<link type="text/css" rel="stylesheet" href="https://my.forexmart.com/assets/css/loaders.css"/>

    <style type="text/css" rel="stylesheet">
        .spn-4190{
            margin-left: 5px;
        }
        .spn-4190:hover {
            text-decoration: underline;
        }
        a#fee_ba:hover{
            text-decoration: none;
        }
        .btn-demo:lang(pt) {
            height: 56px;
            position: relative;
        }
        @media screen and (min-width:561px ){
            .btn-demo:lang(pt) {
                bottom: 20px!important;
            }
        }
        @media screen and (max-width:560px ){
            .btn-demo:lang(pt) {
                bottom: 10px!important;
            }
        }
        @media only screen and (max-width:420px){
            .form-bordered{
                border:none!important;
            }
            .form-title{
                margin-top: -6px!important;
                margin-bottom: 24px;
            }
            .form-input{
                margin-bottom: 18px;
            }
            .btn-cus-submit{
                margin-top: 10px!important;
                margin-bottom: 25px!important;
            }
            .orsighuptext{
                padding-top: 20px!important;
            }
            .social_login_button_box{
                padding: 6px 10px 0px 10px!important;
            }
            .other-info{
                margin-top: -5px!important;
            }
            .new-client-button-holder{
                padding: 0px 0px!important;
            }
            .new-client-buttons{
                margin-bottom: -4px!important;
            }
            .text-highlight{
                margin-top: 10px!important;
            }
        }

        .loader-holder {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 9999;
            background: rgba(0,0,0,0.8);
            top: 0;
            left: 0;
            display: none;
        }

        .loader
        {
            margin-left: 47%;
            margin-top: 20%;
        }

        .signin-bg{
                background-image: url('https://my.forexmart.com/assets/images/bg-client-signin.png')!important;
                background-repeat: no-repeat !important;
                background-attachment: fixed !important;
                background-position: center !important;
            padding: 5.3% 20px !important;
        }

        .no-border{
            border-top: none !important;
        }

        .form-group{
            margin-bottom: 0 !important;
        }

        .hideClientButton {
            display: none !important;
        }

        .wrongPassDiv{
            display: none;
        }

    </style>




<?php


$arrLang = array('my', 'ru', 'bg', 'cs', 'de', 'es', 'pl', 'jp','gr','vn');
$curLang=strtolower(FXPP::html_url());

if(in_array($curLang, $arrLang)) { ?>
    <style>
        @media screen and (min-width:768px) and (max-width:991px){
            .logo-img {
                max-width: 200px;
                padding-top: 7px !important;
            }
            a.mbtn.btn-reg.btn-reg2.custom-mbl-b {
                font-size: 14px !important;
            }
            a.mbtn.btn-partner-reg.btn-partner-reg2.custom-a.hidePartButton {
                font-size: 14px !important;
            }
            a.mbtn.btn-login.custom-mbl-c {
                font-size: 14px !important;
            }


            .nav>li>a {
                padding: 8px 4px !important;
            }
        }
    </style>

<?php }  ?>











<?php
    
      $form_data['social_data']=array('type'=>'client','reason'=>'signin','account'=>'live');
    
    
    if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){
        ?>

        <iframe id="my_iframe"  sandbox="allow-same-origin allow-scripts allow-popups allow-forms"  style="display: none" name="my_iframe" ></iframe>
    <?php }else{?>
        <iframe id="my_iframe"  sandbox="allow-same-origin allow-scripts allow-popups allow-forms"  style="display: none" name="my_iframe"  ></iframe>
    <?php }?>

    <div class="reg-form-holder signin-form-holder">
        <div class="sign-in-container-holder client-form-holder signin-bg">
            <div class="container">
                <!--             class="signin-box-container test3"-->
                <div class="form-holder form-bordered form-right">
                    <!--                signin-box-holder-content info-text-->
                    <h2 class="form-title">
                        <?php echo lang('cs_01'); ?>
                    </h2>
                    <?php
                    $landing = $this->session->userdata('landing-error');

                    if(isset($landing) && ($landing=='alreadyactivated')){
                        $error_act = '<div class="alert-style alert alert-success "><p>Account is already activated using this activation code.</p><p> We have sent access details to your email.</p> </div>';
                    }
                    else if(isset($landing) && ($landing=='country')){
                        $error_act = '<div class="alert-style alert alert-warning "><p>Country code is wrong.</p></div>';
                    }
                    else if(isset($landing) && ($landing=='mt4NotCreated')){
                        $error_act = '<div class="alert-style alert alert-warning " style="text-align: center;"><p>Some thing is wrong!</p><p> Please click again to activation link.</p> </div>';
                    }
                    else if(isset($landing) && ($landing)){
                        $error_act = '<div class="alert-style alert alert-warning "><p>Activation link is wrong.</p></div>';
                    }


                    echo $error_act;
                    $this->session->unset_userdata('landing-error');
                    ?>
                    <?php $landing = $this->session->userdata('landing');
                    if(isset($landing)){ ?>

                        <div class="alert-style alert alert-success ">
                            <p> Your email address has been confirmed.</p>
                            <p> We have sent access details to your email.</p>
                        </div>
                    <?php } $this->session->unset_userdata('landing');
                    ?>
                    <?php
                    $rst_pass = $this->session->userdata('rst_pass');
                    if(isset($rst_pass)){ ?>
                        <div class="resetl alert alert-success" style="">
                            <?=lang('cs_02');?>

                        </div>
                        <?php
                    }
                    $this->session->unset_userdata('rst_pass');
                    ?>

                    <?php
                    $wrongPassword = $this->session->flashdata("wrongPassword");
                    $accountBlocked = $this->session->flashdata("account-blocked");
                    $accountEU = $this->session->flashdata("account-eu");
                    $accountArchived = $this->session->flashdata("accountArchived");
                    $accountInvalid = $this->session->flashdata("account-invalid");

                    $accountNewTryAgain = $this->session->flashdata("accountNewTryAgain");





                    ?>

                    <div class="alert-style alert alert-danger wrongPassDiv">
                        <p  id="errorPtag"></p>

                    </div>

                    <?php




                    if(isset($accountBlocked)){ ?>
                        <div class="alert-style alert alert-danger">
                            <p>Your account has been blocked. Please contact support for further assistance.</p>
                        </div>
                    <?php }else if(isset($accountArchived)){?>

                        <div class="alert-style alert alert-danger">
                            <!--                        <p>Unfortunately, your account has been archived after 90 days inactivity period. Please, contact support department if you want to restore your account.</p>-->
                            <p>Your account has been deactivated due to 90 days inactivity period. Please contact support to restore your account.</p>
                        </div>
                    <?php }else if(isset($wrongPassword)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Your password is wrong. Please contact support for further assistance.</p>
                        </div>
                    <?php }else if(isset($accountInvalid)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Sign in with your acccount number and password.</p>
                        </div>
                    <?php }else if(isset($accountEU)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Please login <a href="https://personal.forexmart.eu/login">here.</a></p>
                        </div>
                    <?php }if(isset($accountNewTryAgain)){?>

                    <div class="alert-style alert alert-danger">
                        <p>Please try again.</p>
                    </div>
                    <?php } ?>


                    <?php if(isset($message)){ ?>
                        <div class="alert alert-style alert-warning">
                            <?=$message;?>
                        </div>
                    <?php } ?>











                    <div class="col-lg-12 col-md-12 col-centered">


                        <div class="form-holder" style="display: none">
                            <?php

                            if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){


                                //  echo '<iframe name="signout" style="display: none" src="https://my.forexmart.com/Signout/autoSignout"></iframe>';


                            }else{


                                // echo '<iframe name="signout" style="display: none" src="https://my.forexmart.eu/Signout/autoSignout"></iframe>';


                            }



                            if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){

                            ?>
                            <form id="form_login2"  action=""  class="form-horizontal" method="post"  target="my_iframe">
                                <?php
                                }else{

                                ?>
                                <form  id="form_login2" action=""  class="form-horizontal" method="post" target="my_iframe">
                                    <?php
                                    }
                                    ?>

                                    <div class="form-group">
                                        <div class="validation-result" id="validation-result">
                                            <div class="col-sm-10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group signin-form-group">
                                        <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                                Login
                                                <cite class="req">*</cite></label></div>
                                        <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                            <input type="text" name="username" value="" id="inputEmai2" class="form-control round-0 ext-arabic-form-control-placeholder" placeholder="Email or Account number">

                                            <div class="red signin-red">  </div>


                                        </div>
                                    </div>
                                    <div class="form-group signin-form-group">
                                        <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                                Password
                                                <cite class="req">*</cite></label></div>
                                        <div class="col-sm-12 signin-no-pad">
                                            <input type="password" name="password" value="" id="pass2" class="form-control round-0 ext-arabic-form-control-placeholder" placeholder="Password">

                                            <div class="red signin-red"> </div>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                            <a href="https://my.forexmart.com/forgot-password" class="signin-forgot ext-arabic-reversed-signin-forgot">
                                                Forgot Password?                                        <!--Forgot Password?-->
                                            </a>
                                            <button type="submit" id="btnRestore1" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">
                                                Submit                                        <!--Submit-->
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>                    </div>


                        <!-- class="form-holder"-->
                        <div>
                            <?= form_open(FXPP::my_url('client/signin'.$landingRedirect),array('id' => 'form_login','class'=> 'form-horizontal'),$output_key); ?>


                            <div class="form-group">
                                <div class="validation-result" id="validation-result">
                                    <div class="col-sm-10">
                                        <?php
                                        if (isset ( $notice['notice'])){
                                            echo '<div class="bg-success customr">';
                                            echo $notice['notice'];
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group signin-form-group">
                                <!--                            <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">-->
                                <!--                                    --><?//=lang('cs_03');?>
                                <!---->
                                <!--                                    <cite class="req">*</cite></label></div>-->
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content form-input clearfix">
                                    <?php echo form_input($username);?>
                                    <span class="i-form i-user i-right"></span>
                                    <span class="form-error"><?php echo  form_error('username')?> <?php echo  isset($errors['username'])?lang($errors['username']):"";?></span>


                                    <!--                                <div class="red signin-red">--><?php //echo  form_error('username')?><!-- --><?php //echo  isset($errors['username'])?lang($errors['username']):"";?><!-- </div>-->


                                </div>
                            </div>
                            <div class="form-group signin-form-group">
                                <!--                            <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">-->
                                <!--                                    --><?//=lang('cs_04');?>
                                <!---->
                                <!--                                    <cite class="req">*</cite></label></div>-->
                                <div class="col-sm-12 signin-no-pad form-input clearfix">
                                    <?php echo form_input($password);?>
                                    <span class="i-form i-lock i-right"></span>
                                    <span class="form-error"><?php echo  form_error('password')?> <?php echo  isset($errors['password'])?lang($errors['password']):"";?></span>

                                    <!--                                <div class="red signin-red">--><?php //echo  form_error('password')?><!-- --><?php //echo  isset($errors['password'])?lang($errors['password']):"";?><!--</div>-->


                                </div>
                            </div>
                            <div class="form-group">

                                <!--                            --><?php //if(IPLoc::Office()){  ?>
                                <!--                                <div style="text-align: left;">-->
                                <!--                                    --><?php //echo form_input($remember);?><!-- Remember Me-->
                                <!--                                </div>-->
                                <!--                            --><?php // }  ?>



                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                    <!--                                <a href="--><?php //echo FXPP::my_url('forgot-password');?><!--" class="signin-forgot ext-arabic-reversed-signin-forgot">-->
                                    <!--                                    --><?//=lang('cs_05');?>
                                    <!--                                    <!--Forgot Password?-->
                                    <!--                                </a>-->




                                    <button style="display: none" type="submit" id="btnRestore" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">
                                        <?=lang('cs_06');?>
                                        <!--Submit-->
                                    </button>














                                    <input type="hidden" name="goToPayment" value="<?= $goToPayment ?>">
                                    <button type="button" id="test" class="btn-cus-submit btn-submit signin-btn-submit ext-arabic-reversed-signin-submit btn-form btn-control">  <?=lang('cs_06');?></button>
                                    <a href="<?php echo FXPP::my_url('forgot-password');?>" class="btn-password">
                                        <?=lang('cs_05');?>
                                        <!--Forgot Password?-->
                                    </a>


                                    <?= $this->load->view('social_login', $form_data, TRUE); ?>



                                </div>

                                <div class="clearfix"></div>
                            </div>
                            <?php echo form_close()?>
                        </div>
                    </div>
                    <hr class="h-divider">
                    <div class="new-client-button-holder signin-no-pad no-border other-info">
                    <span class="text-blue">
                        <?=lang('cs_07');?>
                    </span>
                        <div  class="new-client-buttons ext-arabic-forex-buttons">
                            <!--                        <a target="_blank" href="--><?//= FXPP::www_url('register'); ?><!--" class="a-cutom btn-real btn-forex-submit">-->
                            <!--                            --><?//=lang('cs_08');?>
                            <!--                        </a>-->

                            <h3 class="text-highlight"><?=lang('cs_11');?></h3>
                            <a type="button" target="_blank" href="<?= FXPP::www_url('register'); ?>" class="a-cutom btn-real btn-forex-submit btn-form btn-bordered"><?=lang('cs_10');?></a>

                            <!--<a target="_blank" href="<?//= FXPP::www_url('register/demo'); ?>" class="btn-demo btn-forex-submit">
                           <?//=lang('cs_09');?>
                        </a>-->





                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        <?php /* ?>

        $(document).on("click","#test",function(){
            $("#loader-holder").show();
            <?php if(FXPP::isEUUrl()){?>
            $("#btnRestore1").click();
            setTimeout(function(){ $("#btnRestore").click(); }, 3000);

            <?php }else{?>

            $("#form_login").submit();
            <?php } ?>


        });

        <?php */ ?>


        $(document).on('blur',"#inputEmail3",function(){
            $("#inputEmai2").val($(this).val());
        });

        $(document).on('blur',"#pass",function(){
            $("#pass2").val($(this).val());
        });



        $(document).on('click', 'button#test', function () {

            <?php if(FXPP::isEUUrl()){?>

            $("#btnRestore1").click();
            setTimeout(function(){ $("#btnRestore").click(); }, 3000);

            <?php }else{?>

            var username = $('#inputEmail3').val();
            var password = $('#pass').val();
            var url = '<?= FXPP::ajax_url('client/signin_check_data_client'); ?>';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json',
                beforeSend: function () {
                    $("#loader-holder").show();
                },
                success: function (response) {
                    if (response) {
                        if(response.valid=='1' ){

                            $('.wrongPassDiv').hide();
                            $("#form_login").submit();

                        }else{
                            $("#loader-holder").hide();
                            $('.wrongPassDiv').show();
                            $('#errorPtag').html("<?=lang("auth_part_client_mesg_01");?>");

                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });



            <?php } ?>


        });


    </script>
    <link href="<?php echo $this->template->Css()?>view-signin.css" rel="stylesheet">


<!-- Start tag Criteo OneTag -->

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 82147},
        { event: "setEmail", email: "##User's email address##" }, // Can be an empty string
        { event: "setSiteType", type: deviceType},
        { event: "viewBasket", user_segment: "1", item: [
            {id: "1", price: 1, quantity: 1 }
//add a new entry for each product in your cart
        ]}
    );
</script>

<!-- End of tag Criteo OneTag -->






