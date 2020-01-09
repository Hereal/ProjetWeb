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
    <div class="content">
      <?php
$query = $_GET['query'];

$json           = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&q=%22'.$query.'%22&sort=-rentree_lib');
$obj            = json_decode($json, true);
if($obj['nhits'] =='0'){
  echo "Aucun résultats";
}
else{
$array = $obj['records'];

foreach ($array as $value) {
  $temp = $value['fields'];


  echo "Région: ".$temp['reg_etab_lib']."<br>";
  echo "Département: ".$temp['dep_etab_lib']."<br>";
  echo "Académie: ".$temp['aca_etab_lib']."<br>";
  echo "Ville: ".$temp['com_etab_lib']."<br>";
  echo "Type de Diplome: ".$temp['typ_diplome_lib']."<br>";
  echo "Type de D'Etablissement: ".$temp['etablissement_type_lib']."<br>";

echo '<form action="./formation.php" method="get" class="">
    <input  name="recordid" type="hidden" value="'.$value['recordid'].'">
    <input class="" type="submit" value="Voir cette formation">
</form>';

  echo "<hr><br>";
}

}
?>

    </div>
</body>

</html>
