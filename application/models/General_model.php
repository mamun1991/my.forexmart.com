<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model
{	
	function __construct(){
		parent::__construct();

	}
    function difference_day($date1,$date2){
        $split1 = explode("-", $date1);
        $dates1  = $split1[2];	$month1 = $split1[1]; $year1  = $split1[0];

        $split2 = explode("-", $date2);
        $dates2 = $split2[2]; $month2 = $split2[1]; $year2 =  $split2[0];

        $gtj1 = GregorianToJD($month1, $dates1, $year1);
        $gtj2 = GregorianToJD($month2, $dates2, $year2);

        $diff_day = $gtj2 - $gtj1;

        return $diff_day;
    }
    function showssingle($table,$field="",$id="",$select="",$order_by=""){
        
        if($field == 'user_id' || $field == 'id'){
            $id = (int)$id;
        }
        
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($field, $id);
        $this->db->limit(1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    
    
    
     public function getSocialID($social_user_id,$login_type){
                
        $sql = "select * from users where social_user_id=? and login_type=? order by id desc limit 1";        
                                
        $query = $this->db->query($sql,array($social_user_id,$login_type));        
                                
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }         
    } 
    
    
    function whereCondition($table, $conditon,$select="*"){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($conditon);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function showssingle2($table,$field="",$id="",$select="",$order_by=""){
        if($field == 'user_id' || $field == 'id'){
            $id = (int)$id;
        }
       
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($field, $id);
        $this->db->limit(1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function showssingletwo($table,$field="",$id="",$field2="",$id2="",$field3="",$id3="",$select="",$order_by=""){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($field, $id);
        $this->db->where($field2, $id2);
        $this->db->where($field3, $id3);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function updatemy($table,$field,$id,$data){
        if($field == 'user_id' || $field == 'id'){
            $id = (int)$id;
        }
        $this->db->where($field, $id);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }

    function showt1w1j2($table,$table2,$select="",$field0,$id0,$join12){
        $this->db->select($select);
        $this->db->where($field0, $id0);
        $this->db->from($table);
        $this->db->join($table2 ,$join12);
        $query =  $this->db->get();
        return $query->result_array();
    }
    function showt1w1($table,$field="",$id="",$select="",$order_by=""){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($field, $id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function showssingle3($table,$field="",$id="",$field2="",$id2="",$select="",$order_by=""){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($field, $id);
        $this->db->where($field2, $id2);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
	function insert($table,$data){
		$this->db->insert($table,$data);
        return $this->db->insert_id();
	}
	function update($table,$field,$id,$data){
		$this->db->where($field, $id);
		$this->db->update($table, $data);
	}
	function delete($table,$field,$id){

        $this->db->trans_start();
		$this->db->delete($table, array($field => $id));
        $this->db->trans_complete();
	}

    function delete2($table,$field,$id,$field2,$id2){
        $this->db->trans_start();
        $this->db->delete($table, array($field => $id,$field2 => $id2));
        $this->db->trans_complete();
    }

    public function getData($select,$table='', $where){
        $result = $this->db->select($select)
            ->get_where($table,$where);
        return ($result && $result->num_rows()>0) ? $result->row() : '';

    }
    function conditionalDelete($table,$condition){

        $this->db->trans_start();
        $this->db->delete($table, $condition);
        $this->db->trans_complete();
    }
	function show($table,$field="",$id="",$select="",$order_by=""){

        $this->db->trans_start();
		if(!$select){ $select ="*"; } $this->db->select($select);
		if($order_by){ $orderby = explode(',',$order_by); $this->db->order_by($orderby[0],$orderby[1]); } 
		if($id) { $result = $this->db->get_where($table, array($field => $id)); 
		} else { $result = $this->db->get($table);}
	

        $this->db->trans_complete();
        return $result;
	}
	function showWhere2($table,$field1="",$id1="",$field2="",$id2="",$order_by=""){

        $this->db->trans_start();
		$this->db->where($field1, $id1);
		$this->db->where($field2, $id2);
		if($order_by){ $orderby = explode(',',$order_by); $this->db->order_by($orderby[0],$orderby[1]); } 
		$result = $this->db->get($table);	
		return $result;
        $this->db->trans_complete();
	}

	function getTimezones($company_id=""){

		if($this->session->userdata('logged_in')){
            $localization = $this->show('locale_table','company_id',$this->session->userdata('company_id'));
        }else{
			$localization = $this->show('locale_table','company_id',$company_id);	
		}
		if($localization->num_rows() >0){
			$get_tz= $localization->row()->timezone;
				if($get_tz){
					$get_tzx = $get_tz;
					}else{			
					$get_tzx = ini_get('date.timezone');	
					}
			return date_default_timezone_set($get_tzx); 
		}

	}
	function numberFormat($number,$type=""){
	    $number = str_replace(" ","",$number);
		if($type =="nf1"){
			$number = number_format($number,2,".",","); 
		}else if($type =="nf2"){
			$number = number_format($number,2,".",", ");
			$number = str_replace(',',', ',$number);
		}else if($type =="nf3"){
			$number = number_format($number,2,"."," "); 
		}else if($type =="nf4"){
			$number = number_format($number,2,",","."); 
		}else if($type =="nf5"){
			$number = number_format($number,2,",",". "); 
			$number = str_replace('.','. ',$number);
		}else if($type =="nf6"){
			$number = number_format($number,2,","," "); 
		}else if($type =="nf7"){
			$number = number_format($number,0,"",""); 
		}else if($type =="nf8"){
			$number = number_format($number,0,"",","); 
		}else if($type =="nf9"){
			$number = number_format($number,0,"","."); 
		}else if($type =="nf10"){
			$number = number_format($number,0,""," "); 
		}
		return $number;

	}

	function dateFormat($date,$type=""){
		$exp = explode('-',$date);
		if((count($exp) == 3)&&($type !='')) {
			 $date = new DateTime($date);
			 $date = date_format($date, $type); 			
		}
		return $date;

	}
	function convertDateSql($date,$type=""){
		$exp = explode('/',$date);
		if(count($exp) == 3) {  
			if($type=="1"){               
				$date = $exp[2].'-'.$exp[0].'-'.$exp[1];    		// mm/dd/yy -> yy-mm-dd
			}else{
				$date = $exp[2].'-'.$exp[1].'-'.$exp[0];			// dd/mm/yy -> yy-mm-dd
			}
		}	
		return $date;

	}
	function convertDateStr($date,$type=""){
		$exp = explode('-',$date);
		if(count($exp) == 3) {		
			if($type=='1'){
				$date = $exp[1].'-'.$exp[2].'-'.$exp[0];  			//=> 08-29-2014
			}else if($type=='2'){				
				$d = $exp[2]; $p='';
				if(($d ==1)||($d ==21)||($d ==31)){
					$p = 'st'; 
				}else if(($d ==2)||($d ==22)){
					$p = 'nd';
				}else if(($d ==3)||($d ==23)){
					$p = 'rd';
				}else{
					$p = 'th';
				}
				$date = $exp[2].$p.' of '.$this->get_month($exp[1]).' '.$exp[0];  			//=> 17th of October 2014
			}
			else{
				$date = $exp[2].'/'.$exp[1].'/'.$exp[0];  			//=> 29/08/2014
			}
		}
		return $date;

	}
	function convertDtime($date_time,$type=""){

		$exp_date_time = explode(" ",$date_time);
		$get_date = $exp_date_time[0];	$get_time =$exp_date_time[1];
		
		$exp_date = explode("-",$get_date);
		$year =$exp_date[0];	$month =$exp_date[1]; $date =$exp_date[2];

		$exp_time = explode(":",$get_time);
		$hours =$exp_time[0]; $minute =$exp_time[1];
			
		if($type==""){	
			$new_date_time = $date."-".$month."-".$year." ".$get_time;								//=> 29-08-2014 08:03:22
		}else if($type==1){	
			$new_date_time = $year."-".$month."-".$date;											//=> 2014-08-27
		}else if($type==2){	
			$new_date_time = $date."/".$month."/".$year." ".date("g:i a", strtotime($get_time));  //=> 28/08/2014 11:18 am
		}
			return $new_date_time;

	}
	function differenceDay($date1,$date2){

		$split1 = explode("-", $date1);
		$dates1  = $split1[2];	$month1 = $split1[1]; $year1  = $split1[0];			 
							 
		$split2 = explode("-", $date2);
		$dates2 = $split2[2]; $month2 = $split2[1]; $year2 =  $split2[0];			
				 
		$gtj1 = GregorianToJD($month1, $dates1, $year1);
		$gtj2 = GregorianToJD($month2, $dates2, $year2);			 
							 
		$diff_day = $gtj2 - $gtj1;
				 
		return $diff_day;
    }

	function getMonth($month){
		switch ($month){
				case $month=='01':
					$month="January";
					break;
				case $month=='02':
					$month="February";
					break;
				case $month=='03':
					$month="March";
					break;
				case $month=='04':
					$month="April";
					break;
				case $month=='05':
					$month="May";
					break;
				case $month=='06':
					$month="June";
					break;
				case $month=='07':
					$month="July";
					break;
				case $month=='08':
					$month="August";
					break;
				case $month=='09':
					$month="September";
					break;
				case $month=='10':
					$month="October";
					break;
				case $month=='11':
					$month="November";
					break;
				case $month=='12':
					$month="December";
					break;
				}
		return $month;
	}

    function getCountries($country_id="")
    {
        $countries = array(
            "GB" => "United Kingdom",
            /* "US" => "United States",*/
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic Of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia (Local Name: Hrvatska)",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TP" => "East Timor",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "FX" => "France, Metropolitan",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard And Mc Donald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran (Islamic Republic Of)",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic Of",
            /*"KR" => "Korea, Republic Of",*/
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            "MK" => "Macedonia, Former Yugoslav Republic Of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States Of",
            "MD" => "Moldova, Republic Of",
            "MC" => "Monaco",
            "MN" => "Mongolia",

            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            /*  "MM" => "Myanmar",*/
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            "VC" => "Saint Vincent And The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia (Slovak Republic)",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia, South Sandwich Islands",
			"KS" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SH" => "St. Helena",
            "PM" => "St. Pierre And Miquelon",
            /* "SD" => "Sudan",*/
            "SR" => "Suriname",
            "SJ" => "Svalbard And Jan Mayen Islands",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            /* "SY" => "Syrian Arab Republic",*/
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic Of",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands (British)",
            "VI" => "Virgin Islands (U.S.)",
            "WF" => "Wallis And Futuna Islands",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
//            "YU" => "Yugoslavia",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );
        if($country_id){
            return isset($countries[$country_id])?$countries[$country_id]:false;
        }else{
            return $countries;
        }
    }

	function getCurrency($currency_id="")
    {
        $currency = array (
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        );
		if($currency_id){ 
			return isset($currency[$currency_id])?$currency[$currency_id]:false;
		}else{
			return $currency;
			}
    }
    
    function sendEmail($file_name, $subject, $email, $data, $configemail = null)
    {  $this->load->library('Fx_mailer');

        $html = $this->load->view('email/' . $file_name, $data, TRUE);
        if($error_info = Fx_mailer::FMsender($email,$subject,$html) === true){
            return true;
        }

        $email_error = array("email"=>$email, "logs"=>$error_info,"subject"=>$subject,'html'=>$html);
        $this->insert('email_error_logs', $email_error);

        Fx_mailer::FXsendEmail($email,$subject,$html);
        return true;  // Just for checking.


       
    }

    function sendEmail_old($file_name, $subject, $email, $data,$configemail=null)
    {
        $this->config->load('tank_auth');
        $this->load->library('email');
        if($configemail != null){
            $this->email->initialize($configemail);
        }

        $this->email->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($this->load->view('email/'.$file_name, $data, TRUE));
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $this->email->send();
        }
        else{
            return false;
        }



    }

    function sendEmailAttachment($file_name, $subject, $email, $data,$configemail=null, $attachment_path = '', $attachment_file_name = ''){
        $this->config->load('tank_auth');
        $this->load->library('email');
        if($configemail != null){
            $this->email->initialize($configemail);
        }

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($this->load->view('email/'.$file_name, $data, TRUE));
        $this->email->attach($attachment_path, 'attachment', $attachment_file_name);
        $this->email->send();
    }

    function sendProfileEmail($file_name, $subject, $email, $data,$configemail=null)
    {
        $this->config->load('tank_auth');
        $this->load->library('email');
        if($configemail != null){
            $this->email->initialize($configemail);
        }

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
//        $this->email->cc('armando@zetaol.com');
        $this->email->subject($subject);
        $this->email->message($this->load->view('email/'.$file_name, $data, TRUE));
        $this->email->send();

    }


    function getLanguage($id=null){
        $language_codes = array(
            'en' => 'English' ,
            'aa' => 'Afar',
            'ab' => 'Abkhazian' ,
            'af' => 'Afrikaans' ,
            'am' => 'Amharic' ,
            'ar' => 'Arabic' ,
            'as' => 'Assamese' ,
            'ay' => 'Aymara' ,
            'az' => 'Azerbaijani' ,
            'ba' => 'Bashkir' ,
            'be' => 'Byelorussian' ,
            'bg' => 'Bulgarian' ,
            'bh' => 'Bihari' ,
            'bi' => 'Bislama' ,
            'bn' => 'Bengali/Bangla' ,
            'bo' => 'Tibetan' ,
            'br' => 'Breton' ,
            'ca' => 'Catalan' ,
            'co' => 'Corsican' ,
            'cz' => 'Czech' ,/*added*/
            'cs' => 'Czech' ,
            'cy' => 'Welsh' ,
            'da' => 'Danish' ,
            'de' => 'German' ,
            'dz' => 'Bhutani' ,
            'el' => 'Greek' ,
            'eo' => 'Esperanto' ,
            'es' => 'Spanish' ,
            'et' => 'Estonian' ,
            'eu' => 'Basque' ,
            'fa' => 'Persian' ,
            'fi' => 'Finnish' ,
            'fj' => 'Fiji' ,
            'fo' => 'Faeroese' ,
            'fr' => 'French' ,
            'fy' => 'Frisian' ,
            'ga' => 'Irish' ,
            'gd' => 'Scots/Gaelic' ,
            'gl' => 'Galician' ,
            'gn' => 'Guarani' ,
            'gu' => 'Gujarati' ,
            'ha' => 'Hausa' ,
            'hi' => 'Hindi' ,
            'hr' => 'Croatian' ,
            'hu' => 'Hungarian' ,
            'hy' => 'Armenian' ,
            'ia' => 'Interlingua' ,
            'ie' => 'Interlingue' ,
            'ik' => 'Inupiak' ,
            'in' => 'Indonesian' ,
            'is' => 'Icelandic' ,
            'it' => 'Italian' ,
            'iw' => 'Hebrew' ,
            'ja' => 'Japanese' ,
            'ji' => 'Yiddish' ,
            'jw' => 'Javanese' ,
            'ka' => 'Georgian' ,
            'kk' => 'Kazakh' ,
            'kl' => 'Greenlandic' ,
            'km' => 'Cambodian' ,
            'kn' => 'Kannada' ,
            'ko' => 'Korean' ,
            'ks' => 'Kashmiri' ,
            'ku' => 'Kurdish' ,
            'ky' => 'Kirghiz' ,
            'la' => 'Latin' ,
            'ln' => 'Lingala' ,
            'lo' => 'Laothian' ,
            'lt' => 'Lithuanian' ,
            'lv' => 'Latvian/Lettish' ,
            'mg' => 'Malagasy' ,
            'mi' => 'Maori' ,
            'mk' => 'Macedonian' ,
            'ml' => 'Malayalam' ,
            'mn' => 'Mongolian' ,
            'mo' => 'Moldavian' ,
            'mr' => 'Marathi' ,
            'ms' => 'Malay' ,
            'mt' => 'Maltese' ,
            'my' => 'Burmese' ,
            'na' => 'Nauru' ,
            'ne' => 'Nepali' ,
            'nl' => 'Dutch' ,
            'no' => 'Norwegian' ,
            'oc' => 'Occitan' ,
            'om' => '(Afan)/Oromoor/Oriya' ,
            'pa' => 'Punjabi' ,
            'pl' => 'Polish' ,
            'ps' => 'Pashto/Pushto' ,
            'pt' => 'Portuguese' ,
            'qu' => 'Quechua' ,
            'rm' => 'Rhaeto-Romance' ,
            'rn' => 'Kirundi' ,
            'ro' => 'Romanian' ,
            'ru' => 'Russian' ,
            'rw' => 'Kinyarwanda' ,
            'sa' => 'Sanskrit' ,
            'sd' => 'Sindhi' ,
            'sg' => 'Sangro' ,
            'sh' => 'Serbo-Croatian' ,
            'si' => 'Singhalese' ,
            'sk' => 'Slovak' ,
            'sl' => 'Slovenian' ,
            'sm' => 'Samoan' ,
            'sn' => 'Shona' ,
            'so' => 'Somali' ,
            'sq' => 'Albanian' ,
            'sr' => 'Serbian' ,
            'ss' => 'Siswati' ,
            'st' => 'Sesotho' ,
            'su' => 'Sundanese' ,
            'sv' => 'Swedish' ,
            'sw' => 'Swahili' ,
            'ta' => 'Tamil' ,
            'te' => 'Tegulu' ,
            'tg' => 'Tajik' ,
            'th' => 'Thai' ,
            'ti' => 'Tigrinya' ,
            'tk' => 'Turkmen' ,
            'tl' => 'Tagalog' ,
            'tn' => 'Setswana' ,
            'to' => 'Tonga' ,
            'tr' => 'Turkish' ,
            'ts' => 'Tsonga' ,
            'tt' => 'Tatar' ,
            'tw' => 'Twi' ,
            'uk' => 'Ukrainian' ,
            'ur' => 'Urdu' ,
            'uz' => 'Uzbek' ,
            'vi' => 'Vietnamese' ,
            'vo' => 'Volapuk' ,
            'wo' => 'Wolof' ,
            'xh' => 'Xhosa' ,
            'yo' => 'Yoruba' ,
            'zh' => 'Chinese' ,
            'zu' => 'Zulu' ,
        );
        if(!is_null($id)){
            return isset($language_codes[$id])?$language_codes[$id]:false;
        }else{
            return $language_codes;
        }
    }

    function getAccountTypeGroup($id=null){

        $data= array(
            '1' =>"ForexMart Standard",
            '2' => "ForexMart Zero Spread",
            '4' => "ForexMart Micro",
            '5' => 'ForexMart Classic',
            '6' => 'ForexMart Pro',
            '7' => 'ForexMart Cents',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }


    }



//    function getAccountType($id=null){
//
//        $data= array(
//            '1' =>"ForexMart Standard",
//            '2' => "ForexMart Zero Spread",
//            '4' => "ForexMart Micro Account"
//        );
//
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//
//    }

    function getNewAccountType($id = null)
    {
//        if (!IPLoc::Office()) {
//            return self::getAccountType($id = null);
//        }

        $data = array(
            '5' => 'ForexMart Classic',
            '6' => 'ForexMart Pro',
            '7' => 'ForexMart Cents',
            '2' => lang('reg_acct_type2'),
        );


        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

    function getNewAccountTypeBD($id = null)
    {
//        if (!IPLoc::Office()) {
//            return self::getAccountType($id = null);
//        }

        $data = array(
            '1' => lang('reg_acct_type1'),
            '5' => 'ForexMart Classic',
            '6' => 'ForexMart Pro',
            '7' => 'ForexMart Cents',
            '2' => lang('reg_acct_type2'),
        );


        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

    function getAccountType($id = null)
    {
        $this->lang->load('registration');
        // if(IPLoc::Office()){
        $data = array(
            '1' => lang('reg_acct_type1'),
            '2' => lang('reg_acct_type2'),
            '4' => lang('reg_acct_type3')
        );
        // }else {
        //     $data = array(
        //         '1' => lang('reg_acct_type1'),
        //         '2' => lang('reg_acct_type2')
        //     );
        // }


        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

    function getAccountCurrencyBase3($id=null){
        $data= array(
            'EUR' =>"EUR",
            'USD' => "USD",
            'GBP' => "GBP",
            'MYR' => "MYR",
            'IDR' => "IDR",
            'THB' => "THB",
            'CNY' => "CNY",
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }

    function getAccountCurrencyBase($id=null){

        $data= array(
            'EUR' =>"EUR",
            'USD' => "USD",
            'GBP' => "GBP",
            'RUB' => "RUB",
            'MYR' => "MYR",
            'IDR' => "IDR",
            'THB' => "THB",
            'CNY' => "CNY",
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getFCVolume($id=null){
        $data= array(
            '0.1' => '0.1',
            '1'=>'1',
            '10'=>'10',
            '100'=>'100',
            '1000'=>'1000',
            '10000'=>'10000',
            '100000'=>'100000',
            '1000000'=>'1000000',
            '10000000'=>'10000000',
            '100000000'=>'100000000',
            '1000000000'=>'1000000000',
            '10000000000'=>'10000000000',
            '100000000000'=>'100000000000',
        );
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }
    }
    function getFCLeverage($id=null){
        // FXPP-794
        $data= array(
             '1:1' => "1:1",
             '1:2' => "1:2",
             '1:3' => "1:3",
             '1:5' => "1:5",
            '1:10' => "1:10",
            '1:20' => "1:20",
            '1:25' => "1:25",
            '1:30' => "1:30",
            '1:50' => "1:50",
            '1:66' => "1:66",
           '1:100' => "1:100",
           '1:125' => "1:125",
           '1:150' => "1:150",
           '1:175' => "1:175",
           '1:200' => "1:200",
           '1:300' => "1:300",
           '1:400' => "1:400",
           '1:500' => "1:500",
           '1:600' => "1:600",
          '1:1000' => "1:1000",
            '1:5000' => "1:5000",
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }

    function getCurrenciesPairFI($currency_id=""){
        //reference https://www.forexmart.com/financial-instruments
        $currency = array (
            'USDJPY'=> 'USD/JPY',
            'USDCHF'=> 'USD/CHF',
            'USDCAD'=> 'USD/CAD',
            'AUDUSD'=> 'AUD/USD',
            'NZDUSD'=> 'NZD/USD',
            'EURJPY'=> 'EUR/JPY',
            'EURCHF'=> 'EUR/CHF',
            'EURGBP'=> 'EUR/GBP',
            'AUDCAD'=> 'AUD/CAD',
            'AUDCHF'=> 'AUD/CHF',
            'AUDJPY'=> 'AUD/JPY',
            'CADCHF'=> 'CAD/CHF',
            'CADJPY'=> 'CAD/JPY',
            'CHFJPY'=> 'CHF/JPY',
            'NZDCAD'=> 'NZD/CAD',
            'NZDCHF'=> 'NZD/CHF',
            'NZDJPY'=> 'NZD/JPY',
            'EURAUD'=> 'EUR/AUD',
            'GBPCHF'=> 'GBP/CHF',
            'GBPJPY'=> 'GBP/JPY',
            'AUDNZD'=> 'AUD/NZD',
            'EURCAD'=> 'EUR/CAD',
            'EURNZD'=> 'EUR/NZD',
            'GBPAUD'=> 'GBP/AUD',
            'GBPCAD'=> 'GBP/CAD',
            'GBPNZD'=> 'GBP/NZD',
            'USDDKK'=> 'USD/DKK',
            'USDNOK'=> 'USD/NOK',
            'USDSEK'=> 'USD/SEK',
            'USDZAR'=> 'USD/ZAR',
            'AUDCZK'=> 'AUD/CZK',
            'AUDDKK'=> 'AUD/DKK',
            'AUDHKD'=> 'AUD/HKD',
            'AUDHUF'=> 'AUD/HUF',
            'AUDMXN'=> 'AUD/MXN',
            'AUDNOK'=> 'AUD/NOK',
            'AUDPLN'=> 'AUD/PLN',
            'AUDSEK'=> 'AUD/SEK',
            'AUDSGD'=> 'AUD/SGD',
            'AUDZAR'=> 'AUD/ZAR',
            'CADCZK'=> 'CAD/CZK',
            'CADDKK'=> 'CAD/DKK',
            'CADHKD'=> 'CAD/HKD',
            'CADHUF'=> 'CAD/HUF',
            'CADMXN'=> 'CAD/MXN',
            'CADNOK'=> 'CAD/NOK',
            'CADPLN'=> 'CAD/PLN',
            'CADSEK'=> 'CAD/SEK',
            'CADSGD'=> 'CAD/SGD',
            'CADZAR'=> 'CAD/ZAR',
            'CHFCZK'=> 'CHF/CZK',
            'CHFDKK'=> 'CHF/DKK',
            'CHFHKD'=> 'CHF/HKD',
            'CHFHUF'=> 'CHF/HUF',
            'CHFMXN'=> 'CHF/MXN',
            'CHFNOK'=> 'CHF/NOK',
            'CHFPLN'=> 'CHF/PLN',
            'CHFSEK'=> 'CHF/SEK',
            'CHFSGD'=> 'CHF/SGD',
            'CHFZAR'=> 'CHF/ZAR',
            'EURCZK'=> 'EUR/CZK',
            'EURDKK'=> 'EUR/DKK',
            'EURHKD'=> 'EUR/HKD',
            'EURHUF'=> 'EUR/HUF',
            'EURMXN'=> 'EUR/MXN',
            'EURNOK'=> 'EUR/NOK',
            'EURPLN'=> 'EUR/PLN',
            'EURSEK'=> 'EUR/SEK',
            'EURSGD'=> 'EUR/SGD',
            'EURZAR'=> 'EUR/ZAR',
            'GBPCZK'=> 'GBP/CZK',
            'GBPDKK'=> 'GBP/DKK',
            'GBPHKD'=> 'GBP/HKD',
            'GBPHUF'=> 'GBP/HUF',
            'GBPMXN'=> 'GBP/MXN',
            'GBPNOK'=> 'GBP/NOK',
            'GBPPLN'=> 'GBP/PLN',
            'GBPSEK'=> 'GBP/SEK',
            'GBPSGD'=> 'GBP/SGD',
            'GBPZAR'=> 'GBP/ZAR',
            'NZDCZK'=> 'NZD/CZK',
            'NZDDKK'=> 'NZD/DKK',
            'NZDHKD'=> 'NZD/HKD',
            'NZDHUF'=> 'NZD/HUF',
            'NZDMXN'=> 'NZD/MXN',
            'NZDNOK'=> 'NZD/NOK',
            'NZDPLN'=> 'NZD/PLN',
            'NZDSEK'=> 'NZD/SEK',
            'NZDSGD'=> 'NZD/SGD',
            'NZDZAR'=> 'NZD/ZAR',
            'USDCZK'=> 'USD/CZK',
            'USDHKD'=> 'USD/HKD',
            'USDHUF'=> 'USD/HUF',
            'USDMXN'=> 'USD/MXN',
            'USDSGD'=> 'USD/SGD',
            'USDPLN'=> 'USD/PLN',
            'CZKJPY'=> 'CZK/JPY',
            'DKKJPY'=> 'DKK/JPY',
            'HKDJPY'=> 'HKD/JPY',
            'HUFJPY'=> 'HUF/JPY',
            'MXNJPY'=> 'MXN/JPY',
            'NOKJPY'=> 'NOK/JPY',
            'SGDJPY'=> 'SGD/JPY',
            'SEKJPY'=> 'SEK/JPY',
            'ZARJPY'=> 'ZAR/JPY',
            'USDRUB'=> 'USD/RUB',

            'EURUSD'=> 'EUR/USD',
            'GBPUSD'=> 'GBP/USD',
            'GBPPLN'=> 'GBP/PLN',
            'USDRUR'=> 'USD/RUR',


            '#AA'=> '#AA',
            '#AAL'=> '#AAL',
            '#AAPL'=> '#AAPL',
            '#AIG'=> '#AIG',
            '#AMZN'=> '#AMZN',
            '#AXP'=> '#AXP',
            '#BA'=> '#BA',
            '#BABA'=> '#BABA',
            '#BAC'=> '#BAC',
//            '#BARC'=> '#BARC',
            '#BLT'=> '#BLT',
            '#BP'=> '#BP',
            '#BTA'=> '#BTA',
            '#C'=> '#C',
            '#CAT'=> '#CAT',
            '#CSCO'=> '#CSCO',
            '#CVX'=> '#CVX',
            '#DD'=> '#DD',
            '#DIS'=> '#DIS',
            '#EBAY'=> '#EBAY',
            '#FB'=> '#FB',
            '#GEN'=> '#GEN',
            '#GOOG'=> '#GOOG',
            '#GS'=> '#GS',
            '#GSK'=> '#GSK',
            '#HD'=> '#HD',
            '#HPQ'=> '#HPQ',
//            '#HSBA'=> '#HSBA',
            '#IBM'=> '#IBM',
            '#INTC'=> '#INTC',
            '#JNJ'=> '#JNJ',
            '#JPM'=> '#JPM',
            '#KO'=> '#KO',
//            '#LLOY'=> '#LLOY',
            '#LNKD'=> '#LNKD',
            '#MCD'=> '#MCD',
            '#MMM'=> '#MMM',
            '#MRK'=> '#MRK',
            '#MSFT'=> '#MSFT',
            '#ORCL'=> '#ORCL',
            '#PFE'=> '#PFE',
            '#PG'=> '#PG',
            '#T'=> '#T',
            '#TRV'=> '#TRV',
            '#TSCO'=> '#TSCO',
            '#TWTR'=> '#TWTR',
            '#UTX'=> '#UTX',
            '#VOD'=> '#VOD',
            '#VZ'=> '#VZ',
            '#WFC'=> '#WFC',
            '#WMT'=> '#WMT',
            '#XOM'=> '#XOM',
            '#YHOO'=> '#YHOO',

            'XAUUSD'=> 'GOLD',
            'XAGUSD'=> 'SILVER',
            'XXAU/USD'=> 'XAU/USD',

        );
        if($currency_id){
            return isset($currency[$currency_id])?$currency[$currency_id]:false;
        }else{
            return $currency;
        }
    }


    function getLeverage($id=null, $limit = 500){


            $data = array(
                10,
                20,
                25,
                30,
                50,
                100,
                200,
                300,
                400,
                500,
            );


            $data_value = array(
                '1:10' => "1:10",
                '1:20' => "1:20",
                '1:25' => "1:25",
                '1:30' => "1:30",
                '1:50' => "1:50",
                '1:100' => "1:100",
                '1:200' => "1:200",
                '1:300' => "1:300",
                '1:400' => "1:400",
                '1:500' => "1:500",
            );



           /* $data = array(
                1,
                2,
                3,
                5,
                10,
                20,
                25,
                // 33,
                50,
                // 66,
                // 88,
                100,
                200,
                300,
                400,
                500,
                1000,
                3000,
                5000
            );

            $data_value = array(
                '1:1' =>"1:1",
                '1:2' => "1:2",
                '1:3' => "1:3",
                '1:5' => "1:5",
                '1:10' => "1:10",
                '1:20' => "1:20",
                '1:25' => "1:25",
                // '1:33' => "1:33",
                '1:50' => "1:50",
                // '1:66' => "1:66",
                // '1:88' => "1:88",
                '1:100' => "1:100",
                '1:200' => "1:200",
                '1:300' => "1:300",
                '1:400' => "1:400",
                '1:500' => "1:500",
                '1:1000' => "1:1000",
                '1:3000' => "1:3000",
                '1:5000' => "1:5000"
            );
        }*/

        if(FXPP::MTGroupMU() == 'mu'){
            array_push($data,1000);
            $limit = 1000;
          
         }


        if($id==null){
            $ret_data = array();
            foreach($data as $leverage){
                if( $leverage <= $limit ) {
                    $ret_data['1:' . $leverage] = '1:' . $leverage;
                }
            }
            return $ret_data;
        }else{
            return isset($data_value[$id])?$data_value[$id]:false;
        }

    }
    function getAmount($id=null){

        $data= array(
            '500' =>"500",
            '1000' => "1000",
            '3000' => "3000",
            '5000' => "5000",
            '10000' => "10000",
            '25000' => "25000",
            '50000' => "50000",
            '100000' => "100000",
            '500000' => "500000"

        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getEmploymentStatus($id = null)
    {
        $data = array(lang('empstat_1'),lang('empstat_2'),lang('empstat_3'),lang('empstat_4'),lang('empstat_5'));
        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

//    function getEmploymentStatus($id=null){
//        $data= array( "Employed","Self-employed","Retired","Student","Unemployed");
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//
//    }


    function getIndustry($id = null)
    {
//        if(IPLoc::Office()){
        $data = array(lang('industry_1'),lang('industry_2'),lang('industry_3'),lang('industry_4'),lang('industry_5'),lang('industry_6'),lang('industry_7'),lang('industry_8'),lang('industry_9'),lang('industry_10'),
            lang('industry_11'),lang('industry_12'),lang('industry_13'),lang('industry_14'),lang('industry_15'),lang('industry_16'),lang('industry_17'),lang('industry_18'),lang('industry_19'),lang('industry_20'),
            lang('industry_21'),lang('industry_22'),lang('industry_23'),lang('industry_24'),lang('industry_25'),lang('industry_26'),lang('industry_27') );
//        }else{
//            $data = array("Accountancy", "Admin/Secretarial", "Agriculture", "Finance Services - Banking", "Catering/Hospitality", "Creative/Media", "Education", "Emergency Services", "Engineering", "Financial Services - Others", "Health/Medicine", "HM Forces",
//                "HR", "Financial Services - Insurance", "IT", "Legal", "Leisure/Entertainment/Tourism", "Manufacturing", "Marketing/PR/Advertising", "Pharmaceuticals",
//                "Property/Constructions/Trades", "Retail", "Sales", "Social Care/Services", "Telecommunications", "Transport/Logistics", "Others");
//        }
        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

//    function getIndustry($id=null){
//        $data= array( "Accountancy","Admin/Secretarial","Agriculture","Finance Services - Banking","Catering/Hospitality","Creative/Media","Education","Emergency Services","Engineering","Financial Services - Others","Health/Medicine","HM Forces",
//            "HR","Financial Services - Insurance","IT","Legal","Leisure/Entertainment/Tourism","Manufacturing","Marketing/PR/Advertising","Pharmaceuticals",
//            "Property/Constructions/Trades","Retail","Sales","Social Care/Services","Telecommunications","Transport/Logistics","Others");
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//
//    }
    function getSourceOfFunds($id=null){
        $data= array( "Savings/Investments","Partner/Parent/Family","Benefits/Borrowing","Private Pension","State Pension","Other");
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getEstimatedAnnualIncome($id=null){
        $data= array( ">100,000","50,000 - 100,000","10,000 - 50,000","<10,000");
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getEstimatedNetWorth($id=null){
        $data= array( ">100,000","50,000 - 100,000","10,000 - 50,000","<10,000");
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
//    function getInvestmentKnowledge($id=null){
//        $data= array( "Non-exiting","Limited","Fair","Excellent");
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//
//    }

    function getInvestmentKnowledge($id = null)
    {
//        if(IPLoc::Office()){
        $data = array(lang('inv_know2'), lang('inv_know1'),lang('inv_know3'), lang('inv_know4'));
//        }else{
//            $data = array("Non-Existing", "Limited", "Fair", "Excellent");
//       }


        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }
    function getEducationLevel($id = null)
    {
//        if(IPLoc::Office()){
        $data = array(lang('educ_1'),lang('educ_2'),lang('educ_3'),lang('educ_4'),lang('educ_5'),lang('educ_6'));
//        }else{
//            $data = array("Elementary", "High School", "College/University", "Masters/PHD", "Professional Qualification","Financial related");
//        }

        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

//    function getEducationLevel($id=null){
//        $data= array( "Elementary","High School","College/University","Masters/PHD","Professional Qualification");
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//
//    }

//    function getTradeDuration($id=null){
//        $data= array( "Daily","Weekly","Monthly");
//        if($id==null){
//            return $data;
//        }else{
//            return isset($data[$id])?$data[$id]:false;
//        }
//    }

    function getTradeDuration($id = null)
    {
//        if(IPLoc::Office()){
        $data = array(lang('tradesel_1'), lang('tradesel_2'),lang('tradesel_3'),lang('tradesel_4'));
//        }else{
//            $data = array("Daily", "Weekly", "Monthly","Yearly");
//        }

        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }
    }

    function selectOptionList($data,$selected_val=null){
        $selectOption="";
        if(is_array($data)){

			$selected_text=true;
				if($selected_val==null or selected_val==""){
					$selectOption="<option value=''>Select</option>";
					$selected_text=false;
				}

            foreach($data as $key=>$d){
                
				$selected =($selected_text)?$selected_val == $key ? "selected":"":"";
				
                $selectOption= $selectOption."<option ".$selected." value='".$key."'>".$d."</option>";
            }
        }
        return $selectOption;
    }

    public function userType($id=null){
        $data= array(
            '0' =>"client",
            '1' => "partner",
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }
    }

    function getCallingCode($country_code){
        $countryCallingCodes = array
        (
            'Afghanistan' => '93',
            'Albania' => '355',
            'Algeria' => '213',
            'American Samoa' => '1 684',
            'Andorra' => '376',
            'Angola' => '244',
            'Anguilla' => '1264',
            'Antarctica' => '672',
            'Antigua and Barbuda' => '1268',
            'Antilles, Netherlands' => '599',
            'Argentina' => '54',
            'Armenia' => '374',
            'Aruba' => '297',
            'Australia' => '61',
            'Austria' => '43',
            'Azerbaijan' => '994',
            'Bahamas' => '1242',
            'Bahrain' => '973',
            'Bangladesh' => '880',
            'Barbados' => '1246',
            'Belarus' => '375',
            'Belgium' => '375',
            'Belize' => '501',
            'Benin' => '229',
            'Bermuda' => '1 441',
            'Bhutan' => '975',
            'Bolivia' => '591',
            'Bosnia and Herzegovina' => '387',
            'Botswana' => '267',
            'Brazil' => '55',
            'British Indian Ocean Territory' => '246',
            'British Virgin Islands' => '1 284',
            'Brunei Darussalam' => '673',
            'Bulgaria' => '359',
            'Burkina Faso' => '226',
            'Burundi' => '257',
            'Cambodia' => '855',
            'Cameroon' => '237',
            'Canada' => '1',
            'Cape Verde' => '238',
            'Cayman Islands' => '1 345',
            'Central African Republic' => '236',
            'Chad' => '235',
            'Chile' => '56',
            'China' => '86',
            'Christmas Island' => '64',
            'Cocos (Keeling) Islands' => '61',
            'Colombia' => '57',
            'Comoros' => '269',
            'Congo' => '242',
            'Cook Islands' => '682',
            'Costa Rica' => '506',
            'Cote D\'Ivoire' => '225',
            'Croatia' => '385',
            'Cuba' => '53',
            'Cyprus' => '357',
            'Czech Republic' => '420',
            'Denmark' => '45',
            'Djibouti' => '253',
            'Dominica' => '1 767',
            'Dominican Republic' => '1 809',
            'East Timor (Timor-Leste)' => '670',
            'Ecuador' => '593',
            'Egypt' => '20',
            'El Salvador' => '503',
            'Equatorial Guinea' => '240',
            'Eritrea' => '291',
            'Estonia' => '372',
            'Ethiopia' => '251',
            'Falkland Islands (Malvinas)' => '500',
            'Faroe Islands' => '298',
            'Fiji' => '679',
            'Finland' => '358',
            'France' => '33',
            'French Guiana' => '594',
            'French Polynesia' => '689',
            'Gabon' => '241',
            'Gambia, the' => '220',
            'Georgia' => '995',
            'Germany' => '49',
            'Ghana' => '233',
            'Gibraltar' => '350',
            'Greece' => '30',
            'Greenland' => '299',
            'Grenada' => '1 473',
            'Guadeloupe' => '590',
            'Guam' => '1 671',
            'Guatemala' => '502',
            'Guernsey and Alderney' => '5399',
            'Guinea' => '224',
            'Guinea-Bissau' => '245',
            'Guinea, Equatorial' => '240',
            'Guiana, French' => '594',
            'Guyana' => '592',
            'Haiti' => '509',
            'Holy See (Vatican City State)' => '379',
            'Holland' => '31',
            'Honduras' => '504',
            'Hong Kong, (China)' => '852',
            'Hungary' => '36',
            'Iceland' => '354',
            'India' => '91',
            'Indonesia' => '62',
            'Iran' => '98',
            'Iraq' => '964',
            'Ireland' => '353',
            'Isle of Man' => '44',
            'Israel' => '972',
            'Italy' => '39',
            'Jamaica' => '1 876',
            'Japan' => '81',
            'Jersey' => '44',
            'Jordan' => '962',
            'Kazakhstan' => '7',
            'Kenya' => '254',
            'Kiribati' => '686',
            'Korea(North)' => '850',
            'Korea(South)' => '82',
            'Kosovo' => '381',
            'Kuwait' => '965',
            'Kyrgyzstan' => '996',
            'Lao People\'s Democratic Republic' => '856',
            'Latvia' => '371',
            'Lebanon' => '961',
            'Lesotho' => '266',
            'Liberia' => '231',
            'Libyan Arab Jamahiriya' => '218',
            'Liechtenstein' => '423',
            'Lithuania' => '370',
            'Luxembourg' => '352',
            'Macao, (China)' => '853',
            'Macedonia, TFYR' => '389',
            'Madagascar' => '261',
            'Malawi' => '265',
            'Malaysia' => '60',
            'Maldives' => '960',
            'Mali' => '223',
            'Malta' => '356',
            'Marshall Islands' => '692',
            'Martinique' => '596',
            'Mauritania' => '222',
            'Mauritius' => '230',
            'Mayotte' => '262',
            'Mexico' => '52',
            'Micronesia' => '691',
            'Moldova' => '373',
            'Monaco' => '377',
            'Mongolia' => '976',
            'Montenegro' => '382',
            'Montserrat' => '1 664',
            'Morocco' => '212',
            'Mozambique' => '258',
            'Myanmar' => '95',
            'Namibia' => '264',
            'Nauru' => '674',
            'Nepal' => '977',
            'Netherlands' => '31',
            'Netherlands Antilles' => '599',
            'New Caledonia' => '687',
            'New Zealand' => '64',
            'Nicaragua' => '505',
            'Niger' => '227',
            'Nigeria' => '234',
            'Niue' => '683',
            'Norfolk Island' => '672',
            'Northern Mariana Islands' => '1 670',
            'Norway' => '47',
            'Oman' => '968',
            'Pakistan' => '92',
            'Palau' => '680',
            'Palestinian Territory' => '970',
            'Panama' => '507',
            'Papua New Guinea' => '675',
            'Paraguay' => '595',
            'Peru' => '51',
            'Philippines' => '63',
            'Pitcairn Island' => '872',
            'Poland' => '48',
            'Portugal' => '351',
            'Puerto Rico' => '1787',
            'Qatar' => '974',
            'Reunion' => '262',
            'Romania' => '40',
            'Russia' => '7',
            'Rwanda' => '250',
            'Sahara' => '212',
            'Saint Helena' => '290',
            'Saint Kitts and Nevis' => '1869',
            'Saint Lucia' => '1758',
            'Saint Pierre and Miquelon' => '508',
            'Saint Vincent and the Grenadines' => '1784',
            'Samoa' => '685',
            'San Marino' => '374',
            'Sao Tome and Principe' => '239',
            'Saudi Arabia' => '966',
            'Senegal' => '221',
            'Serbia' => '381',
            'Seychelles' => '248',
            'Sierra Leone' => '232',
            'Singapore' => '65',
            'Slovakia' => '421',
            'Slovenia' => '386',
            'Solomon Islands' => '677',
            'Somalia' => '252',
            'South Africa' => '27',
            'S. Georgia and S. Sandwich Is.' => '500',
            'Spain' => '34',
            'Sri Lanka (ex-Ceilan)' => '94',
            'Sudan' => '249',
            'Suriname' => '597',
            'Svalbard and Jan Mayen Islands' => '79',
            'Swaziland' => '41',
            'Sweden' => '46',
            'Switzerland' => '41',
            'Syrian Arab Republic' => '963',
            'Taiwan' => '886',
            'Tajikistan' => '992',
            'Tanzania' => '255',
            'Thailand' => '66',
            'Timor-Leste (East Timor)' => '670',
            'Togo' => '228',
            'Tokelau' => '690',
            'Tonga' => '676',
            'Trinidad and Tobago' => '1 868',
            'Tunisia' => '216',
            'Turkey' => '90',
            'Turkmenistan' => '993',
            'Turks and Caicos Islands' => '1 649',
            'Tuvalu' => '688',
            'Uganda' => '256',
            'Ukraine' => '380',
            'United Arab Emirates' => '971',
            'United Kingdom' => '44',
            'United States' => '1',
            'US Minor Outlying Islands' => '808',
            'Uruguay' => '598',
            'Uzbekistan' => '998',
            'Vanuatu' => '678',
            'Vatican City State (Holy See)' => '379',
            'Venezuela' => '58',
            'Viet Nam' => '84',
            'Virgin Islands, British' => '1284',
            'Virgin Islands, U.S.' => '1340',
            'Wallis and Futuna' => '681',
            'Western Sahara' => '212',
            'Yemen' => '967',
            'Zambia' => '260',
            'Zimbabwe' => '263',
        );

        $country_name = $this->getCountries($country_code);

        return isset($countryCallingCodes[$country_name])?$countryCallingCodes[$country_name]:false;
    }

    public function getStatus($id = null){
        $data= array(
            '1'=>'Pending',
            '2' => 'Accepted',
            '3' => 'Invited',
            '4' => 'Referred',
            '5' => 'Credited ',
            '6' =>'Awaiting',
            '7' =>'-',
            '8' =>'Referral'
        );

        if(!is_null($id)){
            return isset($data[$id])?$data[$id]:false;
        }
        return $data;

    }
    public function getPeriodicity($id = null){
        $data= array(
            '1'=>'Daily',
            '2' => 'Weekly',
            '3' => 'Monthly'
             );

        if(!is_null($id)){
            return isset($data[$id])?$data[$id]:false;
        }
        return $data;

    }
    public function getProjectStatus($id = null){
        $data= array(
            '1'=>'Activated',
            '2' => 'Deactivated',
            '0' => 'Deleted'
        );

        if(!is_null($id)){
            return isset($data[$id])?$data[$id]:false;
        }
        return $data;

    }

    public function getFMGroupCurrency($account_type, $currency_code, $swap_free = 0)
    {

        /* Any Update here please update in all repositories namely d8 , m7 and my .forexmart.com Domain. */

        $data= array(

            5 => array( // API group codes for  ForexMart Classic
                'USD' => array(
                    0 => 'FcSwUS',
                    1 => 'FcSFUS'
                ),
                'EUR' => array(
                    0 => 'FcSwEU',
                    1 => 'FcSFEU'
                ),
                'GBP' => array(
                    0 => 'FcSwGB',
                    1 => 'FcSFGB'
                ),
                'RUB' => array(
                    0 => 'FcSwRU',
                    1 => 'FcSFRU'
                ),
                'MYR' => array(
                    0 => 'FcSwMR',
                    1 => 'FcSFMR'
                ),
                'IDR' => array(
                    0 => 'FcSwID',
                    1 => 'FcSFID'
                ),
                'THB' => array(
                    0 => 'FcSwTH',
                    1 => 'FcSFTH'
                ),
                'CNY' => array(
                    0 => 'FcSwCN',
                    1 => 'FcSFCN'
                )
            ),
            6 => array( // API group codes for ForeMart PRO
                'USD' => array(
                    0 => 'FpSwUS',
                    1 => 'FpSFUS'
                ),
                'EUR' => array(
                    0 => 'FpSwEU',
                    1 => 'FpSFEU'
                ),
                'GBP' => array(
                    0 => 'FpSwGB',
                    1 => 'FpSFGB'
                ),
                'RUB' => array(
                    0 => 'FpSwRU',
                    1 => 'FpSFRU'
                ),
                'MYR' => array(
                    0 => 'FpSwMR',
                    1 => 'FpSFMR'
                ),
                'IDR' => array(
                    0 => 'FpSwID',
                    1 => 'FpSFID'
                ),
                'THB' => array(
                    0 => 'FpSwTH',
                    1 => 'FpSFTH'
                ),
                'CNY' => array(
                    0 => 'FpSwCN',
                    1 => 'FpSFCN'
                )
            ),

            3 => array( // API group codes for Partners/Affiliates
                'USD' => 'PaUS',
                'EUR' => 'PaEU',
                'GBP' => 'PaGB',
                'RUB' => 'PaRU',
                'MYR' => 'PaMY',
                'IDR' => 'PaID',
                'THB' => 'PaTH',
                'CNY' => 'PaCN'
            ),
            7 => array( // API group codes for ForexMart Cents
                'USD' => array(
                    0 => 'FcSwUSC',
                    1 => 'FcSFUSC'
                ),
                'EUR' => array(
                    0 => 'FcSwEUC',
                    1 => 'FcSFEUC'
                )
            )
        );

        

        $mt_group = '';

        if(in_array($account_type, array(5,6,3,7))){
            if($this->session->userdata('isChina') == '1'){
                $this->session->unset_userdata('isChina');
                //return "D-".$data[$account_type][$currency_code][$swap_free].'-cn';
                $mt_group = "D-".$data[$account_type][$currency_code][$swap_free];
            } else {
                $mt_group = "D-".$data[$account_type][$currency_code][$swap_free];

            }
        }

        if(in_array($account_type, array(5,7)) && $currency_code == 'USD'){
            $mt_group = $mt_group.FXPP::MTGroupMU();
        }


        return $mt_group;
        /* Any Update here please update in all repositories namely d8 , m7 and my .forexmart.com Domain. */
    }

    public function getGroupCurrency($account_type, $currency_code, $swap_free = 0)
    {

        if(in_array($account_type, array(5,6,7))) {
            //if (IPLoc::Office()) {
                return self::getFMGroupCurrency($account_type, $currency_code, $swap_free);
           // }
        }

        $data = array(

            1 => array( // API group codes for ForexMart Standard
                'USD' => array(
                    0 => 'StSwUS',
                    1 => 'StSFUS'
                ),
                'EUR' => array(
                    0 => 'StSwEU',
                    1 => 'StSFEU'
                ),
                'GBP' => array(
                    0 => 'StSwGB',
                    1 => 'StSFGB'
                ),
                'RUB' => array(
                    0 => 'StSwRU',
                    1 => 'StSFRU'
                ),
                'MYR' => array(
                    0 => 'StSwMR',
                    1 => 'StSFMR'
                ),
                'IDR' => array(
                    0 => 'StSwID',
                    1 => 'StSFID'
                ),
                'THB' => array(
                    0 => 'StSwTH',
                    1 => 'StSFTH'
                ),
                'CNY' => array(
                    0 => 'StSwCN',
                    1 => 'StSFCN'
                )
            ),
            2 => array( // API group codes for ForeMart Zero Spread
                'USD' => array(
                    0 => 'ZeSwUS',
                    1 => 'ZeSFUS'
                ),
                'EUR' => array(
                    0 => 'ZeSwEU',
                    1 => 'ZeSFEU'
                ),
                'GBP' => array(
                    0 => 'ZeSwGB',
                    1 => 'ZeSFGB'
                ),
                'RUB' => array(
                    0 => 'ZeSwRU',
                    1 => 'ZeSFRU'
                ),
                'MYR' => array(
                    0 => 'ZeSwMR',
                    1 => 'ZeSFMR'
                ),
                'IDR' => array(
                    0 => 'ZeSwID',
                    1 => 'StSFID'
                ),
                'THB' => array(
                    0 => 'ZeSwTH',
                    1 => 'ZeSFTH'
                ),
                'CNY' => array(
                    0 => 'ZeSwCN',
                    1 => 'ZeSFCN'
                )
            ),

            3 => array( // API group codes for Partners/Affiliates
                'USD' => 'PaUS',
                'EUR' => 'PaEU',
                'GBP' => 'PaGB',
                'RUB' => 'PaRU',
                'MYR' => 'PaMY',
                'IDR' => 'PaID',
                'THB' => 'PaTH',
                'CNY' => 'PaCN'
            ),
            4 => array( // API group codes for ForexMart Micro
                'USD' => array(
                    0 => 'StSwUSC',
                    1 => 'StSFUSC'
                ),
                'EUR' => array(
                    0 => 'StSwEUC',
                    1 => 'StSFEUC'
                )
            )
        );

        if(in_array($account_type, array(1,2,4))){
            if($this->session->userdata('isChina') == '1'){
                $this->session->unset_userdata('isChina');

                return "D-".$data[$account_type][$currency_code][$swap_free].'-cn';
            } else {
                // return $data[$account_type][$currency_code][$swap_free];
                // if(IPLoc::Office()){

                //  if(IPLoc::isEuropeanCountry($this->session->userdata('country_code'))){
//                    $this->session->unset_userdata('country_code');
//                    return $data[$account_type][$currency_code][$swap_free];
                //  }else{
                return "D-".$data[$account_type][$currency_code][$swap_free];
                //}

                /*  }else{
                      return $data[$account_type][$currency_code][$swap_free];
                  }*/
            }
        }elseif(in_array($account_type, array(3))){
            if($this->session->userdata('isChina') == '1'){
                $this->session->unset_userdata('isChina');
                return "D-".$data[$account_type][$currency_code].'-cn';
            } else {
                //return $data[$account_type][$currency_code];
                // if(IPLoc::Office()){

//                if(IPLoc::isEuropeanCountry($this->session->userdata('country_code'))){
//                    $this->session->unset_userdata('country_code');
//                    return $data[$account_type][$currency_code];
//                }else{
                return "D-".$data[$account_type][$currency_code];
//                }

                /* }else{
                     return $data[$account_type][$currency_code];
                 }*/
            }
        }else{
            return '';
        }
    }

    public function getDemoGroupCurrency( $account_type, $currency_code, $swap_free = 0 ){

        $data= array(
            1 => array( // API group codes for ForexMart Demo Standard
                'USD' => 'StUS',
                'EUR' =>'StEU',
                'GBP' => 'StGB'
            ),
            2 => array( // API group codes for ForexMart Demo Zero-Spread
                'USD' => 'ZeUS',
                'EUR' =>'ZeEU',
                'GBP' => 'ZeGB'
            ),
            3 => array( // API group codes for Contest Moneyfall for swap-free/non swap-free
                0 => 'ContestMF',
                1 => 'ContestMFSF'
            )
        );

        if(FXPP::isEUUrl()){

            $data = array(
                'USD'=>"EU-demofx-USD",
                'EUR' =>"EU-demofx-EUR"
            );

            return isset($data[$currency_code])?$data[$currency_code]:$data['USD'];
        }else{
            $data = array(
                'USD'=>"demoforex-usd",
                'EUR' =>"demoforex-eur"
            );

            return isset($data[$currency_code])?$data[$currency_code]:$data['USD'];
        }

        if(in_array($account_type, array(1,2))){
            return $data[$account_type][$currency_code];
        }elseif(in_array($account_type, array(3))){
            return $data[$account_type][$swap_free];
        }else{
            return '';
        }
    }

    function getGender($id = null)
    {

        $data = array(
            'M' => 'Male',
            'F' => 'Female'
        );

        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }


    function getEstimatedAnnualIncome2($id=null){
        $data= array( ">250,000","50,000 - 250,000","15,000 - 50,000","<15,000");
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getEstimatedNetWorth2($id=null){
        $data= array( ">250,000","50,000 - 250,000","15,000 - 50,000","<15,000");
        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }


    function getBusinessNature($id=null){

        $data = array(
            'Accounting',
            'Banking',
            'Legal',
            'Financial Services',
            'Business Administration',
            'Other',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getNumberMonthlyConnectedTradedAnswer($id=null){
        $data = array(
            'more than 100 trades',
            '50-100 trades',
            '25-50 trades',
            '1-25 trades',
            'No trades',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }

    function getCFDPositionStopOutLevelAnswer($id=null){
        $data = array(
            'No change',
            'I will lose part of my investment',
            'It will close automatically',
            'Only I can close the deal',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getCFDTradingWithHigherLeverageAnswer($id=null){
        $data = array(
            'You can lower your risk of loss',
            'Your position volume will decrease',
            'You have a lower profit',
            'You may open a larger position volume, and profit but it increases the risk of loss',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getStopOutLevel50PercentAnswer($id=null){
        $data = array(
            'The account equity reaches 50% of the used margin ',
            'The account equity reaches zero',
            'The account equity reaches 50% of the account balance ',
            'None of the above',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getEducationLevel2($id = null)
    {
//        if(IPLoc::Office()){
//            $data = array(lang('educ_1'),lang('educ_2'),lang('educ_3'),lang('educ_4'),lang('educ_5'),lang('educ_6'));
//        }else{
        $data = array("Elementary", "High School", "College/University", "Masters/PHD", "Professional Qualification","Other");
//        }

        if ($id == null) {
            return $data;
        } else {
            return isset($data[$id]) ? $data[$id] : false;
        }

    }

    function showt2w3j2s(
        $table1,$table2,
        $field1="",$id1="",
        $field2="",$id2="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field1, $id1);
        $this->db->or_where($field2, $id2);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function showt2w3j2sX(
        $table1,$table2,
        $field1="",$id1="",
        $field2="",$id2="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field1, $id1);
        $this->db->or_where($field2, $id2);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    public function getMail($id) {
        $this->db->select('*');
        $this->db->from('TestTable');
        $this->db->where('id', $id);
        $this->db->where('reply_id', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function getDOBbyuserid( $table1,$table2,
                             $field1="",$id1="",
                             $field2="",$id2="",
                             $field3="",$id3="",
                             $field4="",$id4="",
                             $join12="",
                             $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field1, $id1);
        $this->db->or_where($field2, $id2);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
    function showt2w3j2sFullname(
        $table1,$table2,
        $field1="",$id1="",
        $field2="",$id2="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field2, $id2);
        $this->db->where($field1, $id1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function showt2w3j2sEmail(
        $table1,$table2,
        $field1="",$id1="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field1, $id1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function showst4j2w1($table1,$table2,$table3,$table4,$field1,$id1,$join12,$join13,$join14,$select){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->join($table3 ,$join13);
        $this->db->join($table4 ,$join14);
        $this->db->where($field1, $id1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    
     public function getQueryStirngResult($table,$star,$data="",$gropup="",$order="",$join=""){
        $this->db->select($star);
        $this->db->from($table);
        if($join!=""){foreach($join as $key=>$val){$this->db->join($key ,$val);}}
        if($data!=""){foreach($data as $key=>$val){ $this->db->where($key ,$val);}}
        
        if($gropup!=""){foreach($gropup as $key=>$val){ $this->db->group_by($val); }}
        if($order!=""){foreach($order as $key=>$val){ $this->db->order_by($key,$val); }}
  
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
    
    
     public function getQueryStirngRow($table,$star,$data="",$gropup="",$order="",$join=""){
        $this->db->select($star);
        $this->db->from($table);
        if($join!=""){foreach($join as $key=>$val){$this->db->join($key ,$val);}}
        if($data!=""){foreach($data as $key=>$val){ $this->db->where($key ,$val);}}
        
        if($gropup!=""){foreach($gropup as $key=>$val){ $this->db->group_by($val); }}
        if($order!=""){foreach($order as $key=>$val){ $this->db->order_by($key,$val); }}
  
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row();
        }else{
            return false;
        }
    }

        public function getQueryStirngAll($ResultType="0",$table,$star,$data="",$dataOr="",$gropup="",$order="",$join=""){
        $this->db->select($star);
        $this->db->from($table);
        if($join!=""){foreach($join as $key=>$val){$this->db->join($key ,$val);}}
        if($data!=""){$this->db->where($data);}
        if($dataOr!=""){$this->db->or_where($dataOr);}
        if($gropup!=""){foreach($gropup as $key=>$val){ $this->db->group_by($val); }}
        if($order!=""){foreach($order as $key=>$val){ $this->db->order_by($key,$val); }}
  
        $query = $this->db->get();
        if($query->num_rows() > 0) {
           if($ResultType=="1")
           {
            return $query->result();   
           }
           else
           {
               return $query->row();
           }
            
        }else{
            return false;
        }
    }
    
    
    function insertmy($table,$data){
        if ($this->db->insert($table, $data)){
            return $this->db->insert_id();
        }
        return false;
    }

    public function table_exists( $table_name ){
        if ($this->db->table_exists($table_name)){
            return true;
        }else{
            return false;
        }
    }
    
    
    public function getQueryStringRow($table,$star,$whereData="",$orderbyField="",$AscDesc="",$limit=""){

        $this->db->select($star);
        $this->db->from($table);
        if($whereData!=""){ foreach($whereData as $key=>$val) {$this->db->where($key, $val);  }}

        if($orderbyField!=""){ $this->db->order_by($orderbyField,$AscDesc);}
        if($limit!=""){$this->db->limit($limit);}
        $result = $this->db->get();
        return $result->row();

    }
    function setQueryStringUpdate($table,$whereData,$updateData){
        foreach($whereData as $key=>$val) {$this->db->where($key, $val);}  
        $this->db->update($table, $updateData);
	
    }
    
    function sendEmail2($file_name, $subject, $email, $data,$configemail=null)
    {
        $this->config->load('tank_auth');
        $this->load->library('email');
        if($configemail != null){
            $this->email->initialize($configemail);
        }
        $this->SMTPDebug =1;
        $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($this->load->view('email/'.$file_name, $data, TRUE));
        $this->email->send();

    }

      function sendEmailVisitor($file_name, $subject, $email, $data,$configemail=null,$bcc=null,$cc=null)
    {
        $this->config->load('tank_auth');
        $this->load->library('email');
        if($configemail != null){
            $this->email->initialize($configemail);
        }

        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        if($cc!=null){$this->email->cc($cc);}
        if($bcc!=null){$this->email->bcc($bcc);}
        $this->email->subject($subject);
        $this->email->message($this->load->view('email/'.$file_name, $data, TRUE));
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $this->email->send();
        }
        else{
            return false;
        }
    }
    function updatemyw2($table,$field1,$id1,$field2,$id2,$data){
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }
    function showt1w1arr($table,$field="",$id="",$select="",$order_by=""){
        $this->db->select($select);
        $this->db->where($field, $id);
        $this->db->from($table);
        $query =  $this->db->get();
        return $query->result_array();
    }

    function showtable($table,$whereData,$select="",$order_by="",$offset=0,$limit=""){
//        $this->db->select($select);
//        foreach($whereData as $key=>$val) {$this->db->where($key, $val);}
//        $this->db->from($table);
//        $this->db->orderby($order_by);
//        $this->db->limit($limit,$offset);
//        $query =  $this->db->get();
//        $query->result_array();


//        return  $this->db->query("SELECT '".$select."' FROM '".$table."' ORDER BY '".$order_by."' LIMIT '".$offset."' '".$limit."'")->result_array();
       // return  $this->db->query("SELECT ".$select." FROM `".$table."` ORDER BY ".$order_by." LIMIT ".$offset.",".$limit."" )->result_array();

        //

        $this->db->select($select);
        $this->db->from($table);
        $this->db->order_by($order_by);
        $this->db->limit($limit,$offset);

        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }



    }
    
     public function getQueryAllObject($table,$star="*",$wheredata="",$join="",$orderby="",$gropup="",$limit=""){
        $this->db->select($star);
        $this->db->from($table);        
        
        if($join!=""){foreach($join as $key=>$val)   // array('table__jointtype'=>'table.id=table2.id');
        { $joinType=explode("__", $key); $this->db->join($joinType[0] ,$val,$joinType[1]);} }            
        if($wheredata!=""){ $this->db->where($wheredata);}      // array('id'=>'1','name'=>'frz');   
        if($gropup!=""){$this->db->group_by($gropup);} //'id'
        if($orderby!=""){foreach($orderby as $key=>$val){ $this->db->order_by($key,$val); }}   // array('id'=>'desc');
        if($limit!=""){$this->db->limit($limit);} // 4
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }       
        
      public function getQueryOneObject($table,$star="*",$wheredata="",$join="",$orderby="",$gropup="",$limit=""){
        $this->db->select($star);
        $this->db->from($table);        
        
        if($join!=""){foreach($join as $key=>$val)   // array('table__jointtype'=>'table.id=table2.id');
        { $joinType=explode("__", $key); $this->db->join($joinType[0],$val,$joinType[1]);} }            
        if($wheredata!=""){ $this->db->where($wheredata);}      // array('id'=>'1','name'=>'frz');   
        if($gropup!=""){$this->db->group_by($gropup);} 
        if($orderby!=""){foreach($orderby as $key=>$val){ $this->db->order_by($key,$val); }}   // array('id'=>'desc');
        if($limit!=""){$this->db->limit($limit);} // 4
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row();
        }else{
            return false;
        }
    }
    public function getCountVerifyStatus($user_id) {
        $this->db->select('created, DATE_ADD(created,INTERVAL 15 DAY) as count',false);
        $this->db->from('users');
        $this->db->where('DATE_ADD(created,INTERVAL 15 DAY) > NOW()',null,false);
        $this->db->where('id',$user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function getAccountCurrencyBase_v2($id=null){

        $data= array(
            'EUR' =>"EUR",
            'USD' => "USD",
//            'GBP' => "GBP",
            'RUB' => "RUR",
//            'MYR' => "MYR",
//            'IDR' => "IDR",
//            'THB' => "THB",
//            'CNY' => "CNY"
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }
    }
    function getAllCountries($country_id = "")
    {
        FXPP::CI()->lang->load('register');
        $countries = array(
            "GB" => lang('uk_gm'),
            //  "US" => "United States",
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua And Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
          //  "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic Of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia (Local Name: Hrvatska)",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TP" => "East Timor",
            "EC" => lang('fc_gm'),
            "EG" => lang('eg_gm'),
            "SV" => lang('sv_gm'),
            "GQ" => lang('gq_gm'),
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => lang('fk_gm'),
            "FO" => lang('fo_gm'),
            "FJ" => lang('fj_gm'),
            "FI" => lang('fi_gm'),
            "FR" => lang('fr_gm'),
            "FX" => lang('fx_gm'),
            "GF" => lang('gf_gm'),
            "PF" => lang('pf_gm'),
            "TF" => lang('tf_gm'),
            "GA" => lang('ga_gm'),
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => lang('germany_gm'),
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard And Mc Donald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran (Islamic Republic Of)",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic Of",
            // "KR" => "Korea, Republic Of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
           "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            "MK" => "Macedonia, Former Yugoslav Republic Of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States Of",
            "MD" => "Moldova, Republic Of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            // "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS"=>  "Palestina",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "KN" => "Saint Kitts And Nevis",
            "LC" => "Saint Lucia",
            "VC" => "Saint Vincent And The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome And Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia (Slovak Republic)",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia, South Sandwich Islands",
            "KS" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SH" => "St. Helena",
            "PM" => "St. Pierre And Miquelon",
            //"SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard And Jan Mayen Islands",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            //  "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic Of",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad And Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks And Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands (British)",
            "VI" => "Virgin Islands (U.S.)",
            "WF" => "Wallis And Futuna Islands",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
//            "YU" => "Yugoslavia",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );
        if ($country_id) {
            return isset($countries[$country_id]) ? $countries[$country_id] : false;
        } else {
            return $countries;
        }
    }
    function getAllCountries_localize($country_id=""){
        FXPP::CI()->lang->load('countries');
        $countries = array(
            "GB" =>lang('GB'),
            // "US" =>lang('US'),
            "AF" =>lang('AF'),
            "AL" =>lang('AL'),
            "DZ" =>lang('DZ'),
            "AS" =>lang('AS'),
            "AD" =>lang('AD'),
            "AO" =>lang('AO'),
            "AI" =>lang('AI'),
            "AQ" =>lang('AQ'),
            "AG" =>lang('AG'),
            "AR" =>lang('AR'),
            "AM" =>lang('AM'),
            "AW" =>lang('AW'),
            "AU" =>lang('AU'),
            "AT" =>lang('AT'),
            "AZ" =>lang('AZ'),
            "BS" =>lang('BS'),
            "BH" =>lang('BH'),
            "BD" =>lang('BD'),
            "BB" =>lang('BB'),
            "BY" =>lang('BY'),
            "BE" =>lang('BE'),
            "BZ" =>lang('BZ'),
            "BJ" =>lang('BJ'),
            "BM" =>lang('BM'),
            "BT" =>lang('BT'),
            "BO" =>lang('BO'),
            "BA" =>lang('BA'),
            "BW" =>lang('BW'),
            "BV" =>lang('BV'),
            "BR" =>lang('BR'),
            "IO" =>lang('IO'),
            "BN" =>lang('BN'),
            "BG" =>lang('BG'),
            "BF" =>lang('BF'),
            "BI" =>lang('BI'),
            "KH" =>lang('KH'),
            "CM" =>lang('CM'),
            "CA" =>lang('CA'),
            "CV" =>lang('CV'),
            "KY" =>lang('KY'),
            "CF" =>lang('CF'),
            "TD" =>lang('TD'),
            "CL" =>lang('CL'),
            "CN" =>lang('CN'),
            "CX" =>lang('CX'),
            "CC" =>lang('CC'),
            "CO" =>lang('CO'),
            "KM" =>lang('KM'),
            "CG" =>lang('CG'),
            "CD" =>lang('CD'),
            "CK" =>lang('CK'),
            "CR" =>lang('CR'),
            "CI" =>lang('CI'),
            "HR" =>lang('HR'),
            "CU" =>lang('CU'),
            "CY" =>lang('CY'),
            "CZ" =>lang('CZ'),
            "DK" =>lang('DK'),
            "DJ" =>lang('DJ'),
            "DM" =>lang('DM'),
            "DO" =>lang('DO'),
            "TP" =>lang('TP'),
            "EC" =>lang('EC'),
            "EG" =>lang('EG'),
            "SV" =>lang('SV'),
            "GQ" =>lang('GQ'),
            "ER" =>lang('ER'),
            "EE" =>lang('EE'),
            "ET" =>lang('ET'),
            "FK" =>lang('FK'),
            "FO" =>lang('FO'),
            "FJ" =>lang('FJ'),
            "FI" =>lang('FI'),
            "FR" =>lang('FR'),
            "FX" =>lang('FX'),
            "GF" =>lang('GF'),
            "PF" =>lang('PF'),
            "TF" =>lang('TF'),
            "GA" =>lang('GA'),
            "GM" =>lang('GM'),
            "GE" =>lang('GE'),
            "DE" =>lang('DE'),
            "GH" =>lang('GH'),
            "GI" =>lang('GI'),
            "GR" =>lang('GR'),
            "GL" =>lang('GL'),
            "GD" =>lang('GD'),
            "GP" =>lang('GP'),
            "GU" =>lang('GU'),
            "GT" =>lang('GT'),
            "GN" =>lang('GN'),
            "GW" =>lang('GW'),
            "GY" =>lang('GY'),
            "HT" =>lang('HT'),
            "HM" =>lang('HM'),
            "VA" =>lang('VA'),
            "HN" =>lang('HN'),
            "HK" =>lang('HK'),
            "HU" =>lang('HU'),
            "IS" =>lang('IS'),
            "IN" =>lang('IN'),
            "ID" =>lang('ID'),
            "IR" =>lang('IR'),
            "IQ" =>lang('IQ'),
            "IE" =>lang('IE'),
            "IL" =>lang('IL'),
            "IT" =>lang('IT'),
            "JM" =>lang('JM'),
            "JP" =>lang('JP'),
            "JO" =>lang('JO'),
            "KZ" =>lang('KZ'),
            "KE" =>lang('KE'),
            "KI" =>lang('KI'),
            "KP" =>lang('KP'),
            "KR" =>lang('KR'),
            "KW" =>lang('KW'),
            "KG" =>lang('KG'),
            "LA" =>lang('LA'),
            "LV" =>lang('LV'),
            "LB" =>lang('LB'),
            "LS" =>lang('LS'),
            "LR" =>lang('LR'),
            "LY" =>lang('LY'),
            "LI" =>lang('LI'),
            "LT" =>lang('LT'),
            "LU" =>lang('LU'),
            "MO" =>lang('MO'),
            "MK" =>lang('MK'),
            "MG" =>lang('MG'),
            "MW" =>lang('MW'),
            "MY" =>lang('MY'),
            "MV" =>lang('MV'),
            "ML" =>lang('ML'),
            "MT" =>lang('MT'),
            "MH" =>lang('MH'),
            "MQ" =>lang('MQ'),
            "MR" =>lang('MR'),
            "MU" =>lang('MU'),
            "YT" =>lang('YT'),
            "MX" =>lang('MX'),
            "FM" =>lang('FM'),
            "MD" =>lang('MD'),
            "MC" =>lang('MC'),
            "MN" =>lang('MN'),
            "ME" => "Montenegro",
            "MS" =>lang('MS'),
            "MA" =>lang('MA'),
            "MZ" =>lang('MZ'),
            // "MM" =>lang('MM'),
            "NA" =>lang('NA'),
            "NR" =>lang('NR'),
            "NP" =>lang('NP'),
            "NL" =>lang('NL'),
            "AN" =>lang('AN'),
            "NC" =>lang('NC'),
            "NZ" =>lang('NZ'),
            "NI" =>lang('NI'),
            "NE" =>lang('NE'),
            "NG" =>lang('NG'),
            "NU" =>lang('NU'),
            "NF" =>lang('NF'),
            "MP" =>lang('MP'),
            "NO" =>lang('NO'),
            "OM" =>lang('OM'),
            "PK" =>lang('PK'),
            "PW" =>lang('PW'),
            "PS" =>lang('PS'),
            "PA" =>lang('PA'),
            "PG" =>lang('PG'),
            "PY" =>lang('PY'),
            "PE" =>lang('PE'),
            "PH" =>lang('PH'),
            "PN" =>lang('PN'),
            "PL" =>lang('PL'),
            "PT" =>lang('PT'),
            "PR" =>lang('PR'),
            "QA" =>lang('QA'),
            "RE" =>lang('RE'),
            "RO" =>lang('RO'),
            "RU" =>lang('RU'),
            "RW" =>lang('RW'),
            "KN" =>lang('KN'),
            "LC" =>lang('LC'),
            "VC" =>lang('VC'),
            "WS" =>lang('WS'),
            "SM" =>lang('SM'),
            "ST" =>lang('ST'),
            "SA" =>lang('SA'),
            "SN" =>lang('SN'),
            "RS" =>lang('RS'),
            "SC" =>lang('SC'),
            "SL" =>lang('SL'),
            "SG" =>lang('SG'),
            "SK" =>lang('SK'),
            "SI" =>lang('SI'),
            "SB" =>lang('SB'),
            "SO" =>lang('SO'),
            "ZA" =>lang('ZA'),
            "GS" =>lang('GS'),
            "ES" =>lang('ES'),
            "LK" =>lang('LK'),
            "SH" =>lang('SH'),
            "PM" =>lang('PM'),
            // "SD" =>lang('SD'),
            "SR" =>lang('SR'),
            "SJ" =>lang('SJ'),
            "SZ" =>lang('SZ'),
            "SE" =>lang('SE'),
            "CH" =>lang('CH'),
            // "SY" =>lang('SY'),
            "TW" =>lang('TW'),
            "TJ" =>lang('TJ'),
            "TZ" =>lang('TZ'),
            "TH" =>lang('TH'),
            "TG" =>lang('TG'),
            "TK" =>lang('TK'),
            "TO" =>lang('TO'),
            "TT" =>lang('TT'),
            "TN" =>lang('TN'),
            "TR" =>lang('TR'),
            "TM" =>lang('TM'),
            "TC" =>lang('TC'),
            "TV" =>lang('TV'),
            "UG" =>lang('UG'),
            "UA" =>lang('UA'),
            "AE" =>lang('AE'),
            "UM" =>lang('UM'),
            "UY" =>lang('UY'),
            "UZ" =>lang('UZ'),
            "VU" =>lang('VU'),
            "VE" =>lang('VE'),
            "VN" =>lang('VN'),
            "VG" =>lang('VG'),
            "VI" =>lang('VI'),
            "WF" =>lang('WF'),
            "EH" =>lang('EH'),
            "YE" =>lang('YE'),
//"YU" => "Yugoslavia",
            "ZM" =>lang('ZM'),
            "ZW" =>lang('ZW'),
        );
        if($country_id){
            return isset($countries[$country_id])?$countries[$country_id]:false;
        }else{
            return $countries;
        }
    }
    function getshow($tbl,$fld,$id){
        $q = $this->db->select('*')
            ->from($tbl)
            ->where($fld, $id);
        $ret = $q->get()->result();
        return $ret;
    }
    function getGroupSpard($id=null){

        $data = array(
            "refSt201"=>"ForexMart Standard / spread 2.0 pips",
            "refSt251"=>"ForexMart Standard / spread 2.5 pips",
            "refSt301"=>"ForexMart Standard / spread 3.0 pips",
            "refSt351"=>"ForexMart Standard / spread 3.5 pips",
            "refSt401"=>"ForexMart Standard / spread 4.0 pips",
            "refZe201"=>"ForexMart Zero Spread / fee 2.0 pips",
            "refZe251"=>"ForexMart Zero Spread / fee 2.5 pips",
            "refZe301"=>"ForexMart Zero Spread / fee 3.0 pips",
            "refZe351"=>"ForexMart Zero Spread / fee 3.5 pips",
            "refZe401"=>"ForexMart Zero Spread / fee 4.0 pips"
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function update_micro($user_id,$data){
        //$this->db->trans_start();
        $this->db->set($data);
        $this->db->where('id', $user_id);
        $this->db->update('users');

        /*$this->db->update('users',$data);
        $this->db->where('id',$user_id);*/

        //$this->db->trans_complete();
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }


    function whereConditionQuery($conditon){
        $sql = "Select * from (SELECT
                    `mt_accounts_set`.`user_id` AS `user_id`,
                    `mt_accounts_set`.`account_number` AS `account_number`,
                    `mt_accounts_set`.`mt_type` AS `type`,
                    `mt_accounts_set`.`amount` AS `amount`,
                    `mt_accounts_set`.`mt_currency_base` AS `currency`,
                    1 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `mt_accounts_set`
                        inner JOIN `users` ON (
                            (
                                `mt_accounts_set`.`user_id` = `users`.`id`
                            )
                        )
                    )
			where `mt_accounts_set`.`user_id` = ? limit 1
              UNION ALL
                SELECT
                    `partnership`.`partner_id` AS `user_id`,
                    `partnership`.`reference_num` AS `account_number`,
                    `partnership`.`type_of_partnership` AS `type`,
                    `partnership`.`amount` AS `amount`,
                    `partnership`.`currency` AS `currency`,
                    2 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `partnership`
                        LEFT JOIN `users` ON (
                            (
                                `partnership`.`partner_id` = `users`.`id`
                            )
                        )
                    )
			where `partnership`.`partner_id` = ? limit 1

)   as testtable   ";

        $query = $this->db->query($sql, array($conditon,$conditon));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;

    }

    function whereConditionQuery2($conditon1,$conditon2){
        $sql = "Select * from (SELECT
                    `mt_accounts_set`.`user_id` AS `user_id`,
                    `mt_accounts_set`.`account_number` AS `account_number`,
                    `mt_accounts_set`.`mt_type` AS `type`,
                    `mt_accounts_set`.`amount` AS `amount`,
                    `mt_accounts_set`.`mt_currency_base` AS `currency`,
                    1 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `mt_accounts_set`
                        LEFT JOIN `users` ON (
                            (
                                `mt_accounts_set`.`user_id` = `users`.`id`
                            )
                        )
                    )
              UNION ALL
                SELECT
                    `partnership`.`partner_id` AS `user_id`,
                    `partnership`.`reference_num` AS `account_number`,
                    `partnership`.`type_of_partnership` AS `type`,
                    `partnership`.`amount` AS `amount`,
                    `partnership`.`currency` AS `currency`,
                    2 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `partnership`
                        LEFT JOIN `users` ON (
                            (
                                `partnership`.`partner_id` = `users`.`id`
                            )
                        )
                    ) )   as testtable  WHERE user_id = ? and account_type=? ";

        $query = $this->db->query($sql, array($conditon1,$conditon2));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    function whereConditionQueryRow($condition){
        $sql = "Select * from (SELECT
                    `mt_accounts_set`.`user_id` AS `user_id`,
                    `mt_accounts_set`.`account_number` AS `account_number`,
                    `mt_accounts_set`.`mt_type` AS `type`,
                    `mt_accounts_set`.`amount` AS `amount`,
                    `mt_accounts_set`.`mt_currency_base` AS `currency`,
                    1 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `mt_accounts_set`
                        LEFT JOIN `users` ON (
                            (
                                `mt_accounts_set`.`user_id` = `users`.`id`
                            )
                        )
                    )
              UNION ALL
                SELECT
                    `partnership`.`partner_id` AS `user_id`,
                    `partnership`.`reference_num` AS `account_number`,
                    `partnership`.`type_of_partnership` AS `type`,
                    `partnership`.`amount` AS `amount`,
                    `partnership`.`currency` AS `currency`,
                    2 AS `account_type`,
                    `users`.`accountstatus` AS `approved`
                FROM
                    (
                        `partnership`
                        LEFT JOIN `users` ON (
                            (
                                `partnership`.`partner_id` = `users`.`id`
                            )
                        )
                    ) )   as testtable  WHERE user_id = ? ";

        $query = $this->db->query($sql, array($condition));
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
	function getLeverage_internal_registration($id = null, $limit = 5000)
	{

		$data = array(
			1,
			2,
			3,
			5,
			10,
			20,
			25,
			30,
			50,
			66,
			88,
			100,
			200,
			300,
			400,
			500,
			1000,
			3000,
		);
		$data_value = array(
			'1:1' => "1:1",
			'1:2' => "1:2",
			'1:3' => "1:3",
			'1:5' => "1:5",
			'1:10' => "1:10",
			'1:20' => "1:20",
			'1:25' => "1:25",
			'1:30' => "1:30",
			'1:50' => "1:50",
			'1:66' => "1:66",
			'1:88' => "1:88",
			'1:100' => "1:100",
			'1:200' => "1:200",
			'1:300' => "1:300",
			'1:400' => "1:400",
			'1:500' => "1:500",
			'1:1000' => "1:1000",
			'1:3000' => "1:3000",
		);

//        if(IPLoc::Office()){
		//FXPP-2865
		array_push($data, 5000);
		array_push($data_value['1:5000'], "1:5000");
//            $limit = 5000;
//        }


if(FXPP::riseLeverage() == 'mu'){
  
    $limit = 1000;
  
 }
		if ($id == null) {
			$ret_data = array();
			foreach ($data as $leverage) {
				if ($leverage <= $limit) {
					$ret_data['1:' . $leverage] = '1:' . $leverage;
				}
			}
			return $ret_data;
		} else {
			return isset($data_value[$id]) ? $data_value[$id] : false;
		}

	}
	function getAllReferrals($code){
		$q = $this->db->select('*')
			->from('users_affiliate_code')
			->where('referral_affiliate_code', $code);
		$ret = $q->get()->result();
		return $ret;
	}
	function getAllReferralByDate($code,$from,$to){
//		$from = date("Y-m-d H:i:s",strtotime($from.' 0:0:0'));
//		$to = date("Y-m-d H:i:s",strtotime($to.' 23:59:59'));
		$where_bet = "(date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') )";
		$q = $this->db->select('*')
			->from('users_affiliate_code')
			->where('referral_affiliate_code', $code)
			->where($where_bet);
		$ret = $q->get()->result();
//		print_r($this->db->last_query());exit;

		return $ret;
	}
	function GetAffiliateCodesOfAccount($id,$table,$fld){
		$q = $this->db->select('*')
			->from($table)
			->where($fld, $id);
		$ret = $q->get()->result();
		
		//if(IPLoc::Office()){ echo 'fffff'; print_r($ret);}
		return $ret;
	}
	
	function getshow1($tbl,$fld,$id){
		$q = $this->db->select('*')
			->from($tbl)
			->where($fld, $id);
		$ret = $q->get()->result();
		return $ret;
	}


    function getshow1Search($tbl,$fld,$id , $search){
        $q = $this->db->select('*')
            ->from($tbl)
            ->where($fld, $id);
        $ret = $q->get()->result();
        return $ret;
    }


    function getAllMasterAccount($account_number){
        $master_account = array(
            '258739' => '258739',
            '258746' => '258739',
            '258747' => '258747',
            '101926'  => '101926',
            '282901'  => '282901',
            '282886'  => '282886' ,
            '282882'  => '282882',
            '265782'  => '265782',
            '291967'  => '291967',
            '99998'  => '99998',
            '192912'  => '192912',
            '293867'  => '293867',
            '1929121'  => '1929121',
            '196076'  => '196076',
            '296477'  => '296477',

        );
        if ($account_number) {
            return isset($master_account[$account_number]) ? $master_account[$account_number] : false;
        } else {
            return $master_account;
        }

    }

    function insertRegLog($data){
        $this->db->insert('registration_logs', $data);
        return $this->db->insert_id();
    }
    function where($table, $condition, $select = "*")
    {
        $this->db->select($select);
        $this->db->where($condition);
        $result = $this->db->get($table);
        if ($result->num_rows() > 0) return $result;
        return false;
    }

    function whereConditionArray($table, $condition, $select = "*")
    {
        $this->db->select($select);
        $this->db->where($condition);
        $result = $this->db->get($table);
        if ($result->num_rows() > 0) return $result->result_array();
        return false;
    }

    function getAverageTransactionSizeAns($id=null){
        //  $data = array(lang('reg_per_33'),lang('reg_per_34'),lang('reg_per_35'),lang('reg_per_36'));
        $data = array(
            'over 1000 EUR with a leverage of above 1:50',
            'between 100-1000 EUR with a leverage of above 1:50',
            '100 EUR or less with a leverage of above 1:50 ',
            'Never traded with a leverage of above 1:50',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getReqMarginAns($id=null){
        //  $data = array(lang('reg_per_33'),lang('reg_per_34'),lang('reg_per_35'),lang('reg_per_36'));
        $data = array(
            '1,000 EUR',
            '100 USD',
            '5,000 EUR  ',
            '1,000 USD ',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }
    function getBuyLotsAns($id=null){
        //  $data = array(lang('reg_per_33'),lang('reg_per_34'),lang('reg_per_35'),lang('reg_per_36'));
        $data = array(
            '20,000 USD ',
            '1,000,000 USD',
            '20,000,000 USD',
            '10,000 USD ',
        );

        if($id==null){
            return $data;
        }else{
            return isset($data[$id])?$data[$id]:false;
        }

    }


    public function isBdcountry($user_id){

        $sql = "SELECT 
  users.id AS userId,
  user_profiles.`country` 
FROM
  user_profiles 
  INNER JOIN users 
    ON user_profiles.user_id = users.id 
WHERE user_profiles.user_id =  ?
        ";
        $query = $this->db->query($sql, array($user_id));

        // return $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }

    }

    public function getLatestCredit30($account,$date){

        $sql = "select DATE_FORMAT(DateProcessed, '%Y-%m') as DateProcessed 
        from deposit_bonus 
        where TransactionPage = 'BONUS_30_DOLLAR' 
        and AccountNumber = $account
        and DATE_FORMAT(DateProcessed, '%Y-%m')  = '".$date."'
        limit 1
        ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
    public function getLatestCredit30PerMonth($codes,$date){
        if(count($codes) > 0){
            $where_in = 'AND users_affiliate_code.referral_affiliate_code  IN ("' . implode('", "', $codes) . '")';
        }

        $sql = "select deposit_bonus.AccountNumber
        FROM deposit_bonus
        LEFT  JOIN users_affiliate_code ON users_affiliate_code.users_id = deposit_bonus.UserId
        WHERE TransactionPage = 'BONUS_30_DOLLAR' 
        AND DATE_FORMAT(DateProcessed, '%Y-%m')  = '".$date."'
        $where_in";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }

    }



    public function isAdminApproved($user_id){

        $sql = "SELECT 
  users_affiliate_code.`approved_affiliate_code` 
FROM
  users_affiliate_code 
WHERE users_affiliate_code.`users_id` =  ?
        ";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }


    }




    public function isAdminApprovedPartnerCode($user_id){

        $sql = "SELECT 
  partnership_affiliate_code.`partner_approved_affiliate_code` 
FROM
  partnership_affiliate_code 
WHERE partnership_affiliate_code.`partner_id`=  ?
        ";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }


    }
	
	function getOnePageAllReferralByDate($code,$from,$to,$offset, $limit, $search){
		$where_bet = "(date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') )  LIMIT ". $offset.", ". $limit;
		
		$q = $this->db->select('ufc.affiliate_code, ufc.users_id, ufc.id, mas.mt_account_set_id')
			->from('users_affiliate_code ufc')
            ->join("mt_accounts_set mas", "mas.user_id = ufc.users_id", "left")
			->where('ufc.referral_affiliate_code', $code)
			//->like('u.Email', $search)
			->where($where_bet);
		$ret = $q->get()->result();

		return $ret;
		
	}
	
    function getOnePageAllReferralByDateSearch($code,$from,$to,$offset, $limit, $search){
        
		if($search=='Verified' || $search=='Read only'){			
			if($search=='Verified'){
				$accountstatus = 1;
			} else {
				$accountstatus = 0;
			}
			
			$where_bet = "WHERE `referral_affiliate_code` = '".$code."' and (date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') ) AND ( mt_accounts_set.`account_number` LIKE '".$search."%'  OR users.`email` LIKE '".$search."%' OR users.`accountstatus` = '".$accountstatus."'  OR mt_accounts_set.`registration_time` LIKE '".$search."%' OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%')  LIMIT ". $offset.", ". $limit;
		} else{
			$where_bet = "WHERE `referral_affiliate_code` = '".$code."' and (date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') ) AND ( mt_accounts_set.`account_number` LIKE '".$search."%'  OR users.`email` LIKE '".$search."%' OR mt_accounts_set.`registration_time` LIKE '".$search."%' OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%')  LIMIT ". $offset.", ". $limit;			
		}

       $q = "SELECT 
		  users_affiliate_code.`affiliate_code`,
		  users_affiliate_code.`users_id`,
		  users_affiliate_code.`id`,
		  mt_accounts_set.`registration_time`,
		  mt_accounts_set.`account_number`,
		  mt_accounts_set.`mt_account_set_id`
		  users.`email`,
		  users.`accountstatus`,
		  user_profiles.`full_name`,
		  contacts.`phone1` 
		FROM
		  `users_affiliate_code` 
		  LEFT JOIN mt_accounts_set 
			ON mt_accounts_set.`user_id` = users_affiliate_code.`users_id` 
		  LEFT JOIN users 
			ON mt_accounts_set.`user_id` = users.`id` 
		  LEFT JOIN user_profiles 
			ON mt_accounts_set.`user_id` = user_profiles.`user_id` 
		  LEFT JOIN contacts 
		ON mt_accounts_set.`user_id` = contacts.`user_id` ".$where_bet;
		 if(IPLoc::office()){
		// echo  $q;
		 }
        $query = $this->db->query($q);
        $ret=$query->result();
        return $ret;

    }
	
    function getDataAllReferrals2($code,$from,$to,$offset, $limit, $search){
        
		if($search=='Verified' || $search=='Read only'){			
			if($search=='Verified'){
				$accountstatus = 1;
			} else {
				$accountstatus = 0;
			}
			
			$where_bet = "WHERE `referral_affiliate_code` = '".$code."' and (date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') ) AND ( mt_accounts_set.`account_number` LIKE '".$search."%'  OR users.`email` LIKE '".$search."%' OR users.`accountstatus` = '".$accountstatus."'  OR mt_accounts_set.`registration_time` LIKE '".$search."%' OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%')  LIMIT ". $offset.", ". $limit;
		} else{
			$where_bet = "WHERE `referral_affiliate_code` = '".$code."' and (date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') ) AND ( mt_accounts_set.`account_number` LIKE '".$search."%'  OR users.`email` LIKE '".$search."%' OR mt_accounts_set.`registration_time` LIKE '".$search."%' OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%')  LIMIT ". $offset.", ". $limit;			
		}

       $q = "SELECT 
		  users_affiliate_code.`affiliate_code`,
		  users_affiliate_code.`users_id`,
		  users_affiliate_code.`id`,
		  mt_accounts_set.`registration_time`,
		  mt_accounts_set.`account_number`,
		  mt_accounts_set.`mt_account_set_id`,
		  users.`email`,
		  users.`accountstatus`,
		  user_profiles.`full_name`,
		  contacts.`phone1` 
		FROM
		  `users_affiliate_code` 
		  LEFT JOIN mt_accounts_set 
			ON mt_accounts_set.`user_id` = users_affiliate_code.`users_id` 
		  LEFT JOIN users 
			ON mt_accounts_set.`user_id` = users.`id` 
		  LEFT JOIN user_profiles 
			ON mt_accounts_set.`user_id` = user_profiles.`user_id` 
		  LEFT JOIN contacts 
		ON mt_accounts_set.`user_id` = contacts.`user_id` ".$where_bet;
		 if(IPLoc::office()){
		 //echo  $q;
		 }
		
        $query = $this->db->query($q);
        $ret=$query->result();
        return $ret;

    }

	
    function getDataAllReferrals($postData){
        if( empty( $postData ) ) {
            return array();
        }
		
		$search = $postData['search'];

        /*to prevent injection.*/

        $date_from = $this->db->escape($postData['date_from']);
        $date_to = $this->db->escape($postData['date_to']);

            /*End*/
        $where = array();
		
		$query = "select uac.affiliate_code, uac.users_id, uac.id, mas.mt_account_set_id, mas.account_number, us.nodepositbonus, us.accountstatus from users_affiliate_code uac
                  left join
	                (SELECT affiliate_code,  users_id userid from users_affiliate_code WHERE users_id = '".$postData['user_id']."' union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code WHERE partner_id = '".$postData['user_id']."') t
                    on uac.referral_affiliate_code=t.affiliate_code
                  left join  mt_accounts_set mas
                    on uac.users_id= mas.user_id
                  left join users us
                    on us.id = mas.user_id";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "t.userid = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "mas.registration_time BETWEEN $date_from AND $date_to";
            $where[] = implode( " OR ", $date );
        }
				
        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";
		 
		$where_bet =  '';
		if(isset($search) && !empty($search)){
			if($search=='Verified' || $search=='Read only'){			
				if($search=='Verified'){
					$accountstatus = 1;
				} else {
					$accountstatus = 0;
				}
				
				$where_bet = "AND ( mas.`account_number` LIKE '".$search."%'  OR us.`email` LIKE '".$search."%' OR us.`accountstatus` = '".$accountstatus."')";
				 //OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%'
			} else{
				$where_bet = "AND ( mas.`account_number` LIKE '".$search."%'  OR us.`email` LIKE '".$search."%' )";	
//OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%'				
			}
		}
        $query .= $whereClause . $where_bet . " order by mas.registration_time DESC LIMIT ".$postData['offset'].", ".$postData['limit']."";
//echo '<pre>'.$query;
        $result = $this->db->query( $query );
		
        return $result->result();         

    }
	
    function getCountDataAllReferrals($postData){
       
		if( empty( $postData ) ) {
            return array();
        }
		
		$search = $postData['search'];

        /*to prevent injection.*/

        $date_from = $this->db->escape($postData['date_from']);
        $date_to = $this->db->escape($postData['date_to']);

            /*End*/
        $where = array();
		
		$query = "select count(*) as count from users_affiliate_code uac
                  left join
	                (SELECT affiliate_code,  users_id userid from users_affiliate_code WHERE users_id = '".$postData['user_id']."' union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code WHERE partner_id = '".$postData['user_id']."') t
                    on uac.referral_affiliate_code=t.affiliate_code
                  left join  mt_accounts_set mas
                    on uac.users_id= mas.user_id
                  left join users us
                    on us.id = mas.user_id";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "t.userid = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "mas.registration_time BETWEEN $date_from AND $date_to";
            $where[] = implode( " OR ", $date );
        }
				
        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";
		 
		$where_bet =  '';
		if(isset($search) && !empty($search)){
			if($search=='Verified' || $search=='Read only'){			
				if($search=='Verified'){
					$accountstatus = 1;
				} else {
					$accountstatus = 0;
				}
				
				$where_bet = "AND ( mas.`account_number` LIKE '".$search."%'  OR us.`email` LIKE '".$search."%' OR us.`accountstatus` = '".$accountstatus."')";
				 //OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%'
			} else{
				$where_bet = "AND ( mas.`account_number` LIKE '".$search."%'  OR us.`email` LIKE '".$search."%' )";	
//OR user_profiles.`full_name` LIKE '".$search."%' OR contacts.`phone1` LIKE '".$search."%'				
			}
		}
        $query .= $whereClause . $where_bet . " order by mas.registration_time";

        $result = $this->db->query( $query );
		
        return $result->row_array();

    }

	function getCountAllReferralsAndRegisterAcByCode($code,$from,$to){
		$where_bet = "(date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') )";
		$q = $this->db->select('*')
			->from('users_affiliate_code')
			->where('referral_affiliate_code', $code)
			->where($where_bet);
		$ret = $q->get()->result();
//		print_r($this->db->last_query());exit;

		return $ret;
		
	}


    public function getCountAllReferralsAndRegisterAcByCode2( $codes, $date_from, $date_to ){
        $sql_where = 'WHERE referral_affiliate_code in ("' . implode('", "', $codes) . '")';
        $sql = "SELECT affiliate_code
                FROM users_affiliate_code   
                $sql_where
                AND (date_created >= '" . date('Y-m-d 00:00:00', strtotime($date_from)) . "' AND date_created <= '" . date('Y-m-d 23:59:59', strtotime($date_to)) . "')";
        $query = $this->db->query($sql);
        $ret = $query->result();
        return $ret;
    }

	public function depositReport( ){
        $sql = 'SELECT deposit.payment_date, deposit.user_id,deposit.transaction_id,deposit.transaction_type,users.micro,
					case when users.micro = 1 then SUM(deposit.conv_amount/100) else SUM(deposit.conv_amount) end amount, case when users.login_type = 1 then partnership.currency else mt_accounts_set.mt_currency_base end currency,  case when users.login_type = 1 then partnership.reference_num else mt_accounts_set.account_number end account_number
					FROM deposit
					INNER JOIN users ON users.id = deposit.user_id
					LEFT JOIN mt_accounts_set ON mt_accounts_set.user_id = deposit.user_id
					LEFT JOIN partnership ON partnership.partner_id = deposit.user_id
					Where deposit.status = 2				  
				    AND deposit.isDeposit = 0
					AND users.test = 0 
                    AND deposit.note = "Zotapay deposit" 
					AND deposit.admin_manualdeposit_users_id is NULL
					AND case when mt_accounts_set.id is not null then mt_accounts_set.mt_type = 1 else true end
					AND case when (mt_accounts_set.id is not null or partnership.id is not null) then CHAR_LENGTH(mt_accounts_set.account_number) > 4 or CHAR_LENGTH(partnership.reference_num) > 4 end         
					AND deposit.payment_date BETWEEN "2021-04-21 06:49:00" AND "2021-04-30 23:59:59"
					GROUP BY  deposit.transaction_id,deposit.user_id
					ORDER BY deposit.payment_date';
        $query = $this->db->query($sql);
        $ret = $query->result_array();
        return $ret;
    }
		
	function getCountAllReferralsDate($code,$from,$to){
		$where_bet = "(date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') )";
		$q = $this->db->select('*')
			->from('users_affiliate_code')
			->where('referral_affiliate_code', $code)
			->where($where_bet);
		$ret = $q->get()->result();
//		print_r($this->db->last_query());exit;

		return $ret;
		
	}

	public function countClicksByAffiliateCode($affiliate_code, $to, $from){

        $where = array();

        $query = "SELECT count(affiliate_code) as count FROM referral_affiliate_code";

        if(!empty($affiliate_code)){
            $where[] = '`affiliate_code` =  "' . $affiliate_code . '"';
        }
        if(!empty($to) AND !empty($from)){
            $where[] = '`date` BETWEEN " ' . $from . ' " AND " ' .$to. ' "';
        }

        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";
        $query .= $whereClause;

        $result = $this->db->query($query);

        if($result->num_rows() > 0 ){
            return $result->row_array();
        }
        return false;

    }


    function phone_verified($table,$user_id,$data){

        $this->db->set($data);
        $this->db->where('id', $user_id);
        $this->db->update($table);
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }

    public function has30dollarbonus($user_id, $select){
        $this->db->select($select)
            ->from('users')
            ->where('id', $user_id);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    function getUserDetails($user_id){
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }
        function getUserProfiles($user_id){
        $this->db->select("*");
        $this->db->from("user_profiles");
        $this->db->where("user_id",$user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }
    function getClientAccountDetails($accountNumber){
        $this->db->select("*");
        $this->db->from("mt_accounts_set");
        $this->db->where("account_number",$accountNumber);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }
    function getPartnerAccountDetails($accountNumber){
        $this->db->select("*");
        $this->db->from("partnership");
        $this->db->where("reference_num",$accountNumber);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }
    
      function getClientAccountDetailsByid($user_id){
        $this->db->select("*");
        $this->db->from("mt_accounts_set");
        $this->db->where("user_id",$user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }
    function getPartnerAccountDetailsByid($user_id){
        $this->db->select("*");
        $this->db->from("partnership");
        $this->db->where("partner_id",$user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row();
        }else{
            return false;
        }
    }

    public function getPartnerData(){
        $this->db->select('full_name, reference_num, email, phone_number');
        $this->db->from('partnership');
        $this->db->join('users', 'partnership.partner_id = users.id', 'left');
        $this->db->join('user_profiles', 'user_profiles.user_id = users.id', 'left');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'left');
        $this->db->where('test', '!=1');
        $this->db->where('user_profiles.country','MY');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
   
    // query for single value (mm)
    public function getSingleValue($tbl, $select, $condition){
        $this->db->select($select);
        $this->db->from($tbl);
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }


	public function getTnxTypeList(){
		$this->db->select('SubType,SubTypeCode');
		$this->db->from('transaction_type');
		$data =  $this->db->get();
		if($data->num_rows() > 0) {
			return $data->result_array();
		}else{
			return false;
		}

	}
        
        public function isStandardAccountInfo($email_address,$full_name){
            
            
            $sql_client="select user_profiles.* from users
            INNER JOIN mt_accounts_set on users.id=mt_accounts_set.user_id
            INNER JOIN user_profiles on users.id=user_profiles.user_id
            where users.email=? and mt_accounts_set.mt_account_set_id=1 and user_profiles.full_name=?";

             $query = $this->db->query($sql_client,array($email_address,$full_name));
                if ($query->num_rows() > 0) {
                   return $query->row();
                }
                else 
                {
                    return false;
                }	
	}
        
        public function isStandardAccount($account_number=false){
            
                if(!$account_number){
                 $account_number=$this->session->userdata('account_number');
                }
              
                $this->db->select("*");
                $this->db->from("mt_accounts_set");
                $this->db->where("mt_account_set_id",1);
                $this->db->where("account_number",$account_number);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->row();
                }
                return false;
              
              	
	}        
        
        
	public function geAccountInformaiton($account_number){
		$sql_client="select u.id,up.full_name,u.email,u.administration,u.login_type,'Client' account_type,mt.account_number,u.registration_location,
		up.country,mt.mt_account_set_id,mt.trader_password,u.accountstatus,up.image 
		from users u
		inner JOIN user_profiles up on up.user_id = u.id
		inner JOIN  mt_accounts_set mt on mt.user_id = u.id
		where mt.account_number=?";
		
		$sql_partner="select u.id,up.full_name,u.email,u.administration,u.login_type,'Partner' account_type,p.reference_num account_number,up.country,u.accountstatus,p.type_of_partnership,up.image
		from users u
		inner JOIN user_profiles up on up.user_id = u.id
		inner JOIN  partnership p on p.partner_id = u.id
		where p.reference_num=?";
		
			
		 $query = $this->db->query($sql_client,array($account_number));
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
								
				$query = $this->db->query($sql_partner,array($account_number));
				if ($query->num_rows() > 0) {
					return $query->row();
				} else {
					return false;
			} 
		}	
	} 
	
    function updateRemoveAccount($table,$account_number){
		$sql = "UPDATE ". $table ." SET remove_account = 1 WHERE account_number = " . $account_number;
        $query = $this->db->query($sql);
        return false;
    }
    
    public function isPayomaPayMentAvailable($user_id,$last_date=false){
        
       $last_date=($last_date)?$last_date:'2020-12-12';
        
        $sql = "SELECT isPayoma.* from(
            select deposit.user_id from deposit
            where LOWER(transaction_type)=LOWER('PAYOMA') and `status`=2
            and DATE_FORMAT(payment_date,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') 
            and user_id=?
            LIMIT 1

            union all
            select withdraw.user_id from withdraw
            where LOWER(transaction_type)=LOWER('PAYOMA') and `status`=1
            and DATE_FORMAT(date_withdraw,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') 
            and user_id=?
            LIMIT 1) as isPayoma";        
         $query = $this->db->query($sql,array($last_date,$user_id,$last_date,$user_id));
        
         
         if($query->num_rows()>0) 
         {
             return true;
	 }else{
            return false;
        }
         
    }
    
     public function isPayomaDepositAvailable($user_id,$last_date=false){
        
       $last_date=($last_date)?$last_date:'2020-12-11'; //[original date 2020-12-12]
        
        $sql = "select deposit.user_id from deposit
            where LOWER(transaction_type)=LOWER('PAYOMA') and `status`=2
            and DATE_FORMAT(payment_date,'%Y-%m-%d')<=DATE_FORMAT(?,'%Y-%m-%d') 
            and user_id=?
            LIMIT 1";        
         $query = $this->db->query($sql,array($last_date,$user_id));
        
         
         if($query->num_rows()>0) 
         {
             return true;
	 }else{
            return false;
        }
         
    }
     public function checkPermissionRemoveReadOnlyMWP($mwp_user_id,$permission_key){
                
        $sql = "select mwp_panel.* from(
            SELECT 
            `manage_access`.`country_group_permission`, `manage_access`.`special_permission`, 
            `users`.`id` `user_id`, `users`.`email` `email`, `users`.`activated` `status`, `user_profiles`.`id` `profile_id`, 
            `user_profiles`.`full_name` `name`, `manage_access`.`id` `manage_ac_id`, `manage_access`.`permission` `permission`,
             `manage_access`.`status` `manage_ac_status` FROM `users` 

            INNER JOIN `user_profiles` ON `users`.`id`=`user_profiles`.`user_id` 
            LEFT JOIN `manage_access` ON `users`.`id`=`manage_access`.`user_id`

             WHERE `manage_access`.`type` = 3 AND `manage_access`.`admin` = 3 AND `users`.`administration` = 1
             GROUP BY `users`.`email` ORDER BY `users`.`id` DESC) as mwp_panel where mwp_panel.user_id=? and mwp_panel.permission like '%".$permission_key."%'";        
                                
        $query = $this->db->query($sql,array($mwp_user_id));        
                                
         if($query->num_rows()>0) 
         {
             return true;
	 }else{
            return false;
        }
         
    }
    
    
     public function userAccountDetails($user_id){
                
        $sql = "select 
            users.*,
             upro.full_name,upro.street,upro.city,upro.state,upro.country,upro.zip,upro.dob,upro.passport,upro.image,upro.age,upro.gender,
            contacts.phone1,contacts.phone2,contacts.email1,contacts.telephone,
            empd.employment_status,empd.industry,empd.source_of_funds,empd.estimated_annual_income,empd.estimated_net_worth,empd.education_level,empd.us_resident,empd.us_citizen,
            IF(ua_code.affiliate_code!='',ua_code.affiliate_code,pa_code.affiliate_code) affiliate_code,IF(mt_st.account_number!='',mt_st.account_number,partnership.reference_num) account_number,
            IF(mt_st.account_number!='',mt_st.mt_account_set_id,'00') account_type_code,IF(mt_st.account_number!='','client','partner') account_type,
            IF(mt_st.account_number!='',mt_st.mt_currency_base,partnership.currency) currency
            from users 
            INNER JOIN user_profiles upro on users.id=upro.user_id
            LEFT JOIN contacts on users.id=contacts.user_id
            LEFT JOIN employment_details empd on users.id=empd.user_id
            LEFT JOIN users_affiliate_code ua_code on users.id=ua_code.users_id
            LEFT JOIN partnership_affiliate_code pa_code on users.id=pa_code.partner_id
            LEFT JOIN mt_accounts_set mt_st on users.id=mt_st.user_id 
            LEFT JOIN partnership on users.id=partnership.partner_id 
            where users.id=?";        
                                
        $query = $this->db->query($sql,array($user_id));        
                                
         if($query->num_rows()>0) 
         {
            return $query->row();
	 }else{
            return false;
        }
         
    }
       function upDateSpecailSessionData($ip,$email){
       
		$sql ="select  * from ci_sessions_c where ip_address=? and `data` like '%".$email."%' ORDER BY DATE_FORMAT(FROM_UNIXTIME(`timestamp`), '%Y-%m-%d %H:%i:%s') DESC  limit 1";       
                $query = $this->db->query($sql,array($ip));
                if($query->num_rows()>0) 
                {
                     $data=$query->row();    
                     $ci_session_c_id=$data->id;
                     $u_sql="UPDATE ci_sessions_c SET data ='' WHERE id =?";
                     $this->db->query($u_sql,array($ci_session_c_id));
                     return true;                    
                }else{
                   return false;
               }

    }    

}