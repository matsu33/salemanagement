<h2>Viewing <span class='muted'>#<?php echo $category->id; ?></span></h2>

<p>
	<strong>Category name:</strong>
	<?php echo $category->category_name; ?></p>

<?php echo Html::anchor('categories/edit/'.$category->id, 'Edit'); ?> |
<?php echo Html::anchor('categories', 'Back'); ?>