<?php

namespace Fuel\Migrations;

class Create_product_groups_3
{
	public function up()
	{
		\DBUtil::create_table('product_groups_3', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'product_group_id' => array('constraint' => 10, 'type' => 'int'),
			'main_product_id' => array('constraint' => 10, 'type' => 'int'),
			'sub_product_id' => array('constraint' => 10, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('product_groups_3');
	}
}