<?php


class SVC{

    private $svc;
    private $request_ip;
    public $result = array();
    protected $service_url = array(
        'cabinet' => 'http://136.243.89.90:9051/Cabinet.svc?wsdl'
    );

    public function SVC(){

        $ci =& get_instance();
        $this->request_ip = $ci->input->ip_address();
        self::Initialize();

        $this->return = array(
            'HasError'      => false,
            'ErrorMessage'  => null,
            'Data'          => null
        );

    }

    protected function Initialize( ){

        try	{

            $webService = $this->service_url['cabinet'];

            $this->svc = new SoapClient($webService, array(
                'soap_version'  => 'SOAP_1_1',
                'exceptions'    => true,
                'trace'         => true,
                'features'      => SOAP_SINGLE_ELEMENT_ARRAYS
            ));

            return true;

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }

    }
    public  function GetSession(){
        $ci =& get_instance();

        $accountNumber = $ci->session->userdata('account_number');
        $sessionId = $ci->session->userdata('session_id');

        $authData =  array(
            'Login'         =>  $accountNumber,
            'SessionId'     =>  $sessionId
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

    public function GetResult(){
        return $this->result;
    }


    public function Authenticate($account_number, $password){

        try	{

            $authParams = array(
                "request" => array(
                    "Login" => $account_number,
                    "Password" => $password
                )
            );

            $result = $this->svc->Authorize($authParams);
            return  array(
                    'Login'         =>  $result->AuthorizeResult->Login,
                    'SessionId'     =>  $result->AuthorizeResult->SessionId
                    );

        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetOpenTrades($args = array()){
        try	{
            $auth = self::Authenticate($args['AccountNumber'], $args['Password']);
            $params = array(
                'request' => array(
                    'Accounts'  => $args['AccountNumber'],
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => $auth,
                )
            );

            $result = $this->svc->GetOpenTrades(array_merge($params, $auth));
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
            $auth = self::Authenticate($args['AccountNumber'], $args['Password']);
            $params = array(
                'request' => array(
                    'Accounts'  => $args['AccountNumber'],
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 20,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => $auth,
                )
            );

            $result = $this->svc->GetTradeHistory(array_merge($params, $auth));
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
    public function GetAccountDetails($args = array()){
        try	{
            $auth = self::Authenticate($args['AccountNumber'], $args['Password']);

            $params = array(
                'request' => array(
                    'Accounts'  => $args['Accounts'],
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => $auth,
                )
            );

            print_r($args);


           // SVC::Dump($params, true);
            $result = $this->svc->GetAccountDetails($params);
            return $result;
        }catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage()
            );

        }
    }
    public function GetFinanceOpHistory($args = array()){
        try	{
            $auth = self::Authenticate($args['AccountNumber'], $args['Password']);
            $params = array(
                'request' => array(
                    'Accounts'  => $args['AccountNumber'],
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => $auth,
                )
            );

            //SVC::Dump(array_merge($params, $auth) , true);
            $result = $this->svc->GetFinanceOpHistory(array_merge($params, $auth));
            return $result;
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
                    'Accounts'  =>  0,
                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 100,
                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
                    'ClientIP'  => $this->request_ip,
                    'SessionDetails'    => $this->GetSession(),
                )
            );
            print_r($params);
            $result = $this->svc->GetCommissionHistory($params);
            print_r($result);die();
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
//    public function GetCommissionHistory1($args = array()){
//        try	{
//            $params = array(
//                'request' => array(
//                    'Accounts' => 0,
//                    'Limit'     => isset($args['Limit']) ? $args['Limit']   : 0,
//                    'Offset'    => isset($args['Offset']) ? $args['Offset'] : 0,
//                    'From'      => isset($args['From']) ? $args['From'] : 0 ,
//                    'To'        => isset($args['To']) ? $args['To'] : 0 ,
//                    'ClientIP'  => $this->request_ip,
//                    'SessionDetails'    => $this->GetSession(),
//                )
//            );
//            print_r($params);
//            $result = $this->svc->GetCommissionHistory($params);
////            return $result;
//            $reqResult = self::RequestResult($result->GetCommissionHistoryResult->ReqResult);
//            print_r($result->GetCommissionHistoryResult); die();
//            if($reqResult !== "RET_OK"){
//                $this->return['HasError'] = true;
//                $this->return['ErrorMessage'] = $reqResult;
//                return $this->return;
//            }
//            $this->return['ErrorMessage'] = $reqResult;
//            $this->return['Data'] = $result->GetCommissionHistoryResult;
//            return $this->return;
//        }catch (SoapFault $e) {
//
//            return array(
//                'SOAPError' => true,
//                'Message' => $e->getMessage()
//            );
//
//        }
//    }

    public static function RequestResult($code){

        $reqResult = array(
            'RET_OK',
            'RET_CHAR_EXCEEDS',
            'RET_INTERNAL_ERROR',
            'RET_ORDERID_UNAVAILABLE',
            'RET_INVALID_PARAMETERS',
            'RET_ACCOUNT_NOT_FOUN',
            'RET_INVALID_PASSWORD',
            'RET_NO_DATA_TO_SHOW',
            'RET_AUTHENTICATION_FAILED',
            'RET_INVALID_SESSION',
            'RET_MT_ERROR',
            'RET_NO_ROLL_OVER',
            'RET_NOT_ENOUGH_FUND',
            'RET_CONNECTION_ERROR',
            'RET_CURRENCY_ISSUE_ERROR',
            'RET_INVALID_PROJECT_NAME'
        );

        return (array_key_exists($code, $reqResult)) ? $reqResult[$code] : 'System Error';
    }

}