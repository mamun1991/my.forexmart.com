<?php
 class Copytrade_model extends CI_Model {
     private $table = 'copytrade_info';
    // private $fc_users = 'copytrade_users';

    function __construct(){
        parent::__construct();
    }

     function IsMasterFollowerExist( $master,$follower ){
         $this->db->select('*');
         $this->db->from($this->table);
         $this->db->where('master_number', $master);
         $this->db->where('follower_number', $follower);
         $data = $this->db->get();
         if($data->num_rows() > 0) {
             return $data->row_array();
         }else{
             return false;
         }
     }
     function IsSubscribeToMaster($follower,$master ){
         $this->db->select('*');
         $this->db->from('copytrade_info');
         $this->db->where('follower_number', $follower);
         $this->db->where('master_number', $master);
         $this->db->where('is_subscribe', 1);
         $data = $this->db->get();
         if($data->num_rows() > 0) {
             return $data->row_array();
         }else{
             return false;
         }
     }

     function updateCopytrade($where,$data){
         $this->db->where($where);
         $this->db->update('copytrade_info', $data);
         if ($this->db->affected_rows() > 0){
             return true;
         }
         return false;
     }



     function getCopytradeInfoByMaster( $account ){
         $this->db->select('*');
         $this->db->from($this->table);
         $this->db->where('follower_number', $account);
         $data = $this->db->get();
         if($data->num_rows() > 0) {
             return $data->result_array();
         }else{
             return false;
         }
     }

     function getCopytradeInfoByFollower( $where,$id ){
         $this->db->select('*');
         $this->db->from($this->table);
         $this->db->where($where, $id);
         $data = $this->db->get();
         if($data->num_rows() > 0) {
             return $data->result_array();
         }else{
             return false;
         }
     }

     function updateCopytradeInfo($master,$follower,$data){
         $this->db->where('master_number', $master);
         $this->db->where('follower_number', $follower);
         $this->db->update($this->table, $data);
         if ($this->db->affected_rows() > 0){
             return true;
         }
         return false;
     }

     function insertCopytradeInfo($data){
         $this->db->insert($this->table,$data);
         return $this->db->insert_id();
     }
     function fcopy_insert($table,$data){
         $this->db->insert($table,$data);
         return $this->db->insert_id();
     }

     public function getMasterAccount($account_number) {
         $this->db->select('forextrader_account_info.*,user_profiles.full_name,mt_accounts_set.leverage,mt_accounts_set.mt_account_set_id,mt_accounts_set.registration_time');
         $this->db->from('forextrader_account_info');
         $this->db->join('mt_accounts_set','mt_accounts_set.account_number = forextrader_account_info.account_number','left');
         $this->db->join('user_profiles','forextrader_account_info.user_id = user_profiles.user_id','left');
         $this->db->where('forextrader_account_info.account_number', $account_number);
         $this->db->where('forextrader_account_info.status', 1);
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
             return $query->row_array();
         }
         return false;
     }

     public function getAllActiveMasterAccount() {
         $this->db->select('*');
         $this->db->from('forextrader_account_info');
         $this->db->where('status', 1);
         $query = $this->db->get();
         if ($query->num_rows() > 0) {
             return $query->result_array();
         }
         return false;
     }

     public function getFollowersCount($account) {
         $this->db->select('*');
         $this->db->from('copytrade_info');
         $this->db->where('is_subscribe', 1);
         $this->db->where('master_number', $account);
         $query = $this->db->get();
         return $query->num_rows();

     }


     function get_where($table, $condition, $select = "*")
     {
         $this->db->select($select);
         $this->db->where($condition);
         $result = $this->db->get($table);
         if ($result->num_rows() > 0) return $result->result_array();
         return false;
     }
     function get_where_row($table, $condition, $select = "*")
     {
         $this->db->select($select);
         $this->db->where($condition);
         $result = $this->db->get($table);
         if ($result->num_rows() > 0) return $result->row_array();
         return false;
     }

 }
