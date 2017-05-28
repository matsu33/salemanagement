<h2>Editing <span class='muted'>Customer</span></h2>
<br>

<?php echo render('customers/_form'); ?>
<p>
	<?php echo Html::anchor('customers/view/'.$customer->id, 'View'); ?> |
	<?php echo Html::anchor('customers', 'Back'); ?></p>
