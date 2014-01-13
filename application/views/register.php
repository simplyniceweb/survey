<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>Web Based Generator::Registration</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/datepicker.css">
	<script src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap-datepicker.js"></script>
	<script>
		$(document).ready(function(){
			$('.datepicker').datepicker();
		});
	</script>
</head>
<body>

<div id="container">

	<div class="row">
		<div class="col-sm-4 col-md-offset-4">
		<?php if(isset($_GET['std_id']) && $_GET['std_id'] == "invalid"): ?>
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Invalid Student Number!</small>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($_GET['used_id']) && $_GET['used_id'] == "true"): ?>
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Invalid Student Number!</small>
			</div>
		</div>
		<?php endif; ?>
	
		<?php if(isset($_GET['add']) && $_GET['add'] == "true"): ?>
		<div class="list-group-item">
			<div class="alert alert-success">
				<small>Successful registration!</small>
				<br>
				<a href="">Sign In!</a>
			</div>
		</div>
		<?php endif; ?>
		<?php echo form_open('index/process'); ?>
			<legend><h4>REGISTER</h4></legend>

			<div class="list-group-item">
				<label><small>Username</small></label>
				<input type="text" name="user_name" class="form-control" required="required" placeholder="Full Name">
			</div>
			
			<div class="list-group-item">
				<label><small>Email Address</small></label>
				<input type="email" name="user_email" class="form-control" required="required" placeholder="Email Address">
			</div>

			<div class="list-group-item">
				<label><small>Password</small></label>
				<input type="password" name="user_password" class="form-control" required="required" placeholder="Password">
			</div>

			<div class="list-group-item">
				<label><small>Birthday</small></label>
				<input type="text" name="user_birthday" class="datepicker form-control" data-date-format="yyyy-mm-dd" required="required" placeholder="Birthday">
			</div>
			
			<div class="list-group-item">
				<label><small>Student Number</small></label>
				<input type="text" name="user_std_id" class="form-control" required="required" placeholder="Student Number">
			</div>

			<div class="list-group-item">
				<button class="btn btn-primary btn-block">
					<small>Register</small>
				</button>
			</div>
			
			<a class="col-md-offset-4" href="">Have an account? Sign In!</a>
		<?php echo form_close(); ?>
		</div>
	</div>

</div>
</body>
</html>