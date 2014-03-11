<?php
class Main_Controller extends MY_Controller 
{
  
  function __construct()
  {
		parent::__construct();
              $this->load->library('fb'); // Automatically picks appId and secret from config
              $this->user_profile = $this->getUserProfile();
             
             // $this->load->library('form_validation');
        // OR
        // You can pass different one like this
        //$this->load->library('facebook', array(
        //    'appId' => 'APP_ID',
        //    'secret' => 'SECRET',
        //    ));
  }


  function getUserProfile(){
      $user_id = $this->fb->sdk->getUser();
        if($user_id) {      
          try {
            $user_profile = $this->fb->sdk->api('/me');                                    
            return $user_profile;           
        } catch(FacebookApiException $e) {            
            error_log($e->getType());
            error_log($e->getMessage());        
          }   
        } else {          
      }
    return NULL;
  }


}


