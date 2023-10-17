<?php


/**
 * Cardpay REST API (3.0)
 *
*/


class CardPay {

    private  $accountCurrency;
    private  $currency;
    private  $method;
    private  $amount;
    private  $token;
    private  $url_type;
    private  $access_type;
    private  $url;
    protected $methodURL = array(
        '0' => array(
            'payment' => 'https://sandbox.cardpay.com/api/payments',
            'auth_token' => 'https://sandbox.cardpay.com/api/auth/token',
        ),
        '1' => array(
            'payment' => 'https://cardpay.com/api/payments',
            'auth_token' => 'https://cardpay.com/api/auth/token',
        )

    );

    public  function getMethodList($currency="")
    {

        $paymentMethod = array(
            'MXN' => array(
                '7ELEVEN' => '7 Eleven',
                'ALSUPER' => 'Alsuper',
                'BANCOMER' => 'Bancomer',
                'BANORTE' => 'Banorte',
                'BENAVIDES' => 'Farmacias Benavides',
                'BODEGA' => 'Bodega Aurrera',
                'CALIMAX' => 'Calimax',
                'CIRCULOK' => 'Círculo K',
                'COMERCIALMEXICANA' => 'Comerial Mexicana',
                'DELAHORRO' => 'Farmacias del Ahorro',
                'ELASTURIANO' => 'El Asturiano',
                'EXTRA' => 'Tiendas Extra',
                'FARMROMA' => 'Farmacias Roma',
                'KIOSKO' => 'Kiosko',
                'LAMASBARATA' => 'Farmacias la más barata',
                'BANKCARD' => 'Maestro',
                'BANKCARD' => 'Mastercard',
                'PAYCASH' => 'PayCash',
//                'PAYNET' => 'PayNet', //not found
                'SAMSCLUB' => 'Sam´s Club',
                'SPEI' => 'SPEI', // africa
                'SORIANA' => 'Soriana',
                'STAMARIA' => 'Farmacias Santa María',
                'SUPERAMA' => 'Superama',
                'TELECOMM' => 'Telecomm',
                'BANKCARD' => 'Visa',
                'WALDOS' => 'Waldos',
                'WALMART' => 'Walmart',

            ),
            'NGN' => array(
                'AQRCODE ' => 'QR code',
                'DIRECTBANKINGNGA ' => 'Direct Banking Nigeria', // mandatory birthday YYYY-MM-DD.
            ),
            'UGX' => array(
                'AIRTEL' => 'Airtel',
                'MTN' => 'MTN',
                'UGANDAMOBILE' => 'Uganda Mobile Money',
            ),
            'GHS' => array(
                'AIRTEL' => 'Airtel',
                'MTN' => 'MTN',
                'TIGO' => 'Tigo',
                'VODAFONE' => 'vodafone',
            ),
            'KES' => array(
                'MPESA' => 'M-Pesa',
            ),
            'BRL' => array(
                'BOLETO' => 'Boleto', //mandatory full name,Customer CPF number.
                'DEPOSITEXPRESSBRL' => 'Deposit Express Brasil', //mandatory full name,Customer CPF number.
                'LOTERICA' => 'Loterica', // //mandatory full name,Customer CPF number.
                'BANKCARD1' => 'American Express',
                'BANKCARD2' => 'Discover',
                'BANKCARD3' => 'Hipercard',
                'BANKCARD4' => 'JCB',
                'BANKCARD5' => 'Maestro',
                'BANKCARD6' => 'UnionPay',
                'BANKCARD7' => 'dc.international',
                'BANKCARD8' => 'ELO',
                'BANKCARD9' => 'Mastercard',
                'BANKCARD10' => 'Visa',
            ),


        );
        if ($currency) {
            return isset($paymentMethod[$currency]) ? $paymentMethod[$currency] : false;
        } else {
            return false;
        }
    }
    public function getWalletCredentials(){
        if($this->getCurrency() == 'MXN'){
            if($this->getAccessType() == 1) {
                switch($this->getMethod()){
                    case '7ELEVEN':
                    case 'ALSUPER':
                    case 'BANCOMER':
                    case 'BANORTE':
                    case 'BENAVIDES':
                    case 'BODEGA':
                    case 'CALIMAX':
                    case 'CIRCULOK':
                    case 'COMERCIALMEXICANA':
                    case 'DELAHORRO':
                    case 'ELASTURIANO':
                    case 'EXTRA':
                    case 'FARMROMA':
                    case 'KIOSKO':
                    case 'LAMASBARATA':
                    case 'PAYCASH':
                    case 'PAYNET':
                    case 'SAMSCLUB':
                    case 'SORIANA':
                    case 'STAMARIA':
                    case 'SUPERAMA':
                    case 'TELECOMM':
                    case 'WALDOS':
                    case 'WALMART':

                        return array(
                            'terminal_code' => '87621',
                            'terminal_password' => 'GBd0q85HQ2yj',
                            'secret_code' => 'lI490UuCGk2y',

                        );

                        break;
                    case 'BANKCARD':
                        return array(
                            'terminal_code' => '89075',
                            'terminal_password' => '9Ga5QIJ6tc8d',
                            'secret_code' => '26T03rbAOVta',

                        );

                        break;
                    case 'SPEI':

                        return array(
                            'terminal_code' => '87675',
                            'terminal_password' => 'Y7ZM0l95zJai',
                            'secret_code' => '60Ru82wFJzMt',

                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code' => '28637',
                    'terminal_password' => '6vIMT1x5Vai9',
                    'secret_code' => '95xIoCAR1n6l',

                );

        }

        }else  if($this->getCurrency() == 'NGN') {

            if($this->getAccessType() == 1){
                switch ($this->getMethod()) {
                    case 'AQRCODE':

                        return array(
                            'terminal_code' => '87619',
                            'terminal_password' => '5UnQjb91A4Ra',
                            'secret_code' => '7lCu2A0Zcf1U',

                        );

                        break;
                    case 'DIRECTBANKINGNGA':
                        return array(
                            'terminal_code' => '87623',
                            'terminal_password' => 'ud0O2KVr3X1w',
                            'secret_code' => '235bGdkN8YJf',
                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code' => '28639',
                    'terminal_password' => 'm78lUSCeF6y5',
                    'secret_code' => 'ZAFUw78fc26y',

                );
            }

        } else  if($this->getCurrency() == 'UGX') {
            if($this->getAccessType() == 1){
                switch ($this->getMethod()) {
                    case 'AIRTEL':
                    case 'MTN':
                    case 'UGANDAMOBILE':
                        return array(
                            'terminal_code' => '87625',
                            'terminal_password' => 'VyjZeG1S37s4',
                            'secret_code' => 'pt4Lzl8S9IT2',
                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code' => '28639',
                    'terminal_password' => 'm78lUSCeF6y5',
                    'secret_code' => 'ZAFUw78fc26y',

                );
            }

        } else  if($this->getCurrency() == 'GHS') {
            if($this->getAccessType() == 1){
                switch ($this->getMethod()) {
                    case 'AIRTEL':
                    case 'MTN':
                    case 'TIGO':
                    case 'VODAFONE':
                        return array(
                            'terminal_code' => '87625',
                            'terminal_password' => 'VyjZeG1S37s4',
                            'secret_code' => 'pt4Lzl8S9IT2',
                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code' => '28639',
                    'terminal_password' => 'm78lUSCeF6y5',
                    'secret_code' => 'ZAFUw78fc26y',
                );
            }

        }
        /*else  if($this->getCurrency() == 'KES') {
            if($this->getAccessType() == 1){
                switch ($this->getMethod()) {
                    case 'MPESA':
                        return array(
                            'terminal_code' => '87625',
                            'terminal_password' => 'VyjZeG1S37s4',
                            'secret_code' => 'pt4Lzl8S9IT2',
                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code' => '28639',
                    'terminal_password' => 'm78lUSCeF6y5',
                    'secret_code' => 'ZAFUw78fc26y',

                );
            }

        }  */ //FXPP-13427


        else  if($this->getCurrency() == 'BRL') {
            if($this->getAccessType() == 1) {
                switch ($this->getMethod()) {
                    case 'BOLETO':
                        return array(
                            'terminal_code'     => '87613',
                            'terminal_password' => 'A1fw63ebE0CD',
                            'secret_code'       => 'de349xQSPO2l',
                        );

                        break;
                    case 'BANKCARD':
                        return array(
                            'terminal_code'     => '87617',
                            'terminal_password' => 'Di3g76wjQEF9',
                            'secret_code'       => 'zjSnw238O7DV',
                        );

                        break;
                    case 'DEPOSITEXPRESSBRL':
                        return array(
                            'terminal_code'     => '87615',
                            'terminal_password' => 'DbxWE3u0i15F',
                            'secret_code'       => 'G4u7jpRHT96q',
                        );

                        break;
                    case 'LOTERICA':
                        return array(
                            'terminal_code'     => '87665',
                            'terminal_password' => 'zAvfG1F8qM05',
                            'secret_code'       => '2x8eW5AJVc9y',
                        );

                        break;

                }
            }else{
                return array(
                    'terminal_code'     => '28635',
                    'terminal_password' => 'A5HvR63Dih4b',
                    'secret_code'       => 'B89kstG73SeA',
                );
            }
        }else  if($this->getCurrency() == 'EUR' || $this->getCurrency() == 'USD' || $this->getCurrency() == 'GBP') {
            if($this->getAccessType() == 0) { //test

                return array(
                    'terminal_code'     => '29661',
                    'terminal_password' => '7eHbIzE3Y02a',
                    'secret_code'       => 'n0DO6Agb1aV2',
                );

            }

        }else{
            return array(
                'terminal_code'     => 0,
                'terminal_password' => 0,
                'secret_code'       => 0,
            );
        }

        return array(
            'terminal_code'     => 0,
            'terminal_password' => 0,
            'secret_code'       => 0,
        );
    }


    public function getTotalTransactionFee(){
        // Fee computation
        switch($this->getCurrency()){
            case 'MXN':
                //Mexico cash payments: payin 7% + 1 EUR
                //Mexico bank transfer: payin 6.5% + 0.5 EUR;
                if($this->getMethod() == 'BANKCARD'){
                    $feeInterest = $this->getAmount() * 0.065;
                    $fixedFee =  FXPP::getCurrencyRate(0.05, 'EUR', $this->getAccountCurrency());
                }else if($this->getMethod() == 'SPEI'){
                    $feeInterest = $this->getAmount() * 0.06;
                    $fixedFee =  FXPP::getCurrencyRate(0.5, 'EUR', $this->getAccountCurrency());
                }else{
                    $feeInterest = $this->getAmount() * 0.07;
                    $fixedFee =  FXPP::getCurrencyRate(1, 'EUR', $this->getAccountCurrency());
                }
                $totalFee =  FXPP::roundno($feeInterest + $fixedFee, 2);
                break;
            case 'BRL':

                if($this->getMethod() == 'BANKCARD'){
                    $feeInterest = $this->getAmount() * 0.065;
                    $fixedFee =  FXPP::getCurrencyRate(0.25,'EUR', $this->getAccountCurrency());
                }elseif($this->getMethod() == 'LOTERICA'){
                    $feeInterest = $this->getAmount() * 0.07;
                    $fixedFee =  0;
                }else{ //BOLETO and DEPOSITEXPRESSBRL
                    $feeInterest = $this->getAmount() * 0.07;
                    $fixedFee =  FXPP::getCurrencyRate(1,'EUR', $this->getAccountCurrency());
                }

                $totalFee =  FXPP::roundno($feeInterest + $fixedFee, 2);
                break;
            case 'NGN':
            case 'UGX':
            case 'GHS':
                $totalFee = FXPP::roundno($this->getAmount() * 0.05,2);
                break;
            case 'KES':
                $feeInterest = $this->getAmount() * 0.05;
                $fixedFee =  FXPP::getCurrencyRate(0.35,'EUR', $this->getAccountCurrency());
                $totalFee =  FXPP::roundno($feeInterest + $fixedFee, 2);
                break;
            default:
                $totalFee = 0;
                break;


        }
        return $totalFee;
    }

  
    public function setMethod($method){
        $this->method = $method;
    }
    public function getMethod(){
       return $this->method;
    }
    public function setAccountCurrency($currency){
        $this->accountCurrency = $currency;
    }
    public function getAccountCurrency(){
       return $this->accountCurrency;
    }
    public function setAmount($amount){
        $this->amount = $amount;
    }
    public function getAmount(){
       return $this->amount;
    }

    public function setCurrency($currency){ // wallet currency
        $this->currency = $currency;
    }
    public function getCurrency(){ // wallet currency
       return $this->currency;
    }
    public function setToken($token){
        $this->token = $token;
    }
    public function getToken(){
       return $this->token;
    }

    public function setAccessType($type){
        $this->access_type = $type;
    }

    public function getAccessType(){
        return $this->access_type;
    }

    public function setUrl($type){
        $this->url_type = $type;
        $this->url = $this->methodURL[$this->getAccessType()][$type];

    }
    public function getUrl(){
       return $this->url;

    }




    public function requestAuthToken(){
        $data = $this->getWalletCredentials();
        if($data['terminal_code'] > 0){
            $requestData = "grant_type=password&terminal_code=".$data['terminal_code']."&password=" . $data['terminal_password'];

            $url = $this->getUrl();
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_USERPWD, '');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $return = curl_exec($ch);
            curl_close($ch);
            if($return){
                $decodeData = json_decode($return,true);
                return $decodeData;

            }else{
                return false;
            }
        }
        return false;
    }

    public function requestPayment($requestData){
        $url = $this->getUrl();
        $ch = curl_init($url);
        $authorization = "Authorization: Bearer ".$this->getToken();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_USERPWD, '');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        curl_close($ch);
        if($return){
            $decodeData = json_decode($return,true);
            return $decodeData;

        }else{
            return false;
        }

    }





}