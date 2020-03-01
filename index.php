<?php
include_once 'generateList.php'; include_once 'jsonExporter.php';
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Portail de la formation</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="./js/script.js">
    </script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <link rel="stylesheet" href="./lib/MarkerCluster.css" />
  	<link rel="stylesheet" href="./lib/MarkerCluster.Default.css" />
  	<script src="./lib/leaflet.markercluster-src.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156849275-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-156849275-1');
  </script>

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
            <FORM action="index.php" method="get">
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

                <!-- Secteur disciplinaire  -->
                Secteur disciplinaire:<br>
                <SELECT name="sect_disciplinaire" size="1">
                <option value="">Choisir un secteur</option>
                <?php
                  foreach ($arraySecteur as $key => $value) {
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

               iconUrl: './images/marker.png',

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
             //Ajout de tout les marqueurs
             foreach ($arrayEtablisement as  $value) {
               $x = floatval($value['coordonnees']['0']);
               $y = floatval($value['coordonnees']['1']);

               $name = $value['uo_lib'];
               $string = $name . "<br> <a  href='siteIncrement.php?data=" . $value['url'] . "'target='_blank'>" . $value['url'] . "</a>" ."<br>Nombre de visite: ".getSiteValue( $value['url'] ). "<br> <a href='./ecole.php?etablissement=".$value['uai']."'>En savoir plus</a>";
               echo"markers.addLayer(new L.marker([".$x.",".$y."], {icon: greenIcon}).bindPopup(\"".$string."\"));\n";
             }
            ?>
              mymap.addLayer(markers);
           }

          </script>
        </div>
    </div>
    <?php include('footer.html');
    ?>

</body>

</html>
