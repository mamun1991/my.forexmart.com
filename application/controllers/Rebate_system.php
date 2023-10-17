<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2/25/16
 * Time: 12:33 PM
 */


class Rebate_system extends CI_Controller {
    public function __construct(){
        parent::__construct();
		$this->lang->load('partnership');
        $this->load->model('partners_model');
        $user_id = $this->session->userdata('user_id');
        if($type = $this->general_model->showt1w1("partnership",'partner_id',$user_id,'*')){
            if($type['type_of_partnership']=="cpa" || $type['type_of_partnership']=="extra_commission"){
                redirect(FXPP::my_url('my-account'));
            }
        }



    }

    public $periodicity = array('1'=>'Daily','2'=>'Weekly','3'=>'Monthly');
    public function index() {
        if($_SERVER['REMOTE_ADDR']=='49.12.5.139'){
            redirect('rebate-systems-new');
        }
       // if(IPLoc::Office()) {


        $this->load->library('IPLoc', null);
        if($this->session->userdata('logged') ){


            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');

//            if($user_id == 132478){
//                $user_id = 158632;
//            }
//            $accData = $this->general_model->whereCondition('all_accounts', array('user_id' => $user_id));
            $accData = $this->general_model->whereConditionQuery( $user_id);
            $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|numeric');
            $custom_account = array(264409,109369);
            $custom_account2 = array(58060250,209874,231902, 58059113); // 58060250,209874 test accounts
//            $data['rebate_msg']= 'Max Value is 0.8 pips';z
            $data['rebate_msg']= 'Max Value is 80%';
            $data['max_09']= false;

               // if(IPLoc::IPOnlyForVenus()){

                    $dataList = $this->getDatalistOfAccount($account_number);
                    $data['list_option'] = $dataList['list_option'];
                    $data['max_value'] = $maxvalue = $dataList['max_value'];
                    $this->form_validation->set_rules('new_value', 'New Value', "trim|required|xss_clean|less_than_equal_to[$maxvalue]");
                    $data['rebate_msg']= 'Max value is '. $maxvalue.'%';
               /* }else{
                    if( in_array($accData['account_number'],$custom_account)){
//                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[1]'); // Set 1 pip auto rebate for affiliate account 264409. Client can only set it to 0.8 pip max, raise it to 1 pip.
                        $this->form_validation->set_rules('new_value', 'New Value', 'trim|required|xss_clean|less_than_equal_to[100]');
                    }
                    elseif( in_array($accData['account_number'],$custom_account2)){
//                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[0.9]'); // Set 1 pip auto rebate for affiliate account 264409. Client can only set it to 0.8 pip max, raise it to 1 pip.
//                    $data['rebate_msg']= 'Max Value is 0.9 pips';
//                    $data['max_09']= true;
                        $this->form_validation->set_rules('new_value', 'New Value', 'trim|required|xss_clean|less_than_equal_to[90]');
                        $data['rebate_msg']= 'Max Value is 90%';
                        $data['max_09']= true;

                    }
                    else{
//
                        $this->form_validation->set_rules('new_value', 'New Value', 'trim|required|xss_clean|less_than_equal_to[80]');
                    }
                }*/


            
            if ($this->form_validation->run()) {

                $new_value = $_REQUEST['new_value'] * 0.01;

                $rebateDetails = $this->general_model->showssingle('rebate_system','project_name',$this->input->post('project_name',true),'*');
                if(!$rebateDetails){
                    $insertData =  array(
                        'project_name'=> $this->input->post('project_name',true),
                        'rebate' => $this->input->post('rebate',true),
//                    'new_value' => $this->input->post('new_value',true),
                        'new_value' => $new_value,
                        'user_id'=> $user_id,
                        'periodicity'=>1,
                        'status'=>2,
                        'created_date'=> date('Y-m-d H:i:s')
                    );
                    // $this->general_model->delete('rebate_system',"user_id",$user_id);
                    $this->general_model->insert('rebate_system',$insertData);
                }


            }
            $data['account_number'] = $accData['account_number'];
            $data['custom_account'] = $custom_account;
            $data['active_tab'] = 'rebate-system';
            $data['active_sub_tab'] = 'accounts';
            $data['page'] = 'rebate_system/default';
            $data['nav'] = 'default';
            $data['project']= $this->general_model->show('rebate_system','user_id',$user_id,'','id,desc')->result();
            $data['rebate_amount']= $this->partners_model->getRebateAmount($user_id);





            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('rebate_system/navigation', $data);

        }else{
            redirect('signout');
        }

        //}
    }
    public function update(){
        if($this->session->userdata('logged')){
            $id = $this->input->post('id',true);
            $user_id = $this->session->userdata('user_id');
            $updateData = array(
                'periodicity' => $this->input->post('periodicity',true),
                'status'    => $this->input->post('st',true)
            );

            $condition = array('user_id'=>$user_id,'status'=>1);
            if($this->general_model->whereCondition("rebate_system",$condition) && $updateData['status'] == 1){
                echo "Only one project can be active";
            }else{
                $this->general_model->updatemy('rebate_system','id',$id,$updateData);
                echo "Updated successfully";
            }




        }else{
            redirect('signout');
        }
    }
    public function update_personal(){
        if($this->session->userdata('logged')){
            $id = $this->input->post('id',true);
            $updateData = array(
                'periodicity' => $this->input->post('periodicity',true),
                'rebate'    => $this->input->post('pip',true)
            );


            $rebateDetails = $this->general_model->showssingle('personal_rebate','id',$id,'*');
            $rebate_log = array(
                'account_number'  => $rebateDetails['account_number'],
                'status'          => "Update",
                'new_periodicity' => $this->input->post('periodicity',true),
                'old_periodicity' => $rebateDetails['periodicity'],
                'new_pip_size'    => $this->input->post('pip',true),
                'old_pip_size'    => $rebateDetails['rebate'],
                'modified_by'     => $this->session->userdata('user_id'),
                'date_modified'    => date('Y-m-d H:i:s'));

            $this->general_model->insert('personal_rebate_log',$rebate_log);

            $this->general_model->updatemy('personal_rebate','id',$id,$updateData);


        }else{
            redirect('signout');
        }
    }

    public function delete_personal(){
        if($this->session->userdata('logged')){
            $id = $this->input->post('id',true);
            $user_id = $this->session->userdata('user_id');
            $condition = array(
                'id' => $id,
                'user_id'    => $user_id
            );

            $rebateDetails = $this->general_model->showssingle('personal_rebate','id',$id,'*');
            $rebate_log = array(
                'account_number'  => $rebateDetails['account_number'],
                'status'          => "Delete",
                'old_periodicity' => $rebateDetails['periodicity'],
                'old_pip_size'    => $rebateDetails['rebate'],
                'modified_by'   => $this->session->userdata('user_id'),
                'date_modified'   => date('Y-m-d H:i:s'));

            $this->general_model->insert('personal_rebate_log',$rebate_log);

            $this->general_model->conditionalDelete('personal_rebate',$condition);



        }else{
            redirect('signout');
        }
    }
    public function personal_rebate() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');


//            if($user_id == 132478){
//                $user_id = 158632;
//            }
//            $accData = $this->general_model->whereCondition('all_accounts', array('user_id' => $user_id));
            $accData =  $this->general_model->whereConditionQuery( $user_id);

            $this->form_validation->set_rules('account', 'Account number', 'trim|required|xss_clean');
            $custom_account = array(264409,109369);
            $custom_account2 = array(209874,231902);
            $data['rebate_msg']= 'Max Value is 80%';
            $data['max_09']= false;


           // if(IPLoc::IPOnlyForVenus()){

                $dataList = $this->getDatalistOfAccount($account_number);
                $data['list_option'] = $dataList['list_option'];
                $data['max_value'] = $maxvalue = $dataList['max_value'];
                $this->form_validation->set_rules('rebate', 'New Value', "trim|required|xss_clean|less_than_equal_to[$maxvalue]");
                $data['rebate_msg']= 'Max value is '. $maxvalue.'%';

           /* }else {


                if (in_array($accData['account_number'], $custom_account)) {
                    //$this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[1]'); // Set 1 pip auto rebate for affiliate account 264409. Client can only set it to 0.8 pip max, raise it to 1 pip.
                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[100]');
                } elseif (in_array($accData['account_number'], $custom_account2)) {
                    //$this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[0.9]'); // Set 1 pip auto rebate for affiliate account 264409. Client can only set it to 0.8 pip max, raise it to 1 pip.
                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[90]');
//                    $data['rebate_msg']= 'Max Value is 0.9 pips';
                    $data['rebate_msg'] = 'Max Value is 90%';
                    $data['max_09'] = true;
                } else {
//                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[0.8]');
                    $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|less_than_equal_to[80]');
                }

            }*/






            if ($this->form_validation->run()) {


                $rebate = $_REQUEST['rebate'] * 0.01;

                $insertData = array(
//                    'rebate'=>$this->input->post('rebate',true),
                    'rebate'=>$rebate,
                    'account_number'=>$this->input->post('account',true),
                    'periodicity'=>$this->input->post('periodicity',true),
                    'user_id'=>$user_id,
                    'date_created'=>date('Y-m-d H:i:s'));

                $this->general_model->delete('personal_rebate','account_number',$this->input->post('account',true));
                $this->general_model->insert('personal_rebate',$insertData);

                $rebate_log = array(
                     'account_number'  => $this->input->post('account',true),
                     'status'          => "Add",
                     'new_periodicity' => $this->input->post('periodicity',true),
                     'new_pip_size'    => $this->input->post('rebate',true),
                     'modified_by'     => $user_id,
                     'date_modified'    => date('Y-m-d H:i:s'));

                $this->general_model->insert('personal_rebate_log',$rebate_log);


            }


            
            



          // if(IPLoc::APIUpgradeDevIP()){
                $dateFrom = 0;
                $dateTo = strtotime(date('Y-m-d H:i:s', strtotime('now')));

                $requestData = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => 2147483647, 'Offset' => 0,'isCPA' => $this->isCPA);
                $referralsList = FXPP::getReferralsOfAccount($requestData)['referralList'];

                foreach ($referralsList as $key => $obj) {
                    $data['referrals'][] = array('account_number'    =>  $obj->LogIn,);
                }
           /* }else{
                $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);
            }*/

            $data['account_number'] = $accData['account_number'];



            $data['project'] = $this->partners_model->getRebateProject($user_id);
            $data['rebate']= $this->partners_model->getRebateAccountList($user_id);
            $data['periodicity'] = $this->periodicity;
            $data['active_tab'] = 'rebate-system';
            $data['page'] = 'rebate_system/personal_rebate';
            $data['nav'] = 'personal_rebate';

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('rebate_system/navigation', $data);

        }else{
            redirect('signout');
        }
    }
    public function statistics() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');



            $data['active_tab'] = 'rebate-system';
            $data['page'] = 'rebate_system/statistics';
            $data['nav'] = 'statistics';
            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                        <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                 ")
                ->append_metadata_js("              
                      <script src='".$this->template->Js()."Moment.js'></script>
                      <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                      <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                      <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                
                ->build('rebate_system/navigation', $data);

        }else{
            redirect('signout');
        }
    }

    public function statisticsData() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);



            $user_id = $this->session->userdata('user_id');
            $agent = 0;
            if($agent_acc = $this->partners_model->getReferralsNDB($user_id)){
                $agent = $agent_acc[0]['account_number'];
            }
            $account_number = $this->input->post('account_number',true);
            $from = $this->input->post('from',true);
            $to = $this->input->post('to',true);
            $view = $this->input->post('view',true);
            $data= $this->partners_model->getStatisticsData($from,$to,$account_number,$this->session->userdata('account_number'));


            if($data= $this->partners_model->getStatisticsData($from,$to,$account_number,$this->session->userdata('account_number'))){

                $arr = array();
                foreach($data as $d){
                   if($d->num >0){
                       $arr[]= "[". strtotime($d->p_date)*1000 .", ".$d->num."]";
                   }

                }
                echo "[".join(",",$arr)."]";
            }



        }else{
            redirect('signout');
        }
    }



    public function getDatalistOfAccount($account){

        $resultData = $this->partners_model->getAccountRebate($account);
        $maxValue = 80; // default max value
        if($resultData) {
            $maxValue = $resultData['max_rebate_value'];
        }
       $listOption = '';
        for($i = 10; $i <= $maxValue; $i += 10){

            $listOption .= "<option value='".$i."'>";
        }

        $returnData = array('list_option' => $listOption, 'max_value' => $maxValue);


        return $returnData;




    }
}

