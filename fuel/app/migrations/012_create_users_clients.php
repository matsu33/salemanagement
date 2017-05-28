<?php

namespace Fuel\Migrations;

class Create_users_clients
{
	public function up()
	{
		\DBUtil::create_table('users_clients', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 32, 'type' => 'varchar'),
			'client_id' => array('constraint' => 32, 'type' => 'varchar'),
			'client_secret' => array('constraint' => 32, 'type' => 'varchar'),
			'redirect_uri' => array('constraint' => 255, 'type' => 'varchar'),
			'auto_approve' => array('constraint' => 1, 'type' => 'tinyint'),
			'autonomous' => array('constraint' => 1, 'type' => 'tinyint'),
			'status' => array('constraint' => '"development","pending","approved","rejected"', 'type' => 'enum'),
			'suspended' => array('constraint' => 1, 'type' => 'tinyint'),
			'notes' => array('constraint' => 255, 'type' => 'tinytext'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users_clients');
	}
}