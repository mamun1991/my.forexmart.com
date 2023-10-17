<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_model extends CI_Model
{
    private $table = 'deposit';
    private $table_queue = 'deposit_queue';
    private $table_deposit_bonus = 'deposit_bonus';
    private $table_no_deposit = 'no_deposit';

    function __construct()
    {
        parent::__construct();
    }

    function get_ndbrequest(){
        $this->db->select('user_id,account_number')
            ->from($this->table_no_deposit)
            ->where('is_approved', 0)
            ->where('qual', 0);
//            ->limit(1);

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }
    function get_ndbrequest_fortest(){
        $this->db->select('user_id,account_number,last_ip')
            ->join('users',' users.id = no_deposit.user_id')
            ->from($this->table_no_deposit)
            ->where('is_approved', 0);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }
    function get_ndbrequest_test(){
        $this->db->select('user_id,account_number,')
            ->from($this->table_no_deposit)
            ->where('account_number', 247396);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }
    function get_ndbqualified_v2(){
        $this->db->select('email,account_number,unique_email,no_deposit.id')
            ->from($this->table_no_deposit)
            ->join('users', 'users.id = no_deposit.user_id')
            ->where('is_approved', 0)
            ->where('qualifications', 1)
            ->where('no_deposit.id', 38887);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    function get_ndbqualified(){
        $this->db->select('email,account_number,unique_email,no_deposit.id')
            ->from($this->table_no_deposit)
            ->join('users', 'users.id = no_deposit.user_id')
            ->where('is_approved', 0)
            ->where('qualifications', 1);
//            ->limit(5);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }


    function get_ndb_accounts($email,$table_id){
        $this->db->select('email,account_number,unique_email,no_deposit.id')
            ->from($this->table_no_deposit)
            ->join('users', 'users.id = no_deposit.user_id')
            ->where('is_approved', 0)
            ->where('qualifications', 1)
            ->where('UCASE(email)', strtoupper($email))
            ->where('no_deposit.id!=', $table_id)
            ->where('no_deposit.unique_email', 0);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }

    function checkaccounthasUEmailtag($table_id){

        $this->db->select('account_number')
            ->from($this->table_no_deposit)
            ->where('is_approved', 0)
            ->where('qualifications', 1)
            ->where('no_deposit.id', $table_id)
            ->where('no_deposit.unique_email', 0);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;


    }
    function get_ndbrequest_new(){
        $this->db->select('user_id,account_number')
            ->from('test_credit_ndb_request')
            ->where('status', 0);
//            ->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
        return false;
    }
}