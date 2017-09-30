<!DOCTYPE html>
<html>
	<?php
		require "connection.php";

		function logs_table($query){
	?>

			<div class="table-responsive">
					<table class="table table-hover table-bordered log-list" id="equipment_log_table">
						<colgroup class="col-numbers"></colgroup>
						<thead>
							<tr>
								<th colspan="2" id="borrower_name">NAME</th>
								<th id="borrower_id">ID</th>
								<th id="item_name">ITEM</th>
								<th id="borrow_time">DATE &amp; TIME</th>
								<th id="due_time">DUE</th>
								<th id="">REMAINING TIME</th>
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
									$dt_borrow = new DateTime($row['borrow_time']);
									$date_borrow = $dt_borrow->format('M d, Y');
									$time_borrow = $dt_borrow->format('g:i A');

									$dt_due = new DateTime($row['due_time']);
									$date_due = $dt_due->format('M d, Y');
									$time_due = $dt_due->format('g:i A');

									
						?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['borrower_name']; ?><span class="badge badge-error" title="number of overdues" data-toggle="tooltip" data-placement="right"><?= overdue_count($row['borrower_id']);?></span></td>
										<td class="text-center"><?= $row['borrower_id']; ?></td>
										<td class="text-center"><?= $row['item_name']; ?></td>
										<td class="text-center"><?= $date_borrow;?><span class="time"><small><?= $time_borrow; ?></small></span></td>
										<td class="text-center"><?= $date_due;?><span class="time"><small><?= $time_due; ?></small></span></td>
										<td class="text-center"><span id="<?= $row['log_num']; ?>">xxx</span></td>

										<script type="text/javascript">window.onload = remain('<?= $row['due_time'] ?>', '<?= $row['log_num'] ?>');</script>
										<td class="text-center"><?= $row['name']?></td>
										<td><button name="check-in" class="btn btn-warning check_in" data-toggle="modal" data-target="#verify_check_in_mod" data-pg="<?php echo $row['log_num']; ?>">check-in</button>
										</td>
									</tr>
									<?php
									$i++;
								}
							}

							else{?>
								<tr><td colspan="9" class="text-center">No logs found.</td></tr>

						<?php	}
						?>
						</tbody>
					</table>
					<script type="text/javascript">
						$('.log-list').paginate({
				    		limit: 20,
					    	onSelect: function(obj, page) {
					     	console.log('Page ' + page + ' selected!' );}
						});
					</script>
				</div>

	<?php
				mod_new_borrower();	
				mod_check_in();
		}

		function mod_new_borrower(){?>
			<div class="modal fade borrow-modal" id="new_borrower_mod" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header success">
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> New Borrower</h4>
					</div>

					<form method="post" action="<?php $_PHP_SELF; ?>" class="row">
						<div class="modal-body">
						<?php 
						GLOBAL $conn;
						$query = $conn->query("SELECT * from equipment where equipment_status='available'");

						$num_rows = mysqli_num_rows($query);
						if($num_rows>0){

						?>
						
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="name" class="input-group-addon">Name</label>
									<input type="text" name="name" class="form-control" autofocus="" required="" />
								</div>
							</div>
							<div class="form-group col-xs-12">
								<div class="input-group">
									<label for="id" class="input-group-addon">ID</label>
									<input type="text" name="id" class="form-control" required="" />
								</div>
							</div>

							<div class="form-group col-xs-8">
								<div class="input-group">
									<label for="item" class="input-group-addon" required>Item</label>
									<?php selection(); ?>
								</div>
							</div>

							<div class="form-group col-xs-4">
								<div class="input-group">
									<label for="duration" class="input-group-addon">Duration</label>
									<input type="number" name="duration" min="1" max="5" class="form-control" placeholder="hrs" required="" />
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<input type="submit" name="check_out" class="btn btn-success check_out_btn" value="Check-out"/>
						</div>
						<?php } 

					 else{ ?>
							<div class='text-center'>No available equipment at the moment.</div>
						</div>

						<div class="modal-footer">
							<button class="btn btn-success check_out_btn" data-dismiss="modal">OK</button>
						</div>
					<?php } ?>
						
						
					</form>
				</div>
			</div>
		</div>

<?php
		}


		function mod_check_in(){?>
			<div class="modal fade" id="verify_check_in_mod">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header warning">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Verification</h4>
						</div>
						<div class="modal_content">
							
						</div>
					</div>
				</div>
			</div>

<?php
		}

		function selection(){
			GLOBAL $conn;

			$query = $conn->query("SELECT * from equipment where equipment_status='available'");

			echo "<select name='item' class='form-control'>";
			while($row= $query-> fetch_array()){

				echo "<option value='".$row['property_number']."'>".$row['item_name']."</option>";
			}
			echo "</select>";

			 
	}


	function query_log_table(){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from equipment_log join (SELECT property_number, item_name from equipment) as equipment on equipment_log.property_number=equipment.property_number join users on equipment_log.encoder=users.username where status='unreturned' order by log_num desc");
		logs_table($query);
	}

	function search_result(){
		GLOBAL $conn;
		if(isset($_POST['search'])){
			$search = $_POST['search'];
			$query = $conn->query("SELECT * from (SELECT * from equipment_log where status='unreturned') as log join (SELECT property_number, item_name from equipment) as equipment on log.property_number=equipment.property_number join users on log.encoder=users.username where borrower_name like '%$search%' or borrower_id  like '%$search%' or item_name  like '%$search%' or borrow_time  like '%$search%' or due_time like '%$search%' or name like '%$search%' order by log_num desc");
			logs_table($query);

			die();
		}

		else{
			query_log_table();
		}
	}

	function get_return_data($log_num){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from (SELECT * from equipment_log where log_num='$log_num') as log join equipment on log.property_number=equipment.property_number");
		$row = $query->fetch_array();?>


		<div class="modal-body">
			<p>Return item <strong><?=$row['item_name'];?></strong>?</p>
			
				<div class="input-group">
					<label class="input-group-addon text-bold">Borrower: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['borrower_name']?>"/>
				</div>
				<br/>
				<div class="input-group">
					<label class="input-group-addon text-bold">Borrower ID: </label>
					<input type="text" class="form-control disabled" disabled value="<?= $row['borrower_id']?>"/>
				</div>
			<form id="check_in_verified">
				<input type="hidden" name="id" value="<?= $log_num ?>"/>
				<br/>
				<div class="modal-footer">
					<input type="submit" name="check_in" class="btn btn-success" value="OK"/>
					<button class="btn btn-danger check_in_verified" data-dismiss="modal" aria-hidden="true">CANCEL</button>
				</div>
			</form>
			
		</div>	


	<?php
	}

	function check_in_success(){
		?>
		<div class="alert alert-success alert-dismissable alert_checked_in text-center">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <span><strong>Equipment returned sucessfully!</strong></span>
		</div>

	<?php

		$_SESSION['check_in'] = 0;

	}

	function overdue_count($id){
		GLOBAL $conn;
		$query = $conn ->query("SELECT count(*) as count from equipment_log where status='overdue' and borrower_id='$id'");
		$row= $query-> fetch_array();
		$overdue_count = $row['count'];

		if ($overdue_count == 0){
			return '';
		}

		return $overdue_count;
	}


	function arrange_table($key){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from equipment_log join (SELECT property_number, item_name from equipment) as equipment on equipment_log.property_number=equipment.property_number join users on equipment_log.encoder=users.username where status='unreturned' order by $key");
		logs_table($query);
	}
	?>

</html>