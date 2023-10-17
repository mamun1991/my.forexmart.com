<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    private $country_code;


    public function __construct(){
        parent::__construct();
        $this->load->model('account_model');
        $this->load->model('partners_model');

        //for advertisement cookie
                $this->load->model('General_model');
                $this->g_m=$this->General_model;
                if($this->session->userdata('logged')){
                    $data['cookie'] = array(
                        'name'   => 'fullname',
                        'value'  => $_SESSION['full_name'],
                        'expire' => time() + (10 * 365 * 24 * 60 * 60),
                        'domain' => '.forexmart.com',
                        'secure' => true,
                        'path'   => '/',
                        'prefix' => '',
                        'httponly' => true,
                    );

                    $this->input->set_cookie($data['cookie'],true);

                    $nodepositbonus = $this->g_m->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='nodepositbonus,created,createdforadvertising');

                    $data['cookie']['name']='nodepositbonus';
                    $data['cookie']['value']=$nodepositbonus['nodepositbonus'];

                    $this->input->set_cookie($data['cookie'],true);
                    if(is_null($nodepositbonus['createdforadvertising'])){
                        $data['datecreated']=$nodepositbonus['created'];
                    }else{
                        $data['datecreated']=$nodepositbonus['createdforadvertising'];
                    }
                    $datecreated=DateTime::createFromFormat('Y-m-d H:i:s',$data['datecreated']);
                    $datedifference=$this->g_m->difference_day($datecreated->format('Y-m-d'),$datecurrent=date('Y-m-d'));
                    $data['cookie']['name']='datedifference';
                    $data['cookie']['value']=$datedifference;

                    $this->input->set_cookie($data['cookie'],true);
                    unset($data['cookie']);
                    unset($data);
                }
        //for advertisement cookie

        $this->country_code = FXPP::getUserCountryCode() or null;

    }

    public function index() {
        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);
            $user_id = $this->session->userdata('user_id');

            if( $user_id ){
                //AN for account number
                //AN_type account type 0 Demo 1 Live 2 Partner
                if($this->session->userdata('login_type') == 1){
                    // Partnership accounts
                    $accounts = $this->partners_model->getPartnersByUserId($user_id);
                    $data['p_status'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='accountstatus');
                    $data['AN_type']=2;

                }else {
                    // Live and Demo accounts
                    $accounts = $this->account_model->getAccountsByUserId($user_id);
                    $data['users'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='type,nodepositbonus');
                    $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='account_number');
                    $data['AN_type'] = $data['users']['type']; // 0 demo 1 live
                    $data['AN'] = $data['mtas'] ['account_number'];

                    foreach( $accounts as $key => $value ){
                        $accounts[$key]['account_type'] = $this->general_model->getAccountType( $value['mt_account_set_id'] );
                    }
                }
                $data['accounts'] = $accounts;
                /**  FXPP-893 to remove*/
                //                $data['mt_type'] = $this->getAccountDetails('mt_type');
                //                $data['mt_currency_base'] = $this->getAccountDetails('mt_currency_base');
                //                $data['mt_account_set_id'] = $this->getAccountDetails('mt_account_set_id');

            }else{
                $data['accounts'] = array();
            }

            $this->load->model('user_model');
            $user = $this->user_model->getUserProfileByUserId($user_id);
            if(in_array(strtoupper($user['country']), array('PL'))){
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100));
            }else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage());
            }

            if(IPLoc::VPN_IP_Jenalie()){
                $data['leverage'] = 0;
            }

            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'accounts';
            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = 'This section enables management of different accounts, checking of current trades and history of trades, and usage of forex calculator';
            $this->template->title("ForexMart | My Account")
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('dashboard', $data);

        }else{
            redirect('signout');
        }
    }
    public function register(){
        if($this->session->userdata('logged')){
            $this->lang->load('register');
            $user_id = $this->session->userdata('user_id');
            if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())>0){
                redirect('my-account');
            }

            $this->form_validation->set_rules('employment_status', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('estimated_annual_income', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('education_level', 'Leverage', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {

                $user = array(
                    'affiliate_code'=> $this->input->post("affiliate_code",true)
                );
                if(IPLoc::Office()){
                $email = $this->session->userdata('email');
                    $this->partners_model->updateStatus('invite_friends',$email);
                }
                $this->general_model->update('users','id',$user_id,$user);

                // employment_status,industry,source_of_funds,estimated_annual_incomeestimated_net_worth,politically_exposed_person,education_level,user_id
                $employment_detail = array(
                    'employment_status' => $this->input->post('employment_status',true),
                    'industry' => $this->input->post('industry',true),
                    'source_of_funds' => $this->input->post('source_of_funds',true),
                    'estimated_annual_income' => $this->input->post('estimated_annual_income',true),
                    'estimated_net_worth' => $this->input->post('estimated_net_worth',true),
                    'politically_exposed_person' => $this->input->post('politically_exposed_person',true),
                    'education_level' => $this->input->post('education_level',true),
                    'us_resident' => $this->input->post('us_resident',true),
                    'us_citizen' => $this->input->post('us_citizen',true),
                    'user_id' => $user_id
                );
                $this->general_model->insert('employment_details', $employment_detail);


                // Registration Upload Documents
                if(!empty($_FILES['filename']['name'])) {
                    $this->load->helper(array('form', 'url'));
                    $cpt = count($_FILES['filename']['name']);
                    for($i=0; $i<$cpt; $i++) {
                        if(!empty($_FILES['filename']['name'][$i])){
                            $_FILES['userfile']['name'] = $_FILES['filename']['name'][$i];
                            $_FILES['userfile']['type'] = strtolower($_FILES['filename']['type'][$i]);
                            $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
                            $_FILES['userfile']['error'] = $_FILES['filename']['error'][$i];
                            $_FILES['userfile']['size'] = $_FILES['filename']['size'][$i];

                            $config['file_name'] = sha1($_FILES['userfile']['name'][$i]);
//                            $config['upload_path'] = './assets/user_docs';
                            $config['upload_path'] = $this->config->item('asset_user_docs');//'/var/www/svn1/assets/user_docs/';
                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
                            $config['max_size'] = '10000';
                            $config['max_width'] = '0';
                            $config['max_height'] = '0';
                            $config['overwrite'] = false;
                            $this->load->library('upload', $config);
                            //                     Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
                            $this->upload->initialize($config);
                            if($this->upload->do_upload()) {
                                $uploadData = $this->upload->data();
                                $updData = array(
                                    'user_id' => $user_id,
                                    'doc_type' => $i,
                                    'file_name' => $uploadData['file_name'],
                                    'client_name' => $uploadData['client_name']
                                );
                                $config['source_image'] = $this->config->item('asset_user_docs').$uploadData['file_name'];// './assets/user_docs/'. $uploadData['file_name'];

                                FXPP::setWaterMark($config['source_image']);
                                $this->general_model->insert('user_documents', $updData);
                            }
                        }
                    }
                }

                $this->db->trans_complete();
                redirect('my-account');


            }

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(),$this->country_code);
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType(),1);
            $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase(),"USD");
            $this->load->model('user_model');
            $user = $this->user_model->getUserProfileByUserId($user_id);
            if(in_array(strtoupper($user['country']), array('PL'))){
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100), "1:100");
            }else {
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(),"1:200");
            }
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(),0);
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getIndustry());
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds());
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome(),3);
            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth(),3);
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(),1);
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel());
            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration());

            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'accounts';
            $this->template->title("ForexMart | My Account")
                ->set_layout('internal/main')
                ->build('auth/register_live2', $data);

        }else{
            redirect('signout');
        }
    }
    public function current_trades(){

        if($this->session->userdata('logged')){
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
            $account_info = array(
                'iLogin' => $data['mtas']['account_number']
            );
            $WebService->open_GetAccountActiveTrades($account_info);
            switch($WebService->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('TradeDataList');
                    if($tradatalist){
                        $opened='';
                        foreach ( $tradatalist['TradeData'] as $object){
                            $opened.='<tr>';
                            $opened.='<td>'.$object->OrderTicket.'</td>';
                            $opened.='<td>'.$object->TradeType.'</td>';
                            $opened.='<td>'.$object->Volume.'</td>';
                            $opened.='<td>'.$object->Symbol.'</td>';
                            $opened.='<td>'.$object->OpenPrice.'</td>';
                            $opened.='<td>'.$object->StopLoss.'</td>';
                            $opened.='<td>'.$object->TakeProfit.'</td>';
                            $opened.='<td>'.$object->ClosePrice.'</td>';
                            $opened.='<td>N/A</td>';
                            $opened.='<td>'.$object->Profit.'</td>';
                            $opened.='</tr>';
                        }

                        $data['Opened']= $opened;
                    }else{
                        $data['Opened']='';
                    }
                    break;
                default:
                    $data['data']['error']=true;
            }

            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'current-trades';
            $data['active_sub_sub_tab'] = 'current_trades';
            $data['metadata_description'] = 'Examine all current trades and pending orders.';
            $this->template->title("ForexMart | Current Trades")

                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")
                ->set_layout('internal/main')
                ->build('current_trades', $data);

        }else{
            redirect('signout');
        }
    }

// pending order get in curretn treads tab [FZ]    
    public function pendingOrders(){

        if($this->session->userdata('logged')){
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
            $account_info = array(
                'iLogin' =>$data['mtas']['account_number']
               // 'iLogin' =>'101926'
                    
            );
            $WebService->GetAccounPendingOrders($account_info);
            switch($WebService->request_status){
                case 'RET_OK':
                    $tradatalist = (array) $WebService->get_result('TradeDataList');                 
                    if($tradatalist){
                        $opened='';
                        foreach ( $tradatalist['TradeData'] as $object){
                            $opened.='<tr>';
                            $opened.='<td>'.$object->OrderTicket.'</td>';
                            $opened.='<td>'.$object->TradeType.'</td>';
                            $opened.='<td>'.number_format((float) $object->Volume,2).'</td>';
                            $opened.='<td>'.$object->Symbol.'</td>';
                            $opened.='<td>'.$object->OpenPrice.'</td>';
                            $opened.='<td>'.number_format((float) $object->StopLoss,5).'</td>';
                            $opened.='<td>'.number_format((float) $object->TakeProfit,5).'</td>';
                            $opened.='<td>'.$object->ClosePrice.'</td>';
                            $opened.='<td>N/A</td>';
                            $opened.='<td>'.number_format((float) $object->Profit,5).'</td>';
                            $opened.='</tr>';
                        }

                        $data['Opened']= $opened;
                    }else{
                        $data['Opened']='';
                    }
                    break;
                default:
                    $data['data']['error']=true;
            }

            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'current-trades';
            $data['active_sub_sub_tab'] = 'pending_orders';
            $this->template->title("ForexMart | Pending Orders")

                ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")
                ->set_layout('internal/main')
                    
                ->build('pending_orders', $data);

        }else{
            redirect('signout');
        }
    } 
                
                
    
    
    
    public function history_of_trades(){
        if($this->session->userdata('logged')){

            if($_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933'){
                print_r('test');
                $this->NewGetOpenTrades();
            }else{
                $data['active_tab'] = 'accounts';
                $data['active_sub_tab'] = 'history-of-trades';
                $data['metadata_description'] = 'Review all closed and cancelled deals for a specific time period.';
                $this->template->title("ForexMart | History of Trades")
                    ->append_metadata_css("
                       <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."loaders.css'>
                       <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('history_of_trades',$data);
            }

        }else{
            redirect('signout');
        }
    }

public function HistoryOfTrades(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

            $data['from'] = DateTime::createFromFormat('Y/d/m', $this->input->post('from',true));
            $data['none'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', $this->input->post('to',true).' 23:59:59');

        $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $data['data']['accountnumber']=$data['mtas']['account_number'];
        $account_info = array(
            'iLogin' => $data['mtas']['account_number'],
           // 'iLogin' =>'101491',
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):Null ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):Null
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_GetAccountTradesHistory($account_info);
        switch($WebService->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebService->get_result('TradeDataList');
                if($tradatalist){
                    $closed='';
                    foreach ( $tradatalist['TradeData'] as $object){
                        $closed.='<tr>';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'.$object->Volume.'</td>';
                        $closed.='<td>'.$object->Symbol.'</td>';
                        $closed.='<td>'.$object->OpenPrice.'</td>';
                        $closed.='<td>'.$object->StopLoss.'</td>';
                        $closed.='<td>'.$object->TakeProfit.'</td>';
                        $closed.='<td>'.$object->ClosePrice.'</td>';
                        $closed.='<td>N/A</td>';
                        $closed.='<td>'.$object->Profit.'</td>';
                        $closed.='</tr>';
                    }
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= $closed;
                }else{
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= '';
                }
                break;
            default:
                $data['data']['error']=true;
        }
        $account_info2 = array(
            'iLogin' => $data['mtas']['account_number'],
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):$data['none']->format('Y-m-d\TH:i:s') ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):$data['none']->format('Y-m-d\TH:i:s')
        );
        $WebServiceBalOpe = new WebService($webservice_config);
        $WebServiceBalOpe->open_RequestAccountFinanceRecordsByDate($account_info2);

        switch($WebServiceBalOpe->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebServiceBalOpe->get_result('FinanceRecords');

                if($tradatalist){
                    $holder1='';
                    $holder2='';
                    $holder3='';
                    $holder4='';
                    $data['data']['bonus']=false;
                    $data['data']['deposit']=false;
                    $data['data']['withdraw']=false;
                    $data['data']['transfer']=false;
                    foreach ( $tradatalist['FinanceRecordData'] as $object){

                        if ($object->FundType=='BONUS'){
                            $data['data']['bonus']=true;
                            $holder1.='<tr>';
                            $holder1.='<td>'.$object->Ticket.'</td>';
                            $holder1.='<td>'.$object->FundType.'</td>';
                            $holder1.='<td>'.$object->Amount.'</td>';
                            $holder1.='<td>'.$object->Status.'</td>';
                            $holder1.='<td>'.$object->Stamp.'</td>';
                            $holder1.='<td>'.$object->Operation.'</td>';
                            $holder1.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_DEPOSIT'){
                            $data['data']['deposit']=true;
                            $holder2.='<tr>';
                            $holder2.='<td>'.$object->Ticket.'</td>';
                            $holder2.='<td>'.$object->FundType.'</td>';
                            $holder2.='<td>'.$object->Amount.'</td>';
                            $holder2.='<td>'.$object->Status.'</td>';
                            $holder2.='<td>'.$object->Stamp.'</td>';
                            $holder2.='<td>'.$object->Operation.'</td>';
                            $holder2.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_WITHDRAW'){
                            $data['data']['withdraw']=true;
                            $holder3.='<tr>';
                            $holder3.='<td>'.$object->Ticket.'</td>';
                            $holder3.='<td>'.$object->FundType.'</td>';
                            $holder3.='<td>'.$object->Amount.'</td>';
                            $holder3.='<td>'.$object->Status.'</td>';
                            $holder3.='<td>'.$object->Stamp.'</td>';
                            $holder3.='<td>'.$object->Operation.'</td>';
                            $holder3.='</tr>';

                        }
                        if ($object->Operation=='REAL_FUND_TRANSFER'){
                            $data['data']['transfer']=true;
                            $holder4.='<tr>';
                            $holder4.='<td>'.$object->Ticket.'</td>';
                            $holder4.='<td>'.$object->FundType.'</td>';
                            $holder4.='<td>'.$object->Amount.'</td>';
                            $holder4.='<td>'.$object->Status.'</td>';
                            $holder4.='<td>'.$object->Stamp.'</td>';
                            $holder4.='<td>'.$object->Operation.'</td>';
                            $holder4.='</tr>';
                        }
                    }
                    $data['data']['BalOpe_bonus'] = $holder1;
                    $data['data']['BalOpe_deposit'] = $holder2;
                    $data['data']['BalOpe_withdraw'] = $holder3;
                    $data['data']['BalOpe_transfer'] = $holder4;
                }else{
                    $data['data']['BalOpe_bonus'] = '';
                    $data['data']['BalOpe_deposit'] = '';
                    $data['data']['BalOpe_withdraw'] = '';
                    $data['data']['BalOpe_transfer'] = '';
                }
                break;
            default:
                $data['data']['error2']=true;
                $data['data']['bonus']=false;
                $data['data']['deposit']=false;
                $data['data']['withdraw']=false;
                $data['data']['transfer']=false;
        }

        echo json_encode($data['data']);
        unset($data);

    }

    
   public function CancelledPendingOrders(){

        if(!$this->input->is_ajax_request()){die('Not authorized!');}

            $data['from'] = DateTime::createFromFormat('Y/d/m', $this->input->post('from',true));
            $data['none'] = DateTime::createFromFormat('Y/d/m', date('2015/5/5'));
            $data['to'] = DateTime::createFromFormat('Y/d/m H:i:s', $this->input->post('to',true).' 23:59:59');

        $data['mtas'] = $this->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$_SESSION['user_id'],$select='account_number');
        $data['data']['accountnumber']=$data['mtas']['account_number'];
        $account_info = array(
            'iLogin' => $data['mtas']['account_number'],
            //'iLogin' =>'101926',
            'from' => $this->input->post('from',true) !=''? $data['from']->format('Y-m-d\TH:i:s'):Null ,
            'to' => $this->input->post('to',true) !=''?$data['to']->format('Y-m-d\TH:i:s'):Null
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountCancelledPendingOrders($account_info);
        switch($WebService->request_status){
            case 'RET_OK':
                $tradatalist = (array) $WebService->get_result('TradeDataList');
                if($tradatalist){
                    $closed='';
                    foreach ( $tradatalist['TradeData'] as $object){
                        $closed.='<tr>';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'.number_format((float) $object->Volume,2).'</td>';
                        $closed.='<td>'.$object->Symbol.'</td>';
                        $closed.='<td>'.$object->OpenPrice.'</td>';
                        $closed.='<td>'.number_format((float) $object->StopLoss,5).'</td>';
                        $closed.='<td>'.number_format((float) $object->TakeProfit,5).'</td>';
                        $closed.='<td>'.$object->ClosePrice.'</td>';
                        $closed.='<td>N/A</td>';
                        $closed.='<td>'.number_format((float) $object->Profit,5).'</td>';
                        $closed.='</tr>';
                    }
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= $closed;
                }else{
                    $data['data']['CancelledPendingOrder']= '';
                    $data['data']['Closed']= '';
                }
                break;
            default:
                $data['data']['error']=true;
        }
        

        echo json_encode($data['data']);
        unset($data);

    } 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function forex_calculator(){

        if($this->session->userdata('logged')){

            $data['CurrencyPair'] = $this->g_m->getCurrenciesPairFI();
            $data['Leverage'] = $this->g_m->getFCLeverage();
            $data['Volume'] = $this->g_m->getFCVolume();
            $data['Currency'] = $this->g_m->getAccountCurrencyBase3();

            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'forex-calculator';
            $data['metadata_description'] = 'Compute exchange rates using the free forex calculator powered by ForexMart.';
            $this->template->title("ForexMart | Forex Calculator")
                ->append_metadata_css('
                 <link rel="stylesheet" href="'.$this->template->Css().'select2-bootstrap.css">
                 <link rel="stylesheet" href="'.$this->template->Css().'select2.css"> ')
                ->append_metadata_js(
                    '<script src="'.$this->template->Js().'select2.js" type="text/javascript"></script>')
                ->set_layout('internal/main')
                ->build('forex_calculator', $data);
        }else{
            redirect('signout');
        }
    }
        /** public function apiquotes(){
            // used in method forex_calculator
            if(!$this->input->is_ajax_request()){die('Not authorized!');}

            $data['data']['custom_validation']='';

            $data['convert']['handle'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='.  $this->input->post('cur2')  . $this->input->post('cur3') .'=X', 'r');

            if ($data['convert']['handle']) {
                $data['convert']['result'] = fgets($data['convert']['handle'], 4096);
                fclose($data['convert']['handle']);
            }

            $data['convert']['all_data']  = explode(',',$data['convert']['result'] );

            if($data['convert']['all_data'][1] != 0.00){
                $data['data'][$this->input->post('cur2').$this->input->post('cur3')] = floatval($data['convert']['all_data'][1]);
                $data['data']['CF23'] = floatval($data['convert']['all_data'][1]);
            }

            $data['convert']['handle1'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='.  $this->input->post('cur1')  . $this->input->post('cur2') .'=X', 'r');

            if ($data['convert']['handle1']) {
                $data['convert']['result1'] = fgets($data['convert']['handle1'], 4096);
                fclose($data['convert']['handle1']);
            }

            $data['convert']['all_data1']  = explode(',',$data['convert']['result1']);

            if($data['convert']['all_data1'][1] != 0.00){
                $data['data'][$this->input->post('cur1').$this->input->post('cur2')] = floatval($data['convert']['all_data1'][1]);
                $data['data']['CF12'] = floatval($data['convert']['all_data1'][1]);
            }

            $data['convert']['handle2'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='.  $this->input->post('cur1')  . $this->input->post('cur3') .'=X', 'r');

            if ($data['convert']['handle2']) {
                $data['convert']['result2'] = fgets($data['convert']['handle2'], 4096);
                fclose($data['convert']['handle2']);
            }

            $data['convert']['all_data2']  = explode(',',$data['convert']['result2']);

            if($data['convert']['all_data2'][1] != 0.00){
                $data['data'][$this->input->post('cur1').$this->input->post('cur3')] = floatval($data['convert']['all_data2'][1]);
                $data['data']['CF13'] = floatval($data['convert']['all_data2'][1]);

            }

            if($data['convert']['all_data'][1] != 0.00 AND $data['convert']['all_data1'][1] != 0.00 AND $data['convert']['all_data2'][1] != 0.00){

                $data['data']['value'] = floatval($data['data'][$this->input->post('cur2').$this->input->post('cur3')]);
                $data['data']['CurrentQuote'] = floatval($data['data'][$this->input->post('cur1').$this->input->post('cur2')]);
                $data['data']['PIPValue'] = ($data['data']['value'])*$this->input->post('volume')*100000* (.0001);
                $data['data']['Margin'] = (($this->input->post('volume')*100000)/$this->input->post('leverage'))*$data['data'][$this->input->post('cur1').$this->input->post('cur3')];

            }else{
                $data['data']['value']  = false;
            }

            echo json_encode($data['data']);

        } */

    /*
    public function open_trading_account(){

        $user_id = $this->session->userdata('user_id');
        if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())<1){
            redirect('accounts/register');
        }
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
//        var_dump($this->account_model->getAccountStatus($this->session->userdata('user_id')));exit;
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $mt_accounts_type = $this->session->userdata('checkLiveMtAccType');
            if($mt_accounts_type){

                $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
                $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
                $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');

                if ($this->form_validation->run()) {
                // leverage, mt_currency_base,mt_account_set_id,registration_ip,user_id
                    $swap_free = $this->input->post('swap_free');
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $phone_password = FXPP::RandomizeCharacter(7);

                    $WebService = new WebService();
                    $service_data = array(
                        'address' => $this->input->post('street'),
                        'city' => $this->input->post('city'),
                        'country' => $this->input->post('country'),
                        'currency' => $this->input->post('mt_currency_base'),
                        'email' => $this->session->userdata('email_live'),
                        'is_swap_on' => empty($swap_free) ? false : true,
                        'leverage' => count($ex_leverage = explode(":", $this->input->post('leverage'))) > 1 ? $ex_leverage[1] : $this->input->post('leverage'),
                        'name' => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone'),
                        'state' => $this->input->post('state'),
                        'zip_code' => $this->input->post('zip'),
                        'phone_password' => $phone_password
                    );
                    if( (int)$this->input->post('mt_account_set_id') === 1 ) {
                        $WebService->open_account_live_standard($service_data);
                    }elseif( (int)$this->input->post('mt_account_set_id') === 2 ){
                        $WebService->open_account_live_zero_spread($service_data);
                    }
                    if( $WebService->request_status === 'RET_OK' ) {
                        $AccountNumber = $WebService->get_result('LogIn');
                        $TraderPassword = $WebService->get_result('TraderPassword');
                        $InvestorPassword = $WebService->get_result('InvestorPassword');
                        $mt_account = array(
                            'leverage' => $this->input->post('leverage'),
                            'mt_currency_base' => $this->input->post('mt_currency_base'),
                            'mt_account_set_id' => $this->input->post('mt_account_set_id'),
                            'registration_ip' => $_SERVER['REMOTE_ADDR'],
                            'registration_time' => FXPP::getCurrentDateTime(),
                            'user_id' => $user_id,
                            'mt_type' => 1,
                            'swap_free' => $swap_free,
                            'account_number' => $AccountNumber,
                            'trader_password' => $TraderPassword,
                            'investor_password' => $InvestorPassword,
                            'phone_password' => $phone_password
                        );
                        $this->account_model->insert('mt_accounts_set', $mt_account);
                    }
                    redirect('accounts');
                }
            }else{
                $this->form_validation->set_rules('mt_account_set_id', 'Account type', 'trim|required|xss_clean');
                $this->form_validation->set_rules('mt_currency_base', 'Account Currency Base', 'trim|required|xss_clean');
                $this->form_validation->set_rules('leverage', 'Leverage', 'trim|required|xss_clean');
                $this->form_validation->set_rules('street', 'Street', 'trim|required|xss_clean');
                $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
                $this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
                $this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');
                $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|xss_clean');

                if ($this->form_validation->run()) {
                    $profile = array(
                        'street' => $this->input->post('street'),
                        'city' => $this->input->post('city'),
                        'state' => $this->input->post('state'),
                        'zip' => $this->input->post('zip'),
                        'dob' => $this->input->post('dob')
                    );

                    $this->account_model->updateUserDetails('user_profiles', 'user_id', $user_id, $profile); // Update user profile data.
                    // leverage, mt_currency_base,mt_account_set_id,registration_ip,user_id
                    $swap_free = $this->input->post('swap_free');
                    $swap_free = empty($swap_free) ? 0 : 1;
                    $phone_password = FXPP::RandomizeCharacter(7);

                    $service_data = array(
                        'address' => $this->input->post('street'),
                        'city' => $this->input->post('city'),
                        'country' => $this->input->post('country'),
                        'currency' => $this->input->post('mt_currency_base'),
                        'email' => $this->session->userdata('email_live'),
                        'is_swap_on' => empty($swap_free) ? false : true,
                        'leverage' => count($ex_leverage = explode(":", $this->input->post('leverage'))) > 1 ? $ex_leverage[1] : $this->input->post('leverage'),
                        'name' => $this->session->userdata('full_name_live'),
                        'phone_number' => $this->input->post('phone'),
                        'state' => $this->input->post('state'),
                        'zip_code' => $this->input->post('zip'),
                        'phone_password' => $phone_password
                    );

                    $webservice_config = array(
                        'server' => 'live'
                    );
                    if( (int)$this->input->post('mt_account_set_id') === 1 ) {
                        $WebService = new WebService($webservice_config);
                        $WebService->open_account_live_standard($service_data);
                    }elseif( (int)$this->input->post('mt_account_set_id') === 2 ){
                        $WebService = new WebService($webservice_config);
                        $WebService->open_account_live_zero_spread($service_data);
                    }

                    if( $WebService->request_status === 'RET_OK' ) {
                        $AccountNumber = $WebService->get_result('LogIn');
                        $TraderPassword = $WebService->get_result('TraderPassword');
                        $InvestorPassword = $WebService->get_result('InvestorPassword');

                        $mt_account = array(
                            'leverage' => $this->input->post('leverage'),
                            'amount' => $this->input->post('amount'),
                            'mt_currency_base' => $this->input->post('mt_currency_base'),
                            'mt_account_set_id' => $this->input->post('mt_account_set_id'),
                            'registration_ip' => $_SERVER['REMOTE_ADDR'],
                            'user_id' => $user_id,
                            'mt_type' => 1,
                            'swap_free' => $swap_free,
                            'account_number' => $AccountNumber,
                            'trader_password' => $TraderPassword,
                            'investor_password' => $InvestorPassword,
                            'phone_password' => $phone_password
                        );
                        $this->account_model->insert('mt_accounts_set', $mt_account);

                        // send email  to user email
                        $email_data = array(
                            'full_name' => $this->session->userdata('full_name_live'),
                            'email' => $this->session->userdata('email_live'),
                            'account_number'=> $mt_account['account_number'],
                            'trader_password'=> $mt_account['trader_password'],
                            'investor_password'=> $mt_account['investor_password'],
                            'phone_password'=> $mt_account['phone_password'],
                        );
                        $subject = "ForexMart MT4 Live Trading Account details";
                        $config = array(
                            'mailtype'=> 'html'
                        );
                        $this->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,$config);
                    }
                    $experiences = $this->input->post('experience');
                    $experience = is_array($experiences) ? join(",", $experiences) : "";

                    $trading_experience = array(
                        'investment_knowledge' => $this->input->post('investment_knowledge'),
                        'risk' => $this->input->post('risk'),
                        'experience' => $experience,
                        'user_id' => $user_id,
                        'technical_analysis' => $this->input->post('technical_analysis'),
                        'trade_duration' => $this->input->post('trade_duration'),
                        'us_resident' => $this->input->post('us_resident'),
                        'us_citizen' => $this->input->post('us_citizen'),
                    );
                    $this->general_model->insert('trading_experience', $trading_experience);

                    $employment_detail = array(
                        'employment_status' => $this->input->post('mt_currency_base'),
                        'industry' => $this->input->post('industry'),
                        'source_of_funds' => $this->input->post('source_of_funds'),
                        'estimated_annual_income' => $this->input->post('estimated_annual_income'),
                        'estimated_net_worth' => $this->input->post('estimated_net_worth'),
                        'politically_exposed_person' => $this->input->post('politically_exposed_person'),
                        'education_level' => $this->input->post('education_level'),
                        'user_id' => $user_id
                    );
                    $this->general_model->insert('employment_details', $employment_detail);


                    if(!empty($_FILES['filename']['name'])) {
                        $this->load->helper(array('form', 'url'));
                        $cpt = count($_FILES['filename']['name']);
                        for($i=0; $i<$cpt; $i++) {
                            if(!empty($_FILES['filename']['name'][$i])){
                                $_FILES['userfile']['name'] = $_FILES['filename']['name'][$i];
                                $_FILES['userfile']['type'] = strtolower($_FILES['filename']['type'][$i]);
                                $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
                                $_FILES['userfile']['error'] = $_FILES['filename']['error'][$i];
                                $_FILES['userfile']['size'] = $_FILES['filename']['size'][$i];

                                $config['file_name'] = sha1($_FILES['userfile']['name'][$i]);
                                $config['upload_path'] = './assets/user_images';
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                                $config['max_width'] = '0';
                                $config['max_height'] = '0';
                                $config['overwrite'] = false;
                                $this->load->library('upload', $config);
                                //                     Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
                                $this->upload->initialize($config);
                                if($this->upload->do_upload()) {
                                    $uploadData = $this->upload->data();
                                    $updData = array(
                                        'user_id' => $user_id,
                                        'doc_type' => $i,
                                        'file_name' => $uploadData['file_name'],
                                        'client_name' => $uploadData['client_name']
                                    );
                                    $this->general_model->insert('user_documents', $updData);
                                }
                            }
                        }
                    }

                    $this->account_model->updateUserDetails('trading_experience', 'user_id', $user_id, $trading_experience); // Update user trading experience data.

                    redirect('accounts');

                }
            }

            $getAccountStatus = $this->account_model->getAccountStatus($this->session->userdata('user_id'));
            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(),$this->country_code);
            $data['account_type'] = $this->general_model->selectOptionList($this->general_model->getAccountType(), $getAccountStatus ? $getAccountStatus->mt_account_set_id : 1);
            $data['account_currency_base'] = $this->general_model->selectOptionList($this->general_model->getAccountCurrencyBase(), $getAccountStatus ? $getAccountStatus->mt_currency_base : 'USD');
            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(), $getAccountStatus ? $getAccountStatus->leverage : '1:200');
            $data['amount'] = $this->general_model->selectOptionList($this->general_model->getAmount());
            $data['employment_status'] = $this->general_model->selectOptionList($this->general_model->getEmploymentStatus(), $getAccountStatus ? $getAccountStatus->employment_status : 0);
            $data['industry'] = $this->general_model->selectOptionList($this->general_model->getIndustry(), $getAccountStatus ? $getAccountStatus->industry : 0);
            $data['source_of_funds'] = $this->general_model->selectOptionList($this->general_model->getSourceOfFunds(), $getAccountStatus ? $getAccountStatus->source_of_funds : 0);
            $data['estimated_annual_income'] = $this->general_model->selectOptionList($this->general_model->getEstimatedAnnualIncome(), $getAccountStatus ? $getAccountStatus->estimated_annual_income : 0);
            $data['estimated_net_worth'] = $this->general_model->selectOptionList($this->general_model->getEstimatedNetWorth(), $getAccountStatus ? $getAccountStatus->estimated_net_worth : 0);
            $data['investment_knowledge'] = $this->general_model->selectOptionList($this->general_model->getInvestmentKnowledge(), $getAccountStatus ? $getAccountStatus->investment_knowledge : 1);
            $data['education_level'] = $this->general_model->selectOptionList($this->general_model->getEducationLevel(), $getAccountStatus ? $getAccountStatus->education_level : 0);
            $data['trade_duration'] = $this->general_model->selectOptionList($this->general_model->geTtradeDuration(), $getAccountStatus ? $getAccountStatus->trade_duration : 0);

            $data['trade_exp'] = explode(',', $getAccountStatus->experience);
            $data['politically_exposed_person'] = $getAccountStatus->politically_exposed_person;
            $data['risk'] = $getAccountStatus->risk;
            $data['us_resident'] = $getAccountStatus->us_resident;
            $data['us_citizen'] = $getAccountStatus->us_citizen;

            $data['active_tab'] = 'accounts';
            $this->template->title("ForexMart | Open Trading Account")
                ->set_layout('internal/main')
                ->build($mt_accounts_type ? 'open_trading_account' : 'open_trading_account2', $data);
        }else{
            redirect('signout');
        }
    }
*/
    public function createVirtualAccount(){
        if($this->session->userdata('logged')) {
            $user_id = $this->session->userdata('user_id');
            $virtual_currency = $this->input->post('virtual_currency',true);
            $virtual_currency_bases = $this->general_model->getAccountCurrencyBase();
            if( in_array($virtual_currency, $virtual_currency_bases) ) {
                if (FXPP::canCreateVirtualAccount()) {
                    $this->load->model('virtual_account_model');
                    if (!$this->virtual_account_model->isCurrencyExistByUserId( $user_id, $virtual_currency )) {
                        $data = array(
                            'user_id' => $user_id,
                            'currency' => $virtual_currency
                        );
                        if($this->virtual_account_model->insertVirtualAccount($data)) {
                            flash_message('virtual_account_message', 'Virtual account successfully created.', 1);
                        }else{
                            flash_message('virtual_account_message', 'Failed to create virtual account.');
                        }
                    }else{
                        flash_message('virtual_account_message', 'Virtual account currency already exist.');
                    }
                }else{
                    flash_message('virtual_account_message', 'You have already created maximum number of virtual accounts.');
                }
            }else{
                flash_message('virtual_account_message', 'Invalid virtual account currency.');
            }
            redirect($this->agent->referrer());
        }
    }

    public function getAccountDetails($filterBy){
        $user_id = $this->session->userdata('user_id');
        $detailsFilter = $this->account_model->getUserDetailsFilter($user_id, $filterBy);
        $htm = '';
        foreach($detailsFilter as $d){
            switch($filterBy){
                case 'mt_type':
                    $data = $d[$filterBy] ? 'Trading' : 'Demo';
                    break;
                case 'mt_currency_base':
                    $data = $d[$filterBy];
                    break;
                case 'mt_account_set_id':
                    $data = $this->general_model->getAccountType( $d[$filterBy] );
                    break;
            }
            $htm .= "<div class='checkbox'>";
                $htm .= "<label>";
                    $htm .= "<input type='checkbox' value= $d[$filterBy] name= $filterBy class='chkfilter' checked/>";
                    $htm .= $data;
                $htm .= "</label>";
            $htm .= "</div>";
        }
//        var_dump($htm);
        return $htm;
    }

    public function updateAccountsFilter(){
       if($this->session->userdata('logged')) {
           $user_id = $this->session->userdata('user_id');
           $mt_type_dts = $this->input->post('mt_type_dts',true) == '' ? array('') : $this->input->post('mt_type_dts',true);
           $mt_currency_base_dts = $this->input->post('mt_currency_base_dts',true) == '' ? array('') : $this->input->post('mt_currency_base_dts',true);
           $mt_account_set_id_dts = $this->input->post('mt_account_set_id_dts',true) == '' ? array('') : $this->input->post('mt_account_set_id_dts',true);
           $accounts = $this->account_model->selectedDetailsFilter($user_id, $mt_type_dts, $mt_currency_base_dts, $mt_account_set_id_dts);
//           $accounts = $this->account_model->getAccountsByUserId($user_id);
//           var_dump($accounts);
            $htm = '';
            if($accounts){
                foreach ($accounts as $key => $value) {
                    $free_margin = $value['amount'] == '' ? 0 : $value['amount'];
                    $balance = $value['amount'] == '' ? 0 : $value['amount'];
                    $type = $value['mt_type'] ? 'Trading' : 'Demo';
                    $htm .= '<tr>';
                        $htm .= '<td style="color: #ff0000;"><i class="fa fa-caret-down"></i></td>';
                        $htm .= '<td>'.$value['leverage'].'</td>';
                        $htm .= '<td>'.$value['mt_currency_base'].'</td>';
                        $htm .= '<td>'.$free_margin.'</td>';
                        $htm .= '<td>'.$balance.'</td>';
                        $htm .= '<td></td>';
                        $htm .= '<td>'.$type.'</td>';
                        $htm .= '<td>'.$this->general_model->getAccountType( $value['mt_account_set_id'] ).'</td>';
                    $htm .= '</tr>';
                }
            }else{
                $htm .= '<tr><td colspan="8"> NO RECORDS FOUND</td></tr>';
            }

            echo json_encode($htm);
        }
    }
    public function API_CurrencyPairSpotCFD(){
        // used in method forex_calculator
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $data['data']['custom_validation']='';

        if ($this->input->post('cur1',true)[0]=='#'){

            //Computations for CFD

            $data['data']['isCFD'] = true;

            $data['FilteredCFD'] = ltrim ($this->input->post('cur1',true), '#');

            // get CFD value
            $data['convert']['handle'] = fopen('http://finance.yahoo.com/d/quotes.csv?s='.$data['FilteredCFD'].'&f=sb2b3jk', 'r');

            if ($data['convert']['handle']) {
                $data['convert']['result'] = fgets($data['convert']['handle'], 4096);
                fclose($data['convert']['handle']);
            }

            $pieces = explode(",", $data['convert']['result']);

            $data['cfd'] = floatval($pieces[4]);
            // get USD  currency to currency 3
            $data['convert']['handle2'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=USD'.$this->input->post('cur3',true) .'=X', 'r');
            if ($data['convert']['handle2']) {
                $data['convert']['result2'] = fgets($data['convert']['handle2'], 4096);
                fclose($data['convert']['handle2']);
            }
            $data['convert']['all_data2']  = explode(',',$data['convert']['result2'] );
            if($data['convert']['all_data2'][1] != 0.00){
                $data['data']['CF23'] = floatval($data['convert']['all_data2'][1]);
            }

            $data['data']['CurrentQuote'] = $data['cfd'];
            $data['data']['PIPValue'] = 0.1*0.0001*100000*$data['data']['CF23'];
            $data['data']['Margin'] = ($data['data']['PIPValue']*0.1*100000*$data['cfd']*0.1)/$this->input->post('leverage',true);

        }else{

            //Computations for Currency Pair and Metals

            $data['data']['isCFD'] = false;

            if ($this->input->post('cur1',true)=='USD' AND $this->input->post('cur2',true)=='JPY'){
                $data['USDJYPADJ']=100;
            }else{
                $data['USDJYPADJ']=1;
            }

            if ($this->input->post('cur1',true)=="XXAU"){
                $data['NewCur1']='XAU';
            }else{
                $data['NewCur1']=$this->input->post('cur1',true);
            }


            $cur2=$this->input->post('cur2',true);
            if ($this->input->post('cur2name',true)=="RUR"){
                $cur2='RUB';
            }


            $data['convert']['handle'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $cur2 . $this->input->post('cur3',true) .'=X', 'r');

            if ($data['convert']['handle']) {
                $data['convert']['result'] = fgets($data['convert']['handle'], 4096);
                fclose($data['convert']['handle']);
            }

            $data['convert']['all_data']  = explode(',',$data['convert']['result'] );

            if($data['convert']['all_data'][1] != 0.00){
                if($this->input->post('cur2name',true)=='RUR') {
                    $data['data'][$cur2 . $this->input->post('cur3',true)] = floatval($data['convert']['all_data'][1]*1000);
                    $data['data']['CF23'] = floatval($data['convert']['all_data'][1]*1000);
                }else{
                    $data['data'][$cur2 . $this->input->post('cur3',true)] = floatval($data['convert']['all_data'][1]);
                    $data['data']['CF23'] = floatval($data['convert']['all_data'][1]);
                }
            }

            $data['convert']['handle1'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='.  $data['NewCur1']  . $cur2 .'=X', 'r');

            if ($data['convert']['handle1']) {
                $data['convert']['result1'] = fgets($data['convert']['handle1'], 4096);
                fclose($data['convert']['handle1']);
            }

            $data['convert']['all_data1']  = explode(',',$data['convert']['result1']);

            if($data['convert']['all_data1'][1] != 0.00){

                if($this->input->post('cur2name',true)=='RUR') {
                    $data['data']['CF12'] = floatval(($data['convert']['all_data1'][1])/1000);
                    $data['data'][$data['NewCur1'].$cur2] = floatval(($data['convert']['all_data1'][1])/1000);
                }else {
                    $data['data'][$data['NewCur1'].$cur2] = floatval($data['convert']['all_data1'][1]);
                    $data['data']['CF12'] = floatval($data['convert']['all_data1'][1]);
                }

            }

            $data['convert']['handle2'] = fopen('https://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='.  $data['NewCur1']  . $this->input->post('cur3',true) .'=X', 'r');

            if ($data['convert']['handle2']) {
                $data['convert']['result2'] = fgets($data['convert']['handle2'], 4096);
                fclose($data['convert']['handle2']);
            }

            $data['convert']['all_data2']  = explode(',',$data['convert']['result2']);

            if($data['convert']['all_data2'][1] != 0.00){

                $data['data'][$data['NewCur1'].$this->input->post('cur3',true)] = floatval($data['convert']['all_data2'][1]);
                $data['data']['CF13'] = floatval($data['convert']['all_data2'][1]);
            }

            if($data['convert']['all_data'][1] != 0.00 AND $data['convert']['all_data1'][1] != 0.00 AND $data['convert']['all_data2'][1] != 0.00){

                $SpotMetals = array("SILVER","GOLD","XAU");


                $data['data']['value'] = $data['data']['CF23'];

                $data['data']['CurrentQuote'] = floatval(($data['data'][$data['NewCur1'].$cur2]));


                if (in_array($this->input->post('cur1name',true), $SpotMetals)) {

                    if($this->input->post('cur1name',true)=="XAU"){

                        $data['data']['PIPValue'] = ($data['data']['value'])*$this->input->post('volume',true)*100000*(.0001)*5;
                        $data['data']['Margin'] = ((0.0001*$this->input->post('volume',true)*100000)*$data['data'][$data['NewCur1'].$this->input->post('cur3',true)])*5;

                    }elseif($this->input->post('cur1name',true)=="SILVER"){

                        $data['data']['PIPValue'] = (($data['data']['value'])*$this->input->post('volume',true)*100000* (.0001))/2;
                        $data['data']['Margin'] = ((0.0001*$this->input->post('volume',true)*100000)*$data['data'][$data['NewCur1'].$this->input->post('cur3',true)])/2;
                    }else{

                        $data['data']['PIPValue'] = $data['USDJYPADJ']*($data['data']['value'])*$this->input->post('volume',true)*100000* (.0001);
                        $data['data']['Margin'] = ((0.0001*$this->input->post('volume',true)*100000)*$data['data'][$data['NewCur1'].$this->input->post('cur3',true)]);
                    }

                }else{

                    if($this->input->post('cur2name',true)=='RUR' or $this->input->post('cur2name',true)=='RUB'){

                        $data['data']['PIPValue'] = (($data['data']['value'])*$this->input->post('volume',true)*100000* (.0001)*10);
                    }else{
                        $data['data']['PIPValue'] =  $data['USDJYPADJ']*($data['data']['value'])*$this->input->post('volume',true)*100000* (.0001);
                    }
                    $data['data']['Margin'] = (($this->input->post('volume',true)*100000)/$this->input->post('leverage',true))*$data['data'][$data['NewCur1'].$this->input->post('cur3',true)];

                }

            }else{
                $data['data']['value']  = false;
            }

        }
        echo json_encode($data['data']);

    }
    public function vps(){
        if($this->session->userdata('logged')){
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'vps';
            $this->template->title("ForexMart | My Account")
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('myaccount/vps', $data);
        }else{
                redirect('signout');
        }
    }

    public function req_bal(){

        if (!$this->input->is_ajax_request()) {die('Not authorized!');}

        $account_info = array(
            'iLogin' => $this->input->post('AccountNumber',true)
        );
        if($this->input->post('AccNum_type',true)){
            $webservice_config = array(
                'server' => 'live_new'
            );
        }else{
            $webservice_config = array(
                'server' => 'demo_new'
            );
        }
        $data['data']['an']=$this->input->post('AccountNumber',true);

        $WebService= new WebService($webservice_config);
        $WebService->open_RequestAccountBalance($account_info);

        switch($WebService->request_status){
            case 'RET_OK':
                $data['data']['balance'] =  $this->roundno(floatval( $WebService->get_result('Balance')),2);
             break;
            default:
                $data['data']['balance'] = $this->roundno(floatval(0),2);

        }
        $data['data']['reso']=$WebService->request_status;
        echo json_encode($data['data']);
        unset($data);

    }
    private function roundno($number,$dp) {
        return number_format((float)$number, $dp,'.','');
    }

    public function updateLeverage(){
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $users = $this->g_m->showssingle($table='users',$id='id', $field=$user_id,$select='type,nodepositbonus');
            if($users['nodepositbonus'] == 0){
                $has_50percent = $this->depoosit_model->has50PercentBonusDeposit($user_id);
                $isUpdate = false;
                if(!$has_50percent){
                    $leverage = count($ex_leverage = explode(":", $this->input->post('leverage',true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage',true);
                    $account = $this->account_model->getAccountByUserId($user_id);

//                    $config = array(
//                        'server' => 'live_new'
//                    );
//
//                    $info = array(
//                        'iLogin' => $account['account_number'],
//                        'iLeverage' => $leverage
//                    );

//                    $WebService = new WebService($config);
//                    $WebService->open_ChangeAccountLeverage($info);

                    $WebService = FXPP::SetLeverage($account['account_number'], $leverage);

                    if( $WebService->request_status === 'RET_OK' ) {
                        $this->account_model->updateAccountLeverage($account['account_number'], $this->input->post('leverage',true));
                        $isUpdate = true;
                    }
                }

                $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate)));
            }else{
             show_404();
            }
        }else{
            show_404();
        }
    }

    public function updateSwap(){
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $users = $this->g_m->showssingle($table='users',$id='id', $field=$user_id,$select='type,nodepositbonus');
            $ndb = '';
            if($users['nodepositbonus'] == 1) {
                $ndb = 'ndb';
            }
            $isUpdate = false;
            $swap = (int) $this->input->post('swap',true);
            if($swap ){
                $is_swap = 1;
            }else{
                $is_swap = 0;
            }

            FXPP::update_account_group();
            $account = $this->account_model->getAccountByUserId($user_id);

            if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){
                $this->session->set_userdata('isChina', '1');
            }

           // $groupCurrency = $this->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $is_swap);
            $groupCurrency =  substr($account['group'], 0, -1);

//            $config = array(
//                'server' => 'live_new'
//            );

            $groupCurrency .= $ndb . $account['group_code'];
            $account_info2 = array(
                'iLogin' => $account['account_number'],
                'strGroup' => $groupCurrency
            );

//            $WebService = new WebService($config);
//            $WebService->open_ChangeAccountGroup($account_info2);

            $WebService = FXPP::SetAccountGroup($account['account_number'], $groupCurrency);

            if( $WebService->request_status === 'RET_OK' ) {
                $this->account_model->updateAccountSwapFree($account['account_number'], $is_swap);
                $isUpdate = true;
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate, 'swap' => $swap, 'is_swap' => $is_swap, $account_info2)));
        }else{
            show_404();
        }
    }

    public function NewGetOpenTrades(){
        if($_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933'){
            if($this->session->userdata('logged')){

                $data['active_tab'] = 'accounts';
                $data['active_sub_tab'] = 'history-of-trades';
                $data['metadata_description'] = 'Review all closed and cancelled deals for a specific time period.';
                $this->template->title("ForexMart | History of Trades")
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
                    ->build('new_history_of_trades',$data);
            }else{
                redirect('signout');
            }

        }
    }

    public function getTrades(){
        if ($this->input->is_ajax_request()) {
            $this->load->library('SVC');
            $tradeType = $_POST['recType'];
            $rowPerPage = 10;
            $hasError = false;
            $errorMsg = "";
            $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
            $SVC = new SVC();
            $args = array(
                'AccountNumber' => $_SESSION['account_number'],
                'Password' => $this->getTraderPassword($_SESSION['account_number']),
                'Limit' => $rowPerPage,
                'Offset' => $page
            );

            switch ($tradeType) {
                case 'history-of-trades':
                    $x = ( $SVC->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $SVC->GetTradeHistory($args)['Data']: $SVC->GetTradeHistory($args) ;
                    $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                    $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                    $hasError = ( $SVC->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $SVC->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    break;
                case 'current-trades':
                    $x = ( $SVC->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $SVC->GetOpenTrades($args)['Data']: array() ;
                    $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                    $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                    $hasError = ( $SVC->GetOpenTrades($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $SVC->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    break;
                default :
                    $x = ( $SVC->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $SVC->GetTradeHistory($args)['Data']: array() ;
                    $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                    $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                    $hasError = ( $SVC->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                    $errorMsg = ( $SVC->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
                    break;
            }
            $result = $this->populate($res, $args);
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(array('result' => $result , 'hasError' => $hasError , 'errorMsg' => $errorMsg )));
        }
    }
    public function populate($data,$raw){
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
        $data1['result'] =  $data1['count']>0?$this->formatRaw($data['record'] , $rowNum):'<tr><td colspan="11">No data available.</td></tr>';

        $data1['row'] = $rowNum;

        $data1['rowPerPage'] = $data['rowPerPage'];

        return $data1;
    }

    public function formatRaw($records, $rowNum){
        $tbl = '';
        $ctr = intval($rowNum) + 1;
        foreach ($records->TradeRecord as $a){

            $tbl .= "<tr>";
            $tbl .= "<td>".$ctr."</td>";
            $tbl .= "<td>".$a->Order."</td>";
            $tbl .= "<td>".$this->getTradeType($a->Cmd)."</td>";
            $tbl .= "<td>".($a->Volume/100)."</td>";
            $tbl .= "<td>".$a->Symbol."</td>";
            $tbl .= "<td>".$a->OpenPrice."</td>";
            $tbl .= "<td>".$a->Sl."</td>";
            $tbl .= "<td>".$a->Tp."</td>";
            $tbl .= "<td>".$a->ClosePrice."</td>";
            $tbl .= "<td>N/A</td>";
            $tbl .= "<td>".$a->Profit."</td>";
            $tbl .= "</tr>";
            $ctr++;
        }
        return $tbl;
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
}
