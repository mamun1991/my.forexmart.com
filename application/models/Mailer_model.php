<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

    }

    function getAllReplyTo(){
        $this->db->select('*');
        $this->db->from('article_topic');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getLatestAccountNumber($email){
        $this->db->select('account_number');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'mt_accounts_set.user_id = users.id', 'INNER');
        $this->db->where('users.email',$email);
        $this->db->order_by('mt_accounts_set.user_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data[0]['account_number'];
    }

    function checkIfSendLessThanTwoWeeks($email){
        $this->db->select('DateAuth');
        $this->db->from('mailer_test_recipients');
        $this->db->where('mailer_test_recipients.Email',$email);
        $query = $this->db->get();
        $data = $query->result_array();
        $Data['tes'] = $data[0]['DateAuth'];
        $Data['DateAuth']    = strtotime($data[0]['DateAuth']);
        $Data['DateAuthEnd'] = strtotime($data[0]['DateAuth'] . " +14 days") ;
        return (   strtotime('now')  <=  $Data['DateAuthEnd'] ) ? true :false;
        // return $Data;
    }

}

