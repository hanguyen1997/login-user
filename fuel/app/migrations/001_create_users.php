<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'password' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'token' => array('constraint' => 255, 'null' => true, 'type' => 'varchar'),
			'mail_address' => array('constraint' => 255, 'null' => false, 'type' => 'varchar'),
			'name' => array('constraint' => 20, 'null' => true, 'type' => 'varchar'),
			'created_at' => array('null' => false, 'type' => 'datetime'),
			'updated_at' => array('null' => false, 'type' => 'datetime'),
			
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}