<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/16/15
 * Time: 11:18 AM
 */

class Gmail {

    public   $client_id = '586993417817-hbp9p51bg59q8r19o0rudn6l9b3orthg.apps.googleusercontent.com';
    public   $client_secret = 'djMX9mSEYkAwaCGhylgXq5BC';
    public   $redirect_uri = 'https://my.forexmart.com/invite_friend/syncEmail';
    public  $max_results = 25;


    private  function curl_file_get_contents($url)
    {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

        curl_setopt($curl,CURLOPT_URL,$url);	//The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);	//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);	//The number of seconds to wait while trying to connect.

        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);	//The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);	//To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);	//To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);	//The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);	//To stop cURL from verifying the peer's certificate.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }
    public function getApiInfo(){

       return $fields=array(
            'client_id'=>  urlencode($this->client_id),
            'client_secret'=>  urlencode($this->client_secret),
            'redirect_uri'=>  urlencode($this->redirect_uri),
        );
    }

    public function getContract($auth_code){

        $fields=array(
            'code'=>  urlencode($auth_code),
            'client_id'=>  urlencode($this->client_id),
            'client_secret'=>  urlencode($this->client_secret),
            'redirect_uri'=>  urlencode($this->redirect_uri),
            'grant_type'=>  urlencode('authorization_code')
        );

        $post = '';
        foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
        $post = rtrim($post,'&');

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl,CURLOPT_POST,5);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
        $result = curl_exec($curl);
        curl_close($curl);

        $response =  json_decode($result);

        $accesstoken = $response->access_token;

        $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$this->max_results.'&oauth_token='.$accesstoken;
        $xmlresponse = $this->curl_file_get_contents($url);
        if((strlen(stristr($xmlresponse,'Authorization required'))>0) && (strlen(stristr($xmlresponse,'Error '))>0))
        {
           return false;
            exit();
        }

        $xml =  new SimpleXMLElement($xmlresponse);
        $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
        $result = $xml->xpath('//gd:email');

        $email_array = array();
        foreach ($result as $title) {
            $email_array[] = $title->attributes()->address;

        }
        return $email_array;
    }







} 