<!DOCTYPE html>
<html>
<head>
	<title>Log-in</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/log_in_style.css"/>
	<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body>

	<?php

		include "php/functions/log_in_functions.php";

		log_in();
	?>
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
					<ul class="nav navbar-nav navbar-right">
						<li class="navbar-link">
							<a href="javascript:void(0)" class="date_time"><span id="date_time"></span></a>
							<script type="text/javascript">window.onload = date_time('date_time');</script>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>

	<div class="container content">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">
			          	<h1 class="text-center">Welcome</h1>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<form method="post" action="<?php $_PHP_SELF; ?>">
						            <div class="input-group">
						            	<label for="username" class="input-group-addon"><span class="glyphicon glyphicon-user"></span></label>
						                <input type="text" name="username" class="form-control input-lg" autofocus="" required="" placeholder="Username" />
						            </div><br/>

						            <div class="input-group">
						            	<label for="password" class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></label>
						                <input type="password" name="password" class="form-control input-lg" required="" placeholder="Password" />
						            </div><br/>

						            <div class="form-group">
						            	<button type="submit" class="btn btn-block btn-lg btn-success" name="log_in"><span class="glyphicon glyphicon-log-in"></span> Login</button>
						            </div>
						        </form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
