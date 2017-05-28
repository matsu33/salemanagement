<?php

class Model_Publisher extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'publisher_name',
		'status',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'publishers';

}
