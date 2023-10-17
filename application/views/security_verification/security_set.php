<?php
    $this->load->view('profile_nav');
?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="<?= FXPP::html_url() != 'sa' ? 'min-height: 600px;' : '' ?>">




        <div class="row">
            <div class="col-md-12 col-centered <?= FXPP::html_url() == 'sa' ? 'col-lg-12 col-md-12 col-xs-12' : '' ?>">
                <div>
                   <h1>Your second step</h1>

                    <P> After entering your password, you’ll be asked for a second verification step.</P>

                </div>


                <?php echo validation_errors(); ?>

                <form method="post" action="<?=FXPP::my_url('security-verification/setting')?>" class="form-horizontal prof-form">

                    <?php

                    $flag = isset($auth['flag'])?$auth['flag']:0;
                    if($flag==0){?>

                        <div class="form-group">
                            <div class="col-md-12">
                                <h3>Let's set up your phone</h3>
                                <p>What phone number do you want to use?</p>
                            </div>

                            <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-4 col-xs-12' : '' ?>">
                                <input type="text" value="<?php echo set_value('mobile'); ?>" name="mobile" class="form-control round-0 col-md-6">
                            </div>
                            <div class="col-md-12"> Verification codes are sent by text message.</12>
                            <?php echo form_error('mobile', '<span class="col-sm-4 error">', '</span>') ?>

                        </div>


                    <div class="form-group">
                        <div class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8 col-xs-12' : '' ?> arabic-send-request">
                            <button type="submit" class="btn-submit">
                               TRY IT
                            </button>
                        </div><div class="clearfix"></div>
                    </div>

                <?php }else{?>


                    <div class="form-group">
                        <div class="col-md-12">
                            <h3>Confirm that it works</h3>
                            <p>ForexMart just sent a text message with a verification code to <?=$auth['phone']?>.</p>
                        </div>

                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-4 col-xs-12' : '' ?>">
                            <input type="text" value="<?php echo set_value('otp'); ?>" name="otp" class="form-control round-0 col-md-6">
                            <span class="red"> <?=$msg; ?></span>
                        </div>
                        <div class="col-md-12">Didn't get it? <a href="<?=FXPP::my_url('security_verification/resend')?>">Resend</a></div>


                    </div>


                    <div class="form-group">
                        <div class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8 col-xs-12' : '' ?> arabic-send-request">
                            <button type="submit" class="btn-submit">
                                TRY IT
                            </button>
                        </div><div class="clearfix"></div>
                    </div>
                    <?php } ?>

                </form>
            </div>

        </div>
    </div>
</div>
<style>
    .red{color: red;}
</style>
<script type="text/javascript">


    $("#sms_active").change(function(){

        if($(this).is(":checked")){
            $("#mobile").show();
        }else{
            $("#mobile").hide();
        }
    })

    $("#sms_deactive").change(function(){

        if($(this).is(":checked")){
            $("#mobile").hide();
        }else{
            $("#mobile").hide();
        }
    })
</script>