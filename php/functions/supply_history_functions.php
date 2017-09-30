<!DOCTYPE html>
<html>
	<?php 
		include "connection.php";

		function supply_history_table($query){

	?>
			<div class="table-responsive">
					<table class="table table-hover table-bordered log-list history_list">
						<colgroup class="col-numbers"></colgroup>
						<thead>
							<th colspan="2" id="imbursed_to">RECIEVER</th>
							<th id="supply_name">ITEM</th>
							<th id="quantity_out">QUANTITY</th>
							<th id="date_imbursed">DATE</th>
							<th id="name">IMBURSED BY</th>							
						</thead>
						<tbody>
						<?php 

							$num_rows = mysqli_num_rows($query);
							
							if($num_rows>0){
								$i=1;
								while ($row= $query-> fetch_array()){
									$date_in = new DateTime($row['date_imbursed']);
									$date = $date_in->format('M j, Y');
									$time = $date_in->format('g:i A');
									
						?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['imbursed_to']; ?></td>
										<td class="text-center">
											<span><?= $row['supply_name'] ?></span> - 
											<span><?= $row['brand']?></span>
										</td>
										<td class="text-center">
											<span><?= $row['quantity_out'] ?></span>
											<span><?= $row['unit'] ?></span>
										</td>
										<td class="text-center">
											<?= $date?>
											<span class="time"><small><?= $time; ?></small></span>
										</td>
										<td class="text-center"><?= $row['name'] ?></td>
									</tr>
									<?php
									$i++;
								}
							}

							else{?>
								<tr><td colspan="6" class="text-center">No item found.</td></tr>

						<?php	}
						?>
						</tbody>
					</table>
				</div>	
				<script type="text/javascript">
					$('.history_list').paginate({
			    		limit: 25,
				    	onSelect: function(obj, page) {
				     	console.log('Page ' + page + ' selected!' );}
					});
				</script>					

	<?php
		}


	function search_result_supply_history(){
		GLOBAL $conn;
		if(isset($_POST['search_supply_history'])){
			$search = $_POST['search_supply_history'];
			$query = $conn->query("SELECT * from supply_log join supply on supply_log.supply_id = supply.supply_id join users on users.username = supply_log.imbursed_by where imbursed_to like '%$search%' or supply_name like '%$search%' or brand like '%$search%' or quantity_out like '%$search%' or date_imbursed like '%$search%' or name like '%$search%' order by date_imbursed desc");
			supply_history_table($query);

			die();
		}

		else{
			$query = $conn->query("SELECT * from supply_log join supply on supply_log.supply_id = supply.supply_id join users on users.username = supply_log.imbursed_by order by date_imbursed desc");
			supply_history_table($query);

		}
	}

	function arrange_table($key){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from supply_log join supply on supply_log.supply_id = supply.supply_id join users on users.username = supply_log.imbursed_by order by $key");
		supply_history_table($query);
	}
	?>
</html>