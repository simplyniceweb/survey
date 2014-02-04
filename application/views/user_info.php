<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Full Name</th>
			<th>User Email</th>
			<th>Contact Number</th>
			<th>Student Address</th>
			<th>Birthday</th>
			<th>Edit</th>
		</tr>
	</thead>
	
	<tbody>
		<?php foreach($students as $std) { ?>
		<tr>
			<td><?php echo $std->user_name; ?></td>
			<td><?php echo $std->user_email; ?></td>
			<td><?php echo $std->student_phone_number; ?></td>
			<td><?php echo $std->student_address; ?></td>
			<td><?php echo $std->user_birthday; ?></td>
			<td><a href="settings/<?php echo $std->user_id; ?>" target="_blank">Edit</a></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
