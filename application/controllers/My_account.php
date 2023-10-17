<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account extends MY_Controller {

    private $country_code;
    private $auto_update_fields = array(
        'email2',
        'email3',
        'phone2',
        'preferred_time'
    );

    public function __construct(){
        parent::__construct();
        $this->lang->load('currenttrades');
        $this->lang->load('historyoftrades');
        $this->lang->load('datatable');
        $this->load->model('account_model');
        $this->load->model('partners_model');
        $this->load->model('deposit_model');
        $this->lang->load('modal_message');
        $this->lang->load('datatable');
         $this->lang->load('currenttrades_lang'); 
        $this->load->library('IPLoc', null);
        $user_id = $this->session->userdata('user_id');
        // $this->isCPA = $this->partners_model->isCPA($user_id);
        $this->load->helper('cookie');
        //for advertisement cookie
        $this->load->model('General_model');
        $this->g_m=$this->General_model;

        /*if(IPLoc::isProgrammersIP()){
            //FXPP-9691
            $analy_hash = key($this->input->get(NULL, TRUE));
            $eu_reg_data = $this->g_m->showssingle2('eu_register_session','analytic_hash',$analy_hash,'*');
            if($eu_reg_data){
                $user_data = array(
                    'email' => $eu_reg_data['email'],
                    'full_name' => $eu_reg_data['full_name'],
                    'user_id' => $eu_reg_data['user_id'],
                    'logged_in' => ($eu_reg_data['logged_in']) ? 'TRUE':'FALSE',
                    'logged' =>  $eu_reg_data['logged'],
                    'first_login' => ($eu_reg_data['first_login']) ? 'TRUE':'FALSE',
                );

                $this->session->set_userdata($user_data);
                $this->g_m->delete('eu_register_session', 'user_id', $eu_reg_data['user_id']);
            }
            //end FXPP-9691
        }*/

        if($this->session->userdata('logged')){

            /*Note cookies have prefix found in Applications/config "forexmart_"*/
            $nodepositbonus = $this->g_m->showssingle2($table='users',$field='id',(int)$_SESSION['user_id'],$select='nodepositbonus,created,createdforadvertising');
            $data['cookie']['name']='nodepositbonus';
            $data['cookie']['value']=$nodepositbonus['nodepositbonus'];

            $this->input->set_cookie($data['cookie'],true);

            /*Set nodepositbonus datedifference cookie*/

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


            /*Set user_id cookie for tag manager*/

            $data['cookie']['name'] = 'gtm_id';
            $data['cookie']['value'] = $_SESSION['user_id'];
            $this->input->set_cookie($data['cookie'],true);

            $data['cookie']['name'] = 'gtm_IP';
            $data['cookie']['value'] = $_SERVER['REMOTE_ADDR'];
            $this->input->set_cookie($data['cookie'],true);

            unset($data['cookie']);
            unset($data);
        }
        //for advertisement cookie
        $this->country_code = $this->session->userdata('country');
        // set cookie to hide external page no deposit bonus start FXPP-2179
        if ($nodepositbonus['nodepositbonus']==1 ){
            $data['cookie_ndb'] = array(
                'name'   => 'ndb_acquired',
                'value'  => true,
                'expire' => time() + (10 * 365 * 24 * 60 * 60),
                'domain' => '.forexmart.com',
                'secure' => true,
                'path'   => '/',
                'prefix' => '',
                'httponly' => true,
            );
            $this->input->set_cookie($data['cookie_ndb'],true);
            $_SESSION['cookie_ndb']=true;
        }
        // set cookie to hide external page no deposit bonus end
        $data['save_hash'] = array(
            'first_login_stat' => 0
        );
        $this->general_model->updatemy('users', 'id', (int)$_SESSION['user_id'], $data['save_hash']);
        //FXPP::leverage_auto_change();

        /*put account number in session - start*/

        $data['cookie']['name'] = 'gtm_account_number';
        $data['cookie']['value'] = $_SESSION['account_number'];
        $this->input->set_cookie($data['cookie'],true);
        /*put account number in session - end*/
        unset($data['cookie']);
        unset($data);



    }


    public function releted_accounts(){
        if($this->input->is_ajax_request()){
            $data = array();

            $post_email =  $this->input->post('email',true);
            $acct_email = $this->session->userdata('email');
            $acc_login_type= $this->input->post('account_type',true);
            
            $realte_account_html_page=($acc_login_type=="client")?"account_list_1":"related_account_list_partner";
            
            
            if($post_email == $acct_email){ // Fixed - Task FXPP-12085
                                        
            // $data['accounts2'] =  $this->getAllRelatedAccounts($acc_login_type);

              $data['accounts2'] =  $this->getAllRelatedAccountsWithoutColsed($acc_login_type);
                        
             
//                    if($_SERVER["REMOTE_ADDR"]=='159.69.88.248' || IPLoc::Office() ){
//                          $data['accounts2'] =  $this->getAllRelatedAccountsWithoutColsed();
//                    }
                                
                                
                   if(count($data['accounts2']) > 0){
                       echo $tr = $this->load->view($realte_account_html_page,$data,true);
                   }
            }
        }
    }
    
    public function releted_accounts_test(){
        if($this->input->is_ajax_request()){

            $data = array();			
			$this->load->library('IPLoc', null);
			$this->load->library('FXPP', null);
		
            $post_email =  $this->input->post('email',true);
            $acct_email = $this->session->userdata('email');
			
			
			$user_id = $this->session->userdata('user_id');
            if( $user_id ){

                $account_info = array(
                    'iLogin' => $account_number
                );
                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);
                $WebService->open_RequestAccountBalance($account_info);
                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $data['balance'] = $this->roundno(floatval($WebService->get_result('Balance')), 2);
                        break;
                    default:
                        $data['balance'] = $this->roundno(floatval(0), 2);
                }




                //AN for account number
                //AN_type account type 0 Demo 1 Live 2 Partner
                if($this->session->userdata('login_type') == 1){
                    // Partnership accounts
                    $accounts = $this->partners_model->getPartnersByUserId($user_id);
                    $data['p_status'] = $user_info;
                    $cpa_type = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=$user_id,$select='type_of_partnership,reference_num,reference_subnum');
                    $data['AN_type']=2;
                    $data['AN'] = $account_number;
                    $data['user_profiles']['country']='';

                    if($cpa_type['type_of_partnership']=='cpa'){
                        $receiving_cpaAcct = $this->general_model->showssingle($table='partnership',$id='reference_subnum', $field=$cpa_type['reference_num'],$select='reference_num');
                        $iLogin = $receiving_cpaAcct['reference_num'];
                    }else{
                        $iLogin = $account_number;
                    }

//                    if($this->session->userdata('user_id')==102342 && IPLoc::Office()){ $iLogin = 241800;}
                    $account_info = array( 'iLogin' => $iLogin );



                    $webservice_config = array(  'server' => 'live_new' );
                    $WebService2 = new WebService($webservice_config);
                    $WebService2->ReqAgentStats($account_info);
                    $ReqAgentStats = (array)  $WebService2->result;
                    switch ($WebService2->request_status) {
                        case 'RET_OK':
                            $data['user_referrals']  = $ReqAgentStats["ReferralsCount"];
                            $data['user_commission'] = $ReqAgentStats["TotalCommission"];

                            break;
                        default:
                            $data['user_referrals']  = 0;
                            $data['user_commission'] = 0;
                    }


                    if($cpa_type['type_of_partnership']=='cpa'){
                        $user_id = $this->session->userdata('user_id');

                        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                        if($sub_partner) {
                            $data['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);

                        }else{
                            $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                        }
                        $val = 0;
                        foreach ( $data['cpa'] as $d){
                            $val=$val + $d->cpa_amount;
                        }
                        $data['user_commission'] = $val;
                    }
                    $WebService3 = new WebService($webservice_config);
                    $WebService3->GetAgentReferralTradeVolume($iLogin);
                    switch ($WebService3->get_all_result()['ReqResult']) {
                        case 'RET_OK':
                            $data['totalTradedVolume']  = $WebService3->get_all_result()['TotalVolume'];
                            break;
                        default:
                            $data['totalTradedVolume'] = 0;
                    }
                }else {
                    // Live and Demo accounts
                    $accounts = $this->account_model->getAccountsByUserId($user_id);



                    $data['users'] = $user_info;
                    $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='account_number,auto_leverage_change');
                    $data['user_profiles'] = $this->general_model->showssingle($table='user_profiles',$id='user_id', $field=$user_id,$select='country');

                    $data['AN_type'] = $data['users']['type']; // 0 demo 1 live
                    $data['AN'] = $account_number;
                    $data['email'] = $user_info['email'];

                    // Back Agent of Client
                    FXPP::BackAgentOfAccount($data['AN']);

                        $accounts[0]['veri_status'] = ($accounts[0]['accountstatus']== 1 || $accounts[0]['accountstatus']== 3) ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                        $accounts[0]['trade_status'] = $this->getAPIAccountDetails($account_number)['IsReadOnly'] == false ? lang('curtra_tbl_07') : lang('curtra_tbl_09');;
                        $accounts[0]['account_type'] = $this->general_model->getAccountTypeGroup($accounts[0]['mt_account_set_id']);
                }

                $data['accounts'] = $accounts;
				
				if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                    if($data['mtas2']['total_points'] < 50) {
                        $leverage = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50));
                    }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                        $leverage = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                    }else if($data['mtas2']['total_points'] > 70){
                        $leverage = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400));
                    }
                }else{
                    $leverage = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                }

            }else{
                $data['accounts'] = array();
            }
			
			$firstaccount = array(
				"0" => array( 
					'account_number' => $data['accounts'][0]['account_number'],
					'leverage' => $data['accounts'][0]['leverage'],
					'email' => $acct_email,
					'country' => '',
					'mt_currency_base' => $data['accounts'][0]['mt_currency_base'],
					'amount' => $data['accounts'][0]['amount'],
					'veri_status' => $data['accounts'][0]['veri_status'],
					'trade_status' => $data['accounts'][0]['trade_status'],
					'account_type' => $data['accounts'][0]['account_type'],
					'swap_free' => $data['accounts'][0]['swap_free'],
					'inactive' => 'N/A', 
				),
			);
			
           $data = array();
			 $i = 0;
            if($post_email == $acct_email){ 
                $RelatedAccounts =  $this->getAllRelatedAccounts();
				$RelatedAccounts = array_merge( $firstaccount, $RelatedAccounts);
				
				
				    if(count($RelatedAccounts) > 0){
				    foreach($RelatedAccounts as $account) {
						
						if($i == 0 ){
						 $user_info = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='email,accountstatus,is_showfxbonus,registration_location,type,nodepositbonus');
						 $user_profiles = $this->general_model->showssingle($table='user_profiles',$id='user_id', $field=$this->session->userdata('user_id'),$select='country');
						
						 $first_1 = '<span id="txt_leverage" onclick="txt_leverage()">'. $account['leverage'] .'</span>';
						$first_2 = '';
						
						if($user_info['is_showfxbonus']==1 ){

						 }  elseif ($user_info['nodepositbonus'] == 0 OR $user_profiles['country'] == 'PL') { 
							$first_2 = '<a id="edit_leverage"  onclick="edit_leverage()"><i class="fa fa-pencil edit-lev"></i></a><select id="select_leverage" class="form-control round-0 ma testp" style="display: none;" >'. $leverage .'</select>';
						} 
						
						$leverage = $first_1.$first_2; 
						
						if(IPLoc::WhitelistPIPCandCC()) { 
                           $acc_field_1 = '<li><a href="'. FXPP::loc_url('deposit/debit-credit-cards') .'">'.lang('mya_07') .'</a></li>';
                           $acc_field_2 = '<li>
                                <a href="'. FXPP::loc_url('deposit/webmoney') .'">
                                    '.lang('mya_10') .'</a></li>
                            <li><a href="'. FXPP::loc_url('deposit/paxum') .'">
                                '.lang('mya_11') .'</a></li>
                            <li><a href="'. FXPP::loc_url('deposit/ukash') .'">
                                '.lang('mya_12') .'</a></li>
                            <li><a href="'. FXPP::loc_url('deposit/payco') .'">
                                '.lang('mya_13') .'</a></li>
                            <li>
                                <a href="'. FXPP::loc_url('deposit/filspay') .'">
                                    '.lang('mya_14') .'</a></li>
                            <li><a href="'. FXPP::loc_url('deposit/cashu') .'">
                                '.lang('mya_15') .'</a></li>
                            <li><a href="'. FXPP::loc_url('deposit/hipay') .'">
                                '.lang('mya_16') .'</a></li>';
                        }
						$account_number = '<div class="dropdown">
							<button type="button" class="btn btn-default dropdown-toggle"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
									style="color: #ff0000;">
								'.$account['account_number'].'<span class="caret"></span>
							</button>
							<ul class="dropdown-menu multi-level" role="menu"
								aria-labelledby="dropdownMenu">
								<li class="dropdown-submenu">
									<a href="'. FXPP::loc_url('deposit') .'">
										'.lang('mya_04') .'
									</a>
									<ul class="dropdown-menu">
										<li><a href="'. FXPP::loc_url('deposit/debit-credit-cards') .'"> '.lang('mya_06') .'</a></li>
										'.$acc_field_1.
										' <li><a href="'. FXPP::loc_url('deposit/skrill') .'">'.lang('mya_08') .'</a></li>
										<li><a href="'. FXPP::loc_url('deposit/neteller') .'">'.lang('mya_09') .'</a></li>
										'.$acc_field_2.'
										<li><a href="'. FXPP::loc_url('deposit/paypal') .'"> '.lang('mya_17') .'</a></li>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a href="'. FXPP::loc_url('withdraw') .'">'.lang('mya_18') .'</a>
									<ul class="dropdown-menu">
										<li><a href="'. FXPP::loc_url('withdraw/bank-transfer') .'">'.lang('mya_05') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/debit-credit-cards') .'">'.lang('mya_06') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/unionpay') .'">'.lang('mya_07') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/skrill') .'">'.lang('mya_08') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/neteller') .'">'.lang('mya_09') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/webmoney') .'">'.lang('mya_10') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/paxum') .'">'.lang('mya_11') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/ukash') .'">'.lang('mya_12') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/payco') .'">'.lang('mya_13') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/filspay') .'">'.lang('mya_14') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/cashu') .'">'.lang('mya_15') .'</a></li>
										<li><a href="'. FXPP::loc_url('withdraw/paypal') .'">'.lang('mya_17') .'</a></li>
									</ul>
								</li>
							</ul>
						</div>'; 
						
						$edit_btn = '<td class="onlyAcc">N/A </td>';
					} else {
						$leverage = $account['leverage'];
						$account_number = '<div class="dropdown">
									<button type="button" class="btn btn-default dropdown-toggle"
											data-toggle="dropdown disabled" aria-haspopup="true"
											aria-expanded="false"
											style="color: #aba3a3;"> '. $account['account_number'] . '
										<span class="caret"></span></button>
									<ul class="dropdown-menu multi-level" role="menu"
										aria-labelledby="dropdownMenu">
										<li class="dropdown-submenu"><a href="#">
											   '.lang('mya_04').'</a>
											 <ul class="dropdown-menu"> '  . 
												 $ipLi .' 
												<li><a href="'. FXPP::loc_url('deposit/skrill') . '">'. lang('mya_08').'</a></li>
												<li><a href="'. FXPP::loc_url('deposit/neteller') . '">'. lang('mya_09').'</a></li>'
												.$ipLi. '<li><a href="'. FXPP::loc_url('deposit/paypal') . '">'. lang('mya_17').'</a></li>										 
											</ul>
										</li>
										<li class="dropdown-submenu">
											<a href="#">'. lang('mya_18').'</a>
											<ul class="dropdown-menu">
												<li><a href="'. FXPP::loc_url('withdraw/bank-transfer') . '">'. lang('mya_05').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/debit-credit-cards') . '">'. lang('mya_06').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/unionpay') . '">'. lang('mya_07').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/skrill') . '">'. lang('mya_08') .'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/neteller') . '">'. lang('mya_09').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/webmoney') . '">'. lang('mya_10').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/paxum') . '">'. lang('mya_11') .'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/ukash') . '">'. lang('mya_12').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/payco') . '">'. lang('mya_13').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/filspay') . '">'. lang('mya_14').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/cashu').'">'. lang('mya_15').'</a></li>
												<li><a href="'. FXPP::loc_url('withdraw/paypal') .'">'. lang('mya_17').'</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<span class="clearfix"></span>';
							
						if(isset($_SESSION['first_login']) && $_SESSION['first_login'] ){
							$active_chk =$account['inactive']?'disabled':'';
								$active_color =$account['inactive']?'#aaabaa':'#29a643';
							
								$edit_btn = '<a class="btn btn-primary" href="'. FXPP::loc_url('Client/signin').'" style="background: '. $active_color .' ;white-space:normal!important;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" '.$active_chk.'>
							'.lang('mya_32').' </a>'; }else{
								$active_chk =$account['inactive']?'disabled':'';
								$active_color =$account['inactive']?'#aaabaa':'#29a643';
								$edit_btn = form_open(FXPP::loc_url('client/switch-account'), '', '') .'
								<input type="hidden"  name="username" value="'. $account['account_number'] .'">
								<button type="submit"
										style="background: '. $active_color .' ;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;"  '. $active_chk.'>
									 '. lang('mya_32') .'
								</button>'. form_close(); 
							}	
					} 
					
					$i = $i++;
					
						
								
					$i++;
							
						switch ($account['account_type']) {
							case 'ForexMart Standard':
								$account_type = lang('mya_28');
								break;
							case 'ForexMart Zero Spread':
								$account_type = lang('mya_29');
								break;
							case 'ForexMart Micro Account':
								$account_type = lang('mya_31');
								break;
							default:
								$account_type = $account['account_type'];
						}
							
						if($account['inactive']==1){
							$stat_inactive = "Inactive";
							$color = 'color:red';
						}else{
							$stat_inactive = ((!isset($account['mt_status']) || trim($account['mt_status']) === '')) ? lang('mya_26') : lang('mya_27');
							$color = '';
						}


                        if (IPLoc::WhitelistPIPCandCC()) {

                            $ipLi=' <li><a href="'. FXPP::loc_url('deposit/debit-credit-cards') . '">'. lang('mya_07').'</a></li>';
                            $ipLi_1='<li><a href="'. FXPP::loc_url('deposit/webmoney') . '">'. lang('mya_10').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/paxum') . '">'. lang('mya_11').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/ukash') . '">'. lang('mya_12').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/payco') . '">'. lang('mya_13').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/filspay') . '">'. lang('mya_14').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/cashu') . '">'. lang('mya_15').'</a></li>
									<li><a href="'. FXPP::loc_url('deposit/hipay') . '">'. lang('mya_16').'</a></li>';
                        } else {
							$ipLi= '';
							$ipLi_1= '';
						}
						
									

						 



                    $valChk =$account['swap_free'] ? 'checked' : '';
				    $tempArray = array(
							'DT_RowId' => 	$account['account_number'],
							'0' => 	$account_number,
							'1' => 	$leverage,
							'2' => 	$account['mt_currency_base'],
							'3' => 	$account['amount'],
							'4' => 	$account['veri_status'],
							'5' => 	'<span style="'.$color.'">'.$account['trade_status'].'</span>',
							'6' => 	$account_type,
//							'7' => 	'<input type="checkbox" id="chk_swap"'.$account['swap_free'] ? ' checked' : '' .' disabled/>',
                            '7' => 	'<input type="checkbox" id="chk_swap" '.$valChk.'  disabled />',
							'8' =>  $edit_btn,
						);
						$data[] = $tempArray;
					}
                     // echo $tr = $this->load->view('account_list_1',$data,true);

                   }
            }
			
			$result = array(
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)count($RelatedAccounts),
                'recordsFiltered' => (int)count($RelatedAccounts),
                'data' => $data
            );

            echo json_encode($result);


        }		

    }
    
	
	public function index() {
                    

        $this->lang->load('myprofile');

       // accounts             

        set_time_limit(0);
        //*** This code is for direct access to deposit page upon logging in**/


        if(isset($_COOKIE['forexmart_monitor_account'])){
            redirect(FXPP::my_url('copytrade/monitor_user/'.$_COOKIE['forexmart_monitor_account']));
        }

        if (isset($_SESSION['redirect'])){
            redirect($_SESSION['redirect']);

        }
        //**End **/


        

        if($this->session->userdata('logged')){


            
            
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $this->lang->load('registration');


            $user_id = $this->session->userdata('user_id');
            $account_number = $this->session->userdata('account_number');
            if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())<1){
                $data['incomplete_reg'] = true;
            }

            $user_info = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='email,accountstatus,is_showfxbonus,registration_location,type,nodepositbonus');

            $data['acc_status'] = $user_info;
            $data['reg_loc'] = $user_info['registration_location'];
            $data['show_fx_bonus'] = $user_info;

            if($user_id){

            
                
                $fundData = FXPP::getAccountFunds($account_number);
                switch ($fundData['status']) {
                    case 'RET_OK':
                        $data['balance'] = $this->roundno(floatval($fundData['balance']), 2);
                        break;
                    default:
                        $data['balance'] = $this->roundno(floatval(0), 2);
                }




                //AN for account number
                //AN_type account type 0 Demo 1 Live 2 Partner
                if($this->session->userdata('login_type') == 1){
                    
                    // Partnership accounts
                    $accounts = $this->partners_model->getPartnersByUserId($user_id);
                    $data['p_status'] = $user_info;
                    $cpa_type = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=$user_id,$select='type_of_partnership,reference_num,reference_subnum');
                    $data['AN_type']=2;
                    $data['AN'] = $account_number;
                    $data['user_profiles']['country']='';

                    if($cpa_type['type_of_partnership']=='cpa'){
                        $receiving_cpaAcct = $this->general_model->showssingle($table='partnership',$id='reference_subnum', $field=$cpa_type['reference_num'],$select='reference_num');
                        $iLogin = $receiving_cpaAcct['reference_num'];
                    }else{
                        $iLogin = $account_number;
                    }

//                    if($this->session->userdata('user_id')==102342 && IPLoc::Office()){ $iLogin = 241800;}
                    $account_info = array( 'iLogin' => $iLogin );



                    $webservice_config = array(  'server' => 'live_new' );
                    $WebService2 = new WebService($webservice_config);
                    $WebService2->ReqAgentStats($account_info);
                    $ReqAgentStats = (array)  $WebService2->result;
                    switch ($WebService2->request_status) {
                        case 'RET_OK':
                            $data['user_referrals']  = $ReqAgentStats["ReferralsCount"];
                            $data['user_commission'] = $ReqAgentStats["TotalCommission"];

                            break;
                        default:
                            $data['user_referrals']  = 0;
                            $data['user_commission'] = 0;
                    }


                    if($cpa_type['type_of_partnership']=='cpa'){
                        $user_id = $this->session->userdata('user_id');

                        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                        if($sub_partner) {
                            $data['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);

                        }else{
                            $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                        }
                        $val = 0;
                        foreach ( $data['cpa'] as $d){
                            $val=$val + $d->cpa_amount;
                        }
                        $data['user_commission'] = $val;
                    }
                    $WebService3 = new WebService($webservice_config);
                    $WebService3->GetAgentReferralTradeVolume($iLogin);
                    switch ($WebService3->get_all_result()['ReqResult']) {
                        case 'RET_OK':
                            $data['totalTradedVolume']  = $WebService3->get_all_result()['TotalVolume'];
                            break;
                        default:
                            $data['totalTradedVolume'] = 0;
                    }
                    
                    
                  

//                    $data['totalTradedVolume'] = $this->getTotalTrade($getAccountNumber['account_number'])['TotalVolume'];
                }else {
                    
                    
                    
                    
                    // Live and Demo accounts
                    $accounts = $this->account_model->getAccountsByUserId($user_id);

                   
                    
                    $data['users'] = $user_info;
                    $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='account_number,auto_leverage_change');
                    $data['user_profiles'] = $this->general_model->showssingle($table='user_profiles',$id='user_id', $field=$user_id,$select='country');

                    $data['AN_type'] = $data['users']['type']; // 0 demo 1 live
                    $data['AN'] = $account_number;
                    $data['email'] = $user_info['email'];

                    
                    
                    // Back Agent of Client
                    FXPP::BackAgentOfAccount($data['AN']);


                   
                    
                    $accounts[0]['veri_status'] = ($accounts[0]['accountstatus']== 1 || $accounts[0]['accountstatus']== 3) ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                    $accounts[0]['trade_status'] = $this->getAPIAccountDetails($account_number)['IsReadOnly'] == false ? lang('curtra_tbl_07') : lang('curtra_tbl_09');;
                   
                    
                    
                    $accounts[0]['account_type'] = $this->general_model->getAccountTypeGroup($accounts[0]['mt_account_set_id']);

                    

                }

                $data['accounts'] = $accounts;
                        
            }else{
                $data['accounts'] = array();
            }

            $this->load->model('user_model');
            // $user = $this->user_model->getUserProfileByUserId($user_id);


            $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='amount,registration_leverage,leverage,amount_conv_api,mt_currency_base,mt_account_set_id,total_points');

                        
                        // get client information from API
                        $account_info_api_success=false;
            
                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();

                        $account = array(
                            'account_number' => [$account_number]
                        );
                        $newServiceResult = $WSV->GetAccountDetails($account);

                        
                  
                        
                        $selectedValue = null;
                        if(!empty($data['accounts']) && $newServiceResult["ErrorMessage"] === "RET_OK"){

                            $account_info_api_success=true;
                            
                            $serviceData   = $newServiceResult["Data"][0];
                            $data['accounts'][0]['SendReports'] = $serviceData->SendReports;                  

                        }

              
            
            
            if(IPLoc::APIUpgradeDevIP()){ //FXPP-12302

                
                
                
                 if($account_info_api_success){                        
                  
                    
                                $leverage      = "1:". $serviceData->Leverage;
                                $selectedValue = $leverage;
                                $data['accounts'][0]['leverage'] = $leverage;

            //                    if(IPLoc::IPOnlyForG()) {
            //                    if ($account_info['iLogin'] == '58027951' || $account_info['iLogin'] == 58027951) {
            //                        if ($accountType == 'ForexMart Micro' || $accountType == 'ForexMart Micro Account') {
            ////                            if ($WebService->get_result('Balance') >= 1000000 && $WebService->get_result('Leverage') != 200 || $WebService->get_result('Leverage') != "200") {
            //                            if ($balance >= 1000000 && $WebService->get_result('Leverage') != 200 || $WebService->get_result('Leverage') != "200") {
            //                                $leverage = 200;
            //                                $info = array(
            //                                    'iLogin' => $account_info['iLogin'],
            //                                    'iLeverage' => $leverage
            //                                );
            //                                $WSV1 = new WSV();
            //                                $WebService = $WSV1->SetAccountDetail($info, "SetAccountLeverage");
            //
            //
            //
            //                                if ($WebService->request_status === 'RET_OK') {
            //                                    $date_modified = FXPP::getCurrentDateTime();
            //                                    $update_history_data = array(
            //                                        'user_id' => $user_id,
            //                                        'manager_id' => $user_id,
            //                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
            //                                    );
            //                                    $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
            //                                    $update_history_field_data = array();
            //                                    if ($update_history_id) {
            //                                        $update_history_field_data[] = array(
            //                                            'field' => 'Leverage',
            //                                            'old_value' => $acc['leverage'],
            //                                            'new_value' => '1:200',
            //                                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
            //                                            'update_id' => $update_history_id
            //                                        );
            //                                    }
            //                                    $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
            //
            //                                    $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:200");
            //                                }
            //                            }
            //                        } else {
            //                            if ($balance >= 10000 && $WebService->get_result('Leverage') != 200 || $WebService->get_result('Leverage') != "200") {
            //                                $leverage = 200;
            //                                $info = array(
            //                                    'iLogin' => $account_info['iLogin'],
            //                                    'iLeverage' => $leverage
            //                                );
            //                                $WSV1 = new WSV();
            //                                $WebService = $WSV1->SetAccountDetail($info, "SetAccountLeverage");
            //
            //                                if ($WebService->request_status === 'RET_OK') {
            //                                    $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:200");
            //                                }
            //                            }
            //                        }
            //                    }
            //                    }

            //                    if(IPLoc::IPOnlyForG()){
                                    $acc = $this->account_model->getUserDetailsByAccountNumber($account_number);
                                    $user_id = $this->session->userdata('user_id');
                                    $accountType = FXPP::fmGroupType($account_info['iLogin']);
                                    if(!$accountType){
                                        $accountType = $this->general_model->getAccountType( $acc['mt_account_set_id'] );
                                    }

                                    if ($accountType == 'ForexMart Micro' || $accountType == 'ForexMart Micro Account'|| $accountType == 'ForexMart Cent' || $accountType == 'ForexMart Cents') {
                                        if ($serviceData->Balance >= 1000000 && $serviceData->Leverage != 200) {
                                            $leverage = 200;

                                            $WebService = FXPP::SetLeverage($account_info['iLogin'], $leverage);

                                            if ($WebService->request_status === 'RET_OK') {
                                                $date_modified = FXPP::getCurrentDateTime();
                                                $update_history_data = array(
                                                    'user_id' => $user_id,
                                                    'manager_id' => $user_id,
                                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                                    'update_url' => 'my-account/index'
                                                );
                                                $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
                                                $update_history_field_data = array();
                                                if ($update_history_id) {
                                                    $update_history_field_data[] = array(
                                                        'field' => 'Leverage',
                                                        'old_value' => $acc['leverage'],
                                                        'new_value' => '1:200',
                                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                                        'update_id' => $update_history_id
                                                    );
                                                }
                                                $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                                                $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:$leverage");
                                            }
                                        }


                                    } else {
                                        if ($serviceData->Balance >= 10000 && $serviceData->Leverage != 200) {
                                            $leverage = 200;

                                            $WebService = FXPP::SetLeverage($account_info['iLogin'], $leverage);

                                            if ($WebService->request_status === 'RET_OK') {
                                                $date_modified = FXPP::getCurrentDateTime();
                                                $update_history_data = array(
                                                    'user_id' => $user_id,
                                                    'manager_id' => $user_id,
                                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                                    'update_url' => 'my-account/index'
                                                );
                                                $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
                                                $update_history_field_data = array();
                                                if ($update_history_id) {
                                                    $update_history_field_data[] = array(
                                                        'field' => 'Leverage',
                                                        'old_value' => $acc['leverage'],
                                                        'new_value' => '1:200',
                                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                                        'update_id' => $update_history_id
                                                    );
                                                }
                                                $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                                                $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:$leverage");
                                            }
                                        }
                                    }
            //                    }

                }
                
                
                
            
                
                
                
                
                        if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                          if($data['mtas2']['total_points'] < 50) {
                              $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50), $selectedValue);
                          }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                              $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200), $selectedValue);
                          }else if($data['mtas2']['total_points'] > 70){
                              $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400), $selectedValue);
                          }
                      }else{
                          $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500), $selectedValue);
      //
                      }
              

                      
            }else{

                if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                    if($data['mtas2']['total_points'] < 50) {
                        $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50));
                    }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                        $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                    }else if($data['mtas2']['total_points'] > 70){
                        $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400));
                    }
                }else{
                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                }

            }

            // if($data['mtas2']['mt_currency_base']=='USD'){
            //     $amount = $data['mtas2']['amount'];
            // }else{
            //     $amount  = FXPP::getCurrencyRate($amount=$data['mtas2']['amount'], $from_currency=strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency="USD");
            // }
            // if($data['mtas2']['mt_account_set_id']==4){ //micro
            //     $amount = ($amount/100);
            // }

            
                        
                    
            $acc_login_type=($this->session->userdata('login_type')!=1)?'client':'partner';
            
            $data['accountsPagi'] =  $this->getAllRelatedAccounts($acc_login_type);
                        
                    
            /*----------------------- specail code for smart doller access/not- [FXPP-13524]----------------------*/
                $data['smart_dollar_not_allow']=false;
               
                    if(isset($_SESSION['smart_dollar_visit'])){
                        
                         if(FXPP::getBonusListByAccount($_SESSION['account_number'], FXPP::smartDollarNotAccess()))
                         {
                              $data['smart_dollar_not_allow']="smar-dollar not allow";
                         }     
                        
                    }    
               
            /*----------------------- specail code end -----------------------*/

            $data['title_page'] = lang('sb_li_0');
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'accounts';
            $css = $this->template->Css();

//if(IPLoc::frz(true)){ 
//                        echo "<pre>";
//                        print_r($data['accounts']);
//                        exit;
//                    }
            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css("              
                  <link rel='stylesheet' href='".$css."personal-details.css'>
                ")
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('dashboard_v2', $data);

        }else{
            if($_GET['login'] == 'partner'){
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }

    
  
    

 public  function isRealFundAlreayGet($acc){
        $getAccountBonusByType = FXPP::getAccountBonusByType($acc);
                        
        if(count($getAccountBonusByType) > 0){
            foreach($getAccountBonusByType as $key => $bonuses) {
                if (array_key_exists($key, $this->allowed_bonuses)) {
                    return true;
                }
            }
            return false;
        }
        return true;

    }
    
    
    
    
    
    public function testSes(){
        echo '<pre>';
        var_dump($_SESSION);
    }

    private function index_v1() {







        set_time_limit(0);
        //*** This code is for direct access to deposit page upon logging in**/


        if(isset($_COOKIE['forexmart_monitor_account'])){
            redirect(FXPP::my_url('copytrade/monitor_user/'.$_COOKIE['forexmart_monitor_account']));
        }

        if (isset($_SESSION['redirect'])){
            redirect($_SESSION['redirect']);

        }
        //**End **/



        if($this->session->userdata('logged')){


            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');

            $this->lang->load('registration');
//            if(IPLoc::Office()){
//                echo 'bd-Test';  exit();
//            }



            $user_id = $this->session->userdata('user_id');
            if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())<1){
                $data['incomplete_reg'] = true;
            }



            if( $user_id ){
                //set not first login


                // get balance api
                $getAccountNumber = $this->account_model->getAccountNumber($user_id);

                $account_info = array(
                    'iLogin' => $getAccountNumber['account_number']
                );




                // check if client agreed to auto subscription in the external registration for referrals of partner 262259 only
                $autoSubscribetoCopytarder = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='auto_subscribe')['auto_subscribe'];






                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);
                $WebService->open_RequestAccountBalance($account_info);
                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $data['balance'] = $this->roundno(floatval($WebService->get_result('Balance')), 2);
                        break;
                    default:
                        $data['balance'] = $this->roundno(floatval(0), 2);
                }




                //AN for account number
                //AN_type account type 0 Demo 1 Live 2 Partner
                if($this->session->userdata('login_type') == 1){
                    // Partnership accounts
                    $accounts = $this->partners_model->getPartnersByUserId($user_id);
                    $data['p_status'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='accountstatus');
                    $cpa_type = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=$user_id,$select='type_of_partnership,reference_num,reference_subnum');
                    $data['AN_type']=2;
                    $data['AN'] = $getAccountNumber['account_number'];
                    $data['user_profiles']['country']='';

                    if($cpa_type['type_of_partnership']=='cpa'){
                        $receiving_cpaAcct = $this->general_model->showssingle($table='partnership',$id='reference_subnum', $field=$cpa_type['reference_num'],$select='reference_num');
                        $iLogin = $receiving_cpaAcct['reference_num'];
                    }else{
                        $iLogin = $getAccountNumber['account_number'];
                    }

//                    if($this->session->userdata('user_id')==102342 && IPLoc::Office()){ $iLogin = 241800;}
                    $account_info = array( 'iLogin' => $iLogin );



                    $webservice_config = array(  'server' => 'live_new' );
                    $WebService2 = new WebService($webservice_config);
                    $WebService2->ReqAgentStats($account_info);
                    $ReqAgentStats = (array)  $WebService2->result;
                    switch ($WebService2->request_status) {
                        case 'RET_OK':
                            $data['user_referrals']  = $ReqAgentStats["ReferralsCount"];
                            $data['user_commission'] = $ReqAgentStats["TotalCommission"];

                            break;
                        default:
                            $data['user_referrals']  = 0;
                            $data['user_commission'] = 0;
                    }


                    if($cpa_type['type_of_partnership']=='cpa'){
                        $user_id = $this->session->userdata('user_id');

                        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                        if($sub_partner) {
                            $data['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
                        }else{
                            $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                        }
                        $val = 0;
                        foreach ( $data['cpa'] as $d){
                            $val=$val + $d->cpa_amount;
                        }
                        $data['user_commission'] = $val;
                    }
                    $WebService3 = new WebService($webservice_config);
                    $WebService3->GetAgentReferralTradeVolume($iLogin);
                    switch ($WebService3->get_all_result()['ReqResult']) {
                        case 'RET_OK':
                            $data['totalTradedVolume']  = $WebService3->get_all_result()['TotalVolume'];
                            break;
                        default:
                            $data['totalTradedVolume'] = 0;
                    }
//                    $data['totalTradedVolume'] = $this->getTotalTrade($getAccountNumber['account_number'])['TotalVolume'];
                }else {
                    // Live and Demo accounts
                    $accounts = $this->account_model->getAccountsByUserId($user_id);
                    $data['users'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='type,nodepositbonus');
                    $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='account_number,auto_leverage_change');
                    $data['user_profiles'] = $this->general_model->showssingle($table='user_profiles',$id='user_id', $field=$user_id,$select='country');

                    $data['AN_type'] = $data['users']['type']; // 0 demo 1 live
                    $data['AN'] = $getAccountNumber['account_number'];

                    // Back Agent of Client
                    FXPP::BackAgentOfAccount($data['AN']);


                    //FXPP-9557

                    $getAccountGroupDetails = FXPP::isEUGroup($getAccountNumber['account_number']);
                    /* if (!$getAccountGroupDetails['status']) { // RET_OK
                         if ($getAccountGroupDetails['is_eugroup']) { // is mt4 group eu
                             if ($getAccountGroupDetails['leverage'] > 50) { // is leverage greater than 50
                                 //reduce leverage to 50
                                 $info = array(
                                     'iLogin'    => $getAccountNumber['account_number'],
                                     'iLeverage' => 50
                                 );

                                 $WebServiceChangeLeverage = new WebService($webservice_config);
                                 $WebServiceChangeLeverage->open_ChangeAccountLeverage($info);
                                 if ($WebServiceChangeLeverage->request_status === 'RET_OK') {
                                     $date_modified = FXPP::getCurrentDateTime();
                                     $leverage_log = array(
                                         'user_id' => $user_id,
                                         'old_leverage' => '1:'.$getAccountGroupDetails['leverage'],
                                         'new_leverage' => '1:50',
                                         'date_updated' => date('Y-m-d H:i:s', strtotime($date_modified))
                                     );
                                     $this->general_model->insert('auto_leverage_log',$leverage_log);
                                     $this->account_model->updateAccountLeverage($getAccountNumber['account_number'], '1:50');
                                 }

                             }

                         }

                     }*/

                    $data['is_eugroup'] = $getAccountGroupDetails['is_eugroup'];


                    foreach( $accounts as $key => $value ){
                        $verification_status = $value['accountstatus'] == 1 ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                        $trading_status =  $this->getAPIAccountDetails($getAccountNumber['account_number'])['IsReadOnly'] == false ? lang('curtra_tbl_07') : lang('curtra_tbl_09');
                        $accounts[$key]['veri_status'] = $verification_status;
                        $accounts[$key]['trade_status'] = $trading_status;
                        if($accountType = FXPP::fmGroupType($getAccountNumber['account_number'])){
                            $accounts[$key]['account_type'] = $accountType;
                        }else{
                            $accounts[$key]['account_type'] = $this->general_model->getAccountType( $value['mt_account_set_id'] );
                        }
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


            $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='amount,registration_leverage,leverage,amount_conv_api,mt_currency_base,mt_account_set_id,total_points');


            if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                if($data['mtas2']['total_points'] < 50) {
                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50));
                }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                }else if($data['mtas2']['total_points'] > 70){
                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400));
                }
            }else{
                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
            }





            if($data['mtas2']['mt_currency_base']=='USD'){
                $amount = $data['mtas2']['amount'];
            }else{
                $amount  = FXPP::getCurrencyRate($amount=$data['mtas2']['amount'], $from_currency=strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency="USD");
            }
            if($data['mtas2']['mt_account_set_id']==4){ //micro
                $amount = ($amount/100);
            }


            /*  if(in_array(strtoupper($user['country']), array('PL'))){
                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100));
              }else {

                  $this->load->model('deposit_model');
                  $has_50percent_bonus = $this->deposit_model->has50PercentBonusDeposit($user_id);
                  if($has_50percent_bonus){
                      $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,200));
                  }else{
                      $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='amount,registration_leverage,leverage,amount_conv_api,mt_currency_base,mt_account_set_id');
                      $r_l=intval(substr($data['mtas2']['registration_leverage'] ,2));  // remove "1:" from the leverage
                      $l=intval(substr($data['mtas2']['leverage'],2));  // remove "1:" from the leverage

                      if($data['mtas2']['mt_currency_base']=='USD'){
                          $amount = $data['mtas2']['amount'];
                      }else{
                          $amount  = FXPP::getCurrencyRate($amount=$data['mtas2']['amount'], $from_currency=strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency="USD");
                      }
                      if($data['mtas2']['mt_account_set_id']==4){ //micro
                          $amount = ($amount/100);
                      }
                      switch (true) {
                          case $r_l >= 1000:
                              if(floatval($amount)>=1000 and floatval($amount)<3000){
                                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,3000));
                              }elseif(floatval($amount)>=3000 and floatval($amount)<5000){
                                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,1000));
                              }elseif(floatval($amount)>=5000){
                                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                              }else{
                                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                                  $data['client_autochangelev']=array(
                                      'client_autolevchange_disable'=>0
                                  );
                                  $this->general_model->updatemy('mt_accounts_set', 'user_id',$_SESSION['user_id'], $data['client_autochangelev']);
                              }
                              break;
                          default:
                              if ($l<1000){
                                  if(floatval($amount)>=1000 and floatval($amount)<3000){
                                      $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,3000));
                                  }elseif(floatval($amount)>=3000 and floatval($amount)<5000){
                                      $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,1000));
                                  }elseif(floatval($amount)>=5000){
                                      $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                                  }else{
                                      $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                                      $data['client_autochangelev']=array(
                                          'client_autolevchange_disable'=>0
                                      );
                                      $this->general_model->updatemy('mt_accounts_set', 'user_id',$_SESSION['user_id'], $data['client_autochangelev']);
                                  }
                              }else{
                                  $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                              }

                      }
                      unset($data['mtas2']);
                  }
              }
          }*/


//            $inactive_account_info= $this->getInactiveUserdetails($getAccountNumber['account_number']); //API INFO



            $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
            $this->session->set_userdata(array('image' => $image));
            $data['accounts2'] = $this->getAllAccounts(); $data['micro_test_acc']=$amount;

            $data['reg_loc'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='registration_location')['registration_location'];

            $data['title_page'] = lang('sb_li_0');
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'accounts';
            $data['acc_status'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='accountstatus');

//            if(IPLoc::Office()){
            $data['show_fx_bonus'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='is_showfxbonus');
//            }

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('dashboard', $data);

        }else{
            if($_GET['login'] == 'partner'){
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }
    public function getTotalTrade($account){
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $account_info = array( 'iLogin' => $account);
        $WebService->GetAccountTotalTradedVolume($account_info);
        if($WebService->request_status=='RET_OK'){
            $data = $WebService->get_all_result();
        }else{
            $data = false;
        }
        return $data;
    }
    public function getTotalTradePerMonth($account_info){
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
    public function getCommissionDataChart($account_info, $opt){

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

            if(IPLoc::APIUpgradeDevIP()){

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService2 = $WSV->GetAccountFunds($r['account_number']);

                if($WebService2->request_status === "RET_OK"){
                    $TotalBonusFund = $WebService2->result['TotalBonusFund'];
                }

            }else{

                $WebService2= new WebService($webservice_config);
                $WebService2->RequestAccountFunds($r['account_number']);

                $TotalBonusFund = $WebService2->get_result('TotalBonusFund');

            }

            if ($r['nodepositbonus']) {
                if ($getTotalDeposit > $TotalBonusFund) {
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

    public function getCalingCode() {
        $country=$this->input->post('country',true);
        if($this->input->is_ajax_request()) {
            $result= $this->general_model->getCallingCode($country);
            echo $result;
        }
    }

    public function register(){
        if($this->session->userdata('logged')){
            $this->lang->load('register');
            $this->load->model('user_model');
            $this->load->model('account_model');
            $this->load->model('contact_model');

            $user_id = $this->session->userdata('user_id');
            if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())>0){
                redirect(FXPP::my_url('my-account'));
            }

            $this->form_validation->set_rules('employment_status', 'Account type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('estimated_annual_income', 'Account Currency Base', 'trim|required|xss_clean');
            $this->form_validation->set_rules('education_level', 'Leverage', 'trim|required|xss_clean');

            if ($this->form_validation->run()) {

                $current_user_profile = $this->user_model->getUserProfileByUserId($user_id);
                $user = array(
                    'affiliate_code'=> $this->input->post("affiliate_code",true)
                );

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

                $field['phone1'] = $this->input->post('Phone_number',true);
                $field['street'] = $this->input->post('street',true);
                $field['city'] = $this->input->post('city',true);
                $field['state'] = $this->input->post('state',true);
                $field['country'] = $this->input->post('country',true);
                $field['zip'] = $this->input->post('zip',true);
                $field['dob'] = $this->input->post('dob',true);

                //user personal information
                $userprofile_detail =array(
                    'street' => $field['street'],
                    'city' => $field['city'],
                    'state' => $field['state'],
                    'country' => $field['country'],
                    'dob' => $field['dob'],
                    'zip' => $field['zip']
                );
                $this->general_model->update('user_profiles','user_id',$user_id,$userprofile_detail);

                // check contacts entry
                $contuct_detail = array('phone1' => $field['phone1'],'user_id' =>$user_id);
                $cgarray=array('user_id'=>$user_id);
                $check=$this->general_model->getQueryStirngRow('contacts','*',$cgarray);

                // contact insert or update
                if(empty($check)){
                    $this->general_model->insert('contacts', $contuct_detail);}else{
                    $upcon=array('phone1'=>$field['phone1']);
                    $this->general_model->update('contacts','user_id',$user_id,$upcon);
                }
                // user personal information close

                // Update MT4
                // if (IPLoc::Office()) {
                $date_modified = FXPP::getCurrentDateTime();

                $field_alias = array(
                    'phone1' => 'Telephone Number(1)',
                    'street' => 'Street',
                    'city' => 'City',
                    'zip' => 'Postal/Zip Code',
                    'state' => 'State/Province',
                    'dob' => 'Date of Birth',
                    'country' => 'Country',
                );

                $change_fields = array();
                $update_fields = array();
                $update_req_fields = array();
                array_push($this->auto_update_fields, "email", "phone1");
                $auto_update_fields = $this->auto_update_fields;
                foreach($field as $key => $value ){
                    if(in_array($key, $auto_update_fields)){
                        if ($value != $current_user_profile[$key]) {
                            $update_fields[$key] = $value;
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
                        }
                    }
                }

                if(!$this->session->userdata('login_type')) {
                    $account_details = $this->account_model->getAccountByUserId($user_id);
                }else{
                    $account_details = $this->account_model->getAccountByPartnerId($user_id);
                }

                $account_number = $account_details['account_number'];

                $webservice_config = array('server' => 'live_new');
                $service_account_info = array(
                    'iLogin' => $account_number
                );
//                $AccountWebService = new WebService($webservice_config);
//                $AccountWebService->open_RequestAccountDetails($service_account_info);

                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $AccountWebService = $WSV->GetAccountDetailsSingle($service_account_info, $webservice_config);

                $account_comment = '';
                if($AccountWebService->request_status == 'RET_OK'){
//                    $account_comment = $AccountWebService->get_result('Comment');
                    $account_comment = $AccountWebService->result['Comment'];
                }
                $WebService = new WebService($webservice_config);
                $account_info = array(
                    'full_name' => $current_user_profile['full_name'],
                    'email' => $current_user_profile['email'],
                    'street_address' => $field['street'],
                    'city' => $field['city'],
                    'state' => $field['state'],
                    'country' => $this->general_model->getCountries($field['country']),
                    'zip_code' => $field['zip'],
                    'phone_number' => $field['phone'],
                    'account_number' => $account_number,
                    'comment' => $account_comment,
                );

                $WebService->update_live_account_details($account_info);
                if ($WebService->request_status === 'RET_OK') {

                    //add Account Update History
                    $update_history_data = array(
                        'user_id' => $user_id,
                        'manager_id' => $user_id,
                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                        'update_url' => 'my-account/register'
                    );
                    $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);

                    //add Account Update Fields History
                    if ($update_history_id) {
                        $update_history_field_data = array();
                        $fields_changed = array();
                        foreach ($field as $key => $value) {
                            if ($value != $current_user_profile[$key]) {
                                $fields_changed[$key] = array(
                                    'field_key' => $key,
                                    'field' => $field_alias[$key],
                                    'old_value' => $current_user_profile[$key],
                                    'new_value' => $value,
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified))
                                );
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
                }
                //  }//if(IPLOC::Office()) end

                // Registration Upload Documents
//                if(!empty($_FILES['filename']['name'])) {
//                    $this->load->helper(array('form', 'url'));
//                    $cpt = count($_FILES['filename']['name']);
//                    for($i=0; $i<$cpt; $i++) {
//                        if(!empty($_FILES['filename']['name'][$i])){
//                            $_FILES['userfile']['name'] = $_FILES['filename']['name'][$i];
//                            $_FILES['userfile']['type'] = strtolower($_FILES['filename']['type'][$i]);
//                            $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
//                            $_FILES['userfile']['error'] = $_FILES['filename']['error'][$i];
//                            $_FILES['userfile']['size'] = $_FILES['filename']['size'][$i];
//
//                            $config['file_name'] = sha1($_FILES['userfile']['name'][$i]);
////                            $config['upload_path'] = './assets/user_docs';
//                            $config['upload_path'] = '/var/www/svn1/assets/user_docs/';
//                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                            $config['max_size'] = '10000';
//                            $config['max_width'] = '0';
//                            $config['max_height'] = '0';
//                            $config['overwrite'] = false;
//                            $this->load->library('upload', $config);
//                            //                     Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
//                            $this->upload->initialize($config);
//                            if($this->upload->do_upload()) {
//                                $uploadData = $this->upload->data();
//                                $updData = array(
//                                    'user_id' => $user_id,
//                                    'doc_type' => $i,
//                                    'file_name' => $uploadData['file_name'],
//                                    'client_name' => $uploadData['client_name']
//                                );
//                                $this->general_model->insert('user_documents', $updData);
//                            }
//                        }
//                    }
//                }

//                if(!empty($_FILES['filename']['name'])) {
//                    $this->load->helper(array('form', 'url'));
//                    $cpt = count($_FILES['filename']['name']);
//                    for($i=0; $i<$cpt; $i++) {
//                        if(!empty($_FILES['filename']['name'][$i])){
//                            $_FILES['userfile']['name'] = $_FILES['filename']['name'][$i];
//                            $_FILES['userfile']['type'] = strtolower($_FILES['filename']['type'][$i]);
//                            $_FILES['userfile']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
//                            $_FILES['userfile']['error'] = $_FILES['filename']['error'][$i];
//                            $_FILES['userfile']['size'] = $_FILES['filename']['size'][$i];
//
//                            $config['file_name'] = sha1($_FILES['userfile']['name'][$i]);
//                            $config['upload_path'] = '/var/www/svn1/assets/user_docs/';
//                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                            $config['max_size'] = '10000';
//                            $config['max_width'] = '0';
//                            $config['max_height'] = '0';
//                            $config['overwrite'] = false;
//                            $this->load->library('upload', $config);
//                            //                     Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
//                            $this->upload->initialize($config);
//                            if($this->upload->do_upload()) {
//                                $uploadData = $this->upload->data();
//                                $updData = array(
//                                    'user_id' => $user_id,
//                                    'doc_type' => $i,
//                                    'file_name' => $uploadData['file_name'],
//                                    'client_name' => $uploadData['client_name']
//                                );
//                                $this->general_model->insert('user_documents', $updData);
//                            }
//                        }
//                    }
//                }

//                            $config['file_name'] = sha1($_FILES['userfile']['name'][$i]);
//                            $config['upload_path'] = './assets/user_docs';
//                            $config['upload_path'] = '/var/www/svn1/assets/user_docs/';
//                            $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                            $config['max_size'] = '10000';
//                            $config['max_width'] = '0';
//                            $config['max_height'] = '0';
//                            $config['overwrite'] = false;
//                            $this->load->library('upload', $config);
//                            //                     Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
//                            $this->upload->initialize($config);
//                            if($this->upload->do_upload()) {
//                                $uploadData = $this->upload->data();
//                                $updData = array(
//                                    'user_id' => $user_id,
//                                    'doc_type' => $i,
//                                    'file_name' => $uploadData['file_name'],
//                                    'client_name' => $uploadData['client_name']
//                                );
//                                $this->load->library('image_lib');
//                                $config['source_image'] = './assets/user_docs/'. $uploadData['file_name'];
//                                chmod($config['source_image'],0777);
//                                $config['wm_overlay_path'] = './assets/images/watermark.png';
//                                $config['wm_type'] = 'overlay';
//                                $config['wm_opacity'] = '100';
//                                $config['wm_vrt_alignment'] = 'middle';
//                                $config['wm_hor_alignment'] = 'center';
//                                $config['wm_padding'] = '0';
//                                $size = getimagesize($config['source_image']);
//                                if(isset($size[0])){
//                                    if($size[0]<541){
//                                        $config['wm_overlay_path'] = './assets/images/watermark_s.png';
//                                    }
//                                }
//                                $this->image_lib->initialize($config);
//                                $this->image_lib->watermark();
//                                $this->general_model->insert('user_documents', $updData);
//                            }
//                        }
//                    }
//                }
                $this->db->trans_complete();
                redirect( FXPP::my_url('my-account'));
            }

            $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(),$this->country_code);
            $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
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

            //FXPP-5191
            $user_id = $this->session->userdata('user_id');
            $getUserEmailByUserId = $this->account_model->getUserEmailByUserId($user_id);
            $user_profile = $this->user_model->getUserProfileByUserId( $user_id );
            $user_contact = $this->contact_model->getUserContactByUserId( $user_id );
            $countries = $this->general_model->getCountries();
            $this->load->library('IPLoc', null);

            if(IPLoc::IPCrpAccVerify()){
                $data['account_type_status'] =$this->user_model->getAccouTypeStatus('corporate_acc_status','mt_accounts_set',array('user_id'=>$user_id));
            }
            $user_data = array(
                'name' => '',
                'address' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'telephone' => array('',''),
                'dob' => '',
                'email' => array('','',''),
                'contact_time' => '',
                'country' => '',
                'image' => '',
            );
            if( $user_profile !== false ){
                $user_data['name'] = $user_profile['full_name'];
                $user_data['address'] = $user_profile['street'];
                $user_data['dob'] = $user_profile['dob'];
                $user_data['city'] = $user_profile['city'];
                $user_data['state'] = $user_profile['state'];
                $user_data['zip_code'] = $user_profile['zip'];
                $user_data['country'] = $user_profile['country'];
                $user_data['image'] = $user_profile['image'];
                $user_data['preferred_time'] = $user_profile['preferred_time'];
                $user_data['email1'] = $getUserEmailByUserId[0]['email'];
                $user_data['skype'] = $user_profile['skype'];


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
            $data['s_address'] = $user_data->address;
            if($data['user_data']['country']!=''){
                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(),$data['user_data']['country']);
                $data['calling_code'] = $this->general_model->getCallingCode($data['user_data']['country']);
            }else{
                $data['countries'] = $this->general_model->selectOptionList($this->general_model->getCountries(),$this->country_code);
                $data['calling_code'] = $this->general_model->getCallingCode($this->country_code);
            }

            $this->template->title("ForexMart | My Account")
                ->set_layout('internal/main')
                ->build('auth/register_live3', $data);
        }else{
            redirect('signout');
        }
    }

    public function current_trades(){
        $this->lang->load('currenttrades');
        if($this->session->userdata('logged')){
            if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
                $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
                $this->NewGetOpenTrades();
            }else {


                $webservice_config = array('server' => 'live_new');
                $WebService = new WebService($webservice_config);
                $data['mtas'] = $this->g_m->showssingle2($table = 'mt_accounts_set', $field = 'user_id', $id = $_SESSION['user_id'], $select = 'account_number');
                $account_info = array(
                    'iLogin' => $data['mtas']['account_number']
                );

//            if(IPLoc::Office()){
//
//                $WebService->GetAccounPendingOrders($account_info);
//            }else{
                $WebService->open_GetAccountActiveTrades($account_info);
                //  }


                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $tradatalist = (array)$WebService->get_result('TradeDataList');
                        if ($tradatalist) {
                            $opened = '';
                            foreach ($tradatalist['TradeData'] as $object) {


                                if (floatval($object->Volume) != 0) {
                                    $data['volume'] = (floatval($object->Volume) / 100);
                                } else {
                                    $data['volume'] = floatval($object->Volume);
                                }


                                $crTic = "'$object->OrderTicket'";
                                $crTrd = "'$object->TradeType'";
                                $crVol = "'$data[volume]'";
                                $crSym = "'$object->Symbol'";
                                $crOprc = "'$object->OpenPrice'";
                                $crStls = "'$object->StopLoss'";
                                $crTkprft = "'$object->TakeProfit'";
                                $crClprc = "'$object->ClosePrice'";
                                $crSwps = "'N/A'";
                                $crPrf = "'$object->Profit'";

                                $crDetails = 'Details';


                                $opened .= '<tr onclick="mobDetailsCloseTrades(' . $crTic . ',' . $crTrd . ',' . $crVol . ',' . $crSym . ',' . $crOprc . ',' . $crStls . ',' . $crTkprft . ',' . $crClprc . ',' . $crSwps . ',' . $crPrf . ')">';

                                $opened .= '<td>' . $object->OrderTicket . '</td>';
                                $opened .= '<td>' . $object->TradeType . '</td>';
                                $opened .= '<td>' . $data['volume'] . '</td>';


                                $opened .= '<td class="crTradesMob">' . $object->Symbol . '</td>';

                                $opened .= '<td  class="crTradesMob">' . $object->OpenPrice . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->StopLoss . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->TakeProfit . '</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->ClosePrice . '</td>';
                                $opened .= '<td  class="crTradesMob">N/A</td>';
                                $opened .= '<td  class="crTradesMob">' . $object->Profit . '</td>';
                                $opened .= '<td class="crTradesWeb crTradesWebStyle">' . $crDetails . '</td>';


                                $opened .= '</tr>';
                            }

                            $data['Opened'] = $opened;
                        } else {
                            $data['Opened'] = '';

                        }
                        break;
                    default:
                        $data['data']['error'] = true;
                }

                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'accounts';
                $data['active_sub_tab'] = 'current-trades';
                $data['active_sub_sub_tab'] = 'current_trades';

                $data['metadata_description'] = lang('curtra_dsc');
                $data['metadata_keyword'] = lang('curtra_kew');
                $this->template->title(lang('curtra_tit'))
                    ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>
                 ")
                    ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};
                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('current_trades', $data);
            }
        }else{
            redirect('signout');
        }
    }

// pending order get in curretn treads tab [FZ]    
    public function pending_orders(){
        $this->lang->load('currenttrades');
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
        $this->lang->load('historyoftrades');
        if($this->session->userdata('logged')){
            if( // $_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
                $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
                $this->NewGetHistoryTrades();
            }else {
            $data['title_page'] = lang('sb_li_0');
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'history-of-trades';
            $data['metadata_description'] = lang('hot_dsc');
            $data['metadata_keyword'] = lang('hot_kew');
            $this->template->title(lang('hot_tit'))
                ->append_metadata_css("
                       <link rel='stylesheet' href='" . $this->template->Css() . "dataTables.bootstrap2.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "loaders.css'>
                       <link rel='stylesheet' href='" . $this->template->Css() . "bootstrap-datetimepicker.css'>
                 ")
                ->append_metadata_js("
                        <script type='text/javascript'>
                            window.alert = function() {};

                          </script>
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "Moment.js'></script>
                       <script src='" . $this->template->Js() . "bootstrap-datetimepicker.min.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                ->set_layout('internal/main')
                ->build('history_of_trades', $data);
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

                        if (floatval($object->Volume)!=0 ){
                            $data['volume']=(floatval($object->Volume)/100);
                        }else{
                            $data['volume']=floatval($object->Volume);
                        }


                        $clDetails='Details';

                        $cTic="'$object->OrderTicket'";
                        $cTrd="'$object->TradeType'";
                        $cVol="'$data[volume]'";
                        $cSym="'$object->Symbol'";

                        $openPrc=number_format((float)$object->OpenPrice, $object->Digits, '.', '');
                        $StopLoss=number_format((float)$object->StopLoss, $object->Digits, '.', '');
                        $TakeProfit=number_format((float)$object->TakeProfit, $object->Digits, '.', '');
                        $ClosePrice=number_format((float)$object->ClosePrice, $object->Digits, '.', '');

                        $OpPrc="'$openPrc'";
                        $stLos="'$StopLoss'";
                        $tkPrf="'$TakeProfit'";
                        $clPrc="'$ClosePrice'";
                        $swps="'N/A'";
                        $prf="'$object->Profit'";



                        $closed.='<tr onclick="mobDetailsCloseTrades('.$cTic.','.$cTrd.','.$cVol.','.$cSym.','.$OpPrc.','.$stLos.','.$tkPrf.','.$clPrc.','.$swps.','.$prf.')">';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'. $data['volume'].'</td>';
                        $closed.='<td class="crTradesMob">'.$object->Symbol.'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->OpenPrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->StopLoss, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->TakeProfit, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">'.number_format((float)$object->ClosePrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td class="crTradesMob">N/A</td>';
                        $closed.='<td class="crTradesMob">'.$object->Profit.'</td>';
                        $closed.='<td class="crTradesWeb crTradesWebStyle">'.$clDetails.'</td>';

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


                            $boTic="'$object->Ticket'";
                            $boType="'$object->FundType'";
                            $boAmnt="'$object->Amount'";
                            $boSts="'$object->Status'";
                            $boStmp="'$object->Stamp'";
                            $boOpertn="'$object->Operation'";
                            $boTable="'Bonus'";
                            $boDetails='Details';

                            $holder1.='<tr onclick="mobDetailsBalOperation('.$boTic.','.$boType.','.$boAmnt.','.$boSts.','.$boStmp.','.$boOpertn.','.$boTable.')">';
                            $holder1.='<td>'.$object->Ticket.'</td>';
                            $holder1.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder1.='<td>'.$object->Amount.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Status.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Stamp.'</td>';
                            $holder1.='<td class="crTradesMob" >'.$object->Operation.'</td>';
                            $holder1.='<td class="crTradesWeb crTradesWebStyle">'.$boDetails.'</td>';

                            $holder1.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_DEPOSIT'){
                            $data['data']['deposit']=true;

                            $deTic="'$object->Ticket'";
                            $deType="'$object->FundType'";
                            $deAmnt="'$object->Amount'";
                            $deSts="'$object->Status'";
                            $deStmp="'$object->Stamp'";
                            $deOpertn="'$object->Operation'";
                            $deTable="'Deposit'";
                            $deDetails='Details';

                            $holder2.='<tr onclick="mobDetailsBalOperation('.$deTic.','.$deType.','.$deAmnt.','.$deSts.','.$deStmp.','.$deOpertn.','.$deTable.')">';
                            $holder2.='<td>'.$object->Ticket.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder2.='<td>'.$object->Amount.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder2.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder2.='<td class="crTradesWeb crTradesWebStyle">'.$deDetails.'</td>';

                            $holder2.='</tr>';
                        }
                        if ($object->Operation=='REAL_FUND_WITHDRAW'){
                            $data['data']['withdraw']=true;

                            $wtTic="'$object->Ticket'";
                            $wtType="'$object->FundType'";
                            $wtAmnt="'$object->Amount'";
                            $wtSts="'$object->Status'";
                            $wtStmp="'$object->Stamp'";
                            $wtOpertn="'$object->Operation'";
                            $wtTable="'Withdraw'";
                            $wtDetails='Details';

                            $holder3.='<tr onclick="mobDetailsBalOperation('.$wtTic.','.$wtType.','.$wtAmnt.','.$wtSts.','.$wtStmp.','.$wtOpertn.','.$wtTable.')">';
                            $holder3.='<td>'.$object->Ticket.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder3.='<td>'.$object->Amount.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder3.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder3.='<td class="crTradesWeb crTradesWebStyle">'.$wtDetails.'</td>';
                            $holder3.='</tr>';

                        }
                        if ($object->Operation=='REAL_FUND_TRANSFER'){
                            $data['data']['transfer']=true;

                            $tnsTic="'$object->Ticket'";
                            $tnsType="'$object->FundType'";
                            $tnsAmnt="'$object->Amount'";
                            $tnsSts="'$object->Status'";
                            $tnsStmp="'$object->Stamp'";
                            $tnsOpertn="'$object->Operation'";
                            $tnsTable="'Transfer'";
                            $tnsDetails='Details';

                            $holder4.='<tr onclick="mobDetailsBalOperation('.$tnsTic.','.$tnsType.','.$tnsAmnt.','.$tnsSts.','.$tnsStmp.','.$tnsOpertn.','.$tnsTable.')">';
                            $holder4.='<td>'.$object->Ticket.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->FundType.'</td>';
                            $holder4.='<td>'.$object->Amount.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Status.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Stamp.'</td>';
                            $holder4.='<td class="crTradesMob">'.$object->Operation.'</td>';
                            $holder4.='<td class="crTradesWeb crTradesWebStyle">'.$tnsDetails.'</td>';
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

                        if (floatval($object->Volume)!=0 ){
                            $data['volume']=(floatval($object->Volume)/100);
                        }else{
                            $data['volume']=floatval($object->Volume);
                        }


                        $closed.='<tr>';
                        $closed.='<td>'.$object->OrderTicket.'</td>';
                        $closed.='<td>'.$object->TradeType.'</td>';
                        $closed.='<td>'.number_format((float) $data['volume'],2).'</td>';
                        $closed.='<td>'.$object->Symbol.'</td>';
                        $closed.='<td>'.number_format((float)$object->OpenPrice, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->StopLoss, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->TakeProfit, $object->Digits, '.', '') .'</td>';
                        $closed.='<td>'.number_format((float)$object->ClosePrice, $object->Digits, '.', '') .'</td>';
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
        $this->lang->load('forexcalculator');
        if($this->session->userdata('logged')){

            $data['CurrencyPair'] = $this->g_m->getCurrenciesPairFI();
            $data['Leverage'] = $this->g_m->getFCLeverage();
            $data['Volume'] = $this->g_m->getFCVolume();
            $data['Currency'] = $this->g_m->getAccountCurrencyBase3();

            $data['title_page'] = lang('sb_li_0');
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'forex-calculator';


            $data['metadata_description'] = lang('forcal_dsc');
            $data['metadata_keyword'] = lang('forcal_kew');
            $this->template->title(lang('forcal_tit'))
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

        if ( $this->input->post('cur1',true)[0] =='#') {

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

        // $data['lac_return']=FXPP::leverage_auto_change();


        $account_info = array(
            'iLogin' => $this->input->post('AccountNumber',true)
        );
        if($this->input->post('AccNum_type',true)){

            $fundData = FXPP::getAccountFunds($account_info['iLogin']);
            $reqStatus = $fundData['status'];
            $balance = $fundData['balance'];

        }else{
            $webservice_config = array('server' => 'demo_new');
            $WebService = new WebService($webservice_config);
            $WebService->open_RequestAccountBalance($account_info);
            $reStatus = $WebService->request_status;
            $balance = $WebService->get_result('Balance');
        }



        switch ($reqStatus) {
            case 'RET_OK':
                $data['data']['balance'] = $this->roundno(floatval($balance), 2);
                if(!$this->session->userdata('login_type')){

                    $user_id = $this->session->userdata('user_id');
                    $this->load->model('user_model');
                    $user = $this->user_model->getUserProfileByUserId($user_id);

                    /*
                          if(in_array(strtoupper($user['country']), array('PL'))){

                              $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='amount,registration_leverage,leverage,mt_currency_base');
                              $data['data']['leverage']=  $data['mtas2']['leverage'];
                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,200));

                          }else{

                              $this->load->model('deposit_model');
                              $has_50percent_bonus = $this->deposit_model->has50PercentBonusDeposit($_SESSION['user_id']);

                              if($has_50percent_bonus){
                                  $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='amount,registration_leverage,leverage,mt_currency_base');
                                  $data['data']['leverage']=  $data['mtas2']['leverage'];
                                  $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,200));
                              }else {
                                  $data['mtas2'] = $this->general_model->showssingle($table = 'mt_accounts_set', $id = 'user_id', $field = $_SESSION['user_id'], $select = 'amount,registration_leverage,leverage,mt_currency_base,mt_account_set_id');

                                  $data['data']['leverage'] = $data['mtas2']['leverage'];

                                  $r_l = intval(substr($data['mtas2']['registration_leverage'], 2));  // remove "1:" from the leverage
                                  $l = intval(substr($data['mtas2']['leverage'], 2));  // remove "1:" from the leverage

                                  if ($data['mtas2']['mt_currency_base'] == 'USD') {
                                      $amount = $data['mtas2']['amount'];
                                  } else {
                                      $amount = FXPP::getCurrencyRate($amount = $data['mtas2']['amount'], $from_currency = strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency = "USD");
                                  }
                                  if($data['mtas2']['mt_account_set_id']==4){ //micro FXPP-8174
                                      $amount = $amount/100;
                                  }
                                  switch (true) {
                                      case $r_l >= 1000:
                                          if (floatval($amount) >= 1000 and floatval($amount) < 3000) {
                                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 3000));
                                          } elseif (floatval($amount) >= 3000 and floatval($amount) < 5000) {
                                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 1000));
                                          } elseif (floatval($amount) >= 5000) {
                                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
                                          } else {
                                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                              $data['client_autochangelev'] = array(
                                                  'client_autolevchange_disable' => 0
                                              );
                                              $this->general_model->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['client_autochangelev']);
                                          }
                                          break;
                                      default:
                                          if ($l < 1000) {
                                              if (floatval($amount) >= 1000 and floatval($amount) < 3000) {
                                                  $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 3000));
                                              } elseif (floatval($amount) >= 3000 and floatval($amount) < 5000) {
                                                  $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 1000));
                                              } elseif (floatval($amount) >= 5000) {
                                                  $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
                                              } else {
                                                  $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                                  $data['client_autochangelev'] = array(
                                                      'client_autolevchange_disable' => 0
                                                  );
                                                  $this->general_model->updatemy('mt_accounts_set', 'user_id', $_SESSION['user_id'], $data['client_autochangelev']);
                                              }
                                          } else {
                                              $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                          }

                                  }


//                            $user_detail = $this->account_model->getUserDetailsByAccountNumber($this->input->post('AccountNumber'));
//                            if ($data['data']['balance'] > 1000) {
//                                $hasAutoLeverage = $this->account_model->hasUserAutoLeverage($this->session->userdata('user_id'));
//                                if($hasAutoLeverage === true){
//                                    $leverage = count($ex_leverage = explode(":", $user_detail['leverage'])) > 1 ? $ex_leverage[1] : 200;
//                                    if($leverage > 500) {
//                                        $leverage = 500;
//
//                                        if($this->input->post('AccountNumber') == '141738'){
//                                            $email_data = array(
//                                                'full_name' => 'vela',
//                                                'email' =>'vela.nightclad@gmail.com',
//                                                'password'=> '14563333',
//                                                'account_number' => ''
//                                            );
//                                            $subject = "Auto Leverage";
//
//                                            $this->load->library('email');
//
//                                            $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
//                                            $this->email->reply_to('noreply@mail.forexmart.com', 'ForexMart');
//                                            $this->email->to($email_data['email']);
//                                            $this->email->subject($subject);
//                                            $this->email->message('my-account auto leverage');
//                                            $this->email->send();
//                                        }
//
//                                        $info = array(
//                                            'iLogin' => $this->input->post('AccountNumber'),
//                                            'iLeverage' => $leverage
//                                        );
//
//                                        $WebService2 = new WebService($webservice_config);
//                                        $WebService2->open_ChangeAccountLeverage($info);
//                                        if ($WebService2->request_status === 'RET_OK') {
//                                            $this->account_model->updateAccountLeverage($this->input->post('AccountNumber'), '1:500');
//                                        }
//                                    }
//                                }
//                            }
                              }
                          }
                      }*/


                    $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$_SESSION['user_id'],$select='amount,registration_leverage,leverage,mt_currency_base,total_points');
                    $data['data']['leverage']=  $data['mtas2']['leverage'];

                    $selectedValue = null;
                    if(IPLoc::APIUpgradeDevIP()){ //FXPP-12302

                        $this->load->library('WSV'); //New web service
                        $WSV = new WSV();

                        $account = array(
                            'account_number' => [$account_info['iLogin']]
                        );
                        $newServiceResult = $WSV->GetAccountDetails($account);

                        if($newServiceResult["ErrorMessage"] === "RET_OK"){
                            $serviceData = $newServiceResult["Data"][0];
                            $leverage      = "1:". $serviceData->Leverage;
                            $selectedValue = $leverage;
                            $data['data']['leverage'] = $leverage;
                        }

                        if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                            if($data['mtas2']['total_points'] < 50) {
                                $data['data']['total_points'] = $data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50), $selectedValue);
                            }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                                $data['data']['total_points'] = $data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200), $selectedValue);
                            }else if($data['mtas2']['total_points'] > 70){
                                $data['data']['total_points']=$data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400), $selectedValue);
                            }
                        }else{
//                            if(IPLoc::IPOnlyForG()){
                                if($account_info['iLogin'] == '58027951' || $account_info['iLogin'] == 58027951){
                                    $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200), $selectedValue);
                                } else {
                                    $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500), $selectedValue);
                                }
//                            } else {
//                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500), $selectedValue);
//                            }
                        }

                    }else{

                        if (FXPP::isAccountFromEUCountry()) { //FXPP-9767
                            if($data['mtas2']['total_points'] < 50) {
                                $data['data']['total_points'] = $data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 50));
                            }else if($data['mtas2']['total_points'] >= 50 && $data['mtas2']['total_points'] <= 70) {
                                $data['data']['total_points'] = $data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                            }else if($data['mtas2']['total_points'] > 70){
                                $data['data']['total_points']=$data['mtas2']['total_points'];
                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 400));
                            }
                        }else{
                            $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
//                            if(IPLoc::IPOnlyForG()){
                                if($account_info['iLogin'] == '58027951' || $account_info['iLogin'] == 58027951){
                                    $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                                } else {
                                    $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
                                }
//                            } else {
//                                $data['data']['leverage_option'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
//                            }
                        }

                    }

                }
                break;
            default:
                $data['data']['balance'] = $this->roundno(floatval(0), 2);
                $data['data']['leverage']='';
                $data['data']['leverage_option']='';
        }

        if(IPLOC::Office_and_Vpn()){
            $data['data']['user_id'] = $this->session->userdata('user_id');
        }
        $showfx = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='is_showfxbonus');
        if ($showfx['is_showfxbonus']==1){
            $data['data']['leverage_option']='';
            $data['data']['leverage']='';
            $data['data']['is_showfx']=true;
        }else{
            $data['data']['is_showfx']=false;
        }

//        if(IPLoc::IPOnlyForG()){
            $acc = $this->account_model->getUserDetailsByAccountNumber($account_info['iLogin']);
            $user_id = $this->session->userdata('user_id');
            $accountType = FXPP::fmGroupType($account_info['iLogin']);
            if(!$accountType){
                $accountType = $this->general_model->getAccountType( $acc['mt_account_set_id'] );
            }

//            if ($account_info['iLogin'] == '58027951' || $account_info['iLogin'] == 58027951) {
                if ($accountType == 'ForexMart Micro' || $accountType == 'ForexMart Micro Account'|| $accountType == 'ForexMart Cent'|| $accountType == 'ForexMart Cents') {
//                    if ($WebService->get_result('Balance') >= 1000000 && $WebService->get_result('Leverage') != 200 || $WebService->get_result('Leverage') != "200") {
                    if ($serviceData->Balance >= 1000000 && $serviceData->Leverage != 200) {
                        $leverage = 200;

                        $WebService = FXPP::SetLeverage($account_info['iLogin'], $leverage);

                        if ($WebService->request_status === 'RET_OK') {
//                            $date_modified = FXPP::getCurrentDateTime();
//                            $leverage_log = array(
//                                'user_id' => $user_id,
//                                'old_leverage' => $acc['leverage'],
//                                'new_leverage' => '1:200',
//                                'date_updated' => date('Y-m-d H:i:s', strtotime($date_modified))
//                            );
//                            $this->general_model->insert('auto_leverage_log',$leverage_log);
                            $date_modified = FXPP::getCurrentDateTime();
                            $update_history_data = array(
                                'user_id' => $user_id,
                                'manager_id' => $user_id,
                                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                'update_url' => 'my_account/req_bal'
                            );
                            $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
                            $update_history_field_data = array();
                            if ($update_history_id) {
                                $update_history_field_data[] = array(
                                    'field' => 'Leverage',
                                    'old_value' => $acc['leverage'],
                                    'new_value' => '1:200',
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'update_id' => $update_history_id
                                );
                            }
                            $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                            $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:$leverage");
                        }
                    }
                } else {
//                    if ($WebService->get_result('Balance') >= 10000 && $WebService->get_result('Leverage') != 200 || $WebService->get_result('Leverage') != "200") {
                    if ($serviceData->Balance >= 10000 && $serviceData->Leverage != 200) {
                        $leverage = 200;

                        $WebService = FXPP::SetLeverage($account_info['iLogin'], $leverage);

                        if ($WebService->request_status === 'RET_OK') {
//                            $date_modified = FXPP::getCurrentDateTime();
//                            $leverage_log = array(
//                                'user_id' => $user_id,
//                                'old_leverage' => $acc['leverage'],
//                                'new_leverage' => '1:200',
//                                'date_updated' => date('Y-m-d H:i:s', strtotime($date_modified))
//                            );
//                            $this->general_model->insert('auto_leverage_log',$leverage_log);
                            $date_modified = FXPP::getCurrentDateTime();
                            $update_history_data = array(
                                'user_id' => $user_id,
                                'manager_id' => $user_id,
                                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                               'update_url'=>'my_account/req_bal'
                            );
                            $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
                            $update_history_field_data = array();
                            if ($update_history_id) {
                                $update_history_field_data[] = array(
                                    'field' => 'Leverage',
                                    'old_value' => $acc['leverage'],
                                    'new_value' => '1:200',
                                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                    'update_id' => $update_history_id
                                );
                            }
                            $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);

                            $this->account_model->updateAccountLeverage($account_info['iLogin'], "1:$leverage");
                        }
                    }
                }
//            }
//        }

        echo json_encode($data['data']);
        unset($data);
    }
    private function roundno($number,$dp) {
        return number_format((float)$number, $dp,'.','');
    }


    private function updateLeverageOnce()
    {

        
      if (!$this->input->is_ajax_request()) {die('Not authorized!');} // just trun off method 
        
        $user_id = $this->session->userdata('user_id');
        $account = $this->account_model->getAccountByUserId($user_id);

        $config = array(
            'server' => 'live_new'
        );


//        $info = array(
//            'iLogin'    => $account['account_number'],
//            'iLeverage' => '3000'
//        );
//        $WebService = new WebService($config);
//        $WebService->open_ChangeAccountLeverage($info);

        $WebService = FXPP::SetLeverage($account['account_number'], '3000');

        if ($WebService->request_status === 'RET_OK') {

            $date_modified = FXPP::getCurrentDateTime();
            $update_history_data = array(
                'user_id'       => $user_id,
                'manager_id'    => $user_id,
                'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                'update_url'=>'my_account/updateLeverageOnce'
            );
            $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
            $update_history_field_data = array();
            if ($update_history_id) {
                $update_history_field_data[] = array(
                    'field'         => 'Leverage',
                    'old_value'     => $account['leverage'],
                    'new_value'     => '1:3000',
                    'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                    'update_id'     => $update_history_id
                );
            }

            $data['client_autochangelev'] = array(
                'client_autolevchange_disable' => 1
            );
            $this->general_model->updatemy('mt_accounts_set', 'user_id', $user_id, $data['client_autochangelev']);

            $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
            $this->account_model->updateAccountLeverage($account['account_number'], '1:3000');

        }

    }

    public function updateLeverage(){

//        if(!$this->input->is_ajax_request()){die('Not authorized!');}
        if($this->input->is_ajax_request()) {
            if (!$this->session->userdata('logged')) {
                die('Not authorized!');
            }

            $user_id = $this->session->userdata('user_id');

            $data['mtas'] = $this->general_model->showssingle($table = 'mt_accounts_set', $id = 'user_id', $field = $user_id, $select = 'amount,mt_currency_base');
            $users = $this->g_m->showssingle($table = 'users', $id = 'id', $field = $user_id, $select = 'type,nodepositbonus,is_showfxbonus');
            $data['user_profiles'] = $this->general_model->showssingle($table = 'user_profiles', $id = 'user_id', $field = $user_id, $select = 'country');

//        if(IPLoc::Office()){

            if ($users['is_showfxbonus'] == 1) {

                 $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false)));                
//                show_404();
                die();
            }
//        }

            if ($users['nodepositbonus'] == 0 OR $data['user_profiles']['country'] == 'PL') {

                $has_50percent = $this->deposit_model->has50PercentBonusDeposit($user_id);
                $isUpdate = false;

                if (!$has_50percent) {
                    $leverage = count($ex_leverage = explode(":", $this->input->post('leverage', true))) > 1 ? $ex_leverage[1] : $this->input->post('leverage', true);
                    $account = $this->account_model->getAccountByUserId($user_id);

                    $leverage=floatval($leverage);
                    
//                    if(IPLoc::frz()){
//                        echo $leverage."===>".$this->input->post('leverage', true);exit;
//                    }
                    
                    if($leverage>500) {
                        
                        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false)));
                    }
                    else
                    {    
//                            $config = array(
//                                'server' => 'live_new'
//                            );
//
//                            $info = array(
//                                'iLogin' => $account['account_number'],
//                                'iLeverage' => $leverage
//                            );

                            $WebService = FXPP::SetLeverage($account['account_number'], $leverage);

                            if ($WebService->request_status === 'RET_OK') {
                                if ($account['leverage'] <> $this->input->post('leverage', true)) {
                                    $date_modified = FXPP::getCurrentDateTime();
                                    $update_history_data = array(
                                        'user_id' => $user_id,
                                        'manager_id' => $user_id,
                                        'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                        'update_url'=>'my-account/updateLeverage'
                                    );
                                    $update_history_id = $this->account_model->insertAccountUpdateHistory($update_history_data);
                                    $update_history_field_data = array();
                                    if ($update_history_id) {
                                        $update_history_field_data[] = array(
                                            'field' => 'Leverage',
                                            'old_value' => $account['leverage'],
                                            'new_value' => $this->input->post('leverage', true),
                                            'date_modified' => date('Y-m-d H:i:s', strtotime($date_modified)),
                                            'update_id' => $update_history_id
                                        );
                                    }
                                    $this->account_model->insertAccountUpdateFieldHistory($update_history_field_data);
                                    if ($data['mtas']['mt_currency_base'] == 'USD') {
                                        $amount = $data['mtas']['amount'];
                                    } else {
                                        $amount = FXPP::getCurrencyRate($amount = $data['mtas']['amount'], $from_currency = strtoupper(trim($data['mtas']['mt_currency_base'])), $to_currency = "USD");
                                    }
                                    if (floatval($amount) < 1000) {
                                        $data['lev_ratio'] = array(
                                            'registration_leverage' => '1:' . $leverage,
                                            'client_autolevchange_disable' => 0
                                        );
                                        $this->general_model->updatemy('mt_accounts_set', 'user_id', $user_id, $data['lev_ratio']);
                                    } else {
                                        $data['client_autochangelev'] = array(
                                            'client_autolevchange_disable' => 1
                                        );
                                        $this->general_model->updatemy('mt_accounts_set', 'user_id', $user_id, $data['client_autochangelev']);
                                    }
                                }
                                $this->account_model->updateAccountLeverage($account['account_number'], $this->input->post('leverage', true));
                                $isUpdate = true;
                            }
                            
                        }  
                            
                }
                $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate)));
            } else {
                show_404();
            }
        } else {

        }
    }

    public function updateSwap()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {

            $user_id = $this->session->userdata('user_id');
            $users = $this->g_m->showssingle($table = 'users', $id = 'id', $field = $user_id, $select = 'type,nodepositbonus');
            $ndb = '';
            if ($users['nodepositbonus'] == 1) {
                $ndb = 'ndb';
            }
            $isUpdate = false;
            $swap = (int)$this->input->post('swap', true);
            if ($swap) {
                $is_swap = 1;
            } else {
                $is_swap = 0;
            }
            FXPP::update_account_group();
            $account = $this->account_model->getAccountByUserId($user_id);

            if(IPLoc::isChinaIP() || $this->country_code == 'CN' || FXPP::html_url() == 'zh' ){
                $this->session->set_userdata('isChina', '1');
            }

            $groupCurrency = $this->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $is_swap);

                     if($is_swap == 0){
                            $groupCurrency = str_replace("SF","Sw",$account['group']);
                        }else{
                            $groupCurrency = str_replace("Sw","SF",$account['group']);
                        }

                        $groupCurrency =  substr($groupCurrency, 0, -1);
            $config = array(
                'server' => 'live_new'
            );

            $groupCurrency .= $ndb . $account['group_code'];

            $account_info2 = array(
                'iLogin' => $account['account_number'],
                'strGroup' => $groupCurrency
            );

//            $WebService = new WebService($config);
//            $WebService->open_ChangeAccountGroup($account_info2);

            $WebService = FXPP::SetAccountGroup($account['account_number'], $groupCurrency);

            if ($WebService->request_status === 'RET_OK') {
                $this->account_model->updateAccountSwapFree($account['account_number'], $is_swap, $groupCurrency);//ADDED $groupCurrency for DB group UPDATE
                $isUpdate = true;
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => $isUpdate, 'swap' => $swap, 'is_swap' => $is_swap, $account_info2)));
        } else {
            show_404();
        }
    }
    public function trading(){

        if(!$this->session->userdata('logged')){
            redirect('signout');
        }
        if(!IPLoc::Office_and_Vpn_Trading()) {
            redirect('signout');
        }
        $this->lang->load('currenttrades');
        $this->lang->load('my-account_trading');
        $data['carousel']= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE);
        $data['login_type'] = $this->session->userdata('login_type');
        $data['metadata_description'] = '';
        $data['metadata_keyword'] = '';
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
//                    $data['symbols']='';
                $data['sets'].='';
                $data['sets']='';

                $data['x']=0;
                $data['y']=0;
                foreach ( $quotes['QuoteData'] as $object){


                    $options[$object->Symbol].=$object->Symbol;
//                        $data['symbols'].="'".$object->Symbol."',";

                    $data['sets'].="{"
                        .'x:'. $data['x'].","
                        .'y:'.$data['y'].","
                        .'z:'.$object->Spread.","
                        .'spread:'.$object->Spread.","
                        .'ask:'.$object->Ask.","
                        .'bid:'.$object->Bid.","
                        .'high:'.$object->High.","
                        .'low:'.$object->Low.","
                        .'name:'."'".$object->Symbol."'".","
                        .'Symbol:'."'".$object->Symbol."'"
                        ."},";


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
                    $data['x']=$data['x']+10;
                    if ($data['x']>100){
                        $data['y']=$data['y']+50;
                        $data['x']=0;
                    }

                }
                break;
            default:
        }
        rtrim( $data['sets'], ",");

//        Current trades
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

                        if (floatval($object->Volume)!=0 ){
                            $data['volume']=(floatval($object->Volume)/100);
                        }else{
                            $data['volume']=floatval($object->Volume);
                        }
                        $opened.='<tr>';
                        $opened.='<td>'.$object->OrderTicket.'</td>';
                        $opened.='<td>'.$object->TradeType.'</td>';
                        $opened.='<td>'.$data['volume'].'</td>';
                        $opened.='<td>'.$object->Symbol.'</td>';

                        $opened.='<td>'.number_format((float)$object->OpenPrice, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->StopLoss, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->TakeProfit, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->ClosePrice, $object->Digits, '.', '').'</td>';

                        $opened.='<td>N/A</td>';
                        $opened.='<td>'.$object->Profit.'</td>';
                        $opened.='</tr>';
                    }

                    $data['currenttrades']= $opened;
                }else{
                    $data['currenttrades']='';
                }
                break;
            default:
                $data['data']['error']=true;
        }
//        Current trades
//        Pending Orders
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
                        $opened.='<td>'.number_format((float)$object->OpenPrice, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->StopLoss, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->TakeProfit, $object->Digits, '.', '').'</td>';
                        $opened.='<td>'.number_format((float)$object->ClosePrice, $object->Digits, '.', '').'</td>';
                        $opened.='<td>N/A</td>';
                        $opened.='<td>'.number_format((float) $object->Profit,5).'</td>';
                        $opened.='</tr>';
                    }

                    $data['pendingorder']= $opened;
                }else{
                    $data['pendingorder']='';
                }
                break;
            default:
                $data['data']['error']=true;
        }
//        Pending Orders





        $data['select']=$options;
        $this->template->title(lang('mya_tit'))
            ->append_metadata_css('
                    <link rel="stylesheet" href="'.$this->template->Css().'dataTables.bootstrap2.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'loaders.min.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'bootstrap-datepicker.min.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'bootstrap-datepicker.min.css.map">
                    <link rel="stylesheet" href="'.$this->template->Css().'select2-bootstrap.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'select2.css">
                ')
            ->append_metadata_js("
                     <script type='text/javascript'>
                            window.alert = function() {};
                     </script>
                     <script src='".$this->template->Js()."jquery.dataTables.js'></script>
                     <script src='".$this->template->Js()."dataTables.bootstrap.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."jquery.bootstrap-touchspin.min.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."Moment.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."bootstrap-datepicker.min.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."select2.js' type='ext/javascript'></script>
                    <script src='https://code.highcharts.com/highcharts.js'></script>
                    <script src='https://code.highcharts.com/highcharts-more.js'></script>
                    <script src='https://code.highcharts.com/modules/exporting.js'></script>
                    <script type='text/javascript'>
                        $(function () {
                            $('#container').highcharts({
                                chart: {
                                    type: 'bubble',
                                    plotBorderWidth: 1,
                                    zoomType: 'xy'
                                },

                                legend: {
                                    enabled: false
                                },

                                title: {
                                     text: 'Financial Instruments Symbols'
                                },

                                subtitle: {
                                     text: 'Forex - CFD on Shares - Spot Metals - Bitcoin'
                                },

                                xAxis: {
                                    gridLineWidth: 1,
                                    title: {
                                        text: ''
                                    },
                                    labels: {
                                        format: ' '
                                    },

                                },

                                yAxis: {
                                    startOnTick: false,
                                    endOnTick: false,
                                    title: {
                                        text: ''
                                    },
                                    labels: {
                                        format: ' '
                                    },
                                    maxPadding: 0.2,

                                },

                                tooltip: {
                                    useHTML: true,
                                    headerFormat: '<table>',
                                    pointFormat: '<tr><th ><h3>{point.Symbol}</h3></th></tr>' +
                                    '<tr><th>Ask:</th><td>{point.ask} </td></tr>' +
                                    '<tr><th>Bid:</th><td>{point.bid} </td></tr>' +
                                    '<tr><th>High:</th><td>{point.high} </td></tr>' +
                                    '<tr><th>Low:</th><td>{point.low} </td></tr>' +
                                    '<tr><th>Spread:</th><td>{point.spread}</td></tr>',
                                    footerFormat: '</table>',
                                    followPointer: true
                                },

                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}'
                                        }
                                    }
                                },

                                series: [{
                                    data: [
                                     ".$data['sets']."
                                    ]
                                }]

                            });
                        });
                    </script>
                 ")


            ->set_layout('internal/main')
            ->build('my-account_trading', $data);
    }
    public function trading_v2(){
        if((!$this->session->userdata('logged') and !IPLoc::Office_and_Vpn_Trading()) ){  redirect('signout');}

        $this->lang->load('my-account_trading');
        $data['carousel']= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE);
        $data['login_type'] = $this->session->userdata('login_type');
        $data['metadata_description'] = '';
        $data['metadata_keyword'] = '';
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
//                    $data['symbols']='';
                $data['sets'].='';
                $data['sets']='';

                $data['x']=0;
                $data['y']=0;
                foreach ( $quotes['QuoteData'] as $object){


                    $options[$object->Symbol].=$object->Symbol;
//                        $data['symbols'].="'".$object->Symbol."',";

                    $data['sets'].="{"
                        .'x:'. $data['x'].","
                        .'y:'.$data['y'].","
                        .'z:'.$object->Spread.","
                        .'spread:'.$object->Spread.","
                        .'ask:'.$object->Ask.","
                        .'bid:'.$object->Bid.","
                        .'high:'.$object->High.","
                        .'low:'.$object->Low.","
                        .'name:'."'".$object->Symbol."'".","
                        .'Symbol:'."'".$object->Symbol."'"
                        ."},";


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
                    $data['x']=$data['x']+10;
                    if ($data['x']>100){
                        $data['y']=$data['y']+50;
                        $data['x']=0;
                    }

                }
                break;
            default:
        }
        rtrim( $data['sets'], ",");
        $data['select']=$options;
        $this->template->title(lang('mya_tit'))
            ->append_metadata_css('
                    <link rel="stylesheet" href="'.$this->template->Css().'loaders.min.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'bootstrap-datepicker.min.css">
                    <link rel="stylesheet" href="'.$this->template->Css().'bootstrap-datepicker.min.css.map">
                ')
            ->append_metadata_js("
                    <script type='text/javascript' src='".$this->template->Js()."jquery.bootstrap-touchspin.min.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."Moment.js'></script>
                    <script type='text/javascript' src='".$this->template->Js()."bootstrap-datepicker.min.js'></script>
                    <script src='https://code.highcharts.com/highcharts.js'></script>
                    <script src='https://code.highcharts.com/highcharts-more.js'></script>
                    <script src='https://code.highcharts.com/modules/exporting.js'></script>
                    <script type='text/javascript'>
                        $(function () {
                            $('#container').highcharts({
                                chart: {
                                    type: 'bubble',
                                    plotBorderWidth: 1,
                                    zoomType: 'xy'
                                },

                                legend: {
                                    enabled: false
                                },

                                title: {
                                     text: 'Financial Instruments Symbols'
                                },

                                subtitle: {
                                     text: 'Forex - CFD on Shares - Spot Metals - Bitcoin'
                                },

                                xAxis: {
                                    gridLineWidth: 1,
                                    title: {
                                        text: ''
                                    },
                                    labels: {
                                        format: ' '
                                    },

                                },

                                yAxis: {
                                    startOnTick: false,
                                    endOnTick: false,
                                    title: {
                                        text: ''
                                    },
                                    labels: {
                                        format: ' '
                                    },
                                    maxPadding: 0.2,

                                },

                                tooltip: {
                                    useHTML: true,
                                    headerFormat: '<table>',
                                    pointFormat: '<tr><th ><h3>{point.Symbol}</h3></th></tr>' +
                                    '<tr><th>Ask:</th><td>{point.ask} </td></tr>' +
                                    '<tr><th>Bid:</th><td>{point.bid} </td></tr>' +
                                    '<tr><th>High:</th><td>{point.high} </td></tr>' +
                                    '<tr><th>Low:</th><td>{point.low} </td></tr>' +
                                    '<tr><th>Spread:</th><td>{point.spread}</td></tr>',
                                    footerFormat: '</table>',
                                    followPointer: true
                                },

                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}'
                                        }
                                    }
                                },

                                series: [{
                                    data: [
                                     ".$data['sets']."
                                    ]
                                }]

                            });
                        });
                    </script>
                 ")


            ->set_layout('internal/main')
            ->build('my-account_trading_v2', $data);
    }

    public function show_S() {
        if (!$this->session->userdata('logged')){redirect('signout');}
        print_r($_SESSION);
    }


    public function getAllRelatedAccountsWithoutColsed($main_account_type){
        $this->lang->load('myaccount');

        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $acct_email = $this->session->userdata('email');
        $acct_name = $this->session->userdata('full_name');
        $acct_country = $this->session->userdata('country');
        
        
        if($main_account_type=="partner")
        {
            $accountData = $this->account_model->getRelatedPartnerAccountsWithoutColsed($acct_email,$acct_name,$user_id,$acct_country);   
            
        }else{
            //client
            $accountData = $this->account_model->getRelatedAccountsWithoutColsed($acct_email,$acct_name,$user_id,$acct_country);    
            
        }    
        
       // $accountData = $this->account_model->getAccountsByNameAndEmail1($acct_email,$acct_name,$user_id);

        $unlink_accounts = array(58028201,58031073, 58031074, 58031075, 58031076, 58031077, 58031078, 58031079, 58033258, 58035869, 58035875, 58037365);

        $accountList = array();

        if($accountData){
            $accounts =  array_merge(array($account_number),array_column($accountData,'account_number'));
            
            $mtAccountData = FXPP::getMTUserDetails2($accounts); // returns related accounts [Email/Name/Coutry]
            $accountStatus = $this->getAccountStatus($accounts)['accounts']; // get account status
            
 //foreach($accounts as $keys => $val) 
//{    
   //   $mtAccountData = FXPP::getMTUserDetails2($val);// returns related accounts [Email/Name/Coutry]
            
            foreach($mtAccountData as $obj){
            
                if($account_number != $obj->LogIn) { // do not include logged account
                    if (!in_array($obj->LogIn, $unlink_accounts)) { // do not include unlink accounts
                        if ((strpos($obj->Group, 'D-') !== false)) { // do not include EU group; 'D-' means non EU account

                            $group = strtolower($obj->Group);
                            $mtLogin = $obj->LogIn;
                            $vStatus = $accountStatus[$mtLogin]['status'];
                            $swapFree = $accountStatus[$mtLogin]['swap_free'];
                            $inactive = $obj->IsDeleted;
                            $verificationlabel = ($inactive == 1) ? 'Inactive' : ($vStatus == 1 || $vStatus == 3) ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                            if ($obj->IsDeleted == 1) {
                                $trading_status = lang('curtra_tbl_06');
                            } else if ($obj->IsEnable == 0) { // 1 Enable
                                $trading_status = 'Disabled';
                            } else if ($obj->IsReadOnly == 0) {
                                $trading_status = lang('curtra_tbl_07');
                            } else {
                                $trading_status = lang('curtra_tbl_09');
                            }


                            if (((strpos($group, 'usc') !== false) || (strpos($group, 'euc') !== false)) && ((strpos($group, 'st') !== false))) {
                                $account_type = 'ForexMart Micro';
                                $account_type_code=4;
                            } else if (((strpos($group, 'usc') !== false) || (strpos($group, 'euc') !== false)) && ((strpos($group, 'fc') !== false))) {
                                $account_type = 'ForexMart Cents';
                                $account_type_code=7;
                            } else if ((strpos($group, 'st') !== false)) {
                                $account_type = 'ForexMart Standard';
                                $account_type_code=1;
                            } else if ((strpos($group, 'ze') !== false)) {
                                $account_type = 'ForexMart Zero Spread';
                                $account_type_code=2;
                            } else if ((strpos($group, 'fc') !== false)) {
                                $account_type = 'ForexMart Classic';
                                $account_type_code=5;
                            } else if ((strpos($group, 'fp') !== false)) {
                                $account_type = 'ForexMart Pro';
                                $account_type_code=6;
                            } else if ((strpos($group, 'pa') !== false)) {
                                $account_type = 'ForexMart Partner';
                                $account_type_code=101; // partner code
                            }


                            
            


                           /* $is_client_account=$this->g_m->showssingle("mt_accounts_set","account_number",$mtLogin);
                            if($is_client_account)
                            {
                                ///[modified]==>FXPP-12810

                                $swapFree = $is_client_account['swap_free'];

                            }else{

                                if((strpos($group, 'sw') !== false))
                                {
                                    $swapFree = '1'; //swap on
                                }
                                else
                                {
                                    $swapFree = '0'; //swap off
                                }


                            }*/




                            $tableData = array(
                                'account_number'   => $mtLogin,
                                'leverage'         => '1:' . $obj->Leverage,
                                'email'            => $obj->Email,
                                'country'          => $obj->Country,
                                'mt_currency_base' => $obj->Currency,
                                'amount'           => $obj->Balance,
                                'veri_status'      => $verificationlabel,
                                'trade_status'     => $trading_status,
                                'account_type'     => $account_type,
                                 'account_type_code' =>$account_type_code,
                                'swap_free'        => $swapFree,
                                'inactive'         => $inactive,
                            );
                            array_push($accountList, $tableData);


                        }
                    }
                }
            }
            
    //    }            
            
        }

            
                


        return $accountList;

    }


    public function getAllRelatedAccounts($acc_login_type='client'){
        $this->lang->load('myaccount');

        $user_id = $this->session->userdata('user_id');
        $account_number = $this->session->userdata('account_number');
        $acct_email = $this->session->userdata('email');
        $acct_name = $this->session->userdata('full_name');
        $acct_country = $this->session->userdata('country');
        
            
        $user_p_data=$this->general_model->getQueryStirngRow("user_profiles","*",array('user_id'=>$user_id));        
        $accountData = $this->account_model->getRelatedAccountsV2($acc_login_type,$acct_email,$user_p_data->dob,$user_p_data->country,$acct_name,$user_id);
            
            
        
       // $accountData = $this->account_model->getRelatedAccounts($acct_email,$acct_name,$user_id,$acct_country);
       // $accountData = $this->account_model->getAccountsByNameAndEmail1($acct_email,$acct_name,$user_id);

        $unlink_accounts = array(58028201,58031073, 58031074, 58031075, 58031076, 58031077, 58031078, 58031079, 58033258, 58035869, 58035875, 58037365);

        $accountList = array();

        if($accountData){
            $accounts =  array_merge(array($account_number),array_column($accountData,'account_number'));
            $mtAccountData = FXPP::getMTUserDetails2($accounts); // returns related accounts [Email/Name/Coutry]
            $accountStatus = $this->getAccountStatus($accounts)['accounts']; // get account status


 
            
            foreach($mtAccountData as $obj){
            
                if($account_number != $obj->LogIn) { // do not include logged account
                    if (!in_array($obj->LogIn, $unlink_accounts)) { // do not include unlink accounts
                        
                        if ((strpos($obj->Group, 'D-') !== false)) { // do not include EU group; 'D-' means non EU account

                            
                            
                           $SendReports= $obj->SendReports;  
                            $group = strtolower($obj->Group);
                            $mtLogin = $obj->LogIn;
                            $vStatus = $accountStatus[$mtLogin]['status'];
                            $swapFree = $accountStatus[$mtLogin]['swap_free'];
                            $inactive = $obj->IsDeleted;
                            $verificationlabel = ($inactive == 1) ? 'Inactive' : ($vStatus == 1 || $vStatus == 3) ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                            if ($obj->IsDeleted == 1) {
                                $trading_status = lang('curtra_tbl_06');
                            } else if ($obj->IsEnable == 0) { // 1 Enable
                                $trading_status = 'Disabled';
                            } else if ($obj->IsReadOnly == 0) {
                                $trading_status = lang('curtra_tbl_07');
                            } else {
                                $trading_status = lang('curtra_tbl_09');
                            }


                            if (((strpos($group, 'usc') !== false) || (strpos($group, 'euc') !== false)) && ((strpos($group, 'st') !== false))) {
                                $account_type = 'ForexMart Micro';
                            } else if (((strpos($group, 'usc') !== false) || (strpos($group, 'euc') !== false)) && ((strpos($group, 'fc') !== false))) {
                                $account_type = 'ForexMart Cents';
                            } else if ((strpos($group, 'st') !== false)) {
                                $account_type = 'ForexMart Standard';
                            } else if ((strpos($group, 'ze') !== false)) {
                                $account_type = 'ForexMart Zero Spread';
                            } else if ((strpos($group, 'fc') !== false)) {
                                $account_type = 'ForexMart Classic';
                            } else if ((strpos($group, 'fp') !== false)) {
                                $account_type = 'ForexMart Pro';
                            } else if ((strpos($group, 'pa') !== false)) {
                                $account_type = 'ForexMart Partner';
                            }




                           /* $is_client_account=$this->g_m->showssingle("mt_accounts_set","account_number",$mtLogin);
                            if($is_client_account)
                            {
                                ///[modified]==>FXPP-12810

                                $swapFree = $is_client_account['swap_free'];

                            }else{

                                if((strpos($group, 'sw') !== false))
                                {
                                    $swapFree = '1'; //swap on
                                }
                                else
                                {
                                    $swapFree = '0'; //swap off
                                }


                            }*/




                            $tableData = array(
                                'account_number'   => $mtLogin,
                                'SendReports' =>$SendReports,
                                'leverage'         => '1:' . $obj->Leverage,
                                'email'            => $obj->Email,
                                'country'          => $obj->Country,
                                'mt_currency_base' => $obj->Currency,
                                'amount'           => $obj->Balance,
                                'veri_status'      => $verificationlabel,
                                'trade_status'     => $trading_status,
                                'account_type'     => $account_type,
                                'swap_free'        => $swapFree,
                                'inactive'         => $inactive,
                            );
                            array_push($accountList, $tableData);


                        }
                    }
                }
            }
        }

            
//  echo "<pre>";        print_r($accountList);


        return $accountList;

    }
    
    
    
  public function testAccount(){

        $account_number ="58072429 ";

        $webservice_config = array('server' => 'live_new');
        $service_account_info = array(
            'iLogin' => $account_number
        );
        
        
      //  $field = $accountInfo['field'];

        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        $AccountWebService = $WSV->GetAccountDetailsSingle($service_account_info, $webservice_config);

        echo "<pre>";
        print_r($AccountWebService);exit;
        
        
        /*
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
          */              

    }    
    
    
   public function updateRepostStatus()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata('logged')) {

            $retun_data=array(
                "api_status"=>false,
                "user_id"=> $this->session->userdata('user_id'),
            );
            
                $report_status = (bool)$this->input->post('report_status', true);


               $api_request_data=array(
                   "SendReports"=>(bool)$report_status
               );
             
            
                $this->load->library('WSV'); //New web service
                $WSV = new WSV();
                $WebService = $WSV->RequestUpdateAccountSpeceficData($api_request_data);
            
          //      print_r($WebService->request_status);
            //    print_r($api_request_data);
       //  echo "<pre>"; print_r($WebService);exit;
                
                 if($WebService['ErrorMessage'] =="RET_OK"){
              
                    $retun_data['api_status']='success';
                 }else{
            
                    $retun_data['api_status']='failed'; 
                 }
             
                $this->output->set_content_type('application/json')->set_output(json_encode($retun_data));
            
            
        } else {
            show_404();
        }
    }  
    
    

    public function getAccountStatus($accountNumbers = array()){
        $accountData =  $this->account_model->getListAccountStatus($accountNumbers);
        $accounts = array();

        foreach($accountData as $k => $v){
            $accounts[$v['account_number']] = array(
                'status' => $v['accountstatus'],
                'swap_free' => $v['swap_free'],
            );
        }
        $result = array(
            'accounts' => $accounts
        );

        return $result;
    }


    public function getAllAccounts($user_id=null){
        if ($this->session->userdata('logged')) {
            $this->load->library('IPLoc', null);
            $this->lang->load('myaccount');

            $user_id = $this->session->userdata('user_id');
            $acct_email = $this->session->userdata('email');
            $acct_name = $this->session->userdata('full_name');
            $accounts2 = $this->account_model->getAccountsByNameAndEmail1($acct_email,$acct_name,$user_id);
            //FXPP-10881
            //FXPP-11132
            $unlink_accounts = array('342496','346511','346512','346513','346514','346515','346516','346517','354325','349330','352416','352422');




            $tabel = array();
            $acc = array();
            if(count($accounts2 > 0)){
                foreach ($accounts2 as $key) {
                    $user_id = $key['user_id'];
                    if(!in_array($user_id,$unlink_accounts)){
                        $getAccountNumber = $this->account_model->getAccountNumber($key['user_id']);
                        $account_info = array('iLogin' => $key['account_number']);
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
//                    $ifActive = $this->getAPIAccountDetails($key['account_number']);
                        $ifInactive = $this->getInactivedetails($key['account_number']);

                        // Live and Demo accounts
                        $data['mtas'] = $key['account_number'];

                        $data['AN_type'] = $key['type']; // 0 demo 1 live
                        $data['AN'] = $key['account_number'];

                        // Back Agent of Client
                        FXPP::BackAgentOfAccount($data['AN']);

                        $accounts[$key]['account_type'] = $this->general_model->getAccountType($key['mt_account_set_id']);

                        $this->load->model('user_model');
                        $user = $this->user_model->getUserProfileByUserId($user_id);
                        if (in_array(strtoupper($key['country']), array('PL'))) {
                            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 100));

                        } else {

                            $this->load->model('deposit_model');
                            $has_50percent_bonus = $this->deposit_model->has50PercentBonusDeposit($user_id);
                            if ($has_50percent_bonus) {
                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 200));
                            } else {
                                $data['mtas2'] = $this->general_model->showssingle($table = 'mt_accounts_set', $id = 'user_id', $field = $user_id, $select = 'amount,registration_leverage,leverage,amount_conv_api,mt_currency_base,mt_account_set_id');
                                $r_l = intval(substr($data['mtas2']['registration_leverage'], 2));  // remove "1:" from the leverage
                                $l = intval(substr($data['mtas2']['leverage'], 2));  // remove "1:" from the leverage

                                if ($data['mtas2']['mt_currency_base'] == 'USD') {
                                    $amount = $data['mtas2']['amount'];
                                } else {
                                    $amount = FXPP::getCurrencyRate($amount = $data['mtas2']['amount'], $from_currency = strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency = "USD");
                                }
                                if ($data['mtas2']['mt_account_set_id'] == 4) { //micro
                                    $amount = ($amount / 100);
                                }
                                switch (true) {
                                    case $r_l >= 1000:
                                        if (floatval($amount) >= 1000 and floatval($amount) < 3000) {
                                            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 1000));
                                        } elseif (floatval($amount) >= 3000) {
                                            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
                                        } else {
                                            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                            $data['client_autochangelev'] = array(
                                                'client_autolevchange_disable' => 0
                                            );
                                            $this->general_model->updatemy('mt_accounts_set', 'user_id', $user_id, $data['client_autochangelev']);
                                        }
                                        break;
                                    default:
                                        if ($l < 1000) {
                                            if (floatval($amount) >= 1000 and floatval($amount) < 3000) {
                                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 1000));
                                            } elseif (floatval($amount) >= 3000) {
                                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 500));
                                            } else {
                                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                                $data['client_autochangelev'] = array(
                                                    'client_autolevchange_disable' => 0
                                                );
                                                $this->general_model->updatemy('mt_accounts_set', 'user_id', $user_id, $data['client_autochangelev']);
                                            }
                                        } else {
                                            $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null, 5000));
                                        }
                                }
                                unset($data['mtas2']);
                            }
                        }
                        $verification_status = $key['accountstatus'] == 1 ? lang('curtra_tbl_02') : lang('curtra_tbl_01');
                        $account_infoAPI =  $this->getAPIAccountDetails($key['account_number']);
                        if($ifInactive['LogIn'] == $key['account_number']){
                            $trading_status  = lang('curtra_tbl_06');
                        } else if(!$account_infoAPI['IsEnable']){
                            $trading_status  = 'Disabled';
                        }else if(!$account_infoAPI['IsReadOnly']){
                            $trading_status  = lang('curtra_tbl_07');
                        }else{
                            $trading_status  = lang('curtra_tbl_09');
                        }





                        switch ($key['mt_account_set_id']) {
                            case 1:
                                $account_type = 'ForexMart Standard';
                                break;
                            case 2:
                                $account_type = 'ForexMart Zero Spread';
                                break;
                            case 4:
                                $account_type = 'ForexMart Micro Account';
                                break;
                            case 5:
                                $account_type = 'ForexMart Classic';
                                break;
                            case 6:
                                $account_type = 'ForexMart Pro';
                                break;
                            case 7:
                                $account_type = 'ForexMart Cents';
                                break;
                            default:
                                $account_type = $key['account_type'];
                        }
                        $ifInactive = ($ifInactive && $key['restored_inactive_account'] == 0) ? true : false;
                        $tabel = array(
                            'account_number'   => $key['account_number'],
                            'trader_password'  => $key['trader_password'],
                            'leverage'         => $key['leverage'],
                            'leverage2'        => $data['leverage'],
                            'nodepositbonus'   => $key['nodepositbonus'],
                            'email'            => $key['email'],
                            'country'          => $key['country'],
                            'mt_currency_base' => $key['mt_currency_base'],
                            'amount'           => $data['balance'],
                            'mt_status'        => $key['mt_status'],
                            'veri_status'      => $verification_status,
                            'trade_status'     => $trading_status,
                            'mt_type'          => $key['mt_type'],
                            'account_type'     => $account_type,
                            'swap_free'        => $key['swap_free'],
                            'inactive'         => $ifInactive,
                        );
                        array_push($acc, $tabel);
                    }
                }//end foreach
                $data['accounts2'] = $acc;
            }//end count
            else{
                $data['accounts2'] = 'No other accounts to be displayed';
                $acc2 = $data['accounts2'];
            }
            return $data['accounts2'];

        } else {
            if ($_GET['login'] == 'partner') {
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }
    public function getAPIAccountDetails($account_number){
        $webservice_config = array('server' => 'live_new');
        $service_account_info = array(  'iLogin' => $account_number  );
//        $AccountWebService = new WebService($webservice_config);
//        $AccountWebService->open_RequestAccountDetails($service_account_info);
                            
        $this->load->library('WSV'); //New web service
        $WSV = new WSV();
        
                            
        $AccountWebService = $WSV->GetAccountDetailsSingle($service_account_info, $webservice_config);
 
   
        
        $APIdetails = false;
        if ($AccountWebService->request_status === 'RET_OK') {
//            $APIdetails = $AccountWebService->get_all_result();
            $APIdetails = $AccountWebService->result;
        }

        return $APIdetails;
    }
    public function getInactivedetails($account_number){
        $webservice_config = array(  'server' => 'live_new'  );
        $webService = new WebService($webservice_config);
        $data = array( 'iLogin' => $account_number );
        $webService->request_inactive_details($data);
        if ($webService->request_status === 'RET_OK') {
            $data = $webService->get_all_result();
        }else{
            $data = false;
        }
        return $data;
    }

    public function index_speed_test() {
        if(!IPLoc::Office()){redirect('index');}

        $this->benchmark->mark('t1');
        //*** This code is for direct access to deposit page upon logging in**/
        if (isset($_SESSION['redirect'])){
            redirect($_SESSION['redirect']);
        }
        //**End **/

        if($this->session->userdata('logged')){
            $this->load->library('IPLoc', null);

            $this->lang->load('myaccount');
            $this->lang->load('registration');

            $user_id = $this->session->userdata('user_id');
            if(sizeof($this->General_model->show('employment_details','user_id',$user_id)->result())<1){
                $data['incomplete_reg'] = true;
            }

            if( $user_id ){
                //set not first login
                $this->benchmark->mark('t2');
                // get balance api
                $getAccountNumber = $this->account_model->getAccountNumber($user_id);
                $this->benchmark->mark('t3');
                if($this->session->userdata('user_id')==102342){
                    $account_info = array(
                        'iLogin' => 115257
                    );
                }else{
                    $account_info = array(
                        'iLogin' => $getAccountNumber['account_number']
                    );
                }

                $webservice_config = array(
                    'server' => 'live_new'
                );
                $WebService = new WebService($webservice_config);
                $WebService->open_RequestAccountBalance($account_info);
                $this->benchmark->mark('t4');
                switch ($WebService->request_status) {
                    case 'RET_OK':
                        $data['balance'] = $this->roundno(floatval($WebService->get_result('Balance')), 2);
                        break;
                    default:
                        $data['balance'] = $this->roundno(floatval(0), 2);
                }

                //AN for account number
                //AN_type account type 0 Demo 1 Live 2 Partner
                if($this->session->userdata('login_type') == 1){
                    // Partnership accounts
                    $this->benchmark->mark('t5');
                    $accounts = $this->partners_model->getPartnersByUserId($user_id);
                    $this->benchmark->mark('t6');
                    $data['p_status'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='accountstatus');
                    $this->benchmark->mark('t7');
                    $cpa_type = $this->general_model->showssingle($table='partnership',$id='partner_id', $field=$user_id,$select='type_of_partnership,reference_num,reference_subnum');
                    $this->benchmark->mark('t8');
                    $data['AN_type']=2;
                    $data['AN'] = $getAccountNumber['account_number'];
                    $data['user_profiles']['country']='';

                    if($cpa_type['type_of_partnership']=='cpa'){
                        $receiving_cpaAcct = $this->general_model->showssingle($table='partnership',$id='reference_subnum', $field=$cpa_type['reference_num'],$select='reference_num');
                        $iLogin = $receiving_cpaAcct['reference_num'];
                    }else{
                        $iLogin = $getAccountNumber['account_number'];
                    }
                    $this->benchmark->mark('t9');
//                    if($this->session->userdata('user_id')==102342 && IPLoc::Office()){ $iLogin = 241800;}
                    $account_info = array( 'iLogin' => $iLogin );

//                    if(IPLoc::Office()){
//                        print_r($account_info);
//                    }
                    $webservice_config = array(  'server' => 'live_new' );
                    $WebService2 = new WebService($webservice_config);
                    $WebService2->ReqAgentStats($account_info);
                    $this->benchmark->mark('t10');
                    $ReqAgentStats = (array)  $WebService2->result;
                    switch ($WebService2->request_status) {
                        case 'RET_OK':
                            $data['user_referrals']  = $ReqAgentStats ["ReferralsCount"];
                            $data['user_commission'] = $ReqAgentStats ["TotalCommission"];
                            break;
                        default:
                            $data['user_referrals']  = 0;
                            $data['user_commission'] = 0;
                    }

//                    if(IPLoc::Office()){
//                        print_r($data['user_referrals']); print_r($iLogin); exit;
//                    }
                    if($cpa_type['type_of_partnership']=='cpa'){
                        $user_id = $this->session->userdata('user_id');
                        $sub_partner = $this->partners_model->getCPAReferenceSub($user_id);
                        if($sub_partner) {
                            $data['cpa'] = $this->partners_model->getCpaClientList($sub_partner['partner_id'], 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($sub_partner['partner_id']);
                        }else{
                            $data['cpa'] = $this->partners_model->getCpaClientList($user_id, 1);
                            $data['no_of_registered_acc']= $this->partners_model->getCpaTotalRegisterAcc($user_id);
                        }
                        $val = 0;
                        foreach ( $data['cpa'] as $d){
                            $val=$val + $d->cpa_amount;
                        }
                        $data['user_commission'] = $val;
                    }
                    $this->benchmark->mark('t11');
                    $WebService3 = new WebService($webservice_config);
                    $WebService3->GetAgentReferralTradeVolume($iLogin);
                    $this->benchmark->mark('t12');
                    switch ($WebService3->get_all_result()['ReqResult']) {
                        case 'RET_OK':
                            $data['totalTradedVolume']  = $WebService3->get_all_result()['TotalVolume'];
                            break;
                        default:
                            $data['totalTradedVolume'] = 0;
                    }
//                    $data['totalTradedVolume'] = $this->getTotalTrade($getAccountNumber['account_number'])['TotalVolume'];
                }else {
                    $this->benchmark->mark('t13');
                    // Live and Demo accounts
                    $accounts = $this->account_model->getAccountsByUserId($user_id);
                    $this->benchmark->mark('t14');
                    $data['users'] = $this->general_model->showssingle($table='users',$id='id', $field=$user_id,$select='type,nodepositbonus');
                    $data['mtas'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='account_number,auto_leverage_change');
                    $data['user_profiles'] = $this->general_model->showssingle($table='user_profiles',$id='user_id', $field=$user_id,$select='country');
                    $this->benchmark->mark('t15');
                    $data['AN_type'] = $data['users']['type']; // 0 demo 1 live
                    $data['AN'] = $getAccountNumber['account_number'];

                    // Back Agent of Client
                    FXPP::BackAgentOfAccount($data['AN']);
                    $this->benchmark->mark('t16');
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
                $this->benchmark->mark('t17');
                $this->load->model('deposit_model');
                $has_50percent_bonus = $this->deposit_model->has50PercentBonusDeposit($user_id);
                if($has_50percent_bonus){
                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,200));
                }else{
                    $this->benchmark->mark('t18');
                    $data['mtas2'] = $this->general_model->showssingle($table='mt_accounts_set',$id='user_id', $field=$user_id,$select='amount,registration_leverage,leverage,amount_conv_api,mt_currency_base,mt_account_set_id');
                    $r_l=intval(substr($data['mtas2']['registration_leverage'] ,2));  // remove "1:" from the leverage
                    $l=intval(substr($data['mtas2']['leverage'],2));  // remove "1:" from the leverage

                    if($data['mtas2']['mt_currency_base']=='USD'){
                        $amount = $data['mtas2']['amount'];
                    }else{
                        $amount  = FXPP::getCurrencyRate($amount=$data['mtas2']['amount'], $from_currency=strtoupper(trim($data['mtas2']['mt_currency_base'])), $to_currency="USD");
                    }
                    if($data['mtas2']['mt_account_set_id']==4){ //micro
                        $amount = ($amount/100);
                    }
                    switch (true) {
                        case $r_l >= 1000:
                            if(floatval($amount)>=1000 and floatval($amount)<3000){
                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,1000));
                            }elseif(floatval($amount)>=3000){
                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                            }else{
                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                                $data['client_autochangelev']=array(
                                    'client_autolevchange_disable'=>0
                                );
                                $this->general_model->updatemy('mt_accounts_set', 'user_id',$_SESSION['user_id'], $data['client_autochangelev']);
                            }
                            break;
                        default:
                            if ($l<1000){
                                if(floatval($amount)>=1000 and floatval($amount)<3000){
                                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,1000));
                                }elseif(floatval($amount)>=3000){
                                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,500));
                                }else{
                                    $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                                    $data['client_autochangelev']=array(
                                        'client_autolevchange_disable'=>0
                                    );
                                    $this->general_model->updatemy('mt_accounts_set', 'user_id',$_SESSION['user_id'], $data['client_autochangelev']);
                                }
                            }else{
                                $data['leverage'] = $this->general_model->selectOptionList($this->general_model->getLeverage(null,5000));
                            }

                    }
                    $this->benchmark->mark('t19');
                    unset($data['mtas2']);
                }
            }
            $this->benchmark->mark('t20');
            $image = $this->user_model->getUserProfileByUserId($user_id)['image'];
            $this->benchmark->mark('t21');
            $this->session->set_userdata(array('image' => $image));
//            if(IPLoc::Office()){
            $data['accounts2'] = $this->getAllAccounts(); $data['micro_test_acc']=$amount;
//            }
            $data['reg_loc'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='registration_location')['registration_location'];
            $this->benchmark->mark('t22');
            $data['title_page'] = lang('sb_li_0');
            $data['active_tab'] = 'accounts';
            $data['active_sub_tab'] = 'accounts';
            $data['acc_status'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='accountstatus');

//            if(IPLoc::Office()){
            $data['show_fx_bonus'] = $this->general_model->showssingle($table='users',$id='id', $field=$this->session->userdata('user_id'),$select='is_showfxbonus');
//            }
            $this->benchmark->mark('t23');

            $i = 1;
            for($i;$i<23; $i++){
                echo "t".$i."--t".($i+1)."  ".$this->benchmark->elapsed_time('t'.$i, 't'.($i+1))."<br>";
            }

            echo $this->benchmark->elapsed_time('t1','t21').'<br>';
            echo $this->benchmark->elapsed_time('t4','t5').'<br>';
            echo $this->benchmark->elapsed_time('t20','t21').'<br>';
            exit();

            $data['login_type'] = $this->session->userdata('login_type');
            $data['metadata_description'] = lang('mya_dsc');
            $data['metadata_keyword'] = lang('mya_kew');
            $this->template->title(lang('mya_tit'))
                ->append_metadata_css('')
                ->append_metadata_js('')
                ->set_layout('internal/main')
                ->build('dashboard', $data);

        }else{
            if($_GET['login'] == 'partner'){
                redirect('partner/signin');
            }
            redirect('signout');
        }
    }

    public function switch_account($account_number=null){

        if ($this->session->userdata('logged')) {

            if( $row = $this->account_model->isLinkAccount($this->session->userdata('email'), $this->session->userdata('full_name'), $this->session->userdata('user_id'),$account_number)){

                $this->session->set_userdata('user_id', $row->id);
                $this->session->set_userdata('administration', $row->administration);
                $this->session->set_userdata('login_type', $row->login_type);
                $this->session->set_userdata('account_number', $row->account_number);
                redirect('my-account');
            }
        }else{
            redirect('signout');
        }
    }

    public function total_lots(){
        // $this->lang->load('total_lots');
        if($this->session->userdata('logged')){
            $data['from'] = date('m-d-Y', strtotime('sunday -1 week', strtotime('tomorrow')));
            // $data['from'] = date('Y-m-d', strtotime('-1 day'));
            $data['to'] = date('m-d-Y', strtotime('now'));
            $data['title_page'] = lang('sb_li_0');
           // $data['active_tab'] = 'accounts';
            $data['active_tab'] = 'trading';
            $data['active_sub_tab'] = 'total-lots';
            $data['metadata_description'] = 'total-lots';
            $data['metadata_keyword'] = 'total-lots';
            $this->template->title('Total lots')
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
                ->build('total_lots',$data);
        }else{
            redirect('signout');
        }
    }

    public function getAccounTotalLots(){
        if(!$this->input->is_ajax_request()){die('Not authorized!');}

        $account =  $_SESSION['account_number'];
        // $account =  58028602;
        $data['from'] = $this->input->post('from',true);
        $data['to'] = $this->input->post('to',true);
        if(empty($data['from'])){
            $data['from'] = date('Y-m-d', strtotime('sunday -1 week', strtotime('tomorrow')));
        }
        if(empty($data['to'])){
            $data['to'] = date('Y-m-d', strtotime('now'));
        }
        
        
        //if(IPLoc::APIUpgradeDevIP()){

            $requestData = array('From' => FXPP::unixTime($data['from']), 'To' => FXPP::unixTime($data['to']. ' 23:59:59'), 'Accounts' => array($account));
            $requestData2 = array('From' => 0, 'To' => FXPP::unixTime(date('Y-m-d 23:59:59', strtotime('now'))), 'Accounts' => array($account));

            $data['totalTradedVolume'] = $this->getAccountsTotalLots($requestData2); // get all account lots
            $data['totalLots'] = $this->getAccountsTotalLots($requestData); // get account lots by date

            echo json_encode($data);
       /* }else{

            $account_info = array(
                'iLogin' => $account,
                'from'        =>  date('Y-m-d\T00:00:00', strtotime($data['from'])),
                'to'        =>  date('Y-m-d\T23:59:59', strtotime($data['to'])),
            );
            $account_info_total = array(
                'iLogin' => $account,
                'from'        =>  date('Y-m-d\T00:00:00', strtotime($data['from'])),
                'to'        =>  date('Y-m-d\T23:59:59', strtotime($data['to'])),
            );

            $data['totalTradedVolume'] = $this->getTotalTradePerMonth($account_info_total)['totalLots'];
            $data['totalLots'] = $this->getTotalTradePerMonth($account_info)['totalLots'];

            echo json_encode($data);

        }*/



    }

    public function getAccountsTotalLots($requestData = array()){
        $this->load->library('WSV');
        $WSV = new WSV();
        $requestResult =  $WSV->GetAccountsTotalTradedLot($requestData);
        $requestStatus = $requestResult['ErrorMessage'];
        $referralLotsData =  $requestResult['Data']->ResultDouble->KeyValuePairOfintdouble;
        $referralLots = array();
        $totalLots = 0;

        foreach($referralLotsData as $k => $v){
            $totalLots += $v->value;
        }


        return $totalLots;




    }

    public function monthlyLots(){
//        $account_info = array(
//            'iLogin' => 58027931,
//            'from'        =>  date('Y-m-d\T00:00:00', strtotime('09/22/2019')),
//            'to'        =>  date('Y-m-d\T23:59:59', strtotime('11/22/2019')),
//        );
//
//        echo '<pre>';
//
//
//        $data['totalLots'] = 0;
//        $webservice_config = array('server' => 'live_new');
//        $WebService = new WebService($webservice_config);
//
//        $WebService->Open_GetMonthlyLots($account_info);
//
//        switch($WebService->request_status){
//            case 'RET_OK':
//                $lostArray = $WebService->get_result('Lots');
//                foreach ($lostArray->KeyValuePairOfdateTimedouble as $key => $val){
//                    $data['totalLots'] += $val->value;
//                }
//                break;
//
//        }
//
//        var_dump( $data['totalLots']);


//        $account_info = array( 'iLogin' =>  '58033707');
//
//
//
//        $webservice_config = array(  'server' => 'live_new' );
//        $WebService2 = new WebService($webservice_config);
//        $WebService2->ReqAgentStats($account_info);
//        $ReqAgentStats = (array)  $WebService2->result;
//        var_dump($ReqAgentStats);

        // $res = $this->getAPIAccountDetails(212690);
        // $trading_status =  ($this->getAPIAccountDetails(212690)['IsReadOnly']) == false ? 'Active' : 'Read-Only';
        //  var_dump($trading_status);

        $accounts = $this->account_model->getAccountsByUserId(135835);

        foreach( $accounts as $key => $value ){

            $verification_status = $value['accountstatus'] == 1 ? 'Verified' : 'Not Verified';
            $trading_status =  $this->getAPIAccountDetails(212690)['IsReadOnly'] == false ? lang('curtra_tbl_07') : lang('curtra_tbl_09');
            $accounts[$key]['veri_status'] = $verification_status;
            $accounts[$key]['trade_status'] = $trading_status;
            if($accountType = FXPP::fmGroupType(212690)){
                $accounts[$key]['account_type'] = $accountType;
            }else{
                $accounts[$key]['account_type'] = $this->general_model->getAccountType( $value['mt_account_set_id'] );
            }
        }
        echo '<pre>';
        var_dump($accounts);
    }

    /*NEW API FXPP-11977 , FXPP-11978 , FXPP-11979*/

    public function NewGetOpenTrades(){
        $this->lang->load('currenttrades');
        if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
            $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
            if($this->session->userdata('logged')){

                $data['title_page'] = lang('sb_li_0');
                $data['active_tab'] = 'accounts';
                $data['active_sub_tab'] = 'current-trades';
                $data['active_sub_sub_tab'] = 'current_trades';

                $data['metadata_description'] = lang('curtra_dsc');
                $data['metadata_keyword'] = lang('curtra_kew');
                $this->template->title("ForexMart | Current Trades")
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
    public function NewGetHistoryTrades(){
        if( //$_SESSION['user_id']==356895 || $_SESSION['account_number']=='58027933' ||
                $_SERVER['REMOTE_ADDR']=='49.12.5.139') {
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
                       <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                       <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                 ")
                    ->set_layout('internal/main')
                    ->build('new_history_of_trades',$data);
            }else{
                redirect('signout');
            }

        }
    }
	
    public function getTransactionHistoryRecords(){
        if ($this->input->is_ajax_request()) {

            ini_set("soap.wsdl_cache_enabled", "0");

            $this->load->library('WSV');		
			
            $tradeType = $_POST['recordType'];
            $rowPerPage = $_POST['length'];
            $hasError = false;
            $errorMsg = "";
            $page = is_numeric($_POST['page']) ? $_POST['page'] : 1;
            $WSV = new WSV();
            $args = array(
                'AccountNumber' => $_SESSION['account_number'],
                'isCPA' => $this->isCPA,
                'Limit' => $rowPerPage,
                'Offset' => $_POST['start'],
                'recType' => 'transaction-history',
            );

            if($_POST['recType']=='commission'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
                $rowPerPage = $_POST['length'];
                $args['Limit'] = $rowPerPage;
                $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
                $args['Offset'] = $_POST['length'];
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

            }else{
                $x = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $WSV->GetTradeHistory($args)['Data']: array() ;
                $res['count'] = isset($x->DataCount) ? $x->DataCount : 0;
                $res['record'] = isset($x->Transactions) ? $x->Transactions : '';
                $hasError = ( $WSV->GetTradeHistory($args)['ErrorMessage']=='RET_OK') ? $hasError : true;
                $errorMsg = ( $WSV->GetTradeHistory($args)['ErrorMessage']!='RET_OK') ? $x['ErrorMessage'] : $errorMsg;
            }


          //  $result = $this->populate($res, $args);
		$type = $tradeType;
		$records = $res['record'];
        $rowNum = $args['Offset'];
        $count = isset( $res['count'] )?  $res['count']: 0;

		$tbl = '';
        $ctr = intval($rowNum) + 1;
       
        $transaction_history=array();
        
        if($type=='commission'){
            if($count>1){
                foreach ($records->TradeRecord as $a){
					$tempArray = array(
						'DT_RowId' => $ctr,
						$ctr,
						gmdate("Y-m-d H:i:s", $a->CloseTime),
						$a->CommissionAgent,
						$a->Login,
						$a->Symbol,
						$a->Order,
					);
                    $ctr++;
					
                }
            }
        }else if($type=='current-trades' || $type=='history-of-trades'){

            if($count>1){
                foreach ($records->TradeRecord as $a){

                    $data['volume'] = (floatval($a->Volume)!=0 )?(floatval($a->Volume)/100) : floatval($a->Volume);

						$tempArray = array(
							'DT_RowId' => $ctr,
							$ctr,
							$a->Order,
							$this->getTradeType($a->Cmd),
							number_format(($a->Volume),2),
							$a->Symbol,
							$a->OpenPrice,
							$a->ClosePrice,
							gmdate("Y-m-d H:i:s", $a->OpenTime),
							gmdate("Y-m-d H:i:s", $a->CloseTime),
							$a->Sl,
							$a->Tp,
							$a->Profit,
						);

                    $ctr++;
                }
            }

        }else {
            if ($count > 1) {
                $pendingTrans = 0;
                
                
//                if(IPLoc::frz()){
//                   echo "<pre>"; print_r($records->FinanceOpData);exit;
//                }
                
                foreach ($records->FinanceOpData as $a) {
                    $d = $this->getFundStatusPerOperationType($a->OperationTypeId);
                    $dt = $this->getBalOpsDetails($a);
                    if($type=='balance-operations'){
						$tempArray = array(
							'DT_RowId' => $ctr,
							$ctr,
							$a->Ticket,
							$d['FundType'],
							$d['TransType'],
							$a->Amount,
							$d['Status'],
							gmdate("Y-m-d H:i:s", $a->ProcessTime),
							$d['Description'],
						);
                    }else if($type=='transaction-history'){

                        $status = $d['Status'];

                        if(IPLoc::StatusTask()){
                            $status = FXPP::TransactionStatus($a->IsAccepted);
                        }
                        
                        

						$tempArray = array(
							'DT_RowId' => $ctr,
							$ctr,
							$d['FundType'],
                            $status,
							$d['TransType'],
							$a->Amount,
							gmdate("Y-m-d H:i:s", $a->ProcessTime),
							"<button   id='btn-view-" . $a->Ticket . "' data-info='".$dt."' class='btn-view-trans-details' type='button'>  View Details</button>",
						);
                   // $data[] = $tempArray;
			
                    $transaction_history[]=$tempArray;
                    
                    
                    
                    
                    
                    
                    
                    }else if($type=='pending-transactions'){
                        
                        
                        
                        if($a->OperationTypeId == "WITHDRAW_REAL_FUND"){
                            
                                                        
                           //FXPP-12929
                            if($this->checkPendingTranSection($a->Ticket,$a->Comment))
                            {
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
                                    $pendingTrans++;
                            }
                            
                        }
                    }

                    $ctr++;
                }
                
                
                if($type=='pending-transactions'){
                    return $res = array('tbl'=> ($pendingTrans>0)?$tbl:'<tr><td colspan="7">'.lang('dta_tbl_01').'</td></tr>' , 'countPending'=> $pendingTrans);
                }               
                
            } 
        }


        
        
        if($_POST['recordType']=="transaction-history")
        {
           $data=$transaction_history;
            
        }
                        
        

            $result = array(
                 'recordType'=>$_POST['recordType'],   
                'draw' => (int)$this->input->post('draw',true),
                'recordsTotal' => (int)$res['count'],
                'recordsFiltered' => (int)$res['count'],
                'data' => $data
            );

                        
                echo json_encode($result);	
                        
            
            
        }
    }
	
	
    public function getTrades(){
        if ($this->input->is_ajax_request()) {

            ini_set("soap.wsdl_cache_enabled", "0");
//            $this->load->library('SVC');
            $this->load->library('WSV');
            $tradeType = $_POST['recType'];
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
                'Offset' => $page,
                'recType' => $tradeType,
            );

            if($_POST['recType']=='commission'){
                $dateFr = $_POST['from'];
                $dateT = $_POST['to'];
                $dateFrom = FXPP::unixTime($dateFr.' 00:00:00');
                $dateTo =  FXPP::unixTime($dateT.' 23:59:59');
                $args['From'] = $dateFrom;
                $args['To'] = $dateTo;
                $rowPerPage = $_POST['rowNum'];
                $args['Limit'] = $rowPerPage;
                $page = ($_POST['page'] != 0) ? ( ($_POST['page'] - 1) * $rowPerPage ) : $_POST['page'];
                $args['Offset'] =$page;
            }
            if($_POST['recType']=='history-of-trades'){


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




            $result = $this->populate($res, $args);
           


            if(IPLoc::IPOnlyForTq()){
//                echo "<pre>";
//                print_r($x->Transactions); exit();
//                print_r($result); exit();

            }






            $dataResult['result'] = $result;
            $dataResult['hasError'] = $hasError;
            $dataResult['errorMsg'] = $errorMsg;
            $this->output->set_content_type('application/json')
                ->set_output(json_encode( $dataResult ));
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
        $config['page'] = $rowNum;

        $config['num_links'] = 20;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open']    = '<ul class="tab-pagination pagination pagination-md">';
        $config['full_tag_close']   = '</ul>';

        $config['first_link']       = 'first';
        $config['first_tag_open']   = '<li class="latest-page">';
        $config['first_tag_close']  = '</li>';

        $config['last_link']        = 'last';
        $config['last_tag_open']    = '<li class="latest-page">';
        $config['last_tag_close']   = '</li>';

        $config['next_link']        = 'next';
        $config['next_tag_open']    = '<li class="latest-page paginate-next">';
        $config['next_tag_close']   = '</li>';

        $config['prev_link']        = 'prev';
        $config['prev_tag_open']    = '<li class="latest-page">';
        $config['prev_tag_close']   = '</li>';

        $config['cur_tag_open']     = '<li class="latest-page active"><a id="curPage" class="first" data-ci-pagination-page="1">';
        $config['cur_tag_close']    = '</a></li>';

        $config['num_tag_open']     = '<li class="latest-page">';
        $config['num_tag_close']    = '</li>';

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

                    
                         if($type=='current-trades'){
                       
                             $tbl .= "<tr>";
                                $tbl .= "<td>".$ctr."</td>";
                                $tbl .= "<td>".$a->Order."</td>";
                                $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->OpenTime) ."</td>"; 
                                $tbl .= "<td>".$this->getTradeType($a->Cmd)."</td>";
        //                        $tbl .= "<td>".$data['volume']."</td>";
                                $tbl .= "<td>".number_format(($a->Volume),2)."</td>";                                
                                $tbl .= "<td>".$a->Symbol."</td>";                                
                                $tbl .= "<td>".$a->OpenPrice."</td>";
                                 $tbl .= "<td>".$a->Sl."</t>";
                                $tbl .= "<td>".$a->Tp."</tdd>";                                
                                $tbl .= "<td>".$a->ClosePrice."</td>";
                                
                              //  $tbl .= "<td>".gmdate("Y-m-d H:i:s", $a->CloseTime) ."</td>";                                
                                $tbl .= "<td>".$a->Profit."</td>"; 
                             $tbl .= "</tr>";
                             
                        }else{
                    
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
                        
                        }
                        

                    $ctr++;
                }
            }else{
                
                if($type=='current-trades'){
                $tbl .= '<tr><td colspan="11">'.lang('dta_tbl_01').'</td></tr>';
                }else{
                    $tbl .= '<tr><td colspan="12">'.lang('dta_tbl_01').'</td></tr>';
                }
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
                                    Ticket: ".$a->Ticket."<br><br>
                                    Comment: ".$a->Comment."<br><br>
                                    Payment System: ".$pSystem."<br>
                                    </p>";
                break;
            case 'Withdraw':
                $pSystem = isset($pSystem)? $pSystem : "N/A";
                $recall = isset($recall)? $recall : "";
                $stat = isset($stat)? $stat : "N/A";
                $comment = (!empty($a->Comment))? $comment : "N/A";
                $details = "<p>
                                    Ticket: ".$a->Ticket."<br><br>
                                    Comment: ".$comment."<br><br>
                                    Payment System: ".$pSystem."<br><br>
                                    Status: ".$stat."<br><br>
                                    Recall: ".$recall."<br>
                                    </p>";
                break;
            case 'Transfer':
                $details = "<p>
                                    Ticket: ".$a->Ticket."<br><br>
                                    Comment: ".$a->Comment."<br><br>
                                    Transfer From: ".$a->TransferAccountSender."<br><br>
                                    Transfer To: ".$a->TransferAccountReceiver."<br>
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
	
    public function removeAccount(){
		$this->load->model('user_model');
		$account_number = $this->input->post('account_number',true);
		
        $this->general_model->updateRemoveAccount('mt_accounts_set', $account_number);
		
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
