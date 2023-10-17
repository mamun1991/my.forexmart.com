<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bonus extends MY_Controller{

    private $isSupporter = false;

    private $bonusPercent =  array(
        'tpb'  => 0.30,
        'twpb' => 0.20,
        'fpb'  => 0.50,
    );
    private $bonusPercentByID =  array(
        '1'  => 0.30,
        '28' => 0.20,
        '10'  => 0.50,
    );


    public function __construct(){
        parent::__construct();
        $this->load->model('General_model');
        $this->load->model('user_model');
        $this->g_m=$this->General_model;
        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $this->lang->load('bonus');
        $this->lang->load('modal_message');
        $user_id = $this->session->userdata('user_id');
//        if (IPLoc::Office()) {
            if ($account = $this->g_m->whereConditionQuery( $user_id)) {
                $this->isSupporter  = FXPP::isSupporterAccounts($account['account_number']);
//            }
        }
    }

    public function index(){

            redirect(FXPP::loc_url('bonus/bonuses'));

    }

    public function bonuses(){
            if(FXPP::isAccountFromEUCountry()){
              redirect(FXPP::loc_url('my-account'));
            }
            if(!$this->session->userdata('logged')){
                redirect('signout');
            }
            $this->lang->load('bonus');
            FXPP::LoginTypeRestriction();

            if(FXPP::fmGroupType($_SESSION['account_number']) == 'ForexMart Pro'){
                redirect(FXPP::my_url('my-account'));
            }


            $this->load->helper('language');

                $user_id=$_SESSION['user_id'];
                $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob,zip",$order_by="");
                $_SESSION['dob']=$data['user_profiles']['dob'];
                $_SESSION['zip']=$data['user_profiles']['zip'];

                //jira FXPP-2147 separate validation of fullname and email separate query
                //check for account fullname
                // $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
                //     $table1 = 'users',$table2 = 'user_profiles',
                //     $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
                //     $field1 = 'user_profiles.dob', $id1 = trim($_SESSION['dob']),
                //     $field3 = 'users.ndb_bonus!=', $id3 = '',
                //     $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
                //     $join12 = 'users.id=user_profiles.user_id',
                //     $select = 'ndb_bonus,users.email,user_profiles.dob'
                // );

                //check for account email
                // $data['accountemail'] = $this->t_m->showEmail_v2(
                //     $table1 = 'users',$table2 = 'user_profiles',$table3='mt_accounts_set',
                //     $field1 = 'UCASE(users.email)', $id1 = $_SESSION['email'],
                //     $field3 = 'users.ndb_bonus!=', $id3 = '',
                //     $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
                //     $join12 = 'users.id=user_profiles.user_id',
                //     $join13 = 'users.id=mt_accounts_set.user_id',
                //     $select = 'ndb_bonus,users.email,account_number,nodepositbonus'
                // );
//        if(IPLoc::Office()){
//            print_r($data['accountemail']);
//        }


        $IsAcquiredFromOtherAccount = false;

                // if ( $data['accountfullname']) {
                //     foreach ( $data['accountfullname'] as $key1 => $value1) {
                //         if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '' ) {

                //         }else if(is_null($value1['ndb_bonus'])) {

                //         } else {

                //             $IsAcquiredFromOtherAccount = true;
                //             $acquireFrom = $data['accountfullname'];
                //             $data['data']['category_acquire'] = 'accountfullname';
                //         }
                //     }

                // }

                // if ($data['accountemail']) {
                //     foreach ( $data['accountemail'] as $key2 => $value2) {
                //         if ((!isset($value2['ndb_bonus'])) || trim($value2['ndb_bonus']) === '' ) {

                //         }else if(is_null($value2['ndb_bonus'])) {

                //         } else {
                //             $IsAcquiredFromOtherAccount = true;
                //             $acquireFrom = $data['accountemail'];
                //             $data['data']['category_acquire'] = 'accountemail';
                //         }

                //     }
                // }

                    $data['data']['isSupporter'] = $this->isSupporter;

                // jira FXPP-7752
                // $data['accountfullnameIP'] = $this->t_m->showt2w3j2sFullnameIP(
                //     $table1 = 'users',$table2 = 'user_profiles', $table3='mt_accounts_set',
                //     $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
                //     $field1 = 'mt_accounts_set.registration_ip', $id1 = $this->input->ip_address(),
                //     $field3 = 'users.ndb_bonus!=', $id3 = '',
                //     $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
                //     $join12 = 'users.id=user_profiles.user_id',
                //     $join31 = 'mt_accounts_set.user_id=users.id',
                //     $select = 'ndb_bonus,users.email,user_profiles.dob,mt_accounts_set.account_number'
                // );

                // if ($data['accountfullnameIP']) {
                //     foreach ( $data['accountfullnameIP'] as $key3 => $value3) {
                //         if ((!isset($value3['ndb_bonus'])) || trim($value3['ndb_bonus']) === '' ) {

                //         }else if(is_null($value3['ndb_bonus'])) {

                //         } else {
                //             $IsAcquiredFromOtherAccount = true;
                //             $acquireFrom = $data['accountfullnameIP'];
                //             $data['data']['category_acquire'] = 'accountfullnameIP';
                //         }

                //     }
                // }

                // jira FXPP-7752

                $data['contacts'] = $this->g_m->showssingle( $table='contacts',$field="user_id",$id=$user_id,$select="phone1",$order_by="");
                $_SESSION['phone1'] = $data['contacts']['phone1'];
                //jira FXPP-7752
//            $data['accountAdditionalInfo'] = $this->t_m->accountAdditionalInfo(
//                $table1 = 'users',$table2 = 'user_profiles', $table3='contacts',
//                $field1 = 'phone1', $id1 =   $_SESSION['phone1'],
//                $field2 = 'dob', $id2 = $_SESSION['dob'],
//                $field3 = 'zip', $id3 = $_SESSION['zip'],
//                $field4 = 'users.ndb_bonus!=', $id4 = '',
//                $field5 = 'users.id !=', $id5=$_SESSION['user_id'],
//                $join12 = 'user_profiles.user_id=users.id',
//                $join31 = 'contacts.user_id=users.id',
//                $select = 'ndb_bonus,users.email,user_profiles.dob'
//            );
//            if ($data['accountAdditionalInfo']) {
//                foreach ( $data['accountAdditionalInfo'] as $key4 => $value4) {
//
//                    if ((!isset($value4['ndb_bonus'])) || trim($value4['ndb_bonus']) === '' ) {
//
//                    }else if(is_null($value4['ndb_bonus'])) {
//
//                    } else {
//                        $IsAcquiredFromOtherAccount = true;
//                    }
//
//                }
//            }
//        }
        $data['data']['IsAcquiredFromOtherAccount'] = false; // $IsAcquiredFromOtherAccount;
        $data['data']['acquireFrom'] = false; //$acquireFrom;



//                $data['data']['IsAcquiredFromOtherAccount'] = false;

                $nodepositbonus = $this->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='ndba_acquired,nodepositbonus,created,createdforadvertising,accountstatus,is_bonuscontestmfprize,is_showfxbonus');
                $account_details = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='mt_account_set_id');

                // FXPP-4261
                $data['data']['IsVerified'] = false;
                $data['data']['valid_for_nodepositbonus'] = false;

                if ($nodepositbonus['accountstatus'] == 1 and $nodepositbonus['nodepositbonus'] == 0) {
                    $data['data']['IsVerified'] = true;
                }

                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
                $account_info = array('iLogin' => $_SESSION['account_number']);
//                $WebService->open_RequestAccountDetails($account_info);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

                if ($WebService->request_status === 'RET_OK') {
                    $ForMarStaAcc = FXPP::get_standardgroup_for_ndb($_SESSION['account_number']);
//                    $ForMarStaAcc = FXPP::get_standardgroup();
                    if ($ForMarStaAcc){
                        $data['IsStandardAccount'] = true;
                    } else {
                        $data['IsStandardAccount'] = false;
                    }
                }else{
                    $data['IsStandardAccount'] = false;
                }


                //FXPP-1674 Implement logic of removing the NDB tab if the client has already made his first deposit in FXPP
                $deposit = $this->g_m->showssingle3($table='deposit',$field="user_id",$id=$_SESSION['user_id'],$field2="status",$id2=2,$select="*",$order_by="");
                if(IPLoc::IPCrpAccVerify()){
                  // echo $this->db->last_query();
                }
                //FXPP-1674

                //FXPP-3520
                $no_deposit = $this->g_m->showssingle2($table='no_deposit',$field='user_id',$id=$_SESSION['user_id'],$select='*');
                if($no_deposit){
                    $data['data']['has_rqstd_ndb'] = true;
                }else{
                    $data['data']['has_rqstd_ndb'] = false;
                }

                $this->load->library('Bonus_Library');
                $FXPP6539 = Bonus_Library::getScoring();

                $mt_account_set = $this->g_m->showt1w1($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'mt_currency_base');

                $data['data']['isUSDorEUR']=false;

                $data['data']['users_currency'] = $mt_account_set['mt_currency_base'];
                $ccy= array("USD", "EUR");
                if (in_array($mt_account_set['mt_currency_base'], $ccy)) {
                    $data['data']['isUSDorEUR']=true;
                }
                if(strtoupper(FXPP::getUserContinentCode()) == 'EU'){
                    $default_currency = 'EUR';

                    $data['data']['bonus_negligible_view'] = FXPP::get_convert_amount($from_currency='USD', $FXPP6539['bonus'], $to_currency = 'EUR');

                    $data['data']['bonus_negligible_view'] = str_replace(',', '', $data['data']['bonus_negligible_view']);

                    if ($mt_account_set['mt_currency_base'] == 'USD'){
                        $data['data']['bonus'] = $FXPP6539['bonus'];

                    }else{
                        $data['data']['bonus']=FXPP::get_convert_amount($from_currency='USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                        $data['data']['bonus'] = str_replace(',', '',  $data['data']['bonus']);

                    }

                }else{
                    $default_currency = 'USD';

                    $data['data']['bonus_negligible_view'] = $FXPP6539['bonus'];

                    if ($mt_account_set['mt_currency_base']=='USD'){
                        $data['data']['bonus']=$FXPP6539['bonus'];
                    }else{
                        $data['data']['bonus']=FXPP::get_convert_amount($from_currency='USD', $FXPP6539['bonus'], $to_currency = $mt_account_set['mt_currency_base']);
                        $data['data']['bonus'] = str_replace(',', '',  $data['data']['bonus']);

                    }
                }

                $user_id = $this->session->userdata('user_id');

                $data['data']['check'] =$this->load->ext_view('modal', 'check', $data['data'], TRUE);
                $data['data']['modal_bonus_thirty_percent'] =$this->load->ext_view('modal', 'bonus_thirty_percent', $data['data'], TRUE);
                $data['data']['modal_bonus_fifty_percent'] =$this->load->ext_view('modal', 'bonus_fifty_percent', $data['data'], TRUE);
                $data['data']['modal_bonus_twenty_percent'] =$this->load->ext_view('modal', 'bonus_twenty_percent', $data['data'], TRUE);
                $data['data']['modal_bonus_alert'] =$this->load->ext_view('modal', 'bonus_alert', $data['data'], TRUE);
                $data['data']['modal_bonus_no_deposit_alert'] =$this->load->ext_view('modal', 'bonus_no_deposit_alert', $data['data'], TRUE);
                $data['data']['modal_bonus_twenty_percent_alert'] =$this->load->ext_view('modal', 'bonus_twenty_percent_alert', $data['data'], TRUE);
                $data['data']['modal_bonus_thirty_percent_alert'] =$this->load->ext_view('modal', 'bonus_thirty_percent_alert', $data['data'], TRUE);
                $data['data']['modal_bonus_fifty_percent_alert'] =$this->load->ext_view('modal', 'bonus_fifty_percent_alert', $data['data'], TRUE);
                $data['data']['modal_bonus_claim_alert'] =$this->load->ext_view('modal', 'bonus_claim_alert', $data['data'], TRUE);


                if(is_null($nodepositbonus['createdforadvertising'])){
                    $data['datecreated']=$nodepositbonus['created'];
                }else{
                    $data['datecreated']=$nodepositbonus['createdforadvertising'];
                }
                $datecreated=DateTime::createFromFormat('Y-m-d H:i:s',$data['datecreated']);
                $datedifference=$this->g_m->difference_day($datecreated->format('Y-m-d'),$datecurrent=date('Y-m-d'));

                $this->load->model('deposit_model');
                $has_no_deposit_request = $this->deposit_model->hasNoDepositRequest($user_id);

                $data['data']['test']= "-------nodepositbonus : "
                    .$nodepositbonus['nodepositbonus']."-------datedifference : "
                    .$datedifference."-------account_details : "
                    .$account_details['mt_account_set_id']."------deposit : "
                    .$deposit."------has_no_deposit_request : "
                    .$has_no_deposit_request."------IsAcquiredFromOtherAccount : "
                    .$IsAcquiredFromOtherAccount."------user_id : "
                    .$user_id."------id : "
                    .$id=$_SESSION['user_id'];

                $data['data']['expireNoDeposit_msg'] = '';
                if ($nodepositbonus['nodepositbonus']==1 OR $datedifference > 7 OR $account_details['mt_account_set_id'] != 1 OR $deposit!=false){
                    $data['data']['expireNoDeposit']=true;
                    if(IPLoc::Office()){
                        $data['data']['expireNoDeposit_msg'] = $nodepositbonus['nodepositbonus'] == 1 ? lang('ndb_pup5') : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $datedifference > 7 ? lang('ndb_pup6') : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $account_details['mt_account_set_id'] != 1 ? lang('ndb_pup7') : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $deposit != false ? lang('ndb_pup8') : $data['data']['expireNoDeposit_msg'];
                    } else {
                        $data['data']['expireNoDeposit_msg'] = $nodepositbonus['nodepositbonus'] == 1 ? "No Deposit Bonus has been claimed." : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $datedifference > 7 ? "Account has exceeded 7 days of No Deposit Bonus" : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $account_details['mt_account_set_id'] != 1 ? "Account Type is not allowed to claim No Deposit Bonus" : $data['data']['expireNoDeposit_msg'];
                        $data['data']['expireNoDeposit_msg'] = $deposit != false ? "Account has Deposit transaction/s." : $data['data']['expireNoDeposit_msg'];
                    }
                }else{
                    $data['data']['expireNoDeposit']=false;
                }
                $data['data']['NDB_has_been_claimed']= $nodepositbonus['nodepositbonus']==1?true:false;
                $data['data']['NDB_has_been_claimed_date']= $nodepositbonus['ndba_acquired'];

                $data['data']['datedifference'] = $datedifference;

                $this->load->model('account_model');
                $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($user_id);
                $account_number = $accountsByUserIdRow['account_number'];


                $allowedBonuses = FXPP::allowedBonuses($account_number);
//                $data['data']['displayBonusStatistics'] = $allowedBonuses;
                if($allowedBonuses == 28){
                    if(IPLoc::Office()){
                        $data['data']['displayBonusStatistics'] = true;
                    }
                }else{
                    $data['data']['displayBonusStatistics'] = $allowedBonuses;
                }



                if (
                    ($nodepositbonus['nodepositbonus'] == 0 or  $nodepositbonus['nodepositbonus']==Null) &&
                    ($data['data']['has_rqstd_ndb']==false ) &&
                    ($data['IsStandardAccount']==true) &&
                    ($datedifference <= 7) &&
                    ($account_details['mt_account_set_id'] == 1) &&
                    ($deposit==false)  &&
                    ($data['IsAcquiredFromOtherAccount'] == false or $data['IsAcquiredFromOtherAccount'] == Null)&&
                    ($nodepositbonus['is_bonuscontestmfprize']==0)
                )
                {
                    $data['data']['valid_for_nodepositbonus'] = true;
                }else{
                    $data['data']['valid_for_nodepositbonus'] = false;

                    if($nodepositbonus['nodepositbonus'] != 0 or  $nodepositbonus['nodepositbonus']!=Null){ $err_notvalid = 'nodepositbonus claimed. not_valid';}
                    if($data['data']['has_rqstd_ndb']==true ){ $err_notvalid = 'has_rqstd_ndb.not_valid';}
                    if($data['IsStandardAccount']==false){ $err_notvalid = 'IsStandardAccount - not .not_valid';}
                    if($datedifference > 7){ $err_notvalid = 'datedifference .not_valid';}
                    if($account_details['mt_account_set_id'] != 1){ $err_notvalid = 'mt_account_set_id .not_valid';}
                    if($deposit==true){ $err_notvalid = 'has deposit.not_valid';}
                    if($data['IsAcquiredFromOtherAccount'] == true or $data['IsAcquiredFromOtherAccount'] != Null){ $err_notvalid = 'IsAcquiredFromOtherAccount .not_valid';}
                    $data['data']['valid_for_nodepositbonus_error'] = $err_notvalid;

                }

/*if(IPLoc::Office()){
    var_dump($nodepositbonus['nodepositbonus']);
    echo "<br>";
    var_dump($data['data']['has_rqstd_ndb']);
    echo "<br>";
    var_dump($data['IsStandardAccount']);
    echo "<br>";
    var_dump($datedifference);
    echo "<br>";
    var_dump($account_details['mt_account_set_id']);
    echo "<br>";
    var_dump($deposit);
    echo "<br>";
    var_dump($data['IsAcquiredFromOtherAccount']);
    echo "<br>";
}*/

//            if(IPLoc::Office()){
//                $conditions= array(
//                    'has_nodepositbonus'=>$nodepositbonus['has_nodepositbonus'],
//                    'has_rqstd_ndb'=>$data['data']['has_rqstd_ndb'],
//                    'IsStandardAccount'=>$data['IsStandardAccount'],
//                    'date_diff'=>$datedifference,
//                    'mt_account_set_id'=>$account_details['mt_account_set_id'],
//                    'hasdeposit'=>$deposit,
//                    'valid_for_nodepositbonus'=>$data['data']['valid_for_nodepositbonus'],
//                    'IsAcquiredFromOtherAccount'=>$IsAcquiredFromOtherAccount
//                );
//                var_dump($conditions);
//            }

        $data['data']['prohibit']=false;
        /*FXPP-7759 Get special referral affiliate code that restrict user accounts*/
        $aff_code = $this->t_m->getspecialaffiliatecode();
        if($aff_code){
            $affiliate_array=array();
            foreach($aff_code as $aff_key => $aff_value){
                array_push($affiliate_array,$aff_value['affiliate_code']);
            }
            $user_ref_code = $this->t_m->getreferralcode($_SESSION['user_id']);
            if($user_ref_code){
                if (in_array($user_ref_code[0]['referral_affiliate_code'], $affiliate_array)) {
                    $data['data']['prohibit']=true;
                }else{
                    $data['data']['prohibit']=false;
                }
            }

        }
        /* FXPP-7759 Get special referral affiliate code that restrict user accounts*/

        $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
        $this->session->set_userdata(array('image' => $image));


        if(IPLoc::Office()){
          //  $data['data']['accountemail'] = $data['accountemail'];
          //  $data['data']['accountfullname'] = $data['accountfullname'];
           // $data['data']['accountAdditionalInfo'] = $data['accountAdditionalInfo'];
//            if($this->session->userdata('user_id')==189899){
//                $data['data']['expireNoDeposit'] = false;
//            }
        }
            $data['data']['default_currency'] = $default_currency;
            $data['data']['nodeposit']=$nodepositbonus['nodepositbonus'];
            $data['data']['active_tab'] = 'bonus';
            $data['data']['active_sub_tab'] = 'bonuses';
            $css = $this->template->Css();
            $js = $this->template->Js();
            $data['metadata_description'] = lang('bon_dsc');
            $data['metadata_keyword'] = lang('bon_kew');

            $data['data']['title_page'] = lang('sb_li_3');

            $this->template->title(lang('bon_tit'))
                ->append_metadata_js("
                        <script src='".$js."jquery.validate.js'></script>
                        <script type='text/javascript'>
                            $(document).ready(function(){
                                $('#atab-sub1').click(function(){
                                    $('#atab-sub2').removeClass('cur-active');
                                    $('#atab-sub1').addClass('cur-active');
                                });
                                $('#atab-sub2').click(function(){
                                    $('#atab-sub1').removeClass('cur-active');
                                    $('#atab-sub2').addClass('cur-active');
                                });
                            });
                        </script>
                 ")
                ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."/additional-internalStyle.css'>
                        <link rel='stylesheet' href='".$css."/hover.css'>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('bonus/bonuses',  $data['data']);

    }

    public function getAccountSummaryDetails($account_number){
        if($this->session->userdata('logged')) {

            FXPP::LoginTypeRestriction();

            $defaultData = array(
                'Balance' => 0,
                'Equity' => 0,
                'FreeMargin' => 0,
                'Withdrawable_RealFund' => 0,
                'Withdrawable_BonusSafe' => 0,
                'Total_Bonus' => 0
            );

            //get balance, equity and free margin
            $webservice_config = array(
                'server' => 'live_new'
            );
            $account_info = array(
                'iLogin' => $account_number
            );
            $WebServiceBalance = new WebService($webservice_config);
            $WebServiceBalance->open_RequestAccountBalance($account_info);
            $serviceResultBalance = $WebServiceBalance->get_all_result();

            $balance = $serviceResultBalance['Balance'];

            if($serviceResultBalance['ReqResult'] != 'RET_OK'){
                return $defaultData;
            }

            if($balance < 0 ){
                return $defaultData;
            }

            //withdrawable without bonus
//            $WebServiceRequestFunds = new WebService($webservice_config);
//            $WebServiceRequestFunds->RequestAccountFunds($account_number);
//            $getWithdrawableRealFund = $WebServiceRequestFunds->get_result('Withrawable_RealFund');


          
            $fundsData = FXPP::getAccountFunds($account_number);


            $getWithdrawableRealFund = $fundsData['withrawableRealFund'];

               
           

            $defaultData['Withdrawable_RealFund'] =  $getWithdrawableRealFund;

            //get withdrawable bonus with bonus safe - total balance - x - (x/.30)
            $totalBonusandChart = self::getTotalBonus($account_number);
            $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);
            $totalThirtyPercentBonus =  $getAccountBonusByType[1];

            $totalBonus = $totalThirtyPercentBonus;
            $bonusChart = $totalBonusandChart['bonusData'];
            $newBalance = $getWithdrawableRealFund + $totalBonus;

            $wdBonusSafe = $newBalance - $totalBonus - ($totalBonus / .30);
            $defaultData['Total_Bonus'] = $totalBonus;

            $defaultData['Withdrawable_BonusSafe'] = number_format($wdBonusSafe, 2);

            $defaultData['Balance'] = $newBalance;
            $defaultData['Equity'] = $newBalance;
            $defaultData['FreeMargin'] = $newBalance;
            $defaultData['bonusChart'] = $bonusChart;

            return $defaultData;
        }
    }

    public function getAccountSummaryDetailsTest($account_number){


            FXPP::LoginTypeRestriction();

            $defaultData = array(
                'Balance' => 0,
                'Equity' => 0,
                'FreeMargin' => 0,
                'Withdrawable_RealFund' => 0,
                'Withdrawable_BonusSafe' => 0,
                'Total_Bonus' => 0
            );

            
            $fundsData = FXPP::getAccountFunds($account_number);


            $balance = $fundsData['balance'];

            if($fundsData['status'] != 'RET_OK'){
                return $defaultData;
            }

            if($balance < 0 ){
                return $defaultData;
            }

    
            $getWithdrawableRealFund  = $fundsData['withrawableRealFund'];
            $newMargin      = $fundsData['margin'];
            $newEquity      = $fundsData['equity'];
            $newRealBalance = $fundsData['balance'];
          
         

            //get withdrawable bonus with bonus safe - total balance - x - (x/.30)
            //if(IPLoc::IPOnlyForVenus()){
                
                $totalBonusandChart = $this->getTotalBonus_v2($account_number);
         
            /*}else{
                $totalBonusandChart = $this->getTotalBonusTest($account_number);
         
            }*/
           $getAccountBonusByType = FXPP::getAccountBonusByType($account_number);

             $totalbonus =  $getAccountBonusByType[1];
             $percent = .30;
             $bonusName = "30 percent";

            if (is_null($getAccountBonusByType[1])) {
                $totalbonus =  $getAccountBonusByType[10];
                $percent = .50;
                $bonusName = "50 percent";

            }
            if (is_null($getAccountBonusByType[10])) {
                $totalbonus =  $getAccountBonusByType[28];
                $percent = .20;
                $bonusName = "20 percent";

            }


            $totalBonus = $totalbonus;
            $bonusChart = $totalBonusandChart['bonusData'];
            $newBalance = $getWithdrawableRealFund + $totalBonus;

            $wdBonusSafe = $newBalance - $totalBonus - ($totalBonus / $percent);
            $defaultData['Total_Bonus'] = $totalBonus;

            $defaultData['Withdrawable_BonusSafe'] = ($wdBonusSafe < 0 ) ? 0 : number_format($wdBonusSafe, 2);


          
            $defaultData['Withdrawable_RealFund'] =  $getWithdrawableRealFund;
            $defaultData['Balance'] = $newBalance;
            $defaultData['bonusFund'] = $fundsData['bonusFund'];
            $defaultData['Equity'] = $newEquity;
            $defaultData['FreeMargin'] = $newMargin;
            $defaultData['Acct_Balance'] = $newRealBalance;
            $defaultData['bonusChart'] = $bonusChart;
            $defaultData['BonusName'] = $bonusName;

        return $defaultData;
        
    }

    public function getTotalBonus_v2($account_number){

        $amount = 0;

        $dateFrom = 0;

        //$dateFrom = strtotime(date('Y-m-d 00:00:00', strtotime('-1 months')));
        $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));
        $params = array(
            'Accounts' => [$account_number],
            'From' => $dateFrom,
            'To' => $dateTo,
            'Limit' => 1000,
            'Offset' => 0,
        );

        $this->load->library('FXAPI');
        $ret = FXAPI::GetMyBonuses($params);

        $requestStatus = $ret['RET']; //status

        if($requestStatus === 'RET_OK'){
            $financeRecordEncode = json_encode($ret['data']->Transactions);
            $financeRecord = json_decode($financeRecordEncode, true);
           // array_multisort(array_column($financeRecord['FinanceOpData'], 'ProcessTime'), SORT_DESC, $financeRecord['FinanceOpData']); // sort multiple arrays from largest to smallest amount

            $operations = array_column($financeRecord['FinanceOpData'], 'OperationTypeId');
 
          
            foreach($operations as $key => $o){
                if($financeRecord['FinanceOpData'][$key]['Amount'] > 0){


                if($o === 'BONUS_30_PERCENT'){

                    $getAmount = $financeRecord['FinanceOpData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceOpData'][$key]['ProcessTime']  * 1000;
                   // $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$dateStamp, $amount]";
                }elseif ($o === 'BONUS_20_PERCENT') {

                    $getAmount = $financeRecord['FinanceOpData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceOpData'][$key]['ProcessTime'] * 1000;
                    //$datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$dateStamp, $amount]";
                }elseif ($o === 'BONUS_50_PERCENT') {

                    $getAmount = $financeRecord['FinanceOpData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceOpData'][$key]['ProcessTime']  * 1000;
                   // $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$dateStamp, $amount]";
                }


               }
           }

        }else{
            $bonusData[] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
        }

        $defaultData = array(
            'amount' => number_format($amount, 2),
            'bonusData' => $bonusData,
        );

     

        //var_dump($defaultData);exit();
        return $defaultData;


    }

    public function getTotalBonus($account_number){

        $amount = 0;

        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
        $account_info = array(
            'account_number' => $account_number,
            'from' => $from->format('Y-m-d\TH:i:s'),
            'to' => $to->format('Y-m-d\TH:i:s'),
            'limit' => 1000000,
            'offset' => 0,
            'type' => 1,
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountFinanceRecordsByTypeWithLimitOffset($account_info);
// GetAccountTotalTradedVolume_After_Bonus
        $requestResult = $WebService->get_result('ReqResult');

        if($requestResult === 'RET_OK'){
            $financeRecordEncode = json_encode($WebService->get_result('FinanceRecords'));
            $financeRecord = json_decode($financeRecordEncode, true);

            $operations = array_column($financeRecord['FinanceRecordData'], 'Operation');

            foreach($operations as $key => $o){


                if($o === 'BONUS_30PERCENT'){

                    $getAmount = $financeRecord['FinanceRecordData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceRecordData'][$key]['Stamp'];
                    $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$datetime, $amount]";
                }


            }
        }else{
            $bonusData[] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
        }

        $defaultData = array(
            'amount' => number_format($amount, 2),
            'bonusData' => $bonusData,
        );

        return $defaultData;

    }

      public function getTotalBonusTest($account_number){

        $amount = 0;

        $from = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
        $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
        $account_info = array(
            'account_number' => $account_number,
            'from' => $from->format('Y-m-d\TH:i:s'),
            'to' => $to->format('Y-m-d\TH:i:s'),
            'limit' => 1000000,
            'offset' => 0,
            'type' => 1,
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountFinanceRecordsByTypeWithLimitOffset($account_info);
       // GetAccountTotalTradedVolume_After_Bonus
        $requestResult = $WebService->get_result('ReqResult');

        if($requestResult === 'RET_OK'){
            $financeRecordEncode = json_encode($WebService->get_result('FinanceRecords'));
            $financeRecord = json_decode($financeRecordEncode, true);

            $operations = array_column($financeRecord['FinanceRecordData'], 'Operation');

            foreach($operations as $key => $o){


                if($o === 'BONUS_30PERCENT'){

                    $getAmount = $financeRecord['FinanceRecordData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceRecordData'][$key]['Stamp'];
                    $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$datetime, $amount]";

                }elseif ($o === 'BONUS_50PERCENT') {

                    $getAmount = $financeRecord['FinanceRecordData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceRecordData'][$key]['Stamp'];
                    $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$datetime, $amount]";
                }elseif ($o === 'BONUS_20PERCENT') {

                    $getAmount = $financeRecord['FinanceRecordData'][$key]['Amount'];
                    $amount = $amount + $getAmount;

                    $dateStamp = $financeRecord['FinanceRecordData'][$key]['Stamp'];
                    $datetime = strtotime($dateStamp) * 1000;

                    $bonusData[] = "[$datetime, $amount]";
                }


            }
        }else{
            $bonusData[] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
        }

        $defaultData = array(
            'amount' => number_format($amount, 2),
            'bonusData' => $bonusData,
        );

        return $defaultData;

    }

    public function getLotsTrade($account_number){
        $totalVolume = 0;
        $account_info = array(
            'iLogin' => $account_number
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountTotalTradedVolumeAfter30PercentBonus($account_info);
        $requestResult = $WebService->get_result('ReqResult');

        if($requestResult != 'RET_OK'){
            return number_format($totalVolume, 2);
        }

        $totalVolume = $WebService->get_result('TotalVolume');
        return number_format($totalVolume, 2);
    }

   public function getLotsTrade2($account_number, $iBonusType){
        $totalVolume = 0;
        $account_info = array(
            'iLogin' => $account_number,
            'iBonusType' => $iBonusType 
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);

        $WebService->GetAccountTotalTradedVolumeAfterBonus($account_info);
        $requestResult = $WebService->get_result('ReqResult');
  

        if($requestResult != 'RET_OK'){
            return number_format($totalVolume, 2);
        }

        $totalVolume = $WebService->get_result('TotalVolume');
        return number_format($totalVolume, 2);
    }


    public static function getBonusId($account_number){
        $account_info = array(
            'iLogin' => $account_number
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountBonusBreakdown($account_info);
        return $WebService->get_all_result()->BonusBreakdownList->BonusData[0]->BonusId;

    }

// old
    public function bonuses_statistic2(){
        $this->lang->load('bonus');
        if($this->session->userdata('logged')) {

            FXPP::LoginTypeRestriction();

            $userId = $this->session->userdata('user_id');

            $this->load->model('account_model');
            $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);

            $account_number = $accountsByUserIdRow['account_number'];

            $this->load->library('IPLoc', null);
            if(IPLoc::Office()){
                $getAccountSummaryDetails= self::getAccountSummaryDetailstest($account_number);
            }else{
                $getAccountSummaryDetails = self::getAccountSummaryDetails($account_number);

            }
            $getBonusId = self::getBonusId($account_number);
            $data['accountSummaryDetails'] = $getAccountSummaryDetails;

   
                $getLotsTrade = self::getLotsTrade($account_number);
                $data['lotsTradeData'] = $getLotsTrade;
            

            $this->load->model('deposit_model');
            $getAllClaimed30percentBonus = $this->deposit_model->getAllClaimed30percentBonus($userId);
            $data['TotalDepositClaimedBonus'] = $getAllClaimed30percentBonus['sum'];

            $data['currency'] = $accountsByUserIdRow['mt_currency_base'];

            $necessaryNumberofLots = $getAccountSummaryDetails['Total_Bonus'] * 0.30;
            $data['necessaryNumberofLots'] = number_format($necessaryNumberofLots, 2);

            $lotstoTrade = $necessaryNumberofLots - $getLotsTrade;

            if($lotstoTrade < 0){
                $lotstoTrade = 0;
            }

            if($lotstoTrade > 0){
                $bonus_status = lang('bon_aval_2');
            }else{
                $bonus_status = lang('bon_aval_1');
            }

            $data['lotstoTradeData'] = number_format($lotstoTrade, 2);
            $data['bonus_status'] = $bonus_status;

            $allowedBonuses = FXPP::allowedBonuses($account_number);
            $data['displayBonusStatistics'] = $allowedBonuses;

            $data['account_number'] = $account_number;
            $data['title_page'] = lang('sb_li_3');
            $data['active_tab'] = 'bonus';
            $data['active_sub_tab'] = 'bonuses_statistic';
            $js = $this->template->Js();
            $data['metadata_description'] = lang('bon_sta_dsc');
            $data['metadata_keyword'] = lang('bon_sta_kew');
            $this->template->title(lang('bon_sta_tit'))
                ->append_metadata_js("
                     <script src='".$js."bootbox.min.js'></script>
                    ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('bonus/bonuses_statistics2', $data);
        }else{
            redirect('signout');
        }
    }
    
            
    
    
// new 
    public function bonuses_statistic(){
        $this->lang->load('bonus');
        if($this->session->userdata('logged')) {
            $this->load->model('account_model');
            
            

            FXPP::LoginTypeRestriction();
            
           
            $userId = $this->session->userdata('user_id');
            $currency = $this->session->userdata('currency');
            $account_number = $this->session->userdata('account_number');
            $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);

            
            
            FXPP::allowedBonuses($account_number);
            $getAccountSummaryDetails = self::getAccountSummaryDetailstest($account_number);
            
            
            
            
            $getBonusId = self::getBonusId($account_number);
            $data['accountSummaryDetails'] = $getAccountSummaryDetails;
if($_SERVER["REMOTE_ADDR"]=='159.69.88.248'){
	//$this->load->controller('Withdraw');
	//echo '<pre>'; print_r($data['accountSummaryDetails']); 
}
            $getLotsTrade = self::getLotsTrade2($account_number,$getBonusId);
            $data['lotsTradeData'] = $getLotsTrade;
            $data['currency'] = $currency;
            $this->load->model('deposit_model');


            $bonusPercent = $this->bonusPercentByID[$getBonusId];

            $data['TotalDepositClaimedBonus'] = $getAccountSummaryDetails['Total_Bonus'] ;
            $necessaryNumberofLots =   $getAccountSummaryDetails['Total_Bonus'] * $bonusPercent;
            $data['necessaryNumberofLots'] = number_format($necessaryNumberofLots, 2);


           


            $lotstoTrade = $necessaryNumberofLots - $getLotsTrade;

            if($lotstoTrade < 0){
                $lotstoTrade = 0;
            }

            if($lotstoTrade > 0){
                $bonus_status = lang('bon_aval_2');
            }else{
                $bonus_status = lang('bon_aval_1');
            }

            $data['lotstoTradeData'] = number_format($lotstoTrade, 2);
            $data['bonus_status'] = $bonus_status;


            $data['account_number'] = $account_number;
            $data['title_page'] = lang('sb_li_3');
            $data['active_tab'] = 'bonus';
            $data['active_sub_tab'] = 'bonuses_statistic';
            $js = $this->template->Js();
            $data['metadata_description'] = lang('bon_sta_dsc');
            $data['metadata_keyword'] = lang('bon_sta_kew');
            $this->template->title(lang('bon_sta_tit'))
                ->append_metadata_js("
                     <script src='".$js."bootbox.min.js'></script>
                    ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('bonus/bonuses_statistics3', $data);
            
            
            
        }else{
            redirect('signout');
        }
    }

	
    public function bonuses_statistic_byDate(){
        $dateFrom = $this->input->post('from');
        $dateTo = $this->input->post('to');

       $dateFrom = strtotime(date('Y-m-d 00:00:00', strtotime( $dateFrom)));
       $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime( $dateTo)));
        $params = array(
            
            'From' => $dateFrom,
            'To' => $dateTo,
            'Limit' => 1000,
            'Offset' => 0,
        );
    
        $this->load->library('FXAPI');
        $ret = FXAPI::GetMyBonuses($params);
        
        $val = [];
        if($ret['RET'] == 'RET_OK'){
            
            foreach($ret['data']->Transactions->FinanceOpData as $d){
                ///$val[] = "[".$d->ProcessTime.",".$d->Amount."]";
                $val[]=array($d->ProcessTime,$d->Amount);
            }
        }
        echo json_encode($val);       
        
    }
    

    public function calculateBonusLeft(){
        if(!$this->input->is_ajax_request() && !$this->session->userdata('logged')){die('Not authorized!');}
        $amount = $this->input->post('amount',true);
        $account_number = $_SESSION['account_number'];
        $getBonusId = self::getBonusId($account_number);
        $bonusPercent = $this->bonusPercentByID[$getBonusId];

        $accountFunds = FXPP::getAccountFunds($account_number);
        $realAfterCancel = $accountFunds['withrawable_real_fund'] - $amount;
        $realFund = round($accountFunds['withrawable_real_fund'] * $bonusPercent,2);
        $fundWithdraw  = round($amount * $bonusPercent, 2);
        $BonusLeft = $realFund - $fundWithdraw;

        if ($BonusLeft < $accountFunds['bonus_fund']) {
            $BonusLeft = $BonusLeft;
        } elseif ($accountFunds['withrawable_real_fund'] <= 0) {
            $BonusLeft = 0;
        } elseif ($realAfterCancel <= 0) {
            $BonusLeft = 0;
        } else {
            $BonusLeft = 0;
        }

        echo json_encode($BonusLeft);

    }


    public function nodepositbonus()
    {
        $this->load->model('account_model');
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }

        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$_SESSION['user_id'],$select="dob",$order_by="");
        $_SESSION['dob']=$data['user_profiles']['dob'];


        //jira FXPP-2147 separate validation of fullname and email separate query

        $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
            $table1 = 'users',$table2 = 'user_profiles',
            $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
            $field1 = 'user_profiles.dob', $id1 = trim($_SESSION['dob']),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        $data['accountemail'] = $this->g_m->showt2w3j2sEmail(
            $table1 = 'users',$table2 = 'user_profiles',
            $field1 = 'users.email', $id1 = $_SESSION['email'],
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email'
        );

        //jira FXPP-1394
        //Implement logic of putting allowing NDB on the first account of clients who has multiple accounts in FXPP

//        $data['account'] = $this->g_m->showt2w3j2sX(
//            $table1 = 'users',$table2 = 'user_profiles',
//            $field1 = 'users.email', $id1 = $_SESSION['email'],
//            $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
//            $field3 = 'users.ndb_bonus!=', $id3 = '',
//            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
//            $join12 = 'users.id=user_profiles.user_id',
//            $select = 'ndb_bonus,users.email'
//        );
        $data['request']=false;

        $data['IsAcquiredFromOtherAccount'] = false;

        if ( $data['accountfullname']) {
            foreach ( $data['accountfullname'] as $key1 => $value1) {
                if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '' ) {

                }else if(is_null($value1['ndb_bonus'])) {

                } else {

                    $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        if ($data['accountemail']) {
            foreach ($data['accountemail'] as $key => $value) {
                if ((!isset($data['accountemail']['ndb_bonus'])) || trim($data['accountemail']['ndb_bonus']) === '' ) {
                }else if(is_null($data['accountemail']['ndb_bonus'])) {
                } else {
                    $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        //jira FXPP-1394


        //check for 1 week showing of no deposit tab
        $nodepositbonus = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'nodepositbonus,created,createdforadvertising');

        if (is_null($nodepositbonus['createdforadvertising']) or $nodepositbonus['createdforadvertising']=="") {
            $data['datecreated'] = $nodepositbonus['created'];
        } else {
            $data['datecreated'] = $nodepositbonus['createdforadvertising'];
        }


        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));

        if ($nodepositbonus['nodepositbonus'] == 1 OR $datedifference > 7) {
            echo json_encode('failed');
            die();
        }
        //check for 1 week showing of no deposit tab


        $this->db->trans_start();

        //default false of returns
        $data['IsStandardAccount'] = true;
        $data['Implemented'] = false;
        $data['HasError'] = false;
        $data['IsVerified'] = $data['NotNoDepositBonus'] = false;
        //default false of returns


        //get verified account and get nodepositbonus if already or not already given bonus amount field
        $prvt_data['IsVerified'] = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'accountstatus,nodepositbonus');

        if ($data['IsAcquiredFromOtherAccount'] == false) {//  //jira FXPP-1394

            if ($prvt_data['IsVerified']['accountstatus'] == 1 and $prvt_data['IsVerified']['nodepositbonus'] == 0) {
                $data['IsVerified'] = true;
                //get amount balance in USD if available

                $prvt_data['mt_account_set'] = $this->g_m->showt1w1($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'amount,id,mt_currency_base,mt_account_set_id,account_number,swap_free,leverage');

                //FXPP-1058 application     - allow only standard account to have bonus
                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
                $account_info = array('iLogin' => $prvt_data['mt_account_set']['account_number']);
//                $WebService->open_RequestAccountDetails($account_info);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

                if ($WebService->request_status === 'RET_OK') {
//                    $ForMarStaAcc =FXPP::get_standardgroup();
                    $ForMarStaAcc = FXPP::get_standardgroup_for_ndb($prvt_data['mt_account_set']['account_number']);
                    if ($ForMarStaAcc) {
                        $data['IsStandardAccount'] = true;
                    } else {
                        $data['IsStandardAccount'] = false;
                    }

//                    if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
//                        $data['IsStandardAccount'] = true;
//                    } else {
//                        $data['IsStandardAccount'] = false;
//                    }
                } else {
                    $data['IsStandardAccount'] = false;
                }
                //FXPP-1058 application

                //FXPP-1058
                if ($data['IsStandardAccount']) {

                    $data['mtas'] = $prvt_data['mt_account_set'];

                    //get user location bonus
                    $this->load->library('IPLoc', null);
                    $user_profiles = $this->g_m->showssingle2($table = 'user_profiles', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'country');
                    $data['bonus'] = IPLoc::bonusV2($user_profiles['country']);
                    $webservice_config = array('server' => 'live_new');
                    $WebService = new WebService($webservice_config);


                    if ($prvt_data['mt_account_set']['mt_currency_base'] == 'USD') {
//                        if(IPLoc::Office()){
//                            ini_set('max_execution_time', 0);
                            $this->load->model('deposit_model');

                            $no_deposit_data = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'date_request' => date('Y-m-d H:i:s'),
                                'account_number' => $prvt_data['mt_account_set']['account_number'],
                                'is_approved' => 0
                            );

                            $request_number = $this->deposit_model->insertNoDepositRequest($no_deposit_data);

                            if($request_number){
                                $data['request']=true;
                                $email_data = array(
                                    'request_number' => $request_number
                                );

//                                $account_details = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
//                                $support_email = 'support@forexmart.com';
//                                $config = array(
//                                    'mailtype'=> 'html'
//                                );

//                                $prvt_data['nodepositbonus'] = array(
//                                    'nodepositbonus' => 1,
//                                    'ndba_acquired' => $data['DateUp']->format('Y-m-d H:i:s'),
//                                    'ndb_bonus' => $this->roundno(floatval($data['bonus']), 2)
//
//                                );

                                //update table users
//                                $prvt_data['Update_users'] = $this->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $prvt_data['nodepositbonus']);

                                //$this->g_m->sendEmail('no-deposit-request-html', 'Application for No Deposit Bonus to account ' . $prvt_data['mt_account_set']['account_number'], $this->session->userdata('email'), $email_data, $config);
//                                $this->g_m->sendEmail('no-deposit-report-html', 'Application for No Deposit Bonus to account ' . $prvt_data['mt_account_set']['account_number'], $support_email, $email_data, $config);
                            }
//                        }else{
//
//                            // Remove Agent Account before Deposit
//                            $removeAgentAccount = false;
//                            $getAffiliateCodeByAccountNumber = $this->account_model->getAffiliateCodeByAccountNumber($prvt_data['mt_account_set']['account_number']);
//                            if ($getAffiliateCodeByAccountNumber) {
//                                $referralAffiliateCode = $getAffiliateCodeByAccountNumber['referral_affiliate_code'];
//                                if ($referralAffiliateCode) {
//                                    $webservice_config = array('server' => 'live_new');
//                                    $WebServiceRemove = new WebService($webservice_config);
//                                    $WebServiceRemove->RemoveAgentOfAccount($prvt_data['mt_account_set']['account_number']);
//                                    if ($WebServiceRemove->request_status === 'RET_OK') {
//                                        $removeAgentAccount = true;
//                                    }
//                                }
//                            }
//
//                            $account_info = array(
//                                'Login' => $prvt_data['mt_account_set']['account_number'],
//                                'FundTransferAccountReciever' => $prvt_data['mt_account_set']['account_number'],
//                                'Amount' => $this->roundno(floatval($data['bonus']), 2),
//                                'Comment' => 'FOREXMART NO DEPOSIT BONUS',
//                                'ProcessByIP' => $this->input->ip_address()
//                            );
//
//                            $WebService->open_Deposit_NoDepositBonus($account_info);
//
//                            if ($WebService->request_status === 'RET_OK') {
//                                // add account balance USD plus bonus
//                                $WebService2 = new WebService($webservice_config);
//                                $groupCurrency = $this->g_m->getGroupCurrency($prvt_data['mt_account_set']['mt_account_set_id'], $prvt_data['mt_account_set']['mt_currency_base'], $prvt_data['mt_account_set']['swap_free']);
//                                /**
//                                 * $user_details = $this->user_model->getUserProfileByUserId($_SESSION['user_id']);
//                                 */
//                                FXPP::update_account_group();
//                                $account_details = $this->account_model->getAccountByUserId($_SESSION['user_id']);
//                                /**
//                                 * $account_info2 = array(
//                                 * 'account_number' => $prvt_data['mt_account_set']['account_number'],
//                                 * 'city' => $user_details['city'],
//                                 * 'country' => $user_details['country'],
//                                 * 'email' => $user_details['email'],
//                                 * 'group' => $groupCurrency . 'ndb' . $account_details['group_code'], //change group
//                                 * 'leverage' => count($ex_leverage = explode(":", $prvt_data['mt_account_set']['leverage'])) > 1 ? $ex_leverage[1] : $prvt_data['mt_account_set']['leverage'],
//                                 * 'full_name' => $user_details['full_name'],
//                                 * 'phone_number' => $user_details['phone1'],
//                                 * 'state' => $user_details['state'],
//                                 * 'street_address' => $user_details['street'],
//                                 * 'zip_code' => $user_details['zip']
//                                 * );
//                                 * $WebService2->update_live_account_details($account_info2);
//                                 */
//                                $account_info2 = array(
//                                    'iLogin' => $prvt_data['mt_account_set']['account_number'],
//                                    'strGroup' => $groupCurrency . 'ndb' . $account_details['group_code']
//                                );
//                                $WebService2->open_ChangeAccountGroup($account_info2);
//
//                                $user = $this->user_model->getUserProfileByUserId($_SESSION['user_id']);
//                                if(in_array(strtoupper($user['country']), array('PL'))){
//                                    $account_info3 = array(
//                                        'iLogin' => $prvt_data['mt_account_set']['account_number'],
//                                        'iLeverage' => '100'
//                                    );
//                                }else{
//                                    $account_info3 = array(
//                                        'iLogin' => $prvt_data['mt_account_set']['account_number'],
//                                        'iLeverage' => '200'
//                                    );
//                                }
//                                $WebService3 = new WebService($webservice_config);
//                                $WebService3->open_ChangeAccountLeverage($account_info3);
//
//                                $sum = $this->roundno(floatval($data['bonus']), 2) + floatval($prvt_data['mt_account_set']['amount']);
//
//                                $prvt_data['amount'] = array(
//                                    'amount' => $this->roundno($sum, 2),
//                                    'leverage' => '1:200'
//                                );
//
//                                $prvt_data['Update_mt_account_set'] = $this->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $prvt_data['mt_account_set']['id'], $prvt_data['amount']);
//                                $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
//                                $prvt_data['nodepositbonus'] = array(
//                                    'nodepositbonus' => 1,
//                                    'ndba_acquired' => $data['DateUp']->format('Y-m-d H:i:s'),
//                                    'ndb_bonus' => $this->roundno(floatval($data['bonus']), 2)
//
//                                );
//                                //update table users
//                                $prvt_data['Update_users'] = $this->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $prvt_data['nodepositbonus']);
//
//
//                                if ($WebService2->request_status == 'RET_OK' and $WebService3->request_status == 'RET_OK') {
//                                    $data['NotNoDepositBonus'] = true;
//                                    $data['accountInfo'] = $account_info2;
//                                    $data['accountInfo3'] = $account_info3;
//                                    $data['reqStatus'] = $WebService2->request_status;
//                                    $data['reqStatus3'] = $WebService3->request_status;
//                                } else {
//                                    $data['NotNoDepositBonus'] = false;
//                                    $data['accountInfo'] = $account_info2;
//                                    $data['accountInfo3'] = $account_info3;
//                                    $data['reqStatus'] = $WebService2->request_status;
//                                    $data['reqStatus3'] = $WebService3->request_status;
//                                }
//
//
//                            } else {
//                                $data['HasError'] = true;
//                            }
//                        }

                        // Back Agent Account after Deposit success or  not
    //                        if($removeAgentAccount){
    //                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByAffiliateCode($referralAffiliateCode);
    //                            $AgentAccountNumber = $getAccountNumberByAffiliateCode[0]['reference_num'] ? $getAccountNumberByAffiliateCode[0]['reference_num'] : $getAccountNumberByAffiliateCode[0]['account_number'];
    //                            $service_data = array(
    //                                'AccountNumber' => $prvt_data['mt_account_set']['account_number'],
    //                                'AgentAccountNumber' => $AgentAccountNumber
    //                            );
    //                            $webservice_config = array(
    //                                'server' => 'live_new'
    //                            );
    //                            $WebService = new WebService($webservice_config);
    //                            $WebService->SetAccountAgent($service_data);
    //                            if( $WebService->request_status === 'RET_OK' ) {
    //                                $referral_data = array(
    //                                    'referral_affiliate_code' => $referralAffiliateCode
    //                                );
    //                                $this->account_model->updateUserDetails('users_affiliate_code', 'id', $getAffiliateCodeByAccountNumber['uacID'], $referral_data);
    //                            }
    //                        }

                    } else {
//                        if(IPLoc::Office()){
                            $this->load->model('deposit_model');

                            $no_deposit_data = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'date_request' => date('Y-m-d H:i:s'),
                                'account_number' => $prvt_data['mt_account_set']['account_number'],
                                'is_approved' => 0
                            );

                            $request_number = $this->deposit_model->insertNoDepositRequest($no_deposit_data);
                            if($request_number){
                                $data['request']=true;
                                $email_data = array(
                                    'request_number' => $request_number
                                );

                                $account_details = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
//                                $support_email = 'vela.nightclad@gmail.com';
//                                $config = array(
//                                    'mailtype'=> 'html'
//                                );

//                                $prvt_data['nodepositbonus'] = array(
//                                    'nodepositbonus' => 1,
//                                    'ndba_acquired' => $data['DateUp']->format('Y-m-d H:i:s'),
//                                    'ndb_bonus' => $this->roundno(floatval($data['bonus']), 2),
//                                    'ndb_bonus_api' => $account_info['amount']
//                                );
                                //update table users
//                                $prvt_data['Update_users'] = $this->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $prvt_data['nodepositbonus']);

                                //$this->general_model->sendEmail('no-deposit-request-html', 'Application for No Deposit Bonus to account ' . $prvt_data['mt_account_set']['account_number'], $account_details['email'], $email_data, $config);
//                                $this->general_model->sendEmail('no-deposit-report-html', 'Application for No Deposit Bonus to account ' . $prvt_data['mt_account_set']['account_number'], $support_email, $email_data, $config);
                            }
//                        }else{
//                            $ConvertedAmount = $this->convert($to = $prvt_data['mt_account_set']['mt_currency_base']);
//                            // add account balance USD plus bonus
//
//                            $data['convertedamount'] = floatval($data['bonus']) * floatval($ConvertedAmount);
//
//                            // Remove Agent Account before Deposit
//                            $removeAgentAccount = false;
//                            $getAffiliateCodeByAccountNumber = $this->account_model->getAffiliateCodeByAccountNumber($prvt_data['mt_account_set']['account_number']);
//                            if ($getAffiliateCodeByAccountNumber) {
//                                $referralAffiliateCode = $getAffiliateCodeByAccountNumber['referral_affiliate_code'];
//                                if ($referralAffiliateCode) {
//                                    $webservice_config = array('server' => 'live_new');
//                                    $WebServiceRemove = new WebService($webservice_config);
//                                    $WebServiceRemove->RemoveAgentOfAccount($prvt_data['mt_account_set']['account_number']);
//                                    if ($WebServiceRemove->request_status === 'RET_OK') {
//                                        $removeAgentAccount = true;
//                                    }
//                                }
//                            }
//
//                            $account_info = array(
//                                'Login' => $prvt_data['mt_account_set']['account_number'],
//                                'FundTransferAccountReciever' => $prvt_data['mt_account_set']['account_number'],
//                                'Amount' => $this->roundno(floatval($data['convertedamount']), 2),
//                                'Comment' => 'No deposit bonus',
//                                'ProcessByIP' => $this->input->ip_address()
//                            );
//
//                            $WebService->open_Deposit_NoDepositBonus($account_info);
//
//                            if ($WebService->request_status === 'RET_OK') {
//
//                                $WebService2 = new WebService($webservice_config);
//                                $swap_free = empty($prvt_data['mt_account_set']['swap_free']) ? 0 : $prvt_data['mt_account_set']['swap_free'];
//                                $data['getGroupCurrency'] = array(
//                                    'set_id' => $prvt_data['mt_account_set']['mt_account_set_id'],
//                                    'currency' => $prvt_data['mt_account_set']['mt_currency_base'],
//                                    'swap' => $swap_free,
//                                    'user_id' => $_SESSION['user_id']
//                                );
//                                $groupCurrency = $this->g_m->getGroupCurrency($prvt_data['mt_account_set']['mt_account_set_id'], $prvt_data['mt_account_set']['mt_currency_base'], $swap_free);
//                                $user_details = $this->user_model->getUserProfileByUserId($_SESSION['user_id']);
//                                FXPP::update_account_group();
//                                $account_details = $this->account_model->getAccountByUserId($_SESSION['user_id']);
//                                /**
//                                 * $account_info2 = array(
//                                 * 'account_number' => $prvt_data['mt_account_set']['account_number'],
//                                 * 'city' => $user_details['city'],
//                                 * 'country' => $user_details['country'],
//                                 * 'email' => $user_details['email'],
//                                 * 'group' => $groupCurrency . 'ndb1', //change group
//                                 * 'leverage' => count($ex_leverage = explode(":", $prvt_data['mt_account_set']['leverage'])) > 1 ? $ex_leverage[1] : $prvt_data['mt_account_set']['leverage'],
//                                 * 'full_name' => $user_details['full_name'],
//                                 * 'phone_number' => $user_details['phone1'],
//                                 * 'state' => $user_details['state'],
//                                 * 'street_address' => $user_details['street'],
//                                 * 'zip_code' => $user_details['zip']
//                                 * );
//                                 * $WebService2->update_live_account_details($account_info2);
//                                 */
//                                $account_info2 = array(
//                                    'iLogin' => $prvt_data['mt_account_set']['account_number'],
//                                    'strGroup' => $groupCurrency . 'ndb' . $account_details['group_code']
//                                );
//                                $WebService2->open_ChangeAccountGroup($account_info2);
//
//                                $account_info3 = array(
//                                    'iLogin' => $prvt_data['mt_account_set']['account_number'],
//                                    'iLeverage' => '200'
//                                );
//                                $WebService3 = new WebService($webservice_config);
//                                $WebService3->open_ChangeAccountLeverage($account_info3);
//
//                                $sum = floatval($data['convertedamount']) + floatval($prvt_data['mt_account_set']['amount']);
//                                $prvt_data['amount'] = array(
//                                    'amount' => $this->roundno($sum, 2),
//                                    'leverage' => '1:200'
//                                );
//
//                                $prvt_data['Update_mt_account_set'] = $this->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $prvt_data['mt_account_set']['id'], $prvt_data['amount']);
//                                $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
//                                $prvt_data['nodepositbonus'] = array(
//                                    'nodepositbonus' => 1,
//                                    'ndba_acquired' => $data['DateUp']->format('Y-m-d H:i:s'),
//                                    'ndb_bonus' => $this->roundno(floatval($data['bonus']), 2),
//                                    'ndb_bonus_api' => $account_info['amount']
//                                );
//                                //update table users
//                                $prvt_data['Update_users'] = $this->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $prvt_data['nodepositbonus']);
//                                if ($WebService2->request_status == 'RET_OK' and $WebService3->request_status == 'RET_OK') {
//                                    $data['NotNoDepositBonus'] = true;
//                                    $data['accountInfo'] = $account_info2;
//                                    $data['accountInfo3'] = $account_info3;
//                                    $data['reqStatus'] = $WebService2->request_status;
//                                    $data['reqStatus3'] = $WebService3->request_status;
//                                } else {
//                                    $data['NotNoDepositBonus'] = false;
//                                    $data['accountInfo'] = $account_info2;
//                                    $data['accountInfo3'] = $account_info3;
//                                    $data['reqStatus'] = $WebService2->request_status;
//                                    $data['reqStatus3'] = $WebService3->request_status;
//                                }
//
//                            } else {
//                                $data['HasError'] = true;
//                            }
//                        }


                        // Back Agent Account after Deposit success or  not
    //                        if($removeAgentAccount){
    //                            $getAccountNumberByAffiliateCode = $this->account_model->getAccountNumberByAffiliateCode($referralAffiliateCode);
    //                            $AgentAccountNumber = $getAccountNumberByAffiliateCode[0]['reference_num'] ? $getAccountNumberByAffiliateCode[0]['reference_num'] : $getAccountNumberByAffiliateCode[0]['account_number'];
    //                            $service_data = array(
    //                                'AccountNumber' => $prvt_data['mt_account_set']['account_number'],
    //                                'AgentAccountNumber' => $AgentAccountNumber
    //                            );
    //                            $webservice_config = array(
    //                                'server' => 'live_new'
    //                            );
    //                            $WebService = new WebService($webservice_config);
    //                            $WebService->SetAccountAgent($service_data);
    //                            if( $WebService->request_status === 'RET_OK' ) {
    //                                $referral_data = array(
    //                                    'referral_affiliate_code' => $referralAffiliateCode
    //                                );
    //                                $this->account_model->updateUserDetails('users_affiliate_code', 'id', $getAffiliateCodeByAccountNumber['uacID'], $referral_data);
    //                            }
    //                        }
                    }

                }

            } elseif ($prvt_data['IsVerified']['accountstatus'] == 1 and $prvt_data['IsVerified']['nodepositbonus'] == 1) {
                $data['Implemented'] = true;
            }
        }
        $this->db->trans_complete();
        echo json_encode($data);

    }

    private function convert($to){

        $data['data']['custom_validation']='';
        $data['convert']['handle'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=USD' . $to .'=X', 'r');

        if ($data['convert']['handle']) {
            $data['convert']['result'] = fgets($data['convert']['handle'], 4096);
            fclose($data['convert']['handle']);
        }

        $data['convert']['all_data']  = explode(',',$data['convert']['result'] );

        if($data['convert']['all_data'][1] != 0.00){
            $data['data']['value'] =$data['convert']['all_data'][1];
        }else{
            $data['data']['value']  = false;
        }

        return $data['data']['value'];
    }
    public function twentypercentbonus(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $hasDeposit = $this->deposit_model->has20BonusDeposit($user_id);
        $hasclaimed_twpb = $this->deposit_model->hasClaimed20BonusDeposit($user_id);

        $account_detail = $this->account_model->getAccountByUserId($user_id);
        $user_detail = $this->account_model->getUserInfoByUserId($user_id);
        $claimedBonus = $this->deposit_model->has20PercentBonusDeposit_v2($user_id);
        $deposit20Bonus = '';
        $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($user_id);
        if(!$first_bonus_acquired){
            $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquiredITS($account_detail['account_number']);
            if($first_bonus_acquired['BonusType'] == 'twpb'){
                $first_bonus_acquired['twentypercentbonus'] = 1;
            }
        }
        if($first_bonus_acquired){
            if($first_bonus_acquired['twentypercentbonus'] == 1){
                $can_claim = true;
            }else{
                $can_claim = false;
            }
        }else{
            $can_claim = true;
        }
        $non_verified_users = $this->non_verified_bonus_validation($user_id);
        if(!$claimedBonus) {
            $bonus_delay = false;
            if($hasDeposit){
                $deposit20BonusData = $this->deposit_model->getAll20BonusDeposit_all_new($user_id);
                foreach($deposit20BonusData as $key => $value){
                    if($value['transaction_type']=='BITCOIN'){
                        $deposit20Bonus .= '<tr>
                    <td>' . date('m/d/Y H:i:s', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['conv_amount'], 2) . '</td>
                    <td>' . number_format($value['conv_amount'] * 0.2, 2) . '</td>
                    </tr>';
                    }else{
                        $deposit20Bonus .= '<tr>
                    <td>' . date('m/d/Y H:i:s', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['amount'], 2) . '</td>
                    <td>' . number_format($value['amount'] * 0.2, 2) . '</td>
                    </tr>';
                    }
                }
            }
//            if( (IPLoc::Office()) ){
            $transfer20BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
            if($can_claim && (count($transfer20BonusData)>0)){
                foreach($transfer20BonusData as $key => $value) {
                    $deposit20Bonus .= '<tr>
                        <td>' . date('m/d/Y H:i:s', strtotime($value['date_transfer'])) . '</td>
                        <td>' . number_format($value['conv_amount'], 2) . '</td>
                        <td>' . number_format($value['conv_amount'] * 0.2, 2) . '</td>
                        </tr>';
                }
                $hasDeposit = true;
            }
//            }
        }else{
            $bonus_delay = true;
        }

        if($this->isSupporter){
            $hasSupporterBonus = true;
        }else{
            $hasSupporterBonus = false;
        }



        $data = array(
            'has_deposit' => $hasDeposit,
            'has_twpb' => $hasclaimed_twpb,
            'is_verified' => $user_detail['accountstatus'],
            'nodepositbonus' => $user_detail['nodepositbonus'],
            'can_claim' => $can_claim,
            'account_number' => $account_detail['account_number'],
            'bonus_data' => $deposit20Bonus,
            'bonus_delay' => $bonus_delay,
            'isSupporter' => $hasSupporterBonus,
            'non_verified' => $non_verified_users
        );
//        if(IPLoc::Office()){
        $data_log= array(
            'data'=>json_encode($data),
            'user_id'=>$this->session->userdata('user_id'),
            'date'=>FXPP::getServerTime(),
            'bonus_type'=>'20% bonus - 1st validation'
        );
        $this->deposit_model->insertBonusLogAttempt($data_log);
//        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    public function thirtypercentbonus(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $hasDeposit = $this->deposit_model->has30BonusDeposit($user_id);
        $hasclaimed_tpb = $this->deposit_model->hasClaimed30BonusDeposit($user_id);

        $account_detail = $this->account_model->getAccountByUserId($user_id);
        $user_detail = $this->account_model->getUserInfoByUserId($user_id);
        $claimedBonus = $this->deposit_model->has30PercentBonusDeposit_v2($user_id);
        $deposit30Bonus = '';
        $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($user_id);
        if(!$first_bonus_acquired){
            $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquiredITS($account_detail['account_number']);
            if($first_bonus_acquired['BonusType'] == 'tpb'){
                $first_bonus_acquired['thirtypercentbonus'] = 1;
            }
        }
        if($first_bonus_acquired){
            if($first_bonus_acquired['thirtypercentbonus'] == 1){
                $can_claim = true;
            }else{
                $can_claim = false;
            }
        }else{
            $can_claim = true;
        }
        $non_verified_users = $this->non_verified_bonus_validation($user_id);
        if(!$claimedBonus) {
        $bonus_delay = false;
        if($hasDeposit){
            $deposit30BonusData = $this->deposit_model->getAll30BonusDeposit_all_new($user_id);
            foreach($deposit30BonusData as $key => $value){
                if($value['transaction_type']=='BITCOIN'){
                    $deposit30Bonus .= '<tr>
                    <td>' . date('m/d/Y H:i:s', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['conv_amount'], 2) . '</td>
                    <td>' . number_format($value['conv_amount'] * 0.3, 2) . '</td>
                    </tr>';
                }else{
                    $deposit30Bonus .= '<tr>
                    <td>' . date('m/d/Y H:i:s', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['amount'], 2) . '</td>
                    <td>' . number_format($value['amount'] * 0.3, 2) . '</td>
                    </tr>';
                }
            }
        }
//            if( (IPLoc::Office()) ){
                $transfer30BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
                if($can_claim && (count($transfer30BonusData)>0)){
                    foreach($transfer30BonusData as $key => $value) {
                        $deposit30Bonus .= '<tr>
                        <td>' . date('m/d/Y H:i:s', strtotime($value['date_transfer'])) . '</td>
                        <td>' . number_format($value['conv_amount'], 2) . '</td>
                        <td>' . number_format($value['conv_amount'] * 0.3, 2) . '</td>
                        </tr>';
                    }
                    $hasDeposit = true;
                }
//            }
    }else{
        $bonus_delay = true;
    }

         if($this->isSupporter){
            $hasSupporterBonus = true;
         }else{
             $hasSupporterBonus = false;
         }



        $data = array(
            'has_deposit' => $hasDeposit,
            'has_tpb' => $hasclaimed_tpb,
            'is_verified' => $user_detail['accountstatus'],
            'nodepositbonus' => $user_detail['nodepositbonus'],
            'can_claim' => $can_claim,
            'account_number' => $account_detail['account_number'],
            'bonus_data' => $deposit30Bonus,
            'bonus_delay' => $bonus_delay,
            'isSupporter' => $hasSupporterBonus,
            'non_verified' => $non_verified_users
        );
//        if(IPLoc::Office()){
            $data_log= array(
                'data'=>json_encode($data),
                'user_id'=>$this->session->userdata('user_id'),
                'date'=>FXPP::getServerTime(),
                'bonus_type'=>'30% bonus - 1st validation'
            );
            $this->deposit_model->insertBonusLogAttempt($data_log);
//        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }


    public function fiftypercentbonus(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $user_id = $this->session->userdata('user_id');
        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob,zip",$order_by="");
        if(IPLoc::isEuropeanCountry($data['user_profiles']['country'])){
            return false;
        }


        $this->load->library('WebService');
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $hasDeposit = $this->deposit_model->has50BonusDeposit($user_id);
        $account_detail = $this->account_model->getAccountByUserId($user_id);
        $claimedBonus = $this->deposit_model->has50PercentBonusDeposit_v2($user_id);
        $deposit50Bonus = '';
        $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquired($user_id);
        if(!$first_bonus_acquired){
            $first_bonus_acquired = $this->deposit_model->getFirstPercentBonusAcquiredITS($account_detail['account_number']);
            if($first_bonus_acquired['BonusType'] == 'fpb'){
                $first_bonus_acquired['fiftypercentbonus'] = 1;
            }
        }
        if($first_bonus_acquired){
            if($first_bonus_acquired['fiftypercentbonus'] == 1){
                $can_claim = true;
            }else{
                $can_claim = false;
            }
        }else{
            $can_claim = true;
        }
        $user_detail = $this->account_model->getUserInfoByUserId($user_id);
        $non_verified_users = $this->non_verified_bonus_validation($user_id);
        //FXPP-3756 allow only standard account to have bonus
        $webservice_config = array('server' => 'live_new');
//        $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_detail['account_number']);
//        $WebService->open_RequestAccountDetails($account_info);

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

        if ($WebService->request_status === 'RET_OK') {
//            $accountGroup = $WebService->get_all_result();
            $accountGroup = $WebService->result;
//            $ForMarStaAcc =FXPP::get_standardgroup();
            $ForMarStaAcc = FXPP::get_standardgroup_v2($account_detail['account_number']);
            if($ForMarStaAcc){
                $isStandardAccount = true;
            }else{
                $isStandardAccount = false;
            }

//            if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
//                $isStandardAccount = true;
//            } else {
//                $isStandardAccount = false;
//            }
        } else {
            $accountGroup = 'status: ' . $WebService->request_status;
            $isStandardAccount = false;
        }

        $has_loss = false;
        $equity = 0;
        $total_loss = 0;
        if(!$claimedBonus) {
            $bonus_delay = false;
        if($hasDeposit){
                $deposit50BonusData = $this->deposit_model->getAll50BonusDeposit_all($user_id);
            if(IPLoc::Office() && $this->session->userdata('user_id')==224740){
//                print_r($deposit50BonusData);
            }
            $total_deposit = 0;
            foreach($deposit50BonusData as $key => $value){
                $total_deposit += $value['amount'];
            }

//            $WebService2 = new WebService($webservice_config);
//            $WebService2->RequestAccountFunds($account_detail['account_number']);
//            $equity = $WebService2->get_result('Equity');

                        
            $fundsData = FXPP::getAccountFunds($account_detail['account_number']);


            $equity = $fundsData['equity'];

           

            if($equity > 0){
                if($equity < $total_deposit){
                    $has_loss = true;
                    foreach($deposit50BonusData as $key => $value){
                        if($value['transaction_type']=='BITCOIN'){
                            $deposit50Bonus .= '<tr>
                    <td>' . date('m/d/Y', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['amount'], 2) . '</td>
                    <td></td>
                    </tr>';
                        }else{
                            $deposit50Bonus .= '<tr>
                    <td>' . date('m/d/Y', strtotime($value['payment_date'])) . '</td>
                    <td>' . number_format($value['amount'], 2) . '</td>
                    <td></td>
                    </tr>';
                        }

                    }

                    $total_loss = $total_deposit - $equity;
                }else{
                    foreach($deposit50BonusData as $key => $value){
                        if($value['transaction_type']=='BITCOIN'){
                                    $deposit50Bonus .= '<tr>
                            <td>' . date('m/d/Y', strtotime($value['payment_date'])) . '</td>
                            <td>' . number_format($value['conv_amount'], 2) . '</td>
                            <td>' . number_format($value['conv_amount'] * 0.5, 2) . '</td>
                            </tr>';
                        }else{
                                    $deposit50Bonus .= '<tr>
                            <td>' . date('m/d/Y', strtotime($value['payment_date'])) . '</td>
                            <td>' . number_format($value['amount'], 2) . '</td>
                            <td>' . number_format($value['amount'] * 0.5, 2) . '</td>
                            </tr>';
                        }

                    }
                }
            }else{
                $hasDeposit = false;
            }
        }
                $transfer50BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
                if($can_claim && (count($transfer50BonusData)>0)){
                    foreach($transfer50BonusData as $key => $value) {
                        $deposit50Bonus .= '<tr>
                        <td>' . date('m/d/Y H:i:s', strtotime($value['date_transfer'])) . '</td>
                        <td>' . number_format($value['conv_amount'], 2) . '</td>
                        <td>' . number_format($value['conv_amount'] * 0.5, 2) . '</td>
                        </tr>';
                    }
                    $hasDeposit = true;
                }

    }else{
        $bonus_delay = true;

    }

        if($this->isSupporter){
            $hasSupporterBonus = true;
        }else{
            $hasSupporterBonus = false;
        }

        $data = array(
            'has_loss' => $has_loss,
            'total_loss' => number_format($total_loss * -1, 2),
            'claimable_amount' => $equity,
            'claimable_bonus' => number_format($equity * 0.5, 2),
            'has_deposit' => $hasDeposit,
            'is_standard' => $isStandardAccount,
            'account_group' => $accountGroup,
            'can_claim' => $can_claim,
            'account_number' => $account_detail['account_number'],
            'bonus_data' => $deposit50Bonus,
            'bonus_delay' => $bonus_delay,
            'isSupporter' => $hasSupporterBonus,
            'nodepositbonus' => $user_detail['nodepositbonus'],
            'is_verified' => $user_detail['accountstatus'],
            'non_verified' => $non_verified_users
        );
        $data_log= array(
            'data'=>json_encode($data),
            'user_id'=>$this->session->userdata('user_id'),
            'date'=>FXPP::getServerTime(),
            'bonus_type'=>'50% bonus - 1st validation'
        );
        $this->deposit_model->insertBonusLogAttempt($data_log);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    public function getBonusTwentyPercent(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}


        $user_id = $this->session->userdata('user_id');
        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob,zip",$order_by="");
        if(IPLoc::isEuropeanCountry($data['user_profiles']['country'])){
            return false;
        }

        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $is_get_bonus = false;
        $has_no_deposit_bonus = false;
        $account_detail = $this->account_model->getAccountByUserId($user_id);
        //FXPP-8306
        if ($account_detail) {
            $user_details = $this->user_model->getUserDetails($user_id);
            if ($user_details) {
                $non_verified_users = $this->non_verified_bonus_validation($user_id);
                if (($user_details['nodepositbonus'] == 0)) {
                    $hasDeposit = $this->deposit_model->hasPercentBonusDeposit($user_id);
                    $hasclaimed_twpb = $this->deposit_model->hasClaimed20BonusDeposit($user_id);
                    $transfer20BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
                    if ( ($hasDeposit) || ($transfer20BonusData)) {
                        $webservice_config = array('server' => 'live_new');
                        $deposit20BonusData = $this->deposit_model->getAll20BonusDeposit($user_id);
                        $total_deposit = 0;
                        $total_deposit_ITS = 0;
                        foreach ($deposit20BonusData as $key => $value) {
                            $total_deposit += $value['amount'];
                        }
                        foreach($transfer20BonusData as $key => $value){
                            $total_deposit_ITS += $value['conv_amount'];
                        }


                      /*   $accountFunds = FXPP::getAccountFunds($account_detail['account_number']);
                        $total_equity              = $accountFunds['equity'];
                        $total_bonus_fund          = $accountFunds['bonusFund'];
                        $total_withdraw_real_fund  = $accountFunds['withrawableRealFund'];
                        $total_withdraw_bonus_fund = $accountFunds['withrawableBonusFund'];
                        $total_real_fund           = $accountFunds['realFund'];*/



                      //  if ($total_real_fund > 0) {
                            $total_deposit_and_transfer = $total_deposit + $total_deposit_ITS;


                            $resData = $this->ProcessBonus($account_detail['account_number'],'twpb');
                            if(!$resData['error']){
                                $date_bonus_acquired = date('Y-m-d H:i:s');
                                $setDepositBonus = $this->deposit_model->setBonusTwentyBonus($user_id, 1, $date_bonus_acquired, 2);
                                $setITSBonus = $this->deposit_model->setBonusITS($account_detail['account_number'],1, $date_bonus_acquired);
                                if ( ($setDepositBonus) || ($setITSBonus)   ) {
//                                    $WebService = new WebService($webservice_config);
                                    $account_info = array(
                                        'AccountNumber' => $account_detail['account_number'],
                                        'Amount'        => $resData['amount'],
                                        'Comment'       => 'FOREXMART WELCOME BONUS 20%',
                                        'ProcessByIP'   => $this->input->ip_address()
                                    );


//                                    if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                                        $webserviceResult =  FXPP::CreditBonus('BONUS_20_PERCENT', $resData['amount'], 'FOREXMART WELCOME BONUS 20%', $account_detail['account_number']);
                                        $reqResult   = $webserviceResult['ErrorMessage'];
                                        $bonusTicket = $webserviceResult['Data']->Ticket;
//                                    }else{
//                                        $WebService->open_Deposit_20PercentBonus($account_info);
//                                        $reqResult   = $WebService->request_status;
//                                        $bonusTicket = $WebService->get_result('Ticket');

//                                    }

                                    FXPP::CI()->load->model('Logs_model');
                                    $logData = array(
                                        'account_number' => isset($account_detail['account_number']) ? $account_detail['account_number'] : 0,
                                        'method' => 'BONUS_20_PERCENT',
                                        'request_data' => json_encode(array('BONUS_20_PERCENT', $resData['amount'], 'FOREXMART WELCOME BONUS 20%', $account_detail['account_number'])),
                                        'status' => $reqResult,
                                        'date' => FXPP::getCurrentDateTime()
                                    );

                                    FXPP::CI()->Logs_model->insert_log($table = "api_method_log", $logData);


                                    if ($reqResult === 'RET_OK') {
                                         $account_number = $account_detail['account_number'];

                                        $is_get_bonus = true;
                                        $message = '<i class="fa fa-check-circle"></i> You have successfully claimed your bonus.';

                                        /*$api_data = array(
                                            'equity'              => $total_equity,
                                            'bonus_fund'          => $total_bonus_fund,
                                            'withdraw_bonus_fund' => $total_withdraw_bonus_fund,
                                            'withdraw_real_fund'  => $total_withdraw_real_fund,
                                            'total_real_fund'     => $total_real_fund,
                                            'CreditBonusStatus'   => $reqResult,
                                            'bonus_sum_amount'    => $resData['amount'],
                                            'updateBalancestat'   => '',
                                            'total_deposit'       => $total_deposit,
                                            'total_transfer'      => $total_deposit_ITS
                                            


                                        );*/

                                        $bonusArray_v1 = array(
                                            'AmountDeposited' => $total_deposit_and_transfer,
                                            'AmountBonus'     => $resData['amount'],
                                            'DateProcessed'   => $date_bonus_acquired,
                                            'UserId'          => $user_id,
                                            'AccountNumber'   => $account_number,
                                            'TransactionPage' => 'bonus',
                                            'Ticket'          => $bonusTicket,
                                            'BonusType'       => 'twpb',
                                            'DepositId'       => 0,
                                            'BonusStatus'     => 2,
                                           // 'APIData'         => json_encode($api_data),
                                          //  'ProcessedBy'     => $processedAmountBy,
                                        );

                                        $this->deposit_model->insertDepositBonus($bonusArray_v1);
                                    } else {
                                        $message = 'Internal error on webservice.';
                                    }
                                }
                            }else{
                                $message = $resData['errorMsg'];
                            }

                        /*} else {
                            $hasDeposit = false;
                            $message = 'Account ' . $account_detail['account_number'] . ' has ' . $total_real_fund . ' total real fund.';
                        }*/
                    } else if ($hasclaimed_twpb) {
                        $message = 'You have already claimed 20% bonus for your previous deposits.';
                    } else {
                        $message = 'You have not receive any transfers nor made any deposits to the following account number yet: ' . $account_detail['account_number'];
                    }
                } else {
//                        if ($user_details['accountstatus'] == 0) {
//                            $message = 'Account is not yet verified.';
                    if ($user_details['nodepositbonus'] == 1) {
                        $has_no_deposit_bonus = true;
                        $message = 'You are not eligible to claim the 20% bonus on this account. To claim your 20% bonus, please create a new trading account.';
                    }
                }
            } else {
                $message = 'Invalid user details.';
            }
        } else {
            $message = 'Invalid account details.';
        }

        //FXPP-8306

        $data = array('success' => $is_get_bonus, 'has_deposit' => $hasDeposit, 'has_no_deposit_bonus' => $has_no_deposit_bonus, 'message' => $message);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function getBonusThirtyPercent(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}


        $user_id = $this->session->userdata('user_id');
        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob,zip",$order_by="");
        if(IPLoc::isEuropeanCountry($data['user_profiles']['country'])){
            return false;
        }

        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $is_get_bonus = false;
        $has_no_deposit_bonus = false;
        $account_detail = $this->account_model->getAccountByUserId($user_id);
            //FXPP-8306
            if ($account_detail) {
                $user_details = $this->user_model->getUserDetails($user_id);
                if ($user_details) {
                    $non_verified_users = $this->non_verified_bonus_validation($user_id);
                    if (($user_details['nodepositbonus'] == 0)) {
                        $hasDeposit = $this->deposit_model->hasPercentBonusDeposit($user_id);
                        $hasclaimed_tpb = $this->deposit_model->hasClaimed30BonusDeposit($user_id);
                        $transfer30BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
                        if (    ($hasDeposit) || ($transfer30BonusData)) {
                            $webservice_config = array('server' => 'live_new');
                            $deposit50BonusData = $this->deposit_model->getAll30BonusDeposit($user_id);
                            $total_deposit = 0;
                            $total_deposit_ITS = 0;
                            foreach ($deposit50BonusData as $key => $value) {
                                $total_deposit += $value['amount'];
                            }
                            foreach($transfer30BonusData as $key => $value){
                                $total_deposit_ITS += $value['conv_amount'];
                            }


                                                    
                           /* $accountFunds = FXPP::getAccountFunds($account_detail['account_number']);
                            $total_equity              = $accountFunds['equity'];
                            $total_bonus_fund          = $accountFunds['bonusFund'];
                            $total_withdraw_real_fund  = $accountFunds['withrawableRealFund'];
                            $total_withdraw_bonus_fund = $accountFunds['withrawableBonusFund'];
                            $total_real_fund           = $accountFunds['realFund'];*/

                                                        

                          //  if ($total_real_fund > 0) {
                                $total_deposit_and_transfer = $total_deposit + $total_deposit_ITS;
                              

                                $resData = $this->ProcessBonus($account_detail['account_number'],'tpb');
                                    if(!$resData['error']){
                                        $date_bonus_acquired = date('Y-m-d H:i:s');
                                        $setDepositBonus = $this->deposit_model->setBonusThirtyBonus($user_id, 1, $date_bonus_acquired, 2);
                                        $setITSBonus = $this->deposit_model->setBonusITS($account_detail['account_number'],1, $date_bonus_acquired);
                                        if ( ($setDepositBonus) || ($setITSBonus)   ) {
                                            $WebService = new WebService($webservice_config);
                                            $account_info = array(
                                                'AccountNumber' => $account_detail['account_number'],
                                                'Amount'        => $resData['amount'],
                                                'Comment'       => 'FOREXMART WELCOME BONUS 30%',
                                                'ProcessByIP'   => $this->input->ip_address()
                                            );

//                                          
                                                $webserviceResult =  FXPP::CreditBonus(
                                                    'BONUS_30_PERCENT',
                                                    $resData['amount'],
                                                    'FOREXMART WELCOME BONUS 30%',
                                                    $account_detail['account_number']
                                                );
                                                $reqResult   = $webserviceResult['ErrorMessage'];
                                                $bonusTicket = $webserviceResult['Data']->Ticket;

                                                FXPP::CI()->load->model('Logs_model');
                                                $logData = array(
                                                    'account_number' => isset($account_detail['account_number']) ? $account_detail['account_number'] : 0,
                                                    'method' => 'BONUS_30_PERCENT',
                                                    'request_data' => json_encode(array('BONUS_30_PERCENT', $resData['amount'], 'FOREXMART WELCOME BONUS 30%', $account_detail['account_number'])),
                                                    'status' => $reqResult,
                                                    'date' => FXPP::getCurrentDateTime()
                                                );
            
                                                FXPP::CI()->Logs_model->insert_log($table = "api_method_log", $logData);
            
//                                       

                                            if ($reqResult === 'RET_OK') {
                                    
                                                $is_get_bonus = true;
                                                $message = '<i class="fa fa-check-circle"></i> You have successfully claimed your bonus.';

                                                /*$api_data = array(
                                                    'equity'              => $total_equity,
                                                    'bonus_fund'          => $total_bonus_fund,
                                                    'withdraw_bonus_fund' => $total_withdraw_bonus_fund,
                                                    'withdraw_real_fund'  => $total_withdraw_real_fund,
                                                    'total_real_fund'     => $total_real_fund,
                                                    'CreditBonusStatus'   => $reqResult,
                                                    'bonus_sum_amount'    => $resData['amount'],
                                                    'updateBalancestat'   => '',
                                                    'total_deposit'       => $total_deposit,
                                                    'total_transfer'       => $total_deposit_ITS
                                                );*/

                                                $bonusArray_v1 = array(
                                                    'AmountDeposited' => $total_deposit_and_transfer,
                                                    'AmountBonus'     => $resData['amount'],
                                                    'DateProcessed'   => $date_bonus_acquired,
                                                    'UserId'          => $user_id,
                                                    'AccountNumber'   => $account_detail['account_number'],
                                                    'TransactionPage' => 'bonus',
                                                    'Ticket'          => $bonusTicket,
                                                    'BonusType'       => 'tpb',
                                                    'DepositId'       => 0,
                                                    'BonusStatus'     => 2,
                                                  //  'APIData'         => json_encode($api_data),
                                                    //'ProcessedBy'     => $processedAmountBy,
                                                );

                                                $this->deposit_model->insertDepositBonus($bonusArray_v1);
                                            } else {
                                                $message = 'Internal error on webservice.';
                                            }
                                        }
                                    }else{
                                        $message = $resData['errorMsg'];
                                    }

                           /* } else {
                                $hasDeposit = false;
                                $message = 'Account ' . $account_detail['account_number'] . ' has ' . $total_real_fund . ' total real fund.';
                            }*/
                        } else if ($hasclaimed_tpb) {
                            $message = 'You have already claimed 30% bonus for your previous deposits.';
                        } else {
                            $message = 'You have not receive any transfers nor made any deposits to the following account number yet: ' . $account_detail['account_number'];
                        }
                    } else {
//                        if ($user_details['accountstatus'] == 0) {
//                            $message = 'Account is not yet verified.';
                       if ($user_details['nodepositbonus'] == 1) {
                            $has_no_deposit_bonus = true;
                            $message = 'You are not eligible to claim the 30% bonus on this account. To claim your 30% bonus, please create a new trading account.';
                        }
                    }
                } else {
                    $message = 'Invalid user details.';
                }
            } else {
                $message = 'Invalid account details.';
            }

            //FXPP-8306

        $data = array('success' => $is_get_bonus, 'has_deposit' => $hasDeposit, 'has_no_deposit_bonus' => $has_no_deposit_bonus, 'message' => $message);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function getBonusThirtyPercent_test(){
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = 212860;
        $is_get_bonus = false;
        $has_no_deposit_bonus = false;
        $account_detail = $this->account_model->getAccountByUserId($user_id);
        if( $account_detail ){
            $user_details = $this->user_model->getUserDetails($user_id);
            if( $user_details ){
                if( ($user_details['accountstatus'] == 1 && $user_details['nodepositbonus'] == 0)){
                    $hasDeposit = $this->deposit_model->hasPercentBonusDeposit($user_id);
                    if($hasDeposit) {
                        $webservice_config = array(
                            'server' => 'live_new'
                        );
                        $deposit50BonusData = $this->deposit_model->getAll30BonusDeposit($user_id);
                        $total_deposit = 0;
                        foreach($deposit50BonusData as $key => $value){
                            $total_deposit += $value['amount'];
                        }

//                        $WebService2 = new WebService($webservice_config);
//                        $WebService2->RequestAccountFunds($account_detail['account_number']);
//                        $equity = $WebService2->get_result('Equity');

                                                    
                    $fundsData = FXPP::getAccountFunds($account_detail['account_number']);


                    $equity = $fundsData['equity'];


                        if($equity > 0){

                            if($equity < $total_deposit) {
                                $bonus_sum_amount['amount'] = $equity * 0.3;
                            }else{
                                $bonus_sum_amount = $this->deposit_model->getAll30BonusDepositAmount($user_id);
                            }
                            $date_bonus_acquired = date('Y-m-d H:i:s');
                            if ($this->deposit_model->setBonusThirtyBonus($user_id, 1, $date_bonus_acquired,2)) {
//                                $WebService = new WebService($webservice_config);
                                $account_info = array(
                                    'AccountNumber' => $account_detail['account_number'],
                                    'Amount' => $bonus_sum_amount['amount'],
                                    'Comment' => 'FOREXMART WELCOME BONUS 30%',
                                    'ProcessByIP' => $this->input->ip_address()
                                );

//                                if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                                    $webserviceResult =  FXPP::CreditBonus(
                                        'BONUS_30_PERCENT',
                                        $bonus_sum_amount['amount'],
                                        'FOREXMART WELCOME BONUS 30%',
                                        $account_detail['account_number']
                                    );
                                    $reqResult   = $webserviceResult['ErrorMessage'];
//                                }else{
//                                    $WebService->open_Deposit_30PercentBonus($account_info);
//                                    $reqResult   = $WebService->request_status;
//                                }

                                if( $reqResult === 'RET_OK' ) {
                                    $WebService2 = new WebService($webservice_config);
                                    $account_number = $account_detail['account_number'];
                                    $WebService2->request_live_account_balance($account_number);
                                    if ($WebService2->request_status === 'RET_OK') {
                                        $amount = $WebService2->get_result('Balance');
                                        $this->account_model->updateAmountByAccountNumber($account_number, $amount);
                                    }
                                    $is_get_bonus = true;
                                    $message = '<i class="fa fa-check-circle"></i> You have successfully claimed your bonus.';
                                }else{
                                    $message = 'Internal error on webservice.';
                                }
                            }
                        }else{
                            $hasDeposit = false;
                            $tb_test = '';
                            if(IPLoc::Office()){ $tb_test = 'no equity';}
                            $message = 'You have not made any deposits to the following account number yet: ' . $account_detail['account_number'].$tb_test;
                        }
                    }else{
                        $message = 'You have not made any deposits to the following account number yet: ' . $account_detail['account_number'];
                    }
                }else{
                    if($user_details['accountstatus'] == 0){
                        $message = 'Account is not yet verified.';
                    }elseif($user_details['nodepositbonus'] == 1){
                        $has_no_deposit_bonus = true;
                        $message = 'You are not eligible to claim the 30% bonus on this account. To claim your 30% bonus, please create a new trading account.';
                    }
                }
            }else{
                $message = 'Invalid user details.';
            }
        }else{
            $message = 'Invalid account details.';
        }

        print_r('testing 30$');echo "<br>";
        print_r($is_get_bonus);echo "<br>";
        print_r($message);exit;
//        $data = array('success' => $is_get_bonus, 'has_deposit' => $hasDeposit, 'has_no_deposit_bonus' => $has_no_deposit_bonus, 'message' => $message);
//
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function getBonusFiftyPercent(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        $this->load->model('deposit_model');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $is_get_bonus = false;
        $has_no_deposit_bonus = false;
        $account_detail = $this->account_model->getAccountByUserId($user_id);


            //FXPP-8306

            if( $account_detail ){
                $user_details = $this->user_model->getUserDetails($user_id);
                if( $user_details ){
                    //FXPP-3756 allow only standard account to have bonus
                    $webservice_config = array('server' => 'live_new');
//                    $WebService = new WebService($webservice_config);
                    $account_info = array('iLogin' => $account_detail['account_number']);
//                    $WebService->open_RequestAccountDetails($account_info);

                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

                    if ($WebService->request_status === 'RET_OK') {
//                        $old_leverage = $WebService->get_result('Leverage');//FXPP-7732
                        $old_leverage = $WebService->result['Leverage'];//FXPP-7732
//                        $ForMarStaAcc =FXPP::get_standardgroup();
                        $ForMarStaAcc = FXPP::get_standardgroup_v2($account_detail['account_number']);
                        if ($ForMarStaAcc) {
                            $isStandardAccount = true;
                        } else {
                            $isStandardAccount = false;
                        }
                    } else {
                        $isStandardAccount = false;
                    }
                    if( $isStandardAccount ){
                        $non_verified_users = $this->non_verified_bonus_validation($user_id);
                        if($user_details['nodepositbonus'] == 0){
                            $hasDeposit = $this->deposit_model->hasPercentBonusDeposit($user_id);
                            $transfer50BonusData = $this->deposit_model->getAllTransitTrasfers($account_detail['account_number']);
                            if( ($hasDeposit) || ($transfer50BonusData) ) {
                                $deposit50BonusData = $this->deposit_model->getAll50BonusDeposit($user_id);
//                                if(IPLoc::Office() && $this->session->userdata('user_id')==224740){
//                                    print_r($deposit50BonusData);exit;
//                                }

                                $total_deposit = 0;
                                $total_deposit_ITS = 0;
                                foreach($deposit50BonusData as $key => $value){
                                    $total_deposit += $value['amount'];
                                }
                                foreach($transfer50BonusData as $key => $value){
                                    $total_deposit_ITS += $value['conv_amount'];
                                }


//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account_detail['account_number']);
//                                $total_equity = $WebService2->get_result('Equity');
//                                $total_bonus_fund = $WebService2->get_result('TotalBonusFund');
//                                $total_withdraw_bonus_fund = $WebService2->get_result('Withrawable_BonusFund');
//                                $total_withdraw_real_fund = $WebService2->get_result('Withrawable_RealFund');
//                                $total_real_fund = $WebService2->get_result('TotalRealFund');

                                if(IPLoc::APIUpgradeDevIP()){

                                    $this->load->library('WSV'); //New web service
                                    $WSV = new WSV();
                                    $WebService2 = $WSV->GetAccountFunds($account_detail['account_number']);

                                    if($WebService2->request_status === "RET_OK"){
                                        $total_equity              = $WebService2->result['Equity'];
                                        $total_bonus_fund          = $WebService2->result['TotalBonusFund'];
                                        $total_withdraw_bonus_fund = $WebService2->result['Withrawable_BonusFund'];
                                        $total_withdraw_real_fund  = $WebService2->result['Withrawable_RealFund'];
                                        $total_real_fund           = $WebService2->result['TotalRealFund'];
                                    }

                                }else{

                                    $WebService2= new WebService($webservice_config);
                                    $WebService2->RequestAccountFunds($account_detail['account_number']);

                                    $total_equity              = $WebService2->get_result('Equity');
                                    $total_bonus_fund          = $WebService2->get_result('TotalBonusFund');
                                    $total_withdraw_bonus_fund = $WebService2->get_result('Withrawable_BonusFund');
                                    $total_withdraw_real_fund  = $WebService2->get_result('Withrawable_RealFund');
                                    $total_real_fund           = $WebService2->get_result('TotalRealFund');

                                }

                                if($total_real_fund > 0){
                                    $total_deposit_and_transfer = floatval($total_deposit) + floatval($total_deposit_ITS);
                                    if( $total_real_fund < $total_deposit_and_transfer ) {
                                        $bonus_sum_amount['amount'] = $total_real_fund * 0.5;
                                    }else{
                                        $bonus_sum_amount1 = $this->deposit_model->getAll50BonusDepositAmount_all($user_id);
                                        $processedAmountBy = 'Total real fund >= total deposit';
                                        if($bonus_sum_amount1 || $transfer50BonusData){
                                            $sum_amount = 0;
                                            if($bonus_sum_amount1){
                                                foreach($bonus_sum_amount1 as $a){
//                                                    if($a['transaction_type']=='BITCOIN'){
//                                                        $sum_amount = floatval($sum_amount) + floatval($a['conv_amount']);
//                                                    }else{
//                                                        $sum_amount = floatval($sum_amount) + floatval($a['amount']);
//                                                    }

                                                    $sum_amount = floatval($sum_amount) + floatval($a['amount']);
                                                }
                                            }
                                           if($transfer50BonusData){
                                               foreach($transfer50BonusData as $key => $value) {
                                                   $sum_amount = floatval($sum_amount) + floatval($value['conv_amount']);
                                               }
                                           }
                                            $bonus_sum_amount['amount'] = floatval($sum_amount) * 0.5;
                                        }
                                    }
//                                    if(IPLoc::Office() && $this->session->userdata('user_id')==224740){
//                                        print_r($deposit50BonusData);
//                                        print_r($bonus_sum_amount['amount']);exit;
//                                    }
                                    $date_bonus_acquired = date('Y-m-d H:i:s');
                                    $setDepositBonus = $this->deposit_model->setBonusFiftyBonus($user_id, 1, $date_bonus_acquired,2);
                                    $setITSBonus = $this->deposit_model->setBonusITS($account_detail['account_number'],2, $date_bonus_acquired);
                                    if (    ($setDepositBonus) || ($setITSBonus) ) {
                                        $webservice_config = array(  'server' => 'live_new' );
//                                        $WebService = new WebService($webservice_config);
                                        $account_info = array(
                                            'AccountNumber' => $account_detail['account_number'],
                                            'Amount' => $bonus_sum_amount['amount'],
                                            'Comment' => 'FOREXMART WELCOME BONUS 50%',
                                            'ProcessByIP' => $this->input->ip_address()
                                        );

//                                        if(IPLoc::APIUpgradeDevIP() || IPLoc::Office()){
                                            $webserviceResult =  FXPP::CreditBonus('BONUS_50_PERCENT', bonus_sum_amount['amount'], 'FOREXMART WELCOME BONUS 50%', $account_detail['account_number']);
                                            $reqResult   = $webserviceResult['ErrorMessage'];
                                            $bonusTicket = $webserviceResult['Data']->Ticket;
//                                        }else{
//                                            $WebService->open_Deposit_50PercentBonus($account_info);
//                                            $reqResult   = $WebService->request_status;
//                                            $bonusTicket = $WebService->get_result('Ticket');
//                                        }

                                        if( $reqResult === 'RET_OK' ) {

                                            $country = $this->account_model->getAccountsCountry($user_id);
                                           // $groupCurrency = $this->g_m->getGroupCurrency($account_detail['mt_account_set_id'], $account_detail['mt_currency_base'], $account_detail['swap_free']);
                                            $groupCurrency =  substr($account_detail['group'], 0, -1);
                                            FXPP::update_account_group();

                                            $account_number = $account_detail['account_number'];

                                            $isMicro = $this->account_model->isMicro($user_id);
                                            if($isMicro){
                                              if($country[0]['country'] == 'CN'){
                                                    $this->session->set_userdata('isChina', '1');
                                                    $groupCurrency .= 'ndb-cn1';
                                              }else {
                                                     $groupCurrency .= 'ndb1';
                                              }
                                            }else{
                                                $groupCurrency .= '-b' . $account_detail['group_code'];
                                            }

//                                            $WebService2 = new WebService($webservice_config);
//                                            $account_info2 = array(
//                                                'iLogin' => $account_number,
//                                                'strGroup' => $groupCurrency
//                                            );
//                                            $WebService2->open_ChangeAccountGroup($account_info2);

                                            $WebService2 = FXPP::SetAccountGroup($account_number, $groupCurrency);

                                            $user = $this->user_model->getUserProfileByUserId($_SESSION['user_id']);
                                            if(in_array(strtoupper($user['country']), array('PL'))){
                                                $account_info3 = array(
                                                    'iLogin' => $account_number,
                                                    'iLeverage' => '100'
                                                );
                                            }else{
                                                $account_info3 = array(
                                                    'iLogin' => $account_number,
                                                    'iLeverage' => '200'
                                                );
                                            }

//                                            $WebService3 = new WebService($webservice_config);
//                                            $WebService3->open_ChangeAccountLeverage($account_info3);

                                            $WebService3 = FXPP::SetLeverage($account_info3['iLogin'], $account_info3['iLeverage']);
                                            if($WebService3->request_statues === 'RET_OK'){
                                                $this->account_model->updateAccountLeverage($account_number, '1:' . $account_info3['iLeverage']);
                                            }

                                            $WebService4 = new WebService($webservice_config);
                                            $WebService4->request_live_account_balance($account_number);
                                            if ($WebService4->request_status === 'RET_OK') {
                                                $amount = $WebService4->get_result('Balance');
                                                $this->account_model->updateAmountByAccountNumber($account_number, $amount);
                                            }

                                            $api_data = array(
                                                'equity' => $total_equity,
                                                'bonus_fund' => $total_bonus_fund,
                                                'withdraw_bonus_fund' => $total_withdraw_bonus_fund,
                                                'withdraw_real_fund' => $total_withdraw_real_fund
                                            );

                                            $bonusArray_v1 = array(
                                                'AmountDeposited' => $total_deposit,
                                                'AmountBonus'   => $bonus_sum_amount['amount'],
                                                'DateProcessed' => $date_bonus_acquired,
                                                'UserId'    => $user_id,
                                                'AccountNumber' => $account_number,
                                                'TransactionPage' => 'bonus',
                                                'Ticket'    => $bonusTicket,
                                                'BonusType' => 'fpb',
                                                'DepositId' => 0,
                                                'BonusStatus' => 2,
                                                'APIData' => json_encode($api_data)
                                            );

                                            $this->deposit_model->insertDepositBonus($bonusArray_v1);

                                            $is_get_bonus = true;
                                            $message = '<i class="fa fa-check-circle"></i> You have successfully claimed your bonus.';
                                        }else{
                                            $message = 'Internal error on webservice.';
                                        }
                                    }
                                }else{
                                    $hasDeposit = false;
                                    $message = 'You have not made any deposits to the following account number yet: ' . $account_detail['account_number'];
                                }
                            }else{
                                    $message = 'You have not receive any transfers nor made any deposits to the following account number yet: ' . $account_detail['account_number'];
                            }
                        }else{
//                            if($user_details['accountstatus'] == 0){
//                                $hasDeposit = true;
//                                $message = 'Account is not yet verified.';
                            if($user_details['nodepositbonus'] == 1){
                                $has_no_deposit_bonus = true;
                                $message = 'You are not eligible to claim the 30% bonus on this account. To claim your 30% bonus, please create a new trading account.';
                            }
                        }
                    }else{
                        $message = 'This bonus is applicable for ForexMart Standard Account.';
                    }
                }else{
                    $message = 'Invalid user details.';
                }
            }else{
                $message = 'Invalid account details.';
            }

            //FXPP-8306

        $data = array('success' => $is_get_bonus, 'has_deposit' => $hasDeposit, 'has_no_deposit_bonus' => $has_no_deposit_bonus, 'message' => $message);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function check_ndb( $user_id )
    {
        $this->load->model('account_model');
//        if (!$this->input->is_ajax_request()) {
//            die('Not authorized!');
//        }

        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob",$order_by="");

        $_SESSION['dob']=$data['user_profiles']['dob'];


        //jira FXPP-2147 separate validation of fullname and email separate query

        $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
            $table1 = 'users',$table2 = 'user_profiles',
            $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
            $field1 = 'user_profiles.dob', $id1 = trim($_SESSION['dob']),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$user_id,
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        $data['accountemail'] = $this->g_m->showt2w3j2sEmail(
            $table1 = 'users',$table2 = 'user_profiles',
            $field1 = 'users.email', $id1 = $_SESSION['email'],
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$user_id,
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email'
        );

        $data['IsAcquiredFromOtherAccount'] = false;

        if ( $data['accountfullname']) {
            foreach ( $data['accountfullname'] as $key1 => $value1) {
                if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '' ) {

                }else if(is_null($value1['ndb_bonus'])) {

                } else {

                    $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        if ($data['accountemail']) {
            foreach ($data['accountemail'] as $key => $value) {
                if ((!isset($data['accountemail']['ndb_bonus'])) || trim($data['accountemail']['ndb_bonus']) === '' ) {
                }else if(is_null($data['accountemail']['ndb_bonus'])) {
                } else {
                    $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        //jira FXPP-1394


        //check for 1 week showing of no deposit tab
        $nodepositbonus = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $user_id, $select = 'nodepositbonus,created,createdforadvertising');

        if (is_null($nodepositbonus['createdforadvertising'])) {
            $data['datecreated'] = $nodepositbonus['created'];
        } else {
            $data['datecreated'] = $nodepositbonus['createdforadvertising'];
        }

        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));

        if ($nodepositbonus['nodepositbonus'] == 1 OR $datedifference > 7) {
            echo json_encode('failed');
            die();
        }
        //check for 1 week showing of no deposit tab


//        $this->db->trans_start();

        //default false of returns
        $data['IsStandardAccount'] = true;
        $data['Implemented'] = false;
        $data['HasError'] = false;
        $data['IsVerified'] = $data['NotNoDepositBonus'] = false;
        //default false of returns


        //get verified account and get nodepositbonus if already or not already given bonus amount field
        $prvt_data['IsVerified'] = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $user_id, $select = 'accountstatus,nodepositbonus');

        if ($data['IsAcquiredFromOtherAccount'] == false) {//  //jira FXPP-1394

            if ($prvt_data['IsVerified']['accountstatus'] == 1 and $prvt_data['IsVerified']['nodepositbonus'] == 0) {
                $data['IsVerified'] = true;
                //get amount balance in USD if available

                $prvt_data['mt_account_set'] = $this->g_m->showt1w1($table = 'mt_accounts_set', $field = 'user_id', $id = $user_id, $select = 'amount,id,mt_currency_base,mt_account_set_id,account_number,swap_free,leverage');

                //FXPP-1058 application     - allow only standard account to have bonus
                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
                $account_info = array('iLogin' => $prvt_data['mt_account_set']['account_number']);
//                $WebService->open_RequestAccountDetails($account_info);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

                if ($WebService->request_status === 'RET_OK') {
                    $ForMarStaAcc = FXPP::get_standardgroup();
                    if (in_array($WebService->result['Group'], $ForMarStaAcc)) {
                        $data['IsStandardAccount'] = true;
                    } else {
                        $data['IsStandardAccount'] = false;
                    }
                } else {
                    $data['IsStandardAccount'] = false;
                }
                //FXPP-1058 application

                //FXPP-1058
                if ($data['IsStandardAccount']) {

                    $data['mtas'] = $prvt_data['mt_account_set'];

                    //get user location bonus
                    $this->load->library('IPLoc', null);
                    $user_profiles = $this->g_m->showssingle2($table = 'user_profiles', $field = 'user_id', $id = $user_id, $select = 'country');
                    $data['bonus'] = IPLoc::bonusV2($user_profiles['country']);
//                    $webservice_config = array('server' => 'live_new');
//                    $WebService = new WebService($webservice_config);


                    if ($prvt_data['mt_account_set']['mt_currency_base'] == 'USD') {
//                        if(IPLoc::Office()){
//                            ini_set('max_execution_time', 0);
                        $this->load->model('deposit_model');

                        $no_deposit_data = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'date_request' => date('Y-m-d H:i:s'),
                            'account_number' => $prvt_data['mt_account_set']['account_number'],
                            'is_approved' => 0
                        );

//                        $request_number = $this->deposit_model->insertNoDepositRequest($no_deposit_data);
//                        if($request_number){
//                            $email_data = array(
//                                'request_number' => $request_number
//                            );
//                        }
                        $data['Implemented'] = false;
                    } else {
//                        if(IPLoc::Office()){
                        $this->load->model('deposit_model');

                        $no_deposit_data = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'date_request' => date('Y-m-d H:i:s'),
                            'account_number' => $prvt_data['mt_account_set']['account_number'],
                            'is_approved' => 0
                        );

//                        $request_number = $this->deposit_model->insertNoDepositRequest($no_deposit_data);
//                        if($request_number){
//                            $email_data = array(
//                                'request_number' => $request_number
//                            );

//                        $account_details = $this->account_model->getAccountByUserId($this->session->userdata('user_id'));
                        $data['Implemented'] = false;
                    }

                }

            } elseif ($prvt_data['IsVerified']['accountstatus'] == 1 and $prvt_data['IsVerified']['nodepositbonus'] == 1) {
                $data['Implemented'] = true;
            }
        }
//        $this->db->trans_complete();
        echo json_encode($data);

    }

    public function updatedFB(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        $user_id = $this->session->userdata('user_id');
        $fb = $this->input->post('id',true);
        $data = array('fb'=>$fb);
        $this->general_model->update("user_profiles","user_id",$user_id,$data);
    }

    public function nodepositbonus_autocrediting()
    {

        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if (!$this->session->userdata('logged')){redirect('signout');}


        $data['msg']='';
        $this->load->model('account_model');

        $data['request']=false;


        $user_id = $this->session->userdata('user_id');

        $data['user_profiles'] = $this->g_m->showssingle( $table='user_profiles',$field="user_id",$id=$user_id,$select="dob,zip",$order_by="");
        if(IPLoc::isEuropeanCountry($data['user_profiles']['country'])){
            return false;
        }

        $_SESSION['dob']=$data['user_profiles']['dob'];
        $_SESSION['zip']=$data['user_profiles']['zip'];
        //jira FXPP-2147 separate validation of fullname and email separate query
        $data['accountfullname'] = $this->g_m->showt2w3j2sFullname(
            $table1 = 'users',$table2 = 'user_profiles',
            $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
            $field1 = 'user_profiles.dob', $id1 = trim($_SESSION['dob']),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        $data['accountemail'] = $this->g_m->showt2w3j2sEmail(
            $table1 = 'users',$table2 = 'user_profiles',
            $field1 = 'users.email', $id1 = strtoupper($_SESSION['email']),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
            $join12 = 'users.id=user_profiles.user_id',
            $select = 'ndb_bonus,users.email'
        );


        $data['request'] = false;

        $data['IsAcquiredFromOtherAccount'] = false;

        if ( $data['accountfullname']) {
            foreach ( $data['accountfullname'] as $key1 => $value1) {
                if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '' ) {

                }else if(is_null($value1['ndb_bonus'])) {

                } else {
                      $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        if ($data['accountemail']) {
            foreach ($data['accountemail'] as $key => $value) {
                if ((!isset($data['accountemail']['ndb_bonus'])) || trim($data['accountemail']['ndb_bonus']) === '' ) {
                }else if(is_null($data['accountemail']['ndb_bonus'])) {
                } else {
                     $data['IsAcquiredFromOtherAccount'] = true;
                }
            }

        }

        //jira FXPP-1394

        //jira FXPP-7752
        $data['accountfullnameIP'] = $this->t_m->showt2w3j2sFullnameIP(
            $table1 = 'users',$table2 = 'user_profiles', $table3='mt_accounts_set',
            $field2 = 'user_profiles.full_name', $id2 = trim($_SESSION['full_name']),
            $field1 = 'mt_accounts_set.registration_ip', $id1 = $this->input->ip_address(),
            $field3 = 'users.ndb_bonus!=', $id3 = '',
            $field4 = 'users.id !=', $id4=$_SESSION['user_id'],
            $join12 = 'users.id=user_profiles.user_id',
            $join31 = 'mt_accounts_set.user_id=users.id',
            $select = 'ndb_bonus,users.email,user_profiles.dob'
        );

        if ($data['accountfullnameIP']) {
            foreach ( $data['accountfullnameIP'] as $key3 => $value3) {
                if ((!isset($value3['ndb_bonus'])) || trim($value3['ndb_bonus']) === '' ) {

                }else if(is_null($value3['ndb_bonus'])) {

                } else {
                    $data['IsAcquiredFromOtherAccount'] = true;
                }

            }
        }


//        $data['accountAdditionalInfo'] = $this->t_m->accountAdditionalInfo(
//            $table1 = 'users',$table2 = 'user_profiles', $table3='contacts',
//            $field1 = 'phone1', $id1 =   $_SESSION['phone1'],
//            $field2 = 'dob', $id2 = $_SESSION['dob'],
//            $field3 = 'zip', $id3 = $_SESSION['zip'],
//            $field4 = 'users.ndb_bonus!=', $id4 = '',
//            $field5 = 'users.id !=', $id5=$_SESSION['user_id'],
//            $join12 = 'user_profiles.user_id=users.id',
//            $join31 = 'contacts.user_id=users.id',
//            $select = 'ndb_bonus,users.email,user_profiles.dob'
//        );
//        if ($data['accountAdditionalInfo']) {
//            foreach ( $data['accountAdditionalInfo'] as $key4 => $value4) {
//                if ((!isset($value4['ndb_bonus'])) || trim($value4['ndb_bonus']) === '' ) {
//
//                }else if(is_null($value4['ndb_bonus'])) {
//
//                } else {
//                    $data['IsAcquiredFromOtherAccount'] = true;
//                }
//
//            }
//        }


        //check for 1 week showing of no deposit tab
        $nodepositbonus = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $user_id, $select = 'nodepositbonus,created,createdforadvertising,is_bonuscontestmfprize,is_showfxbonus');

        if (is_null($nodepositbonus['createdforadvertising'])) {
            $data['datecreated'] = $nodepositbonus['created'];
        } else {
            $data['datecreated'] = $nodepositbonus['createdforadvertising'];
        }

        $datecreated = DateTime::createFromFormat('Y-m-d H:i:s', $data['datecreated']);
        $datedifference = $this->g_m->difference_day($datecreated->format('Y-m-d'), $datecurrent = date('Y-m-d'));

        //check for 1 week showing of no deposit tab

        //default false of returns
        $data['IsStandardAccount'] = true;
        $data['Implemented'] = false;
        $data['HasError'] = false;
        $data['IsVerified'] =  false;
        $data['NotNoDepositBonus'] = false;
        //default false of returns

        $account_details = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$user_id,$select='mt_account_set_id');
        //FXPP-1674 Implement logic of removing the NDB tab if the client has already made his first deposit in FXPP
        $deposit = $this->g_m->showssingle3($table='deposit',$field="user_id",$id=$_SESSION['user_id'],$field2="status",$id2=2,$select="*",$order_by="");
        //get verified account and get nodepositbonus if already or not already given bonus amount field
        $prvt_data['IsVerified'] = $this->g_m->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'accountstatus,nodepositbonus');
        $webservice_config = array('server' => 'live_new');
//        $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => $_SESSION['account_number']);
//        $WebService->open_RequestAccountDetails($account_info);

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

        if ($WebService->request_status === 'RET_OK') {
//            $ForMarStaAcc = FXPP::get_standardgroup();
            $ForMarStaAcc = FXPP::get_standardgroup_for_ndb($_SESSION['account_number']);

            if ($ForMarStaAcc) {
                $data['IsStandardAccount'] = true;
            } else {
                $data['msg'].='This account is not a standard account.';
                $data['IsStandardAccount'] = false;
            }


//            if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
//                $data['IsStandardAccount'] = true;
//            } else {
//                $data['msg'].='This account is not a standard account.';
//                $data['IsStandardAccount'] = false;
//            }
        } else {
            $data['IsStandardAccount'] = false;
        }

        $data['data']['prohibit']=false;

        /*FXPP-7759 Get special referral affiliate code that restrict user accounts*/
        $aff_code = $this->t_m->getspecialaffiliatecode();
        if($aff_code){
            $affiliate_array=array();
            foreach($aff_code as $aff_key => $aff_value){
                array_push($affiliate_array,$aff_value['affiliate_code']);
            }
            $user_ref_code = $this->t_m->getreferralcode($_SESSION['user_id']);
            if($user_ref_code){
                if (in_array($user_ref_code[0]['referral_affiliate_code'], $affiliate_array)) {
                    $data['data']['prohibit']=true;
                }else{
                    $data['data']['prohibit']=false;
                }
            }

        }
        /* FXPP-7759 Get special referral affiliate code that restrict user accounts*/

        /*Not related with Crediting but is necessary for process start*/
        /*moved removal of agent before the library*/
        $agentremovalvalidation = false;
        $account_number = $_SESSION['account_number'];

        $getAccountAgent = FXPP::GetAccountAgent($account_number);
        $remove_agent_data = array(
            'api_status' => 0,
            'date_removed' => FXPP::getCurrentDateTime(),
            'account_number' => $account_number,
            'agent_account_number' => $getAccountAgent,
            'isRemoved' => 0,
        );

        if($getAccountAgent=='error'){
            $mydata['removeagent'] = array(
                'removeagent_log'=>4
            );
            $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);
            $agentremovalvalidation = false;

        }elseif($getAccountAgent!=false and $getAccountAgent!='error'){

            $webservice_config = array('server' => 'live_new');
            $WebServiceRemove = new WebService($webservice_config);
//            $WebServiceRemove->RemoveAgentOfAccount($account_number);

            if(IPLoc::APIUpgradeDevIP()){
                $this->load->library('WSV'); //New web service
                $WSV = new WSV();

                $param = array(
                    "AccountNumber" => $account_number
                );
                $WebServiceRemove = $WSV->SetAccountDetail($param, "RemoveAgentAccount");
            }else{
                $WebServiceRemove->RemoveAgentOfAccount($account_number);
            }

            if ($WebServiceRemove->request_status === 'RET_OK') {
                $remove_agent_data['api_status'] = $WebServiceRemove->request_status;
                $remove_agent_data['isRemoved'] = 1;

                $removeData = array(
                    'AccountNumber' => $account_number,
                    'AgentAccountNumber' => $getAccountAgent,
                    'DateRemoved' => FXPP::getCurrentDateTime()
                );
                $this->general_model->insertmy($table = "removed_agents",$removeData);

                $mydata['removeagent'] = array(
                    'removeagent_log'=>1
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);

                $getAccountAgent2 = FXPP::GetAccountAgent($account_number);

                if($getAccountAgent2===false){
                    $agentremovalvalidation = true;
                    $mydata['removeagent']['removeagent_log'] = 1;
                    $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);
                }else{
                    $mydata['removeagent']['removeagent_log'] = 7;
                    $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);
                }


            }else{
                $remove_agent_data['api_status'] = $WebServiceRemove->request_status;
                $remove_agent_data['isRemoved'] = 2;

                $agentremovalvalidation = false;
                $mydata['removeagent'] = array(
                    'removeagent_log'=>2
                );
                $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);
            }

        }elseif($getAccountAgent==false){
            $remove_agent_data['isRemoved'] = 3; // no agent set
            $agentremovalvalidation = true;
            $mydata['removeagent']  = array(
                'removeagent_log'=>3
            );
            $this->general_model->updatemy($table = 'users', $field = 'id', $id = $id = $_SESSION['user_id'], $mydata['removeagent']);
        }
        /*moved removal of agent before the library*/
        /*Not related with Crediting but is necessary for process end*/

        //save agent log
        $this->general_model->insertmy($table = "remove_agent_log",$remove_agent_data);

        if (
            ($nodepositbonus['nodepositbonus'] == 0) &&
            ($data['data']['has_rqstd_ndb']==false ) &&
            ($data['IsStandardAccount']==true) &&
            ($datedifference <= 7) &&
            ($account_details['mt_account_set_id'] == 1) &&
            ($deposit==false) &&
            ($data['IsAcquiredFromOtherAccount'] == false) &&
            ($data['data']['prohibit']==false &&
            $agentremovalvalidation==true) &&
            ($nodepositbonus['is_bonuscontestmfprize']==0) &&
            ($nodepositbonus['is_showfxbonus']==0)
        )
        {
            $data['mtas'] = $prvt_data['mt_account_set'];
            $data['request']=true;

            /* Implement Library Crediting Nodeposit bonus automatically */
            $this->load->library('Bonus_Library');
            $FXPP6539 = Bonus_Library::getScoring();
            $bonus = $FXPP6539['bonus'];
            $data['arr'] = Bonus_Library::creditNDB($bonus);
//            $data['request'] = $data['arr']['request'];
            $data['request1'] = $data['arr']['WS1'];
            $data['request2'] = $data['arr']['WS2'];
            $data['request3'] = $data['arr']['WS3'];

            $data['data']['valid_for_nodepositbonus'] = true;
        }else{
            $data['data']['valid_for_nodepositbonus'] = false;
            $data['Implemented'] = true;
             $data['request']=false;
        }
        echo json_encode($data);
    }

    public function testbonusstatistics(){
              error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('memory_limit', '-1');
            $userId = 188182;
            $this->load->model('account_model');

            $accountsByUserIdRow = $this->account_model->getAccountsByUserIdRow($userId);

            $account_number = $accountsByUserIdRow['account_number'];
            FXPP::allowedBonuses($account_number);
            $getAccountSummaryDetails= self::getAccountSummaryDetailstest($account_number);
            
            $getBonusId = self::getBonusId($account_number);
            $data['accountSummaryDetails'] = $getAccountSummaryDetails;

            $getLotsTrade = self::getLotsTrade2($account_number,$getBonusId);
            $data['lotsTradeData'] = $getLotsTrade;
            $data['currency'] = $accountsByUserIdRow['mt_currency_base'];
            $this->load->model('deposit_model');

                $bonusPercent = ($getBonusId == 1) ? 0.3 : 0.5;
                $data['TotalDepositClaimedBonus'] = $getAccountSummaryDetails['Total_Bonus'] ;
                $necessaryNumberofLots =   $getAccountSummaryDetails['Total_Bonus'] * $bonusPercent;

            $data['necessaryNumberofLots'] = number_format($necessaryNumberofLots, 2);

                $webservice_config = array(
                    'server' => 'live_new'
                );
//                $WebService= new WebService($webservice_config);
//                $WebService->RequestAccountFunds($account_number);
//                $serviceResultBalance = $WebService->get_all_result();

                if(IPLoc::APIUpgradeDevIP()){

                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService2 = $WSV->GetAccountFunds($account_number);

                    if($WebService2->request_status === "RET_OK"){
                        $serviceResultBalance = $WebService2->result;
                    }

                }else{

                    $WebService2= new WebService($webservice_config);
                    $WebService2->RequestAccountFunds($account_number);

                    $serviceResultBalance = $WebService2->get_all_result();

                }

                $data['balanceExpand'] = $serviceResultBalance;

            $lotstoTrade = $necessaryNumberofLots - $getLotsTrade;

            if($lotstoTrade < 0){
                $lotstoTrade = 0;
            }

            if($lotstoTrade > 0){
                $bonus_status = lang('bon_aval_2');
            }else{
                $bonus_status = lang('bon_aval_1');
            }

            $data['lotstoTradeData'] = number_format($lotstoTrade, 2);
            $data['bonus_status'] = $bonus_status;

            $allowedBonuses = FXPP::allowedBonuses($account_number);
            $data['displayBonusStatistics'] = $allowedBonuses;

            $data['account_number'] = $account_number;
            $data['title_page'] = lang('sb_li_3');
            $data['active_tab'] = 'bonus';
            $data['active_sub_tab'] = 'bonuses_statistic';
            $js = $this->template->Js();
            $data['metadata_description'] = lang('bon_sta_dsc');
            $data['metadata_keyword'] = lang('bon_sta_kew');

            print_r($data);
    }
    public function non_verified_bonus_validation($user_id){
        /*FXPP-8259*/
        /*rule1: 30% and 50% Bonus claiming is enabled for non-verified accounts in the span of 15 days upon registration*/
        /*rule2: To enable 30% and 50% Bonus claiming even after 15 days for non-verified, account should have a balance of exactly 2000 EUR or equivalent before 15 days exception of deposit rule for non-verified ends*/
        $data['mt'] = $this->general_model->showssingle($table = 'mt_accounts_set', $id = 'user_id', $field = $user_id, $select = '*');
        $data['count_status'] = $this->general_model->getCountVerifyStatus($this->session->userdata('user_id'));
        $EUR_balance = $this->getBalance($data['mt']['mt_currency_base']);
        if($data['count_status']){
            return false;
        }else if($EUR_balance==2000){
            return false;
        }else{
            return 'To continue claiming 20% or 30% or 50% bonus, please acquire a balance amounting to 2000 EUR or equivalent within 15 days upon registration. Please verify your account <a href="'.FXPP::my_url('profile/upload-documents').'">here</a>.';
        }
    }
    public function getBalance($currency) {
        $this->load->model('account_model');
        $getAccountNumber = $this->account_model->getAccountNumber($this->session->userdata("user_id"));
        $account_info = array('iLogin' => $getAccountNumber['account_number']);
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountBalance($account_info);
        switch ($WebService->request_status) {
            case 'RET_OK':
                $data['balance'] = $this->roundno(floatval($WebService->get_result('Balance')), 2);
                break;
            default:
                $data['balance'] = $this->roundno(floatval(0), 2);
        }
        $conv_amount_usd = $this->get_convert_amount($currency, $data['balance']);
        $conv_amount = $this->get_convert_amount(trim($currency), $data['balance'], trim('EUR'));
        return $conv_amount;
    }
    private function roundno($number, $dp) {
        return number_format((float) $number, $dp, '.', '');
    }
    private function get_convert_amount($currency, $amount, $to_currency = 'USD') {
        if ($currency == $to_currency) {
            $conv_amount = $amount;
        } else {
            $converter_config = array(
                'server' => 'converter'
            );
            $WebService = new WebService($converter_config);
            $data = array(
                'Amount' => $amount,
                'FromCurrency' => $currency,
                'ToCurrency' => $to_currency,
                'ServiceLogin' => '505641',
                'ServicePassword' => '5fX#p8D^c89bQ'
            );

            $ConvertCurrency = $WebService->ConvertCurrency($data);
            $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
            if ($resultConvertCurrency['Status'] === 'RET_OK') {
                $converted_amount = $resultConvertCurrency['ToAmount'];
                $conv_amount = $converted_amount;
            } else {
                $conv_amount = $amount;
            }
        }

        return $conv_amount;
    }




    public function ProcessBonus($accountNumber, $bonusID){
        $returnData = array(
            'error' => false,
            'errorMsg' => '',
            'amount' => 0,
        );

        $accountFunds = FXPP::getAccountFunds($accountNumber);
        if($accountFunds['withrawableRealFund'] > 0) {
            $real_bonus_fund = round($accountFunds['withrawableRealFund'] * $this->bonusPercent[$bonusID], 2);
            if ($real_bonus_fund > $accountFunds['bonusFund']) {
                $amount = abs($accountFunds['bonusFund'] - $real_bonus_fund); //credit additional bonus
                $returnData['amount'] = $amount;
            } else {
                $returnData['amount'] = 0;
                $returnData['errorMsg'] = 'You have already received welcome bonus on your latest deposit';
                $returnData['error'] = true;
            }
        }

        
            FXPP::CI()->load->model('Logs_model');
            $logData = array(
                'account_number' => isset($accountNumber) ? $accountNumber : 0,
                'method' => 'GetAccountFunds',
                'request_data' => json_encode($accountFunds),
                'status' => $accountFunds['status'],
                'date' => FXPP::getCurrentDateTime()
            );

            FXPP::CI()->Logs_model->insert_log($table = "api_method_log", $logData);


        return $returnData;



    }

    public function checkAccountBonusAttempt(){
        if(IPLoc::Office()){
            $details = $this->General_model->showssingle2($table='Bonus_logs',$field='user_id',$id=231516,$select='*');
            echo "<pre>";
            print_r($details);
        }
    }

    public function testNewAPI($account_number){

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();

        $webservice_config = array(
            'server' => 'live'
        );

        $WebService  = $WSV->GetAccountFunds(
            $account_number,
            $webservice_config
        );

        var_dump($WebService);

    }

    public function test(){

        $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => $_SESSION['account_number']);
//                $WebService->open_RequestAccountDetails($account_info);

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();

        $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);

        var_dump($WebService);

    }

}
?>