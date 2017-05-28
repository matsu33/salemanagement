<?php

namespace Fuel\Migrations;

class Create_order_tbls_4
{
	public function up()
	{
		\DBUtil::create_table('order_tbls_4', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'order_id' => array('constraint' => 10, 'type' => 'int'),
			'order_type' => array('constraint' => 1, 'type' => 'char'),
			'total' => array('type' => 'decimal'),
			'paid' => array('type' => 'decimal'),
			'debt' => array('type' => 'decimal'),
			'user_id' => array('constraint' => 10, 'type' => 'int'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'publisher_id' => array('constraint' => 5, 'type' => 'int'),
			'customer_type' => array('constraint' => 1, 'type' => 'char'),
			'customer_id' => array('constraint' => 10, 'type' => 'int'),
			'date_create' => array('type' => 'datetime'),
			'date_paid' => array('type' => 'datetime'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('order_tbls_4');
	}
}