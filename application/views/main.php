<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::<?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
    <style>
        .user-info { background: #f1f1f1; width: 300px; padding: 5px; margin-left: 150px; border-radius: 3px; }
        .user-info p { margin-left: 5px;}
        .user-img { width: 300px; height: 200px;}
		.mainpage { margin-top: 150px; }
		.mainpage .badge { margin-left: 20px }
		.activity-list { margin-top: -4px; }
		.nav-justified {  background: #FFF; border-radius: 4px; padding: 8px }
	</style>
</head>
<body>
<?php require_once('includes/header.php'); ?>
        <div class="col-md-6 col-md-offset-3">
            <h1 style="color:#FFF">Welcome to Web based generator</h1>
        </div>
<div class="container mainpage">
    <div class="row">
        <div class="col-sm-6">
            <div class=" user-info">
            <?php foreach($user as $user) { ?>
            <?php if($user->profile_picture != "") { ?>
            <img src="assets/images/<?php echo $user->profile_picture; ?>" alt="..." class="user-img img-thumbnail">
            <?php } else { ?>
            <img src="assets/images/default.jpg" alt="..." class="user-img img-thumbnail">
            <?php } ?>
            <br>
            <p><?php echo $user->user_name; ?></p>
            <p><?php echo date("M. j, Y", strtotime($user->user_birthday)); ?></p>
            <p><?php echo $user->user_email; ?></p>
            <p><?php echo $user->student_address; ?></p>
            <?php } ?>
            </div>
        </div>
        <div class="col-sm-6">
            <ul class="nav nav-pills nav-justified">
            <?php if($session['user_level'] == 99) { ?>
                <select id="department_id" class="form-control" name="department_id">
                    <option value="">Choose Category</option>
                    <option value="0" selected>General</option>
                    <?php foreach($department as $did) { ?>
                    <option value="<?php echo $did->department_id; ?>"><?php echo $did->department_name; ?></option>
                    <?php } ?>
                </select>
            <?php } else { ?>
				<?php foreach($department as $dept) { ?>
                <li class="active" data-tab-id="<?php echo $dept->department_id; ?>"><a href="javascript: void(0);"><?php echo $dept->department_name; ?> <span class="badge pull-right"><?php echo $counter ;?></span></a></li>
                <li data-tab-id="0"><a href="javascript: void(0);">General <span class="badge pull-right"><?php echo $general; ?></span></a></li>
                <?php } ?>
            <?php } ?>
            </ul>
            
            <div class="box-md">
                <ul class="category list-group activity-list">
                	<?php if($activity): ?>
						<?php foreach($activity as $row ) { ?>
                        <li class="list-group-item">
                        	<a href="activity/<?php echo $row->act_id; ?>">
								<?php
								if($row->only_survey == 0) {
									echo ucfirst(substr($row->activity_title, 0, 40));
								} else {
									echo ucfirst(substr($row->survey_title, 0, 40));
								}
								?>
                            </a>
                            <span class="pull-right" title="<?php echo $row->activity_dated; ?>">
                            	<?php echo date("M. j, Y", strtotime($row->activity_dated)); ?>
                            </span>
                        </li>
                        <?php } ?>
                    <?php else: ?>
                    	<li class="list-group-item"><p>No activity for this category.</p></li>
                    <?php endif; ?>
                </ul>
                <div class="pagination">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/mainpage.js"></script>
</body>
</html>
