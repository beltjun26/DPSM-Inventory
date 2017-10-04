<?php
  session_start();
  if(!(isset($_SESSION['log-in']))){
    header("Location: ../../index.php");
  }
  if($_SESSION['user']['type']!="admin"){
    header("Location: ../index.php");
  }
  $query = $conn->query("Select * from users");

 ?>
