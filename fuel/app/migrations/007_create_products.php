<?php

namespace Fuel\Migrations;

class Create_products
{
	public function up()
	{
		\DBUtil::create_table('products', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'product_id' => array('constraint' => 10, 'type' => 'int'),
			'category_id' => array('constraint' => 5, 'type' => 'smallint'),
			'material_id' => array('constraint' => 3, 'type' => 'smallint'),
			'size_id' => array('constraint' => 10, 'type' => 'mediumint'),
			'unit_id' => array('constraint' => 2, 'type' => 'tinyint'),
			'image' => array('constraint' => 100, 'type' => 'varchar'),
			'unit_instock' => array('constraint' => 10, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('products');
	}
}