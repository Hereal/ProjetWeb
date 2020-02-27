<?php include_once 'API.php';$api = new API(); ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Portail de la formation</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <!--  NavBar  -->
    <div class="navBar">
        <div onclick="location.href='./index.php';" class="navBarItemLeft">
            <img class="navBarLogo" src="./images/logo.png" alt="logo">
        </div>

        <div class="navBarTitle">
            Résultat de la recherche
        </div>

        <div class="searchDiv">
            <form action="./queryResult.php" method="get" class="">
                <input class="searchField" type="text" name="query" id="name" placeholder="Rechercher" required>
                <input class="searchButton" type="submit" value="m">
            </form>
        </div>
    </div>

    <!--  content  -->



      <?php
$query = $_GET['query'];

$json           = $api->api1Request('&q=%22'.$query.'%22&sort=-rentree_lib&facet=diplome_rgp&rows=-1');
$obj            = json_decode($json, true);

if($obj['nhits'] =='0'){
  echo "<div class='errorField' >
      Aucun résultats
  </div>";
}

else{
  $arrayFacetFormation = $obj['facet_groups'][0]['facets'];
  $arrayFormations    = array();

$nbHits = 0;
  $array = $obj['records'];
  $arrayFiltre = array();
  foreach ($array as $value) {
    $value2 = $value['fields'];
    $string = $value2['reg_etab_lib'].$value2['dep_etab_lib'].$value2['aca_etab_lib'].$value2['com_etab_lib'].$value2['typ_diplome_lib'].$value2['etablissement_type_lib'];
    $arrayFiltre[$string] = $value;
  }
  foreach ($arrayFiltre as $key => $value) {
    $nbHits++;
  }






  foreach ($arrayFacetFormation as $value2) {
    $arraytempo = array();
    foreach ($arrayFiltre as $value) {
      if($value['fields']['diplome_rgp']==$value2['name']){
        array_push($arraytempo, $value);
      }
    }
    array_push($arrayFormations, $arraytempo);
  }


  echo "<div class='content'><br><div class='centerText'> ";
  echo $nbHits." Résultats trouvés</div><br><br>";
  foreach ($arrayFormations as $FormationName) {
    echo "<br>  <div class='centerText'>  ".$FormationName[0]['fields']['typ_diplome_lib']."</div><br>";
    echo "<div class='resultList'>";
    foreach ($FormationName as $value) {

      $temp = $value['fields'];

      echo "<div class='resultContainer'><br>";
      echo "Région: ".$temp['reg_etab_lib']."<br><br>";
      echo "Département: ".$temp['dep_etab_lib']."<br><br>";
      echo "Académie: ".$temp['aca_etab_lib']."<br><br>";
      echo "Ville: ".$temp['com_etab_lib']."<br><br>";
      echo "Type de Diplome: ".$temp['typ_diplome_lib']."<br><br>";
      echo "Type de D'Etablissement: ".$temp['etablissement_type_lib']."<br><br>";

    echo '<form action="./formation.php" method="get" class="">
        <input  name="recordid" type="hidden" value="'.$value['recordid'].'">
        <input class="" type="submit" value="Voir cette formation">
    </form>';

      echo "</div><br>";
    }
    echo "</div>";
  }


    $array = $obj['records'];







echo "</div>";
}
?>


</body>

</html>
