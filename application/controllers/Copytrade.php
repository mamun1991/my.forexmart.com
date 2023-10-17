<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Copytrade extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('General_model');
        $this->load->model('copytrade_model');
        $this->lang->load('datatable');
        $this->lang->load('depositwithdraw');
        $this->load->helper('url');
        $this->lang->load('sidebar');
        $this->lang->load('copytrade');
        $this->load->library('Fx_mailer');
        $this->load->helper('cookie');
        $this->load->library('ForexCopy'); //ForexCopy web service
        $this->load->model('user_model');

        if($this->session->userdata('login_type') == 1){
            redirect(FXPP::my_url('my-account'));
        }
    }

    public function index()
    {
        /*if(isset($_GET['test'])){
            print_r('teeeeeeeeeeeeeeeeeeeeest');
        }*/

        if ($this->session->userdata('logged')) {
            $data['IsSubscribe'] = false;
            $trader_data = $this->getUserType($_SESSION['account_number']);
            if ($trader_data == 0 || $trader_data == 1 || $trader_data == 2) {
                $data['IsSubscribe'] = true;


                if (isset($_COOKIE['forexmart_monitor_account'])) {
                    redirect(FXPP::my_url('copytrade/monitor_user/' . $_COOKIE['forexmart_monitor_account']));
                }
            }


            $user_id = $this->session->userdata('user_id');
            $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
            $this->session->set_userdata(array('image' => $image));


            $view = 'copytrade/my_copytrading';
                    

            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='" . $this->template->Css() . "copytrade_style.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "copytrade_circle.css'>    
                 <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>       
                 <link rel='stylesheet' href='" . $this->template->Css() . "mongrid.css'>    
                  <link rel='stylesheet' href='" . $this->template->Css() . "modal_style.css'>        
              ")
                ->append_metadata_js("                        
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                //  ->build('copytrade/my_copytrading', $data);
                ->build($view, $data);
        } else {
            if (FXPP::html_url() == 'ru') {
                redirect('ru/signout');
            } else {
                $lang_code=(FXPP::html_url()!="" or FXPP::html_url()!="en")?FXPP::html_url()."/":'';
                
                redirect($lang_code.'signout');
            }
        }

    }

    public function recommended_accounts()
    {
        if ($this->session->userdata('logged')) {


            $trader_data = $this->getUserType($_SESSION['account_number']);
            if ($trader_data == 0 || $trader_data == 1 || $trader_data == 2) {
                $data['IsSubscribe'] = true;
            }


            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='" . $css . "copytrade_style.css'>
                 <link rel='stylesheet' href='" . $css . "copytrade_circle.css'>    
                 <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>       
                 <link rel='stylesheet' href='" . $this->template->Css() . "mongrid.css'>    
              ")
                ->append_metadata_js("
               
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('copytrade/recommended_accounts', $data);
        } else {
            redirect('signout');
        }

    }

    public function my_project()
    {
        $trader_data = $this->getUserType($_SESSION['account_number']);
        if ($trader_data == 0 || $trader_data == 1 || $trader_data == 2) {
            $this->monitor_user($_SESSION['account_number']);
        } else {
            redirect(FXPP::my_url('copytrade'));
        }

    }

    public function register_trader()
    {
		 
        if ($this->session->userdata('logged')) {

            $trader_data = $this->getUserType($_SESSION['account_number']);
            if ($trader_data != 3) {
                redirect(FXPP::my_url('copytrade'));
            }


            $trader_data = $this->getUserType($_SESSION['account_number']);
            $data['is_master'] = $trader_data;


            if (!$this->copytrade_model->get_where("copytrade_users", array('account_number' => $_SESSION['account_number'], 'status' => 1))) {
                $users_info = array(
                    'account_number' => $_SESSION['account_number'],
                    'fc_type'        => 2, // follower
                    'status'         => 1,
                    'date_created'   => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                );

                $this->copytrade_model->fcopy_insert('copytrade_users', $users_info);
            }


            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='" . $css . "copytrade_style.css'>
                 <link rel='stylesheet' href='" . $css . "copytrade_circle.css'>    
                 <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>             
              ")
                ->append_metadata_js("
               
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('copytrade/register_trader', $data);
        } else {
            redirect('signout');
        }

    }

    public function my_subscription()
    {
        if ($this->session->userdata('logged')) {


            $data['is_follower'] = false;
            $trader_data = $this->getUserType($_SESSION['account_number']);

            if ($trader_data == 0 || $trader_data == 1 || $trader_data == 2) {
                $data['is_master'] = $trader_data;
                $data['IsTrader'] = $trader_data;
                if ($trader_data == 0) {
                    $data['is_follower'] = true;
                }
            } else {
                redirect(FXPP::my_url('copytrade'));
            }
            //trader - can have follower/ can subscribe to other trader
            // follower  - can only subscribe to trader

            $data['commissionType']  = $this->GetTraderCopyTermsKey();
            if($data['commissionType'] == 3){
                
                $ForexCopy = new ForexCopy();
                $data['rollover_status'] = $ForexCopy->GetMyRollOverStatus();
                $data['rolloverNote']   = $data['rollover_status']  ? lang('rollover_note_1') : lang('rollover_note_2');

            }

            $data['noTrader'] = false;
            $traderCount = $this->GetTraderByLimit($_SESSION['account_number'], 0, 1, 2);
            if ($traderCount['traderCount'] > 0) {
                $traderTotalPages = ceil($traderCount['traderCount'] / 10);
                $data['traderTotalPages'] = $traderTotalPages;
            } else {
                $data['traderTotalPages'] = 1;
            }

            $subsCount = $this->GetPastSubscriptionByLimit($_SESSION['account_number'], 0, 1, 2);
            if ($subsCount['pastSubsCount'] > 0) {
                $subsTotalPages = ceil($subsCount['pastSubsCount'] / 10);
                $data['subsTotalPages'] = $subsTotalPages;
            } else {
                $data['subsTotalPages'] = 1;
            }


            if ($data['IsTrader']) {
                $followerCount = $this->GetFollowerByLimit($_SESSION['account_number'], 0, 1, 2);
                if ($followerCount['followerCount'] > 0) {
                    $followerTotalPages = ceil($followerCount['followerCount'] / 10);
                    $data['followerTotalPages'] = $followerTotalPages;
                } else {
                    $data['followerTotalPages'] = 1;
                }


            }

            if ($traderCount > 0) {

            } else {
                $data['noTrader'] = true;
            }


            $data['copytrade_info_modal'] = $this->load->ext_view('modal', 'copytrade_info_modal', null, true);

            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='" . $css . "copytrade_style.css'>
                 <link rel='stylesheet' href='" . $css . "copytrade_circle.css'>    
                 <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>             
                 <link rel='stylesheet' href='" . $this->template->Css() . "modal_style.css'>                
                 <link rel='stylesheet' href='" . $this->template->Css() . "table-style.css'>             
              ")
                ->append_metadata_js("
               
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                       <script src='" . $this->template->Js() . "simple-bootstrap-paginator.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('copytrade/my_subscription_v2', $data);
        } else {
            redirect('signout');
        }

    }

    public function getTotalDaysFromDate($timestamp)
    {
        $now = time();
        $difference = $now - $timestamp;
        $days = floor($difference / (60 * 60 * 24));
        if ($days < 1) {
            $days = 1;

            return $days . ' ' . lang('copytrade_59');
        }

        return $days . ' ' . lang('copytrade_58');
    }

    public function my_copytrade_request()
    {
        if ($this->session->userdata('logged')) {
            if (!$this->input->is_ajax_request()) {
                die('Not authorized!');
            }
            $this->load->model('user_model');

            $this->lang->load('copytrade');

            $draw = (int) $this->input->post('draw');

            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('extra_search');
            $sort = $this->input->post('sort');
            $visitor = $_SESSION['account_number'];
            $webservice_config = array('server' => 'copytrader');
            if (empty($search)) {
                $service_data = array('Offset' => $start, 'Limit' => $length, 'AccountNumber' => $visitor, 'sortBy' => $sort);
                $ForexCopy = new ForexCopy();
                $ForexCopy->GetAllCopyTrader($service_data);
            } else {
                $service_data = array('Offset' => $start, 'Limit' => $length, 'AccountNumber' => $visitor, 'Search' => $search);
                $ForexCopy = new ForexCopy();
                $ForexCopy->SearchTrader($service_data);

            }

            $request_result = (array) $ForexCopy->GetAllResult();
            $dataCount = $request_result['DataCount']; //total count
            $traderData = $request_result['Traders']->MonitorAccountData;


            $pendingList = array();
            foreach ($traderData as $key => $value) {

                $user_link = 'copytrade/monitor-user/' . $value->UserId;
                //$master_info = $this->general_model->showssingle('mt_accounts_set', 'account_number', $value->UserId, 'mt_account_set_id');
                //$account_type = $this->general_model->getAccountTypeGroup($master_info['mt_account_set_id']);
                $user_profile = $this->user_model->getUserAvatar($value->UserId);
                if ($user_profile['cpy_avatar']) {
                    if (strpos($user_profile['cpy_avatar'], 'avatar') !== false) {
                        $avatar = 'https://my.forexmart.com/assets/images/trader_avatar/' . $user_profile['cpy_avatar'];
                    } else {
                        $avatar = 'https://my.forexmart.com/assets/user_images/' . $user_profile['cpy_avatar'];
                    }
                } else {
                    $avatar = $this->template->Images() . 'trader_avatar/avatar-18.png'; //default
                }


                $testTrader = array('58024888', '58024911', '58025196', '58025198', '58026392', '101926', '58027936', '58027935', '58027934', '58027931', '58027933', '58063713', '58061569');
                $subsStatus = $value->SubscriptionStatus;
                if ($subsStatus == 0) {
                    $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' data-type = ' . $subsStatus . ' type="button">' . lang('btn_subscribe') . '</button>';
                } else if ($subsStatus == 1) {
                    $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' data-type = ' . $subsStatus . ' type="button" style="background-color: #d9534f;border-color: transparent;">' . lang('btn_cancel') . '</button>';
                } else if ($subsStatus == 2) {
                    $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' data-type = ' . $subsStatus . ' type="button" style="background-color: #d9534f;border-color: transparent;">' . lang('btn_unsubscribe') . '</button>';
                }

                if ($value->AccountType == 'Cents') {
//					$AccountType = lang('copytrade_05');
					$AccountType = 'Cents';
				} else if ($value->AccountType ==  'Classic') {
					$AccountType = 'Classic';
//					$AccountType = lang('copytrade_01');
				} else if ($value->AccountType == 'ZeroSpread') {
//					$AccountType = lang('copytrade_00');
					$AccountType = 'ZeroSpread';
				} else if ($value->AccountType == 'Pro') {
//					$AccountType = lang('copytrade_02');
					$AccountType = 'Pro';
				}  else {
//					$AccountType = 'ForexMart ' . $value->AccountType;
					$AccountType = $value->AccountType;
				}
				
                if (IPLoc::Office() || IPLoc::APITraderIP()) {
                    $tempArray = array(
                        'DT_RowId' => $value->UserId,
                        '<div class="box box-align">
							<img src=' . $avatar . ' class="img-responsive avatar">
								<a href="' . FXPP::my_url($user_link) . '">
							<div class="project-block">
								<span class="account-name">' . $value->UserId . '</span>
								<br>
									<span class="account-type">' . $AccountType . '</span>
								</div>
							</a>
						</div>',
                        $value->ProjectName,
                        $this->roundno(floatval($value->Balance), 2),
                        $this->roundno(floatval($value->Equity), 2),
                        $value->CurrentTrades,
                        $value->TotalTrades,
                        $this->roundno(floatval($value->DailyEquity), 2),
                        $this->getTotalDaysFromDate($value->RegisteredDate),
                        $btn,
                    );

                } else {
                    if (!in_array($value->UserId, $testTrader)) {
                        $tempArray = array(
                            'DT_RowId' => $value->UserId,
                            '<div class="box box-align">
								<img src=' . $avatar . ' class="img-responsive avatar">
								<a href="' . FXPP::my_url($user_link) . '">
								<div class="project-block">
									<span class="account-name">' . $value->UserId . '</span>
									<br>
										<span class="account-type">' . $AccountType . '</span>
									</div>
								</a>
							</div>',
                            $value->ProjectName,
                            $this->roundno(floatval($value->Balance), 2),
                            $this->roundno(floatval($value->Equity), 2),
                            $value->CurrentTrades,
                            $value->TotalTrades,
                            $this->roundno(floatval($value->DailyEquity), 2),
                            $this->getTotalDaysFromDate($value->RegisteredDate),
                            $btn,
                        );

                    }
                }


                $pendingList[] = $tempArray;
            }

            $result = array(
                'draw'            => $draw,
                'recordsTotal'    => (int) $dataCount,
                'recordsFiltered' => (int) $dataCount,
                'data'            => $pendingList
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($result));

        }
    }

    public function recommended_request()
    {
        if ($this->session->userdata('logged')) {
            if (!$this->input->is_ajax_request()) {
                die('Not authorized!');
            }
            $this->load->model('user_model');
            $visitor = $_SESSION['account_number'];
            $service_data = array('Offset' => 0, 'Limit' => 3, 'AccountNumber' => $visitor, 'sortBy' => '2');
            $ForexCopy = new ForexCopy();
            $ForexCopy->GetAllCopyTrader($service_data);

            $request_result = (array) $ForexCopy->GetAllResult();
            $dataCount = $request_result['DataCount']; //total count
            $traderData = $request_result['Traders']->MonitorAccountData;


            $data['top_trader_data'] = '';

            if (count($traderData) > 0) {
                foreach ($traderData as $value) {
                    $user_link = 'copytrade/monitor-user/' . $value->UserId;
                    $user_profile = $this->user_model->getUserAvatar($value->UserId);
                    if ($user_profile['cpy_avatar']) {
                        if (strpos($user_profile['cpy_avatar'], 'avatar') !== false) {
                            $avatar = 'https://my.forexmart.com/assets/images/trader_avatar/' . $user_profile['cpy_avatar'];
                        } else {
                            $avatar = 'https://my.forexmart.com/assets/user_images/' . $user_profile['cpy_avatar'];
                        }
                    } else {
                        $avatar = $this->template->Images() . 'trader_avatar/avatar-18.png'; //default
                    }

                    //$master_info = $this->copytrade_model->getMasterAccount($value['UserId']);
                    $master_info = $this->general_model->showssingle('mt_accounts_set', 'account_number', $value->UserId, 'mt_account_set_id');
                    $account_type = $this->general_model->getAccountTypeGroup($master_info['mt_account_set_id']);

                    $subsStatus = $value->SubscriptionStatus;
                    if ($subsStatus == 0) {
                        $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' type="button">' . lang('btn_subscribe') . '</button>';
                    } else if ($subsStatus == 1) {
                        $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' type="button" style="background-color: #d9534f;border-color: transparent;">' . lang('btn_cancel') . '</button>';
                    } else if ($subsStatus == 2) {
                        $btn = '<button class="btn-xs btn-main btnsubscribe" data-id = ' . $value->UserId . ' type="button" style="background-color: #d9534f;border-color: transparent;">' . lang('btn_unsubscribe') . '</button>';
                    }


                    $data['top_trader_data'] .= '
                <tr>
                     <td><img src=' . $avatar . ' class="img-responsive avatar">	<a href="' . FXPP::my_url($user_link) . '"><div class="project-block" style="display: inline-block; margin: 10px;"><span class="account-name">' . $value->UserId . '</span><br><span class="account-name" style="font-style: italic; ">' . $account_type . '</span></a></div></td>
                    <td>' . $value->ProjectName . '</td>
                    <td>' . $this->roundno(floatval($value->TotalProfitInUsd), 2) . '</td>
                    <td>' . $btn . '</td>
                </tr>';
                }
            } else {
                $data['top_trader_data'] .= '
                <tr>
                     <td colspan="4">No recommended accounts.</td>           
                </tr>';
            }


            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }


    public function getUserType($accountNumber)
    {
        $this->load->library('ForexCopy'); 
        
        $serviceData = array('Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
       // echo "<pre>"; print_r($ForexCopy);exit;
        
        $ForexCopy->GetAccountType($serviceData);
        $request_result = $ForexCopy->request_status;
        // 0 follower
        // 1 trader
        // 2 deactivated
        // 3 not registered

        return $request_result;
    }


    public function getConnectionsCopyTerms($connectionID)
    {

        $serviceData = array('ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetConnectionsCopyTerms($serviceData);

        if ($ForexCopy->request_status == 'RET_OK') {
            $request_result = (array) $ForexCopy->GetAllResult();
            $display = $request_result['DisplayValue'];
            $connectionData = $request_result['Result']->KeyValueOfintstring;
        }

        $connectionData = array(
            'copytermsDisplay' => $display,
            'copytermsRes'     => $connectionData,
        );

        return $connectionData;

    }


    public function getFollowerCopySettings($connectionID)
    { //old service
        $serviceData = array('ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetConnectionsCopySettings($serviceData);

        if ($ForexCopy->request_status == 'RET_OK') {
            $request_result = (array) $ForexCopy->GetAllResult();
        }

        return $request_result['Result']->KeyValueOfintstring;

    }


    public function isMaster($account_number)
    {

        if ($this->copytrade_model->get_where("forextrader_account_info", array('account_number' => $account_number, 'status' => 1))) {
            return true;
        }

        return false;
    }

    public function unsubscribeAccount()
    {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {

        $conId = $this->input->post('connection', true);
        $accountNumber = $_SESSION['account_number'];//login account
        $traderAccount = $this->input->post('trader', true);
        $followerAccount = $this->input->post('follower', true);
        $isSuccess = false;

        $serviceData = array('ConnectionId' => $conId, 'Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->UnsubscribeConnection($serviceData);
        if(!empty($ForexCopy->request_status)){
            if ($ForexCopy->request_status == 'RET_OK') {

                $isSuccess = true;
                $errorMsg = 'Update Successful.';
                $traderData = $this->account_model->getUserDetailsByAccountNumber($traderAccount);
                $followerData = $this->account_model->getUserDetailsByAccountNumber($followerAccount);


                $fEmail = array(
                    'email'       => $followerData['email'],
                    'trader_account' => $traderAccount,
                );


                Fx_mailer::forex_copy_follower_unsubscribe($fEmail);


                $tEmail = array(
                    'email'     => $traderData['email'],
                    'follower_account' => $followerAccount,
                );

                Fx_mailer::notify_unsubscribe_to_master($tEmail);


            } else if ($ForexCopy->request_status == 'RET_NOT_ENOUGH_FUND') {// follower fund is not enough
                $errorMsg = "Request to unsubscribe failed, Your balance is not enough to pay pending commission.";
            } else if ($ForexCopy->request_status == 'RET_CONNECTION_ERROR') { // when you call the method even when the account is already unsubscribe
                $errorMsg = "Request to unsubscribe failed, You have no active connection to this trader.";
                if($followerAccount == $accountNumber){
                    $errorMsg = "Request to unsubscribe failed, Trader rejected your follow request.";
                }else{
                    $errorMsg = "Request to unsubscribe failed, Follower cancelled the request to follow your account.";
                }


            } else {
                $errorMsg = "Webservice Failed: Status " . $ForexCopy->request_status . " Please try again.";
            }

        }else{
            $errorMsg = "Request timeout, Please try again later or contact support at support@forexmart.com.";

        }

        if (!$isSuccess) {
            if(!in_array($ForexCopy->request_status, array('RET_CONNECTION_ERROR','RET_NOT_ENOUGH_FUND','RET_TRANSFER_BLOCKED'))) {
                //send email report
                $errorData = array(
                    'account_number' => $this->session->userdata('account_number'),
                    'full_name'      => $this->session->userdata('full_name'),
                    'report_date'    => FXPP::getServerTime(),
                    'action'         => 'Follower ' . $followerAccount . ' unsubscribe from the account of Copytrading Trader ' . $traderAccount,
                    'error'          => 'UnsubscribeConnection method result: ' . $ForexCopy->request_status,
                );

                if(!empty($ForexCopy->request_status)){
                    Fx_mailer::copytradeReport($errorData);
                }

              
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess, 'err_msg' => $errorMsg, 'connection' => $conId, 'reqStatus' => $ForexCopy->request_status)));

    }
}


    public function upateFollowerStatus(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {

        $conId = $this->input->post('connection', true);
        $status = $this->input->post('status', true);
        $isSuccess = false;
        $errorMsg = 'Failed to update status.';
        $accountNumber = $_SESSION['account_number']; //login
        if ($status == 2) {
            $updateStatus = 'Approved';
        } else {
            $updateStatus = 'Reject';
        }


//            case '2': // approved
//            case '3': // rejected

        $serviceData = array('ConnectionId' => $conId, 'Status' => $status, 'Login' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->UpdatePendingFollower($serviceData);

        if ($ForexCopy->request_status === 'RET_OK') {
            $isSuccess = true;
            $errorMsg = 'Update Successful.';
        } else {
            if($ForexCopy->request_status === 'RET_CONNECTION_ERROR'){
                $errorMsg = "Request to " .strtolower($updateStatus). " failed, Follower cancelled the request to follow your account.";
            }else{
                $errorMsg = "Webservice Failed: Status " . $ForexCopy->request_status . ". Please try again.";
                //send email report
                $errorData = array(
                    'account_number' => $this->session->userdata('account_number'),
                    'full_name'      => $this->session->userdata('full_name'),
                    'report_date'    => FXPP::getServerTime(),
                    'action'         => $updateStatus . ' Subscription Request of Connection Id ' . $conId,
                    'error'          => 'UpdatePendingFollower method result: ' . $ForexCopy->request_status,
                );

                if(!in_array($ForexCopy->request_status, array('RET_CONNECTION_ERROR','RET_TRANSFER_BLOCKED'))) {
                    if(!empty($ForexCopy->request_status)){
                        Fx_mailer::copytradeReport($errorData);
                    }
                }

           }


        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isSuccess, 'err_msg' => $errorMsg, 'connection' => $conId, 'request_status' => $ForexCopy->request_status)));
    }
    }

    private function roundno($number,$dp) {
        return number_format((float)$number, $dp,'.','');
    }
    public function UpdateCopySettings(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {
            $is_success = false;
            $errormsg = 'Update Failed';


            if($_POST['page'] == 1){
                $trader   = $this->input->post('trader',true);
                $follower = $this->session->userdata('account_number');
            }else{
                $trader = $this->input->post('trader',true);;
                $follower = $this->input->post('follower',true);
            }

            $conId = $this->input->post('connection_id',true);
            $conId = !empty($conId) ? $conId : $this->isSubscibeToTrader($trader, $follower)['connection'];


            if(!empty($conId)) {
                $c1 = $this->input->post('copy_settings_values_1',true);
                $c2_default = $this->input->post('copy_settings_2_default',true);
                $c2 = $this->input->post('copy_settings_values_2',true);
                $c3 = $this->input->post('copy_settings_values_3',true);
                $c7 = $this->input->post('dont_copy',true);
                $c8 = $this->input->post('copy_options',true);
                $c9 = $this->input->post('copy_inverse',true);

                if($this->input->post('limited_or_fixed',true) == 1){
                    $c5 = $this->input->post('fixed_lot',true);
                    $c6 = $this->input->post('fixed_lot',true);
                }else{
                    $c5 = $this->input->post('max_lot_open',true);
                    $c6 = $this->input->post('min_lot_open',true);
                }


                $sum = array_sum($_POST['quotes']);
                $copySettingData = array(
                    'connectionId'   => $conId,
                    'accountNumber'  => $follower,
                    'copysettings_1' => $c1 < 1 ? $sum : $c1,
                    'copysettings_2' => !empty($c2) ? $c2 : $c2_default,
                    'copysettings_3' => $c3,
                    'copysettings_5' => $c5,
                    'copysettings_6' => $c6,
                    'copysettings_7' => isset($c7) ? $c7 : 0,
                    'copysettings_8' => isset($c8) ? $c8 : 0,
                    'copysettings_9' => isset($c9) ? $c9 : 0,
                );



                    

                $WS_S = new ForexCopy();
                $WS_S->UpdateCopySettings($copySettingData);
                if ($WS_S->request_status === 'RET_OK') {
                    $is_success = true;

                }else{
                    if($WS_S->request_status == 'RET_AUTHENTICATION_FAILED'){
                        $errormsg = "Your subscription update request is not yet approved.";

                    }else{
                        $errormsg = "Webservice Failed: Status ".$WS_S->request_status ." Please try again.";
                    }



                    //send email report
                    $errorData = array(
                        'account_number'       => $this->session->userdata('account_number'),
                        'full_name'            => $this->session->userdata('full_name'),
                        'report_date'           => FXPP::getServerTime(),
                        'action'               => 'Update copy settings of connection id '.$conId,
                        'error'                => 'UpdateCopySettings method result: ' .$WS_S->request_status,
                    );


                    if(!IPloc::IPOnlyForVenus()){
                        if(!in_array($WS_S->request_status, array('RET_AUTHENTICATION_FAILED','RET_INTERNAL_ERROR'))) {
                            Fx_mailer::copytradeReport($errorData);

                            /*forexcopy_log*/
                            $this->load->model('Logs_model');
                            $logData = array(
                                'account_number' => $_SESSION['account_number'],
                                'method'         => 'UpdateCopySettings',
                                'request_data'   => json_encode($copySettingData),
                                'status'         => $WS_S->request_status,
                                'date'           => FXPP::getCurrentDateTime()
                            );

                            $this->Logs_model->insert_log($table = "forexcopy_log", $logData);
                        }

                    }
                }
            }else{
                /*forexcopy_log*/
                $this->load->model('Logs_model');
                $logData = array(
                    'account_number' => $_SESSION['account_number'],
                    'method'         => 'UpdateCopySettings',
                    'request_data'   => json_encode($_POST),
                    'status'         => 'Connection ID NULL',
                    'date'           => FXPP::getCurrentDateTime()
                );

                $this->Logs_model->insert_log($table = "forexcopy_log", $logData);
                $errormsg = "Connection Id is required. Please try again or contact support.";

            }


            $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>$is_success,'err_msg' => $errormsg)));

        }
    }
    public function UpdateCopySettingsv2()
    {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {
            $is_success = false;
            $errormsg = 'Update Failed';
            $conId = $this->input->post('connection_id',true);

            if($_POST['page'] == 1){
                $trader   = $this->input->post('trader',true);
                $follower = $this->session->userdata('account_number');
            }else{
                $trader = $this->input->post('trader',true);;
                $follower = $this->input->post('follower',true);
            }

            $c1 = $this->input->post('copy_settings_values_1',true);
            $c2 = $this->input->post('copy_settings_values_2_part_2',true);
            //$c2 = $this->input->post('icopy_settings_values_2_total',true);
            $c3 = $this->input->post('copy_settings_values_3',true);
            $c5 = $this->input->post('max_lot_open',true);
            $c6 = $this->input->post('min_lot_open',true);
            $c7 = $this->input->post('dont_copy',true);
            $c8 = $this->input->post('copy_options',true);
            $c9 = $this->input->post('copy_inverse',true);

            $sum = array_sum($_POST['quotes']);
            $copySettingData = array(
                'connectionId'   => $conId,
                'accountNumber'  => $follower,
                'copysettings_1' => $c1 < 1 ? $sum : $c1,
                'copysettings_2' => $c2,
                'copysettings_3' => $c3,
                'copysettings_5' => $c5,
                'copysettings_6' => $c6,
                'copysettings_7' => isset($c7) ? $c7 : 0,
                'copysettings_8' => isset($c8) ? $c8 : 0,
                'copysettings_9' => isset($c9) ? $c9 : 0,
            );

            $WS_S = new ForexCopy();
            $WS_S->UpdateCopySettings($copySettingData);
            if ($WS_S->request_status === 'RET_OK') {
                $is_success = true;
                $account_info_update = array(
                    'copy_data'  => json_encode($_POST),
                );
                $this->copytrade_model->updateCopytrade(array('follower_number' => $follower,'master_number' =>$trader),$account_info_update);
            }else{
                if($WS_S->request_status == 'RET_AUTHENTICATION_FAILED'){
                    $errormsg = "Your subscription update request is not yet approved.";

                }else{
                    $errormsg = "Webservice Failed: Status ".$WS_S->request_status ." Please try again.";
                }



                //send email report
                $errorData = array(
                    'account_number'       => $this->session->userdata('account_number'),
                    'full_name'            => $this->session->userdata('full_name'),
                    'report_date'           => FXPP::getServerTime(),
                    'action'               => 'Update copy settings of connection id '.$conId,
                    'error'                => 'UpdateCopySettings method result: ' .$WS_S->request_status,
                );


                   if(!IPloc::IPOnlyForVenus()){
                       if(!in_array($WS_S->request_status, array('RET_AUTHENTICATION_FAILED','RET_INTERNAL_ERROR'))) {
                           Fx_mailer::copytradeReport($errorData);

                           /*forexcopy_log*/
                           $this->load->model('Logs_model');
                           $logData = array(
                               'account_number' => $_SESSION['account_number'],
                               'method'         => 'UpdateCopySettings',
                               'request_data'   => json_encode($copySettingData),
                               'status'         => $WS_S->request_status,
                               'date'           => FXPP::getCurrentDateTime()
                           );

                           $this->Logs_model->insert_log($table = "forexcopy_log", $logData);
                       }

                   }
               }


            $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>$is_success,'err_msg' => $errormsg)));

        }
    }
    public function subscribeToTrader(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {


            //check status
            $tStatus = $this->getUserType($_SESSION['account_number']);
            $is_success = false;
            $success_data=array();
            if($tStatus == 2){
                $reqStatus = "RET_DEACTIVATED";
                $errormsg = "Your account status is deactivated, Please re-activate your account to follow this trader.";
            }else{
                $fm_acc_type = array(
                    '1' =>'ForexMart Standard',
                    '2' => 'ForexMart Zero Spread',
                    '4' => 'ForexMart Micro Account',
                    '5' => 'ForexMart Classic',
                    '6' => 'ForexMart Pro',
                    '7' => 'ForexMart Cents',
                );
                $fm_acc_type = array(
                    '1' => lang('copytrade_03'),
                    '2' => lang('copytrade_00'),
                    '4' => lang('copytrade_04'),
                    '5' => lang('copytrade_01'),
                    '6' => lang('copytrade_02'),
                    '7' => lang('copytrade_05'),
                );

                $errormsg = 'Subscription Failed';
                $follower = $_SESSION['account_number'];
                $trader = $this->input->post('account_number',true);
                $copysetting1 = $this->input->post('copy_settings_values_1',true);
                $copysetting2 = $this->input->post('copy_settings_values_2',true);
                $copysetting3 = $this->input->post('copy_settings_values_3',true);
                $copysetting6 = $this->input->post('dont_copy',true);
                $copysetting7 = $this->input->post('copy_options',true);
                $copysetting8 = $this->input->post('copy_inverse',true);

                if($this->input->post('limited_or_fixed',true) == 1){
                    $copysetting4 = $this->input->post('fixed_lot',true);
                    $copysetting5 = $this->input->post('fixed_lot',true);
                }else{
                    $copysetting4 = $this->input->post('max_lot_open',true);
                    $copysetting5 = $this->input->post('min_lot_open',true);
                }

                $sum =  array_sum($_POST['quotes']);
                $account_info = array(
                    'follower'              => $follower,
                    'trader'                => $trader,
                    'copysettings_1'        => $copysetting1 < 1 ?  $sum : $copysetting1,
                    'copysettings_2'        => isset($copysetting2) ? $copysetting2 : 1 ,
                    'copysettings_3'        => $copysetting3,
                    'copysettings_5'        => $copysetting4,
                    'copysettings_6'        => $copysetting5,
                    'copysettings_7'        => isset($copysetting6) ? $copysetting6 : 0,
                    'copysettings_8'        => isset($copysetting7) ? $copysetting7 : 0,
                    'copysettings_9'        => isset($copysetting8) ? $copysetting8 : 0,
                );


                $master_type = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $account_info['trader']))['mt_account_set_id'];
                $follower_type = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $account_info['follower']))['mt_account_set_id'];

                $resConn = $this->isSubscibeToTrader($trader,$follower);




                if(!$resConn['status']){ // proceed if no  active connection id
                    if($master_type != $follower_type ){
                        $reqStatus = 'ACCOUNT_TYPE_NOT_THE_SAME';
                        $is_success = false;
                        $tradersData = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $trader));
                        $accountType = $fm_acc_type[$tradersData['mt_account_set_id']];
                        $errormsg = "This account uses &ldquo;" . $tradersData['mt_currency_base'] . "&rdquo; currency and  &ldquo;" . $accountType . "&rdquo; account in his trading strategy, register same &ldquo;account type&rdquo; and &ldquo;currency&rdquo; to proceed with your request.";

                    }else{


                        $WS_S = new ForexCopy();
                        $WS_S->SubscribeToTrader($account_info);
                        $reqStatus = $WS_S->request_status;


                        if ($reqStatus === 'RET_OK') {
                            $is_success = true;

                            
                              $subscription_data = $this->isSubscibeToTrader($trader,$follower);
                    
                            $success_data['is_subscribe'] = $subscription_data['status'];
                            $success_data['connection'] = $subscription_data['connection'];
                    
                            $master_email = $this->account_model->getUserDetailsByAccountNumber($account_info['trader']);
                            $f_email_data = array(
                                'trader_account' => $trader,
                                'email' => $_SESSION['email'],
                            );
                            Fx_mailer::forex_copy_follower_subscribe($f_email_data);


                            $m_email_data = array(
                                'follower_account' => $follower,
                                'email' => $master_email['email'],
                            );


                            Fx_mailer::notify_subscribe_to_master($m_email_data);

                        }else if($reqStatus === 'RET_INVALID_ACCOUNT'){
                            $errormsg = 'Please activated your account before you subscribe.';
                        }else if($reqStatus === 'RET_ARCHIVED_ACCOUNT'){

                            //check if not readonly-status
                            $mtDetails =  FXPP::getMTUserDetails2($follower);
                            if($mtDetails[0]->IsReadOnly == 1){
                                $errormsg = 'Your trading status is Read-Only, Please activate your account to subscribe to this trader.';
                            }else{
                                $errormsg = 'Unfortunately, This copytrading trader account has been archived after 90 days inactivity period. Please, contact support department if you want to restore the account.';
                            }
                        }else if($reqStatus === 'RET_INVALID_PARAMETERS'){
                            $errormsg = 'Subscription Failed: This trader is subscribed to you.';
                        }else{
                            $errormsg = 'Subscription Failed ' .$reqStatus;

                        }

                    }
                    
                }else{
                    $errormsg = 'Your account is already subscribed.';
                    $reqStatus = 'RET_CON_ID_EXIST';
                    $is_success = false;
                }
            }


           

            if(!$is_success){
                if(!in_array($reqStatus, array('RET_CON_ID_EXIST','ACCOUNT_TYPE_NOT_THE_SAME','RET_CURRENCY_ISSUE_ERROR','RET_INVALID_PARAMETERS','RET_ARCHIVED_ACCOUNT','RET_DEACTIVATED'))){
                    //send email report
                    if(!empty($reqStatus)){
                        $errorData = array(
                            'account_number'       => $this->session->userdata('account_number'),
                            'full_name'            => $this->session->userdata('full_name'),
                            'report_date'           => FXPP::getServerTime(),
                            'action'               => 'Subscribe to copytrading Trader '.$trader,
                            'error'                => 'SubscribeToTrader method result: ' .$reqStatus
                        );

                        Fx_mailer::copytradeReport($errorData);
                    }

                 }
               }
                /*forexcopy_log*/
                $this->load->model('Logs_model');
                $logData =array(
                    'account_number'  => $_SESSION['account_number'],
                    'method'          => 'SubscribeToTrader',
                    'request_data'    => json_encode($account_info),
                    'status'          => $reqStatus,
                    'date'            => FXPP::getCurrentDateTime()
                );

                $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                /*forexcopy_log*/


                    

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>$is_success,'data'=>$success_data,'err_msg' => $errormsg)));

        }
    }
    /*
     * Register  as Forexcopy trader and Active account.
     *
     */
    public function register_master(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {
            $account_number = $_SESSION['account_number'];
            $is_success = false;
            $errormsg = 'Registration Failed';
            $fm_acc_type = array(
                '1' =>'ForexMart Standard',
                '2' => 'ForexMart Zero Spread',
                '4' => 'ForexMart Micro Account',
                '5' => 'ForexMart Classic',
                '6' => 'ForexMart Pro',
                '7' => 'ForexMart Cents',

            );

                $data_key = 0;
                $data_value = 0;

                $array_cond_key = array(
                    'conditions_values_1' => 1,
                    'conditions_values_2'  => 2,
                    'conditions_values_3'  => 3,
                    'conditions_values_4'  => 4,
                    'conditions_values_10'  => 10,
                    'conditions_values_7'  => 7,
                );

                foreach($_POST as $key => $value){
                    if (array_key_exists($key, $array_cond_key)) {
                        if($value != 'Do not use' && $value != null){
                            $data_key = $array_cond_key[$key];
                            $data_value = $value;
                        }
                    }
                }


                $registerData = array(
                    'ProjectName' => $this->input->post('project_name', true),
                    'IsEu'         =>  false,
                    'LangNotify'   =>  $this->input->post('notify_lang', true) ,
                    'UserId'       =>  $account_number, // client login
                    'IsTrader'     =>  true, //(true for trader, false for follower)
                    'Commission_type'     => $data_key,
                    'Commission_value'    => $data_value,
                );
                


                $SvcRegister= new ForexCopy();
                $SvcRegister->RegisterForexCopy($registerData);
                $data['service'] = $SvcRegister->request_status;

                if ($SvcRegister->request_status === "RET_OK_REG_AS_TRADER" || $SvcRegister->request_status === "RET_OK") {
                    $is_success = true;


                    $email_data = array(
                        'email' => $_SESSION['email'],
                    );

                    Fx_mailer::forex_copy_trader_subscribe($email_data);

                }else{
                    if($SvcRegister->request_status=='RET_ALREADY_REGISTER') {
                        $data['errorMsg'] =  $errormsg ='Your account is already registered as copytrading trader.';

                    }else if($SvcRegister->request_status=='RET_DUPLICATE_PROJECT_NAME' || $SvcRegister->request_status=='RET_INVALID_PROJECT_NAME'){
                        $data['errorMsg'] =  $errormsg = $this->input->post('project_name', true). ' is already used.';
                    }else if($SvcRegister->request_status=='RET_CURRENCY_ISSUE_ERROR'){


                        $tradersData = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $account_number));
                        $accountType = $fm_acc_type[$tradersData['mt_account_set_id']];
                        $data['errorMsg'] = "This account uses &ldquo;" . $tradersData['mt_currency_base'] . "&rdquo; currency and  &ldquo;" . $accountType . "&rdquo; account in his trading strategy, register same &ldquo;account type&rdquo; and &ldquo;currency&rdquo; to proceed with your request.";

                    }else{
                        $data['errorMsg'] =  $errormsg = 'Webservice Error: ' . $SvcRegister->request_status;;
                    }

                    $is_success = false;
                }



            if( !$is_success){
                //send email report
                if(!in_array($SvcRegister->request_status, array('RET_DUPLICATE_PROJECT_NAME','RET_INVALID_PARAMETERS','RET_INVALID_PROJECT_NAME','RET_ALREADY_REGISTER','RET_INTRRNERNAL_ERROR'))) {
                    if(!empty($SvcRegister->request_status)) {
                        $errorData = array(
                            'account_number' => $this->session->userdata('account_number'),
                            'full_name'      => $this->session->userdata('full_name'),
                            'report_date'    => FXPP::getServerTime(),
                            'action'         => 'Register as copytrading Trader',
                            'error'          => 'Register method result: ' . $SvcRegister->request_status,
                        );

                        Fx_mailer::copytradeReport($errorData);
                    }
                }

            }
                /*forexcopy_log*/
                $this->load->model('Logs_model');
                $logData =array(
                    'account_number'  => $_SESSION['account_number'],
                    'method'          => 'Register Trader',
                    'request_data'    => json_encode($registerData),
                    'status'          => $SvcRegister->request_status,
                    'date'            => FXPP::getCurrentDateTime()
                );

                $this->Logs_model->insert_log($table="forexcopy_log",$logData);
            

            if($data['all_master_info'] = $this->copytrade_model->getMasterAccount($_SESSION['account_number'])) {
                $data['is_success'] = true;
                $data['all_master_info']['account_type'] = $fm_acc_type[$_SESSION['mt_account_set_id']];

            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>$is_success,'errorMsg' => $errormsg,'data' => $data)));
        }

    }
    public function register_follower(){

        if ($this->session->userdata('logged')) {
            if (!$this->input->is_ajax_request()) {die('Not authorized!');}
            $data['isSubscribe'] = false;
            $data['isSuccess'] = false;
            $data['errorMsg'] = '';
            
            $trader_data = $this->getUserType($_SESSION['account_number']);
            if ($trader_data == 0 || $trader_data == 1 || $trader_data == 2) {
                $data['isSubscribe'] = true;
                redirect(FXPP::my_url('copytrade'));
            }else{
                $service_data = array(
                    'IsEu'       => false,
                    'LangNotify' => 'en',
                    'UserId'     => $_SESSION['account_number'], // client login
                    'IsTrader'   => false, //(true for trader, false for follower)
                );

                    $SvcRegister = new ForexCopy();
                    $SvcRegister->RegisterForexCopy($service_data);
                if ($SvcRegister->request_status === "RET_OK_REG_AS_FOLLOWER" || $SvcRegister->request_status === "RET_OK") {
                    $data['isSuccess'] = true;
                    $email_data = array(
                        'email' => $_SESSION['email'],
                        'account_number' => $_SESSION['account_number'],
                         'full_name' => $_SESSION['full_name'],
                    );

                    Fx_mailer::forex_copy_follower_register($email_data);
                    
                 
                } else {
                    if($SvcRegister->request_status=='RET_ALREADY_REGISTER') {
                        $data['errorMsg'] =  $errormsg ='Your account is already registered as copytrading follower.';

                    }else if($SvcRegister->request_status=='RET_CURRENCY_ISSUE_ERROR' ){

                        $fm_acc_type = array(
                            '1' =>'ForexMart Standard',
                            '2' => 'ForexMart Zero Spread',
                            '4' => 'ForexMart Micro Account',
                            '5' => 'ForexMart Classic',
                            '6' => 'ForexMart Pro',
                            '7' => 'ForexMart Cents',

                        );

                        $tradersData = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $_SESSION['account_number']));
                        $accountType = $fm_acc_type[$tradersData['mt_account_set_id']];
                        $data['errorMsg'] = "This account uses &ldquo;" . $tradersData['mt_currency_base'] . "&rdquo; currency and  &ldquo;" . $accountType . "&rdquo; account in his trading strategy, register same &ldquo;account type&rdquo; and &ldquo;currency&rdquo; to proceed with your request.";


                    }else{
                        $data['errorMsg'] = 'Registration Failed. Please try again.';
                    }

                    /*forexcopy_log*/
                    $this->load->model('Logs_model');
                    $logData =array(
                        'account_number'  => $_SESSION['account_number'],
                        'method'          => 'Register',
                        'request_data'    => json_encode($service_data),
                        'status'          => $SvcRegister->request_status,
                        'date'            => FXPP::getCurrentDateTime()
                    );

                    $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                    /*forexcopy_log*/
                }
            }


            if(!$data['isSuccess']){
                if(!in_array($SvcRegister->request_status, array('RET_CURRENCY_ISSUE_ERROR','RET_ALREADY_REGISTER','RET_INTERNAL_ERROR'))) {
                    $errorData = array(
                        'account_number' => $this->session->userdata('account_number'),
                        'full_name'      => $this->session->userdata('full_name'),
                        'report_date'    => FXPP::getServerTime(),
                        'action'         => 'Register as copytading Follower',
                        'error'          => 'Register method result: ' . $SvcRegister->request_status,
                    );

                    Fx_mailer::copytradeReport($errorData);
                }
            }


            

            $this->output->set_content_type('application/json')->set_output(json_encode($data));

        }
            
            


    }
    public function monitor_user($account){
        if ($this->session->userdata('logged')) {
            $allowStatus = array('0','1','2');
            $trader_data = $this->getUserType($_SESSION['account_number']);
            if (!in_array($trader_data, $allowStatus)) {
                redirect(FXPP::my_url('copytrade'));
            }
            $this->input->set_cookie('monitor_account', null, time() + (3600 * 24), '.forexmart.com', '/', '', false); // unset

            $data['hide_subscription'] = false;
            if($_SESSION['account_number'] == $account){
                $data['hide_subscription'] = true;
            }
        
            $fm_acc_type = array(
                '1' =>'ForexMart Standard',
                '2' => 'ForexMart Zero Spread',
                '4' => 'ForexMart Micro Account',
                '5' => 'ForexMart Classic',
                '6' => 'ForexMart Pro',
                '7' => 'ForexMart Cents',
            );

            $tradersData = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $account));
            $master_type = $tradersData['mt_account_set_id'];

            $subscription_data = $this->isSubscibeToTrader($account,$_SESSION['account_number']);
            $data['is_subscribe'] = $subscription_data['status'];
            $data['connection'] = $subscription_data['connection'];


           // $trader_data = $this->getUserType($account);
            $data['IsTrader'] = $trader_data;
            $data['subscribeToTrader'] = 1;
            $trader_con = array();

            $copytermsDetails = $this->GetTraderCopyTerms($account);
            foreach ($copytermsDetails['copyTerms'] as $con_value){
                $con_key = 'conditions_values_' . $con_value->Key;
                $trader_con[$con_key] = $con_value->Value;
            }



            
            
            $data['parameters_account']=$account;
            $visitor = $_SESSION['account_number'];

            $data['copytermsDisplay'] = $copytermsDetails['commission'];

            $fc_details = $this->GetTraderUserDetails($account,$visitor);
            
             // fc_details  SimpleRating  ForumTopic
//            
//            if(IPLoc::IPOnlyForTq())
//            {
//                echo "<pre>"; print_r($fc_details);exit;
//            }
            
            
            if(empty($fc_details['UserId'])){
                $fc_details['UserId'] = $account;
                
            }

            $data['fc_details'] = $fc_details;
            $data['project'] = htmlspecialchars (ucwords(strtolower($fc_details['ProjectName'])),ENT_QUOTES);
            
           
            $data['fc_details']['account_type'] = $fm_acc_type[$master_type];
            $data['fc_details']['account_currency'] = $fc_details['Currency'];


            $balanceDetails =  $this->GetUserBalanceCache($account,$visitor);
            $data['bal_details'] = $balanceDetails;
            $data['bal_details']['DailyProfit'] = $this->roundno(floatval($balanceDetails['DailyProfit']),2).'%';
            $data['bal_details']['WeeklyProfit'] = $this->roundno(floatval($balanceDetails['WeeklyProfit']),2).'%';
            $data['bal_details']['MonthlyProfit'] = $this->roundno(floatval($balanceDetails['MonthlyProfit']),2).'%';
            $data['bal_details']['Monthly3Profit'] = $this->roundno(floatval($balanceDetails['Monthly3Profit']),2).'%';
            $data['bal_details']['Monthly6Profit'] = $this->roundno(floatval($balanceDetails['Monthly6Profit']),2).'%';
            $data['bal_details']['Monthly9Profit'] = $this->roundno(floatval($balanceDetails['Monthly9Profit']),2).'%';
            $data['bal_details']['TotalProfit'] = $this->roundno(floatval($balanceDetails['TotalProfit']),2).'%';
            $data['fc_details']['ActiveFollowers'] = $balanceDetails['ActiveFollowers'];

            $language = FXPP::html_url(); // change language

           
            
            $fc_detailsDesc = $this->GetTraderDescription($account,$visitor);


//            if(IPLoc::IPOnlyForTq())
//            {
//               // echo "<pre>"; print_r($fc_detailsDesc);exit;
//            }


            $english = '';
            foreach ($fc_detailsDesc as $desc_value){
                $desc_key = 'desc_' . $desc_value->Key;
                $data['fc_details'][$desc_key] = $desc_value->Value;
                if($desc_value->Key == 4){ $english = $desc_value->Value;} //default;

                switch ($language) {
                    case 'ru':
                        if($desc_value->Key == 1){ $data['fc_details']['language_desc'] = empty($desc_value->Value) ? $english : $desc_value->Value;}break;
                    case 'jp':
                        if($desc_value->Key == 2){ $data['fc_details']['language_desc'] = empty($desc_value->Value) ? $english : $desc_value->Value;}break;
                    case 'pl':
                        if($desc_value->Key == 3){ $data['fc_details']['language_desc'] = empty($desc_value->Value) ? $english : $desc_value->Value;}break;
                    default:
                        if($desc_value->Key == 4){ $data['fc_details']['language_desc'] = empty($desc_value->Value) ? $english : $desc_value->Value;}break;
                }
            }


            $last_update = $balanceDetails['LastUpdate'];
            $last_update_monitor = new DateTime("@$last_update");
            $data['fc_details']['LastUpdate']  = $last_update_monitor->format('Y-m-d H:i:s');
           //$page = 'copytrade/fc_monitoring_project';
            $page = 'copytrade/monitor_project';
            $data['trader_data'] = $trader_con;
            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("              
                 <link rel='stylesheet' href='".$css."copytrade_style.css'>
                 <link rel='stylesheet' href='".$css."copytrade_circle.css'>    
                 <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>             
              ")
                ->append_metadata_js("                       
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."bootbox.min.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                      <script src='https://code.highcharts.com/highcharts.js'></script>
                      <script src='https://code.highcharts.com/modules/exporting.js'></script>
                      <script src='https://code.highcharts.com/modules/no-data-to-display.js'></script>
                ")
                ->set_layout('internal/main')
                ->build($page, $data);
        }else{
            //if($account == 150350){
                $this->input->set_cookie('monitor_account', $account, time() + (3600 * 24), '.forexmart.com', '/', '', false);
           // }
                
           $lang_code=(FXPP::html_url()!="" or FXPP::html_url()!="en")?FXPP::html_url()."/":'';      
            redirect($lang_code.'signout');
        }


    }
    public function profile(){

        if ($this->session->userdata('logged')) {
            $this->load->model('user_model');
            $account = $_SESSION['account_number'];

            $trader_data = $this->getUserType($_SESSION['account_number']);
            if($trader_data == 0 || $trader_data == 1 || $trader_data == 2){
                $data['IsTrader'] = $trader_data;
            }else{
                redirect(FXPP::my_url('copytrade'));
            }

            $fc_details = $this->GetTraderUserDetails($account,$account);
            $monitor_time = $fc_details['MonitoringStart'];
            $monitor_start = new DateTime("@$monitor_time");
           // $fc_details['MonitoringStart'] = $monitor_start->format('YYYY/MM/DD');
            $fc_details['MonitoringStart'] = $monitor_start->format('Y-m-d');
            $data['details'] = $fc_details;


            $copytermsDetails = $this->GetTraderCopyTerms($account);
            
            $ForexCopy = new ForexCopy();
            $data['rollover_status'] = $ForexCopy->GetMyRollOverStatus();

            $copytermsDetails = $this->GetTraderCopyTerms($account);
           // var_dump($copytermsDetails); exit();
          
          $data['profitShare'] = ($copytermsDetails['copyTerms'][0]->Key == 3) ? true : false;

          $data['change_rollover'] = true;
         
           /* if($data['profitShare']){
                if(strtotime(date('Y-m-d H:i')) < strtotime('-30 days')) {
                    $data['change_rollover'] = true;
                }else{
                    $data['change_rollover'] = false;
                }
            }*/

            

//            if(IPLoc::frz())
//            {
//                echo "<pre>"; print_r($copytermsDetails);exit;
//            }
            
            foreach ($copytermsDetails['copyTerms'] as $con_value){
                $con_key = 'conditions_values_' . $con_value->Key;
                $data['details'][$con_key] = $con_value->Value;
            }
            
            if(IPloc::IPOnlyForVenus()){
                $data['details']['cpType'] = $copytermsDetails['copyTerms'][0]->Key;
            }

            $fc_detailsDesc = $this->GetTraderDescription($account,$account);
            foreach ($fc_detailsDesc as $desc_value){
                $desc_key = 'desc_' . $desc_value->Key;
                $data['details'][$desc_key] = $desc_value->Value;
            }



            $user_profile = $this->user_model->getUserAvatar( $_SESSION['account_number'] );
            $data['image'] = $user_profile['cpy_avatar'];
            if (strpos($data['image'], 'avatar') !== false) {
                $data['imageUrl'] =   'https://my.forexmart.com/assets/images/trader_avatar/' . $user_profile['cpy_avatar'];
            }else{
                $data['imageUrl'] =  'https://my.forexmart.com/assets/user_images/' . $user_profile['cpy_avatar'];
            }

//            
//              if(IPLoc::frz())
//            {
//                  if(isset($_GET['frz'])){
//                      if($_GET['frz']=="frz"){
//                    echo "<pre>"; print_r($data['details']);exit;
//                      }
//                  }
//            }
            
         
            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='".$css."copytrade_style.css'>
                 <link rel='stylesheet' href='".$css."copytrade_circle.css'>    
                 <link rel='stylesheet' href='".$this->template->Css()."dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='".$this->template->Css()."bootstrap-datetimepicker.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>             
              ")
                ->append_metadata_js("
               
                       <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                       <script src='".$this->template->Js()."bootbox.min.js'></script>
                       <script src='".$this->template->Js()."Moment.js'></script>
                       <script src='".$this->template->Js()."bootstrap-datetimepicker.min.js'></script>
                       <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('copytrade/profile', $data);
        }else{
            redirect('signout');
        }


    }
    public function update_profile(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $account_number =  $_SESSION['account_number'];
        $type = $this->getUserType($account_number);
        $account_info = array(
            'project_name'  => $this->input->post('project_name', true),
            'lang_notify'   => $this->input->post('lang_notify', true),
            'commission_acc' => $this->input->post('commission_acc', true),
            'topic_theme' => $this->input->post('topic_theme', true),
            'show_acc_name' => $this->input->post('show_acc_name', true),
            'icq' => $this->input->post('icq', true),
            'show_icq' => $this->input->post('show_icq', true),
            'skype' => $this->input->post('skype', true),         
            'show_skype' => $this->input->post('show_skype', true),              
            'email' => $this->input->post('email', true),
            'phone' => $this->input->post('phone', true),  
            'show_email' => $this->input->post('show_email', true),
            'show_phone' => $this->input->post('show_phone', true),
            'mon_start' => $this->input->post('mon_start', true),
            'show_deals' => $this->input->post('show_deals', true),
            'alerts_email' => $this->input->post('alerts_email', true),
            'alerts_sms' => $this->input->post('alerts_sms', true),
            'alert_unsubscribe' => $this->input->post('alerts_sms', true),
            'user_spec_param_1' => $this->input->post('user_spec_param_1', true),
            'close_project' => $this->input->post('close_project', true),
            'open_project' => $this->input->post('open_project', true),
            'commission_payer' => $this->input->post('commission_payer', true),
            'conditions_values_1' => $this->input->post('conditions_values_1', true),
            'conditions_values_2' => $this->input->post('conditions_values_2', true),
            'conditions_values_10' => $this->input->post('conditions_values_10', true),
            'conditions_values_3' => $this->input->post('conditions_values_3', true),
            'conditions_values_4' => $this->input->post('conditions_values_4', true),
            'conditions_values_6' => $this->input->post('conditions_values_6', true), // auto approve request
            'rollover_status' => $this->input->post('rollover_status', true), // rollover type
        );
        
                    
        
        $account_desc_info = array(
            'accountNumber' => $account_number,
            'desc_en' => $this->input->post('desc_en', true),
            'desc_ru' => $this->input->post('desc_ru', true),
            'desc_jp' => $this->input->post('desc_jp', true),
            'desc_pl' => $this->input->post('desc_pl', true),

        );


        $mon_date = new DateTime($account_info['mon_start']);

        $account_update = array(
            //'ProjectName' => $account_info['project_name'],
            'accountNumber' => $account_number,
            'Icq' => $account_info['icq'],
            'Skype' => $account_info['skype'],
            'Email' => $account_info['email'],
            'Phone' => $account_info['phone'],
            'ShowIcq' => $account_info['show_icq'],
            'ShowSkype' => $account_info['show_skype'],
            'ShowEmail' => $account_info['show_email'],
            'ShowPhone' => $account_info['show_phone'],
            'ShowAccountName' => $account_info['show_acc_name'],
            'ShowDeals' => $account_info['show_deals'],
            'MonitoringStart' => $mon_date->getTimestamp(),
            'AlertUnsubscribe' => $account_info['alert_unsubscribe'],
        );

                    

        $user = $this->GetTraderUserDetails($account_number,$account_number);
        $projectNameOld = $user['ProjectName'];

        if(empty($projectNameOld)){
            $account_update['ProjectName'] = '';
        }else{
            if(trim($account_info['project_name']) != trim($projectNameOld)){
                $account_update['ProjectName'] = $account_info['project_name'];
            }
        }
        

        $account_update_f = array(
            'accountNumber' => $account_number,
            'AlertUnsubscribe' => $account_info['alert_unsubscribe'],
        );

        $ForexCopyRollover = new ForexCopy();
        $currentRollover = $ForexCopyRollover->GetMyRollOverStatus();

        $commissionType  = $this->GetTraderCopyTermsKey();
        if($commissionType == 3){
        
            if(isset($account_info['rollover_status'])){
                $SvcRollover = new ForexCopy();
                $SvcRollover->UpdateRollOverStatus(array('status' => $account_info['rollover_status']));

                if ($SvcRollover->request_status === "RET_OK") {
                    $is_success_0 = true;

                    $isRolloverEqual  =  ($currentRollover  == $account_info['rollover_status']) ? true : false;

                    //if(IPloc::RolloverTest()){

                    if(!$isRolloverEqual){
                        $updateRollover = [
                            'rollover_status' => $account_info['rollover_status'],
                            'rollover_date_modified' => date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime())),
                        ];
                        $this->general_model->updatemy($table = 'users', 'id', $_SESSION['user_id'], $updateRollover);
                        Fx_mailer::forex_copy_rolloverstatus(array('email' => $_SESSION['email'], 'type' => $account_info['rollover_status'])); //0 auto 1 manual

                    }


                    //}

                }else{
                    $errormsg_0 = 'Webservice Rollover Error: ' . $SvcRollover->request_status . ' <br>';
                    $is_success_0 = false;
                }
            }else{
                $is_success_0 = true;
            }

       }



        if($account_info['close_project'] == 1){ // deactivate account
            $deactivateData = array('accountNumber' => $account_number);
            $SvcDeactivate = new ForexCopy();
            $SvcDeactivate->DeactivateTrader($deactivateData);
            if ($SvcDeactivate->request_status === "RET_OK") {
                $is_success = true;
                $errormsg = 'Account deactivation has been successfully processed.';
                $account_email =  $this->account_model->getUserDetailsByAccountNumber($account_number);
                $email_data = array(
                    'email' => $account_email['email'],
                    'isTrader' => ($this->getUserType($account_number) == 1 ? true:false),
                );
                Fx_mailer::forex_copy_deactivate($email_data);

            }else if($SvcDeactivate->request_status == "RET_SUBSCRIPTION_ERROR" || $SvcDeactivate->request_status == "RET_CONNECTION_ERROR" ){
                $errormsg = 'Unsubscribe all your followers before deactivating your account.';
                $is_success = false;
            } else{
                $errormsg = 'Webservice Deactivate Error: ' . $SvcDeactivate->request_status . ' <br>';
                $is_success = false;
            }

            /*forexcopy_log*/
            $this->load->model('Logs_model');
            $logData =array(
                'account_number'  => $_SESSION['account_number'],
                'method'          => 'Deactivate',
                'request_data'    => json_encode($deactivateData),
                'status'          => $SvcDeactivate->request_status,
                'date'            => FXPP::getCurrentDateTime()
            );

            $this->Logs_model->insert_log($table="forexcopy_log",$logData);
        }else if($account_info['open_project'] == 1){ //re activate account
            if($account_info['open_project'] == 1){
                $activateData = array('accountNumber' => $account_number);
                $SvcActivate = new ForexCopy();
                $SvcActivate->ActivateTrader($activateData);
                if ($SvcActivate->request_status === "RET_OK") {
                    $is_success = true;
                    $errormsg = 'Account activation has been successfully processed.';
                }else{
                    $errormsg = 'Webservice Activate Account Error: ' . $SvcActivate->request_status . ' <br>';
                    $is_success = false;

                    /*forexcopy_log*/
                    $this->load->model('Logs_model');
                    $logData =array(
                        'account_number'  => $_SESSION['account_number'],
                        'method'          => 'Activate',
                        'request_data'    => json_encode($activateData),
                        'status'          => $SvcActivate->request_status,
                        'date'            => FXPP::getCurrentDateTime()
                    );

                    $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                }
            }

        }else{

         

                if($this->input->post('is_trader', true) == 1 || $type == 1) {
                $SvcUpdateTradersDescription = new ForexCopy();
                $SvcUpdateTradersDescription->UpdateTradersDescription($account_desc_info);
                
              
                
                if ($SvcUpdateTradersDescription->request_status === "RET_OK") {
                    $is_success_1 = true;
                }else{
                    $errormsg_1 = 'Webservice UpdateTradersDescription Error: ' . $SvcUpdateTradersDescription->request_status . ' <br>';
                    $is_success_1 = false;

                    /*forexcopy_log*/
                    $this->load->model('Logs_model');
                    $logData =array(
                        'account_number'  => $_SESSION['account_number'],
                        'method'          => 'UpdateTradersDescription',
                        'request_data'    => json_encode($account_desc_info),
                        'status'          => $SvcUpdateTradersDescription->request_status,
                        'date'            => FXPP::getCurrentDateTime()
                    );

                    $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                }





                $data_key = 0;
                $data_value = 0;
                // need only 1 commission type from the list
                $array_cond_key = array(
                    'conditions_values_1' => 1,
                    'conditions_values_2'  => 2,
                    'conditions_values_3'  => 3,
                    'conditions_values_4'  => 4,
                    'conditions_values_10'  => 10,
                    'conditions_values_7'  => 7,
                );

                foreach($_POST as $key => $value){

                    if (array_key_exists($key, $array_cond_key)) {
                        if($value == 'Do not use' ||  $value == null){

                        }else{
                            $data_key = $array_cond_key[$key];
                            $data_value = $value;
                        }
                    }
                }



                if($this->input->post('is_trader', true) == 1){ // register as a copytrader( upgrade account)
                    $registerData = array(
                        'ProjectName' => $account_info['project_name'],
                        'IsEu'         =>  false,
                        'LangNotify'   =>  $account_info['lang_notify'] ,
                        'UserId'       =>  $account_number, // client login
                        'IsTrader'     =>  true, //(true for trader, false for follower)
                        'Commission_type'     => $data_key,
                        'Commission_value'    => $data_value,
                    );
                    $SvcRegister= new ForexCopy();
                    $SvcRegister->RegisterForexCopy($registerData);
                    
                    if ($SvcRegister->request_status === "RET_OK_REG_AS_TRADER" || $SvcRegister->request_status === "RET_OK") {
                        $is_success_2 = true;
                    }else{
                        $errormsg_2 = 'WebService Register Error: ' . $SvcRegister->request_status . ' <br>';
                        $is_success_2 = false;

                        /*forexcopy_log*/
                        $this->load->model('Logs_model');
                        $logData =array(
                            'account_number'  => $_SESSION['account_number'],
                            'method'          => 'Register Upgrade',
                            'request_data'    => json_encode($registerData),
                            'status'          => $SvcRegister->request_status,
                            'date'            => FXPP::getCurrentDateTime()
                        );

                        $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                    } //end
                }else{
                   // check active trader copyterms
                    $copyTerms = $this->GetTraderCopyTerms($_SESSION['account_number']);
                    $traderCTK = $copyTerms['copyTerms'][0]->Key; //key
                    $traderCTV = $copyTerms['copyTerms'][0]->Value; //value

                    if($traderCTK == $data_key && $traderCTV == $data_value){
                        // do nothing
                        $is_success_2 = true;
                    }else{
                        //update copyterms

                        $account_con_info = array(
                            'trader' => $account_number,
                            'commission_type' => $data_key,
                            'commission_value' => $data_value,
                            'conditions_values_5' => ($account_info['commission_acc']) ? $account_info['commission_acc'] : 0,
                            'rollover' => ($account_info['rollover']) ? $account_info['rollover'] : 0,
                            'auto_subs' => ($account_info['conditions_values_6']) ? $account_info['conditions_values_6'] : 0,
                        );
                        
                     

                        $SvcUpdateTradersCondition = new ForexCopy();
                        $SvcUpdateTradersCondition->UpdateTradersCondition($account_con_info);

                        if ($SvcUpdateTradersCondition->request_status === "RET_OK") {
                            $is_success_2 = true;
                        }else{
                            if($SvcUpdateTradersCondition->request_status == 'RET_CURRENCY_ISSUE_ERROR'){
                                $fm_acc_type = array(
                                    '1' =>'ForexMart Standard',
                                    '2' => 'ForexMart Zero Spread',
                                    '4' => 'ForexMart Micro Account',
                                    '5' => 'ForexMart Classic',
                                    '6' => 'ForexMart Pro',
                                    '7' => 'ForexMart Cents',

                                );

                                $tradersData = $this->copytrade_model->get_where_row('mt_accounts_set',array('account_number' => $account_number));
                                $accountType = $fm_acc_type[$tradersData['mt_account_set_id']];
                                $errormsg_2 = "This account uses &ldquo;" . $tradersData['mt_currency_base'] . "&rdquo; currency and  &ldquo;" . $accountType . "&rdquo; account in his trading strategy, register same &ldquo;account type&rdquo; and &ldquo;currency&rdquo; to proceed with your request.";

                            }else{
                                $errormsg_2 = 'Webservice UpdateTradersCondition Error: ' . $SvcUpdateTradersCondition->request_status . ' <br>';
                            }

                            $is_success_2 = false;

                            /*forexcopy_log*/
                            $this->load->model('Logs_model');
                            $logData =array(
                                'account_number'  => $_SESSION['account_number'],
                                'method'          => 'UpdateTradersCondition',
                                'request_data'    => json_encode($account_con_info),
                                'status'          => $SvcUpdateTradersCondition->request_status,
                                'date'            => FXPP::getCurrentDateTime()
                            );

                            $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                        }

                    }



                    
                }
                $SvcUpdateUserDetails = new ForexCopy();
                    
                $SvcUpdateUserDetails->UpdateTradersUserDetails($account_update);
                
                if ($SvcUpdateUserDetails->request_status === "RET_OK") {
                    $is_success_3 = true;
                }else{
                    $errormsg_3 = 'Webservice UpdateUserDetails Error: ' . $SvcUpdateUserDetails->request_status . ' <br>';
                    $is_success_3 = false;

                    /*forexcopy_log*/
                    $this->load->model('Logs_model');
                    $logData =array(
                        'account_number'  => $_SESSION['account_number'],
                        'method'          => 'UpdateUserDetails',
                        'request_data'    => json_encode($account_update),
                        'status'          => $SvcUpdateUserDetails->request_status,
                        'date'            => FXPP::getCurrentDateTime()
                    );

                    $this->Logs_model->insert_log($table="forexcopy_log",$logData);

                }

                if($is_success_0 && $is_success_1  && $is_success_2 && $is_success_3){
                    $errormsg = 'Your profile has been successfuly updated.';
                    $is_success = true;
                }else{
                    $errormsg = $errormsg_0 . $errormsg_1 . $errormsg_2 . $errormsg_3;
                    $is_success = false;
                }

            }else{
                    
                    $SvcUpdateUserDetails = new ForexCopy();
                    $SvcUpdateUserDetails->UpdateTradersUserDetails($account_update_f);
                    
                    
                if ($SvcUpdateUserDetails->request_status === "RET_OK") {
                    $is_success = true;
                    $errormsg = 'Your profile has been successfuly updated.';
                }else{
                    $errormsg = 'Webservice FollowerUpdateUserDetails Error: ' . $SvcUpdateUserDetails->request_status . ' <br>';


                    /*forexcopy_log*/
                    $this->load->model('Logs_model');
                    $logData =array(
                        'account_number'  => $_SESSION['account_number'],
                        'method'          => 'UpdateUserDetails Follower',
                        'request_data'    => json_encode($account_update_f),
                        'status'          => $SvcUpdateUserDetails->request_status,
                        'date'            => FXPP::getCurrentDateTime()
                    );

                    $this->Logs_model->insert_log($table="forexcopy_log",$logData);
                    $is_success = false;
                }


            }

        }

        $type = $this->getUserType($account_number);




        $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>$is_success,'errorMsg' => $errormsg,'type' => $type,'project' => $projectNameOld)));
    }
    public function showCommissionSetting(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        $trader_con = array();

        $trader_data = $this->getConnectionsCopyTerms($_POST['connection']);
        $displayValue = $trader_data['copytermsDisplay'];
        $connectionData = $trader_data['copytermsRes'];
        foreach ($connectionData as $con_value){
            $con_key = 'td_' . $con_value->Key;
            if(!empty($con_value->Value)){
                $trader_con[$con_key] = $displayValue;
            }else{
                $trader_con[$con_key] = $con_value->Value;
            }
           
        }


        $this->output->set_content_type('application/json')->set_output(json_encode(array('success'=>true,'condition' => $trader_con)));

    }
    public function show_conditions()
    {
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}
        if ($this->session->userdata('logged')) {
        $traderSetting = $this->getFollowerCopySettings($_POST['connection']);
                    
        
                    
$json = array(
'copysetting_1' => "",                
'copysetting_2' =>"",
'copysetting_3' => "",
'copysetting_5' => "",
'copysetting_6' => "",
'copysetting_7' => "",
'copysetting_8' => "",
'copysetting_9' => "",
'currency_code' => "",
'test' => 1,
);

              
            
          foreach ($traderSetting as $key=>$val) {
              
               if($val->Key == 1) {
                 $json['copysetting_1']=$val->Value;
               }
               
               
                if($val->Key == 2) {
                 $json['copysetting_2']=$val->Value;
               }
               
               
                if($val->Key == 3) {
                 $json['copysetting_3']=$val->Value;
               }
               
//                if($val->Key == 4) {
//                 $json['copysetting_4']=$val->Value;
//               }
               
                if($val->Key == 5) {
                 $json['copysetting_5']=$val->Value;
               }
               
                if($val->Key == 6) {
                 $json['copysetting_6']=$val->Value;
               }
               
                if($val->Key == 7) {
                 $json['copysetting_7']=$val->Value;
               }
               
                if($val->Key == 8) {
                 $json['copysetting_8']=$val->Value;
               }
                    
                if($val->Key == 9) {
                 $json['copysetting_9']=$val->Value;
               }
               
               
                if($val->Key == 1 && $val->Value > 2) {
                $json['currency_code']= $this->DecodeCurrency($val->Value);
            } 
          }
                    
            
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        }


    }

    public function getBalanceHistoryNew($account_number){
        $visitor =  $this->session->userdata('account_number');

        $serviceData = array(
            'Trader' => $account_number,
            'Visitor' => $visitor,
        );
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetBalanceHistory($serviceData);
                    
        
        switch($ForexCopy->request_status){
            case 'RET_OK':
                $BalanceDataList = (array) $ForexCopy->GetResult('Balance');
                $data['data_margin'] = array();
                $data['data_equity'] = array();
                $data['data_balance'] = array();

                foreach ($BalanceDataList['BalanceData'] as $object) {
                    $margin = array($object->TimeStamp * 1000, $object->Margin);
                    $equity = array($object->TimeStamp*1000,$object->Equity);
                    $balance = array($object->TimeStamp *1000,$object->Balance);
                    array_push($data['data_margin'], $margin);
                    array_push($data['data_equity'], $equity);
                    array_push($data['data_balance'], $balance);
                }

                break;
            default:
                break;
        }

        echo json_encode($data,JSON_NUMERIC_CHECK);

    }
   /* public function getProfitHistoryNew($account_number){

        $service_data = array('Trader' => $account_number,);
        $data['data_profit'] = array();
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetProfitHistory($service_data);
        switch($ForexCopy->request_status){
            case 'RET_OK':
                $ProfitDataList = (array) $ForexCopy->GetResult('Profits');

                foreach ($ProfitDataList['ProfitData'] as $object) {
                    $profit = array($object->TimeStamp * 1000,$object->Profit);
                    array_push( $data['data_profit'], $profit);
                }
                break;
            default:
                break;
        }
        echo json_encode($data,JSON_NUMERIC_CHECK);
    }*/

    public function getProfitHistoryNew($account_number){
        $visitor =  $this->session->userdata('account_number');

        $serviceData = array(
            'Trader' => $account_number,
            'Visitor' => $visitor,
        );
        
        $data['data_profit'] = array();
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetProfitHistory($serviceData);
            
        
        $request_result = (array) $ForexCopy->GetAllResult();
        if($ForexCopy->request_status == 'RET_OK') {

            $requestResult = json_encode($request_result['Profits']);
            $ProfitDataList = json_decode($requestResult, true);
            array_multisort(array_column($ProfitDataList['ProfitData'], 'TimeStamp'),  SORT_ASC, $ProfitDataList['ProfitData']); // sort multiple arrays from largest to smallest amount

            foreach ($ProfitDataList['ProfitData'] as $object) {
                $profit = array($object['TimeStamp'] * 1000, floatval($object['Profit']));
                array_push( $data['data_profit'], $profit);

            }

        }


        echo json_encode($data,JSON_NUMERIC_CHECK);

    }

    public function payRollOver(){
        if (!$this->input->is_ajax_request()) {die('Not authorized!');}

        if ($this->session->userdata('logged')) {


                $is_success = false;
                $errorMsg = "Webservice Failed.Please try again.";
                $conId = $this->input->post('connection');
                $account_info = array('connectionId' => $conId, 'trader' => $_SESSION['account_number']);
                $userType =  $this->getUserType($_SESSION['account_number']);
               if($userType == 1) { //trader

                $ForexCopy = new ForexCopy();
                $ForexCopy->PayRollOver($account_info);
                $rollover = '';
                $requestStatus = trim($ForexCopy->request_status);
                if ($requestStatus == 'RET_OK') {
                    $is_success = true;
                    $errorMsg = "Rollover Successful.";
                    $rollover = $this->GetRollOverProfit($_POST['connection']);
                } else if ($requestStatus == 'RET_NO_ROLL_OVER') {
                    $errorMsg = "No pending commission to collect.";
                } else if ($requestStatus == 'RET_NOT_ENOUGH_FUND') {
                    $errorMsg = "Follower's balance is not enough to pay pending commission.";
                } else {

                    $errorMsg = "Webservice Failed: Status " . $ForexCopy->request_status . " Please try again.";
                    $errorData = array(
                        'account_number' => $this->session->userdata('account_number'),
                        'full_name' => $this->session->userdata('full_name'),
                        'report_date' => FXPP::getServerTime(),
                        'action' => 'Pay rollover of connection id ' . $conId,
                        'error' => 'PayRollOver method result: ' . $ForexCopy->request_status,
                    );
                    if(!empty($requestStatus)){
                        Fx_mailer::copytradeReport($errorData);
                    }

                   
                }
               }else{
                   $requestStatus = "NOT_TRADER_ACCOUNT";
               }

                /*forexcopy_log*/
                 $this->load->model('Logs_model');
                 $this->load->helpers('url');
           
                $account_info['url']  = 'internal/copytade/my-subscription';
                $account_info['user_tyoe']  = $userType;
        
                $logData = array(
                    'account_number' => $_SESSION['account_number'],
                    'method' => 'PayRollOver',
                    'request_data' => json_encode($account_info),
                    'status' => $requestStatus,
                    'date' => FXPP::getCurrentDateTime()
                );

                $this->Logs_model->insert_log($table = "forexcopy_log", $logData);



            $this->output->set_content_type('application/json')->set_output(json_encode(array('rollOver'=>$rollover['rollOver'],'success'=>$is_success,'err_msg' => $errorMsg,'reqResult' => $requestStatus)));

        } else {
            redirect('signout');
        }


      }
    public function isSubscibeToTrader($trader,$follower){
        $result = array(
            'connection' => 0,
            'status' => false,
        );
        $account_info = array('trader' => $trader,'visitor' => $follower);
            
        
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetConnectionId($account_info);
        if($ForexCopy->request_status == 'RET_OK'){
            $result['connection'] =  $ForexCopy->GetResult('Result');
            $result['status'] = true;

        }

        return $result;
    }
    public function DecodeCurrency($currencyCode){

        $sequence = array(4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048);
        $res = array();
        for($i = 9; $i >= 0; $i-- ) {
            $tryFind = $sequence[$i];

            if ($currencyCode >= $tryFind) {
                $currencyCode -= $tryFind;
                array_push($res, $tryFind);
            }

        }

        return $res;
    }
    public function getOpenTradeById()
    {
        $data['connection'] = $_POST['connection'];

        $trades = $this->GetOpenTradesModal($data['connection']);
        $c_profit = 0;
        $data['open_trade'] = '';
        if (count($trades['result']) > 0) {
            $data['has_trades'] = true;
            foreach ($trades['result'] as $key =>  $value) {
                $c_profit += $value->Profit;
                $data['open_trade'] .= '
                 <tr>
                    <td> ' . $value->Ticket . '</td>
                    <td> Open </td>
                    <td>' . $value->Volume . '</td>
                    <td>' . $value->Symbol . '</td>
                    <td>' . $value->OpenPrice . '</td>
                    <td>' . $value->Sl . '</td>
                    <td>' . $value->Tp . '</td>
                    <td>' . $value->Profit . '</td>
                      
                </tr>';

            }
            $data['open_trade'] .= '<tr>
                                            <td class="first"></td>
                                            <td class="last" colspan="8" style="height: 10px; border: 0; line-height: 123% !important;"><div style="font-size: 11px; float: right; margin-right: 10px; color: #343434;"><b>Total profit:' . $c_profit . '</b></div></td>
                                        </tr>';
        } else {
            $data['has_trades'] = false;
            $data['open_trade'] .= '<tr style="text-align: center"><td colspan = "9">You have no open trades.</td></tr>';
        }

      // $data['rolloverProfit'] = $this->GetRollOverProfit($data['connection'])['rollOver'];
      // $data['rolloverStatus'] = $this->GetRollOverProfit($data['connection'])['status'];
      // $data['rolloverStatus'] = 'RET_NOT_ENOUGH_FUND';

        $this->output->set_content_type('application/json')->set_output(json_encode($data));



}
    public function removeAvatar(){
        if ($this->input->is_ajax_request()) {
            $this->load->model('user_model');
            $user_id = $this->session->userdata('account_number');
            $user_profile = $this->user_model->getUserAvatar($user_id);
            $asset_user_images=$this->config->item('asset_user_images');
            
            $isRemove = false;
            if (!empty($user_profile['cpy_avatar'])) {
                if ($this->user_model->updatCpyUserAvatar($user_id, '')) {
                    $error = 'Avatar successfully updated.';
                    $isRemove = true;
                    if ($user_profile['cpy_avatar'] != '') {
                        if (file_exists($asset_user_images.$user_profile['cpy_avatar'])) {
                            unlink($asset_user_images.$user_profile['cpy_avatar']);
                        }
                    }
                } else {
                    //If failed to update, remove uploaded file.
                    $error = 'Unable to remove  avatar.';

                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isRemove, 'error' => $error)));
        }else{
            show_404();
        }
    }

    public function uploadAvatar(){
        if ($this->input->is_ajax_request()) {
            $this->load->model('user_model');
            
            $user_images=$this->config->item('asset_user_images');
            
         //   var_dump($_FILES);
            if (!empty($_FILES['avatar']['name'])) {
                $user_id = $this->session->userdata('account_number');
                $user_profile = $this->user_model->getUserAvatar($user_id);
                if ($_FILES['avatar']['name'] != $user_profile['cpy_avatar']) {
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
                        $config['upload_path'] =$user_images;// './assets/user_images';
                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
                        $config['max_size'] = '52428800';
                        $config['max_width'] = '0';
                        $config['max_height'] = '0';
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload()) {
                            //Get upload data
                            $uploadData = $this->upload->data();

                            if ($this->user_model->updatCpyUserAvatar($user_id, $uploadData['file_name'])) {
                                $error = 'Profile avatar successfully updated.';
                                $isUpdate = true;
                                $image_src = base_url($user_images. $uploadData['file_name']);
                            } else {
                                //If failed to update, remove uploaded file.
                                $error = 'Unable to update profile avatar.';
                                $isUpdate = false;
                                if (file_exists($user_images.$uploadData['file_name'])) {
                                    unlink($user_images.$uploadData['file_name']);
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
                    $error = 'new image. ' . $_FILES['avatar']['name'] . ' - ' . $user_profile['cpy_avatar'];
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
    public function uploadAvatarSelected(){
        if ($this->input->is_ajax_request()) {
            $this->load->model('user_model');
            $avatarFilename = $this->input->post('imgFilename');
            if (!empty($avatarFilename)) {
                $user_id = $this->session->userdata('account_number');
            
                if ($this->user_model->updatCpyUserAvatar($user_id,$avatarFilename)) {
                    $error = 'Profile avatar successfully updated.';
                    $isUpdate = true;
                    $image_src = base_url('assets/images/trader_avatar/' . $avatarFilename);
                } else {
                    //If failed to update, remove uploaded file.
                    $error = 'Unable to update profile avatar.';
                    $isUpdate = false;
                   
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
    
    public function GetTraderCopyTermsKey(){
        $commissionType = 0;
        $copytermsDetails = $this->GetTraderCopyTerms($_SESSION['account_number']);
        foreach ($copytermsDetails['copyTerms'] as $con_value){
            switch($con_value->Key){
                case '2': //  Commission per 0.01 lots (profitable trades)
                    $commissionType = 2;
                    break;
                case '3':  //Profit share (in %):
                    $commissionType = 3;
                    break;
                case '4':  // Daily commission:
                    $commissionType = 4;
                    break;
                case '10':  // Commission per 0.01 lots (all trades):
                    $commissionType = 10;
                    break;
                case '7':  // spread commission for company type
                    $commissionType = 7;
                    break;
                    
                
            }

        }


        return $commissionType;

    }
    


    public function GetTraderCopyTerms($accountNumber){
        $service_data = array('offset' => 0, 'limit' => 0, 'visitor' => 0,'trader' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetTraderCopyTerms($service_data);
        $commissionData = (array) $ForexCopy->GetAllResult();
        $commissionDisplay = $commissionData['DisplayValue'];
        $commissionTerms = $commissionData['Result']->KeyValueOfintstring;

        $result = array(
            'commission' => $commissionDisplay,
            'copyTerms' => $commissionTerms,
        );
        return $result;
    }

    public function GetUserBalanceCache($accountNumber){
        $service_data = array('Trader' => $accountNumber);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetUserBalanceCache($service_data);
        $balanceData = (array) $ForexCopy->GetAllResult();

        return $balanceData;
    }


    public function GetTraderDescription($accountNumber,$visitor){
        ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service
        $service_data = array('Trader' => $accountNumber,'Visitor' => $visitor );
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetTraderDescription($service_data);
        $descData = (array) $ForexCopy->GetAllResult();
        $descList = $descData['Result']->KeyValueOfintstring;

        return $descList;
    }

    public function GetTraderUserDetails($accountNumber,$visitor){
        ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service
        $service_data = array('Trader' => $accountNumber,'Visitor' => $visitor );
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetTraderUserDetails($service_data);
        $traderDetails = (array) $ForexCopy->GetAllResult();


        return $traderDetails;
    }

    public function GetOpenTradesModal($connectionID){
        $start = 0;
        $length = 100;
        $service_data = array('Offset' => $start, 'Limit' => $length, 'ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetOpenTradesFromConnection($service_data);
        $request_result = (array) $ForexCopy->GetAllResult();
        $dataCount = $request_result['DataCount']; //total count
        $tradesData =  $request_result['Trades']->TradeData;

        $restradesData = array(
            'result' => $tradesData

        );

        return $restradesData;

    }


    public function GetOpenTradesFromConnection(){
        $start = $_POST['start'];
        $length = $_POST['length'];
        $draw = $_POST['draw'];
        $connectionID = $_POST['extra_search'];

        $service_data = array('Offset' => $start, 'Limit' => $length, 'ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        if(IPloc::IPOnlyForVenus()){ //testing
            $ForexCopy->GetCloseTradesFromConnection($service_data);
        }else{
            $ForexCopy->GetOpenTradesFromConnection($service_data);
        }
        $request_result = (array) $ForexCopy->GetAllResult();
        $dataCount = $request_result['DataCount']; //total count
        $tradesData =  $request_result['Trades']->TradeData;


        /*$copyStatus  = array(
            'OPEN_OK' => 1,
            'CLOSE_OK' => 2,
            'CLOSE_ERROR_ALREADY_CLOSE_WHEN_CLOSING' => 3,
            'COMMISSION_OK' => 4,
            'COMMISSION_ERROR_WHEN_DEBIT_CREDIT' => 5,
            'READY_ROLL_OVER' => 6,
            'READY_DAILY_COMMISSION' => 7,
            'COMMISSION_FAILED_DUE_TO_NOT_ENOUGH_FUND' => 8,
            'CLOSE_DUE_TO_AUTO_UNSUBSCRIBE' => 9,
            'CANCEL_ORDER_NO_COMMISSION' => 10,
            'CLOSE_TRADE_BY_ERROR' => 11,
            'FOLLOWER_TICKET_DOES_NOT_EXIST' => 12,
            'CLOSE_DUE_TO_SUBSCRIPTION_CLOSE' => 13

        );*/

        $copyStatus  = array(
            1 => 'Open',
            2 => 'Closed',
            3 => 'Error closing',
            4 => 'Commission Paid',
            5 => 'Error credit/debit commission',
            6 => 'Pending commission',
            7 => 'Daily commission',
            8 => 'Commission failed',
            10 => 'Cancelled',
            11 => 'Closing error',
            12 => 'Archived follower',
            13 => 'Closed unsubscribe'

        );
          $cmdStatus = array(
           '0' => 'BUY',
           '1' => 'SELL',
           '2' => 'BUY LIMIT',
           '3' => 'SELL LIMIT',
           '4' => 'BUY STOP',
           '5' => 'SELL STOP',
           '6' => 'BALANCE',
           '7' => 'CREDIT',
         );


        $pendingList = array();
        foreach ($tradesData as $key => $value){
            $openTime = new DateTime("@$value->OpenTime");
            $closeTime = new DateTime("@$value->CloseTime");
        $tempArray = array(
            'DT_RowId' => $value->CopyId,
            $value->CopyId,
            '<span data-toggle="tooltip" data-placement="top" title="'.$copyStatus[$value->CopyStatus].'"><i class="fa fa-info-circle"></span>',
            '<a onclick="showTicketinfo('.$value->MasterTicket.','.$connectionID.')" style="cursor: pointer;"> '.$value->MasterTicket.'</a>',
            $value->Ticket,
            $value->Symbol,
            $cmdStatus[$value->Cmd],
            $value->Volume,
            $value->OpenPrice,
            $value->ClosePrice,
            $openTime->format('d-m-Y H:i:s'),
            'N/A',
            $value->Sl,
            $value->Tp,
            $value->Profit,
        );
            
            $pendingList[] = $tempArray;
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => (int) $dataCount,
            'recordsFiltered' => (int) $dataCount,
            'data' => $pendingList
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($result));


    }



    public function GetCloseTradesFromConnection(){

            $start = $_POST['start'];
            $length = $_POST['length'];
            $draw = $_POST['draw'];
            $connectionID = $_POST['extra_search'];

            $reqData = array(
                'start' => $start,
                'length' => $length,
                'draw' => $draw,
                'type' => 0,
                'connectionID' => $connectionID,

            );

            $result = $this->GetAccountCloseTrades($reqData);

            $this->output->set_content_type('application/json')->set_output(json_encode($result['result']));
            

    }

    public function GetTotalProfit(){

            $connectionID = $_POST['connection'];

            $reqData = array(
                'start' => 0,
                'length' => 1,
                'connectionID' => $connectionID,
                'type' => 1,

            );

            $result = $this->GetAccountCloseTrades($reqData);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('totalProfit' => $result)));


    }
    public function GetAccountCloseTrades($reqData){
        $start = $reqData['start'];
        $length = $reqData['length'];
        $draw = $reqData['draw'];
        $connectionID = $reqData['connectionID'];
        $service_data = array('Offset' => $start, 'Limit' => $length, 'ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetCloseTradesFromConnection($service_data);
        $request_result = (array) $ForexCopy->GetAllResult();
        $dataCount = $request_result['DataCount']; //total count
        $tradesData =  $request_result['Trades']->TradeData;
        $totalProfit =  $request_result['TotalProfit'];
        
        if($reqData['type'] == 1){
            
            return $totalProfit;
            
        }else{
            /*$copyStatus  = array(
            'OPEN_OK' => 1,
            'CLOSE_OK' => 2,
            'CLOSE_ERROR_ALREADY_CLOSE_WHEN_CLOSING' => 3,
            'COMMISSION_OK' => 4,
            'COMMISSION_ERROR_WHEN_DEBIT_CREDIT' => 5,
            'READY_ROLL_OVER' => 6,
            'READY_DAILY_COMMISSION' => 7,
            'COMMISSION_FAILED_DUE_TO_NOT_ENOUGH_FUND' => 8,
            'CLOSE_DUE_TO_AUTO_UNSUBSCRIBE' => 9,
            'CANCEL_ORDER_NO_COMMISSION' => 10,
            'CLOSE_TRADE_BY_ERROR' => 11,
            'FOLLOWER_TICKET_DOES_NOT_EXIST' => 12,
            'CLOSE_DUE_TO_SUBSCRIPTION_CLOSE' => 13

        );*/
            $copyStatus  = array(
                1 => 'Open',
                2 => 'Closed',
                3 => 'Error closing',
                4 => 'Commission Paid',
                5 => 'Error credit/debit commission',
                6 => 'Pending commission',
                7 => 'Daily commission',
                8 => 'Commission failed',
                10 => 'Cancelled',
                11 => 'Closing error',
                12 => 'Archived follower',
                13 => 'Closed unsubscribe'

            );

            $cmdStatus = array(
                '0' => 'BUY',
                '1' => 'SELL',
                '2' => 'BUY LIMIT',
                '3' => 'SELL LIMIT',
                '4' => 'BUY STOP',
                '5' => 'SELL STOP',
                '6' => 'BALANCE',
                '7' => 'CREDIT',
            );

            $commissionType  = $this->GetTraderCopyTermsKey();

            $pendingList = array();
            foreach ($tradesData as $key => $value){
                $openTime = new DateTime("@$value->OpenTime");
                $closeTime = new DateTime("@$value->CloseTime");
                
          
                
                if($commissionType == 4){ // daily commission
                    $tempArray = array(
                        'DT_RowId' => $value->CopyId,
                        $value->CopyId,
                        '<span data-toggle="tooltip" data-placement="top" title="'.$copyStatus[$value->CopyStatus].'"><i class="fa fa-info-circle"></span>',
                        '<a onclick="showTicketinfo('.$value->MasterTicket.','.$connectionID.')" style="cursor: pointer;"> '.$value->MasterTicket.'</a>',
                        $value->Ticket,
                        $value->Symbol,
                        $cmdStatus[$value->Cmd],
                        $value->Volume,
                        $value->OpenPrice,
                        $value->ClosePrice,
                        $openTime->format('d-m-Y H:i:s'),
                        $closeTime->format('d-m-Y H:i:s'),
                        $value->Sl,
                        $value->Tp,
                        $value->Profit
                    );
                }else{
                    $tempArray = array(
                        'DT_RowId' => $value->CopyId,
                        $value->CopyId,
                        '<span data-toggle="tooltip" data-placement="top" title="'.$copyStatus[$value->CopyStatus].'"><i class="fa fa-info-circle"></span>',
                        '<a onclick="showTicketinfo('.$value->MasterTicket.','.$connectionID.')" style="cursor: pointer;"> '.$value->MasterTicket.'</a>',
                        $value->Ticket,
                        $value->Symbol,
                        $cmdStatus[$value->Cmd],
                        $value->Volume,
                        $value->OpenPrice,
                        $value->ClosePrice,
                        $openTime->format('d-m-Y H:i:s'),
                        $closeTime->format('d-m-Y H:i:s'),
                        $value->Sl,
                        $value->Tp,
                        $value->Profit,
                        $value->Commission_T,

                    );
                }
                
                

                $pendingList[] = $tempArray;
            }
            
            $tableData = array(
                'draw' => $draw,
                'recordsTotal' => (int) $dataCount,
                'recordsFiltered' => (int) $dataCount,
                'data' => $pendingList
            );
            
            

            $result = array(
                'result' => $tableData,
            );
            
            
            
            return $result;
        }
        
    }
    public function GetRollOverProfit($connectionID){

        $service_data = array('ConnectionId' => $connectionID);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetRollOverProfit($service_data);;
        $request_result = (array) $ForexCopy->GetAllResult();
        $rollOver = 0;
        $status = $ForexCopy->request_status;
        if($status == 'RET_OK') {
            $rollOver = $request_result['Result'];

        }

        $return = array(
            'status' => $status,
            'rollOver' => $rollOver

        );

        if($this->input->is_ajax_request()){

            $this->output->set_content_type('application/json')->set_output(json_encode($return));

        } else{

            return $return;

        }

    }
    public function GetAccountsBalance($accounts){


        $service_data = array('Accounts' => $accounts);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetAccountsBalance($service_data);
        $balanceRecord = $ForexCopy->GetAllResult();
        if($ForexCopy->request_status == 'RET_OK') {
            $financeRecordEncode = json_encode($balanceRecord['Balance']->KeyValueOfintstring);
            $balanceList = json_decode($financeRecordEncode, true);
        }

        $return = array(
            'balanceList' => $balanceList
        );

        return $return;


    }
    public function GetTicketInfo(){

    
        $cmdStatus = array(
           '0' => 'BUY',
           '1' => 'SELL',
           '2' => 'BUY LIMIT',
           '3' => 'SELL LIMIT',
           '4' => 'BUY STOP',
           '5' => 'SELL STOP',
           '6' => 'BALANCE',
           '6' => 'CREDIT',
         );

        $ticket = $_POST['ticket'];
        $connection = $_POST['connection'];
        $service_data = array('ticket' => $ticket,'connectionId' => $connection);
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetTicketInfo($service_data);
        if($ForexCopy->request_status == 'RET_OK') {
            $request_result = (array) $ForexCopy->GetAllResult();
            $tradesData =  $request_result['Trades']->TradeData;

           
             $dateOpen = $tradesData[0]->OpenTime;
             $dateClose = $tradesData[0]->CloseTime;
             $openTime = new DateTime("@$dateOpen");
             $closeTime = new DateTime("@$dateClose");

            $trades = array(
                'ClosePrice' => $tradesData[0]->ClosePrice,
                'CloseTime'  => $closeTime->format('d-m-Y H:i:s'),
                'Cmd'        =>  $cmdStatus[$tradesData[0]->Cmd],
                'Ticket'     =>  $tradesData[0]->Ticket,
                'OpenPrice'  =>  $tradesData[0]->OpenPrice,
                'OpenTime'   =>  $openTime->format('d-m-Y H:i:s'),
                'Sl'        =>  $tradesData[0]->Sl,
                'Tp'        =>  $tradesData[0]->Tp,
                'Volume'    =>  $tradesData[0]->Volume,
                'Symbol'    =>  $tradesData[0]->Symbol,
                 'Profit'    =>  $tradesData[0]->Profit,

            );

             $result['trades'] = $trades;

        
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($result));


    }

   

    public function GetTraderByLimit($account_number,$start,$limit,$type = 1){
        $serviceData = array('Offset' => $start, 'Limit' => $limit, 'AccountNumber' => $account_number);
        $traderList = array();
         ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service

        $ForexCopy = new ForexCopy();
        $ForexCopy->GetMyTrader($serviceData);
        $requestResult = $ForexCopy->request_status;
        $resultData = (array) $ForexCopy->GetAllResult();

      
        if($requestResult == 'RET_OK') {
            $traderData = $resultData['Connections']->Connection;
            $traderCount = $resultData['DataCount'];

            $traderssAccount = array_map(function($e) { //return array of object column  similar to array_column for array
                return is_object($e) ? $e->Trader : $e['Trader'];
            }, $traderData);
            $traderBalance =  $this->GetAccountsBalance($traderssAccount);

           if($type == 1){
               $status = array(
                   '1' => 'On approval of Trader',
                   '2' => 'Approved',
                   '3' => 'Subscription was rejected by the Copytrading trader.',
                   '4' => 'Subscription was cancelled by the Copytrading trader.',
                   '5' => 'Subscription was cancelled by the Copytrading follower.',
                   '6' => 'Automatic Cancellation.',
                   '7' => 'Cant open new trades.',
                   '8' => 'Subscription stop loss.',
                   '9' => 'Dead Subscription.',
                   '10' => 'PAMM.',
                   '11' => 'Suspended.',
                   '12' => '10 percent of profit of NDB.',
                   '12' => 'Inactive.',
               );

               if(count($traderData) > 0){
                   foreach($traderData as $obj){

                       $searchKey = array_search($obj->Trader, array_column($traderBalance['balanceList'], 'Key'));
                       $balance = $traderBalance['balanceList'][$searchKey]['Value'];

                       $create_time = new DateTime("@$obj->CreateTime");
                       $last_modify = new DateTime("@$obj->LastModify");
                       $traderList[] = array(
                           'ConnectionId' =>  $obj->ConnectionId,
                           'Follower' =>  $obj->Follower,
                           'CreateTime' =>  $create_time->format('d-m-Y H:i:s'),
                           'LastModify' =>  $last_modify->format('d-m-Y H:i:s'),
                           'StatusId' =>  $obj->StatusId,
                           'RollOverStatus' =>  $obj->RollOverStatus ? 1 : 2,
                           'RollOverLogo' =>  $obj->RollOverStatus ? 'rollover-auto.png' : 'rollover-manual.png',
                           'RolloverNote' =>  $obj->RollOverStatus ? lang('rollover_note_1') : lang('rollover_note_2'),                         
                           'PendingRollOver' =>  $obj->PendingRollOver,
                           'StartBalance' => $balance,
                           'StatusDesc' => $status[$obj->StatusId],
                           'Trader' => $obj->Trader,
                           //'CopyTermsKey' => $this->CopyTermsKey($obj->ConnectionId),
                       );

                   }
               }

               $result = array(
                   'traderCount' => $traderCount,
                   'traderList' => $traderList,
               );


           }else{
               $result = array(
                   'traderCount' => $traderCount
               );
           }


        }


        return $result;
    }
    public function GetFollowerByLimit($account_number,$start,$limit,$type = 1){
        $serviceData = array('Offset' => $start, 'Limit' => $limit, 'AccountNumber' => $account_number);
        $followerList = array();

        $commissionType  = $this->GetTraderCopyTermsKey();
        if($commissionType == 3){
            $ForexCopyRollover = new ForexCopy();
            $rollover_status = $ForexCopyRollover->GetMyRollOverStatus();
        }
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetMyFollower($serviceData);
        $requestResult = $ForexCopy->request_status;
        $resultData = (array) $ForexCopy->GetAllResult();

        if($requestResult == 'RET_OK') {
            $followerData = $resultData['Connections']->Connection;
            $followerCount = $resultData['DataCount'];

            $followersAccount = array_map(function($e) { //return array of object column  similar to array_column for array
                return is_object($e) ? $e->Follower : $e['Follower'];
            }, $followerData);
            $followerBalance =  $this->GetAccountsBalance($followersAccount);


           if($type == 1){
               $status = array(
                   '1' => lang('copytrade_61'),
                   '2' => lang('copytrade_60'),
                   '3' => 'Subscription was rejected by the Copytrading trader.',
                   '4' => 'Subscription was cancelled by the Copytrading trader.',
                   '5' => 'Subscription was cancelled by the Copytrading follower.',
                   '6' => 'Automatic Cancellation.',
                   '7' => 'Cant open new trades.',
                   '8' => 'Subscription stop loss.',
                   '9' => 'Dead Subscription.',
                   '10' => 'PAMM.',
                   '11' => 'Suspended.',
                   '12' => '10 percent of profit of NDB.',
                   '12' => 'Inactive.',
               );

               if(count($followerData) > 0){
                   foreach($followerData as $obj){

                       $searchKey = array_search($obj->Follower, array_column($followerBalance['balanceList'], 'Key'));
                       $balance = $followerBalance['balanceList'][$searchKey]['Value'];

                       $create_time = new DateTime("@$obj->CreateTime");
                       $last_modify = new DateTime("@$obj->LastModify");
                       $followerList[] = array(
                           'ConnectionId' =>  $obj->ConnectionId,
                           'Follower' =>  $obj->Follower,
                           'CreateTime' =>  $create_time->format('d-m-Y H:i:s'),
                           'LastModify' =>  $last_modify->format('d-m-Y H:i:s'),
                           'StatusId' =>  $obj->StatusId,
                           'RollOverStatus' =>  $rollover_status ? 1 : 2,
                           'RollOverLogo' =>  $rollover_status ? 'rollover-auto.png' : 'rollover-manual.png',
                           'RolloverNote' =>  $rollover_status ? lang('rollover_note_1') : lang('rollover_note_2'),                       
                           'PendingRollOver' =>  $obj->PendingRollOver,
                           'RollOverScheduled' =>  $obj->RollOverScheduled,
                           'StartBalance' => $balance,
                           'StatusDesc' => $status[$obj->StatusId],
                           'Trader' => $obj->Trader,
                           'ConditionType' => $obj->ConditionType,
                          // 'CopyTermsKey' => $this->CopyTermsKey($obj->ConnectionId),
                       );

                   }
               }

               $result = array(
                   'followerCount' => $followerCount,
                   'followerList' => $followerList,
               );
           }else{
               $result = array(
                   'followerCount' => $followerCount,
               );
           }


        }


        return $result;

    }
    public function GetPastSubscriptionByLimit($account_number,$start,$limit,$type = 1){
        $serviceData = array('Offset' => $start, 'Limit' => $limit, 'AccountNumber' => $account_number);
        $pastSubsList = array();
        $ForexCopy = new ForexCopy();
        $ForexCopy->GetPastSubscription($serviceData);
        $requestResult = $ForexCopy->request_status;
        $resultData = (array) $ForexCopy->GetAllResult();
        if($requestResult == 'RET_OK') {
        $pastSubsData = $resultData['Connections']->Connection;
        $pastSubsCount = $resultData['DataCount'];

        if($type == 1){
            $status = array(
                '1' => 'On approval of Trader',
                '2' => 'Approved',
                '3' => 'Subscription was rejected by the Copytrading trader.',
                '4' => 'Subscription was cancelled by the Copytrading trader.',
                '5' => 'Subscription was cancelled by the Copytrading follower.',
                '6' => 'Automatic Cancellation.',
                '7' => 'Cant open new trades.',
                '8' => 'Subscription stop loss.',
                '9' => 'Dead Subscription.',
                '10' => 'PAMM.',
                '11' => 'Suspended.',
                '12' => '10 percent of profit of NDB.',
                '12' => 'Inactive.',
            );

            if(count($pastSubsData) > 0){
                foreach($pastSubsData as $obj){
                    $create_time = new DateTime("@$obj->CreateTime");
                    $last_modify = new DateTime("@$obj->LastModify");
                    if($this->getUserType($account_number) == 1){
                        $pastAccount = $obj->Follower;
                    }else{
                        $pastAccount = $obj->Trader;
                    }
                    
                    $pastSubsList[] = array(
                        'ConnectionId' =>  $obj->ConnectionId,
                        'Account' =>  $pastAccount,
                        'CreateTime' =>  $create_time->format('d-m-Y H:i:s'),
                        'LastModify' =>  $last_modify->format('d-m-Y H:i:s'),
                        'StatusId' =>  $obj->StatusId,
                        'StatusDesc' => $status[$obj->StatusId],
                    );

                }
            }

            $result = array(
                'pastSubsCount' => $pastSubsCount,
                'pastSubsList' => $pastSubsList,
            );
        }else{
            $result = array(
                'pastSubsCount' => $pastSubsCount,
            );
        }


    }
        
        return $result;

    }
    public function getFollowerList(){
        $search = $this->input->post('search', true);
        $page = $this->input->post('page', true);
        if (!$page) {
            $page = 1;
        }

        if(!empty($search)){
            $length  = 100;
            $start = 0;

        }else{
            $length  = 10;
            $start = ($page - 1) * $length;

        }

        $accountNumber = $_SESSION['account_number'];

        $followerData = $this->GetFollowerByLimit($accountNumber,$start,$length);



        if(!empty($search)){
            $searchKey = array_search($search, array_column($followerData['followerList'], 'Follower'));
            $searchData = $followerData['followerList'][$searchKey];
            $searchList = array();
            $searchList[] = $searchData;
            if(count($searchData) > 0){
                $view_data = array(
                    'follower_list' =>  $searchList,
                );
            }else{
                $view_data = array(
                    'follower_list' =>  $followerData['followerList'],
                );
            }



        }else{
            $view_data = array(
                'follower_list' =>  $followerData['followerList'],
            );
        }
        

        $followerListView = $this->load->view('copytrade/follower_list', $view_data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('htmlView' => $followerListView)));
    }

    public function getTraderList(){
        $page = $this->input->post('page', true);
        $search = $this->input->post('search', true);
        if (!$page) {
            $page = 1;
        }

        if(!empty($search)){
            $length  = 100;
            $start = 0;

        }else{
            $length  = 10;
            $start = ($page - 1) * $length;

        }



        $accountNumber = $_SESSION['account_number'];


        $traderData = $this->GetTraderByLimit($accountNumber,$start,$length);

        if(!empty($search)){
            $searchKey = array_search($search, array_column($traderData['traderList'], 'Trader'));
            $searchData = $traderData['traderList'][$searchKey];
            $searchList = array();
            $searchList[] = $searchData;
            if(count($searchData) > 0){
                $view_data = array(
                    'trader_list' =>  $searchList,
                );
            }else{
                $view_data = array(
                    'trader_list' =>  $traderData['traderList'],
                );
            }
           


        }else{
            $view_data = array(
                'trader_list' =>  $traderData['traderList'],
            );
        }


        $followerListView = $this->load->view('copytrade/trader_list', $view_data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('htmlView' => $followerListView)));
    }

    public function getPastSubsList(){
        $page = $this->input->post('page', true);
        $search = $this->input->post('search', true);
        if (!$page) {
            $page = 1;
        }


        if(!empty($search)){
            $length  = 100;
            $start = 0;

        }else{
            $length  = 10;
            $start = ($page - 1) * $length;

        }
        $accountNumber = $_SESSION['account_number'];


        $traderData = $this->GetPastSubscriptionByLimit($accountNumber,$start,$length);
        if(!empty($search)){
          // $searchKey = array_search($search, array_column($traderData['pastSubsList'], 'Account')); // single array search

            $searchKey = array_keys(array_column($traderData['pastSubsList'], 'Account'),$search); //multiple array search
            $searchList = array();
            foreach ($searchKey as $val){
                $searchData = $traderData['pastSubsList'][$val];
                $searchList[] = $searchData;
            }

            if(count($searchData) > 0){
                $view_data = array(
                    'pastsubs_list' =>  $searchList,
                );
            }else{
                $view_data = array(
                    'pastsubs_list' =>  $traderData['pastSubsList'],
                );
            }



        }else{
            $view_data = array(
                'pastsubs_list' =>  $traderData['pastSubsList'],
            );
        }


        $followerListView = $this->load->view('copytrade/past_subscriptions_list', $view_data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('htmlView' => $followerListView)));
    }

    public function rollover_commission()
    {
        if ($this->session->userdata('logged')) {
            $trader_data = $this->getUserType($_SESSION['account_number']);
            if (!in_array($trader_data, array(0,1))) {
                redirect(FXPP::my_url('copytrade'));
            }
         
           
            $view = 'copytrade/rollover_commission';
            $data['active_tab'] = 'copytrading';
            $js = $this->template->Js();
            $css = $this->template->Css();
            $this->template->title(lang('cpy_mon_tit'))
                ->append_metadata_css("
              
                 <link rel='stylesheet' href='" . $this->template->Css() . "copytrade_style.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "copytrade_circle.css'>    
                 <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                 <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>         
                  <link rel='stylesheet' href='" . $this->template->Css() . "modal_style.css'>        
              ")
                ->append_metadata_js("                        
                       <script src='" . $this->template->Js() . "bootbox.min.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build($view, $data);
        } else {
           
                redirect(FXPP::my_url('signout'));
            }
    }


    
    public function getCommissionOpt()
    {
        if (!$this->input->is_ajax_request()) {
            die('Not authorized!');
        }
        if ($this->session->userdata('logged')) {
            $draw = (int) $this->input->post('draw');
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $type = $this->input->post('type'); //1 received, 2 paid
          // $requestData = array('Offset' => $start, 'Limit' => $length);

           $requestData = array('Offset' => 0, 'Limit' => 20);
 

            $ForexCopy = new ForexCopy();
            if ($type == 1) {
                $requestRes = $ForexCopy->GetMyReceivedRollOvers($requestData);
            } else {

                $requestRes = $ForexCopy->GetMyPaidRollOvers($requestData);
            }

            $dataCount = $requestRes->DataCount;
            $tradesData = $requestRes->RollOvers;

            $pendingList = array();
            if ($dataCount > 0) {
                foreach ($tradesData->RollOverInfo as $key => $value) {
                
                        $tempArray = array(
                            $value->Ticket,
                            gmdate("Y-m-d H:i:s", $value->ProcessTime),
                            $value->Login,
                            $value->Amount,
                            $value->Comment,
                            $value->FromConnection,
                        

                        );
                    
                  
                    $pendingList[] = $tempArray;
                }
            }


            $result = array(
                'draw'            => $draw,
                'recordsTotal'    => (int) $dataCount,
                'recordsFiltered' => (int) $dataCount,
                'data'            => $pendingList
            );
         

            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        } else {
            redirect('signout');
        }
    }




    public function getRes(){

 $resConn = $this->isSubscibeToTrader(58024888 ,58027937);
         if(!$resConn['status']) { // proceed if no  active connection id
             $is_success = true;
         }else{
                $errormsg = 'Your account is already subscribed.';
                $reqStatus = 'RET_CON_ID_EXIST';
                $is_success = false;
            }

        var_dump($reqStatus);


             // if(!$is_success){
            //send email report
//        $trader = 78910;
//            $errorData = array(
//                'account_number'       => 12345,
//                'full_name'            => 'test',
//                'report_date'           => FXPP::getServerTime(),
//                'action'               => 'test only',
//                'error'                => 'test',
//            );
//
//            Fx_mailer::copytradeReport($errorData);
       // }
        //ini_set("soap.wsdl_cache_enabled", 0); // refresh soap service
//
//        $serviceData = array('Login' => 58027933);
//        $ForexCopy = new ForexCopy();
//        $ForexCopy->GetAccountType($serviceData);
//        $requestResult = $ForexCopy->request_status;
//
////
//        $serviceData = array('Offset' => 0, 'Limit' => 10, 'AccountNumber' => 58027933);
//
//        $ForexCopy = new ForexCopy();
//        $ForexCopy->GetMyTrader($serviceData);
//        $requestResult = $ForexCopy->request_status;
//        $resultData = (array) $ForexCopy->GetAllResult();
//        var_dump($requestResult);
//        var_dump($resultData);


//        $webservice_config = array('server' => 'copytrader');
//        $service_data = array('offset' => 0, 'limit' => 20, 'traderAccount' => 58043907,'visitor' => 0);
//        $WebService = new WebService($webservice_config);
//        $WebService->GetUserBalanceCache($service_data);
//        $request_result = (array) $WebService->get_all_result();
//       echo  $request_result['BalancePerDay'];

//        $visitor = $_SESSION['account_number'];
//
//        $webservice_config = array('server' => 'copytrader');
//        $service_data = array('offset' => 0, 'limit' => 10, 'accountNumber' => $visitor,'search' => 58024888);
//        $WebService = new WebService($webservice_config);
//        $WebService->SearchTrader($service_data);
//        $request_result = (array) $WebService->get_all_result();
//        $dataCount = $request_result['DataCount']; //total count
//        $traderData =  $request_result['Traders']->MonitorAccountData;
        //$request_result = $this->GetTraderByLimit(58027937,0,10);
        //$request_result = $this->GetTraderByLimit(58027937 ,0,10);
//       $res = $this->GetTicketInfo2();



//        $serviceData = array('accountNumber' => 58024888);
//        $webservice_config = array('server' => 'copytrader');
//        $WebService = new WebService($webservice_config);
//        $WebService->DeactivateTrader($serviceData);
//        $request_result = (array) $WebService->get_all_result();
//
//                $webservice_config = array('server' => 'copytrader');
//        $service_data = array('offset' => 0, 'limit' => 10, 'accountNumber' => $visitor,'search' => 58024888);
//        $WebService = new WebService($webservice_config);
//        $WebService->SearchTrader($service_data);
//        $request_result = (array) $WebService->get_all_result();
//        $dataCount = $request_result['DataCount']; //total count

//
//        echo '<pre>';
      // var_dump($request_result);

        //  print_r($request_result);
        exit();

    }


    
    

}