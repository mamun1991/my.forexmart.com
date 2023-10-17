<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');
class Password_hash
{
    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        $this->ci->load->model('user_model');
        $this->ci->load->config('tank_auth', TRUE);
        $this->ci->load->library('tank_auth');
        $this->ci->lang->load('tank_auth');
        $this->ci->load->database();
        $this->ci->load->model('tank_auth/users');
    }

    function change_password($old_pass, $new_pass ){

        $hasher = new PasswordHash(
            $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
            $this->ci->config->item('phpass_hash_portable', 'tank_auth'));

        $hashed_password = $hasher->HashPassword($new_pass);
        return $hashed_password;

    }

    function check_password($password){
        $user_id = $this->ci->session->userdata('user_id');
        $user = $this->ci->users->get_user_by_id($user_id, TRUE);

        $hasher = new PasswordHash(
            $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
            $this->ci->config->item('phpass_hash_portable', 'tank_auth'));

        if ($hasher->CheckPassword($password, $user->password)) {
            return true;
        }else{
            return false;
        }
    }
}