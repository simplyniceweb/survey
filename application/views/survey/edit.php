<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::Survey</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
<?php include(__DIR__ . "/../includes/header.php"); ?>

<div class="container">
	<div class="row">
	<?php if(isset($_GET['edit']) && $_GET['edit'] == 'true'): ?>
        <div class="alert alert-success">Activity has been updated successfuly!</div>
    <?php endif; ?>
    <?php echo form_open_multipart('survey/edit?id='.$act_id); ?>
    	<?php foreach($activity->result() as $act ) {} ?>
    	<div class="col-sm-4">
            <div class="panel panel-primary">
            
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Activity</h3>
                </div>
                
                <div class="panel-body">
                    <div class="form-group">
                    	<label for="activity_category"><small>Activity Category</small></label>
                        <select name="activity_category" id="activity_category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option <?php if($act->activity_category == 0):?> selected="selected"<?php endif; ?>value="0">General</option>
                            <?php foreach($department as $did) { ?>
                            <option <?php if($act->activity_category == $did->department_id):?>selected="selected"<?php endif; ?> value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if($act->only_survey == 0) { ?>
                    <div class="form-group">
                    	<label for="activity_title"><small>Activity Title</small></label>
                    	<input type="text" name="activity_title" id="activity_title" class="form-control" value="<?php echo $act->activity_title; ?>" required="required">
                    </div>
                    
                    <div class="form-group">
                    	<label for="activity_description"><small>Activity Description</small></label>
                    	<textarea name="activity_description" id="activity_description" class="form-control" required><?php echo $act->activity_description; ?></textarea>
                    </div>

                    <div class="form-group">
                    	<label for="activity_photos"><small>Activity Photos</small></label>
                    	<input type="file" name="activity_photos[]" id="activity_photos" class="form-control" multiple>
                    </div>
                    <?php } ?>
                    <?php if($act->only_survey == 1) { ?>
                        <input type="hidden" name="has_activity" value="1" checked />
                    <?php } ?>
                    <button type="submit" class="btn btn-success pull-right">Update</button>
                </div>
             </div>
        </div>
        
        <?php if(!is_null($survey)) { foreach($survey as $srv) { ?>
     	<div class="col-sm-4">
            <div class="panel panel-primary survey">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Survey</h3>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
                    	<label for="survey_title"><small>Survey Title</small></label>
                    	<input type="text" id="survey_title" name="survey_title" value="<?php echo $srv->survey_title; ?>" class="form-control">
                    </div>
                    
                    <div class="form-group">
                    	<label for="survey_description"><small>Survey Question</small></label>
                    	<textarea name="survey_description" id="survey_description" class="form-control"><?php echo $srv->survey_description; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="survey_end"><small>Survey End Date</small></label>
                        <input type="date" id="survey_end" name="survey_end" value="<?php if($srv->survey_end != "0000-00-00") echo date("Y-m-d", strtotime($srv->survey_end)); ?>" class="form-control"/>
                    </div>
             	</div>
             </div>
        </div>
       <?php
			} } 
       ?>
       <?php echo form_close(); ?>
 
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/admin.js"></script>
</body>
</html>
