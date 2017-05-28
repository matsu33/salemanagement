<h2>Editing <span class='muted'>Category</span></h2>
<br>

<?php echo render('categories/_form'); ?>
<p>
	<?php echo Html::anchor('categories/view/'.$category->id, 'View'); ?> |
	<?php echo Html::anchor('categories', 'Back'); ?></p>
