<?php include_once 'API.php';$api = new API(); include_once 'jsonExporter.php';?>
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

      <?php
        $query = $_GET['etablissement'];
        $json           = $api->api1Request('&refine.etablissement='.$query.'&rows=-1');
        $obj            = json_decode($json, true);
        if($obj['nhits'] =='0'){
          echo "Aucun résultats";
        }
        else{
          echo "<div class='informationContent'>";
          $array = $obj['records'];

          //Affichage des informations sur l'etablissement
          echo "Région: ".$array['0']['fields']['reg_etab_lib']."<br><hr>";
          echo "Département: ".$array['0']['fields']['dep_etab_lib']."<br><hr>";
          echo "Académie: ".$array['0']['fields']['aca_etab_lib']."<br><hr>";
          echo "Ville: ".$array['0']['fields']['com_etab_lib']."<br><hr>";

          //Recuperation des coordonnees de l'etablissement
          $json = $api->api2Request('&q='.$array['0']['fields']['etablissement'].'&sort=uo_lib');
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
          echo "</div>";
        }
      ?>

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
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";






$arrayFiltre = array();
$nbHits = 0;
foreach ($array as $value) {
  $value2 = $value['fields'];
  $string = $value2['reg_etab_lib'].$value2['dep_etab_lib'].$value2['aca_etab_lib'].$value2['com_etab_lib'].$value2['typ_diplome_lib'].$value2['etablissement_type_lib'];
  $arrayFiltre[$string] = $value;
}
foreach ($arrayFiltre as $key => $value) {
  $nbHits++;
}







echo "<div class='centerText'> ";
echo $nbHits." Résultats trouvés</div><br>";



echo "<div class='resultList'>";




foreach ($arrayFiltre as $value) {
  $temp = $value['fields'];

echo "<div class='resultContainer'>";echo "<div class='textContainer'>";

  echo "Secteur: ".$temp['diplome_rgp']."<br><br>";
  echo "Type de Diplome: ".$temp['typ_diplome_lib']."<br><br>";
  echo "Type de D'Etablissement: ".$temp['etablissement_type_lib']."<br><br>";
  echo "Nombre de vues de la formation: ".getFormationValue($value['recordid'])." <br><br>";


echo '<form action="./formation.php" method="get" class="">

    <input  name="recordid" type="hidden" value="'.$value['recordid'].'">
    <br><br>
    <input class="" type="submit" value="Voir cette formation">
</form>';
  echo "</div>";echo "</div>";
  echo "<br>";
}
echo "</div>";

?>
    </div>
</body>

</html>
