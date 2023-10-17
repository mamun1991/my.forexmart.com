<?php
//    $this->load->view('copytrader_nav.php');
?>

<div class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">
        <h1 class="">Copy Trade</h1>
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li role="presentation"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" id="active-tab"><i class="fa fa-line-chart"></i> Project 1</a></li>
                <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" id="active-tab2"><i class="fa fa-bar-chart"></i> Project 2</a></li>
                <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" id="active-tab3"><i class="fa fa-bar-chart"></i> Project 3</a></li>
                <li><a href="<?=FXPP::my_url('Sub_monitoring/special_account/' . 258739)?>" id="active-tab4"><i class="fa fa-bar-chart"></i>Monitoring</a></li>
            </ul><div class="clearfix"></div>
        </div>
        <div class="tab-content acct-cont">
            <div role="tabpanel" class="row tab-pane active" id="tab1">
                <div class="col-lg-12">
                    <div class="chart-container">
                        <a href="#" class="btn-ribbon"><img src="<?= $this->template->Images()?>ribbon-for-account-01.png"><span class="ribbon-number">01</span><span class="ribbon-label">Account Title</span></a>
                        <h3 class="bal1">Account Balance</h3>
                        <div id="samplegraph1"></div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="row tab-pane " id="tab2">
                <div class="col-lg-12">
                    <div class="chart-container">
                        <a href="#" class="btn-ribbon"><img src="<?= $this->template->Images()?>ribbon-for-account-02.png"><span class="ribbon-number">02</span><span class="ribbon-label">Account Title</span></a>
                        <h3 class="bal1">Account Balance</h3>
                        <div id="samplegraph2"></div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="row tab-pane " id="tab3">
                <div class="col-lg-12">
                    <div class="chart-container">
                        <a href="#" class="btn-ribbon"><img src="<?= $this->template->Images()?>ribbon-for-account-03.png"><span class="ribbon-number">03</span><span class="ribbon-label">Account Title</span></a>
                        <h3 class="bal1">Account Balance</h3>
                        <div id="samplegraph3"></div>
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
            var log_url = "<?php echo FXPP::my_url('client/signin'); ?>";

//        window.onload = function () {

//
//        var chart = new CanvasJS.Chart("samplegraph2", {
//        theme: "theme2",//theme1
//        // title:{
//        //     text: "Basic Column Chart - CanvasJS"
//        // },
//        animationEnabled: false,   // change to true
//        data: [
//        {
//        // Change type to "bar", "area", "spline", "pie",etc.
//        type: "bar",
//        dataPoints: [
//        { label: "apple",  y: 10  },
//        { label: "orange", y: 15  },
//        { label: "banana", y: 25  },
//        { label: "mango",  y: 30  },
//        { label: "grape",  y: 28  }
//        ]
//        }
//        ]
//        });
//        chart.render();
//
//        var chart = new CanvasJS.Chart("samplegraph3", {
//        theme: "theme2",//theme1
//        // title:{
//        //     text: "Basic Column Chart - CanvasJS"
//        // },
//        animationEnabled: false,   // change to true
//        data: [
//        {
//        // Change type to "bar", "area", "spline", "pie",etc.
//        type: "spline",
//        dataPoints: [
//        { label: "apple",  y: 10  },
//        { label: "orange", y: 15  },
//        { label: "banana", y: 25  },
//        { label: "mango",  y: 30  },
//        { label: "grape",  y: 28  }
//        ]
//        }
//        ]
//        });
//        chart.render();
//        }


        generatechart();
        function generatechart() {

//        pblc['request'] = $.ajax({
//            dataType: 'json',
//            url: site_url + "query/live_accountmonitoring",
//            method: 'POST',
//            data: prvt["data"]
//        });
//
//        pblc['request'].done(function (data) {
//            Chart1.series[0].remove(true);
//            Chart2.series[0].remove(true);
//            Chart3.series[0].remove(true);
//            var dataset = [];
//
//            $.each(data.Balance1, function (k, v) {
//                dataset.push([moment(v.x).valueOf(), v.y]);
//            });
//
//            Chart1.addSeries({
//                name: 'Balance',
//                data: dataset
//            });
//
//            var dataset2 = [];
//            $.each(data.Balance2, function (k, v) {
//                dataset2.push([moment(v.x).valueOf(), v.y]);
//            });
//            Chart2.addSeries({
//                name: 'Balance',
//                data: dataset2
//            });
//
//            var dataset3 = [];
//            $.each(data.Balance3, function (k, v) {
//                dataset3.push([moment(v.x).valueOf(), v.y]);
//            });
//            Chart3.addSeries({
//                name: 'Balance',
//                data: dataset3
//            });
//
//            $(".bal1").html(data.Current_Balance1);
//            $(".bal2").html(data.Current_Balance2);
//            $(".bal3").html(data.Current_Balance3);
//
//            $(".eqt1").html(data.Current_Equity1);
//            $(".eqt2").html(data.Current_Equity2);
//            $(".eqt3").html(data.Current_Equity3);
//
//        });
//        pblc['request'].fail(function (jqXHR, textStatus) {
//
//        });
//
//        pblc['request'].always(function (jqXHR, textStatus) {
//        });


            $('#loader-holder').show();

            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url + 'CopyTrade/getTradeHistory2',
                method: 'POST',
            });

            pblc['request'].done(function( data ) {
                $('#loader-holder').hide();
                console.log(data);

                if (data.Balance1 != 'null') {
                    var JsonBalance1 = JSON.parse(data.Balance1);
                    $.each(JsonBalance1, function (key, value) {
//                    JsonBalance[key].x= new Date (JsonBalance[key].x);
                        JsonBalance1[key].x = (JsonBalance1[key].x);
                    });
                }
                if (data.Balance2 != 'null') {
                    var JsonBalance2 = JSON.parse(data.Balance2);
                    $.each(JsonBalance2, function (key, value) {
//                    JsonBalance[key].x= new Date (JsonBalance[key].x);
                        JsonBalance2[key].x = (JsonBalance2[key].x);
                    });
                }
                if (data.Balance3 != 'null') {
                    var JsonBalance3 = JSON.parse(data.Balance3);
                    $.each(JsonBalance3, function (key, value) {
//                    JsonBalance[key].x= new Date (JsonBalance[key].x);
                        JsonBalance3[key].x = (JsonBalance3[key].x);
                    });
                }


                $(".bal1").html(data.Current_Balance1);
                $(".bal2").html(data.Current_Balance2);
                $(".bal3").html(data.Current_Balance3);
                $(".eqt1").html(data.Current_Equity1);
                $(".eqt2").html(data.Current_Equity2);
                $(".eqt3").html(data.Current_Equity3);


                if (data.Balance1 != 'null' || data.Balance2 != 'null' || data.Balance3 != 'null') {
                    chartcanvas(JsonBalance1);
                    chartcanvas2(JsonBalance2);
                    chartcanvas3(JsonBalance3);
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


                    chartcanvas2(
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


                    chartcanvas3(
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


//            var chart = new CanvasJS.Chart("samplegraph1", {
//                theme: "theme2",//theme1
//                // title:{
//                //     text: "Basic Column Chart - CanvasJS"
//                // },
//                animationEnabled: false,   // change to true
//
//                        // Change type to "bar", "area", "spline", "pie",etc.
//                        type: "area",
//                        data: [
//                        {
//                            xValueType: "dateTime",
//                            name: "<?//=lang('cpy_bal')?>//",
//                            type: "area",
//                            color: "rgba(0,75,141,0.7)",
//                            lineThickness: 3,
//                            showInLegend: true,
//                            dataPoints: balance,
//                            markerType: "square",
//                            legendText: "<?//=lang('cpy_bal')?>//"
//                        },
//                    ],
//
//
//            });
//            chart.render();




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




        function chartcanvas2(balance){
            var chart2 = new CanvasJS.Chart("samplegraph2",
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
                        labelFontSize: 16,
                        includeZero: false,

                        tickColor: "DarkSlateBlue" ,
                        tickThickness: 2,

                        gridColor: "lightblue" ,
                        gridThickness: 2

                    },
                    axisX:{
                        labelFormatter: function (e) {
                            return CanvasJS.formatDate( e.value, "DD MMM");
                        },
                        labelFontSize: 16,
                        valueFormatString: "DD-MMM" ,
                        tickColor: "red",
                        tickThickness: 2,

                        gridColor: "lightblue" ,
                        gridThickness: 2,

                        interlacedColor: "#F0F8FF",
                        labelAutoFit: false,
                        tickLength: 2

                    },
                    data: [
                        {
                            xValueType: "dateTime",
                            name: "<?=lang('cpy_bal')?>",
                            type: "area",
                            color: "rgba(0,75,141,0.7)",
                            lineThickness:3,
                            showInLegend: true,
                            dataPoints:balance,
                            markerType: "square",
                            legendText: "<?=lang('cpy_bal')?>"
                        },
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
                            chart2.render();
                        }
                    }
                });

            chart2.render();
        }

        function chartcanvas3(balance){
            var chart3 = new CanvasJS.Chart("samplegraph3",
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
                        labelFontSize: 16,
                        includeZero: false,

                        tickColor: "DarkSlateBlue" ,
                        tickThickness: 2,

                        gridColor: "lightblue" ,
                        gridThickness: 2

                    },
                    axisX:{
                        labelFormatter: function (e) {
                            return CanvasJS.formatDate( e.value, "DD MMM");
                        },
                        labelFontSize: 16,
                        valueFormatString: "DD-MMM" ,
                        tickColor: "red",
                        tickThickness: 2,

                        gridColor: "lightblue" ,
                        gridThickness: 2,

                        interlacedColor: "#F0F8FF",
                        labelAutoFit: false,
                        tickLength: 2

                    },
                    data: [
                        {
                            xValueType: "dateTime",
                            name: "<?=lang('cpy_bal')?>",
                            type: "area",
                            color: "rgba(0,75,141,0.7)",
                            lineThickness:3,
                            showInLegend: true,
                            dataPoints:balance,
                            markerType: "square",
                            legendText: "<?=lang('cpy_bal')?>"
                        },
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
                            chart3.render();
                        }
                    }
                });

            chart3.render();

        }


        var x = 60; //.15 9sec .1 6sec
        var interval = 1000 * 60 * x; // where X is your every X minutes
        setInterval(generatechart, interval);

            $("#active-tab").click(function(){
                $("#tab1").addClass("active");
                $("#tab2").removeClass("active");
                $("#tab2").removeClass("active");
                generatechart();
            });
            $("#active-tab2").click(function(){
                $("#tab2").addClass("active");
                $("#tab1").removeClass("active");
                $("#tab3").removeClass("active");
                generatechart();
            });
            $("#active-tab3").click(function(){
                $("#tab3").addClass("active");
                $("#tab2").removeClass("active");
                $("#tab1").removeClass("active");
                generatechart();
            });


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
