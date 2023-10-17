<p class="cur-trades-text arabic-cur-trades-text">
    <?= lang('curtra_00');?>
</p>
<div class="cur-trades-tab arabic-cur-trades-tab">
    <ul class="ctpo_nav">
        <li><a href="<?php echo FXPP::loc_url('my-account/current-trades'); ?>" id="current_trades" class="tab-toggle <?= ($active_sub_sub_tab == 'current_trades') ? 'cur-active' : '' ?>">
                <?= lang('curtra_01');?>
            </a></li>
        <?php if (IPLoc::ForexCalc()) { ?>
            <li><a href="<?php echo FXPP::loc_url('my-account/pending-orders'); ?>" id="pending_orders" class="tab-toggle <?= ($active_sub_sub_tab == 'pending_orders') ? 'cur-active' : '' ?>">
                    <?= lang('curtra_02');?>
                </a></li>
        <?php } ?>
    </ul>
</div>

<style type="text/css">
    @media screen and (max-width:700px) {
        ul.ctpo_nav li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.ctpo_nav li a{
            text-align: center;
        }
    }



    @media screen and (min-width: 376px) and (max-width: 767px)  {

        div.dataTables_wrapper div.dataTables_length label {
            padding-left: 63px;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 156px;
        }

    }

    @media screen and (min-width: 320px) and (max-width: 375px)  {
        div.dataTables_wrapper div.dataTables_length label {
            padding-left: 20px !important;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            width: 130px !important;
        }
        div.dataTables_wrapper div.dataTables_filter label {
            margin-left: -43px !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 130px;
        }

    }







</style>