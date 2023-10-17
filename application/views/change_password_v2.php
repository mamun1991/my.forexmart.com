 <?php
/**
 * Created by PhpStorm.
 * User: Jenalie
 * Date: 12/16/2020
 * Time: 4:07 PM
 */
?>

<h1>
    <?=lang('xnv_MyAcc');?>
</h1>

<style type="text/css">

    #pre-submit {
        text-decoration:none;
    }
    #gen-pass-link {
        text-decoration:none;
        height: 50px;
    }
    .custom-link{
        text-decoration:none;
        color: #fff;
        /*background: #29a643;*/
        background-color: #33333340;
        display: block;
        /*width: 100%;*/
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-image: none;
        border: 1px solid #ccc;
    }

    .icon_container > i {
        position:relative;
        top: calc(50% - 10px); /* 50% - 3/4 of icon height */
    }

    .change-password-alert{
        width: 80%;
        margin: auto;
        margin-bottom: 20px;
    }
    .btn-align{
       margin-right: 48px!important;
    }
    #generate-password-container{
       margin-top: 7px!important;
    }

    input::-webkit-contacts-auto-fill-button,
    input::-webkit-credentials-auto-fill-button {
        visibility: hidden;
        pointer-events: none;
        position: absolute;
        right: 0;
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
    @media screen and (max-width: 1199px){

        .btn-align {
            margin-right: 46px!important;
        }


    }
    @media screen and (max-width: 991px){
        .ssl-img{
            margin: 0px !important;
        }

        .ssl-img img{
            width: 20% !important;
        }
        .btn-align {
            margin-right: 52px!important;
        }
    }
    @media screen and (max-width: 800px){

        .btn-align {
            margin-right: 45px!important;
        }

    }
    @media screen and (max-width: 767px){
        .changePassDiv{
            min-height: 175px;
        }
        #tooltip-container {
            display: none;
        }
        #tip_new_password_1 {
            display: block!important;
        }
        .btn-align {
            margin-right: 87px!important;
        }
    }
    @media screen and (max-width: 600px){

        .btn-align {
            margin-right: 60px!important;
        }
    }

    @media screen and (max-width: 443px){
        #gen-pass-link {
            height: 50px;
        }
        .btn-align {
            margin-right: 43px!important;
        }
    }

    @media screen and (min-width: 320px) and (max-width: 400px){
        #gen-pass-link {
            height: 70px;
        }

    }

    @media screen and (max-width: 280px){
        #gen-pass-link {
            height: 90px;
        }
    }

    /*@media screen and (min-width: 768px) and (max-width: 847px){*/
        /*#gen-pass-link {*/
            /*height: 50px;*/
        /*}*/
    /*}*/

    @media screen and (min-width: 991px) and (max-width: 1880px){
        #gen-pass-link {
            text-align: left;
        }
    }

    @media screen and (max-width: 990px){
        #gen-pass-link {
            text-align: center;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1023px){
        .changePassDiv {
            min-height: 230px;
        }
        #tooltip-container {
            display: block;
        }
        #tip_new_password_1 {
            display: none;
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
        .tooltip:lang(sa),.tooltip:lang(pk){
             left:312px!important;
         }
    }

span.changepassinputeyeicon {
    width: 12%;
    float: right;
    height: 30px;
    line-height: 30px;
    text-align: center;
    cursor: pointer;
}    
    
.changepassinput {
    width: 87% !important;
    float: left;
}    
    
span.changepassinputeyeicon .eye_icon:hover {
    color:red!important;
}    

span.changepassinputeyeicon .fa-eye{float:left; line-height:30px}
span.changepassinputeyeicon .glyphicon-question-sign{float:right; line-height:30px}

@media screen and (min-width: 399px) and (max-width: 767px){

    #tip_new_password_2{
      float: left;
    margin-left: 4px;  
    }
}
    @media screen and (max-width: 399px){
      .changepassinput {
            width: 70% !important;
            float: left;
        } 
        
        span.changepassinputeyeicon {
            width: 27%; 
            margin-left: 4px;  
        }
        
        #tip_new_password_2{
      float: left;
    margin-left: 4px;  
    }
    
    #gen-pass-link{width: 70% !important;}
        .btn-align {
            margin-right: 90px!important;
        }
   }
    @media screen and (max-width: 360px){

        .btn-align {
            margin-right: 75px!important;
        }

    }
    @media screen and (max-width: 320px){

        .btn-align {
            margin-right: 70px!important;
            padding: 7px 34px!important;
        }
        .custom-link{
        padding: 3px 5px;
        }

    }

    @media (max-width: 575.98px) { 
        .tooltip:lang(sa),.tooltip:lang(pk){
             left:140px!important;
         }
     }

.error{ float: left; width:100%; text-align: left}
#gen-pass-link{width: 87%; float: left;}

<?php if(IPLoc::ForJenalieOnly()){ ?>
    #toggle_pwd {
        cursor: pointer;
    }

    .container i {
        margin-left: -30px;
        cursor: pointer;
    }

        a.my-tool-tip:hover, a.my-tool-tip:visited {
            color: black;
        }

        .tooltip {
            z-index: 1000000;
        }
    
<?php } ?>
</style>

<script src="<?= $this->template->Js()?>jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">-->

<?php $this->load->view('account_nav.php');?>



<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active changePassDiv" id="pass" style="">
        <div class="row">

            <div class="form-group">

                <div class="col-sm-9">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
                        <?php echo form_open(FXPP::loc_url('profile/change-password'), array('role' => 'form', 'class' => 'form-horizontal prof-form', 'id' => 'frmChangePassword','autocomplete'=>'off')) ?>
                        <input type="hidden" name="form_key" value="<?php echo $form['form_key'] ?>" />
                        <?php if(isset($success)){ ?>
<!--                            <style>#tip_new_password_2{margin-top:94px;}</style>-->
                            <?php if( $success ){ ?>
                                <div class="alert alert-success change-password-alert cntr">
                                    Thank you, information about changing the password has been sent to your mail.
                                </div>
                            <?php }else{ ?>
                                <div class="alert alert-danger change-password-alert"><?php echo $tank_error ?></div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="alert alert-danger change-password-alert" style="display: none;"></div>
                        <?php } ?>

                        <div class="form-group">
                            <label id="cp_L" class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
                                <?php $password=(!empty(lang('chapas_01'))) ? lang('chapas_01') : 'Current Password'; echo $password;?>
                                <cite class="req">*</cite>
                            </label>
                            <div id="cp_I" class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                                <input type="password" name="old_password" class="form-control round-0 changepassinput" id="old_password" placeholder="<?=lang('chapas_01_0');?>">
                                <span class="changepassinputeyeicon old_pass">
                                    <i class="fa fa-eye eye_icon" onclick="togglePassword('old_password')" ></i>
                                </span>
                                <?php echo form_error('old_password', '<span id="cp_A" class=" error">', '</span>') ?>
                                <span id="pre_error_old_password" class="error" style="display: none;">
                            </div>
                        </div>
                        <div class="form-group" id="new-pass-container">
                            <label id="cp_L" class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
<!--                                New Password-->
                                <?=lang('change_pass_06')?>
                                <cite class="req">*</cite>
                            </label>
                            <div id="cp_I" class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                                <input type="password" name="new_password" class="form-control round-0 changepassinput" id="new_password" placeholder="<?= lang('change_pass_08')?>">
                                
                                    <span class="changepassinputeyeicon new_pass">
                                        <i class="fa fa-eye eye_icon" onclick="togglePassword('new_password')"></i>
                                        <i style="color: blue; vertical-align: middle;" id="tip_new_password_2" class="tip_new_password tooltip-upload-docs glyphicon glyphicon-question-sign"></i>
                                       <input type="hidden" id="pre-errors">
                                    </span>
                                <?php echo form_error('new_password', '<span id="cp_B" class=" error">', '</span>') ?>
                                <?php if($new_pass_error) { ?>
                                    <span class="new-password-error error"><?=$error_message?></span>
                                <?php } ?>
                                <span id="pre_error_new_password" class="error" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="form-group" id="generate-password-container" style="display: none; margin-top:0;">
                            <div id="cp_I" class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> arabic-input-placeholder"></div>
                            <div id="cp_I" class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                                <input type="hidden" id="is-generated" value="false">
                                <a href="javascript:void(0)" id="gen-pass-link" class="custom-link"><i class="fa fa-key" aria-hidden="true"></i> <span>Use system-generated password:</span> <br /><b><span id="generate-password"></span></b></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="cp_L" class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?> control-label input1 arabic-account-ver arabic-profile-label">
<!--                                Confirm Password-->
                                <?=lang('change_pass_07')?>
                                <cite class="req">*</cite></label>
                            <div id="cp_I" class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8' : '' ?> arabic-input-placeholder">
                                <input type="password" name="confirm_password" class="form-control round-0 changepassinput" id="confirm_password" placeholder="<?= lang('change_pass_09')?>">
                                <span class="changepassinputeyeicon conf_pass">
                                    <i class="fa fa-eye eye_icon" onclick="togglePassword('confirm_password')"></i>
                                </span>
                                <?php echo form_error('confirm_password', '<span id="cp_C" class=" error">', '</span>') ?>
                                <span id="pre_error_confirm_password" class="error" style="display: none;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 <?= FXPP::html_url() == 'sa' ? 'col-lg-11 col-md-11 col-xs-12' : '' ?>">
                                <?php $submitLabel=(!empty(lang('chapas_04'))) ? lang('chapas_04') : 'Send Request';?>
<!--                                <a id="pre-submit" class="btn-submit arabic-btn-reverse" href="javascript:void(0)">--><?//=$submitLabel;?><!--</a>-->
                                <button type="submit" class="btn-submit arabic-btn-reverse btn-align">
                                    <?=lang('chapas_04');?>
                                </button>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

<!--                <div class="col-sm-3" id="tooltip-container" style="float: left!important; margin-left: -60px!important; margin-top: 60px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" id="pre-errors">
                                <i style="color: blue; vertical-align: middle; margin-top: -6px;" id="tip_new_password_2" class="tip_new_password tooltip-upload-docs glyphicon glyphicon-question-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>-->

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="expired_session_modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p>Session Expired. Please login again.</p>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <a href="https://my.forexmart.com/signout" class="btn btn-default">OK</a>
            </div>
        </div>
    </div>
</div>

 

<script>
    var language = '<?=FXPP::html_url()?>';
    $(document).ready(function(){
        str = language.replace(/\s/g, '');
        if (str === 'bg'){
            $("#cp_A").removeClass("col-sm-4");
            $("#cp_A").addClass("col-sm-4");
            $("#cp_B").removeClass("col-sm-4");
            $("#cp_B").addClass("col-sm-4");
            $("#cp_C").removeClass("col-sm-4");
            $("#cp_C").addClass("col-sm-4");
        }

         
         

        $('.tip_new_password').tooltip({title: "<?=lang('edit_profile_erro_8')?>"});

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

        var getWidth = 0;
        $(window).resize(function() {
            getWidth = $(window).width();
        });

        $('#frmChangePassword').validate({
            ignore: [],
            rules:{
                old_password: {
                    required: true,
                    maxlength: 15
                },
                new_password: {
                    required: true,
                    minlength: 7,
                    maxlength: 15,
                    noSpace: true
                },
                confirm_password: {
                    required: true,
                    maxlength: 15,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    required: 'Current Password is required.',
                    maxlength: 'Current password should be 7 to 15 symbols.'
                },
                new_password: {
                    required: 'New Password is required.',
                    minlength: 'New Password should be not less than 7 symbols.',
                    maxlength: 'New Password should be 7 to 15 symbols.'
                },
                confirm_password: {
                    required: 'Confirm Password is required.',
                    maxlength: 'Confirm Password should be 7 to 15 symbols.',
                    equalTo: 'New Password and Confirm Password must match.'
                }
            },
            errorPlacement: function(error, element){

                $('#cp_A').css('display','none');
                $('#cp_B').css('display','none');
                $('#cp_C').css('display','none');

                var field = element.attr("name");

                $('#pre_error_'+field).css('display','block').html(error.text());
 

                // if($('#pre-errors').val() !== ''){
                //     var search = $('#pre-errors').val().search(field);
                //     if(search === -1){
                //         var errors = $('#pre-errors').val() + ',' + field;
                //         $("#pre-errors").val(errors);
                //     }
                // }else{
                //     $('#pre-errors').val(field);
                // }

                return true;
            },
            submitHandler: function(form){

                var new_password = $('#new_password').val();
                var error = false;

                if(new_password.match(/^[A-Za-z]+$/) || $.isNumeric(new_password)){
                    $('#pre_error_new_password').css('display','block').html("New Password doesn\'t correspond to the criteria.");
                    error = true;
                }

                if(!error){
                    bootbox.confirm({
                        title: "<?=lang('change_pass_03')?>",
                        message: "<?=lang('change_pass_01')?> "+'<a href="#" data-toggle="tooltip" title="<?=lang("change_pass_02")?>"><i style="margin-bottom: 5px; color: blue; vertical-align: middle;" class="tooltip-upload-docs glyphicon glyphicon-question-sign"></i></a>',
                        buttons: {
                            confirm: {
                                label: "<?=lang('change_pass_05')?> ",
                                className: 'btn-success'
                            },
                            cancel: {
                                label: "<?=lang('change_pass_04')?>",
                                className: 'btn-danger'
                            }
                        },
                        callback: function(result){
                            if(result){
                                $('#pre_error').css('display','none');
                                $('#cp_A').css('display','none');
                                form.submit();
                            }
                        }
                    });
                }

            }
        });

        jQuery.validator.addMethod("noSpace", function(value, element) {
            return value.indexOf(" ") < 0;
        }, "Space is not allowed.");

        $("#new_password").on("keyup", function(e) {

            $('#pre-submit').unbind('click');

            if($('#new_password').val().length < 7){
                $('#pre_error_new_password').css('display','block').html('New Password should be not less than 7 symbols.');
                $('#pre-submit').unbind('click');
            }
            else if($('#new_password').val().length > 20){
                $('#pre_error_new_password').css('display','block').html('New Password should be 7 to 15 symbols.');
                $('#pre-submit').unbind('click');
            }
            else if(e.keyCode === 32){
                $('#pre_error_new_password').css('display','block').html('Space is not allowed.');
                $('#pre-submit').unbind('click');
            }
            else{
                $('#pre_error_new_password').css('display','none');
                $('#pre-submit').bind('click');
            }

        });

        $("#confirm_password").on("keyup", function() {
            if($(this).val() !== $('#new_password').val()){
                $('#pre_error_confirm_password').css('display','block').html('New Password and Confirm Password must match.');
                $('#pre-submit').unbind('click');
            }else{
                $('#pre_error_confirm_password').css('display','none');
                $('#pre-submit').bind('click');
            }
        });

        $("#old_password").mousedown(function(){
            $('#cp_A').css('display','none');
            $('#pre_error_old_password').css('display','none');

           

        });

        $("#confirm_password").mousedown(function(){
            $('#cp_C').css('display','none');
        });

        $("#new_password").mousedown(function(){
            GeneratePassword();
        });

        $('body').on('keydown', '#old_password', function(e) { //Tab
            if (e.which === 9) {
                // e.preventDefault();
                GeneratePassword();
            }
        });

        $('body').on('click', '#gen-pass-link', function(){
            var generated_password = $('#generate-password').text();
            $("#new_password").val(generated_password);
            $("#confirm_password").val(generated_password);
            $('#pre_error_new_password').css('display','none');
            $('#pre_error_confirm_password').css('display','none');
            if(getWidth <= 767){
                $('#tip_new_password_1').css('margin-top','-24px');
            }
        });


        <?php if( !empty($msg) ){ ?>
            setTimeout(function () {
                $('#expired_session_modal').modal('show');
                $('#expired_session_modal').modal({backdrop: 'static', keyboard: false});
            }, 2000);
        <?php }?>
 

    });

    function GeneratePassword(){

        var base_url = '<?php echo FXPP::ajax_url() ?>';

        var is_generated = $('#is-generated').val();

        if(is_generated === 'false'){

            jQuery.ajax({
                type: 'POST',
                url: base_url + 'profile/generatePassword',
                dataType: 'json',
                success: function(x){
                    console.log(x.password);
                    $('#generate-password').html(x.password);
                    $('#is-generated').val('true');
                    $('#cp_B').css('display','none');
                    $('#generate-password-container').css('display','block');
                    $('#new-pass-container').css('margin-bottom','0px');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });

        }

    }

    function togglePassword(inputboxid)
    {
        var inputbox_type = $("#"+inputboxid).attr("type");
        if(inputbox_type==="password")
        {
            $("#"+inputboxid).attr("type","text");
        }else{
            $("#"+inputboxid).attr("type","password");
        }

    }




//    $(document).ready(function(){
//
//        var width = $(window).width();
//        if (width < 768) {
//            console.log(width);
//
//                $(".old_pass").on("click", function(){
//
//                    var inputbox_type = $("#old_password").attr("type");
//                    if(inputbox_type==="password")
//                    {
//                        $("#old_password").attr("type","text");
//                    }else{
//                        $("#old_password").attr("type","password");
//                    }
//
//                });
//
//                $(".new_pass").on("click", function(){
//
//                    var inputbox_type = $("#new_password").attr("type");
//                    if(inputbox_type==="password")
//                    {
//                        $("#new_password").attr("type","text");
//                    }else{
//                        $("#new_password").attr("type","password");
//                    }
//
//                });
//
//                $(".conf_pass").on("click", function(){
//
//                    var inputbox_type = $("#confirm_password").attr("type");
//                    if(inputbox_type==="password")
//                    {
//                        $("#confirm_password").attr("type","text");
//                    }else{
//                        $("#confirm_password").attr("type","password");
//                    }
//
//                });
//
//
//        }else {
//
//            $(".old_pass").hover(function(){
//
//                var inputbox_type = $("#old_password").attr("type");
//                if(inputbox_type==="password")
//                {
//                    $("#old_password").attr("type","text");
//                }else{
//                    $("#old_password").attr("type","password");
//                }
//            });
//            $(".new_pass").hover(function(){
//
//                var inputbox_type = $("#new_password").attr("type");
//                if(inputbox_type==="password")
//                {
//                    $("#new_password").attr("type","text");
//                }else{
//                    $("#new_password").attr("type","password");
//                }
//            });
//            $(".conf_pass").hover(function(){
//
//                var inputbox_type = $("#confirm_password").attr("type");
//                if(inputbox_type==="password")
//                {
//                    $("#confirm_password").attr("type","text");
//                }else{
//                    $("#confirm_password").attr("type","password");
//                }
//            });
//
//        }
//
//    });

</script>

 