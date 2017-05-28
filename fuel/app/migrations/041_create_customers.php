<?php

namespace Fuel\Migrations;

class Create_customers
{
	public function up()
	{
		\DBUtil::create_table('customers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'customer_type' => array('constraint' => 1, 'type' => 'tinyint'),
			'customer_name' => array('constraint' => 200, 'type' => 'varchar'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('customers');
	}
}