<?php
/**
 * Created by PhpStorm.
 * User: Zeta-Elmer
 * Date: 5/20/2015
 * Time: 1:31 PM
 */

Class Form_key{

    public function __construct(){

    }

    public static  function InputKey_array($url = false){
        if($url){
            $url = $url;
        }else{
            $url = "http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];
        }
        $CI =& get_instance();

        $key=self::generateKey();
        $minutes = 10;
        $enkey=self::encrypt_Rijndael($key);
        $CI->input->set_cookie('FK_forexmart',$enkey, time() + 600);

        return array('form_key' => $enkey);
    }

    public static function isValid( $key ){
        $CI =& get_instance();
        $encrypted_key = self::decrypt_Rijndael($CI->input->cookie('forexmart_FK_forexmart'));
        $form_key = self::decrypt_Rijndael($key);
        return $encrypted_key == $form_key;
    }

    public static  function GetKey(){
        $key=self::generateKey();
        return $key;
    }

    public static function generateKey(){
        $CI =& get_instance();
        $ip =  $CI->input->ip_address();
        $uniqid = uniqid(mt_rand(), true);
        return  md5($ip . $uniqid);
    }

    public static function decrypt_Rijndael($cipher){
        $key = pack('H*', "DC744BC7893FEB4D"); //random key hexadecimal "DC744BC7893FEB4D"
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $ciphertext_dec = base64_decode($cipher);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
        return  $plaintext_dec ;
    }
    public  static function encrypt_Rijndael($plaintext){
        $key = pack('H*', "DC744BC7893FEB4D");//random key hexadecimal "DC744BC7893FEB4D"
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$plaintext, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
        $ciphertext_base64 = base64_encode($ciphertext);
        return  $ciphertext_base64;
    }

}