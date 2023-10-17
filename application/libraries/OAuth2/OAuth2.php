<?php

require_once APPPATH . 'vendor/autoload.php';
require_once APPPATH . 'controllers/Client.php';


class OAuth2 {

	/**@var CI_Controller|null $CI */
	protected $CI = null;

	public function __construct()
	{
		$this->CI = & get_instance();
		$this->CI->load->model('General_model');
		$this->CI->load->model('cabinet_model');
		$this->CI->load->library('WSV');
	}

	/**
	 * Check for auth service exists
	 *
	 * @return bool
	 * @throws Exception
	 */
	protected function checkServiceExists()
	{
		return true;
		if (! class_exists(__CLASS__)) {
			throw new Exception("Service not found");
		}

		return true;
	}

	protected function user_auth($user_data)
	{
		$this->CI->load->library('Email_notification');

		if ($this->CI->general_model->showssingle('users', 'login_oauth_id', $user_data['id']))
		{
			$user_info = $this->CI->cabinet_model->getUserInfoByAuthID($user_data['id']);
			$readOnly = FALSE;
			$this->CI->session->set_userdata([
				'oauth_provider' => $user_data['provider'],
				'oauth_id' => $user_data['id'],
				'full_name' => $user_info->full_name,
				'user_id' => $user_info->id,
				'username' => $user_info->username,
				'email' => $user_info->email,
				'logged_in' => TRUE,
				'logged' => 1,
				'status' => 1,
				'administration' => $user_info->administration,
				'login_type' => $user_info->login_type,
				'readOnly' => $readOnly,
				'account_number' => $user_info->account_number,
				'country' => $user_info->country,
				'mt_account_set_id' => $user_info->mt_account_set_id,
				'accountstatus' => $user_info->accountstatus,
				'image' => $user_info->image,
			]);

			redirect(FXPP::my_url('my-account/current-trades'));

		} else
		{
			// create user
			$country = FXPP::getUserCountryCode() or null;
			$whereData = ['countryCode' => $country];
			$conndata = $this->CI->general_model->getQueryStringRow('country_to_courrency', '*', $whereData);
			if ($conndata->currencyCode != 'EUR' and $conndata->currencyCode != 'GBP' and $conndata->currencyCode != 'RUB')
			{
				$currency = 'USD';
			} else
			{
				$currency = $conndata->currencyCode;
			}

			$login_type = 0;
			$use_username = $this->CI->config->item('use_username', 'tank_auth');
			$email_activation = $this->CI->config->item('email_activation', 'tank_auth');
			$userEmail = $user_data['email'];
			$userFullName = $user_data['first_name'] . ' ' . $user_data['last_name'];
			$password = $this->autoPassword(8);
			$insertUserData = $this->CI->tank_auth->create_user('', $userEmail, $password, $email_activation, 1,
				$login_type);

			$authData = [
				'login_oauth_provider' => $user_data['provider'],
				'login_oauth_id' => $user_data['id']
			];


			$userID = $insertUserData['user_id'];
			$this->CI->general_model->updatemy($table = "users", "id", $userID, $authData);

			$swap_free = 0;
			$phone_password = FXPP::RandomizeCharacter(7);
			if (IPLoc::isChinaIP() || $country == 'CN')
			{
				$this->CI->session->set_userdata('isChina', '1');
			}

			$groupCurrency = $this->CI->general_model->getGroupCurrency(1, $currency, $swap_free) . 1;
			$service_data = [
				'address' => '',
				'city' => '',
				'country' => $this->CI->general_model->getCountries($country),
				'email' => $userEmail,
				'group' => $groupCurrency,
				'leverage' => '1:50',
				'name' => $userFullName,
				'phone_number' => '',
				'state' => '',
				'zip_code' => '',
				'phone_password' => $phone_password,
				'comment' => $this->CI->input->ip_address()
			];

			$webservice_config = [
				'server' => 'live_new'
			];
			$WebService = $this->CI->wsv->OpenNewAccount($service_data, $webservice_config);

			if ($WebService->request_status === 'RET_OK')
			{
				$AccountNumber = $WebService->AccountNumber;
				$TraderPassword = $WebService->TraderPassword;
				$InvestorPassword = $WebService->InvestorPassword;

				FXPP::activate_trading_API($userID, $AccountNumber);
				$RegDate = FXPP::getServerTime();
				$mt_account = [
					'leverage' => '1:50',
					'registration_leverage' => '1:50',
					'amount' => '',
					'mt_currency_base' => $currency,
					'mt_account_set_id' => 1,
					'registration_ip' => $_SERVER['REMOTE_ADDR'],
					'registration_time' => date('Y-m-d H:i:s', strtotime($RegDate)),
					'user_id' => $userID,
					'mt_type' => 1,
					'swap_free' => $swap_free,
					'account_number' => $AccountNumber,
					'trader_password' => $TraderPassword,
					'investor_password' => $InvestorPassword,
					'phone_password' => $phone_password
				];

				$this->CI->general_model->insert('mt_accounts_set', $mt_account);
				$profile = [
					'full_name' => $userFullName,
					'user_id' => $userID,
					'country' => $country,
					'street' => '',
					'city' => '',
					'state' => '',
					'zip' => '',
					'dob' => '',
					'image' => $user_data['avatar'],
				];
				$this->CI->general_model->insert('user_profiles', $profile);

				// Save affiliate code
				$generateAffiliateCode = FXPP::GenerateRandomAffiliateCode();
				$affiliate_code_data = [
					'users_id' => $userID,
					'affiliate_code' => $generateAffiliateCode
				];
				$this->CI->general_model->insert('users_affiliate_code', $affiliate_code_data);

				// Save trading experience
				$trading_experience = [
					'investment_knowledge' => '',
					'risk' => '',
					'experience' => '',
					'user_id' => $userID,
					'technical_analysis' => '',
					'trade_duration' => '',
				];
				$this->CI->general_model->insert('trading_experience', $trading_experience);

				$contacts_data = [
					'phone1' => '',
					'user_id' => $userID
				];
				$this->CI->general_model->insert('contacts', $contacts_data);

				$reg_link_details = [
					'registration_link' => $user_data['provider'] . ' sign in',
					'user_id' => $userID,
					'street' => '',
					'date_created' => date('Y-m-d H:i:s', strtotime($RegDate)),
				];
				$this->CI->general_model->insert('track_registration', $reg_link_details);

				$email_data = [
					'full_name' => $userFullName,
					'email' => $userEmail,
					'password' => $password,
					'account_number' => $mt_account['account_number'],
					'trader_password' => $mt_account['trader_password'],
					'investor_password' => $mt_account['investor_password'],
					'phone_password' => $mt_account['phone_password'],
				];

				// send account details

				$subject = "ForexMart MT4 Live Trading Account details";
				$config = [
					'mailtype' => 'html'
				];


				$this->CI->general_model->sendEmail('live-account-html', $subject, $email_data['email'], $email_data,
					$config);

				$this->CI->Email_notification->dailyCountryReport($userID);

				$readOnly = TRUE;
				$this->CI->session->set_userdata([
					'oauth_provider' => $user_data['provider'],
					'oauth_id' => $user_data['id'],
					'full_name' => $userFullName,
					'user_id' => $userID,
					'username' => '',
					'email' => $userEmail,
					'logged_in' => TRUE,
					'logged' => 1,
					'status' => 1,
					'administration' => 0,
					'login_type' => 0,
					'account_number' => $mt_account['account_number'],
					'country' => $country,
					'mt_account_set_id' => 1,
					'accountstatus' => 0
				]);

				redirect(FXPP::my_url('my-account/current-trades'));
			}
		}
	}

	private function autoPassword($nc, $a = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
		$l = strlen($a) - 1;
		$r = '';
		while ($nc-- > 0)
			$r .= $a{mt_rand(0, $l)};
		return $r;
	}
}