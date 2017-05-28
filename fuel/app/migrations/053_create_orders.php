<?php

namespace Fuel\Migrations;

class Create_orders
{
	public function up()
	{
		\DBUtil::create_table('orders', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'user_id' => array('constraint' => 5, 'type' => 'smallint'),
			'publisher_id' => array('constraint' => 5, 'type' => 'int'),
			'customer_id' => array('constraint' => 10, 'type' => 'int'),
			'order_type' => array('constraint' => 1, 'type' => 'char'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'customer_type' => array('constraint' => 1, 'type' => 'char'),
			'total' => array('type' => 'decimal'),
			'debt' => array('type' => 'decimal'),
			'paid' => array('type' => 'decimal'),
			'date_paid' => array('type' => 'timestamp'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('orders');
	}
}