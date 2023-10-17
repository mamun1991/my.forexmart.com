<?php defined('BASEPATH') OR exit('No direct script access allowed');


class IPLoc{
	public static function bonusV2($country = ''){
		//jira FXPP-2074
		// new reference https://docs.google.com/spreadsheets/d/14uXnEoRimvCcGoYwp7IDCTafyLPZ5bSaUAwOH6fccy8/edit#gid=606146794

		$data['Country'] = $country;
		$data['c1_20'] = array('BD', 'CN', 'HK', 'TW', 'KE', 'UZ','IN','JO','LB'); //Bangladesh, China, Hong Kong, Taiwan, Kenya, Uzbekistan ,India , Jordan , Lebanon added countries.

		$data['c2_30n'] = array('ID'); // indonesia
		$data['c2_30n_latinamerica'] = array('AR','BO','BR','CL','CO','CR','CU','DO','EC','SV','GF','GP','GT', 'HT','HN','MQ','MX','NI','PA','PY','PE','PR','MF','UY','VE'); // latin america
		$data['c2_30n_merge'] = array_merge($data['c2_30n'], $data['c2_30n_latinamerica']); // merge latin america and indoenesia to 30 usd bonus

		$data['c3_30'] = array('NG','EG','MA','TN'); // removed india and retain  Nigeria, Egypt, Morocco, Tunisia

		$data['c4_40n'] = array('MY','TH','AG','BS'); // "MY" => "Malaysia","TH" => "Thailand",  AG" => "Antigua And Barbuda", "BS" => "Bahamas",

		$data['c5_50'] = array('ZA','SA','AE','BN'); // "ZA" => "South Africa", "SA" => "Saudi Arabia",   "AE" => "United Arab Emirates","BN" => "Brunei Darussalam",

		$data['c6_15'] = array('DZ','AO','BJ','BW','BF','BI','CM','CV','CF','TD','KM','CG','DJ','GQ','ER','ET','GA','GM','GH','GW','GN','CI','LS','LR','LY','MG','MW','ML','MR','MU','YT','MA','MZ','NA','NE','ST','RE','RW','SN','SC','SL','SO','SH','SD','SZ','TZ','TG','UG','CD','ZM','TZ','ZW'); //Other countries of Africa
//  "DZ" => "Algeria",  "AO" => "Angola","SH" => "St. Helena","BJ" => "Benin","BW" => "Botswana","BF" => "Burkina Faso", "BI" => "Burundi","CM" => "Cameroon","CV" => "Cape Verde", "CF" => "Central African Republic","TD" => "Chad","KM" => "Comoros","CG" => "Congo","DJ" => "Djibouti", "GQ" => "Equatorial Guinea","ER" => "Eritrea", "ET" => "Ethiopia","GA" => "Gabon", "GM" => "Gambia", "GH" => "Ghana","GW" => "Guinea-Bissau","GN" => "Guinea", "CI" => "Cote D'Ivoire","LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libyan Arab Jamahiriya","MG" => "Madagascar","MW" => "Malawi", "ML" => "Mali",  "MR" => "Mauritania", "MU" => "Mauritius","YT" => "Mayotte","MA" => "Morocco", "MZ" => "Mozambique","NA" => "Namibia",    "NE" => "Niger","ST" => "Sao Tome And Principe","RE" => "Reunion", "RW" => "Rwanda",  "SN" => "Senegal","SC" => "Seychelles","SL" => "Sierra Leone", "SO" => "Somalia",  "SH" => "St. Helena",   "SD" => "Sudan","SZ" => "Swaziland","TZ" => "Tanzania, United Republic Of","UG" => "Uganda","CD" => "Congo, The Democratic Republic Of The", "ZM" => "Zambia","ZW" => "Zimbabwe" , "TG" => "Togo",

		$data['c7_50'] = array('HU');//"HU" => "Hungary", retain

		$data['c8_40'] = array('UA','BY','LV','LT','GE','MD','RU','KZ');//"UA" => "Ukraine", "BY" => "Belarus","LV" => "Latvia","LT" => "Lithuania", "GE" => "Georgia", "MD" => "Moldova, Republic Of","RU" => "Russian Federation", "KZ" => "Kazakhstan",

		$data['c9_40'] = array('FJ');//"FJ" => "Fiji", Tasmania not found

		$data['c9_40_otheroceanis'] = array('TP','AU','CX','CC','NF','NC','PB','PG','SB','VU','FM','GU','KI','MH','NR','MP','PW','UM','AS','CK','PF','NU','PN','WS','TK','TO','TV','WF'); // removed SD sudan removed ST
		//https://en.wikipedia.org/wiki/Oceania

		$data['c9_40_merge'] = array_merge($data['c9_40'], $data['c9_40_otheroceanis']);
		$data['c10_50'] = array('KW','QA','BH');

		$data['c11_100'] = array('AD','AU','AT','BE','CA','CY','CZ','EE','DK','FO','FI','FR','DE','GR','IS','IE','IL','IT','JP','LU','MT','MC','NZ','NL','NO', 'PT','SM','SG','SK','SI','KR','ES','SE','CH','GB');
//"AD" => "Andorra","AU" => "Australia", "AT" => "Austria","BE" => "Belgium","CA" => "Canada","CY" => "Cyprus","CZ" => "Czech Republic","EE" => "Estonia","DK" => "Denmark",  "FO" => "Faroe Islands", "FI" => "Finland","FR" => "France","DE" => "Germany", "GR" => "Greece","IS" => "Iceland","IE" => "Ireland", "IL" => "Israel","IT" => "Italy","JP" => "Japan",  "LU" => "Luxembourg", "MT" => "Malta","MC" => "Monaco","NZ" => "New Zealand","NL" => "Netherlands","NO" => "Norway","PT" => "Portugal","SM" => "San Marino","SG" => "Singapore","SK" => "Slovakia (Slovak Republic)","SI" => "Slovenia","KR" => "Korea, Republic Of","ES" => "Spain", "CH" => "Switzerland", "GB" => "United Kingdom",   "SE" => "Sweden",

//		no great britain use united kingdom
		$data['c12_70'] = array('PL');//"PL" => "Poland",

		$data['c13_20'] = array('');

		$data['data']['bonus']='';
		if (in_array($data['Country'], $data['c1_20'])) {
			$data['data']['bonus']=20;

		}else if (in_array($data['Country'], $data['c2_30n_latinamerica'])) {

			$data['data']['bonus']=30; //40 before

		}else if (in_array($data['Country'], $data['c3_30'])) {
			$data['data']['bonus']=30; // 30 before ratined
		}else if (in_array($data['Country'], $data['c4_40n'])) {
			$data['data']['bonus']=40; // 50 before
		}else if (in_array($data['Country'], $data['c5_50'])) {
			$data['data']['bonus']=50;// 70 before

		}else if (in_array($data['Country'], $data['c6_15'])) {
			$data['data']['bonus']=15; // retain double check africas
		}else if (in_array($data['Country'], $data['c7_50'])) {
			$data['data']['bonus']=50; // retain
		}else if (in_array($data['Country'], $data['c8_40'])) {
			$data['data']['bonus']=40; // retain
		}else if (in_array($data['Country'], $data['c9_40_merge'])) {
			$data['data']['bonus']=40;
		}else if (in_array($data['Country'], $data['c10_50'])) {
			$data['data']['bonus']=50; //100 before
		}else if (in_array($data['Country'], $data['c11_100'])) {
			$data['data']['bonus']=100;
		}else if (in_array($data['Country'], $data['c12_70'])) {
			$data['data']['bonus']=70;
		}else{
			$data['data']['bonus']=20;
		}
		return $data['data']['bonus'];

	}


	public static function bonus(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$CI =& get_instance();

		$ip=$CI->input->ip_address();
		if($CI->input->valid_ip($ip)){
			$data['Country'] =getCountryFromIP($ip);
		}else{
			$data['Country'] = 'Invalid';
		}

		//https://docs.google.com/spreadsheets/d/1Pvmj6q3PY6VAbKaXw_rWXmNt5F12qSeK_o6KjGKeBto/edit#gid=606146794

		$data['c1_20'] = array('BD', 'CN', 'HK', 'TW', 'KE', 'UZ');// 20
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
		$data['c11_100'] = array('AD','AU','AT','BE','CA','CY','CZ','EE','DK','FO','FI','FR','DE','GR','IS','IE','IL','IT','JP','LU','MT','MC','NZ','NL','NO', 'PT','SM','SG','SK','SI','KR','ES','SE','CH','US');
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

	public static function ForexCalc(){
		/**  method used once*/
		//FXPP-916
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}
		$data['WhitelistCountries'] = array('GB', 'BG', 'RU', 'LT', 'ES');

		$data['StaticIP'] = array(
			'115.127.83.18',
			'124.107.173.21',
			'58.69.197.82',
			'192.168.1.85',
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
			'10.10.111.5' //Paxum IPN
			,'148.251.181.104',
			'78.46.187.12'
		);
		$data['ip'] = ip2long($ip);

		$data['Lo0'] = ip2long('193.138.0.0');
		$data['Hi0'] = ip2long('193.138.255.255');

		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.30');

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
	public static function WhitelistPIPCandCC(){

		require_once APPPATH.'/helpers/geoiploc.php';

		$ip=FXPP::CI()->input->ip_address();

		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
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
			'78.46.187.12',
			'78.46.190.237',

			'115.127.83.18',
			'176.9.130.91',
            // '5.9.102.99',

			'81.4.164.118' // Neteller IP

		);

		$data['ip'] = ip2long($ip);

		$data['Lo0'] = ip2long('193.138.0.0');
		$data['Hi0'] = ip2long('193.138.255.255');

		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');

//		$data['Lo2'] = ip2long('182.18.0.1');
//		$data['Hi2'] = ip2long('182.18.255.254');

		if (in_array($data['Country'], $data['WhitelistCountries'])) {
			return true;
		}elseif(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi0'] && $data['Lo0'] <= $data['ip']){
			return true;
//		}elseif($data['ip'] <= $data['Hi2'] && $data['Lo2'] <= $data['ip']){
//			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}

	}



	public static function Officetest2($ip){
		require_once APPPATH.'/helpers/geoiploc.php';

		$data['StaticIP'] = array(
			'5.9.65.183',
			'78.46.195.217',
			'115.127.83.18',
			'78.46.79.174',
			//'5.9.102.99',
            '182.163.102.47',
			'109.237.2.242 ',//FXPP-7643
            '81.4.164.118',
            // '88.198.94.228'//FOR CHINESE
			// '188.40.37.66',
			// '80.250.69.99'
//			'78.46.187.12'
             '83.219.143.110', //eu access
             '81.4.164.118', //eu access
                    );
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}
	public static function Office(){
	
	
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		$data['StaticIP'] = array(
			'5.9.65.183',
			'78.46.195.217',
			'115.127.83.18',
			'78.46.79.174',
			//'5.9.102.99',
            '182.163.102.47',
			'109.237.2.242 ',//FXPP-7643
            '81.4.164.118',
            '46.146.225.205',
            '88.198.94.228',//FXPP-11298
            // '88.198.94.228'//FOR CHINESE
			// '188.40.37.66',
			// '80.250.69.99'
//			'78.46.187.12'
             '83.219.143.110', //eu access
             '81.4.164.118',  //eu access
             '159.69.88.248',
            '210.213.232.30', // api admin
            '78.46.190.237', //
			'78.46.185.187',//provide tobias FXPP-11298
			'152.32.105.198',
			'152.32.104.142',
			'130.105.209.200',
			'152.32.100.196',
			'49.12.5.139',
			'159.69.88.248', //taariq
			"95.217.153.171", // Tester
            '14.250.128.80', // tester paymentasia
            '14.250.128.112', // tester paymentasia
            '14.165.210.172', // tester paymentasia

        );
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}

	public static function NdbBonus(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		$data['StaticIP'] = array(
		     '78.46.187.12',
		     '78.46.190.237',
             '78.46.195.217',
		     '210.213.232.29',
             '5.9.65.183',
			 '148.251.122.78',
			 '136.243.104.88',
		     '115.127.83.18'
		);
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}

	public static function Banned(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		$data['StaticIP'] = array(
			'212.33.2.170',
			'27.147.132.246'
		);
//		$data['ip'] = ip2long($ip);
//		$data['Lo1'] = ip2long('210.213.232.24');
//		$data['Hi1'] = ip2long('210.213.232.29');
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}else{
			return false;
		}
//		elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
//			return true;
//		}
	}
	public static function for_id_only(){
//		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
//			$data['Country'] = getCountryFromIP($ip);
            $data['Country'] = self::getCountryCode($ip);
		}else{
			return false;
			exit;
		}

		// $data['StaticIP'] = array(
		// 	'162.158.64.151',
		// 	'210.213.232.29',
		// );

		if($data['Country']=='ID') {
			return true;
		// }
		// elseif(in_array($ip, $data['StaticIP'])){
		// 	return true;
		}else{
			return false;
		}
	}
	public static function for_my_only(){
	//	require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = self::getCountryCode($ip);
		}else{
			return false;
			exit;
		}

		if($data['Country']=='MY'){
			return true;
		}else{
			return false;
		}
	}
	public static function for_th_only(){
	//	require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = self::getCountryCode($ip);
		}else{
			return false;
			exit;
		}

		if($data['Country']=='TH'){
			return true;
		}else{
			return false;
		}
	}

	public static function for_vn_only(){
	//	require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = self::getCountryCode($ip);
		}else{
			return false;
			exit;
		}

		if($data['Country']=='VN'){
			return true;
		}else{
			return false;
		}
	}

	public static function Office_and_Vpn(){
            
            
           
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
             
                
		if(FXPP::CI()->input->valid_ip($ip)){
                   
			$data['Country'] = getCountryFromIP($ip);
		}else{
                    
			return false;
			exit;
		}

		$data['StaticIP'] = array(
			'5.9.65.183',
			'115.127.83.18',
			// '5.9.102.99',
			'78.46.79.174',
			'78.46.187.12',

			'188.40.37.66',
            '78.46.195.217',
            '148.251.122.78',
            '136.243.104.88',
            '182.163.102.47',
            '78.46.190.237',
            '49.12.5.139',
            '159.69.88.248'
		);
                
                
                
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');

		$data['vpnLo1'] = ip2long('78.46.187.8');
		$data['vpnHi1'] = ip2long('78.46.187.14');
                
                
                
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}elseif($data['ip'] <= $data['vpnHi1'] && $data['vpnLo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
                
                
	}

	public static function Office_and_Vpn_Trading(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		$data['StaticIP'] = array(
			'5.9.65.183',
			'115.127.83.18',
			// '5.9.102.99',
			'79.170.141.39',
			'78.46.187.12',
			'78.46.79.174'
			
		);
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');

		$data['vpnLo1'] = ip2long('78.46.187.8');
		$data['vpnHi1'] = ip2long('78.46.187.14');
		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}elseif($data['ip'] <= $data['vpnHi1'] && $data['vpnLo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}

	public static function Office_and_Vpn_InviteFriend(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		$data['StaticIP'] = array(
			'78.46.190.237',
			'78.46.195.217',
			'115.127.83.18',
			'78.46.187.12'
		);
		$data['ip'] = ip2long($ip);
		$data['Lo1'] = ip2long('210.213.232.24');
		$data['Hi1'] = ip2long('210.213.232.29');

		if(in_array($ip, $data['StaticIP'])){
			return true;
		}elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
			return true;
		}else{
			return false;
		}
	}

	public static function for_de_only(){
		require_once APPPATH.'/helpers/geoiploc.php';
		$ip=FXPP::CI()->input->ip_address();
		if(FXPP::CI()->input->valid_ip($ip)){
			$data['Country'] = getCountryFromIP($ip);
		}else{
			return false;
			exit;
		}

		if($data['Country']=='DE'){
			return true;
		}else{
			return false;
		}
	}


    public static function isChinaIP(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $country = getCountryFromIP($ip);
        }else{
            $country = 'Invalid';
        }

        $chinese_provinces = array(
            'CN', 'HK', 'MO', 'TW', 'XJ', 'NX', 'QH', 'GS', 'SN', 'XZ', 'YN', 'GZ', 'SC', 'CQ', 'HI', 'GX', 'GD',
            'HN', 'HB', 'HA', 'SD', 'JX', 'FJ', 'AH', 'ZJ', 'JS', 'SH', 'HL', 'JL', 'LN', 'NM', 'SX', 'HE', 'TJ', 'BJ',
        );

        if(in_array(strtoupper($country),$chinese_provinces)){
            return true;
        }else{
            return false;
        }
    }

    public static function IPCrpAccVerify(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '115.127.83.18',
            '182.163.102.47',
           // '78.46.190.237',
            '127.0.0.1'
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }


    public static function IP4Me(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '115.127.83.18',
            '182.163.102.47',
            // '78.46.190.237',
            '127.0.0.1'
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }

    public static function forGermanSpeaking(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $data['Country'] = getCountryFromIP($ip);
        }else{
            return false;
            exit;
        }
        // Germany, Belgium, Spain and Italy
        $german_speaking = array(
            'BE','ES','IT','DE'
        );

        if(in_array($data['Country'],$german_speaking)){
            return true;
        }else{
            return false;
        }
    }
    
    public static function Office_for_NDB(){
        $ip=FXPP::CI()->input->ip_address();
        $data['ip'] = ip2long($ip);
        $data['Lo1'] = ip2long('210.213.232.24');
        $data['Hi1'] = ip2long('210.213.232.29');
        $data['StaticIP'] = array(
            '78.46.187.12',
            '78.46.190.237',
            '78.46.195.217',
            '210.213.232.29',
            '5.9.65.183',
            '148.251.122.78',
            '136.243.104.88',
            '115.127.83.18',
            '182.163.102.47'
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }elseif($data['ip'] <= $data['Hi1'] && $data['Lo1'] <= $data['ip']){
            return true;
        }else{
            return false;
        }
    }

    public static function IPOnlyForMe(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '182.163.102.47',
            '210.213.232.29',
            '115.127.83.2',
            '78.46.190.237',
			'159.69.88.248',
			'49.12.5.139',
            '159.69.88.248' //taariq
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }

    public static function IPOnlyForVenus(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
			'78.46.190.237',
            '195.201.40.47'
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }
	public static function APITraderIP(){
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
			'49.12.42.32',
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }

    public static function IPOnlyForG(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '49.12.5.139',
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }


    public static function IPOnlyForTq(){
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '159.69.88.248',
            '95.217.153.171',
            '49.12.5.139',

        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }







    public static function isEuropeanIP(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $country = getCountryFromIP($ip);
            //added validation for invalid code
            $invalid_code = array('ZZ');
            if(in_array(strtoupper($country),$invalid_code)){
                $country  =  self::getCountryCodeFromNetIP($ip);
            }
        }else{
            return false;
        }
        $base_url  = site_url();

        if($base_url == 'https://my.forexmart.eu/'){
            return true;
        }else{

            /*new EU list FXPP-9294
            *Austria,Italy,Belgium,Latvia,Bulgaria,Lithuania,Croatia,Luxemburg,Cyprus,Malta,Czech Republic,Netherlands,Denmark,Poland,Estonia,Portugal,
            *Finland,Romania,France,Slovakia,Germany,Slovenia,Greece,Spain,Hungary,Sweden,Ireland, United Kingdom,
            */

            $europeanCountry = self::euCountryArray();

            if( in_array(strtoupper(FXPP::html_url()),$europeanCountry) || in_array(strtoupper($country),$europeanCountry)  ){
                return true;
            }else{
                return false;
            }

        }

    }

    public static function isEuropeanCountry($country_code=null){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $country = getCountryFromIP($ip);
            //added validation for invalid code
            $invalid_code = array('ZZ');
            if(in_array(strtoupper($country),$invalid_code)){
                $country  =  self::getCountryCodeFromNetIP($ip);
            }
        }else{
            $country = '';
        }

        /*        Bulgaria,    Czech Republic,    United Kingdom,    Spain,    France,    Germany,    Poland,    Portugal*/
        // $europeanCountry = array('BG','CZ','GB','ES','FR','DE','PL','PT','EN','CS');
        $europeanCountry = self::euCountryArray();

        if(in_array(strtoupper($country_code),$europeanCountry)){
            return true;
        }

        if(in_array(strtoupper($country),$europeanCountry)){
            // return true;  // it will check only country code
        }
        return false;

//        if( !in_array(strtoupper(FXPP::html_url()),$europeanCountry) || !in_array(strtoupper($country),$europeanCountry) || !in_array(strtoupper($country_code),$europeanCountry)  ){
//            return true;
//        }else{
//            return false;
//        }
    }


    public  function isIPandLanguageChina()
    {
        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {
            $country = getCountryFromIP($ip);
        } else {
            $country = 'Invalid';
        }

        if (strtoupper($country) == 'CN') {
            $res = true;
        }else if(FXPP::html_url() == 'zh' ){
            $res = true;
        }else{
            $res = false;
        }
        return  $res;
    }

    public function isProgrammersIP(){
        $ip=FXPP::CI()->input->ip_address();

        $data['StaticIP'] = array(
            '210.213.232.29', // venus
        );

        if(in_array($ip, $data['StaticIP'])) {
            return true;
        }else{
            return false;
        }
    }
    public function ManagersIP(){
        $ip=FXPP::CI()->input->ip_address();

        $data['StaticIP'] = array(
            '83.219.143.110', //FXPP-11195
        );

        if(in_array($ip, $data['StaticIP'])) {
            return true;
        }else{
            return false;
        }
    }

    public static function blacklistIPs(){
        FXPP::CI()->load->library('general_model');
        $ip = FXPP::CI()->input->ip_address();

        if($ip_list = FXPP::CI()->general_model->where("blacklist_ip",array('ip'=>$ip))){
            return false;
        }
        return true;
    }

    public static function blacklistEmail($email=null){
        FXPP::CI()->load->library('general_model');

        if($ip_list = FXPP::CI()->general_model->where("blacklist_email",array('email'=>$email))){
            return false;
        }
        return true;
    }


    public static function for_eu_country(){
        require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        if(FXPP::CI()->input->valid_ip($ip)){
            $country = getCountryFromIP($ip);
        }else{
            $country = '';
        }

        $data['StaticIP'] = array(
            '210.213.232.29', // venus
        );

        $europeanCountry = self::euCountryArray();

        if(in_array(strtoupper($country),$europeanCountry)){
            return true;
        }else if(in_array($ip, $data['StaticIP'])) {
            return true;
        }else{
            return false;
        }

    }

    public static function euCountryArray(){
        /* Austria, Belgium, Bulgaria, Croatia, Republic of Cyprus, Czech Republic, Denmark, Estonia, Finland, Germany, Greece, Hungary, Ireland, Italy, Lithuania, Luxembourg, Malta, Netherlands, Poland, Portugal, Romania, Slovakia, Slovenia, Spain, Sweden and the UK,France,France Metropolitan, Latvia . */
        return array('AT','BE','BG','HR','CY','CZ','DK','EE','FI','DE','GR','HU','IE','IT','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE','GB','LV','FR','FX','NO','CH','IS',);
    }

    public static function isEuropeanCountryByCode($country_code=null){

        /* Austria, Bulgaria, Croatia, Republic of Cyprus, Czech Republic, Denmark, Estonia, Finland, Germany, Greece, Hungary, Ireland, Italy, Lithuania, Luxembourg, Malta, Netherlands, Poland, Portugal, Romania, Slovakia, Slovenia, Spain, Sweden and the UK. */
        $europeanCountry = self::euCountryArray();

        if(in_array(strtoupper($country_code),$europeanCountry)){
            return true;
        }
        return false;

    }


    public function getCountryCodeFromNetIP($ip){
        //alternative service, limited to  1,000 API requests per day
        //$ip = $_SERVER['REMOTE_ADDR'];
        $response = @file_get_contents('http://www.netip.de/search?query=' . $ip);
        $patterns = array();
        $patterns["country"] = '#Country: (.*?)&nbsp;#i';

        $ipInfo = array();

        foreach ($patterns as $key => $pattern) {
            $ipInfo[$key] = preg_match($pattern, $response, $value) && !empty($value[1]) ? $value[1] : 'not found';
        }

        $country_code = explode(' - ',$ipInfo['country']); //  explode string with white spaces

        return $country_code[0]; //return country code only

    }

    public static function getCountryCodeFromIP($ip=null){
        require_once APPPATH.'/helpers/geoiploc.php';
        try{
            return strtoupper(getCountryFromIP($ip));
        }catch (Exception $e){
            return 'ZZ';
        }
    }

    public static function PHDevIP(){
        $CI =& get_instance();

        $ip = $CI->input->ip_address();

        $staticIP = array(
            '210.213.232.29',
        );

        if(in_array($ip, $staticIP)){
            return true;
        }

        return false;
    }
    public static function allowableCountry( array $country_array)
    {
        require_once APPPATH . '/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        if (FXPP::CI()->input->valid_ip($ip)) {
            $country = getCountryFromIP($ip);
        } else {
            $country = '';
        }

        $data['StaticIP'] = array(
           // '115.127.83.18',
        );
		if(IPloc::IPOnlyForVenus()){
			$country = 'FR';
		}


        if (in_array(strtoupper($country), $country_array)) {
            return true;
        } else if (in_array($ip, $data['StaticIP'])) {
            return true;
        } else {
            return false;
        }

    }

    public static function getCountryCode($ip){
               
        
//        
//                FXPP::CI()->load->library('FXIP');
//                return  FXIP::getCountryCode($ip);	 
                
                
                $ip_data=array("::1","127.0.0.1","localhost");
                
                if(in_array($ip,$ip_data))
                {
                    return "GB"; 
                }else{
                    FXPP::CI()->load->library('FXIP');
                    return FXIP::getCountryCode($ip);
                }

    }
    public static function OnlyTest(){

        $ip = FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '182.163.102.47',
            '210.213.232.29',
            '78.46.190.237',
            '159.69.88.248',
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function OnlyTest2(){

        $ip = FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '83.219.143.110',
            '182.163.102.47',
            '58.145.189.248',
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        } else {
            return false;
        }
	}
	
	public static function OpenAccounts(){

        $account_number = FXPP::CI()->session->userdata('account_number');
        $account_array = array(
            58028034,109369
        );

        if (in_array($account_number, $account_array)) {
            return true;
        } else {
            return false;
        }
    }

    public static function OnlyTest_z(){

        $ip = FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '159.69.88.248',
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        } else {
            return false;
        }
	}

    public static function IPForG()
    {
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '49.12.5.139',
            '120.29.75.242',
            '49.12.37.45', //tobias
            '159.69.88.248' //check
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        }
        return false;

    }

    public static function JustG()
    {
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip = FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '49.12.5.139',
			'93.171.143.94'
        );

        if (in_array($ip, $data['StaticIP'])) {
            return true;
        }
        return false;

    }

    public static function VPN_IP_Jenalie(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '195.201.40.47',
            '95.217.153.171',   //VPN IP = Sergey Spiridonov (QA)
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }

        return false;
    }

    public static function ForJenalieOnly(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '195.201.40.47',
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }

        return false;
    }
    
    public static function frz($just_frz=false){
        $ip=FXPP::CI()->input->ip_address();
        
        
        $data['StaticIP'] = array(
            '49.12.5.139',
        );

        if($just_frz){
        
            if(in_array($ip, $data['StaticIP'])){
                
               $frz_email=array('firozur@m.insta.kim','keystationfrz@gmail.com','f.7.live.co@gmail.com','forexmartthinkbigtrade@gmail.com');
               
                if(in_array(FXPP::CI()->session->userdata('email'), $frz_email))
                {  
                    return true;
                    
                }else{
                     if(isset($_GET['frz'])=='frz')
                     { 
                         return true;
                     }else{
                    return false;
                     }
                }
                
            }else{
                return false;
            }
            
        }else{
             if(in_array($ip, $data['StaticIP'])){
                return true;
            }else{
                return false;
            }
            
        }
    }

    
 public static function frzPM(){
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '49.12.5.139',
            '49.12.37.45', //tobias
            '138.201.153.118',
            '192.168.30.35',  // Alexandr Durmanov
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }
    
 public static function isReomveReadOnly(){
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '49.12.5.139', //Armando
            '49.12.37.45', //tobias 
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }else{
            return false;
        }
    }    
	public static function APIUpgradeDevIP(){
		$ip = FXPP::CI()->input->ip_address();
		$VPN_IPs = array(
			"78.46.190.237", //Menux
			"120.29.75.242", //Joya
			"195.201.40.47", //Jena
			"49.12.5.139", //Arman
			"49.12.42.32", //jayson
			"95.217.153.171" // Tester


		);

		if(in_array($ip, $VPN_IPs)){
		    return true;
        }elseif(self::Office()){
            return true;
        }else{
		    return false;
        }

	}

    public static function StatusTask(){
        $ip = FXPP::CI()->input->ip_address();
        $VPN_IPs = array(
            "195.201.40.47", //Jena
        );

        return (in_array($ip, $VPN_IPs)) ? true : false;
    }
	    public static function RolloverTest(){
        // require_once APPPATH.'/helpers/geoiploc.php';
        $ip=FXPP::CI()->input->ip_address();
        $data['StaticIP'] = array(
            '195.201.40.47',
            '78.46.190.237',
            '95.217.153.171',   //VPN IP = Sergey Spiridonov (QA)
            '49.12.42.32', //Jimmy'
        );

        if(in_array($ip, $data['StaticIP'])){
            return true;
        }

        return false;
    }
}

