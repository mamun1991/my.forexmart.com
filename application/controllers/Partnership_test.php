<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Partnership_test extends MY_Controller
{
    private $isCPA = false;

    public function __construct()
    {
        parent::__construct();


        if(!IPLoc::Banned()){
            $this->load->model('partners_model');
            $this->load->library('IPLoc', null);
            $user_id = $this->session->userdata('user_id');
            $isPAS = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $this->session->set_userdata('cpa',$isPAS);
            $this->isCPA = $this->partners_model->isCPA($user_id);
            $this->lang->load('partnership');
            $this->lang->load('its');
            $this->load->model('General_model');
            $this->load->model('account_model');
            $this->g_m=$this->General_model;
            $this->load->model('user_model');
        }else{

            show_404();
        }

       
    }

    public function index(){


        if( FXPP::isMicro($this->session->userdata('user_id'))){ redirect('partnership/affiliate-umbrella');}

        if($this->isCPA){

            redirect(FXPP::my_url('partnership/cpa'));
        }else{
            redirect(FXPP::my_url('partnership/commission'));
        }

    }

    public function commission_(){
        if($this->session->userdata('logged') && IPLoc::Office()) {
            $user_id = $this->session->userdata('user_id');

            if($this->isCPA){
                redirect(FXPP::my_url('partnership/cpa'));
            }

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

           // $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;

            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'commission';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $webservice_config = array('server' => 'live_new');
            $from = DateTime::createFromFormat('Y/d/m', '2015/05/05');
            $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m H:i:s'));
//            $ac = $this->general_model->showssingle2($table='mt_accounts_set','user_id',$id=$this->session->userdata('user_id'),'account_number');
            $ac = $this->account_model->getAccountNumberByUserId( $user_id );
            $data['data']['accountnumber']=$ac['account_number'];
            $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;

            $account_info2 = array(
                'iLogin' => $ac['account_number'],
//                 'iLogin' =>'108326',
                'from' =>$from->format('Y-m-d\TH:i:s') ,
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
            // echo "<pre>";
            //  print_r($account_info2);
            $WebService = new WebService($webservice_config);
            $WebService->GetAgentsCommissionByDate($account_info2);


            switch($WebService->request_status){
                case 'RET_OK':
                    $CommisionList =  $WebService->get_result('CommisionList');
                    $data['commisionList'] = isset($CommisionList->CommissionData)?$CommisionList->CommissionData:false;

                    break;
                default:
                    $data['error']=true;
            }

            $js = $this->template->Js();
            $data['metadata_description'] = lang('com_dsc');
            $data['metadata_keyword'] = lang('com_kew');
            $this->template->title(lang('com_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/commission', $data);
        }else{
            redirect('signout');
        }
    }

    public function commission(){
         $this->output->cache(5);
        ini_set('max_execution_time', 0);
        if( FXPP::isMicro($this->session->userdata('user_id'))){ redirect('partnership/affiliate-umbrella');}
        if($this->session->userdata('logged')) {


            if( $_SERVER['REMOTE_ADDR']!=='49.12.5.139') {

                $this->load->model('partners_model');
                $this->load->model('account_model');
                $this->load->model('General_model');
                $this->g_m = $this->General_model;

                $user_id = $this->session->userdata('user_id');

//            if(IPLoc::Office() && $user_id==102342){
//                if($this->isCPA){
//                    redirect(FXPP::my_url('partnership/cpa'));
//                }
//
//                if($this->isCPA){
//                    redirect(FXPP::my_url('partnership/cpa'));
//                }
//
//                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
//                if($sub_partner){
//                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
//                }else{
//                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
//                }
//
//                $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
//                $data['isCPA'] = $this->isCPA;
//
//                $data['title_page'] = lang('sb_li_4');
//                $data['active_tab'] = 'partnership';
//                $data['active_sub_tab'] = 'commission';
//
//                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
//
//                $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
//                $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
//
//                $ac = $this->account_model->getAccountNumberByUserId( $user_id );
//
//
//                $data['data']['accountnumber']=$ac['account_number'];
//                $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;
//                $accountnumbers = $ac['account_number'];
//               // $accountnumbers = 115257;
//                //$accountnumbers = 101890;
//
////                $data['current'] = date("2016-09-01 h:i:s");
////                $data['current1'] = date("2016-09-30 h:i:s");
//                $data['current'] = date("2015-05-05 h:i:s");
//                $data['current1'] = date("2016-12-19 h:i:s");
//                $from = date('Y-m-d\T00:00:00', strtotime($data['current']));
//                $to = date('Y-m-d\T23:59:59', strtotime($data['current1']));
//                $account_info2 = array(
//                    'iLogin' =>$accountnumbers,
//                    'from' =>$from,
//                    'to' =>  $to
//                );
//
//
////                $account_info2 = array(
////                    'iLogin' =>$accountnumbers,
////                    'from' =>$from->format('Y-m-d\TH:i:s') ,
////                    'to' =>  $to->format('Y-m-d\TH:i:s')
////                );
//
//
//                //$getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);
//                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
//                $WebService->GetAgentsCommissionByDate($account_info2);
//
//                if($WebService->request_status === 'RET_OK'){
//                    $CommisionList =  $WebService->get_result('CommisionList');
//                    $countCommissionList = (array) $CommisionList;
//                    $am = 0;
//                    foreach ($countCommissionList['CommissionData'] as $a){
//                        $am = $am + $a->Amount;
//                    }
//                }
////                echo "<pre>";
////                print_r($account_info2);
////                echo "<br>";
////                print_r($am);
////                echo "<br>";
////                //print_r($getCommissionData);
////                print_r($countCommissionList);
////                exit;
//
//                $data['getCommissionData'] = $getCommissionData;


//           }else{

                if ($this->isCPA) {
                    redirect(FXPP::my_url('partnership/cpa'));
                }

                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if ($sub_partner) {
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                } else {
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                }


//                $bdUser=$this->partners_model->isBdcountry($user_id);
//                $data['bdUser'] = $bdUser;


                $isReqforCode = $this->partners_model->isReqaffcode($user_id);
                $data['isReqforCode'] = $isReqforCode;

                $isApprovedRecCode = $this->partners_model->isApprovedReqCode($user_id);
                $data['isApprovedRecCode'] = $isApprovedRecCode;


              //  $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['isCPA'] = $this->isCPA;

                $data['title_page'] = lang('sb_li_4');
                $data['active_tab'] = 'partnership';
                $data['active_sub_tab'] = 'commission';

                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
                $dataobj['from'] = DateTime::createFromFormat('Y/d/m', date('Y/d/m', strtotime("- 1 day")));
                $dataobj['from']->setTime(00, 00, 01);
//                $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
                $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');

                $ac = $this->account_model->getAccountNumberByUserId($user_id);


                $data['data']['accountnumber'] = $ac['account_number'];
                $data['opt'] = $this->input->get('opt', true); // for Cumulative option select;
                $accountnumbers = $ac['account_number'];


                if (($this->session->userdata('user_id') == 102342) && (IPLoc::Office())) {

                    $account_info2 = array(
                        'iLogin' => 241800,
                        'from' => $dataobj['from']->format('Y-m-d\TH:i:s'),
                        'to' => $to->format('Y-m-d\TH:i:s')
                    );

                } else {

                    if (IPLoc::Office()) {

                        $webservice_config = array('server' => 'live_new');
                        $account_info = array('iLogin' => $accountnumbers);
                        $WSAD = new WebService($webservice_config);
                        $WSAD->open_RequestAccountDetails($account_info);
                        if ($WSAD->request_status === 'RET_OK') {
                            $account_info2 = array(
                                'iLogin' => $accountnumbers,
//                                 'from' => $WSAD->get_result('RegDate') ,
                                'from' => $dataobj['from']->format('Y-m-d\TH:i:s'),
                                'to' => $to->format('Y-m-d\TH:i:s')
                            );
                        }

                    } else {

                        $account_info2 = array(
                            'iLogin' => $accountnumbers,
                            'from' => $dataobj['from']->format('Y-m-d\TH:i:s'),
                            'to' => $to->format('Y-m-d\TH:i:s')
                        );

                    }

                }


                //if (false) {

                    $getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);

                    $data['getCommissionData'] = $getCommissionData;
                //}


                //FXPP-2479
                $data['user_id'] = $this->session->userdata('user_id');
                $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');

                $data['partner_agreement'] = 0;
                if ($data['users']) {
                    if ($data['users']['partner_agreement'] == 1) {
                        $data['partner_agreement'] = 1;
                    }
                }
                //FXPP-2479
//            }


                $user_id = $this->session->userdata('user_id');
                $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
                $this->session->set_userdata(array('image' => $image));



                $js = $this->template->Js();
                $data['metadata_description'] = lang('com_dsc');
                $data['metadata_keyword'] = lang('com_kew');
                $this->template->title(lang('com_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                        <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 ")
                    ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='" . $this->template->Js() . "Moment.js'></script>
                         <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                      <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                      <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                    ->set_layout('internal/main')
                    ->build('partnership/commission', $data);


            }else{
                $this->newCommission();
            }
        }else{
            if($_GET['login'] == 'partner'){
                if($_SESSION['url']){
                    unset($_SESSION['url']);
                }
                $_SESSION['url'] = 'partnership/commission';
                redirect('partner/signin');
            }
            redirect('signout');
        }

    }

    public function commissionchart(){
        ini_set('max_execution_time', 0);
        if( FXPP::isMicro($this->session->userdata('user_id'))){ redirect('partnership/affiliate-umbrella');}
        if($this->session->userdata('logged')) {

            $this->load->model('partners_model');
            $this->load->model('account_model');
            $this->load->model('General_model');
            $this->g_m=$this->General_model;

            $user_id = $this->session->userdata('user_id');

//            if(IPLoc::Office() && $user_id==102342){
//                if($this->isCPA){
//                    redirect(FXPP::my_url('partnership/cpa'));
//                }
//
//                if($this->isCPA){
//                    redirect(FXPP::my_url('partnership/cpa'));
//                }
//
//                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
//                if($sub_partner){
//                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
//                }else{
//                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
//                }
//
//                $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
//                $data['isCPA'] = $this->isCPA;
//
//                $data['title_page'] = lang('sb_li_4');
//                $data['active_tab'] = 'partnership';
//                $data['active_sub_tab'] = 'commission';
//
//                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
//
//                $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
//                $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');
//
//                $ac = $this->account_model->getAccountNumberByUserId( $user_id );
//
//
//                $data['data']['accountnumber']=$ac['account_number'];
//                $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;
//                $accountnumbers = $ac['account_number'];
//               // $accountnumbers = 115257;
//                //$accountnumbers = 101890;
//
////                $data['current'] = date("2016-09-01 h:i:s");
////                $data['current1'] = date("2016-09-30 h:i:s");
//                $data['current'] = date("2015-05-05 h:i:s");
//                $data['current1'] = date("2016-12-19 h:i:s");
//                $from = date('Y-m-d\T00:00:00', strtotime($data['current']));
//                $to = date('Y-m-d\T23:59:59', strtotime($data['current1']));
//                $account_info2 = array(
//                    'iLogin' =>$accountnumbers,
//                    'from' =>$from,
//                    'to' =>  $to
//                );
//
//
////                $account_info2 = array(
////                    'iLogin' =>$accountnumbers,
////                    'from' =>$from->format('Y-m-d\TH:i:s') ,
////                    'to' =>  $to->format('Y-m-d\TH:i:s')
////                );
//
//
//                //$getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);
//                $webservice_config = array('server' => 'live_new');
//                $WebService = new WebService($webservice_config);
//                $WebService->GetAgentsCommissionByDate($account_info2);
//
//                if($WebService->request_status === 'RET_OK'){
//                    $CommisionList =  $WebService->get_result('CommisionList');
//                    $countCommissionList = (array) $CommisionList;
//                    $am = 0;
//                    foreach ($countCommissionList['CommissionData'] as $a){
//                        $am = $am + $a->Amount;
//                    }
//                }
////                echo "<pre>";
////                print_r($account_info2);
////                echo "<br>";
////                print_r($am);
////                echo "<br>";
////                //print_r($getCommissionData);
////                print_r($countCommissionList);
////                exit;
//
//                $data['getCommissionData'] = $getCommissionData;



//           }else{

                if($this->isCPA){
                    redirect(FXPP::my_url('partnership/cpa'));
                }

                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if($sub_partner){
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                }else{
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                }


//                $bdUser=$this->partners_model->isBdcountry($user_id);
//                $data['bdUser'] = $bdUser;


                $isReqforCode=$this->partners_model->isReqaffcode($user_id);
                $data['isReqforCode'] = $isReqforCode;

                $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
                $data['isApprovedRecCode'] = $isApprovedRecCode;






              //  $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['isCPA'] = $this->isCPA;

                $data['title_page'] = lang('sb_li_4');
                $data['active_tab'] = 'partnership';
                $data['active_sub_tab'] = 'commission';

                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
                $data['from']= DateTime::createFromFormat('Y/d/m',  date('Y/d/m',strtotime("- 1 month")));
                $data['from']->setTime(00,00,01);
//                $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
                $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');

                $ac = $this->account_model->getAccountNumberByUserId( $user_id );


                $data['data']['accountnumber']=$ac['account_number'];
                $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;
                $accountnumbers = $ac['account_number'];

                if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
                    $account_info2 = array(
                        'iLogin' =>241800,
                        'from' =>$data['from']->format('Y-m-d\TH:i:s') ,
                        'to' =>  $to->format('Y-m-d\TH:i:s')
                    );

                }else{

                     if (IPLoc::Office()){

                         $webservice_config = array('server' => 'live_new');
                         $account_info = array('iLogin' => $accountnumbers);
                         $WSAD = new WebService($webservice_config);
                         $WSAD->open_RequestAccountDetails($account_info);
                         if ($WSAD->request_status === 'RET_OK') {
                             $account_info2 = array(
                                 'iLogin' =>$accountnumbers,
//                                 'from' => $WSAD->get_result('RegDate') ,
                                 'from' =>$data['from']->format('Y-m-d\TH:i:s'),
                                 'to' =>  $to->format('Y-m-d\TH:i:s')
                             );
                         }

                     }else{

                         $account_info2 = array(
                             'iLogin' =>$accountnumbers,
                             'from' =>$data['from']->format('Y-m-d\TH:i:s') ,
                             'to' =>  $to->format('Y-m-d\TH:i:s')
                         );

                     }

                }


            if(false){
                $getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);

                $data['getCommissionData'] = $getCommissionData;
            }






                //FXPP-2479
                $data['user_id'] = $this->session->userdata('user_id');
                $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');

                $data['partner_agreement']=0;
                if($data['users']){
                    if($data['users']['partner_agreement']==1){
                        $data['partner_agreement']=1;
                    }
                }
                //FXPP-2479
//            }


            $js = $this->template->Js();
            $data['metadata_description'] = lang('com_dsc');
            $data['metadata_keyword'] = lang('com_kew');
            $this->template->title(lang('com_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                        <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('partnership/commissionchart', $data);
        }else{
            if($_GET['login'] == 'partner'){
                if($_SESSION['url']){
                    unset($_SESSION['url']);
                }
                $_SESSION['url'] = 'partnership/commissionchart';
                redirect('partner/signin');
            }
            redirect('signout');
        }

    }

    public function getCommission(){
       set_time_limit(0);
        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId( $user_id );
        $account_number = $ac['account_number'];

        $date_from = $this->input->post('from',true);
        $date_to = $this->input->post('to',true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from.' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to.' 23:59:59');


        $accountnumbers = $ac['account_number'];
        if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
            $account_info = array(
                'iLogin' => 241800,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
            print_r($account_info);
        }else{
            $account_info = array(
                'iLogin' => $accountnumbers,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
        }


        $opt = $this->input->post('cumulative',true);

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);

        $html_commission = '';

//        if($WebService->request_status === 'RET_OK'){
            $CommisionList =  $WebService->get_result('CommisionList');
            $CommissionData = json_encode($CommisionList->CommissionData);
            $CommisionListRecord = json_decode($CommissionData, true);

            $chartCommission = array();
            $val=0;
            $totalCommission = 0;
            if(is_array($CommisionListRecord)){

                foreach($CommisionListRecord as $d){
                    $datetime = strtotime($d['Date']) * 1000;
                    if($opt=='no'){
                        $val = $d['Amount'];
                    }else{
                        $val = $val + $d['Amount'];
                    }
                    $chartCommission[] = array($datetime, (float) $val);

                    $totalCommission = $totalCommission + $d['Amount'];
                }


                if(is_array($CommisionListRecord)){
                    foreach($CommisionListRecord as $d){
                        $html_commission .= "<tr> <td>".$d['Date']."</td><td>".$d['Amount']."</td><td>". $d['FromAccount']."</td><td>". $d['Symbol']."</td></tr>";
                    }
                }else{
                    $html_commission .= '<tr> <td colspan="4" class="center testa">'.lang('com_05').'.</td> </tr>';
                }

            }else{
                $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);
                $html_commission .= '<tr> <td colspan="4" class="center testb">'.lang('com_05').'.</td> </tr>';
            }
//        }else{
//            $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);
//            $html_commission .= '<tr> <td colspan="4" class="center testc">'.lang('com_05').'.</td> </tr>';
//        }
        if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
            print_r($totalCommission);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission,'account_number'=>$accountnumbers,'account_info'=>$account_info)));

    }

    public function getCommissionchart(){
       set_time_limit(0);
        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId( $user_id );
        $account_number = $ac['account_number'];

        $date_from = $this->input->post('from',true);
        $date_to = $this->input->post('to',true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from.' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to.' 23:59:59');


        $accountnumbers = $ac['account_number'];
        if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
            $account_info = array(
                'iLogin' => 241800,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
        }else{
            $account_info = array(
                'iLogin' => $accountnumbers,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
        }


        $opt = $this->input->post('cumulative',true);

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);

        $html_commission = '';

            $CommisionList =  $WebService->get_result('CommisionList');
            $CommissionData = json_encode($CommisionList->CommissionData);
            $CommisionListRecord = json_decode($CommissionData, true);

            $chartCommission = array();
            $val=0;
            $totalCommission = 0;
            if(is_array($CommisionListRecord)){

                foreach($CommisionListRecord as $d){
                    $datetime = strtotime($d['Date']) * 1000;
                    if($opt=='no'){
                        $val = $d['Amount'];
                    }else{
                        $val = $val + $d['Amount'];
                    }
                    $chartCommission[] = array($datetime, (float) $val);

                    //$totalCommission = $totalCommission + $d['Amount'];
                }

            }else{
                $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);
            }
        if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission)));

    }

    public function getCommission_v2(){
        set_time_limit(0);
        $this->benchmark->mark('t1');
        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId( $user_id );
        $account_number = $ac['account_number'];

        $date_from = $this->input->post('from',true);
        $date_to = $this->input->post('to',true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from.' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to.' 23:59:59');


        $accountnumbers = $ac['account_number'];
        if( IPLoc::Office() ){
            $account_info = array(
                'iLogin' => $accountnumbers,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );

        }else{
            $account_info = array(
                'iLogin' => $accountnumbers,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
        }


        $opt = $this->input->post('cumulative',true);
        $this->benchmark->mark('t2');
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommssionByDateForChart($account_info);
        $this->benchmark->mark('t3');
        $html_commission = '';
        $CommisionList =  $WebService->get_result('CommissionList');

        $CommissionData = $CommisionList->CommissionDataForChart;
        $this->benchmark->mark('t4');
        $chartCommission = array();
        $val=0;
        $totalCommission = 0;
        if(is_array($CommissionData)){

            foreach($CommissionData as $d){
                $datetime = strtotime($d->Date) * 1000;
                if($opt=='no'){
                    $val = $d->Amount;
                }else{
                    $val = $val + $d->Amount;
                }
                $chartCommission[] = array($datetime, (float) $val);

                $totalCommission = $totalCommission + $d->Amount;
            }



        }else{
            $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);

        }
        $this->benchmark->mark('t5');

        $html_commission = "t1-t2 = ".$this->benchmark->elapsed_time('t1', 't2')."  t2-t3=".$this->benchmark->elapsed_time('t2', 't3')."  t3-t4=".$this->benchmark->elapsed_time('t3', 't4')." t4-t5=".$this->benchmark->elapsed_time('t4', 't5');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission,'account_number'=>$accountnumbers,'account_info'=>$account_info)));

    }
    public function getCommission_v3(){
        ini_set("soap.wsdl_cache_enabled", "0");
        $dateFrom = FXPP::unixTime($this->input->post('from',true).' 00:00:00');
        $dateTo =  FXPP::unixTime($this->input->post('to',true).' 23:59:59');

        $account = $_SESSION['account_number'];
        $chartCommission = array();
        $opt = $this->input->post('cumulative',true);
        $this->load->library('WSV');
        $WSV = new WSV();
        $serviceData = array('From' => $dateFrom,'To'=>$dateTo,'AccountNumber' => $account );
        $requestResult = $WSV->GetCommissionHistory($serviceData);
        $commissionData = $requestResult['Data']->Transactions->TradeRecord;

        $totalCommission = 0;
        $val = 0;
        $html_commission = '';


        foreach($commissionData as $d){
            $datetime = $d->CloseTime * 1000;
            if($opt=='no'){
                $val = $d->Profit;
            }else{
                $val = $val + $d->Profit;
            }
            $chartCommission[] = array($datetime, (float) $val);

            $totalCommission = $totalCommission + $d->Profit;
        }



        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission,'account_number'=>$accountnumbers)));

    }
    public function getCommission_v4(){
        ini_set("soap.wsdl_cache_enabled", "0");
        $dateFrom = FXPP::unixTime($this->input->post('from',true).' 00:00:00');
        $dateTo =  FXPP::unixTime($this->input->post('to',true).' 23:59:59');

        $account = $_SESSION['account_number'];
        $chartCommission = array();
        $opt = $this->input->post('cumulative',true);
        $this->load->library('WSV');
        $WSV = new WSV();
        $serviceData = array('From' => $dateFrom,'To'=>$dateTo,'AccountNumber' => 0 );
        $requestResult = $WSV->GetCommissionHistory($serviceData);
        $commissionData = $requestResult['Data']->Transactions->TradeRecord;

        $totalCommission = 0;
        $val = 0;
        $html_commission = '';


        foreach($commissionData as $d){
            $datetime = $d->CloseTime * 1000;
            if($opt=='no'){
                $val = $d->CommissionAgent;
            }else{
                $val = $val + $d->CommissionAgent;
            }
            $chartCommission[] = array($datetime, (float) $val);

            $totalCommission = $totalCommission + $d->CommissionAgent;
        }



        $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission,'account_number'=>$accountnumbers)));

    }

    public function getCommission_test(){
        if(IPLoc::Office()){
            set_time_limit(0);
            $user_id = 172112;
            print_r('test getCommission_test<br>');
            $ac = $this->account_model->getAccountNumberByUserId( $user_id );
            $account_number = $ac['account_number'];
            $date_from = '2017-05-01';
            $date_to = '2017-06-01';

//        $date_from = $this->input->post('from',true);
//        $date_to = $this->input->post('to',true);

            $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from.' 00:00:00');
            $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to.' 23:59:59');


            $accountnumbers = $ac['account_number'];
//        if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
            $account_info = array(
                'iLogin' => $account_number,
                'from' =>$from->format('Y-m-d\TH:i:s'),
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
            print_r($account_info);
//        }else{
//            $account_info = array(
//                'iLogin' => $accountnumbers,
//                'from' =>$from->format('Y-m-d\TH:i:s'),
//                'to' =>  $to->format('Y-m-d\TH:i:s')
//            );
//        }


            $opt = $this->input->post('cumulative',true);

            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->GetAgentsCommissionByDate($account_info);

            $html_commission = '';
        print_r('<pre>');
//        $CommisionList =  $WebService->get_all_result();
//        print_r($CommisionList);
//        print_r('<br>');

            if($WebService->request_status === 'RET_OK'){
                $CommisionList =  $WebService->get_result('CommisionList');
                $CommissionData = json_encode($CommisionList->CommissionData);
                $CommisionListRecord = json_decode($CommissionData, true);

                $chartCommission = array();
                $val=0;
                $totalCommission = 0;
                if(is_array($CommisionListRecord)){

                    foreach($CommisionListRecord as $d){
                        $totalCommission = floatval($totalCommission) + floatval($d['Amount']);
//                        $datetime = strtotime($d['Date']) * 1000;
//                        if($opt=='no'){
//                            $val = $d['Amount'];
//                        }else{
//                            $val = $val + $d['Amount'];
//                        }
//                        $chartCommission[] = array($datetime, (float) $val);
//
//                        $totalCommission = $totalCommission + $d['Amount'];
                        print_r(floatval($d['Amount']).'-'.$d['Date'] );echo "<br>";
                    }
                    print_r("totalCommission=");
                    print_r($totalCommission);


//                    if(is_array($CommisionListRecord)){
//                        foreach($CommisionListRecord as $d){
//                            $html_commission .= "<tr> <td>".$d['Date']."</td><td>".$d['Amount']."</td><td>". $d['FromAccount']."</td><td>". $d['Symbol']."</td></tr>";
//                        }
//                    }else{
//                        $html_commission .= '<tr> <td colspan="4" class="center">'.lang('com_05').'.</td> </tr>';
//                    }

                }else{
                    $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);
                    $html_commission .= '<tr> <td colspan="4" class="center">'.lang('com_05').'.</td> </tr>';
                }
            }else{
                $chartCommission[] = array(strtotime(date('Y-m-d'))*1000, 0);
                $html_commission .= '<tr> <td colspan="4" class="center">'.lang('com_05').'.</td> </tr>';
            }
//            if( (IPLoc::Office())  ){
//                print_r($totalCommission);
//                print_r('<br>');
//
//            }




        }
    }

    public function getCommissionDataChart($account_info, $opt){

      if(IPLoc::Office()){
          ini_set('max_execution_time', 0);
          $totalCommission = 0;

          $defaultData = array(
              'startDate' => Date('Y-m-d', strtotime("-7 days")),
              'endDate'   =>  date('Y-m-d'),
              'chart'     =>  array(),
              'pagination' => ''
          );

          $webservice_config = array('server' => 'live_new');
          $WebService = new WebService($webservice_config);
          $WebService->GetAgentsCommssionByDateForChart($account_info);
          $html_commission = '';
//        if($WebService->request_status === 'RET_OK'){

          $CommisionList =  $WebService->get_result('CommissionList');
          $countCommissionList = (array) $CommisionList;

          if(!empty($countCommissionList)){
              $CommissionData = $CommisionList->CommissionDataForChart;


              $defaultData['startDate'] =$defaultData['startDate'];
              $defaultData['endDate'] =  $defaultData['endDate'];

              $val=0;
              $totalCommission = 0;
              if(is_array($CommissionData)){
                  foreach($CommissionData as $d){

                      $datetime = strtotime($d->Date) * 1000;

                      if($opt=='no'){
                          $val = $d->Amount;
                      }else{
                          $val = $val + $d->Amount;
                      }
                      $defaultData['chart'][] = "[$datetime, $val]";
                      $totalCommission = $totalCommission + $d->Amount;
                  }


              }else{
                  $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
              }
          }else{
              $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
          }
//        }else{
//            $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
//        }

          $defaultData['totalCommission'] = $totalCommission;

          return $defaultData;
      }else{



        ini_set('max_execution_time', 0);
        $totalCommission = 0;

        $defaultData = array(
            'startDate' => Date('Y-m-d', strtotime("-7 days")),
            'endDate'   =>  date('Y-m-d'),
            'chart'     =>  array(),
            'pagination' => ''
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);
        $html_commission = '';
//        if($WebService->request_status === 'RET_OK'){

            $CommisionList =  $WebService->get_result('CommisionList');
            $countCommissionList = (array) $CommisionList;

            if(!empty($countCommissionList)){
             if(!empty($countCommissionList[0])){   
                $CommissionData = json_encode($CommisionList->CommissionData);
                $CommisionListRecord = json_decode($CommissionData, true);
                
                

                $startDate = reset($CommisionListRecord);
                $endDate = end($CommisionListRecord);

                $startDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $startDate['Date']);
                $endDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $endDate['Date']);

                $defaultData['startDate'] = $startDate->format('Y-m-d');
                $defaultData['endDate'] = $endDate->format('Y-m-d');

                $val=0;
                $totalCommission = 0;
                if(is_array($CommisionListRecord)){
                    foreach($CommisionListRecord as $d){
                        $datetime = strtotime($d['Date']) * 1000;

                        if($opt=='no'){
                            $val = $d['Amount'];
                        }else{
                            $val = $val + $d['Amount'];
                        }
                        $defaultData['chart'][] = "[$datetime, $val]";
                        $totalCommission = $totalCommission + $d['Amount'];
                    }
                    foreach($CommisionListRecord as $d){
                        $html_commission .= "<tr> <td>".$d['Date']."</td><td>".$d['Amount']."</td><td>". $d['FromAccount']."</td><td>". $d['Symbol']."</td></tr>";
                    }

                }else{
                    $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                }
               
            }else {
                    $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                }
                
            }else{
                $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
            }
//        }else{
//            $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
//        }

        $defaultData['totalCommission'] = $totalCommission;

        return $defaultData;
      }
    }

    public function getAllCommissionPaginate(){
        if(!$this->input->is_ajax_request() && !$this->session->userdata('logged')){die('Not authorized!');}

        $user_id = $this->session->userdata('user_id');
        $ac = $this->account_model->getAccountNumberByUserId( $user_id );
        $account_number = $ac['account_number'];

        ini_set("soap.wsdl_cache_enabled", "0");

        $date_from = $this->input->post('date_from',true);
        $date_to = $this->input->post('date_to',true);

        $from = DateTime::createFromFormat('Y-m-d H:i:s', $date_from. ' 00:00:00');
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $date_to.' 23:59:59');

        $start = $this->input->post('start',true);

        $limit = $this->input->post('length',true);
		
		$accountnumbers = $ac['account_number'];

        $account_info2 = array(
            'iLogin' => $accountnumbers,
            'from' => $from->format('Y-m-d\TH:i:s') ,
            'to' => $to->format('Y-m-d\TH:i:s'),
            'offset' => $start,
            'limit' => $limit
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);

        $getServiceData = $WebService->GetAgentsCommissionByDateWithLimitAndOffset($account_info2);
        $CommisionList = $getServiceData->GetAgentsCommissionByDateWithLimitAndOffSetResult->CommisionList;
        $CommissionData = json_encode($CommisionList->CommissionData);
        $CommisionListRecord = json_decode($CommissionData, true);

        $data = array();

        $account_info = array(
            'iLogin' => $accountnumbers,
            'from' => $from->format('Y-m-d\TH:i:s') ,
            'to' =>  $to->format('Y-m-d\TH:i:s')
        );

        $WebService2 = new WebService($webservice_config);
        $WebService2->GetAgentsCommissionByDateCount($account_info);
        $DataCount = $WebService2->get_result('DataCount');

        $total_commission = 0;

        if ($CommisionListRecord) {
            foreach ($CommisionListRecord as $key => $details) {

                $convertDate = date('Y-m-d H:i:s', strtotime($details['Date']));


//                $cDate="'$convertDate'";
//                $cAmount="$details[Amount]";
//                $cAcc="'$details[FromAccount]'";
//                $cSymb="'$details[Symbol]'";
//				$view_details = '<button onclick="myFunction('.$cDate.','.$cAmount.','.$cAcc.','.$cSymb.')">Detail</button> ';

            $total_commission = $total_commission + $details['Amount'];

				if(IPLoc::Office()){
					$tempArray = array(
						'DT_RowId' => $key,
						$convertDate,
						$details['Amount'],
						$details['FromAccount'],
						$details['Symbol']
//						,$view_details
					);
				}  else {
					$tempArray = array(
						'DT_RowId' => $key,
						$convertDate,
						$details['Amount'],
						$details['FromAccount'],
						$details['Symbol']
					);
				}



                $data[] = $tempArray;
            }
        }
        $result = array(
            'draw' => (int) $this->input->post('draw',true),
            //'recordsTotal' => (int) $DataCount,
            'recordsTotal' => '10',
            'recordsFiltered' => (int) $DataCount,
            'data' => $data,
            'total_commission'=>$total_commission
        );

        echo json_encode($result);
    }

    /*public function commission1(){
        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);

            $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'commission';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $webservice_config = array('server' => 'live_new');
            $from = DateTime::createFromFormat('Y/d/m', '2015/05/05');
            $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m H:i:s'));
            $ac = $this->general_model->showssingle2($table='mt_accounts_set','user_id',$id=$this->session->userdata('user_id'),'account_number');
            $data['data']['accountnumber']=$ac['account_number'];

            $account_info2 = array(
               // 'iLogin' => $ac['account_number'],
                 'iLogin' =>'102032',
                'from' =>$from->format('Y-m-d\TH:i:s') ,
                'to' =>  $to->format('Y-m-d\TH:i:s')
            );
            $data['opt'] = $this->input->get('opt'); // for Cumulative option select;
            // echo "<pre>";
            //  print_r($account_info2);
            $WebService = new WebService($webservice_config);
            $WebService->GetAgentsCommissionByDate($account_info2);


            switch($WebService->request_status){
                case 'RET_OK':
                    $CommisionList =  $WebService->get_result('CommisionList');
                    $data['commisionList'] = isset($CommisionList->CommissionData)?$CommisionList->CommissionData:false;

                    break;
                default:
                    $data['error']=true;
            }


            $js = $this->template->Js();
            $this->template->title("ForexMart | Partnership")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/commission', $data);
        }else{
            redirect('signout');
        }
    }*/

    public function clicks(){
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            //$data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'clicks';
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];

            $data['affiliate_codes'] = $affiliate_code;
            $data['www'] = $this->config->item('domain-www');

            $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code'], $data['date_to'].' 23:59:59', $data['date_from'].' 00:00:00');
            $click = $this->partners_model->getClickByCode($affiliate_code[0]['affiliate_code']);

            $data['date_from'] = reset($click)->date;
            $data['date_to'] = end($click)->date;

            $countClicksByAffiliateCode = $this->partners_model->countClicksByAffiliateCode($affiliate_code[0]['affiliate_code'], $data['date_to'].' 23:59:59', $data['date_from'].' 00:00:00');

            $data['countClicks'] = $countClicksByAffiliateCode['count'];

//            if($this->isCPA){
//                if($sub_partner){
//                    $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                    $click = $this->partners_model->getClick($affiliate_code[0]['affiliate_code']);
//                }else{
//                    $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                    $click = $this->partners_model->getClick($user_id);
//                }
//            }else{
//                $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                $click = $this->partners_model->getClick($user_id);
//            }

            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;
            // $chart = "[". strtotime($ac_created)*1000 .",0],";
            if(is_array($click)){
                foreach($click as $d){

                    $datetime = strtotime($d->date) * 1000;
                    $value = $d->num;
                    $click_data[] = "[$datetime, $value]";
                }

                $chart =  join($click_data,",");
                $data['chart'] = $chart;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }

//            $js = $this->template->Js();
            $data['metadata_description'] = lang('cli_dsc');
            $data['metadata_keyword'] = lang('cli_kew');
            $this->template->title(lang('cli_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/clicks_test', $data);
        }else{
            redirect('signout');
        }
    }

    public function clickschart(){
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            //$data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'clicks';
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];

            $data['affiliate_codes'] = $affiliate_code;
            $data['www'] = $this->config->item('domain-www');

            $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
            $click = $this->partners_model->getClickByCode($affiliate_code[0]['affiliate_code']);

            $data['date_from'] = reset($click)->date;
            $data['date_to'] = end($click)->date;

            $countClicksByAffiliateCode = $this->partners_model->countClicksByAffiliateCode($affiliate_code[0]['affiliate_code'], $data['date_to'].' 23:59:59', $data['date_from'].' 00:00:00');

            $data['countClicks'] = $countClicksByAffiliateCode['count'];

            if(is_array($click)){
                foreach($click as $d){

                    $datetime = strtotime($d->date) * 1000;
                    $value = $d->num;
                    $click_data[] = "[$datetime, $value]";
                }

                $chart =  join($click_data,",");
                $data['chart'] = $chart;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }

            $data['metadata_description'] = lang('cli_dsc');
            $data['metadata_keyword'] = lang('cli_kew');
            $this->template->title(lang('cli_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/clickschart', $data);
        }else{
            redirect('signout');
        }
    }

	public function getTrades(){
        if ($this->input->is_ajax_request()) {

            ini_set("soap.wsdl_cache_enabled", "0");
//            $this->load->library('SVC');
            $this->load->library('WSV');
            $tradeType = 'transaction-history';
            $rowPerPage = 10;
            $hasError = false;
            $errorMsg = "";
            //$page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
            $page = is_numeric($_POST['page']) ? $_POST['page'] : 1;
            $WSV = new WSV();
            $args = array(
                'AccountNumber' => $_SESSION['account_number'],
                'isCPA' => $this->isCPA,
                'Limit' => $rowPerPage,
                'Offset' => 1,
                'recType' => 'transaction-history',
            );

            if($_POST['recType']=='commission'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
                $rowPerPage = 10;
                $args['Limit'] = $rowPerPage;
                $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
                $args['Offset'] = 10;
            }
            if($_POST['recType']=='transaction-history'){


                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;



            }

            if($tradeType=='history-of-trades'){


                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: $WSV->GetTradeHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            }else if($tradeType=='current-trades'){



                $x = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $WSV->GetOpenTrades($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;

            }else if( in_array($tradeType,array('balance-operations', 'transaction-history','pending-transactions') ) ){
                $x = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                if($tradeType=='pending-transactions'){  $args['Limit'] = $res['count']; }
                $y = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $WSV->GetFinanceOpHistoryV2($args)['Data']: array() ;
                $res['record'] = isset($y->Transactions) ? $y->Transactions : '';
                $hasError = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetFinanceOpHistoryV2($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }else if($tradeType=='commission'){
                $args['AccountNumber'] = 0;
                $x = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetCommissionHistory($args)['Data']: $WSV->GetCommissionHistory($args) ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetCommissionHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetCommissionHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                $dataResult['totalCom'] = isset($x->TotalFromRange) ? $x->TotalFromRange : 0;
//                if($_SESSION['account_number']=='58027933' && $_SERVER['REMOTE_ADDR']=='49.12.5.139'){
//                        echo "<pre>";
//                        print_r($x);
//                        print_r($args); die();
//                    }

            }else{
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }


          //  $result = $this->populate($res, $args);
		$type = 'transaction-history';
		$records = $res['record'];
        $rowNum = $args['Offset'];
        $count = isset( $res['count'] )?  $res['count']: 0;

$tbl = '';
        $ctr = intval($rowNum) + 1;
       
        if($type=='commission'){
            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $tbl .= "<tr>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime)."</td>";
                    $tbl .= "<td>".$a->CommissionAgent."</td>";
                    $tbl .= "<td>".$a->Login."</td>";
                    $tbl .= "<td>".$a->Symbol."</td>";
                    $tbl .= "<td>".$a->Order."</td>";
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="6">'.lang('dta_tbl_01').'</td></tr>';
            }
        }else if($type=='current-trades' || $type=='history-of-trades'){

            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $data['volume'] = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

                        $tbl .= "<tr>";
                        $tbl .= "<td>".$ctr."</td>";
                        $tbl .= "<td>".$a->Order."</td>";
                        $tbl .= "<td>".$this->getTradeType($a->Cmd)."</td>";
//                        $tbl .= "<td>".$data['volume']."</td>";
                        $tbl .= "<td>".number_format(($a->Volume),2)."</td>";
                        $tbl .= "<td>".$a->Symbol."</td>";
                        $tbl .= "<td>".$a->OpenPrice."</td>";
                        $tbl .= "<td>".$a->ClosePrice."</td>";
                        $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->OpenTime) ."</td>";
                        $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime) ."</td>";
                        $tbl .= "<td>".$a->Sl."</t>";
                        $tbl .= "<td>".$a->Tp."</tdd>";
                        $tbl .= "<td>".$a->Profit."</td>";

                     

                        $tbl .= "</tr>";

                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="12">'.lang('dta_tbl_01').'</td></tr>';
            }

        }else {
            if ($count > 1) {
                $pendingTrans = 0;
                foreach ($records->FinanceOpData as $a) {
                    $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
                    $dt = $this->getBalOpsDetails($a);
                    if($type=='balance-operations'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $a->Ticket . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td>" . $d['Description'] . "</td>";
                        $tbl .= "</tr>";
                    }else if($type=='transaction-history'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . $d['TransType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                        $tbl .= "</tr>";
                    $tempArray = array(
                        'DT_RowId' => $ctr,
                        $ctr,
                        $d['FundType'],
                        $d['Status'],
                        $d['TransType'],
                        $a->Amount,
                        gmdate("Y-m-d H:i:s", $a->ProcessTime),
                        "<button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button>",
                    );
                    $data[] = $tempArray;
			
                    }else if($type=='pending-transactions'){
                        
                        
                        
                        if($a->OperationTypeId == "WITHDRAW_REAL_FUND"){
                            
                                                        
                           //FXPP-12929
                            if($this->checkPendingTranSection($a->Ticket,$a->Comment))
                            {
                                    $tbl .= "<tr>";
                                    $tbl .= "<td>" . $ctr . "</td>";
                                    $tbl .= "<td>" . $d['FundType'] . "</td>";
                                    $tbl .= "<td>" . $d['Status'] . "</td>";
                                    $tbl .= "<td>" . $d['TransType'] . "</td>";
                                    $tbl .= "<td>" . $a->Amount . "</td>";
                                    $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                                    $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                                    $tbl .= "</tr>";
                                    $pendingTrans++;
                            }
                            
                        }
                    }

                    $ctr++;
                }
                
                
                if($type=='pending-transactions'){
                    return $res = array('tbl'=> ($pendingTrans>0)?$tbl:'<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>' , 'countPending'=> $pendingTrans);
                }
                
                
            } else {
                $col = ($type=='transaction-history')? 6:7;
                $tbl .= '<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>';
            }

        }

            $result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$res['count'],
                'recordsFiltered' => (int)$res['count'],
                'data' => $data
            );

            echo json_encode($result);	
        }
    }
	 public function populate($data,$raw){
        $this->load->library('pagination');
        $rowPerPage = $raw['Limit'];
        $rowNum = $raw['Offset'];
        $data1['count'] = isset( $data['count'] )?  $data['count']: 0;

        $config['base_url'] = base_url().'get-trades';
        $config['total_rows'] = $data1['count'] ;
        $config['per_page'] = $rowPerPage;
        $config['num_links'] = 4;
        $config['page'] = $rowNum;
        $config['use_page_numbers'] = TRUE;
        $config['first_link']       = '&#60;';
        $config['prev_link']        = '&laquo;';
        $config['last_link']        = '&#62;';
        $config['next_link']        = '&raquo;';
        $config['full_tag_open']    = '<ul class="tab-pagination pagination pagination-md">';
        $config['full_tag_close']   = '</ul>';
        $config['first_tag_open']   = '<li class="latest-page">';
        $config['prev_tag_open']    = '<li class="latest-page">';
        $config['last_tag_open']    = '<li class="latest-page">';
        $config['next_tag_open']    = '<li class="latest-page">';
        $config['first_tag_close']  = '</li>';
        $config['prev_tag_close']   = '</li>';
        $config['last_tag_close']   = '</li>';
        $config['next_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a id="curPage">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="latest-page">';
        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);
        $data1['pagination'] = $this->pagination->create_links();

//        $config['base_url'] = base_url().'get-trades';
//        $config['total_rows'] = $data1['count'] ;
//        $config['per_page'] = $rowPerPage;
//        $config['page'] = $rowNum;
//
//        $config['num_links'] = 20;
//        $config['use_page_numbers'] = TRUE;
//
//        $config['full_tag_open']    = '<ul class="tab-pagination pagination pagination-md">';
//        $config['full_tag_close']   = '</ul>';
//
//        $config['first_link']       = 'first';
//        $config['first_tag_open']   = '<li class="latest-page">';
//        $config['first_tag_close']  = '</li>';
//
//        $config['last_link']        = 'last';
//        $config['last_tag_open']    = '<li class="latest-page">';
//        $config['last_tag_close']   = '</li>';
//
//        $config['next_link']        = 'next';
//        $config['next_tag_open']    = '<li class="latest-page paginate-next">';
//        $config['next_tag_close']   = '</li>';
//
//        $config['prev_link']        = 'prev';
//        $config['prev_tag_open']    = '<li class="latest-page">';
//        $config['prev_tag_close']   = '</li>';
//
//        $config['cur_tag_open']     = '<li class="latest-page active"><a id="curPage" class="first" data-ci-pagination-page="1">';
//        $config['cur_tag_close']    = '</a></li>';
//
//        $config['num_tag_open']     = '<li class="latest-page">';
//        $config['num_tag_close']    = '</li>';

        $this->pagination->initialize($config);
        $data1['pagination'] = $this->pagination->create_links();
		
        $data1['result'] =  $this->formatRaw($data['record'] , $rowNum, $raw['recType'], $data1['count']) ;

        if($raw['recType']=='pending-transactions'){
            $data1['result'] = $data1['result']['tbl'];
            $data1['count'] = $data1['result']['countPending'];
        }

        $c = (intval($rowNum) + 1);
        $t =  ($rowNum+$rowPerPage) ;
        $t = ($t>=intval($data1['count']) )? $data1['count']: $t;
        $data1['showing'] = "Showing ".$c." to ".($t)." of ".$data1['count']." entries";
        $data1['row'] = $rowNum;
        $data1['rowPerPage'] = $data['rowPerPage'];

        return $data1;
    }

     public function formatRaw($records, $rowNum, $type, $count){
        $tbl = '';
        $ctr = intval($rowNum) + 1;
        if($type=='commission'){
            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $tbl .= "<tr>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime)."</td>";
                    $tbl .= "<td>".$a->CommissionAgent."</td>";
                    $tbl .= "<td>".$a->Login."</td>";
                    $tbl .= "<td>".$a->Symbol."</td>";
                    $tbl .= "<td>".$a->Order."</td>";
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="6">'.lang('dta_tbl_01').'</td></tr>';
            }
        }else if($type=='current-trades' || $type=='history-of-trades'){

            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $data['volume'] = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

                        $tbl .= "<tr>";
                        $tbl .= "<td>".$ctr."</td>";
                        $tbl .= "<td>".$a->Order."</td>";
                        $tbl .= "<td>".$this->getTradeType($a->Cmd)."</td>";
//                        $tbl .= "<td>".$data['volume']."</td>";
                        $tbl .= "<td>".number_format(($a->Volume),2)."</td>";
                        $tbl .= "<td>".$a->Symbol."</td>";
                        $tbl .= "<td>".$a->OpenPrice."</td>";
                        $tbl .= "<td>".$a->ClosePrice."</td>";
                        $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->OpenTime) ."</td>";
                        $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime) ."</td>";
                        $tbl .= "<td>".$a->Sl."</t>";
                        $tbl .= "<td>".$a->Tp."</tdd>";
                        $tbl .= "<td>".$a->Profit."</td>";

                     

                        $tbl .= "</tr>";

                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="12">'.lang('dta_tbl_01').'</td></tr>';
            }

        }else {

            if ($count > 1) {
                $pendingTrans = 0;
                foreach ($records->FinanceOpData as $a) {
                    $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
                    $dt = $this->getBalOpsDetails($a);
                    if($type=='balance-operations'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $a->Ticket . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td>" . $d['Description'] . "</td>";
                        $tbl .= "</tr>";
                    }else if($type=='transaction-history'){
                        $tbl .= "<tr>";
                        $tbl .= "<td>" . $ctr . "</td>";
                        $tbl .= "<td>" . $d['FundType'] . "</td>";
                        $tbl .= "<td>" . $d['Status'] . "</td>";
                        $tbl .= "<td>" . $d['TransType'] . "</td>";
                        $tbl .= "<td>" . $a->Amount . "</td>";
                        $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                        $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                        $tbl .= "</tr>";
                    }else if($type=='pending-transactions'){
                        
                        
                        
                        if($a->OperationTypeId == "WITHDRAW_REAL_FUND"){
                            
                                                        
                           //FXPP-12929
                            if($this->checkPendingTranSection($a->Ticket,$a->Comment))
                            {
                                    $tbl .= "<tr>";
                                    $tbl .= "<td>" . $ctr . "</td>";
                                    $tbl .= "<td>" . $d['FundType'] . "</td>";
                                    $tbl .= "<td>" . $d['Status'] . "</td>";
                                    $tbl .= "<td>" . $d['TransType'] . "</td>";
                                    $tbl .= "<td>" . $a->Amount . "</td>";
                                    $tbl .= "<td>" . gmdate("Y-m-d H:i:s", $a->ProcessTime) . "</td>";
                                    $tbl .= "<td><button id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>View Details</button></td>";
                                    $tbl .= "</tr>";
                                    $pendingTrans++;
                            }
                            
                        }
                    }

                    $ctr++;
                }
                
                
                if($type=='pending-transactions'){
                    return $res = array('tbl'=> ($pendingTrans>0)?$tbl:'<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>' , 'countPending'=> $pendingTrans);
                }
                
                
            } else {
                $col = ($type=='transaction-history')? 6:7;
                $tbl .= '<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>';
            }

        }
        return $tbl;
    }
    
  
    public function getClicksData(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            $date_from = $this->input->post('date_from',true).' 00:00:00';
            $date_to = $this->input->post('date_to',true).' 23:59:59';
            $code = $this->input->post('code',true) ;
            $offset = (int)  $this->input->post('start',true);
            $rowPerPage = (int)  $this->input->post('length',true);

            $getAllClicks = $this->partners_model->getAllClickAndRegisterAcByCode($code, $date_from, $date_to, $offset, $rowPerPage);
            $countAllClicks = count($this->partners_model->getCountAllClickAndRegisterAcByCode($code, $date_from, $date_to));

            $data = array();

            if ($getAllClicks) {
                foreach ($getAllClicks as $key => $details) {
                    $tempArray = array(
                        'DT_RowId' => $key,
                        $details->date,
                        $details->num,
                        $details->acnum,
                    );
                    $data[] = $tempArray;
                }
            }

            $result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$countAllClicks,
                'recordsFiltered' => (int)$countAllClicks,
                'data' => $data
            );

            echo json_encode($result);
        }
    }

    public function get_clicks(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){
            $date_from = $this->input->post('from',true).' 00:00:00';
            $date_to =  $this->input->post('to',true).' 23:59:59';
            $code = $this->input->post('code',true);
            $click_chart_data = $this->partners_model->getAllClickByCode($code,$date_from, $date_to);
            $countClicksByAffiliateCode = $this->partners_model->countClicksByAffiliateCode($code, $date_to, $date_from);
            $click_data = array();
            if(is_array($click_chart_data)){
                foreach($click_chart_data as $d){
                    $datetime = strtotime($d->date) * 1000;
                    $value =  (int) $d->num;
                    $click_data[] = array($datetime, $value);
                }
            }else{
                $click_data[] = array(strtotime(date('Y-m-d'))*1000, 0);
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $click_data, 'countClicks' => $countClicksByAffiliateCode['count'])));
        }
    }

    public function referralPreProcess(){

        $user_id = $this->session->userdata('user_id');
        $countReferrals = $this->partners_model->countReferrals($user_id);

        $referralsList = $this->partners_model->getReferralList($user_id);

        if($countReferrals['count'] > $referralsList['count']){

            $getReferralsNew = $this->partners_model->getReferralsNew($user_id);

            foreach($getReferralsNew as $key => $ref){

                $this->load->model('account_model');
                $aff_user_id = $ref['users_id'];

                $getAccountNumberByUserId = $this->account_model->getAccountNumberByUserId($aff_user_id);
                $account_number = $getAccountNumberByUserId['account_number'];

                $this->load->model('deposit_model');
                $getTotalDeposit = $this->deposit_model->getTotalDeposit($aff_user_id, 2);
                $totalDeposit = empty($getTotalDeposit) ? 0 : $getTotalDeposit;

                $getUserDetailsByUserId = $this->account_model->getUserandMTaccountDetails($aff_user_id);
                $isNDBget = $getUserDetailsByUserId['nodepositbonus'];

                $webservice_config = array('server' => 'live_new');
//                $WebService2 = new WebService($webservice_config);
//                $WebService2->RequestAccountFunds($account_number);
//                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                $accountFunds = $this->GetAccountFunds($account_number);

                if ($isNDBget) {
                    if ($totalDeposit > $accountFunds['TotalBonusFund']) {
                        $status = 'Confirmed';
                    } else {
                        $status = 'Pending';
                    }
                } else {
                    $status = 'Confirmed';
                }
                $getReferralsDetails = $this->partners_model->getReferralDetails($user_id, $account_number);

                if(!$getReferralsDetails){
                    $insert_data = array(
                        'User_id' => $user_id,
                        'Account_number' => $account_number,
                        'Registration_time' => $getUserDetailsByUserId['registration_time'],
                        'Status' => $status
                    );
                    $this->general_model->insert('referrals',$insert_data);
                }
            }
        }
    }

    public function referralsprocesstest(){

        $user_id = 7493;
        $countReferrals = $this->partners_model->countReferrals($user_id);

        $referralsList = $this->partners_model->getReferralList($user_id);

        if($countReferrals['count'] > $referralsList['count']){

            $getReferralsNew = $this->partners_model->getReferralsNew($user_id, $referralsList['count']);
//            FXPP::print_data($getReferralsNew);

            foreach($getReferralsNew as $key => $ref){

                $this->load->model('account_model');
                $aff_user_id = $ref['users_id'];

                $getAccountNumberByUserId = $this->account_model->getAccountNumberByUserId($aff_user_id);
                $account_number = $getAccountNumberByUserId['account_number'];

                $this->load->model('deposit_model');
                $getTotalDeposit = $this->deposit_model->getTotalDeposit($aff_user_id, 2);
                $totalDeposit = empty($getTotalDeposit) ? 0 : $getTotalDeposit;

                $getUserDetailsByUserId = $this->account_model->getUserandMTaccountDetails($aff_user_id);
                $isNDBget = $getUserDetailsByUserId['nodepositbonus'];

                $webservice_config = array('server' => 'live_new');
//                $WebService2 = new WebService($webservice_config);
//                $WebService2->RequestAccountFunds($account_number);
//                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                $accountFunds = $this->GetAccountFunds($account_number);

                if ($isNDBget) {
                    if ($totalDeposit > $accountFunds['TotalBonusFund']) {
                        $status = 'Confirmed';
                    } else {
                        $status = 'Pending';
                    }
                } else {
                    $status = 'Confirmed';
                }
                $getReferralsDetails = $this->partners_model->getReferralDetails($user_id, $account_number);

                if(!$getReferralsDetails){
                    $insert_data = array(
                        'User_id' => $user_id,
                        'Account_number' => $account_number,
                        'Registration_time' => $getUserDetailsByUserId['registration_time'],
                        'Status' => $status
                    );
                    $this->general_model->insert('referrals',$insert_data);
                }else{
                    echo $key.' - '.$account_number.'<br>';
                }
            }
        }

    }

    public function getReferralsT($offset = 0, $rowPerPage = 10){

        $status = 'Confirmed';
        $user_id = $this->session->userdata('user_id');

        $countAllReferrals = $this->partners_model->countAllReferrals($status);
        $getAllReferrals = $this->partners_model->getAllReferrals($user_id, $status, $offset, $rowPerPage);

        foreach($getAllReferrals as $details){
            $tempArray = array(
                'DT_RowId' => $details['Id'],
                $details['Account_number'],
                $details['Registration_time']
            );
        }

        $result = array(
            'draw'              => (int) $this->input->post('draw',true),
            'recordsTotal'      => (int) $countAllReferrals['Count'],
            'recordsFiltered'   => (int) $countAllReferrals['Count'],
            'data'              => $tempArray
        );

        echo json_encode($result);

    }

    public function getPartnershipReferrals(){
        $user_id = 10380;
        $partnershipReferrals = $this->partners_model->getPartnershipReferrals($user_id);
        FXPP::print_data($partnershipReferrals);
    }

    public function getReferrals($user_id){

        $referrals = $this->partners_model->getReferralsNDB($user_id);

        $status = array(
            'Pending' => null,
            'Confirmed' => null,
            'total' => null
        );
        $i = 0;
        foreach ($referrals as $r) {
            $i++;
            $this->load->model('deposit_model');
            $getTotalDeposit = $this->deposit_model->getTotalDeposit($r['user_id'], 2);

            $webservice_config = array('server' => 'live_new');
//            $WebService2 = new WebService($webservice_config);
//            $WebService2->RequestAccountFunds($r['account_number']);
//            $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

            $accountFunds = $this->GetAccountFunds($r['account_number']);

            if ($r['nodepositbonus']) {
                if ($getTotalDeposit > $accountFunds['TotalBonusFund']) {
                    $status['Confirmed'] .= "<tr align='center'><td >" . $r['registration_time'] . "</td><td>" . $r['account_number'] . "</td></tr>";
                } else {
                    $status['Pending'] .= "<tr align='center'><td>" . $r['registration_time'] . "</td><td>" . $r['account_number'] . "</td></tr>";
                }
            } else {
                $status['Confirmed'] .= "<tr align='center'><td>" . $r['registration_time'] . "</td><td>" . $r['account_number'] . "</td></tr>";
            }


        }
        $status['total'] = $i;

        return $status;
    }

    public function getChartData(){
        if(!$this->input->is_ajax_request() && !$this->session->userdata('logged')){die('Not authorized!');}
        $user_id = $this->session->userdata('user_id');
        $date_from = date('Y-m-d', strtotime($this->input->post('from',true)));
        $date_to = date('Y-m-d', strtotime($this->input->post('to',true)));

        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($this->isCPA) {
            if ($sub_partner) {
                $user_id = $sub_partner['partner_id'];
            }
        }

        $postData = array(
            'user_id' => $user_id,
            'date_from' => $date_from,
            'date_to' => $date_to
        );

        $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
        $data['numberofreferrals'] = $countAllReferrals['count'];


        if($this->isCPA) {
            if ($sub_partner) {
                $postData['user_id'] = $sub_partner['partner_id'];
                $click = $this->partners_model->getRegisteredAccRef($postData);
            } else {
                $click = $this->partners_model->getRegisteredAccRef($postData);
            }
        }else {
            $click = $this->partners_model->getRegisteredAccRef($postData);
        }


        if(is_array($click['result'])){
            foreach($click['result'] as $d){
                $datetime = strtotime($d->date) * 1000;
                if(strlen($datetime)>5){
                    $value = (int) $d->acnum;
                    $click_data[] = [$datetime, $value];
                }
            }
            $data['seriesofdata'] = $click_data;
        }else{
            $data['seriesofdata'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
        }

        echo json_encode($data);

    }

    public function getReferralsData(){
        if(!$this->input->is_ajax_request() && !$this->session->userdata('logged')){die('Not authorized!');}
        $offset = $this->input->post('start',true);
        $rowPerPage = $this->input->post('length',true);
        $status = $this->input->post('tab',true);
        $date_from = $this->input->post('date_from',true);
        $date_to =  $this->input->post('date_to',true);
        $user_id = $this->session->userdata('user_id');

        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($this->isCPA) {
            if ($sub_partner) {
                $user_id = $sub_partner['partner_id'];
            }
        }


        $postData = array(
            'user_id' => $user_id,
            'status' => $status,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'offset' => $offset,
            'limit' => $rowPerPage
        );

//        if(IPLoc::Office()){
//         print_r($postData);
//        }
        $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
        $getAllReferrals = $this->partners_model->getAllPartnershipReferrals($postData);

        $data = array();

        if($getAllReferrals){
            foreach($getAllReferrals as $details){
                $this->load->model('deposit_model');
                $getTotalDeposit = $this->deposit_model->getTotalDeposit($details['user_id'], 2);

                $webservice_config = array('server' => 'live_new');
//                $WebService2 = new WebService($webservice_config);
//                $WebService2->RequestAccountFunds($details['account_number']);
//                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                $accountFunds = $this->GetAccountFunds($details['account_number']);

                if ($details['nodepositbonus']) {
                    if ($getTotalDeposit > $accountFunds['TotalBonusFund']) {
                        $status = 'Confirmed';
                    } else {
                        $status = 'Unconfirmed';
                    }
                } else {
                    $status = 'Confirmed';
                }
                $accountstatus=($details['accountstatus'] == 1) ? "<b style='color:green'>Verified</b>" : "<b style='color:red'>Not Verified</b>";
                $tempArray = array(
                    'DT_RowId' => $details['user_id'],
                    $details['registration_time'],
                    $details['account_number'],
                    $status,
                    $accountstatus,
                );
                $data[] = $tempArray;
            }
        }

        $result = array(
            'draw'              => (int)  $this->input->post('draw',true),
            'recordsTotal'      => (int) $countAllReferrals['count'],
            'recordsFiltered'   => (int) $countAllReferrals['count'],
            'data'              => $data
        );

        echo json_encode($result);

    }

    public function referrals_old(){

        if($this->session->userdata('logged')) {

            //load new referrals data and save to referrals table
//            $this->referralPreProcess();

//            $this->lang->load('referrals');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            //$data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;

            //$referrals = $this->partners_model->getReferralsbyAffiliateCode($affiliate_code[0]['affiliate_code']);
            //  $data['referralList'] = $this->createReferralList($referrals);

            $postData = array(
                'user_id' => $user_id
            );

            if($this->isCPA) {
                if ($sub_partner) {
                    $postData['user_id'] = $sub_partner['partner_id'];
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                } else {
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                }
            }else{
                $click = $this->partners_model->getRegisteredAccRefDef($postData);
            }

            //$chart = "[". strtotime($ac_created)*1000 .",0],";
//            if(IPLoc::Office()){
                $from = date("Y-m-d",strtotime("2015-05-05"));
                $to = date("Y-m-d");
                $getAllReferrals = $this->partners_model->getReferralCountofAffiliateCode($affiliate_code[0]['affiliate_code'],$from,$to);

                if(count($getAllReferrals)>0){
                    $ctr_alref = 0;
                    for($i=0;$i<count($getAllReferrals);$i++){
                        $datetime = strtotime( $getAllReferrals[$i]['date_created'] ) * 1000;
                        $ctr_alref = $ctr_alref + ($getAllReferrals[$i]['referralCount']);
                        $click_data[] = "[$datetime, $ctr_alref]";
                    }
                    $chart1 =  join($click_data,",");
                    $data['chart'] = $chart1;
                    $data['status'] = 1;
                }else{
                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                    $data['status'] = 0;
                }
				
            $data['test'] = $affiliate_code['affiliate_code'];

            $data['date_from'] = $click['first_row']['date'];
            $data['date_to'] = $click['last_row']['date'];

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($this->isCPA) {
                if ($sub_partner) {
                    $user_id = $sub_partner['partner_id'];
                }
            }

            $postData = array(
                'user_id' => $user_id,
                'date_from' =>  date('Y-m-d', strtotime($click['first_row']['date'])),
                'date_to' => date('Y-m-d', strtotime($click['last_row']['date']))
            );
            $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
            $data['referralsTotal'] = $countAllReferrals['count'];

//            if(IPLoc::Office()){
                $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, '*')['account_number'];
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, '*')['reference_num'];
                $account = $mt?$mt:$pt;
                $data['agentStats'] =  $this->GetAgentStats($account);
                $data['referralsTotal'] =  $data['agentStats']["user_referrals"];
//            }

            $data['isCPA'] = $this->isCPA;
            //  $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];


            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');
			
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referrals', $data);
        }else{
            redirect('signout');
        }
    }

    public function referralschart(){

        if($this->session->userdata('logged')) {

            //load new referrals data and save to referrals table
//            $this->referralPreProcess();

//            $this->lang->load('referrals');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            //$data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;

            //$referrals = $this->partners_model->getReferralsbyAffiliateCode($affiliate_code[0]['affiliate_code']);
            //  $data['referralList'] = $this->createReferralList($referrals);

            $postData = array(
                'user_id' => $user_id
            );

            if($this->isCPA) {
                if ($sub_partner) {
                    $postData['user_id'] = $sub_partner['partner_id'];
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                } else {
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                }
            }else{
                $click = $this->partners_model->getRegisteredAccRefDef($postData);
            }

            //$chart = "[". strtotime($ac_created)*1000 .",0],";
//            if(IPLoc::Office()){
                $from = date("Y-m-d",strtotime("2015-05-05"));
                $to = date("Y-m-d");
                $getAllReferrals = $this->partners_model->getReferralCountofAffiliateCode($affiliate_code[0]['affiliate_code'],$from,$to);

                if(count($getAllReferrals)>0){
                    $ctr_alref = 0;
                    for($i=0;$i<count($getAllReferrals);$i++){
                        $datetime = strtotime( $getAllReferrals[$i]['date_created'] ) * 1000;
                        $ctr_alref = $ctr_alref + ($getAllReferrals[$i]['referralCount']);
                        $click_data[] = "[$datetime, $ctr_alref]";
                    }
                    $chart1 =  join($click_data,",");
                    $data['chart'] = $chart1;
                    $data['status'] = 1;
                }else{
                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                    $data['status'] = 0;
                }
//            }else{
//                if(is_array($click['result'])){
//                    foreach($click['result'] as $d){
//                        $datetime = strtotime($d->date) * 1000;
//                        if(strlen($datetime)>5){
//                            $value = $d->acnum;
//                            $click_data[] = "[$datetime, $value]";
//                        }
//                    }
//
//                    $chart1 =  join($click_data,",");
//
//                    $data['chart'] = $chart1;
//                    $data['status'] = 1;
//                }else{
//                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
//                    $data['status'] = 0;
//                }
//            }
            $data['test'] = $affiliate_code['affiliate_code'];

            $data['date_from'] = $click['first_row']['date'];
            $data['date_to'] = $click['last_row']['date'];

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($this->isCPA) {
                if ($sub_partner) {
                    $user_id = $sub_partner['partner_id'];
                }
            }

            $postData = array(
                'user_id' => $user_id,
                'date_from' =>  date('Y-m-d', strtotime($click['first_row']['date'])),
                'date_to' => date('Y-m-d', strtotime($click['last_row']['date']))
            );
            $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
            $data['referralsTotal'] = $countAllReferrals['count'];
//            if(IPLoc::Office()){
                $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, '*')['account_number'];
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, '*')['reference_num'];
                $account = $mt?$mt:$pt;
                $data['agentStats'] =  $this->GetAgentStats($account);
                $data['referralsTotal'] =  $data['agentStats']["user_referrals"];
//            }


            $data['isCPA'] = $this->isCPA;
            //  $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];



            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referralschart', $data);
        }else{
            redirect('signout');
        }
    }

    public function createReferralList($referrals){
        $str = '';
        if($referrals['rtn']){
            if($referrals['count'] > 0){
                foreach($referrals['result'] as $row){
                    $str = '<tr id="rf-'.$row['id'].'">'
                        .'<td>'.$row['created'].'</td>'
                        .'<td>'.$row['full_name'].'</td>'
                        .'</tr>';
                }
            }else{
                $str = '<td colspan="2" class="center">There are no records found.</td>';
            }
        }else{
            $str = '<td colspan="2" class="center">There are no records found.</td>';
        }
        return $str;
    }

    public function affiliate_custom_link(){
        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            if($this->isCPA){

                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if($sub_partner){
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                    $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($sub_partner['partner_id']);
                    $getPartnersAffiliatesCode = $this->partners_model->getPartnersAffiliatesCode($sub_partner['partner_id']);
                }else{
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                    $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                    $getPartnersAffiliatesCode = $this->partners_model->getPartnersAffiliatesCode($user_id);
                }
            } else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $getPartnersAffiliatesCode = $this->partners_model->getPartnersAffiliatesCode($user_id);
            }
            if(!$data['data']['PartnershipAgreementStatus']){
                redirect('');
            }
            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'affiliate';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $data['www'] = $this->config->item('domain-www');
            $js = $this->template->Js();


            $data['partners_affiliate'] = $this->createHtmlPartnersAffiliate($getPartnersAffiliatesCode);
            $data['metadata_description'] = 'Auto-generate or customize your own affiliate link in the Partner Cabinet.';


            $this->template->title("ForextMart | Partnership")
                ->append_metadata_css("

                ")
                ->append_metadata_js("
                      <script src='".$js."jquery.validate.js'></script>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/affiliate_custom_link', $data);
        }else{
            redirect('signout');
        }
    }

    public function createHtmlPartnersAffiliate($partnersAffiliatesCode){
        $str = '';

        if($partnersAffiliatesCode['rtn']){
            if($partnersAffiliatesCode['count'] > 0){
                foreach($partnersAffiliatesCode['result'] as $row){
                    $str .= '<tr id="rf-'.$row['id'].'">'
                        .'<td style="text-align:center;">'.$row['affiliate_code'].'</td>'
                        .'<td style="text-align:center;">'.$this->config->item('domain-www')."/register?id=".$row['affiliate_code'].'</td>'
                        .'</tr>';
                }
            }else{
                $str = '<td colspan="2" class="center">There are no records found.</td>';
            }
        }else{
            $str = '<td colspan="2" class="center">There are no records found.</td>';
        }
        return $str;
    }

    public function SetLimitofAffiliateCode($sub_partner_id){

        $defLimit = 10;

        //101889 - 7493, 101890-7494, 104833 - 10716
        $specialPartnersId = array(
            7493, 7494, 10716
        );

        $getCountAffiliates = $this->partners_model->getPartnersAffiliatesCode($sub_partner_id);

        if(in_array($sub_partner_id, $specialPartnersId)){
            return true;
        }else{
            if($getCountAffiliates['count'] < $defLimit){
                return true;
            }else{
                return false;
            }
        }

    }

    public function create_affiliate_link(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged')){

            $this->form_validation->set_rules('affiliate_link', 'Custom Affiliate Link', 'required|trim|xss_clean|is_unique[partnership_affiliate_code.affiliate_code]');
            $this->form_validation->set_message('is_unique', 'Affiliate code is already in use');


            if($this->form_validation->run() == true){
                $affiliate_code = $this->input->post('affiliate_link',true);
                $user_id = $this->session->userdata('user_id');
                if($this->isCPA) {
                    $sub_partner =$this->partners_model->getCPAReferenceSub($user_id);
                    $sub_partner_id = $sub_partner['partner_id'];
                }else{
                    $sub_partner_id = $user_id;
                }

                $setLimitofAffiliateCode = self::SetLimitofAffiliateCode($sub_partner_id);
                if($setLimitofAffiliateCode){
                    $checkunique = $this->partners_model->checkCustomAffiliateCode($affiliate_code);
                    if($checkunique){
                        $link = $this->config->item('domain-www');

                            if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){
                                $link .= '/zh';
                            }


                        $affiliate_link = $link.'/register?id='.$affiliate_code;
                        $insdata = array(
                            'partner_id' => $sub_partner_id,
                            'affiliate_code' => $affiliate_code,
                            'affiliate_link' => $affiliate_link
                        );
                        $this->db->trans_begin();
                        $insert_id = $this->general_model->insert('partnership_affiliate_code', $insdata);
                        if($insert_id>0){
                            $data['affiliate'] = $affiliate_code;
                            $data['error'] = false;
                            $getPartnersAffiliatesCode = $this->partners_model->getPartnersAffiliatesCode($sub_partner_id);
                            $data['result'] = $this->createHtmlPartnersAffiliate($getPartnersAffiliatesCode);
                            if ($this->db->trans_status() === FALSE)
                            {
                                $this->db->trans_rollback();
                            }
                            else
                            {
                                $this->db->trans_commit();
                            }
                        }else{
                            $data['error'] = true;
                            $data['message'] = 'Something went wrong. Please try again.';
                        }
                    }else{
                        $data['error'] = true;
                        $data['message'] = 'Affiliate Code is already taken.';
                    }
                }else{
                    $data['error'] = true;
                    $data['message'] = "You've reached the number limit of Affiliates code.";
                }
            }else{
                $data['error'] = true;
                $data['message'] = validation_errors();
            }

            echo json_encode($data);
        }else{
            show_404();
        }
    }

    public function affiliate_program(){

    }

    public function cpa(){

         if($this->session->userdata('logged')) {

            $type_array= array('0'=>'Pending','1'=>'Approved','2'=>'Declined');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                //$affiliate_code = $this->partners_model->getLimitDepositCount($sub_partner['partner_id']);
                //if(IPLoc::Office()){
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
               // }
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }
//            $cpa_type = $this->input->get('cpa');

//            $cpa_type = strlen($cpa_type)>0 ?$cpa_type:1;
            $cpa_type = 1;
//            echo $sub_partner['partner_id'];
            if($sub_partner) {
                if(FXPP::isEUUrl()){
                    $data['data']['cpa'] = $this->partners_model->getCpaReferralDepositList($sub_partner['partner_id']);
                }else{
                    $data['data']['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], $cpa_type);
                }

                $data['data']['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($sub_partner['partner_id']);
            }else{
                $data['data']['cpa'] = $this->partners_model->getCpaClientList($user_id, $cpa_type);
                $data['data']['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);

            }
            $data['data']['type'] = isset($type_array[$cpa_type])?$type_array[$cpa_type]:"1";
            $data['data']['active'] = $cpa_type;

            if(!$data['data']['PartnershipAgreementStatus']){
                redirect('');
            }

            $data['data']['isCPA'] = $this->isCPA;

            $data['data']['active_tab'] = 'partnership';
            $data['data']['active_sub_tab'] = 'cpa';
            $data['data']['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

                
            
            $js = $this->template->Js();
            $data['data']['metadata_description'] = lang('cpa_dsc');
            $data['data']['metadata_keyword'] = lang('cpa_kew');
            $this->template->title(lang('cpa_tit'))
                ->set_layout('internal/main')
                ->build('partnership/cpa', $data);
           }else{
              redirect('signout');
           }
        }
    /* public function extra_commission (){
         if($this->session->userdata('logged')) {
             $type_array= array('0'=>'Pending','1'=>'Approved','2'=>'Declined');
             $user_id = $this->session->userdata('user_id');
             $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
             $ext_type = $this->input->get('ext');
             $ext_type = strlen($ext_type)>0 ?$ext_type:1;
             $data['ext'] = $this->partners_model->getCpaClientList($user_id,$ext_type);
             $data['type'] = isset($type_array[$ext_type])?$type_array[$ext_type]:"1";
             $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);

             $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $data['partnership_type'] = $this->partners_model->getPartnershipType($user_id,'extra_commission');
             if(!$data['PartnershipAgreementStatus'])
             {
                 redirect('');
             }
             $data['isCPA'] = $this->isCPA;
             $data['active_tab'] = 'partnership';
             $data['active_sub_tab'] = 'extra_commission';
             $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

             $js = $this->template->Js();
             $data['metadata_description'] = lang('oth_com_dsc');
             $data['metadata_keyword'] = lang('oth_com_kew');
             $this->template->title(lang('oth_com_tit_e'))
                 ->set_layout('internal/main')
                 ->prepend_metadata('')
                 ->build('partnership/extra_commission', $data);
         }else{
             redirect('signout');
         }
     }*/


    public function extra_commission (){
        if($this->session->userdata('logged')) {
            $type_array= array('0'=>'Pending','1'=>'Approved','2'=>'Declined');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }
            $ext_type = $this->input->get('ext',true);
            $ext_type = strlen($ext_type)>0 ?$ext_type:1;
            //$data['ext'] = $this->partners_model->getCpaClientList($user_id,$ext_type);
            $data['type'] = isset($type_array[$ext_type])?$type_array[$ext_type]:"1";
            $data['extra'] = $ext_type;
            $data['no_of_registered_acc']= 0;

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $data['partnership_type'] = $this->partners_model->getPartnershipType($user_id,'extra_commission');
            if(!$data['PartnershipAgreementStatus'])
            {
                redirect('');
            }
            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'extra_commission';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $data['extra_commission_list'] = $this->partners_model->getExtraCommissionList($user_id);
            if($data['extra_commission_list']){
                $data['no_of_registered_acc'] = sizeof($data['extra_commission_list']);
            }


            $js = $this->template->Js();
            $data['metadata_description'] = lang('oth_com_dsc');
            $data['metadata_keyword'] = lang('oth_com_kew');
            $this->template->title(lang('oth_com_tit_e'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/extra_commission', $data);
        }else{
            redirect('signout');
        }
    }


    public function internal_transfer(){
        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            if (!$data['data']['PartnershipAgreementStatus']) {
                redirect('');
            }




            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($sub_partner) {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            } else {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);





            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'internal_transfer';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

            $condition = array('user_id'=> $user_id);
            $data['status'] = $this->general_model->whereCondition('internal_transfer',$condition);

            
//            if($_GET['id']=="frzf7")
//            {
//                print_r($data['status']);
//                echo $this->db->last_query();exit;
//            }
            
            
            $data['mpr'] = 'none';
            $referralsList = $this->partners_model->getPartnerReferralsByPartnerID($user_id);

            //if(IPLoc::APIUpgradeDevIP()){
                $dateFrom = 0;
                $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

                $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => 500000, 'Offset' => 0,'isCPA' => $this->isCPA);
                $referralsList = FXPP::getReferralsOfAccount($requestData)['referralList'];

                foreach ($referralsList as $key => $obj) {
                    $data['referral_acc_num'][] = array(
                        'account_number'    =>  $obj->LogIn,
                        'c_wallet_number'   =>  $obj->LogIn,
                    );
                }
           /* }else{
                $referralsList = $this->partners_model->getPartnerReferralsByPartnerID($user_id);

                foreach ($referralsList as $key => $value) {
                    $data['referral_acc_num'][] = array(
                        'account_number'    =>  $value['account_number'],
                        'c_wallet_number'   =>  $this->partners_model->getTTPaycoWallet($value['users_id'])['wallet_number'],
                    );
                }


                $data['account_number'] = array('' => 'Select Account Number');

                foreach ($referralsList as $key => $value) {
                    $data['account_number'][$value['account_number']] = $value['account_number'];
                }


            }*/
            
            
//status

            $data['metadata_description'] = lang('oth_com_dsc');
            $data['metadata_keyword'] = lang('oth_com_kew');
            $this->template->title(lang('oth_com_tit_e'))
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $this->template->Js() . "jquery.autonumeric.js'></script>")
                ->build('partnership/internal_transfer', $data);
        } else {
            redirect('signout');
        }
    }
    public function internal_transfer_test(){
        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            if (!$data['PartnershipAgreementStatus']) {
                redirect('');
            }

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($sub_partner) {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            } else {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }
            $data['modal_bonus_alert'] = $this->load->ext_view('modal', 'bonus_alert', '', TRUE);

            $account = $this->account_model->getAccountNumber($this->session->userdata('user_id'));
            $data['getAllAccountNumber'] = FXPP::inputAccountNumberWithBalance2($account['account_number'], $account['currency']);

            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'internal_transfer';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

            $condition = array('user_id'=> $user_id);
            $data['status'] = $this->general_model->whereCondition('internal_transfer',$condition);

            $data['mpr'] = 'none';
            $referralsList = $this->partners_model->getPartnerReferralsByPartnerID($user_id);

            if ($this->session->userdata('user_id') != 60247) {
                $data['account_number'] = array('' => 'Select Account Number');
            }

            foreach ($referralsList as $key => $value) {
                $data['account_number'][$value['account_number']] = $value['account_number'];
            }

            $referrals = $this->partners_model->getPartnerReferralsByPartnerID($this->session->userdata('user_id'));

            foreach ($referrals as $key => $value) {
                $data['referral_acc_num'][] = array(
                    'account_number'    =>  $value['account_number'],
                    'c_wallet_number'   =>  $this->partners_model->getTTPaycoWallet($value['users_id'])['wallet_number'],
                );
            }

            $data['metadata_description'] = lang('oth_com_dsc');
            $data['metadata_keyword'] = lang('oth_com_kew');
            $this->template->title(lang('oth_com_tit_e'))
                ->set_layout('internal/main')
                ->prepend_metadata("<script src='" . $this->template->Js() . "jquery.autonumeric.js'></script>")
                ->build('partnership/internal_transfer_test', $data);
        } else {
            redirect('signout');
        }
    }

    public function its_request(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $this->load->library('fx_mailer');
            $user_id = $this->session->userdata('user_id');
            $message = '';
            if (!$this->general_model->showssingle('internal_transfer','user_id',$user_id,'user_id')) {
                if($partner_info = $this->partners_model->getPartnerInfo($user_id)){
                    $subject = "Internal transfer request for ".$partner_info['reference_num'];
                    $partnerData = array(
                        'full_name' => $partner_info['full_name'],
                        'email' => $partner_info['email'],
                        'account_number' => $partner_info['reference_num'],
                        'subject' => $subject
                    );

                    // user_id request_date status reason update_date ref_num
                    $its = array(
                        'user_id'=>$user_id,
                        'request_date'=> date('Y-m-d h:i:s'),
                        'status' => 0,
                        'reason'=>'',
                        'ref_num'=>''
                    );

                    $this->general_model->insert('internal_transfer',$its);

                    $msg =  $this->load->view('email/internal_transfer_for_fxpp',$partnerData,true);
                    $returnPath = "noreply@mail.forexmart.com";
                    $from = "noreply@mail.forexmart.com";

                    if(Fx_mailer::sender("partnership@forexmart.com",$subject,$msg,$from,$returnPath)){

                        $msg =  $this->load->view('email/internal_transfer_for_partner',$partnerData,true);

                        $subject = "Internal transfer request for ".$partnerData['account_number'];
                        $partnerData['subject'] = $subject;
                        if(Fx_mailer::sender($partnerData['email'],$subject,$msg,$from,$returnPath)){
                            $message =  "Internal transfer service request successfully sent.";
                        }
                    } else {
                        $message =  "Internal transfer service request successfully sent but failed to send the email";
                    }
                }
            } else {
                $message = 'You already have an existing ITS request.';
            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'message' => $message
                        )
                    )
                );
        }else{
            redirect('signout');
        }
    }

    public function getCustomEmail() {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $acc_num = $this->input->post('acc_num');
            $user_info = array();

//            if ($this->session->userdata('user_id') != 60247) {
                $user_info = array(
                    'account_number' => $acc_num,
                    'email' => $this->account_model->getUserDetailsByAccountNumber($acc_num)['email']
                );
//            } else {
//                foreach ($acc_num as $value) {
//                    $acc_num = $value;
//                    $user_info[] = array(
//                        'account_number' => $acc_num,
//                        'email' => $this->account_model->getUserDetailsByAccountNumber($acc_num)['email']
//                    );
//                }
//            }

            $this->output->set_content_type('application/json')
                ->set_output(
                    json_encode(
                        array(
                            'result' => $user_info
                        )
                    )
                );
        }
    }

    public function affiliate_umbrella() {
        if(!$this->session->userdata('logged')) { redirect('signout'); }

//        if (IPLoc::Office()) {
            $user_id = $this->session->userdata('user_id');

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            if ($data['PartnershipAgreementStatus']) { redirect(''); }

            $condition = array('user_id'=> $user_id);
            $data['status'] = $this->general_model->whereCondition('internal_transfer',$condition);
            //$mpr = $this->general_model->showssingle3('manage_payco_registration','status',1,'user_id',$user_id,'user_id,status');
            $data['security_code'] = $this->partners_model->getAffiliateSecurityCodeByUserId($user_id)['security_code'];

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'affiliate-umbrella';

            $data['metadata_description'] = lang('oth_com_dsc');
            $data['metadata_keyword'] = lang('oth_com_kew');
            $this->template->title(lang('oth_com_tit_e'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/internal_transfer_affiliate', $data);
//        } else {
//            redirect('');
//        }

    }

    public function affiliate_request() {
        if(!$this->input->is_ajax_request()){ redirect('signout'); }
        if (!$this->session->userdata('logged')) { redirect('signout'); }

        $this->load->library('fx_mailer');

        $user_id = $this->session->userdata('user_id');
        $message = '';

        if (!$this->general_model->showssingle('internal_transfer','user_id',$user_id,'user_id')) {
            if ($this->account_model->getUserDetailsByUserId($user_id)) {
                $client_mt_details = $this->account_model->getAccountsByUserIdRow($user_id);
                $client_info = $this->account_model->getUserDetailsByAccountNumber($client_mt_details['account_number']);

                $subject = "Internal transfer request for ".$client_mt_details['account_number'];
                $emailData = array(
                    'full_name' => $client_info['full_name'],
                    'email' => $client_info['email'],
                    'account_number' => $client_mt_details['account_number'],
                    'subject' => $subject
                );

                $msg =  $this->load->view('email/internal_transfer_for_fxpp',$emailData,true);
                $returnPath = "noreply@mail.forexmart.com";
                $from = "noreply@mail.forexmart.com";

                if(Fx_mailer::sender("partnership@forexmart.com",$subject,$msg,$from,$returnPath)){

                    $msg =  $this->load->view('email/internal_transfer_for_partner',$emailData,true);

                    $subject = "Internal transfer request for ".$client_mt_details['account_number'];
                    $partnerData['subject'] = $subject;
                    if(Fx_mailer::sender($emailData['email'],$subject,$msg,$from,$returnPath)){
                        $message =  lang('its_10');
                    }
                } else {
                    $message =  lang('its_11');
                }

                $its = array(
                    'user_id' => $user_id,
                    'request_date' => date('Y-m-d h:i:s'),
                    'status' => 0,
                    'reason' => '',
                    'ref_num' => ''
                );
                $this->general_model->insert('internal_transfer',$its);
            }
        } else {
            $message = lang('its_12');
        }

        $this->output->set_content_type('application/json')
            ->set_output(
                json_encode(
                    array(
                        'message' => $message,
                    )
                )
            );
    }

    public function getSecurityCode() {
        if(!$this->input->is_ajax_request()){ redirect('signout'); }
        if (!$this->session->userdata('logged')) { redirect('signout'); }

        $user_id = $this->session->userdata('user_id');
        $security_code = mt_rand(111111,999999);
        $message = '';
        $success = false;

        $code_details = $this->partners_model->getAffiliateSecurityCodeByUserId($user_id);

//        if(IPLoc::frz())
//        {
//            echo "<pre>";
//            print_r($code_details);
//            
//            echo $this->db->last_query();exit;
//        }
        
        if (!$code_details){
            
            $its = array(
                'affiliate_user_id' => $user_id,
                'status' => 0,
                'security_code' => $security_code,
                'date_request' => date('Y-m-d h:i:s'),
            );
            $this->general_model->insert('its_security_code',$its);

            $code = $security_code;
            $success = true;
        } else {
            $date = date('F d, Y',$code_details['date_request']);
            $code = $code_details['security_code'];
            $message = lang('its_16') . $code_details['security_code'] . lang('its_17');
        }

        $this->output->set_content_type('application/json')
            ->set_output(
                json_encode(
                    array(
                        'code' => $code,
                        'message' => $message,
                        'success' => $success,
                    )
                )
            );
    }

    public function testReceiver() {
        parse_str(file_get_contents("php://input"),$_POST);
        $jsonEncoded = json_encode($_POST);
        $jsonData = json_decode($jsonEncoded, true);
        $email = $jsonData['email'];
        $token = $jsonData['token'];

        $checkMPRData = $this->partners_model->checkMPRData($email, $token);
        if ($checkMPRData) {
            $where = array(
                'email' => $email,
                'token' => $token,
            );
            $data = array('response' => json_encode($jsonData['response']));
            $this->partners_model->update_mpr($where,$data);

            $user_id = $checkMPRData['user_id'];
            $message = preg_replace('/\s+/', '', trim($jsonData['response']['Message']));

            if ($message == 'Success') {
                $checkMPRDataExist = $this->partners_model->getPayCoRegistrationById($user_id);
                if (!$checkMPRDataExist) {
                    $data =array(
                        'email'     =>  $email,
                        'user_id'   =>  $user_id,
                    );
                    $this->saveResellerData($data);
                }
            }
        }
    }

    function saveResellerData($data) {
        $isSuccess = false;
        $email = $data['email'];
        $user_id = $data['user_id'];

        $result = FXPP::PayCo_ResellerData($email);

        if ($result['Message'] == 'Success') {
            $mpr_info = $this->general_model->showssingle('manage_payco_registration','user_id',$user_id,'id, status');
            $user_info = $this->general_model->showssingle('user_profiles','user_id',$user_id,'full_name');

            if ($mpr_info['status'] < 1) {
                $table = '';

                foreach ($result['Data']['wallet'] as $key => $value) {
                    $wallet_info = array(
                        'mpr_id'        =>  $mpr_info['id'],
                        'wallet_number' =>  $value['wallet'],
                        'currency'      =>  $value['currency'],
                        'created_date'  =>  date('Y-m-d H:i:s', strtotime('now')),
                    );
                    $this->general_model->insert('its_payco_wallets',$wallet_info);

                    $table .= "<tr>
                                <td padding: 0 5px'>" . $value['currency'] . "</td>
                                <td padding: 0 5px'>" . $value['wallet'] . "</td>
                              </tr>";
                }

                $data = array(
                    'username'      =>  $result['Data']['username'],
                    'password'      =>  $result['Data']['password'],
                    'merchant_id'   =>  $result['Data']['mid'],
                    'updated_date'  =>  date('Y-m-d H:i:s', strtotime('now')),
                    'status'        =>  1,
                );
                $this->general_model->updatemy('manage_payco_registration','id',$mpr_info['id'],$data);

                // Send mail to Client for notification of verified PayCo Reseller Data
                $config = array(
                    'mailtype'=> 'html'
                );

                $email_data['full_name'] = $user_info['full_name'];
                $email_data['body'] = 'You are granted access to ForexMart Transit Transfer.'.
                    '<p>Please see Wallet Details below:</p><br/><table cellspacing="0" border="1" >'. $table .
                    '</table><br/><br/> For non-partners, please contact your affiliate Partner to proceed with Transit Transfer.' .
                    '<br/><br/>Should you have any assistance, please contact us at partnership@forexmart.com. ';
                $email_data['closing_remark'] = '<span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team';

                $this->load->library('email');
                if($config != null){
                    $this->email->initialize($config);
                }

                $this->SMTPDebug = 1;
                $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
                $this->email->to($email);
                $this->email->bcc('raihana@zetaol.com');
                $this->email->subject('ForexMart Transit Transfer');
                $this->email->message($this->load->view('email/general_mail-html', $email_data, true));

                if(!$this->email->send()){
                    $email_sending = $this->email->print_debugger();
                } else {
                    $email_sending = 'worked';
                }

                $this->partners_model->insertITSTest(array('response' => $email_sending));
            }
            $isSuccess = true;
        }

        return $isSuccess;
    }

    public function testValidate() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect('signout'); }

        $reseller_token = $this->input->post('token');
        $account_number = $this->input->post('account_number');

        $returnData = array(
            'error'     =>  false,
            'message'   =>  '',
        );

        if ($account_number == '') {
            $partner_info = $this->account_model->getAccountByPartnerId($this->session->userdata('user_id'));
            $account_number = $partner_info['account_number'];
        }

        $partner_user_id = $this->account_model->getUserDetailsByAccountNumber_partner($account_number);
        if (!$partner_user_id) {
            $user_info = $this->account_model->getUserDetailsByAccountNumber($account_number);
        } else {
            $user_info = $this->partners_model->getPartnerInfo($partner_user_id['user_id']);
        }

        $email = $this->input->post('email');
        $full_name = explode(' ', $user_info['full_name']);
        $contact = trim($user_info['phone1']);

        $checkPlus = substr($contact, 0, 1);
        $checkContactLength = strlen($contact);

        if ($user_info['dob'] == '' || $user_info['street'] == '' || $user_info['city'] == '' || $user_info['state'] == '' || $user_info['zip'] == '' || $user_info['phone1'] == '' || $checkContactLength < 8) {
            $returnData['error'] = true;
            $returnData['message'] = 'Please complete your information first. Update your information <a href="'.base_url('profile/edit').'">here</a>.';

            return $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'result'    =>  '',
                'error'     =>  $returnData['error'],
                'message'   =>  $returnData['message'],
            )));
        }

        $responseArray = array(
            'Token' => $reseller_token,
            'Registration' => array(
                'Salutation' => 'Mr.',
                'Email' => $email,
                'Firstname' => $full_name[0],
                'Lastname' => $full_name[1],
                'Birthdate' => $user_info['dob'],
                'Address1' => $user_info['street'],
                'Address2' => $user_info['street'],
                'City' => $user_info['city'],
                'Region' => $user_info['state'],
                'Country' => $user_info['country'],
                'Postal' => $user_info['zip'],
                'Contact' => $checkPlus == '+' ? $contact : '+' . $contact,
                'Ip' => $user_info['last_ip'],
            ),
        );

        $xml = new SimpleXMLElement('<rootTag/>');
        $this->to_xml($xml, $responseArray);
        $simpleXML = $xml->asXML();
        $baseEncoded = base64_encode($simpleXML);

        $url_callback = 'https://www.pay.co/support/prevalidate';
        $responseToken = array(
            'response' => $baseEncoded,
            'token' => $reseller_token,
        );

        $params = array(
            'fields' => $responseToken,
            'statusUrl' => $url_callback,
        );

        $curlResult = FXPP::CurlToSite($params, 0);

        $result = array(
            'curl_result' => $curlResult,
            'response_array' => $responseArray,
        );

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'result'    =>  $result,
            'error'     =>  $returnData['error'],
            'message'   =>  $returnData['message'],
        )));
    }

    public function testValidate2() {
        $this->load->model('partners_model');

        $reseller_token = 'gdwuiWHlL';
        $account_number = 264956;

        $returnData = array(
            'error'     =>  false,
            'message'   =>  '',
        );

        if ($account_number == '') {
            $partner_info = $this->account_model->getAccountByPartnerId($this->session->userdata('user_id'));
            $account_number = $partner_info['account_number'];
        }

        $partner_user_id = $this->account_model->getUserDetailsByAccountNumber_partner($account_number);
        if (!$partner_user_id) {
            $user_info = $this->account_model->getUserDetailsByAccountNumber($account_number);
        } else {
            $user_info = $this->partners_model->getPartnerInfo($partner_user_id['user_id']);
        }

        $email = 'bktantest043@gmail.com';
        $full_name = explode(' ', $user_info['full_name']);

        if ($user_info['dob'] == '' || $user_info['street'] == '' || $user_info['city'] == '' || $user_info['state'] == '' || $user_info['zip'] == '' || $user_info['phone1'] == '') {
            $returnData['error'] = true;
            $returnData['message'] = 'Please complete your information first. Update your information <a href="'.base_url('profile/edit').'">here</a>.';

            echo '<pre>';
            print_r(array(
                'result'    =>  '',
                'error'     =>  $returnData['error'],
                'message'   =>  $returnData['message'],
            ));
            echo '</pre>';exit;
        }

        $contact = trim($user_info['phone1']);
        $checkPlus = substr($contact, 0, 1);

        $responseArray = array(
            'Token' => $reseller_token,
            'Registration' => array(
                'Salutation' => 'Mr.',
                'Email' => $email,
                'Firstname' => $full_name[0],
                'Lastname' => $full_name[1],
                'Birthdate' => $user_info['dob'],
                'Address1' => $user_info['street'],
                'Address2' => $user_info['street'],
                'City' => $user_info['city'],
                'Region' => $user_info['state'],
                'Country' => $user_info['country'],
                'Postal' => $user_info['zip'],
                'Contact' => $checkPlus == '+' ? $contact : '+' . $contact,
                'Ip' => $user_info['last_ip'],
            ),
        );

        $xml = new SimpleXMLElement('<rootTag/>');
        $this->to_xml($xml, $responseArray);
        $simpleXML = $xml->asXML();
        $baseEncoded = base64_encode($simpleXML);

        $url_callback = 'https://www.pay.co/support/prevalidate';
        $responseToken = array(
            'response' => $baseEncoded,
            'token' => $reseller_token,
        );

        $params = array(
            'fields' => $responseToken,
            'statusUrl' => $url_callback,
        );

        $curlResult = FXPP::CurlToSite($params, 0);

        $result = array(
            'curl_result' => $curlResult,
            'response_array' => $responseArray,
        );

        echo '<pre>';
        print_r(array(
            'result'    =>  $result,
            'error'     =>  $returnData['error'],
            'message'   =>  $contact,
        ));
        echo '</pre>';exit;

    }

    function to_xml(SimpleXMLElement $object, array $data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                $this->to_xml($new_object, $value);
            } else {
                $object->addChild($key, $value);
            }
        }
    }

    public function testSaveResellerData() {
        $email = 'ohmyglobness18@gmail.com';
        $user_id = 199576;

        $user_info = $this->general_model->showssingle('user_profiles','user_id',$user_id,'full_name');

        $table = '';

        // Send mail to Client for notification of verified PayCo Reseller Data
        $config = array(
            'mailtype'=> 'html'
        );

        $email_data['full_name'] = $user_info['full_name'];
        $email_data['body'] = 'You are granted access to ForexMart Transit Transfer.'.
            '<p>Please see Wallet Details below:</p><br/><table cellspacing="0" border="1" >'. $table .
            '</table><br/><br/> For non-partners, please contact your affiliate Partner to proceed with Transit Transfer.' .
            '<br/><br/>Should you have any assistance, please contact us at partnership@forexmart.com. ';
        $email_data['closing_remark'] = '<span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team';

        $this->load->library('email');
        if($config != null){
            $this->email->initialize($config);
        }

        $this->SMTPDebug = 1;
        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->to($email);
        $this->email->bcc('raihana@zetaol.com');
        $this->email->subject('ForexMart Transit Transfer');
        $this->email->message($this->load->view('email/general_mail-html', $email_data, true));

        if(!$this->email->send()){
            echo $this->email->print_debugger();
        }
    }

    public function testEmpty() {
        $user_info = $this->general_model->showssingle('user_profiles', 'user_id', 200273, 'full_name, dob, street, city, state, zip');
        $contact_info = $this->general_model->showssingle('contacts', 'user_id', 200273, 'phone1');
        $checkContactLength = strlen($contact_info['phone1']);

        if ($user_info['dob'] == '') {
            print_r('empty string');
        }
        if ($user_info['dob'] == NULL) {
            print_r('null');
        }

        echo '<pre>';
        var_dump($user_info);
        var_dump($contact_info);
        echo '</pre>';
        exit;
    }

    public function getAffiliateInfo() {
        if (!$this->input->is_ajax_request()) { die('Not authorized!'); }
        if (!$this->session->userdata('logged')) { redirect('signout'); }

        $account_number = $this->input->post('value');
        $user_id = $this->general_model->showssingle('mt_accounts_set', 'account_number', $account_number, 'user_id');
        $full_name = $this->general_model->showssingle('user_profiles', 'user_id', $user_id['user_id'], 'full_name,user_id');

        return $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'full_name' =>  $full_name['full_name'],
            'id'        =>  $full_name['user_id']
        )));
    }

    public function commission_test(){
        ini_set('max_execution_time', 0);

        if($this->session->userdata('logged')) {

            $this->load->model('partners_model');
            $this->load->model('account_model');
            $this->load->model('General_model');
            $this->g_m=$this->General_model;

            $user_id = $this->session->userdata('user_id');

            if($this->isCPA){
                redirect(FXPP::my_url('partnership/cpa'));
            }

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'commission';

            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];

            $from = DateTime::createFromFormat('Y/d/m H:i:s', '2015/05/05 00:00:00');
            $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m').' 23:59:59');

            $ac = $this->account_model->getAccountNumberByUserId( $user_id );


            $data['data']['accountnumber']=$ac['account_number'];
            $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;
            $accountnumbers = $ac['account_number'];

            if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
                $account_info2 = array(
                    'iLogin' =>241800,
                    'from' =>$from->format('Y-m-d\TH:i:s') ,
                    'to' =>  $to->format('Y-m-d\TH:i:s')
                );

            }else{
                if (IPLoc::Office()){

                    $webservice_config = array('server' => 'live_new');
                    $account_info = array('iLogin' => $accountnumbers);
                    $WSAD = new WebService($webservice_config);
                    $WSAD->open_RequestAccountDetails($account_info);
                    if ($WSAD->request_status === 'RET_OK') {
                        $account_info2 = array(
                            'iLogin' =>$accountnumbers,
                            'from' => $WSAD->get_result('RegDate') ,
                            'to' =>  $to->format('Y-m-d\TH:i:s')
                        );
                    }

                }else{
                    $account_info2 = array(
                        'iLogin' =>$accountnumbers,
                        'from' =>$from->format('Y-m-d\TH:i:s') ,
                        'to' =>  $to->format('Y-m-d\TH:i:s')
                    );
                }


            }


//            $getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);
//            $data['getCommissionData'] = $getCommissionData;


            //FXPP-2479
            $data['user_id'] = $this->session->userdata('user_id');
            $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');

            $data['partner_agreement']=0;
            if($data['users']){
                if($data['users']['partner_agreement']==1){
                    $data['partner_agreement']=1;
                }
            }
            //FXPP-2479
            //            }


            $js = $this->template->Js();
            $data['metadata_description'] = lang('com_dsc');
            $data['metadata_keyword'] = lang('com_kew');
            $this->template->title(lang('com_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                        <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('partnership/commission', $data);
        }else{
            if($_GET['login'] == 'partner'){
                if($_SESSION['url']){
                    unset($_SESSION['url']);
                }
                $_SESSION['url'] = 'partnership/commission_test';
                redirect('partner/signin');
            }
            redirect('signout');
        }

    }

    public function getCommissionDataChart_test($account_info, $opt){
        ini_set('max_execution_time', 0);
        $totalCommission = 0;

        $defaultData = array(
            'startDate' => '2015-05-05',
            'endDate'   =>  date('Y-m-d'),
            'chart'     =>  array(),
            'pagination' => ''
        );

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAgentsCommissionByDate($account_info);
        $html_commission = '';
        if($WebService->request_status === 'RET_OK'){

            $CommisionList =  $WebService->get_result('CommisionList');
            $countCommissionList = (array) $CommisionList;

            if(!empty($countCommissionList)){
                $CommissionData = json_encode($CommisionList->CommissionData);
                $CommisionListRecord = json_decode($CommissionData, true);

                $startDate = reset($CommisionListRecord);
                $endDate = end($CommisionListRecord);

                $startDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $startDate['Date']);
                $endDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $endDate['Date']);

                $defaultData['startDate'] = $startDate->format('Y-m-d');
                $defaultData['endDate'] = $endDate->format('Y-m-d');

                $val=0;
                $totalCommission = 0;
                if(is_array($CommisionListRecord)){
                    foreach($CommisionListRecord as $d){
                        $datetime = strtotime($d['Date']) * 1000;

                        if($opt=='no'){
                            $val = $d['Amount'];
                        }else{
                            $val = $val + $d['Amount'];
                        }
                        $defaultData['chart'][] = "[$datetime, $val]";
                        $totalCommission = $totalCommission + $d['Amount'];
                    }
                    foreach($CommisionListRecord as $d){
                        $html_commission .= "<tr> <td>".$d['Date']."</td><td>".$d['Amount']."</td><td>". $d['FromAccount']."</td><td>". $d['Symbol']."</td></tr>";
                    }

                }else{
                    $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                }
            }else{
                $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
            }
        }else{
            $defaultData['chart'][] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
        }

        $defaultData['totalCommission'] = $totalCommission;

        return $defaultData;

    }

    public function getRefCommision($agent=262259,$from="",$to=""){
         if(empty($from) && empty($to)){
             $from = date('Y-m-d\T00:00:00', strtotime('2014-01-01'));
             $to = date('Y-m-d\T23:59:59', time());
         }else{
             $from = date('Y-m-d\T00:00:00', strtotime($from));
             $to = date('Y-m-d\T23:59:59', strtotime($to));
         }


        $webservice_config = array('server' => 'live_new');
        $WS_GT = new WebService($webservice_config);
        $arrayName = array(
            'iAgent' =>$agent,
            'from' => $from,
            'to' => $to,
        );
        $WS_GT->GetAgentTotalCommissionGroupByAccount($arrayName);
        $commissionTotal = $WS_GT->get_all_result();
        if(!empty($commissionTotal['CommissionTotal'])){

            $ref_list = array();
            foreach($commissionTotal['CommissionTotal'] as $d){
                $ref_list[$d->FromAccount]= $d->TotalAmount;

            }
            return $ref_list;
        }
        return false;


    }

    public function getAllReferrals(){
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('user_id');
//            if($user_id == 132478){
//                $user_id = 239015;
//            }

            $tab = $this->input->post('tab');
            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];

            $from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
            $to = date("Y-m-d 23:59:59");
            switch($tab){
                case "all":     $from= $from; break;
                case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
                case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
                case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
                case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
                case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
                case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
            }
            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);


            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

            $account_num = count($mt)>0?$mt:$pt['reference_num'];
            $all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
             $active_accounts = array();

            foreach ($all as $key){
                $referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
                if(count($referrals)>0){
                    foreach ($referrals as $key) {
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
                         //   if($apiInfo_active['Agent']==$account_num){
                                 $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 //   $status = ($getTotalDeposit > $TotalBonusFund)?'Confirmed':'Unconfirmed';
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = 'Confirmed';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';
//                                if(IPLoc::Office()){
//                                    print_r($account1);
//                                }
                                $record .= '<tr><td style="text-align: center;">' . date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])). '</td>';
                                $record .= '<td style="text-align: center;">' . $account[0]->account_number. '</td>';
                               if(FXPP::showReferralAccountBalance()){
                                   $amount = $accountFunds['Balance'];
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Name'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$amount.'</td>';
                                   if(FXPP::showCommisionAmount()){
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $record .= '<td style="text-align: center;">'.$comission.'</td>';
                                   }






                                   if(FXPP::showReferralAccountContactDetails()){
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Email'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['PhoneNumber'].'</td>';
                                   }

                               }
                                $record .= '<td style="text-align: center;">'.$status.'</td>';
                                $record .= '<td style="text-align: center;">'.$ver_stat.'</td></tr>';
                        //    }
                       }
                    }
                }
            }

            $affiliate_codes = array();
            foreach ($all as $key) {
                $affiliate_codes[] = $key->affiliate_code;
            }

            /*GRAPH*/
            $from = date("Y-m-d",strtotime($from));
            $to = date("Y-m-d",strtotime($to));
            if(IPLoc::Office()){
                if($active_accounts){
                    $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode2($affiliate_codes,$active_accounts,$from,$to);
                } else {
                    $getAllReferrals_graph = '';
                }

            }else{
                $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode($all[0]->affiliate_code,$from,$to);
            }

            if(count($getAllReferrals_graph)>0){
                $ctr_alref = 0;
                for($i=0;$i<count($getAllReferrals_graph);$i++){
                    $datetime = strtotime( $getAllReferrals_graph[$i]['date_created'] ) * 1000;
                    $ctr_alref = $ctr_alref + ($getAllReferrals_graph[$i]['referralCount']);
                    $click_data[] = array('0'=>$datetime, '1'=>$ctr_alref );
                }
                $data['chart'] = $click_data;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }
            /*GRAPH*/

            $data = array( 'success' => true , 'error'=>'','record'=>$record,'chart1'=>$data['chart'],"fromDate"=>$from,"toDate"=>$to );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function getUserdetails($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
        $webService->request_account_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        }else{
            $data = false;
        }
        return $data;
    }
    public function GetAgentStats($iLogin){
        $account_info = array( 'iLogin' => $iLogin );
        $webservice_config = array(  'server' => 'live_new' );
        $WebService2 = new WebService($webservice_config);
        $WebService2->ReqAgentStats($account_info);
        $ReqAgentStats = (array) $WebService2->get_all_result();
        if($ReqAgentStats){
            $data['user_referrals']  = $ReqAgentStats["ReferralsCount"];
            $data['user_commission'] = $ReqAgentStats["TotalCommission"];
        }else{
            $data['user_commission'] = 0;
            $data['user_referrals']  = 0;
        }
        return $data;
    }
    public function checkAccountReferrals(){
        if (IPLoc::Office()) {
            echo "<pre>";
            $user_id = 224403;
            $record = [];
            $record1 = [];
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];
            $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');
            $account_num = count($mt)>0?$mt:$pt['reference_num'];
            $from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
            $to = date("Y-m-d 23:59:59");
            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');
            $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
            $all = array_merge($allAffiliateCode0,$allAffiliateCode1);
            foreach ($all as $key){
                $referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
                if(count($referrals)>0){
                    foreach ($referrals as $key) {
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
//                        print_r($account1);exit;
                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        $apiStatus = $apiInfo_active['Agent']==$account_num?$apiInfo_active['Agent']:'No agent in API';
                            if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1->nodepositbonus) {
                                    $status = ($getTotalDeposit > $accountFunds['TotalBonusFund'])?'Confirmed':'Unconfirmed';
                                } else {
                                    $status = 'Confirmed';
                                }
                                $ver_stat = $account1->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';
                                if($apiStatus=='No agent in API'){
                                    $record1[] = array(
                                        "date" => date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])),
                                        "account_number"=> $account[0]->account_number,
                                        "status"=> $status,
                                        "verified_status"=> $ver_stat,
                                    );
                                }else{
                                    $record[] = array(
                                        "date" => date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])),
                                        "account_number"=> $account[0]->account_number,
                                        "status"=> $status,
                                        "verified_status"=> $ver_stat,
                                    );
                                }

                            }

                    }
                }
            }

            print_r($record1);
        }
    }


    public function referrals_test(){    if($this->session->userdata('logged')) {

            //load new referrals data and save to referrals table
//            $this->referralPreProcess();

//            $this->lang->load('referrals');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;

            //$referrals = $this->partners_model->getReferralsbyAffiliateCode($affiliate_code[0]['affiliate_code']);
            //  $data['referralList'] = $this->createReferralList($referrals);

            $postData = array(
                'user_id' => $user_id
            );

            if($this->isCPA) {
                if ($sub_partner) {
                    $postData['user_id'] = $sub_partner['partner_id'];
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                } else {
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                }
            }else{
                $click = $this->partners_model->getRegisteredAccRefDef($postData);
            }

            //$chart = "[". strtotime($ac_created)*1000 .",0],";
//            if(IPLoc::Office()){
                $from = date("Y-m-d",strtotime("2015-05-05"));
                $to = date("Y-m-d");
                $getAllReferrals = $this->partners_model->getReferralCountofAffiliateCode($affiliate_code[0]['affiliate_code'],$from,$to);

                if(count($getAllReferrals)>0){
                    $ctr_alref = 0;
                    for($i=0;$i<count($getAllReferrals);$i++){
                        $datetime = strtotime( $getAllReferrals[$i]['date_created'] ) * 1000;
                        $ctr_alref = $ctr_alref + ($getAllReferrals[$i]['referralCount']);
                        $click_data[] = "[$datetime, $ctr_alref]";
                    }
                    $chart1 =  join($click_data,",");
                    $data['chart'] = $chart1;
                    $data['status'] = 1;
                }else{
                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                    $data['status'] = 0;
                }
//            }else{
//                if(is_array($click['result'])){
//                    foreach($click['result'] as $d){
//                        $datetime = strtotime($d->date) * 1000;
//                        if(strlen($datetime)>5){
//                            $value = $d->acnum;
//                            $click_data[] = "[$datetime, $value]";
//                        }
//                    }
//
//                    $chart1 =  join($click_data,",");
//
//                    $data['chart'] = $chart1;
//                    $data['status'] = 1;
//                }else{
//                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
//                    $data['status'] = 0;
//                }
//            }
            $data['test'] = $affiliate_code['affiliate_code'];

            $data['date_from'] = $click['first_row']['date'];
            $data['date_to'] = $click['last_row']['date'];

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($this->isCPA) {
                if ($sub_partner) {
                    $user_id = $sub_partner['partner_id'];
                }
            }

            $postData = array(
                'user_id' => $user_id,
                'date_from' =>  date('Y-m-d', strtotime($click['first_row']['date'])),
                'date_to' => date('Y-m-d', strtotime($click['last_row']['date']))
            );
            $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
            $data['referralsTotal'] = $countAllReferrals['count'];

//            if(IPLoc::Office()){
                $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, '*')['account_number'];
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, '*')['reference_num'];
                $account = $mt?$mt:$pt;
                $data['agentStats'] =  $this->GetAgentStats($account);
                $data['referralsTotal'] =  $data['agentStats']["user_referrals"];
//            }

            $data['isCPA'] = $this->isCPA;
            //  $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];



            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');
			
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referrals_test', $data);
        }else{
            redirect('signout');
        }
    

    }

    public function getUserdetails2($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
        $webService->request_account_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        }else{
            $data = false;
        }
        print_r($data);
//        return $data;
    }

    public function getSubs($account_number){
        $this->load->model('partners_model');
        $referralClient = $this->partners_model->getAffiliateCodeofAgent($account_number); //CLIENT REFERRAL
        var_dump($referralClient);
    }



    public function second_affiliates()
    {
        show_404();
       

        if(IPLoc::APIUpgradeDevIP()){
            $this->sub_affiliates();
        }else {


            $data['result'] = array();
            $this->load->model('Partners_model');

            $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
            $user_id = $this->session->userdata('user_id');
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);

            $data['is_client'] = ($data['PartnershipAgreementStatus']) ? false : $this->general_model->showssingle("mt_accounts_set", "user_id", $user_id);


            if (!$data['data']['PartnershipAgreementStatus'] and !$data['is_client']) {

                redirect('');

            }


            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($sub_partner) {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'partner_id,reference_num, type_of_partnership');
            } else {
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'partner_id,reference_num, type_of_partnership');
            }

            if (IPLoc::Office()) {
                if (!$pt) {

                    $pt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'user_id as partner_id, account_number as reference_num');
                }
            } else {
                if (!$pt) {
                    $pt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'user_id as partner_id, account_number as reference_num');
                }
            }


            $data['info_sub_ib'] = array();
            $account_number = $pt['reference_num'];
            $referralClient = $this->Partners_model->getAffiliateCodeofAgent($account_number, 'partner')['rows']; //CLIENT REFERRAL

            if (count($referralClient) > 0) {
                foreach ($referralClient as $key) {
                    $affiliates = $this->partners_model->getReferralsByCode($key->affiliate_code)['rows'];

                    foreach ($affiliates as $key => $value) {

                        //               $apiInfo_active = $this->getUserdetails($value->account_number);
                        //                if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ) {
                        $data['info_sub_ib'][$value->affiliate_code] = array(
                            'account_number'          => $value->account_number,
                            'registration_date'       => date("Y-m-d", strtotime($value->registration_time)),
                            'total_referral'          => 0,
                            'affiliate_code'          => $value->affiliate_code,
                            'referral_affiliate_code' => $value->referral_affiliate_code,
                            'name'                    => $value->full_name,
                            'email'                   => $value->email,
                            'phone_no'                => $value->phone1,
                        );
                        //  }
                    }
                }
            }
            foreach ($data['info_sub_ib'] as $key_sub => $value_sub) {
                $affiliates3rd = $this->partners_model->getReferralsByCode($value_sub['affiliate_code'])['rows'];
                foreach ($affiliates3rd as $key_3 => $value_3) {

                    if (array_key_exists($value_3->referral_affiliate_code, $data['info_sub_ib'])) {
                        $data['info_sub_ib'][$value_3->referral_affiliate_code]['total_referral'] += 1;

                    }
                }

            }

            $sub_acc_num = array(
                'account_number' => $account_number
            );

            $sub_permission = $this->partners_model->getSubPermissionData($sub_acc_num);

            //if(IPLoc::Office()){
            //$data['sub_permission'] = explode('|', $sub_permission->permission);
            $data['sub_permission'] = FXPP::referrals_table_permission(FXPP::sub_affiliate_table(), $sub_permission->permission);

            // print_r($ex);exit;
            // }
            //$data['sub_permission'] = $sub_permission->permission;
            //echo '<pre></pre>'; print_r($data['sub_permission'][3]);exit;


            array_multisort(array_column($data['info_sub_ib'], 'total_referral'), SORT_DESC, $data['info_sub_ib']); // sort multiple arrays from largest to smallest amount


            $data['isCPA'] = $this->isCPA;
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'sub_affiliates';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $data['metadata_description'] = lang('oth_com_dsc');
            $data['metadata_keyword'] = lang('oth_com_kew');
            $this->template->title(lang('oth_com_tit_e'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "sub_ib_tree.css'>
                 ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/sub_ib_commission_tree', $data);

        }
    }

    
    public function sub_affiliates(){
        show_404();
       
        $data['result'] = array();
        $this->load->model('Partners_model');

        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|xss_clean');
        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);

        $data['is_client']=($data['PartnershipAgreementStatus'])?false:$this->general_model->showssingle("mt_accounts_set","user_id",$user_id) ;
        
        if(!$data['data']['PartnershipAgreementStatus'] and !$data['is_client']) {redirect('');}


        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
        } else {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
           
        }

        $data['ref_table'] =   FXPP::referrals_table_permission(FXPP::sub_affiliate_table(),$this->sub_affiliate_permission());
        
        $data['isCPA'] = $this->isCPA;
        $data['active_tab'] = 'partnership';
        $data['active_sub_tab'] = 'sub_affiliates';
        $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
        $data['metadata_description'] = lang('oth_com_dsc');
        $data['metadata_keyword'] = lang('oth_com_kew');
        $this->template->title(lang('oth_com_tit_e'))
            ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."sub_ib_tree.css'>
                 ")
            ->set_layout('internal/main')
            ->prepend_metadata('')
            ->build('partnership/sub_affiliates', $data);

    }
    
    public function getSubAffiliates(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
            

            $offset = (int) $this->input->post('start', true);
            $rowPerPage = (int) $this->input->post('length', true);
            $draw = (int) $this->input->post('draw', true);
            $dateFrom = 0;
            $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

            $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $rowPerPage, 'Offset' => $offset,'isCPA' => $this->isCPA);
            $referralData = FXPP::getReferralsOfAccount($requestData);
            $dataCount = $referralData['referralCount']; //total count
            $referralList = $referralData['referralList'];
            
            $accounts = array_map(function ($e) { //return array / object column
                return is_object($e) ? $e->LogIn : $e['LogIn'];
            }, $referralList);

            $requestData2 = array('Accounts'=>$accounts,'isCPA' => $this->isCPA);
            $countPerReferral = $this->getReferralsCount($requestData2);
            $data = array();
            if ($dataCount > 0) {
                foreach ($referralList as $key => $obj) {

                    $accountNumber = $obj->LogIn;
                 
                    $unixRegDate = new DateTime("@$obj->RegDate");
                    $regDate = $unixRegDate->format('d-m-Y');
                    $fullName = $obj->Name;
                    $Email = $obj->Email;
                    $PhoneNumber = $obj->PhoneNumber;


                    $full_table = array(

                        0 => $fullName, 
                        1 => $Email,
                        2 => $PhoneNumber, 
                        3 => $regDate, 
                        4 => isset($countPerReferral[$accountNumber]['count']) ? $countPerReferral[$accountNumber]['count'] : '0',
                        5 => $accountNumber,
                        6 => '<button class="affiliates" style="color: #fff!important;margin: 0 auto;transition: all ease 0.3s;background: #29a643;border: none;width: 50px;padding: 5px;" data-code="'.$accountNumber.'">View</button>',
                    );


                    $tempArray =   array_values(FXPP::referrals_table_permission($full_table,$this->sub_affiliate_permission()));

                    $data[] = $tempArray;
                }
            }


            $result = array(
                'draw'            => $draw,
                'recordsTotal'    => $dataCount,
                'recordsFiltered' => $dataCount,
                'data'            => $data
            );

            echo json_encode($result);
        }
        

    }

    public function getlevelTwoReferrals()
    {
        if ($this->input->is_ajax_request()) {
            $account = $this->input->post('account');
            $dateFrom = 0;
            $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));
            $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => 10000, 'Offset' => 0,'Accounts' => array($account),'isCPA' => $this->isCPA);
            $referralData = FXPP::getReferralsOfAccount($requestData);
            $dataCount = $referralData['referralCount']; //total count
            $referralList = $referralData['referralList'];

            if ($dataCount > 0) {
                $referrals = '';
                foreach ($referralList as $key => $value) {
                   $type =  ($this->getGroupCodeType($value->Group) == 'Pa') ? 'Partner' : 'Client';
                $referrals .= '<tr>
                          <td>' . $value->LogIn . '</td>
                          <td>' . $value->Name . '</td>
                          <td>' . $type . '</td>
                 
                        </tr>';
               }

            }


            $this->output->set_content_type('application/json')->set_output(json_encode(array('referrals' => $referrals)));
        }
    }




    public function requestReferralsCount(){
      
        $requestData = array('isCPA' =>$this->isCPA);
        $totalReferred = $this->getReferralsCount($requestData,true);
  

        $this->output->set_content_type('application/json')->set_output(json_encode(array('totalReferred' => $totalReferred)));

    }
    public function requestReferralTradedlots(){
        $user_id = $this->session->userdata('user_id');

        if(IPLoc::APIUpgradeDevIP()){
            $offset = 0;
            $rowPerPage = 10000;
            $dateFrom = 0;
            $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

            $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $rowPerPage, 'Offset' => $offset,'isCPA' => $this->isCPA);
            $referralData = FXPP::getReferralsOfAccount($requestData);
            $dataCount = $referralData['referralCount']; //total count
            $referralList = $referralData['referralList'];
            $referralListDecode = json_decode(json_encode($referralList['referralList']), true);
            $referralGroup = array_column($referralListDecode, 'Group','LogIn');
            
            $accounts = array_map(function ($e) { //return array /object column
                return is_object($e) ? $e->LogIn : $e['LogIn'];
            }, $referralList);

            $dateFrom = 0;
            $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));
            $requestData2 = array('From' => $dateFrom, 'To' => $dateTo,'Accounts' => $accounts,'isCPA' => $this->isCPA);


            $totalLots = $this->getReferralTotalLots($requestData2,true,$referralGroup);


        }else{

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            $totalRefVolume = 0;
            if ($sub_partner) {
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'partner_id,reference_num, type_of_partnership');
            } else {
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'partner_id,reference_num, type_of_partnership');
            }

            $totalLots = 0;
            $totalVolume = 0;
            $account_number = $pt['reference_num'];
            $referralClient = $this->partners_model->getAccountDetailsByAcctNumber1($account_number, 'partner')['rows']; //CLIENT REFERRAL

            if (count($referralClient) > 0) {
                foreach ($referralClient as $key) {
                    $affiliates = $this->partners_model->getAffiliates1($key->affiliate_code)['rows'];
                    foreach ($affiliates as $key => $value) {
                        $affiliateData = $this->general_model->showssingle('mt_accounts_set', 'account_number', $value->account_number, 'mt_account_set_id,mt_currency_base');

                        $account_info = array(
                            'iLogin' => $value->account_number
                        );
                        $webservice_config = array('server' => 'live_new');
                        $WebServiceLots = new WebService($webservice_config);
                        $WebServiceLots->GetAccountTotalTradedVolume($account_info);
                        if ($WebServiceLots->request_status == 'RET_OK') {
                            $totalVolume = $WebServiceLots->get_result('TotalVolume');
                        }
                        if ($affiliateData['mt_account_set_id'] == '4' || $affiliateData['mt_account_set_id'] == '7') { //convert amount
                            $totalVolume = $totalVolume / 100;
                        }

                        $totalLots += $totalVolume;



                    }
                }
            }
        }


        $this->output->set_content_type('application/json')->set_output(json_encode(array('totalLots' => $totalLots)));

    }
     public function requestReferralTotalCommission(){

        $offset = 0;
        $length = 10000; // max referrals
        $dateFrom = 0;
        $accountNumber =  $this->session->userdata('account_number');
        $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

        $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $length, 'Offset' => $offset,'Accounts' => 0);

        $totalCommission = $this->getTotalCommissionFromAllReferrals($requestData,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('totalCommission' => $totalCommission)));

    }


    public function getCommissiontest($account){


        $PartAccountsDetails = $this->general_model->showssingle2($table = 'partnership', $field = 'reference_num', $id = $account, $select = 'type_of_partnership,partner_id,currency');
        $user_id = $PartAccountsDetails['partner_id'];

        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $user_id = $sub_partner['partner_id'];
        }
        $referralsList = $this->partners_model->getPartnerReferralsByPartnerID($user_id);

        foreach ($referralsList as $key => $value) {
            $account_info = array(
                'iLogin' => $value['account_number']
            );
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->GetAccountTotalTradedVolume($account_info);
            $totalVolume = 0;
            if ($WebService->request_status == 'RET_OK') {
                $totalVolume = $WebService->get_result('TotalVolume');

            }
            echo $value['account_number'] .'-'. var_dump($totalVolume); echo '<br>';
        }
    }

	public function referrals_export(){

		$user_id = $this->session->userdata('user_id');

		$tab = $this->input->post('tab');
		$record = '';
		$data_referrals = array();
		$mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];

		$from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
		$to = date("Y-m-d 23:59:59");
		switch($tab){
			case "all":     $from= $from; break;
			case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
			case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
			case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
			case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
			case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
			case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
		}
		$allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

		$sub_partner = $this->partners_model->getCPAReferenceSub($user_id);

		if($sub_partner){

			$allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
			$pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

		}else{

			$allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
			$pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

		}

		$account_num = count($mt)>0?$mt:$pt['reference_num'];
		$all = array_merge($allAffiliateCode0,$allAffiliateCode1);

		$ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));

		$active_accounts = array();

		$record .= "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel'><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-></head><body><table  >";
		$this->lang->load('referrals');
		$record .= '<thead><tr><th class="center-data">' . lang('refer_05') . '</th><th  class="center-data">' . lang('refer_06') . '</th>';
			if(FXPP::showReferralAccountBalance()){
				$record .= "<th  class='center-data'>referral's name</th>";
				$record .= '<th  class="center-data">Balance</th>';
			   if(FXPP::showCommisionAmount()){
				$record .= '<td class="center-data"> Total amount of commission</td>';
					}
				if(FXPP::showReferralAccountContactDetails()){
				$record .= '<th  class="center-data">Email</th>';
				$record .= '<th  class="center-data">Phone number</th>';
			} }
			$record .= '<th  class="center-data">Status</th>';
			$record .= '<th  class="center-data">Verified Status</th>';
		foreach ($all as $key){
			$referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
			if(count($referrals)>0){
				foreach ($referrals as $key) {
					$account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
					$account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
					$apiInfo_active= $this->getUserdetails($account[0]->account_number);
					if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){

						 $active_accounts[] = $account[0]->account_number;
						$this->load->model('deposit_model');
						$getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

						$webservice_config = array('server' => 'live_new');
//						$WebService2 = new WebService($webservice_config);
//						$WebService2->RequestAccountFunds($account[0]->account_number);
//						$TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                        $accountFunds = $this->GetAccountFunds($account[0]->account_number);

						if ($account1[0]->nodepositbonus) {
							$status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
						}else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
							$status = '<span style="color:red;">Unconfirmed</span>';
						}else{
							$status = 'Confirmed';
						}
						$ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';

						$record .= '<tr><td style="text-align: center;">' . date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])). '</td>';
						$record .= '<td style="text-align: center;">' . $account[0]->account_number. '</td>';
					   if(FXPP::showReferralAccountBalance()){
						   $amount = $accountFunds['Balance'];
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['Name'].'</td>';
						   $record .= '<td style="text-align: center;">'.$amount.'</td>';
						   if(FXPP::showCommisionAmount()){
							  $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

							   $record .= '<td style="text-align: center;">'.$comission.'</td>';
						   }

						   if(FXPP::showReferralAccountContactDetails()){
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['Email'].'</td>';
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['PhoneNumber'].'</td>';
						   }

					   }
						$record .= '<td style="text-align: center;">'.$status.'</td>';
						$record .= '<td style="text-align: center;">'.$ver_stat.'</td></tr>';
			   }
				}
			}
		}
		$record .= '</table></body></html>';
		$filename = 'Partner_Cabinet_'.date('Y_m_d').'.xls';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$filename");
		echo $record;

    }

	public function getAllReferralstable(){
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('user_id');
            $tab = $this->input->post('tab');
            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];

            $from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
            $to = date("Y-m-d 23:59:59");
            switch($tab){
                case "all":     $from= $from; break;
                case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
                case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
                case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
                case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
                case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
                case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
            }
            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);


            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

            $account_num = count($mt)>0?$mt:$pt['reference_num'];
            $all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
             $active_accounts = array();
            foreach ($all as $key){
                $referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
                if(count($referrals)>0){
                    foreach ($referrals as $key) {
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
                         //   if($apiInfo_active['Agent']==$account_num){
                                 $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 //   $status = ($getTotalDeposit > $TotalBonusFund)?'Confirmed':'Unconfirmed';
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = 'Confirmed';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';
//                                if(IPLoc::Office()){
//                                    print_r($account1);
//                                }
                                $record .= '<tr><td style="text-align: center;">' . date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])). '</td>';
                                $record .= '<td style="text-align: center;">' . $account[0]->account_number. '</td>';
                               if(FXPP::showReferralAccountBalance()){
                                   $amount = $accountFunds['Balance'];
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Name'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$amount.'</td>';
                                   if(FXPP::showCommisionAmount()){
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $record .= '<td style="text-align: center;">'.$comission.'</td>';
                                   }

                                   if(FXPP::showReferralAccountContactDetails()){
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Email'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['PhoneNumber'].'</td>';
                                   }

                               }
                                $record .= '<td style="text-align: center;">'.$status.'</td>';
                                $record .= '<td style="text-align: center;">'.$ver_stat.'</td></tr>';
                        //    }
                       }
                    }
                }
            }

            $affiliate_codes = array();
            foreach ($all as $key) {
                $affiliate_codes[] = $key->affiliate_code;
            }

            $data = array( 'success' => true , 'error'=>'','record'=>$record,"fromDate"=>$from,"toDate"=>$to );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

	 public function getAllReferralschart(){
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('user_id');
            $tab = $this->input->post('tab');
            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];

            $from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
            $to = date("Y-m-d 23:59:59");
            switch($tab){
                case "all":     $from= $from; break;
                case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
                case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
                case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
                case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
                case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
                case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
            }
            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);


            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

            $account_num = count($mt)>0?$mt:$pt['reference_num'];
            $all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));

			$active_accounts = array();
            foreach ($all as $key){
                $referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
                if(count($referrals)>0){
                    foreach ($referrals as $key) {
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
							$active_accounts[] = $account[0]->account_number;
					    }
                    }
                }
            }

            $affiliate_codes = array();
            foreach ($all as $key) {
                $affiliate_codes[] = $key->affiliate_code;
            }

            /*GRAPH*/
            $from = date("Y-m-d",strtotime($from));
            $to = date("Y-m-d",strtotime($to));
            if(IPLoc::Office()){
                if($active_accounts){
                    $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode2($affiliate_codes,$active_accounts,$from,$to);
                } else {
                    $getAllReferrals_graph = '';
                }

            }else{
                $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode($all[0]->affiliate_code,$from,$to);
            }

            if(count($getAllReferrals_graph)>0){
                $ctr_alref = 0;
                for($i=0;$i<count($getAllReferrals_graph);$i++){
                    $datetime = strtotime( $getAllReferrals_graph[$i]['date_created'] ) * 1000;
                    $ctr_alref = $ctr_alref + ($getAllReferrals_graph[$i]['referralCount']);
                    $click_data[] = array('0'=>$datetime, '1'=>$ctr_alref );
                }
                $data['chart'] = $click_data;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }
            /*GRAPH*/

            $data = array( 'success' => true , 'error'=>'','chart1'=>$data['chart'],"fromDate"=>$from,"toDate"=>$to );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

	public function clicks_loading_time(){
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            $data['isCPA'] = $this->isCPA;
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'clicks';
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];

            $data['affiliate_codes'] = $affiliate_code;
            $data['www'] = $this->config->item('domain-www');

            $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
            $click = $this->partners_model->getClickByCode($affiliate_code[0]['affiliate_code']);

            $data['date_from'] = reset($click)->date;
            $data['date_to'] = end($click)->date;

            $countClicksByAffiliateCode = $this->partners_model->countClicksByAffiliateCode($affiliate_code[0]['affiliate_code'], $data['date_to'].' 23:59:59', $data['date_from'].' 00:00:00');

            $data['countClicks'] = $countClicksByAffiliateCode['count'];

//            if($this->isCPA){
//                if($sub_partner){
//                    $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                    $click = $this->partners_model->getClick($affiliate_code[0]['affiliate_code']);
//                }else{
//                    $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                    $click = $this->partners_model->getClick($user_id);
//                }
//            }else{
//                $data['click'] = $this->partners_model->getClickAndRegisterAcByCode($affiliate_code[0]['affiliate_code']);
//                $click = $this->partners_model->getClick($user_id);
//            }

            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;
            // $chart = "[". strtotime($ac_created)*1000 .",0],";
            if(is_array($click)){
                foreach($click as $d){

                    $datetime = strtotime($d->date) * 1000;
                    $value = $d->num;
                    $click_data[] = "[$datetime, $value]";
                }

                $chart =  join($click_data,",");
                $data['chart'] = $chart;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }

//            $js = $this->template->Js();
            $data['metadata_description'] = lang('cli_dsc');
            $data['metadata_keyword'] = lang('cli_kew');
            $this->template->title(lang('cli_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/clicks_loading_time', $data);
        }else{
            redirect('signout');
        }
    }

	public function getClicksDatassss(){

	    if ($this->input->is_ajax_request()) {
         $user_id = $this->session->userdata('user_id');

		$record = '';
		$data_referrals = array();
		$mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];/////

		$from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
		$to = date("Y-m-d 23:59:59");

		$allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');


		$sub_partner = $this->partners_model->getCPAReferenceSub($user_id);

		if($sub_partner){

			$allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
			$pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

		}else{

			$allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
			$pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

		}
		$account_num = count($mt)>0?$mt:$pt['reference_num'];
		//$all = array_merge($allAffiliateCode0,$allAffiliateCode1);
		$all = $allAffiliateCode1;



		$ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));

		$active_accounts = array();

		$record .= '<thead><tr><th class="center-data">' . lang('refer_05') . '</th><th  class="center-data">' . lang('refer_06') . '</th>';
			if(FXPP::showReferralAccountBalance()){
				$record .= "<th  class='center-data'>referral's name</th>";
				$record .= '<th  class="center-data">Balance</th>';
			   if(FXPP::showCommisionAmount()){
				$record .= '<td class="center-data"> Total amount of commission</td>';
					}
				if(FXPP::showReferralAccountContactDetails()){
				$record .= '<th  class="center-data">Email</th>';
				$record .= '<th  class="center-data">Phone number</th>';
			} }
			$record .= '<th  class="center-data">Status</th>';
			$record .= '<th  class="center-data">Verified Status</th>';
		foreach ($all as $key){
			$referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
			if(count($referrals)>0){
				foreach ($referrals as $key) {
					$account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
					$account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
					$apiInfo_active= $this->getUserdetails($account[0]->account_number);
					if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){

						 //$active_accounts[] = $account[0]->account_number;
						$this->load->model('deposit_model');
						$getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

						$webservice_config = array('server' => 'live_new');
//						$WebService2 = new WebService($webservice_config);
//						$WebService2->RequestAccountFunds($account[0]->account_number);
//						$TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                        $accountFunds = $this->GetAccountFunds($account[0]->account_number);

						if ($account1[0]->nodepositbonus) {
							$status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
						}else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
							$status = '<span style="color:red;">Unconfirmed</span>';
						}else{
							$status = 'Confirmed';
						}
						$ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';

						$record .= '<tr><td style="text-align: center;">' . date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])). '</td>';
						echo date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate']));
						$record .= '<td style="text-align: center;">' . $account[0]->account_number. '</td>';
						echo $account[0]->account_number;
					   if(FXPP::showReferralAccountBalance()){
						   $amount = $accountFunds['Balance'];
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['Name'].'</td>';
						echo $apiInfo_active['Name'];
						   $record .= '<td style="text-align: center;">'.$amount.'</td>';
						echo $amount;
						   if(FXPP::showCommisionAmount()){
							  $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

							   $record .= '<td style="text-align: center;">'.$comission.'</td>';

						echo $comission;
						   }

						   if(FXPP::showReferralAccountContactDetails()){
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['Email'].'</td>';

						echo $apiInfo_active['Email'];
						   $record .= '<td style="text-align: center;">'.$apiInfo_active['PhoneNumber'].'</td>';

						echo $apiInfo_active['PhoneNumber'];
						   }

					   }
						$record .= '<td style="text-align: center;">'.$status.'</td>';
						echo $status;
						$record .= '<td style="text-align: center;">'.$ver_stat.'</td></tr>';
						echo $ver_stat;
			   }
				}
			}
		}

		$data = array( 'success' => true , 'error'=>'','record'=>$record,"fromDate"=>$from,"toDate"=>$to );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
	}

	public function getAllReferralsNew(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            $date_from = $this->input->post('date_from',true).' 00:00:00';
            $date_to = $this->input->post('date_to',true).' 23:59:59';
            $code = $this->input->post('code',true) ;
            $search = $this->input->post('search',true) ;
            $offset = (int)  $this->input->post('start',true);
            $rowPerPage = (int)  $this->input->post('length',true);

            $user_id = $this->session->userdata('user_id');

            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];


            $from = date("Y-m-d 0:0:0",strtotime($date_from));
            $to = date("Y-m-d 23:59:59",strtotime($date_to));
            // switch($tab){
            //     case "all":     $from= $from; break;
            //     case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
            //     case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
            //     case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
            //     case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
            //     case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
            //     case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
            // }

            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);

            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

			$pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

			$account_num = count($mt)>0?$mt:$pt['reference_num'];

			$all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $codeList = array();
            $data = array();


            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
            $active_accounts = array();

            
			
            foreach ($all as $key){

               

                if(!$search['value']) {  // page load
                    $referrals = $this->general_model->getOnePageAllReferralByDate($key->affiliate_code,$from,$to,$offset, $rowPerPage);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                }else{  // for table search
                    $referrals = $this->general_model->getOnePageAllReferralByDateSearch($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                    //$referralssss = $this->general_model->getOnePageAllReferralByDateSearchhhh($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                }

                array_push($codeList,$key->affiliate_code);
                if(count($referrals)>0){

                   
                    foreach ($referrals as $key) {
				
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);

                        

                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        
                        if(strlen($apiInfo_active['LogIn'])>3){
                       
                      //  if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
							
                                $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = '<span style="color:green;">Confirmed</span>';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';

						$RegDate =  date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate']));
                                $recordaccount_number = $account[0]->account_number;


                              

                               if(FXPP::showReferralAccountBalance()){
                                   $amount = $accountFunds['Balance'];
                                   $record_Name = $apiInfo_active['Name'];
                                   $amount = $amount;
                                   if(FXPP::showCommisionAmount()){
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $comission = $comission;
                                   }

                                   if(FXPP::showReferralAccountContactDetails()){
                                   $Email = $apiInfo_active['Email'];
                                   $PhoneNumber = $apiInfo_active['PhoneNumber'];
                                   }

                               }
                      
					if(FXPP::showReferralAccountBalance() && FXPP::showReferralAccountContactDetails() && FXPP::showCommisionAmount()){
						$tempArray = array(
                        'DT_RowId' => $key->id,
							$RegDate,
							$recordaccount_number,
							$record_Name,
							$amount,
							$comission,
							$Email,
							$PhoneNumber,
							//$status,
							$ver_stat
						);
					}else if(FXPP::showReferralAccountBalance() && FXPP::showReferralAccountContactDetails() && FXPP::showReferralAccountLots() ){
                       
                            $tempArray = array(
                                'DT_RowId' => $key->id,
                                    $RegDate,
                                    $recordaccount_number,
                                    $record_Name,
                                    $amount,
                                    $this->getAccounTotalLots($recordaccount_number),
                                    $Email,
                                    $PhoneNumber,                                  
                                    $ver_stat
                                );

                    } elseif(FXPP::showReferralAccountBalance() && FXPP::showReferralAccountContactDetails()){
						$tempArray = array(
                        'DT_RowId' => $key->id,
							$RegDate,
							$recordaccount_number,
							$record_Name,
							$amount,
							$Email,
							$PhoneNumber,
							//$status,
							$ver_stat
						);
					} elseif(FXPP::showReferralAccountBalance() && FXPP::showCommisionAmount()){
						$tempArray = array(
                        'DT_RowId' => $key->id,
							$RegDate,
							$recordaccount_number,
							$record_Name,
							$amount,
							$comission,
							//$status,
							$ver_stat
						);
					}else if(FXPP::showReferralAccountBalance()){
                        $tempArray = array(
                            'DT_RowId' => $key->id,
                                $RegDate,
                                $recordaccount_number,
                                $record_Name,
                                $amount,                               
                                //$status,
                                $ver_stat
                            );

                    } else {
						$tempArray = array(
                        'DT_RowId' => $key->id,
							$RegDate,
							$recordaccount_number,
							//  $record_Name,
							//  $amount,
							//$status,
							$ver_stat
						);
                    }
                    $data[] = $tempArray;
                }
					
                   
                    }
                }
            }

            $countAllReferrals = count($this->general_model->getCountAllReferralsAndRegisterAcByCode2($codeList , $date_from, $date_to));
			
			if(IPLoc::office()){
				
				//$countAllReferrals = count($this->general_model->getOnePageAllReferralByDateSearchSearch($codeList , $date_from, $date_to, $search['value']));
			}
		
			$result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$countAllReferrals,
                'recordsFiltered' => (int)$countAllReferrals,
                'data' => $data
            );

			echo json_encode($result);
        }
    }
	
	
    public function GetLevelThreeRef()
    {
        if ($this->input->is_ajax_request()) {
            $code = $this->input->post('code');


                $affiliates = $this->partners_model->getAffiliates1($code)['rows'];
               
            $referrals = '';
                foreach ($affiliates as $key => $value) {

//                $apiInfo_active = $this->getUserdetails($value->account_number);
//                if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ) {

                            $referrals .= '<tr>
                          <td>' . $value->account_number. '</td>
                          <td>' .$value->full_name. '</td>
                          <td>' . 'Client' . '</td>
                           <td>'.$value->affiliate_code.'</td>
                        </tr>';
                    //  }

                }


            $this->output->set_content_type('application/json')->set_output(json_encode(array('referrals' => $referrals)));
        }
    }



	public function get_referrals(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){
            $date_from = $this->input->post('from',true).' 00:00:00';
            $date_to =  $this->input->post('to',true).' 23:59:59';
            $code = $this->input->post('code',true);
            //$click_chart_data = $this->partners_model->getAllClickByCode($code,$date_from, $date_to);
            $countClicksByAffiliateCode = $this->generel_model->countClicksByAffiliateCode($code, $date_to, $date_from);
            $click_data = array();
           /*  if(is_array($click_chart_data)){
                foreach($click_chart_data as $d){
                    $datetime = strtotime($d->date) * 1000;
                    $value =  (int) $d->num;
                    $click_data[] = array($datetime, $value);
                }
            }else{
                $click_data[] = array(strtotime(date('Y-m-d'))*1000, 0);
            } */

            $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $click_data, 'countClicks' => $countClicksByAffiliateCode['count'])));
        }
    }


    public function testAffiliates(){
//        $affiliatesN = array();
//        $data['info1'] = array();
//        $data['info_sub_ib'] = array();
//        echo '<pre>';
//
//        $account_number = 58028358;
//
//        $partner = $this->partners_model->getAccountDetailsByAcctNumber1($account_number, 'partner')['rows'];
//         if (count($partner)) {
//        $data['info0'] = $this->getUserdetails($account_number);
//        $data['info'] = $partner;
//
//             $affiliates = $this->partners_model->getAffiliates1('IIYPH')['rows'];
//             foreach ($affiliates as $key => $value) {
//                 echo $value->affiliate_code;
//             }
//             exit();
//        foreach ($partner as $key) {
//            $affiliates = $this->partners_model->getAffiliates1($key->affiliate_code)['rows'];
//
//            foreach ($affiliates as $key => $value) {
//
////                $apiInfo_active = $this->getUserdetails($value->account_number);
////                if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ) {
//                $data['info_sub_ib'][$value->affiliate_code] = array(
//                    'registration_date'       => $value->registration_time,
//                    'total_referral'          => 0,
//                    'affiliate_code'          => $value->affiliate_code,
//                    'referral_affiliate_code' => $value->referral_affiliate_code,
//                );
//                //  }
//
//            }
//
//        }
//            foreach ( $data['info_sub_ib'] as $key_sub => $value_sub) {
//                   $affiliates3rd = $this->partners_model->getAffiliates1($value_sub['affiliate_code'])['rows'];
//                foreach ( $affiliates3rd as $key_3 => $value_3) {
//
//
//                    if (array_key_exists($value_3->referral_affiliate_code, $data['info_sub_ib'])) {
//                        $data['info_sub_ib'][$value_3->referral_affiliate_code]['total_referral'] += 1;
//
//                    }
//                }
//
//            }
//
//            array_multisort(array_column($data['info_sub_ib'], 'total_referral'),  SORT_DESC,$data['info_sub_ib']); // sort multiple arrays from largest to smallest amount
//
//
//
//
//            // $data['info1'] = array_merge($data['info1'], $affiliates);
////                    echo '<pre>';print_r( $data['info1']);exit;
////            if (count($affiliates) > 0) {
////                for ($i = 0; $i < count($affiliates); $i ++) {
////                    $affiliates2 = $this->partners_model->getAffiliates1( $affiliates[$i]->affiliate_code)['rows'];
////                    if (count($affiliates2) > 0) {
////                        $data['info1']['']
////                        array_push($affiliatesN, $affiliates2);
////                    }
////                }
////                $data['info2'] = $affiliatesN;
////
//////                    echo '<pre>';print_r( $data['info2']);exit;
////            }
//
//        } else {
//            $data['noinfo'] = false;
//        }
//
//
//        var_dump(     $data['info_sub_ib']);
  echo '<pre>';
        $partner = 1000000130;
        $lotList = array();
        $apiInfo = $this->getUserdetails($partner);
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $from = $apiInfo['RegDate'];
        $to = date('Y-m-d\T23:59:59', strtotime(FXPP::getCurrentDateTime()));
        $account_info = array('iAgent'=>$partner,'from'=>$from,'to'=>$to);
        $WebService->getTotalCommissionGroupByAccount($account_info);
        $result = $WebService->get_result('CommissionTotal');
        $volume = 0;
        $totalVolume = 0;
        foreach ( $result as $key => $val){
            $affiliate = $this->general_model->showssingle('mt_accounts_set', 'account_number', $result[$key]->FromAccount, 'mt_account_set_id,mt_currency_base');
            $account_info = array(
                'iLogin' => $result[$key]->FromAccount
            );

            $WebServiceLots = new WebService($webservice_config);
            $WebServiceLots->GetAccountTotalTradedVolume($account_info);
            if ($WebServiceLots->request_status == 'RET_OK') {
                $volume = $WebServiceLots->get_result('TotalVolume');
            }

            if ($affiliate['mt_account_set_id'] == '4' || $affiliate['mt_account_set_id'] == '7') { //convert amount
                $volume = $volume / 100;
            }

            $totalVolume += $volume;
            $lotList[] =  array(
                'referral' => $result[$key]->FromAccount,
                'lot'=>$volume,
                'type' => $affiliate['mt_account_set_id'],
            );

        }
echo $totalVolume;
var_dump($lotList);
    }


    private function getAccounTotalLots($account_number=null){



        $data['from'] = date('Y-m-d', strtotime('2015-01-01'));

        $data['to'] = date('Y-m-d', strtotime('now'));


    $account_info = array(
        'iLogin' => $account_number,
        'from'        =>  date('Y-m-d\T00:00:00', strtotime($data['from'])),
        'to'        =>  date('Y-m-d\T23:59:59', strtotime($data['to'])),
    );



  return  $data['totalLots'] = $this->getTotalTradePerMonth($account_info)['totalLots'];



}

private function getTotalTradePerMonth($account_info){
    $data['totalLots'] = 0;
    $webservice_config = array('server' => 'live_new');
    $WebService = new WebService($webservice_config);
    $WebService->Open_GetMonthlyLots($account_info);

    switch($WebService->request_status){
        case 'RET_OK':
            $lostArray = $WebService->get_result('Lots');
            foreach ($lostArray->KeyValuePairOfdateTimedouble as $key => $val){
                $data['totalLots'] += $val->value;
            }
            break;

    }
    return $data;
}




public function testLots(){

        echo '<pre>';
    $lotList = array();
        $webservice_config = array('server' => 'live_new');
        $user_id = 299246;
        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'partner_id,reference_num, type_of_partnership');
        } else {
            $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'partner_id,reference_num, type_of_partnership');
        }

        $volume = 0;
        $totalVolume = 0;
        $account_number = $pt['reference_num'];

        $referralClient = $this->partners_model->getAccountDetailsByAcctNumber1($account_number, 'partner')['rows']; //CLIENT REFERRAL


        if (count($referralClient) > 0) {
            foreach ($referralClient as $key) {
                $affiliates = $this->partners_model->getAffiliates1($key->affiliate_code)['rows'];
                echo $key->affiliate_code;
                foreach ($affiliates as $key => $value) {
                    $affiliateData = $this->general_model->showssingle('mt_accounts_set', 'account_number', $value->account_number, 'mt_account_set_id,mt_currency_base');

                    $account_info = array(
                        'iLogin' => $value->account_number
                    );
                    $WebServiceLots = new WebService($webservice_config);
                    $WebServiceLots->GetAccountTotalTradedVolume($account_info);
                    if ($WebServiceLots->request_status == 'RET_OK') {
                        $volume = $WebServiceLots->get_result('TotalVolume');
                    }
//                    if ($affiliateData['mt_account_set_id'] == '4' || $affiliateData['mt_account_set_id'] == '7') { //convert amount
//                        $volume = $volume / 100;
//                    }

                    $totalVolume += $volume;
                    $lotList[] =  array(
                        'referral' => $value->account_number,
                        'lot'=>$volume,
                        'type' => $affiliateData['mt_account_set_id'],
                    );


                }
            }
        }

        echo $totalVolume;
        var_dump($lotList);

    }






    private function ref_table_permission(){
        $permission = '0|1|8';
        if( $permission_row = $this->general_model->show('partner_ref_permission','account_number',$this->session->userdata('account_number'),'permission')->row()){
          $permission = $permission_row->permission;
        }
        
        return $permission; 
    }
    private function sub_affiliate_permission(){
        $permission = '3|4|5|6';
        if( $permission_row = $this->general_model->show('partner_sub_affilliate','account_number',$this->session->userdata('account_number'),'permission')->row()){
          $permission = $permission_row->permission . '|5|6';
        }
        
        return $permission; 
    }

    public function referrals(){

        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            
            $data['column'] = $this->getReferralsColumnIndex();

            
            $data['ref_table'] =   FXPP::referrals_table_permission(FXPP::referrals_table(),$this->ref_table_permission());
            $data['header_count'] = count( $data['ref_table'] );
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);

        

            $data['isCPA'] = $this->isCPA;
        
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
           


            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');

            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referrals_v2', $data);
        }else{
            redirect('signout');
        }
    }
    
    public function getReferralsColumnIndex(){
        //rearrange the index number to get the right column
        $header =  FXPP::referrals_table_permission(FXPP::referrals_table(),$this->ref_table_permission());
        $columnHeader= array();
        $index = 1;
        foreach($header as $h){
            $columnHeader[$index] = $h;
            $index += 1;
        }
        
        $data = array();
        $data['commission_column'] = array_search(lang('trd_257'), $columnHeader);
        $data['balance_column'] = array_search(lang('trd_81'), $columnHeader);
        $data['lots_column'] = array_search(lang('trd_258'), $columnHeader);
        $data['saldo_column'] = array_search('Net Deposit', $columnHeader);
        return $data;
    }

     public function referralst(){

        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }
          
            $data['ref_table'] =   FXPP::referrals_table_permission(FXPP::referrals_table(),$this->ref_table_permission());
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);

            $data['isCPA'] = $this->isCPA;
        
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
           


            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');
			
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referralsTest1', $data);
        }else{
            redirect('signout');
        }
    }

    public function getAllReferrals_v22(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
            $date_from = $this->input->post('date_from',true).' 00:00:00';
            $date_to = $this->input->post('date_to',true).' 23:59:59';
            $code = $this->input->post('code',true) ;
            $search = $this->input->post('search',true) ;
            $offset = (int)  $this->input->post('start',true);
            $rowPerPage = (int)  $this->input->post('length',true);

            $user_id = $this->session->userdata('user_id');

            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];


            $from = date("Y-m-d 0:0:0",strtotime($date_from));
            $to = date("Y-m-d 23:59:59",strtotime($date_to));
        
            $postData = array(
				'user_id' => $user_id,
				'date_from' => $date_from,
				'date_to' => $date_to,
				'offset' => $offset,
				'limit' => $rowPerPage,
				'search' => $search['value']
			);
			
			$account_num = count($mt)>0?$mt:$pt['reference_num'];
			
			$referrals = $this->general_model->getDataAllReferrals($postData);

            $data = array();

//echo '<pre>1'; print_r($referrals);
            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
            $active_accounts = array();

                     

                if(count($referrals)>0){

                   
                    foreach ($referrals as $key) {
				
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);

                        

                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                       // echo '<pre>2'; print_r($apiInfo_active);
                       // if(strlen($apiInfo_active['LogIn'])>3){
                       
                      //  if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
							
                                $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = '<span style="color:green;">Confirmed</span>';
                                }
                               $recordaccount_number = $account[0]->account_number;
                               $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';
                               $RegDate  = '<span data-level ="1" ref="'.$recordaccount_number.'" class="btn-expand"><i  class="fa fa-plus"></i></span> ' . date("Y-m-d",strtotime($apiInfo_active['RegDate']));

								//$RegDate =  date("Y-m-d",strtotime($apiInfo_active['RegDate']));

                              

                              
                                   $amount = $accountFunds['Balance'];
                                   $record_Name = $apiInfo_active['Name'];
                                   $amount = $amount;
                                 
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $comission = $comission;
                                 

                                  
                                   $Email = $apiInfo_active['Email'];
                                   $PhoneNumber = $apiInfo_active['PhoneNumber'];
                                

                              
                    $account_type = array( //FXPP-11796
                        1 => "St",
                        2 => "Zr",
                        4 => "Cn", //Micro
                        5 => "Cl",
                        6 => "Pr",
                        7 => "Cn",
                    );

                    $full_table = array(
                        
                            0 => $RegDate, //"Date of registration",
                            1=>$recordaccount_number ." (". $account_type[$key->mt_account_set_id] . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>', //"Account number of referral",
                            2=>$record_Name, //"Referral's name",
                            3=>$amount, //"Balance",
                            4=>$comission, // "Total amount of commission",
                            5=> $this->getAccounTotalLots($recordaccount_number), //"Number of Lots",
                            6=> $Email, //"Email",
                            7=> $PhoneNumber, // "Phone number",
                            8=>$ver_stat // "Verified Status",
                    );
                   

                   $tempArray = array_values( FXPP::referrals_table_permission($full_table,$this->ref_table_permission())); 
                   $tempArray['DT_RowId'] = $key->id; 
                                      
					
                    $data[] = $tempArray;
                //}
                }
            }

//            if(IPLoc::Office()){
//                echo '<pre>'; print_r($data);exit;
//            }
			
			$countAllReferrals = $this->general_model->getCountDataAllReferrals($postData);
			
			$result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$countAllReferrals['count'],
                'recordsFiltered' => (int)$countAllReferrals['count'],
                'data' => $data
            );

			echo json_encode($result);
		}
    }

	public function getAllReferrals_v2(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            $date_from = $this->input->post('date_from',true).' 00:00:00';
            $date_to = $this->input->post('date_to',true).' 23:59:59';
            $code = $this->input->post('code',true) ;
            $search = $this->input->post('search',true) ;
            $offset = (int)  $this->input->post('start',true);
            $rowPerPage = (int)  $this->input->post('length',true);

            $user_id = $this->session->userdata('user_id');

            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];


            $from = date("Y-m-d 0:0:0",strtotime($date_from));
            $to = date("Y-m-d 23:59:59",strtotime($date_to));
          

            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);

            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

			$pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

			$account_num = count($mt)>0?$mt:$pt['reference_num'];

			$all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $codeList = array();
            $data = array();


            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
            $active_accounts = array();

            
			
            foreach ($all as $key){

               

                if(!$search['value']) {  // page load
                    $referrals = $this->general_model->getOnePageAllReferralByDate($key->affiliate_code,$from,$to,$offset, $rowPerPage);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                }else{  // for table search
                    $referrals = $this->general_model->getOnePageAllReferralByDateSearch($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                    //$referralssss = $this->general_model->getOnePageAllReferralByDateSearchhhh($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                }

                array_push($codeList,$key->affiliate_code);
                if(count($referrals)>0){

                   
                    foreach ($referrals as $key) {
				
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);

                        

                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        
                        if(strlen($apiInfo_active['LogIn'])>3){
                       
                      //  if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
							
                                $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = '<span style="color:green;">Confirmed</span>';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';

						$RegDate =  date("Y-m-d",strtotime($apiInfo_active['RegDate']));
                                $recordaccount_number = $account[0]->account_number;


                              

                              
                                   $amount = $accountFunds['Balance'];
                                   $record_Name = $apiInfo_active['Name'];
                                   $amount = $amount;
                                 
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $comission = $comission;
                                 

                                  
                                   $Email = $apiInfo_active['Email'];
                                   $PhoneNumber = $apiInfo_active['PhoneNumber'];
                                

                              
                    $account_type = array( //FXPP-11796
                        1 => "St",
                        2 => "Zr",
                        4 => "Cn", //Micro
                        5 => "Cl",
                        6 => "Pr",
                        7 => "Cn",
                    );

                    $full_table = array(
                        
                            0 => $RegDate, //"Date of registration",
                            1=>$recordaccount_number ." (". $account_type[$key->mt_account_set_id] . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>', //"Account number of referral",
                            2=>$record_Name, //"Referral's name",
                            3=>$amount, //"Balance",
                            4=>$comission, // "Total amount of commission",
                            5=> $this->getAccounTotalLots($recordaccount_number), //"Number of Lots",
                            6=> $Email, //"Email",
                            7=> $PhoneNumber, // "Phone number",
                            8=>$ver_stat // "Verified Status",
                    );
                   

                   $tempArray = array_values( FXPP::referrals_table_permission($full_table,$this->ref_table_permission())); 
                   $tempArray['DT_RowId'] = $key->id; 
                                      
					
                    $data[] = $tempArray;
                }
					
                   
                    }
                }
            }

            $countAllReferrals = count($this->general_model->getCountAllReferralsAndRegisterAcByCode2($codeList , $date_from, $date_to));
			
			if(IPLoc::office()){
				
				//$countAllReferrals = count($this->general_model->getOnePageAllReferralByDateSearchSearch($codeList , $date_from, $date_to, $search['value']));
			}
		
			$result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$countAllReferrals,
                'recordsFiltered' => (int)$countAllReferrals,
                'data' => $data
            );

			echo json_encode($result);
        }
    }

	
	public function referral_activities(){

        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            $sessionId = $this->session->userdata('session_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);

            }
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            if(IPLoc::APIUpgradeDevIP()){
                $this->load->library('WSV');
                $unixDateFrom = 0;
                $unixDateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));

                $serviceData = array('From' => $unixDateFrom,'To'=>$unixDateTo,'Limit'=>1,'Offset'=>0,'isCPA'=>$this->isCPA);
                $WSV = new WSV();
                $requestResult = $WSV->GetReferralsActivity($serviceData);
                $dataCount = $requestResult['Data']->DataCount; //total count
                
                if($dataCount > 0 ){
                    $traderTotalPages = ceil($dataCount/10);
                    $data['activitiesTotalPages'] = $traderTotalPages;
                }else{
                    $data['activitiesTotalPages'] = 1;
                }

            }else{
                $data['ref_table'] =  $this->partners_model->getReferralActivtiesDetails($user_id);

                $data['isCPA'] = $this->isCPA;
                $isReqforCode=$this->partners_model->isReqaffcode($user_id);
                $data['isReqforCode'] = $isReqforCode;

                $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
                $data['isApprovedRecCode'] = $isApprovedRecCode;
            }

        
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referral_activities';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
           


            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');

            if(IPLoc::APIUpgradeDevIP()){
                $view = 'partnership/referral_activities_v2';
            }else{
                $view = 'partnership/referral_activities';
            }
			
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                       <script src='".$this->template->Js()."simple-bootstrap-paginator.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build($view, $data);
        }else{
            redirect('signout');
        }
    }
    
    
    public function requestReferralActivities(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
            $dateFrom = FXPP::unixTime($this->input->post('date_from', true) . ' 00:00:00');
            $dateTo = FXPP::unixTime($this->input->post('date_to', true) . ' 23:59:59');
            $accountNumber = $this->session->userdata('account_number');
            $page = $this->input->post('page', true);
            if (!$page) {
                $page = 1;
            }


            $length = 10;
            $start = ($page - 1) * $length;

            $serviceData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $length, 'Offset' => $start,'isCPA'=>$this->isCPA);
            $this->load->library('WSV'); //New web service
            $WSV = new WSV();
            $requestResult = $WSV->GetReferralsActivity($serviceData);
            $requestStatus = $requestResult['ErrorMessage']; //status

            if ($requestStatus == 'RET_OK') {
                $activitiesList = $requestResult['Data']->Transactions->FinanceOpData;

                $accounts = array_map(function ($e) { //return array / object column
                    return is_object($e) ? $e->Login : $e['Login'];
                }, $activitiesList);

                $accounts[] = $accountNumber; // add logged in account


                $accountDetails = $this->getMTAccountDetails($accounts);

                $activities = array();

                foreach ($activitiesList as $obj) {

                    $searchKey = array_search($obj->Login, array_column($accountDetails['accountList'], 'LogIn'));
                    $country = $accountDetails['accountList'][$searchKey]['Country'];
                    $currency = $accountDetails['accountList'][$searchKey]['Currency'];
                    $unixProcess = new DateTime("@$obj->ProcessTime");
                    $processTime = $unixProcess->format('d-m-Y H:i:s');


                    if ((strpos(strtolower($obj->Comment), 'bonus') !== false)) {
                        $comment = 'Bonus' . ' ' . number_format($obj->Amount, 2) . " " . $currency;
                    } else {

                        if ($obj->Amount > 0) {
                            $comment = 'Deposited' . ' ' . number_format($obj->Amount, 2) . " " . $currency;
                        } else {
                            $comment = 'Withdrawn' . ' ' . number_format($obj->Amount, 2) . " " . $currency;
                        }
                    }


                    $activities[] = array(
                        'country'       => $country,
                        'currency'      => $currency,
                        'processTime'   => $processTime,
                        'comment'       => $comment,
                        'amount'        => $obj->Amount,
                        'accountNumber' => $obj->Login,

                    );

                }


            }

            $view_data = array(
                'activities' => $activities,
            );


            $activitiesListView = $this->load->view('partnership/referral_activities_list', $view_data, true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('htmlView' => $activitiesListView)));


        }
    }

    public function getMTAccountDetails($accountNumber = array()){
        $this->load->library('WSV');
        $serviceData = array('account_number' => $accountNumber);
        $detailsSvc = new WSV();
        $requestResult = $detailsSvc->GetAccountDetails($serviceData);

        $accountListEncode = json_encode($requestResult['Data']);
        $accountList = json_decode($accountListEncode,true);

        $result = array(
            'accountList' => $accountList,
        );

        return $result;


    }



    public function trading_history(){

        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            $from = DateTime::createFromFormat('Y-m-d', '2015-05-05');
            $to = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-d-m H:i:s'));
            $data = array(
                'iLogin' => $account_number, // int partner account Number
                'from' => $from->format('Y-m-d\TH:i:s'), // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                'to' => $to->format('Y-m-d\TH:i:s'), // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                
            );   

            $this->form_validation->set_rules('from', 'From date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('to', 'To date', 'trim|required|xss_clean');
            
            if ($this->form_validation->run()) {	

                $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->input->post('from',true).' 00:00:00');
                $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->input->post('to',true).' 23:59:59');
                $data = array(
                    'iLogin' => $account_number, // int partner account Number
                    'from' => $from->format('Y-m-d\TH:i:s'), // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                    'to' => $to->format('Y-m-d\TH:i:s'), // DateTime::createFromFormat  format('Y-m-d\TH:i:s')
                    
                ); 
            }


            
            

            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_GetReferralsTradeHistory($data);
            if($WebService->request_status == 'RET_OK'){
                $data['trading_history'] = $WebService->get_result('TradeDataList')->TradeData;
            }else{
                $data['trading_history'] = array();
            }

            $isReqforCode=$this->partners_model->isReqaffcode($user_id);
            $data['isReqforCode'] = $isReqforCode;

            $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
            $data['isApprovedRecCode'] = $isApprovedRecCode;
            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
          
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['isCPA'] = $this->isCPA;
        
            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'trading-history';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
           


            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');

            $data['from'] =  $from->format('Y-m-d');
            $data['to'] =  $to->format('Y-m-d');
			
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referral_trading_history', $data);
        }else{
            redirect('signout');
        }
    }


public function referralsTest(){

        if($this->session->userdata('logged')) {

            //load new referrals data and save to referrals table
//            $this->referralPreProcess();

//            $this->lang->load('referrals');
            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }

            $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // $ac_created = $this->general_model->show('users','id',$user_id,'date(created) created')->row()->created;

            //$referrals = $this->partners_model->getReferralsbyAffiliateCode($affiliate_code[0]['affiliate_code']);
            //  $data['referralList'] = $this->createReferralList($referrals);

            $postData = array(
                'user_id' => $user_id
            );

            if($this->isCPA) {
                if ($sub_partner) {
                    $postData['user_id'] = $sub_partner['partner_id'];
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                } else {
                    $click = $this->partners_model->getRegisteredAccRefDef($postData);
                }
            }else{
                $click = $this->partners_model->getRegisteredAccRefDef($postData);
            }

            //$chart = "[". strtotime($ac_created)*1000 .",0],";
//            if(IPLoc::Office()){
                $from = date("Y-m-d",strtotime("2015-05-05"));
                $to = date("Y-m-d");
                $getAllReferrals = $this->partners_model->getReferralCountofAffiliateCode($affiliate_code[0]['affiliate_code'],$from,$to);

                if(count($getAllReferrals)>0){
                    $ctr_alref = 0;
                    for($i=0;$i<count($getAllReferrals);$i++){
                        $datetime = strtotime( $getAllReferrals[$i]['date_created'] ) * 1000;
                        $ctr_alref = $ctr_alref + ($getAllReferrals[$i]['referralCount']);
                        $click_data[] = "[$datetime, $ctr_alref]";
                    }
                    $chart1 =  join($click_data,",");
                    $data['chart'] = $chart1;
                    $data['status'] = 1;
                }else{
                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                    $data['status'] = 0;
                }
//            }else{
//                if(is_array($click['result'])){
//                    foreach($click['result'] as $d){
//                        $datetime = strtotime($d->date) * 1000;
//                        if(strlen($datetime)>5){
//                            $value = $d->acnum;
//                            $click_data[] = "[$datetime, $value]";
//                        }
//                    }
//
//                    $chart1 =  join($click_data,",");
//
//                    $data['chart'] = $chart1;
//                    $data['status'] = 1;
//                }else{
//                    $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
//                    $data['status'] = 0;
//                }
//            }
            $data['test'] = $affiliate_code['affiliate_code'];

            $data['date_from'] = $click['first_row']['date'];
            $data['date_to'] = $click['last_row']['date'];

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if ($this->isCPA) {
                if ($sub_partner) {
                    $user_id = $sub_partner['partner_id'];
                }
            }

            $postData = array(
                'user_id' => $user_id,
                'date_from' =>  date('Y-m-d', strtotime($click['first_row']['date'])),
                'date_to' => date('Y-m-d', strtotime($click['last_row']['date']))
            );
            $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
            $data['referralsTotal'] = $countAllReferrals['count'];
//            if(IPLoc::Office()){
                $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, '*')['account_number'];
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, '*')['reference_num'];
                $account = $mt?$mt:$pt;
                $data['agentStats'] =  $this->GetAgentStats($account);
                $data['referralsTotal'] =  $data['agentStats']["user_referrals"];
//            }


            $data['isCPA'] = $this->isCPA;
            //  $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);

            $data['title_page'] = lang('sb_li_4');
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'referrals';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];



            $data['metadata_description'] = lang('refer_dsc');
            $data['metadata_keyword'] = lang('refer_kew');
            $this->template->title(lang('refer_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                      <script type='text/javascript'>
                        window.alert = function() {};
                      </script>
                         <script src='".$this->template->Js()."Moment.js'></script>
                         <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")

                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/referralsTest1', $data);
        }else{
            redirect('signout');
        }
    }
	
	 public function getAllReferralsTest(){
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('user_id');
//            if($user_id == 132478){
//                $user_id = 239015;
//            }

            $tab = $this->input->post('tab');
            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];

            $from = date("Y-m-d 0:0:0",strtotime("2015-05-05"));
            $to = date("Y-m-d 23:59:59");
            switch($tab){
                case "all":     $from= $from; break;
                case "day":     $from= date("Y-m-d 0:0:0",strtotime("yesterday") );  break;
                case "week":    $from= date("Y-m-d 0:0:0",strtotime("-7 days")); break;
                case "month":   $from= date("Y-m-d 0:0:0",strtotime("-1 Months")); break;
                case "three":   $from= date("Y-m-d 0:0:0",strtotime("-3 Months")); break;
                case "year":    $from= date("Y-m-d 0:0:0",strtotime("-12 Months")); break;
                case "custom":    $from= date("Y-m-d 0:0:0",strtotime($this->input->post('from'))); $to = date("Y-m-d 23:59:59",strtotime($this->input->post('to'))); break;
            }
            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);


            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

            $account_num = count($mt)>0?$mt:$pt['reference_num'];
            $all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
             $active_accounts = array();
            foreach ($all as $key){
                $referrals = $this->general_model->getAllReferralByDate($key->affiliate_code,$from,$to);
                
				if(count($referrals)>0){
                    foreach ($referrals as $key) {
					
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);
                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
                         //   if($apiInfo_active['Agent']==$account_num){
                                 $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 //   $status = ($getTotalDeposit > $TotalBonusFund)?'Confirmed':'Unconfirmed';
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = 'Confirmed';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';
//                                if(IPLoc::Office()){
//                                    print_r($account1);
//                                }
                                $record .= '<tr><td style="text-align: center;">' . date("Y-m-d H:i:s",strtotime($apiInfo_active['RegDate'])). '</td>';
                                $record .= '<td style="text-align: center;">' . $account[0]->account_number. '</td>';
                               if(FXPP::showReferralAccountBalance()){
                                   $amount = $accountFunds['Balance'];
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Name'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$amount.'</td>';
                                   if(FXPP::showCommisionAmount()){
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $record .= '<td style="text-align: center;">'.$comission.'</td>';
                                   }






                                   if(FXPP::showReferralAccountBalance()){
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['Email'].'</td>';
                                   $record .= '<td style="text-align: center;">'.$apiInfo_active['PhoneNumber'].'</td>';
                                   }

                               }
                                $record .= '<td style="text-align: center;">'.$status.'</td>';
                                $record .= '<td style="text-align: center;">'.$ver_stat.'</td></tr>';
                        //    }
                       }
                    }
                }
            }

            $affiliate_codes = array();
            foreach ($all as $key) {
                $affiliate_codes[] = $key->affiliate_code;
            }

            /*GRAPH*/
            $from = date("Y-m-d",strtotime($from));
            $to = date("Y-m-d",strtotime($to));
            if(IPLoc::Office()){
                $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode2($affiliate_codes,$active_accounts,$from,$to);
            }else{
                $getAllReferrals_graph = $this->partners_model->getReferralCountofAffiliateCode($all[0]->affiliate_code,$from,$to);
            }

            if(count($getAllReferrals_graph)>0){
                $ctr_alref = 0;
                for($i=0;$i<count($getAllReferrals_graph);$i++){
                    $datetime = strtotime( $getAllReferrals_graph[$i]['date_created'] ) * 1000;
                    $ctr_alref = $ctr_alref + ($getAllReferrals_graph[$i]['referralCount']);
                    $click_data[] = array('0'=>$datetime, '1'=>$ctr_alref );
                }
                $data['chart'] = $click_data;
                $data['status'] = 1;
            }else{
                $data['chart'] = "[". strtotime(date('Y-m-d'))*1000 .",0],";
                $data['status'] = 0;
            }
            /*GRAPH*/

            $data = array( 'success' => true , 'error'=>'','record'=>$record,'chart1'=>$data['chart'],"fromDate"=>$from,"toDate"=>$to );
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
   
	public function getAllReferrals_v2222(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            $date_from = $this->input->post('date_from',true).' 00:00:00';
            $date_to = $this->input->post('date_to',true).' 23:59:59';
            $code = $this->input->post('code',true) ;
            $search = $this->input->post('search',true) ;
            $offset = (int)  $this->input->post('start',true);
            $rowPerPage = (int)  $this->input->post('length',true);

            $user_id = $this->session->userdata('user_id');

            $record = '';
            $data_referrals = array();
            $mt = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number')['account_number'];


            $from = date("Y-m-d 0:0:0",strtotime($date_from));
            $to = date("Y-m-d 23:59:59",strtotime($date_to));
          

            $allAffiliateCode0 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'users_affiliate_code','users_id');

            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);

            if($sub_partner){

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($sub_partner['partner_id'],'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $sub_partner['partner_id'], 'reference_num, type_of_partnership');

            }else{

                $allAffiliateCode1 = $this->general_model->GetAffiliateCodesOfAccount($user_id,'partnership_affiliate_code','partner_id');
                $pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

            }

			$pt = $this->general_model->showssingle('partnership', 'partner_id', $user_id, 'reference_num, type_of_partnership');

			$account_num = count($mt)>0?$mt:$pt['reference_num'];

			$all = array_merge($allAffiliateCode0,$allAffiliateCode1);

            $codeList = array();
            $data = array();


            $ref_comission = $this->getRefCommision($account_num,$this->input->post('from'),$this->input->post('to'));
            $active_accounts = array();

            
			
            foreach ($all as $key){

               

                if(!$search['value']) {  // page load
                    $referrals = $this->general_model->getOnePageAllReferralByDate($key->affiliate_code,$from,$to,$offset, $rowPerPage);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                }else{  // for table search
                    $referrals = $this->general_model->getOnePageAllReferralByDateSearch($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                   // if(IPLoc::office()){ echo $this->db->last_query();}
                    //$referralssss = $this->general_model->getOnePageAllReferralByDateSearchhhh($key->affiliate_code, $from, $to, $offset, $rowPerPage, $search['value']);
                }

                array_push($codeList,$key->affiliate_code);
                if(count($referrals)>0){

                   
                    foreach ($referrals as $key) {
				
                        $account = $this->general_model->getshow1('mt_accounts_set', 'user_id', $key->users_id);
                        $account1 = $this->general_model->getshow1('users', 'id', $key->users_id);

                        

                        $apiInfo_active= $this->getUserdetails($account[0]->account_number);
                        
                        if(strlen($apiInfo_active['LogIn'])>3){
                       
                      //  if(($apiInfo_active['LogIn']!='') || ($apiInfo_active['LogIn']!=0) ){
							
                                $active_accounts[] = $account[0]->account_number;
                                $this->load->model('deposit_model');
                                $getTotalDeposit = $this->deposit_model->getTotalDeposit($key->users_id, 2);

                                $webservice_config = array('server' => 'live_new');
//                                $WebService2 = new WebService($webservice_config);
//                                $WebService2->RequestAccountFunds($account[0]->account_number);
//                                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

                                $accountFunds = $this->GetAccountFunds($account[0]->account_number);

                                if ($account1[0]->nodepositbonus) {
                                 
                                    $status = ($getTotalDeposit > 0)?'Confirmed':'<span style="color:red;">Unconfirmed</span>';
                                }else if (($apiInfo_active['ReqResult'] === 'RET_OK') && ($apiInfo_active['Agent']== 0)) {
                                    $status = '<span style="color:red;">Unconfirmed</span>'; //failed setting of agent
                                }else{
                                    $status = '<span style="color:green;">Confirmed</span>';
                                }
                                $ver_stat = $account1[0]->accountstatus==1?'<span style="color:green;">Verified</span>':'<span style="color:red;">Read only</span>';

						$RegDate =  date("Y-m-d",strtotime($apiInfo_active['RegDate']));
                                $recordaccount_number = $account[0]->account_number;


                              

                              
                                   $amount = $accountFunds['Balance'];
                                   $record_Name = $apiInfo_active['Name'];
                                   $amount = $amount;
                                 
                                      $comission =  isset($ref_comission[$account[0]->account_number])? $ref_comission[$account[0]->account_number]:'0';

                                       $comission = $comission;
                                 

                                  
                                   $Email = $apiInfo_active['Email'];
                                   $PhoneNumber = $apiInfo_active['PhoneNumber'];
                                

                              
                    $account_type = array( //FXPP-11796
                        1 => "St",
                        2 => "Zr",
                        4 => "Cn", //Micro
                        5 => "Cl",
                        6 => "Pr",
                        7 => "Cn",
                    );

                    $full_table = array(
                        
                            0 => $RegDate, //"Date of registration",
                            1=>$recordaccount_number ." (". $account_type[$key->mt_account_set_id] . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>', //"Account number of referral",
                            2=>$record_Name, //"Referral's name",
                            3=>$amount, //"Balance",
                            4=>$comission, // "Total amount of commission",
                            5=> $this->getAccounTotalLots($recordaccount_number), //"Number of Lots",
                            6=> $Email, //"Email",
                            7=> $PhoneNumber, // "Phone number",
                            8=>$ver_stat // "Verified Status",
                    );
                   

                   $tempArray = array_values( FXPP::referrals_table_permission($full_table,$this->ref_table_permission())); 
                   $tempArray['DT_RowId'] = $key->id; 
                                      
					
                    $data[] = $tempArray;
                }
					
                   
                    }
                }
            }

            $countAllReferrals = count($this->general_model->getCountAllReferralsAndRegisterAcByCode2($codeList , $date_from, $date_to));
			
			if(IPLoc::office()){
				
				//$countAllReferrals = count($this->general_model->getOnePageAllReferralByDateSearchSearch($codeList , $date_from, $date_to, $search['value']));
			}
		
			$result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$countAllReferrals,
                'recordsFiltered' => (int)$countAllReferrals,
                'data' => $data
            );

			echo json_encode($result);
        }
    }




    public function getAllReferrals_v3(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

        $dateFrom = FXPP::unixTime($this->input->post('date_from', true) . ' 00:00:00');
        $dateTo = FXPP::unixTime($this->input->post('date_to', true) . ' 23:59:59');
        $userID = $this->session->userdata('user_id');
        $accountNumber = $this->session->userdata('account_number');

        $search = $this->input->post('search', true);
        $offset = (int) $this->input->post('start', true);
        $rowPerPage = (int) $this->input->post('length', true);
        $draw = (int) $this->input->post('draw', true);

        $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $rowPerPage, 'Offset' => $offset,'isCPA' => $this->isCPA);
        $referralData = FXPP::getReferralsOfAccount($requestData);
        $dataCount = $referralData['referralCount']; //total count
        $referralList = $referralData['referralList'];
        $referralListDecode = json_decode(json_encode($referralData['referralList']), true);
        $referralGroup = array_column($referralListDecode, 'Group','LogIn');

        $data = array();
        if ($dataCount > 0) {

            $accounts = array_map(function ($e) { //return array / object column
                return is_object($e) ? $e->LogIn : $e['LogIn'];
            }, $referralList);


            $accountStatus = $this->getAccountStatus($accounts)['accounts']; // get account status
            $saldoList = $this->getAccountTotalSaldo($accounts)['accounts'];



            $dateFrom = 0;
            $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));
            $requestData2 = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => count($accounts), 'Offset' => 0,'Accounts' => $accounts);

            $accountCommissions = $this->getTotalCommissionFromAllReferrals($requestData2)['commissionList']; // get referrals commissions
            $requestData2['isCPA'] = $this->isCPA;

            $accountLots = $this->getReferralTotalLots($requestData2,false,$referralGroup)['referralLots']; // get referrals lots


            $sumLots = 0;
            $sumCommission = 0;
            $sumBalance = 0;
            $sumSaldo = 0;
            foreach ($referralList as $key => $obj) {


                $accountNumber = $obj->LogIn;
                $accountGroup = $obj->Group;
                $balance = FXPP::roundno(floatval($obj->Balance), 2);
                $ver_stat = $accountStatus[$accountNumber]['status'] == 1 ? '<span style="color:green;">Verified</span>' : '<span style="color:red;">Read only</span>';
                $saldo = $saldoList[$accountNumber]['saldo'] ? $saldoList[$accountNumber]['saldo'] : 0;

                $unixRegDate = new DateTime("@$obj->RegDate");

                $fullName = $obj->Name;
                $comission = isset($accountCommissions[$accountNumber]['Amount']) ? $accountCommissions[$accountNumber]['Amount'] : '0';
                $totalLots = isset($accountLots[$accountNumber]['Lots']) ? $accountLots[$accountNumber]['Lots'] : '0';
                $Email = $obj->Email;
                $PhoneNumber = $obj->PhoneNumber;

                $regDate  = $unixRegDate->format('d-m-Y');

                $accountNumberTd =   '<span data-level ="1" ref="'.$accountNumber.'" class="btn-expand"><i  class="fa fa-plus"></i></span> ' .  $accountNumber . " (" . $this->getGroupCodeType($accountGroup) . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>'; //"Account number of referral",


               // re-arrange table FXPP-12613
                $full_table = array(
                    1 => $accountNumberTd,
                    2 => $fullName, //"Referral's name",
                    0 => $regDate, //"Date of registration",
                    6 => $Email, //"Email",
                    7 => $PhoneNumber, // "Phone number",
                    3 => $balance, //"Balance",
                    4 => $comission, // "Total amount of commission",
                    5 => $totalLots, //"Number of Lots",
                    11 => $saldo, //"Number of Lots",
                    8 => $ver_stat // "Verified Status",
                );

                /* $full_table = array(

                     0 => $regDate, //"Date of registration",
                     1 => $accountNumber . " (" . $this->getGroupCodeType($accountGroup) . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>', //"Account number of referral",
                     2 => $fullName, //"Referral's name",
                     3 => $balance, //"Balance",
                     4 => $comission, // "Total amount of commission",
                     5 => $totalLots, //"Number of Lots",
                     6 => $Email, //"Email",
                     7 => $PhoneNumber, // "Phone number",
                     8 => $ver_stat // "Verified Status",
                 );*/
                $sumLots += $totalLots;
                $sumCommission += $comission;
                $sumBalance += $balance;
                $sumSaldo += $saldo;


                $tempArray = array_values(FXPP::referrals_table_permission($full_table, $this->ref_table_permission()));


                $data[] = $tempArray;
            }
        }


        $result = array(
            'draw'            => $draw,
            'recordsTotal'    => $dataCount,
            'recordsFiltered' => $dataCount,
            'data'            => $data,
            'saldo'           => $sumSaldo,
            'commission'      => $sumCommission,
            'lots'            => $sumLots,
            'balance'         => $sumBalance,
        );

        echo json_encode($result);
    }

    }

    public function getReferralsByLevel(){


        $sumLots = 0;
        $sumCommission = 0;
        $sumBalance = 0;
        $sumSaldo = 0;
        $accountNumber = $this->input->post('account', true);
        $level = (int) $this->input->post('level', true);

        $referralList = FXPP::getAccountReferralsFromAllLevels($accountNumber,1);

        $data = array();
        $attr = $level + 1;

        $account_type = array( //FXPP-11796
            1 => "St",
            2 => "Zr",
            4 => "Cn", //Micro
            5 => "Cl",
            6 => "Pr",
            7 => "Cn",
        );


        $accountCommission = $this->getRefCommision($accountNumber,'','');

        if(count($referralList) > 0){
            $accounts = array_map(function ($e) { //return array of object column
                return is_object($e) ? $e->account_number : $e['account_number'];
            }, $referralList);
            $saldoList = $this->getAccountTotalSaldo($accounts)['accounts'];




        foreach ($referralList as $key => $obj) {

            $saldo = $saldoList[$obj['account_number']]['saldo'] ? $saldoList[$obj['account_number']]['saldo'] : 0;


            //temporary method
            $webserviceConfig = array('server' => 'live_new');
            $accountFunds = new WebService($webserviceConfig);
            $accountFunds->RequestAccountFunds($obj['account_number']);
            $balance = $accountFunds->get_result('Balance');
            //end

            $totalCommission =  isset($accountCommission[$obj['account_number']])? $accountCommission[$obj['account_number']]:'0';

            $totalLots = $this->getAccounTotalLots($obj['account_number']);
            $accountNumberTd = $obj['account_number'] ." (". $account_type[$obj['account_type']] . ') <i data-html="true" rel="tooltip" class="fa fa-question-circle holder-img " data-toggle="tooltip" data-placement="right" title="" data-original-title="<p><b>Acc type legend:</b><br> Cl - Classic<br> Pr - Pro<br> Cn - Cents<br> Zr - Zero Spread<br> St - Standard</p>" aria-describedby="tooltip96414"></i>';


            $verStatus = $obj['accountstatus'] == 1 ? '<span style="color:green;">Verified</span>' : '<span style="color:red;">Read only</span>';
           // $regDate  = '<span>&nbsp;</span> ' . $obj['registration_date'];
            $regDate  = $obj['registration_date'];
            $btn  = $accountNumberTd;

                $permitColumn = explode('|', $this->ref_table_permission());
                switch ($level) {
                    case 1:
                        if (in_array(9, $permitColumn)) {
                            $btn  = '<span data-level ="' . $attr . '" ref="' . $obj['account_number'] . '" class="btn-expand"><i  class="fa fa-plus"></i></span> ' . $accountNumberTd;

                        }
                        break;
                    case 2:
                        if (in_array(10, $permitColumn)) {
                            $btn  = '<span data-level ="' . $attr . '" ref="' . $obj['account_number'] . '" class="btn-expand"><i  class="fa fa-plus"></i></span> ' . $accountNumberTd;

                        }
                        break;
                    case 3:
                        $btn  = '<span>&nbsp;</span> ' . $accountNumberTd;
                        break;
                    default:
                        $btn  = '<span data-level ="' . $attr . '" ref="' . $obj['account_number'] . '" class="btn-expand"><i  class="fa fa-plus"></i></span> ' . $accountNumberTd;

                        break;

                }







            $full_table = array(
                1 => $btn,//"Referral's account number",
                2 => $obj['name'], //"Referral's name",
                0 => $regDate, //"Date of registration",
                6 => $obj['email'], //"Email",
                7 => $obj['phone_no'], // "Phone number",
                3 => $balance, //"Balance",
                4 => $totalCommission, // "Total amount of commission",
                5 => $totalLots, //"Number of Lots",
                11 => $saldo, //"Total Saldo",
                8 => $verStatus // "Verified Status",

            );

            $sumLots += $totalLots;
            $sumCommission += $totalCommission;
            $sumBalance += $balance;
            $sumSaldo += $saldo;

            $data[] = FXPP::referrals_table_permission($full_table, $this->ref_table_permission());

          }
        }
        $count_head = count(FXPP::referrals_table_permission(FXPP::referrals_table(),$this->ref_table_permission()));

        $tableView = '';

        if(count($data) > 0) {

            foreach ($data as $row): array_map('htmlentities', $row);
                $tableView .= '<tr>
                                <td>' . implode('</td><td>', $row) . '</td>
                            </tr>';
            endforeach;
        }else{
            $tableView .= '<tr>
                             <td colspan = "'.$count_head.'" style="text-align:center"> No data to display.</td>
                          </tr>';

        }
        $result = array(
            'count' => count($data),
            'table_view' => $tableView,
            'balance' => $sumBalance,
            'saldo' => $sumSaldo,
            'lots' => $sumLots,
            'commission' => $sumCommission,
            
        );


        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    
    public function GetTotalCommissionFromAllReferrals($requestData = array(),$isTotal = false){
        $this->load->library('WSV');

        $WSV = new WSV();
        $requestResult =  $WSV->GetTotalCommissionFromAllReferrals($requestData);
        $requestStatus = $requestResult['ErrorMessage']; 
        $referralCommissionData =  $requestResult['Data']->Commissions->Commission;


        $referralCommission = array();
        $totalCommission = 0;

        foreach($referralCommissionData as $k => $v){
            $referralCommission[$v->From] = array(
                'Amount' => round($v->Amount,2),
            );
            $totalCommission +=  $v->Amount;

        }

        if($isTotal){
           return  round($totalCommission,2);
        }


        $result = array(
            'commissionList' => $referralCommission
        );


   

        return $result;


    }

   public function getGroupCodeType($group)
   {
            $group  = strtolower($group);

            if((strpos($group, 'usc') !== false) || (strpos($group, 'euc') !== false) && ((strpos($group, 'st') !== false) || (strpos($group, 'fc') !== false))) {
                return 'Cn';
            }else if ((strpos($group, 'st') !== false)) {
                return 'St';
            }else if ((strpos($group, 'ze') !== false)) {
                return 'Zr';

            }else if ((strpos($group, 'fc') !== false)) {
                return 'Cl';
            }else if ((strpos($group, 'fp') !== false)) {
                return 'Pr';
            }else if ((strpos($group, 'pa') !== false)) {
                return 'Pa';
            }


   }


   public function getAccountStatus($accountNumbers = array()){
       $accountData =  $this->account_model->getListAccountStatus($accountNumbers);
       $accounts = array();

       foreach($accountData as $k => $v){
           $accounts[$v['account_number']] = array(
               'status' => $v['accountstatus'],
           );
       }
       $result = array(
           'accounts' => $accounts
       );

       return $result;
  }

    public function getClickRegistration(){
        $dateFrom = FXPP::unixTime($this->input->post('from',true).' 00:00:00');
        $dateTo =  FXPP::unixTime($this->input->post('to',true).' 23:59:59');

        $start = 0;
        $length = 10000; // max referrals
        $referralDataChart = array();
        $clickData = array();


        $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $length, 'Offset' => $start,'isCPA' => $this->isCPA);
        $referralData = FXPP::getReferralsOfAccount($requestData);
        $dataCount = $referralData['referralCount']; //total count
        $referralList = $referralData['referralList'];


        foreach ($referralList as $key => $obj) { // get count  of referrals per date
            $unixRegDate = new DateTime("@$obj->RegDate");
            $regDate =  $unixRegDate->format('d-m-Y');

            if (!array_key_exists($regDate, $referralDataChart)) {

                $referralDataChart[$regDate] = array(
                    'registration_date' => $regDate,
                    'count'             => 1,
                );
            } else {

                $referralDataChart[$regDate]['count'] += 1;
            }
        }//end
        


        foreach($referralDataChart as $d){
            $datetime = strtotime($d['registration_date']) * 1000;
            $value =  (int) $d['count'];
            $clickData[] = array($datetime, $value);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('chart' => $clickData)));



    }

    public function getReferralTotalLots($requestData = array(),$isTotal = false,$groupData = array()){
        $this->load->library('WSV');
        $WSV = new WSV();
        $requestResult =  $WSV->GetAccountsTotalTradedLot($requestData);
        $requestStatus = $requestResult['ErrorMessage'];
        $referralLotsData =  $requestResult['Data']->ResultDouble->KeyValuePairOfintdouble;
        $referralLots = array();
        $totalLots = 0;
        $lots = 0;
        foreach($referralLotsData as $k => $v){

          $group =  $this->getGroupCodeType($groupData[$v->key]);
            $lots =  round($v->value,2);
            if(strtolower($group) == 'cn' ){ //cents
                $lots /= 100;
            }
            $referralLots[$v->key] = array(
                'Lots' => $lots,
            );
            $totalLots += $lots;
        }

        if($isTotal){

            return round($totalLots,2);
        }

        $result = array(
            'referralLots' => $referralLots
        );

        return $result;


    }

    public function getReferralsCount($requestData = array(),$isTotal = false){
        $this->load->library('WSV');
        $referralsCount = array();
        $WSV = new WSV();
        $requestResult =  $WSV->GetReferralsCount($requestData);
        $totalReferred = 0;
        $referralsData =  $requestResult['Data']->ResultInt->KeyValuePairOfintint;
        foreach($referralsData as $k => $v){
            $referralsCount[$v->key] = array(
                'count' => $v->value,
            );

            $totalReferred += $v->value; 
        }
        if($isTotal){
            return $totalReferred;
        }
       
        return $referralsCount;
        
    }
    


    public function  TestPartnership(){
             echo '<pre>';

       ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service

        $dateFrom = 0;
        $dateTo = strtotime(date('Y-m-d 23:59:59', strtotime('now')));
        $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => 5000, 'Offset' => 0,'isCPA' => $this->isCPA);
     $referralData = FXPP::getReferralsOfAccount($requestData);
        $referralList = $referralData['referralList'];
        $accounts = array_map(function ($e) { //return array / object column
            return is_object($e) ? $e->LogIn : $e['LogIn'];
        }, $referralList);

        $requestData2 = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => count($accounts), 'Offset' => 0,'Accounts' => $accounts);

        $accountLots = $this->getReferralTotalLots($requestData2,true); // get referrals lots

        var_dump($accountLots);

        //  $res = FXPP::getAccountReferralsFromAllLevels(381425);

      //  FXPP::isReferralsOfAccount();
        // $res  = FXPP::DepositBonus(135835, 212690, 10, 'ITS', 'twpb', 1601533023);




        //$saldoList = $this->getAccountTotalSaldo($accounts)['accounts'];
       // var_dump($saldoList);exit();
        
        //$res = FXPP::DepositRealFund(212690,2,'TEST_DEPOSIT');
        //$res = FXPP::WithdrawRealFund(209874,150,'TEST_WITHDRAW');

       // var_dump($res);
        //var_dump($res['requestResult']);
       // var_dump($res['ticket']);
       // $serviceData = array('AccountNumber' => '58054099 ', 'Password' => 'vv56VyF','Accounts'=> array(58054099));// refresh soap service

       // $SVC = new SVC();
       // $requestResult = $SVC->GetAccountDetails($serviceData);
       // print_r($requestResult);

//
//        $res = $this->GetAccountFunds($_SESSION['account_number']);
//        var_dump($res);  exit();


//
//        $webservice_config = array('server' => 'live_new');
//        $account_info = array('iLogin' =>58040036); //inactive
//        $WebServiceAD = new WebService($webservice_config);
//        $WebServiceAD->open_RequestAccountDetails($account_info);
//        if($WebServiceAD->request_status == 'RET_ACCOUNT_NOT_FOUND'){
//          echo  $returnData['errorMsg'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department if you want to restore the account.';
//        }


//        if(IPLoc::IPOnlyForVenus()){
//            $webservice_config = array('server' => 'live_new');
//            $account_info = array('iLogin' => 58040036);
//            $WebServiceAD = $this->wsv->GetAccountDetailsSingle($account_info, $webservice_config);;
//            if ($WebServiceAD->result['IsDeleted'] == '1') {
//              echo  $returnData['errorMsg'] = 'Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department if you want to restore the account.';
//               // return $returnData;
//            }
//
//        }
//        exit();
//        echo $WebServiceAD->request_status;
//        echo '<bre>';
//        echo $WebServiceAD->result['IsDeleted'];
//        echo '<bre>';
//        var_dump($WebServiceAD); exit();
//
//
//
//          $dateFrom = 0;
//            $dateTo = strtotime(date('Y-m-d H:i:s', strtotime('now')));
//
//            $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => 1000, 'Offset' => 0,'isCPA' => $this->isCPA);
//            $referralData = FXPP::getReferralsOfAccount($requestData);
//             print_r($referralData);


//       $serviceData = array('From' => 0,'To'=>1593057599,'Limit'=> 20,'Offset'=>0);

//       $WSV = new WSV();
//       $requestResult = $WSV->GetReferralsAccount($serviceData);
//
//       $requestStatus = $requestResult['ErrorMessage']; //total count
//       $referralList =  $requestResult['Data']->Accounts->AccountData;
//
//          $accounts = array_map(function($e) { //return array /object column
//           return is_object($e) ? $e->LogIn : $e['LogIn'];
//           }, $referralList);
//
//
//       $serviceData['Accounts'] = $accounts;
//       $serviceData['Limit'] = count($accounts);
//
//      //$res =  $this->GetTotalCommissionFromReferrals($serviceData);
//
//           $res =  $this->getAccountStatus($accounts);

//       print_r($res);
      //  $accountGroup = 'D-StSwUS1';

      //  var_dump($this->getGroupCodeType($accountGroup));


    }

    public function newCommission(){
        $this->output->cache(5);
        ini_set('max_execution_time', 0);
        if( FXPP::isMicro($this->session->userdata('user_id'))){ redirect('partnership/affiliate-umbrella');}


        if($this->session->userdata('logged')){
            if( $_SERVER['REMOTE_ADDR']=='49.12.5.139') {


                $this->load->model('partners_model');
                $this->load->model('account_model');
                $this->load->model('General_model');
                $this->g_m=$this->General_model;
                $this->load->model('partners_model');

                $user_id = $this->session->userdata('user_id');
                if($this->isCPA){  redirect(FXPP::my_url('partnership/cpa'));     }


                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                $affiliate_code = ($sub_partner) ? $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']) : $this->partners_model->getAffiliateCodeById($user_id);


                $isReqforCode=$this->partners_model->isReqaffcode($user_id);
                $data['isReqforCode'] = $isReqforCode;

                $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
                $data['isApprovedRecCode'] = $isApprovedRecCode;
                $data['data']['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                $data['isCPA'] = $this->isCPA;
                $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];


                $ac = $this->account_model->getAccountNumberByUserId( $user_id );

                $dataobj['from'] = DateTime::createFromFormat('Y/d/m', date('Y/d/m', strtotime("- 1 day")));
                $dataobj['from']->setTime(00, 00, 01);
                $to = DateTime::createFromFormat('Y/d/m H:i:s', date('Y/d/m') . ' 23:59:59');
                $data['data']['accountnumber']=$ac['account_number'];
                $data['opt'] = $this->input->get('opt',true); // for Cumulative option select;
                $accountnumbers = $ac['account_number'];

                if( ($this->session->userdata('user_id')==102342)   && (IPLoc::Office())  ){
                    $account_info2 = array(
                        'iLogin' =>241800,
                        'from' =>$dataobj['from']->format('Y-m-d\TH:i:s') ,
                        'to' =>  $to->format('Y-m-d\TH:i:s')
                    );
                }else{
                    if (IPLoc::Office()){
                        $webservice_config = array('server' => 'live_new');
                        $account_info = array('iLogin' => $accountnumbers);
                        $WSAD = new WebService($webservice_config);
                        $WSAD->open_RequestAccountDetails($account_info);
                        if ($WSAD->request_status === 'RET_OK') {
                            $account_info2 = array(
                                'iLogin' =>$accountnumbers,
                                'from' =>$dataobj['from']->format('Y-m-d\TH:i:s'),
                                'to' =>  $to->format('Y-m-d\TH:i:s')
                            );
                        }
                    }else{
                        $account_info2 = array(
                            'iLogin' =>$accountnumbers,
                            'from' =>$dataobj['from']->format('Y-m-d\TH:i:s') ,
                            'to' =>  $to->format('Y-m-d\TH:i:s')
                        );
                    }

                }


                if(false){
                    $getCommissionData = self::getCommissionDataChart($account_info2, $data['opt']);
                    $data['getCommissionData'] = $getCommissionData;
                }

                //FXPP-2479
                $data['user_id'] = $this->session->userdata('user_id');
                $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');
                $data['partner_agreement']=0;
                if($data['users']){
                    if($data['users']['partner_agreement']==1){   $data['partner_agreement']=1;  }
                }


                $data['title_page'] = lang('sb_li_4');
                $data['active_tab'] = 'partnership';
                $data['active_sub_tab'] = 'commission';
                $data['active_tab'] = 'partnership';
                $data['active_sub_tab'] = 'commission';
                $data['metadata_description'] = lang('com_dsc');
                $data['metadata_keyword'] = lang('com_kew');
                $this->template->title(lang('com_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                dtDay ='".date('Y-m-d',strtotime('yesterday'))."',
                                dtWeek ='".date('Y-m-d',strtotime('-1 week'))."',
                                dtMonth ='".date('Y-m-d',strtotime('-1 month'))."',
                                base_url ='".base_url()."';
                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('partnership/new_commission',$data);
            }else{
                $this->commission();
            }
        }else{
            if($_GET['login'] == 'partner'){
                if($_SESSION['url']){
                    unset($_SESSION['url']);
                }
                $_SESSION['url'] = 'partnership/commission';
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }

    public function GetAccountFunds($accountNumber){

        if(IPLoc::APIUpgradeDevIP()){

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();

            $WebService2 = $WSV->GetAccountFunds($accountNumber);

            if($WebService2->request_status === "RET_OK"){
                return $WebService2->result;
            }

        }else{

            $webserviceConfig = array(
                'server' => 'live_new'
            );
            $WebService2= new WebService($webserviceConfig);
            $WebService2->RequestAccountFunds($accountNumber);

            return $WebService2->result;

        }

    }

    public function getAccountTotalSaldo($accountNumbers = array()){
        $accounts = array();
        $from = date('Y-m-d 00:00:00', strtotime('2015-05-05'));
        $to = date('Y-m-d 23:59:59', strtotime('now'));;
        $this->load->model('deposit_model');
        $saldoData = $this->deposit_model->getAccountSaldo($accountNumbers,$from, $to);

        foreach($saldoData as $k => $v){
            $accounts[$v['account_number']] = array(
                'saldo' => round($v['saldo_amount'],2),
            );
        }
        $result = array(
            'accounts' => $accounts
        );

        return $result;
    }

public function checkPendingTranSection($ticketNumber,$comments)
    {
        
        $transaction_referral_id=$ticketNumber;
        
        if($comments)
        {
            if(strpos($comments, "_"))
            {       
                 $array_data = explode('_', $comments);
                $last_comment_data= $array_data[sizeof($array_data)-1];
                
                if(is_numeric($last_comment_data))
                {
                    $transaction_referral_id=$last_comment_data;
                }    
            }       
        }
        
        
        
        $is_pending_transectin=false;
        
            $this->load->model('Withdraw_model');
           $resultTransaction = $this->Withdraw_model->getWithdrawalTransactionByTicketV2($ticketNumber);

           

           if($resultTransaction)
           {
               if($resultTransaction->status==0){
               $is_pending_transectin=true;
               }
           }else{
               
                $resultTansitTransaction = $this->Withdraw_model->getWithdrawalTransitTransactionByTicket($ticketNumber,$transaction_referral_id);

                 if($resultTansitTransaction)   
                 {
                     
                    if($resultTansitTransaction->status==0){
                    $is_pending_transectin=true;
                    } 
                 }        
                        
           }
           
           

     return $is_pending_transectin;
           
           
                        
//[Withdraw_table ]
//0 - request, 1- processed, 2 - declined           
           
 //[transit_transfer_Table]          
 // 'Pending'   =>  0,   'Returned'  =>  1, 'Success'   =>  2,'Failed'    =>  3,'Canceled'  =>  4, 'Declined'  =>  5, 'Verifying' =>  6,
           
        
    }            
    

    public function getFundStatusPerOperationType($OperationTypeId){
        $operationType = array(
            'BONUS_30PERCENT'       => array( 'desc'=> 'PERCENT BONUS',         'status' => 3 , 'fundType' => 2),
            'BONUS_NO_DEPOSIT'      => array( 'desc'=> 'NO DEPOSIT BONUS',      'status' => 3 , 'fundType' => 2),
            'DEPOSIT_REAL_FUND'     => array( 'desc'=> 'DEPOSIT REAL FUND',     'status' => 1 , 'fundType' => 1),
            'WITHDRAW_REAL_FUND'    => array( 'desc'=> 'WITHDRAW REAL FUND',    'status' => 1 , 'fundType' => 1),
            'TRANSFER_REAL_FUND'    => array( 'desc'=> 'FUND TRANSFER',         'status' => 1 , 'fundType' => 1),
            'BONUS_CONTEST_PRIZE'   => array( 'desc'=> 'CONTEST PRIZE BONUS',   'status' => 4 , 'fundType' => 2),
            'BONUS_SUPPORTER_PART'  => array( 'desc'=> 'SUPPORTER PART BONUS',  'status' => 4 , 'fundType' => 2),
            'BONUS_SHOWFX'          => array( 'desc'=> 'SHOWFX BONUS',          'status' => 4 , 'fundType' => 2),
            'BONUS_50PERCENT'       => array( 'desc'=> '50 PERCENT BONUS',      'status' => 3 , 'fundType' => 2),
            'PAMM_INVESTMENT'       => array( 'desc'=> 'PAMM INVESTMENT FUND',  'status' => 4 , 'fundType' => 1),
            'BONUS_CONTEST_MF_PRIZE'=> array( 'desc'=> 'FOREXMART_CONTEST_MF',  'status' => 4 , 'fundType' => 2),
            'BONUS_SUPPORTER_FULL'  => array( 'desc'=> 'SUPPORTER FULL',        'status' => 1 , 'fundType' => 1),
            'BONUS_100_PERCENT'     => array( 'desc'=> '100 PERCENT BONUS',     'status' => 4 , 'fundType' => 2),
            'COMMISSION_ADJUSTMENT' => array( 'desc'=> 'COMMISSION ADJUSTMENTS','status' => 1 , 'fundType' => 1),
            'BONUS_100_PERCENT_CONSTANT' => array( 'desc'=> '100 PERCENT CONSTANT BONUS', 'status' => 4 , 'fundType' => 2),
            'INVITE_FRIEND_BONUS'   => array( 'desc'=> 'INVITE A FRIEND BONUS', 'status' => 1 , 'fundType' => 1),
            'FORUM_BONUS'           => array( 'desc'=> 'FORUM BONUS',           'status' => 3 , 'fundType' => 2),
            'SUB_IB_COMMISSION'     => array( 'desc'=> 'SUB IB COMMISSION',     'status' => 1 , 'fundType' => 1),
            'BONUS_PROFIT'          => array( 'desc'=> 'BONUS PROFIT',          'status' => 3 , 'fundType' => 1),
            'ERROR_ORDER_CANCEL'    => array( 'desc'=> 'ERROR ORDER CANCELLATION', 'status' => 4 , 'fundType' => 2),
            'BONUS_70PERCENT'       => array( 'desc'=> '70 PERCENT BONUS',      'status' => 3 , 'fundType' => 2),
            'FEE_COMPENSATION'      => array( 'desc'=> 'FEE COMPENSATION',      'status' => 1 , 'fundType' => 1),
            'AFFILIATE_FEE'         => array( 'desc'=> 'AFFILIATE FEE',         'status' => 1 , 'fundType' => 1),
            'REFUND'                => array( 'desc'=> 'REFUND',                'status' => 1 , 'fundType' => 1),
            'DELETED_TICKET'        => array( 'desc'=> 'DELETED TICKET',        'status' => 1 , 'fundType' => 1),
            'BONUS_FOREXCOPY'       => array( 'desc'=> 'BONUS FOREXCOPY',       'status' => 4 , 'fundType' => 2),
            'BONUS_20PERCENT'       => array( 'desc'=> 'BONUS_20PERCENT',       'status' => 3 , 'fundType' => 2),
        );
        $status = array(
            '1' => 'WITHDRAWABLE_FULL',
            '2' => 'WITHDRAWABLE_HALF',
            '3' => 'WITHDRAWABLE_PARTIAL',
            '4' => 'NON_WITHDRAWABLE',
            '5' => 'NO_PERMISSION',
        );
        switch($OperationTypeId){
            case 'DEPOSIT_REAL_FUND': $tType = "Deposit"; break;
            case 'WITHDRAW_REAL_FUND': $tType = "Withdraw"; break;
            case 'TRANSFER_REAL_FUND': $tType = "Transfer"; break;
            default: $tType = "Bonus"; break;
        }

        return array(
            'Description' =>  isset($operationType[$OperationTypeId]['desc']) ? $operationType[$OperationTypeId]['desc'] : 'N/A',
            'FundType' => $operationType[$OperationTypeId]['fundType']==1? 'REAL': 'BONUS',
            'Status' => isset($status[$operationType[$OperationTypeId]['status']]) ? $status[$operationType[$OperationTypeId]['status']] : "N/A",
            'TransType' => $tType,
        );
    }

    public function getTradeType($id){
        switch ($id){
            case 0: $type = 'BUY'; break;
            case 1: $type = 'SELL'; break;
            case 2: $type = 'BUY LIMIT'; break;
            case 3: $type = 'SELL LIMIT'; break;
            case 4: $type = 'BUY STOP'; break;
            case 5: $type = 'SELL STOP'; break;
            case 6: $type = 'BALANCE'; break;
            case 7: $type = 'CREDIT'; break;
            default : $type = 'BUY'; break;
        }
        RETURN $type;
    }

    public function getTraderPassword($accountNumber){
        $client = $this->General_model->showssingle('mt_accounts_set',$field="account_number",$id=$accountNumber,'*');
        $partner = $client ? $client['trader_password'] : $this->General_model->showssingle('partnership',$field="reference_num",$id=$accountNumber,'*')['trader_password'];

        return $pass = $partner ? $partner : 0;
    }
    public function getCommisionFromAllReferrals(){
        if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
            $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
                if($this->session->userdata('logged')){
                    $this->load->model('partners_model');
                    $user_id = $this->session->userdata('user_id');

                    if($this->isCPA){  redirect(FXPP::my_url('partnership/cpa'));     }


                    $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                    $affiliate_code = ($sub_partner) ? $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']) : $this->partners_model->getAffiliateCodeById($user_id);


                    $isReqforCode=$this->partners_model->isReqaffcode($user_id);
                    $data['isReqforCode'] = $isReqforCode;

                    $isApprovedRecCode=$this->partners_model->isApprovedReqCode($user_id);
                    $data['isApprovedRecCode'] = $isApprovedRecCode;
                    $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                    $data['isCPA'] = $this->isCPA;
                    $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];



                    $data['active_tab'] = 'partnership';
                    $data['active_sub_tab'] = 'commission';
                    $data['metadata_description'] = lang('com_dsc');
                    $data['metadata_keyword'] = lang('com_kew');
                    $this->template->title(lang('com_tit'))
                        ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                        ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                            var recordType='".$data['active_sub_tab']."',
                                dtDay ='".date('Y-m-d',strtotime('now'))."',
                                dtWeek ='".date('Y-m-d',strtotime('-1 week'))."',
                                dtMonth ='".date('Y-m-d',strtotime('-1 month'))."',
                                base_url ='".base_url()."';
                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                        ->set_layout('internal/main')
                        ->build('partnership/new_commission',$data);
                }else{
                    redirect('signout');
                }
        }
    }
    public function getBalOpsDetails($a){
        $ticketArray = $this->getFinanceTxn();
        $withdrawalCommentsKey = array(
            'comment_w1' => 'withdrawal',
            'comment_w2' => 'w/d'
        );
        $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
        $details = "<p>Ticket:".$a->Ticket."<br><br>Comment:".$a->Comment."<br></p>";
        if($d['FundType']=="BONUS"){
            $d['TransType'] = "Bonus";
        }else{
            if($d['FundType']=='REAL' && $a->OperationTypeId=='BONUS_SUPPORTER_FULL' ){
                if($a->Amount < 0){
                    $d['TransType'] = "Withdraw";
                    $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket]; // $this->Withdraw_model->getWithdrawalTransactionByTicket($object->Ticket);
                    if($getWithdrawalTransactionByTicket){
                        if($getWithdrawalTransactionByTicket['status'] > 0){
                            switch($getWithdrawalTransactionByTicket['status']){
                                case 1:     $stat = 'Processed';  break;
                                case 2:     $stat =( ($getWithdrawalTransactionByTicket['decline_reference_number'] > 0) && ( $getWithdrawalTransactionByTicket['recall'] ) ) ? 'Recalled' : 'Requested';  break;
                                default:    $stat = 'N/A'; break;
                            }
                            if(!empty($a->Comment)){
                                $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                                if($getWithdrawalTransactionByTicket['recall']==1){
                                    $comment = 'Recalled last '.$date_recalled;
                                }else{
                                    $comment = $a->Comment;
                                }
                                if(IPLoc::Office()){ $comment = $comment.' com1='.$a->Comment; }
                            }else{
                                $comment = 'N/A';
                            }
                            $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"])) ?  $this->getTp[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : "N/A";
                        }
                    }else{
                        $pSystem = "N/A";
                        $stat = "N/A";
                    }
                }else{
                    $d['TransType'] = "Bonus";
                }

            }


            if(in_array($a->OperationTypeId, array("REAL_FUND_DEPOSIT", "FEE_COMPENSATION", "AFFILIATE_FEE" , "REFUND", "SUB_IB_COMMISSION"))){


                if (strpos(strtolower($a->Comment), $withdrawalCommentsKey['comment_w1'] ) !== false OR strpos(strtolower($a->Comment), $withdrawalCommentsKey['comment_w2'] ) !== false) {
                    $d['TransType'] = "Withdraw";
                    $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket];
                    if(!empty($a->Comment)){
                        $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                        if($getWithdrawalTransactionByTicket['recall']==1){
                            $comment = 'Recalled last '.$date_recalled;
                        }else{
                            $comment = 'Withdrawal request declined last '.$getWithdrawalTransactionByTicket['date_withdraw'];
                        }
                    }else{
                        $comment = 'N/A';
                    }
                    $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"]))? $this->transaction_type[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : 'N/A';
                    $recall = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                    $stat = "Declined";
                }else{
                    $d['TransType'] = "Deposit";
                    $depositTransaction = isset($ticketArray[$a->Ticket])?$ticketArray[$a->Ticket]:false;
                    $pSystem = ($depositTransaction) ?  strtoupper($depositTransaction["transaction_type"]):'N/A';


                    if(substr($a->Comment,0,8) === 'DPST_TR_') {
                        $transID = substr($a->Comment, 15, 10);
                        $pSystem = 'A/T';
                    }
                }

            }


            if ($a->OperationTypeId=='WITHDRAW_REAL_FUND'){
                $getWithdrawalTransactionByTicket = $ticketArray[$a->Ticket];
                if($getWithdrawalTransactionByTicket){
                    if($getWithdrawalTransactionByTicket['status'] > 0){
                        switch($getWithdrawalTransactionByTicket['status']){
                            case 1:  $stat = 'Processed';  break;
                            case 2:  $stat =  'Declined'; break;
//                                        default:  $withdrawalStatus = 'N/A'; brea
                        }
                        if(!empty($a->Comment)){
                            $date_recalled = $getWithdrawalTransactionByTicket['date_recalled']?$getWithdrawalTransactionByTicket['date_recalled']:$getWithdrawalTransactionByTicket['date_withdraw'];
                            if($getWithdrawalTransactionByTicket['recall']==1){
                                $comment = 'Recalled last '.$date_recalled;
                            }else{
                                switch($getWithdrawalTransactionByTicket['status']){
                                    case 1: $comment = 'Proccessed last '.$getWithdrawalTransactionByTicket['date_processed']; break;
                                    case 2: $comment = 'Withdrawal request declined last '.$date_recalled; break;
                                }
                                $comment = $comment;
                            }
                        }else{
                            $comment = 'N/A';
                        }
                        $pSystem = (!empty($getWithdrawalTransactionByTicket["transaction_type"])) ?  $this->getTp[strtoupper($getWithdrawalTransactionByTicket["transaction_type"])] : "N/A";
                        $recall = $getWithdrawalTransactionByTicket['recall']==1?'YES':'NO';
                    }
                }else{
                    if((substr($a->Comment,0,7) == 'W/D_TR_')){                 $transID = substr($a->Comment, 14, 10);     }
                    if((substr($a->Comment,0,12) == 'DECLINED_TR_')) {          $transID = substr($a->Comment, 19, 10);     }
                    $resultTransaction = $ticketArray[$transID]; //$this->Withdraw_model->getRequestDeclineFundTransaction($transID);
                    $comm = $a->Comment;
                    if($resultTransaction && strlen($transID)>1){
                        $pSystem = 'ITS';
                        $stat = 'Declined';
                        $comment = $resultTransaction['decline_reason'];
                    }else{
                        $pSystem = 'N/A';
                        $stat = 'N/A';
                        $comment = $comm;
                    }
                }
            }



        }//END IF REAL FUND
        switch($d['TransType']){
            case 'Deposit':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $details = "<p>
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$a->Comment."<br><br>
                                    Payment System:".$pSystem."<br>
                                    </p>";
                break;
            case 'Withdraw':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $recall = isset($recall)? $recall : "";
                $stat = isset($stat)? $stat : "N/A";
                $comment = (!empty($a->Comment))? $comment : "N/A";
                $details = "<p>
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$comment."<br><br>
                                    Payment System:".$pSystem."<br><br>
                                    Status:".$stat."<br><br>
                                    Recall:".$recall."<br>
                                    </p>";
                break;
            case 'Transfer':
                $details = "<p>
                                    Ticket:".$a->Ticket."<br><br>
                                    Comment:".$a->Comment."<br><br>
                                    Transfer From:".$a->TransferAccountSender."<br><br>
                                    Transfer To:".$a->TransferAccountReceiver."<br>
                                    </p>";
                break;
            default:
                $details = $details;
                break;
        }
        return $details;
    }
    private function getFinanceTxn(){
        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $txn = array();
        if($txnResultArray = $this->general_model->whereConditionArray('withdraw',array('user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['reference_number']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('transit_transfer',array('status'=>2,'receiver'=>$account_number))){
            foreach($txnResultArray as $d){
                $txn[$d['transaction_id']] = $d;
            }
        }

        if($txnResultArray = $this->general_model->whereConditionArray('deposit',array('status'=>2,'user_id'=>$user_id))){
            foreach($txnResultArray as $d){
                $txn[$d['mt_ticket']] = $d;
            }
        }

        return $txn;
    }
    public function getTp($tp){
        $transaction_type = array(
            'BOC' => 'BANK OF CYPRUS',
            'BT' => 'BANK TRANSFER',
            'NT' => 'NETELLER',
            'SK' => 'SKRILL',
            'CC' => 'CREDIT CARD',
            'UP' => 'UNIONPAY',
            'WM' => 'WEBMONEY',
            'PX' => 'PAXUM',
            'UK' => 'UKASH',
            'PC' => 'PAYCO',
            'FP' => 'FILSPAY',
            'CU' => 'CASHU',
            'PP' => 'PAYPAL',
            'QW' => 'QIWI',
            'MT' => 'MEGATRANSFER',
            'MTC' => 'MEGATRANSFER CARD',
            'BC' => 'BITCOIN',
            'CP'=> 'CARDPAY',
            'MN'=> 'MONETA',
            'SF'=> 'SOFORT',
            'CUP'=> 'CHINAUNIONPAY',
            'WIRE_TRANSFER_SL' => 'MegaTransfer SiauLiu',
            'WIRE_TRANSFER_SP' => 'MegaTransfer Sparkasse',
            'WIRE_TRANSFER_PC' => 'Piraeus Cyprus',
            'WIRE_TRANSFER_BOC' => 'Bank of Cyprus',
            'WIRE_TRANSFER_EC' => 'Eurobank Cyprus',
            'N/A' => 'N/A',
            'TR' => 'TRANSIT TRANSFER',
            'FASAPAY'=>'FASAPAY',
            'PAYOMA'=>'PAYOMA'
        );
        return $transaction_type[$tp];
    }


}




?>