<style type="text/css">
    .info-box-holder
    {
        margin-top: 15px;
    }
    .panel-blue {
        border-color: #2988ca;
        /*margin-bottom: 0!important;*/
        border-radius: 0px!important;
    }
    .panel-blue > .panel-heading {
        color: #fff;
        background-color: #2988ca;
        border-color: #2988ca;
        /*font-family: Open Sans;*/
        border-radius: 0px!important;
    }
    .panel-blue > .panel-heading + .panel-collapse > .panel-body {
        border-top-color: #2988ca;
    }
    .panel-blue > .panel-heading .badge {
        color: #2988ca;
        background-color: #fff;
    }
    .panel-blue > .panel-footer + .panel-collapse > .panel-body {
        border-bottom-color: #2988ca;
    }
    .panel-blue a
    {
        color: #2988ca;
    }
    .huge
    {
        font-size: 30px;
    }
    .partnership-text
    {
        /*font-family: Open Sans;*/
        font-size: 14px;
        color: #333;
    }
</style>


<div class="acct-tab-holder">

    <ul role="tablist" class="main-tab ul-tab acc_nav arabic-main-tab arabic-my-account-main-tab">


            <li><a id="sm1" style="height: 50px;" href="<?= FXPP::loc_url('smartdollar');?>" class="<?=($active_sub_tab == 'smartdollar') ? 'acct-active' : '';?>"><i class="fa fa-usd"></i>
                    <?=lang('sb_li_13');?>
                </a></li>


            <li><a id="sm2" style="height: 50px;" href="<?= FXPP::loc_url('my-account/total-lots');?>" class="<?=($active_sub_tab == 'total-lots') ? 'acct-active' : '';?>"><i class="fa fa-line-chart"></i>
                    <?=lang('total_lots');?>
                </a></li>


           <div class="clearfix"></div>
    </ul>

</div>

<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }
    @media screen and (max-width: 1000px) {
        ul.acc_nav li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.acc_nav li a{
            text-align: center;
        }
    }
    .arabic-main-tab li {
        width: 20%;
    }
</style>
<script type="text/javascript">

    var anhighheight=0;
    var an1=0;
    var an2=0;

    $(window).load(function() {
        an1 = parseFloat($('#sm1').height());
        an2 = parseFloat($('#sm2').height());

        anhighheight=parseFloat(Math.round(Math.max(an1,an2)));
        $('#sm1').height(anhighheight);
        $('#sm2').height(anhighheight);

    });
    $(window).resize(function() {
        an1 = parseFloat($('#sm1').height());
        an2 = parseFloat($('#sm2').height());
        anhighheight=parseFloat(Math.round(Math.max(an1,an2)));
        $('#sm1').height(anhighheight);
        $('#sm2').height(anhighheight);
    });
</script>