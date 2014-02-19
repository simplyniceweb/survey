<?php
$counter = 1;
if(!is_null($survey)) {
foreach($survey as $row ) {
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo ucfirst($row->survey_title); ?> <?php if($row->survey_end != "0000-00-00") { ?><span class="pull-right">You can vote until <?php echo date("Y-m-d", strtotime($row->survey_end)); } ?></span></h3>
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
			<?php
            $now = new \DateTime(date("Y-m-d"));
            $end = new \DateTime($row->survey_end);
            if($end > $now || $row->survey_end == "0000-00-00"): 
            ?>
				<input type="radio" name="choice" class="question-pick" <?php if(!is_null($voted)) { if($vote->question_id == $query->question_id): echo 'id="the_choice" data-checked="1" checked="checked"'; else: 'data-checked="0"'; endif; } ?> data-activity-id="<?php echo $activity_id; ?>" data-survey-id="<?php echo $row->survey_id; ?>" data-count="<?php echo $counter++; ?>" data-question-id="<?php echo $query->question_id; ?>">
                <?php endif; ?>
				<input type="text" class="edit-answer" data-entry="<?php echo $query->question_id; ?>" value="<?php echo $query->survey_question; ?>">
				<span class="pull-right"><?php echo $query->question_choose; ?> Votes <small class="badge"><?php if($sum->question_choose): echo round($percent,0); else: echo "0"; endif; ?>%</small></span>
			</li>
		<?php } else { ?>
			<li class="list-group-item">
				<input type="radio" name="choice" class="question-pick" <?php if(!is_null($voted)) { if($vote->question_id == $query->question_id): echo 'data-checked="1" checked="checked"'; else: 'data-checked="0"'; endif; } ?> data-activity-id="<?php echo $activity_id; ?>" data-survey-id="<?php echo $row->survey_id; ?>" data-count="<?php echo $counter++; ?>" data-question-id="<?php echo $query->question_id; ?>">
			   <?php echo $query->survey_question; ?>
				<span class="pull-right"><?php echo $query->question_choose; ?> Votes <small class="badge"><?php if($sum->question_choose): echo round($percent,0); else: echo "0"; endif; ?>%</small></span>
			</li>
		<?php } } ?>
		<li class="list-group-item">Total Vote: <?php echo number_format($sum->question_choose); ?> User(s)</li>
        <?php } ?>
	</ul>
</div>