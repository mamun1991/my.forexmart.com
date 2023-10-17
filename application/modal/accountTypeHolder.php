<
<?php if( $_SERVER['REMOTE_ADDR']==='120.29.75.242' ){ ?>
    <link rel='stylesheet' href='<?=$this->template->Css()?>additional-style.css'>
    <div class="account-types-holder">
        <div class="grp-items row">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-default">
                    <h2 class="item-title text-default">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('classic');?></div>
                    </h2>
                    <a class="btn-bordered bordered-default" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-primary">
                    <h2 class="item-title text-primary">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('pro');?></div>
                    </h2>
                    <a class="btn-bordered bordered-primary" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-success">
                    <h2 class="item-title text-success">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('cents');?></div>
                    </h2>
                    <a class="btn-bordered bordered-success" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <div class="item item-danger">
                    <h2 class="item-title text-danger">
                        <span class="subtitle"><?=lang('forexMart');?></span>
                        <div><?=lang('zero_spread');?></div>
                    </h2>
                    <a class="btn-bordered bordered-danger" href="<?php echo FXPP::www_url('account-type') ?>" target="_self"><?=lang('learn_more');?></a>
                </div>
            </div>
        </div>
    </div>
<?php }?>