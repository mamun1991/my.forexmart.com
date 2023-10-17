<?php

class Thunder
{
     	
private $access_type; // 0 testing, 1 production	
	 
private $username="forexmartxpay";
private $password="fuTBd4Vg";

private $txpay_id="forexmartxpay";

private $auth_username="forexmartxpay";
private $auth_password="PamPF4vd";
private $x_api_key="EKzX6wjJ";




private $callback_url="https://my.forexmart.com/deposit/thunderXPay-return";

protected $url = [
        '0' => 'https://thunderxpay.com/portal/main/local', // test portal
        '1' => 'https://portal.thunderxpay.com/main/local', // live porta
		'3' => 'https://thunderxpay.com/crm-dev', // crm test
		'4' => 'https://thunderxpay.com/crm', // crm live 
      ];
	
	
public function __construct()
{
     
}	

public function minimum_limit_per_transaction($key=false){
    $data=array(
      "THB"=>"500",  
      "LAK"=>"200000",
      "MMK"=>"50000",
      "KHR"=>"100000",
      "ZAR"=>"150", 
    );
     
    if($key)
    {
        return $data[$key];
    }else{
        return $data;
    }
}


public function maximum_limit_per_transaction($key=false){
     
    
    $data=array(
      "THB"=>"500000",  
      "LAK"=>"150000000",
      "MMK"=>"20000000",
      "KHR"=>"60000000",
      "ZAR"=>"500000", 
    );
     
    if($key)
    {
        return $data[$key];
    }else{
        return $data;
    }
}

public function getFee($amount=1,$transection_type="d"){
    
    $fee_percent=($transection_type=="d")?3:1; //[d] deposit , w==> withdraw
     
    
   $fee_amount=(($amount*$fee_percent)/100);
   
   return $fee_amount;
    
}

public function setAccessType($type)
    {
        $this->access_type = $type;
    }

    public function getAccessType()
    {
        return $this->access_type;
    }
	
public function getAPI()
    {
        return $this->url[$this->getAccessType()];
    }	
	
	 
public function getAuthData(){
	 
	 
	
	$auth_data=array(
		"username"=>$this->username,
		"password"=>$this->password,
		"auth_username"=>$this->auth_username,
		"auth_password"=>md5($this->auth_password),
		"txpay_id"=>$this->txpay_id,
		"x_api_key"=>$this->x_api_key,
		"callback_url"=>$this->callback_url,
		"api_url"=>$this->getAPI()
	
	);
	
	return $auth_data;
	
}


}
