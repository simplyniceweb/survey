<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::<?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
<?php require_once('includes/header.php'); ?>

<div class="container">
	<div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
				<h3 class="panel-title">Administrator Dashboard</h3>
            </div>
            
            <div class="panel-body">
            	<ul class="list-group">
                    <li class="list-group-item"><a href="main">View Activity</a></li>
                    <li class="list-group-item"><a href="ban">Ban user</a></li>
                    <li class="list-group-item"><a href="department">Add Department</a></li>
                    <li class="list-group-item"><a href="survey">Add School Activity & Survey</a></li>
                    <li class="list-group-item"><a href="studentnumber">Add Student Number</a></li>
                </ul>
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