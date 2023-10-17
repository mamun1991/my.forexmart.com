<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Managecontest_model extends CI_Model
{	
	function __construct(){
		parent::__construct();

	}
    function showt3w2j2($table1,$table2,$table3,$field1="",$id1="",$select="",$join12,$join23,$order) {
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->join($table3 ,$join23);
        $this->db->where($field1, $id1);
        $this->db->order_by($order,'desc');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function getAllContestWinnersByToken( $token = '', $search_by = '' ){
        $this->db->from('contest_winners');

        if( $token != '' ) {
            switch($search_by){
                case 'account_number' :
                    $search = "contest_winners.account_number LIKE '%$token%'";
                    break;
                case 'nickname' :
                    $search = "contest_winners.nickname LIKE '%$token%'";
                    break;
            }
            if(trim($search) != '') {
//                $this->db->where('contest_winners.rank <=', 10);
                $this->db->where($search, null, false);
            }
        }
        $this->db->where('contest_winners.end_date <=', date('Y-m-d 22:59:59', strtotime('last friday', strtotime('yesterday'))));
        $this->db->order_by('contest_winners.rank');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getLimitAllContestWinnersByToken( $limit, $offset, $token = '', $search_by = '' ){
        $this->db->select('contest_winners.*, contestmoneyfall.City');
        $this->db->from('contest_winners');
        $this->db->join('contestmoneyfall', 'contestmoneyfall.users_id = contest_winners.user_id', 'inner');
        if( $token != '' ) {
            switch($search_by){
                case 'account_number' :
                    $search = "contest_winners.account_number LIKE '%$token%'";
                    break;
                case 'nickname' :
                    $search = "contest_winners.nickname LIKE '%$token%'";
                    break;
            }
            if(trim($search) != '') {
//                $this->db->where('contest_winners.rank <=', 10);
                $this->db->where($search, null, false);
            }
        }
        $this->db->where('contest_winners.end_date <=', date('Y-m-d 22:59:59', strtotime('last friday', strtotime('yesterday'))));
        $this->db->limit($limit, $offset);
        $this->db->order_by('contest_winners.rank');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getAllContestWinnersByDates( $datefrom = '', $dateto = '' ){
        $this->db->from('contest_winners');
                if( strtotime($datefrom) > 0 && strtotime($dateto) > 0 ) {
            $this->db->where('contest_winners.start_date >=', date('Y-m-d 00:00:00', strtotime($datefrom)));
            $this->db->where('contest_winners.end_date <=', date('Y-m-d 23:59:59', strtotime($dateto)));
//            $this->db->where('contest_winners.end_date <=', date('Y-m-d 22:59:59', strtotime('last friday', strtotime('yesterday'))));
//            $this->db->where('contest_winners.rank <=', 10);
        }else{
            $this->db->where('contest_winners.end_date <=', date('Y-m-d 23:59:59', strtotime('last friday', strtotime('yesterday'))));
//            $this->db->where('contest_winners.rank <=', 10);
        }
        $this->db->order_by('contest_winners.start_date desc, contest_winners.rank');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getLimitAllContestWinnersByDates( $limit, $offset, $datefrom = '', $dateto = '' ){
        $this->db->select('contest_winners.*, contestmoneyfall.City');
        $this->db->from('contest_winners');
        $this->db->join('contestmoneyfall', 'contestmoneyfall.users_id = contest_winners.user_id', 'inner');
        if( strtotime($datefrom) > 0 && strtotime($dateto) > 0 ) {
            $this->db->where('contest_winners.start_date >=', date('Y-m-d 00:00:00', strtotime($datefrom)));
            $this->db->where('contest_winners.end_date <=', date('Y-m-d 23:59:59', strtotime($dateto)));
//            $this->db->where('contest_winners.end_date <=', date('Y-m-d 22:59:59', strtotime('last friday', strtotime('yesterday'))));
//            $this->db->where('contest_winners.rank <=', 10);
        }else{
            $this->db->where('contest_winners.end_date <=', date('Y-m-d 23:59:59', strtotime('last friday', strtotime('yesterday'))));
//            $this->db->where('contest_winners.rank <=', 10);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('contest_winners.start_date desc, contest_winners.rank');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getContestWinnerById( $id ){
        $this->db->from('contest_winners');
        $this->db->where('contest_winners.id', $id);
        $data = $this->db->get();
        return $data->row_array();
    }

    function updateContestWinnerById( $id, $data ){
        $this->db->where('id', $id);
        if($this->db->update('contest_winners', $data)){
            return true;
        }else{
            return false;
        }
    }

    //SD search date

    
    function showt3w2j2SD($table1,$table2,$table3,$field1="",$id1="",$select="",$join12,$join23,$order,$first_date,$second_date)
    {
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $join12);
        $this->db->join($table3, $join23);
        $this->db->where($field1, $id1);

        $this->db->where('users.created >=', $first_date);
        $this->db->where('users.created <=', $second_date);
        $this->db->order_by($order, 'desc');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function insertCreditPrize( $data ){
        if($this->db->insert('credit_prize' ,$data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function showM5P() {
        $this->db->select('mt_accounts_set.account_number as an');
        $this->db->from('contestmoneyfall');
        $this->db->join('users', 'users.id= contestmoneyfall.users_id');
        $this->db->join('mt_accounts_set' ,'users.id=mt_accounts_set.user_id');
        $this->db->where('contestmoneyfall.users_id <>', 0);
        $this->db->order_by('users.created','desc');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
    function showM5Ps($length, $start,$search=0, $order=0) {

        switch($order[0]['column']){
            case 0:
                $orderf='an';
                $orderid=$order['0']['dir'];
                break;
            default:
                $orderf='users.created';
                $orderid='users.desc';


        }
        $this->db->select('mt_accounts_set.account_number as an');
        $this->db->from('contestmoneyfall');
        $this->db->join('users' ,'users.id= contestmoneyfall.users_id');
        $this->db->join('mt_accounts_set' ,'users.id=mt_accounts_set.user_id');
        $this->db->like('mt_accounts_set.account_number', $search, 'both');
        $this->db->where('contestmoneyfall.users_id <>', 0);
        $this->db->order_by($orderf,$orderid);
        $this->db->limit($length, $start);

        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

//    function show_monitortrades(){
//
//        $query = $this->db->query("SELECT * FROM monitor_contest as resutl_table ;");
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//
//    }

}