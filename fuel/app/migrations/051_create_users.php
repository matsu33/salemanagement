<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_name' => array('constraint' => 50, 'type' => 'varchar'),
			'user_password' => array('constraint' => 255, 'type' => 'varchar'),
			'user_type' => array('constraint' => 1, 'type' => 'char'),
			'user_realname' => array('constraint' => 255, 'type' => 'varchar'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}