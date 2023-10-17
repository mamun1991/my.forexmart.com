<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MY_Controller {

    private $country_code;
    private $allow_register = true;
    private $user_country;

    public function __construct() {
        parent::__construct();
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('user_model');
        $this->load->model('General_model');
        $this->load->model('withdraw_model');
        $this->lang->load('myaccount');
        $this->lang->load('myprofile');
        $this->lang->load('registration');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->g_m = $this->General_model;
        $isPartner = $this->session->userdata('login_type');
        if ($isPartner == 1) {
            $this->isPartner = true;
        }
        $this->user_country = FXPP::getUserCountryCode();
        $this->country_code = FXPP::getUserCountryCode() or null;
    }

    public function live(){


        set_time_limit(3000);
        @ini_set('max_execution_time', 3000);

        if (isset($_SESSION['redirect'])) {redirect($_SESSION['redirect']);}
        if ($this->session->userdata('logged')) {
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
//            $this->session->set_userdata(array('email_live' => $this->session->userdata('email'), 'full_name_live' => $this->session->userdata('full_name')));
//            $user_details_emailname = $this->user_model->getFirstUserDetailsByEmailAndNamev2($this->session->userdata('email'), $this->session->userdata('full_name'));
//            $trading_experience = explode(',', $user_details_emailname['experience']);
//            $trading_experience_value = array();
//            if (count($trading_experience) > 2) {
//                foreach ($trading_experience as $experience) {
//                    $trading_experience_value[] = $experience ? true : false;
//                }
//            } else {
//                $trading_experience_value = array(false, false, false);
//            }
//            $user_details['trading_experience_value'] = $trading_experience_value;
//            $data['user_details'] = $user_details;
//            $data['user_details_emailname'] = $user_details_emailname;
//            $data['api_details_emailname'] = $this->getUserdetails($user_details_emailname['account_number']);
//
//            $data['gender'] = $this->general_model->selectOptionList($this->general_model->getGender(), isset($user_details_emailname['gender']) ? $user_details_emailname['gender'] : 'M');
//            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
//            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(), isset($user_details_emailname['employment_status']) ? $user_details_emailname['employment_status'] : 0);
//            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getBusinessNature(), isset($user_details['industry']) ? $user_details_emailname['industry'] : null);
//            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
//            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome2(), isset($user_details_emailname['estimated_annual_income']) ? $user_details_emailname['estimated_annual_income'] : 3);
//            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth2(), isset($user_details_emailname['estimated_net_worth']) ? $user_details_emailname['estimated_net_worth'] : 3);
//            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), isset($user_details_emailname['investment_knowledge']) ? $user_details_emailname['investment_knowledge'] : 1);
//            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel2(), isset($user_details_emailname['education_level']) ? $user_details_emailname['education_level'] : null);
//            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), isset($user_details_emailname['trade_duration']) ? $user_details_emailname['trade_duration'] : null);
//            $data['postal_code'] = FXPP::getVisitorInfo()->postal_code;
//            $data['number_of_trades'] = $this->general_model->selectOptionList($this->general_model->getNumberMonthlyConnectedTradedAnswer(), isset($user_details_emailname['number_of_trades']) ? $user_details_emailname['number_of_trades'] : null);
//
//            $data['cfd_equity_stop_out_level'] = $this->general_model->selectOptionList($this->general_model->getCFDPositionStopOutLevelAnswer(), isset($user_details_emailname['cfd_equity_stop_out_level']) ? $user_details_emailname['cfd_equity_stop_out_level'] : null);
//            $data['cfd_higher_leverage'] = $this->general_model->selectOptionList($this->general_model->getCFDTradingWithHigherLeverageAnswer(), isset($user_details_emailname['cfd_higher_leverage']) ? $user_details_emailname['cfd_higher_leverage'] : null);
//            $data['stop_out_level_50'] = $this->general_model->selectOptionList($this->general_model->getStopOutLevel50PercentAnswer(), isset($user_details_emailname['stop_out_level_50']) ? $user_details_emailname['stop_out_level_50'] : null);
//
//            $user_aff_code = $this->account_model->getUserReferralCode($this->session->userdata('user_id'));
//            $data['aff_code'] = $user_aff_code['referral_affiliate_code'];
//
//            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
//            $user_country = FXPP::getUserCountryCode();
//            if (in_array(strtoupper($user_country), array('PL'))) {
//                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details_emailname['leverage'] != "") ? $user_details_emailname['leverage'] : "1:50");
//            } else {
//                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(), ($user_details_emailname['leverage'] != "") ? $user_details_emailname['leverage'] : "1:50");
//            }
//            if ($_SESSION['temp_country'] == "PL") {
//                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details_emailname['leverage'] != "") ? $user_details_emailname['leverage'] : "1:50");
//            }
//            if (isset($_SESSION['ru_ctm_links'])) {
//                switch ($_SESSION['ru_ctm_links']) {
//                    case 'ru_posting':
//                        $data['account_currency_base'] = $this->general_model->selectOptionList(array('RUB' => 'RUR'), "RUR"); // modified
//                        break;
//                }
//            } else {
//                $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase_v2(), isset($user_details_emailname['mt_currency_base']) ? $user_details_emailname['mt_currency_base'] : "USD");
//            }
//            if (isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $_SESSION['isMicro'] == '1' || $this->input->post('mt_account_set_id', true) == '4') {
//                $data['account_type'] = $this->general_model->selectOptionList(array('4' => 'Forexmart Micro Account'), '4');
//                $data['account_currency_base'] = $this->general_model->selectOptionList(array('USD' => 'USD', 'EUR' => 'EUR'), "USD");
//                $data['micro'] = 1;
//                unset($_SESSION['isMicro']);
//            }
//
//            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries(), isset($user_details_emailname['country']) ? $user_details_emailname['country'] : $this->country_code);
//            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType(), isset($user_details_emailname['mt_account_set_id']) ? $user_details_emailname['mt_account_set_id'] : 1);


            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('register_live4', $data);
        }else {
            if ($_GET['login'] == 'partner') {
                redirect('partner/signin');
            }
            redirect('signout');
        }

        }

    public function index_new()
    {
        set_time_limit(3000);
        @ini_set('max_execution_time', 3000);

        if (isset($_SESSION['redirect'])) {redirect($_SESSION['redirect']);}
        if ($this->session->userdata('logged')) {
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->session->set_userdata(   array('email_live'=>$this->session->userdata('email'),'full_name_live'=>$this->session->userdata('full_name')) );
            $user_details_emailname = $this->user_model->getFirstUserDetailsByEmailAndNamev2($this->session->userdata('email'),$this->session->userdata('full_name') );
            $trading_experience = explode(',', $user_details_emailname['experience']);
            $trading_experience_value = array();
            if (count($trading_experience) > 2) {
                foreach ($trading_experience as $experience) {
                    $trading_experience_value[] = $experience?true:false;
                }
            } else {
                $trading_experience_value = array(false, false, false);
            }
            $user_details['trading_experience_value'] = $trading_experience_value;
            $data['user_details'] = $user_details;

            $data['user_details_emailname'] =  $user_details_emailname;
//            echo '<pre>';
//            print_r($user_details_emailname);
//            exit;
            $data['api_details_emailname'] = $this->getUserdetails($user_details_emailname['account_number']);

            $data['gender'] = $this->general_model->selectOptionList($this->general_model->getGender(),isset($user_details_emailname['gender']) ? $user_details_emailname['gender'] : 'M');
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(), isset($user_details_emailname['employment_status']) ? $user_details_emailname['employment_status'] : 0);
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getBusinessNature(), isset($user_details['industry']) ? $user_details_emailname['industry'] : null);
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome2(), isset($user_details_emailname['estimated_annual_income']) ? $user_details_emailname['estimated_annual_income'] : 3);
            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth2(), isset($user_details_emailname['estimated_net_worth']) ? $user_details_emailname['estimated_net_worth'] : 3);
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), isset($user_details_emailname['investment_knowledge']) ? $user_details_emailname['investment_knowledge'] : 1);
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel2(), isset($user_details_emailname['education_level']) ? $user_details_emailname['education_level'] : null);
            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), isset($user_details_emailname['trade_duration']) ? $user_details_emailname['trade_duration'] : null);
            $data['postal_code'] = FXPP::getVisitorInfo()->postal_code;
            $data['number_of_trades'] = $this->general_model->selectOptionList($this->general_model->getNumberMonthlyConnectedTradedAnswer(), isset($user_details_emailname['number_of_trades']) ? $user_details_emailname['number_of_trades'] : null);

            $data['cfd_equity_stop_out_level'] = $this->general_model->selectOptionList($this->general_model->getCFDPositionStopOutLevelAnswer(), isset($user_details_emailname['cfd_equity_stop_out_level']) ? $user_details_emailname['cfd_equity_stop_out_level'] : null);
            $data['cfd_higher_leverage'] = $this->general_model->selectOptionList($this->general_model->getCFDTradingWithHigherLeverageAnswer(), isset($user_details_emailname['cfd_higher_leverage']) ? $user_details_emailname['cfd_higher_leverage'] : null);
            $data['stop_out_level_50'] = $this->general_model->selectOptionList($this->general_model->getStopOutLevel50PercentAnswer(), isset($user_details_emailname['stop_out_level_50']) ? $user_details_emailname['stop_out_level_50'] : null);

            $user_aff_code = $this->account_model->getUserReferralCode($this->session->userdata('user_id'));
            $data['aff_code'] = $user_aff_code['referral_affiliate_code'];

            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
            $user_country = FXPP::getUserCountryCode();
            if (in_array(strtoupper($user_country), array('PL'))) {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details_emailname['leverage']!="")?$user_details_emailname['leverage'] : "1:50");
            } else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(),($user_details_emailname['leverage']!="")?$user_details_emailname['leverage'] : "1:50");
            }
            if ($_SESSION['temp_country'] == "PL") {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details_emailname['leverage']!="")?$user_details_emailname['leverage'] : "1:50");
            }
            if(isset( $_SESSION['ru_ctm_links'])){
                switch($_SESSION['ru_ctm_links']){
                    case 'ru_posting':
                        $data['account_currency_base'] = $this->general_model->selectOptionList( array('RUB'=>'RUR'),"RUR"); // modified
                        break;
                }
            }else{
                $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase_v2(), isset($user_details_emailname['mt_currency_base']) ? $user_details_emailname['mt_currency_base'] : "USD" );
            }
            if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $_SESSION['isMicro'] =='1' || $this->input->post('mt_account_set_id', true) == '4') {
                $data['account_type'] = $this->general_model->selectOptionList(array('4'=>'Forexmart Micro Account'),'4');
                $data['account_currency_base'] = $this->general_model->selectOptionList(array('USD' => 'USD', 'EUR' => 'EUR'), "USD");
                $data['micro'] = 1;
                unset($_SESSION['isMicro']);
            }

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries(), isset($user_details_emailname['country']) ? $user_details_emailname['country'] : $this->country_code);
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType(), isset($user_details_emailname['mt_account_set_id']) ? $user_details_emailname['mt_account_set_id'] : 1);


            $this->form_validation->set_rules('street', 'Street', 'trim|required|max_length[128]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|max_length[16]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('telephone', 'Telephone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
            $this->form_validation->set_rules('age', 'Age', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

            $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tin', 'Tax Identification Number', 'trim|required');
            $this->form_validation->set_rules('passport', 'Passport', 'trim|required');
            $this->form_validation->set_rules('authority', 'Issuing Authority', 'trim|required');


            if ($this->form_validation->run()){

                $country = $this->input->post('country', true);
                $illicit_country = unserialize(ILLICIT_COUNTRIES);
                if (!in_array(strtoupper(trim($country)), $illicit_country)) {
                    $login_type = 0; //login_type 0 = client user / 1 = partner user
                    $use_username = $this->config->item('use_username', 'tank_auth');
                    $email_activation = $this->config->item('email_activation', 'tank_auth');
                    $password = $this->autoPassword(8);

                    $swap_free = $this->input->post('swap_free', true);
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $phone_password = FXPP::RandomizeCharacter(7);
                    $hidden_input_affiliate_code = $this->input->post('hidden_affiliate_code', true);
                    $getCode  = $this->input->post('affiliate_code', true);
                    $input_affiliate_code = isset($getCode)?$this->checkAffiliateCode_viaURL($getCode)['error']==false?$getCode:'':'';
                    if($country == 'CN'){
                        $this->session->set_userdata('isChina', '1');
                        if(!empty($input_affiliate_code) && !empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($input_affiliate_code) && empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($hidden_input_affiliate_code) && empty($input_affiliate_code) ){
                            $new_aff_code = $hidden_input_affiliate_code;
                        }else{
                            //$new_aff_code = 'EILQY';//FXPP-8533
                            $new_aff_code = ''; //FXPP-12933
                        }
                    }else{
                        if(!empty($input_affiliate_code) && !empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($input_affiliate_code) && empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($hidden_input_affiliate_code) && empty($input_affiliate_code) ){
                            $new_aff_code = $hidden_input_affiliate_code;
                        }else{
                            $new_aff_code = '';
                        }
                        $this->session->set_userdata('isChina', '0');
                    }

                    /*  =============== Spread project  setting ================================ */
                    $speardGroup = $this->input->cookie('forexmart_account_type');  // Here store spread of value using affiliateChecker hook.
                    $mt_set_id =$this->input->post('mt_account_set_id',true);
                    $speardGroup = $mt_set_id==1? "refSt".$speardGroup:"refZe".$speardGroup;

                    if($mt_set_id==1){
                        $speardGroup = "refSt".$speardGroup;
                    }elseif($mt_set_id==2) {
                        $speardGroup = "refZe" . $speardGroup;
                    }

                    if(!$this->general_model->getGroupSpard($speardGroup)){
                        $groupCurrency = $this->general_model->getGroupCurrency((int)$mt_set_id, $this->input->post('mt_currency_base',true), $swap_free).'1';
                    }else{
                        $groupCurrency = $speardGroup;
                    }

                    $input_affiliate_code = $new_aff_code;
                    $affiliate_code_logs = self::getAffiliateLogs($input_affiliate_code);
                    $affiliate_referral_codes = ':' . str_replace('-', ':', $affiliate_code_logs);
                    // webserive registration require data
                    $service_data = array(
                        'address' => $this->input->post('street', true),
                        'city' => $this->input->post('city', true),
                        'country' => $this->general_model->getCountries($this->input->post('country', true)),
                        'email' => $this->session->userdata('email_live'),
                        'group' => $groupCurrency,
                        'leverage' => count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true),
                        'name' => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone', true),
                        'state' => $this->input->post('state', true),
                        'zip_code' => $this->input->post('zip', true),
                        'phone_password' => $phone_password,
                        'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                    );


                    $reg_log_data = $service_data;

                    $webserviceData = $this->webServiceSaveliveAccount($service_data);
                    if($webserviceData['success'])
                    {
                        $user_inser_data = $this->tank_auth->create_user(
                            $use_username ? $this->form_validation->set_value('username') : '',
                            $this->session->userdata('email_live'),
                            $password,
                            $email_activation, 1, $login_type);
                        $user_id = $user_inser_data['user_id'];
                        $user_data = array( 'user_id' => $user_id,);
//                        $this->session->set_userdata($user_data);
                        $data['random_alpha_string_analytics'] = '';
                        $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
                        $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

                        if(IPLoc::Office()){

                            $acc_status = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='accountstatus');
                            if($user_details_emailname['accountstatus'] == 1){
                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 1,
                                    'type' => 1,
                                    'accountstatus' => 1,
                                    'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                                    'registration_location'=>6,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_4',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                            }else{

                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 0,
                                    'type' => 1,
                                    'accountstatus' => 0,
                                    'registration_location'=>6,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_5',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                            }

                        }else{


                            $data['save_hash'] = array(
                                'first_login_hash' => $data['random_alpha_string_analytics'],
                                'first_login_stat' => 1,
                                'auto_verified' => 1,
                                'type' => 1,
                                'accountstatus' => 1,
                                'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                                'registration_location'=>6,
                                "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                "accountstatus_update_location"=>'my_6',
                                "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                            );
                            $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                        }

                        $user_data = array(  'analytic_hash' => $data['random_alpha_string_analytics'], );
//                        $this->session->set_userdata($user_data);
                        $profile = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'user_id' => $user_id,
                            'country' => $this->input->post('country', true),
                            'street' => $this->input->post('street', true),
                            'city' => $this->input->post('city', true),
                            'state' => $this->input->post('state', true),
                            'zip' => $this->input->post('zip', true),
                            'dob' => $this->input->post('dob', true),
                            'dob_back' => $this->input->post('dob', true),
                            'age' => $this->input->post('age', true),
                            'gender' => $this->input->post('gender', true),
                            'tin' =>  $this->input->post('tin', true),
                            'passport_number' => $this->input->post('passport', true),
                            'issuing_authority' => $this->input->post('authority', true),
                        );


                        if ($this->input->post('country', true) == 'PL') {
                            $_SESSION['temp_country'] = 'PL';
                        }
                        $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                        /*  =============== End Spread project  setting ================================ */
                        // track registration link
                        $this->load->helpers('url');
                        $reg_date_cur = FXPP::getServerTime();
                        $reg_link_details = array(
                            'registration_link' => FXPP::my_url('registration/open_live_account'),
                            'user_id' => $user_id,
                            'street' => $this->input->post('street', true),
                            'date_created' => FXPP::getServerTime(),//date('Y-m-d H:i:s', strtotime($reg_date_cur)),
                        );
                        $this->general_model->insert('track_registration', $reg_link_details);

                        // Save Affiliate Link
                        $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                        $affiliate_code_data = array(
                            'users_id' => $user_id,
                            'affiliate_code' => $generateAffiliateCode
                        );
                        $this->general_model->insert('users_affiliate_code', $affiliate_code_data);
                        // mt accounts information with webservice return
                        //$RegDate = FXPP::getServerTime();

                        if(IPLoc::Office()){
                            $mt_account = array(
                                'leverage' => $this->input->post('leverage', true),
                                'registration_leverage' => $this->input->post('leverage', true),
                                'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                                'mt_currency_base' => $this->input->post('mt_currency_base', true),
                                'mt_account_set_id' => $this->input->post('mt_account_set_id', true),
                                'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                'registration_time' => FXPP::getServerTime(),
                                'user_id' => $user_id,
                                'mt_type' => 1,
                                // 'mt_status' => 1,
                                'swap_free' => $swap_free,
                                'account_number' => $webserviceData['AccountNumber'],
                                'trader_password' =>  $webserviceData['TraderPassword'],
                                'investor_password' =>  $webserviceData['InvestorPassword'],
                                'phone_password' => $phone_password,
                                'registry_method'=> $webserviceData['tag'],
                                'group'=>$groupCurrency
                            );
                            if($user_details_emailname['accountstatus'] == 1){
                                $mt_account['mt_status']=1;
                            }

                            $this->general_model->insert('mt_accounts_set', $mt_account);

                        }else{

                            $mt_account = array(
                                'leverage' => $this->input->post('leverage', true),
                                'registration_leverage' => $this->input->post('leverage', true),
                                'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                                'mt_currency_base' => $this->input->post('mt_currency_base', true),
                                'mt_account_set_id' => $this->input->post('mt_account_set_id', true),
                                'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                'registration_time' => FXPP::getServerTime(),
                                'user_id' => $user_id,
                                'mt_type' => 1,
                                'mt_status' => 1,
                                'swap_free' => $swap_free,
                                'account_number' => $webserviceData['AccountNumber'],
                                'trader_password' =>  $webserviceData['TraderPassword'],
                                'investor_password' =>  $webserviceData['InvestorPassword'],
                                'phone_password' => $phone_password,
                                'registry_method'=> $webserviceData['tag'],
                                'group'=>$groupCurrency
                            );
                            $this->general_model->insert('mt_accounts_set', $mt_account);
                        }

                        /* MICRO ACCOUNTS */
                        if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $this->input->post('mt_account_set_id', true) == '4') {
                            $data_micro = array('micro' => 1);
                            $this->general_model->update_micro((int)$user_id, $data_micro);//UPDATE MICRO TO 1 in users
                            unset($_SESSION['isMicro']);
                        }
                        /* END MICRO ACCOUNTS */
                        
                        $user_update_d=array(
                            'created' => FXPP::getServerTime(), 
                            'type' => 1
                            );
                        $this->general_model->updatemy($table = "users", "id", $user_id, $user_update_d);
                        $getCookieAffiliate = $this->input->cookie('forexmart_affiliate');
                        $forexmart_affiliate = empty($input_affiliate_code) ? $getCookieAffiliate : $input_affiliate_code;
                        if (!empty($forexmart_affiliate)) {
                            $this->load->model('account_model');
                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];
                            if (!empty($AgentAccountNumber)) {
                                $service_data = array(
                                    'AccountNumber' => $webserviceData['AccountNumber'],
                                    'AgentAccountNumber' => $AgentAccountNumber
                                );

                                $webservice_config = array('server' => 'live_new');
                                $WebService = new WebService($webservice_config);
                                $WebService->SetAccountAgent($service_data);
                                if ($WebService->request_status === 'RET_OK') {
                                    $referral_data = array( 'referral_affiliate_code' => $forexmart_affiliate);
                                    $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                                }else {
                                    $agent_data = array(
                                        'user_id' => $user_id,
                                        'account_number' => $webserviceData['AccountNumber'],
                                        'agent_account_number' => $AgentAccountNumber
                                    );
                                    $this->account_model->insertFailedSetAgent($agent_data);
                                }
                            }
                        }
                        // Invite friend status update
                        $this->load->model('invite_model');
                        $email_user = $this->session->userdata('email_live');
                        $inv_ref = $forexmart_affiliate;
                        // $ref_code = $this->invite_model->getInvitedAffiliateCode($email_user);
                        $ref_code = $this->invite_model->getInvitedRefCode($email_user,$user_id);
                        $tbl_code = 'ref_number';
                        $tbl_email = 'email';
                        $invite_data = array(
                            'status' => 8,
                            'user_id_after_registration' => $user_id
                        );
                        if($inv_ref == $ref_code){
                            $this->invite_model->updateInviteDetails('invite_friends', $inv_ref, $tbl_code,$email_user,$tbl_email,$invite_data);
                        }
                        // end invite friend status update
                        $trading_experience = array(
                            'investment_knowledge' => $this->input->post('investment_knowledge', true),
                            'risk' => $this->input->post('risk', true),
                            'experience' => $this->input->post('experience', true),
                            'user_id' => $user_id,
                            'technical_analysis' => $this->input->post('technical_analysis', true),
                            'trade_duration' => $this->input->post('trade_duration', true),
                            'bankruptcy' => $this->input->post('bankruptcy', true),
                            'trading_leverage_experience' =>  $this->input->post('trading_leverage_experience', true),
                            'number_of_trades' =>  $this->input->post('number_of_trades', true),
                            'otc_meaning' => $this->input->post('otc_meaning', true),
                            'cfd_equity_stop_out_level' => $this->input->post('cfd_equity_stop_out_level', true),
                            'cfd_higher_leverage' => $this->input->post('cfd_higher_leverage', true),
                            'stop_out_level_50' => $this->input->post('stop_out_level_50', true),
                            'seminar_attended' => $this->input->post('seminar_attended', true),
                        );
                        $this->general_model->insert('trading_experience', $trading_experience);
                        $employment_detail = array(
                            'employment_status' => $this->input->post('employment_status', true),
                            'industry' => $this->input->post('industry', true),
                            'source_of_funds' => $this->input->post('source_of_funds', true),
                            'estimated_annual_income' => $this->input->post('estimated_annual_income', true),
                            'estimated_net_worth' => $this->input->post('estimated_net_worth', true),
                            'politically_exposed_person' => $this->input->post('politically_exposed_person', true),
                            'education_level' => $this->input->post('education_level', true),
                            'us_resident' => $this->input->post('us_resident', true),
                            'us_citizen' => $this->input->post('us_citizen', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('employment_details', $employment_detail);
                        $contacts_data = array(
                            'phone1' => $this->input->post('phone', true),
                            'user_id' => $user_id,
                            'telephone' =>  $this->input->post('telephone', true),
                        );
                        $this->general_model->insert('contacts', $contacts_data);


                        $this->update_account_group_For_Bangladesh($user_id,$AgentAccountNumber,$groupCurrency); //update groupcode



                        // send email  to user email
                        $email_data = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'email' => $this->session->userdata('email_live'),
                            'password' => $password,
                            'account_number' => $mt_account['account_number'],
                            'trader_password' => $mt_account['trader_password'],
                            'investor_password' => $mt_account['investor_password'],
                            'phone_password' => $mt_account['phone_password'],
                        );
                        $subject = "ForexMart MT4 Live Trading Account details";
                        $config = array(   'mailtype' => 'html' );
                        $isSendSuccess = $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,$config);
                        unset($_SESSION['ru_ctm_links']);
                        unset($_SESSION['FXPP6635']);
                        /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/
                        if(IPLoc::Office_for_NDB()){
                            FXPP::activate_trading_API($user_id,$webserviceData['AccountNumber']);
                        }
                        /* FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP */
                        $this->dailyCountryReport($user_id); // sent real time to the email groups
//                        $info_demo_account=array(
//                            'country' => $this->input->post('country', true),
//                            'user_id' => $user_id,
//                            'account_type' => $this->input->post('mt_account_set_id', true),
//                            'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
//                            'currency' => $this->input->post('mt_currency_base',true),
//                            'address' => $this->input->post('street', true),
//                            'city' => $this->input->post('city', true),
//                            'email' => $this->session->userdata('email_live'),
//                            'group' => $groupCurrency,
//                            'leverage' => $this->input->post('leverage', true),
//                            'name' => $this->session->userdata('full_name_live'),
//                            'phone_number' => $this->input->post('phone', true),
//                            'state' => $this->input->post('state', true),
//                            'zip_code' => $this->input->post('zip', true),
//                            'phone_password' => $phone_password,
//                            'technical_analysis' =>$this->input->post('technical_analysis', true)
//                        );
//                        $this->autoCreateDemoAccount($info_demo_account);
                        $data['success'] = true;
                        $data['info'] = $mt_account;
                    }
                    else
                    {
                        $data['errors'] = "Oops, something went wrong, Please try again in a few minutes.";
                        $data['success'] = false;
//                        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'error' => 'Oops, something went wrong, Please try again in a few minutes.'.$groupCurrency)));
                    }
                } else {
                    $data['errors'] = "Country is not currently available. Try it again.";
                    $data['success'] = false;
                }
            }else{

//                $data['success'] = false;
////                 echo validation_errors();
                $data['errors'] = "Please fill required fields.";


            }
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('register_live3', $data);
        } else {
            if ($_GET['login'] == 'partner') {
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }

    public function index()
    {
//        set_time_limit(3000);
//        @ini_set('max_execution_time', 3000);

       // set_time_limit(0);
        
        // accountstatus  estimated_annual_income




        if (isset($_SESSION['redirect'])) {redirect($_SESSION['redirect']);}
        if ($this->session->userdata('logged')) {
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');

          //  $active_user_details = $this->account_model->getUserDetailsByAccountNumber($_SESSION['account_number']);
            $curr_email = $this->session->userdata('email');
            $curr_full_name = $this->session->userdata('full_name') ;
            $curr_country = $this->session->userdata('country') ;

            $this->session->set_userdata(   array('email_live'=>$curr_email,'full_name_live'=>$curr_full_name) );


           // $user_details_emailname = $this->user_model->getFirstUserDetailsByEmailAndName($curr_email,$curr_full_name, $curr_country );  //data1

             $acc=$this->session->userdata('account_number');
             $user_details_emailname = $this->user_model->getFirstUserDetailsByEmailAndNameAndAcc($curr_email,$curr_full_name, $acc );  // FXMAIN-615



                       
            $trading_experience = explode(',', $user_details_emailname['experience']);
            $trading_experience_value = array();
            if (count($trading_experience) > 2) {
                foreach ($trading_experience as $experience) {
                    $trading_experience_value[] = $experience?true:false;
                }
            } else {
                $trading_experience_value = array(false, false, false);
            }
            $user_details['trading_experience_value'] = $trading_experience_value;
            $data['user_details'] = $user_details;
            $data['user_details_emailname'] =  $user_details_emailname;



               //$data['api_details_emailname'] = $this->getUserdetails($user_details_emailname['account_number']);   // data2

                $data['api_details_emailname'] = $this->getUserdetails($this->session->userdata('account_number')); // FXMAIN-615
            



            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(), isset($user_details['employment_status']) ? $user_details['employment_status'] : 0);
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getIndustry(), isset($user_details['industry']) ? $user_details['industry'] : null);
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
            //$data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome(), isset($user_details['estimated_annual_income']) ? $user_details['estimated_annual_income'] : 3);
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome(),$user_details['estimated_annual_income']);
			
			//$data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth(), isset($user_details['estimated_net_worth']) ? $user_details['estimated_net_worth'] : 3);
			$data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth(),$user_details['estimated_net_worth']);
			
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), isset($user_details['investment_knowledge']) ? $user_details['investment_knowledge'] : 1);
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel(), isset($user_details['education_level']) ? $user_details['education_level'] : null);
            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), isset($user_details['trade_duration']) ? $user_details['trade_duration'] : null);
            $data['postal_code'] = FXPP::getVisitorInfo()->postal_code;
            $user_aff_code = $this->account_model->getUserReferralCode($this->session->userdata('user_id'));
                       
            $data['aff_code'] = $user_aff_code['referral_affiliate_code'];

            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
            $user_country = FXPP::getUserCountryCode();
            //EU country can have max 1:500 leverage as long as they will registere in .com domain // FXPP-11330
//             if(IPLoc::isEuropeanCountryByCode($user_details_emailname['country']) || FXPP::isEUUrl() ) { //FXPP-9625
//                // $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50), "1:50");
//                $data['leverage'] = $this->general_model->selectOptionList(array('1:50' => '1:50'), "1:50");
//            }else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null,500),($user_details['leverage']!="")?$user_details['leverage'] : "1:50");
          //  }

            if(isset( $_SESSION['ru_ctm_links'])){
                switch($_SESSION['ru_ctm_links']){
                    case 'ru_posting':
                        $data['account_currency_base'] = $this->general_model->selectOptionList( array('RUB'=>'RUR'),"RUR"); // modified
                        break;
                }
            }

            if(FXPP::isAccountFromEUCountry()){
                $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase_v2(), isset($user_details['mt_currency_base']) ? $user_details['mt_currency_base'] : "USD" );

            }else{
               $data['account_currency_base'] = $this->general_model->selectOptionList(array('USD' => 'USD', 'EUR' => 'EUR','RUB' => 'RUR'), isset($user_details['mt_currency_base']) ? $user_details['mt_currency_base'] : "USD" );

            }
            if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $_SESSION['isMicro'] =='1' || $this->input->post('mt_account_set_id', true) == '4') {
                $data['account_type'] = $this->general_model->selectOptionList(array('4'=>'Forexmart Micro Account'),'4');
                $data['account_currency_base'] = $this->general_model->selectOptionList(array('USD' => 'USD', 'EUR' => 'EUR'), "USD");
                $data['micro'] = 1;
                unset($_SESSION['isMicro']);
            }

                    
                    


//            if (IPLoc::Office()) {
//                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries_localize(), isset($user_details['country']) ? $user_details['country'] : $this->country_code);
//            } else {
                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries(), isset($user_details_emailname['country']) ? $user_details_emailname['country'] : $this->country_code);
//            }


//            if($user_details_emailname['country'] == 'BD' || $this->country_code == 'BD' || strtoupper(FXPP::html_url()) == 'BD'){
//                $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getNewAccountTypeBD(), isset($user_details['mt_account_set_id']) ? $user_details['mt_account_set_id'] : 1);
//            }else{
//                $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getNewAccountType(), isset($user_details['mt_account_set_id']) ? $user_details['mt_account_set_id'] : 5);
//
//            }

                
          
            $number_account_types=$this->general_model->getNewAccountTypeBD();
            

                $isStandardAccount=$this->general_model->isStandardAccount();
                if(!$isStandardAccount){
                     unset($number_account_types[1]); // standard remove
                }
            
            
            
            $data['submitted'] = '0';
                    
                    
            $data['account_type'] = $this->general_model->selectOptionList($number_account_types, isset($user_details['mt_account_set_id']) ? $user_details['mt_account_set_id'] : 5);

         
            
                                   
            $this->form_validation->set_rules('street', 'Street', 'trim|required|max_length[128]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|max_length[16]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

            $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');

            if ($this->form_validation->run())
            {
                $data['submit'] = '1';
                
                $country = $this->input->post('country', true);
                $illicit_country = unserialize(ILLICIT_COUNTRIES);
                if(!in_array(strtoupper(trim($country)), $illicit_country)) 
                {
                    $login_type = 0; //login_type 0 = client user / 1 = partner user
                    $use_username = $this->config->item('use_username', 'tank_auth');
                    $email_activation = $this->config->item('email_activation', 'tank_auth');
                    $password = $this->autoPassword(8);
                    $inputCountry = $this->input->post('country', true);
                    $swap_free = $this->input->post('swap_free', true);
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $account_type = $this->input->post('mt_account_set_id', true);
                    $account_currency = $this->input->post('mt_currency_base', true);
                    $phone_password = FXPP::RandomizeCharacter(7);

                    if ($inputCountry == 'CN') {
                        $this->session->set_userdata('isChina', '1');
                    }


                    if ($this->input->post('country', true) == 'PL') {
                        $_SESSION['temp_country'] = 'PL';
                    }


                    $inputAffiliateCode  = $this->input->post('affiliate_code', true);
                    
                    
                    
                    // webserive registration require data

                    $agentData = array('country' => $inputCountry,'referralCode'=>$inputAffiliateCode);
                    $agentAccountData = $this->getAccountAgent($agentData);

                    $mtData = array('account_type' => $account_type,'account_currency'=>$account_currency,'account_swap'=>$swap_free);
                    $mtGroup = $this->getMtGroup($mtData);



                    // RET_CHAR_EXCEEDS API error
                    $EXCEED_COUNTRIES = array(
                        'UM' => 'United States Minor Outlying IS',
                        'GS' => 'South Georgia, South Sandwich IS',
                        'MK' => 'Macedonia',
                        'CD' => 'Congo, Democratic Republic Of',
                        'KP' => 'Korea, Democratic Republic Of',
                        'VC' => 'Saint Vincent And Grenadines'
                    );

                    if(array_key_exists($inputCountry, $EXCEED_COUNTRIES)) {
                        $serviceCountry = $EXCEED_COUNTRIES[$inputCountry];
                    }else{
                        $serviceCountry = $this->general_model->getCountries($inputCountry);
                    }

                    $this->load->helper('cookie');
                    $http_referer_url = $this->input->cookie('forexmart_http_referer');
                    $urlData = parse_url($http_referer_url);
                    $http_referer =  substr($urlData['host'],0,30);

                    $service_data = array(
                        'agent'       => $agentAccountData['agentAccount'],
                        'address'     => $this->input->post('street', true),
                        'city'        => $this->input->post('city', true),
                        'country'     => $serviceCountry,
                        'email'       => $this->session->userdata('email_live'),
                        'group'       => $mtGroup,
                        'lead_source' => $http_referer,
                        'leverage'    => count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true),
                        'name'        => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone', true),
                        'state'       => $this->input->post('state', true),
                        'zip_code'    => $this->input->post('zip', true),
                        'phone_password' => $phone_password,
                        'comment'     => $this->input->ip_address()
                    );


                    
                    
                    
                    $reg_log_data['personal'] = $service_data;

                    $webserviceData = $this->webServiceSaveliveAccount($service_data);
                    if($webserviceData['success'])
                    {

                        $data['submit'] = '2';

                        $user_inser_data = $this->tank_auth->create_user(
                            $use_username ? $this->form_validation->set_value('username') : '',
                            $this->session->userdata('email_live'),
                            $password,
                            $email_activation, 1, $login_type);
                        $user_id = $user_inser_data['user_id'];
                        $user_data = array( 'user_id' => $user_id,);
//                        $this->session->set_userdata($user_data);
                        $data['random_alpha_string_analytics'] = '';
                        $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
                        $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

                        if(FXPP::isEUUrl()){
                            $domain = 2; //forexmart.eu
                        }else{
                            $domain = 1; //forexmart.com
                        }

                            $acc_status = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='accountstatus');
                          
                            
                            $account_verified_status=array("1","3");
                            $allow_mt_account_info=false;

                        $verifiedFirst = $this->getUserdetails($user_details_emailname['account_number']); // 1st verified account



                        if(FXPP::isAutoVeriFiedAllow(FXPP::getTimeDuration($verifiedFirst['RegDate'])) and in_array($user_details_emailname['accountstatus'], $account_verified_status))
                            {        
                    
                            
                          ///  if($user_details_emailname['accountstatus'] == 1 or $user_details_emailname['accountstatus'] == 3){
                                
                                $allow_mt_account_info=true;
                                
                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 1,
                                    'type' => 1,
                                    'accountstatus' => $user_details_emailname['accountstatus'],
                                    'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                                    'registration_location'=>6,
                                    'internal_registration'=>1,
                                    'domain' => $domain,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_7',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                    
                                
                            }else{

                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 0,
                                    'type' => 1,
                                    'accountstatus' => 0,
                                    'registration_location'=>6,
                                    'internal_registration'=>1,
                                    'domain' => $domain,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_8',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                            }

       
                        $user_data = array(  'analytic_hash' => $data['random_alpha_string_analytics'], );
//                        $this->session->set_userdata($user_data);
                        $profile = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'user_id' => $user_id,
                            'country' => $this->input->post('country', true),
                            'street' => $this->input->post('street', true),
                            'city' => $this->input->post('city', true),
                            'state' => $this->input->post('state', true),
                            'zip' => $this->input->post('zip', true),
                            'dob' =>  date("Y-m-d", strtotime($this->input->post('dob', true))),
                            'dob_back' => date("Y-m-d", strtotime($this->input->post('dob', true))),
                        );


                        $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                      
                        // track registration link
                        $this->load->helpers('url');
                        $reg_date_cur = FXPP::getServerTime();
                        $reg_link_details = array(
                            'registration_link' => FXPP::my_url('registration/open_live_account'),
                            'user_id' => $user_id,
                            'street' => $this->input->post('street', true),
                            'date_created' => FXPP::getServerTime(),//date('Y-m-d H:i:s', strtotime($reg_date_cur)),
                        );
                        $this->general_model->insert('track_registration', $reg_link_details);

                        // Save Affiliate Link
                        $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                        $affiliate_code_data = array(
                            'users_id' => $user_id,
                            'affiliate_code' => $generateAffiliateCode
                        );
                        $this->general_model->insert('users_affiliate_code', $affiliate_code_data);                        
                        
                        // mt accounts information with webservice return
                        //$RegDate = FXPP::getServerTime();

                       // if(IPLoc::Office()){
                            $mt_account = array(
                                'leverage' => $this->input->post('leverage', true),
                                'registration_leverage' => $this->input->post('leverage', true),
                                'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                                'mt_currency_base' => $account_currency,
                                'mt_account_set_id' => $account_type,
                                'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                'registration_time' => FXPP::getServerTime(),
                                'user_id' => $user_id,
                                'mt_type' => 1,
                               // 'mt_status' => 1,
                                'swap_free' => $swap_free,
                                'account_number' => $webserviceData['AccountNumber'],
                                'trader_password' =>  $webserviceData['TraderPassword'],
                                'investor_password' =>  $webserviceData['InvestorPassword'],
                                'phone_password' => $phone_password,
                                'registry_method'=> $webserviceData['tag'],
                                'group'=>$mtGroup
                            );
                            
                            
                            
                            if($allow_mt_account_info)
                            {
                                $mt_account['mt_status']=1;
                            }

                            $this->general_model->insert('mt_accounts_set', $mt_account);

                   
                        
                        $reg_log_data['api'] = $mt_account;

                        /* MICRO ACCOUNTS */
                        if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $this->input->post('mt_account_set_id', true) == '4' || $this->input->post('mt_account_set_id', true) == '7') {
                            $data_micro = array('micro' => 1);
                            $this->general_model->update_micro((int)$user_id, $data_micro);//UPDATE MICRO TO 1 in users
                            unset($_SESSION['isMicro']);
                        }
                        /* END MICRO ACCOUNTS */
                        $user_update_d=array(
                            'created' => FXPP::getServerTime(),
                            'type' => 1,
                            'account_link'=>1
                            );
                        $this->general_model->updatemy($table = "users", "id", $user_id,$user_update_d);
                       
                        
                    
                        
                        // add log reffarel code
                        //$getCookieAffiliate = $this->input->cookie('forexmart_affiliate');
                         $reg_log_data['personal']['referral_affiliate_code'] = $agentAccountData['affiliate_code'];
                        if(!empty($agentAccountData['affiliate_code']))
                        {
                            $referral_data = array( 'referral_affiliate_code' => $agentAccountData['affiliate_code']);
                            $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);

                        }

                            

                  

                      /*  if(!empty($forexmart_affiliate))
                         {
                            $this->load->model('account_model');
                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];
                            if (!empty($AgentAccountNumber)) {
                                $service_data = array(
                                    'AccountNumber' => $webserviceData['AccountNumber'],
                                    'AgentAccountNumber' => $AgentAccountNumber
                                );

                                $webservice_config = array('server' => 'live_new');
                                $WebService = new WebService($webservice_config);
//                                $WebService->SetAccountAgent($service_data);

                                if(IPLoc::VPN_IP_Jenalie()){
                                    $this->load->library('WSV'); //New web service
                                    $WSV = new WSV();

                                    $WebService = $WSV->SetAccountDetail($service_data, "SetAgentAccount");
                                    $emailData = array(
                                        'email' => 'forexmart.tester5@gmail.com',
                                        'subject' => 'SetAccountAgent',
                                        'body' => $WebService->request_status
                                    );
                                    $this->load->library("Fx_mailer");
                                    Fx_mailer::testAPI($emailData);
                                }else{
                                    $WebService->SetAccountAgent($service_data);
                                }

                                if ($WebService->request_status === 'RET_OK') {
                                    $referral_data = array( 'referral_affiliate_code' => $forexmart_affiliate);
                                    $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                                }else {
                                    $agent_data = array(
                                        'user_id' => $user_id,
                                        'account_number' => $webserviceData['AccountNumber'],
                                        'agent_account_number' => $AgentAccountNumber
                                    );
                                    $this->account_model->insertFailedSetAgent($agent_data);
                                }
                            }
                        }*/
                        // Invite friend status update
                        $this->load->model('invite_model');
                        $email_user = $this->session->userdata('email_live');
                        $inv_ref = $agentAccountData['affiliate_code'];
                        // $ref_code = $this->invite_model->getInvitedAffiliateCode($email_user);
                        $ref_code = $this->invite_model->getInvitedRefCode($email_user,$user_id);
                        $tbl_code = 'ref_number';
                        $tbl_email = 'email';
                        $invite_data = array(
                            'status' => 8,
                            'user_id_after_registration' => $user_id
                        );
                        if($inv_ref == $ref_code){
                            $this->invite_model->updateInviteDetails('invite_friends', $inv_ref, $tbl_code,$email_user,$tbl_email,$invite_data);
                        }
                        // end invite friend status update
                        $trading_experience = array(
                            'investment_knowledge' => $this->input->post('investment_knowledge', true),
                            'risk' => $this->input->post('risk', true),
                            'experience' => $this->input->post('experience', true),
                            'user_id' => $user_id,
                            'technical_analysis' => $this->input->post('technical_analysis', true),
                            'trade_duration' => $this->input->post('trade_duration', true),
                        );
                        $this->general_model->insert('trading_experience', $trading_experience);
                        $employment_detail = array(
                            'employment_status' => $this->input->post('employment_status', true),
                            'industry' => $this->input->post('industry', true),
                            'source_of_funds' => $this->input->post('source_of_funds', true),
                            'estimated_annual_income' => $this->input->post('estimated_annual_income', true),
                            'estimated_net_worth' => $this->input->post('estimated_net_worth', true),
                            'politically_exposed_person' => $this->input->post('politically_exposed_person', true),
                            'education_level' => $this->input->post('education_level', true),
                            'us_resident' => $this->input->post('us_resident', true),
                            'us_citizen' => $this->input->post('us_citizen', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('employment_details', $employment_detail);
                        $contacts_data = array(
                            'phone1' => $this->input->post('phone', true),
                            'user_id' => $user_id
                        );
                        $contacts = $this->general_model->insert('contacts', $contacts_data);



//                        if(IPLoc::IPOnlyForMe()){
                          //  $this->update_account_group_For_Bangladesh($user_id,$AgentAccountNumber,$groupCurrency); //update groupcode
//                        }


//                        $reg_log = array(
//                            'data' => json_encode($reg_log_data),
//                            'error_condition' => '',
//                            'error_msg' => json_encode($webserviceData['regAPIstatus']),
//                            'registration_url' => current_full_url(),
//                            'date' => FXPP::getServerTime(),
//                            'ip_address' => $_SERVER['REMOTE_ADDR'],
//                            'result_data' => json_encode( $reg_log_data),
//                        );
//                        $this->general_model->insertRegLog($reg_log);

                        if($mt_account['mt_account_set_id'] != 6){ // Pro Account must be activated only when balance is more than or equals to 200$
                            FXPP::activate_trading_API($user_id,$webserviceData['AccountNumber']);
                        }

                        // send email  to user email
                        $email_data = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'email' => $this->session->userdata('email_live'),
                            'password' => $password,
                            'account_number' => $mt_account['account_number'],
                            'trader_password' => $mt_account['trader_password'],
                            'investor_password' => $mt_account['investor_password'],
                            'phone_password' => $mt_account['phone_password'],
                        );
                        $subject = "ForexMart MT4 Live Trading Account details";
                        $config = array(   'mailtype' => 'html' );
                        $isSendSuccess = $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,$config);



                        unset($_SESSION['ru_ctm_links']);
                        unset($_SESSION['FXPP6635']);
                        /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/



                        /* FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP */
                        $this->dailyCountryReport($user_id); // sent real time to the email groups
//                        $info_demo_account=array(
//                            'country' => $this->input->post('country', true),
//                            'user_id' => $user_id,
//                            'account_type' => $this->input->post('mt_account_set_id', true),
//                            'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
//                            'currency' => $this->input->post('mt_currency_base',true),
//                            'address' => $this->input->post('street', true),
//                            'city' => $this->input->post('city', true),
//                            'email' => $this->session->userdata('email_live'),
//                            'group' => $groupCurrency,
//                            'leverage' => $this->input->post('leverage', true),
//                            'name' => $this->session->userdata('full_name_live'),
//                            'phone_number' => $this->input->post('phone', true),
//                            'state' => $this->input->post('state', true),
//                            'zip_code' => $this->input->post('zip', true),
//                            'phone_password' => $phone_password,
//                            'technical_analysis' =>$this->input->post('technical_analysis', true)
//                        );
//                        $this->autoCreateDemoAccount($info_demo_account);
                        $data['success'] = true;
                        $data['info'] = $mt_account;


                    }
                    else
                    {
                        $data['errors'] = "Oops, something went wrong, Please try again in a few minutes.";
                        $data['success'] = false;

                            //send Registration data
                            $reg_data = array(
                                'full_name'        => $this->session->userdata('full_name_live'),
                                'email'            => $this->session->userdata('email_live'),
                                'registration_date' => FXPP::getServerTime(),
                                'country' => $this->general_model->getCountries($this->input->post('country', true)),
                                'status' => $webserviceData['regAPIstatus'],
                                'step' => 'Internal Registration'
                            );
                            Fx_mailer::registration_data($reg_data);

                      //  $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'error' => 'Oops, something went wrong, Please try again in a few minutes.'.$groupCurrency)));
                    }
                } else {
                    $data['errors'] = "Country is not currently available. Try it again.";
                    $data['success'] = false;
                }
            }else{
                $data['errors'] = "Please fill required fields.";
                if(IPLoc::VPN_IP_Jenalie()){
//                    $data['success'] = false;
                }
            }

//            $data['calling_code'] = '+'.$this->general_model->getCallingCode($this->country_code);


            $view = 'register_live2';
            if(IPLoc::VPN_IP_Jenalie()){
                $view = 'register_live2_new';
            }

            
            // account_type
                    

           $reg_log = array(
                'data' => json_encode($reg_log_data),
                'error_condition' => $data['errors'],
                'error_msg' => $webserviceData['regAPIstatus'],
                 'registration_url' => 'internal/registration',
                'date' => FXPP::getServerTime(),
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                //'result_data' => json_encode( $reg_log_data),
                'email' => $this->session->userdata('email_live'),
                'result_status' => $webserviceData['regAPIstatus'],
            );
            $this->general_model->insertRegLog($reg_log);


            unset($data['DateUp'] );
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
                ->append_metadata_js("<script src='" . $this->template->Js() . "bootbox.min.js'></script>")
                ->set_layout('internal/main')
                ->build($view, $data);
        } else {
            if ($_GET['login'] == 'partner') {
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }

   
    public function getAccountAgent($infoData){
        //Referral affiliate code
        $this->load->helper('cookie');
        $cookieReferralCode = $this->input->cookie('forexmart_affiliate');

        $inputReferralCode = $infoData['referralCode'];

        if (!empty($cookieReferralCode) && !empty($inputReferralCode)) {
            $fmReferralCode = $inputReferralCode;
        } else if (empty($inputReferralCode) && !empty($cookieReferralCode)) {
            $fmReferralCode = $cookieReferralCode;
        } else if (empty($cookieReferralCode) && !empty($inputReferralCode)) {
            $fmReferralCode = $inputReferralCode;
        } else if (empty($cookieReferralCode) && empty($inputReferralCode)) {
            $fmReferralCode = '';
        } else {
            $fmReferralCode = '';
        }

        // FXPP-12124
        if(strlen($fmReferralCode)<2 && $infoData['country'] == 'MY'){
            $fmReferralCode = 'BZWEF';
        }
        $_SESSION['aff_code'] = $fmReferralCode;

        if (!empty( $fmReferralCode )) {

            $this->load->model('account_model');
            $agentData = $this->account_model->getAccountNumberByCode($fmReferralCode);
            $agentAccountNumber = ($agentData['account_number'] > 0) ? $agentData['account_number'] : 0 ;
            return array('affiliate_code' =>$fmReferralCode,'agentAccount'=> $agentAccountNumber);

        }else{
            if(!IPloc::Office()){
                return array('affiliate_code' =>'GWLSW','agentAccount'=> '333'); // FXDES-1831 - default agent code

            }
        }


        return  array('affiliate_code' =>$fmReferralCode,'agentAccount'=> 0);

    }
    public function getMtGroup($mtData){

        /*  =============== Spread project  setting ================================ */
        $this->load->helper('cookie');
        $speardGroup = $this->input->cookie('forexmart_account_type');  // Here store spread of value using affiliateChecker hook.
        $speardGroup = $mtData['account_type']==1? "refSt".$speardGroup:"refZe".$speardGroup;

        if($mtData['account_type']==1){
            $speardGroup = "refSt".$speardGroup;
        }elseif($mtData['account_type']==2) {
            $speardGroup = "refZe" . $speardGroup;
        }
//                    }elseif($account_type==4){
//                        $speardGroup = "refStC".$speardGroup;  // Macro account type
//                    }
        if(!$this->general_model->getGroupSpard($speardGroup)){
            $groupCurrency = $this->general_model->getGroupCurrency((int)$mtData['account_type'], $mtData['account_currency'], $mtData['account_swap']).'1';
        }else{
            $groupCurrency = $speardGroup;
        }
        
        return $groupCurrency;

    }


    public function getUserdetails_old($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
        $webService->request_account_details1($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        }else{
            $data = false;
        }
        return $data;
    }

    public function getUserdetails($account_number){ //FXPP-13646

        $newWebService = FXPP::GetAllAccountDetails($account_number);

        if ($newWebService['ErrorMessage'] === 'RET_OK') {
            $data = (array) $newWebService['Data'][0];
        } else {
            $data = false;
        }

        return $data;
    }

    public function checkAgent(){
        if ($this->session->userdata('logged') && $this->input->is_ajax_request()) {
            $affiliate_code = $this->input->post('code');
            $this->load->model('account_model');
            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($affiliate_code);
            if ($getAccountNumberByAffiliateCode) {
                $isSucc = true;
                $message = $getAccountNumberByAffiliateCode;
            } else {
                $isSucc = false;
                $message = "Please enter a valid affiliate code.";
            }

            $d1 = array(
                'success'=>$isSucc,
                'error'=>$message,
                'dbData'=>$getAccountNumberByAffiliateCode,
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($d1));
        }
    }

    public function character_check($str)
    {
        $this->load->library('Cyrillic');
        if (preg_match(Cyrillic::register_page(), $str)
        ) {
            $this->form_validation->set_message('character_check', lang('validate_engrus1') . ' %s ' . lang('validate_engrus2'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
    private function autoPassword($nc, $a = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        $l = strlen($a) - 1;
        $r = '';
        while ($nc-- > 0) $r .= $a{mt_rand(0, $l)};
        return $r;
    }

    public function open_live_account(){
        if ($this->session->userdata('logged')) {
            $this->form_validation->set_rules('street', 'Street', 'trim|required|max_length[128]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|max_length[16]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

            $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');

//            print_r($this->input->post('street'));echo "<br>";
//            print_r($this->input->post('city'));echo "<br>";
//            print_r($this->input->post('state'));echo "<br>";
//            print_r($this->input->post('country'));echo "<br>";
//            print_r($this->input->post('zip'));echo "<br>";
//            print_r($this->input->post('phone'));echo "<br>";
//            print_r($this->input->post('dob'));echo "<br>";
//            print_r($this->input->post('mt_account_set_id'));echo "<br>";
//            print_r($this->input->post('mt_currency_base'));echo "<br>";
//            print_r($this->input->post('leverage'));echo "<br>";
//            exit;
            if ($this->form_validation->run()){
                $country = $this->input->post('country', true);
                $this->session->set_userdata('country_code', $country);
                $illicit_country = unserialize(ILLICIT_COUNTRIES);
                if (!in_array(strtoupper(trim($country)), $illicit_country)) {
                    $login_type = 0; //login_type 0 = client user / 1 = partner user
                    $use_username = $this->config->item('use_username', 'tank_auth');
                    $email_activation = $this->config->item('email_activation', 'tank_auth');
                    $password = $this->autoPassword(8);

                    $swap_free = $this->input->post('swap_free', true);
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $phone_password = FXPP::RandomizeCharacter(7);

                    if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
                        $this->session->set_userdata('isChina', '1');
                    }else{
                        $this->session->set_userdata('isChina', '0');
                    }

                    /*  =============== Spread project  setting ================================ */
                    $speardGroup = $this->input->cookie('forexmart_account_type');  // Here store spread of value using affiliateChecker hook.
                    $mt_set_id =$this->input->post('mt_account_set_id',true);
                    $speardGroup = $mt_set_id==1? "refSt".$speardGroup:"refZe".$speardGroup;

                    if($mt_set_id==1){
                        $speardGroup = "refSt".$speardGroup;
                    }elseif($mt_set_id==2){
                        $speardGroup = "refZe".$speardGroup;
                    }elseif($mt_set_id==4){
                        $speardGroup = "refStC".$speardGroup;  // Macro account type
                    }
                    if(!$this->general_model->getGroupSpard($speardGroup)){
                        $groupCurrency = $this->general_model->getGroupCurrency((int)$mt_set_id, $this->input->post('mt_currency_base',true), $swap_free).'1';
                    }else{
                        $groupCurrency = $speardGroup;
                    }
                    // affiliate referrral get
                    $input_affiliate_code = $this->input->post('affiliate_code', true);
                    $affiliate_code_logs = self::getAffiliateLogs($input_affiliate_code);
                    $affiliate_referral_codes = ':' . str_replace('-', ':', $affiliate_code_logs);
                    // webserive registration require data
                    $service_data = array(
                        'address' => $this->input->post('street', true),
                        'city' => $this->input->post('city', true),
                        'country' => $this->general_model->getCountries($this->input->post('country', true)),
                        'email' => $this->session->userdata('email_live'),
                        'group' => $groupCurrency,
                        'leverage' => count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true),
                        'name' => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone', true),
                        'state' => $this->input->post('state', true),
                        'zip_code' => $this->input->post('zip', true),
                        'phone_password' => $phone_password,
                        'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                    );
                    $webserviceData = $this->webServiceSaveliveAccount($service_data);
                    if($webserviceData['success'])
                    {
                        $user_inser_data = $this->tank_auth->create_user(
                            $use_username ? $this->form_validation->set_value('username') : '',
                            $this->session->userdata('email_live'),
                            $password,
                            $email_activation, 1, $login_type);
                        $user_id = $user_inser_data['user_id'];
                        $user_data = array( 'user_id' => $user_id,);
//                        $this->session->set_userdata($user_data);
                        $data['random_alpha_string_analytics'] = '';
                        $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
                        $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                        $data['save_hash'] = array(
                            'first_login_hash' => $data['random_alpha_string_analytics'],
                            'first_login_stat' => 1,
                            'auto_verified' => 1,
                            'accountstatus' => 1,
                            'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                            'registration_location'=>6,
                            "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                            "accountstatus_update_location"=>'my_9',
                            "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                        );
                        $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                        $user_data = array(  'analytic_hash' => $data['random_alpha_string_analytics'], );
//                        $this->session->set_userdata($user_data);
                        $profile = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'user_id' => $user_id,
                            'country' => $this->input->post('country', true),
                            'street' => $this->input->post('street', true),
                            'city' => $this->input->post('city', true),
                            'state' => $this->input->post('state', true),
                            'zip' => $this->input->post('zip', true),
                            'dob' => $this->input->post('dob', true),
                            'dob_back' => $this->input->post('dob', true)
                        );
                        if ($this->input->post('country', true) == 'PL') {
                            $_SESSION['temp_country'] = 'PL';
                        }
                        $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                        /*  =============== End Spread project  setting ================================ */
                        // track registration link
                        $this->load->helpers('url');
                        $reg_date_cur = FXPP::getServerTime();
                        $reg_link_details = array(
                            'registration_link' => FXPP::my_url('registration'),
                            'user_id' => $user_id,
                            'street' => $this->input->post('street', true),
                            'date_created' => FXPP::getServerTime(),
                        );
                        $this->general_model->insert('track_registration', $reg_link_details);

                        // Save Affiliate Link
                        $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                        $affiliate_code_data = array(
                            'users_id' => $user_id,
                            'affiliate_code' => $generateAffiliateCode
                        );
                        $this->general_model->insert('users_affiliate_code', $affiliate_code_data);
                        // mt accounts information with webservice return
                        //$RegDate = FXPP::getServerTime();

                        $leverage = count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true);
                        if(IPLoc::isEuropeanIP()){
                            $leverage = 50;
                        }

                        $mt_account = array(
                            'leverage' => $leverage, //$this->input->post('leverage', true),
                            'registration_leverage' => $this->input->post('leverage', true),
                            'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                            'mt_currency_base' => $this->input->post('mt_currency_base', true),
                            'mt_account_set_id' => $this->input->post('mt_account_set_id', true),
                            'registration_ip' => $_SERVER['REMOTE_ADDR'],
                            'registration_time' => FXPP::getServerTime(),
                            'user_id' => $user_id,
                            'mt_type' => 1,
                            'mt_status' => '1',
                            'swap_free' => $swap_free,
                            'account_number' => $webserviceData['AccountNumber'],
                            'trader_password' =>  $webserviceData['TraderPassword'],
                            'investor_password' =>  $webserviceData['InvestorPassword'],
                            'phone_password' => $phone_password,
                            'registry_method'=> $webserviceData['tag'],
                            'group'=>$groupCurrency
                        );
                        $this->general_model->insert('mt_accounts_set', $mt_account);
                        /* MICRO ACCOUNTS */
                        if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $this->input->post('mt_account_set_id', true) == '4') {
                            $data_micro = array(
                                'micro' => 1
                            );
                            $this->general_model->update_micro((int)$user_id, $data_micro);//UPDATE MICRO TO 1 in users
                            unset($_SESSION['isMicro']);
                        }
                        /* END MICRO ACCOUNTS */
                        $user_update_d=array(
                            'created' => FXPP::getServerTime(),
                            'type' => 1
                            );
                        $this->general_model->updatemy($table = "users", "id", $user_id,$user_update_d );
                        
                        $this->general_model->updatemy($table = "mt_accounts_set", "user_id", $user_inser_data['user_id'], array('mt_status' => '1'));
                        $getCookieAffiliate = $this->input->cookie('forexmart_affiliate');
                        $forexmart_affiliate = empty($input_affiliate_code) ? '' : $input_affiliate_code;
                        if (!empty($forexmart_affiliate)) {
                            $this->load->model('account_model');
                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];
                            if (!empty($AgentAccountNumber)) {
                                $service_data = array(
                                    'AccountNumber' => $webserviceData['AccountNumber'],
                                    'AgentAccountNumber' => $AgentAccountNumber
                                );

                                $webservice_config = array('server' => 'live_new');
                                $WebService = new WebService($webservice_config);
                                $WebService->SetAccountAgent($service_data);
                                if ($WebService->request_status === 'RET_OK') {
                                    $referral_data = array( 'referral_affiliate_code' => $forexmart_affiliate);
                                    $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                                }else {
                                    $agent_data = array(
                                        'user_id' => $user_id,
                                        'account_number' => $webserviceData['AccountNumber'],
                                        'agent_account_number' => $AgentAccountNumber
                                    );
                                    $this->account_model->insertFailedSetAgent($agent_data);
                                }
                            }
                        }
                        // Invite friend status update
                        $this->load->model('invite_model');
                        $email_user = $this->session->userdata('email_live');
                        $inv_ref = $forexmart_affiliate;
                        // $ref_code = $this->invite_model->getInvitedAffiliateCode($email_user);
                        $ref_code = $this->invite_model->getInvitedRefCode($email_user,$user_id);
                        $tbl_code = 'ref_number';
                        $tbl_email = 'email';
                        $invite_data = array(
                            'status' => 8,
                            'user_id_after_registration' => $user_id
                        );
                        if($inv_ref == $ref_code){
                            $this->invite_model->updateInviteDetails('invite_friends', $inv_ref, $tbl_code,$email_user,$tbl_email,$invite_data);
                        }
                        // end invite friend status update
                        $trading_experience = array(
                            'investment_knowledge' => $this->input->post('investment_knowledge', true),
                            'risk' => $this->input->post('risk', true),
                            'experience' => $this->input->post('experience', true),
                            'user_id' => $user_id,
                            'technical_analysis' => $this->input->post('technical_analysis', true),
                            'trade_duration' => $this->input->post('trade_duration', true),
                        );
                        $this->general_model->insert('trading_experience', $trading_experience);
                        $employment_detail = array(
                            'employment_status' => $this->input->post('employment_status', true),
                            'industry' => $this->input->post('industry', true),
                            'source_of_funds' => $this->input->post('source_of_funds', true),
                            'estimated_annual_income' => $this->input->post('estimated_annual_income', true),
                            'estimated_net_worth' => $this->input->post('estimated_net_worth', true),
                            'politically_exposed_person' => $this->input->post('politically_exposed_person', true),
                            'education_level' => $this->input->post('education_level', true),
                            'us_resident' => $this->input->post('us_resident', true),
                            'us_citizen' => $this->input->post('us_citizen', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('employment_details', $employment_detail);
                        $contacts_data = array(
                            'phone1' => $this->input->post('phone', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('contacts', $contacts_data);
                        // send email  to user email
                        $email_data = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'email' => $this->session->userdata('email_live'),
                            'password' => $password,
                            'account_number' => $mt_account['account_number'],
                            'trader_password' => $mt_account['trader_password'],
                            'investor_password' => $mt_account['investor_password'],
                            'phone_password' => $mt_account['phone_password'],
                        );
                        $subject = "ForexMart MT4 Live Trading Account details";
                        $config = array(   'mailtype' => 'html' );
                        $isSendSuccess = $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,$config);
                        unset($_SESSION['ru_ctm_links']);
                        unset($_SESSION['FXPP6635']);
                        /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/
                        if(IPLoc::Office_for_NDB()){
                            FXPP::activate_trading_API($user_id,$webserviceData['AccountNumber']);
                        }
                        /* FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP */
                        $this->dailyCountryReport($user_id); // sent real time to the email groups
//                        $info_demo_account=array(
//                            'country' => $this->input->post('country', true),
//                            'user_id' => $user_id,
//                            'account_type' => $this->input->post('mt_account_set_id', true),
//                            'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
//                            'currency' => $this->input->post('mt_currency_base',true),
//                            'address' => $this->input->post('street', true),
//                            'city' => $this->input->post('city', true),
//                            'email' => $this->session->userdata('email_live'),
//                            'group' => $groupCurrency,
//                            'leverage' => $this->input->post('leverage', true),
//                            'name' => $this->session->userdata('full_name_live'),
//                            'phone_number' => $this->input->post('phone', true),
//                            'state' => $this->input->post('state', true),
//                            'zip_code' => $this->input->post('zip', true),
//                            'phone_password' => $phone_password,
//                            'technical_analysis' =>$this->input->post('technical_analysis', true)
//                        );
//                        $this->autoCreateDemoAccount($info_demo_account);
                        $data['success'] = true;
                        $data['info'] = $mt_account;
                    }
                    else
                    {
                        $data['errors'] = "Oops, something went wrong, Please try again in a few minutes.";
                        $data['success'] = false;
                        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'error' => 'Oops, something went wrong, Please try again in a few minutes.'.$groupCurrency)));
                    }
                } else {
                    $data['errors'] = "Country is not currently available. Try it again.";
                    $data['success'] = false;
                }
            }else{
                $data['errors'] = "Please fill required fields.";
            }
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
                ->set_layout('internal/main')
                ->build('register_live2', $data);
        }
    }
    public function autoCreateDemoAccount($info_demo_account = array()){
        $country = $info_demo_account['country'];
        $illicit_country = unserialize(ILLICIT_COUNTRIES);
        if (!in_array(strtoupper(trim($country)), $illicit_country)) {
            $user_id = $info_demo_account['user_id'];
            $webservice_config = array( 'server' => 'demo_new' );
            $WebService = new WebService($webservice_config);
            $groupCurrency = $this->general_model->getDemoGroupCurrency((int)$info_demo_account['account_type'], $info_demo_account['currency']);

            $account_info = array(
                'address' => $info_demo_account['address'],
                'city' => $info_demo_account['city'],
                'country' => $this->general_model->getCountries($info_demo_account['country']),
                'email' => $info_demo_account['email'],
                'group' => $groupCurrency,
                'leverage' => count($ex_leverage = explode(":", $info_demo_account['leverage'])) > 1 ? $ex_leverage[1] : $info_demo_account['leverage'],
                'name' => $info_demo_account['name'],
                'phone_number' => $info_demo_account['phone_number'],
                'state' => $info_demo_account['state'],
                'zip_code' => $info_demo_account['zip_code'],
                'phone_password' =>''
            );
//            $WebService->open_account_standard($account_info);

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService = $WSV->OpenNewAccount($account_info, $webservice_config);

            if ($WebService->request_status === 'RET_OK') {

//                $AccountNumber = $WebService->get_result('LogIn');
//                $TraderPassword = $WebService->get_result('TraderPassword');
//                $InvestorPassword = $WebService->get_result('InvestorPassword');

                $AccountNumber    = $WebService->AccountNumber;
                $TraderPassword   = $WebService->TraderPassword;
                $InvestorPassword = $WebService->InvestorPassword;

                $RegDate = FXPP::getServerTime();
                $this->db->trans_start();
                $mt_account = array(
                    'leverage' => $info_demo_account['leverage'],
                    'amount' => 10000,
                    'mt_currency_base' => $info_demo_account['currency'],
                    'mt_account_set_id' => $info_demo_account['account_type'],
                    'registration_ip' => $_SERVER['REMOTE_ADDR'],
                    'registration_time' => FXPP::getServerTime(),
                    'user_id' => $user_id,
                    'mt_type' => 0,
                    'account_number' => $AccountNumber,
                    'trader_password' => $TraderPassword,
                    'investor_password' => $InvestorPassword
                );
                $this->general_model->insert('mt_accounts_set', $mt_account);
                $WebService2 = new WebService($webservice_config);
                $WebService2->update_demo_deposit_balance($AccountNumber, 10000);
                $trading_experience = array(
                    'user_id' => $user_id,
                    'technical_analysis' => $info_demo_account['technical_analysis'],
                );
                $this->general_model->insert('trading_experience', $trading_experience);
                $contacts_data = array(
                    'phone1' => $info_demo_account['phone_number'],
                    'user_id' => $user_id
                );
                $this->general_model->insert('contacts', $contacts_data);
                $this->db->trans_complete();
            } else {
                return false;
            }
        }
    }
    public function dailyCountryReport($user_id)
    {
        $this->load->model('account_model');
        $this->load->model('general_model');
        if ($row = $insert_data['client_country'] = $this->account_model->getClientInfoByUserId($user_id)) {
            $c_code = $row[0]->country;
            $insert_data['country'] = $this->general_model->getCountries();
            $insert_data['country']["GB','IE"] = "UK and Ireland ";
            $insert_data['country']["AT','DE"] = "Austria and Germany ";
            $insert_data['country']["AM','BY','KZ','KG','MD','RU','TJ','TM','UA"] = "Russia and CIS";

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
                "IN" => "clients_india_daily_1@forexmart.com",
                "PK" => "clients_pakistan_daily_1@forexmart.com",
                "CF" => "clients_africa_daily_1@forexmart.com",
                "JM" => "clients_jamaica_daily_1@forexmart.com",
                "AU" => "clients_australia_daily_1@forexmart.com",
                "NZ" => "clients_australia_daily_1@forexmart.com",
                "MT" => "clients_malta_daily_1@forexmart.com",
                "SG" => "clients_singapore_daily_1@forexmart.com",
                "UZ" => "clients_uzbekistan_daily_1@forexmart.com",
                "BD" => "clients_bangladesh_daily_1@forexmart.com",


            );
            if (isset($to_email[$c_code])) {
                if ($to_email[$c_code] == "clients_russia_daily_1@forexmart.com") {
                    if($exGroup = $this->general_model->where("cis_group_mail",array('email'=>$row[0]->email))){
                        $insert_data['email'] = "clients_russia_daily_".$exGroup->row()->group_id."@forexmart.com";
                    }else{
                        if ($this->account_model->getCISRegPerDay() % 2 == 0) {
                            $insert_data['email'] = "clients_russia_daily_1@forexmart.com";
                            $this->general_model->insertmy('cis_group_mail',array('email'=>$row[0]->email,'group_id'=>1));
                        } else {
                            $insert_data['email'] = "clients_russia_daily_2@forexmart.com";
                            $this->general_model->insertmy('cis_group_mail',array('email'=>$row[0]->email,'group_id'=>2));
                        }
                    }
                } else {
                    $insert_data['email'] = $to_email[$c_code];
                }
            } else {
                return true;
                $insert_data['email'] = "german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com";
            }
            $insert_data['subject'] = "Clients from " . $insert_data['country'][$c_code] . " on  " . date('Y-m-d');
            $config = array(
                'mailtype' => 'html'
            );
            $this->load->library('email');
            if ($config != null) {  $this->email->initialize($config); }
            $this->SMTPDebug = 1;
            $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
            $this->email->to($insert_data['email']);
            if (isset($to_email[$c_code])) {
                $this->email->bcc('german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com,stefania.sopko@forexmart.com');
            } else {
                $this->email->bcc('stefania.sopko@forexmart.com');
            }
            $this->email->subject($insert_data['subject']);
            $this->email->message($this->load->view('email/realtime_client_report', $insert_data, TRUE));
            $this->email->send();
        }
    }
    public function getAffiliateLogs($input_affiliate_code)
    {
        $getCookieLogs = $this->input->cookie('forexmart_affiliate_logs');
        $affiliate_code = $this->input->cookie('forexmart_affiliate');
        if (empty($getCookieLogs) and !empty($affiliate_code)) {
            $getCookieLogs = $affiliate_code;
        }
        if (empty($getCookieLogs)) {
            $affiliate_code = $input_affiliate_code;
        } else {
            $affiliate_code = '-' . $input_affiliate_code;
        }
        if (!empty($input_affiliate_code)) {  $getCookieLogs = $getCookieLogs . $affiliate_code;  }
        return $getCookieLogs;
    }


    public function webServiceSaveliveAccount($service_data)
    {
        $webservice_config = array( 'server' => 'live_new' );
        $WebService = new WebService($webservice_config);
        $tag='';
        if(isset($_SESSION['FXPP6635']) and $_SESSION['FXPP6635']=='GJAOV'){
            $WebService->open_partner_special_account($service_data);
            $tag='open_partner_special_account';
        }else{
//            $WebService->open_account_standard($service_data);
            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $WebService = $WSV->OpenNewAccount($service_data, $webservice_config);
            $tag='open_account_standard';
        }
      /* if(IPLoc::IPOnlyForMe()){
           print_r($service_data);
           echo $WebService->request_status;
           exit();
       }*/
        // check account create and account number confirm
        if ($WebService->request_status === 'RET_OK'){

//            $AccountNumber = $WebService->get_result('LogIn');
//            $TraderPassword = $WebService->get_result('TraderPassword');
//            $InvestorPassword = $WebService->get_result('InvestorPassword');

            if($tag === 'open_partner_special_account'){

                $AccountNumber    = $WebService->get_result('LogIn');
                $TraderPassword   = $WebService->get_result('TraderPassword');
                $InvestorPassword = $WebService->get_result('InvestorPassword');

            }else{

                $AccountNumber    = $WebService->AccountNumber;
                $TraderPassword   = $WebService->TraderPassword;
                $InvestorPassword = $WebService->InvestorPassword;

            }


//                  $RegDate = $WebService->get_result('RegDate');
//            $WebService4 = new WebService($webservice_config);
//            $account_info2 = array( 'iLogin' =>  $AccountNumber );
//            $WebService4->request_account_details($account_info2);

            $WebService4 = FXPP::GetAllAccountDetails($AccountNumber);

            if( $WebService4['ErrorMessage'] === 'RET_OK'){
                $RegDate = $WebService4['Data'][0]->RegDate;
            }else{
                $RegDate  = FXPP::getServerTime();
            }
            $webserviceData=array(
                'RegDate'=>$RegDate,
                'AccountNumber'=>$AccountNumber,
                'TraderPassword'=>$TraderPassword,
                'InvestorPassword'=>$InvestorPassword,
                'tag'=>$tag,
                'regAPIstatus' => $WebService->request_status,
                'success' => TRUE,
            );
            return $webserviceData;
        } else {
            $webserviceData=array(
                'regAPIstatus' => $WebService->request_status,
                'success' => FALSE,
            );
            return $webserviceData;
        }
    }

    public function checkAffiliateCode_viaURL($code)
    {

        $affiliate_code = $code;
        $this->load->model('account_model');
        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($affiliate_code);
        if ($getAccountNumberByAffiliateCode) {
            $error = false;
//                    print_r($getAccountNumberByAffiliateCode);exit;
            $message = $getAccountNumberByAffiliateCode;
        } else {
            $error = true;
            $message = "Please enter valid code.";
        }

        $data = array(
            'error' => $error,
            'message' => $message
        );
        return $data;
    }

    public function index_memory_test()
    { exit();
        set_time_limit(3000);
        @ini_set('max_execution_time', 3000);


        if (isset($_SESSION['redirect'])) {redirect($_SESSION['redirect']);}
        if ($this->session->userdata('logged')) {
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->session->set_userdata(   array('email_live'=>$this->session->userdata('email'),'full_name_live'=>$this->session->userdata('full_name')) );
            $user_details_emailname = $this->user_model->getFirstUserDetailsByEmailAndName($this->session->userdata('email'),$this->session->userdata('full_name') );
            $trading_experience = explode(',', $user_details_emailname['experience']);
            $trading_experience_value = array();
            if (count($trading_experience) > 2) {
                foreach ($trading_experience as $experience) {
                    $trading_experience_value[] = $experience?true:false;
                }
            } else {
                $trading_experience_value = array(false, false, false);
            }
            $user_details['trading_experience_value'] = $trading_experience_value;
            $data['user_details'] = $user_details;
            $data['user_details_emailname'] =  $user_details_emailname;
            $data['api_details_emailname'] = $this->getUserdetails($user_details_emailname['account_number']);
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(), isset($user_details['employment_status']) ? $user_details['employment_status'] : 0);
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getIndustry(), isset($user_details['industry']) ? $user_details['industry'] : null);
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome(), isset($user_details['estimated_annual_income']) ? $user_details['estimated_annual_income'] : 3);
            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth(), isset($user_details['estimated_net_worth']) ? $user_details['estimated_net_worth'] : 3);
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), isset($user_details['investment_knowledge']) ? $user_details['investment_knowledge'] : 1);
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel(), isset($user_details['education_level']) ? $user_details['education_level'] : null);
            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), isset($user_details['trade_duration']) ? $user_details['trade_duration'] : null);
            $data['postal_code'] = FXPP::getVisitorInfo()->postal_code;
            $user_aff_code = $this->account_model->getUserReferralCode($this->session->userdata('user_id'));
            $data['aff_code'] = $user_aff_code['referral_affiliate_code'];

            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
            $user_country = FXPP::getUserCountryCode();
            if (in_array(strtoupper($user_country), array('PL'))) {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details['leverage']!="")?$user_details['leverage'] : "1:50");
            } else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(),($user_details['leverage']!="")?$user_details['leverage'] : "1:50");
            }
            if ($_SESSION['temp_country'] == "PL") {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage_internal_registration(null, 100), ($user_details['leverage']!="")?$user_details['leverage'] : "1:50");
            }
            if(isset( $_SESSION['ru_ctm_links'])){
                switch($_SESSION['ru_ctm_links']){
                    case 'ru_posting':
                        $data['account_currency_base'] = $this->general_model->selectOptionList( array('RUB'=>'RUR'),"RUR"); // modified
                        break;
                }
            }else{
                $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase_v2(), isset($user_details['mt_currency_base']) ? $user_details['mt_currency_base'] : "USD" );
            }
            if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $_SESSION['isMicro'] =='1' || $this->input->post('mt_account_set_id', true) == '4') {
                $data['account_type'] = $this->general_model->selectOptionList(array('4'=>'Forexmart Micro Account'),'4');
                $data['account_currency_base'] = $this->general_model->selectOptionList(array('USD' => 'USD', 'EUR' => 'EUR'), "USD");
                $data['micro'] = 1;
                unset($_SESSION['isMicro']);
            }
//            if (IPLoc::Office()) {
//                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries_localize(), isset($user_details['country']) ? $user_details['country'] : $this->country_code);
//            } else {
            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getAllCountries(), isset($user_details_emailname['country']) ? $user_details_emailname['country'] : $this->country_code);
//            }
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType(), isset($user_details['mt_account_set_id']) ? $user_details['mt_account_set_id'] : 1);




            $this->form_validation->set_rules('street', 'Street', 'trim|required|max_length[128]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[32]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|max_length[16]|xss_clean|callback_character_check');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

            $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');
            $this->benchmark->mark('t1');
            if ($this->form_validation->run()){
                $country = $this->input->post('country', true);
                $illicit_country = unserialize(ILLICIT_COUNTRIES);
                $this->benchmark->mark('t2');
                if (!in_array(strtoupper(trim($country)), $illicit_country)) {
                    $login_type = 0; //login_type 0 = client user / 1 = partner user
                    $use_username = $this->config->item('use_username', 'tank_auth');
                    $email_activation = $this->config->item('email_activation', 'tank_auth');
                    $password = $this->autoPassword(8);
                    $this->benchmark->mark('t3');
                    $swap_free = $this->input->post('swap_free', true);
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $phone_password = FXPP::RandomizeCharacter(7);
                    $this->benchmark->mark('t4');
                    $hidden_input_affiliate_code = $this->input->post('hidden_affiliate_code', true);
                    $getCode  = $this->input->post('affiliate_code', true);
                    $this->benchmark->mark('t5');
                    $input_affiliate_code = isset($getCode)?$this->checkAffiliateCode_viaURL($getCode)['error']==false?$getCode:'':'';
                    $this->benchmark->mark('t6');
                    if(IPLoc::isChinaIP() || $country == 'CN' || FXPP::html_url() == 'zh' ){
                        $this->benchmark->mark('t7');
                        $this->session->set_userdata('isChina', '1');
                        if(!empty($input_affiliate_code) && !empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($input_affiliate_code) && empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($hidden_input_affiliate_code) && empty($input_affiliate_code) ){
                            $new_aff_code = $hidden_input_affiliate_code;
                        }else{
                            //$new_aff_code = 'EILQY';//FXPP-8533
                            $new_aff_code = ''; //FXPP-12933
                        }
                    }else{
                        if(!empty($input_affiliate_code) && !empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($input_affiliate_code) && empty($hidden_input_affiliate_code) ){
                            $new_aff_code = $input_affiliate_code;
                        }else if(!empty($hidden_input_affiliate_code) && empty($input_affiliate_code) ){
                            $new_aff_code = $hidden_input_affiliate_code;
                        }else{
                            $new_aff_code = '';
                        }
                        $this->session->set_userdata('isChina', '0');
                    }
                    $this->benchmark->mark('t8');
                    /*  =============== Spread project  setting ================================ */
                    $speardGroup = $this->input->cookie('forexmart_account_type');  // Here store spread of value using affiliateChecker hook.
                    $mt_set_id =$this->input->post('mt_account_set_id',true);
                    $speardGroup = $mt_set_id==1? "refSt".$speardGroup:"refZe".$speardGroup;

                    if($mt_set_id==1){
                        $speardGroup = "refSt".$speardGroup;
                    }elseif($mt_set_id==2) {
                        $speardGroup = "refZe" . $speardGroup;
                    }
//                    }elseif($mt_set_id==4){
//                        $speardGroup = "refStC".$speardGroup;  // Macro account type
//                    }
                    if(!$this->general_model->getGroupSpard($speardGroup)){
                        if($mt_set_id==4) {
                            $groupCurrency = $this->general_model->getGroupCurrency((int) $mt_set_id, $this->input->post('mt_currency_base', true), $swap_free) . '-cn1';
                        }else{

                            $groupCurrency = $this->general_model->getGroupCurrency((int)$mt_set_id, $this->input->post('mt_currency_base',true), $swap_free).'1';
                        }
                    }else{
                        $groupCurrency = $speardGroup;
                    }

                    // affiliate referrral get
                    // $input_affiliate_code = $this->input->post('affiliate_code', true);
                    $input_affiliate_code = $new_aff_code;
                    $affiliate_code_logs = self::getAffiliateLogs($input_affiliate_code);
                    $affiliate_referral_codes = ':' . str_replace('-', ':', $affiliate_code_logs);
                    // webserive registration require data
                    $service_data = array(
                        'address' => $this->input->post('street', true),
                        'city' => $this->input->post('city', true),
                        'country' => $this->general_model->getCountries($this->input->post('country', true)),
                        'email' => $this->session->userdata('email_live'),
                        'group' => $groupCurrency,
                        'leverage' => count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true),
                        'name' => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone', true),
                        'state' => $this->input->post('state', true),
                        'zip_code' => $this->input->post('zip', true),
                        'phone_password' => $phone_password,
                        'comment' => strtolower(FXPP::html_url()) . ':' . $this->input->ip_address() . $affiliate_referral_codes
                    );
                    $webserviceData = $this->webServiceSaveliveAccount($service_data);

                    if($webserviceData['success'])
                    {

                        $user_inser_data = $this->tank_auth->create_user(
                            $use_username ? $this->form_validation->set_value('username') : '',
                            $this->session->userdata('email_live'),
                            $password,
                            $email_activation, 1, $login_type);
                        $user_id = $user_inser_data['user_id'];
                        $user_data = array( 'user_id' => $user_id,);
//                        $this->session->set_userdata($user_data);
                        $data['random_alpha_string_analytics'] = '';
                        $data['random_alpha_string_analytics'] = 'z42esbsn4yqu2p';
                        $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

                        if(IPLoc::Office()){

                            $acc_status = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='accountstatus');
                            if($user_details_emailname['accountstatus'] == 1){
                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 1,
                                    'type' => 1,
                                    'accountstatus' => 1,
                                    'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                                    'registration_location'=>6,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_10',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                            }else{

                                $data['save_hash'] = array(
                                    'first_login_hash' => $data['random_alpha_string_analytics'],
                                    'first_login_stat' => 1,
                                    'auto_verified' => 0,
                                    'type' => 1,
                                    'accountstatus' => 0,
                                    'registration_location'=>6,
                                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                    "accountstatus_update_location"=>'my_11',
                                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                                );
                                $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                            }

                        }else{


                            $data['save_hash'] = array(
                                'first_login_hash' => $data['random_alpha_string_analytics'],
                                'first_login_stat' => 1,
                                'auto_verified' => 1,
                                'type' => 1,
                                'accountstatus' => 1,
                                'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                                'registration_location'=>6,
                                "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                                "accountstatus_update_location"=>'my_12',
                                "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                            );
                            $this->general_model->update('users', 'id', $user_id, $data['save_hash']);
                        }

                        $user_data = array(  'analytic_hash' => $data['random_alpha_string_analytics'], );
//                        $this->session->set_userdata($user_data);
                        $profile = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'user_id' => $user_id,
                            'country' => $this->input->post('country', true),
                            'street' => $this->input->post('street', true),
                            'city' => $this->input->post('city', true),
                            'state' => $this->input->post('state', true),
                            'zip' => $this->input->post('zip', true),
                            'dob' => $this->input->post('dob', true),
                            'dob_back' => $this->input->post('dob', true)
                        );


                        if ($this->input->post('country', true) == 'PL') {
                            $_SESSION['temp_country'] = 'PL';
                        }
                        $this->general_model->insert('user_profiles', $profile); // Insert into user profile data.
                        $this->benchmark->mark('t6a');
                        /*  =============== End Spread project  setting ================================ */
                        // track registration link
                        $this->load->helpers('url');
                        $reg_date_cur = FXPP::getServerTime();
                        $reg_link_details = array(
                            'registration_link' => FXPP::my_url('registration/open_live_account'),
                            'user_id' => $user_id,
                            'street' => $this->input->post('street', true),
                            'date_created' => FXPP::getServerTime(),
                        );
                        $this->general_model->insert('track_registration', $reg_link_details);
                        $this->benchmark->mark('t6b');
                        // Save Affiliate Link
                        $this->benchmark->mark('t1a');
                        $generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
                        $affiliate_code_data = array(
                            'users_id' => $user_id,
                            'affiliate_code' => $generateAffiliateCode
                        );
                        $this->benchmark->mark('t1b');
                        $this->general_model->insert('users_affiliate_code', $affiliate_code_data);
                        $this->benchmark->mark('t1c');
                        // mt accounts information with webservice return
                        //$RegDate = FXPP::getServerTime();
                        $this->benchmark->mark('t13');
                        if(IPLoc::Office()){
                            $mt_account = array(
                                'leverage' => $this->input->post('leverage', true),
                                'registration_leverage' => $this->input->post('leverage', true),
                                'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                                'mt_currency_base' => $this->input->post('mt_currency_base', true),
                                'mt_account_set_id' => $this->input->post('mt_account_set_id', true),
                                'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                'registration_time' => FXPP::getServerTime(),
                                'user_id' => $user_id,
                                'mt_type' => 1,
                                // 'mt_status' => 1,
                                'swap_free' => $swap_free,
                                'account_number' => $webserviceData['AccountNumber'],
                                'trader_password' =>  $webserviceData['TraderPassword'],
                                'investor_password' =>  $webserviceData['InvestorPassword'],
                                'phone_password' => $phone_password,
                                'registry_method'=> $webserviceData['tag'],
                                'group'=>$groupCurrency
                            );
                            if($user_details_emailname['accountstatus'] == 1){
                                $mt_account['mt_status']=1;
                            }

                            $this->general_model->insert('mt_accounts_set', $mt_account);
                            $this->benchmark->mark('t14');
                        }else{

                            $mt_account = array(
                                'leverage' => $this->input->post('leverage', true),
                                'registration_leverage' => $this->input->post('leverage', true),
                                'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
                                'mt_currency_base' => $this->input->post('mt_currency_base', true),
                                'mt_account_set_id' => $this->input->post('mt_account_set_id', true),
                                'registration_ip' => $_SERVER['REMOTE_ADDR'],
                                'registration_time' => FXPP::getServerTime(),
                                'user_id' => $user_id,
                                'mt_type' => 1,
                                'mt_status' => 1,
                                'swap_free' => $swap_free,
                                'account_number' => $webserviceData['AccountNumber'],
                                'trader_password' =>  $webserviceData['TraderPassword'],
                                'investor_password' =>  $webserviceData['InvestorPassword'],
                                'phone_password' => $phone_password,
                                'registry_method'=> $webserviceData['tag'],
                                'group'=>$groupCurrency
                            );
                            $this->general_model->insert('mt_accounts_set', $mt_account);
                        }
                        $this->benchmark->mark('t7');
                        /* MICRO ACCOUNTS */
                        if(isset($_SESSION['isMicro']) && $_SESSION['isMicro'] != '' || $this->input->post('mt_account_set_id', true) == '4') {
                            $data_micro = array('micro' => 1);
                            $this->general_model->update_micro((int)$user_id, $data_micro);//UPDATE MICRO TO 1 in users
                            unset($_SESSION['isMicro']);
                        }
                        $this->benchmark->mark('t15');
                        $this->benchmark->mark('t2a');
                        /* END MICRO ACCOUNTS */
                        $user_update_d=array(
                            'created' => FXPP::getServerTime(),
                            'type' => 1
                            );
                    
                        $this->general_model->updatemy($table = "users", "id", $user_id,$user_update_d);
                        
                        $this->benchmark->mark('t2b');
                        $getCookieAffiliate = $this->input->cookie('forexmart_affiliate');
                        $forexmart_affiliate = empty($input_affiliate_code) ? $getCookieAffiliate : $input_affiliate_code;
                        if (!empty($forexmart_affiliate)) {
                            $this->load->model('account_model');
                            $this->benchmark->mark('t2c');
                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($forexmart_affiliate);
                            $this->benchmark->mark('t2d');
                            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];
                            if (!empty($AgentAccountNumber)) {
                                $service_data = array(
                                    'AccountNumber' => $webserviceData['AccountNumber'],
                                    'AgentAccountNumber' => $AgentAccountNumber
                                );
                                $this->benchmark->mark('t2e');
                                $this->benchmark->mark('t16');
                                $webservice_config = array('server' => 'live_new');
                                $WebService = new WebService($webservice_config);
                                $WebService->SetAccountAgent($service_data);
                                $this->benchmark->mark('t2f');
                                if ($WebService->request_status === 'RET_OK') {
                                    $referral_data = array( 'referral_affiliate_code' => $forexmart_affiliate);
                                    $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $user_id, $referral_data);
                                    $this->benchmark->mark('t2g');
                                    $this->benchmark->mark('t17');
                                }else {
                                    $agent_data = array(
                                        'user_id' => $user_id,
                                        'account_number' => $webserviceData['AccountNumber'],
                                        'agent_account_number' => $AgentAccountNumber
                                    );
                                    $this->account_model->insertFailedSetAgent($agent_data);
                                    $this->benchmark->mark('t2h');
                                }
                            }
                        }

                        // Invite friend status update
                        $this->load->model('invite_model');
                        $email_user = $this->session->userdata('email_live');
                        $inv_ref = $forexmart_affiliate;
                        // $ref_code = $this->invite_model->getInvitedAffiliateCode($email_user);
                        $ref_code = $this->invite_model->getInvitedRefCode($email_user,$user_id);
                        $tbl_code = 'ref_number';
                        $tbl_email = 'email';
                        $invite_data = array(
                            'status' => 8,
                            'user_id_after_registration' => $user_id
                        );
                        if($inv_ref == $ref_code){
                            $this->invite_model->updateInviteDetails('invite_friends', $inv_ref, $tbl_code,$email_user,$tbl_email,$invite_data);
                        }
                        // end invite friend status update
                        $trading_experience = array(
                            'investment_knowledge' => $this->input->post('investment_knowledge', true),
                            'risk' => $this->input->post('risk', true),
                            'experience' => $this->input->post('experience', true),
                            'user_id' => $user_id,
                            'technical_analysis' => $this->input->post('technical_analysis', true),
                            'trade_duration' => $this->input->post('trade_duration', true),
                        );
                        $this->general_model->insert('trading_experience', $trading_experience);
                        $employment_detail = array(
                            'employment_status' => $this->input->post('employment_status', true),
                            'industry' => $this->input->post('industry', true),
                            'source_of_funds' => $this->input->post('source_of_funds', true),
                            'estimated_annual_income' => $this->input->post('estimated_annual_income', true),
                            'estimated_net_worth' => $this->input->post('estimated_net_worth', true),
                            'politically_exposed_person' => $this->input->post('politically_exposed_person', true),
                            'education_level' => $this->input->post('education_level', true),
                            'us_resident' => $this->input->post('us_resident', true),
                            'us_citizen' => $this->input->post('us_citizen', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('employment_details', $employment_detail);
                        $contacts_data = array(
                            'phone1' => $this->input->post('phone', true),
                            'user_id' => $user_id
                        );
                        $this->general_model->insert('contacts', $contacts_data);
                        // send email  to user email
                        $email_data = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'email' => $this->session->userdata('email_live'),
                            'password' => $password,
                            'account_number' => $mt_account['account_number'],
                            'trader_password' => $mt_account['trader_password'],
                            'investor_password' => $mt_account['investor_password'],
                            'phone_password' => $mt_account['phone_password'],
                        );
                        $subject = "ForexMart MT4 Live Trading Account details";
                        $config = array(   'mailtype' => 'html' );
                        $isSendSuccess = $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,$config);
                        unset($_SESSION['ru_ctm_links']);
                        unset($_SESSION['FXPP6635']);

                        /*FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP*/
                        if(IPLoc::Office_for_NDB()){
                            FXPP::activate_trading_API($user_id,$webserviceData['AccountNumber']);
                        }
                        /* FXPP-6539 Allow accounts to be credited with NDB without the need for verification in FXPP */
                        $this->dailyCountryReport($user_id); // sent real time to the email groups
//                        $info_demo_account=array(
//                            'country' => $this->input->post('country', true),
//                            'user_id' => $user_id,
//                            'account_type' => $this->input->post('mt_account_set_id', true),
//                            'amount' => $this->input->post('amount', true) ? $this->input->post('amount', true) : 0,
//                            'currency' => $this->input->post('mt_currency_base',true),
//                            'address' => $this->input->post('street', true),
//                            'city' => $this->input->post('city', true),
//                            'email' => $this->session->userdata('email_live'),
//                            'group' => $groupCurrency,
//                            'leverage' => $this->input->post('leverage', true),
//                            'name' => $this->session->userdata('full_name_live'),
//                            'phone_number' => $this->input->post('phone', true),
//                            'state' => $this->input->post('state', true),
//                            'zip_code' => $this->input->post('zip', true),
//                            'phone_password' => $phone_password,
//                            'technical_analysis' =>$this->input->post('technical_analysis', true)
//                        );
//                        $this->autoCreateDemoAccount($info_demo_account);
                        $data['success'] = true;
                        $data['info'] = $mt_account;


                       echo  "t1-t2=". $this->benchmark->elapsed_time('t1', 't2');
                        echo "t2-t3= ".$this->benchmark->elapsed_time('t2', 't3');
                        echo " t3-t4=".$this->benchmark->elapsed_time('t3', 't4');
                        echo "t4-t5=".$this->benchmark->elapsed_time('t4', 't5');
                        echo "t5-t6=".$this->benchmark->elapsed_time('t5', 't6');
                        echo "t6-t7=".$this->benchmark->elapsed_time('t6', 't7');
                        echo "t7-t8=".$this->benchmark->elapsed_time('t7', 't8');

                        echo "<br>";
                        echo "t2a-t2b=".$this->benchmark->elapsed_time('t2a', 't2b');
                        echo "t2b-t2c=".$this->benchmark->elapsed_time('t2b', 't2c');
                        echo "t2c-t2d=".$this->benchmark->elapsed_time('t2c', 't2d');
                        echo "t2d-t2e".$this->benchmark->elapsed_time('t2d', 't2e');
                        echo "t2e-t2f".$this->benchmark->elapsed_time('t2e', 't2f');
                        echo "t2f-t2g".$this->benchmark->elapsed_time('t2f', 't2g');
                        echo "<br>";
                        echo "t1a-t1b=".$this->benchmark->elapsed_time('t1a', 't1b');
                        echo "t1b-t1c=".$this->benchmark->elapsed_time('t1b', 't1c');


                       // echo json_encode( $time);
                        exit();
                    }
                    else
                    {
                        $data['errors'] = "Oops, something went wrong, Please try again in a few minutes.";
                        $data['success'] = false;
                        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'error' => 'Oops, something went wrong, Please try again in a few minutes.'.$groupCurrency)));
                    }
                } else {
                    $data['errors'] = "Country is not currently available. Try it again.";
                    $data['success'] = false;
                }
            }else{
                $data['errors'] = "Please fill required fields.";
            }
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('register_live2', $data);
        } else {
            if ($_GET['login'] == 'partner') {
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }


    public function update_account_group_For_Bangladesh($user_id,$agent,$groupcode){

        $this->load->model('account_model');
        $account_get = $this->account_model->getAccountByUserId($user_id);
        $isSet = 0;
        $webservice_config = array(
            'server' => 'live_new'
        );
        $bangladesh_clients = array(
            '242400',
            '242700',
            '243340',
            '247429',
            '249640',
            '250598',
            '255208',
            '255223',
            '265078',
            '266222',
            '241800',
           // '209874', //test
        );

        if(!empty($agent) && $account_get['mt_currency_base'] == 'USD' ) {
            if (in_array($agent,$bangladesh_clients)) {
                $groupCurrency = $this->general_model->getGroupCurrency($account_get['mt_account_set_id'], $account_get['mt_currency_base'], $account_get['swap_free']);
                $Group2char = substr($groupCurrency, 0, 2); //return 1st two char
                if($Group2char == 'D-'){
                  //  $groupCurrency = substr($groupCurrency, 2); //remove 'D-'  // FXPP-9776
                }
                $groupCurrency .= '-ibBD1';
                $account_info2 = array(
                    'iLogin'   => $account_get['account_number'],
                    'strGroup' => $groupCurrency
                );

//                $WebServiceChangeAccountGroup = new WebService($webservice_config);
//                $WebServiceChangeAccountGroup->open_ChangeAccountGroup($account_info2);

                $WebServiceChangeAccountGroup = FXPP::SetAccountGroup($account_get['account_number'], $groupCurrency);

                if ($WebServiceChangeAccountGroup->request_status === 'RET_OK') {
                    $isSet = 1;
                }
                $resApi = $WebServiceChangeAccountGroup->request_status;
            }else{
                $resApi = 'AGENT_NOT_IN_THE_LIST';
            }
        }else{
            $resApi = 'ACCOUNT_HAS_NO_AGENT OR NOT USD';
        }


        $set_group_data = array(
            'api_status_getAgent' => 'REGISTER',
            'api_status_setGroup' => $resApi,
            'date_updated' => FXPP::getCurrentDateTime(),
            'account_number' => $account_get['account_number'],
            'agent_account_number' => $agent,
            'old_group_code' => $groupcode,
            'newly_set_group_code' => $groupCurrency,
            'isAgentBangladesh' => $isSet,
        );

        //save log
        $this->general_model->insertmy($table = 'group_codes_log',$set_group_data);

    }

    public function dailyCountryReport_testing()
    {

        $user_id = 257965;
        $this->load->model('account_model');
        $this->load->model('general_model');
        if ($row = $insert_data['client_country'] = $this->account_model->getClientInfoByUserId($user_id)) {
            $c_code = $row[0]->country;
            $insert_data['country'] = $this->general_model->getCountries();
            $insert_data['country']["GB','IE"] = "UK and Ireland ";
            $insert_data['country']["AT','DE"] = "Austria and Germany ";
            $insert_data['country']["AM','BY','KZ','KG','MD','RU','TJ','TM','UA"] = "Russia and CIS";

            $to_email = array(
                "ES" => 'clients_spain_daily_1@forexmart.com',
                "AT" => 'clients_germany_daily_1@forexmart.com',
                "DE" => 'clients_germany_daily_1@forexmart.com',
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
                "PL" => 'clients_poland_daily_1@forexmart.com',
                "SK" => 'clients_czech.slovak_daily_1@forexmart.com',
                "CZ" => 'clients_czech.slovak_daily_1@forexmart.com',
                "IN" => "clients_india_daily_1@forexmart.com",
                "PK" => "clients_pakistan_daily_1@forexmart.com",
                "CF" => "clients_africa_daily_1@forexmart.com",
                "JM" => "clients_jamaica_daily_1@forexmart.com",
                "AU" => "clients_australia_daily_1@forexmart.com",
                "NZ" => "clients_australia_daily_1@forexmart.com",
                "MT" => "clients_malta_daily_1@forexmart.com",
                "SG" => "clients_singapore_daily_1@forexmart.com",
                "UZ" => "clients_uzbekistan_daily_1@forexmart.com",


            );
            if (isset($to_email[$c_code])) {
                if ($to_email[$c_code] == "clients_russia_daily_1@forexmart.com") {
                    if($exGroup = $this->general_model->where("cis_group_mail",array('email'=>$row[0]->email))){
                        $insert_data['email'] = "clients_russia_daily_".$exGroup->row()->group_id."@forexmart.com";
                    }else{
                        if ($this->account_model->getCISRegPerDay() % 2 == 0) {
                            $insert_data['email'] = "clients_russia_daily_1@forexmart.com";
                            $this->general_model->insertmy('cis_group_mail',array('email'=>$row[0]->email,'group_id'=>1));
                        } else {
                            $insert_data['email'] = "clients_russia_daily_2@forexmart.com";
                            $this->general_model->insertmy('cis_group_mail',array('email'=>$row[0]->email,'group_id'=>2));
                        }
                    }
                } else {
                    $insert_data['email'] = $to_email[$c_code];
                }
            } else {
                return true;
                $insert_data['email'] = "german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com";
            }
            $insert_data['subject'] = $insert_data['email']."Clients from " . $insert_data['country'][$c_code] . " on  " . date('Y-m-d');
            $config = array(
                'mailtype' => 'html'
            );
            echo "<pre>";
            print_r($insert_data);
            print_r($row);
            $this->load->library('email');
            if ($config != null) {  $this->email->initialize($config); }
            $this->SMTPDebug = 1;
            $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
            $this->email->to('bug.fxpp@gmail.com');
            if (isset($to_email[$c_code])) {
                $this->email->bcc(',bug.fxpp@gmail.com');
            } else {
                $this->email->bcc('bug.fxpp@gmail.com');
            }
            $this->email->subject($insert_data['subject']);
            $this->email->message($this->load->view('email/realtime_client_report', $insert_data, TRUE));
            $this->email->send();
        }
    }


    public function appropriateness_test(){

        if(!IPLoc::Office()){redirect('');}

        $data['metadata_description'] = lang('mya_dsc');
        $data['metadata_keyword'] = lang('mya_kew');

        $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), isset($user_details['investment_knowledge']) ? $user_details['investment_knowledge'] : 1);
        $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), isset($user_details['trade_duration']) ? $user_details['trade_duration'] : null);
        $data['number_of_trades'] = $this->general_model->selectOptionList($this->general_model->getNumberMonthlyConnectedTradedAnswer(), isset($user_details['number_of_trades']) ? $user_details['number_of_trades'] : null);
        $data['cfd_equity_stop_out_level'] = $this->general_model->selectOptionList($this->general_model->getCFDPositionStopOutLevelAnswer(), isset($user_details['cfd_equity_stop_out_level']) ? $user_details['cfd_equity_stop_out_level'] : null);
        $data['cfd_higher_leverage'] = $this->general_model->selectOptionList($this->general_model->getCFDTradingWithHigherLeverageAnswer(), isset($user_details['cfd_higher_leverage']) ? $user_details['cfd_higher_leverage'] : null);
        $data['stop_out_level_50'] = $this->general_model->selectOptionList($this->general_model->getStopOutLevel50PercentAnswer(), isset($user_details['stop_out_level_50']) ? $user_details['stop_out_level_50'] : null);
        $data['average_trans_size'] = $this->general_model->selectOptionList($this->general_model->getAverageTransactionSizeAns(), isset($user_details['average_trans_size']) ? $user_details['average_trans_size'] : null);
        $data['margin'] = $this->general_model->selectOptionList($this->general_model->getReqMarginAns(), isset($user_details['margin']) ? $user_details['margin'] : null);
        $data['buy_lots'] = $this->general_model->selectOptionList($this->general_model->getBuyLotsAns(), isset($user_details['buy_lots']) ? $user_details['buy_lots'] : null);

        $this->template->title(lang('mya_tit'))
            ->append_metadata_css('<link rel="stylesheet" href="' . $this->template->Css() . 'select2-bootstrap.css">')
            ->append_metadata_js('')
            ->set_layout('internal/main')
            ->build('appropriateness_test', $data);

    }


    public function testAPI(){
       $res = $this->getUserdetails($_SESSION['account_number']);
        var_dump($res['RegDate']);
        //var_dump($res);
    }
}