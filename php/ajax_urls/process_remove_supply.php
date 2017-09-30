<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";

	$id = $_POST['id'];
	$time_returned = date("Y-m-d H:i:s");

	remove_supply($id);

	$_SESSION['removed'] = 1;
?>