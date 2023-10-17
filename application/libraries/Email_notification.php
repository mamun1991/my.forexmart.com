<?php

class Email_notification {

	private $CI = NULL;

	public function __construct()
	{
		$this->CI = &get_instance();
	}

	/**
	 * @param $user_id
	 * @return bool
	 */
	public function dailyCountryReport($user_id)
	{
		$this->CI->load->model('account_model');
		$this->CI->load->model('general_model');
		if ($row = $insert_data['client_country'] = $this->CI->account_model->getClientInfoByUserId($user_id))
		{
			$c_code = $row[0]->country;
			$insert_data['country'] = $this->CI->general_model->getCountries();
			$insert_data['country']["GB','IE"] = "UK and Ireland ";
			$insert_data['country']["AT','DE"] = "Austria and Germany ";
			$insert_data['country']["AM','BY','KZ','KG','MD','RU','TJ','TM','UA','UZ"] = "Russia and CIS";

			$to_email = [
//                "ES" => 'clients_spain_daily_1@forexmart.com',
//                "AT" => 'clients_germany_daily_1@forexmart.com',
//                "DE" => 'clients_germany_daily_1@forexmart.com',
				"FR" => 'clients_france_daily_1@forexmart.com',
				"GB" => 'clients_ukireland_daily_1@forexmart.com',
				"IE" => 'clients_ukireland_daily_1@forexmart.com',
				"BG" => 'clients_bulgaria_daily_1@Forexmart.com',
				"CA" => 'clients_ukireland_daily_1@forexmart.com',
				"NL" => 'clients_ukireland_daily_1@forexmart.com',
				"AM" => 'clients_russia_daily_1@forexmart.com',
				"BY" => 'clients_russia_daily_1@forexmart.com',
				"KZ" => 'clients_russia_daily_1@forexmart.com',
				"KG" => 'clients_russia_daily_1@forexmart.com',
				"MD" => 'clients_russia_daily_1@forexmart.com',
				"RU" => 'clients_russia_daily_1@forexmart.com',
				"TJ" => 'clients_russia_daily_1@forexmart.com',
				"TM" => 'clients_russia_daily_1@forexmart.com',
				"UA" => 'clients_russia_daily_1@forexmart.com',
				"UZ" => 'clients_russia_daily_1@forexmart.com',
//                "PL" => 'clients_poland_daily_1@forexmart.com',
				"SK" => 'clients_czech.slovak_daily_1@forexmart.com',
				"CZ" => 'clients_czech.slovak_daily_1@forexmart.com',
			];


			// $insert_data['email'] = "fin-stats@forexmart.com";
			// $insert_data['email'] = "moniruzzaman-it@itgrowtech.com,bug.fxpp@gmail.com";

			if (isset($to_email[$c_code]))
			{
				$insert_data['email'] = $to_email[$c_code];
			} else
			{
				return TRUE; // At the moment we do not need the real time mailing with registrations from all countries.
				$insert_data['email'] = "german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com";
			}


			$insert_data['subject'] = "Clients from " . $insert_data['country'][$c_code] . " on  " . date('Y-m-d');
			$config = [
				'mailtype' => 'html'
			];


			$this->CI->load->library('email');
			if ($config != NULL)
			{
				$this->CI->email->initialize($config);
			}
			$this->CI->SMTPDebug = 1;
			$this->CI->email->from('noreply@mail.forexmart.com', 'ForexMart');
			//  $this->email->reply_to('noreply@mail.forexmart.com', 'ForexMart');
			$this->CI->email->to($insert_data['email']);
			//  $this->email->to("moniruzzaman-it@itgrowtech.com,bug.fxpp@gmail.com");

			if (isset($to_email[$c_code]))
			{
				$this->CI->email->bcc('german.pavlyak@forexmart.com,ildar.sharipov@forexmart.com,stefania.sopko@forexmart.com');
			} else
			{
				// $insert_data['email'] ="german.pavlyak@forexmart.com,agus@forexmart.com,ildar.sharipov@forexmart.com";
				$this->CI->email->bcc('stefania.sopko@forexmart.com');
			}

			$this->CI->email->bcc('alexey.nikolaev@kpigroups.com');
			$this->CI->email->subject($insert_data['subject']);
			$this->CI->email->message($this->load->view('email/realtime_client_report', $insert_data, TRUE));
			$this->CI->email->send();
		}

	}
}