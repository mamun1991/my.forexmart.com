<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fx_mailer');
        $this->load->model('user_model');
        $this->load->library('password_hash');
        $this->lang->load('forgotpassword');
    }



    public function index(){
       
        $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|callback_checkExistingEmail|xss_clean');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|callback_checkExistingAccountNumber|xss_clean');

        $data['metadata_keyword'] = lang('metadata_keyword');
        $data['metadata_description']=  lang('metadata_description');
        if($this->form_validation->run()){

            $getUserId = $this->user_model->getIdbyAccNumClientPartner($this->input->post('account_number',true));

            if($getUserId){

                if(strtolower($getUserId['email']) != strtolower($this->input->post('Email',true))){
                    $this->session->set_flashdata('wrong_email', 'Email address does not match with account number');


                    redirect(FXPP::my_url('forgot-password'));
                }



                $getLoginType = empty($getUserId['account_number']) ? 1 : 0; // 0 client - 1 partner

                $forgotpass = array(
                    'Email' =>$getUserId['email'],// $this->input->post('Email',true),
                    'Hash' => $hash=Custom_library::generateGUIDForgotPassword(),
                    'Account_number' => $this->input->post('account_number',true),
                    'user_id' => $getUserId['id'],
                    'login_type' => $getLoginType
                );

                $this->general_model->insert("user_forgot_password",$forgotpass);

                $usr_prfl = $this->general_model->showssingle2($table='user_profiles',$field="user_id",$id=$getUserId['id'],$select="full_name",$order_by="");
                $forgotpass2 = array(
                    'Email' =>$getUserId['email'], //$this->input->post('Email',true),
                    'Hash' => $hash,
                    'Account_number' => $this->input->post('account_number',true),
                    'user_id' => $getUserId['id'],
                    'login_type' => $getLoginType,
                    'full_name' =>$usr_prfl['full_name']
                );
                $this->fx_mailer->forgot_password_v2($forgotpass2);

                $data['success'] = true;

                $this->session->set_flashdata("success", 'ok');
                $this->session->set_userdata('userIdForRePass', 'RePass');

                redirect(FXPP::my_url('forgot-password'));
            }else{
                $this->session->set_flashdata('wrong_email', 'Email address does not match with account number');
                redirect(FXPP::my_url('forgot-password'));
            }
        }

        $this->template->title("ForexMart | Forgot Password")
            ->set_layout('external/main')
            ->build('forgot_password',$data);
    }

    public function checkExistingAccountNumber($acc_num){
        $checkExistingEmail = $this->user_model->checkExistingAccountNumber($acc_num);
        
        
        
//        if ($checkExistingEmail) {
//            $validateForgotDetails = $this->user_model->validateForgotDetails($this->input->post('Email'), $acc_num);
//
//            if($validateForgotDetails){
//                return TRUE;
//            }else{
//                $this->form_validation->set_message('checkExistingAccountNumber', "Invalid account number.");
//                return FALSE;
//            }
//        } else {
//            $this->form_validation->set_message('checkExistingAccountNumber', "Account number does not exist.");
//            return FALSE;
//        }

        
        
        

        if(!$checkExistingEmail){
                $this->form_validation->set_message('checkExistingAccountNumber', lang('prof_fgt_03'));
            return FALSE;
        }

//        $validateForgotDetails = $this->user_model->validateForgotDetails($this->input->post('Email',true), $acc_num);
//        if(!$validateForgotDetails){
//            $this->form_validation->set_message('checkExistingAccountNumber', "Invalid account number.");
//            return FALSE;
//        }

        $account_info = array(
            'iLogin' => $acc_num
        );

        $webservice_config = array(
            'server' => 'live_new'
        );

//        $WebService = new WebService($webservice_config);
//        $WebService->open_RequestAccountDetails($account_info);

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

        if ($WebService->request_status === 'RET_ACCOUNT_NOT_FOUND') {
            $this->form_validation->set_message('checkExistingAccountNumber',  lang('prof_fgt_01'));
            return FALSE;
        }

        return TRUE;

    }

    public function checkExistingEmail($email){
        $checkExistingEmail = $this->user_model->checkExistingEmail($email);
        
               
          if (!$checkExistingEmail) {
                $checkExistingEmail = $this->user_model->checkExistingEmail(strtolower($email));
          }
        
        
        
        if (!$checkExistingEmail) {
            $this->form_validation->set_message('checkExistingEmail', lang('prof_fgt_02'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function reset_password($token){
       // redirect('forget-password/token-expired'); // Switch off option to restore password please. THIS IS HIGHEST PRIORITY NOW!
        if($token){
            if($this->user_model->deleteExpiredTokens()){
//                $validateToken = $this->user_model->validateToken($token);
                $validateToken = $this->user_model->validateToken_v2($token);
                if($validateToken){
                    $getForgotPasswordDetails = $this->user_model->getForgotPasswordDetails($token);
                    $data['token'] = $token;
                        $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $this->input->post('password',true));
                        $this->user_model->change_password( $getForgotPasswordDetails[0]['user_id'], (string)$hash_password );


                    $this->load->library('WebService');
                        $webservice_config = array(
                            'server' => 'live_new'
                        );

                        $WebService1 = new WebService($webservice_config);
                        $WebService1->GeneratePassword();
                        $password = $WebService1->get_all_result();

                        $rstData = array(
                            'Email' => $getForgotPasswordDetails[0]['Email'],
                            'Account_number' =>$getForgotPasswordDetails[0]['Account_number'],
                            'new_password' => $password
                        );

                        $this->general_model->delete('user_forgot_password','Hash',$token);
                        $this->fx_mailer->reset_password($rstData);
                        $newdata = array(
                            'rst_pass'  => true
                        );
                        $this->session->set_userdata($newdata);

                        $service_data = array(
                            'iLogin' => $getForgotPasswordDetails[0]['Account_number'],
                            'strNewPass' => $rstData['new_password']
                        );
                        $WebService = new WebService($webservice_config);
                        $WebService->ChangeUserMasterPasswordAdmin($service_data);
                        $redirects = $getForgotPasswordDetails[0]['login_type'] ? 'partner' : 'client';


                        $old_password = "";

                        if ($WebService->request_status === 'RET_OK') {

                            $live = $this->general_model->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $getForgotPasswordDetails[0]['user_id'] , $select = 'account_number,trader_password');
                            if($live){
                                $datax['update'] = array(
                                    'trader_password' => $rstData['new_password']
                                );
                                $old_password = $live['trader_password'];
                                $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $getForgotPasswordDetails[0]['user_id'] , $datax['update']);
                            }else{

                                $live = $this->general_model->showssingle2($table = 'partnership', $field = 'partner_id', $id = $getForgotPasswordDetails[0]['user_id'] , $select = 'reference_num,trader_password');
                                $old_password = $live['trader_password'];
                                $datax['update'] = array(
                                    'trader_password' => $rstData['new_password']
                                );
                                $this->general_model->updatemy($table = 'partnership', $field = 'partner_id', $id = $getForgotPasswordDetails[0]['user_id'] , $datax['update']);
                            }

                            //redirect(FXPP::my_url($redirects.'/signin'));
                        }

                    $log = array(
                        'email' =>$getForgotPasswordDetails[0]['Email'],
                        'account_number' =>$getForgotPasswordDetails[0]['Account_number'],
                        'old_password' => $old_password,
                        'token' => $token,
                        'ip' => $this->input->ip_address()
                    );

                    $this->general_model->insert("forgot_password_log",$log);

                        redirect(FXPP::my_url($redirects.'/signin'));


                }else{
                    $this->token_expired();
                }
            }else{

                $this->token_expired();
            }

        }else{
            show_404();
        }
    }

    private  function token_expired(){
        $this->template->title("ForexMart | Forgot Password")
            ->set_layout('external/main')
            ->build('token_expired');
    }

    public function reset_password1($token){
        if($token){
            if($this->user_model->deleteExpiredTokens()){
                $validateToken = $this->user_model->validateToken($token);
                if(!$validateToken){
                    $getForgotPasswordDetails = $this->user_model->getForgotPasswordDetails($token);
                    $data['token'] = $token;
                    $this->form_validation->set_rules('password', 'Password', 'required|callback_passwordCheck['.$getForgotPasswordDetails[0]['Email'].']');
                    $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');

                    if ($this->form_validation->run() == TRUE){
                        $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $this->input->post('password',true));
                        $this->user_model->change_password( $getForgotPasswordDetails[0]['user_id'], (string)$hash_password );
                        $rstData = array(
                            'Email' => $getForgotPasswordDetails[0]['Email'],
                            'new_password' => $this->input->post('password',true)
                        );
                        $this->general_model->delete('user_forgot_password','Hash',$token);
                        $this->fx_mailer->reset_password($rstData);
                        $newdata = array(
                            'rst_pass'  => true
                        );
                        $this->session->set_userdata($newdata);

                        $redirects = $getForgotPasswordDetails[0]['login_type'] ? 'partner' : 'client';
                        $this->load->library('WebService');
                        $webservice_config = array(
                            'server' => 'live_new'
                        );
                        $service_data = array(
                            'iLogin' => $getForgotPasswordDetails[0]['Account_number'],
                            'strNewPass' => $rstData['new_password']
                        );
                        $WebService = new WebService($webservice_config);
                        $WebService->ChangeUserMasterPasswordAdmin($service_data);
                        $redirects = $getForgotPasswordDetails[0]['login_type'] ? 'partner' : 'client';

                        if ($WebService->request_status === 'RET_OK') {
                            redirect(FXPP::my_url($redirects.'/signin'));
                        }

                        redirect(FXPP::my_url($redirects.'/signin'));
                    }

                    $this->template->title("Reset Password | ForexMart")
                        ->set_layout('external/main')
                        ->build('forgot_reset_password', $data);
                }else{
                    show_404();
                }
            }else{
                show_404();
            }

        }else{
            show_404();
        }
    }

   
    public function passwordCheck($pass, $email)
    {
        $password = urldecode($pass);
        $this->load->library('Tank_auth');
        $this->load->model('tank_auth/users');
        if (!is_null($users = $this->users->get_user_by_email($email))) { // login ok



            //print_r($users);
            //exit();
            // Does password match hash in database?

            $hasher = new PasswordHash(
                $this->config->item('phpass_hash_strength', 'tank_auth'),
                $this->config->item('phpass_hash_portable', 'tank_auth'));

            foreach ($users as $user) {
                if ($hasher->CheckPassword($password, $user->password)) { // password ok
                        $this->form_validation->set_message('passwordCheck', lang('prof_fgt_04'));
                    return FALSE;
                }
            }
        } else {
            $this->form_validation->set_message('passwordCheck', "Invalid user.");
            return FALSE;
        }

        return TRUE;

    }

    public function delete_expired_tokens(){
        if($this->user_model->deleteExpiredTokens()){
            echo 'deleted';
        }else{
            echo 'failed';
        }
    }

    private  function autoPassword($nc, $a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        $l=strlen($a)-1; $r='';
        while($nc-->0) $r.=$a{mt_rand(0,$l)};
        return $r;
    }


    public function reset_password_test($token){
        if (!IPLOC::Office_and_Vpn()){die();}
var_dump($token);
        if($token){
            if($this->user_model->deleteExpiredTokens()){
                $validateToken = $this->user_model->validateToken_v2($token);
                if($validateToken){
                    $getForgotPasswordDetails = $this->user_model->getForgotPasswordDetails($token);
                    $data['token'] = $token;
                    $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $this->input->post('password',true));
                    $this->user_model->change_password( $getForgotPasswordDetails[0]['user_id'], (string)$hash_password );
                    $rstData = array(
                        'Email' => $getForgotPasswordDetails[0]['Email'],
                        'new_password' => $this->autoPassword(8)
                    );
                    $this->general_model->delete('user_forgot_password','Hash',$token);
                    $this->fx_mailer->reset_password($rstData);
                    $newdata = array(
                        'rst_pass'  => true
                    );
                    $this->session->set_userdata($newdata);
                    $redirects = $getForgotPasswordDetails[0]['login_type'] ? 'partner' : 'client';
                    $this->load->library('WebService');
                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $service_data = array(
                        'iLogin' => $getForgotPasswordDetails[0]['Account_number'],
                        'strNewPass' => $rstData['new_password']
                    );
                    $WebService = new WebService($webservice_config);
                    $WebService->ChangeUserMasterPasswordAdmin($service_data);
                    $redirects = $getForgotPasswordDetails[0]['login_type'] ? 'partner' : 'client';

                    if ($WebService->request_status === 'RET_OK') {
                        redirect(FXPP::my_url($redirects.'/signin'));
                    }

                    redirect(FXPP::my_url($redirects.'/signin'));


                }else{
                    echo 'x1';
//                    show_404();
                }
            }else{
                echo 'x2';
//                show_404();
            }

        }else{
            echo 'x3';
//            show_404();
        }
    }
}

