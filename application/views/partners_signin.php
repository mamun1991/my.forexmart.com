


    <style>
        .a-cutom{
            text-decoration: none !important;
        }
        .red{ color: red; text-align: left!important;}
        .btn-adjust-button{padding-right: 0px !important;}
        @media screen and (-webkit-min-device-pixel-ratio:0) {
            .btn-demo:lang(es) {
                /*top: 10px;*/
                position: relative;
                /*height: 56px;*/
            }
            .btn-demo:lang(de) {
                top: -10px;
                position: relative;
                height: 56px;
            }
            .btn-demo:lang(pt) {
                /*top: 10px;*/
                position: relative;
                /*height: 56px;*/
            }
            .btn-demo:lang(fr) {
                height: 36px;
                position: relative;
                top: 0px;
            }
        }
        @-moz-document url-prefix() {
            .btn-demo:lang(es) {
                /*height: 56px;*/
                /*position: relative;*/
                bottom: 10px;
            }
            .btn-demo:lang(pt) {
                /*height: 56px;*/
                position: relative;
                /*bottom: 10px;*/
            }
            .btn-demo:lang(fr) {
                height: 36px;
                position: relative;
                bottom: 0px;
            }
        }
        @media screen and (max-width: 560px) {
            .btn-demo:lang(es) {
                margin: 10px;
            }
            .btn-demo:lang(pt) {
                margin: 10px;
            }
            @-moz-document url-prefix() {
                .btn-demo:lang(fr) {
                    margin: 10px;
                }

            }
            @media screen and (-webkit-min-device-pixel-ratio:0) {
                .btn-demo:lang(fr) {
                    margin: 0px;
                }
                .btn-real:lang(fr) {
                    margin: 0px;
                }
            }
        }
        .btn-real:lang(pt) {
            padding: 7px 5px;
        }
        .btn-real:lang(fr) {
            padding: 7px 5px;
        }
        .btn-demo:lang(de) {
            top: -10px;
            position: relative;
            height: 56px;
        }
        .de:lang(de){
            display: inline-block;
        }
        .de1:lang(de){
            display: inline-block;
            float: left;
        }
        .de2:lang(de){
            float: left;
            display: inline-block;
            top: 0;
        }

        .hidePartButton {
            display: none !important;
        }

        .wrongPassDiv {
            display: none;
        }

        .orsighuptext {
            color: #555 !important;
        }

        button#AccChknSubmit {
            text-transform: uppercase;
        }

        button.btn-real.btn-forex-submit.de1 {
            padding-left: 5px;
            padding-right: 5px;
        }
        button.btn-real.btn-forex-submit.de1:lang(sa) {
            padding-left: 25px;
            padding-right: 25px;
        }


    </style>



<?php if(strtolower(FXPP::html_url())=="es"){ ?>

    <style>
        .partnerSigninregibutton{
            margin: 0% 30%;
        }
    </style>

<?php } ?>


<?php


$arrLang = array('my', 'ru', 'bg', 'cs', 'de', 'es', 'pl', 'jp');
$curLang=strtolower(FXPP::html_url());


if(in_array($curLang, $arrLang)) { ?>

    <style>

        @media screen and (min-width:768px) and (max-width:991px){

            .logo-img {
                max-width: 200px;
                padding-top: 7px !important;
            }

            a.mbtn.btn-reg.btn-reg2.btn-partner-reg.custom-mbl-b.hideClientButton {
                font-size: 14px !important;
            }


            a.mbtn.btn-reg.btn-reg2.custom-mbl-b {
                font-size: 14px !important;
            }

            a.mbtn.btn-login.custom-mbl-c {
                font-size: 14px !important;
            }

            .btn-reg2{
                padding: 8px 5px!important;
            }


        }



    </style>



<?php }  ?>








    
    <div class="reg-form-holder signin-form-holder">
        <div class="sign-in-container-holder partners-form-holder">
            <div class="signin-box-container">
                <div class="signin-box-holder-content">
                    <h1 class="info-text">
                        <?=lang('ps_01');?>
                    </h1>

                    <?php

 $form_data['social_data']=array('type'=>'partner','reason'=>'signin','account'=>'live');

                     $somethingisWrong = $this->session->flashdata("somethingisWrong");
                    $wrongPassword = $this->session->flashdata("wrongPassword");
                    $accountBlocked = $this->session->flashdata("account-blocked");
                    $accountArchived = $this->session->flashdata("accountArchived");
                    $accountInvalid = $this->session->flashdata("account-invalid");
                    if(isset($accountBlocked)){ ?>
                        <div class="alert-style alert alert-danger">
                            <p>Your account has been blocked. Please contact support for further assistance.</p>
                        </div>
                    <?php }else if(isset($accountArchived)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Unfortunately, your account has been archived after 90 days inactivity period. Please, contact support department if you want to restore your account.</p>
                        </div>
                    <?php }else if(isset($wrongPassword)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Your password is wrong . Please contact support for further assistance.</p>
                        </div>
                    <?php }else if(isset($accountInvalid)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Sign in with your acccount number and password.</p>
                        </div>

                      <?php }else if(isset($somethingisWrong)){?>
                    
                     <div class="alert-style alert alert-danger">
                            <p>Something is wrong. Please,contact support department </p>
                        </div>
                    
                      <?php } ?>


                    <div class="alert-style alert alert-danger wrongPassDiv">
                        <p  id="errorPtag"></p>

                    </div>





                    <div class="col-lg-12 col-md-12 col-centered">

                        <div class="form-holder" >

                            <?= form_open(FXPP::loc_url('partner/signin'),array('id' => 'form_login','class'=> 'form-horizontal'),$output_key); ?>

                            <div class="form-group signin-form-group">
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                        <?=lang('ps_02');?>
                                        <cite class="req">*</cite></label></div>
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                    <?php echo form_input($username);?>
                                </div>
                                <span class="red signin-red"><p>

                                    <?php
                                    if(form_error('username'))  {
                                        echo lang('auth_validation_partner_login');
                                    }
                                    ?>

                                    <?php echo  isset($errors['username'])?lang($errors['username']):"";?> </p> </span>
                            </div>
                            <div class="form-group signin-form-group">
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                        <?=lang('ps_03');?>
                                        <cite class="req">*</cite></label></div>
                                <div class="col-sm-12 signin-no-pad">
                                    <?php echo form_input($password);?>
                                </div>
                                <span class="red signin-red"><p>

                                    <?php
                                    if(form_error('password'))  {
                                        echo lang('auth_validation_partner_pass');
                                    }
                                    ?>

                                    <?php echo  isset($errors['password'])?lang($errors['password']):"";?></p> </span>
                            </div>





                            <div class="form-group">
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                    <a href="<?php echo FXPP::my_url('forgot-password');?>" class="forgot signin-forgot ext-arabic-reversed-signin-forgot" >
                                        <?=lang('ps_04');?>
                                        <!--Forgot Password?-->
                                    </a>


                                    <?php /* ?>
                                    <button type="submit" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">
                                        <?=lang('ps_05');?>
                                        <!--Submit-->
                                    </button>

                                    <?php */ ?>



                                    <button id="AccChknSubmit" type="button" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit"><?=lang('cs_06');?>  </button>
<!--                                    <input id="AccChknSubmit" type="submit" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">-->
<!--                                    --><?//=lang('ps_05');?>
 
                                   <?= $this->load->view('social_login', $form_data, TRUE); ?>
                                    
                                    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php echo form_close()?>
                        </div>
                    </div>

                    <div class="new-client-button-holder signin-no-pad">
                    <span>                        <?=lang('ps_06');?>
                    </span>
                        <div class="new-client-buttons ext-arabic-forex-buttons">
                            <a target="_blank" href="<?= FXPP::www_url('partnership/registration'); ?>" class="a-cutom de">
                                <button class="btn-real btn-forex-submit de1 partnerSigninregibutton" >
                                    <?=lang('ps_07');?>
                                </button>
                            </a>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>






<script>

    $(document).keypress(function (e) {
        if (e.which == 13) {
            $('#AccChknSubmit').click();
            return false;    //<---- Add this line
        }
    });

    $(document).on('click', 'button#AccChknSubmit', function () {

        var username = $('#inputEmail3').val();
        var password = $('#pass').val();
                var url = '<?= FXPP::ajax_url('partner/signin_check_data'); ?>';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#loader-holder').show();
                    },
                    success: function (response) {
                        if (response) {
                            if(response=='1' ){
                                $('.wrongPassDiv').hide();
                                $('#form_login').submit();

                            }else{
                                $('.wrongPassDiv').show();
//                                $('#errorPtag').html('Your password is wrong. Please contact support for further assistance.');
                                $('#errorPtag').html("<?= lang("auth_part_client_mesg_01")?>");

                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                    }
                });
    });

</script>














