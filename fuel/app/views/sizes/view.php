<h2>Viewing <span class='muted'>#<?php echo $size->id; ?></span></h2>

<p>
	<strong>Diameter:</strong>
	<?php echo $size->diameter; ?></p>
<p>
	<strong>Length:</strong>
	<?php echo $size->length; ?></p>
<p>
	<strong>Product range:</strong>
	<?php echo $size->product_range; ?></p>

<?php echo Html::anchor('sizes/edit/'.$size->id, 'Edit'); ?> |
<?php echo Html::anchor('sizes', 'Back'); ?>