<?php

class Model_Size extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'diameter',
		'length',
		'product_range',
		'status',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'sizes';

}
