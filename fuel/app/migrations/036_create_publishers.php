<?php

namespace Fuel\Migrations;

class Create_publishers
{
	public function up()
	{
		\DBUtil::create_table('publishers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'publisher_name' => array('constraint' => 200, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('publishers');
	}
}