<?php

	require "connection.php";
	session_start();


	function log_in(){
		GLOBAL $conn;

		if(isset($_SESSION['log-in'])){
			header("Location:php/equipment_logs.php");
		}

		elseif(isset($_POST['log_in'])){
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			$query = $conn->query("SELECT * from users where binary username='$username'");
			$num_row = mysqli_num_rows($query);

			if($num_row==0){
				show_error("username");
			}
			else{
				$row = $query->fetch_array();
				if($password==$row['password']){
					$_SESSION['user']=$row;
					$_SESSION['log-in']=1;
					$_SESSION['username']=$username;
					header("Location:php/equipment_logs.php");
				}
				else{
					show_error("password");
				}
			}
		}
	}

	function show_error($message){?>
		<div class="alert alert-danger alert-dismissable alert_invalid text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <?php if ($message =="username"){?>
			  <span><strong>Log-in Error:</strong>Invalid username.</span>

		<?php	}
				else{?>
					<span><strong>Log-in Error:</strong>Incorrect password.</span>
		<?php		}

			?>
		</div>
<?php
	}


?>
