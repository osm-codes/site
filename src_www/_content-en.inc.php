<!DOCTYPE html>
<html>

<head>

<title>OSM.codes</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- link rel="manifest" href="manifest.json" -->

<link rel="stylesheet" href="assets/jquery.wizzy.css">
<link rel="stylesheet" href="assets/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="assets/demo_home.js"></script>
<script>
$(document).ready(function(){ // ONLOAD
    $('nav .menuIcon').click(function () {
        let x = document.getElementById('topnav1');
        x.className = (x.className === 'top')? 'top responsive': 'top'
    })
    $('#chg_lang').click(function () {
      if ( confirm("Mudando língua para inglês, confirme!\n\nChanging language to English, confirm!") )
       location.href="index.php?lang=en"
      //$(this).text('['+newLang+']').prop('title','nov tit')
    })
    setPt();
    $('#selStd_rd input, #selGlob-tec, #selPt, #selRes').change( function () {setPt();} );
}); // ONLOAD
</script>
</head>

<body>
<nav class="top" id="topnav1">
  <!-- current top menu -->
  <a href="index.php" class="home"><tt>OSM.codes</tt></a>

  <a href="index-FAQ.php#_what" title="O que são os códigos">O que</a>
  <a href="index-FAQ.php#_who" title="Quem somos">Quem</a>
  <a href="index-FAQ.php#_status" title="Situação dos países filiados">Situação</a>
  <a href="index-FAQ.php#_how" title="Como funciona e como a comunidade do seu país pode participar">Como</a>

  <!-- a href="index-dets.php?lang=pt" title="Mais detalhes sobre tudo isso">Detalhes</a -->
  <a href="index-CAT.php?lang=pt" title="Catálogo de dados sobre os códigos">Catálogo</a>
  <a href="index-FAQ.php?lang=pt" title="Perguntas e respostas: simples, objetivas e ilustradas">FAQ</a>

  <a href="javascript:void(0);"  id="chg_lang" title="English version">&nbsp; [en]&nbsp;</a>
  <a href="javascript:void(0);" class="menuIcon">
    <i class="fa fa-bars"></i>
  </a>
</nav>
<?php
if ($msg) echo "<p>$msg</p>";
?>

<main lang="pt-BR" id="_top">

<header>
  <h1>One portal for all geocodes, official and general purpose</h1>
</header>

<article>
  <p>The database of postal codes of a country is a resource for all citizens and should be available for the whole country, but <a href="https://index.okfn.org/dataset/postcodes">only ~8% of all countries</a> offer their postal code database under Open License. It would be good too, that modern postal codes have corresponding spatial locations in terms of latitude and longitude, but this the case only for Cabo Verde (CV), Ireland (IE) and other few countries, where the official hierarchical grid of the country was standardized, so that it was possible to implement a fine-grained postal code.</p>
  <p>There are many technological options to implement an official hierarchical grid of the country, such as Geohash, OLC (Open Location Code), or any other more sophisticated grid framework that complies with the <a href="http://docs.opengeospatial.org/as/15-104r5/15-104r5.html">DGGS standard of 2017</a> (Discrete Global Grid Systems of the Open Geospatial Consortium). When a country elects a standard grid and elects a standard way to identify each cell of the grid with a standard human-readable short symbol, this symbol can be considered the official geocode of the country, and can be adopted also as postal code. In that case, “official postal code” and “official geocode” are synonyms.</p>
  <p><strong>Every country is sovereign in choosing a <a href="https://en.wikipedia.org/wiki/Discrete_global_grid">hierarchical grid</a> for its <a href="https://en.wikipedia.org/wiki/National_spatial_data_infrastructure">National spatial data infrastructure</a></strong>, as well as in the choice of its geocodes. It is a problem of property rights, and the <a href="http://osm.codes"><tt>OSM.codes</tt></a> initiative emerged to help each country and its community to own their geocode, offering services and databases for free and “forever” (decades) for its citizens and any other user. Mainly poor countries and countries with territories of minor area.</p>
  <p>OSM user community and OSM’s applications (APPs) need a complete and reliable API to resolve geocodes. In view of providing long-term services, the <tt>OSM.codes</tt> initiative also established an <a href="http://osm.codes/_foundations/art2.pdf">extension to the standard Geo URI for geocodes</a>, as a foundation for its API.</p>

  <h2 id="the-redirection-services">The Redirection services</h2>
  <p>The <tt>OSM.codes</tt> portal is focused on long-term <a href="https://en.wikipedia.org/wiki/HTTP_303">redirection services</a>, like <a href="https://en.wikipedia.org/wiki/Persistent_uniform_resource_locator">PURL</a> or <a href="https://www.doi.org/">DOI.org</a> standard, where a short domain name is used to redirect the official identification to its correct web page. The automatic redirections are triggered by the URL syntax:</p>
  <ul>
  <li>Official geocodes: codes starting by the country code, for example “BR” for Brazil or “CV” for Cape Verde. Example: “osm.codes/CV-PR-WF8R+V7” will redirect to the correct point at “openStreetMap.org” online map. The country code is used as key in the database to decide how to interpret the remaining code (“-PR-WF8R+V7”). In this case, the ISO 3166-2 local code, “PR”, followed by an OLC suffix geocode “WF8R+V7”.</li>
  <li>Global geocodes: codes starting with a geocode technology label, followed by “:” and the proper geocode. For example “olc:796RWF8R+V7” is a global <a href="https://en.wikipedia.org/wiki/Open_Location_Code">Open Location Code</a>, and “ghs:e6xkc594” is a global <a href="https://en.wikipedia.org/wiki/Geohash">Geohash</a> to the same point.</li>
  <li>Canditate (to official) geocodes: to support countries where there is no official geocode or official grid yet, the community can test different geocodes, in order to best define what will be the “official geocode” in the future.</li>
  </ul>

  <h2 id="the-catalog-services">The Catalog services</h2>
  <p>Another important service is the catalog. Instead of redirecting, the API returns a page or a JSON dataset with all metadata about the requested geocode.</p>
  <h2 id="innovations">Innovations</h2>
  <p>During the discussion and adaptation process of <tt>OSM.codes</tt> we developed some innovative elements:</p>
  <ul>
  <li><p>A solution for the use of the <a href="http://s2geometry.io">S2 Geometry</a> cell-keys as geocodes, expressing bit strings in base32, as described in <a href="http://osm.codes/_foundations/art3.pdf">this preprint article</a>. We created the concept of “Generalized Geohashes”.</p></li>
  <li><p>After discussions within the OSM community, as in <a href="https://github.com/openstreetmap/openstreetmap-website/issues/1807">this case</a>, we realized the need to deal with <strong>long-term property rights</strong> and <strong>contractual guarantees</strong>. We have come to a contractual arrangement that solves the problem. It consists primarily in the use of the <strong>legal figure of the “condominium”</strong>: the owner of OSM-codes is a <em>collective ownership</em> focused only on maintaining the assets.</p></li>
  </ul>

  <h2 id="first-official-use">First official use</h2>
  <p>
    The <tt>OSM.codes</tt> project was chosen in Brazil by the government project called “RORAIS” rural routes.
    The project aims to define addresses for the rural areas of the state of São Paulo,
    in such a way that police and firefighters define their paths without problems.
  </p>
</article>

</main>


<footer>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p align="center"><b>Contato</b>: <a href="https://github.com/osm-codes/spec/issues">github.com/osm-codes/spec/issues</a></p>
  <p>&nbsp;</p><p>&nbsp;</p>
</footer>
<script src="assets/jquery.wizzy.js"></script>
</body>
</html>
