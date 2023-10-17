<div class="live-feed-child-content">
    <h2>
        <?=$trader_info;?>
    </h2>
    <img src="<?= $this->template->Images()?><?=$flag;?>" width="24" height="24"/>
    <span>
        <?=$trader_timestamp;?>
    </span>
    <ul>
        <li><a href="<?=FXPP::loc_url('pamm/monitoring')?><?=$account_monitoring;?>"><?= lang('pamm_80'); ?></a></li>
        <li><a href="<?=FXPP::loc_url('pamm/invest')?>/<?=$trader_account;?>"><?= lang('pamm_81'); ?></a></li>
    </ul>
</div>