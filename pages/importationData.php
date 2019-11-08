<?php
function connectToDB() {
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "projetweb";

  // Create connection
  $conn = new mysqli($servername, $username, $password,$dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully<br>";
  return $conn;
}


function insertEtablissement($ETABLISSEMENT_TYPE,$nameType){
  $conn = connectToDB();
  $sql = "INSERT INTO typeetablissement(TYPE_ETABLISSEMENT, nomType) VALUES ('".$ETABLISSEMENT_TYPE."','".$nameType."');";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}


insertEtablissement("TEST","test");


/*
$myfile = fopen("../data/data.csv", "r") or die("Unable to open file!");
fgets($myfile);
while(!feof($myfile)) {
   $str = fgets($myfile);
   if($str != ""){
     str_replace("\n","",$str);
     $strArray = explode(";",$str);
     echo $strArray[3]."<br>";
     //insertEtablissement($strArray[3],$strArray[2]);
   }
}
fclose($myfile);*/
?>
