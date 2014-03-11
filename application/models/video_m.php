<?php
class Video_m extends CI_Model{
	public $upload_path = "app_content/";
	
	function __construct()
	{
		$this->load->database();
	}

	public function get_videos()
	{
		$query = $this->db->order_by('date', 'desc')->get('videos');
		return $query->result_array();
	}

	public function insert_file($filename, $name, $uploader)
	{
		$data = array(
			'filename' => $filename,
			'name' => $name,	
			'uploader' => $uploader,
			'date' => date('Y-m-d H:i:s'),
			);

		$this->db->insert('videos', $data);
		return $this->db->insert_id();
	}

	public function delete_file($file_id)
	{
		$file = $this->get_video($file_id);  
		if(count($file) != 0) {     
			$file_url_to_del = $this->upload_path . $file->filename;
			if (!$this->db->where('id', $file_id)->delete('videos'))
			{
				return FALSE;
			}
			if(is_file($file_url_to_del)){
				if(unlink($file_url_to_del)){            
					return TRUE;           
				}
			}
		}
		return FALSE;
		
	}

	public function get_video($file_id = NULL)
	{
		return $this->db->select()
		->from('videos')
		->where('id', $file_id)
		->get()
		->row();
	}

	public function get_all(){ 
		return $this->db->get('videos')->result_array(); 
	}
}