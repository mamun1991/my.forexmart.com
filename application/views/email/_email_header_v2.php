

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content=" multipart/related; charset=utf-8" type="multipart/alternative" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForexMart Mail</title>

</head>

<body style="padding: 0; margin: 0;">
<div  style="max-width:560px;  margin:0 auto;  background-color:#fff; " >
    <div  style="display: inline-block; width: 100%; background: #06477b;">
        <div  style="display:inline-block;  padding-top: 20px; padding-left: 20px;">
            <a href="http://forexmart.com/" target="_blank"  style=" text-decoration: none; color:#0071d9;" >
                <img src="https://www.forexmart.com/assets/images/forexmart-blue-logo-mail.png"  style="max-width:100%">
            </a>
        </div>
        <div  style="float: right; padding-right: 20px;">


            <?php if($type == 1){
                $link = 'https://my.forexmart.com/partner/signin';
            }else{
                $link = 'https://my.forexmart.com/client/signin';
            } ?>


            <a href="<?= $link; ?>"  style=" text-decoration: none; color:#0071d9;" >
                <div style="display:inline-block; width:130px; font-family: 'Open Sans', sans-serif;  font-size:12px; font-weight: 600; text-align:center; color:#fefefe; margin:0; margin-top: 0px; padding-top: 10px;  float: right;"><p style="font-family:'Open Sans', sans-serif;padding-top:7px;padding-bottom:7px;padding-right:20px;padding-left:20px;background-color:#2baf24;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px;border-style:solid;border-color:#2baf24;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;">SIGN IN</p></div></a>

            <div class="forgot-pwd" style="font-family: 'Open Sans', sans-serif;  font-size:12px; font-weight: 500; color:#b8d6f0; margin:0;  margin-top:50px; padding-bottom: 20px;  line-height:0.7;  text-align: right; padding-right: 12px;">

                <p style="font-family:'Open Sans', sans-serif;" ><a href="https://my.forexmart.com/forgot-password" style="color:#b8d6f0;" >Forgot Password?</a></p>
            </div>
        </div>
    </div>



    <div  style="width:100%;margin-top:0;margin-bottom:20px;margin-right:auto;margin-left:auto;font-family:'Open Sans',sans-serif;font-size:14px;line-height:1.7;text-align:justify;color:#222;padding-bottom:10px; " >
        <?php if($title == 'smart_dollar') {
            $img = 'smart_fm_mailer_img.png';
        }else {
            $img = 'fm_mailer_img_new.png';
        } ?>

        <img alt="FM icon" src="https://www.forexmart.com/assets/images/fm_mailer_icon/<?= $img ?>" class="mailer-img" style="width:auto; display:block;max-width:100%;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" />







<?php /*


 //old

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ForexMart Mail</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">



</head>

<body style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;" >
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<div class="mailer-container" style="max-width:800px;margin-top:10px;margin-bottom:10px;margin-right:auto;margin-left:auto;padding-left:20px;padding-right:20px;background-color:#fff;" >
    <div class="mailer-logo-holder" style="display:inline-block;padding-top:30px;float:left;width:50%;" >
        <img alt="" src="<?=base_url()?>assets/images/fmlogo.png" class="mailer-logo" style="max-width:85%;" >
    </div>
    <div class="login-holder" style="float:right;width:50%;" >


        <div class="login-part1" style="width:100%;" >
            <a href="https://my.forexmart.com" class="login" style="text-decoration:none;color:#0071d9;" >


                <div class="btn-login" style="float:right;width:140px;font-family:'Open Sans',sans-serif;font-size:15px;text-align:center;color:#fff;padding-top:20px;" >
                    <p style="padding-top:11px;padding-bottom:11px;padding-right:27px;padding-left:27px;background-color:#0071d9;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;border-width:1px;border-style:solid;border-color:#0071d9;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;margin-bottom:5px;color:#fff;" >L O G I N</p>
                    <a style="text-decoration: none;" href="https://my.forexmart.com/forgot-password">  Forgotten details?</a>
                </div>

            </a>
        </div>

        <div class="login-part2" style="width:100%;" >

        </div>


    </div>




    <div class="container" style="display:table;width:100%;margin-top:0;margin-bottom:20px;margin-right:auto;margin-left:auto;font-family:'Open Sans',sans-serif;font-size:14px;line-height:1.7;text-align:justify;color:#222;padding-bottom:50px;" >
        <?php if($title == 'smart_dollar') {
            $img = 'smart_fm_mailer_img.png';
        }else {
            $img = 'fm_mailer_img.png';
        } ?>

        <img alt="" src="<?=base_url()?>assets/images/fm_mailer_icon/<?= $img ?>" class="mailer-img" style="display:block;max-width:100%;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;" />




      */

?>




