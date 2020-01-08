<?php
//&refine.diplome_rgp=Master&refine.reg_etab=R11&refine.dep_etab=D010
$string = "";
  if(isset($_GET['diplome_rgp'])){
    if($_GET['diplome_rgp'] != ""){
    $string .= "&refine.diplome_rgp=";
    $string .= $_GET['diplome_rgp'];
  }
}
  if(isset($_GET['reg_etab'])){
    if($_GET['reg_etab'] != ""){
    $string .= "&refine.reg_etab=";
    $string .= $_GET['reg_etab'];
  }}
  if(isset($_GET['dep_etab'])){
    if($_GET['dep_etab'] != ""){
    $string .= "&refine.dep_etab=";
    $string .= $_GET['dep_etab'];
  }
}


//Formations
$json = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=com_etab&facet=com_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=diplome_rgp&refine.rentree_lib=2017-18');
$obj = json_decode($json, true);
$arrayFormation = $obj['facet_groups'][9]['facets'];


//Régions
$tempoId     = $obj['facet_groups'][7]['facets'];
$tempoId2    = array();
$tempoValue  = $obj['facet_groups'][3]['facets'];
$tempoValue2 = array();
foreach ($tempoId as $value) {
    array_push($tempoId2, $value['name']);
}
foreach ($tempoValue as $value) {
    array_push($tempoValue2, $value['name']);
}
$arrayRegion = array_combine($tempoId2, $tempoValue2);



//Departement
$tempoId     = $obj['facet_groups'][1]['facets'];
$tempoId2    = array();
$tempoValue  = $obj['facet_groups'][5]['facets'];
$tempoValue2 = array();
foreach ($tempoId as $value) {
    array_push($tempoId2, $value['name']);
}
foreach ($tempoValue as $value) {
    array_push($tempoValue2, $value['name']);
}
$arrayDep = array_combine($tempoId2, $tempoValue2);

asort($arrayRegion);
asort($arrayDep);
asort($arrayFormation);

//Liste Etablissement
$json           = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&rows=0&facet=etablissement&facet=etablissement_lib&refine.rentree_lib=2017-18'.$string);
$obj            = json_decode($json, true)['facet_groups'];
$arrayPoint = array();

$tempoId     = $obj[2]['facets'];
$tempoId2    = array();
$tempoValue  = $obj[0]['facets'];
$tempoValue2 = array();
foreach ($obj as $value) {
if($value['name']=='etablissement'){
$tempoId = $value['facets'];
}
if($value['name']=='etablissement_lib'){
$tempoValue = $value['facets'];
}
}
foreach ($tempoId as $value) {
    array_push($tempoId2, $value['name']);
}
foreach ($tempoValue as $value) {
    array_push($tempoValue2, $value['name']);
}
$arrayPoint = array_combine($tempoId2, $tempoValue2);

//Liste localisation Etablissement
$json           = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&rows=-1');
$obj            = json_decode($json, true)['records'];
$arrayEtablisement = array();
foreach ($obj as $value) {
  if(isset($value['fields']['coordonnees'])&&isset($value['fields']['uai'])&&isset($value['fields']['uo_lib'])&&isset($value['fields']['url'])&&isset($value['fields']['uucr_nom'])&&isset($value['fields']['code_postal_uai'])&&isset($value['fields']['adresse_uai'])&&isset($value['fields']['code_postal_uai'])){
    $uai = $value['fields']['uai'];
    $uo_lib=$value['fields']['uo_lib'];
    $url=$value['fields']['url'];
    $uucr_nom=$value['fields']['uucr_nom'];
    $code_postal_uai=$value['fields']['code_postal_uai'];
    $adresse_uai=$value['fields']['adresse_uai'];
    $coordonnees = $value['fields']['coordonnees'];
    $arrayEtablisement[$uai] = array( "uai" => $uai,"uo_lib" => $uo_lib,"url" => $url,"uucr_nom" => $uucr_nom,"code_postal_uai" => $code_postal_uai,"adresse_uai" => $adresse_uai,"coordonnees" => $coordonnees );

  }
}

$arrayEtablisement = array_intersect_key($arrayEtablisement,$arrayPoint);
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Portail de la formation</title>
    <link rel="stylesheet" href="style/style2.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="./js/script.js">
    </script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <link rel="stylesheet" href="./lib/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css" />
  	<link rel="stylesheet" href="./lib/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css" />
  	<script src="./lib/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>
</head>

<body>
    <!--  NavBar -->
    <div class="navBar">
        <div onclick="location.href='./index.php';" class="navBarItemLeft">
            <img class="navBarLogo" src="./images/logo.png" alt="logo">
        </div>

        <div class="navBarTitle">
            Formations
        </div>

        <div class="searchDiv">
            <form action="./queryResult.php" method="get" class="">
                <input class="searchField" type="text" name="query" id="name" placeholder="Rechercher" required>
                <input class="searchButton" type="submit" value="m">
            </form>
        </div>
    </div>

    <!-- content  -->
    <div class="content">
        <!--  filter  -->
        <div class="filterButton" id="filterButton">
            <button type="submit" class="openBtn" onclick="openForm()">
            ↪
          </button>
        </div>
        <div class="filter" id="filter">
            <button type="submit" class="cancelBtn" onclick="closeForm()">
            ↩
          </button> <br>
            <FORM>
                <!-- Type de Formations  -->
                Type de Formations:<br>
                <SELECT name="diplome_rgp" size="1">
                <option value="">Choisir une Formation </option>
                <?php
foreach ($arrayFormation as $value) {
    echo '<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
}
?>
               </SELECT>
                <hr>
                <br>

                <!-- Régions  -->
                Région:<br>
                <SELECT name="reg_etab" size="1">
                <option value="">Choisir une région</option>
                <?php
foreach ($arrayRegion as $key => $value) {
    echo '<option value="' . $key . '">' . $value . '</option>';
}
?>
               </SELECT>
                <hr>
                <br>

                <!-- Départements  -->
                Département:<br>
                <SELECT name="dep_etab" size="1">
                <option value="">Choisir un département </option>
                <?php
foreach ($arrayDep as $key => $value) {
    echo '<option value="' . $key . '">' . $value . '</option>';
}
?>
               </SELECT>
                <hr>
                <br>

                <input class="filterInput" type="submit" value="Filtrer">
            </FORM>
        </div>
        <div id="mapid">
          <script>

           window.onload = function(){
             var greenIcon = L.icon({

               iconUrl: '/ProjetWeb/map/images/marker.png',
             	//shadowUrl: '/ProjetWeb/map/images/shadow.png',

             	iconSize:     [38, 63], // size of the icon
             	iconAnchor:   [22, 65], // point of the icon which will correspond to marker's location
             	popupAnchor:  [-3, -50] // point from which the popup should open relative to the iconAnchor
           });

             console.log("salut");
             var mymap = L.map('mapid').setView([47.096411, 2.620687], 6);
             var tileStreets = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
               	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
               	maxZoom: 18,
               	id: 'mapbox.streets',
               	accessToken: 'pk.eyJ1IjoiaGVyZWFsIiwiYSI6ImNrMW92ZnJ3dDBvaWQzbWw4MWMyemRmMTkifQ.ybaNjSTBRj1Cw45T379ZMA'
               });
               mymap.addLayer(tileStreets);

               var markers = new L.MarkerClusterGroup();
               <?php


               foreach ($arrayEtablisement as  $value) {

                   $x = floatval($value['coordonnees']['0']);
                   $y = floatval($value['coordonnees']['1']);
                   $name = $value['uo_lib'];
                   $string = $name;
                   $string .= "<br> <a href='";
$string .= $value['url'];
$string .= "'target='_blank'>";
$string .= $value['url'];
$string .= "</a>";
$string .= "<br> <a href='./ecole.php?etablissement=".$value['uai']."'>En savoir plus</a>";






                   echo"markers.addLayer(new L.marker([".$x.",".$y."], {icon: greenIcon}).bindPopup(\"".$string."\"));\n";



                }
               ?>
              mymap.addLayer(markers);
           }

          </script>
        </div>




    </div>
</body>

</html>
