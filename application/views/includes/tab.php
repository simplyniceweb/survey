<?php if($activity): ?>
<?php foreach($activity as $row ) { ?>
<li class="list-group-item">
<a href="activity/<?php echo $row->activity_id; ?>">
<?php echo ucfirst(substr($row->activity_title, 0, 40)); ?>
</a>
<span class="pull-right" title="<?php echo $row->activity_dated; ?>">
<?php echo date("M. j, Y", strtotime($row->activity_dated)); ?>
</span>
</li>
<?php } ?>
<?php else: ?>
<li class="list-group-item"><p>No activity for this category.</p></li>
<?php endif; ?>