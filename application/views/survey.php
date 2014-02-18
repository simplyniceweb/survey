<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::Survey</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/styles/design.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
    <style>
	div.survey { display: none }
	</style>
</head>
<body>
<?php require_once('includes/header.php'); ?>	

<div class="container">
	<div class="row">
	<?php if(isset($_GET['add']) && $_GET['add'] == 'true'): ?>
        <div class="alert alert-success">Survey has been added successfuly!</div>
    <?php endif; ?>
    <?php echo form_open_multipart('survey/add'); ?>
    	<div class="col-sm-4">
            <div class="panel panel-primary">
            
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Activity</h3>
                </div>
                
                <div class="panel-body">

                    <div class="form-group">
                        <label for="only_survey"><small>Check if you want survey only.</small></label>
                    	<br>
                        <input type="checkbox" name="has_activity" id="only_survey" class="only-survey" value="0">
                    </div>

                    <div class="form-group">
                    	<label for="activity_category"><small>Activity Category</small></label>
                        <select name="activity_category" id="activity_category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="0">General</option>
                            <?php foreach($department as $did) { ?>
                            <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-activity">
						<div class="form-group">
							<label for="activity_title"><small>Activity Title</small></label>
							<input type="text" name="activity_title" id="activity_title" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="activity_description"><small>Activity Description</small></label>
							<textarea name="activity_description" id="activity_description" class="form-control"></textarea>
						</div>
						
						<div class="form-group">
							<label for="activity_photos"><small>Activity Photos</small></label>
							<input type="file" name="activity_photos[]" id="activity_photos" class="form-control" multiple>
						</div>
						
						<div class="form-group">
							<label for="activity_survey"><small>Would you like to add a survey for this activity?</small></label>
							<br>
							<input type="checkbox" name="has_survey" id="activity_survey" class="survey-interface" value="0">
						</div>
					</div>
                    
                    <button type="submit" class="btn btn-success pull-right">Store</button>
                </div>
             </div>
        </div>

    	<div class="col-sm-4">
            <div class="panel panel-primary survey">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Survey</h3>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
                    	<label for="survey_title"><small>Survey Title</small></label>
                    	<input type="text" id="survey_title" name="survey_title" class="form-control">
                    </div>
                    
                    <div class="form-group">
                    	<label for="survey_description"><small>Survey Question</small></label>
                    	<textarea name="survey_description" id="survey_description" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group"><button type="button" class="btn btn-success add-question">Add Answer</button></div>
                    
                    <div class="form-group input-group this-remove-1">
                      <input type="text" name="questions[]" class="form-control" autocomplete="off" placeholder="Answer #1">
                      <span data-remove="1" class="input-group-addon remove-question">
                      	<a href="javascript: void(0);">Remove</a>
                      </span>
                    </div>

                    <div class="form-group">
                        <label for="survey_end"><small>Survey End Date</small></label>
                        <input type="date" id="survey_end" name="survey_end" value="" class="form-control"/>
                    </div>
             	</div>
             </div>
        </div>
    <?php echo form_close(); ?>
    
 
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/admin.js"></script>
</body>
</html>
