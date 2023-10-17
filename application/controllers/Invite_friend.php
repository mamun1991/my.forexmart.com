<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invite_friend extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('invite_model');
        $this->load->model('account_model');
        $this->lang->load('invitefriend');
       // self::reviewIp();

        if(!IPLoc::Office()){
            redirect('');
        }
    }

    function  index(){
        if($this->session->userdata('logged')) {
            $affiliate_code = $this->partners_model->getAffiliateCodeById($this->session->userdata('user_id'));
            $data['title_page'] = lang('sb_li_5');
            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'commission';
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
            $data['metadata_description'] = lang('ibepar_dsc');
            $data['metadata_keyword'] = lang('ibepar_kew');
            $this->template->title(lang('ibepar_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('partnership/commission', $data);
        }else{
            redirect('signout');
        }
    }
    public function email_check($str)
    {
        if($this->session->userdata('logged')) {


            if ($this->invite_model->checkPerDayOneInvite($str))
            {
            // echo   $test = $this->db->last_query();

                $this->form_validation->set_message('email_check','You have already invited this person');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }else{
            redirect('signout');
        }
    }
   /* function invite_by_email(){

        if($this->session->userdata('logged')) {


            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]|callback_email_check');
            //  $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('language', 'Language', 'trim|required|xss_clean');
            $this->form_validation->set_message('is_unique', ' The person you are trying to invite, already has an ForexMart account');
            $user_id = $this->session->userdata('user_id');
            $data['full_name'] = $this->session->userdata('full_name');

            if ($this->form_validation->run()) {

                $insert_data['subject']  = "Invitation to Open an ForexMart Trading Account";
                $config = array(
                    'mailtype'=> 'html'
                );
                if($this->general_model->sendEmail('invite-html',$insert_data['subject'], $insert_data['email'], $insert_data,$config))
                {
                    $insert_data= array(
                        'name' => $this->input->post('name'),
                        'email'=> $this->input->post('email'),
                        'language' => $this->input->post('language'),
                        'date' => date("Y-m-d H:i:s"),
                        'status' => 3, // '3' => 'Invited',
                        'bonus_status' => 6, // '6' =>'awaiting'
                        'ref_number' =>date("YmdHis"),
                        'bonus' =>"",
                        'user_id' => $user_id

                    );
                    $this->general_model->insert('invite_friends',$insert_data);
                    $this->session->set_flashdata('msg', "An invitation has been sent to your friends email. Kindly inform him/her to check his inbox.");
                    redirect(FXPP::my_url('invite-friend/invite-by-email'));

                }else{
                    $this->session->set_flashdata('msg', "An invitation has been not sent to your friends email.");

                    redirect(FXPP::my_url('invite-friend/invite-by-email'));
//                    $insert_data= array(
//                        'name' => $this->input->post('name'),
//                        'email'=> $this->input->post('email'),
//                        'language' => $this->input->post('language'),
//                        'date' => date("Y-m-d H:i:s"),
//                        'status' => 7, // '3' => 'Invited',
//                        'bonus_status' => 6, // '6' =>'awaiting'
//                        'ref_number' =>date("YmdHis"),
//                        'bonus' =>"",
//                        'user_id' => $user_id
//
//                    );
//                    $this->general_model->insert('invite_friends',$insert_data);

                }





            }

            $data['title_page'] = lang('sb_li_5');
            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'invite-by-email';
            $data['status'] = $this->general_model->getStatus();
            $data['language_array'] = $this->general_model->getLanguage();
            $data['language'] = $this->general_model->selectOptionList($data['language_array']);
            $data['ref'] = $this->general_model->show('invite_friends','user_id',$user_id,'','date,desc')->result();

            $data['metadata_description'] = lang('ibe_dsc');
            $data['metadata_keyword'] = lang('ibe_kew');
            $this->template->title(lang('ibe_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('invite_friend/invite_by_email', $data);
        }else{
            redirect('signout');
        }
    }*/
    function inviteByEmail(){

        if($this->session->userdata('logged')) {


            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]|callback_email_check');
            //  $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('language', 'Language', 'trim|required|xss_clean');
            $this->form_validation->set_message('is_unique', ' The person you are trying to invite, already has an ForexMart account');
            $user_id = $this->session->userdata('user_id');
            $data['full_name'] = $this->session->userdata('full_name');
            $user_affiliate_code = $this->invite_model->getUserAffiliateCode($user_id);

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $from = 'marketing@notify.forexmart.com';
                $verifyEmail = FXPP::verifyLegitEmail($email, $from);
                $ref_number = date('Ymdhis').rand(10, 99);
                if($verifyEmail === 'invalid') {

                    $insert_data = array(

                        'name' => $this->input->post('name',true),
                        'email'=> $this->input->post('email',true),
                        'language' => $this->input->post('language',true),
                        'date' => date("Y-m-d H:i:s"),
                        'status' => 7, // '3' => 'Invited',
                        'bonus_status' => 7, // '6' =>'awaiting'
                        'ref_number' => $ref_number,
                        'bonus' => "",
                        'user_affiliate_code' => $user_affiliate_code,
                        'user_id' => $user_id

                    );
                    $this->general_model->insert('invite_friends', $insert_data);

                }
                else {

                    $insert_data = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'language' => $this->input->post('language'),
                        'date' => date("Y-m-d H:i:s"),
                        'status' => 3, // '3' => 'Invited',
                        'bonus_status' => 6, // '6' =>'awaiting'
                        'ref_number' => $ref_number,
                        'bonus' => "",
                        'user_affiliate_code' => $user_affiliate_code,
                        'user_id' => $user_id

                    );
                    $this->general_model->insert('invite_friends', $insert_data);
                }

                $insert_data['subject']  = "Invitation to Open an ForexMart Trading Account";
                $config = array(
                    'mailtype'=> 'html'
                );

                $this->general_model->sendEmail('invite-html',$insert_data['subject'], $insert_data['email'], $insert_data,$config);
                $this->session->set_flashdata('msg', "An invitation has been sent to your friends email. Kindly inform him/her to check his inbox.");
                redirect(FXPP::my_url('invite-friend/invite-by-email'));
            }

            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'invite-by-email';
            $data['status'] = $this->general_model->getStatus();
            $data['language_array'] = $this->general_model->getLanguage();
            $data['language'] = $this->general_model->selectOptionList($data['language_array']);
            $data['ref'] = $this->general_model->show('invite_friends','user_id',$user_id,'','date,desc')->result();
            $data['metadata_description'] = lang('ibe_dsc');
            $data['metadata_keyword'] = lang('ibe_kew');
            $this->template->title(lang('ibe_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('invite_friend/invite_by_email', $data);
        }else{
            redirect('signout');
        }
    }

    function myFriends(){
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $this->load->library("Gmail");
            $gmail= $this->gmail->getApiInfo();
            $data['url'] = "https://accounts.google.com/o/oauth2/auth?client_id=".$gmail['client_id']."&redirect_uri=".$gmail['redirect_uri']."&scope=https://www.google.com/m8/feeds/&response_type=code";

            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'my-friends';
           // $data['email'] = $this->general_model->show('sync_email','user_id',$user_id)->result();
            $data['email'] = $this->invite_model->synonymsEmail($user_id);


            $data['metadata_description'] = lang('mf_dsc');
            $data['metadata_keyword'] = lang('mf_kew');
            $this->template->title(lang('mf_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('invite_friend/my_friends', $data);
        }else{
            redirect('signout');
        }
    }
   /* function my_Friends(){

        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $this->load->library("Gmail");
            $gmail= $this->gmail->getApiInfo();
            $data['url'] = "https://accounts.google.com/o/oauth2/auth?client_id=".$gmail['client_id']."&redirect_uri=".$gmail['redirect_uri']."&scope=https://www.google.com/m8/feeds/&response_type=code";
            $data['title_page'] = lang('sb_li_5');
            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'my-friends';
            //$data['email'] = $this->general_model->show('sync_email','user_id',$user_id)->result();
            $data['email'] = $this->invite_model->synonymsEmail($user_id);
            $data['metadata_description'] = lang('mf_dsc');
            $data['metadata_keyword'] = lang('mf_kew');
            $this->template->title(lang('mf_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('invite_friend/my_friends', $data);
        }else{
            redirect('signout');
        }
    }*/

    function syncEmail(){

        if($this->session->userdata('logged')) {

            $this->load->library("Gmail");
          $auth_code = $this->input->get('code');
          $data = $this->gmail->getContract($auth_code);
            $user_id = $this->session->userdata('user_id');
            $email = array();
            $exist_email = $this->general_model->show("sync_email",'user_id',$user_id)->result_array();
            foreach($exist_email as $d){
                $email[] = $d['email'];
            }

            foreach($data as $d){
               if(!in_array($d,$email)){  // ignore existing email address
                $insert_data = array(
                    'email' =>$d,
                    'user_id' => $user_id
                );
                $this->general_model->insert('sync_email',$insert_data);
               }
            }
            redirect('invite-friend/my-friends');

        }else{
            redirect('signout');
        }
    }
    /*function inviteUsingSyncEmail(){

        if($this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $data['full_name'] = $this->session->userdata('full_name');

            $email = array();
            $exist_email = $this->general_model->show("invite_friends",'user_id',$user_id)->result_array();
            foreach($exist_email as $d){
                $email[] = $d['email'];
            }

            $exist_email = $this->general_model->show("sync_email",'user_id',$user_id)->result();
              foreach($exist_email as $d){

                  if(!in_array($d->email,$email)){ // ignore invited email
                    $insert_data= array(
                        'name' => '',
                        'email'=> $d->email,
                        'language' => 'en',
                        'date' => date("Y-m-d H:i:s"),
                        'status' => 3, // '3' => 'Invited',
                        'bonus_status' => 6, // '6' =>'awaiting'
                        'ref_number' =>date("YmdHis"),
                        'bonus' =>"",
                        'user_id' => $user_id

                    );



                    $this->general_model->insert('invite_friends',$insert_data);
                    $insert_data['subject']  = "Invitation to Open an ForexMart Trading Account";
                    $config = array(
                        'mailtype'=> 'html'
                    );

                    $this->general_model->sendEmail('invite-html',$insert_data['subject'], $insert_data['email'], $insert_data,$config);
                  }
              }
           redirect(FXPP::loc_url('invite-friend/invite-by-email'));
        }else{
            redirect('signout');
        }
    }*/

    function sendInviteUsingSyncEmail(){



       $id  = $this->input->post('id',true);
       $name = $this->input->post('name',true);

        if($this->session->userdata('logged')) {


            $user_id = $this->session->userdata('user_id');
            $data['full_name'] = $this->session->userdata('full_name');

            $email = array();
            $exist_email = $this->general_model->show("invite_friends",'user_id',$user_id)->result_array();
            foreach($exist_email as $d){
                $email[] = $d['email'];
            }

          if( $sync_email = $this->general_model->whereCondition("sync_email",array('id'=>$id,'user_id'=>$user_id))){

              if(!in_array( $sync_email['email'],$email)){ // ignore invited email


                  $user_affiliate_code = $this->invite_model->getUserAffiliateCode($user_id);
                  $ref_number = date('Ymdhis').rand(10, 99);
                  $insert_data = array(
                      'name' => $name,
                      'email' => $sync_email['email'],
                          'language' => 'en',
                          'date' => date("Y-m-d H:i:s"),
                          'status' => 3, // '3' => 'Invited',
                          'bonus_status' => 6, // '6' =>'awaiting'
                          'ref_number' => $ref_number,
                          'bonus' => "",
                          'user_affiliate_code' => $user_affiliate_code,
                          'user_id' => $user_id

                      );

                  $this->general_model->insert('invite_friends',$insert_data);
                  $this->general_model->updatemy('sync_email','id',$id,array('status'=>1,'name'=>$name));
                  $insert_data['subject']  = "Invitation to Open an ForexMart Trading Account";
                  $config = array(
                      'mailtype'=> 'html'
                  );

                  $this->general_model->sendEmail('invite-html',$insert_data['subject'], $insert_data['email'], $insert_data,$config);
              }

          }

        }

        echo $this->db->last_query();
    }



    function statistics(){
error_reporting(E_ALL);
        set_time_limit(0);
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $data['active_tab'] = 'invite-friend';
            $data['active_sub_tab'] = 'statistics';

            $month = array(
                '1' => '0','2' => '0','3' => '0','4' => '0','5' => '0','6' => '0','7' => '0','8' => '0','9' => '0','10' => '0','11' => '0','12' => '0'
            );

            $invite_data =  $this->invite_model->getInvitePerMonth($user_id);
            $invite = array();
           foreach($invite_data as $d){
               $invite[$d->month] = $d->number;
           }
            $referral_data =  $this->invite_model->getReferralPerMonth($user_id);
            $referal =  array();
            foreach($referral_data as $d){
                $referal[$d->month] = $d->number;
            }
            $data['status'] = $this->general_model->getStatus();
            $data['language_array'] = $this->general_model->getLanguage();
            $data['language'] = $this->general_model->selectOptionList($data['language_array']);


            $webservice_config = array(
                'server' => 'live_new'
            );
            $WebService = new WebService($webservice_config);
            $data['bonus'] = array();

           if( $invite_list = $this->invite_model->getInviteFriendsAccountNumber($user_id)){

               foreach($invite_list as $d){

                   if($d->user_id_after_registration >0 ){
                       $firstDeposit = $this->general_model->showWhere2('deposit','user_id',$d->user_id_after_registration,'status','2','id,asc')->row();

                        $val =  $firstDeposit->amount / 2;
                       if($val >100){
                           $val = 100;
                       }

                       $WebService->GetFristDipositTradedVolume(array('account_number'=>$d->account_number));
                       if ($WebService->request_status === 'RET_OK') {
                            $vol = $WebService->get_result('TotalVolume');
                           $amount =  number_format((floatval($vol) / 0.1) * 3 ,4);
                           if($amount >100){
                               $amount = 100;
                           }
                           $data['bonus'][$firstDeposit->user_id] = array(
                               'virtual'=>abs($val - $amount),
                               'cash'=> $amount - number_format( floatval($d->amount) ,4),
                               'volume_amount'=> $amount

                           );

                       }
                   }

               }



           }

            $data['ref'] = $invite_list;


            

            /*$affcode=$this->general_model->getQueryStringRow('users_affiliate_code','affiliate_code',array('users_id'=>$user_id));

            $deposiCheck=$this->invite_model->checkDepositInvaiteFriends($affcode->affiliate_code);



                $getamount="";
                foreach($deposiCheck as $key)
                {
                    $getamount[$key->user_id]=$key->amount;
                }

            $data['dipositArray']=$getamount;*/

            $data['title_page'] = lang('sb_li_5');
            $data['invite'] = join(",",array_replace($month,$invite)) ;
            $data['referal'] = join(",",array_replace($month,$referal));

            $data['metadata_description'] = lang('sta_dsc');
            $data['metadata_keyword'] = lang('sta_kew');
            $this->template->title(lang('sta_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata('')
                ->build('invite_friend/statistics', $data);
        }else{
            redirect('signout');
        }
    }

    function reviewIp(){
        if(!IPLoc::Office_and_Vpn_InviteFriend()){
            redirect('my-account');
        }
    }

    function test(){
        $webservice_config = array(
            'server' => 'live_new'
        );
        $WebService = new WebService($webservice_config);
        $WebService->GetFristDipositTradedVolume(array('account_number'=>160674));
        if ($WebService->request_status === 'RET_OK') {
                        $AccountNumber = $WebService->get_result('TotalVolume');


        }

    }

    function credit(){

        if($this->session->userdata('logged')){

            $id = $this->input->post('id',true);

            if( $invite_info = $this->general_model->whereCondition('invite_friends',array('user_id'=>$this->session->userdata('user_id'),'id'=>$id))){

//                $account_detail = $this->general_model->whereCondition('all_accounts',array('user_id'=>$this->session->userdata('user_id'),'account_type'=>'1'));
                $account_detail =  $this->general_model->whereConditionQuery2( $this->session->userdata('user_id'),1);
//                $partner_account_detail = $this->general_model->whereCondition('all_accounts',array('user_id'=>$invite_info['user_id_after_registration'],'account_type'=>'1'));
                $partner_account_detail = $this->general_model->whereConditionQuery2( $invite_info['user_id_after_registration'],1);


                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);

                $WebService->GetFristDipositTradedVolume(array('account_number'=>$partner_account_detail['account_number']));
                if ($WebService->request_status === 'RET_OK') {
                   $vol = $WebService->get_result('TotalVolume');
                      //  $val = (($vol / 0.1) * 3);
                    $val =  number_format((floatval($vol) / 0.1) * 3 ,4);
                    //  maximum bonus is 100
                    if($val>100){
                        $val = 100;
                    }

                      $cash = $val - ($invite_info['credit']+$invite_info['withdraw']);

                    if($cash>0){

                        $config = array(
                            'server' => 'live_new'
                        );
//                        $WebService = new WebService($config);
                         $account_number = $account_detail['account_number'];

                       // $WebService->deposit_invite_A_friend_bonus($account_number, $cash, "BONUS FOR FRIEND  ".$partner_account_detail['account_number']);
//                        if(IPLoc::APIUpgradeDevIP()){
                            $WebServiceNew = FXPP::DepositRealFund($account_number, $account_number, "BONUS FOR FRIEND  ".$partner_account_detail['account_number']);
                            $requestResult = $WebServiceNew['requestResult'];
                            $ticket        = $WebServiceNew['ticket'];
//                        }else{
//                            $WebService->update_live_deposit_balance($account_number, $account_number, "BONUS FOR FRIEND  ".$partner_account_detail['account_number']);
//                            $requestResult = $WebService->request_status;
//                            $ticket        = $WebService->get_result('Ticket');
//                        }

                        if ($requestResult === 'RET_OK') {
                            $data['mt_ticket'] = $ticket;
                            $WebService2 = new WebService($config);
                            $WebService2->request_live_account_balance($account_number);
                            if ($WebService2->request_status === 'RET_OK') {
                               $balance = $WebService2->get_result('Balance');
                                $this->account_model->updateAccountBalance($account_number, $balance);
                                if($this->general_model->updatemyw2("invite_friends","user_id",$this->session->userdata('user_id'),"id",$id,array('credit'=>$cash))){

                                    $log = array('withdraw_type'=>1, // 1= credit. 2= withdraw
                                                'created_date'=>date('Y-m-d h:i:s'),
                                                'user_id'=>$this->session->userdata('user_id'),
                                                'amount'=>$cash,
                                                'inv_if'=>$id);
                                    $this->general_model->insertmy('invite_friend_bonus_log',$log);

                                    echo "done"; exit();
                                }

                            }
                        }

                    }

                }



            }

            echo "false" ;



        }else{
            redirect('signout');
        }
    }

    function withdraw(){

        if($this->session->userdata('logged')){


        }else{
            redirect('signout');
        }
    }

    function getTransactionFee(){

        if ($this->input->is_ajax_request()) {

            $payment_system = $this->input->post('payment_system');
            $currency = $this->input->post('currency');
            $getTransactionFee = FXPP::getTransactionFee($payment_system, $currency);
            echo json_encode($getTransactionFee);

        }else{
            exit('No direct script access allowed');
        }


    }

}