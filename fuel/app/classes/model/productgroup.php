<?php

class Model_Productgroup extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'main_product_id',
		'sub_product_id',
		'status',
		'quanlity',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'productgroups';

}
