<script src="<?= $this->template->Js()?>jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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
    img#avatar{
        height: 100px!important;
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

        .tick {
            padding-left: 15px !important;
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
        .tick1, .tick2{
            margin-top: 10px!important;
        }
    }
.hide-msg{
		display: none;
	}
 .dob, .dob:hover {
     cursor: text;
     background: #ffffff !important;
 }
.tick {
	padding-left: 0px;
}
.tick .btn{
	padding: 6px 6px;
	width: 100%;
}

 span.btn-default.btn-input {
     padding-left: 10px;
     padding-right: 10px;
 }
 span.showFileName {
     padding-left: 10px;
 }

 #pre-submit {
     text-decoration:none;
 }



    <?php

    if(FXPP::html_url()=='sa' || FXPP::html_url()=='pk'){ ?>

    .phone-format{
        direction: ltr;
    }

    <?php }  ?>




</style>



<h1>
   <?=lang('change-detail')?>
</h1>


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
                                </span><br>




                                <?php if(IPLoc::Office()){ ?>
                                    <label class="btn"><span class="btn-default btn-input"><?= lang('boo_str_01'); ?></span><span class="showFileName"><?=lang('boo_str_02'); ?></span>
                                    <input id="fileupload" type="file" name="avatar" multiple data-buttonText="<?=lang('boo_str_01')?>" style="display: none;" >
                                 </label>

                               <?php  }else{ ?>
                                    <input id="fileupload" type="file" name="avatar" multiple   >
                               <?php } ?>




                            </span>
                        </div>
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_02');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="name" class="char-only no-paste form-control arabic-input-box round-0 userfullname" maxlength="127" placeholder="<?=lang('perdet_02');?>" Value="<?php echo $user_data['name'] ?>" autocomplete="off" >
                            <span class="name-error error" style="display: none"></span>
                        </div>
                        <p><i style="color: blue; vertical-align: middle;" id="tip_name" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                       
                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_03');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="address" class="no-paste form-control round-0" maxlength="90" placeholder="<?=lang('perdet_03');?>" Value="<?php echo $user_data['address'] ?>" autocomplete="nope"  >
                            <span class="address-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_address" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_04');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="city" class="char-only no-paste form-control round-0" maxlength="30" placeholder="<?=lang('perdet_04');?>" Value="<?php echo $user_data['city'] ?>" autocomplete="nope">
                            <span class="city-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_city" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_05');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="state" class="char-only no-paste form-control round-0" maxlength="30" placeholder="<?=lang('perdet_05');?>" Value="<?php echo $user_data['state'] ?>" autocomplete="nope">
                            <span class="state-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_state" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_06');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="zip_code" class= "form-control round-0" oninput="numericOnly(this)" maxlength="15" placeholder="<?=lang('perdet_06');?>" Value="<?php echo $user_data['zip_code'] ?>" autocomplete="nope">
                            <span class="zip-code-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_zip" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <?php
                    $country_code = array('BY','RU','UA','MD','AM','AZ','GE','KZ','GB','BD');
                    if (in_array($user_data['country'], $country_code)){

                    ?>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_07');?>(1)
                            <cite class="req">*</cite>
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <div class="row">
                                <div class="col-sm-8">
                                    <input id="tel_1" type="text" name="telephone_1" class="form-control round-0 phone-format tel_1" oninput="numericOnly(this)"  min="4" maxlength="30" placeholder="First phone number" Value="<?php echo $user_data['telephone1'] ?>" required autocomplete="nope">
                                </div>
                                <div class="col-sm-4 tick1 tick" style="Padding-left">
                                    <?php
                                    if($user_data['phone_verified_1']==1){ ?>
                                        <i id="phoneVerifiedIcon" class="fa fa-check fa-2x text-success" style="color:green"></i>
                                    <?php }
                                    else{ ?>
                                        <a id="verify-mbl-1" class="btn btn-primary btn-md btn-secondary" href="JavaScript:void(0)"><?=lang('reg_wr_05');?></a>
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
						    <input type="text" id="sms-code-1" name="sms_code_1" class="form-control round-0 phone-format sms1-input" maxlength="30" placeholder="�Please , enter SMS code�." Value="<?php echo $user_data['sms_code_1'] ?>" style="margin-bottom: 15px;"  autocomplete="nope">
                            <a id="verify-submit-1" class="btn btn-primary btn-secondary btn-md" href="JavaScript:void(0)"><?=lang('reg_wr_06');?></a>
						    <div class="clearfix"></div>
						    <div  style="margin-top: 15px;" id="suc-code-1" class="alert alert-success hide-msg"><?=lang('reg_wr_07');?></div>
                            <div id="error-code-1" class="alert alert-danger hide-msg" style="margin-top: 2px"><?=lang('reg_wr_08');?></div>
                        </div>
                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                        <?=lang('perdet_07');?>(2)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <div class="row">
                                <div class="col-sm-8">
                                    <input id="tel_2" type="text" name="telephone_2" oninput="numericOnly(this)" class="form-control round-0 phone-format tel_2" maxlength="30" placeholder="<?=lang('second_phone');?>" Value="<?php echo $user_data['telephone2'] ?>" >
                                </div>
                                <div class="col-sm-4 tick2 tick">
                                    <?php if($user_data['phone_verified_2']==1){ ?>
                                        <i id="phoneVerifiedIcon2" class="fa fa-check fa-2x text-success" style="color:green"></i>
                                    <?php }else{ ?>
                                        <a id="verify-mbl-2" class="btn btn-primary btn-md btn-secondary" href="JavaScript:void(0)"><?=lang('reg_wr_05');?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <p><i style="color: blue; vertical-align: middle;" id="tip_telephone2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label arabic-account-ver arabic-profile-label"></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" id="sms-code-2" name="sms_code_2" class="form-control round-0 phone-format sms1-input" maxlength="32" placeholder="Please , enter SMS code." Value="<?php echo $user_data['sms_code_2'] ?>" style="margin-bottom: 15px;" >
                            <a id="verify-submit-2" class="btn btn-primary btn-secondary btn-md" href="JavaScript:void(0)"><?=lang('reg_wr_06');?></a>
                            <div class="clearfix"></div>
                            <div  style="margin-top: 15px;" id="suc-code-2" class="alert alert-success hide-msg"><?=lang('reg_wr_07');?></div>
                            <div id="error-code-2" class="alert alert-danger hide-msg" style="margin-top: 2px"><?=lang('reg_wr_08');?></div>
                        </div>
                    </div>
                    <?php  }else{ ?>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_07');?>(1)
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="telephone_1" class="form-control round-0 phone-format" maxlength="16" oninput="numericOnly(this)" placeholder="First phone number" Value="<?php echo $user_data['telephone1'] ?>" autocomplete="nope" >
                            <span class="telephone-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_telephone1" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_07');?>(2)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="telephone_2" class="form-control round-0 phone-format" oninput="numericOnly(this)" maxlength="16" placeholder="<?=lang('second_phone');?>" Value="<?php echo $user_data['telephone2'] ?>" autocomplete="nope">
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_telephone2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>
                    <?php }?>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_12');?>
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="text" name="dob" class="form-control round-0 datepicker dob" readonly="readonly" autocomplete="off" placeholder="<?=lang('perdet_12');?>" Value="<?php echo $user_data['dob'] ?>">
                            <span class="dob-error error"></span>
                        </div>

                    </div>

                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(1)
                            <cite class="req">*</cite></label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="hidden" id="user-email" name="user-email" value="<?=$user_data['email']?>">
                            <input type="email" id="email_1" name="email_1" class="form-control round-0" maxlength="47" autocomplete="off" placeholder="First email" Value="<?php echo $user_data['email1'] ?>">
                            <span class="email-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_email1" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>

                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(2)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="email" id="email_2" name="email_2" class="form-control round-0" autocomplete="off" maxlength="47" placeholder="<?=lang('second_email');?>" Value="<?php echo $user_data['email2'] ?>">
                            <span class="email2-error error" style="display: none"></span>
                        </div>
                        <i style="color: blue; vertical-align: middle;" id="tip_email2" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></p>
                    </div>
                    <div class="form-group  arabic-form-group-holder">
                        <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> arabic-account-ver arabic-profile-label">
                            <?=lang('perdet_08');?>(3)
                        </label>
                        <div class="col-sm-7 <?= FXPP::html_url() == 'sa' ? 'col-lg-7 col-md-7 col-xs-11' : '' ?> arabic-account-ver">
                            <input type="email" id="email_3" name="email_3" class="form-control round-0" autocomplete="off" maxlength="47" placeholder="<?=lang('third_email');?>" Value="<?php echo $user_data['email3'] ?>">
                            <span class="email3-error error" style="display: none"></span>
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
                            <a href="<?=FXPP::loc_url('my-account');?>" class="btn-submit arabic-btn-reverse" style="float:left; margin-right:5px;"><?=lang('reg_wr_09');?></a>
                            <!--<button type="button" id="btn-submit-reg" class="btn-submit arabic-btn-reverse" style="float:left;"><?//=lang('perdet_11');?></button>-->
                            <a id="pre-submit" class="btn-submit arabic-btn-reverse" href="javascript:void(0)" style="float:left;"><?=lang('perdet_11');?></a>
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
    var submit = false;
    var dob =  $("input[name=dob]").val();

    $(document).ready(function(){
            var age  = getAge(dob);
            console.log(age);
            if(age < 18){
                submit = false;
                jQuery( ".dob-error").html( "<p>Invalid Birthdate, You must be atleast 18 years old.</p>" );
            }else{
                submit = true;
                jQuery( ".dob-error").html("");
            }

        $('.no-paste').on("paste",function(e) {
            e.preventDefault();
        });

        $("input[name=dob]").on('change', function(e) {
            // e.preventDefault();
            if ($(this).val().length > 0) {
                var age  = getAge($(this).val());
                console.log(age);
                if(age < 18){
                    submit = false;
                    jQuery( ".dob-error").html( "<p>Invalid Birthdate, You must be atleast 18 years old.</p>" );
                }else{
                    submit = true;
                    jQuery( ".dob-error").html("");

                }

            }
        });


//
//
//        $(".char-only").on("keypress", function(event) {
//            console.log(event.keyCode);
//
//           var regex = new RegExp("^[a-zA-Z]+$");
//
//            var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//            if (regex.test(str) || event.keyCode == 32 || event.keyCode == 46 || event.keyCode == 44 || event.keyCode == 45) { // letters a-z and space
//                return true;
//            } else {
//                event.preventDefault();
//                return false;
//            }
//
//        });


        $(".char-only").on("keypress", function(event) {
            console.log(event.keyCode);
            var allLangAlphaAndSpace =/\p{L}/u;
            var key = String.fromCharCode(event.which);
            if (event.keyCode == 32 || event.keyCode == 44 || event.keyCode == 45 ||event.keyCode == 46 || allLangAlphaAndSpace.test(key)) { // Allow all language letters and space
                return true;
            }else{
                event.preventDefault();
                return false;
            }

        });










//
//        $("input[name=telephone_1], input[name=telephone_2], input[name=zip_code]").keypress(function (e) {/**Disables alphabet*/
//        var key = e.key.toLowerCase();
//            if (0 === e.target.selectionStart) {
//                return /^[\+?|\d+]$/.test(key)
//            }
//            else {
//                return /^\d+$/.test(key);
//            }
//
//        });
//
//        $("input[name=telephone_1], input[name=telephone_2], input[name=zip_code]").bind('paste', function(e) {
//
//            setTimeout(function(e) {
//                var val = $(this).val();
//                if (val != '0') {
//                    var regx = new RegExp(/^[0-9]+$/);
//                    if (!regx.test(val)) {
//                        $(this).val("");
//                    }
//                    $(this).val(val);
//                }
//           }, 0);
//        });





//
//        $("input[name=telephone_1], input[name=telephone_2],  input[name=zip_code]").bind("copy paste",function(e) {
//            e.preventDefault();
//        });

        $('form#frmProfile').on('click', '#btn-submit-reg', function(){

            console.log(submit);
            if(submit){
                $('#frmProfile').submit();
            }

        });

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

        <?php if(IPLoc::VPN_IP_Jenalie()){ ?>

        $('body').on('click', '#pre-submit', function(){

            console.log('pre submit');

            var userfullname=$(".userfullname").val();

            var email1 = $('#email_1').val();
            var email2 = $('#email_2').val();
            var email3 = $('#email_3').val();
            var emailError = false;

            if(email2 !== '' && email1 === email2){
                emailError = true;
            }else if(email3 !== '' && email1 === email3){
                emailError = true;
            }else if(email2 !== '' && email3 !== ''){
                if(email2 === email3){
                    emailError = true;
                }
            }

            if(emailError){
                jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">Unable to add the same mail.</div>');
            }
            else{

                // bootbox.confirm({
                //     title: "Confirm Change Password",
                //     message: "Password can be changed once a day",
                //     callback: function(result){
                //         if(result){
                //             $('#pre_error').css('display','none');
                //             $('#frmProfile').submit();
                //         }
                //     }
                // });


                jQuery('.col-alert').html('<div class="alert alert-info" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">Updating profile...</div>');
                jQuery('.error').hide();
                jQuery.ajax({
                    type: 'POST',
                    url: base_url+'profile/updateProfile',
                    dataType: 'json',
                    data: new FormData(this),
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false,
                    beforeSend: function(){
                        $('#loader-holder').show();
                    },
                    success: function(x) {
                        console.log(x);
                        if(x.success){
                            jQuery('.col-alert').html('<div class="alert alert-success" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                            if (parseInt(x.account_status) === 1) {
                                jQuery('.form-submit-group').remove();
                            }

                            $("#userProfilenameofheader").html(userfullname);



                        }else{
                            if(x.validation_error) {
                                if (x.error == null) {
                                    jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">There was no changes on your information.</div>');
                                } else {
                                    jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                                }
                            }else{
                                jQuery('.col-alert').html('');
                                for( var item in x.error ){

                                    if(x.error[item] != ''){
                                        console.log(item);
                                        jQuery('.' + item + '-error').html(x.error[item]);
                                        jQuery('.' + item + '-error').show();
                                    }
                                }
                            }
                        }
                        $('#loader-holder').hide();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        jQuery('.col-alert').html('');
                        console.log(xhr.status);
                        console.log(thrownError);
                        $('#loader-holder').hide();
                    }
                });

            }

        });

        <?php }else { ?>

        jQuery("#frmProfile").on('submit',(function(event) {
            event.preventDefault();

            var userfullname=$(".userfullname").val();



            jQuery('.col-alert').html('<div class="alert alert-info" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">Updating profile...</div>');
            jQuery('.error').hide();
            jQuery.ajax({
                type: 'POST',
                url: base_url+'profile/updateProfile',
                dataType: 'json',
                data: new FormData(this),
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false,
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x) {
                    console.log(x);
                    if(x.success){
                        jQuery('.col-alert').html('<div class="alert alert-success" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                        if (parseInt(x.account_status) === 1) {
                            jQuery('.form-submit-group').remove();
                        }

                        $("#userProfilenameofheader").html(userfullname);




                    }else{
                        if(x.validation_error) {
                            if (x.error == null) {
                                jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">There was no changes on your information.</div>');
                            } else {
                                jQuery('.col-alert').html('<div class="alert alert-danger" style="opacity: 1;font-size: 12px; padding: 10px;margin: 20px 0px;">' + x.error + '</div>');
                            }
                        }else{
                            jQuery('.col-alert').html('');
                            for( var item in x.error ){

                                if(x.error[item] != ''){
                                    console.log(item);
                                    jQuery('.' + item + '-error').html(x.error[item]);
                                    jQuery('.' + item + '-error').show();
                                }
                            }
                        }
                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.col-alert').html('');
                    console.log(xhr.status);
                    console.log(thrownError);
                    $('#loader-holder').hide();
                }
            });
        }));

        <?php } ?>

    });

    $('#sms-code-2').hide();
    $('#verify-submit-2').hide();



    function numericOnly(input){
        let value = input.value;
        let numbers = value.replace(/[^0-9]/g, "");
        input.value = numbers;
    }
    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }





</script>



<!--mobile number verification Enc-->

