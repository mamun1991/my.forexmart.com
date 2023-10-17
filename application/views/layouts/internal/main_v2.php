<?php $class = $this->router->class; ?>
<?php $method = $this->router->method; ?>
<?php $this->lang->load('register');
header("Content-Type: text/html");
?>
<!DOCTYPE html>
<html lang="<?= FXPP::html_url() ?>" dir="<?= FXPP::lang_dir(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
<!--    <meta http-equiv="Content-Type" content="text/html";  charset="windows-1252">-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="author" content="Ildar Sharipov">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="verify-paysera" content="e4253864f1648dfca5e848eab6854897">
    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">

    <link rel="icon" type="image/gif" href="<?= $this->template->Images()?>icon.ico" />

    <title><?php echo $template['title']; ?></title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->

    <?php switch(FXPP::html_url()){
    case 'sa': case 'pk': ?>
            <link type="text/css" href="<?= $this->template->Css()?>arabic/bootstrap-arabic.min.css" rel="stylesheet">
    <?php break;default:?>
            <link type="text/css" href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
    <?php } ?>

    <link type="text/css"  href="<?= $this->template->Css()?>internal-style.css" rel="stylesheet">
    <link type="text/css"  href="<?= $this->template->Css()?>custom.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>custom-internal.min.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>carousel.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>mainstyle.css" rel="stylesheet">
    <link type="text/css"  href="<?= $this->template->Css()?>inscrolling-nav.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>chat-widget.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>internal-side-nav.css" rel="stylesheet">
    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>
    <!-- jQuery -->
    <script type="application/javascript" src="<?= $this->template->Js()?>jquery.js"></script>
    <!-- Owl Carousel Assets -->
    <link type="text/css" href="<?= $this->template->Css()?>owl.carousel.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>owl.theme.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>owl.transitions.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>chat-widget.css" rel="stylesheet">


    <?php switch(FXPP::html_url()){ case 'sa': case 'pk': ?>
        <link type="text/css" href="<?= $this->template->Css()?>arabic-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/custom-arabic-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/internal-modified-style.css" rel="stylesheet">
    <?php break;default:?>

    <?php } ?>
    <!-- Prettify -->

    <!-- Preloader -->
    <link type="text/css" rel="stylesheet" href="<?= $this->template->Css()?>loaders.css"/>
    <script type="text/javascript">
        $(window).bind('scroll', function() {
            if ($(window).scrollTop() > 95) {
                $('#nav').addClass('nav-fix');
            }
            else {
                $('#nav').removeClass('nav-fix');
            }
        });
    </script>
    <style type="text/css">
        .nav-fix
        {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }
        @media screen and (max-width: 1199px){
            .main-border {
                border-bottom: 1px solid #ccc;
            }
        }
        @media screen and (min-width: 992px){
            .maincont{
                min-height: 740px;
                border-left:1px solid #ccc;
            }
        }
    </style>
    <?=(isset($template['metadata_js']))? $template['metadata_js']: '';?>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <?php if(!IPLoc::isChinaIP()){ ?>
    <?php if(IPLoc::Office()){ ?>
        <script>
//                <!-- Google Tag Manager -->
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-KFS2LSK');
                <!-- End Google Tag Manager -->
        </script>
        <?php } ?>
    <?php } ?>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<?php if(!IPLoc::isChinaIP()){ ?>

    <?php if(isset($_SESSION['user_id'])){ $ga_user_id =(string) $_SESSION['user_id']; ?>

    <script type="text/javascript">
        var usrid ='<?=$ga_user_id;?>';
        usrid='88'.concat(usrid).concat('88');
        dataLayer = [{'userID': usrid.toString()}];
    </script>

        <?php }else if(isset($_COOKIE['forexmart_gtm_id'])){ ?>

    <script type="text/javascript">
        var usrid ='<?=$_COOKIE['forexmart_gtm_id'];?>';
        usrid='88'.concat(usrid).concat('88');
        dataLayer = [{'userID': usrid.toString()}];
    </script>

        <?php } ?>

     <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFS2LSK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php } ?>

<div >
<?php include_once('nav.php'); ?>

<?php
$getLoginType = $this->session->userdata('login_type');
$incomplete_reg = FXPP::incomplete_reg_pop($this->session->userdata('user_id'));
    if(!$getLoginType){
        if($class != 'accounts' || $method != 'register'){
            if(!$incomplete_reg){ ?>
                <div class="bs-example">
                    <div class="alert alert-info fade in info-container-message">
                        <div class="container info-container-child">
                            <p><span class="info-icon"></span> <strong><?=lang('int_reg_37');?> ForexMart.</strong> <?=lang('int_reg_38');?>

                                   <?=lang('int_reg_57');?><a href="<?php echo  FXPP::loc_url('my-account/register');?>" ><?=lang('int_reg_58');?></a>.
                            </p>
                        </div>
                    </div>
                </div>
<?php }}} ?>

<div class="main-content">
    <div class="container container1">

<!--        internal content-->
        <div class="row main-border">
<!--            internal sidebar-->
            <?php include_once('sidebar_v2.php') ?>
<!--            end internal sidebar-->
            <div class="maincont col-lg-9 col-md-9 col-sm-9 arabic-int-main-cont arabic-main-container arabic-secondary-container" style="">
                <div class="section arabic-section arabic-section-title" style="min-height: 500px;">

<!--                    content navigation-->
<!--                    --><?php //include_once('content_nav.php') ?>
<!--                    end content navigation-->

<!--                    dynamic content-->
                    <?=(isset($template['body']))?$template['body']: ''; ?>
<!--                    end dynamic content-->

                </div>
            </div>
            <div class="clearfix">
            </div>
        </div>
<!--        end internal content-->

<!--        bottom nav-->
        <?php include_once('bottom_nav.php') ?>
<!--        end bottom nav-->

    </div>
</div>
</div>
<!--  start modal -->
<?php include_once('modal_feedback.php') ?>
<!--  end modal -->

<!-- footer -->
<?php include_once('footer.php') ?>
<!-- end footer -->
<a href="#" class="cd-top cd-is-visible cd-fade-out ">Top</a>
<!-- mainright -->
<?php include_once('mainright.php') ?>
<!-- mainright -->

<!-- Bootstrap Core JavaScript -->
<?php switch(FXPP::html_url()){
case 'sa':
case 'pk': ?>
        <script type="application/javascript" src="<?= $this->template->Js()?>arabic/bootstrap-arabic.js"></script>
<?php break;default:?>
    <script type="application/javascript" src="<?= $this->template->Js()?>bootstrap.min.js"></script>
<?php } ?>

<!-- Scrolling Nav JavaScript -->
<script type="text/javascript" src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
<script type="text/javascript" src="<?= $this->template->Js()?>scrolling-nav.js"></script>
<script type="text/javascript" src="<?= $this->template->Js()?>owl.carousel.js"></script>

<!--scroll button at right bottom corner-->
<script type="text/javascript" src="<?= $this->template->Js()?>scrolltotop.min.js"></script>
<!--scroll button at right bottom corner-->
<!-- Demo -->

<style type="text/css">
    @media screen and (max-width: 991px) {
        .maincont{
            width: 100%;
        }
    }
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        /*width: 100%;*/
        /*height: auto;*/
    }
</style>


<script type="text/javascript">
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            items : 4,
            lazyLoad : true,
            navigation : true
        });

    });
</script>
<?=(isset($template['metadata']))?$template['metadata']: ''; ?>

    <script type="application/javascript">

// deposit page visitor get
$(document).ready(function(){
   setTimeout(function(){
    var str ="<?=current_url()?>";
    var nview = str.search("deposit");
    if(nview!=-1){
        var res = str.split("deposit/");         
        if (typeof res[1]== 'undefined'){
          depositPageVisitorDataSend(str);
        }
    }
    },(5*60*1000));
 });
function depositPageVisitorDataSend(url) {
     var base_url='<?=  base_url()?>';
   $.post(base_url+'deposit/depositPageVisitorInformatin',{current_url:url},function(view){
    //   alert(view);
       console.log(view);
   });
}








$(function(){
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    $("#SearchInInternal").attr("placeholder","<?=lang('search');?>");
    <?php if($this->session->userdata('readOnly')){?>
	$("input,button").attr("disabled",true);
    $("#live-client-status").text("Read Only");

    $("#date_start").attr("disabled",false);
    $("#date_end").attr("disabled",false);
    <?php }?>
	
    $("#navbar-menu-1").attr("disabled",false);
    $("#navbar-menu-2").attr("disabled",false);
	$("#tab3 :input").attr("disabled", false);
	$("#tab3 :button").attr("disabled", false);
});
</script>
    
<?php if ($this->uri->segment(1) == 'zh') { ?>
    <!--Start of Tawk.to Script (Chinese)-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5945fcbbe9c6d324a4735f4e/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
<?php } else { ?>
<!--Start of Tawk.to Script (All)-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5917fdcd64f23d19a89b20c2/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<?php } ?>
