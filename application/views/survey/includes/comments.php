<?php foreach($comments as $com) { ?>
<li class="list-group-item wrapper-comment-<?php echo $com->comment_id; ?>">

<?php if($com->user_id == $session['user_id'] || $session['user_level'] == 99) { ?>
<div style="float:right">
<a class="edit_comment edit-comment-<?php echo $com->comment_id; ?>" data-id="<?php echo $com->comment_id; ?>" href="javascript:void(0);">Edit</a>
<a class="delete_comment" data-id="<?php echo $com->comment_id; ?>" href="javascript:void(0);">Delete</a>
</div>
<?php } ?>

<p><a href="javascript:void(0);"><?php echo $session['user_name']; ?></a></p>
<p class="comment-face-<?php echo $com->comment_id; ?>"><?php echo $com->comment_message; ?></p>
<input style="display:none" type="text" class="form-control edit-show-<?php echo $com->comment_id; ?> edit-comment-edit" data-id="<?php echo $com->comment_id; ?>" value="<?php echo $com->comment_message; ?>"/>
</li>
<?php } ?>