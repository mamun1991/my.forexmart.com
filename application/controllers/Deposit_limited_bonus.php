<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deposit_limited_bonus extends CI_Controller {
    private $isPartner = false;
    private  $ipAddress="";
    public function __construct() {
        parent::__construct();
//        FXPP::preventPost(); // only for read only mode
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('user_model');
        $this->load->model('General_model');
        $this->g_m = $this->General_model;

        $isPartner = $this->session->userdata('login_type');
        if ($isPartner == 1) {
            $this->isPartner = true;
        }
        $this->ipAddress=$this->input->ip_address();
    }

    public function index() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($this->session->userdata('logged')) {
            
            
            if (!IPLoc::Office()) {
                FXPP::LoginTypeRestriction();
            }
            
                redirect('deposit');
             
           
            

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'deposit';
            $this->template->title(lang('dep_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("")
                ->build('deposits/Dposit_limited_bonus', $data);
        } else {
            redirect('signout');
        }
    }
}