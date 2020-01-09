<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Portail de la formation</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
</head>

<body>
    <!--  NavBar  -->
    <div class="navBar">
        <div onclick="location.href='./index.php';" class="navBarItemLeft">
            <img class="navBarLogo" src="./images/logo.png" alt="logo">
        </div>

        <div class="navBarTitle">
            Ecole
        </div>

        <div class="searchDiv">
            <form action="./queryResult.php" method="get" class="">
                <input class="searchField" type="text" name="query" id="name" placeholder="Rechercher" required>
                <input class="searchButton" type="submit" value="m">
            </form>
        </div>
    </div>

    <!--  content  -->
    <div class="content">
      <div class="informationContent">
      <?php
        $query = $_GET['etablissement'];
        $json           = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&refine.rentree_lib=2017-18&refine.etablissement='.$query);
        $obj            = json_decode($json, true);
        if($obj['nhits'] =='0'){
          echo "Aucun résultats";
        }
        else{
          $array = $obj['records'];

          //Affichage des informations sur l'etablissement
          echo "Région: ".$array['0']['fields']['reg_etab_lib']."<br><hr>";
          echo "Département: ".$array['0']['fields']['dep_etab_lib']."<br><hr>";
          echo "Académie: ".$array['0']['fields']['aca_etab_lib']."<br><hr>";
          echo "Ville: ".$array['0']['fields']['com_etab_lib']."<br><hr>";

          //Recuperation des coordonnees de l'etablissement
          $json = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-etablissements-enseignement-superieur&q='.$array['0']['fields']['etablissement'].'&sort=uo_lib&refine.rentree_lib=2017-18');
          $obj = json_decode($json, true);

          if($obj['nhits'] =='0'){
            echo "Aucun résultats";
            $x = 47.096411;
            $y = 2.620687;
            $name = "Aucun Résultat";
          }
          else{
            $x = floatval($obj['records']['0']['fields']['coordonnees']['0']);
            $y = floatval($obj['records']['0']['fields']['coordonnees']['1']);
          }
        }
      ?>
    </div>
<div id="floatMap">
  <script>
  <?php
  if($obj['nhits'] =='0'){
    echo"hidemap()";
  }
   ?>
  window.onload = function(){

    var greenIcon = L.icon({

      iconUrl: '/ProjetWeb/images/marker.png',

      iconSize:     [38, 63], // size of the icon
      iconAnchor:   [22, 65], // point of the icon which will correspond to marker's location
      popupAnchor:  [-3, -50] // point from which the popup should open relative to the iconAnchor
  });

    console.log("salut");
  var mymap = L.map('floatMap').setView([<?php echo$x; ?>, <?php echo$y; ?>], 8);
    var tileStreets = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiaGVyZWFsIiwiYSI6ImNrMW92ZnJ3dDBvaWQzbWw4MWMyemRmMTkifQ.ybaNjSTBRj1Cw45T379ZMA'
      });
      tileStreets.addTo(mymap);
      var marker = L.marker([<?php echo$x; ?>, <?php echo$y; ?>], {icon: greenIcon}).addTo(mymap);
  }
  </script>
</div>
<?php
echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

foreach ($array as $value) {
  $temp = $value['fields'];



  echo "Type de Diplome: ".$temp['typ_diplome_lib']."<br>";
  echo "Type de D'Etablissement: ".$temp['etablissement_type_lib']."<br>";


echo '<form action="./formation.php" method="get" class="">
    <input  name="recordid" type="hidden" value="'.$value['recordid'].'">
    <input class="" type="submit" value="Voir cette formation">
</form>';

  echo "<hr><br>";
}


?>
    </div>
</body>

</html>
