<h2>Viewing <span class='muted'>#<?php echo $publisher->id; ?></span></h2>

<p>
	<strong>Publisher name:</strong>
	<?php echo $publisher->publisher_name; ?></p>
<p>
	<strong>Status:</strong>
	<?php echo $publisher->status; ?></p>
<p>
	<strong>Create at:</strong>
	<?php echo $publisher->create_at; ?></p>
<p>
	<strong>Update at:</strong>
	<?php echo $publisher->update_at; ?></p>

<?php echo Html::anchor('publishers/edit/'.$publisher->id, 'Edit'); ?> |
<?php echo Html::anchor('publishers', 'Back'); ?>