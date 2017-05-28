<?php

namespace Fuel\Migrations;

class Create_publishers_3
{
	public function up()
	{
		\DBUtil::create_table('publishers_3', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'publisher_name' => array('constraint' => 200, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('publishers_3');
	}
}