<?php

namespace Fuel\Migrations;

class Create_prices_2
{
	public function up()
	{
		\DBUtil::create_table('prices_2', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'price_id' => array('constraint' => 10, 'type' => 'int'),
			'product_id' => array('constraint' => 10, 'type' => 'int'),
			'publisher_id' => array('constraint' => 5, 'type' => 'int'),
			'input_price' => array('type' => 'decimal'),
			'selected_price' => array('constraint' => 1, 'type' => 'char'),
			'wholesales_rate' => array('type' => 'decimal'),
			'retail_rate' => array('type' => 'decimal'),
			'wholesales_price' => array('type' => 'decimal'),
			'retail_price' => array('type' => 'decimal'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('prices_2');
	}
}