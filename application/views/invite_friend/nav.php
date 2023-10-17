
<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }
    .main-tab li {
        border-left: 2px solid #fff!important;
        border-right:0!important;
    }
    .main-tab li:first-child {
        border-left:0px;
    }

    ul.main-tab li {
        width: 33.33%;
    }
    @media screen and (max-width: 1000px) {
        ul.main-tab li{
            width: 100%;
            float: none;
            margin: 1px;
            border-left: 2px solid #fff!important;
        }
        ul.main-tab li a{
            text-align: center;
        }
        .main-tab li {
            width: 33.33%;
        }
    }

    @media only screen and (min-width: 1000px){
        .main-tab li{
            border-left: 0!important;
            border-right: 2px solid #fff!important;
        }
    }
    .acct-cont {
        border: 1px solid #ccc;
        margin-bottom: 20px;
        padding: 10px;
    }
</style>

<h1>
    <?=lang('iafn_00');?>
</h1>
<!--<p class="affiliate-code">Affiliate Code: <span><?php /*echo $affiliate_code;*/?></span></p>-->
<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab arabic-main-tab arabic-invite-friend-tab">
        <li >
            <a  id="if1" href="<?= FXPP::loc_url('invite-friend/invite-by-email');?>" class="<?='bw '?><?php echo $active_sub_tab == 'invite-by-email' ? 'acct-active' : '' ?>"><i class="fa fa-paper-plane"></i>
                <?=lang('iafn_01');?>

            </a></li>
        <li ><a  id="if2"href="<?= FXPP::loc_url('invite-friend/my-friends');?>" class="<?='bw '?><?php echo $active_sub_tab == 'my-friends' ? 'acct-active' : '' ?>"><i class="fa fa-users"></i>
                <?=lang('iafn_02');?>
            </a></li>
        <li ><a  id="if3" href="<?= FXPP::loc_url('invite-friend/statistics');?>" class="<?='bw '?><?php echo $active_sub_tab == 'statistics' ? 'acct-active' : '' ?>"><i class="fa fa-bar-chart"></i>
                <?=lang('iafn_03');?>
            </a></li>
        <div class="clearfix"></div>
    </ul>
</div>

<script type="text/javascript">
    var ifhighheight=0;
    var if1=0;
    var if2=0;
    var if3=0;


    $(window).load(function() {
        if1 = parseFloat($('#if1').height());
        if2 = parseFloat($('#if2').height());
        if3 = parseFloat($('#if3').height());


        ifhighheight=parseFloat(Math.round(Math.max(if1,if2,if3)));

        $('#if1').height(ifhighheight);
        $('#if2').height(ifhighheight);
        $('#if3').height(ifhighheight);
        console.log(ifhighheight);
    });

    $(window).resize(function() {
        if1 = parseFloat($('#if1').height());
        if2 = parseFloat($('#if2').height());
        if3 = parseFloat($('#if3').height());


        ifhighheight=parseFloat(Math.round(Math.max(if1,if2,if3)));

        $('#if1').height(ifhighheight);
        $('#if2').height(ifhighheight);
        $('#if3').height(ifhighheight);
        console.log(ifhighheight);

    });

</script>