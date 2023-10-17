<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>
<?php $this->load->view('finance_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title"><?=lang('wunip_00');?></h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawUnionpay')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert"><?=lang('wunip_01');?></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* <?=lang('wunip_02');?></span></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="accountNumber" class="col-sm-4 control-label contest-label"><?=lang('wunip_03');?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <select name="account_number" id="accountNumber" class="form-control round-0"<?php echo $disabled ?>><?php echo $getAllAccountNumber; ?></select>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_04');?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>
                            <!--                                <input type="hidden" name="amount_receive" value="0">-->
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_05');?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_name" class="form-control round-0" id="beneficiaryName" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_06');?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_account" class="form-control round-0" id="bankAccount" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_07');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_name" class="form-control round-0" id="bankName" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_08');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_branch" class="form-control round-0" id="bankBranch" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_09');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_province" class="form-control round-0" id="bankProvince" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wunip_10');?>City <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_city" class="form-control round-0" id="bankCity" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnUnionpayContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?=lang('wunip_11');?></a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title"><?=lang('wunip_00');?></h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i> <?=lang('wunip_12');?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_13');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_14');?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_15');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountReceive"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_16');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_17');?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankAccount"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_18');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_19');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankBranch"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_20');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankProvince"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wunip_21');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankCity"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnUnionpayBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wunip_22');?></a>
                                <a id="btnUnionpaySendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wunip_23');?></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title"><?=lang('wunip_00');?></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wunip_24');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i> <?=lang('wunip_25');?>
                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_26');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtUnionpaySuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_27');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtUnionpaySuccessAmountWithdraw"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_28');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtUnionpaySuccessAmountReceive"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_29');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_30');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtUnionpaySuccessBankAccount"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wunip_31');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtUnionpaySuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/unionpay')?>" class="create-another"><?=lang('wunip_32');?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title"><?=lang('wunip_33');?></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wunip_34');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i><?=lang('wunip_35');?>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/unionpay')?>" class="create-another"><?=lang('wunip_36');?></a>
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