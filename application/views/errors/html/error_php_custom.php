<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/gif" href="<?php echo base_url('assets/images/icon.ico') ?>" />
    <title>ForexMart</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/external-style.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/carousel.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js') ?>"></script>
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/exscrolling-nav.css') ?>" rel="stylesheet">

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
    <style>
        .nav-fix
        {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            transition: all ease 0.3s;
        }
    </style>
</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div class="error-main-holder">
    <div class="error-header-holder">
        <div class="error-logo-holder">
            <a href="https://www.forexmart.com"><img src="<?php echo base_url('assets/images/logo5.svg') ?>" class="img-responsive error-logo"></a>
        </div>
    </div>
    <div class="error-content-holder">
        <div class="error-content-holder">
            <img src="<?php echo base_url('assets/images/error500.png') ?>" class="img-responsive error-cont">
            <p class="error-cont-text">
                We are sorry but <span>ForexMart</span> is temporarily unavailable.<br>
                We apologize for the inconvenience.
            </p>
        </div>
    </div>
    <div class="error-img-holder">
        <div class="error-logo-holder">
            <img src="<?php echo base_url('assets/images/error-img.png') ?>" class="img-responsive error-img">
        </div>
    </div>
    <div class="error-footer-holder">
        <p class="error-footer-text">
            Check out our <a href="https://www.forexmart.com/faq">FAQ</a> for help, or you may reach us using <a href="https://www.forexmart.com/contact-us">Contact us</a> page.
        </p>
    </div>
</div>
<!-- jQuery -->
<script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>

<!-- Scrolling Nav JavaScript -->
<script src="<?php echo base_url('assets/js/jquery.easing.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/scrolling-nav.js') ?>"></script>

</body>

</html>
