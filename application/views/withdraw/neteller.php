
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
                    <h4 class="with-title">
                        <?=lang('wn_00_t');?>

                    </h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawNeteller')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <?=lang('wn_00');?>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <div class="form-group" style="text-align: center;">
                        <img src="http://mrc.neteller.com/neteller.image/325.jpg" border="0" alt="" />
                    </div>

                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label contest-label">
                                <?=lang('wn_02');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-4">
<!--                                <select name="account_number" id="accountNumber" class="form-control round-0"--><?php //echo $disabled ?><!--><?php //echo $getAllAccountNumber; ?><!--</select>-->
                                <?php echo $getAllAccountNumber; ?>

                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amountWithdraw" class="col-sm-5 control-label contest-label">

                                <?=lang('wn_03');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder="" <?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3" id="amtWithdrawErr">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fee" class="col-sm-5 control-label contest-label">Fee</label>
                            <div class="col-sm-4">
                                <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
                            </div>
                            <div class="col-sm-3"> <p class="fee-details"><?php echo $fee_details; ?></p></div>
                        </div>
                        <div class="form-group">
                            <label for="new balance" class="col-sm-5 control-label contest-label"><?= lang('with-p-004');?></label>
                            <div class="col-sm-4">
                                <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="netellerID" class="col-sm-5 control-label contest-label" style="white-space: nowrap;">

                                <?=lang('wn_04');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="neteller_id" class="form-control round-0" id="netellerID" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">

                                    <a id="btnNetellerContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option btn-submit"<?php echo $disabled ?>>
                                        <?=lang('wn_05');?>

                                    </a>
                            </div><div class="clearfix"></div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">

                        <?=lang('wn_06');?>
                    </h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i>
                            <?php if(IPLoc::Office() && (FXPP::html_url() == 'sa' || FXPP::html_url() == 'pk')) {
                                echo 'You are about to withdraw funds to your Neteller account. This will be processed within 1-7 working hours. Please make sure the information below is correct and complete.';
                            }else{?>
                                <?=lang('wn_07');?>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">

                                <?=lang('wn_08');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">

                                <?=lang('wn_09');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wn_10');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wn_11');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtNetellerID"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnNetellerBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wn_12');?></a>
                                <a id="btnNetellerSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wn_13');?></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">
                        <?=lang('wn_14');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wn_15');?>

                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i>
                                        <?=lang('wn_16');?>

                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">

                                                <?=lang('wn_17');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtNetellerSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">

                                                <?=lang('wn_18');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wn_19');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtNetellerSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wn_20');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtNetellerSuccessNetellerID"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wn_21');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtNetellerSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/neteller')?>" class="create-another">
                                            <?=lang('wn_22');?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">
                        <?=lang('wn_23');?>
                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wn_24');?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/neteller')?>" class="create-another">
                                            <?=lang('wn_26');?>
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

<script src="<?php echo base_url('assets/js/custom-neteller-withdraw.js')?>"></script>
