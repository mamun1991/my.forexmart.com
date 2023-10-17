<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rebate_systems_new extends CI_Controller {
    public $periodicity = array('1'=>'Daily','2'=>'Weekly','3'=>'Monthly');
    public function __construct(){
        parent::__construct();
        $this->lang->load('partnership');
        $this->load->model('partners_model');
        $this->load->library('WSV');
        $user_id = $this->session->userdata('user_id');
        if($type = $this->general_model->showt1w1("partnership",'partner_id',$user_id,'*')){
            if($type['type_of_partnership']=="cpa" || $type['type_of_partnership']=="extra_commission"){
                redirect(FXPP::my_url('my-account'));
            }
        }

    }

    public function index() {
        $this->load->library('IPLoc', null);
        ini_set("soap.wsdl_cache_enabled", "0");
//        if($_SERVER['REMOTE_ADDR']!=='49.12.5.139'){
//            show_404();  
//        }
        if($this->session->userdata('logged') ){
//            if($_SESSION['user_id']==374667){ echo '<pre>';
//                print_r($_SESSION); }
            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');

            $accData = $this->general_model->whereConditionQuery( $user_id);
            $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('rebate', 'Rebate', 'trim|required|xss_clean|numeric');
            $custom_account = array(264409,109369);
            $custom_account2 = array(209874,231902,58059113);

            $dataList = $this->getDatalistOfAccount($account_number);
            $data['list_option'] = $dataList['list_option'];
            $data['max_value'] = $maxvalue = $dataList['max_value'];
            $this->form_validation->set_rules('new_value', 'New Value', "trim|required|xss_clean|less_than_equal_to[$maxvalue]");
            $data['rebate_msg']= 'Maximum rebate is '. $maxvalue.' %';
            
            
            

            $data['custom_account'] = $custom_account;
            $data['active_tab'] = 'rebate-system';
            $data['active_sub_tab'] = 'accounts';
            $data['page'] = 'rebate_system/all_rebates';
            $data['nav'] = 'default';
            $data['project']= $this->general_model->show('rebate_system','user_id',$user_id,'','id,desc')->result();
            $data['rebate_amount']= $this->partners_model->getRebateAmount($user_id);
            $data['errorMsg'] = '';
            if ($this->form_validation->run()) {
                $new_value = $_REQUEST['new_value'] * 0.01;
                $res = $this->addProject($new_value, $this->input->post());
                $data['errorMsg'] = $res['errorMsg'];
                $data['hasError'] = $res['hasError'];
            }

//            $this->useNewRebateAPI(array('recType'=>'get-projects','page'=>0 ));


            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title("ForexMart | Rebate System")
                ->append_metadata_css('')
                ->append_metadata_js("
                        <script type='text/javascript'>
                            var base_url ='".base_url()."';
                          </script>
                 ")
                ->set_layout('internal/main')
                ->build('rebate_system/new_rebate', $data);

        }else{
            redirect('signout');
        }
    }
    public function addProject($new,$info)
    {
        $rebateDetails = $this->general_model->showssingle('rebate_system', 'project_name', $info['project_name'], '*');

        $result = array(
            'hasError' => false,
            'errorMsg' => '',

        );
        if (!$this->isProjectExist($info['project_name'])) {
            $insertData = array(
                'project_name' => $info['project_name'],
                'rebate' => $info['rebate'],
                'new_value' => $new,
                'user_id' => $this->session->userdata('user_id'),
                'periodicity' => 4,
                'status' => 2,
                'created_date' => date('Y-m-d H:i:s')
            );

            $this->general_model->insert('rebate_system', $insertData);
            $info['recType'] = 'add-projects';
            $info['rebateVal'] = $new;
            $result = $this->useNewRebateAPI($info);
            if(!$result['hasError']){
                $result['errorMsg'] = 'Project has been successfully added.';
            }
            return $result;

        }

        $result['hasError'] = true;
        $result['errorMsg'] = 'Project name already exist.';
        return $result;
    }
    public function isProjectExist($projName){
        $args = array('Limit' => 5000,'Offset' => 0,'Type'=>'DEFAULT');
        $WSV = new WSV('rebate');
        $x = $WSV->GetProjects($args);
        if($x['Data']->DataCount > 0 && isset($projName)) {
            $projectList = json_decode(json_encode($x['Data']->Projects->ProjectData), true);
            $ids = array_column($projectList, 'ProjectName', 'ProjectName');
            if (isset($ids[$projName])) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    public function isClientActive($client){
        $args = array('Limit' => 5000,'Offset' => 0,'Type'=>'PERSONAL');
        $WSV = new WSV('rebate');
        $x = $WSV->GetProjects($args);
        if($x['Data']->DataCount > 0 && isset($client)) {
            $clientList = json_decode(json_encode($x['Data']->Projects->ProjectData), true);
            $ids = array_column($clientList, 'Client', 'Client');
            if (isset($ids[$client])) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    public function updateProject(){
            $id = $this->input->post('rsId',true);
            $user_id = $this->session->userdata('user_id');
            $updateData = array(
               // 'periodicity' => $this->input->post('periodicity',true),
                'periodicity' => 4,
                'rebate' => $this->input->post('rebateVal',true),
                'new_value' => $this->input->post('rebateNewVal',true) * 0.01,
                'status'    => $this->input->post('st',true)
            );



            $condition = array('user_id'=>$user_id,'status'=>1);
            if($this->general_model->whereCondition("rebate_system",$condition) && $updateData['status'] == 1){
                $msg = "Only one project can be active";
            }else{
                $this->general_model->updatemy('rebate_system','id',$id,$updateData);
                $msg = "Updated successfully";
            }
            $result = $this->useNewRebateAPI($updateData);
            if($result){
                $this->output->set_content_type('application/json')->set_output(json_encode($result));
            }

    }

    public function useNewRebateAPI($info=null){
//        print_r($info); die();
            ini_set("soap.wsdl_cache_enabled", "0");
            $hasError = false;
            $errorMsg = "No error.";
            $result = ""; $res = array();
            if($info['rType']!=='PERSONAL'){
                if ($this->input->is_ajax_request()) {  $info = $_POST;  }
            }

            $rType = $info['recType'];
            if(isset($info['page'])){ $page = ($info['page'] != 0) ? ( ($info['page'] - 1) * 10 ) : $info['page']; }
            $WSV = new WSV('rebate');
            $args = array('Limit' => 10,'Offset' => isset($page)? $page: 0 );
//                    echo "<pre>";
//                    print_r($info); die();
            switch ($rType) {
                case 'get-projects':
                    $args['Type'] = isset($info['rType'])? $info['rType'] : "DEFAULT";
                    $x = $WSV->GetProjects($args) ;
                    $hasError = ( $x['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $x['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;                 
                    $result = $this->populate(array('count'=>$x['Data']->DataCount, 'record'=>$x['Data']->Projects),$args);
                    break;
                case 'get-statistics':
                    $dateFr = $_POST['from']; $dateT = $_POST['to'];
                    $args = array('From' => FXPP::unixTime($dateFr.' 00:00:00') , 'To' =>FXPP::unixTime($dateT.' 23:59:59') );
                    $x = ( $WSV->GetStatistics($args)['ErrorMessage']=='RET_OK') ? $WSV->GetStatistics($args)['Data']: $WSV->GetStatistics($args) ;
                    $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                    $res['record'] = isset($x->Data) ? $x->Data : '';
                    $hasError = ( $WSV->GetStatistics($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $WSV->GetStatistics($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    break;
                case 'add-projects':
                    $type = isset($info['personal']) ? 'PERSONAL': 'DEFAULT';
                    $client = isset($info['personal']) ? $info['personal'] : array();
                    $args = array('ProjName' => $info['project_name'], 'RebateVal' => $info['rebateVal'], 'Type' => $type, 'AccountNumber'=>$client  );
//                    if($type=='PERSONAL'){
//                        print_r($info);
//                    print_r($args); die();
//                    }
                    $x = $WSV->RequestToAddProject($args);                    
                    $hasError = ( $x['ErrorMessage']=='RET_OK') ? false:true ;
                    $errorMsg = ( $x['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    break;
                case 'update-project':
                    $errorMsg = "Updated successfully";
                    switch ($info['st']){
                        case '0': $info['event'] = "DELETE"; break;
                        case '1': $info['event'] = "ACTIVATE"; break;
                        case '2': $info['event'] = "DEACTIVATE"; break;
                        default: $info['event'] = "ACTIVATE"; break;
                    }
                    if ($info['rType']!== "DEFAULT"){ $info['personal'] = $info['personal']; }
                    $type = isset($info['personal']) ? 'PERSONAL': 'DEFAULT';
                    if ($type == "PERSONAL"){ $rebateVal = $info['rebateVal'];}else{$rebateVal  = $info['rebateNewVal'] * 0.01; }

                    $client = isset($info['personal']) ? $info['personal'] : $this->session->userdata('account_number');
                    $args = array('ProjName' => $info['project_name'], 'RebateVal' => $rebateVal, 'Type' => $type, 'AccountNumber'=>$client, 'Action' =>  $info['event']  );

                    $x = $WSV->RequestToUpdateProject($args);
//                    if(IPLoc::IPOnlyForVenus()){
//                                         print_r($args);
//                        var_dump($x); exit();
//                    }


                    $hasError = ( $x['ErrorMessage']=='RET_OK') ? false:true ;
                    $errorMsg = ( $x['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
//                    print_r($x);
                    break;
                default :
                    $args['Type'] = isset($info['rType'])? $info['rType'] : "DEFAULT";
                    $x = $WSV->GetProjects($args) ;
                    $hasError = ( $x['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $x['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    $result = $this->populate(array('count'=>$x['Data']->DataCount, 'record'=>$x['Data']->Projects),$args);
                    break;
            }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('result' => $result , 'hasError' => $hasError , 'errorMsg' => $errorMsg )));
        }else{
            return array('result' => $result , 'hasError' => $hasError , 'errorMsg' => $errorMsg ) ;

        }
    }
    public function populate($data,$raw){
//        echo '<pre>';
//        print_r($data);
//        print_r($raw);die();
        $this->load->library('pagination');
        $rowPerPage = $raw['Limit'];
        $rowNum = $raw['Offset'];
        $data1['count'] = isset( $data['count'] )?  $data['count']: 0;

        $config['base_url'] = base_url().'get-trades';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $data1['count'] ;
        $config['page'] = $rowNum;
        $config['per_page'] = $rowPerPage;
        $config['use_page_numbers'] = TRUE;
        $config['first_link']       = 'first';
        $config['prev_link']        = 'prev';
        $config['last_link']        = 'last';
        $config['next_link']        = 'next';
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
        $config['cur_tag_open']     = '<li class="latest-page active"><a id="curPage" class="first" data-ci-pagination-page="1">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="latest-page">';
        $config['num_tag_close']    = '</li>';
        $config['num_links'] = 10;

        $this->pagination->initialize($config);
        $data1['pagination'] = $this->pagination->create_links();
        $data1['result'] =  $this->formatRaw($data['record'] , $rowNum, $raw['Type'], $data1['count']) ;

        $c = (intval($rowNum) + 1);
        $t =  ($rowNum+$rowPerPage) ;
        $t = ($t>=intval($data1['count']) )? $data1['count']: $t;
        $data1['showing'] = "Showing ".$c." to ".($t)." of ".$data1['count']." entries";
        $data1['row'] = $rowNum;
        $data1['rowPerPage'] = $data['rowPerPage'];

        return $data1;
    }
    public function formatRaw($records, $rowNum, $type, $count){
//        echo "<pre>";    print_r($records);   print_r($type);  print_r($count); die();
        $account_number = $this->session->userdata('account_number');
        $dataList = $this->getDatalistOfAccount($account_number);
        $list_option = $dataList['list_option'];
         $maxvalue = $dataList['max_value'];

        $tbl = '';
        $ctr = intval($rowNum) + 1;
        if($type=='PERSONAL'){
            if($count>0){
                foreach ($records->ProjectData as $a){
//                    print_r($a);
//                    die();
                    $db= $this->general_model->showWhere2('personal_rebate','user_id',$_SESSION['user_id'],'account_number',$a->Client,'id,desc')->result(); $db = $db[0];
                    $p= $db->periodicity;$s = $a->Status;
                    $daily = ($p==1)?"selected":"";   $weekly =($p==2)?"selected":"";      $monthly = ($p==3)?"selected":"";
                    $deac = (strtoupper($s)=="DEACTIVATED")?"selected":"";    $actve = (strtoupper($s)=="ACTIVATED")?"selected":"";  $del = (strtoupper($s)=="DELETED")?"selected":"";
                    $id = empty($db->id) ? 0 : $db->id;
                    $tbl .= "<tr id='tr-".$id."'>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".$a->Client."</td>";
//                    $tbl .= "<td><select id='p".$id."' class='form-control round-0 project-periodicity'>".
//                        "<option value='1' ".$daily.">Daily</option>".
//                        "<option value='2' ".$weekly.">Weekly</option>".
//                        "<option value='3' ".$monthly.">Monthly</option>".
//                        "</select></td>";
//                    $tbl .= "<td>Hourly</td>";
                    $tbl .= "<td><input id='pip".$id."' required='true'  min ='1' max=".$maxvalue."  type='number' name='rebate' class='form-control round-0 rebate-system-textbox new_value' onkeyup='this.value = rebateChange(this.value, 0, $maxvalue)'  value='".( $a->RebateValue * 100)."'> </td>";
                    //$tbl .= "<td>".$a->Status."</td>";
                    $tbl .= "<td>
                                <button onclick='update(".$id.",".$a->Client.")' type='button' class='btn-remove-avatar btn-rebate-add'>Update</button>
                                <button onclick='deleteAcc(".$id.",".$a->Client.")' type='button' class='btn-remove-avatar btn-rebate-add'>Delete</button>
                                </td>";
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="5">No data available.</td></tr>';
            }
        }else{
            if($count>0){
                foreach ($records->ProjectData as $a){
                    $db= $this->general_model->showWhere2('rebate_system','user_id',$_SESSION['user_id'],'project_name',$a->ProjectName,'id,desc')->result(); $db = $db[0];
                    //echo "<pre>";print_r($db->project_name);die();
                    $id = empty($db->id) ? 0 : $db->id;
                    $btn = "'".$id."'";
                    $p= $db->periodicity;$s = $a->Status;
                    $daily = ($p==1)?"selected":"";
                    $weekly =($p==2)?"selected":"";
                    $monthly = ($p==3)?"selected":"";
                    
                   
                    
                    switch ($a->Status){
                        case 'DELETE': $rStatus = "0"; break;
                        case 'ACTIVATE':$rStatus = "1"; break;
                        case 'DEACTIVATE': $rStatus = "2"; break;
                    }
                    
                    
                   
                    
                    $deac = (strtoupper($s)=="DEACTIVATED")?"selected":"";
                    $actve = (strtoupper($s)=="ACTIVATED")?"selected":"";
                    $del = (strtoupper($s)=="DELETED")?"selected":"";
                    
                     $deac_style = (strtoupper($s)=="DEACTIVATED")?"style='display:none'":"";
                    $actve_style = (strtoupper($s)=="ACTIVATED")?"style='display:none'":"";
                    $del_style = (strtoupper($s)=="DELETED")?"style='display:none'":"";
                    
                    $tbl .= "<tr id='tr-".$db->id."'>";
                    $tbl .= "<td>".$ctr."</td>";
                    $tbl .= "<td>".$a->ProjectName."</td>";
                  //  $tbl .= "<td>".$db->rebate."</td>";
//                    $tbl .= "<td>".$a->RebateValue."</td>";
                    $tbl .= "<td><input id='pip".$id."' required='true'  min ='1' max=".$maxvalue."  type='number' name='rebate' class='form-control round-0 rebate-system-textbox new_value'  onkeyup='this.value = rebateChange(this.value, 0, $maxvalue)' value='".( $a->RebateValue * 100)."' style='width: 100%;'> </td>";
//                    $tbl .= "<td><select id='p".$db->id."' class='form-control round-0 project-periodicity'>".
//                        "<option value='1' ".$daily.">Daily</option>".
//                        "<option value='2' ".$weekly.">Weekly</option>".
//                        "<option value='2' ".$monthly.">Monthly</option>".
//                        "</select></td>";

//                    $tbl .= "<td>Hourly</td>";
                   $tbl .= "<td>".$this->getRebetAccountStatusText(strtoupper($s))."</td>";
                    $tbl .= "<td ><select  name='proj-stat' id='project-status".$db->id."' class='form-control round-0 project-status' data-pname='".trim($a->ProjectName)."' data-rvalue='".$a->RebateValue."' data-rtype='".$a->Type."' data-rstatus='".$rStatus."'>".
                     //   "<option value='2' ".$deac.">Deactivate</option>".
                      //  "<option value='1' ".$actve.">Activate</option>".
                       // "<option value='0' ".$del.">Delete</option>".
                        "<option value='' >Select</option>".
                        "<option value='1' ".$actve_style.">Activate</option>".
                        "<option value='2' ".$deac_style.">Deactivate</option>".
                        "<option value='0' ".$del_style.">Delete</option>". 
                        "</select>";
                    //$tbl .= "<td><button onclick='update('.$db->id.")' type='button' class='btn-remove-avatar btn-rebate-update'>Update</button></td>";
                    $tbl .= '<button type="button" class="btn-remove-avatar btn-rebate-update btn-update-project" data-projType="'.$a->Type.'" data-rsId="'.$db->id.'">Update</button></td>';
                    $tbl .= "</tr>";
                    $ctr++;
                }
            }else{
                $tbl .= '<tr><td colspan="5">No data available.</td></tr>';
            }
        }
            return $tbl;
    }


    private function getRebetAccountStatusText($status){
                        
        
        if($status=="DELETED"){
            return "<b style='color:red'>".$status." </b>";
        }
        
         if($status=="DEACTIVATED"){
            return "<b style='color:gray'>".$status." </b>";
        }
        
        if($status=="ACTIVATED"){
            return "<b style='color:green'>".$status." </b>";
        }
                        
    }


    public function personal_rebate() {
        if($this->session->userdata('logged')){
//            echo "<pre>";
//            print_r($_SESSION);
            $this->load->library('IPLoc', null);
            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            $accData =  $this->general_model->whereConditionQuery( $user_id);

            $this->form_validation->set_rules('account', 'Account number', 'trim|required|xss_clean');

            $custom_account = array(264409,109369);
            $custom_account2 = array(209874,231902);
            $data['rebate_msg']= 'Max Value is 80%';
            $data['max_09']= false;
            $data['errorMsg'] = '';


            $dataList = $this->getDatalistOfAccount($account_number);
            $data['list_option'] = $dataList['list_option'];
            $data['max_value'] = $maxvalue = $dataList['max_value'];
            $this->form_validation->set_rules('rebate', 'New Value', "trim|required|xss_clean|less_than_equal_to[$maxvalue]");
            $data['rebate_msg']= 'Max value is '. $maxvalue.'%';



            if ($this->form_validation->run()) {

                if(!$this->isClientActive($this->input->post('account',true))){
                    $rebate = $_REQUEST['rebate'] * 0.01;
                    $insertData = array(
                        'rebate'=>$rebate,
                        'account_number'=>$this->input->post('account',true),
                        'periodicity'=>4,
//                    'periodicity'=>$this->input->post('periodicity',true),
                        'user_id'=>$user_id,
                        'date_created'=>date('Y-m-d H:i:s'));
                    $this->general_model->delete('personal_rebate','account_number',$this->input->post('account',true));
                    $this->general_model->insert('personal_rebate',$insertData);
                    $rebate_log = array(
                        'account_number'  => $this->input->post('account',true),
                        'status'          => "Add",
                        //'new_periodicity' => $this->input->post('periodicity',true),
                        'new_periodicity' => 4,
                        'new_pip_size'    => $this->input->post('rebate',true),
                        'modified_by'     => $user_id,
                        'date_modified'    => date('Y-m-d H:i:s'));

                    $this->general_model->insert('personal_rebate_log',$rebate_log);
                    $apiArgs = array('recType'=> 'add-projects',
                        'rType'=>"PERSONAL",
                        'personal'=>$this->input->post('account',true),
                        'rebateVal'=>$rebate,
                        'project_name'=> 'Project '.$this->input->post('account',true)
                    ) ;
                    $result = $this->useNewRebateAPI($apiArgs);

                    if(!$result['hasError']){
                        $result['errorMsg'] = 'Successfully added.';
                    }
                }else{
                    $data['hasError'] = true;
                    $data['errorMsg'] = 'Account '. $this->input->post('account',true) . ' already exist.';
                }

            }

            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);
            $data['account_number'] = $accData['account_number'];

            $data['project'] = $this->partners_model->getRebateProject($user_id);
            $data['rebate']= $this->getPersonalRebates();
//            print_r($data['rebate']);die();
                //$this->partners_model->getRebateAccountList($user_id);
            $data['periodicity'] = $this->periodicity;
            $data['active_tab'] = 'rebate-system';
            $data['page'] = 'rebate_system/personal-rebate-new';
            $data['nav'] = 'personal_rebate';

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title('ForexMart | Personal Rebate')
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('rebate_system/new_rebate', $data);

        }else{
            redirect('signout');
        }
    }

    public function getPersonalRebates(){
        $raw = $this->useNewRebateAPI(array('rType'=>"PERSONAL", "recType"=>'get-projects'));
        return $raw['result']['result'];
    }
    public function update_personal(){
        if($this->session->userdata('logged')){
//            print_r($this->input->post());
//            print_r($_POST);die();
            $id = $_POST['id'];
            $updateData = array(
                'periodicity' =>$_POST['periodicity'],
                'rebate'    => $_POST['pip']
            );


            $rebateDetails = $this->general_model->showssingle('personal_rebate','id',$id,'*');
            $rebate_log = array(
                'account_number'  => $rebateDetails['account_number'],
                'status'          => "Update",
                'new_periodicity' => 4,
               // 'new_periodicity' => $_POST['periodicity'],
                'old_periodicity' => $rebateDetails['periodicity'],
                'new_pip_size'    => $_POST['pip'],
                'old_pip_size'    => $rebateDetails['rebate'],
                'modified_by'     => $this->session->userdata('user_id'),
                'date_modified'    => date('Y-m-d H:i:s'));

            $this->general_model->insert('personal_rebate_log',$rebate_log);
            $this->general_model->updatemy('personal_rebate','id',$id,$updateData);

            $apiArgs = array(
                'recType'=>'update-project',
                'rType'=>'PERSONAL',
                'personal'=> $_POST['account'],
                'project_name'=> 'Project '.$_POST['account'] ,
                'rebateVal'=>$_POST['pip'] ,
                'st' => 1
            );
//            print_r($apiArgs);
            $result = $this->useNewRebateAPI($apiArgs);

        }else{
            redirect('signout');
        }
    }
    public function delete_personal(){
        if($this->session->userdata('logged')){
            $id = $_POST['id'];
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
            $apiArgs = array(
                'recType'=>'update-project',
                'rType'=>'PERSONAL',
                'personal'=>$rebateDetails['account_number'],
                'project_name'=> 'Project '.$rebateDetails['account_number'] ,
                'rebateVal'=>$rebateDetails['rebate'] ,
                'st' => 0
            );
            $result = $this->useNewRebateAPI($apiArgs);
            //print_r($result);
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
            $data['page'] = 'rebate_system/statistics-new';
            $data['nav'] = 'statistics';
            $data['referrals'] = $this->partners_model->getReferralsNDB($user_id);

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title("Forexmart | Statistics")
                ->append_metadata_css('')
                ->append_metadata_js("                   
                     <script src='".$this->template->Js()."Moment.js'></script>                       
                ")
                ->set_layout('internal/main')
                ->build('rebate_system/new_rebate', $data);

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
//    if(IPLoc::frz()){
//        echo $this->db->last_query();exit;
//    }
//            
          //  if($data= $this->partners_model->getStatisticsData($from,$to,$account_number,$this->session->userdata('account_number'))){
            if($data){
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
  public function statisticsDataV2() {
        if($this->session->userdata('logged')){ 

            
            $this->load->library('IPLoc', null);
            $user_id = $this->session->userdata('user_id');
            $agent = 0;
            if($agent_acc = $this->partners_model->getReferralsNDB($user_id)){
                $agent = $agent_acc[0]['account_number'];
            }
            $account_number = $this->input->post('account_number',true);
            $from_date = $this->input->post('from',true);
            $to_date = $this->input->post('to',true);
          //  $view = $this->input->post('view',true);
            
                        
            $accounts=$account_number;     
            if($account_number=="All")
            {   
            
                    $get_refarel_acc_form_date="2015-05-05";
                    $get_refarel_acc_to_date="Y-m-d 23:59:59";
                    $dateFrom = FXPP::unixTime(date("Y-m-d 0:0:0",strtotime($get_refarel_acc_form_date)));
                    $dateTo = FXPP::unixTime(date($get_refarel_acc_to_date));
                    $offset = 0;
                    $rowPerPage = 2147483647;


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


                    }
            }
            
                        
            
                // graph data start================>
                
                 ini_set("soap.wsdl_cache_enabled", "0");
                 $this->load->library('WSV');
                 $WSV = new WSV();
                 
                
                 $dateFrom = FXPP::unixTime(date("Y-m-d 0:0:0",strtotime($from_date)));
                 $dateTo = FXPP::unixTime(date($to_date));                 
                $api_request_parameters = array('From' => $dateFrom, 'To' => $dateTo, 'Limit' => count($accounts), 'Offset' => 0,'Accounts' => $accounts);

                $api_request_result =  $WSV->GetTotalCommissionFromAllReferrals($api_request_parameters);
                $api_status = $api_request_result['ErrorMessage']; 
                
               $commissionData = false;        
      
                if($api_status=="RET_OK")
                {
                    if($api_request_result['Data'])
                    {
                       $commissionData= $api_request_result['Data']->Commissions->Commission;
                    }    
                    
                        
                }    
                        
                        
                $arr = array();
                foreach($commissionData as $d){
                        
                    echo "[-------->".$accounts."<------------]";echo "<br>";
                     $date_data=$d->From*1000;
                    echo $d->From;
                    echo "[]===>".$date_data."--->";
                    echo date("Y-m-d 0:0:0",strtotime($d->From))."=================>";
                   echo date("Y-m-d 0:0:0",strtotime($date_data));
                   echo "<br>";
                    
                    

                }
               // echo "[".join(",",$arr)."]";
            
                echo "<pre>";
                print_r($commissionData);
                 exit;      
                       
                       
                       
               
                        //--- 

//                $totalCommission = 0;
//                $val = 0;
//                $html_commission = '';
//
//
//                foreach($commissionData as $d){
//                    $datetime = $d->CloseTime * 1000;
//                    if($opt=='no'){
//                        $val = $d->CommissionAgent;
//                    }else{
//                        $val = $val + $d->CommissionAgent;
//                    }
//                    $chartCommission[] = array($datetime, (float) $val);
//
//                    $totalCommission = $totalCommission + $d->CommissionAgent;
//                }
//              $this->output->set_content_type('application/json')->set_output(json_encode(array('data' => $chartCommission, 'data_html' => $html_commission, 'totalCommission' => $totalCommission,'account_number'=>$accountnumbers)));


            
              
              // --- 
//            if($data= $this->partners_model->getStatisticsData($from,$to,$account_number,$this->session->userdata('account_number'))){
//
//                $arr = array();
//                foreach($data as $d){
//                    if($d->num >0){
//                        $arr[]= "[". strtotime($d->p_date)*1000 .", ".$d->num."]";
//                    }
//
//                }
//                echo "[".join(",",$arr)."]";
//            }
//            
//            
            
            


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

