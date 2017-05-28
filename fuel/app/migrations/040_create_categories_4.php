<?php

namespace Fuel\Migrations;

class Create_categories_4
{
	public function up()
	{
		\DBUtil::create_table('categories_4', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'category_name' => array('constraint' => 50, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('categories_4');
	}
}