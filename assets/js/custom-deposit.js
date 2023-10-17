$(document).ready(function(){

    var base_url = $('#base_url').val();

    jQuery(".numeric").on("keypress keyup blur",function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    jQuery(".numeric").on("blur",function (event) {
        var value=$(this).val().replace(/[^0-9.,]*/g, '');
        value=value.replace(/\.{2,}/g, '.');
        value=value.replace(/\.,/g, ',');
        value=value.replace(/\,\./g, ',');
        value=value.replace(/\,{2,}/g, ',');
        value=value.replace(/\.[0-9]+\./g, '.');
        $(this).val(value)
    });


    jQuery(".numeric").on("cut copy paste",function (event) {
       event.preventDefault();
    });




    $('#send').click(function(event){
        event.preventDefault();
        var currency = $('#currency').val();
        var amount = $('#amount').val();
        var bonus = $('#bonus').val();
        if(currency.length == 0){
            jQuery('.currency-error').html('Please select currency.');
            jQuery('.currency-error').show();
        }else{
            $.ajax({
                type: "post",
                url: base_url+"deposit/encodePaymentFields",
                data: 'account_currency='+currency+'&amount='+amount+'&bonus='+bonus,
                dataType: 'json',
                success: function(x) {
                    if(x.success){
                        console.log(x.order);
                        $('#order_xml').val(x.order_xml);
                        $('#sha512').val(x.sha512);
                        $('#frmDeposit').submit();
                    }else{
                        if(!x.validation_error) {
                            for( var item in x.error ){
                                if(x.error[item] != ''){
                                    console.log(item);
                                    jQuery('#amountErrorVal').html(x.error[item]);
                                    jQuery('#amountErrorVal').show();

                                }
                            }
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

    });

    jQuery('#frm-webmoney button').on('click', function(){
        jQuery('#frm-webmoney :input').each(function(index) {
            var total_input = jQuery('#frm-webmoney :input').length;
            if (!jQuery(this).val().length) {
                // jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if (total_input - 1 === index) {
                if(!jQuery('#frm-webmoney p.field-req').length) {
                    jQuery.ajax({
                        type: "POST",
                        url: base_url + "deposit/webmoney_transfer", //deposit/webtopay
                        data: jQuery('#frm-webmoney').serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('#loader-holder').show();
                        },
                        success: function (x) {
                            if(!x.validation_error){
                                console.log(x.error.err);
                                jQuery('#amountErrorVal').html(x.error.err);
                                jQuery('#amountErrorVal').show();
                                $('#loader-holder').hide();
                            }else{
                                console.log(x);
                                jQuery('#payment_amount').val(x.data.LMI_PAYMENT_AMOUNT);
                                jQuery('#desc').val(x.data.LMI_PAYMENT_DESC);
                                jQuery('#purse').val(x.data.LMI_PAYEE_PURSE);
                                jQuery('#pin').val(x.data.LMI_PAYMENT_NO);
                                jQuery('#user_id').val(x.data.user_id);
                                jQuery('#trn_id').val(x.data.trn_id);
                                jQuery('#bonus').val(x.data.bonus);
                                jQuery('#frm-wmt').submit();
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab4').addClass('active');
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }
            }
        });
    });



jQuery('#frm-paysera button').on('click', function(){
        jQuery('#frm-paysera :input').each(function(index) {
            var total_input = jQuery('#frm-paysera :input').length;
            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if (total_input - 1 === index) {
                if(!jQuery('#frm-paysera p.field-req').length) {
                    jQuery.ajax({
                        type: "POST",
                        url: base_url + "deposit/payseratopay",
                        data: jQuery('#frm-paysera').serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('#loader-holder').show();
                        },
                        success: function (x) {
                            jQuery('#frm-paysera').attr('action', x.action);
                            jQuery('#frm-paysera').append(x.data);
                            jQuery('#frm-paysera').submit();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab4').addClass('active');
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }
            }
        });
    });



    //Bank Transfer

    jQuery('#btnSendBankTransfer').on('click', function(event){
        event.preventDefault();

        var currency = $('#account_currency').val();
        var amount = $('#amount').val();
        var bank_name = $('#bankName').val();
        // if($('#bankName').val().toUpperCase() == 'PRIVATBANK' ){
        //     jQuery('#amountErrorVal').html('Sorry, We no longer accept payments from this bank.');
        //     jQuery('#amountErrorVal').show();
        //    }
        if(currency.length == 0){
            jQuery('#curErrorVal').html('Invalid account');
            jQuery('#curErrorVal').show();
        }else{
            jQuery.ajax({
                type: "POST",
                url: base_url + "deposit/sendBankTransfer",
                data: jQuery('#frmBankTransfer').serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (x) {
                    if(x.success){
                        jQuery('#frmBankTransfer').removeAttr('action');
                        jQuery('#bank-transfer-row').html(x.data);
                    }else{
                        console.log(x.data);
                        console.log(x.Errdata);
                        jQuery('#frmBankTransfer').prepend(x.data);
                        jQuery('#amountErrorVal').html(x.Errdata);
                        jQuery('#amountErrorVal').show();
                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }
    });

    //Bitcoin
    jQuery('#btnGenerateAddress').on('click', function(){
        jQuery.ajax({
            type: "POST",
            url: base_url + "deposit/generate_bitcoin_address",
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function (x) {
                $('#txtPaymentAddress').val(x.address);
                $("#generate-address-holder").html('<button type="button" class="btn-generate" id="btnGenerateAddress" style="background: #d3d3d3" disabled="disabled">Generate new address</button>');
                $('#loader-holder').hide();

            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

    jQuery('#btnBitcoinSubmit').on('click', function(){
        var errors = new Array(),
            submit = true,
            form = '#frmBitcoin';

        jQuery(form + " input").each(function(){

            if( '' == jQuery( this ).val() ) {
                errors.push( this.name );
                submit = false;
            }

            if( this.name == 'amount' ){
                if(parseInt(jQuery( this ).val()) <= 0){
                    errors.push( 'amount_minimum' );
                    submit = false;
                }
            }
        });

        if(submit){
            jQuery(form).submit();
        }else{
            for( error in errors){
                switch(errors[error]){
                    case 'currency':
                    case 'account_currency':
                        $('span#bitcoin_currency').html('The Currency field is required.');
                        break;
                    case 'amount':
                        $('span#bitcoin_amount').html('The Amount field is required.');
                        break;
                    case 'amount_minimum':
                        $('span#bitcoin_amount').html('Minimum deposit amount is 1 USD.');
                        break;
                    case 'address':
                        $('span#bitcoin_address').html('The ForexMart Bitcoin Address field is required.');
                        break;
                    case 'transaction_id':
                        $('span#bitcoin_transaction_id').html('The Bitcoin Transaction ID field is required.');
                        break;
                }
            }
        }

    });




    // Paypal
    jQuery('#btnPaypalSubmit').on('click', function(e){
        var amount = $('#amount').val();
        var currency = $('#currency').val();
        if(parseInt(amount) < 1 || amount.length == 0){
            jQuery('.amount-error').html('Minimum deposit should be at least 1 ' + currency + '.');
            jQuery('.amount-error').show();
            e.preventDefault();
        }
    });


    // China Union Pay
    jQuery('#chinaUnionPayForm button').on('click', function(){
        jQuery('#chinaUnionPayForm :input').each(function(index,item) {
            var total_input = jQuery('#chinaUnionPayForm  :input').length;
            var isInputChinese = isChn(jQuery(this).val());

            if (!(item.name == 'account_currency')) {

                if(parseFloat(jQuery('#amount').val()) < 1 ){
                    console.log(item.name);
                    console.log('yes');
                    jQuery('.amount-err').html('<p class="field-req"> Minimum deposit should be at least 1 USD</p>');
                }
                if (!jQuery(this).val().length) {
                    jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
                } else if (jQuery(this).val().length && !isInputChinese && !(item.name == 'amount') && !(item.name == 'cup_bank_number')) {
                    jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req"> Input must be in Chinese Characters </p>');
                } else {
                    jQuery(this).closest('div.form-group').children('div.reqs').html('');
                }


                if (total_input - 2 === index) {
                    console.log(item.name);
                    if(!jQuery('#chinaUnionPayForm p.field-req').length) {
                        console.log('YES');
                        jQuery('#chinaUnionPayForm').submit();
                    }
                }
            }
        });

    });



});


function isChn(str){
    return /^[\u4E00-\u9FA5]+$/.test(str);
}

 function isNanVal(amount){  
   amount=parseFloat(amount);
   return Number.isNaN(amount) ;
 
}
 
 

/*--------------------------- card number validation -------------------------*/
function IsValidCardNumber(cardNumber,minchk=false) {
    
    if(cardNumber)
    {
        cardNumber=cardNumber.replace(/ /g,'');
        
        if (/[a-zA-Z]/.test(cardNumber)) {
           return false;
         }
         else{
             
                     var regex = new RegExp(/^\d*$/),
                    value = $.trim(cardNumber);

                if(value.length <=19 && regex.exec(value)) 
                {
                    if(minchk)
                    {    
                        if(value.length<10)
                        {
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return true;
                    }
                    
                } else {
                   return false;
                }

         }
        

    }else{
        return false;
    }
}


/*--------------------------- card number validation close -------------------------*/



$(document).on("keyup","#card_number",function(e){
    $(".CardFieldVal").html("");
   
   var card_number= $(this).val();
   if(IsValidCardNumber(card_number))
   {
       return true;
   }else{
       

       
       $(".CardFieldVal").html("Wrong card number");
       
       $("#card_number").val(card_number.toString().slice(0, -1));
       
       return false;
   }
    
});


$(document).on("blur","#card_number",function(e){
    $(".CardFieldVal").html("");
   
   var card_number= $(this).val();
   if(IsValidCardNumber(card_number,true))
   {
       return true;
   }else{
              
       $(".CardFieldVal").html("Wrong card number");
        
                if(card_number<=0) 
                {
                    var posNum = (card_number < 0) ? card_number * -1 : card_number;
                    
                    $("#card_number").val(posNum);
                }
       
       
       
       return false;
   }
    
});




var max_deposit="100000000";
var max_deposit_mgs= "Maximum deposit amount is 100,000,000.";
var min_deposit="Minimum of 1.00 USD/GBP/EUR deposit.";

var alipay_max ="200000";
var alipay_min ="100"; //CNY
var alipay_max_mgs= "Maximum deposit amount is 200000";


$(document).on("keyup",".depositamountcheck",function(e){
    
  
    
       var total_amt=0; 
       var amt_data= $(this).val();
       var amt =(isNanVal(amt_data))?0:parseFloat(amt_data); 
      
      total_amt=total_amt+amt;
      
      if($(this).hasClass('alogatewayamount'))
      {
          
            if(total_amt>parseFloat(alipay_max))
            {   
                $(this).parent("div").find(".errorlineshow").html(alipay_max_mgs);

                  $(this).val(parseFloat(total_amt.toString().slice(0, -1)));
                  e.preventDefault();
                  return false;

            }else{
                 $(this).parent("div").find(".errorlineshow").html("");
            }

          
          
      }
      else
      {     
        if(total_amt>parseFloat(max_deposit))
        {   
            $(this).parent("div").find(".errorlineshow").html(max_deposit_mgs);

              $(this).val(parseFloat(total_amt.toString().slice(0, -1)));
              e.preventDefault();
              return false;

        }else{
             $(this).parent("div").find(".errorlineshow").html("");
        }
    } 
      
});


$(document).on("change",".payomacurrenytype",function(e){
    
    $(".errorlineshow").html("");
});

 

 

 $(document).on('click', '.paymentmethodformsumitbutton', function(){
     

      
       var amt_data=$('.depositamountcheck').val();
       var amt =(isNanVal(amt_data))?0:parseFloat(amt_data);

       //console.log(amt+' ook');
    
        if(amt<1)
        {
            $(".errorlineshow").html(min_deposit);
           
        }
        else if(amt>max_deposit)
        { 
           $(".errorlineshow").html(max_deposit_mgs);
           
        }
        else{
             
             changeUrlParamitterValue("amount1",amt);
             
             if($(this).hasClass("china_union_pay_submit_button"))
             {
                 $(".reqs").html("");
                 if(checkGroupPayRquiredField())
                 {
                      $(".paymentmethodformsumit").submit();
                 }
                 
             }
            else if($(this).hasClass("ali_pay_submit_button"))
             {
                 
                 $(".failed_success_mgs_cls").remove();
                 $(".reqs").html("");
                 if(checkGroupPayRquiredField())
                 {
                      $(".paymentmethodformsumit").submit();
                 }
                 
             } 
            else{
                 $(".paymentmethodformsumit").submit();
             }
             
            
            
        }
        



    });



 function changeUrlParamitterValue(paramName, paramValue,currentUrl=null){

    
	 if(currentUrl==null){
        currentUrl=window.location.href;
    }
  
      
var url = new URL(currentUrl);
url.searchParams.set(paramName, paramValue); // setting your param
var newUrl = url.href; 
//console.log(newUrl);

history.pushState({}, null, newUrl);

return true;
}


function checkGroupPayRquiredField()
{
    var return_data=true;
    var first_name=$("#first_name").val();
    var last_name=$("#last_name").val();
    var address1=$("#address1").val();
    var city=$("#city").val();
    var zip_code=$("#zip_code").val();
    var phone=$("#phone").val(); 
    
    if(first_name.length<4)
    {
        return_data=false;
        $(".error_first_name").html("The First name  must be at least 4 characters in length.");
    }
    
    if(last_name.length<4)
    {
       return_data=false;
        $(".error_last_name").html("The Last name  must be at least 4 characters in length.");
    }
    
    if(address1.length<10)
    {
        return_data=false;
        $(".error_address1").html("The Address  must be at least 10 characters in length.");
    }
    
    if(city.length<4)
    {
        return_data=false;
        $(".error_city").html("The City name  must be at least 4 characters in length.");
    }
    
     if(zip_code.length<3)
    {
        return_data=false;
        $(".error_zip_code").html("The Zip-code  must be at least 3 characters in length.");
    }
    
    if(phone.length<4)
    {
        return_data=false;
        $(".error_phone").html("The Phone  must be at least 4 characters in length.");
    }
    
    
    return return_data;
}

