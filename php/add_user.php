<!DOCTYPE html>
<html>
<head>
	<title>Equipment Logs</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/main.css"/>
	<link rel="icon" href="../images/Unibersidad_ng_Pilipinas.png"/>
	<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>
	<script type="text/javascript" src="../js/equipment_log.js"></script>
	<script type="text/javascript" src="../js/jquery-paginate.js"></script>
	<?php
		require "functions/add_user_functions.php";
	 ?>
</head>
<body>
	<div class="container" >
		<div class="navbar">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="../index.php">DPSM Inventory</a>
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
									<li><a href="javascript:void(0)"><span class="glyphicon glyphicon-th-list"></span>Logs</a></li>
									<li><a href="equipment_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li><a href="equipment_history.php"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
								</ul>
							</li>
							<li class="dropdown log"><a href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span> Supplies<span class="caret"></span></a>
								<ul class="dropdown-menu log-menu">
									<li><a href="supply_inventory.php"><span class="glyphicon glyphicon-book"></span> Inventory</a></li>
									<li><a href="supply_history.php"><span class="glyphicon glyphicon-list-alt"></span> History</a></li>
									<li><a href="check_out_supply.php"><span class="glyphicon glyphicon-check"></span>Check Out Supply</a></li>
								</ul>
							</li>
							<li><a href="#">Manage Account <?php echo $_SESSION['user']['type'] ?></a></li>
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
		<div class="row">
			<div class="col-sm-6 col-lg-6 col-sm-offset-3">
				<div class="panel">
					<div class="panel-heading text-center">
						<h3>Add Account</h3>
					</div>
					<div class="panel-body">
						<form method="post" action="<?php $_PHP_SELF;?>">
							<div class="form-group <?php if($username_error){echo "has-error";}?> has-feedback">
							<label class="control-label" for="username">Username <?=$username_error?></label>
								<input class="form-control" type="text" id="username" name="username" required/>
								<?php if($username_error){?>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								<?php } ?>
							</div>
							<div class="form-group has-feedback <?php if($name_error){echo "has-error";}?>">
								<label class="control-label">Name <?=$name_error?></label>
								<input class="form-control" type="text" id="name" name="name" required/>
								<?php if($name_error){?>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								<?php } ?>
							</div>
							<div class="form-group">
								<label class="">Password</label>
								<input class="form-control" type="password" id="password" name="password" required>
							</div>
							<div class="form-group">
								<label for="type">Account Type</label>
							</div>
							<div class="form-group">
								<select class="form-control" name="type">
									<option value="user">User</option>
									<option value="admin">Admin</option>
								</select>
							</div>
							<div class="from-group">
								<input name="submit" type="submit" class="btn btn-primary" />
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php

			?>
		</div>
	</div>
</body>
