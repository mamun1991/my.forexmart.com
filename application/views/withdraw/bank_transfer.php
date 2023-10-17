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
    .errorClass { border:  1px solid red; }
</style>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="banktrans-option" id="bt">
            <div class="row tab-content">
                <div class="col-md-11 col-centered tab-pane active" id="bt-tab1">
                    <h4 class="with-title">
                        <?=lang('wbt_00');?>                        
                    </h4>
                    <input type="hidden" name="hidden-lang" id="hidden-lang" value = "<?= FXPP::html_url()?>">
                    <?php echo form_open(base_url('/withdraw'), array('class' => 'form-horizontal reg-frm', 'id' => 'frmWithdrawBankTransfer')) ?>
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
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert" id="bank-wire-error" style="display: none;text-align: center;"></div>
                        </div>
                    </div>
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
                            <?=lang('wbt_06');?>
<!--                            Beneficiary's Name-->
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
                        <label for="ibanoraccountNumber" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_47');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="ibanoraccount_number" class="form-control round-0" id="ibanoraccountNumber" placeholder=""<?php echo $disabled ?>>
                        </div>
                        <div class="reqs col-sm-3">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="bicCode" class="col-sm-4 control-label contest-label">
                            <?=lang('wbt_48');?>
                            <span class="reqs1">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" name="bic_code" class="form-control round-0" id="bicCode" placeholder=""<?php echo $disabled ?>>
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
                    <div class="form-group">
                        <div class="col-sm-4">&nbsp;</div>
                        <div class="col-sm-8" style="font-size: 11px">Bank can charge additional fees upon withdrawal.</div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label contest-label"></label>
                        <div class="col-sm-5">
                            <a id="btnContinue" aria-controls="bt-tab2" role="tab" data-toggle="tab" class="btn-withdraw-option"<?php echo $disabled ?>>Continue</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab2">
                    <h4 class="with-title">

                        <?=lang('wbt_17');?>
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
                                <p class="bt-val" id="txtAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_20');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountWithdraw"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_21');?>
                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtAmountDeducted"></p>
                            </div>
                        </div>
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
                                <?=lang('wbt_47');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtIbanorAccountNumber"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label">
                                <?=lang('wbt_48');?>

                                <span class="reqs1">*</span></label>
                            <div class="col-sm-6">
                                <p class="bt-val" id="txtBicCode"></p>
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
                        <div class="form-group">
                            <label for="" class="col-sm-6 control-label contest-label"></label>
                            <div class="col-sm-6">
                                <a id="btnBack" aria-controls="bt-tab1" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wbt_32');?>
                                </a>
                                <a id="btnSendRequest" aria-controls="bt-tab3" role="tab" data-toggle="tab" class="btn-withdraw-option">
                                    <?=lang('wbt_33');?>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-11 col-centered tab-pane" id="bt-tab3">
                    <h4 class="with-title">
                        <?=lang('wbt_34');?>
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
                                                <p class="frm-val" id="txtSuccessAmountRequested"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_38');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessFee"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_39');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                IBAN Or Account number:
                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessBankAccountNumber"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label">
                                                <?=lang('wbt_41');?>

                                            </label>
                                            <div class="col-sm-6">
                                                <p class="frm-val" id="txtSuccessTransactionNumber"></p>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="btn-create-another">
                                        <a href="<?php echo FXPP::loc_url('withdraw/bank-transfer')?>" class="create-another">
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
                                        <a href="<?php echo FXPP::loc_url('withdraw/bank-transfer')?>" class="create-another">
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