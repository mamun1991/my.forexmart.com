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
                        <h4 class="with-title"> Withdrawal Option - Visa/Mastercard</h4>
                        <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawDebitCredit')) ?>
                        <?php if(!$disable_input){ ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger" role="alert"> <?=lang('wdcc_01');?></div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div id="reqLabel" class="form-group">
                                <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">*  <?=lang('wdcc_02');?></span></label>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_03');?>  <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <?php echo $getAllAccountNumber; ?>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>

                        <input type="hidden" name="amount_deducted" value="0">
                        <div class="form-group">
                            <input type="hidden" name="card_opt" value="zp">
                            <label for="amountWithdraw" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_04');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>

                            </div>
                            <div class="reqs col-sm-3" id="amtWithdrawErr">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fee" class="col-sm-4 control-label contest-label">Fee</label>
                            <div class="col-sm-5">
                                <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
                            </div>
                            <div class="col-sm-3"> <p class="fee-details"><?php echo $fee_details; ?></p></div>
                        </div>
                        <div class="form-group">
                            <label for="new balance" class="col-sm-4 control-label contest-label"><?= lang('with-p-004');?></label>
                            <div class="col-sm-5">
                                <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="debitCreditCardNumber" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_05');?>  <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="card_number" class="form-control round-0 numeric" id="debitCreditCardNumber" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="debitCreditCardName" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_06');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="card_name" class="form-control round-0" id="debitCreditCardName" placeholder=""<?php echo $disabled ?>>
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
                                            <option value=""> <?=lang('wdcc_08');?> </option>
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
                                            <option value=""> <?=lang('wdcc_09');?> </option>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"></label>
                            <div class="col-sm-5">
                                <a id="btnDebitCreditContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>  <?=lang('wdcc_10');?></a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                        <h4 class="with-title"> Withdrawal Option - Visa/Mastercard</h4>
                        <form class="form-horizontal reg-frm">
                            <div class="alert alert-info" role-alert>
                                <i class="fa fa-info-circle"></i>  <?=lang('wdcc_11');?>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_12');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAccountNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_13');?><span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAmountWithdraw"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"> <?=lang('wdcc_14');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAmountDeducted"></p>
                                </div>
                            </div>
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
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"></label>
                                <div class="col-sm-6">
                                    <a id="btnDebitCreditBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wdcc_18');?></a>
                                    <a id="btnDebitCreditSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wdcc_19');?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                        <h4 class="with-title"> Withdrawal Option - Visa/Mastercard</h4>
                        <div class="panel panel-default round-0">
                            <div class="panel-heading">
                                <b> <?=lang('wdcc_20');?></b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8 col-centered">
                                        <div class="alert alert-success" role="alert">
                                            <i class="fa fa-check-circle"></i> <?=lang('wdcc_21');?>
                                        </div>
                                        <form class="form-horizontal form-success">
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_22');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessAmountRequested"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"> <?=lang('wdcc_23');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtSuccessFee"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_24');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessAccountNumber"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_25');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessCardNumber"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="col-sm-6 control-label"> <?=lang('wdcc_26');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtDebitCreditSuccessTransactionNumber"></p>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="btn-create-another">
                                            <a href="<?php echo base_url('withdraw/zotapay_card')?>" class="create-another"> <?=lang('wdcc_27');?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                        <h4 class="with-title"> <?=lang('wdcc_00');?></h4>
                        <div class="panel panel-default round-0">
                            <div class="panel-heading">
                                <b> <?=lang('wdcc_28');?></b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8 col-centered">
                                        <div class="alert alert-danger" role="alert">
                                            <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                        </div>
                                        <div class="btn-create-another">
                                            <a href="<?php echo base_url('withdraw/debit-credit-cards')?>" class="create-another"> <?=lang('wdcc_29');?></a>
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

    <script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>
