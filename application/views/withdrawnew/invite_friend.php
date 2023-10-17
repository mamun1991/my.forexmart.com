
<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>
<?php $this->load->view('finance_nav.php');?>

<style>
    .alert-danger p{
        display: inline;
    }
    p.fee-details{
        padding-top: 2%;
    }
</style>



<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">Invite friend bonus Withdrawal Option <span class="payment_method"></span></h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawPaypal')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert"><?=lang('wppal_01');?></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* <?=lang('wppal_02');?></span></label>
                        </div>
                    <?php } ?>
            <div class="withdraw_common">
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?= lang('trd_20'); ?>:<span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <select class="form-control" id="withdrawal_methods">
                                <option value="0">Select</option>
                                <option value="CREDIT CARD">Withdrawal Credit Card</option>
                                <option value="BANK TRANSFER">Withdrawal Bank Transfer</option>
                                <option value="SKRILL">Withdrawal Skrill (Moneybookers)</option>
                                <option value="NETELLER">Withdrawal Neteller</option>
                                <option value="PAXUM">Withdrawal Paxum</option>
                                <option value="PAYPAL">Withdrawal Paypal</option>
                                <option value="WEBMONEY">Withdrawal WebMoney</option>
                                <option value="PAYCO">Withdrawal Payco</option>
                                <option value="QIWI">Withdrawal Qiwi</option>
                                <option value="MEGATRANSFER">Withdrawal MegaTransfer</option>
                                <option value="BITCOIN">Withdrawal Bitcoin</option>
                                <option value="YANDEXMONEY">Withdrawal YandexMoney</option>
                                <option value="MONETA">Withdrawal Moneta.ru</option>
                                <option value="SOFORT">Withdrawal Sofort</option>

                            </select>
                        </div>
                        <div class="reqs col-sm-3 withdrawal_methods_error">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wppal_03');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input readonly type="text" name="account_number" class="form-control round-0 numeric" id="accountNumber" data-accountnumber="<?= $account_number?>" data-balance="<?=$amount?>" value="<?php echo $currency."-". $account_number."[".$amount."]" ?>">
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label"><?=lang('wppal_04');?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input readonly value="<?php echo $amount ?>" type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3" id="amtWithdrawErr">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-4 control-label contest-label label-fee">Fee</label>
                        <div class="col-sm-5">
                            <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
                        </div>
                        <div class="col-sm-3"> <p class="fee-details"></p></div>
                    </div>
                    <div class="form-group">
                        <label for="new balance" class="col-sm-4 control-label contest-label"><?= lang('with-p-004');?></label>
                        <div class="col-sm-5">
                            <input value="0" type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                        </div>
                    </div>



                    <div class="form-group account_show">
                        <label  class="col-sm-4 control-label contest-label"> <span class="payment_system_name">account</span>  <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="paypal_account" class="form-control round-0" id="paypalAccount" placeholder="">
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>

                    <div class="credit_card">
                        <div class="form-group">
                            <label for="debitCreditCardNumber" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_05');?>  <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="card_number" value="1" class="form-control round-0 numeric" id="debitCreditCardNumber" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="debitCreditCardName" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_06');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="card_name" value="1" class="form-control round-0" id="debitCreditCardName" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_07');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select id="debitCreditExpiryMonth" name="card_expiry_month" class="form-control round-0"<?php echo $disabled ?>>

                                            <?php
                                            for ($m = 1; $m <= 12; $m++) {
                                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                echo '<option value="' . $m . '">' . $month . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="debitCreditExpiryYear" name="card_expiry_year" class="form-control round-0"<?php echo $disabled ?>>
                                           <?php
                                            $year = date('Y', strtotime(FXPP::getCurrentDateTime()));
                                            for ($y = 0; $y <= 10; $y++) {
                                                echo '<option value="' . ($year + $y) . '">' . ($year + $y) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="reqs col-sm-3">
                                <p class="field-req">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="bank_transfer">
                        <div class="form-group">
                            <label for="beneficiaryBank" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_05');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_bank" class="form-control round-0" id="beneficiaryBank" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryAddress" class="col-sm-4 control-label contest-label">
                                <!--                            --><?//=lang('wbt_06');?>
                                Beneficiary's Name
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_address" class="form-control round-0" id="beneficiaryAddress" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiarySwift" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_07');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_swift" class="form-control round-0" id="beneficiarySwift" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryAccount" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_08');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_account" class="form-control round-0" id="beneficiaryAccount" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"></label>
                            <div class="col-sm-5">
                                <label for="" class="control-label contest-label">
                                    <?=lang('wbt_09');?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryStreet" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_10');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_street" class="form-control round-0" id="beneficiaryStreet" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryCity" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_11');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_city" class="form-control round-0" id="beneficiaryCity" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryState" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_12');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_state" class="form-control round-0" id="beneficiaryState" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryCountry" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_13');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <select id="beneficiaryCountry" name="beneficiary_country" class="form-control round-0 "<?php echo $disabled ?>>
                                    <option value="">
                                        <?=lang('wbt_14');?>

                                    </option>
                                    <?php echo $countries; ?>
                                </select>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="beneficiaryPostal" class="col-sm-4 control-label contest-label">
                                <?=lang('wbt_15');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="beneficiary_postal" class="form-control round-0" id="beneficiaryPostal" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnInviteContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?=lang('wppal_06');?></a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">Invite friend bonus Withdrawal Option <span class="payment_method"></span></h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>


                            <?php $lng = array(
                                'NETELLER' => "wn_07",
                                'SKRILL' => "wskrill_07",
                                'PAYPAL' => "wppal_07",
                                'PAXUM' => "pax_08",
                                'CREDIT CARD' => "wdcc_11",
                                'MEGATRANSFER_CARD' => "wdcc_11",
                                'BANK TRANSFER' => "wbt_18",
                                'PAYCO' => "wpay_08",
                                'QIWI' => "qiwi_08",
                                'MEGATRANSFER' => "megatransfer_08",
                                'WEBMONEY' => "wwebm_08",
                                'MONETA' => "wmon_08",
                                'SOFORT' => "wsof_08",
                                'YANDEXMONEY' => "yandex_08",
                                'BITCOIN'=>'bitcoin_08'
                            );

                            foreach($lng as $key=>$d){ ?>
                               <span class="<?=$key;?> lan"> <i class="fa fa-info-circle "></i> <?=lang($d);?></span>

                            <?php }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wppal_08');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wppal_09');?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wppal_10');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
                        <div class="form-group account_show">
                            <label for="" class="col-sm-6 control-label contest-label"><span class="payment_system_name">account</span> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtPaypalAccount"></p>
                            </div>
                        </div>
                        <div class="credit_card">

                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_15');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtCardNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_16');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtCardName"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_17');?><span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtCardExpiry"></p>
                                </div>
                            </div>

                        </div>

                        <div class="bank_transfer">
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_05');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryBank"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_06');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryAddress"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_07');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiarySwift"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_08');?>

                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryAccount"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"></label>
                                <div class="col-sm-6">
                                    <label for="" class="control-label contest-label">
                                        <?=lang('wbt_09');?>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_27');?>

                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryStreet"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_28');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryCity"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_29');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryState"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_30');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryCountry"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label">
                                    <?=lang('wbt_31');?>
                                    <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtBeneficiaryPostal"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnInviteBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wppal_12');?></a>
                                <a id="btnInviteSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wppal_13');?></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">Invite friend bonus Withdrawal Option <span class="payment_method"></span></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wppal_15');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i> <?=lang('wppal_16');?>
                                    </div>
                                    <form class="form-horizontal form-success">

                                    <div class="bitcoin_success" style="display: none">
                                        <div class="form-group">
                                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('pax_20');?> <span class="reqs1">*</span></label>
                                            <div class="col-sm-6">
                                                <p class="bt-val" id="txtAccountNumberBitcin"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('wskrill_09');?> <span class="reqs1">*</span></label>
                                            <div class="col-sm-6">
                                                <p class="bt-val" id="txtAmountWithdrawBitcin"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('wwebm_10');?> <span class="reqs1">*</span></label>
                                            <div class="col-sm-6">
                                                <p class="bt-val" id="txtAmountDeductedBitcin"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="col-sm-6 control-label contest-label"> Bitcoin address <span class="reqs1">*</span></label>
                                            <div class="col-sm-6">
                                                <p class="bt-val" id="txtBitcoinAddress"></p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="all_paytype">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wppal_17');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtPaypalSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wppal_18');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group account_show">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><span class="payment_system_name"></span>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtPaypalSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">Account name:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtPaypalSuccessPaypalAccount"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wppal_21');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val txtPaypalSuccessTransactionNumber" id="txtPaypalSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="credit_card">

                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_25');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessCardNumber"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_26');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val txtPaypalSuccessTransactionNumber" id="txtDebitCreditSuccessTransactionNumber"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> Account name:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessCardName"></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_17');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtCardExpirySuccessTransactionNumber"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bank_transfer">
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_05');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryBankSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_06');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryAddressSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_07');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiarySwiftSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_08');?>

                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryAccountSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label"></label>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label contest-label">
                                                        <?=lang('wbt_09');?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_27');?>

                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryStreetSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_28');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryCitySuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_29');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryStateSuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_30');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryCountrySuccess"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label contest-label">
                                                    <?=lang('wbt_31');?>
                                                    <span class="reqs1">*</span></label>
                                                <div class="col-sm-6">
                                                    <p class="bt-val" id="txtBeneficiaryPostalSuccess"></p>
                                                </div>
                                            </div>
                                        </div>



                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('invite-friend/statistics')?>" class="create-another"><?=lang('wppal_22');?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">Invite friend bonus Withdrawal Option <span class="payment_method"></span><?php //=lang('wppal_23');?></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wppal_24');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('invite-friend/statistics')?>" class="create-another"><?=lang('wppal_25');?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>


<script>



    function payment_account( type){
        var accountName = '';
        switch (type) {
            case "CREDIT CARD":
                accountName = "Credit card";
                break;
            case "BANK TRANSFER":
                accountName = "Bank transfer";
                break;
            case "SKRILL":
                accountName = "Skrill account";
                break;
            case "NETELLER":
                accountName = "NETELLER Account ID or E-mail Address";
                break;
            case "PAXUM":
                accountName = "Paxum Account ID";
                break;
            case "PAYPAL":
                accountName = "Paypal acccount";
                break;
            case "WEBMONEY":
                accountName = "Webmoney purse or Email Address";
                break;
            case "PAYCO":
                accountName = "PayCo Wallet";
                break;
            case "QIWI":
                accountName = "QIWI Account";
                break;
            case "MEGATRANSFER":
                accountName = "MegaTransfer Username";
                break;
            case "BITCOIN":
                accountName = "Bitcoin Address";
                break;
            case "YANDEXMONEY":
                accountName = "Yandex.Money Wallet";
                break;
            case "MONETA":
                accountName = "Email Address or Phone number";
                break;
            case "SOFORT":
                accountName = "Sofort Account or Email Address";
                break;
        }
        return accountName;
    }


    $(document).on('change',"#withdrawal_methods",function(){

        var payment_system = $("#withdrawal_methods").val();

        if(payment_system == 0){
            return false;
        }
        $(".payment_method").text(" - "+payment_system);
        $('#loader-holder').show();
        $(".credit_card").hide();
        $(".label-fee").text('Fee');
        var currency = '<?=$currency?>';
        var amount = parseFloat("<?=$amount?>");
        var base_url = '<?=FXPP::ajax_url('withdraw/getTransactionFee');?>';
        $.post(base_url,{payment_system:payment_system,currency:currency,amount:amount},function(data){
           var rowFee = parseFloat(data.fee)*100;
            var fee =( parseFloat(<?=$amount?>) *parseFloat(data.fee)) + data.sys_fee;
            var addons = parseFloat(data.addons);
            var total = parseFloat(fee+addons);
            var waletAmount = amount.toFixed(4) - total.toFixed(4);

            if(waletAmount <0){
                waletAmount = 0;
            }
            $("#amountWithdraw").val(waletAmount.toFixed(4));
           // $("#accountNumber").attr("data-balance",parseFloat(waletAmount));
            $('.fee-details').text(rowFee.toFixed(4) + '% + '+ addons.toFixed(4) +'  <?=$currency?>');
            $("#tfee").val(total.toFixed(4));
            $(".payment_system_name").text( payment_account(payment_system));
            $(".lan").hide();
            $("."+payment_system).show();

            if(payment_system == 'BITCOIN'){
                $(".bitcoin_success").show();
                $(".all_paytype").hide();
            }else{
                $(".bitcoin_success").hide();
                $(".all_paytype").show();
            }

            if(payment_system == 'CREDIT CARD' || payment_system == 'BANK TRANSFER'){
                $(".credit_card").show();
                $(".account_show").hide();

                $("#debitCreditCardNumber").val('');
                $("#debitCreditCardName").val('');
                $("#paypalAccount").val(1);
                if(payment_system == 'CREDIT CARD'){
                    $(".CREDIT").show();
                    $(".bank_transfer").hide();
                }

                if(payment_system == 'BANK TRANSFER'){
                    $(".label-fee").text('BEN');
                    $(".credit_card").hide();
                    $(".bank_transfer").show();
                    $("#debitCreditCardNumber").val('1');
                    $("#debitCreditCardName").val('1');
                    $(".TRANSFER").show();

                }



            }else{

                $(".account_show").show();
                $("#paypalAccount").val('');
                $("#debitCreditCardNumber").val('1');
                $("#debitCreditCardName").val('1');
                $(".bank_transfer").hide();

            }
            $('#loader-holder').hide();

        },'json')


    })

    /** PAYPAL START */
    jQuery('#btnInviteContinue').click(function(){

        var total_input = jQuery('.withdraw_common :input').length;
        var payment_system = $("#withdrawal_methods").val();
        if(payment_system == 0){

            $(".withdrawal_methods_error").html('<p class="field-req">This field is required.</p>');
            return false;
        }else{
            $(".withdrawal_methods_error").html('');
        }

        if(payment_system == 'BANK TRANSFER'){
            var status = false;
            jQuery('.bank_transfer :input').each(function(index){

                if(!jQuery(this).val().length){
                    jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
                    status = true;
                }else{
                    jQuery(this).closest('div.form-group').children('div.reqs').html('');
                }})
            console.log(status);
            if( status){ return false;}

        }

        jQuery('.withdraw_common :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val())+ parseFloat($("#tfee").val());
                    var result = (!isNaN(debitAmount) && walletBalance.toFixed(4) >= debitAmount.toFixed(4) && walletBalance>0) ? true : false;

                    if(!result){
                        jQuery('#amtWithdrawErr').html('<p class="field-req"> Insufficient fund.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                console.log("total input"+total_input+"===" +index);
                if(!jQuery('.withdraw_common p.field-req').length){

                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat( $("#tfee").val());

                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4));
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountDeducted.toFixed(4)));
                    jQuery('#txtPaypalAccount').html(jQuery('#paypalAccount').val());
                    jQuery('#txtCardNumber').html(jQuery('#debitCreditCardNumber').val());
                    jQuery('#txtCardName').html(jQuery('#debitCreditCardName').val());
                    jQuery('#txtCardExpiry').html(jQuery('#debitCreditExpiryMonth').val()+"-"+ jQuery('#debitCreditExpiryYear').val());

                    jQuery('#txtBeneficiaryBank').html(jQuery('#beneficiaryBank').val());
                    jQuery('#txtBeneficiaryAddress').html(jQuery('#beneficiaryAddress').val());
                    jQuery('#txtBeneficiarySwift').html(jQuery('#beneficiarySwift').val());
                    jQuery('#txtBeneficiaryAccount').html(jQuery('#beneficiaryAccount').val());
                    jQuery('#txtBeneficiaryStreet').html(jQuery('#beneficiaryStreet').val());
                    jQuery('#txtBeneficiaryCity').html(jQuery('#beneficiaryCity').val());
                    jQuery('#txtBeneficiaryState').html(jQuery('#beneficiaryState').val());
                    jQuery('#txtBeneficiaryCountry').html(jQuery('#beneficiaryCountry').val());
                    jQuery('#txtBeneficiaryPostal').html(jQuery('#beneficiaryPostal').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnInviteBack').click(function(){
        //jQuery('#frmWithdrawPaypal :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});

        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnInviteSendRequest').click(function(){
        jQuery('.withdraw_common :input').each(function(index){
            var total_input = jQuery('.withdraw_common :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('.withdraw_common p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var id = <?=$this->input->get('id');?> ;
                    var type = $("#withdrawal_methods").val();


                    var amountWithdraw = $('#amountWithdraw').val();
                    var pay_account = $("#paypalAccount").val();
                    var card_number = $("#debitCreditCardNumber").val();
                    var card_name = $("#debitCreditCardName").val();
                    var card_expiry_month = $("#debitCreditExpiryMonth").val();
                    var card_expiry_year = $("#debitCreditExpiryYear").val();

                    var beneficiaryBank = jQuery('#beneficiaryBank').val();
                    var beneficiaryAddress = jQuery('#beneficiaryAddress').val();
                    var beneficiarySwift = jQuery('#beneficiarySwift').val();
                    var beneficiaryAccount = jQuery('#beneficiaryAccount').val();
                    var beneficiaryStreet = jQuery('#beneficiaryStreet').val();
                    var beneficiaryCity = jQuery('#beneficiaryCity').val();
                    var beneficiaryState = jQuery('#beneficiaryState').val();
                    var beneficiaryCountry = jQuery('#beneficiaryCountry').val();
                    var beneficiaryPostal = jQuery('#beneficiaryPostal').val();

                    var url = "<?=FXPP::ajax_url();?>";
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addInviteFriendBonus",
                        data: {id:id,type:type,amountWithdraw:amountWithdraw,pay_account:pay_account,card_number:card_number,card_name:card_name,card_expiry_month:card_expiry_month,card_expiry_year:card_expiry_year,beneficiaryBank:beneficiaryBank,
                        beneficiaryAddress:beneficiaryAddress,beneficiarySwift:beneficiarySwift,beneficiaryAccount:beneficiaryAccount,beneficiaryStreet:beneficiaryStreet,beneficiaryCity:beneficiaryCity,
                            beneficiaryState:beneficiaryState,beneficiaryCountry:beneficiaryCountry,beneficiaryPostal:beneficiaryPostal},
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtPaypalSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(4));
                                jQuery('#txtPaypalSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtPaypalSuccessPaypalAccount').html(x.transaction_data.client_inf);
                                jQuery('.txtPaypalSuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtDebitCreditSuccessCardNumber').html(jQuery('#debitCreditCardNumber').val());
                                jQuery('#txtDebitCreditSuccessCardName').html(jQuery('#debitCreditCardName').val());
                                jQuery('#txtCardExpirySuccessTransactionNumber').html(jQuery('#debitCreditExpiryMonth').val()+"-"+ jQuery('#debitCreditExpiryYear').val());

                                jQuery('#txtBeneficiaryBankSuccess').html(jQuery('#beneficiaryBank').val());
                                jQuery('#txtBeneficiaryAddressSuccess').html(jQuery('#beneficiaryAddress').val());
                                jQuery('#txtBeneficiarySwiftSuccess').html(jQuery('#beneficiarySwift').val());
                                jQuery('#txtBeneficiaryAccountSuccess').html(jQuery('#beneficiaryAccount').val());
                                jQuery('#txtBeneficiaryStreetSuccess').html(jQuery('#beneficiaryStreet').val());
                                jQuery('#txtBeneficiaryCitySuccess').html(jQuery('#beneficiaryCity').val());
                                jQuery('#txtBeneficiaryStateSuccess').html(jQuery('#beneficiaryState').val());
                                jQuery('#txtBeneficiaryCountrySuccess').html(jQuery('#beneficiaryCountry').val());
                                jQuery('#txtBeneficiaryPostalSuccess').html(jQuery('#beneficiaryPostal').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');


                                // bitcoin_success
                                jQuery('#txtAccountNumberBitcin').html($('#accountNumber').data('accountnumber'));
                                jQuery('#txtAmountWithdrawBitcin').html(parseFloat(amount_requested).toFixed(4));
                                jQuery('#txtAmountDeductedBitcin').html(parseFloat(amount_requested).toFixed(4));
                                jQuery('#txtBitcoinAddress').html(jQuery('#paypalAccount').val());





                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab4').addClass('active');
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** PAYPAL END */


    function roundtoTwo( value ){
        return +(Math.round(value + "e+2") + "e-2");
    }

</script>

<style>
    .payment_system_name{ text-transform: capitalize;}
    .lan{display: none;}
    .credit_card{display: none}
    .bank_transfer{display: none}
</style>
