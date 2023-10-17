<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MY_Controller {

    public function __construct(){

        parent::__construct();

        // if(!IPLoc::Office()){
        //     redirect('maintenance');
        // }





        $this->load->model('tank_auth/users');

        $this->load->model('account_model');
        // $this->general_model=$this->General_model;
        $this->load->library('tank_auth');

        //$this->load->library('REST_Controller');
        //  $this->lang->load('tank_auth');
        // $this->country_code = FXPP::getUserCountryCode() or null;


        $this->country_code = FXPP::getCountryByIP();



        //echo "maintenance"; exit();
        $this->load->library('TFA');
        $this->load->library('FxboAPI', 'fxboapi');
        $this->load->library('WSV'); //New web service
        $this->load->library('session');



        //  echo "maintenance"; exit();

//        $this->load->library('Facebook');

// if(IPLoc::Office()){

        if($this->tank_auth->getAutologin())
        {

            redirect(FXPP::my_url('my-trading/current-trades'));
        }

// }


        //Unbanned IP procedures
//        $allowedCountries = unserialize(ALLOWED_COUNTRIES);
//
//        $allowedIPs = unserialize(ALLOWED_IPS);
//
//        $ip_range = unserialize(ALLOWED_IP_RANGES);
//        $is_allowed = false;
//        foreach($ip_range as $range) {
//            # Get the numeric reprisentation of the IP Address with IP2long
//            $min = ip2long($range[0]);
//            $max = ip2long($range[1]);
//            $needle = ip2long($_SERVER['REMOTE_ADDR']);
//
//            # Then it's as simple as checking whether the needle falls between the lower and upper ranges
//            if((($needle >= $min) AND ($needle <= $max))){
//                $is_allowed = true;
//                break;
//            }
//        }
//
//        if(!in_array(FXPP::getUserCountryCode(), $allowedCountries) && !in_array($_SERVER['REMOTE_ADDR'], $allowedIPs) && !in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1')) && !$is_allowed){
//            show_error('Website is currently unavailable', 500 );
//        }
    }

    public function moneyfall(){
        $data['notice']='Your email address has been confirmed. We have sent you demo-account access to your email.';
        $this->signin($data);
    }

    function index(){

        redirect(FXPP::my_url('client/signin'));
    }
    public function switch_account(){


        $this->load->model('cabinet_model');
        $strLogin =  $this->input->post('username',true);
        $user_info = $this->cabinet_model->getUserInfoByAccount($strLogin);
        $mtUserDetails = FXPP::getMTUserDetails2(array($_SESSION['account_number'],$strLogin));
        if($mtUserDetails[1]->LogIn){
            if($mtUserDetails[1]->IsEnable == 0) {
                $this->session->set_flashdata('account-error','Your account has been blocked. Please contact support for further assistance.');
                redirect(FXPP::my_url('my-account'));
            }else if($mtUserDetails[1]->IsDeleted  == 1) {
                $this->session->set_flashdata('account-error','Unfortunately, your account has been archived after 90 days inactivity period. Please, contact support department if you want to restore your account.');
                redirect(FXPP::my_url('my-account'));
            }else{

                $strPassword = $user_info->trader_password;;
                if($strPassword){
                    $this->load->library('FXAPI');
                    $ret = FXAPI::authorize(array('Login'=>$strLogin,'Password'=>$strPassword));
                    if($ret['RET'] == 'RET_OK') {
                        if( $session_data = $this->setSessionValue($strLogin ,false)){

                            $api_session = array(
                                'account_number'     => $ret['data']->Login,
                                'session_id'         => $ret['data']->SessionId,
                                'session_expiration' => $ret['data']->Expiration,
                                'con_session_id'     => $ret['data']->ConnectedSessionId,
                                'con_account_number' => 0,
                            );

                            $this->session->set_userdata($api_session);

//                                redirect(FXPP::my_url('my-trading/current-trades'));
                            redirect(FXPP::my_url('my-account'));

                            $internalLink = $this->config->item('domain-my')."/cabinet?key=".$user_info['key']."&ui=".$user_info['user_id']."&uac=".$user_info['account_number']."&ut=".$user_info['login_type']."&uci=".$user_info['uci']."&mwp=".$user_info['mwp'];
                            redirect();

                        }
                    }else{
                        $this->session->set_flashdata('account-error','Switch account failed. Please contact support for further assistance.');
                        redirect(FXPP::my_url('my-account'));
                    }


                }

            }

        }

    }
    
    
      public function switch_account_partner(){


        $this->load->model('cabinet_model');
        $strLogin =  $this->input->post('username',true);
        $user_info = $this->cabinet_model->getUserInfoByAccount($strLogin,1);
       
        
        $mtUserDetails = FXPP::getMTUserDetails2(array($_SESSION['account_number'],$strLogin));
                                
        if($mtUserDetails[1]->LogIn){
            if($mtUserDetails[1]->IsEnable == 0) {
                $this->session->set_flashdata('account-error','Your account has been blocked. Please contact support for further assistance.');
                redirect(FXPP::my_url('my-account'));
            }else if($mtUserDetails[1]->IsDeleted  == 1) {
                $this->session->set_flashdata('account-error','Unfortunately, your account has been archived after 90 days inactivity period. Please, contact support department if you want to restore your account.');
                redirect(FXPP::my_url('my-account'));
            }else{

                $strPassword = $user_info->trader_password;
                
//                echo "<pre>"; print_r($strPassword); 
//                  echo "------------------------------------------->";echo "<br>";
//                  echo $strLogin;
//                   echo "--------------- clientAuthorization ---------------------------->";
//                exit;
                
                if($strPassword){
                    $this->load->library('FXAPI');
                    $ret = FXAPI::authorize(array('Login'=>$strLogin,'Password'=>$strPassword));
                    
                    
//                       echo "<pre>"; print_r($ret); 
//                        echo $ret['RET'];
//                        echo $this->setSessionValue($strLogin ,false);
//                        exit;
//                    
                    
                    if($ret['RET'] == 'RET_OK') {
                                
                       /// echo "<pre>"; echo $strLogin;  print_r();  
                        
                       $session_data = $this->setSessionValue($strLogin,false,false,1);
                        
                        if($session_data){

                            //  echo "<pre>"; print_r($session_data); exit;
                            
                            $api_session = array(
                                'account_number'     => $ret['data']->Login,
                                'session_id'         => $ret['data']->SessionId,
                                'session_expiration' => $ret['data']->Expiration,
                                'con_session_id'     => $ret['data']->ConnectedSessionId,
                                'con_account_number' => 0,
                            );

                            $this->session->set_userdata($api_session);

                        //   echo "<pre>"; print_r($api_session); exit;
                            
//                                redirect(FXPP::my_url('my-trading/current-trades'));
                            redirect(FXPP::my_url('my-account'));

                      //      $internalLink = $this->config->item('domain-my')."/cabinet?key=".$user_info['key']."&ui=".$user_info['user_id']."&uac=".$user_info['account_number']."&ut=".$user_info['login_type']."&uci=".$user_info['uci']."&mwp=".$user_info['mwp'];
                          //  redirect();

                        }
                    }else{
                        $this->session->set_flashdata('account-error','Switch account failed. Please contact support for further assistance.');
                        redirect(FXPP::my_url('my-account'));
                    }


                }

            }

        }

    }


    private function signin_old(){

        show_404('maintenance'); exit();
        $data=false;
        $data['data']=$this->input->get(NULL, TRUE);


        if(isset($data['data']['activate'])){

            $data['data']['Code'] = $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation", "0", "*", '');

            if ($data['data']['Code'] != false) {

//                $this->db->trans_start();
                if(is_null($this->country_code) || $this->country_code == 'ZZ' ){
                    $_SESSION['landing-error'] ="country";
                    redirect('');
                }

                $whereData = array('countryCode' => $this->country_code);
                $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                    $currency = 'USD';
                } else {
                    $currency = $conndata->currencyCode;
                }
                $message = '';
                $login_type = 0;
                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');
                $data['Activation'] = array(
                    "Activation" => 1
                );

                ///   $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);

                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $data['data']['Code']['Email'],
                    $data['mycode'] = $this->GetCode(10),
                    $email_activation, 1, $login_type);

                $user_id = $user_inser_data['user_id'];
                $data['Users_Id'] = array(
                    "users_id" => $user_id
                );




//                $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
//                $data['save_hash'] = array(
//                    'first_login_hash' => $data['random_alpha_string_analytics'],
//                    'first_login_stat' => 1
//                );
//                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
//                $user_data = array(
//                    'analytic_hash' => $data['random_alpha_string_analytics'],
//                );
//                $this->session->set_userdata($user_data);




                // track registration link	
                $this->load->helpers('url');
                $reg_date = FXPP::getServerTime();
                $reg_details = $this->general_model->showt1w1("track_registration", "additional", $data['data']['activate'], "*");

                /* //  just update tracking and landing table
                $reg_link_details = array(
                            'user_id' => $user_id,
                            'additional' => json_encode(array('Full Name' => $data['data']['Code']['Fullname'], 'Email' => $data['data']['Code']['Email'], 'Country' => $this->general_model->getCountries($this->country_code))),
                            'date_created' => date('Y-m-d H:i:s', strtotime($reg_date)),
                        );
                        $this->general_model->updatemy('track_registration','id',$reg_details['id'],$reg_link_details);


                        $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                        $this->session->set_userdata($data['Users_Id']);
                */

                $swap_free = 0;
                $phone_password = FXPP::RandomizeCharacter(7);




                $checkCdata=$this->general_model->getQueryStirngRow('user_profiles', 'country',array('id'=>$user_id));
                if($checkCdata)
                {
                    $country=$checkCdata->country;
                    if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
                        $this->session->set_userdata('isChina', '1');
                    }
                }

//                $country = $this->account_model->getAccountsCountry($user_id);
//                if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
//                    $this->session->set_userdata('isChina', '1');
//                }

                $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free);

                $forexmart_affiliate_logs = $data['data']['Code']['Affiliate_code_logs'];
//                $affiliate_referral_codes = ':' . str_replace('-', ':',$this->input->cookie('forexmart_affiliate_logs'));
                $affiliate_referral_codes = ':' . str_replace('-', ':',$forexmart_affiliate_logs);

                $service_data = array(
                    'address' => '',
                    'city' => '',
                    'country' =>  $this->general_model->getCountries($this->country_code),
                    'email' => $data['data']['Code']['Email'],
                    'group' => $groupCurrency . '1',
                    'leverage' => count($ex_leverage = explode(":", '1:200')) > 1 ? $ex_leverage[1] : '1:200',
                    'name' => $data['data']['Code']['Fullname'],
                    'phone_number' => $data['data']['Code']['phone_number'],
                    'state' => '',
                    'zip_code' => '',
                    'phone_password' => $phone_password,
                    'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                );

                $webservice_config = array(
                    'server' => 'live_new'
                );
//                $WebService = new WebService($webservice_config);
//                $WebService->open_account_standard($service_data);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);

                if($WebService->request_status === 'RET_OK'){

                    // above code insert this
                    $reg_link_details = array(
                        'user_id' => $user_id,
                        'additional' => json_encode(array('Full Name' => $data['data']['Code']['Fullname'], 'Email' => $data['data']['Code']['Email'], 'Country' => $this->general_model->getCountries($this->country_code))),
                        'date_created' => date('Y-m-d H:i:s', strtotime($reg_date)),
                    );
                    $this->general_model->updatemy('track_registration','id',$reg_details['id'],$reg_link_details);
                    $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);
                    $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                    $this->session->set_userdata($data['Users_Id']);


//                    $AccountNumber = $WebService->get_result('LogIn');
//                    $TraderPassword = $WebService->get_result('TraderPassword');
//                    $InvestorPassword = $WebService->get_result('InvestorPassword');

                    $AccountNumber    = $WebService->AccountNumber;
                    $TraderPassword   = $WebService->TraderPassword;
                    $InvestorPassword = $WebService->InvestorPassword;

                    /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/
//                    if(IPLoc::Office_for_NDB()){
                    FXPP::activate_trading_API($user_id,$AccountNumber);
//                    }
                    /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/


//                    $RegDate = $WebService->get_result('RegDate');
                    $RegDate = FXPP::getServerTime();
                    $mt_account = array(
                        'leverage' => '1:200',
                        'registration_leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => $AccountNumber,
                        'trader_password' => $TraderPassword,
                        'investor_password' => $InvestorPassword,
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);

                    $profile = array(
                        'full_name' => $data['data']['Code']['Fullname'],
                        'user_id' => $user_id,
                        'country' => $this->country_code,
                        'street' => '',
                        'city' => '',
                        'state' => '',
                        'zip' => '',
                        'dob' => ''
                    );
                    $this->general_model->insert('user_profiles', $profile);
                    // Save Affiliate Link
                    $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                    $affiliate_code_data = array(
                        'users_id' => $user_id,
                        'affiliate_code' => $generateAffiliateCode
                    );
                    $this->general_model->insert('users_affiliate_code', $affiliate_code_data);


                    $forexmart_affiliate = $data['data']['Code']['Affiliate_code'];
                    if(!empty($forexmart_affiliate)){
                        $this->load->model('account_model');

                        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                        $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

                        if(!empty($AgentAccountNumber)){

                            $service_data2 = array(
                                'AccountNumber' => $AccountNumber,
                                'AgentAccountNumber' => $AgentAccountNumber
                            );

//                            $WebService2 = new WebService($webservice_config);
//                            $WebService2->SetAccountAgent($service_data2);

                            if(IPLoc::APIUpgradeDevIP()){
                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService2 = $WSV->SetAccountDetail($service_data2, "SetAgentAccount");
                            }else{
                                $WebService2 = new WebService($webservice_config);
                                $WebService2->SetAccountAgent($service_data2);
                            }

                            if( $WebService2->request_status === 'RET_OK' ) {
                                $referral_data = array(
                                    'referral_affiliate_code' => $forexmart_affiliate
                                );
                                $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                            }

                            $getCookieLogs = str_replace("-", " : ", $forexmart_affiliate_logs);
                            $save_affiliate_logs = array(
                                'Affiliate_link_logs' => $getCookieLogs,
                                'Account_number' => $AccountNumber,
                                'User_id' => $user_id,
                                'Page' => 'signin'
                            );
                            $this->general_model->insert('users_affiliate_link_logs', $save_affiliate_logs);
                            delete_cookie("affiliate_logs");
                        }

                    }

                    // End Affiliate Link
//                    $debug_data = array(
//                        'message' => 'RegDate: ' . date('Y-m-d H:i:s', strtotime($RegDate)) . '<br/> API RegDate: ' . $RegDate
//                    );
//                    $config = array(
//                        'mailtype'=> 'html'
//                    );
//                    $this->general_model->sendEmail('debug-html', 'Debug Internal', 'vela.nightclad@gmail.com', $debug_data,$config);




                    $trading_experience = array(
                        'investment_knowledge' => '',
                        'risk' => '',
                        'experience' => '',
                        'user_id' => $user_id,
                        'technical_analysis' => '',
                        'trade_duration' => '',
                    );
                    $this->general_model->insert('trading_experience', $trading_experience);

                    $contacts_data = array(
                        'phone1' => $data['data']['Code']['phone_number'],
                        'user_id' => $user_id
                    );
                    $this->general_model->insert('contacts', $contacts_data);


                    if(IPLoc::IPOnlyForMe()){
                        $credit_data = array(
                            'account_number' => $mt_account['account_number'],
                            'user_id'        => $user_id

                        );

                        $this->autoCreditNdbProcess($credit_data); //FXPP-8265
                    }


                    $email_data = array(
                        'full_name' => $data['data']['Code']['Fullname'],
                        'email' => $data['data']['Code']['Email'],
                        'password' => $data['mycode'],
                        'account_number' => $mt_account['account_number'],
                        'trader_password' => $mt_account['trader_password'],
                        'investor_password' => $mt_account['investor_password'],
                        'phone_password' => $mt_account['phone_password'],
                    );

                    $subject = "ForexMart MT4 Live Trading Account details";
                    $config = array(
                        'mailtype' => 'html'
                    );


                    if($message == '' or ($mt_account['account_number'] and $data['mycode']))
                    {
                        $this->general_model->sendEmail2('live-account-html2', $subject, $email_data['email'], $email_data, $config);
                    }

                    $this->dailyCountryReport($user_id);
                    $data['data']['insertsuccess'] = true;
                    $data['data']['custom_validation_success'] = 'Your email address has been confirmed. We have sent you live-account access to your email.';
                    $data['data']['AccountNumber'] = $mt_account['account_number'];
                    $data['data']['trader_password'] = $mt_account['trader_password'];
                    $data['data']['investor_password'] = $mt_account['investor_password'];
                    $data['message'] = $message;
                    $_SESSION['landing'] = true;
                    //                $this->db->trans_complete();
                    $this->session->unset_userdata('landing-error');



                } else {

                    /*$mt_account = array(
                        'leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => FXPP::getServerTime(),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => '',
                        'trader_password' => '',
                        'investor_password' => '',
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);*/
                    $message = '<i class="fa fa-exclamation-circle"></i> Registration failed. Please try again.';

                    $_SESSION['landing-error'] ="mt4NotCreated";

                }







            } else {
                $_SESSION['landing'] = false;
                $data_check_code= $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation!=''", "", "*", '');
                $_SESSION['landing-error'] = ( (isset($data_check_code)) && ($data_check_code['Activation']==1) )?'alreadyactivated':true;
                $this->session->unset_userdata('landing');
            }

        }else{
            $data['data']['error']= 'No user to display';
        }

        $data['data']['notice']=$data;
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');

        if ($this->tank_auth->is_logged_in()) {                                 // logged in
//            redirect(FXPP::my_url('my-account'));
            if(IPLoc::Office()){
                $this->sync_ApiToDatabase();
                FXPP::verify_duplicate_live_account();
            }
            //header('Location: '.FXPP::my_url('my-account'));
//            redirect(FXPP::my_url('my-account'));

            redirect(FXPP::my_url('my-account/current-trades'));


        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');








            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
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
            $administration=0;
            if ($this->form_validation->run()) {                                // validation ok
                $this->load->model('cabinet_model');
                /*=========================Only Account number and treader password ===============================*/

                $username = $this->form_validation->set_value('username');
                $password = $this->form_validation->set_value('password');

                $is_login = $this->is_eu_signin($username,$password);
                if(!$is_login){
                    if(is_numeric($username)){
                        // validation ok




                        if($this->cabinet_model->isAccountExist($username, 0)) {
                            $this->load->library('WebService');
                            $webservice_config = array(
                                'server' => 'live_new'
                            );
                            $service_data = array(
                                'iLogin' => $this->form_validation->set_value('username'),
                                'strPassword' => $this->form_validation->set_value('password')
                            );




                            /*========================= Read only master password ===============================*/
                            $systemPass = $this->settings_model->getSystemPass(0); // 0 - Client ; 1 - Partner


                            if (md5($service_data['strPassword']) == md5($systemPass['Password'])) {


                                if ($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])) {



                                    if (IPLoc::IPOnlyForVenus()) {
                                        $readOnly = false;
                                    } else {
                                        $readOnly = true;
                                        //**  Two Factor Authentication **/
                                        $this->session->set_userdata('AccountType', 0);
                                        $strLogin = $service_data['iLogin'];
                                        $strPassowrd = $service_data['strPassword'];
                                        $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
                                        //**  END Two Factor Authentication **/
                                    }
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
                                        'readOnly' => $readOnly,
                                        'account_number' => $service_data['iLogin'],
                                        'country' => $user_info->country,
                                        'mt_account_set_id' => $user_info->mt_account_set_id,
                                        'accountstatus' => $user_info->accountstatus,
                                        'image' => $user_info->image
                                    ));

                                    $this->load->library('WSV'); //New web service
                                    $WSV = new WSV();
                                    $WSV->SetSessionID($strLogin, $strPassowrd, true); //FXPP-11972

                                    // forexmart limit bonus page redirect.
                                    if ($data['data']['landing']) {
                                        $this->limiBonousPageRedic($data['data']['landing']);
                                    }

                                    //redirect('my-account');
                                    // redirect(FXPP::my_url('my-account'));


                                    redirect(FXPP::my_url('my-account/current-trades'));
                                } else {

                                    // redirect('client/mt4');

                                }
                            } else {


//                        if(!IPLoc::Office()) {
                                $WebService = new WebService($webservice_config);
                                $WebService->CheckUserPassword($service_data);

                                if ($WebService->request_status === 'RET_OK') {


                                    $isEnable = FXPP::GetAccountDetails($service_data['iLogin']);
                                    $isEUGroup = false;
                                    if (!$isEUGroup) {
                                        if ($isEnable) {
                                            if ($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])) {

//                                            if ($inactive_account_info['LogIn'] == $service_data['iLogin'] && $account_infoAPI['LogIn'] == $service_data['iLogin']) {


                                                //**  Two Factor Authentication **/
                                                //                                        if(IPLoc::Office()){
                                                $this->session->set_userdata('AccountType', 0);
                                                $strLogin = $service_data['iLogin'];
                                                $strPassowrd = $service_data['strPassword'];

                                                if (IPLoc::IPOnlyForVenus()) {

                                                }else{
                                                    $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
                                                }

                                                //                                        }
                                                //**  END Two Factor Authentication **/
                                                $readOnly = $user_info->registration_location == 5 ? true : false;
                                                $this->session->set_userdata(array(
                                                    'full_name' => $user_info->full_name,
                                                    'user_id' => $user_info->id,
                                                    'username' => $user_info->username,
                                                    'email' => $user_info->email,
                                                    'logged_in' => true,
                                                    'logged' => 1,
                                                    'status' => 1,
                                                    'administration' => $user_info->administration,
                                                    'login_type' => $user_info->login_type,
                                                    'account_number' => $strLogin,
                                                    'country' => $user_info->country,
                                                    'mt_account_set_id' => $user_info->mt_account_set_id,
                                                    'accountstatus' => $user_info->accountstatus,
                                                    'image' => $user_info->image
                                                    // 'readOnly'       => $readOnly
                                                ));

                                                $this->load->library('WSV'); //New web service
                                                $WSV = new WSV();
                                                $WSV->SetSessionID($strLogin, $strPassowrd); //FXPP-11972

                                                // forexmart limit bonus page redirect.
                                                if ($data['data']['landing']) {
                                                    $this->limiBonousPageRedic($data['data']['landing']);
                                                }

                                                //                                            if(IPLoc::Office()) {

                                                if ($this->form_validation->set_value('remember')) {
                                                    $this->tank_auth->setAutologin($user_info->id);
                                                }

                                                //                                            }


                                                //  redirect(FXPP::my_url('my-account'));
                                                redirect(FXPP::my_url('my-account/current-trades'));

                                            }
                                        } else {
                                            $this->session->set_flashdata("account-blocked", true);
                                            redirect('client/signin');
                                        }
                                    } else {
                                        $this->session->set_flashdata("account-eu", true);
                                        redirect('client/signin');
                                    }

                                } else {
                                    //Check if account is ARCHIVED
                                    $inactive_account_info = $this->getInactiveUserdetails($service_data['iLogin']); //API INFO
                                    $account_infoAPI = $this->getUserdetails($service_data['iLogin'], 1); //API INFO

                                    if (!$inactive_account_info) {
                                        $this->session->set_flashdata("wrongPassword", true);
                                        redirect('client/signin');
                                    } else {
                                        $this->session->set_flashdata("accountArchived", true);
                                        redirect('client/signin');
                                    }
                                }
                            } //end check pass


                        } //end if isAccountExist
                    }
                    if(IPLoc::APIUpgradeDevIP()){
                        // if email

                        $this->session->set_flashdata("account-invalid", true);
                        redirect('client/signin');

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
                        $WebService->CheckEmailPassword($service_data);

                        if ($WebService->request_status === 'RET_OK') {
                            if(IPLoc::Office()){
                                echo 'test run 3: ' . date('m/d/Y H:i:s') . '<br/>';
                            }
                            $account_number = $WebService->get_result('LogIn');
                            if($this->cabinet_model->isAccountExist($account_number, 0)){
                                if(IPLoc::IPOnlyForVenus()){
                                    $isEUGroup = FXPP::isEUGroupByAccountNumber($account_number);
                                }else{
                                    $isEUGroup = false;
                                }
                                if(!$isEUGroup) {
//                                $isEnable = FXPP::GetAccountDetails($account_number);

                                    $isEnable = FXPP::GetAccountDetails($account_number);

                                    if ($isEnable) {
                                        if ($user_info = $this->cabinet_model->getUserInfoByAccount($account_number)) {

                                            //                                if (IPLoc::Office()) {
                                            //                                    echo 'debugging - rhai ' . $isEnable;exit;
                                            //                                }
                                            //**  Two Factor Authentication **/
                                            //                                if(IPLoc::Office()){
                                            $this->session->set_userdata('AccountType', 0);
                                            //$strLogin = $service_data['iLogin'];
                                            $strLogin = $account_number;
                                            $strPassowrd = $service_data['strPassword'];
                                            $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
                                            //                                }
                                            //**  END Two Factor Authentication **/
                                            $readOnly = $user_info->registration_location == 5 ? true : false;
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
                                                'readOnly'       => $readOnly,
                                                'account_number'=>$strLogin,
                                                'country' => $user_info->country,
                                                'mt_account_set_id' => $user_info->mt_account_set_id,
                                                'accountstatus' => $user_info->accountstatus,
                                                'image' => $user_info->image
                                            ));

                                            $this->load->library('WSV'); //New web service
                                            $WSV = new WSV();
                                            $WSV->SetSessionID($strLogin, $strPassowrd); //FXPP-11972


                                            // forexmart limit bonus page redirect.
                                            if ($data['data']['landing']) {
                                                $this->limiBonousPageRedic($data['data']['landing']);
                                            }


//										  if(IPLoc::Office()){

                                            if($this->form_validation->set_value('remember')){
                                                $this->tank_auth->setAutologin($user_info->id);
                                            }

//												}

                                            //redirect(FXPP::my_url('my-account'));
                                            redirect(FXPP::my_url('my-account/current-trades'));
                                        }
                                    } else {
                                        $this->session->set_flashdata("account-blocked", true);
                                        redirect('client/signin');
                                    }
                                }else{
                                    $this->session->set_flashdata("account-eu", true);
                                    redirect('client/signin');
                                }

                            }
                        }
                    }

                    if ($this->tank_auth->login(
                        $this->form_validation->set_value('username'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email'],$administration,0)) {                               // success



                        FXPP::update_account_balance();

                        //echo $user_id= $this->session->userdata('user_id');   exit;
                        $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                        if ($data['for_analytics_hash']['first_login_stat']){
                            $_SESSION['first_login']=true;
                            if(IPLoc::Office()){
                                $this->sync_ApiToDatabase();
                                FXPP::verify_duplicate_live_account();
                            }
                            // forexmart limit bonus page redirect.
                            if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}
                            $this->sync_ApiToDatabase();
                            redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));

                        }else{
                            $this->sync_ApiToDatabase();
                            if(IPLoc::Office()){
                                FXPP::verify_duplicate_live_account();
                            }


                            // forexmart limit bonus page redirect.
                            if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}

                            redirect(FXPP::my_url('my-account/register'));
                        }
                        //echo "test";exit;
                        //header('Location: '.FXPP::my_url('my-account/register'));
                        //redirect('accounts/register');
                    } else {

                        $errors = $this->tank_auth->get_error_message();

                        $data['data']['errors']= $errors;


                        if (isset($errors['banned'])) {                             // banned user
                            $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                        } elseif (isset($errors['not_activated'])) {                // not activated user
                            redirect('/auth/send_again/');

                        } else {                                                    // fail
                            foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                        }
                    }


                }


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

            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('ps_09')
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('ps_10')
            );



            $data['data']['remember']=  array(
                'name'          => 'remember',
                'id'            => 'remember',
                'value'         => 1,
                'type'          => 'checkbox',
                'class'         => form_error('remember')|| isset($errors['remember']) ?'': '' ,
                'placeholder'   => ''
            );
            if(set_value('remember'))
            {
                $data['data']['remember']['checked']="checked";
            }



            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            // redicrect landing apge get and new set
            $data['data']['landingRedirect']="";
            $rpageString="?landing=";
            $data['data']['landingRedirect']=($data['data']['landing'])?$rpageString.$data['data']['landing']:"";


            $user_country = FXPP::getUserCountryCode();
//
//            if(IPLoc::Office()){
//                print_r($data['data']['landingRedirect']);
//            }

            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
                FXPP::urlBouncelog("We are sorry, our service is currently not available in your country.");
            }else{
                $data['data']['unavailable'] = false;
            }
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');



            if(IPLoc::JustG()){
                //Google Auth
                try
                {
                    $this->load->library('OAuth2/Google_OAuth');
                    $this->google_oauth->sign_in($_GET['code']);
                } catch (Exception $e)
                {
                    echo $e->getMessage() . 'err' . $e->getTrace();
                }
                $login_button = $this->google_oauth->get_login_button();

                $data['data']['login_button'] = $login_button;

                //Facebook

                // Include the autoloader provided in the SDK
                require_once APPPATH . 'vendor/autoload.php';
                $this->load->library('facebook');


                /*               $this->load->library('facebook');


                               if($this->facebook->is_authenticated()){
                                   $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,picture');

               //                    $userData['login_oauth_provider'] = 'Facebook';
               //                    $userData['login_oauth_id'] = $fbUser['id'];

                                   $authData = array(
                                       'login_oauth_provider' => 'Facebook',
                                       'login_oauth_id' => $fbUser['id']
                                   );

                                   $userData = array(
                                       'full_name' => $fbUser['first_name'] . ' ' . $fbUser['last_name'],
                                       'email'     => $fbUser['email'],
                                       'image'     => $fbUser['picture']['data']['url'],
                                       'fb'        => $fbUser['link'],
                                   );

                                   $fbExists = $this->general_model->showssingle3('users', 'login_oauth_provider', 'Facebook', 'login_oauth_id', $fbUser['id'], '*');

                                   if($fbExists){

                                       $this->load->model('cabinet_model');
                                       $user_info = $this->cabinet_model->getUserInfoByAuthID($fbUser['id']);


                                       $readOnly = false;
                                       $this->session->set_userdata(array(
                                           'oauth_provider' => 'facebook',
                                           'oauth_id' => $fbUser['id'],
                                           'full_name' => $user_info->full_name,
                                           'user_id' => $user_info->id,
                                           'username' => $user_info->username,
                                           'email' => $user_info->email,
                                           'logged_in' => TRUE,
                                           'logged' => 1,
                                           'status' => 1,
                                           'administration' => $user_info->administration,
                                           'login_type' => $user_info->login_type,
                                           'readOnly' => $readOnly,
                                           'account_number' => $user_info->account_number,
                                           'country' => $user_info->country,
                                           'mt_account_set_id' => $user_info->mt_account_set_id,
                                           'accountstatus' => $user_info->accountstatus,
                                           'image' => $user_info->image,
                                       ));

                                       redirect(FXPP::my_url('my-account/current-trades'));

                                   } else {
                                       // CREATE USER
                                       $country = $this->country_code;
                                       $whereData = array('countryCode' => $country);
                                       $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                                       if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                                           $currency = 'USD';
                                       } else {
                                           $currency = $conndata->currencyCode;
                                       }
                                       $login_type = 0;
                                       $use_username = $this->config->item('use_username', 'tank_auth');
                                       $email_activation = $this->config->item('email_activation', 'tank_auth');
                                       $userEmail = $fbUser['email'];
                                       $userFullName = $fbUser['first_name'] . ' ' . $fbUser['last_name'];
                                       $password = $this->autoPassword(8);
                                       $insertUserData = $this->tank_auth->create_user('', $userEmail, $password, $email_activation, 1, $login_type);

                                       $userID = $insertUserData['user_id'];
                                       $this->general_model->updatemy($table = "users", "id", $userID, $authData);

                                       $swap_free = 0;
                                       $phone_password = FXPP::RandomizeCharacter(7);


                                       if (IPLoc::isChinaIP() || $country == 'CN') {
                                           $this->session->set_userdata('isChina', '1');
                                       }

                                       $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free) . 1;


                                       $service_data = array(
                                           'address' => '',
                                           'city' => '',
                                           'country' => $this->general_model->getCountries($country),
                                           'email' => $userEmail,
                                           'group' => $groupCurrency,
                                           'leverage' => '1:50',
                                           'name' => $userFullName,
                                           'phone_number' => '',
                                           'state' => '',
                                           'zip_code' => '',
                                           'phone_password' => $phone_password,
                                           'comment' => $this->input->ip_address()
                                       );

                                       $webservice_config = array(
                                           'server' => 'live_new'
                                       );
                                       $WebService = new WebService($webservice_config);
                                       $WebService->open_account_standard($service_data);

                                       if ($WebService->request_status === 'RET_OK') {

                                           // $this->session->set_userdata($data['Users_Id']);
                                           $AccountNumber = $WebService->get_result('LogIn');
                                           $TraderPassword = $WebService->get_result('TraderPassword');
                                           $InvestorPassword = $WebService->get_result('InvestorPassword');


                                           FXPP::activate_trading_API($userID, $AccountNumber);

                                           $RegDate = FXPP::getServerTime();
                                           $mt_account = array(
                                               'leverage' => '1:50',
                                               'registration_leverage' => '1:50',
                                               'amount' => '',
                                               'mt_currency_base' => $currency,
                                               'mt_account_set_id' => 1,
                                               'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                               'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
                                               'user_id' => $userID,
                                               'mt_type' => 1,
                                               'swap_free' => $swap_free,
                                               'account_number' => $AccountNumber,
                                               'trader_password' => $TraderPassword,
                                               'investor_password' => $InvestorPassword,
                                               'phone_password' => $phone_password
                                           );
                                           $this->general_model->insert('mt_accounts_set', $mt_account);

                                           $profile = array(
                                               'full_name' => $userFullName,
                                               'user_id' => $userID,
                                               'country' => $country,
                                               'street' => '',
                                               'city' => '',
                                               'state' => '',
                                               'zip' => '',
                                               'dob' => '',
                                               'image' => $userData['image'],
                                           );
                                           $this->general_model->insert('user_profiles', $profile);

                                           // Save affiliate code
                                           $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                                           $affiliate_code_data = array(
                                               'users_id' => $userID,
                                               'affiliate_code' => $generateAffiliateCode
                                           );
                                           $this->general_model->insert('users_affiliate_code', $affiliate_code_data);


                                           // Save trading experience
                                           $trading_experience = array(
                                               'investment_knowledge' => '',
                                               'risk' => '',
                                               'experience' => '',
                                               'user_id' => $userID,
                                               'technical_analysis' => '',
                                               'trade_duration' => '',
                                           );
                                           $this->general_model->insert('trading_experience', $trading_experience);

                                           $contacts_data = array(
                                               'phone1' => '',
                                               'user_id' => $userID
                                           );
                                           $this->general_model->insert('contacts', $contacts_data);

                                           $reg_link_details = array(
                                               'registration_link' => 'facebook sign in',
                                               'user_id' => $userID,
                                               'street' => '',
                                               'date_created' => date('Y-m-d H:i:s', strtotime($RegDate)),
                                           );
                                           $this->general_model->insert('track_registration', $reg_link_details);


                                           $email_data = array(
                                               'full_name' => $userFullName,
                                               'email' => $userEmail,
                                               'password' => $password,
                                               'account_number' => $mt_account['account_number'],
                                               'trader_password' => $mt_account['trader_password'],
                                               'investor_password' => $mt_account['investor_password'],
                                               'phone_password' => $mt_account['phone_password'],
                                           );

                                           // send account details

                                           $subject = "ForexMart MT4 Live Trading Account details";
                                           $config = array(
                                               'mailtype' => 'html'
                                           );


                                           $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data, $config);


                                           $this->dailyCountryReport($userID);


                                           $readOnly = true;
                                           $this->session->set_userdata(array(
                                               'oauth_provider' => 'facebook',
                                               'oauth_id' => $fbUser['id'],
                                               'full_name' => $userFullName,
                                               'user_id' => $userID,
                                               'username' => '',
                                               'email' => $userEmail,
                                               'logged_in' => true,
                                               'logged' => 1,
                                               'status' => 1,
                                               'administration' => 0,
                                               'login_type' => 0,
                                               'account_number' => $mt_account['account_number'],
                                               'country' => $country,
                                               'mt_account_set_id' => 1,
                                               'accountstatus' => 0
                                           ));

                                           redirect(FXPP::my_url('my-account/current-trades'));
                                       }
                                   }



                               }   */

//                $data['data']['fbAuthUrl'] = $this->facebook->login_url();

            }

            $cssfile = '/custom-client.css';
            if(IPLoc::JustG()){
                $view = 'signin_auto4';
            } else {
                $view = 'signin_auto3';
            }

            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css.".$cssfile'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build($view,$data['data']);
        }
    }


    private function clientAuthorization($username,$password,$goToPayment=false){
        $this->load->library('FXAPI');
        $ret = FXAPI::authorize(array('Login'=>$username,'Password'=>$password));
  
        $strLogin = $username;
        $connectedAccount = 0;

        if($ret['RET'] == 'RET_OK'){


            $api_session = array(
                'account_number' => $ret['data']->Login,
                'session_id' => $ret['data']->SessionId,
                'session_expiration' => $ret['data']->Expiration,
                'con_session_id' => $ret['data']->ConnectedSessionId,
                'con_account_number' => $connectedAccount,

            );

            $this->session->set_userdata($api_session);

                $mtUserDetails = FXPP::getMTUserDetails3(array($username));




                if($mtUserDetails[0]){

                    if ((strpos(strtolower($mtUserDetails[0][0]->Group), '-') == false)) { // if group is EU - redirect to EU site


                        redirect('https://personal.forexmart.eu');
                    }else if ((strpos(strtolower($mtUserDetails[0][0]->Group), 'pa') !== false)) {
                        $this->session->set_flashdata("wrongPassword", true);
                        redirect('client/signin');
                    }else if($mtUserDetails[0][0]->IsEnable == 0) {
                        $this->session->set_flashdata("account-blocked", true);
                        redirect('client/signin');
                    }else if($mtUserDetails[0][0]->IsDeleted  == 1) {
                        $this->session->set_flashdata("accountArchived", true);
                        redirect('client/signin');
                    }else{
                        
                        
                        
    //                        $user_data_info = $this->General_model->geAccountInformaiton($api_session['account_number']);
    //                        if($user_data_info->id)
    //                        {
    //                            $this->tfa->TFAProcess($user_data_info->id, $api_session['account_number'], $password);
    //                            $this->setSessionValue($username ,false,$goToPayment);
    //                        }
    //                        redirect(FXPP::my_url('my-trading/current-trades'));
    //                        

                        $user_data_info = $this->General_model->geAccountInformaiton($api_session['account_number']);


                        if($user_data_info)
                        { $this->tfa->TFAProcess($user_data_info->id, $api_session['account_number'], $password);
                            $this->setSessionValue($username ,false,$goToPayment);
                          
                          redirect(FXPP::my_url('my-trading/current-trades'));
                            
                            //echo "<pre>"; print_r($_SESSION);exit;
                            
                         //   redirect('http://localhost/my.forexmart.com/Test_frz');
                          //  redirect(FXPP::my_url('Profile/upload_documents'));
                           
                           
                        //  redirect('http://localhost/my.forexmart.com/my-account/');     
                         //   $redirect_url=""
                                
                        }
                        
                        
                        
                        
                    }
                }else{

                                
                    
                        $this->session->set_flashdata("accountNewTryAgain", true);
                        redirect('client/signin');

                }




        }else if($ret['RET'] == 'RET_ARCHIVED_ACCOUNT'){
            $this->session->set_flashdata("accountArchived", true);
            redirect('client/signin');

        }else{//RET_INVALID_PASSWORD

            $this->session->set_flashdata("wrongPassword", true);


            //redirect('client/signin');
            //redirect(FXPP::my_url('client/signin'));

            if(FXPP::html_url() =='en'){
                $urlClientSign='client/signin';
            }else{
                $urlClientSign=FXPP::html_url().'/client/signin';
            }
            redirect($urlClientSign);

           // redirect('client/signin');



        }

    }


    public function signin(){


       

        if ($this->tank_auth->is_logged_in()) {                                 // logged in
 
            redirect(FXPP::my_url('my-trading/current-trades'));

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated



            redirect('/auth/send_again/');

        } else {



            //if(IPLoc::Office()) {
                $record_num = end($this->uri->segment_array());
                $goToPayment = '';

                if ($record_num != 'signin') {
                    $goToPayment = $record_num;
                    $this->session->set_userdata(array('getPaymentData' => $record_num));
                } else {
                    $goToPayment = '';
                }


                $data['data']['goToPayment'] = $goToPayment;

           // }

            //echo $this->session->userdata('getPaymentData');exit;


            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean|integer');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');
            $this->form_validation->set_rules('goToPayment', 'goToPayment');


            $data['errors'] = array();
            if ($this->form_validation->run()) {                                // validation ok
                $this->load->model('cabinet_model');

                $username = $this->form_validation->set_value('username');
                $password = $this->form_validation->set_value('password');
                $goToPayment = $this->input->post('goToPayment');
                if($this->session->userdata('getPaymentData')){
                    $goToPayment = $this->session->userdata('getPaymentData'); //exit;
                }

                $this->is_eu_signin($username,$password); // EU client will redirect to the EU cabinet

                if(is_numeric($username)){

                    //echo $goToPayment;exit;
              

                    $this->clientAuthorization($username,$password,$goToPayment); // After authorization it will redirect to cabinet

                }else{
                    $this->session->set_flashdata("account-invalid", true);
                    redirect('client/signin');
                }



            }




            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('fer_02') //lang('ps_09')
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('ps_10')
            );



            $data['data']['remember']=  array(
                'name'          => 'remember',
                'id'            => 'remember',
                'value'         => 1,
                'type'          => 'checkbox',
                'class'         => form_error('remember')|| isset($errors['remember']) ?'': '' ,
                'placeholder'   => ''
            );
            if(set_value('remember'))
            {
                $data['data']['remember']['checked']="checked";
            }



            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            // redicrect landing apge get and new set
            $data['data']['landingRedirect']="";
            $rpageString="?landing=";
            $data['data']['landingRedirect']=($data['data']['landing'])?$rpageString.$data['data']['landing']:"";


            $user_country = FXPP::getUserCountryCode();


            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
                FXPP::urlBouncelog("We are sorry, our service is currently not available in your country.");
            }else{
                $data['data']['unavailable'] = false;
            }
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');

            $cssfile = '/custom-client.css';
            $view = 'signin_auto3_2';
            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css.".$cssfile'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build($view,$data['data']);
        }
    }




    public function signin_check_data_client(){
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $chakAcc='1';
        $chakAcc=$this->clientAuthorizationOnlyCheck($username,$password);
        $data['valid'] = $chakAcc;
        echo json_encode($data);

    }
    
    private function clientAuthorizationOnlyCheck($username,$password){

        $this->load->library('FXAPI');
        $ret = FXAPI::authorize(array('Login'=>$username,'Password'=>$password));
//echo "<pre>"; print_r($ret);exit;
                                
        
        if($ret['RET'] == 'RET_OK'){



            $api_session = array(
                'account_number' => $ret['data']->Login,
                'session_id' => $ret['data']->SessionId,
                'session_expiration' => $ret['data']->Expiration,
                'con_session_id' => $ret['data']->ConnectedSessionId,
                'con_account_number' => 0,

            );

            $this->session->set_userdata($api_session);
           // $mtUserDetails = FXPP::getMTUserDetails2($username);
             $mtUserDetails = FXPP::getMTUserDetails3(array($username));

            if($mtUserDetails[0]->LogIn){

                if ((strpos(strtolower($mtUserDetails[0]->Group), '-') == false)) { // if group is EU - redirect to EU site
                    return '1';
                }else if ((strpos(strtolower($mtUserDetails[0]->Group), 'pa') !== false)) {
                    $this->session->set_flashdata("wrongPassword", true);
                    return '2';
                }else if($mtUserDetails[0]->IsEnable == 0) {
                    $this->session->set_flashdata("account-blocked", true);
                    return '1';
                }else if($mtUserDetails[0]->IsDeleted  == 1) {
                    $this->session->set_flashdata("accountArchived", true);
                    return '1';
                }else{

                    return '1';
                }

            }else{

                return '1';

            }

        }else{  //RET_INVALID_PASSWORD

            

            return '2';


        }


    }
                                


                                

  
    private function setSessionValue($account_number,$readOnly=false,$goToPayment=false,$account_type=0){

        //echo echo $goToPayment.'==';exit;

        $this->load->model('cabinet_model');


        if( $user_info = $this->cabinet_model->getUserInfoByAccount($account_number,$account_type)){

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
                'country' => $user_info->country,
                'mt_account_set_id' => $user_info->mt_account_set_id,
                'currency' => $user_info->currency,
                'accountstatus' => $user_info->accountstatus,
                'readOnly'       => $readOnly, // ReadOnly will true only for master password
                'image' =>  $user_info->image,
                'goToPayment' =>  $goToPayment,
            );

            $this->session->set_userdata($session_data);

            return $session_data;

        }

        return false;



    }

    public function is_eu_signin($email,$password){
        $c_data = array(
            "email"    => $email,
            "password" => $password,
        );

        if(is_numeric($email)){
            $c_result = $this->fxboapi->get_details_by_id($email);
        }else{
            $c_result = $this->fxboapi->check_credentials($c_data);
        }

        if ($c_result->id) {
            $login_data = array(
                "user"   => $c_result->id,
                "locale" => "en",
            );
            $l_result = $this->fxboapi->request_login($login_data);
            if ($l_result) {
                redirect($l_result->url);
            }
        }
        return false;
    }




    public function limiBonousPageRedic($data)
    {

        // forexmart limit bonus page redirect.
        $urlRec=explode("__",$data);
        if($urlRec[1]=="my"){redirect("https://my.forexmart.com/".$urlRec[0]); }
        if($urlRec[1]=="web"){redirect("http://www.forexmart.com/".$urlRec[0]);}


    }



    public function username_check($str){
        if (!is_null($user = $this->users->get_user_by_login( $this->input->post('username',true)))) {
            return true;
        }else{
            $this->form_validation->set_message('username_check', 'Incorrect username . Please try again.');
            return FALSE;
        }
    }
    public function password_check($str){
        $this->load->library('Tank_auth');
        if (!is_null($user = $this->users->get_user_by_loginaccount( $this->input->post('username',true)))) {
            $mydata=array(
                'new'=>$this->input->post('password',true),
                'old'=>$user->password
            );
            if(Tank_auth::compare($mydata)){
                $newdata = array(
                    'full_name'  => $user->full_name,
                    'email'     => $user->email,
                    'logged' => 1,
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'status'    => ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                );
                $this->session->set_userdata($newdata);
//                redirect('my-account');

                redirect(FXPP::my_url('my-account'));

                return true;
            }else{
                $this->form_validation->set_message('password_check', 'Incorrect password . Please try again.');
                return FALSE;
            }
        }
    }

    private function GetCode($length) {
        $key = '';
        $keys = array_merge(range(0, 9),range('A', 'Z'),range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public function dailyCountryReport($user_id) {

        $this->load->model('account_model');
        $this->load->model('general_model');
        if($row = $insert_data['client_country'] = $this->account_model->getClientInfoByUserId($user_id)){
            $c_code = $row[0]->country;
            $insert_data['country'] = $this->general_model->getCountries();
            $insert_data['country']["GB','IE"] = "UK and Ireland ";
            $insert_data['country']["AT','DE"] = "Austria and Germany ";
            $insert_data['country']["AM','BY','KZ','KG','MD','RU','TJ','TM','UA','UZ"] = "Russia and CIS";

            $to_email = array(
//                "ES" => 'clients_spain_daily_1@forexmart.com',
//                "AT" => 'clients_germany_daily_1@forexmart.com',
//                "DE" => 'clients_germany_daily_1@forexmart.com',
                "FR" => 'clients_france_daily_1@forexmart.com',
                "GB" => 'clients_ukireland_daily_1@forexmart.com',
                "IE" => 'clients_ukireland_daily_1@forexmart.com',
                "BG" => 'clients_bulgaria_daily_1@Forexmart.com',
                "CA" => 'clients_ukireland_daily_1@forexmart.com',
                "NL" => 'clients_ukireland_daily_1@forexmart.com',
                "AM" => 'clients_russia_daily_1@forexmart.com',
                "BY" => 'clients_russia_daily_1@forexmart.com',
                "KZ" => 'clients_russia_daily_1@forexmart.com',
                "KG" => 'clients_russia_daily_1@forexmart.com',
                "MD" => 'clients_russia_daily_1@forexmart.com',
                "RU" => 'clients_russia_daily_1@forexmart.com',
                "TJ" => 'clients_russia_daily_1@forexmart.com',
                "TM" => 'clients_russia_daily_1@forexmart.com',
                "UA" => 'clients_russia_daily_1@forexmart.com',
                "UZ" => 'clients_russia_daily_1@forexmart.com',
//                "PL" => 'clients_poland_daily_1@forexmart.com',
                "SK" => 'clients_czech.slovak_daily_1@forexmart.com',
                "CZ" => 'clients_czech.slovak_daily_1@forexmart.com',
            );


            // $insert_data['email'] = "fin-stats@forexmart.com";
            // $insert_data['email'] = "moniruzzaman-it@itgrowtech.com,bug.fxpp@gmail.com";

            if (isset($to_email[$c_code])) {
                $insert_data['email'] = $to_email[$c_code];
            } else {
                return true; // At the moment we do not need the real time mailing with registrations from all countries.
                $insert_data['email'] = "german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com";
            }


            $insert_data['subject'] = "Clients from " . $insert_data['country'][$c_code] . " on  " . date('Y-m-d');
            $config = array(
                'mailtype' => 'html'
            );


            $this->load->library('email');
            if ($config != null) {
                $this->email->initialize($config);
            }
            $this->SMTPDebug = 1;
            $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
            //  $this->email->reply_to('noreply@mail.forexmart.com', 'ForexMart');
            $this->email->to($insert_data['email']);
            //  $this->email->to("moniruzzaman-it@itgrowtech.com,bug.fxpp@gmail.com");

            if (isset($to_email[$c_code])) {
                $this->email->bcc('german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com,stefania.sopko@forexmart.com');
            } else {
                // $insert_data['email'] ="german.pavlyak@forexmart.com,agus@forexmart.com,ildar.sharipov@forexmart.com";
                $this->email->bcc('stefania.sopko@forexmart.com');
            }

            $this->email->bcc('alexey.nikolaev@kpigroups.com');
            $this->email->subject($insert_data['subject']);
            $this->email->message($this->load->view('email/realtime_client_report', $insert_data, TRUE));
            $this->email->send();
        }

    }

    public function mt4(){
        if(!IPLoc::Office()){
            redirect('client/signin');
        }
        if ($this->tank_auth->is_logged_in()) {                                 // logged in
//            redirect(FXPP::my_url('my-account'));
            $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
            if ($data['for_analytics_hash']['first_login_stat']){
                $_SESSION['first_login']=true;
                header('Location: '.FXPP::my_url('my-account'.'?'.$data['for_analytics_hash']['first_login_hash']));
            }else{
                //header('Location: '.FXPP::my_url('my-account'));
                redirect(FXPP::my_url('my-account'));
            }

        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
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
            $administration=0;
            if ($this->form_validation->run()) {                                // validation ok
                $this->load->library('WebService');
                $webservice_config = array(
                    'server' => 'live_new'
                );
                $service_data = array(
                    'iLogin' => $this->form_validation->set_value('username'),
                    'strPassword' => $this->form_validation->set_value('password')
                );
                if(md5($service_data['strPassword']) == md5("FxMartMT4")){

                    $this->load->model('cabinet_model');
                    if($user_info = $this->cabinet_model->getPartnerInfoByAccount($service_data['iLogin'])){
                        $this->session->set_userdata(array(
                            'full_name'  => $user_info->full_name,
                            'user_id'   => $user_info->id,
                            'username'  => $user_info->username,
                            'email'     =>$user_info->email,
                            'logged_in' => TRUE,
                            'logged' => 1,
                            'status'    => 1,
                            'administration'    => $user_info->administration,
                            'login_type' => $user_info->login_type,
                            'readOnly'=>true
                        ));
                        //redirect('my-account');
                        redirect(FXPP::my_url('my-account'));
                    }else{
                        redirect('client/mt4');

                    }
                }else{
                    $WebService = new WebService($webservice_config);
                    $WebService->CheckUserPassword($service_data);

                    if ($WebService->request_status === 'RET_OK') {
                        $this->load->model('cabinet_model');
                        if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){
                            $this->session->set_userdata(array(
                                'full_name'  => $user_info->full_name,
                                'user_id'   => $user_info->id,
                                'username'  => $user_info->username,
                                'email'     =>$user_info->email,
                                'logged_in' => TRUE,
                                'logged' => 1,
                                'status'    => 1,
                                'administration'    => $user_info->administration,
                                'login_type' => $user_info->login_type,
                                //'readOnly'=>true
                            ));

                            //redirect('my-account');
                            redirect(FXPP::my_url('my-account'));
                        }else{
                            redirect('client/mt4');

                        }
                    }
                }


                if ($this->tank_auth->login(
                    $this->form_validation->set_value('username'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $data['login_by_username'],
                    $data['login_by_email'],$administration,0)) {                               // success

                    FXPP::update_account_balance();

                    //  echo $user_id= $this->session->userdata('user_id');   exit;
                    $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                    if ($data['for_analytics_hash']['first_login_stat']){
                        $_SESSION['first_login']=true;
                        redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));
                    }else{
                        redirect(FXPP::my_url('my-account/register'));
                    }

                    //echo "test";exit;
//                    header('Location: '.FXPP::my_url('my-account/register'));
//                    redirect('accounts/register');


                } else {

                    $errors = $this->tank_auth->get_error_message();

                    $data['data']['errors']= $errors;


                    if (isset($errors['banned'])) {                             // banned user
                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {                // not activated user
                        redirect('/auth/send_again/');

                    } else {                                                    // fail
                        foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                    }
                }


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


            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Account Number'
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Password'
            );

            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            $user_country = FXPP::getUserCountryCode();

            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
                FXPP::urlBouncelog("We are sorry, our service is currently not available in your country.");
            }else{
                $data['data']['unavailable'] = false;
            }
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');
            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('mt4_signin',$data['data']);
        }
    }

    public function signinmt4($data=false){
        if(!IPLoc::Office()){
            redirect('client/signin');
        }
        $data['data']=$this->input->get(NULL, TRUE);
        if(isset($data['data']['activate'])){
            $data['data']['Code'] = $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation", "0", "*", '');
            if ($data['data']['Code'] != false) {
                $this->db->trans_start();
                $whereData = array('countryCode' => $this->country_code);
                $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                    $currency = 'USD';
                } else {
                    $currency = $conndata->currencyCode;
                }


                $login_type = 0;
                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');
                $data['Activation'] = array(
                    "Activation" => 1
                );
                $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);

                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $data['data']['Code']['Email'],
                    $data['mycode'] = $this->GetCode(10),
                    $email_activation, 1, $login_type);

                $user_id = $user_inser_data['user_id'];
                $data['Users_Id'] = array(
                    "users_id" => $user_id
                );
                $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                $this->session->set_userdata($data['Users_Id']);
                $profile = array(
                    'full_name' => $data['data']['Code']['Fullname'],
                    'user_id' => $user_id,
                    'country' => $this->country_code,
                    'street' => '',
                    'city' => '',
                    'state' => '',
                    'zip' => '',
                    'dob' => ''

                );
                $this->general_model->insert('user_profiles', $profile);
                $swap_free = 0;
                $phone_password = FXPP::RandomizeCharacter(7);

                if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){
                    $this->session->set_userdata('isChina', '1');
                }

                $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free);

                $forexmart_affiliate_logs = $data['data']['Code']['Affiliate_code_logs'];
                $affiliate_referral_codes = ':' . str_replace('-', ':',$forexmart_affiliate_logs);
                $service_data = array(
                    'address' => '',
                    'city' => '',
                    'country' =>  $this->general_model->getCountries($this->country_code),
                    'email' => $data['data']['Code']['Email'],
                    'group' => $groupCurrency . '1',
                    'leverage' => count($ex_leverage = explode(":", '1:200')) > 1 ? $ex_leverage[1] : '1:200',
                    'name' => $data['data']['Code']['Fullname'],
                    'phone_number' => '',
                    'state' => '',
                    'zip_code' => '',
                    'phone_password' => $phone_password,
                    'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                );

                $webservice_config = array(
                    'server' => 'live_new'
                );
//                $WebService = new WebService($webservice_config);
//                $WebService->open_account_standard($service_data);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);

                if ($WebService->request_status === 'RET_OK') {

//                    $AccountNumber = $WebService->get_result('LogIn');
//                    $TraderPassword = $WebService->get_result('TraderPassword');
//                    $InvestorPassword = $WebService->get_result('InvestorPassword');

                    $AccountNumber    = $WebService->AccountNumber;
                    $TraderPassword   = $WebService->TraderPassword;
                    $InvestorPassword = $WebService->InvestorPassword;

//                    $RegDate = $WebService->get_result('RegDate');
                    $RegDate = FXPP::getServerTime();
                    $mt_account = array(
                        'leverage' => '1:200',
                        'amount' => 0,
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => $AccountNumber,
                        'trader_password' => $TraderPassword,
                        'investor_password' => $InvestorPassword,
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);


                    // Save Affiliate Link
                    $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                    $affiliate_code_data = array(
                        'users_id' => $user_id,
                        'affiliate_code' => $generateAffiliateCode
                    );
                    $this->general_model->insert('users_affiliate_code', $affiliate_code_data);

                    $forexmart_affiliate = $data['data']['Code']['Affiliate_code'];
                    if(!empty($forexmart_affiliate)){
                        $this->load->model('account_model');
                        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByAffiliateCode($forexmart_affiliate);
                        $AgentAccountNumber = $getAccountNumberByAffiliateCode[0]['reference_num'] ? $getAccountNumberByAffiliateCode[0]['reference_num'] : $getAccountNumberByAffiliateCode[0]['account_number'];
                        if(!empty($AgentAccountNumber)){

                            $service_data2 = array(
                                'AccountNumber' => $AccountNumber,
                                'AgentAccountNumber' => $AgentAccountNumber
                            );

                            if(IPLoc::APIUpgradeDevIP()){
                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService2 = $WSV->SetAccountDetail($service_data2, "SetAgentAccount");
                            }else{
                                $WebService2 = new WebService($webservice_config);
                                $WebService2->SetAccountAgent($service_data2);
                            }

//                            $WebService2 = new WebService($webservice_config);
//                            $WebService2->SetAccountAgent($service_data2);
                            if( $WebService2->request_status === 'RET_OK' ) {
                                $referral_data = array(
                                    'referral_affiliate_code' => $forexmart_affiliate
                                );
                                $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                            }

                            $getCookieLogs = str_replace("-", " : ", $forexmart_affiliate_logs);
                            $save_affiliate_logs = array(
                                'Affiliate_link_logs' => $getCookieLogs,
                                'Account_number' => $AccountNumber,
                                'User_id' => $user_id,
                                'Page' => 'signinmt4'
                            );
                            $this->general_model->insert('users_affiliate_link_logs', $save_affiliate_logs);
                            delete_cookie("affiliate_logs");
                        }

                    }

                    // End Affiliate Link

                } else {
                    $mt_account = array(
                        'leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => FXPP::getServerTime(),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => '',
                        'trader_password' => '',
                        'investor_password' => '',
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);
                }

                $trading_experience = array(
                    'investment_knowledge' => '',
                    'risk' => '',
                    'experience' => '',
                    'user_id' => $user_id,
                    'technical_analysis' => '',
                    'trade_duration' => '',
                );
                $this->general_model->insert('trading_experience', $trading_experience);

                $contacts_data = array(
                    'phone1' => '',
                    'user_id' => $user_id
                );
                $this->general_model->insert('contacts', $contacts_data);

                $email_data = array(
                    'full_name' => $data['data']['Code']['Fullname'],
                    'email' => $data['data']['Code']['Email'],
                    'password' => $data['mycode'],
                    'account_number' => $mt_account['account_number'],
                    'trader_password' => $mt_account['trader_password'],
                    'investor_password' => $mt_account['investor_password'],
                    'phone_password' => $mt_account['phone_password'],
                );

                $subject = "ForexMart MT4 Live Trading Account details";
                $config = array(
                    'mailtype' => 'html'
                );
                $this->general_model->sendEmail2('live-account-html2', $subject, $email_data['email'], $email_data, $config);
                $this->dailyCountryReport($user_id);
                $data['data']['insertsuccess'] = true;
                $data['data']['custom_validation_success'] = 'Your email address has been confirmed.We have sent you live-account access to your email.';
                $data['data']['AccountNumber'] = $mt_account['account_number'];
                $data['data']['trader_password'] = $mt_account['trader_password'];
                $data['data']['investor_password'] = $mt_account['investor_password'];
                $_SESSION['landing'] = true;
                $this->db->trans_complete();
                $this->session->unset_userdata('landing-error');

            } else {
                $_SESSION['landing'] = false;
                $_SESSION['landing-error'] = true;
                $this->session->unset_userdata('landing');
            }

        }else{
            $data['data']['error']= 'No user to display';
        }

        $data['data']['notice']=$data;
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');
        if ($this->tank_auth->is_logged_in()) {                                 // logged in
//            redirect(FXPP::my_url('my-account'));
            if(IPLoc::Office()){
                $this->sync_ApiToDatabase();
                FXPP::verify_duplicate_live_account();
            }
            //header('Location: '.FXPP::my_url('my-account'));
            redirect(FXPP::my_url('my-account'));
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
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
            $administration=0;
            if ($this->form_validation->run()) {                                // validation ok



                //========================================================

                //  $username = $this->form_validation->set_value('username');
                $username = $this->input->post('username',true);

                if(is_numeric($username)){                              // validation ok
                    $this->load->library('WebService');
                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $service_data = array(
                        'iLogin' => $this->form_validation->set_value('username'),
                        'strPassword' => $this->form_validation->set_value('password')
                    );
                    if(md5($service_data['strPassword']) == md5("FxMartMT4")){

                        $this->load->model('cabinet_model');
                        if($user_info = $this->cabinet_model->getPartnerInfoByAccount($service_data['iLogin'])){
                            $this->session->set_userdata(array(
                                'full_name'  => $user_info->full_name,
                                'user_id'   => $user_info->id,
                                'username'  => $user_info->username,
                                'email'     =>$user_info->email,
                                'logged_in' => TRUE,
                                'logged' => 1,
                                'status'    => 1,
                                'administration'    => $user_info->administration,
                                'login_type' => $user_info->login_type,
                                'readOnly'=>true
                            ));
                            //redirect('my-account');
                            redirect(FXPP::my_url('my-account'));
                        }else{
                            // redirect('client/mt4');

                        }
                    }else{
                        $WebService = new WebService($webservice_config);
                        $WebService->CheckUserPassword($service_data);

                        if ($WebService->request_status === 'RET_OK') {
                            $this->load->model('cabinet_model');
                            if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){
                                $this->session->set_userdata(array(
                                    'full_name'  => $user_info->full_name,
                                    'user_id'   => $user_info->id,
                                    'username'  => $user_info->username,
                                    'email'     =>$user_info->email,
                                    'logged_in' => TRUE,
                                    'logged' => 1,
                                    'status'    => 1,
                                    'administration'    => $user_info->administration,
                                    'login_type' => $user_info->login_type,
                                    //'readOnly'=>true
                                ));

                                //redirect('my-account');
                                redirect(FXPP::my_url('my-account'));
                            }else{
                                // redirect('client/mt4');

                            }
                        }
                    }


                    if ($this->tank_auth->login(
                        $this->form_validation->set_value('username'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email'],$administration,0)) {                               // success

                        FXPP::update_account_balance();

                        //  echo $user_id= $this->session->userdata('user_id');   exit;
                        $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                        if ($data['for_analytics_hash']['first_login_stat']){
                            $_SESSION['first_login']=true;
                            redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));
                        }else{
                            redirect(FXPP::my_url('my-account/register'));
                        }

                        //echo "test";exit;
//                    header('Location: '.FXPP::my_url('my-account/register'));
//                    redirect('accounts/register');


                    } else {

                        $errors = $this->tank_auth->get_error_message();

                        $data['data']['errors']= $errors;


                        if (isset($errors['banned'])) {                             // banned user
                            $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                        } elseif (isset($errors['not_activated'])) {                // not activated user
                            redirect('/auth/send_again/');

                        } else {                                                    // fail
                            foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                        }
                    }


                }

                //=========================================================






                if ($this->tank_auth->login(
                    $this->form_validation->set_value('username'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $data['login_by_username'],
                    $data['login_by_email'],$administration,0)) {                               // success


                    FXPP::update_account_balance();

                    //  echo $user_id= $this->session->userdata('user_id');   exit;
                    $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                    if ($data['for_analytics_hash']['first_login_stat']){
                        $_SESSION['first_login']=true;
                        if(IPLoc::Office()){
                            $this->sync_ApiToDatabase();
                            FXPP::verify_duplicate_live_account();
                        }
                        redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));
                    }else{
                        if(IPLoc::Office()){
                            $this->sync_ApiToDatabase();
                            FXPP::verify_duplicate_live_account();
                        }
                        redirect(FXPP::my_url('my-account/register'));
                    }
                    //echo "test";exit;
//                    header('Location: '.FXPP::my_url('my-account/register'));
//                    redirect('accounts/register');


                } else {

                    $errors = $this->tank_auth->get_error_message();

                    $data['data']['errors']= $errors;


                    if (isset($errors['banned'])) {                             // banned user
                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {                // not activated user
                        redirect('/auth/send_again/');

                    } else {                                                    // fail
                        foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                    }
                }


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


            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Email'
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Password'
            );

            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            $user_country = FXPP::getUserCountryCode();

            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
            }else{
                $data['data']['unavailable'] = false;
            }
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');
            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."/signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('signinmt4',$data['data']);
        }
    }

    public function signin1($data=false){
        if(!IPLoc::Office()){redirect("");}

        $data['data']=$this->input->get(NULL, TRUE);
        if(isset($data['data']['activate'])){
            $data['data']['Code'] = $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation", "0", "*", '');
            if ($data['data']['Code'] != false) {
                $this->db->trans_start();
                $whereData = array('countryCode' => $this->country_code);
                $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                    $currency = 'USD';
                } else {
                    $currency = $conndata->currencyCode;
                }


                $login_type = 0;
                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');
                $data['Activation'] = array(
                    "Activation" => 1
                );
                $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);

                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $data['data']['Code']['Email'],
                    $data['mycode'] = $this->GetCode(10),
                    $email_activation, 1, $login_type);

                $user_id = $user_inser_data['user_id'];
                $data['Users_Id'] = array(
                    "users_id" => $user_id
                );
                $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                $this->session->set_userdata($data['Users_Id']);
                $profile = array(
                    'full_name' => $data['data']['Code']['Fullname'],
                    'user_id' => $user_id,
                    'country' => $this->country_code,
                    'street' => '',
                    'city' => '',
                    'state' => '',
                    'zip' => '',
                    'dob' => ''

                );
                $this->general_model->insert('user_profiles', $profile);
                $swap_free = 0;
                $phone_password = FXPP::RandomizeCharacter(7);

                if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){
                    $this->session->set_userdata('isChina', '1');
                }

                $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free);


                $forexmart_affiliate_logs = $data['data']['Code']['Affiliate_code_logs'];
//                $affiliate_referral_codes = ':' . str_replace('-', ':',$this->input->cookie('forexmart_affiliate_logs'));
                $affiliate_referral_codes = ':' . str_replace('-', ':',$forexmart_affiliate_logs);

                $service_data = array(
                    'address' => '',
                    'city' => '',
                    'country' =>  $this->general_model->getCountries($this->country_code),
                    'email' => $data['data']['Code']['Email'],
                    'group' => $groupCurrency . '1',
                    'leverage' => count($ex_leverage = explode(":", '1:200')) > 1 ? $ex_leverage[1] : '1:200',
                    'name' => $data['data']['Code']['Fullname'],
                    'phone_number' => '',
                    'state' => '',
                    'zip_code' => '',
                    'phone_password' => $phone_password,
                    'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                );

                $webservice_config = array(
                    'server' => 'live_new'
                );
//                $WebService = new WebService($webservice_config);
//                $WebService->open_account_standard($service_data);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);

                if ($WebService->request_status === 'RET_OK') {

//                    $AccountNumber = $WebService->get_result('LogIn');
//                    $TraderPassword = $WebService->get_result('TraderPassword');
//                    $InvestorPassword = $WebService->get_result('InvestorPassword');

                    $AccountNumber    = $WebService->AccountNumber;
                    $TraderPassword   = $WebService->TraderPassword;
                    $InvestorPassword = $WebService->InvestorPassword;

//                    $RegDate = $WebService->get_result('RegDate');
                    $RegDate = FXPP::getServerTime();
                    $mt_account = array(
                        'leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => $AccountNumber,
                        'trader_password' => $TraderPassword,
                        'investor_password' => $InvestorPassword,
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);


                    // Save Affiliate Link
                    $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                    $affiliate_code_data = array(
                        'users_id' => $user_id,
                        'affiliate_code' => $generateAffiliateCode
                    );
                    $this->general_model->insert('users_affiliate_code', $affiliate_code_data);

                    $forexmart_affiliate = $data['data']['Code']['Affiliate_code'];
                    if(!empty($forexmart_affiliate)){
                        $this->load->model('account_model');

                        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                        $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

                        if(!empty($AgentAccountNumber)){

                            $service_data2 = array(
                                'AccountNumber' => $AccountNumber,
                                'AgentAccountNumber' => $AgentAccountNumber
                            );

                            if(IPLoc::APIUpgradeDevIP()){
                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService2 = $WSV->SetAccountDetail($service_data2, "SetAgentAccount");
                            }else{
                                $WebService2 = new WebService($webservice_config);
                                $WebService2->SetAccountAgent($service_data2);
                            }

//                            $WebService2 = new WebService($webservice_config);
//                            $WebService2->SetAccountAgent($service_data2);
                            if( $WebService2->request_status === 'RET_OK' ) {
                                $referral_data = array(
                                    'referral_affiliate_code' => $forexmart_affiliate
                                );
                                $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                            }

                            $getCookieLogs = str_replace("-", " : ", $forexmart_affiliate_logs);
                            $save_affiliate_logs = array(
                                'Affiliate_link_logs' => $getCookieLogs,
                                'Account_number' => $AccountNumber,
                                'User_id' => $user_id,
                                'Page' => 'signin'
                            );
                            $this->general_model->insert('users_affiliate_link_logs', $save_affiliate_logs);
                            delete_cookie("affiliate_logs");
                        }

                    }

                    // End Affiliate Link
//                    $debug_data = array(
//                        'message' => 'RegDate: ' . date('Y-m-d H:i:s', strtotime($RegDate)) . '<br/> API RegDate: ' . $RegDate
//                    );
//                    $config = array(
//                        'mailtype'=> 'html'
//                    );
//                    $this->general_model->sendEmail('debug-html', 'Debug Internal', 'vela.nightclad@gmail.com', $debug_data,$config);
                } else {
                    $mt_account = array(
                        'leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => FXPP::getServerTime(),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => '',
                        'trader_password' => '',
                        'investor_password' => '',
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);
                }

                $trading_experience = array(
                    'investment_knowledge' => '',
                    'risk' => '',
                    'experience' => '',
                    'user_id' => $user_id,
                    'technical_analysis' => '',
                    'trade_duration' => '',
                );
                $this->general_model->insert('trading_experience', $trading_experience);

                $contacts_data = array(
                    'phone1' => '',
                    'user_id' => $user_id
                );
                $this->general_model->insert('contacts', $contacts_data);

                $email_data = array(
                    'full_name' => $data['data']['Code']['Fullname'],
                    'email' => $data['data']['Code']['Email'],
                    'password' => $data['mycode'],
                    'account_number' => $mt_account['account_number'],
                    'trader_password' => $mt_account['trader_password'],
                    'investor_password' => $mt_account['investor_password'],
                    'phone_password' => $mt_account['phone_password'],
                );

                $subject = "ForexMart MT4 Live Trading Account details";
                $config = array(
                    'mailtype' => 'html'
                );
                $this->general_model->sendEmail2('live-account-html2', $subject, $email_data['email'], $email_data, $config);
                $this->dailyCountryReport($user_id);
                $data['data']['insertsuccess'] = true;
                $data['data']['custom_validation_success'] = 'Your email address has been confirmed.We have sent you live-account access to your email.';
                $data['data']['AccountNumber'] = $mt_account['account_number'];
                $data['data']['trader_password'] = $mt_account['trader_password'];
                $data['data']['investor_password'] = $mt_account['investor_password'];
                $_SESSION['landing'] = true;
                $this->db->trans_complete();
                $this->session->unset_userdata('landing-error');

            } else {
                $_SESSION['landing'] = false;
                $_SESSION['landing-error'] = true;

//                if(IPLoc::Office()){
//                    var_dump($this->input->cookie('forexmart_affiliate_logs'));
//                }

                $this->session->unset_userdata('landing');
            }

        }else{
            $data['data']['error']= 'No user to display';
        }

        $data['data']['notice']=$data;
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');
        if ($this->tank_auth->is_logged_in()) {                                 // logged in
//            redirect(FXPP::my_url('my-account'));
            if(IPLoc::Office()){
                $this->sync_ApiToDatabase();
                FXPP::verify_duplicate_live_account();
            }
            //header('Location: '.FXPP::my_url('my-account'));
            redirect(FXPP::my_url('my-account'));
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
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
            $administration=0;
            if ($this->form_validation->run()) {                                // validation ok


                //========================================================
                $this->load->model('cabinet_model');
                $username = $this->form_validation->set_value('username');

                if(is_numeric($username)){                              // validation ok
                    $this->load->library('WebService');
                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $service_data = array(
                        'iLogin' => $this->form_validation->set_value('username'),
                        'strPassword' => $this->form_validation->set_value('password')
                    );

                    $WebService = new WebService($webservice_config);
                    $WebService->CheckUserPassword($service_data);

                    if ($WebService->request_status === 'RET_OK') {

                        if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){
                            $this->session->set_userdata(array(
                                'full_name'  => $user_info->full_name,
                                'user_id'   => $user_info->id,
                                'username'  => $user_info->username,
                                'email'     =>$user_info->email,
                                'logged_in' => TRUE,
                                'logged' => 1,
                                'status'    => 1,
                                'administration'    => $user_info->administration,
                                'login_type' => $user_info->login_type,
                                //'readOnly'=>true
                            ));

                            //redirect('my-account');
                            redirect(FXPP::my_url('my-account'));
                        }else{
                            // redirect('client/mt4');

                        }

                    }
                }

                // validation ok
                $this->load->library('WebService');
                $webservice_config = array(
                    'server' => 'live_new'
                );
                $email = $this->form_validation->set_value('username');
                $password = $this->form_validation->set_value('password');

                if($account = $this->cabinet_model->getAccountNumberByEmail($email)){

                    foreach($account as $d){

                        $service_data = array(
                            'iLogin' => $d->account_number,
                            'strPassword' => $password
                        );

                        $WebService = new WebService($webservice_config);
                        $WebService->CheckUserPassword($service_data);

                        if ($WebService->request_status === 'RET_OK') {

                            if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){
                                $this->session->set_userdata(array(
                                    'full_name'  => $user_info->full_name,
                                    'user_id'    => $user_info->id,
                                    'username'   => $user_info->username,
                                    'email'     =>$user_info->email,
                                    'logged_in'  => TRUE,
                                    'logged' => 1,
                                    'status' => 1,
                                    'administration' => $user_info->administration,
                                    'login_type' => $user_info->login_type,
                                    //'readOnly'=>true
                                ));

                                //redirect('my-account');
                                redirect(FXPP::my_url('my-account'));
                            }else{
                                // redirect('client/mt4');

                            }

                        }

                    }


                }




                if ($this->tank_auth->login(
                    $this->form_validation->set_value('username'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $data['login_by_username'],
                    $data['login_by_email'],$administration,0)) {                               // success


                    FXPP::update_account_balance();

                    //  echo $user_id= $this->session->userdata('user_id');   exit;
                    $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                    if ($data['for_analytics_hash']['first_login_stat']){
                        $_SESSION['first_login']=true;
                        if(IPLoc::Office()){
                            $this->sync_ApiToDatabase();
                            FXPP::verify_duplicate_live_account();
                        }
                        redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));
                    }else{
                        if(IPLoc::Office()){
                            $this->sync_ApiToDatabase();
                            FXPP::verify_duplicate_live_account();
                        }
                        redirect(FXPP::my_url('my-account/register'));
                    }
                    //echo "test";exit;
//                    header('Location: '.FXPP::my_url('my-account/register'));
//                    redirect('accounts/register');


                } else {

                    $errors = $this->tank_auth->get_error_message();

                    $data['data']['errors']= $errors;


                    if (isset($errors['banned'])) {                             // banned user
                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {                // not activated user
                        redirect('/auth/send_again/');

                    } else {                                                    // fail
                        foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                    }
                }


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


            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Email'
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => 'Password'
            );

            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            $user_country = FXPP::getUserCountryCode();

            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
            }else{
                $data['data']['unavailable'] = false;
            }
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');
            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."/signin.min.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('mt4_signin',$data['data']);
        }
    }


    public function sync_ApiToDatabase()
    {
        $success = false;
        $account = array();
        $data = array();
        $this->load->model('Deposit_model');
        $this->load->model('User_model');
        $this->load->model('contact_model');
        $this->load->model('Account_model');
        $account_id = $this->session->userdata('user_id');
        $type = 1; //live account
        $account = $this->Account_model->getAccountsByIdType($account_id, $type);
//        print_r($account);exit;
        if (count($account) > 0) {
            $success = true;
            if ($type == 1) {

                $account_info = array('iLogin' => $account['account_number']);
                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
//                $WebService->open_RequestAccountDetails($account_info);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

                if ($WebService->request_status == 'RET_OK') {
                    $field_alias = array(
                        'email' => 'Email',
                        'full_name' => 'Name',
                        'street' => 'Street Address',
                        'city' => 'City',
                        'state' => 'State/Province',
                        'zip' => 'Postal/Zip Code',
                        'phone1' => 'Phone Number',
                        'leverage' => 'Leverage',
                        'fb' => 'fb',
                        'social_media_type' => 'social_media_type'
                    );

                    $field['email'] = $account['email'];
                    $field['full_name'] = $account['full_name'];
                    $field['street'] = $account['street'];
                    $field['city'] = $account['city'];
                    $field['state'] = $account['state'];
                    $field['zip'] = $account['zip'];
                    $field['phone1'] = $account['phone1'];
                    $field['leverage'] = $account['leverage'];
                    $field['fb'] = $account['fb'];
                    $field['social_media_type'] = $account['social_media_type'];

//                    $service['email'] = $WebService->get_result('Email');
//                    $service['full_name'] = $WebService->get_result('Name');
//                    $service['street'] = $WebService->get_result('Address');
//                    $service['city'] = $WebService->get_result('City');
//                    $service['state'] = $WebService->get_result('State');
//                    $service['zip'] = $WebService->get_result('ZipCode');
//                    $service['phone1'] = $WebService->get_result('PhoneNumber');
//                    $service['leverage'] = '1:' . $WebService->get_result('Leverage');

                    $service['email']     = $WebService->result['Email'];
                    $service['full_name'] = $WebService->result['Name'];
                    $service['street']    = $WebService->result['Address'];
                    $service['city']      = $WebService->result['City'];
                    $service['state']     = $WebService->result['State'];
                    $service['zip']       = $WebService->result['ZipCode'];
                    $service['phone1']    = $WebService->result['PhoneNumber'];
                    $service['leverage']  = '1:' . $WebService->result['Leverage'];

                    $date_modified = FXPP::getCurrentDateTime();
                    $has_changes = false;
                    $update_history_field_data = array();
                    foreach ($field as $key => $value) {
                        if ($value != $service[$key]) {
                            $has_changes = true;
                            $update_history_field_data[] = array(
                                'field' => $field_alias[$key],
                                'old_value' => $value,
                                'new_value' => $service[$key],
                                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
                            );

                            switch ($key) {
                                case "email":
                                    $user_data = array(
                                        'email' => $service[$key],
                                        'modified' => date('Y-m-d H:i:s', strtotime($date_modified))
                                    );
                                    $this->User_model->updateUserById($account['user_id'], $user_data);
                                    $user_contact_data = array(
                                        'email1' => $service[$key]
                                    );
                                    $this->contact_model->updateContactByUserId($account['user_id'], $user_contact_data);
                                    break;
                                case "full_name":
                                case "street":
                                case "city":
                                case "state":
                                case "zip":
                                    $user_profile_data = array(
                                        $key => $service[$key]
                                    );
                                    $this->User_model->updateUserProfileInfoById($account['user_id'], $user_profile_data);
                                    break;
                                case "phone1":
                                    $user_contact_data = array(
                                        'phone1' => $service[$key]
                                    );
                                    $this->contact_model->updateContactByUserId($account['user_id'], $user_contact_data);
                                    break;
                                case "leverage":
                                    $user_account_data = array(
                                        'leverage' => $service[$key]
                                    );
                                    $this->Account_model->updateAccountByUserId($account['user_id'], $user_account_data);
                                    break;
                            }
                        }
                    }
                    if ($has_changes) {
                        $update_history_data = array(
                            'user_id' => $account['user_id'],
                            'manager_id' => 0,
                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                            'update_url' => FXPP::loc_url('client/sync_ApiToDatabase')
                        );
                        $update_history_id = $this->Account_model->insertAccountUpdateHistory($update_history_data);
                        if ($update_history_id) {
                            foreach ($update_history_field_data as $key => $value) {
                                $update_history_field_data[$key]['update_id'] = $update_history_id;
                            }
                            $this->Account_model->insertAccountUpdateFieldHistory($update_history_field_data);
                        }
                        $account = $this->Account_model->getAccountsByIdType($account_id, $type);
                    }
                }

//                    if (FXPP::update_auto_leverage($account['user_id'])) {
                if (FXPP::leverage_auto_change($account['user_id'])) {
                    $account = $this->Account_model->getAccountsByIdType($account_id, $type);
                }
                $trading_experience = explode(',', $account['experience']);
                $trading_experience_value = array();
                if (count($trading_experience) > 2) {
                    foreach ($trading_experience as $experience) {
                        if ($experience) {
                            $trading_experience_value[] = true;
                        } else {
                            $trading_experience_value[] = false;
                        }
                    }
                } else {
                    $trading_experience_value = array(false, false, false);
                }

                $ndb_comment = '';
                if ($account['nodepositbonus'] == 1) {
                    $ndb_comment = 'NDB has been credited.';
                } else {
                    $hasNoDepositRequest = $this->Deposit_model->hasNoDepositRequest($account['user_id']);
                    if ($hasNoDepositRequest) {
                        $ndb_comment = 'NDB has been requested.';
                    }
                }

                $getAffiliateDetailsByUserId = $this->Account_model->getAffiliateDetailsByUserId($account['user_id']);
                $referralCode = $getAffiliateDetailsByUserId['referral_affiliate_code'];

                $data = array(
                    'success' => $success,
                    'corporate_acc_status' => $account['corporate_acc_status'],
                    'account_number' => $account['account_number'],
                    'mt_status' => trim($account['mt_status']),
                    'account_data' => array(
                        'email' => $account['email'],
                        'name' => $account['full_name'],
                        'address' => $account['street'],
                        'city' => $account['city'],
                        'state' => $account['state'],
                        'country' => $account['country'],
                        'zip_code' => $account['zip'],
                        'phone_number' => $account['phone1'],
                        'birth_date' => date('m/d/Y', strtotime($account['dob'])),
                        'account_type' => $this->general_model->getAccountType($account['mt_account_set_id']),
                        'currency_base' => $account['mt_currency_base'],
                        'leverage' => $account['leverage'],
                        'investment_knowledge' => $this->general_model->getInvestmentKnowledge($account['investment_knowledge']),
                        'trade_duration' => $this->general_model->getTradeDuration($account['trade_duration']),
                        'employment_status' => $this->general_model->getEmploymentStatus($account['employment_status']),
                        'industry' => $this->general_model->getIndustry($account['industry']),
                        'estimated_annual_income' => $this->general_model->getEstimatedAnnualIncome($account['estimated_annual_income']),
                        'education_level' => $this->general_model->getEducationLevel($account['education_level']),
                        'affiliate_code' => $referralCode,
                        'auto_leverage' => $account['auto_leverage'] == 0 ? false : true,
                        'ndb_status' => $ndb_comment,
                        'fb' =>$account['fb'],
                        'social_media_type' => $account['social_media_type'],
                        'user_id' => $account['user_id']

                    ),
                    'trading_data' => array(
                        'swap_free' => $account['swap_free'] ? true : false,
                        'trading_experience' => $trading_experience_value,
                        'politically_exposed_person' => ($account['politically_exposed_person']) ? 'Yes' : 'No',
                        'risk' => ($account['risk']) ? 'Yes' : 'No'
                    ),
                    'employee_data' => array(
                        'us_resident' => ($account['us_resident']) ? 'Yes' : 'No',
                        'us_citizen' => ($account['us_citizen']) ? 'Yes' : 'No'
                    )
                );
            } else {
                $data = array(
                    'success' => $success,
                    'account_number' => $account['account_number'],
                    'account_data' => array(
                        'email' => $account['email'],
                        'name' => $account['full_name'],
                        'country' => $account['country'],
                        'phone_number' => $account['phone1'],
                        'amount' => $account['amount'],
                        'account_type' => $this->general_model->getAccountType($account['mt_account_set_id']),
                        'currency_base' => $account['mt_currency_base'],
                        'leverage' => $account['leverage']
                    )
                );
            }

        }
    }

    public function autoCreditNdbProcess($data){

        $dev_country = array('EU','BE','BG','HR','CZ','DK','EE','FI','FR','DE','GR','HU','IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES', 'SE','GB'); //15000
        $country_2 = array('RU','CIS','AZ','BY','GE','MD','TM','UA'); //$1000
        $count_3 = array('IN','PK','BD'); //250 //rest 500

        $country = FXPP::getCountryByIP();
        $comment = 'FOREXMART NO DEPOSIT BONUS';

        if($country <> 'CY') { // no bonus
            if (in_array($country, $dev_country)) {
                $credit_amount = 1500;
            } else if  (in_array($country, $country_2)) {
                $credit_amount = 1000;
            } else if (in_array($country, $count_3)) {
                $credit_amount = 250;
            } else {
                $credit_amount = 500;
            }

            $webservice_config = array('server' => 'live_new');
            $WebServiceNDB = new WebService($webservice_config);
            $account_info = array(
                'Login'                       => $data['account_number'],
                'FundTransferAccountReciever' => $data['account_number'],
                'Amount'                      => $credit_amount,
                'Comment'                     => $comment,
                'ProcessByIP'                 => FXPP::CI()->input->ip_address()
            );

            $WebServiceNDB->open_Deposit_NoDepositBonus($account_info);
            if ($WebServiceNDB->request_status === 'RET_OK') {

                $date_updated = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $prvt_data['nodepositbonus'] = array(
                    'nodepositbonus'   => 1,
                    'ndb_bonus'        => floatval($credit_amount),
                    'ndb_ticket'       =>$WebServiceNDB->get_result('Ticket'),
                    'ndba_acquired'    => $date_updated->format('Y-m-d H:i:s'),
                    'ndb_bonus_ccy'    => floatval($credit_amount),
                    'ndb_cabinet_crediting' => 2
                );
                FXPP::CI()->general_model->updatemy($table = 'users', $field = 'id', $id = $data['user_id'], $prvt_data['nodepositbonus']);

                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $data['user_id'],
                    'process'        => 'API nodeposit bonus Registration',
                    'api'            => 'open_Deposit_NoDepositBonus',
                    'account_number' => $data['account_number'],
                    'status'         => 1,
                    'amount'         => $credit_amount,
                    'country'        => $country,
                    'ip'             => FXPP::CI()->input->ip_address(),
                    'api_status'     => $WebServiceNDB->request_status,

                );
                FXPP::CI()->general_model->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/

            }else{

                $tbl_log = array(
                    'user_id'        => $data['user_id'],
                    'process'        => 'API nodeposit bonus',
                    'api'            => 'open_Deposit_NoDepositBonus Registration',
                    'account_number' => $data['account_number'],
                    'status'         => 2,
                    'amount'         => $credit_amount,
                    'country'        => $country,
                    'ip'             => FXPP::CI()->input->ip_address(),
                    'api_status'     => $WebServiceNDB->request_status,

                );
                FXPP::CI()->general_model->insertmy($table='no_deposit_logs',$data=$tbl_log);
            }
        }else{

            $tbl_log = array(
                'user_id'        => $data['user_id'],
                'process'        => 'API nodeposit bonus Registration',
                'api'            => 'open_Deposit_NoDepositBonus',
                'account_number' => $data['account_number'],
                'status'         => 2,
                'amount'         => 0,
                'country'        => $country,
                'ip'             => FXPP::CI()->input->ip_address(),
                'api_status'     => 'CYPRUS NO BONUSES',

            );
            FXPP::CI()->general_model->insertmy($table='no_deposit_logs',$data=$tbl_log);
        }

    }


    public function signin_auto($data=false){

        if(!IPLoc::Office()){redirect('');}

        $data['data']=$this->input->get(NULL, TRUE);
        if (IPLoc::IPCrpAccVerify()){
//           echo $data['data']['activate'];exit();
        }

        if(isset($data['data']['activate'])){

            $data['data']['Code'] = $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation", "0", "*", '');

            if ($data['data']['Code'] != false) {

//                $this->db->trans_start();
                if(is_null($this->country_code) || $this->country_code == 'ZZ' ){
                    $_SESSION['landing-error'] ="country";
                    redirect('');
                }

                $whereData = array('countryCode' => $this->country_code);
                $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                    $currency = 'USD';
                } else {
                    $currency = $conndata->currencyCode;
                }
                $message = '';
                $login_type = 0;
                $use_username = $this->config->item('use_username', 'tank_auth');
                $email_activation = $this->config->item('email_activation', 'tank_auth');
                $data['Activation'] = array(
                    "Activation" => 1
                );

                ///   $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);

                $user_inser_data = $this->tank_auth->create_user(
                    $use_username ? $this->form_validation->set_value('username') : '',
                    $data['data']['Code']['Email'],
                    $data['mycode'] = $this->GetCode(10),
                    $email_activation, 1, $login_type);

                $user_id = $user_inser_data['user_id'];
                $data['Users_Id'] = array(
                    "users_id" => $user_id
                );


//                $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
//                $data['save_hash'] = array(
//                    'first_login_hash' => $data['random_alpha_string_analytics'],
//                    'first_login_stat' => 1
//                );
//                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
//                $user_data = array(
//                    'analytic_hash' => $data['random_alpha_string_analytics'],
//                );
//                $this->session->set_userdata($user_data);




                // track registration link
                $this->load->helpers('url');
                $reg_date = FXPP::getServerTime();
                $reg_details = $this->general_model->showt1w1("track_registration", "additional", $data['data']['activate'], "*");

                /* //  just update tracking and landing table
                $reg_link_details = array(
                            'user_id' => $user_id,
                            'additional' => json_encode(array('Full Name' => $data['data']['Code']['Fullname'], 'Email' => $data['data']['Code']['Email'], 'Country' => $this->general_model->getCountries($this->country_code))),
                            'date_created' => date('Y-m-d H:i:s', strtotime($reg_date)),
                        );
                        $this->general_model->updatemy('track_registration','id',$reg_details['id'],$reg_link_details);


                        $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                        $this->session->set_userdata($data['Users_Id']);
                */

                $swap_free = 0;
                $phone_password = FXPP::RandomizeCharacter(7);




                $checkCdata=$this->general_model->getQueryStirngRow('user_profiles', 'country',array('id'=>$user_id));
                if($checkCdata)
                {
                    $country=$checkCdata->country;
                    if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
                        $this->session->set_userdata('isChina', '1');
                    }
                }

//                $country = $this->account_model->getAccountsCountry($user_id);
//                if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
//                    $this->session->set_userdata('isChina', '1');
//                }

                $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free);

                $forexmart_affiliate_logs = $data['data']['Code']['Affiliate_code_logs'];
//                $affiliate_referral_codes = ':' . str_replace('-', ':',$this->input->cookie('forexmart_affiliate_logs'));
                $affiliate_referral_codes = ':' . str_replace('-', ':',$forexmart_affiliate_logs);

                $service_data = array(
                    'address' => '',
                    'city' => '',
                    'country' =>  $this->general_model->getCountries($this->country_code),
                    'email' => $data['data']['Code']['Email'],
                    'group' => $groupCurrency . '1',
                    'leverage' => count($ex_leverage = explode(":", '1:200')) > 1 ? $ex_leverage[1] : '1:200',
                    'name' => $data['data']['Code']['Fullname'],
                    'phone_number' => $data['data']['Code']['phone_number'],
                    'state' => '',
                    'zip_code' => '',
                    'phone_password' => $phone_password,
                    'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                );

                $webservice_config = array(
                    'server' => 'live_new'
                );
//                $WebService = new WebService($webservice_config);
//                $WebService->open_account_standard($service_data);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);

                if($WebService->request_status === 'RET_OK'){

                    // above code insert this
                    $reg_link_details = array(
                        'user_id' => $user_id,
                        'additional' => json_encode(array('Full Name' => $data['data']['Code']['Fullname'], 'Email' => $data['data']['Code']['Email'], 'Country' => $this->general_model->getCountries($this->country_code))),
                        'date_created' => date('Y-m-d H:i:s', strtotime($reg_date)),
                    );
                    $this->general_model->updatemy('track_registration','id',$reg_details['id'],$reg_link_details);
                    $data['updateRet'] = $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Activation']);
                    $this->general_model->updatemy($table = "forexmart_landing", "Code", $data['data']['activate'], $data['Users_Id']);
                    $this->session->set_userdata($data['Users_Id']);


//                    $AccountNumber = $WebService->get_result('LogIn');
//                    $TraderPassword = $WebService->get_result('TraderPassword');
//                    $InvestorPassword = $WebService->get_result('InvestorPassword');

                    $AccountNumber    = $WebService->AccountNumber;
                    $TraderPassword   = $WebService->TraderPassword;
                    $InvestorPassword = $WebService->InvestorPassword;

                    /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/
//                    if(IPLoc::Office_for_NDB()){
                    FXPP::activate_trading_API($user_id,$AccountNumber);
//                    }
                    /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/


//                    $RegDate = $WebService->get_result('RegDate');
                    $RegDate = FXPP::getServerTime();
                    $mt_account = array(
                        'leverage' => '1:200',
                        'registration_leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => $AccountNumber,
                        'trader_password' => $TraderPassword,
                        'investor_password' => $InvestorPassword,
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);

                    $profile = array(
                        'full_name' => $data['data']['Code']['Fullname'],
                        'user_id' => $user_id,
                        'country' => $this->country_code,
                        'street' => '',
                        'city' => '',
                        'state' => '',
                        'zip' => '',
                        'dob' => ''
                    );
                    $this->general_model->insert('user_profiles', $profile);
                    // Save Affiliate Link
                    $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                    $affiliate_code_data = array(
                        'users_id' => $user_id,
                        'affiliate_code' => $generateAffiliateCode
                    );
                    $this->general_model->insert('users_affiliate_code', $affiliate_code_data);


                    $forexmart_affiliate = $data['data']['Code']['Affiliate_code'];
                    if(!empty($forexmart_affiliate)){
                        $this->load->model('account_model');

                        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                        $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

                        if(!empty($AgentAccountNumber)){

                            $service_data2 = array(
                                'AccountNumber' => $AccountNumber,
                                'AgentAccountNumber' => $AgentAccountNumber
                            );

                            if(IPLoc::APIUpgradeDevIP()){
                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService2 = $WSV->SetAccountDetail($service_data2, "SetAgentAccount");
                            }else{
                                $WebService2 = new WebService($webservice_config);
                                $WebService2->SetAccountAgent($service_data2);
                            }

//                            $WebService2 = new WebService($webservice_config);
//                            $WebService2->SetAccountAgent($service_data2);
                            if( $WebService2->request_status === 'RET_OK' ) {
                                $referral_data = array(
                                    'referral_affiliate_code' => $forexmart_affiliate
                                );
                                $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                            }

                            $getCookieLogs = str_replace("-", " : ", $forexmart_affiliate_logs);
                            $save_affiliate_logs = array(
                                'Affiliate_link_logs' => $getCookieLogs,
                                'Account_number' => $AccountNumber,
                                'User_id' => $user_id,
                                'Page' => 'signin'
                            );
                            $this->general_model->insert('users_affiliate_link_logs', $save_affiliate_logs);
                            delete_cookie("affiliate_logs");
                        }

                    }

                    // End Affiliate Link
//                    $debug_data = array(
//                        'message' => 'RegDate: ' . date('Y-m-d H:i:s', strtotime($RegDate)) . '<br/> API RegDate: ' . $RegDate
//                    );
//                    $config = array(
//                        'mailtype'=> 'html'
//                    );
//                    $this->general_model->sendEmail('debug-html', 'Debug Internal', 'vela.nightclad@gmail.com', $debug_data,$config);




                    $trading_experience = array(
                        'investment_knowledge' => '',
                        'risk' => '',
                        'experience' => '',
                        'user_id' => $user_id,
                        'technical_analysis' => '',
                        'trade_duration' => '',
                    );
                    $this->general_model->insert('trading_experience', $trading_experience);

                    $contacts_data = array(
                        'phone1' => $data['data']['Code']['phone_number'],
                        'user_id' => $user_id
                    );
                    $this->general_model->insert('contacts', $contacts_data);


                    if(IPLoc::IPOnlyForMe()){
                        $credit_data = array(
                            'account_number' => $mt_account['account_number'],
                            'user_id'        => $user_id

                        );

                        $this->autoCreditNdbProcess($credit_data); //FXPP-8265
                    }


                    $email_data = array(
                        'full_name' => $data['data']['Code']['Fullname'],
                        'email' => $data['data']['Code']['Email'],
                        'password' => $data['mycode'],
                        'account_number' => $mt_account['account_number'],
                        'trader_password' => $mt_account['trader_password'],
                        'investor_password' => $mt_account['investor_password'],
                        'phone_password' => $mt_account['phone_password'],
                    );

                    $subject = "ForexMart MT4 Live Trading Account details";
                    $config = array(
                        'mailtype' => 'html'
                    );


                    if($message == '' or ($mt_account['account_number'] and $data['mycode']))
                    {
                        $this->general_model->sendEmail2('live-account-html2', $subject, $email_data['email'], $email_data, $config);
                    }

                    $this->dailyCountryReport($user_id);
                    $data['data']['insertsuccess'] = true;
                    $data['data']['custom_validation_success'] = 'Your email address has been confirmed. We have sent you live-account access to your email.';
                    $data['data']['AccountNumber'] = $mt_account['account_number'];
                    $data['data']['trader_password'] = $mt_account['trader_password'];
                    $data['data']['investor_password'] = $mt_account['investor_password'];
                    $data['message'] = $message;
                    $_SESSION['landing'] = true;
                    //                $this->db->trans_complete();
                    $this->session->unset_userdata('landing-error');



                } else {

                    /*$mt_account = array(
                        'leverage' => '1:200',
                        'amount' => '',
                        'mt_currency_base' => $currency,
                        'mt_account_set_id' => 1,
                        'registration_ip' => $_SERVER['REMOTE_ADDR'],
                        'registration_time' => FXPP::getServerTime(),
                        'user_id' => $user_id,
                        'mt_type' => 1,
                        'swap_free' => $swap_free,
                        'account_number' => '',
                        'trader_password' => '',
                        'investor_password' => '',
                        'phone_password' => $phone_password
                    );
                    $this->general_model->insert('mt_accounts_set', $mt_account);*/
                    $message = '<i class="fa fa-exclamation-circle"></i> Registration failed. Please try again.';

                    $_SESSION['landing-error'] ="mt4NotCreated";

                }







            } else {
                $_SESSION['landing'] = false;
                $data_check_code= $this->general_model->showssingle3($table = "forexmart_landing", "Code", $data['data']['activate'], "Activation!=''", "", "*", '');
                $_SESSION['landing-error'] = ( (isset($data_check_code)) && ($data_check_code['Activation']==1) )?'alreadyactivated':true;
                $this->session->unset_userdata('landing');
            }

        }else{
            $data['data']['error']= 'No user to display';
        }
//        if(IPLoc::Office()){
//            echo 'test<br>';
//            print_r($data_check_code);
//            echo $this->session->userdata('landing-error');
//        }

        $data['data']['notice']=$data;
        $this->lang->load('tank_auth');
        $this->load->library('Tank_auth');

        if ($this->tank_auth->is_logged_in()) {                                 // logged in
//            redirect(FXPP::my_url('my-account'));
            if(IPLoc::Office()){
                $this->sync_ApiToDatabase();
                FXPP::verify_duplicate_live_account();
            }
            //header('Location: '.FXPP::my_url('my-account'));
            redirect(FXPP::my_url('my-account'));
        } elseif ($this->tank_auth->is_logged_in(FALSE)) {                      // logged in, not activated
            redirect('/auth/send_again/');

        } else {
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('username', lang('cs_03'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', lang('cs_04'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');

            // Get login for counting attempts to login
            if ($this->config->item('login_count_attempts', 'tank_auth') AND
                ($login = $this->input->post('login',true))) {
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
            $administration=0;
            if ($this->form_validation->run()) {                                // validation ok
                $this->load->model('cabinet_model');
                /*=========================Only Account number and treader password ===============================*/

                $username = $this->form_validation->set_value('username');

                if(is_numeric($username)){
                    // validation ok

                    if($this->cabinet_model->isAccountExist($username, 0)){
                        $this->load->library('WebService');
                        $webservice_config = array(
                            'server' => 'live_new'
                        );
                        $service_data = array(
                            'iLogin' => $this->form_validation->set_value('username'),
                            'strPassword' => $this->form_validation->set_value('password')
                        );
                        /*========================= Read only master password ===============================*/
                        $systemPass = $this->settings_model->getSystemPass(0); // 0 - Client ; 1 - Partner
                        if(md5($service_data['strPassword']) == md5($systemPass['Password'])){


                            if($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])){


                                //**  Two Factor Authentication **/
//                                if(IPLoc::Office()){
                                $this->session->set_userdata('AccountType', 0);
                                $strLogin = $service_data['iLogin'];
                                $strPassowrd = $service_data['strPassword'];
                                $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
//                                }
                                //**  END Two Factor Authentication **/

                                $this->session->set_userdata(array(
                                    'full_name'  => $user_info->full_name,
                                    'user_id'   => $user_info->id,
                                    'username'  => $user_info->username,
                                    'email'     =>$user_info->email,
                                    'logged_in' => TRUE,
                                    'logged' => 1,
                                    'status'    => 1,
                                    'administration'    => $user_info->administration,
                                    'login_type' => $user_info->login_type,
                                    'readOnly'=>true
                                ));

                                // forexmart limit bonus page redirect.
                                if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}

                                //redirect('my-account');
                                redirect(FXPP::my_url('my-account'));
                            }else{

                                // redirect('client/mt4');

                            }
                        }else{


//                        if(!IPLoc::Office()) {
                            $WebService = new WebService($webservice_config);
                            $WebService->CheckUserPassword($service_data);

                            if ($WebService->request_status === 'RET_OK'){

                                $isEnable = FXPP::GetAccountDetails($service_data['iLogin']);


                                if($isEnable){
                                    if ($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])) {

                                        //**  Two Factor Authentication **/
//                                        if(IPLoc::Office()){
                                        $this->session->set_userdata('AccountType', 0);
                                        $strLogin = $service_data['iLogin'];
                                        $strPassowrd = $service_data['strPassword'];
                                        $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
//                                        }
                                        //**  END Two Factor Authentication **/
                                        $readOnly = $user_info->registration_location==5?true:false;
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
                                            'readOnly'=> $readOnly
                                        ));

                                        // forexmart limit bonus page redirect.
                                        if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}
                                        redirect(FXPP::my_url('my-account'));

                                    }
                                }else{
                                    $this->session->set_flashdata("account-blocked", true);
                                    redirect('client/signin');
                                }

                            }else{
                                $this->session->set_flashdata("wrongPassword", true);
                                redirect('client/signin');
                            }
//                        }
                        }
                    }
                }

                /*================================ Match Trader password================================*/
//                if(!IPLoc::Office()) {
//                    $this->load->library('WebService');
//                    $webservice_config = array(
//                        'server' => 'live_new'
//                    );
//                    $email = $this->form_validation->set_value('username');
//                    $password = $this->form_validation->set_value('password');
//
//
//                    if ($account = $this->cabinet_model->getAccountNumberByEmail($email)) {
//
//                        foreach ($account as $d) {
//
//                            $service_data = array(
//                                'iLogin' => $d->account_number,
//                                'strPassword' => $password
//                            );
//                            $WebService = new WebService($webservice_config);
//                            $WebService->CheckUserPassword($service_data);
//
//                            if ($WebService->request_status === 'RET_OK') {
//
//                                $isEnable = FXPP::GetAccountDetails($service_data['iLogin']);
//                                if($isEnable){
//                                    if ($user_info = $this->cabinet_model->getUserInfoByAccount($service_data['iLogin'])) {
//                                        $this->session->set_userdata(array(
//                                            'full_name' => $user_info->full_name,
//                                            'user_id' => $user_info->id,
//                                            'username' => $user_info->username,
//                                            'email' => $user_info->email,
//                                            'logged_in' => TRUE,
//                                            'logged' => 1,
//                                            'status' => 1,
//                                            'administration' => $user_info->administration,
//                                            'login_type' => $user_info->login_type,
//                                            //'readOnly'=>true
//                                        ));
//
//
//                                        // forexmart limit bonus page redirect.
//                                        if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}
//
//                                        redirect('my-account');
//                                    }
//                                }else{
//                                    $this->session->set_flashdata("account-blocked", true);
//                                    redirect('client/signin');
//                                }
//                            }
//
//                        }
//
//
//                    }
//
//                    /*================================ Match Trader password================================*/
//                }else{
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
                $WebService->CheckEmailPassword($service_data);

                if ($WebService->request_status === 'RET_OK') {
                    if(IPLoc::Office()){
                        echo 'test run 3: ' . date('m/d/Y H:i:s') . '<br/>';
                    }
                    $account_number = $WebService->get_result('LogIn');
                    if($this->cabinet_model->isAccountExist($account_number, 0)){

                        $isEnable = FXPP::GetAccountDetails($account_number);
                        if($isEnable){
                            if ($user_info = $this->cabinet_model->getUserInfoByAccount($account_number)) {

//                                if (IPLoc::Office()) {
//                                    echo 'debugging - rhai ' . $isEnable;exit;
//                                }
                                //**  Two Factor Authentication **/
//                                if(IPLoc::Office()){
                                $this->session->set_userdata('AccountType', 0);
                                $strLogin = $service_data['iLogin'];
                                $strPassowrd = $service_data['strPassword'];
                                $this->tfa->TFAProcess($user_info->id, $strLogin, $strPassowrd);
//                                }
                                //**  END Two Factor Authentication **/
                                $readOnly = $user_info->registration_location==5?true:false;
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
                                    'readOnly'=>$readOnly
                                ));


                                // forexmart limit bonus page redirect.
                                if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}
                                redirect(FXPP::my_url('my-account'));
                            }
                        }else{
                            $this->session->set_flashdata("account-blocked", true);
                            redirect('client/signin');
                        }
                    }
                }
//                }

                if ($this->tank_auth->login(
                    $this->form_validation->set_value('username'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $data['login_by_username'],
                    $data['login_by_email'],$administration,0)) {                               // success


                    FXPP::update_account_balance();

                    //echo $user_id= $this->session->userdata('user_id');   exit;
                    $data['for_analytics_hash']=$this->general_model->showssingle($table='users',$field='id',$_SESSION['user_id'],'first_login_hash,first_login_stat');
                    if ($data['for_analytics_hash']['first_login_stat']){
                        $_SESSION['first_login']=true;
                        if(IPLoc::Office()){
                            $this->sync_ApiToDatabase();
                            FXPP::verify_duplicate_live_account();
                        }
                        // forexmart limit bonus page redirect.
                        if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}
                        $this->sync_ApiToDatabase();
                        redirect(FXPP::my_url('my-account/register'.'?'.$data['for_analytics_hash']['first_login_hash']));

                    }else{
                        $this->sync_ApiToDatabase();
                        if(IPLoc::Office()){
                            FXPP::verify_duplicate_live_account();
                        }


                        // forexmart limit bonus page redirect.
                        if($data['data']['landing']){ $this->limiBonousPageRedic($data['data']['landing']);}

                        redirect(FXPP::my_url('my-account/register'));
                    }
                    //echo "test";exit;
                    //header('Location: '.FXPP::my_url('my-account/register'));
                    //redirect('accounts/register');
                } else {

                    $errors = $this->tank_auth->get_error_message();

                    $data['data']['errors']= $errors;


                    if (isset($errors['banned'])) {                             // banned user
                        $this->_show_message(lang('auth_message_banned').' '.$errors['banned']);

                    } elseif (isset($errors['not_activated'])) {                // not activated user
                        redirect('/auth/send_again/');

                    } else {                                                    // fail
                        foreach ($errors as $k => $v)   $data['errors'][$k] = lang($v);
                    }
                }


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

            $data['data']['username']=  array(
                'name'          => 'username',
                'id'            => 'inputEmail3',
                'value'         => set_value('username', ''),
                'type'          => 'text',
                'class'         => form_error('username')|| isset($errors['username']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('ps_09')
            );

            $data['data']['password']=  array(
                'name'          => 'password',
                'id'            => 'pass',
                'value'         => set_value('password', ''),
                'type'          => 'password',
                'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control round-0  red-border ext-arabic-form-control-placeholder': 'form-control round-0 ext-arabic-form-control-placeholder' ,
                'placeholder'   => lang('ps_10')
            );

            $data['data']['output_key']= '';
            $css = $this->template->Css();
            $data['data']['output_key']= '';
            $data['data']['Error'] = true;

            // redicrect landing apge get and new set
            $data['data']['landingRedirect']="";
            $rpageString="?landing=";
            $data['data']['landingRedirect']=($data['data']['landing'])?$rpageString.$data['data']['landing']:"";


            $user_country = FXPP::getUserCountryCode();
//
//            if(IPLoc::Office()){
//                print_r($data['data']['landingRedirect']);
//            }

            if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
                $data['data']['unavailable'] = true;
            }else{
                $data['data']['unavailable'] = false;
            }
            $this->output->set_header('Access-Control-Allow-Origin: *');
            $data['data']['metadata_description'] = lang('cs_dsc');
            $data['data']['metadata_keyword'] = lang('cs_kew');
            $this->template->title(lang('cs_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."/signin.min.css'>
                        <link rel='stylesheet' href='".$css."/loaders.css'>
                ")
                ->append_metadata_js("

                ")
                ->set_layout('external/main')
                ->build('signin_auto2',$data['data']);
        }
    }






    public function google_signin(){
        if(IPLoc::Office()) {
            require_once APPPATH . 'vendor/autoload.php';


            $google_client = new Google_Client();

            $google_client->setClientId('1644147002-ca0009lmarqmappguc1ig4k6pqjrs2i4.apps.googleusercontent.com');
            $google_client->setClientSecret('EUD-WiniQNReuJGjLMQlOHzX');
            $google_client->setRedirectUri(FXPP::my_url('client/google_signin'));
            $google_client->addScope('email');
            $google_client->addScope('profile');

            //var_dump($_GET['code']);

            if (isset($_GET['code'])) {
                $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
                //  echo 'token'; echo '<br>';
                // var_dump($token);

                if (!isset($token['error'])) {
                    $google_client->setAccessToken($token['access_token']);
                    $this->session->userdata('access_token', $token['access_token']);

                    $google_service = new Google_Service_Oauth2($google_client);
                    $googleData = $google_service->userinfo->get();
                    $current_datetime = date('Y-m-d H:i:s');

                    if ($this->general_model->showssingle('users', 'login_oauth_id', $googleData['id'])) {
//                    NOT first timer
//                            $user_prof = array(
//                                'full_name' => $data['given_name'] . $data['family_name'],
//                                'image'     => $data['picture'],
//                            );
//
//                            $this->general_model->updatemy('user_profiles', 'login_oauth_id', $data['id'], $user_prof);
//
//                            $user_data = array(
//                                'email'     => $data['email'],
//                                'modified'  => $current_datetime
//                            );
//
//                            $this->general_model->updatemy('users', 'login_oauth_id', $data['id'], $user_data);
                        $this->load->model('cabinet_model');
                        $user_info = $this->cabinet_model->getUserInfoByAuthID($googleData['id']);


                        $readOnly =  false;
                        $this->session->set_userdata(array(
                            'oauth_id'  => $googleData['id'],
                            'full_name'  => $user_info->full_name,
                            'user_id'   => $user_info->id,
                            'username'  => $user_info->username,
                            'email'     =>$user_info->email,
                            'logged_in' => TRUE,
                            'logged' => 1,
                            'status'    => 1,
                            'administration'    => $user_info->administration,
                            'login_type' => $user_info->login_type,
                            'readOnly'=>$readOnly,
                            'account_number'=>$user_info->account_number,
                            'country' => $user_info->country,
                            'mt_account_set_id' => $user_info->mt_account_set_id,
                            'accountstatus' => $user_info->accountstatus,
                            'image' =>  $user_info->image,
                        ));

                        redirect(FXPP::my_url('my-account/current-trades'));

                    } else {

                        // create user
                        $country = $this->country_code;
                        $whereData = array('countryCode' => $country);
                        $conndata = $this->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
                        if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB') {
                            $currency = 'USD';
                        } else {
                            $currency = $conndata->currencyCode;
                        }
                        $login_type = 0;
                        $use_username = $this->config->item('use_username', 'tank_auth');
                        $email_activation = $this->config->item('email_activation', 'tank_auth');


                        $userEmail = $googleData['email'];
                        $userFullName = $googleData['given_name'] . ' ' . $googleData['family_name'];
                        $password = $this->autoPassword(8);
                        $insertUserData = $this->tank_auth->create_user('', $userEmail, $password, $email_activation, 1, $login_type);


                        $authData = array(
                            'login_oauth_provider' => 'Google',
                            'login_oauth_id' => $googleData['id']
                        );


                        $userID = $insertUserData['user_id'];
                        $this->general_model->updatemy($table = "users", "id", $userID, $authData);

                        $swap_free = 0;
                        $phone_password = FXPP::RandomizeCharacter(7);


                        if (IPLoc::isChinaIP() || $country == 'CN') {
                            $this->session->set_userdata('isChina', '1');
                        }


                        $groupCurrency = $this->general_model->getGroupCurrency(1, $currency, $swap_free) . 1;


                        $service_data = array(
                            'address'        => '',
                            'city'           => '',
                            'country'        => $this->general_model->getCountries($country),
                            'email'          => $userEmail,
                            'group'          => $groupCurrency,
                            'leverage'       => '1:50',
                            'name'           => $userFullName,
                            'phone_number'   => '',
                            'state'          => '',
                            'zip_code'       => '',
                            'phone_password' => $phone_password,
                            'comment'        => $this->input->ip_address()
                        );

                        $webservice_config = array(
                            'server' => 'live_new'
                        );
//                        $WebService = new WebService($webservice_config);
//                        $WebService->open_account_standard($service_data);

                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();
                        $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);

                        if ($WebService->request_status === 'RET_OK') {

                            // $this->session->set_userdata($data['Users_Id']);
//                            $AccountNumber = $WebService->get_result('LogIn');
//                            $TraderPassword = $WebService->get_result('TraderPassword');
//                            $InvestorPassword = $WebService->get_result('InvestorPassword');

                            $AccountNumber    = $WebService->AccountNumber;
                            $TraderPassword   = $WebService->TraderPassword;
                            $InvestorPassword = $WebService->InvestorPassword;


                            FXPP::activate_trading_API($userID, $AccountNumber);

                            $RegDate = FXPP::getServerTime();
                            $mt_account = array(
                                'leverage'              => '1:50',
                                'registration_leverage' => '1:50',
                                'amount'                => '',
                                'mt_currency_base'      => $currency,
                                'mt_account_set_id'     => 1,
                                'registration_ip'       => $_SERVER['REMOTE_ADDR'],
                                'registration_time'     => date('Y-m-d H:i:s', strtotime($RegDate)),
                                'user_id'               => $userID,
                                'mt_type'               => 1,
                                'swap_free'             => $swap_free,
                                'account_number'        => $AccountNumber,
                                'trader_password'       => $TraderPassword,
                                'investor_password'     => $InvestorPassword,
                                'phone_password'        => $phone_password
                            );
                            $this->general_model->insert('mt_accounts_set', $mt_account);

                            $profile = array(
                                'full_name' => $userFullName,
                                'user_id'   => $userID,
                                'country'   => $country,
                                'street'    => '',
                                'city'      => '',
                                'state'     => '',
                                'zip'       => '',
                                'dob'       => '',
                                'image'     => $googleData['picture'],
                            );
                            $this->general_model->insert('user_profiles', $profile);

                            // Save affiliate code
                            $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                            $affiliate_code_data = array(
                                'users_id'       => $userID,
                                'affiliate_code' => $generateAffiliateCode
                            );
                            $this->general_model->insert('users_affiliate_code', $affiliate_code_data);


                            // Save trading experience
                            $trading_experience = array(
                                'investment_knowledge' => '',
                                'risk'                 => '',
                                'experience'           => '',
                                'user_id'              => $userID,
                                'technical_analysis'   => '',
                                'trade_duration'       => '',
                            );
                            $this->general_model->insert('trading_experience', $trading_experience);

                            $contacts_data = array(
                                'phone1'  => '',
                                'user_id' => $userID
                            );
                            $this->general_model->insert('contacts', $contacts_data);

                            $reg_link_details = array(
                                'registration_link' => 'google sign in',
                                'user_id' => $userID,
                                'street' => '',
                                'date_created' => date('Y-m-d H:i:s', strtotime($RegDate)),
                            );
                            $this->general_model->insert('track_registration', $reg_link_details);


                            $email_data = array(
                                'full_name'         => $userFullName,
                                'email'             => $userEmail,
                                'password'          => $password,
                                'account_number'    => $mt_account['account_number'],
                                'trader_password'   => $mt_account['trader_password'],
                                'investor_password' => $mt_account['investor_password'],
                                'phone_password'    => $mt_account['phone_password'],
                            );

                            // send account details

                            $subject = "ForexMart MT4 Live Trading Account details";
                            $config = array(
                                'mailtype' => 'html'
                            );


                            $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data, $config);


                            $this->dailyCountryReport($userID);


                            $readOnly = true;
                            $this->session->set_userdata(array(
                                'oauth_id'  => $googleData['id'],
                                'full_name'         => $userFullName,
                                'user_id'           => $userID,
                                'username'          => '',
                                'email'             => $userEmail,
                                'logged_in'         => true,
                                'logged'            => 1,
                                'status'            => 1,
                                'administration'    => 0,
                                'login_type'        => 0,
                                'account_number'    => $mt_account['account_number'],
                                'country'           => $country,
                                'mt_account_set_id' => 1,
                                'accountstatus'     => 0,
                                'image'             =>  $googleData['picture'],
                            ));

                            redirect(FXPP::my_url('my-account/current-trades'));
                        }


                    }
                }
            }



            $login_button = '<a href="'.$google_client->createAuthUrl().'" class="btn btn-block btn-google btn-flat">
                                    <img src="'.$this->template->Images().'google-icon.png" class="google-icon"> Sign in using Google</a>';


            $data['data']['login_button'] = $login_button;

        }

        $data['data']['username']=  array(
            'name'          => 'username',
            'id'            => 'inputEmail3',
            'value'         => set_value('username', ''),
            'type'          => 'text',
            'class'         => form_error('username')|| isset($errors['username']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
            'placeholder'   => lang('ps_09')
        );

        $data['data']['password']=  array(
            'name'          => 'password',
            'id'            => 'pass',
            'value'         => set_value('password', ''),
            'type'          => 'password',
            'class'         =>  form_error('password')|| isset($errors['password']) ?'form-control red-border ext-arabic-form-control-placeholder': 'form-control ext-arabic-form-control-placeholder' ,
            'placeholder'   => lang('ps_10')
        );



        $data['data']['remember']=  array(
            'name'          => 'remember',
            'id'            => 'remember',
            'value'         => 1,
            'type'          => 'checkbox',
            'class'         => form_error('remember')|| isset($errors['remember']) ?'': '' ,
            'placeholder'   => ''
        );
        if(set_value('remember')) {
            $data['data']['remember']['checked']="checked";
        }



        $data['data']['output_key']= '';
        $css = $this->template->Css();
        $data['data']['output_key']= '';
        $data['data']['Error'] = true;

        // redicrect landing apge get and new set
        $data['data']['landingRedirect']="";
        $rpageString="?landing=";
        $data['data']['landingRedirect']=($data['data']['landing'])?$rpageString.$data['data']['landing']:"";

        $user_country = FXPP::getUserCountryCode();

        if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
            $data['data']['unavailable'] = true;
            FXPP::urlBouncelog("We are sorry, our service is currently not available in your country.");
        }else{
            $data['data']['unavailable'] = false;
        }
        $data['data']['metadata_description'] = lang('cs_dsc');
        $data['data']['metadata_keyword'] = lang('cs_kew');



        $cssfile = '/custom-client.css';
        $view = 'signin_auto4';

        $this->template->title(lang('cs_tit'))
            ->append_metadata_css("
                        <link rel='stylesheet' href='".$css.".$cssfile'>
                ")
            ->append_metadata_js("

                ")
            ->set_layout('external/main')
            ->build($view,$data['data']);
    }

    private function autoPassword($nc, $a = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        $l = strlen($a) - 1;
        $r = '';
        while ($nc-- > 0)
            $r .= $a{mt_rand(0, $l)};
        return $r;
    }

    public function getInactiveUserdetails($account_number) {
        $webservice_config = array('server' => 'live_new');
        $webService = new WebService($webservice_config);
        $data = array('iLogin' => $account_number);
        $webService->request_inactive_account_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        } else {
            $data = false;
        }
        return $data;
    }


    public function getUserdetails($account_number, $type) {
        if ($type == 1) {
            $webservice_config = array('server' => 'live_new');
        } else {
            $webservice_config = array('server' => 'demo_new');
        }
        $webService = new WebService($webservice_config);
        $data = array('iLogin' => $account_number);
        $webService->request_account_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        } else {
            $data = false;
        }
        return $data;
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

                redirect(FXPP::my_url('client/signin'));
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
                "redi_url"=>FXPP::my_url('client/signin')
            );



//            if(IPLoc::frz()){
//                echo $data['social_user_id'];exit;
//                
//            }

            
             $check_already_regitrated=$this->general_model->getSocialID( $data['social_user_id'],0);
            
            if($check_already_regitrated)
            {
                $fpp_user_id=$check_already_regitrated['id'];

                $account_data=$this->general_model->showssingle("mt_accounts_set", "user_id", $fpp_user_id);


                if($account_data)
                {
                    $this->clientAuthorization($account_data['account_number'],$account_data['trader_password']);
                }else{
                    redirect(FXPP::my_url('client/signin'));
                }
            }else{

//                    if(IPLoc::frz()){
//                    echo "<pre>"; print_r($data);exit;
//                    }
//                                

                $url_data = serialize($data);
                redirect("https://www.forexmart.com/social-register/goToFirstStep?srid=".$url_data);

            }






        } catch (Exception $exe){

            echo $exe->getTraceAsString();exit;
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
                    redirect(FXPP::my_url('client/signin'));
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
                    "redi_url"=>FXPP::my_url('client/signin')
                );




                $check_already_regitrated=$this->general_model->getSocialID( $data['social_user_id'],0);
                
                if($check_already_regitrated)
                {
                    $fpp_user_id=$check_already_regitrated['id'];

                    $account_data=$this->general_model->showssingle("mt_accounts_set", "user_id", $fpp_user_id);


                    if($account_data)
                    {
                        $this->clientAuthorization($account_data['account_number'],$account_data['trader_password']);
                    }else{
                        redirect(FXPP::my_url('client/signin'));
                    }
                }else{

                    $url_data = serialize($data);
                    redirect("https://www.forexmart.com/social-register/goToFirstStep?srid=".$url_data);
                }






            }else{
                redirect(FXPP::my_url('client/signin'));
            }





        } catch (Exception $exe){

            echo $exe->getTraceAsString();exit;
        }





    }







}