<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller{
	
	function __construct(){
		parent::__construct();
//        redirect('maintenance');


        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;


        /*if($_SERVER['SERVER_NAME'] === 'my.forexmart.com') {
            if(IPLoc::allowableCountry(IPLoc::euCountryArray())){
                redirect('http://personal.forexmart.eu');
            }
        }*/


        if( isset($_SESSION["user_id"]) ){
            $core_userid = $_SESSION['user_id'];
        }
        if( isset($_SESSION["account_number"]) ){
            $core_accountnumber = $_SESSION['account_number'];
        }

        if(IPLoc::Office_and_Vpn()){
            $test_account = array(
                strtolower('trowabarton00005@gmail.com'),
                strtolower('eskimo.callboy606@gmail.com'),
                strtolower('carinobrutal6666@gmail.com'),
                strtolower('mottakaquezo68@gmail.com'),
                strtolower('sm491159@gmail.com'),
                strtolower('js3493111@gmail.com'),
                strtolower('fxprog5@forexmart.com'),
                strtolower('firozur@zondertag.net'),
                strtolower('redcarpet404@gmail.com'),
                strtolower('f.7.live.co@gmail.com'),
                strtolower('invite.fxpp@gmail.com'),
                strtolower('inv.fxpp@gmail.com'),
                strtolower('bug.fxpp@gmail.com'),
                strtolower('smsapipp@gmail.com'),
                strtolower('fxtest025@gmail.com'),
                strtolower('fxtest026@gmail.com'),
                strtolower('fxtest027@gmail.com'),
                strtolower('uness1954@gmail.com'),
                strtolower('ohmygloness03@gmail.com'),
                strtolower('jayhens.snow@gmail.com'),
                strtolower('hanz.grimpz@gmail.com'),
                strtolower('tdum574@gmail.com'),
                strtolower('prog1username@gmail.com'),
                strtolower('prog2username@gmail.com'),
                strtolower('prog3username@gmail.com'),
                strtolower('prog4username@gmail.com'),
                strtolower('splprouser@gmail.com'),
                strtolower('prohibitndb@gmail.com'),
                strtolower('mickeymouseuser241@gmail.com'),
                strtolower('crosscircleuser1231@gmail.com'),
                strtolower('testgee@protonmail.com'),
                strtolower('testpartner@protonmail.com'),
                strtolower('mariaclove07@gmail.com')
            );

            if (in_array(strtolower($_SESSION['email']), $test_account)) {


                $is_testaccount= FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$core_userid,$select='test,test_1');
                if($is_testaccount){
                    if( !($is_testaccount['test']==1 and $is_testaccount['test_1']==0)){
                        $data['settestaccount'] = array(
                            'test' => 1,
                            'test_1' => 0
                        );
                        FXPP::CI()->g_m->updatemy($table = "users", "id", $core_userid,$data['settestaccount']);
                    }
                }
            }
        }




           // $data['lac_return']=FXPP::leverage_auto_change();

		//	FXPP::verify_duplicate_live_account();
		//	FXPP::verify_duplicate_partner_account();

        /* FXPP-6539 P01 - Allow accounts to be credited with NDB without the need for verification in FXPP */
//        if(IPLoc::Office_for_NDB()){
            /*if( isset($_SESSION["account_number"]) ){
                $check_client_trading_status= FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='account_number',$id= $core_accountnumber ,$select='open_trading');
                if($check_client_trading_status){
                    if($check_client_trading_status['open_trading']==0){
                        FXPP::activate_trading_API($core_userid,$core_accountnumber);
                    }
                }
            }*/
//        }
        /* FXPP-6539 P01 - Allow accounts to be credited with NDB without the need for verification in FXPP */

        if (isset($_SESSION['login_type'])){
            if ($_SESSION['login_type']==1){
              //  FXPP::CI()->load->library('Partnership_Library');
              //  Partnership_Library::recreate_cpa();
            }
        }


        /* START Method to update account with improperly updated group standard that is not in ndb START */
        if( false && isset($_SESSION["account_number"]) ){
            $checkndbtag= FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$core_userid ,$select='nodepositbonus');
            $mtas = FXPP::CI()->g_m->showssingle3($table='mt_accounts_set',$field='user_id',$id=$core_userid,$field2="registration_time >",$id2="2017-04-03 11:0:01",$select="",$order_by="fixed_group");
            if($checkndbtag){
                if($mtas){
                    if($mtas['fixed_group']==0){
                        if($checkndbtag['nodepositbonus']==1){
                            FXPP::requestdetailsNDB($core_userid);
                        }
                    }
                }
            }
        }
        /* END Method to update account with improperly updated group standard that is not in ndb END */
        if(IPLoc::Office_and_Vpn()){
            $test_account = array(
                strtolower('trowabarton00005@gmail.com'),
                strtolower('eskimo.callboy606@gmail.com'),
                strtolower('carinobrutal6666@gmail.com'),
                strtolower('mottakaquezo68@gmail.com'),
                strtolower('sm491159@gmail.com'),
                strtolower('js3493111@gmail.com'),
                strtolower('fxprog5@forexmart.com'),
                strtolower('firozur@zondertag.net'),
                strtolower('redcarpet404@gmail.com'),
                strtolower('f.7.live.co@gmail.com'),
                strtolower('invite.fxpp@gmail.com'),
                strtolower('inv.fxpp@gmail.com'),
                strtolower('bug.fxpp@gmail.com'),
                strtolower('smsapipp@gmail.com'),
                strtolower('fxtest025@gmail.com'),
                strtolower('fxtest026@gmail.com'),
                strtolower('fxtest027@gmail.com'),
                strtolower('uness1954@gmail.com'),
                strtolower('ohmygloness03@gmail.com'),
                strtolower('jayhens.snow@gmail.com'),
                strtolower('hanz.grimpz@gmail.com'),
                strtolower('tdum574@gmail.com'),
                strtolower('prog1username@gmail.com'),
                strtolower('prog2username@gmail.com'),
                strtolower('prog3username@gmail.com'),
                strtolower('prog4username@gmail.com'),
                strtolower('splprouser@gmail.com'),
                strtolower('prohibitndb@gmail.com'),
                strtolower('mickeymouseuser241@gmail.com'),
                strtolower('crosscircleuser1231@gmail.com')
            );

            if (in_array(strtolower($_SESSION['email']), $test_account)) {


                $is_testaccount= FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$core_userid,$select='test,test_1');
                if($is_testaccount){
                    if( !($is_testaccount['test']==1 and $is_testaccount['test_1']==0)){
                        $data['settestaccount'] = array(
                            'test' => 1,
                            'test_1' => 0
                        );
                        FXPP::CI()->g_m->updatemy($table = "users", "id", $core_userid,$data['settestaccount']);
                    }
                }
            }
        }




            if ($_SESSION['login_type']!= 1){
           //   FXPP::updateNonEUGroup(); //FXPP-9557
                  //  FXPP::updateAccountTradingStatus($core_accountnumber,$core_userid,0);

            }


//        if(IPLoc::Office()) {
//            FXPP::updateleverageAllAccounts(); //FXPP-8945
//        }

      
        // FXPP::isSubscribeToPartnerAccount($core_userid);

        // only access allowed IP
        if(!IPLoc::blacklistIPs()){

            show_404('accessing'); exit();
        }


        if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu') {
            if(IPLoc::Office() || IPLoc::allowableCountry(array('LV'))) {


            }else{
                show_404('accessing');
            }

        }

        if(isset($_COOKIE['enable_profiler'])){
            $this->output->enable_profiler(TRUE);
        }

        
        
	}

}
