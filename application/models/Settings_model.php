<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function get_payment_fee_by_type( $type ){
        $this->db->from('settings_payment_fee');
        $this->db->where('payment_type', $type);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result =  $query->row_array();
            return $result['withdraw_fee'];
        }else{
            return 0;
        }
    }

    public function getTransactionFeeByType($type){
        $this->db->from('transaction_type')
            ->join('transaction_fee', 'transaction_type.id = transaction_fee.transaction_type_Id', 'left')
            ->where('transaction_type.SubType', $type)
            ->order_by('transaction_fee.DateCreated', 'DESC');

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }

        return false;
    }

    public function getTransactionFeeByTypev2($type,$currency){
        $this->db->from('transaction_type')
            ->join('transaction_fee', 'transaction_type.id = transaction_fee.transaction_type_Id', 'left')
            ->where('transaction_type.SubType', $type)
            ->where('transaction_fee.Currency', $currency)
            ->order_by('transaction_fee.DateCreated', 'DESC');

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }

        return false;
    }


    public function getSystemPass($accountType){
        $this->db->from('system_accounts')
            ->where('Account', $accountType);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }

        return false;
    }

    public function getAllTransactionFeeByType(){
        $this->db->from('transaction_type')
            ->join('transaction_fee', 'transaction_type.id = transaction_fee.transaction_type_Id', 'left')
            ->order_by('transaction_fee.DateCreated', 'DESC');

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }

        return false;
    }
}