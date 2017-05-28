<?php

namespace Fuel\Migrations;

class Create_orderdetails
{
	public function up()
	{
		\DBUtil::create_table('orderdetails', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'order_id' => array('constraint' => 10, 'type' => 'int'),
			'product_id' => array('constraint' => 10, 'type' => 'int'),
			'order_type' => array('constraint' => 1, 'type' => 'char'),
			'price' => array('type' => 'decimal'),
			'quanlity' => array('type' => 'decimal'),
			'money' => array('type' => 'decimal'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('orderdetails');
	}
}