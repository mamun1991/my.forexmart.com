<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//class PammService  extends SoapService{
class PammService {

    private $proxy;
    public $request_status;
    public $ticket;
    public $result = array();
    private $request_ip;

    private $config_keys_allowed = array(
        'url', 'service_id', 'service_password'
    );

    protected $service_id = '';
    protected $service_password = '';

    protected $url;
    /* Help locations
     * 'pamm'  help link -> http://144.76.159.179:8850/html/92c3be91-5b50-430f-b1a3-8cd52fa6eb6d.htm
     *
     */
    protected  $server_url = array(
        'pamm' => 'http://144.76.159.179:8810/PammService.svc?singleWsdl',
        'pamm_livefeeds' => 'http://144.76.159.179:1133/Monitoring.svc?singleWsdl',
    );

    public function PammService( $config = array() ){
        $ci =& get_instance();
        $this->request_ip = $ci->input->ip_address();
        self::initialize($config);
        // exit;
        // try	{
        //     $this->url = $this->server_url[$config['server']];
        //     $this->proxy = new SoapClient($this->url, array(
        //         'soap_version'=> SOAP_1_1,
        //         'exceptions' => true,
        //         'trace' => true,
        //         'features' => SOAP_SINGLE_ELEMENT_ARRAYS
        //     ));
        //     return true;
        // }catch (SoapFault $e) {
        //     return array(
        //         'SOAPError' => true,
        //         'Message' => $e->getMessage(),
        //         'LogId' => self::Exception($e,'GetProxy',null)
        //     );
        // }
    }

    /**
     * Initialize WebService with given $config
     */
    protected function initialize( $config ){
        try {

            if( array_key_exists('server', $config) ){
                if( array_key_exists($config['server'], $this->server_url) )
                    $this->url = $this->server_url[$config['server']];
                else
                    $this->url = $this->server_url['pamm'];
            }else{
                $this->url = $this->server_url['pamm'];
            }

            $array =  array(
                'soap_version'=> SOAP_1_1,
                'exceptions' => true,
                'trace' => true,
                'features' => SOAP_SINGLE_ELEMENT_ARRAYS
            );
            
            $this->proxy = new SoapClient($this->url,$array);

            return true;
        }catch (SoapFault $e) {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetProxy',null)
            );
        }
    }



    public function get_result( $field ){
        if( array_key_exists($field, $this->result) ) {
            return $this->result[$field];
        }else{
            return false;
        }
    }

    public function get_all_result(){
        return $this->result;
    }

    protected function get_array_object($object){
        $arrayObject = new ArrayObject($object);
        return $arrayObject->getArrayCopy();
    }

    public function __destruct(){

        unset($this);
    }

    public static function Exception($e, $subject, $eData) {
        //error logging
    }

    /*
     * Method to get the PAMM user account number condition set 1 to 4
     *
     */

    public function open_GetConditionsSetOfPammTrader ( $account_info = array() ) {

        $eData = array();

        try {

            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'brokerId' => 0
            );

            $oAccountData = $this->proxy->GetConditionsSetOfPammTrader($data);
            $this->request_status = $oAccountData->GetConditionsSetOfPammTraderResult;
            return true;
        } catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetConditionsSetOfPammTrader',$eData)
            );

        }

    }

    /*
     *  Method to set the  PAMM user account number condition set 1 to 4
     *
     *
     */
    public function open_SetTraderConditionPackage ( $account_info = array() ) {
        $eData = array();

        try {
            $data = array(
                'iPammTrader' => $account_info['iPammTrader'],
                'conditionSets' => array(
                    'PTConditionPackage' =>
                    array(
                        0 => array(
                                 'ConditionSetNumber' => 1,
                                 'IsConditionEnable'  => $account_info['IsConditionEnable0'],
                                'MinInvestmentAmount' => $account_info['MinInvestmentAmount0'],
                     'MinimumInvestmentTimeInSeconds' => $account_info['MinimumInvestmentTimeInSeconds0'],
                                 'PenaltyPersentBack' => $account_info['PenaltyPersentBack0'],
                                       'ProjectShare' => $account_info['ProjectShare0'],
                        ),
                        1 =>   array(
                                'ConditionSetNumber' => 2,
                                'IsConditionEnable'  => $account_info['IsConditionEnable1'],
                               'MinInvestmentAmount' => $account_info['MinInvestmentAmount1'],
                    'MinimumInvestmentTimeInSeconds' => $account_info['MinimumInvestmentTimeInSeconds1'],
                                'PenaltyPersentBack' => $account_info['PenaltyPersentBack1'],
                                      'ProjectShare' => $account_info['ProjectShare1'],
                        ),
                        2=>   array(
                                'ConditionSetNumber' => 3,
                                'IsConditionEnable'  => $account_info['IsConditionEnable2'],
                               'MinInvestmentAmount' => $account_info['MinInvestmentAmount2'],
                    'MinimumInvestmentTimeInSeconds' => $account_info['MinimumInvestmentTimeInSeconds2'],
                                'PenaltyPersentBack' => $account_info['PenaltyPersentBack2'],
                                      'ProjectShare' => $account_info['ProjectShare2'],
                        ),
                        3 =>   array(
                                'ConditionSetNumber' => 4,
                                'IsConditionEnable'  => $account_info['IsConditionEnable3'],
                               'MinInvestmentAmount' => $account_info['MinInvestmentAmount3'],
                    'MinimumInvestmentTimeInSeconds' => $account_info['MinimumInvestmentTimeInSeconds3'],
                                'PenaltyPersentBack' => $account_info['PenaltyPersentBack3'],
                                      'ProjectShare' => $account_info['ProjectShare3'],
                        )
                    )
                ),
                'minimalInvestment' => $account_info['minimalInvestment'],
                'brokerId' => 0,
            );

            $oAccountData = $this->proxy->SetTraderConditionPackage($data);
            $this->request_status = $oAccountData->SetTraderConditionPackageResult;
            return true;
        } catch (SoapFault $e) {

            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetConditionsSetOfPammTrader',$eData)
            );

        }
    }




    // public function open_GetPammAccountInfo($account_info = array()){
    //     $eData = array();

    //     try {

    //         $data = array(
    //             'iAccount' => $account_info['iAccount'],
    //             'brokerId' => $account_info['brokerId'],
    //         );

    //         $oAccountData = $this->proxy->GetPammAccountInfo($data);
    //         $this->result = $oAccountData->GetPammAccountInfoResult;
    //         $this->result_array = self::get_array_object($oAccountData->GetPammAccountInfoResult);
    //         return true;

    //     } catch (SoapFault $e)  {
    //         return array(
    //             'SOAPError' => true,
    //             'Message' => $e->getMessage(),
    //             'LogId' => self::Exception($e,'GetPammAccountInfo',$eData)
    //         );
    //     }
    // }

    public function open_GetPammAccountInfo($account_info = array()){
        $eData = array();

        try {

            $data = array(
                'iAccount' => $account_info['iAccount'],
                'brokerId' => $account_info['brokerId'],
            );

            $oAccountData = $this->proxy->GetPammAccountInfo($data);
            $this->result = $oAccountData->GetPammAccountInfoResult;
            $this->result_array = self::get_array_object($oAccountData->GetPammAccountInfoResult);
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetPammAccountInfo',$eData)
            );
        }
    }

    /*
    * pamm_livefeeds method
    */

    public function open_GetPammTradersMonitoringDataCustom($account_info = array()){
        $eData = array();

        try {
            $data = array(
                'request' => array(
                         'AccountFilter' => $account_info['AccountFilter'],
                               'Filters' => array(
                                   'ActiveInvestorsFrom' => $account_info['ActiveInvestorsFrom'],
                                     'ActiveInvestorsTo' => $account_info['ActiveInvestorsTo'],
                                           'BalanceFrom' => $account_info['BalanceFrom'],
                                             'BalanceTo' => $account_info['BalanceTo'],
                                     'CurrentTradesFrom' => $account_info['CurrentTradesFrom'],
                                       'CurrentTradesTo' => $account_info['CurrentTradesTo'],
                                          'DailyBalFrom' => $account_info['DailyBalFrom'],
                                            'DailyBalTo' => $account_info['DailyBalTo'],
                                       'DailyEquityFrom' => $account_info['DailyEquityFrom'],
                                         'DailyEquityTo' => $account_info['DailyEquityTo'],
                                       'DailyProfitFrom' => $account_info['DailyProfitFrom'],
                                         'DailyProfitTo' => $account_info['DailyProfitTo'],
                                            'EquityFrom' => $account_info['EquityFrom'],
                                              'EquityTo' => $account_info['EquityTo'],
                                    'Month_3_ProfitFrom' => $account_info['Month_3_ProfitFrom'],
                                      'Month_3_ProfitTo' => $account_info['Month_3_ProfitTo'],
                                    'Month_6_ProfitFrom' => $account_info['Month_6_ProfitFrom'],
                                      'Month_6_ProfitTo' => $account_info['Month_6_ProfitTo'],
                                    'Month_9_ProfitFrom' => $account_info['Month_9_ProfitFrom'],
                                      'Month_9_ProfitTo' => $account_info['Month_9_ProfitTo'],
                                     'MonthlyProfitFrom' => $account_info['MonthlyProfitFrom'],
                                       'MonthlyProfitTo' => $account_info['MonthlyProfitTo'],
                                      'SimpleRatingFrom' => $account_info['SimpleRatingFrom'],
                                        'SimpleRatingTo' => $account_info['SimpleRatingTo'],
                                   'SinceRegisteredFrom' => $account_info['SinceRegisteredFrom'],
                                     'SinceRegisteredTo' => $account_info['SinceRegisteredTo'],
                                       'TotalProfitFrom' => $account_info['TotalProfitFrom'],
                                         'TotalProfitTo' => $account_info['TotalProfitTo'],
                                       'TotalTradesFrom' => $account_info['TotalTradesFrom'],
                                         'TotalTradesTo' => $account_info['TotalTradesTo'],
                                      'WeeklyProfitFrom' => $account_info['WeeklyProfitFrom'],
                                        'WeeklyProfitTo' => $account_info['WeeklyProfitTo'],
                               ),
                    'HasFilterToColumns' => $account_info['HasFilterToColumns'],
                                 'Limit' => $account_info['Limit'],
                                'Offset' => $account_info['Offset'],
                            'OrderByAsc' => $account_info['OrderByAsc'],
                     'OrderByColumnName' => $account_info['OrderByColumnName']
                )
            );

            $oAccountData = $this->proxy->GetPammTradersMonitoringDataCustom($data);
            $this->result = $oAccountData->GetPammTradersMonitoringDataCustomResult;
            return true;

        } catch (SoapFault $e)  {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetPammTradersMonitoringDataCustom',$eData)
            );
        }
    }



}