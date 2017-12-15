<?php

class Model_Category extends \Orm\Model
{
	protected static $_properties = array(
		'id',
        'parentid',
		'category_name',
		'status',
		'create_at',
		'update_at',
	);

	protected static $_table_name = 'categories';
    protected static $_primary_key = array('id');
}
