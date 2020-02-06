
<!DOCTYPE html>
<html>
<body>

<?php
$dsn = 'mysql:host=127.0.0.1;dbname=projetWeb;charset=utf8';
$username = "root";
$password = "";
$conn = new PDO($dsn, $username, $password);

  function insertLike($like){
    try {
        $conn = $GLOBALS['conn'];
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO likeecole(idEcole, adressIp, statutJaime) VALUES ('0870669E','".$_SERVER['REMOTE_ADDR']."',".$like.")";
        $conn->exec($sql);
        echo "New record created successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    $conn = null;
  }

  function updateLike($like){
    try {
        $conn = $GLOBALS['conn'];
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE likeecole SET statutJaime=".$like." WHERE idEcole = '0870669E' AND adressIp = '".$_SERVER['REMOTE_ADDR']."'";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "New record created successfully";
        }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
        }
    $conn = null;
  }


  function checkLike($like){
    // Create connection
    $conn = $GLOBALS['conn'];
    // Check connection

    $sql = "SELECT * FROM likeecole WHERE idEcole = '0870669E' AND adressIp = '".$_SERVER['REMOTE_ADDR']."'";
    $result = $conn->query($sql);

    echo $sql;
    echo "<br><br><br>";
    echo $result->rowCount();
    echo "<pre>";
    print_r($result->fetchAll());
    echo "</pre>";
    if ($result->rowCount() == 0) {
      echo "vide";
      insertLike($like);
    }
    elseif ($result->rowCount() == 1) {
      updateLike($like);
    }
    else {
    echo "plein";
    }
    $conn=null;
  }

checkLike(intval($_GET['q']));
?>
</body>
</html>
