<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable');?>
<style type="text/css">
    .cur-trades-tab > li.active > a{  background: #C0C0C0!important;  }
    .partnership-referral{  font-size: 14px;  }
    .center-data{  text-align: center;  }
    .part-table td { text-align: center; }
    @media screen and (max-width: 700px) {  ul.referrer li{  width: 100%;  float: none;  margin: 1px;  }  ul.referrer li a{  text-align: center;  }  }
    .dataTables_wrapper {  _height: 102px;  min-height: 102px;  }
    @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0){  .btnapply{   float: right;  }  }
    @media screen and (max-width: 463px)and (min-width: 344px) and (-webkit-min-device-pixel-ratio:0){  .ulday{  margin-top:5px;  } .nav-pills li{  width: 32.5%!important;  }  }
    @media screen and (max-width: 343px) and (-webkit-min-device-pixel-ratio:0){  .ulday{  margin-top:5px;  }  .nav-pills li{  width: 100%!important;  } }
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="referrals">
        <div class="row">
            <div class="col-sm-12">
                <p class="part-text">
                    <?=lang('refer_00'); ?>
                </p>
            </div>
            <div class="col-sm-12">
                <p style="margin-top: 5px;" class="">
                    <b> <?=lang('refer_01'); ?>: <span id="numberofreferrals"><?=$referralsTotal;//$no_of_registered_acc;?></span></b>
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
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btnapply" id="btn-apply"><?=lang('com_11');?></button>
				<a href="<?= FXPP::loc_url('partnership/referrals_export'); ?>">
					<button type="button" class="btn btn-primary">Export</button>
				</a> 				
			</div>
        </div>
        <div class="row">
            <div class='col-md-8'>
                <div class="form-group ulday">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#"><?=lang('part_all');?></a></li>
                        <li><a href="javascript:void(0)" id="day"><?=lang('part_day');?></a></li>
                        <li><a href="javascript:void(0)" id="week"><?=lang('part_week');?></a></li>
                        <li><a href="javascript:void(0)" id="month"><?=lang('part_month');?></a></li>
                        <li><a href="javascript:void(0)" id="three_months"><?=lang('part_tmonth');?></a></li>
                        <li><a href="javascript:void(0)" id="year"><?=lang('part_year');?></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12 col-centered">
                <div class="graph-holder" id="container" style="min-height: 400px;direction: ltr;">

                </div>
            </div>
        </div> -->

        <div class="tab-content cur-tab-cont partnership-referral">
            <div role="tabpanel" class="tab-pane table-responsive active" id="tab-sub1">

                <div class="table-responsive" id="confirmed-tab">
                    <table class="table table-striped part-table" id="tab-sub1-table" cellspacing="0" width="100%"  cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th class="center-data"><?=lang('refer_05'); ?></th>
                            <th  class="center-data"><?=lang('refer_06'); ?></th>
                            <?php

                            if(FXPP::showReferralAccountBalance()){?>
                                <th  class="center-data">referral's name</th>
                                <th  class="center-data">Balance</th>
                               <?php  if(FXPP::showCommisionAmount()){?>
                                <td class="center-data"> Total amount of commission</td>
                                   <?php }?>
                               <?php if(FXPP::showReferralAccountContactDetails()){?>
                                <th  class="center-data">Email</th>
                                <th  class="center-data">Phone number</th>
                            <?php } }?>
                            <th  class="center-data">Status</th>
                            <th  class="center-data">Verified Status</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

            <p class="part-text arabic-part-text">* <?=lang('refer_04'); ?></p>
            <p class="part-text arabic-part-text">* <?=lang('refer_07'); ?></p>
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
<script type="text/javascript">
    var sfrom = '';
    var sto = '';
    var options = {
        chart: {renderTo: 'container'},
        yAxis: {allowDecimals: false},
        rangeSelector: {enabled: false},
        navigator: {enabled: false},
        title: {text: '<?=lang('refer_08')?>'},
        series: [{
            name: 'Opened Accounts',
            data: [],
            tooltip: {
                valueDecimals: 0
            }
        }]
    };
    //options.series[0].data = [<?=$chart?>];
    //window.chart = new Highcharts.StockChart(options, function (chart) {  });

    $(document).ready(function () {
        sfrom = "<?=date("Y-m-d 0:0:0",strtotime("2015-05-05"));?>";
        sto = "<?php echo date("Y-m-d 23:59:59");?>";
        $('#inp-dtimpicker-from').click(function(){ $('span#sp-dtimpicker-from').click(); });
        $('#inp-dtimpicker-to').click(function(){ $('span#sp-dtimpicker-to').click(); });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            var target = $(e.target).attr("href"); // activated tab
            $(target+'-table').DataTable().draw();
        });

        $('#dtimpicker-from').datetimepicker({ format: 'YYYY-MM-DD',  defaultDate: sfrom });

        $('#dtimpicker-to').datetimepicker({ format: 'YYYY-MM-DD',   defaultDate: sto });

        $("#dtimpicker-from").on("dp.change", function (e) { $('#dtimpicker-to').data("DateTimePicker").minDate(e.date); });

        $("#dtimpicker-to").on("dp.change", function (ev) { $('#dtimpicker-from').data("DateTimePicker").maxDate(ev.date); });


        getAllreferralsByDate('all',sfrom,sto);
        var readonly = "<?= $this->session->userdata('readOnly')?>";
        if(readonly === '1'){
            $('#inp-dtimpicker-from').attr('disabled',false);
            $('#inp-dtimpicker-to').attr('disabled',false);
            $('#btn-apply').attr('disabled',false);
            console.log(readonly);
        }
        $('.part-table').DataTable({
            dom: 'ltip',
            processing : true,
            serverSide: true,
            responsive: true,
            ordering: false,
            deferLoading: 5,
            language:{
                //search: "Search :",
                search:'<?=lang('curtra_s')?>',
                //lengthMenu: "Show _MENU_ entries",
                lengthMenu: '<?=lang('dta_tbl_07')?>',
                //info: "Showing _PAGE_ to _PAGES_ entries",
                info: '<?=lang('dta_tbl_02')?>',
                //zeroRecords: "No data available in table",
                zeroRecords: '<?=lang('dta_tbl_01')?>',
                paginate: {
                    next:       '<?=lang('dta_tbl_14')?>',
                    previous:   '<?=lang('dta_tbl_15')?>'
                }
            },
        });
    });
    $('ul.nav.nav-pills li a').click(function() {
        $(this).parent().addClass('active').siblings().removeClass('active');
        var target = $(this).attr("id"); // activated tab
        var tab_clicked = '';
        switch (target){
            case 'day':     tab_clicked="day"; break;
            case 'month':   tab_clicked="month"; break;
            case 'week':    tab_clicked="week"; break;
            case 'three_months':tab_clicked="three"; break;
            case 'year':    tab_clicked="year"; break;
            default:        tab_clicked="all"; break;
        }
        getAllreferralsByDate(tab_clicked,sfrom,sto);
    });
    $('#btn-apply').click(function(){
        var getDateFrom = $("#dtimpicker-from").data('date');
        var getDateTo = $("#dtimpicker-to").data('date');
        $('ul.nav-pills li').removeClass('active');
        getAllreferralsByDate('custom',getDateFrom, getDateTo);
    });

    function getAllreferralsByDate(tab_clicked, sfrom, sto){
        var table1 = $('.part-table').DataTable({});
        var base_url = "<?php echo FXPP::ajax_url('partnership/getAllReferrals')?>//";
        $.ajax({
            type: 'POST',url: base_url,dataType: 'json',
            data: {tab:tab_clicked , from:sfrom,to:sto},
            beforeSend: function(){ $('table#tab-sub1-table tbody').html('<tr><td colspan="4">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr>');  },
            success: function(data) {
                if(data.success){
                    $('#inp-dtimpicker-from').val(data.fromDate);
                    $("#dtimpicker-from").data("DateTimePicker").date(data.fromDate);

                    $('#inp-dtimpicker-to').val(data.toDate);
                    $("#dtimpicker-to").data("DateTimePicker").date(data.toDate);

                    table1.destroy();
                    $('table#tab-sub1-table tbody').html(data.record);
                    $('.part-table').DataTable({
                        "bSort": false,
                        "ordering": false
                    });
                   // UpdateGraphOnClick(data.chart1);
                }
            }
        });
    }
    function UpdateGraphOnClick(graphInfo){
        options.series = [{
            name: 'Opened Accounts',
            data: graphInfo,
            tooltip: {
                valueDecimals: 2
            }
        }];
        window.chart = new Highcharts.StockChart(options, function (chart) {});
    }
	
/*$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );*/

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function() {
  var table = 'tab-sub1-table';
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
