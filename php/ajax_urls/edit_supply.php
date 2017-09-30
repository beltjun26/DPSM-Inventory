<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";
	include "../functions/supply_inventory_functions.php";

	date_default_timezone_set('Asia/Shanghai');
	$id = $_POST['id'];


	GLOBAL $conn;
	$query = $conn->query("SELECT * from supply where supply_id='$id'");
	$row = $query->fetch_array();
	
	$_SESSION['edited']=1;
	return_supply_data($id);
	
	
?>