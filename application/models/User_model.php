<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function getUserProfileByUserId( $user_id ){

//        $this->db->trans_start();
        $this->db->select('user_profiles.*, users.email, contacts.phone1, contacts.phone2, contacts.email2, contacts.email3');
        $this->db->from('user_profiles');
        $this->db->join('users', 'user_profiles.user_id = users.id');
        $this->db->join('contacts', 'contacts.user_id = users.id', 'left');
        $this->db->where('user_profiles.user_id', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
        //$this->db->trans_complete();
    }

    function getUserAvatar( $user_id ){

//        $this->db->trans_start();
        $this->db->select('cpy_avatar');
        $this->db->from('mt_accounts_set');
        $this->db->where('account_number', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
        //$this->db->trans_complete();
    }

    function change_password($user_id, $new_pass)
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('password' => $new_pass));
    }

    function updateUserProfileById( $user_id, $data ){
        $query1 = false;
        $query2 = false;

        $user_profiles_data = array(
//            'full_name' => $data['full_name'],
            'street' => $data['street'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'country' => $data['country'],
            'preferred_time' => $data['preferred_time']
        );

        if( array_key_exists('image', $data) ){
            $user_profiles_data['image'] = $data['image'];
        }


        $this->db->from('contacts');
        $this->db->where('user_id', $user_id);
        $contact_result = $this->db->get();
        if($contact_result->num_rows() > 0) {
            $user_contacts_data = array(
                'phone1' => $data['phone1'],
                'phone2' => $data['phone2'],
                'email1' => $data['email1'],
                'email2' => $data['email2'],
                'email3' => $data['email3']
            );
            $this->db->where('user_id', $user_id);
            $this->db->update('contacts', $user_contacts_data);
        }else{
            $user_contacts_data = array(
                'phone1' => $data['phone1'],
                'phone2' => $data['phone2'],
                'email1' => $data['email1'],
                'email2' => $data['email2'],
                'email3' => $data['email3'],
                'user_id' => $user_id
            );
            $this->db->insert('contacts', $user_contacts_data);
        }

        $user_email = array(
            'email' => $data['email1']
        );

        //update user_profiles
        $this->db->where('user_id', $user_id);
        if($this->db->update('user_profiles', $user_profiles_data)){
            $query1 = true;
        }

        $this->db->where('id', $user_id);
        if($this->db->update('users', $user_email)){
            $query2 = false;
        }

        //update user_contacts
//        $this->db->where('user_id', $user_id);
//        if($this->db->update('contacts', $user_contacts_data)){
//            $query2 = false;
//        }

        return ($query1 || $query2);
    }

    public function checkExistingEmail($email){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('LOWER(email)', strtolower($email));
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function validateToken($token){
        $this->db->select('*');
        $this->db->from('user_forgot_password');
        $this->db->where('Hash', $token);
        $data = $this->db->get();
        return ($data->num_rows() > 0) ? false : true;
    }

    public function getForgotPasswordDetails($token){
        $this->db->select('*');
        $this->db->from('user_forgot_password');
        $this->db->where('Hash', $token);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }

    public function checkExistingAccountNumber($acc_num){
        $this->db->select('users.id');
        $this->db->from('users');
        $this->db->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left');
        $this->db->join('partnership', 'users.id = partnership.partner_id', 'left');
        $this->db->where('mt_accounts_set.account_number', $acc_num);
        $this->db->or_where('partnership.reference_num', $acc_num);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function getUserIdbyAccountNumber($acc_num){
        $this->db->select('user_id,mt_currency_base');
        $this->db->from('mt_accounts_set');
        $this->db->where('account_number', $acc_num);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->result_array();
        }else{
            return false;
        }
    }
    public function getIdbyAccNumClientPartner($acc_num){
        $this->db->select('users.id,users.email, mt_accounts_set.account_number');
        $this->db->from('users');
        $this->db->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left');
        $this->db->join('partnership', 'users.id = partnership.partner_id', 'left');
        $this->db->where('mt_accounts_set.account_number', $acc_num);
        $this->db->or_where('partnership.reference_num', $acc_num);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }

    public function validateForgotDetails($email, $acc_num){

        $this->db->select('users.id');
        $this->db->from('users');
        $this->db->join('mt_accounts_set', 'users.id = mt_accounts_set.user_id', 'left');
        $this->db->join('partnership', 'users.id = partnership.partner_id', 'left');
        $this->db->where('mt_accounts_set.account_number', $acc_num);
        $this->db->or_where('partnership.reference_num', $acc_num);
        $this->db->where('users.email', $email);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function updateUserProfileInfoById( $user_id, $data ){
        $this->db->where('user_id', $user_id);
        if($this->db->update('user_profiles', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function deleteExpiredTokens(){
        $this->db->where('DATE_ADD(user_forgot_password.Date, INTERVAL 24 HOUR) < NOW()');
        $is_deleted = $this->db->delete('user_forgot_password');
        $this->db->trans_complete();
        if($is_deleted){
            return true;
        }else{
            return false;
        }
    }

    public function deleteExpiredProfileRequests(){
        $this->db->where('DATE_ADD(user_profile_requests.date_changed, INTERVAL 1 DAY) < NOW()');
        $is_deleted = $this->db->delete('user_profile_requests');
        $this->db->trans_complete();
        if($is_deleted){
            return true;
        }else{
            return false;
        }
    }

    public function hasProfileRequests( $user_id ){
        $this->db->where('user_profile_requests.user_id', $user_id);
        $this->db->from('user_profile_requests');
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function insertProfileChangeRequest( $data ){
        if ($this->db->insert_batch('user_profile_requests', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfileChangeDateLastRequest( $user_id ){
        $this->db->distinct();
        $this->db->from('user_profile_requests');
        $this->db->where('user_profile_requests.user_id', $user_id);
        $this->db->order_by('user_profile_requests.date_changed', 'DESC');
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['date_changed'];
        }else{
            return false;
        }
    }

    public function updateUserAvatar( $user_id, $image_name = '' ){
        $user_profiles_data['image'] = $image_name;
        $this->db->where('user_id', $user_id);
        if($this->db->update('user_profiles', $user_profiles_data)){
            return true;
        }else{
            return false;
        }

    }
    public function updatCpyUserAvatar( $user_id, $image_name = '' ){
        $user_profiles_data['cpy_avatar'] = $image_name;
        $this->db->where('account_number', $user_id);
        if($this->db->update('mt_accounts_set', $user_profiles_data)){
            return true;
        }else{
            return false;
        }

    }

    public function getUserDetails( $user_id ){
        $this->db->from('users');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getUserDetailsMT( $user_id ){
        $this->db->select('*');
        $this->db->from('mt_accounts_set');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }
        public function getPartnerDetailsMT( $user_id ){
        $this->db->select('partnership.reference_num as account_number, partnership.partner_id as user_id, partnership.*');
        $this->db->from('partnership');
        $this->db->where('partner_id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function validateToken_v2($token){
        $this->db->select('*');
        $this->db->from('user_forgot_password');
        $this->db->where('Hash', $token);
        $data = $this->db->get();
        return ($data->num_rows() > 0) ? true : false;
    }

    function getAccouTypeStatus($select,$table,$where){
        $query=$this->db->select($select)
            ->get_where($table,$where);
        if($query->num_rows()>0){
            return $query->row();
        } else{
            return false;
        }
    }

    public function getUserAccountTypeById( $user_id ){
        $this->db->from('users');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    /*Method added for auto crediting NDB method from admin */
    function getUserProfileByUserId_admin( $user_id ){

        $this->db->from('user_profiles');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }

    }
    /*Method added for auto crediting NDB method from admin */



    public function getFirstUserDetailsByEmailAndNamev2( $email , $name ){
        $this->db->select('mt_accounts_set.account_number,users.created registration_date,users.accountstatus,user_profiles.user_id,user_profiles.full_name,user_profiles.street, user_profiles.city, user_profiles.state, user_profiles.country, user_profiles.zip, user_profiles.dob,user_profiles.age,user_profiles.gender,user_profiles.tin,user_profiles.passport_number,user_profiles.issuing_authority, contacts.phone1,contacts.telephone, users.affiliate_code,
                           trading_experience.experience, trading_experience.investment_knowledge, trading_experience.trade_duration, trading_experience.risk,
                           trading_experience.bankruptcy, trading_experience.trading_leverage_experience, trading_experience.number_of_trades, trading_experience.otc_meaning,
                            trading_experience.cfd_equity_stop_out_level,trading_experience.cfd_higher_leverage, trading_experience.stop_out_level_50, trading_experience.seminar_attended,
                           employment_details.politically_exposed_person, employment_details.employment_status, employment_details.employment_status, employment_details.industry,
                           employment_details.estimated_annual_income, employment_details.estimated_net_worth, employment_details.education_level, employment_details.us_resident,
                           employment_details.us_citizen, mt_accounts_set.mt_account_set_id, mt_accounts_set.mt_currency_base, mt_accounts_set.leverage, mt_accounts_set.swap_free');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id = users.id');
        $this->db->join('contacts', 'contacts.user_id = users.id');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users.id');
        $this->db->join('trading_experience', 'trading_experience.user_id = users.id', 'left');
        $this->db->join('employment_details', 'employment_details.user_id = users.id', 'left');
       // $this->db->where('users.accountstatus', 1);  //
        $this->db->where('LOWER(users.email)', strtolower($email));
        $this->db->where('LOWER(user_profiles.full_name)', strtolower($name));
        $this->db->order_by('users.created');
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0) {
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getFirstUserDetailsByEmailAndName( $email , $name , $country ){
        $this->db->select('mt_accounts_set.account_number,users.created registration_date,users.accountstatus,user_profiles.user_id,user_profiles.full_name,user_profiles.street, user_profiles.city, user_profiles.state, user_profiles.country, user_profiles.zip, user_profiles.dob, contacts.phone1, users.affiliate_code,
                           trading_experience.experience, trading_experience.investment_knowledge, trading_experience.trade_duration, trading_experience.risk,
                           employment_details.politically_exposed_person, employment_details.employment_status, employment_details.employment_status, employment_details.industry,
                           employment_details.estimated_annual_income, employment_details.estimated_net_worth, employment_details.education_level, employment_details.us_resident,
                           employment_details.us_citizen, mt_accounts_set.mt_account_set_id, mt_accounts_set.mt_currency_base, mt_accounts_set.leverage, mt_accounts_set.swap_free');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id = users.id');
        $this->db->join('contacts', 'contacts.user_id = users.id');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users.id');
        $this->db->join('trading_experience', 'trading_experience.user_id = users.id', 'left');
        $this->db->join('employment_details', 'employment_details.user_id = users.id', 'left');
       // $this->db->where('users.accountstatus', 1);  //
        $this->db->where('LOWER(users.email)', strtolower($email));
        $this->db->where('LOWER(user_profiles.full_name)', strtolower($name));
        $this->db->where('LOWER(user_profiles.country)', strtolower($country));
        $this->db->order_by('users.created');
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0) {
            return $result->row_array();
        }else{
            return false;
        }
    }





    public function getFirstUserDetailsByEmailAndNameAndAcc( $email , $name , $acc ){
        $this->db->select('mt_accounts_set.account_number,users.created registration_date,users.accountstatus,user_profiles.user_id,user_profiles.full_name,user_profiles.street, user_profiles.city, user_profiles.state, user_profiles.country, user_profiles.zip, user_profiles.dob, contacts.phone1, users.affiliate_code,
                           trading_experience.experience, trading_experience.investment_knowledge, trading_experience.trade_duration, trading_experience.risk,
                           employment_details.politically_exposed_person, employment_details.employment_status, employment_details.employment_status, employment_details.industry,
                           employment_details.estimated_annual_income, employment_details.estimated_net_worth, employment_details.education_level, employment_details.us_resident,
                           employment_details.us_citizen, mt_accounts_set.mt_account_set_id, mt_accounts_set.mt_currency_base, mt_accounts_set.leverage, mt_accounts_set.swap_free');
        $this->db->from('users');
        $this->db->join('user_profiles', 'user_profiles.user_id = users.id');
        $this->db->join('contacts', 'contacts.user_id = users.id');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users.id');
        $this->db->join('trading_experience', 'trading_experience.user_id = users.id', 'left');
        $this->db->join('employment_details', 'employment_details.user_id = users.id', 'left');
        $this->db->where('mt_accounts_set.account_number', $acc);  //
        $this->db->where('LOWER(users.email)', strtolower($email));
        $this->db->order_by('users.created');
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0) {
            return $result->row_array();
        }else{
            return false;
        }
    }







    public function updateUserById( $user_id, $data ){
        $this->db->where('id', $user_id);
        if($this->db->update('users', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getPartnerByAccount($reference_num) {
        $this->db->select('partner_id,reference_num,currency');
        $this->db->from('partnership');
        $this->db->where('reference_num',$reference_num);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getUserEmail($user_id){
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row()->email;
        }else{
            return false;
        }
    }

}