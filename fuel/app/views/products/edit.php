<h2>Editing <span class='muted'>Product</span></h2>
<br>

<?php echo render('products/_form'); ?>
<p>
	<?php echo Html::anchor('products/view/'.$product->id, 'View'); ?> |
	<?php echo Html::anchor('products', 'Back'); ?></p>
