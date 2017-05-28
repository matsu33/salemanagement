<?php

class Model_Customer extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'customer_type',
		'customer_name',
		'status',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'customers';

}
