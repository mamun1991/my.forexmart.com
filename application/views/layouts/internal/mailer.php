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

    <link rel="icon" type="image/gif" href="<?= $this->template->Images()?>icon.ico" />

    <title><?php echo $template['title']; ?></title>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:700,300,600,400" rel="stylesheet" type="text/css">
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>internal-style.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>custom.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>custom-internal.min.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>inscrolling-nav.css" rel="stylesheet">
    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>
    <!-- jQuery -->
    <script src="<?= $this->template->Js()?>jquery.js"></script>
    <!-- Owl Carousel Assets -->
    <link href="<?= $this->template->Css()?>owl.carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>owl.theme.css" rel="stylesheet">

    <!-- Prettify -->
    <link href="<?= $this->template->Css()?>prettify.css" rel="stylesheet">

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

<?php include_once('nav.php') ?>

<div class="main-content">
    <div class="container">

        <!--        internal content-->
        <div class="row">

            <!--            internal sidebar-->
            <?php include_once('mailer_sidebar.php') ?>
            <!--            end internal sidebar-->

            <div class="col-lg-9 col-md-9 col-sm-9" style="border-left: 1px solid #ccc;">
                <div class="section" style="min-height: 500px;">

                    <!--                    content navigation-->
                    <!--                    --><?php //include_once('content_nav.php') ?>
                    <!--                    end content navigation-->

                    <!--                    dynamic content-->
                    <?=(isset($template['body']))?$template['body']: ''; ?>
                    <!--                    end dynamic content-->

                </div>
            </div>
            <div class="col-lg-12 border-bottom-line"></div>
            <!--        end internal content-->

            <!--        bottom nav-->
            <?php include_once('bottom_nav.php') ?>
            <!--        end bottom nav-->

        </div>
    </div>

    <!--  start modal -->
    <?php include_once('modal_feedback.php') ?>
    <!--  end modal -->

    <!-- footer -->
    <?php include_once('footer.php') ?>
    <!-- end footer -->
    <a href="#" class="cd-top cd-is-visible cd-fade-out">Top</a>
    <!-- mainright -->
    <?php include_once('mainright.php') ?>
    <!-- mainright -->

    <!-- Bootstrap Core JavaScript -->

    <script src="<?= $this->template->Js()?>bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
    <script src="<?= $this->template->Js()?>scrolling-nav.js"></script>

    <script src="<?= $this->template->Js()?>owl.carousel.js"></script>
    <script src="<?= $this->template->Css()?>owl.transitions.css"></script>
    <!--scroll button at right bottom corner-->
    <script src="<?= $this->template->Js()?>scrolltotop.min.js"></script>
    <!--scroll button at right bottom corner-->
    <!-- Demo -->

    <style>
        #owl-demo .item{
            margin: 3px;
        }
        #owl-demo .item img{
            display: block;
            width: 100%;
            height: auto;
        }
    </style>


    <script>
        $(document).ready(function() {

            $("#owl-demo").owlCarousel({
                items : 4,
                lazyLoad : true,
                navigation : true
            });

        });
    </script>
    <?=(isset($template['metadata']))?$template['metadata']: ''; ?>
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
</body>

</html>
