<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class svctest extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('SVC');
    }
    public function index(){
        if($_SERVER['REMOTE_ADDR']=='120.29.75.242'){

            $SVC = new WSV();
            $auth = $SVC->Authorize(58050126,"sr6OEXq");
            echo "<pre>",print_r($auth, 1),"</pre>";


        }

    }


}