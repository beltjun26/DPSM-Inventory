<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";

	date_default_timezone_set('Asia/Shanghai');
	$id = $_POST['id'];
	$time_returned = date("Y-m-d H:i:s");

	update_log($time_returned, $id);
	update_equipment($id);

	$_SESSION['check_in'] = 1;

	// check_in_success();
?>