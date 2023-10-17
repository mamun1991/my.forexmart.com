<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FXPP{

    public static function CI(){
        $CI =& get_instance();
        return $CI;
    }

    public static function bitcoinToWalletCurrency($wallet_currency='USD',$bitcoin_amount){
      
     
            $data = file_get_contents("https://apirone.com/api/v1/ticker?currency=btc");
            $respond = json_decode($data,true);
            $exchange_rate = $respond[$wallet_currency]["last"]; // Exchange rate bitcoin to general currency
            return  $to_usd = ( $bitcoin_amount * $exchange_rate);
       
    }

    public static function WalletCurrencyToBitcoin($wallet_currency='USD',$wallet_amount=0.0002){
      
           $data = file_get_contents("https://apirone.com/api/v1/tobtc?currency=".$wallet_currency."&value=".$wallet_amount);    
          return $data;        
       
    }

    public static function canCreateVirtualAccount()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('virtual_account_model');

        $user_id = $ci->session->userdata('user_id');
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);

        if ($virtual_accounts === false || count($virtual_accounts) < 5) {
            return true;
        } else {
            return false;
        }
    }
      public static function getCiSessionId()
    {
        $ci =& get_instance();
        $ci->load->database();
        
        
        $session_id=$ci->session->userdata('session_id');
        $last_generate_session_id=$ci->session->userdata('__ci_last_regenerate');
        
            if(!isset($session_id))
            {
                $session_id=$last_generate_session_id;
                
            }    
            
          return   $session_id;
    }

    public static function hasCreateVirtualAccount()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('virtual_account_model');

        $user_id = $ci->session->userdata('user_id');
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);

        if ($virtual_accounts === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function getAccountCurrencyBase()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = $ci->general_model->getAccountCurrencyBase();
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);
        if (!empty($virtual_accounts)) {
            foreach ($virtual_accounts as $account) {
                if (in_array($account['currency'], $account_currency_base)) {
                    unset($account_currency_base[$account['currency']]);
                }
            }
        }
        return $account_currency_base;
    }

    public static function getUserAccountCurrencyBase()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach ($virtual_accounts as $account) {
            $account_currency_base[$account['mt_currency_base']] = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']) . ' - ' . $account['account_number'] . '[' . number_format($account['amount'], 2) . ']';
        }
        return $account_currency_base;
    }

    public static function getCustomUserAccountCurrencyBase()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach ($virtual_accounts as $account) {
            $account_currency_base[$account['account_number']] = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']) . ' - ' . $account['account_number'] . '[' . number_format($account['amount'], 2) . ']';
        }
        return $account_currency_base;
    }

    public static function getDepositAmountOptions()
    {
        $selectOption = "";
        for ($amount = 100; $amount <= 2500; $amount += 100) {
            $selectOption = $selectOption . "<option value='" . $amount . "'>" . $amount . "</option>";
        }
        return $selectOption;
    }

    public static function getCountries()
    {



        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        return $ci->general_model->getCountries();
    }
   public static function matchData($string_data,$key_word){
       
       $string_data= (string) $string_data;
            
            $key_word = (string) $key_word;
            if(preg_match("/{$key_word}/i", $string_data)) {
               return true;
            }else{
                return false;
            }
       
   } 
    public static function getCurrentDateTime()
    {
		/*

        try {
 

            $user_localtime = self::getServerTime();

        }catch(Exception $e){
            $user_localtime = new DateTime("now");
        }

        
        $user_localtime=date('Y-m-d H:i:s', strtotime($user_localtime));
        
        
          if(FXPP::matchData($user_localtime,"1970"))
        {
             $user_localtime = date('Y-m-d H:i:s');
        } 
        
        
        return $user_localtime;
		*/
		
		   $user_localtime = date('Y-m-d H:i:s');
		
		   return $user_localtime;
		  
		
    }

    public static function getUserCountryCode()
    {


        require_once("geoip/geoipcity.inc");
        require_once("geoip/geoipregionvars.php");
        require_once("geoip/timezone.php");

        //Get remote IP
        $ip = $_SERVER['REMOTE_ADDR'];

        //Open GeoIP database and query our IP
        $gi = geoip_open(APPPATH . "libraries/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
        return geoip_country_code_by_addr($gi, $ip);
    }

    public static function getUserContinentCode(){


        require_once("geoip/geoipcity.inc");
        require_once("geoip/geoipregionvars.php");
        require_once("geoip/timezone.php");

        //Get remote IP
        $ip = $_SERVER['REMOTE_ADDR'];


        //Open GeoIP database and query our IP
        $gi = geoip_open(APPPATH . "libraries/geoip/GeoLiteCity.dat", GEOIP_STANDARD);

        $record = GeoIP_record_by_addr($gi, $ip);

        return $record->continent_code;
    }

    public static function GenerateWalletNumber()
    {
        $CI =& get_instance();
        $CI->load->model('account_model');

        $walletNum = 'FM' . self::RandomizeNumber(8);

        $unique = $CI->account_model->checkIfUniqueAccountNumber($walletNum);

        return ($unique) ? $walletNum : self::GenerateWalletNumber();
    }

    private static function RandomizeNumber($length)
    {

        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= mt_rand(0, 9);
        }

        return $random;
    }

    public function selectAccountNumberWithBalance($user_id)
    {
        $CI =& get_instance();
        $CI->load->model('account_model');
        $getAllAccountNumber = $CI->account_model->getAllAccountNumber($user_id);
        $selectOption = '';
        foreach ($getAllAccountNumber as $key => $d) {
            $d['mt_currency_base'] == 'RUB'?'RUR': $d['mt_currency_base'];
            $selectOption = $selectOption . "<option value='" . $d['account_number'] . "' data-currency='" . $d['mt_currency_base'] . "' data-balance='" . $d['amount'] . "'>" . $d['account_number'] . "</option>";
        }

        return $selectOption;
    }

    public function selectAccountNumber($user_id)
    {
        $CI =& get_instance();
        $CI->load->model('account_model');
        $getAllAccountNumber = $CI->account_model->getAllAccountNumber($user_id);
        $selectOption = '';
        foreach ($getAllAccountNumber as $key => $d) {
            $selectOption = $selectOption . "<option value='" . $d['account_number'] . "'>" . $d['account_number'] . "</option>";
        }

        return $selectOption;
    }

    public static function ForexData($fromCurr, $toCurr)
    {
        $xCurrency = $fromCurr . $toCurr;
        $yahooFinanceUrl = 'http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair = "' . $xCurrency . '"&env=store://datatables.org/alltableswithkeys';
        $xmlResult = simplexml_load_file($yahooFinanceUrl);
        $forexData = json_decode(json_encode($xmlResult), true);
        $forexResult = $forexData['results']['rate'];
        return array(
            'Name' => $forexResult['Name'],
            'Rate' => $forexResult['Rate'],
            'Date' => $forexResult['Date'],
            'Time' => $forexResult['Time']
        );
    }

    public function LoginTypeRestriction()
    {
        $CI =& get_instance();

        if ($CI->session->userdata('login_type') == 1) {
            redirect(FXPP::my_url('my-account'));
        }

    }

    public static function RandomizeCharacter($length)
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[mt_rand(0, 61)];
        }

        return $result;
    }

    public static function Neteller_token()
    {
        $CI =& get_instance();
        $user_id = $CI->session->userdata('user_id');
        if($user_id == 10293 || $user_id==127872){
            //test token
            $client_id = 'AAABUGDHVDp1nfOm';
            $client_secret = '0.SYJiEAmfWMGOwYdbWXY2Tt9kl6XVskQdKlzFaQEC9W0.BkeK2dAUpcR8fxQ-D3Avnrxidn8';
//            echo "$client_id:$client_secret<br/>";


            $curl = curl_init();

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, "https://test.api.neteller.com/v1/oauth2/token?grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_USERPWD, "$client_id:$client_secret");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Cache-Control:no-cache"));
            curl_setopt($curl, CURLOPT_POSTFIELDS, array("scope" => "default"));
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = json_decode(curl_exec($curl), true);
        }else{

          //  if(!FXPP::isAccountFromEUCountry()){  // FXPP-9987
                $client_id = 'AAABZr6SIwrJw4Kb';
                $client_secret = '0.cHosS3a9f3fdrC5JiQIF3extJ13BGLQktYGMGjRMzRw.EAAQSX1AeA7NIrb0GNWASGvTB_SN_3c';
//            }else{
//                $client_id = 'AAABUEcRwcxLAnwR';
//                $client_secret = '0.7E7StCCzlycKTmumKqW9o3SOmQlGTnUJdwDUly6kY2E.EAAQR20o93ag41VE_elH_wvNKe4nrSU';
//            }




            $curl = curl_init();

            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, "https://api.neteller.com/v1/oauth2/token?grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_USERPWD, "$client_id:$client_secret");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Cache-Control:no-cache"));
            curl_setopt($curl, CURLOPT_POSTFIELDS, array("scope" => "default"));
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $apiResponse = json_decode(curl_exec($curl), true);
        }
        return $apiResponse;
    }

    public static function Neteller_transferIn($transDetails)
    {

        $date = new DateTime();
        $merchantRefId = (string)$date->getTimestamp();
        $CI =& get_instance();
        $user_id = $CI->session->userdata('user_id');
        if($user_id == 10293){
            $service_url = "https://test.api.neteller.com/v1/transferIn";
        }else{
            $service_url = "https://api.neteller.com/v1/transferIn";
        }

        $curl = curl_init($service_url);
        $curl_post_data = array(
            "paymentMethod" => array(
                "type" => "neteller",
                "value" => $transDetails['neteller_account']
            ),
            "transaction" => array(
                "merchantRefId" => $merchantRefId,
                "amount" => $transDetails['amount'],
                "currency" => $transDetails['currency']
            ),
            "verificationCode" => $transDetails['secure_id']
        );

        $jsonDataEncoded = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        $headers = array(
            "Content-type: application/json",
            "Authorization: Bearer " . $transDetails['token']
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);

        $apiResponse = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $apiResponse;
    }

    public static function update_account_balance()
    {
        $CI =& get_instance();
        $CI->load->model('account_model');
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $user_id = $CI->session->userdata('user_id');
        $account = $CI->account_model->getAccountByUserId($user_id);
        if (count($account) > 0) {
            $webservice_config = array(
                'server' => 'live_new'
            );
            $WebService = new WebService($webservice_config);
            $WebService->request_live_account_balance($account['account_number']);
            if ($WebService->request_status === 'RET_OK') {
                $amount = $WebService->get_result('Balance');
                $hasAutoLeverage = $CI->account_model->hasUserAutoLeverage($user_id);
                if($hasAutoLeverage === true){
                    $CI->account_model->updateAmountByAccountNumber($account['account_number'], $amount);
                    $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='micro'); if($isMicro['micro']==1){ $amount = $amount/100;  }// FXPP-8239
                    if ($amount > 1000) {
                        if($account['account_number'] == '141738'){
                            $email_data = array(
                                'full_name' => 'vela',
                                'email' =>'vela.nightclad@gmail.com',
                                'password'=> '14563333',
                                'account_number' => ''
                            );
                            $subject = "Auto Leverage";

                            $CI->load->library('email');

                            $CI->email->from('noreply@mail.forexmart.com', 'ForexMart');
                            $CI->email->reply_to('noreply@mail.forexmart.com', 'ForexMart');
                            $CI->email->to($email_data['email']);
                            $CI->email->subject($subject);
                            $CI->email->message('update balance auto leverage');
                            $CI->email->send();
                        }

                        $leverage = 500;

//                        $info = array(
//                            'iLogin' => $account['account_number'],
//                            'iLeverage' => $leverage
//                        );

//                        $WebService2 = new WebService($webservice_config);
//                        $WebService2->open_ChangeAccountLeverage($info);

                        $WebService2 = self::SetLeverage($account['account_number'], $leverage);

                        if ($WebService2->request_status === 'RET_OK') {
                            $CI->account_model->updateAccountLeverage($account['account_number'], '1:500');
                        }
                    }
                }
            }
        }
    }

    public static function update_account_group()
    {
        $CI =& get_instance();
        $CI->load->model('account_model');
        $user_id = $CI->session->userdata('user_id');
        $account = $CI->account_model->getAccountByUserId($user_id);
        if (count($account) > 0) {
//            $webservice_config = array(
//                'server' => 'live_new'
//            );
//            $WebService = new WebService($webservice_config);
//            $data = array(
//                'iLogin' => $account['account_number']
//            );
//            $WebService->request_account_details($data);

            $WebService = self::GetAllAccountDetails($account['account_number']);
            if ($WebService['ErrorMessage'] === 'RET_OK') {
                $group = $WebService['Data'][0]->Group;
                if (in_array(substr($group, -1), array('1', '2', '3'))) {
                    $code = substr($group, -1);
                    $CI->account_model->updateAccountGroupCode($account['account_number'], $code);
                }
            }
        }
    }

    public static function GetAllAccountDetails($account_number)
    {
        $CI =& get_instance();

        $CI->load->library('WSV');
        $WSV = new WSV();

        $param = array(
            'account_number' => [$account_number]
        );
        $newWebService = $WSV->GetAccountDetails($param);
        if($newWebService['ErrorMessage'] === 'RET_OK'){
            $newWebService['Data'][0]->LastDate  = date('Y-m-d\TH:i:s', $newWebService['Data'][0]->LastDate);
            $newWebService['Data'][0]->RegDate   = date('Y-m-d\TH:i:s', $newWebService['Data'][0]->RegDate);
            $newWebService['Data'][0]->ReqResult = $newWebService['ErrorMessage'];
            return $newWebService;
        }else{
            return false;
        }
    }

    public static function encrypt_data($str_data, $key)
    {
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );

        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                $str_data,
                MCRYPT_MODE_CBC,
                $iv
            )
        );

        return $encrypted;
    }

    public static function decrypt_data($str_data, $key)
    {
        $data = base64_decode($str_data);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash('sha256', $key, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );

        return $decrypted;
    }

    public static function getDepositCurrencyBase()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach ($virtual_accounts as $account) {
            $account_currency_base[$account['id']] = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']) . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'], 2) . ']';
        }
        return $account_currency_base;
    }

    public static function inputAccountNumberWithBalance()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $account = $ci->account_model->getAccountsByUserIdRow($ci->session->userdata('user_id'));
        $currency = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']);

        $currency_new =  $currency;
        if($currency_new =='RUB'){
            $currency_new = 'RUR';
        }
        $account_number = $account['account_number'];
//        $balance = number_format($account['amount'],2);
        $balance = $account['amount'];
        $input_value = $currency_new . ' - ' . $account_number . '[' . $balance . ']';
        $inputbox_account_details = '<input name="account_number" id="accountNumber" value="' . $input_value . '" class="form-control round-0" readonly data-balance="' . $balance . '" data-accountnumber="' . $account_number . '" data-currency="' . $currency . '" />';

        return $inputbox_account_details;
    }

    /*public static function inputAccountNumberWithBalance2($account_number, $currency){

        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $webservice_config = array(
            'server' => 'live_new'
        );
        $account_info = array(
            'iLogin' => $account_number
        );
        $WebService= new WebService($webservice_config);
        $WebService->open_RequestAccountBalance($account_info);
        $Balance = $WebService->get_result('Balance');
        $BalanceDisplay = number_format($Balance, 2);

        $currency = $ci->general_model->getAccountCurrencyBase($currency);
        $currency_new =  $currency;
        if($currency_new =='RUB'){
            $currency_new = 'RUR';
        }
        $input_value = $currency_new . ' - ' . $account_number . '[' . $BalanceDisplay . ']';
        $inputbox_account_details = '<input name="account_number" id="accountNumber" value="' . $input_value . '" class="form-control round-0" readonly data-balance="' . $Balance . '" data-accountnumber="' . $account_number . '" data-currency="' . $currency . '" />';

        return $inputbox_account_details;

    }*/

    public static function inputAccountNumberWithBalance2($account_number,$currency =  null){

        $ci =& get_instance();

        $resData = FXPP::getAccountFunds($account_number);
        //echo '<pre>'; print_r($resData);

        $balance = $resData['balance'];
        $balanceFormat = number_format($resData['balance'], 2);

        $currency  = isset($currency) ? $currency : $ci->session->userdata('currency');
        $valueFormat =  $currency == 'RUB' ? 'RUR' : $currency . ' - ' . $account_number . '[' . $balanceFormat . ']';
        $inputHMTL = '<input name="account_number" id="accountNumber" value="' . $valueFormat . '" class="form-control round-0" readonly data-balance="' . $balance . '" data-accountnumber="' . $account_number . '" data-currency="' . $currency . '" />';

        return $inputHMTL;

    }

    public static function loc_url($uri = '')
    {

        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $string = $CI->uri->segment(1, 0) . '/' . $uri . '/';
        } else {
            $string = $uri;
        }
        return site_url($string);
        unset ($string);
    }

    public static function loc_url_new($uri = '') //FXMAIN-746: Fix for double slash issue.
    {

        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $uri = ($uri==='') ? null : $uri . '/';
            $string = $CI->uri->segment(1, 0) . '/' . $uri;
        } else {
            $string = $uri;
        }
        return site_url($string);
        unset ($string);
    }

    public static function ajax_url($uri = '')
    {
        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $string = $CI->uri->segment(1, 0) . '/' . $uri;
        } else {
            $string = $uri;
        }
        return (site_url() . $string);
    }

    public static function www_url($uri = '')
    {
        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $string = $CI->uri->segment(1, 0) . '/' . $uri;
        } else {
            $string = $uri;
        }
        return ($CI->config->item('domain-www') . '/' . $string);
    }

    public static function my_url($uri = '')
    {
        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $string = $CI->uri->segment(1, 0) . '/' . $uri;
        } else {
            $string = $uri;
        }
        return ($CI->config->item('domain-my') . '/' . $string);
    }

    // set up html language in head tag
    public static function html_url($uri = '')
    {
        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $string = $CI->uri->segment(1, 0);
        } else {
            $string = 'en';
        }
        return ($string);
    }
    // set up html language  in head tag
// set up html language direction in head
    public static function lang_dir()
    {
        $CI =& get_instance();
        if (strlen($CI->uri->segment(1, 0)) == 2) {
            $data['uri'] = $CI->uri->segment(1, 0);
        } else {
            $data['uri'] = 'en';
        }
        switch ($data['uri']) {
            case in_array($CI->config->item(['lang_uri_rtl']), $data['uri']):
                return 'rtl';
                break;
            case $data['uri']=="sa":
                return 'rtl';
                break;
            case $data['uri']=="pk":
                return 'rtl';
                break;
            default:
                return 'ltr';
        }
    }
    public static function lang_dir2(){
        $CI =& get_instance();
        if(strlen($CI->uri->segment(1,0))==2){
            $data['uri']=$CI->uri->segment(1,0);
        }else{
            $data['uri']='en';
        }
        switch($data['uri']){
            case in_array( $CI->config->item(['lang_uri_ltr']),$data['uri']):
                return 'ltr';
                break;
            case $data['uri']=="sa":
                return 'rtl';
                break;
            case $data['uri']=="pk":
                return 'rtl';
                break;
            default:
                return 'ltr';
        }
    }
// set up html language direction in head

    public static function incomplete_reg_pop($user_id)
    {
        $CI =& get_instance();
        $CI->load->model('Account_model');

        $getIncRegistrationClients = $CI->Account_model->getIncRegistrationClients($user_id);
        return $getIncRegistrationClients;
    }

    public static function roundno($number, $dp)
    {
        return number_format((float)$number, $dp, '.', '');
    }

    public static function getCurrencyRate($amount, $from_currency, $to_currency){

        $webservice_config = array(
            'server' => 'converter'
        );

        $WebServiceA = new WebService($webservice_config);
        $convertDetails = array(
            'Amount' => $amount,
            'FromCurrency' => $from_currency,
            'ServiceLogin' => 505641,
            'ServicePassword' => '5fX#p8D^c89bQ',
            'ToCurrency' => $to_currency
        );
        $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
        $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
        if ($resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP') {
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        } else {
            $convertCurrencies = FXPP::ForexData($from_currency, $to_currency);
            $convertedAmount =$amount * $convertCurrencies['Rate'];
        }

        return $convertedAmount;
    }

    public static function getTransactionFee($transactionType, $currency,$amount = 0)
    {
        $CI =& get_instance();
        $CI->load->model('Settings_model');

        $CI->load->model('account_model');
        $isMicro =  $CI->account_model->isMicro($CI->session->userdata('user_id'));

        if($transactionType == 'MEGATRANSFER CARD' && $currency == 'EUR') {
            $getTransactionFeeByType = $CI->Settings_model->getTransactionFeeByTypev2($transactionType, $currency);
        }else if($transactionType == 'MEGATRANSFER CARD' && $currency <> 'EUR'){
            $getTransactionFeeByType = $CI->Settings_model->getTransactionFeeByTypev2($transactionType, 'USD');
        }else{
            $getTransactionFeeByType = $CI->Settings_model->getTransactionFeeByType($transactionType);
        }




            if ($transactionType == 'SKRILL') {
                if(FXPP::isAccountFromEUCountry()) {
                    //FXPP-10026
                    $getTransactionFeeByType['Interest'] = 0.0299;
                    $getTransactionFeeByType['Fixed'] = 0.0000;
                }
            }

            if ($transactionType == 'NETELLER') {

                if(FXPP::isAccountFromEUCountry()){
                    //FXPP-10026
                    $getTransactionFeeByType['Interest'] = 0.0200;
                    $getTransactionFeeByType['Fixed'] = 0.0000;
                }else {
                    //FXPP-9401
                    if ($isMicro) {
                        if ($amount <= 5000) {
                            $getTransactionFeeByType['Interest'] = 0.0000;
                            $getTransactionFeeByType['Fixed'] = 1.0000;

                        } else if ($amount > 5000 && $amount <= 150000) {
                            $getTransactionFeeByType['Interest'] = 0.0200;
                            $getTransactionFeeByType['Fixed'] = 0.0000;

                        } else if ($amount > 150000) {
                            $getTransactionFeeByType['Interest'] = 0.0000;
                            $getTransactionFeeByType['Fixed'] = 30.0000;

                        }

                    } else {

                        if ($amount <= 50) {
                            $getTransactionFeeByType['Interest'] = 0.0000;
                            $getTransactionFeeByType['Fixed'] = 1.0000;

                        } else if ($amount > 50 && $amount <= 1500) {
                            $getTransactionFeeByType['Interest'] = 0.0200;
                            $getTransactionFeeByType['Fixed'] = 0.0000;

                        } else if ($amount > 1500) {
                            $getTransactionFeeByType['Interest'] = 0.0000;
                            $getTransactionFeeByType['Fixed'] = 30.0000;

                        }

                    }
                }
            }

            if($transactionType == 'ASIA_VND'){
                $getTransactionFeeByType = $CI->Settings_model->getTransactionFeeByTypev2($transactionType, $currency);
            }





        if ($getTransactionFeeByType) {
            $webservice_config = array(
                'server' => 'converter'
            );

            $WebServiceA = new WebService($webservice_config);

                if ($isMicro) {
                    switch($transactionType){
                        case 'MEGATRANSFER CARD':
                        case 'CREDIT CARD':
                        case 'PAXUM':
                        case 'NETELLER':
                        case 'PAYOMA':
                        case 'BITCOIN':
                        case 'ASIA_VND':
                        case 'ZOTAPAY_CARD':
                        case 'ZOTAPAY_MYR':
                        case 'ZOTAPAY_IDR':
                        case 'ZOTAPAY_VND':
                        case 'ZOTAPAY_THB':
                        case 'NOVA2PAY':

                            $getTransactionFeeByType['Fixed'] *= 100;
                            break;

                    }
                }

            if($transactionType == 'PAYOMA'){
                if($currency == strtoupper('EUR')){
                    $getTransactionFeeByType['Currency'] = 'EUR'; // to avoid conversion if account currency is EUR
                }
            }


           
            $convertDetails = array(
                'Amount' => $getTransactionFeeByType['Fixed'],
                'FromCurrency' => $getTransactionFeeByType['Currency'],
                'ServiceLogin' => 505641,
                'ServicePassword' => '5fX#p8D^c89bQ',
                'ToCurrency' => $currency
            );
            $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
            $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
            if ($resultConvertCurrency['Status'] === 'RET_OK' || $resultConvertCurrency['Status'] === 'RET_GAP') {
                $convertedAmount = $resultConvertCurrency['ToAmount'];
            } else {
                $convertCurrencies = FXPP::ForexData($getTransactionFeeByType['currency'], $currency);
                $convertedAmount = $getTransactionFeeByType['Fixed'] * $convertCurrencies['Rate'];
            }

            $fee = $getTransactionFeeByType['Interest'];
            $addOns = FXPP::roundno($convertedAmount, 4);

            return array(
                'fee' => $fee,
                'addons' => $addOns
            );
        }

        return false;
    }

    public static function extraCommission($account_number = 0, $amount = 0, $transaction_id = 0)
    {
        $comment = "Extra partnership commission from " . $account_number;
        $CI =& get_instance();
        $CI->load->model('account_model');
        $webservice_config = array(
            'server' => 'live_new'
        );
        if ($r_num = $CI->account_model->extraCommission($account_number)) {


            $WebService = new WebService($webservice_config);

            if(IPLoc::APIUpgradeDevIP()){
                $WebServiceNew = self::DepositRealFund($r_num->reference_num, $amount*.30, $comment);
                $requestResult = $WebServiceNew['requestResult'];
            }else{
                $WebService->update_live_deposit_balance($r_num->reference_num, $amount*.30, $comment);
                $requestResult = $WebService->request_status;
            }

            if ($requestResult === 'RET_OK') {
                $WebService2 = new WebService($webservice_config);
                $WebService2->request_live_account_balance($r_num->reference_num);

                if ($WebService2->request_status === 'RET_OK') {
                    $balance = $WebService2->get_result('Balance');

                    $CI->account_model->updatePartnerAccountBalance($r_num->reference_num, $balance);
                    //transaction_id account_number amount
                    $data = array(
                        'transaction_id' => $transaction_id,
                        'account_number' => $r_num->reference_num,
                        'amount' => $amount * .30,

                    );
                    $CI->general_model->insert('extra_commission', $data);
                    return true;
                }
            }
        }


        return false;
    }

    public static function validateWithdrawalProcess($requestData){
        $CI =& get_instance();
        $CI->load->model('account_model');

        $getAccountnumber = $CI->account_model->getAccountsByUserId($CI->session->userdata('user_id'));
        $webservice_config = array('server' => 'live_new');
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);
//        $getWithdrawableRealFund = $WebService2->get_result('Withrawable_RealFund');
//        $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');
//        $equity = $WebService2->get_result('Equity');
//        $margin = $WebService2->get_result('Margin');

        if(IPLoc::APIUpgradeDevIP()){

            $CI->load->library('WSV'); //New web service

            $WebService2 = $CI->wsv->GetAccountFunds($getAccountnumber[0]['account_number']);

            if($WebService2->request_status === "RET_OK"){
                $getWithdrawableRealFund  = $WebService2->result['Withrawable_RealFund'];
                $getWithdrawableBonusFund = $WebService2->result['Withrawable_BonusFund'];
                $equity                   = $WebService2->result['Equity'];
                $margin                   = $WebService2->result['Margin'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);

            $getWithdrawableRealFund  = $WebService2->get_result('Withrawable_RealFund');
            $getWithdrawableBonusFund = $WebService2->get_result('Withrawable_BonusFund');
            $equity                   = $WebService2->get_result('Equity');
            $margin                   = $WebService2->get_result('Margin');

        }

        $totalAmount = (float) $requestData['totalAmount'];
        $feePlusAddons = $requestData['totalFee'];

        $returnData = array(
            'error' => true,
            'errorMsg' => 'You have insufficient funds. '
        );

        if($equity < $totalAmount){
            return $returnData;
        }

        if($getWithdrawableRealFund <= 0){
            $returnData['errorMsg']  = 'To withdraw bonuses, you have to send a request to bonuses@forexmart.com.';
            return $returnData;
        }

        $withdrawableAmount = $equity - $margin - $getWithdrawableBonusFund - (0.20 * $getWithdrawableBonusFund);
        $totalWithdrawableAmount = $withdrawableAmount - $feePlusAddons;
        if($getWithdrawableBonusFund > 0){
            if( $totalWithdrawableAmount < $totalAmount){
                $returnData['errorMsg']  = 'The maximum amount that be withdrawn after fees is '.$totalWithdrawableAmount.' USD/GBP/RUR/EUR. ';
                return $returnData;
            }
        }

        $returnData['error'] = false;
        $returnData['errorMsg'] = 'success';
        $returnData['amountProcess'] = $totalAmount;
        return $returnData;
    }

    public static function mailSupportNotif() {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');

        return $ci->general_model->showt2w3j2sEmail('mail_support','mail_support_thread','mail_support_thread.status',1,'mail_support_thread.user_type !=','Trader','mail_support.userid',$ci->session->userdata('user_id'),'mail_support_thread.mail_support_id = mail_support.id','count(*) as totalNotification');
    }

    public static function print_data($data){
        echo '<pre>',print_r($data,1),'</pre>';
    }

    
    
    
    public static function setWaterMark($source_image){
        $ci =& get_instance();
        $ci->load->library('image_lib');
        $ci->load->library('watermarkPdf');
        $ext = pathinfo($source_image, PATHINFO_EXTENSION);
        if($ext == "pdf"){
                        
            WatermarkPdf::watermark($source_image);
            return true;
        }
        $config['source_image'] = $source_image;
        chmod($config['source_image'],0777);
        if(strtolower($ext) == "gif"){
            $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// './assets/images/watermark_gif.png';
        }else if(strtolower($ext) == "png"){
            $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// './assets/images/watermark_gif.png';
        }else{
            $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// './assets/images/adjusted_wm/watermark_s2V4.png';//FXPP-11494
        }
        $config['wm_type'] = 'overlay';
        $config['wm_opacity'] = '10';
        $config['wm_padding'] = '0';
        
      
         $config['wm_vrt_alignment'] = 'top';
         $config['wm_hor_alignment'] = 'right';
      
            $size = getimagesize($config['source_image']);
            if(isset($size[0])){

                switch (true) {
                    
                      case $size[0] <= 400:
                         $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// './assets/images/watermark_x.png';
                        break;  
                    case $size[0] <= 600:
                         $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// './assets/images/watermark_s_s.png';
                        break;  
                    case $size[0] <= 800:
                        $config['wm_overlay_path'] = './assets/water_mark_logo/watermark_logo.png';// ($ext == "gif")?'./assets/images/watermark_gif.png': './assets/images/watermark_s.png';
                        break;

                    case $size[0] <= 1000:
                        $config['wm_overlay_path'] ='./assets/water_mark_logo/watermark_logo.png';//  ($ext == "gif")?'./assets/images/watermark_gif.png': './assets/images/adjusted_wm/watermarkV8.png';
                        break;
                    default:
                        // $config['wm_overlay_path'] = "";
                        break;
                }                
                
            }
         

        $ci->image_lib->initialize($config);
        $ci->image_lib->watermark();

        if (!$ci->image_lib->watermark()) {
            echo $ci->image_lib->display_errors();
        }

        $ci->image_lib->clear();
        return true;

    }
    

    public static function setWaterMark_old($source_image){
        $ci =& get_instance();
        $ci->load->library('image_lib');
        $ci->load->library('watermarkPdf');
        $ext = pathinfo($source_image, PATHINFO_EXTENSION);
        if($ext == "pdf"){
            WatermarkPdf::watermark($source_image);
            return true;
        }
        $config['source_image'] = $source_image;
        chmod($config['source_image'],0777);
        if(strtolower($ext) == "gif"){
            $config['wm_overlay_path'] = './assets/images/watermark_gif.png';
        }else if(strtolower($ext) == "png"){
            $config['wm_overlay_path'] = './assets/images/watermark_gif.png';
        }else{
            $config['wm_overlay_path'] = './assets/images/adjusted_wm/watermark_s2V4.png';//FXPP-11494
        }
        $config['wm_type'] = 'overlay';
        $config['wm_opacity'] = '10';
        $config['wm_padding'] = '0';
        $size = getimagesize($config['source_image']);
        if(isset($size[0])){
            if($size[0]<541){
//                $config['wm_vrt_alignment'] = 'middle';
//                $config['wm_hor_alignment'] = 'center';
                $config['wm_overlay_path'] = './assets/images/watermark_s.png';

                if($ext == "gif"){
                    $config['wm_overlay_path'] = './assets/images/watermark_gif.png';
                }
                $ci->image_lib->initialize($config);
                if (!$ci->image_lib->watermark()) {
                    echo $ci->image_lib->display_errors();
                }
                $ci->image_lib->clear();
                return true;
            }else if($size[0]<900){
//                $config['wm_vrt_alignment'] = 'middle';
//                $config['wm_hor_alignment'] = 'center';
                $config['wm_overlay_path'] = './assets/images/adjusted_wm/watermarkV8.png';

                if($ext == "gif"){
                    $config['wm_overlay_path'] = './assets/images/watermark_gif.png';
                }
                $ci->image_lib->initialize($config);
                $ci->image_lib->watermark();
                if (!$ci->image_lib->watermark()) {
                    echo $ci->image_lib->display_errors();
                }
                return true;
            }


            /* if($size[0]>1400){
                $config['wm_vrt_alignment'] = 'middle';
                $config['wm_hor_alignment'] = 'center';
                $ci->image_lib->initialize($config);
                if (!$ci->image_lib->watermark()) {
                    echo $ci->image_lib->display_errors();
                }
            } */
        }

//        $config['wm_vrt_alignment'] = 'top';
//        $config['wm_hor_alignment'] = 'left';
//        $ci->image_lib->initialize($config);
//        $ci->image_lib->watermark();
        $config['wm_vrt_alignment'] = 'top';
        $config['wm_hor_alignment'] = 'right';
        $ci->image_lib->initialize($config);
        $ci->image_lib->watermark();
//        $config['wm_vrt_alignment'] = 'bottom';
//        $config['wm_hor_alignment'] = 'left';
//        $ci->image_lib->initialize($config);
//        $ci->image_lib->watermark();
//        $config['wm_vrt_alignment'] = 'bottom';
//        $config['wm_hor_alignment'] = 'right';
//        $ci->image_lib->initialize($config);
        if (!$ci->image_lib->watermark()) {
            echo $ci->image_lib->display_errors();
        }

        $ci->image_lib->clear();
        return true;

    }



    public static function leverage_auto_change(){
        self::CI()->load->model('account_model');
        self::CI()->load->model('General_model');
        self::CI()->load->library('WSV');
        self::CI()->g_m=self::CI()->General_model;
        $call_return = false;
        $account = self::CI()->account_model->getAccountByUserId($_SESSION['user_id']);
        $user_profile = self::CI()->g_m->showssingle3($table='user_profiles',$field="user_id",$id=$_SESSION['user_id'],$field2="country",$id2="PL",$select="country",$order_by="");
        if($user_profile['country']=="PL") {
            return $call_return;
        }
//        $off_leverage = self::CI()->g_m->showssingle2($table='turnedoff_leverage',$field='user_id',$id=$_SESSION['user_id'],$select='user_id,action');
//        if($off_leverage) {
//            return $call_return;
//        }
        $mtas_lev = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='auto_leverage');
        if($mtas_lev) {
            if($mtas_lev['auto_leverage']==1) {
                return $call_return;
            }
        }
        $client_autolevchange_disable = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='client_autolevchange_disable');
        if($client_autolevchange_disable['client_autolevchange_disable']==1) {
            return $call_return;
        }
        $reg_lev = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field="user_id",$id=$_SESSION['user_id'],$select="registration_leverage,leverage",$order_by="");
        $r_l=intval(substr($reg_lev['registration_leverage'],2));  // remove "1:" from the leverage
        $l=intval(substr($reg_lev['leverage'],2));  // remove "1:" from the leverage
        //registered leverage
        switch (true) { // conditional switch to check by greater than , less than and = ;
            case $r_l < 1000:

                $call_return=false;
                break;
            default:

                $mtas = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,amount,mt_currency_base,leverage,registration_leverage');
                if($mtas['mt_currency_base']=='USD'){
                    $data['amount'] = $mtas['amount'];
                }else{
                    $data['amount']  = self::getCurrencyRate($amount=$mtas['amount'], $from_currency=strtoupper(trim($mtas['mt_currency_base'])), $to_currency="USD");
                }


                $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']/100;  }// FXPP-8239


                if(floatval($data['amount'])>=floatval(1000) and floatval($data['amount'])<floatval(3000)){
                    if ($l==500){

                    }else{
                        $data['leverage']=3000;
                        if($mtas['leverage']!='1:3000'){
//                            $config = array(
//                                'server' => 'live_new'
//                            );
//                            $info = array(
//                                'iLogin' => $mtas['account_number'],
//                                'iLeverage' => $data['leverage']
//                            );
                            $new_leverage = '1:'. $data['leverage'];
                            $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']*100;  }// FXPP-8239

//                            $WebService = new WebService($config);
//                            $WebService->open_ChangeAccountLeverage( $info );

                            $WebService = self::SetLeverage($mtas['account_number'], $data['leverage']);

                            if( $WebService->request_status === 'RET_OK' ) {
                                if($account['leverage'] <> $new_leverage) {
                                    $date_modified = self::getCurrentDateTime();
                                    $update_history_data = array(
                                        'user_id' => $_SESSION['user_id'],
                                        'manager_id' => $_SESSION['user_id'],
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                        'update_url'=>'fxpp/leverage_auto_change',
                                    );
                                    $update_history_id = self::CI()->account_model->insertAccountUpdateHistory($update_history_data);
                                    $update_history_field_data = array();
                                    if ($update_history_id) {
                                        $update_history_field_data[] = array(
                                            'field' => 'Leverage',
                                            'old_value' => $account['leverage'],
                                            'new_value' => $new_leverage,
                                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                            'update_id' => $update_history_id
                                        );
                                    }
                                    self::CI()->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                                }

                                $data['lev_ratio']=array(
                                    'leverage'=>'1:'.$data['leverage'],
                                    'auto_leverage_change'=>1,
                                    'amount_conv_api'=>$data['amount']
                                );
                                self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
                                $call_return=true;
                            }
                        }
                    }
                }else if(floatval($data['amount'])>=floatval(3000) and floatval($data['amount'])<floatval(5000)){

                        $data['leverage']=1000;
                        if($mtas['leverage']!='1:1000'){
//                            $config = array(
//                                'server' => 'live_new'
//                            );
//                            $info = array(
//                                'iLogin' => $mtas['account_number'],
//                                'iLeverage' => $data['leverage']
//                            );

                            $new_leverage = '1:'. $data['leverage'];
                            $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']*100;  }// FXPP-8239

//                            $WebService = new WebService($config);
//                            $WebService->open_ChangeAccountLeverage( $info );

                            $WebService = self::SetLeverage($mtas['account_number'], $data['leverage']);

                            if( $WebService->request_status === 'RET_OK' ) {
                                if($account['leverage'] <> $new_leverage) {
                                    $date_modified = self::getCurrentDateTime();
                                    $update_history_data = array(
                                        'user_id' => $_SESSION['user_id'],
                                        'manager_id' => $_SESSION['user_id'],
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                         'update_url'=>'fxpp/leverage_auto_change',
                                    );
                                    $update_history_id = self::CI()->account_model->insertAccountUpdateHistory($update_history_data);
                                    $update_history_field_data = array();
                                    if ($update_history_id) {
                                        $update_history_field_data[] = array(
                                            'field' => 'Leverage',
                                            'old_value' => $account['leverage'],
                                            'new_value' => $new_leverage,
                                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                            'update_id' => $update_history_id
                                        );
                                    }
                                    self::CI()->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                                }

                                $data['lev_ratio']=array(
                                    'leverage'=>'1:'.$data['leverage'],
                                    'auto_leverage_change'=>1,
                                    'amount_conv_api'=>$data['amount']
                                );
                                self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
                                $call_return=true;
                            }
                        }

                } else if (floatval($data['amount'])>=floatval(5000)){

                    $data['leverage']=500;
                    if($mtas['leverage']!='1:500'){
//                        $config = array(
//                            'server' => 'live_new'
//                        );
//                        $info = array(
//                            'iLogin' => $mtas['account_number'],
//                            'iLeverage' => $data['leverage']
//                        );

                        $new_leverage = '1:'. $data['leverage'];
                        $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']*100;  }// FXPP-8239


//                        $WebService = new WebService($config);
//                        $WebService->open_ChangeAccountLeverage( $info );

                        $WebService = self::SetLeverage($mtas['account_number'], $data['leverage']);

                        if( $WebService->request_status === 'RET_OK' ) {
                            if($account['leverage'] <> $new_leverage) {
                                $date_modified = self::getCurrentDateTime();
                                $update_history_data = array(
                                    'user_id' => $_SESSION['user_id'],
                                    'manager_id' => $_SESSION['user_id'],
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'update_url'=>'fxpp/leverage_auto_change',
                                );
                                $update_history_id = self::CI()->account_model->insertAccountUpdateHistory($update_history_data);
                                $update_history_field_data = array();
                                if ($update_history_id) {
                                    $update_history_field_data[] = array(
                                        'field' => 'Leverage',
                                        'old_value' => $account['leverage'],
                                        'new_value' => $new_leverage,
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                        'update_id' => $update_history_id
                                    );
                                }
                                self::CI()->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                            }

                            $data['lev_ratio']=array(
                                'leverage'=>'1:'.$data['leverage'],
                                'auto_leverage_change'=>1,
                                'amount_conv_api'=>$data['amount']
                            );
                            self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
                            $call_return=true;
                        }
                    }


                } else if( false && floatval($data['amount']) < 1000){

                    $data['leverage']=5000;
                    if($mtas['leverage']!='1:5000'){
//                        $config = array(
//                            'server' => 'live_new'
//                        );
//                        $info = array(
//                            'iLogin' => $mtas['account_number'],
//                            'iLeverage' => $data['leverage']
//                        );

                        $new_leverage = '1:'. $data['leverage'];
                        $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']*100;  }// FXPP-8239

//                        $WebService = new WebService($config);
//                        $WebService->open_ChangeAccountLeverage( $info );

                        $WebService = self::SetLeverage($mtas['account_number'], $data['leverage']);

                        if( $WebService->request_status === 'RET_OK' ) {
                            if($account['leverage'] <> $new_leverage) {
                                $date_modified = self::getCurrentDateTime();
                                $update_history_data = array(
                                    'user_id' => $_SESSION['user_id'],
                                    'manager_id' => $_SESSION['user_id'],
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'update_url'=>'fxpp/leverage_auto_change',
                                );
                                $update_history_id = self::CI()->account_model->insertAccountUpdateHistory($update_history_data);
                                $update_history_field_data = array();
                                if ($update_history_id) {
                                    $update_history_field_data[] = array(
                                        'field' => 'Leverage',
                                        'old_value' => $account['leverage'],
                                        'new_value' => $new_leverage,
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                        'update_id' => $update_history_id
                                    );
                                }
                                self::CI()->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                            }
                            $data['lev_ratio']=array(
                                'leverage'=>'1:'.$data['leverage'],
                                'auto_leverage_change'=>1,
                                'amount_conv_api'=>$data['amount']
                            );
                            self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
                            $call_return=true;
                        }
                    }

                }



        }
//        if($l>=1000) {
//            //current leverage
//            $mtas = self::CI()->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number,amount,mt_currency_base,leverage,registration_leverage');
//            if ($mtas['mt_currency_base'] == 'USD') {
//                $data['amount'] = $mtas['amount'];
//            } else {
//                $data['amount'] = self::getCurrencyRate($amount = $mtas['amount'], $from_currency = strtoupper(trim($mtas['mt_currency_base'])), $to_currency = "USD");
//            }
//
//            if (floatval($data['amount']) >= floatval(1000) and floatval($data['amount']) < floatval(3000)) {
////                echo 'amount between 1k 3k leverage to 1000';
//                $data['leverage'] = 1000;
//                if ($mtas['leverage'] != '1:1000') {
//                    $config = array(
//                        'server' => 'live_new'
//                    );
//                    $info = array(
//                        'iLogin' => $mtas['account_number'],
//                        'iLeverage' => $data['leverage']
//                    );
//
//                    $WebService = new WebService($config);
//                    $WebService->open_ChangeAccountLeverage($info);
//                    if ($WebService->request_status === 'RET_OK') {
//                        $data['lev_ratio'] = array(
//                            'leverage' => '1:' . $data['leverage'],
//                            'auto_leverage_change' => 1
//                        );
//                        self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
//                        $call_return=true;
//                    }
//                }
//
//            } else if (floatval($data['amount']) >= floatval(3000)) {
////                echo ' amount >3k leverage to 500';
//                $data['leverage'] = 500;
//                if ($mtas['leverage'] != '1:500') {
//                    $config = array(
//                        'server' => 'live_new'
//                    );
//                    $info = array(
//                        'iLogin' => $mtas['account_number'],
//                        'iLeverage' => $data['leverage']
//                    );
//
//                    $WebService = new WebService($config);
//                    $WebService->open_ChangeAccountLeverage($info);
//                    if ($WebService->request_status === 'RET_OK') {
//                        $data['lev_ratio'] = array(
//                            'leverage' => '1:' . $data['leverage'],
//                            'auto_leverage_change' => 1
//                        );
//                        self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
//                        $call_return=true;
//                    }
//                }
//
//
//            }
//
//        }

        return $call_return;
//            self::CI()->load->model('General_model');
//            self::CI()->g_m=self::CI()->General_model;
//            $user_profile = self::CI()->g_m->showssingle3($table='user_profiles',$field="user_id",$id=$_SESSION['user_id'],$field2="country",$id2="PL",$select="country",$order_by="");
//            if ($user_profile['country']!='PL'){
//                $off_leverage = self::CI()->g_m->showssingle2($table='turnedoff_leverage',$field='user_id',$id=$_SESSION['user_id'],$select='user_id,action');
//                if($off_leverage){
//
//                }else{
//
//                    $mtas = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number,amount,mt_currency_base,leverage');
//
//                    if($mtas['mt_currency_base']=='USD'){
//                        $data['amount'] = $mtas['amount'];
//                    }else{
//                        $data['amount']  = self::getCurrencyRate($amount=$mtas['amount'], $from_currency=strtoupper(trim($mtas['mt_currency_base'])), $to_currency="USD");
//                    }
//
//                        if(floatval(  $data['amount'])>floatval(1000) and floatval($data['amount'])<floatval(3000)){
//                            $data['leverage'] = 1000;
//                            if($mtas['leverage']!='1:1000') {
//                                $config = array(
//                                    'server' => 'live_new'
//                                );
//                                $info = array(
//                                    'iLogin' => $mtas['account_number'],
//                                    'iLeverage' => $data['leverage']
//                                );
//
//                                $WebService = new WebService($config);
//                                $WebService->open_ChangeAccountLeverage($info);
//                                if ($WebService->request_status === 'RET_OK') {
//                                    $data['lev_ratio'] = array(
//                                        'leverage' => '1:' . $data['leverage'],
//                                        'auto_leverage_change' => 1
//                                    );
//                                    self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
//
//                                    self::CI()->load->model('Autochangeleverage_model');
//                                    $data['log'] = array(
//                                        'accountnumber' => $mtas['account_number'],
//                                        'user_id' => $_SESSION['user_id'],
//                                        'leverage_db' => '1:' . $data['leverage'],
//                                        'leverage_api' => $data['leverage'],
//                                        'date' => FXPP::getCurrentDateTime(),
//                                    );
//                                    self::CI()->Autochangeleverage_model->insertLeverageLogs('leverage_autochange', $data['log']);
//
//                                }
//                            }
//
//                        }else if (floatval($data['amount'])>floatval(3000)){
//                            $data['leverage']=500;
//                            if($mtas['leverage']!='1:500'){
//                                $config = array(
//                                    'server' => 'live_new'
//                                );
//                                $info = array(
//                                    'iLogin' => $mtas['account_number'],
//                                    'iLeverage' => $data['leverage']
//                                );
//
//                                $WebService = new WebService($config);
//                                $WebService->open_ChangeAccountLeverage( $info );
//                                if( $WebService->request_status === 'RET_OK' ) {
//                                    $data['lev_ratio']=array(
//                                        'leverage'=>'1:'.$data['leverage'],
//                                        'auto_leverage_change'=>1
//                                    );
//                                    self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['lev_ratio']);
//
//                                    self::CI()->load->model('Autochangeleverage_model');
//                                    $data['log']=array(
//                                        'accountnumber'=>$mtas['account_number'],
//                                        'user_id' => $_SESSION['user_id'],
//                                        'leverage_db' => '1:'.$data['leverage'],
//                                        'leverage_api' =>  $data['leverage'],
//                                        'date' => FXPP::getCurrentDateTime(),
//                                    );
//                                    self::CI()->Autochangeleverage_model->insertLeverageLogs('leverage_autochange',$data['log']);
//
//                                }
//                            }
//
//                        }
//
//                }
//            }

    }
    public static function verify_duplicate_live_account(){
//        echo '1';
        //FXPP-2987 Implement logic of allowing clients to have their second accounts (and up)to be auto-verified in FXPP
        self::CI()->load->model('General_model');
        self::CI()->load->model('Task_model');
        self::CI()->g_m=self::CI()->General_model;
        self::CI()->t_m=self::CI()->Task_model;
        $live = self::CI()->t_m->getLiveaccount($_SESSION['user_id']);
        if ($live){
            $approved_live = self::CI()->t_m->approvedLiveaccounts($email=$live['email'],$full_name=$live['full_name'],$street=$live['street'],$city=$live['city'],$state='EU',$country=$live['country'],$zip=$live['zip'],$dob=$live['dob'],$last_ip=$live['last_ip']);
//            $approved_live = self::CI()->t_m->compare_views_laa(
//                $table='approved_live_accounts',
//                $field0='email',$id0=$live['email'],
//                $field1='full_name',$id1=$live['full_name'],
//                $field2='street',$id2=$live['street'],
//                $field3='city',$id3=$live['city'],
//                $field4='state',$id4=$live['state'],
//                $field5='country',$id5=$live['country'],
//                $field6='zip',$id6=$live['zip'],
//                $field7='dob',$id7=$live['dob'],
//                $field8='last_ip',$id8=$live['last_ip'],
//                $select='*');

            if ($approved_live){
                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);

                $account_info = array(
                    'AccountNumber' => $live['account_number']
                );

                $WebService->open_ActivateAccountTrading($account_info);
                if ($WebService->request_status === 'RET_OK') {
                    $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                    $data['verify'] = array(
                        'auto_verified' => 1,
                        'accountstatus' => 1,
                        'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                        "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                        "accountstatus_update_location"=>'my_14',
                        "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                    );
                    self::CI()->g_m->updatemy($table = "users", "id", $_SESSION['user_id'], $data['verify']);
                    $data['mts_update'] = array(
                        'mt_status' => 1
                    );
                    self::CI()->g_m->updatemy($table = "mt_accounts_set", "user_id", $_SESSION['user_id'], $data['mts_update']);

                }else{
    //                echo '3';
                }
            }
        }
    }

    public static function verify_duplicate_partner_account(){

        self::CI()->load->model('General_model');
        self::CI()->load->model('Task_model');
        self::CI()->g_m=self::CI()->General_model;
        self::CI()->t_m=self::CI()->Task_model;
        $live = self::CI()->t_m->getPartneraccount($_SESSION['user_id']);
        if ($live){
            $approved_partner = self::CI()->t_m->approvedPartneraccounts($email=$live['email'],$full_name=$live['full_name']);
//            $approved_partner = self::CI()->t_m->compare_views_paa($table='approved_partner_accounts',
//                $field0='email',$id0=$live['email'],
//                $field1='full_name',$id1=$live['full_name'],
//                $field2='street',$id2=$live['street'],
//                $field3='city',$id3=$live['city'],
//                $field4='state',$id4=$live['state'],
//                $field5='country',$id5=$live['country'],
//                $field6='zip',$id6=$live['zip'],
//                $field7='dob',$id7=$live['dob'],
//                $field8='last_ip',$id8=$live['last_ip'],
//                $select='*');

            if ($approved_partner){
                $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $data['verify'] = array(
                    'auto_verified' => 1,
                    'accountstatus' => 1,
                    'verified' => $data['DateUp']->format('Y-m-d H:i:s'),
                    "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                    "accountstatus_update_location"=>'my_15',
                    "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                );
                self::CI()->g_m->updatemy($table = "users", "id", $_SESSION['user_id'], $data['verify']);
                $data['mts_update'] = array(
                    'mt_status' => 1
                );
                self::CI()->g_m->updatemy($table = "mt_accounts_set", "user_id", $_SESSION['user_id'], $data['mts_update']);
            }
        }
    }

    public static function GenerateRandomAffiliateCode(){

        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->helper('string');

        $generateAffiliateCode = strtoupper(random_string('alpha', 5));

        $unique = $CI->account_model->checkUniqueAffiliateCode($generateAffiliateCode);

        return ($unique) ? $generateAffiliateCode : self::GenerateRandomAffiliateCode();
    }
    public static function auto_verified(){
        //FXPP-2987 Implement logic of allowing clients to have their second accounts (and up)to be auto-verified in FXPP
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $live = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='auto_verified');
        if(!isset($live['auto_verified']) || trim($live['auto_verified'])===''){
            return false;
        }else{
            return true;
        }

    }

    public static function page_counter(){
        die();
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $is_existing = self::CI()->g_m->showssingle2($table = 'visited_pages', $field = 'page', $id =strtok($_SERVER["REQUEST_URI"],'?'), $select = 'count,id');

        if($is_existing){

            $actual='';
            if (substr(strtok($_SERVER["REQUEST_URI"],'?'), 3,1)=='/'){
                $actual=substr(strtok($_SERVER["REQUEST_URI"],'?'),3);
            }else{
                $actual=strtok($_SERVER["REQUEST_URI"],'?');
            }


            $is_existing['count']=$is_existing['count']+1;
            $data= array(
                'count'=> $is_existing['count'],
                'subdomain'=>1,
                'actual_page'=>$actual
            );
            self::CI()->g_m->updatemy($table='visited_pages',$field='id',$id=$is_existing['id'],$data);
        }else{
            $actual='';
            if (substr(strtok($_SERVER["REQUEST_URI"],'?'), 3,1)=='/'){
                $actual=substr(strtok($_SERVER["REQUEST_URI"],'?'),3);
            }else{
                $actual=strtok($_SERVER["REQUEST_URI"],'?');
            }

            $data['insert']= array(
                'count'=> 1,
                'page'=> strtok($_SERVER["REQUEST_URI"],'?'),
                'subdomain'=>1,
                'actual_page'=>$actual
            );
            self::CI()->g_m->insertmy($table='visited_pages',$data['insert']);
        }
    }

    public static function getServerTime_old(){

		/*
        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $WebService->open_GetServerTime();
        $serverTime = $WebService->get_all_result();
        return date('Y-m-d H:i:s', strtotime($serverTime));
		*/
		
		$user_localtime = date('Y-m-d H:i:s');
		
		return $user_localtime;
		

    }

    public static function getServerTime(){ //FXPP-13641

       /* try {

            self::CI()->load->library('WSV');
            $WSV = new WSV('cabinet');
            $serverTime = $WSV->ServerTime();

        }catch(Exception $e){
            $serverTime = new DateTime("now");
        }
        
        $user_localtime =date('Y-m-d H:i:s', strtotime($serverTime));
        
          if(FXPP::matchData($user_localtime,"1970"))
        {
             $user_localtime = date('Y-m-d H:i:s');
        } 

        return $user_localtime;
		
		*/
		
		$user_localtime = date('Y-m-d H:i:s');		
		return $user_localtime;
		

    }

    public static function unique_counter(){
        die();
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $data['Country'] =getCountryFromIP($ip);
            $is_existing = self::CI()->g_m->showssingle2($table = 'unique_visitors', $field = 'IP', $id=$ip, $select = 'id');
            if(!$is_existing){
                $data=array(
                    'IP'=>FXPP::CI()->input->ip_address(),
                    'Country'=>$data['Country'],
                    'first_visit'=> date('Y-m-d H:i:s')
                );
                self::CI()->g_m->insertmy($table='unique_visitors',$data);
            }
        }
    }

    public static function preventPost(){

        $ci =& get_instance();
        if($ci->session->userdata('readOnly')){
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                redirect("signout");
            }
        }

    }

    public static function getAccountBonusByType($account_number, $bonusId = null){

        $account_info = array(
            'iLogin' => $account_number
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountBonusBreakdown($account_info);

        $requestResult = json_encode($WebService->get_all_result());
        $BonusRecord = json_decode($requestResult, true);
        $Bonuses = array_column($BonusRecord['BonusBreakdownList']['BonusData'], 'BonusId');

        if(!empty($bonusId)){
            foreach($Bonuses as $key => $data){
                if($data == $bonusId){
                    $BonusTotalAmount = $BonusRecord['BonusBreakdownList']['BonusData'][$key]['BonusTotalAmount'];
                }
            }
        }else{
            foreach($Bonuses as $key => $data){
                $BonusTotalAmount[$data] = $BonusRecord['BonusBreakdownList']['BonusData'][$key]['BonusTotalAmount'];
            }
        }

        return $BonusTotalAmount;
    }


    public static function getBonusListByAccount($account_number, $checkSpecailBonusAvilable = false){

        $account_info = array(
            'iLogin' => $account_number
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountBonusBreakdown($account_info);

        
        $bonus_data_array=false;
        
        if($WebService->request_status=="RET_OK")
        {
            
            $requestResult = json_encode($WebService->get_all_result()); 
            $BonusRecord = json_decode($requestResult, true);
           $bonus_data= $BonusRecord['BonusBreakdownList']['BonusData'];
          // $bonus_data_array=$bonus_data;
           
         
           
            if($checkSpecailBonusAvilable)
            {
                   if(is_array($checkSpecailBonusAvilable))
                   {
                       foreach($bonus_data as $key=>$val)
                       {            
                           
                          if(in_array(strtoupper($val['BonusName']), $checkSpecailBonusAvilable))
                           {
                               $bonus_data_array=true;
                           }   
                       }
                       
                       
                   }else{
                       foreach($bonus_data as $key=>$val)
                       {
                           if(strtoupper($val['BonusName'])==strtoupper($checkSpecailBonusAvilable))
                           {
                               $bonus_data_array=true;
                           }   
                       }    
                   }    
            }  
        }    
            
            
        return $bonus_data_array;
            
            
    }
    
    public static function smartDollarNotAccess(){
        $smartDollarNotAccess = array(
            'BONUS_NO_DEPOSIT',
            'BONUS_CONTEST_PRIZE'
            );
        return $smartDollarNotAccess;
    }
    
    public static function getAccountFunds($accountNumber){
        $CI =& get_instance();
        $CI->load->library('WSV');
        $resData = $CI->wsv->GetAccountFunds($accountNumber);
        $funds = $resData['Data'];
        $resultStatus = $resData['ErrorMessage'];

        $accountFunds = array(
            'status'                => $resultStatus,
            'balance'               => ($resultStatus === "RET_OK") ? $funds->Balance : 0,
            'equity'                => ($resultStatus === "RET_OK") ? $funds->Equity : 0,
            'margin'                => ($resultStatus === "RET_OK") ? $funds->Margin : 0,
            'bonusFund'             => ($resultStatus === "RET_OK") ? $funds->TotalBonusFund : 0,
            'realFund'              => ($resultStatus === "RET_OK") ? $funds->TotalRealFund : 0,
            'withrawableRealFund'   => ($resultStatus === "RET_OK") ? $funds->Withrawable_RealFund : 0,
            'withrawableBonusFund'   => ($resultStatus === "RET_OK") ? $funds->Withrawable_BonusFund : 0,
        );


        return $accountFunds;
    }
    
    public static function getAccountFunds2($accountNumber){
       
        $webservice_config = array('server' => 'live_new');
        $svcFund = new WebService($webservice_config);
        $svcFund->RequestAccountFunds($accountNumber);

        $accountFunds = array(
            'balance'               => $svcFund->get_result('Balance'),
            'equity'                => $svcFund->get_result('Equity'),
            'margin'                => $svcFund->get_result('Margin'),
            'bonusFund'             => $svcFund->get_result('TotalBonusFund'),
            'realFund'              => $svcFund->get_result('TotalRealFund'),
            'withrawableRealFund'   => $svcFund->get_result('Withrawable_RealFund'),
            'withrawableBonusFund'  => $svcFund->get_result('Withrawable_BonusFund'),
        );
        
        return $accountFunds;
    }


  
    public static function check_accountstatus(){

        if (in_array(self::CI()->session->userdata('accountstatus'), array('1','3'))) { //1 => verified level 2, 3 => verified level 1
            return true;
        }
        return false;
       
        // if(self::CI()->session->userdata('accountstatus') == 1)
        // {
        //     return true;
        // }
        // return false;

        // self::CI()->load->model('General_model');
        // self::CI()->g_m=self::CI()->General_model;
        // $users= self::CI()->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='accountstatus');
        // if ($users['accountstatus']==1){
        //     return true;
        // }else{
        //     return false;
        // }
    }


    public static function getCurrencyRate_autolev($amount, $from_currency, $to_currency){

        $webservice_config = array(
            'server' => 'converter'
        );

        $WebServiceA = new WebService($webservice_config);
        $convertDetails = array(
            'Amount' => $amount,
            'FromCurrency' => $from_currency,
            'ServiceLogin' => 505641,
            'ServicePassword' => '5fX#p8D^c89bQ',
            'ToCurrency' => $to_currency
        );
        $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
        $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
        if ($resultConvertCurrency['Status'] === 'RET_OK') {
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        } else {
            $convertedAmount=$amount;
        }

        return $convertedAmount;
    }


    public static function PayCo_isWallet($details) {
        $CI =& get_instance();
        $user_id = $CI->session->userdata('user_id');
        $result = '';

        $url = 'https://reseller.pay.co/api/reseller/iswallet/mid/' . trim($details['merchant_id']) . '/wallet/' . trim($details['wallet']);
        $access_name = trim($details['username']);
        $access_pass = trim($details['password']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $access_name . ':' . $access_pass);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $json_result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($json_result, true);

        return $result;
    }

    public static function PayCo_WalletBalance($details) {
        $CI =& get_instance();
        $user_id = $CI->session->userdata('user_id');
        $result = '';

        //if ($user_id == 60247 || $user_id == 60248) {
            $url = 'https://reseller.pay.co/api/reseller/walletbalance/mid/'. $details['merchant_id'] .'/wallet/' . $details['wallet'];
            $access_name = $details['username'];
            $access_pass = $details['password'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERPWD, $access_name . ':' . $access_pass);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $json_result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($json_result, true);
        //}
        return $result;
    }

    public static function PayCo_WalletTransfer($data) {
        if ($data['sender'] === 'M598357205') {
            $url = 'https://reseller.pay.co/api/reseller/wallettransfer/mid/' . trim($data['merchant_id']) . '/from/' . trim($data['sender']) . '/to/' . trim($data['receiver']) . '/amt/' . $data['amount'] . '/curr/' . $data['currency'] . '/pin/' . $data['wallet_pin'];
        } else {
            $url = 'https://reseller.pay.co/api/reseller/wallettransfer/mid/' . trim($data['merchant_id']) . '/from/' . trim($data['sender']) . '/to/' . trim($data['receiver']) . '/amt/' . $data['amount'] . '/curr/' . $data['currency'];
        }

        $access_name = trim($data['username']);
        $access_pass = trim($data['password']);

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_USERPWD, $access_name . ':' . $access_pass);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        if (strpos($url, "https") === false) {
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json_result = curl_exec($ch);
        $result = json_decode($json_result, true);

        curl_close($ch);

        return $result;
    }

    public static function PayCo_generateURLToken($email) {
        $username  = 'Forexmart'; //globness03
        $password = 'MZM8eGH4P3'; //gl0bn3ss03
        $private_key = 'jw9kilqse8'; //izplomt85g
        $_email  = $email;

        $returnData = array(
            'isError' => true,
            'data' => null,
            'message' => '',
        );

        $get_que = "username=$username&password=$password&private_key=$private_key&email=$_email";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://reseller.pay.co/api/reseller/RegistrationKey?".$get_que);
        curl_setopt($ch, CURLOPT_USERPWD, 'Forexmart' . ":" . 'MZM8eGH4P3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close ($ch);
        $obj = json_decode($json, true);

        if (isset($obj['Message']) && ($obj['Message'] == 'Process successful')) {
            $returnData['isError'] = false;
            $returnData['data'] = $obj['Data'];
        } else {
            $returnData['message'] = $obj['Message'];
        }

        return $returnData;
    }

    public static function PayCo_ResellerData($email) {
        $pkey = 'jw9kilqse8';

        $url = 'https://my.pay.co/api/reseller/ResellerData/pkey/' . $pkey . '?em=' . $email;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, 'Forexmart' . ":" . 'MZM8eGH4P3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($json, true);

        return $result;
    }

    public static function verifyLegitEmail($toemail, $fromemail, $getdetails = false){

        $details='';
        $email_arr = explode("@", $toemail);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];
        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");
        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }
        $mxhosts = array();
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);
        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }
            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {
                $result   = "invalid";
                $details .= "No suitable MX records found.";
                return ( (true == $getdetails) ? array($result, $details) : $result );
            }
        }

        $connect = @fsockopen($mx_ip, 25);
        if($connect){
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n");
                $out = fgets ($connect, 1024);
                $details .= $out."\n";

                fputs ($connect , "MAIL FROM: <$fromemail>\r\n");
                $from = fgets ($connect, 1024);
                $details .= $from."\n";
                fputs ($connect , "RCPT TO: <$toemail>\r\n");
                $to = fgets ($connect, 1024);
                $details .= $to."\n";
                fputs ($connect , "QUIT");
                fclose($connect);
                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid";
                }
                else{
                    $result = "valid";
                }
            }
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($getdetails){
            return array($result, $details);
        }
        else{
            return $result;
        }

    }

    public static function allowedBonuses($accountNumber){
        //28 = 30% bonus
        $allowedBonuses = array( 1,3,10 );
        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);

        foreach($getAccountBonusByType as $key => $bonus){
            if(in_array($key, $allowedBonuses)){
                return true;
            } elseif ($key == 28){
                return 28;
            }
        }

        return false;
    }

    public static function BackAgentOfAccount($account_number){

        $CI =& get_instance();
        $CI->load->model('general_model');
        $removedAgents = $CI->account_model->getRemovedAgent($account_number);
        if($removedAgents){
            $depositedAmount = FXPP::GetTotalDepositRealFund($account_number);
            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number, 2);
            if($depositedAmount >= $getAccountBonusByType){
                $service_data = array(
                    'AccountNumber' => $account_number,
                    'AgentAccountNumber' => $removedAgents['AgentAccountNumber']
                );
                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);
                $WebService->SetAccountAgent($service_data);
                if ($WebService->request_status === 'RET_OK') {
                    $CI->general_model->delete('removed_agents', 'Id', $removedAgents['Id']);
                }
            }
        }
    }

    public static function GetTotalDepositRealFund($account_number){
        $webservice_config = array('server' => 'live_new');
        $serviceTotalDepositedRf = new WebService($webservice_config);
        $serviceTotalDepositedRf->GetAccountTotalDepositedRealFund($account_number);
        if ($serviceTotalDepositedRf->request_status === 'RET_OK') {
            $returnDepositRf = $serviceTotalDepositedRf->get_all_result();
            return $returnDepositRf['Amount'];
        }
        return 0;
    }

    public static function GetAccountDetails_old($account_number){

        $webservice_config = array('iLogin'=>$account_number,'server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->RequestAccountDetails($webservice_config);

//        $CI =& get_instance();
//        $CI->load->library('WSV'); //New web service
//
//        $webservice_config = array('server' => 'live_new');
//        $account_info      = array('account_number' => [$account_number]);
//
//        $WebService = $CI->wsv->GetAccountDetailsSingle($account_info, $webservice_config);

        if($WebService->request_status === "RET_OK") {

            $totalAccount = (array)$WebService->get_all_result();//('AccountData');
//            $totalAccount = $WebService['Data'][0];//('AccountData');

            $IsEnable = $totalAccount['IsEnable'];
            if (strpos($totalAccount['Group'], 'Pa') !== false) {
                return $IsEnable ? true : false;
            }
            if (strpos($totalAccount['Group'], '-') !== false) {
                return $IsEnable ? true : false;
            }else{
                redirect('https://personal.forexmart.eu');
            }

        }

        return false;
    }

    public static function GetAccountDetails($account_number){

        $CI =& get_instance();
        $CI->load->library('WSV'); //New web service
        $WSV = new WSV();

        $account_info = array(
            'account_number' => [$account_number]
        );
        $WebService = $WSV->GetAccountDetails($account_info);

        if($WebService['ErrorMessage'] === "RET_OK") {

            $totalAccount = $WebService['Data'][0];

            $IsEnable = $totalAccount->IsEnable;
            if (strpos($totalAccount->Group, 'Pa') !== false) {
                return $IsEnable ? true : false;
            }
            if (strpos($totalAccount->Group, '-') !== false) {
                return $IsEnable ? true : false;
            }else{
                redirect('https://personal.forexmart.eu');
            }

        }

        return false;
    }

    public static function DepositBonusValidation($user_id, $bonus){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');

        $rtnData = array(
            'Error' => true,
            'ErrorMsg' => 'Invalid account details.'
        );

        
        
        $account_detail = $CI->account_model->getAccountByUserId($user_id);
        
        
        if(!$account_detail){
            $p_account_detail = $CI->account_model->getAccountByPartnerId($user_id);
            if(!$p_account_detail){                
                return $rtnData;
            }
        }
//        $user_mt_set = $CI->user_model->getUserDetailsMT($user_id);
        
        $user_details = $CI->user_model->getUserDetails($user_id);
        $user_mt_details = $CI->user_model->getUserDetailsMT($user_id);
        
        if(!$user_details){
            
             $p_user_details = $CI->user_model->getUserDetails($user_id);
             
             if(!$p_user_details){
                return $rtnData;
            }
        }

        if(!$user_mt_details){
             $user_mt_details = $CI->user_model->getPartnerDetailsMT($user_id);
        }

        /*if($user_details['accountstatus'] != 1){
            $rtnData['ErrorMsg'] = 'Account is not yet verified.';
            return $rtnData;
        }*/
        
            
        
/* ===============>FXPP-13280<======================== */
//        if (!in_array($user_details['accountstatus'], array('1','3'))) { //1 => verified level 2, 3 => verified level 1
//            $rtnData['ErrorMsg'] = 'Account is not yet verified.';
//            return $rtnData;
//        }


        if($user_details['nodepositbonus'] == 1){
            if($bonus === 'tenpb'){
            }else{
                $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus.';
                return $rtnData;
            }
        }

        $allowedBonuses = array(
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'twpb' => 'twentypercentbonus',
            'tdcb' => 'thirtydollarcreditbonus',
            'tenpb' => 'tenpercentbonus'
        );

        if(!array_key_exists($bonus, $allowedBonuses)){
            $rtnData['ErrorMsg'] = 'Bonus invalid.';
            return $rtnData;
        }


        $isNewAccountType = FXPP::fmGroupType($user_mt_details['account_number']);
        $getFirstBonus = self::getFirstDepositBonus($user_id);
        if($getFirstBonus){
            
            
            if($getFirstBonus == 'tpb'){ //FXPP-11064 old account type credited with 30% bonus  can be combined with 20% bonus.
                
                if(!$isNewAccountType && $bonus == 'twpb'){
                    $rtnData['ErrorMsg'] = '';
                    $rtnData['Error'] = false;
                    return $rtnData;
                }

            }

            if($isNewAccountType && $bonus == 'tpb'){ ///FXPP-11064 new account type  no 30% bonus but can be credited with 20% bonus
                $rtnData['ErrorMsg'] = 'Your account is not allowed to be credited with 30% bonus.';
                return $rtnData;
            }


            if($bonus != $getFirstBonus){
                if($bonus === 'tenpb'){
                }else{
                    $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus.';
                    return $rtnData;
                }
            }
        }


        $rtnData['ErrorMsg'] = '';
        $rtnData['Error'] = false;

        return $rtnData;

    }

    
    

    public static function isAllowFirstDepositBonus($user_id){
        $CI =& get_instance();

        $CI->load->model('deposit_model');
        
       $acc_data = $CI->deposit_model->getRowData("mt_accounts_set","user_id",$user_id);
       
       if($acc_data)
       {           
           
            
                $mt_set_id = $acc_data->mt_account_set_id;

                $depo_count=$CI->deposit_model->getNumberOfDepositsByUser($user_id);

                $mt_set_data=array(1,2,4,5,7); //Removed 6 (excluded because ForexMart Pro is not allowed in 10% bonus)
            
                if($depo_count<1 or $depo_count=="" or $depo_count==false)
                {
                    if(in_array($mt_set_id, $mt_set_data))
                    {
                        return true;
                    }else{
                        return false;
                    }


                }else{
                    return false;
                }
        
       }else{
           return false;
       }
    
        
        
    }
    

    public static function getFirstDepositBonus($user_id){
        $CI =& get_instance();

        $CI->load->model('deposit_model');
        $getFirstBonus = $CI->deposit_model->getFirstPercentBonusAcquired($user_id);

        if($getFirstBonus['twentypercentbonus'] == 1){
            return 'twpb';
        }
        if($getFirstBonus['thirtypercentbonus'] == 1){
            return 'tpb';
        }

        if($getFirstBonus['fiftypercentbonus'] == 1){
            return 'fpb';
        }

        if($getFirstBonus['tenpercentbonus'] == 1){
            return 'tenpb';
        }
        
        
        
        return false;
    }

public static function getBonusDataList($type_bonus=false)
{
      $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'hplb' => 'hundredpercentbonus',
            'rhpb' => 'regularhundredpercentbonus',            
            'fplb' => 'fiftypercentlimitedbonus',
            'tenpb' => 'tenpercentbonus', 
        );
    
      if($type_bonus)
      {
            return $depositBonusField[$type_bonus];
      }else{
        return $depositBonusField;
      }
}        
    

 public static function DepositBonusProcess_test($account_number, $amountDeposited, $user_id, $module, $bonus = 'tpb', $depositId){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');
        $CI->load->library('WSV');

        $depositBonusType = array(
            'twpb' => 0.2,
            'tpb' => 0.3,
            'fpb' => 0.5,
            'hplb' =>  1,
            'rhpb' =>  1,
            'fplb' => 0.5,
            'tenpb'=> 0.1
        );

        $depositBonusComment = array(
            'twpb' => 'FOREXMART WELCOME BONUS 20%',
            'tpb' => 'FOREXMART WELCOME BONUS 30%',
            'fpb' => 'FOREXMART WELCOME BONUS 50%',
            'hplb' => 'FOREXMART LIMITED BONUS 100%',
            'rhpb' => 'FOREXMART REGULAR BONUS 100%',
            'fplb' => 'FOREXMART LIMITED BONUS 50%',
            'tdcb' => 'FOREXMART CREDIT BONUS $30',
            'tenpb' => 'FOREXMART WELCOME BONUS 10%',
        );

        $depositBonusAPI = array(
            'twpb' => 'open_Deposit_20PercentBonus',
            'tpb' => 'open_Deposit_30PercentBonus',
            'fpb' => 'open_Deposit_50PercentBonus',
            'hplb' => 'open_Deposit_100PercentBonus',
            'rhpb' => 'open_Deposit_100PercentConstantBonus',            
            'fplb' => 'open_Deposit_50PercentBonus',
            'tenpb' => 'open_Deposit_20PercentBonus',
        );

        $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'hplb' => 'hundredpercentbonus',
            'rhpb' => 'regularhundredpercentbonus',            
            'fplb' => 'fiftypercentlimitedbonus',
            'tenpb' => 'tenpercentbonus',
        );

        $depositResult = array(
            'Error' => true,
            'ErrorMsg' => 'System error.'
        );

        $amountDeposited = (float) $amountDeposited;
        $bonusPercent = (float) $depositBonusType[$bonus];
        $amount = $amountDeposited * $bonusPercent;




        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $account_info = array(
            'AccountNumber' => $account_number,
            'Amount' => $amount,
            'Comment' => $depositBonusComment[$bonus],
            'ProcessByIP' => $CI->input->ip_address()
        );



        $date_bonus_acquired = date('Y-m-d H:i:s');
      //  $hasDeposit = $CI->deposit_model->hasBonusDeposit_general($user_id);
       // if ($hasDeposit){

//            if($module == 'ITS'){
//                $setBonus =  $CI->deposit_model->setBonusITS($account_number,2, $date_bonus_acquired);
//            }else {
//                $setBonus = $CI->deposit_model->updateDepositBonus_v2($user_id, 1, $date_bonus_acquired, $depositBonusField[$bonus], $depositId, $location = 1, 1);
//            }

            
     if($module == 'ITS'){      
         return "TTS";
     }else{

    return  "user_id=>".$user_id." [value]=>1 [date]=>".$date_bonus_acquired." [bonus]=>".$depositBonusField[$bonus]." [deposit id]=>".$depositId;
     }
            
            
            
            
//            
//             $WebService->{$depositBonusAPI[$bonus]}($account_info);
//            
//            if( $WebService->request_status != 'RET_OK' ) {
//                return $depositResult;
//            }
           

            $bonusArray_v1 = array(
                'AmountDeposited' => $amountDeposited,
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'UserId'    => $user_id,
                'AccountNumber' => $account_number,
                'TransactionPage' => $module,
                'Ticket'    => "",//$WebService->get_result('Ticket'),
                'BonusType' => $bonus,
                'DepositId' => $depositId,
                'BonusStatus' => 2
            );

            $bonusArray_v2 = array( //for neteller logs
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'Ticket'    => "",//WebService->get_result('Ticket'),
                'DepositId' => $depositId,
                'BonusStatus' => 2

            );

            
            

//            $resUpdateDep = $CI->deposit_model->updateUnprocessedBonus($depositId,$bonusArray_v2);
//            if(!$resUpdateDep){
//                $CI->deposit_model->insertDepositBonus($bonusArray_v1);
//            }
//            $CI->deposit_model->updateDepositBonusStatus_v1($user_id,$depositId,2);
//

            
            
            

        $depositResult['Error'] = false;
        $depositResult['ErrorMsg'] = '';
        return $depositResult;
    }
    
    public static function DepositBonusProcess($account_number, $amountDeposited, $user_id, $module, $bonus = 'tpb', $depositId){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');
        $CI->load->library('WSV');

        $depositBonusType = array(
            'twpb' => 0.2,
            'tpb' => 0.3,
            'fpb' => 0.5,
            'hplb' =>  1,
            'rhpb' =>  1,
            'fplb' => 0.5,
            'tenpb'=> 0.1
        );

        $depositBonusComment = array(
            'twpb' => 'FOREXMART WELCOME BONUS 20%',
            'tpb' => 'FOREXMART WELCOME BONUS 30%',
            'fpb' => 'FOREXMART WELCOME BONUS 50%',
            'hplb' => 'FOREXMART LIMITED BONUS 100%',
            'rhpb' => 'FOREXMART REGULAR BONUS 100%',
            'fplb' => 'FOREXMART LIMITED BONUS 50%',
            'tdcb' => 'FOREXMART CREDIT BONUS $30',
            'tenpb' => 'FOREXMART WELCOME BONUS 10%',
        );

        $depositBonusAPI = array(
            'twpb' => 'open_Deposit_20PercentBonus',
            'tpb' => 'open_Deposit_30PercentBonus',
            'fpb' => 'open_Deposit_50PercentBonus',
            'hplb' => 'open_Deposit_100PercentBonus',
            'rhpb' => 'open_Deposit_100PercentConstantBonus',            
            'fplb' => 'open_Deposit_50PercentBonus',
            'tenpb' => 'open_Deposit_20PercentBonus',
        );

        $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'hplb' => 'hundredpercentbonus',
            'rhpb' => 'regularhundredpercentbonus',            
            'fplb' => 'fiftypercentlimitedbonus',
            'tenpb' => 'tenpercentbonus',
        );

        $depositResult = array(
            'Error' => true,
            'ErrorMsg' => 'System error.'
        );

        $amountDeposited = (float) $amountDeposited;
        $bonusPercent = (float) $depositBonusType[$bonus];
        $amount = $amountDeposited * $bonusPercent;




        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService = new WebService($webservice_config);
        $account_info = array(
            'AccountNumber' => $account_number,
            'Amount' => $amount,
            'Comment' => $depositBonusComment[$bonus],
            'ProcessByIP' => $CI->input->ip_address()
        );



        $date_bonus_acquired = date('Y-m-d H:i:s');
      //  $hasDeposit = $CI->deposit_model->hasBonusDeposit_general($user_id);
       // if ($hasDeposit){

            if($module == 'ITS'){
                $setBonus =  $CI->deposit_model->setBonusITS($account_number,2, $date_bonus_acquired);
            }else {
                $setBonus = $CI->deposit_model->updateDepositBonus_v2($user_id, 1, $date_bonus_acquired, $depositBonusField[$bonus], $depositId, $location = 1, 1);
            }

           // $WebService->$depositBonusAPI[$bonus]($account_info); // deprecated in php 7
             $WebService->{$depositBonusAPI[$bonus]}($account_info);

        

            if( $WebService->request_status != 'RET_OK' ) {
                return $depositResult;
            }
           

            $bonusArray_v1 = array(
                'AmountDeposited' => $amountDeposited,
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'UserId'    => $user_id,
                'AccountNumber' => $account_number,
                'TransactionPage' => $module,
                'Ticket'    => $WebService->get_result('Ticket'),
                'BonusType' => $bonus,
                'DepositId' => $depositId,
                'BonusStatus' => 2
            );

            $bonusArray_v2 = array( //for neteller logs
                'AmountBonus'   => $amount,
                'DateProcessed' => $date_bonus_acquired,
                'Ticket'    => $WebService->get_result('Ticket'),
                'DepositId' => $depositId,
                'BonusStatus' => 2

            );


            $resUpdateDep = $CI->deposit_model->updateUnprocessedBonus($depositId,$bonusArray_v2);
            if(!$resUpdateDep){
                $CI->deposit_model->insertDepositBonus($bonusArray_v1);
            }
            $CI->deposit_model->updateDepositBonusStatus_v1($user_id,$depositId,2);



        if(!$setBonus){
            return $depositResult;
        }else{

            $country = $CI->account_model->getAccountsCountry($user_id);
            if($country[0]['country'] == 'CN'){
                $CI->session->set_userdata('isChina', '1');
            }

            if($bonus == 'fpb'){
                if($user_id <> '112913') {
                    self::update_account_group();
                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
                   // $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
                  
                    $groupCurrency =  substr($account_detail['group'], 0, -1);

                    $account_number = $account_detail['account_number'];
                    $user = $CI->user_model->getUserProfileByUserId($user_id);
                    if(in_array(strtoupper($user['country']), array('PL'))){
                        $account_info3 = array(
                            'iLogin' => $account_number,
                            'iLeverage' => '100'
                        );
                    }else{
                        $account_info3 = array(
                            'iLogin' => $account_number,
                            'iLeverage' => '200'
                        );
                    }

//                    $WebService3 = new WebService($webservice_config);
//                    $WebService3->open_ChangeAccountLeverage($account_info3);

                    $WebService3 = self::SetLeverage($account_number, $account_info3['iLeverage']);

                    if($WebService3->request_status === 'RET_OK'){
                        $CI->account_model->updateAccountLeverage($account_number, '1:' . $account_info3['iLeverage']);
                    }

                    $isMicro = $CI->account_model->isMicro($user_id);

                    if($isMicro){

                        if($country[0]['country'] == 'CN'){
                            $CI->session->set_userdata('isChina', '1');
                            $groupCurrency .= 'ndb-cn1';
                        }else{
                            $groupCurrency .= 'ndb1';
                        }

                    }else{

                            $groupCurrency .= '-b' . $account_detail['group_code'];

                    }

                    // double check the group code for non-eu country
                    // if the code has 'D-' and country is not from EU country then exit
                    // else append "D-" on the group code
                    if($country[0]['country'] <> 'CN') { // all nont EU except for CN
                        if (!self::isEuropeanCountrybyCountryCode($country[0]['country'])) {
                            $nonEUgroup = substr($groupCurrency, 0, 2); //return 1st two char
                            if ($nonEUgroup != "D-") {
                                $groupCurrency = "D-" . $groupCurrency;
                            }
                        }
                    }


//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);

                }
            }

            if($bonus == 'hplb' || $bonus == 'fplb'){
                if($user_id <> '112913') {
                    self::update_account_group();
                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
                   // $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
                   
                    $groupCurrency =  substr($account_detail['group'], 0, -1);
                    $account_number = $account_detail['account_number'];

                    $groupCurrency .= 'ndb' . $account_detail['group_code'];

//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);
                }
            }
        }
        
                if($bonus == 'rhpb'){

                    $country = $CI->account_model->getAccountsCountry($user_id);
                    if($country[0]['country'] == 'CN'){
                        $CI->session->set_userdata('isChina', '1');
                    }

                if($user_id <> '112913') {
                    self::update_account_group();
                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
                  //  $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
                   
                    $groupCurrency =  substr($account_detail['group'], 0, -1);
                    $account_number = $account_detail['account_number'];

//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency . 'b1',
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency . 'b1');
                }
            }      
            
        
        

        //if(IPLoc::Office()) {
            $RequestLogintype = $CI->account_model->getAccountLoginType($user_id);//GET LOG IN TYPE
            $WebService4 = new WebService($webservice_config);
            $WebService4->request_live_account_balance($account_number);
            if ($WebService4->request_status === 'RET_OK') {
                $balance = $WebService4->get_result('Balance');
                if ($RequestLogintype['login_type'] == 1) {
                    $CI->account_model->updatePartnerAccountBalance($account_number, $balance);//UPDATE PARTNERS' BALANCE(w/ BONUS)
                } else {
                    $CI->account_model->updateAccountBalance($account_number, $balance);//UPDATE CLIENTS' BALANCE(w/ BONUS)
                }

            }
        //}

        $depositResult['Error'] = false;
        $depositResult['ErrorMsg'] = '';
        return $depositResult;
    }

    public static function DepositBonusProcessNew($account_number, $amountDeposited, $user_id, $module, $bonus = 'tpb', $depositId){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');
        $CI->load->library('WSV');

        $depositBonusType = array(
            'twpb' => 0.2,
            'tpb' => 0.3,
            'fpb' => 0.5,
            'hplb' =>  1,
            'rhpb' =>  1,
            'fplb' => 0.5,
            'tenpb'=> 0.1
        );

        $depositBonusComment = array(
            'twpb' => 'FOREXMART WELCOME BONUS 20%',
            'tpb' => 'FOREXMART WELCOME BONUS 30%',
            'fpb' => 'FOREXMART WELCOME BONUS 50%',
            'hplb' => 'FOREXMART LIMITED BONUS 100%',
            'rhpb' => 'FOREXMART REGULAR BONUS 100%',
            'fplb' => 'FOREXMART LIMITED BONUS 50%',
            'tdcb' => 'FOREXMART CREDIT BONUS $30',
            'tenpb' => 'FOREXMART WELCOME BONUS 10%',
        );

        $depositBonusAPI = array( //from New API
            'twpb'  => 'BONUS_20_PERCENT',
            'tpb'   => 'BONUS_30_PERCENT',
            'fpb'   => 'BONUS_50_PERCENT',
            'hplb'  => 'BONUS_100_PERCENT',
            'rhpb'  => 'BONUS_100_PERCENT_CONSTANT',
            'fplb'  => 'BONUS_50_PERCENT',
            'tenpb' => 'BONUS_20_PERCENT',
        );

        $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'hplb' => 'hundredpercentbonus',
            'rhpb' => 'regularhundredpercentbonus',
            'fplb' => 'fiftypercentlimitedbonus',
            'tenpb' => 'tenpercentbonus',
        );

        $depositResult = array(
            'Error' => true,
            'ErrorMsg' => 'System error.'
        );

        $amountDeposited = (float) $amountDeposited;
        $bonusPercent = (float) $depositBonusType[$bonus];
        $amount = $amountDeposited * $bonusPercent;


        $date_bonus_acquired = date('Y-m-d H:i:s');

        if($module == 'ITS'){
            $setBonus =  $CI->deposit_model->setBonusITS($account_number,2, $date_bonus_acquired);
        }else {
            $setBonus = $CI->deposit_model->updateDepositBonus_v2($user_id, 1, $date_bonus_acquired, $depositBonusField[$bonus], $depositId, $location = 1, 1);
        }

        /**New API*/
        $WebService = self::CreditBonus($depositBonusAPI[$bonus], $amount, $depositBonusComment[$bonus], $account_number);


        if( $WebService['ErrorMessage'] != 'RET_OK' ) {
            return $depositResult;
        }


        $bonusArray_v1 = array(
            'AmountDeposited' => $amountDeposited,
            'AmountBonus'   => $amount,
            'DateProcessed' => $date_bonus_acquired,
            'UserId'    => $user_id,
            'AccountNumber' => $account_number,
            'TransactionPage' => $module,
            'Ticket'    => $WebService['Data']->Ticket,
            'BonusType' => $bonus,
            'DepositId' => $depositId,
            'BonusStatus' => 2
        );

        $bonusArray_v2 = array( //for neteller logs
            'AmountBonus'   => $amount,
            'DateProcessed' => $date_bonus_acquired,
            'Ticket'    => $WebService['Data']->Ticket,
            'DepositId' => $depositId,
            'BonusStatus' => 2

        );


        $resUpdateDep = $CI->deposit_model->updateUnprocessedBonus($depositId,$bonusArray_v2);
        if(!$resUpdateDep){
            $CI->deposit_model->insertDepositBonus($bonusArray_v1);
        }
        $CI->deposit_model->updateDepositBonusStatus_v1($user_id,$depositId,2);



        if(!$setBonus){
            return $depositResult;
        }else{

            $country = $CI->account_model->getAccountsCountry($user_id);
            if($country[0]['country'] == 'CN'){
                $CI->session->set_userdata('isChina', '1');
            }

            if($bonus == 'fpb'){
                if($user_id <> '112913') {
                    self::update_account_group();
                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
                    $groupCurrency =  substr($account_detail['group'], 0, -1);

                    $account_number = $account_detail['account_number'];
                    $user = $CI->user_model->getUserProfileByUserId($user_id);
                    if(in_array(strtoupper($user['country']), array('PL'))){
                        $account_info3 = array(
                            'iLogin' => $account_number,
                            'iLeverage' => '100'
                        );
                    }else{
                        $account_info3 = array(
                            'iLogin' => $account_number,
                            'iLeverage' => '200'
                        );
                    }

                    $WebService3 = self::SetLeverage($account_number, $account_info3['iLeverage']);

                    if($WebService3->request_status === 'RET_OK'){
                        $CI->account_model->updateAccountLeverage($account_number, '1:' . $account_info3['iLeverage']);
                    }

                    $isMicro = $CI->account_model->isMicro($user_id);

                    if($isMicro){

                        if($country[0]['country'] == 'CN'){
                            $CI->session->set_userdata('isChina', '1');
                            $groupCurrency .= 'ndb-cn1';
                        }else{
                            $groupCurrency .= 'ndb1';
                        }

                    }else{

                        $groupCurrency .= '-b' . $account_detail['group_code'];

                    }

                    // double check the group code for non-eu country
                    // if the code has 'D-' and country is not from EU country then exit
                    // else append "D-" on the group code
                    if($country[0]['country'] <> 'CN') { // all nont EU except for CN
                        if (!self::isEuropeanCountrybyCountryCode($country[0]['country'])) {
                            $nonEUgroup = substr($groupCurrency, 0, 2); //return 1st two char
                            if ($nonEUgroup != "D-") {
                                $groupCurrency = "D-" . $groupCurrency;
                            }
                        }
                    }


//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);

                }
            }

            if($bonus == 'hplb' || $bonus == 'fplb'){
                if($user_id <> '112913') {
                    self::update_account_group();
                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
                    // $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);

                    $groupCurrency =  substr($account_detail['group'], 0, -1);
                    $account_number = $account_detail['account_number'];

                    $groupCurrency .= 'ndb' . $account_detail['group_code'];

//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);
                }
            }
        }

        if($bonus == 'rhpb'){

            $country = $CI->account_model->getAccountsCountry($user_id);
            if($country[0]['country'] == 'CN'){
                $CI->session->set_userdata('isChina', '1');
            }

            if($user_id <> '112913') {
                self::update_account_group();
                $account_detail = $CI->account_model->getAccountByUserId($user_id);
                //  $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);

                $groupCurrency =  substr($account_detail['group'], 0, -1);
                $account_number = $account_detail['account_number'];

//                    $WebService2 = new WebService($webservice_config);
//                    $account_info2 = array(
//                        'iLogin' => $account_number,
//                        'strGroup' => $groupCurrency . 'b1',
//                    );
//                    $WebService2->open_ChangeAccountGroup($account_info2);

                $WebService2 = self::SetAccountGroup($account_number, $groupCurrency . 'b1');
            }
        }




        //if(IPLoc::Office()) {
        $RequestLogintype = $CI->account_model->getAccountLoginType($user_id);//GET LOG IN TYPE
        $WebService4 = new WebService($webservice_config);
        $WebService4->request_live_account_balance($account_number);
        if ($WebService4->request_status === 'RET_OK') {
            $balance = $WebService4->get_result('Balance');
            if ($RequestLogintype['login_type'] == 1) {
                $CI->account_model->updatePartnerAccountBalance($account_number, $balance);//UPDATE PARTNERS' BALANCE(w/ BONUS)
            } else {
                $CI->account_model->updateAccountBalance($account_number, $balance);//UPDATE CLIENTS' BALANCE(w/ BONUS)
            }

        }
        //}

        $depositResult['Error'] = false;
        $depositResult['ErrorMsg'] = '';
        return $depositResult;
    }

    public static function DepositBonus($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId){

        $depositBonusValidation = self::DepositBonusValidation($user_id, $bonus);

        if($depositBonusValidation['Error']){
            
            self::deposit_bonus_validation_log($user_id,$account_number,$module,$bonus,$depositId,$amountDeposited,$depositBonusValidation['ErrorMsg']);
            
            return false;
        }

        $depositBonusProcess = self::DepositBonusProcess($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

        if($depositBonusProcess['Error']){
            self::deposit_bonus_validation_log($user_id,$account_number,$module,$bonus,$depositId,$amountDeposited,$depositBonusProcess['ErrorMsg']);
            
            return false;
        }

        return true;

    }

    public static function DepositBonusNew($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId){

        $depositBonusValidation = self::DepositBonusValidation($user_id, $bonus);

        if($depositBonusValidation['Error']){

            self::deposit_bonus_validation_log($user_id,$account_number,$module,$bonus,$depositId,$amountDeposited,$depositBonusValidation['ErrorMsg']);

            return false;
        }

        $depositBonusProcess = self::DepositBonusProcessNew($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

        if($depositBonusProcess['Error']){
            self::deposit_bonus_validation_log($user_id,$account_number,$module,$bonus,$depositId,$amountDeposited,$depositBonusProcess['ErrorMsg']);

            return false;
        }

        return true;

    }
    
public static function deposit_bonus_validation_log($user_id,$account_number,$module,$bonus,$depositId,$amountDeposited,$error_data){
    
    $data=array(
        'account_number'=>$account_number,
        'module'=>$module,
        'bonus_type'=>$bonus,
        'deposit_id'=>$depositId,        
        'deposit_amount'=>$amountDeposited,
        'error'=>$error_data,
    );
    
    $log_data=array(
    'user_id'=>$user_id,
    'data'=>json_encode($data),
    'created_date'=>date("Y-m-d")    
    );
    
        $CI =& get_instance();
        $CI->load->model('General_model');
       $CI->General_model->insert('deposit_bonus_validation_log',$log_data);  
       
       
       return true;
}


 public static function DepositBonusProcessNew_frz_test($account_number, $amountDeposited, $user_id, $module, $bonus = 'tpb', $depositId){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');
        $CI->load->library('WSV');

        $depositBonusType = array(
            'twpb' => 0.2,
            'tpb' => 0.3,
            'fpb' => 0.5,
            'hplb' =>  1,
            'rhpb' =>  1,
            'fplb' => 0.5,
            'tenpb'=> 0.1
        );

        $depositBonusComment = array(
            'twpb' => 'FOREXMART WELCOME BONUS 20%',
            'tpb' => 'FOREXMART WELCOME BONUS 30%',
            'fpb' => 'FOREXMART WELCOME BONUS 50%',
            'hplb' => 'FOREXMART LIMITED BONUS 100%',
            'rhpb' => 'FOREXMART REGULAR BONUS 100%',
            'fplb' => 'FOREXMART LIMITED BONUS 50%',
            'tdcb' => 'FOREXMART CREDIT BONUS $30',
            'tenpb' => 'FOREXMART WELCOME BONUS 10%',
        );

        $depositBonusAPI = array( //from New API
            'twpb'  => 'BONUS_20_PERCENT',
            'tpb'   => 'BONUS_30_PERCENT',
            'fpb'   => 'BONUS_50_PERCENT',
            'hplb'  => 'BONUS_100_PERCENT',
            'rhpb'  => 'BONUS_100_PERCENT_CONSTANT',
            'fplb'  => 'BONUS_50_PERCENT',
            'tenpb' => 'BONUS_20_PERCENT',
        );

        $depositBonusField = array(
            'twpb' => 'twentypercentbonus',
            'tpb' => 'thirtypercentbonus',
            'fpb' => 'fiftypercentbonus',
            'hplb' => 'hundredpercentbonus',
            'rhpb' => 'regularhundredpercentbonus',
            'fplb' => 'fiftypercentlimitedbonus',
            'tenpb' => 'tenpercentbonus',
        );

        $depositResult = array(
            'Error' => true,
            'ErrorMsg' => 'System error.'
        );
        
        
        echo "--------->amountDeposited =>[".$amountDeposited."] depositBonusType percent =====>[".$depositBonusType[$bonus]."]------------------->";
        

        $amountDeposited = (float) $amountDeposited;
        $bonusPercent = (float) $depositBonusType[$bonus];
        $amount = $amountDeposited * $bonusPercent;


        $date_bonus_acquired = date('Y-m-d H:i:s');

        echo "================>amountDeposited =>[".$amountDeposited."] bonusPercent=====>]".$bonusPercent."]======____=======>".$depositBonusAPI[$bonus]."==============>".$amount."================>".$account_number;
        
//        
//        if($module == 'ITS'){
//            $setBonus =  $CI->deposit_model->setBonusITS($account_number,2, $date_bonus_acquired);
//        }else {
//            $setBonus = $CI->deposit_model->updateDepositBonus_v2($user_id, 1, $date_bonus_acquired, $depositBonusField[$bonus], $depositId, $location = 1, 1);
//        }

        /**New API*/
//        $WebService = self::CreditBonus($depositBonusAPI[$bonus], $amount, $depositBonusComment[$bonus], $account_number);
//
//
//        if( $WebService['ErrorMessage'] != 'RET_OK' ) {
//            return $depositResult;
//        }
//        
        $ticket="333";//$WebService['Data']->Ticket;


        $bonusArray_v1 = array(
            'AmountDeposited' => $amountDeposited,
            'AmountBonus'   => $amount,
            'DateProcessed' => $date_bonus_acquired,
            'UserId'    => $user_id,
            'AccountNumber' => $account_number,
            'TransactionPage' => $module,
            'Ticket'    => $ticket,
            'BonusType' => $bonus,
            'DepositId' => $depositId,
            'BonusStatus' => 2
        );

        $bonusArray_v2 = array( //for neteller logs
            'AmountBonus'   => $amount,
            'DateProcessed' => $date_bonus_acquired,
            'Ticket'    => $ticket,
            'DepositId' => $depositId,
            'BonusStatus' => 2

        );
        
        
        print_r($bonusArray_v1);
        echo "--------------================================----------------";
        print_r($bonusArray_v2);
        exit;

//
//        $resUpdateDep = $CI->deposit_model->updateUnprocessedBonus($depositId,$bonusArray_v2);
//        if(!$resUpdateDep){
//            $CI->deposit_model->insertDepositBonus($bonusArray_v1);
//        }
//        $CI->deposit_model->updateDepositBonusStatus_v1($user_id,$depositId,2);
//


//        if(!$setBonus){
//            return $depositResult;
//        }else{
//
//            $country = $CI->account_model->getAccountsCountry($user_id);
//            if($country[0]['country'] == 'CN'){
//                $CI->session->set_userdata('isChina', '1');
//            }
//
//            if($bonus == 'fpb'){
//                if($user_id <> '112913') {
//                    self::update_account_group();
//                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
//                    $groupCurrency =  substr($account_detail['group'], 0, -1);
//
//                    $account_number = $account_detail['account_number'];
//                    $user = $CI->user_model->getUserProfileByUserId($user_id);
//                    if(in_array(strtoupper($user['country']), array('PL'))){
//                        $account_info3 = array(
//                            'iLogin' => $account_number,
//                            'iLeverage' => '100'
//                        );
//                    }else{
//                        $account_info3 = array(
//                            'iLogin' => $account_number,
//                            'iLeverage' => '200'
//                        );
//                    }
//
//                    $WebService3 = self::SetLeverage($account_number, $account_info3['iLeverage']);
//
//                    if($WebService3->request_status === 'RET_OK'){
//                        $CI->account_model->updateAccountLeverage($account_number, '1:' . $account_info3['iLeverage']);
//                    }
//
//                    $isMicro = $CI->account_model->isMicro($user_id);
//
//                    if($isMicro){
//
//                        if($country[0]['country'] == 'CN'){
//                            $CI->session->set_userdata('isChina', '1');
//                            $groupCurrency .= 'ndb-cn1';
//                        }else{
//                            $groupCurrency .= 'ndb1';
//                        }
//
//                    }else{
//
//                        $groupCurrency .= '-b' . $account_detail['group_code'];
//
//                    }
//            
//                    if($country[0]['country'] <> 'CN') { // all nont EU except for CN
//                        if (!self::isEuropeanCountrybyCountryCode($country[0]['country'])) {
//                            $nonEUgroup = substr($groupCurrency, 0, 2); //return 1st two char
//                            if ($nonEUgroup != "D-") {
//                                $groupCurrency = "D-" . $groupCurrency;
//                            }
//                        }
//                    }
//            
//
//                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);
//
//                }
//            }
//
//            if($bonus == 'hplb' || $bonus == 'fplb'){
//                if($user_id <> '112913') {
//                    self::update_account_group();
//                    $account_detail = $CI->account_model->getAccountByUserId($user_id);
//                    // $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
//
//                    $groupCurrency =  substr($account_detail['group'], 0, -1);
//                    $account_number = $account_detail['account_number'];
//
//                    $groupCurrency .= 'ndb' . $account_detail['group_code'];
//            
//
//                    $WebService2 = self::SetAccountGroup($account_number, $groupCurrency);
//                }
//            }
//        }

//        if($bonus == 'rhpb'){
//
//            $country = $CI->account_model->getAccountsCountry($user_id);
//            if($country[0]['country'] == 'CN'){
//                $CI->session->set_userdata('isChina', '1');
//            }
//
//            if($user_id <> '112913') {
//                self::update_account_group();
//                $account_detail = $CI->account_model->getAccountByUserId($user_id);
//                //  $groupCurrency = $CI->general_model->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
//
//                $groupCurrency =  substr($account_detail['group'], 0, -1);
//                $account_number = $account_detail['account_number'];
//            
//
//                $WebService2 = self::SetAccountGroup($account_number, $groupCurrency . 'b1');
//            }
//        }




//            
//        $RequestLogintype = $CI->account_model->getAccountLoginType($user_id);//GET LOG IN TYPE
//        $WebService4 = new WebService($webservice_config);
//        $WebService4->request_live_account_balance($account_number);
//        if ($WebService4->request_status === 'RET_OK') {
//            $balance = $WebService4->get_result('Balance');
//            if ($RequestLogintype['login_type'] == 1) {
//                $CI->account_model->updatePartnerAccountBalance($account_number, $balance);//UPDATE PARTNERS' BALANCE(w/ BONUS)
//            } else {
//                $CI->account_model->updateAccountBalance($account_number, $balance);//UPDATE CLIENTS' BALANCE(w/ BONUS)
//            }
//
//        }
            

        $depositResult['Error'] = false;
        $depositResult['ErrorMsg'] = '';
        return $depositResult;
    }


    //100 % regular bonus
     public static function DepositRegular100PercentBonus($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId,$maxNumofDeposit=2){

        $depositBonusValidation = self::DepositRegular100BonusValidation($user_id, $amountDeposited,$maxNumofDeposit);
       //  var_dump($depositBonusValidation);

        if($depositBonusValidation['Error']){
            return false;
        }
        else
        {
            

                $depositBonusProcess = self::DepositBonusProcess($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

                if($depositBonusProcess['Error']){
                    return false;
                }
                else
                {
//                    $levData=array(
//                        'account_number'=>$account_number,
//                        'leverage'=>200,
//                    );

                    $WebService = self::SetLeverage($account_number, 200);

                    if( $WebService->request_status === 'RET_OK' ) {
                        $mtdata['lev_ratio']=array(
                            'leverage'=>'1:200',
                            'auto_leverage_change'=>1
                        );
                        self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $user_id, $mtdata['lev_ratio']);
                    }
                    
                    return true;
                }
        }
            

    }

    public static function DepositRegular100PercentBonusNew($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId,$maxNumofDeposit=2){

        $depositBonusValidation = self::DepositRegular100BonusValidation($user_id, $amountDeposited,$maxNumofDeposit);
        //  var_dump($depositBonusValidation);

        if($depositBonusValidation['Error']){
            return false;
        }
        else
        {


            $depositBonusProcess = self::DepositBonusProcessNew($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

            if($depositBonusProcess['Error']){
                return false;
            }
            else
            {
//                    $levData=array(
//                        'account_number'=>$account_number,
//                        'leverage'=>200,
//                    );

                $WebService = self::SetLeverage($account_number, 200);

                if( $WebService->request_status === 'RET_OK' ) {
                    $mtdata['lev_ratio']=array(
                        'leverage'=>'1:200',
                        'auto_leverage_change'=>1
                    );
                    self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $user_id, $mtdata['lev_ratio']);
                }

                return true;
            }
        }


    }


    public static function DepositRegular100BonusValidation($user_id,$amount=0,$maxNumofDeposit){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');

        $rtnData = array(
            'Error' => true,
            'ErrorMsg' => 'Invalid account details.'
        );

        $account_detail = $CI->account_model->getAccountByUserId($user_id);
        if(!$account_detail){
            return $rtnData;
        }

        $user_details = $CI->user_model->getUserDetails($user_id);
        if(!$user_details){
            return $rtnData;
        }

       
        if (!in_array($user_details['accountstatus'], array('1','3'))) { //1 => verified level 2, 3 => verified level 1
            $rtnData['ErrorMsg'] = 'Account is not yet verified.';
            return $rtnData;
        }
        
         $whr=array("users.email"=>$user_details['email']);
         $cjoin=array("deposit__inner"=>"users.id= deposit.user_id");
         $checkDeposit=$CI->general_model->getQueryOneObject("users","count(deposit.user_id) noOfdeposit",$whr,$cjoin);
         if($checkDeposit->noOfdeposit>$maxNumofDeposit)   
         {
            $rtnData['ErrorMsg'] = "It's not new deposit";
            return $rtnData; 
         }   
            
        
        $rtnData['ErrorMsg'] = '';
        $rtnData['Error'] = false;

        return $rtnData;

    }
    public static function Deposit100PercentBonus($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId){

        $depositBonusValidation = self::Deposit100BonusValidation($user_id, $amountDeposited);

        if($depositBonusValidation['Error']){
            return false;
        }

        if($amountDeposited>2000){
            $bonus = "fplb";
        }else{
            $bonus = "hplb";
        }

        $depositBonusProcess = self::DepositBonusProcess($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

        if($depositBonusProcess['Error']){
            return false;
        }

        return true;

    }

    public static function Deposit100PercentBonusNew($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId){

        $depositBonusValidation = self::Deposit100BonusValidation($user_id, $amountDeposited);

        if($depositBonusValidation['Error']){
            return false;
        }

        if($amountDeposited>2000){
            $bonus = "fplb";
        }else{
            $bonus = "hplb";
        }

        $depositBonusProcess = self::DepositBonusProcessNew($account_number, $amountDeposited, $user_id, $module, $bonus, $depositId);

        if($depositBonusProcess['Error']){
            return false;
        }

        return true;

    }

    public static function Deposit100BonusValidation($user_id,$amount=0){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('user_model');
        $CI->load->model('deposit_model');

        $rtnData = array(
            'Error' => true,
            'ErrorMsg' => 'Invalid account details.'
        );

        $account_detail = $CI->account_model->getAccountByUserId($user_id);
        if(!$account_detail){
            return $rtnData;
        }

        $user_details = $CI->user_model->getUserDetails($user_id);
        if(!$user_details){
            return $rtnData;
        }

       if (!in_array($user_details['accountstatus'], array('1','3'))) { //1 => verified level 2, 3 => verified level 1
            $rtnData['ErrorMsg'] = 'Account is not yet verified.';
            return $rtnData;
        }


        if($user_details['nodepositbonus'] == 1){
            $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus.';
            return $rtnData;
        }

        if($row = $CI->general_model->whereCondition("limited_bouns",array('user_id'=>$user_id,'type'=>0))){

           if(strtotime($row['login_time']) < strtotime(date('Y-m-d h:i:s')) - (60*60*24*2)){
               $rtnData['ErrorMsg'] = 'Limited bonus time out!';
               return $rtnData;
           }

        }

        /*if($CI->general_model->whereCondition("deposit",array('user_id'=>$user_id,'hundredpercentbonus'=>1))){
            $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus';
            return $rtnData;
        }
        if($CI->general_model->whereCondition("deposit",array('user_id'=>$user_id,'fiftypercentlimitedbonus'=>1))){
            $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus';
            return $rtnData;
        }*/

        // But if he already has regular 50% bonus and he wants to get limited 50% bonus by depositing more than 2000 USD, then will allow him to do that.
        if($amount<=2000){
            if($CI->general_model->whereCondition("deposit",array('user_id'=>$user_id,'fiftypercentbonus'=>1))){
                $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus.';
                return $rtnData;
            }
        }

        if($CI->general_model->whereCondition("deposit",array('user_id'=>$user_id,'thirtypercentbonus'=>1))){
            $rtnData['ErrorMsg'] = 'Bonuses cannot be mixed in one account. You can register a new account to get the other bonus.';
            return $rtnData;
        }

        $rtnData['ErrorMsg'] = '';
        $rtnData['Error'] = false;

        return $rtnData;

    }
    public static function isSupporterAccounts($account_number){
        
        if(IPLoc::frz(true)){
            return false;
        }
        
        $webservice_config = array(
            'server' => 'live_new'
        );
        $WebService3 = new WebService($webservice_config);
        $WebService3->GetSupporterBonusFunds($account_number);
        if ($WebService3->request_status === 'RET_OK') {
            if(($WebService3->get_result('SupporterFullCount') + $WebService3->get_result('SupporterPartCount')) >0){ // If count is greater then 0 then it is supporter account
                return true;
            }
        }
        return false;

    }
    
     public static function getAllACcount($user_id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model'); 
            
//            $all_accounts= $ci->general_model->getQueryStirngRow('all_accounts',"*",array('user_id'=>$user_id));
            $all_accounts= $ci->general_model->whereConditionQueryRow($user_id);
            if($all_accounts)
            {  return $all_accounts;}
            else { return false;}
    }
    public static function  curLan($method=null){
        $ci =& get_instance(); 
        if($method)
        {
            $curl= base_url().self::html_url()."/".$method;
            $ci->session->set_userdata('pmlred', $curl);  
            return true;
        }
        else
        {            
            return $ci->session->userdata('pmlred');            
        }
        
         
        
    }
            
      public static function  failedDepositInformer(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model'); 
        
        
            
        if(IPLoc::for_id_only() || IPLoc::for_my_only())
        {
            
             $user_id=$ci->session->userdata('user_id');             
             
              $uwhereData=array('user_id'=>$user_id);
              $userProfile=$ci->general_model->getQueryStringRow('user_profiles','*',$uwhereData,'id','DESC','1');

             $cwhereData=array('user_id'=>$user_id);
             $cserProfile=$ci->general_model->getQueryStringRow('contacts','*',$cwhereData);

             $countryName=$ci->general_model->getCountries($userProfile->country);
            
            
             $edatas['email_data']=array(
                'Email'=>$ci->session->userdata('email'),
                'Phone '=>(($cserProfile->phone1)?$cserProfile->phone1:$cserProfile->phone2),
                'City'=>$userProfile->city,
                'Country'=>$countryName,
                'Name'=>$userProfile->full_name,
                'Status'=>'Interested',
            );

            
            
            if(IPLoc::for_id_only())
            {
                $subject = "Active Indonesian Client Report";
                $edatas['email_data']['heading']='Active Indonesian Client Report';
                $ci->general_model->sendEmailVisitor('default_mail', $subject,'id_a_clients@forexmart.com', $edatas, "",null);

            }
            if(IPLoc::for_my_only())
            {
                $subject = "Active Malaysian Client Report";
                $edatas['email_data']['heading']='Active Malaysian Client Report';
                $ci->general_model->sendEmailVisitor('default_mail', $subject,'my_a_clients@forexmart.com', $edatas, "",null);
            }
            
        }
            
    }




    public static function activate_trading_API($userid,$account_number){

        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebServiceTrading = new WebService($webservice_config);

        $account_info = array(
            'AccountNumber' => $account_number
        );

        $WebServiceTrading->open_ActivateAccountTrading($account_info);

        if( $WebServiceTrading->request_status === 'RET_OK' ) {
            self::CI()->g_m->updatemy($table = "mt_accounts_set", "user_id", $userid, array('open_trading' => 1, 'mt_status' => 1));

            return true;
        }else{

            return false;
        }

    }


    public static function deactivate_trading_API($userid,$account_number){

        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebServiceTrading = new WebService($webservice_config);

        $account_info = array(
            'AccountNumber' => $account_number
        );

        $WebServiceTrading->open_DeactivateAccountTrading($account_info);

        if( $WebServiceTrading->request_status === 'RET_OK' ) {
            self::CI()->g_m->updatemy($table = "mt_accounts_set", "user_id", $userid, array('open_trading' => 0,  'mt_status' => ''));

            return true;
        }else{

            return false;
        }

    }
    public static function get_convert_amount($currency, $amount, $to_currency = 'USD')
    {
        if ($currency == $to_currency) {
            $conv_amount = $amount;
        } else {

            $currency_convert_config = array(
                'server' => 'converter',
                'service_id' => '505641',
                'service_password' => '5fX#p8D^c89bQ'
            );

            $WebService = new WebService($currency_convert_config);
            $data = array(
                'amount' => $amount,
                'from_currency' => strtoupper(trim($currency)),
                'to_currency' => $to_currency
            );

            $WebService->convert_currency_amount($data);
            if ($WebService->request_status === 'RET_OK' || $WebService->request_status === 'RET_GAP') {
                $converted_amount = $WebService->get_result('ToAmount');
                $conv_amount = number_format($converted_amount, 2);
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }
    /*Method added for auto crediting NDB method from admin */
    public static function GetAccountAgent($account_number){

        $CI =& get_instance();
        $CI->load->library('WSV'); //New web service

        $webservice_config = array('server' => 'live_new');
//        $WebServiceCheck = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number );
//        $WebServiceCheck->open_RequestAccountDetails($account_info);

        $WebServiceCheck = $CI->wsv->GetAccountDetailsSingle($account_info, $webservice_config);

        if($WebServiceCheck->request_status === 'RET_OK'){
//            $accountDetails = $WebServiceCheck->get_all_result();
            $accountDetails = $WebServiceCheck->result;
            $getAccountAgent = $accountDetails['Agent'];
            if ($getAccountAgent==0){
                return false;
            }else{
                return $getAccountAgent;
            }

        }else{
            return 'error';
        }

    }

    public static function GetAccountAgentFromDB($user_id){
        self::CI()->load->model('general_model');
        self::CI()->g_m=self::CI()->general_model;
        self::CI()->load->model('account_model');

        $affiliate_data = self::CI()->g_m->whereCondition('users_affiliate_code',array('users_id'=>$user_id));
        if($affiliate_data['referral_affiliate_code']){
          $account_agent =  self::CI()->account_model->getAccountNumberByCode($affiliate_data['referral_affiliate_code'])['account_number'];
        }else{
            $account_agent = '';
        }
        $result = array(
            'agent' => $account_agent,
            'agent_code' =>$affiliate_data['referral_affiliate_code']
        );

        return $result;

    }

    public static function insert_ndblogs($argument){
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $data['insert_ndblogs']=array(
            'admin_user_id'=>$argument['admin_user_id'],
            'user_id'=>$argument['user_id'],
            'date_api'=>FXPP::getServerTime(),
            'account_number'=>$argument['account_number'],
            'amount'=>$argument['amount'],
            'location'=>$argument['location'],
        );
        self::CI()->g_m->insertmy($table='ndb_logs',$data=$data['insert_ndblogs']);
    }
    /*Method added for auto crediting NDB method from admin */



    public static function isCashback($user_id){
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;

        if( $row_array = self::CI()->g_m->whereCondition('users_affiliate_code',array('users_id'=>$user_id))){
            if($row_array['referral_affiliate_code'] == 'IHXBM'){
                return true;
            }
        }
        return false;
    }

    public static function getCurrencybase_v2(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('account_model');
        $user_id = $ci->session->userdata('user_id');
        $getCur = $ci->account_model->getAccountByUserId($user_id);
        $currency_conv = $getCur['mt_currency_base'];

        return $currency_conv;
    }


    public static function getBonusProfit($account_info = array()){
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_GetAccountTotalProfitFromRange($account_info);

        if($WebService->request_status ==='RET_OK'){
            $bonus_funds = array(
                'profit' => $WebService->get_result('TotalProfit')
            );
        }

        return $bonus_funds;
    }


    public function RemoveBonus($BonusData){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->model('general_model');
        $CI->load->model('deposit_model');

        $accountNumber = $BonusData['Account_number'];
        $user_id = $BonusData['UserId'];

        $transaction_id = $BonusData['TransactionId'];
        $transaction_type = $BonusData['TransactionType'];
        $ndbBonusprofit = $BonusData['ndbBonusprofit'];
        $isCancelprofit = $BonusData['isCancelprofit'];

        $getAccountBonusByType = self::getAccountBonusByType($accountNumber);

        foreach($getAccountBonusByType as $key => $bonuses){

            if($bonuses > 0){
                $removeContestBonusParams = array(

                    'amount' => $bonuses,
                    'account_number' => $accountNumber,
                    'user_id' => $user_id,
                    'bonus_id' => $key,
                    'transaction_id' => $transaction_id,
                    'transaction_type' => $transaction_type,
                    'remainingBonus' => $BonusData['removebalance']
                );

                if($isCancelprofit){
                    $removeContestBonusParams['ndbBonusprofitAmount'] = $ndbBonusprofit;
                    $removeContestBonusParams['profit_comment'] = 'BONUS PROFIT CLEAN UP';
                    $removeContestBonusParams['isBonusCancelprofit'] = $isCancelprofit;
                }


                $encodeNdbProfitLogs = json_encode($removeContestBonusParams);
                $insertProfitLogs = array(
                    'logs' => $encodeNdbProfitLogs,
                    'User_Id' => $user_id
                );
                $CI->deposit_model->insertNdbCancellationLogs($insertProfitLogs);

                self::processRemovingBonus($removeContestBonusParams);

            }
        }

    }


    public function processRemovingBonus($params){
        $ci =& get_instance();
        $ci->load->model('Withdraw_model');


        $removeBonusesComment =  array(
            2 => 'FM NO DEPOSIT BONUS CANCELLATION'
        );

        $depositMethods = array(
            2 => 'Deposit_NoDepositBonus'
        );

        if($params['remainingBonus'] > 0){
            $amount = $params['remainingBonus'];
        }else{
            $amount = $params['amount'];
        }

        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $bonusId = $params['bonus_id'];
        $withdraw_id = $params['transaction_id'];
        $transaction_type = $params['transaction_type'];
        $comment = $removeBonusesComment[$bonusId];
        $fund_status = 1;

        $webservice_config = array(
            'server' => 'live_new'
        );

        $remove_amount = $amount * -1;

        if($params['isBonusCancelprofit']){
            $remove_amount = $params['ndbBonusprofitAmount'] * -1;
            $amount = $params['ndbBonusprofitAmount'];
            $comment = $params['profit_comment'];
            $bonusId = 2;
            $fund_status = 2;
        }

        $account_info = array(
            'Amount' => $remove_amount,
            'Comment' => $comment,
            'AccountNumber' => $account_number,
            'Method' => $depositMethods[$bonusId]
        );

        $WebService = new WebService($webservice_config);
        $WebService->RequestCommonMethodBonus($account_info);
        $result = $WebService->result;

        if ($WebService->request_status === 'RET_OK') {

            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $withdraw_data = array(
                'Account_number' => $account_number,
                'User_id' => $userId,
                'Date' => $date,
                'Ticket' => $result['Ticket'],
                'Amount' => $amount,
                'Bonus_id' => $bonusId,
                'Transaction_id' => $withdraw_id,
                'Transaction_type' => $transaction_type,
                'Is_realfund' => $fund_status
            );

            $ci->Withdraw_model->insertWithdrawBonus($withdraw_data);
        }
    }
    

    public function BonusProfitCancellation($user_id, $AccountNumber, $DepAmount, $depositID){
       

            $CI =& get_instance();
            $CI->load->model('account_model');
            $CI->load->model('general_model');
            $CI->load->model('deposit_model');
            $CI->load->libary('WSV');

            $isdNDBBonusCanceled = $CI->deposit_model->getWithdrawNDB($AccountNumber);
            if($isdNDBBonusCanceled) {
               return false; // return if NDB is already canceled [bonus_id => 2]
            }
        
            $webservice_config = array('server' => 'live_new');
        
//            $WebServiceRequestAccountFunds = new WebService($webservice_config);
//            $WebServiceRequestAccountFunds->RequestAccountFunds($AccountNumber);
//            $TotalRealFund = $WebServiceRequestAccountFunds->get_result('TotalRealFund');
//            $TotalBonusFund = $WebServiceRequestAccountFunds->get_result('TotalBonusFund');
//            $TotalEquity = $WebServiceRequestAccountFunds->get_result('TotalRealFund');
//            $TotalBalance = $WebServiceRequestAccountFunds->get_result('Balance');

            if(IPLoc::APIUpgradeDevIP()){

                $CI->load->library('WSV'); //New web service

                $WebServiceRequestAccountFunds = $CI->wsv->GetAccountFunds($AccountNumber);

                if($WebServiceRequestAccountFunds->request_status === "RET_OK"){
                    $TotalRealFund  = $WebServiceRequestAccountFunds->result['TotalRealFund'];
                    $TotalBonusFund = $WebServiceRequestAccountFunds->result['TotalBonusFund'];
                    $TotalEquity    = $WebServiceRequestAccountFunds->result['TotalRealFund'];
                    $TotalBalance   = $WebServiceRequestAccountFunds->result['Balance'];
                }

            }else{

                $WebServiceRequestAccountFunds= new WebService($webservice_config);
                $WebServiceRequestAccountFunds->RequestAccountFunds($AccountNumber);

                $TotalRealFund  = $WebServiceRequestAccountFunds->get_result('TotalRealFund');
                $TotalBonusFund = $WebServiceRequestAccountFunds->get_result('TotalBonusFund');
                $TotalEquity    = $WebServiceRequestAccountFunds->get_result('TotalRealFund');
                $TotalBalance   = $WebServiceRequestAccountFunds->get_result('Balance');

            }

            $bonuses = FXPP::getAccountBonusByType($AccountNumber);


            $getUserDetail = $CI->account_model->getUserDetailsByUserId($user_id);
        
//            $WebServiceRequestAccDetails = new WebService($webservice_config);
//            $data = array(
//                'iLogin' => $AccountNumber
//            );
//            $WebServiceRequestAccDetails->request_account_details($data);

            $WebServiceRequestAccDetails = self::GetAllAccountDetails($AccountNumber);
            if ($WebServiceRequestAccDetails['ErrorMessage'] === 'RET_OK') {
                $from = date('Y-m-d\TH:i:s', $WebServiceRequestAccDetails['Data'][0]->RegDate);
            }
        
//            $to = Date('Y/d/m',strtotime(FXPP::getCurrentDateTime()));
//            $data['to'] = DateTime::createFromFormat('Y/d/m', date($to));

//            $WebServiceTime = new WebService($webservice_config);
//            $WebServiceTime->open_GetServerTime();
//            $serverTime = $WebServiceTime->get_all_result();

            $serverTime = self::getServerTime();

            $account_info = array(
                'iLogin' => $AccountNumber,
                'from' => $from,
                'to' => $serverTime
            );



        $WebServiceRequestProfit = new WebService($webservice_config);
        $WebServiceRequestProfit->open_GetAccountTotalProfitFromRange($account_info);

        if ($WebServiceRequestProfit->request_status === 'RET_OK') {
            $BonusProfit = $WebServiceRequestProfit->get_result('TotalProfit');
            $Commission = $WebServiceRequestProfit->get_result('TotalCommission');
            $Swap = $WebServiceRequestProfit->get_result('TotalSwaps');
        } else {
            $BonusProfit = 0;
            $Commission = 0;
            $Swap = 0;
        }


        $removeBonusArray = array(
            'Account_number' => $AccountNumber,
            'UserId' => $user_id,
            'TransactionId' => $depositID,
            'TransactionType' => "Withdraw"
        );

        //*****Cancel Remaining NDB bonus instead of cancelling full NDB to avoid Negative Balance
        //*****FXPP-8487

        if ($BonusProfit <= 0) {
            if ($TotalBalance > 0) {
                $bonusBalance = $TotalBalance - $DepAmount;
                if ($bonusBalance > 0) {
                    $removeBonusArray['removebalance'] = $bonusBalance;
                } else {
                    $removeBonusArray['removebalance'] = 0;}
            } else {
                $removeBonusArray['removebalance'] = 0;
            }
        }

        //*****FXPP-8487

                $NewBonusProfit = $BonusProfit + $Commission + $Swap;

         //   if ($BonusProfit > 0) {
                if ($DepAmount >= $NewBonusProfit) {
                    self::removeBonus($removeBonusArray);
                    $no = 1;
                } else {
                    $no = 2;
                    $PartialProfit = $NewBonusProfit - $DepAmount;
                    $removeBonusProfitArray = array(
                        'Account_number' => $AccountNumber,
                        'UserId' => $user_id,
                        'TransactionId' => $depositID,
                        'TransactionType' => "Withdraw",
                        'ndbBonusprofit' => $PartialProfit,
                        'isCancelprofit' => true
                    );
                    self::removeBonus($removeBonusArray);// Remove NDB bonus
                    if ($PartialProfit > 0) {
                        $no = 3;
                        self::removeBonus($removeBonusProfitArray);//BONUS PROFIT CLEAN UP

                    }
                }

                $ndbProfitLogs = array(
                    'Account_number' => $AccountNumber,
                    'DepAmount' => $DepAmount,
                    'UserId' => $user_id,
                    'TransactionId' => $depositID,
                    'TransactionType' => "Withdraw",
                    'BonusCleanUp' => $PartialProfit,
                    'isCancelprofit' => $removeBonusProfitArray['isCancelprofit'],
                    'BonusProfit' => $BonusProfit,
                    'dateFrom' => $account_info['from'],
                    'dateTo' => $account_info['to'],
                    'TotalRealFund' => $TotalRealFund,
                    'TotalBonusFund' => $TotalBonusFund,
                    'bonus' => $bonuses[2],
                    'no' => $no,
                    'remainingBalance' => $TotalBalance,
                    'swap' => $Swap,
                    'commission' => $Commission,
                    'newBonusProfit' => $NewBonusProfit,
                    'bonusBalance' => $bonusBalance,
                    'statusAPIdetails' => $WebServiceRequestAccDetails->request_status,
                    'statusAPIprof' => $WebServiceRequestProfit->request_status
                );
                $encodeNdbProfitLogs = json_encode($ndbProfitLogs);
                $insertProfitLogs = array(
                    'logs' => $encodeNdbProfitLogs,
                    'User_Id' => $user_id
                );


                $CI->deposit_model->insertNdbCancellationLogs($insertProfitLogs);

                $WebServiceRequestAccBalance = new WebService($webservice_config);
                $WebServiceRequestAccBalance->request_live_account_balance($AccountNumber);
                if ($WebServiceRequestAccBalance->request_status === 'RET_OK') {
                    $balance = $WebServiceRequestAccBalance->get_result('Balance');
                    $this->account_model->updateAccountBalance($AccountNumber, $balance);
                }

                $account = $CI->account_model->getAccountByUserId($user_id);

                $country = $CI->account_model->getAccountsCountry($user_id);
                if($country[0]['country'] == 'CN'){
                    $CI->session->set_userdata('isChina', '1');
                }

              //  $groupCurrency = $CI->general_model->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);
                
                $groupCurrency =  substr($account['group'], 0, -1);

                $groupCurrency .= '-b1';

                FXPP::update_account_group();
//                $account_info2 = array(
//                    'iLogin' => $account['account_number'],
//                    'strGroup' => $groupCurrency
//                );

//                $WebServiceChangeAccountGroup = new WebService($webservice_config);
//                $WebServiceChangeAccountGroup->open_ChangeAccountGroup($account_info2);

                $WebService2 = self::SetAccountGroup($account['account_number'], $groupCurrency);

         //   }
        }



    public static function get_standardgroup(){
        return array(
            "StSwUS1", "StSwEU1", "StSwGB1", "StSwRU1", "StSwMR1", "StSwID1", "StSwTH1", "StSwCN1",
            "StSwUS2", "StSwEU2", "StSwGB2", "StSwRU2", "StSwMR2", "StSwID2", "StSwTH2", "StSwCN2",
            "StSwUS3", "StSwEU3", "StSwGB3", "StSwRU3", "StSwMR3", "StSwID3", "StSwTH3", "StSwCN3",
            "StSFUS1", "StSFEU1", "StSFGB1", "StSFRU1", "StSFMR1", "StSFID1", "StSFTH1", "StSFCN1",
            "StSFUS2", "StSFEU2", "StSFGB2", "StSFRU2", "StSFMR2", "StSFID2", "StSFTH2", "StSFCN2",
            "StSFUS3", "StSFEU3", "StSFGB3", "StSFRU3", "StSFMR3", "StSFID3", "StSFTH3", "StSFCN3",
//            "StSwUSC-cn1", "StSwEUC-cn1", "StSFUSC-cn1", "StSFEUC-cn1", "StSwUSCndb-cn1", "StSwEUCndb-cn1", "StSFUSCndb-cn1", "StSFEUCndb-cn1","StSwUSC1"  //Micro
        );
    }


    public static function get_standardgroup_v2($account_number){
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;

         $account_details =FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id=$account_number,$select='mt_account_set_id');
         $isStandardAccount = false;
         if($account_details['mt_account_set_id'] == 1 || $account_details['mt_account_set_id'] == 4){
//             $webservice_config = array(
//                 'server' => 'live_new'
//             );
//             $WebServiceS = new WebService($webservice_config);
//             $data = array(
//                 'iLogin' => $account_number
//             );
//             $WebServiceS->request_account_details($data);

             $WebServiceS = self::GetAllAccountDetails($account_number);

             if ($WebServiceS['ErrorMessage'] === 'RET_OK') {
                 $group = $WebServiceS['Data'][0]->Group;
                 $Standard = substr($group, 0, 2); //return 1st two char
                 $StandardEU = substr($group, 0, 4); //return 1st two char
                 if($Standard === 'St' || $StandardEU === 'D-St'){
                     $isStandardAccount = true;
                 }
             }

         }

        return $isStandardAccount;
    }

    public static function get_standardgroup_for_ndb($account_number){
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;

         $account_details =FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id=$account_number,$select='mt_account_set_id');
         $isStandardAccount = false;
         if($account_details['mt_account_set_id'] == 1){
//             $webservice_config = array(
//                 'server' => 'live_new'
//             );
//             $WebServiceS = new WebService($webservice_config);
//             $data = array(
//                 'iLogin' => $account_number
//             );
//             $WebServiceS->request_account_details($data);

             $WebServiceS = self::GetAllAccountDetails($account_number);

             if ($WebServiceS['ErrorMessage'] === 'RET_OK') {
                 $group = $WebServiceS['Data'][0]->Group;
                   $Standard = substr($group, 0, 2); //return 1st two char
                   $StandardEU = substr($group, 0, 4); //return 1st two char
                   if($Standard === 'St' || $StandardEU === 'D-St'){
                       $isStandardAccount = true;
                   }
              }
         }

        return $isStandardAccount;
    }

    public static function update_account_group_specific($user_id){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $account_get = $CI->account_model->getAccountByUserId($user_id);
        if (count($account_get) > 0) {
//            $webservice_config = array(
//                'server' => 'live_new'
//            );
//            $WebServiceS = new WebService($webservice_config);
//            $data = array(
//                'iLogin' => $account_get['account_number']
//            );
//            $WebServiceS->request_account_details($data);

            $WebServiceS = self::GetAllAccountDetails($account_get['account_number']);

            if ($WebServiceS['ErrorMessage'] === 'RET_OK') {
                $group = $WebServiceS['Data'][0]->Group;
                if (in_array(substr($group, -1), array('1', '2', '3'))) {
                    $code = substr($group, -1);
                    $CI->account_model->updateAccountGroupCode($account_get['account_number'], $code);
                }
            }
        }
    }

    public static function getVisitorInfo(){
        require_once("geoip/geoipcity.inc");
        require_once("geoip/geoipregionvars.php");
        require_once("geoip/timezone.php");

        //Get remote IP
        $ip = $_SERVER['REMOTE_ADDR'];


        //Open GeoIP database and query our IP
        $gi = geoip_open(APPPATH . "libraries/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
        return( GeoIP_record_by_addr($gi,$ip));
        //return true;

    }

    public static function requestdetailsNDB($user_id){

        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m = FXPP::CI()->Task_model;

        FXPP::CI()->load->model('account_model');

        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;

        FXPP::CI()->load->model('deposit_model');
        FXPP::CI()->d_m=FXPP::CI()->deposit_model;

        $account_get = FXPP::CI()->account_model->getAccountByUserId($user_id);
        $webservice_config = array(
            'server' => 'live_new'
        );
//        $WebServiceUpdateNDBG = new WebService($webservice_config);
//        $data = array(
//            'iLogin' => $account_get['account_number']
//        );
//        $WebServiceUpdateNDBG->request_account_details($data);

        $WebServiceUpdateNDBG = self::GetAllAccountDetails($account_get['account_number']);

        if ($WebServiceUpdateNDBG['ErrorMessage'] === 'RET_OK') {
            $group = $WebServiceUpdateNDBG['Data'][0]->Group;
            $ForMarStaAcc = FXPP::get_standardgroup();
            if (in_array($group, $ForMarStaAcc)) {
                /*group not yet updated*/
                FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $account_get['account_number'], array('fixed_group'=>1));
                $account =  FXPP::CI()->account_model->getAccountsByAccountNumber( $account_number=$account_get['account_number'] );
                FXPP::update_account_group_specific($account['user_id']);

                $country = FXPP::CI()->account_model->getAccountsCountry($account['user_id']);
                if($country[0]['country'] == 'CN'){
                    FXPP::CI()->session->set_userdata('isChina', '1');
                }

               // $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);
               
                $groupCurrency =  substr($account['group'], 0, -1);
                $account_details = FXPP::CI()->account_model->getAccountByUserId($account['user_id']);

                $groupCurrency .= 'ndb' . $account_details['group_code'];

//                $account_info2 = array(
//                    'iLogin' => $account['account_number'],
//                    'strGroup' => $groupCurrency
//                );

//                $WebServiceGroupUp = new WebService($webservice_config);
//                $WebServiceGroupUp->open_ChangeAccountGroup($account_info2);

                $WebServiceGroupUp = self::SetAccountGroup($account['account_number'], $groupCurrency);

                if ($WebServiceGroupUp->request_status == 'RET_OK'){

                    $group = $groupCurrency;

                    $data = array(
                        'group'=> $group,
                    );
                    FXPP::CI()->g_m->updatemy('mt_accounts_set', 'account_number', $account['account_number'], $data);
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountGroup',
                        'api'=>'ChangeAccountGroup',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);

                    /*Table Logs*/
                }else{

                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountGroup',
                        'api'=>'ChangeAccountGroup',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }



                FXPP::CI()->load->model('user_model');
                $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($account['user_id']);
                if (in_array(strtoupper($user['country']), array('PL'))) {
                    $account_info3 = array(
                        'iLogin' => $account['account_number'],
                        'iLeverage' => '100'
                    );
                } else {
                    $account_info3 = array(
                        'iLogin' => $account['account_number'],
                        'iLeverage' => '200'
                    );
                }

                /*3rd Webservice Call*/
//                $WebServiceLL = new WebService($webservice_config);
//                $WebServiceLL->open_ChangeAccountLeverage($account_info3);

                $WebServiceLL = self::SetLeverage($account['account_number'], $account_info3['iLeverage']);

                if ($WebServiceLL->request_status == 'RET_OK') {
                    $prvt_data['lev'] = array(
                        'leverage' => '1:'.$account_info3['iLeverage']
                    );
                    FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $account['id'], $prvt_data['lev']);
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountLeverage',
                        'api'=>'ChangeAccountLeverage',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }else{
                    $logs['WS3']='ChangeAccountLeverage API error';
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountLeverage',
                        'api'=>'ChangeAccountLeverage',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }
                FXPP::CI()->d_m->setNoDepositRequestStatus($account['user_id'], 1);


                $usrs= FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$account['user_id'] ,$select='ndb_ticket,ndb_bonus_ccy');
                $comment = 'FOREXMART NO DEPOSIT BONUS';
                FXPP::CI()->load->model('Managecontest_model');
                $prize_data = array(
                    'user_id' => $account['user_id'],
                    'account_number' => $account_number,
                    'manager_id' => $account['user_id'],
                    'amount' =>$usrs['ndb_bonus_ccy'],
                    'comment' => $comment,
                    'ticket' =>$usrs['ndb_ticket'],
                    'date_processed' => FXPP::getCurrentDateTime()
                );
                $i_cp = FXPP::CI()->Managecontest_model->insertCreditPrize($prize_data);
                $logs['i_cp']=$i_cp;

                if($i_cp!=false){
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'Credit Prize',
                        'api'=>'N/A',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }else{
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'Credit Prize',
                        'api'=>'N/A',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }



            }
        }else{

        }

    }

    public static function CurlToSite($params, $headeron = 1) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $fields = $params['fields'];
        $statusUrl = $params['statusUrl'];

        $ch = curl_init();  //open connection
        curl_setopt($ch, CURLOPT_URL, $statusUrl);  //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_HEADER, $headeron);

        if (strpos($statusUrl, 'https') === false) {
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (count($fields) > 0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields) . '\n');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); //suggested by Instaforex
        $result = curl_exec($ch);
        curl_close($ch);

        return $result; //close connection
    }

    function isMicro( $user_id ){

        FXPP::CI()->load->model('account_model');
        $isMicro = FXPP::CI()->account_model->isMIcro($user_id);
        return $isMicro;
    }


    function isNdb( $user_id ){

        FXPP::CI()->load->model('account_model');
        $isNdb = FXPP::CI()->account_model->isNdb($user_id);
        return $isNdb;
    }


    public function hasContestBonus(){
//         7   => 'BONUS_CONTEST_PRIZE',
//        12   => 'BONUS_CONTEST_MF_PRIZE'

        FXPP::CI()->load->model('account_model');
        $account = FXPP::CI()->account_model->getAccountByUserId(FXPP::CI()->session->userdata('user_id'));
        $bonus_list = array();
        $getAccountBonusByType = FXPP::getAccountBonusByType($account['account_number']);
        foreach($getAccountBonusByType as $key => $bonuses){
            array_push($bonus_list,$key);
        }
        if(FXPP::CI()->uri->segment(1) === 'deposit'){
            if(in_array(7,$bonus_list) || in_array(12,$bonus_list) ) {
                return true;
            }else{
                return false;
            }

        }else{
            if(in_array(7,$bonus_list) || in_array(12,$bonus_list) ) {
                return true;
            }else{
                return false;
            }
        }

    }


    public static function GetAccountAgent_v2($account_number){

        $CI =& get_instance();
        $CI->load->library('WSV'); //New web service

        $webservice_config = array('server' => 'live_new');
//        $WebServiceCheck = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number );
//        $WebServiceCheck->open_RequestAccountDetails($account_info);

        $WebServiceCheck = $CI->wsv->GetAccountDetailsSingle($account_info, $webservice_config);

        if($WebServiceCheck->request_status === 'RET_OK') {
//            $accountDetails = $WebServiceCheck->get_all_result();
            $accountDetails = $WebServiceCheck->result;
            $getAccountAgent = $accountDetails['Agent'];
            $getGroupCode = $accountDetails['Group'];

        }
        $result = array(
            'Agent' => $getAccountAgent,
            'Code' => $getGroupCode,
            'ApiStat' => $WebServiceCheck->request_status
        );
        return $result;
    }

    public function update_account_group_For_Bangladesh($user_id){
        self::CI()->load->model('account_model');
        $account = self::CI()->account_model->getAccountByUserId($user_id);
        $isAgentBangladesh = false;
//        $getAccountAgent = FXPP::GetAccountAgent($account_get['account_number']);
        $getAccountAgent = FXPP::GetAccountAgentFromDB($user_id);
        $bangladesh_clients = array(
            '242400',
            '242700',
            '243340',
            '247429',
            '249640',
            '250598',
            '255208',
            '255223',
            '265078',
            '266222',
            '241800',
            '209874', //test
        );


        if(!empty($getAccountAgent['agent'])){
            if (in_array($getAccountAgent['agent'],$bangladesh_clients)) {
                if($account['mt_currency_base'] == 'USD'){
                    $isAgentBangladesh = true;
                }
            }
        }

        $result = array(
            'agent_account_number' => $getAccountAgent['agent'],
            'agent_code' => $getAccountAgent['agent_code'],
            'isAgentBangladesh' => $isAgentBangladesh,
            'currency_base' => $account['mt_currency_base']
        );

        return $result;
    }

    public static function isSubscribeToMasterAccount($session_account_number){
        $webservice_config = array('server' => 'minifcservice');
        $WS_I = new WebService($webservice_config);
        $isSub = FALSE;
        $account_info = array('iFollowerAccount' => $session_account_number);
        $WS_I->open_GetFollowerSubscriptionInfo($account_info);

        if ($WS_I->request_status === 'RET_OK') {
            if ($WS_I->get_result('IsSubscribed')=='true'){
                $masterAcc  = $WS_I->get_result('MasterAccount');
                $isSub = TRUE;
            }
        }elseif($WS_I->request_status === 'RET_ACCOUNT_NOT_FOUND'){
            $masterAcc = '';
            $isSub = FALSE;
        }else{
            $masterAcc = '';
            $isSub = FALSE;
        }
        $result = array(
            'master' => $masterAcc,
            'IsSubscribed' => $WS_I->get_result('IsSubscribed'),
            'ApiStat' =>$WS_I->request_status,
            'subscribe' =>$isSub
        );
        return $result;
    }

    public static function isMasterAccount($account_number){
        $MasterAccounts = FXPP::GetAllMasterTradersAccount();
        $isMastertrader = FALSE;
        if($MasterAccounts) {
            foreach ($MasterAccounts as $value) {
                if ($account_number == $value) {
                   $master_account = $value;
                    $isMastertrader = TRUE;
                }
            }

        }

        if(!$master_account){
            $isMastertrader = false;
        }
        $result = array(
            'master' => $master_account,
            'isMasterAcc' => $isMastertrader,
        );
        return $result;
    }

  


    public static function isSubscribeToPartnerAccount($user_id, $isAgreToSubs = 0){

        self::CI()->load->model('Task_model');
        self::CI()->load->model('account_model');
        $account = self::CI()->account_model->getAccountByUserId($user_id);
        $user_data = self::CI()->account_model->getUserInfoByUserId($user_id);

        $ndbstat = false;
        if($user_data['nodepositbonus'] == 1){
            $ndbstat = true;
        }

        $partner_list = array( //affiliate code of partner 262259
            'LBTPH',
            'jpro',
            '17jpro',
            'jakarta',
            'ibsyariah',
            'rushtrader'
        );

        $partner_list2 = array( //cpa 293290(293291 mirror)
            'PNDBM',
        );

        $getUserReferralCode =  FXPP::CI()->Task_model->getreferralcode($user_id);
        if(in_array($getUserReferralCode[0]['referral_affiliate_code'],$partner_list2)){
            $masterAcc = 301298;
        
        }

        if (in_array($getUserReferralCode[0]['referral_affiliate_code'], $partner_list)) {
            if($isAgreToSubs == 1) {
//                $masterAcc = 281105;
                  $masterAcc = 58000527;

            }
        }



        $subs_data = array(
            'user_id' => $user_id,
            'account_number' => $account['account_number'],
            'ndbstat' => $ndbstat,
            'email' => $user_data['email'],
            'master_account' => $masterAcc,
        );


        if($subs_data['master_account']){

             $subscribedtomaster = self::subscribeReferralsAccount($subs_data);
        }



        $result = array(
            'master' => $masterAcc,
            'subscribe' =>$subscribedtomaster,
        );

        return $result;
    }



    public function subscribeReferralsAccount($data){

        self::CI()->lang->load('copytrade');
        self::CI()->load->library('Fxpp_email');

        $webservice_config = array('server' => 'minifcservice');
        $isSubscribedReferrals = false;

        $WS_I = new WebService($webservice_config);
        $account_info = array('iFollowerAccount' => $data['account_number']);

        $WS_I->open_GetFollowerSubscriptionInfo($account_info);

        if ($WS_I->request_status === 'RET_OK' && $WS_I->get_result('IsSubscribed')=='true') {

        

        }else{

        $WS_S = new WebService($webservice_config);
        $account_info = array(
            'FollowerAccount' => $data['account_number'],
            'Is_NDB_Account'  => $data['ndbstat'],
            'MasterTrader'    => $data['master_account']
        );

        $WS_S->open_SubscribeToMasterAccount($account_info);

        if ($WS_S->request_status === 'RET_OK') {

             $email_data = array(
                 'email' => $data['email'],
              );

             Fxpp_email::ct_subscribe($email_data);

            $isSubscribedReferrals = true;

        }

      }


        return $isSubscribedReferrals;

    }



    public function updateleverageAllAccounts(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountByUserId($user_id);

        $account_info = array(
            'iLogin' => $account['account_number'],
        );

        $webservice_config = array(
            'server' => 'live_new'
        );
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountBalance($account_info);
        switch ($WebService->request_status) {
            case 'RET_OK':
                $balance =  self::roundno(floatval($WebService->get_result('Balance')), 2);
                break;
            default:
                $balance =  self::roundno(floatval(0), 2);
        }

        $result = array(
            'account_number' => $account_info['iLogin'],
            'user_id' => $user_id,
            'balance' => $balance,
            'leverage' =>$account['leverage']
        );

        self::updateLeverageMax13000and15000($result);
    }


    public function updateLeverageMax13000and15000($result){
        self::CI()->load->model('general_model');
        $config = array(
            'server' => 'live_new'
        );
        if($result['balance'] >= 1000){
            $defaultLeverage = '3000';
        }else{
            $defaultLeverage = '5000';
        }

//        $info = array(
//            'iLogin'    => $result['account_number'],
//            'iLeverage' => $defaultLeverage
//        );
//        $WebService = new WebService($config);
//        $WebService->open_ChangeAccountLeverage($info);

        $WebService = self::SetLeverage($result['account_number'], $defaultLeverage);

        if ($WebService->request_status === 'RET_OK') {

            $date_modified = self::getCurrentDateTime();
            $update_history_data = array(
                'user_id'       => $result['user_id'],
                'manager_id'    => $result['user_id'],
                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                'update_url'=>'fxpp/updateLeverageMax13000and15000',
            );
            $update_history_id = self::CI()->account_model->insertAccountUpdateHistory($update_history_data);
            $update_history_field_data = array();
            if ($update_history_id) {
                $update_history_field_data[] = array(
                    'field'         => 'Leverage',
                    'old_value'     => $result['leverage'],
                    'new_value'     => '1:'.$defaultLeverage,
                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                    'update_id'     => $update_history_id
                );
            }

            $data['client_autochangelev'] = array(
                'client_autolevchange_disable' => 1
            );
            self::CI()->general_model->updatemy('mt_accounts_set', 'user_id', $result['user_id'], $data['client_autochangelev']);

            self::CI()->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
            self::CI()->account_model->updateAccountLeverage($result['account_number'], '1:'.$defaultLeverage);


        }
//       return $info;
    }

    public function GetFollowersByMastersAccount($masterAcc){

        $webservice_config = array(
            'server' => 'minifcservice'
        );

        $WebService = new WebService($webservice_config);
        $WebService->open_GetAllFollowersOfMastersAccount();
        $followers_record = array();

        if($WebService->request_status === 'RET_OK') {
            $requestResult = json_encode($WebService->get_all_result());
            $followerDetails = json_decode($requestResult, true);

            foreach($followerDetails['Followers'] as $key => $data){
                foreach ($data as $value){
                    if($value['MasterTrader'] == $masterAcc && $value['IsSubscribe'] == True){
                        $followers_record[] = $value['FollowersAccount'];
                    }
                }
            }

        }

        return $followers_record;
    }

    public function GetAllMasterTradersAccount(){

        $webservice_config = array(
            'server' => 'minifcservice'
        );
        $WebService = new WebService($webservice_config);
        $WebService->open_GetAllMasterTradersAccount();
        $master_record = array();
        if($WebService->request_status === 'RET_OK') {
            $requestResult = json_encode($WebService->get_all_result());
            $masterDetails = json_decode($requestResult, true);
            foreach($masterDetails['MasterAccountsList'] as $key => $data){
                foreach ($data as $value){
                    if($value['IsActive'] == 1){
                        $master_record[] = $value['TraderAccount'];
                    }
                }
            }
        }

        return $master_record;
    }

    public static function showReferralAccountLots(){
        

        $balanceShowArray = array(109369,58028034);

        $account_number = FXPP::CI()->session->userdata('account_number');
        if(in_array($account_number,$balanceShowArray))
            return true;

        return false;
    }

    public static function showReferralAccountBalance(){
        //$balanceShowArray = array(293290,293295,109369,227173 );

        $balanceShowArray = array(293290,293295,109369,227173,262259,285733,58028034,58028358, 299814, 58033364, 58033305, 58033463, 58034124, 58033507,
            58033422, 1000000130, 58033364, 142184, 58033544,58037367, 58037565, 58033589, 58045016, 58044841);

        $account_number = FXPP::CI()->session->userdata('account_number');
        if(in_array($account_number,$balanceShowArray))
            return true;

        return false;
    }
    public static function showReferralAccountContactDetails(){

        $balanceShowArray = array(262259,285733,58028034, 299814, 58033364, 58033305, 58033463, 58034124, 58033507, 58033422, 1000000130, 58033364,
            142184, 58033544, 58037367, 58037565, 58033589, 58045016, 58044841 );

        $account_number = FXPP::CI()->session->userdata('account_number');
        if(in_array($account_number,$balanceShowArray))
            return true;

        return false;
    }

    public static function getCountryByIP()
    {
        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {
            $Country = getCountryFromIP($ip);

            return $Country;
        }

    }

    /*
     *  This function is using user registered country to determine if account is EU or not.
    */
    public function isAccountFromEUCountry($user_id = null){
        return false;

        self::CI()->load->model('account_model');
        if(!$user_id){
            $user_id = self::CI()->session->userdata('user_id');
        }

        $account = self::CI()->account_model->getAccountsCountry($user_id);

        if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){
            return true;
        }else {

            $europeanCountry = IPloc::euCountryArray();

            if (in_array(strtoupper($account[0]['country']), $europeanCountry)) {
                return  true;
            } else {
                return false;
            }

        }

    }

    public static function isEuropeanCountrybyCountryCode($country_code=null){
        $europeanCountry = IPloc::euCountryArray();
        if(in_array(strtoupper($country_code),$europeanCountry)){
            return true;
        }

        return false;
    }



    public static function showCommisionAmount(){

       /* if(!IPLoc::Office()){
            return false;
        }*/
        $balanceShowArray = array(262259,   299814, 58033364, 58033305, 58033463, 58034124, 58033507, 58033422, 1000000130, 58033364, 142184, 58033544, 58037367,
            58037565, 58033589, 58045016, 58044841);

        $account_number = FXPP::CI()->session->userdata('account_number');
        if(in_array($account_number,$balanceShowArray))
            return true;

        return false;
    }

    public function IsCountryPayoma(){
        $country_payoma = array('CA', 'AU', 'BR', 'VN', 'PH');
        $user_country = FXPP::getCountryCode();

        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

        if (in_array(strtoupper($account[0]['country'] ), $country_payoma)) {
            return true;

        }

        if (in_array(strtoupper($user_country), $country_payoma)) {
            return true;

        }
        return false;
    }

    public static function isEUPayment($url=null){
        if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){
            self::CI()->general_model->insertmy('eu_session_url', array('url'=>$url,'account_number'=>self::CI()->session->userdata('account_number')));
        }

    }


    /*public static function isEUUrl(){
        if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){
            return true;
        }
        return false;

    }*/

    public static function isEUUrl(){
        return false;
        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {
            $country = getCountryFromIP($ip);
            //added validation for invalid code
            $invalid_code = array('ZZ');
            if (in_array(strtoupper($country), $invalid_code)) {
                $country = IPLoc::getCountryCodeFromNetIP($ip);
            }
        } else {
            return false;
        }

        if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu' || IPLoc::isEuropeanCountryByCode($country)){
            return true;
        }
        return false;

    }

    public static function failedPaymentNotify($url=null,$status=0,$user_id=null,$error_msg =null){

            if($status == 1) {
                if(empty($user_id)){ $user_id = self::CI()->session->userdata('user_id'); }
                self::CI()->general_model->updatemyw2('eu_session_payment','url',$url,'user_id', $user_id, array('status' => 1,'error_message' => $error_msg));
            } else {
                if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu') {
                    self::CI()->general_model->insertmy('eu_session_payment', array('url' => $url, 'user_id' => self::CI()->session->userdata('user_id'), 'status' => $status));
                }
           }
   }

    public static function SendPOSTRequest( $url, $fields ){

        $ch = curl_init();
        $postvars = '';
        foreach($fields as $key=>$value) {
            $postvars .= $key . "=" . $value . "&";
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        if($response = curl_exec($ch)){
            curl_close ($ch);
            return $response;
        }
        curl_close ($ch);
        return curl_error($ch);

    }

    public function isEUGroup($account_number){
        if($ac_data = FXPP::getMTUserDetails($account_number)) {
            if ((strpos($ac_data['Group'], 'D-Fc') !== false) || (strpos($ac_data['Group'], 'D-Fp') !== false) || (strpos($ac_data['Group'], 'D-St') !== false) || (strpos($ac_data['Group'], 'D-Ze') !== false)) {
                $return = false;
            }else{
                $return = true;
            }

        }

        return $return;

    }


   //auto update group of non-eu clients, group must have 'D-'.
    public static function updateNonEUGroup()
    {

        self::CI()->load->model('general_model');
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $getAccountNumber = self::CI()->account_model->getAccountNumber($user_id);
        $account = self::CI()->account_model->getAccountsCountry($user_id);

        //list of EU countries
        $europeanCountry = IPloc::euCountryArray();

        if (!in_array(strtoupper($account[0]['country']), $europeanCountry)) {

            $webservice_config = array('server' => 'live_new');
//            $WebServiceCheck = new WebService($webservice_config);
            $account_info = array('iLogin' =>  $getAccountNumber['account_number']);

//            $WebServiceCheck->open_RequestAccountDetails($account_info);

            self::CI()->load->library('WSV'); //New web service
            $WebServiceCheck = self::CI()->wsv->GetAccountDetailsSingle($account_info, $webservice_config);

            if($WebServiceCheck->request_status === 'RET_OK'){
//                $accountDetails = $WebServiceCheck->get_all_result();
                $accountDetails = $WebServiceCheck->result;
                $getAccountGroup = $accountDetails['Group']; //API group
                $accountGroup = substr($getAccountGroup, 0, 4); //return 1st 4 char
                    if($accountGroup != 'D-St' && $accountGroup != 'D-Ze'){
//                        $WebServiceChangeGroup = new WebService($webservice_config);
                        $account_info2 = array(
                            'iLogin' => $getAccountNumber['account_number'],
                            'strGroup' => 'D-'.$getAccountGroup
                        );
//                        $WebServiceChangeGroup->open_ChangeAccountGroup($account_info2);

                        $WebServiceChangeGroup = self::SetAccountGroup($account_info2['iLogin'], $account_info2['strGroup']);

                        $date_modified = self::getCurrentDateTime();
                        $group_log = array(
                            'user_id' => $user_id,
                            'old_group' => $getAccountGroup,
                            'new_group' => $account_info2['strGroup'],
                            'date_updated' => date('Y-m-d H:i:s', strtotime($date_modified))
                        );
                        self::CI()->general_model->insert('auto_group_update',$group_log);

                    }

            }
        }
    }


     public static function IsAccountRegFromEUUrl(){
         self::CI()->load->model('account_model');
         $user_id = self::CI()->session->userdata('user_id');
         $account = self::CI()->account_model->getUserInfoByUserId($user_id);
         if($account['domain'] == 2){
             return true;
         }
         return false;

     }

    public static function getRiskPercentage(){
        $CI =& get_instance();
        $CI->load->model('general_model');
        $risk_details = $CI->general_model->showssingle('risk_warning','status',1);
        return $risk_details['percent'] . '%';
    }

    public static function urlBouncelog($bouncing_reason = null){
        $ci =& get_instance();
        $ci->load->model('general_model');
        $data = array(
            'country_code'=>IPLoc::getCountryCodeFromIP($ci->input->ip_address()),
            'url'=>$_SERVER['REQUEST_URI'],
            'IP'=>$ci->input->ip_address(),
            'bouncing_reason'=>$bouncing_reason
        );
        $ci->general_model->insertmy("bouncing_log",$data);
    }

    public static function companyName(){
        if(self::isEUUrl()){
            return "Instant Trading EU Ltd.";
        }
        return "Tradomart SV Ltd.";
    }

    public static function spanishValidationView($module){
        $CI =& get_instance();

        if($module == "neteller"){
            $data["col_sm"] = "8";
        }else{
            $data["col_sm"] = "10";
        }

        $view = $CI->load->view("deposit_widget/spanish_accept_risk_declaration", $data, true);
        return $view;
    }

    public static function spanishDocumentStatus($user_id){
        $CI =& get_instance();
        $CI->load->model("account_model");

        $tableName = "spanish_accept_risks_declaration";
        $hasRecord = $CI->account_model->getUserRecord($tableName, array("user_id" => $user_id));

        $message = null;
        if($hasRecord){
            if($hasRecord[0]["status"] == 2){
                $message = 'Your document has been processed and tagged as Declined.';
            }
        }

        return $message;
    }

    public static function isArabicCountry($filter, $type = 'code'){ //FXPP-9820

        /**$filter: country code or country name*/

        $ArabicCountries = array(
            "DZ" => "Algeria",
            "BH" => "Bahrain",
            "KM" => "Comoros",
            "DJ" => "Djibouti",
            "EG" => "Egypt",
            "IQ" => "Iraq",
            "JO" => "Jordan",
            "KW" => "Kuwait",
            "LB" => "Lebanon",
            "LY" => "Libya",
            "MR" => "Mauritania",
            "MA" => "Morocco",
            "OM" => "Oman",
            "PS" => "Palestine Liberation Organization",
            "QA" => "Qatar",
            "SA" => "Saudi Arabia",
            "SO" => "Somalia",
            "SD" => "Sudan",
            "SY" => "Syria",
            "TN" => "Tunisia",
            "AE" => "United Arab Emirates",
            "YE" => "Yemen",
            "IR" => "Iran"
        );

        if(!in_array($type, array('code', 'country'))){
            return false;
        }

        if($type === 'code' && array_key_exists($filter, $ArabicCountries)){
            return true;
        }

        if($type === 'country' && in_array($filter, $ArabicCountries)){
            return true;
        }

        return false;
    }
    public static function getSmartDollarCounty(){
        return array('ID','MY','BD');
    }

    public static function isSmartDollarCountry(){
     // return false;
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);
        $countryList = self::getSmartDollarCounty();
        if(in_array($account[0]['country'], $countryList)){
            return true;
        }
        return false;

    }

    public static function isIndonesianCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);
            
            if ($account[0]['country'] == 'ID') {
                return  true;
            } else if (IPLoc::for_id_only()){
                return true;
            } else {
                return false;
            }
    }
    public static function isMalaysianCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'MY') {
                return  true;
            } else if (IPLoc::for_my_only()) {
                return  true;
            } else {
                return false;
            }
    }
    public static function isThailandCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'TH') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isNigerianCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'NG') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isMexicanCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'MX') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isBrazilianCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'BR') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isGhanaCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'GH') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isUgandaCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'UG') {
                return  true;
            } else {
                return false;
            }
    }
    public static function isKenyaCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'KE') {
                return  true;
            } else {
                return false;
            }
    }

    public static function isVietnamCountry(){
        self::CI()->load->model('account_model');
        $user_id = self::CI()->session->userdata('user_id');
        $account = self::CI()->account_model->getAccountsCountry($user_id);

            if ($account[0]['country'] == 'VN') {
                return  true;
            } else {
                return false;
            }
    }

    public static function isNonEuGroupCountry($group_code){
        if((strpos($group_code, 'D-') !== false) || (strpos($group_code, '-cn') !== false)){ // non EU group country
            return true;
        }

        return false;
    }

    public static function isEUGroupByAccountNumber($account_number){
            if($ac_data = FXPP::getMTUserDetails($account_number)){
                    if(self::isNonEuGroupCountry($ac_data['Group'])){ // non EU group country
                        return false;  //
                    }else{
                        return true;  // this is EU country group
                    }
                }
        return true;

    }

    public static  function getMTUserDetails($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
//        $webService->request_account_details($data);

        $webService = self::GetAllAccountDetails($account_number);
        if ($webService['ErrorMessage'] === 'RET_OK') {
            $data = (array) $webService['Data'][0];
        }else{
            $webService->request_inactive_details($data);
            if ($webService->request_status === 'RET_OK'){
                $data = $webService->get_all_result();
            }else{
                return false;
            }
        }
        return $data;
    }

    public static  function getMTUserDetails2($account_number){
        
             
 
       $accounts = is_array($account_number) ? $account_number : [$account_number];    
        
        
       
        self::CI()->load->library("WSV");
        $account_info = array('account_number' => $accounts);
            
        $WebService = self::CI()->wsv->GetAccountDetails($account_info);
            
            if($WebService['ErrorMessage'] === "RET_OK") {
                $arrayObject = new ArrayObject($WebService['Data']);
                $data = $arrayObject->getArrayCopy();

            }

            return $data;

    
    }




    public static  function getMTUserDetails3($account_number){
      $accounts = is_array($account_number) ? $account_number : [$account_number];
        self::CI()->load->library("WSV");

        $account_info = array(
            'account_number' => $account_number
        );
        $WebService = self::CI()->wsv->GetAccountDetails($account_info);
        if($WebService['ErrorMessage'] === "RET_OK") {
            $arrayObject = new ArrayObject(array($WebService['Data']));
            $data = $arrayObject->getArrayCopy();
           // $data = (array) $WebService['Data'];
        }
        return $data;
    }



    public static function getCountryCode(){
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $user_id = self::CI()->session->userdata('user_id');

        if( $row_array = self::CI()->g_m->whereCondition('user_profiles',array('user_id'=>$user_id),'country')){
            return $row_array['country'];
        }
        return false;
    }

    public static function payomaCountryArray(){
        /* 'Algeria','Afghanistan','Bosnia and Herzegovina','Ecuador','Guyana','North Korea','Iraq','Iran','Myanmar','Lao PDR','Syria','Uganda','Vanuatu','Yemen'*/
        //return array('AF','DZ','BA','EC','GY','IQ','MM','UG','VU','YE','IR','LA','SY','KP','KR');
        return array("DZ","AF","AU","BE","BA","BR","CN","CA","EC", "DE","GY","HK","KS","IQ","IR","IE","IL","IN", "JP","KE", "LV","LT","MM","NZ","PR", "PH","SO","SY","SG","SO","TR","UG","VU","VN","YE","US","LA", "ZA", "AT", "BG", "HR", "CY", "CZ", "DK", "EE", "FI", "FR", "GR", "HU", "IT", "LU", "MT", "NL", "PL", "PT", "RO", "SK", "SI", "ES", "SE", "GB");
    }
    public static function notAllowedPayomaDepositCountry(){

        return in_array(self::getCountryCode(),self::payomaCountryArray())?true:false;
    }

   
    public static function isNotPayomaPayMentAvailableCountry(){
        $EEA_countries =array('BE'=>'Belgium','BG'=>'Bulgaria','CZ'=>'Czechia','DK'=>'Denmark','CY'=>'Cyprus','LV'=>'Latvia','LT'=>'Lithuania','LU'=>'Luxembourg','ES'=>'Spain','FR'=>'France','HR'=>'Croatia','IT'=>'Italy','PL'=>'Poland','PT'=>'Portugal','RO'=>'Romania','SI'=>'Slovenia','HU'=>'Hungary','MT'=>'Malta','NL'=>'Netherlands','AT'=>'Austria','IS'=>'Iceland','LI'=>'Liechtenstein','NO'=>'Norway','SK'=>'Slovakia','FI'=>'Finland','SE'=>'Sweden','DE'=>'Germany','EE'=>'Estonia','IE'=>'Ireland','EL'=>'Greece');
 
        $payomaNotAllow=array( 'CZ'=>'Czech Republic', 'GB'=>'United Kingdom', 'DZ'=>'Algeria', 'AF'=>'Afghanistan', 'AU'=>'Australia',  'BA'=>'Bosnia and Herzegovina', 'BR'=>'Brazil', 'CN'=>'China', 'CA'=>'Canada', 'EC'=>'Ecuador', 'GY'=>'Guyana', 'HK'=>'Hong Kong', 'HU'=>'Hungary', 'KP'=>'North Korea', 'NZ'=>'New Zealand', 'IQ'=>'Iraq', 'IR'=>'Iran',  'IL'=>'Israel', 'IN'=>'India', 'ID'=>'Indonesia', 'JP'=>'Japan', 'MY'=>'Malaysia ', 'MM'=>'Myanmar ', 'KE'=>'Kenya', 'LA'=>'Lao',  'LV'=>'Latvia', 'LT'=>'Lithuania', 'PL'=>'Poland', 'PR'=>'Puerto Rico', 'PH'=>'Philippines', 'KR'=>'South Korea',  'ZA'=>'South Africa',  'SO'=>'Somalia', 'SY'=>'Syria', 'SG'=>'Singapore', 'TR'=>'Turkey', 'UG'=>'Uganda','VU'=>'Vanuatu', 'VN'=>'Vietnam', 'YE'=>'Yemen', 'US'=>'USA');
            
        $paymonNCountry=array_merge($EEA_countries,$payomaNotAllow);
        $country_code= strtoupper(self::getCountryCode());
        if($paymonNCountry[$country_code])
        {
            return true; /// recticted country found
        }else{
            return false;
        }    
            
    }
    public static function isNotZotapayPayMentAvailableCountry($country){
        $blockedCountries = array( 'CN'=>'China','US'=>'United States','CA'=>'Canada','SY'=>'Syria','IN'=>'India','IL'=>'Israel','IR'=>'Iran','KP'=>'South Korea','MX'=>'Mexico','BR'=>'Brazil','YE'=>'Yemen');
        $country_code = strtoupper($country);
        if($blockedCountries[$country_code])
        {
            return true; /// restricted country found
        }else{
            return false;
        }

    }

    public static function isNotNova2PayPayMentAvailableCountry($country){
        //CIS Region and Russia
        $blockedCountries = array('AZ','AM','BY','GE','KZ','KG','MD','RU','TJ','TM','UZ','UA');
        $country_code = strtoupper($country);

        if(in_array($country, $blockedCountries)) {
            

          return true; /// restricted country found
        }else{
            return false;
        }

    }
    
    
   public static function isPayomaPayMentAvailable($finance_type="deposit"){
       //$finance_type=>deposit means deposit page access avaible check  and others means withdraw page availabel check  
       
       self::CI()->load->model('General_model');
        $userId = self::CI()->session->userdata('user_id');
        $account_number = self::CI()->session->userdata('account_number');
        $ip=FXPP::CI()->input->ip_address();
        
        $withdraw_allow_accounts=array('58032125','58031116','58030904','58072429','58050356','322365');        
        $deposit_allow_accounts=array('58072429','58050356');
        
        
        
       /* $only_allow_accounts=array('58050356','58072429');
        
            if(!empty($only_allow_accounts)) // onpen for only specefic account 
            {
                            if(in_array($account_number, $only_allow_accounts) or IPLoc::Office())  
                            {
                              return true;   //FXPP-13860
                            }else{
                                return false;
                            } 
            }  */  
            
        
                    if($finance_type=="deposit"){

                         $date_range_check=self::CI()->General_model->isPayomaPayMentAvailable($userId);

                            if(in_array($account_number, $deposit_allow_accounts))  
                            {
                              return true;   //FXPP-13860

                            }else{ 
                                   $date_range_check=self::CI()->General_model->isPayomaPayMentAvailable($userId);
                            }

                    }else{

                          if(in_array($account_number, $withdraw_allow_accounts))  
                            {
                              return true;   //FXPP-13608 and /FXPP-13761

                            }else{ 
                                 $date_range_check=self::CI()->General_model->isPayomaDepositAvailable($userId);
                            }
                    }


                    if($date_range_check)
                    {
                        if(self::isNotPayomaPayMentAvailableCountry())
                        {

                            return false;

                        }else{
                            return true;
                        }    

                    }else{

            //            if(IPLoc::frz(true)){return true;}else{
            //            
            //                if(isset($_GET['frz'])=='frz'){
            //                    return true;
            //                }else{
            //                    return false;
            //                }
            //            }

                        return false;

                    }   
        
    }
   public static function isZotapayPayMentAvailable(){
       // $country = self::CI()->session->userdata('country');

       $country= strtoupper(self::getCountryCode());

       // if(IPLoc::frz()){return true;}
        
        if(self::isNotZotapayPayMentAvailableCountry($country))
        {
            return false;

        }else{
            return true;
        }


    }

    public static function isNova2PayMentAvailable(){
        //$country = self::CI()->session->userdata('country');
        
        $country= strtoupper(self::getCountryCode());
        
        if(self::isNotNova2PayPayMentAvailableCountry($country))
        {
            return false;

        }else{
            return true;
        }


    }



        public static function fmGroupType($account_number=""){
       
            if($account_number)
            {
                $ci =& get_instance();
                $ci->load->database();
                $ci->load->model('general_model'); 
                $mt_data = $ci->general_model->getClientAccountDetails($account_number);
                if($mt_data)
                {
                     $mt_account_set_id = $mt_data->mt_account_set_id;
                }
                
                
            }else{
                   $mt_account_set_id = self::CI()->session->userdata('mt_account_set_id');
            }
            
            
     
        $data = array(
            '5' => 'ForexMart Classic',
            '6' => 'ForexMart Pro',
            '7' => 'ForexMart Cents',
        );

        return isset($data[$mt_account_set_id])?$data[$mt_account_set_id]:false;

        // if(in_array($mt_account_set_id,$data)){
        //     return $data[$mt_account_set_id];
        // }
        // return false;
       
       
        // if($ac_data = FXPP::getMTUserDetails($account_number)) {
        //     if ((strpos($ac_data['Group'], 'FcSwUSC') !== false) || (strpos($ac_data['Group'], 'FcSFUSC') !== false) || (strpos($ac_data['Group'], 'FcSwEUC') !== false)|| (strpos($ac_data['Group'], 'FcSFEUC') !== false)) {
        //         return 'ForexMart Cents';
        //     }
        //     if ((strpos($ac_data['Group'], 'D-Fc') !== false)) {
        //         return 'ForexMart Classic';
        //     }
        //     if ((strpos($ac_data['Group'], 'D-Fp') !== false)) {
        //         return 'ForexMart Pro';
        //     }

        //     return false;
        // }

        //return false;
    }




    public static function isNewMtGroup(){
      
        $account_number = FXPP::CI()->session->userdata('account_number');      

        return (self::fmGroupType($account_number)) ? true : false;

    }
    
    public static function isBDUrl(){
        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {

            $country = IPLoc::getCountryCode($ip);
            //added validation for invalid code
            $invalid_code = array('ZZ');
            if (in_array(strtoupper($country), $invalid_code)) {
                $country = getCountryFromIP($ip);
            }
        } else {
            return false;
        }

        if(FXPP::html_url() == 'bd' || strtoupper($country) == "BD"){
            return true;
        }
        return false;

    }

    public function realProfit($AccountNumber){
        $webservice_config = array(
            'server' => 'live_new'
        );
//        $WebServiceRequestAccDetails = new WebService($webservice_config);
//        $data = array(
//            'iLogin' => $AccountNumber
//        );
//        $WebServiceRequestAccDetails->request_account_details($data);

        $WebServiceRequestAccDetails = self::GetAllAccountDetails($AccountNumber);

        if ($WebServiceRequestAccDetails['ErrorMessage'] === 'RET_OK') {
            $from = date('Y-m-d\TH:i:s', $WebServiceRequestAccDetails['Data'][0]->RegDate);
        }

//      $to = Date('Y/d/m',strtotime(FXPP::getCurrentDateTime()));
//      $data['to'] = DateTime::createFromFormat('Y/d/m', date($to));

//        $WebServiceTime = new WebService($webservice_config);
//        $WebServiceTime->open_GetServerTime();
//        $serverTime = $WebServiceTime->get_all_result();

        $serverTime = self::getServerTime();

        $account_info = array(
            'iLogin' => $AccountNumber,
            'from' => $from,
            'to' => $serverTime
        );



        $WebServiceRequestProfit = new WebService($webservice_config);
        $WebServiceRequestProfit->open_GetAccountTotalProfitFromRange($account_info);
        $profit = 0;
        if ($WebServiceRequestProfit->request_status === 'RET_OK') {
            $profit = $WebServiceRequestProfit->get_result('TotalProfit');
        }

        return $profit;
    }


    public static function isEUClient(){
       

        self::CI()->load->model('account_model');
       
            $user_id = self::CI()->session->userdata('user_id');


        $account = self::CI()->account_model->getAccountsCountry($user_id);


            if (in_array(strtoupper($account[0]['country']), IPloc::euCountryArray())) {
                return  true;
            } 
            
            return false;
    }

    public static function has30DollarPermission(){

        self::CI()->load->model('general_model');
        $user_id = self::CI()->session->userdata('user_id');
        $checkdata = self::CI()->general_model->has30dollarbonus($user_id, $select = 'partner_credit_bonus');
        if ($checkdata[0]['partner_credit_bonus']==1){
            return  true;
        }
        return false;

    }

    public static function referrals_table(){       
       
       /* return   $head =  array(
                0 => lang('oth_com_20_1'),
                1=>lang('acc_number_type'),
                2=>lang('trd_256'),
                3=>lang('trd_81'),
                4=>lang('trd_257'),
                5=>lang('trd_258'),
                6=>lang('mf_02'),
                7=>lang('trd_259'),
                8=>lang('trd_260'),
              
    
            );*/



        return   $head =  array(

            1=>lang('acc_number_type'),
            2=>lang('trd_256'),
            0 => lang('oth_com_20_1'),
            6=>lang('mf_02'),
            7=>lang('trd_259'),
            3=>lang('trd_81'),
            4=>lang('trd_257'),
            5=>lang('trd_258'),
            11=>'Net Deposit',
            8=>lang('trd_260'),
            12=>lang('acl_02')
          


        );
            
    }

    public static function sub_affiliate_table(){

        return   $head =  array(
            0 =>lang('trd_256'),
            1=>lang('mf_02'),
            2=>lang('trd_259'),
            3=>lang('oth_com_20_1'),
            4=>lang('oth_com_20_3'),
            5=>lang('fer_02'),
            6=>lang('view_referrals'),
        );
    }
    
        public static function referrals_table_permission($full_table,$permission_string){
            $permited_column = explode('|',$permission_string);
            $permited_column = array_combine($permited_column,$permited_column);
            return array_intersect_key($full_table,$permited_column);


        }


    public static function isProAccount($accountNumber = NULL){
        $mtType = self::CI()->session->userdata('mt_account_set_id');
        $accountType = isset($mtType) ? $mtType : self::CI()->general_model->showssingle2('mt_accounts_set','account_number',$accountNumber,'mt_account_set_id')['mt_account_set_id'];
        return $accountType == 6 ? true : false;

    }

    public static function getAccountCurrency($accountNumber  = NULL){
        $currency = self::CI()->session->userdata('currency');
        $accountCurrency = isset($currency) ? $currency : self::CI()->account_model->getAccountDetailsByAccountNumber($accountNumber)['currency'];
        return $accountCurrency;


    }


    public static function updateAccountTradingStatusV2($accountNumber, $userId = NULL, $balance = 0){

        $isPro = self::isProAccount($accountNumber);
        if($isPro){ //if pro

            if($balance <= 0){ // if balance is set skip this
                $funds = FXPP::getAccountFunds($accountNumber);
                $balance = $funds['Balance'];

            }
            $currency = self::getAccountCurrency($accountNumber);
            $convBalance = $currency == 'USD' ? $balance : self::getCurrencyRate($balance, $currency, 'USD'); //convert to usd


            $status = ($convBalance >= 200) ? 0 : 1; //0 = enable, 1 = readonly

            $params = array(
                "AccountNumber" => $accountNumber,
                "isReadOnly"    => $status
            );

            self::CI()->load->library("WSV");
            self::CI()->wsv->SetAccountDetail($params, "UpdateReadOnlyModeOfAccount");

        }

    }



    public static function updateAccountTradingStatus($account_number,$user_id,$balance = 0){
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $mt4 = self::CI()->g_m->showssingle2($table = 'mt_accounts_set', $field = 'account_number', $id = $account_number, $select = 'mt_account_set_id,mt_currency_base');

        if($mt4['mt_account_set_id'] == 6){ //if pro
            $webservice_config = array('server' => 'live_new');
            $WebServiceReqBal = new WebService($webservice_config);
            if($balance <= 0){
                $WebServiceReqBal->request_live_account_balance($account_number);
                if ($WebServiceReqBal->request_status === 'RET_OK') {
                    $balance = $WebServiceReqBal->get_result('Balance');
                }
            }
            $conv_balance = $balance;
            if($mt4['mt_currency_base'] != 'USD') {
                $conv_balance = self::getCurrencyRate($balance, $mt4['mt_currency_base'], 'USD');
            }
            if($conv_balance >= 200){
                //activate
               self::activate_trading_API($user_id,$account_number);
            }else{
                self::deactivate_trading_API($user_id,$account_number);
            }
        }
    }



    public static function unixTime($date){
        $date = date('Y-m-d H:i:s', strtotime($date));
        $dateTime = new DateTime($date);
        $timestamp = $dateTime->format('U');
        return $timestamp;
    }

    // public static function riseLeverage(){
    //     $ci =& get_instance();       

    //     $account_number = $ci->session->userdata('account_number');               

    //     $condition = array('account_number'=>$account_number,
    //                              'group_type'=>'MU',
    //                              'type'=>'RL',
    //                              'status'=>1                                
    //                             );

    //     if( $row_array = $ci->general_model->whereCondition('mt_custom_groups',$condition,'account_number')){
    //         return 'mu';
    //     }
        
    //     return '';
    // }

    // public static function MTGroupMU(){
    //     $ci =& get_instance();       

    //     $account_number = $ci->session->userdata('account_number');               

    //     $condition = array('account_number'=>$account_number,
    //                              'group_type'=>'MU',
    //                              'type'=>'UG',
    //                              'status'=>1                                
    //                             );

    //     if( $row_array = $ci->general_model->whereCondition('mt_custom_groups',$condition,'account_number')){
    //         return 'mu';
    //     }
        
    //     return '';
    // }


    public static function riseLeverage(){
        $aff_code = $_SESSION['aff_code'];
        if(strlen($aff_code)>2){
            self::CI()->load->model('account_model');
            $getAccountNumberByAffiliateCode = self::CI()->account_model->getAccountNumberByCode($aff_code);
            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

            $condition = array('account_number'=>$getAccountNumberByAffiliateCode['account_number'],
                                 'group_type'=>'MU',
                                 'type'=>'RL',
                                 'status'=>1                                
                                );

            if( $row_array = self::CI()->general_model->whereCondition('mt_custom_groups',$condition,'account_number')){
                return 'mu';
            }
            

            // $affiliate_code_array = array('XOBIO');
            // if(in_array($aff_code,$affiliate_code_array)){return 'mu';};
        }   
        
        return '';
    }

    public static function MTGroupMU(){
        $aff_code = $_SESSION['aff_code'];
        if(strlen($aff_code)>2){
            self::CI()->load->model('account_model');
            $getAccountNumberByAffiliateCode = self::CI()->account_model->getAccountNumberByCode($aff_code);
            $AgentAccountNumber = $getAccountNumberByAffiliateCode['account_number'];

            $condition = array('account_number'=>$getAccountNumberByAffiliateCode['account_number'],
                                 'group_type'=>'MU',
                                 'type'=>'UG',
                                 'status'=>1                                
                                );

            if( $row_array = self::CI()->general_model->whereCondition('mt_custom_groups',$condition,'account_number')){
                return 'mu';
            }
            

            // $affiliate_code_array = array('XOBIO');
            // if(in_array($aff_code,$affiliate_code_array)){return 'mu';};
        }   
        
        return '';
    }


    public static function encode($data) {
        return rtrim( strtr( base64_encode( $data ), '+/', '-_'), '=');
    }
    
    
    public static function decode($data) {
        return base64_decode( strtr( $data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $data )) % 4 ));
    }

    public static function getCopytradeType(){
        $ci =& get_instance();
        $ci->load->library('ForexCopy'); //ForexCopy web service
        $accountNumber = $ci->session->userdata('account_number');
        $serviceData = array('Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetAccountType($serviceData);
        $request_result = $ForexCopy->request_status;
        // 0 follower
        // 1 trader
        // 2 deactivated
        // 3 not registered
        return $request_result;
    }

    
    public static function isCopyAccType($accountNumber=false)
    {
        $ci =& get_instance();      
        $ci->load->library('ForexCopy'); //ForexCopy web service
        
        if(!$accountNumber)
        {
              $accountNumber = $ci->session->userdata('account_number');
        }        
        
        $serviceData = array('Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetAccountType($serviceData);
        $request_result = $ForexCopy->request_status;
        // 0 follower
        // 1 trader
        // 2 deactivated
        // 3 not registered
        
        
          if($request_result>=0)  
          {
              return $request_result;
              
          }else{
              return false;
          }  
    }
    
    
    
    
    public static function getSubPartner($accountNumber){
        $ci =& get_instance();
        $ci->load->model('partners_model');

        if(!$accountNumber){
            $accountNumber = $ci->session->userdata('account_number');
        }


        $subPartner = $ci->partners_model->getCPAReferenceSubByAccount($accountNumber);
        
        if($subPartner) {
            return $subPartner['reference_num'];
        }else{
            return false;
        }
    }
    
    public static function isCPA($accountNumber = null){
        $ci =& get_instance();
        $ci->load->model('partners_model');
        
        if(!$accountNumber){
            $accountNumber = $ci->session->userdata('account_number');
        }
      
        
        if($ci->partners_model->isCPAbyAccount($accountNumber)) {
            return true;
        }else{
            return false;
        }
    }
    public static function isCorpDocumentDeclined(){
        $ci =& get_instance();
        $ci->load->model('user_model');

        $corporateAccount =  $ci->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $ci->session->userdata('user_id')));

        if($corporateAccount->corporate_acc_status && $corporateAccount->corporate_acc_status==2) {
            return true;
        }else{
            return false;
        }
    }

    public static function isClient(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');

        // 0 - client
        // 1 - partner

        if ($ci->session->userdata('login_type') != 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAccountStatusHTML(){
        $CI =& get_instance();
        $accountStatusData = FXPP::getAccountStatus($CI->session->userdata('user_id'),true);
        $status = $accountStatusData['accountstatus'];
        $label = $accountStatusData['accountstatustext'];
        switch($status){
            case 0:
            case 2:
                $labelHtml = '<span class="lbl lbl--default">'. $label .'</span>';
                break;
            case 1:
            case 3:
                $labelHtml = '<span class="lbl lbl--verified">'. $label .'</span>';
                break;

        }

        return $labelHtml;
    }


    public static function getReferralsOfAccount($serviceData = array()){
        $ci =& get_instance();
        $ci->load->library('WSV');
        $WSV = new WSV();
        $requestResult = $WSV->GetReferralsAccount($serviceData);
        $requestStatus = $requestResult['ErrorMessage']; //status

        if ($requestStatus == 'RET_OK') {
            $dataCount = $requestResult['Data']->DataCount; //total count
            $referralList = $requestResult['Data']->Accounts->AccountData;
        }

        $result = array(
            'referralList' => $referralList,
            'referralCount' => $dataCount
        );

        return $result;


    }

    public static function testGetAccountFunds(){

        $CI =& get_instance();
        $CI->load->model('account_model');
        $CI->load->library('WSV'); //New web service

        $getAccountnumber = $CI->account_model->getAccountsByUserId($CI->session->userdata('user_id'));
        $webservice_config = array('server' => 'live_new');

        if(IPLoc::APIUpgradeDevIP()){

            $WebService2 = $CI->wsv->GetAccountFunds($getAccountnumber[0]['account_number']);

            if($WebService2->request_status === "RET_OK"){
                $data['getWithdrawableRealFund']  = $WebService2->result['Withrawable_RealFund'];
                $data['getWithdrawableBonusFund'] = $WebService2->result['Withrawable_BonusFund'];
                $data['equity']                   = $WebService2->result['Equity'];
                $data['margin']                   = $WebService2->result['Margin'];
            }

        }else{

            $WebService2= new WebService($webservice_config);
            $WebService2->RequestAccountFunds($getAccountnumber[0]['account_number']);

            $data['getWithdrawableRealFund']  = $WebService2->get_result('Withrawable_RealFund');
            $data['getWithdrawableBonusFund'] = $WebService2->get_result('Withrawable_BonusFund');
            $data['equity']                   = $WebService2->get_result('Equity');
            $data['margin']                   = $WebService2->get_result('Margin');

        }

        return $data;
    }

    public static function test_leverage_auto_change($accountNumber, $leverage){

        self::CI()->load->library('WSV');

        $info = array(
            'iLogin' => $accountNumber,
            'iLeverage' => $leverage
        );

        $WebService = self::CI()->wsv->SetAccountDetail($info, "SetAccountLeverage");

        return $WebService;

    }
    
    
    public static function DepositRealFund($accountNumber,$amount,$comment){
        self::CI()->load->library('WSV');

        $configURL = 'finance_op';

        $WSV = new WSV($configURL);

        $requestData = array(
            'amount' => (float) $amount,
            'accountNumber' => $accountNumber,
            'comment' => $comment
        );

        $resultData = $WSV->DepositRealFund($requestData);

        return $resultData;
    }

    public static function WithdrawRealFund($accountNumber,$amount,$comment,$is_accepted=0){
        self::CI()->load->library('WSV');

        $configURL = 'finance_op';

        $WSV = new WSV($configURL);

        $requestData = array(
            'amount'        => $amount,
            'accountNumber' => $accountNumber,
            'comment'       => $comment,
            'is_accepted'   => $is_accepted
        );

        $resultData = $WSV->WithdrawRealFund($requestData);

        return $resultData;
    }
    
    public static function WithdrawRealFundV2($accountNumber,$amount,$comment,$is_accepted=0,$cancelComment='W/D_DECLINED'){
        self::CI()->load->library('WSV');

        if(IPLoc::IPOnlyForVenus()){
            $configURL = 'cabinet_staging';
        }else{
            $configURL = 'cabinet';
        }

       

        $WSV = new WSV($configURL);

        $requestData = array(
            'amount'        => $amount,
            'accountNumber' => $accountNumber,
            'comment'       => $comment,
            'cancelComment' => $cancelComment,
            'is_accepted'   => $is_accepted
        );

        $resultData = $WSV->WithdrawRealFund($requestData);

        return $resultData;
    }




    public static function bs3Pagination($base_url,$total_rows,$per_page){
        self::CI()->load->library('pagination');

        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        self::CI()->pagination->initialize($config);
        return self::CI()->pagination->create_links();
    }
    
    
    public static function prohibition($id)
    {
          $CI =& get_instance();
          $CI->load->model('account_model'); 
        
         $data=array(
            "1"=>"Internal transfers",
            "2"=>"Withdrawals", 
        ); 


        $account_data = $CI->account_model->getAccountNumber($CI->session->userdata('user_id'));
        $whr_data=array('account_number'=>$account_data['account_number']);
        
      //  echo "<pre>";        print_r($whr_data);exit;
        
        $provision_data = $CI->account_model->getRow("finance_provision",$whr_data);
            
        if($provision_data)
        {
            
            
             $prohibition_array=array($provision_data->prohibition);
             if(strpos($provision_data->prohibition,","))
             {
                 $prohibition_array=explode(",",$provision_data->prohibition);
             }
        
             if(in_array($id, $prohibition_array))
             {
                 return true;
             }
             else{
                 return false;
             }
            
             
        }else{
            return false;
        }    
        
    }
    
     public static function getAllowNumberOfChangePass($user_id=false,$total_num=false){

        $ci =& get_instance();
        $ci->load->model('account_model');
        
        $current_date=date("Y-m-d");
            
        if(!$user_id)
        {
          $user_id=$ci->session->userdata('user_id');
        }
        
        $user_data=$ci->account_model->getRow("users", array('id'=>$user_id));
        
        $number_of_change_password=$user_data->number_of_change_password;        
        $last_change_password_date=date_format(date_create($user_data->change_password_date),"Y-m-d");
        
        if($total_num)
        {
             if($current_date==$last_change_password_date)
             {
                if($number_of_change_password<4)
                {
                     return $number_of_change_password;
                }else{
                    return "0";
                }
             }
             else
             {
                  return "0";
                 
             }    
             
            
        }
        else
        {    
        
            if($current_date==$last_change_password_date)
            {
               if($number_of_change_password<4)
               {
                   return true;
               }
               else
               {
                   return false;
               }

            }
            else
            {
              return true;  
            }
        }
        
  
  
               
        
            
        
        
    }


    public static function getAllowNumberOfChangePassV2($user_id=false){

        $ci =& get_instance();
        $ci->load->model('account_model');

        $current_date=date("Y-m-d");

        if(!$user_id) {
            $user_id=$ci->session->userdata('user_id');
        }

        $user_data = $ci->account_model->getRow("users", array('id'=>$user_id));

        $number_of_change_password = $user_data->number_of_change_password;
        $last_change_password_date = date_format(date_create($user_data->change_password_date),"Y-m-d");

        if($current_date == $last_change_password_date && $number_of_change_password >= 1){
            return true;
        }else{
            return false;
        }

    }

    public static function isReferralsOfAccount($paymentType){
        // FXPP-12543 and FXPP-12553
        $ci =& get_instance();
        $accountNumber = $ci->session->userdata('account_number');
        if($paymentType == 'IDR'){
            $customListID = array(58021518,58061315,58061126,58060732); //priority accounts
            if(in_array($accountNumber, $customListID)){
                return true;
            }
            $referralListIDR = self::getAccountReferralsFromAllLevels(58060732); //58060732
            if(array_key_exists($accountNumber, $referralListIDR)){
                return true;
            }
        }
        if($paymentType == 'MYR'){
            $customListMY = array(58060735); //priority accounts
            if(in_array($accountNumber, $customListMY)){
                return true;
            }
            $referralListMYR = self::getAccountReferralsFromAllLevels(58060735); //58060735
            if(array_key_exists($accountNumber, $referralListMYR)){
                return true;
            }
        }


        return false;
    }

    public static function getAccountReferralsFromAllLevels($accountNumber, $level = 0 ){
        //level - get all referrals up to params level
        // max level is 3
        // default level is zero - means from 1st to 3rd level referrals


        $ci =& get_instance();
        $ci->load->model('partners_model');

        if (FXPP::isCPA($accountNumber)) { // check if account is CPA Partner
            $accountNumber = FXPP::getSubPartner($accountNumber);
        }

        $referrals = array();
        $levelOneAffiliateCodes = $ci->partners_model->getAffiliateCodeofAgent($accountNumber, 'partner')['rows'];


        //level 1 referrals
        if (count($levelOneAffiliateCodes) > 0) {
            foreach ($levelOneAffiliateCodes as $key) {

                $referralLevelOne = $ci->partners_model->getReferralsByCode($key->affiliate_code)['rows'];

                foreach ($referralLevelOne as $key => $value) {

                    $referrals[$value->account_number] = array(
                        'account_number'          => $value->account_number,
                        'registration_date'       => date("Y-m-d", strtotime($value->registration_time)),
                        'name'                    => $value->full_name,
                        'email'                   => $value->email,
                        'phone_no'                => $value->phone1,
                        'account_type'            => $value->account_type,
                        'accountstatus'            => $value->accountstatus,
                        'level'                   => 1,
                    );
                  
                }
            }
        }

        if($level == 1){
            return $referrals;
        }



        //level 2 referrals
        if (count($referrals) > 0) {
            foreach ($referrals as $key_sub => $value_sub) {
                if($value_sub['level'] == 1) {
                $levelTwoAffiliateCodes = $ci->partners_model->getAffiliateCodeofAgent($value_sub['account_number'], 'partner')['rows'];

                if (count($levelTwoAffiliateCodes) > 0) {
                    foreach ($levelTwoAffiliateCodes as $key) {

                            $referralLevelTwo = $ci->partners_model->getReferralsByCode($key->affiliate_code)['rows'];

                            foreach ($referralLevelTwo as $key => $value) {

                                $referrals[$value->account_number] = array(
                                    'account_number'    => $value->account_number,
                                    'registration_date' => date("Y-m-d", strtotime($value->registration_time)),
                                    'name'              => $value->full_name,
                                    'email'             => $value->email,
                                    'phone_no'          => $value->phone1,
                                    'account_type'      => $value->account_type,
                                    'level'             => 2,
                                );

                            }
                        }
                    }
                }
            }

        }

        if($level == 2){
            return $referrals;
        }

        //level 3 referrals
        foreach ($referrals as $key_sub => $value_sub) {
            if($value_sub['level'] == 2){
                $levelThreeAffiliateCodes = $ci->partners_model->getAffiliateCodeofAgent($value_sub['account_number'], 'partner')['rows'];

                if (count($levelThreeAffiliateCodes) > 0) {
                    foreach ($levelThreeAffiliateCodes as $key) {

                        $referralLevelThree = $ci->partners_model->getReferralsByCode($key->affiliate_code)['rows'];

                        foreach ($referralLevelThree as $key => $value) {

                            $referrals[$value->account_number] = array(
                                'account_number'          => $value->account_number,
                                'registration_date'       => date("Y-m-d", strtotime($value->registration_time)),
                                'name'                    => $value->full_name,
                                'email'                   => $value->email,
                                'phone_no'                => $value->phone1,
                                'account_type'            => $value->account_type,
                                'level'                   => 3,
                            );

                        }
                    }
                }
            }

        }

        if($level == 3 || $level == 0){
            return $referrals;
        }



    }


    public static function DepositBonus10Percent($user_id, $account_number, $amountDeposited, $module, $bonus, $depositId){
        $CI =& get_instance();
        $CI->load->model('deposit_model');

        $depositBonusType = array(
            'tenpb'=> 0.1
        );

        $amountDeposited = (float) $amountDeposited;
        $bonusPercent    = (float) $depositBonusType['tenpb'];
        $amount          = $amountDeposited * $bonusPercent;

        $date_bonus_acquired = date('Y-m-d H:i:s');

        $bonusArray_v1 = array(
            'AmountDeposited' => $amountDeposited,
            'AmountBonus'     => $amount,
            'DateProcessed'   => $date_bonus_acquired,
            'UserId'          => $user_id,
            'AccountNumber'   => $account_number,
            'TransactionPage' => $module,
            'Ticket'          => null,
            'BonusType'       => $bonus,
            'DepositId'       => $depositId,
            'BonusStatus'     => 2
        );

        $CI->deposit_model->insertDepositBonus($bonusArray_v1);
    }





    public static function accStatusSideBtn($type = 1){
        $CI =& get_instance();
        
        $accountStatusData = FXPP::getAccountStatus($CI->session->userdata('user_id'),true);
        $status = $accountStatusData['accountstatus'];
        $label = $accountStatusData['accountstatustext'];
           $isVerified = false;

            switch($status){
                case 0:
                    $st_class="btnTemp-verify";
                    $bg_color="background:gray";
                    break;
                case 1:
                    $isVerified = true;
                    $st_class="btnTemp-verified";
                    $bg_color="background: linear-gradient(#2ab045,#259d3d,#16872e)";
                    break;
                case 3:
                    $isVerified = true;
                    $st_class="btnTemp-verify";
                    $bg_color="background: linear-gradient(#2ab045,#259d3d,#16872e)";
                    break;
                case 2:
                    $st_class="btnTemp-verify";
                    $bg_color="background:brown";
                    break;
                case 4:
                    $st_class="btnTemp-verify";
                    $exception_class="verified_no_doc_font_small";
                    $bg_color="background:gray";
                    break;
                default:
                    $exception_class ="";
                    $bg_color="";
                    break;
                    
            }
            if($type == 1) {//desktop
                $st_class = "verified";
            }
            $btnHTML = '<button class="'. $st_class.' sidebar_verification_button verified-custom '. $exception_class.'"  style="'.$bg_color.'" ><i class="fa fa-check-square-o fa-lg"></i>'.$label.'</button>';

            if(!$isVerified){
                $btnHTML = '<a href="'.FXPP::loc_url('profile/upload-documents').'">'.$btnHTML.'</a>';

            }


        return $btnHTML;

    }
            
          
    
    
 public static function getAccountStatus($user_id=null,$code_text=null,$text_html=null){
    self::CI()->lang->load('myaccount');
    if(is_null($text_html))
      {
          $data=array(
                0=>lang('txt-pending'),
                1=>lang('txt-ver-lev-2'),
                2=>lang('txt-declined'),
                3=>lang('txt-ver-lev-1'),
                4=>lang('txt-no-doc-sub'),
                5=>lang('default_mgs'),
                6=>lang('declined_mgs'),
                7=>lang('level_one_mgs'),
                8=>lang('default_button_text'),
                9=>lang('declined_button_text'),
                10=>lang('level_one_button_text'),
            )  ;
      }else{
           $data=array(
                0=>"<b style='color:gray'>".lang('txt-pending')."</b>",
                1=>"<b style='color:green'>".lang('txt-ver-lev-2')."</b>",
                2=>"<b style='color:red'>".lang('txt-declined')."</b>",
                3=>"<b style='color:green'>".lang('txt-ver-lev-1')."</b>",
                4=>"<b style='color:gray'>".lang('txt-no-doc-sub')."</b>",
                5=>"<b style='color:gray'>".lang('default_mgs')."</b>",
                6=>"<b style='color:gray'>".lang('declined_mgs')."</b>",
                7=>"<b style='color:gray'>".lang('level_one_mgs')."</b>",
                8=>"<b style='color:gray'>".lang('default_button_text')."</b>",
                9=>"<b style='color:gray'>".lang('declined_button_text')."</b>",
                10=>"<b style='color:gray'>".lang('level_one_button_text')."</b>",
            )  ;
      } 

      $upload_link=FXPP::loc_url('profile/upload-documents');

     if(!is_null($user_id))
     {

            $ci =& get_instance();
            $ci->load->database();
            $ci->load->model('General_model');

            $user_data= $ci->General_model->showssingle("users","id",$user_id);
            $account_status=$user_data['accountstatus'];

            if($account_status<=0)
            {
                $check_user_documents= $ci->General_model->showssingle("user_documents","user_id",$user_id);     
             
                if(!$check_user_documents)
                {
                    $account_status=4;
                }
            }
         
            if(array_key_exists($account_status,$data)) 
            {
                 if(!is_null($code_text))
                {

                    $retun_data=array(
                        "accountstatus"=>$account_status,
                        "accountstatustext"=>$data[$account_status],
                        "default_mgs" => $data[5],
                        "declined_mgs" => $data[6],
                        "level_one_mgs" => $data[7],
                        "default_button_text" => $data[8],
                        "declined_button_text" => $data[9],
                        "level_one_button_text" => $data[10],
                        "link"=>$upload_link,
                    )    ;
                    
                    return  $retun_data;
                }else{
                    return $data[$account_status];
                }

            }else{
                
                if(!is_null($code_text))
                {
                     $retun_data=array(
                    "accountstatus"=>$account_status,
                    "accountstatustext"=>$data[4],
                    "default_mgs" => $data[5],
                    "declined_mgs" => $data[6],
                    "level_one_mgs" => $data[7],
                    "default_button_text" => $data[8],
                    "link"=>$upload_link,     
                    )  ;
                     
                      return  $retun_data;
                    
                }else{
                    return $data[4];
                }
             
            }
         
     }else{
         return $data;
     }

}

public static function getTranslations()
{
    self::CI()->load->language('myaccount');

    return [
        "about_leverage" => lang("about_leverage"),
        "edit_leverage" => lang("edit_leverage"),
        "to" => lang("to"),
        "want_changes" => lang("want_changes"),
        "no" => lang("no"),
        "yes" => lang("yes")
    ];
}
    
   	
    public static function fbLoginUrl($config=array()){
        
            
          self::CI()->load->library('Social');  
            return Social::fbAPI($config)['fb_url'];
            
            
    }
    
     public static function googleLoginUrl($config=array()){
        
            
          self::CI()->load->library('Social');  
            return Social::googleAPI($config)['goole_url'];
            
            
    }

    public function freeCurrencyConverter($fromCurrency,$toCurrency,$amount){
        $currencyPair = $fromCurrency.'_'.$toCurrency;

        $fileContent = file_get_contents("https://free.currconv.com/api/v7/convert?q=".$currencyPair."&compact=ultra&apiKey=16890856c5eb63c8c9ab");
        $jsonData = json_decode($fileContent,true);
        $convAmount = 0;
        if($jsonData[$currencyPair] > 0){
            $convAmount = $jsonData[$currencyPair] * $amount;

        }
      
       /* log*/
        $log_data = array(
            'log'=>"from ".$fromCurrency.">>".$amount.">>to ".$toCurrency,
            'amount'=>$convAmount,
            'currency'=>$fromCurrency.$toCurrency,
            'user_id'=>self::CI()->session->userdata('user_id'));

        self::CI()->general_model->insertmy('convert_amount_log', $log_data);

        return $convAmount;

    }

    public static function Dump($dataarray,$todie = false) {
        echo '<pre>',print_r($dataarray,1),'</pre>';
        if ($todie) {
            die();
        }
    }


    public static function isPayomaUser(){
        self::CI()->load->model('deposit_model');
        $userId = self::CI()->session->userdata('user_id');
        
        return self::CI()->deposit_model->isPayomaUser($userId);
    }
    public static function isPaymentMethodAvailable($transaction_type){
        self::CI()->load->model('deposit_model');
        $userId = self::CI()->session->userdata('user_id');
        $accountNumber = self::CI()->session->userdata('account_number');

        // custom allowed accounts for nova2pay withdrawal
        $customNova2payList = array('58082002');
        if($transaction_type == 'NOVA2PAY'){
            if (in_array($accountNumber, $customNova2payList)) {
               return true;
            }
         
        }

        
        return self::CI()->deposit_model->isPaymentMethodAvailable($userId,$transaction_type);
    }




    public static function isPayomaUserWithdraw(){
        self::CI()->load->model('deposit_model');
        $userId = self::CI()->session->userdata('user_id');
        
        return self::CI()->deposit_model->isPayomaUserV2($userId);
    }

    public static function buildUpPage($default_page,$maintenance_is_ongoing=false)
    {
        if($maintenance_is_ongoing){
            return "maintenance_is_ongoing";
        }else{
            return $default_page;
        }
    }


    public static function getZPBanks($currency=""){

        $paymentMethod = array(
            'MYR' => array(
                'CIMB' => 'CIMB Bank',
                'HLB' => 'Hong Leong Bank',
                'PBB' => 'Public Bank',
                'RHB' => 'RHB Bank',
                'MBB' => 'Maybank',
                'AMB' => 'AmBank Group',
                'BIMB' => 'BIMB Bank',
            ),
            'THB' => array(
                'KKR ' => 'KKR',
                'KTB ' => 'KTB',
                'SCB ' => 'SCB',
                'BBL ' => 'BBL',
                'BOA ' => 'BOA',
                'CIMBT ' => 'CIMBT',
                'KNK ' => 'KNK',
                'TMB ' => 'TMB',
                'GSB' => 'GSB',
            ),
            'VND' => array(
                'VCB' => 'VCB',
                'TCB' => 'TCB',
                'SACOM' => 'SACOM',
                'VTB' => 'VTB',
                'ACB' => 'ACB',
                'DAB' => 'DAB',
                'BIDV' => 'BIDV',
                'EXIM' => 'EXIM',
            ),
            'IDR' => array(
                'BCA' => 'KlikBCA',
                'BNI' => 'BNI Bank',
                'BRI' => 'BRI Bank',
                'CIMBN' => 'CIMB Niaga',
                'MDR' => 'Bank Mandiri',
                'PMTB' => 'Bank Permata',
            ),
            'CNY' => array(
                'UP' => 'Union Pay',

            ),
           'LAK' => array(
                'SCB' => 'SCB', 
            ),
          'MMK' => array(
                'SCB' => 'SCB', 
            ),
           'KHR' => array(
                'SCB' => 'SCB', 
            ),
           'ZAR' => array(
                'SCB' => 'SCB', 
            )


        );
        if ($currency) {
            return isset($paymentMethod[$currency]) ? $paymentMethod[$currency] : false;
        } else {
            return false;
        }
    }
    public static  function getZPMinimumDeposit($currency="",$bank=""){
        if($currency == 'MYR'){
            switch($bank) {
                case 'CIMB':
                case 'HLB':
                case 'RHB':
                case 'PBB':
                case 'MBB':
                    $min =  10; break;

                    break;
                case 'AMB':
                case 'BIMB':
                    $min =  50; break;
            }

        }
        if($currency == 'THB'){
            switch($bank) {
                case 'KKR':
                case 'KTB':
                case 'SCB':
                case 'BBL':

                    $min =  100; break;
                case 'BOA':
                case 'CIMBT':
                case 'KNK':
                case 'TMB':
                case 'GSB':
                    $min =  500; break;
            }

        }
        if($currency == 'VND') {
            switch ($bank) {
                case 'VCB':
                case 'TCB':
                case 'SACOM':
                case 'VTB':
                case 'ACB':
                case 'DAB':
                case 'BIDV':

                    $min = 60000;
                    break;
                case 'EXIM':
                    $min = 300000;
                    break;
            }
        }

        if($currency == 'IDR') {
            switch ($bank) {
                case 'BCA':
                case 'BNI':
                case 'BRI':
                    $min = 60000;
                break;
                case 'CIMBN':
                case 'MDR':
                case 'PMTB':
                    $min = 300000;
                    break;
            }
        }

        return $min;
    }

    public static  function getTnxType($type = 1){
        $tnxType = array();
        $data = self::CI()->general_model->getTnxTypeList();
        if($data){
            foreach ($data as $d){
                if($type == 1){
                    $tnxType[] = $d['SubType']; // deposit
                }else{
                    $tnxType[] = $d['SubTypeCode']; //withdraw
                }

            }
            return $tnxType;
        }

        return false;

    }
    
     public static  function getTimeDuration($user_from_data,$type_of_type=false){
         
         //$type_of_type='seconds/minutes/hours/days/months/years/';
                
        
        $from_date = new DateTime($user_from_data);
        $today_date = new DateTime();                
        $interval = $today_date->diff($from_date);
        
        $date_data=array(
            "years"=>$interval->format('%y'),
            "months"=>$interval->format('%m'),
            "days"=>$interval->format('%d'),
            "hours"=>$interval->format('%h'),
            "minutes"=>$interval->format('%i'),
            "seconds"=>$interval->format('%s'),
            
        );
        
        if($type_of_type){
            if (array_key_exists($type_of_type,$date_data))
            {
               return  $date_data[$type_of_type];
                
            }else{
                return $date_data;
            }
             
        }else{
            return $date_data;
        }     

    }
    
      public static  function isAutoVeriFiedAllow($timeData){
          // max $duration="6" month 
                
          if($timeData['years']<1)
          {
                if($timeData['months']>6)
                {
                    return false;
                }
                else if($timeData['months']<6)
                {
                    return true;
                }
                else 
                {
                    if($timeData['days']<=1)
                    {
                        return true;
                    }else{
                        return false;
                    }                    
                }    
                
           }
           else
           {
               return false;
           }
      }

    public static function TransactionStatus($is_accepted=0, $ITS=false, $comment=null){
//        if(IPLoc::StatusTask()){
//
//            switch($is_accepted){
//                case 0:
//                    $status = ($ITS) ? 'Sent' : 'Pending';
//                    break;
//                case 1:
//                    $status = 'Credited';
//                    if($ITS && (strpos($comment, 'DPST_TR') !== false)){
//                        $status = 'Received';
//                    }
//                    break;
//                case 2:
//                    $status = ($ITS) ? 'Not Approved' : 'Not Credited';
//            }
//
//            return $status;
//
//        }else{
//
            $status = array(
                0 => 'PENDING',
                1 => 'CREDITED',
                2 => 'NOT CREDITED'
            );

            return (array_key_exists($is_accepted, $status)) ? $status[$is_accepted] : 'Undefined Status';
//        }

    }
    
    public static function isHiddenItem($item_data){
        if(strtolower($item_data)=="hidden")
        {
            return "N/A";
        }else{
            return $item_data;
        }
    }
     public static function getTransitTransferAllowAccount($account_number){
                
          $tye_data= array(
            '1' =>"ForexMart Standard",
            '2' => "ForexMart Zero Spread",
            '4' => "ForexMart Micro",
            '5' => 'ForexMart Classic',
            '6' => 'ForexMart Pro',
            '7' => 'ForexMart Cents',
        );
          
        $intransitTransData=array('5','7');  
          
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $user_id = $ci->session->userdata('user_id');
        $data = $ci->general_model->getClientAccountDetails($account_number);
        
        if($data)     
        {
            $accont_type=$data->mt_account_set_id;
            if(in_array($accont_type,$intransitTransData))
            {
                return true;
            }else{
                return false;
            }    
            
        }else{
            return false;
        }  
                
    }
    
    
     public static function isSpecailTransitTransferPartner()
    {
         if(IPLoc::frz(true)){
             $partner_data=array("58045279","58028358","58075679","58069799");
         }else{
            $partner_data=array("58045279","58028358","58069799");     
         }
     
         // $partner_data=array("58045279","58028358");  
          
          
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $user_id = $ci->session->userdata('user_id');
        $data = $ci->general_model->getPartnerAccountDetailsByid($user_id);
  
         if($data)     
        {
            $account_number=$data->reference_num;
            if(in_array($account_number,$partner_data))
            {
                return true;
            }else{
                return false;
            }    
            
        }else{
            return false;
        }
        
    }
   public static function isReadOnlyRemoveFromMWP(){
        $ci =& get_instance();
        $ci->load->model('General_model');
        
         $mwp_login_userId=$ci->session->userdata('mwp_login_userId');
        // [cabinet access form mpw panel]=>qjgot
        $cabinet_access_code="qjgot"; 
        
       $data=$ci->General_model->checkPermissionRemoveReadOnlyMWP($mwp_login_userId,$cabinet_access_code);
                
        if($data) 
        {
          return true;
        }else{
            return false;
        }
   }

   public static function SetLeverage_new($account_number, $leverage){ //FXPP-13638
       $CI = self::CI();
       $CI->load->library('WSV');

       $info = array(
           'iLogin'    => $account_number,
           'iLeverage' => intval($leverage)
       );

       $WSV = new WSV();
       $WebService = $WSV->SetAccountDetail($info, "SetAccountLeverage");

        return $WebService;
   }

    public static function SetLeverage($account_number, $leverage){

        $config = array(
            'server' => 'live_new'
        );
        $info = array(
            'iLogin' => $account_number,
            'iLeverage' => $leverage
        );

        $WebService = new WebService($config);
        $WebService->open_ChangeAccountLeverage($info);

        return $WebService;
    }

   public static function SetAccountGroup($account_number, $group){
       $CI = self::CI();
       $CI->load->library('WSV');

       $info = array(
           'iLogin'   => $account_number,
           'strGroup' => $group
       );

       $WSV = new WSV();
       $WebService = $WSV->SetAccountDetail($info, "SetAccountGroup");

       return $WebService;
   }

    public static function CreditBonus($type, $amount, $comment, $account_number){
        $CI = self::CI();
        $CI->load->library('WSV');

        $params = array(
            'type'           => $type,
            'amount'         => $amount,
            'comment'        => $comment,
            'isAccepted'     => 1,
            'accountNumber'  => $account_number
        );

        $WSV = new WSV('finance_op');
        $WebService = $WSV->CreditBonus($params);

        return $WebService;
    }



    static function isMicroAccountChk($accountNumber = NULL){
        if($accountNumber){
            $accountType = self::CI()->general_model->showssingle2('mt_accounts_set','account_number',$accountNumber,'mt_account_set_id')['mt_account_set_id'];
        }else{
            $accountType = self::CI()->session->userdata('mt_account_set_id');

        }
        if($accountType == 4  || $accountType == 7 ) {
            return true;
        }
        return false;


    }


    public static function depositFeeAllowCountry($country_code){
        
        // if match country return true else false;    
        
         $country_data=array(
              "AE"=>"UNITED ARAB EMIRATES","AL"=>"ALBANIA","AM"=>"ARMENIA","AR"=>"ARGENTINA","AZ"=>"AZERBAIJAN","BA"=>"BOSNIA AND HERZEGOVINA","BD"=>"BANGLADESH","BG"=>"BULGARIA",
             "BR"=>"BRAZIL","BY"=>"BELARUS","CL"=>"CHILE","CO"=>"COLOMBIA","CR"=>"COSTA RICA","CY"=>"CYPRUS","CZ"=>"CZECH REPUBLIC","EE"=>"ESTONIA","EG"=>"EGYPT","GE"=>"GEORGIA",
             "GR"=>"GREECE","HR"=>"CROATIA","HU"=>"HUNGARY","ID"=>"INDONESIA","IL"=>"ISRAEL","IN"=>"INDIA","IS"=>"ICELAND","JP"=>"JAPAN","KE"=>"KENYA","KH"=>"CAMBODIA","KR"=>"KOREA, REPUBLIC OF",
             "KW"=>"KUWAIT","KZ"=>"KAZAKHSTAN","LK"=>"SRI LANKA","LT"=>"LITHUANIA","LV"=>"LATVIA", "MD"=>"MOLDOVA, REPUBLIC OF", "ME"=>"MONTENEGRO", "MK"=>"MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
             "MX"=>"MEXICO","MY"=>"MALAYSIA", "NG"=>"NIGERIA", "OM"=>"OMAN", "PE"=>"PERU","PK"=>"PAKISTAN","RO"=>"ROMANIA","RS"=>"SERBIA","RU"=>"RUSSIAN FEDERATION","SA"=>"SAUDI ARABIA","SC"=>"SEYCHELLES",
             "SI"=>"SLOVENIA", "TH"=>"THAILAND", "TN"=>"TUNISIA","TR"=>"TURKEY", "TW"=>"TAIWAN, PROVINCE OF CHINA", "UA"=>"UKRAINE","UY"=>"URUGUAY","VE"=>"VENEZUELA","VN"=>"VIETNAM","ZA"=>"SOUTH AFRICA", 
              ) ; 
         if($country_code){
             $country_code=strtoupper($country_code);        
             
             if(isset($country_data[$country_code]))             
             {
                 if(array_key_exists($country_code,$country_data))
                    {
                     return true;
                     
                    }else{
                        return false;
                    }
                 
             }else{
                 return false;
             }
             
             
         }else{
             return false;
         }
         
    }

    
public static function getTotalCommissionFromAllReferralsAccounts($account_number=false){

        $offset = 0;
        $length = 10000; // max referrals
        $dateFrom = 0;
        if(!account_number){
            $accountNumber = self::CI()->session->userdata('account_number');
        }
        $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

        $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $length, 'Offset' => $offset,'Accounts' => 0);

        $totalCommission = FXPP::getTotalCommissionFromAllReferralsAPI($requestData,true);

        return $totalCommission;

    }      
    

 public static function getTotalCommissionFromAllReferralsAPI($requestData = array(),$isTotal = false){
        self::CI()->load->library('WSV');

        $WSV = new WSV();
        $requestResult =  $WSV->GetTotalCommissionFromAllReferrals($requestData);
        $requestStatus = $requestResult['ErrorMessage']; 
        $referralCommissionData =  $requestResult['Data']->Commissions->Commission;


        $referralCommission = array();
        $totalCommission = 0;

        foreach($referralCommissionData as $k => $v){
            $referralCommission[$v->From] = array(
                'Amount' => round($v->Amount,2),
            );
            $totalCommission +=  $v->Amount;

        }

        if($isTotal){
           return  round($totalCommission,2);
        }


        $result = array(
            'commissionList' => $referralCommission
        );


   

        return $result;


    }
    
public static function getAllowAccounts($account_number=false){

                if(!$account_number)
                {                    
                    $account_number= self::CI()->session->userdata('account_number');
                }
                
                $access_allow_account=array("58064415");
                
                if(in_array($account_number,$access_allow_account))
                { 
                   return true; 
                }else{
                    return false;
                }

 }      
    


 public static function getAutoLoginRemoveAccess(){
    
     $ip=FXPP::CI()->input->ip_address();
   
    $data=array('136.243.104.88','localhost'); 
    
    if(in_array($ip,$data))
    {
     return  true;
        
    }else{
        return false;
    }
    
    
}

public static function isMasterCard(){
    
   $method_name=FXPP::CI()->router->fetch_method();
    if($method_name=="master_cards"){
        return true;
    }else{
        return false;
    }
}




    public static function thunderXpayAllow($country_code=false,$account_number=false){

        // if match country return true else false;


        $country_data=array("TH"=>"THAILAND","KH"=>"CAMBODIA","ZA"=>"SOUTH AFRICA",'MM'=>'MYANMAN', 'LAK'=>'LAOS' );
        $ip_data=array('::1','localhost','49.12.5.139');
        $access_allow_account=array("58064415");



       $user_account_number=FXPP::CI()->session->userdata('account_number');

       $ip=FXPP::CI()->input->ip_address();
       $user_country = FXPP::getCountryCode($ip);




                if($country_code){
                    $country_code= strtoupper($country_code);
                }else{
                      $country_code= strtoupper($user_country);
                }


               if(!$account_number){
                      $account_number=$user_account_number;
                }





        if(in_array($ip,$ip_data) or (array_key_exists($country_code,$country_data)) or (in_array($account_number,$access_allow_account)))
        {
            return true;

        }else{
            return false;
        }





    }


   public static function showImg($file_name,$location=false)
    {

        $ci =& get_instance();
         $types = [
             'gif'=> 'image/gif',
             'png'=> 'image/png',
             'jpeg'=> 'image/jpeg',
             'jpg'=> 'image/jpeg',
         ];



         if(!$location)
         {
             $location=$ci->config->item('asset_user_docs');
         }

         $defailt_target_file=$location."default.png";

         $target_file=$location.$file_name;

         if(file_exists($target_file))
         {

                 $path = $target_file;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $data_image = 'data:image/' . $type . ';base64,' . base64_encode($data);

             return $data_image;
         }else{

                $path = $defailt_target_file;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $data_image = 'data:image/' . $type . ';base64,' . base64_encode($data);

                return $data_image;

         }


    }

     public static function showVideo($file_name,$location=false)
    {

        $ci =& get_instance();
         $types = [
             'mp4'=> 'video/mp4',
             'mov'=> 'video/mov',
             'webm'=> 'video/webm',
             'mkv'=> 'video/mkv',
             'flv'=> 'video/flv',
             'avi'=> 'video/avi',
         ];



         if(!$location)
         {
             $location=$ci->config->item('asset_user_docs');
         }

         $defailt_target_file=$location."default.mp4";

         $target_file=$location.$file_name;




         if(file_exists($target_file))
         {

                 $path = $target_file;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $data_video = 'data:video/' . $type . ';base64,' . base64_encode($data);

             return $data_video;
         }else{

                $path = $defailt_target_file;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $data_video = 'data:video/' . $type . ';base64,' . base64_encode($data);

                return $data_video;

         }


    }


    
}