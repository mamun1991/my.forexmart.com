<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailsupport_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function getUserMails($id) {
        $this->db->select('mail_support.*, mail_support_thread.date_updated, mail_support_thread.user_type, mail_support_thread.status as mail_status, (select count(*) from mail_support_thread where mail_support_thread.mail_support_id = mail_support.id and mail_support_thread.status = 1 and mail_support_thread.user_type != "Trader") as mail_notif');
        $this->db->from('mail_support');
        $this->db->join('mail_support_thread', 'mail_support_thread.mail_support_id = mail_support.id');
        $this->db->where('mail_support.userid', $id);
        $this->db->where('mail_support_thread.id IN (select MAX(mail_support_thread.id) from mail_support_thread GROUP BY mail_support_thread.mail_support_id)', NULL, FALSE);
        $this->db->order_by('mail_support_thread.date_updated','desc');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function getLastMail($thread_id) {
        $this->db->select('user_type');
        $this->db->from('mail_support_thread');
        $this->db->where('mail_support_id', $thread_id);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }

    function getMailImages($ids) {
        $this->db->select('*');
        $this->db->from('mail_support_images');
        $this->db->where_in('mail_thread_id', $ids);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function getMailThread($thread_id) {
        $this->db->select('*');
        $this->db->from('mail_support_thread');
        $this->db->where('mail_support_id', $thread_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
}