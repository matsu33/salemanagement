<?php

class Model_Order extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'publisher_id',
		'customer_id',
		'order_type',
		'status',
		'customer_type',
		'total',
		'debt',
		'paid',
		'date_paid',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'orders';

}
