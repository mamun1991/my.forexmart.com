<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 3/21/16
 * Time: 12:42 PM.
 */
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Cabinet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabinet_model');
    }

    public function index()
    {
        //unset session
        $_SESSION = [];
        $key = $this->input->get('key', true);
        $user_id = $this->input->get('ui', true);
        $strLogin = $this->input->get('uac', true);
        $type = $this->input->get('ut', true);

        if ($user = $this->cabinet_model->getKey($key, $user_id)) {
            if ($user_info = $this->cabinet_model->getUserInfoByAccount($strLogin, $type)) {
                if (IPLoc::IPOnlyForVenus()) {
                    $readOnly = false;
                } else {
                    $readOnly = true;
                }

                $this->session->set_userdata([
                'full_name' => $user_info->full_name,
                'user_id' => $user_id,
                'username' => $user_info->username,
                'email' => $user_info->email,
                'logged_in' => true,
                'logged' => 1,
                'status' => 1,
                'administration' => $user_info->administration,
                'login_type' => $user_info->login_type,
                'readOnly' => $readOnly,
                'account_number' => $strLogin,
                'country' => $user_info->country,
                'mt_account_set_id' => $user_info->mt_account_set_id,
                'accountstatus' => $user_info->accountstatus,
                'image' => $user_info->image,
                'is_manager' => true,
            ]);

                // if( $_SERVER['REMOTE_ADDR']=='49.12.5.139' ){
                $mwpUCI = $this->input->get('uci', true);
                $mwp = $this->input->get('mwp', true);
                if (isset($_SESSION['mwp_session_id'])) {
                    $this->session->unset('mwp_session_id');
                } else {
                    $this->session->set_userdata('mwp_session_id', $mwp);
                    $this->session->set_userdata('mwp_login_userId', $mwpUCI);
                }
                // }

                $mtUserDetails = FXPP::getMTUserDetails2($strLogin);

                // Archived account
                if (isset($mtUserDetails[0]->LogIn)) {
                    if ($mtUserDetails[0]->IsDeleted == 1) {
                        $_SESSION = [];
                        $this->session->set_flashdata('accountArchived', true);

                        redirect('client/signin');
                    }
                }

                redirect(FXPP::my_url('my-account'));
            } else {
                redirect('client/signin');
            }
        } else {
            redirect('client/signin');
        }
    }

    public function terms_condition()
    {
        redirect('https://www.forexmart.com/assets/pdf/Tradomart-SV/Terms%20and%20Conditions.pdf');
    }
}
