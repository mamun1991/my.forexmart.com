<style>
    .alert-danger p{
        display: inline;
    }

    @media  screen and (min-width: 1138px)  {
        .cup-label-acc{
            padding-right: 0px !important;
        }
    }

</style>
<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
if(IPLoc::Office()){
//    print_r($cup_details);
}
?>
<?php $this->load->view('finance_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">Withdraw via local bank transfer in VND <?php //echo lang('chinapay-opt-01') ?></h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawVndAsia')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert"><?= lang('wbt_01') ?> <?php //echo lang('chinapay-opt-01') ?></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="reqLabel" class="form-group">
                            <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">*<?= lang('with-p-01') ?></span></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"><?= lang('with-p-02') ?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <?php echo $getAllAccountNumber; ?>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label"><?= lang('with-p-03') ?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3" id="amtWithdrawErr">

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-4 control-label contest-label"><?= lang('with-p-04') ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="tfee" class="form-control round-0" id="tfee" readonly>
                        </div>
                        <div class="col-sm-3"> <p class="fee-details"><?php echo $fee_details; ?></p></div>
                    </div>
                    <div class="form-group">
                        <label for="new balance" class="col-sm-4 control-label contest-label"><?= lang('with-p-004') ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly>
                        </div>
                    </div>




                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"> <?= lang('with_04') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_account_name" class="form-control round-0" id="bank_account_name" placeholder="" value="<?php echo set_value('bank_account_name') ?>"<?php echo $disabled ?>>

                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with_03') ?><span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_name" class="form-control round-0" id="bank_name" placeholder="" value="<?php echo set_value('bank_name') ?>"<?php echo $disabled ?>>

                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"><?= lang('with_01') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="vndasia_account" class="form-control round-0 numeric" id="vndasia_account" placeholder="" value="<?php echo set_value('bank_account_number') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label"> <?= lang('with_02') ?>  <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_branch" class="form-control round-0" id="bank_branch" placeholder="" value="<?php echo set_value('branch') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label">  <?= lang('with_06') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_province" class="form-control round-0" id="bank_province" placeholder="" value="<?php echo set_value('province') ?>"<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="yandex_wallet" class="col-sm-4 cup-label-acc control-label contest-label">  <?= lang('with_05') ?> <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bank_city" class="form-control round-0" id="bank_city" placeholder="" value="<?php echo set_value('city') ?>" <?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnVndAsiaContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?> > <?= lang('with-p-05') ?> </a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title"> Withdraw via local bank transfer in VND <?php //echo  lang('chinapay-opt-01') ?> </h4>
                    <form class="form-horizontal reg-frm">
                        <div class="alert alert-info" role-alert>
                            <i class="fa fa-info-circle"></i> You are about to withdraw funds to your local bank tranfer VND. This will be processed within 48 hours. Please make sure the information below is correct and complete. <?php //echo  lang('chinapay-opt-03') ?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-06') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-07') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"><?= lang('with-p-08') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_04') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankAccountName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"> <?= lang('with_03') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankName"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_01') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtVndAsiaAccount"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"> <?= lang('with_02') ?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankBranch"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">  <?= lang('with_06') ?><span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankProvince"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">   <?= lang('with_05') ?> <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBankCity"></p>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnVndAsiaBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option" style="margin-right: 10px;"> <?=lang('wn_12');?> </a>
                                <a id="btnVndAsiaSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option"> <?=lang('wn_13');?> </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">Withdraw via local bank transfer in VND  <?php //echo  lang('chinapay-opt-01') ?>  </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b> <?= lang('with-p-09') ?>  </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i> <?= lang('with-p-10') ?>
                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-11') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtVndAsiaSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-12') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"><?= lang('with-p-13') ?></label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtVndAsiaSuccessForexAccountNumber"></p>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_04') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankAccountNameSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_03') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankNameSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_01') ?>: </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtVndAsiaaccSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_02') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankBranchSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_06') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankProvinceSuccess"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label"> <?= lang('with_05') ?> : </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtBankCitySuccess"></p>
                                            </div>
                                        </div>



                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/payment-asia')?>" class="create-another"><?= lang('with-p-16') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">   Withdraw via local bank transfer in VND <?php // echo lang('chinapay-opt-01') ?> </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b> <?= lang('with-p-166') ?></b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i> <span id="customError"></span>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/payment-asia')?>" class="create-another"> <?= lang('with-p-16') ?></a>
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