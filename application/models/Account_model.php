<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function getAccountsByUserId( $user_id ){
            $this->db->select('mt_accounts_set.*, users.type,users.accountstatus');
            $this->db->from('mt_accounts_set');
            $this->db->join('users', 'users.id = mt_accounts_set.user_id');
            $this->db->where('user_id', $user_id);
            $this->db->order_by('id', 'DESC');
            $data = $this->db->get();
            return $data->result_array();
    }

    function getAccountsByUserIdRow( $user_id ){
        $this->db->select('mt_accounts_set.*, users.type, users.ndb_bonus');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id = mt_accounts_set.user_id');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    function getMtAccountType( $user_id ){
        $mtAccounts = $this->getAccountsByUserId( $user_id );
        foreach($mtAccounts as $acct){
            if($acct['mt_type']){
                return true;
            }
        }
        return false;
    }

    function upload_documents( $data ){
        $this->db->insert('user_documents' ,$data);
        return $this->db->insert_id();
    }

    function update_upload_documents($user_id, $doc_type, $updatedata){
        $passAraray = array(
            'user_id' => $user_id,
            'doc_type' => $doc_type
        );
        $this->db->where($passAraray);
        $this->db->update('user_documents', $updatedata);
    }

    function checkUserDocs($user_id, $doc_type){
        $this->db->select('*');
        $this->db->from('user_documents');
        $passArray = array(
            'user_id' => $user_id,
            'doc_type' => $doc_type
        );
        $this->db->where($passArray);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function updateUserDetails($table,$field,$id,$data){
        $this->db->where($field, $id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    //get users details
    function getUserEmailByUserId($user_id){
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    //get user details for filter
    function getUserDetailsFilter($user_id, $filterField){
        $this->db->distinct();
        $this->db->select($filterField);
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    function selectedDetailsFilter($user_id, $flts, $test, $test2){
        $this->db->select('*');
        $this->db->from('mt_accounts_set');
        $this->db->where_in('mt_type', $flts);
        $this->db->where_in('mt_currency_base', $test);
        $this->db->where_in('mt_account_set_id', $test2);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function checkIfUniqueAccountNumber($accountnum){
        $this->db->select('*');
        $this->db->from('mt_accounts_set');
        $this->db->like('account_number', $accountnum, 'before');
        $queryResult = $this->db->get();

        return ($queryResult->num_rows() > 0) ? false : true;
    }

    public function getAllAccountNumber($user_id){
        $this->db->select('*');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function incompleteRegistration($user_id){
        $this->db->select('*')
            ->from('employment_details')
            ->where('user_id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }

    }

    public function getAccountStatus($user_id){
        $this->db->select('accountstatus');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $getStatus = $query->row();
//            $getStatus->accountstatus;
            if($getStatus->accountstatus == 1){
                $this->db->select('*');
                $this->db->from('mt_accounts_set');
                $this->db->join('trading_experience', 'trading_experience.user_id = mt_accounts_set.user_id', 'left');
                $this->db->join('employment_details', 'employment_details.user_id = mt_accounts_set.user_id', 'left');
                $this->db->where('mt_accounts_set.user_id', $user_id);
                $query = $this->db->get();
                if($query->num_rows() > 0){
                    return $query->row();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * Validate account id based on current user
     */
    public function check_user_account_number_by_id( $user_id, $id ){
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $this->db->where('id', $id);
        $queryResult = $this->db->get();
        return ($queryResult->num_rows() > 0) ? false : true;
    }

    /**
     * Get user account info base on account id
     */
    public function get_account_by_id( $id ){
        $this->db->from('mt_accounts_set');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function get_partner_by_id( $id ){
        $this->db->select('id, reference_num as account_number, currency as mt_currency_base,amount');
        $this->db->from('partnership');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getAccountNumberDetails($account_num){
        $this->db->select('*');
        $this->db->from('mt_accounts_set');
        $this->db->where('account_number', $account_num);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function updateAccountBalance( $account_number, $amount ){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('account_number', $account_number);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getAccountByUserId( $user_id ){
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getUserInfoByUserId( $user_id ){
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getAccountByPartnerId( $partner_id ){
        $this->db->select('reference_num as account_number');
        $this->db->from('partnership');
        $this->db->where('partner_id', $partner_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getAccountByPartnerId2( $partner_id ){
        $this->db->select('reference_num as account_number, currency as mt_currency_base, currency as currency ,amount');
        $this->db->from('partnership');
        $this->db->where('partner_id', $partner_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    function updateAmountByAccountNumber( $account_number, $amount ){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('account_number', $account_number);
        $this->db->update('mt_accounts_set', $data);
    }

    //get user details by account number
    public function getUserDetailsByAccountNumber($account_number){
        $this->db->select('*')
            ->from('users')
            ->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left')
            ->join('contacts', 'users.id = contacts.user_id', 'left')
            ->join('user_profiles', 'users.id = user_profiles.user_id', 'left')
            ->where('mt_accounts_set.account_number', $account_number);

        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getUserDetailsByAccountNumberRow($account_number){
        $this->db->select('*')
            ->from('users')
            ->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left')
            ->join('contacts', 'users.id = contacts.user_id', 'left')
            ->join('user_profiles', 'users.id = user_profiles.user_id', 'left')
            ->where('mt_accounts_set.account_number', $account_number);

        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row();
        }else{
            return false;
        }
    }
    //get user details by user id
    public function getRowUserDetailsByUserID($user_id){
        $this->db->select('*')
            ->from('users')
            ->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left')
            ->join('contacts', 'users.id = contacts.user_id', 'left')
            ->join('user_profiles', 'users.id = user_profiles.user_id', 'left')
            ->where('users.id', $user_id);

        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row();
        }else{
            return false;
        }
    }

    public function getAffiliateCodeByAccountNumber($account_number){
        $this->db->select('*, users_affiliate_code.id as uacID')
            ->from('mt_accounts_set')
            ->join('users_affiliate_code', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'left')
            ->where('mt_accounts_set.account_number', $account_number);
        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getAccountNumberByAffiliateCode($affiliate_code){
        //        select partnership.reference_num, mt_accounts_set.account_number from users
//        left join partnership_affiliate_code on users.id = partnership_affiliate_code.partner_id
//        left join partnership on partnership.partner_id = partnership_affiliate_code.partner_id
//        left join users_affiliate_code on users.id=users_affiliate_code.users_id
//        left join mt_accounts_set on mt_accounts_set.user_id = users_affiliate_code.users_id
//        where partnership_affiliate_code.affiliate_code = 'HGMWM'
//        Order by users.created DESC
//        $this->db->select('partnership.reference_num, mt_accounts_set.account_number');
        $this->db->select('partnership.reference_num, mt_accounts_set.account_number');
        $this->db->from('users');
        $this->db->join('partnership_affiliate_code', 'users.id = partnership_affiliate_code.partner_id', 'left');
        $this->db->join('partnership', 'partnership.partner_id = partnership_affiliate_code.partner_id', 'left');
        $this->db->join('users_affiliate_code', 'users.id=users_affiliate_code.users_id', 'left');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'left');
        $this->db->where('partnership_affiliate_code.affiliate_code', $affiliate_code);
        $this->db->or_where('users_affiliate_code.affiliate_code', $affiliate_code);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    public function updateAccountGroupCode( $account_number, $group_code ){
        $data = array(
            'group_code' => $group_code
        );
        $this->db->where('account_number', $account_number);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function updateAccountLeverage( $account_number, $leverage ){
        $data = array(
            'leverage' => $leverage
        );
        $this->db->where('account_number', $account_number);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }
    function UpdateLeverageAfterBonus($id,$data){ //FXPP-7732
        $this->db->where('account_number', $id);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function updateAccountSwapFree( $account_number, $is_swap, $groupCurrency){
        $data = array(
            'swap_free' => $is_swap,
            'group' => $groupCurrency
        );
        $this->db->where('account_number', $account_number);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getIncRegistrationClients($user_id){
        $this->db->select('*')
            ->from('employment_details')
            ->join('users', 'employment_details.user_id = users.id', 'left')
            ->where('users.login_type', 0)
            ->where('employment_details.user_id', $user_id);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function hasUserAutoLeverage($user_id){
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $this->db->where('auto_leverage', 0);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    function extraCommission($account_number){

       $sql = 'SELECT  p.reference_num from mt_accounts_set mt
inner join users_affiliate_code ua on  mt.user_id=ua.users_id
inner join partnership_affiliate_code pac on pac.affiliate_code=ua.referral_affiliate_code
inner join partnership p on p.partner_id=pac.partner_id
where mt.account_number=? and p.type_of_partnership="extra_commission"';
        $query = $this->db->query($sql,array($account_number));

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function updatePartnerAccountBalance( $account_number, $amount ){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('reference_num', $account_number);
        if($this->db->update('partnership', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getAffiliatesByCode($affiliate_code, $string){
        $this->db->select('ua.*, u.email, mta.account_number')
            ->from('users_affiliate_code ua')
            ->join('users u', 'ua.users_id = u.Id', 'left')
            ->join('mt_accounts_set mta', 'u.Id = mta.user_id', 'left')
            ->where('ua.referral_affiliate_code', $affiliate_code)
            ->like('u.Email', $string);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    public function updateUsersAffiliateDetails($users_id, $data){
        $this->db->where('users_id', $users_id)
            ->update('users_affiliate_code', $data);

    }

    function insertAccountUpdateHistory( $data ){
        if($this->db->insert('account_update_history', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insertAccountUpdateFieldHistory( $data ){
        if($this->db->insert_batch('account_field_update_history', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getUserDetailsByUserId($userId){
        $this->db->select('*')
            ->from('users')
            ->where('id', $userId);

        $result = $this->db->get();
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }

        return false;

    }

    function updateAmountNDBByUserId( $userId, $amount ){
        $data = array(
            'ndb_bonus' => $amount
        );
        $this->db->where('id', $userId);
        $this->db->update('users', $data);
    }


    function getClientInfoByUserId($user_id){
        $sql = "select u.email,u.created,u.id,up.full_name,mt.account_number,c.phone1,up.street,up.city,up.state,up.zip,up.country
from users u inner join user_profiles up on u.id= up.user_id
left join mt_accounts_set mt on mt.user_id=u.id
left join contacts c on u.id=c.user_id
where u.id =  ?
";
        $query = $this->db->query($sql,array($user_id));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function getAccountNumberByUserId( $user_id ){
        $sql = "SELECT account_number as account_number FROM mt_accounts_set WHERE user_id = ?
                  UNION ALL
                  SELECT reference_num as account_number FROM partnership WHERE partner_id = ?";

        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function getAccountDetailsByAccountNumber( $account_number ){
        $sql = "SELECT user_id as user_id, account_number as account_number,mt_currency_base as currency,  0 as account_type FROM mt_accounts_set WHERE account_number = ?
                UNION ALL
                SELECT partner_id as user_id, reference_num as account_number, currency as currency, type_of_partnership as account_type FROM partnership WHERE reference_num = ?";
        $query = $this->db->query($sql, array($account_number, $account_number));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function checkUniqueAffiliateCode($affiliateCode)
    {
       /* $query = 'SELECT * FROM
                    (
                      SELECT affiliate_code FROM users_affiliate_code AS uac
	                  UNION
	                  SELECT affiliate_code FROM partnership_affiliate_code AS pac
                    ) as sac WHERE affiliate_code = ?;
        ';*/
        // Query Optimize by Moniruzzaman
        $query = 'SELECT * FROM
                    (
                      SELECT affiliate_code FROM users_affiliate_code AS uac WHERE affiliate_code = ?
	                  UNION
	                  SELECT affiliate_code FROM partnership_affiliate_code AS pac WHERE affiliate_code = ?
                    ) as sac ;
        ';

        $result = $this->db->query($query, array($affiliateCode,$affiliateCode));
        return ($result->num_rows() > 0) ? false : true;

    }

    public function getAccountNumber( $user_id ){
        $sql = "SELECT account_number as account_number, mt_currency_base as currency FROM mt_accounts_set WHERE user_id = ?
                  UNION ALL
                  SELECT reference_num as account_number, currency as currency FROM partnership WHERE partner_id = ?";

        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    public function getUserIdByAccountNumber( $account ){
        $sql = "SELECT user_id FROM mt_accounts_set WHERE account_number =  ?
                  UNION ALL
                  SELECT partner_id as user_id FROM partnership WHERE reference_num = ? ";

        $query = $this->db->query($sql, array($account, $account));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }


    public function getVerificationStatus($user_id){
        $this->db->select('accountstatus');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $this->db->where_in('accountstatus', array(1,3)); //  0=>"PENDING",1=>"VERIFIED LEVEL 2",2=>"DECLINED",3=>"VERIFIED LEVEL 1",4=>"NO DOCUMENTS SUBMITTED"
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        }
        return false;
    }

    public function getAccountsByDate(){

//        $where = "registration_time BETWEEN  '2016-05-24' and '2016-06-01' ";
        $where = "registration_time BETWEEN '2016-05-27 00:00:00' and '2016-05-27 23:59:59' ";

        $this->db->select('account_number, registration_time')
            ->from('mt_accounts_set')
            ->where($where);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        return false;
    }
  

    public function getListAccountStatus($accounts){
        if(count($accounts) > 0){
            $sql_mt = 'WHERE  mt.account_number IN (' . implode(',', $accounts) . ')';
            $sql_pt = 'WHERE  pt.reference_num IN (' . implode(',', $accounts) . ')';
        }
        $sql = "SELECT * FROM
                    (
                      SELECT u.accountstatus,mt.swap_free, mt.account_number as account_number,mt.mt_account_set_id as account_type FROM mt_accounts_set mt inner join users u on u.id = mt.user_id $sql_mt
	                  UNION
	                  SELECT u.accountstatus,0 as swap_free, pt.reference_num as account_number, 2 as account_type FROM partnership pt inner join users u on u.id = pt.partner_id $sql_pt
	                  ) as sac";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function getAccountNumberByCode($code){
        /*$sql = "SELECT * FROM
                    (
                      SELECT affiliate_code, account_number FROM users_affiliate_code AS uac left join mt_accounts_set as mas on uac.users_id = mas.user_id
	                  UNION
	                  SELECT affiliate_code, reference_num as account_number FROM partnership_affiliate_code AS pac left join partnership as p on pac.partner_id = p.partner_id
                    ) as sac WHERE affiliate_code = ?";*/

        // Query Optimize by Moniruzzaman
        $sql = "SELECT * FROM
                    (
                      SELECT affiliate_code, account_number, uac.users_id FROM users_affiliate_code AS uac inner join mt_accounts_set as mas on uac.users_id = mas.user_id WHERE affiliate_code = ?
	                  UNION ALL
	                  SELECT affiliate_code, reference_num as account_number, pac.partner_id users_id FROM partnership_affiliate_code AS pac inner join partnership as p on pac.partner_id = p.partner_id WHERE affiliate_code = ?
                    ) as sac ";
        
      
        $query = $this->db->query($sql, array($code,$code));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getUserandMTaccountDetails($userId){
        $this->db->select('*')
            ->from('users')
            ->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left')
            ->where('users.id', $userId);

        $result = $this->db->get();
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }

        return false;
    }

    public function getUserReferralCode($user_id) {
        $this->db->select('referral_affiliate_code');
        $this->db->from('users_affiliate_code');
        $this->db->where('users_id', $user_id);
        $this->db->group_by('users_id');
        $this->db->order_by('date_created', 'desc');
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return $query->row_array();
        }
        return false;
    }

    public function getUserAffiliateAgent($referral_aff_code) {
        $this->db->select('partnership.reference_num, partnership.reference_subnum, partnership.partner_id');
        $this->db->from('partnership_affiliate_code');
        $this->db->join('partnership','partnership.partner_id = partnership_affiliate_code.partner_id','left');
        $this->db->where('partnership_affiliate_code.affiliate_code',$referral_aff_code);
        $partner_aff_query = $this->db->get();

        if ($partner_aff_query->num_rows() > 0) {
            $this->db->select('user_profiles.full_name, user_profiles.user_id');
            $this->db->from('partnership');
            $this->db->join('user_profiles','user_profiles.user_id = partnership.partner_id','left');

            if ($partner_aff_query->row_array()['reference_subnum'] != null || $partner_aff_query->row_array()['reference_subnum'] != '') {
                $this->db->where('partnership.reference_num',$partner_aff_query->row_array()['reference_subnum']);
            } else {
                $this->db->where('partnership.partner_id',$partner_aff_query->row_array()['partner_id']);
            }

            $partner_query = $this->db->get();
            if ($partner_query->num_rows() > 0) {
                return $partner_query->row_array();
            }
            return false;
        } else {
            $this->db->select('user_profiles.full_name, user_profiles.user_id');
            $this->db->from('users_affiliate_code');
            $this->db->join('user_profiles','user_profiles.user_id = users_affiliate_code.users_id','left');
            $this->db->where('users_affiliate_code.affiliate_code',$referral_aff_code);

            $client_query = $this->db->get();
            if($client_query->num_rows() > 0){
                return $client_query->row_array();
            }
            return false;
        }

        // Backup
        /*$this->db->select('partnership_affiliate_code.affiliate_code, user_profiles.full_name, user_profiles.user_id');
        $this->db->from('partnership_affiliate_code');
        $this->db->join('user_profiles','user_profiles.user_id = partnership_affiliate_code.partner_id','left');
        $this->db->where('partnership_affiliate_code.affiliate_code',$referral_aff_code);
        $partner_query = $this->db->get();

        if($partner_query->num_rows() > 0){
            return $partner_query->row_array();
        } else {

        }*/
    }

    public function getRemovedAgent($account_number){
        $this->db->select('*')
            ->from('removed_agents')
            ->where('AccountNumber', $account_number);

        $result = $this->db->get();
        if( $result->num_rows() > 0 ){
            return $result->row_array();
        }

        return false;
    }
    public function getAccountNumfromAffliateCode($user_id){
        $query = $this->db->query("select * from users_affiliate_code
join (SELECT affiliate_code, users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
on users_affiliate_code.referral_affiliate_code = t.affiliate_code where t.userid = ?",array($user_id));
            if($query->num_rows() > 0){
                return $query->result_array();
            }else{
                return false;
            }
    }

    public function getAffiliates($user_id){
        $query = $this->db->query("SELECT affiliate_code, users_id userid from users_affiliate_code where users_id = ? UNION ALL SELECT affiliate_code, partner_id userid from partnership_affiliate_code where partner_id = ?", array($user_id,$user_id));
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
    }

    public function getAccountNumPartner($user_id,$aff_code){
        $query = $this->db->query("select * from users_affiliate_code
join (SELECT affiliate_code, users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
on users_affiliate_code.referral_affiliate_code = t.affiliate_code where t.userid = ? and users_affiliate_code.referral_affiliate_code = ?",array($user_id,$aff_code));
            if($query->num_rows() > 0){
                return $query->result_array();
            }else{
                return false;
            }
    }

    public function getAccountNumberClient($user_id){
        $query =  $this->db->query("select id,user_id,account_number FROM mt_accounts_set where user_id=?",array($user_id));
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
    }
    public function getAccountNumberPartner($user_id){
        $query =  $this->db->query("select id,partner_id,reference_number FROM partnership where partner_id=?",array($user_id));
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
    }


    //**  Two Factor Authenticator**/
    public function saveUserTfa($data){
        $sqlStr =
            "INSERT INTO user_tfa (UserId, isEnabled, SecretKey) ".
            "VALUES (?, ?, ?) ".
            "ON DUPLICATE KEY UPDATE isEnabled = '{$data['isEnabled']}', SecretKey = '{$data['SecretKey']}'";

        $this->db->query($sqlStr, $data);
    }

    public function GetTFASettings($userID){

        $result = $this->db->get_where('user_tfa', array('UserID' => $userID ));
        return $result->row_array();

    }

    public function UpdateTFASetting($condition, $updatedata){
        $this->db->where($condition);
        $this->db->update('user_tfa', $updatedata);
    }
    //** End Two Factor Authenticator**/
    function checkUserDocsForCorporate($user_id, $type,$status){
        $this->db->select('*');
        $this->db->from('user_documents');
        $passArray = array(
            'user_id' => $user_id,
            'doc_type' => $type,
            'status'=>$status
        );

        $this->db->where($passArray);
        $this->db->order_by('id','DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        } else {
            return false;
        }

    }


    public function limitedBonusTimeCount($data){

       $this->db->where('user_id',$data['user_id']);
       $this->db->from('limited_bouns');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return true;
        } else {
            $this->db->insert('limited_bouns',$data);
        }

    }
    public function getUserDetailsByAccountNumber_partner($account_number){

        $this->db->select('*')
            ->from('users')
            ->join('partnership', 'users.id = partnership.partner_id', 'left')
            ->join('user_profiles', 'users.id = user_profiles.user_id', 'left')
            ->where('partnership.reference_num', $account_number);
        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getUserDetailsByAccountNumberRow_partner($account_number){

        $this->db->select('*')
            ->from('users')
            ->join('partnership', 'users.id = partnership.partner_id', 'left')
            ->join('user_profiles', 'users.id = user_profiles.user_id', 'left')
            ->where('partnership.reference_num', $account_number);
        $result = $this->db->get();
        if($result->num_rows() > 0 ){
            return $result->row();
        }else{
            return false;
        }
    }

    public function updateAccountBalance_partner( $account_number, $amount ){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('reference_num', $account_number);
        if($this->db->update('partnership', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function getaccountshow($sel,$table,$data){
        $this->db->select($sel)
            ->from($table)
            ->where($data);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    function insertAccountUpdateFieldHistory1( $data ){
        $this->db->insert('account_field_update_history' ,$data);
        return true;
    }

    public function getAccountLoginType( $user_id ){
        $this->db->select('login_type');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    /*
     * CHECK IF ACCOUNT IS MICRO
     */
    function isMicro( $user_id ){
        $this->db->select('micro');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $this->db->where('micro', 1);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }


    /*
   * CHECK IF ACCOUNT IS Ndb
   */
    function isNdb( $user_id ){

        $this->db->select('mt_account_set_id');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $this->db->where('mt_account_set_id', 1);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getAccountsByNameAndEmail($acct_email, $acct_name){
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('mt_accounts_set b','a.id = b.user_id','inner');
        $this->db->join('user_profiles c','a.id = c.user_id','inner');
        $this->db->where('a.email',$acct_email);
        $this->db->where('c.full_name',$acct_name);
        $this->db->where('a.type','1');

        $acctdetails = $this->db->get();

        if($acctdetails->num_rows() > 0){
            return $acctdetails->row_array();
        }else{
           return false;
            }
    }

    /*Method added for auto crediting NDB method from admin */
    function getAccountsByAccountNumber( $account_number ){
        $this->db->select('mt_accounts_set.*, users.type');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id = mt_accounts_set.user_id');
        $this->db->where('mt_accounts_set.account_number', $account_number);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->row_array();
        }else{
            return false;
        }
    }
    /*Method added for auto crediting NDB method from admin */
    public function insertFailedSetAgent($data){

        $db_data = array(
            'user_id' => $data['user_id'],
            'account_number' => $data['account_number'],
            'agent_account_number' => $data['agent_account_number']
        );

        $this->db->insert('failed_set_agent' ,$db_data);
        return $this->db->insert_id();
    }
    function getAccountsByIdType( $id, $type ){
        $this->db->select('mt_accounts_set.*,
                           users.email, users.type, users.affiliate_code, users.nodepositbonus,
                           user_profiles.full_name, user_profiles.country, user_profiles.street, user_profiles.city, user_profiles.state, user_profiles.zip, user_profiles.dob, user_profiles.fb,
                           contacts.phone1, contacts.phone2, contacts.email2, contacts.email3,
                           trading_experience.experience, trading_experience.investment_knowledge, trading_experience.trade_duration, trading_experience.risk,
                           employment_details.politically_exposed_person, employment_details.employment_status, employment_details.employment_status, employment_details.industry,
                           employment_details.estimated_annual_income, employment_details.estimated_net_worth, employment_details.education_level, employment_details.us_resident,
                           employment_details.us_citizen');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id = mt_accounts_set.user_id');
        $this->db->join('user_profiles', 'user_profiles.user_id = mt_accounts_set.user_id', 'left');
        $this->db->join('contacts', 'contacts.user_id = mt_accounts_set.user_id', 'left');
        $this->db->join('trading_experience', 'trading_experience.user_id = mt_accounts_set.user_id', 'left');
        $this->db->join('employment_details', 'employment_details.user_id = mt_accounts_set.user_id', 'left');
        $this->db->where('mt_accounts_set.user_id', $id);
        $this->db->where('mt_accounts_set.mt_type', $type);
        $this->db->where('CHAR_LENGTH(mt_accounts_set.account_number) > 4', null, false);
        $data = $this->db->get();
        return $data->row_array();
    }
    function updateAccountByUserId( $user_id, $data ){
        $this->db->where('user_id', $user_id);
        if($this->db->update('mt_accounts_set', $data)){
            return true;
        }else{
            return false;
        }
    }
    public function getAffiliateDetailsByUserId($user_id){
        $this->db->select('*')
            ->from('users_affiliate_code')
            ->where('users_id', $user_id);

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }
        return false;
    }
    function accountAdditionalInfo_new($f1,$f2,$f3,$f4,$f5){
        $this->db->start_cache();
        $this->db->select('ndb_bonus,users.email,user_profiles.dob');
        $this->db->from('users');
        $this->db->join('user_profiles','users.id=user_profiles.user_id');
        $this->db->join('contacts','contacts.user_id=users.id');
        $this->db->where('phone1', $f1);
        $this->db->where('dob', $f2);
        $this->db->where('zip', $f3);
        $this->db->where('users.ndb_bonus!=', $f4);
        $this->db->where('users.id !=', $f5);
        $query = $this->db->get();
        $this->db->flush_cache();
        return $query;
    }
    function getDetails($user_id){
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('mt_accounts_set b','a.id=b.user_id','inner');
        $this->db->join('user_profiles c','a.id=c.user_id','left');
        $this->db->where('a.id',$user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function getReasonForDeclining($user_id,$application_number){
        $this->db->select('*');
        $this->db->from('user_documents');
        $this->db->where('user_id',$user_id);
        $this->db->where('pac_appnum',$application_number);
        $this->db->where('decline_reason!=','');
        $query = $this->db->get();
        return $query->result_array();
    }
    function checkUserDocs1($user_id, $doc_type,$ctr){
        $this->db->select('*');
        $this->db->from('user_documents');
        if($ctr<=1){
            $passArray = array(
                'user_id' => $user_id,
                'doc_type' => $doc_type
            );
            $this->db->where($passArray);
            $this->db->where('pac_appnum<=1');
        }else{
            $passArray = array(
                'user_id' => $user_id,
                'doc_type' => $doc_type,
                'pac_appnum'=>$ctr
            );
            $this->db->where($passArray);
        }

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }
    }
    function reApplyForPAC($userId,$data){
        $this->db->where('id', $userId);
        if($this->db->update('users', $data)){
            return true;
        }else{
            return false;
        }
    }
    function getPac($user_id){
        $this->db->select('*');
        $this->db->from('users');
        $passArray = array(
            'id' => $user_id
        );
        $this->db->where($passArray);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    public function get_and_transfer_Docdata($file_increment){

        $this->db->select('*');
        $this->db->from('user_documents');
        $this->db->where('id', $file_increment);
        $this->db->limit(1);
        $data = $this->db->get();
        $getdata=$data->result_array();
//        var_dump($getdata[0]);
        if ($this->db->insert('user_documents_replaced', $getdata[0])) {
            return true;
        }
        return false;


    }
    function update_pac_ctr($user_id,$data){
        $this->db->where('id',$user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }
    function update_upload_documents1($user_id, $doc_type, $updatedata, $docid,$pac){
        $passAraray = array(
            'user_id' => $user_id,
            'doc_type' => $doc_type,
            'id' => $docid,
            'pac_appnum'=>$pac
        );
        $this->db->where($passAraray);
        $this->db->update('user_documents', $updatedata);
//        return $this->db->affected_rows();

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;


    }
    function insertlog($table,$data){
        if ($this->db->insert($table, $data)){
            return $this->db->insert_id();
        }
        return false;
    }
    function checkAccountUploadedDocs($user_id){
        $this->db->select('*');
        $this->db->from('user_documents');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }
    }
    function checkAccountDeclinedDocs($user_id){
        $this->db->select('*');
        $this->db->from('user_documents');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }
    }
    function getDetails_new($user_id){
        $this->db->select('*');
        $this->db->from('users a');
        $this->db->join('user_profiles c','a.id=c.user_id','left');
        $this->db->where('a.id',$user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAccountsByNameAndEmail1($email, $name, $user)
    {

        $nonEUGroup = $this->isNONEUGroup($user);

        $this->db->select('a.*,b.*,c.full_name,c.country ');
        $this->db->from('users a ');
        $this->db->join('mt_accounts_set b', 'a.id=b.user_id', 'inner');
        $this->db->join('user_profiles c', 'a.id = c.user_id', 'inner');
        $this->db->where('a.email', $email);
        $this->db->where('c.full_name', $name);
        $this->db->where('a.administration !=', '1');
        $this->db->where('a.type', '1');
       // $this->db->where('a.account_link', '1');
        $this->db->where('b.user_id !=', $user);
        if ($nonEUGroup) {
            $this->db->like('b.group', 'D-', 'after');
        } else {
            $this->db->not_like('b.group', 'D-', 'after');
        }


        $data = $this->db->get();
        return $data->result_array();
    }
    
    public function getRelatedAccounts($email, $name, $user,$country)
    {

        $this->db->select('b.account_number');
        $this->db->from('users a ');
        $this->db->join('mt_accounts_set b', 'a.id=b.user_id', 'inner');
        $this->db->join('user_profiles c', 'a.id = c.user_id', 'inner');
        $this->db->where('a.email', $email);
        $this->db->where('c.full_name', $name);
        $this->db->where('c.country',$country);
        $this->db->where('a.administration !=', '1');
        $this->db->where('a.type', '1');
        $this->db->where('b.user_id !=', $user);
        $data = $this->db->get();

        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }

    }
    
     public function getRelatedAccountsV2($acc_login_type,$email,$dob,$country,$name,$user_id)
    {
         $inner_quel= array($email,$dob,$name,$user_id);
         $dob_country_condition="DATE_FORMAT(usersp.dob,'%Y-%m-%d') =DATE_FORMAT(?,'%Y-%m-%d')";
         if($dob=="" or $dob==" " or $dob==null or $dob==NULL)
         {
            $dob_country_condition="LOWER(usersp.country)=LOWER(?)";
            $inner_quel= array($email,$country,$name,$user_id);
         }
         
         
         $sql_acc_query="select matc.account_number from users 
                INNER JOIN user_profiles usersp on users.id=usersp.user_id
                INNER JOIN mt_accounts_set matc on users.id=matc.user_id
                where LOWER(users.email)=LOWER(?)
                and ".$dob_country_condition."
                and LOWER(usersp.full_name)=LOWER(?)
                and users.type=1
                and users.id !=?
                and matc.remove_account !=1
                ORDER BY users.id ASC";
         
          $sql_pat_query="select patc.reference_num account_number from users 
                INNER JOIN user_profiles usersp on users.id=usersp.user_id
                INNER JOIN partnership patc on users.id=patc.partner_id
                where LOWER(users.email)=LOWER(?)
                and ".$dob_country_condition."
                and LOWER(usersp.full_name)=LOWER(?)
                and users.type=1
                and users.id !=?
                ORDER BY users.id ASC";
        
$sql_query=($acc_login_type=="client")?$sql_acc_query:$sql_pat_query;
          
         
           $query = $this->db->query($sql_query,$inner_quel);
         
          if($query->num_rows() > 0) {
            return $query->result_array();
            } else {
                return false;
            }
         


    }
	
    public function getRelatedAccountsWithoutColsed($email, $name, $user,$country)
    {

        $this->db->select('b.account_number');
        $this->db->from('users a ');
        $this->db->join('mt_accounts_set b', 'a.id=b.user_id', 'inner');
        $this->db->join('user_profiles c', 'a.id = c.user_id', 'inner');
        $this->db->where('a.email', $email);
        $this->db->where('c.full_name', $name);
        $this->db->where('c.country',$country);
        $this->db->where('a.administration !=', '1');
        $this->db->where('a.type', '1');
        $this->db->where('b.user_id !=', $user);
        $this->db->where('b.remove_account !=', '1');
        $data = $this->db->get();

        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }

    }
    
     public function getRelatedPartnerAccountsWithoutColsed($email, $name, $user,$country)
    {

        $this->db->select('b.reference_num account_number');
        $this->db->from('users a ');
        $this->db->join('partnership b', 'a.id=b.partner_id', 'inner');
        $this->db->join('user_profiles c', 'a.id = c.user_id', 'inner');
        $this->db->where('a.email', $email);
        $this->db->where('c.full_name', $name);
        $this->db->where('c.country',$country);
        $this->db->where('a.administration !=', '1');
        $this->db->where('a.type', '1');
        $this->db->where('b.partner_id !=', $user);
    //    $this->db->where('b.remove_account !=', '1');
        $data = $this->db->get();

        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }

    }

    public function isNONEUGroup($user_id){
        $this->db->select('group');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id',$user_id);

        $data = $this->db->get();
        if($data->num_rows() > 0) {
            $group =  $data->row()->group;
            if(substr($group, 0, 2) == "D-"){
                return true;
            }
        }

        return false;

    }
    function getAccountsCountry($user_id){
        $this->db->select('country');
        $this->db->from('user_profiles');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->result_array();
        }else{
            return false;
        }
    }


    function getAccountsByAccountNumber_minibonus( $account_number ){
        $this->db->select('mt_accounts_set.*, users.type,users.accountstatus,users.email,user_profiles.full_name,user_profiles.dob,users.nodepositbonus');
        $this->db->from('mt_accounts_set');
        $this->db->join('users', 'users.id = mt_accounts_set.user_id');
        $this->db->join('user_profiles', 'user_profiles.user_id = mt_accounts_set.user_id','left');
        $this->db->where('mt_accounts_set.account_number', $account_number);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('1');
        $data = $this->db->get();
        if($data->num_rows() > 0){
            return $data->row_array();
        }else{
            return false;
        }
    }

    public function getWithdrawalTransactionYandex_payout($ticket){

//        $this->db->select('withdraw.reference_number as Reference No,user_profiles.full_name as Full Name,withdraw.account_number as Account Number,withdraw.amount as Amount,withdraw.amount_deducted as Amount Deducted,withdraw.date_withdraw as date requested')
//
        $this->db->select('withdraw.reference_number,user_profiles.full_name,withdraw.account_number, withdraw.amount,withdraw.amount_deducted,withdraw.date_withdraw')
            ->from('withdraw')
            ->join('user_profiles', 'user_profiles.user_id = withdraw.user_id', 'left')
            ->join('yandex_money', 'yandex_money.id = withdraw.transaction_id', 'left')
            ->where('withdraw.transaction_type', 'YAN')
            ->where('withdraw.reference_number', $ticket)
            ->where('withdraw.status',1);

        $result = $this->db->get();

        return ($result->num_rows() > 0) ? $result->result_array() : false;

    }

    public function getCISRegPerDay() {

        $sql = "select count(*) num
from users u inner join user_profiles up on u.id= up.user_id inner join mt_accounts_set mt on mt.user_id=u.id
 left join contacts c on u.id=c.user_id where u.type=1 and DATE(u.created)= date(NOW() - INTERVAL 0 DAY)
 and up.country in ('AM','BY','KZ','KG','MD','RU','TJ','TM','UA','UZ') and LOWER(up.full_name) NOT LIKE '%test%' and LOWER(up.street)
 NOT LIKE '%test%' and LOWER(up.city) NOT LIKE LOWER('%test%') and LOWER(up.state) NOT LIKE '%test%' order by up.country, u.id desc ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row()->num;
        } else {
            return false;
        }
    }

    public function getRegistrationIP($user_id){

        $this->db->select('registration_ip');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->row_array();
            return $result["registration_ip"];
        }

        return false;
    }

    function getUserRecord($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }

        return false;
    }

    public function isLinkAccount($email, $name, $user,$account_number)
    {

        $nonEUGroup = $this->isNONEUGroup($user);

        $this->db->select('a.id,a.administration,a.login_type,b.account_number');
        $this->db->from('users a ');
        $this->db->join('mt_accounts_set b', 'a.id=b.user_id', 'inner');
        $this->db->join('user_profiles c', 'a.id = c.user_id', 'inner');
        $this->db->where('a.email', $email);
        $this->db->where('c.full_name', $name);
        $this->db->where('b.account_number', $account_number);
        if ($nonEUGroup) {
            $this->db->like('b.group', 'D-', 'after');
        } else {
            $this->db->not_like('b.group', 'D-', 'after');
        }
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }
       return false;
    }

    public function isPartnerAcVerified($user_id){

        $this->db->select('usr2.accountstatus as cpa_accountstatus,partnership.type_of_partnership,users_affiliate_code.referral_affiliate_code,users.email,users.accountstatus');
        $this->db->from('users_affiliate_code');
        $this->db->join('partnership_affiliate_code', 'users_affiliate_code.referral_affiliate_code = partnership_affiliate_code.affiliate_code', 'inner');
        $this->db->join('users', 'users.id = partnership_affiliate_code.partner_id', 'inner');
        $this->db->join('partnership', 'partnership.partner_id = partnership_affiliate_code.partner_id', 'inner');
        $this->db->join('partnership p2', 'p2.reference_num = partnership.reference_subnum', 'left');
        $this->db->join('users usr2', 'usr2.id = p2.partner_id', 'left');
        $this->db->where('users_affiliate_code.users_id', $user_id);
        $this->db->where('length(users_affiliate_code.referral_affiliate_code)>0');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }
	
	function getFirstPhoneCodeByUserId($user_id){
        $this->db->select('sms_code_1');
        $this->db->select('phone_verified_1');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }
	
	function getSecondPhoneCodeByUserId($user_id){
        $this->db->select('sms_code_2');
        $this->db->select('phone_verified_2');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return false;
        }
    }

    public function UpdateThirtyDollarBonuse($user_id, $updatedata){

        $this->db->where('id',$user_id);

        $return = $this->db->update('users', $updatedata);

        if($return){
            return true;
        }else{
            return false;
        }

    }
    
      function getRow($table, $where){
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }
        
        return false;
    }
    

}
