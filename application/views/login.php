<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::-</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/styles/design.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
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
</head>
<body>
<div class="container">
<div class="row">
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
  <div class="page-header"><h2>Login Form</h2></div>
	<?php echo form_open('index/verify',array('class' => 'form-horizontal')); ?>
    <fieldset>

      <!-- Form Name -->
      <legend><h3>No account yet? <a href="register">Register!</a></h3></legend>

      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-1 control-label" for="username"></label>  
        <div class="col-md-12">
          <input id="username" name="user_email" type="text" required="required" placeholder="Email Address" class="form-control input-md">
        </div>
      </div>

      <!-- Password input-->
      <div class="form-group">
        <label class="col-md-1 control-label" for="password"></label>
        <div class="col-md-12">
          <input id="password" name="user_password" type="password" required="required" placeholder="Password" class="form-control input-md">
        </div>
      </div>

      <!-- Button (Double) -->
      <div class="form-group">
        <label class="col-md-1 control-label" for="login"></label>
      <div class="col-md-12">
        <button id="login" name="login" class="btn btn-block btn-success">Login</button>
      </div>
    </fieldset>
  </form>
</body>
</html>
