<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_Bonus extends MY_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('general_model');
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $this->load->model('partners_model');
        if(!FXPP::has30DollarPermission()){
            redirect(FXPP::my_url('my-account'));
        }
    }

    public function index()
    {
        if ($this->session->userdata('logged')) {

                $data['userdata'] = $this->session->userdata();

                $data['title_page'] = 'Credit Bonus $30';
                $data['active_tab'] = 'credit-bonus-30';
                $this->template->title('Credit Bonus $30')
                    ->prepend_metadata("")
                    ->set_layout('internal/main')
                    ->build('credit_bonus', $data);

        } else {
            redirect('signout');
        }
    }

    public function CreditBonus30()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $user_data = $this->session->userdata();
            $affiliateAccount = trim($this->input->post('account_num'));

            if(FXPP::fmGroupType($affiliateAccount) != 'ForexMart Classic'){
                echo json_encode(array('success' => false, 'message' => 'This is exclusively for classic account types only.'));
            }else{
                //$affiliateData = $this->account_model->getAccountDetailsByAccountNumber($affiliateAccount);
                $affiliateData = $this->account_model->getAccountsByAccountNumber($affiliateAccount);

                $data = array(
                    'affiliate_user_id'        => $affiliateData['user_id'],
                    'affiliate_account_number' => $affiliateAccount,
                    'affiliate_currency'       => $affiliateData['mt_currency_base'],
                    'partner_account_number'   => $user_data['account_number'],
                    'partner_user_id'          => $user_data['user_id'],
                );

                if($affiliateData){
                    $validate = $this->validate($data);

                    if (!$validate['error']) {

                        $account_info = array(
                            'AccountNumber' => $affiliateAccount,
                            'Amount'        => 30,
                            'Comment'       => 'FOREXMART WELCOME BONUS $30',
                            'ProcessByIP'   => $this->input->ip_address()
                        );

                        //$bonusAmount = 30;
                        //$bonusComment = 'FOREXMART WELCOME BONUS $30';
                        $config = array('server' => 'live_new');
//                        $WebService = new WebService($config);
                        //$WebService->update_live_deposit_balance($affiliateAccount, $bonusAmount, $bonusComment);
//                        $WebService->open_Deposit_20PercentBonus($account_info);

//                        if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                           $webserviceResult =  FXPP::CreditBonus('BONUS_30_PERCENT', 30, 'FOREXMART WELCOME BONUS $30', $affiliateAccount);
                           $reqResult   = $webserviceResult['ErrorMessage'];
                           $bonusTicket = $webserviceResult['Data']->Ticket;
//                        }else{
//                            $WebService->open_Deposit_20PercentBonus($account_info);
//                            $reqResult   = $WebService->request_status;
//                            $bonusTicket = $WebService->get_result('Ticket');
//                        }

                        if ($reqResult === 'RET_OK') {
                            $ticket = $bonusTicket;

                            $date_bonus_before_acquired =  date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
                            $bonusArray = array(
                                'AmountBonus'     => 30,
                                'DateProcessed'   => $date_bonus_before_acquired,
                                'UserId'          => $affiliateData['user_id'],
                                'AccountNumber'   => $affiliateData['account_number'],
                                'TransactionPage' => 'BONUS_30_DOLLAR',
                                'Ticket'          => $ticket,
                                'BonusType'       => 'twpb',
                            );

                            $this->deposit_model->insertDepositBonus($bonusArray);

                            $UpdateData = array('thirtydollarbonus' => 1);
                            $this->account_model->UpdateThirtyDollarBonuse($affiliateData['user_id'], $UpdateData);

                            $WebServiceBalance = new WebService($config);
                            $WebServiceBalance->request_live_account_balance($affiliateAccount);
                            if ($WebServiceBalance->request_status === 'RET_OK') {
                                $balance = $WebServiceBalance->get_result('Balance');
                                $this->account_model->updateAccountBalance($affiliateAccount, $balance);
                            }


                            $message = 'Bonus has been successfully credited.';
                            echo json_encode(array('success' => true, 'message' => $message));

                        }else{
                            $message = 'Webservice failed. Please try again.';
                            echo json_encode(array('success' => false, 'message' => $message));
                        }
                    } else {
                        $message = $validate['errorMsg'];
                        echo json_encode(array('success' => false, 'message' => $message));
                    }
                }else{
                    echo json_encode(array('success' => false, 'message' => 'Invalid account.'));
                }

            }
        }
    }


    public function validate($data){

        $rtnData = array(
            'error'    => true,
            'errorMsg' => 'Invalid account.'
        );

        if(empty($data['affiliate_account_number'])){
            $rtnData['errorMsg'] = 'This input field must be required.';
            return $rtnData;
        }

//        if (empty($affiliateData)){
//            $rtnData['errorMsg'] = 'Invalid account.';
//            return $rtnData;
//        }

        $sub_partner = $this->partners_model->getCPAReferenceSub($data['partner_user_id']); // check if account is cpa
        if($sub_partner){
            $partnerID = $sub_partner['partner_id'];
            $partner = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');
        }else{
            $partnerID = $data['partner_user_id'];
            $partner = $this->general_model->showssingle('partnership', 'partner_id', $data['partner_user_id'], 'reference_num, type_of_partnership');
        }


        $partnerAccount = $partner['reference_num'];
        $referralInfo = $this->getUserdetails($data['affiliate_account_number']);
        if (($referralInfo['LogIn'] != '') || ($referralInfo['LogIn'] != 0)) { // check if account is active
            if ($referralInfo['Agent'] == $partnerAccount) {
                $checkdata = $this->general_model->showssingle2('users','id',$data['affiliate_user_id'],'accountstatus,thirtydollarbonus');
                $checkBonus = $this->general_model->showssingle3('deposit','user_id',$data['affiliate_user_id'],'twentypercentbonus',1,'twentypercentbonus');
                $current_date =  date('Y-m', strtotime(FXPP::getCurrentDateTime()));
                $checkLatestBonus = $this->general_model->getLatestCredit30($data['affiliate_account_number'], $current_date);

                $affiliateCodes = array_column($this->general_model->showt1w1arr('partnership_affiliate_code','partner_id',$partnerID,'affiliate_code'),'affiliate_code');
                $numCreditPerMonth = $this->general_model->getLatestCredit30PerMonth($affiliateCodes,$current_date);
                if($checkdata['accountstatus'] != 1) { // check if account is verified
                    $rtnData['errorMsg'] = 'Receiver account is not yet verified.';

                    return $rtnData;
                }else if($numCreditPerMonth > 20) {  // partner can only credit 20 bonuses to 20 clients per month
                        $rtnData['errorMsg'] = 'You can only credit 20 bonuses to 20 clients  per month.';
                        return $rtnData;

                }else if ($checkdata['thirtydollarbonus'] == 1) {
                    if($checkLatestBonus) { // partner can credit bonus once per month for each client
                        $rtnData['errorMsg'] = 'You can only credit 20 bonuses per month';
                        return $rtnData;
                    }
                }
//                }  else if ($checkBonus['twentypercentbonus'] == 1) { // check if account already received this bonus
//                    $rtnData['errorMsg'] =  'This account has already  been credited with this type of bonus.';
//                    return $rtnData;
//                }

                //get real fund balance
                $webservice_config = array('server' => 'live_new');
//                $WebServiceFunds = new WebService($webservice_config);
//                $WebServiceFunds->RequestAccountFunds($data['affiliate_account_number']);
//                $totalRealFund = $WebServiceFunds->get_result('TotalRealFund');

                if(IPLoc::APIUpgradeDevIP()){

                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService2 = $WSV->GetAccountFunds($data['affiliate_account_number']);

                    if($WebService2->request_status === "RET_OK"){
                        $totalRealFund  = $WebService2->result['TotalRealFund'];
                    }

                }else{

                    $WebService2= new WebService($webservice_config);
                    $WebService2->RequestAccountFunds($data['affiliate_account_number']);

                    $totalRealFund  = $WebService2->get_result('TotalRealFund');

                }

                $convRealFund = $this->amountConverter($totalRealFund, $data['affiliate_currency'],'USD');
                if ($convRealFund < 20) { // check if ral fund balance is more than $20
                    $rtnData['errorMsg'] =  'Account total real fund must be  more than or equals to $20';
                    return $rtnData;
                }

                $rtnData['error'] = false;
                return $rtnData;

            } else {
                $rtnData['errorMsg'] = 'Account is not a valid referral.';
                return $rtnData;
            }
        }else{
            $rtnData['errorMsg'] = 'Invalid Account number.';
            return $rtnData;
        }


    }

    public function getUserdetails_old($account_number){
        $webservice_config = array('server' => 'live_new');
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

    public function getUserdetails($account_number){ //FXPP-13646

        $newWebService = FXPP::GetAllAccountDetails($account_number);

        if ($newWebService['ErrorMessage'] === 'RET_OK') {
            $data = (array) $newWebService['Data'][0];
        } else {
            $data = false;
        }

        return $data;
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
        if($ConvertCurrency['SOAPError'] === true || $resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP'){
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        }else{
            $convertCurrencies = FXPP::ForexData($currencyFrom, $currencyTo);
            $convertedAmount = $amount*$convertCurrencies['Rate'];
        }

        return $convertedAmount;
    }

    public function test(){
        $partner_id = 345511;
        $affiliateCodes = array_column($this->general_model->showt1w1arr('partnership_affiliate_code','partner_id',$partner_id,'affiliate_code'),'affiliate_code');
        $res = $this->general_model->getLatestCredit30PerMonth($affiliateCodes,'2020-03');
        var_dump($res);
}


}






?>