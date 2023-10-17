<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction
{

    protected $removeBonusesComment =  array(
        1 => 'FM BONUS 30% CANCELLATION',
        2 => 'FM 100% NDB CANCELLATION',
        28 => 'FM BONUS 20% CANCELLATION',
        7 => 'BONUS_CONTEST_PRIZE_CANCELLATION',
        10 => 'FM BONUS 50% CANCELLATION',
        12 => 'FM_CONTEST_MF_CANCELLATION'
    );

    protected $depositMethods = array(
        1 => 'Deposit_30PercentBonus',
        2 => 'Deposit_NoDepositBonus',
        28 => 'Deposit_20PercentBonus',
        7=> 'Deposit_ContestPrizeBonus',
        10 => 'Deposit_50_PercentBonus',
        12 => 'Deposit_Contest_MF_Prize_Bonus'
    );

//    public function RemoveBonus($BonusData){ //Old Procedure
//
//        $accountNumber = $BonusData['Account_number'];
//        $user_id = $BonusData['UserId'];
//
//        // Remove pending 30% and 50% bonuses
////        $this->removePendingDepositBonuses($user_id);
//
//        $transaction_id = $BonusData['TransactionId'];
//        $transaction_type = $BonusData['TransactionType'];
//
//        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);
//        $removeBonuses = $this->removeBonusesComment;
//        foreach($getAccountBonusByType as $key => $bonuses){
//            if(array_key_exists($key, $removeBonuses)){
//                if($bonuses > 0){
//                    $removeContestBonusParams = array(
//                        'amount' => $bonuses,
//                        'account_number' => $accountNumber,
//                        'user_id' => $user_id,
//                        'bonus_id' => $key,
//                        'transaction_id' => $transaction_id,
//                        'transaction_type' => $transaction_type
//                    );
//
//                    self::processRemovingBonus($removeContestBonusParams);
//
//                    if($key == 2){
//                        $realFundToRemove = 0.20 * $bonuses;
//                        $removeContestBonusParams['realFundToRemove'] = $realFundToRemove;
//                        self::Remove20PercentOfNDBInRF($removeContestBonusParams);
//                    }
//
//                }
//            }
//        }
//
//    }

    public function RemoveBonus($BonusData){

        return false;

        $accountNumber = $BonusData['Account_number'];
        $user_id = $BonusData['UserId'];

        $transaction_id = $BonusData['TransactionId'];
        $transaction_type = $BonusData['TransactionType'];
        $withdrawAmount =  $BonusData['Amount'];
        $amountDeducted =  $BonusData['Amount_deducted'];

        $getAccountBonusByType = FXPP::getAccountBonusByType($accountNumber);
        $profit  = FXPP::realProfit($accountNumber);

        $removeBonuses = $this->removeBonusesComment;

        $accountFunds = FXPP::getAccountFunds($accountNumber);

        if($accountFunds['status'] !== 'RET_OK'){
            $accountFunds = FXPP::getAccountFunds2($accountNumber);
        }

        $apiJson = json_encode($accountFunds); // reference only
        
        $bonusFund = $accountFunds['bonusFund'];
        $bonuses = 0;
        foreach($getAccountBonusByType as $key => $bonusesAmt){
            if(array_key_exists($key, $removeBonuses)) {
                if($bonusesAmt > 0){
                //check bonus to deduct based on withdraw amount
                if ($key == 1) {
                    $real_bonus_fund = round($accountFunds['withrawableRealFund'] * 0.30, 2);
                    if ($real_bonus_fund < $accountFunds['bonusFund']) {
                        $bonuses = $accountFunds['bonusFund'] - $real_bonus_fund;
                    } elseif ($accountFunds['withrawableRealFund'] <= 0) {
                        $bonuses = $accountFunds['bonusFund'];
                    } else {
                        $bonuses = 0;
                    }

                } elseif ($key == 28) {
                    $real_bonus_fund = round($accountFunds['withrawableRealFund'] * 0.20, 2);
                    // $real_bonus_fund = $amountDeducted; // for 20 percent bonus, withdrawal amount is equivalent to amount of bonus cancelled
                    if ($withdrawAmount > $profit) {
                        if ($real_bonus_fund < $accountFunds['bonusFund']) {
                            $bonuses = $accountFunds['bonusFund'] - $real_bonus_fund;
                        } elseif ($accountFunds['withrawableRealFund'] <= 0) {
                            $bonuses = $accountFunds['bonusFund'];
                        } else {
                            $bonuses = 0;
                        }
                    }

                } elseif ($key == 10) {
                    $real_bonus_fund = round($accountFunds['withrawableRealFund'] * 0.50, 2);
                    if ($real_bonus_fund <= $accountFunds['bonusFund']) {
                        $bonuses = $accountFunds['bonusFund'] - $real_bonus_fund;
                    } elseif ($accountFunds['withrawableRealFund'] <= 0) {
                        $bonuses = $accountFunds['bonusFund'];
                    } else {
                        $bonuses = 0;
                    }
                } else if ($key == 7 || $key == 12) {

                }
            }



                if($bonuses > 0){

                        $accountFunds['bonusFund'] -=  $bonuses;
                        $removeContestBonusParams = array(
                            'amount' => $bonuses,
                            'account_number' => $accountNumber,
                            'user_id' => $user_id,
                            'bonus_id' => $key,
                            'transaction_id' => $transaction_id,
                            'transaction_type' => $transaction_type,
                            'withrawable_real_fund' => $accountFunds['withrawableRealFund'],
                            'bonus_fund' => $bonusFund,
                            'api' => $apiJson,
                        );


                        if(round($bonuses,2) > round($bonusFund,2)){
                            //In case bonus  to be cancelled exceed the total bonus fund of client
                            self::DeclineBonusCancellation($removeContestBonusParams);

                        }else{
                            self::processRemovingBonus($removeContestBonusParams);
                        }

                        $bonuses = 0;  // reset the bonus amount because of the foreach
                
//                        if($key == 2){
//                            $realFundToRemove = 0.20 * $bonuses;
//                            $removeContestBonusParams['realFundToRemove'] = $realFundToRemove;
//                            self::Remove20PercentOfNDBInRF($removeContestBonusParams);
//                        }
//                    
                }else{
                    /*logger*/
                    FXPP::CI()->load->model('Logs_model');
                    $logData = array(
                        'account_number' => isset($accountNumber) ? $accountNumber : 0,
                        'method' => 'ITS Bonus Cancellation',
                        'request_data' => json_encode(array('fund' => $apiJson, 'profit' => $profit, 'amount' =>$withdrawAmount)),
                        'status' => 'bonus zero',
                        'date' => FXPP::getCurrentDateTime()
                    );

                    FXPP::CI()->Logs_model->insert_log($table = "api_method_log", $logData);
                    
                }
            }
        }

    }

     
    public function removePendingDepositBonuses($user_id){
        $ci =& get_instance();
        $ci->load->model('withdraw_model');

        $dateUpdate = array(
            'twentypercentbonus' => 2,
            'thirtypercentbonus' => 2,
            'fiftypercentbonus' => 2,
            'date_bonus_acquired' => date('Y-m-d H:i:s')
        );
        $conditions = array(
            'user_id' => $user_id,
            'twentypercentbonus' => 0,
            'thirtypercentbonus' => 0,
            'fiftypercentbonus' => 0
        );

        $this->withdraw_model->removePendingDepositBonus($dateUpdate, $conditions);
    }

    public function processRemovingBonus($params){
        $ci =& get_instance();
        $ci->load->model('Withdraw_model');

        $amount = $params['amount'];
        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $bonusId = $params['bonus_id'];
        $withdraw_id = $params['transaction_id'];
        $transaction_type = $params['transaction_type'];
        $withrawable_real_fund = $params['withrawable_real_fund'];
        $bonus_fund = $params['bonus_fund'];
        $comment = $this->removeBonusesComment[$bonusId];
        $fund_status = 1;

        $webservice_config = array(
            'server' => 'live_new'
        );

        $remove_amount = $amount * -1;
        
        $account_info = array(
            'Amount' => $remove_amount,
            'Comment' => $comment,
            'AccountNumber' => $account_number,
            'Method' => $this->depositMethods[$bonusId]
        );

        $WebService = new WebService($webservice_config);
        $WebService->RequestCommonMethodBonus($account_info);
        $result = $WebService->result;
        

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $withdraw_data = array(
            'Account_number' => $account_number,
            'User_id' => $userId,
            'Date' => $date,
            'Ticket' => $result['Ticket'],
            'Amount' => $amount,
            'Bonus_id' => $bonusId,
            'Transaction_id' => $withdraw_id,
            'Transaction_type' => $transaction_type,
            'Is_realfund' => $fund_status,
            'Withrawable_real_fund' => $withrawable_real_fund,
            'Bonus_fund' => $bonus_fund,
            'API' => $params['api'],
            'mt_status' => $WebService->request_status,
        );

        $ci->Withdraw_model->insertWithdrawBonus($withdraw_data);

    }

    public function Remove20PercentOfNDBInRF($params){
        $ci =& get_instance();
        $ci->load->model('Withdraw_model');

        $amount = $params['realFundToRemove'];
        $account_number = $params['account_number'];
        $userId = $params['user_id'];
        $withdraw_id = $params['transaction_id'];
        $transaction_type = $params['transaction_type'];

        $comment = 'FM 20% NDB CANCELLATION';
        $webservice_config = array(
            'server' => 'live_new'
        );

        $remove_amount = $amount * -1;
        $account_info = array(
            'Amount' => $remove_amount,
            'Comment' => $comment,
            'AccountNumber' => $account_number,
            'Method' => 'DepositRealFund'
        );
        $WebService = new WebService($webservice_config);
        $WebService->RequestCommonMethodBonus($account_info);
        $result = $WebService->result;
        if ($WebService->request_status === 'RET_OK') {

            $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
            $withdraw_data = array(
                'Account_number' => $account_number,
                'User_id' => $userId,
                'Date' => $date,
                'Ticket' => $result['Ticket'],
                'Amount' => $amount,
                'Bonus_id' => 0,
                'Transaction_id' => $withdraw_id,
                'Transaction_type' => $transaction_type,
                'Is_realfund' => 1
            );

            $ci->Withdraw_model->insertWithdrawBonus($withdraw_data);

        }
    }
    public function DeclineBonusCancellation($params){
        $ci =& get_instance();
        $ci->load->model('Withdraw_model');

        $date = date('Y-m-d H:i:s', strtotime(FXPP::getCurrentDateTime()));
        $withdraw_data = array(
            'Account_number' => $params['account_number'],
            'User_id' => $params['user_id'],
            'Date' => $date,
            'Ticket' => 0,
            'Amount' => 0,
            'Bonus_id' => $params['bonus_id'],
            'Transaction_id' => $params['transaction_id'],
            'Transaction_type' =>$params['transaction_type'],
            'Is_realfund' => 1,
            'Withrawable_real_fund' => $params['withrawable_real_fund'],
            'Bonus_fund' => $params['bonus_fund'],
            'Bonus_cancel' => $params['amount'],
            'Status' => 2,
            'Note' => 'Incorrect bonus computation',
            'API' => $params['api'],
        );

        $ci->Withdraw_model->insertWithdrawBonus($withdraw_data);

    }

    //    Transaction Record

    public function getAllTransactionData($transType = null, $account_number, $from, $to){
        $transactionTypesId = array(
            'Bonuses' => 1,
            'Deposits' => 3,
            'Withdraws' => 4,
            'Transfers' => 6
        );
        if($transType){
            $getAccountFinanceRecordByTranType = self::getAccountFinanceRecordByTranType($transactionTypesId[$transType], $account_number, $from, $to);
            $TransactionData = $getAccountFinanceRecordByTranType;
        }else{
            $TransactionData = self::getAccountFinanceRecord($account_number, $from, $to);

        }
        return $TransactionData;

    }

    public function getAccountFinanceRecordByTranType($transTypeId, $account_number, $from, $to){
        $account_info = array(
            'account_number' => $account_number,
            'from' => $from,
            'to' => $to,
            'limit' => 999999999,  //suggested by admin no choice
            'offset' => 0,
            'type' => $transTypeId,
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->GetAccountFinanceRecordsByTypeWithLimitOffset($account_info);
        $financeRecord = $WebService->get_result('FinanceRecords');
        if($financeRecord){
            $financeRecordEncode = json_encode($financeRecord);
            $financeRecordDecode = json_decode($financeRecordEncode, true);
            return $financeRecordDecode['FinanceRecordData'];
        }
        return false;

    }

    public function getAccountFinanceRecord($account_number, $from, $to){
        $account_info = array(
            'iLogin' => $account_number,
            'from' => $from,
            'to' => $to
        );
        $webservice_config = array('server' => 'live_new');
        $WebService = new WebService($webservice_config);
        $WebService->open_RequestAccountFinanceRecordsByDate($account_info);
        $financeRecord = $WebService->get_result('FinanceRecords');
        if($financeRecord){
            $financeRecordEncode = json_encode($financeRecord);
            $financeRecordDecode = json_decode($financeRecordEncode, true);
            return $financeRecordDecode['FinanceRecordData'];
        }
        return false;

    }

}