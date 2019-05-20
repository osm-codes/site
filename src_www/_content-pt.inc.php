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
  <h1>Um portal para todos os geocódigos,
    oficiais e de uso geral
  </h1>
</header>
<article>
  <p>Experimente: &nbsp;&nbsp;<input type="text" size="25" id="build_val" placeholder="geocódigo"/>
      <select id="build_type">
        <option value="redir">Mapa com o ponto</option>
        <option value="cat">Catálogo para humanos</option>
        <option value="catjson">Catálogo para máquinas (JSON)</option>
        <option value="catnom">Busca de ponto próximo (Nominatim)</option>
      </select>
      &nbsp;
      <button onclick="go_link()">Ir</button><!-- ou
      <button onclick="copyToClip('build_val','cpval_buildLink')">Copiar como link <i class="fa fa-copy"></i></button> -->
      <br/> ou aprenda escolhendo e testando exemplos:
  </p>
  <table>
  <!-- tr><td align="center" colspan="2">Amostra</td></tr -->
  <tr><td>

  <p id="selStd_rd">Escolha o tipo de geocódigo:<br/>
    <label><input type="radio" value="of" name="selStd" checked> <b>Oficial</b> (do país)</label>
    &nbsp;
    <label><input type="radio" value="co" name="selStd"> <b>Candidato</b> a oficial</label>
      &nbsp;
    <label><input type="radio" value="gl" name="selStd"> <b>Global</b> </label>
  </p>

  <p id="gl-opt">Escolha a tecnologia:
    <select id="selGlob-tec">
      <option value="ghs" selected="1">Geohash (classic)</option>
      <option value="ghs-nvu">Geohash NVU (No-Vowels except U)</option>
      <option value="olc">OLC (Open Location Code)</option>
      <option value="cep">CEP (sem tecnologia)</option>
      <!-- option value="s2">S2-geometry</option -->
    </select> <span id="pub_code2"></span>
  </p>

  <p>Escolha um ponto:
    <select id="selPt">
      <option value="1">Prefeitura de Praia (PR), Cabo Verde (CV)</option>
      <option value="2">Aeroporto de Praia (PR), Cabo Verde (CV)</option>
      <option value="3">Portão do MASP, São Paulo (SP/capital), Brasil (BR)</option>
      <option value="4">Aeroporto de Congonhas (SP/capital), Brasil (BR)</option>
      <option value="5">Aeroporto, Altamira (PA), Brasil (BR)</option>
    </select>
    <br/>&nbsp; (<code id="geoCoords">geo:?</code> <button title="Copiar como link para o clipboard" onclick="copyToClip('geoCoords','cptxt_buildLink')"><i class="fa fa-copy"></i></button>)
  </p>

  <p>Escolha a resolução do ponto:
  <select id="selRes">
    <option value="urb">Meio urbano (~3 metros)</option>
    <option value="rur">Meio rural (~15 metros)</option>
    <option value="sem">Sem resolução definida</option>
  </select>
  </p>
  <p>Link para o geocódigo:
    <code><a id="pub_url" rel="shortlink" href="#">?</a></code>
    <button title="Copiar link para o clipboard" onclick="copyToClip('pub_url','href')"><i class="fa fa-copy"></i></button>
    <small id="pub_url_ctx"></small>
  </p>
</td>
<td>Geocódigo<br/>escolhido:
  <br/><code id="pub_code">?</code>
</td>
</tr></table>

<section id="AQUI"></section>
<section id="DETALHES"></section>

</article>

</main>


<footer>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p align="center"><b>Contato</b>: <a href="https://github.com/osm-codes/spec/issues">github.com/osm-codes/spec/issues</a></p>
  <p>&nbsp;</p><p>&nbsp;</p>
</footer>

<!-- # # # # # # # # # # # # # # # # # # # # # -->
<template id="s2res-sem">
  <p>O geocódigo determina um local, mas geocódigos sem resolução definida, como o CEP,
     não permitem determinar o local. O CEP apenas contextualiza o município, distrito ou trecho de rua.
     Na opção "tipo de geocódigo" escolha "candidato a oficial", para entender como seria idealmente
     o comportamento de um código postal eficiente.
  </p>
</template>
<template id="s2res-else">
  <p>Isso significa que o número de dígitos do sufixo do geocódigo é suficiente para
  determinar um ponto que distingue dois portões vizinhos nesta escala.
  </p>
  <p>O geocódigo determina um local, mas conforme o tipo de local a precisão de localização
    será diferente, será preciso "resolver" entre um ponto e seu vizinho.
    <a href="#" rel="help">No <code>OSM.codes</code> foi convencionado</a> que os locais mais importantes são
    os <b>portões</b> (em sentido amplo, de portaria, porteira, porta, acesso ou portal).
    No meio urbano a menor distância entre portões é da ordem de 3 metros, exigindo um geocódigo mais longo.
    No meio rural (ou ainda nos parques e condomínios do meio urbano) é da ordem de 15 metros,
    permitindo o uso de um geocódigo mais curto.
  </p>
</template>

<template id="s2dets">
  <h2>Entendendo os demais detalhes...</h2>
  <p>Você escolheu um geocódigo de resolução "${tr_resolution[resolution]}",
    <br/><img src="http://osm.codes/assets/geocodeResolution-${resolution}.png" align="center"/>
  </p>
  ${resTPL}
</template>

  <!-- templates opcionais -->

  <template id="s1of-CV">
    <h2>Entendendo o geocódigo escolhido, <i>oficial de Cabo Verde</i></h2>
    <p>Em Cabo Verde <a href="https://web.archive.org/web/20170209155133/http://aicep.pt/?/noticias/1/2534">foi adotado oficialmente, a partir de novembro de 2016</a>,
      um novo tipo de código postal,
      que corresponde ao sufixo geocódigo OLC contetualizado pelo local (nomes oficiais de bairro e de município).
      O OLC completo (global) também é aceito. Exemplos de endereçamento postal válido:
      <br/>&nbsp; Código global – 796RWF8Q+WF
      <br/>&nbsp; Código Local – WF8Q+WF Praia, Cabo Verde
    </p>
    <p>
      Transpondo para as <a rel="help" href="http://osm.codes/_foundations/art2.pdf">convenções <tt>OSM.codes</tt></a>,
      a contextualização local é convertida para uma sigla <a rel="external" href="https://en.wikipedia.org/wiki/ISO_3166-2:CV">padrão ​ISO&nbsp;3166-2</a>, aceita mundialmente e fácil de lembrar.
      No exemplo "Cabo Verde, Paria" é convertido
      para a sigla "CV-PR", resultando num código de 10 a 13 caracteres, <code class="osmcode"><span>CV-PR</span>-WF8Q+WF</code>.
      A contextualização se torna parte do código, que resulta ser mais fácil de  lembrar do que o código global.
    </p>
  </template>

  <template id="s1of-BR">
    <h2>Entendendo o geocódigo escolhido, <i>geocódigo oficial do Brasil</i></h2>
    <p>O Brasil, apesar de ter uma <a href="https://www.inde.gov.br/Inde/Apresentacao">INDE (Infraestrutura Nacional de Dados Espaciais)</a>,
      não elegeu a sua <a href="https://en.wikipedia.org/wiki/Discrete_global_grid">grade nacional</a>.
      A única grade hierarquica padronizada para todo o território nacional é o CEP, ou seja, o código postal brasileiro.
    </p>
  </template>

  <template id="s1co-BR">
    <h2>Entendendo o <i>candidato a geocódigo do Brasil</i></h2>
    <p>A <a rel="help" href="http://osm.codes/CLP/">proposta de Código Localizador de Portão</a> (CLP)
      iniciou como estudos de viabilidade e consulta pública sobre o assunto em 2018,
      tendo evoluido para testes-piloto e se integrado à iniciativa do <tt>OSM.codes</tt> em 2019.
    </p>
    <p>Durante a fase de triagem técnica foram selecionadas duas tecnologias,
      o Geohash-NVU e uma adaptação da tecnologia <a href="http://s2geometry.io/">S2 Geometry</a>,
        para representar também em base32-nvu.
   </p>
   <p>A proposta é de fomentar um grade de referência para a INDE e eventualmente <a rel="help" href="http://osm.codes/_foundations/BR-CEP-manifesto2019.pdf">substituir o CEP caso a agência de Correios venha ser privatizada</a>.</p>
  </template>

  <template id="s1ghs">
    <h2>Entendendo o <i>Geohash global</i></h2>
    <p>O <a href="https://en.wikipedia.org/wiki/Geohash">Geohash</a> foi proposto em 2010
      e se manteve desde então o principal geocódigo de licença livre.
      O <i>valor Geohash</i> pode ser expresso em binário, e, para ser expresso como geocódigo padronizado,
      foi convencionado o uso da base32 com um albeto próprio (0-9 e letras minúsculas de "b" até "y" sem "i", "l" nem "o").
    </p>
    <p>O geocódigo Geohash é matematicamente o entrelaçamento entre os dígitos binários das coordenadas de latitude e longitude,
      de modo que a sua representação espacial forma uma hierarquia de células grandes até o tamanho de célula que se queira.
      Por isso Geohashes com mesmo prefixo correspondem a pontos dentro de uma mesma localidade, dada pelo Geohash do prefixo.
    </p>
  </template>

  <template id="s1ghs-nvu">
    <h2>Entendendo o <i>Geohash-NVU global</i></h2>
    <p>Baseado no <a href="https://en.wikipedia.org/wiki/Geohash">Geohash</a>, difere apenas na
      representação final, onde o alfabeto de letras minúsculas foi trocado por um alfabeto
      de letras maiúsculas sem as vogais, exceto o "U" (daí a sigla NVU - do inglês "No-Vowels except U").
    </p>
    <p>O alfabeto NVU é interessante para geocódigos em países de língua latina, principalmente Português e Espanhol,
      onde a maior parte das palavras do dicionário requer vogal, e o uso da vogal "u" é menos frequente.
      Isso evita confusão entre o geocódigo e palavras comuns.
  </template>

  <template id="s1olc">
    <h2>Entendendo o <i>OLC global</i></h2>
    <p>O <a href="https://en.wikipedia.org/wiki/Open_Location_Code">padrão de geocódigo OLC</a>  (do inglês "​Open Location Code​") surgiu em 2014,
      sendo logo em seguida adotado pela Google no seu site <tt>Plus.codes</tt>.
      Em 2016 foi adotado pelos Correios de Cabo Verde.
    </p>
  </template>
</template>

</body>
</html>
