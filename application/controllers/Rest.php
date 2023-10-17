<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tank_auth/users');
        $this->load->model('General_model');
        $this->g_m=$this->General_model;
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('TFA');
        $this->load->model('cabinet_model');

    }

    public function signin(){
        $account_number =  $this->session->userdata('ex_account_number');
        if ($user_info = $this->cabinet_model->getUserInfoByAccount($account_number)) {
            $this->session->set_userdata('AccountType', 0);

            //$strLogin = $account_number;
            //$strPassowrd = $service_data['strPassword'];
            // $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);

            $this->session->set_userdata(array(
                'full_name'      => $user_info->full_name,
                'user_id'        => $user_info->id,
                'username'       => $user_info->username,
                'email'          => $user_info->email,
                'logged_in'      => true,
                'logged'         => 1,
                'status'         => 1,
                'administration' => $user_info->administration,
                'login_type'     => $user_info->login_type,
            ));

            redirect(FXPP::my_url('my-account'));
        }
    }


}
