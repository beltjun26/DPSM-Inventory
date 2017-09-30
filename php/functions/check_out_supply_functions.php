<!DOCTYPE html>
<html>

<?php
	include "connection.php";

	function suggestions(){
		GLOBAL $conn;

		$query = $conn->query("SELECT * from supply where quantity>0");
			while($row=$query->fetch_array()){
				echo "<option value='".$row['supply_name']." - ".$row['brand']."'/>";
			}
	}

	function check_entries(){
		GLOBAL $conn;

		if(isset($_POST['supply'])){
			$supply = $_POST['supply'];
			$quantity = $_POST['quantity'];
			$imbursed_to = $_POST['reciever'];

			$supply_name = explode(" - ", $supply)[0];
			$brand = explode(" - ", $supply)[1];

			$query = $conn->query("SELECT * from supply where supply_name='$supply_name' and brand='$brand'");
			$row = $query->fetch_array();
			$supply_id = $row['supply_id'];
			$imbursed_by = $_SESSION['username'];

			$query = $conn->query("INSERT into supply_log(supply_id, imbursed_by, imbursed_to, quantity_out) values('$supply_id', '$imbursed_by', '$imbursed_to', '$quantity')");


			$_SESSION['entries'] += 1;

		}

		unset($_POST['supply']);
		unset($_POST['quantity']);
	}

	function show_entries(){
		GLOBAL $conn;
		if(isset($_POST['quantity'])){

			$quantity = $_POST['quantity'];
			$entries = $_SESSION['entries'];
			$query = $conn->query("SELECT * from supply_log join supply on supply_log.supply_id=supply.supply_id join users on supply_log.imbursed_by=users.username");

			while($row=$query->fetch_array()){
		?>
				<tr>
					<td><?=$row['supply_name']?></td>
					<td><?=$row['brand']?></td>
					<td><?=$quantity?></td>
					<td><?=$row['unit']?></td>
				</tr>

		<?php
			}
		}
	}

	function show_supplies(){
		GLOBAL $conn;
		$search = $_POST['supply_name'];
		$search = explode(" - ", $search);

		if(sizeof($search)==1){
			$search = $search[0];
			$query = $conn->query("SELECT * from (SELECT * from supply where quantity>0) supply where supply_name like '%$search%' or brand like '%$search%' order by date_modified desc");
		}

		else{
			$supply_name = $search[0];
			$brand = $search[1];

			$query = $conn->query("SELECT * from (SELECT * from supply where quantity>0) supply where supply_name like '%$supply_name%' and brand like '%$brand%' order by date_modified desc");
		}

		
		supply_table($query);
	}


	function supply_table($query){
?>
	<div class="table-responsive">
		<table class="table table-hover" rules="rows" id="table-supply">
		<?php

			while($row = $query->fetch_array()){
?>
				<tr class="supply-row <?= $row['supply_id']?>" data-pg="<?= $row['supply_id']?>" >	
					<td><?= $row['supply_name'] ?></td>
					<td><?= $row['brand']?></td>
					<td colspan="2" class="text-center supply-left"><?= $row['quantity']?> <span><?= $row['unit']?></span> left</td>
				</tr>
				<tr class="hide-prompt <?= $row['supply_id']?>">
					<td></td>
					<td></td>
					<td class="prompt-quantity "><input type="number" min="1" class="form-control <?= $row['supply_id']?>" placeholder="Quantity"/></td>
					<td>
						<button class="btn btn-success <?= $row['supply_id']?>" type="button">OK</button>
						<span class="glyphicon glyphicon-remove close-prompt text-danger <?= $row['supply_id']?>"></span>
					</td>
				</tr>


<?php
			}
		?>
		</table>
	</div>

<?php
	}


	function show_supply_out(){
		GLOBAL $conn;
		if(!(isset($_SESSION['first_entry']))){
			$_SESSION['first_entry'] = mysqli_insert_id($conn);	
		}

		$first_entry = $_SESSION['first_entry'];

		$query_recievers = $conn->query("SELECT DISTINCT imbursed_to from supply_log where log_num >= '$first_entry'");

		$num_rows = mysqli_num_rows($query_recievers);

		if($num_rows >0){

		while ($row_recievers= $query_recievers->fetch_array()){

		$reciever = $row_recievers['imbursed_to'];
		echo "<dt>Recieved by: $reciever</dt>";

		$query = $conn->query("SELECT * from supply_log join supply on supply_log.supply_id=supply.supply_id where log_num >= '$first_entry' and imbursed_to = '$reciever' order by supply_name");

		while($row=$query->fetch_array()){
?>
			<dd>
				<span><?= $row['quantity_out'] ?></span>
				<span><?= $row['unit'] ?> </span>
				<span> - <?= $row['brand'] ?></span>
				<span><?= $row['supply_name'] ?></span>
				<span class="glyphicon glyphicon-remove text-danger cancel-check-out" data-pg
				="<?= $row['log_num'].';'.$row['supply_id'].';'.$row['quantity_out'] ?>"></span>
			</dd>


<?php
	}
	 echo "<br/>";
	}}
	else{
		echo "<p class='prompt text-center'>No Items Selected.</p>";
	}
	}


	function recievers(){
		GLOBAL $conn;

		$query = $conn->query("SELECT DISTINCT imbursed_to from supply_log");
		while($row=$query->fetch_array()){
			echo "<option value='".$row['imbursed_to']."'/>";
		}
	}

?>
</html>