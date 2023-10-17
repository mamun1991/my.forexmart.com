<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller
{

    function __construct()
    {
        parent::__construct();


    }

    public function index(){
        $user_country = FXPP::getUserCountryCode();
        if(in_array($user_country, array('US', 'KP', 'MM', 'SD', 'SY'))){
            $data['unavailable'] = true;
        }else{
            $data['unavailable'] = false;
        }

        $this->template->title(" Maintenance | ForexMart ")
            ->set_layout('external/main')
            ->build('maintenance', $data);
    }
}