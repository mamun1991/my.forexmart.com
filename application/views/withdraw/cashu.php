<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>
<?php $this->load->view('finance_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">
                        <?=lang('wcu_00');?>
                    </h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawCashu')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <?=lang('wcu_01');?>

                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">
                                    * <?=lang('wcu_02');?>
                                </span></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label">
                            <?=lang('wcu_03');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <?php echo $getAllAccountNumber; ?>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label">
                            <?=lang('wcu_04');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>

                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-4 control-label contest-label">Fee</label>
                        <div class="col-sm-5">
                            <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new balance" class="col-sm-4 control-label contest-label"><?= lang('with-p-004');?></label>
                        <div class="col-sm-5">
                            <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cashuAccount" class="col-sm-4 control-label contest-label">
                            <?=lang('wcu_05');?>

                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="cashu_account" class="form-control round-0" id="cashuAccount" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnCashuContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>
                                <?=lang('wcu_06');?>

                            </a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">
                        <?=lang('wcu_07');?>

                    </h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i>
                            <?=lang('wcu_08');?>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">

                                <?=lang('wcu_09');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wcu_10');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wcu_11');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">

                                <?=lang('wcu_12');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtCashuAccount"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnCashuBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wcu_13');?>

                                </a>
                                <a id="btnCashuSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wcu_14');?>

                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">
                        <?=lang('wcu_15');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wcu_16');?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i>
                                        <?=lang('wcu_17');?>

                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wcu_18');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtCashuSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wcu_19');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wcu_20');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtCashuSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wcu_21');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtCashuSuccessCashuAccount"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wcu_22');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtCashuSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/cashu')?>" class="create-another">
                                            <?=lang('wcu_23');?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">
                        <?=lang('wcu_24');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wcu_25');?>

                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <?=lang('wcu_26');?>

                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/cashu')?>" class="create-another">
                                            <?=lang('wcu_27');?>
                                        </a>
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

<script src="<?php echo FXPP::loc_url('assets/js/custom-withdraw.js')?>"></script>