$(document).ready(function(){

    $('span#neteller_'+field).html(message);
    console.log(message);
    $('#'+showForm).addClass('active');
    $('#'+showForm1).removeClass('active');

    if(showModal){
        console.log(details);
        jQuery('#txtNetellerSuccessAccountNumber').html(details['account_number']);
        jQuery('#txtNetellerSuccessAmount').html(details['amount']);
        jQuery('#txtNetellerSuccessAccount').html(details['neteller_account']);
        jQuery('#txtNetellerSuccessReferenceNumber').html(details['reference_number']);
        jQuery('[id^="nt-tab2"]').removeClass('active');
        jQuery('#nt-tab1').removeClass('active');
        jQuery('#nt-tab3').addClass('active');
    }

    jQuery('#btnNetellerBack').click(function(){
        jQuery('[id^="nt-tab2"]').removeClass('active');
        jQuery('#nt-tab').addClass('active');
    });

    jQuery('#btnNetellerRequest').on('click', function(){
        $('form#neteller-request-form').submit();
    });

    jQuery('#send-request').on('click', function(){
        console.log('submit');
        var errors = new Array(),
            submit = true,
            form = '#neteller-request-form';

        jQuery(form + " input").each(function(){

            // if('amount' == this.id) {
            //     if (this.value < 2) {
            //         if (jQuery('#micro_type').val() == 1) {
            //             console.log('micro');
            //             errors.push('min-amount');
            //         } else {
            //             errors.push('invalid-amount');
            //         }
            //         submit = false;
            //     }
            // }

            if( '' == jQuery( this ).val() ) {
                errors.push( this.name );
                submit = false;
            }
        });

        if(submit){
            console.log(jQuery('#account_number').val());
            jQuery('#txtAccountNumber').text(jQuery('#account_number').val());
            jQuery('#txtAmount').text(jQuery('#amount').val());
            jQuery('#txtAccount').text(jQuery('#neteller_account').val());
            jQuery('#txtSecureId').text(jQuery('#neteller_secure_id').val());
            jQuery('[id^="nt-tab"]').removeClass('active');
            jQuery('#nt-tab2').addClass('active');
        }else{
            for( error in errors){
                switch(errors[error]){
                    case 'amount':
                        $('span#neteller_amount').html('The Amount field is required.');
                        break;
                    // case 'invalid-amount':
                    //     $('span#neteller_amount').html('Minimum amount is 2.00 USD/GBP/RUR/EUR.');
                    //     break;
                    //FOR MICRO ACCOUNT
                    // case 'min-amount':
                    //     $('span#neteller_amount').html('Minimum amount is 2.00 USD/EUR.');
                    //     break;
                    // case 'max-amount':
                    //     $('span#neteller_amount').html('Maximum amount is 2.00 USD/EUR.');
                    //     break;
                    //END OF MICRO ACCOUNT
                    case 'neteller_account':
                        $('span#neteller_neteller_account').html('The Neteller account field is required.');
                        break;
                    case 'neteller_secure_id':
                        $('span#neteller_verificationCode').html('The Neteller Secured Id field is required.');
                        break;
                }
            }
        }

    });


});