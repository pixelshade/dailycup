<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_visit extends Main_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_visits_m');

    }

    public function index(){ 
   
        $this->load->view('include/header');

        $user_profile = $this->user_profile; 
        $this->data['user_profile'] = $user_profile;

        if($user_profile['id'] == NULL ){
          $this->data['login_url'] = $login_url = $this->fb->sdk->getLoginUrl(); 
          $this->data['login_link'] = '<a href="' . $login_url . '" class="btn btn-lg btn-success">Login</a>';
          $this->load->view('login',$this->data);
      } else {   
          $this->data['login_link'] = "<a href='/video/logout'>Logout</a>";                              
          $this->data['user_visits'] = $this->user_visits_m->get_user_visits();      
          $this->load->view('templates/menubar',$this->data);      


        $this->load->view('user_visits',$this->data);
    }

    $this->load->view('include/footer',$this->data);
}




    public function delete_user_visit($id){        
         $video = $this->user_visits_m->get_video($id);
        if(!empty($video)){
            if($this->user_profile['id'] == $video->uploader){
                if ($this->user_visits_m->delete_user_visit($id))
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

