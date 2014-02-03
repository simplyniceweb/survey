<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::-</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
</head>
<body>

<div id="container">

	<div class="row">
		<div class="col-sm-4 col-md-offset-4">

		<?php if(isset($_GET['login']) && $_GET['login'] == "false"): ?>
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Please provide the right credentials.</small>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($_GET['ban']) && $_GET['ban'] == "true"): ?>
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>An adminastrator blocked you from viewing this system.</small>
			</div>
		</div>
		<?php endif; ?>
		
		<?php echo form_open('index/verify'); ?>
			<legend><h4>LOGIN</h4></legend>

			<div class="list-group-item">
				<label><small>Email Address</small></label>
				<input type="email" name="user_email" class="form-control" required="required" placeholder="Email Address">
			</div>

			<div class="list-group-item">
				<label><small>Password</small></label>
				<input type="password" name="user_password" class="form-control" required="required" placeholder="Password">
			</div>
			
			<div class="list-group-item">
				<button class="btn btn-primary btn-block">
					<small>Log In</small>
				</button>
			</div>
			
			<a class="col-md-offset-4" href="register">No account yet? Register!</a>
		<?php echo form_close(); ?>
		</div>
	</div>

</div>
</body>
</html>