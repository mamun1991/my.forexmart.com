<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends MY_Controller {
    private $auto_update_fields = array(
        'email2',
        'email3',
        'phone2',
        'preferred_time'
    );

    public function __construct(){
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model('user_model');
        $this->load->model('contact_model');
        $this->load->model('account_model');
        $this->load->model('tank_auth/users');
        $this->load->model('General_model');
        $this->load->config('tank_auth', TRUE);
        $this->lang->load('myprofile');
        $this->load->library('SMS');
        $this->lang->load('currenttrades');
        
        
        
        $this->load->library('CheckMobiRest');
        if(isset($_COOKIE['enable_profiler'])){
            $this->output->enable_profiler(TRUE);
        }
    }

    
    public function test_fun(){
   
                
        
 //$this->lang->load('fxpp');           
 
      //  echo "=================";
                        
      //  echo lang('acc_veri_status_2');
        
        
 ///print_r(FXPP::getAccountStatus());
    
}     
    
    
    public function iasada(){
        die();
        $accountstatus=$this->general_model->showssingle($table='users',$field="id",$id=$_SESSION['user_id'],$select="accountstatus");
        var_dump($accountstatus);

    }
    public function index()
    {
        redirect(FXPP::loc_url('profile/edit'));
    }

    public function edit_old()
    {
        if($this->session->userdata('logged')) {


            $user_id = $this->session->userdata('user_id');

            $getUserEmailByUserId = $this->account_model->getUserEmailByUserId($user_id);

            // Get user general information
            $user_profile = $this->user_model->getUserProfileByUserId( $user_id );
            // Get user contact information
            $user_contact = $this->contact_model->getUserContactByUserId( $user_id );
            // Get countries array
            $countries = $this->general_model->getCountries();

            $this->load->library('IPLoc', null);

            //if(IPLoc::IPCrpAccVerify()){
                $data['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=>$user_id));
                $this->session->set_userdata(array('corporate_acc_status'=>$data['account_type_status']->corporate_acc_status));
            //}

            $user_data = array(
                'name' => '',
                'address' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'telephone' => array('',''),
                'email' => array('','',''),
                'contact_time' => '',
                'country' => '',
                'image' => '',
                'dob' => ''
            );

            if( $user_profile !== false ){
                $user_data['name'] = $user_profile['full_name'];
                $user_data['address'] = $user_profile['street'];
                $user_data['city'] = $user_profile['city'];
                $user_data['state'] = $user_profile['state'];
                $user_data['zip_code'] = $user_profile['zip'];
                $user_data['country'] = $user_profile['country'];
                $user_data['image'] = $user_profile['image'];
                $user_data['preferred_time'] = $user_profile['preferred_time'];
                $user_data['email1'] = $getUserEmailByUserId[0]['email'];
                $user_data['skype'] = $user_profile['skype'];
                $user_data['dob'] = $user_profile['dob'];

                    if(IPLoc::Office()){
                        $user_data['fb'] = $user_profile['fb'];
                        $user_data['social_media_type'] = $user_profile['social_media_type'];




                     }
            }

            if( $user_contact !== false ){
                $user_data['telephone1'] = $user_contact['phone1'];
                $user_data['telephone2'] = $user_contact['phone2'];
                $user_data['email2'] = $user_contact['email2'];
                $user_data['email3'] = $user_contact['email3'];
            }

            $user_data['email'][0]  = $getUserEmailByUserId[0]['email'];

            // Store Data for view
            $data['countries'] = $countries;
            $data['user_data'] = $user_data;

            $has_request = false;
            if($this->user_model->deleteExpiredProfileRequests()) {
                $has_request = $this->user_model->hasProfileRequests($user_id);
            }
            $date_change = '';
            if($has_request){
                $date_change_data = $this->user_model->getProfileChangeDateLastRequest($user_id);
                if($date_change_data === false){
                    $date_change = '';
                }else{
                    $date_change = date('D, d M Y H:i:s', strtotime($date_change_data));
                }
            }



            $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
            $this->session->set_userdata(array('image' => $image));


            // Render Edit Profile View
            $js = $this->template->Js();
            $data['has_request'] = $has_request;
            $data['date_change_alert'] = $date_change;

            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'personal-details';
            $data['metadata_description'] = lang('perdet_dsc');
            $data['metadata_keyword'] = lang('perdet_kew');
            $this->template->title(lang('perdet_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "/custom-profile.js'></script>
                            ")
                ->build('edit_profile', $data);
        }else{
            redirect('signout');
        }
    }
    public function corporate_info_save(){
        if($this->input->is_ajax_request() && $this->session->userdata('logged'))
        {
            $company_info=array(
                'user_id'=> $this->session->userdata('user_id'),
                'company_name'=>$this->input->post('name'),
                'company_trading_name'=>$this->input->post('company_trading_name'),
                'website'=>$this->input->post('company_website'),
                'business_type'=>$this->input->post('business_type'),
                'contact'=>$this->input->post('number'),
                'status'=>0,
                'added_date'=>date('Y-m-d H:i:s')
            );
            $this->update_bus_history($company_info);
            if($this->input->post('action')=='save'){
                $company_id=$this->account_model->insert('business_account_info',$company_info);
                $message='Company information successfully added';
            } else{
                $company_id=$this->account_model->updateUserDetails('business_account_info','user_id',$this->session->userdata('user_id'),$company_info);
                $message='Company information successfully updated';
            }
            if($company_id){
                echo json_encode(array('success'=>true,'message'=>$message));
            }
        }
        else
        {
            redirect('signout');
        }
    }
    public function update_bus_history($new){
        $this->load->model('Account_model');
        $user_id = $this->session->userdata('user_id');
        $info = $this->Account_model->getaccountshow('*','business_account_info',array('user_id'=>$this->session->userdata('user_id')));
        $old = array(
            'company_name'=>$info['company_name'],
            'company_trading_name'=>$info['company_trading_name'],
            'website'=>$info['website'],
            'business_type'=>$info['business_type'],
            'contact'=>$info['contact']
        );
        $ctr = 0;
        $changes =array();
        $old['company_name']==$new['company_name']?'':array_push($changes,'company_name');
        $old['company_trading_name']==$new['company_trading_name']?'':array_push($changes,'company_trading_name');
        $old['website']==$new['website']?'':array_push($changes,'website');
        $old['business_type']==$new['business_type']?'':array_push($changes,'business_type');
        $old['contact']==$new['contact']?'':array_push($changes,'contact');
        $date_modified = FXPP::getCurrentDateTime();
        if($changes){
            $update_history_data = array(
                'user_id' => $user_id,
                'manager_id' => 0,
                'update_url' =>FXPP::loc_url('profile/company-details'),
                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
            );
            $update_history_id = $this->Account_model->insertAccountUpdateHistory($update_history_data);
            if ($update_history_id) {
                foreach ($changes as $key){
                    $update_history_field_data = array('field' => $key,'old_value' => $old[$key],'new_value' => $new[$key],'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),'update_id' => $update_history_id);
                    $this->Account_model->insertAccountUpdateFieldHistory1($update_history_field_data);
//                    print_r($update_history_field_data);
                }
            }
        }
    }
    public function companyDetails(){

        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');

            $getUserEmailByUserId = $this->account_model->getUserEmailByUserId($user_id);

            // Get user general information
            $user_profile = $this->user_model->getUserProfileByUserId( $user_id );
            // Get user contact information
            $user_contact = $this->contact_model->getUserContactByUserId( $user_id );
            // Get countries array
            $countries = $this->general_model->getCountries();
            $data['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=>$user_id));
            $data['company_info'] =$this->user_model->getAccouTypeStatus('*','business_account_info',array('user_id'=>$user_id));

            $user_data['email'][0]  = $getUserEmailByUserId[0]['email'];
            // Store Data for view
            $data['countries'] = $countries;
            $data['user_data'] = $user_data;

            // Render Edit Profile View
            $js = $this->template->Js();
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'company-details';
            $data['metadata_description'] = lang('perdet_dsc');
            $data['metadata_keyword'] = lang('perdet_kew');
            $this->template->title(lang('perdet_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $js . "/custom-profile.js'></script>
                            ")
                ->build('company-deatils-for-corporate-account', $data);
        }else{
            redirect('signout');
        }
    }

    public function check_current_password( $password ){
        $this->load->library('password_hash');
        $this->form_validation->set_message('check_current_password', lang('error_pass_msg'));
        return $this->password_hash->check_password( $password );
    }

    /**
     *
     */
    public function upload_documents(){
        if($this->session->userdata('logged')) {
            
        $this->load->model('accountverification_model');

            
            
                        
                $user_id=$this->session->userdata('user_id'); 
                $data["user_doocument_data"]=$this->accountverification_model->getUserDocumentsData($user_id);       
                 $file_verification="account_file_uploaded_verification";
                 
                        
            /*
              // old implimentaion decliend.

            if(IPLoc::Office() && $this->session->userdata('email')=='mariaclove04@gmail.com' || $this->session->userdata('email')=='tobias@forexmart.com' || $this->session->userdata('email')=='imariclaw00@temp-mail.pp.ua'){ redirect(FXPP::loc_url('profile/upload-verification-documents'));}
            $data['checkUserDocsIDfront'] = $this->account_model->checkUserDocs( $this->session->userdata('user_id'), 0);
            $data['checkUserDocsIDback'] = $this->account_model->checkUserDocs( $this->session->userdata('user_id'), 1);
            $data['checkUserDocsResidence'] = $this->account_model->checkUserDocs( $this->session->userdata('user_id'), 2);

            $data['checkUserDocsAdditional'] = $this->account_model->checkUserDocs( $this->session->userdata('user_id'), 3);


                
                if ($data['checkUserDocsIDfront']){
                    $data['up0'] = $this->accountverification_model->checkUserDocs( $this->session->userdata('user_id'), 0);
                }
                if ($data['checkUserDocsIDback']){
                    $data['up1'] = $this->accountverification_model->checkUserDocs( $this->session->userdata('user_id'), 1);
                }
                if ($data['checkUserDocsResidence']){
                    $data['up2'] = $this->accountverification_model->checkUserDocs( $this->session->userdata('user_id'), 2);
                }

            if ($data['checkUserDocsAdditional']){
                $data['up3'] = $this->accountverification_model->checkUserDocs( $this->session->userdata('user_id'), 3);
            }

            $data['adCount']=$this->accountverification_model->checkAdditionalDocs( $this->session->userdata('user_id'));

            if($data['adCount']){
                $countX = 1;
                foreach( $data['adCount'] as $key){
                    if ($data['checkUserDocsAdditional']){
                        $data['adCounts'] = $countX;
                        $countX++;
                        $data['up'.$key['doc_type']] = $this->accountverification_model->checkUserDocs( $this->session->userdata('user_id'), $key['doc_type']);
                    }
                }
            }

            $file_verification="account_verification";
                        
            */
                 
                 
                 
            
            // For corporate account type check
            $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));

            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'account-verification';

            $data['metadata_description'] = lang('accver_dsc');
            $data['metadata_keyword'] = lang('accver_kew');
            $this->template->title(lang('accver_tit'))
                ->set_layout('internal/main')
//                ->build('upload_documents', $data);
                ->build($file_verification, $data);
        }else{
            redirect('signout');
        }
    }
                        
    
    

    public function platform_access(){

        redirect(FXPP::html_url('signout')); //https://my.forexmart.com/client/signin



        if($this->session->userdata('logged')) {
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'platform-access';
            $data['metadata_description'] = 'Check login ID and password of chosen platform.';

            $this->template->title("ForexMart | VPS")
                ->set_layout('internal/main')
                ->build('platform_access', $data);
        }else{
            redirect('signout');
        }
    }
    public function vps(){
        redirect('signout');
        die();
        if($this->session->userdata('logged')) {
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'vps';

            $this->template->title("ForexMart | VPS")
                ->set_layout('internal/main')
                ->build('platform_access', $data);
        }else{
            redirect('signout');
        }
    }

    public function uploadDocuments(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
       // $this->load->library('image_lib');
        $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');

        $data=array();
        if(!empty($_FILES['filename']['name'])){
            $this->load->helper(array('form', 'url'));
            $_FILES['userfile']['name']    = $_FILES['filename']['name'];
            $_FILES['userfile']['type']    = strtolower($_FILES['filename']['type']);
            $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'];
            $_FILES['userfile']['error']       = $_FILES['filename']['error'];
            $_FILES['userfile']['size']    = $_FILES['filename']['size'];

//            $config['file_name']     = sha1($_FILES['userfile']['name']);
            $config['file_name']     = hash('haval192,4',$_FILES['userfile']['name']);
            $config['upload_path'] =$this->config->item('asset_user_docs');// './assets/user_docs';
            $config['allowed_types'] = 'gif|JPG|JPEG|jpg|jpeg|png|pdf';
            $config['max_size']      = '10240';
          //  $config['max_width']     = '0';
          //  $config['max_height']    = '0';
           // $config['overwrite']     = false;
            $config['overwrite']     = false; // DO NOT CHANGE
            $this->load->library('upload',$config);
            // Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
           // $this->upload->initialize($config);
            $data['msgError_ext']=false;
            try{
                if($this->upload->do_upload()) {
                    $uploadData = $this->upload->data();

                    $updData = array(
                        'user_id' => $user_id,
                        'doc_type' => $this->input->post('doc_type',true),
                        'level' => $this->input->post('level',true),
                        'file_name' => $uploadData['file_name'],
                        'client_name' => $uploadData['client_name'],
                        'date_uploaded'=>Date('Y-m-d H:i:s'),
                    );
                    $config['source_image'] =$this->config->item('asset_user_docs').$uploadData['file_name'];

                        
                    
                    FXPP::setWaterMark($config['source_image']);

                   // echo $config['source_image']; exit();


//                    if(!IPLoc::Office()){
//                        FXPP::setWaterMark($config['source_image']);
//                    }



                    


//                $checkUser = $this->account_model->checkUserDocs( $user_id, $this->input->post('doc_type'));
//                if($checkUser){
//                    $this->account_model->update_upload_documents( $user_id, $this->input->post('doc_type'), $updData );
//                }else{
                    $docid = $this->account_model->upload_documents( $updData );
//                }

                    //print_r( $docid); echo('test'); exit();

                    $accountstatus=$this->general_model->showssingle($table='users',$field="id",$id=$this->session->userdata('user_id'),$select="accountstatus");
                    $upload=$this->general_model->showssingle($table='user_documents',$field="id",$id=$docid,$select="date_uploaded");
                    if ($accountstatus['accountstatus']!=1){
                        $data['newupload']=array(
                            'accountstatus'=>0,
                            'recent_fileupload'=> $upload['date_uploaded'],
                            "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                            "accountstatus_update_location"=>'my_1',
                            "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                        );
                        $rd = $this->general_model->updatemy('users',"id",$this->session->userdata('user_id'),$data['newupload']);
//                        $rd=$rd?'true':'false';
//                        print_r($rd);

                    }

                    $this->load->model('Adminslogs_model');
                    $logsPrms = array(
                        'Action' => 'CLIENT_UPLOAD_DOC',
                        'Doc_type' => $this->input->post('doc_type',true),
                        'File_name' =>  $uploadData['file_name'],
                        'Manager_IP' => $this->input->ip_address(),
                    );
                    $logsData = array(
                        'users_id' => $_SESSION['user_id'],
                        'page' => 'profile/upload-document',
                        'date_processed' => FXPP::getCurrentDateTime(),
                        'processed_users_id' => $_SESSION['user_id'],
                        'data' => json_encode($logsPrms),
                        'processed_users_id_accountnumber' => $_SESSION['account_number'],
                        'comment' => 'Upload verification document',
                        'admin_fullname' => $_SESSION['full_name'],
                        'admin_email' => $_SESSION['email'],
                    );
                    $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);



                    $data['error'] = false;
                    $data['msgError_ext']=false;
                    
                    
                }else{
                    $data['msgError'] = $this->upload->display_errors();

                    $data['error'] = true;
                    //http://php.net/manual/en/function.exif-imagetype.php
                    $data['filetype'] = exif_imagetype($_FILES['filename']['tmp_name']);
                    $data['filetype2']=strtolower($_FILES['filename']['type']);
                    $data['msgError_ext']=false;
                    switch(strtolower($_FILES['filename']['type'])){
                        case 'image/gif':
                            if (exif_imagetype($_FILES['filename']['tmp_name'])==1){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] =  lang('x_accv_01');
                            }
                            break;
                        case 'image/jpeg':
                            if (exif_imagetype($_FILES['filename']['tmp_name'])==2){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] = lang('x_accv_01');
                            }
                            break;
                        case 'image/png':
                            if (exif_imagetype($_FILES['filename']['tmp_name'])==3){

                            }else{
                                $data['msgError_ext']=true;
                                $data['msgError'] = lang('x_accv_01');
                            }
                            break;
                        default:
                    }
                }
            } catch(Exception $e){                $data['msgError_ext']=false;

                if (strpos($e->getMessage(), 'pdf') !== false) {
                    $data['msgError']="The PDF file type that you uploaded is not supported.";
                }else{
                    $data['msgError'] = $e->getMessage() ;
                }
//                $data['msgError'] =str_replace("/var/www/html/my.forexmart.com/assets/user_docs/", "",$e->getMessage() );
//                $data['msgError'] =str_replace("free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details)", " upload engine.",$data['msgError'] );
                $data['error'] = true;
            }

        }else{
            $data['msgError'] = lang('x_accv_02');
            $data['error'] = true;
        }
//        $data['trace']=$_FILES['userfile']['name'];
        echo json_encode($data);
    }
    
                        
    // old method 
    public function upload_user_documents(){

        if (!$this->input->is_ajax_request()) {die('Not authorized!');}

            $user_id = $this->session->userdata('user_id');

        $account_number = $this->general_model->showssingle('mt_accounts_set', 'user_id', $user_id, 'account_number');
     
        
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
            $config['upload_path'] = $this->config->item('asset_user_docs');//'/var/www/html/my.forexmart.com/assets/user_docs/';
            $config['allowed_types'] = 'gif|JPG|JPEG|jpg|jpeg|png|bmp|pdf';
            $config['max_size']      = '10240';
            $config['max_width']     = '0';
            $config['max_height']    = '0';
            $config['overwrite']     = false; //DO NOT CHANGE
            
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            try{
                if($this->upload->do_upload()){
                    
                        
                    
                    $uploadData = $this->upload->data();
                    $updData = array(
                        'user_id' => $user_id,
                        'doc_type' => $this->input->post('doc_type',true),
                        'level' => $this->input->post('level',true),
                        'file_name' => $uploadData['file_name'],
                        'client_name' => $uploadData['client_name'],
                        'date_uploaded'=>Date('Y-m-d H:i:s'), 
                    );
                    
                    
                    
                    $this->load->library('image_lib');
                    $asset_user_docs=$this->config->item('asset_user_docs');
                    $config['source_image'] = $asset_user_docs. $uploadData['file_name'];
                
                    FXPP::setWaterMark($config['source_image']);

                    $this->general_model->insertmy($table="user_documents",$updData);

                    $insert_id = $this->db->insert_id();

                    $dataValue = $this->general_model->getSingleValue('user_documents','file_name','id='.$insert_id);
                    $data['showsinglevalue'] = $dataValue['file_name'];
                    
                    
                    
                       $accountstatus=$this->general_model->showssingle($table='users',$field="id",$id=$this->session->userdata('user_id'),$select="accountstatus");
                    $upload=$this->general_model->showssingle($table='user_documents',$field="id",$id=$docid,$select="date_uploaded");
                    
                    
                    if ($accountstatus['accountstatus']==2 or $accountstatus['accountstatus']==4){
                        $data['newupload']=array(
                          'accountstatus'=>0,
                          'recent_fileupload'=> $upload['date_uploaded'],
                          "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                        "accountstatus_update_location"=>'my_2',
                        "accountstatus_update_by_user_id"=>$_SESSION['user_id']   
                        );
                        
                        
                        
                        
                        $rd = $this->general_model->updatemy('users',"id",$this->session->userdata('user_id'),$data['newupload']);

                    }
                    
                    
                    
                    

                    
                    
                    $this->load->model('Adminslogs_model');
                    $logsPrms = array(
                        'Action' => 'CLIENT_UPLOAD_DOC',
                        'Doc_type' => $this->input->post('doc_type',true),
                        'File_name' =>  $uploadData['file_name'],
                        'Manager_IP' => $this->input->ip_address(),
                    );
                    $logsData = array(
                        'users_id' => $_SESSION['user_id'],
                        'page' => 'profile/upload-document',
                        'date_processed' => FXPP::getCurrentDateTime(),
                        'processed_users_id' => $_SESSION['user_id'],
                        'data' => json_encode($logsPrms),
                        'processed_users_id_accountnumber' => $_SESSION['account_number'],
                        'comment' => 'Upload verification document',
                        'admin_fullname' => $_SESSION['full_name'],
                        'admin_email' => $_SESSION['email'],
                    );
                    $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);


                    
                    
                    
                    
                    $data['error'] = false;
                    $data['doc_filename'] = $uploadData['file_name'];
              

                    $data['msg'] = $this->image_lib->display_errors();
                    $data['msgError_ext']=false;
                    
                    
                    
                }else{
                        
                    
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
//               
                $data['error'] = true;
            }

        }else{
            $data['msgError'] = 'Please select a file.';
            $data['error'] = true;
        }
        echo json_encode($data);
    }
    
    
    
    
    
     public function chckNameVald($name)
    {
        $this->load->library('Cyrillic');
         if(strlen($name)>127)
         {
               $this->form_validation->set_message('chckNameVald', 'The maximum character allowed 127.');
            return false;
         }else if(preg_match(Cyrillic::register_page(), $name))
         {
            $this->form_validation->set_message('chckNameVald', 'Your name is not correct.');
            return false;
          }
         else if(strlen($name)<4)
         {
             $this->form_validation->set_message('chckNameVald', lang('edit_profile_erro_1'));
            return false;
         }else{
             return true;
         }
         
    }
   
     public function chckAddressVald($address)
    {
        $this->load->library('Cyrillic');
         if(strlen($address)>90)
         { $this->form_validation->set_message('chckAddressVald', 'The maximum character allowed 90.');
            return false;
         }else if(preg_match(Cyrillic::register_page(), $address))
         {
            $this->form_validation->set_message('chckAddressVald', 'Your address is not correct.');
            return false;
          }
         else if(strlen($address)<4)
         {
             $this->form_validation->set_message('chckAddressVald', lang('edit_profile_erro_2'));
            return false;
         }else{
             return true;
         }
         
    }
    
     public function chckCityVald($city)
    {
        $this->load->library('Cyrillic');
         if(strlen($city)>30)
         {
               $this->form_validation->set_message('chckCityVald', 'The maximum character allowed 30.');
            return false;
         }else if(preg_match(Cyrillic::register_page(), $city))
         {
            $this->form_validation->set_message('chckCityVald', 'Your city name is not correct.');
            return false;
          }
         else if(strlen($city)<4)
         {
             $this->form_validation->set_message('chckCityVald', lang('edit_profile_erro_3'));
            return false;
         }else{
             return true;
         }
         
    }
    
     public function chckStateVald($state)
    {
        $this->load->library('Cyrillic');
         if(strlen($state)>30)
         {
               $this->form_validation->set_message('chckStateVald', 'The maximum character allowed 30.');
            return false;
         }else if(preg_match(Cyrillic::register_page(), $state))
         {
            $this->form_validation->set_message('chckStateVald', 'Your state name is not correct.');
            return false;
          }
         else if(strlen($state)<4)
         {
             $this->form_validation->set_message('chckStateVald', lang('edit_profile_erro_4'));
            return false;
         }else{
             return true;
         }
         
    } 
    
        
     public function chckzip_codeVald($zip_code)
    {
         if(strlen($zip_code)>15)
         {
               $this->form_validation->set_message('chckzip_codeVald', 'The maximum character allowed 15.');
            return false;
         }
         else if(strlen($zip_code)<2)
         {
             $this->form_validation->set_message('chckzip_codeVald', lang('edit_profile_erro_5'));
            return false;
         }else{
             return true;
         }
         
    }
       
    
      public function chckTelephoneVald($telephone)
    {
         if(strlen($telephone)>16)
         {
               $this->form_validation->set_message('chckTelephoneVald', 'Your telephone number is not correct. Max 16 digit allow.');
            return false;
         }
         else if(strlen($telephone)<4)
         {
            $this->form_validation->set_message('chckTelephoneVald', lang('edit_profile_erro_6'));
            return false;
         }else{
             return true;
         }
         
    }
                        
    public function chckIsTelephoneVald($telephone)
    {
         if(strlen($telephone)>16)
         {
               $this->form_validation->set_message('chckIsTelephoneVald', 'Your telephone number is not correct. Max 16 digit allow.');
            return false;
         }else{
             return true;
         }
         
    }
   
    
    public function is_valid_email($email) {
           $this->load->library('Fx_mailer');
     
        $return = Fx_mailer::validateEmail('notify@forexmart.com', $email);
        $emailavg = explode('@', $email);


        if ($email == 'aynel@abv.bg' or $email == '576@tuta.io') {
        }
        if ($emailavg[1] == 'abv.bg') {
            return true;
        }
        if ($emailavg[1] == 'gmx.at') {
            return true;
        }
        if ($emailavg[1] == 'forexspez.ru') {
            return true;
        }
        if ($emailavg[1] == 'gmx.de') {
            return true;
        }
        if ($emailavg[1] == 'icloud.com') {
            return true;
        }
        if ($return[$email] == 'bool(true)') {
            return true;
        }else {
            $this->form_validation->set_message('is_valid_email', lang('edit_profile_erro_7'));
            // $this->form_validation->set_message('is_valid_email', 'The email address you entered is invalid.'); // FXPP-8880
            return false;
        }
    }
    
                        
    public function updateProfile(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_chckNameVald');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean|callback_chckAddressVald');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean|callback_chckCityVald');
            $this->form_validation->set_rules('state', 'State/Province', 'trim|required|xss_clean|callback_chckStateVald');
            $this->form_validation->set_rules('zip_code', 'zip', 'trim|required|xss_clean|callback_chckzip_codeVald');
            $this->form_validation->set_rules('telephone_1', 'Telephone Number', 'trim|required|xss_clean|callback_chckTelephoneVald');
            $this->form_validation->set_rules('telephone_2', 'Telephone Number', 'trim|xss_clean|callback_chckIsTelephoneVald');
            //if(IPLoc::Office()){
                $this->form_validation->set_rules('dob', 'Date of Birth', 'required|trim|xss_clean');
            //}
                        
            $this->form_validation->set_rules('email_1', 'Email', "trim|required|valid_email|xss_clean|callback_is_valid_email");

            if ($this->input->post('email_2',true) != null) {//optional email 2
                $this->form_validation->set_rules('email_2', 'Email (2)', "trim|valid_email|xss_clean|callback_is_valid_email");
            }
            if ($this->input->post('email_3',true) != null) {//optional email 3
                $this->form_validation->set_rules('email_3', 'Email (3)', "trim|valid_email|xss_clean|callback_is_valid_email");
            }


            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $this->form_validation->set_rules('preferred_time', 'Preferred time of contact', 'trim|xss_clean');

            $this->form_validation->set_rules('skype', 'Skype', 'trim|xss_clean');
            $isValidationError = true;
            $account_status = null;
            if($this->form_validation->run()) {



                $progj = '';
                $user_id = $this->session->userdata('user_id');
                $account_number = $this->session->userdata('account_number');
                $has_request = $this->user_model->hasProfileRequests($user_id);

                $account_status = $this->user_model->getUserDetails($user_id);

                if(!$has_request){
                    $field_alias = array(
                        'full_name' => 'Name',
                        'street' => 'Street',
                        'city' => 'City',
                        'zip' => 'Postal/Zip Code',
                        'state' => 'State/Province',
                        'phone1' => 'Telephone Number(1)',
                        'phone2' => 'Telephone Number(2)',
                        'dob' => 'Date of Birth',
                        'email' => 'Email(1)',
                        'email2' => 'Email(2)',
                        'email3' => 'Email(3)',
                        'country' => 'Country',
                        'preferred_time' => 'Preferred time of contact',
                        'skype' => 'Skype'
                    );

                    $field['full_name'] = $this->input->post('name',true);
                    $field['street'] = $this->input->post('address',true);
                    $field['city'] = $this->input->post('city',true);
                    $field['state'] = $this->input->post('state',true);
                    $field['zip'] = $this->input->post('zip_code',true);
                    $field['phone1'] = $this->input->post('telephone_1',true);
                    $field['phone2'] = $this->input->post('telephone_2',true);
                    $field['dob'] = $this->input->post('dob',true);
                    $field['email'] = $this->input->post('email_1',true);
                    $field['email2'] = $this->input->post('email_2',true);
                    $field['email3'] = $this->input->post('email_3',true);
                    $field['country'] = $this->input->post('country',true);
                    $field['preferred_time'] = $this->input->post('preferred_time',true);

                    $field['skype'] = $this->input->post('skype',true);



                    $date_modified = FXPP::getCurrentDateTime();
                    $current_user_profile = $this->user_model->getUserProfileByUserId($user_id);
                    $change_fields = array();
                    $update_fields = array();
                    $update_req_fields = array();
                    $update_field_count=0;
                    $field_count=0;
                    array_push($this->auto_update_fields, "email", "phone1");

                    $auto_update_fields = $this->auto_update_fields;
                    foreach( $field as $key => $value ){
                        if(in_array($key, $auto_update_fields)){

                            if ($value != $current_user_profile[$key]) {
                                $update_fields[$key] = $value;
                                $update_field_count++;
                            }else{
                                $update_req_fields[$key] = $value;
                            }
                        }else {
                            $update_req_fields[$key] = $value;
                            if ($value != $current_user_profile[$key]) {
                                $change_fields[$key] = array(
                                    'field' => $field_alias[$key],
                                    'old_value' => $current_user_profile[$key],
                                    'new_value' => $value,
                                    'date_changed' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'user_id' => $user_id
                                );
                                $field_count++;
                            }
                        }
                    }



                    if(!$this->session->userdata('login_type')) {
                        $account_details = $this->account_model->getAccountByUserId($user_id);
                        $user_info = $this->account_model->getUserDetailsByAccountNumber($account_number);
                        $progj = 'track1';
                    }else{
                        $account_details = $this->account_model->getAccountByPartnerId($user_id);
                        $user_info = $this->account_model->getUserDetailsByAccountNumber_partner($account_number);
                        $progj = 'track2';
                    }
                    
                        
                    
                    $allow_change= (count($change_fields)>0)?true:($field_count>0)?true:false;
                     $allow_update_change= (count($update_fields)>0)?true:($update_field_count>0)?true:false;
                    

                    if($allow_change){
                        $progj = 'track3';
                        if ($account_status['accountstatus'] == 0 || $account_status['accountstatus'] == 2) { //non verified accounts
                            $progj = 'track4';

                            
                            
                            
                         // if(IPLoc::APIUpgradeDevIP()){
                                $requestProfileData = array(
                                    'account_number' =>$account_number,
                                    'field' => $field,
                                );
                                $updateResult =  $this->updateAccountDetails($requestProfileData,false);
                           /* }else{

                                $webservice_config = array('server' => 'live_new');
                                $service_account_info = array(
                                    'iLogin' => $account_number
                                );

                                $AccountWebService = $this->wsv->GetAccountDetailsSingle($service_account_info, $webservice_config);

                                $account_comment = '';
                                if($AccountWebService->request_status == 'RET_OK'){
                                    $account_comment = $AccountWebService->result['Comment'];
                                }
                                $WebService = new WebService($webservice_config);
                                $account_info = array(
                                    'account_number' => $account_number,
                                    'city' => $field['city'],
                                    'country' => $this->general_model->getCountries($field['country']),
                                    'email' => $field['email'],
                                    'full_name' => $field['full_name'],
                                    'phone_number' => $field['phone1'],
                                    'state' => $field['state'],
                                    'street_address' => $field['street'],
                                    'zip_code' => $field['zip'],
                                    'comment' => $account_comment,
                                    'skype' => $field['skype']
                                );

                                $WebService->update_live_account_details($account_info);
                                $updateResult =  $WebService->request_status;

                            }*/
                                
                        
                             
                            if ($updateResult === 'RET_OK') {
                                $progj = 'track5';

                                //add Account Update History
                                $update_history_data = array(
                                    'user_id' => $user_id,
                                    'manager_id' => $user_id,
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'update_url'=>'profile/updateProfile',
                                );
                                $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);

                                //add Account Update Fields History
                                if ($update_history_id) {
                                    $update_history_field_data = array();
                                    $fields_changed = array();
                                    $num_change_field=0;
                                    foreach ($field as $key => $value) {
                                        if ($value != $current_user_profile[$key]) {
                                            $fields_changed[$key] = array(
                                                'field_key' => $key,
                                                'field' => $field_alias[$key],
                                                'old_value' => $current_user_profile[$key],
                                                'new_value' => $value,
                                                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
                                            );
                                            
                                            $num_change_field++;
                                        }
                                    }
                                    foreach ($fields_changed as $field_key => $field_value) {
                                        $update_history_field_data[] = array(
                                            'field' => $field_value['field'],
                                            'old_value' => $field_value['old_value'],
                                            'new_value' => $field_value['new_value'],
                                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                            'update_id' => $update_history_id
                                        );
                                    }
                                    $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
                                    
                        
                                    
                                }

                                
                        
                                
                                //update user profile info
                                $user_profile_data = array(
                                    'full_name' => $field['full_name'],
                                    'street' => $field['street'],
                                    'city' => $field['city'],
                                    'state' => $field['state'],
                                    'country' => $field['country'],
                                    'zip' => $field['zip'],
                                    'dob' => $field['dob'],
                                    'skype' => $field['skype']
                                );
                                $isUpdateUserProfileInfo = $this->user_model->updateUserProfileInfoById($user_id, $user_profile_data);

                        
                                if($isUpdateUserProfileInfo) {
                                    
                                    $_SESSION['full_name']=$field['full_name'];
                                      
                                    
                                    $error = 'Profile successfully updated.<br>
                                            Your last profile edit was at: ' . date('D, d M Y H:i:s', strtotime($date_modified));
                                    $progj = 'track6';
                                } else {
                                    $error = 'Failed to update';
                                    $progj = 'track7';
                                }
                                $isUpdate = true;
                                $progj = 'track8';
                            }
                            
                            
                             if($updateResult === 'RET_CHAR_EXCEEDS') {
                                  $error ="The text string you entered is too long, reduce the number of characters";
                             }
                            
                            $progj = 'track9';
                        } else {
                            // for verified accounts
                            // needs profile update approval except for email and phone
                            $progj = 'track10';
                            $email_data = array(
                                'name' => $current_user_profile['full_name'],
                                'account_number' => $account_number,
                                'change_fields' => $change_fields
                            );
                            if($this->user_model->insertProfileChangeRequest($change_fields)) {
                                $progj = 'track11';
                                    if (($user_info['test'] == 1 && $user_info['test_1'] == 0)) {
                                        $progj = 'track12';
                                        if ($user_info['user_id'] == 376406) {
                                            $progj = 'track13';
                                            $email = 'jayhens.snow@gmail.com';
                                            $config = array(
                                                'mailtype' => 'html'
                                            );
                                            $this->general_model->sendEmail('profile-request-html', 'Edit Profile Request [' .$account_number . ']', $email, $email_data, $config);
                                        } else if ($user_id == 6778) {
                                            $progj = 'track14';
                                            $email = 'vela.nightclad@gmail.com';
                                            $config = array(
                                                'mailtype' => 'html'
                                            );
                                            $this->general_model->sendEmail('profile-request-html', 'Edit Profile Request [' . $account_number . ']', $email, $email_data, $config);
                                        }
                                        $progj = 'track15';

                                    }else{
                                        $progj = 'track16';
                                            $email = 'support@forexmart.com';
                                            $config = array(
                                                'mailtype' => 'html'
                                            );
                                            $this->general_model->sendProfileEmail('profile-request-html', 'Edit Profile Request [' . $account_number . ']', $email, $email_data, $config);
                                        }
                                $progj = 'track17';
                            }
                            $progj = 'track18';
                            $error = lang('dc_alert'). date('D, d M Y H:i:s', strtotime($date_modified));
                            $isUpdate = true;
                        }

                        if(count($update_fields) > 0){
                            $data_update = array_merge($update_fields, $update_req_fields);

                            //if(IPLoc::IPOnlyForVenus()){
                                $requestProfileData = array(
                                    'account_number' =>$account_number,
                                    'email' => $update_fields['email'],
                                    'phone1' => $update_fields['phone1'],
                                );
                                $updateResult =  $this->updateAccountDetails($requestProfileData,true);
                                if($updateResult == 'RET_OK'){
                                    $data_update['email1'] = $data_update['email'];
                                    $this->user_model->updateUserProfileById($user_id, $data_update);
                                }

//                            }else{
//                                $data_update['email1'] = $data_update['email'];
//                                $this->user_model->updateUserProfileById($user_id, $data_update);
//                            }


                            $progj = 'track19';
                        }

                    }else{
                        
                        
                        $progj = 'track20';
                        if($allow_update_change){
                            $data_update = array_merge($update_fields, $update_req_fields);

                            //if(IPLoc::IPOnlyForVenus()){
                                $requestProfileData = array(
                                    'account_number' =>$account_number,
                                    'email' => $update_fields['email'],
                                    'phone1' => $update_fields['phone1'],
                                );
                                $updateResult =  $this->updateAccountDetails($requestProfileData,true);
                                if($updateResult == 'RET_OK'){
                                    $data_update['email1'] = $data_update['email'];
                                    $this->user_model->updateUserProfileById($user_id, $data_update);
                                    $error = 'Profile successfully updated';
                                    $isUpdate = true;
                                    $progj = 'track21';

                                    // save auto update fields changes
                                    //add Account Update History
                                    $update_history_data = array(
                                        'user_id' => $user_id,
                                        'manager_id' => $user_id,
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                        'update_url'=>'profile/updateProfile',
                                    );
                                    $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);

                                    //add Account Update Fields History
                                    if ($update_history_id) {
                                        $update_history_field_auto_data = array();
                                        $fields_changed_auto = array();
                                        foreach ($update_fields as $key => $value) {
                                           // if ($value != $current_user_profile[$key]) {
                                            $fields_changed_auto[$key] = array(
                                                    'field_key' => $key,
                                                    'field' => $field_alias[$key],
                                                    'old_value' => $current_user_profile[$key],
                                                    'new_value' => $value,
                                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
                                                );
                                           // }
                                        }
                                        foreach ($fields_changed_auto as $field_key => $field_value) {
                                            $update_history_field_auto_data[] = array(
                                                'field' => $field_value['field'],
                                                'old_value' => $field_value['old_value'],
                                                'new_value' => $field_value['new_value'],
                                                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                                'update_id' => $update_history_id
                                            );
                                        }
                                        $this->account_model->insertAccountUpdateFieldHistory($update_history_field_auto_data);
                                    }



                                } else {
									$isUpdate = FALSE;
								}

//                            }else{
//                                $data_update['email1'] = $data_update['email'];
//                                $this->user_model->updateUserProfileById($user_id, $data_update);
//                                $error = 'Profile successfully updated';
//                                $isUpdate = true;
//                                $progj = 'track21';
//                            }


                            $progj = 'track22';
                        }
                        $progj = 'track23';
                    }
                }else{
                    $progj = 'track24';
                    $error = 'Profile editing can only be performed once within a 24 hour period.';
                    $isUpdate = false;
                }
            }else{
                $progj = 'track25';
                $isValidationError = false;
                $error = array(
                    'name' => form_error('name'),
                    'address' => form_error('address'),
                    'city' => form_error('city'),
                    'state' => form_error('state'),
                    'zip-code' => form_error('zip_code'),
                    'telephone' => form_error('telephone_1'),
                    'email' => form_error('email_1'),
                    'email2' => form_error('email_2'),
                    'email3' => form_error('email_3'),
                    'country' => form_error('country'),
                    'dob' => form_error('dob')
                );
                $isUpdate = false;
            }

            if (true === $isUpdate) {
				$this->session->set_userdata(['full_name'  => $field['full_name']]);
			}

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate, 'error' => $error, 'validation_error' => $isValidationError, 'account_status' => $account_status['accountstatus'],'testinvestigate'=>$progj,'form_error',validation_errors() )));
        }else{
            show_404();
        }
    }


    public function updateAccountDetails($accountInfo,$isAutoChange = false){

        $account_number = $accountInfo['account_number'];

        $webservice_config = array('server' => 'live_new');
        $service_account_info = array(
            'iLogin' => $account_number
        );
        $field = $accountInfo['field'];

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        $AccountWebService = $WSV->GetAccountDetailsSingle($service_account_info, $webservice_config);

        $comment = '';
        if($AccountWebService->request_status == 'RET_OK'){
            $comment = $AccountWebService->result['Comment'];

        }

        if($isAutoChange) { //email and phone can be change without approval
            $account_info = array(
                'account_number' => $account_number,
                'city'           => $AccountWebService->result['City'],
                'country'        => $AccountWebService->result['Country'],
                'email'          => $accountInfo['email'],
                'full_name'      => $AccountWebService->result['Name'],
                'phone_number'   => $accountInfo['phone1'],
                'state'          => $AccountWebService->result['State'],
                'street_address' => $AccountWebService->result['Address'],
                'zip_code'       => $AccountWebService->result['ZipCode'],
                'comment'        => $comment
            );
        }else{


            $account_info = array(
                'account_number' => $account_number,
                'city'           => $field['city'],
                'country'        => $this->general_model->getCountries($field['country']),
                'email'          => $field['email'],
                'full_name'      => $field['full_name'],
                'phone_number'   => $field['phone1'],
                'state'          => $field['state'],
                'street_address' => $field['street'],
                'zip_code'       => $field['zip'],
                'comment'        => $comment
            );

        }
        
                        
        
        if(IPLoc::APIUpgradeDevIP()){
            
            $WSV = new WSV();
            $requestResult = $WSV->RequestUpdateAccountDetails($account_info);
                        
            $requestStatus = $requestResult['ErrorMessage']; //status
        }else{
            $WebServiceProfileUpdate = new WebService($webservice_config);
            $WebServiceProfileUpdate->update_live_account_details($account_info);
            $requestStatus =  $WebServiceProfileUpdate->request_status;
            
                        
        }

                        
        return $requestStatus;
                        

    }


    public function removeAvatar(){
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('user_id');
            $user_profile = $this->user_model->getUserProfileByUserId($user_id);
            $isRemove = false;
            $img_unlink=$this->config->item('asset_user_images');
            
            if (!empty($user_profile['image'])) {
                if ($this->user_model->updateUserAvatar($user_id, '')) {
                    $error = lang('profile-updated');
                    $isRemove = true;
                    if ($user_profile['image'] != '') {
                        if (file_exists($img_unlink.$user_profile['image'])) {
                            unlink($img_unlink.$user_profile['image']);
                        }
                        
                    }
                    
                    
                    unset($_SESSION['image']); 
                } else {
                    //If failed to update, remove uploaded file.
                    $error = 'Unable to remove profile avatar.';
                    $isRemove = false;
                }
            }else{
                $error = 'Default avatar cannot be removed. You can upload new avatar.';
                $isRemove = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isRemove, 'error' => $error)));
        }else{
            show_404();
        }
    }

    public function uploadAvatar(){
        if ($this->input->is_ajax_request()) {
            if (!empty($_FILES['avatar']['name'])) {
                $user_id = $this->session->userdata('user_id');
                $user_profile = $this->user_model->getUserProfileByUserId($user_id);
                if ($this->input->post('profile_avatar',true) != $user_profile['image']) {
                    $allowedExtensions = array("gif", "jpeg", "jpg", "png", "bmp");
                    $temp = explode(".", $_FILES["avatar"]["name"]);
                    $extension = end($temp);

                     $img_unlink=$this->config->item('asset_user_images');
                    
                    //Check if image format is valid
                    if ((($_FILES["avatar"]["type"] == "image/gif")
                            || ($_FILES["avatar"]["type"] == "image/jpeg")
                            || ($_FILES["avatar"]["type"] == "image/jpg")
                            || ($_FILES["avatar"]["type"] == "image/pjpeg")
                            || ($_FILES["avatar"]["type"] == "image/x-png")
                            || ($_FILES["avatar"]["type"] == "image/png")
                            || ($_FILES["avatar"]["type"] == "image/x-png"))
                        && in_array( strtolower($extension), $allowedExtensions)) {

                        $_FILES['userfile']['name'] = $_FILES['avatar']['name'];
                        $_FILES['userfile']['type'] = strtolower($_FILES['avatar']['type']);
                        $_FILES['userfile']['tmp_name'] = $_FILES['avatar']['tmp_name'];
                        $_FILES['userfile']['error'] = $_FILES['avatar']['error'];
                        $_FILES['userfile']['size'] = $_FILES['avatar']['size'];

                        $config['file_name'] = sha1($_FILES['userfile']['name']);
                        $config['upload_path'] = $img_unlink;//'./assets/user_images';
                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
//                        $config['max_size'] = '52428800';
                        $config['max_size'] = '92428800';
                        $config['max_width'] = '0';
                        $config['max_height'] = '0';
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload()) {
                            //Get upload data
                            $uploadData = $this->upload->data();
                            
                           

                            if ($this->user_model->updateUserAvatar($user_id, $uploadData['file_name'])) {
                                $error = 'Profile avatar successfully updated.';
                                $isUpdate = true;
                                $image_src = base_url($img_unlink.$uploadData['file_name']);
                                
                               $_SESSION['image']=$uploadData['file_name'];
                                
                            } else {
                                //If failed to update, remove uploaded file.
                                $error = 'Unable to update profile avatar.';
                                $isUpdate = false;
                                if (file_exists($img_unlink.$uploadData['file_name'])) {
                                    unlink($img_unlink.$uploadData['file_name']);
                                }
                            }
                        } else {
                            // Get upload error
                            $error = $this->upload->display_errors();
                            $isUpdate = false;
                        }
                    }else{
                        $error = 'Invalid format. Image should be in gif, jpg or png.';
                        $isUpdate = false;
                    }
                }else{
                    $isUpdate = true;
                    $error = 'new image. ' . $this->input->post('profile_avatar',true) . ' - ' . $user_profile['image'];
                }
            }else{
                $isUpdate = true;
                $error = 'empty file';
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate, 'error' => $error, 'src' => $image_src)));
        }else{
            show_404();
        }
    }

    public function updateProfileOld(){
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'State/Province', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip_code', 'zip', 'trim|required|xss_clean');
            $this->form_validation->set_rules('telephone_1', 'Telephone Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email_1', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
            $isValidationError = true;
            if($this->form_validation->run()) {
                $user_id = $this->session->userdata('user_id');
                if (!empty($_FILES['avatar']['name'])) {
                    $this->load->helper(array('form', 'url'));

                    // Get user general information
                    $user_profile = $this->user_model->getUserProfileByUserId($user_id);
                    //Check if new avatar is uploaded
                    if ($this->input->post('profile_avatar',true) != $user_profile['image']) {

                        //Check if avatar is removed
                        if ($this->input->post('profile_avatar',true)) {

                            $allowedExtensions = array("gif", "jpeg", "jpg", "png", "bmp");
                            $temp = explode(".", $_FILES["avatar"]["name"]);
                            $extension = end($temp);

                            //Check if image format is valid
                            if ((($_FILES["avatar"]["type"] == "image/gif")
                                    || ($_FILES["avatar"]["type"] == "image/jpeg")
                                    || ($_FILES["avatar"]["type"] == "image/jpg")
                                    || ($_FILES["avatar"]["type"] == "image/pjpeg")
                                    || ($_FILES["avatar"]["type"] == "image/x-png")
                                    || ($_FILES["avatar"]["type"] == "image/png")
                                    || ($_FILES["avatar"]["type"] == "image/x-png"))
                                && in_array( strtolower($extension), $allowedExtensions)) {

                                $_FILES['userfile']['name'] = $_FILES['avatar']['name'];
                                $_FILES['userfile']['type'] = strtolower($_FILES['avatar']['type']);
                                $_FILES['userfile']['tmp_name'] = $_FILES['avatar']['tmp_name'];
                                $_FILES['userfile']['error'] = $_FILES['avatar']['error'];
                                $_FILES['userfile']['size'] = $_FILES['avatar']['size'];

                                $config['file_name'] = sha1($_FILES['userfile']['name']);
                                $config['upload_path'] = $this->config->item('asset_user_images');//'./assets/user_images';
                                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                                $config['max_size'] = '52428800';
                                $config['max_width'] = '0';
                                $config['max_height'] = '0';
                                $config['overwrite'] = false; //DO NOT CHANGE
                                $this->load->library('upload', $config);

                                if ($this->upload->do_upload()) {
                                    //Get upload data
                                    $uploadData = $this->upload->data();
                                    $isUpdate = true;

                                    // Save user data with avatar's file name
                                    $data = array(
                                        //'full_name' => $this->input->post('name'),
                                        'street' => $this->input->post('address',true),
                                        'city' => $this->input->post('city',true),
                                        'state' => $this->input->post('state',true),
                                        'zip' => $this->input->post('zip_code',true),
                                        'country' => $this->input->post('country',true),
                                        'image' => $uploadData['file_name'],
                                        'phone1' => $this->input->post('telephone_1',true),
                                        'phone2' => $this->input->post('telephone_2',true),
                                        'email1' => $this->input->post('email_1',true),
                                        'email2' => $this->input->post('email_2',true),
                                        'email3' => $this->input->post('email_3',true)
                                    );

                                   $img_link= $this->config->item('asset_user_images');
                                    
                                    if ($this->user_model->updateUserProfileById($user_id, $data)) {
//                                    $error = $uploadData;
                                        $error = lang('profile-updated');
                                        $isUpdate = true;
                                    } else {
                                        //If failed to update, remove uploaded file.
                                        $error = 'Unable to update profile.';
                                        $isUpdate = false;
                                        if (file_exists($img_link.$uploadData['file_name'])) {
                                            unlink($img_link.$uploadData['file_name']);
                                        }
                                    }
                                } else {
                                    // Get upload error
                                    $error = $this->upload->display_errors();
                                    $isUpdate = false;
                                }
                            }else{
                                $error = 'Invalid format. Image should be in gif, jpg or png.';
                                $isUpdate = false;
                            }
                        } else {
                            $data = array(
                                // 'full_name' => $this->input->post('name'),
                                'street' => $this->input->post('address',true),
                                'city' => $this->input->post('city',true),
                                'state' => $this->input->post('state',true),
                                'zip' => $this->input->post('zip_code',true),
                                'country' => $this->input->post('country',true),
                                'image' => '',
                                'phone1' => $this->input->post('telephone_1',true),
                                'phone2' => $this->input->post('telephone_2',true),
                                'email1' => $this->input->post('email_1',true),
                                'email2' => $this->input->post('email_2',true),
                                'email3' => $this->input->post('email_3',true)
                            );

                            if ($this->user_model->updateUserProfileById($user_id, $data)) {
                                $error = lang('profile-updated');
                                $isUpdate = true;
                                $img_unlik=$this->config->item('asset_user_images');
                                
                                if ($user_profile['image'] != '') {
                                    if (file_exists($img_unlik.$user_profile['image'])) {
                                        unlink($img_unlik.$user_profile['image']);
                                    }
                                }
                            } else {
                                //If failed to update, remove uploaded file.
                                $error = 'Unable to update profile.';
                                $isUpdate = false;
                            }

                        }
                    } else { // Else when uploaded avatar didn't changed
                        $data = array(
                            //'full_name' => $this->input->post('name'),
                            'street' => $this->input->post('address',true),
                            'city' => $this->input->post('city',true),
                            'state' => $this->input->post('state',true),
                            'zip' => $this->input->post('zip_code',true),
                            'country' => $this->input->post('country',true),
                            'phone1' => $this->input->post('telephone_1',true),
                            'phone2' => $this->input->post('telephone_2',true),
                            'email1' => $this->input->post('email_1',true),
                            'email2' => $this->input->post('email_2',true),
                            'email3' => $this->input->post('email_3',true)
                        );

                        if ($this->user_model->updateUserProfileById($user_id, $data)) {
                            $error = lang('profile-updated');
                            $isUpdate = true;
                        } else {
                            //If failed to update, remove uploaded file.
                            $error = 'Unable to update profile.';
                            $isUpdate = false;
                        }
                    }

                } else { //Else When no uploaded avatar
                    $data = array(
                        //'full_name' => $this->input->post('name'),
                        'street' => $this->input->post('address',true),
                        'city' => $this->input->post('city',true),
                        'state' => $this->input->post('state',true),
                        'zip' => $this->input->post('zip_code',true),
                        'country' => $this->input->post('country',true),
                        'phone1' => $this->input->post('telephone_1',true),
                        'phone2' => $this->input->post('telephone_2',true),
                        'email1' => $this->input->post('email_1',true),
                        'email2' => $this->input->post('email_2',true),
                        'email3' => $this->input->post('email_3',true)
                    );

                    if ($this->user_model->updateUserProfileById($user_id, $data)) {
                        $error = lang('profile-updated');
                        $isUpdate = true;
                    } else {
                        //If failed to update, remove uploaded file.
                        $error = 'Unable to update profile.';
                        $isUpdate = false;
                    }
                }
            }else{
                $isValidationError = false;
                $error = array(
                    'name' => form_error('name'),
                    'address' => form_error('address'),
                    'city' => form_error('city'),
                    'state' => form_error('state'),
                    'zip-code' => form_error('zip_code'),
                    'telephone' => form_error('telephone_1'),
                    'email' => form_error('email_1'),
                    'country' => form_error('country')
                );
                $isUpdate = false;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate, 'error' => $error, 'validation_error' => $isValidationError)));
        }
    }

    public function sms_security(){
        if($this->session->userdata('logged') && IPLoc::Office()) {
            $user_id = $this->session->userdata('user_id');
            $sms = $this->input->post('sms',true);
            if($sms == 1){
                $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean');
            }else{
                $this->form_validation->set_rules('sms', 'SMS Security', 'trim|required|xss_clean');
            }
            if ($this->form_validation->run()) {


                $data = array('sms'=>$this->input->post('mobile',true));
                if($this->general_model->updatemy('contacts','user_id',$user_id,$data)){

                    $this->general_model->updatemy('users','id',$user_id,array('sms_security'=>$sms));

                }
               
            }

            $condition = array('id'=>$user_id,'sms_security'=>1);
            if($row= $this->general_model->whereCondition("users",$condition,"sms_security")){

                $condition = array('user_id'=>$user_id);
                $data['mobile'] = $this->general_model->whereCondition("contacts",$condition,"sms");
            }
            // For corporate account type check
            $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'sms-security';
            $data['metadata_description'] = lang('chapas_dsc');
            $data['metadata_keyword'] = lang('chapas_kew');
            $this->template->title(lang('chapas_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $this->template->Js() . "/pwstrength.js'></script>
                            ")
                ->build('sms_security', $data);
        }else{
            redirect('signout');
        }
    }
    public function change_password_dt(){
        redirect(FXPP::loc_url('profile'));
        if($this->session->userdata('logged')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $this->load->library('form_validation');
            $this->load->library('password_hash');
            $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|xss_clean|callback_check_apicurrentpassword');
            $data = array();
            if ($this->form_validation->run()) {

                $live = $this->general_model->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number,trader_password');
                $webservice_config = array(
                    'server' => 'live_new'
                );

                $WebService1 = new WebService($webservice_config);
                $WebService1->GeneratePassword();
                $password = $WebService1->get_all_result();

                if ($live) {
                    $prvt_data['account_number'] = $live['account_number'];

                    $webservice_config = array(
                        'server' => 'live_new'
                    );
                    $new_pass = $password;
//                    $WebService = new WebService($webservice_config);
                    $account_info = array(
                        'iLogin' => $prvt_data['account_number'],
                        'currentMasterPass' => $this->input->post('old_password',true),
                        'strNewPass' => $new_pass,
                    );
//                    $WebService->ChangeUserMasterPasswordClient($account_info);

                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);

                    switch ($WebService->request_status) {
                        case 'RET_OK':
                            $new_pass = $WebService->NewPassword;
                            $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
                            $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);
                            $datax['update'] = array(
                                'trader_password' => $new_pass
                            );
                            $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $datax['update']);
                            $data['success'] = true;

                            $datum['changepassword'] = array(
                                'account_number' => $prvt_data['account_number'],
                                'Email' => $_SESSION['email'],
                                'new_password' => $new_pass,
                                'type' => 0,
                            );
                            $this->load->library('fx_mailer');
                            $this->fx_mailer->change_password($datum['changepassword']);
                            break;
                        default:
                            $data['success'] = false;
                            $data['tank_error'] = 'System Failure. Please try again later.';
                    }

                } else {
                    $partner = $this->general_model->showssingle2($table = 'partnership', $field = 'partner_id', $id = $_SESSION['user_id'], $select = 'reference_num');
                    $prvt_data['account_number'] = $partner['reference_num'];
                    $new_pass = $password;

                    $webservice_config = array(
                        'server' => 'live_new'
                    );
//                    $WebService = new WebService($webservice_config);
                    $account_info = array(
                        'iLogin' => $prvt_data['account_number'],
                        'currentMasterPass' => $this->input->post('old_password',true),
                        'strNewPass' => $new_pass,
                    );

//                    $WebService->ChangeUserMasterPasswordClient($account_info);

                    $this->load->library('WSV'); //New web service
                    $WSV = new WSV();
                    $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);

                    switch ($WebService->request_status) {
                        case 'RET_OK':
                            $new_pass = $WebService->NewPassword;
                            $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
                            $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);

                            $datum['changepassword'] = array(
                                'account_number' => $prvt_data['account_number'],
                                'Email' => $_SESSION['email'],
                                'new_password' => $new_pass,
                                'type' => 1,
                            );
                            $this->load->library('fx_mailer');
                            $this->fx_mailer->change_password($datum['changepassword']);
                            $data['success'] = true;

                            break;

                        default:
                            $data['success'] = false;
                            $data['tank_error'] = 'System Failure. Please try again later.';
                    }


                }

            }
//        $data['form'] = Form_key::InputKey_array();
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'change-password';
            $data['metadata_description'] = lang('chapas_dsc');
            $data['metadata_keyword'] = lang('chapas_kew');
            $this->template->title(lang('chapas_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $this->template->Js() . "/pwstrength.js'></script>
                            ")
                ->build('change_password_test', $data);
        }else{
            redirect('signout');
        }
    }

   private  function CustomPassword() {
        //$lenAll = rand(6, 10);
        $lenAll = 7;//rand(6, 10);
        $lenExcess = $lenAll-3;
        $charPool = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $charPool1 = "abcdefghijklmnopqrstuwxyz";
        $charPool2 = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $charPool3 = "0123456789";
        $len=1;

        $pass1 = array();
        $length = strlen($charPool1) - 1;
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $length);
            $pass1[] = $charPool1[$n];
        }
        $pass2 = array();
        $length = strlen($charPool2) - 1;
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $length);
            $pass2[] = $charPool2[$n];
        }
        $pass3 = array();
        $length = strlen($charPool3) - 1;
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $length);
            $pass3[] = $charPool3[$n];
        }
        $pass4= array();
        $length = strlen($charPool) - 1;
        for ($i = 0; $i < $lenExcess; $i++) {
            $n = rand(0, $length);
            $pass4[] = $charPool[$n];
        }
        $pass12 = array_merge($pass1,$pass2);
        $pass23 = array_merge($pass3,$pass4);
        $pass = array_merge($pass23,$pass12);

        $password =str_shuffle(implode($pass));

        return $password;
    }
    public function check_apicurrentpassword($password){

        $live = $this->general_model->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        if($live){
            $prvt_data['account_number']=$live['account_number'];
        }else{
            $partner = $this->general_model->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num');
            $prvt_data['account_number']=$partner['reference_num'];
        }
        $webservice_config = array(
            'server' => 'live_new'
        );
        $service_data = array(
            'iLogin' => $prvt_data['account_number'],
            'strPassword' => $password
        );

        $WebService = new WebService($webservice_config);
        $WebService->CheckUserPassword($service_data);
        if ($WebService->request_status === 'RET_OK') {
            return true;
        }else{
            $this->form_validation->set_message('check_apicurrentpassword', lang('error_pass_msg'));
            return false;
        }

    }
    public function test(){
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
    }
    public function upload_documents_for_corporate(){
        if($this->session->userdata('logged')) {
            $data['corporate_doc_1']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),3,1);
            if($data['corporate_doc_1']==false){
                $data['corporate_doc_1']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),3,0);
            }
            $data['corporate_doc_2']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),4,1);
            if($data['corporate_doc_2']==false){
                $data['corporate_doc_2']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),4,0);
            }
            $data['corporate_doc_3']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),5,1);
            if($data['corporate_doc_3']==false){
                $data['corporate_doc_3']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),5,0);
            }

            $data['corporate_doc_4']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),6,1);
            if($data['corporate_doc_4']==false){
                $data['corporate_doc_4']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),6,0);
            }

            $data['corporate_doc_5']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),7,1);
            if($data['corporate_doc_5']==false){
                $data['corporate_doc_5']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),7,0);
            }

            $data['corporate_doc_6']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),8,1);
            if($data['corporate_doc_6']==false){
                $data['corporate_doc_6']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),8,0);
            }

            $data['corporate_doc_7']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),9,1);
            if($data['corporate_doc_7']==false){
                $data['corporate_doc_7']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),9,0);
            }

            $data['corporate_doc_8']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),10,1);
            if($data['corporate_doc_8']==false){
                $data['corporate_doc_8']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),10,0);
            }
            $data['corporate_doc_9']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),11,1);
            if($data['corporate_doc_9']==false){
                $data['corporate_doc_9']=$this->account_model->checkUserDocsForCorporate( $this->session->userdata('user_id'),11,0);
            }

            $data['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));

            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'corporate-account-verification';

            $data['metadata_description'] = lang('accver_dsc');
            $data['metadata_keyword'] = lang('accver_kew');
            $this->template->title(lang('accver_tit'))
                ->set_layout('internal/main')
//                ->build('upload_documents', $data);
                ->build('corporate-account_verification', $data);
        }else{
            redirect('signout');
        }
    }

    public function change_password_old(){
		
        if($this->session->userdata('logged')) {
            $this->load->library('Form_key');
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $data['msg'] = '';
            if(Form_key::isValid(trim($this->input->post('form_key',true)))) {
                $this->load->library('form_validation');
                $this->load->library('password_hash');
                
                        
                   $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|xss_clean|callback_check_apicurrentpasswordx|callback_checkAllowChangePassword');
                   
                        
                
                $data = array();
                if ($this->form_validation->run()) {

                    $live = $this->general_model->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number,trader_password');
                    $webservice_config = array(
                        'server' => 'live_new'
                    );

                    $WebService1 = new WebService($webservice_config);
                    $WebService1->GeneratePassword();
                    $password = $WebService1->get_all_result();

//                    if(IPLoc::VPN_IP_Jenalie()){ //FXMAIN-135

                        $number_of_change_password = FXPP::getAllowNumberOfChangePassV2(false);

                        if(!$number_of_change_password){

                            $this->load->model('user_model');
                            $email = $this->user_model->getUserEmail($_SESSION['user_id']); //FXMAIN-94

                            if ($live) {
                                $prvt_data['account_number'] = $live['account_number'];

                                $webservice_config = array(
                                    'server' => 'live_new'
                                );
                                $new_pass = $password;
//                        $WebService = new WebService($webservice_config);
                                $account_info = array(
                                    'iLogin' => $prvt_data['account_number'],
                                    'currentMasterPass' => $this->input->post('old_password',true),
                                    'strNewPass' => $new_pass,
                                );
//                        $WebService->ChangeUserMasterPasswordClient($account_info);

                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);

                                switch ($WebService->request_status) {
                                    case 'RET_OK':
                                        $new_pass = $WebService->NewPassword;
                                        $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
                                        $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);
                                        $datax['update'] = array(
                                            'trader_password' => $new_pass
                                        );
                                        $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $datax['update']);
                                        $data['success'] = true;
                                        $data['msg'] = 'success';

                                        $datum['changepassword'] = array(
                                            'account_number' => $prvt_data['account_number'],
                                            'Email' => $email,
                                            'new_password' => $new_pass,
                                            'type' => 0,
                                        );
                                        $this->load->library('fx_mailer');
                                        $this->fx_mailer->change_password($datum['changepassword']);

                                        $datum_3657 = array(
                                            'change_password_status' => 1,
                                            'change_password_date' => FXPP::getCurrentDateTime(),
                                            'change_password_attempts' => 0,
                                            'number_of_change_password' => 1
                                        );
                                        $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);

                                        break;
                                    default:

                                        $data['success'] = false;
                                        $data['tank_error'] = 'System Failure. Please try again later.';
                                }

                            } else {
                                $partner = $this->general_model->showssingle2($table = 'partnership', $field = 'partner_id', $id = $_SESSION['user_id'], $select = 'reference_num');
                                $prvt_data['account_number'] = $partner['reference_num'];
                                $new_pass = $password;

                                $webservice_config = array(
                                    'server' => 'live_new'
                                );
//                        $WebService = new WebService($webservice_config);
                                $account_info = array(
                                    'iLogin' => $prvt_data['account_number'],
                                    'currentMasterPass' => $this->input->post('old_password',true),
                                    'strNewPass' => $new_pass,
                                );

//                        $WebService->ChangeUserMasterPasswordClient($account_info);

                                $this->load->library('WSV'); //New web service
                                $WSV = new WSV();
                                $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);

                                switch ($WebService->request_status) {
                                    case 'RET_OK':
                                        $new_pass = $WebService->NewPassword;
                                        $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
                                        $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);

                                        $datum['changepassword'] = array(
                                            'account_number' => $prvt_data['account_number'],
                                            'Email' => $email,
                                            'new_password' => $new_pass,
                                            'type' => 1,
                                        );
                                        $this->load->library('fx_mailer');
                                        $this->fx_mailer->change_password($datum['changepassword']);
                                        $data['success'] = true;

                                        $datum_3657 = array(
                                            'change_password_status' => 1,
                                            'change_password_date' => date('Y-m-d H:i:s'),
                                            'change_password_attempts' => 0,
                                            'number_of_change_password' => 1
                                        );
                                        $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);
                                        break;

                                    default:
                                        $data['success'] = false;
                                        $data['tank_error'] = 'System Failure. Please try again later.';
                                }


                            }


                            $this->load->model('Adminslogs_model');
                            $logsPrms = array(
                                'Api_req' => $WebService->request_status,
                                'Action' => 'CHANGE_PASSWORD',
                                'Manager_IP' => $this->input->ip_address(),
                            );

                            $logsData = array(
                                'users_id' => $_SESSION['user_id'],
                                'page' => 'profile/change-password',
                                'date_processed' => FXPP::getCurrentDateTime(),
                                'processed_users_id' => $_SESSION['user_id'],
                                'data' => json_encode($logsPrms),
                                'processed_users_id_accountnumber' => $prvt_data['account_number'],
                                'comment' => 'Change password',
                                'admin_fullname' => $_SESSION['full_name'],
                                'admin_email' => $email,
                            );
                            $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);

                        }else{
                            //error

                            $data['success'] = false;
                            $data['tank_error'] = lang('max_pass_msg');
                        }

//                    }
//                    else{
//
//                        $number_of_change_password=(FXPP::getAllowNumberOfChangePass(false,true)+1);
//
//                        $this->load->model('user_model');
//                        $email = $this->user_model->getUserEmail($_SESSION['user_id']); //FXMAIN-94
//
//                        if ($live) {
//                            $prvt_data['account_number'] = $live['account_number'];
//
//                            $webservice_config = array(
//                                'server' => 'live_new'
//                            );
//                            $new_pass = $password;
////                        $WebService = new WebService($webservice_config);
//                            $account_info = array(
//                                'iLogin' => $prvt_data['account_number'],
//                                'currentMasterPass' => $this->input->post('old_password',true),
//                                'strNewPass' => $new_pass,
//                            );
////                        $WebService->ChangeUserMasterPasswordClient($account_info);
//
//                            $this->load->library('WSV'); //New web service
//                            $WSV = new WSV();
//                            $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);
//
//                            switch ($WebService->request_status) {
//                                case 'RET_OK':
//                                    $new_pass = $WebService->NewPassword;
//                                    $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
//                                    $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);
//                                    $datax['update'] = array(
//                                        'trader_password' => $new_pass
//                                    );
//                                    $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $datax['update']);
//                                    $data['success'] = true;
//                                    $data['msg'] = 'success';
//
//                                    $datum['changepassword'] = array(
//                                        'account_number' => $prvt_data['account_number'],
//                                        'Email' => $email,
//                                        'new_password' => $new_pass,
//                                        'type' => 0,
//                                    );
//                                    $this->load->library('fx_mailer');
//                                    $this->fx_mailer->change_password($datum['changepassword']);
//
//                                    $datum_3657 = array(
//                                        'change_password_status' => 1,
//                                        'change_password_date' => FXPP::getCurrentDateTime(),
//                                        'change_password_attempts' => 0,
//                                        'number_of_change_password'=>$number_of_change_password
//                                    );
//                                    $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);
//
//                                    break;
//                                default:
//
//                                    $data['success'] = false;
//                                    $data['tank_error'] = 'System Failure. Please try again later.';
//                            }
//
//                        } else {
//                            $partner = $this->general_model->showssingle2($table = 'partnership', $field = 'partner_id', $id = $_SESSION['user_id'], $select = 'reference_num');
//                            $prvt_data['account_number'] = $partner['reference_num'];
//                            $new_pass = $password;
//
//                            $webservice_config = array(
//                                'server' => 'live_new'
//                            );
////                        $WebService = new WebService($webservice_config);
//                            $account_info = array(
//                                'iLogin' => $prvt_data['account_number'],
//                                'currentMasterPass' => $this->input->post('old_password',true),
//                                'strNewPass' => $new_pass,
//                            );
//
////                        $WebService->ChangeUserMasterPasswordClient($account_info);
//
//                            $this->load->library('WSV'); //New web service
//                            $WSV = new WSV();
//                            $WebService = $WSV->ChangeUserMasterPassword($account_info, $webservice_config);
//
//                            switch ($WebService->request_status) {
//                                case 'RET_OK':
//                                    $new_pass = $WebService->NewPassword;
//                                    $hash_password = $this->password_hash->change_password($this->input->post('old_password',true), $new_pass);
//                                    $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);
//
//                                    $datum['changepassword'] = array(
//                                        'account_number' => $prvt_data['account_number'],
//                                        'Email' => $email,
//                                        'new_password' => $new_pass,
//                                        'type' => 1,
//                                    );
//                                    $this->load->library('fx_mailer');
//                                    $this->fx_mailer->change_password($datum['changepassword']);
//                                    $data['success'] = true;
//
//                                    $datum_3657 = array(
//                                        'change_password_status' => 1,
//                                        'change_password_date' => date('Y-m-d H:i:s'),
//                                        'change_password_attempts' => 0,
//                                        'number_of_change_password'=>$number_of_change_password
//                                    );
//                                    $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);
//                                    break;
//
//                                default:
//                                    $data['success'] = false;
//                                    $data['tank_error'] = 'System Failure. Please try again later.';
//                            }
//
//
//                        }
//
//
//                        $this->load->model('Adminslogs_model');
//                        $logsPrms = array(
//                            'Api_req' => $WebService->request_status,
//                            'Action' => 'CHANGE_PASSWORD',
//                            'Manager_IP' => $this->input->ip_address(),
//                        );
//
//                        $logsData = array(
//                            'users_id' => $_SESSION['user_id'],
//                            'page' => 'profile/change-password',
//                            'date_processed' => FXPP::getCurrentDateTime(),
//                            'processed_users_id' => $_SESSION['user_id'],
//                            'data' => json_encode($logsPrms),
//                            'processed_users_id_accountnumber' => $prvt_data['account_number'],
//                            'comment' => 'Change password',
//                            'admin_fullname' => $_SESSION['full_name'],
//                            'admin_email' => $email,
//                        );
//                        $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);
//
//                    }

                }
            }
            $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));
            $data['form'] = Form_key::InputKey_array();
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'change-password';
            $data['metadata_description'] = lang('chapas_dsc');
            $data['metadata_keyword'] = lang('chapas_kew');
            $this->template->title(lang('chapas_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $this->template->Js() . "/pwstrength.js'></script>
                        <script src='". $this->template->Js(). "bootbox.min.js'></script>
                            ")
                ->build('change_password', $data);
        }else{
            redirect('signout');
        }
    }

    public function check_apicurrentpasswordx($password){

        $live = $this->general_model->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        if($live){
            $prvt_data['account_number']=$live['account_number'];
        }else{
            $partner = $this->general_model->showssingle2($table='partnership',$field='partner_id',$id=$_SESSION['user_id'],$select='reference_num');
            $prvt_data['account_number']=$partner['reference_num'];
        }
        $webservice_config = array(
            'server' => 'live_new'
        );
        $service_data = array(
            'iLogin' => $prvt_data['account_number'],
            'strPassword' => $password
        );

        $WebService = new WebService($webservice_config);
        $WebService->CheckUserPassword($service_data);
        if ($WebService->request_status === 'RET_OK') {
            return true;
        }else{
            $usr = $this->general_model->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'change_password_date,change_password_attempts,change_password_status');
            if (intval($usr['change_password_attempts'])<3 ){
                $attempts=intval($usr['change_password_attempts'])+1;
                $datum_3657 = array(
                    'change_password_status'=>0,
                    'change_password_attempts'=>$attempts

                );
                $this->general_model->updatemy($table='users',$field='id',$id=$_SESSION['user_id'],$datum_3657);
                $this->form_validation->set_message('check_apicurrentpasswordx', lang('error_pass_msg'));
                return false;
            }else if( intval($usr['change_password_attempts'])>=3){
                $datum_3657 = array(
                    'change_password_status'=>0,
                    'change_password_date'=>date('Y-m-d H:i:s'),
                    'change_password_attempts'=>3
                );
                $this->general_model->updatemy($table='users',$field='id',$id=$_SESSION['user_id'],$datum_3657);
                $this->form_validation->set_message('check_apicurrentpasswordx', lang('max_pass_msg'));
                return false;
            }
        }

    }
    public function check_successfulchangepasswordattempt($password){
        $usr = $this->general_model->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'change_password_date,change_password_attempts,change_password_status');

        $date_created=DateTime::createFromFormat('Y-m-d H:i:s',$usr['change_password_date']);
        $date_difference=$this->g_m->difference_day($date_created->format('Y-m-d H:i:s'),$date_current=date('Y-m-d H:i:s'));

        if($date_difference>0 and $usr['change_password_status']==1  ){
            return true;
        }
        if ($usr['change_password_status']==0 ){
            return true;
        }
        if ($date_difference<1 and $usr['change_password_status']==1 ){
            $this->form_validation->set_message('check_successfulchangepasswordattempt', 'Changing password can be done only once a day. Please try again tomorrow.');
            return false;
        }
    }
    public function attempt(){
        $res =FXPP::getAllowNumberOfChangePass();
        var_dump($res);
    }
    public function checkAllowChangePassword($password)
    {
        if(FXPP::getAllowNumberOfChangePass())
        {
            return true;
        }
        else
        {
             $this->form_validation->set_message('checkAllowChangePassword', 'Changing password can be done only once a day. Please try again tomorrow.');
            return false;
        }    
       
    }        
    
    
    public function check_test(){
        $usr = $this->general_model->showssingle2($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $select = 'change_password_date,change_password_attempts,change_password_status');
        $datecreated=DateTime::createFromFormat('Y-m-d H:i:s',$usr['change_password_date']);
        $datedifference=$this->g_m->difference_day($datecreated->format('Y-m-d H:i:s'),$datecurrent=date('Y-m-d H:i:s'));
         echo $datedifference;

    }

    // Two Step Authentication
    public function two_factor_authentication(){

           //QRCodeSrc                 
        
        if(!$this->session->userdata('logged')) {
            redirect('signout');
        }

        $userID =  $this->session->userdata('user_id');
        $TFASettings = $this->account_model->GetTFASettings($userID);
        $data['isTFASet'] = $TFASettings['isEnabled'];

        $js = $this->template->Js();
        $css = $this->template->Css();
        // For corporate account type check
        $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));
        $data['title_page'] = lang('sb_li_1');
        $data['active_tab'] = 'profile';
        $data['active_sub_tab'] = 'tfa-security';
        $data['metadata_description'] = 'Two Factor Authentication';
        $data['metadata_keyword'] = 'ForexMart | Two Factor Authentication';
        $this->template->title('ForexMart | Two Factor Authentication')
            ->set_layout('internal/main')
            ->append_metadata_css("
                        <link rel='stylesheet' href='".$css."authenticator.css'>
                ")
            ->prepend_metadata("
               <script src='".$js."jquery.validate.js'></script>
               <script src='" . $js . "custom-tfa.js'></script>
            ")
            ->build('tfa/two_factor_auth', $data);
    }

    public function TFASetup(){
        if( ! $this->input->is_ajax_request() ){
            show_404();
        }



        $userID =  $this->session->userdata('user_id');
        $email =  $this->session->userdata('email');

        $TFASettings = $this->account_model->GetTFASettings($userID);
        if($TFASettings['isEnabled'] == 1){
            
             $viewModal = $this->load->view('tfa/tfa_verify', $TFASettings, TRUE);
        }else{
//            $this->load->library('GoogleAuthenticator');
//            $TFASecret = $this->googleauthenticator->createSecret();
//            $this->session->set_userdata('TFASecret', $TFASecret);

            if(IPLoc::VPN_IP_Jenalie()){
                $this->load->library('GoogleAuthenticator');
                $TFASecret = $this->googleauthenticator->createSecret();
                $this->session->set_userdata('TFASecret', $TFASecret);

                $QRCode = $this->googleauthenticator->getQRCodeGoogleUrl('ForexMart', $email, $TFASecret);
            }else{
                $this->load->library('GoogleAuthenticator');
                $TFASecret = $this->googleauthenticator->createSecret();
                $this->session->set_userdata('TFASecret', $TFASecret);

                $QRCode = $this->googleauthenticator->getQRCodeGoogleUrl('ForexMart', $email, $TFASecret);
            }

            $modalData['QRCodeSrc'] = $QRCode;
            $modalData['QRSecrateCode'] = $TFASecret;

            $viewModal = $this->load->view('tfa/tfa_setup', $modalData, TRUE);
        }

        echo $viewModal;

    }
    
    
    public function verifyTFAcodeManul($str) {
        
         $this->load->library('Cyrillic');
        
        if(preg_match(Cyrillic::onlyNunberAllow(), $str)) {
            if(Cyrillic::excetlenghtAllow($str,6))
            {
                return TRUE;
            }else{
                $this->form_validation->set_message('verifyTFAcodeManul','Invalid code');
            return FALSE;
            }
        } else{
           $this->form_validation->set_message('verifyTFAcodeManul','Invalid code');
            return FALSE;
        }
    }   

    public function TFASetupVerify(){

        if( ! $this->input->is_ajax_request() ){
            show_404();
        }

         
        
        
        $this->form_validation->set_rules('tfa_setup_code', 'Verification code', 'required|callback_verifyTFAcodeManul|verifyTFACode');

        if($this->form_validation->run()){

            $tfa_setup_code=$this->input->post( 'tfa_setup_code' ,true);
            $tfa_setup_code=preg_replace("/[^0-9]/", "",$tfa_setup_code);
            
             if(strlen($tfa_setup_code)==6) 
             {
            
                            $userID =  $this->session->userdata('user_id');
                            $TFASettings = $this->account_model->GetTFASettings($userID);

                            if($TFASettings['isEnabled'] == 1){
                                $isEnabled = 0;
                                $secretKey  = null;
                            }else{
                                // QR Code
                                $isEnabled = 1;
                                $secretKey  = $this->session->userdata('TFASecret');
                            }

                            $this->session->set_userdata('TFA', $isEnabled);

                            $TFASettings = array(
                                'UserID'    => $userID,
                                'isEnabled' => $isEnabled,
                                'SecretKey' => $secretKey
                            );

                            $this->account_model->saveUserTfa($TFASettings);
                            $data['HasError']   = false;


                            $this->load->model('Adminslogs_model');
                            $logsPrms = array(
                                'Action' => 'TWO_FACTOR_AUTH',
                                'Type' => $isEnabled == 1 ? 'ON' : 'OFF',
                                'Manager_IP' => $this->input->ip_address(),
                            );

                            $logsData = array(
                                'users_id' => $_SESSION['user_id'],
                                'page' => 'Transaction History - Pending Transaction Recall, Internal Cabinet',
                                'date_processed' => FXPP::getCurrentDateTime(),
                                'processed_users_id' => $_SESSION['user_id'],
                                'data' => json_encode($logsPrms),
                                'processed_users_id_accountnumber' => $_SESSION['account_number'],
                                'comment' => 'Two factor authentication',
                                'admin_fullname' => $_SESSION['full_name'],
                                'admin_email' => $_SESSION['email'],
                            );
                            $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);


               }else{
                    $data['HasError']   = true;
                    $data['Message']    = "<p>Invalid code</p>";
               }

        }else{

            $data['HasError']   = true;
            $data['Message']    = validation_errors();

        }


        echo json_encode($data);
    }
    public function verify_user_profile($user_id){
        $account_number = $this->account_model->getDetails($user_id);
        $this->load->library('Webservice');
        if(count($account_number)>0){
            $webservice_config = array(   'server' => 'live_new'  );
//            $WebService = new WebService($webservice_config);
            $data = array(  'iLogin' => $account_number[0]['account_number'] );
            $data['data'] = '';

            $WebService = FXPP::GetAllAccountDetails($account_number[0]['account_number']);

//            $WebService->request_account_details($data);
            if ($WebService['ErrorMessage'] === 'RET_OK') {
//                $info =  $WebService->get_all_result();
                $info =  (array) $WebService['Data'][0];
                $data['Apidata'] =  $info;
                $data['Dbdata'] =  $account_number[0];
                if($info['Name']!='' && $info['Email']!='' && $info['Address']!='' && $info['City']!='' && $info['State']!='' && $info['Country']!='' && $info['ZipCode']!='' && $info['PhoneNumber']!='' )
                {
                    if($account_number[0]['dob']!='0000-00-00'){
                        $data['success'] = true;
                    }else{
                        $data['success'] = false;
                        $data['data'] = 'No date of Birth';
                    }
                }else{
                    $data['success'] = false;
                    $data['data'] = 'Incomplete basic information.';
                }
            }else{
                $data['success'] = false;
                $data['data'] = 'RET_ERROR';
            }
        }else{
            $data['success'] = false;
            $data['data'] = 'ACCOUNT NUMBER DOES NOT EXIST.';
        }
        return $data;
    }

    public function upload_verification_documents($pac_ctr){
        if($this->session->userdata('logged')) {
            $isComplete = $this->verify_user_profile($this->session->userdata('user_id'));
            $data['isComplete'] = $isComplete['success'];
            $data['account_status'] = $this->account_model->getDetails($this->session->userdata('user_id'))[0]['accountstatus'];
            if($pac_ctr==''){
                $pac_ctr = $this->account_model->getPac($this->session->userdata('user_id'))->pac_ctr; //FXPP-6631
            }else{
                $data['files_read_only'] = true;
            }

            $data['reupload0'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0,$pac_ctr);//FXPP-6631
            $data['reupload1'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1,$pac_ctr);//FXPP-6631
            $data['reupload2'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2,$pac_ctr);//FXPP-6631

            $data['checkUserDocsIDfront'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0,$pac_ctr);
            $data['checkUserDocsIDback'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1,$pac_ctr);
            $data['checkUserDocsResidence'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2,$pac_ctr);
            $data['account_type_status'] = $this->user_model->getAccouTypeStatus('corporate_acc_status', 'mt_accounts_set', array('user_id' => $this->session->userdata('user_id')));

//            if($data['reupload0'] && $data['reupload1'] && $data['reupload2']){
                $data['up0'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0,$pac_ctr);//FXPP-6631
                $data['up1'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1,$pac_ctr);//FXPP-6631
                $data['up2'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2,$pac_ctr);//FXPP-6631
//            }

            $old_accounts_with_docs = $this->account_model->checkAccountUploadedDocs($this->session->userdata('user_id'));
            if($old_accounts_with_docs && $data['account_status']==2){ //Accounts who uploaded documents before the implementation of new account verification FXPP-6422
                $updatePAC = array('pac_ctr' => 1);
                $rd = $this->general_model->updatemy('users', "id", $this->session->userdata('user_id'), $updatePAC);
            }
            $data['personalver_appnum'] = $this->account_model->getDetails_new($this->session->userdata('user_id'))[0]['pac_ctr'];
            $data['hasDocs'] = $old_accounts_with_docs;
            $data['hasDeclinedDocs'] = $this->account_model->checkAccountDeclinedDocs($this->session->userdata('user_id'));
            $data['reason_for_decline'] = $this->account_model->getReasonForDeclining($this->session->userdata('user_id'),1);
            $reasons = '';
            foreach ($data['reason_for_decline'] as $key){
                $doc_type = $key['doc_type']>=1?'1':'2';
                $explanation = $key['decline_explained']==""?"N/A":$key['decline_explained'];
                $reasons .= '<tr><td>'.$doc_type.'</td>';
                $reasons .= '<td>'.$key['file_name'].'</td>';
                $reasons .= '<td>'.$this->getDeclineReason($key['decline_reason']).'</td>';
                $reasons .= '<td>'.$explanation.'</td></tr>';
            }
            $data['reason_for_decline'] = $reasons;
            $data['applicationnumber'] = $pac_ctr;
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'account-verification';
            $data['metadata_description'] = lang('accver_dsc');
            $data['metadata_keyword'] = lang('accver_kew');
            $this->template->title(lang('accver_tit'))
                ->set_layout('internal/main')
                ->build('upload_account_verification', $data);
        } else {
            redirect('signout');
        }
    }
    public function verification_documents($pac_ctr){
        if($this->session->userdata('logged')) {
            $isComplete = $this->verify_user_profile($this->session->userdata('user_id'));
//            $data['isComplete'] = $isComplete['success']?true:false;
            $data['isComplete'] = $isComplete['success'];
            $data['account_status'] = $this->account_model->getDetails($this->session->userdata('user_id'))[0]['accountstatus'];


            $data['reupload0'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0,$pac_ctr);//FXPP-6631
            $data['reupload1'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1,$pac_ctr);//FXPP-6631
            $data['reupload2'] =$this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2,$pac_ctr);//FXPP-6631

            $data['checkUserDocsIDfront'] = $this->account_model->checkUserDocs($this->session->userdata('user_id'), 0);
            $data['checkUserDocsIDback'] = $this->account_model->checkUserDocs($this->session->userdata('user_id'), 1);
            $data['checkUserDocsResidence'] = $this->account_model->checkUserDocs($this->session->userdata('user_id'), 2);
            $data['account_type_status'] = $this->user_model->getAccouTypeStatus('corporate_acc_status', 'mt_accounts_set', array('user_id' => $this->session->userdata('user_id')));

            if($data['reupload0'] && $data['reupload1'] && $data['reupload2']){
                $data['up0'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0,$pac_ctr);//FXPP-6631
                $data['up1'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1,$pac_ctr);//FXPP-6631
                $data['up2'] = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2,$pac_ctr);//FXPP-6631
            }
            $data['first_application'] = true;
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'account-verification';
            $data['metadata_description'] = lang('accver_dsc');
            $data['metadata_keyword'] = lang('accver_kew');
            $this->template->title(lang('accver_tit'))
                ->set_layout('internal/main')
                ->build('upload_account_verification', $data);
        } else {
            redirect('signout');
        }
    }
    public function reApplyForPAC(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        $user_id = $this->session->userdata('user_id');
        $dataUpdate = array('pac_ctr'=>2,'accountstatus'=>0);
        $data['personalver_appnum'] = $this->account_model->getDetails($user_id)[0]['pac_ctr'];
        $data['accountstatus'] = $this->account_model->getDetails($user_id)[0]['accountstatus'];
        $data['updateApplication']=($data['personalver_appnum']<=1) && ($data['accountstatus']==2)?$this->account_model->reApplyForPAC($user_id,$dataUpdate):false;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function uploadVerificationDocuments(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        if(!$this->session->userdata('logged')){die('Not authorized!');}
        error_reporting(E_ALL); ini_set('display_errors', 1);
        $this->load->library('image_lib');  $this->load->model('account_model');
        $user_id = $this->session->userdata('user_id');
        $checkUser = $this->account_model->checkUserDocs($user_id, $this->input->post('doc_type'));
        $old_doc = $checkUser;
        $accountstatus = $this->general_model->showssingle($table = 'users', $field = "id", $id = $this->session->userdata('user_id'), $select = "accountstatus");
        $pac_ctr = $this->account_model->getPac($user_id); //FXPP-6631
        $reUpload = $this->account_model->checkUserDocs1($this->session->userdata('user_id'), $this->input->post('doc_type'), $pac_ctr->pac_ctr);//FXPP-6631
        if ($pac_ctr->pac_ctr == 0 || $pac_ctr->pac_ctr == '' || $pac_ctr->pac_ctr == null) {
            $pac_appnum = 1;
        } else {
            if ($accountstatus['accountstatus'] ==  0 || $accountstatus['accountstatus'] ==  4) {
                $pac_appnum = $pac_ctr->pac_ctr;
            } else if (count($reUpload) >= 0 && $accountstatus['accountstatus'] == 2) {
                $pac_appnum = intval($pac_ctr->pac_ctr) + 1;
            }
        }
        $data = array();
        if (!empty($_FILES['filename']['name'])) {
            $this->load->helper(array('form', 'url'));
            $_FILES['userfile']['name'] = $_FILES['filename']['name'];
            $_FILES['userfile']['type'] = strtolower($_FILES['filename']['type']);
            $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'];
            $_FILES['userfile']['error'] = $_FILES['filename']['error'];
            $_FILES['userfile']['size'] = $_FILES['filename']['size'];
            $config['file_name']     = hash('haval192,4',$_FILES['userfile']['name']); //we do not use sha1 anymore because of sha1 hash repetition.
            $config['upload_path'] = $this->config->item('asset_user_docs');//'./assets/user_docs';
            $config['allowed_types'] = 'gif|JPG|JPEG|jpg|jpeg|png|bmp|pdf';
            $config['max_size'] = '10240';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = false; // DO NOT CHANGE
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $data['msgError'] = '';
            try {
                if ($this->upload->do_upload()) {
                    $uploadData = $this->upload->data();
                    $updData = array(
                        'user_id'     => $user_id,
                        'doc_type'    => $doc_type =$this->input->post('doc_type', true),
                        'file_name'   => $uploadData['file_name'],
                        'client_name' => $uploadData['client_name'],
                        'status'      => 0,
                        'pac_appnum'  => $pac_appnum
                    );

                    /*retun ajx filename*/
                    $data['file_name']=$uploadData['file_name'];
                    /*retun ajx filename*/

                    $config['source_image'] = $this->config->item('asset_user_docs').$uploadData['file_name'];//'./assets/user_docs/' . $uploadData['file_name'];
//                    if (substr(strtolower($uploadData['file_name']), - 3) != 'pdf') {
//                        FXPP::setWaterMark($config['source_image']);
//                    }

                    if ($this->input->post('reupload')) {
                        $ismovedformerdata =  $this->account_model->get_and_transfer_Docdata($checkUser->id); //transfer data doc in 'user_documents_replaced'
                        if($ismovedformerdata){
                            $upId = $this->account_model->update_upload_documents1($user_id, $doc_type, $updData, $checkUser->id, $pac_appnum);
                        }
                    } else {
                        $docid = $this->account_model->upload_documents($updData);
                        $dataP = array('pac_ctr' => $pac_appnum);
                        $up_pac = $this->account_model->update_pac_ctr($user_id, $dataP);
                    }
                    $upload = $this->general_model->showssingle($table = 'user_documents', $field = "id", $id = $docid, $select = "date_uploaded");
                    if ($accountstatus['accountstatus'] != 1) {
                        $data['newupload'] = array(
                            'accountstatus'     => 4,
                            'recent_fileupload' => $upload['date_uploaded'],
                            "accountstatus_update_date"=>Date('Y-m-d H:i:s'),
                            "accountstatus_update_location"=>'my_3',
                            "accountstatus_update_by_user_id"=>$_SESSION['user_id'] 
                        );
//                        if($this->session->userdata('user_id')==208598){ print_r($data['new_upload']); }
                        $rd = $this->general_model->updatemy('users', "id", $this->session->userdata('user_id'), $data['newupload']);
//                        $data['recent_date'] = $rd?date('Y-m-d H:i:s'):'users.recent_fileupload not updated.';
                        $rd = $rd ? 'true' : 'false';
                        //print_r($rd);exit;
                    }
                    //FXPP-6632
                    $check0 = count($this->account_model->checkUserDocs1($this->session->userdata('user_id'), 0, $pac_appnum));//FXPP-6632
                    $check1 = count($this->account_model->checkUserDocs1($this->session->userdata('user_id'), 1, $pac_appnum));//FXPP-6632
                    $check2 = count($this->account_model->checkUserDocs1($this->session->userdata('user_id'), 2, $pac_appnum));//FXPP-6632
                    if ($check0 > 0 && $check1 > 0 && $check2 > 0) {
                        $dataP = array('accountstatus' => 0); //New status for moving to pending
                        $this->account_model->update_pac_ctr($user_id, $dataP);
                    }
                    $data['error'] = false;
                    $data['msgError_ext'] = false;
                } else {
                    $data['msgError'] = $this->upload->display_errors();
                    $data['error'] = true;
                    //http://php.net/manual/en/function.exif-imagetype.php
                    $data['filetype'] = exif_imagetype($_FILES['filename']['tmp_name']);
                    $data['filetype2'] = strtolower($_FILES['filename']['type']);
                    $data['msgError_ext'] = false;
                    switch (strtolower($_FILES['filename']['type'])) {
                        case 'image/gif':
                            if (exif_imagetype($_FILES['filename']['tmp_name']) == 1) {

                            } else {
                                $data['msgError_ext'] = true;
                                $data['msgError'] = "There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        case 'image/jpeg':
                            if (exif_imagetype($_FILES['filename']['tmp_name']) == 2) {

                            } else {
                                $data['msgError_ext'] = true;
                                $data['msgError'] = "There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        case 'image/png':
                            if (exif_imagetype($_FILES['filename']['tmp_name']) == 3) {

                            } else {
                                $data['msgError_ext'] = true;
                                $data['msgError'] = "There's an issue with the format of the file. Please open it in any photo editing software (e.g. paint) and save it as gif , jpg or png file.";
                            }
                            break;
                        default:
                    }
                }
            } catch (Exception $e) {
                $data['msgError_ext'] = false;
                if (strpos($e->getMessage(), 'pdf') !== false) {
                    $data['msgError'] = "The PDF file type that you uploaded is not supported.";
                } else {
                    $data['msgError'] = $e->getMessage();
                }
                $data['error'] = true;
            }
        } else {
            $data['msgError'] = 'Please select a file.';
            $data['error'] = true;
        }
        $this->checkToMove();
        $update_history_data = array(
            'user_id' => $this->session->userdata('user_id'),
            'manager_id' => 0,
            'update_url' =>FXPP::loc_url('profile/uploadVerificationDocuments'),
            'date_modified' => date('Y-m-d H:i:s', strtotime("now"))
        );
        $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
        if ($update_history_id) {
            $new_doc = $this->account_model->checkUserDocs($user_id, $this->input->post('doc_type'));
            $update_history_field_data = array(
                'field' => "",
                'old_value' => $old_doc->client_name ." - file: ".$old_doc->file_name,
                'new_value' => $new_doc->client_name ." - file: ".$new_doc->file_name,
                'date_modified' => FXPP::getCurrentDateTime(),
                'update_id' => $update_history_id
            );
            $this->account_model->insertAccountUpdateFieldHistory1($update_history_field_data);
        }
        $data['log'] = array(
            'user_id' => $_SESSION['user_id'],
            'doc_type' => $old_doc->doc_type,
            'file_name' => $old_doc->file_name,
            'client_name' => $old_doc->client_name,
            'status' => $old_doc->status,
            'date_uploaded' => $old_doc->date_uploaded,
            'decline_reason' => $old_doc->decline_reason,
            'decline_explained' => $old_doc->decline_explained,
            'uploadset' => $old_doc->uploadset,
            'date_approved' => $old_doc->date_approved,
            'date_declined' => $old_doc->date_declined,
            'admn_upload_userid' =>$old_doc->admn_upload_userid,
            'user_type' => $old_doc->user_type,
            'pac_appnum' => $old_doc->pac_appnum,
            'date_replaced' => FXPP::getCurrentDateTime() ,
            'link_replaced' => FXPP::loc_url('profile/upload-verification-documents'),
        );
        $this->account_model->insertlog($table = "document_history", $data['log']);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function checkToMove(){
        $user_id = $this->session->userdata('user_id');
        $doc0 = $this->account_model->checkUserDocs($user_id,0);
        $doc1 = $this->account_model->checkUserDocs($user_id,1);
        $doc2 = $this->account_model->checkUserDocs($user_id,2);

    }
    public function getDeclineReason($num)
    {
        switch ($num) {
            case 0:
                $reason = 'Account holder did not reached the age limit.';
                break;
            case 1:
                $reason = 'Address provided and address on document do not match.';
                break;
            case 2:
                $reason = 'Document is altered or modified without proper certification from issuer.';
                break;
            case 3:
                $reason = 'Document is corrupt and cannot be opened.';
                break;
            case 4:
                $reason = 'Document is expired.';
                break;
            case 5:
                $reason = 'Document is password protected.';
                break;
            case 6:
                $reason = 'Document presented page mismatch.';
                break;
            case 7:
                $reason = 'Document presented shows a photo without identity details.';
                break;
            case 8:
                $reason = 'Document presented shows no proof of identity.';
                break;
            case 9:
                $reason = 'Document scanned from the wrong side.';
                break;
            case 10:
                $reason = 'Document shows lack of issuer signatures.';
                break;
            case 11:
                $reason = 'Document shows no country of issuance.';
                break;
            case 12:
                $reason = 'Document shows no signature of the account holder.';
                break;
            case 13:
                $reason = 'Invalid document.';
                break;
            case 14:
                $reason = 'Low resolution scanned document.';
                break;
            case 15:
                $reason = 'Missing pages on scanned document.';
                break;
            case 16:
                $reason = 'Name of the account holder and name on the document mismatch.';
                break;
            case 17:
                $reason = 'No images found on the scanned document.';
                break;
            case 18:
                $reason = 'No second document submitted.';
                break;
            case 19:
                $reason = 'Poor quality scanned document.';
                break;
            case 20:
                $reason = 'Document shows no signature of the account holder.';
                break;
            case 21:
                $reason = 'Same document submitted on the previous.';
                break;
            case 22:
                $reason = 'Translation required.';
                break;
        }
        return $reason;

    }

    public function sendPasswordtest(){
        $datum['changepassword'] = array(
            'account_number' => '',
            'Email' => '',
            'new_password' => '',
            'type' => 0,
        );
        $this->load->library('fx_mailer');
        $this->fx_mailer->change_password($datum['changepassword']);
    }
	
	public function edit()
    { 
        if($this->session->userdata('logged')) {

            //if (IPLoc::OnlyTest2()){

                $user_id = $this->session->userdata('user_id');

                $getUserEmailByUserId = $this->account_model->getUserEmailByUserId($user_id);

                // Get user general information
                $user_profile = $this->user_model->getUserProfileByUserId( $user_id );
                // Get user contact information
                $user_contact = $this->contact_model->getUserContactByUserId( $user_id );
                // Get countries array
                $countries = $this->general_model->getCountries();
                
              
                $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=>$user_id));
                $this->session->set_userdata(array('corporate_acc_status'=>$data['data']['account_type_status']->corporate_acc_status));
                

                $getFirstPhoneCodeByUserId = $this->account_model->getFirstPhoneCodeByUserId($user_id);

                $getSecondPhoneCodeByUserId = $this->account_model->getSecondPhoneCodeByUserId($user_id);
                $user_data = array(
                    'name' => '',
                    'address' => '',
                    'city' => '',
                    'state' => '',
                    'zip_code' => '',
                    'telephone' => array('',''),
                    'email' => array('','',''),
                    'contact_time' => '',
                    'country' => '',
                    'image' => '',
                    'dob' => ''
                );

                if( $user_profile !== false ){
                    $user_data['name'] = $user_profile['full_name'];
                    $user_data['address'] = $user_profile['street'];
                    $user_data['city'] = $user_profile['city'];
                    $user_data['state'] = $user_profile['state'];
                    $user_data['zip_code'] = $user_profile['zip'];
                    $user_data['country'] = $user_profile['country'];
                    $user_data['image'] = $user_profile['image'];
                    $user_data['preferred_time'] = $user_profile['preferred_time'];
                    $user_data['email1'] = $getUserEmailByUserId[0]['email'];
                    $user_data['sms_code_1'] = $getFirstPhoneCodeByUserId[0]['sms_code_1'];
                    $user_data['phone_verified_1'] = $getFirstPhoneCodeByUserId[0]['phone_verified_1'];
                    $user_data['sms_code_2'] = $getSecondPhoneCodeByUserId[0]['sms_code_2'];
                    $user_data['phone_verified_2'] = $getSecondPhoneCodeByUserId[0]['phone_verified_2'];
                    $user_data['skype'] = $user_profile['skype'];
                    $user_data['dob'] = $user_profile['dob'];

                    if(IPLoc::Office()){
                        $user_data['fb'] = $user_profile['fb'];
                        $user_data['social_media_type'] = $user_profile['social_media_type'];
                    }
                }

                if( $user_contact !== false ){
                    $user_data['telephone1'] = $user_contact['phone1'];
                    $user_data['telephone2'] = $user_contact['phone2'];
                    $user_data['email2'] = $user_contact['email2'];
                    $user_data['email3'] = $user_contact['email3'];
                }

                $user_data['email'][0]  = $getUserEmailByUserId[0]['email'];

                // Store Data for view
                $data['countries'] = $countries;
                $data['user_data'] = $user_data;

                $has_request = false;
                if($this->user_model->deleteExpiredProfileRequests()) {
                    $has_request = $this->user_model->hasProfileRequests($user_id);
                }
                $date_change = '';
                if($has_request){
                    $date_change_data = $this->user_model->getProfileChangeDateLastRequest($user_id);
                    if($date_change_data === false){
                        $date_change = '';
                    }else{
                        $date_change = date('D, d M Y H:i:s', strtotime($date_change_data));
                    }
                }
                // Render Edit Profile View
                $js = $this->template->Js();
                $data['has_request'] = $has_request;
                $data['date_change_alert'] = $date_change;

                $data["data"] = $this->input->get();
                

                $data['title_page'] = lang('sb_li_1');
                $data['active_tab'] = 'profile';
                $data['active_sub_tab'] = 'personal-details';
                $data['metadata_description'] = lang('perdet_dsc');
                $data['metadata_keyword'] = lang('perdet_kew');
                
                $this->template->title(lang('perdet_tit'))
                    ->set_layout('internal/main')
                    ->prepend_metadata("
                        <script src='" . $js . "/custom-profile.js'></script>
                            ")
                    ->build('edit_profile', $data);

            //}

        }else{
            redirect('signout');
        }
    }

    public function SendSMS(){

        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){

            $table = "users";
            $user_id = $this->session->userdata('user_id');
            $phone = $this->input->post('tel');
            $sms_code = rand(1000,9999);
            //echo "sms code: $sms_code";

            $sms = new CheckMobiRest();
            $sms->setTo($phone);
            $sms->setText("Your Security Code is ".$sms_code);
            $return_data = $sms->SendSMS();
            var_dump($return_data);

            $user_data = array(
                'sms_code_1'=> $sms_code,
                'sms_record_1' =>$return_data->id,
            );
           $this->general_model->phone_verified($table, $user_id, $user_data);


        }
    }


    public function SendSMSTest(){

        //if($this->input->is_ajax_request() && $this->session->userdata('logged') ){

            $table = "users";
            $user_id = $this->session->userdata('user_id');
            $phone = +8801873330895;
            $sms_code = rand(1000,9999);
           // echo "sms code: $sms_code";

            $sms = new CheckMobiRest();
//            $sms->setTo($phone);
//            $sms->setText("Your Security Code is ".$sms_code);
            $return_data = $sms->SendSMSTest();
            var_dump($return_data);

//            $user_data = array(
//                'sms_code_1'=> $sms_code,
//                'sms_record_1' =>$return_data->id,
//            );
//            $this->general_model->phone_verified($table, $user_id, $user_data);


        //}
    }

    public function number_verification(){

        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){

            $user_id = $this->session->userdata('user_id');
            $sms_code = $this->input->post('sms_code');
            $table = "users";
            $get_data = $this->general_model->showssingle($table, "id", $user_id, "sms_code_1"," ");

            if ($get_data['sms_code_1'] == $sms_code){
                $user_data = array(
                    'phone_verified_1' =>"1"
                );
                $suc_udate = $this->general_model->phone_verified($table, $user_id, $user_data);

                if ($suc_udate){
                    echo json_encode(array('success'=>true));
                }

            }else{
                echo json_encode(array('success'=>false));
            }
        }

    }

    public function SendSMS2(){

        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){
            $table = "users";
            $user_id = $this->session->userdata('user_id');
            $phone2 = $this->input->post('tel2');
            $sms_code2 = rand(1000,9999);
            echo "sms code: $sms_code2";

            $sms = new CheckMobiRest();
            $sms->setTo($phone2);
            $sms->setText("Your Security Code is ".$sms_code2);
            $return_data = $sms->SendSMS();
            var_dump($return_data);

            $user_data = array(
                'sms_code_2'=> $sms_code2,
                'sms_record_2' =>$return_data->id,
            );
            $this->general_model->phone_verified($table, $user_id, $user_data);

        }
    }

    public function number_verification2(){

        if($this->input->is_ajax_request() && $this->session->userdata('logged') ){

            $user_id = $this->session->userdata('user_id');
            $sms_code2 = $this->input->post('sms_code_2');
            $table = "users";
            $get_data = $this->general_model->showssingle($table, "id",$user_id, "sms_code_2"," ");

            if ($get_data['sms_code_2'] == $sms_code2){
                $user_data = array(
                    'phone_verified_2' =>"1"
                );
                $suc_udate = $this->general_model->phone_verified($table, $user_id, $user_data);
                if ($suc_udate){
                    echo json_encode(array('success'=>true));
                }
            }else{
                echo json_encode(array('success'=>false));
            }
        }
    }

    public function checkCurrentPassword($current_pass){

        $this->load->library('WSV');
        $WSV = new WSV();

        $param['currentMasterPass'] = $current_pass;
        $check_current_pass = $WSV->CheckPassword($param);

        if($check_current_pass !== 'RET_OK') {
            $this->form_validation->set_message('checkCurrentPassword', lang('error_pass_msg'));
            return false;
        }else{
            return true;
        }

    }

    public function checkNewPassword($new_pass){

        $this->load->library('WSV');
        $WSV = new WSV();

        $param['currentMasterPass'] = $new_pass;
        $checkCurrentPass = $WSV->CheckPassword($param);

        if($checkCurrentPass == 'RET_OK') {
            $this->form_validation->set_message('checkNewPassword', 'Current Password and New Password must not be the same.');
            return false;
        }else{
            return true;
        }

    }

    public function confirmPassword($confirm_pass, $new_pass){

        if($confirm_pass !== $new_pass) {
            $this->form_validation->set_message('confirmPassword', 'New Password and Confirm Password must match.');
            return false;
        }else{
            return true;
        }

    }

    public function change_password(){ //new version

        if ($this->session->userdata('logged')) {

            $this->load->library('Form_key');
            error_reporting(E_ALL);

            ini_set('display_errors', 1);
            $data = array();

            if(Form_key::isValid(trim($this->input->post('form_key',true)))) {

                $this->load->library('form_validation');
                $this->load->library('password_hash');

                $this->form_validation->set_rules('old_password',     'Current Password', 'trim|required|xss_clean|callback_checkCurrentPassword');

                if($this->form_validation->run()){

                    $old_pass = $this->input->post('old_password');
                    $new_pass = $this->input->post('new_password');

                    $this->form_validation->set_rules('new_password',     'New Password',     'trim|required|xss_clean|callback_checkNewPassword');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', "trim|required|xss_clean|callback_confirmPassword[$new_pass]");

                    if($this->form_validation->run()) {


                        $number_of_change_password = FXPP::getAllowNumberOfChangePassV2(false);


                        if(!$number_of_change_password) {

                            $this->load->model('general_model');
                            $this->load->model('user_model');
                            $email = $this->user_model->getUserEmail($_SESSION['user_id']); //FXMAIN-94

                            $this->load->library('WSV'); //New web service
                            $WSV = new WSV();

                            $param['currentMasterPass'] = $old_pass;
                            $param['newPassword'] = $new_pass;
                            $WebService = $WSV->ChangeUserMasterPasswordV2($param);

                            switch($WebService){

                                case 'RET_OK':

                                    $this->load->library('password_hash');
                                    $hash_password = $this->password_hash->change_password($old_pass, $new_pass);
                                    $this->user_model->change_password($_SESSION['user_id'], (string)$hash_password);

                                    $datax['update'] = array(
                                        'trader_password' => $new_pass
                                    );
                                    $this->general_model->updatemy($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $datax['update']);

                                    $data['success'] = true;
                                    $data['msg'] = 'success';

                                    $datum['changepassword'] = array(
                                        'account_number' => $_SESSION['account_number'],
                                        'Email' => $email,
                                        'new_password' => $new_pass,
                                        'type' => 0,
                                    );
                                    $this->load->library('fx_mailer');
                                    $this->fx_mailer->change_password_v2($datum['changepassword']);

                                    $datum_3657 = array(
                                        'change_password_status' => 1,
                                        'change_password_date' => FXPP::getCurrentDateTime(),
                                        'change_password_attempts' => 0,
                                        'number_of_change_password' => 1
                                    );
                                    $this->general_model->updatemy($table = 'users', $field = 'id', $id = $_SESSION['user_id'], $datum_3657);
                                    break;

                                case 'RET_INVALID_PARAMETERS':

                                    $data['success'] = false;
                                    $data['tank_error'] = "Password should be not less than 7 symbols, contain letters and numbers.";
                                    break;

                                default:
                                    $data['success'] = false;
                                    $data['tank_error'] = "System Failure. Please try again. $WebService";
                                    break;

                            }

                            $this->load->model('Adminslogs_model');

                            $logsPrms = array(
                                'Api_req' => $WebService,
                                'Action' => 'CHANGE_PASSWORD',
                                'Manager_IP' => $this->input->ip_address(),
                            );

                            $logsData = array(
                                'users_id'           => $_SESSION['user_id'],
                                'page'               => 'profile/change-password',
                                'date_processed'     => FXPP::getCurrentDateTime(),
                                'processed_users_id' => $_SESSION['user_id'],
                                'data'               => json_encode($logsPrms),
                                'processed_users_id_accountnumber' => $_SESSION['account_number'],
                                'comment'            => 'Change password',
                                'admin_fullname'     => $_SESSION['full_name'],
                                'admin_email'        => $email,
                            );
                            $this->Adminslogs_model->insertmy($table = "admin_log", $logsData);

                        }else{

                            $data['success'] = false;
                            $data['tank_error'] = lang('max_pass_msg');

                        }

                    }
                }


            }

            $data['data']['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=> $this->session->userdata('user_id')));
            $data['form'] = Form_key::InputKey_array();
            $data['title_page'] = lang('sb_li_1');
            $data['active_tab'] = 'profile';
            $data['active_sub_tab'] = 'change-password';
            $data['metadata_description'] = lang('chapas_dsc');
            $data['metadata_keyword'] = lang('chapas_kew');

            $JS = $this->template->Js();
            $this->template->title(lang('chapas_tit'))
                ->set_layout('internal/main')
                ->prepend_metadata("
                        <script src='" . $JS . "pwstrength.js'></script>
                        <script src='" . $JS . "bootbox.min.js'></script>
                        <script src='" . $JS . "jquery.validate.js'></script>
                            ")
                ->build('change_password_v2', $data);
        }else{
            redirect('signout');
        }


    }

    public function generatePassword(){
        if ($this->input->is_ajax_request()) {

            $this->load->library('PasswordGenerator');
            $password = new PasswordGenerator(10, 1, 'lower_case,numbers,upper_case,special_symbols');

            if($password->getLength() < 7){
                $password2 = new PasswordGenerator(10, 1, 'lower_case,numbers,upper_case,special_symbols');
                $result = $password2->generate();
            }else{
                $result = $password->generate();
            }

            if(ctype_alpha($result)){
                $result = $this->generatePasswordV2(7);
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('password' => $result)));

        }else{
            show_404();
        }
    }

    public function generatePasswordV2($maxLength = 10) {

        $length 	= rand(7,$maxLength);
        $aSymbols	= 'abcdefghijklmnoprstuvwxyz0123456789ABCDEFGHIJKLMNOPRSTUVWXYZ@#$%!';
        $password	= '';

        for($i = 0; $i<$length; $i++) {
            $password .= $aSymbols[rand(0,strlen($aSymbols)-1)];
        }
        return $password;
    }

}
?>