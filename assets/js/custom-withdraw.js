/**
 * Created by Zeta-Daryll on 8/13/2015.
 */
jQuery(document).ready(function(){

    var fee = jQuery('#fee').val();
    var ndb_bonus = jQuery('#ndb_bonus').val();
    var add_on = jQuery('#add_on').val();
    var min_request = jQuery('#min_amount_req').val();
    var is_micro = jQuery('#micro').val();
    var language = jQuery('#language').val();
    var is_eu_account = $('#is_from_eu').val();

    var msg_trans_01;
    var err_msg_1,err_msg_2,err_msg_3,err_msg_4,err_msg_5,err_msg_6,err_msg_7;

    switch(language){
        case 'ru':
            msg_trans_01 = "Переводы в этот банк не разрешены.";
            err_msg_1 = '<p class="field-req"> Недостаточно средств</p>';
            err_msg_2 = '<p class="field-req"> Минимальная сумма должна быть больше или равна USD 50. </p>';
            err_msg_3 = '<p class="field-req">Необходимо заполнить это поле.</p>';
            err_msg_4 = '<p class="field-req">Пожалуйста, заполните.</p>';
            err_msg_5 = '<p class="field-req">Срок действия карты уже истек.</p>';
            err_msg_6 = '<p class="field-req"> Недостаточно средств.</p>';
            err_msg_7 = '<p class="field-req"> Необходимо ввести данные китайскими иероглифами </p>';

            break;
        default:
            msg_trans_01 = "Transfers to this Bank are not allowed.";
            err_msg_1 = '<p class="field-req"> Not enough funds.</p>';
            err_msg_2 = '<p class="field-req"> Minimum amount must be greater than or equal to 50 USD. </p>';
            err_msg_3 = '<p class="field-req">This field is required.</p>';
            err_msg_4 = '<p class="field-req">Please fill in.</p>';
            err_msg_5 = '<p class="field-req">Card is already expired.</p>';
            err_msg_6 = '<p class="field-req"> Insufficient fund.</p>';
            err_msg_7 = '<p class="field-req"> Input must be in Chinese Characters </p>';
            break;
    }
    //jQuery('.numeric').autoNumeric('init');
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
/** BANK TRANSFER START */
   jQuery('#btnContinue').click(function(){
       var total_input = jQuery('#frmWithdrawBankTransfer :input').length;
       var bank_error = false;
       jQuery('#frmWithdrawBankTransfer :input').each(function(index){

           if(!jQuery(this).val().length){
               jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_4);
           }else{
               jQuery(this).closest('div.form-group').children('div.reqs').html('');
           }

           var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
           var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
           var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
           var walletCurrency = $('#accountNumber').data('currency');



           // if(this.id == 'beneficiaryBank' || this.id == 'bicCode' ){
           //     if(jQuery(this).val().length){
           //         if(jQuery('#beneficiaryBank').val().toUpperCase() == 'PRIVATBANK') {
           //             jQuery('#beneficiaryBank').addClass('errorClass');
           //             bank_error = true;
           //             jQuery('#bank-wire-error').html('Sorry, We cannot send a payment to Privatbank.');
           //             jQuery('#bank-wire-error').show();
           //         }else if(jQuery('#bicCode').val().toUpperCase().substring(0, 7) == "PBANUA2" ){
           //             jQuery('#bicCode').addClass('errorClass');
           //             bank_error = true;
           //             jQuery('#bank-wire-error').html('Sorry, We cannot send a payment to Privatbank.');
           //             jQuery('#bank-wire-error').show();
           //         }else{
           //             jQuery('#bank-wire-error').hide();
           //             bank_error = false;
           //             jQuery('#beneficiaryBank').removeClass('errorClass');
           //             jQuery('#bicCode').removeClass('errorClass');
           //         }
           //     }
           // }



           if(this.id == 'bicCode'){
               if(jQuery(this).val().length){
                   if(jQuery(this).val().toUpperCase().substring(0, 7) == "PBANUA2" ){
                       jQuery(this).addClass('errorClass');
                       bank_error = true;
                       jQuery('#bank-wire-error').html(msg_trans_01);
                       jQuery('#bank-wire-error').show();
                   }else{
                       bank_error = false;
                       jQuery(this).removeClass('errorClass');
                   }
               }
           }


           if(this.id == 'beneficiaryBank'){
               if(jQuery(this).val().length){
                   if(jQuery('#beneficiaryBank').val().toUpperCase() == 'PRIVATBANK') {
                       jQuery(this).addClass('errorClass');
                       bank_error = true;
                       jQuery('#bank-wire-error').html(msg_trans_01);
                       jQuery('#bank-wire-error').show();
               }else{
                       bank_error = false;
                       jQuery(this).removeClass('errorClass');
                   }
               }
           }






           if(this.id == 'amountWithdraw'){
               if(jQuery(this).val().length){
                   if(jQuery(this).val() >= 50){
                       var walletBalance = parseFloat($('#accountNumber').data('balance'));
                       var result = (!isNaN(amountReceive) && walletBalance >= amountReceive) ? true : false;
                       if(!result){
                           jQuery('#amtWithdrawErr').html(err_msg_1 );
                       }
                   }else{
                       jQuery('#amtWithdrawErr').html(err_msg_2);
                   }
               }
           }




           // if(this.id == 'amountWithdraw'){
           //     if(jQuery(this).val().length){
           //          if(jQuery(this).val() >= min_request){
           //              var walletBalance = parseFloat($('#accountNumber').data('balance'));
           //              var result = (!isNaN(amountReceive) && walletBalance >= amountReceive) ? true : false;
           //              if(!result){
           //                  jQuery('#amtWithdrawErr').html('<p class="field-req"> Not enough funds.</p>');
           //              }
           //          }else{
           //              if(walletCurrency == 'USD'){
           //                  jQuery('#amtWithdrawErr').html('<p class="field-req"> Minimum amount must be greater than or equal to 50 USD </p>');
           //              }else{
           //                  jQuery('#amtWithdrawErr').html("<p class='field-req'> Minimum amount must be greater than or equal to 50 USD or "+min_request+ ' ' + walletCurrency + " .</p>");
           //              }
           //
           //          }
           //     }
           // }

           if( total_input - 1 === index && !jQuery('#beneficiaryBank').hasClass('errorClass') && !jQuery('#bicCode').hasClass('errorClass') ){
                if(!jQuery('#frmWithdrawBankTransfer p.field-req').length){
                    jQuery('#bank-wire-error').hide();
                    //jQuery('#frmWithdrawBankTransfer :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBeneficiaryBank').html(jQuery('#beneficiaryBank').val());
                    jQuery('#txtBeneficiaryAddress').html(jQuery('#beneficiaryAddress').val());
                    jQuery('#txtBeneficiarySwift').html(jQuery('#beneficiarySwift').val());
                    //jQuery('#txtBeneficiaryAccount').html(jQuery('#beneficiaryAccount').val());
                    jQuery('#txtIbanorAccountNumber').html(jQuery('#ibanoraccountNumber').val());
                    jQuery('#txtBicCode').html(jQuery('#bicCode').val());
                    jQuery('#txtBeneficiaryStreet').html(jQuery('#beneficiaryStreet').val());
                    jQuery('#txtBeneficiaryCity').html(jQuery('#beneficiaryCity').val());
                    jQuery('#txtBeneficiaryState').html(jQuery('#beneficiaryState').val());
                    //jQuery('#txtBeneficiaryCountry').html(jQuery('#beneficiaryCountry').val());
                    var country = jQuery('#beneficiaryCountry').val();
                    var txt_country = $("#beneficiaryCountry option[value='" + country + "']").text();
                    jQuery('#txtBeneficiaryCountry').html(txt_country);
                    jQuery('#txtBeneficiaryPostal').html(jQuery('#beneficiaryPostal').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
           }
       });
   });

    jQuery('#btnBack').click(function(){
        //jQuery('#frmWithdrawBankTransfer :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnSendRequest').click(function(){
        jQuery('#frmWithdrawBankTransfer :input').each(function(index){
            var total_input = jQuery('#frmWithdrawBankTransfer :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBankTransfer p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankTransfer",
                        data: jQuery('#frmWithdrawBankTransfer').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtSuccessBankAccountNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });


/** BANK TRANSFER END */
/** NETELLER START */
    jQuery('#btnNetellerContinue').click(function(){

        var total_input = jQuery('#frmWithdrawNeteller :input').length;
        jQuery('#frmWithdrawNeteller :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawNeteller p.field-req').length){

                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawNeteller :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(2)));

                    jQuery('#txtNetellerID').html(jQuery('#netellerID').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnNetellerBack').click(function(){
        //jQuery('#frmWithdrawNeteller :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnNetellerSendRequest').click(function(){
        jQuery('#frmWithdrawNeteller :input').each(function(index){
            var total_input = jQuery('#frmWithdrawNeteller :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawNeteller p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addNeteller",
                        data: jQuery('#frmWithdrawNeteller').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtNetellerSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtNetellerSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtNetellerSuccessNetellerID').html(x.transaction_data.client_inf);
                                jQuery('#txtNetellerSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** NETELLER END */
/** SKRILL START */
    jQuery('#btnSkrillContinue').click(function(){

        var total_input = jQuery('#frmWithdrawSkrill :input').length;
        jQuery('#frmWithdrawSkrill :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSkrill p.field-req').length){





                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);

                    /*
                    var amount = $('#amountWithdraw').val().trim();
                    var amountDeducted = parseFloat(amount) * fee;
                    var totalFee = parseFloat(amount) + parseFloat(amountDeducted) + parseFloat(ndb_bonus);

                    var skrill_fee_limit = $('#skrill_fee_limit').val(),
                        system_fee = 0.01,
                        currency = $('#accountNumber').data('currency');

                    switch(currency){
                        case 'EUR':
                            var limitAmountFee = 10;
                            break;
                        default:
                            var limitAmountFee = skrill_fee_limit;
                    }

                    system_fee = parseFloat(amount) * parseFloat(system_fee);
                    if(!is_eu_account){
                        if(system_fee >= limitAmountFee ){
                            system_fee = limitAmountFee;
                        }
                    }
                    var amountReceive = parseFloat(system_fee) + parseFloat(totalFee);*/

                    //jQuery('#frmWithdrawSkrill :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(roundtoTwo(amountReceive));
                    jQuery('#txtSkrillAccount').html(jQuery('#skrillAccount').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnSkrillBack').click(function(){
        //jQuery('#frmWithdrawSkrill :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});

        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnSkrillSendRequest').click(function(){
        jQuery('#frmWithdrawSkrill :input').each(function(index){
            var total_input = jQuery('#frmWithdrawSkrill :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSkrill p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addSkrill",
                        data: jQuery('#frmWithdrawSkrill').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtSkrillSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtSkrillSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtSkrillSuccessSkrillAccount').html(x.transaction_data.client_inf);
                                jQuery('#txtSkrillSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** SKRILL END */

/** QIWI START */
    jQuery('#btnQiwiContinue').click(function(){

        var total_input = jQuery('#frmWithdrawQiwi :input').length;
        jQuery('#frmWithdrawQiwi :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawQiwi p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtQiwiId').html(jQuery('#qiwi_id').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnQiwiBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnQiwiSendRequest').click(function(){
        jQuery('#frmWithdrawQiwi :input').each(function(index){
            var total_input = jQuery('#frmWithdrawQiwi :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawQiwi p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addQiwi",
                        data: jQuery('#frmWithdrawQiwi').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtQiwiSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtQiwiSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtQiwiSuccessQiwiId').html(x.transaction_data.client_inf);
                                jQuery('#txtQiwiSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** QIWI END */

/** MegaTransfer START */
    jQuery('#btnMegaTransferContinue').click(function(){

        var total_input = jQuery('#frmWithdrawMegaTransfer :input').length;
        jQuery('#frmWithdrawMegaTransfer :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawMegaTransfer p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtMegaTransferUsername').html(jQuery('#megatransfer_username').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnMegaTransferBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnMegaTransferSendRequest').click(function(){
        jQuery('#frmWithdrawMegaTransfer :input').each(function(index){
            var total_input = jQuery('#frmWithdrawMegaTransfer :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawMegaTransfer p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addMegatransfer",
                        data: jQuery('#frmWithdrawMegaTransfer').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtMegaTransferSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtMegaTransferSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtMegaTransferSuccessMegaTransferUsername').html(x.transaction_data.client_inf);
                                jQuery('#txtMegaTransferSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** MegaTransfer END */

    /** Bitcoin START */
    jQuery('#btnBitcoinContinue').click(function(){
        var total_input = jQuery('#frmWithdrawBitcoin :input').length;
        jQuery('#frmWithdrawBitcoin :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val()) + parseFloat($("#tfee").val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBitcoin p.field-req').length){
                    var amountDeducted =  parseFloat($("#tfee").val());
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBitcoinAddress').html(jQuery('#bitcoin_address').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnBitcoinBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnBitcoinSendRequest').click(function(){
        jQuery('#frmWithdrawBitcoin :input').each(function(index){
            var total_input = jQuery('#frmWithdrawBitcoin :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBitcoin p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBitcoin",
                        data: jQuery('#frmWithdrawBitcoin').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtBitcoinSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtBitcoinSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtBitcoinSuccessBitcoinAddress').html(x.transaction_data.client_inf);
                                jQuery('#txtBitcoinSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** Bitcoin END */

    /** Yandex START */
    jQuery('#btnYandexContinue').click(function(){

        var total_input = jQuery('#frmWithdrawYandex :input').length;
        jQuery('#frmWithdrawYandex :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawYandex p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);

                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));

                    jQuery('#txtYandexWallet').html(jQuery('#yandex_wallet').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnYandexBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnYandexSendRequest').click(function(){
        jQuery('#frmWithdrawYandex :input').each(function(index){
            var total_input = jQuery('#frmWithdrawYandex :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawYandex p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addYandex",
                        data: jQuery('#frmWithdrawYandex').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtYandexSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtYandexSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtYandexSuccessYandexWallet').html(x.transaction_data.client_inf);
                                jQuery('#txtYandexSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** Yandex END */
    
/** DEBIT CREDIT CARDS START */
    jQuery('#btnDebitCreditContinue').click(function(){

        var total_input = jQuery('#frmWithdrawDebitCredit :input').length;

        jQuery('#frmWithdrawDebitCredit :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(!jQuery('#debitCreditExpiryMonth').val().trim().length || !jQuery('#debitCreditExpiryYear').val().length){
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
            }


            var d = new Date(),

                n = d.getMonth()+1,

                y = d.getFullYear();


            if( parseInt(jQuery('#debitCreditExpiryYear').val())<=y){

                if(parseInt(jQuery('#debitCreditExpiryMonth').val())<=n ){
                    jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_5);

                }else{
                    if(!jQuery('#debitCreditExpiryMonth').val().length || !jQuery('#debitCreditExpiryYear').val().length){
                        jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_3);
                    }else{
                        jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
                    }
                }

            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                   // var debitAmount = parseFloat($(this).val());
                    var debitAmount = parseFloat($(this).val()) + parseFloat($("#tfee").val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){

                if(!jQuery('#frmWithdrawDebitCredit p.field-req').length){


                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                   
                    //jQuery('#frmWithdrawDebitCredit :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtCardNumber').html(jQuery('#debitCreditCardNumber').val());
                    jQuery('#txtCardName').html(jQuery('#debitCreditCardName').val());
                    jQuery('#txtCardExpiry').html(jQuery('#debitCreditExpiryMonth option[value="' + jQuery('#debitCreditExpiryMonth').val() + '"]').text() + ' ' + jQuery('#debitCreditExpiryYear').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });


    jQuery('#btnDebitCreditBack').click(function(){

        //jQuery('#frmWithdrawDebitCredit select').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});

        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnDebitCreditSendRequest').click(function(){
        jQuery('#frmWithdrawDebitCredit :input').each(function(index){
            var total_input = jQuery('#frmWithdrawDebitCredit :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(!jQuery('#debitCreditExpiryMonth').val().length || !jQuery('#debitCreditExpiryYear').val().length){
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
            }



            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawDebitCredit p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addDebitCredit",
                        data: jQuery('#frmWithdrawDebitCredit').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtDebitCreditSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtDebitCreditSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtDebitCreditSuccessCardNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtDebitCreditSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** DEBIT CREDIT CARDS END */


    /** Payoma */


    jQuery('#btnPayomaSendRequest').click(function(){
        jQuery('#frmWithdrawDebitCredit :input').each(function(index){
            var total_input = jQuery('#frmWithdrawDebitCredit :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(!jQuery('#debitCreditExpiryMonth').val().length || !jQuery('#debitCreditExpiryYear').val().length){
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
            }



            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawDebitCredit p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addPayoma",
                        data: jQuery('#frmWithdrawDebitCredit').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtDebitCreditSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtDebitCreditSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtDebitCreditSuccessCardNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtDebitCreditSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });


    /** end Payoma  **/


/*** Start e-Merchant pay ***/


jQuery('#btnMegatransferCardSendRequest').click(function(){
    jQuery('#frmWithdrawDebitCredit :input').each(function(index){
        var total_input = jQuery('#frmWithdrawDebitCredit :input').length;
        if(!jQuery(this).val().length){
            jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
        }else{
            jQuery(this).closest('div.form-group').children('div.reqs').html('');
        }

        if(!jQuery('#debitCreditExpiryMonth').val().length || !jQuery('#debitCreditExpiryYear').val().length){
            jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html(err_msg_3);
        }else{
            jQuery('#debitCreditExpiryMonth').closest('div.form-group').children('div.reqs').html('');
        }

        if( total_input - 1 === index ){
            if(!jQuery('#frmWithdrawDebitCredit p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                var url = jQuery('#baseURL').val();
                jQuery.ajax({
                    type:"POST",
                    url: url+"withdraw/addMegatransferCard",
                    data: jQuery('#frmWithdrawDebitCredit').serialize(),
                    dataType: 'json',
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x){
                        $('#loader-holder').hide();
                        jQuery('[id^="bt-tab"]').removeClass('active');
                        if(x.success){
                            var amount_requested = x.transaction_data.amount_requested;
                            var fee = x.transaction_data.fee;
                            jQuery('#txtDebitCreditSuccessAmountRequested').html(amount_requested);
                            jQuery('#txtDebitCreditSuccessAccountNumber').html(x.transaction_data.account_number);
                            jQuery('#txtDebitCreditSuccessCardNumber').html(x.transaction_data.client_inf);
                            jQuery('#txtDebitCreditSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                            jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                            jQuery('#txtCardExpirySuccessTransactionNumber').html(x.transaction_data.card_expiry_month+ ' '+x.transaction_data.card_expiry_year);
                            jQuery('#txtDebitCreditSuccessCardName').html(x.transaction_data.cardName);

                            jQuery('#bt-tab3').addClass('active');
                        }else{
                            jQuery('#customError').html(x.errorMsg);
                            jQuery('#bt-tab4').addClass('active');
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
            }else{
                jQuery('#bt-tab1').tab('show');
            }
        }
    });
});

/** UNIONPAY START */
    jQuery('#btnUnionpayContinue').click(function(){

        var total_input = jQuery('#frmWithdrawUnionpay :input').length;

        jQuery('#frmWithdrawUnionpay :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){

                if(!jQuery('#frmWithdrawUnionpay p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + amountDeducted;
                    //jQuery('#frmWithdrawUnionpay :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountReceive').html(roundtoTwo(amountReceive));
                    jQuery('#txtBeneficiaryName').html(jQuery('#beneficiaryName').val());
                    jQuery('#txtBankAccount').html(jQuery('#bankAccount').val());
                    jQuery('#txtBankName').html(jQuery('#bankName').val());
                    jQuery('#txtBankBranch').html(jQuery('#bankBranch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bankProvince').val());
                    jQuery('#txtBankCity').html(jQuery('#bankCity').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnUnionpayBack').click(function(){
        //jQuery('#frmWithdrawUnionpay :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnUnionpaySendRequest').click(function(){
        jQuery('#frmWithdrawUnionpay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawUnionpay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawUnionpay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addUnionpay",
                        data: jQuery('#frmWithdrawUnionpay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_withdraw = x.transaction_data.amount_withdraw;
                                var amount_receive = x.transaction_data.amount_receive;
                                jQuery('#txtUnionpaySuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtUnionpaySuccessAmountWithdraw').html(parseFloat(amount_withdraw).toFixed(2));
                                jQuery('#txtUnionpaySuccessAmountReceive').html(parseFloat(amount_receive).toFixed(2));
                                jQuery('#txtUnionpaySuccessBankAccount').html(x.transaction_data.bank_account);
                                jQuery('#txtUnionpaySuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(x.transaction_data.fee);
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** UNIONPAY CARDS END */
    /** WEBMONEY START */
    jQuery('#btnWebmoneyContinue').click(function(){

        var total_input = jQuery('#frmWithdrawWebmoney :input').length;
        jQuery('#frmWithdrawWebmoney :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawWebmoney p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawPaxum :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtWebmoneyEmail').html(jQuery('#webmoneyEmail').val());
                    jQuery('#txtWebmoneyPurse').html(jQuery('#webmoneyPurse').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnWebmoneyBack').click(function(){
        //jQuery('#frmWithdrawPaxum :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnWebmoneySendRequest').click(function(){
        jQuery('#frmWithdrawWebmoney :input').each(function(index){
            var total_input = jQuery('#frmWithdrawWebmoney :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawWebmoney p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addWebmoney",
                        data: jQuery('#frmWithdrawWebmoney').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtWebmoneySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtWebmoneySuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtWebmoneySuccessWebmoneyEmail').html(x.transaction_data.email_address);
                                jQuery('#txtWebmoneySuccessWebmoneyPurse').html(x.transaction_data.client_inf);
                                jQuery('#txtWebmoneySuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** WEB MONEY END */
 
    /** MONETA START */
    jQuery('#btnMonetaContinue').click(function(){

        var total_input = jQuery('#frmWithdrawMoneta :input').length;
        jQuery('#frmWithdrawMoneta :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawMoneta p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawPaxum :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtMonetaAccount').html(jQuery('#monetaAccount').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnMonetaBack').click(function(){
        //jQuery('#frmWithdrawPaxum :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnMonetaSendRequest').click(function(){
        jQuery('#frmWithdrawMoneta :input').each(function(index){
            var total_input = jQuery('#frmWithdrawMoneta :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawMoneta p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addMoneta",
                        data: jQuery('#frmWithdrawMoneta').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                //   alert(fee);
                                console.log(x.transaction_data.account_number);
                                jQuery('#txtMonetaSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtMonetaSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtMonetaSuccessMonetaAccount').html(x.transaction_data.client_inf);
                                jQuery('#txtMonetaSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(2));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** MONETA END */
    /** SOFORT  START */

    jQuery('#btnSofortContinue').click(function(){

        var total_input = jQuery('#frmWithdrawSofort :input').length;
        jQuery('#frmWithdrawSofort :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSofort p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawPaxum :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtSofortAccount').html(jQuery('#sofortAccount').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnSofortBack').click(function(){
        //jQuery('#frmWithdrawPaxum :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnSofortSendRequest').click(function(){
        jQuery('#frmWithdrawSofort :input').each(function(index){
            var total_input = jQuery('#frmWithdrawSofort :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSofort p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addSofort",
                        data: jQuery('#frmWithdrawSofort').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                //   alert(fee);
                                console.log(x.transaction_data.account_number);
                                jQuery('#txtSofortSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtSofortSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtSofortSuccessSofortAccount').html(x.transaction_data.client_inf);
                                jQuery('#txtSofortSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(2));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** SOFORT END */




    /** PAXUM START */
    jQuery('#btnPaxumContinue').click(function(){

        var total_input = jQuery('#frmWithdrawPaxum :input').length;
        jQuery('#frmWithdrawPaxum :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPaxum p.field-req').length){
                    // var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawPaxum :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtPaxumID').html(jQuery('#paxumID').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnPaxumBack').click(function(){
        //jQuery('#frmWithdrawPaxum :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnPaxumSendRequest').click(function(){
        jQuery('#frmWithdrawPaxum :input').each(function(index){
            var total_input = jQuery('#frmWithdrawPaxum :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPaxum p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addPaxum",
                        data: jQuery('#frmWithdrawPaxum').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtPaxumSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtPaxumSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtPaxumSuccessPaxumID').html(x.transaction_data.client_inf);
                                jQuery('#txtPaxumSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** PAXUM END */
/** UKASH START */
    jQuery('#btnUkashContinue').click(function(){

        var total_input = jQuery('#frmWithdrawUkash :input').length;
        jQuery('#frmWithdrawUkash :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawUkash p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + amountDeducted;
                    //jQuery('#frmWithdrawUkash :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(roundtoTwo(amountReceive));
                    jQuery('#txtUkashAccount').html(jQuery('#ukashID').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnUkashBack').click(function(){
        //jQuery('#frmWithdrawUkash :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnUkashSendRequest').click(function(){
        jQuery('#frmWithdrawUkash :input').each(function(index){
            var total_input = jQuery('#frmWithdrawUkash :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawUkash p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addUkash",
                        data: jQuery('#frmWithdrawUkash').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                jQuery('#txtUkashSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtUkashSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtUkashSuccessUkashAccount').html(x.transaction_data.ukash_account);
                                jQuery('#txtUkashSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(x.transaction_data.fee);
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** UKASH END */
/** PAYCO START */
    jQuery('#btnPayCoContinue').click(function(){

        var total_input = jQuery('#frmWithdrawPayCo :input').length;
        jQuery('#frmWithdrawPayCo :input').each(function(index){
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                  
                  
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPayCo p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    //jQuery('#frmWithdrawPayCo :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtPayCoWallet').html(jQuery('#paycoWallet').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnPayCoBack').click(function(){
        //jQuery('#frmWithdrawPayCo :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        var transit = jQuery('#transit').val();
        if (transit == 'active') {
            jQuery('#bt-tab0').addClass('active');
        } else {
            jQuery('#bt-tab1').addClass('active');
        }
    });

    jQuery('#btnPayCoSendRequest').click(function(){
        jQuery('#frmWithdrawPayCo :input').each(function(index){
            var total_input = jQuery('#frmWithdrawPayCo :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPayCo p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addPayCo",
                        data: jQuery('#frmWithdrawPayCo').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtPayCoSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtPayCoSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtPayCoSuccessPayCoWallet').html(x.transaction_data.client_inf);
                                jQuery('#txtPayCoSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** PAYCO END */
/** FILSPAY START */
    jQuery('#btnFilsPayContinue').click(function(){

        var total_input = jQuery('#frmWithdrawFilsPay :input').length;
        jQuery('#frmWithdrawFilsPay :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawFilsPay p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + amountDeducted;
                    //jQuery('#frmWithdrawFilsPay :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(roundtoTwo(amountReceive));
                    jQuery('#txtFilsPayNumber').html(jQuery('#filspayNumber').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnFilsPayBack').click(function(){
        //jQuery('#frmWithdrawFilsPay :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnFilsPaySendRequest').click(function(){
        jQuery('#frmWithdrawFilsPay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawFilsPay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawFilsPay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addFilsPay",
                        data: jQuery('#frmWithdrawFilsPay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                jQuery('#txtFilsPaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtFilsPaySuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtFilsPaySuccessFilsPayNumber').html(x.transaction_data.filspay_number);
                                jQuery('#txtFilsPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(x.transaction_data.fee);
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** FILSPAY END */
/** CASHU START */

    $('#amountWithdraw').on('keyup blur', function(){
        var amount = $('#amountWithdraw').val().trim(),
            newBalance = 0,
            form_id = $(this).closest("form").attr("id");

      //  console.log('fee: '+fee);
      //  console.log('add_on: '+add_on);

        if(amount !== '' && amount.match(/^\d*\.?\d*$/)){
             var totalFee = parseFloat(amount) * parseFloat(fee) + parseFloat(add_on);

            //Skrill System Fee
          /*  if(form_id == 'frmWithdrawSkrill'){
                var skrill_fee_limit = $('#skrill_fee_limit').val(),
                    system_fee = 0.01,
                    currency = $('#accountNumber').data('currency');

                switch(currency){
                    case 'EUR':
                        var limitAmountFee = 10;
                        break;
                    default:
                        var limitAmountFee = skrill_fee_limit;
                }

                system_fee = parseFloat(amount) * parseFloat(system_fee);

                if(system_fee >= limitAmountFee ){
                    system_fee = limitAmountFee
                }
                totalFee = parseFloat(system_fee) + parseFloat(totalFee);
            }*/

            // bitcoin fee

            if(form_id == 'frmWithdrawBitcoin'){
              console.dir(amount);
              console.dir(free_fee_max_amount);
                if(amount >= free_fee_max_amount ){
                    totalFee = processing_fee;
                    totalFee = parseFloat(totalFee) + parseFloat(add_on);


                }
            }



            var totalAmountDeduct = parseFloat(amount) + parseFloat(totalFee);

            var walletBalance = parseFloat($('#accountNumber').data('balance'));
            var computeTotalBalance = walletBalance - totalAmountDeduct;

            if(computeTotalBalance > 0){
                newBalance = computeTotalBalance;
            }

            $('#tfee').val(roundtoTwo(totalFee));
            $('#tfee').attr('access',roundtoTwo(totalFee));
            $('#new_balance').val(roundtoTwo(newBalance));


            
        }

    });

    jQuery('#btnCashuContinue').click(function(){

        var total_input = jQuery('#frmWithdrawCashu :input').length;
        jQuery('#frmWithdrawCashu :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawCashu p.field-req').length){
                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + amountDeducted;
                    //jQuery('#frmWithdrawCashu :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(roundtoTwo(amountReceive));
                    jQuery('#txtCashuAccount').html(jQuery('#cashuAccount').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnCashuBack').click(function(){
        //jQuery('#frmWithdrawCashu :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnCashuSendRequest').click(function(){
        jQuery('#frmWithdrawCashu :input').each(function(index){
            var total_input = jQuery('#frmWithdrawCashu :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawCashu p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addCashU",
                        data: jQuery('#frmWithdrawCashu').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                jQuery('#txtCashuSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtCashuSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtCashuSuccessCashuAccount').html(x.transaction_data.cashu_account);
                                jQuery('#txtCashuSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(x.transaction_data.fee);
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** CASHSU END */
/** PAYPAL START */
    jQuery('#btnPaypalContinue').click(function(){

        var total_input = jQuery('#frmWithdrawPaypal :input').length;
        jQuery('#frmWithdrawPaypal :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                    
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPaypal p.field-req').length){

                    var amountDeducted = parseFloat(jQuery('#amountWithdraw').val()) * fee;

                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtPaypalAccount').html(jQuery('#paypalAccount').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });

    jQuery('#btnPaypalBack').click(function(){
        //jQuery('#frmWithdrawPaypal :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});

        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnPaypalSendRequest').click(function(){
        jQuery('#frmWithdrawPaypal :input').each(function(index){
            var total_input = jQuery('#frmWithdrawPaypal :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPaypal p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addPaypal",
                        data: jQuery('#frmWithdrawPaypal').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtPaypalSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtPaypalSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtPaypalSuccessPaypalAccount').html(x.transaction_data.client_inf);
                                jQuery('#txtPaypalSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
/** PAYPAL END */
    /** FasaPay Start **/
    jQuery('#btnFasaPayContinue').click(function(e){

        var total_input = jQuery('#frmWithdrawFasaPay :input').length;
        jQuery('#frmWithdrawFasaPay :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawFasaPay p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtFasaAccount').html(jQuery('#fasa_account').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnFasaPayBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnFasaPaySendRequest').click(function(){
        jQuery('#frmWithdrawFasaPay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawFasaPay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawFasaPay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addFasaPay",
                        data: jQuery('#frmWithdrawFasaPay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            console.log('test-btnFasaPaySendRequest');
                            console.log(x);
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtFasapaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtFasaSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtFasaPayaccSuccess').html(x.transaction_data.client_inf);
                                jQuery('#txtFasaPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });

    /** FasaPay End  **/

    /** CHINAUNIONPAY START */

    jQuery('#btnChinaUnionPayContinue').click(function(){

        var total_input = jQuery('#frmWithdrawChinaUnionPay :input').length;
        jQuery('#frmWithdrawChinaUnionPay :input').each(function(index){


            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["chinaUnionPay_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }


            // if(!jQuery(this).val().length){
            //     jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            // }else{
            //     jQuery(this).closest('div.form-group').children('div.reqs').html('');
            // }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawChinaUnionPay p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtChinaUnionPayAccount').html(jQuery('#chinaUnionPay_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());


                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnChinaUnionPayBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnChinaUnionPaySendRequest').click(function(){
        jQuery('#frmWithdrawChinaUnionPay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawChinaUnionPay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawChinaUnionPay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addChinaUnionPay",
                        data: jQuery('#frmWithdrawChinaUnionPay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtChinaUnionPaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtChinaUnionPaySuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtChinaUnionPayaccSuccess').html(x.transaction_data.client_inf);
                                jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /** CHINAUNIONPAY END */







    /** Alipay START */

    jQuery('#btnAlipayContinue').click(function(){

        var total_input = jQuery('#frmWithdrawAlipay :input').length;
        jQuery('#frmWithdrawAlipay :input').each(function(index){

            var isInputChinese = isChn(jQuery(this).val());


            var list_id = ["aliPay_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            // else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
            //     jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
            // }



            // if(!jQuery(this).val().length){
            //     jQuery(this).closest('div.form-group').children('div.reqs').html('<p class="field-req">This field is required.</p>');
            // }else{
            //     jQuery(this).closest('div.form-group').children('div.reqs').html('');
            // }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }


            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawAlipay p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtChinaUnionPayAccount').html(jQuery('#aliPay_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });


    });
    jQuery('#btnAlipayBack').click(function(){

        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');

    });
    jQuery('#btnAlipaySendRequest').click(function(){



        jQuery('#frmWithdrawAlipay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawAlipay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawAlipay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addAlipay",
                        data: jQuery('#frmWithdrawAlipay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                              console.log(x);
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtChinaUnionPaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtChinaUnionPaySuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtChinaUnionPayaccSuccess').html(x.transaction_data.client_inf);

                                jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });




    });
    /** Alipay END */



    // payTrust start

    jQuery('#btnPayTrustContinue').click(function(){
        
        var total_input = jQuery('#frmWithdrawPayTrust :input').length;
        jQuery('#frmWithdrawPayTrust :input').each(function(index){

            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["chinaUnionPay_account", "tfee", "new_balance","amountWithdraw","accountNumber"];

            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPayTrust p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtChinaUnionPayAccount').html(jQuery('#chinaUnionPay_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnPayTrustBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnPayTrustSendRequest').click(function(){

        jQuery('#frmWithdrawPayTrust :input').each(function(index){
            var total_input = jQuery('#frmWithdrawPayTrust :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawPayTrust p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addPayTrust",
                        data: jQuery('#frmWithdrawPayTrust').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                console.log(x);
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtChinaUnionPaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtChinaUnionPaySuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtChinaUnionPayaccSuccess').html(x.transaction_data.client_inf);

                                jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });

    // paytrust end

    // BANK NGN start

    jQuery('#btnBankNGNContinue').click(function(){

        var total_input = jQuery('#frmWithdrawBankNgn :input').length;
        jQuery('#frmWithdrawBankNgn :input').each(function(index){

       
            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBankNgn p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBankAccountNumber').html(jQuery('#bank_accountnumber').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnBankNGNBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnBankNGNSendRequest').click(function(){

        jQuery('#frmWithdrawBankNgn :input').each(function(index){
            var total_input = jQuery('#frmWithdrawBankNgn :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBankNgn p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankNgn",
                        data: jQuery('#frmWithdrawBankNgn').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                console.log(x);
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtAmountRequestedSuccess').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtForexAccountNumberSuccess').html(x.transaction_data.account_number);
                                jQuery('#txtBankAccountNumberSuccess').html(x.transaction_data.client_inf);

                                jQuery('#txtTransactionNumberSuccess').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtFeeSuccess').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });

    // paytrust end   // BANK MYR start

    jQuery('#btnBankMyrContinue').click(function(){

        var total_input = jQuery('#frmWithdrawBankMyr :input').length;
        jQuery('#frmWithdrawBankMyr :input').each(function(index){

            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["chinaUnionPay_account", "tfee", "new_balance","amountWithdraw","accountNumber"];

            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBankMyr p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtChinaUnionPayAccount').html(jQuery('#chinaUnionPay_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnBankMyrBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnBankMyrSendRequest').click(function(){

        jQuery('#frmWithdrawBankMyr :input').each(function(index){
            var total_input = jQuery('#frmWithdrawBankMyr :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawBankMyr p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankMyr",
                        data: jQuery('#frmWithdrawBankMyr').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                console.log(x);
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtChinaUnionPaySuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtChinaUnionPaySuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtChinaUnionPayaccSuccess').html(x.transaction_data.client_inf);

                                jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });

    // paytrust end





/*----------------------------- Withdraw via local bank transfer in THB ----------------*/
jQuery('#btnThbContinue').click(function(){

        var total_input = jQuery('#frmWithdrawThb :input').length;
        jQuery('#frmWithdrawThb :input').each(function(index){


            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["thb_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


//            if (!jQuery(this).val().length) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
//            } else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
//            } else {
//                jQuery(this).closest('div.form-group').children('div.reqs').html('');
//            }


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }
          
          

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    var feeAmount = parseFloat($("#tfee").val());
                    walletBalance=walletBalance-feeAmount;
                    
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawThb p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtThbAccount').html(jQuery('#thb_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());


                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnThbBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnThbSendRequest').click(function(){
        jQuery('#frmWithdrawThb :input').each(function(index){
            var total_input = jQuery('#frmWithdrawThb :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawThb p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankThb",
                        data: jQuery('#frmWithdrawThb').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtThbSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtThbSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtThbaccSuccess').html(x.transaction_data.client_inf);
                               // jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    
    
    /*----------------------------- Withdraw via local bank transfer in THB end----------------*/


    /*----------------------------- Withdraw via local bank transfer in VND ----------------*/
    jQuery('#btnVndContinue').click(function(){

        console.log('paytrust');

        var total_input = jQuery('#frmWithdrawVnd :input').length;
        jQuery('#frmWithdrawVnd :input').each(function(index){


            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["vnd_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


//            if (!jQuery(this).val().length) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
//            } else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
//            } else {
//                jQuery(this).closest('div.form-group').children('div.reqs').html('');
//            }


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }



            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    var feeAmount = parseFloat($("#tfee").val());
                    walletBalance=walletBalance-feeAmount;

                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawVnd p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtVndAccount').html(jQuery('#vnd_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());


                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnVndBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnVndSendRequest').click(function(){
        jQuery('#frmWithdrawVnd :input').each(function(index){
            var total_input = jQuery('#frmWithdrawVnd :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawVnd p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankVnd",
                        data: jQuery('#frmWithdrawVnd').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtVndSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtVndSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtVndaccSuccess').html(x.transaction_data.client_inf);
                                // jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });


    /*----------------------------- Withdraw via local bank transfer in VND end----------------*/

    /*----------------------------- Withdraw via local bank transfer in VND PaymentAsia ----------------*/
    jQuery('#btnVndAsiaContinue').click(function(){

        console.log(1);

        var total_input = jQuery('#frmWithdrawVndAsia :input').length;
        jQuery('#frmWithdrawVndAsia :input').each(function(index){


            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["vndasia_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


//            if (!jQuery(this).val().length) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
//            } else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
//            } else {
//                jQuery(this).closest('div.form-group').children('div.reqs').html('');
//            }


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }



            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    var feeAmount = parseFloat($("#tfee").val());
                    walletBalance=walletBalance-feeAmount;

                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawVndAsia p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtVndAsiaAccount').html(jQuery('#vndasia_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());


                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnVndAsiaBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnVndAsiaSendRequest').click(function(){
        jQuery('#frmWithdrawVndAsia :input').each(function(index){
            var total_input = jQuery('#frmWithdrawVndAsia :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawVndAsia p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankVndAsia",
                        data: jQuery('#frmWithdrawVndAsia').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtVndAsiaSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtVndAsiaSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtVndAsiaaccSuccess').html(x.transaction_data.client_inf);
                                // jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab4').addClass('active');
                            jQuery('#customError').html(x.errorMsg);
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });


    /*----------------------------- Withdraw via local bank transfer in VND PAYMENTASIA end----------------*/


    /*----------------------------- Withdraw via local bank transfer in IDR ----------------*/
    jQuery('#btnIdrContinue').click(function(){

        var total_input = jQuery('#frmWithdrawIdr :input').length;
        jQuery('#frmWithdrawIdr :input').each(function(index){


            var isInputChinese = isChn(jQuery(this).val());
            var list_id = ["idr_account", "tfee", "new_balance","amountWithdraw","accountNumber"];


//            if (!jQuery(this).val().length) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
//            } else if (jQuery(this).val().length && !isInputChinese && (jQuery.inArray(this.id, list_id) == -1)) {
//                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_7);
//            } else {
//                jQuery(this).closest('div.form-group').children('div.reqs').html('');
//            }


            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }



            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    var feeAmount = parseFloat($("#tfee").val());
                    walletBalance=walletBalance-feeAmount;
                    console.log(debitAmount+'::'+walletBalance+'::'+debitAmount);

                    if(debitAmount > 0){
                        // var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        // if(!result){
                        //     jQuery('#amtWithdrawErr').html(err_msg_1);
                        // }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawIdr p.field-req').length){

                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(2)));
                    jQuery('#txtIdrAccount').html(jQuery('#idr_account').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());


                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');
                }
            }
        });
    });
    jQuery('#btnIdrBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });
    jQuery('#btnIdrSendRequest').click(function(){
        jQuery('#frmWithdrawIdr :input').each(function(index){
            var total_input = jQuery('#frmWithdrawIdr :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawIdr p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addBankIdr",
                        data: jQuery('#frmWithdrawIdr').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtIdrSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtIdrSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtIdraccSuccess').html(x.transaction_data.client_inf);
                                // jQuery('#txtChinaUnionPaySuccessTransactionNumber').html(x.transaction_data.transaction_number);

                                jQuery('#txtBankAccountNameSuccess').html(jQuery('#bank_account_name').val());
                                jQuery('#txtBankNameSuccess').html(jQuery('#bank_name').val());
                                jQuery('#txtBankBranchSuccess').html(jQuery('#bank_branch').val());
                                jQuery('#txtBankProvinceSuccess').html(jQuery('#bank_province').val());
                                jQuery('#txtBankCitySuccess').html(jQuery('#bank_city').val());

                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(2));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });
    /*----------------------------- Withdraw via local bank transfer in IDR end----------------*/
    
    jQuery('#btnZPContinue').click(function(){

        var total_input = jQuery('#frmWithdrawZP :input').length;
        jQuery('#frmWithdrawZP :input').each(function(index){




            if (!jQuery(this).val().length) {
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            } else {
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    var walletBalance = parseFloat($('#accountNumber').data('balance'));
                    var debitAmount = parseFloat($(this).val());
                    if(debitAmount > 0){
                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                         jQuery('#amtWithdrawErr').html('<p class="field-req">Invalid amount.</p>');
                    }
                }
            }
            console.log(this.id);
            console.log(total_input - 1);
            console.log(index);
            if( total_input - 1 === index ){
                console.log('valid');
                if(!jQuery('#frmWithdrawZP p.field-req').length){
                    console.log('valid2');
                    var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
                    var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
                    var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBankAccountNumber').html(jQuery('#bank_account_number').val());

                    jQuery('#txtBankAccountName').html(jQuery('#bank_account_name').val());
                    jQuery('#txtBankName').html(jQuery('#bank_name').val());
                    jQuery('#txtBankBranch').html(jQuery('#bank_branch').val());
                    jQuery('#txtBankProvince').html(jQuery('#bank_province').val());
                    jQuery('#txtBankCity').html(jQuery('#bank_city').val());

                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnZPBack').click(function(){
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnZPSendRequest').click(function(){

        jQuery('#frmWithdrawZP :input').each(function(index){
            var total_input = jQuery('#frmWithdrawZP :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawZP p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addZotapay",
                        data: jQuery('#frmWithdrawZP').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){

                                console.log(x);
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtZPSuccessAmountRequested').html(parseFloat(amount_requested).toFixed(2));
                                jQuery('#txtZPSuccessForexAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtZPSuccessBankAccountNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtZPSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtZPSuccessBankAccountName').html(jQuery('#bank_account_name').val());
                                jQuery('#txtZPSuccessBankName').html(jQuery('#bank_name').val());
                                jQuery('#txtZPSuccessBankBranch').html(jQuery('#bank_branch').val());
                                jQuery('#txtZPSuccessBankProvince').html(jQuery('#bank_province').val());
                                jQuery('#txtZPSuccessBankCity').html(jQuery('#bank_city').val());

                                jQuery('#txtZPSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#customError').html(x.errorMsg);
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });









    /** SOFORT NEW START */
    jQuery('#btnContinue2').click(function(){
        var total_input = jQuery('#frmWithdrawSofort2 :input').length;
        jQuery('#frmWithdrawSofort2 :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_4);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
            var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
            var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
            var walletCurrency = $('#accountNumber').data('currency');

            // if(this.id == 'amountWithdraw'){
            //     if(jQuery(this).val().length){
            //          if(jQuery(this).val() >= min_request){
            //              var walletBalance = parseFloat($('#accountNumber').data('balance'));
            //              var result = (!isNaN(amountReceive) && walletBalance >= amountReceive) ? true : false;
            //              if(!result){
            //                  jQuery('#amtWithdrawErr').html('<p class="field-req"> Not enough funds.</p>');
            //              }
            //          }else{
            //              if(walletCurrency == 'USD'){
            //                  jQuery('#amtWithdrawErr').html('<p class="field-req"> Minimum amount must be greater than or equal to 50 USD </p>');
            //              }else{
            //                  jQuery('#amtWithdrawErr').html("<p class='field-req'> Minimum amount must be greater than or equal to 50 USD or "+min_request+ ' ' + walletCurrency + " .</p>");
            //              }
            //
            //          }
            //     }
            // }


            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    if(jQuery(this).val() >= 50){
                        var walletBalance = parseFloat($('#accountNumber').data('balance'));
                        var result = (!isNaN(amountReceive) && walletBalance >= amountReceive) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1);
                        }
                    }else{
                        jQuery('#amtWithdrawErr').html(err_msg_2);
                    }
                }
            }


            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSofort2 p.field-req').length){
                    //jQuery('#frmWithdrawBankTransfer :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumberSofort').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdrawSofort').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeductedSofort').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBeneficiaryBankSofort').html(jQuery('#beneficiaryBankSofort').val());
                    jQuery('#txtBeneficiaryAddressSofort').html(jQuery('#beneficiaryAddressSofort').val());
                    jQuery('#txtBeneficiarySwiftSofort').html(jQuery('#beneficiarySwiftSofort').val());
                    //jQuery('#txtBeneficiaryAccount').html(jQuery('#beneficiaryAccount').val());
                    jQuery('#txtIbanorAccountNumberSofort').html(jQuery('#ibanoraccountNumberSofort').val());
                    jQuery('#txtBicCodeSofort').html(jQuery('#bicCodeSofort').val());
                    jQuery('#txtBeneficiaryStreetSofort').html(jQuery('#beneficiaryStreetSofort').val());
                    jQuery('#txtBeneficiaryCitySofort').html(jQuery('#beneficiaryCitySofort').val());
                    jQuery('#txtBeneficiaryStateSofort').html(jQuery('#beneficiaryStateSofort').val());
                    //jQuery('#txtBeneficiaryCountry').html(jQuery('#beneficiaryCountry').val());
                    var country = jQuery('#beneficiaryCountrySofort').val();
                    var txt_country = $("#beneficiaryCountrySofort option[value='" + country + "']").text();
                    jQuery('#txtBeneficiaryCountrySofort').html(txt_country);
                    jQuery('#txtBeneficiaryPostalSofort').html(jQuery('#beneficiaryPostalSofort').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnBack2').click(function(){
        //jQuery('#frmWithdrawBankTransfer :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnSendRequest2').click(function(){
        jQuery('#frmWithdrawSofort2 :input').each(function(index){
            var total_input = jQuery('#frmWithdrawSofort2 :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawSofort2 p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addSofort",
                        data: jQuery('#frmWithdrawSofort2').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtSofortSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtSofortSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtSofortSuccessBankAccountNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtSofortSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSofortSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });


    /** SOFORT NEW END */

    /** INPAY START */
    jQuery('#btnInpayContinue').click(function(){
        var total_input = jQuery('#frmWithdrawInpay :input').length;
        var bank_error = false;
        jQuery('#frmWithdrawInpay :input').each(function(index){

            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_4);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            var totalFee = parseFloat(jQuery('#amountWithdraw').val()) * fee;
            var amountDeducted = parseFloat(totalFee) + parseFloat(add_on);
            var amountReceive = parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(amountDeducted.toFixed(4)) + parseFloat(ndb_bonus);
            var walletCurrency = $('#accountNumber').data('currency');


            if(this.id == 'bicCode'){
                if(jQuery(this).val().length){
                    if(jQuery(this).val().toUpperCase().substring(0, 7) == "PBANUA2" ){
                        jQuery(this).addClass('errorClass');
                        bank_error = true;
                        jQuery('#bank-wire-error').html(msg_trans_01);
                        jQuery('#bank-wire-error').show();
                    }else{
                        bank_error = false;
                        jQuery(this).removeClass('errorClass');
                    }
                }
            }


            if(this.id == 'beneficiaryBank'){
                if(jQuery(this).val().length){
                    if(jQuery('#beneficiaryBank').val().toUpperCase() == 'PRIVATBANK') {
                        jQuery(this).addClass('errorClass');
                        bank_error = true;
                        jQuery('#bank-wire-error').html(msg_trans_01);
                        jQuery('#bank-wire-error').show();
                    }else{
                        bank_error = false;
                        jQuery(this).removeClass('errorClass');
                    }
                }
            }






            if(this.id == 'amountWithdraw'){
                if(jQuery(this).val().length){
                    if(jQuery(this).val() >= 2){
                        var walletBalance = parseFloat($('#accountNumber').data('balance'));
                        var result = (!isNaN(amountReceive) && walletBalance >= amountReceive) ? true : false;
                        if(!result){
                            jQuery('#amtWithdrawErr').html(err_msg_1 );
                        }
                    }else{
                        jQuery('#amtWithdrawErr').html('<p class="field-req"> Minimum amount must be greater than or equal to 2 USD </p>');
                    }
                }
            }

            if( total_input - 1 === index && !jQuery('#beneficiaryBank').hasClass('errorClass')){
                if(!jQuery('#frmWithdrawInpay p.field-req').length){
                    jQuery('#bank-wire-error').hide();
                    //jQuery('#frmWithdrawBankTransfer :input').attr('readonly', 'readonly');
                    jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                    jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                    jQuery('#txtAmountDeducted').html(parseFloat(amountReceive.toFixed(4)));
                    jQuery('#txtBeneficiaryBank').html(jQuery('#beneficiaryBank').val());
                    jQuery('#txtBeneficiaryAddress').html(jQuery('#beneficiaryAddress').val());
                    jQuery('#txtBeneficiarySwift').html(jQuery('#beneficiarySwift').val());
                    //jQuery('#txtBeneficiaryAccount').html(jQuery('#beneficiaryAccount').val());
                    jQuery('#txtIbanorAccountNumber').html(jQuery('#ibanoraccountNumber').val());
                   // jQuery('#txtBicCode').html(jQuery('#bicCode').val());
                    jQuery('#txtBeneficiaryStreet').html(jQuery('#beneficiaryStreet').val());
                    jQuery('#txtBeneficiaryCity').html(jQuery('#beneficiaryCity').val());
                    jQuery('#txtBeneficiaryState').html(jQuery('#beneficiaryState').val());
                    //jQuery('#txtBeneficiaryCountry').html(jQuery('#beneficiaryCountry').val());
                    var country = jQuery('#beneficiaryCountry').val();
                    var txt_country = $("#beneficiaryCountry option[value='" + country + "']").text();
                    jQuery('#txtBeneficiaryCountry').html(txt_country);
                    jQuery('#txtBeneficiaryPostal').html(jQuery('#beneficiaryPostal').val());
                    jQuery('[id^="bt-tab"]').removeClass('active');
                    jQuery('#bt-tab2').addClass('active');

                }
            }
        });
    });

    jQuery('#btnInpayBack').click(function(){
        //jQuery('#frmWithdrawBankTransfer :input').each(function(){
        //    jQuery(this).removeAttr('readonly');
        //});
        jQuery('[id^="bt-tab"]').removeClass('active');
        jQuery('#bt-tab1').addClass('active');
    });

    jQuery('#btnInpaySendRequest').click(function(){
        jQuery('#frmWithdrawInpay :input').each(function(index){
            var total_input = jQuery('#frmWithdrawInpay :input').length;
            if(!jQuery(this).val().length){
                jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
            }else{
                jQuery(this).closest('div.form-group').children('div.reqs').html('');
            }

            if( total_input - 1 === index ){
                if(!jQuery('#frmWithdrawInpay p.field-req').length) {
//                    jQuery('#frmWithdrawBankTransfer').submit();
                    var url = jQuery('#baseURL').val();
                    jQuery.ajax({
                        type:"POST",
                        url: url+"withdraw/addInpay",
                        data: jQuery('#frmWithdrawInpay').serialize(),
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loader-holder').show();
                        },
                        success: function(x){
                            $('#loader-holder').hide();
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            if(x.success){
                                var amount_requested = x.transaction_data.amount_requested;
                                var fee = x.transaction_data.fee;
                                jQuery('#txtSuccessAmountRequested').html(amount_requested);
                                jQuery('#txtSuccessAccountNumber').html(x.transaction_data.account_number);
                                jQuery('#txtSuccessBankAccountNumber').html(x.transaction_data.client_inf);
                                jQuery('#txtSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                jQuery('#bt-tab3').addClass('active');
                            }else{
                                jQuery('#bt-tab4').addClass('active');
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
                }else{
                    jQuery('#bt-tab1').tab('show');
                }
            }
        });
    });

    /** INPAY END */


});

function roundtoTwo( value ){
    return +(Math.round(value + "e+2") + "e-2");
}

function isChn(str){
    return /^[\u4E00-\u9FA5]+$/.test(str);
}


