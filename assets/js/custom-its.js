$(document).ready(function(){

    var width = $(window).width();
    if (width <= 359) {
        $('.block').addClass('btn-block');
    } else {
        $('.block').removeClass('btn-block');
    }

    $('#btn-submit').click(function () {
        if (!$('#email_input').val().length) {
            $('#email_input').change(function () {
                $(this).css('border-color', '#f11d1d');
            }).trigger('change');
            $('#email_input').focus();
        } else {
            var url = $('#baseURL').val();
            var email = $('#email_input').val();

            $.ajax({
                type:       'post',
                url:        url + 'deposit/getPaycoRegURLToken',
                data:       { email: email },
                dataType:   'json',
                beforeSend: function () {
                    $('.reg-div').hide();
                    $('.load-div').show();
                    $('.small-loader').show();
                },
                success: function (x) {
                    $('.small-loader').hide();
                    if (x.success) {
                        $('.reg-div').hide();
                        $('.load-div').show();
                        $('.msg-div').html('An email has been sent to your email <b>' + x.email + '</b>.');
                    } else {
                        $('.reg-div').show();
                        $('.load-div').hide();

                        $email_exist = x.error.includes('Registration completed already for');

                        if ($email_exist) {
                            $('.reg-link-error').html('PayCo account already exists for ' + $('#email_input').val());
                        } else {
                            $('.reg-link-error').html(x.error);
                        }
                    }
                }
            });
        }
    });

    // Transit Transfer Buttons
    $('#proceed_btn').click(function () {
        var input = $('#pin')[0];
        if (input.value < 1) {
            input.parentNode.nextElementSibling.innerHTML = '<p class="field-req">This field is required</p>';
        } else {
            input.parentNode.nextElementSibling.innerHTML = '';

            var url = $('#baseURL').val();
            var pin = $('#pin').val();
            var type = $('input[name="type"]:checked').val();

            $.ajax({
                type:       'POST',
                url:        url + 'withdraw/checkITSPIN',
                data:       {pin: pin},
                dataType:   'json',
                beforeSend: function () {
                    $('#loader-holder').show();
                },
                success: function (y) {
                    $('#loader-holder').hide();
                    if (!y.success) {
                        input.parentNode.nextElementSibling.innerHTML = '<p class="field-req">Incorrect PIN</p>';
                    } else {
                        input.parentNode.nextElementSibling.innerHTML = '';

                        $.ajax({
                            type:       'POST',
                            url:        url + 'withdraw/checkForexmartWallet',
                            dataType:   'json',
                            beforeSend: function() {
                                $('.small-loader').show();
                            },
                            success: function (x) {
                                $('.small-loader').hide();
                                if (x.result.Message !== 'Success' || x.result.Data < 1) {
                                    $('.modal-show-body').html('Transfer Transit not available for now. Please contact support@forexmart.com.');
                                    $('#popup').modal('show');
                                } else {
                                    if (y.verify != '') {
                                        $('#verify').html(y.verify);
                                        $('#verify').show();
                                        $('#btn-div').html('');
                                    }

                                    $('[id^="bt-tab"]').removeClass('active');
                                    if (type === 'request') {
                                        $('#bt-tab8').addClass('active');
                                    } else {
                                        $('#bt-tab5').addClass('active');
                                    }
                                    $('#popup').modal('hide');
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    $('#btnBackTransit, #btnBackRequest').click(function () {
        var input = $('#pin')[0];
        input.parentNode.nextElementSibling.innerHTML = '';

        $('[id^="bt-tab"]').removeClass('active');
        $('#bt-tab0').addClass('active');
    });

    $('#btnBackTransitForm').click(function(){
        $('[id^="bt-tab"]').removeClass('active');
        $('#bt-tab5').addClass('active');
    });

    $('#btnBackRequestForm').click(function(){
        $('[id^="bt-tab"]').removeClass('active');
        $('#bt-tab8').addClass('active');
    });

    var p = false, c = false;

    $('#btnTransitSubmit').click(function () {
        var url = $('#baseURL').val();
        $('#transit-form :input').each(function(index, item) {
            var total_input = $('#transit-form :input').length, partner = $('#p_wallet').val(), client = $('#c_wallet').val();
            if (!(item.name == 'transfer_nb')) {

                var client_num;
                if ($('#c_fm_account').val() === 'Other') {
                    client_num = $('#c_fm_account_input').val();
                } else {
                    client_num = $('#c_fm_account').val();
                }

                if (!$(this).val().length && item.name !== 'c_fm_account_input') {
                    $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                } else if (item.name === 'c_fm_account_input' && $('#c_fm_account').val() === 'Other' && !$('#c_fm_account_input').val().length) {
                    $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                } else {
                    $(this).closest('div.col-md-12').next('div.reqs').html('');

                    if (total_input - 2 === index) {
                        if (partner != client) {
                            $('#c_wallet').closest('div.col-md-12').next('div.reqs').html('');

                            if(!$('#transit-form p.field-req').length){
                                var acct_num = $('#accountNumber')[0];

                                if(this.id == 'amount_transfer'){
                                    if($(this).val().length){
                                        var walletBalance = parseFloat($('#accountNumber').data('balance'));
                                        var debitAmount = parseFloat($(this).val());
                                        var result = (!isNaN(debitAmount) && walletBalance >= debitAmount) ? true : false;

                                        if (!result) {
                                            $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req"> Insufficient fund.</p>');
                                        } else {
                                            if ($('#amount_transfer').val() < 2) {
                                                $('#amount_transfer').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Amount should be greater or equal to 2.</p>');
                                            } else {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: url + 'withdraw/checkWalletAccNumAndResellerData',
                                                    data: {
                                                        partner_wallet: partner,
                                                        client_wallet: client,
                                                        client_account_num: client_num
                                                    },
                                                    dataType: 'json',
                                                    beforeSend: function () {
                                                        $('#loader-holder').show();
                                                    },
                                                    success: function (x) {
                                                        $('#loader-holder').hide();

                                                        $.each(x.return, function (index, item) {
                                                            if (item.error) {
                                                                var label = $('#'+index).closest('div.col-md-12').children('label.control-label').text();
                                                                $('#'+index).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">'+ label.replace('*','') + item.error_message +'.</p>');
                                                            }
                                                        });

                                                        if (x.return.c_verify.error_message != '') {
                                                            $('#verify').html(x.return.c_verify.error_message);
                                                            $('#verify').show();
                                                            //$('#btn-div').html('');
                                                        }

                                                        if(!$('#transit-form p.field-req').length && !(x.return.c_verify.error)) {
                                                            $('#transit_account_number').html(acct_num.getAttribute('data-accountnumber'));
                                                            $('#p_amount_transfer').html($('#amount_transfer').val());
                                                            $('#p_tbl_wallet').html($('#p_wallet').val());

                                                            $('#c_tbl_wallet').html($('#c_wallet').val());
                                                            $('#c_tbl_acc_num').html($('#c_fm_account').val());

                                                            $('[id^="bt-tab"]').removeClass('active');
                                                            $('#bt-tab6').addClass('active');
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $('#c_wallet').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Receiver PayCo Wallet matched with your wallet. Please enter another PayCo Wallet.</p>');
                        }
                    }
                }
            }
        });
    });

    $('#btnPayCoTransitSendRequest').click(function(){
        var url = $('#baseURL').val();

        $.ajax({
            type:"POST",
            url: url+"withdraw/WalletTransfer",
            data: $('#transit-form').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
            },
            success: function(x){
                $('#loader-holder').hide();
                $('[id^="bt-tab"]').removeClass('active');
                console.log(x);
                if(x.success){
                    var transaction_id = x.result.CL.Data.transactionId;

                    $('#resultAmountTransferred').html(x.data.converted_amount);
                    $('#resultClientFMAccNum').html(x.data.c_fm_account);
                    $('#resultTransactionNumber').html(transaction_id);
                    $('#bt-tab7').addClass('active');
                }else{
                    $('#customError').html(x.errorMsg);
                    $('#bt-tab4').addClass('active');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                $('[id^="bt-tab"]').removeClass('active');
                $('#bt-tab4').addClass('active');
                $('#customError').html('Transit transfer failed. Please try again or contact us for more information.');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });

    $('#amount_transfer').on('keyup blur', function(){
        var amount = $('#amount_transfer').val().trim(),
            newBalance = 0;
        if(amount !== '' && amount.match(/^\d*\.?\d*$/)){
            var walletBalance = parseFloat($('#accountNumber').data('balance'));
            var computeTotalBalance = walletBalance - parseFloat(amount);

            newBalance = computeTotalBalance > 0 ? computeTotalBalance : 0;
            $('#transfer_nb').val(roundtoTwo(newBalance));
        }
    });

    $('#c_fm_account').on('change', function () {
        var wallet = $(this).find(':selected').data('wallet');
        var c_wallet = $('#c_wallet'), c_fm_account_input = $('#c_fm_account_input');

        if (wallet === 'other') {
            c_fm_account_input.show();
            c_fm_account_input.focus();
            $('#c_fm_account').val('Other');
            c_wallet.prop('readonly',false);
            c_wallet.attr('placeholder','Enter PayCo Wallet');
            c_wallet.val('');
        } else {
            c_wallet.prop('readonly',true);
            c_wallet.val(wallet);
            c_wallet.attr('placeholder','');
            c_fm_account_input.hide();
        }
    });

    $('#btnRequestSubmit').click(function () {
        var url = $('#baseURL').val();
        $('#request-form :input').each(function(index, item) {
            var total_input = $('#request-form :input').length;
            if (!(item.name == 'transfer_nb')) {
                if (!$(this).val().length) {
                    $(this).closest('div.col-md-12').next('div.reqs').html('<p class="field-req">This field is required.</p>');
                } else {
                    $(this).closest('div.col-md-12').next('div.reqs').html('');

                    if ($('#requested_amount').val() < 2) {
                        $('#requested_amount').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Amount should be greater or equal to 2.</p>');
                    } else if ($('#security_code').val().length < 6) {
                            $('#security_code').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">Please enter valid Security Code format (6 digits).</p>');
                    } else {
                        if (total_input - 2 === index) {
                            $.ajax({
                                type:       'POST',
                                url:        url + 'withdraw/checkSecurityCode',
                                dataType:   'json',
                                data:       { sec_code: $('#security_code').val(), client_account_num: $('#req_client').val() },
                                beforeSend: function() {
                                    $('#loader-holder').show();
                                },
                                success: function (x) {
                                    $('#loader-holder').hide();
                                    if (!x.success) {
                                        $('#security_code').closest('div.col-md-12').next('div.reqs').html('<p class="field-req">'+ x.message +'</p>');
                                    } else {
                                        if(!$('#request-form p.field-req').length){
                                            $('#rfa_c_acc_num').html($('#req_client').val());
                                            $('#rfa_amount').html($('#requested_amount').val() + ' ' + $('#accountNumber').data('currency'));
                                            $('#rfa_code').html($('#security_code').val());

                                            $('[id^="bt-tab"]').removeClass('active');
                                            $('#bt-tab9').addClass('active');
                                        }
                                    }
                                }
                            });
                        }
                    }
                }
            }
        });
    });

    $('#btnRequestWithdrawSubmit').click(function(){
        var url = $('#baseURL').val();

        $.ajax({
            type:"POST",
            url: url+"withdraw/RequestWalletTransfer",
            data: $('#request-form').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
            },
            success: function(x){
                $('#loader-holder').hide();
                $('[id^="bt-tab"]').removeClass('active');
                $('#reqAmount').html(x.data.amount_transfer);
                $('#convAmount').html(x.data.conv_amount);
                $('#affAccNum').html(x.data.account_num);
                $('#secCode').html(x.data.security_code);
                $('#refNum').html(x.data.referral_id);
                $('#bt-tab10').addClass('active');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                $('[id^="bt-tab"]').removeClass('active');
                $('#bt-tab4').addClass('active');
                $('#customError').html('Transit Transfer request failed. Please try again or contact us for more information.');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });



});