<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::<?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
	<style>
		.mainpage { background: #FFF }
	</style>
</head>
<body>
<?php require_once('includes/header.php'); ?>

<div class="container mainpage">
    <div class="row">
        <div class="col-md-12">
			<legend><h3>Edit user</h3></legend>
			<div class="form-group">
				<label for="department_id"><small>Course</small></label>
				<select id="department_id" class="edit-user form-control" name="department_id" required="required">
					<option value="">Choose Course</option>
					<?php foreach($department as $did) { ?>
					<option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="col-md-12 users-list">
			</div>

        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/mainpage.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/admin.js"></script>
</body>
</html>
