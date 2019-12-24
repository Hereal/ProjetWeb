
<?php
$json = file_get_contents('https://data.enseignementsup-recherche.gouv.fr/api/records/1.0/search/?dataset=fr-esr-principaux-diplomes-et-formations-prepares-etablissements-publics&facet=diplome_rgp&refine.rentree_lib=2017-18');



$obj = json_decode($json,true);
$array = $obj['facet_groups'][0]['facets'];
print '<pre>';
print_r($array);
print '</pre>';
foreach( $array as $value )
echo $value['name'] . '<br />';



?>
