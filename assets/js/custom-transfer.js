jQuery(document).ready(function(){

    var transfer_lang = $('#hidden-lang').val();
    console.log(transfer_lang);

    var msg_trans,msg_trans_01,msg_trans_02,msg_trans_03;
    switch(transfer_lang){
        case 'ru':
            msg_trans = "<i class='fa fa-info-circle'> Пожалуйста, учтите, что этот перевод автоматический и не может быть возвращен.</i> ";
            msg_trans_01 = "Ошибка при переводе между счетами.";
            msg_trans_02 = "Пожалуйста, заполните.";
            msg_trans_03 = "Пожалуйста, подтвердите действие";
            break;
        case 'zh':
            msg_trans = "<i class='fa fa-info-circle'> 请注意,这个转账是自动的,不能被退回.</i> ";
            msg_trans_01 = "账户间转账错误.";
            msg_trans_02 = "请填写.";
            msg_trans_03 = "Please confirm your action";
            break;
        default:
            msg_trans = "<i class='fa fa-info-circle'> Please note this transfer is automatic and can't be returned.</i> ";
            msg_trans_01 = "Transfer Between Accounts Error.";
            msg_trans_02 = "Please fill in.";
            msg_trans_03 = "Please confirm your action";
            break;
    }



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


    if(modalMsg.search("archived") !== -1){
        modalMsg = "Unfortunately, your receiver account has been archived after 90 days inactivity period. Please, contact support department at <a href='mailto:support@forexmart.com'>support@forexmart.com</a> if you want to restore the account.";
    }

    bootbox.alert({
        title: msg_trans_01,
        message: modalMsg,
        show: showModal
    });

    jQuery(document).on('click', '.complete-transfer', function(){
        bootbox.confirm({
            title: msg_trans_03,
            message: msg_trans,
            callback: function(result){
                if(result){
                    $('#transfer_form').submit();
                }
            }
        });
    });


    $(document).on('click', '.review-transfer', function(){

        var acc_rec=$('#account_receiver').val();
        var acc_amount=$('#amount').val();

        if(acc_rec.length<4){
            $('.accRecErr').addClass('border-red');
            return false;
        }else{
            $('.accRecErr').removeClass('border-red');
        }

        if(acc_amount<=0){
            $('.amountErr').addClass('border-red');
            return false;
        }else{
            $('.amountErr').removeClass('border-red');

        }


        var validate = 0;

        $('#transfer_form .required-field').each(function(index){

            if(!$(this).val().length){
                $(this).closest('div.form-group').find('span.error').text(msg_trans_02);
                validate++;
            }else{
                $(this).closest('div.form-group').find('span.error').text('');
            }

        });



                /*--------------bonus type code ------------------*/

                    var bonusType_data = 0;
                    if($("#inputbonus_type").is(':checked')){ 
                        bonusType_data = $('#inputbonus_type').val();
                    }

                    if($("#inputbonus_type_ten").is(':checked')){ 
                        bonusType_data = $('#inputbonus_type_ten').val();
                    }
                    
                //console.log("=============>",bonusType_data,"===================>");

                    var bonusType =(isNanVal(bonusType_data))?0:parseFloat(bonusType_data);

                    var bonusTypeTxt="";
                    switch (bonusType) {
                        case 30: 
                            bonusTypeTxt = 'tpb';                         
                            break;
                       case 20: 
                           bonusTypeTxt = 'twpb';                         
                            break;    
                      case 10: 
                          bonusTypeTxt = 'tenpb';                         
                            break;    
                        default:
                            break;
                    }
                    
//console.log(bonusType,"=============>",bonusTypeTxt,"===================>");

        if($('#transfe_bonus_finance').css('display') == 'none')
        {
              $("#bonus_type_ids").val(""); 

        }else{
              $("#bonus_type_ids").val(bonusTypeTxt); 
        }

 
        
                    

 /*--------------bonus type code end ------------------*/

         



        if( 0 === validate ){
            var comment = $('textarea#comment').val();
            if(comment == ''){
                $('div#comment-container').hide();
            }else {
                $('div#comment-container').show();
            }

            $('#txtReviewAmount').html($('input#amount').val());
            $('#txtReviewTransferTo').html($('input#account_receiver').val());
            $('#txtReviewComment').html($('textarea#comment').val());

            $('form#form-transfer-review').show();
            $('form#transfer_form').hide();
        }
    });

    jQuery(document).on('click', '.back-transfer', function(){
        $('form#transfer_form').show();
        $('form#form-transfer-review').hide();
    });


});