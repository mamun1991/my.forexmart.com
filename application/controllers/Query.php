<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('General_model');
        $this->load->model('Accountverification_model');
        $this->g_m=$this->General_model;
        $this->av_m=$this->Accountverification_model;
        $this->load->library('Fx_mailer');
        $this->load->model('account_model');
    }

    public function is_verified(){
//        if(IPLoc::IPCrpAccVerify()){
//          echo "eererewrewrw";exit();
//        }
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if(!$this->session->userdata('logged')){redirect('signout');}
        $user_id=$_SESSION['user_id'];
        $account_info = array(
            'iLogin' => $account_number=$_SESSION['account_number']
        );

        $webservice_config = array(
            'server' => 'live_new'
        );
        if ($this->input->post('account_verification',true)==0){
//            $WebService = new WebService($webservice_config);
//            $WebService->open_RequestAccountDetails($account_info);

            $this->load->library('WSV'); //New web service
            $WSV = new WSV();

            $WebService = $WSV->GetAccountDetailsSingle($account_info, $webservice_config);
            switch ($WebService->request_status) {
                case 'RET_OK':

                    $data2['IsReadOnly']=$WebService->result['IsReadOnly'];
                    if ($WebService->result['IsReadOnly']==false){

                        /* FXPP-6539 P01 - Allow accounts to be credited with NDB without the need for verification in FXPP */
//                        if(IPLoc::Office_for_NDB()){
                            $data2['verification_status'] = 'Read Only';

                            $data['users'] = $this->g_m->showssingle($table="users","id",$user_id,"accountstatus",'');

                            if ($data['users']){

                                if ($data['users']['accountstatus']==1){

                                    $data2['verification_status']='Verified';
                                }

                            }

//                        }else{

//                            $this->db->trans_start();
//
//                            $data['users'] = $this->g_m->showssingle($table="users","id",$user_id,"email",'');
//
//                            $data['DateUp'] = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
//                            $data['verify'] = array(
//                                'accountstatus' => 1,
//                                'verified' => $data['DateUp']->format('Y-m-d H:i:s')
//                            );
//                            $this->g_m->updatemy($table="users","id",$user_id,$data['verify']);
//                            $data['mts_update'] = array(
//                                'mt_status' => 1
//                            );
//                            $this->g_m->updatemy($table = "mt_accounts_set", "user_id", $user_id, $data['mts_update']);
//
//                            /* FXPP-6539 P01 - Allow accounts to be credited with NDB without the need for verification in FXPP */
//
//                            $data['ProfileInfo'] = $this->g_m->showssingle($table = "user_profiles", "user_id", $user_id, "full_name", '');
//                            $data['DocType0'] = $this->av_m->show1st1w3($table = "user_documents", 'user_id', $user_id, 'doc_type', '0', 'status', '1', "*", '');
//                            $data['DocType1'] = $this->av_m->show1st1w3($table = "user_documents", 'user_id', $user_id, 'doc_type', '1', 'status', '1', "*", '');
//                            $data['DocType2'] = $this->av_m->show1st1w3($table = "user_documents", 'user_id', $user_id, 'doc_type', '2', 'status', '1', "*", '');
//
//
//                            if ($data['DocType0'] == false) {
//                                $data['DocType0']['client_name'] = '';
//                                $data['DocType0']['file_name'] = '';
//                                $data['DocType0']['doc_type'] = '';
//                            }
//                            if ($data['DocType1'] == false) {
//                                $data['DocType1']['client_name'] = '';
//                                $data['DocType1']['file_name'] = '';
//                                $data['DocType1']['doc_type'] = '';
//                            }
//                            if ($data['DocType2'] == false) {
//                                $data['DocType2']['client_name'] = '';
//                                $data['DocType2']['file_name'] = '';
//                                $data['DocType2']['doc_type'] = '';
//                            }
//
//                            $data['senddata'] = array(
//
//                                'Email' => $data['users']['email'],
//                                'AccountNumber' => $account_number,
//                                'FullName' => $data['ProfileInfo']['full_name'],
//
//                                'ClientName0' => $data['DocType0']['client_name'],
//                                'FileName0' => $data['DocType0']['file_name'],
//                                'DocIdx0' => $data['DocType0']['doc_type'],
//
//                                'ClientName1' => $data['DocType1']['client_name'],
//                                'FileName1' => $data['DocType1']['file_name'],
//                                'DocIdx1' => $data['DocType1']['doc_type'],
//
//                                'ClientName2' => $data['DocType2']['client_name'],
//                                'FileName2' => $data['DocType2']['file_name'],
//                                'DocIdx2' => $data['DocType2']['doc_type']
//
//                            );
//
//                            $data2['verification_status']='Verified';
//                            Fx_mailer::AccountVerificationVerifiedUser($data['senddata']);
//                            $this->db->trans_complete();
//                        }
                        /* FXPP-6539 P01 - Allow accounts to be credited with NDB without the need for verification in FXPP */


                    }else{
                        $data2['verification_status']='Read Only';
                    }

                    break;
                default:
                    $data2['verification_status']='Read Only';
            }
        }
        echo json_encode($data2);
        unset($data);
        unset($data2);
    }


    public function partner_agreement() {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['user_id'] = $this->session->userdata('user_id');
        $data['users'] = $this->g_m->showssingle($table = "users", "id", $data['user_id'], "partner_agreement", '');

        $bdUser = $this->g_m->isBdcountry($data['user_id']);
        $data['bdUser'] = $bdUser['country'];


        $bdUserAdminApproved = $this->g_m->isAdminApproved($data['user_id']);
        $data['bdUserAdminApproved'] = $bdUserAdminApproved['approved_affiliate_code'];

        //$isPartner = $this->session->userdata('login_type');  // This is partner account or not. 1= partner, 0= Client
        //$data['isPartner']= $isPartner;

        if($data['users']){
            if($data['users']['partner_agreement']==1){
                $data['IsCheckedAgreement']=true;
            }else{
                $data['IsCheckedAgreement']=false;
            }
        }else{
            $data['IsCheckedAgreement']=false;
        }



        $this->load->model('partners_model');
        $user_id = $this->session->userdata('user_id');
        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
        } else {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
        }
        $data['affiliate_code_req'] = $affiliate_code[0]['affiliate_code'];








        echo json_encode($data);
        unset($data);
    }




    public function partner_agreement_bdpartner() {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['user_id'] = $this->session->userdata('user_id');
        $bdAartnerAcc = $this->g_m->isAdminApprovedPartnerCode($data['user_id']);
        $data['partnerApproved']=$bdAartnerAcc['partner_approved_affiliate_code'];
        $data['bdUsers']=FXPP::getCountryCode();
        echo json_encode($data);
        unset($data);
    }



    public function partnership_affiliate_request() {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['user_id'] = $this->session->userdata('user_id');
        $data['bdUsers']=FXPP::getCountryCode();


        $data['updateBDUserPartner']=array(
            'partner_approved_affiliate_code' => 1
        );

        if($data['bdUsers']=="BD"){
            $data['isUpdated']=$this->g_m->updatemy($table='partnership_affiliate_code',$field='partner_id',$id=$data['user_id'],$data['updateBDUserPartner']);

        }
        if($data['isUpdated']){
            $data['updatedSuccess']=true;
        }else{
            $data['updatedSuccess']=false;
        }

        echo json_encode($data);
        unset($data);
    }








    public function partner_agreement_update() {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['user_id'] = $this->session->userdata('user_id');
        $data['update']=array(
            'partner_agreement'=>1
        );

        $data['updateBDUser']=array(
            'approved_affiliate_code' => 1
        );

        $bdUserCheck = $this->g_m->isBdcountry($data['user_id']);
        $data['bdUserCheck'] = $bdUserCheck['country'];


        if($data['bdUserCheck']=="BD"){
            $this->g_m->updatemy($table='users_affiliate_code',$field='users_id',$id=$data['user_id'],$data['updateBDUser']);
        }





        $data['users'] = $this->g_m->updatemy($table='users',$field='id',$id=$data['user_id'],$data['update']);
        $data['client_account'] = $this->g_m->showst4j2w1($table='users',$table2='user_profiles',$table3='mt_accounts_set',$table4='users_affiliate_code',$field='users.id',$id=$data['user_id'],$join12='user_profiles.user_id=users.id',$join13='mt_accounts_set.user_id=users.id',$join14='users_affiliate_code.users_id=users.id',$select='user_profiles.full_name,mt_accounts_set.account_number,users_affiliate_code.affiliate_code,user_profiles.country');

        if($data['users']){
            $data['senddata'] = array(
                'full_name' => $data['client_account']['full_name'],
                'account_number' => $data['client_account']['account_number'],
                'country' => $this->general_model->getCountries($data['client_account']['country']),
                'affiliate_link' =>  FXPP::www_url().'register?id='.$data['client_account']['affiliate_code'],
                'date' => date('M d, Y')
            );

            if($data['bdUserCheck']!="BD") {

                Fx_mailer::partners_agreement($data['senddata']);
            }

        }
        $data['isUpdated']=$data['users'];

       // $data['isBD']="BD";





        $this->load->model('partners_model');
        $user_id = $this->session->userdata('user_id');
        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
        if ($sub_partner) {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($sub_partner['partner_id']);
        } else {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($user_id);
        }
        $data['affiliate_code_req'] = $affiliate_code[0]['affiliate_code'];






        echo json_encode($data);
        unset($data);
    }

    public function pa_test() {
        $data['user_id'] = $this->session->userdata('user_id');
//        $data['update']=array(
//            'partner_agreement'=>1
//        );
//        $data['users'] = $this->g_m->updatemy($table='users',$field='id',$id=$data['user_id'],$data['update']);
        $data['client_account'] = $this->g_m->showst4j2w1($table='users',$table2='user_profiles',$table3='mt_accounts_set',$table4='users_affiliate_code',$field='users.id',$id=$data['user_id'],$join12='user_profiles.user_id=users.id',$join13='mt_accounts_set.user_id=users.id',$join14='users_affiliate_code.users_id=users.id',$select='user_profiles.full_name,mt_accounts_set.account_number,users_affiliate_code.affiliate_code');
var_dump($data['client_account'] );

            $data['senddata'] = array(
                'full_name' => $data['client_account']['full_name'],
                'account_number' => $data['client_account']['account_number'],
                'affiliate_link' =>  FXPP::www_url().'register?id='.$data['client_account']['affiliate_code'],
                'date' => date('M d, Y')
            );
        var_dump($data['senddata']);
            Fx_mailer::partners_agreement($data['senddata']);

    }

    public function open_trading() {
        $webservice_config = array(
            'server' => 'live_new'
        );
        $WebService = new WebService($webservice_config);

        $account_info = array(
            'AccountNumber' =>'114900'
        );

        $WebService->open_ActivateAccountTrading($account_info);
        if( $WebService->request_status === 'RET_OK' ) {
            echo 'success 114900';
        }else{
            echo 'failed 114900';
        }
    }

    public function upload(){

        if (!$this->input->is_ajax_request()) {die('Not authorized!');}

        $user_id = $this->session->userdata('user_id');
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if(!empty($_FILES['file']['name'])){
            $this->load->helper(array('form', 'url'));
            $_FILES['userfile']['name']    = $_FILES['file']['name'];
            $_FILES['userfile']['type']    = strtolower($_FILES['file']['type']);
            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error']       = $_FILES['file']['error'];
            $_FILES['userfile']['size']    = $_FILES['file']['size'];
            $config['file_name']=  hash('sha384',$_FILES['userfile']['name']);// hash for external pages.
            $config['upload_path'] =$this->config->item('asset_user_docs');//'/var/www/html/my.forexmart.com/assets/user_docs/';
            $config['allowed_types'] = 'gif|JPG|JPEG|jpg|jpeg|png|bmp|pdf';
            $config['max_size']      = '10000';
            $config['max_width']     = '0';
            $config['max_height']    = '0';
            $config['overwrite']     = false; // DO NOT CHANGE
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            try{
                if($this->upload->do_upload()){
                    $uploadData = $this->upload->data();
                    $updData = array(
                        'user_id' => $user_id,
                        'doc_type' => $this->input->post('doc_type',true),
                        'file_name' => $uploadData['file_name'],
                        'client_name' => $uploadData['client_name'],
                        'status' => 0,
                    );


                    $config['source_image'] = $this->config->item('asset_user_docs').$uploadData['file_name'];//'./assets/user_docs/'. $uploadData['file_name'];

                        FXPP::setWaterMark($config['source_image']);


                    $return=$this->g_m->insertmy($table="user_documents",$updData);
                    $data['error'] = false;
                    $data['msgError_ext']=false;
                }else{
                    $data['msgError'] = $this->upload->display_errors();
                    $data['error'] = true;
                    //http://php.net/manual/en/function.exif-imagetype.php
                    $data['filetype'] = exif_imagetype($_FILES['file']['tmp_name']);
                    $data['filetype2']=strtolower($_FILES['file']['type']);
                    $data['msgError_ext']=false;
                    switch(strtolower($_FILES['file']['type'])){
                        case 'image/gif':
                            if (exif_imagetype($_FILES['file']['tmp_name'])==1){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] ="There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        case 'image/jpeg':
                            if (exif_imagetype($_FILES['file']['tmp_name'])==2){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] ="There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        case 'image/png':
                            if (exif_imagetype($_FILES['file']['tmp_name'])==3){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] ="There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        default:
                    }
                }
             } catch(Exception $e){
                    $data['msgError_ext']=false;
                    if (strpos($e->getMessage(), 'pdf') !== false) {
                        $data['msgError']="The PDF file type that you uploaded is not supported.";
                    }else{
                        $data['msgError'] = $e->getMessage() ;
                    }
//                    $data['msgError'] =str_replace("/var/www/html/my.forexmart.com/assets/user_docs/", "",$e->getMessage() );
//                    $data['msgError'] =str_replace("free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details)", " upload engine.",$data['msgError'] );
                    $data['error'] = true;
             }
        }else{
            $data['msgError'] = 'Please select a file.';
            $data['error'] = true;
        }
        echo json_encode($data);
    }

    public function us_id(){
        $user_id = $this->session->userdata('user_id');
        var_dump($user_id);
    }

    public function trading_open_pending_order(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}

//        $this->db->trans_start();
        $data['mtas']=$this->general_model->showssingle($table='mt_accounts_set',$field='user_id',$_SESSION['user_id'],'account_number');

        $data['expiration'] = DateTime::createFromFormat('m-d-Y',  $this->input->post('Expiration',true));
        $data['expiration']->setTime(59,59,59);
//        $data['expiration']='';

        $data['insert_b4API']=array(
            'users_id'=>$_SESSION['user_id'],
            'Comment'=> $this->input->post('Comment',true),
            'Expiration'=>$data['expiration']->format('Y-m-d H:i:s'),
            'RequestType'=>$this->input->post('RequestType',true),
            'StopLoss'=>$this->input->post('StopLoss',true),
            'Symbol'=>$this->input->post('Symbol',true),
            'TakeProfit'=>$this->input->post('TakeProfit',true),
            'Volume' =>  $this->input->post('Volume',true),
            'OpenPrice' =>  $this->input->post('OpenPrice',true),
            'Status'=>0,//0 pending 1 set
        );
        $data['order_id']=$this->g_m->insertmy($table='trading_pending_order',$data['insert_b4API']);
//        $data['order_id']=1
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $data['account_info']=$account_info= array(
            'Comment' => $this->input->post('Comment',true),
            'Login' => $data['mtas']['account_number'],
            'OpenPrice' =>  $open_price=$this->input->post('OpenPrice',true),
            'Expiration' => $data['expiration']->format('Y-m-d\TH:i:s'),
            'OrderId' =>  0,
            'RequestType' => $request_type= $this->input->post('RequestType',true),
            'StopLoss' =>  $this->input->post('StopLoss',true),
            'Symbol' => $symbol=$this->input->post('Symbol',true),
            'TakeProfit' => $this->input->post('TakeProfit',true),
            'Volume' =>  $volume=$this->input->post('Volume',true),
        );
        $WebService->open_RequestOpenPendingOrder($account_info);
        $API_Response=$WebService->get_result('ReqResult');
        switch($API_Response){
            case 'RET_OK':
                $OrderTicket=$WebService->get_result('OrderTicket');
                $data['update_afrAPI']=array(
                    'Status'=>1,//0 pending 1 set
                    'OrderTicket'=>$OrderTicket,
                );
                $data['update']=$this->g_m->updatemy($table='trading_pending_order',$field='id',$id=$data['order_id'],$data['update_afrAPI']);
                $data['api']='success';
                $data['request'] = "Request Succeeded: "."<br/><br/>"."Pending Order Ticket #".$OrderTicket ." ".str_replace("_"," ",$request_type) . " Volume " .$volume ." ". $symbol ." at ".$open_price." ". " successful." ;
                break;
            default:
                $data['update_afrAPI']=array(
                    'Status'=>2,//0 pending 1 set 2 error
                    'api_status'=>$API_Response,
                );
                $data['update']=$this->g_m->updatemy($table='trading_pending_order',$field='id',$id=$data['order_id'],$data['update_afrAPI']);
                $data['api']='fail';
                $data['request']='Request failed '.$API_Response;
        }
//        var_dump($WebService);

        echo json_encode($data);
    }
    public function trading_symbols(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $WebService->open_GetCurrentQuotes();
        switch($WebService->request_status){
            case 'RET_OK':
                $quotes = (array) $WebService->get_result('Quotes');
                $options[]='';
                $data['selopt']='';
                foreach ( $quotes['QuoteData'] as $object){
//                    $data['market-execution'][$object->Symbol]['ask']=$object->Ask;
//                    $data['market-execution'][$object->Symbol]['bid']=$object->Bid;
                    $data['selopt'].='<option
                                            name="'.$object->Symbol.'"
                                            value="'.$object->Symbol.'"
                                            data-ask="'.$object->Ask.'"
                                            data-bid="'.$object->Bid.'"
                                            data-high="'.$object->High.'"
                                            data-low="'.$object->Low.'"
                                            data-digits="'.$object->Digits.'"
                                            data-spread="'.$object->Spread.'"
                                            data-symbol="'.$object->Symbol.'"
                                            data-timestamp="'.$object->Timestamp.'"
                                            >';
                    $data['selopt'].=$object->Symbol;
                    $data['selopt'].='</option>';
                }
                break;
            default:
        }
        echo json_encode($data);

    }


    public function trading_open_market_execution(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['mtas']=$this->general_model->showssingle($table='mt_accounts_set',$field='user_id',$_SESSION['user_id'],'account_number');
//        var_dump($data['mtas']['account_number']);die();

        $data['insert_b4API']=array(
            'users_id'=>$_SESSION['user_id'],
            'Comment'=>$this->input->post('Comment',true),
            'RequestType'=> $this->input->post('RequestType',true),
            'StopLoss'=>$this->input->post('StopLoss',true),
            'Symbol'=>$this->input->post('Symbol',true),
            'TakeProfit'=>$this->input->post('TakeProfit',true),
            'Volume' =>  $this->input->post('Volume',true),
            'OpenPrice' =>  $this->input->post('OpenPrice',true),
            'ClosePrice' =>  0,
            'Status'=>0,//0 pending 1 set
        );
        $data['order_id']=$this->g_m->insertmy($table='trading_market_execution',$data['insert_b4API']);
//        $data['order_id']=1
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $account_info= array(
            'ClosePrice' =>  0,
            'Comment' =>$this->input->post('Comment',true),
            'Login' => $data['mtas']['account_number'],
            'OpenPrice' =>  $open_price=$this->input->post('OpenPrice',true),
            'OrderId' =>  0,
            'RequestType' => $request_type=$this->input->post('RequestType',true),
            'StopLoss' =>  $this->input->post('StopLoss',true),
            'Symbol' => $symbol=$this->input->post('Symbol',true),
            'TakeProfit' => $this->input->post('TakeProfit',true),
            'Volume' => $volume= $this->input->post('Volume',true),
        );
        $WebService->open_RequestOpenTrade($account_info);
        switch($WebService->request_status){
            case 'OK':

                $data['update_afrAPI']=array(
                    'Status'=>1,//0 pending 1 set
                    'OrderTicket'=>$order_ticket=$WebService->get_result('OrderTicket')
                );

                $data['update']=$this->g_m->updatemy($table='trading_market_execution',$field='id',$id=$data['order_id'],$data['update_afrAPI']);

                $data['request'] = "Request Succeeded: "."<br/><br/>"."Market Execution Ticket #".$order_ticket ." ".strtolower($request_type) . " Volume " .$volume ." ". $symbol ." at ".$open_price." ". " successful." ;

                $data['api']="Request Succeeded";
                break;
            default:
                $data['update_afrAPI']=array(
                    'Status'=>2,//0 pending 1 set 2 error
                    'api_status'=>$WebService->request_status
                );
                $data['update']=$this->g_m->updatemy($table='trading_market_execution',$field='id',$id=$data['order_id'],$data['update_afrAPI']);

                $data['request']="Request Failed ". $WebService->request_status;
                $data['api']="Request Failed";
        }
        echo json_encode($data);

    }
    public function testautolev(){
        die();
        FXPP::leverage_auto_change();
    }
    public function testview(){
        die();
        $data['ProfileInfo'] = $this->g_m->showssingle($table = "approved_live_accounts", "id", '11946', "*", '');

        var_dump($data['ProfileInfo']);
    }
    public function test_verify(){
        die();
        FXPP::verify_duplicate_live_account();
    }

    public function test_verify_partner(){
        die();
        FXPP::verify_duplicate_partner_account();
    }



    public function manual_leverage_change(){
        die();
        FXPP::manual_leverage_auto_change();
    }
    public function testautomailep(){
        $data['user_id'] = $this->session->userdata('user_id');

        $data['update']=array(
            'partner_agreement'=>1
        );
        $data['users'] = $this->g_m->updatemy($table='users',$field='id',$id=$data['user_id'],$data['update']);
        $data['client_account'] = $this->g_m->showst4j2w1($table='users',$table2='user_profiles',$table3='mt_accounts_set',$table4='users_affiliate_code',$field='users.id',$id=$data['user_id'],$join12='user_profiles.user_id=users.id',$join13='mt_accounts_set.user_id=users.id',$join14='users_affiliate_code.users_id=users.id',$select='user_profiles.full_name,mt_accounts_set.account_number,users_affiliate_code.affiliate_code,user_profiles.country');

//        if($data['users']){
            $data['senddata'] = array(
                'full_name' => $data['client_account']['full_name'],
                'account_number' => $data['client_account']['account_number'],
                'country' => $this->general_model->getCountries($data['client_account']['country']),
                'affiliate_link' =>  FXPP::www_url().'register?id='.$data['client_account']['affiliate_code'],
                'date' => date('M d, Y')
            );
            Fx_mailer::partners_agreement_test($data['senddata']);
//        }
        $data['isUpdated']=$data['users'];
        echo json_encode($data);
        unset($data);
    }
    public function testautomailep2(){
        $data['senddata'] = array(
            'full_name' => 'name',
            'account_number' => 'number',
            'country' => $this->general_model->getCountries("PH"),
            'affiliate_link' =>  FXPP::www_url().'register?id='."asdadasd",
            'date' => date('M d, Y')
        );
        Fx_mailer::partners_agreement_test($data['senddata']);
    }
    public function executedepositupdate(){
        die();
        if(IPLoc::Office()){
            $data['insert'] = array(
                'transaction_id' =>29679,
                'status' =>2,
                'amount' =>100,
                'currency' =>'USD',
                'user_id' =>67313,
                'payment_date' => '2016-06-23 00:00:01',
                'note' =>'Manually Deposit',
                'transaction_type' =>'PAYCO',
                'conv_amount' =>100,
                'mt_ticket' =>275846,

            );
            $data['deposit_insert_id'] = $this->g_m->insertmy($table = "deposit", $data['insert']);
        }
    }
    public function trigger_pol(){
        die();
        FXPP::leverage_change_pol();
    }
    public function trigger_pol2(){
        die();
        FXPP::leverage_change_pol2();
    }
    public function single_leverage_change(){
        die();
        FXPP::single_leverage_change();
    }
    public function alc(){
        //test
        die();
        $this->load->library('UPDATE');
        UPDATE::leverage_auto_change();
    }

    public function  stestasda(){
        //test
        die();
        if (IPLOC::Office_and_Vpn()){
            var_dump($_SESSION['email']);
        }
    }
    public function  TCT(){
        //test
        die();
        if (IPLOC::Office_and_Vpn()){
        $nodepositbonus = $this->g_m->showssingle2($table='users',$field='id',$id=56446,$select='nodepositbonus,created,createdforadvertising');
        if(is_null($nodepositbonus['createdforadvertising'])){
            $data['datecreated']=$nodepositbonus['created'];
        }else{
            $data['datecreated']=$nodepositbonus['createdforadvertising'];
        }
        $datecreated=DateTime::createFromFormat('Y-m-d H:i:s',$data['datecreated']);
        $datedifference=$this->g_m->difference_day($datecreated->format('Y-m-d'),$datecurrent=date('Y-m-d'));
            var_dump($datedifference);
        }
    }
    public function mail_inactive_accounts(){
        //test
        die();
        if (!IPLOC::Office_and_Vpn()){die();}

        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $data = $this->t_m->all_live_users();

        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        foreach($data as $key => $value ){
            echo $value['account_number'];
            $account_info = array(
                'iLogin' =>  $value['account_number']
            );
            $WebService->open_RequestAccountDetails($account_info);
            if( $WebService->request_status === 'RET_OK' ) {
                echo ' active <br/>';
                $this->general_model->updatemy($table='mt_accounts_set',$field='account_number',$id=$value['account_number'],$data=array('is_notactive_notemailed'=>1));
            }else{
                echo ' inactive <br/>';
//                echo $value['email'];
//                $data = array(
//                    'Email'=>$value['email'],
//                    'account_number'=> $value['account_number'],
//                    'Email'=>'trowabarton00005@gmail.com',
//                    'account_number'=> '98496492',
//                );
//                $email_return =  Fx_mailer::inactive_users($data);
//                echo ' - email is sent : '.$email_return.'<br/>';
//                if ($email_return){
                    $this->general_model->updatemy($table='mt_accounts_set',$field='account_number',$id=$value['account_number'],$data=array('is_notactive_notemailed'=>2));
//                }else{
//                    $this->general_model->updatemy($table='mt_accounts_set',$field='account_number',$id=$value['account_number'],$data=array('active'=>3,'inactive_email_error'=>$value['email']));
//                }

            }

        }
    }
    public function trading_open_market_execution_v2(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['mtas']=$this->general_model->showssingle($table='mt_accounts_set',$field='user_id',$_SESSION['user_id'],'account_number');
//        var_dump($data['mtas']['account_number']);die();

        $data['insert_b4API']=array(
            'users_id'=>$_SESSION['user_id'],
            'Comment'=>'TEST',
            'RequestType'=> $this->input->post('RequestType',true),
            'StopLoss'=>$this->input->post('StopLoss',true),
            'Symbol'=>$this->input->post('Symbol',true),
            'TakeProfit'=>$this->input->post('TakeProfit',true),
            'Volume' =>  $this->input->post('Volume',true),
            'OpenPrice' =>  $this->input->post('OpenPrice',true),
            'ClosePrice' =>  0,
            'Status'=>0,//0 pending 1 set
        );
        $data['order_id']=$this->g_m->insertmy($table='trading_market_execution',$data['insert_b4API']);
//        $data['order_id']=1
        $config = array(
            'server' => 'trading'
        );
        $WebService = new WebService($config);
        $account_info= array(
            'ClosePrice' =>  0,
            'Comment' => $this->input->post('Comment',true),
            'Login' => $data['mtas']['account_number'],
            'OpenPrice' =>  $this->input->post('OpenPrice',true),
            'OrderId' =>  0,
            'RequestType' => $this->input->post('RequestType',true),
            'StopLoss' =>  $this->input->post('StopLoss',true),
            'Symbol' => $this->input->post('Symbol',true),
            'TakeProfit' => $this->input->post('TakeProfit',true),
            'Volume' =>  $this->input->post('Volume',true),
        );
        $WebService->open_RequestOpenTrade($account_info);
        switch($WebService->request_status){
            case 'OK':

                $data['update_afrAPI']=array(
                    'Status'=>1,//0 pending 1 set
                );

                $data['update']=$this->g_m->updatemy($table='trading_pending_order',$field='id',$id=$data['order_id'],$data['update_afrAPI']);
                $data['request']="Request Succeeded";
                $data['api']="Request Succeeded";
                break;
            default:
                $data['request']="Request Failed";
                $data['api']="Request Failed";
        }
        echo json_encode($data);

    }

    public function get_monitoring(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $draw = (int) $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order =  $this->input->post('order');

        $accountnumber_project   =  $this->input->post('accountnumber_project');
        $HasFilterToColumns=false;
        $simplerating            =  $this->input->post('simplerating');
        if(isset($simplerating)){
            if($simplerating==''){
                $simpleratingfrom= 0;
                $simpleratingto=0;
            }elseif(strpos($simplerating, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $simplerating);
                $simpleratingfrom = ($pieces[1]==0)? 1: $pieces[1];
                $simpleratingto = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $simplerating);
                $simpleratingfrom = $pieces[0];
                $simpleratingto = $pieces[1];
            }
        }else{
            $simpleratingfrom= 0;
            $simpleratingto=0;
        }


        $dailyprofit             =  $this->input->post('dailyprofit');
        if(isset($dailyprofit)){
            if($dailyprofit==''){
                $dailyprofit_from= 0;
                $dailyprofit_to=0;
            }elseif(strpos($dailyprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $dailyprofit);
                $dailyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $dailyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $dailyprofit);
                $dailyprofit_from = $pieces[0];
                $dailyprofit_to = $pieces[1];
            }
        }else{
            $dailyprofit_from= 0;
            $dailyprofit_to=0;
        }


        $weeklyprofit            =  $this->input->post('weeklyprofit');

        if(isset($weeklyprofit)){
            if($weeklyprofit==''){
                $weeklyprofit_from= 0;
                $weeklyprofit_to=0;
            }elseif(strpos($weeklyprofit, '>') !== false){
                $HasFilterToColumns=true;

                $pieces = explode(">", $weeklyprofit);
                $weeklyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $weeklyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $weeklyprofit);
                $weeklyprofit_from = $pieces[0];
                $weeklyprofit_to = $pieces[1];
            }
        }else{
            $weeklyprofit_from= 0;
            $weeklyprofit_to=0;
        }

        $monthlyprofit           =  $this->input->post('monthlyprofit');
        if(isset($monthlyprofit)){
            if($monthlyprofit==''){
                $monthlyprofit_from= 0;
                $monthlyprofit_to=0;
            }elseif(strpos($monthlyprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $monthlyprofit);
                $monthlyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $monthlyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $monthlyprofit);
                $monthlyprofit_from = $pieces[0];
                $monthlyprofit_to = $pieces[1];
            }
        }else{
            $monthlyprofit_from= 0;
            $monthlyprofit_to=0;
        }

        $threemonthprofit        =  $this->input->post('threemonthprofit');
        if(isset($threemonthprofit)){
            if($threemonthprofit==''){
                $threemonthprofit_from= 0;
                $threemonthprofit_to=0;
            }elseif(strpos($threemonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $threemonthprofit);
                $threemonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $threemonthprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $threemonthprofit);
                $threemonthprofit_from = $pieces[0];
                $threemonthprofit_to = $pieces[1];
            }
        }else{
            $threemonthprofit_from= 0;
            $threemonthprofit_to=0;
        }


        $sixmonthprofit          =  $this->input->post('sixmonthprofit');
        if(isset($sixmonthprofit)){
            if($sixmonthprofit==''){
                $sixmonthprofit_from= 0;
                $sixmonthprofit_to=0;
            }elseif(strpos($sixmonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $sixmonthprofit);
                $sixmonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $sixmonthprofit_to =  0;
                //                $sixmonthprofit_from = $pieces[0];
                //                  $sixmonthprofit_to = $pieces[1];
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $sixmonthprofit);
                $sixmonthprofit_from = $pieces[0];
                $sixmonthprofit_to = $pieces[1];
            }
        }else{
            $sixmonthprofit_from = 0;
            $sixmonthprofit_to = 0;
        }


        $ninemonthprofit         =  $this->input->post('ninemonthprofit');
        if(isset($ninemonthprofit)){
            if($ninemonthprofit==''){
                $ninemonthprofit_from= 0;
                $ninemonthprofit_to=0;
            }elseif(strpos($ninemonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $ninemonthprofit);
                $ninemonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $ninemonthprofit_to = 0;
                //                $ninemonthprofit_from = $pieces[0];
                //                  $ninemonthprofit_to = $pieces[1];
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $ninemonthprofit);
                $ninemonthprofit_from = $pieces[0];
                $ninemonthprofit_to = $pieces[1];
            }
        }else{
            $ninemonthprofit_from = 0;
            $ninemonthprofit_to = 0;
        }

        $totalprofit             =  $this->input->post('totalprofit');
        if(isset($totalprofit)){
            if($totalprofit==''){
                $totalprofit_from= 0;
                $totalprofit_to=0;
            }elseif(strpos($totalprofit, '>') !== false){
                $HasFilterToColumns=true;

                $pieces = explode(">", $totalprofit);
                $totalprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $totalprofit_to  =0;

            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totalprofit);
                $totalprofit_from = $pieces[0];
                $totalprofit_to = $pieces[1];
            }
        }else{
            $totalprofit_from = 0;
            $totalprofit_to = 0;
        }



        $balance                 =  $this->input->post('balance');
        if(isset($balance)){
            if($balance==''){
                $balance_from= 0;
                $balance_to=0;
            }elseif(strpos($balance, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $balance);
                $balance_from = ($pieces[1]==1)? 2: $pieces[1];
                $balance_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $balance);
                $balance_from = $pieces[0];
                $balance_to = $pieces[1];
            }
        }else{
            $balance_from = 0;
            $balance_to = 0;
        }


        $equity   =  $this->input->post('equity');
        if(isset($equity)){
            if($equity==''){
                $equity_from= 0;
                $equity_to=0;
            }elseif(strpos($equity, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $equity);
                $equity_from = ($pieces[1]==1)? 2: $pieces[1];
                $equity_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $equity);
                $equity_from = $pieces[0];
                $equity_to = $pieces[1];
            }
        }else{
            $equity_from = 0;
            $equity_to = 0;
        }


        $currenttrades =  $this->input->post('currenttrades');
        if(isset($currenttrades)){
            if($currenttrades==''){
                $currenttrades_from= 0;
                $currenttrades_to=0;
            }elseif(strpos($currenttrades, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $currenttrades);
                $currenttrades_from = ($pieces[1]==0)? 1: $pieces[1];
                $currenttrades_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $currenttrades);
                $currenttrades_from = $pieces[0];
                $currenttrades_to = $pieces[1];
            }
        }else{
            $currenttrades_from = 0;
            $currenttrades_to = 0;
        }

        $totaltrades             =  $this->input->post('totaltrades');
        if(isset($totaltrades)){
            if($totaltrades==''){
                $totaltrades_from= 0;
                $totaltrades_to=0;
            }elseif(strpos($totaltrades, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $totaltrades);
                $totaltrades_from = ($pieces[1]==0)? 1: $pieces[1];
                $totaltrades_to     = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totaltrades);
                $totaltrades_from = $pieces[0];
                $totaltrades_to = $pieces[1];
            }
        }else{
            $totaltrades_from = 0;
            $totaltrades_to = 0;
        }



        $activeinvestor  =  $this->input->post('activeinvestor');
        if(isset($activeinvestor)){
            if($activeinvestor==''){
                $activeinvestor_from= 0;
                $activeinvestor_to=0;
            }elseif(strpos($activeinvestor, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $activeinvestor);
                $activeinvestor_from = ($pieces[1]==0)? 1: $pieces[1];
                $activeinvestor_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $activeinvestor);
                $activeinvestor_from = $pieces[0];
                $activeinvestor_to = $pieces[1];
            }
        }else{
            $activeinvestor_from = 0;
            $activeinvestor_to = 0;
        }


        $dailytotalbalance       =  $this->input->post('dailytotalbalance');
        if(isset($dailytotalbalance)){
            if($dailytotalbalance==''){
                $dailytotalbalance_from= 0;
                $dailytotalbalance_to=0;
            }elseif(strpos($dailytotalbalance, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $dailytotalbalance);
                $dailytotalbalance_from = ($pieces[1]==0)? 1: $pieces[1];
                $dailytotalbalance_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $dailytotalbalance);
                $dailytotalbalance_from = $pieces[0];
                $dailytotalbalance_to = $pieces[1];
            }
        }else{
            $dailytotalbalance_from = 0;
            $dailytotalbalance_to = 0;
        }



        $totaldailyequity        =  $this->input->post('totaldailyequity');
        if(isset($totaldailyequity)){
            if($totaldailyequity==''){
                $totaldailyequity_from= 0;
                $totaldailyequity_to=0;
            }elseif(strpos($totaldailyequity, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $totaldailyequity);
                $totaldailyequity_from = ($pieces[1]==0)? 1: $pieces[1];
                $totaldailyequity_to=   0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totaldailyequity);
                $totaldailyequity_from = $pieces[0];
                $totaldailyequity_to = $pieces[1];
            }
        }else{
            $totaldailyequity_from = 0;
            $totaldailyequity_to = 0;
        }

        $sinceregistered         =  $this->input->post('sinceregistered');
        if(isset($sinceregistered)){
            if($sinceregistered==''){
                $sinceregistered_from= 0;
                $sinceregistered_to=0;
            }else{
                $HasFilterToColumns=true;
                $sinceregistered_from = $sinceregistered;
                $sinceregistered_to =0;
            }
        }else{
            $totaldailyequity_from = 0;
            $totaldailyequity_to = 0;
        }
        switch ($order[0]['column']){
            case 0:
                $column_order='Account';
                break;
            case 1:
                $column_order='SimpleRating';
                break;
            case 9:
                $column_order='Balance';
                break;
            case 10:
                $column_order='Equity';
                break;
            case 11:
                $column_order='CurrentTrades';
                break;
            case 12:
                $column_order='TotalTrades';
                break;
            case 13:
                $column_order='ActiveInvestors';
                break;
            case 14:
                $column_order='DailyTotalBalance';
                break;
            case 15:
                $column_order='DailyTotalEquity';
                break;
            case 16:
                $column_order='SinceRegisteredDays';
                break;
            default:
                $column_order='Account';
        }

        $data['co']=$column_order;
        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);
        $account_info = array(
            'AccountFilter' =>$accountnumber_project ,
            /*Filter*/
            'ActiveInvestorsFrom' => $activeinvestor_from ,
            'ActiveInvestorsTo' => $activeinvestor_to,
//            'ActiveInvestorsFrom' => 0,
//            'ActiveInvestorsTo' => 0,
            'BalanceFrom' => $balance_from ,
            'BalanceTo' => $balance_to ,
//            'BalanceFrom' => 0 ,
//            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => $currenttrades_from ,
            'CurrentTradesTo' => $currenttrades_to ,
            'DailyBalFrom' => $dailytotalbalance_from ,
            'DailyBalTo' => $dailytotalbalance_to,
//            'DailyBalFrom' => 0,
//            'DailyBalTo' => 0,
            'DailyEquityFrom' => $totaldailyequity_from ,
            'DailyEquityTo' => $totaldailyequity_to ,
//            'DailyEquityFrom' => 0 ,
//            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => $dailyprofit_from,
            'DailyProfitTo' => $dailyprofit_to ,
//            'DailyProfitFrom' => 0 ,
//            'DailyProfitTo' => 0 ,
            'EquityFrom' =>$equity_from ,
            'EquityTo' => $equity_to ,
//            'EquityFrom' =>0 ,
//            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => $threemonthprofit_from ,
            'Month_3_ProfitTo'=> $threemonthprofit_to ,
//            'Month_3_ProfitFrom' => 0 ,
//            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => $sixmonthprofit_from,
            'Month_6_ProfitTo' => $sixmonthprofit_to ,
//            'Month_6_ProfitFrom' => 0 ,
//            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => $ninemonthprofit_from ,
            'Month_9_ProfitTo' => $ninemonthprofit_to ,
//            'Month_9_ProfitFrom' => 0 ,
//            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => $monthlyprofit_from ,
            'MonthlyProfitTo' => $monthlyprofit_to,
//            'MonthlyProfitFrom' => 0 ,
//            'MonthlyProfitTo' => 0,
            'SimpleRatingFrom' => $simpleratingfrom ,
            'SimpleRatingTo' => $simpleratingto,
//            'SimpleRatingFrom' =>0,
//            'SimpleRatingTo' =>0,
            'SinceRegisteredFrom' => $sinceregistered_from,
            'SinceRegisteredTo' => $sinceregistered_to ,
//            'SinceRegisteredFrom' => 0 ,
//            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => $totalprofit_from,
            'TotalProfitTo' => $totalprofit_to,
//            'TotalProfitFrom' => 0 ,
//            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => $totaltrades_from ,
            'TotalTradesTo' => $totaltrades_to ,
//            'TotalTradesFrom' => 0 ,
//            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' =>  $weeklyprofit_from,
            'WeeklyProfitTo' => $weeklyprofit_to ,
//            'WeeklyProfitFrom' => 0 ,
//            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => $HasFilterToColumns,
//            'Limit' => $length,
//            'Offset' => $start,
            'Limit' => 0,
            'Offset' => 0,
//            'OrderByAsc' => false,
            'OrderByAsc' => $order[0]['dir']=='desc'? false: true,
//            'OrderByColumnName' => 'Account'// $column_order
            'OrderByColumnName' => $column_order //

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        $request = '';
        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        $key=0;
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            $data['data'][$key]['account'] = '<a href="'. FXPP::loc_url('pamm/monitoring_user') .'/'.$object->AccountId.'">'. $object->AccountId .'('. $object->ProjectName .' )</a> ';
                            $data['data'][$key]['simple_rating'] = $object->SimpleRating;

                            $data['data'][$key]['daily_profit'] = sprintf("%01.2f",$object->DailyProfit)  .'%';
                            $data['data'][$key]['weekly_profit'] = sprintf("%01.2f",$object->WeeklyProfit ) .'%';
                            $data['data'][$key]['monthly_profit'] =  sprintf("%01.2f", $object->MonthlyProfit ) .'%';
                            $data['data'][$key]['3_month_profit'] = sprintf("%01.2f",  $object->Month_3_Profit  ).'%';
                            $data['data'][$key]['6_month_profit'] =  sprintf("%01.2f",  $object->Month_6_Profit  ) .'%';
                            $data['data'][$key]['9_month_profit'] =sprintf("%01.2f",$object->Month_9_Profit   )   .'%';
                            $data['data'][$key]['total_profit'] = sprintf("%01.2f", $object->TotalProfit )   .'%';


                            $data['data'][$key]['balance'] = sprintf("%01.2f", $object->Balance) ;
                            $data['data'][$key]['equity'] = sprintf("%01.2f", $object->Equity ) ;
                            $data['data'][$key]['current_trades'] = $object->CurrentTrades ;
                            $data['data'][$key]['total_trades'] =  $object->TotalTrades ;
                            $data['data'][$key]['active_trades'] =  $object->ActiveInvestors ;
                            $data['data'][$key]['daily_total_balance'] =  sprintf("%01.2f", $object->DailyTotalBalance );
                            $data['data'][$key]['daily_total_equity'] = sprintf("%01.2f", $object->DailyTotalEquity);
                            $data['data'][$key]['sinceregistereddays'] = $object->SinceRegisteredDays.' days';
                            $key=$key+1;
                        }
                    }
                    break;
                default:
            }
        }
        $data['srFrom'] =  $simpleratingfrom ;
        $data['srTo'] =  $simpleratingto ;
        $data['hasfilter'] = $HasFilterToColumns;
        $data['draw'] = $draw;
        $data['recordsTotal'] = $key;
        $data['recordsFiltered'] = $key;
        echo json_encode($data);
        unset($data);
    }

    public function get_monitoring_dt(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $draw = (int) $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order =  $this->input->post('order');

        $accountnumber_project   =  $this->input->post('accountnumber_project');
        $HasFilterToColumns=false;
        $simplerating            =  $this->input->post('simplerating');
        if(isset($simplerating)){
            if($simplerating==''){
                $simpleratingfrom= 0;
                $simpleratingto=0;
            }elseif(strpos($simplerating, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $simplerating);
                   $simpleratingfrom = ($pieces[1]==0)? 1: $pieces[1];
                  $simpleratingto = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $simplerating);
                $simpleratingfrom = $pieces[0];
                $simpleratingto = $pieces[1];
            }
        }else{
            $simpleratingfrom= 0;
            $simpleratingto=0;
        }


        $dailyprofit             =  $this->input->post('dailyprofit');
        if(isset($dailyprofit)){
            if($dailyprofit==''){
                $dailyprofit_from= 0;
                $dailyprofit_to=0;
            }elseif(strpos($dailyprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $dailyprofit);
                  $dailyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $dailyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $dailyprofit);
                $dailyprofit_from = $pieces[0];
                $dailyprofit_to = $pieces[1];
            }
        }else{
            $dailyprofit_from= 0;
            $dailyprofit_to=0;
        }


        $weeklyprofit            =  $this->input->post('weeklyprofit');

        if(isset($weeklyprofit)){
            if($weeklyprofit==''){
                $weeklyprofit_from= 0;
                $weeklyprofit_to=0;
            }elseif(strpos($weeklyprofit, '>') !== false){
                $HasFilterToColumns=true;

                $pieces = explode(">", $weeklyprofit);
                $weeklyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $weeklyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $weeklyprofit);
                $weeklyprofit_from = $pieces[0];
                $weeklyprofit_to = $pieces[1];
            }
        }else{
            $weeklyprofit_from= 0;
            $weeklyprofit_to=0;
        }

        $monthlyprofit           =  $this->input->post('monthlyprofit');
        if(isset($monthlyprofit)){
            if($monthlyprofit==''){
                $monthlyprofit_from= 0;
                $monthlyprofit_to=0;
            }elseif(strpos($monthlyprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $monthlyprofit);
                $monthlyprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $monthlyprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $monthlyprofit);
                $monthlyprofit_from = $pieces[0];
                $monthlyprofit_to = $pieces[1];
            }
        }else{
            $monthlyprofit_from= 0;
            $monthlyprofit_to=0;
        }

        $threemonthprofit        =  $this->input->post('threemonthprofit');
        if(isset($threemonthprofit)){
            if($threemonthprofit==''){
                $threemonthprofit_from= 0;
                $threemonthprofit_to=0;
            }elseif(strpos($threemonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $threemonthprofit);
                $threemonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $threemonthprofit_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $threemonthprofit);
                $threemonthprofit_from = $pieces[0];
                $threemonthprofit_to = $pieces[1];
            }
        }else{
            $threemonthprofit_from= 0;
            $threemonthprofit_to=0;
        }


        $sixmonthprofit          =  $this->input->post('sixmonthprofit');
        if(isset($sixmonthprofit)){
            if($sixmonthprofit==''){
                $sixmonthprofit_from= 0;
                $sixmonthprofit_to=0;
            }elseif(strpos($sixmonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $sixmonthprofit);
                $sixmonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $sixmonthprofit_to =  0;
//                $sixmonthprofit_from = $pieces[0];
//                  $sixmonthprofit_to = $pieces[1];
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $sixmonthprofit);
                $sixmonthprofit_from = $pieces[0];
                $sixmonthprofit_to = $pieces[1];
            }
        }else{
            $sixmonthprofit_from = 0;
            $sixmonthprofit_to = 0;
        }


        $ninemonthprofit         =  $this->input->post('ninemonthprofit');
        if(isset($ninemonthprofit)){
            if($ninemonthprofit==''){
                $ninemonthprofit_from= 0;
                $ninemonthprofit_to=0;
            }elseif(strpos($ninemonthprofit, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $ninemonthprofit);
                $ninemonthprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                  $ninemonthprofit_to = 0;
//                $ninemonthprofit_from = $pieces[0];
//                  $ninemonthprofit_to = $pieces[1];
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $ninemonthprofit);
                $ninemonthprofit_from = $pieces[0];
                $ninemonthprofit_to = $pieces[1];
            }
        }else{
            $ninemonthprofit_from = 0;
            $ninemonthprofit_to = 0;
        }

        $totalprofit             =  $this->input->post('totalprofit');
        if(isset($totalprofit)){
            if($totalprofit==''){
                $totalprofit_from= 0;
                $totalprofit_to=0;
            }elseif(strpos($totalprofit, '>') !== false){
                $HasFilterToColumns=true;

                $pieces = explode(">", $totalprofit);
                $totalprofit_from = ($pieces[1]==0)? 1: $pieces[1];
                $totalprofit_to  =0;

            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totalprofit);
                $totalprofit_from = $pieces[0];
                $totalprofit_to = $pieces[1];
            }
        }else{
            $totalprofit_from = 0;
            $totalprofit_to = 0;
        }



        $balance                 =  $this->input->post('balance');
        if(isset($balance)){
            if($balance==''){
                $balance_from= 0;
                $balance_to=0;
            }elseif(strpos($balance, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $balance);
                $balance_from = ($pieces[1]==1)? 2: $pieces[1];
                  $balance_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $balance);
                $balance_from = $pieces[0];
                $balance_to = $pieces[1];
            }
        }else{
            $balance_from = 0;
            $balance_to = 0;
        }


        $equity   =  $this->input->post('equity');
        if(isset($equity)){
            if($equity==''){
                $equity_from= 0;
                $equity_to=0;
            }elseif(strpos($equity, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $equity);
                $equity_from = ($pieces[1]==1)? 2: $pieces[1];
                  $equity_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $equity);
                $equity_from = $pieces[0];
                $equity_to = $pieces[1];
            }
        }else{
            $equity_from = 0;
            $equity_to = 0;
        }


        $currenttrades =  $this->input->post('currenttrades');
        if(isset($currenttrades)){
            if($currenttrades==''){
                $currenttrades_from= 0;
                $currenttrades_to=0;
            }elseif(strpos($currenttrades, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $currenttrades);
                $currenttrades_from = ($pieces[1]==0)? 1: $pieces[1];
                $currenttrades_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $currenttrades);
                $currenttrades_from = $pieces[0];
                $currenttrades_to = $pieces[1];
            }
        }else{
            $currenttrades_from = 0;
            $currenttrades_to = 0;
        }

        $totaltrades             =  $this->input->post('totaltrades');
        if(isset($totaltrades)){
            if($totaltrades==''){
                $totaltrades_from= 0;
                $totaltrades_to=0;
            }elseif(strpos($totaltrades, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $totaltrades);
                $totaltrades_from = ($pieces[1]==0)? 1: $pieces[1];
                $totaltrades_to     = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totaltrades);
                $totaltrades_from = $pieces[0];
                $totaltrades_to = $pieces[1];
            }
        }else{
            $totaltrades_from = 0;
            $totaltrades_to = 0;
        }



        $activeinvestor  =  $this->input->post('activeinvestor');
        if(isset($activeinvestor)){
            if($activeinvestor==''){
                $activeinvestor_from= 0;
                $activeinvestor_to=0;
            }elseif(strpos($activeinvestor, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $activeinvestor);
                $activeinvestor_from = ($pieces[1]==0)? 1: $pieces[1];
                  $activeinvestor_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $activeinvestor);
                $activeinvestor_from = $pieces[0];
                $activeinvestor_to = $pieces[1];
            }
        }else{
            $activeinvestor_from = 0;
            $activeinvestor_to = 0;
        }


        $dailytotalbalance       =  $this->input->post('dailytotalbalance');
        if(isset($dailytotalbalance)){
            if($dailytotalbalance==''){
                $dailytotalbalance_from= 0;
                $dailytotalbalance_to=0;
            }elseif(strpos($dailytotalbalance, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $dailytotalbalance);
                $dailytotalbalance_from = ($pieces[1]==0)? 1: $pieces[1];
                  $dailytotalbalance_to = 0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $dailytotalbalance);
                $dailytotalbalance_from = $pieces[0];
                $dailytotalbalance_to = $pieces[1];
            }
        }else{
            $dailytotalbalance_from = 0;
            $dailytotalbalance_to = 0;
        }



        $totaldailyequity        =  $this->input->post('totaldailyequity');
        if(isset($totaldailyequity)){
            if($totaldailyequity==''){
                $totaldailyequity_from= 0;
                $totaldailyequity_to=0;
            }elseif(strpos($totaldailyequity, '>') !== false){
                $HasFilterToColumns=true;
                $pieces = explode(">", $totaldailyequity);
                $totaldailyequity_from = ($pieces[1]==0)? 1: $pieces[1];
                $totaldailyequity_to=   0;
            }else{
                $HasFilterToColumns=true;
                $pieces = explode("-", $totaldailyequity);
                $totaldailyequity_from = $pieces[0];
                $totaldailyequity_to = $pieces[1];
            }
        }else{
            $totaldailyequity_from = 0;
            $totaldailyequity_to = 0;
        }

        $sinceregistered         =  $this->input->post('sinceregistered');
        if(isset($sinceregistered)){
            if($sinceregistered==''){
                $sinceregistered_from= 0;
                $sinceregistered_to=0;
            }else{
                $HasFilterToColumns=true;
                $sinceregistered_from = $sinceregistered;
                $sinceregistered_to =0;
            }
        }else{
            $totaldailyequity_from = 0;
            $totaldailyequity_to = 0;
        }
        switch ($order[0]['column']){
            case 0:
                $column_order='Account';
                break;
            case 1:
                $column_order='SimpleRating';
                break;
            case 9:
                $column_order='Balance';
                break;
            case 10:
                $column_order='Equity';
                break;
            case 11:
                $column_order='CurrentTrades';
                break;
            case 12:
                $column_order='TotalTrades';
                break;
            case 13:
                $column_order='ActiveInvestors';
                break;
            case 14:
                $column_order='DailyTotalBalance';
                break;
            case 15:
                $column_order='DailyTotalEquity';
                break;
            case 16:
                $column_order='SinceRegisteredDays';
                break;
            default:
                $column_order='Account';
        }

        $data['co']=$column_order;
        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);
        $account_info = array(
            'AccountFilter' =>$accountnumber_project ,
            /*Filter*/
            'ActiveInvestorsFrom' => $activeinvestor_from ,
            'ActiveInvestorsTo' => $activeinvestor_to,
//            'ActiveInvestorsFrom' => 0,
//            'ActiveInvestorsTo' => 0,
            'BalanceFrom' => $balance_from ,
            'BalanceTo' => $balance_to ,
//            'BalanceFrom' => 0 ,
//            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => $currenttrades_from ,
            'CurrentTradesTo' => $currenttrades_to ,
            'DailyBalFrom' => $dailytotalbalance_from ,
            'DailyBalTo' => $dailytotalbalance_to,
//            'DailyBalFrom' => 0,
//            'DailyBalTo' => 0,
            'DailyEquityFrom' => $totaldailyequity_from ,
            'DailyEquityTo' => $totaldailyequity_to ,
//            'DailyEquityFrom' => 0 ,
//            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => $dailyprofit_from,
            'DailyProfitTo' => $dailyprofit_to ,
//            'DailyProfitFrom' => 0 ,
//            'DailyProfitTo' => 0 ,
            'EquityFrom' =>$equity_from ,
            'EquityTo' => $equity_to ,
//            'EquityFrom' =>0 ,
//            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => $threemonthprofit_from ,
            'Month_3_ProfitTo'=> $threemonthprofit_to ,
//            'Month_3_ProfitFrom' => 0 ,
//            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => $sixmonthprofit_from,
            'Month_6_ProfitTo' => $sixmonthprofit_to ,
//            'Month_6_ProfitFrom' => 0 ,
//            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => $ninemonthprofit_from ,
            'Month_9_ProfitTo' => $ninemonthprofit_to ,
//            'Month_9_ProfitFrom' => 0 ,
//            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => $monthlyprofit_from ,
            'MonthlyProfitTo' => $monthlyprofit_to,
//            'MonthlyProfitFrom' => 0 ,
//            'MonthlyProfitTo' => 0,
            'SimpleRatingFrom' => $simpleratingfrom ,
            'SimpleRatingTo' => $simpleratingto,
//            'SimpleRatingFrom' =>0,
//            'SimpleRatingTo' =>0,
            'SinceRegisteredFrom' => $sinceregistered_from,
            'SinceRegisteredTo' => $sinceregistered_to ,
//            'SinceRegisteredFrom' => 0 ,
//            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => $totalprofit_from,
            'TotalProfitTo' => $totalprofit_to,
//            'TotalProfitFrom' => 0 ,
//            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => $totaltrades_from ,
            'TotalTradesTo' => $totaltrades_to ,
//            'TotalTradesFrom' => 0 ,
//            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' =>  $weeklyprofit_from,
            'WeeklyProfitTo' => $weeklyprofit_to ,
//            'WeeklyProfitFrom' => 0 ,
//            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => $HasFilterToColumns,
//            'Limit' => $length,
//            'Offset' => $start,
            'Limit' => 0,
            'Offset' => 0,
//            'OrderByAsc' => false,
            'OrderByAsc' => $order[0]['dir']=='desc'? false: true,
//            'OrderByColumnName' => 'Account'// $column_order
            'OrderByColumnName' => $column_order //

        );
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        $request = '';
        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        $key=0;
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            $data['data'][$key]['account'] = '<a href="'. FXPP::loc_url('pamm/monitoring_user') .'/'.$object->AccountId.'">'. $object->AccountId .'('. $object->ProjectName .' )</a> ';
                            $data['data'][$key]['simple_rating'] = $object->SimpleRating;

                            $data['data'][$key]['daily_profit'] = sprintf("%01.2f",$object->DailyProfit)  .'%';
                            $data['data'][$key]['weekly_profit'] = sprintf("%01.2f",$object->WeeklyProfit ) .'%';
                            $data['data'][$key]['monthly_profit'] =  sprintf("%01.2f", $object->MonthlyProfit ) .'%';
                            $data['data'][$key]['3_month_profit'] = sprintf("%01.2f",  $object->Month_3_Profit  ).'%';
                            $data['data'][$key]['6_month_profit'] =  sprintf("%01.2f",  $object->Month_6_Profit  ) .'%';
                            $data['data'][$key]['9_month_profit'] =sprintf("%01.2f",$object->Month_9_Profit   )   .'%';
                            $data['data'][$key]['total_profit'] = sprintf("%01.2f", $object->TotalProfit )   .'%';


                            $data['data'][$key]['balance'] = sprintf("%01.2f", $object->Balance) ;
                            $data['data'][$key]['equity'] = sprintf("%01.2f", $object->Equity ) ;
                            $data['data'][$key]['current_trades'] = $object->CurrentTrades ;
                            $data['data'][$key]['total_trades'] =  $object->TotalTrades ;
                            $data['data'][$key]['active_trades'] =  $object->ActiveInvestors ;
                            $data['data'][$key]['daily_total_balance'] =  sprintf("%01.2f", $object->DailyTotalBalance );
                            $data['data'][$key]['daily_total_equity'] = sprintf("%01.2f", $object->DailyTotalEquity);
                            $data['data'][$key]['sinceregistereddays'] = $object->SinceRegisteredDays.' days';
                            $key=$key+1;
                        }
                    }
                    break;
                default:
            }
        }
        $data['srTo'] = $simpleratingto ;
        $data['srFrom'] =   $simpleratingfrom ;
        $data['hasfilter'] = $HasFilterToColumns;
        $data['draw'] = $draw;
        $data['recordsTotal'] = $key;
        $data['recordsFiltered'] = $key;
        echo json_encode($data);
        unset($data);
    }

    public function get_livefeed_old(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        $this->lang->load('pamm');
        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);

        $account_info = array(
            'AccountFilter' => '' ,
            /*Filter*/
            'ActiveInvestorsFrom' => 0 ,
            'ActiveInvestorsTo' => 0 ,
            'BalanceFrom' => 0 ,
            'BalanceTo' => 0 ,
            'CurrentTradesFrom' => 0 ,
            'CurrentTradesTo' => 0 ,
            'DailyBalFrom' => 0 ,
            'DailyBalTo' => 0 ,
            'DailyEquityFrom' => 0 ,
            'DailyEquityTo' => 0 ,
            'DailyProfitFrom' => 0 ,
            'DailyProfitTo' => 0 ,
            'EquityFrom' => 0 ,
            'EquityTo' => 0 ,
            'Month_3_ProfitFrom' => 0 ,
            'Month_3_ProfitTo' => 0 ,
            'Month_6_ProfitFrom' => 0 ,
            'Month_6_ProfitTo' => 0 ,
            'Month_9_ProfitFrom' => 0 ,
            'Month_9_ProfitTo' => 0 ,
            'MonthlyProfitFrom' => 0 ,
            'MonthlyProfitTo' => 0 ,
            'SimpleRatingFrom' => 0 ,
            'SimpleRatingTo' => 0 ,
            'SinceRegisteredFrom' => 0 ,
            'SinceRegisteredTo' => 0 ,
            'TotalProfitFrom' => 0 ,
            'TotalProfitTo' => 0 ,
            'TotalTradesFrom' => 0 ,
            'TotalTradesTo' => 0 ,
            'WeeklyProfitFrom' => 0 ,
            'WeeklyProfitTo' => 0 ,
            /*Filter*/
            'HasFilterToColumns' => false,
            'Limit' => 0,
            'Offset' => 0,
            'OrderByAsc' => false,
            'OrderByColumnName' => 'Account'

        );
        $accountnumbers= array();
        $PammService->open_GetPammTradersMonitoringDataCustom($account_info);
        if($PammService->result){
            $MonitroingDataList =  (array) $PammService->result->MonitroingDataList;
            $Message = $PammService->result->ResponseMessage;
            switch($Message){
                case 'RET_OK':
                    if($MonitroingDataList){
                        foreach ($MonitroingDataList['MonitoringData'] as $object){
                            array_push($accountnumbers,array('account_number'=>$object->AccountId,'project_name'=>$object->ProjectName));
                        }
                    }
                    break;
                default:
            }
        }
        $count = 0; /* counter for closed and opened trades*/
        $accounts = ''; /* counter for closed and opened trades*/
        $realcount = 0;
        foreach ($accountnumbers as $trkey => $trval){
            /*get Current trades*/
            $webservice_config = array(
                'server' => 'live_new'
            );
            $account_info = array(
                'iLogin' => $trval['account_number']
            );

            $WebServiceClosedTrades = new WebService($webservice_config);
            $WebServiceClosedTrades->open_GetAccountActiveTrades($account_info);
            switch($WebServiceClosedTrades->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebServiceClosedTrades->get_result('TradeDataList');
                    foreach ( $tradatalist['TradeData'] as $object){
                        $livefeed_trade[$count]= array(
                            'ClosePrice'=>$object->ClosePrice,
                            'CloseTime'=>$object->CloseTime,
                            'Comment'=>$object->Comment,
                            'Commission'=>$object->Commission,
                            'ConversionRate1'=>$object->ConversionRate1,
                            'ConversionRate2'=>$object->ConversionRate2,
                            'Digits'=>$object->Digits,
                            'Login'=>$object->Login,
                            'MarginRate'=>$object->MarginRate,
                            'OpenPrice'=>$object->OpenPrice,
                            'OpenTIme'=>$object->OpenTIme,
                            'OrderTicket'=>$object->OrderTicket,
                            'Profit'=>$object->Profit,
                            'Reason'=>$object->Reason,
                            'StopLoss'=>$object->StopLoss,
                            'Symbol'=>$object->Symbol,
                            'TakeProfit'=>$object->TakeProfit,
                            'TakeProfit'=>$object->TradeType,
                            'Volume'=>$object->Volume,
                            'ProjectName'=>$trval['project_name'],
                            'type'=>'closed' /*add identifier of what kind of trader trade option */
                        );
                        $count=$count+1;
                        $realcount=$realcount+1;
                        $accounts=$object->Login.',';
                    }

                    break;
                default:
                    $data['data']['error']=true;
            }
            /*get Current trades*/
            /*get Pending Orders*/
            $account_info = array(
                'iLogin' => $trval['account_number']
            );
            $WebServicePendingTrades = new WebService($webservice_config);
            $WebServicePendingTrades->GetAccounPendingOrders($account_info);
            switch($WebServicePendingTrades->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebServicePendingTrades->get_result('TradeDataList');
                    foreach ( $tradatalist['TradeData'] as $object){
                        $livefeed_trade[$count]= array(
                            'ClosePrice'=>$object->ClosePrice,
                            'CloseTime'=>$object->CloseTime,
                            'Commission'=>$object->Commission,
                            'ConversionRate1'=>$object->ConversionRate1,
                            'ConversionRate2'=>$object->ConversionRate2,
                            'Digits'=>$object->Digits,
                            'Login'=>$object->Login,
                            'MarginRate'=>$object->MarginRate,
                            'OpenPrice'=>$object->OpenPrice,
                            'OpenTIme'=>$object->OpenTIme,
                            'OrderTicket'=>$object->OrderTicket,
                            'Profit'=>$object->Profit,
                            'Reason'=>$object->Reason,
                            'Symbol'=>$object->Symbol,
                            'TakeProfit'=>$object->TakeProfit,
                            'TradeType'=>$object->TradeType,
                            'Volume'=>$object->Volume,
                            'ProjectName'=>$trval['project_name'],
                            'type'=>'pending' /*add identifier of what kind of trader trade option */
                        );
                        $count=$count+1;
                        $realcount=$realcount+1;
                        $accounts=$object->Login.',';
                    }
                    break;
                default:
            }
            /*get Pending Orders*/
        }
        if(count($livefeed_trade)>=10){
            $random_key_arr = array_rand($livefeed_trade,10); // select 10 random key from array to show in live feed
            $show_trader=array();
            for($x = 0; $x < 10; $x++){
                array_push($show_trader,$livefeed_trade[$random_key_arr[$x]]); // populate new array of 10 data.
            }

        }else{
            $show_trader = $livefeed_trade;
        }

        foreach ( $show_trader as $key=>$value){
            switch($value['type']){
                //sample content "fxsystem (5082655) closed SELL EURGBP position of 1.02 lot(s) at 0.78878 with profit 76 pips"
                /*$value['ProjectName'].*/
                case 'pending':
                    $tradesandpamm = array(
                        'trader_info'=> $value['ProjectName'].' ( '.$value['Login'].' ) opened ' .$value['TradeType'].' '.$value['Symbol'] .' volume '. $value['Volume']. ' open price '.$value['OpenPrice'].' closed price '.$value['ClosePrice'].'  with profit '.$value['Profit'].'',
                        'flag'=> 'flag.png',
                        'trader_timestamp'=> $value['OpenTIme'],
                        'account_monitoring'=> '?trader='.$value['Login'],
                        'widget'=>'my_widgets',
                        'trader_account'=> $value['Login'],

                    );
                    break;
                case 'closed':
                    $tradesandpamm = array(
                        'trader_info'=> $value['ProjectName']. ' ( '.$value['Login'].' ) closed ' .$value['TradeType'].' '.$value['Symbol'] .' volume '. $value['Volume']. ' open price '.$value['OpenPrice'].' closed price '.$value['ClosePrice'].'  with profit '.$value['Profit'].'',
                        'flag'=> 'flag.png',
                        'trader_timestamp'=> $value['OpenTIme'],
                        'account_monitoring'=> '?trader='.$value['Login'],
                        'widget'=>'my_widgets',
                        'trader_account'=> $value['Login'],
                    );

                    break;
                default:
                    $tradesandpamm = array(
                        'trader_info'=>  $value['ProjectName'].' ( '.$value['Login'].' ) opened ' .$value['TradeType'].' '.$value['Symbol'] .' volume '. $value['Volume']. ' open price '.$value['OpenPrice'].' closed price '.$value['ClosePrice'].'  with profit '.$value['Profit'].'',
                        'flag'=> 'flag.png',
                        'trader_timestamp'=> $value['OpenTIme'],
                        'account_monitoring'=> '?trader='.$value['Login'],
                        'widget'=>'my_widgets',
                        'trader_account'=> $value['Login'],
                    );
            }

            $data['livefeedwidget'] .= $this->load->view('pamm/live-feed_widget', $tradesandpamm , TRUE);
        }
        echo json_encode($data);
        unset($data);
    }

    public function make_newinvestment_request(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

                  $data['mycondition'] = $this->input->post('mycondition',true);
        $data['trader_account_number'] = $this->input->post('trader_account_number',true);
               $data['investment_sum'] = $this->input->post('investment_sum',true);
            $data['affiliate_account'] = '';

        if($this->session->userdata('login_type') == 1){
            /*partner account*/
        }else{
            /*client account*/
            /*get clients account number*/
            $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='account_number,mt_currency_base');

            /*get users affiliate referral code process*/
            $data['users_affiliate_code'] = $this->general_model->showssingle($table='users_affiliate_code',$id='users_id', $field=$_SESSION['user_id'],$select='referral_affiliate_code');
            /*get referral code affiliates user id*/
            if ($data['users_affiliate_code']['referral_affiliate_code']==null OR $data['users_affiliate_code']['referral_affiliate_code']==''){

            }else{
                $data['users_affiliate_codes2'] = $this->general_model->showssingle($table='users_affiliate_code',$id='affiliate_code', $field= $data['users_affiliate_code']['referral_affiliate_code'],$select='user_id');
                if($data['users_affiliate_codes2']){
                    /*referrer is client account*/
                    $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field= $data['users_affiliate_codes2']['user_id'],$select='account_number');
                    if($data['mtas2']){
                        $data['affiliate_account']=$data['mtas2']['account_number'];
                    }

                }else{
                    /*check if referrer is partner account*/
                    $data['partnership_affiliate_code'] = $this->general_model->showssingle($table='partnership_affiliate_code',$id='affiliate_code', $field= $data['users_affiliate_codes2']['user_id'] ,$select='partner_id');

                    if($data['partnership_affiliate_code']){
                        $data['partnership'] = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=  $data['partnership_affiliate_code']['partner_id'] ,$select='reference_num');
                        if($data['partnership']){
                            $data['affiliate_account']= $data['partnership']['reference_num'];
                        }
                    }
                }
            }

            /*get account number of affiliate via user id*/

            $webservice_config = array(
                'server' => 'pamm'
            );
            $PammService = new WebService($webservice_config);
             $account_info = array(
                   'AffiliateAccount' => ($data['affiliate_account']=="")?$data['trader_account_number']:$data['affiliate_account'] ,
//                   'AffiliateAccount' => $data['trader_account_number'],
                 'ConditionSetNumber' => $data['mycondition'],
                           'Currency' => $data['mtas']['mt_currency_base'],
                             'InvSum' => $data['investment_sum'] ,
             'InverstorAccountNumber' => $data['mtas']['account_number'],
                     'InvestorBroker' => 0,
                        'OwnerBroker' => 0,
                            'OwnerId' => $data['trader_account_number'],
             );
            $data['accountinfo']=$account_info;
            $PammService->open_NewInvestmentRequest($account_info);
            if($PammService->result){
                $PammInfo = (array)  $PammService->result;
//                $PammInfo['NewInvestmentData'];
                switch($PammInfo['Message']){
                       case 'RET_FOR_PT_APPROVAL':
                           $NewInvestmentData = (array) $PammInfo['NewInvestmentData'];
                           $data['response']=array(
                               'AccountBrokerId' => $NewInvestmentData['AccountBrokerId'],
                                     'AccountId' => $NewInvestmentData['AccountId'],
                              'InvestmentAmount' => $NewInvestmentData['InvestmentAmount'],
                                  'InvestmentId' => $NewInvestmentData['InvestmentId'],
                                 'OwnerBrokerId' => $NewInvestmentData['OwnerBrokerId'],
                                       'OwnerId' => $NewInvestmentData['OwnerId'],
                                        'Profit' => $NewInvestmentData['Profit'],
                                        'Return' => $NewInvestmentData['Return'],
                                         'Share' => $NewInvestmentData['Share'],
                                        'Status' => $NewInvestmentData['Status'],
                                          'Time' => $NewInvestmentData['Time'],
                                       'Message' => $PammInfo['Message'],
                                   'PageMessage' => 'Request is successful , Investment Id = '. $NewInvestmentData['InvestmentId'] . ' is for approval',
                                          'show' => '1',
                                      'response' => 'Request is successful , Investment Id = '. $NewInvestmentData['InvestmentId'] . ' is for approval'
                           );
                           $config = array('server' => 'live_new');
                           $WebService = new WebService($config);
                           $WebService->request_live_account_balance( $data['mtas']['account_number']);
                           if ($WebService->request_status === 'RET_OK') {
                               /*Update local database balance*/
                               $balance = $WebService->get_result('Balance');
                               $this->account_model->updateAccountBalance($data['mtas']['account_number'], $balance);
                           }
                        break;
                        case 'RET_NOT_ENOUGH_BALANCE':
                            $data['response']=array(
                              'response'=>'Account balance is not enough.',
                              'Message'=> $PammInfo['Message'],
                              'PageMessage' => 'Request not enough balance',
                                'show' => '2'
                            );
                        break;
                        default:
                        $data['response']=array(
                            'response' => 'API error.',
                             'Message' => $PammInfo['Message'],
                         'PageMessage' => $PammInfo['Message'],
                            'show' => '2'
                        );
                }
            }

        }


        if(IPLOC::Office_and_Vpn()){
            echo json_encode($data);
        }else{
//            unset( $data['mtas'] );
//            unset( $data['users_affiliate_code'] );
//            unset( $data['user_affiliate_codes2'] );
//            unset( $data['mtas2'] );
//            unset( $data['partnership_affiliate_code'] );
//            unset( $data['partnership'] );
            echo json_encode($data);
        }
        unset($data);
    }

    function IsNullOrEmptyString($args){
        return (!isset($args) || trim($args)==='');
    }

    public function implement_newinvestmentrequest(){
        if(!IPLoc::Office_and_Vpn_Trading()) {
            redirect('signout');
        }

        $webservice_config = array(
            'server' => 'pamm'
        );
        $PammService = new WebService($webservice_config);

        $account_info = array(
            'AffiliateAccount' => 185268,
            'ConditionSetNumber' => 2,
            'Currency' => 'USD',
            'InvSum' => 3,
            'InverstorAccountNumber' => 189200,
            'InvestorBroker' => 0,
            'OwnerBroker' => 0,
            'OwnerId' => 185268,
        );
        $PammService->open_NewInvestmentRequest($account_info);
        if($PammService->result){
            $PammInfo = (array)  $PammService->result;
            var_dump( (array) $PammInfo['NewInvestmentData']);

           $NewInvestmentData = (array) $PammInfo['NewInvestmentData'];
            echo 'AccountBrokerId '.$NewInvestmentData['AccountBrokerId'];
            echo $PammInfo['Message'];
        }

//        object(stdClass)#39 (11) { ["AccountBrokerId"]=> int(0) ["AccountId"]=> int(0) ["InvestmentAmount"]=> float(0) ["InvestmentId"]=> int(0) ["OwnerBrokerId"]=> int(0) ["OwnerId"]=> int(0) ["Profit"]=> float(0) ["Return"]=> float(0) ["Share"]=> float(0) ["Status"]=> int(0) ["Time"]=> string(19) "0001-01-01T00:00:00" }

    }

    public function get_livefeed_dt_test(){
        $this->lang->load('pamm');
        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);

        $accountnumbers= array();
        $PammService->open_GetLiveFeeds();
        if($PammService->result){
            $LiveFeedData =  (array) $PammService->result->LiveFeedData;
//            var_dump($LiveFeedData);
            if($LiveFeedData){
                foreach ($LiveFeedData as $object){
                    preg_match('#\((.*?)\)#', $object->Feed, $match);
                    array_push($accountnumbers,array('feed'=>$object->Feed,'timestamp'=>$object->TimeStamp,'account_number' =>$match[1]) );
                }
            }

        }
var_dump($accountnumbers);
    }

    public function get_livefeed(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->lang->load('pamm');
        $webservice_config2 = array(
            'server' => 'pamm_livefeeds'
        );
        $PammService = new WebService($webservice_config2);

        $livefeed_trade= array();
        $PammService->open_GetLiveFeeds();
        if($PammService->result){
            $LiveFeedData =  (array) $PammService->result->LiveFeedData;
            //            var_dump($LiveFeedData);
            if($LiveFeedData){
                foreach ($LiveFeedData as $object){
                    preg_match('#\((.*?)\)#', $object->Feed, $match);
                    array_push($livefeed_trade,array('feed'=>$object->Feed,'timestamp'=>$object->TimeStamp,'account_number' =>$match[1]) );
                }
            }

        }
//        var_dump($livefeed_trade);
        $count = 0; /* counter for closed and opened trades*/
        $accounts = ''; /* counter for closed and opened trades*/
        $realcount = 0;

        if(count($livefeed_trade)>=10){
            $random_key_arr = array_rand($livefeed_trade,10); // select 10 random key from array to show in live feed
            $show_trader=array();
            for($x = 0; $x < 10; $x++){
                array_push($show_trader,$livefeed_trade[$random_key_arr[$x]]); // populate new array of 10 data.
            }

        }else{
            $show_trader = $livefeed_trade;
        }

        $data['livefeedwidget']='';
        foreach ( $show_trader as $key=>$value){

            $tradesandpamm = array(
                'trader_info'=> $value['feed'],
                'flag'=> 'flag.png',
                'trader_timestamp'=> $value['timestamp'],
                'account_monitoring'=> '?trader='.$value['account_number'],
                'widget'=>'my_widgets',
                'trader_account'=> $value['account_number'],

            );

            $data['livefeedwidget'] .= $this->load->view('pamm/live-feed_widget', $tradesandpamm , TRUE);
        }
        echo json_encode($data);
        unset($data);
    }
    public function removeagentaccounts(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $gafr = $this->t_m->getnotremovedagents();
        //        var_dump($gafr);
        foreach ( $gafr as $key => $value) {
            echo $value['account_number'].'<br/>';
            $getAccountAgent = FXPP::GetAccountAgent($value['account_number']);
            if($getAccountAgent){
                $webservice_config = array('server' => 'live_new');
                $WebServiceRemove = new WebService($webservice_config);
                $WebServiceRemove->RemoveAgentOfAccount($value['account_number']);
                if ($WebServiceRemove->request_status === 'RET_OK') {
                    $removeData = array(
                        'AccountNumber' => $value['account_number'],
                        'AgentAccountNumber' => $getAccountAgent,
                        'DateRemoved' => FXPP::getCurrentDateTime()
                    );
                    $this->general_model->insertmy($table = "removed_agents",$removeData);
                    $mydata['removeagent'] = array(
                        'status'=>1
                    );
                    $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'], $mydata['removeagent']);

                    $getAccountAgent2 = FXPP::GetAccountAgent($value['account_number']);

                    $mydata['removeagent2'] = array(
                        'removed_agent'=>$getAccountAgent2
                    );
                    $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'], $mydata['removeagent2']);

                    echo 1;
                }else{
                    $mydata['removeagent'] = array(
                        'removed_agent'=>2
                    );
                    $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'], $mydata['removeagent']);
                    echo 2;
                }
            }else{
                $mydata['removeagent'] = array(
                    'status'=>3
                );
                $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'], $mydata['removeagent']);
                echo 3;
            }
        }

        $data='OK';
        echo json_encode($data);
        unset($data);
        exit();

    }

    public function gettotal_commission(){
        die();
        if(!$this->input->is_ajax_request()){die('Not authorized!');}


        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $gafr = $this->t_m->getagents();
        foreach ( $gafr as $key => $value) {
            echo $value['account_number'].'<br/>';

            $webservice_config = array('server' => 'live_new');
            $WS_GT = new WebService($webservice_config);
            $arrayName = array(
                'iAgent' =>$value['agent'],
                'iAccount' => $value['account_number'],
                'from' => $value['api_registration'],
                'to' => '2017-06-02T01:00:00',
            );
            $WS_GT->open_GetAgentTotalCommissionFromAccount($arrayName);
            if ($WS_GT->request_status === 'RET_OK') {

                 $totalamount = $WS_GT->get_result('TotalAmount');
                $mydata['save'] = array(
                    'total_commission'=>$totalamount,
                    'status_commission'=>1
                );
                $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);


            }else{
                $mydata['save'] = array(
                    'status_commission'=>2
                );
                $this->general_model->updatemy($table = 'test_agent_notremoved', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);
            }

        }

        $data='OK';
        echo json_encode($data);
        unset($data);
        exit();

    }
    public function gettotal_commission2(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        die();
        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $gafr = $this->t_m->getagents2();
        foreach ( $gafr as $key => $value) {
            echo $value['account_number'].'<br/>';

            $webservice_config = array('server' => 'live_new');
            $WS_GT = new WebService($webservice_config);
            $arrayName = array(
                'iAgent' =>$value['agent'],
                'iAccount' => $value['account_number'],
                'from' => $value['api_registration'],
                'to' => '2017-06-03T01:00:00',
            );
            $WS_GT->open_GetAgentTotalCommissionFromAccount($arrayName);
            if ($WS_GT->request_status === 'RET_OK') {

                $totalamount = $WS_GT->get_result('TotalAmount');
                $mydata['save'] = array(
                    'total_commission'=>$totalamount,
                    'status_commission'=>1
                );
                $this->general_model->updatemy($table = 'test_removedagent_others', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);


            }else{
                $mydata['save'] = array(
                    'status_commission'=>2
                );
                $this->general_model->updatemy($table = 'test_removedagent_others', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);
            }

        }

        $data='OK';
        echo json_encode($data);
        unset($data);
        exit();

    }
    public function gettotal_commission_data2(){
        die();
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $this->load->model('Task_model');
        $this->t_m=$this->Task_model;
        $gafr = $this->t_m->getagents_data2();
        foreach ( $gafr as $key => $value) {
            echo $value['account_number'].'<br/>';

            $webservice_config = array('server' => 'live_new');
            $WS_GT = new WebService($webservice_config);
            $arrayName = array(
                'iAgent' =>$value['agent'],
                'iAccount' => $value['account_number'],
                'from' => $value['api_registration'],
                'to' => '2017-06-03T01:00:00',
            );
            $WS_GT->open_GetAgentTotalCommissionFromAccount($arrayName);
            if ($WS_GT->request_status === 'RET_OK') {

                $totalamount = $WS_GT->get_result('TotalAmount');
                $mydata['save'] = array(
                    'total_commission'=>$totalamount,
                    'status_commission'=>1
                );
                $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);

            }else{
                $mydata['save'] = array(
                    'status_commission'=>2
                );
                $this->general_model->updatemy($table = 'test_ndbremovedagents', $field = 'account_number', $id = $value['account_number'],  $mydata['save']);
            }

        }

        $data='OK';
        echo json_encode($data);
        unset($data);
        exit();

    }

    public function getTradeHistory(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        $data['from'] = DateTime::createFromFormat('Y/d/m', $this->input->post('from',true));
        $data['none'] = DateTime::createFromFormat('Y/d/m', date('2015/01/01')); //
        $data['to'] = DateTime::createFromFormat('Y/d/m', $this->input->post('to',true));

        $data['from']->setTime(00,00,01);
        $data['to']->setTime(23,59,59);

        $data['trader']=$this->input->post('trader',true);
        $account_info = array(
            'iLogin' => $data['trader'],
            'from' =>   $this->input->post('from',true)!=''? $data['from']->format('Y-m-d\TH:i:s'): $data['none']->format('Y-m-d\TH:i:s'),
            'to' => $data['to']->format('Y-m-d\TH:i:s')
        );

        $webservice_config = array(
            'server' => 'live_new'
        );

        $WebService1 = new WebService($webservice_config);
        $WebService1->open_GetAccountTradesHistory($account_info);

        switch($WebService1->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebService1->get_result('TradeDataList');
                if($tradatalist) {


                    $closed='';
                    $data['data']['ClosedTotal']=0;
                    foreach ($tradatalist['TradeData'] as $object) {

                        $closed .= '<tr >';
                        $closed .= '<td>' . $object->OrderTicket . '</td>';
                        $closed .= '<td>' . $object->TradeType . '</td>';
                        $closed .= '<td>' . $object->Volume . '</td>';
                        $closed .= '<td>' . $object->Symbol . '</td>';
                        $closed .= '<td>' . $object->OpenPrice . '</td>';
                        $closed .= '<td>' . $object->StopLoss . '</td>';
                        $closed .= '<td>' . $object->TakeProfit . '</td>';
                        $closed .= '<td>' . $object->ClosePrice . '</td>';
                        $closed .= '<td>' . $object->Profit . '</td>';
                        $closed .= '</tr>';
                        $data['data']['ClosedTotal']= $data['data']['ClosedTotal']+floatval($object->Profit);


                    }

                    $data['data']['ClosedTotal']='
                                <tr class="total">
                                    <td colspan="8" align="right">Summary profit/loss : </td>
                                    <td id="closedtotal">'.$data['data']['ClosedTotal'].'</td>
                             </tr>
                    ';

                    $data['data']['Closed'] = $closed;
                }else{
                    $data['data']['history']='';
                    $data['data']['Closed']= '';

                    $data['data']['ClosedTotal']='
                             <tr class="total">
                                    <td colspan="8" align="right">Summary profit/loss : </td>
                                    <td id="closedtotal">0</td>
                             </tr>
                    ';
                }
                break;
            default:
                $data['data']['history']='';
                $data['data']['webservice']=' Server request error.';
                $data['HasError']=true;
        }

        $WebService2 = new WebService($webservice_config);
        $WebService2->open_GetBalanceMonitoringDataByDate($account_info);
        switch($WebService2->request_status){
            case 'RET_OK':
                $BalanceMonidtoringDataList = (array) $WebService2->get_result('BalanceMonidtoringDataList');
                $data['data']['Margin'] = array();
                $data['data']['Equity'] = array();
                $data['data']['Balance'] = array();
                foreach ($BalanceMonidtoringDataList['BalanceMonitorData'] as $object) {
                    $date = new DateTime($object->Stamp);
                    $data['Margin'] = array('x' =>strtotime($object->Stamp)*1000, 'y' =>  $object->Margin);
                    array_push($data['data']['Margin'], $data['Margin']);
                    $data['Equity'] = array('x' =>strtotime($object->Stamp)*1000, 'y' =>  $object->Equity);
                    array_push($data['data']['Equity'], $data['Equity']);
                    $data['Balance'] = array('x' => strtotime($object->Stamp)*1000, 'y' =>  $object->Balance);
                    array_push($data['data']['Balance'], $data['Balance']);
                }
                break;
            default:
                $data['data']['history']='';
                $data['data']['webservice']=' Server request error 2';
                $data['HasError']=true;
        }

        $data['data']['Margin']=  json_encode($data['data']['Margin'], JSON_NUMERIC_CHECK);
        $data['data']['Equity']=  json_encode($data['data']['Equity'], JSON_NUMERIC_CHECK);
        $data['data']['Balance']=  json_encode($data['data']['Balance'], JSON_NUMERIC_CHECK);

        echo json_encode($data['data']);
        unset($data);
    }



    public function printData(){
        $res = FXPP::updateAccountTradingStatus();
        var_dump($res);
    }


    public function ptest() {
       // if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $data['user_id'] = 379968; //$this->session->userdata('user_id');
        $data['update']=array(
            'partner_agreement'=>1
        );

        $data['updateBDUser']=array(
            'approved_affiliate_code' => 1
        );

        $bdUserCheck = $this->g_m->isBdcountry($data['user_id']);
        $data['bdUserCheck'] = $bdUserCheck['country'];


        if($data['bdUserCheck']=="BD"){
            //$this->g_m->updatemy($table='users_affiliate_code',$field='users_id',$id=$data['user_id'],$data['updateBDUser']);
        }





        $data['users'] = $this->g_m->updatemy($table='users',$field='id',$id=$data['user_id'],$data['update']);
        $data['client_account'] = $this->g_m->showst4j2w1($table='users',$table2='user_profiles',$table3='mt_accounts_set',$table4='users_affiliate_code',$field='users.id',$id=$data['user_id'],$join12='user_profiles.user_id=users.id',$join13='mt_accounts_set.user_id=users.id',$join14='users_affiliate_code.users_id=users.id',$select='user_profiles.full_name,mt_accounts_set.account_number,users_affiliate_code.affiliate_code,user_profiles.country');

        if($data['users']){
            $data['senddata'] = array(
                'full_name' => $data['client_account']['full_name'],
                'account_number' => $data['client_account']['account_number'],
                'country' => $this->general_model->getCountries($data['client_account']['country']),
                'affiliate_link' =>  FXPP::www_url().'register?id='.$data['client_account']['affiliate_code'],
                'date' => date('M d, Y')
            );

            if($data['bdUserCheck']!="BD") {

                //Fx_mailer::partners_agreement($data['senddata']);
            }

        }
        $data['isUpdated']=$data['users'];

       // $data['isBD']="BD";

        echo json_encode($data);
        unset($data);
    }


}
