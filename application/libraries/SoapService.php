<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SoapService  {

    private $proxy;
    public $request_status;
    public $ticket;
    public $result = array();
    private $request_ip;

    private $config_keys_allowed = array(
        'url', 'service_id', 'service_password'
    );

    protected $url;

    public function SoapService( $config = array() ){
        $ci =& get_instance();
        $this->request_ip = $ci->input->ip_address();

        try	{

            $this->url = $this->server_url[$config['server']];
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

}