<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function compare_views_laa( $table,
                                $field0,$id0,
                                $field1,$id1,
                                $field2,$id2,
                                $field3,$id3,
                                $field4,$id4,
                                $field5,$id5,
                                $field6,$id6,
                                $field7,$id7,
                                $field8,$id8,
                                $select="" ){

        $this->db->select($select);
        $this->db->from($table);
        $this->db->where('Lower('.$field0.')',strtolower($id0));
        $this->db->where($field1,$id1);
//        $this->db->where($field2,$id2); /*street*/
        $this->db->where($field3,$id3);
        $this->db->where($field4,$id4);
        $this->db->where($field5,$id5);
        $this->db->where($field6,$id6);
//        $this->db->where($field7,$id7); /*dob*/
//        $this->db->where($field8,$id8); /*ip*/

        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    function compare_views_paa( $table,
                                $field0,$id0,
                                $field1,$id1,
                                $field2,$id2,
                                $field3,$id3,
                                $field4,$id4,
                                $field5,$id5,
                                $field6,$id6,
                                $field7,$id7,
                                $field8,$id8,
                                $select="" ){

        $this->db->select($select);
        $this->db->from($table);
        $this->db->where('Lower('.$field0.')',strtolower($id0));
        $this->db->where($field1,$id1);
//        $this->db->where($field2,$id2);
//        $this->db->where($field3,$id3);
//        $this->db->where($field4,$id4);
//        $this->db->where($field5,$id5);
//        $this->db->where($field6,$id6);
//        $this->db->where($field7,$id7);
//        $this->db->where($field8,$id8);

        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

//    public function get_liveaccounts (){
//        $this->db->select('account_number');
//        $this->db->from('all_liveaccounts');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;
//    }
    public function get_leverage_one_k (){
        $this->db->select('account_number');
        $this->db->from('temp_update1k5k');
        $this->db->where('leverage','1:1000');
        $this->db->where('status',null);
        $this->db->limit(1000);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function all_live_users(){
//        $query = $this->db->query("SELECT * from for_inactiveaccounts limit 1000");
        $query = $this->db->query("SELECT * from for_inactiveaccounts ");
          if ($query->num_rows() > 0) {
              return $query->result_array();
          }
        return false;
    }

    function showEmail_v2(
        $table1,$table2,$table3,
        $field1="",$id1="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",
        $join13="",
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->join($table3 ,$join13);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field1, strtoupper($id1));
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
    function showFullname_v2(
        $table1,$table2,$table3,
        $field1="",$id1="",
        $field2="",$id2="",
        $field3="",$id3="",
        $field4="",$id4="",
        $join12="",$join13,
        $select=""){
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2 ,$join12);
        $this->db->join($table3 ,$join13);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field2, $id2);
        $this->db->where($field1, $id1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function taggingDoubeNDB(){
        $this->db->select('email,account_number,registration_time,amount,mt_currency_base,open_trading,mt_accounts_set.user_id,mt_accounts_set.mt_account_set_id,mt_accounts_set.swap_free');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id = mt_accounts_set.user_id', 'inner');
        $this->db->where('users.type', 1);
        $this->db->where('registration_time >=', '2017-03-13 00:00:01');
//                $this->db->limit(5);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }


    public function get_ndbbackdate(){
        /*tempo code auto gen*/

        $this->db->select('*');
        $this->db->from('ndb_backdatedgroups');
//        $this->db->limit(1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }

    }
    public function get_tempo_april4_ndb(){
        /*tempo code auto gen*/

        $this->db->select('*');
        $this->db->from('tempo_april4_ndb');
        //        $this->db->limit(1);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }

    }
    public function get_forcheckcreditprize(){
        /*tempo code auto gen*/
        $this->db->select('*');
        $this->db->from('tempo_handlerforcreditprize');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    public function tempo_leverage(){
        $this->db->select('*');
        $this->db->from('tempo_ndb_leverage');
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function showt2w3j2sFullnameIP(
        $table1, $table2,$table3,
        $field1 = "", $id1 = "",
        $field2 = "", $id2 = "",
        $field3 = "", $id3 = "",
        $field4 = "", $id4 = "",
        $join12 = "",
        $join31 = "",
        $select = "")
    {
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $join12);
        $this->db->join($table3, $join31);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field2, $id2);
        $this->db->where($field1, $id1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    function accountAdditionalInfo(
        $table1 = "" , $table2 = "", $table3= "",
        $field1 = "" , $id1 = "" ,
        $field2 = "" , $id2 = "" ,
        $field3 = "" , $id3 = "" ,
        $field4 = "" , $id4 = "" ,
        $field5 = "" , $id5 = "" ,
        $join12 = "" ,
        $join31 = "" ,
        $select = "" )
    {
        $this->db->select($select);
        $this->db->from($table1);
        $this->db->join($table2, $join12);
        $this->db->join($table3, $join31);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $this->db->where($field3, $id3);
        $this->db->where($field4, $id4);
        $this->db->where($field5, $id5);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }


    function getspecialaffiliatecode(){
        /* account number 208164 - is advertising@forexmart.com*/
        $this->db->select($select='affiliate_code');
        $this->db->from($table='partnership');
        $this->db->join($table2='partnership_affiliate_code', 'partnership_affiliate_code.partner_id=partnership.partner_id');
        $this->db->where($field1='reference_num', $id1='208164');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }

    }
    function getreferralcode($user_id){
        $this->db->select($select='referral_affiliate_code');
        $this->db->from($table='users_affiliate_code');
        $this->db->where($field1='users_id', $id1=$user_id);
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function getLiveaccount($user_id){
        $this->db->select('`users`.`id` AS `id`,
            `users`.`email` AS `email`,
            `user_profiles`.`full_name` AS `full_name`,
            `user_profiles`.`street` AS `street`,
            `user_profiles`.`state` AS `state`,
            `user_profiles`.`country` AS `country`,
            `user_profiles`.`zip` AS `zip`,
            `user_profiles`.`dob` AS `dob`,
            `user_profiles`.`city` AS `city`,
            `mt_accounts_set`.`registration_ip` AS `registration_ip`,
            `mt_accounts_set`.`account_number` AS `account_number`,
            `users`.`accountstatus` AS `accountstatus`,
            `users`.`login_type` AS `login_type`,
            `users`.`created` AS `created`,
            `users`.`last_ip` AS `last_ip`');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id=users.id');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id=users.id');
        $this->db->where('users.accountstatus', 0);
        $this->db->where('users.email <>', '');
        $this->db->where('users.login_type', 0);
        $this->db->where('users.id',$user_id);
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row_array();
        } else {
            return false;
        }
    }

    function getPartneraccount($user_id){
        $this->db->select('`users`.`email` AS `email`,
	`users`.`accountstatus` AS `accountstatus`,
	`users`.`login_type` AS `login_type`,
	`user_profiles`.`full_name` AS `full_name`,
	`user_profiles`.`street` AS `street`,
	`user_profiles`.`city` AS `city`,
	`user_profiles`.`state` AS `state`,
	`user_profiles`.`country` AS `country`,
	`user_profiles`.`zip` AS `zip`,
	`user_profiles`.`dob` AS `dob`,
	`users`.`last_ip` AS `last_ip`,
	`partnership`.`dateregistered` AS `dateregistered`,
	`users`.`created` AS `created`,
	`users`.`id` AS `id`,
	`partnership`.`target_country` AS `target_country`,
	`partnership`.`websites` AS `websites`,
	`partnership`.`type_of_partnership` AS `type_of_partnership`,
	`partnership`.`message` AS `message`,
	`partnership`.`company_name` AS `company_name`,
	`partnership`.`registration_number` AS `registration_number`,
	`partnership`.`date_of_incorporation` AS `date_of_incorporation`,
	`partnership`.`phone_number` AS `phone_number`,
	`partnership`.`currency` AS `currency`,
	`partnership`.`amount` AS `amount`');
        $this->db->from('users');
        $this->db->join('user_profiles', '`user_profiles`.`user_id` = `users`.`id`');
        $this->db->join('partnership', '`users`.`id` = `partnership`.`partner_id`');
        $this->db->where('char_length(`partnership`.`reference_num`) >', 5);
        $this->db->where('users.login_type', 1);
        $this->db->where('`users`.`accountstatus`', 0);
        $this->db->where('users.id',$user_id);
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row_array();
        } else {
            return false;
        }
    }

    function approvedLiveaccounts($email='',$full_name='',$street='',$city='',$state='',$country='',$zip='',$dob='',$last_ip=''){
        $this->db->select('`users`.`email` AS `email`,
                            `users`.`id` AS `id`,
                            `users`.`accountstatus` AS `accountstatus`,
                            `user_profiles`.`full_name` AS `full_name`,
                            `user_profiles`.`street` AS `street`,
                            `user_profiles`.`city` AS `city`,
                            `user_profiles`.`state` AS `state`,
                            `user_profiles`.`country` AS `country`,
                            `user_profiles`.`zip` AS `zip`,
                            `user_profiles`.`dob` AS `dob`,
                            `mt_accounts_set`.`account_number` AS `account_number`,
                            `users`.`last_ip` AS `last_ip`,
                            `users`.`created` AS `created`');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id=users.id');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id=users.id');
        $this->db->where('accountstatus',1);
        $this->db->where('char_length(`mt_accounts_set`.`account_number`) >', 5);
        $this->db->where('`users`.`email` <>', '');
        $this->db->where('Lower(email)',strtolower($email));
        $this->db->where('full_name',$full_name);
        //$this->db->where('street',$street); /*street*/
        $this->db->where('city',$city);
        $this->db->where('state',$state);
        $this->db->where('country',$country);
        $this->db->where('zip',$zip);
        $this->db->order_by('`users`.`email`','DESC');
        // $this->db->where('dob',$dob); /*dob*/
        // $this->db->where('last_ip',$id8); /*last_ip*/
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            //            return $data->result_array();
            //            return $data->row_array();
            return true;
        } else {
            return false;
        }
    }
    function approvedPartneraccounts($email='',$full_name=''){
        $this->db->select(' `users`.`email` AS `email`,
                            `users`.`id` AS `id`,
                            `users`.`accountstatus` AS `accountstatus`,
                            `user_profiles`.`full_name` AS `full_name`,
                            `user_profiles`.`street` AS `street`,
                            `user_profiles`.`city` AS `city`,
                            `user_profiles`.`state` AS `state`,
                            `user_profiles`.`country` AS `country`,
                            `user_profiles`.`zip` AS `zip`,
                            `user_profiles`.`dob` AS `dob`,
                            `partnership`.`reference_num` AS `reference_num`,
                            `users`.`last_ip` AS `last_ip`,
                            `users`.`created` AS `created`,
                            `partnership`.`target_country` AS `target_country`,
                            `partnership`.`type_of_partnership` AS `type_of_partnership`,
                            `partnership`.`websites` AS `websites`,
                            `partnership`.`dateregistered` AS `dateregistered`,
                            `partnership`.`status_type` AS `status_type`,
                            `partnership`.`company_name` AS `company_name`,
                            `partnership`.`date_of_incorporation` AS `date_of_incorporation`,
                            `partnership`.`phone_number` AS `phone_number`,
                            `partnership`.`currency` AS `currency`');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id=users.id');
        $this->db->join('partnership', '`users`.`id` = `partnership`.`partner_id`');
        $this->db->where('accountstatus',1);
        $this->db->where('char_length(`partnership`.`reference_num`) >', 5);
        $this->db->where('Lower(email)',strtolower($email));
        $this->db->where('full_name',$full_name);
        $this->db->order_by('`users`.`email`','DESC');

        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            //            return $data->result_array();
            //            return $data->row_array();
            return true;
        } else {
            return false;
        }
    }


    function getaccountnumbersview(){
        $this->db->select('account_number,nodepositbonus,ndba_acquired');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id=mt_accounts_set.user_id');
        $this->db->where('registration_time >','2017-03-12 00:00:01' );
        $this->db->where('nodepositbonus',1 );
        $this->db->where('type',1 );
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function getandupdate_date(){
        $this->db->select('mt_accounts_set.account_number,ndba_acquired');
        $this->db->from('test_ndbremovedagents');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.account_number=test_ndbremovedagents.account_number');
        $this->db->join('users', 'users.id=mt_accounts_set.user_id');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function get_agents_for_removal(){
        $this->db->select('account_number');
        $this->db->from('test_ndbremovedagents');
        $this->db->where('status',0);
//        $this->db->limit('1');

        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function contestmftagging(){
        $sql = "
            SELECT
                account_number,
                users.id
            FROM
                users
            JOIN mt_accounts_set ON mt_accounts_set.user_id = users.id
            WHERE
                is_bonuscontestmfprize = 0
            AND test <> 1
            AND test_1 <> 0
            AND (
                char_length(
                    `mt_accounts_set`.`account_number`
                ) > 5
            )
            AND (`users`.`type` = 1)
            AND (`users`.`login_type` = 0)
            AND is_mt4_active <> 2
            AND is_mt4_active <> 1
            AND nodepositbonus <> 1

        ";
//     LIMIT 100
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getdeposittoday($userid){

        $this->db->select('id,status,mt_ticket');
        $this->db->from('deposit');
        $this->db->where('`deposit`.`status`',2);
        $this->db->where('`deposit`.`payment_date` >=','CURDATE()');
        //        $this->db->where('`deposit`.`user_id`',$_SESSION["user_id"]);
        $this->db->where('`deposit`.`user_id`',$userid);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    function check_not_removedagent(){
        $this->db->select('account_number,nodepositbonus,ndba_acquired');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id=mt_accounts_set.user_id');
        $this->db->where('registration_time >','2017-03-12 00:00:01' );
        $this->db->where('nodepositbonus',1 );
        $this->db->where('agent_ndbtag IS NULL');
        $this->db->where('type',1 );
        $this->db->where('test !=',1 );
        $this->db->where('test_1 !=',0 );
//        $this->db->limit(10);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    function check_not_removedagent2(){
        $this->db->select('account_number,nodepositbonus,ndba_acquired');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id=mt_accounts_set.user_id');
        $this->db->where('registration_time >','2017-03-12 00:00:01' );
        $this->db->where('nodepositbonus',1 );
        $this->db->where('agent_ndbtag IS NULL');
        $this->db->where('type',1 );
        $this->db->where('test !=',1 );
        $this->db->where('test_1 !=',0 );
                $this->db->limit(100);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    function getnotremovedagents(){
        die();
        $this->db->select('account_number');
//        $this->db->select('count(*)');
        $this->db->from('test_agent_notremoved');
        $this->db->where('status',0 );
        $this->db->group_by('account_number');
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
//            return  $data->num_rows();
            return $data->result_array();
        } else {
            return false;
        }
    }

    function getagents(){
            die();
        $this->db->select('account_number,agent,api_registration');
        //        $this->db->select('count(*)');
        $this->db->from('test_agent_notremoved');
        $this->db->where('status_commission',0 );
        $this->db->group_by('account_number');
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            //            return  $data->num_rows();
            return $data->result_array();
        } else {
            return false;
        }
    }

    function getagents2(){

        $this->db->select('account_number,agent,api_registration');
        $this->db->from('test_removedagent_others');
        $this->db->where('status_commission',0 );
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            //            return  $data->num_rows();
            return $data->result_array();
        } else {
            return false;
        }
    }
    function getagents_data2(){

        $this->db->select('account_number,agent,api_registration');
        $this->db->from('test_ndbremovedagents');
        $this->db->where('status_commission',0 );
        $this->db->limit(1);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            //            return  $data->num_rows();
            return $data->result_array();
        } else {
            return false;
        }
    }
}
