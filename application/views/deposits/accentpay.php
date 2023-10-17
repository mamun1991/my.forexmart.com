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
    <?= lang('trd_6'); ?>
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

            <div class="form-group" style= "text-align: center;">
                <?php  if(validation_errors()){ ?>
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;" role="alert" id="amountErrorVal"> <?php echo validation_errors();?></div>
                <?php }?>
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
            if($non_verified_notice){?>
            <div class="form-group" style= "text-align: center;">
                <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
            </div>
            <?php }else if($error_msg){
                $disabled = "disabled";
                ?>
                <div class="form-group" style= "text-align: center;">
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("accentpay"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
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

            <!--<div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>mastercard2.png" width="40px"></a>
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>maestro.png" width="40px"></a>
                    <a href="#"> <img src="<?/*= $this->template->Images()*/?>visacard-new.png" width="40px"></a>
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>visacard2.png" width="40px"></a>
                    <a href="#"> <img src="<?/*= $this->template->Images()*/?>switch.png" width="40px"> </a>
                </div>
            </div>-->

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>ecommpay.svg" border="0" alt="" style="width: 165px; margin-bottom: 15px;"/>
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
                    Payment type
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <label class="radio-inline">
                        <input checked type="radio" name="payment_type" value="qiwi">QIWI Wallet
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="payment_type" value="yandex"> Yandex.Money
                    </label>


                    <div class="reqs ">
                        <?php //echo form_error('payment_type'); ?>
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
                        <?php //echo form_error('amount'); ?>
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


