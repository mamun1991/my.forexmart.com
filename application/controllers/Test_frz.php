<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_frz extends MY_Controller {
 

    public function __construct(){
        
        parent::__construct();
//        $this->load->model('account_model');
//        $this->lang->load('modal_message');
//        $this->lang->load('currenttrades');
//        $this->lang->load('historyoftrades');
//        $this->lang->load('datatable');  
        
        
         $this->load->library('ForexCopy'); 
        
        $serviceData = array('Login' => '58072429');
        $ForexCopy = new ForexCopy('forexcopy_staging');
         
        
           echo "<pre>"; 
           print_r($ForexCopy->gets());exit;
        $ForexCopy->GetAccountType($serviceData);
        $request_result = $ForexCopy->request_status;
     
        
    }


    public function index(){
         echo "<pre>"; print_r($_SESSION);exit;
//	echo  IPLoc::getCountryCode("127.0.0.1");
	 
		if($this->session->userdata('logged')){
echo "tsssssssssssssss";exit;
                $paymentData = $this->session->userdata('goToPayment');
                //if(IPLoc::Office()){
                    if($paymentData){
                        if($paymentData == 'card'){
                            redirect(FXPP::my_url('deposit'));
                        } else {
                            redirect(FXPP::my_url('deposit/'.$paymentData));
                        }

                    } 


                //}

                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'trading';
                $data['active_sub_tab'] = 'current-trades';
                $data['active_sub_sub_tab'] = 'current_trades';

                $data['metadata_description'] = lang('curtra_dsc');
                $data['metadata_keyword'] = lang('curtra_kew');
                $this->template->title("ForexMart | Current Trades")
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                base_url ='".base_url()."';
                          </script>
                       <script src='".$this->template->Js()."new_trades.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('test_frz',$data);
            }else{
                redirect('signout');
            }
		
    }
 
 
}




