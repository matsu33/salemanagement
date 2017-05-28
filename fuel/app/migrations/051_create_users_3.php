<?php

namespace Fuel\Migrations;

class Create_users_3
{
	public function up()
	{
		\DBUtil::create_table('users_3', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 5, 'type' => 'smallint'),
			'user_name' => array('constraint' => 50, 'type' => 'varchar'),
			'user_password' => array('constraint' => 255, 'type' => 'varchar'),
			'user_type' => array('constraint' => 1, 'type' => 'char'),
			'user_realname' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_3');
	}
}