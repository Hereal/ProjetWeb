<?php
//Formations
$json           = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=com_etab&facet=com_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=diplome_rgp&refine.rentree_lib=2017-18');
$obj            = json_decode($json, true);
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
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Portail de la formation</title>
    <link rel="stylesheet" href="style/style2.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="./js/script.js" type="text/javascript">
    </script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
</head>

<body>
    <!---------------  NavBar  ----------------------------->
    <div class="navBar">
        <div onclick="location.href='./index2.php';" class="navBarItemLeft">
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

    <!---------------  content  ----------------------------->
    <div class="content">
        <!---------------  filter  ----------------------------->
        <div class="filterButton" id="filterButton">
            <button type="submit" class="openBtn" onclick="openForm()">
            Filter
            >
          </button>
        </div>
        <div class="filter" id="filter">
            <button type="submit" class="cancelBtn" onclick="closeForm()">
            Filter <
          </button> <br>
            <FORM>

                <!-- Type de Formations  -->
                Type de Formations:<br>
                <SELECT name="formation" size="1">
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
                <SELECT name="formation" size="1">
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
                <SELECT name="formation" size="1">
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
            <script type="text/javascript" src="map/map.js"></script>
        </div>




    </div>
</body>

</html>
