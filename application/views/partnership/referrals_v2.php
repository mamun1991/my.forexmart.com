<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable');?>
<style>
	th {text-align:center}
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
			<div class='col-md-4 top-gap'>
                <div class="form-group">
                    <div class='input-group' id='dtimpicker-from'>
                        <input type='text' class="form-control" id="inp-dtimpicker-from"/>
                        <span class="input-group-addon" id="sp-dtimpicker-from">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <div class='col-md-4 top-gap'>
                <div class="form-group">
                    <div class='input-group' id='dtimpicker-to'>
                        <input type='text' class="form-control" id="inp-dtimpicker-to"/>
                        <span class="input-group-addon" id="sp-dtimpicker-to">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
			
            <!-- <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group dtimpicker col-sm-12' >
                        <input type='date' min='2015-01-01' max='<?php echo date("Y-m-d");?>' class="form-control" id="dtimpicker-from" onkeydown="return false"/>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class="form-group">
                    <div class='input-group dtimpicker  col-sm-12'>
                        <input type='date' min='2015-01-01' max='<?php echo date("Y-m-d");?>' class="form-control" id="dtimpicker-to" onkeydown="return false"/>

                    </div>
                </div>
            </div> -->
            <div class="col-md-4 mbl-right">
                <button type="button" class="btn btn-primary btn-secondary btn-md  top-gap" id="btn-apply"><?=lang('com_11');?></button>
				<a href="<?= FXPP::loc_url('partnership/referrals_export2'); ?>">
					<button type="button" class="btn btn-primary btn-md btn-secondary  top-gap"><?= lang('export');?></button>
				</a>
				<button type="button" class="btn btn-primary btn-md btn-secondary  top-gap" id="chart-button"><?= lang('show_chart');?></button>
            </div>			
        </div>
        <div class="row">
            <div class='col-md-8'>
                <div class="form-group ulday">
                    <ul class="nav nav-pills" id="daytab">
                        <li class="active"><a href="#"  data-day ="0"><?=lang('part_all');?></a></li>
                        <li><a href="javascript:void(0)" data-day ="1" id="day"><?=lang('part_day');?></a></li>
                        <li><a href="javascript:void(0)" data-day ="2" id="week"><?=lang('part_week');?></a></li>
                        <li><a href="javascript:void(0)"  data-day ="3" id="month"><?=lang('part_month');?></a></li>
                        <li><a href="javascript:void(0)"  data-day ="4" id="three_months"><?=lang('part_tmonth');?></a></li>
                        <li><a href="javascript:void(0)"  data-day ="5" id="year"><?=lang('part_year');?></a></li>
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


                            <tr class="heading-title">
                               <?php
							   foreach($ref_table as $d){echo "<th>".$d."</th>";} ?>
                            </tr>
							<tr class="heading-total">
								<?php
								foreach($ref_table as $d){echo "<th class='total-head'>"."</th>";} ?>
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



	var heading = 	'<thead><tr class="td-heading-total">' +  '<?php foreach($ref_table as $d){echo '<th class ="total-head">'.'</th>';} ?>' + '</tr></thead>';
	var c_commission = "<?php echo $column['commission_column'];?>";
	var c_saldo = "<?php echo $column['saldo_column'];?>";
	var c_lots = "<?php echo $column['lots_column'];?>";
	var c_balance = "<?php echo $column['balance_column'];?>";

	var isToggle = true;
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






function getReferralsData(){
	//'/partnership/get_referrals';
	var ajax_url =  '/partnership/getClickRegistration';
	//console.log('test---');

	$.ajax({
		type: 'POST',
		url:ajax_url,
		data: {from:$("#inp-dtimpicker-from").val(), to:$("#inp-dtimpicker-to").val()},
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



	var colSpan = '<?= $header_count; ?>';

	$("#tab-referrals-table").on("click", "td span.btn-expand", function() {
		var ref = $(this).attr('ref');
		var level = $(this).attr('data-level');

		var td_table = "<table id = 'td-" + ref + "' class='table table-stripped queue-tab'>" + heading + "<tbody id = 'tbody-" + ref + "'></tbody></table>";



		$(this).closest('tr').after("<tr><td  colspan='" + colSpan + "'>"+td_table+"</td></tr>");
		$(this).removeClass('btn-expand');
		$(this).addClass('btn-remove');

		$(this).html('<i  class="fa fa-minus">');

		$.ajax({
			url: '/partnership/getReferralsByLevel',
			type: 'POST',
			data: {account:ref,level:level},
			beforeSend: function () {
				$('#tbody-' + ref).html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="20">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

			}
		}).done(function (response) {
			$('#tbody-' + ref).html(response.table_view);

			$('[data-toggle="tooltip"]').tooltip({html:true});





			// total per column *

			if(c_balance > 0 || c_commission > 0 || c_lots > 0 || c_saldo > 0 ) {
				$('#tbody-' + ref).closest('table').find('.td-heading-total').show();
				$("#td-" + ref + " thead tr.td-heading-total th:nth-child(1)").html("TOTAL PER PAGE");

				if (c_balance > 1) {
					$("#td-" + ref + " thead tr.td-heading-total th:nth-child(" + ( c_balance ) + ")").html(parseFloat(response.balance).toFixed(2));

				}
				if (c_saldo > 1) {
					$("#td-" + ref + " thead tr.td-heading-total th:nth-child(" + ( c_saldo ) + ")").html(parseFloat(response.saldo).toFixed(2));

				}
				if (c_lots > 1) {
					$("#td-" + ref + " thead tr.td-heading-total th:nth-child(" + ( c_lots ) + ")").html(parseFloat(response.lots).toFixed(2));

				}
				if (c_commission > 1) {
					$("#td-" + ref + " thead tr.td-heading-total th:nth-child(" + ( c_commission ) + ")").html(parseFloat(response.commission).toFixed(2));

				}
			}else{
				$('#tbody-' + ref).closest('table').find('.td-heading-total').hide();

			}






	     });

	  });


	$(document).on("click",'.btn-remove',function(){
		$(this).parents("tr").next().remove();
		$(this).removeClass('btn-remove');
		$(this).addClass('btn-expand');
		$(this).html('<i class="fa fa-plus">');

		return false;
	});




	$('#btn-apply').click(function(){
		$('ul.nav-pills li').removeClass('active');

		getReferralsData();
	});

		var dateNow = moment().format('YYYY-MM-DD');
		var startDate = new Date();
		var setMoment = moment(startDate);
		var endDateMoment = setMoment;

		$('#inp-dtimpicker-from').val(moment('2015-05-05').format('YYYY-MM-DD'));
		$('#inp-dtimpicker-to').val(dateNow);

	$('ul.nav.nav-pills li a').click(function(e) {
		$(this).parent().addClass('active').siblings().removeClass('active');
		var target = $(e.target).attr("id"); // activated tab

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
				var newDate = '2015-05-05';
				var dateNow = date_to;
				break;
		}


		$('#dtimpicker-from').val(newDate);
		getReferralsData();


	});


	// Create the chart

	options.series[0].data = [<?=$chart?>];
	window.chart = new Highcharts.StockChart(options, function (chart) {
	});



	  var ajax_url = '/partnership/getAllReferrals_v3';
	
	 // var ajax_url = '/partnership/getAllReferrals_v22';




	var t =  $('.referral-table').DataTable({
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
			url: ajax_url,
			dataType: 'json',
			data: function(d){
				d.date_from = $("#inp-dtimpicker-from").val();
				d.date_to = $("#inp-dtimpicker-to").val();
				$('#loader-holder').show();
				 console.log('test:::::::::::::::::::::::::::');
				return d;

			},
			dataSrc: function (json) {


				if(c_balance > 0 || c_commission > 0 || c_lots > 0 || c_saldo > 0 ) {
					$('.heading-total').show();
				// total per column --
				$("#tab-referrals-table thead tr.heading-total th:nth-child(1)").html("TOTAL PER PAGE");

				if (c_balance > 1) {
					$("#tab-referrals-table thead tr.heading-total th:nth-child(" + ( c_balance ) + ")").html(parseFloat(json.balance).toFixed(2));

				}
				if (c_saldo > 1) {
					$("#tab-referrals-table thead tr.heading-total th:nth-child(" + ( c_saldo ) + ")").html(parseFloat(json.saldo).toFixed(2));

				}
				if (c_lots > 1) {
					$("#tab-referrals-table thead tr.heading-total th:nth-child(" + ( c_lots ) + ")").html(parseFloat(json.lots).toFixed(2));

				}
				if (c_commission > 1) {
					$("#tab-referrals-table thead tr.heading-total th:nth-child(" + ( c_commission ) + ")").html(parseFloat(json.commission).toFixed(2));

				}
			}else{

					$('.heading-total').hide();
			}


				return json.data;


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
			$('[data-toggle="tooltip"]').tooltip({html:true});
			$('#loader-holder').hide();
			var readonly = "<?= $this->session->userdata('readOnly')?>";
			if(readonly === '1'){
				$('#dtimpicker-from').attr('disabled',false);
				$('#dtimpicker-to').attr('disabled',false);
				$('#btn-apply').attr('disabled',false);

			}

		}


	});


	$('#tab-referrals-table').DataTable().draw();



});
  
$("#graph-div").hide();
$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip({html:true});


  $("#chart-button").click(function(){
	  if(isToggle){
		 $('#btn-apply').trigger('click');
		  isToggle = false;
	  }
    $("#graph-div").toggle();
  });


	$("#export-button").click(function(){
		var d = $('ul#daytab li a.active').parent().attr('data-day');
		console.log($('ul#daytab li a.active').parent().attr('data-day'));

	    window.location.href = 'https://my.forexmart.com/partnership/referrals_export2/' + d;

	});
	
	
	
});




</script>