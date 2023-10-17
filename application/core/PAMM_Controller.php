<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class PAMM_Controller extends CI_Controller{
	
	function __construct(){
		parent::__construct();
        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office_and_Vpn_Trading()) {
            redirect('signout');
        }
	}

}
