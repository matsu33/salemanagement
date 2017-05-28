<h2>Editing <span class='muted'>Size</span></h2>
<br>

<?php echo render('sizes/_form'); ?>
<p>
	<?php echo Html::anchor('sizes/view/'.$size->id, 'View'); ?> |
	<?php echo Html::anchor('sizes', 'Back'); ?></p>
