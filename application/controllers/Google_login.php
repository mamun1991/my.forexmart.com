<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('google_login_model');
    }

    public function index(){
        echo 'test';
//        require_once APPPATH . 'vendor/autoload.php';
//
//
//        $google_client = new Google_Client();
//
//        $google_client->setClientId('717295422510-t5h099m0gojohrnnrh1pfgieqtjocnrg.apps.googleusercontent.com');
//        $google_client->setClientSecret('t-D9WZu2bSQWr38kBz6kFYWA');
//        $google_client->setRedirectUri(FXPP::my_url('Google_login'));
//        $google_client->addScope('email');
//        $google_client->addScope('profile');
//
//
//        if(isset($_GET['code'])){
//            $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
//
//            if(!isset($token['error'])){
//                $google_client->setAccessToken($token['access_token']);
//                $this->session->userdata('access_token', $token['access_token']);
//                $google_service = new Google_Service_Oauth2($google_client);
//                $data = $google_service->userinfo->get();
//                $current_datetime = date('Y-m-d H:i:s');
////                var_dump($data);
//
//
//
//                if($this->general_model->showssingle('users', 'login_oauth_id', $data['id'])){
////                    NOT first timer
////                    $user_prof = array(
////                        'full_name' => $data['given_name'] . $data['family_name'],
////                        'image'     => $data['picture'],
////                    );
////
////                    $this->general_model->updatemy('user_profiles', 'login_oauth_id', $data['id'], $user_prof);
////
////                    $user_data = array(
////                        'email'     => $data['email'],
////                        'modified'  => $current_datetime
////                    );
////
////                    $this->general_model->updatemy('users', 'login_oauth_id', $data['id'], $user_data);
//                }else{
//
//
//
////                    $user_data = array(
////                        'login_oauth_id'    => $data['id'],
////                        'email'             => $data['email'],
////                        'created'           => $current_datetime
////                    );
////
////                    $this->general_model->insert('users', $user_data);
//
////                    $login_type = 0; // 0 = client, 1 = partner
////
////                    $user_data = array(
////                        'login_oauth_id'    => $data['id'],
////                        'email'		=> $data['email'],
////                        'last_ip'	=> $this->ci->input->ip_address(),
////                        'type'      => 1,
////                        'login_type' => $login_type,
////                    );
////
////
////                    $user_prof = array(
////                        'login_oauth_id'    => $data['id'],
////                        'user_id'           => $user_data['user_id'],
////                        'full_name'         => $data['given_name'] . $data['family_name'],
////                        'image'             => $data['picture'],
////                    );
////
////                    $this->general_model->insert('user_profiles', $user_prof);
//
//                }
//            }
//        }
//
//        if(!$this->session->userdata('access_token')){
//            echo $login_button = '<a href="'.$google_client->createAuthUrl().'" class="btn btn-block btn-google btn-flat">
//                                    <img src="'.$this->template->Images().'google-icon.png" class="google-icon"> Sign in using Google</a>';
//        }

    }


}