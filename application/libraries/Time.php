<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time {

    function __construct(){

    }

    public static function InWeek(){

        $data = FXPP::CI()->general_model->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='created,createdforadvertising');

        if(is_null($data['createdforadvertising'])){

        }else{
            $data['created'] = $data['createdforadvertising'];
        }

        $data['cFF_created'] = DateTime::createFromFormat('Y-m-d H:i:s',$data['created']);
        $data['difference'] = FXPP::CI()->general_model->difference_day($data['cFF_created']->format('Y-m-d'),$data['cFF_current']= date('Y-m-d'));
        $data['return'] = ($data['difference'] > 7 ?  false : true);

        return $data['return'];
        unset($data);


    }

    public static function InMonth(){

    }

    public static function InYear(){

    }

}