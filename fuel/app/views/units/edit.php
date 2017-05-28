<h2>Editing <span class='muted'>Unit</span></h2>
<br>

<?php echo render('units/_form'); ?>
<p>
	<?php echo Html::anchor('units/view/'.$unit->id, 'View'); ?> |
	<?php echo Html::anchor('units', 'Back'); ?></p>
