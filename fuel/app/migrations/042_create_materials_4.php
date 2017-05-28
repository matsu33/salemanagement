<?php

namespace Fuel\Migrations;

class Create_materials_4
{
	public function up()
	{
		\DBUtil::create_table('materials_4', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'material_id' => array('constraint' => 3, 'type' => 'smallint'),
			'material_name' => array('constraint' => 100, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('materials_4');
	}
}