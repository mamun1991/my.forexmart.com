<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
//header('HTTP/1.0 404 Not Found');
//if ($_SERVER['REQUEST_URI'] != "/error") header( "Location: /error" );
//redirect('/error');
/*
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Forexmart - Error (404)</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
        <link href="https://www.forexmart.com/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap Core CSS -->
        <link href="https://www.forexmart.com/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://www.forexmart.com/assets/css/external-style.css" rel="stylesheet">
        <link href="https://www.forexmart.com/assets/css/carousel.css" rel="stylesheet">
        <link href="https://www.forexmart.com/assets/css/custom.css" rel="stylesheet">
        <script src="https://www.forexmart.com/assets/js/jquery-1.11.3.min.js"></script>
        <!-- Custom CSS -->
        <link href="https://www.forexmart.com/assets/css/exscrolling-nav.css" rel="stylesheet">

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
                <a class="navbar-brand page-scroll nb" href="https://www.forexmart.com"><img src="https://www.forexmart.com/assets/images/logo.png" class="img-reponsive logo"></a> <cite class="slogan">Think BIG. <i>Trade Forex</i></cite>
                <div class="clearfix"></div>
            </div>
            <div class="reg-holder">
                <ul class="nav navbar-nav navbar-right ryt">
                    <li><a href="https://my.forexmart.com/sigin" target="_blank" class="login-external"><button class="btn-reg">Login</button></a></li>
                    <li><button class="btn-login">Register</button></li>
                    <li><button class="btn-reg"><img src="https://www.forexmart.com/assets/images/flag.png" width="30px"/></button></li>
                </ul>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div id="nav" class="nav-holder">
        <div class="container">
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav nn">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">ABOUT</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">FOREX TRADING</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">PARTNERS</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">CONTACT US</a>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-right icons">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul>
                <div class="btn-top-holder">
                    <ul class="nav navbar-nav navbar-right ryt">
                        <li><button class="btn-reg1">Login</button></li>
                        <li><button class="btn-login1">Register</button></li>
                        <li><button class="btn-reg1"><img src="https://www.forexmart.com/assets/images/flag.png" width="30px"/></button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="not-found-holder">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-centered">
                    <div class="not-found">
                        <div class="row">
                            <div class="col-sm-3 error-img">
                                <img src="https://www.forexmart.com/assets/images/404.png" class="img-responsive">
                            </div>
                            <div class="col-sm-9 error-content-holder">
                                <h1 class="error-title">Error (404)</h1>
                                <p class="error-text">
                                    We can't find the page you're looking for. Check out our <a href="https://www.forexmart.com/faq">FAQ</a> for help,<br>or go to <a href="https://www.forexmart.com">Home page</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="red-line"></div>
            <div class="btn-holder error-bot btn-holder-center">
                <form class="form-inline">
                    <div class="form-group">
                        <a href="https://www.forexmart.com/register"><button class="btn-real btn-real-404">Open Trading Account</button></a>
                    </div>
                    <div class="form-group">
                        <a href="https://www.forexmart.com/register/demo"><button class="btn-demo btn-demo-404">Open Demo Account</button></a>
                    </div>
                    <div class="form-group">
                        <label>Risk Warning: Trading CFDs involves significant risk of loss.</label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- end content -->
    <div class="bot-nav-holder">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-6 footer-menu-holder">
                    <div class="footer-toggle-holder">
                        <button type="button" class="footer-toggle">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <ul class="bot-nav">
                        <li><a href="https://www.forexmart.com/privacy-policy">Policies</a></li>
                        <li class="ver-line">|</li>
                        <li><a href="https://www.forexmart.com/risk-disclosure">Risk Disclosure</a></li>
                        <li class="ver-line">|</li>
                        <li><a href="https://www.forexmart.com/terms-and-condition">Terms & Conditions</a></li>
                        <li class="ver-line">|</li>
                        <li><a href="https://www.forexmart.com/partners">Partners</a></li>
                    </ul><div class="clearfix"></div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-6 copy">
                    <p>© 2006- 2015 Fx Group</p>
                </div>
            </div>
            <div class="footer-hide-menu">
                <ul>
                    <li><a href="https://www.forexmart.com/privacy-policy">Policies</a></li>
                    <li><a href="https://www.forexmart.com/risk-disclosure">Risk Disclosure</a></li>
                    <li><a href="https://www.forexmart.com/terms-and-condition">Terms & Conditions</a></li>
                    <li><a href="https://www.forexmart.com/partners">Partners</a></li>
                </ul>
            </div>
        </div>
    </div>


    <!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <p class="footer-text">
                        <cite>Risk Warning:</cite> Contracts for Difference (‘CFDs’) are complex financial products that are traded on margin. Trading CFDs carries a high level of risk since leverage can work both to your advantage and disadvantage. As a result, CFDs may not be suitable for all investors because you may lose all your invested capital. You should not risk more than you are prepared to lose. Before deciding to trade, you need to ensure that you understand the risks involved taking into account your investment objectives and level of experience. Past performance of CFDs is not a reliable indicator of future results. Most CFDs have no set maturity date. Hence, a CFD position matures on the date you choose to close an existing open position. Seek independent advice, if necessary. Please read FxPro’s full ‘<i>Risk Disclosure Statement</i>’.
                    </p>
                    <p class="footer-text1">
                        FXPP is authorized and regulated by the [Name of regulatory board] under registration no. [reg. no.], and is authorized and regulated by the Cyprus Securities and Exchange Commision (lincese no.).
                    </p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <ul class="connect">
                        <li>
                            <a href="https://www.forexmart.com/contact-us"><img src="https://www.forexmart.com/assets/images/contact.png" class="img-reponsive"/> Contact Us</a>
                        </li>
                        <li>
                            <a href="#"><img src="https://www.forexmart.com/assets/images/live.png" class="img-reponsive"/> Live Chat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            <?php
            $CI = & get_instance();
            $errmsg[] = "Severity: " . $severity;
            $errmsg[] = "Message: " . $message;
            $errmsg[] = "Filename: " . $filepath;
            $errmsg[] = "Line Number: " . $line;
            if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE){
                $errmsg[] = "Backtrace:";
                foreach (debug_backtrace() as $error){
                    if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0) {
                        $errmsg[] = "File: " . $error['file'];
                        $errmsg[] = "Line: " . $error['line'];
                        $errmsg[] = "Function: " . $error['function'];
                    }
                }
            }

                foreach($errmsg as $err){
                    echo "console.log('" . addslashes($err) . "');" . "\n";
                }
            ?>
        });
        $(".footer-toggle").click(function() {
            $(".footer-hide-menu").toggle( 300, function() {
                // Animation complete.
            });
        });
    </script>
    </body>

    </html>
<?php
*/
/**
?>
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>
 */
?>