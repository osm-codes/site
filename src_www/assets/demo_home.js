
// CONFIG SAMPLE SET:
const coordinates = [
  "14.9171875,-23.5093125", // prefeitura CV
  "14.944268,-23.487588", // aeroporto CV
  "-23.561618,-46.655996", // MASP BR-SP-SP, cep 01310-200
  "-23.625098,-46.661315",  // Congonhas
  "-3.253526,-52.249368"  // aeroporto Altamira BR-PA-ALT
];
const tr_oficialTech = {"of-CV":"olc", "of-BR":"cep", "co-BR":"ghs-nvu"};
const tr_oficialTech2 = {"of-CV":"OLC", "of-BR":"CEP", "co-BR":"Geohash NVU"};
const tr_altTitle = { // Geocódigo Oficial
  "of-CV":"Geocódigo oficial de Cabo Verde",
  "of-BR":"Geocódigo oficial do Brasil",
  "co-BR":"Candidato a geocódigo do Brasil",
  "ghs":"Geohash global",
  "ghs-nvu":"Geohash-NVU global",
  "olc":"OLC global"
};
const tr_resolution = {"rur":"rural", "urb":"urbano", "sem":"sem resolução"};
const tr_prefixRgx = /^(CV\-[A-Z]+|BR\-[A-Z]+\-[A-Z]+|BR)\-(.+)$/;
const geocodes = {
  "p1of~urb": "CV-PR-WF8R+V7", // prefeitura CV
  "p1gl-ghs~urb": "ghs:e6xkc594c",
  "p1gl-ghs-nvu~urb": "ghs-nvu:F6X.LC5.94C",
  "p1gl-olc~urb": "olc:796RWF8R+V7",
  "p1of~rur": "CV-PR-WF8R+V",
  "p1gl-ghs~rur": "ghs:e6xkc594",
  "p1gl-ghs-nvu~rur": "ghs-nvu:F6X.LC5.94",
  "p1gl-olc~rur": "olc:796RWF8R+V",

  "p2of~urb": "CV-PR-WGV6+PX", // aeroporto CV
  "p2gl-ghs~urb": "ghs:e6xm188bg",
  "p2gl-ghs-nvu~urb": "ghs-nvu:F6X.M18.8BF",
  "p2gl-olc~urb": "olc:796RWGV6+PX",
  "p2of~rur": "CV-PR-WGV6+P",
  "p2gl-ghs~rur": "ghs:e6xm188b",
  "p2gl-ghs-nvu~rur": "ghs-nvu:F6X.M18.8B",
  "p2gl-olc~rur": "olc:796RWGV6+P",

  "p3co~urb": "BR-SP-SPA-dqdpt",  // MASP BR-SP-SP
  "p3of~sem": "BR-01310-200",  //cep
  "p3gl-ghs~urb": "ghs:6gycfqdps",
  "p3gl-ghs-nvu~urb": "ghs-nvu:6HY.CGQ.DPS",
  "p3gl-olc~urb": "olc:588MC8QV+9J",
  "p3co~rur": "BR-SP-SPA-dqdp",
  "p3gl-ghs~rur": "ghs:6gycfqdp",
  "p3gl-ghs-nvu~rur": "ghs-nvu:6HY.CGQ.DP",
  "p3gl-olc~rur": "olc:588MC8QV+9",

  "p4co~urb": "BR-SP-SPA-D5N.MC",  //Congonhas
  "p4co~rur": "BR-SP-SPA-d5n.m",
  "p4of~sem": "BR-04626-911",
  "p4gl-ghs~urb": "ghs:6gycd5nmb",
  "p4gl-ghs-nvu~urb": "ghs-nvu:6HY.CD5.NMB",
  "p4gl-olc~urb": "olc:588M98FQ+XF",
  "p4gl-ghs~rur": "ghs:6gycd5nm",
  "p4gl-ghs-nvu~rur": "ghs-nvu:6HY.CD5.NM",
  "p4gl-olc~rur": "olc:588M98FQ+X",

  "p5co~urb": "BR-PA-ATM-19N.V",  // aeroporto Altamira BR-PA-ALT
  "p5co~rur": "BR-PA-ATM-19N",
  "p5of~sem": "BR-68371-970",  //  cep
  "p5gl-ghs~urb": "ghs:6z6v7p9nv",
  "p5gl-ghs-nvu~urb": "ghs-nvu:6Z6.V7P.9NV",
  "p5gl-olc~urb": "olc:6889PQW2+H7",
  "p5gl-ghs~rur": "ghs:6z6v7p9n",
  "p5gl-ghs-nvu~rur": "ghs-nvu:6Z6.V7P.9N",
  "p5gl-olc~rur": "olc:6889PQW2+H"
};

function setPt() {
  let pt = $('#selPt').val();
  let pt_idx = Number(pt)-1;

  let c = coordinates[pt_idx];
  if (c) $('#geoCoords').text('geo:'+c);
  else console.log("ERROR2 on pt="+pt);

  let std = $('#selStd_rd input:checked').val();
  if (pt_idx<2 && std=='co') {
    std='of';
    $("#selStd_rd input[value='of']").prop("checked",true);
    alert("Neste país não há 'geocódigo candidato' em discussão,\n usando o oficial.");
  }
  let std0=std;
  let glTec = ''
  if (std0=='gl') {
    //$('#gl-opt').show()
    $('#selGlob-tec').prop('disabled',false);
    glTec = $('#selGlob-tec').val()
    if (glTec=='cep'){
      alert("CEP não é global")
      glTec ='ghs-nvu'; $('#selGlob-tec').val(glTec)
    }
    std += '-' + glTec
  } else $('#selGlob-tec').prop('disabled',std0=='of');
   //else   $('#gl-opt').hide();

  let resolution = $('#selRes').val()
  //console.log("debug:",pt_idx,std0, glTec,resolution,)
  if ((pt_idx<2 || std!='of') && resolution=='sem') {
    resolution='rur'
    $('#selRes').val(resolution);
    alert("Com este tipo de geocódigo\na resolução ('rural' ou 'urbana')\nprecisa ser escolhida.");
  } else if (pt_idx>1 && std=='of' && resolution!='sem') {
    resolution='sem'
    $('#selRes').val(resolution);
    alert("O padrão CEP é grosseiro, não tem resolução definida.");
  }

  let k = 'p'+pt+ std+'~'+resolution;
  let g = geocodes[k];
  let tec = ''
  let ctx = ''
  let tit = ''
  let aux = ''
  //let gsuffix = ''
  if (std0!='gl') {
    aux = std0+'-'+g.slice(0,2)
    tec = tr_oficialTech[aux]
    $('#selGlob-tec').val(tec) // set to correct
    tit = tr_altTitle[aux]
    let m = tr_prefixRgx.exec(g)
    //gsuffix = m[2]
    ctx = `<br/>&nbsp; (se você está em <b>${m[1]}</b> pode usar <code>OSM.codes/.${m[2]}</code>)`
  } else{
    aux = glTec
    tit = tr_altTitle[glTec]
  }
  let resTPL = $('#'+((resolution=='sem')? 's2res-sem': 's2res-else')).html()
  if (g) {
    if (aux) replaceSection('s1'+aux);
    //$('#pub_code2').html(tec? ' + ISO 3166-2:BR': '')
    $('#pub_code').html( g.replace(/^[^:]+:/,'') )
    $('#pub_url').html(`OSM.codes/${g}`)
    $('#pub_url').prop('href',`http://OSM.codes/${g}`)
    $('#pub_url_ctx').html(ctx)
    $('#DETALHES').html(
      eval('`'+  $('#s2dets').html()  +'`')
    ); //ugly, but... see https://stackoverflow.com/a/29182787/287948

  } else {
    //$('#tit2').html(`erro ...`)
    $('#pub_code').html("??");
    $('#pub_url').html("OSM.codes/?");
    $('#pub_url_ctx').html('');
    alert("ERROR: \ngeocode "+k+" not found.")
  }
}

/////////////

function copyStringToClipboard (str) {
   var el = document.createElement('textarea');
   el.value = str;
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   el.select();
   document.execCommand('copy');
   document.body.removeChild(el);
}

function copyToClip(domID,task) {
  let isCpTxt = (task=='cptxt_buildLink')
  if (task=='cpval_buildLink' || isCpTxt) {
    let copyText = isCpTxt? $('#'+domID).text().trim(): $('#'+domID).val().trim()
    if (copyText)
      copyStringToClipboard('http://osm.codes/'+copyText);
    else alert("Nothing to copy into clipboard.");
  } else if (task=='href') {
    let copyText = $('#'+domID).prop('href');
    copyStringToClipboard(copyText);
  } else alert("BUG2")
}

function replaceSection(idTagTemplate,idToReplace='AQUI') {
    $('#'+idToReplace).html(
      $('#'+idTagTemplate).html()
    )
}

function go_link(){
  let gc = $('#build_val').val()
  let gt = $('#build_type').val()
  if (gt=='redir')
    window.location.href = 'http://osm.codes/'+gc
  else alert("under construction")
}
