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
    
	<?php if(isset($_GET['exist']) && $_GET['exist'] == "true") { ?>
    <div class="alert alert-danger">The student number that you added is already in the database.</div>
    <?php } else if(isset($_GET['unique']) && $_GET['unique'] == "false") { ?>
    <div class="alert alert-danger">Please enter a unique Student number.</div>
	<?php } ?>

    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Student Number</h3>
                </div>
                
                <div class="panel-body">
                    <?php echo form_open('studentnumber/student_no_add'); ?>
                    <div class="form-group">
                        <label for="department_id"><small>Department</small></label>
                        <select id="department_id" class="form-control design" name="department_id" required="required">
                            <option value="">Choose Department</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="student_id_text"><small>Student Number</small></label>
                    <input type="text" id="student_id_text" class="form-control" name="student_id">
                    </div>
                    <button type="submit" class="btn btn-success">Store</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        
        
    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Student Number</h3>
                </div>
                
                <div class="panel-body">
                    <?php echo form_open('studentnumber/student_no_edit'); ?>
                    <div class="form-group">
                        <label for="department_id"><small>Department</small></label>
                        <select id="department_id" class="department-pick form-control design" name="department_id" required="required">
                            <option value="">Choose Department</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="student_id_edit"><small>Student Number</small></label>
                        <select id="student_id_edit" class="form-control design" name="student_id">
                            <option value="0">Select To Edit Student Number</option>
                            <?php foreach($student_id as $sid) { ?>
                            <option value="<?php echo $sid->unique; ?>"><?php echo $sid->unique; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                     <div class="form-group">
                     	<label for="student_id_new"><small>New Student Number</small></label>
                    	<input type="text" id="student_id_new" name="new_student_id" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        
    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Delete Student Number</h3>
                </div>
                
                <div class="panel-body">
                <?php echo form_open('studentnumber/student_no_delete'); ?>
                <div class="form-group">
                	<label for="student_id_delete"><small>Student Number</small></label>
                    <select id="student_id_delete" class="form-control design" name="student_id">
                        <option value="0">Select To Delete Student Number</option>
                        <?php foreach($student_id as $sid) { ?>
                        <option value="<?php echo $sid->student_id; ?>"><?php echo $sid->unique; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger">Delete</button>
                <?php echo form_close(); ?>
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