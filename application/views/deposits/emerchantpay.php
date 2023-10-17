<style>
    .l_{
        float: left;
        width: 20px;
        margin: 1px 10px 0 7px;
    }
    .r_{
        width: 80%;
        float: left;
    }
    .cb{
        clear: both;
    }
    p{ margin: 0px 0px !important;}
</style>
<h1>
     <?= lang('trd_11'); ?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form action="" method="post" class="form-horizontal"  style="margin-top: 50px;">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                </div>
            </div>

            <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
                <div class="form-group">
                    <div class="col-sm-12" style= "margin-top: 21px;">
                        <?php if(!empty($CurPendValidation['TradeErrorMsg'])){?>
                            <div class="alert alert-danger" role="alert">
                                <?php  echo $CurPendValidation['TradeErrorMsg'];?>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>

            <?php
            $disabled = "";
            if($error_msg){

                $disabled = "disabled";

                 if($error_msg == "Spanish client"):

                     echo FXPP::spanishValidationView("emerchantpay");

                else: ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert">
                                <?=$error_msg?>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            <?php } ?>

            <?php  $disabled = false;
            $display = $this->session->flashdata('msg');
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php  $disabled = false;
           // $display = $this->session->flashdata('cardpay_transaction');
            if(isset($msg)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p> <?=$msg;?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php if($error_msg == "Spanish client"){ $disabled = "disabled"; }?>

            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                    <a href="#">  <img src="<?= $this->template->Images()?>mastercard2.png" width="40px"></a>
                    <a href="#">  <img src="<?= $this->template->Images()?>maestro.png" width="40px"></a>
                    <a href="#"> <img src="<?= $this->template->Images()?>visacard-new.png" width="40px"></a>
                    <a href="#">  <img src="<?= $this->template->Images()?>visacard2.png" width="40px"></a>
                    <a href="#"> <img src="<?= $this->template->Images()?>switch.png" width="40px"> </a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php
                    //$attr = 'id="currency" class="form-control round-0"' . $disabled;
                    ?>
                    <?php //echo form_dropdown('account_currency',Custom_library::getDepositCurrencyBase(),false,$attr);?>
                    <input type="hidden" name="account_currency" id="currency" value="<?php echo $account['id'] ?>"/>
                    <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">

                    <select name="currency" class="form-control round-0" <?php echo $disabled ?>>
                        <option <?=$account['currency'] == "USD" ? "selected":''?> value="USD">USD</option>
                        <option <?=$account['currency'] == "BGP" ? "selected":''?> value="GBP">GBP</option>
                        <option <?=$account['currency'] == "EUR" ? "selected":''?> value="EUR">EUR</option>
                    </select>
                    <div class="reqs ">
                        <?php echo form_error('currency'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="amount" value="<?=floatval($amount)?>"  id="amount" class="form-control round-0 numeric depositamountcheck"<?php echo $disabled ?>/>
                    <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>" >
                    <div class="reqs errorlineshow">
                        <?php echo form_error('amount'); ?>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <label for="debitCreditCardName" class="col-sm-4 control-label contest-label"> Card holder name<span class="reqs1">*</span></label>
                <div class="col-sm-5">
                    <input type="text" name="card_holder_name" class="form-control round-0" id="debitCreditCardName" placeholder=""<?php echo $disabled ?>>
                    <div class="reqs ">
                        <?php echo form_error('card_holder_name'); ?>
                    </div>
                </div>

            </div>
            <div class="form-group">
                <label for="debitCreditCardNumber" class="col-sm-4 control-label contest-label">Card number  <span class="reqs1">*</span></label>
                <div class="col-sm-5">
                    <input type="text" name="card_number" class="form-control round-0 numeric" id="debitCreditCardNumber" placeholder=""<?php echo $disabled ?>>
                    <div class="reqs ">
                        <?php echo form_error('card_number'); ?>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="debitCreditCardNumber" class="col-sm-4 control-label contest-label">CVV  <span class="reqs1">*</span></label>
                <div class="col-sm-5">
                    <input type="text" name="cardcv2" class="form-control round-0 numeric" id="debitCreditCardNumber" placeholder=""<?php echo $disabled ?>>
                    <div class="reqs ">
                        <?php echo form_error('cardcv2'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-4 control-label contest-label"> <?=lang('wdcc_07');?> <span class="reqs1">*</span></label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-6">
                            <select id="debitCreditExpiryMonth" name="card_expiry_month" class="form-control round-0"<?php echo $disabled ?>>
                                <option value=""> Month</option>
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                    echo '<option value="' . sprintf("%02d", $m) . '">' . $month . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select id="debitCreditExpiryYear" name="card_expiry_year" class="form-control round-0"<?php echo $disabled ?>>
                                <option value=""> Year</option>
                                <?php
                                $year = date('Y', strtotime(FXPP::getCurrentDateTime()));
                                for ($y = 0; $y <= 10; $y++) {
                                    echo '<option value="' . ($year + $y) . '">' . ($year + $y) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="reqs ">
                        <?php echo form_error('card_expiry_month'); echo form_error('card_expiry_year'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit" id="send2"<?php echo $disabled ?>>
                        <?=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>

        </form>

    </div>

</div>
