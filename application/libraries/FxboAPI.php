<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 4/3/19
 * Time: 4:00 PM
 */

class FxboAPI {

    private   $end_point = "https://personal.forexmart.eu/rest/users/new?version=1.0.0";
    private   $login_api = "https://personal.forexmart.eu/rest/user/direct_login?version=1.0.0";
    private   $get_details_by_id = "https://personal.forexmart.eu/rest/users/";
    private   $check_credentials = "https://personal.forexmart.eu/rest/user/check_credentials?version=1.0.0";
    private  $key = "YWU5ZjlmMWE0ZDFkOTU5ZWIyYWEyOGNkM2NjZThmNWM1ZmI1OWRmM2YwYWZkN2YzYWNmMGUyNThkZThmN2ZkZA";

    //login
    private   $login = "forexmart_site";
    private   $password = "8SWT6wYscZ";

    public function request(array $post_data){
        $process = curl_init($this->end_point);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json")
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

    public function check_credentials(array $login_data){
        $process = curl_init($this->check_credentials);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json")
        );
        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($login_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }


    public function request_login(array $login_data){
        $process = curl_init($this->login_api);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json")
        );
        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($login_data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }

    public function get_details_by_id($user_id){
        $url = $this->get_details_by_id . $user_id . '?version=1.0.0';
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
                "accept: application/json",
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json")
        );
        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        if($response = curl_exec($process)){
            return json_decode($response);
        }
        return false;
    }

} 