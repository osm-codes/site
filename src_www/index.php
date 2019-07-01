<?php
// CONFIGS:
$PG_CONSTR = 'pgsql:host=localhost;port=5432;dbname=osm_stable_br';
$PG_USER   = 'postgres';
$PG_PW     = 'ff#12345eg';
$msg="";
$acceptText = isset($_GET['accept'])? substr($_GET['accept'],0,4): '';
$q = isset($_GET['q'])? $_GET['q']: '';
$ext = isset($_GET['ext'])? strtolower(trim($_GET['ext'])): '';
if ($ext=='js') $ext='json';
$lang = isset($_GET['lang'])? strtolower(trim($_GET['lang'])): 'pt';

if ($q && $ext!='json' && (!$acceptText || $acceptText=='text')) {
  $msg = "";
  // implementing a draft for resolutions and/or redirections:
  //  http://osm.codes/-25.4297,-49.2719
  //  http://osm.codes/olc:588MC9X8+RC
  //  http://osm.codes/ghs:6gy.f4b.f1

  if (preg_match('/^\s*(\-?\d+(?:\.\d*)?)\s*,\s*(\-?\d+(?:\.\d*)?)\s*$/',$q,$m))
      header("Location: https://www.openstreetmap.org/?mlat={$m[1]}&mlon={$m[2]}&zoom=13");

  elseif (preg_match('/^\s*(?:olc\/|olc:|geo:olc:)([A-Z\d]+[\s\+]?[A-Z\d]+)\s*$/i',$q,$mm)) {
    include('_libOlc.inc.php');
    $mm[1] = str_replace(' ','+',$mm[1]);
    $c = OpenLocationCode::decode($mm[1]);
    // or calculate by formula, https://gis.stackexchange.com/a/59133/7505
    //ST_MakeEnvelope( xmin,  ymin,  xmax, ymax, 4326) = minLon, minLat, maxLon, maxLat
    $dbh = new PDO($PG_CONSTR, $PG_USER, $PG_PW);
    $qa= $dbh->query("SELECT st_area(
         ST_MakeEnvelope($c[longitudeLo], $c[latitudeLo], $c[longitudeHi], $c[latitudeHi], 4326)
        ,true) a
    ");
    list($area,$size) = area_size_format( $qa->fetchColumn() );

    $params = "mlat={$c['latitudeCenter']}&mlon={$c['longitudeCenter']}";
    $urlOsm = "https://www.openstreetmap.org/?$params&zoom=13";
    $urlNom = "https://nominatim.openstreetmap.org/reverse?lat={$c['latitudeCenter']}&lon={$c['longitudeCenter']}&format=json";
    $q='';
    $msg = "<p>O geocódigo OLC <b>$mm[1]</b> corresponde ao ponto <code>geo:{$c['latitudeCenter']},{$c['longitudeCenter']}</code> com área de $area (lado $size).</p>";
    $msg .= "<p><a href='$urlOsm'>Mapa OpenStreetMap do ponto</a></p>";
    $msg .= "<p><a href='$urlNom'>Endereço mais próximo pelo Nominatim</a></p>";
    include ("_catalog.inc.php");
    exit;
    //header("Location: https://www.openstreetmap.org/?$params&zoom=13");

  } elseif (preg_match('/^\s*(?:ghs\/|ghs:|geo:ghs:)([A-Z\d][A-Z\d\.]+)\s*$/i',$q,$mm)) {
    //include('_libGeohash.inc.php');
    //$g = new Geohash();
    //$c = $g->decode($mm[1]);
    $strGeohash = strtolower( str_replace('.','',$mm[1]) );
    $sql = "
      SELECT area, st_y(ct) lat, ST_X(ct) lon
      FROM (
        SELECT st_area(geom,true) area, st_centroid(geom) ct
        FROM (
          SELECT ST_SetSRID(ST_GeomFromGeoHash('$strGeohash'),4326)
        ) t(geom)
      ) t2
    ";
    $dbh = new PDO($PG_CONSTR, $PG_USER, $PG_PW);
    $qa= $dbh->query($sql);
    $c = $qa->fetch(PDO::FETCH_ASSOC); //fetchColumn();
    list($area,$size) = area_size_format( $c['area'] );
    $params = "mlat={$c['lat']}&mlon={$c['lon']}";
    $urlOsm = "https://www.openstreetmap.org/?$params&zoom=13";
    $urlNom = "https://nominatim.openstreetmap.org/reverse?lat={$c['lat']}&lon={$c['lon']}&format=json";
    $q='';
    list($cLat,$cLon) = [round($c['lat']*1000000)/1000000,round($c['lon']*1000000)/1000000];
    $msg = "<p>O (geocódigo) Geohash <b>$strGeohash</b> ({$_SERVER['QUERY_STRING']}) corresponde ao ponto <code>geo:{$cLat},{$cLon}</code> com área de $area (lado $size).</p>";
    $msg .= "<p><a href='$urlOsm'>Mapa OpenStreetMap do ponto</a></p>";
    $msg .= "<p><a href='$urlNom'>Endereço mais próximo pelo Nominatim</a></p>";
    include ("_catalog.inc.php");
    exit;
    //header("Location: https://www.openstreetmap.org/?mlat={$c[0]}&mlon={$c[1]}&zoom=13");

  } elseif (preg_match('/^\s*(BR)\-(\d[\d\-\.]+)\s*$/i',$q,$mm)) {
    $countryCode = $mm[1]; // BR
    $geocode = preg_replace('/[^\d]+/', '', $mm[2]); //CEP!
    // CONFIGS:
     $cepResolver = 'http://api.postmon.com.br/v1/cep';
    $urlGet = "$cepResolver/$geocode";
    $strJ = file_get_contents($urlGet);
    $j = json_decode($strJ,true);
    if ($j) {
      $ret= [];
      foreach($j as $k=>$v) if ($k!='estado_info' && $k!='cidade_info') $ret[] = "<li><b>$k</b>: <span>$v</span></li>";
      $msg = "<ul>". implode("\n",$ret) ."</ul>";
    } else $msg = '(pau no get CEP)';
    include ("_catalog.inc.php");
    exit;

  } elseif (preg_match('/^\s*([a-z][a-z]\-[a-z][a-z][a-z]?\-[a-z][a-z]+|[a-z][a-z]\-[a-z][a-z][a-z]?|[a-z][a-z])\-([^\-\/]*)\s*$/i',$q,$mm)) {
    $prefix = $mm[1];
    $suffix = $mm[2];
    $dbh = new PDO($PG_CONSTR, $PG_USER, $PG_PW);
    $sth = $dbh->prepare('
      SELECT wd_id,osm_rel_id,name,encode_std,cover_bound
      FROM kx_osmcodes_prefix  WHERE prefix=?
      LIMIT 1
    ');
    $sth->bindParam(1,$prefix, PDO::PARAM_STR);
    $sth->execute();
    $r = $sth->fetch(); //$sth->fetchColumn();
    //var_dump($r); ... $r["wd_id"], $r["osm_rel_id"]
    //$r["encode_std"]=="olc";
    if ($r["encode_std"]=='olc') {
      $codePrefix = substr(trim($r["cover_bound"],'{}'),0,4);
      $suffix = str_replace(' ','+',$suffix);
      $code = $codePrefix.$suffix;
      // die("\n{}| q=$q | pref=$prefix | $codePrefix and su=$suffix");
      include('_libOlc.inc.php');
      $c = OpenLocationCode::decode($code);
      $params = "mlat={$c['latitudeCenter']}&mlon={$c['longitudeCenter']}";
      header("Location: https://www.openstreetmap.org/?$params&zoom=13");
      exit;
      //$msg = "Código OLC '$code' é geo:{$c['latitudeCenter']},{$c['longitudeCenter']}"; echo "$msg";
    }
    include ("_catalog.inc.php");
    exit;

  } else {
    include ("_catalog.inc.php");
    exit;
  }
} elseif ($q) {
  header("Location: http://osm.codes/geo:{$q}");
  exit;
}
include('_content-pt.inc.php');

// // local LIB

function area_size_format($area0) {
  if  ($area0<9000) {
    if ($area0<10){
      $area = round($area0*100)/100;
      $size = round(sqrt($area0)*100)/100;
    } else {
      $area = round($area0);
      $size = round(sqrt($area0)*10)/10;
    }
    return ["$area m²","$size m"];
  } else {
    $area = round($area0/100000)/10;
    $size = round(sqrt($area)*10)/10;
    return ["$area km²","$size km"];
  }
}

?>
