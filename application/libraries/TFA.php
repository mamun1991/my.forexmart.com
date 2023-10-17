<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TFA
{
    private $CI;

    public function __construct(){

        $this->CI =& get_instance();

    }

    public function TFAProcess($userID, $username, $password){
        $this->CI->load->model('account_model');

        $TFASettings =$this->CI->account_model->GetTFASettings($userID);
        if($TFASettings['isEnabled'] == 1){
            $this->TwoFactorAuthentication($userID, $username, $password);
        }

    }

    protected function TwoFactorAuthentication($userID, $username, $password){
        $this->CI->load->library('session');
        if( !$this->CI->session->userdata('TFA') ){
            $this->CI->load->model('account_model');
            //set default TFA session
            $this->CI->session->set_userdata('TFA', 0);

            $TFASettings =$this->CI->account_model->GetTFASettings($userID);

            if( ! $TFASettings ){
                return;
            }

            if( ! $TFASettings['isEnabled'] ){
                return;
            }

            $this->CI->session->set_userdata('TFA', $TFASettings['isEnabled']);
            $this->CI->session->set_userdata('TFASecret', $TFASettings['SecretKey']);
            $this->CI->session->set_userdata('RequireTFALogin', 'ON');

            $credentials = array(
                'username'  => $username,
                'password'  => $password
            );

            $this->CI->session->set_userdata('TFACredentials', json_encode($credentials));

            header('Location: '.FXPP::my_url('two-step-authentication'));exit;
        }else{
            //Check if TFA is enabled
            if($this->CI->session->userdata('TFA') == 1){

                if($this->CI->session->userdata('RequireTFALogin') == 'ON'){
                    header('Location: '.FXPP::my_url('two-step-authentication'));exit;
                }else{

                    $this->CI->session->unset_userdata('TFACredentials');
                    $this->CI->session->unset_userdata('AccountType');

                }

            }
        }

    }


}
