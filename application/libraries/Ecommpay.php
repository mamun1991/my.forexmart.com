<?php
/**
 * Created by PhpStorm.
 * User: Moniruzzaman
 * Date: 10/18/18
 * Time: 12:38 PM
 */

class Ecommpay {
    /*const SECRETKEY = '626ccd88881edf000736c40668c82f0ecf225e8393298593264d836a52707d02a47de185ce9e70f74512d51508045b1149330b80762b74793abb19f3dbbaac9b';
    const PROJECTID = 441;*/

    const SECRETKEY = 'f5a3fca3f40069e03220e9ad16f635b51dc7dc41ba62dc0e8366b3428aae6188f02eb72245e1ab293741d6060d8846b1184b6c06a80129e02dfa3fb2fdb2a574';
    const PROJECTID = '547';

    private $api_base_url = "https://api.ecommpay.com/";
    private $paymentpage_base_url = 'https://paymentpage.ecommpay.com/payment?';
    private  $url_list = array(
        'qiwi'=>"v2/payment/qiwi/payout",
        'yandex'=>"v2/payment/yandexmoney/payout"
    );


    public function __construct()
    {
        $CI =& get_instance();

        $CI->load->library('signatureHandler');
    }



    private $payment_id;
    private $terminal_callback_url;
    private $customer_id;
    private $customer_ip;
    private $payment_amount;
    private $payment_currency;
    private $description;
    private $account_number;
    private $success_url;
    private $decline_url;
    private $return_url;
    private $payment_type;

    /**
     * @param mixed $payment_type
     */
    public function setPaymentType($payment_type)
    {
        $this->payment_type = $payment_type;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param mixed $terminal_callback_url
     */
    public function setTerminalCallbackUrl($terminal_callback_url)
    {
        $this->terminal_callback_url = $terminal_callback_url;
    }

    /**
     * @return mixed
     */
    public function getTerminalCallbackUrl()
    {
        return $this->terminal_callback_url;
    }

    /**
     * @param mixed $success_url
     */
    public function setSuccessUrl($success_url)
    {
        $this->success_url = $success_url;
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->success_url;
    }

    /**
     * @param mixed $return_url
     */
    public function setReturnUrl($return_url)
    {
        $this->return_url = $return_url;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param mixed $payment_id
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * @param mixed $payment_currency
     */
    public function setPaymentCurrency($payment_currency)
    {
        $this->payment_currency = $payment_currency;
    }

    /**
     * @return mixed
     */
    public function getPaymentCurrency()
    {
        return $this->payment_currency;
    }

    /**
     * @param mixed $payment_amount
     */
    public function setPaymentAmount($payment_amount)
    {
        $this->payment_amount = $payment_amount;
    }

    /**
     * @return mixed
     */
    public function getPaymentAmount()
    {
        return $this->payment_amount;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $decline_url
     */
    public function setDeclineUrl($decline_url)
    {
        $this->decline_url = $decline_url;
    }

    /**
     * @return mixed
     */
    public function getDeclineUrl()
    {
        return $this->decline_url;
    }

    /**
     * @param mixed $customer_ip
     */
    public function setCustomerIp($customer_ip)
    {
        $this->customer_ip = $customer_ip;
    }

    /**
     * @return mixed
     */
    public function getCustomerIp()
    {
        return $this->customer_ip;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $account_number
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    private function getURL(){
        // https://api.ecommpay.com/v2/payment/qiwi/payout
        return isset($this->url_list[$this->getPaymentType()])? $this->api_base_url.$this->url_list[$this->getPaymentType()]:false;
    }


    private function getDataArray(){
      return  $data_array = array(
            'general'=>array(
                "project_id"=>self::PROJECTID,
                "payment_id"=> $this->getPaymentId(),
                "terminal_callback_url"=>$this->getTerminalCallbackUrl()
            ),
            'customer'=>array(
                "id"=>$this->getCustomerId(),
                "ip_address"=>$this->getCustomerIp()
            )	,
            'payment'=> array(
                "amount"=>$this->getPaymentAmount(),
                "currency"=>$this->getPaymentCurrency(),
                "description"=>$this->getDescription()
            ),
            "account"=>array(
                "number"=> $this->getAccountNumber()
            ),
          "return_url"=>array(
              "success"=>$this->getSuccessUrl(),
              "decline"=>$this->getDeclineUrl(),
              "return"=>$this->getReturnUrl()
          )

        );
    }
    private function getDataArrayPaymentPage(){
       return $data_array = array(
            "project_id"=>self::PROJECTID,
            "payment_id"=> $this->getPaymentId(),
            "payment_currency"=> $this->getPaymentCurrency(),
            "payment_amount"=> $this->getPaymentAmount(),
            "description"=> $this->getDescription(),
           "merchant_success_url"=> $this->getSuccessUrl(),
           "merchant_fail_url"=> $this->getDeclineUrl()
        );
    }
    private  function getDataArrayPaymentPageSignature(){
        $data_array = $this->getDataArrayPaymentPage();
        $signature = new signatureHandler(self::SECRETKEY);
        $data_array['signature'] =  $signature->sign($this->getDataArrayPaymentPage());
        return $data_array;
    }

    private function getDataArrayWithSignature(){
        $data_array = $this->getDataArray();
        $signature = new signatureHandler(self::SECRETKEY);
        $data_array['general']['signature'] = $signature->sign($this->getDataArray());
        return $data_array;

    }

    public function paymentPage(){
        $url = $this->paymentpage_base_url.http_build_query($this->getDataArrayPaymentPageSignature());
        redirect($url);
    }

    public function payout(){
        return $this->ecommpayPyament($this->getDataArrayWithSignature(),$this->getURL());
    }

    private function ecommpayPyament(array $data_array,$url){
        // Create the context for the request
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json",
                'content' => json_encode($data_array)
            )
        ));


        // https://api.ecommpay.com/v2/payment/qiwi/payout
        $response = file_get_contents($url, FALSE, $context);



        if($response === FALSE){
            return false;
        }

        return json_decode($response, TRUE);
    }


} 