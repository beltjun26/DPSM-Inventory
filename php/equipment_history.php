<!DOCTYPE html>
<html>
<head>
	<title>History</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/main.css"/>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>
	<script type="text/javascript" src="../js/equipment_history.js"></script>
	<script type="text/javascript" src="../js/jquery-paginate.js"></script>


	<?php
		require "functions/connection.php";
		include "functions/insert_update_functions.php";
		include "functions/view_functions.php";
		include "functions/equipment_history_functions.php";

		unset($_SESSION['first_entry']);
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
							<li class="active log"><a href="javascript:void(0)" data-toggle="dropdown"><span class="glyphicon glyphicon-th-list"></span> Equipment<span class="caret"></span></a>
								<ul class="dropdown-menu log-menu">
									<li><a href="equipment_logs.php"><span class="glyphicon glyphicon-th-list"></span>Logs</a></li>
									<li><a href="equipment_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li class="active"><a href="javascript:void(0)"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
								</ul>
							</li>
							<li class="dropdown log"><a href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> Supplies<span class="caret"></span></a>
								<ul class="dropdown-menu log-menu">
									<li><a href="supply_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li><a href="supply_history.php"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
									<li><a href="check_out_supply.php"><span class="glyphicon glyphicon-check"></span>Check Out Supply</a></li>
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
			<div class="col-sm-4">
				<form id="search_form" method="post" action="<?php $_PHP_SELF; ?>">
					<div class="input-group">
						<input type="text" name="search_history" id="search_history" class="form-control" placeholder="Search table..."  value="<?php place_value();?>"/>
						<div class="input-group-btn">
							<button type="submit" class="btn btn-primary" id="search_btn"><span><i class="glyphicon glyphicon-search"></i></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="datetime"></div>
		<div class="row">
			<div class="content_area col-xs-12 col-sm-12 col-md-12 sol-lg-12 table">
				<?php search_result_history(); ?>
			</div>
		</div>
	</div>

</body>
</html>
