<?php $class = $this->router->class; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">

    <title>FX Site</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= $this->template->Css()?>bootstrap.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>style.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>administration.min.css" rel="stylesheet">
    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>


    <script src="<?= $this->template->Js()?>jquery-1.11.3.min.js"></script>
    <!-- Custom CSS -->
    <link href="<?= $this->template->Css()?>scrolling-nav.css" rel="stylesheet">

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
    <?=(isset($template['metadata_js']))? $template['metadata_js']: '';?>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</head>


<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div class="parent">

    <?php include_once('nav.php') ?>

    <div class="childmiddle">
    <!-- content -->
    <?=(isset($template['body']))?$template['body']: ''; ?>
    <!-- end content -->
    </div>

    <div class="childbottom">

        <?php include_once('bottom_nav.php') ?>

        <?php include_once('footer.php') ?>
        <a href="#" class="cd-top cd-fade-out " >Top</a>
    </div>
</div>
<!-- jQuery -->
<script src="<?= $this->template->Js()?>jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= $this->template->Js()?>bootstrap.min.js"></script>

<!-- Scrolling Nav JavaScript -->
<script src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
<script src="<?= $this->template->Js()?>scrolling-nav.js"></script>
<!--scroll button at right bottom corner-->
<script src="<?= $this->template->Js()?>scrolltotop.min.js"></script>
<!--scroll button at right bottom corner-->
</body>

</html>
