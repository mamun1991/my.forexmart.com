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
    .highcharts-container{
        width: auto !important;
    }

    @media screen and (max-width: 767px){
        .comsHeaderWeb{
            display: none;
        }
        li.ComButtonMob {
            width: 20% !important;
        }
    }

    @media screen and (min-width: 768px){
        .comsHeaderMob{
            display: none;
        }



    }
    @media screen and (max-width: 767px){

        div#part-table_info {
            white-space: pre-line;
        }

        div#part-table_paginate {
            white-space: pre-line;
        }
    }

    }

    .control-label, .input-daterange{
        padding: 8px 0;
    }
    #btn-apply , #btn-show-chart{
        width: 98%;
        padding: 5px;
        background: #85c7f3;
        color: #000;
        border: 1px solid #85c7f3;
        border-radius: 5px;
        font-weight: bold;
        line-height: 20px;
        margin-top: 25px;
    }
    #btn-apply:hover , #btn-show-chart:hover {
        background: #106baa;
        color: #fff;
    }
    .btn-stn{
        width: 98%;
        padding: 5px;
        background: #fff;
        color: #337AB7;
        border: 1px solid #337AB7;
        border-radius: 5px;
        font-weight: bold;
        line-height: 20px;
        margin-top: 25px;
    }
    .btn-stn:hover{
        background-color: #eee;
    }
    .btn-active{
        background: #106baa;
        color: #fff;
    }
    .outer{
        margin-bottom: 10px;
        padding: 0px;
    }
</style>


<div class="tab-content acct-cont">

   

    <div class="col-md-12 outer">
        <div class="input-daterange col-md-4" style="padding:0px;">
            <label for="date_from_history" class="control-label" style="float:left;display:inline-block;"><span class="translate"><?=lang('date_from')?></span></label>
            <input type="date" id="date_from_history" class="form-control hx-date" name="date_from_history" value="<?php echo date('Y-m-d',strtotime('yesterday'));?>" style="width:98%!important; display:inline-block;">
        </div>
        <div class="input-daterange col-md-4" style="padding:0px;">
            <label for="date_to_history" class="control-label" style="float:left;display:inline-block;width:80px;"><span class='translate'><?=lang('date_to')?></span></label>
            <input type="date" id="date_to_history" class="form-control hx-date" name="date_to_history" value="<?php echo date('Y-m-d',strtotime('now'));?>" style="width:98%!important; display:inline-block;">
        </div>
        <div class="input-daterange col-md-2" style="padding:0px;">
            <button id="btn-apply" type="button"><?=lang('btn_apply')?></button>
        </div>
        <div class="input-daterange col-md-2" style="padding:0px;">
            <button id="btn-show-chart" type="button"><?=lang('btn_chart')?></button>
        </div>
    </div>

    <div class="col-md-12 outer">
        <p class="">
            <b> <?=lang('txt_total')?> <span id="totalCommission"><?php echo $getCommissionData['totalCommission'];?></span></b>
        </p>
    </div>
    <div class="col-md-6 col-sm-12 outer">
        <div class="input-daterange col-md-4" style="padding:0px;">
            <button id="btn-day" type="button" class="btn-stn btn-active" data-day="day" data-dt="<?php echo date('Y-m-d',strtotime('-1 day'));?>"><?=lang('txt_day')?></button>
        </div>
        <div class="input-daterange col-md-4" style="padding:0px;">
            <button id="btn-week" type="button" class="btn-stn" data-day="week" data-dt="<?php echo date('Y-m-d',strtotime('-1 week'));?>" ><?=lang('txt_week')?></button>
        </div>
        <div class="input-daterange col-md-4" style="padding:0px;">
            <button id="btn-month" type="button" class="btn-stn" data-day="month" data-dt="<?php echo date('Y-m-d',strtotime('-1 month'));?>" ><?=lang('txt_month')?></button>
        </div>
    </div>

    <div role="tabpanel" class="row tab-pane commissions col-md-12" id="commission-graph-new" style="padding: 0px; margin: 0 auto;">
        <div class="col-sm-12">
            <div class="row history-form-holder">
                <div class="col-sm-12 col-centered" style="padding: 0px;">
                    <div id="com_com">
                        <span><?=lang('com_06')?>:</span>
                        <select id="sel-cumulative">
                            <option selected='selected' value="yes"><?=lang('com_07')?></option>
                            <option value="no"><?=lang('com_08')?></option>
                        </select>
                    </div>

                    <div id="graph-div" class="row">
                        <div class="col-md-12 col-centered" style="margin: 0 auto;">
                            <div class="graph-holder" id="container" style="min-height: 400px;direction: ltr;">
                                <p><?= lang('trd_254');?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div role="tabpanel" class="row tab-pane active commissions" >
        <div class="col-sm-12">
            <div class="row history-form-holder">
                <div class="col-sm-12 col-centered">
                    <label><?=lang('txt_show')?></label>
                  <!--  <select style="width: 60px;" id="rowPerPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <label>entries</label>-->
                    <table id="tbl-commissions" class="table table-striped tab-my-acct arabic-part-table arabic-trans-history-table commissions">
                        <thead>
                        <th style=" width: 10%;">#</th>
                         <th style="width: 30%;"><?=lang('txt_date')?></th>
                            <th style="width: 10%;"><?=lang('txt_sum')?></th>
                            <th style="width: 15%;"><?=lang('txt_referral')?></th>
                            <th style="width: 20%;"><?=lang('txt_instrument')?></th>
                            <th style="width: 15%;"><?=lang('txt_ticket')?></th>

                        </thead>
                        <tbody id="result"></tbody>
                    </table>
                </div>
                <div style='text-align: center;' id='showing' class="col-md-12"></div>
                <div style='margin-top: 10px;text-align: center;' id='commission-pagination' class="pagination col-md-12"></div>
            </div>
        </div>
    </div>
</div>

<style>
    #com_com {  margin-left: 20px; position: absolute;   margin-top: 35px;  z-index: 100;  }
    #com_com:lang(sa) {  margin-right: 40px;  }
    @-moz-document url-prefix() {
        @media screen and (max-width: 584px) {
            #com_com{  padding: 10px!important;  margin: 10px!important;  position: static!important; }
        }
    }
    @media screen and (-webkit-min-device-pixel-ratio:0)  and (max-width: 584px) {
        #com_com{ padding: 10px!important;  margin: 10px!important;  position: static!important; }
    }
</style>



<?php if (FXPP::html_url() == 'sa') { ?>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } else { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } ?>



<script>
    $(document).ready(function () {

        getCommissionTable();

    });
    $("#btn-apply").click(function () {
        $("#commission-graph-new").removeClass('active');
        $("#btn-show-chart").removeClass('chart-show');
        getCommissionTable();
    });

    $("button.btn-stn").click(function () {
        var dt = $(this).data('dt');
        $("button.btn-stn").each(function () {   $(this).removeClass('btn-active');  });
        $(this).addClass( $(this).addClass('btn-active') );
        $('#date_from_history').val(dt);
       // getCommissionRecords(recordType, 0,dt);
        getCommissionTable();
    });
    function getCommissionRecords(recordType, pageNum, dt) {
        var data = {
            recType: recordType,
            page: pageNum,
            from: $('#date_from_history').val(),
            to: $('#date_to_history').val(),
            dt: dt,
            rowNum: $('#rowPerPage').val(),
        };
        var container = "table#tbl-commissions tbody#result",
            from = $('#date_from_history').val(),
            to = $('#date_to_history').val();

			var ajax_url = "<?= FXPP::ajax_url('')?>";
			
        $.ajax({
            type: "post",
            url: ajax_url + "get-trades",
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $('#loader-holder').show();
            },
            success: function (x) {
                if (x.hasError) {
                    $(container).html("<tr><td colspan='6' style='text-align: center;'>Internal Error. Please contact support.</td></tr>");
                } else {
                    $(container).html(x.result['result']);
                    $('span#totalCommission').html(x.totalCom);

                    $('#commission-pagination').each(function () {     $(this).html("");     });

                    $('#showing').html(x.result['showing']);
                    $('#commission-pagination').html(x.result['pagination']);
                    var pg = pageNum <= 1 ? 1 : pageNum;

                    $('ul.tab-pagination li.latest-page').each(function () {
                        $(this).removeClass('active');
                    });
                    $("ul.tab-pagination").find("[data-ci-pagination-page='" + pg + "']").closest('li').addClass('active');

                }
                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#loader-holder').hide();
                // console.log(xhr.status);
                // console.log(thrownError);
            }
        });
    }


        /*VENUS*/

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


        $("#btn-show-chart").click(function () {
            if( $(this).hasClass('chart-show') ){
                $("#commission-graph-new").removeClass('active');
                $(this).removeClass('chart-show');
            }else{
                $(this).addClass('chart-show');
                getCommissionData();
                $("#commission-graph-new").addClass('active');
            }
        });

        $('#sel-cumulative').on("change",function() {
            getCommissionData();
        });

    function getCommissionTable() {
        var tbl = 'tbl-commissions';
        console.log(tbl);
        var requestURL =  '<?=FXPP::ajax_url('partnership/requestCommission')?>';
        //  $('#'+ tbl).DataTable().destroy();
        $('#'+ tbl).on('preXhr.dt', function (e, settings, data) {
            $('#' + tbl + ' tbody').html('<div class ="loading_rec" style="text-align:center;"><tr><td colspan="8">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');
        }).on('xhr.dt', function (e, settings, json, xhr) {
            $('#' + tbl + ' tbody').html('');


        }).DataTable({
            "bJQueryUI": true,
            "destroy": true,
            "processing": false,
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "language":{
                search:'<?=lang('curtra_s')?>',
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                info: '<?=lang('dta_tbl_02')?>',
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ],
            "order": [],  // not set any order rule for any column.
            "ajax": {
                "url": requestURL,
                "type": "POST",
                "data": function (d) {
                    return $.extend( {}, d, {
                        "from": $('#date_from_history').val(),
                        "to": $('#date_to_history').val(),
                    } );
                },
                "dataSrc": function (json) {
                    $('span#totalCommission').html(parseFloat(json.commission).toFixed(2));
                    return json.data;


                }
            },
            "drawCallback" : function (oSettings) {



                if(oSettings.fnRecordsDisplay() == 0){
                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .hide();
                }else{

                    $(oSettings.nTableWrapper)
                        .find('.dataTables_paginate, .dataTables_filter, .dataTables_length, .dataTables_info')
                        .show();
                }

                setTimeout(function(){ $('#loader-holder').hide(); }, 1000);
            }
        });
    }


        function getCommissionData(){
            var getDateFrom = $('#date_from_history').val();
            var getDateTo = $('#date_to_history').val();
            var getCumulative = $('#sel-cumulative').val();

            var ajax_url = '/partnership/getCommission_v4';

            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {from:getDateFrom, to:getDateTo, cumulative:getCumulative},
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                    window.chart.showLoading();
                },
                success: function(response){
                    $('span#totalCommission').html(response.totalCommission);
                    getCommissionRecords(recordType, 0, '');
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


            var activeTable = $.fn.dataTable.tables( {visible: true, api: true});
            activeTable.draw();
        }

        $(function () {
            // Create the chart
            options.series[0].data = [<?=join($getCommissionData['chart'],",");?>];
            window.chart = new Highcharts.StockChart(options, function (chart) {});

        });

        /*VENUS*/


</script>