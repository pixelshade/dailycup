<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends Main_Controller {
    private $_VIDEOS_ON_PAGE = 4;
    private $url = "http://dailycup.skeletopedia.sk";
    function __construct()
    {
        parent::__construct();
        $this->load->model('video_m');
        $this->load->model('user_visits_m');
        $this->load->library('pagination');

        $config['base_url'] = $this->url."/video/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->video_m->get_total_rows();
        $config['per_page'] = $this->_VIDEOS_ON_PAGE; 
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';  
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config); 
    }

    public function index($p = 1){ 
        $this->data['hide_upload'] = 'false';
     // Specifies the url that youtube will return to. The data it returns are as get variables         
        $this->data['nexturl'] = $this->url;
        
    // These are the get variables youtube returns once the video has been uploaded.
        if(isset($_GET['id'])) {$unique_id = $_GET['id'];} else { $unique_id = '';}
        if(isset($_GET['status'])) {$status = $_GET['status'];} else {$status = '';}
        $this->data['error'] = $this->session->flashdata('error');
        $this->load->view('include/header');

        $user_profile = $this->user_profile; 
        $this->data['user_profile'] = $user_profile;

        if($user_profile['id'] == NULL ){
          $this->data['login_url'] = $login_url = $this->fb->sdk->getLoginUrl(); 
          $this->data['login_link'] = '<a href="' . $login_url . '" class="btn btn-lg btn-success">Login</a>';
          $this->load->view('login',$this->data);
      } else {   



          $this->user_visits_m->add_user_visit($user_profile['id'],$user_profile['name']);
          $this->data['login_link'] = "<a href='/video/logout'>Logout</a>";                            
          
          $this->data['videos'] = $this->video_m->get_videos($this->_VIDEOS_ON_PAGE, $this->_VIDEOS_ON_PAGE*($p-1));      
          $this->data['pagination'] = $this->pagination->create_links();
          $this->load->view('templates/menubar',$this->data);  


          if( isset( $_POST['video_title'] ) && isset( $_POST['video_description'] ) && $unique_id == '') {
            $video_title = $this->data['video_title'] = stripslashes( $_POST['video_title'] );             
            $video_description = $this->data['video_description'] = stripslashes( $_POST['video_description'] );
            include_once( 'upload.php' );
        }


        if( empty( $_POST['video_title'] ) && $unique_id == "" ){            
            $this->data['hide_upload'] = 'true';
            $this->load->view('upload_form',$this->data);             
        }
        elseif(isset($response) && $response->token != '' ){
            $this->data['response'] = $response;
            $this->data['video_title'] = $video_title;
            $this->session->set_flashdata('video_title',$this->data['video_title']); 
            $this->session->set_flashdata('video_description',$this->data['video_description']); 
            $this->load->view('upload_form_step2.php',$this->data);        
        } 

        if( $unique_id != '' && $status = '200' ){
            $name = $this->session->flashdata('video_title');
            $description =$this->session->flashdata('video_description');
            $this->video_m->add_video($unique_id, $name, $description, $user_profile['id']);
            $this->data['unique_id'] = $unique_id;
            $this->load->view('upload_success',$this->data);
            redirect('video/index/');

        } 

        $this->load->view('videos',$this->data);
    }

    $this->load->view('include/footer',$this->data);
}


public function login(){

  $user = $this->fb->getUser();


  if ($user) {
    try {
        $data['user_profile'] = $this->fb->sdk->api('/me');        
    } catch (FacebookApiException $e) {
        $user = null;
    }
} else {
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

    public function delete_video($id){        
       $video = $this->video_m->get_video($id);
       if(!empty($video)){
        if($this->user_profile['id'] == $video->uploader){
            if ($this->video_m->delete_video($id))
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

    // public function upload_file()
    // {
    //     if($this->user_profile != NULL){
    //         $status = "";
    //         $msg = "";
    //         $file_element_name = 'userfile';
    //         $name_input = 'name';

    //         $config['upload_path'] = $this->video_m->upload_path;
    //         $config['allowed_types'] = 'mpeg|mpg|mov|avi|mp4|jpg|png|gif|wmv';
    //         $config['max_size'] = 1024 * 47;
    //         $config['encrypt_name'] = TRUE;
    //         $this->load->library('upload', $config);


    //         if (!$this->upload->do_upload($file_element_name))
    //         {
    //             $status = 'error';
    //             $this->data['error'] = $this->upload->display_errors('', '');
    //         }
    //         else
    //         {
    //             $data = $this->upload->data();
    //             $name_from_input = $this->input->post($name_input);
    //             $name = empty($name_from_input) ? $data['orig_name'] : $name_from_input;
    //             $uploader =  $this->user_profile;

    //             $file_id = $this->video_m->insert_file($data['file_name'],$name, $uploader['id']);
    //             if($file_id)
    //             {
    //                 $status = "success";
    //                 $this->data['error'] = "File successfully uploaded";
    //             }
    //             else
    //             {
    //                 unlink($data['full_path']);
    //                 $status = "error";
    //                 $this->data['error'] = "Something went wrong when saving the file, please try again.";
    //             }
    //         }
    //         @unlink($_FILES[$file_element_name]);

    //         $this->session->set_flashdata('error',$this->data['error']); 
    //     }
    //     redirect('video/index/');
    // }

    // public function delete_file($file_id)
    // {
    //     $video = $this->video_m->get_video($file_id);
    //     if(!empty($video)){
    //         if($this->user_profile['id'] == $video->uploader){

    //             if ($this->video_m->delete_file($file_id))
    //             {
    //                 $status = 'success';
    //                 $this->data['error'] = 'File successfully deleted';
    //             }
    //             else
    //             {
    //                 $status = 'error';
    //                 $this->data['error'] = 'Something went wrong when deleteing the file, please try again';
    //             }
    //             $this->session->set_flashdata('error',$this->data['error']); 
    //         }
    //     }
    //     redirect('video/index/');
    // }



}

