<style>
    .red{ color: red; text-align: left!important;}
    .customr{
        color: #008000;
        padding: 10px 100px;
    }
    .resetl{
        text-align: center;
    }

    @media screen and (-webkit-min-device-pixel-ratio:0) {
        .btn-demo:lang(es) {
            top: 10px;
            position: relative;
            height: 56px;
        }
        .btn-demo:lang(pt) {
            top: 10px;
            position: relative;
            height: 56px;
        }
        .btn-demo:lang(fr) {
            height: 56px;
            position: relative;
            top: 10px;
        }
    }
    @-moz-document url-prefix() {

        .btn-demo:lang(es) {
            height: 56px;
            position: relative;
            bottom: 10px;
        }
        .btn-demo:lang(pt) {
            height: 56px;
            position: relative;
            bottom: 10px;
        }
        .btn-demo:lang(fr) {
            height: 56px;
            position: relative;
            bottom: 10px;
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
</style>
<div class="reg-form-holder signin-form-holder">
    <div class="sign-in-container-holder client-form-holder">
        <div class="signin-box-container">
            <div class="signin-box-holder-content">
                <h1 class="info-text">
                    <?=lang('cs_01');?>

                </h1>

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


                <div class="col-lg-12 col-md-12 col-centered">
                    <div class="form-holder">
                        <?= form_open(FXPP::my_url('client/signin1'),array('id' => 'form_login','class'=> 'form-horizontal'),$output_key); ?>
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
                                    <?=lang('cs_03_ac');?>

                                    <cite class="req">*</cite></label></div>
                            <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                <?php echo form_input($username);?>
                                <span class="red signin-red"><p><?php echo  form_error('username')?> <?php echo  isset($errors['username'])?lang($errors['username']):"";?> </p> </span>
                            </div>
                        </div>
                        <div class="form-group signin-form-group">
                            <div class="col-sm-12 signin-no-pad ext-arabic-partners-content"><label class="signin-control-label">
                                    <?=lang('cs_04');?>

                                    <cite class="req">*</cite></label></div>
                            <div class="col-sm-12 signin-no-pad">
                                <?php echo form_input($password);?>
                                <span class="red signin-red"><p><?php echo  form_error('password')?> <?php echo  isset($errors['password'])?lang($errors['password']):"";?></p> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 signin-no-pad ext-arabic-partners-content">
                                <a href="<?php echo FXPP::loc_url('forgot-password');?>" class="signin-forgot ext-arabic-reversed-signin-forgot">
                                    <?=lang('cs_05');?>
                                    <!--Forgot Password?-->
                                </a>
                                <button type="submit" class="btn-submit signin-btn-submit ext-arabic-reversed-signin-submit">
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

                        <a target="_blank" href="<?= FXPP::www_url('register'); ?>" class="">
                            <button class="btn-real btn-forex-submit ">
                                <?=lang('cs_08');?>

                            </button>
                        </a>

                        <a target="_blank" href="<?= FXPP::www_url('register/demo'); ?>" class="">
                            <button class="btn-demo btn-forex-submit">
                                <?=lang('cs_09');?>
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>