    <style type="text/css">
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


    </style>
<div class="reg-form-holder signin-form-holder">
    <div class="sign-in-container-holder client-form-holder">
        <div class="signin-box-container">
            <div class="signin-box-holder-content">
                <h1 class="info-text">
                    <?php echo lang('cs_01'); ?>
                </h1>
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
                    if(isset($accountBlocked)){ ?>
                        <div class="alert-style alert alert-danger">
                            <p>Your account has been blocked. Please contact support for further assistance.</p>
                        </div>
                    <?php }else if(isset($wrongPassword)){?>

                        <div class="alert-style alert alert-danger">
                            <p>Your password is wrong . Please contact support for further assistance.</p>
                        </div>
                <?php }else if(isset($accountEU)){?>

                    <div class="alert-style alert alert-danger">
                        <p>Please login <a href="https://personal.forexmart.eu/login">here.</a></p>
                    </div>
                <?php } ?>



                <?php if(isset($message)){ ?>
                    <div class="alert alert-style alert-warning">
                        <?=$message;?>
                    </div>
                <?php } ?>

                <div class="col-lg-12 col-md-12 col-centered">
                    <div class="form-holder">					
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
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                        <?=lang('cs_03');?>

                                        <cite class="req">*</cite></label></div>
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                    <?php echo form_input($username);?>

                                        <div class="red signin-red"><?php echo  form_error('username')?> <?php echo  isset($errors['username'])?lang($errors['username']):"";?> </div>


                                </div>
                            </div>
                            <div class="form-group signin-form-group">
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                        <?=lang('cs_04');?>

                                        <cite class="req">*</cite></label></div>
                                <div class="col-sm-12 signin-no-pad">
                                    <?php echo form_input($password);?>

                                        <div class="red signin-red"><?php echo  form_error('password')?> <?php echo  isset($errors['password'])?lang($errors['password']):"";?></div>


                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                    <a href="<?php echo FXPP::my_url('forgot-password');?>" class="signin-forgot ext-arabic-reversed-signin-forgot">
                                        <?=lang('cs_05');?>
                                        <!--Forgot Password?-->
                                    </a>
                                    <button type="submit" id="btnRestore" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">
                                        <?=lang('cs_06');?>
                                        <!--Submit-->
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php echo form_close()?>
                    </div>
                </div>
                <div class="new-client-button-holder signin-no-pad">
                    <span>
                        <?=lang('cs_07');?>
                    </span>
                    <div class="new-client-buttons ext-arabic-forex-buttons">
                        <a target="_blank" href="<?= FXPP::www_url('register'); ?>" class="a-cutom btn-real btn-forex-submit">
                            <?=lang('cs_08');?>
                        </a>

                        <a target="_blank" href="<?= FXPP::www_url('register/demo'); ?>" class="btn-demo btn-forex-submit">
                           <?=lang('cs_09');?>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<link href="<?php echo $this->template->Css()?>view-signin.css" rel="stylesheet">

    <iframe name="my-iframe" src="https://my.forexmart.com/client/signin"></iframe>


