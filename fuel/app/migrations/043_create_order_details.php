<?php

namespace Fuel\Migrations;

class Create_order_details
{
	public function up()
	{
		\DBUtil::create_table('order_details', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'order_detail_id' => array('constraint' => 18, 'type' => 'bigint'),
			'order_id' => array('constraint' => 10, 'type' => 'int'),
			'order_type' => array('constraint' => 1, 'type' => 'char'),
			'product_id' => array('constraint' => 10, 'type' => 'int'),
			'price' => array('type' => 'decimal'),
			'quanlity' => array('type' => 'decimal'),
			'money' => array('type' => 'decimal'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('order_details');
	}
}