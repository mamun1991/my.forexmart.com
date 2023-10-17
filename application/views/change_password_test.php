<?php include_once('profile_nav.php') ?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="min-height: 600px;">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-centered">
                <?php echo form_open('profile/change_password_dt', array('role' => 'form', 'class' => 'form-horizontal prof-form', 'id' => 'frmChangePassword')) ?>
                <?php if(isset($success)){ ?>
                    <?php if( $success ){ ?>
                        <div class="alert alert-success cntr">
                            <?=lang('chapas_00');?>
                        </div>
                    <?php }else{ ?>
                        <div class="alert alert-danger change-password-alert "><?php echo $tank_error ?></div>
                    <?php } ?>
                <?php }else{ ?>
                    <div class="alert alert-danger change-password-alert" style="display: none;"></div>
                <?php } ?>
                <div class="form-group">
                    <label id="cp_L" class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
                        <?=lang('chapas_01');?>
                        <cite class="req">*</cite></label>
                    <div id="cp_I" class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                        <input type="password" name="old_password" class="form-control round-0" id="old_password" placeholder="<?=lang('chapas_01_0');?>">
                        <?php echo form_error('old_password', '<span id="cp_A" class=" error">', '</span>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 <?= FXPP::html_url() == 'sa' ? 'col-lg-11 col-md-11 col-xs-12' : '' ?>">
                        <button type="submit" class="btn-submit arabic-btn-reverse">
                            <?=lang('chapas_04');?>
                        </button>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .cntr{
        text-align: center;
    }
    @media screen and (min-width: 752px) and (max-width: 1116px){
        @-moz-document url-prefix() {
            .input3:lang(fr){
                font-size: 13px;
            }
        }
    }
    @media screen and (min-width: 752px) and (max-width: 1116px){

        .input3:lang(fr){
            padding-right: 0px;
            padding-left: 0px;
        }
        .input2:lang(fr){
            padding-right: 0px;
            padding-left: 0px;
        }
        .input1:lang(fr){
            padding-right: 0px;
            padding-left: 0px;
        }
    }
    @media (min-width: 1200px)
        .col-lg-9 {
            float: left !important;
        }
</style>

<script>
    var language = '<?=FXPP::html_url()?>';
    $(document).ready(function(){
        str = language.replace(/\s/g, '');
        if (str === 'bg'){
            // cP current Password _L label _I input _A alerts
            $("#cp_L").removeClass("col-sm-4");
            $("#cp_L").addClass("col-sm-5");

            $("#cp_I").removeClass("col-sm-4");
            $("#cp_I").addClass("col-sm-3");

            $("#cp_A").removeClass("col-sm-4");
            $("#cp_A").addClass("col-sm-4");

            // nP new Password _L label _I input _A alerts
            $("#np_L").removeClass("col-sm-4");
            $("#np_L").addClass("col-sm-5");

            $("#np_I").removeClass("col-sm-4");
            $("#np_I").addClass("col-sm-3");

            $("#np_A").removeClass("col-sm-4");
            $("#np_A").addClass("col-sm-4");

            // rP re-enter Password _L label _I input _A alerts
            $("#rp_L").removeClass("col-sm-4");
            $("#rp_L").addClass("col-sm-5");

            $("#rp_I").removeClass("col-sm-4");
            $("#rp_I").addClass("col-sm-3");

            $("#rp_A").removeClass("col-sm-4");
            $("#rp_A").addClass("col-sm-4");
        }

    });
</script>