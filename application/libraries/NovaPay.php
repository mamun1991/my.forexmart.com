<?php

class NovaPay {

    protected $accountIds = [
        '0' => 70030701,
        '1' => 70031001,
    ];

    protected $md5Certs = [
        '0' => 'UXkP1Wg3e7IAglDaEOzjfjO7py4WrB19nU2S6na64Xp6FMhejDrPkl5MvkQaFwv5qOvz9M8KU5oQfsnBQbMgbXAVHi4XRAFpoXHukxgU1hRdRiB8kPB78C32NNgAoHYt',
        '1' => 'kfLIQlXAKwIR8zl5PpqMPJfe3LFIIH4pqQNAl41ltKMGNPkxQcsSUBJZ91o6zhj9Nm5VZwkupFZVFTGCU7U4PjBaLw6T3GdiDvAdnVrWbp1OkjLUA0sa3U2dk15AWAAA',
    ];


    private $publicKey1 = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCVII6Aj6grvnVNm9Nba+fy1PDuvri8H8uK0Hdvm1byaH6LPP/rEIrr/3b9TBKItiyxZmLb69cIPBDfhRRlQDQpnACeoGa4q8W3ayBYo5SBu3o1ci81iRoXRHhTtiW5kWohhhEFxRdEVgX9HArp/rk33GkwgW9mACQSJjJlblp7rQIDAQAB
-----END PUBLIC KEY-----';


    private $publicKey2 = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCzpeENxnYbJsCWU55iW2i7PNtIk+76cQfbrG97KzFfyAqYa2yiix/QOHvJzWzL5svIfYM36AW/hS3ULn2W7l+myyQvTWBUEFTgWQF3DhNxdUwQrLDZHyEgXf1f6gjQJYfK/K/3jUJi2QrMlYnEQUNNIMpP/HVFobAhTg+FH/b+JwIDAQAB
-----END PUBLIC KEY-----';

    private $accessType; // 0 testing, 1 production
    protected $url = [
        '0' => 'https://uat.securecheckout.host/',
        '1' => 'https://securecheckout.host/',
    ];

    public function setAccessType($type)
    {
        $this->accessType = $type;
    }

    public function getAccessType()
    {
        return $this->accessType;
    }

    public function checkoutRequest($data)
    {

       

        $reqData = [
            'ac' =>  $this->accountIds[$this->getAccessType()],
            'tid' => $data['tid'],
            'oid' => $data['oid'],
            'des' => 'Deposit_N2P_['.$data['acc'].']',
            'amt' => sprintf('%1.2f', $data['amt']),                 
            'cur' => $data['cur'],
            's2s' => 'https://my.forexmart.com/deposit/nova2pay_notify',
            'web' => 'https://my.forexmart.com/deposit/nova2pay_return',
        ];


         $tempRequest = $reqData;
         $tempRequest['md5Key'] = $this->md5Certs[$this->getAccessType()];
         ksort($tempRequest);

        $params = $this->getSignString($tempRequest);
   
        $reqData['sig'] = strtoupper(md5($params));
        $qs = http_build_query($reqData);
        $api_base = $this->url[$this->getAccessType()].'/checkout?'. $qs;

        $insertData = ['log' => serialize($qs), 'ip' => FXPP::CI()->input->ip_address(), 'type' => 'NOVA2PAY'];
        FXPP::CI()->general_model->insertmy('fasapay_log', $insertData);
 
       
        redirect($api_base);
        
    }

    public function verifySign($data){

       $hexSign = $data['tf_sign'];
       unset($data['tf_sign']);
    
       //获取预处理字符串
       $signString = $this->getSignString($data);

       $sign = $this->hexToStr($hexSign);

       //验证签名
       if($this->getAccessType() == 1){
        $pKey = $this->publicKey2;
       }else{
        $pKey = $this->publicKey1;
       }
      
        $res = $this->checkSign($pKey,$sign,$signString);
       
        return $res;//结果为 true

    }
    

    function strToHex($string) //字符串转十六进制
    {
        $hex = "";
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }

        $hex = strtoupper($hex);
        return $hex;
    }

    function hexToStr($hex) //十六进制转字符串
    {
        $string = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $string;
    }

    /**
     * 生成签名
     * @param    string     $signString 待签名字符串
     * @param    [type]     $priKey     私钥
     * @return   string     base64结果值
     */
    function getSign($signString,$priKey){
        $privKeyId = openssl_pkey_get_private($priKey);
        $signature = '';
        openssl_sign($signString, $signature, $privKeyId);
        openssl_free_key($privKeyId);
        return base64_encode($signature);
    }

    /**
     * 校验签名
     * @param    string     $pubKey 公钥
     * @param    string     $sign   签名
     * @param    string     $toSign 待签名字符串
     * @param    string     $signature_alg 签名方式 比如 sha1WithRSAEncryption 或者sha512
     * @return   bool
     */
    function checkSign($pubKey,$sign,$toSign,$signature_alg=OPENSSL_ALGO_SHA1){
        $publicKeyId = openssl_pkey_get_public($pubKey);
        $result = openssl_verify($toSign, base64_decode($sign), $publicKeyId,$signature_alg);
        openssl_free_key($publicKeyId);
        return $result === 1 ? true : false;
    }

    /**
     * 获取待签名字符串
     * @param    array     $params 参数数组
     * @return   string
     */
    public function getSignString($params){
        unset($params['sign']);
        ksort($params);
        reset($params);

        $pairs = array();
        foreach ($params as $k => $v) {
            if(!empty($v)){
                $pairs[] = "$k=$v";
            }
        }

        return implode('&', $pairs);
    }

    /**
     * 格式化私钥
     */
    public function formatPriKey($priKey) {
        $fKey = "-----BEGIN PRIVATE KEY-----\n";
        $len = strlen($priKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($priKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END PRIVATE KEY-----";
        return $fKey;
    }

    /**
     * 格式化公钥
     */
    public function formatPubKey($pubKey) {
        $fKey = "-----BEGIN PUBLIC KEY-----\n";
        $len = strlen($pubKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($pubKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END PUBLIC KEY-----";
        return $fKey;
    }


}
