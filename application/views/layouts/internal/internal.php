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
    <meta name="facebook-domain-verification" content="70cmjqfyz0yua7snv7iulyzjqoebub" />

    <meta name="description" content="<?=(isset($metadata_description))? $metadata_description: '';?>">
    <meta name="keywords" content="<?=(isset($metadata_keyword))? $metadata_keyword: '';?>">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400" rel="stylesheet" type="text/css">
    <link href="<?= $this->template->Fonts()?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="<?= $this->template->Css()?>bootstrap.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>internal.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>style.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>custom-internal.min.css" rel="stylesheet">
    <?=(isset($template['metadata_css']))? $template['metadata_css']: '';?>
    <script src="<?= $this->template->Js()?>jquery-1.11.3.min.js"></script>
    <!-- Custom CSS -->
    <link href="<?= $this->template->Css()?>scrolling-nav.css" rel="stylesheet">
    <!-- Custom CSS -->

    <!-- Owl Carousel Assets -->
    <link href="<?= $this->template->Css()?>owl.carousel.css" rel="stylesheet">
    <link href="<?= $this->template->Css()?>owl.theme.css" rel="stylesheet">


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
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<nav class="navbar navbar-default round-0">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo here</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control round-0" id="exampleInputAmount" placeholder="Search...">
                            <div class="input-group-addon round-0"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </form>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="<?= $this->template->Images()?>avatar.png" class="img-responsive" width="30px" style="float: left; margin-right: 8px; margin-top: -5px;"> <?= lang("sample_user"); ?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?=site_url('accounts')?>"><?= lang('sb_li_0'); ?></a></li>
                        <li><a href="#"><?= lang('sb_li_1'); ?></a></li>
                        <li><a href="#"><?= lang('sb_a_1'); ?></a></li>
                        <li><a href="#"><?= lang('sb_a_2'); ?></a></li>
                        <li><a href="#"><?= lang('sb_a_3'); ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#">Log Out</a></li>
                    </ul>
                </li>
                <li><a href="#"><img src="<?= $this->template->Images()?>flag.png" class="img-reponsive" width="30px"></a></li>
            </ul>s
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="main-content">
<div class="container">
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3" style="border-right: 1px solid #ccc;">
        <div class="dl-holder">
            <h1 class="accbal-title">Account Balance</h1>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control round-0 txt-balance" placeholder="" Value="0.00">
                    <div class="input-group-addon round-0 euro-sign">&euro;</div>
                </div>
            </div>
            <div class="btn-deposit-holder">
                <button class="btn-deposit"><?= lang('trd_232');?></button>
            </div>
            <div class="btn-withdraw-holder">
                <button class="btn-withdraw">Withdraw Funds</button>
            </div>
            <div class="dls">
                <h1>Download platforms</h1>
                <ul class="platforms">
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx1.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart Client Terminal<br><cite>MT4 Platform</cite>
                        </a>
                    </li><div class="clearfix"></div>
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx2.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart MultiTerminal<br><cite>Multi-MT4</cite>
                        </a>
                    </li><div class="clearfix"></div>
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx3.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart WebTrader<br><cite>MT4 Online</cite>
                        </a>
                    </li><div class="clearfix"></div>
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx4.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart iPhone<br><cite>Trader</cite>
                        </a>
                    </li><div class="clearfix"></div>
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx5.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart iPad<br><cite>Trader</cite>
                        </a>
                    </li><div class="clearfix"></div>
                    <li>
                        <a href="#">
                            <img src="<?= $this->template->Images()?>fx6.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                            ForexMart Android<br><cite>Transfer</cite>
                        </a>
                    </li><div class="clearfix"></div>
                 </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="section">
            <div class="side-nav-holder">
                <ul class="side-nav">
                    <li><a href="<?=site_url()?>accounts" class="active-sidenav"><i class="fa fa-suitcase"></i><cite>My Account</cite></a></li>
                    <li><a href="#"><i class="fa fa-user"></i><cite>My Profile</cite></a></li>
                    <li><a href="#"><i class="fa fa-money"></i><cite><?= lang('trd_232');?></cite></a></li>
                    <li><a href="#"><i class="fa fa-credit-card"></i><cite>Withdraw Funds</cite></a></li>
                    <li><a href="#"><i class="fa fa-download"></i><cite>Platform Downloads</cite></a></li>
                </ul><div class="clearfix"></div>
            </div>
            <h1 class="">My Accounts</h1>
            <div class="col-md-9 col-sm-9" style="padding-left: 0;">
                <div class="btns">
                    <button class="open-trading">Open Trading Account</button>
                    <button class="open-demo">Open Demo Account</button>
                </div><div class="clearfix"></div>
            </div>
            <div class="col-md-3 col-sm-3" style="padding-right: 0;">
                <button class="show-hide">Filters</button>
            </div>
            <div class="col-md-12" style="padding: 0; margin-top: 20px;">
                <div class="table-responsive">
                    <table class="table table-striped" style="border: 1px solid #ccc;">
                        <thead>
                        <tr>
                            <th>Account(s)/Actions</th>
                            <th>Leverage</th>
                            <th>Currency</th>
                            <th>Free Margin</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Account Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="color: #ff0000;">4515830 <i class="fa fa-caret-down"></i></td>
                            <td>1:100</td>
                            <td>USD</td>
                            <td>5,000.00</td>
                            <td>5,000.00</td>
                            <td>Appoved</td>
                            <td>demo</td>
                            <td>MT4</td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000;">4515830 <i class="fa fa-caret-down"></i></td>
                            <td>1:100</td>
                            <td>USD</td>
                            <td>5,000.00</td>
                            <td>5,000.00</td>
                            <td>Appoved</td>
                            <td>demo</td>
                            <td>MT4</td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000;">4515830 <i class="fa fa-caret-down"></i></td>
                            <td>1:100</td>
                            <td>USD</td>
                            <td>5,000.00</td>
                            <td>5,000.00</td>
                            <td>Appoved</td>
                            <td>demo</td>
                            <td>MT4</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-12" style="padding: 0; margin-top: 20px;">
                <div class="deposits-holder">
                    <h1><?= lang('trd_15'); ?></h1>
                    <div class="banks">
                        <div id="demo">
                            <div class="span12">

                                <div id="owl-demo" class="owl-carousel">
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>banktransfer.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>visa.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>mastercard.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>unionpay.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>skrill.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>neteller.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>webmoney.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>paxum.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>ukash.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>payco.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>filspay.png" alt="Lazy Owl Image"></a></div>
                                    <div class="item"><a href="#"><img class="lazyOwl" data-src="<?= $this->template->Images()?>cashu.png" alt="Lazy Owl Image"></a></div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="border-top: 1px solid #ccc;">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="about-us-holder">
            <h1>About Us</h1>
            <ul>
                <li><a href="">Forex Trading</a></li>
                <li><a href="">Partners</a></li>
                <li><a href="">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="account-holder">
            <h1>Accounts</h1>
            <ul>
                <li><a href="">My Accounts</a></li>
                <li><a href="">My Profile</a></li>
                <li><a href=""><?= lang('trd_232');?></a></li>
                <li><a href="">Withdraw Funds</a></li>
                <li><a href="">Platforms</a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="connect-holder">
            <h1>Need Help?</h1>
            <ul>
                <li>
                    <a href="">
                        <img src="<?= $this->template->Images()?>circle3.png" width="40px;"/> Help Center
                    </a>
                </li>
                <li>
                    <a href="">
                        <img src="<?= $this->template->Images()?>live.png" width="40px;"/> Live Chat
                    </a>
                </li>
                <li>
                    <a href="">
                        <img src="<?= $this->template->Images()?>contact.png" width="40px;"/> Call Me Back
                    </a>
                </li>
            </ul><div class="clearfix"></div>
        </div>
        <div class="follow-holder">
            <h1>Follow Us</h1>
            <ul>
                <li>
                    <a href="" class="gplus"><img src="<?= $this->template->Images()?>gplus.png" width="30px"></a>
                </li>
                <li>
                    <a href="<?= $this->config->item('domain-facebook');?>" class="fb" target="_blank"><img src="<?= $this->template->Images()?>fb.png" width="30px"></a>
                </li>
                <li>
                    <a href="" class="in"><img src="<?= $this->template->Images()?>linkedin.png" width="30px"></a>
                </li>
                <li>
                    <a href="<?= $this->config->item('domain-twitter');?>" class="twit" target="_blank"><img src="<?= $this->template->Images()?>twitter.png" width="30px"></a>
                </li>
            </ul><div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row" style="border-top: 1px solid #2988CA; padding: 10px; 0">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ul class="other-link">
            <li><a href="">Legal Information</a></li>
            <li><a href="">Privacy Policy</a></li>
            <li><a href="">Risk Disclosure</a></li>
        </ul><div class="clearfix"></div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="copyright">
            <h4>Logo Here <small>&copy; 2006-2015 FX Project.</small></h4>
        </div>
    </div>
</div>
</div>
</div>

<!-- footer -->
<footer style="background: #fbfafa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p class="footer-text">
                    <cite>Legal:</cite><br>
                    ForexMart Financial Services Ltd is authorized and regulated by the CySEC (license no. 078/07) ForexMart UK Limited is authorized and regulated by the Financial Services Authority, registration number 509956.
                </p>
                <p class="footer-text">
                    <cite>Risk Warning:</cite> Contracts for Difference (‘CFDs’) are complex financial products that are traded on margin. Trading CFDs carries a high level of risk since leverage can work both to your advantage and disadvantage. As a result, CFDs may not be suitable for all investors because you may lose all your invested capital. You should not risk more than you are prepared to lose. Before deciding to trade, you need to ensure that you understand the risks involved taking into account your investment objectives and level of experience. Past performance of CFDs is not a reliable indicator of future results. Most CFDs have no set maturity date. Hence, a CFD position matures on the date you choose to close an existing open position. Seek independent advice, if necessary.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- end footer -->

<!-- jQuery -->
<script src="<?= $this->template->Js()?>jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?= $this->template->Js()?>bootstrap.min.js"></script>

<!-- Scrolling Nav JavaScript -->
<script src="<?= $this->template->Js()?>jquery.easing.min.js"></script>
<script src="<?= $this->template->Js()?>scrolling-nav.js"></script>

<script src="<?= $this->template->Js()?>owl.carousel.js"></script>
<script src="<?= $this->template->Js()?>owl.transitions.js"></script>

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

</body>

</html>
