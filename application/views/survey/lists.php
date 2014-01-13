<?php foreach($activity as $act) { } ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<base href="<?php echo base_url(); ?>">
	<title>-::Web Based Generator::<?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css"/>
    <style>
		li { list-style-type: none }
		span.remove-image { position: absolute }
		#survey-comments ul li { background: #F1F1F1 }
		.question-trigger {cursor: pointer }
		.question-trigger:hover { background:#F1F1F1 }
		.edit-answer { background: #FFF; border:0; padding: 3px; }
	</style>
</head>
<body>
<?php require_once('/../includes/header.php'); ?>

<div class="container">
	<div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
            	<small class="pull-right">
                <i class="glyphicon glyphicon-calendar"></i> 
				<?php echo date("M. j, Y", strtotime($act->activity_dated)); ?>
                </small>
                <h3 class="panel-title"><?php echo ucfirst($act->activity_title); ?></h3>
            </div>
        	<div class="panel-body"><?php echo ucfirst(nl2br(htmlspecialchars($act->activity_description))); ?></div>
        </div>
    </div>
    
    <?php if($session['user_level'] == 99) { ?>
    <div class="row">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              Edit Activity
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="activity/activity_edit/<?php echo $act->activity_id; ?>">Edit</a></li>
              <li class="delete-activity" data-activity-id="<?php echo $act->activity_id; ?>"><a href="javascript: void(0);">Delete</a></li>
            </ul>
        </div>
    </div>
    <?php } ?>

    <div class="row">
    <?php foreach($activity_image as $act_img) { ?>
        <div class="col-xs-6 col-md-3">
            <a href="javascript: void(0);">
            <?php if($session['user_level'] == 99) { ?>
            <span class="remove-image glyphicon glyphicon-remove" data-image-id="<?php echo $act_img->activity_image_id; ?>"></span>
            <?php } ?>
            <img src="assets/activity/<?php echo $act_img->image_name; ?>" class="img-circle" width="200" height="200" data-toggle="modal" data-target="#myModal<?php echo $act_img->activity_image_id; ?>"/>
            </a>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModal<?php echo $act_img->activity_image_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <img src="assets/activity/<?php echo $act_img->image_name; ?>" class="img-responsive"/>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?php } ?>
    </div>

<br>

<div class="container">
	<div id="survey-container" class="row">
		<?php
        $counter = 1;
        if(!is_null($survey)) {
        foreach($survey as $row ) {
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo ucfirst($row->survey_title); ?></h3>
            </div>
            <div class="panel-body" style="word-wrap: break-word"><?php echo ucfirst(nl2br(htmlspecialchars($row->survey_description))); ?></div>
        <?php } ?>
            <br>
            <ul class="list-group">
            	<li class="warning-message"></li>
				<?php if(!is_null($voted)): foreach($voted as $vote) {} endif; ?>
				<?php foreach($sum as $sum) {} ?>
				<?php foreach($questions as $query ) { ?>
				<?php
					if($sum->question_choose):
						$percent = ($query->question_choose/$sum->question_choose)*100;
					endif;
				?>
                <?php if($session['user_level'] == 99) { ?>
                    <li class="list-group-item question-trigger">
                        <input type="radio" name="choice" class="question-pick" <?php if(!is_null($voted)) { if($vote->question_id == $query->question_id): echo 'id="the_choice" data-checked="1" checked="checked"'; else: 'data-checked="0"'; endif; } ?> data-activity-id="<?php echo $act->activity_id; ?>" data-survey-id="<?php echo $row->survey_id; ?>" data-count="<?php echo $counter++; ?>" data-question-id="<?php echo $query->question_id; ?>">
                        <input type="text" class="edit-answer" data-entry="<?php echo $query->question_id; ?>" value="<?php echo $query->survey_question; ?>">
                        <span class="pull-right"><?php echo $query->question_choose; ?> Votes <small class="badge"><?php if($sum->question_choose): echo round($percent,0); else: echo "0"; endif; ?>%</small></span>
                    </li>
                <?php } else { ?>
                    <li class="list-group-item">
                        <input type="radio" name="choice" class="question-pick" <?php if(!is_null($voted)) { if($vote->question_id == $query->question_id): echo 'data-checked="1" checked="checked"'; else: 'data-checked="0"'; endif; } ?> data-activity-id="<?php echo $act->activity_id; ?>" data-survey-id="<?php echo $row->survey_id; ?>" data-count="<?php echo $counter++; ?>" data-question-id="<?php echo $query->question_id; ?>">
                       <?php echo $query->survey_question; ?>
                        <span class="pull-right"><?php echo $query->question_choose; ?> Votes <small class="badge"><?php if($sum->question_choose): echo round($percent,0); else: echo "0"; endif; ?>%</small></span>
                    </li>
                <?php } } ?>
                <li class="list-group-item">Total Vote: <?php echo number_format($sum->question_choose); ?> User(s)</li>
            </ul>
    	</div>
    </div>
    
    <?php if($session['user_level'] == 99) { ?>
    <div class="row">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              Delete Survey
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li class="delete-survey" data-survey-id="<?php echo $row->survey_id; ?>"><a href="javascript: void(0);">Delete</a></li>
            </ul>
        </div>
    </div>
    <br>
    <?php } } ?>
    
	<div id="survey-comments" class="col-sm-12">
		<input type="text" data-activity-id="<?php echo $act->activity_id; ?>" class="form-control comment-bar" placeholder="Write your comment here."/>
		<br>
        <ul class="list-group">
			<span class="comment-badge"></span>
            <?php foreach($comments->result() as $com) { ?>
            	<li class="list-group-item wrapper-comment-<?php echo $com->comment_id; ?>">
					
					<?php if($com->user_id == $session['user_id'] || $session['user_level'] == 99) { ?>
                    <div style="float:right">
						<a class="edit_comment edit-comment-<?php echo $com->comment_id; ?>" data-id="<?php echo $com->comment_id; ?>" href="javascript:void(0);">Edit</a>
						<a class="delete_comment" data-id="<?php echo $com->comment_id; ?>" href="javascript:void(0);">Delete</a>
					</div>
					<?php } ?>
					
					<p><a href="javascript:void(0);">
						<?php
							$this->db->from('users');
							$this->db->where('user_id', $com->user_id);
							$user = $this->db->get();
							foreach($user->result() as $user) {
								echo $user->user_name;
							}
						?>
					</a></p>
					<p class="comment-face-<?php echo $com->comment_id; ?>"><?php echo $com->comment_message; ?></p>
					<input style="display:none" type="text" class="form-control edit-show-<?php echo $com->comment_id; ?> edit-comment-edit" data-id="<?php echo $com->comment_id; ?>" value="<?php echo $com->comment_message; ?>"/>
                </li>
            <?php } ?>
		</ul>
	</div>
    
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/mainpage.js"></script>
</body>
</html>