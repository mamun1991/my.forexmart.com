<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phl extends MY_Controller {
	public function __construct(){
		parent::__construct();

	}
	public function Test2(){
        if(!IPLOC::Office_and_Vpn()){
            redirect('');
        }
		echo 'testpage';
		$this->load->library('Minibonus');
//		Minibonus::mark_for_non_ndb2();
//		Minibonus::testcond2(15);
		Minibonus::callcredit();
		echo FXPP::getServerTime();
	}
	public function Test(){
        if(!IPLOC::Office_and_Vpn()){
            redirect('');
        }
		$date = new DateTime(FXPP::getServerTime());
		$date_db_last_update = new DateTime('2014-10-05 13:40:13');
		$diff = $date->diff($date_db_last_update);

		if (intval((($diff->format('%y') * 12) + $diff->format('%m')))>=12){
			echo 'trigger 1 year';
		}else{
			echo 'not 1 year';
		}

	}
	public function index(){
        if(!IPLOC::Office_and_Vpn()){
            redirect('');
        }
		echo 'testpage';
		$this->load->library('Minibonus');
//		Minibonus::mark_for_non_ndb2();
//		Minibonus::testcond2(15);
		Minibonus::credit_accounts();
		echo FXPP::getServerTime();
	}

    public function index2(){
        if(!IPLOC::Office_and_Vpn()){
            redirect('');
        }
        echo CI_VERSION;
    }

    public function info(){
        if(!IPLOC::Office_and_Vpn()){
            redirect('');
        }
        phpinfo();

    }
}
