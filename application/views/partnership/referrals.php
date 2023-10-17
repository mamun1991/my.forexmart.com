<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable');?>
<style>
    .period-option {
        width: 411px!important;
    }
    .part-table:lang(sa) {
        margin-top: 20px !important;
    }
    .referral-table td { text-align: center; }

    .center-data{
        text-align: center;
    }
    @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0){
        .btnapply{
            float: right;
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
.table-padding {
	padding: 10px 0;
}
 .table > thead:first-child > tr:first-child > th {
    border-top: 0;
    text-align: center;
}
</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="referrals">
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
            <div class="col-md-4 mbl-right">
                <button type="button" class="btn btn-primary btn-secondary btn-md" id="btn-apply"><?=lang('com_11');?></button>
				<a href="<?= FXPP::loc_url('partnership/referrals_export'); ?>">
					<button type="button" class="btn btn-primary btn-md btn-secondary"><?= lang('export');?></button>
				</a>
				<button type="button" class="btn btn-primary btn-md btn-secondary" id="chart-button"><?= lang('show_chart');?></button>
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


        <div class="row">
            <div class="col-md-12 period-txt-holder">
                <form class="form-inline">
                    <!--<div class="form-group txt-period">
                        Period :
                        <select class="form-control round-0 period-option">
                            <option>Choose</option>
                        </select>
                    </div>-->
                </form>
            </div>
        </div>
        <div id="graph-div" class="row">
            <div class="col-md-12 col-centered">
                <div class="graph-holder" id="container" style="min-height: 400px;direction: ltr;">
                </div>
            </div>
        </div>
        
        <div class="table-padding">
        <div class="table-responsive">
            <table class="table table-striped part-table referral-table arabic-part-table" id="tab-referrals-table" cellspacing="0" width="100%"  cellspacing="0" border="0">
                 <thead>
                       
                        <tr>
                            <th><?=lang('refer_05'); ?></th>
                            <th ><?=lang('refer_06'); ?></th>
                            <?php

                            if(FXPP::showReferralAccountBalance()){?>
                                <th><?= lang('trd_256');?></th>
                                <th><?= lang('macv_03');?></th>
                               <?php  if(FXPP::showCommisionAmount()){?>
                                <th> <?= lang('trd_257');?></th>
								   <?php }?>
								   
								   <?php  if(FXPP::showReferralAccountLots()){?>
                                <th> <?= lang('trd_258');?></th>
								   <?php }?>
								   
                               <?php if(FXPP::showReferralAccountContactDetails()){?>
                                <th><?= lang('mf_02');?></th>
                                <th><?= lang('trd_259');?></th>
                            <?php } }?>
                           <!-- <th>Status</th>-->
                            <th><?= lang('trd_261');?></th>
                        </tr>
                        </thead>
                        
                <tbody>
                </tbody>
            </table>
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
var options = {
	chart: {
		renderTo: 'container'
	},
	yAxis: {
		allowDecimals: false
	},
	rangeSelector: {
		enabled: false
	},
	navigator: {
		enabled: false
	},
	title: {
		text: '<?=lang('refer_08')?>'
	},

	series: [{
		name: 'Opened Accounts',
		data: [],
		tooltip: {
			valueDecimals: 2
		}
	}]

};

function getReferralsData(getDateFrom, getDateTo){
	$.ajax({
		type: 'POST',
		url:'/partnership/get_referrals',
		data: {from:getDateFrom, to:getDateTo},
		dataType: 'json',
		beforeSend: function(){
			$('#loader-holder').show();
			window.chart.showLoading();
		},
		success: function(response){
			options.series = [{
				name: 'Opened Accounts',
				data: response.chart,
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

	var date_from = "<?=date("Y-m-d 0:0:0",strtotime("2015-05-05"));?>";
	var date_to = "<?php echo date("Y-m-d 23:59:59");?>";

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

	$('#btn-apply').click(function(){
		var getDateFrom = $("#dtimpicker-from").data('date');
		var getDateTo = $("#dtimpicker-to").data('date');

		$('ul.nav-pills li').removeClass('active');

		getReferralsData(getDateFrom, getDateTo);
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

		getReferralsData(newDate, dateNow);
	});

	
	// Create the chart

	options.series[0].data = [<?=$chart?>];
	window.chart = new Highcharts.StockChart(options, function (chart) {
	});
	
	$('.referral-table').DataTable({
		//dom: 'ltip',
		//dom: 'Bfrtip',
        searching: true,
		processing : true,
		serverSide: true,
		responsive: true,
		ordering: false,
		deferLoading: 5,
		language:{
			search:'<?=lang('curtra_s')?>',
			search: "Search :",
			lengthMenu: "Show _MENU_ entries",
			//lengthMenu: '<?=lang('dta_tbl_07')?>',
			//info: "Showing _PAGE_ to _PAGES_ entries",
			info: '<?=lang('dta_tbl_02')?>',
			zeroRecords: '<?=lang('dta_tbl_01')?>',
			paginate: {
				next:       '<?=lang('dta_tbl_14')?>',
				previous:   '<?=lang('dta_tbl_15')?>'
			}
		},
		ajax:{
			type: 'post',
			url: '/partnership/getAllReferralsNew',
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

	$('#tab-referrals-table').DataTable().draw();
});
  
$("#graph-div").hide();
$(document).ready(function(){
  $("#chart-button").click(function(){
    $("#graph-div").toggle();
  });
});
</script>