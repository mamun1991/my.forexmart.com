<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UPDATE{
    public function CI(){
        $CI =& get_instance();
        return $CI;
    }
    
    public static function leverage_change_pol(){
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=self::CI()->General_model;
        $data=array(
            '101241',
            '101290',
            '101515',
            '101600',
            '101698',
            '107691',
            '108759',
            '108796',
            '108981',
            '109041',
            '109259',
            '109329',
            '109451',
            '109645',
            '109833',
            '110408',
            '110535',
            '110964',
            '111205',
            '111605',
            '112109',
            '112116',
            '112738',
            '114712',
            '114964',
            '140093',
            '141513',
            '142449',
            '143455',
            '143990',
            '144053',
            '145938',
            '146113',
            '146251',
            '146979',
            '147084',
            '147428',
            '147484',
            '148989',
            '149370',
            '149834',
            '149883',
            '149912',
            '149937',
            '149938',
            '150210',
            '150388',
            '150410',
            '150411',
            '150412',
            '150476',
            '150670',
            '150681',
            '150695',
            '150971',
            '151250',
            '151354',
            '151362',
            '151369',
            '151812',
            '152147',
            '152161',
            '152162',
            '152324',
            '152395',
            '152526',
            '152528',
            '152542',
            '152624',
            '153038',
            '153043',
            '153071',
            '153145',
            '153402',
            '153936',
            '154400',
            '155003',
            '155004',
            '155232',
            '156077',
            '156280',
            '156450',
            '156948',
            '158392',
            '159314',
            '159554',
            '159604',
            '159633',
            '159744',
            '159799',
            '159800',
            '159917',
        );
        foreach ($data as $value) {

            $webservice_config = array(
                'server' => 'live_new'
            );
            $account_info3 = array(
                'iLogin' => $value,
                'iLeverage' => '100'
            );
            $WebService2 = new WebService($webservice_config);
            $WebService2->open_ChangeAccountLeverage($account_info3);
            if ($WebService2->request_status == 'RET_OK' ){
                echo $value ."<br/> done ";
                $prvt_data['myleverage'] = array(
                    'leverage' => '1:100'
                );
                $prvt_data['Update_users'] = self::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id =$value , $prvt_data['myleverage']);
            }
        }
    }
    public static function leverage_change_pol2(){
        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=self::CI()->General_model;
        $data=array(
            '101241',
            '101290',
            '101515',
            '101600',
            '101698',
            '107691',
            '108796',
            '108981',
            '109041',
            '109259',
            '109329',
            '109645',
            '110408',
            '111205',
            '111605',
            '112116',
            '114964',
        );
        foreach ($data as $value) {
            $webservice_config = array(
                'server' => 'live_new'
            );
            $account_info3 = array(
                'iLogin' => $value,
                'iLeverage' => '100'
            );
            $WebService2 = new WebService($webservice_config);
            $WebService2->open_ChangeAccountLeverage($account_info3);
            if ($WebService2->request_status == 'RET_OK' ){
                echo $value ." done <br/>";
                $prvt_data['myleverage'] = array(
                    'leverage' => '1:100'
                );
                $prvt_data['Update_users'] = self::CI()->g_m->updatemy($table = 'mt_accounts_set', $field = 'account_number', $id =$value , $prvt_data['myleverage']);
            }else{
                echo $value ."  <br/>";
            }
        }
    }

    public static function single_leverage_change(){
        $user_id=61085;
        $data['leverage']=100;
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $off_leverage = self::CI()->g_m->showssingle2($table='turnedoff_leverage',$field='user_id',$id=$user_id,$select='user_id,action');

        if($off_leverage){

        }else{


            $mtas = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$user_id,$select='account_number,amount');
            var_dump($mtas['account_number']);
//            die();

            $config = array(
                'server' => 'live_new'
            );
            $info = array(
                'iLogin' => $mtas['account_number'],
                'iLeverage' => $data['leverage']
            );

            $WebService = new WebService($config);
            $WebService->open_ChangeAccountLeverage( $info );
            if( $WebService->request_status === 'RET_OK' ) {
                $data['lev_ratio']=array(
                    'leverage'=>'1:'.$data['leverage'],
                    'auto_leverage_change'=>1
                );
                self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $user_id, $data['lev_ratio']);
            }else{

            }
        }
    }
    public static function manual_leverage_auto_change(){
        //jira FXPP-2866
        //1. If the balance is over 1k --> leverage changes to 1:1000 automatically
        //2. If the balance is over 3k --> leverage changes to 1:500 automatically.
//        if(IPLoc::Office()){
        $user_id=63062;
        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $off_leverage = self::CI()->g_m->showssingle2($table='turnedoff_leverage',$field='user_id',$id=$user_id,$select='user_id,action');

        if($off_leverage){

        }else{


            $mtas = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=$user_id,$select='account_number,amount');

            $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=$user_id,$select='micro'); if($isMicro['micro']==1){$mtas['amount'] = $mtas['amount']/100;  }// FXPP-8239

            if(floatval($mtas['amount'])>floatval(1000) and floatval($mtas['amount'])<floatval(3000)){
                $data['leverage']=1000;
            }else if (floatval($mtas['amount'])>floatval(3000)){
                $data['leverage']=500;

            }

            if (floatval($mtas['amount'])>floatval(1000)){ // if balance is greater than 1000 active change leverage
                $config = array(
                    'server' => 'live_new'
                );
                $info = array(
                    'iLogin' => $mtas['account_number'],
                    'iLeverage' => $data['leverage']
                );

                $WebService = new WebService($config);
                $WebService->open_ChangeAccountLeverage( $info );
                if( $WebService->request_status === 'RET_OK' ) {
                    $data['lev_ratio']=array(
                        'leverage'=>'1:'.$data['leverage'],
                        'auto_leverage_change'=>1
                    );
                    self::CI()->g_m->updatemy('mt_accounts_set', 'user_id', $user_id, $data['lev_ratio']);

                }else{

                }
            }
        }

    }
    public static function leverage_auto_change(){
        var_dump('in');

        self::CI()->load->model('General_model');
        self::CI()->g_m=self::CI()->General_model;
        $user_profile = self::CI()->g_m->showssingle3($table='user_profiles',$field="user_id",$id=73350,$field2="country",$id2="PL",$select="country",$order_by="");
        if ($user_profile['country']!='PL'){
            $off_leverage = self::CI()->g_m->showssingle2($table='turnedoff_leverage',$field='user_id',$id=73350,$select='user_id,action');
            var_dump($off_leverage);
//            if($off_leverage){
//                echo 1;
//            }else{
                echo 2;
                $mtas = self::CI()->g_m->showssingle2($table='mt_accounts_set',$field='user_id',$id=73350,$select='account_number,amount,mt_currency_base');

                if($mtas['mt_currency_base']=='USD'){
                    $data['amount'] = $mtas['amount'];
                }else{
                    $data['amount']  = self::getCurrencyRate($amount=$mtas['amount'], $from_currency=strtoupper(trim($mtas['mt_currency_base'])), $to_currency="USD");
                }

            $isMicro = self::CI()->g_m->showssingle2($table='users',$field='id',$id=73350,$select='micro'); if($isMicro['micro']==1){$data['amount'] = $data['amount']/100;  }// FXPP-8239


                if (floatval(  $data['amount'])>floatval(1000)){ // if balance is greater than 1000 active change leverage
                    $data['leverage']=500;
                    var_dump($data['amount'] );
                    if(floatval(  $data['amount'])>floatval(1000) and floatval(  $data['amount'])<floatval(3000)){
                        echo 1000;
                        $data['leverage']=1000;
                    }else if (floatval(  $data['amount'])>floatval(3000)){
                        echo 500;
                        $data['leverage']=500;
                    }

                    $config = array(
                        'server' => 'live_new'
                    );
                    $info = array(
                        'iLogin' => $mtas['account_number'],
                        'iLeverage' => $data['leverage']
                    );

                    $WebService = new WebService($config);
                    $WebService->open_ChangeAccountLeverage( $info );
                    if( $WebService->request_status === 'RET_OK' ) {
                        echo 'Done';
                        $data['lev_ratio']=array(
                            'leverage'=>'1:'.$data['leverage'],
                            'auto_leverage_change'=>1
                        );
                        FXPP::CI()->g_m->updatemy('mt_accounts_set', 'user_id', 73350, $data['lev_ratio']);
                        self::CI()->load->model('Autochangeleverage_model');
                        $data['log']=array(
                            'accountnumber'=>$mtas['account_number'],
                            'user_id' => $_SESSION['user_id'],
                            'leverage_db' => '1:'.$data['leverage'],
                            'leverage_api' =>  $data['leverage'],
                            'date' => FXPP::getCurrentDateTime(),
                        );
                        self::CI()->Autochangeleverage_model->insertLeverageLogs('leverage_autochange',$data['log']);
                    }
                }
//            }
        }

    }
    public static function getCurrencyRate($amount, $from_currency, $to_currency){

        $webservice_config = array(
            'server' => 'converter'
        );

        $WebServiceA = new WebService($webservice_config);
        $convertDetails = array(
            'Amount' => $amount,
            'FromCurrency' => $from_currency,
            'ServiceLogin' => 505641,
            'ServicePassword' => '5fX#p8D^c89bQ',
            'ToCurrency' => $to_currency
        );
        $ConvertCurrency = $WebServiceA->ConvertCurrency($convertDetails);
        $resultConvertCurrency = $ConvertCurrency['ConvertCurrencyResult'];
        if ($resultConvertCurrency['Status'] === 'RET_OK') {
            $convertedAmount = $resultConvertCurrency['ToAmount'];
        } else {
            $convertedAmount=$amount;
        }

        return $convertedAmount;
    }
}