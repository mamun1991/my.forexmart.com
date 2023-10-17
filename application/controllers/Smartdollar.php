<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Smartdollar extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('smart_model');
        $this->load->model('account_model');
        $this->load->library('Fx_mailer');
        

        $country= $this->session->userdata('country');

       

//        if(IPLoc::IPOnlyForTq()){
//        }else{
//        }

           /* if(in_array($country, FXPP::getSmartDollarCounty())){
                //show_404('maintenance_smart_dollar');
            }else{
                    
                show_404('accessing');
            }*/
            
            
            
         if(FXPP::getBonusListByAccount($_SESSION['account_number'], FXPP::smartDollarNotAccess()))
         {
             $_SESSION['smart_dollar_visit']=true;
             redirect(FXPP::my_url('my-account'));
         }

                 
            


        $this->load->library('FXAPI');        
        FXAPI::getInstance(SMART_DOLLAR);

    }


    protected $smartDollarNotAccess =  array('BONUS_NO_DEPOSIT','BONUS_CONTEST_PRIZE');
    
    protected $allowed_bonuses =  array(
          1 => 'BONUS 30%',
          28 => 'BONUS 20%',
          10 => 'BONUS 50%',
    );
    protected $smart_level =  array(
          1 => 'Regular',
          2 => 'Pro',
          3 => 'Expert',
          4 => 'VIP',
    );
    protected $smart_level_range =  array(
          1 => 0,
          2 => 100,
          3 => 200,
          4 => 300,
    );
    protected $smart_level_lot =  array(
          1 => 2,
          2 => 50,
          3 => 100,
          4 => 200,
    );
    protected $smart_level_pip =  array(
          1 => 0.05,
          2 => 0.06,
          3 => 0.08,
          4 => 0.1,
    );

    public function  index(){



        if(!$this->session->userdata('logged')){ redirect('signout'); }
        $this->input->set_cookie('smart_click', 1, time() + (3600 * 24), '.forexmart.com', '/', '', false);

        
        $user_id = $this->session->userdata('user_id');
        $data['test_field']=false; // just using testing purpose ...
        
        $data['active_tab'] = 'smartdollar';
        $data['active_sub_tab'] = '';
        $data['title_page'] = 'Smart Dollars';
        $js = $this->template->Js();
        $css = $this->template->Css();

        $account = $this->general_model->showssingle2('users','id',$user_id,'smart_dollar_status,smart_dollar_level');
        $data['acc_status'] = $account['smart_dollar_status'];
        $data['acc_level'] = $this->smart_level_range[$account['smart_dollar_level']];

        $acc_status = false;
        $ret = FXAPI::CheckIfRegistered(array());
        if($ret['RET'] == 'RET_OK'){
            $acc_status = $ret['data']->IsRegistered;
        }else if($ret['RET'] == 'RET_INVALID_SESSION'){
            redirect('signout');
        }
      
            

        if($acc_status) {
            $page = 'smart_dollar/smart_dollar_page2';
        }else{
            $page = 'smart_dollar/smart_dollar_page1';
        }

        

//        if(IPLoc::frz(true)){
//             $data['test_field']=true;
//              $page = 'smart_dollar/smart_dollar_page2';
//        }



        $user_profile = $this->general_model->showssingle2('user_profiles','user_id',$user_id,'image');
        $data['image'] = $user_profile['image'];
        $this->template->title('Smart Dollars')
            ->set_layout('internal/main')
            ->append_metadata_css("              
                  <link rel='stylesheet' href='".$css."smart_dollar_style.css'>
                ")
            ->build($page, $data);
        }


        private function getTotalLotsAPI(){
           $ret = FXAPI::GetCurrentSmartDollar(array());
           
           $lotsLeft = 2;
            $totalLots = 0;
            $enable = false;
           
           if($ret['RET'] == 'RET_OK'){
            $totalLots = $ret['data']->TotalLot;
            $lotsLeft -= $totalLots;
            if($lotsLeft <= 0){
                $lotsLeft = 0;
                $enable = true;
            }

           }

           $jsonData = array('total_traded_lots' => $totalLots,'lots_left' => $lotsLeft,'enable' => $enable);
           $this->output->set_content_type('application/json')->set_output(json_encode($jsonData));



        }


    public function getTotalLots(){
        if ($this->input->is_ajax_request()) {

            
                $this->getTotalLotsAPI();
        }
    }
    public function activateSmartDollar(){
        if ($this->input->is_ajax_request()) {
            $result = true;
            $user_id = $this->session->userdata('user_id');
            $update_data = array('smart_dollar_status' => 1,'smart_dollar_level' => 1);
            $this->general_model->update('users','id',$user_id,$update_data);
            $jsonData = array('success' => $result);
            $ret = FXAPI::RegisterToSmartDollar(array());
           
                $jsonData['api_data'] = $ret['RET'];
           
            $this->output->set_content_type('application/json')->set_output(json_encode($jsonData));
        }
    }

    private function getLevel($totalLots){
        $account_level = 1;
        if($totalLots >= 50 && $totalLots < 100) {
           
            $account_level = 2;
        }else if($totalLots >= 100 && $totalLots < 200) {
           
            $account_level = 3;
       }else if($totalLots >= 200){
            $account_level = 4;
       }

       return $account_level;
    }

    private function lotsx($level,$totalLots){
        switch($level){
            case 1:
                $lotsX = $totalLots - 50;
               
                break;
            case 2:
                $lotsX = $totalLots - 100;
               
                break;
            case 3:
                $lotsX = $totalLots - 200;
               
                break;

        }
        return number_format($lotsX,2);
    }

    private function getSmartInfoAPI(){
        $account  = $this->session->userdata('account_number');

        $totalLots = 0;
        $cashFund = 0;
        $jsonData = array(
            'success'  => false,
            'cashFund' => 0,
        );

        $ret = FXAPI::GetCurrentSmartDollar(array());
        if($ret['RET'] == 'RET_OK'){
            $totalLots = $ret['data']->TotalLot;
            $cashFund = $ret['data']->CurrentSmartDollar->SmartDollarAmount;
            $jsonData['success'] =true;
            $jsonData['LotsToTrade'] = $ret['data']->CurrentSmartDollar->LotsToTrade;

        }
            $jsonData['accountNumb'] = $account;
            $level = $this->getLevel( $totalLots);
            $lotsX = $this->lotsx($level,$totalLots);
            $jsonData['nextlevelPip'] = $this->smart_level_pip[($level+1)];
            $jsonData['nextLevel'] = $this->smart_level[($level+1)];
            $jsonData['lotsX'] = abs($lotsX);
            $jsonData['curlevel'] = $this->smart_level[$level];
            $jsonData['curlevelPip'] = $this->smart_level_pip[$level];
            $jsonData['totalLots'] = $totalLots;
            $jsonData['cashFund'] = $cashFund;
            

//
//            $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'PENDING'));
//            $jsonData['pending'] = $this->SMHistory(0,0,$ret['data']->SmartDollar->SmartDollarList)['htmlData'];
            $this->output->set_content_type('application/json')->set_output(json_encode($jsonData));

    }

    public function getSmartInfo(){
        if ($this->input->is_ajax_request()) {

           
                $this->getSmartInfoAPI();
           
        }
        }

    public function updateRemainingLots($totalSmartFund){
        $user_id = $this->session->userdata('user_id');
        $smartDetails = $this->smart_model->getSmartDollarDetailsByStatus(0, $user_id);
        if (count($smartDetails) > 0) {
            foreach ($smartDetails as $key => $value) {

                if ($totalSmartFund > 0) {
                    if ($totalSmartFund >= $value['lots_remaining']) {
                        $totalRemaining = 0;
                        $update_data = array('lots_remaining' => $totalRemaining);
                        $this->general_model->update('smartdollar_info', 'id', $value['id'], $update_data);
                        $totalSmartFund = $totalSmartFund - $value['lots_remaining'];
                    } else {
                        $totalRemaining = $value['lots_remaining'] - $totalSmartFund;
                        $update_data = array('lots_remaining' => $totalRemaining);
                        $totalSmartFund = $totalSmartFund - $totalSmartFund;
                        $this->general_model->update('smartdollar_info', 'id', $value['id'], $update_data);
                    }

                }
            }
        }
    }

    public  function getTableRecords(){

     

            $tab = $this->input->post('tab', true);
            $user_id = $this->session->userdata('user_id');
            $jsonData = array(
                'success'  => true,
            );
            $jsonData['htmlData'] = '';
            ////Status = ‘ALL’, ‘PENDING’, ‘EXPIRED’, ‘COMPLETED’
            if($tab == 2){
               

                $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'COMPLETED'));
                $jsonData['htmlDataComplete'] =   $this->SMHistory($tab,1,$ret['data']->SmartDollar->SmartDollarList)['htmlData'];
                $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'EXPIRED'));
                $jsonData['htmlDataCancel'] =   $this->SMHistory($tab,2,$ret['data']->SmartDollar->SmartDollarList)['htmlData'];
                $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'PENDING'));                
                $jsonData['htmlDataPending'] =   $this->SMHistory(0,0,$ret['data']->SmartDollar->SmartDollarList)['htmlData'];
            }elseif($tab == 1){
                $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'COMPLETED'));     
                $complete = $this->SMHistory($tab,1,$ret['data']->SmartDollar->SmartDollarList);   
                      
                $jsonData['htmlData'] =  $complete['htmlData'];
                $jsonData['total'] =  $complete['total'];
              
            }else{
                $ret = FXAPI::GetSmartDollarHistory(array('Limit'=>100,'Offset'=>0,'Status'=>'PENDING'));
                $jsonData['htmlData'] =   $this->SMHistory($tab,0,$ret['data']->SmartDollar->SmartDollarList)['htmlData'];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($jsonData));

           

       
    }

    private function  SMHistory($tab,$status,$smartDetails){
        $jsonData['htmlData'] = '';
        $total_sum = $total_lots = $total_remaining = 0;
      
        $num1 = 1;
        
        if(!is_array($smartDetails) && !empty($smartDetails)){
            $smartDetails = array($smartDetails);
        }
            foreach ($smartDetails as $key => $value) {              
                
                $btn = Date('d/m/Y',  $value->Expiration);
              if($value->Status == 'WITHDRAW'){                  
                    $btn = '<button  class="btn-withdraw_amt btn btn-success " style="margin:auto;font-size :14px;width:100%;background:#29a643" data-amount="'.$value->Amount.'" data-FromTicket="' . $value->FromTicket . '" data-ToTicket="' . $value->ToTicket . '">Withdraw now</button>';
                 }
              
                if($num1 % 2 == 0){
                    $class = 'tbl-first-row';
                }else{
                    $class = 'tbl-second-row';
                }
                $jsonData['htmlData'] .= '<tr class="tr_' . $value->ToTicket . ' ' . $class . '">';
//                $jsonData['htmlData'] .= '<td>' . Date('d/m/Y', $value->DateAdded) . '</td>';
                $jsonData['htmlData'] .= '<td>$' . number_format( $value->Amount,2). '</td>';
//                $jsonData['htmlData'] .= '<td>' . number_format($value->LotsToTrade,2). '</td>';
                if($tab == 1 || $tab == 2){
                    if($status == 1){
                        $jsonData['htmlData'] .= '<td>' .Date('d/m/Y',  $value->WithdrawnDate) . '</td>';
                    }else{
                        $jsonData['htmlData'] .= '<td>' .Date('d/m/Y',  $value->Expiration) . '</td>';
                    }
                    
                }else{
                    $jsonData['htmlData'] .= '<td>' . number_format( $value->RemainingLot,2) . '</td>';
                    $jsonData['htmlData'] .= '<td>' .$btn. '</td>';
                }
                $jsonData['htmlData'] .= '</tr>';
                $total_sum += $value->Amount;
                $total_lots += $value->LotsToTrade;
                $total_remaining += $value->RemainingLot;
                $num1 += 1;
            
            }


        
        if ($class == 'tbl-first-row'){
            $class = 'tbl-second-row';
        }else if ($class == 'tbl-second-row'){
            $class = 'tbl-first-row';
        }else{
            $class = 'tbl-first-row';
        }


       /* $jsonData['htmlData'] .= '<tr class="'. $class . '">';
        $jsonData['htmlData'] .= '<td>Total</td>';
        $jsonData['htmlData'] .= '<td>$' . $total_sum . '</td>';
        $jsonData['htmlData'] .= '<td>' . $total_lots . '</td>';
        if($tab == 1 || $tab == 2){
           // $jsonData['htmlData'] .= '<td>&nbsp;</td>';
        }else{
            $jsonData['htmlData'] .= '<td>' . $total_remaining . '</td>';
            $jsonData['htmlData'] .= '<td>&nbsp;</td>';
        }*/

        $jsonData['htmlData'] .= '</tr>';
        $jsonData['total'] = $total_sum;
        return $jsonData;
    }

    public function generateRecords($tab,$user_id){
        $jsonData['htmlData'] = '';
        $total_sum = $total_lots = $total_remaining = 0;
        $smartDetails = $this->smart_model->getSmartDollarDetailsByStatus($tab, $user_id);
        $num1 = 1;
        if (count($smartDetails) > 0) {
            foreach ($smartDetails as $key => $value) {
                if($num1 % 2 == 0){
                    $class = 'tbl-first-row';
                }else{
                    $class = 'tbl-second-row';
                }
                $jsonData['htmlData'] .= '<tr class="tr_' . $value['id'] . ' ' . $class . '">';
                $jsonData['htmlData'] .= '<td>' . Date('d/m/Y', strtotime($value['date_cashed'])) . '</td>';
                $jsonData['htmlData'] .= '<td>'.  $value['amount'] . '</td>';
                $jsonData['htmlData'] .= '<td>' . $value['lots_to_trade'] . '</td>';
                if($tab == 1 || $tab == 2){
                    $jsonData['htmlData'] .= '<td>' . $value['date_withdraw'] . '</td>';
                }else{
                    $jsonData['htmlData'] .= '<td>' . $value['lots_remaining'] . '</td>';
                    $jsonData['htmlData'] .= '<td> - </td>';
                }
                $jsonData['htmlData'] .= '</tr>';
                $total_sum += $value['amount'];
                $total_lots += $value['lots_to_trade'];
                $total_remaining += $value['lots_remaining'];
                $num1 += 1;
            }


        }
        if ($class == 'tbl-first-row'){
            $class = 'tbl-second-row';
        }else if ($class == 'tbl-second-row'){
            $class = 'tbl-first-row';
        }else{
            $class = 'tbl-first-row';
        }


        $jsonData['htmlData'] .= '<tr class="'. $class . '">';
        $jsonData['htmlData'] .= '<td>Total</td>';
        $jsonData['htmlData'] .= '<td>' . $total_sum . '</td>';
        $jsonData['htmlData'] .= '<td>' . $total_lots . '</td>';
        if($tab == 1 || $tab == 2){
            $jsonData['htmlData'] .= '<td>&nbsp;</td>';
        }else{
            $jsonData['htmlData'] .= '<td>' . $total_remaining . '</td>';
            $jsonData['htmlData'] .= '<td>&nbsp;</td>';
        }

        $jsonData['htmlData'] .= '</tr>';
        return $jsonData;
    }


    public function getExchangeRate($currency1,$currency2){
        $symbol1 = $currency1 . $currency2;
        $symbol2 = $currency2 . $currency1;
        if (strtoupper($currency1) == strtoupper($currency1)) {
            return 1.0;
        }
        $resSymbol = $this->getLastSymbolTimestamp(strtoupper($symbol1));
        if (!empty($resSymbol['Symbol'])) {
            $price = $resSymbol['Bid'];
        } else {
            $resSymbol = $this->getLastSymbolTimestamp(strtoupper($symbol2));
            $price = 1 / $resSymbol['Ask'];
        }
        $exchangeRate = FXPP::roundno($price, 4);

        return $exchangeRate;
    }

    public function getCostOfPip($price,$lot){
        //One pip = 0.0001
        //1 lot = 100 000
        //Pip Value = 1 pip * Exchange rate (secondary currency/ account currency) * lot size
        //Pip Value = 0.0001 * 0.6548 * 100000 = 6.548
        $pip = 0.0001;
        $lot = $lot * 100000;
        $pipValue = $pip * $price * $lot;
        $pipValueRound =  FXPP::roundno($pipValue,2);
        return  $pipValueRound;

    }

   /* public function getLastSymbolTimestamp($symbol) {
        $config = array('server' => 'charts');
        $data = array('symbol' => $symbol);

        $WebService = new WebService($config);
        $WebService->get_symbol_last_timestamp($data);
        $result = $WebService->result;
        return  $result;
    }*/

    public function getLastSymbolTimestamp($symbol) {
        // new qoutes api
        $config = array('server' => 'qoutes_ticks');
        $from = date('Y-m-d 23:00:00', strtotime('-1 day', strtotime(FXPP::getCurrentDateTime()))); // yesterday midnight server time
        $to =  date('Y-m-d H:i:s',strtotime(FXPP::getCurrentDateTime())); // current server time
        $data = array(
            'From'           => FXPP::unixTime($from),
            'Symbols'        => array($symbol),
            'TimeFrame'      => 0,
            'To'             => FXPP::unixTime($to),
        );


        $WebService = new WebService($config);
        $WebService->RequestLastQoutes($data);
        if ($WebService->request_status === 'RET_OK') {
            $result = (array) $WebService->get_result('Quotes');
        }

        $result = array(
            'Symbol' => $result['QuoteData'][0]->Symbol,
            'Bid' => $result['QuoteData'][0]->Bid,
            'Ask' => $result['QuoteData'][0]->Ask,
        );

        return  $result;
    }
    

    public function calculateTotalLots(){

            $data = array(
                'req' => array(
                    'Login' => $_SESSION['account_number'],
                    'Guid' => 'FAArKbfCwJfM73t5S6m3xH4',
                    'From' => FXPP::unixTime('2020-01-01 00:00:00'), //starting date
                    'To' => FXPP::unixTime(FXPP::getCurrentDateTime()),
                )

            );
            $encodedData = json_encode($data);
            $get_data = $this->RestRequest('http://78w.forexmart.com:8056/Service1.svc/GetProfitLoss', $encodedData);
            $response = json_decode($get_data, true);

          return $response;

    }

    function RestRequest($url, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $result = curl_exec($curl);
        if(!$result){
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

    private function processCashedAPI($amount){
        $user_id =  $this->session->userdata('user_id');
        $country = $this->general_model->showssingle('user_profiles', 'user_id', $user_id, 'country');
        $isSuccess = false;

      $ret =  FXAPI::RequestToCash(array());
      $isSuccess = $ret['RET'];

      if($ret['RET'] == 'RET_OK'){
        $isSuccess = true;
        $email_data = array(
            'email' => $_SESSION['email'],
        );

        $smart_data = array(
            'amount' => $ret['Amount'],
            'lots_to_trade' => $ret['LotsToTrade'],
            'client' => $_SESSION['full_name'],
        );

        if($country == 'ID'){
            Fx_mailer::forex_smartdollar_request_id($email_data, $smart_data);
        } else if($country == 'MY'){
            Fx_mailer::forex_smartdollar_request_my($email_data, $smart_data);
        } else {
            Fx_mailer::forex_smartdollar_request($email_data, $smart_data);
        }

        

    }



    $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess)));

    }

   
      private function processCashedAPI_test($amount){
        $user_id =  $this->session->userdata('user_id');
        $country = $this->general_model->showssingle('user_profiles', 'user_id', $user_id, 'country');
        $isSuccess = false;

//      $ret =  FXAPI::RequestToCash(array());
//      $isSuccess = $ret['RET'];
//
//      if($ret['RET'] == 'RET_OK'){
//        $isSuccess = true;
//        $email_data = array(
//            'email' => $_SESSION['email'],
//        );
//
//        $smart_data = array(
//            'amount' => $ret['Amount'],
//            'lots_to_trade' => $ret['LotsToTrade'],
//            'client' => $_SESSION['full_name'],
//        );
//
//        if($country == 'ID'){
//            Fx_mailer::forex_smartdollar_request_id($email_data, $smart_data);
//        } else if($country == 'MY'){
//            Fx_mailer::forex_smartdollar_request_my($email_data, $smart_data);
//        } else {
//            Fx_mailer::forex_smartdollar_request($email_data, $smart_data);
//        }
//
//        
//
//    }



    $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess)));

    }

    public function processCashed(){
        if ($this->input->is_ajax_request()) {
            if ($this->session->userdata('logged')) {

              
                    $amount = $this->input->post('amount', true);
                    
                     $this->processCashedAPI($amount);
                    
                    
//                    if(IPLoc::frz()){
//                         $this->processCashedAPI_test($amount);
//                    }else{
//                    $this->processCashedAPI($amount);
//                    }
                
            }
        }

    }


    public function processWithdrawAPI(){
        if ($this->session->userdata('logged')) {
            $FromTicket = $this->input->post('FromTicket', true);
            $ToTicket = $this->input->post('ToTicket', true);
            $ret =  FXAPI::RequestToWithdraw(array('FromTicket'=>$FromTicket,'ToTicket'=>$ToTicket));
            $isSuccess = false;
            
            if($ret['RET'] == 'RET_OK'){
                $isSuccess = true;
            }
            $msg = $ret['RET'];
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess,'msg'=>$msg)));
        }else{
            redirect('');
        }
    } 




    public  function processWithdraw(){
        if ($this->session->userdata('logged')) {
            $isSuccess = false;
            $amount = $this->input->post('amount', true);
            $id = $this->input->post('id', true);
            $config = array('server' => 'live_new');
//            $WebServiceSmart = new WebService($config);
            $account_number = $_SESSION['account_number'];

//            if(IPLoc::APIUpgradeDevIP()){
                $WebServiceNew = FXPP::DepositRealFund($account_number, $amount, 'FOREXMART_SMART_DOLLARS');
                $requestResult = $WebServiceNew['requestResult'];
                $ticket        = $WebServiceNew['ticket'];
//            }else{
//                $WebServiceSmart->update_live_deposit_balance($account_number, $amount, 'FOREXMART_SMART_DOLLARS');
//                $requestResult = $WebServiceSmart->request_status;
//                $ticket        = $WebServiceSmart->get_result('Ticket');
//            }

            if ($requestResult === 'RET_OK') {
                $mt_ticket = $ticket;
                $isSuccess = true;
                $update_data = array('status' => 1,'ticket' => $mt_ticket);
                $this->general_model->update('smartdollar_info','id',$id,$update_data);
                $WebServiceBalance = new WebService($config);
                $WebServiceBalance->request_live_account_balance($account_number);
                if ($WebServiceBalance->request_status === 'RET_OK') {
                    $balance = $WebServiceBalance->get_result('Balance');
                    $this->account_model->updateAccountBalance($account_number, $balance);
                    $bonusCreditData = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'amount' => $amount,
                        'comment' => 'FOREXMART_SMART_DOLLARS',
                        'ticket' => $ticket,
                        'date_processed' => FXPP::getCurrentDateTime()
                    );
                    $this->general_model->insertmy('credit_smart_dollars', $bonusCreditData);

                }
            }
          $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess)));
        }
    }


    public  function isRealFund($acc){
        $getAccountBonusByType = FXPP::getAccountBonusByType($acc);
      
        if(count($getAccountBonusByType) > 0){
            foreach($getAccountBonusByType as $key => $bonuses) {
                if (array_key_exists($key, $this->allowed_bonuses)) {
                    return true;
                }
            }
            return false;
        }
        return true;

    }


    public function testEmail(){
        $email_data = array(
            'email' => 'testgee@protonmail.com',
        );

        $user_id = $this->session->userdata('user_id');

//        $country = $this->general_model->showssingle('user_profiles', 'user_id', $user_id, 'country');
        $country = 'MY';

        $smart_data = array(
            'amount' => 0.07,
            'lots_to_trade' => 200,
//            'client' => $_SESSION['full_name'],
        );

        if($country == 'ID'){
            Fx_mailer::forex_smartdollar_request_id($email_data, $smart_data);
        } else if($country == 'MY'){
            Fx_mailer::forex_smartdollar_request_my($email_data, $smart_data);
        } else {
            Fx_mailer::forex_smartdollar_request($email_data, $smart_data);
        }

        $account_level = 2;
//
//        $smart_data = array(
//            'account_level' => $this->smart_level[2],
//            'account_level_pip' => $this->smart_level_pip[2],
//            'account_level_lot' => $this->smart_level_lot[2],
//            'amount' => 2.95,
//            'next_level_lot' => $this->smart_level_lot[$account_level + 1],
//            'client' => $_SESSION['full_name'],
//        );

//        if($country == 'ID'){
//            Fx_mailer::forex_smartdollar_loyal_id($email_data, $smart_data);
//        }else if($country == 'MY'){
//            Fx_mailer::forex_smartdollar_loyal_my($email_data, $smart_data);
//        } else {
//            Fx_mailer::forex_smartdollar_loyal($email_data, $smart_data);
//        }




    }




}



