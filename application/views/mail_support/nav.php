<style>
    .main-tab li {
        width: 50%;
    }
    .main-tab li {
        border-left: 2px solid #fff!important;
        border-right:0!important;
}
.main-tab li:first-child {
    border-left:0!important;
}
</style>
<h1><?= lang('ms_01'); ?></h1>
<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab arabic-main-tab arabic-bonus-main-tab">
        <li class="between">
            <a href="<?php echo FXPP::loc_url('mail-support/compose');?>" class="<?= $active_sub_tab == 'compose-message' ? 'acct-active' : '' ?>"><i class="fa fa-envelope"></i> <?= lang('ms_08'); ?></a>
        </li>
        <li class="between">
            <a href="<?php echo FXPP::loc_url('mail-support/my-mail');?>" class="<?= $active_sub_tab == 'my-mail' ? 'acct-active' : '' ?>"><i class="fa fa-inbox"></i> <?= lang('ms_06'); ?></a>
        </li>
        <!-- <div class="clearfix"></div> -->
    </ul>
</div>