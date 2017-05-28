<h2>Editing <span class='muted'>Publisher</span></h2>
<br>

<?php echo render('publishers/_form'); ?>
<p>
	<?php echo Html::anchor('publishers/view/'.$publisher->id, 'View'); ?> |
	<?php echo Html::anchor('publishers', 'Back'); ?></p>
