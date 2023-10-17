<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Zeta-Jenalie
 * Date: 8/13/2018
 * Time: 8:51 PM
 */

class SVC extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SVC');

        $VPN_IP = array(
            '120.29.75.242'
        );

        if (!IPLOC::Office() && !in_array($this->input->ip_address(), $VPN_IP)) {
            show_404();
        }
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('user_model');
        $this->load->model('General_model');
        $this->load->model('Withdraw_model');
        $this->load->model('withdraw_model');
        $this->load->library('Transaction');
        $this->g_m = $this->General_model;
        $this->load->helper('cookie');
        $this->output->enable_profiler(TRUE);

    }

    public function index(){
            $SVC = new SVC();
            $auth = $SVC->Authorize(58050126,"sr6OEXq");
            echo "<pre>",print_r($auth, 1),"</pre>";


    }

}