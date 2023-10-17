<?php
class ForexCopy {

    private $svc;
    private $requestIP;
    private $serviceID = '1001';
    private $servicePassword = 'eJR5RdZfA86s4m78';
    private $session = 'abc123456';
    public $result = array();
    private $test_url;
    public $request_status;
    private $auth;
    private $return;
    protected $serviceURL = array(
        //'forexcopy' => 'http://136.243.89.90:8000/ForexCopy.svc?wsdl',
        'forexcopy' => 'http://136.243.89.90:8001/ForexCopy.svc?wsdl',
        'forexcopy_staging' => 'http://78w.forexmart.com:8000/ForexCopy.svc?wsdl',
    );

    public function __construct($configURL = 'forexcopy')
    {
        $ci =& get_instance();
        $this->requestIP = $ci->input->ip_address();
        self::Initialize($configURL);

    }


    public static function RequestResult($code){

        $reqResult = array(
            0 => 'RET_OK',
            1 => 'RET_CHAR_EXCEEDS',
            2 => 'RET_INTERNAL_ERROR',
            3 => 'RET_ORDERID_UNAVAILABLE',
            4 => 'RET_INVALID_PARAMETERS',//or RET_SUBSCRIPTION_ERROR
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
            15 => 'RET_INVALID_PROJECT_NAME', // or RET_DUPLICATE_PROJECT_NAME
            16 => 'RET_ALREADY_REGISTER',
            18 => 'RET_ARCHIVED_ACCOUNT', 
            20 => 'RET_TRANSFER_BLOCKED',

        );
        
        return is_numeric($code) ? ((array_key_exists($code, $reqResult)) ? $reqResult[$code] : $code) : $code;
    }


    protected function Initialize($configURL)
    {

        try {

            /*if(IPloc::RolloverTest()){
                $this->test_url = $this->serviceURL['forexcopy_staging'];
                $webService = $this->serviceURL['forexcopy_staging'];
            }else{*/
                $webService = $this->serviceURL[$configURL];
           // }
            
          
         
            $this->svc = new SoapClient($webService, array(
                'soap_version' => 'SOAP_1_1',
                'exceptions'   => true,
                'trace'        => true,
                'features'     => SOAP_SINGLE_ELEMENT_ARRAYS
            ));

            return true;

        } catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message'   => $e->getMessage()
            );

        }

        
    }
    public  function gets()
    {
        echo "<pre>";print_r($this->svc->__getFunctions());
    }
    /**
     * @param int $origin
     */

    public  function Authenticate(){
        $ci =& get_instance();
        
            $isManager     = $ci->session->userdata('is_manager');
            $accountNumber = $ci->session->userdata('account_number');
            $sessionId     = $ci->session->userdata('session_id');
            $origin = 0;
            $login = $accountNumber;
            if($isManager){
                $login  = $ci->session->userdata('mwp_login_userId'); // manager user_id
                $origin = $accountNumber;
                $sessionId = $ci->session->userdata('mwp_session_id'); // manager session id
            }

            $authData =  array(
                'req' => array(
                    'Session' => array(
                        'Origin'        => $origin,
                        'Login'         => $login,
                        'SessionId'     => $sessionId
                    )
                )
            );


        
       
        return $authData;
    }

    /**
     * WebService converting object to array data type.
     */
    protected function GetArrayObject($object){
        $arrayObject = new ArrayObject($object);
        return $arrayObject->getArrayCopy();
    }
    
    /**
     * Get WebService Get All Result Method
     * Returns full Result
     */

    public function GetAllResult(){
        return $this->result;
    }
    
    /**
     * Get WebService Get  Result Method
     * Returns result value based on the given field
     */
    public function GetResult( $field ){
        if( array_key_exists($field, $this->result) ) {
            return $this->result[$field];
        }else{
            return false;
        }
    }



    public function GetAllCopyTrader($args = array()){


        if($args['sortBy'] == 1) {
            $sort = 'PROFIT_ASC';
        }else if($args['sortBy'] == 2){
            $sort = 'PROFIT_DESC';
        }else if($args['sortBy'] == 3){
            $sort = 'REGISTER_DATE_ASC';
        }else if($args['sortBy'] == 4){
            $sort = 'REGISTER_DATE_DESC';
        }else{
            $sort = 'PROFIT_ASC';
        }

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Offset'     => $args['Offset'],
                'Limit'      => $args['Limit'], //prefer max 20
                'Order'      => $sort, //PROFIT or  REGISTER_DATE
                'UserId'     => $args['AccountNumber'],  //visitor account number
            )
        );

        try {
            $resultData = $this->svc->GetAllTrader(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetAllTraderResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetAllTraderResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function SearchTrader($args = array()) {

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Offset'        => $args['Offset'],
                'Limit'         => $args['Limit'], //prefer max 20
                'Order'         => 'PROFIT_DESC', //PROFIT or  REGISTER_DATE
                'SearchString'  => $args['Search'],
                'UserId'        => $args['AccountNumber'],  //visitor account number

            )
        );


        try {

            $resultData = $this->svc->SearchTrader(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->SearchTraderResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->SearchTraderResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function GetTraderCopyTerms($args = array()) {
 
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Trader'     => $args['trader'],
                'UserId'     => $args['visitor'],  //visitor account number
            )
        );
        
        try {
            $resultData = $this->svc->GetTraderCopyTerms(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetTraderCopyTermsResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetTraderCopyTermsResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function GetProfitHistory($args = array()) {
        
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Trader'     => $args['Trader'],
                'UserId'      => $args['Visitor'],  //visitor account number
            )
        );
        
        try {
           
            $resultData = $this->svc->GetProfitHistory(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetProfitHistoryResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetProfitHistoryResult);

            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetTraderUserDetails($args = array()) {

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Trader'     => $args['Trader'],
                'UserId'     => $args['Visitor'],  //visitor account number
            )
        );

        try {
            $resultData = $this->svc->GetTraderUserDetails(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetTraderUserDetailsResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetTraderUserDetailsResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function GetUserBalanceCache($args = array()) {

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Trader'     => $args['Trader']
            )
        );

        try {
            $resultData = $this->svc->GetUserBalanceCache(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetUserBalanceCacheResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetUserBalanceCacheResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function GetTraderDescription($args = array()) {

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Trader'     => $args['Trader'],
                'UserId'     => $args['Visitor'],  //visitor account number
            )
        );

        try {
            $resultData = $this->svc->GetTraderDescription(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetTraderDescriptionResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetTraderDescriptionResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetTraderForExternalPage($args = array()) {

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'Accounts'    => $args['Accounts']
            )
        );

        try {
            $resultData = $this->svc->GetTraderForExternalPage(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetTraderForExternalPageResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetTraderForExternalPageResult);
        
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetAccountType($args = array()){

        $auth = self::Authenticate();
        try {
            $resultData = $this->svc->GetAccountType($auth);
            $this->request_status = $resultData->GetAccountTypeResult->Result;


        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetConnectionsCopyTerms($args = array()) {
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'ConnectionId' => $args['ConnectionId'],
            )
        );

        try {
            $resultData = $this->svc->GetConnectionsCopyTerms(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetConnectionsCopyTermsResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetConnectionsCopyTermsResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetConnectionsCopySettings($args = array()) {
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'ConnectionId' => $args['ConnectionId'],
            )
        );

        try {
            $resultData = $this->svc->GetConnectionsCopySettings(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetConnectionsCopySettingsResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetConnectionsCopySettingsResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function UnsubscribeConnection($args = array()) {
  
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'ConnectionId' => $args['ConnectionId'],
                'UserId'       => $args['Login'],
            )
        );

        try {
        
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {
                    break;  
                }
    
                $resultData = $this->svc->UnsubscribeConnection(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UnsubscribeConnectionResult->ReqResult);
    
                $i++;
        
            }


            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function UpdatePendingFollower($args = array()){
     
        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'ConnectionId' => $args['ConnectionId'],
                'Status'      =>  $args['Status'],
                'UserId'       => $args['Login'],
            )
        );

        try {
            
        
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }
                $resultData = $this->svc->UpdatePendingFollower(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UpdatePendingFollowerResult->ReqResult);    
                $i++;
        
            }

            $this->result = self::GetArrayObject($resultData->UpdatePendingFollowerResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function UpdateCopySettings($args = array()) {

        $copySettings = array(
            'Definitions'   => array(
                '0'  => array(
                    'Key'   => 1, // currency pairs to copy
                    'Value' =>  $args['copysettings_1'],
                ),
                '1'  => array(
                    'Key'   => 2, // scale to copy
                    'Value' => $args['copysettings_2'],
                ),
                '2'  => array(
                    'Key'   => 3, //max copy times
                    'Value' => $args['copysettings_3'],
                ),
                '3'  => array(
                    'Key'   => 5, // max open lot
                    'Value' => $args['copysettings_5']
                ),
                '4'  => array(
                    'Key'   => 6,  // Min open lot
                    'Value' => $args['copysettings_6'],
                ),
                '5'  => array(
                    'Key'   => 7,  //skip trader if outside limit
                    'Value' => $args['copysettings_7']
                ),
                '6'  => array(
                    'Key'   => 8,  //copy options
                    'Value' => $args['copysettings_8']
                ),
                '7'  => array(
                    'Key'   => 9,  //reverse
                    'Value' => $args['copysettings_9']
                ),

            )
        );

        $auth = self::Authenticate();
        $params = array(
            'req' => array(
                'ConnectionId' => $args['connectionId'],
                'Definitions'  => $copySettings['Definitions'],
                'UserId'       => $args['accountNumber'],
               
            )
        );
  

        try {

        
    
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) { break;  }
    
                $resultData = $this->svc->UpdateCopySettings(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UpdateCopySettingsResult->ReqResult);
                $i++;
        
            }
        
          
            if(!in_array($this->request_status, array('RET_OK'))) {
                /*forexcopy_log*/
                FXPP::CI()->load->model('Logs_model');
                $logData = array(
                    'account_number' => $args['accountNumber'],
                    'method' => 'UpdateCopySettings',
                    'request_data' => json_encode(array_merge_recursive($params, $auth)),
                    'status' => $this->request_status,
                    'date' => FXPP::getCurrentDateTime()
                );

                FXPP::CI()->Logs_model->insert_log($table = "forexcopy_log", $logData);
            }

            $this->result = self::GetArrayObject($resultData->UpdateCopySettingsResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function UpdateTradersCondition($args = array()){
        try {

            $copySettings = array(
                'Definitions'   => array(
                    '0'  => array(
                        'Key'   => $args['commission_type'],
                        'Value' => $args['commission_value'],
                    ),

                    '1'  => array(
                        'Key'   => 6, // auto approve subscription of follower
                        'Value' => $args['auto_subs'],
                    ),
                    '2'  => array(
                        'Key'   => 5, // account for commission
                        'Value' => $args['conditions_values_5'],
                    )
                   ),
                
            );

            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Definitions'  => $copySettings['Definitions'],
                    'UserId'       => $args['trader'],

                )
            );

           $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }
                $resultData = $this->svc->UpdateTradersCondition(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UpdateTradersConditionResult->ReqResult);
                 
                $i++;
        
            }


            $this->result = self::GetArrayObject($resultData->UpdateTradersConditionResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetMyTrader($args = array()) {
        ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service
        try {

            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Offset' => $args['Offset'], //prefer max 20
                    'Limit'  => $args['Limit'], //prefer max 20
                    'UserId' => $args['AccountNumber'],

                )
            );

            $resultData = $this->svc->GetMyTrader(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetMyTraderResult->ReqResult);
            

            $this->result = self::GetArrayObject($resultData->GetMyTraderResult);
            return $resultData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetMyFollower($args = array()) {

        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Offset'      => $args['Offset'], //prefer max 20
                    'Limit'       => $args['Limit'], //prefer max 20
                    'UserId'      => $args['AccountNumber'],

                )
            );

            $resultData = $this->svc->GetMyFollower(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetMyFollowerResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetMyFollowerResult);
            return $resultData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetPastSubscription($args = array()) {
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Offset'      => $args['Offset'], //prefer max 20
                    'Limit'       => $args['Limit'], //prefer max 20
                    'UserId'      => $args['AccountNumber'],

                )
            );

            $resultData = $this->svc->GetPastSubscription(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetPastSubscriptionResult->ReqResult);
            $this->request_status = $resultData->GetPastSubscriptionResult->ReqResult;
            $this->result = self::GetArrayObject($resultData->GetPastSubscriptionResult);
            return $resultData;
        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function UpdateTradersUserDetails($args = array()){
        try {


                $auth = array(
                    'req' => array(
                        'BaseRequest' =>  self::Authenticate()['req']
                    )
                );

                $params = array(
                    'req' => array(
                        'UDetails'              => array(
                            'Icq'               => $args['Icq'],
                            'Skype'             => $args['Skype'],
                            'ShowIcq'           => $args['ShowIcq'],                            
                            'Email'           => $args['Email'],
                            'Phone'           => $args['Phone'],
                            'ShowEmail'           => $args['ShowEmail'],
                            'ShowPhone'           => $args['ShowPhone'],                            
                            'ShowSkype'         => $args['ShowSkype'],
                            'ProjectName'       => $args['ProjectName'],
                            'ShowAccountName'   => $args['ShowAccountName'],
                            'ShowDeals'         => $args['ShowDeals'],
                            'MonitoringStart'   => $args['MonitoringStart'],
                            'AlertUnsubscribe'  => $args['AlertUnsubscribe'],
                            'UserId'            =>  $args['accountNumber'], // client login
                        )
                    )
                );
               
              
                
                $i = 1;
                while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                    if (!empty($this->request_status)) {  break;   }
        
                    $resultData = $this->svc->UpdateTradersUserDetails(array_merge_recursive($params, $auth));
                    $this->request_status = self::RequestResult($resultData->UpdateTradersUserDetailsResult->ReqResult);
                   $i++;
            
                }



            $this->result = self::GetArrayObject($resultData->UpdateTradersUserDetailsResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function RegisterForexCopy($args = array()){
    
        try {

            $auth = self::Authenticate();
            if($args['IsTrader']){
                $params = array(
                    'req' => array(
                        'Definitions'   => array( // accept 1 copyterms condition only
                            '0'  => array(
                                'Key'   => $args['Commission_type'],
                                'Value' => $args['Commission_value'],
                            ),

                        ),
                        'ProjectName' => $args['ProjectName'], // for trader only
                        'UserId'      =>  $args['UserId'], // client login
                        'IsTrader'    =>  $args['IsTrader'], //(true for trader, false for follower)
                    ),

                );
            }else{
                $params = array(
                    'req' => array(
                        'ProjectName' => $args['ProjectName'], // for trader only
                        'UserId'      => $args['UserId'], // client login
                        'IsTrader'    => $args['IsTrader'], //(true for trader, false for follower)
                    )
                );
            }


            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) { break; }
            
                $resultData = $this->svc->Register(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->RegisterResult->ReqResult);            
                $i++;
        
            }


           $this->result = self::GetArrayObject($resultData->RegisterResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function ActivateTrader($args = array()){

        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'UserId'      =>  $args['accountNumber'], // client login
                )
            );

            $resultData = $this->svc->ActivateTrader(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->ActivateTraderResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->ActivateTraderResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function DeactivateTrader($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'UserId'      =>  $args['accountNumber'], // client login
                )
            );
            
//             if(IPLoc::frz(true)){
//                 echo "<pre>";print_r($auth);exit;
//             }
            
            $resultData = $this->svc->DeactivateTrader(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->DeactivateTraderResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->DeactivateTraderResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function UpdateTradersDescription($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'UserId'      =>  $args['accountNumber'], // client login
                    'Definitions'   => array(
                        '0'  => array(
                            'Key'   => 1,
                            'Value' =>  $args['desc_ru'],
                        ),
                        '1'  => array(
                            'Key'   => 2,
                            'Value' => $args['desc_jp'],
                        ),
                        '2'  => array(
                            'Key'   => 3,
                            'Value' => $args['desc_pl'],
                        ),
                        '3'  => array(
                            'Key'   => 4,
                            'Value' => $args['desc_en']
                        )
                    )
                )
            );
            
         
            
          
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }
                $resultData = $this->svc->UpdateTradersDescription(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UpdateTradersDescriptionResult->ReqResult);               
                $i++;
        
            }

            
            if(!in_array($this->request_status, array('RET_OK'))) {
                /*forexcopy_log*/
                FXPP::CI()->load->model('Logs_model');
                $logData = array(
                    'account_number' => isset($args['accountNumber']) ? $args['accountNumber'] : 0,
                    'method' => 'UpdateTradersDescription',
                    'request_data' => json_encode(array_merge_recursive($params, $auth)),
                    'status' => $this->request_status,
                    'date' => FXPP::getCurrentDateTime()
                );

                FXPP::CI()->Logs_model->insert_log($table = "forexcopy_log", $logData);
            }


            $this->result = self::GetArrayObject($resultData->UpdateTradersDescriptionResult);
            return $resultData;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function SubscribeToTrader($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Trader'      => $args['trader'],
                    'UserId'      =>  $args['follower'], // client login
                    'Definitions'   => array(
                        '0'  => array(
                            'Key'   => 1, // currency pairs to copy
                            'Value' =>  $args['copysettings_1'],
                        ),
                        '1'  => array(
                            'Key'   => 2, // scale to copy
                            'Value' => $args['copysettings_2'],
                        ),
                        '2'  => array(
                            'Key'   => 3, //max copy times
                            'Value' => $args['copysettings_3'],
                        ),
                        '3'  => array(
                            'Key'   => 5, // max open lot
                            'Value' => $args['copysettings_5']
                        ),
                        '4'  => array(
                            'Key'   => 6,  // Min open lot
                            'Value' => $args['copysettings_6'],
                        ),
                        '5'  => array(
                            'Key'   => 7,  //skip trader if outside limit
                            'Value' => $args['copysettings_7']
                        ),
                        '6'  => array(
                            'Key'   => 8,  //copy options
                            'Value' => $args['copysettings_8']
                        ),
                        '7'  => array(
                            'Key'   => 9,  //reverse
                            'Value' => $args['copysettings_9']
                        ),

                    )
                )
            );
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }
                
                $resultData = $this->svc->SubscribeToTrader(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->SubscribeToTraderResult->ReqResult);
                        
                $i++;
        
            }

            $this->result = self::GetArrayObject($resultData->SubscribeToTraderResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetBalanceHistory($args = array()) {
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Trader'     => $args['Trader'],
                    'UserId'      => $args['Visitor'],  //visitor account number
                )
            );
            $resultData = $this->svc->GetBalanceHistory(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetBalanceHistoryResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetBalanceHistoryResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetCloseTradesFromConnection($args = array()) {
        try {

            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'ConnectionId' => $args['ConnectionId'],
                    'Offset'      => $args['Offset'], //prefer max 20
                    'Limit'       => $args['Limit'], //prefer max 20
                )
            );
            $resultData = $this->svc->GetCloseTradesFromConnection(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetCloseTradesFromConnectionResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetCloseTradesFromConnectionResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetOpenTradesFromConnection($args = array()) {
        try {

            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'ConnectionId' => $args['ConnectionId'],
                    'Offset'      => $args['Offset'], //prefer max 20
                    'Limit'       => $args['Limit'], //prefer max 20
                )
            );
            $resultData = $this->svc->GetOpenTradesFromConnection(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetOpenTradesFromConnectionResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetOpenTradesFromConnectionResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetRollOverProfit($args = array()) {

        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'ConnectionId' => $args['ConnectionId'],
                )
            );
            $resultData = $this->svc->GetRollOverProfit(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetRollOverProfitResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetRollOverProfitResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    public function GetAccountsBalance($args = array()) {
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Accounts' => $args['Accounts'],
                )
            );
            $resultData = $this->svc->GetAccountsBalance(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetAccountsBalanceResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetAccountsBalanceResult);
            return $resultData;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function GetTicketInfo($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'ConnectionId' => $args['connectionId'],
                    'Ticket'      => $args['ticket'],
                )
            );
            
            $resultData = $this->svc->GetTicketInfo(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetTicketInfoResult->ReqResult);
            $this->result = self::GetArrayObject($resultData->GetTicketInfoResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


    public function GetConnectionId($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'UserId'      =>  $args['visitor'], // client login
                    'Trader'      => $args['trader'],
                )
            );


        
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }

                $resultData = $this->svc->GetConnectionId(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->GetConnectionIdResult->ReqResult);
    
                        
                $i++;
        
            }



            if(!in_array($this->request_status, array('RET_OK'))) {
                /*forexcopy_log*/
                FXPP::CI()->load->model('Logs_model');
                $logData = array(
                    'account_number' => isset($args['visitor']) ? $args['visitor'] : 0,
                    'method' => 'GetConnectionId',
                    'request_data' => json_encode(array_merge_recursive($params, $auth)),
                    'status' => $this->request_status,
                    'date' => FXPP::getCurrentDateTime()
                );

                FXPP::CI()->Logs_model->insert_log($table = "forexcopy_log", $logData);
            }

            $this->result = self::GetArrayObject($resultData->GetConnectionIdResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    public function PayRollOver($args = array()){
        try {
         
         
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'ConnectionId' => $args['connectionId'],
                    'UserId'      => $args['trader'],
                )
            );


            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }

                $resultData = $this->svc->PayRollOver(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->PayRollOverResult->ReqResult);
                        
                $i++;
        
            }

              //if(!in_array($this->request_status, array('RET_OK'))) {
                /*forexcopy_log*/
                FXPP::CI()->load->model('Logs_model');
                $logData = array(
                    'account_number' => isset($args['trader']) ? $args['trader'] : 0,            
                    'method' => 'PayRollOver',
                    'request_data' => json_encode(array_merge_recursive($params, $auth)),
                    'status' => $this->request_status,
                    'date' => FXPP::getCurrentDateTime()
                );

                FXPP::CI()->Logs_model->insert_log($table = "forexcopy_log", $logData);
           // }

  
            $this->result = self::GetArrayObject($resultData->PayRollOverResult);
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

   

    public function UpdateRollOverStatus($args = array()){
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Status' => $args['status'],
                   
                )
            );


            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }

                $resultData = $this->svc->UpdateRollOverStatus(array_merge_recursive($params, $auth));
                $this->request_status = self::RequestResult($resultData->UpdateRollOverStatusResult->ReqResult);

                $i++;

            }

        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }


   
    public function GetMyRollOverStatus(){
        try {
            $auth = self::Authenticate();

            
            $i = 1;
            while ($i <= 3) { // FXPP-13518 - loop 3 times if result is NULL
                if (!empty($this->request_status)) {break; }

                $resultData = $this->svc->GetMyRollOverStatus($auth);
                $this->request_status = self::RequestResult($resultData->GetMyRollOverStatusResult->ReqResult);
                $i++;

            }


            return  $resultData->GetMyRollOverStatusResult->Result;
        } catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }
    
 

    public function GetMyReceivedRollOvers($args = array()) {
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Offset'     => $args['Offset'],
                    'Limit'      => $args['Limit'], //prefer max 20
                )
            );
            $resultData = $this->svc->GetMyReceivedRollOvers(array_merge_recursive($params, $auth));
            $this->request_status = self::RequestResult($resultData->GetMyReceivedRollOversResult->ReqResult);
            return $resultData->GetMyReceivedRollOversResult;
            

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }

    
    public function GetMyPaidRollOvers($args = array()) {
        try {
            $auth = self::Authenticate();
            $params = array(
                'req' => array(
                    'Offset'     => $args['Offset'],
                    'Limit'      => $args['Limit'], //prefer max 20
                )
            );

            $resultData = $this->svc->GetMyPaidRollOvers(array_merge_recursive($params, $auth));

            $this->request_status = self::RequestResult($resultData->GetMyPaidRollOversResult->ReqResult);
            return $resultData->GetMyPaidRollOversResult;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );
        }
    }




}