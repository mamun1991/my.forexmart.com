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
.form-horizontal .control-label{ text-align: left !important}    
</style>
<script>

$(document).on("keydown","#sum",function(e){
  // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
      ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
      // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
      // let it happen, don't do anything
      return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }

});

function validateForm() {
//    var x=parseInt($("#sum").val());
//    if (x == null || x <100)
//    {
//        alert("Deposit amount minimum 100 rub");
//        return false;
//    }
}

</script>

<h1>
    <?=lang('ym_00');?>
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">
        <form method="post" action="" class="form-horizontal" style="margin-top: 50px; margin-left: 120px" onsubmit="return validateForm()" >
            <input type="hidden" name="bounusfiled" value="<?=(set_value('bounusfiled'))?set_value('bounusfiled'):$bounusfiled?>">
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
            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else{ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>  <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div> <?php } ?>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: left;">
                <img src="<?= $this->template->Images()?>yandexmoneylogo.png" border="0" alt="" style="width: 203px; margin-bottom: 15px;"/>
            </div>
       
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?=lang('ym_04');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="sum" id="sum"    value="<?=floatval($amount)?>"  class="form-control round-0"<?php echo $disabled ?> title="Minimum 100 rub" required="required">
                    <cite class="req"><?php echo form_error('sum').$amountmgs; ?></cite>
                </div>
                <div  style="float: left; line-height: 33px; width: auto;">
                     <b><?=$client_currency?></b>
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <?=lang('ym_07');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="paymentType" id="paymentType" class="form-control round-0"<?php echo $disabled ?> required="required">
                         <option value="">Select</option>
                         <option value="PC" <?=(set_value('paymentType')=='PC')?'selected':''?>>Payment from a Yandex.Money Wallet</option>
                           <option value="AC" <?=(set_value('paymentType')=='AC')?'selected':''?>>Payment using a bank card</option>
                            <option value="GP" <?=(set_value('paymentType')=='GP')?'selected':''?>>Cash payment at kiosks or terminals</option>
                    </select>
                    <cite class="req"> <?php echo form_error('paymentType'); ?></cite>
                </div>
            </div>
            
            
              
            
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-4">
                    <button type="submit" class="btn-submit"<?php echo $disabled ?> style=" margin-left: -20px">
                        <?=lang('ym_11');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

  
 


</div>
 

