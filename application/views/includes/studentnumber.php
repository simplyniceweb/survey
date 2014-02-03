<?php if( $student_count > 0 ) { ?>
	<?php foreach($student_id as $sid) { ?>
    <option value="<?php echo $sid->unique; ?>"><?php echo $sid->unique; ?></option>
    <?php } ?>
<?php } else { ?>
	<option style="color: #F00">No student number for this department.</option>
<?php } ?>