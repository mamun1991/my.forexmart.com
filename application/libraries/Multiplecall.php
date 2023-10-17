<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Multiplecall{

	public static function bonus($country = ''){
//		require_once APPPATH.'/helpers/geoiploc.php';
//		$CI =& get_instance();
//
//		$ip=$CI->input->ip_address();
//		if($CI->input->valid_ip($ip)){
//			$data['Country'] =getCountryFromIP($ip);
//		}else{
//			$data['Country'] = 'Invalid';
//		}
		$data['Country'] = $country;
		//https://docs.google.com/spreadsheets/d/1Pvmj6q3PY6VAbKaXw_rWXmNt5F12qSeK_o6KjGKeBto/edit#gid=606146794

		$data['c1_20'] = array('BD', 'CN', 'HK', 'TW', 'KE', 'UZ');
		$data['c2_40'] = array('ID','JO','LB');
		$data['c2_40_latinamerica'] = array('AR','BO','BR','CL','CO','CR','CU','DO','EC','SV','GF','GP','GT', 'HT','HN','MQ','MX','NI','PA','PY','PE','PR','MF','UY','VE');
		$data['c2_40_merge'] = array_merge($data['c2_40'], $data['c2_40_latinamerica']);
		$data['c3_30'] = array('IN','NG','EG','MA','TN');
		$data['c4_50'] = array('MY','TH','AG','BS');
		$data['c5_70'] = array('ZA','SA','AE','BN');
		$data['c6_15'] = array('DZ','AO','SH','BJ','BW','BF','BI','CM','CV','CF','TD','KM','CG','DJ','EG','GQ','ER','ET','GA','GM','GH','GW','GN','CI','KE','LS','LR','LY','MG','MW','ML','MR','MU','YT','MA','MZ','NA','NE','NG','ST','RE','RW','ST','SN','SC','SL','SO','SH','SD','SZ','TZ','TG','TN','UG','CD','ZM','TZ','ZW','SS','CD');
		$data['c7_50'] = array('HU');
		$data['c8_40'] = array('UA','BY','LV','LT','GE','MD');
		$data['c9_40'] = array('FJ');
		$data['c9_40_otheroceanis'] = array('DZ','AO','SH','BJ','BW','BF','BI','CM','CV','CF','TD','KM','CG','DJ','EG','GQ','ER','ET','GA','GM','GH','GW','GN','CI','KE','LS','LR','LY','MG','MW','ML','MR','MU','YT','MA','MZ','NA','NE','NG','ST','RE','RW','ST','SN','SC','SL','SO','SH','SD','SZ','TZ','TG','TN','UG','CD','ZM','TZ','ZW','SS','CD');
		$data['c9_40_merge'] = array_merge($data['c9_40'], $data['c9_40_otheroceanis']);
		$data['c10_100'] = array('KW','QA','BH');
		$data['c11_100'] = array('AD','AU','AT','BE','CA','CY','CZ','EE','DK','FO','FI','FR','DE','GR','IS','IE','IL','IT','JP','LU','MT','MC','NZ','NL','NO', 'PT','SM','SG','SK','SI','KR','ES','SE','CH','US','GB');
		$data['c12_70'] = array('PL','RU','KZ');
		$data['c13_20'] = array('');

		$data['data']['bonus']='';
		if (in_array($data['Country'], $data['c1_20'])) {
			$data['data']['bonus']=20;
		}else if (in_array($data['Country'], $data['c2_40_merge'])) {
			$data['data']['bonus']=40;
		}else if (in_array($data['Country'], $data['c3_30'])) {
			$data['data']['bonus']=30;
		}else if (in_array($data['Country'], $data['c4_50'])) {
			$data['data']['bonus']=50;
		}else if (in_array($data['Country'], $data['c5_70'])) {
			$data['data']['bonus']=70;
		}else if (in_array($data['Country'], $data['c6_15'])) {
			$data['data']['bonus']=15;
		}else if (in_array($data['Country'], $data['c7_50'])) {
			$data['data']['bonus']=50;
		}else if (in_array($data['Country'], $data['c8_40'])) {
			$data['data']['bonus']=40;
		}else if (in_array($data['Country'], $data['c9_40_merge'])) {
			$data['data']['bonus']=40;
		}else if (in_array($data['Country'], $data['c10_100'])) {
			$data['data']['bonus']=100;
		}else if (in_array($data['Country'], $data['c11_100'])) {
			$data['data']['bonus']=100;
		}else if (in_array($data['Country'], $data['c12_70'])) {
			$data['data']['bonus']=70;
		}else{
			$data['data']['bonus']=20;
		}
		return $data['data']['bonus'];
	}
	public static function WhitelistPIPCandCC(){
		return false;
		exit;
		require_once APPPATH.'/helpers/geoiploc.php';
		$CI =& get_instance();
		$ip=$CI->input->ip_address();

		if($CI->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
		}

		$data['WhitelistCountries'] = array('GB', 'BG', 'RU', 'TW', 'LT', 'ES');
		$data['StaticIP'] = array(
			'27.147.132.246',
			'124.107.173.21',
			'58.69.197.82',

			'118.69.226.81',

			'182.253.242.23',
			'213.239.215.78',
			'83.219.143.110',
			'62.152.11.127',
			'104.155.4.46',

			'5.9.65.183',
			'79.170.141.39',
			'104.24.19.93',
			'104.24.18.93',
			'148.251.181.104',

			'148.251.122.78',
			'10.10.111.5', //Paxum IPN
			'148.251.181.104',
			'115.127.83.18',
			'176.9.130.91'

//			'210.213.232.26'

		);

		$data['ip'] = ip2long($ip);

		$data['Lo0'] = ip2long('193.138.0.0');
		$data['Hi0'] = ip2long('193.138.255.255');

		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');

		if (in_array($data['Country'], $data['WhitelistCountries'])) {
			return true;
		}elseif(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi0'] && $data['Lo0'] <= $data['ip']){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}
}

