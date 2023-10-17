
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
    .btn-withdraw-option{
        margin: 0 2px;
    }

</style>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-12 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">
                        <?=lang('wwebm_00');?>

                    </h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawWebmoney')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <?=lang('wwebm_01');?>

                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">
                                    * <?=lang('wwebm_02');?>
                                </span></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label">
                            <?=lang('wwebm_03');?>

                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <?php echo $getAllAccountNumber; ?>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label">
                            <?=lang('wwebm_04');?>

                            <span class="reqs1">*</span></label>
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
                        <label for="webmoneyPurse" class="col-sm-4 control-label contest-label">
                            Email address
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="webmoney_email" class="form-control round-0" id="webmoneyEmail" placeholder="" >
                        </div>
                        <div class="reqs col-sm-3"> </div>
                    </div>

                    <div class="form-group">
                        <label for="webmoneyPurse" class="col-sm-4 control-label contest-label">
                            Client's purse number
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="webmoney_purse" class="form-control round-0" id="webmoneyPurse" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3"> </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnWebmoneyContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>
                                <?=lang('wwebm_06');?>

                            </a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">
                        <?=lang('wwebm_07');?>

                    </h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i>
                            <?=lang('wwebm_08');?>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">

                                <?=lang('wwebm_09');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wwebm_10');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wwebm_11');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                Email Address
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtWebmoneyEmail"></p>
                            </div>
                        </div>
                        <!--- END ---->
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                Client's purse number

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtWebmoneyPurse"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnWebmoneyBack"  aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option" >
                                    <?=lang('wwebm_13');?>
                                </a>
                                <a id="btnWebmoneySendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wwebm_14');?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">
                        <?=lang('wwebm_15');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wwebm_16');?>

                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i>
                                        <?=lang('wwebm_17');?>

                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wwebm_18');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtWebmoneySuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wwebm_19');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wwebm_20');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtWebmoneySuccessAccountNumber"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                Email Address:
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtWebmoneySuccessWebmoneyEmail"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                Client's purse number:
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtWebmoneySuccessWebmoneyPurse"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wwebm_22');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtWebmoneySuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/webmoney')?>" class="create-another">
                                            <?=lang('wwebm_23');?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">
                        <?=lang('wwebm_24');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wwebm_25');?>

                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        =======
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>

                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/webmoney')?>" class="create-another">
                                            <?=lang('wwebm_27');?>
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

<script src="<?php echo base_url('assets/js/custom-withdraw.js')?>"></script>