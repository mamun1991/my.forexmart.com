<!DOCTYPE html>
<html lang="<?= FXPP::html_url() ?>" dir="<?= FXPP::lang_dir2() ?>">
<?php $class = $this->router->class; ?>
<head>
    <meta charset="utf-8">
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
<!--    <meta http-equiv="Content-Style-Type" content="text/css">-->
<!--    <meta http-equiv="Pragma" content="no-cache">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta http-equiv="Cache-control" content="no-cache">-->
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">
    <meta name="verify-paysera" content="e4253864f1648dfca5e848eab6854897">
    <meta name="google-site-verification" content="hUTbDLfEPfAPqV6xcbcuxv_b8HIjsXKIeBHijGZbZE4" />
   
    <link rel="icon" type="image/gif" href="<?= $this->template->Images()?>icon.ico" />
    <title><?php echo $template['title']; ?></title>
    <!-- Bootstrap Core CSS -->
    <?php switch(FXPP::html_url()){
    case 'sa': case 'pk': ?>
            <link href="<?= $this->template->Css()?>arabic/bootstrap-arabic.min.css" rel="stylesheet">
    <?php break;default:?>
            <link href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
    <?php } ?>
    <link type="text/css" href="<?= $this->template->Css()?>style.min.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>carousel.min.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>custom-external.min.css" rel="stylesheet">
    <link type="text/css" href="<?= $this->template->Css()?>external-style.min.css" rel="stylesheet">
    <?php switch(FXPP::html_url()){ case 'sa': case 'pk': ?>
        <link type="text/css" href="<?= $this->template->Css()?>arabic/external-arabic-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/external-modified-style.css" rel="stylesheet">
        <link type="text/css" href="<?= $this->template->Css()?>arabic/custom-external-arabic-style.css" rel="stylesheet">
    <?php break;default:?>

    <?php } ?>

        <link type="text/css" href="<?= $this->template->Css()?>language-dropdown.css" rel="stylesheet">

    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>
    <!-- Owl Carousel Assets -->
    <script type="text/javascript" src="<?= $this->template->Js()?>jquery.js"></script>
    <!-- Custom CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        $(window).bind('scroll', function() {
            if ($(window).scrollTop() > 95) {
                $('#nav').addClass('nav-fix');
                $('#navtop').addClass('top-fix');
            } else {
                $('#nav').removeClass('nav-fix');
                $('#navtop').removeClass('top-fix');
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.page-link').mouseover(function () {
                $($(this).data('target')).fadeIn("fast");

            })
            $('.page-link').mouseleave(function () {
                $($(this).data('target')).fadeOut("fast");
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#nig').hover(function() {
                $('#nigeria-holder').fadeIn("fast");
            }, function() {
                $('#nigeria-holder').fadeOut("fast");
            });
            $('#mal').hover(function() {
                $('#malaysia-holder').fadeIn("fast");
            }, function() {
                $('#malaysia-holder').fadeOut("fast");
            });
            $('#ind').hover(function() {
                $('#indonesia-holder').fadeIn("fast");
            }, function() {
                $('#indonesia-holder').fadeOut("fast");
            });
            $('#cy').hover(function() {
                $('#cyprus-holder').fadeIn("fast");
            }, function() {
                $('#cyprus-holder').fadeOut("fast");
            });
        });
    </script>
    <script type="text/javascript">
        $(window).bind('scroll', function() {
            if ($(window).scrollTop() > 75) {
                $('#nav').addClass('nav-fix');
                $('#top').addClass('top-fix');
            }
            else {
                $('#nav').removeClass('nav-fix');
                $('#top').removeClass('top-fix');
            }
        });
    </script>
    <style type="text/css">
        .navbar-brand-internal{
            min-height: 50px !important;
            padding: 0px;
            margin-top: 6px;
        }
        .nav-fix
        {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }

        @media screen and (max-width: 560px){
            .nav-fix
            {
                width: 96% !important;
            }
        }

        .top-fix{
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }
        .logo {
            /*width: 480px!important;*/
            margin-top: -19px;
            transition: all ease 0.3s;
        }
        .nd {
            background: #fff!important;
            margin-bottom: 0!important;
            padding: 22px 0 0 0!important;
        }


        .chatBoxTwak{
            margin-top: 21px;


        }




    </style>
    <?=(isset($template['metadata_js']))? $template['metadata_js']: '';?>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <!--<script type="text/javascript">
        // task FXPP-923
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','<?php /*echo ('https://my.forexmart.com/Hosting/analytics');*/?>','ga');

        ga('create', 'UA-69138378-1', 'auto');
        ga('send', 'pageview');

    </script>-->


    <?php if ( ! FXPP::isEUUrl()) { ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KFS2LSK');</script>
    <!-- End Google Tag Manager -->
    <?php } ?>
</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


<?php if ( ! FXPP::isEUUrl()) { ?>
    <!-- Google Tag Manager -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFS2LSK" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

<?php } ?>




<?php if(!IPLoc::isChinaIP()){ ?>

    <?php if(isset($_SESSION['user_id'])){ $ga_user_id =(string) $_SESSION['user_id']; ?>
        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];
            var usrid ='<?=$ga_user_id;?>';
            usrid='88'.concat(usrid).concat('88');
            dataLayer.push({'userID': usrid.toString()});

        </script>

    <?php }else if(isset($_COOKIE['forexmart_gtm_id'])){ ?>

        <script type="text/javascript">
            window.dataLayer = window.dataLayer || [];
            var usrid ='<?=$_COOKIE['forexmart_gtm_id'];?>';
            usrid='88'.concat(usrid).concat('88');
            dataLayer = [{'userID': usrid.toString()}];
        </script>

    <?php } ?>

<?php } ?>

<?php include_once('nav.php') ?>

<!-- SLIDER START -->

<div class="searchscope">
<!-- content -->
<?=(isset($template['body']))?$template['body']: ''; ?>
<!-- end content -->
</div>
<?= $this->load->ext_view('modal', 'searchlocation', '', TRUE); ?>

<?php $method = array("whychooseus", "index","signin"); ?>
<?php if(!in_array($this->router->fetch_method(), $method)){ include_once('feats_holder.php');}?>

<?php
//if (IPLoc::IPOnlyForTq()){
    include_once('bottom_nav2.php');
//}else{
    //include_once('bottom_nav.php');
//}
?>

<!--  start modal -->
<?php include_once('modal_feedback.php') ?>
<!--  end modal -->
<?php
//if (IPLoc::IPOnlyForTq()){
    include_once('footer_2.php') ;
//}else{
   // include_once('footer.php') ;
//}
?>

<a href="#" class="cd-top cd-is-visible cd-fade-out t2" style="margin-bottom: 40px !important;  height: 33px; width: 36px; z-index: 9999999999; ">Top</a>
<!-- mainright -->
<?php include_once('mainright.php') ?>
<!-- mainright -->

<!-- jQuery -->
<!-- Bootstrap Core JavaScript -->
<?php switch(FXPP::html_url()){ case 'sa': case 'pk': ?>
    <script type="text/javascript" src="<?= $this->template->Js()?>arabic/bootstrap-arabic.min.js"></script>
<?php break;default:?>
    <script type="text/javascript" src="<?= $this->template->Js()?>bootstrap.min.js"></script>
<?php } ?>

<!-- Scrolling Nav JavaScript -->
<script type="text/javascript" src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
<script type="text/javascript" src="<?= $this->template->Js()?>owl.carousel.min.js"></script>
<!--scroll button at right bottom corner-->
<script type="text/javascript">
    //    scrolltotop.min.js
        jQuery(document).ready(function($){
            var offset = 200,
                offset_opacity = 1200,
                scroll_top_duration = 600,
                $back_to_top = $('.cd-top');
            $(window).scroll(function(){
                ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
                if( $(this).scrollTop() > offset_opacity ) {
                    $back_to_top.addClass('cd-fade-out');
                }
            });
            $back_to_top.on('click', function(event){
                event.preventDefault();
                $('body,html').animate({
                        scrollTop: 0
                    }, scroll_top_duration
                );
            });
        });
    //scrolltotop.min.js
</script>
<!--scroll button at right bottom corner-->
<script type="text/javascript" async src="<?= $this->template->Js()?>/listfilterAll.min.js"></script>
<!-- <script type="text/javascript" async src="<?= $this->template->Js()?>/listfilterMobile.min.js"></script> -->
<script type="text/javascript" async src="<?= $this->template->Js()?>/listfilterTop.js"></script>
<script type="text/javascript" async src="<?= $this->template->Js()?>/listfilterIcon.js"></script>
<?=(isset($template['metadata']))?$template['metadata']: ''; ?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items : 6,
            lazyLoad : true,
            navigation : false
        });
        $('.play').on('click',function(){
            owl.trigger('autoplay.play.owl',[1000])
        })
        $('.stop').on('click',function(){
            owl.trigger('autoplay.stop.owl')
        })
    });
</script>

<script type="text/javascript">
    $(document).on("click", ".supresscookies", function () {
        var site_url="<?=FXPP::ajax_url('')?>";
        var pblc = [];
        pblc['request'] = null;
        var prvt = [];
        prvt["data"] = {

        };
        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url+"pages/setcookie",
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

        });

        pblc['request'].fail(function( jqXHR, textStatus ) {

        });

        pblc['request'].always(function( jqXHR, textStatus ) {
        });
    });
</script>

<!--advertising-->

<?php if(isset($_COOKIE['forexmart_conceal'])){ ?>

<?php }else{ ?>
    <?php if($unavailable === true){ ?>
        <?= $this->load->ext_view('modal', 'unavailables', '', TRUE); ?>

        <script type="text/javascript">
            $(window).load(function(){
                $('#unavailable').modal('show');
            });
        </script>

    <?php }else{ ?>

        <?php if($this->input->cookie('forexmart_fullname') == ''){ ?>
            <?php if( $this->input->cookie('daycookie') == ''){ ?>
                <?= $this->load->ext_view('modal', 'advertising', '', TRUE); ?>
                <script type="text/javascript">
                    $(window).load(function(){
                       // $('#popup').modal('show'); //FXPP-8255
                    });
                    var date = new Date();
                    var midnight = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 23, 59, 59);
                    var x = Math.floor((Math.random() * 1000) + 1);
                    document.cookie = 'daycookie' + "=" + x + "; " + "expires="+midnight;
                </script>
            <?php } ?>
        <?php }elseif($this->input->cookie('forexmart_fullname') != '' and $this->input->cookie('forexmart_nodepositbonus') =='1' ){ ?>

        <?php }elseif(($this->input->cookie('forexmart_fullname') != '') and ($this->input->cookie('forexmart_nodepositbonus'))=='0' and ($this->input->cookie('forexmart_datedifference')<7) ){?>
            <?php if( $this->input->cookie('daycookie') == ''){ ?>
                <?= $this->load->ext_view('modal', 'advertising', '', TRUE); ?>
                <script type="text/javascript">
                    $(window).load(function(){
                        // $('#popup').modal('show'); //FXPP-8255
                    });
                    var date = new Date();
                    var midnight = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 23, 59, 59);
                    var x = Math.floor((Math.random() * 1000) + 1);
                    document.cookie = 'daycookie' + "=" + x + "; " + "expires="+midnight;
                </script>
            <?php } ?>
        <?php }elseif(($this->input->cookie('forexmart_fullname') != '') and ($this->input->cookie('forexmart_nodepositbonus'))=='0' and ($this->input->cookie('forexmart_datedifference')>7) ){?>

        <?php } ?>

    <?php } ?>

<?php } ?>
<!--advertising-->

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

<link href="<?= $this->template->Css()?>view-ext-main.css" rel="stylesheet">


<script type="text/javascript">
    $(function(){
        $("#mysearchfieldi").attr("placeholder","<?=lang('search');?>");
        $("#searchfield").attr("placeholder","<?=lang('search');?>");
        $("#mysearchfieldt").attr("placeholder","<?=lang('search');?>");
        $("#mysearchfield").attr("placeholder","<?=lang('search');?>");
    });

//scrolling-nav.js
    $(window).scroll(function() {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });
    $(function() {
        $('a.page-scroll').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });
//scrolling-nav.js

    $(document).ready(function(){
        if($("body").size()>0) {
            if (document.createStyleSheet) {
                document.createStyleSheet('https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400');
                document.createStyleSheet('<?= $this->template->Fonts()?>css/font-awesome.min.css');
                document.createStyleSheet('https://fonts.googleapis.com/css?family=Open+Sans');
                document.createStyleSheet('<?= $this->template->Css()?>carousel.min.css');
                document.createStyleSheet('<?= $this->template->Css()?>owl.min.css');
            }
            else {
                $("head").append($("<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' type='text/css'  />"));
                $("head").append($("<link rel='stylesheet' href='<?= $this->template->Fonts()?>css/font-awesome.min.css' type='text/css'  />"));
                $("head").append($("<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans' type='text/css'  />"));
                $("head").append($("<link rel='stylesheet' href='<?= $this->template->Css()?>carousel.min.css' type='text/css'  />"));
                $("head").append($("<link rel='stylesheet' href='<?= $this->template->Css()?>owl.min.css' type='text/css'  />"));
            }
        }
    });
</script>



<div class="clear:both"></div>


<?php if (!FXPP::isEUUrl()) {  // com site?>

    <div class="risk-warning">
        <div class="risk-bold">
            <?php echo '<div style="font-weight: 700 !important;   font-size: 12px ;  padding-right: 4px; padding-top: 2px"   class="warn">'.lang('risc-warn').'</div>'; ?>
        </div>

        <div>
            <span style="font-weight: 700 !important;   font-size: 12px ;   "
                  class="marqueeFooter scroll_com_web"><?= ' '.lang('risc-warn-desc'); ?></span>
            <div style="font-weight: 700 !important;   font-size: 12px  ; " class="marqueeFooter marquee-text scroll_com_mob">
                <div class="marquee"><span><marquee behavior="scroll" direction="left"><?= ' '.lang('risc-warn-desc'); ?></marquee> </span></div>
            </div>
        </div>




    </div>

<?php } ?>

</body>

</html>
