<h2>Viewing <span class='muted'>#<?php echo $product->id; ?></span></h2>

<p>
	<strong>Category id:</strong>
	<?php echo $product->category_id; ?></p>
<p>
	<strong>Name:</strong>
	<?php echo $product->name; ?></p>

<?php echo Html::anchor('products/edit/'.$product->id, 'Edit'); ?> |
<?php echo Html::anchor('products', 'Back'); ?>