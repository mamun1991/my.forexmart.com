<?php  $this->lang->load('forgotpassword'); ?>
<style type="text/css">
    div.forgot-success{
        text-align: center;
        padding: 30px;
        margin-top: 20px;
    }
    div.forgot-password-holder{
        min-height: 300px;
    }

    .col-sm-offset-2 {
        width: 58.2%;
    }

    @media screen and (max-width: 767px) {
        .btn-sign {
            float: none;
        }

        .col-sm-offset-2 {
            width: 100%;
        }
    }
    @media screen and (min-width: 1200px) {
        .reg-form-holder {
            min-height: 500px !important;
        }
    }

    /* Chrome, Safari, Edge, Opera | FXMAIN-85*/
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox | FXMAIN-85*/
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="reg-form-holder">
    <div class="container">
        <div class="row col-centered">
            <div class="forgot-password-holder">
                <h1 class="info-text">
                    <?=lang('for_pas_00')?>
<!--                    Forgot Password?-->
                </h1>
                <div class="col-lg-3 col-md-3 "></div>
                <?php
                    $wrong_email = $this->session->flashdata("wrong_email");
                    $flash = $this->session->userdata("userIdForRePass");
                    if(isset($flash))
                    {
                        $this->session->unset_userdata('userIdForRePass');
                        ?>
                        <div class="col-lg-6 col-md-6">
                            <div class="alert alert-success forgot-success">
                                <?=lang('for_pas_01')?>
<!--                                We sent you an email containing the link to reset your password.-->
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                <p>
                                    <?=lang('for_pas_02')?>
<!--                                    Fill in your email address.-->
                                </p>
                                <p>
                                    <?=lang('for_pas_03')?>
<!--                                    We will provide a link by email to reset your password.-->
                                </p>
                            </div>

                            <div class="form-holder" >

                                <?php
                                    if(strlen($wrong_email) > 10){
                                       echo  '<div class="col-lg-9 col-md-9 alert alert-danger">'.$wrong_email.'</div>';
                                    }
                                ?>

                                <div style="clear: both"></div>
                                <?php
                                if(validation_errors())
                                {
                                    echo '<div class="col-lg-9 col-md-9 alert alert-danger" style="float: none !important;">';
                                    echo validation_errors();
                                    echo '</div>';
                                }
                                ?>

                                <?= form_open(FXPP::my_url('forgot_password'),array('id' => 'form_login','class'=> 'form-horizontal')); ?>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <?=lang('for_pas_04')?>
<!--                                        Email-->
                                        <cite class="req">*</cite></label>
                                    <div class="col-sm-6">
                                        <input class="form-control round-0 call-validation" type="text" name="Email" msg="<?=lang('prof_fgt_02')?>" placeholder="Email" value="<?php echo set_value('Email');?>"/>
                                        <span style="color: red"> <?php echo form_error('checkExistingEmail'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">
                                        <?=lang('for_pas_05')?>
<!--                                        Account number-->
                                        <cite class="req">*</cite></label>
                                    <div class="col-sm-6">
                                        <input class="form-control round-0 call-validation" id="account_number" type="number" name="account_number" msg="<?=lang('prof_fgt_03')?>" placeholder="<?=lang('for_pas_05')?>" value="<?php echo set_value('account_number');?>"/>
                                       <span style="color: red"> <?php echo form_error('checkExistingAccountNumber'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button type="submit" class="btn-sign">
                                            <?=lang('for_pas_06')?>
<!--                                            Submit-->
                                        </button>
                                        <div class="clearfix"></div>
                                        <div class="blue-line"></div>
                                    </div>
                                </div>

                                <?php echo form_close()?>

                            </div>
                        </div>
                    <?php } ?>


            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        // $("#account_number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
//            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
//                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
//                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
//                return;
    //        }
            // Ensure that it is a number and stop the keypress
//            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
//                e.preventDefault();
//            }
//         });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){

        $(".btn-sign").click(function(e){
            $('.alert-danger').hide();
            e.preventDefault();
            var submit_form = false;
            var account_number = $('#account_number').val();
            $(".custome-span").remove();
            $('.call-validation').each(function(){
                var message=$(this).attr("msg");
                var values=  $(this).val();
                //console.log(values+", ");
                if(values.length <1){

                    submit_form=false;
                    $('.form-holder').prepend('<div class="col-lg-9 col-md-9 alert alert-danger" style="float: none !important;">'+ message+'</div>');

                    return false;
                } else{
                    if($(this).attr("name")=='Email'){
                        if(validateEmail($(this).val())==true){
                            submit_form=true;
                        } else{
                            submit_form=false;
                            if(account_number != '' || account_number == 0){
                                //console.log(valid_account_id+' testing');
                                $('.form-holder').prepend('<div class="col-lg-9 col-md-9 alert alert-danger" style="float: none !important;">'+ message+'</div>');
                            }

                        }
                    }
                }

            });
            if(submit_form ==true){
                $("#form_login").submit();
            }
        });

        $(document).on('keypress','#account_number', function (event) {
            var regex = new RegExp("^[a-zA-Z0-9]");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
            if(event.charCode < 48 || event.charCode > 57) return false;

            var foo = $(this).val()
            if (foo.length >= 10) { //specify text limit
                return false;
            }
            return true;
        });

        document.getElementById('account_number').addEventListener('keydown', function(e) { //FXMAIN-85
            if (e.which === 38 || e.which === 40) {
                e.preventDefault();
            }
        });
        //FXMAIN-85
        // disable mousewheel on a input number field when in focus
        // (to prevent Cromium browsers change the value when scrolling)
        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('wheel.disableScroll', function (e) {
                e.preventDefault()
            })
        })
        $('form').on('blur', 'input[type=number]', function (e) {
            $(this).off('wheel.disableScroll')
        })

    });



    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }

</script>

