<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_visits extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'TEXT',				
			),
			'name' => array(
				'type' => 'TEXT',				
			),			
			'visited' => array(
				'type' => 'DATETIME',				
			),			
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('user_visits');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_visits');
	}
}