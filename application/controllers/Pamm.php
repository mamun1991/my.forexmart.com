<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pamm extends MY_Controller{

    public function __construct(){

        parent::__construct();
        $this->lang->load('pamm');
        $this->load->model('General_model');
        $this->g_m = $this->General_model;
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('PammService');
        $this->load->library('WebService');
    }


    private $webservice_config = array( 'server' => 'pamm' );
    private $errorWebservice = array( 'error' => '1' );
    
    public function index(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }
        $data['active_tab']='pamm';
        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $nav['registered'] = False;
        $data['deactivated'] = False;
        $data['deact_option'] = True;

        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $PiTi =(array) $PammInfo['TraderInfo'];
                            $r_t_p = array(
                                'AccountName'=>$PiTi['AccountName'],
                                'partner_share'=>$PiTi['AffiliateShare'],
                                'description'=>$PiTi['DescEnglish'],
                                'description_japanese'=>$PiTi['DescriptionJapanesse'],
                                'description_polish'=>$PiTi['DescriptionPolish'],
                                'description_russian'=>$PiTi['DescriptionRussian'],
                                'forum_topic'=>$PiTi['ForumLink'],
                                'email_alerts'=>$PiTi['HasEmailAlerts'],
                                'sms_alerts'=>$PiTi['HasSMSAlerts'],
                                'icq'=>$PiTi['Icq'],
                                'confirm_investement_refund'=>$PiTi['IsConfirmInvestmentRefund'],
                                'deactivatepamm'=>($PiTi['IsDeactivated']==True)?1:0,
                                'show_account_name'=>$PiTi['IsShowAccountName'],
                                'is_auto_investment_agree'=>$PiTi['IsInvestmentAutoAgree'],
                                'trader_hidetradesforall'=>$PiTi['IsShowActiveTrades'],
                                'show_icq'=>$PiTi['IsShowIcq'],
                                'show_skype'=>$PiTi['IsShowSkype'],
                                'show_yahoo'=>$PiTi['IsShowYahoo'],
                                'project_name'=>$PiTi['ProjectName'],
                                'skype'=>$PiTi['Skype'],
                                'StartTimeMonitoring'=>$PiTi['StartTimeMonitoring'],
                                'SystemNotificationLanguage'=>$PiTi['SystemNotificationLanguage'],
                                'yahoo'=>$PiTi['Yahoo'],
                            );
                            $data['investor_name'] = $PiTi['AccountName'];

//                            echo 'deactivate status'. $PiTi['IsDeactivated'];
                            $data['deactivated'] = ($PiTi['IsDeactivated']==True)?1:0;
                            $data['trader_registration']=true;
                            $nav['registered']= true;
                            break;
                        case 1 :
                            // Investor
                            $PiIi =(array) $PammInfo['InvestorInfo'];
                            $r_i_p = array(
                                'investorname'=> $PiIi['AccountName'],
                                'investoricq'=> $PiIi['IcqId'],
                                'confirminvestmentrefund'=> $PiIi['IsConfirmInvestmentRefund'],
                                'deactivatepamm'=> ($PiIi['IsDeactivated']==True)?1:0,
                                'skype'=> $PiIi['Skype'],
                                'cfglang'=> $PiIi['SystemNotificationLanguage'],
                                'investorskype'=> '',
                                'showskype'=> '',
                                'showicq'=> '',
                                'yahoo'=> '',
                                'showyahoo'=> '',
                                'icq'=> $PiIi['IcqId'],
                            );
                            $data['deactivated'] = ($PiIi['IsDeactivated']==True)?1:0;
                            $data['investor_registration']=true;
                            $nav['registered']= true;
                        $data['investor_name'] = $PiIi['AccountName'];

                            break;
                        case 2 :
                            // Partner
                            $PiPi =(array) $PammInfo['PartnerInfo'];
                            $r_p_p = array(
                                'Accountname'=> $PiPi['AccountName'],
                                'cfglang'=> $PiPi['ConfigLanguage'],
                                'icq'=> $PiPi['IcqId'],
                                'confirminvestmentrefund'=> $PiPi['IsConfirmInvestmentRefund'],
                                'deactivatepamm'=>($PiPi['IsDeactivated']==True)?1:0,
                                'skype'=> $PiPi['Skype'],
                                'showskype'=> '',
                                'yahoo'=> '',
                                'showyahoo'=> '',
                            );
                        $data['investor_name'] = $PiPi['AccountName'];

                            $data['deactivated'] = ($PiPi['IsDeactivated']==True)?1:0;
                            $data['partner_registration']=true;
                            $nav['registered']= true;

                            break;
                        default:
                            //account number not registered.
                            $r_p_p=false;
                            $r_i_p=false;
                            $r_t_p=false;
                        //echo 'not registered';
                    }
                    break;
                        //echo 'not registered';

            }
        }

        $data['get'] = $this->input->get(NULL, TRUE);
        $type = $this->input->post('type',true);
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $nav['tab']=1;
        $nav['trader']= false;

        if($type){
            switch($type) {
                case 'partner':
                    $this->form_validation->set_rules('partnername', 'Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('partneremail', 'E-mail', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('partnerinvestorpassword', 'Investor Password', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('partnertraderpassword', 'Trader Password', 'trim|required|xss_clean');

                    $this->form_validation->set_rules('partnerskype', 'Skype', 'trim|xss_clean');
                    $this->form_validation->set_rules('partnericq', 'ICQ', 'trim|xss_clean');

                    $this->form_validation->set_rules('partnercir', 'Confirm investment withdrawal', 'trim|xss_clean');
                    $this->form_validation->set_rules('partnerlangauge', 'Language', 'trim|xss_clean');

                    break;
                case 'investor':
                    $this->form_validation->set_rules('investorname', 'Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('investorskype', 'Skype', 'trim|xss_clean');
                    $this->form_validation->set_rules('investoricq', 'ICQ', 'trim|xss_clean|max_length[9]');
//                    $this->form_validation->set_rules('investoryahoo', 'Yahoo', 'trim|xss_clean');
                    $this->form_validation->set_rules('investorlangauge', 'Investor Language','trim|xss_clean');

//                    to add validations
//                    $this->form_validation->set_rules('investorciw', 'Confirm investment withdrawal','trim|xss_clean');
//                    $this->form_validation->set_rules('investor_checkbox_deactivate', 'Deactivate Pamm System','trim|xss_clean');
                    break;
                case 'trader':
                    $this->form_validation->set_rules('traderprojectname', 'Project Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('traderdescEN', 'Description in English ', 'trim|xss_clean|max_length[1500]');
                    $this->form_validation->set_rules('traderdescRU', 'Description in Russian', 'trim|xss_clean|max_length[1500]');
                    $this->form_validation->set_rules('traderdescJP', 'Description in Japanese', 'trim|xss_clean|max_length[1500]');
                    $this->form_validation->set_rules('traderdescPL', 'Description in Polish', 'trim|xss_clean|max_length[1500]');
//                    to add validations

//                    $this->form_validation->set_rules('traderSkype', 'Skype', 'trim|xss_clean');
//                    $this->form_validation->set_rules('sel_name_showhide', 'Name Option', 'trim|xss_clean');
//
//                    $this->form_validation->set_rules('traderSkype', 'Skype', 'trim|xss_clean');
//                    $this->form_validation->set_rules('sel_skype_showhide', 'Skype Option', 'trim|xss_clean');
//
//                    $this->form_validation->set_rules('traderIcq', 'ICQ', 'trim|xss_clean');
//                    $this->form_validation->set_rules('sel_icq_showhide', 'ICQ Option', 'trim|xss_clean');
//
//                    $this->form_validation->set_rules('traderYahoo', 'Yahoo', 'trim|xss_clean');
//                    $this->form_validation->set_rules('sel_yahoo_showhide', 'Yahoo Option', 'trim|xss_clean');
//
//                    $this->form_validation->set_rules('traderStartTime', 'Time', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_emailalerts', 'Email Alerts', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_smsalerts', 'SMS Alerts', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_approveinvestmentauto', 'Auto Approve Investments', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_hidetradesforall', 'Hide trades for all', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_langauge', 'Language', 'trim|xss_clean');
//                    $this->form_validation->set_rules('slider_reg_trader_value', 'Partner share', 'trim|xss_clean');
//                    $this->form_validation->set_rules('forumtopic', 'Forum location', 'trim|xss_clean');
//                    $this->form_validation->set_rules('trader_checkbox_deactivate', 'Deactivate', 'trim|xss_clean');
                    break;
                default:
            }
        }

        if ($this->form_validation->run()){

            switch($type){
                case 'partner':
                    $partnername = $this->input->post('partnername',true);
                    $partnerskype = $this->input->post('partnerskype',true);
                    $partnericq = $this->input->post('partnericq',true);
                    $partnerlangauge = $this->input->post('partnerlangauge',true);
                    $partnercir = $this->input->post('partnercir',true);
                    $partneryahoo = $this->input->post('partneryahoo',true);

                    $partner_investor_password = $this->input->post('partnerinvestorpassword',true);
                    $partner_trader_password = $this->input->post('partnertraderpassword',true);
                    $partner_checkbox_deactivate = $this->input->post('partner_checkbox_deactivate',true);

                    $sel_skype_showhide = $this->input->post('sel_skype_showhide',true);
                    $sel_icq_showhide = $this->input->post('sel_icq_showhide',true);
                    $sel_yahoo_showhide = $this->input->post('sel_yahoo_showhide',true);

                    $Istraderpassword = $this->checktraderpassword($partner_trader_password);

                    if ($Istraderpassword){

                        $webservice_config = array(
                            'server' => 'pamm'
                        );

                        $WebService = new WebService($webservice_config);
                        $usr_pfls = $this->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$_SESSION['user_id'],$select='*');
                        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,investor_password');
                        $usrs = $this->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='email');

                        $date = FXPP::getCurrentDateTime();
                        $datestart = DateTime::createFromFormat('Y-d-m H:i:s',$date);
                        $formbutton = $this->input->post('formbutton',true);

                        if ($formbutton=='register'){

                            $this->session->set_flashdata("partner_register", true);
                            $this->session->set_flashdata("partner_success", false);


                            $account_info = array(
                                'AccountName' => $usr_pfls['full_name'],
                                'AccountNumber' => $mt_acct_st['account_number'],
                                'BrokerId' => 0,
                                'CfgLang' => $partnerlangauge,
                                'ConfirmInvestmentRefund' => $partnercir,
                                'Icq' => $partnericq,
                                'ShowIcq' => $sel_icq_showhide,
                                'InvestorPassword'=>$mt_acct_st['investor_password'],
                                'ShowSkype' => $sel_skype_showhide,
                                'ShowYahoo' => $sel_yahoo_showhide,
                                'Skype' => $partnerskype,
                                'StartTime' => $datestart->format('Y-m-d\TH:i:s') ,
                                'TraderPassword'=>$partner_trader_password,
                                'Yahoo' => $partneryahoo,
                            );

                            $WebService->open_RegisterPammPartner($account_info);
                            $API_Response=$WebService->get_result('Message');

                            switch ($API_Response) {
                                case 'RET_OK':
                                    $db_info = array(
                                        'user_id' => $_SESSION['user_id'],
                                        'account_number' => $mt_acct_st['account_number'],
                                        'account_name' => $usr_pfls['full_name'],
                                        'brokerid' => 0,
                                        'cfglang' => $partnerlangauge,
                                        'confirminvestmentrefund' => $partnercir,
                                        'email' => $usrs['email'],
                                        'icq' => $partnericq,
                                        'showicq' => $sel_icq_showhide,
                                        'showskype' => $sel_skype_showhide,
                                        'showyahoo' => $sel_yahoo_showhide,
                                        'skype' => $partnerskype,
                                        'starttime' =>$date ,
                                        'yahoo' => $partneryahoo,
                                        'registration_status' => 1,
                                        'deactivatepamm' => 0,
                                        'api_return' => $API_Response,
                                        'reg_date' => FXPP::getCurrentDateTime()
                                    );

                                    $append_return = $this->g_m->insertmy($table='registration_partner_pamm',$data=$db_info);
                                    $this->session->set_flashdata("partner_success", true);
                                    $data['partner_registration']=true;
                                    $data['deactivated']= False;
                                    break;
                                default:

                            }

                        }elseif($formbutton=='update'){

                            $_SESSION['partner_update'] = true;
                            $_SESSION['partner_success'] = false;
                            $check=($partner_checkbox_deactivate==1)? True : False;
                            $account_info = array(
                                'pi_or_pp_account' => $mt_acct_st['account_number'],
                                'brokerId' => 0,
                                'AccountName' => $usr_pfls['full_name'],
                                'IcqId' => $partnericq,
                                'IsConfirmInvestmentRefund' => $partnercir,
                                'IsDeactivated' => $check,
                                'Skype' => $partnerskype,
                                'SystemNotificationLanguage' => $partnerlangauge,
                            );
                            $WebService = new WebService($webservice_config);
                            $WebService->open_EditPammInvestorOrPartnerProfile($account_info);
                            $API_Response = $WebService->get_all_result();
                            switch ($API_Response) {
                                case 'RET_OK':
                                    $_SESSION['partner_success'] = true;
                                    $data['partner_registration']=true;

                                    $WebServiceD = new WebService($webservice_config);
                                    $check=($partner_checkbox_deactivate==1)? True : False;
                                    $account_info = array(
                                        'iAccount' => intval($mt_acct_st['account_number']), //Account Number
                                        'brokerId' => 0, // Broker Id
                                        'IsDeact' => $check
                                    );
                                    $WebServiceD->open_DeactivateAccount($account_info);
                                    switch ($WebServiceD->result) {
                                        case  'RET_OK':
                                            $_SESSION['partner_success'] = true;
                                            break;
                                        default:
                                    }
                                    $data['deactivated']=($partner_checkbox_deactivate==1)?True:False;
                                    break;
                                default:
                            }
                        }
                    }else{
                        $data['deactivated']=False;
                        $this->session->set_flashdata("Trader_password", "Invalid trader password.");
                    }

                    $nav['registered']=1;
                    $nav['is_disable']= $data['deactivated'];
                    $nav['trader']= true;
                    $data['nav'] = $this->load->view('pamm/nav', $nav, TRUE);

                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                            <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                            <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                            <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                            <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>")
                        ->build('pamm/n_registration-partner', $data);
                    break;

                case 'investor':

                    $investorname = $this->input->post('investorname',true);
                    $investorskype = $this->input->post('investorskype',true);
                    $investoricq = $this->input->post('investoricq',true);
                    $investorlangauge = $this->input->post('investorlangauge',true);
                    $investorciw = $this->input->post('investorciw',true);
                    $investoryahoo = $this->input->post('investoryahoo',true);
                    $investor_checkbox_deactivate = $this->input->post('investor_checkbox_deactivate',true);

                    $formbutton = $this->input->post('formbutton',true);
                    $showicq = $this->input->post('sel_icq_showhide',true);
                    $showskype = $this->input->post('sel_skype_showhide',true);
                    $showyahoo = $this->input->post('sel_yahoo_showhide',true);

                    $usr_pfls = $this->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$_SESSION['user_id'],$select='*');
                    $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='*');

                    $date=FXPP::getCurrentDateTime();
                    $datestart= DateTime::createFromFormat('Y-d-m H:i:s',$date);

                        $webservice_config = array(
                            'server' => 'pamm'
                        );

                        if ($formbutton=='register'){

                            $_SESSION['investor_register'] = true;
                            $_SESSION['investor_success'] = false;

                            $WebService = new WebService($webservice_config);
                            $account_info = array(
                                'AccountName' => $usr_pfls['full_name'],
                                'AccountNumber' => $mt_acct_st['account_number'],
                                'BrokerId' => 0,
                                'CfgLang' => $investorlangauge,
                                'ConfirmInvestmentRefund' =>  ($investorciw==1)?1:0,
                                'Icq' => $investoricq,
                                'ShowIcq' => $showicq,
                                'ShowSkype' => $showskype,
                                'ShowYahoo' => $showyahoo,
                                'Skype' => $investorskype,
                                'StartTime' => $datestart->format('Y-m-d\TH:i:s'),
                                'Yahoo' => $investoryahoo,
                            );

                            $WebService->open_RegisterPammInvestor($account_info);
                            $API_Response=$WebService->get_result('Message');
                            $data['success']=false;
                            switch ($API_Response) {
                                case 'RET_OK':
                                    $db_info = array(
                                        'user_id' => $_SESSION['user_id'],
                                        'account_name' => $usr_pfls['full_name'],
                                        'account_number' => $mt_acct_st['account_number'],
                                        'brokerid' => 0,
                                        'cfglang' => $investorlangauge,
                                        'confirminvestmentrefund' => ($investorciw==1)?1:0,
                                        'icq' => $investoricq,
                                        'showicq' => $showicq,
                                        'showskype' => $showskype,
                                        'showyahoo' => $showyahoo,
                                        'skype' => $investorskype,
                                        'starttime' =>$datestart->format('Y-m-d H:i:s') ,
                                        'yahoo' => $investoryahoo,
                                        'registration_status' => 1,
                                        'api_return'=>$API_Response,
                                        'deactivatepamm'=> 0,
                                    );

                                    $append_return = $this->g_m->insertmy($table='registration_investor_pamm',$data=$db_info);

                                    $_SESSION['investor_success']=true;
                                    $data['investor_registration'] = true;
                                    break;
                                default:
                                    $_SESSION['investor_success'] = false;
                            }

                        }else if($formbutton=='update'){

                            $_SESSION['investor_update'] = true;
                            $_SESSION['investor_success'] = false;


                            $check=($investor_checkbox_deactivate==1)? True : False;
                            $account_info = array(
                                'pi_or_pp_account' => $mt_acct_st['account_number'],
                                'brokerId' => 0,
                                'AccountName' => $usr_pfls['full_name'],
                                'IcqId' => $investoricq,
                                'IsConfirmInvestmentRefund' => $investorciw,
                                'IsDeactivated' => $check,
                                'Skype' => $investorskype,
                                'SystemNotificationLanguage' => $investorlangauge,
                            );
                            $WebService = new WebService($webservice_config);
                            $WebService->open_EditPammInvestorOrPartnerProfile($account_info);
                            $API_Response = $WebService->get_all_result();
                            switch ($API_Response) {
                                case 'RET_OK':
                                    $_SESSION['investor_success'] = true;
                                    $data['investor_registration'] = true;
                                    $WebServiceD = new WebService($webservice_config);
                                    $check=($investor_checkbox_deactivate==1)? True : False;
                                    $account_info = array(
                                        'iAccount' => intval($mt_acct_st['account_number']), //Account Number
                                        'brokerId' => 0, // Broker Id
                                        'IsDeact' => $check
                                    );
                                    $WebServiceD->open_DeactivateAccount($account_info);
                                    switch ($WebServiceD->result) {
                                        case  'RET_OK':
                                            $_SESSION['investor_update'] = true;
                                            $_SESSION['investor_success'] = true;
                                            break;

                                        default:
                                    }
                                    $_SESSION['investor_update'] = true;
                                    $_SESSION['investor_success'] = true;
                                    break;
                                default:

                            }
                        }

                    $data['deactivated']=($investor_checkbox_deactivate==1)?True:False;

                    $nav['registered']=1;
                    $nav['is_disable']= $data['deactivated'];
                    $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                            <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                            <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                            <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                            <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>")

                        ->build('pamm/n_registration-investor', $data);
                    break;

                case 'trader':
                    $usr_pfls = $this->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$_SESSION['user_id'],$select='*');
                    $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='*');
                    $formbutton = $this->input->post('formbutton',true);

                    $traderlangauge = $this->input->post('trader_langauge',true);
                    $traderdescription = $this->input->post('traderdescEN',true);
                    $traderdescription_ru = $this->input->post('traderdescRU',true);
                    $traderdescription_jp = $this->input->post('traderdescJP',true);
                    $traderdescription_pl = $this->input->post('traderdescPL',true);

                    $tradername = $this->input->post('traderName',true);
                    $traderskype = $this->input->post('traderSkype',true);
                    $tradericq = $this->input->post('traderIcq',true);
                    $traderYahoo = $this->input->post('traderYahoo',true);

                    $trader_approveinvestmentauto = $this->input->post('trader_approveinvestmentauto',true);
                    $traderProjectName = $this->input->post('traderprojectname',true);

                    $Namehideshow = $this->input->post('sel_name_showhide',true);
                    $Icqhideshow = $this->input->post('sel_icq_showhide',true);
                    $Skypehideshow = $this->input->post('sel_skype_showhide',true);
                    $Yahoohideshow = $this->input->post('sel_yahoo_showhide',true);


                    // $traderStartTime = (($this->input->post('traderStartTime',true))=="")?(FXPP::getServerTime()):$this->input->post('traderStartTime',true);
                    // $traderStartTime = ($this->input->post('traderStartTime')) ?  : FXPP::getServerTime() ;
                    // $traderStartTime = DateTime::createFromFormat('Y-m-d H:i:s',$traderStartTime);

                    $traderStartTime = new DateTime($this->input->post('traderStartTime'));
                    $traderStartTime= $traderStartTime->format('Y-m-d\TH:i:s');

                    $trader_emailalerts = $this->input->post('trader_emailalerts',true);
                    $trader_cir = $this->input->post('trader_cir',true);
                    $trader_smsalerts = $this->input->post('trader_smsalerts',true);
                    $hide_trades_for_all = $this->input->post('trader_hidetradesforall',true);
                    $forumtopic = $this->input->post('forumtopic',true);

                    $slider_reg_trader_value = trim(str_replace('%','',$this->input->post('slider_reg_trader_value',true)));
                    $trader_checkbox_deactivate = $this->input->post('trader_checkbox_deactivate',true);

                    $webservice_config = array(
                        'server' => 'pamm'
                    );

                    if ($formbutton=='register'){

                        $con_d = $this->input->post('i_c1d',true);
                        $con_h = $this->input->post('i_c1h',true);
                        $projectshare = trim(str_replace('%','',$this->input->post('i_c1ps',true)));
                        $prepaymant_investment_sum = trim(str_replace('%','',$this->input->post('i_c1ppis',true)));

                        $_SESSION['trader_register'] = true;
                        $_SESSION['trader_success'] = false;
                        $account_info = array(
                            'AccountName' => $usr_pfls['full_name'],
                            'AccountNumber' => $mt_acct_st['account_number'],
                            'BrokerId' => 0,
                            'ConditionSetNumber' => 1,
                            'IsConditionEnable' => True,
                            'MaxInvestmentAmount' => 0,
                            'MinInvestmentAmount' => 0,
                            'MinimumInvestmentTimeInSeconds' =>  ($con_h*3600)+($con_d*86400),
                            'PenaltyPersentBack' => $prepaymant_investment_sum,
                            'ProjectShare' => $projectshare,
                            'ConfigLanguage' => $traderlangauge,
                            'Description' => $traderdescription,
                            'DescriptionJapanese' => $traderdescription_jp,
                            'DescriptionPolish' => $traderdescription_pl,
                            'DescriptionRussian' => $traderdescription_ru,
                            'Icq' =>$tradericq,
                            'IsAutoInvestmentAgree' => ($trader_approveinvestmentauto==1)?1:0,
                            'PartnerShare' => $slider_reg_trader_value,
                            'ProjectName' => $traderProjectName,
                            'ShowAccountName' => $Namehideshow,
                            'ShowIcq' => $Icqhideshow,
                            'ShowSkype' => $Skypehideshow,
                            'ShowYahoo' => $Yahoohideshow,
                            'Skype' => $traderskype,
                            'StartTime' => $traderStartTime ,
                            'Yahoo' =>$traderYahoo,
                        );

                        $webservice_config = array(
                            'server' => 'pamm'
                        );
                        $WebService = new WebService($webservice_config);
                        $WebService->open_RegisterPammTrader($account_info);
                        $API_Response=$WebService->get_result('Message');
                        switch ($API_Response) {
                            case 'RET_OK':
                                $db_info = array(
                                    'user_id' => $_SESSION['user_id'],
                                    'account_name' => $usr_pfls['full_name'],
                                    'account_number' => $mt_acct_st['account_number'],
                                    'broker_id' => 0,
                                    'cs_conditionsetnumber'=>1,
                                    'cs_is_condition_enable'=>True,
                                    'cs_max_investment_amount'=>0,
                                    'cs_min_investment_amount'=>0,
                                    'cs_minimum_investment_time_in_seconds'=>($con_h*3600)+($con_d*86400),
                                    'cs_penalty_percent_back'=>$prepaymant_investment_sum,
                                    'cs_project_share'=>$projectshare,
                                    'config_language'=>$traderlangauge,
                                    'description'=>$traderdescription,
                                    'description_japanese'=>$traderdescription_jp,
                                    'description_polish'=>$traderdescription_pl,
                                    'description_russian'=>$traderdescription_ru,
                                    'icq'=>$tradericq,
                                    'is_auto_investment_agree'=>($trader_approveinvestmentauto==1)?1:0,
                                    'partner_share'=>$slider_reg_trader_value,
                                    'project_name'=>$traderProjectName,
                                    'show_account_name'=>$Skypehideshow,
                                    'show_icq'=>$Icqhideshow,
                                    'IsShowYahoo'=>$Yahoohideshow,
                                    'show_skype'=>$Skypehideshow,
                                    'show_yahoo'=>$Yahoohideshow,
                                    'skype'=>$traderskype,
                                    'start_time'=>$traderStartTime,
                                    'yahoo'=>$traderYahoo,
                                    'registration_status' => 1,
                                    'deactivatepamm' => 0,
                                );
                                $append_return = $this->g_m->insertmy($table='registration_trader_pamm',$data=$db_info);
                                $_SESSION['trader_success'] = true;
                                $data['trader_registration']=true;
                                break;
                            default:
                                $_SESSION['trader_success'] = false;

                        }

                    }elseif($formbutton=='update'){

// var_dump($Yahoohideshow);
// exit;
                                $check=($trader_checkbox_deactivate==1)? True : False;
                                $_SESSION['trader_update'] = true;
                                $_SESSION['trader_success'] = false;

                                $account_info = array(

                                    'iPammTrader' =>  $mt_acct_st['account_number'],
                                    'brokerId' => 0,

                                    'AccountName' => $usr_pfls['full_name'],
                                    'AffiliateShare' => $slider_reg_trader_value,

                                    'DescEnglish' => $traderdescription,
                                    'DescriptionJapanesse' => $traderdescription_jp,
                                    'DescriptionPolish' => $traderdescription_pl,
                                    'DescriptionRussian' =>$traderdescription_ru,
                                    'ForumLink' => $forumtopic,
                                    'HasEmailAlerts' => ($trader_emailalerts==1)?1:0,
                                    'HasSMSAlerts' => ($trader_smsalerts==1)?1:0,
                                    'Icq' => $tradericq,
                                    'IsConfirmInvestmentRefund' => ($trader_cir==1)?1:0,
                                    'IsDeactivated' => $check,
                                    'IsInvestmentAutoAgree' => ($trader_approveinvestmentauto==1)?1:0,
                                    'IsShowYahoo' => $Yahoohideshow,
                                    'IsShowAccountName' => $Namehideshow,
                                    'IsShowActiveTrades' => $hide_trades_for_all,
                                    'IsShowIcq' => $Icqhideshow,
                                    'IsShowSkype' => $Skypehideshow,
                                    'ProjectName' => $traderProjectName,
                                    'Skype' => $traderskype,
                                    'StartTimeMonitoring' => $traderStartTime,
                                    // 'StartTimeMonitoring' => '1970-01-01T22:22:22',
                                    'SystemNotificationLanguage' => $traderlangauge,
                                    'Yahoo' => $traderYahoo,

                                );
                                $WebService = new WebService($webservice_config);
                                $WebService->open_EditPammTraderProfile($account_info);
                                $API_Response = $WebService->get_all_result();
                                switch ($API_Response) {
                                    case 'RET_OK':

                                        $_SESSION['trader_success'] = true;
//                                        echo $check;
                                        $WebServiceD = new WebService($webservice_config);

                                        $account_info = array(
                                            'iAccount' => intval($mt_acct_st['account_number']), //Account Number
                                            'brokerId' => 0, // Broker Id
                                            'IsDeact' => ($trader_checkbox_deactivate==1)? True : False
                                        );

//                                        $data['updatetrader']= array(
//                                            'project_name'=>$traderProjectName,
//                                            'user_id'=>$_SESSION['user_id']
//                                        );

//                                        $save = $this->g_m->updatemy($table='registration_trader_pamm',$field='user_id',$id=$_SESSION['user_id'],$data['updatetrader']);

                                        $WebServiceD->open_DeactivateAccount($account_info);
                                        switch ($WebServiceD->result) {
                                            case  'RET_OK':
//                                                echo 'success';
                                                break;
                                            default:
                                        }


                                        break;
                                    default:
                                        $_SESSION['trader_success'] = false;
                                }
                                $data['trader_registration']=true;
                    }

                    $data['deactivated']=($trader_checkbox_deactivate==1)?True:False;
                    $nav['registered']=1;
                    $nav['is_disable']= $data['deactivated'];
                    $nav['trader']= true;
                    $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider-volume.css'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker-bv3.min.css' media='screen'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                                <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                                <script type='text/javascript' src='".$this->template->Js()."jquery-ui.js'></script>
                                <script type='text/javascript' src='".$this->template->Js()."simple-slider.js'></script>
                                <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                                <script type='text/javascript' src='".$this->template->Js()."bootstrap-datetimepicker-bv3.js' charset='UTF-8'></script>
                                <script type='text/javascript' src='".$this->template->Js()."locales/bootstrap-datetimepicker.fr.js' charset='UTF-8'></script> ")
                        ->build('pamm/n_registration-trader', $data);
                    break;
                default:
            }
        }else{

            $data['active_tab'] = 'pamm';
            $data['active_sub_tab'] = '';
            $data['title_page'] = lang('sb_li_9');
            $data['metadata_description'] = lang('pamm_dsc');
            $data['metadata_keyword'] = lang('pamm_kew');

            $u_p = $this->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$_SESSION['user_id'],$select='*');
            $usrs = $this->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='*');
            $mts = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='investor_password');

            $data['investor_name'] = $data['investor_name'] ? $data['investor_name'] : $u_p['full_name'];
            $data['investor_password'] = $mts['investor_password'];
            $data['name'] = $u_p['full_name'];
            $data['investor_skype'] = $u_p['skype'];
            $data['skype'] = $u_p['skype'];
            $data['email'] = $usrs['email'];

            if(isset($data['get']['registration'])){
                switch($data['get']['registration']){
                    case 1:
                        $data['deact_option']=False;
                        $nav['registered']=false;
                        $nav['is_disable']= true;
                        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                        $this->template->title(lang('pamm_tit'))
                            ->set_layout('internal/main')
                            ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                            ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                            ")
                            ->build('pamm/n_registration-partner', $data);
                        break;
                    case 2:
                        $data['deact_option']=False;

                        $nav['registered']=false;
                        $nav['is_disable']= true;
                        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

                        $this->template->title(lang('pamm_tit'))
                            ->set_layout('internal/main')
                            ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                            ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                            ")
                            ->build('pamm/n_registration-investor', $data);
                        break;
                    case 3:
                        $data['deact_option']=False;
                        $nav['trader']= true;
                        $nav['registered']=false;
                        $nav['is_disable']= true;
                        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

                        $this->template->title(lang('pamm_tit'))
                            ->set_layout('internal/main')
                            ->append_metadata_css("
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider-volume.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker-bv3.min.css' media='screen'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                            ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery-ui.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."simple-slider.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."bootstrap-datetimepicker-bv3.js' charset='UTF-8'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."locales/bootstrap-datetimepicker.fr.js' charset='UTF-8'></script>
                            ")
                            ->build('pamm/n_registration-trader', $data);
                        break;
                    default:

                        if ($r_p_p){
                            $data['infor']=$r_p_p;
                            $data['deactivated']=$r_p_p['deactivatepamm'];
                            $nav['registered']=false;
                            $nav['is_disable']= $data['deactivated'];
                            $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                            $this->template->title(lang('pamm_tit'))
                                ->set_layout('internal/main')
                                ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                                ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                                ")
                                ->build('pamm/n_registration-partner', $data);
                        }elseif($r_i_p){
                            $data['infor']=$r_i_p;
                            $data['deactivated']=$r_i_p['deactivatepamm'];
                            $nav['registered']=false;
                            $nav['is_disable']= $data['deactivated'];
                            $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                            $this->template->title(lang('pamm_tit'))
                                ->set_layout('internal/main')
                                ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                                ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                            ")
                                ->build('pamm/n_registration-investor', $data);
                        }elseif($r_t_p){
                            $data['infor']=$r_t_p;
                            $data['deactivated']=$r_t_p['deactivatepamm'];
                            $nav['registered']=false;
                            $nav['is_disable']= $data['deactivated'];
                            $nav['trader']= true;
                            $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                            $this->template->title(lang('pamm_tit'))
                                ->set_layout('internal/main')
                                ->append_metadata_css("
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider-volume.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker-bv3.min.css' media='screen'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                                ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery-ui.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."simple-slider.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."bootstrap-datetimepicker-bv3.js' charset='UTF-8'></script>
                                    <script type='text/javascript' src='".$this->template->Js()."locales/bootstrap-datetimepicker.fr.js' charset='UTF-8'></script>")
                                ->build('pamm/n_registration-trader', $data);
                        }else{
                            $this->template->title(lang('pamm_tit'))
                                ->set_layout('internal/main')
                                ->build('pamm/registration_n', $data);
                        }
                }

            }else{

                if ($r_p_p){

                    $data['infor']=$r_p_p;
                    $data['deactivated']=$r_p_p['deactivatepamm'];
                    $nav['registered']=false;
                    $nav['is_disable']= $data['deactivated'];
                    $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                            ")
                        ->build('pamm/n_registration-partner', $data);

                }elseif($r_i_p){

                    $data['infor']=$r_i_p;
                    $data['deactivated']=$r_i_p['deactivatepamm'];
                    $nav['registered']=false;
                    $nav['is_disable']= $data['deactivated'];
                    $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                                    <script type='text/javascript' src='".$this->template->Js()."jquery.validate.min.js'></script>
                            ")
                        ->build('pamm/n_registration-investor', $data);

                }elseif($r_t_p){

                    $data['infor']=$r_t_p;
                    $data['deactivated']=$r_t_p['deactivatepamm'];
                    $nav['registered']=false;
                    $nav['is_disable']= $data['deactivated'];
                    $nav['trader']= true;
                    $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->append_metadata_css("
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider-volume.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker-bv3.min.css' media='screen'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2-bootstrap.css'>
                                    <link rel='stylesheet' href='".$this->template->Css()."select2.css'>")
                        ->append_metadata_js("
                                    <script type='text/javascript' src='".$this->template->Js()."select2.js' ></script>
                                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                                    <script src='".$this->template->Js()."simple-slider.js'></script>
                                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                                    <script src='".$this->template->Js()."bootstrap-datetimepicker-bv3.js' charset='UTF-8'></script>
                                    <script src='".$this->template->Js()."locales/bootstrap-datetimepicker.fr.js' charset='UTF-8'></script>
                            ")
                        ->build('pamm/n_registration-trader', $data);
                }else{

                    $this->template->title(lang('pamm_tit'))
                        ->set_layout('internal/main')
                        ->build('pamm/registration_n', $data);
                }

            }
        }

    }

    public function monitoring(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $webservice_config = array(
            'server' => 'pamm'
        );

        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            $is_trader= false;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $data['trader_registration']=true;
                            $is_trader= true;
                            break;
                        case 1 :
                            // Investor
                            break;
                        case 2 :
                            // PArtner
                            break;
                        default:
                    }

                    break;
                default:

            }
        }

        $data['request'] = $this->get_monitoringdata();

        $nav = array(
                'trader' => $is_trader,
                   'tab' => 3,
            'registered' => false,
            'is_disable' => $data['deactivated'],
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css' >
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                     <link type='text/css' rel='stylesheet' href='".$this->template->Css()."pamm-monitoring.css'>
                   
                ")
            ->append_metadata_js("
                  <script type='text/javascript'>
                        window.alert = function() {};
                  </script>


                   <script src='".$this->template->Js()."jquery.dataTables.min.js'></script>
                  <script src='".$this->template->Js()."moment.min.js'></script>
                  <script src='".$this->template->Js()."datetime-moment.min.js'></script>
                  <script src='".$this->template->Js()."dataTables.bootstrap.min.js'></script>
                  <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                ")
            ->build('pamm/monitoring', $data);
//        <script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
//        <link type='text/css' rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css' >

    }

    public function my_conditions_post(){

        $this->form_validation->set_rules('minimum_investment_sum', 'Minimum investment sum', 'trim|required|xss_clean');
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        if ($this->form_validation->run()){
//            var_dump($_POST);die();
            $api_info = array();
            for ($num = 1; $num <= 4; $num++) {
                $api_info[$num] = array(
                    'condition' => $con_no =$this->input->post('condition'.$num,true),
                    'days' => $con_d=$this->input->post('i_c'.$num.'d',true),
                    'hours' => $con_h=$this->input->post('i_c'.$num.'h',true),
                    'sec'=> ($con_h*3600)+($con_d*86400),
                    'project_share' => $con_ps = trim(str_replace('%','',$this->input->post('i_c'.$num.'ps',true))),
                    'prepaymentinvestmentsum' => $con_ppis=trim(str_replace('%','',$this->input->post('i_c'.$num.'ppis',true))),
                    'status' => $this->input->post('inlinecheck'.$num,true)==1 ? 1:0,
                    'date_set' => FXPP::getCurrentDateTime(),
                    'apply_investment_from' => $this->input->post('inv_from'.$num,true),
                );
            }

            $account_info = array(
                           'iPammTrader' => $mt_acct_st['account_number'],
                    'IsConditionEnable0' => $api_info[1]['status'],
                  'MinInvestmentAmount0' => $minimal=$this->input->post('minimum_investment_sum',true),
       'MinimumInvestmentTimeInSeconds0' => $api_info[1]['sec'],
                   'PenaltyPersentBack0' => $api_info[1]['prepaymentinvestmentsum'],
                         'ProjectShare0' => $api_info[1]['project_share'],

                    'IsConditionEnable1' => $api_info[2]['status'],
                  'MinInvestmentAmount1' => $api_info[2]['apply_investment_from'],
       'MinimumInvestmentTimeInSeconds1' => $api_info[2]['sec'],
                   'PenaltyPersentBack1' => $api_info[2]['prepaymentinvestmentsum'],
                         'ProjectShare1' => $api_info[2]['project_share'],

                    'IsConditionEnable2' => $api_info[3]['status'],
                  'MinInvestmentAmount2' => $api_info[3]['apply_investment_from'],
       'MinimumInvestmentTimeInSeconds2' => $api_info[3]['sec'],
                   'PenaltyPersentBack2' => $api_info[3]['prepaymentinvestmentsum'],
                         'ProjectShare2' => $api_info[3]['project_share'],

                    'IsConditionEnable3' => $api_info[4]['status'],
                  'MinInvestmentAmount3' => $api_info[4]['apply_investment_from'],
       'MinimumInvestmentTimeInSeconds3' => $api_info[4]['sec'],
                   'PenaltyPersentBack3' => $api_info[4]['prepaymentinvestmentsum'],
                         'ProjectShare3' => $api_info[4]['project_share'],

                     'minimalInvestment' => $minimal

            );

        $webservice_config = array(
            'server' => 'pamm'
        );
            $PammService = new PammService($webservice_config);

            $PammService->open_SetTraderConditionPackage($account_info);
            $PTConditionPackage = (array) $PammService->request_status->Conditions;
            $Message = $PammService->request_status->Message;
            switch($Message){
                case 'RET_OK':
                    foreach ( $PTConditionPackage['PTConditionPackage'] as $object){

                        $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);
                        $infor[$object->ConditionSetNumber] = array(
                            'days'=> $time['day'],
                            'hours'=> $time['hour'],
                            'project_share'=>$object->ProjectShare,
                            'prepaymentinvestmentsum'=>$object->PenaltyPersentBack,
                            'status'=>($object->IsConditionEnable==True)? 1 : 0,
                            'apply_investment_from'=>$object->MinInvestmentAmount
                        );

                    }
                    $_SESSION['mycondition_update'] = true;
                    $_SESSION['mycondition_success'] = true;
                    header('Location:https://my.forexmart.com/pamm/my-conditions');
                    break;
                case 'RET_OTHER_SET_MIN_AMOUNT_SHOULD_GREATER_INV_MINIMAL_AMOUNT':
                    $_SESSION['mycondition_errror_msg'] = 'The minimum investment amount for all sets cannot exceed the minimum investment amount for a set.';
                    $_SESSION['mycondition_update'] = true;
                    $_SESSION['mycondition_success'] = false;
                    header('Location:https://my.forexmart.com/pamm/my-conditions');

                    break;
                default:
                    $_SESSION['mycondition_update'] = true;
                    $_SESSION['mycondition_success'] = false;
            }
        }


    }

    public function my_conditions(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $webservice_config = array(
            'server' => 'pamm'
        );
        $PammService = new PammService($webservice_config);
        $PammService->open_GetPammAccountInfo($account_info);
        $trader=false;
        if($PammService->result){
            $PammInfo = (array)  $PammService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $PiTi =(array) $PammInfo['TraderInfo'];
                            $data['deactivated'] = ($PiTi['IsDeactivated']==True)?1:0;
                            $data['trader_registration']=true;
                            $nav['registered']= true;
                            $trader=true;
                            break;
                        case 1 :
                            // Investor
                            $PiIi =(array) $PammInfo['InvestorInfo'];
                            $data['deactivated'] = ($PiIi['IsDeactivated']==True)?1:0;
                            $data['investor_registration']=true;
                            $nav['registered']= true;
                            break;
                        case 2 :
                            // Partner
                            $PiPi =(array) $PammInfo['PartnerInfo'];
                            $data['deactivated'] = ($PiPi['IsDeactivated']==True)?1:0;
                            $data['partner_registration']=true;
                            $nav['registered']= true;
                            break;
                        default:
                            //account number not registered.
                            $r_p_p=false;
                            $r_i_p=false;
                            $r_t_p=false;
                    }
               break;
               default:
                    // API issue
                    $r_p_p=false;
                    $r_i_p=false;
                    $r_t_p=false;

            }

        }

        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $nav=array(
            'is_disable'=>$data['deactivated'],
            'trader'=>$trader,
            'tab'=>4,
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

            $table='';
            $account_info = array(
                'iPammTrader' => $mt_acct_st['account_number'],
            );
            $PammService->open_GetConditionsSetOfPammTrader($account_info);
            $PTConditionPackage = (array) $PammService->request_status;
            foreach ( $PTConditionPackage['PTConditionPackage'] as $object){
                $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);
                $infor[$object->ConditionSetNumber]=array(
                    'days'=> $time['day'],
                    'hours'=> $time['hour'],
                    'project_share'=>$object->ProjectShare,
                    'prepaymentinvestmentsum'=>$object->PenaltyPersentBack,
                    'status'=>($object->IsConditionEnable==True)? 1 : 0,
                    'apply_investment_from'=>$object->MinInvestmentAmount
                );
            }
        

        $data['infor'] = $infor;

        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."pamm.min.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/css/jquery-ui.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/css/simple-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/css/simple-slider-volume.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."bootstrap-slider.js'></script>
                    <script src='".$this->template->Js()."slider/js/simple-slider.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                ")
            ->build('pamm/my-conditions', $data);
    }

    public function my_investments(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $disabled = 0;

        $trader = false;
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,mt_currency_base');
        $data['gi_currency'] = $mt_acct_st['mt_currency_base'];

        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['tab']=4;


        $WebService = new WebService($webservice_config);
        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
                    switch($PammInfo['AccountType']){
                        case 0 :
                            $trader=true;
                            $data['trader_registration']=true;
                            $disabled=($PiTi['IsDeactivated']==True)?1:0;
                            if ($disabled){
                                redirect(FXPP::loc_url('pamm'));
                            }
                            $data['accountType'] = 'trader';
                            break;
                        case 1 :
                            $trader=false;
                            $data['investor_registration']=true;
                            $disabled= ($PiIi['IsDeactivated']==True)? 1 :0;
                            if ($disabled){
                                redirect(FXPP::loc_url('pamm'));
                            }
                            $data['accountType'] = 'investor';
                            
                            break;
                        case 2 :
                            // Partner
                            $mts = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
                            $PiPi = (array) $PammInfo['PartnerInfo'];
                            $trader = false;
                            $data['partner_registration'] = true;
                            $disabled= ($PiPi['IsDeactivated'] == True)? 1 :0;
                            if ($disabled){
                                redirect(FXPP::loc_url('pamm'));
                            }
                            $data['partner_registration'] = true;
                            $nav['registered'] = true;

                            break;
            }
        }

        $nav=array(
            'registered'=>false,
            'is_disable'=>$disabled,
            'trader'=>$trader,
            'tab'=>6
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("

                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider-volume.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."pamm/myinvestment.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."simple-slider.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
            ->build('pamm/my-investments', $data);
    }

    private function checktraderpassword($partnertraderpassword){

        $live = $this->general_model->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        if($live){
            $prvt_data['account_number']=$live['account_number'];
        }
        $webservice_config = array(
            'server' => 'live_new'
        );
        $service_data = array(
            'iLogin' => $prvt_data['account_number'],
            'strPassword' => $partnertraderpassword
        );
        $WebService = new WebService($webservice_config);
        $WebService->CheckUserPassword($service_data);
        if ($WebService->request_status === 'RET_OK') {
            return true;
        }else{
            return false;
        }

    }

    public function live_feed(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }


        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            $is_trader= false;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $is_trader= true;
                            break;
                        case 1 :
                            // Investor
                            break;
                        case 2 :
                            // PArtner
                            break;
                        default:
                    }

                    break;
                default:

            }
        };
        $nav=array(
            'trader'=>$is_trader,
            'tab'=>3,
            'registered'=>false,
//            'is_disable'=> $data['deactivated'],
        );
        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."simple-slider.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                ")
            ->build('pamm/live-feed', $data);
    }

    public function live_feed_dt(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }


        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            $is_trader= false;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $is_trader= true;
                            break;
                        case 1 :
                            // Investor
                            break;
                        case 2 :
                            // PArtner
                            break;
                        default:
                    }

                    break;
                default:

            }
        };
        $nav=array(
            'trader'=>$is_trader,
            'tab'=>3,
            'registered'=>false,
//            'is_disable'=> $data['deactivated'],
        );
        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/jquery-ui.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."slider/simple-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."bootstrap-slider.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."simple-slider.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                ")
            ->build('pamm/live-feed-dt', $data);
    }

    public function my_widgets(){
        redirect(fxpp::loc_url('pamm'));
        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    echo 'registered';
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            echo 'Trader';
                            break;
                        case 1 :
                            // Investor
                            echo 'Investor';
                            break;
                        case 2 :
                            // PArtner
                            echo 'Partner';
                            break;

                        default:
                            echo 'not registered';
                    }

                    break;
                default:
                    echo 'not registered';

            }
        }
    }

    public function my_monitoring(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $webservice_config1 = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config1);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,mt_currency_base');
        $data['gi_currency'] = $mt_acct_st['mt_currency_base'];

        $account_info = array(
            'iAccount' => $accountnumber=$mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $PiTi =(array) $PammInfo['TraderInfo'];
                            $r_t_p = array(
                                'AccountName'=>$PiTi['AccountName'],
                                'partner_share'=>$PiTi['AffiliateShare'],
                                'description'=>$PiTi['DescEnglish'],
                                'description_japanese'=>$PiTi['DescriptionJapanesse'],
                                'description_polish'=>$PiTi['DescriptionPolish'],
                                'description_russian'=>$PiTi['DescriptionRussian'],
                                'forum_topic'=>$PiTi['ForumLink'],
                                'email_alerts'=>$PiTi['HasEmailAlerts'],
                                'sms_alerts'=>$PiTi['HasSMSAlerts'],
                                'icq'=>$PiTi['Icq'],
                                'confirm_investement_refund'=>$PiTi['IsConfirmInvestmentRefund'],
                                'deactivatepamm'=>($PiTi['IsDeactivated']==True)?1:0,
                                'show_account_name'=>$PiTi['IsShowAccountName'],
                                'is_auto_investment_agree'=>$PiTi['IsInvestmentAutoAgree'],
                                'trader_hidetradesforall'=>$PiTi['IsShowActiveTrades'],
                                'show_icq'=>$PiTi['IsShowIcq'],
                                'show_skype'=>$PiTi['IsShowSkype'],
                                'show_yahoo'=>$PiTi['IsShowYahoo'],
                                'project_name'=>$PiTi['ProjectName'],
                                'skype'=>$PiTi['Skype'],
                                'StartTimeMonitoring'=>$PiTi['StartTimeMonitoring'],
                                'SystemNotificationLanguage'=>$PiTi['SystemNotificationLanguage'],
                                'yahoo'=>$PiTi['Yahoo'],
                                'account_number'=> $accountnumber
                            );
                            $data['infor']=$r_t_p;
                            $data['deactivated'] = ($PiTi['IsDeactivated']==True)?1:0;
                            $data['trader_registration']=true;
                            $nav['registered']= true;

                            $webservice_config2 = array(
                                'server' => 'pamm_livefeeds'
                            );

                            $PammService = new PammService($webservice_config2);

                            $account_info = array(
                                'AccountFilter' => $accountnumber ,
                                /*Filter*/
                                'ActiveInvestorsFrom' => 0 ,
                                'ActiveInvestorsTo' => 0 ,
                                'BalanceFrom' => 0 ,
                                'BalanceTo' => 0 ,
                                'CurrentTradesFrom' => 0 ,
                                'CurrentTradesTo' => 0 ,
                                'DailyBalFrom' => 0 ,
                                'DailyBalTo' => 0 ,
                                'DailyEquityFrom' => 0 ,
                                'DailyEquityTo' => 0 ,
                                'DailyProfitFrom' => 0 ,
                                'DailyProfitTo' => 0 ,
                                'EquityFrom' => 0 ,
                                'EquityTo' => 0 ,
                                'Month_3_ProfitFrom' => 0 ,
                                'Month_3_ProfitTo' => 0 ,
                                'Month_6_ProfitFrom' => 0 ,
                                'Month_6_ProfitTo' => 0 ,
                                'Month_9_ProfitFrom' => 0 ,
                                'Month_9_ProfitTo' => 0 ,
                                'MonthlyProfitFrom' => 0 ,
                                'MonthlyProfitTo' => 0 ,
                                'SimpleRatingFrom' => 0 ,
                                'SimpleRatingTo' => 0 ,
                                'SinceRegisteredFrom' => 0 ,
                                'SinceRegisteredTo' => 0 ,
                                'TotalProfitFrom' => 0 ,
                                'TotalProfitTo' => 0 ,
                                'TotalTradesFrom' => 0 ,
                                'TotalTradesTo' => 0 ,
                                'WeeklyProfitFrom' => 0 ,
                                'WeeklyProfitTo' => 0 ,
                                /*Filter*/
                                'HasFilterToColumns' => false,
                                'Limit' => 1,
                                'Offset' => 0,
                                'OrderByAsc' => false,
                                'OrderByColumnName' => 'Account'

                            );


                            $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
                            if($PammService->result){
                                $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
                                $Message = $PammService->result->ResponseMessage;
                                switch($Message){
                                    case 'RET_OK':
                                        $qobject='';
                                        if($MonitroingDataList){

                                            foreach ($MonitroingDataList['MonitoringData'] as $object){
                                                $trdr_m = array(
                                                          'AccountId' => $object->AccountId,
                                                    'ActiveFollowers' => $object->ActiveFollowers ,
                                                    'ActiveInvestors' => $object->ActiveInvestors,
                                                            'Balance' => $object->Balance,
                                                           'BrokerId' => $object->BrokerId,
                                                           'Currency' => $object->Currency,
                                                      'CurrentTrades' => $object->CurrentTrades,
                                                        'DailyProfit' => $object->DailyProfit,
                                                  'DailyTotalBalance' => $object->DailyTotalBalance,
                                                   'DailyTotalEquity' => $object->DailyTotalEquity,
                                                             'Equity' => $object->Equity ,
                                                    'Month_3_Profit' => $object->Month_3_Profit ,
                                                    'Month_6_Profit' => $object->Month_6_Profit,
                                                    'Month_9_Profit' => $object->Month_9_Profit ,
                                                     'MonthlyProfit' => $object->MonthlyProfit ,
                                                       'ProjectName' => $object->ProjectName ,
                                                      'SimpleRating' => $object->SimpleRating ,
                                               'SinceRegisteredDays' => $object->SinceRegisteredDays,
                                                       'TotalProfit' => $object->TotalProfit ,
                                                       'TotalTrades' => $object->TotalTrades,
                                                      'WeeklyProfit' => $object->WeeklyProfit
                                                );
                                            }
                                        }
                                        break;

                                    default:
                                        $trdr_m = array(
                                                  'AccountId' => '',
                                            'ActiveFollowers' => '',
                                            'ActiveInvestors' => '',
                                                    'Balance' => '',
                                                   'BrokerId' => '',
                                                   'Currency' => '',
                                              'CurrentTrades' => '',
                                                'DailyProfit' => '',
                                          'DailyTotalBalance' => '',
                                           'DailyTotalEquity' => '',
                                                     'Equity' => '',
                                             'Month_3_Profit' => '',
                                             'Month_6_Profit' => '',
                                             'Month_9_Profit' => '',
                                              'MonthlyProfit' => '',
                                                'ProjectName' => '',
                                               'SimpleRating' => '',
                                        'SinceRegisteredDays' => '',
                                                'TotalProfit' => '',
                                                'TotalTrades' => '',
                                               'WeeklyProfit' => ''
                                        );
                                }

                            }

                            $data['infor2']=$trdr_m;
                            /*get my conditions*/

                            $webservice_config3 = array(
                                'server' => 'pamm'
                            );
                            $account_info = array(
                                'iPammTrader' => $mt_acct_st['account_number'],
                            );
                            $PammService2 = new PammService($webservice_config3);
                            $PammService2->open_GetConditionsSetOfPammTrader($account_info);
                            $PTConditionPackage = (array) $PammService2->request_status;
                            foreach ( $PTConditionPackage['PTConditionPackage'] as $object){
                                $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);
                                $infor3[$object->ConditionSetNumber]=array(
                                    'days'=> $time['day'],
                                    'hours'=> $time['hour'],
                                    'project_share'=>$object->ProjectShare,
                                    'prepaymentinvestmentsum'=>$object->PenaltyPersentBack,
                                    'status'=>($object->IsConditionEnable==True)? 1 : 0,
                                    'apply_investment_from'=>$object->MinInvestmentAmount
                                );
                            }
                            /*get my conditions*/

                            $data['infor3']=$infor3;

                            $trader = true;
                            break;
                        case 1 :
                            // Investor
                            // echo 'Investor';
                            redirect(fxpp::loc_url('pamm'));
                            break;
                        case 2 :
                            // PArtner
                            // echo 'Partner';
                            redirect(fxpp::loc_url('pamm'));
                            break;
                        default:
                            // echo 'not registered';
                    }

                    break;
                default:
                //  echo 'not registered';
            }
        }


        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['tab']=4;

        $data['pamm_type']='Real';

            switch($trdr_m['BrokerId']){
                case 0:
                    $data['broker']='Forexmart';
                    break;
                case 1:
                    $data['broker']='Instaforex';
                    break;
                default:
                    $data['broker']='Others';

            }

            switch($r_t_p['show_account_name']){
                case 0:
                    $data['gi_show_account_name'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                    break;
                case 1:
                    $data['gi_show_account_name'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                    break;
                case 2:
                    $data['gi_show_account_name'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                    break;
            }

            switch($r_t_p['show_icq']){
                case 0:
                    $data['gi_show_icq'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                    break;
                case 1:
                    $data['gi_show_icq'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                    break;
                case 2:
                    $data['gi_show_icq'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                    break;
            }


            switch($r_t_p['show_skype']){
                case 0:
                    $data['gi_show_skype'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                    break;
                case 1:
                    $data['gi_show_skype'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                    break;
                case 2:
                    $data['gi_show_skype'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                    break;
            }

        $nav = array(
            'registered'=>false,
            'is_disable'=>$disabled=false,
            'trader'=>$trader,
            'tab'=>5
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
        $data['gi_percentsymbol'] = '%';
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
            ->build('pamm/my-monitoring', $data);


    }

    public function investments(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }


        $webservice_config = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    echo 'registered';
                    switch($PammInfo['AccountType']){
                        case 0 :
                            $is_trader=true;
                            redirect(FXPP::loc_url('pamm'));
                            break;
                        case 1 :
                            // Investor

                            break;
                        case 2 :
                            // Partner
                            redirect(FXPP::loc_url('pamm'));
                            break;
                        default:
                    }
                    break;
                default:
            }
        }


        $nav=array(
            'trader'=>$is_trader,
            'tab'=>3,
            'registered'=>false,
//            'is_disable'=> $data['deactivated'],
        );
        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);


        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                ")
            ->append_metadata_js("

                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                ")
            ->build('pamm/live-invest-traderdetails', $data);
    }

    private function convert_sec_to_dy_hr($seconds) {

        $date1 = new \DateTime('@0');
        $date2 = new \DateTime("@$seconds");
        return $sec_to_dy_hr = array(
           'day'=> $date1->diff($date2)->format('%a'),
           'hour'=> $date1->diff($date2)->format('%h')
       );

    }

    public function checklivefeed(){
        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $webservice_config = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new PammService($webservice_config);

        $account_info = array(
            'AccountFilter' => 185268 ,
            /*Filter*/
                'ActiveInvestorsFrom' => 0 ,
                'ActiveInvestorsTo' => 0 ,
                'BalanceFrom' => 0 ,
                'BalanceTo' => 0 ,
                'CurrentTradesFrom' => 0 ,
                'CurrentTradesTo' => 0 ,
                'DailyBalFrom' => 0 ,
                'DailyBalTo' => 0 ,
                'DailyEquityFrom' => 0 ,
                'DailyEquityTo' => 0 ,
                'DailyProfitFrom' => 0 ,
                'DailyProfitTo' => 0 ,
                'EquityFrom' => 0 ,
                'EquityTo' => 0 ,
                'Month_3_ProfitFrom' => 0 ,
                'Month_3_ProfitTo' => 0 ,
                'Month_6_ProfitFrom' => 0 ,
                'Month_6_ProfitTo' => 0 ,
                'Month_9_ProfitFrom' => 0 ,
                'Month_9_ProfitTo' => 0 ,
                'MonthlyProfitFrom' => 0 ,
                'MonthlyProfitTo' => 0 ,
                'SimpleRatingFrom' => 0 ,
                'SimpleRatingTo' => 0 ,
                'SinceRegisteredFrom' => 0 ,
                'SinceRegisteredTo' => 0 ,
                'TotalProfitFrom' => 0 ,
                'TotalProfitTo' => 0 ,
                'TotalTradesFrom' => 0 ,
                'TotalTradesTo' => 0 ,
                'WeeklyProfitFrom' => 0 ,
                'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 100,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );


        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);

        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            echo $object->SimpleRating ;
                        }
                    }
                    break;

                default:
            }

        }


    }

    public function invest($account_number=0){
        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }

        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $mt_acct_st_view = $this->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id=$account_number,$select='mt_currency_base');
        $data['gi_currency'] = $mt_acct_st_view['mt_currency_base'];
        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $webservice_config = array(
            'server' => 'pamm'
        );

        /*Request by the registered user*/
        $PammService = new PammService($webservice_config);
        $PammService->open_GetPammAccountInfo($account_info);
        if($PammService->result){
            $PammInfo = (array)  $PammService->result;
            $is_trader=false;
            switch($PammInfo['Message']){
                case 'RET_OK':
//                    echo 'registered';
                    switch($PammInfo['AccountType']){
                        case 0 :
                            $is_trader=true;
//                            echo 'trader account could not invest';
                            break;
                        case 1 :
                            // Investor

                            break;
                        case 2 :
                            // Partner

                            break;
                        default:
                    }
                    break;
                default:
            }
        }
        /*Request by the registered user*/
        /*Trader account view from live feed*/
        $account_info = array(
            'iAccount' => $account_number,
            'brokerId' => 0,
        );
        $PammService2 = new PammService($webservice_config);
        $PammService2->open_GetPammAccountInfo($account_info);
        if($PammService2->result){
            $PammInfo = (array)  $PammService2->result;
            switch($PammInfo['Message']){
                case 'RET_OK':

                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $PiTi =(array) $PammInfo['TraderInfo'];
                            $r_t_p = array(
                                'AccountName' => $PiTi['AccountName'],
                                'partner_share' => $PiTi['AffiliateShare'],
                                'description' => $PiTi['DescEnglish'],
                                'description_japanese' => $PiTi['DescriptionJapanesse'],
                                'description_polish' => $PiTi['DescriptionPolish'],
                                'description_russian' => $PiTi['DescriptionRussian'],
                                'forum_topic' => $PiTi['ForumLink'],
                                'email_alerts' => $PiTi['HasEmailAlerts'],
                                'sms_alerts' => $PiTi['HasSMSAlerts'],
                                'icq' => $PiTi['Icq'],
                                'confirm_investement_refund' => $PiTi['IsConfirmInvestmentRefund'],
                                'deactivatepamm' => ($PiTi['IsDeactivated']== True)?1:0,
                                'show_account_name' => $PiTi['IsShowAccountName'],
                                'is_auto_investment_agree' => $PiTi['IsInvestmentAutoAgree'],
                                'trader_hidetradesforall' => $PiTi['IsShowActiveTrades'],
                                'show_icq' => $PiTi['IsShowIcq'],
                                'show_skype' => $PiTi['IsShowSkype'],
                                'show_yahoo' => $PiTi['IsShowYahoo'],
                                'project_name' => $PiTi['ProjectName'],
                                'skype' => $PiTi['Skype'],
                                'StartTimeMonitoring' => $PiTi['StartTimeMonitoring'],
                                'SystemNotificationLanguage' => $PiTi['SystemNotificationLanguage'],
                                'yahoo' => $PiTi['Yahoo']
                            );



                            switch($r_t_p['show_account_name']){
                                case 0:
                                    $data['gi_show_account_name'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                    break;
                                case 1:
                                    $data['gi_show_account_name'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                    break;
                                case 2:
                                    $data['gi_show_account_name'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                    break;
                            }

                            switch($r_t_p['show_icq']){
                                case 0:
                                    $data['gi_show_icq'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                    break;
                                case 1:
                                    $data['gi_show_icq'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                    break;
                                case 2:
                                    $data['gi_show_icq'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                    break;
                            }


                            switch($r_t_p['show_yahoo']){
                                case 0:
                                    $data['gi_show_yahoo'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                    break;
                                case 1:
                                    $data['gi_show_yahoo'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                    break;
                                case 2:
                                    $data['gi_show_yahoo'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                    break;
                            }
                            $account_info = array(
                                'iPammTrader' => $account_number,
                            );
                            $webservice_config = array(
                                'server' => 'pamm'
                            );

                            $PammService3 = new PammService($webservice_config);
                            $PammService3->open_GetConditionsSetOfPammTrader($account_info);
                            $PTConditionPackage = (array) $PammService3->request_status;
                            $trader_condition='';
                            foreach ( $PTConditionPackage['PTConditionPackage'] as $object){
                                $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);

                                if($object->IsConditionEnable){
                                     $default = '';
                                    if ($object->ConditionSetNumber == '1') {
                                        $default = 'checked';
                                    }

                                    $trader_condition.='<tr>';
                                    $trader_condition.='<td><input name="condition" id="condition'.$object->ConditionSetNumber.'" type="radio" value="'.$object->ConditionSetNumber.'" '.$default.'><span> '.$object->ConditionSetNumber.'</span></td>';
                                    $trader_condition.='<td>'.$object->MinInvestmentAmount.' '.$data['gi_currency'].'</td>';
                                    $trader_condition.='<td>'.$object->ProjectShare.' %</td>';
                                    $trader_condition.='<td>'.$time['day'].' days '. $time['hour'].' hours </td>';
                                    $trader_condition.='<td>'.$object->PenaltyPersentBack.' %</td>';
                                    $trader_condition.='</tr>';
                                }
                            }

                            break;
                        case 1 :
                            // Investor

                            break;
                        case 2 :
                            // Partner

                            break;
                        default:
                    }
                    break;
                default:
            }
        }
        /*Trader account view from live feed*/
        $data['infor']=$r_t_p;
        $data['infor3']=$trader_condition;
        $nav=array(
            'trader'=>$is_trader,
            'tab'=>0,
            'registered'=>false,
//            'is_disable'=> $data['deactivated'],
        );
        $data['account_number']=$account_number;
        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ");
        /*Note changes in VIEW*/
        if ($is_trader){
            $this->template->build('pamm/trader-cannot-invest', $data);
        }else{
            $this->template->build('pamm/make-investment', $data);
        }
        /*Note changes in VIEW*/
    }
    public function invest_dt($account_number=0){
        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }

        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $mt_acct_st_view = $this->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id=$account_number,$select='mt_currency_base');
        $data['gi_currency'] = $mt_acct_st_view['mt_currency_base'];
        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $webservice_config = array(
            'server' => 'pamm'
        );

        /*Request by the registered user*/
        $PammService = new PammService($webservice_config);
        $PammService->open_GetPammAccountInfo($account_info);
        if($PammService->result){
            $PammInfo = (array)  $PammService->result;
            $is_trader=false;
            switch($PammInfo['Message']){
                case 'RET_OK':
//                    echo 'registered';
                    switch($PammInfo['AccountType']){
                        case 0 :
                            $is_trader=true;
//                            echo 'trader account could not invest';
                            break;
                        case 1 :
                            // Investor

                            break;
                        case 2 :
                            // Partner

                            break;
                        default:
                    }
                    break;
                default:
            }
        }
        /*Request by the registered user*/
        /*Trader account view from live feed*/
            $account_info = array(
                'iAccount' => $account_number,
                'brokerId' => 0,
            );
            $PammService2 = new PammService($webservice_config);
            $PammService2->open_GetPammAccountInfo($account_info);
            if($PammService2->result){
                $PammInfo = (array)  $PammService2->result;
                switch($PammInfo['Message']){
                    case 'RET_OK':

                        switch($PammInfo['AccountType']){
                            case 0 :
                                // Trader
                                $PiTi =(array) $PammInfo['TraderInfo'];
                                $r_t_p = array(
                                      'AccountName' => $PiTi['AccountName'],
                                    'partner_share' => $PiTi['AffiliateShare'],
                                      'description' => $PiTi['DescEnglish'],
                             'description_japanese' => $PiTi['DescriptionJapanesse'],
                               'description_polish' => $PiTi['DescriptionPolish'],
                              'description_russian' => $PiTi['DescriptionRussian'],
                                      'forum_topic' => $PiTi['ForumLink'],
                                     'email_alerts' => $PiTi['HasEmailAlerts'],
                                       'sms_alerts' => $PiTi['HasSMSAlerts'],
                                              'icq' => $PiTi['Icq'],
                       'confirm_investement_refund' => $PiTi['IsConfirmInvestmentRefund'],
                                   'deactivatepamm' => ($PiTi['IsDeactivated']== True)?1:0,
                                'show_account_name' => $PiTi['IsShowAccountName'],
                         'is_auto_investment_agree' => $PiTi['IsInvestmentAutoAgree'],
                          'trader_hidetradesforall' => $PiTi['IsShowActiveTrades'],
                                         'show_icq' => $PiTi['IsShowIcq'],
                                       'show_skype' => $PiTi['IsShowSkype'],
                                       'show_yahoo' => $PiTi['IsShowYahoo'],
                                     'project_name' => $PiTi['ProjectName'],
                                            'skype' => $PiTi['Skype'],
                              'StartTimeMonitoring' => $PiTi['StartTimeMonitoring'],
                       'SystemNotificationLanguage' => $PiTi['SystemNotificationLanguage'],
                                            'yahoo' => $PiTi['Yahoo']
                                );



                                switch($r_t_p['show_account_name']){
                                    case 0:
                                        $data['gi_show_account_name'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                        break;
                                    case 1:
                                        $data['gi_show_account_name'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                        break;
                                    case 2:
                                        $data['gi_show_account_name'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                        break;
                                }

                                switch($r_t_p['show_icq']){
                                    case 0:
                                        $data['gi_show_icq'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                        break;
                                    case 1:
                                        $data['gi_show_icq'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                        break;
                                    case 2:
                                        $data['gi_show_icq'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                        break;
                                }


                                switch($r_t_p['show_yahoo']){
                                    case 0:
                                        $data['gi_show_yahoo'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                                        break;
                                    case 1:
                                        $data['gi_show_yahoo'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                                        break;
                                    case 2:
                                        $data['gi_show_yahoo'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                                        break;
                                }
                                $account_info = array(
                                    'iPammTrader' => $account_number,
                                );
                                $webservice_config = array(
                                    'server' => 'pamm'
                                );

                                $PammService3 = new PammService($webservice_config);
                                $PammService3->open_GetConditionsSetOfPammTrader($account_info);
                                $PTConditionPackage = (array) $PammService3->request_status;
                                $trader_condition='';
                                $checked=false;
                                foreach ( $PTConditionPackage['PTConditionPackage'] as $object){
                                    $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);
                                    if($object->IsConditionEnable){
                                        $trader_condition.='<tr>';
                                        if(!$checked){
                                            $trader_condition.='<td><input name="condition" id="condition'.$object->ConditionSetNumber.'" type="radio" value="'.$object->ConditionSetNumber.'" checked><span> '.$object->ConditionSetNumber.'</span></td>';
                                            $checked=true;
                                        }else{
                                            $trader_condition.='<td><input name="condition" id="condition'.$object->ConditionSetNumber.'" type="radio" value="'.$object->ConditionSetNumber.'" ><span> '.$object->ConditionSetNumber.'</span></td>';
                                        }
                                        $trader_condition.='<td>'.$object->MinInvestmentAmount.' '.$data['gi_currency'].'</td>';
                                        $trader_condition.='<td>'.$object->ProjectShare.' %</td>';
                                        $trader_condition.='<td>'.$time['day'].' days '. $time['hour'].' hours </td>';
                                        $trader_condition.='<td>'.$object->PenaltyPersentBack.' %</td>';
                                        $trader_condition.='</tr>';
                                    }
                                }

                                break;
                            case 1 :
                                // Investor

                                break;
                            case 2 :
                                // Partner

                                break;
                            default:
                        }
                        break;
                    default:
                }
            }
        /*Trader account view from live feed*/
        $data['infor']=$r_t_p;
        $data['infor3']=$trader_condition;
        $nav=array(
            'trader'=>$is_trader,
            'tab'=>0,
            'registered'=>false,
//            'is_disable'=> $data['deactivated'],
        );
        $data['account_number']=$account_number;
        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ");
        /*Note changes in VIEW*/
        if ($is_trader){
            $this->template->build('pamm/trader-cannot-invest', $data);
        }else{
            $this->template->build('pamm/make-investment_dt', $data);
        }
        /*Note changes in VIEW*/
    }


    public function get_monitoringdata(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }

        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }


        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new PammService($webservice_config2);
        $account_info = array(
            'AccountFilter' => '' ,
            /*Filter*/
            'ActiveInvestorsFrom' => 0 ,
            'ActiveInvestorsTo' => 0 ,
            'BalanceFrom' => 0 ,
            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => 0 ,
            'CurrentTradesTo' => 0 ,
            'DailyBalFrom' => 0 ,
            'DailyBalTo' => 0 ,
            'DailyEquityFrom' => 0 ,
            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => 0 ,
            'DailyProfitTo' => 0 ,
            'EquityFrom' => 0 ,
            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => 0 ,
            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => 0 ,
            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => 0 ,
            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => 0 ,
            'MonthlyProfitTo' => 0 ,
            'SimpleRatingFrom' => 0 ,
            'SimpleRatingTo' => 0 ,
            'SinceRegisteredFrom' => 0 ,
            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => 0 ,
            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => 0 ,
            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' => 0 ,
            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 0,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);

        $request = '';

        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        $count=1;
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            $trdr_m[$count] = array(
                                'AccountId' => $object->AccountId,
                                'ActiveFollowers' => $object->ActiveFollowers ,
                                'ActiveInvestors' => $object->ActiveInvestors,
                                'Balance' => $object->Balance,
                                'BrokerId' => $object->BrokerId,
                                'Currency' => $object->Currency,
                                'CurrentTrades' => $object->CurrentTrades,
                                'DailyProfit' => $object->DailyProfit,
                                'DailyTotalBalance' => $object->DailyTotalBalance,
                                'DailyTotalEquity' => $object->DailyTotalEquity,
                                'Equity' => $object->Equity ,
                                'Month_3_Profit' => $object->Month_3_Profit ,
                                'Month_6_Profit' => $object->Month_6_Profit,
                                'Month_9_Profit' => $object->Month_9_Profit ,
                                'MonthlyProfit' => $object->MonthlyProfit ,
                                'ProjectName' => $object->ProjectName ,
                                'SimpleRating' => $object->SimpleRating ,
                                'SinceRegisteredDays' => $object->SinceRegisteredDays,
                                'TotalProfit' => $object->TotalProfit ,
                                'TotalTrades' => $object->TotalTrades,
                                'WeeklyProfit' => $object->WeeklyProfit
                            );
                            $count=$count+1;
                            $request .= '<tr>';

                            $request .= '<td>' .$object->AccountId . '</td>';  /*account number or project*/
                            $request .= '<td>' .$object->SimpleRating. '</td>'; /*simple rating*/
                            $request .= '<td>' . sprintf("%01.2f", $object->Balance) . '</td>'; /*balance*/
                            $request .= '<td>' . sprintf("%01.2f", $object->Equity )  . '</td>'; /*equity*/
                            $request .= '<td>' .  $object->CurrentTrades . '</td>'; /*current trades*/
                            $request .= '<td>' .  $object->TotalTrades . '</td>'; /*total trades*/
                            $request .= '<td>' .  $object->ActiveInvestors . '</td>'; /*active investor*/
                            $request .= '<td>' . sprintf("%01.2f", $object->DailyTotalBalance ). '</td>'; /*daily total balance*/
                            $request .= '<td>' . sprintf("%01.2f", $object->DailyTotalEquity). '</td>'; /* daily total equity*/
                            $request .= '<td>' .  $object->SinceRegisteredDays. ' days</td>'; /* since registered*/
                            $request .= '</tr>';

                            /*instaforex columns*/
                                /*account*/
                                /*simple rating*/
                                /*daily profit*/
                                /*monthly profit*/
                                /*6 month profit*/
                                /*Total profit*/
                                /*Balance*/
                                /*Equity*/
                                /*Current Trades*/
                                /*Total trades*/
                                /*active investors*/
                                /*Daily Total (balance)*/
                                /*Daily total equity*/
                                /*Since registered*/
                        }
                    }
                    break;
                default:
            }
        }
        return $request;
        unset($request);
    }

    public function monitoring_dt(){

                if(!$this->session->userdata('logged')){
                    redirect('signout');
                }

                if(!IPLoc::Office()) {
                    redirect('signout');
                }
                //Partner restriction.
                if (!IPLoc::Office()) {
                    FXPP::LoginTypeRestriction();
                }

        $webservice_config = array(
            'server' => 'pamm'
        );

        $WebService = new WebService($webservice_config);
        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');

        $account_info = array(
            'iAccount' => $mt_acct_st['account_number'],
            'brokerId' => 0,
        );

        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            $is_trader= false;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $data['trader_registration']=true;
                            $is_trader= true;
                            break;
                        case 1 :
                            // Investor
                            break;
                        case 2 :
                            // PArtner
                            break;
                        default:
                    }

                    break;
                default:

            }
        }

//        $data['request'] = $this->get_monitoringdata();

        $nav = array(
            'trader' => $is_trader,
            'tab' => 3,
            'registered' => false,
            'is_disable' => $data['deactivated'],
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                ")
            ->append_metadata_js("
                  <script type='text/javascript'>
                        window.alert = function() {};
                  </script>
                    <script src='" . $this->template->Js() . "datatable_stable/jquery.dataTables.min.js'></script>
                  <script src='" . $this->template->Js() . "datatable_stable/moment.min.js'></script>
                  <script src='" . $this->template->Js() . "datatable_stable/datetime-moment.min.js'></script>
                  <script src='" . $this->template->Js() . "datatable_stable/dataTables.bootstrap.min.js'></script>
                ")
            ->build('pamm/monitoring_dt', $data);

        //        <script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
        //        <link type='text/css' rel='stylesheet' href='https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css' >

    }

    public function get_monitoring2(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $draw = (int) $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order =  $this->input->post('order');


        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);
        $account_info = array(
            'AccountFilter' => '' ,
            /*Filter*/
            'ActiveInvestorsFrom' => 0 ,
            'ActiveInvestorsTo' => 0 ,
            'BalanceFrom' => 0 ,
            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => 0 ,
            'CurrentTradesTo' => 0 ,
            'DailyBalFrom' => 0 ,
            'DailyBalTo' => 0 ,
            'DailyEquityFrom' => 0 ,
            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => 0 ,
            'DailyProfitTo' => 0 ,
            'EquityFrom' => 0 ,
            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => 0 ,
            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => 0 ,
            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => 0 ,
            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => 0 ,
            'MonthlyProfitTo' => 0 ,
            'SimpleRatingFrom' => 0 ,
            'SimpleRatingTo' => 0 ,
            'SinceRegisteredFrom' => 0 ,
            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => 0 ,
            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => 0 ,
            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' => 0 ,
            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 0,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        $request = '';
        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        $key=0;
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            $data['data'][$key]['account'] = $object->AccountId  ;
                            $data['data'][$key]['simple_rating'] = $object->SimpleRating;
                            $data['data'][$key]['balance'] = sprintf("%01.2f", $object->Balance) ;
                            $data['data'][$key]['equity'] = sprintf("%01.2f", $object->Equity ) ;
                            $data['data'][$key]['current_trades'] = $object->CurrentTrades ;
                            $data['data'][$key]['total_trades'] =  $object->TotalTrades ;
                            $data['data'][$key]['active_trades'] =  $object->ActiveInvestors ;
                            $data['data'][$key]['daily_total_balance'] =  sprintf("%01.2f", $object->DailyTotalBalance );
                            $data['data'][$key]['daily_total_equity'] = sprintf("%01.2f", $object->DailyTotalEquity);
                            $data['data'][$key]['sinceregistereddays'] = $object->SinceRegisteredDays.' days';
                            $key=$key+1;
                        }
                    }
                    break;
                default:
            }
        }

        $data['draw'] = $draw;
        $data['recordsTotal'] = $key;
        $data['recordsFiltered'] = $key;
        echo json_encode($data);
        unset($data);
    }

     public function get_monitoring(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $draw = (int) $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order =  $this->input->post('order');


        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);
        $account_info = array(
            'AccountFilter' => '' ,
            /*Filter*/
            'ActiveInvestorsFrom' => 0 ,
            'ActiveInvestorsTo' => 0 ,
            'BalanceFrom' => 0 ,
            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => 0 ,
            'CurrentTradesTo' => 0 ,
            'DailyBalFrom' => 0 ,
            'DailyBalTo' => 0 ,
            'DailyEquityFrom' => 0 ,
            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => 0 ,
            'DailyProfitTo' => 0 ,
            'EquityFrom' => 0 ,
            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => 0 ,
            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => 0 ,
            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => 0 ,
            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => 0 ,
            'MonthlyProfitTo' => 0 ,
            'SimpleRatingFrom' => 0 ,
            'SimpleRatingTo' => 0 ,
            'SinceRegisteredFrom' => 0 ,
            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => 0 ,
            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => 0 ,
            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' => 0 ,
            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 0,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        $request = '';
        $arrayName['data'] = [];

        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        $key=0;
                        foreach ($MonitroingDataList['MonitoringData'] as $object){

                            $data['AccountId'] = "<a href='https://my.forexmart.com/pamm/invest/".$object->AccountId."' >".$object->AccountId."(".$object->ProjectName.")</a> ";
                            $data['ActiveFollowers'] = $object->ActiveFollowers;
                            $data['ActiveInvestors'] = $object->ActiveInvestors;
                            $data['Balance'] = $object->Balance;
                            $data['BrokerId'] = $object->BrokerId;
                            $data['Currency'] = $object->Currency;
                            $data['CurrentTrades'] = $object->CurrentTrades;
                            $data['DailyProfit'] = sprintf("%01.2f", $object->DailyProfit);
                            $data['DailyTotalBalance'] = $object->DailyTotalBalance;
                            $data['DailyTotalEquity'] = sprintf("%01.2f", $object->DailyTotalEquity);
                            $data['Equity'] = $object->Equity;
                            $data['Month_3_Profit'] = sprintf("%01.2f", $object->Month_3_Profit);
                            $data['Month_6_Profit'] = sprintf("%01.2f", $object->Month_6_Profit);
                            $data['Month_9_Profit'] = sprintf("%01.2f", $object->Month_9_Profit);
                            $data['MonthlyProfit'] = sprintf("%01.2f", $object->MonthlyProfit);
                            $data['SimpleRating'] = $object->SimpleRating;
                            $data['SinceRegisteredDays'] = $object->SinceRegisteredDays;
                            $data['TotalProfit'] = sprintf("%01.2f", $object->TotalProfit);
                            $data['TotalTrades'] = sprintf("%01.2f", $object->TotalTrades);
                            $data['WeeklyProfit'] = sprintf("%01.2f", $object->WeeklyProfit);
                            array_push($arrayName['data'],$data);


                        }
                    }
                    break;
                default:
            }
        }
        echo json_encode($arrayName);
    }


    public function check(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        if(!IPLoc::Office()) {
            redirect('signout');
        }
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new PammService($webservice_config2);
        $account_info = array(
            'AccountFilter' =>'' ,
            /*Filter*/
            'ActiveInvestorsFrom' => 0 ,
            'ActiveInvestorsTo' => 0 ,
            'BalanceFrom' => 0 ,
            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => 0 ,
            'CurrentTradesTo' => 0 ,
            'DailyBalFrom' => 0 ,
            'DailyBalTo' => 0 ,
            'DailyEquityFrom' => 0 ,
            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => 0 ,
            'DailyProfitTo' => 0 ,
            'EquityFrom' => 0 ,
            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => 0 ,
            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => 0 ,
            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => 0 ,
            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => 0 ,
            'MonthlyProfitTo' => 0 ,
            'SimpleRatingFrom' => 0 ,
            'SimpleRatingTo' => 0 ,
            'SinceRegisteredFrom' => 0 ,
            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => 0 ,
            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => 0 ,
            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' => 0 ,
            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 0,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        var_dump($MonitroingDataList);

                    }
                    break;
                default:
            }

        }


    }

    public function monitoring_user($account_number=0){


        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office()) {
            redirect('signout');
        }

        //Partner restriction.
        if (!IPLoc::Office()) {
            FXPP::LoginTypeRestriction();
        }

        $mt_acct_st = $this->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id=$account_number,$select='mt_currency_base');
        $data['gi_currency'] = $mt_acct_st['mt_currency_base'];

        $webservice_config1 = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webservice_config1);
        $account_info = array(
            'iAccount' => $account_number,
            'brokerId' => 0,
        );
        $WebService->open_GetPammAccountInfo($account_info);
        if($WebService->result){
            $PammInfo = (array)  $WebService->result;
            switch($PammInfo['Message']){
                case 'RET_OK':
                    switch($PammInfo['AccountType']){
                        case 0 :
                            // Trader
                            $PiTi =(array) $PammInfo['TraderInfo'];
                            $r_t_p = array(
                                'AccountName'=>$PiTi['AccountName'],
                                'partner_share'=>$PiTi['AffiliateShare'],
                                'description'=>$PiTi['DescEnglish'],
                                'description_japanese'=>$PiTi['DescriptionJapanesse'],
                                'description_polish'=>$PiTi['DescriptionPolish'],
                                'description_russian'=>$PiTi['DescriptionRussian'],
                                'forum_topic'=>$PiTi['ForumLink'],
                                'email_alerts'=>$PiTi['HasEmailAlerts'],
                                'sms_alerts'=>$PiTi['HasSMSAlerts'],
                                'icq'=>$PiTi['Icq'],
                                'confirm_investement_refund'=>$PiTi['IsConfirmInvestmentRefund'],
                                'deactivatepamm'=>($PiTi['IsDeactivated']==True)?1:0,
                                'show_account_name'=>$PiTi['IsShowAccountName'],
                                'is_auto_investment_agree'=>$PiTi['IsInvestmentAutoAgree'],
                                'trader_hidetradesforall'=>$PiTi['IsShowActiveTrades'],
                                'show_icq'=>$PiTi['IsShowIcq'],
                                'show_skype'=>$PiTi['IsShowSkype'],
                                'show_yahoo'=>$PiTi['IsShowYahoo'],
                                'project_name'=>$PiTi['ProjectName'],
                                'skype'=>$PiTi['Skype'],
                                'StartTimeMonitoring'=>$PiTi['StartTimeMonitoring'],
                                'SystemNotificationLanguage'=>$PiTi['SystemNotificationLanguage'],
                                'yahoo'=>$PiTi['Yahoo'],
                                'account_number'=> $account_number
                            );
                            $data['infor']=$r_t_p;
                            $data['deactivated'] = ($PiTi['IsDeactivated']==True)?1:0;
                            $data['trader_registration']=true;
                            $nav['registered']= true;

                            $webservice_config2 = array(
                                'server' => 'pamm_livefeeds'
                            );

                            $PammService = new PammService($webservice_config2);

                            $account_info = array(
                                'AccountFilter' => $account_number ,
                                /*Filter*/
                                'ActiveInvestorsFrom' => 0 ,
                                'ActiveInvestorsTo' => 0 ,
                                'BalanceFrom' => 0 ,
                                'BalanceTo' => 0 ,
                                'CurrentTradesFrom' => 0 ,
                                'CurrentTradesTo' => 0 ,
                                'DailyBalFrom' => 0 ,
                                'DailyBalTo' => 0 ,
                                'DailyEquityFrom' => 0 ,
                                'DailyEquityTo' => 0 ,
                                'DailyProfitFrom' => 0 ,
                                'DailyProfitTo' => 0 ,
                                'EquityFrom' => 0 ,
                                'EquityTo' => 0 ,
                                'Month_3_ProfitFrom' => 0 ,
                                'Month_3_ProfitTo' => 0 ,
                                'Month_6_ProfitFrom' => 0 ,
                                'Month_6_ProfitTo' => 0 ,
                                'Month_9_ProfitFrom' => 0 ,
                                'Month_9_ProfitTo' => 0 ,
                                'MonthlyProfitFrom' => 0 ,
                                'MonthlyProfitTo' => 0 ,
                                'SimpleRatingFrom' => 0 ,
                                'SimpleRatingTo' => 0 ,
                                'SinceRegisteredFrom' => 0 ,
                                'SinceRegisteredTo' => 0 ,
                                'TotalProfitFrom' => 0 ,
                                'TotalProfitTo' => 0 ,
                                'TotalTradesFrom' => 0 ,
                                'TotalTradesTo' => 0 ,
                                'WeeklyProfitFrom' => 0 ,
                                'WeeklyProfitTo' => 0 ,
                                /*Filter*/
                                'HasFilterToColumns' => false,
                                'Limit' => 1,
                                'Offset' => 0,
                                'OrderByAsc' => false,
                                'OrderByColumnName' => 'Account'

                            );


                            $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
                            if($PammService->result){
                                $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
                                $Message = $PammService->result->ResponseMessage;
                                switch($Message){
                                    case 'RET_OK':
                                        $qobject='';
                                        if($MonitroingDataList){

                                            foreach ($MonitroingDataList['MonitoringData'] as $object){
                                                $trdr_m = array(
                                                    'AccountId' => $object->AccountId,
                                                    'ActiveFollowers' => $object->ActiveFollowers ,
                                                    'ActiveInvestors' => $object->ActiveInvestors,
                                                    'Balance' => $object->Balance,
                                                    'BrokerId' => $object->BrokerId,
                                                    'Currency' => $object->Currency,
                                                    'CurrentTrades' => $object->CurrentTrades,
                                                    'DailyProfit' => $object->DailyProfit,
                                                    'DailyTotalBalance' => $object->DailyTotalBalance,
                                                    'DailyTotalEquity' => $object->DailyTotalEquity,
                                                    'Equity' => $object->Equity ,
                                                    'Month_3_Profit' => $object->Month_3_Profit ,
                                                    'Month_6_Profit' => $object->Month_6_Profit,
                                                    'Month_9_Profit' => $object->Month_9_Profit ,
                                                    'MonthlyProfit' => $object->MonthlyProfit ,
                                                    'ProjectName' => $object->ProjectName ,
                                                    'SimpleRating' => $object->SimpleRating ,
                                                    'SinceRegisteredDays' => $object->SinceRegisteredDays,
                                                    'TotalProfit' => $object->TotalProfit ,
                                                    'TotalTrades' => $object->TotalTrades,
                                                    'WeeklyProfit' => $object->WeeklyProfit
                                                );
                                            }
                                        }
                                        break;

                                    default:
                                        $trdr_m = array(
                                            'AccountId' => '',
                                            'ActiveFollowers' => '',
                                            'ActiveInvestors' => '',
                                            'Balance' => '',
                                            'BrokerId' => '',
                                            'Currency' => '',
                                            'CurrentTrades' => '',
                                            'DailyProfit' => '',
                                            'DailyTotalBalance' => '',
                                            'DailyTotalEquity' => '',
                                            'Equity' => '',
                                            'Month_3_Profit' => '',
                                            'Month_6_Profit' => '',
                                            'Month_9_Profit' => '',
                                            'MonthlyProfit' => '',
                                            'ProjectName' => '',
                                            'SimpleRating' => '',
                                            'SinceRegisteredDays' => '',
                                            'TotalProfit' => '',
                                            'TotalTrades' => '',
                                            'WeeklyProfit' => ''
                                        );
                                }

                            }

                            $data['infor2']=$trdr_m;
                            /*get my conditions*/

                            $webservice_config3 = array(
                                'server' => 'pamm'
                            );
                            $account_info = array(
                                'iPammTrader' =>$account_number,
                            );
                            $PammService2 = new PammService($webservice_config3);
                            $PammService2->open_GetConditionsSetOfPammTrader($account_info);
                            $PTConditionPackage = (array) $PammService2->request_status;
                            foreach ( $PTConditionPackage['PTConditionPackage'] as $object){
                                $time =  $this->convert_sec_to_dy_hr($object->MinimumInvestmentTimeInSeconds);
                                $infor3[$object->ConditionSetNumber]=array(
                                    'days'=> $time['day'],
                                    'hours'=> $time['hour'],
                                    'project_share'=>$object->ProjectShare,
                                    'prepaymentinvestmentsum'=>$object->PenaltyPersentBack,
                                    'status'=>($object->IsConditionEnable==True)? 1 : 0,
                                    'apply_investment_from'=>$object->MinInvestmentAmount
                                );
                            }
                            /*get my conditions*/

                            $data['infor3']=$infor3;

                            $trader = true;
                            break;
                        case 1 :
                            // Investor
                            // echo 'Investor';

                            break;
                        case 2 :
                            // PArtner
                            // echo 'Partner';
                            redirect(fxpp::loc_url('pamm'));
                            break;
                        default:
                            // echo 'not registered';
                    }

                    break;
                default:
                    //  echo 'not registered';
            }
        }


        $data['active_tab'] = 'pamm';
        $data['active_sub_tab'] = '';
        $data['title_page'] = lang('sb_li_9');
        $data['tab']=4;

        $data['pamm_type']='Real';

        switch($trdr_m['BrokerId']){
            case 0:
                $data['broker']='Forexmart';
                break;
            case 1:
                $data['broker']='Instaforex';
                break;
            default:
                $data['broker']='Others';

        }

        switch($r_t_p['show_account_name']){
            case 0:
                $data['gi_show_account_name'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                break;
            case 1:
                $data['gi_show_account_name'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                break;
            case 2:
                $data['gi_show_account_name'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                break;
        }

        switch($r_t_p['show_icq']){
            case 0:
                $data['gi_show_icq'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                break;
            case 1:
                $data['gi_show_icq'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                break;
            case 2:
                $data['gi_show_icq'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                break;
        }


        switch($r_t_p['show_skype']){
            case 0:
                $data['gi_show_skype'] = (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ;
                break;
            case 1:
                $data['gi_show_skype'] = (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ;
                break;
            case 2:
                $data['gi_show_skype'] = (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ;
                break;
        }

        $nav = array(
            'registered'=>false,
            'is_disable'=>$disabled=false,
            'trader'=> false,//set to false because account is only from monitoring
            'tab'=>0
        );

        $data['nav'] = $this->load->view('pamm/nav', $nav,TRUE);

        $data['gi_percentsymbol'] = '%';
        $data['metadata_description'] = lang('pamm_dsc');
        $data['metadata_keyword'] = lang('pamm_kew');
        $this->template->title(lang('pamm_tit'))
            ->set_layout('internal/main')
            ->append_metadata_css("
                    <link type='text/css' rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                    <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                ")
            ->append_metadata_js("
                    <script src='".$this->template->Js()."jquery-ui.js'></script>
                    <script src='".$this->template->Js()."jquery.validate.min.js'></script>
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
            ->build('pamm/my-monitoring-users', $data);
    }

// ajax

    public function agreeInvestmentPost(){
        if (!$this->input->is_ajax_request()) {
          show_404();
        }

        $webServiceCongif1 = array(
            'server' => 'pamm'
        );
        $WebService2 = new WebService($webServiceCongif1);
                    $time = new DateTime($this->input->post('Time'));
                    $time= $time->format('Y-m-d\TH:i:s');

        $account_info = array(
                'AccountBrokerId'   => $this->input->post('AccountBrokerId'),
                'AccountId'         => $this->input->post('AccountId'),
                'InvestmentAmount'  => $this->input->post('InvestmentAmount'),
                'InvestmentId'      => $this->input->post('InvestmentId'),
                'OwnerBrokerId'     => $this->input->post('OwnerBrokerId'),
                'OwnerId'           => $this->input->post('OwnerId'),
                'Profit'            => $this->input->post('Profit'),
                'Return'            => $this->input->post('Return'),
                'Share'             => $this->input->post('Share'),
                'Status'            => $this->input->post('Status'),
                'StatusDescription' => $this->input->post('StatusDescription'),
                'Time'              => $time
        );
       $WebService2->open_AcceptInvestmentRequest($account_info);
        echo json_encode($WebService2->result);
    }

    public function rollOverByInvestorPost(){
        if (!$this->input->is_ajax_request()) {
          show_404();
        }
        $webServiceCongif1 = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webServiceCongif1);
        $account_info = array(
                'investmentId' => $this->input->post('investmentId'),
                'iPammInvestor'  => $this->input->post('iPammInvestor'),
                'brokerId'     => 0
                );
       $WebService->open_RolloverByInvestor($account_info);
        echo json_encode($WebService->result);
    }

    public function rollOverByTraderPost(){
        if (!$this->input->is_ajax_request()) {
          show_404();
        }

        $webServiceCongif1 = array(
            'server' => 'pamm'
        );
        
        $WebService = new WebService($webServiceCongif1);
        $account_info = array(
                'investmentId' => $this->input->post('investmentId'),
                'iPammTrader'  => $this->input->post('iPammTrader'),
                'brokerId'     => 0
                );
       $WebService->open_RolloverByTrader($account_info);
        echo json_encode($WebService->result);
    }

    public function returnInvestmentPost(){
        if (!$this->input->is_ajax_request()) {
          show_404();
        }

        // print_r($this->input->post());
        // exit;

        $webServiceConfig = array(
            'server' => 'pamm'
        );
        $WebService = new WebService($webServiceConfig);
                    $time = new DateTime('2017-01-30 10:32:31');
                    $time= $time->format('Y-m-d\TH:i:s');

        $account_info = array(
               'isReturnedByTrader' => $this->input->post('isReturnedByTrader'),
                'AccountBrokerId'   => $this->input->post('AccountBrokerId'),
                'AccountId'         => $this->input->post('AccountId'),
                'InvestmentAmount'  => $this->input->post('InvestmentAmount'),
                'InvestmentId'      => $this->input->post('InvestmentId'),
                'OwnerBrokerId'     => $this->input->post('OwnerBrokerId'),
                'OwnerId'           => $this->input->post('OwnerId'),
                'Profit'            => $this->input->post('Profit'),
                'Return'            => $this->input->post('Return'),
                'Share'             => $this->input->post('Share'),
                'Status'            => $this->input->post('Status'),
                'StatusDescription' => '',
                'Time'              => $time
        );
       $WebService->open_ReturnInvestment($account_info);
  
        echo json_encode($WebService->result);
    }

    public function getCurrentInvestment(){
        $currentUsers = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,mt_currency_base');
        $data['gi_currency'] = $currentUsers['mt_currency_base'];
        $account_info = array(
            'iAccount' => $currentUsers['account_number'],
            'brokerId' => 0,
        );

        // print_r($account_info);

        $WebService = new WebService($this->webservice_config);
        $WebService->open_GetPammAccountInfo($account_info);
        $PammInfo = (array)  $WebService->result;

        if(!$WebService->result){
            echo json_encode($this->$errorWebservice);
            exit;
        }

        if ($PammInfo['Message']!='RET_OK') {
            echo json_encode($this->$errorWebservice);
            exit;
        }

        switch ($PammInfo['AccountType']) {
              case 0:
                $jsonResponse=[];
                $trader =(array) $PammInfo['TraderInfo'];

                    if ($this->input->post('getTradersCurrentInvestment')) {
                        $jsonResponse['getTradersCurrentInvestment'] = $this->getTradersCurrentInvestment($currentUsers['account_number'],$currentUsers['mt_currency_base'],$trader['IsConfirmInvestmentRefund']);
                    }

                    if ($this->input->post('getTradersPastInvestment')) {
                        $jsonResponse['getTradersPastInvestment'] = $this->getTradersPastInvestment($currentUsers['account_number'],$currentUsers['mt_currency_base']);
                    }
                echo json_encode($jsonResponse);
                break;
              case 1:
                $InvestorInfo =(array) $PammInfo['InvestorInfo'];
                $jsonResponse=[];
                    if ($this->input->post('getTradersCurrentInvestment')) {
                        $jsonResponse['getTradersCurrentInvestment'] = $this->getInvestorCurrentInvestment($currentUsers['account_number'],$currentUsers['mt_currency_base'],$InvestorInfo['IsConfirmInvestmentRefund']);
                    }

                    if ($this->input->post('getTradersPastInvestment')) {
                        $jsonResponse['getTradersPastInvestment'] = $this->getInvestorPastInvestment($currentUsers['account_number'],$currentUsers['mt_currency_base']);
                    }
                echo json_encode($jsonResponse);
                  break;
              case 2:
                    $jsonResponse=[];

                    echo json_encode($jsonResponse);
                  break;

              default:
                  # code...
                  break;
          }  


        // print_r($WebService->result);
        // echo "success";

    }

    public function getInvestorCurrentInvestment($accountNumber ,$currency,$IsConfirmInvestmentRefund){
         $account_info = array(
            'iPammInvestor' =>  $accountNumber,
            'brokerId' => 0,
        );

        $WebService = new WebService($this->webservice_config);
        $WebService2 = new WebService($this->webservice_config);
        $WebService->open_GetInvestorCurrentInvestments($account_info);
        $WebService2->open_GetInvestorPendingInvestments($account_info);
        if(!$WebService->result){
            $result = false;
        }

        if(!$WebService2->result){
            $result = false;
        }

        $resultTable = [];
        $result = [] ;
        $total_investments=0;
        $total_return=0;
        $total_profit=0;


        $InvestorPendingInvestments = (array)  $WebService2->result;
        $InvestmentData         = (array)  $WebService->result;

        foreach ($InvestorPendingInvestments['InvestmentData'] as $object) {
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
            $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['Share']             = number_format(0, 2, '.', '').' %';
            // $value['Share']             = number_format($object->Share, 2, '.', '').' %';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = '0'.$currency;
            // $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit.' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = $object->StatusDescription;
            // $value['Operations']        = '<button class="btnInvestment" data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnAccept" data-toggle="modal" data-target="#AcceptInvestmentModal" >Accept</button>';


            // $value['Operations']        = '<button class="btnWithdrawInvestmentInvestor" data-toggle="modal" data-target="#WithdrawInvestmentInvestorModal"  data-AccountId="'.$object->AccountId.'" data-id="'.$object->AccountId.'" id="btnWithdraw">Withdraw Investment</button>';

            $value['Operations']        = '<button class="btnInvestment btnWithdrawInvestment" data-isreturnedbytrader="False"  data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnRefund" data-toggle="modal" data-target="#RefundInvestmentModalTrader"  data-typeOfinvestment="Withdraw Investment" >Withdraw Investment</button>';

            // $value['Operations']      .= ($object->Profit <= 0) ? '' : '<button class="btnInvestment" data-investmentid="'.$object->InvestmentId.'" data-ipamminvestor="'.$object->AccountId.'" id="btnRolloverInvestor"  data-toggle="modal" data-target="#RolloverInvestmentModalInvestor">Rollover</button>';

            array_push($resultTable,$value);
        }

        foreach ( $InvestmentData['InvestmentData'] as $object){
            $total_investments=$total_investments+$object->InvestmentAmount;
            $total_return=$total_return+$object->Return;
            $total_profit=$total_profit+$object->Profit;
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
            $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['Share']             = number_format($object->Share, 2, '.', '').' %';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit .' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = $object->StatusDescription;
            // $value['Operations']        ='<button class="btnWithdrawInvestmentInvestor" data-toggle="modal" data-target="#WithdrawInvestmentInvestorModal"  data-AccountId="'.$object->AccountId.'" data-id="'.$object->AccountId.'" id="btnWithdraw">Withdraw Investment</button>';



            if ($IsConfirmInvestmentRefund=='0') {
               $IsConfirmInvestmentRefundBtn = '<button class="btnInvestment btnWithdrawInvestmentInst" data-isreturnedbytrader="False"  data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnRefund"  data-typeOfinvestment="Withdraw Investment"  >Withdraw Investment</button>';
            }else{
               $IsConfirmInvestmentRefundBtn = '<button class="btnInvestment btnWithdrawInvestment" data-isreturnedbytrader="False"  data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnRefund" data-toggle="modal"  data-typeOfinvestment="Withdraw Investment"  data-target="#RefundInvestmentModalTrader" >Withdraw Investment</button>';
            }

            $value['Operations']        = $IsConfirmInvestmentRefundBtn;


            $value['Operations']      .= ($object->Profit  <= 0 ) ? '' : '<button class="btnInvestment" data-investmentid="'.$object->InvestmentId.'" data-ipamminvestor="'.$object->AccountId.'" id="btnRolloverInvestor"  data-toggle="modal" data-target="#RolloverInvestmentModalInvestor">Rollover</button>';


            array_push($resultTable,$value);
        }

            $result['total_investments']='<tr><td colspan="8" class="txt-L">Total Investments: '.$total_investments.' '.$data['gi_currency'].'</td></tr>';
            $result['total_return']='<tr><td colspan="8" class="txt-L">Total Return: '.$total_return.' '.$data['gi_currency'].'</td></tr>';
            $result['total_profit']='<tr><td colspan="8" class="txt-L">Total Profit (including rollovers): '.$total_profit.' '.$data['gi_currency'].'</td></tr>';
            $result['table']= (array) $resultTable;
        return $result;
    }

    public function getTradersCurrentInvestment($accountNumber = 212164,$currency,$IsConfirmInvestmentRefund){

        $account_info = array(
            'iPammTrader' =>  $accountNumber,
            'brokerId' => 0,
        );

        $WebService = new WebService($this->webservice_config);
        $WebService2 = new WebService($this->webservice_config);
        $WebService->open_GetTraderCurrentInvestments($account_info);
        $WebService2->open_GetInvestmentRequestForApprovalByPT($account_info);

        if(!$WebService->result){
            $result = false;
        }

        if(!$WebService2->result){
            $result = false;
        }

        $resultTable = [];
        $result = [] ;
        $total_investments=0;
        $total_return=0;
        $total_profit=0;

        $InvestmentDataApporval = (array)  $WebService2->result;
        $InvestmentData = (array)  $WebService->result;

        $numbering = 0;
        foreach ($InvestmentDataApporval['InvestmentData'] as $object) {
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
            $numbering = $numbering + 1;
            // $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['AccountId']         = $object->AccountId;            
            $value['Share']             = number_format(0, 2, '.', '').' %';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = '0'.$currency;
            // $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit.' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = $object->StatusDescription;
            $value['Status']            = $object->Status;
            $value['numbering']         = $numbering;
            $value['Operations']        = '<button class="btnInvestment btnWithdrawInvestment" data-isReturnedByTrader="True" data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnAccept" data-toggle="modal" data-target="#AcceptInvestmentModal" >Accept</button>';
             $value['Operations']        .= ' <button class="btnInvestment btnWithdrawInvestment" data-isReturnedByTrader="True" data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnRefund" data-toggle="modal" data-target="#RefundInvestmentModalTrader"  data-typeOfinvestment="Decline">Decline</button>'; 

            array_push($resultTable,$value);
        }

        foreach ( $InvestmentData['InvestmentData'] as $object){
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
            $numbering = $numbering + 1;
            $total_investments=$total_investments+$object->InvestmentAmount;
            $total_return=$total_return+$object->Return;
            $total_profit=$total_profit+$object->Profit;
            $value['AccountId']         = $object->AccountId;            
            // $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['Share']             = round($object->Share, 2).' % ';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit.' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = $object->StatusDescription;
            $value['Status']            = $object->Status;
            $value['numbering']         = ($object->Status == '9999') ? 0 : $numbering;
            $IsConfirmInvestmentRefundBtn = '';

            if ($IsConfirmInvestmentRefund=='0') {
               $IsConfirmInvestmentRefundBtn = '<button class="btnInvestment btnWithdrawInvestmentInst" data-isReturnedByTrader="True" data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" data-typeOfinvestment="Refund Investment"  id="btnRefund">Refund Investment</button>';
            }else{
               $IsConfirmInvestmentRefundBtn = '<button class="btnInvestment btnWithdrawInvestment" data-isReturnedByTrader="True" data-accountid="'.$object->AccountId.'" data-ownerid="'.$object->OwnerId.'"   data-investmentid="'.$object->InvestmentId.'" data-share="'.$object->Share.'" data-investmentamount="'.$object->InvestmentAmount.'"    data-return="'.$object->Return.'" data-profit="'.$object->Profit.'"   data-date="'.$DateT->format('Y-m-d H:i:s').'"   data-statusdescription="'.$object->StatusDescription.'" data-status="'.$object->Status.'" id="btnRefund" data-toggle="modal"  data-typeOfinvestment="Refund Investment" data-target="#RefundInvestmentModalTrader" >Refund Investment</button>';
            }

            $value['Operations']        = ($object->Status == '9999') ? 'N/A' :   $IsConfirmInvestmentRefundBtn ;

            if (!$object->Status == '9999') {
                $value['Operations']       .= ($object->Profit > 0 ) ? '<button class="btnInvestment" data-investmentid="'.$object->InvestmentId.'" data-ipammtrader="'.$object->OwnerId.'"  id="btnRolloverTrader"  data-toggle="modal" data-target="#RolloverInvestmentModal">Rollover</button>' : '';
            }


            array_push($resultTable,$value);
        }



        usort($resultTable, function($a, $b) {
            return $a['numbering'] - $b['numbering'];
        });

    
        // usort($resultTable, function($a, $b) {
        //        if($a['Status']==$b['Status']) return 0;
        //         return $a['Status'] < $b['Status']?1:-1;
        // });

        // var_dump($resultTable);
        // exit;
   
            $result['total_investments']='<tr><td colspan="8" class="txt-L">Total Investments: '.sprintf("%01.2f", $total_investments).' '.$currency.'</td></tr>';
            $result['total_return']='<tr><td colspan="8" class="txt-L">Total Return: '.sprintf("%01.2f", $total_return ).' '.$currency.'</td></tr>';
            $result['total_profit']='<tr><td colspan="8" class="txt-L">Total Profit (including rollovers): '.sprintf("%01.2f",$total_profit).' '.$currency.'</td></tr>';
            $result['table']= (array) $resultTable;

        return $result;
     }


    public function getTradersPastInvestment($accountNumber,$currency){
        $account_info = array(
            'iPammTrader' =>  $accountNumber,
            'brokerId' => 0,
        );
        $resultTable = [];
        $WebService = new WebService($this->webservice_config);
        $WebService->open_GetTraderPastInvestments($account_info);
        $InvestmentData = (array)  $WebService->result;
        if(!$WebService->result){
            $resultTable = false;
        }
        foreach ( $InvestmentData['InvestmentData'] as $object){
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
            // $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['AccountId']         = $object->AccountId;
            $value['Share']             = round($object->Share, 2).' %';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit .' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = $object->StatusDescription;
            $value['Operations']        ='N/A';
            array_push($resultTable,$value);
        }
        return $resultTable;
    }

    public function getInvestorPastInvestment($accountNumber = 224196,$currency){
        $account_info = array(
            'iPammInvestor' =>  $accountNumber,
            'brokerId' => 0,
        );
        $resultTable = [];
        $WebService = new WebService($this->webservice_config);
        $WebService->open_GetInvestorPastInvestments($account_info);
        $InvestmentData = (array)  $WebService->result;
        if(!$WebService->result){
            $resultTable = false;
        }
        foreach ( $InvestmentData['InvestmentData'] as $object){
            $DateT  = DateTime::createFromFormat('Y-m-d\TH:i:s', $object->Time);
           
            $value['AccountId']         = '<a href="https://my.forexmart.com/pamm/monitoring_user/'.$object->OwnerId.'" > '.$object->OwnerId.'</a>';
            $value['Share']             = round($object->Share, 2).' %';
            $value['InvestmentAmount']  = $object->InvestmentAmount.' '.$currency;
            $value['Return']            = $object->Return.' '.$currency;
            $value['Profit']            = $object->Profit.' '.$currency;
            $value['Time']              = $DateT->format('Y-m-d H:i:s').' ( UTC+2 )';
            $value['StatusDescription'] = ' '.$object->StatusDescription;
            $value['Operations']        = 'N/A';
            array_push($resultTable,$value);
        
        }
        return $resultTable;
    }

// start test
    public function pammtestMethod(){
        // exit;
        $webServiceCongif1 = array(
            'server' => 'pamm'
        );
        // $WebService2 = new WebService($webServiceCongif1);
        $WebService1 = new WebService($webServiceCongif1);
        $account_info = array(
            // 'investmentId' => 2000106,
            // 'iPammTrader' => 212164,
            'iPammInvestor' =>  224196,
            'brokerId' => 0
        );
        // $WebService2->open_GetInvestorCurrentInvestments($account_info);
        $WebService1->open_GetInvestorPendingInvestments($account_info);


        // $PammInfo = (array)  $WebService2->result;

        print_r(  $WebService1);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        // print_r(  $WebService2);
    }





    public function pammtestAjax(){
        echo json_encode($_POST);
    }
// emdtest


// from other controller /query

    public function make_newinvestment_request(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->load->model('Account_model');


        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $data['mycondition']           = $this->input->post('mycondition',true);
        $data['trader_account_number'] = $this->input->post('trader_account_number',true);
        $data['investment_sum']        = $this->input->post('investment_sum',true);
        $data['affiliate_account']     = '';

        if($this->session->userdata('login_type') == 1){
            /*partner account*/
        }else{
            /*client account*/
            /*get clients account number*/
            $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='account_number,mt_currency_base');
            $accountnumber = $data['mtas']['account_number'];
            /*get users affiliate referral code process*/
            $data['users_affiliate_code'] = $this->general_model->showssingle($table='users_affiliate_code',$id='users_id', $field=$_SESSION['user_id'],$select='referral_affiliate_code');
            /*get referral code affiliates user id*/
            // if ($data['users_affiliate_code']['referral_affiliate_code']==null OR $data['users_affiliate_code']['referral_affiliate_code']==''){

            // }else{
            //     $data['users_affiliate_codes2'] = $this->general_model->showssingle($table='users_affiliate_code',$id='affiliate_code', $field= $data['users_affiliate_code']['referral_affiliate_code'],$select='user_id');
            //     if($data['users_affiliate_codes2']){
            //         /*referrer is client account*/
            //         $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field= $data['users_affiliate_codes2']['user_id'],$select='account_number');
            //         if($data['mtas2']){
            //             $data['affiliate_account']=$data['mtas2']['account_number'];
            //         }

            //     }else{
            //         /*check if referrer is partner account*/
            //         $data['partnership_affiliate_code'] = $this->general_model->showssingle($table='partnership_affiliate_code',$id='affiliate_code', $field= $data['users_affiliate_codes2']['user_id'] ,$select='partner_id');

            //         if($data['partnership_affiliate_code']){
            //             $data['partnership'] = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=  $data['partnership_affiliate_code']['partner_id'] ,$select='reference_num');
            //             if($data['partnership']){
            //                 $data['affiliate_account']= $data['partnership']['reference_num'];
            //             }
            //         }
            //     }
            // }

            /*get account number of affiliate via user id*/

            $webservice_config = array(
                'server' => 'pamm'
            );
            $PammService = new WebService($webservice_config);
             $account_info = array(
                   // 'AffiliateAccount' => ($data['affiliate_account']=="")?$data['trader_account_number']:$data['affiliate_account'] ,
                  'AffiliateAccount' => $data['trader_account_number'],
                 'ConditionSetNumber' => $data['mycondition'],
                           'Currency' => $data['mtas']['mt_currency_base'],
                             'InvSum' => $data['investment_sum'] ,
             'InverstorAccountNumber' => $data['mtas']['account_number'],
                     'InvestorBroker' => 0,
                        'OwnerBroker' => 0,
                            'OwnerId' => $data['trader_account_number'],
             );
            $data['accountinfo']=$account_info;
            $PammService->open_NewInvestmentRequest($account_info);
            if($PammService->result){
                $PammInfo = (array)  $PammService->result;
//                $PammInfo['NewInvestmentData'];
                switch($PammInfo['Message']){
                       case 'RET_FOR_PT_APPROVAL':
                           $NewInvestmentData = (array) $PammInfo['NewInvestmentData'];
                           $data['response']=array(
                               'AccountBrokerId' => $NewInvestmentData['AccountBrokerId'],
                                     'AccountId' => $NewInvestmentData['AccountId'],
                              'InvestmentAmount' => $NewInvestmentData['InvestmentAmount'],
                                  'InvestmentId' => $NewInvestmentData['InvestmentId'],
                                 'OwnerBrokerId' => $NewInvestmentData['OwnerBrokerId'],
                                       'OwnerId' => $NewInvestmentData['OwnerId'],
                                        'Profit' => $NewInvestmentData['Profit'],
                                        'Return' => $NewInvestmentData['Return'],
                                         'Share' => $NewInvestmentData['Share'],
                                        'Status' => $NewInvestmentData['Status'],
                                          'Time' => $NewInvestmentData['Time'],
                                       'Message' => $PammInfo['Message'],
                                   'PageMessage' => 'Request is successful , Investment Id = '. $NewInvestmentData['InvestmentId'] . ' is for approval',
                                          'show' => '1',
                                      'response' => 'Request is successful , Investment Id = '. $NewInvestmentData['InvestmentId'] . ' is for approval'
                           );
                           $config = array('server' => 'live_new');
                           $WebService = new WebService($config);
                           $WebService->request_live_account_balance( $data['mtas']['account_number']);
                            $balance = $WebService->get_result('Balance');
                           if ($WebService->request_status === 'RET_OK') {
                               /*Update local database balance*/
                                $data['response']=array(
                                  'response'=>'Request Success',
                                  'Message'=> $PammInfo['Message'],
                                  'PageMessage' => '2',
                                  'show' => '1'
                                );

                           }

                        break;
                        case 'RET_OK':
                            $data['response']=array(
                                'response'=>'Request Success',
                                'Message'=> $PammInfo['Message'],
                                'PageMessage' => '2',
                                  'show' => '1'
                            );
                            $config = array(
                                'server' => 'live_new'
                            );
//                            $WebService1 = new WebService($config);

//                            if(IPLoc::APIUpgradeDevIP()){
                                $WebServiceNew = FXPP::DepositRealFund($accountnumber, $data['investment_sum'], 'PAMM_INVESTMENTS_ACCEPT' . $this->comment_transaction_type['PAYPAL'] . '11');
                                $requestResult = $WebServiceNew['requestResult'];
                                $ticket        = $WebServiceNew['ticket'];
//                            }else{
//                                $WebService1->update_live_deposit_balance($accountnumber, $data['investment_sum'], 'PAMM_INVESTMENTS_ACCEPT' . $this->comment_transaction_type['PAYPAL'] . '11');
//                                $requestResult = $WebService1->request_status;
//                                $ticket        = $WebService1->get_result('Ticket');
//                            }

                            if ($requestResult === 'RET_OK') {

                            }

                        break;
                        case 'RET_NOT_ENOUGH_BALANCE':
                            $data['response']=array(
                              'response'=>'Account balance is not enough.',
                              'Message'=> $PammInfo['Message'],
                              'PageMessage' => 'Request not enough balance',
                                'show' => '2'
                            );
                        break;

                        default:
                        $data['response']=array(
                            'response' => 'API error.',
                             'Message' => $PammInfo['Message'],
                         'PageMessage' => $PammInfo['Message'],
                            'show' => '2'
                        );
                }
            }

        }

        echo json_encode($data);
    } 

    public function get_livefeed(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->lang->load('pamm');
        $webservice_config = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config);

        $livefeed_trade= array();
        $PammService->open_GetLiveFeeds();

        if($PammService->result){
            $LiveFeedData =  (array) $PammService->result->LiveFeedData;
            //            var_dump($LiveFeedData);
            if($LiveFeedData){
                foreach ($LiveFeedData as $object){
                    preg_match('#\((.*?)\)#', $object->Feed, $match);
                    array_push($livefeed_trade,array('feed'=>$object->Feed,'timestamp'=>$object->TimeStamp,'account_number' =>$match[1]) );
                }
            }

        }
        $count = 0; /* counter for closed and opened trades*/
        $accounts = ''; /* counter for closed and opened trades*/
        $realcount = 0;



        $data['livefeedwidget']='';
        foreach ( $livefeed_trade as $key=>$value){

            $tradesandpamm = array(
                'trader_info'=> $value['feed'],
                'flag'=> 'flag.png',
                'trader_timestamp'=> $value['timestamp'],
                'account_monitoring'=> '?trader='.$value['account_number'],
                'widget'=>'my_widgets',
                'trader_account'=> $value['account_number'],

            );

            $data['livefeedwidget'] .= $this->load->view('pamm/live-feed_widget', $tradesandpamm , TRUE);
        }

        echo json_encode($data);
        // unset($data);
    }

    public function requestFinanceRecordsByTransactionIdForPamm(){
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
            // exit;
            $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='account_number');
            $arrayName = array(
                'iLogin' => $data['mtas']['account_number'],
                'transactionId' => 11,
                'from' => date('Y-m-d\TH:i:s', strtotime($this->input->post('date_start').' 00:00:00')),
                'to' =>  date('Y-m-d\TH:i:s', strtotime($this->input->post('date_end').' 23:59:59'))

                // 'from' => date('Y-m-d\TH:i:s', strtotime('5/19/2016 17:30:00')),
                // 'to' =>  date('Y-m-d\TH:i:s', strtotime('5/19/2017 17:30:05'))



            );

            $webservice_config = array('server' => 'live_new');
            $WebService2 = new WebService($webservice_config);
            $WebService2->RequestFinanceRecordsByTransactionIdForPamm($arrayName);

            $data['result'] = $WebService2->result         ;
            $data['request_status'] = $WebService2->request_status ;
            // print_r($data['result']);
            // exit;
            if ( $data['request_status'] == 'RET_OK') {
                
                $arrayName = [];

               foreach($WebService2->result as $object){
                    $value['AccountNumber']  = (string) $object->AccountNumber; 
                    $value['FundType']       = (string) $object->FundType;      
                    $value['Ticket']         = (string) $object->Ticket;      
                    $value['Amount']         = (string) $object->Amount;        
                    $value['Stamp']          = (string) date("Y-m-d H:i:s", strtotime($object->Stamp));         
                    $value['Comment']        = (string) $object->Comment; 
                    array_push($arrayName,$value);

                }
                // var_dump($arrayName);
                echo json_encode($arrayName);
            }
            
            // return $data;
    }







}