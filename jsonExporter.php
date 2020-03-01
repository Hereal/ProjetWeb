<?php

function readJson($name){
  $json = file_get_contents('./json/'.$name.'.json', true);
   return json_decode($json, true);
}



function incrementFormation($id){
  $array = readJson("formation");
  if(isset($array[$id])){
    $array[$id] = $array[$id]+1;
  }else{
    $array[$id] =1;
  }

  $json_data = json_encode($array);
file_put_contents('./json/formation.json', $json_data);
}


function incrementSite($id){
  $array = readJson("site");
  if(isset($array[$id])){
    $array[$id] = $array[$id]+1;
  }else{
    $array[$id] =1;
  }

  $json_data = json_encode($array);
file_put_contents('./json/site.json', $json_data);
}

function getFormationValue($id){
  $array = readJson("formation");
  if(isset($array[$id])){
    return $array[$id];
  }
  return 0;
}

function getSiteValue($id){
  $array = readJson("site");
  if(isset($array[$id])){
    return $array[$id];
  }
  return 0;
}












 ?>
