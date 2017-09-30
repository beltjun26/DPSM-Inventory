
<?php 
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";
	include "../functions/check_out_supply_functions.php";

	$id = $_POST['id'];
	$quantity = $_POST['quantity'];
	$reciever = $_POST['reciever'];

	save_to_supply_log($id, $quantity, $reciever);
?>