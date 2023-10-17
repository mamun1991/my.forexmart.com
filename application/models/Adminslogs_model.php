<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adminslogs_model extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->log_db = $this->load->database('logs', true);
    }
    public function get_tables(){
        $this->log_db->reconnect();
        $this->log_db->from('admin_log');
        $query = $this->log_db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
        $this->log_db->close();
    }
    function insertmy($table,$data){
        $this->log_db->reconnect();
        if ($this->log_db->insert($table, $data)){
            return $this->db->insert_id();
        }
        return false;
        $this->log_db->close();
    }
    function updatemy($table,$field,$id,$data){
        $this->log_db->reconnect();
        $this->log_db->where($field, $id);
        $this->log_db->update($table, $data);
        if ($this->log_db->affected_rows() > 0){
            return true;
        }
        return false;
        $this->log_db->close();
    }

    function showssingle($table,$field="",$id="",$select="",$order_by=""){
        $this->log_db->reconnect();
        $this->log_db->select($select);
        $this->log_db->from($table);
        $this->log_db->where($field, $id);
        if ($order_by!=""){
            $this->log_db->order_by($order_by,'asc');
        }
        $data = $this->log_db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
        $this->log_db->close();
    }
    function show() {
        $this->log_db->reconnect();
        $this->log_db->select('*');
        $this->log_db->from('admin_log');
        $data = $this->log_db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
        $this->log_db->close();
    }

    function showS($length, $start,$search,$order) {
        $this->log_db->reconnect();
        switch($order['0']['column']){
            case 0:
                $orderfield='admin_fullname';
                break;
            case 1:
                $orderfield='admin_email';
                break;
            case 2:
                $orderfield='processed_users_id_accountnumber';

                break;
            case 3:
                $orderfield='page';

                break;
            case 4:
                $orderfield='date_processed';

                break;
            case 5:
                $orderfield='data';

                break;
            default:
                $orderfield='admin_fullname';
        }
        $search = "(
                admin_fullname LIKE '%$search%'
                OR UCASE(admin_email) LIKE '%$search%'
                OR UCASE(processed_users_id_accountnumber) LIKE '%$search%'
                OR DATE_FORMAT(date_processed, '%Y-%M-%d %H:%i:%s') LIKE '%$search%'
                OR UCASE(data) LIKE '%$search%'
                OR UCASE(page) LIKE '%$search%')";

        $query = $this->log_db->query("SELECT * FROM admin_log as resutl_table WHERE  ".$search."
ORDER BY ".$orderfield." ".$order[0]['dir']." ,date_processed DESC
LIMIT ".$start." , ".$length."  ;");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;

        $this->log_db->close();
    }
    function showS_countcurrent($search,$order) {
        $this->log_db->reconnect();
        switch($order['0']['column']){
            case 0:
                $orderfield='admin_fullname';
                break;
            case 1:
                $orderfield='admin_email';
                break;
            case 2:
                $orderfield='processed_users_id_accountnumber';

                break;
            case 3:
                $orderfield='page';

                break;
            case 4:
                $orderfield='date_processed';

                break;
            case 5:
                $orderfield='data';

                break;
            default:
                $orderfield='admin_fullname';
        }
        $search = "(
                admin_fullname LIKE '%$search%'
                OR UCASE(admin_email) LIKE '%$search%'
                OR UCASE(processed_users_id_accountnumber) LIKE '%$search%'
                OR DATE_FORMAT(date_processed, '%Y-%M-%d %H:%i:%s') LIKE '%$search%'
                OR UCASE(data) LIKE '%$search%'
                OR UCASE(page) LIKE '%$search%')";

        $query = $this->log_db->query("SELECT * FROM admin_log as resutl_table WHERE  ".$search."
ORDER BY ".$orderfield." ".$order[0]['dir']." ,date_processed DESC
 ;");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;

        $this->log_db->close();
    }
}
