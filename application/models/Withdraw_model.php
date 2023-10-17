<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw_model extends CI_Model
{
    private $transaction_type = array(
        'BT' => 'bank_transfer',
        'NT' => 'neteller',
        'SK' => 'skrill',
        'CC' => 'credit_card',
        'MTC' => 'megatransfer_card',
        'UP' => 'unionpay',
        'WM' => 'webmoney',
        'PX' => 'paxum',
        'UK' => 'ukash',
        'PC' => 'payco',
        'FP' => 'filspay',
        'CU' => 'cashu',
        'PP' => 'paypal',
        'QW' => 'qiwi',
        'MT' => 'megatransfer',
        'BC' => 'bitcoin',
        'MN' => 'moneta_withdrawal',
//        'SF' => 'sofort_withdrawal',
        'SF' => 'sofort_bank_withdrawal',
        'YAN' => 'yandex',
        'FASA' => 'fasapay_withdraw',
        'EPAY' => 'emerchantpay_withdraw',
        'CUP' => 'chinaunionpay',
        'PAYOMA'=>'payoma_card_info',
        'INPAY'=>'inpay_withdraw',
        'ALIPAY'=>'alipay_withdrawl',
        'BANK_MYR'=>'paytrust_withdrawl',
        'BANK_THB'=>'paytrust_withdrawl',
        'BANK_VND'=>'paytrust_withdrawl',
        'BANK_IDR'=>'paytrust_withdrawl',
        'BANK_NGN'=>'bank_details_withdraw',
        'ZOTAPAY_MYR'=>'zotapay_withdraw',
        'ZOTAPAY_THB'=>'zotapay_withdraw',
        'ZOTAPAY_VND'=>'zotapay_withdraw',
        'ZOTAPAY_IDR'=>'zotapay_withdraw',
        'ZOTAPAY_CARD'=>'credit_card',
        'NOVA2PAY'=>'credit_card',
        'ASIA_VND'=>'bank_details_withdraw',
    );
    private $table = 'withdraw';
    private $bonus = 'withdraw_bonus';

    function __construct()
    {
        parent::__construct();
    }

    public function insertWithdraw( $data = array() ){
        if($this->db->insert('withdraw', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function insertWithdrawBonus( $data = array() ){
        if($this->db->insert('withdraw_bonus', $data)){
            return $this->db->insert_id();
        }else{
            return false;
            
        }
    }

    public function insertBankTransfer( $data = array() ){
        if($this->db->insert('bank_transfer', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function counterpartTransaction($tranTable, $data = array()){
        if($this->db->insert($tranTable, $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function insertNeteller( $data = array() ){
        if($this->db->insert('neteller', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function getWithdrawBankTransferById($id){
        $this->db->from('withdraw');
        $this->db->join('bank_transfer', 'bank_transfer.id = withdraw.transaction_id', 'inner');
        $this->db->where('withdraw.id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getWithdrawNetellerById($id){
        $this->db->from('withdraw');
        $this->db->join('neteller', 'neteller.id = withdraw.transaction_id', 'inner');
        $this->db->where('withdraw.id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function insertWithdrawByTranType( $trantype = '', $data = array() ){
        $table_name = $this->transaction_type[strtoupper($trantype)];
        if($this->db->insert($table_name, $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function getWithdrawById($id, $trantype = ''){
        $table_name = $this->transaction_type[strtoupper($trantype)];
        $this->db->from('withdraw');
        $this->db->join($table_name, $table_name . '.id = withdraw.transaction_id', 'inner');

        $this->db->where('withdraw.id', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->row_array();
        }else{
            return false;
        }
    }

    public function getWithdrawalTransactionByTicket($ticket){
        $this->db->select('*')
            ->from('withdraw')
            ->where('reference_number', $ticket)
            ->or_where('decline_reference_number', $ticket);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    
    
       public function getWithdrawalTransactionByTicketV2($ticket){
        $this->db->select('*')
            ->from('withdraw')
            ->where('reference_number', $ticket)
            ->or_where('decline_reference_number', $ticket);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row();
        }else{
            return false;
        }
    }

  public function getWithdrawalTransitTransactionByTicket($ticketNumber,$transaction_referral_id){

        $sql = 'SELECT * FROM  transit_transfer where note like "%?%" or transaction_id="?" or referral_id="?"';
        $query = $this->db->query($sql, array($ticketNumber,$transaction_referral_id,$transaction_referral_id));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }


    }

    public function getRequestFundTransactionStatus($transaction_id){
        $this->db->select('*')
            ->from('transit_transfer')
            ->where('transaction_id', $transaction_id)
            ->where('status', 2);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }


    public function getRequestFundTransactionByTransactionID($transaction_id){
        $this->db->select('*')
            ->from('transit_transfer')
            ->where('transaction_id', $transaction_id)
            ->or_where('decline_ref_number', $transaction_id);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getRequestFundTransactionByTransactionIDStat($transaction_id){
        $this->db->select('*')
            ->from('transit_transfer')
            ->where('transaction_id', $transaction_id)
            ->where('status', 6);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getRequestDeclineFundTransaction($transaction_id){
        $this->db->select('*')
            ->from('transit_transfer')
            ->where('decline_ref_number', $transaction_id)
            ->where('status', 5);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getWithdrawalTransactionByDeclineTicket($ticket){
        $this->db->select('*')
            ->from('withdraw')
            ->where('decline_reference_number', $ticket);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function updateWithdrawalDetails($ticket, $data){
        $this->db->where('reference_number', $ticket);
        $this->db->update('withdraw', $data);
    }

    public function getAllPendingDepositBonus($user_id){
        $this->db->select()
            ->from('deposit')
            ->where('user_id', $user_id)
            ->where('thirtypercentbonus', 0)
            ->where('fiftypercentbonus', 0);
        $queryResult = $this->db->get();
        return ($queryResult->num_rows() > 0) ? $queryResult->result_array() : false;
    }

    public function removePendingDepositBonus($data, $conditions){
        $this->db->update('deposit', $data, $conditions);
    }

    //fxpp-6461
    function CountAllWithdrawalTransaction($statusId,$user_id){
        $this->db->select('count(*) as Count')
            ->from('withdraw')
            ->join('user_profiles', 'user_profiles.user_id = withdraw.user_id', 'inner')
            ->where_in('withdraw.status',$statusId)
            ->where_in('withdraw.user_id',$user_id);
        $result = $this->db->get();

        return $result->row_array();
    }


    function CountAllRequestTransitTransferTransaction($statusId,$account_number){
        $this->db->select('count(*) as Count')
            ->from('transit_transfer')
            ->where_in('transit_transfer.status',$statusId)
            ->where_in('transit_transfer.receiver',$account_number);
        $result = $this->db->get();

        return $result->row_array();
    }
    function GetAllWithdrawalTransaction($statusId,$offset, $limit,$user_id){

        $this->db->select('*, withdraw.Id as wId')
            ->from('withdraw')
            ->join('user_profiles', 'user_profiles.user_id = withdraw.user_id', 'inner')
            ->where_in('withdraw.status', $statusId)
            ->where_in('withdraw.user_id',$user_id)
            ->order_by('withdraw.date_withdraw', 'DESC')
            ->limit($limit,$offset);

        $result = $this->db->get();

        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }
    function GetAllRequestTransitTransferTransaction($statusId,$offset, $limit,$account_number){

        $this->db->select('*, transit_transfer.Id as wId')
            ->from('transit_transfer')
            ->where_in('transit_transfer.status', $statusId)
            ->where_in('transit_transfer.receiver',$account_number)
            ->order_by('transit_transfer.date_transfer', 'DESC')
            ->limit($limit,$offset);

        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : false;
    }

    function hasCancelledNDBbonus($user_id)
    {

            $this->db->select('*')
                ->from('withdraw_bonus')
                ->where('User_id', $user_id)
                ->where('Bonus_id', 2);
            $result = $this->db->get();
            if ($result->num_rows() > 0) {
                return true;
            } else {
                return false;
            }

    }

    function getWithdrawBonusDate( $account_number,$fund ){
        $this->db->from('withdraw_bonus');
        $this->db->where('Account_number', $account_number);
        $this->db->where('Is_realfund',$fund);
        $this->db->where('Bonus_id', 2);
        $this->db->where('Amount !=',0);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->row_array();
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

    public function insertWithdrawBonusProfit($data){
        if($this->db->insert('bonus_profit', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function getBonusProfitDetails($account){
        $this->db->select('*')
            ->from('bonus_profit')
            ->where('Account_number', $account);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }

    public function getRecalledStatus($reNum){
        $this->db->select('recall');
        $this->db->from('withdraw');
        $this->db->where('reference_number', $reNum);

        $result = $this->db->get();
        if($result->num_rows() > 0){
            $row = $result->row();

            if($row->recall == 0){
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
    public function GetWithdrawalDetails($ticket){
        $this->db->select('*')
            ->from('withdraw')
            ->where('reference_number', $ticket);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }
    public function getWithdrawalRequestClient($transId){
        $this->db->select('withdraw.*, user_profiles.full_name, users.email,user_profiles.country')
            ->from('withdraw')
            ->join('user_profiles', 'user_profiles.user_id = withdraw.user_id', 'left')
            ->join('users', 'users.id = withdraw.user_id', 'left')
            ->where('withdraw.id', $transId)
            ->where('withdraw.status', 0);

        $result = $this->db->get();

        return ($result->num_rows() > 0) ? $result->row_array() : false;
    }
    public function processTransactionRequest($transId, $data){
        $this->db->where('id',$transId);
        $this->db->update('withdraw',$data);
        return $this->db->affected_rows();
    }
    public function updateInviteFriend($amt,$user_id,$deposit_id){
        $sql = "update invite_friends 	set withdraw = withdraw - ? where user_id=? and withdraw_id=?";
        $query = $this->db->query($sql, array($amt,$user_id,$deposit_id));
        if ($query->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    public function getWithdrawBonusByTransId($wTransId){
        $this->db->from('withdraw_bonus');
        $this->db->where('Transaction_id', $wTransId);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }
    public function updateBonus($wTransId, $bTicket){
        $data = array(
            'Credit_bonus_ticket' => $bTicket
        );
        $this->db->where('Id', $wTransId);
        $this->db->update('withdraw_bonus', $data);
    }
    public function updateAccountBalance( $account_number, $amount ){
        $data = array(
            'amount' => $amount
        );
        $this->db->where('account_number', $account_number);
        if ($this->db->update('mt_accounts_set', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function updateConvertedAmountById( $id, $amount ){
        $data = array(
            'conv_amount' => $amount
        );
        $this->db->where('id', $id);
        $this->db->update('withdraw', $data);
    }
    public function getWithdrawById_recall( $id ){
        $this->db->from('withdraw');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }



    public function IsPayomaUser($userId){
        $this->db->select('*')
            ->from('withdraw')
            ->where('user_id', $userId)
            ->where('transaction_type', 'PAYOMA');
        $result = $this->db->get();

        return ($result->num_rows() > 0) ? true : false;
    }


    public function isZotapayUser($user_id){
        $this->db->select('*');
        $this->db->from('withdraw');
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

}