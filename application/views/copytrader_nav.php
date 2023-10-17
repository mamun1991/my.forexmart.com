
<h1>
   Copy Traders
</h1>

<div class="acct-tab-holder">
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                
                <li><a href="<?=FXPP::my_url('copytrade/my_followers')?>" id="active-tab4"><i class="fa fa-bar-chart"></i>Copied</a></li>
                <li><a href="<?=FXPP::my_url('copytrade/my_copytraders_monitoring/'. $masterAcc)?>" id="active-tab4"><i class="fa fa-bar-chart"></i>Monitoring</a></li>
            </ul><div class="clearfix"></div>
        </div>
    <div class="clearfix"></div>
</div>
<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }
    @media screen and (max-width: 1120px) {
        ul.main-tab li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a{
            text-align: center;
        }
    }
    @media screen and (max-width: 1120px) {
        ul.main-tab li:lang(es){
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a:lang(es){
            text-align: center;
        }
    }

    @media screen and (min-width: 640px) and (max-width: 1120px){
        .main-tab li:last-child{
            border-right: 2px solid #fff!important;
        }
    }
</style>
<script type="text/javascript">

    var fin_navhighheight=0;
    var fin_nav1=0;
    var fin_nav2=0;
    var fin_nav3=0;
    var fin_nav4=0;

    $(window).load(function() {
        fin_nav1 = parseFloat($('#fin_nav1').height());
        fin_nav2 = parseFloat($('#fin_nav2').height());
        fin_nav3 = parseFloat($('#fin_nav3').height());
        fin_nav4 = parseFloat($('#fin_nav4').height());
        if(isNaN(fin_nav4)){
            fin_nav4=0;
        }
        fin_navhighheight=parseFloat(Math.round(Math.max(fin_nav1,fin_nav2,fin_nav3,fin_nav4)));
        $('#fin_nav1').height(fin_navhighheight);
        $('#fin_nav2').height(fin_navhighheight);
        $('#fin_nav3').height(fin_navhighheight);
        $('#fin_nav4').height(fin_navhighheight);


    });
    $(window).resize(function() {
        fin_nav1 = parseFloat($('#fin_nav1').height());
        fin_nav2 = parseFloat($('#fin_nav2').height());
        fin_nav3 = parseFloat($('#fin_nav3').height());
        fin_nav4 = parseFloat($('#fin_nav4').height());
        if(isNaN(fin_nav4)){
            fin_nav4=0;
        }
        fin_navhighheight=parseFloat(Math.round(Math.max(fin_nav1,fin_nav2,fin_nav3,fin_nav4)));
        $('#fin_nav1').height(fin_navhighheight);
        $('#fin_nav2').height(fin_navhighheight);
        $('#fin_nav3').height(fin_navhighheight);
        $('#fin_nav4').height(fin_navhighheight);
    });
</script>