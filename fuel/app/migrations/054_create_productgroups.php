<?php

namespace Fuel\Migrations;

class Create_productgroups
{
	public function up()
	{
		\DBUtil::create_table('productgroups', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'main_product_id' => array('constraint' => 10, 'type' => 'int'),
			'sub_product_id' => array('constraint' => 10, 'type' => 'int'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'quanlity' => array('constraint' => 10, 'type' => 'int'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('productgroups');
	}
}