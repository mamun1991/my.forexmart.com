<?php $class = $this->router->class; ?>
<div class="side-nav-holder">
    <ul class="side-nav">
        <li><a href="<?php echo FXPP::loc_url('my-account');?>" class="<?=($class == 'accounts') ? 'active-sidenav' : '';?>"><i class="fa fa-suitcase"></i><cite>My Account</cite></a></li>
        <li><a href="<?php echo FXPP::loc_url('profile/edit');?>" class="<?=($class == 'profile') ? 'active-sidenav' : '';?>"><i class="fa fa-user"></i><cite>My Profile</cite></a></li>
        <li><a href="<?php echo FXPP::loc_url('deposit');?>" class="<?=($class == 'deposit') ? 'active-sidenav' : '';?>"><i class="fa fa-money"></i><cite><?= lang('trd_232');?></cite></a></li>
        <li><a href="<?php echo FXPP::loc_url('withdraw');?>" class="<?=($class == 'withdraw') ? 'active-sidenav' : '';?>"><i class="fa fa-credit-card"></i><cite>Withdraw Funds</cite></a></li>
        <li><a href="#" class=""><i class="fa fa-download"></i><cite>Platform Downloads</cite></a></li>
    </ul><div class="clearfix"></div>
</div>

