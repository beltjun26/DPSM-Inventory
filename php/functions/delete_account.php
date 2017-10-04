<?php
  require "connection.php";
  session_start();
  if(!(isset($_SESSION['log-in']))){
    header("Location: ../../index.php");
  }
  if($_SESSION['user']['type']!="admin"){
    header("Location: ../../index.php");
  }
  $query = $conn->query("DELETE FROM users where username = '{$_GET['username']}'");
  if(mysqli_affected_rows($conn)){
    header("Location: ../manage_accounts.php");
  }

 ?>
