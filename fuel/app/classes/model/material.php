<?php

class Model_Material extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'material_name',
		'status',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'materials';

}
