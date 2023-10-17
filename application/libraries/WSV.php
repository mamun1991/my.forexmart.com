<?php

/**
 * Newest Web Service
 * Date Added: 6/22/2020
 */

class WSV{

    private $svc;
    private $request_ip;
    private $return;
    private $service_type;
    protected $serviceURL = array(
        'cabinet' => 'http://136.243.89.90:9051/Cabinet.svc?wsdl',
        'cabinet_staging' => 'http://136.243.89.90:9052/Cabinet.svc?wsdl',
        'rebate' => 'http://136.243.89.90:9758/RebateCommission.svc?wsdl',
        'finance_op' => 'http://78w.forexmart.com:9051/FinanceOpWeb.svc?singleWsdl'
    );

    private $transaction_status = array(
        'Deposit'   => 1,   //auto Credited
        'Transfer'  => 1,   //auto Credited
        'Withdraw'  => 0,   //Pending
    );

    public function __construct($configURL='cabinet'){

        $ci =& get_instance();
        $this->request_ip = $ci->input->ip_address();
        $configURL = (empty($configURL))?'cabinet':$configURL;
        self::Initialize($configURL);
        $this->return = array(
            'HasError'      => false,
            'ErrorMessage'  => null,
            'Data'          => null
        );
        $this->service_type = $configURL;

    }

    protected function Initialize( $configURL ){

        try	{

//            if($_SERVER['REMOTE_ADDR']=='49.12.5.139' && ($_SESSION['user_id']==374667) ){ //res. to test account for rebate
                $webService = $this->serviceURL[$configURL];
//            }else{
//                $webService = $this->serviceURL['cabinet'];
//            }


            $this->svc = new SoapClient($webService, array(
                'soap_version'  => 'SOAP_1_1',
                'exceptions'    => true,
                'trace'         => true,
                'features'      => SOAP_SINGLE_ELEMENT_ARRAYS
            ));
            return true;

        }catch (SoapFault $e) {
            if($_SERVER['REMOTE_ADDR']=='49.12.5.139' && ($_SESSION['user_id']==374667) ){
//                print_r($e);
            }
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }


    public function Authenticate($login, $password, $connectedAccount = 0, $isManager = false){

        try	{

            $param     = (is_numeric($login)) ? 'Login' : 'Email';
            $apiMethod = (is_numeric($login)) ? 'Authorize' : 'AuthorizeEmail';

            $authParams['request'] = array(
                'ConnectedAccount'  => $connectedAccount,
                 $param             => $login,
                'Password'          => $password,
                'IsManager'         => $isManager
            );

            $result = $this->svc->$apiMethod($authParams);

            $reqResult = self::RequestResult($result->AuthorizeResult->ReqResult);
            if($reqResult !== "RET_OK"){

                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;

                return $this->return;
            }

            $this->return['Data'] = array(
                'Login'              =>  $result->AuthorizeResult->Login,
                'ConnectedSessionId' =>  $result->AuthorizeResult->ConnectedSessionId,
                'SessionId'          =>  $result->AuthorizeResult->SessionId,
                'SessionExpire'      =>  $result->AuthorizeResult->Expiration
            );

            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

    public static function RequestResult($code){

        $reqResult = array(
            0 => 'RET_OK',
            1 => 'RET_CHAR_EXCEEDS',
            2 => 'RET_INTERNAL_ERROR',
            3 => 'RET_ORDERID_UNAVAILABLE',
            4 => 'RET_INVALID_PARAMETERS',
            5 => 'RET_ACCOUNT_NOT_FOUND',
            6 => 'RET_INVALID_PASSWORD',
            7 => 'RET_NO_DATA_TO_SHOW',
            8 => 'RET_AUTHENTICATION_FAILED',
            9 => 'RET_INVALID_SESSION',
            10 => 'RET_MT_ERROR',
            // FOREXCOPY
            11 => 'RET_NO_ROLL_OVER',
            12 => 'RET_NOT_ENOUGH_FUND',
            13 => 'RET_CONNECTION_ERROR',
            14 => 'RET_CURRENCY_ISSUE_ERROR',
            15 => 'RET_INVALID_PROJECT_NAME',
            18 => 'RET_ARCHIVED_ACCOUNT',
            20 => 'RET_TRANSFER_BLOCKED',
        );

//        if($reqResult[$code] === "RET_INVALID_SESSION"){
//            show_session_expired();
//            exit();
//        }

        return (array_key_exists($code, $reqResult)) ? $reqResult[$code] : 'System Error';
    }

    public function SetSessionID($login, $password, $isManager = false){

        /**Already applied this method on client/signin and partner/signin*/

        $ci =& get_instance();

       
            
            $connectedAccount = 0;

            if (FXPP::isCPA($login)) { // check if account is CPA Partner
                $connectedAccount = FXPP::getSubPartner($login);
            }

            $result = self::Authenticate(
                $login,
                $password,
                $connectedAccount,
                $isManager               //IsManager
            );

            $sessionId          = null;
            $connectedSessionId = null;
            $expiration         = null;
//            $expired            = null;

            if(!$result['HasError']){

                $sessionId          = $result['Data']['SessionId'];
                $connectedSessionId = $result['Data']['ConnectedSessionId'];
                $expiration         = $result['Data']['SessionExpire'];

                //Session Expiration
//                $expiration = $result['Data']['SessionExpire'];
//                $timestamp  = time();
//                $expired    = ($timestamp >= $expiration) ? true : false;

            }

//            $this->session->set_userdata("session_expired", $expired);
            $ci->session->set_userdata('session_id', $sessionId);
            $ci->session->set_userdata("session_expiration", $expiration);
            $ci->session->set_userdata('con_session_id', $connectedSessionId);
            $ci->session->set_userdata('con_account_number', $connectedAccount);





    }

    public  function GetSession($isCPA = false, $origin = 0){
        $ci =& get_instance();


        if($isCPA){
            $accountNumber = $ci->session->userdata('con_account_number');
            $sessionId     = $ci->session->userdata('con_session_id');

        }else{
            $accountNumber = $ci->session->userdata('account_number');
            $sessionId     = $ci->session->userdata('session_id');

        }
        if(isset($_SESSION['mwp_session_id'])){
            $accountNumber = $ci->session->userdata('mwp_login_userId');
            $sessionId     = $ci->session->userdata('mwp_session_id');
            $origin        = $ci->session->userdata('account_number');
        }

        if($this->service_type === 'finance_op'){
            $origin    = 0;
            $sessionId = 'q2mf2LwrdGbAeZ9g8ZcLmuQUDGV4aVcQY5T6B8qQnU2sdNtjdKnKQ3Np5wBm9NWm';
        }

        $authData =  array(
            'Origin'        => $origin,
            'Login'         => $accountNumber,
            'SessionId'     => $sessionId
        );
        return $authData;
    }

    /**
     * GetReferralsAccount Method
     * Returns referrals of account up to 2nd level referrals
     */
    public function GetReferralsAccount($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession($args['isCPA']),
                    'Accounts'          =>  isset($args['Accounts']) ?  $args['Accounts'] :  $args['isCPA'] ? [$_SESSION['con_account_number']] : [$_SESSION['account_number']], //array of account
                )
            );

            $mergedParams = array_merge_recursive($params, self::PaginationParams($args));
            $result = $this->svc->GetReferralsAccount($mergedParams);
            $this->return['ErrorMessage'] = self::RequestResult($result->GetReferralsAccountResult->ReqResult);
            $this->return['Data'] = $result->GetReferralsAccountResult;
            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }


    public function GetReferralsActivity($args = array()){
        try	{

            $params = array(
                'request' => array(
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession($args['isCPA']),
                    'Accounts'          =>  isset($args['Accounts']) ?  $args['Accounts'] :  $args['isCPA'] ? [$_SESSION['con_account_number']] : [$_SESSION['account_number']], //array of account

                )
            );

            $mergedParams = array_merge_recursive($params, self::PaginationParams($args));

            $result = $this->svc->GetReferralsActivity($mergedParams);
            $this->return['ErrorMessage'] = self::RequestResult($result->GetReferralsActivityResult->ReqResult);
            $this->return['Data'] = $result->GetReferralsActivityResult;
            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function GetAccountDetails($args = array()){ //Working

        try	{

            $params = array(
                'request' => array(
                    'ClientIp'       => $this->request_ip,
                    'SessionDetails' => self::GetSession(),
                    'Accounts'       => $args['account_number']
                )
            );

            $mergedParams = array_merge_recursive(
                $params,
                self::PaginationParams($args)
            );

            $apiMethod      = 'GetAccountDetails';
            $webFullResult  = $this->svc->$apiMethod($mergedParams)->{$apiMethod.'Result'};
                
            
            
            $this->return['ErrorMessage'] = self::RequestResult($webFullResult->ReqResult);

            $this->return['Data'] = $webFullResult->Accounts->AccountData;

//            if(self::APIUpgradeDevIP()) { //UNDER TESTING
//
//                $data = $webFullResult->Accounts->AccountData;
//
//                $regDate = array();
//                foreach($data as $key => $val){
//                    $regDate[$key]['RegDate'] = date('Y-m-d\TH:i:s', $val->RegDate);
//                }
//
//                $object = (object) $regDate;
//
//                $merge = array_merge_recursive($data, $object);
//
//            }

            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

     public function GetAccountDetails_e_Test($args = array()){ //Not Working multiple accont

        try	{

            $params = array(
                'request' => array(
                    'ClientIp'       => $this->request_ip,
                    'SessionDetails' => self::GetSession(),
                    'Accounts'       => $args['account_number']
                )
            );

            $mergedParams = array_merge_recursive(
                $params,
                self::PaginationParams($args)
            );

            $apiMethod      = 'GetAccountDetails';
            $webFullResult  = $this->svc->$apiMethod($mergedParams)->{$apiMethod.'Result'};
                
            
            $this->return['ErrorMessage'] = self::RequestResult($webFullResult->ReqResult);

            $this->return['Data'] = $webFullResult->Accounts->AccountData; 

            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }
    public function GetAccountDetailsSingle($args = array(), $serviceConfig){ //For fetching current user's details

        try	{

            if(self::APIUpgradeDevIP()) { //UNDER TESTING

                $data = array(
                    'account_number' => [$args['iLogin']]
                );

                $webFullResult = self::GetAccountDetails($data);

                   
                
                $response = $webFullResult['ErrorMessage'];

                $return = array(
                    'request_status' => $response
                );

                if($response == 'RET_OK'){
                    
                    $result="";
                    if($webFullResult['Data'])
                    {                    
                        $arrayObject = new ArrayObject($webFullResult['Data'][0]);
                        $result      = $arrayObject->getArrayCopy();
                        $result['RegDate'] = date('Y-m-d\TH:i:s', $result['RegDate']);
                     }
                    
                   

                    $return['result']  = $result;

                }else{

                    $webFullResult = new WebService($serviceConfig);
                    $webFullResult->open_RequestAccountDetails($args);

                    if($webFullResult->request_status === 'RET_ACCOUNT_NOT_FOUND'){ //Not included in new API.
                        $return['request_status'] = $webFullResult->request_status;
                    }

                }

                return (object) $return;

            }else{

                $webFullResult = new WebService($serviceConfig);
                $webFullResult->open_RequestAccountDetails($args);

                return $webFullResult;

            }

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

    public function OpenNewAccount($args = array(), $webserviceConfig = array(), $type = 'Client'){ //Working

        try	{

           // if(self::APIUpgradeDevIP()) { //UNDER TESTING


            $params = array(
                'request' => array(
                    'Email'         => $args['email'],
                    'Name'          => $args['name'],
                    'Address'       => $args['address'],
                    'AgentAccount'  => isset($args['agent']) ? $args['agent'] : 0,
                    'City'          => $args['city'],
                    'State'         => $args['state'],
                    'Country'       => $args['country'],
                    'ZipCode'       => $args['zip_code'],
                    'Type'          => $type,                   //Client | Partner
                    'Group'         => $args['group'],
                    'LeadSource'    => $args['lead_source'],
                    'Leverage'      => $args['leverage'],
                    'PhoneNumber'   => $args['phone_number'],
                    'PhonePassword' => $args['phone_password'],
                    'Comment'       => $args['comment'],
                )
            );


            $apiMethod      = 'OpenNewAccount';
                $webFullResult  = $this->svc->$apiMethod($params)->{$apiMethod.'Result'};

                $response = self::RequestResult($webFullResult->ReqResult);

                if($response == 'RET_OK'){

                    $result = array(
                        'request_status'   => $response,
                        'AccountNumber'    => $webFullResult->LogIn,
                        'TraderPassword'   => $webFullResult->TraderPassword,
                        'InvestorPassword' => $webFullResult->InvestorPassword

                    );

                    return (object) $result;

                }else{

                    $params['request']['ReqResult'] = $response;

                    $result = array(
                        'request_status' => $response,
                        'InputData'      => $params['request'],
                        'resultData'     => $webFullResult // log

                    );

                    return (object) $result;

                }

           /* }else{

                $webFullResult = new WebService($webserviceConfig);
                $webFullResult->open_account_standard($args);

                $response = $webFullResult->request_status;

                if($response === 'RET_OK'){

                    $result = array(
                        'request_status'   => $response,
                        'AccountNumber'    => $webFullResult->get_result('LogIn'),
                        'TraderPassword'   => $webFullResult->get_result('TraderPassword'),
                        'InvestorPassword' => $webFullResult->get_result('InvestorPassword'),
                    );

                    return (object) $result;

                }else{

                    $result = array(
                        'request_status' => $response,
                        'InputData'      => $webFullResult->get_all_result(),
                        'resultData'     => $webFullResult->get_all_result()
                    );

                    return (object) $result;

                }

            }*/

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }


    public function GetAccountFunds($accountNumber){

        try	{

            $params = array(
                'request' => array(
                    'Accounts'       => [$accountNumber], //1 account only
                    'ClientIp'       => $this->request_ip,
                    'SessionDetails' => self::GetSession()
                )
            );
               
            
            $apiMethod      = 'GetAccountFunds';
            $webFullResult  = $this->svc->$apiMethod($params)->{$apiMethod.'Result'};
                
            $reqResult = self::RequestResult($webFullResult->ReqResult);
                
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $webFullResult;

            return $this->return;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }
    

    public function ChangeUserMasterPassword($ApiParams, $serviceConfig = array()){ //Working

        try	{

            if(self::APIUpgradeDevIP()) { //UNDER TESTING

                $params = array(
                    'request' => array(
                        'CurrentPassword' => $ApiParams['currentMasterPass'],
                        'ClientIp'        => $this->request_ip,
                        'SessionDetails'  => self::GetSession()
                    )
                );

                $apiMethod      = 'ChangeUserMasterPassword';
                $webFullResult  = $this->svc->$apiMethod($params)->{$apiMethod.'Result'};

                $response = self::RequestResult($webFullResult->ReqResult);

                $return = array(
                    'request_status' => $response,
                    'NewPassword'    => $webFullResult->Common
                );

                return (object) $return;

            }else{

                $webFullResult = new WebService($serviceConfig);
                $webFullResult->ChangeUserMasterPasswordClient($ApiParams);

                $return = array(
                    'request_status' => $webFullResult->request_status,
                    'NewPassword'    => $ApiParams['strNewPass']
                );

                return (object) $return;

            }

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

    public function PaginationParams($args){

        $paginationParams = array(
            'request' => array(
                'From'   => isset($args['From']) ? $args['From'] : 0 ,
                'Limit'  => isset($args['Limit']) ? $args['Limit'] : 100,
                'Offset' => isset($args['Offset']) ? $args['Offset'] : 0,
                'To'     => isset($args['To']) ? $args['To'] : 0,
            )
        );

        return $paginationParams;

    }

    public function APIUpgradeDevIP(){

        $VPN_IPs = array(
            "78.46.190.237", //Menux
            "120.29.75.242", //Joya
            "195.201.40.47", //Jena
            "49.12.5.139", //Arman
            "49.12.42.32", //Jayson
            "95.217.153.171" //Bogdan
        );

        return (in_array($this->request_ip, $VPN_IPs)) ? true : false;
    }

    public function GetOpenTrades($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                    'Accounts'          => isset($args['AccountNumber'] )? array($args['AccountNumber']) : array($_SESSION['account_number']),
                )
            );
//            print_r($params); die();
            $result = $this->svc->GetOpenTrades($params);
            $reqResult = self::RequestResult($result->GetOpenTradesResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetOpenTradesResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetTradeHistory($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 20,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                    'Accounts'          => isset($args['AccountNumber'] )? array($args['AccountNumber']) : array($_SESSION['account_number']),
                )
            );

            $result = $this->svc->GetTradeHistory($params);
            $reqResult = self::RequestResult($result->GetTradeHistoryResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetTradeHistoryResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetFinanceOpHistory($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                    'Accounts'          => isset($args['AccountNumber'] )? array($args['AccountNumber']) : array($_SESSION['account_number']),
                )
            );

            $result = $this->svc->GetFinanceOpHistory($params);
            $reqResult = self::RequestResult($result->GetFinanceOpHistoryResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetFinanceOpHistoryResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }


    /**
     * GetTotalCommissionFromAllReferrals Method
     * Returns all referrals commission
     * Only use Accounts[] when requesting for specific account/s
     */

    public function GetTotalCommissionFromAllReferrals($args = array()){
            try	{
            $params = array(
                'request' => array(
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                    'Accounts'          => $args['Accounts'],

                )
            );


            $mergedParams = array_merge_recursive($params, self::PaginationParams($args));
//echo "<pre>"; print_r($mergedParams);exit;
            

            $result = $this->svc->GetTotalCommissionFromAllReferrals($mergedParams);
            $reqResult = self::RequestResult($result->GetTotalCommissionFromAllReferralsResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetTotalCommissionFromAllReferralsResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetCommissionHistory($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'Limit'             => isset($args['Limit']) ? $args['Limit']   : 0,
                    'Offset'            => isset($args['Offset']) ? $args['Offset'] : 0,
                    'From'              => isset($args['From']) ? $args['From'] : 0 ,
                    'To'                => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                    'Accounts'          => array($args['AccountNumber'])
                )
            );

            $result = $this->svc->GetCommissionHistory($params);
            $reqResult = self::RequestResult($result->GetCommissionHistoryResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetCommissionHistoryResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetAccountsTotalTradedLot($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'ClientIP'         => $this->request_ip,
                    'SessionDetails'  => $this->GetSession($args['isCPA']),
                    'Accounts'        => $args['Accounts'],
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                )
            );

            $result = $this->svc->GetAccountsTotalTradedLot($params);
            $reqResult = self::RequestResult($result->GetAccountsTotalTradedLotResult->ReqResult);
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetAccountsTotalTradedLotResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function SendMoney($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'Amount'          => $args['Amount'],
                    'Comment'         => '',
                    'IpProcess'       => $this->request_ip,
                    'Login'           => $args['Login'],
                    'Manager'         => 0,
                    'Receiver'        => $args['Receiver'],
                    'IsAccepted'      => $this->transaction_status['Transfer'],
                    'SessionDetails'  => self::GetSession(),
                )
            );

        

            $result = $this->svc->SendMoney($params);
            $reqResult = self::RequestResult($result->SendMoneyResult->ReqResult);
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->SendMoneyResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetReferralsCount($args = array()){
        try	{
            $params = array(
                'request' => array(
                    'SessionDetails'  => self::GetSession($args['isCPA']),
                    'Accounts'          =>  isset($args['Accounts']) ?  $args['Accounts'] :  $args['isCPA'] ? [$_SESSION['con_account_number']] : [$_SESSION['account_number']], //array of account

                )
            );

            $result = $this->svc->GetReferralsCount($params);
            $reqResult = self::RequestResult($result->GetReferralsCountResult->ReqResult);
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetReferralsCountResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function RequestUpdateAccountDetails($args = array()){
        try	{

            $params = array(
                'request' => array(
                    'SessionDetails'  => self::GetSession(),
                    'City'            => $args['city'],
                    'Country'         => $args['country'],
                    'Email'           => $args['email'],
                    'Name'            => $args['full_name'],
                    'PhoneNumber'     => $args['phone_number'],
                    'State'           => $args['state'],
                    'StreetAddress'   => $args['street_address'],
                    'ZipCode'         => $args['zip_code'],
                    'Comment'         => $args['comment']
                )
            );

            $result = $this->svc->RequestUpdateAccountDetails($params);
            $reqResult = self::RequestResult($result->RequestUpdateAccountDetailsResult->ReqResult);
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->RequestUpdateAccountDetailsResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

     public function RequestUpdateAccountSpeceficData($args){
         
        try{
                       
            $args['SessionDetails']=self::GetSession();               
            $params = array(
                'request' =>$args
            );
           
       
            $result = $this->svc->RequestUpdateAccountMailingSetting($params);
            $reqResult = self::RequestResult($result->RequestUpdateAccountMailingSettingResult->ReqResult);
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->RequestUpdateAccountMailingSettingResult;
            return $this->return;                        
                
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    /***********************
     * IsAccepted (Status)
     *  0 = Pending
     *  1 = Credited
     *  2 = Not Credited
     ***********************/
    public function DepositRealFund($args = array()){ //Working on callback methods 3/17/2021
        try	{

            $sessionDetails = self::GetSession();
            $sessionDetails['Login'] = $args['accountNumber']; //userdata session is not working on callback methods.

            $params = array(
                'request' => array(
                    'Amount'          => $args['amount'],
                    'Comment'         => $args['comment'],
                    'IpProcess'       => $this->request_ip,
                    'IsAccepted'      => $this->transaction_status['Deposit'],
                    'SessionDetails'  => $sessionDetails

                )
            );

            $result = $this->svc->DepositRealFund($params);
            $reqResult = self::RequestResult($result->DepositRealFundResult->ReqResult);

            $this->return['requestResult'] = $reqResult;
            $this->return['ticket'] = $result->DepositRealFundResult->Ticket;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function WithdrawRealFund($args = array()){ //Working on callback methods 3/17/2021
        try	{

            $sessionDetails = self::GetSession();
            $sessionDetails['Login'] = $args['accountNumber']; //userdata session is not working on callback methods.

            $params = array(
                'request' => array(
                    'Amount'          => $args['amount'] * -1, // require negative amount
                    'Comment'         => $args['comment'],
                    'CancellationComment' => $args['cancelComment'],
                    'IpProcess'       => $this->request_ip,
//                    'IsAccepted'      => $this->transaction_status['Withdraw'],
                    'IsAccepted'      => $args['is_accepted'],
                    'SessionDetails'  => $sessionDetails,

                )
            );

            $result = $this->svc->WithdrawRealFund($params);
            $reqResult = self::RequestResult($result->WithdrawRealFundResult->ReqResult);
            $this->return['amount'] = $result->WithdrawRealFundResult->Amount;
            $this->return['requestResult'] = $reqResult;
            $this->return['ticket'] = $result->WithdrawRealFundResult->Ticket;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function GenerateCodeForInternalTransfer($args = array()){
        try	{

            $params = array(
                'request' => array(
                    'SessionDetails'  => self::GetSession(),

                )
            );

            $result = $this->svc->GenerateCodeForInternalTransfer($params);
            $reqResult = self::RequestResult($result->GenerateCodeForInternalTransferResult->ReqResult);
            $this->return['requestResult'] = $reqResult;
            $this->return['ticket'] = $result->GenerateCodeForInternalTransferResult->Common;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    /**----------------------------------------------------------------
    *   SetAccountLeverage          | deployed under VPN/Office IP    *
    *   SetAgentAccount             |                                 *
    *   SetAccountGroup             | deployed under VPN/Office IP    *
    *   RemoveAgentAccount          | deployed under VPN/Office IP    *
    *   UpdateReadOnlyModeOfAccount | deployed under VPN/Office IP    *
    ------------------------------------------------------------------*/

    public function SetAccountDetail($args = array(), $APIMethod = "SetAccountLeverage"){

        try {

            switch($APIMethod){
                case "SetAccountLeverage":          //FXPP-12302 | Working
                    $login          = isset($args['iLogin']) ? $args['iLogin'] : 0;
                    $propertyInt    = isset($args['iLeverage']) ? $args['iLeverage'] : 0;
                    $propertyString = '';
                    break;
                case "SetAgentAccount";             //FXPP-12303: For internal
                    $login          = isset($args['AccountNumber']) ? $args['AccountNumber'] : 0;
                    $propertyInt    = isset($args['AgentAccountNumber']) ? $args['AgentAccountNumber'] : 0;
                    $propertyString = '';
                    break;
                case "SetAccountGroup":             //FXPP-12304 | Working
                    $login          = isset($args['iLogin']) ? $args['iLogin'] : 0;
                    $propertyInt    = 0;
                    $propertyString = isset($args['strGroup']) ? $args['strGroup'] : '';
                    break;
                case "RemoveAgentAccount";          //FXPP-12305 | Working
                    $login = isset($args['AccountNumber']) ? $args['AccountNumber'] : 0;
                    $propertyInt    = 0;
                    $propertyString = '';
                    break;
                case "UpdateReadOnlyModeOfAccount": //FXPP-12306 | Working
                    $login          = isset($args['AccountNumber']) ? $args['AccountNumber'] : 0;
                    $propertyInt    = isset($args['isReadOnly']) ? $args['isReadOnly'] : 1; //0 = enable, 1 = readonly
                    $propertyString = '';
                    break;
                default:
                    $login          = 0;
                    $propertyInt    = 0;
                    $propertyString = '';
                    break;
            }

            $params = array(
                'request' => array(
                    'Login'          => $login,
                    'PropertyInt'    => $propertyInt,
                    'PropertyString' => $propertyString,
                    'SessionDetails' => self::GetSession()
                )
            );

            $webFullResult  = $this->svc->$APIMethod($params)->{$APIMethod.'Result'};

            $response = self::RequestResult($webFullResult->ReqResult);

            $return['request_status'] = $response;

            return (object) $return;

        } catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    /***NEW REBATE SYSTEM API***/
    public function GetProjects( $args = array() ){
        try	{
            $params = array(
                'request' => array(
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 20,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'Type'      => isset($args['Type']) ? $args['Type'] : 'DEFAULT' ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                )
            );
            $result = $this->svc->GetProjects($params);
            $reqResult = self::RequestResult($result->GetProjectsResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetProjectsResult;
            return $this->return;
        }catch (SoapFault $e) {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetStatistics( $args = array() ){
        try	{
            $params = array(
                'request' => array(
                    'From'      => isset($args['From']) ? $args['From']   : 0,
                    'To'        => isset($args['To']) ? $args['To']   : 0,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 20,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'Type'      => isset($args['Type']) ? $args['Type'] : 'DEFAULT' ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                )
            );

                
            $result = $this->svc->GetStatistics($params);
            $reqResult = self::RequestResult($result->GetStatisticsResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->GetStatisticsResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function RequestToAddProject( $args = array() ){
        try	{
            $params = array(
                'request' => array(
                    'Client'            => isset($args['AccountNumber'] )? array($args['AccountNumber']) : '',
                    'ProjectName'       => isset($args['ProjName']) ? $args['ProjName'] : '-' ,
                    'RebateValue'       => isset($args['RebateVal']) ? $args['RebateVal'] : 0 ,
                    'Type'              => isset($args['Type']) ? $args['Type'] : 'DEFAULT' ,
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                )
            );

            $result = $this->svc->RequestToAddProject($params);
            $reqResult = self::RequestResult($result->RequestToAddProjectResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->RequestToAddProjectResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function RequestToUpdateProject( $args = array() ){
        try	{
            $params = array(
                'request' => array(
                    'Client'            => isset($args['AccountNumber'] )? $args['AccountNumber'] : 0,
                    'Event'             => isset($args['Action']) ? $args['Action'] : 'ACTIVATE' ,
                    'ProjectName'       => isset($args['ProjName']) ? $args['ProjName'] : '' ,
                    'RebateValue'       => isset($args['RebateVal']) ? $args['RebateVal'] : 0 ,
                    'Type'              => isset($args['Type']) ? $args['Type'] : 'DEFAULT' ,
                    'ClientIP'          => $this->request_ip,
                    'SessionDetails'    => self::GetSession(),
                )
            );

            $result = $this->svc->RequestToUpdateProject($params);
            $reqResult = self::RequestResult($result->RequestToUpdateProjectResult->ReqResult);
            if($reqResult !== "RET_OK"){
                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = $reqResult;
                return $this->return;
            }
            $this->return['ErrorMessage'] = $reqResult;
            $this->return['Data'] = $result->RequestToUpdateProjectResult;
            return $this->return;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function CheckPassword($ApiParams){ //FXMAIN-77

        try	{

//            if(self::APIUpgradeDevIP()) { //UNDER TESTING

                $params = array(
                    'request' => array(
                        'CurrentPassword' => $ApiParams['currentMasterPass'],
                        'ClientIp'        => $this->request_ip,
                        'SessionDetails'  => self::GetSession()
                    )
                );

                $apiMethod      = 'CheckPassword';
                $webFullResult  = $this->svc->$apiMethod($params)->{$apiMethod.'Result'};

                $response = self::RequestResult($webFullResult->ReqResult);

                return $response;
//            }

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

    public function ChangeUserMasterPasswordV2($ApiParams){ //FXMAIN-77: Accepts user input new password

        try	{

//            if(self::APIUpgradeDevIP()) { //UNDER TESTING

                $params = array(
                    'request' => array(
                        'CurrentPassword' => $ApiParams['currentMasterPass'],
                        'NewPassword'     => $ApiParams['newPassword'],
                        'ClientIp'        => $this->request_ip,
                        'SessionDetails'  => self::GetSession()
                    )
                );

                $apiMethod      = 'ChangeUserMasterPasswordV2';
                $webFullResult  = $this->svc->$apiMethod($params)->{$apiMethod.'Result'};

                $response = self::RequestResult($webFullResult->ReqResult);

                return $response;
//            }

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

    public function GetFinanceOpHistoryV2($args = array()){
        try	{

            if(IPLoc::StatusTask()){

                $params = array(
                    'request' => array(
                        'From'      => isset($args['From']) ? $args['From'] : 0 ,
                        'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                        'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                        'To'        => isset($args['To']) ? $args['To'] : 0,
                        'Accounts'  => isset($args['AccountNumber'] )? array($args['AccountNumber']) : array($_SESSION['account_number']),
                        'Ticket'    => isset($args['Ticket']) ? array($args['Ticket']) : 0,
                        'ClientIP'  => $this->request_ip,
                        'SessionDetails'    => self::GetSession()
                    )
                );

                $result = $this->svc->GetFinanceOpHistoryV2($params);
                $reqResult = self::RequestResult($result->GetFinanceOpHistoryV2Result->ReqResult);
                if($reqResult !== "RET_OK"){
                    $this->return['HasError'] = true;
                    $this->return['ErrorMessage'] = $reqResult;
                    return $this->return;
                }
                $this->return['ErrorMessage'] = $reqResult;
                $this->return['Data'] = $result->GetFinanceOpHistoryV2Result;
                return $this->return;

            }else{

                $result = self::GetFinanceOpHistory($args);
                return $result;

            }

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }

    public function ServerTime(){

        try	{

            $apiMethod      = 'ServerTime';
            $webFullResult  = $this->svc->$apiMethod()->{$apiMethod.'Result'};
            return $webFullResult;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }

 

    public function CreditBonus($args = array()){

        try {

            $opTypes = array(
                'BONUS_20_PERCENT',
                'BONUS_30_PERCENT',
                'BONUS_50_PERCENT',
                'BONUS_70_PERCENT',
                'BONUS_100_PERCENT',
                'BONUS_100_PERCENT_CONSTANT',
                'BONUS_CONTEST_MF_PRIZE',
                'BONUS_CONTEST_PRIZE',
                'BONUS_FOREXCOPY',
                'BONUS_FORUM',
                'BONUS_INVITE_A_FRIEND',
                'BONUS_NO_DEPOSIT',
                'BONUS_PROFIT',
                'BONUS_SHOWFX',
                'BONUS_SUPPORTER_PART',
                'DEPOSIT_REAL_FUND',
                'TRANSFER_REAL_FUND',
                'WITHDRAW_REAL_FUND',
                'REFUND',
                'AFFILIATE_FEE',
                'PROGRAM_CORRECION',
                'PAMM_INVESTMENT',
                'SUPPORTER_FULL',
                'COMMISSION_ADJUSTMENT',
                'SUB_IB_COMMISSION',
                'ERROR_ORDER_CANCEL',
                'FEE_COMPENSATION',
                'DELETED_TICKET',
                'NONE'
            );

            if(in_array($args['type'], $opTypes)){

                $sessionDetails = self::GetSession();
                $sessionDetails['Login'] = isset($args['accountNumber']) ? $args['accountNumber'] : 0; //userdata session is not working on callback methods.

                $params = array(
                    'request' => array(
                        'OpType'         => $args['type'],
                        'Amount'         => isset($args['amount']) ? $args['amount'] : 0,
                        'Comment'        => isset($args['comment']) ? $args['comment'] : '',
                        'IsAccepted'     => isset($args['isAccepted']) ? $args['isAccepted'] : 0,
                        'IpProcess'      => $this->request_ip,
                        'SessionDetails' => $sessionDetails
                    )
                );

                $APIMethod = 'CreditBonus';
                $webFullResult  = $this->svc->$APIMethod($params)->{$APIMethod.'Result'};

                $response = self::RequestResult($webFullResult->ReqResult);

                if($response !== 'RET_OK'){
                    $this->return['HasError'] = true;
                }

                $this->return['ErrorMessage'] = $response;
                $this->return['Data'] = $webFullResult;

                return $this->return;

            }else{

                $this->return['HasError'] = true;
                $this->return['ErrorMessage'] = 'Undefined API finance operation method.';

                return $this->return;
            }

        } catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }





}