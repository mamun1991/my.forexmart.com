<?php
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
//  header("HTTP/1.0 500 Internal server error");
$site_my = "https://my.forexmart.com/";
$site_www = "https://www.forexmart.com/";
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Forexmart - Error (404)</title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
<link href="<?= $site_www?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Bootstrap Core CSS -->
<link href="<?= $site_www?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= $site_www?>assets/css/external-style.css" rel="stylesheet">
<link href="<?= $site_www?>assets/css/carousel.css" rel="stylesheet">
<link href="<?= $site_www?>assets/css/custom.css" rel="stylesheet">
<script src="<?= $site_www?>assets/js/jquery-1.11.3.min.js"></script>
<!-- Custom CSS -->
<!--    <link href="--><?//= $site_www?><!--assets/css/exscrolling-nav.css" rel="stylesheet">-->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.page-link').mouseover(function () {
            $($(this).data('target')).fadeIn("fast");

        });
        $('.page-link').mouseleave(function () {
            $($(this).data('target')).fadeOut("fast");
        });
    });
</script>
<script type="text/javascript">
    $(window).bind('scroll', function() {
        if ($(window).scrollTop() > 75) {
            $('#nav').addClass('nav-fix');
        }
        else {
            $('#nav').removeClass('nav-fix');
        }
    });
</script>
<style>
.error-img{
    float: left!important;
}
.nav-fix
{
    position: fixed;
    top: 0;
    z-index: 9999;
    width: 100%;
    transition: all ease 0.3s;
}
.tradomart {
    margin-bottom: 3px;
    padding: 0px !important;
}



.enav,
.enav a,
.enav ul,
.enav li,
.enav div,
.enav form,
.enav input {
    margin: 0;
    padding: 0;
    border: none;
    outline: none;
    font-size: 16px;
}

.enav a { text-decoration: none; }

.enav li { list-style: none; }


.enav {
    display: inline-block;
    position: relative;
    cursor: default;
    z-index: 500;
}

.enav > li {
    display: block;
    float: left;
}


.enav > li > a {
    font-family: Georgia;
    font-size: 17px;
    font-weight: 400;
    position: relative;
    display: block;
    z-index: 510;
    height: 50px;
    padding: 0 20px;
    line-height: 54px;


    color: #fcfcfc;

    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -o-transition: all .3s ease;
    -ms-transition: all .3s ease;
    transition: all .3s ease;
}


.enav > li:hover > a {
    background: #319ae3;
}

.enav > li:first-child > a {
    border-radius: 3px 0 0 3px;
    border-left: none;
}


.enav > li > div {
    background: #ffffff;
    border-radius: 0 0 3px 3px;
    max-height: 0;
    -webkit-transition: max-height 1s;
    -moz-transition: max-height1s;
    transition: max-height 1s;
    -o-transition: max-height 1s;
    -ms-transition: max-height 1s;

    position: fixed;

    width: 100%;
    left: 0;
    opacity: 0;
    visibility: hidden;
    overflow: hidden;
}

.enav > li:hover > div {
    max-height: 500px;
    opacity: 1;
    visibility: visible;
    height  :auto;
}
.inner-menu-panel{
    border-bottom: 5px solid #D7DCE0 !important;
    left: 0px !important;
}


.adjustment{
    top: 10px;
}

.border_bottom{
    border-bottom:2px solid #d7dce0;
}

.sub-menu > li:first-child a {
    border: 0px none;
}
.sub-menu > li:first-child a {
    border: 0px none;
}

.submenumain  ul {
    padding-top: 20px!important;
}
.sub-menu > li > a{
    border-left: 1px solid #9CAEBE;
    vertical-align: middle;
    padding: 0px 20px;
}

.submenutopic{
    font-weight: bold;
    color: #23527C;
}

.subtopic{
    color: #00A4DB;
    padding: 4px 20px !important;
}

.submenumain{
    float: left;
    padding-right: 40px !important;
    padding-top: 25px !important;
    padding-bottom: 25px !important;
}
.submenumain > ul >li {
    padding: 6px 0px;
}
.submenumain{
    border-left: 1px solid #9CAEBE;
}
.nav-fix > div.inner-menu-panel{
    top: 60px;!important;
}

.sub-menu {
    margin: 0px auto !important;
    overflow: hidden;
}

@media (min-width: 800px) {
    .sub-menu {
        width: 700px;
    }
}
@media (min-width: 970px) {
    .sub-menu {
        width: 1150px;
    }
}
@media (min-width: 1200px) {
    .container {
        width: 1170px;
    }
}
.btn-livedemo {
    margin-top: 30px;
    text-align: center;
    width: 100%;
}
.btn-livedemo {
    text-align: center;
}
.btn-real {
    background: transparent none repeat scroll 0% 0%;
    border: 1px solid #29A643;
    color: #29A643;
    padding: 7px 0px;
    width: 250px;
    transition: all 0.3s ease 0s;
}
.form-inline .form-group {
    display: inline-block;
    margin-bottom: 0px;
    vertical-align: middle;
}
.btn-demo {
    text-decoration: none !important;
    background: transparent none repeat scroll 0% 0%;
    border: 1px solid #2988CA;
    color: #2988CA;
    padding: 7px 0px;
    width: 250px;
    transition: all 0.3s ease 0s;
}
.error-bot {
    margin-bottom: 70px;
}
.nolinkline{
    outline: none;
}

/*-----Designer CSS CODE START
ADDED STYLES (07/12/2017) -----*/

.restricted-wrapper {
    position: relative;
    padding-top: 15vh;
    height: calc(100% - 33vh);
    overflow: hidden;
    text-align: center;
    min-height:360px;
    padding-bottom: 11vh;
}
.img-handler{
    transition: all ease 0.3s;
}
.fl-rg{
    display: inline-block;
    vertical-align: middle;
}
.fl-lf{
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    padding-top:4vh;
}
.fl-lf b{
    font-family: 'Open Sans';
    font-weight: 500;
    color:#555;
    font-style: italic;
}
.fl-lf h2{
    font-family: 'Open Sans';
    font-size: 32px;
    font-weight: lighter;
    color:#777;
}



@media screen and (max-width: 1167px) {
    .fl-lf h2{
        font-size: 30px;
    }
}

@media screen and (max-width: 991px) {
    .fl-lf{
        padding-top:1vh;
        margin-left: -2vh;
    }
    .fl-lf h2{
        font-size: 32px;
    }
}
@media screen and (max-width: 767px) {
    .restricted-wrapper {
        padding-top: 10vh;
    }
    .fl-rg{
        text-align: center;
        vertical-align: middle;
    }
    .fl-rg img{
        width:75%;
    }
    .fl-lf{
        text-align: center;
        vertical-align: middle;
        padding-top:0vh;
        margin-left: 0vh;
    }

    .fl-lf h2{
        font-size: 24px;
    }

/*-----Designer CSS CODE END -----*/

</style>
</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<!-- Navigation -->
<nav class="navbar navbar-default nd" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <img src="<?= $site_www?>assets/images/fxlogonew.svg" class="img-reponsive logo" alt="" usemap="#fxxpplaspalmas">
            <map name="fxxpplaspalmas">
                <area shape="rect" coords="0,0,217,69" href="<?= $site_www?>" alt="ForexMart" class="nolinkline">
                <area shape="rect" coords="217,0,434,69" href="<?= $site_www?>las-palmas" alt="LasPalmas" class="nolinkline">
            </map>

            <div class="clearfix"></div>
        </div>
        <div class="reg-holder"> </div>
    </div>
</nav>




<div id="nav" class="nav-holder">
    <div class="container">
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav nn fx-navbar" id="">

            </ul>

            <ul class="nav navbar-nav navbar-right search-ryt">
                <li>
                    <form class="navbar-form navbar-left search-form" role="search">
                        <div class="form-group">
                            <div class="input-group" id="headerAll" ></div>
                        </div>
                    </form>
                </li>
            </ul>

            <div class="btn-top-holder">

            </div>

        </div>
    </div>
</div>



<div class="not-found-holder">
    <div class="main-content restricted-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 fl-rg">
                    <img src="<?= $site_www?>assets/images/seru.png" class="img-reponsive img-handler">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 fl-lf">
                    <h2>  "<b>Sorry</b>, the service is currently not available, <br>please try again later".</h2>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- end content -->
<style>
    .error-form-holder {
        max-width:1000px;
        position:relative;
        margin:0 auto;
    }

    .secondary-error-image , .error-other-text {
        display:none;
    }

    .error-other-text span {
        font-weight:bold;
        font-size:20px;
        color:#3e3e3e;
        text-shadow:0 1px #fff;
        line-height:30px;
    }

    .error-image-holder p , .error-other-text {
        text-align:center;
        font-size:15px;
    }

    .absolute-text , .error-other-text {
        margin-top:-120px;
    }
    .bot-nav li a {
        padding: 15px 6px !important;
    }
    .trademart {
        margin-bottom: 3px;
        padding: 0px !important;
    }
    .ver-line {
        padding: 15px 8px !important;
    }
</style>
<div class="bot-nav-holder">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 footer-menu-holder">
                <div class="footer-toggle-holder">
                    <button type="button" class="footer-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="footer-hide-menu">
                    <ul>
                        <li><a href="<?= $site_www?>legal-documentation">Legal documentation</a></li>
                        <li><a href="<?= $site_www?>risk-disclosure">Risk disclosure</a></li>
                        <li><a href="<?= $site_www?>privacy-policy">Privacy Policy</a></li>
                        <li><a href="<?= $site_www?>terms-and-conditions">Terms &#38; Conditions</a></li>


                    </ul>
                </div>
                <ul class="bot-nav">
                    <li><a href="<?= $site_www?>legal-documentation">Legal documentation</a></li>
                    <li class="ver-line">|</li>
                    <li><a href="<?= $site_www?>risk-disclosure">Risk disclosure</a></li>
                    <li class="ver-line">|</li>
                    <li><a href="<?= $site_www?>privacy-policy">Privacy Policy</a></li>
                    <li class="ver-line">|</li>
                    <li><a href="<?= $site_www?>Terms-and-conditions">Terms &#38; Conditions</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 copy">
            </div>
            <div class="col-sm-3">
                <ul class="connect">
                    <li>
                        <a href="<?= $site_www?>contact-us"><i class="fa fa-phone phone"></i> Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- footer -->
<style>
    .tradomart {
        margin-bottom: 3px;
        padding: 0px !important;
    }
</style>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <p class="footer-text">
                    <cite>Risk Warning:</cite> Foreign exchange is highly speculative and complex in nature, and may not be suitable for all investors. Forex trading may result to substantial gain or loss. Therefore, it is not advisable to invest money you cannot afford to lose. Before using the services offered by <span class="company">ForexMart</span>, please acknowledge and understand the risks relative to forex trading. Seek financial advice, if necessary.
                </p>
                <p class="footer-text1">
                    <span class="company">ForexMart</span> is a trading name of <img class="tradomart" width="101px" height="10px"  src="<?= $site_www?>assets/images/tradomart/tradomart-ltd-small-black.png" />, a Cyprus Investment Firm regulated by the Cyprus Securities Exchange (CySEC) with license number 266/15.
                </p>
                <p class="footer-text1">
                    <span class="company">ForexMart</span> was named by ShowFx World as the Best Broker in Europe 2015 and Most Perspective Broker in Asia 2015.
                </p>
            </div>
            <div class="col-sm-3 sec">
                <a target="_blank" href="http://www.cysec.gov.cy/en-GB/entities/investment-firms/cypriot/71294/"><img src="<?= $site_www?>assets/images/cysec.png" class="img-responsive cysec"></a>
                <a target="_blank" href="http://ec.europa.eu/finance/securities/isd/mifid/index_en.htm"><img src="<?= $site_www?>assets/images/mifid.png" class="img-responsive mifid"></a>
            </div>
        </div>
    </div>
</footer>

<div class="copyright-holder">
    <div class="container">
        <div class="row">
            <div class="col-md-9 copy">
                <p>&copy; 2015 <img class="tradomart" width="101" height="11" alt="" src="<?= $site_www?>assets/images/tradomart/tradomart-ltd-small-black.png" /></p>
            </div>
            <div class="col-md-3 social-media-holder">
                <ul class="social-media">
                    <li><a href="https://www.facebook.com/ForexMart" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/ForexMartPage" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    <?php /**<li><a href="https://plus.google.com/+Forexmartpage" target="_blank"><i class="fa fa-google-plus"></i></a></li>*/?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- end footer -->

<script type="text/javascript">
    $(".footer-toggle").click(function() {
        $(".footer-hide-menu").toggle( 300, function() {
            // Animation complete.
        });
    });
</script>

<?php //if ($this->uri->segment(1) == 'zh') {
if (false) {
?>
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

</body>
</html>
