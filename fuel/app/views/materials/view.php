<h2>Viewing <span class='muted'>#<?php echo $material->id; ?></span></h2>

<p>
	<strong>Material name:</strong>
	<?php echo $material->material_name; ?></p>

<?php echo Html::anchor('materials/edit/'.$material->id, 'Edit'); ?> |
<?php echo Html::anchor('materials', 'Back'); ?>