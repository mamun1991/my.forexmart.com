<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deposit_indonesia extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }

    public function index() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($this->session->userdata('logged')) {

            $data['active_tab'] = 'finance';
            $data['active_sub_tab'] = 'deposit';

            $this->template->title(lang('dep_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("")
                ->build('deposits/deposit-indonesia', $data);
        } else {
            redirect('signout');
        }
    }


}