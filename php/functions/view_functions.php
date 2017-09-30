<!DOCTYPE html>
<html>
	<?php
		require "connection.php";
		
		session_start();
		session_check();
		// fix_supply_quantities();

		function session_check(){
			if(!(isset($_SESSION['log-in']))){
				header("Location:../index.php");
			}
		}


// queries

	function place_value(){
		if(isset($_POST['search'])){
			$search = $_POST['search'];
			echo $search;
		}
		elseif(isset($_POST['search_equipment'])){
			$search = $_POST['search_equipment'];
			echo $search;
		}

		elseif(isset($_POST['search_history'])){
			$search = $_POST['search_history'];
			echo $search;
		}

		elseif(isset($_POST['search_supply_history'])){
			$search = $_POST['search_supply_history'];
			echo $search;
		}

		elseif(isset($_POST['search_supply'])){
			$search = $_POST['search_supply'];
			echo $search;
		}

		elseif(isset($_POST['reciever'])){
			$reciever = $_POST['reciever'];
			echo $reciever;
		}
	}

	function cant_borrow($id, $message){
		?>
		<div class="alert alert-danger alert-dismissable alert_invalid text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <?php if ($message =="unreturned"){?>
			  <span><strong>Invalid Transaction:</strong> Borrower with ID Number <u><?= $id ?></u> has a pending equipment loan.Request cannot be processed at the moment.</span>
		<?php }
				else if($message == "exists"){?>
					<span><strong>Invalid Transaction:</strong> Equipment with Property Number <u><?= $id ?></u> already exists.</span>
		<?php	}
				else{?>
					<span><strong>Invalid Transaction:</strong> Borrower with ID Number <u><?= $id ?></u> has exceeded the maximum number of overdues. Request cannot be processed.</span>
		<?php		}

			?>
		</div>

		<?php
	}


	function cant_add_supply($supply_name, $brand){?>

		<div class="alert alert-danger alert-dismissable alert_invalid text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <span><strong>Invalid Transaction:</strong> Supply named <u><?= $supply_name ?></u> with brand <u><?= $brand ?></u> already exists in the database.</span>
		</div>
<?php
	}

	function edit_success($entity){
		?>
		<div class="alert alert-success alert-dismissable alert_checked_in text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <span><strong><?=$entity?> details edited sucessfully!</strong></span>
		</div>

	<?php

		$_SESSION['edited'] = 0;

	}

	function remove_success(){
		?>
		<div class="alert alert-success alert-dismissable alert_checked_in text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <span><strong>Equipment removed from database sucessfully!</strong></span>
		</div>

	<?php

		$_SESSION['removed'] = 0;

	}

	function show_success(){
		if(isset($_SESSION['check_in']) and $_SESSION['check_in']==1){
			check_in_success();
		}

		elseif(isset($_SESSION['edited']) and $_SESSION['edited']==1){
			edit_success("Equipment");
		}

		elseif(isset($_SESSION['edited']) and $_SESSION['edited']==2){
			edit_success("Supply");
		}
		elseif(isset($_SESSION['removed']) and $_SESSION['removed']==1){
			remove_success();
		}
	}

	

?>
</html>