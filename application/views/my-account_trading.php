<?php $this->lang->load('datatable');?>
<h1><?=lang('myatrdg-00');?></h1>
<?php $this->load->view('account_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="row tab-pane active" id="tab5">
<!--        <div class="col-md-12">-->
<!--            <p class="cur-trades-text">-->
<!--                --><?//=lang('myatrdg-01');?>
<!--                Short description of functionality. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.-->
            </p>
<!--            <div class="chart-holder">-->
<!--                <div id="container" style="min-width: 310px; height: 600px; margin: 0 auto"></div>-->
<!--            </div>-->
<!--        </div>-->
        <style type="text/css">
            .trademargin{margin-bottom: 15px;}
            #tkprofit{margin-top: 16px;}

            @media (min-width: 992px) and (max-width: 1081px) {
                #tkprofit{
                    margin-top: 11px !important;
                }                
            }
        </style>
        <div class="col-md-12 frm-opendeal-title trademargin">
            <h3 class="">
                <?=lang('myatrdg-03');?>
<!--                Open a Deal-->
            </h3>
        </div>
        <div class="col-md-6">
            <div class="frm-opendeal-holder">
                <div class="frm-opendeal">
                    <form>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 m-top">
                                <label>
                                    <?=lang('myatrdg-04');?>:
<!--                                    Symbol:-->
                                </label>
<!--                                --><?php //echo form_dropdown('symbol', $select,'#AA','class="form-control round-0" ');?>


                                <select name="symbol" id="symbol" class="form-control round-0">
                                  <?=$selopt?>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 m-top">
                                <label>
                                    <?=lang('myatrdg-06');?>:
<!--                                    Volume:-->
                                </label>
                                <input id="t_volume" type="text" class="form-control round-0" name="volume" value="0.01" min="0.01"/>
                            </div>
                            <div class="col-md-6 col-sm-6 m-top">
                                <label>
                                    <?=lang('myatrdg-07');?>:
<!--                                    Stop Loss:-->
                                </label>
                                <input id="t_stoploss" type="text" class="form-control round-0" name="stoploss" value="0.00000" />
                            </div>

                            <div class="col-md-6 col-sm-6 m-top">
                                <label>
                                    <?=lang('myatrdg-08');?>:
<!--                                    Take Profit:-->
                                </label>
                                <input id="t_takeprofit" type="text" class="form-control round-0" name="takeprofit" value="0.00000">
                            </div>

                            <div class="col-md-12 col-sm-12 m-top">
                                <label>
                                    <?=lang('myatrdg-09');?>:
<!--                                    Comment:-->
                                </label>
                                <textarea  id="t_comment" name="t_comment"    rows="2" class="form-control round-0"></textarea>
                            </div>
                            <div class="col-md-12 col-sm-12 m-top">
                                <label>
                                    <?=lang('myatrdg-10');?>:
<!--                                    Type:-->
                                </label>
                                <select class="form-control round-0" id="order-type" name="order-type">
                                    <option value="1">
                                        <?=lang('myatrdg-11');?>
<!--                                        Market Execution-->
                                    </option>
                                    <option value="2">
                                        <?=lang('myatrdg-12');?>
<!--                                        Pending Order-->
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="order-type-holder">
                <div class="market-execution-type type-active">
                    <h3>
                        <?=lang('myatrdg-13');?>
<!--                        Market Execution-->
                    </h3>
                    <p><span name="sell">1.5538<small>1</small></span> / <span name="buy">1.5540<small>9</small></span></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                                if(date("D") == 'Sun'){
                                    ?>
                                    <button class="btn-market-sell" id="t_sell_sun" name="t_sell_sun">
                                        <?=lang('myatrdg-14');?>
                                        <!--                                Sell by Market-->
                                    </button>
                                    <?php
                                }
                                else{
                                    ?>
                                    <button class="btn-market-sell" id="t_sell" name="t_sell">
                                        <?=lang('myatrdg-14');?>
                                        <!--                                Sell by Market-->
                                    </button>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                                if(date("D") == 'Sun'){
                                    ?>
                                    <button class="btn-market-buy btn-market-buy2" id="t_buy_sun" name="t_buy">
                                        <?=lang('myatrdg-15');?>
                                        <!--                                Buy by Market-->
                                    </button>
                                    <?php
                                }
                                else{
                                    ?>
                                    <button class="btn-market-buy btn-market-buy2" id="t_buy" name="t_buy">
                                        <?=lang('myatrdg-15');?>
                                        <!--                                Buy by Market-->
                                    </button>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="pending-order-type">
                    <h3>
                        <?=lang('myatrdg-16');?>
<!--                        Pending Order-->

                        <label class="lbl-po-bs">
                            Sell / Buy :
                            <span class="spn-po-sl" name="posell"> </span>
                            /
                            <span class="spn-po-by" name="pobuy">  </span>
                        </label>
                    </h3>
                    <div class="row">
                        <div class="col-sm-6 m-top" id="tkprofit">
                            <label>
                                <?=lang('myatrdg-17');?>:
<!--                                Take Profit:-->
                            </label>
                            <select class="form-control round-0 pe-or-1" name="RequestType" id="RequestType">
                                <option value="BUY_LIMIT">
                                    <?=lang('myatrdg-18');?>
                                </option>
                                <option value="SELL_LIMIT">
                                    <?=lang('myatrdg-18-1');?>
                                </option>
                                <option value="BUY_STOP">
                                    <?=lang('myatrdg-18-2');?>
                                </option>
                                <option value="SELL_STOP">
                                    <?=lang('myatrdg-18-3');?>
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6 m-top">
                            <label>
                                <?=lang('myatrdg-19');?>:
<!--                                at price:-->
                            </label>
                            <input type="text" class="form-control round-0 pe-or-2" name="OpenPrice"/>
                        </div>
                        <div class="col-sm-6 m-top">
                            <label>
                                <?=lang('myatrdg-20');?>:
<!--                                Expiry:-->
                            </label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="expiration" value="<?php echo DateTime::createFromFormat('m-d-Y',  date('m-d-Y',strtotime("+1 week")))->format('m-d-Y'); ?>"/><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-6 m-top">
                            <label></label>
                            <button class="btn-market-buy btn-pend-place t_place" id="t_place" name="t_place">
                                <?=lang('myatrdg-21');?>
<!--                                Place-->
                            </button>
                        </div>
                        <div class="col-sm-12">
                            <p class="pend-note">
                                <?=lang('myatrdg-22');?>
<!--                                Open price you set must differ from market price by at least 3 pips.-->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="cur-trades-tab">
                <ul>
                    <li>
                        <a id="curtab1" href="#cur1" aria-controls="cur" role="tab" data-toggle="tab" class="cu-active ctrades">
                            <?= lang('curtra_01');?>
<!--                            Current Trades-->
                        </a></li>
                    <li><a id="pendtab1" href="#pend1" aria-controls="pend" role="tab" data-toggle="tab"  class=" potrades">
                            <?= lang('curtra_02');?>
<!--                            Pending Others-->
                        </a>
                    </li>
                </ul>
            </div><div class="clearfix"></div>
            <div class="tab-content cur-tab-cont">
                <div role="tabpanel" class="tab-pane table-responsive active" id="cur1">
                    <table id="CurrentTrades"  class="table table-striped tab-my-acct">
                        <thead>
                        <tr>
                            <th>
                                <?=lang('curtra_04');?>
                            </th>
                            <th>
                                <?=lang('curtra_05');?>
                            </th>
                            <th>
                                <?=lang('curtra_06');?>
                            </th>
                            <th>
                                <?=lang('curtra_07');?>
                            </th>
                            <th>
                                <?=lang('curtra_08');?>
                            </th>
                            <th>
                                <?=lang('curtra_09');?>
                            </th>
                            <th>
                                <?=lang('curtra_10');?>
                            </th>
                            <th>
                                <?=lang('curtra_11');?>
                            </th>
                            <th>
                                <?=lang('curtra_12');?>
                            </th>
                            <th>
                                <?=lang('curtra_13');?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?= $currenttrades?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane table-responsive" id="pend1">
                    <table  id="PendingOrderTrades"  class="table table-striped tab-my-acct">
                        <thead>
                        <tr>
                            <th><?=lang('curtra_04')?></th>
                            <th><?=lang('curtra_05')?></th>
                            <th><?=lang('curtra_06')?></th>
                            <th><?=lang('curtra_07')?></th>
                            <th><?=lang('curtra_08')?></th>
                            <th><?=lang('curtra_09')?></th>
                            <th><?=lang('curtra_10')?></th>
                            <th><?=lang('curtra_11')?></th>
                            <th><?=lang('curtra_12')?></th>
                            <th><?=lang('curtra_13')?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?= $pendingorder?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $carousel; ?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<style type="text/css">/*  Wed, 13 Apr 2016 07:51:09 +0000 */.chart-holder{min-height:250px;border:1px solid #ddd;width:100%;padding:10px;box-sizing:border-box}.btnmanage-leverage-holder a{padding:9px 20px;display:inline-block;background:#eee;color:#333}.btnmanage-leverage-holder a:hover{background:#c0c0c0;text-decoration:none}.btnmanage-leverage-holder a i{color:#2988ca}.manage-leverage-cont p{color:#333;font-family:Open sans;font-size:14px;font-weight:600;margin-top:20px}.manage-leverage-tab thead tr th,.anti-fraud-tab thead tr th{background:#bbb;color:#fff;border-bottom:none}.up-file-text span{color:#ff0000}.center-int-tab thead tr th,.anti-fraud-tab thead tr th{background:#bbb;color:#fff;border-bottom:none;text-align:center}.center-int-tab tbody tr td{text-align:center}.center-int-tab tbody tr td a{margin-right:10px}footer{background:#fbfafa}.saldo-tab tbody tr td:last-child{text-align:right}.frm-opendeal-holder{width:100%}.frm-opendeal-title h3{font-size:17px;font-family:Georgia;border-bottom:1px solid #ddd;padding-bottom:10px}.m-top{margin-top:10px}.market-execution-type,.pending-order-type{display:none;padding:10px;border:1px solid #ddd;margin-top:33px}.market-execution-type h3,.pending-order-type h3{font-size:17px;font-family:Georgia;margin:0!important}.type-active{display:block!important}.market-execution-type p{text-align:center;margin-top:15px;font-size:35px;font-family:Open Sans;margin-bottom:15px}.market-execution-type p span small{font-size:20px}.btn-market-sell{font-family:Open Sans;font-size:14px;padding:7px;border:1px solid #ff0000;background:#fff;color:#ff0000;width:100%;transition:all ease .3s;margin-bottom:5px}.btn-market-sell:hover{background:#ff0000;color:#fff;transition:all ease .3s}.btn-market-buy{font-family:Open Sans;font-size:14px;padding:7px;border:1px solid #2988ca;background:#fff;color:#2988ca;width:100%;margin-bottom:5px}.btn-market-buy:hover{background:#2988ca;color:#fff;transition:all ease .3s}.btn-pend-place{margin-top:3px}.pend-note{margin-top:10px;font-family:Open Sans;font-size:13px}/*   bootstrap touch spin css*/  .bootstrap-touchspin .input-group-btn-vertical{position:relative;white-space:nowrap;width:1%;vertical-align:middle;display:table-cell}.bootstrap-touchspin .input-group-btn-vertical > .btn{display:block;float:none;width:100%;max-width:100%;padding:8px 10px;margin-left:-1px;position:relative}.bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-up{border-radius:0;border-top-right-radius:4px}.bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-down{margin-top:-2px;border-radius:0;border-bottom-right-radius:4px}.bootstrap-touchspin .input-group-btn-vertical i{position:absolute;top:3px;left:5px;font-size:9px;font-weight:normal}/*   bootstrap touch spin css*/
    .select2-container{
        width:100%;
        height: auto;

    }
    .select2-container .select2-choice{
        border-radius: 0px!important;
        height: 32px!important;
    }
    .select2-container ,.select2-choice  ,.select2-arrow{
        border-radius: 0px!important;
    }
    .select2-drop-active{
        border-width: medium 2px 2px!important;
    }
    /*custom*/
    .pe-or-1{
        margin: 4px 0px;
    }
    .pe-or-2{
        margin: 5px 0px;
    }
    .lbl-po-bs{
        font-weight: normal; font-family: sans; float: right;
    }
    .spn-po-sl{
        color: green; font-weight: bold;
    }
    .spn-po-by{
        color: red; font-weight: bold;
    }
    .cu-active{
        background: #C0C0C0 !important;
    }

    /*custom*/


</style>
<script type="text/javascript">
    $().ready(function(){
        $('select[name=symbol]').select2({});
        $('select[name=order-type]').select2({});
        $('select[name=RequestType]').select2({});
    });
    var pblc = [];
    pblc['request'] = null;
    if(pblc['request'] != null) pblc['request'].abort();
    var site_url="<?=FXPP::ajax_url('')?>";
    $("input[name='volume']").TouchSpin({

        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus',
        min:.01,
        max: 1000,
        step:.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        booster:true

    });
    $("input[name='stoploss']").TouchSpin({
        initval:0.00000,
        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus',
        min: 0,
        max: 1000,
        step:.01,
        decimals: 2,
        boostat: 2,
        maxboostedstep: 10,
        booster:true
    });
    $("input[name='takeprofit']").TouchSpin({
        initval:0.00000,
        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus',
        min: 0,
        max: 1000,
        step:.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        booster:true
    });

    $(document).ready(function(){
        $("#active-tab").focus();
        $('#order-type').change(function() {
            if($(this).val() == 1) {
                $('.market-execution-type').addClass('type-active');
                $('.pending-order-type').removeClass('type-active');
            }
            else if ($(this).val() == 2) {
                $('.pending-order-type').addClass('type-active');
                $('.market-execution-type').removeClass('type-active');
            }
        });
    });
    $(document).on("click", ".t_place", function () {
        $('#loader-holder').show();
        $('#pendingStat').modal('hide');
        var prvt = [];
        prvt["data"] = {
            Comment     :  $("textarea[name='t_comment']").val(),
            RequestType : $("select[name='RequestType']").val(),
            StopLoss    : $("input[name='stoploss']").val(),
            Symbol      : $("select[name='symbol']").val(),
            TakeProfit  : $("input[name='takeprofit']").val(),
            Volume      : $("input[name='volume']").val(),
            Expiration  : $("input[name='expiration']").val(),
            OpenPrice  : $("input[name='OpenPrice']").val(),
        };
        pblc['request'] = $.ajax({

            dataType: 'json',
            url: site_url+"query/trading_open_pending_order",
            method: 'POST',
            data: prvt["data"]

        });
        pblc['request'].done(function( data ) {
            $('#loader-holder').hide();
            $('#s_report').html(data.request);
            $('#avreport').modal('show');
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });
    });
    $(document).ready(function(){
        var xhr;

        var ajax_call = function() {
            if(typeof xhr != 'undefined'){
                xhr.abort();
            }

            var selectedsymbol=$('select#symbol').val();
            console.log(selectedsymbol);

            pblc['request'] = xhr =   $.ajax({
                dataType: 'json',
                url: site_url + 'query/trading_symbols',
                method: 'POST',
            });

            pblc['request'].done(function( data ) {

                $('select[name=symbol]').select2('destroy');
                $('select#symbol').empty().append(data.selopt);
                $('select#symbol').val(selectedsymbol);
                var ask =$('select#symbol').find(':selected').data('ask').toString();
                var bid =$('select#symbol').find(':selected').data('bid').toString();
                $('span[name=sell]').html(bid);
                $('span[name=buy]').html(ask);

                $('span[name=posell]').html(bid);
                $('span[name=pobuy]').html(ask);
                var maximumdecimal = Math.max(countDecimals(bid), countDecimals(ask));
                $("input[name='stoploss']").trigger("touchspin.updatesettings", {   decimals: maximumdecimal});
                $("input[name='takeprofit']").trigger("touchspin.updatesettings", {   decimals: maximumdecimal});

                $('select[name=symbol]').select2();

            });
            
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });
        };


        var interval = 10000; // milllseconds
        setInterval(ajax_call, interval);


        var ask =$('select#symbol').find(':selected').data('ask').toString();
        var bid =$('select#symbol').find(':selected').data('bid').toString();
        $('span[name=sell]').html(bid);
        $('span[name=buy]').html(ask);
        $('span[name=posell]').html(bid);
        $('span[name=pobuy]').html(ask);

        $('select#symbol').on('change', function() {
            var ask =$('select#symbol').find(':selected').data('ask').toString();
            var bid =$('select#symbol').find(':selected').data('bid').toString();

            $('span[name=sell]').html(bid);
            $('span[name=buy]').html(ask);
            $('span[name=posell]').html(bid);
            $('span[name=pobuy]').html(ask);
            var maximumdecimal = Math.max(countDecimals(bid), countDecimals(ask));

            var step =(1/Math.pow(10, maximumdecimal));

            $("input[name='stoploss']").trigger("touchspin.updatesettings", {   decimals: maximumdecimal,step:step,});
            $("input[name='takeprofit']").trigger("touchspin.updatesettings", {   decimals: maximumdecimal,step:step,});

        });

        $(function () {
            $('.input-group.date').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: true,
                language: "<?= FXPP::html_url() ?>",
                calendarWeeks: true,
                autoclose: true,
                format: 'mm-dd-yyyy',
                orientation: "bottom auto"
            });
        });
    });
    var countDecimals = function (value) {
        if(Math.floor(value) === value) return 0;
        return value.toString().split(".")[1].length || 0;
    }

    $(document).on("click","#t_sell_sun", function(){
        $('#avreport_sun').modal('show');
    });

    $(document).on("click", "#t_sell", function () {
        $('#loader-holder').show();
        $('#pendingStat').modal('hide');
        var prvt = [];
        prvt["data"] = {
            ClosePrice  : 0,
            Comment     :  $("textarea[name='t_comment']").val(),
            OpenPrice  : $('span[name=sell]').html(),
            RequestType : 'Sell',
            StopLoss    : $("input[name='stoploss']").val(),
            Symbol      : $("select[name='symbol']").val(),
            TakeProfit  : $("input[name='takeprofit']").val(),
            Volume      : $("input[name='volume']").val()
        };
        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url+"query/trading_open_market_execution",
            method: 'POST',
            data: prvt["data"]

        });
        pblc['request'].done(function( data ) {
            $('#loader-holder').hide();
            $('#s_report').html(data.request);
            $('#avreport').modal('show');
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });
    });

    $(document).on("click","#t_buy_sun", function(){
        $('#avreport_sun').modal('show');
    });

    $(document).on("click", "#t_buy", function () {
        $('#loader-holder').show();
        $('#pendingStat').modal('hide');
        var prvt = [];
        prvt["data"] = {
            ClosePrice  : 0,
            Comment     :  $("textarea[name='t_comment']").val(),
            OpenPrice  : $('span[name=buy]').html(),
            RequestType : 'Buy',
            StopLoss    : $("input[name='stoploss']").val(),
            Symbol      : $("select[name='symbol']").val(),
            TakeProfit  : $("input[name='takeprofit']").val(),
            Volume      : $("input[name='volume']").val()
        };
        pblc['request'] = $.ajax({

            dataType: 'json',
            url: site_url+"query/trading_open_market_execution",
            method: 'POST',
            data: prvt["data"]

        });
        pblc['request'].done(function( data ) {
            $('#loader-holder').hide();
            $('#s_report').html(data.request);
            $('#avreport').modal('show');
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('#CurrentTrades').DataTable({
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>',
                    "last":      '<?=lang('dta_tbl_13')?>',
                    "next":      '<?=lang('dta_tbl_14')?>',
                    "previous":   '<?=lang('dta_tbl_15')?>'
                },
            }
        });
    });
    $(window).resize(function () {
        $(".sorting").width("");
        $(".CurrentTrades").width("100%");
        $("#CurrentTrades").width("100%");
        $(".dataTables_scrollHeadInner").width("100%");
    });
</script>

<style type="text/css">
    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }
    #CurrentTrades > thead > tr > th:lang(jp) {
        white-space: nowrap;
    }
</style>

<script type="text/javascript">
    $(function() {
        $('#PendingOrderTrades').DataTable({
            responsive: true,
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>:',
                    "last":      '<?=lang('dta_tbl_13')?>:',
                    "next":      '<?=lang('dta_tbl_14')?>',
                    "previous":   '<?=lang('dta_tbl_15')?>'
                },
            }
        });
    });
    $(window).resize(function() {
        $('#PendingOrderTrades').DataTable({
            language: {
                emptyTable:'<?=lang('dta_tbl_01')?>',
                infoEmpty:'<?=lang('dta_tbl_03')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                search: '<?=lang('dta_tbl_10')?>:',
                "paginate": {
                    "first":     '<?=lang('dta_tbl_12')?>:',
                    "last":      '<?=lang('dta_tbl_13')?>:',
                    "next":      '<?=lang('dta_tbl_14')?>',
                    "previous":   '<?=lang('dta_tbl_15')?>'
                },
            }
        });
    });
    $(window).resize(function () {
        $(".sorting").width("");
        $(".PendingOrderTrades").width("100%");
        $("#PendingOrderTrades").width("100%");
        $(".dataTables_scrollHeadInner").width("100%");
    });

    $('body').on('click','.ctrades',function(e){
        if($("#curtab1").hasClass('cu-active')){

        }else{
            $("#curtab1").addClass('cu-active');
        }
        $("#pendtab1").removeClass('cu-active');
    });

    $('body').on('click','.potrades',function(e){
        if($("#pendtab1").hasClass('cu-active')){

        }else{
            $("#pendtab1").addClass('cu-active');
        }
        $("#curtab1").removeClass('cu-active');
    });
</script>

<?= $this->load->ext_view('modal', 'av_report', '', TRUE); ?>
