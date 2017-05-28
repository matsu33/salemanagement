<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_name',
		'user_password',
		'user_type',
		'user_realname',
		'status',
		'role',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'users';

}
