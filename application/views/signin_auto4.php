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

    .ortext{
        margin-top: 7px;
        color: #b3b3b3;
    }

    .btn-google{
        font-size: 1.6rem;
        line-height: 5rem;
        height: 5rem;
        padding: 0 50px;
        color: #808080;
        background-color: #fff!important;
        border: none;
        font-weight: 600;
        transition: background-color .3s;
    }

    .btn-google:hover{
        background-color: #dadada !important;
        color: #333;
    }

    .btn-fb{
        background-color: #48639a !important;
        color: #fff !important;
        border: none;
        font-weight: 600;
        transition: background-color .3s;
        font-size: 1.6rem;
        line-height: 5rem;
        height: 5rem;
        padding: 0 50px;
        margin-top: 12px !important;
    }

    .btn-fb:hover{
        background-color: #375082 !important;
    }

    .google-icon{
        margin-right: 10px;
    }


</style>
<style>

</style>
<?php
if($_SERVER['SERVER_NAME'] === 'my.forexmart.eu'){
    ?>

    <iframe id="my_iframe"  sandbox="allow-same-origin allow-scripts allow-popups allow-forms"  style="display: none" name="my_iframe" ></iframe>
<?php }else{?>
    <iframe id="my_iframe"  sandbox="allow-same-origin allow-scripts allow-popups allow-forms"  style="display: none" name="my_iframe"  ></iframe>
<?php }?>

<div class="reg-form-holder signin-form-holder">
    <div class="sign-in-container-holder client-form-holder signin-bg">
        <div class="container">
            <!--             class="signin-box-container"-->
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
                $accountNewTryAgain = $this->session->flashdata("accountNewTryAgain");

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
                        <p>Your password is wrong. Please contact support for further assistance.</p>
                    </div>
                <?php }else if(isset($accountEU)){?>

                    <div class="alert-style alert alert-danger">
                        <p>Please login <a href="https://personal.forexmart.eu/login">here.</a></p>
                    </div>
                <?php } else if(isset($accountNewTryAgain)){?>

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
                        <form id="form_login2"  action="https://my.forexmart.com/client/signin"  class="form-horizontal" method="post"  target="my_iframe">
                            <?php
                            }else{


                            ?>
                            <form  id="form_login2" action="https://my.forexmart.eu/client/signin"  class="form-horizontal" method="post" target="my_iframe">
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
                                <button type="button" id="test" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit btn-form btn-control">  <?=lang('cs_06');?></button>
                                <a href="<?php echo FXPP::my_url('forgot-password');?>" class="btn-password">
                                    <?=lang('cs_05');?>
                                    <!--Forgot Password?-->
                                </a>
                                <p class="ortext">OR</p>
                                <?php
                                    echo $login_button;
                                ?>

                                <a href="#" class="btn btn-block btn-flat btn-fb">
                                    <img src="<?= $this->template->Images().'facebook.png'?>" height="25px" class="google-icon"> Sign in using Facebook</a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <?php echo form_close()?>

                        <?php echo $google_form; ?>
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
    $(document).on("click","#test",function(){
        $("#loader-holder").show();
        <?php if(FXPP::isEUUrl()){?>
        $("#btnRestore1").click();
        setTimeout(function(){ $("#btnRestore").click(); }, 3000);

        <?php }else{?>

        // $('#form_login2').submit();
        // $('form[name="iframe1"]').submit();
        $("#form_login").submit();
        <?php } ?>
    })

    $(document).on('blur',"#inputEmail3",function(){
        $("#inputEmai2").val($(this).val());
    })

    $(document).on('blur',"#pass",function(){
        $("#pass2").val($(this).val());
    })

    $(document).ready(function(){
    })


</script>
<link href="<?php echo $this->template->Css()?>view-signin.css" rel="stylesheet">




