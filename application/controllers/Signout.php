<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signout extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        
        

    }
    public function index(){
        
            if(FXPP::getAutoLoginRemoveAccess()){  
 
                          $login_type = $this->session->userdata('login_type');
                          $google_login = $this->session->userdata('oauth_provider');

                          if((int)$login_type == 1){
                              $this->tank_auth->logout();
                              header('Location: '.FXPP::loc_url('partner/signin'));
                          }else{

                              if(isset($google_login)){
                                  if($google_login = 'facebook'){
                  //                    $this->facebook->logout_url();
                  //                    $this->facebook->destroy_session();
                                  } else {
                                      $this->session->unset_userdata('access_token');
                                      $this->session->unset_userdata('userdata');
                                      $this->session->sess_destroy();
                                  }
                              }


                              $this->tank_auth->logout();

                              header('Location: '.FXPP::loc_url('client/signin'));
                          }

            }else{
 
                 //session_destroy();
               
                 $this->session->unset_userdata('access_token');
                 $this->session->unset_userdata('userdata');
                
                  unset($_COOKIE[$this->config->item('cookie_domain')]);
                  
                  $this->tank_auth->updateSpecialSession();
                  
                  header('Location: '.FXPP::loc_url('client/signin'));
            }

    }

    public function autoSignout(){
        $this->tank_auth->logout();
    }
}
