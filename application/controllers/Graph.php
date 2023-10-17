<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

    private $isCPA = false;
    private $oveallResult = [];
    private $counter = 0;
    
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
            $this->load->model('General_model');
            $this->load->model('account_model');
            $this->g_m=$this->General_model;
        }else{
            show_404();
        }
    }

    public function index() {
        if ($this->session->userdata('logged')) {  
            $user_id = $this->session->userdata('user_id');
            // print_r($user_id);
            // exit;
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }
            $data['affiliate_code_select'] =  $affiliate_code;
            $data['affiliate_code'] =  $affiliate_code[0]['affiliate_code'];
            $data['isCPA'] = $this->isCPA;
            $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
            // print_r($this->session->userdata());
            // exit;
            // $data['aff_codes'] = $this->account_model->getAffiliates($user_id); 
            $data['active_tab'] = 'partnership';
            $data['active_sub_tab'] = 'graph';
            $data['title_page'] = 'Graph';

            $js = $this->template->Js();
            $css = $this->template->Css();
			
            $this->template->title('Graph')
                ->set_layout('internal/main')
                ->append_metadata_css("
                    <link rel='stylesheet' href='".$css."summernote.css'>z
                ")
                ->append_metadata_js("
                    <script src='".$js."jquery-1.11.3.min.js'></script>
                    <script src='".$js."summernote.js'></script>
                    <script src='".$js."jquery.ui.widget.js'></script>
                    <script src='".$js."jquery.validate.js'></script>
                    <script src='".$js."jquery.fileupload.js'></script>
                ")
                ->build('graph', $data);
			}
        else{
            redirect('signout');
        }
    }
    public function requestCommission(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
            $user_id = $this->session->userdata('user_id');
            $aff_code = $this->input->post('affiliate_code');

            if($this->isCPA){

                $from = date('Y-m-d\TH:i:s', strtotime($this->input->post('from').' 00:00:00'));
                $to = date('Y-m-d\TH:i:s', strtotime($this->input->post('to').' 23:59:59'));
                $type_array= array('0'=>'Pending','1'=>'Approved','2'=>'Declined');
                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if($sub_partner){
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                }else{
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                }
    //            $cpa_type = $this->input->get('cpa');

    //            $cpa_type = strlen($cpa_type)>0 ?$cpa_type:1;
                $cpa_type = 1;
    //            echo $sub_partner['partner_id'];
                if($sub_partner) {
                    $data['cpa'] = $this->partners_model->getCpaClientListWithAffiliateCode($sub_partner['partner_id'], $cpa_type,$aff_code,$from,$to);
                    $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
                    $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($sub_partner['partner_id']);
                }else{
                    $data['cpa'] = $this->partners_model->getCpaClientListWithAffiliateCode($user_id, $cpa_type,$aff_code,$from,$to);
                    $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                    $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                }
                foreach($data['cpa'] as $key => $value){
                    if($value->registration_time != null){
                        $d=date("M Y d",strtotime($value->registration_time));
                        $output[$d]->month = date("Y-m-d",strtotime($value->registration_time));
                        $output[$d]->value+=$value->amount;
                    }
                    
                }
                if($output == null){
                        $output = array(array(
                            'month' => date('Y-m-d'),
                            'value' => 0
                        ));
                    echo json_encode(array_values($output));
                }else{
                    echo json_encode(array_values($output));
                }
                return false;
            }else{






                $ac = $this->account_model->getAccountNumberByUserId( $user_id );
                $partners = $this->account_model->getAccountNumfromAffliateCode($user_id,$aff_code);
                $from = date('Y-m-d\TH:i:s', strtotime($this->input->post('from').' 00:00:00'));
                $to = date('Y-m-d\TH:i:s', strtotime($this->input->post('to').' 23:59:59'));
                // echo $from.' '.$to;
                // exit; 

                $account_info2 = array(
                   'iLogin' => $ac['account_number'],
                    // 'iLogin' =>'102032',
                    'from' => $from ,
                    'to' =>  $to
                );

  
                $webservice_config = array('server' => 'live_new');
                $WebService = new WebService($webservice_config);
                $WebService->GetAgentsCommissionByDate($account_info2);

                switch($WebService->request_status){
                    case 'RET_OK':


                        $CommisionList =  $WebService->get_result('CommisionList');
                        $data['commisionList'] = isset($CommisionList->CommissionData)?$CommisionList->CommissionData:false;
                        if($data['commisionList'] == true){

                            $affiliate_accountnumber = array_column($partners, 'affiliate_accountnumber');
                            foreach($data['commisionList'] as $key => $val){
                                if(in_array($val->FromAccount,$affiliate_accountnumber)){
                                $d=date("M Y d",strtotime($val->Date));
                                $output[$d]->month = date("Y-m-d",strtotime($val->Date));
                                $output[$d]->value+=$val->Amount;

                                }
                            }
                        }
                        break;
                    default:
                        $data['error']=true;
                }
                if($output == null){
                    $output = array(array(
                            'month' => date('Y-m-d'),
                            'value' => 0
                        ));
                    echo json_encode(array_values($output));
                }else{
                    echo json_encode(array_values($output));
                }
                return false;
            }
        }

    }


    public function requestCommission_v2(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
            $user_id = $this->session->userdata('user_id');
            $aff_code = $this->input->post('affiliate_code');

            if($this->isCPA){
                $from = date('Y-m-d\TH:i:s', strtotime($this->input->post('from').' 00:00:00'));
                $to = date('Y-m-d\TH:i:s', strtotime($this->input->post('to').' 23:59:59'));
                $type_array= array('0'=>'Pending','1'=>'Approved','2'=>'Declined');
                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if($sub_partner){
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
                }else{
                    $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
                }
                //            $cpa_type = $this->input->get('cpa');

                //            $cpa_type = strlen($cpa_type)>0 ?$cpa_type:1;
                $cpa_type = 1;
                //            echo $sub_partner['partner_id'];
                if($sub_partner) {
                    $data['cpa'] = $this->partners_model->getCpaClientListWithAffiliateCode($sub_partner['partner_id'], $cpa_type,$aff_code,$from,$to);
                    $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
                    $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($sub_partner['partner_id']);
                }else{
                    $data['cpa'] = $this->partners_model->getCpaClientListWithAffiliateCode($user_id, $cpa_type,$aff_code,$from,$to);
                    $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                    $data['PartnershipAgreementStatus'] = $this->partners_model->getPartnershipAgreementStatus($user_id);
                }
                foreach($data['cpa'] as $key => $value){
                    if($value->registration_time != null){
                        $d=date("M Y d",strtotime($value->registration_time));
                        $output[$d]->month = date("Y-m-d",strtotime($value->registration_time));
                        $output[$d]->value+=$value->amount;
                    }

                }
                if($output == null){
                    $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                    echo json_encode(array_values($output));
                }else{
                    echo json_encode(array_values($output));
                }
                return false;
            }else{
               $from = FXPP::unixTime($this->input->post('from',true).' 00:00:00');
                $to =  FXPP::unixTime($this->input->post('to',true).' 23:59:59');

                $this->load->library('WSV');
                $WSV = new WSV();
                ini_set('default_socket_timeout', 600); // 5 minutes
               $serviceData = array('From' => $from,'To'=>$to);
                $requestResult = $WSV->GetCommissionHistory($serviceData);


                switch($requestResult['ErrorMessage']){
                    case 'RET_OK':
                        $commisionList = $requestResult['Data']->Transactions->TradeRecord;
                        if(count($commisionList) > 0){

                            foreach($commisionList as $key => $val){
                                $unixCloseTime = new DateTime("@$val->CloseTime");
                                $d = $unixCloseTime->format('M Y d');
                                $output[$d]->month = $unixCloseTime->format('Y-m-d');
                                $output[$d]->value+=$val->Profit;


                            }

                        }
                        break;
                    default:
                        $data['error']=true;
                }
                if($output == null){
                    $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                    echo json_encode(array_values($output));
                }else{
                    echo json_encode(array_values($output));
                }
                return false;
            }
        }

    }



    public function getClicksData(){
         if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            $date_from = date('Y-m-d',strtotime($this->input->post('from').' 00:00:00'));
            $date_to = date('Y-m-d',strtotime($this->input->post('to').' 23:59:59'));
            $code = $this->input->post('affiliate_code');
            // echo $date_to;
            // exit;

            $getdatas = $this->partners_model->getClickAndRegisterAcByCode($code,$date_from,$date_to);
            foreach($getdatas as $key => $getdata){
                if($getdata->num != 0){
                    if($getdatas[$key-1]){
                        $getdatas[$key]->num = $getdatas[$key-1]->num + $getdata->num;
                    }
                    
                    $d=date("M Y d",strtotime($getdata->date));
                    $output[$d]->month = date("Y-m-d",strtotime($getdata->date));
                    $output[$d]->value+=$getdata->num;      
                }

            } 
            if($output == null){
                $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                echo json_encode(array_values($output));
            }else{

                echo json_encode(array_values($output));
            }
         }
    }
    public function getref(){
    if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {
        $offset = '0';
        $rowPerPage = '10';
        $status = '';
        $date_from = date('Y-m-d',strtotime($this->input->post('from')));
        $date_to =  date('Y-m-d',strtotime($this->input->post('to')));
        $aff_code = $this->input->post('affiliate_code',true);
        // echo $date_from;
        // exit;


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
            'limit' => $rowPerPage,
            'affiliate_code' => $aff_code
        );

        $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
        $getAllReferrals = $this->partners_model->getAllPartnershipReferralsWithAffiliateCode($postData);
        $counter =1;
        foreach($getAllReferrals as $key => $value){
                $getAllReferrals[$key]['counter'] = $counter;
                if($getAllReferrals[$key-1]){
                        $getAllReferrals[$key]['counter'] = $getAllReferrals[$key-1]['counter'] + $getAllReferrals[$key]['counter'];
                }
                $d=date("M Y d",strtotime($value['registration_time']));
                $output[$d]->month = date("Y-m-d",strtotime($value['registration_time']));
                $output[$d]->value += $getAllReferrals[$key]['counter'];
        }

        if($output == null){
                $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                echo json_encode(array_values($output));
            }else{
                echo json_encode(array_values($output));
            }
        }
    }
    public function getref1(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged') ) {

            if (IPLoc::APIUpgradeDevIP()) {
                $dateFrom = FXPP::unixTime($this->input->post('from', true) . ' 00:00:00');
                $dateTo = FXPP::unixTime($this->input->post('to', true) . ' 23:59:59');

                $start = 0;
                $length = 500;

                $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => $length, 'Offset' => $start, 'isCPA' => $this->isCPA);
                $referralData = FXPP::getReferralsOfAccount($requestData);
                $dataCount = $referralData['referralCount']; //total count
                $referralList = $referralData['referralList'];


                foreach ($referralList as $key => $obj) {
                    $unixRegDate = new DateTime("@$obj->RegDate");

                    $d = $unixRegDate->format('M Y d');
                    $output[$d]->month = $unixRegDate->format('Y-m-d');
                    $output[$d]->value += 1;

                }

                if ($output == null) {
                    $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                    echo json_encode(array_values($output));
                } else {
                    echo json_encode(array_values($output));
                }


            } else {


                $offset = '0';
                $rowPerPage = '10';
                $status = '';
                $date_from = date('Y-m-d', strtotime($this->input->post('from')));
                $date_to = date('Y-m-d', strtotime($this->input->post('to')));
                $aff_code = $this->input->post('affiliate_code', true);
                $user_id = $this->session->userdata('user_id');

                $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                if ($this->isCPA) {
                    if ($sub_partner) {
                        $user_id = $sub_partner['partner_id'];
                    }
                }


                $postData = array(
                    'user_id'        => $user_id,
                    'status'         => $status,
                    'date_from'      => $date_from,
                    'date_to'        => $date_to,
                    'offset'         => $offset,
                    'limit'          => $rowPerPage,
                    'affiliate_code' => $aff_code
                );

                $countAllReferrals = $this->partners_model->countAllPartnershipReferrals($postData);
                $getAllReferrals = $this->partners_model->getReferralCountofAffiliateCode($aff_code, $date_from, $date_to);
                if (count($getAllReferrals) > 0) {
                    $output[] = array(
                        "month" => date("Y-m-d", strtotime($getAllReferrals[0]['date_created'])),
                        "value" => $getAllReferrals[0]['referralCount']
                    );
                    for ($i = 1; $i < count($getAllReferrals); $i ++) {
                        $output[] = array(
                            "month" => date("Y-m-d", strtotime($getAllReferrals[$i]['date_created'])),
                            "value" => (($output[$i - 1]['value']) + ($getAllReferrals[$i]['referralCount']))
                        );
                    }
                }
                if ($output == null) {
                    $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                    echo json_encode(array_values($output));
                } else {
                    echo json_encode(array_values($output));
                }
            }
        }
    }


    public function commision_statistics(){

            $user_id = $this->session->userdata('user_id');
            $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
            if($sub_partner){
                $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
            }else{
                $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
            }


            // $data['affiliate_code_select'] =  $affiliate_code;
            $date_from = date('Y-m-d',strtotime('05/05/2015 00:00:00'));
            $date_to = date('Y-m-d',strtotime('03/17/2017 23:59:59'));
            $code = $affiliate_code;
            // echo $date_to;
            // exit;
            // $clicksFinalRes = [];
            print_r(count($code-1));
            exit;
            // for($x = 0, $x <= count($code), $x++){
            //      $output['affiliate_code'] = $value;
                $getdatas = $this->partners_model->getClickAndRegisterAcByCode($code,$date_from,$date_to);
                    foreach($getdatas as $key => $getdata){
                        if($getdata->num != 0){
                            if($getdatas[$key-1]){
                                $getdatas[$key]->num = $getdatas[$key-1]->num + $getdata->num;
                            }
                            
                            $d=date("M Y d",strtotime($getdata->date));
                            $output[$d]->month = date("Y-m-d",strtotime($getdata->date));
                            $output[$d]->value+=$getdata->num;      
                        }

                    }

            //     array_push($clicksFinalRes, $output);
            // }

            print_r($output);
            exit;
            if($output == null){
                $output = array(array(
                        'month' => date('Y-m-d'),
                        'value' => 0
                    ));
                echo json_encode(array_values($output));
            }else{

                echo json_encode(array_values($output));
            }
    }

}