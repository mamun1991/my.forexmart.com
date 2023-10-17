<?php



class Neteller
{

    private $api_key ;    
    private $on_completed = "https://my.forexmart.com/deposit/paysafe_completed";
    private $on_faild = "https://my.forexmart.com/deposit/neteller?status=faild";
    private $defalut = "https://my.forexmart.com/deposit/neteller";

    public $merchantRefNum;
    public $customer_id ;
    public $amount;
    public $currencyCode;
    public $paymentHandleToken;


    private $payment_hendle_url;    
    private $process_payment_url;
    private $payment_hendle_by_merchant_url;


    public function __construct()
    {
        $this->mode('live');
    }
    
    


    public function mode($mode = 'live'){
        

        if($mode == 'live'){
            $this->api_key = "cG1sZS0yNjYyMjI6Qi1wMS0wLTVlMjdkZjExLTAtMzAyZDAyMTUwMDgwODlkZTc4MDI2Njk5MGM5NmFlOTkyOTI4NTM2YTYwZDk0NDdiYTUwMjE0MzhjNGZhZDFjZTM5MGUwNTExM2RlNWYwM2NmZWEzNDMzMWQwZDdhZg==";
            $this->payment_hendle_url = 'https://api.paysafe.com/paymenthub/v1/paymenthandles/';            
            $this->process_payment_url = 'https://api.paysafe.com/paymenthub/v1/payments';
            $this->payment_hendle_by_merchant_url = "https://api.paysafe.com/paymenthub/v1/paymenthandles";
            
        }else{
            $this->api_key = "cG1sZS00NDQ0NzA6Qi1xYTItMC01ZTY3MzQ2Ny0wLTMwMmMwMjE0NTdhNjEzM2U1MjA2ZWIyMTRjMmU0YTE4Zjc3ZDM0M2Q4OWYxMTRmNjAyMTQwMjA5MmZiZjM1Y2M3YjcyMzkxYjAwZTQ3MjIyM2YxYjQzNWNjZDJh";
            $this->payment_hendle_url = 'https://api.test.paysafe.com/paymenthub/v1/paymenthandles/';            
            $this->process_payment_url = 'https://api.test.paysafe.com/paymenthub/v1/payments/';
            $this->payment_hendle_by_merchant_url = "https://api.test.paysafe.com/paymenthub/v1/paymenthandles";
            
        }
    }

    public function createPaymentHandle(){

        $array = array(
            'merchantRefNum'=> $this->merchantRefNum,            
            'transactionType'=>'PAYMENT',
            'neteller'=>array(
                'consumerId'=>$this->customer_id,
                'detail1Description'=>'Forexmart',
                'detail1Text'=>'Forexmart Deposit'
            ),
            'paymentType'=>'NETELLER',
            'amount'=>$this->amount,
            'currencyCode'=>$this->currencyCode,
            'customerIp'=>$_SERVER['REMOTE_ADDR'],
            
            'returnLinks'=>array(
                array('rel'=>'on_completed','href'=>$this->on_completed."?ref=".$this->merchantRefNum),
                array('rel'=>'on_failed','href'=>$this->on_faild),
                array('rel'=>'default','href'=>$this->defalut),
            ),
        );

        return $this->doProcess($this->payment_hendle_url,$array,'post');


    }

    public function getPaymentHandle($id){
        return $this->doProcess($this->payment_hendle_url.$id);
    }
    public function getPaymentHandleByMerchant(){
        return $this->doProcess($this->payment_hendle_by_merchant_url.'?merchantRefNum='.$this->merchantRefNum);
    }

    public function processPayment(){
        $array = array(
            "merchantRefNum"=> $this->merchantRefNum,
          "amount"=> $this->amount,
          "currencyCode"=> $this->currencyCode,
          "dupCheck"=> true,
          "settleWithAuth"=> true,
          "paymentHandleToken"=> $this->paymentHandleToken,
          "customerIp"=> $_SERVER['REMOTE_ADDR'],
          "description"=> "Forexmart deposit"    
        
        );

        return $this->doProcess($this->process_payment_url,$array,'post');

    }

    


    private function doProcess($url, $data=array(),$method = null)
    {
       

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        if(!is_null($method)){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Basic " . $this->api_key,
            "Simulator: EXTERNAL"

        ));

        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response;
    }



}
