<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * Tank_auth
 *
 * Authentication library for Code Igniter.
 *
 * @package		Tank_auth
 * @author		Ilya Konyukhov (http://konyukhov.com/soft/)
 * @version		1.0.9
 * @based on	DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 * @license		MIT License Copyright (c) 2008 Erick Hartanto
 */
class Tank_auth
{
	private $error = array();

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->config('tank_auth', TRUE);

		$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('tank_auth/users');

		// Try to autologin
		$this->autologin();
	}

	protected function TwoFactorAuthentication($userID, $username, $password){
		$this->ci->load->library('session');
		if( ! $this->ci->session->userdata('TFA') ){
			$this->ci->load->model('account_model');
			//set default TFA session
			$this->ci->session->set_userdata('TFA', 0);

			$TFASettings = $this->ci->account_model->GetTFASettings($userID);

			if( ! $TFASettings ){
				return;
			}

			if( ! $TFASettings['isEnabled'] ){
				return;
			}

			$this->ci->session->set_userdata('TFA', $TFASettings['isEnabled']);
			$this->ci->session->set_userdata('TFASecret', $TFASettings['SecretKey']);
			$this->ci->session->set_userdata('RequireTFALogin', 'ON');

			$credentials = array(
				'username'  => $username,
				'password'  => $password
			);

			$this->ci->session->set_userdata('TFACredentials', json_encode($credentials));

			header('Location: '.FXPP::my_url('two-step-authentication'));exit;
		}else{
			//Check if TFA is enabled
			if($this->ci->session->userdata('TFA') == 1){

				if($this->ci->session->userdata('RequireTFALogin') == 'ON'){
					header('Location: '.FXPP::my_url('two-step-authentication'));exit;
				}else{

					$this->ci->session->unset_userdata('TFACredentials');
					$this->ci->session->unset_userdata('TFASecret');
					$this->ci->session->unset_userdata('TFA');
				}

			}
		}

	}

	/**
	 * Login user on the site. Return TRUE if login is successful
	 * (user exists and activated, password is correct), otherwise FALSE.
	 *
	 * @param	string	(username or email or both depending on settings in config file)
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function login($login, $password, $remember, $login_by_username, $login_by_email,$admin,$login_type = 0)
	{



		if ((strlen($login) > 0) AND (strlen($password) > 0)) {

			// Which function to use to login (based on config)
			if ($login_by_username AND $login_by_email) {
				$get_user_func = 'get_user_by_login';
			} else if ($login_by_username) {
				$get_user_func = 'get_user_by_username';
			} else {
				$get_user_func = 'get_user_by_email';
			}

			if (!is_null($users = $this->ci->users->$get_user_func($login,$admin,$login_type))) {	// login ok

				// Does password match hash in database?

				$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));

				foreach($users as $user){


					if ($hasher->CheckPassword($password, $user->password)) {		// password ok

						//**  Two Factor Authentication **/
						if(IPLoc::Office()){
							$this->ci->session->set_userdata('AccountType', $login_type);
							$this->ci->load->library('TFA');
							$this->ci->tfa->TFAProcess($user->id, $login, $password);
						}
						//**  END Two Factor Authentication **/

						//Redirect two step authentication
						$this->TwoFactorAuthentication($user->id, $login, $password);

						$accTable= $this->ci->users->get_user_account_number('mt_accounts_set','user_id',$user->id);
						$account_number=$accTable->account_number;
						if(empty($account_number) or $account_number=="")
						{
							$accTable= $this->ci->users->get_user_account_number('partnership','partner_id',$user->id);
							$account_number=$accTable->reference_num;
						}

						///  echo $account_number;exit;

						$data['apiGetAccDet']=array();
						$webservice_config = array('iLogin'=>$account_number,'server' => 'live_new');
						$WebService = new WebService($webservice_config);
						$WebService->RequestAccountDetails($webservice_config);

						if($WebService->request_status === "RET_OK"){

							$totalAccount = (array) $WebService->get_all_result();//('AccountData');

							$IsEnable=$totalAccount['IsEnable'];

							if($IsEnable==1 or $IsEnable==true)
							{

								$users_profile = $this->ci->users->get_user_by_userid($user->id);        // fail - banned
								if($user->banned == 1)
								{
									$this->error = array('banned' => $user->ban_reason);
								}
								else if($users_profile->sms_security==1){
									$this->ci->session->set_userdata(array(
										'full_name'  => $users_profile->full_name,
										'user_id'	=> $user->id,
										'username'	=> $user->username,
										'email'     =>$user->email,
										/*'logged_in'	=> TRUE,
                                        'logged' => 1,
                                        'status'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                                        'administration'	=> $user->administration,*/
										'login_type' => $login_type,
									));
									$sms_code = mt_rand(100000,999999);  //
									$security_code = array('id'=>$user->id,'sms_code'=>$sms_code);

									if($this->ci->general_model->updatemy('users','id',$user->id,$security_code)){
										redirect('sms_security/sendSms');
									} else{
										redirect('logout');
									}


								} else {

									$this->ci->session->set_userdata(array(
										'full_name'  => $users_profile->full_name,
										'user_id'	=> $user->id,
										'username'	=> $user->username,
										'email'     =>$user->email,
										'logged_in'	=> TRUE,
										'logged' => 1,
										'status'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
										'administration'	=> $user->administration,
										'login_type' => $login_type,
										'verified' => $user->accountstatus
									));

									if ($user->activated == 0) {							// fail - not activated
										$this->error = array('not_activated' => '');

									} else {												// success
										if ($remember) {
											$this->create_autologin($user->id);
										}

										$this->clear_login_attempts($login);

										$this->ci->users->update_login_info(
											$user->id,
											$this->ci->config->item('login_record_ip', 'tank_auth'),
											$this->ci->config->item('login_record_time', 'tank_auth'));
										return TRUE;
									}
								}

							}
							else
							{


//							   $this->ci->load->library('IPLoc');
//                                    if(IPLoc::IPCrpAccVerify()){
//                                       $active_status= $this->restore_inactive_account($account_number);
//                                        if($active_status == true){
//                                            return true;
//                                        }else{
//                                            $this->increase_login_attempt($login);
//                                            $this->error = array('password' => 'auth_account_blocked');
//                                            return false;
//                                        }
//
//                                    }
                                        $this->increase_login_attempt($login);
                                        $this->error = array('password' => 'auth_account_blocked');
                                        return false;


							}
						}
						else
						{

						    // fail - wrong password
							$this->increase_login_attempt($login);
							$this->error = array('password' => 'auth_account_deactivated');
							return false;
						}

					} else {														// fail - wrong password
						$this->increase_login_attempt($login);
						$this->error = array('password' => 'auth_incorrect_password');
					}

				}
			} else {															// fail - wrong login
				$this->increase_login_attempt($login);
				$this->error = array('username' => 'auth_incorrect_login ');

			}
		}
		return FALSE;
	}

	/**
	 * Logout user from the site
	 *
	 * @return	void
	 */
	 private function restore_inactive_account($account_number)
    {


            $account_number = $this->input->post('account_number',true);

            $webservice_config = array('server' => 'live_new');
//            $WebService2 = new WebService($webservice_config);
            $account_info2 = array(
                'iLogin' =>  $account_number
            );
//            $WebService2->open_RequestAccountDetails($account_info2);

            $CI =& get_instance();
            $CI->load->library('WSV'); //New web service

            $accounts = array(
                $account_number,                           //requested account
                $CI->session->userdata('account_number')   //logged in account
            );

            $WebService2 = $CI->wsv->GetAccountDetails($accounts, $webservice_config);

             if( $WebService2['ErrorMessage'] === 'RET_OK' ) {
                 //  $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => 0 )));
                 return true;
             }

//            if( $WebService2->request_status === 'RET_OK' ) {
//              //  $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => 0 )));
//                return true;
//            }
        else{
            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $account_info = array(
                'iLogin' => $account_number
            );
            $this->ci->load->model('account_model');
            $account = $this->ci->account_model->getAccountsByAccountNumber_minibonus($account_number);
            $WebService->open_RestoreInactiveAccount($account_info);
            if ($WebService->request_status === 'RET_OK') {
                /*admin_log*/
                $this->ci->load->model('Adminslogs_model');
                $arr = array(
                    'Restore_Inactive_Account' => 'restored',
                    'Manager_IP' => $this->ci->input->ip_address(),
                );

                //$page = 'manage-accounts/credit-mini-bonus';
                $page = FXPP::loc_url('credit-mini-bonus');
                $data['log'] = array(
                    'users_id' => $_SESSION['user_id'],
                    'page' => $page,
                    'date_processed' => FXPP::getCurrentDateTime(),
                    'processed_users_id' => $account['user_id'],
                    'data' => json_encode($arr),
                    'processed_users_id_accountnumber' => $account_number,
                    'comment' => '',
                    'admin_fullname' => $_SESSION['full_name'],
                    'admin_email' => $_SESSION['email'],
                );

                $this->ci->Adminslogs_model->insertmy($table = "admin_log", $data['log']);
                /*admin_log*/

                $this->ci->load->model('general_model');
                $this->ci->general_model->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id = $account_number, $data = array('restored_inactive_account' => 1));
                return true;
            }else{
                return false;
            }
        }

    }
    
    function updateSpecialSession(){
        
      //   $this->ci->load->model('general_model');                 
         $this->ci->general_model->upDateSpecailSessionData($this->ci->input->ip_address(),$_SESSION['email']);
          return true;
    }
	function logout()
	{
		 $this->delete_autologin();
		// See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
		$this->ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));
                $this->ci->session->sess_destroy();
                 
	}

	/**
	 * Check if user logged in. Also test if user is activated or not.
	 *
	 * @param	bool
	 * @return	bool
	 */
	function is_logged_in($activated = TRUE)
	{
		return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
	}

	/**
	 * Get user_id
	 *
	 * @return	string
	 */
	function get_user_id()
	{
		return $this->ci->session->userdata('user_id');
	}

	/**
	 * Get username
	 *
	 * @return	string
	 */
	function get_username()
	{
		return $this->ci->session->userdata('username');
	}

	/**
	 * Create new user on the site and return some data about it:
	 * user_id, username, password, email, new_email_key (if any).
	 *
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	array
	 */
	function create_user($username, $email, $password, $email_activation,$type=0, $login_type, $phonePassword = null)
	{
		if ((strlen($username) > 0) AND !$this->ci->users->is_username_available($username)) {
			$this->error = array('username' => 'auth_username_in_use');

			/*} elseif (!$this->ci->users->is_email_available($email)) {
                $this->error = array('email' => 'auth_email_in_use');*/

		} else {
			// Hash password using phpass
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);

			$phonePasswordHash = $hasher->HashPassword($phonePassword);

			$data = array(
				'username'	=> $username,
				'password'	=> $hashed_password,
				'email'		=> $email,
				'last_ip'	=> $this->ci->input->ip_address(),
				'type'      => $type,
				'login_type' => $login_type,
				'phone_password' => $phonePasswordHash
			);

            $ip = $this->is_test_account($this->ci->input->ip_address());

            if ($ip) {
                $data['test'] = 1;
                $data['test_1'] = 0;
            } else {
                $data['test'] = 0;
                $data['test_1'] = 1;
            }

			if ($email_activation) {
				$data['new_email_key'] = md5(rand().microtime());
			}
			if (!is_null($res = $this->ci->users->create_user($data, !$email_activation))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}
		}
		return NULL;
	}

	function create_user_google($username, $email, $password, $email_activation,$type=0, $login_type, $phonePassword = null)
	{
		if ((strlen($username) > 0) AND !$this->ci->users->is_username_available($username)) {
			$this->error = array('username' => 'auth_username_in_use');

			/*} elseif (!$this->ci->users->is_email_available($email)) {
                $this->error = array('email' => 'auth_email_in_use');*/

		} else {
			// Hash password using phpass
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			$hashed_password = $hasher->HashPassword($password);

			$phonePasswordHash = $hasher->HashPassword($phonePassword);

			$data = array(
				'username'	=> $username,
				'password'	=> $hashed_password,
				'email'		=> $email,
				'last_ip'	=> $this->ci->input->ip_address(),
				'type'      => $type,
				'login_type' => $login_type,
				'phone_password' => $phonePasswordHash
			);

            $ip = $this->is_test_account($this->ci->input->ip_address());

            if ($ip) {
                $data['test'] = 1;
                $data['test_1'] = 0;
            } else {
                $data['test'] = 0;
                $data['test_1'] = 1;
            }

			if ($email_activation) {
				$data['new_email_key'] = md5(rand().microtime());
			}
			if (!is_null($res = $this->ci->users->create_user($data, !$email_activation))) {
				$data['user_id'] = $res['user_id'];
				$data['password'] = $password;
				unset($data['last_ip']);
				return $data;
			}
		}
		return NULL;
	}



	/**
	 * Check if username available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_username_available($username)
	{
		return ((strlen($username) > 0) AND $this->ci->users->is_username_available($username));
	}

	/**
	 * Check if email available for registering.
	 * Can be called for instant form validation.
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_email_available($email)
	{
		return ((strlen($email) > 0) AND $this->ci->users->is_email_available($email));
	}

	/**
	 * Change email for activation and return some data about user:
	 * user_id, username, email, new_email_key.
	 * Can be called for not activated users only.
	 *
	 * @param	string
	 * @return	array
	 */
	function change_email($email)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, FALSE))) {

			$data = array(
				'user_id'	=> $user_id,
				'username'	=> $user->username,
				'email'		=> $email,
			);
			if (strtolower($user->email) == strtolower($email)) {		// leave activation key as is
				$data['new_email_key'] = $user->new_email_key;
				return $data;

			} elseif ($this->ci->users->is_email_available($email)) {
				$data['new_email_key'] = md5(rand().microtime());
				$this->ci->users->set_new_email($user_id, $email, $data['new_email_key'], FALSE);
				return $data;

			} else {
				$this->error = array('email' => 'auth_email_in_use');
			}
		}
		return NULL;
	}

	/**
	 * Activate user using given key
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function activate_user($user_id, $activation_key, $activate_by_email = TRUE)
	{
		$this->ci->users->purge_na($this->ci->config->item('email_activation_expire', 'tank_auth'));

		if ((strlen($user_id) > 0) AND (strlen($activation_key) > 0)) {
			return $this->ci->users->activate_user($user_id, $activation_key, $activate_by_email);
		}
		return FALSE;
	}

	/**
	 * Set new password key for user and return some data about user:
	 * user_id, username, email, new_pass_key.
	 * The password key can be used to verify user when resetting his/her password.
	 *
	 * @param	string
	 * @return	array
	 */
	function forgot_password($login)
	{
		if (strlen($login) > 0) {
			if (!is_null($user = $this->ci->users->get_user_by_login($login))) {

				$data = array(
					'user_id'		=> $user->id,
					'username'		=> $user->username,
					'email'			=> $user->email,
					'new_pass_key'	=> md5(rand().microtime()),
				);

				$this->ci->users->set_password_key($user->id, $data['new_pass_key']);
				return $data;

			} else {
				$this->error = array('login' => 'auth_incorrect_email_or_username');
			}
		}
		return NULL;
	}

	/**
	 * Check if given password key is valid and user is authenticated.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function can_reset_password($user_id, $new_pass_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0)) {
			return $this->ci->users->can_reset_password(
				$user_id,
				$new_pass_key,
				$this->ci->config->item('forgot_password_expire', 'tank_auth'));
		}
		return FALSE;
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user)
	 * and return some data about it: user_id, username, new_password, email.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function reset_password($user_id, $new_pass_key, $new_password)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_pass_key) > 0) AND (strlen($new_password) > 0)) {

			if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

				// Hash password using phpass
				$hasher = new PasswordHash(
					$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
					$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
				$hashed_password = $hasher->HashPassword($new_password);

				if ($this->ci->users->reset_password(
					$user_id,
					$hashed_password,
					$new_pass_key,
					$this->ci->config->item('forgot_password_expire', 'tank_auth'))) {	// success

					// Clear all user's autologins
					$this->ci->load->model('tank_auth/user_autologin');
					$this->ci->user_autologin->clear($user->id);

					return array(
						'user_id'		=> $user_id,
						'username'		=> $user->username,
						'email'			=> $user->email,
						'new_password'	=> $new_password,
					);
				}
			}
		}
		return NULL;
	}

	/**
	 * Change user password (only when user is logged in)
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function change_password($old_pass, $new_pass)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if old password correct
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($old_pass, $user->password)) {			// success

				// Hash new password using phpass
				$hashed_password = $hasher->HashPassword($new_pass);

				// Replace old password with new one
				$this->ci->users->change_password($user_id, $hashed_password);
//                    echo $new_pass . ' -> ' . $user_id . '->' . $hashed_password;
//                    return true;
//                }else {
				return TRUE;
//                }

			} else {															// fail
				$this->error = array('old_password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}

	/**
	 * Change user email (only when user is logged in) and return some data about user:
	 * user_id, username, new_email, new_email_key.
	 * The new email cannot be used for login or notification before it is activated.
	 *
	 * @param	string
	 * @param	string
	 * @return	array
	 */
	function set_new_email($new_email, $password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$data = array(
					'user_id'	=> $user_id,
					'username'	=> $user->username,
					'new_email'	=> $new_email,
				);

				if ($user->email == $new_email) {
					$this->error = array('email' => 'auth_current_email');

				} elseif ($user->new_email == $new_email) {		// leave email key as is
					$data['new_email_key'] = $user->new_email_key;
					return $data;

				} elseif ($this->ci->users->is_email_available($new_email)) {
					$data['new_email_key'] = md5(rand().microtime());
					$this->ci->users->set_new_email($user_id, $new_email, $data['new_email_key'], TRUE);
					return $data;

				} else {
					$this->error = array('email' => 'auth_email_in_use');
				}
			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return NULL;
	}

	/**
	 * Activate new email, if email activation key is valid.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function activate_new_email($user_id, $new_email_key)
	{
		if ((strlen($user_id) > 0) AND (strlen($new_email_key) > 0)) {
			return $this->ci->users->activate_new_email(
				$user_id,
				$new_email_key);
		}
		return FALSE;
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @param	string
	 * @return	bool
	 */
	function delete_user($password)
	{
		$user_id = $this->ci->session->userdata('user_id');

		if (!is_null($user = $this->ci->users->get_user_by_id($user_id, TRUE))) {

			// Check if password correct
			$hasher = new PasswordHash(
				$this->ci->config->item('phpass_hash_strength', 'tank_auth'),
				$this->ci->config->item('phpass_hash_portable', 'tank_auth'));
			if ($hasher->CheckPassword($password, $user->password)) {			// success

				$this->ci->users->delete_user($user_id);
				$this->logout();
				return TRUE;

			} else {															// fail
				$this->error = array('password' => 'auth_incorrect_password');
			}
		}
		return FALSE;
	}

	/**
	 * Get error message.
	 * Can be invoked after any failed operation such as login or register.
	 *
	 * @return	string
	 */
	function get_error_message()
	{
		return $this->error;
	}
	
	
	
	
	
	
	
	 
	function setAutologin($user_id)
	{
		 
		 $raw_cookie_name=$this->ci->config->item('autologin_cookie_name', 'tank_auth');		 
		 $cookie_name="forexmart_".$raw_cookie_name;
		 
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($cookie_name))), 0, 16);

		$this->ci->load->model('tank_auth/user_autologin');
		$this->ci->user_autologin->purge($user_id);

		if ($this->ci->user_autologin->set($user_id, md5($key)))
		{
			 				
			set_cookie(array(
				'name' 		=>$raw_cookie_name,
				'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
				'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
			));
			return TRUE;
		}
		return false;
		 
	
		 
	}


	function getAutologin()
	{
		
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {			// not logged in (as any user)
		 
	    $raw_cookie_name=$this->ci->config->item('autologin_cookie_name', 'tank_auth');		 
		 $cookie_name="forexmart_".$raw_cookie_name;
	 
	 
			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($cookie_name, TRUE)) {

				$data = unserialize($cookie);
 

				if (isset($data['key']) AND isset($data['user_id'])) {

					$this->ci->load->model('tank_auth/user_autologin');
					if(!is_null($user =  $this->ci->users->get_user_by_id($data['user_id'],1)))
					{ 
							   $users_profile = $this->ci->users->get_user_by_userid($data['user_id']);  

								$this->ci->session->set_userdata(array(
										'full_name'  => $users_profile->full_name,
										'user_id'	=> $user->id,
										'username'	=> $user->username,
										'email'     =>$user->email,
										'logged_in'	=> TRUE,
										'logged' => 1,
										'status'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
										'administration'	=> $user->administration,
										'login_type' => $login_type,
										'verified' => $user->accountstatus
									));

 

						// Renew users cookie to prevent it from expiring
						set_cookie(array(
							'name' 		=> $raw_cookie_name,
							'value'		=> $cookie,
							'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
						));

						$this->ci->users->update_login_info(
							$user->id,
							$this->ci->config->item('login_record_ip', 'tank_auth'),
							$this->ci->config->item('login_record_time', 'tank_auth'));
						return TRUE;
					}
				}
			} 
		}
		return FALSE;
		
		
	}	
	 
	
	
	

	/**
	 * Save data for user's autologin
	 *
	 * @param	int
	 * @return	bool
	 */
	private function create_autologin($user_id)
	{
		$this->ci->load->helper('cookie');
		$key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);

		$this->ci->load->model('tank_auth/user_autologin');
		$this->ci->user_autologin->purge($user_id);

		if ($this->ci->user_autologin->set($user_id, md5($key))) {
			set_cookie(array(
				'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
				'value'		=> serialize(array('user_id' => $user_id, 'key' => $key)),
				'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
			));
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Clear user's autologin data
	 *
	 * @return	void
	 */
	private function delete_autologin()
	{
		$this->ci->load->helper('cookie');
		if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

                    $data = unserialize($cookie);
                      
			$this->ci->load->model('tank_auth/user_autologin');
			$this->ci->user_autologin->delete($data['user_id'], md5($data['key']));
                      			
                      delete_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'));
                       

		}
	}

	/**
	 * Login user automatically if he/she provides correct autologin verification
	 *
	 * @return	void
	 */
	private function autologin()
	{
		if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {			// not logged in (as any user)

			$this->ci->load->helper('cookie');
			if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

				$data = unserialize($cookie);

				if (isset($data['key']) AND isset($data['user_id'])) {

					$this->ci->load->model('tank_auth/user_autologin');
					if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

						// Login user
						$this->ci->session->set_userdata(array(
							'user_id'	=> $user->id,
							'username'	=> $user->username,
							'status'	=> STATUS_ACTIVATED,
						));

						// Renew users cookie to prevent it from expiring
						set_cookie(array(
							'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
							'value'		=> $cookie,
							'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
						));

						$this->ci->users->update_login_info(
							$user->id,
							$this->ci->config->item('login_record_ip', 'tank_auth'),
							$this->ci->config->item('login_record_time', 'tank_auth'));
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}

	/**
	 * Check if login attempts exceeded max login attempts (specified in config)
	 *
	 * @param	string
	 * @return	bool
	 */
	function is_max_login_attempts_exceeded($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('tank_auth/login_attempts');
			return $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login)
			>= $this->ci->config->item('login_max_attempts', 'tank_auth');
		}
		return FALSE;
	}

	/**
	 * Increase number of attempts for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function increase_login_attempt($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			if (!$this->is_max_login_attempts_exceeded($login)) {
				$this->ci->load->model('tank_auth/login_attempts');
				$this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
			}
		}
	}

	/**
	 * Clear all attempt records for given IP-address and login
	 * (if attempts to login is being counted)
	 *
	 * @param	string
	 * @return	void
	 */
	private function clear_login_attempts($login)
	{
		if ($this->ci->config->item('login_count_attempts', 'tank_auth')) {
			$this->ci->load->model('tank_auth/login_attempts');
			$this->ci->login_attempts->clear_attempts(
				$this->ci->input->ip_address(),
				$login,
				$this->ci->config->item('login_attempt_expire', 'tank_auth'));
		}
	}
	/**
	 * Test added by Vernon
	 *
	 *
	 * @param	string
	 * @return	void
	 */
	public static function compare($data){
		$ci =& get_instance();
		$hasher = new PasswordHash(

			$ci->config->item('phpass_hash_strength', 'tank_auth'),
			$ci->config->item('phpass_hash_portable', 'tank_auth'));
		return $hasher->CheckPassword($data['new'], $data['old']);
	}

    function is_test_account($ip) {
        $data['ip'] = ip2long($ip);
        $data['Lo1'] = ip2long('210.213.232.24');
        $data['Hi1'] = ip2long('210.213.232.30');
        $data['StaticIP'] = array(
            '115.127.83.18',
            '5.9.65.183',
            '5.9.102.99',
            '78.46.187.12',
            '78.46.190.237',
            '78.46.195.217',
            '193.138.230.130',
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        } elseif ($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']) {
            return true;
        } else {
            return false;
        }
    }


}

/* End of file Tank_auth.php */
/* Location: ./application/libraries/Tank_auth.php */