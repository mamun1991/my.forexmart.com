<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function getUserContactByUserId( $user_id ){
        $this->db->from('contacts');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }

    function updateContactByUserId( $user_id, $data ){
        $this->db->where('user_id', $user_id);
        if($this->db->update('contacts', $data)){
            return true;
        }else{
            return false;
        }
    }

    function insertUserContact( $data ){
        if( $this->db->insert('contacts', $data) ){
            return true;
        }else{
            return false;
        }
    }
}