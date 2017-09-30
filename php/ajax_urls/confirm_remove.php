<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";
	include "../functions/equipment_inventory_functions.php";

	date_default_timezone_set('Asia/Shanghai');
	$id = $_POST['id'];
	$time_returned = date("Y-m-d H:i:s");

	get_equipment_data($id, 'delete');

?>