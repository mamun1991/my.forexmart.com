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

    .icon-container {
        position: absolute;
        /*right: 10px;*/
        left: 150px;
        top: calc(50% - 10px);
    }
    .icon-loader{
        position: relative;
        height: 20px;
        width: 20px;
        display: inline-block;
        animation: around 5.4s infinite;
    }

    @keyframes around {
        0% {
            transform: rotate(0deg)
        }
        100% {
            transform: rotate(360deg)
        }
    }

    .icon-loader::after, .icon-loader::before {
        content: "";
        background: white;
        position: absolute;
        display: inline-block;
        width: 100%;
        height: 100%;
        border-width: 2px;
        border-color: #333 #333 transparent transparent;
        border-style: solid;
        border-radius: 20px;
        box-sizing: border-box;
        top: 0;
        left: 0;
        animation: around 0.7s ease-in-out infinite;
    }

    .icon-loader::after {
        animation: around 0.7s ease-in-out 0.1s infinite;
        background: transparent;
    }





</style>
 


<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>
<?php $this->load->view('finance_nav.php');?>




 <h1>Withdrawal Options</h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('withdraw');?>">Withdrawal</a></li>
                <li class="active">ThunderXPay</li>
            </ol>
 
 
            <div class="form-group" style="text-align: center;">
             <img src="<?= $this->template->Images()?>sqr_thunderxpay.png" class="img-reponsive" width="250px"/>
            </div>
 
 
<div class="row">
    <div class="col-lg-9 col-centered">





        <form id="thunderx_pay_deposit_form"   onsubmit="return SubmitThunderxPayForm()" action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit" enctype="multipart/form-data">

   

            <?php 
            $display = !empty($this->session->flashdata('zotapay_transaction')) ? $this->session->flashdata('zotapay_transaction') : $apiMsg;
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="center alert <?= ($display == 'Transaction Successful.') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>



            <div class="form-group" style="text-align: center;" id="error_parent_box">
                <div class="col-sm-12" id="error_message_showed" >
                    <?php $disabled = "";  if($error_msg){ $disabled = "disabled"; ?>
                        <div class="alert alert-danger" role="alert" style=" margin-left: 15%; margin-right: 15%;">  <?=$error_msg?> </div>
                    <?php }?>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-4 control-label">
                   Account Number
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php echo $input_account_number; ?>
                </div>

            </div>
           
      
            <div class="form-group">
                <label class="col-sm-4 control-label">
                  Withdraw amount
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <div class="icon-container" style="display: none;">
                        <i class="icon-loader"></i>
                    </div>
                    <input type="number" id="from_amount"  name ="from_amount" min="0" step="any" value="<?=(floatval($amount1)>0)?floatval($amount1):''?>" class="form-control round-0 numeric" placeholder="0.00" style="width: 45%"  required="required">
                </div>
            </div>
            
        <div class="form-group">
                <label class="col-sm-4 control-label">
                  Fee
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">                   
                    <input type="text" name="fee_balance" class="form-control round-0" id="fee_balance" readonly="">
                    
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">
                  New balance
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">                     
                    <input type="text" name="new_balance" class="form-control round-0" id="new_balance" readonly="">
                    
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-5">
                    <input name="amount" id="amount" type="text" class="form-control round-0" readonly style="width: 45%">
                    <span class="amount_error" style="color: red"> <?= form_error('amount') ?></span>
                </div>
            </div>

           
                <div class="form-group">
                <label class="col-sm-4 control-label">Currency<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    
                        <select name="currency" id="currency" class="form-control round-0" required="required">                            
                            <option value="LAK" <?=($user_currency=='LAK')?'selected':''?> >LAK</option>
                            <option value="MMK" <?=($user_currency=='MMK')?'selected':''?> >MMK</option> 
                            <option value="KHR" <?=($user_currency=='KHR')?'selected':''?> >KHR</option> 
                            <option value="ZAR" <?=($user_currency=='ZAR')?'selected':''?> >ZAR</option> 
                            <option value="THB" <?=($user_currency=='THB')?'selected':''?> >THB</option>
                        </select>
               
                    <span class="req">  <?php echo  form_error('currency')?> </span>
                </div>
            </div>
           
            <div class="form-group bank-opt">
                <label class="col-sm-4 control-label">Banks<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select required name="bank_code" class="form-control" id="banks"  required="required"></select>
                    <div class="reqs">
                        <?php echo form_error('bank_code'); ?>
                    </div>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-4 control-label">Bank Account Number <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="bank_account_number" id="bank_account_number" type="text"   class="form-control round-0"  maxlength="30"  value="<?= $bank_account_number?>" <?php echo $disabled ?>  required="required">
                    <span class="bank_account_number_error" style="color: red"><?= form_error('bank_account_number') ?> </span>
                </div>
            </div>
              
          
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit "<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button> 
                    
<input type="hidden" name="from_currency" id="from_currency" value="<?=$user_currency;?>"/>   
                </div><div class="clearfix"></div>
            </div>
        </form>
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
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
    <?=lang('s_05');?>
</h1>
<table class="notes-list" style="margin-bottom: 30px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?=lang('s_06');?>
            </p>
        </td>
    </tr>

</table>




<script type="text/javascript"> 
    
var minimum_withdraw='<?=json_encode($minimum_withdraw)?>';  
var maximum_withdraw='<?=json_encode($maximum_withdraw)?>';  
    
 $("#s3").addClass("active-sidenav");   
    $("#fin_nav2").addClass("acct-active");   
    

        $(window).on('load', function () {
            $('#loader-holder').hide(); //hide loader on reload
        });
    
    
$(document).ready(function(){
       
 
        exhange_currency();
        getBanks();
 });


    
   function getFloatValues(val) {
       
       val= parseFloat(val);
       
   if (isNaN(val)) {
     return 0;
   }
   return val;
} 
    
function getFee(){
    //$fee_amount=(($amount*$fee_percent)/100);
    var fee_precent=getFloatValues(1); //"1%"
  var withdraw_balance= getFloatValues($("#from_amount").val());  
  
  var fee_amt=((withdraw_balance*fee_precent)/100);
  
  return fee_amt;
    
}    
 
    
function isAvailableBalance(){
    
    var withdraw_fee_balance= getFloatValues($("#fee_balance").val());
     var withdraw_balance= getFloatValues($("#from_amount").val());
    var pure_balance=getFloatValues($("#accountNumber").attr("data-balance"));
    
    var with_amt=withdraw_balance+withdraw_fee_balance;
    
    
    var current_balance=pure_balance-(withdraw_balance+withdraw_fee_balance);
    
    if(with_amt>pure_balance)
    {
        return false
    }else{
        return current_balance;
    }
    
}    
    
function withdrawalAmountValidation(){
    
   var currency= $("#currency").val(); 
   var amount= $("#amount").val(); 
    amount=getFloatValues(amount);
    
    var  obj_minimum_withdraw = JSON.parse(minimum_withdraw);
    var obj_maximum_withdraw = JSON.parse(maximum_withdraw);
     
     var min_amt =getFloatValues(obj_minimum_withdraw[currency]);
     var max_amt =getFloatValues(obj_maximum_withdraw[currency]);
     
     
     var result_obj={
         "minimum":(amount<min_amt)?min_amt:false,  // true=> menas need minimum deposit amount
         "maximum":(amount>max_amt)?max_amt:false  // true=> menas need maximum deposit amount
     };
     
        
    return result_obj;
   
}    
    
    

    
 $(document).on('blur', "#from_amount", function (e) 
{
   // var amt= parseFloat($(this).val());
   // var pure_balance=parseFloat($("#accountNumber").attr("data-balance"));
    
     
    var amt_validation = withdrawalAmountValidation();
    var currency= $("#currency").val();  
            if(amt_validation['minimum'])
            {
                showCustomeErrorMgs("The minimum withdrawal  amount is "+amt_validation['minimum']+" "+currency);
                 return false;
            }    
           else if(amt_validation['maximum'])
           {
                showCustomeErrorMgs("The maximum withdrawal amount is "+amt_validation['maximum']+" "+currency);
                 return false;
           }
     
});




function showCustomeErrorMgs(error_mgs){
     var error_mgs='<div class="alert alert-danger" role="alert" style=" margin-left: 15%; margin-right: 15%;"> '+error_mgs+' </div>';
     $("#error_message_showed").html(error_mgs);
    setTimeout(function(){$("#error_message_showed").html(""); }, 8000);

    
}


function showErrorMgs(){
     var error_mgs='<div class="alert alert-danger" role="alert" style=" margin-left: 15%; margin-right: 15%;"> Please complete all the required fields. </div>';
     $("#error_message_showed").html(error_mgs);
    setTimeout(function(){$("#error_message_showed").html(""); }, 6000);

    
}
 


$(document).on("keyup input","#from_amount",function(){
  exhange_currency();
});

$(document).on("change","#currency",function(){
 exhange_currency();
  getBanks();
});

$(document).on("keypress",".char-only",function(e){
  if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)){
                return true;
            }
            e.preventDefault();
            return false;
});

$(document).on("keypress","#phone_number",function(e){
           // Allow: plus sign, backspace, delete, tab, escape, enter and .
            console.log(e.keyCode);
            if ($.inArray(e.keyCode, [43, 46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            
            if(isNaN(String.fromCharCode(e.which))){
                e.preventDefault();
            }
});
     


   



    
    
function SubmitThunderxPayForm()
{
    
    var amt_validation = withdrawalAmountValidation();
    var currency= $("#currency").val(); 
   var from_amount= $("#from_amount").val();
 
     
        var cur_balance= isAvailableBalance();
        
 
    
            if(from_amount<1){
               showErrorMgs();
                return false;
            }
            else if(amt_validation['minimum'])
            {
                showCustomeErrorMgs("The minimum withdrawal  amount is "+amt_validation['minimum']+" "+currency);
                 return false;
            }    
           else if(amt_validation['maximum'])
           {
                showCustomeErrorMgs("The maximum withdrawal  amount is "+amt_validation['maximum']+" "+currency);
                 return false;
           }
            else if(!cur_balance)
           {
               showCustomeErrorMgs("Insufficient balance! Your withdrawable balance is not enough.");
                 return false;
           }
           else
            {
            
                    $('#loader-holder').show(); //show loader on submit
               //s    return false;
                  return true;
            }  
    
}









    function exhange_currency() {
        
        
        
        
        var fee_amt = getFee();        
        $("#fee_balance").val(fee_amt);
        
        var cur_balance= isAvailableBalance();
        
        if(cur_balance)
        {    
            
              $("#new_balance").val(cur_balance.toFixed(2));
        
                    var currencyFrom = $("#from_currency").val();
                        currencyTo =  $('#currency').val(),
                        amountFrom = $('#from_amount').val(),
                        convertedAmount = 0.00;

                         amountFrom=getFloatValues(amountFrom)+getFloatValues(fee_amt);  

                    console.log(currencyFrom+"====>"+currencyTo);

                    $.ajax({
                        type: "post",
                        url: "/deposit/exchange_currency",
                        data: 'amount='+amountFrom+'&currency_from='+currencyFrom+'&currency_to='+currencyTo,
                        dataType: 'json',
                        beforeSend: function(){
                            $('.icon-container').show();
                        },
                        success: function(x) {
                            $('.icon-container').hide();
                            if(x.success){
                                convertedAmount = getFloatValues(x.rate).toFixed(2);
                                $('#amount').val(convertedAmount);
                                $('#to_amount').val(convertedAmount);
                            }else{
                                $('#amount').val(convertedAmount);
                                $('#to_amount').val(convertedAmount);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('.icon-container').hide();
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
          }else{
              
              showCustomeErrorMgs("Insufficient balance! Your withdrawable balance is not enough.");
          }             

    }


    function getBanks(currency){

        $.ajax({
            type: 'POST',
            url: '/deposit/requestZPBanks',
            data: {currency: $('#currency').val()},
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {
                $('#banks').html(response.option);
            }
        });
    }
    
    
    
    
 

    
    
    
 
</script>