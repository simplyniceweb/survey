<?php if( $student_count > 0 ) { ?>
	<?php foreach($student as $std) { ?>
        <option value="<?php echo $std->user_id; ?>"><?php echo $std->user_name; ?></option>
    <?php } ?>
<?php } else { ?>
	<option style="color: #F00">No student yet for this department.</option>
<?php } ?>