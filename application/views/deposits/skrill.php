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
    <?=lang('s_00');?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        
         
        <?php 
        $deposit_amount=0;
        if($amount>0)
        {
            $deposit_amount=$amount;
            
        }else{
           $deposit_amount= ($field_value)?$field_value['amount']:0;
        } 
        
        ?>
        
        
        
        <form action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit">

            <?php if($hasError && !empty($hasError)){?>
                <div class="form-group" style="text-align: center; margin-top: 21px;">
                    <?php if(form_error('amount')){?>
                        <div class="col-sm-9 alert alert-danger" role="alert" style="margin-left:12%;"><?php echo  form_error('amount'); ?></div>
                    <?php }?>
                </div>
            <?php } ?>


              <div class="form-group" style="text-align: center;">
                     <?php $display = $this->session->flashdata('skrill_status');if(isset($display)){?>
                    <div class="col-sm-9 alert alert-danger center" role="alert" style="margin-bottom: 15px;margin-top: 15px; margin-left:12%;">
                        <p><?=lang('dspt-err-1');?> </p>
                    </div>
                    <?php } ?>

                <?php if($non_verified_notice){?>
                    <div class="form-group" style= "text-align: center;">
                        <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$non_verified_notice?></div>
                    </div>
                <?php }else{ ?>
                    <div class="form-group" style= "text-align: center;">
                        <?php if($error_msg){?>

                            <?php if($error_msg == "Spanish client"): ?>

                                <?php echo FXPP::spanishValidationView("skrill"); ?>

                            <?php else: ?>

                                <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                            <?php endif; ?>

                        <?php } ?>
                    </div>
                <?php } ?>
                <img src="<?= $this->template->Images()?>skrill.png" class="img-reponsive" width="250px"/>
               </div>



            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="currency" id="currency" value="<?php echo $account['currency'] ?>"/>
                    <?php echo $input_account_number; ?>
                  </div>
                <span class="col-sm-3 req">  <?php echo  form_error('currency')?> </span>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('s_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="amount" id="amount" type="text" class="form-control round-0 numeric depositamountcheck" placeholder="0.00" value="<?=floatval($deposit_amount)?>" <?php echo $disabled ?>>
                    <span class="CardFieldAmount errorlineshow" style="color: red"> </span>
                </div>


            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" class="btn-submit paymentmethodformsumitbutton"<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button>


                    


                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('s_05');?>
</h1>
<table class="notes-list" style="margin-bottom: 30px;">
    <!--<tr>
        <td><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td>
            <p>
                System fee: 1% (not more than 11,41 USD or 10 EUR). Transaction fee - 1.39%. Withdrawal is processed within 1-7 working hours.
            </p>
        </td>
    </tr>-->
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('s_06');?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('s_07');?>
            </p>
        </td>
    </tr>
</table>




