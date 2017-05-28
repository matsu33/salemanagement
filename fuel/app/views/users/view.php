<h2>Viewing <span class='muted'>#<?php echo $user->id; ?></span></h2>

<p>
	<strong>User name:</strong>
	<?php echo $user->user_name; ?></p>
<p>
	<strong>User password:</strong>
	<?php echo $user->user_password; ?></p>
<p>
	<strong>User type:</strong>
	<?php echo $user->user_type; ?></p>
<p>
	<strong>User realname:</strong>
	<?php echo $user->user_realname; ?></p>

<?php echo Html::anchor('users/edit/'.$user->id, 'Edit'); ?> |
<?php echo Html::anchor('users', 'Back'); ?>