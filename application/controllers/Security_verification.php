<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/2/16
 * Time: 8:54 AM
 */
class Security_verification extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('fx_mailer');
        $this->load->model('user_model');
        // $this->load->library('password_hash');

        if(!IPLoc::Office()){redirect('');}

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }

        $this->lang->load('myprofile');
    }


   public function index(){

       $user_id = $this->session->userdata('user_id');
       $conditon = array('user_id' => $user_id);
       if($data['auth'] = $this->general_model->whereCondition("authentication_step", $conditon)){
           $data['success'] = true;
           $this->template->title("ForexMart |Security verification")
               ->set_layout('internal/main')
               ->build('security_verification/security_view', $data);

       }else{

           redirect('security-verification/setting');
       }

   }

    public function setting()
    {
        $this->load->library('user_agent');
        $user_id = $this->session->userdata('user_id');


        $conditon = array('user_id' => $user_id);
        $data['auth'] = $this->general_model->whereCondition("authentication_step", $conditon);

        if(isset($_GET['flag'])){
            $array = array(
                'flag'=>$this->input->get('flag', true)
            );
            $this->general_model->updatemy('authentication_step', 'user_id', $user_id, $array);
        }


        if (isset($_POST['mobile'])) {
            $this->form_validation->set_rules('mobile', 'Phone number', 'trim|required|xss_clean');
        }
        if(isset($_POST['otp'])) {
            $this->form_validation->set_rules('otp', 'verification code', 'trim|required|xss_clean');
        }


        if ($this->form_validation->run()) {
            $mobile = $this->input->post('mobile', true);
            $otp = $this->input->post('otp', true);



            if (isset($_POST['otp'])) {

                if ($data['auth']['otp'] == $otp) {

                    $array = array(
                        'user_id' => $user_id,
                        'os' => $this->agent->platform(),
                        'browser' => $this->agent->agent_string(),
                        'auth' => '',
                        'status' => 0,
                        'flag'=>1  //  Confirm that it works using phone
                    );
                    $this->general_model->updatemy('authentication_step', 'user_id', $user_id, $array);
                    $data['success'] = "It worked!";
                    redirect(FXPP::my_url('security-verification'));

                } else {
                    $data['success'] = "Security code is wrong";
                }
            }

            if (isset($_POST['mobile'])) {

                $array = array(
                    'user_id' => $user_id,
                    'otp' => rand(10000, 99999),
                    'phone' => $mobile,
                    'os' => $this->agent->platform(),
                    'browser' => $this->agent->agent_string(),
                    'auth' => '',
                    'status' => 0,
                    'flag'=>1
                );

                if (!$data['auth']) {
                    $this->general_model->insert('authentication_step', $array);
                } else {
                    $this->general_model->updatemy('authentication_step', 'user_id', $user_id, $array);
                }
                redirect(FXPP::my_url('security-verification/setting'));

            }


        }

        $data['success'] = true;
        $this->template->title("ForexMart |Security verification")
            ->set_layout('internal/main')
            ->build('security_verification/security_set', $data);
    }

    public function resend()
    {
         $user_id = $this->session->userdata('user_id');
        $this->general_model->delete('authentication_step', 'user_id', $user_id);

        redirect(FXPP::my_url('security-verification/setting'));
    }
} 