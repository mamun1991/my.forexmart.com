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
</style>
<h1>
    <?=lang('p_00');?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <form class="form-horizontal" method="post" style="margin-top: 50px;">
            <div class="form-group" style="text-align: center;">
                <div class="col-sm-12">
                    <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
                        <?php if(!empty($CurPendValidation['TradeErrorMsg'])){?>
                            <div class="alert alert-danger" role="alert">
                                <?php  echo $CurPendValidation['TradeErrorMsg'];?>
                            </div>
                        <?php }?>
                    <?php } ?>


                    <?php if(IPLoc::Office()) {
                        if (isset($eu_payment_status) && $eu_payment_status) {?>
                            <div class="form-group" id="error-payment" style="text-align: center;">
                                <div class="col-sm-8 alert alert-danger" role="alert" style="margin-left:15%;">
                                    <?php echo $eu_error_message; ?>
                                </div>
                            </div>
                        <?php }
                    }?>

                    <div class="form-group" style= "text-align: center;">
                        <?php if(validation_errors() != false){?>
                            <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=validation_errors();?></div>
                        <?php } ?>
                    </div>

                    <?php if($non_verified_notice){?>
                        <div class="form-group" style= "text-align: center;">
                            <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                        </div>
                    <?php }else{ ?>
                        <div class="form-group" style= "text-align: center;">
                            <?php if($error_msg){?>

                                <?php if($error_msg == "Spanish client"): ?>

                                    <?php echo FXPP::spanishValidationView("paxum"); ?>

                                <?php else: ?>

                                    <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                                <?php endif; ?>

                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php  if($success){  ?>
                        <div class="form-group" style= "text-align: center;">
                            <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;">
                                You have successfully deposited <?php echo $currency . ' ' . $amount  ?>.
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('p_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="currency" id="currency" value="<?php echo $account['mt_currency_base'] ?>"/>
                    <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('p_04');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="amount"  value="<?=$amount?>"  class="form-control round-0 numeric"<?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('p_05');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="email" class="form-control round-0"<?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit"<?php echo $disabled ?>>
                        <?=lang('p_06');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('p_07');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('p_08_0');?>
                <a href mailto="finance@forexmart.com">
                    <?=lang('p_08_1');?>
                </a>.
            </p>
        </td>
    </tr>
</table>