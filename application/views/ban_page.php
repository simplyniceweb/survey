<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::Student Number</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/styles/select2.css"/>
    <style>
		.design { border: 0 !important; padding:0 !important; margin:0 !important }
	</style>
</head>
<body>
<?php require_once('includes/header.php'); ?>	
    
<div class="container">
	<div class="row">
    
	<?php if(isset($_GET['action']) && $_GET['action'] == "true") { ?>
    <div class="alert alert-success">Success.</div>
    <?php }?>

    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ban Student</h3>
                </div>
                
                <div class="panel-body">
                    <?php echo form_open('ban/process'); ?>
					
					<?php if(isset($_GET['date']) && $_GET['date'] == "less"): ?>
					<div class="list-group-item">
						<div class="alert alert-danger">
							<small>Unban date should not be less than the date today.</small>
						</div>
					</div>
					<?php endif; ?>
					<?php if(isset($_GET['date']) && $_GET['date'] == "eq"): ?>
					<div class="list-group-item">
						<div class="alert alert-danger">
							<small>Unban date should not be equal than the date today.</small>
						</div>
					</div>
					<?php endif; ?>

                    <div class="form-group">
                        <label for="department_id"><small>Course</small></label>
                        <select id="department_id" class="form-control design department-id" name="department_id" data-action="0" required="required">
                            <option value="">Choose Course</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="student_id0"><small>Student Name</small></label>
                        <select id="student_id0" class="form-control design" name="student_id" required="required">
                            <option value="">Choose Student</option>
                        </select>
                    </div>
					<div class="form-group">
					<label for="unban-date"><small>Unban date</small></label>
					<input type="date" id="unban-date" class="form-control" name="unban_date"/>
					</div>
                    <button type="button" class="btn btn-success banunban" data-action="1">Ban</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
		
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Unban Student</h3>
                </div>
                
                <div class="panel-body">
                   <form role="form" method="post" accept-charset="utf-8" class="form-update">
                    <div class="form-group">
                        <label for="department_id"><small>Department</small></label>
                        <select id="department_id" class="form-control design department-id" name="department_id" data-action="1" required="required">
                            <option value="">Choose Department</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="student_id1"><small>Student Name</small></label>
                        <select id="student_id1" class="form-control design" name="student_id" required="required">
                            <option value="">Choose Student</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-success banunban" data-action="0">Unban</button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/select2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/admin.js"></script>
</body>
</html>