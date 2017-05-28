<?php

class Model_Unit extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'unit_name',
		'status',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'units';

}
