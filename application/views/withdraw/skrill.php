
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
                    <h4 class="with-title"><?=lang('wskrill_00');?></h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawSkrill')) ?>

                    <input type="hidden" id="skrill_fee_limit" value="<?php echo $skrill_fee_limit ?>" />

                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert"><?=lang('wskrill_01');?></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* <?=lang('wskrill_02');?></span></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?=lang('wskrill_03');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <?php echo $getAllAccountNumber; ?>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label"><?=lang('wskrill_04');?> <span class="reqs1">*</span></label>
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
                        <label for="skrillAccount" class="col-sm-4 control-label contest-label"><?=lang('wskrill_05');?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="skrill_account" class="form-control round-0" id="skrillAccount" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnSkrillContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?=lang('wskrill_06');?></a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title"><?=lang('wskrill_00');?></h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i><?=lang('wskrill_07');?> 
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wskrill_08');?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wskrill_09');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wskrill_10');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?=lang('wskrill_11');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtSkrillAccount"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnSkrillBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wskrill_12');?></a>
                                <a id="btnSkrillSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wskrill_13');?></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title"><?=lang('wskrill_00');?></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wskrill_14');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i> <?=lang('wskrill_15');?>
                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wskrill_16');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSkrillSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wskrill_17');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wskrill_18');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSkrillSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wskrill_19');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSkrillSuccessSkrillAccount"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wskrill_20');?>:</label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSkrillSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/skrill')?>" class="create-another"><?=lang('wskrill_21');?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title"><?=lang('wskrill_00');?></h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b><?=lang('wskrill_22');?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/skrill')?>" class="create-another"><?=lang('wskrill_23');?></a>
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
    var site_url = '<?php echo FXPP::ajax_url(); ?>';
</script>
<script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>