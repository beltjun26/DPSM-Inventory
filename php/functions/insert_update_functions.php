<?php

	require "connection.php";

	function check_out(){
		date_default_timezone_set('Asia/Shanghai');
		GLOBAL $conn;

		if(isset($_POST['check_out'])){
			$borrower_name = $_POST['name'];
			$borrower_id = $_POST['id'];
			$duration = $_POST['duration'];
			$propt_num = $_POST['item'];
			$status = "unreturned";
			$borrow_time = date("Y-m-d H:i:s");
			$due_time =  date("Y-m-d H:i:s", strtotime(sprintf("+%d hours", $duration)));
			$has_clear_record = 1;
			$message = "";
			$encoder = $_SESSION['username'];
			$returned_to = $_SESSION['username'];

			$query = $conn->query("SELECT status from equipment_log where borrower_id= '$borrower_id'");
			
			while($row= $query-> fetch_array()){
				if($row['status']=="unreturned"){
					$has_clear_record = 0;
					$message = "unreturned";
					break;
				}
			}

			if(overdue_count($borrower_id)>3 and $has_clear_record=0){
				$has_clear_record = 0;
				$message = "overdue";
			}

			if($has_clear_record){
				$query = $conn ->query("INSERT into equipment_log(borrower_id, borrower_name, status, borrow_time, due_time, property_number, encoder, returned_to) values ('$borrower_id', '$borrower_name', '$status', '$borrow_time', '$due_time', '$propt_num', '$encoder', '$returned_to')");
				$query = $conn->query("UPDATE equipment set equipment_status='on loan' where property_number='$propt_num'");

				header('location:'.$_SERVER['PHP_SELF']);
	      		die();
	      	}

	      	else{
	      		cant_borrow($borrower_id, $message);
	      	}
		}
	}


	function new_equipment(){
		date_default_timezone_set('Asia/Shanghai');
		GLOBAL $conn;

		if(isset($_POST['add_equipment'])){
			$item_name = $_POST['item_name'];
			$property_number = $_POST['property_number'];
			$equipment_status = "available";
			$date_added = date("Y-m-d");
			$encoder = $_SESSION['username'];
			$message = "";

			$query = $conn->query("SELECT * from equipment where property_number='$property_number'");
			$num_rows = mysqli_num_rows($query);

			if($num_rows>0){
				$message = "exists";
				cant_borrow($property_number, $message);
			}
			
			else{
				$query = $conn->query("INSERT into equipment(property_number, item_name, date_added, equipment_status, encoder) values ('$property_number', '$item_name', '$date_added', '$equipment_status', '$encoder')");

				header('location:'.$_SERVER['PHP_SELF']);
	      		die();
			}
		}
	}


	function new_supply(){
		date_default_timezone_set('Asia/Shanghai');
		GLOBAL $conn;

		if(isset($_POST['add_supply'])){
			$supply_name = $_POST['supply_name'];
			$brand = $_POST['brand'];
			$quantity = $_POST['quantity'];
			$unit = $_POST['unit'];
			$date_added = date("Y-m-d");
			$encoder = $_SESSION['username'];

			$query = $conn->query("SELECT * from supply where supply_name='$supply_name' and brand='$brand'");
			$num_rows = mysqli_num_rows($query);

			if($num_rows>0){
				$row = $query->fetch_array();
				$id = $row['supply_id'];
				if($row['quantity']<0){
					$query = $conn->query("UPDATE supply set quantity = '$quantity' where supply_id='$id'");
				}

				else{
					cant_add_supply($supply_name, $brand);
				}
			}
			
			else{
				$query = $conn->query("INSERT into supply(supply_name, brand, quantity, unit, date_added, encoder) values ('$supply_name', '$brand', '$quantity', '$unit', '$date_added', '$encoder')");

				header('location:'.$_SERVER['PHP_SELF']);
	      		die();
			}
		}
	}


	function edit_equipment(){
		GLOBAL $conn;

		if(isset($_POST['edit'])){
			$item_name = $_POST['item_name'];
			$property_number = $_POST['property_number'];
			$prev_property_number = $_POST['prev_property_number'];
			$message = "";

			$query = $conn->query("SELECT * from equipment where property_number='$property_number'");

			$row = $query->fetch_array();
			if($row['item_name']!=$item_name || $row['property_number']!=$property_number){
				$_SESSION['edited']=1;
				$num_rows = mysqli_num_rows($query);

				if(($num_rows==1) and ($property_number!=$prev_property_number)){
					$message = "exists";
					cant_borrow($property_number, $message);
				}
				
				else{
					$query = $conn->query("UPDATE equipment set item_name='$item_name', property_number='$property_number' where property_number='$prev_property_number'");

					header('location:'.$_SERVER['PHP_SELF']);
		      		die();
				}
			}

			$_SESSION['edited']=0;
		}
	}


	function edit_supply(){
		GLOBAL $conn;

		if(isset($_POST['edit_supply'])){
			$supply_name = $_POST['supply_name'];
			$brand = $_POST['brand'];
			$quantity = $_POST['quantity'];
			$unit = $_POST['unit'];
			$encoder = $_SESSION['username'];
			$supply_id = $_POST['supply_id'];


			$query = $conn->query("SELECT * from supply where supply_id='$supply_id'");
			$row = $query->fetch_array();
			
			if($row['supply_name']!=$supply_name || $row['brand']!=$brand || $row['quantity']!=$quantity || $row['unit']!=$unit){
				$query = $conn->query("UPDATE supply set supply_name='$supply_name', brand='$brand', quantity='$quantity', unit='$unit', encoder='$encoder' where supply_id='$supply_id'");

				$_SESSION['edited']=2; 
				header('location:'.$_SERVER['PHP_SELF']);
      			die();
			}		

			$_SESSION['edited']=0;
			
		}
	}


	function update_log($time_returned, $id){
		GLOBAL $conn;
		$query = $conn->query("SELECT due_time from equipment_log where log_num='$id'");
		$row= $query-> fetch_array();
		$due_time = $row['due_time'];
		$status = "on time";
		$returned_to = $_SESSION['username'];

		if ($time_returned > $due_time){
			$status = "overdue";
		}

		GLOBAL $conn;
		$query = $conn->query("UPDATE equipment_log set time_returned='$time_returned', status='$status',returned_to='$returned_to' where log_num='$id'");
	}

	function update_equipment($id){
		GLOBAL $conn;
		$query= $conn->query("SELECT property_number from equipment_log where log_num='$id'");
		$row= $query-> fetch_array();
		$property_number = $row['property_number'];


		$query= $conn->query("UPDATE equipment set equipment_status='available' where property_number='$property_number'");
	}

	function remove_equipment($id){
		GLOBAL $conn;
		$query= $conn->query("UPDATE equipment set equipment_status='removed' where property_number='$id'");
	}

	function remove_supply($id){
		GLOBAL $conn;
		$query= $conn->query("UPDATE supply set quantity=-1 where supply_id='$id'");
	}


	function save_to_supply_log($id, $quantity, $reciever){
		GLOBAL $conn;
		$user = $_SESSION['username'];

		if($quantity >0){
			$query = $conn->query("INSERT into supply_log (supply_id, imbursed_by, imbursed_to, quantity_out) values ('$id', '$user', '$reciever', '$quantity')");
		}
		show_supply_out();
	}

	function remove_from_supply_log($id){
		GLOBAL $conn;
		$query = $conn->query("DELETE from supply_log where log_num='$id'");
		show_supply_out();
	}

	function check_out_supplies(){
		GLOBAL $conn;

		$first_entry = $_SESSION['first_entry'];
		$query_supply_log = $conn->query("SELECT * from supply_log where log_num >= '$first_entry'");
		while($row = $query_supply_log->fetch_array()){
			$supply_id = $row['supply_id'];
			$quantity_out = $row['quantity_out'];

			$query_supply = $conn->query("SELECT * from supply where supply_id = '$supply_id'");
			$row_supply = $query_supply->fetch_array();

			$new_quantity = $row_supply['quantity'] - $quantity_out;

			$query = $conn->query("UPDATE supply set quantity='$new_quantity' where supply_id='$supply_id'");
		}
	}

	function delete_unsaved_log(){
		GLOBAL $conn;

		if(isset($_SESSION['first_entry'])){
			$first_entry = $_SESSION['first_entry'];

			$query = $conn->query("DELETE from supply_log where log_num >= '$first_entry'");
			unset($_SESSION['first_entry']);
		}
	}


	function fix_supply_quantities(){
		GLOBAL $conn;

		$query = $conn->query("SELECT * from supply where unit like '%s'");
		while($row = $query->fetch_array()){
			$quantity = $row['quantity'];
			$unit = $row['unit'];
			$supply_id = $row['supply_id'];
			$new_unit = substr($unit, 0, -1);

			if($quantity <= 1){
				$query_update = $conn->query("UPDATE supply set unit='$new_unit' where supply_id='$supply_id'");
			}
		}

		$query_single = $conn->query("SELECT * from supply where unit not like '%s'");
		while($row = $query_single->fetch_array()){
			$quantity = $row['quantity'];
			$unit = $row['unit'];
			$supply_id = $row['supply_id'];
			$new_unit =$unit . 's';

			if($quantity >1){
				$query_update_single = $conn->query("UPDATE supply set unit='$new_unit' where supply_id='$supply_id'");
			}
		}
	}



?>