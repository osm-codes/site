<?php
/* CATALOGO*/
$IDX = "index.php?lang=$lang"; // ou index.php?...

if ($q) {
  $msg = "$msg<br/><p>Olá! Estamos construindo uma solução!</p>\n";
  $msg.= "<p>q=$q |  ext=$ext | accept=$acceptText.</p>";
}

//Falta a classe de parse GeoURI em javascript

?>
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
  $(document).ready( ()=> { // ONLOAD

      $('nav .menuIcon').click( ()=> {
          let x = document.getElementById('topnav1');
          x.className = (x.className === 'top')? 'top responsive': 'top'
      })
      $('#chg_lang').click( ()=> {
        //let lang = $(this).text().slice(1,3)
        //let newLang = chgLang(lang)
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
  <a href="<?= $IDX?>#_top" class="home"><tt>OSM.codes</tt></a>

  <a href="<?= $IDX?>#_what" title="O que são os códigos">O que</a>
  <a href="<?= $IDX?>#_who" title="Quem somos">Quem</a>
  <a href="<?= $IDX?>#_status" title="Situação dos países filiados">Situação</a>
  <a href="<?= $IDX?>#_how" title="Como funciona e como a comunidade do seu país pode participar">Como</a>

  <!-- a href="index-dets.php?lang=pt" title="Mais detalhes sobre tudo isso">Detalhes</a -->
  <a href="index-FAQ.php?lang=<?=$lang ?>" title="Perguntas e respostas: simples, objetivas e ilustradas">FAQ</a>

  <a href="javascript:void(0);"  id="chg_lang" title="English version">&nbsp; [en]&nbsp;</a>
  <a href="javascript:void(0);" class="menuIcon">
    <i class="fa fa-bars"></i>
  </a>
</nav>

<main>
<article lang="pt" id="_top">
  <p>Solução de catálogo (em construção)... </p>
  <?php echo $msg; ?>

</article>
</main>

<footer>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p>&nbsp;</p><p>&nbsp;</p>
  <p>&nbsp;</p><p>&nbsp;</p>
  <h3>Contatos</h3>
  info@osm.codes
</footer>

</body>
</html>
