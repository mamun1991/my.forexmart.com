
<h1>
    My Account
</h1>

<?php $this->load->view('account_nav.php');?>

<style type="text/css">form.prof-form{  margin-top: 20px !important;  } a.close{ opacity: 0.8;  color: red;font-size: 30px; line-height: 0.6;  }  div.alert-danger{color: red; background-color: #F0CFCF; } .btn-remove-avatar { display: block; float: right !important; } .btn-remove-avatar:lang(sa) {float: left !important; } .btn-remove-avatar:lang(jp) {  padding: 4px 7px; }  @-moz-document url-prefix() {  @media screen and (max-width: 450px){ .rem_ava{      padding-bottom: 75px;  }  } } @media screen and (-webkit-min-device-pixel-ratio:0) and (max-width: 450px){  .rem_ava{  padding-bottom: 105px; } } .error{  margin-left: 42%; }
    .success-message{ display: none; color: #008000; text-align: center; } </style>
<input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="editprof">
        <div class="row">
            <div class="col-md-11 col-centered">
                <form class="form-horizontal prof-form" id="corporate_info_form">

                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-12 arabic-account-ver arabic-profile-label">
                            <span class="col-sm-12 success-message" ></span>
                        </label>

                    </div>

                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('cmp_dtls_02');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="company_name" id="company_name" class="form-control arabic-input-box round-0" maxlength="128" placeholder="<?=lang('cmp_dtls_02');?>" Value="<?php echo isset($company_info->company_name)?$company_info->company_name:'';?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_name" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        <span class="col-sm-6 name-error error" style="display: none"></span>
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('cmp_dtls_03');?>
                        </label>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="company_trading_name" id="company_trading_name" class="form-control round-0" maxlength="128" placeholder="<?=lang('cmp_dtls_03');?>" Value="<?php echo isset($company_info->company_trading_name)?$company_info->company_trading_name:'';?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_address" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        <span class="col-sm-6 address-error error" style="display: none"></span>
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('cmp_dtls_04');?>
                        </label>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="company_website" id="company_website" class="form-control round-0" maxlength="32" placeholder="<?=lang('cmp_dtls_04');?>" Value="<?php echo isset($company_info->website)?$company_info->website:'';?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_city" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        <span class="col-sm-6 city-error error" style="display: none"></span>
                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('cmp_dtls_05');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="business_type" id="business_type" class="form-control round-0" maxlength="32" placeholder="<?=lang('cmp_dtls_05');?>" Value="<?php echo isset($company_info->business_type)?$company_info->business_type:'';?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_state" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        <span class="col-sm-6 state-error error error-business-type" style="display: none"></span>
                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('cmp_dtls_06');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="contact_num" pattern="\d{3}[\-]\d{3}[\-]\d{4}" id="contact_num" class="form-control round-0" maxlength="16" placeholder="<?=lang('cmp_dtls_06');?>" Value="<?php echo isset($company_info->contact)?$company_info->contact:'';?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_zip" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        <span class="col-sm-6 zip-code-error contact-error error" style="display: none"></span>
                    </div>

                    <div class="form-group form-submit-group arabic-form-group-holder">
                        <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver"></div>
                        <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11 ' : '' ?> arabic-profile-bottom-button arabic-account-ver">

                            <button type="button" id="<?php echo isset($company_info->business_id)?'corporate_update_btn':'corporate_save_btn';?>" class="btn-submit arabic-btn-reverse"><?=lang('perdet_11');?></button>

                        </div>
                        <div class="col-sm-1 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11 ' : '' ?> arabic-account-ver"></div>
                        <div class="clearfix"></div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tip_name').tooltip({title: "<p align='left' style='padding: 5px !important;'>Company Name Field should be up to 128 characters.</p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});
        $('#tip_address').tooltip({title: "<p align='left' style='padding: 5px !important;'>If you use different trading name for your company, if not you can leave it blank</p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});
        $('#tip_city').tooltip({title: "<p align='left' style='padding: 5px !important;'>If you have Company Website, if none you can leave it blank.</p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});
        $('#tip_state').tooltip({title: "<p align='left' style='padding: 5px !important;'>Use comma if your company have multiple business type. (e.g. Banking, Finance, Accounting).</p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});
        $('#tip_zip').tooltip({title: "<p align='left' style='padding: 5px !important;'>Contact Number should be up to 32 characters.</p>", html: true, placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"});
    });
</script>


<script type="application/javascript" >
    $(document).ready(function(e){
        $("#corporate_save_btn").click(function(){
             companyInformation('save');
        });

        $("#corporate_update_btn").click(function(){
            companyInformation('update');
        });
    });
    function companyInformation(action){
        $('.error').hide();
        $('.success-message').hide();
        var error_status=false;

        if($("#company_name").val().length<1){
            $('.name-error').show();
            $('.name-error').text('Company name required');
            error_status=true;
        }
        if($("#contact_num").val().length<1){
            $('.contact-error').show();
            $('.contact-error').text('Contact number required');
            error_status=true;
        }
        if($("#business_type").val().length<1){
            $('.error-business-type').show();
            $('.error-business-type').text('Business type required');
            error_status=true;
        }
        if(error_status==false){
            var forgot_data = {
                name : $("#company_name").val(),
                number : $("#contact_num").val(),
                business_type : $("#business_type").val(),
                company_trading_name : $("#company_trading_name").val(),
                company_website : $("#company_website").val(),
                action:action
            };

            $.ajax({
                type: 'POST',
                url: "<?=site_url('')?>profile/corporate-info-save",
                dataType: 'json',
                data: forgot_data,
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x) {
                    if(x.success){
                        $(".success-message").show();
                        $(".success-message").text(x.message);
                        $('#loader-holder').hide();
                    }else{
                        $('#loader-holder').hide();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#loader-holder').hide();
                }
            });

        }
    }

    function validateURL(textval) {
        var urlregex = new RegExp(
            "^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
        return urlregex.test(textval);
    }

</script>
