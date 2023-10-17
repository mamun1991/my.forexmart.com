<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForexMart Mail</title>


</head>
<body>


<div class="mailer-container" style="max-width:560px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;background-color:#fff;" >
    <div class="logo-login-holder" style="display:inline-block;width:100%;background-color:#06477b;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;" >
        <div class="logo-holder" style="display:inline-block;padding-top:20px;padding-left:20px;" >
            <img alt="" src="<?php echo FXPP::www_url()?>assets/images/fm-logo_email_v3.png" class="logo" style="max-width:100%;" >
        </div>
        <div class="sign-in-holder" style="float:right;padding-right:20px;" >
            <a href="<?php echo FXPP::my_url()?>" class="sign-in" style="text-decoration:none;color:#0071d9;" >
                <div class="btn-sign-in" style="display:inline-block;width:130px;font-family:'Open Sans', sans-serif;font-size:12px;font-weight:600;text-align:center;color:#fefefe;margin-top:0px;margin-bottom:0;margin-right:0;margin-left:0;padding-top:10px;float:right;" ><p style="font-family:'Open Sans', sans-serif;padding-top:7px;padding-bottom:7px;padding-right:20px;padding-left:20px;background-color:#2baf24;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px;border-style:solid;border-color:#2baf24;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;" >SIGN IN</p></div></a>

            <div  class="forgot-pwd" style="font-family:'Open Sans', sans-serif;font-size:12px;font-weight:500;color:#b8d6f0;margin-top:50px;margin-bottom:0;margin-right:0;margin-left:0;padding-bottom:20px;line-height:0.7;text-align:right;padding-right:12px;" >
                <p style="font-family:'Open Sans', sans-serif;" ><a href="<?php echo FXPP::my_url('forgot-password')?>" style="color:#b8d6f0;" >Forgot Password?</a></p>
            </div>
        </div>
    </div>
<!--        <img alt="" src="--><?php //echo FXPP::www_url()?><!--assets/images/header-img-v3.jpg" class="header-img" style="display:block;max-width:100%;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" />-->
    <?php if($title == 'smart_dollar'){ ?>
        <img alt="" src="<?php echo FXPP::www_url()?>assets/images/header-smart.jpg" class="header-img" style="display:block;max-width:100%;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" />
    <?php } else {?>
        <img alt="" src="<?php echo FXPP::www_url()?>assets/images/header-img-v3.jpg" class="header-img" style="display:block;max-width:100%;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" />
    <?php } ?>


    <div class="container" style="display:block;padding-left:20px;padding-right:20px;margin-bottom:0;margin-top:0;margin-right:auto;margin-left:auto;font-family:'Open Sans',sans-serif;font-size:11px;line-height:1.5;text-align:justify;color:#222;padding-bottom:20px;" >