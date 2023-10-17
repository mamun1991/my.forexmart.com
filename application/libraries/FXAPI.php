<?php
const CABINET_STAGING_API = "http://136.243.89.90:9052/Cabinet.svc?wsdl";
const CABINET_API = "http://136.243.89.90:9051/Cabinet.svc?wsdl";
const SMART_DOLLAR = "http://136.243.89.90:9757/SmartDollar.svc?wsdl";

class FXAPI
{


  private static $login;
  private static $origin;
  private static $session_id;
  private static $clinet_ip;
  private static $objSoap;
  private static $SoapData = array();
  private static $msg;
  private static $arguments;
  
  /**
   * getSessionDetails
   *
   * @return void
   */
  public static  function getSessionDetails()
  {
    return  array(
      'SessionDetails' => array('IsManager'=>false,'Login' => self::$login, 'Origin'=> self::$origin, 'SessionId' => self::$session_id),
      'ClientIp' => self::$clinet_ip
    );


  }
  private static function setCISessionValue()
  {
    self::$origin = isset($_SESSION['mwp_session_id']) ? $_SESSION['account_number'] : 0;
    self::$login = isset($_SESSION['mwp_session_id']) ? $_SESSION['mwp_login_userId'] : $_SESSION['account_number'];
    self::$session_id = isset($_SESSION['mwp_session_id']) ? $_SESSION['mwp_session_id'] : $_SESSION['session_id'];
    self::$clinet_ip = $_SERVER['REMOTE_ADDR'];
  }

   function __construct()
  {
  }
  private function __clone()
  {
  }


  public static function RequestResult($code)
  {

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
        15 => 'RET_INVALID_PROJECT_NAME', // or RET_DUPLICATE_PROJECT_NAME,
        18 => 'RET_ARCHIVED_ACCOUNT',
        20 => 'RET_TRANSFER_BLOCKED',
    );

    return (array_key_exists($code, $reqResult)) ? $reqResult[$code] : 'System Error';
  }

  private static function resourceData()
  {
    $result = array('data' => new stdClass(), 'RET' => self::$msg);
    foreach (self::$SoapData as $d) {
      $result['data'] = $d;
      $result['RET'] = self::RequestResult($d->ReqResult);
    }
    return $result;
  }
  
  /**
   * soapParameter
   *
   * @param  mixed $parameter
   * @return void
   */
  private static function soapParameter($parameter)
  {
    self::setCISessionValue();
    $api_parameter =  array();
    foreach ($parameter as $arg) {
      $api_parameter =  $arg + self::getSessionDetails();
    }

    return $input = array('request' => $api_parameter);
  }
  
  /**
   * getData
   *
   * @param  mixed $method_name
   * @param  mixed $parameter
   * @return void
   */
  private static  function  getData($method_name, $parameter = array())
  {

    try {
      self::$arguments = array(self::soapParameter($parameter));
      self::$SoapData =  self::$objSoap->__soapCall($method_name, self::$arguments);
    } catch (SoapFault $e) {
      self::$msg = $e->getMessage();
    }

    return self::resourceData();
  }

  
  /**
   * __callStatic
   *
   * @param  mixed $name
   * @param  mixed $arguments
   * @return void
   */
  final public static function __callStatic($name, $arguments=array())
  {
    
    self::getInstance();
    return self::getData($name, $arguments);
  }
  
  /**
   * getInstance
   *
   * @param  mixed $apiUrl
   * @return void
   */
  public static function getInstance($apiUrl = CABINET_API)
  {
    if (!self::$objSoap) {     
      self::$objSoap = new SoapClient($apiUrl,array('cache_wsdl' => WSDL_CACHE_NONE));
    }    
  }

  public static function getArguments(){
    return self::$arguments;
  }
}