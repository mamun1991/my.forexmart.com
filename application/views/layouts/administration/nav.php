
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="<?=site_url()?>">
                <img src="<?php echo $this->template->Images()?>logo.png" class="img-reponsive logo" width="184px" alt="logo"> <cite class="slogan">Think BIG. <i>Trade Forex</i></cite>
            </a>
        </div>
        <div class="reg-holder">
            <ul class="nav navbar-nav navbar-right ryt">
                <?php if($this->session->userdata('email')){?>
                    <li class="adjustment"><span >Hi,<?=$this->session->userdata('full_name')?> </span><a href="<?=site_url('accounts')?>" class="login-extenal "> [Go to My Account]</a></li>
                    <li><a href="<?=site_url('signout')?>" class="login-extenal"><button class="btn-reg">Logout</button></a></li>
                <?php }  else{?>
                        <?php $router =& load_class('Router', 'core');if(strtolower($router->fetch_class()=='signin')){ ?>
                         <?php }else{?>
                                <li><a href="<?=site_url('signin')?>" class="login-extenal"><button class="btn-reg">Login</button></a></li>
                        <?php }   ?>
                                <li><button class="btn-login"><?php // lang('ex_nav_reg'); ?>Register</button></li>
                <?php }   ?>
                <li><button class="btn-reg"><img src="<?= $this->template->Images()?>flag.png" width="30px"/></button></li>
            </ul>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="nav-holder" id="nav" >
    <div class=" container">
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul  class=" enav nav navbar-nav">
                <li>
                    <a class="page-scroll" >Home</a>
                    <div class="inner-menu-panel border_bottom" >
                        <ul class="sub-menu">
                            <li class="submenumain">
                                <a href="<?=site_url('administration')?>" class="submenutopic">Home</a>
                                <ul>
                                    <li> <a href="<?=site_url('administration')?>" class="subtopic">Home</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="page-scroll" >User Access </a>
                    <div class="inner-menu-panel border_bottom" >
                        <ul class="sub-menu">
                            <li class="submenumain">
                                <a href="<?=site_url('administration')?>" class="submenutopic">User Access</a>
                                <ul>
                                    <li> <a href="<?=site_url('administration-useraccess')?>" class="subtopic">User Access</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="page-scroll" >Transactions </a>
                    <div class="inner-menu-panel border_bottom" >
                        <ul class="sub-menu">
                            <li class="submenumain">
                                <a href="<?=site_url('administration')?>" class="submenutopic">Transactions</a>
                                <ul>
                                    <li> <a href="<?=site_url('administration-withdrawal')?>" class="subtopic">Withdrawal</a> </li>
                                    <li> <a href="<?=site_url('administration-deposit')?>" class="subtopic">Deposit</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="page-scroll" >Others </a>
                    <div class="inner-menu-panel border_bottom" >
                        <ul class="sub-menu">
                            <li class="submenumain">
                                <a href="<?=site_url('administration')?>" class="submenutopic">Others</a>
                                <ul>
                                    <li> <a href="<?=site_url('administration-feedback')?>" class="subtopic">Feedback</a> </li>
                                    <li> <a href="<?=site_url('administration-news')?>" class="subtopic">Company News</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav navbar-right icons">
                <li><a href="<?= $this->config->item('domain-facebook');?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?= $this->config->item('domain-twitter');?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                <?php /**<li><a href="<?= $this->config->item('domain-googleplus');?>"><i class="fa fa-google-plus"></i></a></li>*/?>
            </ul>
         </div>
    </div>
</div>




