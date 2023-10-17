<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_security extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fx_mailer');
        $this->load->model('user_model');
        $this->load->library('password_hash');
        $this->load->library('SMS');
    }



    public function index(){
        $user_id = $this->session->userdata('user_id');


        $this->form_validation->set_rules('security_code', 'Security code', 'trim|required|xss_clean');

        if($this->form_validation->run()){
            $security_code = $this->input->post('security_code',true);


            $conditon = array('id'=>$user_id,'sms_security'=>1);
            $sms_code = $this->general_model->whereCondition("users", $conditon,"sms_code,administration");

            if($security_code == $sms_code['sms_code']){
                $this->session->set_userdata(array(

                    'logged_in'	=> TRUE,
                    'logged' => 1,
                    'status'	=>  true ,
                    'administration'	=> $sms_code['administration']

                ));
                redirect('profile/edit');
            }else{
                $data['msg']="Security code is wrong";
            }


        }
        $data['success'] = true;
        $this->template->title("ForexMart | SMS Security")
            ->set_layout('external/main')
            ->build('sms_security_code',$data);
    }

    public function sendSms(){
        $user_id = $this->session->userdata('user_id');
        $conditon = array('id'=>$user_id,'sms_security'=>1);
        if($sms_code = $this->general_model->whereCondition("users", $conditon,"sms_code,administration")){

           $phone = $this->general_model->whereCondition("contacts", array('user_id'=>$user_id),"sms");
            $sms = new SMS();
            $sms->setTo($phone['sms']);
            $sms->setText("Your Security Code is ".$sms_code['sms_code']);
            $sms->sendSms();
            redirect('sms-security');
        }else{
            redirect('logout');
        }



    }
    public function sms(){


        $sms = new SMS();
        $sms->setTo("8801554764182");
        $sms->setText("Test+sms+for+fxpp");
         var_dump(  $sms->sendSms());
    }

    public function voice(){
        $sms = new SMS();
        $sms->setTo("8801554764182");
          return $sms->voice();
    }

    public function voice_answer(){

    }


}

