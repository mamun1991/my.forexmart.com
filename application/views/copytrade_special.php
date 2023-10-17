<?php
//    $this->load->view('copytrader_nav.php');
?>

<div class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">
        <h1 class="">Copy Trade</h1>
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li role="presentation"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" id="active-tab"><i class="fa fa-line-chart"></i> Copied </a></li>
                <li><a href="<?=FXPP::my_url('my-copytraders-monitoring/'. $masterAcc)?>" id="active-tab4"><i class="fa fa-bar-chart"></i>Monitoring</a></li>
            </ul><div class="clearfix"></div>
        </div>
        <div class="tab-content acct-cont">
            <div role="tabpanel" class="row tab-pane active" id="tab1">
                <div class="col-lg-12">
                    <div class="chart-container">
                        <a href="#" class="btn-ribbon"><img src="<?= $this->template->Images()?>ribbon-for-account-01.png"><span class="ribbon-number">01</span><span class="ribbon-label"><?php echo $masterAcc ?></span></a>
                        <h3>Account Balance</h3>
                        <h3 class="bal1"></h3>
                        <div id="samplegraph1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- add -->
</div>
</div>
<div class="row">
    <div class="col-lg-12 border-bottom-line">
    </div>
</div>

<?php echo $this->load->ext_view('modal', 'preloader', '', TRUE); ?>


<script type="text/javascript">

    var pblc = [];
    var prvt = [];
    var site_url = "<?= FXPP::ajax_url() ?>";
    generatechart();
    function generatechart() {



        $('#loader-holder').show();
        var account = <?php echo $masterAcc ?>;
        var isAffiliate = <?php echo $isAffilate ?>;
        prvt["data"] = {
            isAffiliate: isAffiliate,
            account:  account,
        };
        console.log(prvt["data"]);

        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'CopyTrade/getTradeHistorySpecial/',
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {
            $('#loader-holder').hide();
            console.log(data);

            if (data.Balance != 'null') {
                var JsonBalance1 = JSON.parse(data.Balance);
                $.each(JsonBalance1, function (key, value) {
//                    JsonBalance[key].x= new Date (JsonBalance[key].x);
                    JsonBalance1[key].x = (JsonBalance1[key].x);
                });
            }
            $(".bal1").html(data.Current_Balance);
            $(".eqt1").html(data.Current_Equity);


            if (data.Balance != 'null') {
                chartcanvas(JsonBalance1);
            } else {
                chartcanvas(
                    [
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0}
                    ]
                    ,
                    [
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0}
                    ]
                    , [
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0},
                        {x: dfltdate, y: 0}
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


    }
    var x = 180; //.15 9sec .1 6sec
    var interval = 1000 * 60 * x; // where X is your every X minutes
    setInterval(generatechart, interval);


    function chartcanvas(balance) {

        var chart = new CanvasJS.Chart("samplegraph1",
            {

                exportEnabled: true,
                zoomEnabled: true,
                zoomType: "xy",
                theme: "theme2",//theme1
                title: {
                    text: ''
                },
                animationEnabled: true,
                animationDuration: 2000,
                axisY: {

                    includeZero: false,


                },
                axisX: {
                    labelFormatter: function (e) {
                        return CanvasJS.formatDate(e.value, "DD MMM");
                    },

                    valueFormatString: "DD-MMM",
                    labelAutoFit: false,
                },
                data: [
                    {
                        xValueType: "dateTime",
                        name: "<?=lang('cpy_bal')?>",
                        type: "area",
                        color: "rgba(0,75,141,0.7)",
                        lineThickness: 3,
                        showInLegend: true,
                        dataPoints: balance,
                        markerType: "square",
                        legendText: "<?=lang('cpy_bal')?>"
                    },
                ],
                legend: {
                    cursor: "pointer",
//                verticalAlign: "center",
//                horizontalAlign: "left",
                    itemclick: function (e) {
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
    setInterval(generatechart, interval);
</script>
<script>
    $(document).ready(function() {


        $("#charts").owlCarousel({
            autoPlay: false, //Set AutoPlay to 3 seconds
            items : 1,
            lazyLoad : true,
            navigation : false
        });
    });
</script>
