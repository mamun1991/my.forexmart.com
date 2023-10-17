<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Virtual_account_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function getVirtualAccountsByUserId( $user_id ){
        $this->db->where('user_id', $user_id);
        $this->db->from('virtual_accounts');
        $data = $this->db->get();

        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    public function isCurrencyExistByUserId( $user_id, $currency ){
        $this->db->where('user_id', $user_id);
        $this->db->where('currency', $currency);
        $this->db->from('virtual_accounts');
        $data = $this->db->get();

        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function insertVirtualAccount( $data ){
        if( $this->db->insert('virtual_accounts', $data) ){
            return true;
        }else{
            return false;
        }
    }
}