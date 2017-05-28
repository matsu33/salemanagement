<?php

class Model_Orderdetail extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'order_id',
		'product_id',
		'order_type',
		'price',
		'quanlity',
		'money',
		'create_at',
		'update_at',
		'old_instock',
		'new_instock',
	);


	protected static $_table_name = 'orderdetails';

}
