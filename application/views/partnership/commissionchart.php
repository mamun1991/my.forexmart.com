<?php  $this->lang->load('datatable');?>
<?php include_once('partnership_nav.php') ?>

<style type="text/css">
    .part-table td { text-align: center; }
    .center-data{  text-align: center;  }
     @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0){
        .btnapply{
            float: right;
        }
     }
     @media screen and (max-width: 335px) and (-webkit-min-device-pixel-ratio:0){
        .nav-pills li{
            width: 100%;
        }
     }
     @media screen and (max-width: 463px)and (min-width: 344px) and (-webkit-min-device-pixel-ratio:0){
        .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 32.5%!important;
        }
     }
      @media screen and (max-width: 343px) and (-webkit-min-device-pixel-ratio:0){
         .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 100%!important;
        }
     }
</style>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="commission">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text arabic-part-text">
                    <?=lang('com_00');?>
                </p>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <p style="margin-top: 5px;" class="">
                    <b> <?=lang('com_10');?> <span id="totalCommission"><?php echo $getCommissionData['totalCommission'];?></span></b>
                </p>
            </div>
        </div>

        <div class="row">
            <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group' id='dtimpicker-from'>
                        <input type='text' class="form-control" id="inp-dtimpicker-from"/>
                        <span class="input-group-addon" id="sp-dtimpicker-from">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group' id='dtimpicker-to'>
                        <input type='text' class="form-control" id="inp-dtimpicker-to"/>
                        <span class="input-group-addon" id="sp-dtimpicker-to">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary btnapply" id="btn-apply"><?=lang('com_11');?></button>
            </div>
        </div>
        <div class="row">
            <div class='col-md-8'>
                <div class="form-group ulday">
                    <ul class="nav nav-pills">
                        <!--<li ><a href="#">--><?php //echo lang('part_all');?><!--</a></li>-->
                        <li class="active"><a href="javascript:void(0)" id="day"><?=lang('part_day');?></a></li>
                        <li><a href="javascript:void(0)" id="week"><?=lang('part_week');?></a></li>
                        <li ><a href="javascript:void(0)" id="month"><?=lang('part_month');?></a></li>
<!--                        <li ><a href="javascript:void(0)" id="three_months">--><?php //echo lang('part_tmonth');?><!--</a></li>-->
<!--                        <li ><a href="javascript:void(0)" id="year">--><?php //echo lang('part_year');?><!--</a></li>-->
                    </ul>
                </div>
            </div>
        </div>

        <div id="com_com">
            <span><?=lang('com_06')?>:</span>
            <select id="sel-cumulative">
                <option selected='selected' value="yes"><?=lang('com_07')?></option>
                <option value="no"><?=lang('com_08')?></option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-12 col-centered">
                <div class="graph-holder" id="container" style="min-height: 400px;direction: ltr;">
                    <!--<p><?= lang('trd_254');?></p>-->
                </div>
            </div>


        </div>
        <!-- <div class="tab-content cur-tab-cont">
            <div role="tabpanel" class="tab-pane table-responsive active" id="close">
                <table class="table table-striped tab-my-acct part-table arabic-part-table" id="part-table" name="part-table">
                    <thead>
                    <tr>
                        <th class="center-data">
                            <?=lang('com_01');?>
                        </th>
                        <th class="center-data">
                            <?=lang('com_02');?>
                        </th>
                        <th class="center-data">
                            <?=lang('com_03');?>
                        </th>
                        <th class="center-data">
                            <?=lang('com_04');?>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="tbl_clicks">
                    </tbody>
                </table>
            </div>
        </div> -->
    </div>

</div>

<style>
    #com_com {
        margin-left: 40px;
        position: absolute;
        margin-top: 32px;
        z-index: 100;
    }
    #com_com:lang(sa) {
        margin-right: 40px;
    }
    @-moz-document url-prefix() {
        @media screen and (max-width: 584px) {
            #com_com{
                padding: 10px!important;
                margin: 10px!important;
                position: static!important;
            }
        }
    }
    @media screen and (-webkit-min-device-pixel-ratio:0)  and (max-width: 584px) {
        #com_com{
            padding: 10px!important;
            margin: 10px!important;
            position: static!important;
        }
    }
</style>

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
    var firstload=0;
    var options = {
        chart: {
            renderTo: 'container'
        },
        rangeSelector: {
            enabled: false
        },
        navigator: {
            enabled: false
        },
        title: {
            text: '<?=lang('com_09')?>'
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '<?=lang('com_09')?>',
            data: []
        }]

    };

   <?php if(true){?>

    function getCommissionData(getDateFrom, getDateTo, getCumulative){
        console.log(getDateFrom);
        console.log(getDateTo);
        console.log(getCumulative);
        $.ajax({
            type: 'POST',
            url:'/partnership/getCommission_v2',
            data: {from:getDateFrom, to:getDateTo, cumulative:getCumulative},
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
                window.chart.showLoading();
            },
            success: function(response){
                console.log(response);

                $('span#totalCommission').html(response.totalCommission);

                options.series = [{
                    name: '<?=lang('com_09')?>',
                    data: response.data,
                    tooltip: {
                        valueDecimals: 2
                    }
                }];
                window.chart = new Highcharts.StockChart(options, function (chart) {});
                window.chart.hideLoading();

                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                window.chart.hideLoading();
            }
        });

        //var activeTable = $.fn.dataTable.tables( {visible: true, api: true});
        //activeTable.draw();
    }

    <?php } else{?>

    function getCommissionData(getDateFrom, getDateTo, getCumulative){
        console.log(getDateFrom);
        console.log(getDateTo);
        console.log(getCumulative);
        $.ajax({
            type: 'POST',
            url:'/partnership/getCommission',
            data: {from:getDateFrom, to:getDateTo, cumulative:getCumulative},
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
                window.chart.showLoading();
            },
            success: function(response){
                console.log(response);

                $('span#totalCommission').html(response.totalCommission);

                options.series = [{
                    name: '<?=lang('com_09')?>',
                    data: response.data,
                    tooltip: {
                        valueDecimals: 2
                    }
                }];
                window.chart = new Highcharts.StockChart(options, function (chart) {});
                window.chart.hideLoading();

                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                window.chart.hideLoading();
            }
        });

       // var activeTable = $.fn.dataTable.tables( {visible: true, api: true});
       // activeTable.draw();
    }

    <?php }; ?>

    $(function () {

        // Create the chart

        options.series[0].data = [<?=join($getCommissionData['chart'],",");?>];
        window.chart = new Highcharts.StockChart(options, function (chart) {});

        <?php if(IPLoc::Office()){?>
        var date_from = "<?php echo date("Y-m-d",strtotime("- 1 day"));?>";
        var date_to = "<?php echo date("Y-m-d");?>";
        <?php }else{?>
        var date_from = "<?php echo date("Y-m-d",strtotime("- 1 month"));?>";
        var date_to = "<?php echo date("Y-m-d");?>";
        <?php }?>


        $('#inp-dtimpicker-from').click(function(){
            $('span#sp-dtimpicker-from').click();
        });

        $('#inp-dtimpicker-to').click(function(){
            $('span#sp-dtimpicker-to').click();
        });

        $('#dtimpicker-from').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: date_from
        });

        $('#dtimpicker-to').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: date_to
        });

        $("#dtimpicker-from").on("dp.change", function (e) {
            $('#dtimpicker-to').data("DateTimePicker").minDate(e.date);
        });

        $("#dtimpicker-to").on("dp.change", function (ev) {
            $('#dtimpicker-from').data("DateTimePicker").maxDate(ev.date);
        });

        $('#sel-cumulative').on("change",function() {
            var getDateFrom = $("#dtimpicker-from").data('date');
            var getDateTo = $("#dtimpicker-to").data('date');
            var getCumulative = $('#sel-cumulative').val();
            getCommissionData(getDateFrom, getDateTo, getCumulative);
        });


        $('#btn-apply').click(function(){
            var getDateFrom = $("#dtimpicker-from").data('date');
            var getDateTo = $("#dtimpicker-to").data('date');
            var getCumulative = $('#sel-cumulative').val();

            $('ul.nav-pills li').removeClass('active');

            getCommissionData(getDateFrom, getDateTo, getCumulative);

        });


        $('ul.nav.nav-pills li a').click(function(e) {
            $(this).parent().addClass('active').siblings().removeClass('active');
            var target = $(e.target).attr("id"); // activated tab
            var dateNow = moment().format('YYYY-MM-DD');

            var startDate = new Date();
            var setMoment = moment(startDate);
            var endDateMoment = setMoment;
            switch (target){
                case 'day':
                    var newenddate = endDateMoment.subtract(1, 'day');
                    var newDate = newenddate.format('YYYY-MM-DD');
                    break;
                case 'month':
                    var newenddate = endDateMoment.subtract(1, 'months');
                    var newDate = newenddate.format('YYYY-MM-DD');
                    break;
                case 'week':
                    var newenddate = endDateMoment.subtract(1, 'week');
                    var newDate = newenddate.format('YYYY-MM-DD');
                    break;
                case 'three_months':
                    var newenddate = endDateMoment.subtract(3, 'months');
                    var newDate = newenddate.format('YYYY-MM-DD');
                    break;
                case 'year':
                    var newenddate = endDateMoment.subtract(1, 'year');
                    var newDate = newenddate.format('YYYY-MM-DD');
                    break;
                default:
                    var newDate = date_from;
                    var dateNow = date_to;
                    break;
            }


            $('#inp-dtimpicker-from').val(newDate);
            $("#dtimpicker-from").data("DateTimePicker").date(newDate);

            $('#inp-dtimpicker-to').val(dateNow);
            $("#dtimpicker-to").data("DateTimePicker").date(dateNow);

            var getCumulative = $('#sel-cumulative').val();

            getCommissionData(newDate, dateNow, getCumulative);

        });


        $('#part-table').DataTable({
            dom: 'ltip',
            processing : false,
            serverSide: true,
            responsive: true,
            ordering: false,
            deferLoading: 5,
            language:{
                //search: "Search :",
                // lengthMenu: "Show _MENU_ entries",
                // info: "Showing _PAGE_ to _PAGES_ entries",
                // zeroRecords: "No data available in table",
                // paginate: {
                //     next:       "Next",
                //     previous:   "Previous"
                search:'<?=lang('curtra_s')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                info: '<?=lang('dta_tbl_02')?>',
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
            ajax:{
                type: 'post',
                url: '/partnership/getAllCommissionPaginate',
                dataType: 'json',
                data: function(d){
                    d.date_from = $("#dtimpicker-from").data('date');
                    d.date_to = $("#dtimpicker-to").data('date');
                    $('#loader-holder').show();
                    return d;

                }
            },
            drawCallback : function (oSettings) {
                if(oSettings.fnRecordsDisplay() == 0){
                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .hide();
                }else{

                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .show();
                }
                $('#loader-holder').hide();
                    var readonly = "<?= $this->session->userdata('readOnly')?>";
                    if(readonly === '1'){
                        $('#inp-dtimpicker-from').attr('disabled',false);
                        $('#inp-dtimpicker-to').attr('disabled',false);
                        $('#btn-apply').attr('disabled',false);
                        // console.log('1');
                    }
            }
        });



        <?php if(!IPLoc::Office()){?>

        $('#part-table').DataTable().draw();

        <?php }?>

    });




    $(document).ready(function(){


        var getDateFrom = "<?php echo date('Y-m-d',strtotime("- 1 day"));?>";
        var getDateTo = "<?php echo date('Y-m-d') ; ?>";

        getCommissionData(getDateFrom, getDateTo, "yes");

        console.log(getDateFrom);
    })




</script>