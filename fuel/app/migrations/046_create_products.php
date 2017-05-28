<?php

namespace Fuel\Migrations;

class Create_products
{
	public function up()
	{
		\DBUtil::create_table('products', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'category_id' => array('constraint' => 5, 'type' => 'smallint'),
			'material_id' => array('constraint' => 3, 'type' => 'smallint'),
			'size_id' => array('constraint' => 10, 'type' => 'mediumint'),
			'unit_id' => array('constraint' => 2, 'type' => 'tinyint'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'product_group' => array('constraint' => 10, 'type' => 'int'),
			'image' => array('constraint' => 100, 'type' => 'varchar'),
			'unit_instock' => array('constraint' => 10, 'type' => 'int'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('products');
	}
}