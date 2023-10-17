<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Zeta-Jenalie
 * Date: 8/13/2018
 * Time: 8:51 PM
 */

class Tester extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $VPN_IP = array(
            '195.201.40.47'
        );

//       if (!IPLOC::Office() && !in_array($this->input->ip_address(), $VPN_IP)) {
//           show_404();
//       }

       $this->load->model('deposit_model');
       $this->load->model('account_model');
       $this->load->model('partners_model');
       $this->load->model('user_model');
       $this->load->model('General_model');
       $this->load->model('Withdraw_model');
       $this->load->model('withdraw_model');
       $this->load->library('Transaction');
       $this->g_m = $this->General_model;
       $this->load->helper('cookie');
     //  $this->pageVisitor(); // page monitoring
       $isPartner = $this->session->userdata('login_type');
       if ($isPartner == 1) {
           $this->isPartner = true;
       }

       $this->output->enable_profiler(TRUE);
    }

    protected $removeBonusesComment =  array(
        1 => 'FM BONUS 30% CANCELLATION',
        2 => 'FM 100% NDB CANCELLATION',
        28 => 'FM BONUS 20% CANCELLATION',
        7 => 'BONUS_CONTEST_PRIZE_CANCELLATION',
        10 => 'FM BONUS 50% CANCELLATION',
        12 => 'FM_CONTEST_MF_CANCELLATION'
    );

    protected $depositMethods = array(
        1 => 'Deposit_30PercentBonus',
        2 => 'Deposit_NoDepositBonus',
        28 => 'Deposit_20PercentBonus',
        7=> 'Deposit_ContestPrizeBonus',
        10 => 'Deposit_50_PercentBonus',
        12 => 'Deposit_Contest_MF_Prize_Bonus'
    );


    function email_check(){
        ini_set('max_execution_time', 0);
        $this->load->library('email');
        $this->email->clear(TRUE);
        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->to('bug.fxpp123@gmail.com');
        $this->email->subject('Email test');
        $this->email->message('Message');
      echo  $this->email->send();
      echo $this->email->print_debugger();
    }


   

    function smartDollerTEST(){
        $this->load->library('FXAPI');
echo "<pre>";
         FXAPI::getInstance(SMART_DOLLAR);
          $ret = FXAPI::GetCurrentSmartDollar(array());
          print_r($ret);
          //Status = ‘ALL’, ‘PENDING’, ‘EXPIRED’, ‘COMPLETED’
        
         
        //   $ret2 = FXAPI::GetSmartDollarHistory(array('Limit'=>10,'Offset'=>0,'Status'=>'COMPLETED'));
        //   print_r($ret2);

          $ret2 = FXAPI::GetSmartDollarHistory(array('Limit'=>10,'Offset'=>0,'Status'=>'ALL'));
          print_r($ret2);

        //   $ret =  FXAPI::RequestToWithdraw(array('FromTicket'=>13400255,'ToTicket'=>13400255));
        //   print_r($ret);
           print_r(FXAPI::getArguments());
         

    }
   

    function newAPI(){

        $this->load->library('FXAPI');

        // FXAPI::getInstance(SMART_DOLLAR);
        //   $ret = FXAPI::GetCurrentSmartDollar(array());
        //  print_r($ret);

        $input = array(
            'From'   =>  0 ,
            'Limit'  =>  100,
            'Offset' =>  0,
            'To'     =>  0,
            'Accounts'=>array(58064637 ));
        
        $ret = FXAPI::authorize(array('Login'=>58064637,'Password'=>'LgUEg2F','email'=>''));
        $_SESSION['session_id'] = $ret['data']->SessionId;
        $_SESSION['account_number'] = $ret['data']->Login;
        print_r($ret);


        $ret = FXAPI::GetAccountDetails($input);
        print_r($ret);

        $ret = FXPP::getMTUserDetails(58064637);
        print_r($ret);

        $ret = FXPP::getMTUserDetails2(58064637);
        print_r($ret);

        // $ret = FXAPI::GetAccountFunds($input);
        // print_r($ret);



        // $objApi = new FXAPI();       
        // $input = array(
        //     'From'   =>  0 ,
        //     'Limit'  =>  100,
        //     'Offset' =>  0,
        //     'To'     =>  0,
        //     'Accounts'=>array(192912,58041786));

        //     $ret = $objApi->getData('authorize',array('Login'=>192912,'Password'=>'KxSPYLG','email'=>''));
        //     print_r($ret);
        //     $ret = $objApi->getData('GetAccountDetails',$input);          
        //     print_r($ret);
        //     $ret = $objApi->getData('GetAccountFunds',$input);
        //     print_r($ret);  


    }


    function bonusCheck(){

        $withdrawAmount = 400;
        $accountNumber = '58030227';
        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);
        $profit  = FXPP::realProfit($accountNumber);

        $removeBonuses = $this->removeBonusesComment;
        $accountFunds = FXPP::getAccountFunds($accountNumber);
        $apiJson = json_encode($accountFunds); // reference only
        $bonusFund = $accountFunds['bonus_fund'];
        var_dump($getAccountBonusByType);
        var_dump($profit);
        foreach($getAccountBonusByType as $key => $bonuses){
            if(array_key_exists($key, $removeBonuses)) {
                if($bonuses > 0){
                    echo "bonus ID: ". $key. " ".$bonuses;
                //check bonus to deduct based on withdraw amount
                if ($key == 1) {
                    $real_bonus_fund = round($accountFunds['withrawable_real_fund'] * 0.30, 2);
                    if ($real_bonus_fund < $accountFunds['bonus_fund']) {
                        $bonuses = $accountFunds['bonus_fund'] - $real_bonus_fund;
                    } elseif ($accountFunds['withrawable_real_fund'] <= 0) {
                        $bonuses = $accountFunds['bonus_fund'];
                    } else {
                        $bonuses = 0;
                    }

                } elseif ($key == 28) {
                    $real_bonus_fund = round($accountFunds['withrawable_real_fund'] * 0.20, 2);
                    // $real_bonus_fund = $amountDeducted; // for 20 percent bonus, withdrawal amount is equivalent to amount of bonus cancelled
                    if ($withdrawAmount > $profit) {
                        if ($real_bonus_fund < $accountFunds['bonus_fund']) {
                            $bonuses = $accountFunds['bonus_fund'] - $real_bonus_fund;
                        } elseif ($accountFunds['withrawable_real_fund'] <= 0) {
                            $bonuses = $accountFunds['bonus_fund'];
                        } else {
                            $bonuses = 0;
                        }
                    }

                } elseif ($key == 10) {
                    $real_bonus_fund = round($accountFunds['withrawable_real_fund'] * 0.50, 2);
                    if ($real_bonus_fund <= $accountFunds['bonus_fund']) {
                        $bonuses = $accountFunds['bonus_fund'] - $real_bonus_fund;
                    } elseif ($accountFunds['withrawable_real_fund'] <= 0) {
                        $bonuses = $accountFunds['bonus_fund'];
                    } else {
                        $bonuses = 0;
                    }
                } else if ($key == 7 || $key == 12) {

                }
            }
        }
    }

    var_dump($bonuses);
    }

    function loadingTest(){
        echo 'Load test';
    }


    public function deposit_finance()
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->lang->load('depositwithdraw');
        $this->lang->load('sidebar');

        if ($this->session->userdata('logged')) {
            //**my_account/index /
            $_SESSION['redirect'] = null;
            //**End**//

            if (!IPLoc::Office()) {
                FXPP::LoginTypeRestriction();
            }

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');

            $mtas2 = $this->general_model->showssingle($table = 'mt_accounts_set', $id = 'user_id', $field = $user_id, $select = 'mt_currency_base');

            switch ($mtas2['mt_currency_base']) {
                case 'RUB':
                    $depositAmount = array("1000000", "500000", "300000", "100000", "50000", "30000", "10000 ", "5000", "3000", "1000", "500");
                    $currency1 = '<i class="fa fa-rub" aria-hidden="true"></i>';
                    $currency2 = '<i class="fa fa-rub" aria-hidden="true"></i>';
                    break;
                case 'GBP':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = '<i class="fa fa-gbp" aria-hidden="true"></i>';
                    $currency2 = '<i class="fa fa-gbp" aria-hidden="true"></i>';
                    break;
                case 'EUR':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = '<i class="fa fa-eur" aria-hidden="true"></i>';
                    $currency2 = '<i class="fa fa-eur" aria-hidden="true"></i>';
                    $cur_eur = '<i class="fa fa-gbp" aria-hidden="true"></i>';
                    break;
                case 'MYR':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = 'RM';
                    $currency2 = 'RM';
                    break;
                case 'IDR':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = 'Rp';
                    $currency2 = 'Rp';
                    break;
                case 'THB':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = '&#3647;';
                    $currency2 = '&#3647;';
                    break;
                case 'CNY':
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = '<i class="fa fa-cny" aria-hidden="true"></i>';
                    $currency2 = '<i class="fa fa-cny" aria-hidden="true"></i>';
                    break;
                default:
                    $depositAmount = array("10000", "5000", "3000", "1000", "500", "250", "100", "50", "30", "20", "10");
                    $currency1 = '<i class="fa fa-usd" aria-hidden="true"></i>';
                    $currency2 = '<i class="fa fa-usd" aria-hidden="true"></i>';
            }

            if ($mtas2['mt_currency_base'] == 'EUR') {
                $data['title'] = lang('ch_tip_eur_p');
                $amount_tip = '<a data-toggle="tooltip" data-placement="top" title="' . $data['title'] . '"><i class="fa fa-exclamation-circle"></i></a>';
            } else {
                $data['title2'] = lang('ch_tip_usd_p');
                $amount_tip = '<a data-toggle="tooltip" data-placement="top" title="' . $data['title2'] . '"><i class="fa fa-exclamation-circle"></i></a>';
            }

            $data['cur_eur'] = $cur_eur;
            $data['tip'] = $amount_tip;

            $data['depositAmount'] = $depositAmount;
            $data['currency'] = $currency1;
            $data['currency2'] = $currency2;
            $data['base_currency'] = $mtas2['mt_currency_base'];
            $data['title_page'] = lang('sb_li_2');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'deposit';
            $data['metadata_description'] = lang('dep_dsc');
            $data['metadata_keyword'] = lang('dep_kew');

            $nodepositbonus = $this->g_m->showssingle2('users', 'id', $user_id, 'nodepositbonus,created,createdforadvertising');
            $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($user_id);

            $data['loginType'] = $this->session->userdata('login_type');
            $ForMarStaAcc = false ; //FXPP::get_standardgroup_v2($_SESSION['account_number']);
            if ($ForMarStaAcc) {
                $data['IsStandardAccount'] = true;
            } else {
                $data['IsStandardAccount'] = false;
            }

            $data['isSupporter'] = false;
//                if ($account = $this->g_m->whereCondition('all_accounts', array('user_id' => $user_id))) {
           
              //  $data['isSupporter'] = FXPP::isSupporterAccounts($account_number);
           


            $bonus_selection = 'hdb';
            if ($nodepositbonus['nodepositbonus'] == 1) {
                $bonus_selection = 'ndb';
            } else {
                if ($first_bonus_acquired) {
                    if ($first_bonus_acquired['fiftypercentbonus'] == 1) {
                        $bonus_selection = 'fpb';
                    }elseif ($first_bonus_acquired['twentypercentbonus'] == 1) {
                        $bonus_selection = 'twpb';
                    } elseif ($first_bonus_acquired['thirtypercentbonus'] == 1) {
                        $bonus_selection = 'tpb';
                    } elseif ($first_bonus_acquired['hundredpercentbonus'] == 1) {
                        $bonus_selection = 'hpb';
                    } elseif ($first_bonus_acquired['fiftypercentlimitedbonus'] == 1) {
                        $bonus_selection = 'hpb';
                    }
                }
            }

            /* FXPP-6333 */
            $isMicro = $this->account_model->isMicro($user_id);
            if ($isMicro) {
                $data['micro'] = 1;
            }
            /* FXPP-6333 */
          //  $data['isNewAccountType'] = FXPP::fmGroupType($account_number);
            $data['login_type'] = $this->session->userdata('login_type');
            $data['bonus_selection'] = $bonus_selection;
            $data['modal_bonus_alert'] = $this->load->ext_view('modal', 'bonus_alert', $data['data'], true);
//            if(IPLoc::Office()){
            $data['acc_status'] = $this->general_model->showssingle($table = 'users', $id = 'id', $field = $this->session->userdata('user_id'), $select = 'accountstatus');
            $data['count_status'] = $this->general_model->getCountVerifyStatus($this->session->userdata('user_id'));
            if ($data['count_status']) {
                $data['error_msg'] = 'You are allowed to deposit up to 2000 EUR or equivalent converted amount in other currency starting from registration date, ' .
                    date('F d, Y', strtotime(str_replace('-', '', $data['count_status']['created']))) . ' until ' .
                    date('F d, Y', strtotime(str_replace('-', '', $data['count_status']['count'])))
                    . '. ';
            }
            $data['total_balance'] = ''; // $this->getBalance($mtas2['mt_currency_base']);
            $data['cur_base'] = $mtas2['mt_currency_base'];
//            }
            $css = $this->template->Css();
            $this->template->title(lang('dep_tit'))
                ->append_metadata_css("
                        <link rel='stylesheet' href='" . $css . "/finance-style.css'>
                        <link rel='stylesheet' href='" . $css . "/finance-style-v2.css'>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata("")
                ->build('deposits/deposit_finance_v2', $data);
        } else {
            // redirect('signout');
            $_SESSION['redirect'] = $this->config->item('domain-my') . $_SERVER['REQUEST_URI'];
            $lan = FXPP::html_url();
            if ($lan == "en" || $lan == "EN") {
                $lan = "";
            }
            redirect('' . $lan . '/client/signin');


        }
    }

   

    


    function checkBlance($client_acc_num){

       
        $config = array('server' => 'live_new');
        $WebService = new WebService($config);
        $account_info = array('iLogin' => $client_acc_num);
        $WebService->open_RequestAccountBalance($account_info);
        if ($WebService->request_status === 'RET_OK') {
            $balance = $WebService->get_result('Balance');
            var_dump($balance);
            $converted_amount_1 =  54.96;
            if ($converted_amount_1 > $balance) {
                echo "Transit Transfer failed. Client Account Number";
            }
        }

        echo '<pre>';
        //print_r($this);
    }

    public function testEmail(){

        $email_data = array(
        );
        $subject = "ForexMart MT4 Live Trading Account details";
        $config = array(   'mailtype' => 'html' );
        $isSendSuccess = $this->general_model->sendEmail('test_v2', $subject, 'smsapipp@gmail.com', $email_data,$config);
    }



    /********************************************************
     * JENA | FXPP-9759
     ********************************************************/

    public function dumpCountry(){

        $this->input->ip_address();

//        $IP = $_SERVER['REMOTE_ADDR'];

        $IP = "210.213.232.29";
        $country = IPLoc::getCountryCodeFromIP($IP);

        var_dump($country);
    }

    public function dumpUserDetails(){

        $user_id = $this->session->userdata('user_id');
//        var_dump($user_id);

        $accountDetail = $this->general_model->whereConditionQuery($user_id);

        var_dump($accountDetail);
    }

    public function OfficeIP(){

        $IP = $this->input->ip_address();

        $officeIP = array(
            '210.213.232.29',
        );

        if(in_array($IP, $officeIP)){
            return true;
        }

        return false;
    }

    public function display_spanish_doc(){

        $IP = $this->OfficeIP();

        $data = array();

        if(IPLoc::PHDevIP()){
            $view = $this->load->view("deposit_widget/spanish_accept_risk_declaration", true);
            echo $view;
        }else{
            echo "no document";
        }
    }

    public function DumpAllUserDetails(){
        $this->load->model("account_model");
        $RegIP = $getEmail = $this->account_model->getUserRecord('users', array("id" => 314926));
        var_dump($RegIP[0]['email']);

    }

    public function checkSpanishDoc(){
        $this->load->model("account_model");
        $tableName = "spanish_accept_risks_declaration";
        $hasRecord = $this->account_model->getUserRecord($tableName, array("user_id" => 314926));
        var_dump($hasRecord);

    }

    public function checkBool(){
        $uploadData = array(
            'uploaded_filename' => "27a8f16c6940a48576fded3e45d3bcf53aed0d12377a5028.pdf",
            'uploaded_date'     => date("Y-m-d H:m:s"),
            'status'            => 1, //Pending
        );
        $this->load->library('Fx_mailer');
         Fx_mailer::successfulSpanishUpload("forexmart.tester5@gmail.com", $uploadData);
    }

    public function checkIPCountry(){

        $this->load->model("account_model");
//        $tableName = "mt_accounts_set";
//        $hasRecord = $this->account_model->getUserRecord('mt_accounts_set', array("user_id" => 314926));

//        $ip = $hasRecord[0]['registration_ip'];

//        $code = IPLoc::getCountryCodeFromIP("185.136.151.86");
//
//        $IPLoc = new IPLoc();
//        $country  =  $IPLoc->getCountryCodeFromNetIP("185.136.151.86");
//        // $code = getCountryFromIP($ip);

        $getIP = $this->account_model->getUserRecord('mt_accounts_set', array("user_id" => 314926));
        $countryCode = IPLoc::getCountryCodeFromIP($getIP[0]['registration_ip']);

        if($countryCode == 'ZZ'){
            $IPLoc = new IPLoc();
            $countryCodeCatch = $IPLoc->getCountryCodeFromNetIP($getIP[0]['registration_ip']);

            if(strtoupper($countryCodeCatch) == "ES"){
                var_dump(['zz' => $countryCodeCatch]);
            }else{

            }

        }else{
//            var_dump($countryCode);

            echo "ok";
        }

//        var_dump($countryCode);

    }

    public function dumpCountryCodeByIP($ip){
        $countryCode = IPLoc::getCountryCodeFromIP($ip);

        if($countryCode == 'ZZ'){

            $IPLoc = new IPLoc();
            $countryCodeCatch = $IPLoc->getCountryCodeFromNetIP($ip);

            var_dump(['zz' => $countryCodeCatch]);

        }

        var_dump($countryCode);
    }

    public function checkArabicCountry($filter){

        $test = FXPP::isArabicCountry($filter, 'country');
        var_dump($test);

    }

    public function dumpSession(){
//        $test = $_SESSION();
        $data['email'] = $_SESSION['email'];
        $data['fn'] = $_SESSION['full_name'];
        $data['uci'] = $_SESSION['user_id'];

        var_dump($data);
    }

    public function testWebService($account_number){

        $webservice_config = array('server' => 'live_new');

        $WebService1 = new WebService($webservice_config);
        $WebService1->RequestAccountFunds($account_number);

        $WebService2 = new WebService($webservice_config);
        $WebService2->request_live_account_balance($account_number);

        $data['funds'] = $WebService1->get_result('Withrawable_RealFund');
        $data['balance'] = $WebService2->get_result('Equity');

        $this->load->model("account_model");
        $data['userDetails'] = $this->account_model->getUserDetailsByAccountNumber($account_number);

        $data['bonus_type'] = FXPP::getAccountBonusByType($account_number);

       echo "<pre>",print_r($data, 1),"</pre>";

    }

    public function txnTest(){
        echo '<pre>';
      
    //     $webservice_config = array('server' => 'live_new');

    //     $WebService1 = new WebService($webservice_config);
    //    $result =  $WebService1->open_RequestAccountFinanceRecordsByDate_groupBy( array(
    //         'iLogin' => 58045279, // int Account Number
    //         'from' => '2015-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
    //         'to' => '2021-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            
    //     ));

       

    //     print_r($WebService1->result);

        $webservice_config = array('server' => 'live_new');

        $WebService1 = new WebService($webservice_config);
       $result =  $WebService1->open_RequestAccountFinanceRecordsByDate( array(
            'iLogin' => 58045279, // int Account Number
            'from' => '2015-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            'to' => '2021-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            
        ));       

        print_r($WebService1->result);




    }


    public function txn(){

        $webservice_config = array('server' => 'live_new');

        $WebService1 = new WebService($webservice_config);
        $WebService1->open_RequestAccountFinanceRecordsByDate_groupBy( array(
            'iLogin' => 192912, // int Account Number
            'from' => '2015-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            'to' => '2021-01-01', // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            
        ));

        echo '<pre>';

        $deposit_txn = array();
        $fee_txn = array();
        $other_txn = array();
      
        foreach($WebService1->result['FinanceRecords']->FinanceRecordData as $d){
           
            if( strpos($d->Comment,'DPST_') !== false ){
                $deposit_txn[] = $d;
            }else if(strpos( $d->Comment,'FEES_') !== false){
                $fee_txn[] = $d;
            }
            else{
                $other_txn[] = $d;
            }
            
        }       

        foreach($deposit_txn as $d){
            $txn_id = str_replace('DPST_','',$d->Comment);
            foreach($fee_txn as $k){
                if(strpos($k->Comment,$txn_id) !== false){
                    $d->Amount = ($d->Amount + $k->Amount);
                }
            }
        }

        $txn = ($deposit_txn + $other_txn);
       

    }

    public function netller()
    {


        //$api_key = "cG1sZS0yNjYyMjI6Qi1wMS0wLTVlMjdkZjExLTAtMzAyZDAyMTUwMDgwODlkZTc4MDI2Njk5MGM5NmFlOTkyOTI4NTM2YTYwZDk0NDdiYTUwMjE0MzhjNGZhZDFjZTM5MGUwNTExM2RlNWYwM2NmZWEzNDMzMWQwZDdhZg==";

        $api_key = 'c2luZ2xldXNlLXBtbGUtMjY2MjIyOkItcDEtMC01ZTI3ZGYxMS0wLTMwMmQwMjE1MDA5NzFhODcwZDA0ZjdlMmZhZmRkZjgyODIxYjUxZGU2YTY0NWY0MTMwMDIxNDYwNzY4ZDg4YzhiNmQzOTQ1ZTYxNTY1MzIzYjU1M2E3MjUxY2I4YmE=';

        $array = array(
            'merchantRefNum' => time(),
            //'accountId' => '1001659010',
            'transactionType' => 'PAYMENT',
            'neteller' => array(),
            'paymentType' => 'NETELLER',
            'amount' => 600,
            'currencyCode' => 'USD',
            'customerIp' => $this->input->ip_address(),
            'billingDetails' => array(
                'street' => '',
                'street2' => '',
                'city' => '',
                'zip' => '',
                'country' => 'GB'
            ),
            'returnLinks' => array(
                array('rel' => 'on_completed', 'href' => 'https://my.forexmart.com/deposit/test/test'),
                array('rel' => 'on_failed', 'href' => 'https://my.forexmart.com/deposit/test/test'),
                array('rel' => 'default', 'href' => 'https://my.forexmart.com/deposit/test/test'),
            ),




        );
        //echo json_encode($array); exit();


        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://api.paysafe.com/paymenthub/v1/paymenthandles");
        curl_setopt($ch, CURLOPT_URL, "https://api.test.paysafe.com/paymenthub/v1/paymenthandles");
        //curl_setopt($ch, CURLOPT_URL, "https://private-anon-b7e16e9f09-netellerintegrationguide.apiary-mock.com/paymenthub/v1/paymenthandles");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
        //curl_setopt($ch, CURLOPT_USERPWD,$user);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Basic " . $api_key,
            "Simulator: EXTERNAL"

        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        echo "<pre>";
        //header('Location: '.$response->links[0]->href); die();
        print_r($response);
    }
    public function paytrust($amount){
        $url = "https://api.paytrust88.com/v1/transaction/start";
        $key = 'ZYQORxgQKSkFJQ4b6SPuBJbqs1YCwKuk';
       // $key_vnd = 'xSo50Uad6lp2sHi0l6icOQP0e35zOGWt';
        $parameteres = json_encode(array(
            "currency"              =>'MYR',
            'amount'                => $amount,
            'item_id'               => 'myr'.uniqid(),
            'item_description'      =>"MYR deposit",
            'name'                  =>'Test',
            'return_url'            =>'https://my.forexmart.com/deposit/bank_transfer_myr?status=success',
            'http_post_url'         =>'https://my.forexmart.com/deposit/bank_transfer_myr_status',
            'failed_return_url'     =>'https://my.forexmart.com/deposit/bank_transfer_myr?status=failed',

        ));

            //$url = $this->url;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_USERPWD, $key);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameteres);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $return = curl_exec($ch);
            curl_close($ch);
          var_dump($return); exit();
            if($return){
                $decode = json_decode($return,true);

                return $decode['redirect_to'];
            }else{
                return false;
            }
    }


    public function getFinanceTxn(){
        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $txn = array();
        if($txnResultArray = $this->general_model->whereConditionArray('withdraw',array('user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['reference_number']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('transit_transfer',array('status'=>2,'receiver'=>$account_number))){
            foreach($txnResultArray as $d){
                $txn[$d['transaction_id']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('deposit',array('status'=>2,'user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['mt_ticket']] = $d;
            }
        }

       

        return $txn;


    }



    public function txnCheck()
    {
        $this->lang->load('transactionhistory');
        $this->lang->load('datatable');
        $this->load->library('IPLoc', null);


        if($this->session->userdata('logged')) {
                $user_id = $this->session->userdata('user_id');
                $mtas3 = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='login_type');
                $data['login_type'] = $mtas3['login_type'];
            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
            if( $this->session->userdata('login_type') == 1){
                $data['mtas'] = $this->g_m->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num');
                $data['mtas']['account_number'] = $data['mtas']['reference_num'];
            }else{
                $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');   
            }

            $ticketArray = $this->getFinanceTxn();

                $account_info = array(
                    'iLogin' => $data['mtas']['account_number'],
                    'from' => $data['from']->format('Y-m-d\TH:i:s'),
                    'to' => $data['to']->format('Y-m-d\TH:i:s')
                );
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

            $withdrawalCommentsKey = array(
                'comment_w1' => 'withdrawal',
                'comment_w2' => 'w/d'
            );

//            if(IPLoc::OnlyTest()){
//                echo '<pre>';
//               var_dump( $WebService->get_result('FinanceRecords')); exit();
//            }

            switch($WebService->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('FinanceRecords');
                    $data['holder1']=''; /*Bonus*/
                    $data['holder2']=''; /*Deposit*/
                    $data['holder3']=''; /*Withdraw*/
                    $data['holder4']=''; /*Transfer*/
                    $data['holder5']=''; /*Pamm*/

             //  print_r($tradatalist['FinanceRecordData']); exit();

                    foreach ( $tradatalist['FinanceRecordData'] as $object){
                            if ($object->FundType=='BONUS'){

                                $dtTyp="'$object->FundType'";
                                $dtTrans="'$object->Comment'";
                                $dtAcc="'$object->AccountNumber'";
                                $dtAmnt="'$object->Amount'";
                                $dtDte="'$object->Stamp'";

                                $dtDetails='Details';

                                $data['data']['bonus']=true;

                                $data['holder1'].='<tr onclick="mobViewDetails('.$dtTyp.','.$dtTrans.','.$dtAcc.','.$dtAmnt.','.$dtDte.')">';
                                $data['holder1'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
                                $data['holder1'].='<td class="showDetailsMob">'.$object->Comment.'</td>';      //transaction
                                $data['holder1'].='<td class="crTradesMob">'.$object->AccountNumber.'</td>';  //account
                                $data['holder1'].='<td>'.$object->Amount.'</td>';         //amount
                                //$data['holder1'].='<td>N/A</td>';                         //pay system
                                $data['holder1'].='<td class="crTradesMob">'.$object->Stamp.'</td>';          //date

                                $data['holder1'].='<td class="crTradesWeb crTradesWebStyle">'.$dtDetails.'</td>';
                                $data['holder1'].='</tr>';





                            }
						
 
                            if($object->FundType=='REAL' and $object->Operation=='BONUS_SUPPORTER_FULL' ){
                                if($object->Amount < 0){
                                    $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];
                                    $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                                    if($getWithdrawalTransactionByTicket){

                                        if($getWithdrawalTransactionByTicket['status'] > 0){
                                            switch($getWithdrawalTransactionByTicket['status']){
                                                case 1:
                                                    $withdrawalStatus = 'Processed';
                                                    break;
                                                case 2:
                                                    if($getWithdrawalTransactionByTicket['decline_reference_number'] > 0){
                                                        $withdrawalStatus = $getWithdrawalTransactionByTicket['recall'] ? 'Recalled' : 'Requested';
                                                    }else{
                                                        $withdrawalStatus = 'Requested';
                                                    }

                                                    break;
                                                default:
                                                    $withdrawalStatus = 'N/A';
                                            }

                                            if(!empty($object->Comment)){
                                                $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                                if($getWithdrawalTransactionByTicket['recall']==1){
                                                    $recall_comment = 'Recalled last '.$date_recalled;
                                                }else{
                                                    $recall_comment = $object->Comment;
                                                }
                                                if(IPLoc::Office()){ $recall_comment = $recall_comment.' com1='.$object->Comment; }
                                                $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                            }else{
                                                $comment = 'N/A';
                                            }

                                            if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                                $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                            }else{
                                                $transactionType = 'N/A';
                                            }


                                            $wtTyp="'$object->FundType'";
                                            $wtAcc="'$object->AccountNumber'";
                                            $wtAmnt="'$object->Amount'";
                                            $wtTrans="'$transactionType'";
                                            $wtDte="'$convertStamp'";
                                            $wtStatus="'$withdrawalStatus'";

                                            if(!empty($object->Comment)){
                                                $wtCmts="'$object->Comment'";
                                            }else{
                                                $wtCmts="'N/A'";

                                            }

                                            $wtcall="'--'";
                                            $wtDetails='Details';

                                            $data['data']['withdraw']=true;
                                            $data['holder3'].='<tr onclick="mobViewDetailsWithdraw('.$wtTyp.','.$wtAcc.','.$wtAmnt.','.$wtTrans.','.$wtDte.','.$wtStatus.','.$wtCmts.','.$wtcall.')">';
                                            $data['holder3'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
                                            $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                            $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                            $data['holder3'].='<td class="crTradesMob">'.$transactionType.'</td>';                         //pay system
                                            $data['holder3'].='<td class="crTradesMob">'.$convertStamp.'</td>';          //date
                                            $data['holder3'].='<td class="crTradesMob">'.$withdrawalStatus.'</td>';          //status
                                            $data['holder3'].='<td class="crTradesMob">'.$comment.'</td>';
                                            $data['holder3'].='<td class="crTradesWeb crTradesWebStyle">'.$wtDetails.'</td>';
                                            $data['holder3'].='</tr>';
                                        }

                                    }else{
                                        $data['data']['withdraw']=true;


                                        $wt3Typ="'$object->FundType'";
                                        $wt3Acc="'$object->AccountNumber'";
                                        $wt3Amnt="'$object->Amount'";
                                        $wt3Trans="'N/A'";
                                        $wt3Dte="'$convertStamp'";
                                        $wt3Status="'N/A'";
                                        $wt3Cmts="' '";
                                        $wt3call="' '";
                                        $wt3Details='Details';


                                        $data['holder3'].='<tr onclick="mobViewDetailsWithdraw('.$wt3Typ.','.$wt3Acc.','.$wt3Amnt.','.$wt3Trans.','.$wt3Dte.','.$wt3Status.','.$wt3Cmts.','.$wt3call.')">';
                                        $data['holder3'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                        $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                        $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount

                                        $data['holder3'].='<td class="crTradesMob">N/A</td>';                         //pay system
                                        $data['holder3'].='<td class="crTradesMob">'.$convertStamp.'</td>';          //date
                                        $data['holder3'].='<td class="crTradesMob">N/A</td>';          //status
                                        $data['holder3'].='<td class="crTradesWeb crTradesWebStyle">'.$wt3Details.'</td>';

                                        $data['holder3'].='</tr>';
                                    }
                                }else {

                                    $data['data']['bonus'] = true;


                                    $dt2Typ="'$object->FundType'";
                                    $dt2Trans="'$object->Comment'";
                                    $dt2Acc="'$object->AccountNumber'";
                                    $dt2Amnt="'$object->Amount'";
                                    $pay2Sys="'N/A'";
                                    $dt2Dte="'$object->Stamp'";
                                    $dt2Details='Details';


                                    $data['holder2'].='<tr onclick="mobViewDetails('.$dt2Typ.','.$dt2Trans.','.$dt2Acc.','.$dt2Amnt.','.$dt2Dte.','.$pay2Sys.')">';
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                    $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->AccountNumber . '</td>';  //account
                                    $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                    $data['holder2'] .= '<td class="crTradesMob">N/A</td>';         //amount
                                    $data['holder2'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date
                                    $data['holder2'].='<td class="crTradesWeb crTradesWebStyle">'.$dt2Details.'</td>';
                                    $data['holder2'] .= '</tr>';
                                }
                            }
//
                            if ($object->Operation=='REAL_FUND_DEPOSIT' || $object->Operation=='FEE_COMPENSATION' || $object->Operation=='AFFILIATE_FEE' || $object->Operation=='REFUND'|| $object->Operation=='SUB_IB_COMMISSION'){
//                            if(strlen($object->Comment) >= 5){
//                                if(substr($object->Comment, 0, 5) == 'FEES_'){
//                                    $operation = 'Covered Fee';
//                                }else{
//                                    $operation = $object->Operation;
//                                }
//                            }else{
//                                $operation = $object->Operation;
//                            }

                                if (strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w1'] ) !== false OR strpos(strtolower($object->Comment), $withdrawalCommentsKey['comment_w2'] ) !== false) {

                                    $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                                    $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];

                                    if(!empty($object->Comment)){
                                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                        if($getWithdrawalTransactionByTicket['recall']==1){
                                            $recall_comment = 'Recalled last '.$date_recalled;
                                        }else{
                                            $recall_comment = 'Withdrawal request declined last '.$getWithdrawalTransactionByTicket['date_withdraw'];
                                        }
//                                        if(IPLoc::Office()){
////                                            echo "<pre>";print_r($getWithdrawalTransactionByTicket);
//                                            $recall_comment = $recall_comment.' com2='.$object->Comment; }
                                        $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                    }else{
                                        $comment = 'N/A';
                                    }

                                    if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                        $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                    }else{
                                        $transactionType = 'N/A';
                                    }

                                    $rstat = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                                    $data['data']['withdraw']=true;


                                    $wteTyp="'$object->FundType'";
                                    $wteAcc="'$object->AccountNumber'";
                                    $wteAmnt="'$object->Amount'";
                                    $wteTrans="'$transactionType'";
                                    $wteDte="'$convertStamp'";
                                    $wteStatus="'Declined'";

                                    if(!empty($object->Comment)){
                                        $wteCmts="'$recall_comment'";
                                    }else{
                                        $wteCmts="'N/A'";
                                    }

                                    $wtecall="'$rstat'";
                                    $wteDetails='Details';


                                    $data['holder3'].='<tr onclick="mobViewDetailsWithdraw('.$wteTyp.','.$wteAcc.','.$wteAmnt.','.$wteTrans.','.$wteDte.','.$wteStatus.','.$wteCmts.','.$wtecall.')">';
                                    $data['holder3'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction

                                    $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                    $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                    $data['holder3'].='<td class="crTradesMob">'.$transactionType.'</td>';                         //pay system

                                    $data['holder3'].='<td class="crTradesMob">'.$convertStamp.'</td>';          //date
                                    $data['holder3'].='<td class="crTradesMob">Declined</td>';          //status
                                    $data['holder3'].='<td class="crTradesMob">'.$comment.'</td>';
                                    $data['holder3'].='<td class="crTradesMob">'.$rstat.'</td>';                    //active
                                    $data['holder3'].='<td class="crTradesWeb crTradesWebStyle">'.$wteDetails.'</td>';

                                    $data['holder3'].='</tr>';

                                }else{
                                    $depositTransaction = isset($ticketArray[$object->Ticket])?$ticketArray[$object->Ticket]:false;
                                    if($depositTransaction){
                                        $transactionType = strtoupper($depositTransaction["transaction_type"]);
                                    }else{
                                        $transactionType = 'N/A';
                                    }



                                    if(substr($object->Comment,0,8) === 'DPST_TR_') {
                                        $transID = substr($object->Comment, 15, 10);
                                       // $isITSProcessed = $this->Withdraw_model->getRequestFundTransactionStatus($transID);
                                        $transactionType = 'A/T';

                                    }

                              

                                        $dtTyp="'$object->FundType'";
                                        $dtTrans="'$object->Comment'";
                                        $dtAcc="'$object->AccountNumber'";
                                        $dtAmnt="'$object->Amount'";
                                        $paySys="'$transactionType'";
                                        $dtDte="'$object->Stamp'";

                                        $dtDetails='Details';

                                        $data['data']['deposit'] = true;
                                        $data['holder2'].='<tr onclick="mobViewDetails('.$dtTyp.','.$dtTrans.','.$dtAcc.','.$dtAmnt.','.$dtDte.','.$paySys.')">';
                                        $data['holder2'] .= '<td class="crTradesMob">' . $object->FundType . '</td>';       //type
                                        $data['holder2'] .= '<td>' . $object->Comment . '</td>';      //transaction
                                        $data['holder2'] .= '<td class="crTradesMob">' . $object->AccountNumber . '</td>';  //account
                                        $data['holder2'] .= '<td>' . $object->Amount . '</td>';         //amount
                                        $data['holder2'] .= '<td class="crTradesMob">' . $transactionType . '</td>';                         //pay system
                                        $data['holder2'] .= '<td class="crTradesMob">' . $object->Stamp . '</td>';          //date
                                        $data['holder2'].='<td class="crTradesWeb crTradesWebStyle">'.$dtDetails.'</td>';
                                        $data['holder2'] .= '</tr>';
                                 //   }





                                }


                            }


                        if(IPLoc::Office()){

                            if ( $object->Operation=='INVITE_FRIEND_BONUS' ){

                                $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];
                                $data['last_query'] = $this->db->last_query();
                                $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                                if($getWithdrawalTransactionByTicket){

                                    if($getWithdrawalTransactionByTicket['status'] > 0){
                                        switch($getWithdrawalTransactionByTicket['status']){
                                            case 1:  $withdrawalStatus = 'Processed';  break;
                                            case 2:  $withdrawalStatus =  'Declined'; break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                                        }

                                        if(!empty($object->Comment)){
                                            $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                            if($getWithdrawalTransactionByTicket['recall']==1){
                                                $recall_comment = 'Recalled last '.$date_recalled;
                                            }else{
                                                switch($getWithdrawalTransactionByTicket['status']){
                                                    case 1: $comm = 'Withdrawn last '.$getWithdrawalTransactionByTicket['date_withdraw']; break;
                                                    case 2: $comm = 'Withdrawal request declined last '.$date_recalled; break;
                                                }
                                                $recall_comment = $comm;
                                            }

                                            $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                        }else{
                                            $comment = 'N/A';
                                        }

                                        if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                            $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                        }else{
                                            $transactionType = 'N/A';
                                        }
                                       // $recalledStatus = $this->Withdraw_model->getRecalledStatus($object->Ticket);

                                     //   $rstat = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';

                                        $data['data']['withdraw_inv_friend']=true;
                                        $data['inv_friend'].='<tr>';
                                        $data['inv_friend'].='<td>'.$object->FundType.'</td>';       //type

                                        $data['inv_friend'].='<td>'.$object->AccountNumber.'</td>';  //account
                                        $data['inv_friend'].='<td>'.$object->Amount.'</td>';         //amount
                                        $data['inv_friend'].='<td>'.$transactionType.'</td>';                         //pay system
                                        $data['inv_friend'].='<td>'.$convertStamp.'</td>';          //date
                                        $data['inv_friend'].='<td>'.$withdrawalStatus.'</td>';          //status
                                        $data['inv_friend'].='<td>'.$comment.'</td>';

                                        $data['holder3'].='</tr>';





                                    }

                                }else{

                                   $data['data']['withdraw_inv_friend']=true;
                                    $data['inv_friend'].='<tr>';
                                    $data['inv_friend'].='<td>'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                    $data['inv_friend'].='<td>'.$object->AccountNumber.'</td>';  //account
                                    $data['inv_friend'].='<td>'.$object->Amount.'</td>';         //amount
                                    $data['inv_friend'].='<td>N/A</td>';                         //pay system
                                    $data['inv_friend'].='<td>'.$convertStamp.'</td>';          //date
                                    $data['inv_friend'].='<td>N/A</td>';          //status
                                    $data['inv_friend'].='<td>'.$comment.'</td>';          //status
                                    $data['inv_friend'].='</tr>';
                                }

                            }

                        }


                        if ($object->Operation=='REAL_FUND_WITHDRAW'){

                            $getWithdrawalTransactionByTicket = $ticketArray[$object->Ticket];
                            $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));

                            if($getWithdrawalTransactionByTicket){

                                if($getWithdrawalTransactionByTicket['status'] > 0){
                                    switch($getWithdrawalTransactionByTicket['status']){
                                        case 1:  $withdrawalStatus = 'Processed';  break;
                                        case 2:  $withdrawalStatus =  'Declined'; break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                                    }

                                    if(!empty($object->Comment)){
                                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                        if($getWithdrawalTransactionByTicket['recall']==1){
                                            $recall_comment = 'Recalled last '.$date_recalled;
                                        }else{
                                            switch($getWithdrawalTransactionByTicket['status']){
                                                case 1: $comm = 'Proccessed last '.$getWithdrawalTransactionByTicket['date_processed']; break;
                                                case 2: $comm = 'Withdrawal request declined last '.$date_recalled; break;
                                            }
                                            $recall_comment = $comm;
                                        }
//                                        if(IPLoc::Office()){
////                                            echo "<pre>"; print_r($getWithdrawalTransactionByTicket);
//                                            $recall_comment = $recall_comment.' com3='.$object->Comment; }
                                        $comment = '<a href="javascript:void(0);" class="view-comment" data-wcomment="'.$recall_comment.'">View</a>';
                                    }else{
                                        $comment = 'N/A';
                                    }

                                    if(!empty($getWithdrawalTransactionByTicket["transaction_type"])){
                                        $transactionType = $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])];
                                    }else{
                                        $transactionType = 'N/A';
                                    }
                                  //  $recalledStatus = $this->Withdraw_model->getRecalledStatus($object->Ticket);
//                                    print_r($recalledStatus);
                                    $rstat = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                                        $data['data']['withdraw']=true;

                                        $wte2Typ="'$object->FundType'";
                                        $wte2Acc="'$object->AccountNumber'";
                                        $wte2Amnt="'$object->Amount'";
                                        $wte2Trans="'$transactionType'";
                                        $wte2Dte="'$convertStamp'";
                                        $wte2Status="'$withdrawalStatus'";

                                        if(!empty($object->Comment)){
                                            $wte2Cmts="'$recall_comment'";
                                        }else{
                                            $wte2Cmts="'N/A'";
                                        }

                                        $wte2call="'$rstat'";
                                        $wte2Details='Details';



                                        $data['holder3'].='<tr onclick="mobViewDetailsWithdraw('.$wte2Typ.','.$wte2Acc.','.$wte2Amnt.','.$wte2Trans.','.$wte2Dte.','.$wte2Status.','.$wte2Cmts.','.$wte2call.')">';
                                        $data['holder3'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
                                        //                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction

                                        $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                        $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount
                                        $data['holder3'].='<td class="crTradesMob">'.$transactionType.'</td>';

                                        //pay system
                                        $data['holder3'].='<td class="crTradesMob">'.$convertStamp.'</td>';          //date
                                        $data['holder3'].='<td class="crTradesMob">'.$withdrawalStatus.'</td>';          //status
                                        $data['holder3'].='<td class="crTradesMob">'.$comment.'</td>';
                                        $data['holder3'].='<td class="crTradesMob">'.$rstat.'</td>';
//                                        if(IPLoc::Office()){
//                                            $data['holder3'].='<td><p class="tabRecall" rel="'.$object->Ticket.'">Recall</p></td>';                    //active
//                                        }
                                        $data['holder3'].='<td class="crTradesWeb crTradesWebStyle">'.$wte2Details.'</td>';
                                        $data['holder3'].='</tr>';
//                                    }




                                }

                            }else{


                                if((substr($object->Comment,0,7) == 'W/D_TR_')){
                                    $transID = substr($object->Comment, 14, 10);
                                }
                                if((substr($object->Comment,0,12) == 'DECLINED_TR_')) {
                                    $transID = substr($object->Comment, 19, 10);
                                }
                                $resultTransaction = $ticketArray[$transID];
                                $comm = $object->Comment;
                                if($resultTransaction && strlen($transID)>1){
                                    $paymentType = 'ITS';
                                    $paymentStat = 'Declined';
                                    $comment = '<a href="javascript:void(0);" txnid="'.$transID.'" class="view-comment" data-wcomment="'.$resultTransaction['decline_reason'].'">View</a>';
                                }else{
                                    $paymentType = 'N/A';
                                    $paymentStat = 'N/A';
                                    $comment = '<a href="javascript:void(0);" txnid="'.$transID.'" class="view-comment" data-wcomment="'.$comm.'">View</a>';

                                }



                                $data['data']['withdraw']=true;

                                $wte3Typ="'$object->FundType'";
                                $wte3Acc="'$object->AccountNumber'";
                                $wte3Amnt="'$object->Amount'";
                                $wte3Trans="'$paymentType'";
                                $wte3Dte="'$convertStamp'";
                                $wte3Status="'$paymentStat'";

                                if($resultTransaction && strlen($transID)>1){
                                    $wte3Cmts="'$resultTransaction[decline_reason]'";
                                }else{
                                    $wte3Cmts="'$object->Comment'";
                                }
                                $wte3call="' '";
                                $wte3Details='Details';



                                $data['holder3'].='<tr onclick="mobViewDetailsWithdraw('.$wte3Typ.','.$wte3Acc.','.$wte3Amnt.','.$wte3Trans.','.$wte3Dte.','.$wte3Status.','.$wte3Cmts.','.$wte3call.')">';
                                $data['holder3'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
//                            $data['holder3'].='<td>'.$object->Operation.'</td>';      //transaction
                                $data['holder3'].='<td>'.$object->AccountNumber.'</td>';  //account
                                $data['holder3'].='<td>'.$object->Amount.'</td>';         //amount

                                $data['holder3'].='<td class="crTradesMob">'.$paymentType.'</td>';                         //pay system
                                $data['holder3'].='<td class="crTradesMob">'.$convertStamp.'</td>';          //date
                                $data['holder3'].='<td class="crTradesMob">'.$paymentStat.'</td>';          //status
                                $data['holder3'].='<td class="crTradesMob">'.$comment.'</td>';
                                $data['holder3'].='<td class="crTradesMob"></td>';
                                $data['holder3'].='<td class="crTradesWeb crTradesWebStyle">'.$wte3Details.'</td>';
                                $data['holder3'].='</tr>';
                            }

                        }







                        if ($object->Operation=='REAL_FUND_TRANSFER'){
                            /*2*/

                            if (strpos($object->Comment, 'INTERNAL_TRANSFER_FROM_') !== false) {

                                $data['trans_to']  = $object->AccountNumber;
                                $data['trans_from'] = str_replace('INTERNAL_TRANSFER_FROM_','',$object->Comment);
                            }else if (strpos($object->Comment, 'OWN_MONEY_FROM_') !== false) {

                                $data['trans_to']  = $object->AccountNumber;
                                $data['trans_from'] = str_replace('OWN_MONEY_FROM_','',$object->Comment);
                            }else{

                                $data['trans_from']= $object->AccountNumber;
                                $data['trans_to']= $object->AccountReceiver;
                            }



                            $trnsfTyp="'$object->FundType'";
                            $trnsTransaction="'$object->Operation'";
                            $trnsfAccFrm="'$data[trans_from]'";
                            $trnsfAccTo="'$data[trans_to]'";
                            $trnsfAmount="'$object->Amount'";
                            $trnsfDate="'$object->Stamp'";
                            $transferDetails='Details';


                            $data['data']['transfer']=true;

                            $data['holder4'].='<tr onclick="mobViewDetailsTransfer('.$trnsfTyp.','.$trnsTransaction.','.$trnsfAccFrm.','.$trnsfAccTo.','.$trnsfAmount.','.$trnsfDate.')">';
                            $data['holder4'].='<td class="crTradesMob">'.$object->FundType.'</td>';       //type
                            $data['holder4'].='<td>'.$object->Operation.'</td>';      //transaction
                            $data['holder4'].='<td class="crTradesMob">'.$data['trans_from'].'</td>';  //account to
                            $data['holder4'].='<td class="crTradesMob">'.$data['trans_to'].'</td>';  //account from
                            $data['holder4'].='<td>'.$object->Amount.'</td>';         //amount
                            $data['holder4'].='<td class="crTradesMob">'.$object->Stamp.'</td>';          //date
                            $data['holder4'].='<td class="crTradesWeb crTradesWebStyle">'.$transferDetails.'</td>';

                            $data['holder4'].='</tr>';
                        }

                            if(IPLoc::Office()){

                                if (strpos($object->Operation, 'PAMM') !== false) {
                                    $data['data']['pamm']=true;
                                    $data['holder5'].='<tr>';
                                    $data['holder5'].='<td>'.$object->AccountNumber.'</td>'; 
                                    $data['holder5'].='<td>'.$object->FundType.'</td>';      
                                    $data['holder5'].='<td>'.$object->Ticket.'</td>';      
                                    $data['holder5'].='<td>'.$object->Amount.'</td>';        
                                    $data['holder5'].='<td>'.date("Y-m-d H:i:s", strtotime($object->Stamp)).'</td>';         
                                    $data['holder5'].='<td>'.$object->Comment.'</td>';       
                                    $data['holder5'].='</tr>';
                                }
                            }

                    }
//                    if(IPLoc::Office()){ //joy
//                        exit;
//                    }
                    break;
                default:
                    $data['holder0']='';

            }

            if($WebService->request_status === 'RET_OK'){



                $financeRecords = $WebService->get_result('FinanceRecords');
                foreach($financeRecords->FinanceRecordData as $object){
                    if($object->Operation === 'REAL_FUND_WITHDRAW'){
                        $resultTransaction = $ticketArray[$object->Ticket];
                        $convertStamp = date("Y-m-d H:i:s", strtotime($object->Stamp));
                            if ($resultTransaction) {
                                if ($resultTransaction['status'] == 0) {
                                    $data['withdrawFinance'] .= "<tr id=" . $object->Ticket . "}'>"
                                        . "<td class='FundType' align='center'>" . $object->FundType . "</td>"
                                        . "<td class='Operation' align='center'>" . $object->Operation . "</td>"
                                        . "<td class='AccountNumber'>" . $object->AccountNumber . "</td>"
                                        . "<td class='Amount'>" . $object->Amount . "</td>"
                                        . "<td class='PaySystem'>" . $this->transaction_type[strtoupper($resultTransaction['transaction_type'])] . "</td>"
                                        . "<td class='Stamp'>" . $convertStamp . "</td>"
                                        . "<td class='Recall'><a class='btn-withdraw-option recall-action hide-when-recalled' data-ticket=" . $object->Ticket . ">Recall</a></td>"
                                        . "</tr>";
                                }
                            }
//                        }
                    }
                }
            }

            $data['holderincomplete']='';
            $data['title_page'] = lang('sb_li_2');
            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'transaction-history';

            $data['metadata_description'] = lang('frahis_dsc');
            $data['metadata_keyword'] = lang('frahis_kew');
            $this->template->title(lang('frahis_tit'))
                ->set_layout('internal/main')
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                        <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."bootbox.min.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")

                ->build('transaction_history',$data);
            unset($data);
        }else{
            redirect('signout');
        }
    }

    public function testWSV(){

        $this->load->library("WSV");
        $this->load->library("Fx_mailer");

//        $accountNumber = $this->input->get('account_number');
        $account = $this->input->get('AccountNumber');
        $agent = $this->input->get('AgentAccountNumber');

        $params = array(
            "AccountNumber" => $account,
            "AgentAccountNumber" => $agent
        );


        $webFullResult  = $this->wsv->SetAccountDetail($params, "RemoveAgentAccount");


//        $emailData = array(
//            'email' => 'forexmart.tester5@gmail.com',
//            'subject' => 'SetAccountAgent',
//            'body' => 'Set Account Agent successful.'
//        );
//
//        Fx_mailer::testAPI($emailData);

//        $params = array(
//            "iLogin" => $account,
//            "strGroup" => $agent
//        );
//        $webFullResult = Bonus_Library::SetAccountGroup($account, $agent);

//        $leverage = FXPP::test_leverage_auto_change($params['iLogin'], $params['iLeverage']);

//        $session = $this->wsv->GetSession(false, false);

        echo "<pre>",print_r($webFullResult, 1),"</pre>";

    }

    public function sessionExpire(){

//        $sessionExpiration = $this->session->userdata("session_expiration");
//
//        $timestamp = time();
//
//        if(is_numeric($sessionExpiration)){
//            if($timestamp >= $sessionExpiration){
//                $message = "true";
//            }else{
//                $message = "false";
//            }
//        }else{
//            $message = "outside office ip";
//        }

//        echo "<script type='text/javascript'>
//                $(document).ready(function(){
//                    $('#sessionExpire').modal('show');
//                })
//            </script>";

//        $this->load->view("errors/html/error_session_expired");

        show_session_expired();


//        $this->session->set_userdata("session_expired", $message);
//        $this->session->set_userdata("timestamp", $timestamp);
//
//        echo $timestamp;
    }

    public function getAccountNumber(){

        $this->load->model('account_model');

        $result = $this->account_model->getAllAccountNumber(369115);


        echo $result[0]["account_number"];
    }

    public function dumpUserDataSession(){

        $result = $this->session->userdata();

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function dumpAccountDetails(){

        $webserviceConfig = array(
            'server' => 'live_new'
        );

        $accountNumber = $this->input->get('account_number');

        $result = FXPP::GetAllAccountDetails($accountNumber);

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function testOldAIP(){

        $this->load->library("WSV");

        $webservice_config = array(
            'server' => 'live_new'
        );

        $data['iLogin'] = $this->input->get('account_number');

        $WebFullResult = new WebService($webservice_config);
        $WebFullResult->open_RequestAccountDetails($data);

//        $test = array(
//            'request_status' => $WebFullResult->request_status,
//            'result' => $WebFullResult->result
//        );
//
//        $result = (object) $test;

        echo "<pre>",print_r($WebFullResult->result, 1),"</pre>";
    }

    public function chechPartner(){

        $this->load->model('cabinet_model');
        $service_data['iLogin'] = 58041774;
        $user_info = $this->cabinet_model->getPartnerInfoByAccount($service_data['iLogin']);
        getAccountNumberByEmail($email);
        echo "<pre>",print_r($user_info, 1),"</pre>";

    }

    public function ipcheck($ip){
        $this->load->library('FXIP');
        echo FXIP::getCountryCode($ip);
    }

    public function curlcheck(){
        $handle=curl_init('https://www.google.com');
        curl_setopt($handle, CURLOPT_VERBOSE, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($handle);

        echo $content; // show target page
    }

//    public function testFXMailer(){
//
//        $this->load->library('Fx_mailer');
//
////        $from = "noreply@mail.forexmart.com";
////        $returnPath = "noreply@mail.forexmart.com";
////        $test = Fx_mailer::fx_sender_partner("forexmart.tester5@gmail.com", "Test", "Investigate FXPP-12647", $from, $returnPath);
//
//        $data = array(
//            "account_number" => 58050126,
//            "time" => date('Y-m-d H:i:s'),
//            "payment_type" => "Sample",
//            "amount" => 10,
//            "reason" => "Test"
//        );
//
//        Fx_mailer::pending_deposit_with_issues($data);
//
////        echo "<pre>",print_r($test2, 1),"</pre>";
//    }


    public function timeTest(){
        $date =  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

        print_r($date);
    }

    public function checkPartnership(){
        $this->load->library('Fx_mailer');
        Fx_mailer::partners_agreement_v2(array());
    }

    public function testMe(){

        $data = array(
            "account_number" => 58050126,
            "time" => date('Y-m-d H:i:s'),
            "payment_type" => "Sample",
            "amount" => 10,
            "transaction_id" => 12345
        );

        $this->load->library('Fx_mailer');
        Fx_mailer::pending_deposit_with_issues($data, "forexmart.tester5@gmail.com");
        Fx_mailer::pending_deposit_with_issues($data, "agus@forexmart.com");
//        Fx_mailer::FMsender("forexmart.tester5@gmail.com", "Test", "fsdfdsdf");
    }

    public function dumpMe(){
        echo "Test!";
    }

    public static function DepositBonus10Percent($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId, $add10Percent = false){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');
        $CI->load->library('WSV');

        $depositBonusType = array(
            'twpb' => 0.2,
            'tenpb'=> 0.1
        );

        $depositBonusComment = array(
            'twpb' => 'FOREXMART WELCOME BONUS 20%',
            'tenpb' => 'SPECIAL 10% BONUS',
        );

        $depositBonusAPI = array(
            'twpb' => 'open_Deposit_20PercentBonus',
            'tenpb' => 'open_Deposit_10PercentBonus',
        );

        $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tenpb' => 'tenpercentbonus',
        );

        $depositResult = array(
            'Error' => true,
            'ErrorMsg' => 'System error.'
        );

        $tenPercentBonus = false;

        if(!is_null($bonus) && $bonus === "twpb" && $add10Percent){

            self::DepositBonus($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId);

            $tenPercentBonus = true;

        }else{

            if($add10Percent){
                $tenPercentBonus = true;
            }
        }

        if($tenPercentBonus){

            $amountDeposited = (float) $amountDeposited;
            $bonusPercent = (float) $depositBonusType['tenpb'];
            $amount = $amountDeposited * $bonusPercent;


            $webservice_config = array(
                'server' => 'live_new'
            );

            $WebService = new WebService($webservice_config);
//        $account_info = array(
//            'AccountNumber' => $account_number,
//            'Amount' => $amount,
//            'Comment' => $depositBonusComment[$bonus],
//            'ProcessByIP' => $CI->input->ip_address()
//        );


            $date_bonus_acquired = date('Y-m-d H:i:s');
            //  $hasDeposit = $CI->deposit_model->hasBonusDeposit_general($user_id);
            // if ($hasDeposit){

            $bonusArray_v1 = array(
                'AmountDeposited' => $amountDeposited,
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'UserId'    => $user_id,
                'AccountNumber' => $account_number,
                'TransactionPage' => $module,
                'Ticket'    => $WebService->get_result('Ticket'),
                'BonusType' => $bonus,
                'DepositId' => $depositId,
                'BonusStatus' => 2
            );

            $bonusArray_v2 = array( //for neteller logs
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'Ticket'    => $WebService->get_result('Ticket'),
                'DepositId' => $depositId,
                'BonusStatus' => 2

            );

            $depositResult['Error'] = false;
            $depositResult['ErrorMsg'] = '';
            return $depositResult;

        }

    }

    public function testDeposit(){

        $this->load->model('deposit_model');
        $depo_count = $this->deposit_model->getNumberOfDepositsByUser(385732);

        $this->db->select('*')
            ->from('deposit')
            ->where('user_id', 385732)
            ->where('status', 2)
            ->group_by('transaction_id');
        $result = $this->db->get();

        echo "<pre>",print_r($result->result_array(), 1),"</pre>";

    }

    public function displayAccountTYpe($id){
        $this->load->model('general_model');
        $accountType = $this->general_model->getAccountTypeGroup($id);
        echo $accountType;
    }

    public function testBonus(){
        FXPP::DepositBonus(386289, 58064566, 5, 'its', 'twpb', 1604984206);
    }

    public function checkConverter($from,$to,$amount){

        $res = FXPP::freeCurrencyConverter($from,$to,$amount);

        var_dump($res);

//       $currency_pair = 'BRL_USD';
//
//        $fileContent = file_get_contents("https://free.currconv.com/api/v7/convert?q=".$currency_pair."&compact=ultra&apiKey=16890856c5eb63c8c9ab");
//
//       // var_dump($fileContent);
//        $json = json_decode($fileContent,true);
//        var_dump($json['BRL_USD']);
    }

    public function testTFA(){

        $this->load->library('GoogleAuthenticator');
        $secret = $this->googleauthenticator->createSecret();
        echo "Secret is: ".$secret."</br>";

        $email =  $this->session->userdata('email');

        $qrCodeUrl = $this->googleauthenticator->getQRCodeGoogleUrl('ForexMart', $email, $secret);
        echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."</br>";

        $oneCode = $this->googleauthenticator->getCode($secret);
        echo "Checking Code '$oneCode' and Secret '$secret':\n";

        $checkResult = $this->googleauthenticator->verifyCode($secret, $oneCode);    // 2 = 2*30sec clock tolerance
        if ($checkResult) {
            echo 'OK';
        } else {
            echo 'FAILED';
        }

    }

    public function serverTimeZone(){

        $date = new DateTime();
        $timeZone = $date->getTimezone();
        echo $timeZone->getName();

    }

    public function testSMS(){

        $phone = $this->input->get('tel');
//        $sms_code = rand(1000,9999);
        //echo "sms code: $sms_code";

//        $sms = new CheckMobiRest();
//        $sms->setTo($phone);
//        $sms->setText("Your Security Code is ".$sms_code);
//        $return_data = $sms->SendSMSTestV2($phone);
//        $return_data = $sms->SendSMS();

        $process = curl_init("https://api.checkmobi.com/v1/sms/send");
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: C74C5A05-2D9B-4CB0-9FFA-BE007A8EA18D",
                "Content-Type: application/json")
        );

        $post_data = array(
            "to" =>$phone,
            "text" => '12345',
            "platform" => "web"
        );

        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($process);

        echo "<pre>",print_r(json_decode($response), 1),"</pre>";
    }


    public function getPartnerData(){
        $query = $this->g_m->getPartnerData();
        foreach ($query as $object => $val){
            $apiData = $this->getUserdetails2($val->reference_num);
            var_dump($object->reference_num);
//            var_dump($object . ' api: ' . $apiData);
        }
    }

    public function getUserdetails2($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
        $webService->request_account_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        }else{
            $data = false;
        }
        return $data;
    }

    public function checkURL(){

        $checkGet = $this->input->get();

        $additionalBonus = false;
        if(array_key_exists('additional_bonus', $checkGet)){
            $additionalBonus = $this->input->get('additional_bonus');
        }

        var_dump($additionalBonus);
    }

    public function checkPasswordAPI(){

        $param['currentMasterPass'] = $this->input->get('password');

        $this->load->library('WSV');
        $WSV = new WSV();
        $check = $WSV->CheckPassword($param);

        if($check === 'RET_OK'){

            $param['currentMasterPass'] = $this->input->get('password');
            $param['newPassword'] = $this->input->get('newPass');
            $changePassword = $WSV->ChangeUserMasterPasswordV2($param);

            echo "<pre>",print_r($changePassword, 1),"</pre>";

        }else{

            echo "<pre>",print_r($check, 1),"</pre>";
        }

    }

    public function checkInsert(){
        $addt = '';
        $insert_data = array(
            'full_name'=>'test',
            'amount'=>2,
            'item_id'=>123456789,
            'bonus'=>'twpb',
            'create_date'=>date('Y-m-d h:i:s'),
            'user_id'=>135835,
            'additional_tenp_bonus' => $addt
        );
        $this->general_model->insertmy('vnd', $insert_data);
    }

    public function checkUserFromDatabase(){

        $this->load->model('user_model');

        $user_id = $_SESSION['user_id'];

        $check = $this->user_model->getUserEmail($user_id);

        echo "<pre>",print_r($check, 1),"</pre>";

    }

    public function checkPasswordChangeCount(){

        $this->load->model('account_model');

        $current_date=date("Y-m-d");

        $user_id=$this->session->userdata('user_id');

        $user_data = $this->account_model->getRow("users", array('id'=>$user_id));

        $number_of_change_password = $user_data->number_of_change_password;
        $last_change_password_date = date_format(date_create($user_data->change_password_date),"Y-m-d");

        $last_change_date = new DateTime($user_data->change_password_date);
        $last_change = $last_change_date->format("Y-m-d");

//        $check = (FXPP::getAllowNumberOfChangePass(false,true)+1);

        var_dump($current_date);
        var_dump($last_change_password_date);
        var_dump($last_change);

    }

    public function checkCurrentPassword($current_pass){

        $this->load->library('WSV');
        $WSV = new WSV();

        $param['currentMasterPass'] = $current_pass;
        $check_current_pass = $WSV->CheckPassword($param);

        if($check_current_pass !== 'RET_OK') {
            $this->form_validation->set_message('checkCurrentPassword', 'Invalid current password.');
            return false;
        }else{
            return true;
        }

    }

    public function checkNewPassword($new_pass){

        $this->load->library('WSV');
        $WSV = new WSV();

        $param['currentMasterPass'] = $new_pass;
        $checkCurrentPass = $WSV->CheckPassword($param);

        if($checkCurrentPass == 'RET_OK') {
            $this->form_validation->set_message('checkNewPassword', 'Current password and New password must not be the same.');
            return false;
        }else{
            return true;
        }

    }

    public function confirmPassword($confirm_pass, $new_pass){

        if($confirm_pass !== $new_pass) {
            $this->form_validation->set_message('confirmPassword', 'New password and Confirm Password must match.');
            return false;
        }else{
            return true;
        }

    }
    
    
    public function testPayoma(){
        $r = FXPP::isPayomaUser();
        var_dump($r);
    }

    public function change_password_v2(){

        if ($this->session->userdata('logged')) {

            $this->load->library('Form_key');
            error_reporting(E_ALL);

            ini_set('display_errors', 1);
            $data = array();

            if(Form_key::isValid(trim($this->input->post('form_key',true)))) {

                $this->load->library('form_validation');
                $this->load->library('password_hash');

                $this->form_validation->set_rules('old_password',     'Current password', 'trim|required|xss_clean|callback_checkCurrentPassword');

                if($this->form_validation->run()){

                    $old_pass = $this->input->post('old_password');
                    $new_pass = $this->input->post('new_password');

                    $this->form_validation->set_rules('new_password',     'New password',     'trim|required|xss_clean|callback_checkNewPassword');
                    $this->form_validation->set_rules('confirm_password', 'Confirm password', "trim|required|xss_clean|callback_confirmPassword[$new_pass]");

                    if($this->form_validation->run()) {

                        $number_of_change_password = FXPP::getAllowNumberOfChangePassV2(false);

                        if(!$number_of_change_password) {

                            $this->load->model('general_model');
                            $this->load->model('user_model');
                            $email = $this->user_model->getUserEmail($_SESSION['user_id']); //FXMAIN-94

                            $this->load->library('WSV'); //New web service
                            $WSV = new WSV();

                            $param['currentMasterPass'] = $old_pass;
                            $param['newPassword'] = $new_pass;
                            $WebService = $WSV->ChangeUserMasterPasswordV2($param);

                            if($WebService == 'RET_OK'){

                                $this->load->library('password_hash');
                                $hash_password = $this->password_hash->change_password($old_pass, $new_pass);
                                $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);

                                $datax['update'] = array(
                                    'trader_password' => $new_pass
                                );
                                $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $datax['update']);

                                $data['success'] = true;
                                $data['msg'] = 'success';

                                $datum['changepassword'] = array(
                                    'account_number' => $_SESSION['account_number'],
                                    'Email' => $email,
                                    'new_password' => $new_pass,
                                    'type' => 0,
                                );
                                $this->load->library('fx_mailer');
                                $this->fx_mailer->change_password($datum['changepassword']);

                                $datum_3657 = array(
                                    'change_password_status' => 1,
                                    'change_password_date' => FXPP::getCurrentDateTime(),
                                    'change_password_attempts' => 0,
                                    'number_of_change_password' => 1
                                );
                                $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);

                            }else{
                                $data['success'] = false;
                                $data['tank_error'] = "System Failure. Please try again later. $WebService";
                            }

//                            $this->load->model('Adminslogs_model');
//                            $logsPrms = array(
//                                'Api_req' => $WebService,
//                                'Action' => 'CHANGE_PASSWORD',
//                                'Manager_IP' => $this->input->ip_address(),
//                            );
//
//                            $logsData = array(
//                                'users_id' => $_SESSION['user_id'],
//                                'page' => 'profile/change-password',
//                                'date_processed' => FXPP::getCurrentDateTime(),
//                                'processed_users_id' => $_SESSION['user_id'],
//                                'data' => json_encode($logsPrms),
//                                'processed_users_id_accountnumber' => $account_number,
//                                'comment' => 'Change password',
//                                'admin_fullname' => $_SESSION['full_name'],
//                                'admin_email' => $email,
//                            );
//                            $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);


                        }else{

                            $data['success'] = false;
                            $data['tank_error'] = 'You have exceeded the password change limit for today. Try again after 1 day.';

                        }

                    }
                }


            }

            $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));
            $data['form'] = Form_key::InputKey_array();
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'change-password';
            $data['metadata_description'] = lang('chapas_dsc');
            $data['metadata_keyword'] = lang('chapas_kew');

            $JS = $this->template->Js();
            $this->template->title(lang('chapas_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $JS . "pwstrength.js'></script>
                        <script src='" . $JS . "bootbox.min.js'></script>
                            ")
                ->build('change_password_v2', $data);
        }else{
            redirect('signout');
        }


    }

    public function generatePassword(){
        if ($this->input->is_ajax_request()) {

            $this->load->library('PasswordGenerator');
            $test = new PasswordGenerator(10, 1, 'lower_case,upper_case,numbers,special_symbols');
            $password = $test->generate();

            $this->output->set_content_type('application/json')->set_output(json_encode(array('password' => $password)));

        }else{
            show_404();
        }
    }


    public function test_payment(){
        $this->load->library('ZotaPay');
       
          $paymentRes =  $this->zotapay->paymentRequestV2(array());
        var_dump($paymentRes);


        }


//    public function developmentStatus(){
//
//        $this->load->library('WSV');
//
//        $WSV = new WSV();
//        $args = array(
//            'AccountNumber' => $_SESSION['account_number'],
//            'isCPA' => $this->isCPA,
//            'Limit' => $rowPerPage,
//            'Offset' => $_POST['start'],
//            'recType' => 'transaction-history',
//        );
//
//        $dateFr = $_POST['from'];
//        $dateT = $_POST['to'];
//        $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
//        $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
//        $args['From'] = $dateFrom;
//        $args['To'] = $dateTo;
//
//        $x = ( $WSV->GetFinanceOpHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistory($args)['Data']: array() ;
//        $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
//        if($tradeType=='pending-transactions'){  $args['Limit'] = $res['count']; }
//        $y = ( $WSV->GetFinanceOpHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistory($args)['Data']: array() ;
//        $res['record'] = isset($y->Transactions) ? $y->Transactions : '';
//        $hasError = ( $WSV->GetFinanceOpHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
//        $errorMsg = ( $WSV->GetFinanceOpHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
//
//    }

    public function getUserIdByAccountNumber($accountNumber){

        $this->db->select('user_id')
            ->from('mt_accounts_set')
            ->where('account_number', $accountNumber);
        $result = $this->db->get()->row()->user_id;

        return $result;
    }

    public function displayUserIdByAccountNumber(){

        $accountNumber = $this->input->get("account_number");

        $result = $this->getUserIdByAccountNumber($accountNumber);

        echo $result;
    }

    public function updateCountryByAccountNumber(){

        $accountNumber = $this->input->get("account_number");
        $countryCode = $this->input->get("country_code");

        $user_id = $this->getUserIdByAccountNumber($accountNumber);

        $update_data = array(
            'country' => $countryCode
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('user_profiles', $update_data);
        if ($this->db->affected_rows() > 0){
            echo "update success!";
        }else{
            echo "update failed!";
        }
    }

    public function updateStatusByAccountNumber(){

        $accountNumber = $this->input->get("account_number");
        $status = $this->input->get("status"); //1 and 3 = verified; 2 = declined

        $user_id = $this->getUserIdByAccountNumber($accountNumber);

        $update_data = array(
            'accountstatus' => $status,
            "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
            "accountstatus_update_location"=>'my_13',
            "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
        );

        $this->db->where('id', $user_id);
        $this->db->update('users', $update_data);
        if ($this->db->affected_rows() > 0){
            echo "update success!";
        }else{
            echo "update failed!";
        }
    }

    public function getTransactionRecords(){

        $this->load->library('WSV');
        $WSV = new WSV();

        $param = array();
        $result = $WSV->GetFinanceOpHistoryV2($param);

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function getTransactionRecordsV2(){

        $ticket = $this->input->get('ticket');

        $this->load->library('WSV');
        $WSV = new WSV();

        $param = array();
        $result = $WSV->GetFinanceOpHistoryV2($param);

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function printData(){


        $this->load->library('ZotaPay');
      
        $paymentRes =  $this->zotapay->orderStatusRequest();

        var_dump($paymentRes);

    }

    public function getFunds($acc){
      // $res = FXPP::getAccountFunds($acc);
       //$res = FXPP::isProAccount($acc);
      // $res = FXPP::getAccountCurrency($acc);

//        $requestData = array(
//            'totalAmount' => 25,
//            'amountRequested' => 20,
//            'totalFee' => 5,
//            'currency' => 'USD',
//            'account_number' => $account_number,
//            'addons' => $getTransactionFee['addons'],
//            'fee' => $getTransactionFee['fee'],
//            'user_id' => $userId
//        );
//
//
//
//        $res  = $this->validateAccountFundv2($requestData);

        $res = FXPP::getMTUserDetails2(array($_SESSION['account_number'],$acc));




        var_dump($res);
    }

    public function testNewDepositRealFund(){

        $test = FXPP::DepositRealFund($_SESSION['account_number'], 1, 'test new end point');

        FXPP::Dump($test);

    }

    public function testNewWithdrawRealFund(){

        $test = FXPP::WithdrawRealFund($_SESSION['account_number'], 1, 'test new end point withdraw', 1);

        FXPP::Dump($test);

    }

    public function testComment(){

        $tnxComment = "W/D_TR_123456_123456789";

        $type = '';
        if((strpos($tnxComment, 'W/D_TR') !== false)){ // standard type
            $type = 'W/D_TR';
        }

        echo $type;
    }

    public function testServerTime(){

        $serverTime = FXPP::getCurrentDateTime();
        echo $serverTime;

    }

    public function testUpdateTradingStatus(){

        $readOnly = $this->input->get('read_only');

        $this->load->library('WSV');
        $WSV = new WSV();

        $param = array(
            'AccountNumber' => 58050126,
            'isReadOnly' => $readOnly
        );
        $result = $WSV->SetAccountDetail($param, 'UpdateReadOnlyModeOfAccount');

        echo "<pre>",print_r($result, 1),"</pre>";

    }
    
    public function testCheckout(){
        $this->load->library('NovaPay');
        //$paymentRes =  $this->novapay->checkoutRequest();


        //echo '<br>';
        $json = 'a:10:{s:9:"accountId";s:8:"70030701";s:10:"merTradeId";s:10:"1620378897";s:6:"amount";s:4:"5.00";s:7:"orderId";s:22:"OD20210507170026007658";s:10:"event_code";s:4:"Sale";s:11:"tradeStatus";s:8:"Approved";s:8:"currency";s:3:"USD";s:7:"tf_sign";s:344:"426A43664A5651596D4B59343443645756743447334A44653574566B39314F7043316D616B756F67716A464E7578626F6438726E2F6D4C575039327967305067716F64724937314F434166386256474941554D6851584C7A6D5454426778465150767679706A64594449694A3668386D4D3134526D736941766971507638314D4A3142632B677A31524D527A58614A51377556785850775A646E4D696F34466A44576F41306A75714245733D";s:7:"tradeId";s:22:"TD20210507170026006870";s:10:"merOrderId";s:16:"usd60950511bf495";}';
        $data = unserialize($json);

        $paymentRes =  $this->novapay->verifySign($data);

        var_dump($paymentRes);


    }

    public function testLeverage(){

        $account_number = $this->input->get('account_number');
        $leverage = $this->input->get('leverage');

        $WebService = FXPP::SetLeverage_new($account_number, $leverage);

        if ($WebService->request_status === 'RET_OK') {
            $this->load->model('Account_model');
            $this->account_model->updateAccountLeverage($account_number, "1:$leverage");
        }

    }

    public function testGroup(){

        $account_number = $this->input->get('account_number');
        $leverage = $this->input->get('group');

//        $WebService = FXPP::SetAccountGroup($account_number, $leverage);

        $webservice_config = array('server' => 'live_new');
        $WebServiceChangeGroup = new WebService($webservice_config);
        $account_info2 = array(
            'iLogin' => $account_number,
            'strGroup' => 'D-'.$leverage
        );

        $WebServiceChangeGroup->open_ChangeAccountGroup($account_info2);

        var_dump($WebServiceChangeGroup);

    }

    public function testCreditFund(){

//        $amount = $this->input->get('amount');

        $totalAmount = 2 * .05;

        $result = FXPP::CreditBonus('BONUS_50_PERCENT', $totalAmount, "FOREXMART WELCOME BONUS 50%", 58050126);

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function checkMYRLog(){

        $reference = 'myr_6088d6226e487';

        $this->db->select('*');
        $this->db->from('myr_log');
        $this->db->like('log', $reference, 'both');
        $query = $this->db->get();

        $result = $query->row_array();
        $decode = unserialize($result['log']);

        echo "<pre>",print_r($result, 1),"</pre>";
        echo "<pre>",print_r($decode, 1),"</pre>";
    }

    public function testBonusMethod(){

        $account_number = $this->input->get('bonus');

        $test = array(
            'twpb' => 'testMethodTwenty',
            'tpb' => 'testMethodThirty',
            'fpb' => 'testMethodFifty'
        );

        FXPP::$test[$account_number]();
    }

    public function testGetFunds(){

        $result = FXPP::getAccountFunds(58050126);

        echo "<pre>",print_r($result, 1),"</pre>";

    }

    public function testExcel(){

        require_once $_SERVER['DOCUMENT_ROOT']."application/libraries/third_party/PHPExcel.php";
        require_once $_SERVER['DOCUMENT_ROOT']."application/libraries/third_party/PHPExcel/Writer/PDF.php";

//        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
// write data to first sheet
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'id')
            ->setCellValue('A2', 1)
            ->setCellValue('B1', 'name')
            ->setCellValue('B2', 'John');
// write data to defined excel sheet
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('Classes/studentInformation.xlsx');

    }

    public function testAutoDate(){

        $user_details_emailname = array(
            'registration_date' => '2015-12-01T10:18:49',
            'accountstatus' => 1
        );

        $account_verified_status=array("1","3");
        $allow_mt_account_info=false;

       $rDate = FXPP::getTimeDuration('2015-12-01T10:18:49');
        var_dump($rDate);

       if(FXPP::isAutoVeriFiedAllow(FXPP::getTimeDuration('2021-05-18T18:37:30')) and in_array($user_details_emailname['accountstatus'], $account_verified_status)){
           echo 'yes';
       }else{
           echo 'no';
       }

    }

}