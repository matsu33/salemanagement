<?php

namespace Fuel\Migrations;

class Create_units
{
	public function up()
	{
		\DBUtil::create_table('units', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'unit_id' => array('constraint' => 2, 'type' => 'tinyint'),
			'unit_name' => array('constraint' => 30, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('units');
	}
}