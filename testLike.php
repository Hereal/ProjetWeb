<?php

 ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Like</title>
    <link rel="stylesheet" href="style/style.css"><script src="./js/script.js"></script>

</head>

<body>
  <?php
    try
  {
  	  $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');
  }
  catch (Exception $e)
  {
          die('Erreur : ' . $e->getMessage());
  }
  $reponse = $bdd->query('SELECT * FROM `likeecole` WHERE `adressIp`="'.$_SERVER['REMOTE_ADDR'].'"')->fetchAll();
echo "<pre>";
print_r($reponse);
echo "</pre>";
   ?>

<?php
$nbDislike = $bdd->query('SELECT COUNT(*) FROM `likeecole` WHERE idEcole = "0870669E" AND statutJaime=-1')->fetchAll();
if(isset($nbDislike[0])){
  $nbDislike = intval($nbDislike[0][0]);
}
else{
  $nbDislike = 0;
}
$nbLike = $bdd->query('SELECT COUNT(*) FROM `likeecole` WHERE idEcole = "0870669E" AND statutJaime=1')->fetchAll();
if(isset($nbLike[0])){
  $nbLike = intval($nbLike[0][0]);
}
else{
  $nbLike = 0;
}
echo "<pre>";
print_r($nbDislike);
echo "</pre>";
echo $nbDislike.'/'.$nbLike;




 ?>

    <img class="like" src="./images/dislike.png" alt="dislike">

    <svg height="30" width="100">
      <?php
      if($nbLike==0&&$nbDislike==0){
        echo'<line x1="0" y1="15" x2="100" y2="15" style="stroke:rgb(100,100,100);stroke-width:3" />';
      }else{
        echo'<line x1="0" y1="15" x2="'.(100/($nbLike+$nbDislike))*$nbDislike .'" y2="15" style="stroke:rgb(255,0,0);stroke-width:3" />';
        echo'<line x1="'. (100-(100/($nbLike+$nbDislike))*$nbLike) .'" y1="15" x2="100" y2="15" style="stroke:rgb(0,0,255);stroke-width:3" />';
      }
       ?>
    </svg>
    <img class="like" src="./images/like.png" alt="like">
</body>

</html>
