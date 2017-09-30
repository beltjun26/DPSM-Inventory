
<?php 
	require "../functions/connection.php";
	include "../functions/view_functions.php";
	include "../functions/insert_update_functions.php";
	include "../functions/equipment_history_functions.php";

	$key = $_POST['id'];
	arrange_table($key);
?>