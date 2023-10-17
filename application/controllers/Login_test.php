<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_test extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('FxboAPI','fxboapi');
        if(!IPLoc::Office()){
            redirect('');
        }
//        if (IPLoc::isEuropeanIP()) {
//            redirect('');
//        }
    }
    public function  index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');


        if ($this->form_validation->run()) {
            $email = $this->input->post("email", true);
            $password = $this->input->post("password", true);
            $c_data = array(
                "email"    => $email,
                "password" => $password,
            );
            $is_eu = true;
            if(is_numeric($email)){
              $is_eu = $this->isEUgroup($email);

            }

            if(!$is_eu){

                $l_result = $this->fxboapi->request_login_non_eu($c_data);
                if ($l_result->success == 1) {
                    redirect($l_result->url);
                }else{
                    $data['error'] = $l_result->error;
                }

            }else{
                $c_result = $this->fxboapi->check_credentials($c_data);
                if ($c_result->id) {
                    $login_data = array(
                        "user"   => $c_result->id,
                        "locale" => "en",
                    );
                    $l_result = $this->fxboapi->request_login($login_data);
                    if ($l_result) {
                        redirect($l_result->url);
                    }
                }else{
                    $data['error'] = "Wrong account or password. Please, try again. If the problem persists, contact us via support@forexmart.eu";
                }
            }
        }

        $this->load->view('signin_test',$data);

    }

    public function isEUgroup($account_number){
        $webservice_config = array('iLogin' => $account_number, 'server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->RequestAccountDetails($webservice_config);

        if ($WebService->request_status === "RET_OK") {

            $totalAccount = (array) $WebService->get_all_result();
            if (strpos($totalAccount['Group'], '-') !== false) {
                return false;
            } else {
                return true;
            }
        }
    }


}