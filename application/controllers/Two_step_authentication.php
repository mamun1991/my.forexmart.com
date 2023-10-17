<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Two_step_authentication extends CI_Controller {

    public function __construct(){
        parent::__construct();

           $this->load->library('Cyrillic');
        if( ! $this->session->userdata('RequireTFALogin') ){
            redirect();
        }

    }

    public function test(){
        redirect('login_auth');
    }

    
    public function verifyTFAcodeManul($str) {
        if(preg_match(Cyrillic::onlyNunberAllow(), $str)) {
            if(Cyrillic::excetlenghtAllow($str,6))
            {
                return true;
            }else{
                $this->form_validation->set_message('verifyTFAcodeManul','Invalid code');
            return FALSE;
            }
        } else{
           $this->form_validation->set_message('verifyTFAcodeManul','Invalid code');
            return FALSE;
        }
    }   
    
    
    public function index(){

      
        $this->form_validation->set_rules('verification_code', 'Verification code', 'required|callback_verifyTFAcodeManul|verifyTFACode');
        if($this->form_validation->run() == true){
            $this->session->unset_userdata('RequireTFALogin');

            $data = json_decode($this->session->userdata('TFACredentials'), true);
            $this->load->view('tfa/tfa_login_verify_success', $data);

        }

        $css = $this->template->Css();
        $data['metadata_description'] = lang('cs_dsc');
        $data['metadata_keyword'] = lang('cs_kew');
        $this->template->title(lang('cs_tit'))
            ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."signin.min.css'>
                        <link rel='stylesheet' href='".$css."/authenticator.css'>
                ")
            ->append_metadata_js("

                ")
            ->set_layout('external/main')
            ->build('tfa/tfa_sign_verify_code',$data);
    }

    public function verify(){

        $this->form_validation->set_rules('verification_code', 'Verification code', 'required|callback_verifyTFAcodeManul|verifyTFACode');

            if($this->form_validation->run() == true){
                $this->session->unset_userdata('RequireTFALogin');

                $type = $this->session->userdata('AccountType'); // 0 - client ; 1 - partner
                $data['type'] = $type ? 'partner' : 'client';

                $data['credentials'] = json_decode($this->session->userdata('TFACredentials'), true);
                $this->load->view('tfa/tfa_login_verify_success', $data);

            }else{
                $this->session->set_flashdata('validation_errors', validation_errors());
                redirect(FXPP::my_url('two-step-authentication'));
            }


    }

}