<h2>Viewing <span class='muted'>#<?php echo $unit->id; ?></span></h2>

<p>
	<strong>Unit name:</strong>
	<?php echo $unit->unit_name; ?></p>

<?php echo Html::anchor('units/edit/'.$unit->id, 'Edit'); ?> |
<?php echo Html::anchor('units', 'Back'); ?>