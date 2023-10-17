<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partners_model extends CI_Model
{
    private $tb_partnerhip = 'partnership';
    private $tb_partnerhip_affiliate_code = 'partnership_affiliate_code';
    private $tb_users = 'users';
    private $tb_profiles = 'user_profiles';

    function getReferralsbyAffiliateCode($affiliateCode)
    {
        $this->db->select('*');
        $this->db->from($this->tb_users);
        $this->db->join($this->tb_profiles, 'users.id = user_profiles.user_id');
        $this->db->where('affiliate_code', $affiliateCode);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $query->num_rows();
            $data['rtn'] = true;
        } else {
            $data['rtn'] = false;
        }
        return $data;
    }

    function getAffiliateCodeById($user_id)
    {
        /* $this->db->select('affiliate_code');
         $this->db->from($this->tb_partnerhip_affiliate_code);
         $this->db->where('partner_id', $user_id);
         $query = $this->db->get();*/
        $sql = "SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? ";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function checkCustomAffiliateCode($code)
    {
        $query = 'SELECT * FROM
                    (
                      SELECT affiliate_code FROM users_affiliate_code AS uac
	                  UNION
	                  SELECT affiliate_code FROM partnership_affiliate_code AS pac
                    ) as sac WHERE affiliate_code = ?;
        ';

        $result = $this->db->query( $query, array($code) );
        return ($result->num_rows() > 0) ? false : true;
    }

    public function getPartnersAffiliatesCode($partnersId)
    {
        /* $this->db->select('*');
         $this->db->from($this->tb_partnerhip_affiliate_code);
         $this->db->where('partner_id', $partnersId);
         $this->db->order_by('date_created', 'DESC');
         $query = $this->db->get();*/
        $sql = "SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? ";

        $query = $this->db->query($sql, array($partnersId, $partnersId));
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $query->num_rows();
            $data['rtn'] = true;
        } else {
            $data['rtn'] = false;
        }
        return $data;
    }

    function getDefaultAffiliateCodeById($user_id)
    {
        $this->db->select('affiliate_code');
        $this->db->from('users_affiliate_code');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getClick($user_id)
    {
        $sql = "SELECT count(affiliate_code) as num , date(`date`) as `date` from click where affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ?  ) group by date(`date`) ";

        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function countClicksByAffiliateCode($affiliate_code, $to, $from){

        $where = array();

        $query = "SELECT count(affiliate_code) as count FROM click";

        if(!empty($affiliate_code)){
            $where[] = '`affiliate_code` =  "' . $affiliate_code . '"';
        }
        if(!empty($to) AND !empty($from)){
            $where[] = '`date` BETWEEN " ' . $from . ' " AND " ' .$to. ' "';
        }

        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";
        $query .= $whereClause;

        $result = $this->db->query($query);

        if($result->num_rows() > 0 ){
            return $result->row_array();
        }
        return false;

    }

    function getClickByCode($code)
    {
        $sql = "SELECT count(affiliate_code) as num , date(`date`) as `date` from click where affiliate_code  = ? group by date(`date`) ";

        $query = $this->db->query($sql, array($code));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getAllClickByCode($code,$date_from, $date_to)
    {
        $sql = "SELECT count(affiliate_code) as num , date(`date`) as `date` from click where affiliate_code  = ? AND DATE(`date`) BETWEEN ? AND ? group by date(`date`) ";

        $query = $this->db->query($sql, array($code,$date_from, $date_to));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getClickAndRegisterAc($user_id)
    {

        $sql = "
select sum(num) num,sum(acnum) acnum,`date` from (
SELECT count(affiliate_code) as num ,0 as acnum,  date(`date`) as date from click where affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ?  ) group by date(`date`)
union all
select  0 as num, count(affiliate_code) as acnum, date(date_created) `date` from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? ) group by date(`date_created`)
) t group by t.date";
    }

    function getClickAndRegisterAcByCode($code,$date_from,$date_to)
    {

        $sql = "
select sum(num) num,sum(acnum) acnum,`date` from (
SELECT count(affiliate_code) as num ,0 as acnum,  date(`date`) as date from click where affiliate_code = ? group by date(`date`)
union all
select  0 as num, count(affiliate_code) as acnum, date(date_created) `date` from users_affiliate_code where referral_affiliate_code = ? group by date(`date_created`)
) t where t.date between ? and ? group by t.date";


        $query = $this->db->query($sql, array($code, $code,$date_from,$date_to));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getReferral($user_id)
    {
        // $sql = "select t.date_created,up.full_name,up.user_id from user_profiles up inner join (select * from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )) t on t.users_id = up.user_id ";
        $sql = "select mas.account_number,mas.registration_time from users_affiliate_code uac inner join (
SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ?
)t on uac.referral_affiliate_code=t.affiliate_code inner join mt_accounts_set mas on uac.users_id= mas.user_id group by mas.user_id order by mas.registration_time desc
";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getReferralsNDB($user_id, $nodeposit='')
    {
        // $sql = "select t.date_created,up.full_name,up.user_id from user_profiles up inner join (select * from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )) t on t.users_id = up.user_id ";
        $sql = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus from users_affiliate_code uac inner join (
            SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ?
            )t on uac.referral_affiliate_code=t.affiliate_code inner join mt_accounts_set mas on uac.users_id= mas.user_id left join users on users.id = mas.user_id
            group by mas.user_id order by mas.registration_time desc
        ";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getRegisteredAcc($user_id)
    {

        // $sql = "select  0 as num, count(affiliate_code) as acnum,UNIX_TIMESTAMP(date(`date_created`)) as `date` from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ?				union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )group by date(`date_created`)";
        $sql = "select 0 as num, count(uac.affiliate_code) as acnum,date(uac.date_created) as `date` from users_affiliate_code uac inner join (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )t
on uac.referral_affiliate_code=t.affiliate_code group by date(uac.date_created)
";
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getPartnersByUserId($user_id)
    {
        $this->db->from($this->tb_partnerhip);
        $this->db->where('partner_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $data = $this->db->get();
        return $data->result_array();
    }

    function getAccountRebate($account)
    {   
        $this->db->select('*');
        $this->db->from('custom_rebate_value');
        $this->db->where('account_number', $account);
        $this->db->limit('1');
        $data = $this->db->get();
        return $data->row_array();
    }

    function getPartnershipAgreementStatus($user_id)
    {
        $this->db->from($this->tb_partnerhip);
        $this->db->where('partner_id', $user_id);
        $this->db->limit('1');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        }

        return false;
    }

    function getCpaPartnership($type = 0, $user_id)
    {

        $this->db->select("p.dateregistered,p.partner_id,p.amount,up.full_name");
        $this->db->from('partnership p');
        $this->db->join('user_profiles up', ' p.partner_id = up.user_id');
        $this->db->where('p.type_of_partnership', "cpa");
        $this->db->where('p.status_type', $type);
        $this->db->where('up.user_id', $user_id);
        $this->db->order_by('p.dateregistered', 'desc');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }

    function getCpaReferralDepositList($user_id)
    {
        $this->db->select('mt_accounts_set.account_number, mt_accounts_set.registration_time, sum(deposit.amount) as amount');
        $this->db->from('partnership');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'inner');
        $this->db->join('users_affiliate_code', 'users_affiliate_code.referral_affiliate_code = partnership_affiliate_code.affiliate_code', 'inner');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'inner');
        $this->db->join('deposit', 'deposit.status = 2 and deposit.user_id = mt_accounts_set.user_id', 'inner');
        $this->db->where('partnership.partner_id', $user_id);
        $this->db->where('partnership.type_of_partnership', 'cpa');
        $this->db->group_by('mt_accounts_set.account_number, mt_accounts_set.registration_time, deposit.cpa_amount, deposit.transaction_id, deposit.reference_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getCpaClientList($user_id, $type)
    {


        //$sql = "select count(*) as approv_deposite, mt.account_number,mt.registration_time,d.amount from mt_accounts_set mt inner join deposit d on mt.user_id= d.user_id  inner join users_affiliate_code uac on uac.users_id=mt.user_id inner join( SELECT affiliate_code from partnership_affiliate_code where partner_id = ?) ac on ac.affiliate_code = uac.referral_affiliate_code group by mt.account_number order by d.payment_date asc";
        /*
        $sql = "select count(*) approv_deposite,mt.user_id, ac.partner_id, mt.account_number,mt.registration_time,d.amount from mt_accounts_set mt inner join deposit d on mt.user_id= d.user_id  inner join users_affiliate_code uac on uac.users_id=mt.user_id inner join

(SELECT pac.affiliate_code,p.partner_id from partnership p inner join partnership_affiliate_code pac on p.partner_id=pac.partner_id where pac.partner_id=? and  p.type_of_partnership='cpa' and p.status_type=? ) ac on ac.affiliate_code = uac.referral_affiliate_code
 group by mt.user_id";
        $query = $this->db->query($sql, array($user_id, $type));
        */

        if(IPLoc::Office()){
            $this->db->select('mt_accounts_set.account_number, mt_accounts_set.registration_time, users.micro, SUM(deposit.amount) as amount, deposit.cpa_amount,mt_accounts_set.mt_currency_base');
        }else{
            $this->db->select('mt_accounts_set.account_number, mt_accounts_set.registration_time,case when users.micro = 1 then SUM(deposit.amount/100) else SUM(deposit.amount) end amount , deposit.cpa_amount,mt_accounts_set.mt_currency_base');
        }

        $this->db->from('partnership');
        $this->db->join('users', 'users.id = partnership.partner_id', 'inner');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'inner');
        $this->db->join('users_affiliate_code', 'users_affiliate_code.referral_affiliate_code = partnership_affiliate_code.affiliate_code', 'inner');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'inner');
        $this->db->join('deposit', 'deposit.status = 2 and deposit.user_id = mt_accounts_set.user_id', 'inner');
        $this->db->where('partnership.partner_id', $user_id);
        $this->db->where('partnership.type_of_partnership', 'cpa');
        $this->db->where('deposit.cpa', $type);
        $this->db->where('deposit.payment_date', '(select min(payment_date)
                                                   from deposit deposit2
                                                   where deposit2.status = 2
                                                   and deposit2.user_id = deposit.user_id)', false);
        $this->db->group_by('mt_accounts_set.account_number, mt_accounts_set.registration_time, deposit.cpa_amount, deposit.transaction_id, deposit.reference_id');
        $query = $this->db->get();

       // echo "<pre></pre>"; echo  $this->db->last_query();exit();


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getCpaTotalRegisterAcc($user_id)
    {
/*
        $sql = "select count(mt.user_id) registerAcc from mt_accounts_set mt  inner join users_affiliate_code uac on uac.users_id=mt.user_id inner join  (SELECT pac.affiliate_code,p.partner_id from partnership p inner join partnership_affiliate_code pac on p.partner_id=pac.partner_id where pac.partner_id=? and  p.type_of_partnership='cpa' ) ac on ac.affiliate_code = uac.referral_affiliate_code";

        $query = $this->db->query($sql, array($user_id));
*/
        $this->db->distinct();
        $this->db->select('mt_accounts_set.account_number');
        $this->db->from('partnership');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'inner');
        $this->db->join('users_affiliate_code', 'users_affiliate_code.referral_affiliate_code = partnership_affiliate_code.affiliate_code', 'inner');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'inner');
        $this->db->where('partnership.partner_id', $user_id);
        $this->db->where('partnership.type_of_partnership', 'cpa');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function isCPA($user_id)
    {
        $this->db->from($this->tb_partnerhip);
        $this->db->where('partner_id', $user_id);
        $this->db->where('type_of_partnership', 'cpa');
        $this->db->limit('1');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        }

        return false;
    }
    function isCPAbyAccount($accountNumber)
    {
        $this->db->from($this->tb_partnerhip);
        $this->db->where('reference_num', $accountNumber);
        $this->db->where('type_of_partnership', 'cpa');
        $this->db->limit('1');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        }

        return false;
    }

    function getPartnershipType($user_id,$type){
        $this->db->from($this->tb_partnerhip);
        $this->db->where('partner_id', $user_id);
        $this->db->where('type_of_partnership',$type);
        $this->db->limit('1');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row()->type_of_partnership;
        }

        return false;
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
                $this->db->from($this->tb_partnerhip);
                $this->db->where('partnership.partner_id', $user_id);
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

    public function getAccountByUserId( $user_id ){
        $this->db->from($this->tb_partnerhip);
        $this->db->where('partner_id', $user_id);
        $this->db->limit(1);
        $result = $this->db->get();
        if($result->num_rows() > 0){
            return $result->row_array();
        }else{
            return false;
        }
    }


    public function getRebateProject($user_id){
        $this->db->from('rebate_system');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        }

        return false;
    }
    public function getRebateAccountList($user_id){
        $this->db->from('personal_rebate');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        }

        return false;
    }

    public function getExtraCommissionList($user_id){

        $sql = "select IFNULL(ecs.status, 0) extra,d.id, mt.registration_time,up.full_name,mt.account_number,d.amount,p.reference_num,cp.full_name partner,d.status from partnership p
inner join partnership_affiliate_code pac on p.partner_id = pac.partner_id
inner join users_affiliate_code ua on ua.referral_affiliate_code = pac.affiliate_code
left join deposit d on d.user_id=ua.users_id
left join user_profiles up on up.user_id=ua.users_id
left join mt_accounts_set mt on mt.user_id= ua.users_id
left join user_profiles cp on cp.user_id=p.partner_id
left join extra_commission_status ecs on d.id=ecs.deposit_id
where p.type_of_partnership='extra_commission' and p.partner_id=?

        ";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPartnerInfo($user_id){
        $this->db->select("p.reference_num,p.partner_id,u.email,up.full_name,c.phone1,up.dob,up.street,up.city,up.country,up.state,up.zip,u.last_ip");
        $this->db->from('partnership p');
        $this->db->join('user_profiles up', ' p.partner_id = up.user_id','left');
        $this->db->join('users u', ' u.id = up.user_id');
        $this->db->join('contacts c', 'c.user_id = u.id','left');
        $this->db->where('p.partner_id', $user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getCPAReferenceSub( $user_id ){
        $this->db->select('p2.*');
        $this->db->from('partnership p1');
        $this->db->join('partnership p2', 'p1.reference_num = p2.reference_subnum', 'inner');
        $this->db->where('p1.partner_id', $user_id);
        $query = $this->db->get();

        //echo "<pre></pre>";echo $this->db->last_query();exit();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    public function getCPAReferenceSubByAccount( $accountNumber ){
        $this->db->select('p2.*');
        $this->db->from('partnership p1');
        $this->db->join('partnership p2', 'p1.reference_num = p2.reference_subnum', 'inner');
        $this->db->where('p1.reference_num', $accountNumber);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function countReferrals($user_id){
        $sql = "select count(*) as count from  users_affiliate_code as uac left join (SELECT affiliate_code as ref_affiliate_code, users_id as uid from users_affiliate_code union all SELECT affiliate_code as ref_affiliate_code, partner_id from partnership_affiliate_code as pac) as t
                  on uac.referral_affiliate_code=t.ref_affiliate_code where t.uid = ?";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

    public function getReferralsNew($user_id, $numberofReferrals){
//        $sql = "select * from (SELECT affiliate_code, users_id as uid from users_affiliate_code where users_id = ? union all SELECT affiliate_code, partner_id from partnership_affiliate_code as pac where partner_id = ?) as t
//                  left join users_affiliate_code as uac on t.affiliate_code = uac.referral_affiliate_code";

        $sql = "select * from  users_affiliate_code as uac left join (SELECT affiliate_code as ref_affiliate_code, users_id as uid from users_affiliate_code union all SELECT affiliate_code as ref_affiliate_code, partner_id from partnership_affiliate_code as pac) as t
                  on uac.referral_affiliate_code=t.ref_affiliate_code where t.uid = ? limit 1500, 500";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function getReferrals($user_id)
    {
        $data = array(
            'result' => null,
            'count' => 0
        );

        // $sql = "select t.date_created,up.full_name,up.user_id from user_profiles up inner join (select * from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )) t on t.users_id = up.user_id ";
        $sql = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus from users_affiliate_code uac inner join (
            SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ?
            )t on uac.referral_affiliate_code=t.affiliate_code inner join mt_accounts_set mas on uac.users_id= mas.user_id left join users on users.id = mas.user_id
            group by mas.user_id order by mas.registration_time
        ";
        $query = $this->db->query($sql, array($user_id, $user_id));

        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $query->num_rows();
        }

        return $data;
    }

    public function getReferralList($user_id)
    {

        $data = array(
            'result' => null,
            'count' => 0
        );

        $this->db->select('*')
            ->from('referrals')
            ->where('User_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $query->num_rows();
        }

        return $data;
    }

    public function getReferralDetails($user_id, $account_number){
        $this->db->select('*')
            ->from('referrals')
            ->where('User_id', $user_id)
            ->where('Account_number', $account_number);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getAllClickAndRegisterAcByCode($code,$from,$to, $offset, $limit)
    {

        $sql = "

        select * from(
            select sum(num) num,sum(acnum) acnum,`date` from (
            SELECT count(affiliate_code) as num ,0 as acnum,  date(`date`) as date from click where affiliate_code = ? group by date(`date`)
            union all
            select  0 as num, count(affiliate_code) as acnum, date(date_created) `date` from users_affiliate_code where referral_affiliate_code = ? group by date(`date_created`)
            ) t
          where DATE(t.date) BETWEEN ? AND ? group by t.date Order by `date` DESC) r  where r.num > 0  LIMIT ?, ?";


        $query = $this->db->query($sql, array($code, $code, $from, $to, $offset, $limit));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function getCountAllClickAndRegisterAcByCode($code,$from,$to)
    {

        $sql = "
        select * from(
        select sum(num) num,sum(acnum) acnum,`date` from (
        SELECT count(affiliate_code) as num ,0 as acnum,  date(`date`) as date from click where affiliate_code = ? group by date(`date`)
        union all
        select  0 as num, count(affiliate_code) as acnum, date(date_created) `date` from users_affiliate_code where referral_affiliate_code = ? group by date(`date_created`)
        ) t where DATE(t.date) BETWEEN ? AND ? group by t.date) r where r.num > 0 ";


        $query = $this->db->query($sql, array($code, $code, $from, $to));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getAllReferrals($postData){
//        $this->db->select('*')
//            ->from('referrals')
//            ->where('User_id', $user_id)
//            ->where('Status', $status)
//            ->limit($limit, $offset);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        }
//        return false;

        if( empty( $postData ) ) {
            return array();
        }

        $where = array();
        $query = "SELECT * FROM referrals";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "User_id = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['status']) && !empty($postData['status'])){
            $statusD[] = "Status = '".$postData['status']."'";
            $where[] = implode( " OR ", $statusD );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "DATE(Registration_time) BETWEEN '".$postData['date_from']."' AND '".$postData['date_to']."'";
            $where[] = implode( " OR ", $date );
        }

        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";

        $query .= $whereClause . " ORDER BY `Registration_time` LIMIT ".$postData['offset'].", ".$postData['limit']."";
        $result = $this->db->query( $query );
        if( is_object( $result ) ) {
            return $result->result_array();
        }

    }

    public function getAllPartnershipReferrals($postData){
        if( empty( $postData ) ) {
            return array();
        }

        /*to prevent injection.*/ 
        $date_from = $this->db->escape($postData['date_from']);
        $date_to = $this->db->escape($postData['date_to']);
        $limit = (int)$this->db->escape( $postData['limit']);
        $offset = (int)$this->db->escape($postData['offset']);

        /*End*/

        $where = array();
//        $query = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus  from (SELECT affiliate_code,  users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
//                  left join users_affiliate_code uac
//                  on uac.referral_affiliate_code=t.affiliate_code
//                  left join  mt_accounts_set mas on uac.users_id= mas.user_id left join users on users.id = mas.user_id
//                  left join users u on u.id = mas.user_id";

        $query = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus,users.accountstatus from users_affiliate_code uac
                  left join
	                (SELECT affiliate_code, users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
                    on uac.referral_affiliate_code=t.affiliate_code
                  left join  mt_accounts_set mas
                    on uac.users_id= mas.user_id
                  left join users
                    on users.id = mas.user_id";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "t.userid = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "DATE(registration_time) BETWEEN $date_from  AND $date_to";
            $where[] = implode( " OR ", $date );
        }
        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";

        $query .= $whereClause . " ORDER BY `registration_time` DESC LIMIT $offset, $limit";

        $result = $this->db->query( $query );
        if( is_object( $result ) ) {
            return $result->result_array();
        }
        return false;
    }

    public function countAllPartnershipReferrals($postData){
        if( empty( $postData ) ) {
            return array();
        }

        /*to prevent injection.*/

        $date_from = $this->db->escape($postData['date_from']);
        $date_to = $this->db->escape($postData['date_to']);

            /*End*/
        $where = array();
        $query = "select count(*) as count from users_affiliate_code uac
                  left join
	                (SELECT affiliate_code,  users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
                    on uac.referral_affiliate_code=t.affiliate_code
                  left join  mt_accounts_set mas
                    on uac.users_id= mas.user_id
                  left join users
                    on users.id = mas.user_id";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "t.userid = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "DATE(registration_time) BETWEEN $date_from AND $date_to";
            $where[] = implode( " OR ", $date );
        }
        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";

        $query .= $whereClause . " order by mas.registration_time";

//        if(IPLoc::Office()){
//            echo $query;exit;
//        }

        $result = $this->db->query( $query );
        if( is_object( $result ) ) {
            return $result->row_array();
        }
    }

    public function countAllReferrals($postData){

        if( empty( $postData ) ) {
            return array();
        }

        $where = array();
        $query = "SELECT count(*) as count FROM referrals";

        if(isset($postData['user_id']) && !empty($postData['user_id'])){
            $userid[] = "User_id = '".$postData['user_id']."'";
            $where[] = implode( " OR ", $userid );
        }

        if(isset($postData['status']) && !empty($postData['status'])){
            $statusD[] = "Status = '".$postData['status']."'";
            $where[] = implode( " OR ", $statusD );
        }

        if(isset($postData['date_from']) && !empty($postData['date_from'])){
            $date[] = "DATE(Registration_time) BETWEEN '".$postData['date_from']."' AND '".$postData['date_to']."'";
            $where[] = implode( " OR ", $date );
        }

        $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";

        $query .= $whereClause . " ORDER BY `Registration_time`";

//        var_dump($query);exit;

        $result = $this->db->query( $query );
        if( is_object( $result ) ) {
            return $result->row_array();
        }

    }

    function getRegisteredAccRef($postData)
    {
        // $sql = "select  0 as num, count(affiliate_code) as acnum,UNIX_TIMESTAMP(date(`date_created`)) as `date` from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ?				union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )group by date(`date_created`)";
//        $sql = "select 0 as num, count(uac.affiliate_code) as acnum,date(uac.date_created) as `date` from users_affiliate_code uac inner join (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )t
//on uac.referral_affiliate_code=t.affiliate_code WHERE date(uac.date_created) BETWEEN ? AND ? group by date(uac.date_created)
//";

        $sql = "select 0 as num, count(uac.affiliate_code) as acnum,mas.registration_time as `date` from users_affiliate_code uac inner join (SELECT affiliate_code from users_affiliate_code where users_id=?  union all SELECT affiliate_code from partnership_affiliate_code where partner_id =?)t
                on uac.referral_affiliate_code=t.affiliate_code
                left join  mt_accounts_set mas
                on uac.users_id= mas.user_id
                WHERE date(mas.registration_time) BETWEEN ? AND ?
                group by date(registration_time)";
        $query = $this->db->query($sql, array($postData['user_id'], $postData['user_id'], $postData['date_from'], $postData['date_to']));
        if ($query->num_rows() > 0) {

            $data = array(
                'result'=> $query->result(),
                'first_row' => $query->first_row('array'),
                'last_row' => $query->last_row('array')
            );

            return $data;
        } else {
            return false;
        }

    }
    function getRegisteredAccRefDef($postData)
    {
        // $sql = "select  0 as num, count(affiliate_code) as acnum,UNIX_TIMESTAMP(date(`date_created`)) as `date` from users_affiliate_code where referral_affiliate_code in (SELECT affiliate_code from users_affiliate_code where users_id= ?				union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )group by date(`date_created`)";
        $sql = "select 0 as num, count(uac.affiliate_code) as acnum,date(uac.date_created) as `date` from users_affiliate_code uac inner join (SELECT affiliate_code from users_affiliate_code where users_id= ? union all SELECT affiliate_code from partnership_affiliate_code where partner_id = ? )t
on uac.referral_affiliate_code=t.affiliate_code group by date(uac.date_created)
";
        $sql = "select 0 as num, count(uac.affiliate_code) as acnum,mas.registration_time as `date` from users_affiliate_code uac inner join (SELECT affiliate_code from users_affiliate_code where users_id=?  union all SELECT affiliate_code from partnership_affiliate_code where partner_id =?)t
                on uac.referral_affiliate_code=t.affiliate_code
                left join  mt_accounts_set mas
                on uac.users_id= mas.user_id
                group by date(registration_time)";


        $query = $this->db->query($sql, array($postData['user_id'], $postData['user_id']));
        if ($query->num_rows() > 0) {

            $data = array(
                'result'=> $query->result(),
                'first_row' => $query->first_row('array'),
                'last_row' => $query->last_row('array')
            );

            return $data;
        } else {
            return false;
        }

    }

    public function getPartnershipReferrals($partnerId){
        $sql = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus  from (SELECT affiliate_code from users_affiliate_code where users_id=10380 union all SELECT affiliate_code from partnership_affiliate_code where partner_id =10380) t
                left join users_affiliate_code uac
                on uac.referral_affiliate_code=t.affiliate_code
                left join  mt_accounts_set mas on uac.users_id= mas.user_id left join users on users.id = mas.user_id
                left join users u on u.id = mas.user_id order by mas.registration_time desc";

        $query = $this->db->query($sql, array($partnerId, $partnerId));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function updateStatus($table,$email){
        $this->db->Set('status', '7');
        $this->db->set('bonus_status', '7');
        $this->db->where('email', $email);
        $this->db->update($table);
    }

    public function getPartnerActivatedITS($user_id) {
        $this->db->select('partnership.partner_id, partnership.reference_num, partnership_affiliate_code.affiliate_code, internal_transfer.status');
        $this->db->from('partnership');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'left');
        $this->db->join('internal_transfer', 'internal_transfer.user_id = partnership.partner_id');
        $this->db->where('internal_transfer', 1);
        $this->db->where('partnership.partner_id', $user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getPartnerActivatedITSClients($user_id) {
        $this->db->select('internal_transfer.status, users_affiliate_code.referral_affiliate_code');
        $this->db->from('users_affiliate_code');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.affiliate_code = users_affiliate_code.referral_affiliate_code', 'left');
        $this->db->join('internal_transfer', 'internal_transfer.user_id = partnership_affiliate_code.partner_id', 'left');
        $this->db->join('users', 'users.id = users_affiliate_code.users_id', 'left');
        $this->db->where('users_affiliate_code.users_id', $user_id);
        $this->db->where('users.accountstatus', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getITSRegisteredPayCoAccountByUserId($user_id) {
        $this->db->select('preferred_payco_email');
        $this->db->from('manage_payco_registration');
        $this->db->where('status', 1);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getITSRegistrationAttemptPayCoAccountByUserId($user_id) {
        $this->db->select('preferred_payco_email');
        $this->db->from('manage_payco_registration');
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getAllPartnershipReferralsWithAffiliateCode($postData){
            if( empty( $postData ) ) {
                return array();
            }

            $where = array();
    //        $query = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus  from (SELECT affiliate_code,  users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
    //                  left join users_affiliate_code uac
    //                  on uac.referral_affiliate_code=t.affiliate_code
    //                  left join  mt_accounts_set mas on uac.users_id= mas.user_id left join users on users.id = mas.user_id
    //                  left join users u on u.id = mas.user_id";

            $query = "select mas.account_number,mas.registration_time,mas.user_id,users.nodepositbonus,uac.referral_affiliate_code from users_affiliate_code uac
                      left join
                        (SELECT affiliate_code, users_id userid from users_affiliate_code union all SELECT affiliate_code, partner_id userid from partnership_affiliate_code) t
                        on uac.referral_affiliate_code=t.affiliate_code
                      left join  mt_accounts_set mas
                        on uac.users_id= mas.user_id
                      left join users
                        on users.id = mas.user_id";

            if(isset($postData['user_id']) && !empty($postData['user_id'])){
                $userid[] = "t.userid = '".$postData['user_id']."'";
                $where[] = implode( " OR ", $userid );
            }

            if(isset($postData['date_from']) && !empty($postData['date_from'])){
                $date[] = "DATE(registration_time) BETWEEN '".$postData['date_from']."' AND '".$postData['date_to']."'";
                $where[] = implode( " OR ", $date );
            }
            $whereClause = !empty( $where ) ? " WHERE " . implode( " AND ", $where ) : "";

            $query .= $whereClause . " and uac.referral_affiliate_code = '".$postData['affiliate_code']."'  ORDER BY `registration_time` ASC LIMIT ".$postData['offset'].", ".$postData['limit']."";
            $result = $this->db->query( $query );
		
            if( is_object( $result ) ) {
                return $result->result_array();
            }
            return false;
        }

    function getCpaClientListWithAffiliateCode($user_id, $type,$aff_code,$from,$to)
    {


        //$sql = "select count(*) as approv_deposite, mt.account_number,mt.registration_time,d.amount from mt_accounts_set mt inner join deposit d on mt.user_id= d.user_id  inner join users_affiliate_code uac on uac.users_id=mt.user_id inner join( SELECT affiliate_code from partnership_affiliate_code where partner_id = ?) ac on ac.affiliate_code = uac.referral_affiliate_code group by mt.account_number order by d.payment_date asc";
        /*
        $sql = "select count(*) approv_deposite,mt.user_id, ac.partner_id, mt.account_number,mt.registration_time,d.amount from mt_accounts_set mt inner join deposit d on mt.user_id= d.user_id  inner join users_affiliate_code uac on uac.users_id=mt.user_id inner join

(SELECT pac.affiliate_code,p.partner_id from partnership p inner join partnership_affiliate_code pac on p.partner_id=pac.partner_id where pac.partner_id=? and  p.type_of_partnership='cpa' and p.status_type=? ) ac on ac.affiliate_code = uac.referral_affiliate_code
 group by mt.user_id";
        $query = $this->db->query($sql, array($user_id, $type));
        */
        $this->db->select('mt_accounts_set.account_number, mt_accounts_set.registration_time, sum(deposit.amount) as amount, deposit.cpa_amount, users_affiliate_code.referral_affiliate_code');
        $this->db->from('partnership');
        $this->db->join('partnership_affiliate_code', 'partnership_affiliate_code.partner_id = partnership.partner_id', 'inner');
        $this->db->join('users_affiliate_code', 'users_affiliate_code.referral_affiliate_code = partnership_affiliate_code.affiliate_code', 'inner');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'inner');
        $this->db->join('deposit', 'deposit.status = 2 and deposit.user_id = mt_accounts_set.user_id', 'inner');
        $this->db->where('partnership.partner_id', $user_id);
        $this->db->where('partnership.type_of_partnership', 'cpa');
        $this->db->where('deposit.cpa', $type);
        $this->db->where('deposit.payment_date', '(select min(payment_date)
                                                   from deposit deposit2
                                                   where deposit2.status = 2
                                                   and deposit2.user_id = deposit.user_id)', false);
        $this->db->where('users_affiliate_code.referral_affiliate_code',$aff_code);
        $this->db->where("deposit.payment_date BETWEEN '".$from."' AND '".$to."'");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getRefTotal($id){
        $q = $this->db->select('*')
            ->from('users_affiliate_code a')
            ->join('partnership_affiliate_code c', 'a.referral_affiliate_code = c.affiliate_code')
            ->join('partnership b','c.partner_id = b.partner_id')
            ->where('b.reference_subnum', $id);
        $ret['rows'] = $q->get()->result();
        return $ret;
    }

    public function getTTPaycoWallet( $user_id ) {
        $this->db->select('its_payco_wallets.wallet_number');
        $this->db->from('its_payco_wallets');
        $this->db->join('manage_payco_registration','manage_payco_registration.id = its_payco_wallets.mpr_id','left');
        $this->db->where('its_payco_wallets.currency','USD');
        $this->db->where('manage_payco_registration.user_id',$user_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getPartnerReferralsByPartnerID( $user_id ) {
        $this->db->select('users_affiliate_code.users_id, users_affiliate_code.referral_affiliate_code, users_affiliate_code.affiliate_code, mt_accounts_set.account_number');
        $this->db->from('partnership');
        $this->db->join('partnership_affiliate_code','partnership.partner_id = partnership_affiliate_code.partner_id','left');
        $this->db->join('users_affiliate_code','partnership_affiliate_code.affiliate_code = users_affiliate_code.referral_affiliate_code','left');
        $this->db->join('mt_accounts_set','users_affiliate_code.users_id = mt_accounts_set.user_id');
        $this->db->where('partnership.partner_id',$user_id);
        $this->db->order_by('users_affiliate_code.users_id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function getPartnerDetailsById($partner_id){
        $this->db->select('*')
            ->from($this->tb_users.' as u')
            ->join($this->tb_profiles.' as p', 'u.id = p.user_id', 'left')
            ->where('u.id', $partner_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;

    }

    public function getRebateAmount($partner_id){
        $this->db->select('sum(rl.amount) as num')
            ->from($this->tb_partnerhip.' as p')
            ->join("rebate_log".' as rl', 'p.reference_num=rl.agent', 'inner')
            ->where('p.partner_id', $partner_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->num;
        }
        return 0;

    }

    public function getStatisticsData($from=null,$to=null,$account_number="all",$agent=null,$view=null){
        $this->db->select('sum(amount) as num, date(`date`) as p_date');
        $this->db->from('rebate_log');

        if(!is_null($from) || !is_null($to)){
            $this->db->where('date(`date`) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
        }
        if(trim($account_number)!="All"){
            $this->db->where('account', $account_number);
        }
        $this->db->where('agent', $agent);
        $this->db->group_by("date(`date`)");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return 0;
    }

    public function getAffiliateSecurityCodeByUserId($user_id) {
        $this->db->select('*');
        $this->db->from('its_security_code');
        $this->db->where('affiliate_user_id',$user_id);
        $this->db->where('status',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    public function getAffiliateSecurityCodeByCode($code) {
        $this->db->select('*');
        $this->db->from('its_security_code');
        $this->db->where('security_code',$code);
        //$this->db->where('status',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function getSecurityCodeOnTransitTransfer($sec_code) {
        $this->db->select('security_code');
        $this->db->from('transit_transfer');
        $this->db->where('security_code',$sec_code);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    public function getCashbackStatisticsData($from=null,$to=null,$account_number="all",$agent=null,$view=null){
        $this->db->select('sum(amount) as num, date(`date`) as p_date');
        $this->db->from('cashback_log');

        if(!is_null($from) || !is_null($to)){
            $this->db->where('date(`date`) BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
        }
        if(trim($account_number)!="All"){
            $this->db->where('account', $account_number);
        }
        $this->db->where('agent', $agent);
        $this->db->group_by("date(`date`)");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return 0;
    }

    public function checkMPRData($email, $token) {
        $this->db->select('*');
        $this->db->from('manage_payco_registration');
        $this->db->where('token', $token);
        $this->db->where('preferred_payco_email', $email);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    public function update_mpr($where, $data) {
        $this->db->where('preferred_payco_email', $where['email']);
        $this->db->where('token', $where['token']);
        if($this->db->update('manage_payco_registration', $data)){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getPayCoRegistrationById($user_id) {
        $this->db->select('mpr.username, mpr.password, mpr.merchant_id, its.*');
        $this->db->from('manage_payco_registration mpr');
        $this->db->join('its_payco_wallets its','its.mpr_id = mpr.id','left');
        $this->db->where('mpr.user_id',$user_id);
        $this->db->where('mpr.status',1);
        $this->db->group_by('its.mpr_id');
        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return $query->row_array();
        }
        return false;
    }

    public function insertITSTest($data){
        if($this->db->insert('ITS_testing', $data)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function checkAmountTransferred($account_number, $date) {
        $from = $date.' 23:59:59';
        $to = $date.' 00:00:00';

        $this->db->select('sum(amount_transfer) as total_transferred', false);
        $this->db->from('transit_transfer');
        $this->db->where('date_transfer <=', $from);
        $this->db->where('date_transfer >=', $to);
        $this->db->where('request_from_affiliate', 1);
        $this->db->where('receiver', $account_number);
      //  $this->db->where('status', 2);
        $this->db->where_in('status', array(2,6)); //for admin verification - 6 and success - 2
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;

    }
    public function getReferralCountofAffiliateCode($affiliate_code,$from,$to){
        $from = date("Y-m-d H:i:s",strtotime($from.' 0:0:0'));
        $to = date("Y-m-d H:i:s",strtotime($to.' 23:59:59'));
        $where_bet = "(date_created BETWEEN STR_TO_DATE('".$from."','%Y-%m-%d %H:%i:%s')  AND STR_TO_DATE('".$to."','%Y-%m-%d %H:%i:%s') )";
        $this->db->select('date_created,COUNT(*) as referralCount', false);
        $this->db->from('users_affiliate_code');
        if(strlen($affiliate_code)>0){
            $this->db->where('referral_affiliate_code', $affiliate_code);
        }else{
            $this->db->where('1=0'); // If referral affiliate code is blank then no need to return any data
        }

        $this->db->where($where_bet);
        $this->db->GROUP_BY("DATE_FORMAT(date_created,'%Y-%m-%d')");
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function getReferralCountofAffiliateCode2($affiliate_code,$account_number,$from,$to){
        $where_bet = "(users_affiliate_code.date_created >= '" .  date("Y-m-d H:i:s",strtotime($from.' 0:0:0')) . "' AND users_affiliate_code.date_created <= '" . date("Y-m-d H:i:s",strtotime($to.' 23:59:59')) . "')";
        $this->db->select('users_affiliate_code.date_created,COUNT(*) as referralCount', false);
        $this->db->from('users_affiliate_code');
        $this->db->join('mt_accounts_set', 'mt_accounts_set.user_id = users_affiliate_code.users_id', 'inner');
        $this->db->where_in('users_affiliate_code.referral_affiliate_code',$affiliate_code);
        $this->db->where_in('mt_accounts_set.account_number',$account_number);
        $this->db->where($where_bet);
        $this->db->GROUP_BY('users_affiliate_code.date_created');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function getAccountDetailsByAcctNumber1($acctno, $type){
        if ($type == 'client') {
            $q = $this->db->select('*')
                ->from('mt_accounts_set a')
                ->join('users b', 'a.user_id = b.id','inner')
                ->join('user_profiles c', 'b.id = c.user_id', 'left')
                ->join('users_affiliate_code d', 'c.user_id = d.users_id', 'left')
                ->where('a.account_number', $acctno);
            $ret['rows'] = $q->get()->result();
        } else if ($type == 'partner') {
            $q = $this->db->select('*')
                ->from('partnership a')
                ->join('users b', 'a.partner_id = b.id', 'inner')
                ->join('user_profiles c', 'b.id = c.user_id', 'left')
                ->join('partnership_affiliate_code d', 'a.partner_id = d.partner_id', 'inner')
                ->where('a.reference_num', $acctno);
            $ret['rows'] = $q->get()->result();
        }
        return $ret;
    }


    public function getAffiliateCodeofAgent($account){
        $q = "select users_affiliate_code.affiliate_code,mt_accounts_set.account_number account_number from mt_accounts_set inner join users_affiliate_code on users_affiliate_code.users_id = mt_accounts_set.user_id where mt_accounts_set.account_number = ?
         union all
         SELECT partnership_affiliate_code.affiliate_code,partnership.reference_num account_number from partnership inner join partnership_affiliate_code on partnership.partner_id = partnership_affiliate_code.partner_id where partnership.reference_num = ? ";
        $query = $this->db->query($q, array($account, $account));
        if ($query->num_rows() > 0) {
            $ret['rows'] = $query->result();
            return $ret;
        } else {
            return false;
        }

  }



    
    public function getReferralsByCode($affiliate_code){
            $q = "select a.users_id , a.referral_affiliate_code ,case when users.login_type = 1 then -1 else mt_accounts_set.mt_account_set_id end account_type , case when users.login_type = 1 then partnership.reference_num else mt_accounts_set.account_number end account_number , user_profiles.full_name, users.email, contacts.phone1, a.affiliate_code,case when users.login_type = 1 then partnership.dateregistered else mt_accounts_set.registration_time end registration_time,users.accountstatus
             from users_affiliate_code a
             left join mt_accounts_set on a.users_id = mt_accounts_set.user_id
             left join partnership on  a.users_id = partnership.partner_id
             left join  user_profiles on a.users_id = user_profiles.user_id
             left join users on a.users_id = users.id 
             LEFT JOIN contacts ON a.users_id = contacts.user_id 
             where a.referral_affiliate_code!= ''          
             and a.referral_affiliate_code = '" . $affiliate_code. "'";
            $query = $this->db->query($q);
            if ($query->num_rows() > 0) {
                $ret['rows'] = $query->result();
                return $ret;
            } else {
                return false;
            }

    }

    public function getAffiliates1($id){
        $q = $this->db->select('a.users_id , a.referral_affiliate_code , mt_accounts_set.account_number,user_profiles.full_name, a.affiliate_code, a.second_level_status,mt_accounts_set.registration_time,users.accountstatus')
            ->from('users_affiliate_code a')
            ->join('mt_accounts_set', 'a.users_id = mt_accounts_set.user_id', 'left')
            ->join('user_profiles','a.users_id = user_profiles.user_id','left')
            ->join('users','a.users_id = users.id','left')
            ->where('a.referral_affiliate_code', $id)
            ->where('a.referral_affiliate_code!=""')
            ->where('users.accountstatus', 1);
        $ret['rows'] = $q->get()->result();
        return $ret;
    }





    public function getPartnerRequestTranferStatus($partner_id){
        $this->db->select('*');
        $this->db->from('internal_transfer');
        $this->db->where('user_id',$partner_id);
        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return $query->row_array();
        }
        return false;
    }




//    public function isBdcountry($user_id){
//
//        $sql = "SELECT
//  mt_accounts_set.account_number,
//  mailer_test_recipients.Email,
//  mailer_test_recipients.Active,
//  users.id AS userId,
//  users_affiliate_code.`affiliate_code`,
//  user_profiles.`country`
//FROM
//  mailer_test_recipients
//  INNER JOIN users
//    ON users.email = mailer_test_recipients.Email
//  INNER JOIN mt_accounts_set
//    ON mt_accounts_set.user_id = users.id
//  INNER JOIN users_affiliate_code
//    ON users_affiliate_code.users_id = users.id
//  INNER JOIN user_profiles
//    ON user_profiles.user_id = users.id
//WHERE users.id = ?
//        ";
//        $query = $this->db->query($sql, array($user_id));
//
//       // return $this->db->last_query();
//
//
//        if ($query->num_rows() > 0) {
//            return $query->row_array();
//        } else {
//            return false;
//        }
//
//
//    }



    public function isReqaffcode($user_id){

        $sql = "SELECT 
  mt_accounts_set.account_number,
  mailer_test_recipients.Email,
  mailer_test_recipients.Active,
  users.id AS userId,
  users_affiliate_code.`affiliate_code`,
  user_profiles.`country` ,
  users_affiliate_code.`req_for_affiliate_code` 
FROM
  mailer_test_recipients 
  INNER JOIN users 
    ON users.email = mailer_test_recipients.Email 
  INNER JOIN mt_accounts_set 
    ON mt_accounts_set.user_id = users.id 
  INNER JOIN users_affiliate_code 
    ON users_affiliate_code.users_id = users.id 
  INNER JOIN user_profiles 
    ON user_profiles.user_id = users.id 
WHERE users.id = ?
        ";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }





    public function isApprovedReqCode($user_id){

        $sql = "SELECT 
  mt_accounts_set.account_number,
  mailer_test_recipients.Email,
  mailer_test_recipients.Active,
  users.id AS userId,
  users_affiliate_code.`affiliate_code`,
  user_profiles.`country` ,
  users_affiliate_code.`approved_affiliate_code` 
FROM
  mailer_test_recipients 
  INNER JOIN users 
    ON users.email = mailer_test_recipients.Email 
  INNER JOIN mt_accounts_set 
    ON mt_accounts_set.user_id = users.id 
  INNER JOIN users_affiliate_code 
    ON users_affiliate_code.users_id = users.id 
  INNER JOIN user_profiles 
    ON user_profiles.user_id = users.id 
WHERE users.id = ?
        ";
        $query = $this->db->query($sql, array($user_id));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getPartnerReferralByMasterId2($user_id){
        $q = $this->db->select('partnership.partner_id,partnership.type_of_partnership,partnership.reference_num,partnership_affiliate_code.affiliate_code,partnership.dateregistered,partnership_affiliate_code.referral_ib_code')
            ->from('partnership_affiliate_code')
            ->join('partnership', 'partnership.partner_id = partnership_affiliate_code.partner_id', 'inner')
            ->where('partnership_affiliate_code.referral_master_id', $user_id);
        $ret['rows'] = $q->get()->result();
        return $ret;
    }

    public function getAffiliatesByReferralCode($code){
        $q = $this->db->select('*')
            ->from('all_referrals')
            ->where('referral_affiliate_code', $code);
        $ret['rows'] = $q->get()->result();
        return $ret;
    }


    function getReferralActivties($user_id)
    {
        
        $sql = "SELECT mt_accounts_set.mt_currency_base, mt_accounts_set.user_id, mt_accounts_set.registration_time,mt_accounts_set.account_number,t2.*,countries.country,sum(deposit.amount) deposit,sum(withdraw.amount) withdraw from mt_accounts_set inner join (
            SELECT users_affiliate_code.referral_affiliate_code,users_affiliate_code.users_id from users_affiliate_code inner join 
            (SELECT partnership_affiliate_code.affiliate_code from partnership inner join partnership_affiliate_code  on partnership.partner_id = partnership_affiliate_code.partner_id
            where partnership.partner_id = ?) t on users_affiliate_code.referral_affiliate_code = t.affiliate_code) t2 on mt_accounts_set.user_id = t2.users_id
            inner join user_profiles on user_profiles.user_id = mt_accounts_set.user_id
            inner join countries on countries.country_id = user_profiles.country
            left join deposit on deposit.user_id = mt_accounts_set.user_id and deposit.status = 2
            left join withdraw on withdraw.user_id = mt_accounts_set.user_id and withdraw.status = 1
             order by mt_accounts_set.registration_time  desc";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getReferralActivtiesDetails($user_id)
    {
        
        $sql = "SELECT * from (
            SELECT mt_accounts_set.mt_currency_base, mt_accounts_set.user_id, deposit.payment_date tx_date,mt_accounts_set.account_number,t2.*,countries.country,deposit.amount amount,'Deposited' tnx_type from mt_accounts_set inner join (
                        SELECT users_affiliate_code.referral_affiliate_code,users_affiliate_code.users_id from users_affiliate_code inner join 
                        (SELECT partnership_affiliate_code.affiliate_code from partnership inner join partnership_affiliate_code  on partnership.partner_id = partnership_affiliate_code.partner_id
                        where partnership.partner_id = ?) t on users_affiliate_code.referral_affiliate_code = t.affiliate_code) t2 on mt_accounts_set.user_id = t2.users_id
                        inner join user_profiles on user_profiles.user_id = mt_accounts_set.user_id
                        inner join countries on countries.country_id = user_profiles.country
                        inner join deposit on deposit.user_id = mt_accounts_set.user_id and deposit.status = 2  
            
            union all
            SELECT mt_accounts_set.mt_currency_base, mt_accounts_set.user_id, withdraw.date_processed tx_date,mt_accounts_set.account_number,t2.*,countries.country,withdraw.amount amount,'Withdrawn' tnx_type from mt_accounts_set inner join (
                        SELECT users_affiliate_code.referral_affiliate_code,users_affiliate_code.users_id from users_affiliate_code inner join 
                        (SELECT partnership_affiliate_code.affiliate_code from partnership inner join partnership_affiliate_code  on partnership.partner_id = partnership_affiliate_code.partner_id
                        where partnership.partner_id = ?) t on users_affiliate_code.referral_affiliate_code = t.affiliate_code) t2 on mt_accounts_set.user_id = t2.users_id
                        inner join user_profiles on user_profiles.user_id = mt_accounts_set.user_id
                        inner join countries on countries.country_id = user_profiles.country
                         inner join withdraw on withdraw.user_id = mt_accounts_set.user_id and withdraw.status = 1    )  tnx_all order by tnx_all.tx_date desc ";
        $query = $this->db->query($sql, array($user_id,$user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    function getReferralActivtiesDetailsV2($user_id)
    {

        $sql = "SELECT 
  * 
FROM
  (SELECT 
    mt_accounts_set.mt_currency_base,
    mt_accounts_set.user_id,
    deposit.payment_date tx_date,
    mt_accounts_set.account_number,
    t2.*,
    countries.country,
    IF(users.micro !='Null' , deposit.`conv_amount`,ROUND(deposit.`amount`,2)) AS amount,
    'Deposited' tnx_type,
    users.`micro` micro_status 
  FROM
    mt_accounts_set 
    LEFT JOIN users
   ON users.id = mt_accounts_set.`user_id` 
    INNER JOIN 
      (SELECT 
        users_affiliate_code.referral_affiliate_code,
        users_affiliate_code.users_id 
      FROM
        users_affiliate_code 
        INNER JOIN 
          (SELECT 
            partnership_affiliate_code.affiliate_code 
          FROM
            partnership 
            INNER JOIN partnership_affiliate_code 
              ON partnership.partner_id = partnership_affiliate_code.partner_id 
          WHERE partnership.partner_id = ?) t 
          ON users_affiliate_code.referral_affiliate_code = t.affiliate_code) t2 
      ON mt_accounts_set.user_id = t2.users_id 
    INNER JOIN user_profiles 
      ON user_profiles.user_id = mt_accounts_set.user_id 
    INNER JOIN countries 
      ON countries.country_id = user_profiles.country 
    INNER JOIN deposit 
      ON deposit.user_id = mt_accounts_set.user_id 
      AND deposit.status = 2 
      
      
  UNION
  ALL 
  SELECT 
    mt_accounts_set.mt_currency_base,
    mt_accounts_set.user_id,
    withdraw.date_processed tx_date,
    mt_accounts_set.account_number,
    t2.*,
    countries.country,
    withdraw.amount amount,
    'Withdrawn' tnx_type ,
    ' ' micro_status 
  FROM
    mt_accounts_set 
    INNER JOIN 
      (SELECT 
        users_affiliate_code.referral_affiliate_code,
        users_affiliate_code.users_id 
      FROM
        users_affiliate_code 
        INNER JOIN 
          (SELECT 
            partnership_affiliate_code.affiliate_code 
          FROM
            partnership 
            INNER JOIN partnership_affiliate_code 
              ON partnership.partner_id = partnership_affiliate_code.partner_id 
          WHERE partnership.partner_id = ? ) t 
          ON users_affiliate_code.referral_affiliate_code = t.affiliate_code) t2 
      ON mt_accounts_set.user_id = t2.users_id 
    INNER JOIN user_profiles 
      ON user_profiles.user_id = mt_accounts_set.user_id 
    INNER JOIN countries 
      ON countries.country_id = user_profiles.country 
    INNER JOIN withdraw 
      ON withdraw.user_id = mt_accounts_set.user_id 
      AND withdraw.status = 1 
      
      
      
  UNION
  ALL 
  SELECT 
    IF(
      mt_accounts_set.mt_currency_base != 'NULL',
      mt_accounts_set.mt_currency_base,
      a.`currency`
    ) AS mt_currency_base,
    mt_accounts_set.`user_id`,
    transit_transfer.`date_transfer` tx_date,
    transit_transfer.`receiver` AS account_number,
    partnership_affiliate_code.`affiliate_code` AS referral_affiliate_code,
    mt_accounts_set.`user_id`,
    IF(
      c.`country` != 'NULL',
      c.`country`,
      countries.`country`
    ) AS country,
    transit_transfer.`conv_amount` amount,
    transit_transfer.`transaction_type` tnx_type,
    users.`micro` AS micro_status 
  FROM
    `transit_transfer` 
    LEFT JOIN `partnership` 
      ON partnership.`reference_num` = transit_transfer.`receiver` 
    LEFT JOIN `partnership_affiliate_code` 
      ON partnership.`partner_id` = partnership_affiliate_code.`partner_id` 
    LEFT JOIN `partnership` AS a 
      ON a.`reference_num` = transit_transfer.`receiver` 
    LEFT JOIN user_profiles AS b 
      ON b.user_id = a.partner_id 
    LEFT JOIN countries AS c 
      ON c.country_id = b.country 
    LEFT JOIN `mt_accounts_set` 
      ON mt_accounts_set.`account_number` = transit_transfer.`sender` 
    LEFT JOIN user_profiles 
      ON user_profiles.user_id = mt_accounts_set.user_id 
    LEFT JOIN countries 
      ON countries.country_id = user_profiles.country 
    LEFT JOIN `users` 
      ON users.`id` = mt_accounts_set.`user_id` 
  WHERE partnership.`partner_id` = ? 
    AND transit_transfer.`transaction_type` != 'NULL' 
    AND transit_transfer.`transaction_type` = '3' 
  GROUP BY transit_transfer.`date_transfer` 
      
      
  UNION
  ALL 
  SELECT 
  IF(
    mt_accounts_set.mt_currency_base != 'NULL',
    mt_accounts_set.mt_currency_base,
    a.`currency`
  ) AS mt_currency_base,
  mt_accounts_set.`user_id`,
  transit_transfer.`date_transfer` tx_date,
  transit_transfer.`receiver` AS account_number,
  partnership_affiliate_code.`affiliate_code` AS referral_affiliate_code,
  mt_accounts_set.`user_id`,
  IF(
    c.`country` != 'NULL',
    c.`country`,
    countries.`country`
  ) AS country,
  transit_transfer.`conv_amount` amount,
  transit_transfer.`transaction_type` tnx_type,
   users.`micro` AS micro_status 

FROM
  `transit_transfer` 
  LEFT JOIN `partnership` 
    ON partnership.`reference_num` = transit_transfer.`sender` 
  LEFT JOIN `partnership_affiliate_code` 
    ON partnership.`partner_id` = partnership_affiliate_code.`partner_id` 
  LEFT JOIN `partnership` AS a 
    ON a.`reference_num` = transit_transfer.`receiver` 
  LEFT JOIN user_profiles AS b 
    ON b.user_id = a.partner_id 
  LEFT JOIN countries AS c 
    ON c.country_id = b.country 
  LEFT JOIN `mt_accounts_set` 
    ON mt_accounts_set.`account_number` = transit_transfer.`receiver` 
  LEFT JOIN user_profiles 
    ON user_profiles.user_id = mt_accounts_set.user_id 
  LEFT JOIN countries 
    ON countries.country_id = user_profiles.country 
     LEFT JOIN `users` 
      ON users.`id` = mt_accounts_set.`user_id`
WHERE partnership.`partner_id` = ? 
  AND transit_transfer.`transaction_type` != 'NULL'  
  GROUP BY transit_transfer.id) tnx_all 
ORDER BY tnx_all.tx_date DESC  ";
        $query = $this->db->query($sql, array($user_id,$user_id, $user_id, $user_id));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getSubPermissionData($account){
        $this->db->select('permission');
        $this->db->from('partner_sub_affilliate');
        $this->db->where($account);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }








}