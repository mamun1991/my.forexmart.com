function readInput(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('#avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

jQuery(document).ready(function(){

    var base_url = $('#base_url').val();

    jQuery("#fileupload").change(function() {
        var filename = jQuery(this).val().replace(/C:\\fakepath\\/i, '');
        jQuery("#profileAvatar").val(filename);
        var data_avatar = new FormData($('#frmProfile')[0]);
        console.log(data_avatar);
       
        if(filename){
            jQuery.ajax({
                type: 'POST',
                url: base_url + 'profile/uploadAvatar',
                data: data_avatar,
                dataType: 'json',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    if(x.success){
                        jQuery('#avatar').attr('src', x.src);
                        jQuery('#img-dp').attr('src', x.src);
                    }

                    var alertClass = (x.success) ? 'success' : 'danger'; //FXMAIN-125
                    jQuery('.col-alert').html("<div class='alert alert-"+ alertClass + "' style='opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;'>" + x.error + "</div>");

                    $('#loader-holder').hide();

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.col-alert').html('');
                    console.log(xhr.status);
                    console.log(thrownError);
                    if(thrownError == 'Request Entity Too Large'){
                        jQuery('.col-alert').html("<div class='alert alert-danger" + "' style='opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;'>" + 'File too large' + "</div>");
                    }
                    $('#loader-holder').hide();
                }
            });


        }


    });

    jQuery("#remove_avatar").click(function(event){
        event.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: base_url + 'profile/removeAvatar',
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
            },
            success: function(x){
                if(x.success){

                    jQuery("#fileupload").val('');
                    jQuery("#profileAvatar").val('');

                    jQuery('#avatar').attr('src', jQuery('#no-image').val());
                    jQuery('#img-dp').attr('src', jQuery('#no-image').val());

                }

                var alertClass = (x.success) ? 'success' : 'danger'; //FXMAIN-125
                jQuery('.col-alert').html("<div class='alert alert-"+ alertClass + "' style='opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;'>" + x.error + "</div>");

                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery('.col-alert').html('');
                console.log(xhr.status);
                console.log(thrownError);
                $('#loader-holder').hide();
            }
        });
    });

    $('body').on('click', '#pre-submit', function() { //FXMAIN-93

        $('.col-alert').html('');
        $('.error').hide();

        var email1 = $('#email_1').val();
        var email2 = $('#email_2').val();
        var email3 = $('#email_3').val();
        var emailError = false;

        if(email2 !== '' || email3 !== ''){

            if (email2 === email1 || email2 === email3) {
                emailError = true;
                $('.email2-error').html('Unable to add the same mail.');
                $('.email2-error').show();
                console.log('email2');
            }else{
                $('.email2-error').hide();
            }

            if (email3 === email1 || email3 === email2) {
                emailError = true;
                $('.email3-error').html('Unable to add the same mail.');
                $('.email3-error').show();
                console.log('email2');
            }else{
                $('.email3-error').hide();
            }

        }

        if(!emailError){
            $('.email-error').hide();
            $('.email2-error').hide();
            $('.email3-error').hide();
            $('#frmProfile').submit();
        }

    });

    jQuery("#frmProfile").on('submit',(function(event) {
        event.preventDefault();

        var userfullname=$(".userfullname").val();

        jQuery('.col-alert').html('<div class="alert alert-info" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">Updating profile...</div>');
        jQuery('.error').hide();
        jQuery.ajax({
            type: 'POST',
            url: base_url+'profile/updateProfile',
            dataType: 'json',
            data: new FormData(this),
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false,
            beforeSend: function(){
                $('#loader-holder').show();
            },
            success: function(x) {
                console.log(x);
                if(x.success){
                    jQuery('.col-alert').html('<div class="alert alert-success" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                    if (parseInt(x.account_status) === 1) {
                        jQuery('.form-submit-group').remove();
                    }


                    var fullName = userfullname;
                    var fullNameLength = fullName.length;
                    var updName='';
                    if(fullNameLength>11){
                        updName= fullName.substring(0, 11)+'...';
                    }else{
                        updName=userfullname;
                    }


                    // $("#userProfilenameofheader").html(userfullname);

                    $("#userProfilenameofheader").html(updName);




                }else{
                    if(x.validation_error) {
                        if (x.error == null) {
                            jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">There was no changes on your information.</div>');
                        } else {
                            jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                        }
                    }else{
                        jQuery('.col-alert').html('');
                        for( var item in x.error ){

                            if(x.error[item] != ''){
                                console.log(item);
                                jQuery('.' + item + '-error').html(x.error[item]);
                                jQuery('.' + item + '-error').show();
                            }
                        }
                    }
                }
                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery('.col-alert').html('');
                console.log(xhr.status);
                console.log(thrownError);
                $('#loader-holder').hide();
            }
        });
    }));

    // jQuery("#frmProfile").on('submit',(function(event) {
    //     event.preventDefault();
    //
    //     var userfullname=$(".userfullname").val();
    //
    //     jQuery('.col-alert').html('<div class="alert alert-info" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">Updating profile...</div>');
    //     jQuery('.error').hide();
    //     jQuery.ajax({
    //         type: 'POST',
    //         url: base_url+'profile/updateProfile',
    //         dataType: 'json',
    //         data: new FormData(this),
    //         contentType: false,       // The content type used when sending data to the server.
    //         cache: false,             // To unable request pages to be cached
    //         processData:false,        // To send DOMDocument or non processed data file it is set to false,
    //         beforeSend: function(){
    //             $('#loader-holder').show();
    //         },
    //         success: function(x) {
    //             console.log(x);
    //             if(x.success){
    //                 jQuery('.col-alert').html('<div class="alert alert-success" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
    //                 if (parseInt(x.account_status) === 1) {
    //                     jQuery('.form-submit-group').remove();
    //                 }
    //
    //                 $("#userProfilenameofheader").html(userfullname);
    //
    //
    //
    //             }else{
    //                 if(x.validation_error) {
    //                     if (x.error == null) {
    //                         jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">There was no changes on your information.</div>');
    //                     } else {
    //                         jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
    //                     }
    //                 }else{
    //                     jQuery('.col-alert').html('');
    //                     for( var item in x.error ){
    //
    //                         if(x.error[item] != ''){
    //                             console.log(item);
    //                             jQuery('.' + item + '-error').html(x.error[item]);
    //                             jQuery('.' + item + '-error').show();
    //                         }
    //                     }
    //                 }
    //             }
    //             $('#loader-holder').hide();
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             jQuery('.col-alert').html('');
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //             $('#loader-holder').hide();
    //         }
    //     });
    // }));

    jQuery(".phone-format").on("keypress",function (event) {
        if ((event.which != 43 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
});