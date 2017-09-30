<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";
	include "../functions/equipment_inventory_functions.php";

	date_default_timezone_set('Asia/Shanghai');
	$id = $_POST['id'];


	GLOBAL $conn;
	$query = $conn->query("SELECT * from equipment where property_number='$id'");
	$row = $query->fetch_array();

	if($row['equipment_status']=="on loan"){
		get_equipment_data($id, 'edit');
	}

	else{
		$_SESSION['edited']=1;
		return_equipment_data($id);
	}
	
?>