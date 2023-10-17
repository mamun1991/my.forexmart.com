<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pamm_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }


    public function getAccountNumber($user_id){
        $this->db->select('account_number');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $return = $data->row_array();
            return $return['account_number'];
        } else {
            return false;
        }
    }


}
