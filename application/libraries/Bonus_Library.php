<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_Library{

    public static function getScoring()
    {

        FXPP::CI()->load->model('General_model');

        FXPP::CI()->g_m=FXPP::CI()->General_model;

        $userid = $_SESSION['user_id'];

        $data['scoring']=array();
        $total=0;
        $trading_experience = FXPP::CI()->g_m->showssingle2($table='trading_experience',$field='user_id',$id=$userid,$select='investment_knowledge,risk,experience,trade_duration');

//        echo '1. Knowledge';

        if($trading_experience){
            /*Investment knowledge*/
            switch($trading_experience['investment_knowledge']){
                case 0:
                    /* Non-Existing */
                    $value=0;
                    $total=$total+$value;
                    break;
                case 1:
                    /* Fair */
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2:
                    /* Limited */
                    $value=2;
                    $total=$total+$value;
                    break;
                case 3:
                    /* Excellent */
                    $value=3;
                    $total=$total+$value;
                    break;
            }

            /*Understand Investment Risk*/

            if($trading_experience['risk']==1){
                $value=4;
                $total=$total+$value;
            }else{
                $value=0;
                $total=$total+$value;
            }

//            echo '2. Experience';

            /* Trading Experience */

            /* $trading_experience['experience'] sting sepated by comma structure ex 0,1,1 data */
            if ($trading_experience['experience']!=''){
                $experience = explode(",",$trading_experience['experience']);

                if($experience[0]){ /*Forex and CFD's */
                    $value=4;
                    $total=$total+$value;
                }

                if($experience[1]){ /* Securities */
                    $value=2;
                    $total=$total+$value;
                }

                if($experience[2]){ /* Other Derivative Products */
                    $value=4;
                    $total=$total+$value;
                }
            }

            /* How often do you trade? */

            switch($trading_experience['trade_duration']){
                case 0: /*Daily*/
                    $value=4;
                    $total=$total+$value;
                    break;
                case 1: /*Weekly*/
                    $value=3;
                    $total=$total+$value;
                    break;
                case 2: /*Monthly*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 3: /*Yearly*/
                    $value=0;
                    $total=$total+$value;
                    break;
            }
        }

        $employment_details = FXPP::CI()->g_m->showssingle2($table='employment_details',$field='user_id',$id=$userid,$select='employment_status,industry,education_level');

        if($employment_details){

            /* Employment Status  field employment_status*/

            /* 0 Employed value 1*/
            /* 1 Self Employed  value 1*/
            /* 2 Retired value 1 */
            /* 3 Student value 1*/
            /* 4 Unemployed  value 1*/
            $value=1;
            $total=$total+$value;

            /* Industry */

            /*
            0   Accountancy
            1   Admin/Secretarial
            2   Agriculture
            3   Finance service - Banking
            4   Catering/Hospitality
            5   Creative/media
            6   Education
            7   Engineering
            8   Financial service - others
            9   Health/Medicine
            10  Emergency Services
            11  HM Forces
            12  HR
            13  Financial Services - insurance
            14  IT
            15  Leisure/Entertainment/Tourism
            16  Manufacturing
            17  Marketing/PR/Advertising
            18  Pharmaceuticals
            */

            switch($employment_details['industry']){
                case 0: /*0 Accountancy*/
                    $value=3;
                    $total=$total+$value;
                    break;

                case 1: /*1 Admin/Secretarial*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2: /*2 Agriculture*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 3: /*4   Finance service - Banking*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 4: /*4   Catering/Hospitality*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 5: /*5   Creative/media*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 6: /*6   Education*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 7: /*7   Engineering*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 8: /*8   Financial service - others*/
                    $value=3;
                    $total=$total+$value;
                    break;
                case 9: /*9   Health/Medicine*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 10: /*10  Emergency Services*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 11: /*11  HM Forces*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 12: /*12  HR*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 13: /*13  Financial Services - insurance*/
                    break;
                case 14: /*14  IT*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 15: /*15  Leisure/Entertainment/Tourism*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 16: /*16  Manufacturing*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 17: /*17  Marketing/PR/Advertising*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 18: /*18  Pharmaceuticals */
                    $value=1;
                    $total=$total+$value;
                    break;
                default:

            }

            /*27 industries field industry*/

            /* Educational Level */

            /*
                 0 - Elementary
                 1 - High School
                 2 - College / University
                 3 - Master / PHD
                 4 - Professional Qualification
                 5 - Financial Related
            */

            switch($employment_details['education_level']){
                case 0 : /* 0 - Elementary*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 1 : /* 1 - High School*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2 : /*2 - College / University*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 3 : /* 3 - Master / PHD*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 4 : /* 4 - Professional Qualification*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 5 :  /*5 - Financial Related*/
                    $value=4;
                    $total=$total+$value;
                    break;
                default:
            }
            /*field education_level*/

        }

//        $mt_accounts_set = FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$userid,$select='registration_ip');
        $user_profiles = FXPP::CI()->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$userid,$select='country');
//        require_once APPPATH.'/helpers/geoiploc.php';
        $data['Country']=$user_profiles['country'];
//        $CI =& get_instance();

//        $ip = $mt_accounts_set['registration_ip'];
//
//        if($CI->input->valid_ip($ip)){
//            $data['Country'] =getCountryFromIP($ip);
//        }else{
//            $data['Country'] = 'Invalid';
//        }

        /*Country 1 and Points 1*/
        /*Bangladesh, China, Hong Kong, Taiwan, Kenya, Uzbekistan, India, Jordan, Lebanon,Other countries of Africa, The others*/
        $data['c1'] = array('BD','CN', 'HK', 'TW', 'KE', 'UZ','IN','JO','LB');//1
        /*Note no africa yet*/


        /*Country 2 and Points 2*/
        /*Indonesia, Latin America, Jordan, Lebanon, Nigeria, Egypt, Morocco, Tunisia Malaysia, Thailand, Antigua and Barbuda,
        Bahamas, Ukraine, Belarus, Latvia, Lithuania, Georgia, Moldova, Russia, Kazakhstan Tasmania, Fiji and other countries of Oceania*/
        $data['c2'] = array('ID','JO','LB','NG','MA','TN','MY','TH','AG','BS','UA','BY','LV','LT','GE','MD','RU','KZ','FJ');//2 //Tasmania not found other countries of Oceania*/
        $data['c2_latinamerica'] = array('AR','BO','BR','CL','CO','CR','CU','DO','EC','SV','GF','GP','GT', 'HT','HN','MQ','MX','NI','PA','PY','PE','PR','MF','UY','VE'); // latin america
        $data['c2_otheroceanis'] = array('TP','AU','CX','CC','NF','NC','PB','PG','SB','VU','FM','GU','KI','MH','NR','MP','PW','UM','AS','CK','PF','NU','PN','WS','TK','TO','TV','WF');
        $data['c2_merge']= array_merge($data['c2'], $data['c2_latinamerica']);
        $data['c2_merge']= array_merge($data['c2_merge'], $data['c2_otheroceanis']);


        /*Country 3 and Points 3*/
        /*"THE REPUBLIC OF SOUTH AFRICA, Saudi Arabia, UNITED ARAB EMIRATES, Brunei" Kuwait, Qatar, Bahrain*/
        $data['c3'] = array('ZA','SA','AE','BN');//3 "ZA" => "South Africa", "SA" => "Saudi Arabia",   "AE" => "United Arab Emirates","BN" => "Brunei Darussalam",

        /*Country 4 and Points 4*/
        /*Poland, Hungary */
        $data['c4'] = array('PL','HU');//4
        /*done*/
        /*Country 5 and Points 5*/
        /*
            Andorra, Australia, Austria, Belgium, Great Britain, Canada, Cyprus, Czech Republic, Estonia, Denmark, Faroes, Finland, France,
            Germany, Greece, Iceland, Ireland, Israel, Italy, Japan, Luxembourg, Malta, Monaco, Netherlands, New Zealand, Norway, Portugal, San Marino,
            Singapore, Slovakia, Slovenia, South Korea, Spain, Sweden, Switzerland
        */
        $data['c5'] = array('AD','AU','AT','BE','GB','CA','CY','CZ','EE','DK','FI','FR','DE','GR','IS','IE','IL','IT','JP','LU','MT','MC','NL','NZ','NO','PT','SM','SG','SK','SI','KR','ES','SE','CH');//4
        /*no great britaion use GB for Uniter Kingdom*/
        /*no Faroes*/
        /*done*/

        if (in_array($data['Country'], $data['c1'])) {
            $value=1;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c2_merge'])) {
            $value=2;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c3'])) {
            $value=3;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c4'])) {
            $value=4;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c5'])) {
            $value=5;
            $total=$total+$value;
        }else{
            $value=1;
            $total=$total+$value;
        }

        //25 - 35 	$300
        //15 - 24 	$250
        //11 - 15 	$200
        //0 - 10 	$100
        $score =$total;
        $bonus=0;
        switch(true){
            case ($score <=10):
                /*$100*/
                $bonus=100;
                break;
            case ($score>10 and $score <=15):
                $bonus=200;
                /*$200*/
                break;
            case ($score>15 and $score <=24):
                $bonus=250;
                /*$250*/
                break;
            case ($score>=25 and $score <=35):
                $bonus=300;
                /*$300*/
                break;

        }
        return  array(
            'score'=>$score,
            'bonus'=>$bonus,
            'currency'=>'USD',
            'country'=>$data['Country']
        );
    }

    public static function creditNDB($bonus)
    {

        $data['crediting']=false;
        FXPP::CI()->load->model('account_model');
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->load->model('deposit_model');
        FXPP::CI()->load->library('WSV');
        FXPP::CI()->g_m=FXPP::CI()->General_model;
        FXPP::CI()->d_m=FXPP::CI()->deposit_model;

        /*Prevent user from double crediting error handling Start*/
        $user_id=$_SESSION['user_id'];
        $uservisit = FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='ndbcreditingvisit');
        if ($uservisit['ndbcreditingvisit']==0){
            $prvt_data['visit']=array(
                'ndbcreditingvisit'=>1
            );
            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $user_id, $prvt_data['visit']);
        }else{
            die();
        }
        /*Prevent user from double crediting error handling End*/


        /* add check is this account has already been tagged with acquiring no deposit bonus */
        //$account, $account_number, $amount, $is_cancel = false ,$comment

        $amount = $bonus; /*note amount should be converted depending on the bonus amount */
        $account_number = $_SESSION['account_number'];
        $comment = 'FOREXMART NO DEPOSIT BONUS';
        $account =  FXPP::CI()->account_model->getAccountsByAccountNumber( $account_number );
        if ($account['mt_currency_base']=='USD'){
            $amount_to_database = str_replace(',', '', $amount);
        }else{
            $amount_to_database = FXPP::get_convert_amount($to_currency='USD', $amount, $to_currency = $account['mt_currency_base']);
            $amount_to_database = str_replace(',', '', $amount_to_database);
        }

            $webservice_config = array('server' => 'live_new');
            $WebServiceNDB = new WebService($webservice_config);

            $account_info = array(
                'Login' => $account_number,
                'FundTransferAccountReciever' => $account_number,
                'Amount' => $amount_to_database,
                'Comment' => $comment,
                'ProcessByIP' => FXPP::CI()->input->ip_address()
            );
            /*1st Webservice Call*/
            $WebServiceNDB->open_Deposit_NoDepositBonus($account_info);
            if ($WebServiceNDB->request_status === 'RET_OK') {
                $data['crediting'] = true;
                $date_updated = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $prvt_data['nodepositbonus'] = array(
                        'nodepositbonus' => 1,
                        'ndb_bonus' => floatval($amount),
                        'ndb_ticket'=>$WebServiceNDB->get_result('Ticket'),
                        'ndba_acquired' => $date_updated->format('Y-m-d H:i:s'),
                        'ndb_bonus_ccy' => floatval($amount_to_database),
                        'ndb_cabinet_crediting' => 1
                    );

                FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $prvt_data['nodepositbonus']);

                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API nodeposit bonus',
                    'api'=>'open_Deposit_NoDepositBonus',
                    'account_number'=>$account_number,
                    'status'=>1
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/

                    /*new task email*/
                        $data['data']['isUSDorEUR']=false;
                        $data['data']['users_currency'] = $account['mt_currency_base'];
                        $ccy= array("USD", "EUR");
                        if (in_array($account['mt_currency_base'], $ccy)) {
                            $data['data']['isUSDorEUR']=true;
                        }

                        if(strtoupper(FXPP::getUserContinentCode()) == 'EU'){
                            $default_currency = 'EUR';

                            $data['data']['bonus_negligible_view'] = FXPP::get_convert_amount($to_currency='USD', $amount, $to_currency = 'EUR');
                            $data['data']['bonus_negligible_view'] = str_replace(',', '', $data['data']['bonus_negligible_view']);
                            if ($account['mt_currency_base'] == 'USD'){
                                $data['data']['bonus'] = $amount;

                            }else{
                                $data['data']['bonus'] = $amount_to_database;
                            }
                        }else{
                            $default_currency = 'USD';

                            $data['data']['bonus_negligible_view'] = $amount;

                            if ($account['mt_currency_base']=='USD'){

                                $data['data']['bonus']=$amount;
                            }else{
                                $data['data']['bonus'] = $amount_to_database;

                            }
                        }

                        $email_data = array(
                            'account_number' => $account_number ,
                            'email' => $email = $_SESSION['email'],
                            'bonus' => $data['data']['bonus'],
                            'isUSDorEUR' => $data['data']['isUSDorEUR'],
                            'users_currency' => $account['mt_currency_base'],
                            'default_currency' => $default_currency,
                            'bonus_negligible_view' => $data['data']['bonus_negligible_view']
                        );
                        FXPP::CI()->load->library('Fxpp_email');
                        $logs['is_sent'] = Fxpp_email::ndb($email_data);

                        /*Table Logs*/
                        if ($logs['is_sent']){
                            $tbl_log = array(
                                'user_id'=>$account['user_id'],
                                'process'=>'Email',
                                'api'=>'N/A',
                                'account_number'=>$account_number,
                                'status'=>1
                            );
                            FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                        }else{
                            $tbl_log = array(
                                'user_id'=>$account['user_id'],
                                'process'=>'Email',
                                'api'=>'N/A',
                                'account_number'=>$account_number,
                                'status'=>2
                            );
                            FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                        }
                        /*Table Logs*/


                    /*new task email*/


                /*2nd Webservice Call*/

                $country = FXPP::CI()->account_model->getAccountsCountry($account['user_id']);
                if($country[0]['country'] == 'CN'){
                    FXPP::CI()->session->set_userdata('isChina', '1');
                }

               // $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);
                
                $groupCurrency =  substr($account['group'], 0, -1);
                FXPP::update_account_group_specific($account['user_id']);
                $account_details = FXPP::CI()->account_model->getAccountByUserId($account['user_id']);
                FXPP::CI()->load->model('Managecontest_model');
                $prize_data = array(
                    'user_id' => $account['user_id'],
                    'account_number' => $account_number,
                    'manager_id' => $account['user_id'],
                    'amount' => $amount_to_database,
                    'comment' => $comment,
                    'ticket' => $WebServiceNDB->get_result('Ticket'),
                    'date_processed' => FXPP::getCurrentDateTime()
                );
                $i_cp = FXPP::CI()->Managecontest_model->insertCreditPrize($prize_data);
                $logs['i_cp']=$i_cp;

                if($i_cp!=false){
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'Credit Prize',
                        'api'=>'N/A',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }else{
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'Credit Prize',
                        'api'=>'N/A',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }

//                if(IPLoc::IPOnlyForMe()){
                    $isAgentBangladesh = FXPP::update_account_group_For_Bangladesh($account['user_id'])['isAgentBangladesh'];
//                }

                if($isAgentBangladesh){
                    $Group2char = substr($groupCurrency, 0, 2); //return 1st two char
                    if($Group2char == 'D-'){
                      //  $groupCurrency = substr($groupCurrency, 2); //remove 'D-'  //FXPP-9776
                    }
                    $groupCurrency .= 'ndb-ibBD1'; //FXPP-8164
                }else{
                    $groupCurrency .= 'ndb' . $account_details['group_code'];
                }

//                $account_info2 = array(
//                    'iLogin' => $account['account_number'],
//                    'strGroup' => $groupCurrency
//                );

//                $WebService2 = new WebService($webservice_config);
//                $WebService2->open_ChangeAccountGroup($account_info2);

                $WebService2 = FXPP::SetAccountGroup($account['account_number'], $groupCurrency);

                if ($WebService2->request_status == 'RET_OK'){

                    $group = $groupCurrency;

                    $mdata = array(
                        'group'=> $group,
                    );
                    FXPP::CI()->g_m->updatemy('mt_accounts_set', 'account_number', $account['account_number'], $mdata);

                    $logs['WS2']='OK';
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountGroup',
                        'api'=>'ChangeAccountGroup',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/


                }else{
                    $logs['WS2']='ChangeAccountGroup API error';
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountGroup',
                        'api'=>'ChangeAccountGroup',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }


                FXPP::CI()->load->model('user_model');

                $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($account['user_id']);
                if (in_array(strtoupper($user['country']), array('PL'))) {
                    $account_info3 = array(
                        'iLogin' => $account['account_number'],
                        'iLeverage' => '100'
                    );
                } else {
                    $account_info3 = array(
                        'iLogin' => $account['account_number'],
                        'iLeverage' => '200'
                    );
                }

                /*3rd Webservice Call*/
//                $WebService3 = new WebService($webservice_config);
//                $WebService3->open_ChangeAccountLeverage($account_info3);

                $WebService3 = FXPP::SetLeverage($account['account_number'], $account_info3['iLeverage']);

                if ($WebService3->request_status == 'RET_OK') {
                    $logs['WS3']='OK';
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountLeverage',
                        'api'=>'ChangeAccountLeverage',
                        'account_number'=>$account_number,
                        'status'=>1
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }else{
                    $logs['WS3']='ChangeAccountLeverage API error';
                    /*Table Logs*/
                    $tbl_log = array(
                        'user_id'=>$account['user_id'],
                        'process'=>'API ChangeAccountLeverage',
                        'api'=>'ChangeAccountLeverage',
                        'account_number'=>$account_number,
                        'status'=>2
                    );
                    FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                    /*Table Logs*/
                }

                $sum = floatval($amount_to_database) + floatval($account['amount']);
                $prvt_data['amount'] = array(
                    'amount' => $sum,
                    'leverage' => '1:'.$account_info3['iLeverage']
                );
                $u_lev_amt = FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $account['id'], $prvt_data['amount']);
                $logs['u_lev_amt']=$u_lev_amt;
                $date_updated = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $prvt_data['nodepositbonus'] = array(
                    'nodepositbonus' => 1,
                    'ndba_acquired' => $date_updated->format('Y-m-d H:i:s'),
                    'ndb_bonus' => floatval($amount),
                    'ndb_bonus_ccy' => floatval($amount_to_database),
                    'ndb_cabinet_crediting' => 1
                );

                $logs['ndb_bonus'] = (string) $amount;
                $logs['ndb_bonus_ccy'] = (string) $amount_to_database;
                FXPP::CI()->d_m->setNoDepositRequestStatus($account['user_id'], 1);
                $u_logndb =  FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $prvt_data['nodepositbonus']);
                $logs['u_logndb'] = $u_logndb;
                $logs['WS1']='OK';

            }else{
                $data['crediting']=false;
                $logs['WS1']='NoDepositBonus API error';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API nodeposit bonus',
                    'api'=>'open_Deposit_NoDepositBonus',
                    'account_number'=>$account_number,
                    'status'=>2
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }

            $data['log']=array(
                'ndb_logs'=> json_encode($logs)
            );

            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $data['log']);

        return array(
            'request'=>$data['crediting'],
            'WS1'=>$logs['WS1'],
            'WS2'=>$logs['WS2'],
            'WS3'=>$logs['WS3'],
        );

    }
    /*Method added for auto crediting NDB method from admin */
    public static function GetAccountAgent($account_number)
    {
        $webservice_config = array('server' => 'live_new');
//        $WebService = new WebService($webservice_config);
        $account_info = array('iLogin' => $account_number );
//        $WebService->open_RequestAccountDetails($account_info);

        $CI =& get_instance();
        $CI->load->library('WSV'); //New web service
        $WebService = $CI->wsv->GetAccountDetailsSingle($account_info, $webservice_config);

        if($WebService->request_status === 'RET_OK'){
//            $accountDetails = $WebService->get_all_result();
            $accountDetails = $WebService->result;
            $getAccountAgent = $accountDetails['Agent'];
            return $getAccountAgent;
        }

        return false;
    }

    public static function insert_ndblogs($argument)
    {
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $data['insert_ndblogs']=array(
            'admin_user_id'=>$argument['admin_user_id'],
            'user_id'=>$argument['user_id'],
            'date_api'=>FXPP::getServerTime(),
            'account_number'=>$argument['account_number'],
            'amount'=>$argument['amount'],
            'location'=>$argument['location'],
        );
        self::CI()->g_m->insertmy($table='ndb_logs',$data=$data['insert_ndblogs']);
    }
    /*Method added for auto crediting NDB method from admin */
    public static function creditNBD_alreadyrequested()
    {

        /*Note staging account numbers are also mixed with  account nuber from live database*/

        FXPP::CI()->load->model('Bonus_model');
        FXPP::CI()->b_m=FXPP::CI()->Bonus_model;
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;
        //        $nodeposit = FXPP::CI()->b_m->get_ndbrequest();
        FXPP::CI()->load->model('Task_model');
        FXPP::CI()->t_m=FXPP::CI()->Task_model;
        $nodeposit = FXPP::CI()->b_m->get_ndbrequest_new();
//        var_dump($nodeposit);
//        die();
        foreach($nodeposit as $key => $value){

            $user_id = $value['user_id'];

            $account_number = $value['account_number'];
            echo $account_number . '<br/>';

            $usr_p = FXPP::CI()->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$user_id,$select='full_name,dob');
            $usr = FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='email');

            $fullname = $usr_p['full_name'];
            $dob = $usr_p['dob'];
            $email = $usr['email'];

            $data['accountfullname'] = FXPP::CI()->g_m->showt2w3j2sFullname(
                $table1 = 'users',$table2 = 'user_profiles',
                $field2 = 'user_profiles.full_name', $id2 = trim($fullname),
                $field1 = 'user_profiles.dob', $id1 = trim($dob),
                $field3 = 'users.ndb_bonus!=', $id3 = '',
                $field4 = 'users.id !=', $id4=$user_id,
                $join12 = 'users.id=user_profiles.user_id',
                $select = 'ndb_bonus,users.email,user_profiles.dob'
            );

            //check for account email
            $data['accountemail'] = FXPP::CI()->t_m->showEmail_v2(
                $table1 = 'users',$table2 = 'user_profiles',$table3='mt_accounts_set',
                $field1 = 'UCASE(users.email)', $id1 = $email,
                $field3 = 'users.ndb_bonus!=', $id3 = '',
                $field4 = 'users.id !=', $id4 = $user_id,
                $join12 = 'users.id=user_profiles.user_id',
                $join13 = 'users.id=mt_accounts_set.user_id',
                $select = 'ndb_bonus,users.email,account_number,nodepositbonus'
            );

            $IsAcquiredFromOtherAccount = false;
            if ( $data['accountfullname']) {
                foreach ( $data['accountfullname'] as $key1 => $value1) {
                    if ((!isset($value1['ndb_bonus'])) || trim($value1['ndb_bonus']) === '' ) {

                    }else if(is_null($value1['ndb_bonus'])) {

                    } else {

                        $IsAcquiredFromOtherAccount = true;
                    }
                }

            }

            if ($data['accountemail']) {
                foreach ( $data['accountemail'] as $key2 => $value2) {
                    if ((!isset($value2['ndb_bonus'])) || trim($value2['ndb_bonus']) === '' ) {

                    }else if(is_null($value2['ndb_bonus'])) {

                    } else {
                        $IsAcquiredFromOtherAccount = true;
                    }

                }
            }

            /*1 week exceeding is allowed since this has been a before request of ndb*/
            $account_details = FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id= $user_id ,$select='mt_account_set_id');

            $webservice_config = array('server' => 'live_new');
            $WebService = new WebService($webservice_config);
            $account_info = array('iLogin' => $account_number);
            $WebService->open_RequestAccountDetails($account_info);

            if ($WebService->request_status=== 'RET_OK') {
                $ForMarStaAcc = FXPP::get_standardgroup();
                if (in_array($WebService->get_result('Group'), $ForMarStaAcc)) {
                    $data['IsStandardAccount'] = true;
                } else {
                    $data['IsStandardAccount'] = false;
                }
            }else{
                $data['IsStandardAccount'] = false;
            }

            $deposit = FXPP::CI()->g_m->showssingle3($table='deposit',$field="user_id",$id=$user_id,$field2="status",$id2=2,$select="*",$order_by="");

            $nodepositbonus = FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='nodepositbonus,created,createdforadvertising,accountstatus');
            $data['data']['prohibit']=false;


            /*FXPP-7759 Get special referral affiliate code that restrict user accounts*/
            $aff_code =  FXPP::CI()->t_m->getspecialaffiliatecode();
            if($aff_code){
                $affiliate_array=array();
                foreach($aff_code as $aff_key => $aff_value){
                    array_push($affiliate_array,$aff_value['affiliate_code']);
                }
                $user_ref_code =  FXPP::CI()->t_m->getreferralcode($user_id);
                if($user_ref_code){
                    if (in_array($user_ref_code[0]['referral_affiliate_code'], $affiliate_array)) {
                        $data['data']['prohibit']=true;
                    }else{
                        $data['data']['prohibit']=false;
                    }
                }

            }

            /* FXPP-7759 Get special referral affiliate code that restrict user accounts*/

            $conditions= array(
                'nodepositbonus'=>$nodepositbonus['nodepositbonus'],
                'has_rqstd_ndb'=>$data['data']['has_rqstd_ndb'],
                'IsStandardAccount'=>$data['IsStandardAccount'],
                'mt_account_set_id'=>$account_details['mt_account_set_id'],
                'hasdeposit'=>$deposit,
                'IsAcquiredFromOtherAccount'=>$IsAcquiredFromOtherAccount,
                'account_number'=>$account_number,
                'prohibit'=>$data['data']['prohibit']
            );

            $prvt_data['datus'] = array(
                'log2' =>  json_encode($conditions)
            );
            FXPP::CI()->g_m->updatemy($table = 'no_deposit', $field = 'account_number', $id = $account_number, $prvt_data['datus']);


            /*Not related with Crediting but is necessary for process start*/
            /*moved removal of agent before the library*/
            $agentremovalvalidation = false;
            $getAccountAgent = FXPP::GetAccountAgent($account_number);
            if($getAccountAgent){

                $webservice_config = array('server' => 'live_new');
                $WebServiceRemove = new WebService($webservice_config);
                $WebServiceRemove->RemoveAgentOfAccount($account_number);
                if ($WebServiceRemove->request_status === 'RET_OK') {
                    $removeData = array(
                        'AccountNumber' => $account_number,
                        'AgentAccountNumber' => $getAccountAgent,
                        'DateRemoved' => FXPP::getCurrentDateTime()
                    );
                    FXPP::CI()->g_m->insertmy($table = "removed_agents",$removeData);
                    $agentremovalvalidation = true;
                    $mydata['removeagent'] = array(
                        'removeagent_log'=>1
                    );
                    FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $user_id, $mydata['removeagent']);
                }else{
                    $agentremovalvalidation = false;
                    $mydata['removeagent'] = array(
                        'removeagent_log'=>2
                    );
                    FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $user_id, $mydata['removeagent']);
                }
            }else{

                $agentremovalvalidation = true;

                $mydata['removeagent']  = array(
                    'removeagent_log'=>3
                );

                FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $id = $user_id, $mydata['removeagent']);
            }
            /* moved removal of agent before the library */
            /* Not related with Crediting but is necessary for process end */

            if ( ($nodepositbonus['nodepositbonus'] == 0 or  $nodepositbonus['nodepositbonus']==Null) &&
                 ($data['IsStandardAccount']==true) &&
                 ($account_details['mt_account_set_id'] == 1) &&
                 ($deposit==false) &&
                 $IsAcquiredFromOtherAccount==false &&
                 ($data['data']['prohibit']==false) &&
                 $agentremovalvalidation==true
               )
            {
                $FXPP6539 = Bonus_Library::getScoring_v2($user_id);
                $bonus = $FXPP6539['bonus'];
//                $data['arr'] = Bonus_Library::creditNDB_v2($bonus,$account_number,$email);
                echo  $account_number.'/ 1'.'<br/>';
                $prvt_data['datus'] = array(
                    'status' => 1
                );
                FXPP::CI()->g_m->updatemy($table = 'test_credit_ndb_request', $field = 'account_number', $id = $account_number, $prvt_data['datus']);

            }else{

                $prvt_data['datus'] = array(
                    'status' => 2
                );
                 FXPP::CI()->g_m->updatemy($table = 'test_credit_ndb_request', $field = 'account_number', $id = $account_number, $prvt_data['datus']);

            }
        }



    }

    public function getMTAccountDetails($accountNumber, $webservice_config){

        $CI =& get_instance();
        $CI->load->library('WSV'); //New web service

        $accounts = array(
            $accountNumber,
            $CI->session->userdata('account_number') //logged in account
        );

        $serviceData   = array('account_number' => $accounts);
        $requestResult = $CI->wsv->GetAccountDetails($serviceData, $webservice_config);

        $accountListEncode = json_encode($requestResult['Data']);
        $serviceResult = json_decode($accountListEncode,true);

        if(count($serviceResult) > 1){
            $searchKey      = array_search($accountNumber, array_column($serviceResult['accountList'], 'LogIn'));
            $accountDetails = $serviceResult['accountList'][$searchKey];
            return $accountDetails;
        }

        return $serviceResult;
    }

    public static function getScoring_v2($userid)
    {

        FXPP::CI()->load->model('General_model');

        FXPP::CI()->g_m=FXPP::CI()->General_model;

        $data['scoring']=array();
        $total=0;
        $trading_experience = FXPP::CI()->g_m->showssingle2($table='trading_experience',$field='user_id',$id=$userid,$select='investment_knowledge,risk,experience,trade_duration');

        //        echo '1. Knowledge';

        if($trading_experience){
            /*Investment knowledge*/
            switch($trading_experience['investment_knowledge']){
                case 0:
                    /* Non-Existing */
                    $value=0;
                    $total=$total+$value;
                    break;
                case 1:
                    /* Fair */
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2:
                    /* Limited */
                    $value=2;
                    $total=$total+$value;
                    break;
                case 3:
                    /* Excellent */
                    $value=3;
                    $total=$total+$value;
                    break;
            }

            /*Understand Investment Risk*/

            if($trading_experience['risk']==1){
                $value=4;
                $total=$total+$value;
            }else{
                $value=0;
                $total=$total+$value;
            }

            //            echo '2. Experience';

            /* Trading Experience */

            /* $trading_experience['experience'] sting sepated by comma structure ex 0,1,1 data */
            if ($trading_experience['experience']!=''){
                $experience = explode(",",$trading_experience['experience']);

                if($experience[0]){ /*Forex and CFD's */
                    $value=4;
                    $total=$total+$value;
                }

                if($experience[1]){ /* Securities */
                    $value=2;
                    $total=$total+$value;
                }

                if($experience[2]){ /* Other Derivative Products */
                    $value=4;
                    $total=$total+$value;
                }
            }

            /* How often do you trade? */

            switch($trading_experience['trade_duration']){
                case 0: /*Daily*/
                    $value=4;
                    $total=$total+$value;
                    break;
                case 1: /*Weekly*/
                    $value=3;
                    $total=$total+$value;
                    break;
                case 2: /*Monthly*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 3: /*Yearly*/
                    $value=0;
                    $total=$total+$value;
                    break;
            }
        }

        $employment_details = FXPP::CI()->g_m->showssingle2($table='employment_details',$field='user_id',$id=$userid,$select='employment_status,industry,education_level');

        if($employment_details){

            /* Employment Status  field employment_status*/

            /* 0 Employed value 1*/
            /* 1 Self Employed  value 1*/
            /* 2 Retired value 1 */
            /* 3 Student value 1*/
            /* 4 Unemployed  value 1*/
            $value=1;
            $total=$total+$value;

            /* Industry */

            /*
            0   Accountancy
            1   Admin/Secretarial
            2   Agriculture
            3   Finance service - Banking
            4   Catering/Hospitality
            5   Creative/media
            6   Education
            7   Engineering
            8   Financial service - others
            9   Health/Medicine
            10  Emergency Services
            11  HM Forces
            12  HR
            13  Financial Services - insurance
            14  IT
            15  Leisure/Entertainment/Tourism
            16  Manufacturing
            17  Marketing/PR/Advertising
            18  Pharmaceuticals
            */

            switch($employment_details['industry']){
                case 0: /*0 Accountancy*/
                    $value=3;
                    $total=$total+$value;
                    break;

                case 1: /*1 Admin/Secretarial*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2: /*2 Agriculture*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 3: /*4   Finance service - Banking*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 4: /*4   Catering/Hospitality*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 5: /*5   Creative/media*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 6: /*6   Education*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 7: /*7   Engineering*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 8: /*8   Financial service - others*/
                    $value=3;
                    $total=$total+$value;
                    break;
                case 9: /*9   Health/Medicine*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 10: /*10  Emergency Services*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 11: /*11  HM Forces*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 12: /*12  HR*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 13: /*13  Financial Services - insurance*/
                    break;
                case 14: /*14  IT*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 15: /*15  Leisure/Entertainment/Tourism*/
                    $value=1;
                    $total=$total+$value;
                    break;

                case 16: /*16  Manufacturing*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 17: /*17  Marketing/PR/Advertising*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 18: /*18  Pharmaceuticals */
                    $value=1;
                    $total=$total+$value;
                    break;
                default:

            }

            /*27 industries field industry*/

            /* Educational Level */

            /*
                 0 - Elementary
                 1 - High School
                 2 - College / University
                 3 - Master / PHD
                 4 - Professional Qualification
                 5 - Financial Related
            */

            switch($employment_details['education_level']){
                case 0 : /* 0 - Elementary*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 1 : /* 1 - High School*/
                    $value=1;
                    $total=$total+$value;
                    break;
                case 2 : /*2 - College / University*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 3 : /* 3 - Master / PHD*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 4 : /* 4 - Professional Qualification*/
                    $value=2;
                    $total=$total+$value;
                    break;
                case 5 :  /*5 - Financial Related*/
                    $value=4;
                    $total=$total+$value;
                    break;
                default:
            }
            /*field education_level*/

        }

        //        $mt_accounts_set = FXPP::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$userid,$select='registration_ip');
        $user_profiles = FXPP::CI()->g_m->showssingle2($table='user_profiles',$field='user_id',$id=$userid,$select='country');
        //        require_once APPPATH.'/helpers/geoiploc.php';
        $data['Country']=$user_profiles['country'];
        //        $CI =& get_instance();

        //        $ip = $mt_accounts_set['registration_ip'];
        //
        //        if($CI->input->valid_ip($ip)){
        //            $data['Country'] =getCountryFromIP($ip);
        //        }else{
        //            $data['Country'] = 'Invalid';
        //        }

        /*Country 1 and Points 1*/
        /*Bangladesh, China, Hong Kong, Taiwan, Kenya, Uzbekistan, India, Jordan, Lebanon,Other countries of Africa, The others*/
        $data['c1'] = array('BD','CN', 'HK', 'TW', 'KE', 'UZ','IN','JO','LB');//1
        /*Note no africa yet*/


        /*Country 2 and Points 2*/
        /*Indonesia, Latin America, Jordan, Lebanon, Nigeria, Egypt, Morocco, Tunisia Malaysia, Thailand, Antigua and Barbuda,
        Bahamas, Ukraine, Belarus, Latvia, Lithuania, Georgia, Moldova, Russia, Kazakhstan Tasmania, Fiji and other countries of Oceania*/
        $data['c2'] = array('ID','JO','LB','NG','MA','TN','MY','TH','AG','BS','UA','BY','LV','LT','GE','MD','RU','KZ','FJ');//2 //Tasmania not found other countries of Oceania*/
        $data['c2_latinamerica'] = array('AR','BO','BR','CL','CO','CR','CU','DO','EC','SV','GF','GP','GT', 'HT','HN','MQ','MX','NI','PA','PY','PE','PR','MF','UY','VE'); // latin america
        $data['c2_otheroceanis'] = array('TP','AU','CX','CC','NF','NC','PB','PG','SB','VU','FM','GU','KI','MH','NR','MP','PW','UM','AS','CK','PF','NU','PN','WS','TK','TO','TV','WF');
        $data['c2_merge']= array_merge($data['c2'], $data['c2_latinamerica']);
        $data['c2_merge']= array_merge($data['c2_merge'], $data['c2_otheroceanis']);


        /*Country 3 and Points 3*/
        /*"THE REPUBLIC OF SOUTH AFRICA, Saudi Arabia, UNITED ARAB EMIRATES, Brunei" Kuwait, Qatar, Bahrain*/
        $data['c3'] = array('ZA','SA','AE','BN');//3 "ZA" => "South Africa", "SA" => "Saudi Arabia",   "AE" => "United Arab Emirates","BN" => "Brunei Darussalam",

        /*Country 4 and Points 4*/
        /*Poland, Hungary */
        $data['c4'] = array('PL','HU');//4
        /*done*/
        /*Country 5 and Points 5*/
        /*
            Andorra, Australia, Austria, Belgium, Great Britain, Canada, Cyprus, Czech Republic, Estonia, Denmark, Faroes, Finland, France,
            Germany, Greece, Iceland, Ireland, Israel, Italy, Japan, Luxembourg, Malta, Monaco, Netherlands, New Zealand, Norway, Portugal, San Marino,
            Singapore, Slovakia, Slovenia, South Korea, Spain, Sweden, Switzerland
        */
        $data['c5'] = array('AD','AU','AT','BE','GB','CA','CY','CZ','EE','DK','FI','FR','DE','GR','IS','IE','IL','IT','JP','LU','MT','MC','NL','NZ','NO','PT','SM','SG','SK','SI','KR','ES','SE','CH');//4
        /*no great britaion use GB for Uniter Kingdom*/
        /*no Faroes*/
        /*done*/

        if (in_array($data['Country'], $data['c1'])) {
            $value=1;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c2_merge'])) {
            $value=2;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c3'])) {
            $value=3;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c4'])) {
            $value=4;
            $total=$total+$value;
        }else if (in_array($data['Country'], $data['c5'])) {
            $value=5;
            $total=$total+$value;
        }else{
            $value=1;
            $total=$total+$value;
        }

        //25 - 35 	$300
        //15 - 24 	$250
        //11 - 15 	$200
        //0 - 10 	$100
        $score =$total;
        $bonus=0;
        switch(true){
            case ($score <=10):
                /*$100*/
                $bonus=100;
                break;
            case ($score>10 and $score <=15):
                $bonus=200;
                /*$200*/
                break;
            case ($score>15 and $score <=24):
                $bonus=250;
                /*$250*/
                break;
            case ($score>=25 and $score <=35):
                $bonus=300;
                /*$300*/
                break;
        }
        return  array(
            'score'=>$score,
            'bonus'=>$bonus,
            'currency'=>'USD',
            'country'=>$data['Country']
        );
    }

    public static function creditNDB_v2($bonus,$account_number,$email )
    {
        die();
        $data['crediting']=false;
        FXPP::CI()->load->model('account_model');
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->load->model('deposit_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;
        FXPP::CI()->d_m=FXPP::CI()->deposit_model;

        /* add check is this account has already been tagged with acquiring no deposit bonus */
        //$account, $account_number, $amount, $is_cancel = false ,$comment

        $amount = $bonus; /*note amount should be converted depending on the bonus currency of user */

        $comment = 'FOREXMART NO DEPOSIT BONUS';
        $account =  FXPP::CI()->account_model->getAccountsByAccountNumber( $account_number );
        $user_id=$account['user_id'];

        $agentremovalvalidation = false;

        $getAccountAgent = FXPP::GetAccountAgent($account_number);
        if($getAccountAgent=='error'){
            $mydata['removeagent'] = array(
                'removeagent_log'=>4
            );
            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $mydata['removeagent']);
            $agentremovalvalidation = false;

        }elseif($getAccountAgent!=false and $getAccountAgent!='error'){

            $webservice_config = array('server' => 'live_new');
            $WebServiceRemove = new WebService($webservice_config);
            $WebServiceRemove->RemoveAgentOfAccount($account_number);
            if ($WebServiceRemove->request_status === 'RET_OK') {
                $removeData = array(
                    'AccountNumber' => $account_number,
                    'AgentAccountNumber' => $getAccountAgent,
                    'DateRemoved' => FXPP::getCurrentDateTime()
                );
                FXPP::CI()->g_m->insertmy($table = "removed_agents",$removeData);

                $mydata['removeagent'] = array(
                    'removeagent_log'=>1
                );
                FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $mydata['removeagent']);

                $getAccountAgent2 = FXPP::GetAccountAgent($account_number);

                if($getAccountAgent2===false){
                    $agentremovalvalidation = true;
                }

            }else{
                $agentremovalvalidation = false;
                $mydata['removeagent'] = array(
                    'removeagent_log'=>2
                );
                FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $mydata['removeagent']);
            }

        }elseif($getAccountAgent==false){

            $agentremovalvalidation = true;
            $mydata['removeagent']  = array(
                'removeagent_log'=>3
            );
            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $mydata['removeagent']);
        }

        $uservisit = FXPP::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='ndbcreditingvisit');
        if ($uservisit['ndbcreditingvisit']==0){
            $prvt_data['visit']=array(
                'ndbcreditingvisit'=>1
            );
            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $user_id, $prvt_data['visit']);
        }else{
            die();
        }


        if ($account['mt_currency_base']=='USD'){
            $amount_to_database = str_replace(',', '', $amount);
        }else{
            $amount_to_database = FXPP::get_convert_amount($to_currency='USD', $amount, $to_currency = $account['mt_currency_base']);
            $amount_to_database = str_replace(',', '', $amount_to_database);
        }

        $webservice_config = array('server' => 'live_new');
        $WebServiceNDB = new WebService($webservice_config);

        $account_info = array(
            'Login' => $account_number,
            'FundTransferAccountReciever' => $account_number,
            'Amount' => $amount_to_database,
            'Comment' => $comment,
            'ProcessByIP' => FXPP::CI()->input->ip_address()
        );
        /*1st Webservice Call*/

        $WebServiceNDB->open_Deposit_NoDepositBonus($account_info);
        if ($WebServiceNDB->request_status === 'RET_OK') {
            $data['crediting'] = true;
            $date_updated = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $prvt_data['nodepositbonus'] = array(
                'nodepositbonus' => 1,
                'ndb_bonus' => floatval($amount),
                'ndb_ticket'=>$WebServiceNDB->get_result('Ticket'),
                'ndba_acquired' => $date_updated->format('Y-m-d H:i:s'),
                'ndb_bonus_ccy' => floatval($amount_to_database),
                'ndb_cabinet_crediting' => 1
            );

            FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $prvt_data['nodepositbonus']);

            /*Table Logs*/
            $tbl_log = array(
                'user_id'=>$account['user_id'],
                'process'=>'API nodeposit bonus',
                'api'=>'open_Deposit_NoDepositBonus',
                'account_number'=>$account_number,
                'status'=>1
            );
            FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
            /*Table Logs*/


            /*new task email*/
            $data['data']['isUSDorEUR']=false;
            $data['data']['users_currency'] = $account['mt_currency_base'];
            $ccy= array("USD", "EUR");
            if (in_array($account['mt_currency_base'], $ccy)) {
                $data['data']['isUSDorEUR']=true;
            }

            if(strtoupper(FXPP::getUserContinentCode()) == 'EU'){
                $default_currency = 'EUR';

                $data['data']['bonus_negligible_view'] = FXPP::get_convert_amount($to_currency='USD', $amount, $to_currency = 'EUR');
                $data['data']['bonus_negligible_view'] = str_replace(',', '', $data['data']['bonus_negligible_view']);
                if ($account['mt_currency_base'] == 'USD'){
                    $data['data']['bonus'] = $amount;

                }else{
                    $data['data']['bonus'] = $amount_to_database;
                }
            }else{
                $default_currency = 'USD';

                $data['data']['bonus_negligible_view'] = $amount;

                if ($account['mt_currency_base']=='USD'){

                    $data['data']['bonus']=$amount;
                }else{
                    $data['data']['bonus'] = $amount_to_database;

                }
            }

            $email_data = array(   'account_number' => $account_number ,
                'email' => $email ,
                'bonus' => $data['data']['bonus'],
                'isUSDorEUR' => $data['data']['isUSDorEUR'],
                'users_currency' => $account['mt_currency_base'],
                'default_currency' => $default_currency,
                'bonus_negligible_view' => $data['data']['bonus_negligible_view']);

            FXPP::CI()->load->library('Fxpp_email');
            $logs['is_sent'] = Fxpp_email::ndb($email_data);
            $email_data = array(   'account_number' => $account_number ,
                'email' => 'trowabarton00005@gmail.com' ,
                'bonus' => $data['data']['bonus'],
                'isUSDorEUR' => $data['data']['isUSDorEUR'],
                'users_currency' => $account['mt_currency_base'],
                'default_currency' => $default_currency,
                'bonus_negligible_view' => $data['data']['bonus_negligible_view']);

              Fxpp_email::ndb($email_data);

            /*Table Logs*/
            if ($logs['is_sent']){
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'Email',
                    'api'=>'N/A',
                    'account_number'=>$account_number,
                    'status'=>1
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
            }else{
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'Email',
                    'api'=>'N/A',
                    'account_number'=>$account_number,
                    'status'=>2
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
            }
            /*Table Logs*/


            /*new task email*/

            /*2nd Webservice Call*/

            $country = FXPP::CI()->account_model->getAccountsCountry($account['user_id']);
            if(IPLoc::isChinaIP() || $country[0]['country'] == 'CN' || FXPP::html_url() == 'zh' ){
                FXPP::CI()->session->set_userdata('isChina', '1');
            }

           // $groupCurrency = FXPP::CI()->g_m->getGroupCurrency($account['mt_account_set_id'], $account['mt_currency_base'], $account['swap_free']);

            $groupCurrency =  substr($account['group'], 0, -1);
            FXPP::update_account_group_specific($account['user_id']);
            $account_details = FXPP::CI()->account_model->getAccountByUserId($account['user_id']);
            FXPP::CI()->load->model('Managecontest_model');
            $prize_data = array(
                'user_id' => $account['user_id'],
                'account_number' => $account_number,
                'manager_id' => $account['user_id'],
                'amount' => $amount_to_database,
                'comment' => $comment,
                'ticket' => $WebServiceNDB->get_result('Ticket'),
                'date_processed' => FXPP::getCurrentDateTime()
            );

            $i_cp = FXPP::CI()->Managecontest_model->insertCreditPrize($prize_data);
            $logs['i_cp']=$i_cp;
            if($i_cp!=false){
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'Credit Prize',
                    'api'=>'N/A',
                    'account_number'=>$account_number,
                    'status'=>1
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }else{
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'Credit Prize',
                    'api'=>'N/A',
                    'account_number'=>$account_number,
                    'status'=>2
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }


            $groupCurrency .= 'ndb' . $account_details['group_code'];

            $account_info2 = array(
                'iLogin' => $account['account_number'],
                'strGroup' => $groupCurrency
            );
//            $WebService2 = new WebService($webservice_config);
//            $WebService2->open_ChangeAccountGroup($account_info2);

            $WebService2 = FXPP::SetAccountGroup($account['account_number'], $groupCurrency);

            if ($WebService2->request_status == 'RET_OK'){

                $group = $groupCurrency;

                $mdata = array(
                    'group'=> $group,
                );
                FXPP::CI()->g_m->updatemy('mt_accounts_set', 'account_number', $account['account_number'], $mdata);

                $logs['WS2']='OK';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API ChangeAccountGroup',
                    'api'=>'ChangeAccountGroup',
                    'account_number'=>$account_number,
                    'status'=>1
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/


            }else{
                $logs['WS2']='ChangeAccountGroup API error';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API ChangeAccountGroup',
                    'api'=>'ChangeAccountGroup',
                    'account_number'=>$account_number,
                    'status'=>2
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }


            FXPP::CI()->load->model('user_model');
            $user = FXPP::CI()->user_model->getUserProfileByUserId_admin($account['user_id']);
            if (in_array(strtoupper($user['country']), array('PL'))) {
                $account_info3 = array(
                    'iLogin' => $account['account_number'],
                    'iLeverage' => '100'
                );
            } else {
                $account_info3 = array(
                    'iLogin' => $account['account_number'],
                    'iLeverage' => '200'
                );
            }

            /*3rd Webservice Call*/
//            $WebService3 = new WebService($webservice_config);
//            $WebService3->open_ChangeAccountLeverage($account_info3);

            $WebService3 = FXPP::SetLeverage($account['account_number'], $account_info3['iLeverage']);

            if ($WebService3->request_status == 'RET_OK') {
                $logs['WS3']='OK';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API ChangeAccountLeverage',
                    'api'=>'ChangeAccountLeverage',
                    'account_number'=>$account_number,
                    'status'=>1
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }else{
                $logs['WS3']='ChangeAccountLeverage API error';
                /*Table Logs*/
                $tbl_log = array(
                    'user_id'=>$account['user_id'],
                    'process'=>'API ChangeAccountLeverage',
                    'api'=>'ChangeAccountLeverage',
                    'account_number'=>$account_number,
                    'status'=>2
                );
                FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
                /*Table Logs*/
            }

            $sum = floatval($amount_to_database) + floatval($account['amount']);

            $prvt_data['amount'] = array(
                'amount' => $sum,
                'leverage' => '1:'.$account_info3['iLeverage']
            );
            $u_lev_amt = FXPP::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'id', $id = $account['id'], $prvt_data['amount']);
            $logs['u_lev_amt']=$u_lev_amt;

            $date_updated = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

            $prvt_data['nodepositbonus'] = array(
                'nodepositbonus' => 1,
                'ndba_acquired' => $date_updated->format('Y-m-d H:i:s'),
                'ndb_bonus' => floatval($amount),
                'ndb_bonus_ccy' => floatval($amount_to_database),
                'ndb_cabinet_crediting' => 1
            );

            $logs['ndb_bonus'] = (string) $amount;
            $logs['ndb_bonus_ccy'] = (string) $amount_to_database;

            $u_logndb =  FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $prvt_data['nodepositbonus']);

            FXPP::CI()->d_m->setNoDepositRequestStatus($account['user_id'], 1);
            $logs['u_logndb'] = $u_logndb;
            $logs['WS1']='OK';

        }else{
            $data['crediting']=false;
            $logs['WS1']='NoDepositBonus API error';
            /*Table Logs*/
            $tbl_log = array(
                'user_id'=>$account['user_id'],
                'process'=>'API nodeposit bonus',
                'api'=>'open_Deposit_NoDepositBonus',
                'account_number'=>$account_number,
                'status'=>2
            );
            FXPP::CI()->g_m->insertmy($table='no_deposit_logs',$data=$tbl_log);
            /*Table Logs*/
        }

        $data['log']=array(
            'ndb_logs'=> json_encode($logs)
        );

        FXPP::CI()->g_m->updatemy($table = 'users', $field = 'id', $id = $account['user_id'], $data['log']);
        return array(
            'request'=>$data['crediting'],
            'WS1'=>$logs['WS1'],
            'WS2'=>$logs['WS2'],
            'WS3'=>$logs['WS3'],
        );

    }

    public static function tag_test_account( )
    {

        die();
        FXPP::CI()->load->model('Bonus_model');
        FXPP::CI()->b_m=FXPP::CI()->Bonus_model;
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;


        $nodeposit = FXPP::CI()->b_m->get_ndbrequest_fortest();

        //var_dump($nodeposit);
        //die();

        foreach($nodeposit as $key => $value){

            echo ' <br> user_id'. $value['user_id'] .' account_number '. $value['account_number'] . ' IP ' . $value['last_ip'] ;
                $officeip = array(    "78.46.187.12",
                                "78.46.190.237",
                                "78.46.195.217",
                                "210.213.232.29",
                                "5.9.65.183",
                                "148.251.122.78",
                                "136.243.104.88",
                                "115.127.83.18",
                            );
            if (in_array($value['last_ip'], $officeip)) {

                $data['log']=array(
                    'user_id'=> $value['user_id'],
                    'comment'=> 'test ip ='. $value['last_ip']
                );

                FXPP::CI()->g_m->updatemy($table = 'no_deposit', $field = 'user_id', $id = $value['user_id'], $data['log']);

            }

        }
    }

}