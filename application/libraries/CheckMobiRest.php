<?php
/**
 * Created by PhpStorm.
 * User: IT Grow
 * Date: 12/29/2019
 * Time: 1:15 PM
 */

class CheckMobiRest
{

    // https://api.checkmobi.com/v1/sms/send

    private $url = "https://api.checkmobi.com/v1/sms/send";
    private $method = "POST";
    private   $api_secret = "C74C5A05-2D9B-4CB0-9FFA-BE007A8EA18D";
    private   $from="CheckMobi";
    private     $to="";
    private     $text="";

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }


    function __construct()
    {

    }

    public function SendSMS(){
        $process = curl_init($this->url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: C74C5A05-2D9B-4CB0-9FFA-BE007A8EA18D",
                "Content-Type: application/json")
        );

        $post_data = array(
            "to" =>$this->to,
            "text" => $this->text,
            "platform" => "web"
        );

        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }

    public function SendSMSTest(){
        $process = curl_init($this->url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: C74C5A05-2D9B-4CB0-9FFA-BE007A8EA18D",
                "Content-Type: application/json")
        );

        $post_data = array(
            "to" =>'8801873330895',
            "text" => '12345',
            "platform" => "web"
        );

        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }

    public function SendSMSTestV2($phone){//FXMAIN-92
        $process = curl_init($this->url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: C74C5A05-2D9B-4CB0-9FFA-BE007A8EA18D",
                "Content-Type: application/json")
        );

        $post_data = array(
            "to" =>$phone,
            "text" => '12345',
            "platform" => "web"
        );

        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }
}