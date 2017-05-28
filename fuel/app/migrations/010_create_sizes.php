<?php

namespace Fuel\Migrations;

class Create_sizes
{
	public function up()
	{
		\DBUtil::create_table('sizes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'size_id' => array('constraint' => 10, 'type' => 'mediumint'),
			'diameter' => array('constraint' => 10, 'type' => 'smallint'),
			'length' => array('constraint' => 10, 'type' => 'smallint'),
			'product_range' => array('constraint' => 10, 'type' => 'smallint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sizes');
	}
}