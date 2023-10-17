
<h1>
    <?=lang('xnv_MyAcc');?>
</h1>

<?php if(IPLoc::VPN_IP_Jenalie()){?>
    <script src="<?= $this->template->Js()?>jquery-ui.js" ></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php } ?>

<?php $this->load->view('account_nav.php');?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active changePassDiv" id="pass" style="">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 col-centered">
                <?php echo form_open(FXPP::loc_url('profile/change_password'), array('role' => 'form', 'class' => 'form-horizontal prof-form', 'id' => 'frmChangePassword')) ?>
                <input type="hidden" name="form_key" value="<?php echo $form['form_key'] ?>" />
                <?php if(isset($success)){ ?>
                    <?php if( $success ){ ?>
                        <div class="alert alert-success change-password-alert cntr">
                            <?=lang('after_success_msg');?>
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
                    <div id="cp_I" class="col-sm-8  <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                        <input type="password" name="old_password" class="form-control round-0" id="old_password" placeholder="<?=lang('chapas_01_0');?>">
                        <?php echo form_error('old_password', '<span id="cp_A" class=" error">', '</span>') ?>
                        <span id="pre_error" class="error" style="display: none;">
                    </div>
                </div>

                    <!--
                    <div class="form-group">
                        <label id="cp_L" class="col-sm-4 <?//= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
                            New Password
                            <cite class="req">*</cite></label>
                        <div id="cp_I" class="col-sm-8 <?//= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                            <input type="password" name="new_password" class="form-control round-0" id="new_password" placeholder="Enter New Password">
                            <?php //echo form_error('old_password', '<span id="cp_A" class=" error">', '</span>') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label id="cp_L" class="col-sm-4 <?//= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
                            Confirm Password
                            <cite class="req">*</cite></label>
                        <div id="cp_I" class="col-sm-8 <?//= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                            <input type="password" name="new_password" class="form-control round-0" id="new_password" placeholder="Enter Confirm Password">
                            <?php //echo form_error('old_password', '<span id="cp_A" class=" error">', '</span>') ?>
                        </div>
                    </div>
                    -->

                <div class="form-group">
                    <div class="col-sm-12 <?= FXPP::html_url() == 'sa' ? 'col-lg-11 col-md-11 col-xs-12' : '' ?>">
                        <?php //if(IPLoc::VPN_IP_Jenalie()){?>
                            <a id="pre-submit" class="btn-submit arabic-btn-reverse" href="javascript:void(0)"><?=lang('chapas_04');?></a>
                        <?php //}else{ ?>
<!--                            <button type="submit" class="btn-submit arabic-btn-reverse">-->
<!--                                --><?//=lang('chapas_04');?>
<!--                            </button>-->
                        <?php //} ?>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="expired_session_modal" role="dialog" data-backdrop="static" data-keyboard="false" style="display:flex;padding-right:17px;align-items: center; position: relative;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p><?=lang('SessionExpired');?></p>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <a href="https://my.forexmart.com/signout" class="btn btn-default"><?=lang('ok');?></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_change_password" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p>Password can be changed once a day.</p>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <a id="confirm" href="javascript:void(0)">Confirm</a>
                <a id="cancel" href="javascript:void(0)">Cancel</a>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .change-password-alert{
        width: 80%;
        margin: auto;
        margin-bottom: 20px;
    }

    @media screen and (min-width: 1201px){
        .col-centered {
            float: none;
            margin-left: -37px;
        }
    }

    .changePassDiv{
        min-height: 600px;
    }
    .cntr{
        text-align: center;
    }

    @media screen and (max-width: 991px){
        .ssl-img{
            margin: 0px !important;
        }
        
         .ssl-img img{
           width: 20% !important;
        }
    }    
    
    @media screen and (max-width: 767px){
        .changePassDiv{
            min-height: 175px;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1023px){
        .changePassDiv {
            min-height: 230px;
        }

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
    @media (min-width: 1200px){
        .col-lg-9 {
            float: left !important;
        }
    }
    #pre-submit {
        text-decoration:none;
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

       


        <?php if( !empty($msg) ){ ?>
        setTimeout(function () {
            $('#expired_session_modal').modal('show');
            $('#expired_session_modal').modal({backdrop: 'static', keyboard: false});
        }, 2000);

        <?php }?>

        <?php //if(IPLoc::VPN_IP_Jenalie()){ ?>

        $('body').on('click', '#pre-submit', function(){

            if($('#old_password').val() === '' && $('#cp_A').is(":hidden")){
                $('#pre_error').css('display','block').html('Current Password is required.');
            }else{
                bootbox.confirm({
                    title: "Confirm Change Password",
                    message: "Password can be changed once a day",
                    buttons: {
                        confirm: {
                            label: 'Change',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result){
                        if(result){
                            $('#pre_error').css('display','none');
                            $('#frmChangePassword').submit();
                        }
                    }
                });
            }

        });

        <?php //} ?>


    });
</script>