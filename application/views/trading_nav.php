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
    .arabic-my-account-main-tab2 li a .fa:lang(pk){
        float:unset!important;
    }
</style>

<div class="acct-tab-holder">

    <ul role="tablist" class="main-tab ul-tab acc_nav arabic-main-tab arabic-my-account-main-tab arabic-my-account-main-tab2">
            <li role="presentation">
                <a id="an1" href="<?= FXPP::loc_url('my-trading/current-trades');?>" class=" <?=($active_sub_tab == 'current-trades') ? 'acct-active' : '';?>"><i class="fa fa-check"></i>
                    <?=lang('man_01');?>
                </a>
            </li>
            <li role="presentation">
                <a  id="an2" href="<?= FXPP::loc_url('my-trading/history-of-trades');?>" class="<?=($active_sub_tab == 'history-of-trades') ? 'acct-active' : '';?>"><i class="fa fa-history"></i>
                    <?=lang('man_02');?>
                </a>
            </li>
          <li role="presentation">
                <a  id="an3" href="<?= FXPP::loc_url('my-account/total-lots');?>" class="<?=($active_sub_tab == 'total-lots') ? 'acct-active' : '';?>"><i class="fa fa-line-chart"></i>
                    <?=lang('total_lots');?>
                </a>
            </li>
        
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
    var an3=0;
    var an4=0;
    var an5=0;

    $(window).load(function() {
        an1 = parseFloat($('#an1').height());
        an2 = parseFloat($('#an2').height());
        an3 = parseFloat($('#an3').height());
        an4 = parseFloat($('#an4').height());
        an5 = parseFloat($('#an5').height());
        if(isNaN(an5)){
            an5=0;
        }
        anhighheight=parseFloat(Math.round(Math.max(an1,an2,an3,an4,an5)));
        $('#an1').height(anhighheight);
        $('#an2').height(anhighheight);
        $('#an3').height(anhighheight);
        $('#an4').height(anhighheight);
        $('#an5').height(anhighheight);

    });
    $(window).resize(function() {
        an1 = parseFloat($('#an1').height());
        an2 = parseFloat($('#an2').height());
        an3 = parseFloat($('#an3').height());
        an4 = parseFloat($('#an4').height());
        an5 = parseFloat($('#an5').height());
        if(isNaN(an5)){
            an5=0;
        }
        anhighheight=parseFloat(Math.round(Math.max(an1,an2,an3,an4,an5)));
        $('#an1').height(anhighheight);
        $('#an2').height(anhighheight);
        $('#an3').height(anhighheight);
        $('#an4').height(anhighheight);
        $('#an5').height(anhighheight);
    });
</script>