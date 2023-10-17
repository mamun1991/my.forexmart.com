<script src="<?= $this->template->Js()?>jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php include_once('profile_nav.php') ?>
<style type="text/css">

    .red-border-part {
        border:1px solid red!important;
    }
    form.prof-form{
        margin-top: 20px !important;
    }
    a.close{
        opacity: 0.8;
        color: red;
        font-size: 30px;
        line-height: 0.6;
    }
    div.alert-danger{
        color: red;
        background-color: #F0CFCF;
    }
    .btn-remove-avatar {
        display: block;
        float: right !important;
    }
    .btn-remove-avatar:lang(sa) {
        float: left !important;
    }
    .btn-remove-avatar:lang(jp) {
        padding: 4px 7px;
    }
    @-moz-document url-prefix() {
        @media screen and (max-width: 450px){
            .rem_ava{
                padding-bottom: 75px;
            }
        }
    }
    @media screen and (-webkit-min-device-pixel-ratio:0) and (max-width: 450px){
        .rem_ava{
            padding-bottom: 105px;
        }
    }
    .datepicker {
        z-index:9999 !important;
    }

    @media screen and (max-width: 767px){
        .form-group.arabic-form-group-holder {
            position: relative;
        }

        .arabic-form-group-holder i.tooltip-upload-docs {
            position: absolute;
            top: 2px;
            right: 25px;
        }
    }
	.hide-msg{
		display: none;
	}

</style>
<input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="editprof">
        <div class="row">
            <div class="col-md-12 col-centered col-alert">
                <?php if($has_request){?>
                    <div class="alert alert-success" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;"><?=lang('dc_alert').' '.$date_change_alert?></div>
               <?php } ?>
            </div>
            <div class="col-md-9 col-centered">
                <form class="form-horizontal prof-form" id="frmProfile">
                    <!-- <p id="dsc"><?=lang('dc_alert');?></p> -->
                    <div class="form-group">
                        <div class="rem_ava col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver">
                            <div class="dp-holder dp-holder2">
                                <input type="hidden" id="profileAvatar" name="profile_avatar" value="<?php echo $user_data['image'] ?>" />
                                <input type="hidden" id="no-image" value="<?= $this->template->Images()?>avatar.png" />
				<?php if($this->session->userdata('oauth_id')){?>
                                    <img src="<?php echo $user_data['image']  ?>" id="avatar" class="dp">
                                <?php }else{ ?>
                                <img src="<?php echo $user_data['image'] ? base_url('assets/user_images/' . $user_data['image']) : $this->template->Images() . 'avatar.png' ?>" id="avatar" class="dp">
    				<?php } ?>
                                <div style="clear: both;"></div>
                                <button id="remove_avatar" class="btn-remove-avatar">
                                    <?=lang('perdet_00');?>

                                </button>
                            </div>
                        </div>
                        <div class="col-sm-8 btn-capt-holder <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-8 col-xs-12' : '' ?> arabic-account-ver arabic-browse-button-holder">
                            <span class="btn btn-success fileinput-button fileup arabic-browse-button">
                                <span><i class="fa fa-download"></i>
                                    <?=lang('perdet_01');?>...
                                </span>
                                <input id="fileupload" type="file" name="avatar" multiple>
                            </span>
                        </div>
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_02');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="name" class="form-control arabic-input-box round-0" maxlength="128" placeholder="<?=lang('perdet_02');?>" Value="<?php echo $user_data['name'] ?>">
                            <span class="name-error error" style="display: none"></span>
                        </div>
                        <p><i style="color: blue; vertical-align: middle;" id="tip_name" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_03');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="address" class="form-control round-0" maxlength="128" placeholder="<?=lang('perdet_03');?>" Value="<?php echo $user_data['address'] ?>">
                            <span class="address-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_address" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_04');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="city" class="form-control round-0" maxlength="32" placeholder="<?=lang('perdet_04');?>" Value="<?php echo $user_data['city'] ?>">
                            <span class="city-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_city" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_05');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="state" class="form-control round-0" maxlength="32" placeholder="<?=lang('perdet_05');?>" Value="<?php echo $user_data['state'] ?>">
                            <span class="state-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_state" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_06');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="zip_code" class="form-control round-0" maxlength="16" placeholder="<?=lang('perdet_06');?>" Value="<?php echo $user_data['zip_code'] ?>">
                            <span class="zip-code-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_zip" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <?php
                    $country_code = array('BY','RU','UA','MD','AM','AZ','GE','KZ','GB',);
                    if (in_array($user_data['country'], $country_code)){

                    ?>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_07');?>(1)
                            <cite class="req">*</cite>
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input id="tel_1" type="text" name="telephone_1" class="form-control round-0 phone-format tel_1" maxlength="32" placeholder="First phone number" Value="<?php echo $user_data['telephone1'] ?>" required>
                                </div>
                                <div class="col-sm-3 tick1">
                                    <?php
                                    if($user_data['phone_verified_1']==1){ ?>
                                        <i id="phoneVerifiedIcon" class="fa fa-check fa-2x text-success" style="color:green"></i>
                                    <?php }
                                    else{ ?>
                                        <a id="verify-mbl-1" class="btn btn-primary btn-md btn-secondary" href="JavaScript:void(0)">Verify</a>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <span class="telephone-error error" style="display: none"></span>
                        </div>
                        <p><i style="color: blue; vertical-align: middle;" id="tip_telephone1" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>

					<div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label arabic-account-ver arabic-profile-label"></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
						    <input type="text" id="sms-code-1" name="sms_code_1" class="form-control round-0 phone-format sms1-input" maxlength="32" placeholder="“Please , enter SMS code”." Value="<?php echo $user_data['sms_code_1'] ?>" style="margin-bottom: 15px;" required>
                            <a id="verify-submit-1" class="btn btn-primary btn-secondary btn-md" href="JavaScript:void(0)">Set Code</a>
						    <div class="clearfix"></div>
						    <div  style="margin-top: 15px;" id="suc-code-1" class="alert alert-success hide-msg">Verification Successful, Thank you!</div>
                            <div id="error-code-1" class="alert alert-danger hide-msg" style="margin-top: 2px">Verification code is not match, Please enter valid code or resend code</div>
                        </div>
                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                        <?=lang('perdet_07');?>(2)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input id="tel_2" type="text" name="telephone_2" class="form-control round-0 phone-format tel_2" maxlength="32" placeholder="<?=lang('second_phone');?>" Value="<?php echo $user_data['telephone2'] ?>" required>
                                </div>
                                <div class="col-sm-3 tick2">
                                    <?php if($user_data['phone_verified_2']==1){ ?>
                                        <i id="phoneVerifiedIcon2" class="fa fa-check fa-2x text-success" style="color:green"></i>
                                    <?php }else{ ?>
                                        <a id="verify-mbl-2" class="btn btn-primary btn-md btn-secondary" href="JavaScript:void(0)">Verify</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <p><i style="color: blue; vertical-align: middle;" id="tip_telephone2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label arabic-account-ver arabic-profile-label"></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" id="sms-code-2" name="sms_code_2" class="form-control round-0 phone-format sms1-input" maxlength="32" placeholder="“Please , enter SMS code”." Value="<?php echo $user_data['sms_code_2'] ?>" style="margin-bottom: 15px;" required>
                            <a id="verify-submit-2" class="btn btn-primary btn-secondary btn-md" href="JavaScript:void(0)">Set Code</a>
                            <div class="clearfix"></div>
                            <div  style="margin-top: 15px;" id="suc-code-2" class="alert alert-success hide-msg">Verification Successful, Thank you!</div>
                            <div id="error-code-2" class="alert alert-danger hide-msg" style="margin-top: 2px">Verification code is not match, Please enter valid code or resend code</div>
                        </div>
                    </div>
                    <?php  }else{ ?>
                        <div class="form-group  arabic-form-group-holder">
                            <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                                <?=lang('perdet_07');?>(1)
                                <cite class="req">*</cite></label>
                            <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                                <input type="text" name="telephone_1" class="form-control round-0 phone-format" maxlength="32" placeholder="First phone number" Value="<?php echo $user_data['telephone1'] ?>">
                                <span class="telephone-error error" style="display: none"></span>
                            </div>
                            <i style="color: blue; vertical-align: middle;" id="tip_telephone1" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                        </div>
                        <div class="form-group  arabic-form-group-holder">
                            <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                                <?=lang('perdet_07');?>(2)
                            </label>
                            <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                                <input type="text" name="telephone_2" class="form-control round-0 phone-format" maxlength="32" placeholder="<?=lang('second_phone');?>" Value="<?php echo $user_data['telephone2'] ?>">
                            </div>
                            <i style="color: blue; vertical-align: middle;" id="tip_telephone2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                        </div>
                    <?php }?>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_12');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="dob" class="form-control round-0 datepicker"  placeholder="<?=lang('perdet_12');?>" Value="<?php echo $user_data['dob'] ?>">
                            <span class="dob-error error" style="display: none"></span>
                        </div>

                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(1)
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="email" name="email_1" class="form-control round-0" maxlength="48" placeholder="First email" Value="<?php echo $user_data['email1'] ?>">
                            <span class="email-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_email1" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(2)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="email" name="email_2" class="form-control round-0" maxlength="48" placeholder="<?=lang('second_email');?>" Value="<?php echo $user_data['email2'] ?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_email2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(3)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="email" name="email_3" class="form-control round-0" maxlength="48" placeholder="<?=lang('third_email');?>" Value="<?php echo $user_data['email3'] ?>">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_email3" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('skype');?>
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="skype" class="form-control round-0" maxlength="32" placeholder="<?=lang('skype');?>" Value="<?php echo $user_data['skype'] ?>">
                        </div>
                    </div>

                    <?php $this->load->library('IPLoc', null);
                    if(IPLoc::Office()){?>
                    <?php if ($user_data['social_media_type']=="") {
                        
                    }else{ ?>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                         <?php echo $user_data['social_media_type'] ?>
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="fb" class="form-control round-0" maxlength="32" placeholder="fb" Value="<?php echo $user_data['fb'] ?>">
                        </div>
                    </div>
                    <?php }?>
                    <?php }?>


                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_09');?>
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" maxlength="128" name="preferred_time" class="form-control round-0" placeholder="<?=lang('perdet_09');?>" Value="<?php echo $user_data['preferred_time'] ?>">
                        </div>
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_10');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <select name="country" class="form-control round-0 arabic-select-box arabic-selection-form">
                                <?php
                                    foreach( $countries as $key => $country ){
                                        if( $key == $user_data['country'] ){
                                            echo '<option value="' . $key . '" selected="selected">' . $country . '</option>';
                                        }else{
                                            echo '<option value="' . $key . '">' . $country . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <span class="country-error error" style="display: none"></span>
                        </div>

                    </div>
                    <?php if( !$has_request ){ ?>
                    <div class="form-group form-submit-group arabic-form-group-holder">
                        <div class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver"></div>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11 ' : '' ?> arabic-profile-bottom-button arabic-account-ver">
                            <button type="submit" class="btn-submit arabic-btn-reverse"><?=lang('perdet_11');?></button>
                        </div>
                        <div class="col-sm-1 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11 ' : '' ?> arabic-account-ver"></div>
                        <div class="clearfix"></div>
                    </div>
                    <?php } ?>
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
<?php /** Preloader Modal End */ ?>
<script type="text/javascript">
    $(document).ready(function(){

        var width = $(window).width();

        if(width < 768) {
            $('#tip_name').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_01');?></p>", html: true, placement:'left'});
            $('#tip_address').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_02');?></p>", html: true, placement: 'left'});
            $('#tip_city').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_03');?></p>", html: true, placement: 'left'});
            $('#tip_state').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_04');?></p>", html: true, placement: 'left'});
            $('#tip_zip').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_05');?></p>", html: true, placement: 'left'});
            $('#tip_telephone1, #tip_telephone2').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_06');?></p>", html: true, placement: 'left'});
            $('#tip_email1, #tip_email2, #tip_email3').tooltip({title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_07');?></p>", html: true, placement: 'left'});
        }
        else {
            $('#tip_name').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_01');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_address').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_02');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_city').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_03');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_state').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_04');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_zip').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_05');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_telephone1, #tip_telephone2').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_06');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
            $('#tip_email1, #tip_email2, #tip_email3').tooltip({
                title: "<p align='left' style='padding: 5px !important;'><?=lang('tooltip_07');?></p>",
                html: true,
                placement: "<?= FXPP::html_url() == 'sa' ? 'left' : 'right' ?>"
            });
        }
    });
</script>


<script>
    $(document).ready(function(){
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
            yearRange: "-95:+0"
            //  defaultDate: '1920-01-01'

        });

    });
</script>

<!--mobile number verification start-->
<script>

    $(document).ready(function(){

        //phone number one
        $("#verify-mbl-1").click(function(){

            var tel_1 = $('.tel_1').val();
            var x = document.getElementById("sms-code-1");
            var y = document.getElementById("verify-submit-1");

            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "inline-block";
            } else {
                x.style.display = "none";
                y.style.display = "none";
            }
            $.ajax({
                url: "/profile/SendSMS",
                type: "post",
                data: {tel:tel_1} ,
                success: function (data) {
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

        //phone number two

        $("#verify-mbl-2").click(function(){

            var tel_2 = $('.tel_2').val();
            var x = document.getElementById("sms-code-2");
            var y = document.getElementById("verify-submit-2");

            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "inline-block";
            } else {
                x.style.display = "none";
                y.style.display = "none";
            }

            $.ajax({
                url: "/profile/SendSMS2",
                type: "post",
                data: {tel2:tel_2} ,
                success: function (data) {
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });

    });

    // phone number one
    $("#verify-submit-1").click(function(){

        var sms_code_1 = $('#sms-code-1').val();

        $.ajax({
            url: "/profile/number_verification",
            type: "post",
            data: {sms_code:sms_code_1} ,
            success: function (data) {

                data = JSON.parse(data);

                if(data.success===true){

                    $('#sms-code-1').hide();
                    $('#verify-submit-1').hide();
                    $('#suc-code-1').show().delay(5000).fadeOut(300, function(){
                        $('#verify-mbl-1').hide();
                        $('#verify-mbl-1').parents('.tick1').html('<i id="phoneVerifiedIcon" class="fa fa-check fa-2x text-success" style="color:green"></i>');
                    });
                }else {
                    $('#error-code-1').show().delay(5000).fadeOut(300);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });
    $('#sms-code-1').hide();
    $('#verify-submit-1').hide();

    //phone number two
    $("#verify-submit-2").click(function(){

        var sms_code_2 = $('#sms-code-2').val();

        $.ajax({
            url: "/profile/number_verification2",
            type: "post",
            data: {sms_code_2:sms_code_2} ,

            success: function (data) {

                data = JSON.parse(data);

                if(data.success===true)
                {
                    $('#sms-code-2').hide();
                    $('#verify-submit-2').hide();
                    $('#suc-code-2').show().delay(5000).fadeOut(300, function(){
                        $('#verify-mbl-2').hide();
                        $('#verify-mbl-2').parents('.tick2').html('<i id="phoneVerifiedIcon2" class="fa fa-check fa-2x text-success" style="color:green"></i>');
                    });
                }else{
                    $('#error-code-2').show().delay(5000).fadeOut(300);
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $('#sms-code-2').hide();
    $('#verify-submit-2').hide();

</script>

<!--mobile number verification Enc-->
