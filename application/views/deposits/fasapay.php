
<h1>
    Fasapay
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">
        
        <?php 
        $deposit_amount=0;
       
        $account= ($field_value)?$field_value['account']:"";
        $currency= ($field_value)?$field_value['currency']:"";

        if($amount>0)
        {
            $deposit_amount=$amount;
            
        }else{
           $deposit_amount= ($field_value)?$field_value['sum']:0;
           
        } 
        
        ?>

        <form method="post" action="" class="form-horizontal subFasapay" id="faspaypaymentform" style="margin-top: 50px;" >
            
            <div class="form-group" style= "text-align: center;">
                <?php if(validation_errors() != false){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=validation_errors();?></div> <?php }
                 if(isset($error)){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=$error;?></div> <?php } ?>
            </div>

            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>

                        <?php if($error_msg == "Spanish client"): ?>

                            <?php echo FXPP::spanishValidationView("fasapay"); ?>

                        <?php else: ?>

                            <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>

                        <?php endif; ?>

                    <?php } ?>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>fasapay.png" border="0" alt="" style="width: 200px; margin-bottom: 15px;"/>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label">
                    Account currency
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php echo $input_account_number; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label">
                  Fasapay account number
                    <cite class="req">*</cite></label> 
                <div class="col-sm-5">
                    <input type="text"  name="account"  value="<?=$account?>"  id="account"  class="form-control round-0 cardField">
                      <span class="cardField_account" style="color: red"> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">
                   Currency
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency" class="form-control round-0">
                        <option value="USD" <?=($currency=='USD')?'selected':''?> >USD</option>
                        <option value="IDR" <?=($currency=='IDR')?'selected':''?> >IDR</option>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label">
                   Deposit Amount
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="sum" id="sum"  class="form-control round-0 numeric cardField depositamountcheck"   value="<?=$deposit_amount?>"  <?=$disabled?>>
                    <span class="cardField_sum errorlineshow" style="color: red"> </span>

                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-5">
                    <button type="button" class="btn-submit faspaysumitbutton" <?=$disabled?>>
                   Send Request
                    </button>

                 



                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>






<script type="text/javascript">
var minimum_deposit_mgs="<?=lang('n_23')?>";
var requied_accmount_mgs="Account number is required ";


    $(document).on('click', '.faspaysumitbutton', function(){
        var amountVal=$('#sum').val();
        var account=$('#account').val();
        account=trim(account);
     
 
        if(account.length<4)
        {
            $(".cardField_account").html(requied_accmount_mgs);
           
        }
        else if(account.length>30)
        {
           $(".cardField_account").html("Wrong fasapay account number");
           
        }
        else if(amountVal<1)
        {
          $('.cardField_sum').html(minimum_deposit_mgs);
           
        }
        else if(!isNumber(amountVal))
        {
            $('#sum').val(0);
          $('.cardField_sum').html(minimum_deposit_mgs);
           
        }
        else{
               changeUrlParamitterValue("amount1",amountVal);
             
            $("#faspaypaymentform").submit();
            
        }
        



    });
    
    
    
    
    


$(document).on("keyup","#account",function(e){
    $(".cardField_account").html("");
   
   var card_number= $(this).val();
   
   card_number=trim(card_number);
   
   if(card_number.length>30)
   {
       $(".cardField_account").html("Wrong fasapay account number");
   }else{
       
        $(".cardField_account").html("");
       
      // $("#account").val(card_number.toString().slice(0, -1));
       
       return false;
   }
    
});    
    

/*
$(document).on("keyup",".cardField",function(){
    var id=$(this).attr("id");
    $(".cardField_"+id).html("");
    
    
});
*/

function trim(str) {
    return str.toString().replace(/^\s+|\s+$/g,'');
}

 function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 

</script>

