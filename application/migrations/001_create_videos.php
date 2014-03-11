<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_videos extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'filename' => array(
				'type' => 'TEXT',				
			),
			'name' => array(
				'type' => 'TEXT',				
			),
			'uploader' => array(
				'type' => 'VARCHAR',
				'constraint' => '200',
			),	
			'date' => array(
				'type' => 'DATETIME',				
			),			
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('videos');
	}

	public function down()
	{
		$this->dbforge->drop_table('videos');
	}
}