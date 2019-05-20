<?php
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

    $params = "mlat={$c['latitudeCenter']}&mlon={$c['longitudeCenter']}";
    $urlOsm = "https://www.openstreetmap.org/?$params&zoom=13";
    $urlNom = "https://nominatim.openstreetmap.org/reverse?lat={$c['latitudeCenter']}&lon={$c['longitudeCenter']}&format=json";
    $q='';
    $msg = "<p>O geocódigo OLC <b>$mm[1]</b> corresponde ao ponto <coode>geo:{$c['latitudeCenter']},{$c['longitudeCenter']}</code></p>";
    $msg .= "<p><a href='$urlOsm'>Mapa OpenStreetMap do ponto</a></p>";
    $msg .= "<p><a href='$urlNom'>Endereço mais próximo pelo Nominatim</a></p>";
    include ("_catalog.inc.php");
    exit;
    //header("Location: https://www.openstreetmap.org/?$params&zoom=13");

  } elseif (preg_match('/^\s*(?:ghs\/|ghs:|geo:ghs:)([A-Z\d][A-Z\d\.]+)\s*$/i',$q,$mm)) {
    include('_libGeohash.inc.php');
    $mm[1] = str_replace('.','',$mm[1]);
    $g = new Geohash();
    $c = $g->decode($mm[1]);

    $params = "mlat={$c[0]}&mlon={$c[1]}";
    $urlOsm = "https://www.openstreetmap.org/?$params&zoom=13";
    $urlNom = "https://nominatim.openstreetmap.org/reverse?lat={$c[0]}&lon={$c[1]}&format=json";
    $q='';
    $msg = "<p>O (geocódigo) Geohash <b>$mm[1]</b> corresponde ao ponto <coode>geo:{$c[0]},{$c[1]}</code></p>";
    $msg .= "<p><a href='$urlOsm'>Mapa OpenStreetMap do ponto</a></p>";
    $msg .= "<p><a href='$urlNom'>Endereço mais próximo pelo Nominatim</a></p>";
    include ("_catalog.inc.php");
    exit;
    //header("Location: https://www.openstreetmap.org/?mlat={$c[0]}&mlon={$c[1]}&zoom=13");

  } elseif (preg_match('/^\s*([a-z][a-z]\-[a-z][a-z][a-z]?\-[a-z][a-z]+|[a-z][a-z]\-[a-z][a-z][a-z]?|[a-z][a-z])\-([^\-\/]*)\s*$/i',$q,$mm)) {
    $prefix = $mm[1];
    $suffix = $mm[2];
    // CONFIGS:
    $PG_CONSTR = 'pgsql:host=localhost;port=5432;dbname=osm_stable_br';
    $PG_USER   = 'postgres';
    $PG_PW     = 'ff#12345eg';
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
?>
