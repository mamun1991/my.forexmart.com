<nav class="navbar navbar-default navbar-internal round-0">
  
 <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

                <img src="<?= $this->template->Images()?>new-logo-internal.svg" class="navbar-brand navbar-brand-internal img-reponsive int-logo" alt="ForexMart and LasPalmas Logo " usemap="#fxxpplaspalmas"/>
                <map name="fxxpplaspalmas">
                    <area shape="rect" coords="0,0,217,69" href="<?= FXPP::www_url('');?>" alt="ForexMart" class="nolinkline">
                    <area shape="rect" coords="217,0,434,69" href="<?= FXPP::www_url('las-palmas');?>" alt="LasPalmas" class="nolinkline">
                </map>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right navbar-right-internal">
 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img src="<?php echo $this->template->Images()?>avatar.png" class="img-responsive" width="30px" style="float: left; margin-right: 8px; margin-top: -5px;">
                        <?php echo  strlen($this->session->userdata('full_name'))>0?$this->session->userdata('full_name'): lang("sample_user");?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="accta" href="<?php echo site_url()?>accounts">My Account</a></li>
                        <li><a class="accta" href="<?php echo site_url();?>profile">My Profile</a></li>
                        <li><a class="accta" href="<?php echo site_url();?>deposit"><?= lang('trd_232');?></a></li>
                        <li><a class="accta" href="<?php echo site_url();?>withdraw">Withdraw Funds</a></li>
                        <li class="divider"></li>
                        <li><a class="accta" href="<?=site_url('Signout')?>">Log Out</a></li>
                    </ul>
                </li>
                <li><a href="#"><img src="<?= $this->template->Images()?>flag.png" class="img-reponsive" width="30px"></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>