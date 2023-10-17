<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class External_model extends CI_Model{


    private  $tb_UserFeedback = 'user_feedback';
    private  $tb_AdminNews = 'admin_news';
    private  $tb_AdminUser = 'users';

    function __construct(){
        parent::__construct();
    }
    /* administration **/
    public function updateuserAdministration($data) {
        $this->db->where('id', $data['id']);
        $this->db->update($this->tb_AdminUser, $data);
    }
    public function record_count_users() {
        return $this->db->count_all($this->tb_AdminUser);
    }
    public function fetch_users($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->tb_AdminUser);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    /* administration **/

    /* feedback **/
    function updateFeedbackemail($data){

        $this->db->where('id', $data['id']);
        $this->db->update($this->tb_UserFeedback, $data);
        if ($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }
    function insertFeedback( $data ){

        if ($this->db->insert($this->tb_UserFeedback, $data)){
            return $this->db->insert_id();
        }
        return false;
    }

    public function record_count_feedback() {
        return $this->db->count_all($this->tb_UserFeedback);
    }

    public function fetch_feedback($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->tb_UserFeedback);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    /* feedback **/
    /* news **/
    function insertNews( $data ){
        if ($this->db->insert($this->tb_AdminNews, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }
    public function record_count() {
        return $this->db->count_all($this->tb_AdminNews);
    }

    public function fetch_news($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->tb_AdminNews);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    /* news **/

}