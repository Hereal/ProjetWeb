<?php

  ?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Like</title>
    <link rel="stylesheet" href="style/style.css"><script src="./js/script.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        var nbLike = 0;
        var nbDislike = 0;

        function like(statut){
                  xmlhttp = new XMLHttpRequest();
                  xmlhttp.open("GET","ajaxRequest/like.php?q="+statut);
                  xmlhttp.send();
                  update();
                  /*
                  xmlhttp.addEventListener("load", function () {

                    window.location.href=window.location.href;
                  });*/
        }

        function init(like, dislike){
          nbLike = like;
          nbDislike = dislike;
        }
        function update(){
          var span = document.getElementById("likeDislike");
          span.textContent = nbDislike.toString()+"/"+nbLike.toString();
          document.getElementById("like").setAttribute("src", "./images/like-activated.png");
          document.getElementById("dislike").setAttribute("src", "./images/dislike-activated.png");
        }

  </script>
</head>

<body>
  <?php
    try{
  	  $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');
    }
    catch (Exception $e)  {
            die('Erreur : ' . $e->getMessage());
    }
    $reponse = $bdd->query('SELECT * FROM likeecole WHERE adressIp="'.$_SERVER['REMOTE_ADDR'].'"')->fetchAll();


$nbDislike = $bdd->query('SELECT COUNT(*) FROM likeecole WHERE idEcole = "0870669E" AND statutJaime=-1')->fetchAll();
if(isset($nbDislike[0])){
  $nbDislike = intval($nbDislike[0][0]);
}
else{
  $nbDislike = 0;
}
$nbLike = $bdd->query('SELECT COUNT(*) FROM likeecole WHERE idEcole = "0870669E" AND statutJaime=1')->fetchAll();
if(isset($nbLike[0])){
  $nbLike = intval($nbLike[0][0]);
}
else{
  $nbLike = 0;
}

echo "<script>init(".$nbDislike.",". $nbLike.");</script>";




 ?>
 <span id="likeDislike"></span>
 <img class="like" id="like" src="./images/like.png" alt="like" onclick="like(1)">


    <svg height="30" width="100">
      <?php
      if($nbLike==0&&$nbDislike==0){
        echo'<line x1="0" y1="15" x2="100" y2="15" style="stroke:rgb(100,100,100);stroke-width:3" />';
      }else{
        echo'<line x1="'.(100-(100/($nbLike+$nbDislike))*$nbDislike) .'" y1="15" x2="0" y2="15" style="stroke:rgb(0,0,255);stroke-width:3" />';
        echo'<line x1="100" y1="15" x2="'. ((100/($nbLike+$nbDislike))*$nbLike) .'" y2="15" style="stroke:rgb(255,0,0);stroke-width:3" />';
      }
       ?>
    </svg>
    <img class="like"  id="dislike" src="./images/dislike.png" alt="dislike" onclick="like(-1)">
    <script>update();</script>
</body>

</html>
