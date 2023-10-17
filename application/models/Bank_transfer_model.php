<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank_transfer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getBankById($id){
        $this->db->from('bank_transfer_banks');
        $this->db->where('id', $id);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getBankAccountByBankCurrency($bank_id, $currency){
        $this->db->from('bank_transfer_accounts');
        $this->db->where('bank_id', $bank_id);
        $this->db->where('currency', $currency);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }
}