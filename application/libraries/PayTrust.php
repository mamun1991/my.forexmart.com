<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 3/27/19
 * Time: 4:45 PM
 */

class PayTrust {

    private  $amount;
    private  $full_name;
    private  $item_id;
    private  $country;

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
    }
    private $url = "https://api.paytrust88.com/v1/transaction/start";
    //private $key = "ZYQORxgQKSkFJQ4b6SPuBJbqs1YCwKuk";
    private $key = "ifdWdScJ6IKAg8xWjxen8uP5bEcWcXfk";
    private $key_thb = "sYo3cuXKkk37pFWCbRS5GswyD1GWihwB";
    private $key_idr = "UB0QuWMTpNcFFPyTKztYPLPH1YudmQM8";
    private $key_vnd = "xSo50Uad6lp2sHi0l6icOQP0e35zOGWt";

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }


    private function getPaymentData(){

        if($this->getCountry() == 'TH') {
            return $parameteres = json_encode(array(

                "currency"          => 'THB',
                'amount'            => $this->getAmount(),
                'item_id'           => $this->getItemId(),
                'item_description'  => "THB deposit",
                'name'              => $this->getFullName(),
                'return_url'        => 'https://my.forexmart.com/deposit/bank_transfer_thb?status=success',
                'http_post_url'     => 'https://my.forexmart.com/deposit/bank_transfer_thb_status',
                'failed_return_url' => 'https://my.forexmart.com/deposit/bank_transfer_thb?status=failed',

            ));
        }
        if($this->getCountry() == 'MY'){
            return $parameteres = json_encode(array(

                "currency"=>'MYR',
                'amount'=>$this->getAmount(),
                'item_id'=>$this->getItemId(),
                'item_description'=>"MYM deposit",
                'name'=>$this->getFullName(),
                'return_url'=>'https://my.forexmart.com/deposit/bank_transfer_myr?status=success',
                'http_post_url'=>'https://my.forexmart.com/deposit/bank_transfer_myr_status',
                'failed_return_url'=>'https://my.forexmart.com/deposit/bank_transfer_myr?status=failed',

            ));
        }
        if($this->getCountry() == 'ID'){
            return $parameteres = json_encode(array(

                "currency"              =>'IDR',
                'amount'                =>$this->getAmount(),
                'item_id'               =>$this->getItemId(),
                'item_description'      =>"IDR deposit",
                'name'                  =>$this->getFullName(),
                'return_url'            =>'https://my.forexmart.com/deposit/bank_transfer_idr?status=success',
                'http_post_url'         =>'https://my.forexmart.com/deposit/bank_transfer_idr_status',
                'failed_return_url'     =>'https://my.forexmart.com/deposit/bank_transfer_idr?status=failed',

            ));
        }
        if($this->getCountry() == 'VN'){
            return $parameteres = json_encode(array(

                "currency"              =>'VND',
                'amount'                =>$this->getAmount(),
                'item_id'               =>$this->getItemId(),
                'item_description'      =>"VND deposit",
                'name'                  =>$this->getFullName(),
                'return_url'            =>'https://my.forexmart.com/deposit/bank_transfer_vnd?status=success',
                'http_post_url'         =>'https://my.forexmart.com/deposit/bank_transfer_vnd_status',
                'failed_return_url'     =>'https://my.forexmart.com/deposit/bank_transfer_vnd?status=failed',

            ));
        }

    }






    public function mymPay(){

        $url = $this->url; 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if($this->getCountry() == 'TH') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_thb);
        } elseif ($this->getCountry() == 'ID') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_idr);
        } elseif ($this->getCountry() == 'VN') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_vnd);
        } else{
            curl_setopt($ch, CURLOPT_USERPWD, $this->key);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPaymentData());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       $return = curl_exec($ch);
       

        curl_close($ch);

        if($return){
            $decode = json_decode($return,true);

           return $decode['redirect_to'];
        }else{
            return false;
        }

    }

    
    
    public function mymPayTest(){

        $url = $this->url; 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if($this->getCountry() == 'TH') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_thb);
        } elseif ($this->getCountry() == 'ID') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_idr);
        } elseif ($this->getCountry() == 'VN') {
            curl_setopt($ch, CURLOPT_USERPWD, $this->key_vnd);
        } else{
            curl_setopt($ch, CURLOPT_USERPWD, $this->key);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getPaymentData());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       $return = curl_exec($ch);
        var_dump($return); exit();

        curl_close($ch);

        if($return){
            $decode = json_decode($return,true);

           return $decode;//$decode['redirect_to'];
        }else{
            return false;
        }
        

    }

} 