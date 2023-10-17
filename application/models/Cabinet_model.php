<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 3/21/16
 * Time: 12:45 PM
 */

class Cabinet_model extends  CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getUserInfo($user_id=null){
        $this->db->select('*');
        $this->db->from('users u');
        $this->db->join('user_profiles up',' up.user_id = u.id');
        $this->db->where('u.id',$user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) return $query->row();
        return false;

    }
    public function getUserInfoByAccount($account_number=null, $type=0){

        
        if($type == 0){
            $this->db->select('u.id,up.full_name,u.email,u.administration,u.login_type,u.registration_location,up.country,mt.mt_account_set_id,mt.mt_currency_base as currency,mt.trader_password,u.accountstatus,up.image');
            $this->db->from('users u');
            $this->db->join('user_profiles up',' up.user_id = u.id','inner');
            $this->db->join('mt_accounts_set mt',' mt.user_id = u.id','inner');
            $this->db->where('mt.account_number',$account_number);
            $query = $this->db->get();
        }else{
            $this->db->select('u.id,up.full_name,u.email,u.administration,u.login_type,up.country,p.trader_password,u.accountstatus,p.type_of_partnership,p.currency,up.image');
            $this->db->from('users u');
            $this->db->join('user_profiles up',' up.user_id = u.id','inner');
            $this->db->join('partnership p',' p.partner_id = u.id','inner');
            $this->db->or_where('p.reference_num',$account_number);
            $query = $this->db->get();
        }

        if ($query->num_rows() > 0){
            return $query->row();
        }else {
            return false;
        }
    }
    public function getUserInfoByAuthID($id, $type=0){

        if($type == 0){
            $this->db->select('u.id,up.full_name,up.image,u.email,u.administration,u.login_type,u.registration_location,up.country,mt.mt_account_set_id,mt.account_number,u.accountstatus');
            $this->db->from('users u');
            $this->db->join('user_profiles up',' up.user_id = u.id','inner');
            $this->db->join('mt_accounts_set mt',' mt.user_id = u.id','inner');
            $this->db->where('u.login_oauth_id',$id);
            $query = $this->db->get();
        }else{
            $this->db->select('u.id,up.full_name,up.image,u.email,u.administration,u.login_type,up.country,u.accountstatus,p.reference_num as account_number,p.type_of_partnership');
            $this->db->from('users u');
            $this->db->join('user_profiles up',' up.user_id = u.id','inner');
            $this->db->join('partnership p',' p.partner_id = u.id','inner');
            $this->db->where('u.login_oauth_id',$id);
            $query = $this->db->get();
        }

        if ($query->num_rows() > 0){
            return $query->row();
        }else {
            return false;
        }
    }



    public function getAccountNumberByUserId( $user_id ){
        $sql = "SELECT u.id,up.full_name,u.email,u.administration,u.login_type,u.registration_location,up.country,mt.mt_account_set_id,u.accountstatus, mt.account_number as account_number 
                FROM users u 
                INNER JOIN user_profiles up ON up.user_id = u.id
                INNER JOIN mt_accounts_set mt on mt.user_id = u.id
                WHERE mt.user_id = ?
                UNION ALL
                SELECT u.id,up.full_name,u.email,u.administration,u.login_type,u.registration_location,up.country,0,u.accountstatus, p.reference_num as account_number 
                FROM users u 
                INNER JOIN user_profiles up ON up.user_id = u.id
                INNER JOIN partnership p  on p.partner_id = u.id
                WHERE p.partner_id = ?";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getPartnerInfoByAccount($account_number=null){


        $this->db->select('u.id,up.full_name,u.email,u.administration,u.login_type,up.country,u.accountstatus,p.type_of_partnership');
        $this->db->from('users u');
        $this->db->join('user_profiles up',' up.user_id = u.id','inner');
        $this->db->join('partnership p',' p.partner_id = u.id','inner');
        $this->db->where('p.reference_num',$account_number);
      //  $this->db->where('u.accountstatus',0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) return $query->row();
        return false;

    }
    public function getClientInfoByAccount($account_number=null){


        $this->db->select('u.id,up.full_name,u.email,u.administration,u.login_type');
        $this->db->from('users u');
        $this->db->join('user_profiles up',' up.user_id = u.id','inner');
        $this->db->join('mt_accounts_set mt',' mt.user_id = u.id','inner');
        $this->db->where('mt.account_number',$account_number);

        $query = $this->db->get();

        if ($query->num_rows() > 0) return $query->row();
        return false;

    }

    public function getKey($key=null,$user_id=null){
        $this->db->select('*');
        $this->db->from('go_to_cabinet');
        $this->db->where('user_id',$user_id);
        $this->db->where('key',$key);
        $query = $this->db->get();

        $this->db->delete('go_to_cabinet',array('key'=>$key));
        if ($query->num_rows() > 0) return $query->row();
        return false;

    }

    public function getAccountNumberByEmail($email){

        $sql = "select u.id,u.email,mt.account_number, 1 as  `type` from users u inner join mt_accounts_set mt on u.id= mt.user_id where u.email = ?
union all
select u.id,u.email,p.reference_num ,0 as `type` from users u inner join partnership p on p.partner_id = u.id where u.email = ? ";


        $result = $this->db->query( $sql, array($email,$email) );
        return ($result->num_rows() > 0) ? $result->result() : false ;


    }

    public function getAccountNumber($user_id=null){
        $this->db->select('mt.account_number,u.id,up.full_name,u.email,u.administration,u.login_type');
        $this->db->from('users u');
        $this->db->join('user_profiles up',' up.user_id = u.id','left');
        $this->db->join('mt_accounts_set mt',' mt.user_id = u.id','left');
        $this->db->join('partnership p',' p.partner_id = u.id','left');
        $this->db->where('u.id',$user_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) return $query->row();
        return false;

    }

    public function isAccountExist( $account_number, $login_type ){
        if($login_type == 0){
            $this->db->from('mt_accounts_set');
            $this->db->where('account_number', $account_number);
            $query = $this->db->get();
            if ($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }elseif($login_type == 1){
            $this->db->from('partnership');
            $this->db->where('reference_num', $account_number);
            $query = $this->db->get();
            if ($query->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

} 