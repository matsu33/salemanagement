<?php

class Model_Product extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'category_id',
		'material_id',
		'size_id',
		'unit_id',
		'status',
		'product_group',
		'image',
		'unit_instock',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'products';

}
