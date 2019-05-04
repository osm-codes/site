<!DOCTYPE html>
<html>

<head>

<title>OSM.codes</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- link rel="manifest" href="manifest.json" -->

<link rel="stylesheet" href="assets/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
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
      }); // ONLOAD
</script>

</head>

<body>
<nav class="top" id="topnav1">
  <!-- current top menu -->
  <a href="#_top" class="home"><tt>OSM.codes</tt></a>

  <a href="#_what" title="O que são os códigos">O que</a>
  <a href="#_who" title="Quem somos">Quem</a>
  <a href="#_status" title="Situação dos países filiados">Situação</a>
  <a href="#_how" title="Como funciona e como a comunidade do seu país pode participar">Como</a>

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
  <h1>Um portal para todos os geocódigos,
    <br/>incluindo códigos de localização que as pessoas possam lembrar de cor
  </h1>
</header>


<article>
<!-- lead section -->
<p>Todo país é soberano, e deveria ser o dono de seus geocódigos. Ajude seu país e sua comunidade a serem donos do <tt>OSM.codes</tt>.</p>

<p>Nosso objetivo: que os <tt>OSM.codes</tt> sejam <b>realmente <a rel="external" href="https://index.okfn.org/dataset/postcodes/" target="_blank">livres e abertos</a></b> e de propriedade das jurisdições e suas comunidades,
  para qualquer um usar, para sempre.</p>

<section id="_what">
<h3>Nossos geocódigos</h3>
<p>No <tt>OSM.codes</tt> estão sendo reunidos serviços de longa duração para ambos,
 tecnologias de uso geral e soluções oficiais adotadas por países que estão substituindo o
 <a rel="help" href="https://pt.wikipedia.org/wiki/C%C3%B3digo_postal" target="_blank">código postal</a> tradicional
 por um <i>código postal de granularidade mais fina</i>, que é o <i>geocódigo oficial do país</i>.
</p>
<p>O geocódigo substitui as coordenadas geográficas usuais, que na Internet são
  expressas na forma <code>geo:latitude,longititude</code>
  do <a href="https://tools.ietf.org/html/rfc5870" rel="external" target="_blank">padrão Geo URI</a>
  (p. ex. <code>geo:13.4125,103.8667</code>). São compridas e difíceis de lembrar.
</p>
<p>Os <i>geocódigos globais</i>, de uso geral, são soluções tecnológicas para se reduzir o comprimento das
    coordenadas. São soluções abertas,
   reconhecidas pela comunidade OpenStreetMap (OSM), tais como Geohash e OLC (Open Location Code).
   Além disso, os geocódigos informam mais do que as coordenadas, eles também expressam a precisão,
   que é proporcional ao seu número de dígitos.
   Alguns exemplos:
   <table>
   <tr><th>Latitude,Longitude<th>Geocódigo global<th>Opções de resolução do código</tr>
   <tr>
     <td><code>geo:<big>-23,-46</big></code><br/>ponto no Brasil, sem precisão definida</td>
     <td><code>geo:ghs:<big>6gzm1</big></code><br/>Geohash do ponto, uma caixa com ~5&nbsp;km de lado.</td>
     <td>Links para o mapa OSM através das coordenadas
       <a rel="shortlink" href="http://osm.codes/-23,-46">osm.codes/&#8209;23,&#8209;46</a>
       e através do código <a rel="shortlink" href="http://osm.codes/ghs:6gzm1">osm.codes/ghs:6gzm1</a>.
       Serviços de catálogo: para <a href="#">humanos</a>,
       para <a rel="shortlink" href="http://osm.codes/geo:ghs:6gzm1">aplicativos</a>.
     </td>
   </tr>
   <tr>
     <td><code>geo:<big>&#8209;23.55041,&#8209;46.63394</big>;u=8</code><br/>ponto vizinho, com precisão de ~8&nbsp;m.</td>
     <td><code>geo:ghs:<big>6gyf4bf0</big></code><br/>Geohash do ponto, caixa com ~25&nbsp;m de lado.</td>
     <td>Links para o mapa OSM, através das coordenadas
       <a rel="shortlink" href="http://osm.codes/-23.55041,-46.63394">osm.codes/&#8209;23.55041,&#8209;46.63394</a>
       e através do código <a rel="shortlink" href="http://osm.codes/ghs:6gyf4bf0">osm.codes/ghs:6gyf4bf0</a>.
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="#">aplicativos</a>.
     </td>
   </tr>
   <tr>
     <td><code>geo:<big>&#8209;23.55041,&#8209;46.63394</big>;u=6</code><br/>idem, com precisão de ~6&nbsp;m.</td>
     <td><code>geo:olc:<big>588MC9X8+RC</big></code><br/>OLC do ponto, caixa com ~15&nbsp;m de lado.</td>
     <td>Link para o mapa OSM, através do código <a rel="shortlink" href="http://osm.codes/olc:588MC9X8+RC">osm.codes/olc:588MC9X8+RC</a>.
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="#">aplicativos</a>.
     </td>
   </tr>
   </table>
</p>

<p>Os <i>geocódigos locais</i>, de uso oficial ou contextualizado, são códigos compostos de duas partes,
  <br/><i>Prefixo</i>: é a <b>abreviação</b> oficial da região, baseado no padrão  ISO 3166-2, que define o código do país (ex. <code><big>AR</big></code> é Argentina e <code><big>BR</big></code> é Brasil)
  e o código de subdivisão de primeiro nível (ex. <code><big>BR-PA</big></code> é o estado do Pará), ou ainda mais um nível (<code><big>BR-PA-ALT</big></code> é o município de Altamira).
  <br/><i>Sufixo</i>: é um <b>geocódigo local</b>, restrito ao polígono do prefixo, calibrado para fins de <a href="./CLP">Código Localizador de Portão</a>, sendo também flexível para outros fins. <br/>Exemplos:
   <table>
   <tr><th>Geocódigo oficial<th>Geocódigo local<th>Opções de resolução do código</tr>
   <tr>
     <td><code>geo:<big>BR-PA-ATM-19n</big></code><br/>(experimental) localização do Aeroporto de Altamira com precisão de 20&nbsp;m.</td>
     <td><code>geo:.<big>19n</big></code><br/>referência ao mesmo ponto para quem já está em Altamira.</td>
     <td>Link para o mapa OSM através do <i>geocódigo oficial</i>
       <a rel="shortlink" href="http://osm.codes/BR-PA-ATM-19n">osm.codes/BR-PA-ATM-19n</a>.
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="#">aplicativos</a>.
     </td>
   </tr>
   <tr>
     <td><code>geo:<big>BR-68372-590</big></code><br/>(oficial vigente - CEP) localização parcial do aeroporto de Altamira.</td>
     <td>(pendente mapa do CEP e suas regiões)</td>
     <td>Link para o mapa OSM através do CEP, o <i>geocódigo oficial</i> vigente, de baixa resolução:
       <a rel="shortlink" href="http://osm.codes/BR-68372-590">osm.codes/BR-68372-590</a> (nuvem de pontos sem precisão).
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="#">aplicativos</a>.
     </td>
   </tr>
   <tr>
     <td><code>geo:<big>CV-PR-WGW7+49</big></code><br/>(oficial vigente - OLC) localização do Aeroporto de Praia (Cabo Verde) com precisão de 15&nbsp;m.</td>
     <td><code>geo:.<big>WGW7+49</big></code><br/>referência ao mesmo ponto para quem já está em Praia.</td>
     <td>Link para o mapa oficial de Cabo Verde através do <i>geocódigo oficial</i>
       <a rel="shortlink" href="http://osm.codes/CV-PR-WGW7+49">osm.codes/CV-PR-WGW7+49</a>.
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="http://osm.codes/geo:CV-PR-WGW7+49">aplicativos</a>.
     </td>
   </tr>
   <tr>
     <td><code>geo:<big>​IE​-R93.E920</big></code><br/>(oficial vigente - Eircode) ponto na Irlanda.</td>
     <td><code>geo:.<big>R93.E920</big></code><br/>referência ao mesmo ponto para quem já está na Irlanda.</td>
     <td>Link para o mapa OSM: por hora impossível, o código (Eircode​) tem patente e não tem serviço de redirecionamento.
       Serviços de catálogo: para <a href="#">humanos</a>, para <a rel="shortlink" href="#">aplicativos</a>.
     </td>
   </tr>

   </table>
</p>
</section>

<section id="_status">
<h3>Países filiados e situação</h3>
  <table>
  <tr><th>País <th>Regras estáveis <th>Mapas estáveis <th>Jurisdições definidas</tr>
  <tr><td><b>BR</b> - Brasil  <td> <a href="./CLP">em discussão</a> (<a rel="external" href="http://bit.ly/CLP-form1" target="_blank">vote</a>)    <td>pendente       <td>645 municípios de 5570 (~12%) </tr>
  <tr><td><b>CV</b> - Cabo Verde <td> <a rel="external" href="http://www.correios.cv/olc">oficiais</a>, pendente abertura de dados na definição das freguesias <td> pendente      <td> 22 concelhos de 22 (100%) </tr>
  </table>

  <section id="_agenda">
  <h4>Agenda das metas de abril</h4>
  <p>Estamos implementando serviços e redirecionamentos para o <a rel="shortlink" href="http://osm.codes/_foundations/art2.pdf">novo padrão Geo URI</a> (artigo PDF).</p>
  <p>(em teste) Serviços para a jurisdição <tt><b>BR-SP</b></tt>, Estado de São Paulo: <ul>
    <li>Latitude e longitude dentro do estado: <a class="wslink" rel="shortlink" href="http://osm.codes/geo:-23,-46.6">osm.codes/geo:-23,-46.6</a></li>
    <li>Geohash dentro do estado: <a class="wslink" rel="shortlink" href="http://osm.codes/geo:ghs:6gyv5sfz">osm.codes/geo:ghs:6gyv5sfz</a></li>
    <li>OLC dentro do estado: <a class="wslink" rel="shortlink" href="http://olc.osm.codes/-23,-46.6">olc.osm.codes/-23,-46.6</a></li>
  </ul>
  </p>
  <p>(em teste) Serviços para a jurisdição <tt><b>CV</b></tt>, Cabo Verde:  <a href="http://osm.codes/_sql/rpc/latlng_to_official?lat=14.85&lng=-24.7">exemplo</a>.</p>

  <p> Listagem completa das <a href="http://osm.codes/_sql/kx_osmcodes_prefix?select=prefix,name,osm_rel_id,wd_id">jurisdições
     previstas para a primeira etapa de implantação</a>.
  </section>

</section>

<section id="_who">
<h3>Quem somos</h3>
<p>O nome domínio <tt>OSM.codes</tt> é uma concessão de baixo custo,
  podendo ser paga antecipadamente por até 20 anos,
  e tem um custo baixo de manutenção dos seus serviços, previsível<!-- e planejado--> para um horizonte de 5 anos.
  Além disso, <b>o direito de propriedade é coletivo</b>: é uma "vaquinha",
  de custo individual irrisório mas suficiente para que cada um dos co-proprietários,
  representantes oficiais dos países e de grupos locais,
  atestem formalmente a sua participação e os seus direitos.
</p>
<p>Os contratos de propriedade coletiva (condominial) são os mais estáveis, garantidos por lei e por décadas. Somos, enquanto fundadores, um grupo de membros da Comunidade OpenStreetMap.
   Formalmente somos um <a rel="help" href="https://wiki.openstreetmap.org/wiki/OSM.codes" target="_blank">Condomínio Voluntário de Patrimônio Digital</a> em construção.</p>
</section>

<section id="_how">
<h3>Como funciona e como participar</h3>
<p>Todo cidadão pode apoiar o seu país a participar do <tt>OSM.codes</tt>,
  e todo usuário OSM, empresa ou associação local que o comprovar de forma transparente
  e contribuir financeiramente para a sua manutenção. </p>

<p>Em particular os representantes oficiais de um país,
  para assuntos da Infraestrutura Nacional de Dados Espaciais (INDE),
  recebem um assento especial nas assembleias e um termo de direito de propriedade sobre o domínio <tt>OSM.codes</tt>,
  previsto em estatuto por cláusula irrevogável.
  A manutenção de longo prazo é  garantida junto com os demais representantes institucionais que ajudaram a criar e manter os serviços
  a jurisdição do país <tt>OSM.codes</tt> (o código ISO do país nos serviços <tt>OSM.codes</tt>).
</p>
<p>Para países que ainda não fazem parte do <tt>OSM.codes</tt> terem seus códigos oficiais, este é o passo-a-passo:</p>
<ol>
  <li>Consolidar o artigo ISO_3166-2 do seu país na Wikipedia (<a rel="help" href="https://en.wikipedia.org/wiki/ISO_3166-2:CV">exemplo</a>), seus itens na Wikidata e polígonos no OSM. As comunidades Wikidata e OSM podem ajudar, confira os contatos aqui.</li>
  <li>Submeter o pedido como empresa, ONG ou entidade governamental do seu país: na submissão os dados da Wikidata e OSM serão homologados e submetidos à comunidade. O seu pedido é colocado em consulta pública e  processo iniciado.</li>
  <li>Um repositório <i>git</i> <code>stable-${isoCode}</code> (por exemplo <a rel="external" href="https://github.com/osm-codes/stable-BR"><code>stable-BR</code></a>)..
    <li>(se não tem DGG) Processo de escolha da DGG nacional
      <li> processo de confirmação da DGG e do código oficial...
</ol>
</section>
</article>

</main>


<footer>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p>&nbsp;</p><p>&nbsp;</p>
  <h3>Contatos, etc.</h3>
  info@osm.codes gitgub/issues etc.
</footer>

</body>
</html>
