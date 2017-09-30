<!DOCTYPE html>
<html>
	<?php 
		include "connection.php";

		function history_table($query){

	?>
			<div class="table-responsive">
					<table class="table table-hover table-bordered log-list history_list">
						<colgroup class="col-numbers"></colgroup>
						<thead>
							<th colspan="2" id="borrower_name">BORROWER</th>
							<th id="borrower_id">BORROWER ID</th>
							<th id="item_name">ITEM</th>
							<th id="borrow_time">BORROWED</th>
							<th id="time_returned">RETURNED</th>
							<th id="status">STATUS</th>
							<th id="name">RETURNED TO</th>							
						</thead>
						<tbody>
						<?php 

							$num_rows = mysqli_num_rows($query);
							
							if($num_rows>0){
								$i=1;
								while ($row= $query-> fetch_array()){
									$borrow = new DateTime($row['borrow_time']);
									$borrow_date = $borrow->format('M j, Y');
									$borrow_time = $borrow->format('g:i A');

									$returned = new DateTime($row['time_returned']);
									$day_returned = $returned->format('M j, Y');
									$time_returned = $returned->format('g:i A');


									
						?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['borrower_name']; ?></td>
										<td class="text-center"><?= $row['borrower_id']; ?></td>
										<td class="text-center"><?= $row['item_name'];?></td>
										<td class="text-center"><?= $borrow_date ?><span class="time"><small><?= $borrow_time; ?></small></span></td>
										<td class="text-center"><?= $day_returned?><span class="time"><small><?= $time_returned; ?></small></span></td>

									<?php
										if($row['status']=="overdue"){
											echo "<td class='text-center text-error'>".$row['status']."</td>";
									}
										else{
											echo "<td class='text-center'>".$row['status']."</td>";
										}
									?>
										<td class="text-center"><?= $row['name'] ?></td>
									</tr>
									<?php
									$i++;
								}
							}

							else{?>
								<tr><td colspan="8" class="text-center">No item found.</td></tr>

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


	function search_result_history(){
		GLOBAL $conn;
		if(isset($_POST['search_history'])){
			$search = $_POST['search_history'];
			$query = $conn->query("SELECT * from (SELECT * from equipment_log where status='on time' or status='overdue') as log join (SELECT item_name, property_number from equipment) as equipment on log.property_number=equipment.property_number join users on users.username=log.returned_to where borrower_name like '%$search%' or borrower_id like '%$search%' or item_name like '%$search%' or borrow_time like '%$search%' or time_returned like '%$search%' or status like '%$search%' or name like '%$search%' order by time_returned desc");
			history_table($query);

			die();
		}

		else{
			$query = $conn->query("SELECT * from equipment_log join (SELECT item_name, property_number from equipment) as equipment on equipment_log.property_number=equipment.property_number join users on users.username=equipment_log.returned_to where status='on time' or status='overdue' order by time_returned desc");
			history_table($query);

		}
	}

	function arrange_table($key){
		GLOBAL $conn;
		$query = $conn->query("SELECT * from equipment_log join (SELECT item_name, property_number from equipment) as equipment on equipment_log.property_number=equipment.property_number join users on users.username=equipment_log.returned_to where status='on time' or status='overdue' order by $key");
		history_table($query);
	}
	?>
</html>