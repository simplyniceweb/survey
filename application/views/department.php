<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>Student Number</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
<?php require_once('includes/header.php'); ?>	
<div class="container">
	<div class="row">
    
	<?php if(isset($_GET['exist']) && $_GET['exist'] == "true") { ?>
    <div class="alert alert-danger">The Course that you added is already in the database.</div>
    <?php } else if(isset($_GET['add']) && $_GET['add'] == "true") { ?>
    <div class="alert alert-success">Course has been added successfully!</div>
	<?php } ?>

    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Course</h3>
                </div>
                
                <div class="panel-body">
                    <?php echo form_open('department/department_add'); ?>
                    <div class="form-group">
                    <label for="student_id_text"><small>Course Name</small></label>
                    <input type="text" id="student_id_text" class="form-control" name="department_name">
                    </div>
                    <button type="submit" class="btn btn-success">Store</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        
        
    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Course</h3>
                </div>
                
                <div class="panel-body">
                    <?php echo form_open('department/department_edit'); ?>
                    <div class="form-group">
                        <label for="student_id_edit"><small>Course Name</small></label>
                        <select id="student_id_edit" class="form-control" name="department_name">
                            <option value="0">Select To Edit Course</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                     <div class="form-group">
                     	<label for="student_id_new"><small>New Course Name</small></label>
                    	<input type="text" id="student_id_new" name="new_department_name" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        
    	<div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Delete Course</h3>
                </div>
                
                <div class="panel-body">
                <?php echo form_open('department/department_delete'); ?>
                <div class="form-group">
                	<label for="student_id_delete"><small>Course Name</small></label>
                    <select id="student_id_delete" class="form-control" name="department_name">
                        <option value="0">Select To Delete Course</option>
                        <?php foreach($department as $did) { ?>
                        <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
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

<?php require_once('includes/footer.php'); ?>
</body>
</html>
