<!DOCTYPE html>
<html>
<head>
	<title>Check Out Supply</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/main.css"/>
	<link rel="stylesheet" type="text/css" href="../css/check_out_supply_style.css"/>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>
	<script type="text/javascript" src="../js/check_out_supply_script.js"></script>
	<script type="text/javascript" src="../js/jquery-paginate.js"></script>


	<?php
		require "functions/connection.php";
		include "functions/insert_update_functions.php";
		include "functions/view_functions.php";
		include "functions/check_out_supply_functions.php";

		check_entries();
		delete_unsaved_log();
	?>
</head>
<body>

	<div class="container">
		<div class="navbar">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">DPSM Inventory</a>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					</div>
					<div class="collapse navbar-collapse" id="navbar">
						<ul class="nav navbar-nav">
							<li class="log"><a href="javascript:void(0)" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span> Equipment<span class="caret"></span></a>
								<ul class="dropdown-menu log-menu">
									<li><a href="equipment_logs.php"><span class="glyphicon glyphicon-th-list"></span>Logs</a></li>
									<li><a href="equipment_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li><a href="equipment_history.php"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
								</ul>
							</li>
							<li class="dropdown log active"><a href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> Supplies<span class="caret"></span></a>
								<ul class="dropdown-menu log-menu">
									<li><a href="supply_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li><a href="supply_history.php"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
									<li class="active"><a href="javascript:void(0)"><span class="glyphicon glyphicon-check"></span>Check Out Supply</a></li>
								</ul>
							</li>
							<li><a href="manage_accounts.php">Manage Account <?php echo $_SESSION['user']['type'] ?></a></li>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<li class="navbar-link">
								<a href="javascript:void(0)" class="date_time"><span id="date_time"></span></a>
								<script type="text/javascript">window.onload = date_time('date_time');</script>
							</li>
							<li data-toggle="tooltip" data-placement="bottom" title="log-out"><a href="log_out.php"><span class="glyphicon glyphicon-off"></span></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>

		<div class="row top-functions">
			<div class=" col-sm-7">
				<div class="panel panel-success">
					<div class="panel-body">
						<form method="post" action="<?php $_PHP_SELF; ?>">
							<div class="input-group">
								<label for="reciever" class="input-group-addon">Recieved by:</label>
								<input list="recievers" autocomplete="off" type="text" name="reciever" id="reciever" class="form-control" autofocus="" required="" value="<?php place_value();?>"/>
								<datalist id="recievers">
									<?php recievers() ?>
								</datalist>
							</div>
							<hr/>
							<div class="col-sm-12">
								<div id="supply_list">
									<div class="col-xs-12">
										<input list="supplies_data" type="text" name="supply_name" id="supply_name" class="form-control" placeholder="Search supply..." required="" autocomplete="off" />
										<datalist id="supplies_data">
											<?php suggestions() ?>
										</datalist>
									</div>
									<!-- <div class="col-xs-12 col-md-3">
										<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" min="1" required="" />
									</div>

									<button type="submit" class="btn btn-success col-md-1 col-md-offset-0 col-xs-12 col-sm-10 col-sm-offset-1" id="supply_out"><span class="glyphicon glyphicon-ok"></span></button> -->
								</div><br/>

								<div id="supplies"></div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-5">
				<div class="panel panel-primary">
					<div class="panel-heading">Supplies ready for check out.</div>
					<div class="list_supplies">
						<p class="prompt text-center">No Items Selected.</p>
					</div>
					<button class="btn btn-success" id="check_out_all"><span class="glyphicon glyphicon-check"></span>Check out supplies</button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
