<?php

include_once 'API.php';
$api = new API();

//Recuperation des arguments pour le filtre
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
  }}
  if(isset($_GET['sect_disciplinaire'])){
    if($_GET['sect_disciplinaire'] != ""){
    $string .= "&refine.sect_disciplinaire=";
    $string .= $_GET['sect_disciplinaire'];
  }}



//Creations des diverses listes
//Facet Formations
$json =$api->api1Request('&facet=com_etab&facet=com_etab_lib&facet=dep_etab&facet=dep_etab_lib&facet=aca_etab&facet=aca_etab_lib&facet=reg_etab&facet=reg_etab_lib&facet=diplome_rgp&facet=sect_disciplinaire_lib&facet=sect_disciplinaire');
$obj = json_decode($json, true);
$arrayFormation = $obj['facet_groups'][11]['facets'];

//Facet Régions
$tempoId     = $obj['facet_groups'][9]['facets'];
$tempoId2    = array();
$tempoValue  = $obj['facet_groups'][5]['facets'];
$tempoValue2 = array();
foreach ($tempoId as $value) {
    array_push($tempoId2, $value['name']);
}
foreach ($tempoValue as $value) {
    array_push($tempoValue2, $value['name']);
}
$arrayRegion = array_combine($tempoId2, $tempoValue2);

//Facet Sect Disciplinaire
$tempoId     = $obj['facet_groups'][4]['facets'];
$tempoId2    = array();
$tempoValue  = $obj['facet_groups'][1]['facets'];
$tempoValue2 = array();
foreach ($tempoId as $value) {
    array_push($tempoId2, $value['name']);
}
foreach ($tempoValue as $value) {
    array_push($tempoValue2, $value['name']);
}
$arraySecteur = array_combine($tempoId2, $tempoValue2);



//Facet Departement
$tempoId     = $obj['facet_groups'][2]['facets'];
$tempoId2    = array();
$tempoValue  = $obj['facet_groups'][7]['facets'];
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
asort($arraySecteur);

//Liste Etablissement (BDD1)
$json           = $api->api1Request('&rows=0&facet=etablissement&facet=etablissement_lib'.$string);
if(isset(json_decode($json, true)['facet_groups'])){
$obj            = json_decode($json, true)['facet_groups'];
$arrayPoint = array();
$tempoId = $obj[1]['facets'];
$tempoId2  = array();
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

//Liste localisation Etablissement (BDD2)
$json           = $api->api2Request('&rows=-1');
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

$arrayEtablisement = array_intersect_key($arrayEtablisement,$arrayPoint); //Recuperation des établissements commun aux deux bases de données pour un traitement sans erreur.
}else{
  $arrayEtablisement = array();
}
 ?>
