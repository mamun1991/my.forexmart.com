<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//http://136.243.89.90:9000/html/cee0502b-2e5e-9e06-d062-f7ed125dd4a5.htm

Class WebServiceNew {

    private $proxy;
    public $request_status;
    public $ticket;
    public $result = array();
    private $request_ip;
    protected $service_id = '10001';
    protected $service_password = 'Bj4mQBqP';
    protected $bitcoin_id = '50564781';
    protected $bitcoin_password = '#MHuc$@5AQ3g';

    protected $trading_id = '10002';
    protected $trading_password = 'PKpSq706';

    private $config_keys_allowed = array(
        'url', 'service_id', 'service_password'
    );

    protected $url;

    protected $server_url = array(
        'demo' => 'http://136.243.89.90:44388/MT4ApiService.svc?wsdl',
        'live' => 'http://136.243.89.90:44360/MT4ApiService.svc?wsdl',
//        'demo_new' => 'http://136.243.89.90:9060/MT4ApiService.svc?wsdl',
//        'live_new' => 'http://136.243.89.90:9050/MT4ApiService.svc?singleWsdl',
//        'converter' => 'http://136.243.89.90:9088/Converter.svc?singleWsdl'
        'demo_new' => 'https://78w.forexmart.com:9060/MT4ApiService.svc?wsdl',
        'live_new' => 'https://78w.forexmart.com:9050/MT4ApiService.svc?singleWsdl',
        'converter' => 'https://78w.forexmart.com:9088/Converter.svc?singleWsdl',
       // 'bitcoin' => 'http://188.40.124.145:8055/BitcoinPaymentService.svc?singleWsdl', //old
//        'bitcoin' => 'http://78.47.95.22:8055/BitcoinPaymentService.svc?singleWsdl',
        'bitcoin' => 'http://94.130.151.41:8055/BitcoinPaymentService.svc?singleWsdl',
        'trading' => 'https://78w.forexmart.com:9041/Trading.svc?wsdl', // support https://78w.forexmart.com:9042/html/9184f0f3-b615-656c-10f4-2e2eb11109d3.htm
        'pamm' => 'http://144.76.159.179:8810/PammService.svc?singleWsdl', //http://144.76.159.179:8850/html/92c3be91-5b50-430f-b1a3-8cd52fa6eb6d.htm
        'pamm_livefeeds' => 'http://144.76.159.179:1133/Monitoring.svc?singleWsdl',
        'minifcservice' => 'https://78w.forexmart.com:2895/MiniFCService.svc?wsdl',
        'forexcopy' => 'https://78w.forexmart.com:5885/Service.svc?singleWsdl',
         'g_session'=>'https://78w.forexmart.com:8044/GlobalSessionService.svc'   
    );

    
    function WebServiceNew($config = array())
    {
        $ci =& get_instance();
        $this->request_ip = $ci->input->ip_address();
        self::initialize($config);
    }
    

    /**
     * Initialize WebService with given $config
     */
    protected function initialize( $config ){
        try	{

            if( array_key_exists('server', $config) ){
                if( array_key_exists($config['server'], $this->server_url) )
                    $this->url = $this->server_url[$config['server']];
                else
                    $this->url = $this->server_url['demo_new'];
            }else{
                $this->url = $this->server_url['demo_new'];
            }

            if( array_key_exists('service_id', $config) ){
                $this->service_id = $config['service_id'];
            }

            if( array_key_exists('service_password', $config) ){
                $this->service_password = $config['service_password'];
            }

            $this->proxy = new SoapClient($this->url, array(
                'soap_version'=> SOAP_1_1,
                'exceptions' => true,
                'trace' => true,
                'features' => SOAP_SINGLE_ELEMENT_ARRAYS
            ));



            return true;
        }catch (SoapFault $e) {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetProxy',null)
            );
        }
    }

    /**
     * Open Demo Account Method
     * Request result are stored in WebService::result
     */
    public function open_account_demo( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'isStandard' => $account_info['standard'],
                'isStandardSpecified' => true,
                'strName' => $account_info['name'],
                'strEmail' => $account_info['email'],
                'strCurrency' => $account_info['currency'],
                'iLeverage' => $account_info['leverage'],
                'strPhonePassword' => ''
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenAccountDemo($merge_data);
            $this->request_status = $oAccountData->OpenAccountDemoResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->OpenAccountDemoResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountDetails',$eData)
            );
        }
    }

    /**
     * Open Demo Contest Account Method
     * Request result are stored in WebService::result
     */
    public function open_account_demo_contest( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'IsSwapFree' => $account_info['is_swap_on'],
                'IsSwapFreeSpecified' => true,
                'strName' => $account_info['name'],
                'strEmail' => $account_info['email'],
                'strCity' => $account_info['city'],
                'strCountry' => $account_info['country'],
                'strPhone' => $account_info['phone_number'],
                'strPhonePassword' => ''
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenAccountDemoContest($merge_data);
            $this->request_status = $oAccountData->OpenAccountDemoContestResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->OpenAccountDemoContestResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'OpenAccountDemoContest',$eData)
            );
        }
    }

    /**
     * Get Demo Account Details Method
     * Request result are stored in WebService::result
     */
    public function request_account_details( $data = array() ){
        $eData = array();
        try {
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountDetails($merge_data);
            $this->request_status = $oAccountData->RequestAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountDetails',$eData)
            );
        }
    }
    public function request_account_details1( $data = array() ){
        $eData = array();
        try {
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountDetails($merge_data);
            $this->request_status = $oAccountData->RequestAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountDetails',$eData)
            );
        }
    }

    /**
     * Open Live Standard Account Method
     * Request result are stored in WebService::result
     */
    public function open_account_live_standard( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'accountInfo' => array(
                    'Address' => $account_info['address'],
                    'City' => $account_info['city'],
                    'Country' => $account_info['country'],
                    'Currency' => $account_info['currency'],
                    'Email' => $account_info['email'],
                    'IsSwapFree' => $account_info['is_swap_on'],
                    'IsSwapFreeSpecified' => true,
                    'Leverage' => $account_info['leverage'],
                    'LeverageSpecified' => true,
                    'Name' => $account_info['name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => $account_info['state'],
                    'ZipCode' => $account_info['zip_code'],
                    'IsReadOnly' => true,
                    'IsReadOnlySpecified' => true,
                    'PhonePassword' => $account_info['phone_password']
                )
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenRealStandardAccount($merge_data);
            $this->request_status = $oAccountData->OpenRealStandardAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->OpenRealStandardAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'OpenRealStandardAccount',$eData)
            );
        }
    }

    /**
     * Open Live Zero Spread Account Method
     * Request result are stored in WebService::result
     */
    public function open_account_live_zero_spread( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'accountInfo' => array(
                    'Address' => $account_info['address'],
                    'City' => $account_info['city'],
                    'Country' => $account_info['country'],
                    'Currency' => $account_info['currency'],
                    'Email' => $account_info['email'],
                    'IsSwapFree' => $account_info['is_swap_on'],
                    'IsSwapFreeSpecified' => true,
                    'Leverage' => $account_info['leverage'],
                    'LeverageSpecified' => true,
                    'Name' => $account_info['name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => $account_info['state'],
                    'ZipCode' => $account_info['zip_code'],
                    'IsReadOnly' => true,
                    'IsReadOnlySpecified' => true,
                    'PhonePassword' => $account_info['phone_password']
                )
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenRealZeroSpreadAccount($merge_data);
            $this->request_status = $oAccountData->OpenRealZeroSpreadAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->OpenRealZeroSpreadAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'OpenRealZeroSpreadAccount',$eData)
            );
        }
    }

    /**
     * Open Affiliate Account Method
     * Partnership registrations
     * Request result are stored in WebService::result
     */
    public function open_account_affiliate( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'accountInfo' => array(
                    'Country' => $account_info['country'],
                    'Currency' => $account_info['currency'],
                    'Email' => $account_info['email'],
                    'FullName' => $account_info['name'],
                    'Phone' => $account_info['phone_number'],
                    'PhonePassword' => $account_info['phone_password']
                )
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenAffiliateAccount($merge_data);
            $this->request_status = $oAccountData->OpenAffiliateAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->OpenAffiliateAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'OpenAffiliateAccount',$eData)
            );
        }
    }

    /**
     * Update Account Deposit Balance Method
     * Request result are stored in WebService::result
     */
    public function update_demo_deposit_balance( $account_number, $amount = 0 ){
        $eData = array();
        try {
            $data = array(
                'financeInfo' => array(
                    'AccountNumber' => $account_number,
                    'AccountNumberSpecified' => true,
                    'Amount' => (float) $amount,
                    'AmountSpecified' => true,
                    'Comment' => '',
                    'ProcessByIP' => '',
                    'serviceId' =>  $this->service_id,
                    'serviceIdSpecified' =>  true,
                    'servicePassword' =>  $this->service_password

                )
            );
//            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->DemoDepositBalance($data);
            $this->request_status = $oAccountData->DemoDepositBalanceResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->DemoDepositBalanceResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'DemoDepositBalance',$eData)
            );
        }
    }

    /**
     * Update Live Account Deposit Balance Method
     * Request result are stored in WebService::result
     */
    public function update_live_deposit_balance( $account_number, $amount = 0, $comment = '' ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => (float) $amount,
                    'Comment' => $comment,
                    'FundTransferAccountReceiver' => 0,
                    'Login' => $account_number,
                    'ProcessByIP' => $this->request_ip,
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );
//            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->DepositRealFund($data);
            $this->request_status = $oAccountData->DepositRealFundResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->DepositRealFundResult);
            self::depositorInformation($account_number); // please do not delete functin cuase it's use for  Indonesian  and malysian deposit record
            return true;
        } catch (SoapFault $e)  {
            return array(
                true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'DepositRealFund',$eData)
            );
        }
    }


    /**
     * Update Account Withdraw Balance Method
     * Request result are stored in WebService::result
     */
    public function update_withdraw_balance( $account_number, $amount = 0 ){
        $eData = array();
        try {
            $data = array(
                'iAccountNumber' => $account_number,
                'iAccountNumberSpecified' => true,
                'dPrice' => (float) $amount,
                'dPriceSpecified' => true,
                'strComment' => ''
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->UpdateAccountBalanceWithdraw($merge_data);
            $this->request_status = $oAccountData->UpdateAccountBalanceWithdrawResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateAccountBalanceWithdrawResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountBalanceWithdraw',$eData)
            );
        }
    }

    /**
     * Get Demo Account Balance Method
     * this is currently used for contest winners
     * Request result are stored in WebService::result
     */
    public function request_demo_account_balance( $account_number ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_number,
                'iAccountNumberSpecified' => true
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountBalance($merge_data);
            $this->request_status = $oAccountData->RequestAccountBalanceResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountBalanceResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountBalanceWithdraw',$eData)
            );
        }
    }

    /**
     * Get Demo Account Balance Method
     * this is currently used for contest winners
     * Request result are stored in WebService::result
     */
    public function request_live_account_balance( $account_number ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_number
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountBalance($merge_data);
            $this->request_status = $oAccountData->RequestAccountBalanceResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountBalanceResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountBalanceWithdraw',$eData)
            );
        }
    }

    /**
     * Get WebService Request Result Method
     * Returns result value based on the given field
     */
    public function get_result( $field ){
        if( array_key_exists($field, $this->result) ) {
            return $this->result[$field];
        }else{
            return false;
        }
    }

    public function get_all_result(){
        return $this->result;
    }

    public function hello_world(){
        return 'hello world!';
    }

    /**
     * WebService Authentication for every request.
     * Credentials should be merge to the given data parameters for request
     */
    protected function set_service_auth( $data = array() ){
        $service_auth = array(
            'serviceId' =>  $this->service_id,
            'serviceIdSpecified' =>  true,
            'servicePassword' =>  $this->service_password,
        );
        return array_merge($service_auth, $data);
    }

    /**
     * WebService converting object to array data type.
     */
    protected function get_array_object($object){
        $arrayObject = new ArrayObject($object);
        return $arrayObject->getArrayCopy();
    }

    public function __destruct(){
        unset($this);
    }

    public static function Exception($e, $subject, $eData) {
        //error logging
    }


    /**
     * Live No DepositBonus Method
     *
     */
    public function open_Deposit_NoDepositBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['Login'],
                    'FundTransferAccountReceiver' => $account_info['FundTransferAccountReciever'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password,

                )
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_NoDepositBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_NoDepositBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_NoDepositBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_NoDepositBonus',$eData)
            );
        }
    }
    public function credit_mf_Prize( $account_number, $amount = 0, $comment = '' ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => (float) $amount,
                    'Comment' => $comment,
                    'FundTransferAccountReciever' => 0,
                    'Login' => $account_number,
                    'ProcessByIP' => $this->request_ip,
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );
//            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_Contest_MF_Prize_Bonus($data);
            $this->request_status = $oAccountData->Deposit_Contest_MF_Prize_BonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_Contest_MF_Prize_BonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_Contest_MF_Prize_Bonus',$eData)
            );
        }
    }

    /**
     * Live 20PercentBonus Method
     *
     */
    public function open_Deposit_20PercentBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_20PercentBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_20PercentBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_20PercentBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_20PercentBonus',$eData)
            );
        }
    }


    /**
     * Live 30PercentBonus Method
     *
     */
    public function open_Deposit_30PercentBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_30PercentBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_30PercentBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_30PercentBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_30PercentBonus',$eData)
            );
        }
    }
    public function open_Deposit_50_PercentBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_50_PercentBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_50_PercentBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_50_PercentBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_50_PercentBonus',$eData)
            );
        }
    }

    /**
     * Live 50PercentBonus Method
     *
     */
    public function open_Deposit_50PercentBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_50_PercentBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_50_PercentBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_50_PercentBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_50_PercentBonus',$eData)
            );
        }
    }

    /**
     * Live 100PercentBonus Method
     *
     */
    public function open_Deposit_100PercentBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_100_PercentBonus($merge_data);
            $this->request_status = $oAccountData->Deposit_100_PercentBonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_100_PercentBonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_100_PercentBonus',$eData)
            );
        }
    }
 public function open_Deposit_100PercentConstantBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Login' => $account_info['AccountNumber'],
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => 0,
                    'FundTransferReceiverAmount' => 0,
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_100_Percent_Constant_Bonus($merge_data);
            $this->request_status = $oAccountData->Deposit_100_Percent_Constant_BonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_100_Percent_Constant_BonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_100_Percent_Constant_Bonus',$eData)
            );
        }
    }
    

    /**
     * WebService method for updating live account details
     * this method is used in administration - manage accounts
     */
    public function update_live_account_details( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['account_number'],
                'info' => array(
                    'City' => $account_info['city'],
                    'Country' => $account_info['country'],
                    'Email' => $account_info['email'],
//                    'Leverage' => $account_info['leverage'],
//                    'Group' => $account_info['group'],
                    'Name' => $account_info['full_name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => $account_info['state'],
                    'StreetAddress' => $account_info['street_address'],
                    'ZipCode' => $account_info['zip_code'],
                    'Comment' => $account_info['comment']
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->UpdateAccountDetails($merge_data);
            $this->request_status = $oAccountData->UpdateAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountDetails',$eData)
            );
        }
    }


    /**
     * WebService method for updating live account details
     * this method is used in administration - manage accounts
     */
    public function update_affiliate_account_details( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['account_number'],
                'info' => array(
                    'City' => '',
                    'Country' => $account_info['country'],
                    'Email' => $account_info['email'],
//                    'Group' => $account_info['group'],
//                    'Leverage' => '',
                    'Name' => $account_info['full_name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => '',
                    'StreetAddress' => '',
                    'ZipCode' => ''
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->UpdateAccountDetails($merge_data);
            $this->request_status = $oAccountData->UpdateAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountDetails',$eData)
            );
        }
    }


    /**
     * WebService method for updating live account details
     * this method is used in administration - manage accounts
     */
    public function update_demo_account_details( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['account_number'],
                'info' => array(
                    'City' => '',
                    'Country' => $account_info['country'],
                    'Email' => $account_info['email'],
//                    'Group' => $account_info['group'],
//                    'Leverage' => $account_info['leverage'],
                    'Name' => $account_info['full_name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => '',
                    'StreetAddress' => '',
                    'ZipCode' => ''
                )
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->UpdateAccountDetails($merge_data);
            $this->request_status = $oAccountData->UpdateAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateAccountDetails',$eData)
            );
        }
    }

    /**
     * FXPP-940
     * GetAccountTradesHistory both have demo and live method
     */
    public function open_GetAccountActiveTrades( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAccounActiveTrades($data);
            $this->request_status = $oAccountData->GetAccounActiveTradesResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccounActiveTradesResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccounActiveTrades',$eData)
            );
        }
    }
    /**
     * FXPP-936
     * GetAccountTradesHistory both have demo and live method
     */
    public function open_GetAccountTradesHistory( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAccountTradesHistory($data);
            $this->request_status = $oAccountData->GetAccountTradesHistoryResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTradesHistoryResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTradesHistory',$eData)
            );
        }
    }

    /**
     *
     * GetAccountTotalProfitFromRange
     * this method is used to get total bonus profit
     */
    public function open_GetAccountTotalProfitFromRange( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAccountTotalProfitFromRange($data);
            $this->request_status = $oAccountData->GetAccountTotalProfitFromRangeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTotalProfitFromRangeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTotalProfitFromRange',$eData)
            );
        }
    }


    /**
     * FXPP-937
     * GetServerTime both have demo and live method
     */
    public function open_GetServerTime( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetServerTime($data);
//            var_dump($oAccountData);
//            $this->request_status = $oAccountData->GetServerTimeResult->ReqResult;
            $this->result = $oAccountData->GetServerTimeResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetServerTime',$eData)
            );
        }
    }

    /**
     * FXPP - 941
     * Transfer Between Accounts
     */

    public function FundTransfer($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'CommentFundTransferReceiver' => $account_info['CommentReceiver'],
                    'FundTransferAccountReceiver' => $account_info['Receiver'],
                    'FundTransferReceiverAmount' => $account_info['ConvertedAmount'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' => $this->service_id,
                    'servicePassword' => $this->service_password
                )
            );
            $oAccountData = $this->proxy->FundTransfer($data);
            $this->request_status = $oAccountData->FundTransferResult->ReqResult;
            $this->ticket = $oAccountData->FundTransferResult->Ticket;
            $this->result = self::get_array_object($oAccountData->FundTransferResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'FundTransfer',$eData)
            );
        }
    }

    /**
     * FXPP - 1067
     * remove affiliate of account
     */

    public function RemoveAgentOfAccount($account_number){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_number
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RemoveAgentOfAccount($merge_data);
            $this->request_status = $oAccountData->RemoveAgentOfAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RemoveAgentOfAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RemoveAgentOfAccount',$eData)
            );
        }
    }

    public function SetAccountAgent( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['AccountNumber'],
                'iAgent' => $account_info['AgentAccountNumber'],
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->SetAccountAgent($merge_data);
            $this->request_status = $oAccountData->SetAccountAgentResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->SetAccountAgentResult);
            return $oAccountData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'SetAccountAgent',$eData)
            );
        }
    }
    /**
     * Get Live Account Details Method
     * Request result are stored in WebService::result
     */
    public function open_RequestAccountDetails( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'],
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountDetails($merge_data);
            $this->request_status = $oAccountData->RequestAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountDetails',$eData)
            );
        }
    }
    /**
     *
     * ChangeAccountGroup used to  change the Account Group in the Live Accounts.
     *
     */

    public function open_ChangeAccountGroup( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'],
                'strGroup' => $account_info['strGroup'],
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );
            $oAccountData = $this->proxy->ChangeAccountGroup($data);
            $this->request_status = $oAccountData->ChangeAccountGroupResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ChangeAccountGroupResult);
            return $oAccountData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ChangeAccountGroup',$eData)
            );
        }
    }

    /**
     * This method is used for Transaction History Page - Balance Operations
     * RequestAccountFinanceRecordsByDate both and live method
     */
    public function open_RequestAccountFinanceRecordsByDate( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->RequestAccountFinanceRecordsByDate($data);
            $this->request_status = $oAccountData->RequestAccountFinanceRecordsByDateResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountFinanceRecordsByDateResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountFinanceRecordsByDate',$eData)
            );
        }
    }

    public function GetAgentsCommissionByDate( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAgentsCommissionByDate($data);
            $this->request_status = $oAccountData->GetAgentsCommissionByDateResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentsCommissionByDateResult);
            return true;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentsCommissionByDate',$eData)
            );
        }
    }

    /**
     * FXPP-1238
     * Withdrawal funds
     */

    public function WithdrawRealFund($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => $account_info['Receiver'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' => $this->service_id,
                    'servicePassword' => $this->service_password
                )
            );
            $oAccountData = $this->proxy->WithdrawRealFund($data);
            $this->request_status = $oAccountData->WithdrawRealFundResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->WithdrawRealFundResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'WithdrawRealFund',$eData)
            );
        }
    }

    /**
     * Withdrawal Supporter Full Account Funds
     */

    public function WithdrawSupporterFullFund($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => $account_info['Receiver'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' => $this->service_id,
                    'servicePassword' => $this->service_password
                )
            );
            $oAccountData = $this->proxy->Withdraw_Supporter_Full_Fund($data);
            $this->request_status = $oAccountData->Withdraw_Supporter_Full_FundResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Withdraw_Supporter_Full_FundResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Withdraw_Supporter_Full_Fund',$eData)
            );
        }
    }

    public function WithdrawBonusFund($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => $account_info['Receiver'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' => $this->service_id,
                    'servicePassword' => $this->service_password
                ),
               'bonusId' => $account_info['bonusId']
            );
            $oAccountData = $this->proxy->WithdrawBonusFund($data);
//            FXPP::print_data($data);exit;
            $this->request_status = $oAccountData->WithdrawBonusFundResult->ReqResult;


            $this->result = self::get_array_object($oAccountData->WithdrawBonusFundResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'WithdrawBonusFund',$eData)
            );
        }
    }

    /**
     *  Get Live and Demo Account Balance except partners not yet tested
     *
     */

    public function open_RequestAccountBalance( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' =>$account_info['iLogin']
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountBalance($merge_data);
            $this->request_status = $oAccountData->RequestAccountBalanceResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountBalanceResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountBalance',$eData)
            );
        }
    }

    public function RequestAccountFunds($account_number){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_number
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountFunds($merge_data);
            $this->result = self::get_array_object($oAccountData->RequestAccountFundsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountFunds',$eData)
            );
        }
    }
    /**
     *
     * ChangeAccountLeverage used to  change the Account Leverage in the Live Accounts.
     *
     */

    public function open_ChangeAccountLeverage( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'],
                'iLeverage' => $account_info['iLeverage'],
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );
            $oAccountData = $this->proxy->ChangeAccountLeverage($data);
            $this->request_status = $oAccountData->ChangeAccountLeverageResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ChangeAccountLeverageResult);
            return $oAccountData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ChangeAccountLeverage',$eData)
            );
        }
    }

   // pending order get in current treads tab [FZ]
     public function GetAccounPendingOrders ( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // account number
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );
            $oAccountData = $this->proxy->GetAccounPendingOrders($data);
            $this->request_status = $oAccountData->GetAccounPendingOrdersResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccounPendingOrdersResult);
            return $oAccountData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccounPendingOrders',$eData)
            );
        }
    }

 public function GetAccountCancelledPendingOrders( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAccountCancelledPendingOrders($data);
            $this->request_status = $oAccountData->GetAccountCancelledPendingOrdersResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountCancelledPendingOrdersResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountCancelledPendingOrders',$eData)
            );
        }
    }

    public function ConvertCurrency($convertDetails = array() ){
        $eData = array();

        try{
            $data = array(
                'request' => array(
                    'Amount' => $convertDetails['Amount'],
                    'FromCurrency' => $convertDetails['FromCurrency'],
                    'ServiceLogin' => $convertDetails['ServiceLogin'],
                    'ServicePassword' => $convertDetails['ServicePassword'],
                    'ToCurrency' => $convertDetails['ToCurrency'])
            );
            $oConvertData = $this->proxy->ConvertCurrency($data);
            $aConvertData = json_encode($oConvertData);
            return json_decode($aConvertData, true);

        }catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ConvertCurrency',$eData)
            );
        }

    }



     public function RequestAccountDetails( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin']
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAccountDetails($merge_data);
            $this->request_status = $oAccountData->RequestAccountDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAccountDetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountDetails',$eData)
            );
        }
    }


    /**
     * ActivateAccountTrading used for Account Verification to activate trading Admin side
     *
     */

    public function open_ActivateAccountTrading( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['AccountNumber'],
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->ActivateAccountTrading($merge_data);
            $this->request_status = $oAccountData->ActivateAccountTradingResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ActivateAccountTradingResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateAccountTrading',$eData)
            );
        }
    }

    /**
     * ActivateAccountTrading used for Account Verification to activate trading Admin side
     *
     */

    public function request_payment_address(){
        $eData = array();
        try {
            $data = array(
                'iServiceLogin' => $this->bitcoin_id,
                'strServicePassword' =>  $this->bitcoin_password
            );

            $oAccountData = $this->proxy->RequestPaymentAddress($data);
            $this->request_status = $oAccountData->RequestPaymentAddressResult->RequestStatus;
            $this->result = self::get_array_object($oAccountData->RequestPaymentAddressResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateAccountTrading',$eData)
            );
        }
    }

    public function verify_payment( $address, $transaction_id ){
        $eData = array();
        try {
            $data = array(
                'address' => $address,
                'transactionId' => $transaction_id,
                'iServiceLogin' => $this->bitcoin_id,
                'strServicePassword' =>  $this->bitcoin_password
            );

            $oAccountData = $this->proxy->VerifyPayment($data);
            $this->request_status = $oAccountData->VerifyPaymentResult->RequestStatus;
            $this->result = self::get_array_object($oAccountData->VerifyPaymentResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateAccountTrading',$eData)
            );
        }
    }

    public function verify_payment2( $address, $transaction_id, $account_number ){
        $eData = array();
        try {
            $data = array(
                'address' => $address,
                'transactionId' => $transaction_id,
                'strAccountOrWalletNumber' => $account_number,
                'iServiceLogin' => $this->bitcoin_id,
                'strServicePassword' =>  $this->bitcoin_password
            );

            $oAccountData = $this->proxy->VerifyPayment2($data);
            $this->request_status = $oAccountData->VerifyPayment2Result->RequestStatus;
            $this->result = self::get_array_object($oAccountData->VerifyPayment2Result);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateAccountTrading',$eData)
            );
        }
    }


    public function Test_VerifyPayment_PAYMENT_CONFIRMED_Result( $address, $transaction_id, $account_number ){
        $eData = array();
        try {
            $data = array(
                'address' => $address,
                'transactionId' => $transaction_id,
                'strAccountOrWalletNumber' => $account_number,
                'iServiceLogin' => $this->bitcoin_id,
                'strServicePassword' =>  $this->bitcoin_password
            );

            $oAccountData = $this->proxy->Test_VerifyPayment_PAYMENT_CONFIRMED_Result($data);
            $this->request_status = $oAccountData->Test_VerifyPayment_PAYMENT_CONFIRMED_ResultResult->RequestStatus;
            $this->result = self::get_array_object($oAccountData->Test_VerifyPayment_PAYMENT_CONFIRMED_ResultResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateAccountTrading',$eData)
            );
        }
    }

    /**
     * Trading
     **/
    public function open_GetCurrentQuotes( ){
        $eData = array();
        try {
            $data = array(
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->GetCurrentQuotes($data);
            $this->request_status = $oAccountData->GetCurrentQuotesResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetCurrentQuotesResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetCurrentQuotes',$eData)
            );
        }
    }
    public function open_RequestCancelPendingOrder($account_info = array()   ){
        $eData = array();
        try {
            $data = array(
                'orderRequest' => array(
                    'Comment' => $account_info['Comment'],
                    'Expiration' => $account_info['Login'],
                    'OrderId' => $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' => $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->RequestCancelPendingOrder($data);
            $this->request_status = $oAccountData->RequestCancelPendingOrderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestCancelPendingOrderResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestCancelPendingOrder',$eData)
            );
        }
    }
    public function open_RequestCloseTrade($account_info = array()  ){
        $eData = array();
        try {
            $data = array(
                'tradeRequest' => array(
                    'ClosePrice' => $account_info['ClosePrice'],
                    'Comment' => $account_info['Comment'],
                    'Login' => $account_info['Login'],
                    'OpenPrice' => $account_info['OpenPrice'],
                    'OrderId' => $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' => $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->RequestCloseTrade($data);
            $this->request_status = $oAccountData->RequestCloseTradeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestCloseTradeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestCloseTrade',$eData)
            );
        }
    }
    public function open_RequestModifyPendingOrder($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'orderRequest' => array(
                    'Comment' => $account_info['Comment'],
                    'Expiration' => $account_info['Expiration'],
                    'Login' => $account_info['Login'],
                    'OrderId' => $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' => $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->RequestModifyPendingOrder($data);
            $this->request_status = $oAccountData->RequestModifyPendingOrderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestModifyPendingOrderResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestModifyPendingOrder',$eData)
            );
        }
    }
    public function open_RequestModifyTrade($account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'tradeRequest' => array(
                    'ClosePrice' => $account_info['ClosePrice'],
                    'Comment' => $account_info['Comment'],
                    'Login' => $account_info['Login'],
                    'OpenPrice' => $account_info['OpenPrice'],
                    'OrderId' => $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' => $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->RequestModifyTrade($data);
            $this->request_status = $oAccountData->RequestModifyTradeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestModifyTradeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestModifyTrade',$eData)
            );
        }
    }
    public function open_RequestOpenPendingOrder( $account_info = array()){
        $eData = array();
        try {
            $data = array(
                'orderRequest' => array(
                    'Comment' => $account_info['Comment'],
                    'Expiration' => $account_info['Expiration'],
                    'Login' => $account_info['Login'],
                    'OpenPrice' => $account_info['OpenPrice'],
                    'OrderId' => $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' => $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                 ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
            $oAccountData = $this->proxy->RequestOpenPendingOrder($data);
            $this->request_status = $oAccountData->RequestOpenPendingOrderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestOpenPendingOrderResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestOpenPendingOrder',$eData)
            );
        }
    }

    public function open_RequestOpenTrade($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'tradeRequest' => array(
                    'ClosePrice' => $account_info['ClosePrice'],
                    'Comment' => $account_info['Comment'],
                    'Login' => $account_info['Login'],
                    'OpenPrice' =>  $account_info['OpenPrice'],
                    'OrderId' =>  $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' =>  $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );

            $oAccountData = $this->proxy->RequestOpenTrade($data);
            $this->request_status = $oAccountData->RequestOpenTradeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestOpenTradeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestOpenTrade',$eData)
            );
        }
    }
    public function open_RequestOpenTrade_test($account_info = array()){
        $eData = array();
//        try {
            $data = array(
                'tradeRequest' => array(
                    'ClosePrice' => $account_info['ClosePrice'],
                    'Comment' => $account_info['Comment'],
                    'Login' => $account_info['Login'],
                    'OpenPrice' =>  $account_info['OpenPrice'],
                    'OrderId' =>  $account_info['OrderId'],
                    'RequestType' => $account_info['RequestType'],
                    'StopLoss' =>  $account_info['StopLoss'],
                    'Symbol' => $account_info['Symbol'],
                    'TakeProfit' => $account_info['TakeProfit'],
                    'Volume' => $account_info['Volume'],
                ),
                'serviceId' => $this->trading_id,
                'servicePassword' =>  $this->trading_password
            );
        print_r($data);
//            $oAccountData = $this->proxy->RequestOpenTrade($data);
//            $this->request_status = $oAccountData->RequestOpenTradeResult->ReqResult;
//            $this->result = self::get_array_object($oAccountData->RequestOpenTradeResult);
//            return true;
//        } catch (SoapFault $e)  {
//            return array(
//                'SOAPError' => true,
//                'Message' => $e->getMessage(),
//                'LogId' => self::Exception($e,'RequestOpenTrade',$eData)
//            );
//        }
    }
    /**
     * Trading
     **/
    /**
     * Open Standard Account Method
     * Request result are stored in WebService::result
     */
    public function open_account_standard( $account_info = array() ){
        $eData = array();
        try {
            if(array_key_exists('comment', $account_info)){
                $comment = $account_info['comment'];
            }else{
                $comment = '';
            }

            $data = array(
                'accountInfo' => array(
                    'Address' => $account_info['address'],
                    'City' => $account_info['city'],
                    'Comment' => $comment,
                    'Country' => substr($account_info['country'],0,31),
                    'Email' => $account_info['email'],
                    'Group' => $account_info['group'],
                    'Leverage' => $account_info['leverage'],
//                    'LeverageSpecified' => true,
                    'Name' => $account_info['name'],
                    'PhoneNumber' => $account_info['phone_number'],
                    'State' => $account_info['state'],
                    'ZipCode' => $account_info['zip_code'],
                    'IsReadOnly' => true,
//                    'IsReadOnlySpecified' => true,
                    'PhonePassword' => $account_info['phone_password']
                )
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->OpenAccount($merge_data);
            $this->request_status = $oAccountData->OpenAccountResult->ReqResult;
//            $this->request_status = $oAccountData->OpenRealStandardAccountResult->ReqResult;
//            $this->result = self::get_array_object($oAccountData->OpenRealStandardAccountResult);
            $this->result = self::get_array_object($oAccountData->OpenAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'OpenRealStandardAccount',$eData)
            );
        }
    }

    /**
     * Check Account number and password
     * Request result are stored in WebService::result
     */
    public function CheckUserPassword( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'],
                'strPassword' => $account_info['strPassword']
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->CheckAccountPassword($merge_data);
            $this->request_status = $oAccountData->CheckAccountPasswordResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->CheckAccountPasswordResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'CheckAccountPassword',$eData)
            );
        }
    }

    /**
     * Check email and password
     * Request result are stored in WebService::result
     */
    public function CheckEmailPassword( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'strEmail' => $account_info['strEmail'],
                'strPassword' => $account_info['strPassword']
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->CheckAccountEmailPassword($merge_data);
            $this->request_status = $oAccountData->CheckAccountEmailPasswordResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->CheckAccountEmailPasswordResult);
            return true;
        } catch (SoapFault $e)  {
            var_dump($e->getMessage());
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'CheckAccountEmailPassword',$eData)
            );
        }
    }

    public function GetAccountTotalTradedVolume( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'],
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountTotalTradedVolume($merge_data);
            $this->request_status = $oAccountData->GetAccountTotalTradedVolumeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTotalTradedVolumeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTotalTradedVolume',$eData)
            );
        }
    }
    public function GetAccountTotalTradedVolumeAfter30PercentBonus( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'],
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountTotalTradedVolume_After_30_Percent_Bonus($merge_data);
            $this->request_status = $oAccountData->GetAccountTotalTradedVolume_After_30_Percent_BonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTotalTradedVolume_After_30_Percent_BonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTotalTradedVolume_After_30_Percent_Bonus',$eData)
            );
        }
    }

    public function GetAccountTotalTradedVolumeAfterBonus( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'],
                'iBonusType' => $account_info['iBonusType']
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountTotalTradedVolume_After_Bonus($merge_data);
            $this->request_status = $oAccountData->GetAccountTotalTradedVolume_After_BonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTotalTradedVolume_After_BonusResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTotalTradedVolume_After_Bonus',$eData)
            );
        }
    }

    public function GetAgentsCommissionByDateWithLimitAndOffset( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'iOffset' => $account_info['offset'],
                'limitCount' => $account_info['limit']
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentsCommissionByDateWithLimitAndOffset($merge_data);
            $this->request_status = $oAccountData->GetAgentsCommissionByDateWithLimitAndOffsetResult->ReqResult;
            $this->result = $oAccountData->GetAgentsCommissionByDateWithLimitAndOffsetResult;
            return $oAccountData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentsCommissionByDateWithLimitAndOffset',$eData)
            );
        }
    }

    public function GetAgentsCommissionByDateCount( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentsCommissionByDateCount($merge_data);
            $this->request_status = $oAccountData->GetAgentsCommissionByDateCountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentsCommissionByDateCountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentsCommissionByDateCount',$eData)
            );
        }
    }

    public function GetBalanceMonitoringDataByDate( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetBalanceMonitoringDataByDate($merge_data);
            $this->request_status = $oAccountData->GetBalanceMonitoringDataByDateResult->ReqResult;
            $this->result = $oAccountData->GetBalanceMonitoringDataByDateResult;
            return $oAccountData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetBalanceMonitoringDataByDate',$eData)
            );
        }
    }

    public function GetAccountBonusBreakdown( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountBonusBreakdown($merge_data);
            $this->request_status = $oAccountData->GetAccountBonusBreakdownResult->ReqResult;
            $this->result = $oAccountData->GetAccountBonusBreakdownResult;
            return $oAccountData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountBonusBreakdown',$eData)
            );
        }
    }

    public function ChangeUserMasterPasswordAdmin( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' =>$account_info['iLogin'],
                'strNewPass' =>$account_info['strNewPass']
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->ChangeAccountMasterPasswordAdmin($merge_data);
            $this->request_status = $oAccountData->ChangeAccountMasterPasswordAdminResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ChangeAccountMasterPasswordAdminResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ChangeAccountMasterPasswordAdmin',$eData)
            );
        }
    }

    public function ChangeUserMasterPasswordClient( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' =>$account_info['iLogin'],
                'currentMasterPass' =>$account_info['currentMasterPass'],
                'strNewPass' =>$account_info['strNewPass'],
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->ChangeAccountMasterPasswordClient($merge_data);
            $this->request_status = $oAccountData->ChangeAccountMasterPasswordClientResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ChangeAccountMasterPasswordClientResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ChangeAccountMasterPasswordClient',$eData)
            );
        }
    }

    public function GeneratePassword( $account_info = array()){
        $eData = array();
        try {

            $data = array(
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GeneratePassword($data);
            $this->result = $oAccountData->GeneratePasswordResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GeneratePassword',$eData)
            );
        }
    }


    public function GeneratePasswordTest()
    {
        $eData = array();
        try {

            $data = array(
                'serviceId' => $this->service_id, //int
                'servicePassword' => $this->service_password //string
            );
            $oAccountData = $this->proxy->GeneratePassword($data);
            $this->result = $oAccountData->GeneratePasswordResult;
            return true;
        } catch (SoapFault $e) {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e, 'GeneratePassword', $eData)
            );
        }
    }
    public function GetAccountWithBalanceBetweenRange( $account_info = array() ){
        $eData = array();
        try {

            $data = array(
                'startAmount' => $account_info['startAmount'],
                'endAmount' => $account_info['endAmount'],
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountWithBalanceBetweenRange($merge_data);
            $this->request_status = $oAccountData->GetAccountWithBalanceBetweenRangeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountWithBalanceBetweenRangeResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountWithBalanceBetweenRange',$eData)
            );
        }
    }

    public function GetAccountFinanceRecordsByTypeWithLimitOffset( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['account_number'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'iLimit' => $account_info['limit'],
                'iOffset' =>  $account_info['offset'],
                'iType' =>  $account_info['type'],
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAccountFinanceRecordsByTypeWithLimitOffset($data);

            $this->request_status = $oAccountData->GetAccountFinanceRecordsByTypeWithLimitOffsetResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountFinanceRecordsByTypeWithLimitOffsetResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountFinanceRecordsByTypeWithLimitOffset',$eData)
            );
        }
    }


/* please do not delete functin cuase it's use for  Indonesian  and malysian deposit record
 [If any body want to delete this function you mast infrom me before that.]
 */
    public function depositorInformation($accountNumber){

          $ci =& get_instance();
          $ipadd=$ci->input->ip_address();
          $ci->load->database();

        $row = $ci->account_model->getUserDetailsByAccountNumberRow($accountNumber);
        $user_id=$row->user_id;
        if(!$row){
            $row = $ci->account_model->getUserDetailsByAccountNumberRow_partner($accountNumber);
            $user_id=$row->partner_id;
        }


        $countryName=$ci->general_model->getCountries($row->country);
        $edatas['email_data']=array(
            'Email'=>$row->email,
            'Phone '=>(($row->phone1)?$row->phone1:$row->phone2),
            'City'=>$row->city,
            'Country'=>$countryName,
            'Name'=>$row->full_name,
            'Status'=>'Deposited',
        );


        $checkData=array(
            'user_id'=>$user_id,
            'status'=>1,
            'action'=>1,
            'date'=>date('Y-m-d')
        );

        $resultcheck=$ci->general_model->getQueryStringRow('page_visitor','*',$checkData,'id','DESC','1');
        if(empty($resultcheck)) {

           unset($checkData['date']);
           $finalCheckN=$ci->general_model->getQueryStringRow('page_visitor','*',$checkData,'id','DESC','1');
           if(!empty($finalCheckN)){$dbtime=$finalCheckN->visit_time;}else{$dbtime=strtotime(date('Y-m-d H:i'));}

               $exhousr=self::getDateDiffer($dbtime,date('Y-m-d H:i'));

               if($exhousr=="24" or empty($finalCheckN))
                 {

                            if(IPLoc::for_id_only() || IPLoc::for_my_only())
                            {
                                      if(IPLoc::for_id_only())
                                     {
                                         $subject = "Active Indonesian Client Report";
                                         $edatas['email_data']['heading']='Active Indonesian Client Report.';
                                         $ci->general_model->sendEmailVisitor('default_mail', $subject,'id_a_clients@forexmart.com', $edatas, $config,null);
                                     }

                                   if(IPLoc::for_my_only())
                                     {
                                         $subject = "Active Malaysian Client Report";
                                         $edatas['email_data']['heading']='Active Malaysian Client Report.';
                                         $ci->general_model->sendEmailVisitor('default_mail', $subject,'my_a_clients@forexmart.com', $edatas, $config,null);
                                     }

                                    if(!empty($finalCheckN))
                                    {
                                     unset($checkData['notification_count']);
                                     unset($checkData['action']);
                                     $updateBox=array('notification_count'=>1,'action'=>1);

                                     $ci->general_model->setQueryStringUpdate('page_visitor',$checkData,$updateBox);
                                    }
                                    else
                                    {

                                         $idata=array(
                                            'ip'=>$ci->input->ip_address(),
                                            'user_id'=>$user_id,
                                            'session_id'=>session_id(),
                                            'date'=>date('Y-m-d'),
                                            'visit_time'=>strtotime(date('Y-m-d H:i')),
                                            'visit_page'=>$ci->input->post('current_url'),
                                            'notification_count'=>1,
                                            'comments'=>'Direct deposit',
                                            'status'=>1,
                                             'action'=>1,
                                            'cookie_id'=>'',
                                            'browser'=>$ci->agent->browser()
                                        );
                                          $ci->general_model->insert('page_visitor',$idata);

                                    }


                            }


                 }
            }

    }

 public function depositorInformationOld($accountNumber){

          $ci =& get_instance();
          $ipadd=$ci->input->ip_address();
          $user_id=$ci->session->userdata('user_id');
          $ci->load->database();
          $whereUser=array('account_number'=>$accountNumber);
         $dipositUser=$ci->general_model->getQueryStringRow('mt_accounts_set','*',$whereUser,'id','DESC','1');

        // if(!empty($dipositUser)){$user_id=$dipositUser->user_id;}
            $user_id=$dipositUser->user_id;
            $uwhereData=array('user_id'=>$user_id);
            $userProfile=$ci->general_model->getQueryStringRow('user_profiles','*',$uwhereData,'id','DESC','1');
            $cserProfile=$ci->general_model->getQueryStringRow('contacts','*',$uwhereData);
            $countryName=$ci->general_model->getCountries($userProfile->country);

            $getuser=array('id'=>$user_id);
            $userTable=$ci->general_model->getQueryStringRow('users','*',$getuser,'id','DESC','1');

                        $edatas['email_data']=array(
                        'Email'=>$userTable->email,
                        'Phone '=>(($cserProfile->phone1)?$cserProfile->phone1:$cserProfile->phone2),
                        'City'=>$userProfile->city,
                        'Country'=>$countryName,
                       'Name'=>$userProfile->full_name,
                       'Status'=>'Deposited',
                      );



                    $checkData=array(
                    'user_id'=>$user_id,
                    'status'=>1,
                    'action'=>1,
                    'date'=>date('Y-m-d')
                   );

        $resultcheck=$ci->general_model->getQueryStringRow('page_visitor','*',$checkData,'id','DESC','1');
        if(empty($resultcheck))
        {

                   unset($checkData['date']);
                   $finalCheckN=$ci->general_model->getQueryStringRow('page_visitor','*',$checkData,'id','DESC','1');
                  if(!empty($finalCheckN)){$dbtime=$finalCheckN->visit_time;}else{$dbtime=strtotime(date('Y-m-d H:i'));}

               $exhousr=self::getDateDiffer($dbtime,date('Y-m-d H:i'));

               if($exhousr=="24" or empty($finalCheckN))
                 {

                            $cCountryName=$userProfile->country;
                           // $countryArray=array('ID','IDR','MY','MYR');
                            if(IPLoc::for_id_only() || IPLoc::for_my_only())
                            {
                                      if(IPLoc::for_id_only())
                                     {
                                         $subject = "Active Indonesian Client Report";
                                         $edatas['email_data']['heading']='Active Indonesian Client Report.';
                                         $ci->general_model->sendEmailVisitor('default_mail', $subject,'id_a_clients@forexmart.com', $edatas, $config,null);
                                     }

                                   if(IPLoc::for_my_only())
                                     {
                                         $subject = "Active Malaysian Client Report";
                                         $edatas['email_data']['heading']='Active Malaysian Client Report.';
                                         $ci->general_model->sendEmailVisitor('default_mail', $subject,'my_a_clients@forexmart.com', $edatas, $config,null);
                                     }


                                    if(!empty($finalCheckN))
                                    {
                                     unset($checkData['notification_count']);
                                     unset($checkData['action']);
                                     $updateBox=array('notification_count'=>1,'action'=>1);

                                     $ci->general_model->setQueryStringUpdate('page_visitor',$checkData,$updateBox);
                                    }
                                    else
                                    {

                                         $idata=array(
                                            'ip'=>$ci->input->ip_address(),
                                            'user_id'=>$user_id,
                                            'session_id'=>session_id(),
                                            'date'=>date('Y-m-d'),
                                            'visit_time'=>strtotime(date('Y-m-d H:i')),
                                            'visit_page'=>$ci->input->post('current_url'),
                                            'notification_count'=>1,
                                            'comments'=>'Direct deposit',
                                            'status'=>1,
                                             'action'=>1,
                                            'cookie_id'=>'',
                                            'browser'=>$ci->agent->browser()
                                        );
                                          $ci->general_model->insert('page_visitor',$idata);

                                    }


                            }


                 }
        }

    }





  public function getDateDiffer($dbTime,$currentTime)
 {

        $diff=((strtotime($currentTime))-$dbTime);
        $y=60*60*24*365;
	$m=60*60*24*30;
	$d=60*60*24;
	$h=60*60;

        $yy=floor($diff/$y);
        $mm=floor($diff/$m);
        $dd=floor($diff/$d);
        $hh=floor($diff/$h);

	 $result=0;
	 if($yy>0 or $mm>0 or $dd>0 or $hh>23)
	 {
	  $result="24";
	 }
	 return $result;
 }





    public function temp_get_finance_record_by_ticket($ticket){
        $eData = array();
        try {
            $data = array(
                'iTicket' => $ticket, // int Account Number
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetFinanceRecordOfTicket($merge_data);
            $this->request_status = $oAccountData->GetFinanceRecordOfTicketResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetFinanceRecordOfTicketResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAccountFinanceRecordsByDate',$eData)
            );
        }
    }

    public function RequestCommonMethodBonus( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $this->request_ip,
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password,
                )
            );
            $method = $account_info['Method'];
            $methodResult = $account_info['Method'].'Result';
            $oAccountData = $this->proxy->$method($data);
            $this->request_status = $oAccountData->$methodResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->$methodResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,$methodResult,$eData)
            );
        }
    }

    public function GetAccountTotalDepositedRealFund($account_number){
        $eData = array();
        try {
            $data = array(
                'iAccount' => $account_number,
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAccountAllTimeTotalRFealFundDeposit($merge_data);
            $this->request_status = $oAccountData->GetAccountAllTimeTotalRFealFundDepositResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountAllTimeTotalRFealFundDepositResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountAllTimeTotalRFealFundDeposit',$eData)
            );
        }
    }
    //    PAMM API

    public function open_RegisterPammInvestor($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'investorReq' => array(
                    'AccountName' => $account_info['AccountName'], //Full name of the account holder.
                    'AccountNumber' => $account_info['AccountNumber'], // Account Number.
                    'BrokerId' => $account_info['BrokerId'], //Broker Id 0 forexmart 1 instaforex
                    'CfgLang' => $account_info['CfgLang'], // Reporting language in PAMM system (ru, en).
                    'ConfirmInvestmentRefund' => $account_info['ConfirmInvestmentRefund'], // is investment refund  0 false 1 true
                    'Icq' => $account_info['Icq'], //Icq Number
                    'ShowIcq' => $account_info['ShowIcq'], // Whether to show icq number in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'ShowSkype' => $account_info['ShowSkype'], //Whether to show skype ID in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'ShowYahoo' => $account_info['ShowYahoo'], // Whether to show yahoo number in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'Skype' => $account_info['Skype'],  //Skype ID.
                    'StartTime' => $account_info['StartTime'], //Time when monitoring starts
                    'Yahoo' => $account_info['Yahoo'], //Yahoo Id.
                )
            );
            $oAccountData = $this->proxy->RegisterPammInvestor($data);
            $this->request_status = $oAccountData->RegisterPammInvestorResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RegisterPammInvestorResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RegisterPammInvestor',$eData)
            );
        }

    }

    public function open_RegisterPammPartner($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'partnerReq' => array(
                    'AccountName' => $account_info['AccountName'], //Full name of the account holder.
                    'AccountNumber' => $account_info['AccountNumber'], // Account Number.
                    'BrokerId' => $account_info['BrokerId'], //Broker Id 0 forexmart 1 instaforex
                    'CfgLang' => $account_info['CfgLang'], // Reporting language in PAMM system (ru, en).
                    'ConfirmInvestmentRefund' => $account_info['ConfirmInvestmentRefund'], // is investment refund  0 false 1 true
                    'Email' => $account_info['Email'], //Email
                    'Icq' => $account_info['Icq'], //Icq Number
                    'InvestorPassword' => $account_info['InvestorPassword'], //Investor Password
                    'ShowIcq' => $account_info['ShowIcq'], // Whether to show icq number in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'ShowSkype' => $account_info['ShowSkype'], //Whether to show skype ID in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'ShowYahoo' => $account_info['ShowYahoo'], // Whether to show yahoo number in the monitoring list (0 � hidden, 1 �shown to investors, 2 � shown to everybody).
                    'Skype' => $account_info['Skype'],  //Skype ID.
                    'StartTime' => $account_info['StartTime'], //Time when monitoring starts
                    'TraderPassword' => $account_info['TraderPassword'], //Investor Password
                    'Yahoo' => $account_info['Yahoo'], //Yahoo Id.
                )
            );
            $oAccountData = $this->proxy->RegisterPammPartner($data);
            $this->request_status = $oAccountData->RegisterPammPartnerResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RegisterPammPartnerResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RegisterPammPartner',$eData)
            );
        }
    }

    public function open_RegisterPammTrader($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'traderReq' => array(
                    'AccountName' => $account_info['AccountName'], //Full name of the account holder.
                    'AccountNumber' => $account_info['AccountNumber'], // Account Number.
                    'BrokerId' => $account_info['BrokerId'], //Broker Id 0 forexmart 1 instaforex
                    'ConditionSet'=> array(
                        'ConditionSetNumber' => $account_info['ConditionSetNumber'],
                        'IsConditionEnable' => $account_info['IsConditionEnable'],
                        'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount'],
                        'MinInvestmentAmount' => $account_info['MinInvestmentAmount'],
                        'MinimumInvestmentTimeInSeconds' => $account_info['MinimumInvestmentTimeInSeconds'],
                        'PenaltyPersentBack' => $account_info['PenaltyPersentBack'],
                        'ProjectShare' => $account_info['ProjectShare'],
                    ),
                    'ConfigLanguage' => $account_info['ConfigLanguage'],
                    'Description' => $account_info['Description'],
                    'DescriptionJapanese' => $account_info['DescriptionJapanese'],
                    'DescriptionPolish' => $account_info['DescriptionPolish'],
                    'DescriptionRussian' => $account_info['DescriptionRussian'],
                    'Icq' => $account_info['Icq'], //Icq Number
                    'IsAutoInvestmentAgree' => $account_info['IsAutoInvestmentAgree'],
                    'PartnerShare' => $account_info['PartnerShare'],
                    'ProjectName' => $account_info['ProjectName'],
                    'ShowAccountName' => $account_info['ShowAccountName'],
                    'ShowIcq' => $account_info['ShowIcq'],
                    'ShowSkype' => $account_info['ShowSkype'],
                    'ShowYahoo' => $account_info['ShowYahoo'],
                    'Skype' => $account_info['Skype'],
                    'StartTime' => $account_info['StartTime'],
                    'Yahoo' => $account_info['Yahoo'],
                )
            );
            $oAccountData = $this->proxy->RegisterPammTrader($data);
            $this->request_status = $oAccountData->RegisterPammTraderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RegisterPammTraderResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RegisterPammTrader',$eData)
            );
        }
    }

    public function open_DeactivateAccount($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'iAccount' => $account_info['iAccount'], //Account Number
                'brokerId' => $account_info['brokerId'], // Broker Id
                'isDeact' => $account_info['isDeact'], // True or False
            );
            $oAccountData = $this->proxy->DeactivateAccount($data);
            $this->result = json_decode(json_encode($oAccountData->DeactivateAccountResult), true);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'DeactivateAccount',$eData)
            );
        }
    }

    public function open_ReturnInvestment($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'isReturnedByTrader' => $account_info['isReturnedByTrader'], // True or False
                'invdata' => array(
                    'AccountBrokerId' => $account_info['AccountBrokerId'],
                    'AccountId' => $account_info['AccountId'],
                    'InvestmentAmount' => $account_info['InvestmentAmount'],
                    'InvestmentId' => $account_info['InvestmentId'],
                    'OwnerBrokerId' => $account_info['OwnerBrokerId'],
                    'OwnerId' => $account_info['OwnerId'],
                    'Profit' => $account_info['Profit'],
                    'Return' => $account_info['Return'],
                    'Share' => $account_info['Share'],
                    'StatusDescription' => $account_info['StatusDescription'],
                    'Status' => $account_info['Status'],
                    'Time' => $account_info['Time'],
                )
            );

            $oAccountData = $this->proxy->ReturnInvestment($data);
            $this->request_status = $oAccountData->ReturnInvestmentResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ReturnInvestmentResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ReturnInvestment',$eData)
            );
        }
    }


    public function open_EditPammTraderProfile($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId'],
                'pt_Data' => array(
                    'AccountName' => $account_info['AccountName'],
                    'AffiliateShare' => $account_info['AffiliateShare'],
                    'DescEnglish' => $account_info['DescEnglish'],
                    'DescriptionJapanesse' => $account_info['DescriptionJapanesse'],
                    'DescriptionPolish' => $account_info['DescriptionPolish'],
                    'DescriptionRussian' => $account_info['DescriptionRussian'],
                    'ForumLink' => $account_info['ForumLink'],
                    'HasEmailAlerts' => $account_info['HasEmailAlerts'],
                    'HasSMSAlerts' => $account_info['HasSMSAlerts'],
                    'Icq' => $account_info['Icq'],
                    'IsConfirmInvestmentRefund' => $account_info['IsConfirmInvestmentRefund'],
                    'IsDeactivated' =>  $account_info['IsDeactivated'],
                    'IsInvestmentAutoAgree' => $account_info['IsInvestmentAutoAgree'],
                    'IsShowAccountName' => $account_info['IsShowAccountName'],
                    'IsShowActiveTrades' => $account_info['IsShowActiveTrades'],
                    'IsShowIcq' => $account_info['IsShowIcq'],
                    'IsShowSkype' => $account_info['IsShowSkype'],
                    'IsShowYahoo' => $account_info['IsShowYahoo'],
                    'ProjectName' => $account_info['ProjectName'],
                    'Skype' => $account_info['Skype'],
                    'StartTimeMonitoring' => $account_info['StartTimeMonitoring'],
                    'SystemNotificationLanguage' => $account_info['SystemNotificationLanguage'],
                    'Yahoo' => $account_info['Yahoo'],
                )
            );

            $oAccountData = $this->proxy->EditPammTraderProfile($data);
            $this->result = $oAccountData->EditPammTraderProfileResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'EditPammTraderProfile',$eData)
            );
        }
    }
    
    public function open_EditPammInvestorOrPartnerProfile($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'pi_or_pp_account' => $account_info['pi_or_pp_account'],
                'brokerId' => $account_info['brokerId'],
                'pi_Data' => array(
                    'AccountName' => $account_info['AccountName'],
                    'IcqId' => $account_info['IcqId'],
                    'IsConfirmInvestmentRefund' => $account_info['IsConfirmInvestmentRefund'],
                    'IsDeactivated' => $account_info['IsDeactivated'],
                    'Skype' => $account_info['Skype'],
                    'SystemNotificationLanguage' => $account_info['SystemNotificationLanguage'],
                )
            );
            $oAccountData = $this->proxy->EditPammInvestorOrPartnerProfile($data);
            $this->result = $oAccountData->EditPammInvestorOrPartnerProfileResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'EditPammInvestorOrPartnerProfile',$eData)
            );
        }
    }

    public function open_NewInvestmentRequest($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'investmentReq' => array(
                    'AffiliateAccount' => $account_info['AffiliateAccount'],
                    'ConditionSetNumber' => $account_info['ConditionSetNumber'],
                    'Currency' => $account_info['Currency'],
                    'InvSum' => $account_info['InvSum'],
                    'InvestorAccountNumber' => $account_info['InverstorAccountNumber'],
                    'InvestorBroker' => $account_info['InvestorBroker'],
                    'OwnerBroker' => $account_info['OwnerBroker'],
                    'OwnerId' => $account_info['OwnerId'],
                )
            );
            $oAccountData = $this->proxy->NewInvestmentRequest($data);
            $this->result = $oAccountData->NewInvestmentRequestResult;
            $this->request_status = $oAccountData->NewInvestmentRequestResult->ReqResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'NewInvestmentRequest',$eData)
            );
        }
    }

    public function open_SetTraderConditionPackage($account_info = array()){

        $eData = array();

        try {
            $data = array(
                'iPammTrader' =>$account_info['iPammTrader'],
                'conditionSets' => array(
                    'PTconditionPackage' => array(
                        '0'=> array(
                            'ConditionSetNumber' => $account_info['ConditionSetNumber'],
                            'IsConditionEnable'  => $account_info['IsConditionEnable'],
                            'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount'],
                            'MinInvestmentAmount' => $account_info['MinInvestmentAmount'],
                            'PenaltyPersentBack' => $account_info['PenaltyPersentBack'],
                            'ProjectShare' => $account_info['ProjectShare'],
                        )
                    )
                ),
                'minimalInvestment' => $account_info['minimalInvestment'],
                'brokerId' => $account_info['brokerId'],
            );
            $oAccountData = $this->proxy->SetTraderConditionPackage($data);
            $this->result = $oAccountData->SetTraderConditionPackageResult;
            $this->request_status = $oAccountData->SetTraderConditionPackageResult->ReqResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'SetTraderConditionPackage',$eData)
            );
        }
    }
    public function open_AcceptInvestmentRequest($account_info = array()){

        $eData = array();

        try {
            $data = array(
               'investment' => array(
                'AccountBrokerId' =>$account_info['AccountBrokerId'],
                'AccountId' => $account_info['AccountId'],
                'InvestmentAmount' => $account_info['InvestmentAmount'],
                'InvestmentId' => $account_info['InvestmentId'],
                'OwnerBrokerId' => $account_info['OwnerBrokerId'],
                'OwnerId' => $account_info['OwnerId'],
                'Profit' => $account_info['Profit'],
                'Return' => $account_info['Return'],
                'Share' => $account_info['Share'],
                'Status' => $account_info['Status'],
                'StatusDescription' => $account_info['StatusDescription'],
                'Time' => $account_info['Time']
                )
               
            );

            $oAccountData = $this->proxy->AcceptInvestmentRequest($data);
            $this->result = $oAccountData->AcceptInvestmentRequestResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'AcceptInvestmentRequest',$eData)
            );
        }
    }
    public function open_GetConditionSetOfPammTrader($account_info = array()){

        $eData = array();

        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetConditionSetOfPammTrader($data);
            $this->result = $oAccountData->GetConditionSetOfPammTraderResult;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetConditionSetOfPammTrader',$eData)
            );
        }
    }

    public function open_GetTraderCurrentInvestments($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetTraderCurrentInvestments($data);


            $this->result = $oAccountData->GetTraderCurrentInvestmentsResult;
            $this->result_array = self::get_array_object($oAccountData->GetTraderCurrentInvestmentsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTraderCurrentInvestments',$eData)
            );
        }
    }

    public function open_GetInvestmentRequestForApprovalByPT($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetInvestmentRequestForApprovalByPT($data);
            // print_r( $oAccountData);
            // exit;

            $this->result = $oAccountData->GetInvestmentRequestForApprovalByPTResult;
            $this->result_array = self::get_array_object($oAccountData->GetInvestmentRequestForApprovalByPTResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetInvestmentRequestForApprovalByPT',$eData)
            );
        }
    }
    public function open_GetTraderPastInvestments($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetTraderPastInvestments($data);
            $this->result = $oAccountData->GetTraderPastInvestmentsResult;
            $this->result_array = self::get_array_object($oAccountData->GetTraderPastInvestmentsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTraderPastInvestments',$eData)
            );
        }
    }


    public function open_GetInvestorCurrentInvestments($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammInvestor' => $account_info['iPammInvestor'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetInvestorCurrentInvestments($data);
            $this->result = $oAccountData->GetInvestorCurrentInvestmentsResult;
//            $this->result_array = self::get_array_object($oAccountData->GetInvestorCurrentInvestmentsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetInvestorCurrentInvestments',$eData)
            );
        }
    }

    public function open_GetInvestorPendingInvestments($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammInvestor' => $account_info['iPammInvestor'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetInvestorPendingInvestments($data);
            $this->result = $oAccountData->GetInvestorPendingInvestmentsResult ;
//            $this->result_array = self::get_array_object($oAccountData->GetInvestorCurrentInvestmentsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetInvestorPendingInvestments',$eData)
            );
        }
    }

    public function open_GetInvestorPastInvestments($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'iPammInvestor' => $account_info['iPammInvestor'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetInvestorPastInvestments($data);
            $this->result = $oAccountData->GetInvestorPastInvestmentsResult;
//            $this->result_array = self::get_array_object($oAccountData->GetTraderPastInvestmentsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetInvestorPastInvestments',$eData)
            );
        }
    }

    public function open_GetPammAccountInfo($account_info = array()){
        $eData = array();

        try {

            $data = array(
                'iAccount' => $account_info['iAccount'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetPammAccountInfo($data);
            $this->result = $oAccountData->GetPammAccountInfoResult;
            $this->result_array = self::get_array_object($oAccountData->GetPammAccountInfoResult);
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetPammAccountInfo',$eData)
            );
        }
    }


    public function open_RolloverByTrader($account_info = array()){
        $eData = array();

        try {

            $data = array(
                'investmentId' => $account_info['investmentId'],
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => $account_info['brokerId']
            );

            $oAccountData = $this->proxy->RolloverByTrader($data);
            $this->result = $oAccountData->RolloverByTraderResult;
            $this->result_array = self::get_array_object($oAccountData->RolloverByTraderResult);
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RolloverByTrader',$eData)
            );
        }
    }

    public function open_RolloverByInvestor($account_info = array()){
        $eData = array();

        try {

            $data = array(
                'investmentId' => $account_info['investmentId'],
                'iPammInvestor' => $account_info['iPammInvestor'],
                'brokerId' => 0
            );

            $oAccountData = $this->proxy->RolloverByInvestor($data);
            $this->result = $oAccountData->RolloverByInvestorResult;
            $this->result_array = self::get_array_object($oAccountData->RolloverByInvestorResult);
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RolloverByInvestor',$eData)
            );
        }
    }

    

    public function open_SetTraderConditionPackage3($account_info = array()){

        $eData = array();

        try {
            $data = array(
                'iPammTrader' =>$account_info['iPammTrader'],
                'conditionSets' => array(
                    'PTConditionPackage' =>
                        array(
                            'ConditionSetNumber' => 1,
                            'IsConditionEnable'  => $account_info['IsConditionEnable1'],
                            'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount1'],
                            'MinInvestmentAmount' => $account_info['MinInvestmentAmount1'],
                            'PenaltyPersentBack' => $account_info['PenaltyPersentBack1'],
                            'ProjectShare' => $account_info['ProjectShare1'],
                        ),
                    'PTConditionPackage' =>
                        array(
                            'ConditionSetNumber' => 2,
                            'IsConditionEnable'  => $account_info['IsConditionEnable2'],
                            'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount2'],
                            'MinInvestmentAmount' => $account_info['MinInvestmentAmount2'],
                            'PenaltyPersentBack' => $account_info['PenaltyPersentBack2'],
                            'ProjectShare' => $account_info['ProjectShare2'],
                        ),
                    'PTConditionPackage' =>
                        array(
                            'ConditionSetNumber' => 3,
                            'IsConditionEnable'  => $account_info['IsConditionEnable3'],
                            'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount3'],
                            'MinInvestmentAmount' => $account_info['MinInvestmentAmount3'],
                            'PenaltyPersentBack' => $account_info['PenaltyPersentBack3'],
                            'ProjectShare' => $account_info['ProjectShare3'],
                        ),
                    'PTConditionPackage' =>
                        array(
                            'ConditionSetNumber' => 4,
                            'IsConditionEnable'  => $account_info['IsConditionEnable4'],
                            'MaxInvestmentAmount' => $account_info['MaxInvestmentAmount4'],
                            'MinInvestmentAmount' => $account_info['MinInvestmentAmount4'],
                            'PenaltyPersentBack' => $account_info['PenaltyPersentBack4'],
                            'ProjectShare' => $account_info['ProjectShare4'],
                        ),
                ),
                'minimalInvestment' => $account_info['minimalInvestment'],
                'brokerId' => 0, // 0 for forexmart
            );
            $oAccountData = $this->proxy->SetTraderConditionPackage($data);
            $this->result = $oAccountData->SetTraderConditionPackageResult;
            $this->request_status = $oAccountData->SetTraderConditionPackageResult->ReqResult;
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'SetTraderConditionPackage',$eData)
            );
        }
    }
    //    PAMM API

    public function GetSupporterBonusFunds( $account_number ){

        $eData = array();
        try {
            $data = array(
                'iAccount' => $account_number, // int Account Number
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );

            $oAccountData = $this->proxy->GetSupporterBonusFundsInfo($data);
            $this->request_status = $oAccountData->GetSupporterBonusFundsInfoResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetSupporterBonusFundsInfoResult);
            return true;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetSupporterBonusFundsInfo',$eData)
            );
        }
    }

    public function open_GetPammTradersMonitoringDataCustom($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'request' => array(
                    'AccountFilter' => $account_info['AccountFilter'],
                    'Filters' => array(
                        'ActiveInvestorsFrom' => $account_info['ActiveInvestorsFrom'],
                        'ActiveInvestorsTo' => $account_info['ActiveInvestorsTo'],
                        'BalanceFrom' => $account_info['BalanceFrom'],
                        'BalanceTo' => $account_info['BalanceTo'],
                        'CurrentTradesFrom' => $account_info['CurrentTradesFrom'],
                        'CurrentTradesTo' => $account_info['CurrentTradesTo'],
                        'DailyBalFrom' => $account_info['DailyBalFrom'],
                        'DailyBalTo' => $account_info['DailyBalTo'],
                        'DailyEquityFrom' => $account_info['DailyEquityFrom'],
                        'DailyEquityTo' => $account_info['DailyEquityTo'],
                        'DailyProfitFrom' => $account_info['DailyProfitFrom'],
                        'DailyProfitTo' => $account_info['DailyProfitTo'],
                        'EquityFrom' => $account_info['EquityFrom'],
                        'EquityTo' => $account_info['EquityTo'],
                        'Month_3_ProfitFrom' => $account_info['Month_3_ProfitFrom'],
                        'Month_3_ProfitTo' => $account_info['Month_3_ProfitTo'],
                        'Month_6_ProfitFrom' => $account_info['Month_6_ProfitFrom'],
                        'Month_6_ProfitTo' => $account_info['Month_6_ProfitTo'],
                        'Month_9_ProfitFrom' => $account_info['Month_9_ProfitFrom'],
                        'Month_9_ProfitTo' => $account_info['Month_9_ProfitTo'],
                        'MonthlyProfitFrom' => $account_info['MonthlyProfitFrom'],
                        'MonthlyProfitTo' => $account_info['MonthlyProfitTo'],
                        'SimpleRatingFrom' => $account_info['SimpleRatingFrom'],
                        'SimpleRatingTo' => $account_info['SimpleRatingTo'],
                        'SinceRegisteredFrom' => $account_info['SinceRegisteredFrom'],
                        'SinceRegisteredTo' => $account_info['SinceRegisteredTo'],
                        'TotalProfitFrom' => $account_info['TotalProfitFrom'],
                        'TotalProfitTo' => $account_info['TotalProfitTo'],
                        'TotalTradesFrom' => $account_info['TotalTradesFrom'],
                        'TotalTradesTo' => $account_info['TotalTradesTo'],
                        'WeeklyProfitFrom' => $account_info['WeeklyProfitFrom'],
                        'WeeklyProfitTo' => $account_info['WeeklyProfitTo'],
                    ),
                    'HasFilterToColumns' => $account_info['HasFilterToColumns'],
                    'Limit' => $account_info['Limit'],
                    'Offset' => $account_info['Offset'],
                    'OrderByAsc' => $account_info['OrderByAsc'],
                    'OrderByColumnName' => $account_info['OrderByColumnName']
                )
            );

            $oAccountData = $this->proxy->GetPammTradersMonitoringDataCustom($data);
            $this->result = $oAccountData->GetPammTradersMonitoringDataCustomResult;
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetPammTradersMonitoringDataCustom',$eData)
            );
        }
    }
    public function open_GetLiveFeeds(){
        $eData = array();
        try {
            $oAccountData = $this->proxy->GetLiveFeeds();
            $this->result = $oAccountData->GetLiveFeedsResult;
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetLiveFeeds',$eData)
            );
        }
    }

    public function GetFristDipositTradedVolume( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['account_number'], // int Account Number
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );

            $oAccountData = $this->proxy->GetAccountTotalTradedVolume_After_Real_Fund_Deposit($data);
            $this->request_status = $oAccountData->GetAccountTotalTradedVolume_After_Real_Fund_DepositResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTotalTradedVolume_After_Real_Fund_DepositResult);
            return true;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentsCommissionByDate',$eData)
            );
        }
    }



    /**
     * Update Live Account Invite friend bouns Balance Method
     * Request result are stored in WebService::result
     */
    public function deposit_invite_A_friend_bonus( $account_number, $amount = 0, $comment = '' ){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => (float) $amount,
                    'Comment' => $comment,
                    'FundTransferAccountReceiver' => 0,
                    'Login' => $account_number,
                    'ProcessByIP' => $this->request_ip,
                    'serviceId' =>  $this->service_id,
                    'servicePassword' =>  $this->service_password
                )
            );
//            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Deposit_Invite_A_Friend_Bonus($data);
            $this->request_status = $oAccountData->Deposit_Invite_A_Friend_BonusResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Deposit_Invite_A_Friend_BonusResult);
            self::depositorInformation($account_number); // please do not delete functin cuase it's use for  Indonesian  and malysian deposit record
            return true;
        } catch (SoapFault $e)  {
            return array(
                true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Deposit_Invite_A_Friend_Bonus',$eData)
            );
        }
    }


    public function withdraw_invite_A_friend_fund($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'financeRequest' => array(
                    'Amount' => $account_info['Amount'],
                    'Comment' => $account_info['Comment'],
                    'FundTransferAccountReceiver' => $account_info['Receiver'],
                    'Login' => $account_info['AccountNumber'],
                    'ProcessByIP' => $account_info['ProcessByIP'],
                    'serviceId' => $this->service_id,
                    'servicePassword' => $this->service_password
                )
            );
            $oAccountData = $this->proxy->Withdraw_Invite_A_Friend_Fund($data);
            $this->request_status = $oAccountData->Withdraw_Invite_A_Friend_FundResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Withdraw_Invite_A_Friend_FundResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Withdraw_Invite_A_Friend_Fund',$eData)
            );
        }
    }
    public function convert_currency_amount( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'request' => array(
                    'Amount' => $account_info['amount'], // int Account Number
                    'FromCurrency' => $account_info['from_currency'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                    'ToCurrency' => $account_info['to_currency'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                    'ServiceLogin' =>  $this->service_id, //int
                    'ServicePassword' =>  $this->service_password //string
                )
            );
            $oAccountData = $this->proxy->ConvertCurrency($data);
            $this->request_status = $oAccountData->ConvertCurrencyResult->Status;
            $this->result = self::get_array_object($oAccountData->ConvertCurrencyResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ConvertCurrency',$eData)
            );
        }
    }

        public function ReqAgentStats( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iAgent' => $account_info['iLogin'],
                'serviceId' =>  $this->service_id,
                'servicePassword' =>  $this->service_password
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RequestAgentStats($merge_data);
            $this->request_status = $oAccountData->RequestAgentStatsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RequestAgentStatsResult);
            return $oAccountData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestAgentStats',$eData)
            );
        }
    }
    public function request_inactive_details( $data = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $data['iLogin']
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->Request_Inactive_Account_Details($merge_data);
            $this->request_status = $oAccountData->Request_Inactive_Account_DetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->Request_Inactive_Account_DetailsResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Request_Inactive_Account_Details',$eData)
            );
        }
    }

    public function open_RestoreInactiveAccount( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'],
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->RestoreInactiveAccount($merge_data);
            $this->request_status = $oAccountData->RestoreInactiveAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RestoreInactiveAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RestoreInactiveAccount',$eData)
            );
        }
    }

    public function RequestFinanceRecordsByTransactionIdForPamm( $data = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $data['iLogin'],
                'transactionId' => 11,
                'from' => $data['from'],
                'to' => $data['to'],
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string    
            );
            $oAccountData = $this->proxy->RequestFinanceRecordsByTransactionId($data);
            $this->request_status = $oAccountData->RequestFinanceRecordsByTransactionIdResult->ReqResult;
            $this->result = $oAccountData->RequestFinanceRecordsByTransactionIdResult->FinanceRecords->FinanceRecordData;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestFinanceRecordsByTransactionId',$eData)
            );
        }
    }

    public function GetAgentReferralTradeVolume($account_number){
        $eData = array();
        try {
            $data = array(
                'iAgent' => $account_number
            );

            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentReferredAccountsTotalVolumeTraded ($merge_data);
            $this->result = self::get_array_object($oAccountData->GetAgentReferredAccountsTotalVolumeTradedResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentReferredAccountsTotalVolumeTraded',$eData)
            );
        }
    }

    public function RequestFinanceRecordsByTransactionId( $data = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $data['iLogin'],
                'transactionId' => $data['transactionId'],
                'from' => $data['from'],
                'to' => $data['to'],
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->RequestFinanceRecordsByTransactionId($data);
            $this->request_status = $oAccountData->RequestFinanceRecordsByTransactionIdResult->ReqResult;
            $this->result = $oAccountData->RequestFinanceRecordsByTransactionIdResult->FinanceRecords->FinanceRecordData;
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RequestFinanceRecordsByTransactionId',$eData)
            );
        }
    }

    public function open_GetAgentCommissionByDate($account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentCommissionByDate($merge_data);
            $this->request_status = $oAccountData->GetAgentCommissionByDateResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentCommissionByDateResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentCommissionByDate',$eData)
            );
        }
    }
    public function open_GetAgentTotalCommissionFromAccount($account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iAgent' => $account_info['iAgent'],
                'iAccount' => $account_info['iAccount'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentTotalCommissionFromAccount($merge_data);
            $this->request_status = $oAccountData->GetAgentTotalCommissionFromAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentTotalCommissionFromAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentTotalCommissionFromAccount',$eData)
            );
        }
    }


    public function GetAgentTotalCommissionGroupByAccount($account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iAgent' => $account_info['iAgent'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $merge_data = self::set_service_auth($data);
            $oAccountData = $this->proxy->GetAgentTotalCommissionGroupByAccount ($merge_data);
            $this->request_status = $oAccountData->GetAgentTotalCommissionGroupByAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentTotalCommissionGroupByAccountResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentTotalCommissionGroupByAccount',$eData)
            );
        }
    }


    public function GetAgentsCommssionByDateForChart( $account_info = array() ){

        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );
            $oAccountData = $this->proxy->GetAgentsCommssionByDateForChart($data);
            $this->request_status = $oAccountData->GetAgentsCommssionByDateForChartResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAgentsCommssionByDateForChartResult);
            return true;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAgentsCommssionByDateForChart',$eData)
            );
        }
    }

    public function open_GetFollowerSubscriptionInfo($account_info = array()){
        $eData = array();
        $data = array(
            'iFollowerAccount' => $account_info['iFollowerAccount']
        );
        try {
            $oAccountData = $this->proxy->GetFollowerSubscriptionInfo($data);
            $this->request_status = $oAccountData->GetFollowerSubscriptionInfoResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetFollowerSubscriptionInfoResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetFollowerSubscriptionInfo',$eData)
            );
        }
    }

    public function open_GetAllFollowersOfMastersAccount(){
        $eData = array();
        try {
            $oAccountData = $this->proxy->GetAllFollowersOfMastersAccount();
            $this->request_status = $oAccountData->GetAllFollowersOfMastersAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAllFollowersOfMastersAccountResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAllFollowersOfMastersAccount',$eData)
            );
        }
    }

    public function open_GetAllMasterTradersAccount(){
        $eData = array();
        try {
            $oAccountData = $this->proxy->GetAllMasterTradersAccount();
            $this->request_status = $oAccountData->GetAllMasterTradersAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAllMasterTradersAccountResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAllMasterTradersAccount',$eData)
            );
        }
    }

    public function DeActivateMasterAccount($account_info = array()){
        $eData = array();
        $data = array(
            'iAccount' => $account_info['iAccount']
        );
        try {
            $oAccountData = $this->proxy->DeActivateMasterAccount($data);
            $this->request_status = $oAccountData->DeActivateMasterAccountResult->ReqResult;

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'DeActivateMasterAccount',$eData)
            );
        }
    }

    public function ActivateMasterAccount($account_info = array()){

        $eData = array();
        $data = array(
            'iAccount' => $account_info['iAccount']
        );
        try {
            $oAccountData = $this->proxy->ActivateMasterAccount($data);
            $this->request_status = $oAccountData->ActivateMasterAccountResult->ReqResult;


        } catch(SoapFault $e)  {
            // echo $e->getMessage();
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateMasterAccount',$eData)
            );
        }
    }

    public function RegisterAsMasterAccount($account_info = array()){
        $eData = array();
        $data = array(
            'iAccount' => $account_info['iAccount']
        );
        try {
            $oAccountData = $this->proxy->RegisterAsMasterAccount($data);
            $this->request_status = $oAccountData->RegisterAsMasterAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RegisterAsMasterAccountResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RegisterAsMasterAccount',$eData)
            );
        }
    }


    public function open_GetBalanceMonitoringDataByDate( $account_info = array() ){
        $eData = array();
        try {
            $data = array(
                'iLogin' => $account_info['iLogin'], // int Account Number
                'from' => $account_info['from'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $account_info['to'], // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'serviceId' =>  $this->service_id, //int
                'servicePassword' =>  $this->service_password //string
            );

            $oAccountData = $this->proxy->GetBalanceMonitoringDataByDate($data);


            $this->request_status = $oAccountData->GetBalanceMonitoringDataByDateResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetBalanceMonitoringDataByDateResult);
            return true;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetBalanceMonitoringDataByDate',$eData)
            );
        }
    }


   //minifcservice api method

    public function open_SubscribeToMasterAccount($account_info = array()){
        $eData = array();
        $data = array(
            'subscribeRequest' => array(
                'FollowerAccount' => $account_info['FollowerAccount'],
                'Is_NDB_Account' => $account_info['Is_NDB_Account'],
                'MasterTrader' => $account_info['MasterTrader']
            )
        );
        try {
            $oAccountData = $this->proxy->SubscribeToMasterAccount($data);

            $this->request_status = $oAccountData->SubscribeToMasterAccountResult->ReqResult;
            //            $this->result = self::get_array_object($oAccountData->SubscribeToMasterAccountResult);
        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'SubscribeToMasterAccount',$eData)
            );
        }
    }

    public function open_UnsubscribeAccount($account_info = array()){
        $eData = array();
        $data = array(
            'subscribeRequest' => array(
                'FollowerAccount' => $account_info['FollowerAccount'],
                'Is_NDB_Account' => $account_info['Is_NDB_Account'],
                'MasterTrader' => $account_info['MasterTrader']
            )
        );
        try {
            $oAccountData = $this->proxy->UnsubscribeAccount($data);
            $this->request_status = $oAccountData->UnsubscribeAccountResult->ReqResult;
            //            $this->result = self::get_array_object($oAccountData->UnsubscribeAccountResult);
        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UnsubscribeAccount',$eData)
            );
        }
    }
    public function GetAllMasterTradersAccount(){
        $eData = array();

        try {
            $oAccountData = $this->proxy->GetAllMasterTradersAccount();
            $this->request_status = $oAccountData->GetAllMasterTradersAccountResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAllMasterTradersAccountResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAllMasterTradersAccount',$eData)
            );
        }
    }


    // Forexcopy Methods
    public function Open_GetLanguageType(){
        $eData = array();

        try {
            $oAccountData = $this->proxy->GetLanguageType();
            $this->request_status = $oAccountData->GetLanguageTypeResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetLanguageTypeResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetLanguageType',$eData)
            );
        }
    }
    public function Open_GetTraderConditionConfiguration($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login']
            );
            $oAccountData = $this->proxy->GetTraderConditionConfiguration($data);
            $this->request_status = $oAccountData->GetTraderConditionConfigurationResult->RequestResult;
            $this->result = self::get_array_object($oAccountData->GetTraderConditionConfigurationResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTraderConditionConfiguration',$eData)
            );
        }
    }
    public function Open_GetTradersLatestCondition($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login']
            );
            $oAccountData = $this->proxy->GetTradersLatestCondition($data);
            $this->request_status = $oAccountData->GetTradersLatestConditionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetTradersLatestConditionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTradersLatestCondition',$eData)
            );
        }
    }
    public function Open_GetTradersConditionAtFollowersSubscription($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connectionid']
            );
            $oAccountData = $this->proxy->GetTradersConditionAtFollowersSubscription($data);
            $this->request_status = $oAccountData->GetTradersConditionAtFollowersSubscriptionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetTradersConditionAtFollowersSubscriptionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTradersConditionAtFollowersSubscription',$eData)
            );
        }
    }
    public function Open_GetAccountFCDetails($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login']
            );
            $oAccountData = $this->proxy->GetAccountFCDetails($data);
            $this->request_status = $oAccountData->GetAccountFCDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountFCDetailsResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountFCDetails',$eData)
            );
        }
    }
    public function Open_GetTraderProfile($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login'],
                'viewer' => $account_info['viewer'],
            );
            $oAccountData = $this->proxy->GetTraderProfile($data);
            $this->request_status = $oAccountData->GetTraderProfileResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetTraderProfileResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTraderProfile',$eData)
            );
        }
    }
    public function open_RegisterForexCopy($account_info = array()){
        $eData = array();

        try {

            if($account_info['IsTrader']){
                $data = array(
                    'details' => array(

                        'ProjectName' => $account_info['ProjectName'], // for trader only
                        'IsEu'        => $account_info['IsEu'],
                        'LangNotify'  => $account_info['LangNotify'],
                        'UserId'      =>  $account_info['UserId'], // client login
                        'IsTrader'    =>  $account_info['IsTrader'], //(true for trader, false for follower)
                    ),
                    'conditions'   => array( // accept 1 condition type only
                        '0'  => array(
                            'Key'   => $account_info['Commission_type'],
                            'Value' => $account_info['Commission_value'],
                        ),
//                   '1'  => array(
//                           'Key'   => 2, // Commission per 0.01 lots (profitable trades)
//                           'Value' => $account_info['conditions_values_2'],
//                   ),
//                   '2'  => array(
//                           'Key'   => 3, //Profit share (in %):
//                           'Value' => $account_info['conditions_values_3'],
//                   ),
//                   '3'  => array(
//                           'Key'   => 4, // Daily commission:
//                           'Value' => $account_info['conditions_values_4']
//                   ),
//                   '4'  => array(
//                           'Key'   => 10,  // Commission per 0.01 lots (all trades):
//                           'Value' => $account_info['conditions_values_10'],
//                   ),
//                   '5'  => array(
//                           'Key'   => 7,  // spread commission for company type
//                           'Value' => $account_info['conditions_values_7']
//                   ),
                    )
                );
            }else{
                $data = array(
                    'details' => array(

                        'ProjectName' => $account_info['ProjectName'], // for trader only
                        'IsEu'        => $account_info['IsEu'],
                        'LangNotify'  => $account_info['LangNotify'],
                        'UserId'      =>  $account_info['UserId'], // client login
                        'IsTrader'    =>  $account_info['IsTrader'], //(true for trader, false for follower)
                    )
                );
            }

         $oAccountData = $this->proxy->Register($data);
          $this->request_status = $oAccountData->RegisterResult->ReqResult;
          $this->result = self::get_array_object($oAccountData->RegisterResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Register',$eData)
            );
        }
    }
    public function open_SubscribeToTrader($account_info = array()){
        $eData = array();
        try {

            $data = array(
                'follower'    => $account_info['follower'], // for trader only
                'trader'      => $account_info['trader'],
                //'copysettings' => $account_info['copysettings'],
                'copysettings'   => array(
                    '0'  => array(
                        'Key'   => 1, // currency pairs to copy
                        'Value' =>  $account_info['copysettings_1'],
                    ),
                    '1'  => array(
                        'Key'   => 2, // scale to copy
                        'Value' => $account_info['copysettings_2'],
                    ),
                    '2'  => array(
                        'Key'   => 3, //max copy times
                        'Value' => $account_info['copysettings_3'],
                    ),
                    '3'  => array(
                        'Key'   => 5, // max open lot
                        'Value' => $account_info['copysettings_5']
                    ),
                    '4'  => array(
                        'Key'   => 6,  // Min open lot
                        'Value' => $account_info['copysettings_6'],
                    ),
                    '5'  => array(
                        'Key'   => 7,  //skip trader if outside limit
                        'Value' => $account_info['copysettings_7']
                    ),
                    '6'  => array(
                        'Key'   => 8,  //copy options
                        'Value' => $account_info['copysettings_8']
                    ),
                    '7'  => array(
                        'Key'   => 9,  //reverse
                        'Value' => $account_info['copysettings_9']
                    ),
//                           '8'  => array(
//                                   'Key'   => 10,  //auto scale
//                                   'Value' => $account_info['copysettings_10']
//                           ),
                )
            );

            //  print_r($data);



            $oAccountData = $this->proxy->SubscribeToTrader($data);
            $this->request_status = $oAccountData->SubscribeToTraderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->SubscribeToTraderResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'SubscribeToTrader',$eData)
            );
        }
    }
    public function open_UpdateCopySettings($account_info = array()){
        $eData = array();
        try {

            $data = array(
                    'connection'      => $account_info['connection'],
                    //'copysettings' => $account_info['copysettings'],
                    'copysettings'   => array(
                            '0'  => array(
                                'Key'   => 1, // currency pairs to copy
                                'Value' =>  $account_info['copysettings_1'],
                            ),
                            '1'  => array(
                               'Key'   => 2, // scale to copy
                               'Value' => $account_info['copysettings_2'],
                              ),
                           '2'  => array(
                                   'Key'   => 3, //max copy times
                                   'Value' => $account_info['copysettings_3'],
                           ),
                           '3'  => array(
                                   'Key'   => 5, // max open lot
                                   'Value' => $account_info['copysettings_5']
                           ),
                           '4'  => array(
                                   'Key'   => 6,  // Min open lot
                                   'Value' => $account_info['copysettings_6'],
                           ),
                           '5'  => array(
                                   'Key'   => 7,  //skip trader if outside limit
                                   'Value' => $account_info['copysettings_7']
                           ),
                           '6'  => array(
                                   'Key'   => 8,  //copy options
                                   'Value' => $account_info['copysettings_8']
                           ),
                           '7'  => array(
                                   'Key'   => 9,  //reverse
                                   'Value' => $account_info['copysettings_9']
                           ),
//                           '8'  => array(
//                                   'Key'   => 10,  //auto scale
//                                   'Value' => $account_info['copysettings_10']
//                           ),
                  )
            );

          //  print_r($data);



            $oAccountData = $this->proxy->UpdateCopySettings($data);
            $this->request_status = $oAccountData->UpdateCopySettingsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateCopySettingsResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateCopySettings',$eData)
            );
        }
    }
    public function open_UpdateTradersCondition($account_info = array()){
        $eData = array();
        try {

            $data = array(
                    'trader'      => $account_info['trader'],
                    'condtion'   => array( // accept 1 commission condition type only
                        '0'  => array(
                            'Key'   => $account_info['commission_type'],
                            'Value' => $account_info['commission_value'],
                        ),
                        '1'  => array(
                            'Key'   => 6, // auto approve subscription of follower
                            'Value' => $account_info['auto_subs'],
                        ),
                  )
            );

          //  print_r($data);



            $oAccountData = $this->proxy->UpdateTradersCondition($data);
            $this->request_status = $oAccountData->UpdateTradersConditionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateTradersConditionResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateTradersCondition',$eData)
            );
        }
    }
    public function open_UpdateTradersDescription($account_info = array()){
        $eData = array();
        try {

            $data = array(
                    'trader'      => $account_info['connection'],
                    'descriptions'   => array(
                        '0'  => array(
                            'Key'   => 1,
                            'Value' =>  $account_info['desc_ru'],
                        ),
                        '1'  => array(
                            'Key'   => 2,
                            'Value' => $account_info['desc_jp'],
                        ),
                        '2'  => array(
                            'Key'   => 3,
                            'Value' => $account_info['desc_pl'],
                        ),
                        '3'  => array(
                            'Key'   => 4,
                            'Value' => $account_info['desc_en']
                        )
                  )
            );

          //  print_r($data);



            $oAccountData = $this->proxy->UpdateTradersDescription($data);
            $this->request_status = $oAccountData->UpdateTradersDescriptionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateTradersDescriptionResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateTradersDescription',$eData)
            );
        }
    }
    public function open_UpdateTradersUserDetails($account_info = array()){
        $eData = array();
        try {

            $data = array(
                    'dt'   => array(
                        'UserId' => $account_info['UserId'],
                        'Icq' => $account_info['Icq'],
                        'Skype' => $account_info['Skype'],
                        'ShowIcq' => $account_info['ShowIcq'],
                        'ShowSkype' => $account_info['ShowSkype'],
                        'ProjectName' => $account_info['ProjectName'],
                        'ShowAccountName' => $account_info['ShowAccountName'],
                        'ShowDeals' => $account_info['ShowDeals'],
                        'MonitoringStart' => $account_info['MonitoringStart'],
                        'AlertUnsubscribe' => $account_info['AlertUnsubscribe'],
                  )
            );

          //  print_r($data);

            $oAccountData = $this->proxy->UpdateTradersUserDetails($data);
            $this->request_status = $oAccountData->UpdateTradersUserDetailsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdateTradersUserDetailsResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdateTradersUserDetails',$eData)
            );
        }
    }
    public function Open_GetAccountTrader($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login']
            );
            $oAccountData = $this->proxy->GetAccountTrader($data);
            $this->request_status = $oAccountData->GetAccountTraderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountTraderResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountTrader',$eData)
            );
        }
    }
    public function Open_GetAccountFollower($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login']
            );
            $oAccountData = $this->proxy->GetAccountFollower($data);
            $this->request_status = $oAccountData->GetAccountFollowerResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAccountFollowerResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAccountFollower',$eData)
            );
        }
    }
    public function Open_UpdatePendingFollower($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connection' => $account_info['connection'],
                'status' => $account_info['status'], //1 pending 2 approved 3 cancelled
            );
            $oAccountData = $this->proxy->UpdatePendingFollower($data);
            $this->request_status = $oAccountData->UpdatePendingFollowerResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UpdatePendingFollowerResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UpdatePendingFollower',$eData)
            );
        }
    }
    public function Open_UnsubscribeConnection($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connection' => $account_info['connection'],
                'who' => $account_info['who'], //1  trader 0 follower
            );
            $oAccountData = $this->proxy->UnsubscribeConnection($data);
            $this->request_status = $oAccountData->UnsubscribeConnectionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->UnsubscribeConnectionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'UnsubscribeConnection',$eData)
            );
        }
    }
    public function Open_GetTopTraders(){
        $eData = array();
        try {

            $oAccountData = $this->proxy->GetTopTraders();
            $this->request_status = $oAccountData->GetTopTradersResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetTopTradersResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTopTraders',$eData)
            );
        }
    }
    public function Open_GetUserType($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login'],
            );
            $oAccountData = $this->proxy->GetUserType($data);
            $this->request_status = $oAccountData->GetUserTypeResult->ReqResult;

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetUserType',$eData)
            );
        }
    }
    public function Open_GetFollowerCopySettings($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connection_id'],
            );
            $oAccountData = $this->proxy->GetFollowerCopySettings($data);
            $this->request_status = $oAccountData->GetFollowerCopySettingsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetFollowerCopySettingsResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetFollowerCopySettings',$eData)
            );
        }
    }
    public function Open_GetTradersConditionAtFollowerSubscription($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connection_id'],
            );
            $oAccountData = $this->proxy->GetTradersConditionAtFollowerSubscription($data);
            $this->request_status = $oAccountData->GetTradersConditionAtFollowerSubscriptionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetTradersConditionAtFollowerSubscriptionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetTradersConditionAtFollowerSubscription',$eData)
            );
        }
    }
    public function Open_GetBalanceEquityMarginHistory($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetBalanceEquityMarginHistory($data);
            $this->request_status = $oAccountData->GetBalanceEquityMarginHistoryResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetBalanceEquityMarginHistoryResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetBalanceEquityMarginHistory',$eData)
            );
        }
    }
    public function Open_GetProfitHistory($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'login' => $account_info['login'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetProfitHistory($data);
            $this->request_status = $oAccountData->GetProfitHistoryResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetProfitHistoryResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetProfitHistory',$eData)
            );
        }
    }
    public function Open_GetCloseOpenTradesFromConnection($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connection_id'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetCloseOpenTradesFromConnection($data);
            $this->request_status = $oAccountData->GetCloseOpenTradesFromConnectionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetCloseOpenTradesFromConnectionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetCloseOpenTradesFromConnection',$eData)
            );
        }
    }
    public function Open_GetOpenTrades($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connection_id'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetOpenTrades($data);
            $this->request_status = $oAccountData->GetOpenTradesResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetOpenTradesResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetOpenTrades',$eData)
            );
        }
    }
    public function Open_GetMonitoringPage(){
        $eData = array();
        try {
            $oAccountData = $this->proxy->GetMonitoringPage();
            $this->request_status = $oAccountData->GetMonitoringPageResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetMonitoringPageResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetMonitoringPage',$eData)
            );
        }
    }
    public function Open_GetAllAccountsForMonitoringPage($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'lastid' => $account_info['lastid'],
                'limit' => $account_info['limit'],
            );
            $oAccountData = $this->proxy->GetAllAccountsForMonitoringPage($data);
            $this->request_status = $oAccountData->GetAllAccountsForMonitoringPageResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetAllAccountsForMonitoringPageResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetAllAccountsForMonitoringPage',$eData)
            );
        }
    }

    public function Open_RollOver($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connectionid' => $account_info['connectionid'],
            );
            $oAccountData = $this->proxy->RollOver($data);
            $this->request_status = $oAccountData->RollOverResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->RollOverResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'RollOver',$eData)
            );
        }
    }
    public function Open_GetConnectionId($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'trader' => $account_info['trader'],
                'follower' => $account_info['follower'],
            );
            $oAccountData = $this->proxy->GetConnectionId($data);
            $this->request_status = $oAccountData->GetConnectionIdResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetConnectionIdResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetConnectionId',$eData)
            );
        }
    }
    public function Open_FcActivateTrader($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'trader' => $account_info['trader'],
            );
            $oAccountData = $this->proxy->ActivateTrader($data);
            $this->request_status = $oAccountData->ActivateTraderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->ActivateTraderResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'ActivateTrader',$eData)
            );
        }
    }
    public function Open_FcDeactivateTrader($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'trader' => $account_info['trader'],
            );
            $oAccountData = $this->proxy->DeactivateTrader($data);
            $this->request_status = $oAccountData->DeactivateTraderResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->DeactivateTraderResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'DeactivateTrader',$eData)
            );
        }
    }

    public function Open_SearchTrader($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'searchText' => $account_info['search'],
            );
            $oAccountData = $this->proxy->Search($data);
            $this->request_status = $oAccountData->SearchResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->SearchResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'Search',$eData)
            );
        }
    }

    public function Open_GetPerTradeCommission($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connection' => $account_info['connection'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetPerTradeCommission($data);
            $this->request_status = $oAccountData->GetPerTradeCommissionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetPerTradeCommissionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetPerTradeCommission',$eData)
            );
        }
    }
    public function Open_GetDailyCommission($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connection' => $account_info['connection'],
                'from' => $account_info['from'],
                'to' => $account_info['to'],
            );
            $oAccountData = $this->proxy->GetDailyCommission($data);
            $this->request_status = $oAccountData->GetDailyCommissionResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetDailyCommissionResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetDailyCommission',$eData)
            );
        }
    }

    public function Open_GetRollOverPendings($account_info = array()){
        $eData = array();
        try {
            $data = array(
                'connection' => $account_info['connection'],
            );
            $oAccountData = $this->proxy->GetRollOverPendings($data);
            $this->request_status = $oAccountData->GetRollOverPendingsResult->ReqResult;
            $this->result = self::get_array_object($oAccountData->GetRollOverPendingsResult);

        } catch(SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetRollOverPendings',$eData)
            );
        }
    }






}