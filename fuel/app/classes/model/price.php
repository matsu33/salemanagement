<?php

class Model_Price extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'product_id',
		'publisher_id',
		'input_price',
		'selected_price',
		'wholesales_rate',
		'retail_rate',
		'wholesales_price',
		'retail_price',
		'status',
		'create_at',
		'update_at',
		'wholesales_rate2',
		'wholesales_price2',
		'wholesales_rate3',
		'wholesales_price3'
	);


	protected static $_table_name = 'prices';

}
