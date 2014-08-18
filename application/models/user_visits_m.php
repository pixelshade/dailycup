<?php
class User_visits_m extends CI_Model{

	function __construct()
	{
		$this->load->database();
	}

	public function get_user_visits($amount = NULL, $offset = NULL)
	{	
		$query = $this->db->order_by('visited', 'desc')->get('user_visits', $amount, $offset);		
		return $query->result_array();
	}

	public function add_user_visit($user_id, $name)
	{
		$data = array(
			'user_id' => $user_id,
			'name' => $name,	
			'visited' => date('Y-m-d H:i:s'),
			);

		$this->db->insert('user_visits', $data);
		return $this->db->insert_id();
	}


	public function delete_user_visit($id){
		$file = $this->get_user_visit($id);  
		if(count($file) != 0) {     
			return ($this->db->where('id', $id)->delete('user_visits'));			
		}		
		return FALSE;
	}
	// public function insert_file($filename, $name, $uploader)
	// {
	// 	$data = array(
	// 		'filename' => $filename,
	// 		'name' => $name,	
	// 		'uploader' => $uploader,
	// 		'date' => date('Y-m-d H:i:s'),
	// 		);

	// 	$this->db->insert('user_visits', $data);
	// 	return $this->db->insert_id();
	// }

	// public function delete_file($file_id)
	// {
	// 	$file = $this->get_user_visit($file_id);  
	// 	if(count($file) != 0) {     
	// 		$file_url_to_del = $this->upload_path . $file->filename;
	// 		if (!$this->db->where('id', $file_id)->delete('user_visits'))
	// 		{
	// 			return FALSE;
	// 		}
	// 		if(is_file($file_url_to_del)){
	// 			if(unlink($file_url_to_del)){            
	// 				return TRUE;           
	// 			}
	// 		}
	// 	}
	// 	return FALSE;

	// }

	public function get_user_visit($user_id = NULL)
	{
		return $this->db->select()
		->from('user_visits')
		->where('user_id', $id)
		->get()
		->row();
	}

	public function get_all(){ 
		return $this->db->get('user_visits')->result_array(); 
	}
}