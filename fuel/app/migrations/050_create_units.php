<?php

namespace Fuel\Migrations;

class Create_units
{
	public function up()
	{
		\DBUtil::create_table('units', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'unit_name' => array('constraint' => 30, 'type' => 'varchar'),
			'status' => array('constraint' => 1, 'type' => 'char'),
			'create_at' => array('type' => 'timestamp'),
			'update_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('units');
	}
}