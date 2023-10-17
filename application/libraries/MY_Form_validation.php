<?php
class MY_Form_validation extends CI_Form_validation
{
    public $CI;

    public function validate_account_id( $account_id ){
        $CI =& get_instance();
        $is_valid = Custom_library::validate_user_account_by_id( $account_id );
        if($is_valid){
            return true;
        }else{
            $this->set_message('validate_account_id', 'Invalid user account.');
            return false;
        }
    }

    public function validate_transaction($amount, $card_number){
        $this->CI =& get_instance();
    
        $this->CI->load->library('session');
        $this->CI->load->model('deposit_model');
    
       $userID = $this->CI->session->userdata('user_id');
       $month = date('m'); $year = date('Y');
       $dateFrom = $year . '-' . $month . '-'. '01 00:00:00';
       $dateTo = $year . '-' . $month . '-'. '31 23:59:59';

        $depositCount = $this->CI->deposit_model->getAccountDepositCount($userID,$card_number,$dateFrom,$dateTo);
       
       
        if($depositCount >= 4){
            $this->set_message('validate_transaction', 'You have reached the monthly deposit limit for this card. Please contact support department for further assistance.');
            return false;
        }
        
        return true;
      }

    public function verifyTFACode($code){
        $this->CI =& get_instance();

        $this->CI->load->library('GoogleAuthenticator');
        $this->set_message('verifyTFACode', 'Invalid code');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');

        $userID = $this->CI->session->userdata('user_id');
        $TFASettings = $this->CI->account_model->GetTFASettings($userID);
        $TFASecretKey = $TFASettings['SecretKey'];

        if(!$TFASettings || $TFASettings['isEnabled'] == 0){
            if( !$this->CI->session->userdata('TFASecret')){
                return false;
            }
            $TFASecretKey = $this->CI->session->userdata('TFASecret');
        }
        
        
            $validTFACode = $this->CI->googleauthenticator->verifyCodeV2($TFASecretKey, $code,25,30);
           
            if(!$validTFACode){
                //sleep(8);
               $validTFACode = $this->checkAgainVerifyTFACode($TFASecretKey, $code);
            }
            
            return ($validTFACode) ? true : false;

    }
    
    
    
        private function checkAgainVerifyTFACode($TFASecretKey,$code,$timeLen=25){
        
         $this->CI =& get_instance();
        $this->CI->load->library('GoogleAuthenticator');   
        
        $length=$timeLen+(4);          
              
        for ($i = $timeLen; $i <= ($length); $i++) {
                 $validTFACode = $this->CI->googleauthenticator->verifyCodeV2($TFASecretKey, $code,$i,30);
                 if($validTFACode)
                 {
                     return $validTFACode;                   
                 }
         }
         return false;
    }

    public function deposit_min_amount($amount, $currency) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');

        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {

            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $date_cnv = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));

        $minAmount = 1;

        $orig_minAmount = $minAmount;

        switch ($currency){
            case 'USD':
                $message = 'Minimum deposit amount is '. $minAmount . ' USD';
                break;
            default:

                $convertAmount = $this->get_convert_amount('USD', $minAmount, strtoupper($currency));
                $minAmount = $convertAmount;
                $message = "($orig_minAmount USD = $minAmount $currency based on $date_cnv conversion)".'<br>'." Minimum deposit is at least $minAmount $currency";
                break;
        }
        if ($amount == null) {
            $this->set_message('deposit_min_amount', 'The Amount field is required');
            return false;
        }


            $accountType = FXPP::fmGroupType($account['account_number']);
            $new_amt_validation = $this->new_type_amt_validation($amount, $currency);
            if($accountType){
                if($new_amt_validation['error']){
                    $this->set_message('deposit_min_amount', $new_amt_validation['errorMsg']);
                    return false;
                }
            }

            if((float) $amount < (float)$minAmount){
                $this->set_message('deposit_min_amount', $message);
                return false;
            }




        return true;



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
            if ($resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP') {
                $converted_amount = $resultConvertCurrency['ToAmount'];
                //$conv_amount = number_format($converted_amount, 2);
                $conv_amount = $converted_amount;
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }


    public function deposit_min_amount2($amount, $currency) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }

        $date_cnv = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
          $minAmount = 1;

        $orig_minAmount = $minAmount;

        switch ($currency){
            case 'USD':
                $message = 'Minimum deposit amount is '. $minAmount . ' USD';
                break;
            default:
                $convertAmount = $this->get_convert_amount('USD', $minAmount, strtoupper($currency));
                $minAmount = $convertAmount;
                $message = "($orig_minAmount USD = $minAmount $currency based on $date_cnv conversion)".'<br>'." Minimum deposit is at least $minAmount $currency";
                break;
        }
        if ($amount == null) {
            $this->set_message('deposit_min_amount2', 'The Amount field is required');
            return false;
        }

        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_min_amount2', $message);
            return false;
        }


            $accountType = FXPP::fmGroupType($account['account_number']);
            $new_amt_validation = $this->new_type_amt_validation($amount, $currency);
            if($accountType){
                if($new_amt_validation['error']){
                    $this->set_message('deposit_min_amount2', $new_amt_validation['errorMsg']);
                    return false;
                }
            }


    }



    public function deposit_min_amount_payco($amount, $currency) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }

        $date_cnv = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
        $minAmount = 2;

        $orig_minAmount = $minAmount;

        switch ($currency){
            case 'USD':
                $message = 'Minimum deposit amount is '. $minAmount . ' USD';
                break;
            default:
                $convertAmount = $this->get_convert_amount('USD', $minAmount, strtoupper($currency));
                $minAmount = $convertAmount;
                $message = "($orig_minAmount USD = $minAmount $currency based on $date_cnv conversion)".'<br>'." Minimum deposit is at least $minAmount $currency";
                break;
        }
        if ($amount == null) {
            $this->set_message('deposit_min_amount_payco', 'The Amount field is required');
            return false;
        }


        if((float) $amount < (float)$minAmount && $currency == 'USD'){
            $this->set_message('deposit_min_amount_payco', $message);
            return false;
        }


        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $currency);
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_min_amount_payco', $new_amt_validation['errorMsg']);
                return false;
            }
        }


    }


    public function non_usd_min_amt_validate($amount, $paymentCurrency) {

        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');

        $accountNumber = $this->CI->session->userdata('account_number');
        $accountType = $this->CI->session->userdata('mt_account_set_id');

        $accountInfo =  $this->CI->account_model->getAccountDetailsByAccountNumber($accountNumber);
        $accountCurrency = $accountInfo['currency'];

        $minAmountUSD = 0;
        switch ($accountType) {
            case '5'://classic
            case '7'://cents
                $minAmountUSD = 15; //usd
                break;
            case '6'://pro
                $minAmountUSD = 200; //usd
                break;
        }

       // if(IPLoc::IPOnlyForVenus()){

            if($minAmountUSD > 0) {

                $accountFund = FXPP::getAccountFunds($accountNumber);
                switch($paymentCurrency) {
                    case 'BRL':
                    case 'NGN':
                    case 'UGX':
                    case 'KES':
                    case 'GHS':
                        $requestAmount = ceil((FXPP::freeCurrencyConverter(strtoupper($paymentCurrency), $accountCurrency, $amount) * 100)) / 100;
                        $totalAccountBalance = $accountFund['realFund'] + $requestAmount; // account currency
                        $totalAccountBalanceUSD = ceil((FXPP::freeCurrencyConverter(strtoupper($accountCurrency), 'USD', $totalAccountBalance) * 100)) / 100;
                        $convertAmount = ceil((FXPP::freeCurrencyConverter('USD', strtoupper($paymentCurrency), $minAmountUSD) * 100)) / 100;
                        break;
                    default:
                        $requestAmount = ceil(($this->get_convert_amount(strtoupper($paymentCurrency), $amount, $accountCurrency) * 100)) / 100;
                        $totalAccountBalance = $accountFund['realFund'] + $requestAmount; // account currency
                        $totalAccountBalanceUSD = ceil(($this->get_convert_amount(strtoupper($accountCurrency), $totalAccountBalance, 'USD') * 100)) / 100;
                        $convertAmount = ceil(($this->get_convert_amount('USD', $minAmountUSD, strtoupper($paymentCurrency)) * 100)) / 100;
                        break;
                }

                switch ($paymentCurrency) {
                    case 'USD':
                        $messageTrading = 'Trading balance cannot be less than ' . $minAmountUSD . ' USD';
                        break;
                    default:
                        $messageTrading = 'Trading balance cannot be less than ' . $minAmountUSD . ' USD (' . $convertAmount . ' ' . $paymentCurrency . ')';
                        break;
                }


                $minAmountBalance = $amount; // in wallet currency





            }
            $maxAmount = 100000000;
            switch($paymentCurrency){ // payment currency
                case 'MXN':
                    $minAmount = 4;//mxn
                    break;
                case 'GHS':
                    $minAmount = 1;//ghs
                    break;
                case 'KES':
                    $minAmount = 10;//kes
                    break;
                case 'NGN':
                    $minAmount = 100;//ngn
                    break;
                case 'UGX':
                    $minAmount = 500;//ugx
                    break;
                case 'BRL':
                    $minAmount = 4;//brl
                    break;
                case 'IDR':
                    $minAmount = 50000; // IDR
                    $maxAmount = 200000000;
                    break;
                case 'MYR':
                    $minAmount = 10; // MYR
                    $maxAmount = 50000;
                    break;
                case 'VND':
                    $minAmount = 60000; // VND
                    $maxAmount = 300000000;
                    break;
                case 'THB':
                    $minAmount = 100; // THB
                    $maxAmount = 500000;
                    break;
                case 'CNY':
                    $minAmount = 100; //CNY
                    $maxAmount = 50000;
                    break;
            }

            if ((float) $totalAccountBalanceUSD < (float) $minAmountUSD) {
                $this->set_message('non_usd_min_amt_validate', $messageTrading);
                return false;

            }
            if($minAmountBalance < $minAmount){
                $message = 'Minimum deposit amount is '. $minAmount . ' '.$paymentCurrency;
                if((float) $amount < (float)$minAmount){
                    $this->set_message('non_usd_min_amt_validate', $message);
                    return false;
                }

            }







            if ((float) $amount > (float) $maxAmount) {
                $this->set_message('non_usd_min_amt_validate', 'Maximum deposit is  ' . $maxAmount . ' ' . $paymentCurrency);

                return false;
            }


            return true;

      /*  }else{
            if($minAmountUSD > 0){

                    $accountFund = FXPP::getAccountFunds($accountNumber);
                    $realBalance = $accountFund['realFund'] + $amount;
                    $deposit_amount = ceil(($this->get_convert_amount(strtoupper($accountCurrency), $realBalance, 'USD') * 100)) / 100;

                    $convertAmount = ceil(($this->get_convert_amount('USD',$minAmountUSD, strtoupper($paymentCurrency)) * 100)) / 100;
                    switch ($paymentCurrency){
                        case 'USD':
                            $message = 'Trading balance cannot be less than ' .$minAmountUSD .' USD';
                            break;
                        default:
                            $message =  'Trading balance cannot be less than '.$minAmountUSD. ' USD (' .$convertAmount. ' '  . $paymentCurrency .')';
                            break;
                    }
                    if((float) $deposit_amount < (float)$convertAmount){
                        $this->set_message('non_usd_min_amt_validate', $message);
                        return false;

                    }



            }else{

                switch($paymentCurrency){ // payment currency
                    case 'MXN':
                        $minAmount = 4;//mxn
                        break;
                    case 'GHS':
                        $minAmount = 1;//ghs
                        break;
                    case 'KES':
                        $minAmount = 10;//kes
                        break;
                    case 'NGN':
                        $minAmount = 100;//ngn
                        break;
                    case 'UGX':
                        $minAmount = 500;//ugx
                        break;
                    case 'BRL':
                        $minAmount = 4;//brl
                        break;
                    case 'IDR':
                        $minAmount = 50000; // IDR
                        break;
                    case 'MYR':
                        $minAmount = 10; // MYR
                        break;
                    case 'VND':
                        $minAmount = 60000; // VND
                        break;
                    case 'THB':
                        $minAmount = 100; // THB
                        break;
                    case 'CNY':
                        $minAmount = 100; //CNY
                        break;
                }

                $message = 'Minimum deposit amount is '. $minAmount . ' '.$paymentCurrency;
                if((float) $amount < (float)$minAmount){
                    $this->set_message('non_usd_min_amt_validate', $message);
                    return false;
                }


            }
        }*/





        return true;



    }
    public function non_usd_min_amt_validate_zp($amount, $payment) {
        $data = explode("-",$payment);
        $paymentCurrency = $data[0];
        $bank = $data[1];


        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');

        $accountNumber = $this->CI->session->userdata('account_number');
        $accountType = $this->CI->session->userdata('mt_account_set_id');

        $accountInfo =  $this->CI->account_model->getAccountDetailsByAccountNumber($accountNumber);
        $accountCurrency = $accountInfo['currency'];

        $minAmountUSD = 0;
        switch ($accountType) {
            case '5'://classic
            case '7'://cents
                $minAmountUSD = 15; //usd
                break;
            case '6'://pro
                $minAmountUSD = 200; //usd
                break;
        }

            if($minAmountUSD > 0) {

                $accountFund = FXPP::getAccountFunds($accountNumber);

                $requestAmount = ceil(($this->get_convert_amount(strtoupper($paymentCurrency), $amount, $accountCurrency) * 100)) / 100;
                $totalAccountBalance = $accountFund['realFund'] + $requestAmount; // account currency
                $totalAccountBalanceUSD = ceil(($this->get_convert_amount(strtoupper($accountCurrency), $totalAccountBalance, 'USD') * 100)) / 100;
                $convertAmount = ceil(($this->get_convert_amount('USD', $minAmountUSD, strtoupper($paymentCurrency)) * 100)) / 100;



                switch ($paymentCurrency) {
                    case 'USD':
                        $messageTrading = 'Trading balance cannot be less than ' . $minAmountUSD . ' USD';
                        break;
                    default:
                        $messageTrading = 'Trading balance cannot be less than ' . $minAmountUSD . ' USD (' . $convertAmount . ' ' . $paymentCurrency . ')';
                        break;
                }


                $minAmountBalance = $amount; // in wallet currency





            }
            $maxAmount = 100000000;
            switch($paymentCurrency){ // payment currency
                case 'USD':

                    if($bank == "NP"){
                        $minAmount = 1;
                        $maxAmount = 1000;
                    }else{
                        $minAmount = 10;
                        $maxAmount = 2000;
                    }
                 
                    break;
                case 'EUR':
                    $minAmount = 10;
                    $maxAmount = 1600;
                    break;
                case 'IDR':
                    $minAmount = FXPP::getZPMinimumDeposit('IDR',$bank); // IDR
                    $maxAmount = 200000000;
                    break;
                case 'MYR':
                    $minAmount = FXPP::getZPMinimumDeposit('MYR',$bank); // MYR
                    $maxAmount = 50000;
                    break;
                case 'VND':
                    $minAmount = FXPP::getZPMinimumDeposit('VND',$bank); // VND
                    $maxAmount = 300000000;
                    break;
                case 'THB':
                    $minAmount = FXPP::getZPMinimumDeposit('THB',$bank); // THB
                    $maxAmount = 500000;
                    break;
                case 'CNY':
                    $minAmount = 100; //CNY
                    $maxAmount = 50000;
                    break;
            }

            if ((float) $totalAccountBalanceUSD < (float) $minAmountUSD) {
                $this->set_message('non_usd_min_amt_validate_zp', $messageTrading);
                return false;

            }
            if($minAmountBalance < $minAmount){
                $message = 'Minimum deposit amount is '. $minAmount . ' '.$paymentCurrency;
                if((float) $amount < (float)$minAmount){
                    $this->set_message('non_usd_min_amt_validate_zp', $message);
                    return false;
                }

            }







            if ((float) $amount > (float) $maxAmount) {
                $this->set_message('non_usd_min_amt_validate_zp', 'Maximum deposit is  ' . $maxAmount . ' ' . $paymentCurrency);

                return false;
            }


            return true;



    }





    public function deposit_cup_amt_validation($amount) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }

        $maxAmount = 200000;

        $minAmount = 100; //CNY

        if ($amount == null) {
            $this->set_message('deposit_cup_amt_validation', 'The Amount field is required');
            return false;
        }


        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_cup_amt_validation', 'Minimum deposit is at least '.$minAmount.' CNY');
            return false;
        }
        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'cup');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_cup_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }

        if((float) $amount > (float)$maxAmount){
            $this->set_message('deposit_cup_amt_validation', 'Maximum deposit is  '.$maxAmount.' CNY');
            return false;
        }

        return true;
    }


    public function deposit_payoma_amt_validation($amount, $currency) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }
        if($currency == 'EUR'){
            $maxAmount = 7500;
        }
        if($currency == 'USD'){
            $maxAmount = 10000;
        }

        

        $minAmount = 1; //USD



        if($currency == 'RUB'){
            $maxAmount = 7500; 
            $minAmount = 50; //RUB
        }

        if ($amount == null) {
            $this->set_message('deposit_payoma_amt_validation', 'The Amount field is required');
            return false;
        }



        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'payoma');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_payoma_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }

        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_payoma_amt_validation', 'Minimum deposit is at least '.$minAmount.' USD');
            return false;
        }

        if((float) $amount > (float)$maxAmount){
            $this->set_message('deposit_payoma_amt_validation', 'Maximum deposit is  ' . $maxAmount . ' ' .$currency);
            return false;
        }

        return true;
    }

    public function deposit_myr_amt_validation($amount) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $minAmount = 10; // MYR



        if ($amount == null) {
            $this->set_message('deposit_myr_amt_validation', 'The Amount field is required');
            return false;
        }
        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_myr_amt_validation', 'Minimum deposit is at least '.$minAmount.' MYR');
            return false;
        }

        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'bank_myr');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_myr_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }



        return true;
    }

    public function deposit_thb_amt_validation($amount) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $minAmount = 100; // THB



        if ($amount == null) {
            $this->set_message('deposit_thb_amt_validation', 'The Amount field is required');
            return false;
        }
        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_thb_amt_validation', 'Minimum deposit is at least '.$minAmount.' THB');
            return false;
        }

        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'bank_thb');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_thb_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }



        return true;
    }

    public function deposit_idr_amt_validation($amount) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $minAmount = 50000; // IDR



        if ($amount == null) {
            $this->set_message('deposit_idr_amt_validation', 'The Amount field is required');
            return false;
        }
        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_idr_amt_validation', 'Minimum deposit is at least '.$minAmount.' IDR');
            return false;
        }

        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'bank_idr');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_idr_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }



        return true;
    }

    public function deposit_vnd_amt_validation($amount) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $minAmount = 100000; // VND
        $maxAmount = 1000000000; // VND



        if ($amount == null) {
            $this->set_message('deposit_vnd_amt_validation', 'The Amount field is required');
            return false;
        }
        if((float) $amount < (float)$minAmount){
            $this->set_message('deposit_vnd_amt_validation', 'Minimum deposit is at least '.$minAmount.' VND');
            return false;
        } else if((float) $amount > (float)$maxAmount){
            $this->set_message('deposit_vnd_amt_validation', 'Maximum deposit is '.$maxAmount.' VND');
            return false;
        }

        $ac_data = FXPP::getMTUserDetails($account['account_number']);
        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $ac_data['Currency'],'bank_vnd');
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_vnd_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }



        return true;
    }


    public function deposit_moneta_amt_validation($amount, $currency) {
        $this->CI =& get_instance();
        $this->CI->load->helper('language');
        $this->CI->lang->load('modal_message');
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');

        $userID = $this->CI->session->userdata('user_id');

        if ($this->CI->session->userdata('login_type') == 1) {

            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $minAmount = 100;

        switch ($currency){
            case 'RUB':
                $message = 'Minimum deposit amount is '. $minAmount . ' RUB';
                break;
            default:

                $convertAmount = $this->get_convert_amount('RUB', $minAmount, strtoupper($currency));
                $convertAmount = ceil($convertAmount * 100) / 100;
                $message = "Minimum deposit is at least $convertAmount $currency";
                break;
        }

        if ($amount == null) {
            $this->set_message('deposit_moneta_amt_validation', 'The Amount field is required');
            return false;
        }


        if((float) $amount < (float)$convertAmount){
            $this->set_message('deposit_moneta_amt_validation', $message);
            return false;
        }


        $accountType = FXPP::fmGroupType($account['account_number']);
        $new_amt_validation = $this->new_type_amt_validation($amount, $currency);
        if($accountType){
            if($new_amt_validation['error']){
                $this->set_message('deposit_moneta_amt_validation', $new_amt_validation['errorMsg']);
                return false;
            }
        }

        return true;

    }



    public function new_type_amt_validation($amount,$currency,$payment_type = null){
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->model('account_model');
        $userID = $this->CI->session->userdata('user_id');
        $date_cnv = date('Y-m-d', strtotime(FXPP::getCurrentDateTime()));
        $result = array(
            'errorMsg' => '',
            'error'    => false,
        );

        if ($this->CI->session->userdata('login_type') == 1) {
            $account = $this->CI->account_model->getAccountByPartnerId2($userID);
        } else {
            $account = $this->CI->account_model->getAccountByUserId($userID);
        }


        $accountFund = FXPP::getAccountFunds($account['account_number']);

        $real_balance = $accountFund['realFund'] + $amount;

        $accountType = FXPP::fmGroupType($account['account_number']);
        switch ($accountType) {
            case 'ForexMart Classic':
            case 'ForexMart Cents':
                $minAmountUSD = 15; //usd
                break;
            case 'ForexMart Pro':
                $minAmountUSD = 200; //usd
                break;
        }

        $deposit_amount = ceil(($this->get_convert_amount(strtoupper($currency), $real_balance, 'USD') * 100)) / 100;
        $convertAmount = ceil(($this->get_convert_amount(strtoupper($currency), $minAmountUSD, 'USD') * 100)) / 100;

        if($payment_type == 'bank_myr') {

            $minAmountUSD = ceil(($this->get_convert_amount($currency, $minAmountUSD, 'MYR') * 100)) / 100;
            $message = 'Minimum deposit amount is ' . $minAmountUSD . ' MYR';

        }else if($payment_type == 'bank_thb') {

            $minAmountUSD = ceil(($this->get_convert_amount($currency, $minAmountUSD, 'THB') * 100)) / 100;
            $message = 'Minimum deposit amount is ' . $minAmountUSD . ' THB';

        }else if($payment_type == 'bank_vnd') {

            $minAmountUSD = ceil(($this->get_convert_amount($currency, $minAmountUSD, 'VND') * 100)) / 100;
            $message = 'Minimum deposit amount is ' . $minAmountUSD . ' VND';

        }else if($payment_type == 'bank_idr') {

            $minAmountUSD = ceil(($this->get_convert_amount($currency, $minAmountUSD, 'IDR') * 100)) / 100;
            $message = 'Minimum deposit amount is ' . $minAmountUSD . ' IDR';

        } else if($payment_type == 'cup') {

            $minAmountUSD = ceil(($this->get_convert_amount($currency, $minAmountUSD, 'CNY') * 100)) / 100;
            $message = 'Minimum deposit amount is ' . $minAmountUSD  .' CNY';

            }else{
                switch ($currency){
                    case 'USD':
                        $message = 'Trading balance cannot be less than ' .$minAmountUSD .' USD';
                        break;
                    default:
                        $message =  'Trading balance cannot be less than '.$minAmountUSD. ' USD (' .$convertAmount. ' '  . $currency .')';
                        break;
                }
        }




        if((float) $deposit_amount < (float)$convertAmount){
            $result['errorMsg'] = $message;
            $result['error'] = true;
            return $result;
        }
        return $result;

    }


    public function chkNameValid($name){
        $this->CI =& get_instance();
        $this->CI->load->library('Cyrillic');
        if(strlen($name)>100)
        {
            $this->set_message('chkNameValid', 'The maximum character allowed 100.');
            return false;
        }else if(preg_match(Cyrillic::register_page(), $name))
        {
            $this->set_message('chkNameValid', 'Your name is not correct.');
            return false;
        }
        else if(strlen($name)<4)
        {
            $this->set_message('chkNameValid', 'Please use minimum of 4 characters for the name.');
            return false;
        }else{
            return true;
        }

    }

    public function chkAddressValid($address){
        $this->CI =& get_instance();
        $this->CI->load->library('Cyrillic');
        if(strlen($address)>90)
        { $this->form_validation->set_message('chkAddressValid', 'The maximum character allowed 90.');
            return false;
        }else if(preg_match(Cyrillic::register_page(), $address))
        {
            $this->set_message('chkAddressValid', 'Your address is not correct.');
            return false;
        }
        else if(strlen($address)<4)
        {
            $this->set_message('chkAddressValid', 'Please use minimum of 4 characters for the address.');
            return false;
        }else{
            return true;
        }

    }

    public function chkCityValid($city)
    {
        $this->CI =& get_instance();
        $this->CI->load->library('Cyrillic');
        if(strlen($city)>30)
        {
            $this->set_message('chkCityValid', 'The maximum character allowed 30.');
            return false;
        }else if(preg_match(Cyrillic::register_page(), $city))
        {
            $this->set_message('chkCityValid', 'Your city name is not correct.');
            return false;
        }
        else if(strlen($city)<4)
        {
            $this->set_message('chkCityValid', 'Please use minimum of 4 characters for the city name.');
            return false;
        }else{
            return true;
        }

    }

    public function chkStateValid($state)
    {
        $this->CI =& get_instance();
        $this->CI->load->library('Cyrillic');
        if(strlen($state)>30)
        {
            $this->set_message('chkStateValid', 'The maximum character allowed 30.');
            return false;
        }else if(preg_match(Cyrillic::register_page(), $state))
        {
            $this->set_message('chkStateValid', 'Your state name is not correct.');
            return false;
        }
        else if(strlen($state)<4)
        {
            $this->set_message('chkStateValid', 'Please use minimum of 4 characters for the state name.');
            return false;
        }else{
            return true;
        }

    }


    public function chkzip_codeValid($zip_code)
    {
        if(strlen($zip_code)>10)
        {
            $this->set_message('chkzip_codeValid', 'The maximum character allowed 10.');
            return false;
        }
        else if(strlen($zip_code)<2)
        {
            $this->set_message('chkzip_codeValid', 'Please use minimum of 2 characters for the zip code.');
            return false;
        }else{
            return true;
        }

    }


    public function chkTelephoneValid($telephone){
        if(!preg_match( "/^\+?[0-9]+$/", $telephone)){
            $this->set_message('chkTelephoneValid', 'Your telephone number is not correct. ');
            return false;
        }else if(strlen($telephone)>16) {
            $this->set_message('chkTelephoneValid', 'Your telephone number is not correct. Max 16 digit allow.');
            return false;
        } else if(strlen($telephone)<4) {
            $this->set_message('chkTelephoneValid', 'Your telephone number is not correct. Required Minimum 4 digit.');
            return false;
        }else{
            return true;
        }

    }


}