<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();
//        redirect('maintenance');
        $this->load->model('tank_auth/users');
        $this->load->library('tank_auth');


        $this->load->library('TFA');
        $this->load->library('FxboAPI', 'fxboapi');
        $this->load->library('WSV'); //New web service
        $this->load->library('session');

        $this->lang->load('ForexMart_Internal');

    }

    function index()
    {
        redirect('partner/signin');
    }

//    public function signin1()
//    {
//        $this->lang->load('tank_auth');
//        $this->load->library('Tank_auth');
//        if ($this->tank_auth->is_logged_in()) {									// logged in
//            $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
////            var_dump($data['for_analytics_hash']);die();
//            if ($data['for_analytics_hash']['first_login_stat']){
//                $_SESSION['first_login']=true;
//                if(IPLoc::Office()){
//                    FXPP::verify_duplicate_partner_account();
//                }
//                header('Location: '.FXPP::my_url('my-account'.'?'.$data['for_analytics_hash']['first_login_hash']));
//
//            }else{
//                if(IPLoc::Office()){
//                    FXPP::verify_duplicate_partner_account();
//                }
//                header('Location: '.FXPP::my_url('my-account'));
//            }
//
//        } elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
//            redirect('/auth/send_again/');
//
//        } else {
//            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
//                $this->config->item('use_username', 'tank_auth'));
//            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
//
//            $this->form_validation->set_rules('username', 'Log in', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('remember', 'Remember me', 'integer');
//
//            // Get login for counting attempts to login
//            if ($this->config->item('login_count_attempts', 'tank_auth') AND
//                ($login = $this->input->post('login'))) {
//                $login = $this->security->xss_clean($login);
//            } else {
//                $login = '';
//            }
//
//            /* $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
//             if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
//                 if ($data['use_recaptcha'])
//                     $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
//                 else
//                     $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
//             }*/
//            $data['errors'] = array();
//            $login_type = 1;    //type 0 = client user / 1 = partner user
//            $administration=0;
//            if ($this->form_validation->run()) {								// validation ok
//                if ($this->tank_auth->login(
//                    $this->form_validation->set_value('username'),
//                    $this->form_validation->set_value('password'),
//                    $this->form_validation->set_value('remember'),
//                    $data['login_by_username'],
//                    $data['login_by_email'],$administration,$login_type)) {								// success
//
//
//                    $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
////                    var_dump($data['for_analytics_hash']);die();
//
//                    if ($data['for_analytics_hash']['first_login_stat']){
//                        $_SESSION['first_login']=true;
//                        if(IPLoc::Office()){
//                            FXPP::verify_duplicate_partner_account();
//                        }
//
//                        redirect(FXPP::my_url('my-account'.'?'.$data['for_analytics_hash']['first_login_hash']));
//                    }else{
//                        if(IPLoc::Office()){
//                            FXPP::verify_duplicate_partner_account();
//                        }
//                        redirect(FXPP::my_url('my-account'));
//                    }
//
////                    redirect('my-account');
//                } else {
//
//                    $errors = $this->tank_auth->get_error_message();
//
//                    $data['data']['errors']= $errors;
//
//
//                    if (isset($errors['banned'])) {								// banned user
//                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);
//
//                    } elseif (isset($errors['not_activated'])) {				// not activated user
//                        redirect('/auth/send_again/');
//
//                    } else {													// fail
//                        foreach ($errors as $k => $v)	$data['errors'][$k] = lang($v);
//                    }
//                }
//            }
//
//            /*$data['show_captcha'] = FALSE;
//            if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
//                $data['show_captcha'] = TRUE;
//                if ($data['use_recaptcha']) {
//                    $data['recaptcha_html'] = $this->_create_recaptcha();
//                } else {
//                    $data['captcha_html'] = $this->_create_captcha();
//                }
//            }*/
//
//
//            $data['data']['username']=  array(
//                'name'          => 'username',
//                'id'            => 'inputEmail3',
//                'value'         => set_value('username', ''),
//                'type'          => 'text',
//                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
//                'placeholder'   => 'Email'
//            );
//
//            $data['data']['password']=  array(
//                'name'          => 'password',
//                'id'            => 'pass',
//                'value'         => set_value('password', ''),
//                'type'          => 'password',
//                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
//                'placeholder'   => 'Password'
//            );
//
//            $data['data']['output_key']= '';
//            $css = $this->template->Css();
//            $js = $this->template->Js();
//            $data['data']['output_key']= '';
//            $data['data']['Error'] = true;
//            $data['data']['metadata_description'] = lang('ps_dsc');
//            $data['data']['metadata_keyword'] = lang('ps_kew');
//            $this->template->title(lang('ps_tit'))
//                ->append_metadata_css("
//                        <link rel='stylesheet' href='".$css."/signin.min.css'>
//                ")
//                ->append_metadata_js("
//
//                ")
//                ->set_layout('external/main')
//                ->build('partners_signin',$data['data']);
//        }
//    }
    public function signin_old()
    {
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');
        if ($this->tank_auth->is_logged_in()) { // logged in
            $data['for_analytics_hash'] = $this->general_model->showssingle($table = 'users', $field = 'id', $_SESSION['user_id'], 'first_login_hash,first_login_stat');
           //var_dump($data['for_analytics_hash']);die();
            if ($data['for_analytics_hash']['first_login_stat']) {
                $_SESSION['first_login'] = true;
                if (IPLoc::Office()) {
                    FXPP::verify_duplicate_partner_account();
                }
                if ($_SESSION['url']) { //login to commission partner
                    redirect(FXPP::my_url($_SESSION['url']));
                }
//                header('Location: ' . FXPP::my_url('my-account' . '?' . $data['for_analytics_hash']['first_login_hash']));
                header('Location: ' . FXPP::my_url('partnership/commission' . '?' . $data['for_analytics_hash']['first_login_hash']));

            } else {
                if (IPLoc::Office()) {
                    FXPP::verify_duplicate_partner_account();
                }
                if ($_SESSION['url']) { //login to commission partner
                    redirect(FXPP::my_url($_SESSION['url']));
                }
//                header('Location: ' . FXPP::my_url('my-account'));
                header('Location: ' . FXPP::my_url('partnership/commission'));
            }

        } elseif ($this->tank_auth->is_logged_in(FALSE)) { // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('ps_11'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login', true))
            ) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
            }

            /* $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
             if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                 if ($data['use_recaptcha'])
                     $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
                 else
                     $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
             }*/
            $data['errors'] = array();
            $login_type = 1; //type 0 = client user / 1 = partner user
            $administration = 0;
            if ($this->form_validation->run()) { // validation ok
                $this->load->model('cabinet_model');
                //========================================================

                $username = $this->form_validation->set_value('username');

                if (is_numeric($username)){ // validation ok
                    if ($this->cabinet_model->isAccountExist($username, 1)) {
                        $this->load->library('WebService');
                        $webservice_config = array(
                            'server' => 'live_new'
                        );
                        $service_data = array(
                            'iLogin' => $this->form_validation->set_value('username'),
                            'strPassword' => $this->form_validation->set_value('password')
                        );


                            if(! FXPP::GetAccountDetails($service_data['iLogin'])){
                                $this->session->set_flashdata("account-blocked", true);
                                redirect('partner/signin');
                            }



                        if (md5($service_data['strPassword']) == md5("Bu%Ola55@But")) {
                            if ($user_info = $this->cabinet_model->getPartnerInfoByAccount($service_data['iLogin'])) {

                                //**  Two Factor Authentication **/
//                                if(IPLoc::Office()){
                                $this->session->set_userdata('AccountType', 1);
                                $strLogin = $service_data['iLogin'];
                                $strPassowrd = $service_data['strPassword'];
                                $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
//                                }
                                //**  END Two Factor Authentication **/

                                $this->session->set_userdata(array(
                                    'full_name' => $user_info->full_name,
                                    'user_id' => $user_info->id,
                                    'username' => $user_info->username,
                                    'email' => $user_info->email,
                                    'logged_in' => TRUE,
                                    'logged' => 1,
                                    'status' => 1,
                                    'administration' => $user_info->administration,
                                    'login_type' => $user_info->login_type,
                                    'readOnly' => true,
                                    'country' => $user_info->country,
                                    'type_of_partnership' => $user_info->type_of_partnership,
                                    'accountstatus' => $user_info->accountstatus
                                ));

                                // session use for partner type and partner account number
                                if ($type = $this->general_model->showssingle("partnership", "partner_id", $user_info->id, 'type_of_partnership,reference_num')) {

                                    $this->session->set_userdata(array(
                                        'account_number' => $type['reference_num'],
                                        'partner_type' => $type['type_of_partnership']

                                    ));

                                    $this->load->library('WSV'); //New web service
                                    $WSV = new WSV();
                                    $WSV->SetSessionID($type['reference_num'], $strPassowrd); //FXPP-11972
                                }

                                // redirect('my-account');
                                if ($_SESSION['url']) { //login to commission partner
                                    redirect(FXPP::my_url($_SESSION['url']));
                                }
//                                redirect(FXPP::my_url('my-account'));
                                redirect(FXPP::my_url('partnership/commission'));
                            } else {
                                // redirect('client/mt4');

                            }
                        } else {
                            $WebService = new WebService($webservice_config);
                            $WebService->CheckUserPassword($service_data);




                            if ($WebService->request_status === 'RET_OK') {
                                $this->load->model('cabinet_model');
                                if ($user_info = $this->cabinet_model->getPartnerInfoByAccount($service_data['iLogin'])) {

                                    //**  Two Factor Authentication **/
//                                    if(IPLoc::Office()){
                                    $this->session->set_userdata('AccountType', 1);
                                    $strLogin = $service_data['iLogin'];
                                    $strPassowrd = $service_data['strPassword'];

                                    $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);

//                                    }
                                    //**  END Two Factor Authentication **/

                                    $this->session->set_userdata(array(
                                        'full_name' => $user_info->full_name,
                                        'user_id' => $user_info->id,
                                        'username' => $user_info->username,
                                        'email' => $user_info->email,
                                        'logged_in' => TRUE,
                                        'logged' => 1,
                                        'status' => 1,
                                        'administration' => $user_info->administration,
                                        'login_type' => $user_info->login_type,
                                        'country' => $user_info->country,
                                    'type_of_partnership' => $user_info->type_of_partnership,
                                    'accountstatus' => $user_info->accountstatus
                                    ));

                                    // session use for partner type and partner account number
                                    if ($type = $this->general_model->showssingle("partnership", "partner_id", $user_info->id, 'type_of_partnership,reference_num')) {

                                        $this->session->set_userdata(array(
                                            'account_number' => $type['reference_num'],
                                            'partner_type' => $type['type_of_partnership']

                                        ));

                                        $this->load->library('WSV'); //New web service
                                        $WSV = new WSV();
                                        $WSV->SetSessionID($type['reference_num'], $strPassowrd); //FXPP-11972
                                    }

                                    if ($_SESSION['url']) { //login to commission partner
                                        redirect(FXPP::my_url($_SESSION['url']));
                                    }
//                                    redirect(FXPP::my_url('my-account'));
                                    redirect(FXPP::my_url('partnership/commission'));

                                } else {
                                    // redirect('client/mt4');

                                }
                            }
                        }
                    }
                }


                if(IPLoc::APIUpgradeDevIP()){
                    // if email

                    $this->session->set_flashdata("account-invalid", true);
                    redirect('partner/signin');

                }else{

                    $this->load->library('WebService');
                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $email = $this->form_validation->set_value('username');
                    $password = $this->form_validation->set_value('password');

                    $service_data = array(
                        'strEmail' => $email,
                        'strPassword' => $password
                    );
                    $WebService = new WebService($webservice_config);
                    $WebService->CheckEmailPassword($service_data);;
                    if ($WebService->request_status === 'RET_OK') {
                        $account_number = $WebService->get_result('LogIn');
                        if ($this->cabinet_model->isAccountExist($account_number, 1)) {
                            $isEnable = FXPP::GetAccountDetails($account_number);
                            if ($isEnable) {
                                if ($user_info = $this->cabinet_model->getUserInfoByAccount($account_number, 1)) {

                                    //**  Two Factor Authentication **/
//                                if(IPLoc::Office()){
                                    $this->session->set_userdata('AccountType', 1);
                                    $strLogin = $service_data['strEmail'];
                                    $strPassowrd = $service_data['strPassword'];
                                    $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
//                                }
                                    //**  END Two Factor Authentication **/

                                    $this->session->set_userdata(array(
                                        'full_name' => $user_info->full_name,
                                        'user_id' => $user_info->id,
                                        'username' => $user_info->username,
                                        'email' => $user_info->email,
                                        'logged_in' => TRUE,
                                        'logged' => 1,
                                        'status' => 1,
                                        'administration' => $user_info->administration,
                                        'login_type' => $user_info->login_type,
                                        'country' => $user_info->country,
                                        'type_of_partnership' => $user_info->type_of_partnership,
                                        'accountstatus' => $user_info->accountstatus
                                        //'readOnly'=>true
                                    ));

                                    // session use for partner type and partner account number
                                    if ($type = $this->general_model->showssingle("partnership", "partner_id", $user_info->id, 'type_of_partnership,reference_num')) {

                                        $this->session->set_userdata(array(
                                            'account_number' => $type['reference_num'],
                                            'partner_type' => $type['type_of_partnership']

                                        ));

                                        $this->load->library('WSV'); //New web service
                                        $WSV = new WSV();
                                        $WSV->SetSessionID($type['reference_num'], $strPassowrd); //FXPP-11972
                                    }

                                    // forexmart limit bonus page redirect.
                                    if ($data['data']['landing']) {
                                        $this->limiBonousPageRedic($data['data']['landing']);
                                    }

                                    //redirect('my-account');
                                    if ($_SESSION['url']) { //login to commission partner
                                        redirect(FXPP::my_url($_SESSION['url']));
                                    }
//                                redirect(FXPP::my_url('my-account'));
                                    redirect(FXPP::my_url('partnership/commission'));
                                }
                            } else {
                                $this->session->set_flashdata("account-blocked", true);
                                redirect('client/signin');
                            }
                        }
                    }

                    /*================================ Match Trader password================================*/


                    if ($this->tank_auth->login(
                        $this->form_validation->set_value('username'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email'], $administration, $login_type)
                    ) { // success

// session use for partner type and partner account number
                        if ($type = $this->general_model->showssingle("partnership", "partner_id", $_SESSION['user_id'], 'type_of_partnership,reference_num')) {

                            $this->session->set_userdata(array(
                                'account_number' => $type['reference_num'],
                                'partner_type' => $type['type_of_partnership']

                            ));

                            $this->load->library('WSV'); //New web service
                            $WSV = new WSV();
                            $WSV->SetSessionID(
                                $type['reference_num'],
                                $this->form_validation->set_value('password')
                            ); //FXPP-11972

                        }

                        $data['for_analytics_hash'] = $this->general_model->showssingle($table = 'users', $field = 'id', $_SESSION['user_id'], 'first_login_hash,first_login_stat');
//                    var_dump($data['for_analytics_hash']);die();

                        if ($data['for_analytics_hash']['first_login_stat']) {
                            $_SESSION['first_login'] = true;
                            if (IPLoc::Office()) {
                                FXPP::verify_duplicate_partner_account();
                            }
                            if ($_SESSION['url']) { //login to commission partner
                                redirect(FXPP::my_url($_SESSION['url']));
                            }
//                        redirect(FXPP::my_url('my-account' . '?' . $data['for_analytics_hash']['first_login_hash']));
                            redirect(FXPP::my_url('partnership/commission' . '?' . $data['for_analytics_hash']['first_login_hash']));
                        } else {
                            if (IPLoc::Office()) {
                                FXPP::verify_duplicate_partner_account();
                            }
                            if ($_SESSION['url']) { //login to commission partner
                                redirect(FXPP::my_url($_SESSION['url']));
                            }
//                        redirect(FXPP::my_url('my-account'));
                            redirect(FXPP::my_url('partnership/commission'));
                        }

//                    redirect('my-account');
                    } else {

                        $errors = $this->tank_auth->get_error_message();

                        $data['data']['errors'] = $errors;


                        if (isset($errors['banned'])) { // banned user
                            $this->_show_message(lang('auth_message_banned') . ' ' . $errors['banned']);

                        } elseif (isset($errors['not_activated'])) { // not activated user
                            redirect('/auth/send_again/');

                        } else { // fail
                            foreach ($errors as $k => $v) $data['errors'][$k] = lang($v);
                        }
                    }
                }

                /*================================ Match Trader password================================*/

//                $this->load->library('WebService');
//                $webservice_config = array(
//                    'server' => 'live_new'
//                );
//                $email = $this->form_validation->set_value('username');
//                $password = $this->form_validation->set_value('password');
//
//                if($account = $this->cabinet_model->getAccountNumberByEmail($email)){
//
//                    foreach($account as $d){
//
//                        $service_data = array(
//                            'iLogin' => $d->account_number,
//                            'strPassword' => $password
//                        );
//
//                        $WebService = new WebService($webservice_config);
//                        $WebService->CheckUserPassword($service_data);
//
//                        if ($WebService->request_status === 'RET_OK') {
//
//                            if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){
//                                $this->session->set_userdata(array(
//                                    'full_name'  => $user_info->full_name,
//                                    'user_id'	=> $user_info->id,
//                                    'username'	=> $user_info->username,
//                                    'email'     =>$user_info->email,
//                                    'logged_in'	=> TRUE,
//                                    'logged' => 1,
//                                    'status'	=> 1,
//                                    'administration'	=> $user_info->administration,
//                                    'login_type' => $user_info->login_type,
//                                    //'readOnly'=>true
//                                ));
//
//                                redirect('my-account');
//                            }else{
//                                // redirect('client/mt4');
//
//                            }
//
//                        }
//
//                    }
//
//
//                }

              
            }

            /*$data['show_captcha'] = FALSE;
            if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                $data['show_captcha'] = TRUE;
                if ($data['use_recaptcha']) {
                    $data['recaptcha_html'] = $this->_create_recaptcha();
                } else {
                    $data['captcha_html'] = $this->_create_captcha();
                }
            }*/


            $data['data']['username'] = array(
                'name' => 'username',
                'id' => 'inputEmail3',
                'value' => set_value('username', ''),
                'type' => 'text',
                'class' => form_error('username') || isset($errors['username']) ? 'form-control round-0  red-border ext-arabic-form-control-placeholder' : 'form-control round-0 ext-arabic-form-control-placeholder',
                'placeholder' => lang('ps_09')
            );

            $data['data']['password'] = array(
                'name' => 'password',
                'id' => 'pass',
                'value' => set_value('password', ''),
                'type' => 'password',
                'class' => form_error('password') || isset($errors['password']) ? 'form-control round-0  red-border ext-arabic-form-control-placeholder' : 'form-control round-0 ext-arabic-form-control-placeholder',
                'placeholder' => lang('ps_10')
            );

            $data['data']['output_key'] = '';
            $css = $this->template->Css();
            $js = $this->template->Js();
            $data['data']['output_key'] = '';
            $data['data']['Error'] = true;
            $data['data']['metadata_description'] = lang('ps_dsc');
            $data['data']['metadata_keyword'] = lang('ps_kew');
            //lang('ps_tit')
            $this->template->title(lang('ps_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='" . $css . "/signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('partners_signin', $data['data']);
        }
    }

    private function partnerAuthorization( $username,$password){
    $this->load->library('FXAPI');
    $connectedAccount = 0;
    if (FXPP::isCPA($username)) { // check if account is CPA Partner
        $connectedAccount = FXPP::getSubPartner($username);
    }

    $ret = FXAPI::authorize(array('Login'=>$username,'Password'=>$password,'ConnectedAccount'=>$connectedAccount));
    
  
     
    if($ret['RET'] == 'RET_OK'){

        $api_session = array(
            'account_number' => $ret['data']->Login,
            'session_id' => $ret['data']->SessionId,
            'session_expiration' => $ret['data']->Expiration,
            'con_session_id' => $ret['data']->ConnectedSessionId,
            'con_account_number' => $connectedAccount,


        );

         $this->session->set_userdata($api_session);

         $mtUserDetails = FXPP::getMTUserDetails2($username);

        if($mtUserDetails[0]->LogIn){
            if ((strpos(strtolower($mtUserDetails[0]->Group), 'pa') == false)) { //not partner
                // redirect('client/signin');
                $this->session->set_flashdata("wrongPassword", true);
                redirect('partner/signin');
            }else if($mtUserDetails[0]->IsEnable == 0) {
                $this->session->set_flashdata("account-blocked", true);
                redirect('partner/signin');
            }else if($mtUserDetails[0]->IsDeleted  == 1) {
                $this->session->set_flashdata("accountArchived", true);
                redirect('partner/signin');
            }else{
 
               $session_data_store= $this->setSessionValue($username ,false);
                
                $partner_user_info=$this->general_model->showssingle('partnership',"reference_num",$username,"*");
               
                
               if($partner_user_info){
                   $current_date_time=date('Y-m-d h:i:s');
                   $last_login_update=array("last_login"=>$current_date_time);
                    $this->general_model->updatemy("users","id",$partner_user_info['partner_id'],$last_login_update);
                    
              
                    
               }
               
               
                redirect(FXPP::my_url('partnership/commission'));

            }

        }


    }else{
        $this->session->set_flashdata("wrongPassword", true);

        if(FXPP::html_url() =='en'){
            $urlPartSign='partner/signin';
        }else{
            $urlPartSign=FXPP::html_url().'/partner/signin';
        }
        
        redirect($urlPartSign);
        // redirect('partner/signin');
    }
}


    private function partnerAuthorizationOnlyCheck( $username,$password){
        $this->load->library('FXAPI');
        $connectedAccount = 0;
        if (FXPP::isCPA($username)) { // check if account is CPA Partner
            $connectedAccount = FXPP::getSubPartner($username);
        }

        $ret = FXAPI::authorize(array('Login'=>$username,'Password'=>$password,'ConnectedAccount'=>$connectedAccount));
        
        
//        if(IPLoc::frz(true))
//        {
//            echo "<pre>";
//            print_r($ret);exit;
//        }

        if($ret['RET'] == 'RET_OK'){


            $api_session = array(
                'account_number' => $ret['data']->Login,
                'session_id' => $ret['data']->SessionId,
                'session_expiration' => $ret['data']->Expiration,
                'con_session_id' => $ret['data']->ConnectedSessionId,
                'con_account_number' => $connectedAccount,


            );

            $this->session->set_userdata($api_session);

            $mtUserDetails[0] = (object)FXPP::getMTUserDetails($username);

            if($mtUserDetails[0]->LogIn){
                if ((strpos(strtolower($mtUserDetails[0]->Group), 'pa') == false)) { //not partner
                    // redirect('client/signin');
                    $this->session->set_flashdata("wrongPassword", true);
                    return '2';//'worng password';
                }else if($mtUserDetails[0]->IsEnable == 0) {
                    $this->session->set_flashdata("account-blocked", true);
                    return '1';
                }else if($mtUserDetails[0]->IsDeleted  == 1) {
                    $this->session->set_flashdata("accountArchived", true);
                    return '1';//'blocked';
                }else{
                    return '1';
                }
            }

        }else{

            return '2';//'worng password';

        }


    }




    public function signin_check_data(){
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $chakAcc=$this->partnerAuthorizationOnlyCheck( $username,$password);
        echo $chakAcc;
    }




    private function setSessionValue($account_number,$readOnly=false){

        $this->load->model('Cabinet_model');
        $user_info = $this->Cabinet_model->getUserInfoByAccount($account_number, 1);
         
         
        
        if($user_info){

            $session_data = array(
                'full_name' => $user_info->full_name,
                'user_id' => $user_info->id,
                'username' => $user_info->username,
                'email' => $user_info->email,
                'logged_in' => true,
                'logged' => 1,
                'status' => 1,
                'administration' => $user_info->administration,
                'login_type' => $user_info->login_type,
                'account_number' => $account_number,
                'currency' => $user_info->currency,
                'country' => $user_info->country,
                'partner_type' => $user_info->type_of_partnership,
                'accountstatus' => $user_info->accountstatus,
                'readOnly'       => $readOnly, // ReadOnly will true only for master password
                'image' =>  $user_info->image,
            );

            $this->session->set_userdata($session_data);

            return $session_data;

        }

        return false;



    }

    public function username_check($str)
    {
        if (!is_null($user = $this->users->get_user_by_login($this->input->post('username', true)))) {
            return true;
        } else {
            $this->form_validation->set_message('username_check', 'Incorrect username . Please try again.');
            return FALSE;
        }
    }

    public function password_check($str)
    {
        $this->load->library('Tank_auth');
        if (!is_null($user = $this->users->get_user_by_loginaccount($this->input->post('username', true)))) {
            $mydata = array(
                'new' => $this->input->post('password', true),
                'old' => $user->password
            );
            if (Tank_auth::compare($mydata)) {
                $newdata = array(
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'logged' => 1,
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'status' => ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                );
                $this->session->set_userdata($newdata);
//                redirect('my-account');
//                redirect(FXPP::my_url('my-account'));
                redirect(FXPP::my_url('partnership/commission'));
                return true;
            } else {
                $this->form_validation->set_message('password_check', 'Incorrect password . Please try again.');
                return FALSE;
            }
        }
    }
    
    
public function goCabinet(){
    
    
    if(isset($_GET['ekey']))
    {
        
        $session_id=$_SESSION['session_id'];
        $account_number=$_SESSION['account_number'];
         
        $data_array=explode($account_number,$_GET['ekey']); 
        
        if(trim($data_array[1])==trim($session_id))
        {
       
                 $this->load->helper('url'); 

                     if($account_number){
                        $session_data_store= $this->setSessionValue($account_number ,false); 
                           redirect(FXPP::my_url('partnership/commission'));
                         
                     }else{
                         $this->session->set_flashdata("somethingisWrong", true);
                            redirect('partner/signin');
                    }
        
        }else{
            $this->session->set_flashdata("somethingisWrong", true);
                    redirect('partner/signin');
        }  
        
        
    }else{
        
      //  echo "====================>".$_GET['cabientKey']."------------->";exit;
        
         $this->session->set_flashdata("somethingisWrong", true);
                redirect('partner/signin');
    }  
    
    
}


    public function signin(){
        if ($this->tank_auth->is_logged_in()) {                                 // logged in

            redirect(FXPP::my_url('partnership/commission'));

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {


            $this->form_validation->set_rules('username', lang('ps_11'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
          if(isset($_POST['remember'])){
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');
          }
 

            $data['errors'] = array();
            if ($this->form_validation->run()) {                                // validation ok
                $this->load->model('cabinet_model');

                $username = $this->form_validation->set_value('username');
                $password = $this->form_validation->set_value('password');


 


                
                if(is_numeric($username)){

                    $this->partnerAuthorization( $username,$password); // After authorization it will redirect to cabinet
                    
                }else{
                    $this->session->set_flashdata("account-invalid", true);

                    redirect('partner/signin');
                }



            }

          

            $data['data']['username'] = array(
                'name' => 'username',
                'id' => 'inputEmail3',
                'value' => set_value('username', ''),
                'type' => 'text',
                'class' => form_error('username') || isset($errors['username']) ? 'form-control round-0  red-border ext-arabic-form-control-placeholder' : 'form-control round-0 ext-arabic-form-control-placeholder',
                'placeholder' => lang('fer_02'),//lang('ps_09')
            );

            $data['data']['password'] = array(
                'name' => 'password',
                'id' => 'pass',
                'value' => set_value('password', ''),
                'type' => 'password',
                'class' => form_error('password') || isset($errors['password']) ? 'form-control round-0  red-border ext-arabic-form-control-placeholder' : 'form-control round-0 ext-arabic-form-control-placeholder',
                'placeholder' => lang('ps_10')
            );

            $data['data']['output_key'] = '';
            $css = $this->template->Css();
            $js = $this->template->Js();
            $data['data']['output_key'] = '';
            $data['data']['Error'] = true;
            $data['data']['metadata_description'] = lang('ps_dsc');
            $data['data']['metadata_keyword'] = lang('ps_kew');
            //lang('ps_tit')
            $this->template->title(lang('ps_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='" . $css . "/signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('partners_signin', $data['data']);
        }
    }


    

    public function fblLogin()
    {
        $this->load->library('Social');


        try{

              $inint_config=array();
                    if($_SESSION['socail_login_config_data']){
                        $inint_config=$_SESSION['socail_login_config_data'];
                    }
            
            
            $fb_api=Social::fbAPI($inint_config)['fb_api'];

            $helper = $fb_api->getRedirectLoginHelper();
            $facebook_access_token = $helper->getAccessToken();

            if(isset($facebook_access_token))
            {
                $_SESSION['facebook_access_token']=$facebook_access_token->getValue();//(string)$facebook_access_token;
            }else{

                redirect(FXPP::my_url('partner/signin'));  
            }




            $fb_api->setDefaultAccessToken($_SESSION['facebook_access_token']);


            $responseUser = $fb_api->get('/me?fields=id,name,email', $_SESSION['facebook_access_token']);
            $responseImage = $fb_api->get('/me/picture?redirect=false&width=550&height=750', $_SESSION['facebook_access_token']);




            $user = $responseUser->getGraphUser();
            $image = $responseImage->getGraphUser();

            //   if(IPLoc::frz()){ echo "<pre>"; print_r($user);exit; }

            $data=array(
                "social_user_id"=>$user['id'],
                "full_name_live"=>$user['name'],
                "email_live"=>isset($user['email'])?$user['email']:"Need Permission",
                "social_profile_image"=>base64_encode($image['url']),
                "social_code"=>$_GET['state'],
                "affiliatee_code"=>"",
                "redi_url"=>FXPP::my_url('partner/signin')
            );




            
                $check_already_regitrated=$this->general_model->getSocialID( $data['social_user_id'],1);
            
            if($check_already_regitrated)
            {
                $fpp_user_id=$check_already_regitrated['id'];

                $account_data=$this->general_model->showssingle("partnership", "partner_id", $fpp_user_id);


                if($account_data)
                {
                      $this->partnerAuthorization( $account_data['reference_num'],$account_data['trader_password']); // After authorization it will redirect to cabinet
                     
                    
                }else{
                    redirect(FXPP::my_url('partner/signin'));
                }
            }else{
                

//                    if(IPLoc::frz()){
//                    echo "<pre>"; print_r($data);exit;
//                    }
                 

                $url_data = serialize($data);
                redirect("https://www.forexmart.com/social-register/goToPartnership?srid=".$url_data);

            }






        } catch (Exception $exe){

            redirect("https://www.forexmart.com/partnership/registration?fbId=1");

           // echo $exe->getTraceAsString();exit;
        }





    }





    public function googleLogin()
    {
        $this->load->library('Social');


        try{



            $google_code=$_GET['code'];


            if(isset($google_code))
            {

                
                    $inint_config=array();
                    if($_SESSION['socail_login_config_data']){
                        $inint_config=$_SESSION['socail_login_config_data'];
                    }
                

                $google_api=Social::googleAPI($inint_config)['google_api'];

                $token = $google_api->fetchAccessTokenWithAuthCode($google_code);
                $google_api->setAccessToken($token['access_token']);




                /* ----------------------------------------------- check redirect if not find token---------------------*/
                $is_redirect=true;
                if(isset($token['access_token']))
                {
                    if($token['access_token']!="")
                    {
                        $_SESSION['google_access_token']=$token['access_token'];
                        $is_redirect=false;
                    }

                }

 

                if($is_redirect)
                {
                    redirect(FXPP::my_url('partner/signin'));
                }

                /* ----------------------------------------------- check redirect if not find token end---------------------*/




                // getting profile information
                $google_oauth = new Google_Service_Oauth2($google_api);
                $google_account_info = $google_oauth->userinfo->get();

                //strpos($google_code,"/")




                $data=array(
                    "social_user_id"=>$google_account_info['id'],
                    "full_name_live"=>$google_account_info['name'],
                    "email_live"=>isset($google_account_info['email'])?$google_account_info['email']:"Need Permission",
                    "social_profile_image"=>base64_encode($google_account_info['picture']),
                    "social_code"=>$google_code,
                    "affiliatee_code"=>"",
                    "redi_url"=>FXPP::my_url('partner/signin')
                );

 

                $check_already_regitrated=$this->general_model->getSocialID( $data['social_user_id'],1);

                

                if($check_already_regitrated)
                {
                    $fpp_user_id=$check_already_regitrated['id'];
 
                      $account_data=$this->general_model->showssingle("partnership", "partner_id", $fpp_user_id);
 

                    if($account_data)
                    {
                        $this->partnerAuthorization($account_data['reference_num'],$account_data['trader_password']);
                        
                    }else{
                        redirect(FXPP::my_url('partner/signin'));
                    }
                }else{

                    $url_data = serialize($data);
                    redirect("https://www.forexmart.com/social-register/goToPartnership?srid=".$url_data);
                }






            }else{
                redirect(FXPP::my_url('partner/signin'));
            }





        } catch (Exception $exe){

            echo $exe->getTraceAsString();exit;
        }





    }

    
    
    
}
