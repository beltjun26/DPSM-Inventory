<!DOCTYPE html>
<html>
	<?php 
		include "connection.php";
		supply_inventory_table();

	function supply_table($query){

	?>
			<div class="table-responsive">
					<table class="table table-hover table-bordered log-list equipment_table">
						<colgroup class="col-numbers"></colgroup>
						<thead>
							<tr>
								<th colspan="2" id="supply_name">SUPPLY NAME</th>
								<th id="brand">BRAND</th>
								<th id="quantity">QUANTITY</th>
								<th id="unit">UNIT</th>
								<th id="date_added">DATE ADDED</th>
								<th id="date_modified">LAST UPDATED</th>
								<th id="name">ENCODED BY</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php 

							$num_rows = mysqli_num_rows($query);
							
							if($num_rows>0){
								$i=1;
								while ($row= $query-> fetch_array()){
									$date_added = new DateTime($row['date_added']);
									$date_added = $date_added->format('M d, Y');
									$date_modified = new DateTime($row['date_modified']);
									$date_modified = $date_modified->format('M d, Y');
									
						?>
									<tr>
										<td><?php echo $i; ?></td>
										<td class="text-center"><?php echo $row['supply_name']; ?></td>
										<td class="text-center"><?= $row['brand']; ?></td>
										<td class="text-center"><?= $row['quantity']; ?></td>
										<td class="text-center"><?= $row['unit']; ?></td>
										<td class="text-center"><?= $date_added; ?></td>
										<td class="text-center"><?= $date_modified; ?></td>
										<td class="text-center"><?= $row['name'] ?></td>

										<td class="text-center"><button name="edit_supply" class="btn btn-warning edit_supply" data-toggle="modal" data-target="#edit_supply_mod" data-pg="<?php echo $row['supply_id']; ?>">edit</button>
											<button name="remove_supply" class="btn btn-danger remove_supply btn-inline" data-toggle="modal" data-target="#remove_supply_mod" data-pg="<?php echo $row['supply_id']; ?>">remove</button>
										</td>
									</tr>
									<?php
									$i++;
								}
							}

							else{?>
								<tr><td colspan="9" class="text-center">No item found.</td></tr>

						<?php	}
						?>
						</tbody>
					</table>

					<script type="text/javascript">
						$('.equipment_table').paginate({
				    		limit: 20,
					    	onSelect: function(obj, page) {
					     	console.log('Page ' + page + ' selected!' );}
						});
					</script>					

				</div>


	<?php
				mod_new_supply();
				mod_edit_supply();
				mod_remove_supply();
		}



	function supply_inventory_table(){
		date_default_timezone_set('Asia/Shanghai');
		GLOBAL $conn;
		$query = $conn->query("SELECT * from supply where quantity>=0 order by supply_name");

		$cur_date = new DateTime();
		$cur_date = $cur_date->format('M d, Y');
		?>

		<div class="table-responsive" id="inventory_table">
			<table class="table" border="1">
				<caption>DPSM OFFICE SUPPLIES INVENTORY REPORT AS OF 
					<span><?= $cur_date ?></span>
				</caption>
				<colgroup class="col-numbers"></colgroup>
				<thead>
					<tr>
						<th>Item No.</th>
						<th>SUPPLIES</th>
						<th>BRAND</th>
						<th>QUAN</th>
						<th>UNIT</th>
						<th>LOCATION</th>
					</tr>
				</thead>
				<tbody>
				<?php 

					$num_rows = mysqli_num_rows($query);
					
					if($num_rows>0){
						$i=1;
						while ($row= $query-> fetch_array()){							
				?>
							<tr>
								<td><?= $i ?></td>
								<td class="text-center"><?php echo $row['supply_name']; ?></td>
								<td class="text-center"><?= $row['brand']; ?></td>
								<td class="text-center"><?= $row['quantity']; ?></td>
								<td class="text-center"><?= $row['unit']; ?></td>
								<td class="text-center">DPSM Office</td>
							</tr>
							<?php
							$i++;
						}
					}
				?>
				</tbody>
			</table>
		</div>
<?php
	}


	function mod_new_supply(){?>
		<div class="modal fade borrow-modal" id="new_supply_mod" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header success">
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> New Supply</h4>
					</div>

					<form method="post" action="<?php $_PHP_SELF; ?>" class="row">
						<div class="modal-body">
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="supply_name" class="input-group-addon">Supply Name</label>
									<input list="supply_names" name="supply_name" class="form-control" autofocus="" required="" autocomplete="off"/>
										<datalist id="supply_names">
											<?php
												options("supply_name");
											?>
										</datalist>
								</div>
							</div>
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="brand" class="input-group-addon">Brand</label>
									<input list="brands" name="brand" class="form-control" autocomplete="off"/>
										<datalist id="brands">
											<?php 
												options("brand");
											?>
										</datalist>
								</div>
							</div>
							<div class="form-group col-xs-6">
								<div class="input-group">
									<label for="quantity" class="input-group-addon">Quanity</label>
									<input type="number" min="0" name="quantity" class="form-control" required="" autocomplete="off"/>
								</div>
							</div>
							<div class="form-group col-xs-6">
								<div class="input-group">
									<label for="unit" class="input-group-addon">Unit</label>
									<input list="units" name="unit" class="form-control" required="" autocomplete="off"/>
										<datalist id="units">
											<?php
												options("unit");
											?>
										</datalist>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<input type="submit" name="add_supply" class="btn btn-success check_out_btn" value="Add"/>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php
	}

	function mod_remove_supply(){?>
		<div class="modal fade borrow-modal" id="remove_supply_mod" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header warning">
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-remove"></span> Remove</h4>
					</div>

					<div class="supply_modal_content"></div>
					
				</div>
			</div>
		</div>

<?php
	}

	function mod_edit_supply(){?>
			<div class="modal fade borrow-modal" id="edit_supply_mod" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header success">
							<button class="close" data-dismiss="modal"><span>&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Edit Supply Details</h4>
						</div>

						<div class="supply_modal_content"></div>
						
					</div>
				</div>
			</div>

<?php
	}

	function search_result_supply(){
		GLOBAL $conn;
		if(isset($_POST['search_supply'])){
			$search = $_POST['search_supply'];
			$query = $conn->query("SELECT * from (SELECT * from supply where quantity>=0) supply join users on supply.encoder=users.username where supply_name like '%$search%' or brand like '%$search%' or name like '%$search%' or quantity like '%$search%' or unit like '%$search%' or date_added like '%$search%' or date_modified like '%$search%' order by date_modified desc");
			supply_table($query);

			die();
		}

		else{
			$query = $conn->query("SELECT * from (SELECT * from supply where quantity>=0) supply join users on supply.encoder=users.username order by date_modified desc");
			supply_table($query);
		}
	}

	function get_supply_data($supply_id){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from supply join users on supply.encoder=users.username where supply_id='$supply_id'");
		$row = $query->fetch_array();

		$date_modified = new DateTime($row['date_modified']);
		$date_modified = $date_modified->format('M d, Y');
	?>

		<div class="modal-body">
			<h3><strong>Remove supply?</strong></h3>
			
				<div class="input-group">
					<label class="input-group-addon text-bold">Supply Name: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['supply_name']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Brand: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['brand']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Quantity: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['quantity']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Unit: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['unit']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Encoded by: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['name']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Last modified: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $date_modified ?>"/>
				</div>
			<form id="remove_supply_verified">
				<input type="hidden" name="id" value="<?= $supply_id ?>"/>
				<br/>
				<div class="modal-footer">
					<input type="submit" name="check_in" class="btn btn-success" value="OK"/>
					<button class="btn btn-danger check_in_verified" data-dismiss="modal" aria-hidden="true">CANCEL</button>
				</div>
			</form>
			
		</div>	

<?php
	}

	function return_supply_data($supply_id){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from supply where supply_id='$supply_id'");
		$row = $query->fetch_array();
		?>


		<form method="post" action="<?php $_PHP_SELF; ?>" class="row">
			<div class="modal-body">
				<div class="form-group col-xs-12">
					<div class="input-group">
						<label for="supply_name" class="input-group-addon">Supply Name</label>
						<input list="supply_names" type="text" name="supply_name" class="form-control" autocomplete="off" autofocus="" value="<?= $row['supply_name'] ?>"/>
							<datalist id="supply_names">
								<?php
									options("supply_name");
								?>
							</datalist>

					</div>
				</div>
				<div class="form-group col-xs-12">
					<div class="input-group">
						<label for="brand" class="input-group-addon">Brand</label>
						<input list="brands" autocomplete="off" type="text" name="brand" class="form-control" value="<?= $row['brand'] ?>" />
							<datalist id="brands">
								<?php
									options("brand");
								?>
							</datalist>
					</div>
				</div>
				<div class="form-group col-xs-6">
					<div class="input-group">
						<label for="quantity" class="input-group-addon">Quantity</label>
						<input type="number" name="quantity" class="form-control" value="<?= $row['quantity'] ?>" />
					</div>
				</div>
				<div class="form-group col-xs-6">
					<div class="input-group">
						<label for="unit" class="input-group-addon">Unit</label>
						<input list="units" autocomplete="off" type="text" name="unit" class="form-control" value="<?= $row['unit'] ?>" />
							<datalist id="units">
								<?php
									options("unit");
								?>
							</datalist>
					</div>
				</div>
				<input type="hidden" name="supply_id" value="<?= $row['supply_id']?>" />
			</div>

			<div class="modal-footer">
				<input type="submit" name="edit_supply" class="btn btn-success check_out_btn" value="Edit"/>
			</div>
		</form>
<?php
	}


	function options($data){
		GLOBAL $conn;
		$query = $conn->query("SELECT DISTINCT $data as data from supply order by $data");

		while ($row= $query-> fetch_array()){
			echo "<option value='".$row['data']."'/>";
		}
	}

	function arrange_table($key){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from (SELECT * from supply where quantity>=0) supply join users on supply.encoder=users.username order by $key");
		supply_table($query);
	}
	?>
</html>