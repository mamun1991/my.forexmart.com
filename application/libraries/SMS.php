<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/4/16
 * Time: 11:56 AM
 */

class SMS {

    // https://rest.nexmo.com/sms/json?api_key=df410c08&api_secret=457f057120323d67&from=NEXMO&to=8801554764182&text=Welcome+to+Nexmo

    private   $api_key = "df410c08";
    private   $api_secret = "457f057120323d67";
    private   $from="NEXMO";
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


    function __construct(){

    }

    public function sendSms(){

       echo $url = "https://rest.nexmo.com/sms/json?api_key=".$this->api_key."&api_secret=".$this->api_secret."&from=".$this->from."&to=".$this->to."&text=".urlencode($this->text)."";
       if( $rs = $this->sendRequest($url)){
           return $rs;
       }
        return false;
    }

    public function voice(){
        $url = 'https://rest.nexmo.com/call/json?' . http_build_query(array(
                'api_key' => $this->api_key,
                'api_secret' => $this->api_secret,
                'to' => $this->to,
                'from' => $this->from,
                'answer_url' => 'https://my.forexmart.com/sms_security/voice_answer',
                'status_url' => 'https://my.forexmart.com/sms_security/voice_answer'
            ));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       var_dump(curl_exec($ch))  ;
       var_dump(error_log($ch));

    }
    public  function sendRequest($url){
       /* $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_GET, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
       // curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
        if($result = curl_exec($ch)){
            return $result;
        }
        return curl_error($ch);*/

        return file_get_contents($url);

    }


} 