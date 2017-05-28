<h2>Editing <span class='muted'>Material</span></h2>
<br>

<?php echo render('materials/_form'); ?>
<p>
	<?php echo Html::anchor('materials/view/'.$material->id, 'View'); ?> |
	<?php echo Html::anchor('materials', 'Back'); ?></p>
