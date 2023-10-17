<?php

require_once APPPATH . 'libraries/OAuth2/OAuth2.php';

final class Google_OAuth extends OAuth2 {

	/**
	 * @var \Google_Client
	 */
	public $client;

	private $provider_name = 'google';

	public function __construct()
	{
		$this->client = new Google_Client();
		parent::__construct();
	}

	/**
	 * Get user data and sign in or register new user
	 *
	 * @param string $code
	 */
	public function sign_in($code)
	{
		$this->client->setClientId('717295422510-t5h099m0gojohrnnrh1pfgieqtjocnrg.apps.googleusercontent.com');
		$this->client->setClientSecret('t-D9WZu2bSQWr38kBz6kFYWA');
		$this->client->setRedirectUri(FXPP::my_url('client/signin'));
		$this->client->addScope('email');
		$this->client->addScope('profile');
		if (isset($code))
		{
			$token = $this->client->fetchAccessTokenWithAuthCode($code);

			if ( ! isset($token['error']))
			{
				$this->client->setAccessToken($token['access_token']);
				$this->CI->session->userdata('access_token', $token['access_token']);

				$google_service = new Google_Service_Oauth2($this->client);
				$googleData = $google_service->userinfo->get();
				$user_data = [
					'id' => $googleData['id'],
					'email' => $googleData['email'],
					'first_name' => $googleData['given_name'],
					'last_name' => $googleData['family_name'],
					'avatar' => $googleData['picture'],
					'provider' => $this->provider_name
				];
				$this->user_auth($user_data);
			}
		}
	}

	/**
	 * Create or authenticate user
	 *
	 * @param array $user_data
	 */
	protected function user_auth($user_data)
	{
		parent::user_auth($user_data);
	}

	/**
	 * @return string
	 */
	public function get_login_button()
	{
		return '<a href="' . $this->client->createAuthUrl() . '" class="btn btn-block btn-google btn-flat">
                	<img src="' . $this->CI->template->Images() . 'google-icon.png" class="google-icon"> Sign in using Google
                </a>';
	}

}