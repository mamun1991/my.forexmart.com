<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getBanner($size){
        $this->db->select('*');
        $this->db->from('banners');
        $this->db->where('size', $size);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function getAllSizes(){
        $this->db->select('size')
            ->from('banners')
            ->group_by('size')
            ->order_by('id');
        $query = $this->db->get();
        if($query->num_rows() > 0 ){
            return $query->result_array();
        }

        return false;
    }

    public function getBannerDetailsBySize($sizes){
        $this->db->select('*')
            ->from('banners')
            ->where('size', $sizes);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return false;
    }
}