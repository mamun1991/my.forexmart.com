<?php
    // $disabled = $disable_input ? '' : ' disabled="disabled"';
    $disabled = $disable_input ? '' : '';
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
                        <?=lang('wsof_00');?>
                    </h4>
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawSofort2')) ?>
                    <?php if(!$disable_input){ ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <?=lang('wbt_01');?>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                    <div id="reqLabel" class="form-group">
                        <label class="col-sm-12 control-label contest-label req2"><span class="reqs1">
                                * <?=lang('wbt_02');?>
                            </span></label>
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
                        <label for="amountWithdraw" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_04');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="amount_withdraw" class="form-control round-0 numeric" id="amountWithdraw" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3" id="amtWithdrawErr">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fee" class="col-sm-4 control-label contest-label">BEN</label>
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
                        <label for="beneficiaryBankSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_05');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_bankSofort" class="form-control round-0" id="beneficiaryBankSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beneficiaryAddressSofort" class="col-sm-4 control-label contest-label">
<!--                            --><?//=lang('wbt_06');?>
                            Beneficiary's Name
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_addressSofort" class="form-control round-0" id="beneficiaryAddressSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beneficiarySwiftSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_07');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_swiftSofort" class="form-control round-0" id="beneficiarySwiftSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="ibanoraccountNumberSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_47');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="ibanoraccount_numberSofort" class="form-control round-0" id="ibanoraccountNumberSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="bicCodeSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_48');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bic_codeSofort" class="form-control round-0" id="bicCodeSofort" placeholder=""<?php echo $disabled ?>>
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
                        <label for="beneficiaryStreetSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_10');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_streetSofort" class="form-control round-0" id="beneficiaryStreetSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beneficiaryCitySofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_11');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_citySofort" class="form-control round-0" id="beneficiaryCitySofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beneficiaryStateSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_12');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_stateSofort" class="form-control round-0" id="beneficiaryStateSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="beneficiaryCountrySofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_13');?>

                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <select id="beneficiaryCountrySofort" name="beneficiary_countrySofort" class="form-control round-0 "<?php echo $disabled ?>>
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
                        <label for="beneficiaryPostalSofort" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_15');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="beneficiary_postalSofort" class="form-control round-0" id="beneficiaryPostalSofort" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">&nbsp;</div>
                        <div class="col-sm-8" style="font-size: 11px">Bank can charge additional fees upon withdrawal.</div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnContinue2" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>Continue</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">

                        <?=lang('wsof_00');?>
                    </h4>
                    <form id="frmReview" class="form-horizontal reg-frm">
                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-info-circle"></i>
                            <?=lang('wbt_18');?>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_19');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAccountNumberSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_20');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdrawSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_21');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeductedSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_05');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryBankSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_06');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryAddressSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_07');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiarySwiftSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_47');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtIbanorAccountNumberSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_48');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBicCodeSofort"></p>
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
                                <p class="bt-val" id="txtBeneficiaryStreetSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_28');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryCitySofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_29');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryStateSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_30');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryCountrySofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_31');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBeneficiaryPostalSofort"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnBack2" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wbt_32');?>
                                </a>
                                <a id="btnSendRequest2" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wbt_33');?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">
                        <?=lang('wsof_00');?>
                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wbt_35');?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check-circle"></i>
                                        <?=lang('wbt_36');?>
                                    </div>
                                    <form class="form-horizontal form-success">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_37');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSofortSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_38');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSofortSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_39');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSofortSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                IBAN Or Account number:
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSofortSuccessBankAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_41');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSofortSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/sofort2')?>" class="create-another">
                                            <?=lang('wbt_42');?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab4">
                    <h4 class="with-title">
                        <?=lang('wbt_43');?>

                    </h4>
                    <div class="panel panel-default round-0">
                        <div class="panel-heading">
                            <b>
                                <?=lang('wbt_44');?>
                            </b>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8 col-centered">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <?=lang('wbt_45');?>
                                    </div>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/sofort2')?>" class="create-another">
                                            <?=lang('wbt_46');?>
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