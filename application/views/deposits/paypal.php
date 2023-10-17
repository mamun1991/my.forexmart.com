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
    .spanish-risk-links{
        margin-top:20px;
        text-align:center;
    }
    .spanish-risk-links a{
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<h1><?=lang('paypal_00');?></h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <form action="" method="post" class="form-horizontal" style="margin-top: 50px;">

            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else{ ?>
                <div class="form-group" style= "text-align: center;">
                    <?php if($error_msg){?>  <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div> <?php } ?>
                </div>
            <?php } ?>

            <?php if($error){ ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <p><?php echo $error_message ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!--<div id = "spanish-risk-decs-main" class="form-group spanish-risk-main">
                    <div id="spanish-risk-desc-message" class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;">
                       To enable Deposit page, please sign and upload a copy of the Spanish accept risk declaration form.
                        <br>
                      <div class="spanish-risk-links"><a href="<?//= base_url('deposit/downloadSpanishRiskDecPDF'); ?>" >Download Form</a> | </li><a href="<?//= base_url('deposit/sendSpanishRiskDecPDFtoClient'); ?>">Send form to email</a> | </li><a href="#">Upload form now</a></li></div>
                    </div>
            </div>-->

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>paypal.png" class="img-reponsive" width="200px"/>
            </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('paypal_02');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input type="hidden" name="currency" id="currency" value="<?php echo $account['mt_currency_base'] ?>"/>
                        <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                    </div>
                    <span class="col-sm-4 red">  <?php echo  form_error('currency')?> </span>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <?=lang('paypal_03');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5">
                        <input name="amount" id="amount" value="<?=floatval($amount)?>" type="text" class="form-control round-0 numeric depositamountcheck" placeholder="0.00"<?php echo $disabled ?>>
                        <span class="amount-error req errorlineshow">  <?php echo  form_error('amount')?> </span>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="submit" id="btnPaypalSubmit" class="btn-submit"<?php echo $disabled ?>>
                            <?=lang('paypal_04');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>

        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('paypal_05');?>
</h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('paypal_06');?>
            </p>
        </td>
    </tr>
</table>