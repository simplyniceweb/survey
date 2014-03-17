<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>Web Based Generator::Registration</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/datepicker.css">
	<style>
	.page-header {
		border-bottom: 1px solid #FFFFFF;
		margin: 20px 0;
		padding-bottom: 9px;
		text-align: center;
	}

	.form-control {
		border: 1px solid #D6D6D6;
		border-radius: 0;
		box-shadow: none;
		height: 50px;
		padding: 6px 15px;
	}

	body {
		background-color: #ee7778;
	}

	.row {
		background: #ededed;
		padding: 20px 50px 20px 50px;
		margin: 100px;
	}

	legend {
		border: medium none;
		color: #7F7F7F;
		display: block;
		font-size: 20px;
		line-height: inherit;
		margin-bottom: 15px;
		padding: 0;
		text-align: center;
		width: 100%;
	}

	.btn {
		padding: 10px;
		border-radius: 0;
		border: none;
		font-size: 21px;
	}
	</style>
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
		<?php if(isset($_GET['email']) && $_GET['email'] == "exist"): ?>
		<div class="col-sm-12">
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Email does exist!</small>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($_GET['std_id']) && $_GET['std_id'] == "invalid"): ?>
		<div class="col-sm-12">
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Invalid Student Number!</small>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($_GET['used_id']) && $_GET['used_id'] == "true"): ?>
		<div class="col-sm-12">
		<div class="list-group-item">
			<div class="alert alert-danger">
				<small>Invalid Student Number!</small>
			</div>
		</div>
		</div>
		<?php endif; ?>

		<?php if(isset($_GET['add']) && $_GET['add'] == "true"): ?>
		<div class="col-sm-12">
		<div class="list-group-item">
			<div class="alert alert-success">
				<small>Successful registration!</small>
				<br>
				<a href="">Sign In!</a>
			</div>
		</div>
		</div>
		<?php endif; ?>
		<?php echo form_open('index/process',array('class' => 'form-horizontal')); ?>
        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
        <?php if($action == 0) { ?>
			<legend>
            <h3>Exclusive for Binalbagan Catholic College only.</h3>
            <h3>REGISTER</h3> <a class="col-md-12" href="">Have an account? Sign In!</a>
            </legend>
		<?php } else { ?>
			<legend>
            <h3>Exclusive for Binalbagan Catholic College only.</h3>
            <h3>Create Admin account.</h3>
            </legend>
        <?php } ?>
			<div class="list-group-item">
				<label><small>Student Number</small></label>
				<input type="text" name="user_std_id" class="form-control" required="required" placeholder="Student Number" autofocus>
			</div>

			<div class="list-group-item">
				<label><small>Full Name</small></label>
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
				<input type="date" name="user_birthday" class="form-control" required="required" placeholder="Birthday">
			</div>

			<div class="list-group-item">
				<button class="btn btn-primary btn-block">
					<small>Register</small>
				</button>
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>

</div>
</body>
</html>
