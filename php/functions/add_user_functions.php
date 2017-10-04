<?php
  session_start();
  if($_SESSION['user']['type']!="admin"){
    header("Location: ../index/index.php");
  }
  require "connection.php";
  $error_password = "";
  $username_error = "";
  $name_error = "";
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $type = $_POST['type'];
    $username = $_POST['username'];
    $query = $conn->query("SELECT * FROM users where username = '$username'");
    if(mysqli_affected_rows($conn)!=0){
      $username_error = " - Already Taken";
    }
    $query=$conn->query("SELECT * FROM users WHERE name = '$name'");
    if(mysqli_affected_rows($conn)!=0){
      $name_error = " - Already Exist";
    }
    if(!$username_error || !$name_error){
      $password = MD5($_POST['password']);
      $query = $conn->query("INSERT INTO users(username, password, name, type) values('$username', '$password', '$name', '$type')");
      header("Location: manage_accounts.php?");
    }

  }
 ?>
