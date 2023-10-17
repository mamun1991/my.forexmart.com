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
 


 <h1>Deposit Options</h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_28'); ?></a></li>
                <li class="active">ThunderXPay</li>
            </ol>
 
 
            <div class="form-group" style="text-align: center;">
             <img src="<?= $this->template->Images()?>sqr_thunderxpay.png" class="img-reponsive" width="250px"/>
            </div>
 
 
<div class="row">
    <div class="col-lg-9 col-centered">





        <form id="thunderx_pay_deposit_form"   onsubmit="return SubmitThunderxPayForm()" action="" method="post" class="form-horizontal subSkrill paymentmethodformsumit" enctype="multipart/form-data">

               
            <?php 
            
            if($deposit_status!="")
            {
                $alert_status=($deposit_status=="success")?"alert-success":"alert-danger";
                
             ?>
                    
                    
              <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="center alert <?=$alert_status?>" role="alert">
                            <p> <?=$this->session->flashdata('thundexpay_deposit')?> </p>
                        </div>
                    </div>
                </div>
            
               
                    
                    
          <?php          
                
            } 
          ?>


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
                    <?=lang('s_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <div class="icon-container" style="display: none;">
                        <i class="icon-loader"></i>
                    </div>
                    <input type="number" id="from_amount"  name ="from_amount" min="0" step="any" value="<?=(floatval($amount1)>0)?floatval($amount1):''?>" class="form-control round-0 numeric" placeholder="0.00" style="width: 45%"  required="required">
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
                <label class="col-sm-4 control-label">ID Card Number<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="idcard_number" id="idcard_number" type="text"   class="form-control round-0"  maxlength="30"  value="<?= $idcard_number?>" <?php echo $disabled ?>  required="required">
                    <span class="idcard_number_error" style="color: red"><?= form_error('idcard_number') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Full Name<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="person_name" id="person_name" type="text"   class=" form-control round-0"  maxlength="30"  value="<?= $person_name?>" <?php echo $disabled ?>  required="required">
                    <span class="person_name_error" style="color: red"><?= form_error('person_name') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Email<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="person_email" id="person_email" type="email" class="form-control round-0" maxlength="30"  value="<?= $person_email?>"<?php echo $disabled ?>  required="required">
                    <span class="person_email_error" style="color: red"><?= form_error('person_email') ?> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Phone Number<cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="person_phone" id="phone_number" type="text" class="form-control round-0"  maxlength="16" value="<?= $person_phone?>" <?php echo $disabled ?>  required="required">
                    <span class="person_phone_error" style="color: red"><?= form_error('person_phone') ?> </span>
                </div>
            </div>
            
             <div class="form-group">
                 <label class="col-sm-4 control-label">Card Image (JPEG/PNG) <cite class="req">*</cite> <br> <i style="font-size:11px"> [Citizen or Passport]</i></label>
                <div class="col-sm-5">
                    <input name="card_image" id="card_image" type="file" class="form-control round-0" <?php echo $disabled ?>  required="required">
                    <span class="card_image_error" style="color: red"><?= form_error('card_image') ?> </span>
                </div>
            </div>
          
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit "<?php echo $disabled ?>>
                        <?=lang('s_04');?>
                    </button>

                    
                    
                    <input type="hidden" name="bonus_type" value="<?=$bonus;?>"/>         
                    <input type="hidden" name="bonus" value="<?=$addBonus;?>"/>         
                    <input type="hidden" name="pre_amount" value="<?=$amount1;?>"/>         
                    <input type="hidden" name="payment_type" value="<?=$type;?>"/>         
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
    
var minimum_deposit='<?=json_encode($minimum_deposit)?>';  
var maximum_deposit='<?=json_encode($maximum_deposit)?>';  
    
    $("#s3").addClass("active-sidenav");    
    
    
function depositAmountValidation(){
    
   var currency= $("#currency").val(); 
   var amount= $("#amount").val(); 
    amount=parseFloat(amount);
    
    var  obj_minimum_deposit = JSON.parse(minimum_deposit);
    var obj_maximum_deposit = JSON.parse(maximum_deposit);
     
     var min_amt =parseFloat(obj_minimum_deposit[currency]);
     var max_amt =parseFloat(obj_maximum_deposit[currency]);
     
     
     var result_obj={
         "minimum":(amount<min_amt)?min_amt:false,  // true=> menas need minimum deposit amount
         "maximum":(amount>max_amt)?max_amt:false  // true=> menas need maximum deposit amount
     };
     
        
    return result_obj;
   
}    
    
    
    
function SubmitThunderxPayForm()
{
    
    var amt_validation = depositAmountValidation();
    var currency= $("#currency").val(); 
   var from_amount= $("#from_amount").val();
 
   
    
            if(from_amount<1){
               showErrorMgs();
                return false;
            }
            else if(amt_validation['minimum'])
            {
                showCustomeErrorMgs("The minimum deposit amount is "+amt_validation['minimum']+" "+currency);
                 return false;
            }    
           else if(amt_validation['maximum'])
           {
                showCustomeErrorMgs("The maximum deposit amount is "+amt_validation['maximum']+" "+currency);
                 return false;
           }
           else
            {
            
                    
            
                    $('#loader-holder').show(); //show loader on submit
               //s    return false;
                  return true;
            }  
    
}

    
 $(document).on('blur', "#from_amount", function (e) 
{
   // var amt= parseFloat($(this).val());
   // var pure_balance=parseFloat($("#accountNumber").attr("data-balance"));
    
     
    var amt_validation = depositAmountValidation();
    var currency= $("#currency").val();  
            if(amt_validation['minimum'])
            {
                showCustomeErrorMgs("The minimum deposit amount is "+amt_validation['minimum']+" "+currency);
                 return false;
            }    
           else if(amt_validation['maximum'])
           {
                showCustomeErrorMgs("The maximum deposit amount is "+amt_validation['maximum']+" "+currency);
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



        $(window).on('load', function () {
            $('#loader-holder').hide(); //hide loader on reload
        });



    $(document).ready(function(){
       
       
     

        exhange_currency();
        getBanks();

      

        $('#from_amount').bind('keyup input', function(){
            exhange_currency();
        });


        $('select#currency').on('change', function() {
            
            exhange_currency();
            getBanks();
          
           
        });


        $(".char-only").keypress(function (e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)){
                return true;
            }
            e.preventDefault();
            return false;
        });


        $("#phone_number").keypress(function (e) {
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

    });



    function exhange_currency() {
        var currencyFrom = $("#from_currency").val();
            currencyTo =  $('#currency').val(),
            amountFrom = $('#from_amount').val(),
            convertedAmount = 0.00;

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
                    convertedAmount = parseFloat(x.rate).toFixed(2);
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
    
    
    
    


$(document).on('change', "#card_image", function (e) 
{
    
    
    var file_obj=this.files[0];
    var name=file_obj.name;
    var file_size= this.files[0].size/1024/1024 ;//file_obj.size;
    var type=file_obj.type;
    var validImageTypes = ["image/jpg", "image/jpeg", "image/png"]; 
    
     $(".card_image_error").html("");
    
        if(type){
     type=type.toLowerCase();
 }
             
 
  
var valid_file=parseInt(validImageTypes.indexOf(type));  
      
    
   if(valid_file<parseInt(0))
   {      
       
          $(this).val("");
           $(".card_image_error").html("Only JPEG and PNG file allow.");
          e.preventDefault();    
          return false;
       
   }
   
  
  if(file_size>5)
  {
      $(this).val("");       
       $(".card_image_error").html("Maximum file size 5mb.");
          e.preventDefault();    
          return false;
      
  }

   
});   
  


 function getExtension(filename) {
  var parts = filename.split('.');
  return parts[parts.length - 1];
}


    
    
    
 
</script>