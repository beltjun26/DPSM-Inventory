<?php
  $error_password = "";
  if(isset($_POST['submit'])){
      if(md5($_POST['oldpassword'])!=$_SESSION['user']['password']){
        $error_password = "Wrong Password";
      }
  }
 ?>
