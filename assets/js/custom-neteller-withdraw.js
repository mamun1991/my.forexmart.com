/**
 * Created by Zeta-Venus on 3/21/2018.
 * TASK ID FXPP-9401
 */

/** NETELLER START */
    jQuery(document).ready(function() {


        var language = jQuery('#language').val();
        var err_msg_1,err_msg_2,err_msg_3,err_msg_4;

        switch(language){
            case 'ru':
                err_msg_1 = '<p class="field-req"> Недостаточно средств.</p>';
                err_msg_3 = '<p class="field-req">Необходимо заполнить это поле.</p>';
                err_msg_4 = '<p class="field-req">Пожалуйста, заполните.</p>';

                break;
            default:
                err_msg_1 = '<p class="field-req"> Not enough funds.</p>';
                err_msg_3 = '<p class="field-req">This field is required.</p>';
                err_msg_4 = '<p class="field-req">Please fill in.</p>';
                break;
        }


        var typingTimer;                //timer identifier
        var doneTypingInterval = 900;  //time in ms, 1 second for example
        var base_url = jQuery('#baseURL').val();

    //on keyup, start the countdown
        $('#amountWithdraw').keyup(function () {
            $('#btnNetellerContinue').data('disabled',true);
            clearTimeout(typingTimer);
            if ($('#amountWithdraw').val) {
                typingTimer = setTimeout(function () {

                    var amount = $('#amountWithdraw').val().trim();

                    $.ajax({
                        type: "post",
                        url: base_url + "withdraw/getNetellerFee",
                        data: 'amount=' + amount,
                        dataType: 'json',
                        success: function (x) {
                            console.log(x);
                            $('.fee-details').html((parseFloat(x.fee) * 100) + '% + ' + parseFloat(x.add_ons));
                            $('#tfee').val(roundtoTwo(x.total_fees));
                            $('#new_balance').val(roundtoTwo(x.new_balance));
                            $('#btnNetellerContinue').data('disabled',false);


                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#btnNetellerContinue').data('disabled',false);
                            console.log(xhr.status);
                            console.log(thrownError);
                        }
                    });

                }, doneTypingInterval);
            }
        });


        jQuery('#btnNetellerContinue').click(function () {
            if (!$(this).data('disabled')) {
                var total_input = jQuery('#frmWithdrawNeteller :input').length;
                jQuery('#frmWithdrawNeteller :input').each(function (index) {

                    if (!jQuery(this).val().length) {
                        jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
                    } else {
                        jQuery(this).closest('div.form-group').children('div.reqs').html('');
                    }

                    if (this.id == 'amountWithdraw') {
                        if (jQuery(this).val().length) {
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

                    if (total_input - 1 === index) {
                        if (!jQuery('#frmWithdrawNeteller p.field-req').length) {
                            //jQuery('#frmWithdrawNeteller :input').attr('readonly', 'readonly');
                            jQuery('#txtAccountNumber').html($('#accountNumber').data('accountnumber'));
                            jQuery('#txtAmountWithdraw').html(jQuery('#amountWithdraw').val());
                            jQuery('#txtAmountDeducted').html(parseFloat(jQuery('#amountWithdraw').val()) + parseFloat(jQuery('#tfee').val()));
                            jQuery('#txtNetellerID').html(jQuery('#netellerID').val());
                            jQuery('[id^="bt-tab"]').removeClass('active');
                            jQuery('#bt-tab2').addClass('active');
                        }
                    }
                });
            }
        });


        jQuery('#btnNetellerBack').click(function () {
            //jQuery('#frmWithdrawNeteller :input').each(function(){
            //    jQuery(this).removeAttr('readonly');
            //});
            jQuery('[id^="bt-tab"]').removeClass('active');
            jQuery('#bt-tab1').addClass('active');
        });

        jQuery('#btnNetellerSendRequest').click(function () {
            jQuery('#frmWithdrawNeteller :input').each(function (index) {
                var total_input = jQuery('#frmWithdrawNeteller :input').length;
                if (!jQuery(this).val().length) {
                    jQuery(this).closest('div.form-group').children('div.reqs').html(err_msg_3);
                } else {
                    jQuery(this).closest('div.form-group').children('div.reqs').html('');
                }

                if (total_input - 1 === index) {
                    if (!jQuery('#frmWithdrawNeteller p.field-req').length) {
                        //                    jQuery('#frmWithdrawBankTransfer').submit();
                        var url = jQuery('#baseURL').val();
                        jQuery.ajax({
                            type: "POST",
                            url: url + "withdraw/addNeteller",
                            data: jQuery('#frmWithdrawNeteller').serialize(),
                            dataType: 'json',
                            beforeSend: function () {
                                $('#loader-holder').show();
                            },
                            success: function (x) {
                                $('#loader-holder').hide();
                                jQuery('[id^="bt-tab"]').removeClass('active');
                                if (x.success) {
                                    var amount_requested = x.transaction_data.amount_requested;
                                    var fee = x.transaction_data.fee;
                                    jQuery('#txtNetellerSuccessAmountRequested').html(amount_requested);
                                    jQuery('#txtNetellerSuccessAccountNumber').html(x.transaction_data.account_number);
                                    jQuery('#txtNetellerSuccessNetellerID').html(x.transaction_data.client_inf);
                                    jQuery('#txtNetellerSuccessTransactionNumber').html(x.transaction_data.transaction_number);
                                    jQuery('#txtSuccessFee').html(parseFloat(fee).toFixed(4));
                                    jQuery('#bt-tab3').addClass('active');
                                } else {
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
                    } else {
                        jQuery('#bt-tab1').tab('show');
                    }
                }
            });
        });
    });

/** NETELLER END */

function roundtoTwo( value ){
    return +(Math.round(value + "e+2") + "e-2");
}
