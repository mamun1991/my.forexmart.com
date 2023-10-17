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
    .transit {
        /*margin-top: 35px;*/
    }
    .td-hd {
        text-align: right;
        font-weight: bold;
    }
    .modal-show-title {
        font-style: italic;
    }
    .reg-link-error {
        color: #ff0000;
        font-family: Open Sans;
        font-size: 13px;
        margin-top: 7px;
    }
    .radio {
        margin-bottom: 20px;
    }
</style>
<div class="tab-content acct-cont">
        <div role="tabpanel" class="tab-pane active" id="tab1">
            <div class="banktrans-option" id="bt">
                <div class="row tab-content">
                    <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                        <h4 class="with-title"><?=lang('wpay_00');?></h4>
                        <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawPayCo')) ?>
                        <?php if(!$disable_input){ ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger" role="alert"><?=lang('wpay_01');?></div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div id="reqLabel" class="form-group">
                                <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">* <?=lang('wpay_02');?></span></label>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"><?=lang('wpay_03');?><span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <?php echo $getAllAccountNumber; ?>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amountWithdraw" class="col-sm-4 control-label contest-label"><?=lang('wpay_04');?> <span class="reqs1">*</span></label>
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
                            <label for="paycoWallet" class="col-sm-4 control-label contest-label"><?=lang('wpay_05');?> <span class="reqs1">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" name="payco_wallet" class="form-control round-0" id="paycoWallet" placeholder=""<?php echo $disabled ?>>
                            </div>
                            <div class="reqs col-sm-3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label contest-label"></label>
                            <?php if (($this->session->userdata('user_id') == 54838 || $this->session->userdata('user_id') == 54834) && ($its_activated != false) && ($mpr == false)) { ?>
                                <div class="col-sm-5">
                                    <a id="btnPayCoContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option pull-left"<?php echo $disabled ?>><?=lang('wpay_06');?></a>
                                    <a class="btn-withdraw-option pull-right" data-toggle="modal" data-target="#getlink-modal">Get Link</a>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-5">
                                    <a id="btnPayCoContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>><?=lang('wpay_06');?></a>
                                </div>
                            <?php } ?>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                        <h4 class="with-title"><?=lang('wpay_07');?></h4>
                        <form class="form-horizontal reg-frm">
                            <div class="alert alert-info" role-alert>
                                <i class="fa fa-info-circle"></i><?=lang('wpay_08');?>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"><?=lang('wpay_09');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAccountNumber"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"><?=lang('wpay_10');?><span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAmountWithdraw"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"><?=lang('wpay_11');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtAmountDeducted"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"><?=lang('wpay_12');?> <span class="reqs1">*</span></label>
                                <div class="col-sm-6">
                                    <p class="bt-val" id="txtPayCoWallet"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-6 control-label contest-label"></label>
                                <div class="col-sm-6">
                                    <a id="btnPayCoBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_13');?></a>
                                    <a id="btnPayCoSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"><?=lang('wpay_14');?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                        <h4 class="with-title"><?=lang('wpay_0');?></h4>
                        <div class="panel panel-default round-0">
                            <div class="panel-heading">
                                <b><?=lang('wpay_15');?></b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8 col-centered">
                                        <div class="alert alert-success" role="alert">
                                            <i class="fa fa-check-circle"></i> <?=lang('wpay_16');?>
                                        </div>
                                        <form class="form-horizontal">
                                            <div class="form-group form-success">
                                                <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_17');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtPayCoSuccessAmountRequested"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_18');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtSuccessFee"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_19');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtPayCoSuccessAccountNumber"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_20');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtPayCoSuccessPayCoWallet"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-6 control-label"><?=lang('wpay_21');?>:</label>
                                                <div class="col-sm-6">
                                                    <p class="frm-val" id="txtPayCoSuccessTransactionNumber"></p>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="btn-create-another">
                                            <a href="<?php echo FXPP::loc_url('withdraw/payco')?>" class="create-another"><?=lang('wpay_22');?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                        <h4 class="with-title"><?=lang('wpay_00');?></h4>
                        <div class="panel panel-default round-0">
                            <div class="panel-heading">
                                <b><?=lang('wpay_23');?></b>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8 col-centered">
                                        <div class="alert alert-danger" role="alert">
                                            <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                        </div>
                                        <div class="btn-create-another">
                                            <a href="<?php echo FXPP::loc_url('withdraw/payco')?>" class="create-another"><?=lang('wpay_25');?></a>
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

<div class="modal fade" id="getlink-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close supresscookies" data-dismiss="modal" aria-label="Close" id="modal_close_top"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title">
                    <img src="https://my.forexmart.com/assets/images/payco.png" class="img-reponsive payco-img" width="95px">
                    Registration Link
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="reg-div">
                    <div style="border-bottom: 1px solid #dfdfdf; padding-bottom: 5px; font-size: 15px;">
                        Use <b>PayCo Registration Link</b> to use Transit Transfer feature.
                    </div
                    <form action="" method="post" class="form-horizontal" id="myForm">
                        <div>
                            <div class="col-sm-offset-1 col-md-offset-1 col-xs-12 col-sm-11 col-md-11">
                                <h5>Please enter your preferred PayCo Email below:</h5>
                                <div class="col-xs-12 col-sm-8 col-md-8" id="input">
                                    <input type="email" name="preferred_email" class="form-control" id="email_input" autocomplete="off">
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <button type="button" class="btn-submit" id="btn-submit">Send</button>
                                </div>
                                <div class="reg-link-error col-md-11"></div>
                            </div>
                            <span class="clearfix"></span>
                        </div>
                    </form>
                </div>
                <div class="load-div">
                    <div class="small-loader col-md-12" style="display: none; text-align: center; font-weight: bold;">
                        <img src="<?= $this->template->Images()?>small-loader.gif" width="38">
                        <br/>Loading...
                    </div>
                    <span class="clearfix"></span>
                    <div class="msg-div"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close_bottom">Close</button>
            </div>
        </div>
    </div>
</div>

<?php /** Preloader Modal Start */ ?>

<?php /** Preloader Modal End */ ?>
<script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>
<script src="<?php echo base_url('assets/js/custom-its.js')?>"></script>