
<div role="tabpanel" class="tab-pane active" id="tab3">
    <div class="row">
        <div class="col-md-12 rebate-child-container">
            <div class="date-statistics">
                <label><?= lang('from'); ?></label>
                <div id="sandbox-container" class="rebate-datepicker">
                    <input id="from" type="text" type="text" class="form-control" value="<?=date('d/m/Y',strtotime('-1 month'))?>"/>
                </div>
            </div>
            <div class="date-statistics">
                <label><?= lang('to'); ?></label>
                <div id="sandbox-container" class="rebate-datepicker">
                    <input id="to" type="text" type="text" class="form-control" value="<?=date('d/m/Y')?>"/>
                </div>
            </div>
            <a class="rebate-showbutton"><button id="show" class="btn-login">Show</button></a>
        </div>
        <div class="col-sm-12 rebate-child-container">

            <div class="rebate-system-checkbox">
                <!-- <input type="checkbox"/>
                 <p>Include trades details checkbox</p>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-centered">
            <div class="graph-holder" id="container">
                <p>Cashback Statistics</p>
            </div>
        </div>
    </div>
</div>
<?php if (FXPP::html_url() == 'sa') { ?>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } else { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } ?>

<script>
    var base_url = "<?=FXPP::ajax_url();?>";

    $(document).on("click","#show",function(){
        $("#loader-holder").show();
        var account_number = $("#account_number").val();
        var to = $("#to").val();
        var from = $("#from").val();

        ajaxView(account_number,to,from);


    })

    function ajaxView(account_number,to,from){
        $.post(base_url+"cashback/statisticsData",{account_number:account_number,to:to,from:from},function(data){
            console.log(data);
            viewGrap(data);
            $("#loader-holder").hide();
        })
    }

    $(function () {

        ajaxView("239789","<?=date('Y-m-d h:i:s')?>","<?=date('Y-m-d h:i:s',strtotime('-1 month'))?>");
        //  viewGrap(dates);


    });


    function viewGrap(datas){
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Cashback Statistics'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Cashback amount'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>Cashback</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
            },

            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },

            series: [{
                name: 'Cashback Statistics',
                data: eval(datas)
            } ]
        });
    }
</script>