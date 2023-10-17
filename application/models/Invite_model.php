<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invite_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function checkPerDayOneInvite($email){

        $this->db->select('id');
        $this->db->from('invite_friends');
        $this->db->where("date(`date`) = current_date()");
        $this->db->where("email",$email);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }
        return false;

    }

    function getInvitePerMonth($user_id){

        $sql = 'SELECT count(*)as number, month(`date`) as `month` from   invite_friends where user_id = ? group by month(`date`)';
        $query =  $this->db->query($sql,array($user_id));

        return  $query->num_rows() > 0 ? $query->result() : false;
    }
    function getReferralPerMonth($user_id){

        $sql = 'SELECT count(*)as number, month(register_date) as `month` from   invite_friends where user_id = ? and `status`= 2 group by month(register_date)';
        $query =  $this->db->query($sql,array($user_id));

        return  $query->num_rows() > 0 ? $query->result() : false;
    }
    function getUserAffiliateCode($user_id){


        $sql = "select affiliate_code from users_affiliate_code where users_id=?
union all
select affiliate_code from partnership_affiliate_code where partner_id=? limit 1";

        $query = $this->db->query($sql, array($user_id,$user_id));

        if($query->num_rows() > 0){
            $ret = $query->row();
            return $ret->affiliate_code;
        }
        return false;



    }
    function getInvitedAffiliateCode($email_user){
        $this->db->select('user_affiliate_code');
        $this->db->from('invite_friends');
        $this->db->where('email', $email_user);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->user_affiliate_code;

    }
    function getInviteFriendsAccountNumber( $user_id){
        // select * from invite_friends inf inner join  mt_accounts_set mas on mas.user_id= inf.user_id_after_registration where inf.user_id=68116
      /*  $sql = "select if(withdraw.status=2,invite_friends.withdraw+invite_friends.credit - withdraw.amount_deducted,invite_friends.withdraw+invite_friends.credit) as amount, invite_friends.id as inv_id,invite_friends.*,mt_accounts_set.account_number,withdraw.status withdraw_status
from invite_friends left join mt_accounts_set on  mt_accounts_set.user_id= invite_friends.user_id_after_registration
left join withdraw on invite_friends.withdraw_id = withdraw.id
where invite_friends.user_id = ?";*/

        $sql = "select (invite_friends.withdraw+invite_friends.credit) as amount, invite_friends.id as inv_id,invite_friends.*,mt_accounts_set.account_number,withdraw.status withdraw_status
from invite_friends left join mt_accounts_set on  mt_accounts_set.user_id= invite_friends.user_id_after_registration
left join withdraw on invite_friends.withdraw_id = withdraw.id
where invite_friends.user_id = ?";

        /*$this->db->select("invite_friends.id as inv_id,invite_friends.*,mt_accounts_set.*");
        $this->db->from('invite_friends');
        $this->db->join('mt_accounts_set','mt_accounts_set.user_id= invite_friends.user_id_after_registration ','left');
        $this->db->where('invite_friends.user_id',$user_id);
        $partner_query = $this->db->get();*/
        $partner_query=  $this->db->query($sql, array($user_id));
        if($partner_query->num_rows() > 0){
            return $partner_query->result();
        }
        return false;
    }

    function checkDepositInvaiteFriends($affilieateCode)
    {
            $sql = "SELECT user_id,amount from deposit where user_id in ( SELECT GROUP_CONCAT(users_id) user_id from users_affiliate_code where referral_affiliate_code = ?) GROUP BY user_id ORDER BY id ASC";

        $query = $this->db->query($sql, array($affilieateCode));

        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;


    }
    function synonymsEmail($user_id)
    {
        //$sql = "select sync_email.*, if(invite_friends.email is null,0,1) as invited  from sync_email left join invite_friends on sync_email.email=invite_friends.email where sync_email.user_id=?";
        $sql = "select sync_email.*, if(invite_friends.email is null,0,1) as invited,if(users.email is null,0,1) as ex_email
from sync_email left join invite_friends on sync_email.email=invite_friends.email
left join users on sync_email.email=users.email where sync_email.user_id=? group by sync_email.email
";
        $query = $this->db->query($sql, array($user_id));

        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;


    }

    function getInvitedRefCode($email_user,$user_id=null){
        $this->db->select('ref_number');
        $this->db->from('invite_friends');
        $this->db->where('email', $email_user);
        // $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $ret = $query->row();
        return $ret->ref_number;

    }
    function updateInviteDetails($table, $inv_ref, $tbl_code,$email_user,$tbl_email,$invite_data){
        $this->db->where($tbl_email, $email_user);
        $this->db->where($tbl_code, $inv_ref);
        $this->db->update($table, $invite_data);
    }
} 