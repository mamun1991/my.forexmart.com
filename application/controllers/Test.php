<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    protected $removeBonusesComment =  array(
        1 => 'FM BONUS 30% CANCELLATION',
        2 => 'FM 100% NDB CANCELLATION',
        7 => 'BONUS_CONTEST_PRIZE_CANCELLATION',
        10 => 'FM BONUS 50% CANCELLATION',
        12 => 'FM_CONTEST_MF_CANCELLATION'
    );


    function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('user_model');
        $this->load->model('General_model');
        

        $VPN_IP = array(
            '195.201.40.47'
        );

        if (!IPLoc::Office() && !in_array($this->input->ip_address(), $VPN_IP)) {
            redirect('');
        }
        $this->load->library('Transaction');
    }

    public function checkPartnership(){
        $this->load->library('Fx_mailer');
        Fx_mailer::partners_agreement_v2(array());
    }


    public function jtest(){
        
        
           $bonusType = FXPP::getAccountBonusByType('58072429');
        $totalContestBonus = $bonusType[7] + $bonusType[12];  // contest FM bonus | contest prize bonus
echo "<pre>";
print_r($bonusType);
        echo $totalContestBonus;
        echo "<br>";
        
         $fundsData = FXPP::getAccountFunds('58072429');
         print_r($fundsData);
        exit;
        
    }
    
    
     public function paysafeDepositProcess()
    {
            
            $paidAmount = 230;

            
                    $amount = $paidAmount;
                    $accData=array(
                      'currency'=>"EUR"  
                    );
                    
                     $invData=array(
                      'user_id'=>"395541"  
                    );

                    $currency = $accData['currency'];
                    /* FXPP-6333 */
                    $currencyStatus = $this->currency_status[$currency];
                    $isMicro = $this->account_model->isMicro($invData['user_id']);

                    
                    $fee = 0;
                    
            
                    
                    /*----------------------fee add------------FXPP-13766------------------------*/
                    
                    $user_profiles = $this->general_model->getUserProfiles($invData['user_id']);                    
                    $client_country_code=($user_profiles)?($user_profiles->country)?$user_profiles->country:false:false;
                    
                    $default_amt_usd=0.29;
                    $default_transecion_min_charge_usd=1; // or max 6.4% all currency
                    $default_transecion_percent=6.4;
                    $default_additional_min_charge_usd=1; // or max 1% all currency
                    $default_additional_percent=1;
                    // $rootbeer = (float) $InvoicedUnits;

                
                            $default_amt_client_curency=$this->get_convert_amount("USD", $default_amt_usd, $accData['currency']);
                            
                            $default_transecion_min_charge_client_curency=$this->get_convert_amount("USD", $default_transecion_min_charge_usd, $accData['currency']);
                            $default_additional_min_charge_client_curency=$default_transecion_min_charge_client_curency;                     
                            
                     
                    
                            $transec_min_charge=(($amount*$default_transecion_percent)/100);
                            $transec_min_charge_usd=$this->get_convert_amount($accData['currency'], $transec_min_charge,"USD");
                            if($transec_min_charge_usd<$default_transecion_min_charge_usd)
                            {
                               $transec_min_charge= $default_transecion_min_charge_client_curency;
                            }
                            
                            
                            
                            $additional_min_charge=0;
                            if(FXPP::depositFeeAllowCountry($client_country_code)){
                                
                                $additional_min_charge=(($amount*$default_additional_percent)/100);
                                $additional_min_charge_usd=$this->get_convert_amount($accData['currency'], $additional_min_charge,"USD");
                                if($additional_min_charge_usd<$default_additional_min_charge_usd)
                                {
                                   $additional_min_charge= $default_additional_min_charge_client_curency;
                                }
                            }
                            
                
                      $fee=($default_amt_client_curency+$transec_min_charge+$additional_min_charge);
                    
                    /*----------------------fee add code close------------------------------------*/
                   echo $fee."===================>".$default_amt_client_curency."+".$transec_min_charge."+".$additional_min_charge."----------->".$client_country_code;
            
    }
    
    
  /*-----------------------------current trade start code---------------------------------------------------------*/  
    public function getcurrentTrades(){
            
            ini_set("soap.wsdl_cache_enabled", "0");
//            $this->load->library('SVC');
            $this->load->library('WSV');
            $tradeType = "current-trades";
            $rowPerPage = 10;
            $hasError = false;
            $errorMsg = "";
            $post_page=0;
            $account_number=($_GET['id'])?$_GET['id']:$_SESSION['account_number'];
            
            $page = is_numeric($post_page) ? $post_page : 1;
            $WSV = new WSV();
            $args = array(
                'AccountNumber' => $account_number,
                'isCPA' => $this->isCPA,
                'Limit' => $rowPerPage,
                'Offset' => $page,
                'recType' => $tradeType,
            );
            
            

                $x = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $WSV->GetOpenTrades($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            echo "<pre>";
            print_r($res);
                
    }
    
            
    
    /*-----------------------------current trade close code---------------------------------------------------------*/
      public static function getBonusList(){

          echo "<pre>";
          
          
          $account_number=$_GET['id'];
          
        $account_info = array(
            'iLogin' => $account_number
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountBonusBreakdown($account_info);

        
        $bonus_data_array=false;
        
        if($WebService->request_status=="RET_OK")
        {
            
            $requestResult = json_encode($WebService->get_all_result()); 
            $BonusRecord = json_decode($requestResult, true);
           $bonus_data= $BonusRecord['BonusBreakdownList']['BonusData'];
           $bonus_data_array=$bonus_data;
            echo "<p>".$account_number."</p>";
           // print_r($bonus_data);
            
                foreach($bonus_data as $key=>$val)
                {
                    echo "Bonus Name:";
                    echo $val['BonusName'];
                  echo "<br>";
                }

            
            
        }else{
            echo "No bonus";
        }    
            
            
            
            
    }
    

    public function depositCheck(){

        $idrData = unserialize('a:21:{s:8:"contract";s:4:"2817";s:6:"apikey";s:4:"3303";s:11:"transaction";s:7:"6690408";s:6:"status";s:1:"1";s:14:"status_message";s:8:"Accepted";s:7:"item_id";s:17:"idr_5f7aef3581f01";s:16:"item_description";s:11:"IDR deposit";s:6:"amount";s:11:"73978650.00";s:10:"total_fees";s:9:"2071402.2";s:8:"currency";s:3:"IDR";s:4:"name";s:6:"Suwaji";s:4:"bank";s:2:"12";s:9:"bank_name";s:8:"Bank BCA";s:12:"bank_account";s:10:"3403929324";s:7:"account";s:5:"49442";s:16:"src_bank_account";s:10:"0800851521";s:14:"bank_reference";s:36:"4DED7754-A25E-79A1-8C54-ADBFC737C8D8";s:9:"signature";s:64:"ec33b9518e9647f58d7180ffac3a71c68fccd9ddf4f644c06c006a159ecca0dc";s:10:"signature2";s:64:"e47767aaf21a123fc0d7b0d1bee7e185eaf25ad04d767cb1b6b6d3d44a48ca6c";s:10:"created_at";s:37:"2020-10-05 17:45:54 Asia/Kuala_Lumpur";s:10:"updated_at";s:19:"2020-10-05 17:49:32";}');
        if ($row = $this->general_model->where("idr", array('item_id' => $idrData['item_id'], 'status' => 0))) {
            $invData = $row->row_array();
        }

        $this->idrDepositProcess($idrData);
    }

    
    public function testUploadMaxSize()
    {
        
        
        
       
     //   ini_set('post_max_size', '20M'); //FXPP-11877
      //  ini_set('upload_max_filesize', '20M'); //FXPP-11877
        
       //  $account_number = $this->session->userdata('account_number');
         if (empty($_FILES['font_side_copy']['name'])) {
         $this->form_validation->set_rules('front_side', 'front_side', 'trim|required'); 
         $this->form_validation->set_rules('back_side', 'back_side', 'trim|required'); 
         }
          if($this->form_validation->run()){
              echo "date================";exit;
          }else{
          
         // if($_POST['card_number']){
            
          echo validation_errors();
          print_r($_FILES);
          echo "------------------------->";
          
          }
          echo "tessssssssssssssssss";
         // }
          
            
            $data['metadata_description'] = 'Payoma.';

            $this->template->title('ForexMart | Deposit - Payoma')
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='".$this->template->Js()."custom-deposit.js'></script>")
                ->build('deposits/file_upload_test_page', $data);
         
         
    }


        private function idrDepositProcess( array $idrData)
    {



        if ($idrData['status'] == 1 ) {
            $paidAmount = ($idrData['amount']);

            $condition_idr = array(  // save only one unique transaction id in the deposit table (task FXPP-11129)
                'transaction_id'   => $idrData['item_id'],
                'transaction_type' => 'BANK_IDR'
            );

            $condition_idr_v2 = array(  // save only one unique transaction id in the idr table (task FXPP-11129)
                'item_id'   => $idrData['item_id'],
                'status'   => 1,
            );

            if ($this->general_model->whereCondition('deposit', $condition_idr)) {
               // return false;
               echo " already deposit";
            }

            if ($this->general_model->whereCondition('idr', $condition_idr_v2)) {
                //return false;
                echo " duplicate  deposit request";
            }



            if ($row = $this->general_model->where("idr", array('item_id' => $idrData['item_id'], 'status' => 0))) {
                $invData = $row->row_array();
                echo "verified checked <br>".floatval($invData['amount'])."<br>".floatval($idrData['amount']);
                if (floatval($invData['amount']) == floatval($idrData['amount'])) {

                    echo " done!"; exit();
                    $accData = $this->general_model->whereConditionQuery($invData['user_id']);
                    $total_amount = $this->get_convert_amount("IDR", $paidAmount, $accData['currency']);
                    $amount = $total_amount;

                    $currency = $accData['currency'];
                    /* FXPP-6333 */
                    $currencyStatus = $this->currency_status[$currency];
                    $isMicro = $this->account_model->isMicro($invData['user_id']);
                    if ($isMicro) {
                        $amount *= 100;
                        $total_amount *= 100;
                        $currencyStatus = $this->currency_status['Cents'];
                    }

                    $fee = $this->get_convert_amount("IDR",  $idrData['total_fees'], $accData['currency']);;


                    $conv_amount_fee_usd = $this->get_convert_amount($accData['currency'], $fee);

                    $amount -= $fee;

                    $conv_amount = $amount;
                    $conv_amount_fee = $fee;

                    $conv_amount_usd = $this->get_convert_amount($accData['currency'], $amount);

                    $insertDepositFailed = array(
                        'transaction_id	' => $invData['item_id'],
                        'status	'         => 0,
                        'amount	'         => $amount,
                        'currency'           => $currency,
                        'user_id'            => $invData['user_id'],
                        'payment_date'       => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        'transaction_type'   => 'BANK_IDR',
                        'payment_status'     => $this->paymentType_status['Deposit via bank idr'], //FXPP-7618
                        'currency_status'    => $currencyStatus, //FXPP-7618
                        'fee'                => $fee,
                        'isFailed'           => 0,
                        'type'               => 'deposit-' . $isMicro . '-' . $invData['bouns']
                    );


                    $data = array(
                        'transaction_id'   => $invData['item_id'],
                        'reference_id'     =>$idrData['item_id'],
                        'status'           => 2,
                        'amount'           => $amount,
                        'currency'         => $currency,
                        'user_id'          => $invData['user_id'],
                        'payment_date'     => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        'note'             => "BANK_IDR deposit",
                        'transaction_type' => 'BANK_IDR',
                        'conv_amount'      => $conv_amount_usd,
                        'payment_status'   => $this->paymentType_status['Deposit via bank idr'], //FXPP-7618
                        'currency_status'  => $currencyStatus //FXPP-7618
                    );


                    if ($fee > 0) {
                        $data_fee = array(
                            'transaction_id'   => $invData['item_id'],
                            'reference_id'     => $idrData['item_id'],
                            'status'           => 2,
                            'amount'           => $fee,
                            'currency'         => $currency,
                            'user_id'          => $invData['user_id'],
                            'payment_date'     => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                            'note'             => "BANK_IDR deposit",
                            'transaction_type' => 'BANK_IDR',
                            'conv_amount'      => $conv_amount_fee_usd,
                            'payment_status'   => $this->paymentType_status['Deposit via bank idr'], //FXPP-7618
                            'currency_status'  => $currencyStatus //FXPP-7618
                        );
                    }


                    $config = array(
                        'server' => 'live_new'
                    );
                    $WebService = new WebService($config);

                    $account_number = $accData['account_number'];

                    print_r($insertDepositFailed);

                    print_r($data);
                    

                }

            }

        } else{
            $updateData = array('status' => 2);
           // $this->general_model->updatemy('idr', 'item_id', $idrData['item_id'], $updateData);

           echo "NOt work"; 
        }
    }

    public function timeTest(){
        $date =  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        echo "<br>".date('Y-m-d h:i:s');

        print_r($date);
    }

    
    
    public function getAccountType(){
         $this->load->library('ForexCopy'); //ForexCopy web service
$accountNumber= $this->input->get('id');
        $serviceData = array('Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetAccountType($serviceData);
        $request_result = $ForexCopy->request_status;
        // 0 follower
        // 1 trader
        // 2 deactivated
        // 3 not registered
        echo "=================account Type ==========================================>"      ;

        echo "<pre>"; print_r($request_result);
        
        echo "</br>";echo "</br>";echo "</br>";echo "</br>";
   echo "=================copy trader type ==========================================>"      ;   
        $account_number =$accountNumber;
        $webservice_config = array('server' => 'forexcopy');
        $service_data = array('login' => $account_number);
        $WebService = new WebService($webservice_config);
        $WebService->Open_GetUserType($service_data);
        $request_result = $WebService->request_status;
        // 0 follower
        // 1 trader
        // 2 deactivated
        // 3 not registered

       echo "<pre>"; print_r($request_result);

            
        
        
        
        
    }
    
    
    public function netller()
    {


        $api_key = "cG1sZS00NDQ0NzA6Qi1xYTItMC01ZTY3MzQ2Ny0wLTMwMmMwMjE0NTdhNjEzM2U1MjA2ZWIyMTRjMmU0YTE4Zjc3ZDM0M2Q4OWYxMTRmNjAyMTQwMjA5MmZiZjM1Y2M3YjcyMzkxYjAwZTQ3MjIyM2YxYjQzNWNjZDJh";

        $array = array(
            'merchantRefNum'=> time(),
            
            'transactionType'=>'PAYMENT',
            'neteller'=>array(
                'consumerId'=>'netellertest_TWD@neteller.com',
                'detail1Description'=>'test',
                'detail1Text'=>'test'
            ),
            'paymentType'=>'NETELLER',
            'amount'=>100,
            'currencyCode'=>'USD',
            'customerIp'=>$_SERVER['REMOTE_ADDR'],
            
            'returnLinks'=>array(
                array('rel'=>'on_completed','href'=>'https://my.forexmart.com/deposit/paysafe_status'),
                array('rel'=>'on_failed','href'=>'https://my.forexmart.com/deposit/paysafe_status'),
                array('rel'=>'default','href'=>'https://my.forexmart.com/deposit/paysafe_status'),
            )  
        
        );
        
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://api.paysafe.com/paymenthub/v1/paymenthandles");
        curl_setopt($ch, CURLOPT_URL, "https://api.test.paysafe.com/paymenthub/v1/paymenthandles");
        //curl_setopt($ch, CURLOPT_URL, "https://private-anon-b7e16e9f09-netellerintegrationguide.apiary-mock.com/paymenthub/v1/paymenthandles");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($array));
        //curl_setopt($ch, CURLOPT_USERPWD,$user);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "Authorization: Basic ".$api_key,
          "Simulator: EXTERNAL"
         
        ));
        
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        
        header('Location: '.$response->links[0]->href);
    }

    public function index()
    {
        if ($_SERVER['REMOTE_ADDR'] === '210.213.232.26') {
            echo $this->sessison->userdata('user_id');
            exit;
            $userId = $this->session->userdata('user_id');
            $withdrawalType = 'NETELLER';
            $amount_withdraw = 50;

            $account = $this->account_model->getAccountsByUserIdRow($userId);
            $getTransactionFee = FXPP::getTransactionFee($withdrawalType, $account['mt_currency_base']);

            $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 4);
            $totalFees = $totalFee + $getTransactionFee['addons'];
            $amount_deducted = FXPP::roundno($amount_withdraw + $totalFees, 4);

            $requestData = array(
                'totalAmount'     => $amount_deducted,
                'amountRequested' => $amount_withdraw,
                'totalFee'        => $totalFees
            );

            $validateWithdraw = FXPP::validateWithdrawalProcess($requestData);
            FXPP::print_data($validateWithdraw);

        } else {
            show_404();
        }

    }

    public function test_query($user_id)
    {


        $user_mt_set = $this->user_model->getUserDetailsMT($user_id);
        echo "<pre>";
        print_r($user_mt_set['mt_account_set_id']);
        $user_details = $this->user_model->getUserDetails($user_id);

        echo "<pre>";
        var_dump($user_details['accountstatus']);
        if ($user_details['accountstatus'] == 0 && $user_mt_set['mt_account_set_id'] == 2) {
            echo 'Account is not yet verified.';

        } else {
            echo 'Account is verified.';

        }

    }

    public function test_q()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
//        $this->load->model('deposit_model');
//        $queue_data = [
//                'transaction_id' => '1234455666',
//                'reference_id' => '123213213',
//                'status' => 0,
//                'amount' => '20',
//                'currency' => 'USD',
//                'user_id' => '123545',
//                'payment_date' => '2017-02-07 19:57:53',
//                'note' => 'ForexMart PayPal deposit[USD]',
//                'transaction_type' => 'PAYPAL',
//                'conv_amount' => '1',
//                'thirtypercentbonus' => 1
//        ];
//        $this->deposit_model->insertPaymentQueue($queue_data);
    }

    public function testprocess()
    {

        if ($_SERVER['REMOTE_ADDR'] === '210.213.232.26') {
            $amountplusfee = $_GET['totalamount'];
            $bonus = $_GET['bonus'];
            $rf = $_GET['rf'];
            $ndb = $_GET['ndb'];
            $data = array(
                'totalAmount' => $amountplusfee,
                'bonus'       => $bonus,
                'rf'          => $rf,
                'ndb'         => $ndb
            );

            $validateAccountFund = $this->validateAccountFund($data);

            if ($validateAccountFund['removeNDB']) {

                $removeBonusParams = array(
                    'amount'         => $ndb,
                    'account_number' => 104353,
                    'user_id'        => 10211
                );
                $this->testremovebonus($removeBonusParams);
                $withdrawBonusPercent = 0.20 * $ndb;
                $amountplusfee = $amountplusfee + $withdrawBonusPercent;
            }

            $service_data = array(
                'Amount'        => $amountplusfee,
                'Comment'       => '',
                'Receiver'      => 0,
                'AccountNumber' => 104353,
                'ProcessByIP'   => $this->input->ip_address()
            );

            $webservice_config = array(
                'server' => 'live_new'
            );

            $WebService = new WebService($webservice_config);
            $WebService->WithdrawRealFund($service_data);

        }
    }

    public function testremovebonus($params)
    {
        if ($_SERVER['REMOTE_ADDR'] === '210.213.232.26') {

            $this->load->model('withdraw_model');
            $this->load->model('account_model');
            $amount = $params['amount'];
            $account_number = $params['account_number'];
            $userId = $params['user_id'];

            $service_data = array(
                'Amount'        => $amount,
                'Comment'       => '',
                'Receiver'      => 0,
                'AccountNumber' => $account_number,
                'ProcessByIP'   => $this->input->ip_address()
            );

            $webservice_config = array(
                'server' => 'live_new'
            );

            $WebService = new WebService($webservice_config);
            $WebService->WithdrawBonusFund($service_data);
            $result = $WebService->result;

            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $withdraw_data = array(
                'Account_number' => $account_number,
                'User_id'        => $userId,
                'Date'           => $date,
                'Ticket'         => $result['Ticket'],
                'Amount'         => $amount
            );

            $WithdrawBonusId = $this->withdraw_model->insertWithdrawBonus($withdraw_data);
            if ($WithdrawBonusId) {
                $amount = $amount - $amount;
                $this->account_model->updateAmountNDBByUserId($userId, $amount);
            }

        }
    }

    public function validateAccountFund($requestData)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        if ($_SERVER['REMOTE_ADDR'] === '210.213.232.26') {

            $this->load->model('account_model');
            $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
//            $webservice_config = array('server' => 'live_new');
//            $WebService2 = new WebService($webservice_config);
//            $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);
//            $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
//            $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');
//            $equity = $WebService2->get_result('Equity');
//            $margin = $WebService2->get_result('Margin');

            $getWithdrawableRealFund = $requestData['rf'];
            $getWithdrawableBonusFund = $requestData['bonus'];

            $equity = $getWithdrawableRealFund + $getWithdrawableBonusFund;
            $margin = 0;

            $totalAmount = (float) $requestData['totalAmount'];
            $feePlusAddons = 0;

            $returnData = array(
                'error'     => true,
                'errorMsg'  => 'You have insufficient funds. ',
                'removeNDB' => false
            );

            if ($equity < $totalAmount) {
                return $returnData;
            }

            if ($getWithdrawableRealFund <= 0) {
                $returnData['errorMsg'] = 'To withdraw bonuses, you have to send a request to bonuses@forexmart.com.';

                return $returnData;
            }

            //new
//            $userDetails = $this->account_model->getUserDetailsByUserId(9970);
//            $getTotalNoDepositBonus = $userDetails['ndb_bonus'];
            $getTotalNoDepositBonus = $requestData['ndb'];

            if ($getTotalNoDepositBonus > 0) {

                $withdrawBonusPercent = 0.20 * $getTotalNoDepositBonus;
                $withdrawableAmount = $equity - $margin - $getTotalNoDepositBonus - ($withdrawBonusPercent);
                $totalWithdrawableAmount = $withdrawableAmount - $feePlusAddons;

                if ($totalWithdrawableAmount < $totalAmount) {
                    $returnData['errorMsg'] = 'The maximum amount that be withdrawn after fees is ' . $totalWithdrawableAmount . ' USD/GBP/RUB/EUR. ';

                    return $returnData;
                }

                if ($totalAmount > $getTotalNoDepositBonus) {
                    $returnData['errorMsg'] = $totalAmount . ' - ' . $getTotalNoDepositBonus . ' Withdrawal request must be less than or equal to No Deposit Bonus received. ';

                    return $returnData;
                }

                $returnData['removeNDB'] = true;

            }

            $returnData['error'] = false;
            $returnData['errorMsg'] = 'success';
            $returnData['amountProcess'] = $totalAmount;

            return $returnData;
        } else {
            show_404();
        }

    }

    public function mt()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        echo 'test';
        parse_str(file_get_contents("php://input"), $_POST);
        $response = $_POST["response"];

        $insDataArray = array(
            'Response' => $response
        );
        $this->load->model('deposit_model');
        $this->deposit_model->testresponsemegatransfer($insDataArray);
    }

    public function testPassword()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->library('password_hash');
        $hasher = new PasswordHash(
            $this->config->item('phpass_hash_strength', 'tank_auth'),
            $this->config->item('phpass_hash_portable', 'tank_auth'));

        if ($hasher->CheckPassword('thisClone02', '$2a$08$j4/jQqYTdocTmWmc1wgmlumlJAPVtrej5GzL5H12H4y6tGbNVrMee')) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function getDir()
    {
        set_time_limit(1000);
        $dir = $this->config->item('asset_user_docs');//"./assets/user_docs/";
        $files1 = scandir($dir);
        $allowed = array("gif", "JPG", "JPEG", "jpg", "jpeg", "png", "bmp");
        $i = 1;
        //FXPP::setWaterMark("./assets/user_docs/02aa629c8b16cd17a44f3a0efec2feed4393764222.JPG");
        FXPP::setWaterMark($dir."02aa629c8b16cd17a44f3a0efec2feed4393764222.JPG");
        exit();
        echo count($files1);
        foreach ($files1 as $d) {

            $filename = $dir . $d;

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (in_array($ext, $allowed)) {
                if ($i > 510) {
                    echo '<a href="http://my.forexmart.com/assets/user_docs/' . $d . '">' . $d . "</a><br>";
                    //echo $filename;
                    //chmod($filename,"0777");
                    /* if(FXPP::setWaterMark($filename)){
                        echo '<a href="http://my.forexmart.com/assets/user_docs/'.$d.'">'.$d."</a><br>";
                    }*/


                }
                echo "  " . $i ++;


            }
        }

    }

    public function commission()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        if ($this->session->userdata('logged')) {

            $this->load->model('partners_model');
            $this->load->model('account_model');
            $this->load->model('General_model');
            $this->g_m = $this->General_model;

            $user_id = $this->session->userdata('user_id');

            if ($this->isCPA) {
                redirect(FXPP::my_url('partnership/cpa'));
            }

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($sub_partner) {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            } else {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'commission';

            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

            $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
            $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');

            $ac = $this->account_model->getAccountNumberByUserId($user_id);


            $data['data']['accountnumber'] = $ac['account_number'];
            $data['opt'] = $this->input->get('opt', true); // for Cumulative option select;

            $account_info2 = array(
//                'iLogin' =>$ac['account_number'],
                'iLogin' => 102032,
                'from'   => $from->format('Y-m-d\TH:i:s'),
                'to'     => $to->format('Y-m-d\TH:i:s')
            );

            $getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);

            $data['getCommissionData'] = $getCommissionData;


            //FXPP-2479
            $data['user_id'] = $this->session->userdata('user_id');
            $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');

            $data['partner_agreement'] = 0;
            if ($data['users']) {
                if ($data['users']['partner_agreement'] == 1) {
                    $data['partner_agreement'] = 1;
                }
            }
            //FXPP-2479

            $js = $this->template->Js();
            $data['metadata_description'] = lang('com_dsc');
            $data['metadata_keyword'] = lang('com_kew');
            $this->template->title(lang('com_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                        <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='" . $this->template->Js() . "Moment.js'></script>
                         <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                      <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                      <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('partnership/test_commission', $data);
        } else {
            redirect('signout');
        }

    }

    public function getCommission()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId($user_id);
        $account_number = $ac['account_number'];

        $date_from = $this->input->post('from', true);
        $date_to = $this->input->post('to', true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from . ' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to . ' 23:59:59');

        $account_info = array(
//            'iLogin' => $account_number,
            'iLogin' => 102032,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );

        $opt = $this->input->post('cumulative', true);

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);

        $html_commission = '';

        if ($WebService->request_status === 'RET_OK') {
            $CommisionList = $WebService->get_result('CommisionList');
            $CommissionData = json_encode($CommisionList->CommissionData);
            $CommisionListRecord = json_decode($CommissionData, true);

            $chartCommission = array();
            $val = 0;
            $totalCommission = 0;
            if (is_array($CommisionListRecord)) {

                foreach ($CommisionListRecord as $d) {
                    $datetime = strtotime($d['Date']) * 1000;
                    if ($opt == 'no') {
                        $val = $d['Amount'];
                    } else {
                        $val = $val + $d['Amount'];
                    }
                    $chartCommission[] = array($datetime, (float) $val);

                    $totalCommission = $totalCommission + $d['Amount'];

                }


                if (is_array($CommisionListRecord)) {
                    foreach ($CommisionListRecord as $d) {
                        $html_commission .= "<tr> <td>" . $d['Date'] . "</td><td>" . $d['Amount'] . "</td><td>" . $d['FromAccount'] . "</td><td>" . $d['Symbol'] . "</td></tr>";
                    }
                } else {
                    $html_commission .= '<tr> <td colspan="4" class="center">' . lang('com_05') . '.</td> </tr>';
                }

            } else {
                $chartCommission[] = array(strtotime(date('Y-m-d')) * 1000, 0);
                $html_commission .= '<tr> <td colspan="4" class="center">' . lang('com_05') . '.</td> </tr>';
            }
        } else {
            $chartCommission[] = array(strtotime(date('Y-m-d')) * 1000, 0);
            $html_commission .= '<tr> <td colspan="4" class="center">' . lang('com_05') . '.</td> </tr>';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission)));

    }

    public function getCommissionDataChart($account_info, $opt)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $totalCommission = 0;

        $defaultData = array(
            'startDate'  => '2015-05-05',
            'endDate'    => date('Y-m-d'),
            'chart'      => array(),
            'pagination' => ''
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);
        $html_commission = '';
        if ($WebService->request_status === 'RET_OK') {

            $CommisionList = $WebService->get_result('CommisionList');
            $countCommissionList = (array) $CommisionList;

            if (!empty($countCommissionList)) {
                $CommissionData = json_encode($CommisionList->CommissionData);
                $CommisionListRecord = json_decode($CommissionData, true);

                $startDate = reset($CommisionListRecord);
                $endDate = end($CommisionListRecord);

                $startDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $startDate['Date']);
                $endDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $endDate['Date']);

                $defaultData['startDate'] = $startDate->format('Y-m-d');
                $defaultData['endDate'] = $endDate->format('Y-m-d');
//                var_dump($defaultData);exit;
                $val = 0;


                if (is_array($CommisionListRecord)) {
                    foreach ($CommisionListRecord as $d) {
                        $datetime = strtotime($d['Date']) * 1000;

                        if ($opt == 'no') {
                            $val = $d['Amount'];
                        } else {
                            $val = $val + $d['Amount'];
                        }
                        $defaultData['chart'][] = "[$datetime, $val]";

                        $totalCommission = $totalCommission + $d['Amount'];

                    }
                    foreach ($CommisionListRecord as $d) {
                        $html_commission .= "<tr> <td>" . $d['Date'] . "</td><td>" . $d['Amount'] . "</td><td>" . $d['FromAccount'] . "</td><td>" . $d['Symbol'] . "</td></tr>";
                    }

                } else {
                    $defaultData['chart'][] = "[" . strtotime(date('Y-m-d')) * 1000 . ",0],";
                }
            } else {
                $defaultData['chart'][] = "[" . strtotime(date('Y-m-d')) * 1000 . ",0],";
            }
        } else {
            $defaultData['chart'][] = "[" . strtotime(date('Y-m-d')) * 1000 . ",0],";
        }

        $defaultData['totalCommission'] = $totalCommission;

        return $defaultData;

    }

    public function gettest()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        ini_set("soap.wsdl_cache_enabled", "0");
        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
        $account_info = array(
            'iLogin' => 104353,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

        FXPP::print_data($WebService->get_all_result());
        exit;

        $financeRecordEncode = json_encode($WebService->get_all_result());
        $financeRecord = json_decode($financeRecordEncode, true);


    }

    public function getAllCommissionPaginate()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId($user_id);
        $account_number = $ac['account_number'];

        ini_set("soap.wsdl_cache_enabled", "0");

        $date_from = $this->input->post('date_from', true);
        $date_to = $this->input->post('date_to', true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from . ' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to . ' 23:59:59');

        $start = $this->input->post('start', true);

        $limit = $this->input->post('length', true);

        $account_info2 = array(
//            'iLogin' => $account_number,
            'iLogin' => 102032,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s'),
            'offset' => $start,
            'limit'  => $limit
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);

        $getServiceData = $WebService->GetAgentsCommissionByDateWithLimitAndOffset($account_info2);
        $CommisionList = $getServiceData->GetAgentsCommissionByDateWithLimitAndOffSetResult->CommisionList;
        $CommissionData = json_encode($CommisionList->CommissionData);
        $CommisionListRecord = json_decode($CommissionData, true);

        $endDataRecord = end($CommisionListRecord);
        $this->session->set_flashdata("lastTicket", $endDataRecord['Ticket']);

        $data = array();

        $account_info = array(
//            'iLogin' => $account_number,
            'iLogin' => 102032,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );

        $WebService2 = new WebService($webservice_config);
        $WebService2->GetAgentsCommissionByDateCount($account_info);
        $DataCount = $WebService2->get_result('DataCount');

        if ($CommisionListRecord) {
            foreach ($CommisionListRecord as $key => $details) {

                $convertDate = date('Y-m-d H:i:s', strtotime($details['Date']));

                $tempArray = array(
                    'DT_RowId' => $key,
                    $convertDate,
                    $details['Amount'],
                    $details['FromAccount'],
                    $details['Symbol'],
                );
                $data[] = $tempArray;
            }
        }

        $result = array(
            'draw'            => (int) $_POST['draw'],
            'recordsTotal'    => (int) $DataCount,
            'recordsFiltered' => (int) $DataCount,
            'data'            => $data
        );

        echo json_encode($result);

    }

    // formula on how to calculate bonus amount to be cancelled
    // find X, where Y is equal to amount, z is the total 30% bonus received
    // x = (z / 0.30) - (y * 0.30)

    public function bonuses_statistic()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->lang->load('bonus');
        if ($this->session->userdata('logged')) {

            FXPP::LoginTypeRestriction();

//            $userId = $this->session->userdata('user_id');
//            $userId = 10349;

            if (IPLoc::Office()) {
                $userId = 6813;
            } else {
                $userId = $this->session->userdata('user_id');
            }

            $this->load->model('account_model');
            $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);

            $account_number = $accountsByUserIdRow['account_number'];

            $getAccountSummaryDetails = self::getAccountSummaryDetails($account_number);
            $data['accountSummaryDetails'] = $getAccountSummaryDetails;

            $getLotsTrade = self::getLotsTrade($account_number);
            $data['lotsTradeData'] = $getLotsTrade;

            $this->load->model('deposit_model');
            $getAllClaimed30percentBonus = $this->deposit_model->getAllClaimed30percentBonus($userId);
            $data['TotalDepositClaimedBonus'] = $getAllClaimed30percentBonus['sum'];

            $data['currency'] = $accountsByUserIdRow['mt_currency_base'];
//            var_dump($getAccountSummaryDetails['Total_Bonus']);exit;
            $necessaryNumberofLots = $getAccountSummaryDetails['Total_Bonus'] * 0.30;
            $data['necessaryNumberofLots'] = number_format($necessaryNumberofLots, 2);

            $lotstoTrade = $necessaryNumberofLots - $getLotsTrade;

            if ($lotstoTrade < 0) {
                $lotstoTrade = 0;
            }

            if ($lotstoTrade > 0) {
                $bonus_status = 'No bonuses available for withdrawal';
            } else {
                $bonus_status = 'Bonus available for withdrawal';
            }

            $data['lotstoTradeData'] = number_format($lotstoTrade, 2);
            $data['bonus_status'] = $bonus_status;

            $data['title_page'] = lang('sb_li_3');
            $data['active_tab'] = 'bonus';
            $data['active_sub_tab'] = 'bonuses_statistic';
            $js = $this->template->Js();
            $data['metadata_description'] = lang('bon_sta_dsc');
            $data['metadata_keyword'] = lang('bon_sta_kew');
            $this->template->title(lang('bon_sta_tit'))
                ->append_metadata_js("
                     <script src='" . $js . "bootbox.min.js'></script>
                    ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('bonus/bonuses_statistics2', $data);
        } else {
            redirect('signout');
        }
    }

    public function calculateBonusLeft()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        if (!$this->input->is_ajax_request() && !$this->session->userdata('logged')) {
            die('Not authorized!');
        }

//        bonusCancelled = ( parseFloat(realFund) * 0.30 ) - ( parseFloat(amount) * 0.30);
//        $userId = $this->session->userdata('user_id');
        $userId = 6813;
        $this->load->model('account_model');
        $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);

        $account_number = $accountsByUserIdRow['account_number'];

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService2 = new WebService($webservice_config);
        $WebService2->RequestAccountFunds($account_number);
        $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');

        $amount = $this->input->post('amount', true);

        $computeBonusLeft = ($getWithdrawableRealFund * 0.30) - ($amount * 0.30);

        $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
        $totalThirtyPercentBonus = $getAccountBonusByType[1];

        $BonusLeft = $computeBonusLeft > $totalThirtyPercentBonus ? $totalThirtyPercentBonus : $computeBonusLeft;

        echo json_encode($BonusLeft);

    }

    public function testgetAccountByUserId()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $user_id = $this->session->userdata('user_id');
        $this->load->model('account_model');
        $account_detail = $this->account_model->getAccountByUserId($user_id);
        var_dump($account_detail);
    }

    public function getTotalBonus($account_number)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $amount = 0;

        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
        $account_info = array(
            'iLogin' => $account_number,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

        $requestResult = $WebService->get_result('ReqResult');

        if ($requestResult === 'RET_OK') {
            $financeRecordEncode = json_encode($WebService->get_result('FinanceRecords'));
            $financeRecord = json_decode($financeRecordEncode, true);

            $operations = array_column($financeRecord['FinanceRecordData'], 'Operation');

            foreach ($operations as $key => $o) {


                if ($o === 'BONUS_30PERCENT') {

                    $getAmount = $financeRecord['FinanceRecordData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceRecordData'][$key]['Stamp'];
                    $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$datetime, $amount]";
                }


            }
        } else {
            $bonusData[] = "[" . strtotime(date('Y-m-d')) * 1000 . ",0],";
        }

        $defaultData = array(
            'amount'    => number_format($amount, 2),
            'bonusData' => $bonusData,
        );

        return $defaultData;

    }

    public function getLotsTrade($account_number)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $totalVolume = 0;
        $account_info = array(
            'iLogin' => $account_number
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountTotalTradedVolumeAfter30PercentBonus($account_info);
        $requestResult = $WebService->get_result('ReqResult');

        if ($requestResult != 'RET_OK') {
            return number_format($totalVolume, 2);
        }

        $totalVolume = $WebService->get_result('TotalVolume');

        return number_format($totalVolume, 2);
    }

    // public function getLotsTradetest($account_number)
    // {

    //     $totalVolume = 0;
    //     $account_info = array(
    //         'iLogin' => $account_number
    //     );
    //     $webservice_config = array('server' => 'live_new');
    //     $WebService = new WebService($webservice_config);
    //     $WebService->GetAccountTotalTradedVolumeAfter30PercentBonus($account_info);
    //     $requestResult = $WebService->get_result('ReqResult');

    //     if ($requestResult != 'RET_OK') {
    //         return number_format($totalVolume, 2);
    //     }

    //     $totalVolume = $WebService->get_result('TotalVolume');

    //     return number_format($totalVolume, 2);
    // }


    // public function getLotsTradeTest($account_number)
    // {
    //     if (!IPLOC::Office_and_Vpn()) {
    //         die();
    //     }
    //     $totalVolume = 0;
    //     $account_info = array(
    //         'iLogin' => $account_number
    //     );
    //     $webservice_config = array('server' => 'live_new');
    //     $WebService = new WebService($webservice_config);
    //     // $WebService->GetAccountTotalTradedVolumeAfter30PercentBonus($account_info);
    //     $WebService->GetAccountTotalTradedVolume_After_Bonus($account_info);
    //     $requestResult = $WebService->get_result('ReqResult');

    //     if ($requestResult != 'RET_OK') {
    //         return number_format($totalVolume, 2);
    //     }

    //     $totalVolume = $WebService->get_result('TotalVolume');

    //     return number_format($totalVolume, 2);
    // }


    public function getAccountSummaryDetails($account_number)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        if ($this->session->userdata('logged')) {

            FXPP::LoginTypeRestriction();

            $defaultData = array(
                'Balance'                => 0,
                'Equity'                 => 0,
                'FreeMargin'             => 0,
                'Withdrawable_RealFund'  => 0,
                'Withdrawable_BonusSafe' => 0,
                'Total_Bonus'            => 0
            );

            //get balance, equity and free margin
            $webservice_config = array(
                'server' => 'live_new'
            );
            $account_info = array(
                'iLogin' => $account_number
            );
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountBalance($account_info);
            $serviceResultBalance = $WebService->get_all_result();

            $balance = $serviceResultBalance['Balance'];

            if ($serviceResultBalance['ReqResult'] != 'RET_OK') {
                return $defaultData;
            }

            if ($balance < 0) {
                return $defaultData;
            }

            //withdrawable without bonus
            $WebService2 = new WebService($webservice_config);
            $WebService2->RequestAccountFunds($account_number);
            $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
            $defaultData['Withdrawable_RealFund'] = $getWithdrawableRealFund;

            //get withdrawable bonus with bonus safe - total balance - x - (x/.30)
            $totalBonusandChart = self::getTotalBonus($account_number);
            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $totalThirtyPercentBonus = $getAccountBonusByType[1];

            $totalBonus = $totalThirtyPercentBonus;
            $bonusChart = $totalBonusandChart['bonusData'];
            $newBalance = $getWithdrawableRealFund + $totalBonus;

            $wdBonusSafe = $newBalance - $totalBonus - ($totalBonus / .30);
            $defaultData['Total_Bonus'] = $totalBonus;

            $defaultData['Withdrawable_BonusSafe'] = number_format($wdBonusSafe, 2);

            $defaultData['Balance'] = $newBalance;
            $defaultData['Equity'] = $newBalance;
            $defaultData['FreeMargin'] = $newBalance;
            $defaultData['bonusChart'] = $bonusChart;

            return $defaultData;
        }
    }

    public function testallowedBonuses()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
//        $this->load->model('deposit_model');
//
//        $account_number = 180947 ;
//        $user_id = 97551;
//        $allowedBonuses = FXPP::allowedBonuses($account_number);
//        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber, 1);
//        $getAccountBonusByType2 = FXPP::getAccountBonusByType($accountNumber, 10);
//        $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($user_id);
//        var_dump($allowedBonuses);
//        var_dump($getAccountBonusByType);
//        var_dump($getAccountBonusByType2);
//        var_dump($first_bonus_acquired);
    }

    public function manual_deposit()
    {
        exit;
        $this->load->model('deposit_model');
        $config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($config);
        $account_number = 179802;
        $amount = 10;
        $comment = 'TEST DEPOSIT';
        $WebService->update_live_deposit_balance($account_number, $amount, $comment);
        $mt_ticket = $WebService->get_result('Ticket');
        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $depositArray = array(
            'transaction_id'      => '10000000011',
            'reference_id'        => '10000000011',
            'status'              => 2,
            'amount'              => $amount,
            'currency'            => 'USD',
            'user_id'             => 96260,
            'payment_date'        => $date,
            'note'                => $comment,
            'transaction_type'    => 'SKRILL',
            'thirtypercentbonus'  => 0,
            'date_bonus_acquired' => '0000-00-00 00:00:00',
            'mt_ticket'           => $mt_ticket,
            'pay_sys_ava'         => '',
            'amount_in_cents'     => null,
            'cpa'                 => 0,
            'comments'            => '',
            'date_cpa'            => '0000-00-00 00:00:00',
            'cpa_amount'          => null,
            'cpa_conv_amount'     => null,
            'conv_amount'         => $amount,
            'date_request'        => '0000-00-00 00:00:00',
            'validate_by'         => null
        );

        $this->deposit_model->insertPayment($depositArray);

    }

    public function getUserDetails()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        if (IPLoc::Office()) {


            $this->load->model('account_model');
            $user_status = $this->account_model->getAccountStatus(12598);
            FXPP::print_data($user_status);


        }
    }

    public function fixMissingAgentSet()
    {
        exit;
        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);

        $this->load->model('account_model');
        $getAccountsByDate = $this->account_model->getAccountsByDate();
//        FXPP::print_data($getAccountsByDate);exit;
        foreach ($getAccountsByDate as $a) {
            $account_info = array('iLogin' => $a['account_number']);
//            FXPP::print_data($account_info);
            $WebService->open_RequestAccountDetails($account_info);
            $comment = $WebService->get_result('Comment');
            $explode = explode(':', $comment);
            if (!empty($explode['2'])) {
                $lastAffiliateCode = end($explode);
                $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($lastAffiliateCode);
                $agentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];
                $getAccountNumberDetails = $this->account_model->getAccountNumberDetails($a['account_number']);
                $service_data = array(
                    'AccountNumber'      => $a['account_number'],
                    'AgentAccountNumber' => $agentAccountNumber
                );

                $WebService2 = new WebService($webservice_config);
                $WebService2->SetAccountAgent($service_data);
                if ($WebService2->request_status === 'RET_OK') {
                    $referral_data = array(
                        'referral_affiliate_code' => $lastAffiliateCode
                    );
                    $this->account_model->updateUserDetails('users_affiliate_code', 'users_id', $getAccountNumberDetails['user_id'], $referral_data);
                    echo 'ok - ' . $a['account_number'] . ' - ' . $lastAffiliateCode . ' - ' . $agentAccountNumber . '</br>';
                } else {
                    echo 'error - ' . $WebService2->request_status . ' - ' . $a['account_number'] . '</br>';
                }
            }
        }

    }

    public function affiliateFixUrl()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $strtok = strtok($_GET['id'], '?');
        var_dump($strtok);
    }

    public function getAffiliateLogs($input_affiliate_code)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $affiliate_code = 'fafwafwa';
        $getCookieLogs = '';

        if (empty($getCookieLogs) and !empty($affiliate_code)) {
            $getCookieLogs = $affiliate_code;
        }

        if (empty($getCookieLogs)) {
            $affiliate_code = $input_affiliate_code;
        } else {
            $affiliate_code = '-' . $input_affiliate_code;
        }

        if (!empty($input_affiliate_code)) {
            $getCookieLogs = $getCookieLogs . $affiliate_code;
        }

        return $getCookieLogs;

    }

    public function testAffiliateLogs()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $account_info = array(
            'iLogin' => 141738,
            // 'iLogin' =>'101491',
            'from'   => '2016-04-05',
            'to'     => '2016-06-13'
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_GetAccountTradesHistory($account_info);
        FXPP::print_data($WebService->get_all_result());
        exit;
    }

    public function LordStark()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        parse_str(file_get_contents("php://input"), $_POST);
        $response = $_POST["response"];

        $insDataArray = array(
            'Response' => $response
        );

        $this->load->model('deposit_model');
        $this->deposit_model->testresponsemegatransfer($insDataArray);
    }

    public function testing()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $pods = array(11 => true, 12 => false);

        $classes = array(1 => 0.7, 2 => 1.0, 3 => 1.5);

        $settings = array(
            'dirty_pod' => 0.9,
            'min_freq'  => 7,
            'std_freq'  => 14,
            'max_freq'  => 28,
        );

        $car = array(
            'id'         => 7,
            'pod_id'     => 11,
            'class_id'   => 3,
            'last_clean' => 5
        );

        $calculateNextClean = $this->calculateNextClean($car, $pods, $classes, $settings);
        echo $calculateNextClean;

    }

    public function calculateNextClean($car, $pods, $classes, $settings)
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $standardFrequency = $settings['std_freq'];
        $maximumFrequency = $settings['max_freq'];
        $minimumFrequency = $settings['min_freq'];
        $dirtyPodFactor = $settings['dirty_pod'];

        $checkPod = $pods[$car['pod_id']];

        $carClassId = $car['class_id'];
        $carLastClean = $car['last_clean'];

        if ($checkPod) {
            $standardFrequency = $standardFrequency * $dirtyPodFactor;
        }

        $getClassFactory = empty($classes[$carClassId]) ? 1.0 : $classes[$carClassId];
        $calculateCleanFrequency = $standardFrequency * $getClassFactory;

        $calculateCleanFrequency = round($calculateCleanFrequency > $maximumFrequency ? $minimumFrequency : $calculateCleanFrequency);
        $calculateNextClean = $calculateCleanFrequency - $carLastClean;
        $result = $calculateNextClean;

        return $result;

    }

    public function getTransactionHistoryofClient()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        ini_set("soap.wsdl_cache_enabled", "0");
        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
        $account_info = array(
            'iLogin' => 145843,
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

        FXPP::print_data($WebService->get_all_result());
        exit;
    }

    public function testGeneratePassword()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GeneratePasswordTest();
        $result = $WebService->result;
        var_dump($result);
        exit;
    }

    public function testPDFImage()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->library('PDFWriter');
        $FPDF = new PDFWriter();
        $date = new DateTime();
        $order_number = $date->getTimestamp();
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/user_docs/';
        $file_name = 'pdf_image' . $order_number . '.pdf';
        $FPDF->generateImagePDF($file_path, $file_name);
    }

    public function testCheckPassword()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->model('cabinet_model');
        $email = 'ezuri.claw@gmail.com';
        $password = 'Ezuri0402';
        $account = $this->cabinet_model->getAccountNumberByEmail($email);
        $webservice_config = array(
            'server' => 'live_new'
        );
        foreach ($account as $d) {
            $service_data = array(
                'iLogin'      => $d->account_number,
                'strPassword' => $password
            );
            $WebService = new WebService($webservice_config);
            $WebService->CheckUserPassword($service_data);
            echo $d->account_number . ' - ' . $WebService->request_status . '<br/>';
            if ($WebService->request_status === 'RET_OK') {
                break;
            }
        }
    }

    public function testtrading()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $account_info = array(
            'ClosePrice'  => 0,
            'Comment'     => 'sample trade',
            'Login'       => 140093,
            'OpenPrice'   => 1.13231,
            'OrderId'     => 0,
            'RequestType' => 'Sell',
            'StopLoss'    => 0,
            'Symbol'      => 'EURUSD',
            'TakeProfit'  => 0.01,
            'Volume'      => 0.01,
        );
        $WebService->open_RequestOpenTrade($account_info);
        var_dump($WebService);
        switch ($WebService->request_status) {
            case 'OK':
                echo "Request Succeeded";
                break;
            default:
                echo "Request Failed";
        }
    }

    public function testtrading2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $account_info = array(
            'ClosePrice'  => 0,
            'Comment'     => 'sample trade',
            'Login'       => 140093,
            'OpenPrice'   => 1.13231,
            'OrderId'     => 0,
            'RequestType' => 'Sell',
            'StopLoss'    => 0,
            'Symbol'      => 'EURUSD',
            'TakeProfit'  => 0.01,
            'Volume'      => 0.01,
        );
        $WebService->open_RequestOpenTrade_test($account_info);
        switch ($WebService->request_status) {
            case 'RET_OK':
                echo "Request Succeeded";
                break;
            default:
                echo "Request Failed";
        }
    }

    public function test_pendingorder()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        $config = array(
            'server' => 'trading'
        );

        $data['expiration'] = DateTime::createFromFormat('m-d-Y', '09-01-2016');
        $data['expiration']->setTime(59, 59, 59);

        $WebService = new WebService($config);
        $account_info = array(
            'Comment'     => "TEST",
            'Login'       => 140093,
            'OpenPrice'   => 1.11759,
            'Expiration'  => $data['expiration']->format('Y-m-d H:i:s'),
            'OrderId'     => $data['order_id'],
            'RequestType' => $this->input->post('RequestType', true),
            'StopLoss'    => $this->input->post('StopLoss', true),
            'Symbol'      => $this->input->post('Symbol', true),
            'TakeProfit'  => $this->input->post('TakeProfit', true),
            'Volume'      => $this->input->post('Volume', true),
        );
        $WebService->open_RequestOpenPendingOrder($account_info);
        var_dump($WebService);
        die();
    }

    public function testt()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

//        $this->load->model('partners_model');
//        $test = $this->partners_model->getReferral(5997);
//
//
//
//        foreach($test as $t){
//            $referral_account_number = $t->account_number;
//
//            $service_data = array(
//                'AccountNumber' => $referral_account_number,
//                'AgentAccountNumber' => 185259
//            );
//
//            $webservice_config = array(
//                'server' => 'live_new'
//            );
//            $WebService = new WebService($webservice_config);
//            $WebService->SetAccountAgent($service_data);
//            if ($WebService->request_status === 'RET_OK') {
//
//            }
//
//        }


    }

    public function checkEmailPassword()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $email = 'ezuri.claw@gmail.com';
        $password = 'm7MJvL9';
        $this->load->library('WebService');
        $webservice_config = array(
            'server' => 'live_new'
        );

        $service_data = array(
            'strEmail'    => $email,
            'strPassword' => $password
        );
        $WebService = new WebService($webservice_config);
        $WebService->CheckEmailPassword($service_data);
        var_dump($WebService->get_all_result());
    }

    public function checkDB()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->Model('Account_model');
        $val = $this->Account_model->get_partner_by_id('25471');
        print_r($val);
        exit;
    }

    public function test12345()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        echo $this->session->userdata('login_type') == 0 ? 'partner' : 'client';
    }

    public function test_graphs()
    {
        print_r($this->session->userdata());
    }

    public function dummy_partnershippage()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        die();
        $_SESSION['user_id'] = '168973';
        $this->load->model('partners_model');
        $this->load->library('IPLoc', null);
        $user_id = $this->session->userdata('user_id');
        $isPAS = $this->partners_model->getPartnershipAgreementStatus($user_id);
        $this->session->set_userdata('cpa', $isPAS);
        $this->isCPA = $this->partners_model->isCPA($user_id);
        $this->lang->load('partnership');
        $this->load->model('General_model');
        $this->load->model('account_model');
        $this->g_m = $this->General_model;


        $user_id = '168973';

        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
        } else {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
        }

        $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
        $data['isCPA'] = false;

        $data['active_tab'] = 'partnership';
        $data['active_sub_tab'] = 'commission';
        $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
        $webservice_config = array('server' => 'live_new');
        $from = DateTime::createFromFormat('Y/d/m', '2015/05/05');
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m H:i:s'));
        //            $ac = $this->general_model->showssingle2($table='mt_accounts_set','user_id',$id=$this->session->userdata('user_id'),'account_number');
        $ac = $this->account_model->getAccountNumberByUserId($user_id);
        $data['data']['accountnumber'] = $ac['account_number'];
        $data['opt'] = $this->input->get('opt', true); // for Cumulative option select;

        $account_info2 = array(
            'iLogin' => $ac['account_number'],
//                 'iLogin' =>'108326',
            'from'   => $from->format('Y-m-d\TH:i:s'),
            'to'     => $to->format('Y-m-d\TH:i:s')
        );
        // echo "<pre>";
        //  print_r($account_info2);
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info2);


        switch ($WebService->request_status) {
            case 'RET_OK':
                $CommisionList = $WebService->get_result('CommisionList');
                $data['commisionList'] = isset($CommisionList->CommissionData) ? $CommisionList->CommissionData : false;

                break;
            default:
                $data['error'] = true;
        }

        $js = $this->template->Js();
        $data['metadata_description'] = lang('com_dsc');
        $data['metadata_keyword'] = lang('com_kew');
        $this->template->title(lang('com_tit'))
            ->set_layout('internal/main')
            ->prepend_metadata('')
            ->build('partnership/commission', $data);
    }

    public function t1()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        die();
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        FXPP::CI()->load->model('Logs_model');

        $partnership_reg_log = FXPP::CI()->Logs_model->get_log($table = 'partnership_log', $field = "partner_id", $id = $partnerid = $_SESSION['user_id'] = 174505, $select = "registration_type,record1,record2,API1,record3");
        $Reg_APi1 = json_decode($partnership_reg_log['API1']);
        var_dump($Reg_APi1);
        echo ' //' . $Reg_APi1->phone_number . ' //';
        echo $Reg_APi1['phone_number'];
    }

    public function cpa_recreate()
    {

        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        die();
        $this->load->library('Partnership_Library');
        $_SESSION['user_id'] = 174505;
        echo $_SESSION['user_id'];
        Partnership_Library::recreate_cpa();

    }

    public function ndbemail()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        $email_data = array(
            'account_number'        => '140093',
            'email'                 => $email = 'trowabarton00005@gmail.com',
            'bonus'                 => 2071.71,
            'isUSDorEUR'            => false,
            'users_currency'        => 'CNY',
            'default_currency'      => 'USD',
            'bonus_negligible_view' => 300
        );

        FXPP::CI()->load->library('Fxpp_email');
        $logs['is_sent'] = Fxpp_email::ndb($email_data);
    }

    public function tag_ndb_test()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        $this->load->library('Bonus_Library');
        Bonus_Library::tag_test_account();

    }

    public function getscore()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring();
        echo 'bonus ' . $FXPP6539['bonus'];
        echo 'score ' . $FXPP6539['score'];
        echo 'currency ' . $FXPP6539['currency'];
        echo 'country ' . $FXPP6539['country'];
    }

    public function ndbreqtagging()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
//        die();
//        var_dump('test');
//        die();
        echo 'hello<br/>';

        $this->load->library('Bonus_Library');
        Bonus_Library::creditNBD_alreadyrequested();
        echo 'hello<br/>';

    }

    public function testupdate()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        die();
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        FXPP::CI()->g_m->updatemy($table = 'no_deposit', 'id', 33566, array('unique_email' => ''));
    }

    public function ndt_tagging()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        die();
        FXPP::CI()->load->model('Bonus_model');
        FXPP::CI()->b_m = FXPP::CI()->Bonus_model;
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        $nodeposit = FXPP::CI()->b_m->get_ndbqualified();
//            $nodeposit = FXPP::CI()->b_m->get_ndbqualified_v2();

//            var_dump($nodeposit);die();

//            $nodeposit = FXPP::CI()->b_m->get_ndbqualified_v2();
        foreach ($nodeposit as $key => $value) {
            $email = $value['email'];
            $table_id = $value['id'];
            /*create a check this account of has tag */
            echo 'account number: ' . $value['account_number'] . 'table id = ' . $table_id . '<br/>';
            $checkaccount = FXPP::CI()->b_m->checkaccounthasUEmailtag($table_id);
            if ($checkaccount) {

                $allemails = FXPP::CI()->b_m->get_ndb_accounts($email, $table_id);
                if ($allemails) {
                    foreach ($allemails as $key2 => $value2) {
                        FXPP::CI()->g_m->updatemy($table = 'no_deposit', 'id', $value2['id'], array('unique_email' => 2));
                    }
                }
                echo 'saving<br/>';
                FXPP::CI()->g_m->updatemy($table = 'no_deposit', 'id', $table_id, array('unique_email' => '1'));
            } else {
                echo 'not checked <br/>';
            }


        }

    }

    public function removeagent()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;

        $account_number = '249832';

        $getAccountAgent = FXPP::GetAccountAgent($account_number);

        if ($getAccountAgent) {
            $webservice_config = array('server' => 'live_new');
            $WebServiceRemove = new WebService($webservice_config);
            $WebServiceRemove->RemoveAgentOfAccount($account_number);
            if ($WebServiceRemove->request_status === 'RET_OK') {
                $removeData = array(
                    'AccountNumber'      => $account_number,
                    'AgentAccountNumber' => $getAccountAgent,
                    'DateRemoved'        => FXPP::getCurrentDateTime()
                );
                FXPP::CI()->g_m->insertmy($table = "removed_agents", $removeData);
            }
        }


    }

    public function removeagentv3()
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        /*tag ndb with morethan 2 ndb accounts*/
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;

        $m14users = FXPP::CI()->t_m->taggingDoubeNDB();
        //        $m14users= FXPP::CI()->t_m->taggingDoubeNDB_test();
        //        var_dump($m14users);
        foreach ($m14users as $key => $value) {
//            echo $account_number=$value['account_number']. '<br/>';

            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2017/03/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
            $account_info = array(
                'iLogin' => $account_number = $value['account_number'],
                'from'   => '2017-03-13T00:00:01',
                'to'     => '2017-03-17T10:00:01'
            );

            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
            switch ($WebService->request_status) {
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('FinanceRecords');
                    $count = 0;
                    $databonus = array();
                    foreach ($tradatalist['FinanceRecordData'] as $object) {
                        if ($object->FundType == 'BONUS' and $object->Comment == 'FOREXMART NO DEPOSIT BONUS') {
                            $count = $count + 1;
                        }

                    }
                    if ($count > 0) {
                        echo $account_number . 'no tagged. <br/>';
                        $getAccountAgent = FXPP::GetAccountAgent($account_number);
                        if ($getAccountAgent) {
                            echo $account_number . ' has agent. <br/>';
//                            $webservice_config = array('server' => 'live_new');
//                            $WebServiceRemove = new WebService($webservice_config);
//                            $WebServiceRemove->RemoveAgentOfAccount($account_number);
//                            if ($WebServiceRemove->request_status === 'RET_OK') {
//                                $removeData = array(
//                                    'AccountNumber' => $account_number,
//                                    'AgentAccountNumber' => $getAccountAgent,
//                                    'DateRemoved' => FXPP::getCurrentDateTime()
//                                );
//                                FXPP::CI()->g_m->insertmy($table = "removed_agents",$removeData);
//                                $removeagent = array('removedagent' => 1);
//                                FXPP::CI()->g_m->insertmy($table = "mt_accounts_set",$removeagent);
//                                echo $account_number. ' tagged. <br/>';
//                            }
                        } else {
                            echo $account_number . ' No agent. <br/>';
                        }
                    } else {

                    }
                    break;
                default:
            }
        }
    }

    public function getspecificscore()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        die();
        $userid = 180905;
        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring_v2($userid);
        echo 'bonus ' . $FXPP6539['bonus'];
        echo 'score ' . $FXPP6539['score'];
        echo 'currency ' . $FXPP6539['currency'];
        echo 'country ' . $FXPP6539['country'];
    }

    public function groupndb()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        /*tag ndb with morethan 2 ndb accounts*/
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->load->model('account_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;

        $m14users = FXPP::CI()->t_m->taggingDoubeNDB();

        foreach ($m14users as $key => $value) {
            $userid = $value['user_id'];
            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2017/03/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
            $account_info = array(
                'iLogin' => $account_number = $value['account_number'],
                'from'   => '2017-03-13T00:00:01',
                'to'     => '2017-03-18T10:00:01'
            );

            $webservice_config = array('server' => 'live_new');
            $WebServiceG = new WebService($webservice_config);
            $WebServiceG->open_RequestAccountFinanceRecordsByDate($account_info);
            switch ($WebServiceG->request_status) {
                case 'RET_OK':
                    $tradatalist = (array) $WebServiceG->get_result('FinanceRecords');
                    $count = 0;
                    foreach ($tradatalist['FinanceRecordData'] as $object) {
                        if ($object->FundType == 'BONUS' and $object->Comment == 'FOREXMART NO DEPOSIT BONUS') {
                            $count = $count + 1;
                        }

                    }
                    if ($count > 0) {

                        $webservice_config = array('server' => 'live_new');
                        $WebServiceR = new WebService($webservice_config);
                        $account_info = array('iLogin' => $account_number);
                        $WebServiceR->open_RequestAccountDetails($account_info);
                        if ($WebServiceR->request_status === 'RET_OK') {
                            $accountDetails = $WebServiceR->get_all_result();
                            $getgroup = $accountDetails['Group'];
//                            echo 'account_number:'.$account_number.' group:'.$getgroup.'<br/>';
                        }


                        FXPP::update_account_group_specific($userid);
                        $WebService2 = new WebService($webservice_config);
                        $account_details = FXPP::CI()->account_model->getAccountByUserId($userid);
                        $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($value['mt_account_set_id'], $value['mt_currency_base'], $value['swap_free']);
                        $account_info2 = array(
                            'iLogin'   => $account_number,
                            'strGroup' => $groupCurrency . 'ndb' . $account_details['group_code']
                        );
                        $WebService2->open_ChangeAccountGroup($account_info2);
                        if ($WebService2->request_status == 'RET_OK') {
                            echo 'account_number:' . $account_number . ' group:' . $getgroup . ' ok <br/>';
                            $prvt_data['groupup'] = array(
                                'grouptagupdate' => 1
                            );
                            FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $account_number, $prvt_data['groupup']);
                        } else {
                            echo 'account_number:' . $account_number . ' group:' . $getgroup . ' fail <br/>';
                            $prvt_data['groupup'] = array(
                                'grouptagupdate' => 2
                            );
                            FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $account_number, $prvt_data['groupup']);
                        }
                    } else {

                    }
                    break;
                default:
            }
        }

    }


    public function gettotalamount()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        $getAccountBonusByType = FXPP::getAccountBonusByType(250100);
        $getTotalNoDepositBonus = $getAccountBonusByType[2];
        echo $getTotalNoDepositBonus;
    }

    public function servicetime()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $webservice_config = array('server' => 'live_new');
        $WebServiceTime = new WebService($webservice_config);
        $WebServiceTime->open_GetServerTime();
        $serverTime = $WebServiceTime->get_all_result();
        echo $serverTime;
    }

    public function check()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $webservice_config = array('server' => 'live_new');
        $WebServiceAD = new WebService($webservice_config);
//        $account_info = array('iLogin' => $account_number=250151);
        $account_info = array('iLogin' => $account_number = 250100);
        $WebServiceAD->open_RequestAccountDetails($account_info);
        if ($WebServiceAD->request_status === 'RET_OK') {
            $datefrom = $WebServiceAD->get_result('RegDate');
            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();
            $data['from'] = DateTime::createFromFormat('Y-m-d\TH:i:s', $datefrom);
            $data['to'] = DateTime::createFromFormat('Y-m-d\TH:i:s', $serverTime);
            $account_info2 = array(
                'iLogin' => $account_number,
                'from'   => $data['from']->format('Y-m-d\TH:i:s'),
                'to'     => $data['to']->format('Y-m-d\TH:i:s')
            );
            var_dump($account_info2);

            $WebServiceGTPfR = new WebService($webservice_config);

            $WebServiceGTPfR->open_GetAccountTotalProfitFromRange($account_info2);
            var_dump($WebServiceGTPfR);
            if ($WebServiceGTPfR->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceGTPfR->get_result('TotalProfit');
                echo '/' . $BonusProfitFull . '/';
                echo 'bonus: ' . $BonusProfitFull;
            } else {
                echo 'bonus: ' . 'error';
            }
        }
    }

    public function testtaccount()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
//        die();
        $amountRequested = 100;
        $account_number = 227173;


        $webservice_config = array('server' => 'live_new');

        $WebServiceAD = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number);
        $WebServiceAD->open_RequestAccountDetails($account_info);
        if ($WebServiceAD->request_status === 'RET_OK') {

            $datefrom = $WebServiceAD->get_result('RegDate');

            $WebService2 = new WebService($webservice_config);
            $WebService2->RequestAccountFunds($account_number);
            $getwithdrawablefund = $WebService2->get_result('Withrawable_RealFund');

            /*Add*/
            $TotalRealFund = $WebService2->get_result('TotalRealFund');
            $equity = $WebService2->get_result('Equity');
            $margin = $WebService2->get_result('Margin');
            /*Add*/


            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();

            $account_info2 = array(
                'iLogin' => $account_number,
                'from'   => $datefrom,
                'to'     => $serverTime
            );

            $WebServiceGTPfR = new WebService($webservice_config);
            $WebServiceGTPfR->open_GetAccountTotalProfitFromRange($account_info2);
            if ($WebServiceGTPfR->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceGTPfR->get_result('TotalProfit');
            } else {
                $BonusProfitFull = 0;
            }

            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $getTotalNoDepositBonus = $getAccountBonusByType[2];


            if ($amountRequested > $getwithdrawablefund) {
                echo 'withdrawabel fund ' . $getwithdrawablefund . '<br/>';
                echo 'getTotalNoDepositBonus ' . $getTotalNoDepositBonus . '<br/>';
                echo 'getTotalNoDepositBonus ' . $TotalRealFund . '<br/>';

                if ($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0) {
                    echo ' a';
                    $_SESSION['preventndbtransfer'] = true;
                }


                echo 1;

//                die();
                $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                return false;
            }


            /*Add from validations*/
            if ($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0) {
                echo 2;
//                die();
                $_SESSION['preventndbtransfer'] = true;
                echo ' b';
                $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                return false;
            }


            $withdrawableAmount = $equity - $margin - $getTotalNoDepositBonus - $BonusProfitFull;
//           echo '$TotalRealFund'. $TotalRealFund.'/';
//           echo '$amountRequested'. $amountRequested.'/';
            if ($amountRequested > $TotalRealFund) {
                echo 3;
//                die();
                $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                return false;
            }

            if ($BonusProfitFull > 0) {

                if ($TotalRealFund < $BonusProfitFull) {
                    //                        $_SESSION['preventndbtransfer']=true;
                }

                if ($TotalRealFund <= 0) {
                    echo 4;
//                    die();
                    $_SESSION['preventndbtransfer'] = true;
                    echo ' c';
                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                    return false;
                }
            }

            if ($withdrawableAmount <= 0) {
                $_SESSION['preventndbtransfer'] = true;
                echo ' d';
                echo 5;
//                die();
                $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                return false;
            }

            /*Add from validations*/


            if ($getTotalNoDepositBonus > 0) {

                $withdrawBonusPercent = 0.20 * $getTotalNoDepositBonus;

                $withdrawableAmount = $getwithdrawablefund - $withdrawBonusPercent;

                if ($withdrawableAmount <= 0) {
                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                    return false;
                }
                if ($this->session->userdata('login_type') == 1) {
                    $getDetailsByAccountNumberSource['mt_currency_base'] = $prtnrshp['currency'];
                } else {
                    $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number);
                }

                if ($withdrawableAmount < $amountRequested) {
                    $errorMsg = 'The maximum amount that can be transfer is ' . $withdrawableAmount . ' ' . $getDetailsByAccountNumberSource['mt_currency_base'];
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);

                    return false;
                }

                if ($amountRequested > $getTotalNoDepositBonus) {
                    $errorMsg = 'Transfer request must be less than or equal to Bonus received. ';
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);

                    return false;
                }
            }
        } else {
            $this->form_validation->set_message('validateFundsAccounts', 'Something went wrong. Please try again later.');

            return false;
        }

        return true;

    }

    public function updateuserlev()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        FXPP::CI()->load->model('account_model');
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->load->model('deposit_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        FXPP::CI()->d_m = FXPP::CI()->deposit_model;
        $account_number = '105998';
        $account = FXPP::CI()->account_model->getAccountsByAccountNumber($account_number);

        $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);
        FXPP::update_account_group_specific($account['user_id']);
        $account_details = FXPP::CI()->account_model->getAccountByUserId($account['user_id']);
        $webservice_config = array('server' => 'live_new');
        $WebService2 = new WebService($webservice_config);
        $account_info2 = array(
            'iLogin'   => $account['account_number'],
            'strGroup' => $groupCurrency . 'ndb' . $account_details['group_code']
        );
        $WebService2->open_ChangeAccountGroup($account_info2);
        if ($WebService2->request_status == 'RET_OK') {
            $logs['WS2'] = 'OK';
            echo $logs['WS2'];
        } else {
            $logs['WS2'] = 'ChangeAccountGroup API error';
            echo $logs['WS2'];
        }

        FXPP::CI()->load->model('user_model');
        $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($account['user_id']);
        if (in_array(strtoupper($user['country']), array('PL'))) {
            $account_info3 = array(
                'iLogin'    => $account['account_number'],
                'iLeverage' => '100'
            );
        } else {
            $account_info3 = array(
                'iLogin'    => $account['account_number'],
                'iLeverage' => '200'
            );
        }
        $WebService3 = new WebService($webservice_config);
        $WebService3->open_ChangeAccountLeverage($account_info3);


    }

    public function taggingactiveaccounts()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        /* I need to tag active accounts , update group */
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        $m14users = FXPP::CI()->t_m->get_ndbmcredited();
        foreach ($m14users as $key => $value) {

        }
    }

    public function ver()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        echo 'Current PHP version: ' . phpversion();
    }


    public function updatendbmethods()
    {
        /*correct three method for ndb group leverage and insertion of credit prize*/
        /*pend first credit prize */
//        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();

        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;


        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;


        FXPP::CI()->load->model('deposit_model');
        FXPP::CI()->d_m = FXPP::CI()->deposit_model;

        FXPP::CI()->load->model('account_model');

        $get_ndbbackdate = FXPP::CI()->t_m->get_ndbbackdate();
        $webservice_config = array('server' => 'live_new');
        foreach ($get_ndbbackdate as $key => $value) {

            FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $value['account_number'], array('fixed_group' => 1));
            $account = FXPP::CI()->account_model->getAccountsByAccountNumber($account_number = $value['account_number']);
            FXPP::update_account_group_specific($account['user_id']);
            $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);
            $account_details = FXPP::CI()->account_model->getAccountByUserId($account['user_id']);

            /*leverage update*/
            $account_info2 = array(
                'iLogin'   => $account['account_number'],
                'strGroup' => $groupCurrency . 'ndb' . $account_details['group_code']
            );

            $WebService2 = new WebService($webservice_config);
            $WebService2->open_ChangeAccountGroup($account_info2);
            if ($WebService2->request_status == 'RET_OK') {
                $data = array(
                    'group' => $WebService2->get_result('Group')
                );
                $this->general_model->updatemy('mt_accounts_set', 'account_number', $account['account_number'], $data);
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $account['user_id'],
                    'process'        => 'API ChangeAccountGroup',
                    'api'            => 'ChangeAccountGroup',
                    'account_number' => $account_number,
                    'status'         => 1
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            } else {
                $tbl_log = array(
                    'user_id'        => $account['user_id'],
                    'process'        => 'API ChangeAccountGroup',
                    'api'            => 'ChangeAccountGroup',
                    'account_number' => $account_number,
                    'status'         => 2
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            }

            /*leverage update*/
            FXPP::CI()->load->model('user_model');
            $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($account['user_id']);
            if (in_array(strtoupper($user['country']), array('PL'))) {
                $account_info3 = array(
                    'iLogin'    => $account['account_number'],
                    'iLeverage' => '100'
                );
            } else {
                $account_info3 = array(
                    'iLogin'    => $account['account_number'],
                    'iLeverage' => '200'
                );
            }
            $WebService3 = new WebService($webservice_config);
            $WebService3->open_ChangeAccountLeverage($account_info3);
            if ($WebService3->request_status == 'RET_OK') {
                $prvt_data['lev'] = array(
                    'leverage' => '1:' . $account_info3['iLeverage']
                );
                FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $account['id'], $prvt_data['lev']);
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $account['user_id'],
                    'process'        => 'API ChangeAccountLeverage',
                    'api'            => 'ChangeAccountLeverage',
                    'account_number' => $account_number,
                    'status'         => 1
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            } else {
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $account['user_id'],
                    'process'        => 'API ChangeAccountLeverage',
                    'api'            => 'ChangeAccountLeverage',
                    'account_number' => $account_number,
                    'status'         => 2
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            }
            /*leverage update*/
            FXPP::CI()->d_m->setNoDepositRequestStatus($account['user_id'], 1);

        }
    }


    public function updatethegroup()
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->model('general_model');
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        $get_tempo_april4_ndb = FXPP::CI()->t_m->get_tempo_april4_ndb();
        foreach ($get_tempo_april4_ndb as $key => $value) {
            $webservice_config = array('server' => 'live_new');
            $WebServiceAD = new WebService($webservice_config);
            $account_info = array('iLogin' => $accountnumber = $value['account_number']);
            $WebServiceAD->open_RequestAccountDetails($account_info);
            if ($WebServiceAD->request_status === 'RET_OK') {
                $group = $WebServiceAD->get_result('Group');
                $data = array(
                    'group'            => $group,
                    'check_inactivity' => 1
                );
                $this->general_model->updatemy('mt_accounts_set', 'account_number', $accountnumber, $data);
                echo 'account number : ' . $accountnumber . ' active <br/>';
            } else {
                $data = array(
                    'check_inactivity' => 2
                );
                $this->general_model->updatemy('mt_accounts_set', 'account_number', $accountnumber, $data);
                echo 'account number : ' . $accountnumber . ' not active <br/>';
            }
        }
    }

    public function updateaccounts()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;

        $mtas = FXPP::CI()->g_m->showssingle2($table = 'mt_accounts_set', $field = 'account_number', $id = 255097, $select = 'user_id');
        echo $mtas['user_id'];
//        FXPP::requestdetailsNDB($mtas['user_id']);

    }

    public function updatecreditprize()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;

        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;

        $get_forcheckcreditprize = FXPP::CI()->t_m->get_forcheckcreditprize();
        foreach ($get_forcheckcreditprize as $key => $value) {
            $credit_prize = FXPP::CI()->g_m->showssingle3($table = 'credit_prize', $field = "account_number", $id = $value['account_number'], $field2 = "comment", $id2 = "FOREXMART NO DEPOSIT BONUS", $select = "amount", $order_by = "");
            if ($credit_prize) {
                $data = array(
                    'updated_creditprize' => 1
                );
                $this->general_model->updatemy('mt_accounts_set', 'account_number', $value['account_number'], $data);
            } else {
                $data = array(
                    'updated_creditprize' => 2
                );
                $this->general_model->updatemy('mt_accounts_set', 'account_number', $value['account_number'], $data);
            }

        }

    }

    public function tag_ndb_ticketsandcounts()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;

        $get_forcheckcreditprize = FXPP::CI()->t_m->get_forcheckcreditprize2();
        foreach ($get_forcheckcreditprize as $key => $value) {
            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/03/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
            $account_info = array(
                'iLogin' => $accountnumber = $value['account_number'],
                'from'   => '2015-03-01T00:00:01',
                'to'     => '2017-04-05T00:00:01'
            );
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
            switch ($WebService->request_status) {
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('FinanceRecords');
                    $count = 0;
                    $ticket = '';
                    $databonus = array();
                    foreach ($tradatalist['FinanceRecordData'] as $object) {
                        if ($object->FundType == 'BONUS' and $object->Comment == 'FOREXMART NO DEPOSIT BONUS') {
                            $count = $count + 1;
                            $ticket = $object->Ticket . ',' . $ticket;

                        }
                    }

                    if ($count > 0) {
                        $data = array(
                            'no_ndb_api'      => $count,
                            'all_ndb_tickets' => $ticket,
                            'ndb_counter_tag' => 1
                        );
                        $this->general_model->updatemy('mt_accounts_set', 'account_number', $accountnumber, $data);
                    } else {
                        $data = array(
                            'no_ndb_api'      => $count,
                            'all_ndb_tickets' => $ticket,
                            'ndb_counter_tag' => 2
                        );
                        $this->general_model->updatemy('mt_accounts_set', 'account_number', $accountnumber, $data);
                    }

                    break;
                default:

            };
        }

    }

    public function updatecreditprize_table()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
    }

    public function updatendbbonusccy()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;

        $get_forcheckcreditprize = FXPP::CI()->t_m->get_forcheckcreditprize();
        foreach ($get_forcheckcreditprize as $key => $value) {
            $data['from'] = DateTime::createFromFormat('Y/d/m', date('2015/03/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
            $account_info = array(
                'iLogin' => $accountnumber = $value['account_number'],
                'from'   => '2015-03-01T00:00:01',
                'to'     => '2017-04-05T00:00:01'
            );
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
            switch ($WebService->request_status) {
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('FinanceRecords');
                    $count = 0;
                    $ticket = '';
                    $databonus = array();

                    foreach ($tradatalist['FinanceRecordData'] as $object) {
                        if ($object->FundType == 'BONUS' and $object->Comment == 'FOREXMART NO DEPOSIT BONUS') {
                            $data = array(
                                'ndb_bonus_ccy' => $object->Amount
                            );
                            $this->general_model->updatemy('users', 'id', $value['user_id'], $data);
                        }
                    }
                    break;
                default:

            };
        }

    }

    public function updatenadbtickets()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;

        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;


        $get_forcheckcreditprize = FXPP::CI()->t_m->get_forcheckcreditprize();
        foreach ($get_forcheckcreditprize as $key => $value) {

            $ticketsource = str_replace(',', '', $value['all_ndb_tickets']);
            echo $ticketsource . '<br/>';
            $data = array(
                'ndb_ticket' => $ticketsource,
            );

            $this->general_model->updatemy('users', 'id', $value['user_id'], $data);
            $dataS = array(
                'updated_creditprize' => 3
            );
            $this->general_model->updatemy('mt_accounts_set', 'user_id', $value['user_id'], $dataS);

            $comment = 'FOREXMART NO DEPOSIT BONUS';
            FXPP::CI()->load->model('Managecontest_model');
            $prize_data = array(
                'user_id'        => $value['user_id'],
                'account_number' => $value['account_number'],
                'manager_id'     => $value['user_id'],
                'amount'         => $value['ndb_bonus_ccy'],
                'comment'        => $comment,
                'ticket'         => $ticketsource,
                'date_processed' => FXPP::getCurrentDateTime()
            );
            $i_cp = FXPP::CI()->Managecontest_model->insertCreditPrize($prize_data);
            $logs['i_cp'] = $i_cp;

            if ($i_cp != false) {
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $value['user_id'],
                    'process'        => 'Credit Prize',
                    'api'            => 'N/A',
                    'account_number' => $value['account_number'],
                    'status'         => 1
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            } else {
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $value['user_id'],
                    'process'        => 'Credit Prize',
                    'api'            => 'N/A',
                    'account_number' => $value['account_number'],
                    'status'         => 2
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            }
        }
    }

    public function updatendbleverage()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        $tempo_leverage = FXPP::CI()->t_m->tempo_leverage();

        $webservice_config = array('server' => 'live_new');
        foreach ($tempo_leverage as $key => $value) {
            $WebServiceAD = new WebService($webservice_config);
            $account_info = array('iLogin' => $value['account_number']);
            $WebServiceAD->open_RequestAccountDetails($account_info);
            if ($WebServiceAD->request_status === 'RET_OK') {
                $prvt_data['lev'] = array(
                    'leverage'            => '1:' . $WebServiceAD->get_result('Leverage'),
                    'leverage_update_ndb' => 1
                );
                FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $value['account_number'], $prvt_data['lev']);
            } else {
                $prvt_data['lev'] = array(
                    'leverage_update_ndb' => 2
                );
                FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $value['account_number'], $prvt_data['lev']);
            }
        }
    }

    public function updatendbleverage_api()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->load->model('Logs_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;
        FXPP::CI()->l_m = FXPP::CI()->Logs_model;
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m = FXPP::CI()->General_model;
        $tempo_leverage = FXPP::CI()->t_m->tempo_leverage();

        $webservice_config = array('server' => 'live_new');
        foreach ($tempo_leverage as $key => $value) {
            FXPP::CI()->load->model('user_model');
            $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($value['user_id']);
            if (in_array(strtoupper($user['country']), array('PL'))) {
                $account_info3 = array(
                    'iLogin'    => $value['account_number'],
                    'iLeverage' => '100'
                );
            } else {
                $account_info3 = array(
                    'iLogin'    => $value['account_number'],
                    'iLeverage' => '200'
                );
            }

            /*3rd Webservice Call*/
            $WebServiceLL = new WebService($webservice_config);
            $WebServiceLL->open_ChangeAccountLeverage($account_info3);
            if ($WebServiceLL->request_status == 'RET_OK') {
                $prvt_data['lev'] = array(
                    'leverage_update_ndb' => 3,
                    'leverage'            => '1:' . $account_info3['iLeverage']
                );
                FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $value['account_number'], $prvt_data['lev']);
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $value['user_id'],
                    'process'        => 'API ChangeAccountLeverage',
                    'api'            => 'ChangeAccountLeverage',
                    'account_number' => $value['account_number'],
                    'status'         => 1
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            } else {
                $logs['WS3'] = 'ChangeAccountLeverage API error';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'        => $value['user_id'],
                    'process'        => 'API ChangeAccountLeverage',
                    'api'            => 'ChangeAccountLeverage',
                    'account_number' => $value['account_number'],
                    'status'         => 2
                );
                FXPP::CI()->g_m->insertmy($table = 'no_deposit_logs', $data = $tbl_log);
                /*Table Logs*/
            }
        }


    }

    public function test_virusscanner()
    {
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }

        $file_name_with_full_path = 'https://my.forexmart.com/assets/user_docs/592f89b73e85c1f676c06f1d39ad3e52543265d2c011363c.PNG';
        $api_key = getenv('VT_API_KEY') ? getenv('VT_API_KEY') : '85e8a4cd991848d039cfc599858c57dcec3e24af0aa9d8096d2ac14ff05b076a';
        $cfile = "@" . $file_name_with_full_path
            . ";type=" . mime_content_type($file_name_with_full_path)
            . ";filename=" . basename($file_name_with_full_path);
        var_dump($cfile);
//        $obj = (object) 'ciao';
//        var_dump( $obj->scalar);
//        //        $bar = new foo;
////        $bar->do_foo();
////
////        var_dump($bar);
//        $cfile = $this->curl_file_create($file_name_with_full_path);
//        $cfile = $file_name_with_full_path;
//        $cfile = $file_name_with_full_path;
//        echo 'Api_key' .$api_key;
//            var_dump($cfile);
//        $cfile = '@'.$file_name_with_full_path;
        $post = array('apikey' => $api_key, 'file' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.virustotal.com/vtapi/v2/file/scan');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1); // remove this if your not debugging
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // please compress data
        curl_setopt($ch, CURLOPT_USERAGENT, "gzip, My php curl client");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        print("status = $status_code\n");
        echo 'test';
        if ($status_code == 200) { // OK
            echo 'test1';
            echo 'ok';
            $js = json_decode($result, true);
            print_r($js);
        } else {  // Error occured
            echo 'test2';
            echo 'Error occured';
            print($result);
        }
        curl_close($ch);

    }

    public function newobject()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $virustotal_api_key = '85e8a4cd991848d039cfc599858c57dcec3e24af0aa9d8096d2ac14ff05b076a';
        $file_hash = 'https://my.forexmart.com/assets/user_docs/592f89b73e85c1f676c06f1d39ad3e52543265d2c011363c.PNG';
        $report_url = '';
        var_dump($report_url);
    }
//    function curl_file_create($filename, $mimetype = '', $postname = '') {
//        return "@$filename;filename="
//            . ($postname ?: basename($filename))
//            . ($mimetype ? ";type=$mimetype" : '');
//    }


    public function testerapi()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        header("Content-Type: text/plain");

        // edit the virustotal.com api key, get one from the site
        $virustotal_api_key = "85e8a4cd991848d039cfc599858c57dcec3e24af0aa9d8096d2ac14ff05b076a";

        // enter here the path of the file to be scanned
//        $file_to_scan = "https://my.forexmart.com/assets/user_docs/592f89b73e85c1f676c06f1d39ad3e52543265d2c011363c.PNG";
        
        $asset_user_docs=$this->config->item('asset_user_docs');
        $file_to_scan = $asset_user_docs."592f89b73e85c1f676c06f1d39ad3e52543265d2c011363c.PNG";

        // get the file size in mb, we will use it to know at what url to send for scanning (it's a different URL for over 30MB)
        $file_size_mb = filesize($file_to_scan) / 1024 / 1024;
        echo 'size=/' . $file_size_mb . '/<br/>';
        // calculate a hash of this file, we will use it as an unique ID when quering about this file
        $file_hash = hash('sha256', file_get_contents($file_to_scan));

        // [PART 1] hecking if a report for this file already exists (check by providing the file hash (md5/sha1/sha256)
        // or by providing a scan_id that you receive when posting a new file for scanning
        // !!! NOTE that scan_id is the only one that indicates file is queued/pending, the others will only report once scan is completed !!!
        $report_url = 'https://www.virustotal.com/vtapi/v2/file/report?apikey=' . $virustotal_api_key . "&resource=" . $file_hash;

        $api_reply = file_get_contents($report_url);
        $api_reply_array = json_decode($api_reply, true);
        echo 'api_reply_array start';
        var_dump($api_reply_array);
        echo 'api_reply_array end';

        if ($api_reply_array['response_code'] == - 2) {

            echo $api_reply_array['verbose_msg'];
        }
        if ($api_reply_array['response_code'] == 1) {
            echo "\nWe got an antivirus report, there were " . $api_reply_array['positives'] . " positives found. Here is the full data: \n\n";
            print_r($api_reply_array);
            exit;
        }
        if ($api_reply_array['response_code'] == '0') {

            // default url where to post files
            $post_url = 'https://www.virustotal.com/vtapi/v2/file/scan';

            // get a special URL for uploading files larger than 32MB (up to 200MB)
            if ($file_size_mb >= 32) {
                $api_reply = @file_get_contents('https://www.virustotal.com/vtapi/v2/file/scan/upload_url?apikey=' . $virustotal_api_key);
                $api_reply_array = json_decode($api_reply, true);
                if (isset($api_reply_array['upload_url']) and $api_reply_array['upload_url'] != '') {
                    $post_url = $api_reply_array['upload_url'];
                }
            }

            // send a file for checking

            // curl will accept an array here too:
            $post['apikey'] = $virustotal_api_key;
            $post['file'] = '@' . $file_to_scan;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $api_reply = curl_exec($ch);
            curl_close($ch);

            $api_reply_array = json_decode($api_reply, true);

            if ($api_reply_array['response_code'] == 1) {
                echo "\nfile queued OK, you can use this scan_id to check the scan progress:\n" . $api_reply_array['scan_id'];
                echo "\nor just keep checking using the file hash, but it will only report once it is completed (no 'PENDING/QUEUED' reply will be given).";
            }

        }


    }

    public function testerapi2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $asset_user_docs=$this->config->item('asset_user_docs');
        
        $file_name_with_full_path = realpath($asset_user_docs.'592f89b73e85c1f676c06f1d39ad3e52543265d2c011363c.PNG');
        $api_key = getenv('VT_API_KEY') ? getenv('VT_API_KEY') : 'YOUR_API_KEY';
        $cfile = curl_file_create($file_name_with_full_path);

        $post = array('apikey' => $api_key, 'file' => $cfile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.virustotal.com/vtapi/v2/file/scan');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1); // remove this if your not debugging
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // please compress data
        curl_setopt($ch, CURLOPT_USERAGENT, "gzip, My php curl client");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        print("status = $status_code\n");
        if ($status_code == 200) { // OK
            $js = json_decode($result, true);
            print_r($js);
        } else {  // Error occured
            print($result);
        }
        curl_close($ch);
    }


    public function testndb()
    {

        if (!IPLOC::Office_and_Vpn()) {
            die();
        }


        $this->load->model('General_model');
        $this->load->model('user_model');
        $this->g_m = $this->General_model;
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;
        $this->lang->load('bonus');
        $testuserid = 189031;
        $testaccountnumber = 255712;
        $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
            $table1 = 'users', $table2 = 'user_profiles',
            $field2 = 'user_profiles.full_name', $id2 = trim('Fayaz Bilal'),
            $field1 = 'user_profiles.dob', $id1 = trim('1983-01-01'),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4 = $testuserid,
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email,user_profiles.dob,user_profiles.full_name,user_profiles.user_id'
        );
        var_dump($data['accountfullname']);

        //check for account email
        $data['accountemail'] = $this->t_m->showEmail_v2(
            $table1 = 'users', $table2 = 'user_profiles', $table3 = 'mt_accounts_set',
            $field1 = 'UCASE(users.email)', $id1 = 'fayaz.bilal.forex@gmail.com',
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4 = $testuserid,
            $join12 = 'users.id=user_profiles.user_id',
            $join13 = 'users.id=mt_accounts_set.user_id',
            $select = 'ndb_bonus,users.email,account_number,nodepositbonus'
        );

        //                if(IPLoc::Office()){
        //                    var_dump( $data['accountemail'] );
        //                }
        $IsAcquiredFromOtherAccount = false;

        if ($data['accountfullname']) {
            foreach ($data['accountfullname'] as $key1 => $value1) {
                if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '') {

                } else if (is_null($value1['ndb_bonus'])) {

                } else {

                    $IsAcquiredFromOtherAccount = true;
                }
            }

        }
        var_dump($IsAcquiredFromOtherAccount);
        var_dump($data['accountfullname']);

        if ($data['accountemail']) {
            foreach ($data['accountemail'] as $key2 => $value2) {
                if ((!isset($value2['ndb_bonus'])) || trim($value2['ndb_bonus']) === '') {

                } else if (is_null($value2['ndb_bonus'])) {

                } else {
                    $IsAcquiredFromOtherAccount = true;
                }

            }
        }
        $data['data']['IsAcquiredFromOtherAccount'] = $IsAcquiredFromOtherAccount;
        //                $data['data']['IsAcquiredFromOtherAccount'] = false;

        $nodepositbonus = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $testuserid, $select = 'nodepositbonus,created,createdforadvertising,accountstatus');
        $account_details = $this->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $testuserid, $select = 'mt_account_set_id');
        $user_profiles = $this->g_m->showssingle2($table = 'user_profiles', $field = 'user_id', $id = $testuserid, $select = 'country,fb');

        // FXPP-4261
        $data['data']['IsVerified'] = false;
        $data['data']['valid_for_nodepositbonus'] = false;

        if ($nodepositbonus['accountstatus'] == 1 and $nodepositbonus['nodepositbonus'] == 0) {
            $data['data']['IsVerified'] = true;
        }


        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => $testaccountnumber);
        $WebService->open_RequestAccountDetails($account_info);
        if ($WebService->request_status === 'RET_OK') {
            $ForMarStaAcc = FXPP::get_standardgroup();
            if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
                $data['IsStandardAccount'] = true;
            } else {
                $data['IsStandardAccount'] = false;
            }
        } else {
            $data['IsStandardAccount'] = false;
        }


        //FXPP-1674 Implement logic of removing the NDB tab if the client has already made his first deposit in FXPP
        $deposit = $this->g_m->showssingle3($table = 'deposit', $field = "user_id", $id = $testuserid, $field2 = "status", $id2 = 2, $select = "*", $order_by = "");
        //FXPP-1674
        //FXPP-3520
        $no_deposit = $this->g_m->showssingle2($table = 'no_deposit', $field = 'user_id', $id = $testuserid, $select = '*');
        if ($no_deposit) {
            $data['data']['has_rqstd_ndb'] = true;
        } else {
            $data['data']['has_rqstd_ndb'] = false;
        }

        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring_v2($testuserid);

        $mt_account_set = $this->g_m->showt1w1($table = 'mt_accounts_set', $field = 'user_id', $id = $testuserid, $select = 'mt_currency_base');

        $data['data']['isUSDorEUR'] = false;

        $data['data']['users_currency'] = $mt_account_set['mt_currency_base'];
        $ccy = array("USD", "EUR");
        if (in_array($mt_account_set['mt_currency_base'], $ccy)) {
            $data['data']['isUSDorEUR'] = true;
        }
        if (strtoupper(FXPP::getUserContinentCode()) == 'EU') {
            $default_currency = 'EUR';

            $data['data']['bonus_negligible_view'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = 'EUR');

            $data['data']['bonus_negligible_view'] = str_replace(',', '', $data['data']['bonus_negligible_view']);

            if ($mt_account_set['mt_currency_base'] == 'USD') {
                $data['data']['bonus'] = $FXPP6539['bonus'];

            } else {
                $data['data']['bonus'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                $data['data']['bonus'] = str_replace(',', '', $data['data']['bonus']);

            }

        } else {
            $default_currency = 'USD';

            $data['data']['bonus_negligible_view'] = $FXPP6539['bonus'];

            if ($mt_account_set['mt_currency_base'] == 'USD') {
                $data['data']['bonus'] = $FXPP6539['bonus'];
            } else {
                $data['data']['bonus'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                $data['data']['bonus'] = str_replace(',', '', $data['data']['bonus']);

            }
        }

        $user_id = $testuserid;

        $data['data']['check'] = $this->load->ext_view('modal', 'check', $data['data'], true);
        $data['data']['modal_bonus_thirty_percent'] = $this->load->ext_view('modal', 'bonus_thirty_percent', $data['data'], true);
        $data['data']['modal_bonus_fifty_percent'] = $this->load->ext_view('modal', 'bonus_fifty_percent', $data['data'], true);
        $data['data']['modal_bonus_alert'] = $this->load->ext_view('modal', 'bonus_alert', $data['data'], true);
        $data['data']['modal_bonus_no_deposit_alert'] = $this->load->ext_view('modal', 'bonus_no_deposit_alert', $data['data'], true);
        $data['data']['modal_bonus_thirty_percent_alert'] = $this->load->ext_view('modal', 'bonus_thirty_percent_alert', $data['data'], true);
        $data['data']['modal_bonus_fifty_percent_alert'] = $this->load->ext_view('modal', 'bonus_fifty_percent_alert', $data['data'], true);
        $data['data']['modal_bonus_claim_alert'] = $this->load->ext_view('modal', 'bonus_claim_alert', $data['data'], true);


        if (is_null($nodepositbonus['createdforadvertising'])) {
            $data['datecreated'] = $nodepositbonus['created'];
        } else {
            $data['datecreated'] = $nodepositbonus['createdforadvertising'];
        }
        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));

        $this->load->model('deposit_model');
        $has_no_deposit_request = $this->deposit_model->hasNoDepositRequest($user_id);

        $data['data']['test'] = "-------nodepositbonus : "
            . $nodepositbonus['nodepositbonus'] . "-------datedifference : "
            . $datedifference . "-------account_details : "
            . $account_details['mt_account_set_id'] . "------deposit : "
            . $deposit . "------has_no_deposit_request : "
            . $has_no_deposit_request . "------IsAcquiredFromOtherAccount : "
            . $IsAcquiredFromOtherAccount . "------user_id : "
            . $user_id . "------id : "
            . $id = $_SESSION['user_id'];


        if ($nodepositbonus['nodepositbonus'] == 1 OR $datedifference > 7 OR $account_details['mt_account_set_id'] != 1 OR $deposit != false) {
            $data['data']['expireNoDeposit'] = true;
        } else {
            $data['data']['expireNoDeposit'] = false;
        }

        $data['data']['datedifference'] = $datedifference;

        $this->load->model('account_model');
        $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($user_id);
        $account_number = $accountsByUserIdRow['account_number'];


        $allowedBonuses = FXPP::allowedBonuses($account_number);
        $data['data']['displayBonusStatistics'] = $allowedBonuses;


        if (
            ($nodepositbonus['nodepositbonus'] == 0 or $nodepositbonus['nodepositbonus'] == null) &&
            ($data['data']['has_rqstd_ndb'] == false) &&
            ($data['IsStandardAccount'] == true) &&
            ($datedifference <= 7) &&
            ($account_details['mt_account_set_id'] == 1) &&
            ($deposit == false) && ($data['IsAcquiredFromOtherAccount'] == false)
        ) {
            $data['data']['valid_for_nodepositbonus'] = true;
        } else {
            $data['data']['valid_for_nodepositbonus'] = false;
        }


        if (IPLoc::Office()) {
            $conditions = array(
                'has_nodepositbonus'         => $nodepositbonus['has_nodepositbonus'],
                'has_rqstd_ndb'              => $data['data']['has_rqstd_ndb'],
                'IsStandardAccount'          => $data['IsStandardAccount'],
                'date_diff'                  => $datedifference,
                'mt_account_set_id'          => $account_details['mt_account_set_id'],
                'hasdeposit'                 => $deposit,
                'valid_for_nodepositbonus'   => $data['data']['valid_for_nodepositbonus'],
                'IsAcquiredFromOtherAccount' => $IsAcquiredFromOtherAccount
            );
            var_dump($conditions);
        }


    }

    public function checkses()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';

    }

    public function testndb2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->model('General_model');
        $this->load->model('user_model');
        $this->g_m = $this->General_model;
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;
        $this->lang->load('bonus');

        $user_id = 180778;
        $data['user_profiles'] = $this->g_m->showssingle($table = 'user_profiles', $field = "user_id", $id = $user_id, $select = "dob,zip", $order_by = "");
        $mydob = $data['user_profiles']['dob'];
        $myfullname = 'Hubert Habrych';
        $myemail = 'macbook710@gmail.com';
        $myzip = $data['user_profiles']['zip'];
        $myIP = '89.79.87.165';

        //jira FXPP-2147 separate validation of fullname and email separate query
        //check for account fullname
        $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
            $table1 = 'users', $table2 = 'user_profiles',
            $field2 = 'user_profiles.full_name', $id2 = trim($myfullname),
            $field1 = 'user_profiles.dob', $id1 = trim($mydob),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4 = $user_id,
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        //check for account email
        $data['accountemail'] = $this->t_m->showEmail_v2(
            $table1 = 'users', $table2 = 'user_profiles', $table3 = 'mt_accounts_set',
            $field1 = 'UCASE(users.email)', $id1 = $myemail,
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4 = $user_id,
            $join12 = 'users.id=user_profiles.user_id',
            $join13 = 'users.id=mt_accounts_set.user_id',
            $select = 'ndb_bonus,users.email,account_number,nodepositbonus'
        );

        $IsAcquiredFromOtherAccount = false;

        if ($data['accountfullname']) {
            foreach ($data['accountfullname'] as $key1 => $value1) {
                if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '') {

                } else if (is_null($value1['ndb_bonus'])) {

                } else {

                    $IsAcquiredFromOtherAccount = true;
                }
            }

        }

        if ($data['accountemail']) {
            foreach ($data['accountemail'] as $key2 => $value2) {
                if ((!isset($value2['ndb_bonus'])) || trim($value2['ndb_bonus']) === '') {

                } else if (is_null($value2['ndb_bonus'])) {

                } else {
                    $IsAcquiredFromOtherAccount = true;
                }

            }
        }


        // jira FXPP-7752
        $data['accountfullnameIP'] = $this->t_m->showt2w3j2sFullnameIP(
            $table1 = 'users', $table2 = 'user_profiles', $table3 = 'mt_accounts_set',
            $field2 = 'user_profiles.full_name', $id2 = trim($myfullname),
            $field1 = 'mt_accounts_set.registration_ip', $id1 = $myIP,
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4 = $user_id,
            $join12 = 'users.id=user_profiles.user_id',
            $join31 = 'mt_accounts_set.user_id=users.id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        if ($data['accountfullnameIP']) {
            foreach ($data['accountfullnameIP'] as $key3 => $value3) {
                if ((!isset($value3['ndb_bonus'])) || trim($value3['ndb_bonus']) === '') {

                } else if (is_null($value3['ndb_bonus'])) {

                } else {
                    $IsAcquiredFromOtherAccount = true;
                }

            }
        }

        $data['contacts'] = $this->g_m->showssingle($table = 'contacts', $field = "user_id", $id = $user_id, $select = "phone1", $order_by = "");
        $myphone1 = $data['contacts']['phone1'];
        //jira FXPP-7752

        $data['accountAdditionalInfo'] = $this->t_m->accountAdditionalInfo(
            $table1 = 'users', $table2 = 'user_profiles', $table3 = 'contacts',
            $field1 = 'phone1', $id1 = $myphone1,
            $field2 = 'contacts.user_id', $id2 = $mydob,
            $field3 = 'zip', $id3 = $myzip,
            $field4 = 'users.ndb_bonus!=', $id4 = '',
            $field5 = 'users.id !=', $id5 = $user_id,
            $join12 = 'user_profiles.user_id=users.id',
            $join31 = 'contacts.user_id=users.id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );
        if ($data['accountAdditionalInfo']) {
            foreach ($data['accountAdditionalInfo'] as $key4 => $value4) {
                if ((!isset($value4['ndb_bonus'])) || trim($value4['ndb_bonus']) === '') {

                } else if (is_null($value4['ndb_bonus'])) {

                } else {
                    $IsAcquiredFromOtherAccount = true;
                }

            }
        }


        echo 'IsAcquiredFromOtherAccount /' . $IsAcquiredFromOtherAccount . '/';


        $data['data']['IsAcquiredFromOtherAccount'] = $IsAcquiredFromOtherAccount;
        //                $data['data']['IsAcquiredFromOtherAccount'] = false;

        $nodepositbonus = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $user_id, $select = 'nodepositbonus,created,createdforadvertising,accountstatus');
        $account_details = $this->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $user_id, $select = 'mt_account_set_id');
        $user_profiles = $this->g_m->showssingle2($table = 'user_profiles', $field = 'user_id', $id = $user_id, $select = 'country,fb');

        // FXPP-4261
        $data['data']['IsVerified'] = false;
        $data['data']['valid_for_nodepositbonus'] = false;

        if ($nodepositbonus['accountstatus'] == 1 and $nodepositbonus['nodepositbonus'] == 0) {
            $data['data']['IsVerified'] = true;
        }


        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => '231544');
        $WebService->open_RequestAccountDetails($account_info);
        if ($WebService->request_status === 'RET_OK') {
            $ForMarStaAcc = FXPP::get_standardgroup();
            if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
                $data['IsStandardAccount'] = true;
            } else {
                $data['IsStandardAccount'] = false;
            }
        } else {
            $data['IsStandardAccount'] = false;
        }


        //FXPP-1674 Implement logic of removing the NDB tab if the client has already made his first deposit in FXPP
        $deposit = $this->g_m->showssingle3($table = 'deposit', $field = "user_id", $id = $user_id, $field2 = "status", $id2 = 2, $select = "*", $order_by = "");
        //FXPP-1674
        //FXPP-3520
        $no_deposit = $this->g_m->showssingle2($table = 'no_deposit', $field = 'user_id', $id = $user_id, $select = '*');
        if ($no_deposit) {
            $data['data']['has_rqstd_ndb'] = true;
        } else {
            $data['data']['has_rqstd_ndb'] = false;
        }

        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring_v2($user_id);

        $mt_account_set = $this->g_m->showt1w1($table = 'mt_accounts_set', $field = 'user_id', $id = $user_id, $select = 'mt_currency_base');

        $data['data']['isUSDorEUR'] = false;

        $data['data']['users_currency'] = $mt_account_set['mt_currency_base'];
        $ccy = array("USD", "EUR");
        if (in_array($mt_account_set['mt_currency_base'], $ccy)) {
            $data['data']['isUSDorEUR'] = true;
        }
        if (strtoupper(FXPP::getUserContinentCode()) == 'EU') {
            $default_currency = 'EUR';

            $data['data']['bonus_negligible_view'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = 'EUR');

            $data['data']['bonus_negligible_view'] = str_replace(',', '', $data['data']['bonus_negligible_view']);

            if ($mt_account_set['mt_currency_base'] == 'USD') {
                $data['data']['bonus'] = $FXPP6539['bonus'];

            } else {
                $data['data']['bonus'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                $data['data']['bonus'] = str_replace(',', '', $data['data']['bonus']);

            }

        } else {
            $default_currency = 'USD';

            $data['data']['bonus_negligible_view'] = $FXPP6539['bonus'];

            if ($mt_account_set['mt_currency_base'] == 'USD') {
                $data['data']['bonus'] = $FXPP6539['bonus'];
            } else {
                $data['data']['bonus'] = FXPP::get_convert_amount($from_currency = 'USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                $data['data']['bonus'] = str_replace(',', '', $data['data']['bonus']);

            }
        }

        $user_id = $user_id;

        $data['data']['check'] = $this->load->ext_view('modal', 'check', $data['data'], true);
        $data['data']['modal_bonus_thirty_percent'] = $this->load->ext_view('modal', 'bonus_thirty_percent', $data['data'], true);
        $data['data']['modal_bonus_fifty_percent'] = $this->load->ext_view('modal', 'bonus_fifty_percent', $data['data'], true);
        $data['data']['modal_bonus_alert'] = $this->load->ext_view('modal', 'bonus_alert', $data['data'], true);
        $data['data']['modal_bonus_no_deposit_alert'] = $this->load->ext_view('modal', 'bonus_no_deposit_alert', $data['data'], true);
        $data['data']['modal_bonus_thirty_percent_alert'] = $this->load->ext_view('modal', 'bonus_thirty_percent_alert', $data['data'], true);
        $data['data']['modal_bonus_fifty_percent_alert'] = $this->load->ext_view('modal', 'bonus_fifty_percent_alert', $data['data'], true);
        $data['data']['modal_bonus_claim_alert'] = $this->load->ext_view('modal', 'bonus_claim_alert', $data['data'], true);


        if (is_null($nodepositbonus['createdforadvertising'])) {
            $data['datecreated'] = $nodepositbonus['created'];
        } else {
            $data['datecreated'] = $nodepositbonus['createdforadvertising'];
        }
        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));

        $this->load->model('deposit_model');
        $has_no_deposit_request = $this->deposit_model->hasNoDepositRequest($user_id);

        $data['data']['test'] = "-------nodepositbonus : "
            . $nodepositbonus['nodepositbonus'] . "-------datedifference : "
            . $datedifference . "-------account_details : "
            . $account_details['mt_account_set_id'] . "------deposit : "
            . $deposit . "------has_no_deposit_request : "
            . $has_no_deposit_request . "------IsAcquiredFromOtherAccount : "
            . $IsAcquiredFromOtherAccount . "------user_id : "
            . $user_id . "------id : "
            . $id = $_SESSION['user_id'];


        if ($nodepositbonus['nodepositbonus'] == 1 OR $datedifference > 7 OR $account_details['mt_account_set_id'] != 1 OR $deposit != false) {
            $data['data']['expireNoDeposit'] = true;
        } else {
            $data['data']['expireNoDeposit'] = false;
        }

        $data['data']['datedifference'] = $datedifference;

        $this->load->model('account_model');
        $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($user_id);
        $account_number = $accountsByUserIdRow['account_number'];


        $allowedBonuses = FXPP::allowedBonuses($account_number);
        $data['data']['displayBonusStatistics'] = $allowedBonuses;


        if (
            ($nodepositbonus['nodepositbonus'] == 0 or $nodepositbonus['nodepositbonus'] == null) &&
            ($data['data']['has_rqstd_ndb'] == false) &&
            ($data['IsStandardAccount'] == true) &&
            ($datedifference <= 7) &&
            ($account_details['mt_account_set_id'] == 1) &&
            ($deposit == false) && ($data['IsAcquiredFromOtherAccount'] == false)
        ) {
            $data['data']['valid_for_nodepositbonus'] = true;
        } else {
            $data['data']['valid_for_nodepositbonus'] = false;
        }


        $conditions = array(
            'has_nodepositbonus'         => $nodepositbonus['has_nodepositbonus'],
            'has_rqstd_ndb'              => $data['data']['has_rqstd_ndb'],
            'IsStandardAccount'          => $data['IsStandardAccount'],
            'date_diff'                  => $datedifference,
            'mt_account_set_id'          => $account_details['mt_account_set_id'],
            'hasdeposit'                 => $deposit,
            'valid_for_nodepositbonus'   => $data['data']['valid_for_nodepositbonus'],
            'IsAcquiredFromOtherAccount' => $IsAcquiredFromOtherAccount
        );
        var_dump($conditions);

    }

    function testcondition()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->model('General_model');
        $this->load->model('user_model');
        $this->g_m = $this->General_model;
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;


        $data['accountAdditionalInfo'] = $this->t_m->accountAdditionalInfo(
            $table1 = 'users', $table2 = 'user_profiles', $table3 = 'contacts',
            $field1 = 'phone1', $id1 = '+63984681984',
            $field2 = 'contacts.user_id', $id2 = '1985-01-09',
            $field3 = 'zip', $id3 = $myzip,
            $field4 = 'users.ndb_bonus!=', $id4 = '',
            $field5 = 'users.id !=', $id5 = $user_id,
            $join12 = 'user_profiles.user_id=users.id',
            $join31 = 'contacts.user_id=users.id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        if ($data['accountAdditionalInfo']) {
            foreach ($data['accountAdditionalInfo'] as $key4 => $value4) {
                if ((!isset($value4['ndb_bonus'])) || trim($value4['ndb_bonus']) === '') {

                } else if (is_null($value4['ndb_bonus'])) {

                } else {
                    $IsAcquiredFromOtherAccount = true;
                }

            }
        }

    }


    function testcondition3()
    {
        die();
        echo 'teaadsad';
    }

    function testcondition2()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;

        /*Get special referral affiliate code that restrict user accounts*/
        $aff_code = $this->t_m->getspecialaffiliatecode();
        if ($aff_code) {
            $affiliate_array = array();
            foreach ($aff_code as $aff_key => $aff_value) {
                array_push($affiliate_array, $aff_value['affiliate_code']);
            }
            $user_ref_code = $this->t_m->getreferralcode($_SESSION['user_id']);
            if ($user_ref_code) {
                if (in_array($user_ref_code[0]['referral_affiliate_code'], $affiliate_array)) {
                    $data['data']['prohibit'] = true;
                } else {
                    $data['data']['prohibit'] = false;
                }
            }

        }
        /*Get special referral affiliate code that restrict user accounts*/


//        var_dump($affiliate_array);

    }

    function testacc()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        self::CI()->load->model('General_model');
        self::CI()->load->model('Task_model');
        self::CI()->g_m = self::CI()->General_model;
        self::CI()->t_m = self::CI()->Task_model;
        $live = self::CI()->g_m->showssingle2($table = 'live_accounts', $field = 'id', $id = $_SESSION['user_id'], $select = '*');


    }

    public function test_liveaccounts()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;

        $liveaccount = $this->t_m->getLiveaccount($user_id = '193550');
        var_dump($liveaccount);
        echo $liveaccount['email'];

    }

    public function test_partneraccounts()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;
        $liveaccount = $this->t_m->getPartneraccount($user_id = '127785');
        var_dump($liveaccount);
        echo $liveaccount['email'];
    }

    public function test_approvedliveaccounts()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;
        $liveaccount = $this->t_m->approvedLiveaccounts($email = 'Xzvitorepec952@aol.com', $full_name = 'Marcos Bajuk', $street = '', $city = 'Podnart', $state = 'EU', $country = 'SI', $zip = '4244', $dob = '0000-00-00', $last_ip = '89.142.119.175');
        var_dump($liveaccount);
    }

    public function test_approvedpartneraccounts()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;
        $liveaccount = $this->t_m->approvedPartneraccounts($email = 'Xtrowabarton00005@gmail.com', $full_name = 'FX Prog1');
        var_dump($liveaccount);


    }

    public function test_j7885()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $account_number = 258043;

        $getAccountAgent = FXPP::GetAccountAgent($account_number);
        if ($getAccountAgent) {

            $webservice_config = array('server' => 'live_new');
            $WebServiceRemove = new WebService($webservice_config);
            $WebServiceRemove->RemoveAgentOfAccount($account_number);
            if ($WebServiceRemove->request_status === 'RET_OK') {
                $removeData = array(
                    'AccountNumber'      => $account_number,
                    'AgentAccountNumber' => $getAccountAgent,
                    'DateRemoved'        => FXPP::getCurrentDateTime()
                );
                $this->general_model->insertmy($table = "removed_agents", $removeData);
                $agentremovalvalidation = true;
                $mydata['removeagent'] = array(
                    'removeagent_log' => 1
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = 191889, $mydata['removeagent']);
            } else {
                $agentremovalvalidation = false;
                $mydata['removeagent'] = array(
                    'removeagent_log' => 2
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = 191889, $mydata['removeagent']);
            }
        } else {

            $agentremovalvalidation = true;

            $mydata['removeagent'] = array(
                'removeagent_log' => 3
            );

            $this->general_model->updatemy($table = 'users', $field = 'id', $id = 191889, $mydata['removeagent']);
        }

    }

    public function ndbcheckragents()
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        /* Create a test table to log all account still with agents whom have ndb bonus */

        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;

        /*Get special referral affiliate code that restrict user accounts*/
        $ganv = $this->t_m->getaccountnumbersview();
        $count = 0;
        foreach ($ganv as $key => $value) {
            $account_number = $value['account_number'];
            $getAccountAgent = FXPP::GetAccountAgent($account_number);

            if ($getAccountAgent) {
                $count = $count + 1;

                echo 'count ' . $count . ' account_number ' . $account_number . '<br/>';
                $withagent = array(
                    'account_number' => $account_number
                );
                $this->general_model->insertmy($table = "test_ndbremovedagents", $withagent);
            } else {
                echo 'n/a  account_number ' . $account_number . '<br/>';
            }
        }


    }

    public function ndbcheckragents2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        echo $this->template->pdfviewer() . '?file=' . $this->template->pdf() . 'No Deposit Bonus.pdf#zoom=page-width';
    }

    public function updatecomment()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');

        $this->t_m = $this->Task_model;

        $ganv = $this->t_m->getandupdate_date();
//        var_dump($ganv);

        foreach ($ganv as $key => $value) {

            $mydata['date'] = array(
                'comment' => $value['ndba_acquired']
            );

            $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $value['account_number'], $mydata['date']);

        }

    }

    public function test2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('General_model');
        $this->g_m = $this->General_model;
        $data['datecreated'] = '2017-05-05 19:28:26';
        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));
        echo 'date' . $datedifference;
        echo $datedifference > 7 ? "Account has exceeded 7 days of No Deposit Bonus" : 'here';
    }

    public function test_transfer()
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        /*1*/
//            $amountRequested=100;
//            $account_number='227173';
//            $prtnrshp['currency']="EUR";
        /*2*/
        $amountRequested = 230;
        $account_number = '261689';
        $prtnrshp['currency'] = "USD";
        $webservice_config = array('server' => 'live_new');

        $WebServiceAD = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number);
        $WebServiceAD->open_RequestAccountDetails($account_info);
        if ($WebServiceAD->request_status === 'RET_OK') {

            $datefrom = $WebServiceAD->get_result('RegDate');

            $WebService2 = new WebService($webservice_config);
            $WebService2->RequestAccountFunds($account_number);
            $getwithdrawablefund = $WebService2->get_result('Withrawable_RealFund');

            /*Add*/
            $TotalRealFund = $WebService2->get_result('TotalRealFund');
            $equity = $WebService2->get_result('Equity');
            $margin = $WebService2->get_result('Margin');
            /*Add*/


            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();

            $account_info2 = array(
                'iLogin' => $account_number,
                'from'   => $datefrom,
                'to'     => $serverTime
            );

            $WebServiceGTPfR = new WebService($webservice_config);
            $WebServiceGTPfR->open_GetAccountTotalProfitFromRange($account_info2);
            if ($WebServiceGTPfR->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceGTPfR->get_result('TotalProfit');
            } else {
                $BonusProfitFull = 0;
            }

            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $getTotalNoDepositBonus = $getAccountBonusByType[2];

            if ($amountRequested > $getwithdrawablefund) {
                if ($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0) {
                    echo 'one';
//                        $_SESSION['preventndbtransfer']=true;
                }

                echo 'two';

//                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                return false;
            }


            /*Add from validations*/
            if ($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0) {
                echo 'three';
//                    $_SESSION['preventndbtransfer']=true;
//                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                return false;
            }

            $withdrawableAmount = $equity - $margin - $getTotalNoDepositBonus - $BonusProfitFull;


            if ($BonusProfitFull > 0) {

                if ($TotalRealFund < $BonusProfitFull) {
                    echo '4';
                    //                        $_SESSION['preventndbtransfer']=true;
                }

                if ($TotalRealFund <= 0) {
                    echo 'four';
//                        $_SESSION['preventndbtransfer']=true;
//                        $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                    return false;
                }
            }

//                if($withdrawableAmount <= 0){
//                    echo 'five';
//                    $_SESSION['preventndbtransfer']=true;
//                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
//                    return false;
//                }

            /*Add from validations*/


            if ($getTotalNoDepositBonus > 0) {
                echo 'six';
                $withdrawBonusPercent = 0.20 * $getTotalNoDepositBonus;

                $withdrawableAmount = $getwithdrawablefund - $withdrawBonusPercent;

                if ($withdrawableAmount <= 0) {
//                        $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                    return false;
                }

//                    if($this->session->userdata('login_type') == 1){
//                        $getDetailsByAccountNumberSource['mt_currency_base']=$prtnrshp['currency'];
//                        $getDetailsByAccountNumberSource['mt_currency_base']=$prtnrshp['currency'];
//                    }else{
//                        $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number);
//                    }

                if ($withdrawableAmount < $amountRequested) {
//                        $errorMsg  = 'The maximum amount that can be transfer is '.$withdrawableAmount.' '.$getDetailsByAccountNumberSource['mt_currency_base'];
//                        $this->form_validation->set_message('validateFundsAccounts', $errorMsg);
                    return false;
                }

                if ($amountRequested > $getTotalNoDepositBonus) {
                    $errorMsg = 'Transfer request must be less than or equal to Bonus received. ';

//                        $this->form_validation->set_message('validateFundsAccounts', $errorMsg);
                    return false;
                }

            }
        } else {
//                $this->form_validation->set_message('validateFundsAccounts', 'Something went wrong. Please try again later.');
            return false;
        }
        echo 'truth';

        return true;


    }

    public function removeagentaccounts()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        /* Create a test table to log all account still with agents whom have ndb bonus */

        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;

        /*Get special referral affiliate code that restrict user accounts*/
        $gafr = $this->t_m->get_agents_for_removal();

        foreach ($gafr as $key => $value) {


            $getAccountAgent = FXPP::GetAccountAgent($value['account_number']);
            if ($getAccountAgent) {
                $webservice_config = array('server' => 'live_new');
                $WebServiceRemove = new WebService($webservice_config);
                $WebServiceRemove->RemoveAgentOfAccount($value['account_number']);
                if ($WebServiceRemove->request_status === 'RET_OK') {
                    $removeData = array(
                        'AccountNumber'      => $value['account_number'],
                        'AgentAccountNumber' => $getAccountAgent,
                        'DateRemoved'        => FXPP::getCurrentDateTime()
                    );
                    $this->general_model->insertmy($table = "removed_agents", $removeData);
                    $mydata['removeagent'] = array(
                        'status' => 1
                    );
                    $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $id = $value['account_number'], $mydata['removeagent']);
                } else {
                    $mydata['removeagent'] = array(
                        'status' => 2
                    );
                    $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $id = $value['account_number'], $mydata['removeagent']);
                }
            } else {
                $mydata['removeagent'] = array(
                    'status' => 3
                );
                $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $id = $value['account_number'], $mydata['removeagent']);
            }
        }


    }

    public function test_q1()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $accData = $this->general_model->whereConditionQuery(170684);
        // 240737
        var_dump($accData);
    }

    public function test_q2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $accData = $this->general_model->whereConditionQuery2(169545, 2);
        /*239798*/
        var_dump($accData);
    }

    public function test_q4()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $accData = $this->general_model->whereConditionQueryRow(5787);
        /*263456*/
        var_dump($accData);
    }

    public function contestmftagging()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $this->load->model('Task_model');
        $accData = $this->Task_model->contestmftagging();
        $webservice_config = array('server' => 'live_new');
        foreach ($accData as $key => $value) {
            $WebServiceAD = new WebService($webservice_config);
            $account_info = array('iLogin' => $value['account_number']);
            $WebServiceAD->open_RequestAccountDetails($account_info);
            if ($WebServiceAD->request_status === 'RET_OK') {
                $mydata['save'] = array(
                    'is_mt4_active' => 1
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = $value['id'], $mydata['save']);
            } else {
                $mydata['save'] = array(
                    'is_mt4_active' => 2
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = $value['id'], $mydata['save']);
            }
        }

    }

    public function test_destruct()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();

        $this->load->model('Task_model');

        if (isset($_SESSION["user_id"])) {
            $userid = $_SESSION["user_id"];
            $accountnumber = $_SESSION["account_number"];

            $deposittransaction = $this->Task_model->getdeposittoday($userid);
            //$accountnumber=$_SESSION['account_number'];
            if ($deposittransaction) {

                $users = $this->general_model->showssingle($table = 'users', $field = "id", $id = $userid, $select = "re_add_agent_tag,nodepositbonus", $order_by = "");
                if ($users) {

                    // echo 're_add_agent_tag='.$users['re_add_agent_tag'];
                    if ($users['re_add_agent_tag'] == 1) {
                        /*do nothing agent has already been added*/
                    } else {

                        if ($users['nodepositbonus'] == 1) {
                            $webservice_config = array('server' => 'live_new');
                            $WSRAD = new WebService($webservice_config);
                            //                        $account_info = array('iLogin' => $_SESSION['account_number']);
                            $account_info = array('iLogin' => $accountnumber);
                            $WSRAD->open_RequestAccountDetails($account_info);
                            if ($WSRAD->request_status === 'RET_OK') {

                                $GetAgent = $WSRAD->get_result('Agent');
                                if ($GetAgent) {
                                    //agent is available in api
                                } else {
                                    $uac = $this->general_model->showssingle($table = 'users_affiliate_code', $field = "users_id", $id = $userid, $select = "referral_affiliate_code", $order_by = "");
                                    if ($uac) {
                                        $this->load->model('account_model');
                                        $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByCode($uac['referral_affiliate_code']);
                                        $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

                                        $service_data = array(
                                            'AccountNumber'      => $accountnumber,
                                            'AgentAccountNumber' => $AgentAccountNumber
                                        );
                                        $webservice_config = array(
                                            'server' => 'live_new'
                                        );
                                        $WS_SAA = new WebService($webservice_config);
                                        $WS_SAA->SetAccountAgent($service_data);
                                        if ($WS_SAA->request_status === 'RET_OK') {

                                            $datasave = array(
                                                're_add_agent_tag' => 1
                                            );
                                            $this->general_model->updatemy($table = 'users', $field = 'id', $id = $userid, $datasave);
                                            $datainsert = array(
                                                'user_id'        => $userid,
                                                'account_number' => $accountnumber,
                                                'agent'          => $AgentAccountNumber,
                                                'date'           => FXPP::getCurrentDateTime()
                                            );
                                            $this->general_model->insertmy($table = 'returned_agents_log', $datainsert);

                                        }


                                    }
                                }

                            } else {
                                //service error in get account details
                            }
                        }


                    }


                }
            }

        }

    }

    function usertest2()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

//        if($this->session->userdata('login_type') == 1){
//            $prtnrshp = $this->general_model->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num,currency');
//            $account_number=$prtnrshp['reference_num'];
//        }else{
//            $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
//            $account_number = $getAccountnumber[0]['account_number'];
//        }
        $account_number = '227173';
        $amountRequested = 100;

        $webservice_config = array('server' => 'live_new');

        $WebServiceAD = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number);
        $WebServiceAD->open_RequestAccountDetails($account_info);
        if ($WebServiceAD->request_status === 'RET_OK') {

            $datefrom = $WebServiceAD->get_result('RegDate');

            $WebService2 = new WebService($webservice_config);
            $WebService2->RequestAccountFunds($account_number);
            $getwithdrawablefund = $WebService2->get_result('Withrawable_RealFund');
            $Withrawable_BonusFund = $WebService2->get_result('Withrawable_BonusFund');

            /*Add*/
            $TotalRealFund = $WebService2->get_result('TotalRealFund');
            $equity = $WebService2->get_result('Equity');
            $margin = $WebService2->get_result('Margin');
            /*Add*/


            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();

            $account_info2 = array(
                'iLogin' => $account_number,
                'from'   => $datefrom,
                'to'     => $serverTime
            );

            $WebServiceGTPfR = new WebService($webservice_config);
            $WebServiceGTPfR->open_GetAccountTotalProfitFromRange($account_info2);
            if ($WebServiceGTPfR->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceGTPfR->get_result('TotalProfit');
            } else {
                $BonusProfitFull = 0;
            }

            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $getTotalNoDepositBonus = $getAccountBonusByType[2];


            /*---------------------------------------------------new validataion ----------------------------------------------*/

            $getAccountBonusAllBonus = FXPP::getAccountBonusByType($account_number);
            $BonusTotalAmount = 0;
            foreach ($getAccountBonusAllBonus as $bkey) {
                $BonusTotalAmount = $BonusTotalAmount + $bkey;
            }


            if ($amountRequested <= $getwithdrawablefund) {

            } else {

                if ($Withrawable_BonusFund <= 0 or $Withrawable_BonusFund < $amountRequested) {
                    echo 'ff';
                    $_SESSION['preventndbtransfer'] = true;
                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                    return false;
                }
                if ($BonusTotalAmount <= 0 or $BonusTotalAmount < $amountRequested) {
                    echo 'c';
                    $_SESSION['preventndbtransfer'] = true;
                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                    return false;
                }

            }

            if ($getwithdrawablefund < $amountRequested) {
                echo 'd';
                //                $_SESSION['preventndbtransfer']=true;
                $modalMessage = 'Insufficient fund ! [ your maximum withdrawal balance is ' . $getwithdrawablefund . " ]";
                $this->form_validation->set_message('validateFundsAccounts', $modalMessage);

                return false;
            }


            if ($amountRequested > $getwithdrawablefund) {
                echo 'a';
                if ($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0) {
                    $_SESSION['preventndbtransfer'] = true;
                }
                $modalMessage = 'Insufficient fund ! [ your maximum withdrawal balance is ' . $getwithdrawablefund . " ]";
                $this->form_validation->set_message('validateFundsAccounts', $modalMessage);

                return false;
            }


            /*---------------------------------------------------new validataion close ----------------------------------------------*/


            ### hide from validation
            /*Add from validations*/
            /*



                                                        if($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0 ) {
                                                            $_SESSION['preventndbtransfer']=true;
                                                            $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                                                            return false;
                                                        }




                                                        $withdrawableAmount = $equity - $margin - $getTotalNoDepositBonus -  $BonusProfitFull;
                                        //                if ($amountRequested >$TotalRealFund) {
                                        //                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                                        //                    return false;
                                        //                }

                                                        if($BonusProfitFull > 0) {

                                                            if ($TotalRealFund < $BonusProfitFull) {
                                        //                        $_SESSION['preventndbtransfer']=true;
                                                            }

                                                            if ($TotalRealFund<=0){
                                                                // $_SESSION['preventndbtransfer']=true;
                                                                $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                                                                return false;
                                                            }
                                                        }
                                                    if($this->session->userdata('login_type') == 1){

                                                    }else{
                                                        if($withdrawableAmount <= 0){
                                                            $_SESSION['preventndbtransfer']=true;
                                                            $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');
                                                            return false;
                                                        }
                                                    }

                */
            /*Add from validations*/


            if ($getTotalNoDepositBonus > 0) {
                echo 'e';
                $withdrawBonusPercent = 0.20 * $getTotalNoDepositBonus;

                $withdrawableAmount = $getwithdrawablefund - $withdrawBonusPercent;

                if ($withdrawableAmount <= 0) {
                    $this->form_validation->set_message('validateFundsAccounts', 'Insufficient Fund.');

                    return false;
                }

                if ($this->session->userdata('login_type') == 1) {
                    $getDetailsByAccountNumberSource['mt_currency_base'] = $prtnrshp['currency'];
                } else {
                    $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number);
                }

                if ($withdrawableAmount < $amountRequested) {
                    $errorMsg = 'The maximum amount that can be transfer is ' . $withdrawableAmount . ' ' . $getDetailsByAccountNumberSource['mt_currency_base'];
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);

                    return false;
                }

                if ($amountRequested > $getTotalNoDepositBonus) {
                    $errorMsg = 'Transfer request must be less than or equal to Bonus received. ';
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);

                    return false;
                }

            }

        }
    }

    function usertest()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');
        $accData = $this->Task_model->check_not_removedagent();

        foreach ($accData as $key => $value) {
            echo $value['account_number'] . '<br/>';
            $webservice_config = array('server' => 'live_new');
            $WSAD = new WebService($webservice_config);
            $account_info = array('iLogin' => $value['account_number']);
            $WSAD->open_RequestAccountDetails($account_info);
            if ($WSAD->request_status === 'RET_OK') {
                $Agent = $WSAD->get_result('Agent');
                $regdate = $WSAD->get_result('RegDate');
                if ($Agent) {
                    $removeData = array(
                        'account_number'   => $value['account_number'],
                        'agent'            => $Agent,
                        'date'             => date('Y-m-d H:i:s'),
                        'api_registration' => $regdate
                    );
                    $this->general_model->insertmy($table = "test_agent_notremoved", $removeData);
                    $this->general_model->updatemy($table = 'mt_accounts_set', 'account_number', $value['account_number'], array('agent_ndbtag' => '1'));
                } else {
                    $this->general_model->updatemy($table = 'mt_accounts_set', 'account_number', $value['account_number'], array('agent_ndbtag' => '2'));
                }
            } else {
                $this->general_model->updatemy($table = 'mt_accounts_set', 'account_number', $value['account_number'], array('agent_ndbtag' => '3'));
            }
        }
    }

    function usertestagain()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');
        $accData = $this->Task_model->check_not_removedagent2();

        foreach ($accData as $key => $value) {
            echo $value['account_number'] . '<br/>';
            $webservice_config = array('server' => 'live_new');
            $WSAD = new WebService($webservice_config);
            $account_info = array('iLogin' => $value['account_number']);
            $WSAD->open_RequestAccountDetails($account_info);
            if ($WSAD->request_status === 'RET_OK') {

            } else {

            }
        }
    }

    function usertestfix()
    {
        die();
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $this->load->model('Task_model');
//        $accData = $this->Task_model->check_not_removedagent();

        //        foreach ( $accData as $key => $value) {
        $value['account_number'] = 255644;
//        echo $value['account_number'].'<br/>';
        $webservice_config = array('server' => 'live_new');
        $WSAD = new WebService($webservice_config);
        $account_info = array('iLogin' => $value['account_number']);
        $WSAD->open_RequestAccountDetails($account_info);
        if ($WSAD->request_status === 'RET_OK') {
//            var_dump($WSAD);
            $Agent = $WSAD->get_result('Agent');
            $regdate = $WSAD->get_result('RegDate');

            if ($Agent != 0) {
                echo 'one';
                $removeData = array(
                    'account_number'   => $value['account_number'],
                    'agent'            => $Agent,
                    'date'             => date('Y-m-d H:i:s'),
                    'api_registration' => $regdate
                );
                var_dump($removeData);
                $this->general_model->insertmy($table = "test_agent_notremoved", $removeData);
                $this->general_model->updatemy($table = 'mt_accounts_set', 'account_number', $value['account_number'], array('agent_ndbtag' => '1'));
                echo 'done';
            } else {
                echo 'two';
//                    $this->general_model->updatemy($table='mt_accounts_set','account_number',$value['account_number'],array('agent_ndbtag'=>'2'));
            }


        } else {
            echo 'three';
            $this->general_model->updatemy($table = 'mt_accounts_set', 'account_number', $value['account_number'], array('agent_ndbtag' => '3'));
        }
        //        }
    }

    function testdate()
    {
        die();
        echo date('Y-m-d H:i:s');
    }


    function inviteFriendTest()
    {

        $arrayName = array(
            'iLogin'        => 192912,
            'transactionId' => 17,
            'from'          => date('Y-m-d\TH:i:s', strtotime('5/19/2016 17:30:00')),
            'to'            => date('Y-m-d\TH:i:s')
        );

        $data = array();
        $webservice_config = array('server' => 'live_new');
        $WebService2 = new WebService($webservice_config);
        $WebService2->RequestFinanceRecordsByTransactionId($arrayName);
        if ($WebService2->request_status == 'RET_OK') {

            foreach ($WebService2->result as $object) {

                $data['invFriend'] .= '<tr>';
                $data['invFriend'] .= '<td>' . $object->FundType . '</td>';      //transaction
                $data['invFriend'] .= '<td>' . $object->Comment . '</td>';      //transaction
                $data['invFriend'] .= '<td>' . $object->AccountNumber . '</td>';  //account
                $data['invFriend'] .= '<td>' . $object->Amount . '</td>';         //amount
                $data['invFriend'] .= '<td>' . $object->Stamp . '</td>';          //date
                $data['invFriend'] .= '</tr>';
            }

        }
        echo "<table>" . $data['invFriend'] . "</table>";

    }

    public function removeagentmethod()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        if (!IPLOC::Office_and_Vpn()) {
            die();
        }
        $this->load->view('_check');

    }

    public function commissin_mo3()
    {
        $webservice_config = array('server' => 'live_new');
        $WSAD = new WebService($webservice_config);
        $account_info = array('iLogin' => 140093);
        $WSAD->open_RequestAccountDetails($account_info);
        var_dump($WSAD);
//        if ($WSAD->request_status === 'RET_OK') {
//            echo $WSAD->get_result('RegDate');
//        }
    }

    public function commissin_mo2()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        echo 'test' . '<br/>';
//        $this->load->model('Task_model');
//        $this->t_m=$this->Task_model;
//        $gafr = $this->t_m->getagents();
//        var_dump($gafr);

        $webservice_config = array('server' => 'live_new');
        $WS_GT = new WebService($webservice_config);
        $account_info = array(
            'iAgent'   => 101889,
            'iAccount' => 258527,
            'from'     => '2017-04-13T07:03:58',
            'to'       => '2017-06-02T01:00:00',
        );
//        var_dump($account_info);
        $WS_GT->open_GetAgentTotalCommissionFromAccount($account_info);
//        var_dump($WS_GT);
//        echo 'ok';

//        var_dump($WS_GT);
//        $regdate = $WS_GT->get_result('TotalAmount');

//        echo $WS_GT->get_result('TotalAmount');

        if ($WS_GT->request_status === 'RET_OK') {
            echo 'ok';
            var_dump($WS_GT->get_result('TotalAmount'));
//
        } else {
            echo 'fail';
        }
    }

    public function stringlower()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
//        276622	michele.larosa@gmail.com	+393358176270	michele la rosa	Via Luigi Carlo Farini 3	Bologna	Bologna	IT	40124
        echo strtolower(276622);
        echo strtolower('michele.larosa@gmail.com');
        echo strtolower('+393358176270');
        echo strtolower('michele la rosa	Via Luigi Carlo Farini 3');
        echo strtolower('Bologna');
        echo strtolower('IT	40124');

    }

    public function commissin_mo1()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();

        $this->load->view('_check');

    }

    public function checkndb()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring_v2(180778);
        var_dump($FXPP6539);

    }

    public function checkndbnow()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        die();
        $this->load->library('Bonus_Library');
        $FXPP6539 = Bonus_Library::getScoring_v2(180778);
//        var_dump($FXPP6539);
        echo $FXPP6539['bonus'];
        $FXPP6539 = Bonus_Library::creditNDB_v2($bonus = $FXPP6539['bonus'], $account_number = '248897', $email = 'macbook710@gmail.com');

    }

    public function testaccount()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }

        $this->load->model('Task_model');
        $this->t_m = $this->Task_model;

        $aff_code = $this->t_m->getspecialaffiliatecode();
        if ($aff_code) {
            $affiliate_array = array();
            foreach ($aff_code as $aff_key => $aff_value) {
                array_push($affiliate_array, $aff_value['affiliate_code']);
            }
            $user_ref_code = $this->t_m->getreferralcode(180778);
            if ($user_ref_code) {
                if (in_array($user_ref_code[0]['referral_affiliate_code'], $affiliate_array)) {
                    $data['data']['prohibit'] = true;
                    echo '11';
                } else {
                    $data['data']['prohibit'] = false;
                    echo '12';
                }
            }

        }

    }

    public function postsize()
    {
        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        echo ini_get('post_max_size');
        echo '<br/>';
        echo (int) (str_replace('M', '', ini_get('post_max_size')) * 1024 * 1024);
    }

    public function test_ech()
    {
        echo "string";
    }


    public function paypaltest()
    {

        if (!IPLoc::Office()) {
            redirect('');
        }

        /*Duplicate validation check*/

        $data = array(
            'transaction_id'   => '59A72921L62051506',
            'reference_id'     => '1497922050',
            'user_id'          => '186265',
            'transaction_type' => 'PAYPAL'
        );

        $queue_data = $data;

        $condition = array(
            'transaction_id'   => $queue_data['transaction_id'],
            'reference_id'     => $queue_data['reference_id'],
            'transaction_type' => 'PAYPAL'
        );

        if ($row = $this->general_model->whereCondition('deposit_queue', $condition)) {

            $insertData = array('log' => serialize($_POST), 'ip' => $this->input->ip_address(), 'type' => 'PAYPAL');
            $this->general_model->insertmy('fasapay_log', $insertData);

            return false;
        }

        print_r($row);

        /*End Duplicate validation check*/
    }

    public function testBanktransfer()
    {

//        $user_id = 52263;
//
//
//        $cpa_type = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=$user_id,$select='type_of_partnership,reference_num,reference_subnum');
//        $data['AN_type']=2;
//        $getAccountNumber = $this->account_model->getAccountNumber($user_id);
//        $data['AN'] = $getAccountNumber['account_number'];
//        $data['user_profiles']['country']='';
//
//            $receiving_cpaAcct = $this->general_model->showssingle($table='partnership',$id='reference_subnum', $field=$cpa_type['reference_num'],$select='reference_num');
//            $iLogin = $receiving_cpaAcct['reference_num'];
//


//        $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
//        $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
//
//
////        $user_id = $this->session->userdata('user_id');
//
//        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
//        echo '<br>';  print_r($sub_partner);
//        if($sub_partner) {
//            $data['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], 1);
//            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
//        }else{
//            $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
//            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
//        }
//        $val = 0;
//        foreach ( $data['cpa'] as $d){
//          echo  $val=$val + $d->cpa_amount;
//        }
//        $data['user_commission'] = $val;

//      echo '<br>';  print_r($cpa_type);
//        echo '<br>';   print_r( $getAccountNumber);
//        echo '-------';
//        echo '<br>';  print_r($receiving_cpaAcct);
//        echo '-------';
//        echo '<br>';  print_r($iLogin);

        $account_info = array('iLogin' => $iLogin);
        $webservice_config = array('server' => 'live_new');
        $WebService2 = new WebService($webservice_config);
        $WebService2->ReqAgentStats($account_info);
        $ReqAgentStats = (array) $WebService2->result;
        switch ($WebService2->request_status) {
            case 'RET_OK':
                $data['user_referrals'] = $ReqAgentStats ["ReferralsCount"];
                $data['user_commission'] = $ReqAgentStats ["TotalCommission"];
                break;
            default:
                $data['user_referrals'] = 0;
                $data['user_commission'] = 0;
        }
        echo '<br>';
        print_r($data['user_referrals']);
    }


    public function update_group_code()
    {

        $user_id = '227741';
        $account_detail = $this->account_model->getAccountByUserId($user_id);
        $groupCurrency = $this->g_m->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
        FXPP::update_account_group();
        $account_number = $account_detail['account_number'];
        $webservice_config = array('server' => 'live_new');
        $WebService2 = new WebService($webservice_config);
        $account_info2 = array(
            'iLogin'   => $account_number,
            'strGroup' => $groupCurrency
        );
        $WebService2->open_ChangeAccountGroup($account_info2);
    }

    public function updateLeverageOnce()
    {

        $user_id = $this->session->userdata('user_id');
        $account = $this->account_model->getAccountByUserId($user_id);

        $config = array(
            'server' => 'live_new'
        );


        $info = array(
            'iLogin'    => $account['account_number'],
            'iLeverage' => '5000'
        );
        $WebService = new WebService($config);
        $WebService->open_ChangeAccountLeverage($info);
        if ($WebService->request_status === 'RET_OK') {

            $date_modified = FXPP::getCurrentDateTime();
            $update_history_data = array(
                'user_id'       => $user_id,
                'manager_id'    => $user_id,
                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
            );
            $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
            $update_history_field_data = array();
            if ($update_history_id) {
                $update_history_field_data[] = array(
                    'field'         => 'Leverage',
                    'old_value'     => $account['leverage'],
                    'new_value'     => '1:5000',
                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                    'update_id'     => $update_history_id
                );
            }
            $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
            $this->account_model->updateAccountLeverage($account['account_number'], '1:5000');

        }


    }

    public function removeagenttest($user_id)
    {
//        $getAccountAgent = FXPP::GetAccountAgent($account_number);
        $country = $this->account_model->getAccountsCountry($user_id);

        echo $country[0]['country'];
//        var_dump($country);
    }
    public function testGroupStandard($account_number)
    {
      $result =  FXPP::get_standardgroup_v2($account_number);

        var_dump($result);
    }



    public function getMissingTradesv2($account_number)
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $trade_record = array();
        $trade_record2 = array();
        echo 'account number : ' . $account_number . '<br/>';
        $webservice_config = array('server' => 'live_new');

        $date_from = date('Y-m-d 00:00:00', strtotime('10/23/2017'));
        $date_to = date('Y-m-d 23:59:59', strtotime('11/03/2017'));

        $account_info = array(
            'iLogin' => $account_number,
            'from'   => date('Y-m-d\T00:00:00', strtotime($date_from)),
            'to'     => date('Y-m-d\T23:59:59', strtotime($date_to))
        );

        $WSTH = new WebService($webservice_config);
        $WSTH->open_GetAccountTradesHistory($account_info);
        switch ($WSTH->request_status) {
            case 'RET_OK':

                $tradatalist = (array) $WSTH->get_result('TradeDataList');
                if ($tradatalist) {
                    foreach ($tradatalist['TradeData'] as $object) {


                        $tempArray = array(
                            'Follower_account_number' => '',
                            'master_accountnumber'    => $account_number,
                            'ClosePrice'              => $object->ClosePrice,
                            'CloseTime'               => $object->CloseTime,
                            'Commission'              => $object->Commission,
                            'ConversionRate1'         => $object->ConversionRate1,
                            'ConversionRate2'         => $object->ConversionRate2,

                            'Digits'     => $object->Digits,
                            'MarginRate' => $object->MarginRate,
                            'OpenPrice'  => $object->OpenPrice,
                            'OpenTime'   => $object->OpenTime,

                            'OrderTicket' => $object->OrderTicket,
                            'Profit'      => $object->Profit,
                            'Reason'      => $object->Reason,
                            'StopLoss'    => $object->StopLoss,
                            'Symbol'      => $object->Symbol,

                            'TakeProfit' => $object->TakeProfit,
                            'TradeType'  => $object->TradeType,
                            'Volume'     => $object->Volume,

                        );
                        $trade_record[$object->OrderTicket] = $tempArray;


                    }


                }

        }

        echo '<pre>';

        print_r($account_info);
        echo '<br>';

        print_r($trade_record);
        echo '<br>';

    }




        public function getMissingTrades($account_number)
    {

        if (!IPLOC::Office_and_Vpn()) {
            redirect('');
        }
        $trade_record = array();
        $trade_record2 = array();
        echo 'account number : ' . $account_number . '<br/>';
        $webservice_config = array('server' => 'live_new');

        $date_from = date('Y-m-d 00:00:00', strtotime('10/23/2017'));
        $date_to = date('Y-m-d 23:59:59', strtotime('11/03/2017'));

        $account_info = array(
            'iLogin' => $account_number,
            'from'   => date('Y-m-d\T00:00:00', strtotime($date_from)),
            'to'     => date('Y-m-d\T23:59:59', strtotime($date_to))
        );

        $WSTH = new WebService($webservice_config);
        $WSTH->open_GetAccountTradesHistory($account_info);
        switch ($WSTH->request_status) {
            case 'RET_OK':

                $tradatalist = (array) $WSTH->get_result('TradeDataList');
                if ($tradatalist) {
                    foreach ($tradatalist['TradeData'] as $object) {


                        $tempArray = array(
                            'Follower_account_number' => '',
                            'master_accountnumber' => $account_number,
                            'ClosePrice' => $object->ClosePrice,
                            'CloseTime' => $object->CloseTime,
                            'Commission' =>  $object->Commission,
                            'ConversionRate1' =>  $object->ConversionRate1,
                            'ConversionRate2' =>   $object->ConversionRate2,

                            'Digits' =>   $object->Digits,
                            'MarginRate' =>   $object->MarginRate,
                            'OpenPrice' =>   $object->OpenPrice,
                            'OpenTime' =>  $object->OpenTime,

                            'OrderTicket' =>  $object->OrderTicket,
                            'Profit' =>   $object->Profit,
                            'Reason' =>   $object->Reason,
                            'StopLoss' =>  $object->StopLoss,
                            'Symbol' =>  $object->Symbol,

                            'TakeProfit' =>   $object->TakeProfit,
                            'TradeType' =>    $object->TradeType,
                            'Volume' =>    $object->Volume,

                        );
                        $trade_record[$object->OrderTicket] = $tempArray;


                    }


                }

        }

        echo '<pre>';

        print_r($account_info);
        echo '<br>';
        print_r($trade_record);
        echo '<br>';
        echo '<br>';



        $followers = FXPP::GetFollowersByMastersAccount($account_number);

            foreach($followers as $follower){

                $account_info2 = array(
                    'iLogin' => $follower,
                    'from'   => date('Y-m-d\T00:00:00', strtotime($date_from)),
                    'to'     => date('Y-m-d\T23:59:59', strtotime($date_to))
                );

                $WSTH2 = new WebService($webservice_config);
                $WSTH2->open_GetAccountTradesHistory($account_info2);
                switch ($WSTH->request_status) {
                    case 'RET_OK':

                        $tradatalist2 = (array) $WSTH2->get_result('TradeDataList');
                        if ($tradatalist2) {
                            foreach ($tradatalist2['TradeData'] as $object2) {

                                    $tempArray2 = array(
                                        'master_accountnumber' => $account_number,
                                        'ClosePrice' => $object2->ClosePrice,
                                        'CloseTime' => $object2->CloseTime,
                                    );
                                    $trade_record2[$object->OrderTicket2] = $tempArray2;

                                }

                            }


                        }

                        foreach($trade_record as $trade_record_key => $trade_record_value){

                            if(!array_key_exists($trade_record[$trade_record_key]['OrderTicket'], $trade_record2)){
                                $trade_record[$trade_record_key]['Follower_account_number'] = $follower;
                                echo '<pre>';
                                print_r($trade_record[$trade_record_key]);
                                echo '<br>';
                                echo '<br>';

                                $this->general_model->insertmy($table = "test_table_tradehistory", $trade_record[$trade_record_key]);
                                unset($trade_record2);
                            }


                        }

                }
            }




    public static function roundno($number, $dp)
    {
        return number_format((float)$number, $dp, '.', '');
    }

    public function testgetAgent($user_id){
       $res =  FXPP::update_account_group_For_Bangladesh($user_id);
       print_r($res);
    }


    public static function testSubs($user_id){
           $ret = FXPP::isSubscribeToPartnerAccount($user_id);

           var_dump($ret);

    }



    function withdraw(){

        $amount_withdraw = 3;
        $withdrawalType = "SKRILL";

        $getTransactionFee = FXPP::getTransactionFee($withdrawalType, "USD");

        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);

        if($withdrawalType === 'SKRILL'){
            $skrillSystemFee = $this->SkrillSystemFee($amount_withdraw,"USD");
            $totalFee = $totalFee + $skrillSystemFee;
        }

        $totalFees = $totalFee + $getTransactionFee['addons'];

        $amount_deducted =  FXPP::roundno($amount_withdraw + $totalFees, 2);

        echo $amount_deducted;
    }

    public function SkrillSystemFee($amount, $currency){
        $skrillSystemFee = 0.01;
        switch($currency){
            case 'EUR':
                $limitAmountFee = 10;
                break;
            default:
                $limitAmountFee = $this->amountConverter(11.41, 'USD', $currency);
        }

        $computeSystemFee = $skrillSystemFee * $amount;

        if($computeSystemFee >= $limitAmountFee){
            $computeSystemFee = $limitAmountFee;
        }

        return $computeSystemFee;

    }

    public function amountConverter($amount, $currencyFrom, $currencyTo){

        $webservice_config = array(
            'server' => 'converter'
        );

        $WebServiceA = new WebService($webservice_config);
        $convertDetails = array(
            'Amount' => $amount,
            'FromCurrency' => $currencyFrom,
            'ServiceLogin' => 505641,
            'ServicePassword' => '5fX#p8D^c89bQ',
            'ToCurrency' => $currencyTo
        );

        $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
        $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
        if($ConvertCurrency['SOAPError'] === true || $resultConvertCurrency['Status'] === 'RET_OK'){
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        }else{
            $convertCurrencies = FXPP::ForexData($currencyFrom, $currencyTo);
            $convertedAmount = $amount*$convertCurrencies['Rate'];
        }

        $convertedAmount = round($convertedAmount, 2);

        return $convertedAmount;
    }

    public function forexdata($fromCurr,$toCurr){
      $res =  FXPP::ForexData($fromCurr, $toCurr);
      echo '<pre>';
      print_r($res);
    }

    public function getExcelData(){
        $data = [];
        $filepath = './assets/excel_trade/REPORT.xlsx';
        $type = PHPExcel_IOFactory::identify($filepath);
        $objReader = PHPExcel_IOFactory::createReader($type);

        $objPHPExcel = $objReader->load($filepath);

        $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
        foreach($rowIterator as $row){
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cell) {
                $data[$row->getRowIndex()][$cell->getColumn()] = $cell->getCalculatedValue();
            }
        }

    }
    public function testurl(){

        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {
            $country = getCountryFromIP($ip);
        } else {
            $country = 'Invalid';
        }

        if (strtoupper($country) == 'CN') {
            echo  'yes';
        }else if (strtoupper(FXPP::html_url() == strtoupper('zh' ))){
            echo  'yes';

        }else{
            echo  'no';
        }
        echo FXPP::html_url();
    }

    public function removeBonustest(){
        $removeBonusArray = array(
            'Account_number'  => '291518',
            'UserId'          => '236538',
            'Amount'          => 5,
            'TransactionId'   => '1511245965',
            'TransactionType' => 'ITS Transfer'
        );

        $Transaction = new Transaction();
        $this->RemoveBonus($removeBonusArray);
    }

    public function RemoveBonus($BonusData){

        $accountNumber = $BonusData['Account_number'];
        $user_id = $BonusData['UserId'];

        $transaction_id = $BonusData['TransactionId'];
        $transaction_type = $BonusData['TransactionType'];

        echo "<pre>";
        print_r($BonusData);
        echo "<br>";

        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);

        $removeBonuses = $this->removeBonusesComment;
        $accountFunds = FXPP::getAccountFunds($accountNumber);

        print_r($accountFunds);
        foreach($getAccountBonusByType as $key => $bonuses){
            if(array_key_exists($key, $removeBonuses)){

                //check bonus to deduct based on withdraw amount
                if($key == 1){
                    $real_bonus_fund = round($accountFunds['withrawable_real_fund'] * 0.30,2);
                    if($real_bonus_fund < $accountFunds['bonus_fund']){
                        $bonuses = $accountFunds['bonus_fund'] - $real_bonus_fund;
                    }elseif($accountFunds['withrawable_real_fund'] <= 0){
                        $bonuses = $accountFunds['bonus_fund'];
                    }else{
                        $bonuses = 0;
                    }

                }elseif($key == 10){
                    $real_bonus_fund = round($accountFunds['withrawable_real_fund'] * 0.50,2);
                    if($real_bonus_fund <= $accountFunds['bonus_fund']){
                        $bonuses = $accountFunds['bonus_fund'] - $real_bonus_fund;
                    }elseif($accountFunds['withrawable_real_fund'] <= 0){
                        $bonuses = $accountFunds['bonus_fund'];
                    }else{
                        $bonuses = 0;
                    }
                }
                echo "<br>";
                echo "bonus";
                var_dump($bonuses);

                if($bonuses > 0){

                    $removeContestBonusParams = array(
                        'amount' => $bonuses,
                        'account_number' => $accountNumber,
                        'user_id' => $user_id,
                        'bonus_id' => $key,
                        'transaction_id' => $transaction_id,
                        'transaction_type' => $transaction_type,
                        'withrawable_real_fund' => $accountFunds['withrawable_real_fund'],
                        'bonus_fund' => $accountFunds['bonus_fund']
                    );

                    print_r($removeContestBonusParams);


//                    self::processRemovingBonus($removeContestBonusParams);

//                        if($key == 2){
//                            $realFundToRemove = 0.20 * $bonuses;
//                            $removeContestBonusParams['realFundToRemove'] = $realFundToRemove;
//                            self::Remove20PercentOfNDBInRF($removeContestBonusParams);
//                        }
//
                }
            }
        }

    }


    public  function getUserCountryCode()
    {

        echo  FXPP::getCountryByIP();
        echo "<br>".FXPP::getUserCountryCode();
    }

    public function getRefCommision($agent=262259){
        echo "<pre>";
        $webservice_config = array('server' => 'live_new');
        $WS_GT = new WebService($webservice_config);
        $arrayName = array(
            'iAgent' =>$agent,
            'from' => date('Y-m-d\T00:00:00', strtotime('2014-01-01')),
            'to' => date('Y-m-d\T23:59:59', time())
        );
        $WS_GT->GetAgentTotalCommissionGroupByAccount($arrayName);
        $commissionTotal = $WS_GT->get_all_result();
        if(!empty($commissionTotal['CommissionTotal'])){

            $ref_list = array();
            foreach($commissionTotal['CommissionTotal'] as $d){
                $ref_list[$d->FromAccount]= $d->TotalAmount;

            }
             print_r($ref_list);
        }
        return false;


    }

    public function testEUcountry(){
        $res = FXPP::isAccountFromEUCountry();
        var_dump($res);
    }

    public function testvalidation($account_number,$amount){
        $this->load->model('partners_model');
        $current_date = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
        $checkAmountTransferred = $this->partners_model->checkAmountTransferred($account_number,$current_date);
        $sum = $amount + $checkAmountTransferred['total_transferred'];


        if( $limit_setting = $this->general_model->whereCondition('withdrawal_limit_setting',array('account_number'=>$account_number),'*')){

            if($limit_setting['limit']<$amount){
                $returnData['message'] = 'Allowed amount to be transferred should be equal or less than '.$limit_setting['limit'].' USD within 24 hour(s).';
                return $returnData;
            }else{
                $limit_amount = $limit_setting['limit'];
            }
        }else{
            $limit_amount = 500;
        }

        var_dump($limit_amount);


        if ($sum > $limit_amount) {

            if ($this->session->userdata('user_id') == 60247) {
               $returnData['message'] = 'Sum of total amount transferred and current amount to be transferred has reached the allowable funds to be transferred within 24 hour(s) (Less than or equal to 500 USD). Your request will be sent to our administrator for approval.';
            } else {
                $returnData['message'] = 'Sum of total amount transferred and current amount to be transferred has reached the allowable funds to be transferred within 24 hour(s) (Less than or equal to 500 USD).';
            }

            echo  $returnData;
        }
        echo '<pre>';
        print_r($limit_setting);
    }


    public function getServerName(){
//        echo getServerURL();
        echo site_url();
    }


 public function testautoleverage(){
     $reg_lev = $this->g_m->showssingle2($table='mt_accounts_set',$field="user_id",$id=$_SESSION['user_id'],$select="registration_leverage,leverage",$order_by="");
     $r_l=intval(substr($reg_lev['registration_leverage'],2));  // remove "1:" from the leverage
     $l=intval(substr($reg_lev['leverage'],2));  // remove "1:" from the leverage
     //registered leverage
     switch (true) { // conditional switch to check by greater than , less than and = ;
         case $r_l < 1000:

             $call_return = false;
             break;
         default:
             $call_return = true;
             break;
     }

     var_dump($call_return);
     echo $r_l;

         echo '<pre>';
    print_r($reg_lev);
 }

 public function testEU(){
//     var_dump(IPLoc::isEuropeanCountry($this->session->userdata('country_code')));

     var_dump($this->session->userdata('country_code'));

     $user_id = 293404;
     $account_detail = $this->account_model->getAccountByUserId($user_id);
     $groupCurrency = $this->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
     echo '<br>';
     echo $groupCurrency;
 }


    public function checkfee()
    {
        $getTransactionFee = FXPP::getTransactionFee('SKRILL', 'USD');

        $amount_withdraw = 672.53;
        $totalFee = FXPP::roundno($amount_withdraw * $getTransactionFee['fee'], 2);

        $skrillSystemFee = $this->SkrillSystemFee2($amount_withdraw, 'USD');
        $totalFee = $totalFee + $skrillSystemFee;



        $totalFees = $totalFee + $getTransactionFee['addons'];

        $amount_deducted = FXPP::roundno($amount_withdraw + $totalFees, 2);

        $requestData = array(
            'addons'          => $getTransactionFee['addons'],
            'fee'             => $getTransactionFee['fee'],
            'amount_deducted' =>$amount_deducted,

        );

        print_r($requestData);


    }


    public function  balance_check(){

        $webservice_config = array(
            'server' => 'live_new'
        );
        $account_info = array(
            'iLogin' => 298049
        );
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountBalance($account_info);

        echo $WebService->get_result('Balance');

    }

    public function getTransactionsRecord($account_number){

        $transactionTypes = array(
            'BONUS_CONTEST_MF_PRIZE',
            'BONUS_CONTEST_PRIZE'

        );
        $contestBonus = array();

        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');

        $account_info = array(
            'iLogin' => $account_number,
            'from' => $from->format('Y-m-d\TH:i:s'),
            'to' => $to->format('Y-m-d\TH:i:s')
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);

        if($WebService->request_status === 'RET_OK'){
            $financeRecordEncode = json_encode($WebService->get_result('FinanceRecords'));
            $financeRecord = json_decode($financeRecordEncode, true);

            $operations = array_column($financeRecord['FinanceRecordData'], 'Operation');

            foreach($operations as $key => $o){

                if(in_array($o, $transactionTypes)){
                        if($financeRecord['FinanceRecordData'][$key]['Amount'] > 0) {
                        $contestBonus[] = $financeRecord['FinanceRecordData'][$key];
                    }
                }

            }

        }
        echo "<pre>";
        print_r($contestBonus);
    }

    public function testmethod($account_number)
    {
        $getAccountBonusAllBonus = FXPP::getAccountBonusByType($account_number);
        print_r($getAccountBonusAllBonus);

        $BonusTotalAmount = 0;
        foreach ($getAccountBonusAllBonus as $bkey) {
            $BonusTotalAmount = $BonusTotalAmount + $bkey;
        }

        echo $BonusTotalAmount;

    }



    public  function foot2(){
        $this->lang->load('FxMailer');
        $body = '<div style="background:url(https://www.forexmart.com/assets/images/footer-bg.png); width:800px; margin-top:2px; height: 218px;border-top: 3px solid #EAEAEA;">';
        $body .= '<div style="width: 620px; float: left;">';

        if(FXPP::isEUUrl()) {
            $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;"><span style="font-weight: 600; color: #FF0000;">' . lang('fxm_foot_01') . '</span>' . lang('fxm_foot_02') . '</span></p></div>';
        }else{
            $body .= '<div><p style="color: #5a5a5a;text-align: justify;font-size: 13px;">
                    <span style="font-weight: 600; color: #FF0000;">' . lang('new_fxm_foo_11') . ' </span> ' . lang('new_fxm_foo_12') . ' </span></p></div>';
        }

        if(FXPP::isEUUrl()) {
            $body .= '<div><p><span style="font-weight: 600;color:#2988ca;"> ' . lang('fxm_foot_03') . ' </span> ' . lang('fxm_foot_04') . ' <img height="12" width="130" style="margin-bottom: -1px;vertical-align: middle" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png">.</p></div>';
        }else{
            $body .= '<div><p>
                        <a href="https://www.forexmart.com"><span style="font-weight: 600;color:#2988ca;"> '. lang('new_fxm_foo_03') .' </span> </a> 
                         ' . lang('new_fxm_foo_04') . ' <span style="font-weight: bold;color:#000;">Tradomart SV Ltd</span> ' . lang('new_fxm_foo_05') .' 
                        <span style="font-weight: bold;color:#000;">Tradomart SV Ltd</span> '. lang('new_fxm_foo_06') .' <span style="font-weight: 600;color:#2988ca;">
                         '. lang('new_fxm_foo_01').'</span>. ' . lang('new_fxm_foo_07').'<span style="font-weight: 600;color:#2988ca;">'. lang('new_fxm_foo_01').'</span>
                         '. lang('new_fxm_foo_08') .'<span style="font-weight: bold; color: #000;">Instant Trading EU Ltd (CY)</span>'. lang('new_fxm_foo_09').'
                        <a href="https://www.forexmart.com/License">266/15</a>'.lang('new_fxm_foo_10').'<a href="https://www.forexmart.eu"><span style="font-weight: 600;color:#2988ca;">'. lang('new_fxm_foo_02').'</span></a>
                     </p></div>';
        }

           $body .= "<div><p><span style='font-weight: 600;color:#2988ca;'> " .lang('fxm_foot_06'). " </span>".lang('fxm_foot_07') ." </p></div>";

        if(FXPP::isEUUrl()) {
            $body .= '<p>&copy; '. '2015-'. date('Y') . ' <img style="margin-bottom: 3px;vertical-align: middle" height="12" width="130" src="https://www.forexmart.com/assets/images/tradomart/instant-trading-eu-ltd.png"></p>';
        }else{
            $body .= '<p>&copy; '. '2015-'. date('Y') . ' <span style="font-weight: bold; color: #000;">Tradomart SV Ltd</span></p>';
        }

        $body .= '</div>';
        $body .= '<div style="width: 180px;float: right;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/cysec.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '<img width="124" height="76" src="https://www.forexmart.com/assets/images/mifid.png" style="width: auto;margin: 20px auto;display: block;">';
        $body .= '</div>';
        $body .= '</div>';
        $body .= '</div></body></div>';
        echo $body;
    }


    public function sendfootermail()
    {

        $email_data = array(
            'full_name'         => 'jayhens',
            'email'             => 'jayhens.snow@gmail.com',
            'password'          => '',
            'account_number'    => '',
            'trader_password'   => '',
            'investor_password' => '',
            'phone_password'    => '',
        );

        $subject = lang('liv_acc_htm_00'); //"ForexMart MT4 Live Trading Account details";
        $config = array('mailtype' => 'html');
        $this->general_model->sendEmail('live-account-html2', $subject, $email_data['email'], $email_data, $config);
        //  $this->load->view('email/_email_footer_3');
    }


public function testaccountval($input_affiliate_code){
  // $res = IPLoc::Officetest2($ip);
    //$res = FXPP::isEUGroup($acc);
   //var_dump(FXPP::isEUGroup($acc)['is_eugroup']);
   //print_r($res);
//    if (FXPP::isEUGroup($acc)['is_eugroup']) {
//        echo 1;
//    }else{
//        echo 2;
//    }

//    var_dump($getCookieLogs);
//    echo '<br>';
//    var_dump($affiliate_code)

           $getCookieLogs = $this->input->cookie('forexmart_affiliate_logs');
        $affiliate_code = $this->input->cookie('forexmart_affiliate');
        var_dump($getCookieLogs);
    echo '<br>';
    var_dump($affiliate_code);
    echo '<br>';
        if (empty($getCookieLogs) and !empty($affiliate_code)) {
            $getCookieLogs = $affiliate_code;
        }
        if (empty($getCookieLogs)) {
            $affiliate_code = $input_affiliate_code;
        } else {
            $affiliate_code = '-' . $input_affiliate_code;
        }
        if (!empty($input_affiliate_code)) {  $getCookieLogs = $getCookieLogs . $affiliate_code;  }
    var_dump($getCookieLogs);

}


    public function test_code($follower){
    $master = 58021956;
        $this->load->model('copytrade_model');
        $data = $this->copytrade_model->IsMasterFollowerExist($master,$follower);
        var_dump($data);

//        $webservice_config = array('server' => 'minifcservice');
//            $WS_U = new WebService($webservice_config);
//            $account_copytrade_info = array(
//                'FollowerAccount' => $follower,
//                'Is_NDB_Account'  => FALSE,
//                'MasterTrader'    => $master,
//            );
//        var_dump( $account_copytrade_info);
//            $test = $WS_U->open_SubscribeToMasterAccount($account_copytrade_info);
//          echo $WS_U->request_status;
//            var_dump( $test);
    }


    function testcurl($method,$payee_data=null){

      //  $secret_key = "7i1v4cI3";
        $payee_data['frmt'] = 'json';
       // $payee_data['merchant_id'] = '1052';

            $payee_data['merchant_id'] = '1184';
            $secret_key = "Th5505Vm";

//        $merchant_data = array(
//            'frmt' => 'json',
//            'merchant_id' => '1052',
//        );

        ksort($payee_data);
        $req ='';
        $i = 1;
        foreach ($payee_data as $key => $value) {
            $value = urlencode(stripslashes($value));

            if($i==1){
                $req .= "$key=$value";
            }else{
                $req .= "&$key=$value";
            }
            $i = $i + 1;
        }

        $check =  strtoupper(hash_hmac('sha256', $req, $secret_key));
        $dataEncode = $req.'&checksum='.$check;
        $request_type = $method . '?';
        //$url= "https://test-admin.inpay.com/api/v2/" . $request_type;
        $url= "https://admin.inpay.com/api/v2/" . $request_type;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataEncode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $data_decode =  json_decode($result, true);
        curl_close($ch);
        return $data_decode;
    }


public function inpay()
{
    echo "<pre>";
 /*   $countries =  $this->testcurl('get_countries');
    $selectOption="";
    $user_country = "TW";
    foreach($countries['countries'] as $country_data){
        $selected = $user_country == $country_data['iso'] ? "selected":"";
        $selectOption = $selectOption . "<option ".$selected." value='".$country_data['iso']."'>".$country_data['name']."</option>";
    }*/

//    var_dump($selectOption);

   /* $getbanks =  $this->testcurl('get_banks');
    $banks = array();
    foreach($getbanks['banks'] as $banks_key => $banks_data){

        $banks[$banks_data['id']] = array(
            'bank_url'          => $banks_data['url'],
            'bank_address'      => $banks_data['bank_address'],
            'bank_name'         => $banks_data['name'],
            'bank_id'           => $banks_data['id'],
            'is_third_party'    => $banks_data['is_third_party'],
            'online_bank_url'   => $banks_data['online_bank_url'],
            'owner_address'     => $banks_data['owner_address'],
        );
        foreach($banks_data['inpay_bank_account'] as $acc_key => $acc_val){
            $banks[$banks_data['id']][$acc_key] = $acc_val;
        }
    }*/

    //create invoice
    $user_id = $this->session->userdata('user_id');
    $account_number = $this->session->userdata('account_number');
    $bank_id =  132;
    $profile = $this->general_model->showssingle($table = 'user_profiles', 'user_id', $user_id, 'full_name,street,zip,city,country');
    $order_id = time().uniqid(mt_rand());
    $total_amount = sprintf("%1.2f", (float) 2);
    $invoice_data = array(
        'amount' =>$total_amount,
        'bank_id' =>$bank_id,
        'buyer_email'=>$this->session->userdata('email'),
        'buyer_address' => $profile['street'] .', ' . $profile['zip'] . ' ' . $profile['city']. ' '. $profile['country'],
        'buyer_name'=>$profile['full_name'],
        'currency' => 'EUR',
        'order_id' => $order_id,
        'order_text' => 'Deposit Inpay [' . $account_number . ']',
    );

  // print_r($invoice_data) ;

        $invoice_info = array(
            'order_id'       => '201812200801151902C',
            'amount'         => '5.00', //23.45
            'currency'       => 'USD', // swift- Company's settlement currency at Inpay | SEPA - The currency in which Inpay should invoice the Merchant.
            'order_text'     => 'Deposit Inpay [58017758]',
            'transfer_currency' => 'MYR', //SWIFT - bank currency | SEPA -  EUR
            'country'       => 'MY', //country of the beneficiary
            'buyer_name'    => 'snow',
            'buyer_email'   => 'jayhens.snow@gmail.com',
            'to_country'    => 'MY', //The country of teh beneficiary bank account
            'to_bank_name'  => 'Maybank', //	beneficiary bank name
            'swift'         => 'MBBEMYKL', //SWIFT/BIC for beneficiary bank account
            'acc_number'    => '515120602903', //IBAN number of the beneficiary account
            'bank_address'  => 'Maybank Malaysia',
            'owner_name'    => 'Inpay Switzerland AG ', //Full, legal name of the beneficiary
            'owner_address' => 'Inpay Switzerland AG Bahnhofstrasse 106301 Zug  Switzerland',
            'merchant_id'   => '1052',
            'frmt'          => 'json',

    );
        $reference = array(
            'invoice_ref' => '4MLCVM5',
        );

//$getWithdraw=  $this->testcurl('withdraw',$invoice_info);
//$getWithdraw=  $this->testcurl('get_invoice_status',$reference);
  //  $getInvoice=  $this->testcurl('create_invoice',$invoice_data);

 /*$invoice_return_data = array();
  $getInvoice=  $this->testcurl('create_invoice',$invoice_data);

    foreach($getInvoice as $inv_key => $inv_data) {

        foreach ($getInvoice['invoice'] as $c_inv_key => $c_inv_data) {
         //   $invoice_return_data[$c_inv_data] = $c_inv_data;
           // $invoice_return_data['reference'] = $inv_data['reference'];
        }
    }*/

//$getbanks =  $this->testcurl('get_banks');

 // print_r($getWithdraw);

    $date = new DateTime();
    $order_number = $date->getTimestamp();
    $test = $this->session->userdata('user_id') . $order_number;
    echo $test;
    echo '<br>';
    $test2 = time() . $order_number;
    echo $test2;
    echo '<br>';
    $test3 = uniqid() . $order_number;
echo $test3;
}


public function inpay_test_transfer($ref,$amount)
{

    $passkey = md5("1052:7i1v4cI3");
    $reference = array(
        'invoice_ref' => $ref,
        'passkey'     => $passkey
    );
    $url = 'https://test-admin.inpay.com/test/create_transfer?amount='.$amount.'&invoice_ref='.$ref.'&passkey='.$passkey;

//Once again, we use file_get_contents to GET the URL in question.
    $contents = file_get_contents($url);

//If $contents is not a boolean FALSE value.
    if($contents !== false){
        //Print out the contents.
        var_dump($contents);
    }
}



    public function get_convert_amount($currency, $amount, $to_currency = 'USD')
    {
        if ($currency == $to_currency) {
            $conv_amount = $amount;
        } else {
            $converter_config = array(
                'server' => 'converter'
            );

            $WebService = new WebService($converter_config);
            $data = array(
                'Amount'          => $amount,
                'FromCurrency'    => $currency,
                'ToCurrency'      => $to_currency,
                'ServiceLogin'    => '505641',
                'ServicePassword' => '5fX#p8D^c89bQ'
            );

            $ConvertCurrency = $WebService->ConvertCurrency($data);
            $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
            //RET_GAP is for RUB and RUR
            if ($resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP') {
                $converted_amount = $resultConvertCurrency['ToAmount'];
                $conv_amount = $converted_amount;
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }

    public function alipay()
    {




        $merchant_account = 900895;
        $amount = 1000;
        $currency = 'CNY';
        $first_name  = 'Sam';
        $last_name = 'Wu';
        $address1  = 'Huanghou Road 162';
        $city = 'Hong Kong';
        $zip_code = '1000';
        $country = 'HK';
        $phone = '85212345678';
        $email  = 'sam@example.com';
        $merchant_order = '12345';
        $merchant_product_desc = 'Digital Product';
        $return_url = 'https://my.forexmart.com/deposit/alipay';
        $control = '21bf90e217f08b8361bf3d7c28144f94';
        settype($merchant_account, "string");
        settype($amount, "string");
       echo $concat = $merchant_account . $amount . $currency . $first_name . $last_name . $address1 . $city . $zip_code . $country . $phone . $email . $merchant_order . $merchant_product_desc . $return_url;
        $checksum = hash_hmac('SHA1',$concat,$control);
        $data['control'] = $checksum;
        echo '<br>';
        echo $checksum;

    }


    public function cup(){

        $cup_parameteres = array(
            'apiversion'=>3,
            'version'=>11,
            'merchant_account'=>900893,
            'merchant_order'=>time(),
            'merchant_product_desc'=>'Deposit',
            'first_name'=>'Johnny',
            'last_name'=>'kei',
            'address1'=>'address1',
            'city'=>'home city',
            'zip_code'=>1000,
            'country'=>'CN',
            'phone'=> '1 555 123 4567',
            'email'=> 'smsapipp@gmail.com',
            'amount'=> 100*100,
            'currency'=>'CNY',
            'bankcode'=>'LBT',
            'ipaddress'=>$this->input->ip_address(),
            'return_url'=>'https://my.forexmart.com/deposit/china_union_pay',
            'server_return_url'=>'https://my.forexmart.com/deposit/cup_status'
        );

        $control = $cup_parameteres['merchant_account'].$cup_parameteres['amount'].$cup_parameteres['currency'].$cup_parameteres['first_name'].$cup_parameteres['last_name'].$cup_parameteres['address1'].$cup_parameteres['city'].$cup_parameteres['zip_code'].$cup_parameteres['country'].$cup_parameteres['phone'].$cup_parameteres['email'].$cup_parameteres['merchant_order'].$cup_parameteres['merchant_product_desc'].$cup_parameteres['return_url'];

        $control = hash_hmac("sha1", $control , '9eda32be0dac79e9331f7bace30d084f');
        $cup_parameteres['control'] = $control;

        $data['cup_pra'] = $cup_parameteres;
        $data['url'] = "https://payment.cdc.alogateway.co/ChinaDebitCard";

        $this->load->view('deposits/cup_payment',$data);
    }

    public function  forexcopy_email(){
        $this->load->library('Fx_mailer');
        $email_data = array(
            'email' => 'jayhens.snow@gmail.com',
            'master_name' => 'FC Test',
            'f_account' => 10001,
        );
        Fx_mailer::forex_copy_trader_subscribe($email_data);
        Fx_mailer::forex_copy_trader_unsubscribe($email_data);
        Fx_mailer::forex_copy_follower_register($email_data);
        Fx_mailer::forex_copy_follower_subscribe($email_data);
        Fx_mailer::forex_copy_follower_unsubscribe($email_data);
        Fx_mailer::notify_subscribe_to_master($email_data);
        Fx_mailer::notify_unsubscribe_to_master($email_data);
    }







    public function testnum($ammount){
//        $date = new DateTime();
//        $order_number = $date->getTimestamp();
//
//        $randChars = FXPP::RandomizeCharacter(6);
//      echo   $order_id = $order_number.uniqid(2);

//        if($row = $this->account_model->isPartnerAcVerified(330146)){
//            var_dump($row);
//            if($row->type_of_partnership == 'cpa'){
//                if($row->cpa_accountstatus == 0) {
//                    echo 'Your Partner is not yet verified.';
//                }
//            }else {
//                if($row->accountstatus == 0) {
//                    echo 'Your Partner is not yet verified.';
//                }
//            }
//        }

        $currentUser = $this->session->userdata('user_id');
        $accData = FXPP::getAllACcount($currentUser);
        $currenccySet = $accData->currency;

        $accountType = FXPP::fmGroupType($accData->account_number);
        switch ($accountType) {
            case 'ForexMart Classic':
                $minAmount = 15;
                $minAmount = $this->get_convert_amount('USD', $minAmount, 'RUB');
                //$minAmount = ceil($convAmountRUB * 100) / 100;
                break;
            case 'ForexMart Pro':
                $minAmount = 200;
                $minAmount = $this->get_convert_amount('USD', $minAmount, 'RUB');
               // $minAmount = ceil($convAmountRUB * 100) / 100;
                break;
            case 'ForexMart Cents':
                $minAmount = 15;
                $minAmount = $this->get_convert_amount('USD', $minAmount, 'RUB');
               // $minAmount = ceil($convAmountRUB * 100) / 100;
                break;
            default:
                $minAmount = 100; //100 RUB
                break;

        }
        echo $minAmount;
        $stadartUSDAmount = $this->get_convert_amount('RUB', $minAmount, $currenccySet);

        $rubAmount = $this->get_convert_amount($currenccySet, $ammount, 'RUB');
        $rubAmount = str_replace(",", "", $rubAmount);
        $rubAmount = (float) $rubAmount;

        $cheCkAmount = floor($rubAmount * 100) / 100;

        if ($cheCkAmount >= $minAmount) {

            echo  $data['amountmgs'] = 'Success ' . $rubAmount . " ".$minAmount . $currenccySet;

        } else {
            $minAmount = ceil($stadartUSDAmount * 100) / 100;

          echo  $data['amountmgs'] = 'Minimum deposit is at least ' . $minAmount . " " . $currenccySet;


        }



    }

    public function  testcode(){
       // FXPP::GroupRestriction();
        $webservice_config = array(
            'server' => 'forexcopy'
        );

        $service_data = array(
            'ProjectName' => 'FC test project 1',
            'IsEu'         =>  false,
            'LangNotify'   =>  'en' ,
            'UserId'       =>  58023935 , // client
            'IsTrader'     =>  true, //(true for trader, false for follower)
            'conditions_values_1' =>   1,
            'conditions_values_2' =>   1,
            'conditions_values_3' =>   1,
            'conditions_values_4' =>   1,
            'conditions_values_10'  => 1
        );

        $account_info = array(
            'follower'     => 58023936,
            'trader'        => 58023929,
//            'copysettings'  => array(
//
//                '0' => array(
//                    'key' => 1,
//                    'values' => 1,
//                ),
//                '1' => array(
//                    'key' => 2,
//                    'values' => 0.01,
//                ),
//                '2' => array(
//                    'key' => 3,
//                    'values' => 0,
//                ),
//                '3' => array(
//                    'key' => 1,
//                    'values' => 1,
//                ),
//                '4' => array(
//                    'key' => 1,
//                    'values' => 1,
//                ),
//            )
        );

      //  print_r($service_data);
        $service_data = array(
            'login' => '58023929 ', // for trader only
        );

echo '<pre>';
        $WebService = new WebService($webservice_config);
   //$test = $WebService->open_RegisterForexCopy($service_data);
        $copytrade_info = array(
            'connection' => 13,
            'who'  => 0,
        );
        $toptraders = array();

     //   $service_data = array('login' => 58023929);
        $service_data = array('connection_id' => 8885);
//       $WebService->Open_GetUserType($service_data);
//       var_dump( $WebService->request_status);
        $follower_condition = array();
        $WebService->Open_GetFollowerCopySettings($service_data);
        if($WebService->request_status == 'RET_OK'){
           // $request_result = (array) $WebService->get_result('Details');
       $request_result1 = (array) $WebService->get_result('Result');
          //  var_dump($request_result1->Result);
         //var_dump($request_result1);

         foreach ($request_result1['KeyValueOfintstring'] as $condition_key => $condition_value){
             $follower_condition[] = array(
                 'c_key' => $condition_value->Key,
                 'c_value' =>$condition_value->Value,
             );
         }
          print_r($follower_condition);
//
//            $res = $request_result1['Result']->KeyValueOfintstring;
//      var_dump($res);
//      var_dump($res[0]->Key);
//      var_dump($res[0]->Value);
        }
  // $getResult = $WebService->Open_GetTopTraders();
   //$getResult = $WebService->Open_GetAccountFollower($service_data);
  // $getResult = $WebService->Open_GetAccountTrader($service_data);
 //  $test = $WebService->open_SubscribeToTrader($account_info);
     // $test = $WebService->Open_GetLanguageType();

//         $WebService->Open_GetTraderData($service_data);
//      $requestResult = json_encode($WebService->get_all_result());
//      var_dump($requestResult);
//        $traderDetails = json_decode($requestResult, true);
//        $request_result = (array) $WebService->get_result('AllUserDetails');
//        print_r($request_result);
//        echo $request_result['ProjectName'];
//        if ($WebService->request_status === 'RET_OK') {
//            $request_result = (array) $WebService->get_result('Result');
//            foreach($request_result['Monitoring'] as $obj){
//                $toptraders[] = array(
//                    'Balance' =>  $obj->Balance,
//                    'CurrentTrades' =>  $obj->CurrentTrades,
//                    'DailyEquity' =>  $obj->DailyEquity,
//                    'Equity' =>  $obj->Equity,
//                    'ProjectName' =>  $obj->ProjectName,
//                    'RegisteredDate' =>  $obj->RegisteredDate,
//                    'SimpleRating' => $obj->SimpleRating,
//                    'UserId' => $obj->UserId,
//                );
//
//            }
//        }
//     $request_result = (array) $WebService->get_all_result();
//         print_r($request_result);

      //  print_r($request_result['Connection']);

//        $followerList = array();
//
//        foreach($request_result['Connection'] as $obj){
//            $followerList[] = array(
//               'ConnectionId' =>  $obj->ConnectionId,
//               'Follower' =>  $obj->Follower,
//               'StatusId' =>  $obj->StatusId,
//               'StartBalance' =>  $obj->StartBalance,
//            );
//
//        }
//
//     print_r($toptraders);
//      echo  count($followerList);


 //echo $request_result['Connection']['ConnectionId'];
      //  echo $request_result['Connection']->ConnectionId;
       // echo $request_result['Connection'][0]->ConnectionId;
//        echo $WebService->request_status;
   //   print_r($traderDetails['Details']);
   //     echo $traderDetails['Details']['UserId'];
    // echo  $result = $request_result->Details->['UserId'];


    }

    public function change_pass(){
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
    }



    public function test_cookie($account_number){

        $apiInfo =  $this->getUserdetails2($account_number);
        if($apiInfo['Agent'] == 0){
            $agentNumber = null;
        }else{
            $agentFullName = $apiInfo['Name'];
            $agentNumber = $apiInfo['Agent'];
        }
        var_dump($agentFullName);

        var_dump($agentNumber);

//        $pid = $this->input->cookie('pid');
//        $lid = $this->input->cookie('lid');
//        $pid = $_GET['pid'];
//        $lid = $_GET['lid'];
//        var_dump($pid);
//
//        var_dump($lid);
//        $encrypt_key = '#w6ZaY;XEvxFkh}d';
//        $email = 'jayhens.snow@gmail.com';
//        $password = '212121';
//        $encrypt_fields = $email.':'.$password;
//       $emcrypt =  FXPP::encrypt_data($encrypt_fields,$encrypt_key);
//       var_dump($emcrypt);
//       $decypt =  FXPP::decrypt_data($emcrypt,$encrypt_key);
//        var_dump($decypt);
//        print_r (explode(":",$decypt));
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

    public function getUserByID(){
       $data = $this->account_model->getRowUserDetailsByUserID(210789);
    //   var_dump($data);
      var_dump($data->email);
       var_dump($data->phone1);
      var_dump($data->city);
       var_dump($data->full_name);
        $countryName=$this->general_model->getCountries($data->country);
       var_dump($countryName);


    }

    public function testinformation(){
     WebService::depositorInformation2(58029662 );
    }


    public function testSession(){
      
        $this->load->library('WebServiceNew');

        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebServiceNew($webservice_config);  
        $data = array( 'iLogin' => 192912 );
        $webService->request_account_details($data);     
        $ret = 8; //$webService->CreateSession();
        print_r($webService->proxy);
    }
    public function printData(){
//        $res = FXPP::updateAccountTradingStatus();
//        var_dump($res);

        $this->load->library('ZotaPay');
        $paymentRes =  $this->zotapay->OrderStatusRequest();
        var_dump($paymentRes); exit();

        $params = array(
            'merchantOrderID'     => 'myr6039201339d84',
            'merchantOrderDesc'   => 'Deposit ZotaPay [58045279]',
            'orderAmount'         =>  8105.00,
            'orderCurrency'       => 'MYR',
            'customerFirstName'   => 'Norhisham',
            'customerLastName'    => 'Bin',
            'customerAddress'     => 'No 19, Lorong 7 Taman Pauh',
            'customerCountryCode' => 'MY',
            'customerCity'        => 'Permatang Pauh',
            'customerState'       => '',
            'customerZipCode'     => '13500',
            'customerPhone'       => '+601156717705',
            'customerEmail'       => 'Norhishamsaid@yahoo.com',
            'customerIP'          => '78.46.190.237',

        );

        $paymentRes =  $this->zotapay->paymentRequest($params);

        var_dump($paymentRes);

    }


    public function emailCheck2(){
        $this->load->library('Fx_mailer');
       Fx_mailer::senderInternal('spam.fxpp@gmail.com',"test header", "message body");
       
    }

    public function testFXMailer(){

        $this->load->library('Fx_mailer');

        $data = array(
            "account_number" => 58050126,
            "time" => date('Y-m-d H:i:s'),
            "payment_type" => "Sample",
            "amount" => 10,
            "reason" => "Test"
        );

        $test2 = Fx_mailer::pending_deposit_with_issues($data);

        echo "<pre>",print_r($test2, 1),"</pre>";
    }
 
}




