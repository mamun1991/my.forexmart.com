<style>

    .dataTables_scroll{
        margin-bottom:15px;
    }
    #fc-offer {
        border: 1px solid #e6e6e6;
        height: auto !important;
        max-height: 280px;
        overflow: auto;
        padding: 10px;
        font-size: 12px;
        width: 100%;
    }
    .content-head-block {
        background-color: #136fd7;
        color: #FFF;
        padding-left: 15px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #fc-offer p{
        font-style: normal;
    }
    #fc-offer li{
        font-size: 15px;
    }
    .btn-main {
        color: #fff;
        background-color: #3d83d2;
        /*border-color: #db3e2b;*/
    }
    .fc-agrr-body{
        margin-bottom: 30px;
    }
    .content-head-block-dark {
        /*background-color: #373739;*/
        background-color: #373739;
        color: #FFF;
        padding-left: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
    }

    .w100 td {
        line-height: 170% !important;
    }
    #advanced_settings_select div.selector{
        width: 163px;

    }
    #advanced_settings_select div.selector span{
        width: 120px;

    }
    #advanced_settings_select div.selector select{
        width: 160px;

    }

    .tooltip-help
    {
        width: 24px;
        height: 16px;
        display: inline-block;
        text-decoration: none;
        vertical-align: middle;
    }

    .tooltip-help2
    {
        width: 17px;
        height: 17px;
        display: inline-block;
        text-decoration: none;
        vertical-align: middle;
    }

    .serarch_trader{ float: right !important;
        width: 35% !important;
        margin: 0px 8px !important;
        height: 38px !important;
        border-radius: 5px !important;
    }

    .serarch_follower{ float: right !important;
        width: 35% !important;
        margin: 0px 8px !important;
        height: 38px !important;
        border-radius: 5px !important;
    }

    .no-sort::after { display: none!important; }

    .no-sort { pointer-events: none!important; cursor: default!important; }

@media only screen and (min-width: 1001px) and (max-width: 1015px)  {
 .main-tab li a{font-size:16px !important }

}
</style>


<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">

        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>
  
                <li  class="active">
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
            
            
                    <li>
                        <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                    </li>

                  
        
                
                <?php if(FXPP::getCopytradeType() == 1){ ?>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
                <?php } ?>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="tab-content clearfix">
            <?php if($noTrader){ ?>
                <p><?= lang('trd_97'); ?><a href="<?=FXPP::my_url('copytrade')?>"><?= lang('trd_98'); ?></a></p>
            <?php }else{ ?>

                <div class="subscribed">
                    <p><?= lang('trd_99'); ?></p>
                </div>
            <?php } ?>
            <div class="no-subs" style="display: none;">
                <p><?= lang('trd_100'); ?></p>
            </div>

            <div class="col-sm-12 subscription subscribed-follower">
                <div class="content-head-block-dark"><?= lang('trd_101'); ?> </div> <!-- My Follower -->
                <div class="table-responsive fc-trader-list copytrading" style="overflow-x:hidden;width:100%">
                    <input type="search" id="search_follower" class="form-control input-sm serarch_trader" placeholder="<?= lang('search_account'); ?>">
                    <table id= "follower_table" class="table  table-striped">
                        <thead>
                        <tr>

                            <th class="text-center"><?= lang('trd_102'); ?></th>
                            <th class="text-center"><?= lang('trd_103'); ?></th>
                            <th class="text-center"><?= lang('trd_104'); ?></th>
                            <th class="text-center"><?= lang('trd_105'); ?></th>
                            <th class="text-center"><?= lang('trd_106'); ?></th>
                          
                            <th class="text-center"><?= lang('trd_278'); ?> <i class="fa fa-question-circle pop-rollover" style="text-align: left;position: absolute;" aria-hidden="true"  data-html ="true" data-toggle="popover" data-placement="top" data-content="<?=$rolloverNote?>" > </i></th>
                            
                            <th class="text-center"><b><?= lang('trd_279'); ?></b></th>
                            <th class="text-center"><b><?= lang('trd_107'); ?></b></th>
                        </tr>
                        </thead>
                        <tbody id = "follower-list-body">

                        </tbody>
                    </table>

                </div>


            </div>
            <div class="text-center">
                <div id="follower_pagination"></div>
                <input type="hidden" id="followerTotalPages" value="<?php echo $followerTotalPages; ?>">
            </div>



            <div class="col-sm-12 subscription subscribed-trader">
                <div class="content-head-block-dark"><?= lang('trd_109'); ?></div><!--Traders you subscribed to-->
                <div class="table-responsive fc-trader-list copytrading" style="overflow-x: hidden;width:100%">

                    <input type="search" id="search_trader" class="form-control input-sm serarch_trader" placeholder="<?= lang('search_account'); ?>">
                    <table id= "trader_table" class="table  table-striped" >
                        <thead>
                        <tr>
                            <th class="text-center"><?= lang('trd_102'); ?></th>
                            <th class="text-center"><?= lang('trd_103'); ?></th>
                            <th class="text-center"><?= lang('trd_104'); ?></th>
                            <th class="text-center"><?= lang('trd_105'); ?></th>
                            <th class="text-center"><?= lang('trd_106'); ?></th>
                            
                            <th class="text-center"><b><?= lang('trd_280'); ?></b></th>
                                          
                            <th class="text-center"><b><?= lang('trd_107'); ?></b></th>
                        </tr>
                        </thead>
                        <tbody id = "trader-list-body">
                        </tbody>
                    </table>

                </div>

            </div>
            <div class="text-center">
                <div id="trader_pagination"></div>
                <input type="hidden" id="traderTotalPages" value="<?php echo $traderTotalPages; ?>">
            </div>

            <!-- Start MY Subscriptions -->
            <div class="col-sm-12 subscription past-subscription" style="display: block;">
                <div class="content-head-block-dark"><?= lang('trd_110'); ?> </div>
                <div class="table-responsive fc-trader-list copytrading" style="overflow-x: scroll;">

                    <input type="search" id="search_pastsubs" class="form-control input-sm serarch_follower" placeholder="<?= lang('search_account'); ?>">



                    <table id= "past_subscription" class="table  table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"><?= lang('trd_80'); ?></th>
                            <th class="text-center"><?= lang('trd_104'); ?></th>
                            <th class="text-center"><?= lang('trd_105'); ?></th>
                            <th class="text-center"><?= lang('trd_106'); ?></th>
                        </tr>
                        </thead>
                        <tbody id = "pastsubs-list-body">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center">
                <div id="subs_pagination"></div>
                <input type="hidden" id="subsTotalPages" value="<?php echo $subsTotalPages; ?>">
            </div>
            <!-- End MY Subscriptions -->


        </div>

          <?= $copytrade_info_modal; ?>

        <div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog"  id="trader-modal" aria-labelledby="mySmallModalLabel" aria-hidden="false" style="padding-right: 17px;">
            <div class="modal-backdrop fade in" style="height: 928px;"></div>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 0px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- <div class="imgloader" style="text-align: center; display: none;"><img src="<?//=$this->template->Images()?>ajax-loader-long.gif"></div>-->
                            <div class="col-md-12 body-content-con"  style="display: none;">

                                <h1>Current commission settings</h1>
                                <table cellpadding="0" cellspacing="0" class="table table_main table-striped">
                                    <tbody>
                                    <tr>
                                        <td class="right" style="width: 50%"><?= lang('trd_112'); ?> </td>
                                        <td class = "td-show td_1" style="padding-bottom: 9px;"><?= lang('trd_113'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="right" style="width: 50%"><?= lang('trd_114'); ?> </td>
                                        <td class = "td-show td_2" style="padding-bottom: 9px;"><?= lang('trd_113'); ?> </td>
                                    </tr>
                                    <tr>
                                        <td class="right" style="width: 50%"><?= lang('trd_115'); ?> </td>
                                        <td class = "td-show td_10" style="padding-bottom: 9px;"><?= lang('trd_113'); ?> </td>
                                    </tr>
                                    <tr>
                                        <td class="right" style="width: 50%"><?= lang('trd_116'); ?></td>
                                        <td class = "td-show td_3" style="padding-bottom: 9px;"><?= lang('trd_113'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="right" style="width: 50%"><?= lang('trd_117'); ?> </td>
                                        <td class = "td-show td_4" style="padding-bottom: 9px;"><?= lang('trd_113'); ?> </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="confirmUnsubscribeModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?= lang('trd_120'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title conf-modal-title text-center"></h4>
                        <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                    </div>
                    <div class="modal-body">

                        <div class="unsubscribe-one">
                            <p class = "trade-desc">Unsubscribing to connection will cause: </p><br>
                            <p class = "trade-desc">1. Close all copied trades from the unsubscribing connection</p><br>

                            <div class="col-md-12 trade-body-content">
                                <table class="tPresentation table-responsive table  table-striped " style="width: 100%; margin-top: 12px; padding-bottom: 5px;" cellpadding="0" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td colspan="8"> <center><b><?= lang('trd_122'); ?></b></center></td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <th class="first center"><b><?= lang('trd_123'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_124'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_125'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_126'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_127'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_128'); ?></b></th>
                                        <th class="middle center"><b><?= lang('trd_129'); ?></b></th>
                                        <th class="last center"><b><?= lang('trd_130'); ?></b></th>
                                    </tr>
                                    </thead>
                                    <tbody id="open_trade_unsubs">

                                    </tbody>
                                </table>
                            </div>
                            <p class = "trade-desc">2. Pending rollover commission will be paid to traders account</p><br>
                            <p>Commission to be paid: <span id="totalRollOverProfit"></span></p>
                        </div>
                        <div class="unsubscribe-two">
                            <p class = "trade-desc-two"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" id="confirm-close-btn" data-dismiss="modal" value="Cancel">
                        <input type="button" class="btn btn-danger" id ="confirm-unsubscribe-btn" value="Continue">
                    </div>
                </div>
            </div>
        </div>
      
        <div id="confirmModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title">Modal title</h5> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title conf-modal-title text-center"></h4>
                        <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                    </div>
                    <div class="modal-body">
                        <p id="m_message" class="text-center conf-modal-desc"></p>
                    </div>
                    <div class="modal-footer">
                       <input type="button" class="btn btn-primary" id ='confirm' value="Yes">
                        <input type="button" class="btn btn-default"  data-dismiss="modal" value="No">
                    </div>
                </div>
            </div>
        </div>
        <div id="ticket_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" style="  position: absolute;top: 50%; left: 50%; transform: translate(-50%, -50%) !important;">
                <div class="modal-content">
                    <div class="modal-header">
                       
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                              <tr><th class="text-center" colspan=2>Master Ticket <span id="span_mTicket"></span> Info</h5></th></tr>

                            </thead>
                            <tbody>
                            <tr>
                                <td>Ticket</td>
                                <td id="td_ticket"></td>
                            </tr>
                            <tr>
                                <td>Close Price</td>
                                <td id="td_clsPrice"></td>
                            </tr>
                            <tr>
                                <td>Cmd</td>
                                <td id="td_cmd"></td>
                            </tr>
                            <tr>
                                <td>Open Price</td>
                                <td id="td_openPrice"></td>
                            </tr>
                            </td>
                                <td>Profit</td>
                                <td id="td_profit"></td>
                            </tr>
                            </td>
                                <td>SL</td>
                                <td id="td_sl"></td>
                            </tr>
                            </td>
                                <td>TP</td>
                                <td id="td_tp"></td>
                            </tr>
                            </td>
                                <td>Symbol</td>
                                <td id="td_symbol"></td>
                            </tr>
                            <tr>
                                <td>Close Time</td>
                                <td id="td_clsTime"></td>
                            </tr>
                            <tr>
                                <td>Open Time</td>
                                <td id="td_openTime"></td>
                            </tr>
                            <tr>
                                <td>Volume</td>
                                <td id="td_volume"></td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default"  data-dismiss="modal" value="Close">

                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script type="text/javascript">
            var url = '<?php echo base_url();?>';
            var is_toggle_trade = false;
            var is_toggle_copysetting = false;
            var is_toggle_condition = false;
            var arr_boleans = [];
            var pending_rollovers;
            var commission_per_trade;
            var commission_daily;
            var date_from = "<?php echo date("Y-m-d",strtotime("- 1 month"));?>";
            var date_to = "<?php echo date("Y-m-d");?>";

            var is_trader = '<?= $IsTrader; ?>';
            var trader_table ="";
            if(is_trader == 1){
                var status = 4;
            }else{
                var status = 3;
            }
            if(is_trader == 1 || is_trader == 2){
                $('.subscribed-follower').show();
                $('.subscribed-trader').show();
                $('.edit-my-follower').hide();
                getTraderList(); //if  account is trader
                getFollowerList(); //if  account is trader
                getPastSubscriptionList(); //if  account is trader
            }else{
                getTraderList(); // if  account is follower
                getPastSubscriptionList();
                $('.subscribed-trader').show();
                $('.subscribed-follower').hide();
                $('.edit-my-follower').show();
            }

            $(document).ready(function(){
              //  $('[data-toggle="popover"]').popover();
                var element = '.pop-rollover';
                $(element).popover({});

            $('body').on('click', function (e) {
                        
                //Use each to hide Popovers with the same class
                $(element).each(function(index, elm) {
                            hidePopover(elm, e);
                }); 
             });

            // hide any open popovers when anywhere else in the body is clicked
            var hidePopover = function(element, e){
            if (!$(element).is(e.target) && $(element).has(e.target).length === 0 && $('.popover').has(e.target).length === 0){
                $(element).popover('hide');
            }
            }


                $('.tooltip-help_predelay').tooltip({
                    offset: [10, 2],
                    predelay: 1000
                });


                $('.tooltip-help').tooltip({
                    offset: [10, 2]
                });

                $('.tooltip-help2').tooltip({
                    offset: [10, 2]
                });



                
                $('[data-toggle="tooltip"]').tooltip();

                $('.datetimepicker').datetimepicker({
                    format: 'YYYY/DD/MM'
                });

                $('.dtimpicker-from').datetimepicker({
                    format: 'YYYY-MM-DD',
                    defaultDate: date_from
                });

                $('.dtimpicker-to').datetimepicker({
                    format: 'YYYY-MM-DD',
                    defaultDate: date_to
                });


                pending_rollovers = $(".pending_rollovers").DataTable();

                jQuery("#search_trader").on("keypress keyup blur",function (event) {
                    if (event.which == 13 || event.keyCode == 13) {
                        var searchTrader = $('#search_trader').val();
                        console.log(searchTrader);
                        $.ajax({
                            url: "<?= FXPP::ajax_url('copytrade/getTraderList')?>",
                            method:"POST",
                            dataType: "json",
                            data:{page:	1, search: searchTrader},
                            beforeSend: function(){
                                $('#trader_table tbody').html('<div id ="loading_rec_trader" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                            },
                            success:function(response){
                                $('#trader_table tbody').html(response.htmlView);

                                $("#loading_rec_trader").hide();

                            }
                        });
                    }
                });
              
                jQuery("#search_pastsubs").on("keypress keyup blur",function (event) {
                    if (event.which == 13 || event.keyCode == 13) {
                        var searchPastSubs = $('#search_pastsubs').val();
                        console.log(searchPastSubs);
                        $.ajax({
                            url: "<?= FXPP::ajax_url('copytrade/getPastSubsList')?>",
                            method:"POST",
                            dataType: "json",
                            data:{page:	1,search: searchPastSubs},
                            beforeSend: function(){
                                $('#past_subscription tbody').html('<div id ="loading_rec_subs" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                            },
                            success:function(response){
                                $('#past_subscription tbody').html(response.htmlView);

                                $("#loading_rec_subs").hide();

                            }
                        });
                    }
                });

                jQuery("#search_follower").on("keypress keyup blur",function (event) {
                    if (event.which == 13 || event.keyCode == 13) {
                        var searchFollower = $('#search_follower').val();
                        console.log(searchFollower);
                        $.ajax({
                            url: "<?= FXPP::ajax_url('copytrade/getFollowerList')?>",
                            method:"POST",
                            dataType: "json",
                            data:{page:	1, search: searchFollower},
                            beforeSend: function(){
                                $('#follower_table tbody').html('<div id ="loading_rec_follower" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                            },
                            success:function(response){
                                $('#follower_table tbody').html(response.htmlView);

                                $("#loading_rec_follower").hide();

                            }
                        });
                    }
                });


            });




            function getTraderList(){
                //get Trader of account


                var totalPageTrader = parseInt($('#traderTotalPages').val());
                $('#trader_pagination').simplePaginator({ //pagination js plugin
                    totalPages: totalPageTrader,
                    maxButtonsVisible: 5,
                    currentPage: 1,
                    nextLabel: '<?= lang("dta_tbl_14"); ?>',
					prevLabel: '<?= lang("dta_tbl_15"); ?>',
					firstLabel: '<?= lang("dta_tbl_12"); ?>',
					lastLabel: '<?= lang("dta_tbl_13"); ?>',
                    clickCurrentPage: true,
                    pageChange: function(page) {
                        $.ajax({
                            url: "<?= FXPP::ajax_url('copytrade/getTraderList')?>",
                            method:"POST",
                            dataType: "json",
                            data:{page:	page},
                            beforeSend: function(){
                                $('#trader_table tbody').html('<div id ="loading_rec_trader" style="text-align:center;"><tr><td colspan="6">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                            },
                            success:function(response){
                                $('#trader_table tbody').html(response.htmlView);

                                $("#loading_rec_trader").hide();

                            }
                        });
                    }
                });

                /* $.ajax({
                 type: 'POST',
                 url: url + 'copytrade/getSubscriptionListByType',
                 // data: {per_page:per_page,last_id:0},
                 dataType: 'json',
                 beforeSend: function () {
                 // $('#loader-holder').show();
                 $('#follower_table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="5">Loading records<img src="//=$this->template->Images()?>loading.gif" /></td></tr></div>');

                 },
                 success: function (data) {
                 //copytrade_table.destroy();
                 $('#follower_table tbody').html(data.htmlView);

                 $("#loading_rec").hide();

                 }
                 });*/
            }
            function getFollowerList(){
        
        
                        var totalPageFollower = parseInt($('#followerTotalPages').val());
                        $('#follower_pagination').simplePaginator({ //pagination js plugin
                            totalPages: totalPageFollower,
                            maxButtonsVisible: 5,
                            currentPage: 1,
                            nextLabel: '<?= lang("dta_tbl_14"); ?>',
                            prevLabel: '<?= lang("dta_tbl_15"); ?>',
                            firstLabel: '<?= lang("dta_tbl_12"); ?>',
                            lastLabel: '<?= lang("dta_tbl_13"); ?>',
                            clickCurrentPage: true,
                            pageChange: function(page) {
                                $.ajax({
                                    url: "<?= FXPP::ajax_url('copytrade/getFollowerList')?>",
                                    method:"POST",
                                    dataType: "json",
                                    data:{page:	page},
                                    beforeSend: function(){
                                        $('#follower_table tbody').html('<div id ="loading_rec_follower" style="text-align:center;"><tr><td colspan="6">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
        
                                    },
                                    success:function(response){
                                        $('#follower_table tbody').html(response.htmlView);
        
                                        $("#loading_rec_follower").hide();
        
                                    }
                                });
                            }
                        });
        
              
                    }
            function getPastSubscriptionList(){

                        var totalPageSubs = parseInt($('#subsTotalPages').val());
                        $('#subs_pagination').simplePaginator({ //pagination js plugin
                            totalPages: totalPageSubs,
                            maxButtonsVisible: 5,
                            currentPage: 1,
                            nextLabel: '<?= lang("dta_tbl_14"); ?>',
                            prevLabel: '<?= lang("dta_tbl_15"); ?>',
                            firstLabel: '<?= lang("dta_tbl_12"); ?>',
                            lastLabel: '<?= lang("dta_tbl_13"); ?>',
                            clickCurrentPage: true,
                            pageChange: function(page) {
                                $.ajax({
                                    url: "<?= FXPP::ajax_url('copytrade/getPastSubsList')?>",
                                    method:"POST",
                                    dataType: "json",
                                    data:{page:	page},
                                    beforeSend: function(){
                                        $('#past_subscription tbody').html('<div id ="loading_rec_subs" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                                    },
                                    success:function(response){
                                        $('#past_subscription tbody').html(response.htmlView);

                                        $("#loading_rec_subs").hide();

                                    }
                                });
                            }
                        });


                    }
            function showTicketinfo(ticketId,connectionId){
                var cp_url = 'copytrade/GetTicketInfo';
                console.log('ticket:'+ ticketId);
               $.ajax({
                   type: 'POST',
                   url: url + cp_url,
                       data:{ticket:ticketId,connection:connectionId},
                   beforeSend: function () {
                       $('#loader-holder').show();
                   }
               }).done(function (response) {
                  // console.log(response);
                   $('#loader-holder').hide();
                  // if (response.success) {
                 
                       $('#span_mTicket').html(response.trades.Ticket);
                       $('#td_ticket').html(response.trades.Ticket);
                       $('#td_clsPrice').html(response.trades.ClosePrice);
                       $('#td_cmd').html(response.trades.Cmd);
                       $('#td_openPrice').html(response.trades.OpenPrice);
                       $('#td_profit').html(response.trades.Profit);
                       $('#td_sl').html(response.trades.Sl);
                       $('#td_tp').html(response.trades.Tp);
                       $('#td_symbol').html(response.trades.Symbol);
                       $('#td_clsTime').html(response.trades.CloseTime);
                       $('#td_openTime').html(response.trades.OpenTime);
                       $('#td_volume').html(response.trades.Volume);
                       $('#ticket_modal').modal('show');
                   
                  // }


               });
            }

            function updateSetting(id,trader,follower) {
                proceed = true;
                
                if(id.length === 0){
        
                    $('#m_message').html('Connection Id not found, Please try again later or contact support.');
                    $('#cpy_modal').modal('show');
                    proceed = false;
                    return false;
                }

                $('#copy_settings_values_2_'+ id).css('border','');
                if($('#copy_settings_values_2_'+ id).val().length === 0) {
                    $('#copy_settings_values_2_'+ id).css('border', '2px solid red');
                    proceed = false;
                    return false;
                }

                if(proceed) {
                    var cp_url = 'copytrade/UpdateCopySettings';
                    $.ajax({
                        type: 'POST',
                        url: url + cp_url,
                        data: $('#updatesetting-form-' + id).serialize() + '&trader=' + trader + '&follower=' + follower,
                        beforeSend: function () {
                            $('#loader-holder').show();
                            $('.subscribed').show();
                        }
                    }).done(function (response) {
                        console.log(response);
                        $('#loader-holder').hide();
                        if (response.success) {
                            $('#m_message').html('<?= lang("trd_135"); ?>');
                        } else {
                            $('#m_message').html(response.err_msg);
                        }
                        $('#cpy_modal').modal('show');

                    });
                }

            }
            function toggle_all(id,type){
                if(type == 1) {
                    $('.f_condition_' + id).hide();
                    $('#commission_history_' + id).hide();
                    $('#pending_rollovers_' + id).hide();
                }
                if(type == 2){
                    $('#current_trade_' + id).hide();
                    $('#commission_history_' + id).hide();
                    $('#pending_rollovers_' + id).hide()
                }
                if(type == 3){
                    $('.f_condition_' + id).hide();
                    // $('#current_trade_' + id).hide();
                }
                if(type == 4){
                    $('.f_condition_' + id).hide();
                    $('#current_trade_' + id).hide();
                    $('#pending_rollovers_' + id).hide()
                }
                if(type == 5){
                    $('.f_condition_' + id).hide();
                    $('#current_trade_' + id).hide();
                    $('#commission_history_' + id).hide();
                }

            }
            function SubmitTradesForm(connection,type = 0){
                if(type == 1) { //close time
                    var baseUrl = url + 'copytrade/GetCloseTradesFromConnection';
                    var tableName = 'close_time_'+connection;
                   // $('#open_time_'+connection).parents('div.dataTables_wrapper').first().hide();

                  //  GetTotalRollOverProfit(connection);
                    GetTotalProfit(connection);

                }else { //open time
                    var baseUrl = url + 'copytrade/GetOpenTradesFromConnection';
                    var tableName = 'open_time_'+connection;
                    $('#div-rollover-profit-'+connection).hide();
                   // $('#close_time_'+connection).parents('div.dataTables_wrapper').first().hide();
                }


                $('#'+tableName).DataTable().clear();
                $('#'+tableName).DataTable().destroy();
                jQuery('#'+tableName).on('preXhr.dt', function (e, settings, data) {
                    $('#current_trade_' + connection).show();
                    $('#loader_current_trade_' + connection).hide();
                    //$('#loader_mini_'+ connection).show();
                }).on('xhr.dt', function (e, settings, json, xhr) {
                    //$('#loader_mini_'+ connection).hide();
                    //$('#current_trade_' + connection).hide();
                    $('#loader_current_trade_' + connection).hide();
                    $('#tr-trades-' + connection).val(true);
                }).DataTable({
                    "bJQueryUI": true,
                    "destroy": true,
                    "processing": false,
                    "serverSide": true,
                    "lengthChange": false,
                    "scrollX": true,
                    "autoWidth": false,
                    "searching":   false,
                    "ordering": false,
                    "ajax": {
                        "url": baseUrl,
                        "type": "POST",
                        "data": function (d) {
                            return $.extend( {}, d, {
                                "extra_search": connection
                            } );
                        }
                    }
                });
                
            }
            function SubmitCommissionForm(connection){
                var from = $('#commission_datepicker_from_'+connection).val();
                var to = $('#commission_datepicker_to_'+connection).val();
                var type = $('#commission_time_type_'+connection).val();
                $('#commission_history_'+connection).hide();
                $.ajax({
                    type:'POST',
                    url:url+'copytrade/getHistoryByType',
                    data:{connection:connection,from:from,to:to,type:type},
                    beforeSend:function(){
                        $('#loader_commission_history_'+ connection).show();
                    }
                }).done(function(response){
                    if(response.hist_type == '1'){
                        $('.commission_daily_' + response.connection).show();
                        $('.commission_per_trade_' + response.connection).hide();
                        $('#commission_daily_tbody' + response.connection).html(response.hist_data);
                    }
                    if(response.hist_type == '2'){
                        $('.commission_per_trade_' + response.connection).show();
                        $('.commission_daily_' + response.connection).hide();
                        $('#commission_per_trade_tbody_' + response.connection).html(response.hist_data);
                        $('.commission_per_trade_'+response.connection).DataTable({
                            "bSort": true,
                            "ordering": true,
                            "searching": false,
                            "lengthChange": false,
                            "info": false,
                            "destroy" : true,
                        });
                    }
                    $('#loader_commission_history_' + response.connection).hide();

                });

            }
            function show_terms(account,con_id,follower){
                toggle_all(con_id,3);
                $.ajax({
                    type: 'POST',
                    url: url + 'copytrade/showCommissionSetting',
                    data: {account_number: account,connection:con_id},
                    beforeSend: function () {
                        $('.imgloader').show();
                    }
                }).done(function (response) {
                    is_toggle_copysetting = true;
                    $('.td-show').html('<?= lang("trd_113"); ?>');
                    $.each(response.condition, function (key, value) {
                        $('.' + key).html(value);
                    });

//                    $.each(response.condition_f, function (key, value) {
//                        $('.' + key).html(value);
//                    });

                    $('#acc-num').html(follower);
                    $('.imgloader').hide();
                    $('#trader-modal').modal('show');
                    $('.body-content-con').show()

                });

            }
            function rollover(id,amount){

                if(amount  == 0){
                     var msg1 = 'No pending commission to collect.';

                     $('#m_message').html(msg1);
                     $('#cpy_modal').modal('show');

                }else if(amount < 0.1){

                    var msg1 = '<?= lang("rollover_note_3"); ?>';

                     $('#m_message').html(msg1);
                     $('#cpy_modal').modal('show');

                }else{
                    $('.conf-modal-desc').html('Are you sure you want to proceed?');
                    $('#confirmModal')
                        .modal({ backdrop: 'static', keyboard: false })
                    .on('click', '#confirm', function (e) {

                        if(id > 0){
                            $.ajax({
                            type: 'POST',
                            url: url + 'copytrade/payRollOver',
                            //url: url + 'copytrade/rollover',
                            data: {connection: id},
                            beforeSend: function () {
                                //  $('#loader_mini_' + id).show();
                            }
                        }).done(function (response) {
                            
                            if(response.reqResult == 'RET_OK'){
                                $('.rollover-btn-'+id).css('display','none');
                            }
                            id = ''; // do not remove
                            $('#confirmModal').modal('hide');
                            if(response.success) {
                                
                                $('#m_message').html('<?= lang("rollover_note_4"); ?>');
                                   // $('#m_message').html(response.err_msg);
                               
                            }else{
                                $('#m_message').html(response.err_msg);
                            }
                           
                            $('#cpy_modal').modal('show');
                        });

                        }else{
                            return
                        }

                        
                      //  e.stopImmediatePropagation();

                    });
                } 

            }
            function trades_toggle(connection){
                toggle_all(connection,1);
                if($('#tr-trades-' + connection).val() ==  'true'){
                    $('#tr-trades-' + connection).val(false);
                    $('#current_trade_' + connection).hide();
                }else {

                    var baseUrl = url + 'copytrade/GetOpenTradesFromConnection';
                    var tableName = 'open_time_'+connection;



                    $('#'+tableName).DataTable().clear();
                    $('#'+tableName).DataTable().destroy();
                    jQuery('#'+tableName).on('preXhr.dt', function (e, settings, data) {
                        $('#current_trade_' + connection).show();
                        $('#loader_current_trade_' + connection).hide();
                        //$('#loader_mini_'+ connection).show();
                    }).on('xhr.dt', function (e, settings, json, xhr) {
                        //$('#loader_mini_'+ connection).hide();
                        //$('#current_trade_' + connection).hide();
                        $('#loader_current_trade_' + connection).hide();
                        $('#tr-trades-' + connection).val(true);
                    }).DataTable({
                        "bJQueryUI": true,
                        "destroy": true,
                        "processing": false,
                        "serverSide": true,
                        "lengthChange": false,
                        "scrollX": true,
                        "autoWidth": false,
                        "searching":   false,
                        "ordering": false,
                        "ajax": {
                            "url": baseUrl,
                            "type": "POST",
                            "data": function (d) {
                                return $.extend( {}, d, {
                                    "extra_search": connection
                                } );
                            }
                        }
                    });


                }

            }
            function pendingRollovers(td_id){
                toggle_all(td_id,5);
                if($('#tr-pending-rollovers-' + td_id).val() ==  'true'){
                    $('#tr-pending-rollovers-' + td_id).val(false);
                    $('#pending_rollovers_' + td_id).toggle();
                }else {
                    $.ajax({
                        type: 'POST',
                        url: url + 'copytrade/getHistoryByType',
                        data: {connection: td_id, type:3},
                        beforeSend: function () {
                            $('#loader_pending_rollovers_' + td_id).show();
                        }
                    }).done(function (response) {
                        pending_rollovers.destroy();
                        $('#loader_pending_rollovers_' + response.connection).hide();
                        $('#tr-pending-rollovers-' + response.connection).val(true);

                        $('.pending_rollovers_table_' + response.connection).show();
                        $('#pending_rollovers_tbody_' + response.connection).html(response.hist_data)

                        pending_rollovers = $('.pending_rollovers').DataTable({
                            "bSort": true,
                            "ordering": true
                        });
                        $('#pending_rollovers_' + td_id).toggle();

                    });
                }


            }
            function commission_toggle(td_id,copytermsType){
                toggle_all(td_id,4);
                if($('#tr-commission-' + td_id).val() ==  'true'){
                    $('#tr-commission-' + td_id).val(false);
                    $('#commission_history_' + td_id).toggle();
                }else {
                    var type = copytermsType;
                    $.ajax({
                        type: 'POST',
                        url: url + 'copytrade/getHistoryByType',
                        data: {connection: td_id, from: date_from, to: date_to, type: type},
                        beforeSend: function () {
                            $('#loader_commission_history_' + td_id).show();
                        }
                    }).done(function (response) {
                        $('#loader_commission_history_' + response.connection).hide();
                        $('#tr-commission-' + response.connection).val(true);

                        if(response.hist_type == '1') {
                            //  commission_daily.destroy();
                            $('.commission_daily_' + response.connection).show();
                            $('.commission_per_trade_' + response.connection).hide();
                            $('#commission_daily_tbody_' + response.connection).html(response.hist_data);
//                            commission_daily = $('.commission_daily').DataTable({
//                                "bSort": true,
//                                 "ordering": true,
//                                "searching": false,
//                                "lengthChange": false,
//                                "info": false,
//                            });

                        }
                        if(response.hist_type == '2'){
                            // commission_per_trade.destroy();
                            $('.commission_per_trade_' + response.connection).show();
                            $('.commission_daily_' + response.connection).hide();
                            $('#commission_per_trade_tbody_' + response.connection).html(response.hist_data);
                            $('.commission_per_trade_'+response.connection).DataTable({
                                "bSort": true,
                                "ordering": true,
                                "searching": false,
                                "lengthChange": false,
                                "info": false,
                                "destroy" : true,
                            });
                        }

                        $('#commission_loader_mini_' + response.connection).hide();
                        $('#commission_history_' + response.connection).toggle();
                    });
                }

            }
            
       
            function show_conditions(ConId){
                toggle_all(ConId,2);
                
                 
                if($('#tr-condition-' + ConId).val() ==  'true'){
                    $('#tr-condition-' + ConId).val(false);
                    //$('.f_condition_' + id).toggle();
                    $('.f_condition_' + ConId).hide();
                }else{
                    $.ajax({
                        type:'POST',
                        url:url+'copytrade/show_conditions',
                        data:{connection:ConId,},
                        beforeSend:function(){
                            $('.f_loader_condition_' + ConId).show();

                        }
                    }).done(function(response){
                        $('.f_loader_condition_' + ConId).hide();
                        $('#tr-condition-' + ConId).val(true);
                        $('.f_condition_' + ConId).show();
                        var connection = ConId;
                        
                        // advanced_settings_12052
                        var cpSetting1 = response.copysetting_1;
                        var cpSetting2 = response.copysetting_2;
                        var cpSetting3 = response.copysetting_3;
                        var cpSetting5 = response.copysetting_5;
                        var cpSetting6 = response.copysetting_6;
                        var cpSetting7 = response.copysetting_7;
                        var cpSetting8 = response.copysetting_8;
                        var cpSetting9 = response.copysetting_9;

                        ResetCheckbox();
                        //currency instrument
                        
                        
                                 var copy_settings_values_2= getIdUseName("copy_settings_values_2");                
                                 $('#'+copy_settings_values_2).addClass("copy_settings_values_2_cls");
                                 
                         
                            if(cpSetting3!=""){ 

                                var icopy_settings_values_3= getIdUseName("copy_settings_values_3");
                                $('#'+icopy_settings_values_3+' option[value="'+cpSetting3+'"]').attr("selected", "selected");

                            }

                        
                        
                        if(cpSetting1 == 1){
                            $("#copy_settings_values_1_1_" + ConId).prop("checked", true);
                        }else if(cpSetting1 == 2){
                            $("#copy_settings_values_1_2_" + ConId).prop("checked", true);
                        }else{
                            $("#copy_settings_values_1_3_" + ConId).prop("checked", true);
                            var i;
                            for (i = 0; i < response.currency_code.length; i++) {
                                $("#qoute_" + response.currency_code[i] + "_" +  ConId).prop("checked", true);
                            }

                        }


                        $("#copy_settings_2_default_" + ConId).val(cpSetting2); //ratio

                        $("#copy_settings_values_2_" + ConId).val(cpSetting2); //ratio
                        CalculateRatio(cpSetting2,ConId);


                        if(cpSetting5 == cpSetting6){
                            $("#limited_or_fixed_" + ConId).val(1); // fixed lot
                            LimitOrFixed(1,ConId);
                            SetFixedLot(ConId);
                            $("#fixed_lot_" + ConId).val(cpSetting5);
                        }else{
                            $("#limited_or_fixed_" + ConId).val(0); //lot range
                            LimitOrFixed(0,ConId);
                            //max lot
                            $("#max_lot_open_" + ConId).val(cpSetting5);
                            //min  lot
                            $("#min_lot_open_" + ConId).val(cpSetting6);
                            SetLimit(ConId);
                        }

                        $('#dont_copy_' + ConId).val(cpSetting7);
                        $('#copy_options_' + ConId).val(cpSetting8);
                        $('#copy_inverse_' + ConId).val(cpSetting9);
                        if(cpSetting7 == 1){
                            $('#dont_copy_' + ConId).prop("checked", true);
                        }
                        if(cpSetting8 == 1){
                            $('#copy_options_' + ConId).prop("checked", true);
                        }
                        if(cpSetting9 == 1){
                            $('#copy_inverse_' + ConId).prop("checked", true);
                        }
                        
                        $('#set_view_'+ ConId).html('View settings');
                        $('#advanced_settings_'+ConId).hide();

                        $('#con_id_' + ConId).val(ConId);

                    });

                }

            }
            function reject_account(connection,who,trader,follower){
                // var connection = $(this).attr("data-id");
                $('.conf-modal-desc').html('Are you sure you want to proceed?');
                $('#confirmModal')
                    .modal({ backdrop: 'static', keyboard: false })
                    .on('click', '#confirm', function (e) {
                        $.ajax({
                            type:'POST',
                            url:url+'copytrade/upateFollowerStatus',
                            data: {'connection':connection,'status':3,follower:follower,trade:trader},
                            beforeSend:function(){
                                $('#loader-holder').show();
                            }
                        }).done(function(response){
                            $('#confirmModal').modal('hide');
                            $('#loader-holder').hide();
                            if(response.success) {
                                $('.f_condition_' + response.connection).hide();
                                $('#current_trade_' + response.connection).hide();
                                $('.tr_id_' + response.connection).hide();
                                var total = parseInt($('.total_follower').html());
                                $('.total_follower').html(total - 1);
                                $('.subscribed').hide();
                                $('.no-subs').hide();
                                if(who == 1){
                                    $('#m_message').html('<?= lang("trd_131"); ?>');
                                }else{
                                    $('#m_message').html('<?= lang("trd_132"); ?>');
                                }

                            }else{
                                $('#m_message').html(response.err_msg);
                            }
                            $('#cpy_modal').modal('show');

                        });
                        e.stopImmediatePropagation();

                    });
            }

            function approve_account(connection){

                //  $(document).on("click",".btn_agree",function(){
                //  var connection = $(this).attr("data-id");

                if(connection > 0){
                    $.ajax({
                    type:'POST',
                    url:url+'copytrade/upateFollowerStatus',
                    data: {'connection':connection,'status':2},
                    beforeSend:function(){
                        $('#loader-holder').show();
                    }
                }).done(function(response){
                   
                    $('#loader-holder').hide();
                    if(response.success) {
                        $('.subscribed').show();
                        $('.no-subs').hide();
                        $('#m_message').html('<?= lang("trd_133"); ?>');
                        //change button option

                        $('.btn-f-apv-'+connection).hide();
                        $('.btn-f-can-'+connection).hide();
                        $('.btn-f-uns-'+connection).show();

                        connection = '';

                    }else{
                        $('#m_message').html(response.err_msg);
                    }
                    $('#cpy_modal').modal('show');

                    //  });
                });
                }else{
                    return false;
                }
              

            }

        function unsubscribe_account(connection,status,trader,follower,rollover){

            var url_update = url+'copytrade/unsubscribeAccount'; //status 4 and 5


            if(status == 1){ // cancel subscription request ( no active subscription yet - request is for approval by trader)

                $('.conf-modal-desc').html('Are you sure you want to proceed?');
                $('#confirmModal')
                    .modal({ backdrop: 'static', keyboard: false })
                    .on('click', '#confirm', function (event) {

                        if(connection > 0){
                            $.ajax({
                            type:'POST',
                            url:url+'copytrade/unsubscribeAccount',
                            data: {'connection':connection,'status':1,follower:follower,trader:trader},
                            beforeSend:function(){
                                $('#loader-holder').show();
                            }
                        }).done(function(response){
                            connection = '';
                            $('#confirmModal').modal('hide');
                            $('#loader-holder').hide();
                            if(response.success) {
                                $('.f_condition_' + response.connection).hide();
                                $('#current_trade_' + response.connection).hide();
                                $('.tr_id_' + response.connection).hide();
                                var total = parseInt($('.total_follower').html());
                                $('.total_follower').html(total - 1);
                                // $('.subscribed').hide();
                                // $('.no-subs').show();

                                $('#m_message').html('Subscription request has been cancelled.');


                            }else{
                                $('#m_message').html(response.err_msg);
                            }
                            $('#cpy_modal').modal('show');

                        });
                        }else{
                            return false;
                        }
                    
                    // event.stopImmediatePropagation();
                    // return true;



                    });
                return true;



            }else{ // unsubscribe request either by trader or follower - ( active subscription)
            
                if(connection > 0){
                    $.ajax({
                    type:'POST',
                    url:url+'copytrade/getOpenTradeById',
                    data: {'connection':connection},
                    beforeSend:function(){
                        $('.imgloader').show();
                    }
                }).done(function(response){
                    $('#loader-holder').hide();

                    if(response.rolloverStatus == 'RET_NOT_ENOUGH_FUND'){
                        $('#m_message').html('Followers don&#39;t have enough balance to pay pending commissions.');
                        $('.unsubscribe-one').hide();
                        $('.unsubscribe-two').show();
                        $('.imgloader').hide();
                        $('.trade-desc-two').html('Followers don&#39;t have enough balance to pay pending commissions.');
                        $('#confirm-close-btn').attr('value', 'OK');
                        $('#confirm-unsubscribe-btn').hide();
                    }else{
                        $('.unsubscribe-two').hide();
                    
                        if(status == 5){
                           var rProfit =  (!rollover) ? 0 : rollover;
                        }else{
                           var rProfit = (parseFloat(rollover) > 0) ? rollover : 0;

                        }
0

                        if(status == 5){
                           var rProfit =  (!rollover) ? 0 : rollover;
                        }else{
                           var rProfit = (parseFloat(rollover) > 0) ? rollover : 0;

                        }
                    
                      
                   
                        $('#confirm-close-btn').attr('value', 'Cancel');
                        $('#confirm-unsubscribe-btn').show();
                        $('.unsubscribe-one').show();
                        $('.imgloader').hide();
                        $('#open_trade_unsubs').html(response.open_trade);
                        $('#totalRollOverProfit').html(rProfit);
                    }

                    $('#confirmUnsubscribeModal')
                        .modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#confirm-unsubscribe-btn', function (e) {
                            if(connection > 0){
                            $.ajax({
                                type:'POST',
                                url:url_update,
                                data: {'connection':connection,'status':status,follower:follower,trader:trader},
                                beforeSend:function(){
                                
                                    $('#loader-holder').show();
                                }
                            }).done(function(response){
                                connection = '';
                                $('#loader-holder').hide();
                                $('#confirmUnsubscribeModal').modal('hide');
                                $('.f_condition_' + response.connection).hide();
                                $('#current_trade_' + response.connection).hide();
                                $('.tr_id_' + response.connection).hide();
                                var total = parseInt($('.total_trader').html());
                                $('.total_trader').html(total - 1);

                                if(response.success) {
                                    $('#m_message').html('<?= lang("trd_134"); ?>');
                                }else{
                                    $('#m_message').html(response.err_msg);
                                }
                                $('#cpy_modal').modal('show');

                            });
                            //e.stopImmediatePropagation();

                        }else{
                            return false;
                        }

                        });


                });

            }else{
                return false;
            }
            
         }

            }
                    

        </script>
        <script>
            $(document).ready(function() {
                // ResetSelect();
                // ResetSelectCopy();
                //SetLimit();
                //SetFixedLot();
                //  ShowHideSettings();

//                $('input[name="copy_settings_values_2_part_2"]').bind('keyup input', function(){
//                    var ratio =  $(this).val();
//                    var conId =  $(this).attr('data-cid');
//                    console.log(ratio);
//                    console.log(conId);
//
//                   CalculateRatio(ratio,conId);
//                });

            });
            function CheckDontCopy(connection) {
                $("#dont_copy_" + connection).on('change', function () {
                    if ($(this).is(':checked')) {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }
                });
            }

            function CheckCopyOption(connection) {
                $("#copy_options_" + connection).on('change', function () {
                    if ($(this).is(':checked')) {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }
                });
            }

            function CheckCopyInverse(connection) {
                $("#copy_inverse_" + connection).on('change', function () {
                    if ($(this).is(':checked')) {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }
                });
            }
            function LimitOrFixed(val,connection) {
                if(val == 0) {
                    $('#limited_lots_holder_'+connection).show();
                    $('#fixed_lot_holder_'+connection).hide();
                } else {
                    $('#limited_lots_holder_'+connection).hide();
                    $('#fixed_lot_holder_'+connection).show();
                }
            }
            function SetLimit(connection) {
                $('#min_'+connection).html(jQuery.trim($('#min_lot_open_' + connection + ' option:selected').text()));
                $('#max_'+connection).html(jQuery.trim($('#max_lot_open_' + connection + ' option:selected').text()));
            }

            function SetFixedLot(connection) {$('#fixed_lot_span_'+connection).html(jQuery.trim($('#fixed_lot_'+connection).val()));}
            function ShowHideSettings(connection) {
                
                var connection_ids=getConnectionId('connection_id');
                
                
                if($("#advanced_settings_"+connection_ids).css('display') == 'none')
                {
                    $("#advanced_settings_"+connection_ids).show();
                     $('#set_view_'+connection_ids).html('Hide settings');
                     
                }else{
                    $("#advanced_settings_"+connection_ids).hide();
                     $('#set_view_'+connection_ids).html('View settings');
                }
                
                
//                $('#advanced_settings_'+connection).toggle();
//                if($('#adv_settings_'+connection).is(':checked')) {
//                    $('#set_view_'+connection).html('View settings');
//                } else {
//                    $('#set_view_'+connection).html('Hide settings');
//                }
            }
            function ShowQuotes() {document.getElementById('i-quotes-list').style.display = 'block';}
            function HideQuotes() {document.getElementById('i-quotes-list').style.display = 'none';}
            function CalculateRatio(d,conId){
               // console.log(d,"===========>",conId);
                if(d == 0) d = 0.01;
                if (d > 1000) {
                 //   isInvalidRatio = true;
                    if(d > 1000) {$('#all_text_'+conId).text("Sorry, you have chosen wrong copying ratio. Please change the ratio.");}
                } else {
                    //isInvalidRatio = false;
                    var  lot = (d > 1) ? " lots deal" : " lot deal"
                    $('#all_text_'+conId).text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + d + lot + " copied to your account.");

                }


            }
            function ResetSelect(totalLots = 0,connection = 0,selectType = 1) {
                var a = $('table#copy_setting_table_'+connection).find('select#copy_settings_values_2_part_2_'+connection).val();
                var b = $('table#copy_setting_table_'+connection).find('select#copy_settings_values_2_part_1_'+connection).val();
//                var a = document.getElementById('icopy_settings_values_2_part_2').value;
//                var b = document.getElementById('icopy_settings_values_2_part_1').value;
                //console.log(a);
                // console.log(b);
                var c = a/b;

                var d = c;
                // var d = c * 100;
                //  var d = Math.round(c*100)/100;
                // console.log(d);
                if(d == 0) d = 0.01;
                if(totalLots > 0){
                    $('table#copy_setting_table_'+connection).find('#icopy_settings_values_2_total_'+connection).val(totalLots);
                }else{
                    $('table#copy_setting_table_'+connection).find('#icopy_settings_values_2_total_'+connection).val(d);
                }

                //$('#icopy_settings_values_2_total').val(d);
                $('table#copy_setting_table_'+connection).find('#copier_'+connection).text(d);
                // $('#copier').text(d);
                var lot = " lot deal";

                if (d > 1000) {
                    if(d > 1000) {
                        $('table#copy_setting_table_'+connection).find('#text_'+connection).val("Sorry, you have chosen wrong copying ratio. Please change the ratio");
                        //$('#all_text').text("Sorry, you have chosen wrong copying ratio. Please change the ratio");
                    }
                } else {
                    if(d < 1)
                    {lot = " lot deal"}
                    else if(d == 1) {lot = " lot deal"}
                    else if(d == 2) {lot = " lot deal"}
                    else if(d == 3) {lot = " lot deal"}
                    else if(d == 4) {lot = " lot deal"}
                    else if(d == 5) {lot = " lots deal"}
                    else if(d == 6) {lot = " lots deal"}
                    else if(d == 7) {lot = " lots deal"}
                    else if(d == 8) {lot = " lots deal"}
                    else if(d == 9) {lot = " lots deal"}
                    else if(d == 10) {lot = " lots deal"}
                    else if(d > 10) {lot = " lots deal"}
                    var copy_word = " copied to your account";
                    if(d == 1) {copy_word = " copied to your account"}
                    if(selectType == 2){
                        var opt = $('#add_opt_'+connection).val();
                        var optVal = $('#add_opt_value_'+connection).val();
                        if(opt == 1){
                            // $('#copy_settings_values_2_part_2_'+ connection + 'option[value="' + optVal +'"]').remove();
                            $('#copy_settings_values_2_part_2_'+connection).find('option:last').remove();
                        }
                    }

                    if(totalLots > 0){
                        totalLots = parseFloat(totalLots).toFixed(2);
                        $('table#copy_setting_table_'+connection).find('#copy_settings_values_2_part_1_'+connection).val(1);
                     
                        var exists = false;
                        var selectID = "select#copy_settings_values_2_part_2_" + connection;
                        $(selectID + ' option').each(function(){
                            if (this.value == totalLots) {
                                exists = true;

                            }
                        });
                        if(!exists){
                           // totalLots = parseFloat(totalLots).toFixed(2);
                            $('#add_opt_'+connection).val(1);
                            $('#add_opt_value_'+connection).val(totalLots);
                            $('select#copy_settings_values_2_part_2_'+connection).append('<option value="'+totalLots+'" selected="selected">'+ totalLots + ' lot deal </option>');
                        }else{
                            $('#add_opt_'+connection).val(2);
                            $('select#copy_settings_values_2_part_2_'+connection).val(totalLots)
                        }
                       

                      //  $('table#copy_setting_table_'+connection).find('select#copy_settings_values_2_part_2_'+connection).val(totalLots)

                        $('table#copy_setting_table_'+connection).find('#all_text_'+connection).text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + totalLots + lot + copy_word );

                    }else{
                        $('table#copy_setting_table_'+connection).find('#all_text_'+connection).text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + parseFloat(d).toFixed(3) + lot + copy_word);

                        //$('#all_text').text("If a trader opens a " + '1' + " " + " lot deal" + ", you will get a " + parseFloat(d).toFixed(3) + lot + copy_word  );

                    }
                }
            }

            function ResetSelectCopy(connection)
            {
                var xy = document.getElementById('copy_settings_values_3_'+connection).value;
                var xd = Math.round(xy % 10);
                if(xd == 1) {xc = " deal"}
                else if(xd == 2) {xc = " deals"}
                else if(xd == 3) {xc = " deals"}
                else if(xd == 4) {xc = " deals"}
                else if(xd == 5) {xc = " deals"}
                else if(xd == 6) {xc = " deals"}
                else if(xd == 7) {xc = " deals"}
                else if(xd == 8) {xc = " deals"}
                else if(xd == 9) {xc = " deals"}
                else if(xd == 0 & xy != 0) {xc = " deals"}
                else if(xy == 0) {xc = " all deals"}

                if(xy != 0) {
                    $('#traider_copy_deals_'+connection).text(xy + xc);
                }
                else
                {
                    $('#traider_copy_deals_'+connection).text(xc);
                }
            }

            function ResetCheckbox(connection) {
                $("table#i-quotes-list_" + connection + " .check_quotes").removeAttr("checked");
                $("table#i-quotes-list_" + connection + " .check_quotes").prop("checked", false);
            }
            function CheckedReset(connection) {
                $("#copy_settings_values_1_3_"+connection).attr("checked","checked");
                $("#copy_settings_values_1_3_" + connection).prop("checked", true);
            }

            function GetTotalRollOverProfit(connection_id){
                $.ajax({
                    type:'POST',
                    url:url+'copytrade/GetRollOverProfit/'+connection_id,
                    data:{connection:connection_id},
                    beforeSend:function(){
                        $('#div-rollover-profit-'+connection_id).show();
                    }
                }).done(function(response){
                    $("#total-rollover-profit-"+connection_id).html(response.rollOver);
                });

            }
            function GetTotalProfit(connection_id){
                $.ajax({
                    type:'POST',
                    url:url+'copytrade/GetTotalProfit',
                    data:{connection:connection_id,type:1},
                    beforeSend:function(){
                        $('#div-total-profit-'+connection_id).show();
                    }
                }).done(function(response){
                    $("#total-profit-"+connection_id).html(response.totalProfit);
                });

            }




function getIdUseName(nameattributes){
   var c_three_data = document.getElementsByName(nameattributes);
     var number_of_trade_id=c_three_data[0].attributes.id.nodeValue;
    number_of_trade_id=number_of_trade_id.replaceAll(/\s/g,'')

return number_of_trade_id;                          
    
} 


function getConnectionId(nameattributes){
   var c_three_data = document.getElementsByName(nameattributes);   
return c_three_data[0].attributes.value.nodeValue;
}  
 
 $(document).on("blur",".copy_settings_values_2_cls",function(){
    
    // Can be entered value less than 0.1, more than 1000 - they are saved
  var val_amt=$(this).val();
  val_amt=parseFloat(val_amt);
  var def_min=0.1;
  var def_max=1000;
  if(val_amt<parseFloat(def_min))
  {
      $(this).val(def_min);
      
  }
  else if(val_amt>parseFloat(def_max))
  {
      $(this).val(def_max); 
  }
  
    var val_amt=$(this).val();
  val_amt=parseFloat(val_amt);
  
  setTimeout(CalculateRatio(val_amt,getConnectionId('connection_id')), 1000);

    
 });
</script>

