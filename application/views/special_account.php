<style>
    input.datepick {
        text-align: center;
    }
    .canvasjs-chart-credit {
        display: none;
    }
    .monitoring-chart {
        width: 100%!important;
    }
    .fm-accnt-chart-holder{
        width:100%;
        overflow:hidden;
    }
    .parent_chartContainer{
        display:block;
        overflow:auto;
    }
    .chart-apply {
        padding: 7px 10px;
        border: none;
        background: #29a643;
        color: #fff;
        width: 100%;
        font-size: 14px;
        font-family: Open Sans;
        margin-top: 15px;
        transition: all ease 0.3s;
        max-width:250px;
    }

    .btn-link-fm {
        padding: 10px;
    }

    .chart-reset {
        padding: 7px 10px;
        border: none;
        background: #aaa;
        color: #fff;
        font-size: 14px;
        font-family: Open Sans;
        width: 100%;
        margin-top: 15px;
        transition: all ease 0.3s;
        max-width:250px;
    }
    .but-monitor{
        text-align: center;
    }
</style>
<?php
    $this->load->view('copytrader_nav.php');
?>

<?php echo $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<section class="fm-page-sec-wrapper">
    <div class="">
        <?php if(!empty($error)){ ?>
            <br/>
            <br/>
            <div class="alert alert-danger center">
            <?= $error;?>
            </div>
        <?php }else{ ?>
            <input type="hidden" name="trader" id="trader" value="<?= isset($account_number)? $account_number :'' ;?>" >
            <div class="fm-page-title-desc-holder">
                <h2><?= lang('cpy_mtr') ?> <?= $account_number; ?></h2>
                <p class="fm-page-desc">

                </p>
            </div>
            <hr>
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <ul class="fm-accnt-details">
                        <li><i class="fa fa-user"></i><p>Broker: <strong>ForexMart</strong></p></li>
                        <li class="fm-text-seperator">|</li>
                        <li><p><?= lang('cpy_acc') ?> <strong><?= $account_number; ?></strong></p></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="chart-control-holder">
                        <div class="chart-control">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group fg">
                                        <label ><?= lang('cpy_frm') ?>:</label>
                                        <input id="date_start" name="date_start" type="text" class="datepick form-control round-0"  placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group fg">
                                        <label ><?= lang('cpy_to') ?>:</label>
                                        <input id="date_end" name="date_end" type="text" class="datepick form-control round-0"  placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-control">
                            <div class="row">
                                <div class="col-md-6 but-monitor">
                                    <button class="Reset chart-reset"><?= lang('cpy_rst') ?></button>
                                </div>
                                <div class="col-md-6 but-monitor">
                                    <button class="Apply chart-apply"><?= lang('cpy_apy') ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fm-accnt-chart-holder">
                        <div class="parent_chartContainer"><div id="chartContainer" style="height: 700px; max-width: 1090px; min-width:767px; margin: 25px 20px;"></div></div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="fm-accnt-tbl-title"><?= lang('cpy_op_trd') ?></h4>
                    <div class="fm-accnt-table table-responsive">
                        <table id="OpenTrades" name="OpenTrades" class="table table-bordered trades-table">
                            <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Type</th>
                                <th>Volume</th>
                                <th>Symbol</th>
                                <th>Open Price</th>
                                <th>SL</th>
                                <th>TP</th>
                                <th>Close Price</th>
                                <th>Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($service){ ?>
                                <?= $Opened; ?>
                            <tr class="total">
                                <td colspan="8"><?= lang('cpy_sum_loss') ?></td>
                                <td><?= $OpenTotal ?></td>
                            </tr>
                                <?php }else{ ?>
                            <tr >
                                <td  colspan="9" align="right">
                                    <?= lang('cpy_srvs_un') ?>
                                </td>
                            </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="col-md-12">
                <h4 class="fm-accnt-tbl-title"><?= lang('cpy_cl_trd') ?></h4>
                <div class="fm-accnt-table table-responsive">
                    <table id="ClosedTrades" name="ClosedTrades"  class="table table-bordered trades-table">
                        <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Type</th>
                            <th>Volume</th>
                            <th>Symbol</th>
                            <th>Open Price</th>
                            <th>SL</th>
                            <th>TP</th>
                            <th>Close Price</th>
                            <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if($service){ ?>
                            <?= $Closed; ?>
                        <tr class="total">
                            <td colspan="8" align="right"><?= lang('cpy_sum_loss') ?></td>
                            <td id="closedtotal"><?= $ClosedTotal ?></td>
                        </tr>
                            <?php }else{ ?>
                        <tr >
                            <td  colspan="9" align="right">
                                <?= lang('cpy_srvs_un') ?>
                            </td>
                        </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        </div>			
    </div>    		
</section>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <?= lang('cpy_sub_mtr') ?></h4>
            </div>
            <div class="modal-body">
               <?php echo $msg ?>
                <p id="m_message">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cpy_sub_cls') ?></button>
            </div>
        </div>

    </div>
</div>



<?= $DemoAndLiveLinks; ?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<script type='text/javascript'>
    $(document).ready(function(){
        var margin = '<?php echo $Margin ;?>';
        var equity = '<?php echo $Equity ;?>';
        var balance = '<?php echo $Balance ;?>';
        if(margin!='') {
            var JsonMargin = JSON.parse(margin);
            $.each(JsonMargin, function (key, value) {
//                JsonMargin[key].x = new Date((JsonMargin[key].x));
                JsonMargin[key].x = ((JsonMargin[key].x));
            });
        }
        if(equity!='') {
            var JsonEquity= JSON.parse(equity);
            $.each(JsonEquity, function(key,value) {
//                JsonEquity[key].x= new Date ((JsonEquity[key].x));
                JsonEquity[key].x=  ((JsonEquity[key].x));
            });
        }
        if(balance!='') {
            var JsonBalance= JSON.parse(balance);
            $.each(JsonBalance, function(key,value) {
//                JsonBalance[key].x= new Date ( (JsonBalance[key].x));
                JsonBalance[key].x= ( (JsonBalance[key].x));
            });
        }

        if(margin!=''){
            chartcanvas(JsonBalance,JsonEquity,JsonMargin);
        }else{
            chartcanvas(
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,[
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
            );
        }

    });
</script>

<script type='text/javascript'>

function getLastWeek(){
    var today = new Date();
    var lastWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7);
    return lastWeek ;
}
var lastWeek = getLastWeek();
var lastWeekMonth = lastWeek.getMonth() + 1;
var lastWeekDay = lastWeek.getDate();
var lastWeekYear = lastWeek.getFullYear();

//var lastWeekDisplay = lastWeekMonth + "/" + lastWeekDay + "/" + lastWeekYear;
var lastWeek = ("0000" + lastWeekYear .toString()).slice(-4) + "/" + ("00" + lastWeekDay .toString()).slice(-2)+ "/" + ("00" + lastWeekMonth.toString()).slice(-2) ;



var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '/' +
    (day<10 ? '0' : '') + day + '/'+
    (month<10 ? '0' : '') + month;

var frmtdt = output.split("/");
var dfltdate= new Date(frmtdt[0]+'-'+frmtdt[2]+'-'+frmtdt[1]);

$("#date_start").val(lastWeek);
$("#date_end").val(output);


$("#date_start").datetimepicker({
    format: "YYYY/DD/MM",
    daysOfWeekDisabled: [0, 6],
    disabledDates: []
});
$("#date_end").datetimepicker({
    format: "YYYY/DD/MM",
    daysOfWeekDisabled: [0, 6],
    disabledDates: []
});

$("#date_start").val(lastWeek);


var pblc = [];
var prvt = [];
var site_url="<?=FXPP::ajax_url()?>";
var log_url="<?php echo FXPP::my_url('client/signin');?>";
pblc['request']=null;

$(document).on("click", ".Apply", function () {
    $('#loader-holder').show();

    prvt["data"] = {
        from: $('input[name=date_start]').val(),
        to:  $('input[name=date_end]').val(),
        trader:  $('input[name=trader]').val()
    };
    pblc['request'] = $.ajax({
        dataType: 'json',
        url: site_url + 'query/getTradeHistory',
        method: 'POST',
        data: prvt["data"]
    });

    pblc['request'].done(function( data ) {
        $('#loader-holder').hide();
        $('#ClosedTrades').DataTable().destroy();
        $('tbody#closed').html('');

        $('#ClosedTrades tbody').html(data.Closed);
        $('#ClosedTrades tbody tr:last').after(data.ClosedTotal);
        if(data.Closed){

        }else{
            $('#ClosedTrades tbody').html(data.ClosedTotal);
        }

        $('#ClosedTrades').DataTable({
            responsive: true,
            "dom": 'tp'
        });


        if (data.Margin!='null'){
            var JsonMargin= JSON.parse(data.Margin);
            $.each(JsonMargin, function(key,value) {
//                    JsonMargin[key].x= new Date (JsonMargin[key].x);
                JsonMargin[key].x=  (JsonMargin[key].x);
            });
        }
        if (data.Equity!='null'){
            var JsonEquity= JSON.parse(data.Equity);
            $.each(JsonEquity, function(key,value) {
//                    JsonEquity[key].x= new Date (JsonEquity[key].x);
                JsonEquity[key].x=  (JsonEquity[key].x);
            });
        }
        if (data.Balance!='null'){
            var JsonBalance= JSON.parse(data.Balance);
            $.each(JsonBalance, function(key,value) {
//                    JsonBalance[key].x= new Date (JsonBalance[key].x);
                JsonBalance[key].x= (JsonBalance[key].x);
            });
        }

        if(data.Margin!='null'){
            chartcanvas(JsonBalance,JsonEquity,JsonMargin);
        }else{
            chartcanvas(
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,[
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
            );

        }

    });

    pblc['request'].fail(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

    pblc['request'].always(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

});

$(document).on("click", ".Reset", function () {

    $('#loader-holder').show();

    prvt["data"] = {
        from: lastWeek,
        to:  output,
        trader:  $('input[name=trader]').val()
    };
    pblc['request'] = $.ajax({
        dataType: 'json',
        url: site_url + 'query/getTradeHistory',
        method: 'POST',
        data: prvt["data"]
    });

    pblc['request'].done(function( data ) {
        $('#loader-holder').hide();
        $('#ClosedTrades').DataTable().destroy();
        $('tbody#closed').html('');

        $('#ClosedTrades tbody').html(data.Closed);
        $('#ClosedTrades tbody tr:last').after(data.ClosedTotal);
        if(data.Closed){

        }else{
            $('#ClosedTrades tbody').html(data.ClosedTotal);
        }

        $('#ClosedTrades').DataTable({
            responsive: true,
            "dom": 'tp'
        });


        if (data.Margin!='null'){
            var JsonMargin= JSON.parse(data.Margin);
            $.each(JsonMargin, function(key,value) {
                JsonMargin[key].x=  (JsonMargin[key].x);
            });
        }
        if (data.Equity!='null'){
            var JsonEquity= JSON.parse(data.Equity);
            $.each(JsonEquity, function(key,value) {
                JsonEquity[key].x=  (JsonEquity[key].x);
            });
        }
        if (data.Balance!='null'){
            var JsonBalance= JSON.parse(data.Balance);
            $.each(JsonBalance, function(key,value) {
                JsonBalance[key].x= (JsonBalance[key].x);
            });
        }

        if(data.Margin!='null'){
            chartcanvas(JsonBalance,JsonEquity,JsonMargin);
        }else{
            chartcanvas(
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,
                [
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
                ,[
                    { x: dfltdate, y: 0 },
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0},
                    { x: dfltdate, y: 0}
                ]
            );

        }

    });

    pblc['request'].fail(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

    pblc['request'].always(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

});

$(document).on("click", ".sub-unsub", function () {
    
    $('#loader-holder').show();

    prvt["data"] = {     
        masteraccount:'<?php echo $account_number; ?>',
        request:  $.trim($("#copy").html()) // pass copy or unsubscribe in language
    };
    pblc['request'] = $.ajax({
        dataType: 'json',
        url: site_url + 'query/sub_unsubaccount',
        method: 'POST',
        data: prvt["data"]
    });

    pblc['request'].done(function( data ) {
        if (data.err==true){
            $('#m_message').html('<?=lang('cpy_mon_msg2')?>');
        }else if (data.err2==true){
            $('#m_message').html('<p><?=lang('cpy_mon_msg1')?><a href="'+log_url+'" target="_blank"><?=lang('cpy_mon_lnk')?></a></p>');
        }else{
            if(data.is_copy==0){
                $('#m_message').html('<?=lang('cpy_mon_accnum')?>  <strong>'+data.account_number+'</strong> <?=lang('cpy_mon_msg3')?> <strong>'+data.masteraccount+'</strong>') ;
                $("#copy").html('<?=lang('cpy_mon_box_but1')?>');
            }else if(data.is_copy==1){
                $('#m_message').html('<?=lang('cpy_mon_accnum')?> <strong>'+data.account_number+'</strong> <?=lang('cpy_mon_subs')?> <strong>'+data.masteraccount+'</strong>') ;
                $("#copy").html('<?=lang('cpy_mon_box_but3')?>');
            }else if(data.is_copy == 2){
                $('#m_message').html('<?=lang('cpy_mon_msg5')?>');

            }
        }
        $('#myModal').modal('show');

        $('#loader-holder').hide();
    });

    pblc['request'].fail(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

    pblc['request'].always(function( jqXHR, textStatus ) {
        $('#loader-holder').hide();
    });

});


$('.table').DataTable({
    responsive: true,
    "dom": 'tp'
});



    function chartcanvas(balance,equity,margin){
        var chart = new CanvasJS.Chart("chartContainer",
            {

                exportEnabled: true,
                zoomEnabled: true,
                zoomType: "xy",
                theme: "theme2",//theme1
                title:{
                    text: ''
                },
                animationEnabled: true,
                animationDuration: 2000,
                axisY:{
                    includeZero: false,

                },
                axisX:{
                    valueFormatString: "DD-MMM",
                    labelAutoFit: false,

                },
                data: [
                    {
                        xValueType: "dateTime",
                        name: "<?=lang('cpy_bal')?>",
                        type: "area",
                        lineThickness:3,
                        showInLegend: true,
                        dataPoints:balance,
                        markerType: "square",
                         legendText: "<?=lang('cpy_bal')?>"
                    },
                    {
                        xValueType: "dateTime",
                        name: "<?=lang('cpy_eqty')?>",
                        lineThickness:3,
                        showInLegend: true,
                        type: "line",
                        dataPoints:equity,
                        legendText: "<?=lang('cpy_eqty')?>",
                        markerType: "cross"

                    }
                    <!--                ,-->
                    <!--                {-->
                    <!--                    visible: false,-->
                    <!--                    xValueType: "dateTime",-->
                    <!--                    name: "--><?php //echo lang('cpy_mgn')?><!--",-->
                    <!--                    lineThickness:3,-->
                    <!--                    showInLegend: true,-->
                    <!--                    type: "line",-->
                    <!--                    dataPoints:margin,-->
                    <!--                    markerType: "circle",-->
                    <!--                    legendText: "--><?//=lang('cpy_mgn')?><!--"-->
                    <!---->
                    <!--                }-->
                ],
                legend: {
                    cursor:"pointer",
//                verticalAlign: "center",
//                horizontalAlign: "left",
                    itemclick : function(e) {
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        }
                        else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }
                }
            });

        chart.render();
    }




var x = 60; //.15 9sec .1 6sec
var interval = 1000 * 60 * x; // where X is your every X minutes
setInterval($('.Apply').trigger('click'), interval);

</script>
