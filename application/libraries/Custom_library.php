<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom_library {

    public static function canCreateVirtualAccount(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('virtual_account_model');

        $user_id = $ci->session->userdata('user_id');
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);

        if( $virtual_accounts === false || count($virtual_accounts) < 5 ){
            return true;
        }else{
            return false;
        }
    }

    public static function hasCreateVirtualAccount(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('virtual_account_model');

        $user_id = $ci->session->userdata('user_id');
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);

        if( $virtual_accounts === false ){
            return false;
        }else{
            return true;
        }
    }

    public static function getAccountCurrencyBase(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = $ci->general_model->getAccountCurrencyBase();
        $virtual_accounts = $ci->virtual_account_model->getVirtualAccountsByUserId($user_id);
        if( !empty($virtual_accounts) ) {
            foreach ($virtual_accounts as $account) {
                if (in_array($account['currency'], $account_currency_base)) {
                    unset($account_currency_base[$account['currency']]);
                }
            }
        }
        return $account_currency_base;
    }

    public static function getUserAccountCurrencyBase(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach( $virtual_accounts as $account ){
            $account_currency_base[$account['mt_currency_base']] = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']) . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']';
        }
        return $account_currency_base;
    }

    public static function getDepositCurrencyBase(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach( $virtual_accounts as $account ){
            $account_currency_base[$account['id']] = $ci->general_model->getAccountCurrencyBase($account['mt_currency_base']) . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']';
        }
        return $account_currency_base;
    }

    public static function getUserCurrency(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        $ci->load->model('account_model');

        $user_id = $ci->session->userdata('user_id');
        $account_currency_base = array();
        $virtual_accounts = $ci->account_model->getAccountsByUserId($user_id);

        foreach( $virtual_accounts as $account ){
            $account_currency_base[$account['mt_currency_base']] = $account['mt_currency_base'];
        }
        return $account_currency_base;
    }

    public static function getDepositAmountOptions(){
        $selectOption = "";
        for ($amount = 100; $amount <= 2500; $amount += 100){
            $selectOption= $selectOption."<option value='".$amount."'>".$amount."</option>";
        }
        return $selectOption;
    }

    public static function getCountries(){
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->model('general_model');
        return $ci->general_model->getCountries();
    }

    public static function getCurrentDateTime(){
        require_once("geoip/geoipcity.inc");
        require_once("geoip/geoipregionvars.php");
        require_once("geoip/timezone.php");

        //Get remote IP
        $ip = $_SERVER['REMOTE_ADDR'];

        //Open GeoIP database and query our IP
        $gi = geoip_open(APPPATH . "libraries/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);

        //If we for some reason didnt find data about the IP, default to a preset location.
        //You can also print an error here.
        if(!isset($record)){
            redirect('signout');
        }

        //Calculate the timezone and local time
        try{
            //Create timezone
            $user_timezone = new DateTimeZone(get_time_zone($record->country_code, ($record->region!='') ? $record->region : 0));

            //Create local time
            $user_localtime = new DateTime("now", $user_timezone);
        } catch(Exception $e){    //Timezone and/or local time detection failed

            $user_localtime = new DateTime("now");
        }

        return $user_localtime->format('Y-m-d H:i:s');
    }

    public static function getUserCountryCode(){
        require_once("geoip/geoipcity.inc");
        require_once("geoip/geoipregionvars.php");
        require_once("geoip/timezone.php");

        //Get remote IP
        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = "192.138.220.82";

        //Open GeoIP database and query our IP
        $gi = geoip_open(APPPATH . "libraries/geoip/GeoLiteCity.dat", GEOIP_STANDARD);
        return geoip_country_code_by_addr($gi, $ip);
    }

    public static function GenerateWalletNumber(){
        $CI =& get_instance();
        $CI->load->model('account_model');

        $walletNum = 'FM'.self::RandomizeNumber(8);

        $unique = $CI->account_model->checkIfUniqueAccountNumber($walletNum);

        return ($unique) ? $walletNum : self::GenerateWalletNumber();
    }

    private static function RandomizeNumber($length){

        $random = '';
        for($i = 0; $i<$length; $i++){
            $random .= mt_rand(0,9);
        }

        return $random;
    }

    public function selectAccountNumber($user_id){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $getAllAccountNumber = $CI->account_model->getAllAccountNumber($user_id);
        $selectOption = '';
        foreach($getAllAccountNumber as $key=>$d){
            $selectOption= $selectOption."<option value='".$d['account_number']."'>".$d['account_number']."</option>";
        }

        return $selectOption;
    }

    public static function validate_user_account_by_id( $id ){
        $CI =& get_instance();
        $CI->load->model('account_model');
        $user_id = $CI->input->post('session_id');
        $is_valid = $CI->account_model->check_user_account_number_by_id($user_id, $id);
        return $is_valid;
    }

    public static function encrypt_data( $str_data, $key ){
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

    public static function decrypt_data( $str_data, $key ){
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

    public static function generateGUIDForgotPassword(){
        $CI =& get_instance();
        $CI->load->model('user_model');

        $create_token = self::RandomizeCharacter(21);
        $unique = $CI->user_model->validateToken($create_token);

        return ($unique) ? $create_token : self::generateGUIDForgotPassword();
    }

    public static function RandomizeCharacter($length){

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for($i = 0; $i<$length; $i++){
            $result .= $characters[mt_rand(0, 61)];
        }

        return $result;
    }

}