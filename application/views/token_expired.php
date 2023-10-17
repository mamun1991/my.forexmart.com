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


</style>
<div class="reg-form-holder">
    <div class="container">
        <div class="row col-centered">
            <div class="forgot-password-holder">
                <h1 class="info-text">
                    Reset password
                    <!--                    Forgot Password?-->
                </h1>
                <div class="col-lg-3 col-md-3 "></div>

                <div class="col-lg-6 col-md-6">
                    <div class="alert alert-success forgot-success">
                        Reset password token has expired. <a href="<?php echo FXPP::loc_url('forgot-password')?>" class=""><?=lang('for_pas_00')?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
