<?php
$json = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=com_etab&facet=com_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=diplome_rgp&refine.rentree_lib=2017-18');
$obj = json_decode($json,true);
$arrayFormation = $obj['facet_groups'][9]['facets'];
$arrayDep = array();
$tempoId = $obj['facet_groups'][1]['facets'];
$tempoValue = $obj['facet_groups'][5]['facets'];
for($i = 0; $i < count($tempoId); ++$i) {
  $arrayDep[$tempoId[$i]] = $tempoValue[$i];
  //array_push($arrayDep,$tempoId[$i]=>$tempoValue[$i]);
}
?>



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
    <div class="mainDiv">
        <div class="navBar">
            <a href="index.html"><img id="logo" src="images/logo.png" alt="Logo"></a>
            Formations
        </div>
        <div class="filterDiv">
            <div class="title">
                Filter
            </div>
            <div class="content">
                <FORM>
                  <h3>Type de formation</h3>
                  <hr>
                  <SELECT name="formation" size="1">
                      <option value="">Choisir une Formation </option>

                      <?php
                      foreach( $arrayFormation as $value ){
                        echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';}
                      ?>
                  </SELECT>
                    <h3>Région</h3>
                    <hr>
                    <SELECT name="region" size="1">
                        <option value="">Choisir une région </option>

                    </SELECT>
                    <h3>Département</h3>
                    <hr>
                    <SELECT name="departement" size="1">
                        <option value="">Choisir un département </option>
                        <?php
                        foreach( $arrayDep as $key =>$value ){
                          echo '<option value="'.$key['name'].'">'.$value['name'].'</option>';}
                        ?>

                    </SELECT>
                    <h3>Bac</h3>
                    <hr>
                    <SELECT name="bac" size="1">
                        <option value="">Choisir un niveau de bac </option>
                        <option value="1">Bac+1</option>
                        <option value="2">Bac+2</option>
                        <option value="3">Bac+3</option>
                        <option value="4">Bac+4</option>
                        <option value="5">Bac+5</option>
                        <option value="6">Bac+6</option>
                        <option value="7">Bac+7</option>
                        <option value="8">Bac+8</option>
                    </SELECT>

                    <input class="filterInput" type="submit" value="Filtrer">
                </FORM>

            </div>
        </div>
        <div class="searchDiv">
            <FORM>
                <input class="searchBar" type="text" placeholder="Recherche..">
                <input class="searchButton" type="submit" value="&#x1F50E;">
            </FORM>
        </div>
        <div id="mapid">
            <script type="text/javascript" src="map/map.js"></script>
        </div>

        <div class="resultDiv">
            <div class="title">
                Résultats
            </div>
            <div class="content">
                <h3>IUT Marne la Vallée</h3>
                  <a href="pages/ecole.html"><h5>link</h5></a>
                <h3>Ecole d'ingénieur n°2</h3>
                <h3>Ecole d'ingénieur n°3</h3>

            </div>
        </div>
    </div>
</body>

</html>
