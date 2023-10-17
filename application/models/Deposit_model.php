<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Deposit_model extends CI_Model
{
    private $table = 'deposit';
    private $table_queue = 'deposit_queue';
    private $table_deposit_bonus = 'deposit_bonus';

    function __construct()
    {
        parent::__construct();
    }

    function insertPayment( $data = array() ){
        if($this->db->insert($this->table, $data)){
            
               $last_id = $this->db->insert_id();
               return $last_id;            
            
        }else{
            return false;
        }
    }

    function insertPayment_v2($table, $data = array() ){
        if($this->db->insert($table, $data)){

            $last_id = $this->db->insert_id();
            return $last_id;

        }else{
            return false;
        }
    }

    function insertPaymentQueue( $data = array() ){
        if($this->db->insert($this->table_queue, $data)){
            return true;
        }else{
            return false;
        }
    }

    function deletePaymentQueueByTranId( $transaction_id = 0 ){
        $this->db->where('transaction_id', $transaction_id);
        if($this->db->delete($this->table_queue)){
            return true;
        }else{
            return false;
        }
    }

    function getPaymentQuequeByTranType($transaction_type=''){
        $this->db->from($this->table_queue);
        $this->db->where('transaction_type', $transaction_type);
        $this->db->group_by('transaction_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
    }
    
       function getPaymentQuequeByTranTypeTest($transaction_type='',$user_id='',$id=false){
        $this->db->from($this->table_queue);
        $this->db->where('transaction_type', $transaction_type);
         $this->db->where('user_id', $user_id);
         if($id){ 
         $this->db->where('id', $id);
         }
        $this->db->group_by('transaction_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
    }

    function has20BonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function has30BonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function hasClaimed20BonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 1);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function hasClaimed30BonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('thirtypercentbonus', 1);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
    function has30BonusDeposit_test( $user_id ){
//        print_r($this->table);exit;
        $this->db->select('*');
        $this->db->from('Deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();
        $query = $this->db->get();
        if($count > 0){
            $query->result_array();
        }else{
            return false;
        }
    }

    function has50BonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function has50PercentBonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('fiftypercentbonus', 1);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function hasPercentBonusDeposit( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
    function getAll20BonusDeposit( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getAll30BonusDeposit( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getAll20BonusDeposit_all_new( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount,conv_amount,transaction_type');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getAll30BonusDeposit_all_new( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount,conv_amount,transaction_type');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }

    function getAll50BonusDeposit( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getAll50BonusDeposit_all( $user_id ){
        $this->db->select('payment_date, sum(amount) as amount, conv_amount,transaction_type');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }

    function getAll20BonusDepositAmount( $user_id ){
        $this->db->select('sum(amount * 0.20) as amount', false);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->row_array();
    }

    function getAll30BonusDepositAmount( $user_id ){
        $this->db->select('sum(amount * 0.30) as amount', false);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->row_array();
    }
    function getAll20BonusDepositAmount_test123( $user_id ){
        $this->db->select('*', false);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getAll30BonusDepositAmount_test123( $user_id ){
        $this->db->select('*', false);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }

    function getAll50BonusDepositAmount( $user_id ){
        $this->db->select('sum(amount * 0.50) as amount', false);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->row_array();
    }
    function getAll50BonusDepositAmount_all( $user_id ){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }


    function setBonusTwentyBonus( $user_id, $value, $date, $bonus_loc ){
        $data = array(
            'twentypercentbonus' => (int) $value,
            'date_bonus_acquired' => $date,
            'bonus_location' => $bonus_loc
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }

    function setBonusThirtyBonus( $user_id, $value, $date, $bonus_loc ){
        $data = array(
           'thirtypercentbonus' => (int) $value,
           'date_bonus_acquired' => $date,
           'bonus_location' => $bonus_loc
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }

    function setBonusFiftyBonus( $user_id, $value, $date, $bonus_loc ){
        $data = array(
           'fiftypercentbonus' => (int) $value,
           'date_bonus_acquired' => $date,
           'bonus_location' => $bonus_loc
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('status', 2);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getFirstPercentBonusAcquired( $user_id ){
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('(thirtypercentbonus = 1 OR twentypercentbonus = 1 OR fiftypercentbonus = 1 OR hundredpercentbonus = 1 OR tenpercentbonus = 1)');
        $this->db->where('status', 2);
        $this->db->limit(1);

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getFirstPercentBonusAcquiredITS( $account_number  ){
        $this->db->select('DepositId,AccountNumber,BonusType');
        $this->db->from($this->table_deposit_bonus);
        $this->db->where('AccountNumber', $account_number );
        $this->db->where('BonusStatus',2);
        $this->db->limit(1);

        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function checkTransactionExist( $transaction_id, $payment_type ){
        $this->db->from($this->table);
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where("UCASE(transaction_type) = '" . $payment_type . "'", null, false);
//        $this->db->where('status', 2);
        $count = $this->db->count_all_results();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function isExistTransaction( $transaction_id, $payment_type ){

        $this->db->trans_complete();  // for testing other trans is not complete

        $this->db->trans_start();
        $this->db->select('count(transaction_id) num');
        $this->db->from($this->table);
        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('transaction_type',$payment_type);
        $data = $this->db->get();
        $this->db->trans_complete();
        if($data->num_rows() > 0){
            return $data->row()->num;
        }else{
            return false;
        }


    }

    public function getDepositNeteller(){
        $this->db->select('*')
            ->from($this->table)
            ->where('transaction_type', 'Neteller');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function updateDepositNeteller($id, $amount){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
    }

    public function getTotalDeposit($user_id, $status){
        $sql = "SELECT SUM(amount) AS TotalAmount FROM deposit where user_id = ? and status = ?";
        $query = $this->db->query($sql, array($user_id, $status));
        if ($query->num_rows() > 0) {
            return $query->row()->TotalAmount;
        }
        return false;

    }

    public function getTotalDepositTransit($user_id, $status){
        $sql = "SELECT SUM(amount_transfer) AS TotalAmount FROM transit_transfer where receiver = ? and status = ?";
        $query = $this->db->query($sql, array($user_id, $status));
        if ($query->num_rows() > 0) {
            return $query->row()->TotalAmount;
        }
        return false;

    }

    public function insertNoDepositRequest($data){
        if($this->db->insert('no_deposit', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insertPayment_v3($table, $data = array() ){
        if($this->db->insert($table, $data)){

            $last_id = $this->db->insert_id();
            return $last_id;

        }else{
            return false;
        }
    }

    public function hasNoDepositRequest( $user_id ){
        $this->db->from('no_deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_approved', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function testresponsemegatransfer( $data ){
        if($this->db->insert('testtablemegatransfer', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function response_neteller( $data ){
        if($this->db->insert('neteller_response', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function updateDepositTransactionData($id, $transData){
        $this->db->where('reference_id',$id);
        if ($this->db->update($this->table, $transData)){
            return true;
        }else{
            return false;
        }
    }

    public function getTransactionDepositData($order_id){
        $this->db->select('*')
            ->from($this->table)
            ->where('reference_id', $order_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

    function getAllClaimed20percentBonus( $user_id ){
        $this->db->select('sum(amount) as sum')
            ->from($this->table)
            ->where('user_id', $user_id)
            ->where('twentypercentbonus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

    function getAllClaimed30percentBonus( $user_id ){
        $this->db->select('sum(amount) as sum')
            ->from($this->table)
            ->where('user_id', $user_id)
            ->where('thirtypercentbonus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }
    function getAllClaimed50percentBonus( $user_id ){
        $this->db->select('sum(amount) as sum')
            ->from($this->table)
            ->where('user_id', $user_id)
            ->where('fiftypercentbonus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }
    public function getDepositTransactionByTicket( $ticket ){
        $this->db->select('*')
            ->from('deposit')
            ->where('mt_ticket', $ticket);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getDepositTicketByUser( $user_id ){
        $this->db->select('mt_ticket')
            ->from('deposit')
            ->where('user_id', $user_id)
            ->where('status', 2);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->result_array();
        }else{
            return false;
        }
    }

    public function getNumberOfDepositsByUser ( $user_id ) {
        $this->db->select('count(*) as counts', false)
            ->from('deposit')
            ->where('user_id', $user_id)
            ->where('status', 2)
            ->group_by('transaction_id');
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->num_rows();
        }else{
            return 0;
        }
    }

    function insertDepositBonus($data){
        if($this->db->insert($this->table_deposit_bonus, $data)){
            return true;
        }
        return false;
    }

    function updateDepositBonus( $user_id, $value, $date, $bonus, $depositId ){
        $data = array(
            $bonus => (int) $value,
            'date_bonus_acquired' => $date
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('transaction_id', $depositId);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }


    function updateDepositBonus_v2( $user_id, $value, $date, $bonus, $transaction_id,$location,$status ){
        $data = array(
            $bonus => (int) $value,
            'date_bonus_acquired' => $date,
            'bonus_location' => $location,
            'bonus_status' => $status
        );

        $this->db->where('user_id', $user_id);
        $this->db->where('transaction_id', $transaction_id);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }
    function updateDepositBonusStatus_v1( $user_id,$transaction_id,$status ){
        $data = array(
            'bonus_status' => $status
        );

        $this->db->where('user_id', $user_id);
        $this->db->where('transaction_id', $transaction_id);
        if($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }




    function has50PercentBonusDeposit_v2( $user_id ){
        $this->db->select('BonusStatus,fiftypercentbonus');
        $this->db->from($this->table_deposit_bonus);
        $this->db->join('deposit', 'deposit.user_id = deposit_bonus.UserId');
        $this->db->where('deposit_bonus.UserId', $user_id);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('BonusStatus', 1);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function has20PercentBonusDeposit_v2( $user_id ){
        $this->db->select('BonusStatus,twentypercentbonus');
        $this->db->from($this->table_deposit_bonus);
        $this->db->join('deposit', 'deposit.user_id = deposit_bonus.UserId');
        $this->db->where('deposit_bonus.UserId', $user_id);
        $this->db->where('twentypercentbonus', 0);
        $this->db->where('BonusStatus', 1);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    function has30PercentBonusDeposit_v2( $user_id ){
        $this->db->select('BonusStatus,thirtypercentbonus');
        $this->db->from($this->table_deposit_bonus);
        $this->db->join('deposit', 'deposit.user_id = deposit_bonus.UserId');
        $this->db->where('deposit_bonus.UserId', $user_id);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('BonusStatus', 1);
        $count = $this->db->count_all_results();

        if($count > 0){
            return true;
        }else{
            return false;
        }
    }


    public function getDepositByTransactionId($transactionId, $tranType){
        $this->db->select('*')
            ->from($this->table)
            ->where('transaction_id', $transactionId)
            ->where('transaction_type', $tranType);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row_array();
        }
        return false;
    }

    public function getDepositByTransactionId2($transactionId){
        $this->db->select('*')
            ->from($this->table)
            ->where('transaction_id', $transactionId);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row_array();
        }
        return false;
    }

    public function updateUnprocessedBonus($id, $transData){
        $this->db->where('DepositId',$id);
        $this->db->update($this->table_deposit_bonus, $transData);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }

    }

    
    function hasBonusDeposit_general( $user_id ){

        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('thirtypercentbonus', 0);
        $this->db->where('fiftypercentbonus', 0);
        $this->db->where('hundredpercentbonus', 0);
        $this->db->where('fiftypercentlimitedbonus', 0);
        $this->db->where('status', 2);
        $count = $this->db->count_all_results();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
    public function setNoDepositRequestStatus( $user_id, $status ){
        $data = array(
            'is_approved' => $status
        );
        $this->db->where('user_id', $user_id);
        if($this->db->update('no_deposit', $data)){
            return true;
        }else{
            return false;
        }
    }

    public function insertNdbCancellationLogs($data){
        if($this->db->insert('ndb_deposit_cancellation', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
       public function checkDepositDoneSMY($transaction_id){
        $sql = "SELECT transaction_id from deposit where  transaction_id=? HAVING count(*)>1";
        $query = $this->db->query($sql, array($transaction_id));
        if($query->num_rows() > 0) {
            return $query->row()->transaction_id;
        }
        return false;

    }

    function testresponsepaypal($data){
        if($this->db->insert('paypal_response', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function insertpaymentResponse($table,$data){
        if($this->db->insert($table, $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function updateDepositById($id, $data){
        $this->db->where('id',$id);
        if ($this->db->update($this->table, $data)){
            return true;
        }else{
            return false;
        }
    }
    function insertBonusLogAttempt($data){
        $this->db->insert('Bonus_logs', $data);
        return $this->db->insert_id();
    }
    function getAccountTotalDeposit( $user_id ){
        $this->db->select('payment_date,amount,conv_amount,transaction_type');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->group_by('payment_date, transaction_id, reference_id');
        $this->db->order_by('payment_date');
        $result = $this->db->get();
        return $result->result_array();
    }
    public function getAllTransitTrasfers($account_num){
        $this->db->select('amount_transfer,date_transfer,conv_amount');
        $this->db->from('transit_transfer');
        $this->db->where('receiver', $account_num);
        $this->db->where('status', 2);
//        $this->db->where('bonus',null);
        $this->db->where('bonus', 0);
        $this->db->order_by('date_transfer');
        $result = $this->db->get();
        return $result->result_array();
    }
    function setBonusITS( $account_num, $bonus , $date ){
        /* 1-30%bonus, 2-50% bonus 3-20% bonus */
        $data = array(
            'bonus' => (int) $bonus,
            'bonus_acquired' => $date,
        );
        $this->db->where('receiver', $account_num);
        $this->db->where('status', 2);
//        $this->db->or_where('bonus', null);
        $this->db->where('bonus', 0);
        if($this->db->update('transit_transfer', $data)){
            return true;
        }else{
            return false;
        }
    }

    function getWithdrawNDB( $account_number){
        $this->db->from('withdraw_bonus');
        $this->db->where('Account_number', $account_number);
        $this->db->where('Bonus_id', 2);
        $this->db->where('Amount >',0);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row_array();
        }else{
            return false;
        }
    }

    function insert30dollarbonus($data){
        if($this->db->insert($this->table_deposit_bonus, $data)){
            return true;
        }else{
            return false;
        }
    }

    public function getCardNumberByStatus($account_num,$status){
        $this->db->select('*');
        $this->db->from('card_documents');
        $this->db->where('account_number', $account_num);
        $this->db->where('status <', $status);
        $this->db->where('is_deleted', 0);
        $this->db->where('create_date >', '2020-05-27');
        $this->db->group_by('card_number');
        $this->db->order_by('create_date','desc');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }else{
            return false;
        }
    }
    public function isPayomaUser($user_id){
        $this->db->select('*');
        $this->db->from('deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('transaction_type', 'PAYOMA');
        $this->db->where('payment_date <', '2020-12-12');
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }


    public function isZotapayUser($user_id){
        $this->db->select('*');
        $this->db->from('deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->where('transaction_type', 'ZOTAPAY_CARD');
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function isPaymentMethodAvailable($user_id,$trans_type){
        $this->db->select('*');
        $this->db->from('deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('transaction_type', $trans_type);
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }


    public function isPayomaUserV2($user_id){
        $this->db->select('*');
        $this->db->from('deposit');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->where('transaction_type', 'PAYOMA');
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }
    
    
    function getRowData($tablee,$field,$filed_val){
        $this->db->from($tablee);
        $this->db->where($field, $filed_val);  
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row();
        }else{
            return false;
        }
    }


    public function getAccountSaldo($accounts,$date_from,$date_to){
        $tnxListDeposit = FXPP::getTnxType(1);
        $tnxListWithdraw = FXPP::getTnxType(2);
        if(count($tnxListDeposit) > 0){
            $impTnxDList = "'" . implode( "','", ($tnxListDeposit) ) . "'";
            $sql_d_tnxList = 'AND UPPER(deposit.transaction_type) IN ('. $impTnxDList .')';
        }
        
        if(count($tnxListWithdraw) > 0){
            $impTnxWList = "'" . implode( "','", ($tnxListWithdraw) ) . "'";
            $sql_w_tnxList = 'AND UPPER(withdraw.transaction_type) IN ('. $impTnxWList .')';
        }
        
        
        $sql_d = 'WHERE (mt_accounts_set.account_number IN (' . implode(',', $accounts) . ') OR partnership.reference_num IN (' . implode(',', $accounts) . '))';
        $sql_w = 'WHERE  withdraw.account_number IN (' . implode(',', $accounts) . ')';

        $sql = "SELECT net_saldo.account_number,SUM(net_saldo.amount_deposit - net_saldo.amount_withdraw) as saldo_amount FROM (
								  SELECT case when users.login_type = 1 then partnership.reference_num else mt_accounts_set.account_number end account_number, case when users.micro = 1 then SUM(deposit.conv_amount/100) else SUM(deposit.conv_amount) end amount_deposit, 0 as amount_withdraw
									FROM deposit
									INNER JOIN users ON users.id = deposit.user_id
									LEFT JOIN mt_accounts_set ON mt_accounts_set.user_id = deposit.user_id
									LEFT JOIN partnership ON partnership.partner_id = deposit.user_id							 		                                  
									$sql_d
							        $sql_d_tnxList
									AND deposit.status = 2 
									AND deposit.isDeposit = 0							  																
									AND (deposit.payment_date >= '" . date('Y-m-d 00:00:00', strtotime($date_from)) . "' AND deposit.payment_date <= '" . date('Y-m-d 23:59:59', strtotime($date_to)) . "')
                                    GROUP BY  account_number
                                    UNION ALL
									SELECT withdraw.account_number,0 as amount_deposit, case when users.micro = 1 then  sum(withdraw.conv_amount/100) else sum(withdraw.conv_amount) end amount_withdraw
									from withdraw							  
									INNER JOIN users on users.id = withdraw.user_id
									INNER JOIN user_profiles on user_profiles.user_id = withdraw.user_id						  
									$sql_w
									$sql_w_tnxList
									AND withdraw.status IN (0,1)
									AND (withdraw.date_withdraw >= '" . date('Y-m-d 00:00:00', strtotime($date_from)) . "' AND withdraw.date_withdraw <= '" . date('Y-m-d 23:59:59', strtotime($date_to)) . "')       
									AND withdraw.is_dashboard_enabled  = 1
									AND CHAR_LENGTH(withdraw.account_number) > 4 							  
									GROUP BY account_number) net_saldo										  
									GROUP BY net_saldo.account_number";

        $query = $this->db->query($sql);



        if($query->num_rows() > 0){


            return $query->result_array();
        }else{
            return false;
        }
    }


    public function getTransitTransferByDate($accounts,$date_from,$date_to){
        $sql_s = 'AND sender IN (' . implode(',', $accounts) . ')';
        $sql_r = 'AND receiver IN (' . implode(',', $accounts) . ')';


        $sql = "SELECT net_saldo.account_number,SUM(net_saldo.amount_deposit - net_saldo.amount_withdraw) as saldo_amount FROM (
                 SELECT conv_amount as amount_deposit,0 as amount_withdraw,receiver as account_number
                FROM transit_transfer
                WHERE transit_transfer.status IN (2,6)
                $sql_r
                AND (date_transfer >= '" . date('Y-m-d 00:00:00', strtotime($date_from)) . "' AND date_transfer <= '" . date('Y-m-d 23:59:59', strtotime($date_to)) . "')
                GROUP BY account_number
                UNION ALL
                SELECT 0  as amount_deposit,conv_amount as amount_withdraw, sender as account_number
                FROM transit_transfer
                WHERE transit_transfer.status IN (2,6)
                $sql_s
                AND (date_transfer >= '" . date('Y-m-d 00:00:00', strtotime($date_from)) . "' AND date_transfer <= '" . date('Y-m-d 23:59:59', strtotime($date_to)) . "')
                GROUP BY account_number
                ) net_saldo
                 GROUP BY net_saldo.account_number
             ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getAccountDepositCount( $user_id,$card_number,$date_from, $date_to){
        $this->db->select('deposit.payment_date,deposit.amount,deposit.transaction_type');
        $this->db->from($this->table);
        $this->db->join('nova2pay', 'nova2pay.order_id = deposit.reference_id');
         $this->db->where('deposit.payment_date >=', date('Y-m-d 00:00:00', strtotime($date_from)));
        $this->db->where('deposit.payment_date <=', date('Y-m-d 23:59:59', strtotime($date_to)));
        $this->db->where('deposit.user_id', $user_id);
        $this->db->where('nova2pay.card_number', $card_number);
        $this->db->where('deposit.status', 2);
        $this->db->where('deposit.transaction_type', 'NOVA2PAY');
        $this->db->group_by('deposit.transaction_id, deposit.reference_id');
        $this->db->order_by('deposit.payment_date');
        $count = $this->db->count_all_results();
        return $count;
    }

}