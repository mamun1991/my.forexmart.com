
<style>
input.datepick {
    text-align: center;
    }
    .canvasjs-chart-credit {
    display: none;vertical-align: 
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
    .Apply{
        margin-top: 24px;
    }
</style>

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
        <input type="hidden" name="trader" id="trader" value="<?= isset($master_account)? $master_account :'' ;?>" >
        <div class="fm-page-title-desc-holder">
            <h2><?= lang('cpy_mtr') ?> <span id="active-account-number"></span></h2>

            <p class="fm-page-desc">

            </p>
        </div>
        <hr>
        <div class="panel panel-default ">
            <div class="panel-heading">
                <ul class="fm-accnt-details">
                    <li><i class="fa fa-user"></i><p>Broker: <strong>ForexMart</strong></p></li>
                    <li class="fm-text-seperator">|</li>
                    <li><p><?= lang('cpy_acc') ?> <strong><span id="active-account-number2"><?= isset($master_account)? $master_account :'' ;?></span></strong></p></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="chart-control-holder">
                    <div class="chart-control">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Followers:</label>
                                        <select class="form-control round-0" name="master_account" id="master_account">
                                            <?php foreach($followers as  $value) { ?>
                                                <option value="<?=$value ?>"><?= $value ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-4'>
                                <div class="form-group">
                                    <label ><?= lang('cpy_frm') ?>:</label>
                                    <div class='input-group' id='dtimpicker-from'>
                                        <input type='text' class="form-control" name = "inp-dtimpicker-from" id="inp-dtimpicker-from"/>
                                        <span class="input-group-addon" id="sp-dtimpicker-from"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <div class="form-group">
                                    <label ><?= lang('cpy_to') ?>:</label>
                                    <div class='input-group' id='dtimpicker-to'>
                                        <input type='text' class="form-control" name = "inp-dtimpicker-to" id="inp-dtimpicker-to"/>
                                        <span class="input-group-addon" id="sp-dtimpicker-to"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <button type="button" class="btn btn-primary btnapply Apply" id="btn-apply">Apply</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <?= $Opened; ?>
                            <tr class="total">
                                <td colspan="8"><?= lang('cpy_sum_loss') ?></td>
                                <td><?= $OpenTotal ?></td>
                            </tr>
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
                            <?= $Closed; ?>
                            <tr class="total">
                                <td colspan="8" align="right"><?= lang('cpy_sum_loss') ?></td>
                                <td id="closedtotal"><?= $ClosedTotal ?></td>
                            </tr>
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

    var pblc = [];
    var prvt = [];

//    function getLastWeek(){
//        var today = new Date();
//        var lastWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7);
//        return lastWeek ;
//    }
//    var lastWeek = getLastWeek();
//    var lastWeekMonth = lastWeek.getMonth() + 1;
//    var lastWeekDay = lastWeek.getDate();
//    var lastWeekYear = lastWeek.getFullYear();
//
//    //var lastWeekDisplay = lastWeekMonth + "/" + lastWeekDay + "/" + lastWeekYear;
//    var lastWeek = ("0000" + lastWeekYear .toString()).slice(-4) + "/" + ("00" + lastWeekDay .toString()).slice(-2)+ "/" + ("00" + lastWeekMonth.toString()).slice(-2) ;
//
//
//
//    var d = new Date();
//    var month = d.getMonth()+1;
//    var day = d.getDate();
//
//    var output = d.getFullYear() + '/' +
//        (day<10 ? '0' : '') + day + '/'+
//        (month<10 ? '0' : '') + month;
//
//    var frmtdt = output.split("/");
//    var dfltdate= new Date(frmtdt[0]+'-'+frmtdt[2]+'-'+frmtdt[1]);
//
//    $("#inp-dtimpicker-from").val(lastWeek);
//    $("#inp-dtimpicker-to").val(output);
//
//
//    $("#inp-dtimpicker-from").datetimepicker({
//        format: "YYYY/DD/MM",
//        daysOfWeekDisabled: [0, 6],
//        disabledDates: []
//    });
//    $("#inp-dtimpicker-to").datetimepicker({
//        format: "YYYY/DD/MM",
//        daysOfWeekDisabled: [0, 6],
//        disabledDates: []
//    });
//
//    $("#date_start").val(lastWeek);

        <?php ?>
        var date_from = "<?php echo date("Y-m-d",strtotime("- 1 month"));?>";
        var date_to = "<?php echo date("Y-m-d");?>";
        <?php ?>

        $('#inp-dtimpicker-from').click(function(){
            $('span#sp-dtimpicker-from').click();
        });

        $('#inp-dtimpicker-to').click(function(){
            $('span#sp-dtimpicker-to').click();
        });

        $('#dtimpicker-from').datetimepicker({
            format: 'YYYY/DD/MM',
            defaultDate: date_from
        });

        $('#dtimpicker-to').datetimepicker({
            format: 'YYYY/DD/MM',
            defaultDate: date_to
        });

        $("#dtimpicker-from").on("dp.change", function (e) {
            $('#dtimpicker-to').data("DateTimePicker").minDate(e.date);
        });

        $("#dtimpicker-to").on("dp.change", function (ev) {
            $('#dtimpicker-from').data("DateTimePicker").maxDate(ev.date);
        });



    var site_url="<?=FXPP::ajax_url()?>";
    var log_url="<?php echo FXPP::my_url('client/signin');?>";
    pblc['request']=null;

    $(document).on("click", ".Apply", function () {
        $('#loader-holder').show();
        var account = $('#master_account').val();
        prvt["data"] = {
            from: $('input[name=inp-dtimpicker-from]').val(),
            to:  $('input[name=inp-dtimpicker-to]').val(),
            trader:  $('#master_account').val()
        };
        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'query/getTradeHistory',
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

            $('#active-account-number').html(account);
            $('#active-account-number2').html(account);
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
        console.log(prvt["data"]);
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
