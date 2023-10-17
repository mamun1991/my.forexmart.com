<?php
class Smart_model extends CI_Model {

    private $table = 'smartdollar_info';
    function __construct(){
        parent::__construct();
    }


    function getSmartDollarDetailsByStatus( $status,$user_id ){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', $status);
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

        function gatAllCashedTickets( $status,$account_number ){
        $this->db->select('*');
        $this->db->from('trades_info');
        $this->db->where('status', $status);
        $this->db->where('account_number', $account_number);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    public function updateTicketsStatus($table,$account,$tickets,$data){
            $this->db->where('account_number', $account);
            $this->db->where_in('ticket_id', $tickets);
            $this->db->update($table, $data);
            if ($this->db->affected_rows() > 0){
                return true;
            }
            return false;

    }
    public function updateSmartStatus($table,$user_id,$status,$data){
            $this->db->where('user_id', $user_id);
            $this->db->where('status', $status);
            $this->db->update($table, $data);
            if ($this->db->affected_rows() > 0){
                return true;
            }
            return false;

    }
    public function getTotalRemainingLots($user_id,$status){
           $this->db->select('sum(lots_remaining) as totalLots');
            $this->db->from($this->table);
            $this->db->where('user_id',$user_id);
            $this->db->where('status',$status);
            $data = $this->db->get();
            if ($data->num_rows() > 0) {
                return $data->row()->totalLots;
            }
            return false;

    }
}