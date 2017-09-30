<!DOCTYPE html>
<html>
	<?php
		include "connection.php";

		function equipment_table($query){

	?>
			<div class="table-responsive">
					<table class="table table-hover table-bordered log-list equipment_table">
						<colgroup class="col-numbers"></colgroup>
						<thead>
							<tr>
								<th colspan="2" id="item_name">EQUIPMENT NAME</th>
								<th id="property_number">PROPERTY NUMBER</th>
								<th id="date_added">DATE ADDED</th>
								<th id="name">ENCODED BY</th>
								<th id="equipment_status">STATUS</th>
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
									
						?>
									<tr>
										<td><?php echo $i; ?></td>
										<td class="text-center"><?php echo $row['item_name']; ?></td>
										<td class="text-center"><?= $row['property_number']; ?></td>
										<td class="text-center"><?= $date_added; ?></td>
										<td class="text-center"><?= $row['name'] ?></td>
									<?php
										if($row['equipment_status']=="available"){
											echo "<td class='text-center available'>".$row['equipment_status']."</td>";
										}
										else{
											echo "<td class='text-center text-primary'>".$row['equipment_status']."</td>";
										}
									?>


										<td class="text-center"><button name="edit_equipment" class="btn btn-warning edit_equipment" data-toggle="modal" data-target="#edit_equipment_mod" data-pg="<?php echo $row['property_number']; ?>">edit</button>
											<button name="remove_equipment" class="btn btn-danger remove_equipment btn-inline" data-toggle="modal" data-target="#remove_equipment_mod" data-pg="<?php echo $row['property_number']; ?>">remove</button>
										</td>
									</tr>
									<?php
									$i++;
								}
							}

							else{?>
								<tr><td colspan="7" class="text-center">No item found.</td></tr>

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
				mod_new_equipment();
				mod_edit_equipment();
				mod_remove_equipment();
		}

	function mod_new_equipment(){?>
		<div class="modal fade borrow-modal" id="new_equipment_mod" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header success">
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> New Equipment</h4>
					</div>

					<form method="post" action="<?php $_PHP_SELF; ?>" class="row">
						<div class="modal-body">
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="item_name" class="input-group-addon">Equipment Name</label>
									<input type="text" name="item_name" class="form-control" autofocus="" required="" />
								</div>
							</div>
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="property_number" class="input-group-addon">Property Number</label>
									<input type="text" name="property_number" class="form-control" required="" />
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<input type="submit" name="add_equipment" class="btn btn-success check_out_btn" value="Add"/>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php
	}

	function mod_remove_equipment(){?>
		<div class="modal fade borrow-modal" id="remove_equipment_mod" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header warning">
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-remove"></span> Remove</h4>
					</div>

					<div class="equipment_modal_content"></div>
					
				</div>
			</div>
		</div>

<?php
	}

	function mod_edit_equipment(){?>
			<div class="modal fade borrow-modal" id="edit_equipment_mod" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header success">
							<button class="close" data-dismiss="modal"><span>&times;</span></button>
							<h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Edit Equipment Details</h4>
						</div>

						<div class="equipment_modal_content"></div>
						
					</div>
				</div>
			</div>

<?php
	}

	function search_result_equipment(){
		GLOBAL $conn;
		if(isset($_POST['search_equipment'])){
			$search = $_POST['search_equipment'];
			$query = $conn->query("SELECT * from (SELECT * from equipment where equipment_status='available' or equipment_status='on loan') equipment join users on equipment.encoder=users.username where property_number like '%$search%' or item_name like '%$search%' or equipment_status like '%$search%' or date_added like '%$search%' or name like '%$search%' order by date_added desc");
			equipment_table($query);

			die();
		}

		else{
			$query = $conn->query("SELECT * from (SELECT * from equipment where equipment_status='available' or equipment_status='on loan') equipment join users on equipment.encoder=users.username order by date_added desc");
			equipment_table($query);

		}
	}

	function get_equipment_data($property_number, $action){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from equipment where property_number='$property_number'");
		$row = $query->fetch_array();


		if($row['equipment_status']=="on loan"){?>
			<div class="modal-body">
				<?php
					if($action=='edit'){?>
						<p class="text-center">Equipment is currently on loan and cannot be edited.</p>
						</div>
						<div class="modal-footer">
							<button class="btn btn-success" data-dismiss="modal">OK</button>
				<?php	}
					else{
				?>
				<p class="text-center">Equipment is currently on loan and cannot be removed.</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-warning" data-dismiss="modal">OK</button><?php }?>
			
			</div>

	<?php
		}
		else{
			$date_added = new DateTime($row['date_added']);
			$date_added = $date_added->format('M d, Y');
	?>

		<div class="modal-body">
			<h3><strong>Remove equipment?</strong></h3>
			
				<div class="input-group">
					<label class="input-group-addon text-bold">Equipment Name: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['item_name']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Property Number: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['property_number']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Date Added: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $date_added ?>"/>
				</div>
			<form id="remove_verified">
				<input type="hidden" name="id" value="<?= $property_number ?>"/>
				<br/>
				<div class="modal-footer">
					<input type="submit" name="check_in" class="btn btn-success" value="OK"/>
					<button class="btn btn-danger check_in_verified" data-dismiss="modal" aria-hidden="true">CANCEL</button>
				</div>
			</form>
			
		</div>	

<?php
	}}

	function return_equipment_data($property_number){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from equipment where property_number='$property_number'");
		$row = $query->fetch_array();
		?>


		<form method="post" action="<?php $_PHP_SELF; ?>" class="row">
			<div class="modal-body">
				<div class="form-group col-xs-12">
					<div class="input-group">
						<label for="item_name" class="input-group-addon">Equipment Name</label>
						<input type="text" name="item_name" class="form-control" autofocus="" value="<?= $row['item_name'] ?>" />
					</div>
				</div>
				<div class="form-group col-xs-12">
					<div class="input-group">
						<label for="property_number" class="input-group-addon">Property Number</label>
						<input type="text" name="property_number" class="form-control" value="<?= $row['property_number'] ?>" />
					</div>
				</div>
				<input type="hidden" name="prev_property_number" value="<?= $row['property_number']?>" />
			</div>

			<div class="modal-footer">
				<input type="submit" name="edit" class="btn btn-success check_out_btn" value="Edit"/>
			</div>
		</form>
<?php
	}

	function arrange_table($key){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from (SELECT * from equipment where equipment_status='available' or equipment_status='on loan') equipment join users on equipment.encoder=users.username order by $key");
		equipment_table($query);
	}
	?>
</html>