<h2>Viewing <span class='muted'>#<?php echo $customer->id; ?></span></h2>

<p>
	<strong>Customer type:</strong>
	<?php echo $customer->customer_type; ?></p>
<p>
	<strong>Customer name:</strong>
	<?php echo $customer->customer_name; ?></p>

<?php echo Html::anchor('customers/edit/'.$customer->id, 'Edit'); ?> |
<?php echo Html::anchor('customers', 'Back'); ?>