<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends Main_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('video_m');

    }

    public function login(){

      $user = $this->fb->getUser();


      if ($user) {
        try {
            $data['user_profile'] = $this->fb->sdk->api('/me');
        } catch (FacebookApiException $e) {
            $user = null;
        }
    }else {
        $this->fb->sdk->destroySession();
    }

    if ($user) {

            $data['logout_url'] = site_url('/video/logout'); // Logs off application
            // OR 
            // Logs off FB!
            // $data['logout_url'] = $this->fb->sdk->getLogoutUrl();

        } else {
            $data['login_url'] = $this->fb->sdk->getLoginUrl(array(
                'redirect_uri' => site_url(),
                'scope' => array("email","user_groups") // permissions here
                ));
        }       

    }

    public function logout(){
        // Logs off session from website
        $this->fb->sdk->destroySession();
        //$this->fb->sdk->setSession(null);
        // Make sure you destory website session as well.

        redirect('video/');
    }

    public function index(){ 
        $this->data['error'] = $this->session->flashdata('error');
        $user_profile = $this->user_profile; 
        $this->data['user_profile'] = $user_profile;

        if($user_profile['id'] == NULL ){
          $this->data['login_url'] = $login_url = $this->fb->sdk->getLoginUrl(); 
          $this->data['login_link'] = '<a href="' . $login_url . '" class="btn btn-lg btn-success">Login</a>';
      } else {   
          $this->data['login_link'] = "<a href='/video/logout'>Logout</a>";                              
          $this->data['videos'] = $this->video_m->get_videos();      
      }


      $this->load->view('include/header');
      $this->load->view('templates/menubar',$this->data);      
      $this->load->view('videos',$this->data);
      $this->load->view('include/footer');
  }

  public function test(){

// $this->load->library('email');
// $config['protocol'] = "smtp";
// $config['smtp_host'] = "ssl://smtp.gmail.com";
// $config['smtp_port'] = "465";
// $config['smtp_user'] = "dailycupof@gmail.com"; 
// $config['smtp_pass'] = "44253611";
// $config['charset'] = "utf-8";
// $config['mailtype'] = "html";
// $config['newline'] = "\r\n";

// $this->email->initialize($config);

// $this->email->from('dailycupof@gmail.com', 'Pejko');
// $this->email->to('icewr6hc1908@m.youtube.com');
// //$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
// $this->email->subject('This is an email test');
// //$this->email->attach('/path/to/photo1.jpg');
// $this->email->message('It is working. Great!');
// $this->email->send();
   // UClH8bVBK8EIqOPU8nz-MEfA
//    AIzaSyCnWBU_JGJB8q_lxwSMvlX2PQH9n26DFdk
  }


  public function upload_file()
  {
    if($this->user_profile != NULL){
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';
        $name_input = 'name';

        $config['upload_path'] = $this->video_m->upload_path;
        $config['allowed_types'] = 'mpeg|mpg|mov|avi|mp4|jpg|png|gif|wmv';
        $config['max_size'] = 1024 * 47;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);


        if (!$this->upload->do_upload($file_element_name))
        {
            $status = 'error';
            $this->data['error'] = $this->upload->display_errors('', '');
        }
        else
        {
            $data = $this->upload->data();
            $name_from_input = $this->input->post($name_input);
            $name = empty($name_from_input) ? $data['orig_name'] : $name_from_input;
            $uploader =  $this->user_profile;

            $file_id = $this->video_m->insert_file($data['file_name'],$name, $uploader['id']);
            if($file_id)
            {
                $status = "success";
                $this->data['error'] = "File successfully uploaded";
            }
            else
            {
                unlink($data['full_path']);
                $status = "error";
                $this->data['error'] = "Something went wrong when saving the file, please try again.";
            }
        }
        @unlink($_FILES[$file_element_name]);

        $this->session->set_flashdata('error',$this->data['error']); 
    }
    redirect('video/index/');
}

public function delete_file($file_id)
{
    $video = $this->video_m->get_video($file_id);
    if(!empty($video)){
        if($this->user_profile['id'] == $video->uploader){

            if ($this->video_m->delete_file($file_id))
            {
                $status = 'success';
                $this->data['error'] = 'File successfully deleted';
            }
            else
            {
                $status = 'error';
                $this->data['error'] = 'Something went wrong when deleteing the file, please try again';
            }
            $this->session->set_flashdata('error',$this->data['error']); 
        }
    }
    redirect('video/index/');
}



}

