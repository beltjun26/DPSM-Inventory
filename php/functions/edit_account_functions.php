<?php
  session_start();
  if($_SESSION['user']['type']!="admin"){
    header("Location: ../index/index.php");
  }
  require "connection.php";
  $query = $conn->query("Select * from users where username = '{$_GET['username']}'");
?>
