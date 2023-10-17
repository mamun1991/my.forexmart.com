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
    <?=lang('dspt-t-3');?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form class="form-horizontal"  style="margin-top: 50px;" enctype="multipart/form-data">
            <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" id="amountErrorVal" style="margin-left:15%; display: none"></div>
            </div>


            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): $disabled = 'disabled'; ?>

                            <?php echo FXPP::spanishValidationView("cardpay"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
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

        <?php
        $display = $this->session->flashdata('cardpay_transaction');
        if(isset($display)){
            ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p><?=lang('dspt-err-1');?> </p>
                        </div>
                    </div>
                </div>

        <?php } ?>
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
                    <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                
                    <input type="text" name="amount" id="amount" class="form-control round-0 numeric depositamountcheck"   value="<?=floatval($amount)?>"  placeholder="0.00"<?php echo $disabled ?>/>
                     <span class="errorlineshow" style="color: red"> </span>
                </div>
                <input type="hidden" id="bonus" value="<?=$_GET['bonus'] ?>">
              
            </div>

            <?php if(IPLoc::Office()){?>

                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        Color copy of front side of the card
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input class="form-control round-0" type="file" name="front_side" id="front_side">
                    </div>
                </div>


                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        Color copy of back side of the card
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input class="form-control round-0" type="file" name="back_side" id="back_side">
                    </div>
                </div>

            <?php } ?>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit" id="send"<?php echo $disabled ?>>
                        <?=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
        <?php
        $test_users = unserialize(TEST_USERS_DEPOSIT);
        if(in_array($this->session->userdata('user_id'), $test_users)){
        ?>
            <form class="form-horizontal"  style="display: none;" id="frmDeposit" action="https://sandbox.cardpay.com/MI/cardpayment.html" method="POST">
                <input type="hidden" name="orderXML" id="order_xml" VALUE=""/>
                <input type="hidden" name="sha512" id="sha512" VALUE=""/>
            </form>
        <?php }else{ ?>
            <form class="form-horizontal"  style="display: none;" id="frmDeposit" action="https://cardpay.com/MI/cardpayment.html" method="POST">
                <input type="hidden" name="orderXML" id="order_xml" VALUE=""/>
                <input type="hidden" name="sha512" id="sha512" VALUE=""/>
            </form>
        <?php } ?>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('ddcc_05');?>
</h1>
<table class="notes-list">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_06');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_07');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_08');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('ddcc_09');?>
            </p>
        </td>
    </tr>
</table>