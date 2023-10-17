<?php


class API
{
    private $endpoint_session = 'http://136.243.89.90:8044/GlobalSessionService.svc';
    private $endpoint_cabinet = "http://136.243.89.90:9052/ClientCabinet.svc";
    
    private function getSessionUrl($method_name){
        return $this->endpoint_session."/".$method_name;
    }

    private function callPostAPI($url,$data){
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);      
        curl_close($ch);
        return $result;

    }

    private function callGetAPI($url){
        $ch = curl_init($url);       
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function jsonData($data){

        return array('data'=>json_decode($data));
    }
   

    public function createSession($user,$password){

        $data = array(
            'Login' => $user,
            'Password' => $password
        );
        $post_data = json_encode(array("Request" => $data));
        return  $this->jsonData( $this->callPostAPI($this->getSessionUrl('CreateSession'),$post_data));


    }

    public function executeGetUrl(){
     echo   $url = $this->endpoint_cabinet."/".join("/",func_get_args());
        return $this->jsonData($this->callGetAPI($url));
    }
    
}






