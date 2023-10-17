<ul id="tabs" class="nav nav-tabs pamm-nav-tabs" data-tabs="tabs">
        <li class="<?=($tab == 1) ? 'active' : '';?>">
            <!--pamm-->
            <a href="<?=FXPP::loc_url('pamm');?>" ><?= lang('pamm_27'); ?></a>
        </li>
<!--    --><?php //if ($registered):?>

        <?php if ($trader){?>
    <!--    <li class="<?=($tab == 2) ? 'active' : '';?>">
       
                <a href="pamm" style="    pointer-events: none;" >My widgets</a>
            </li> -->
        <?php };?>
        <style>
            .nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
                border-color: #e6e6e6!important;
            }
        </style>
        <li class="dropdown <?=($tab == 3) ? 'active' : '';?>">
            <a href="#" id="moremenu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <?= lang('pamm_15'); ?>
                <span class="badge"></span>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="li_max"><a href="<?=FXPP::loc_url('pamm/monitoring');?>"><?= lang('pamm_15'); ?></a></li>
                <li class="li_max"><a href="<?=FXPP::loc_url('pamm/live-feed');?>"><?= lang('pamm_28'); ?></a></li>
            </ul>
        </li>
        <?php if (($trader)){?>
            <li class="<?=($tab == 4) ? 'active' : '';?>">
                <!--my conditions-->
                <a href="<?=($is_disable) ?  'javascript:void(0);':FXPP::loc_url('pamm/my-conditions') ;?>" >
                    <?= lang('pamm_103'); ?>
                </a>
            </li>
            <!--    --><?php //}?>
            <li class="<?=($tab == 5) ? 'active' : '';?>">
                <!--my investments-->
                <a href="<?=($is_disable) ? 'javascript:void(0);':FXPP::loc_url('pamm/my-monitoring');?> " >
                    My monitoring
                </a>
            </li>
        <?php };?>

        <li class="<?=($tab == 6) ? 'active' : '';?>">
            <!--my investments-->
            <a href="<?=($is_disable) ?  'javascript:void(0);':FXPP::loc_url('pamm/my-investments');?> " >
                <?= lang('pamm_105'); ?>
            </a>
        </li>
<!--    --><?php //endif; ?>
</ul>
