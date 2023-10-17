<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer extends MY_Controller {

    private $js;

    public function __construct(){
        parent::__construct();
        $this->load->model('account_model');
        $this->js    = $this->template->Js();
        $this->lang->load('transfer');
        $this->lang->load('modal_message');
        $this->load->library('Transaction');
        
        if(FXPP::prohibition(1))
        {
            redirect(base_url()); 
        }
        
    }

    public function validateProcess($validateData){

        $account_number_source = $validateData['account_number_source'];
        $account_number_receiver = $validateData['account_number_receiver'];
        $account_details_source = $validateData['account_details_source'];
        $account_details_receiver = $validateData['account_details_receiver'];

        $returnData = array(
            'error' => true
        );

        $getVerifiedStatus = $account_details_source['accountstatus'];

        if( $getVerifiedStatus != 1 ){
            $returnData['errorMsg'] = lang('m_trns_07') . $account_number_receiver . lang('m_trns_08');
            return $returnData;
        }

        if( $account_number_source == $account_number_receiver ){
            $returnData['errorMsg'] = lang('m_trns_06');
            return $returnData;
        }

        $validateArray = array(
            'email',
            'phone1',
            'full_name',
            'street',
            'city',
            'state',
            'country',
            'zip'
        );

        foreach ($validateArray as $r) {
            if($account_details_source[$r] == $account_details_receiver[$r]){
                $valid = true;
            }else{
                $valid = false;
                break;
            }
        }

        if(!$valid){

            if(IPLoc::Office()){
                $returnData['errorMsg'] = ' Details on both accounts must be the same (Email, Phone number, Name, Address)0.'.$valid;
            }else{
                $returnData['errorMsg'] = lang('m_trns_09');
            }
            return $returnData;
        }

        $returnData = array(
            'error' => false
        );

        return $returnData;

    }

    public function is_currency($amount){
        $advance = "/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/";
        $simple = "/^\d+(\.\d{1,2})?$/";

        $validAmount = preg_match($simple, $amount);
        if($validAmount){
            return true;
        }else{
            $this->form_validation->set_message('is_currency', lang('m_trns_10'));
            return false;
        }
    }

    private function get_convert_amount($currency, $amount, $to_currency = 'USD') {
        if ($currency == $to_currency) {
            $conv_amount = $amount;
        } else {
            $converter_config = array(
                'server' => 'converter'
            );

            $WebService = new WebService($converter_config);
            $data = array(
                'Amount' => $amount,
                'FromCurrency' => $currency,
                'ToCurrency' => $to_currency,
                'ServiceLogin' => '505641',
                'ServicePassword' => '5fX#p8D^c89bQ'
            );

            $ConvertCurrency = $WebService->ConvertCurrency($data);
            $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
            if ($resultConvertCurrency['Status'] === 'RET_OK') {
                $converted_amount = $resultConvertCurrency['ToAmount'];
                $conv_amount = number_format($converted_amount, 2);
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }

    public function index(){
 

//            if(IPLoc::Office_and_Vpn_Trading()) {
//
//            }else{
//                redirect(FXPP::my_url('my-account'));
//            }

//             if(!IPLoc::Office_and_Vpn_Trading()) {
//                 redirect('signout');
//             }

             if(!$this->session->userdata('logged')){
                 redirect('signout'); // isolate checking of login session if not logged signout the visitor.
             }


            if (IPLOC::Office_and_Vpn()){

            }else{
                $usrs = $this->general_model->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='nodepositbonus');
                if($usrs){
                    if($usrs['nodepositbonus']=='1'){
                        redirect(FXPP::my_url('my-account'));
                    }
                }
            }

            $data['blocked_account']=false;
            if(isset($_SESSION['account_number'])){
                $blocked_accounts = array(
//                    '140093',
                    '1001617',
                    '114425',
                    '143609',
                    '155575',
                    '172613',
                    '198067',
                    '222994');
                if (in_array($_SESSION['account_number'], $blocked_accounts)) {
                    $data['blocked_account']=true;
                }else{
                    $data['blocked_account']=false;
                }
            }


             $showModalOnLoad = false;
             $modalMessage = ' ';
             $process_state = true;
             $user_id = $this->session->userdata('user_id');

             if($this->session->userdata('login_type') == 1){
                 /*Partner account*/
                 $prtnrshp = $this->general_model->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num');
                 $account_number_source = $prtnrshp['reference_num'];

             }else{
                 /*Live account*/
                 $account_detail = $this->account_model->getAccountByUserId($user_id);
                 $account_number_source = $account_detail['account_number'];
             }

             /*Form submit validation*/
             $this->form_validation->set_rules('amount', 'Amount', 'required|callback_is_currency'); /*Notice callback functions callback_validateFundsAccounts and callback_is_currency are user defined*/
             $this->form_validation->set_rules('account_receiver', 'Transfer to', 'required');

             if($this->form_validation->run() == true) {

                 /*form submit is true*/
                 $amount = $this->input->post('amount',true);    /*implement XSS by adding true in input post*/
                 $postAmount = $this->input->post('amount',true);    /*implement XSS by adding true in input post*/
                 $comment = $this->input->post('comment',true);
                 $account_number_receiver = $this->input->post('account_receiver',true);

                 $originalamount = $this->input->post('amount',true);
                 
                   $bonus_type = $this->input->post('bonus_type',true);
                 
                   
                   
                 /*Account number receiver details*/
                 $prtnrshp_rcvr = $this->general_model->showssingle2($table='partnership',$field='reference_num',$id=$account_number_receiver,$select='partner_id');
                 if($prtnrshp_rcvr){
                     $getDetailsByAccountNumberReceiver = $this->account_model->getUserDetailsByAccountNumber_partner($account_number_receiver);
                     $getDetailsByAccountNumberReceiver['transfer_account_type']='partner';
                 }else{
                     $getDetailsByAccountNumberReceiver = $this->account_model->getUserDetailsByAccountNumber($account_number_receiver);
                     $getDetailsByAccountNumberReceiver['transfer_account_type']='client';
                 }


                 /*Account number source details*/
                 if($this->session->userdata('login_type') == 1){
                     $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber_partner($account_number_source);
                     $getDetailsByAccountNumberSource['transfer_account_type']='partner';
                 }else{
                     $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number_source);
                     $getDetailsByAccountNumberSource['transfer_account_type']='client';
                 }


                 /*validate and compare source and destination accounts*/
                 $validateData = array(
                     'account_number_source' => $account_number_source,
                     'account_number_receiver' => $account_number_receiver,

                     'account_details_source' => $getDetailsByAccountNumberSource,
                     'account_details_receiver' => $getDetailsByAccountNumberReceiver
                 );


                 $validateProcess = $this->validate_transferaccounts($validateData);




                 /*validate and compare source and destination accounts*/



                 if(!$validateProcess['error']) {

                     /* check source and destination currency */
                     if ($getDetailsByAccountNumberSource['transfer_account_type'] == 'partner') {
                         $currency_source = $getDetailsByAccountNumberSource['currency'];
                     } else {
                         $currency_source = $getDetailsByAccountNumberSource['mt_currency_base'];
                     }
                     if ($getDetailsByAccountNumberReceiver['transfer_account_type'] == 'partner') {
                         $currency_receiver = $getDetailsByAccountNumberReceiver['currency'];
                     } else {
                         $currency_receiver = $getDetailsByAccountNumberReceiver['mt_currency_base'];
                     }
                     /* check source and destination currency */

                     /* currency conversion API */

                     $webservice_config = array(
                         'server' => 'converter'
                     );


                     $isMicroSource = $this->account_model->isMicro($getDetailsByAccountNumberSource['user_id']);
                     $isMicroReciever = $this->account_model->isMicro($getDetailsByAccountNumberReceiver['user_id']);
                     if ($isMicroSource && !$isMicroReciever) {//MICRO to STANDARD TRANSFER
                         $amount /= 100;
                     } else if (!$isMicroSource && $isMicroReciever) {//STANDARD TO MICRO TRANSFER
                         $amount *= 100;
                     }


                     $WebServiceA = new WebService($webservice_config);
                     $convertDetails = array(
                         'Amount' => $amount,
                         'FromCurrency' => $currency_source,
                         'ServiceLogin' => 505641, /*Authorized account number for currency conversion */
                         'ServicePassword' => '5fX#p8D^c89bQ',
                         'ToCurrency' => $currency_receiver
                     );

                     $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);

                     $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];

                     if ($ConvertCurrency['SOAPError'] === true || $resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP') {
                         $convertedAmount = $resultConvertCurrency['ToAmount'];
                     } else {
                         $convertCurrencies = FXPP::ForexData($currency_source, $currency_receiver);
                         $convertedAmount = $amount * $convertCurrencies['Rate'];
                     }

                     $amount = $originalamount;//BRING BACK TO ORIGINAL AMOUNT (IF TRANSFER IS BET MICRO & STANDARD vice versa)
                     $convertedAmount = round($convertedAmount, 4);

                     /* currency conversion API close */

                     # fund transfering API#

                     //  if(IPLoc::APIUpgradeDevIP()){
                     $service_data = array(
                         'Amount' => $postAmount,
                         'Login' => $account_number_source,
                         'Receiver' => $account_number_receiver,
                     );


                     $this->load->library('WSV');
                     $WebService = new WSV();
                     $requestResult = $WebService->SendMoney($service_data);
                     $sendData = $requestResult['Data'];
                     $requestStatus = $requestResult['ErrorMessage']; //status
                     $ticket = $sendData->Ticket; //ticket
                   

                     /*}else{
                         $service_data = array( // FXPP-9248
                             'Amount' => $amount,
                             'Comment' => 'OWN_MONEY_TO_'.$account_number_receiver,
                             'CommentReceiver' => 'OWN_MONEY_FROM_'.$account_number_source,
                             'Receiver' => $account_number_receiver,
                             'ConvertedAmount' => $convertedAmount,
                             'AccountNumber' => $account_number_source,
                             'ProcessByIP' => $this->input->ip_address()
                         );

                         $webservice_config = array(
                             'server' => 'live_new'
                         );

                         $WebService = new WebService($webservice_config);

                         $WebService->FundTransfer($service_data);
                         $requestStatus = $WebService->request_status; //status
                         $ticket = $WebService->ticket; //ticket
                         $NOT_ENOUGH_FUNDS = 'RET_INSUFFICIENT_FUNDS';
                     }*/

                     switch ($requestStatus) {
                         case 'RET_NOT_ENOUGH_FUND':
                         case 'RET_INSUFFICIENT_FUNDS':
                             $withdrawableFund = $sendData->Amount;

                             $modalMessage = 'Not enough fund, Remaining transferable fund: '. $withdrawableFund;
                             $showModalOnLoad = true;
                             break;
                         case 'RET_TRANSFER_BLOCKED':

                             $modalMessage = 'Fund transfer is blocked, Please try again after 5 seconds. Thank you';
                             $showModalOnLoad = true;

                             break;
                         case 'RET_OK':

                             $date_now = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                             $fundReceived = $sendData->Amount;
                             $transferArray = array(
                                 'Amount' => $amount,
                                 'Comment' => $comment,
                                 'ReceiverAccountNumber' => $account_number_receiver,
                                 'SourceAccountNumber' => $account_number_source,
                                 'ProcessByIP' => $this->input->ip_address(),
                                 'TransactionId' => $ticket,
                                 'AmountTransferred' => $fundReceived,
                                 'DateTranferred' => $date_now
                             );

                             $transactionId = $this->general_model->insert('transfer', $transferArray);


                             if ($getDetailsByAccountNumberReceiver['transfer_account_type'] == 'partner') {
                                 $reciever = $this->general_model->showssingle2($table = 'partnership', $field = 'reference_num', $id = $account_number_receiver, $select = 'partner_id');
                                 $reciever['user_id'] = $reciever['partner_id'];
                             } else {
                                 $reciever = $this->general_model->showssingle2($table = 'mt_accounts_set', $field = 'account_number', $id = $account_number_receiver, $select = 'user_id');
                             }


                             if ($getDetailsByAccountNumberSource['login_type'] != 1) { //check source if client
//                                 FXPP::updateAccountTradingStatus($account_number_source,$getDetailsByAccountNumberSource['user_id']); // for pro accounts

                                 if (IPLoc::APIUpgradeDevIP()) {
                                     FXPP::updateAccountTradingStatusV2($account_number_source, $getDetailsByAccountNumberSource['user_id']); // for pro accounts
                                 } else {
                                     FXPP::updateAccountTradingStatus($account_number_source, $getDetailsByAccountNumberSource['user_id']); // for pro accounts
                                 }

                             }

                             if ($getDetailsByAccountNumberReceiver['login_type'] != 1) { //check receiver if client
//                                 FXPP::updateAccountTradingStatus($account_number_receiver,$getDetailsByAccountNumberReceiver['user_id']); // for pro accounts

                                 if (IPLoc::APIUpgradeDevIP()) {
                                     FXPP::updateAccountTradingStatusV2($account_number_receiver, $getDetailsByAccountNumberReceiver['user_id']); // for pro accounts
                                 } else {
                                     FXPP::updateAccountTradingStatus($account_number_receiver, $getDetailsByAccountNumberReceiver['user_id']); // for pro accounts
                                 }

                             }


                             $date = new DateTime();
                             $reference_id = $date->getTimestamp();


                             $isMicroSource = $this->account_model->isMicro($getDetailsByAccountNumberSource['user_id']);
                             $isMicroReciever = $this->account_model->isMicro($getDetailsByAccountNumberReceiver['user_id']);
                             if ($isMicroSource && !$isMicroReciever) {//MICRO to STANDARD TRANSFER
                                 $amount /= 100;
                             } else if (!$isMicroSource && $isMicroReciever) {//STANDARD TO MICRO TRANSFER
                                 $amount *= 100;
                             }


                             $conv_amount = $this->get_convert_amount($currency_receiver, $amount);

                             ## Receiver Deposit Entry##
                             $depositArray = array(
                                 'transaction_id' => $transactionId,
                                 'reference_id' => $reference_id,
                                 'status' => 2,
                                 'amount' => $convertedAmount,
                                 'currency' => $currency_receiver,
                                 'user_id' => $reciever['user_id'],
                                 'payment_date' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                                 'transaction_type' => 'TRANSFER',
                                 'mt_ticket' => $WebService->ticket,
                                 'cpa_amount' => null,
                                 'cpa_conv_amount' => null,
                                 'conv_amount' => $conv_amount,
                                 'isDeposit' => 1
                             );
                             $this->load->model('deposit_model');
                             $last_deposit_id = $this->deposit_model->insertPayment($depositArray);
                             ## Receiver Deposit End##

                             $amount = $originalamount;//BRING BACK TO ORIGINAL AMOUNT (IF TRANSFER IS BET MICRO & STANDARD vice versa)
                             // $convertCurrencies = FXPP::ForexData($currency_source, $currency_receiver);
                             //$convertedAmount = $amount*$convertCurrencies['Rate'];
                             $convertedAmount = FXPP::getCurrencyRate($amount, $currency_source, $currency_receiver);


                             ### Remove Bonus From Source account number ###
                             /*$removeBonusArray = array(
                                 'Account_number' => $account_number_source,
                                 'UserId' => $user_id,
                                 'Amount' => $convertedAmount,
                                 'TransactionId' => $transactionId,
                                 'TransactionType' => 'Transfer'
                             );

                             $Transaction = new Transaction();
                             $Transaction->RemoveBonus($removeBonusArray);*/
                             ### Remove Bonus From Source account number ###

                             #### Update Source account number balance Start ####
//                             $WebService2 = new WebService($webservice_config);


//                             if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                            /* $WebService2 = FXPP::getAccountFunds($account_number_source);
                             $sourceRequest = $WebService2['status'];
                             $sourceBalance = $WebService2['balance'];*/

//                             }else{
//                                 $WebService2->request_live_account_balance($account_number_source);
//                                 $sourceRequest = $WebService2->request_status;
//                                 $sourceBalance = $WebService2->get_result('Balance');
//                             }

                            /* if ($sourceRequest === 'RET_OK') {

                                 $balance = $sourceBalance;
                                 if ($getDetailsByAccountNumberSource['transfer_account_type'] == 'partner') {

                                     $this->account_model->updateAccountBalance_partner($account_number_source, $balance);
                                 } else {

                                     $this->account_model->updateAccountBalance($account_number_source, $balance);
                                 }

                             }*/
                             #### Update Source account number balance End ####

                             ##### Update Destination account number balance Start #####
//                             $WebService3 = new WebService($webservice_config);

//                             if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                             $WebService3 = FXPP::getAccountFunds($account_number_source);
                             $receiverRequest = $WebService3['status'];
                             $receiverBalance = $WebService3['balance'];

//                             }else{
//                                 $WebService3->request_live_account_balance($account_number_receiver);
//                                 $receiverRequest = $WebService3->request_status;
//                                 $receiverBalance = $WebService3->get_result('Balance');
//                             }

                             if ($receiverRequest === 'RET_OK') {
                                 $balanceReceiver = $receiverBalance;

                                 if ($getDetailsByAccountNumberReceiver['transfer_account_type'] == 'partner') {

                                     $this->account_model->updateAccountBalance_partner($account_number_receiver, $balanceReceiver);
                                 } else {

                                     $this->account_model->updateAccountBalance($account_number_receiver, $balanceReceiver);
                                 }

                             }
                             ##### Update Destination account number balance End #####


                             //------------------------- First deposit bonus (20% or 30%) for client ------------------------------


                             if (IPLoc::frzPM()) {

                                 if ($bonus_type) {
                                     $depo_count = $this->deposit_model->getNumberOfDepositsByUser($getDetailsByAccountNumberReceiver['user_id']);


                                     if ($getDetailsByAccountNumberReceiver['transfer_account_type'] == "client") {
                                         if ($depo_count < 1 or $depo_count == "" or $depo_count == false) {

                                             if (FXPP::isAllowFirstDepositBonus($getDetailsByAccountNumberReceiver['user_id'])) {
                                                 $account_type_data = $this->general_model->getQueryStirngRow("mt_accounts_set", "*", array("account_number" => $account_number_receiver));

                                                 if ($account_type_data) {

                                                     $mt_set_id = $account_type_data->mt_account_set_id;
                                                     $conv_amount; // default usd amount [with if need micro]
                                                     $convertedAmount;// recever currency amoun [with if need micro]


                                                     $data_bonus = array(
                                                         FXPP::getBonusDataList($bonus_type) => 1
                                                     );


                                                     $depo_bonus_update = FXPP::DepositBonus($getDetailsByAccountNumberReceiver['user_id'], $account_number_receiver, $convertedAmount, 'ITS', $bonus_type, $transactionId);

                                                     if ($depo_bonus_update) {
                                                         $this->general_model->update("deposit", "id", $last_deposit_id, $data_bonus);
                                                     }

                                                 }
                                             }

                                         }

                                     }
                                 }

                             }


                             //------------------------- First deposit bonus (20% or 30%) end ------------------------------


                             $data['successData'] = $this->input->post();
                             $data['transactionId'] = $ticket;
                             $process_state = false;
                             $showModalOnLoad = false;
                             $modalMessage = ' ';



                     break;
                 }



                     $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));

                     if ($requestStatus != 'RET_OK') {

                         $apiLogs = array(
                             'Account_number' => $account_number_source,
                             'UserId' => $user_id,
                             'Amount' => $postAmount, //requested amount
                             'ApiStatus' => $requestStatus,
                             'Date' => $date,
                         );
                         $this->general_model->insert('withdraw_api_logs', $apiLogs);

                     }






                 }else{
                     $showModalOnLoad = true;
                     $modalMessage = $validateProcess['errorMsg'];
                 }
             }


             $data['login_type']=$this->session->userdata('login_type');
             $data['metadata_description'] = 'Provide the information needed to transfer funds between accounts.';
             $data['title_page'] = lang('sb_li_2');
             $data['active_tab'] = 'finance';
             $data['active_sub_tab'] = 'transfer';
             $data['process_state'] = $process_state;
             $js = "<script>".
                 "var showModal = '$showModalOnLoad',".
                 "modalMsg = '$modalMessage';".
                 "</script>".
                 "<script src='".$this->js."custom-transfer.js'></script>".
                 "<script src='".$this->js."bootbox.min.js'></script>";
             $data['metadata_description'] = lang('tra_dsc');
             $data['metadata_keyword'] = lang('tra_kew');
             $this->template->title(lang('tra_tit'))
                 ->append_metadata_js($js)
                 ->set_layout('internal/main')
                 ->prepend_metadata("")
                 ->build('transfer',$data);
     }

     

     
public function getAccountTypeBonusData(){

 if (!$this->input->is_ajax_request()) {die('Not authorized!');}

$account_number=$this->input->post('account_number',true); 

 

$acc_data = $this->general_model->showssingle('mt_accounts_set','account_number',$account_number);
//echo $this->db->last_query();exit;

$data=array(
        "status"=>false,
        "bonus"=>0,
        "specail_ten_bonus"=>0,
    );  



if($acc_data)
{    

    $mt_set_id=$acc_data['mt_account_set_id'];
    $bonus = 0;

   // echo "<pre>"; print_r($mt_set_id);exit;
    
    if(in_array($mt_set_id,array(5,7)))
    {
        $bonus = 20;

    }
    else if($mt_set_id == 2)
    {                                    
            $bonus = 30;
    }

    $speacail_ten_per_bonus=0;
    if(FXPP::isAllowFirstDepositBonus($acc_data['user_id']))
    {
       $speacail_ten_per_bonus =10; 
    }        

    $data=array(
        "status"=>true,
        "bonus"=>$bonus,
        "specail_ten_bonus"=>$speacail_ten_per_bonus,
    );    
} 
    
 $this->output->set_content_type('application/json')->set_output(json_encode($data));         

}     
     
     

    public function validateFundsAccounts($amountRequested){


     if ($this->session->userdata('login_type') == 1) {
         $prtnrshp = $this->general_model->showssingle2($table = 'partnership', $field = 'partner_id', $id = $_SESSION['user_id'], $select = 'reference_num,currency');
         $account_number = $prtnrshp['reference_num'];
     } else {
         $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
         $account_number = $getAccountnumber[0]['account_number'];
     }

     $mtUserDetails = FXPP::getMTUserDetails2($account_number);

     if ($mtUserDetails[0]->LogIn) {
         $fundData = FXPP::getAccountFunds($account_number);
         $getwithdrawablefund = $fundData['withrawableRealFund'];



         if($getwithdrawablefund < $amountRequested)
         {
             $modalMessage = lang('m_trns_14').$getwithdrawablefund.".";
             $this->form_validation->set_message('validateFundsAccounts', $modalMessage);
             return false;
         }

         $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);

         $copyTradeBonus =  array(
             27 => 'COPYTRADING BONUS',
         );

         foreach($getAccountBonusByType as $key => $bonusAmt) {
             if (array_key_exists($key, $copyTradeBonus)) {
                 $this->form_validation->set_message('validateFundsAccounts', 'To transfer copytrading bonus, you have to send a request to bonuses@forexmart.com');
                 return false;

             }
         }

         return true;

     }else{
         $this->form_validation->set_message('validateFundsAccounts', lang('m_trns_13'));
         return false;
     }
 }

     
    public function validateFundsAccountsOld($amountRequested){


        if($this->session->userdata('login_type') == 1){
            $prtnrshp = $this->general_model->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num,currency');
            $account_number=$prtnrshp['reference_num'];
        }else{
            $getAccountnumber = $this->account_model->getAccountsByUserId($this->session->userdata('user_id'));
            $account_number = $getAccountnumber[0]['account_number'];
        }

        $webservice_config = array('server' => 'live_new');

        $WebServiceAD = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number);
        $WebServiceAD->open_RequestAccountDetails($account_info);

//        if(IPLoc::APIUpgradeDevIP()){
//            $account = array(
//                'account_number' => [$account_number]
//            );
//            $WebServiceAD = $this->wsv->GetAccountDetails($account);
//            $result   = $WebServiceAD['ErrorMessage'];
//            $datefrom = date('Y-m-d\TH:i:s', $WebServiceAD['Data'][0]['RegDate']);
//        }else{
//            $WebServiceAD->open_RequestAccountDetails($account_info);
//            $result   = $WebServiceAD->request_status;
//            $datefrom = $WebServiceAD->get_result('RegDate');
//        }

        if ($WebServiceAD->request_status === 'RET_OK') {
//
            $datefrom = $WebServiceAD->get_result('RegDate');
//            $datefrom = $WebServiceAD['Data'][0]['RegDate'];

//            $WebService2 = new WebService($webservice_config);
//            $WebService2->RequestAccountFunds($account_number);
//            $getwithdrawablefund = $WebService2->get_result('Withrawable_RealFund');
//            $Withrawable_BonusFund = $WebService2->get_result('Withrawable_BonusFund');
//            /*Add*/
//            $TotalRealFund = $WebService2->get_result('TotalRealFund');
//            $equity = $WebService2->get_result('Equity');
//            $margin = $WebService2->get_result('Margin');
//            /*Add*/

            if(IPLoc::APIUpgradeDevIP()){

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService2 = $WSV->GetAccountFunds($account_number);

                if($WebService2->request_status === "RET_OK"){
                    $getwithdrawablefund   = $WebService2->result['Withrawable_RealFund'];
                    $Withrawable_BonusFund = $WebService2->result['Withrawable_BonusFund'];
                    $TotalRealFund         = $WebService2->result['TotalRealFund'];
                    $equity                = $WebService2->result['Equity'];
                    $margin                = $WebService2->result['Margin'];
                }

            }else{

                $WebService2= new WebService($webservice_config);
                $WebService2->RequestAccountFunds($account_number);

                $getwithdrawablefund   = $WebService2->get_result('Withrawable_RealFund');
                $Withrawable_BonusFund = $WebService2->get_result('Withrawable_BonusFund');
                $TotalRealFund         = $WebService2->get_result('TotalRealFund');
                $equity                = $WebService2->get_result('Equity');
                $margin                = $WebService2->get_result('Margin');

            }

            $WebServiceTime = new WebService($webservice_config);
            $WebServiceTime->open_GetServerTime();
            $serverTime = $WebServiceTime->get_all_result();

            $account_info2 = array(
                'iLogin' => $account_number,
                'from' => $datefrom,
                'to' => $serverTime
            );

            $WebServiceGTPfR = new WebService($webservice_config);
            $WebServiceGTPfR->open_GetAccountTotalProfitFromRange($account_info2);
            if ($WebServiceGTPfR->request_status === 'RET_OK') {
                $BonusProfitFull = $WebServiceGTPfR->get_result('TotalProfit');
            }else{
                $BonusProfitFull=0;
            }

            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $getTotalNoDepositBonus = $getAccountBonusByType[2];

            $getForumBonus = $getAccountBonusByType[18];  // forum bonus


            $copyTradeBonus =  array(
                27 => 'COPYTRADING BONUS',
            );

            foreach($getAccountBonusByType as $key => $bonusAmt) {
                if (array_key_exists($key, $copyTradeBonus)) {
                    $this->form_validation->set_message('validateFundsAccounts', 'To transfer copytrading bonus, you have to send a request to bonuses@forexmart.com');
                    return false;

                }
            }




/*---------------------------------------------------new validataion ----------------------------------------------*/

  $getAccountBonusAllBonus = FXPP::getAccountBonusByType($account_number);
    if($getAccountBonusAllBonus){ // if account has bonus
$BonusTotalAmount=0;
foreach($getAccountBonusAllBonus as $bkey){$BonusTotalAmount=$BonusTotalAmount+$bkey;}

if($amountRequested <= $getwithdrawablefund){

}else{

    if($Withrawable_BonusFund <=0 or  $Withrawable_BonusFund < $amountRequested) {
        $_SESSION['preventndbtransfer']=true;
        $this->form_validation->set_message('validateFundsAccounts', lang('m_wth_06'));
        return false;
    }
    if($BonusTotalAmount <=0 or  $BonusTotalAmount<$amountRequested) {
        $_SESSION['preventndbtransfer']=true;
        $this->form_validation->set_message('validateFundsAccounts', lang('m_wth_06'));
        return false;
    }

}
if($getwithdrawablefund<$amountRequested)
{
    //           $_SESSION['preventndbtransfer']=true;
    $modalMessage = lang('m_trns_14').$getwithdrawablefund.".";
    $this->form_validation->set_message('validateFundsAccounts', $modalMessage);
    return false;
}
if($amountRequested > $getwithdrawablefund){
    if($getTotalNoDepositBonus > 0 AND $TotalRealFund <= 0 ) {
        $_SESSION['preventndbtransfer']=true;
    }
    $modalMessage = lang('m_trns_14').$getwithdrawablefund.".";
    $this->form_validation->set_message('validateFundsAccounts', $modalMessage);

    return false;
}
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


            if($getTotalNoDepositBonus > 0){

                $withdrawBonusPercent = 0.20 * $getTotalNoDepositBonus;

                $withdrawableAmount = $getwithdrawablefund - $withdrawBonusPercent;

                if($withdrawableAmount <= 0){
                    $this->form_validation->set_message('validateFundsAccounts', lang('m_wth_06'));
                    return false;
                }

                if($this->session->userdata('login_type') == 1){
                    $getDetailsByAccountNumberSource['mt_currency_base']=$prtnrshp['currency'];
                }else{
                    $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number);
                }

                if( $withdrawableAmount < $amountRequested){
                    $errorMsg  = lang('m_trns_11') .$withdrawableAmount.' '.$getDetailsByAccountNumberSource['mt_currency_base'];
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);
                    return false;
                }

                if($amountRequested > $getTotalNoDepositBonus ){
                    $errorMsg  = lang('m_trns_12');
                    $this->form_validation->set_message('validateFundsAccounts', $errorMsg);
                    return false;
                }

            }
        }else{
            $this->form_validation->set_message('validateFundsAccounts', lang('m_trns_13'));
            return false;
        }

        return true;
    }

    public function validate_transferaccounts($validateData){
        /*magnes corporation of allowed accounts start*/
        $returnData = array(
            'error' => true
        );
        $allowed_accounts = array(
            /**/
            '900008',
            '900009',
            '900010',
            '900011',
            '900012',
            '900013',
            '900014',
            '900015',
            '900016',
            '900017',
            '900018',
            '900019',
            '227173',
            '198931',
            '195256',

//            '140093',
//            '231544',
            /*FXPP-7124*/
            '900021',
            '900022',
            '900023',
            '900024',
            '900025',
            '900026',
            '900027',
            '900028',
            '900029',
            '900030',
            '900031',
            '900032',
            '900033',
            '900034',
            '900035',
            '900036',
            '900037',
            '900038',
            '900039',
            '900040',
            '900041',
            '900042',
            '900043',
            '900044',
            '900045',
            '900046',
            '900047',
            '900048',
            '900049',
            '900050',
            '900051',
            '900052',
            '900053',
            '900054',
            '900055',
            '900056',
            '900057',
            '900058',
            '900059',
            '900060',
            '900061',
            '900062',
            '900063',
            '900064',
            '900065',
            '900066',
            '900067',
            '900068',
            '900069',
            '900070',
            '900071',
            '900072'
        );

        /*magnes corporation of allowed accounts end*/
        $source = false;
        if (in_array($validateData['account_number_source'],$allowed_accounts)){
            $source = true;
        }
        $reciever = false;
        if (in_array($validateData['account_number_receiver'],$allowed_accounts)){
            $reciever = true;
        }



        $webservice_config = array('server' => 'live_new');
        $account_info = array('iLogin' => $validateData['account_number_receiver']);





        $account_number_source = $validateData['account_number_source'];
        $account_number_receiver = $validateData['account_number_receiver'];
        $account_details_source = $validateData['account_details_source'];
        $account_details_receiver = $validateData['account_details_receiver'];
//        if(IPLoc::Office()){
//            echo "<pre>";
//            print_r($validateData); echo "<br>";
//            print_r($account_details_source); echo "<br>";
//            print_r($account_details_receiver); echo "<br>";
//        }



        $getVerifiedStatusSource = $account_details_source['accountstatus'];

       // if( $getVerifiedStatusSource != 1 ){
        if (!in_array($getVerifiedStatusSource, array('1','3'))) { //1 => verified level 2, 3 => verified level 1
            $returnData['errorMsg'] = lang('m_trns_15') . $account_number_source . lang('m_trns_16');
            return $returnData;
        }

        $getVerifiedStatusDestination = $account_details_receiver['accountstatus'];

        //if( $getVerifiedStatusDestination != 1 ){
        if (!in_array($getVerifiedStatusDestination, array('1','3'))) { //1 => verified level 2, 3 => verified level 1
            $returnData['errorMsg'] = lang('m_trns_17') . $account_number_receiver . lang('m_trns_18');
            return $returnData;
        }

        if( $account_number_source == $account_number_receiver ){
            $returnData['errorMsg'] = lang('m_trns_06');
            return $returnData;
        }

        /* Special Bypass FXPP-7124 */
        $madhen_corporation='maghnes corporation';
        if(strtolower($account_details_source['full_name'])==$madhen_corporation and strtolower($account_details_receiver['full_name'])==$madhen_corporation){
            $returnData = array(
                'error' => false
            );
            return $returnData;
        }
        /* Special Bypass FXPP-7124*/

        if ($source==true and $reciever==true){
            $valid = true;
            $returnData = array(
                'error' => false
            );

            return $returnData;
        }

        if ($account_details_source['transfer_account_type'] == 'client' AND $account_details_receiver['transfer_account_type']=='client'){

            $validateArray = array(
                'email',
                'phone1',
                'full_name',
                'street',
                'city',
                'state',
                'country',
                'zip'
            );

            foreach ($validateArray as $r) {
                if(strtolower($account_details_source[$r]) == strtolower($account_details_receiver[$r])){

                    $valid = true;
                }else{


                    $valid = false;
                    break;
                }
            }

            if(!$valid){
                $returnData['errorMsg'] = lang('m_trns_09');
                return $returnData;
            }

            $mtUserDetails = FXPP::getMTUserDetails2(array($_SESSION['account_number'],$validateData['account_number_receiver']));

            if($mtUserDetails[1]->LogIn) {
                if ($mtUserDetails[1]->IsDeleted  == 1) {
                    $returnData['errorMsg'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at support@forexmart.com if you want to restore the account.';
                    return $returnData;
                }
            }else{
                $returnData['errorMsg'] = lang('m_trns_09');
                return $returnData;
            }
        }

        if ($account_details_source['transfer_account_type'] == 'partner' OR $account_details_receiver['transfer_account_type']=='partner'){

            $validateArray = array(
                'email',
                'full_name',
            );

            foreach ($validateArray as $r) {
                if(strtolower($account_details_source[$r]) == strtolower($account_details_receiver[$r])){
                    $valid = true;
                }else{
                    $valid = false;
                    break;
                }
            }

            if(!$valid){
                $returnData['errorMsg'] = lang('m_trns_19');
                return $returnData;
            }

        }



        $returnData = array(
            'error' => false
        );

        return $returnData;

    }


    public function compare(){
        $account_number_source = 58016445;
        $account_number_receiver = 58027373 ;

        $prtnrshp_rcvr = $this->general_model->showssingle2($table='partnership',$field='reference_num',$id=$account_number_receiver,$select='partner_id');
        if($prtnrshp_rcvr){
            $getDetailsByAccountNumberReceiver = $this->account_model->getUserDetailsByAccountNumber_partner($account_number_receiver);
            $getDetailsByAccountNumberReceiver['transfer_account_type']='partner';
        }else{
            $getDetailsByAccountNumberReceiver = $this->account_model->getUserDetailsByAccountNumber($account_number_receiver);
            $getDetailsByAccountNumberReceiver['transfer_account_type']='client';
        }


        /*Account number source details*/
        if($this->session->userdata('login_type') == 1){
            $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber_partner($account_number_source);
            $getDetailsByAccountNumberSource['transfer_account_type']='partner';
        }else{
            $getDetailsByAccountNumberSource = $this->account_model->getUserDetailsByAccountNumber($account_number_source);
            $getDetailsByAccountNumberSource['transfer_account_type']='client';
        }

echo "<pre>";
        /*validate and compare source and destination accounts*/
        $validateData = array(
            'account_number_source' => $account_number_source,
            'account_number_receiver' => $account_number_receiver,

            'account_details_source' => $getDetailsByAccountNumberSource,
            'account_details_receiver' => $getDetailsByAccountNumberReceiver
        );


        $validateArray = array(
            'email',
            'phone1',
            'full_name',
            'street',
            'city',
            'state',
            'country',
            'zip'
        );

        foreach ($validateArray as $r) {
            if(strtolower($getDetailsByAccountNumberSource[$r]) == strtolower($getDetailsByAccountNumberReceiver[$r])){
                echo $getDetailsByAccountNumberSource[$r]; echo ' = ' ;  echo $getDetailsByAccountNumberReceiver[$r]; echo ' result = yes' ; echo '<br>';
            }else{
                echo $getDetailsByAccountNumberSource[$r]; echo ' = ' ;  echo $getDetailsByAccountNumberReceiver[$r]; echo ' result = no' ; echo '<br>';
                break;
            }
        }

       // $res =  $this->validate_transferaccounts($validateData);

        //var_dump($res);
    }

    public function testBonus($account_number){
        $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
        if($getAccountBonusByType){
            echo ' with bonus';
        }else{
            echo 'no bonus';
        }
    }

}