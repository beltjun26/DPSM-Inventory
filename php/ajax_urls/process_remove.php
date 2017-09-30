<?php
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";

	$id = $_POST['id'];

	remove_equipment($id);

	$_SESSION['removed'] = 1;
?>