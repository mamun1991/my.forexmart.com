<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class CurrencyConverter {

    public static $logs = '';

    public static function GetProxy($debug = false) {
        try	{
            $CI =& get_instance();

            $streamContext = stream_context_create(array(
                'ssl' => array(
                    'verify_peer' => false,
                    'allow_self_signed' => true
                )
            ));

            $webService = 'http://136.243.89.90:9088/Converter.svc?singleWsdl';

            $processor = new SoapClient($webService, array(
                    'trace' => 1,
                    'exception' => 0,
                    'login' => '505641',
                    'password' => '5fX#p8D^c89bQ',
                    "stream_context" => $streamContext
            ));
            return $processor;
        } catch (SoapFault $e) {
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetProxy',null)
            );
        }
    }

    public static function Exception($e,$subject,$aData) {
        echo 'test';
    }

    public static function ConvertCurrency($proxy, $convertDetails){
        $data = array(
            'Amount' => $convertDetails['Amount'],
            'FromCurrency' => $convertDetails['FromCurrency'],
            'ServiceLogin' => $convertDetails['ServiceLogin'],
            'ServicePassword' => $convertDetails['ServicePassword'],
            'ToCurrency' => $convertDetails['ToCurrency']
        );

        try{
            $oaConvertCurrencyAfter = json_encode($proxy->ConvertCurrency($data));
            $aConvertCurrencyAfter = json_decode($oaConvertCurrencyAfter,true);
            return $aConvertCurrencyAfter;
        }catch (SoapFault $e){
            return array(
                'SOAPError' => true,
                'Message' => $e->getMessage(),
                'LogId' => self::Exception($e,'GetProxy',null)
            );
        }

    }


}