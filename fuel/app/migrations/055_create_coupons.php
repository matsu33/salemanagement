<?php

namespace Fuel\Migrations;

class Create_coupons
{
	public function up()
	{
		\DBUtil::create_table('coupons', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'customer_id' => array('constraint' => 10, 'type' => 'int'),
			'product_id' => array('constraint' => 10, 'type' => 'int'),
			'coupon_price' => array('type' => 'decimal'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('coupons');
	}
}