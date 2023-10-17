<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab arabic-main-tab arabic-bonus-main-tab">
        <li class="bonus-li" role="presentation">
            <a  id="bon1" href="<?php echo FXPP::loc_url('bonus/bonuses');?>" class="<?php echo $active_sub_tab == 'bonuses' ? 'acct-active' : '' ?>"><i class="fa fa-dollar"></i>
                <?= lang('bon_tab_00');?>

            </a></li>

        <li class="bonus-li" role="presentation">
            <a id="bon2" href="<?php echo FXPP::loc_url('bonus/bonuses-statistic');?>" class="<?php echo $active_sub_tab == 'bonuses_statistic' ? 'acct-active' : '' ?>"><i class="fa fa-area-chart"></i>
                <?= lang('bon_tab_01');?>

            </a>
        </li>

    </ul>
    <div class="clearfix"></div>
</div>

<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }

    @media screen and (max-width: 750px) {
        ul.main-tab li{
            width: 100%!important;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a{
            text-align: center;
        }
    }
    @media screen and (max-width: 750px) {
        ul.main-tab li:lang(es){
            width: 100%!important;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a:lang(es){
            text-align: center;
        }
    }
</style>
<script type="text/javascript">

    var bonhighheight=0;
    var bon1=0;
    var bon2=0;



    $(window).load(function() {
        bon1 = parseFloat($('#bon1').height());
        bon2 = parseFloat($('#bon2').height());

        bonhighheight=parseFloat(Math.round(Math.max(bon1,bon2)));
        $('#bon1').height(bonhighheight);
        $('#bon2').height(bonhighheight);

    });
    $(window).resize(function() {
        bon1 = parseFloat($('#bon1').height());
        bon2 = parseFloat($('#bon2').height());

        bonhighheight=parseFloat(Math.round(Math.max(bon1,bon2)));
        $('#bon1').height(bonhighheight);
        $('#bon2').height(bonhighheight);

    });
</script>