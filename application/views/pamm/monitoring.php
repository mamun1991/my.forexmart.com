<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<style type="text/css">
    .dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    display: none;
}
</style>

<div class="pamm-onclick-page destination-class" id="pamm-div-trader">

    <?=$nav;?>

    <div id="my-tab-content" class="tab-content pamm-tab-content">
        <div id="secondary-monitoring">
            <div class="pamm-monitoring-landing live-feed-class" id="secondary-monitoring-div">
                <h1><?= lang('pamm_39'); ?></h1>
                <div class="pamm-monitoring-info">
                    <p style="text-align: justify;"><?= lang('pamm_40'); ?>.
                        </br></br><?= lang('pamm_41'); ?>.
                        </br></br>
                        <?= lang('pamm_42'); ?>.
                    </p>
                </div>

                <div class="broker-info text-center">
                    <a href="javascript:void(0)" class="btn_daily btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_55'); ?></a>
                    <a href="javascript:void(0)" class="btn_weekly btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_56'); ?></a>
                    <a href="javascript:void(0)" class="btn_monthly btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_57'); ?></a>
                    <a href="javascript:void(0)" class="btn_3months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_58'); ?></a>
                    <a href="javascript:void(0)" class="btn_6months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_59'); ?></a>
                    <a href="javascript:void(0)" class="btn_9months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_60'); ?></a>
                    <a href="javascript:void(0)" class="btn_total btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_61'); ?></a>
                </div>

                <div class="trades-tab-holder">
                    <div class="table-responsive">
                        <table id="MonitoringTable"  name="MonitoringTable" class="table table-striped table-hover one-table cdsize">
                            <thead>
                            <tr>
                                <th><?= lang('pamm_62'); ?></th>
                                <th><?= lang('pamm_63'); ?></th>
                                <th>Daily Profit</th>
                                <th>Weekly Profit</th>
                                <th>Monthly Profit</th>
                                <th>3-month Profit</th>
                                <th>6-month Profit</th>
                                <th>9-month Profit</th>
                                <th>Total Profit</th>
                                <th><?= lang('pamm_64'); ?></th>
                                <th><?= lang('pamm_65'); ?></th>
                                <th><?= lang('pamm_66'); ?></th>
                                <th><?= lang('pamm_67'); ?></th>
                                <th><?= lang('pamm_68'); ?></th>
                                <th style="min-width: 127px"><?= lang('pamm_70'); ?></th>
                                <th style="min-width: 115px"><?= lang('pamm_71'); ?></th>
                                <th style="min-width: 106px"><?= lang('pamm_72'); ?></th>
                            </tr>
                            <tr>
                                <th>
                                <div class="input-group">
                                    <input  id="accountnumber_project" name="accountnumber_project" type="text" class="accountnumber_project form-control ctm_inputwidth">
                                          <span class="input-group-btn">
                                                  <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                          </span>
                                </div>
                                </th>
                                <th>
                                    <!--simple rating-->
                                    <select name="simplerating" id="simplerating" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option></select>
                                    </select>
                                </th>
                                <th>
                                    <!--dailyprofit-->
                                    <select  name="dailyprofit" id="dailyprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                    </select>
                                </th>
                                <th>
                                    <!--weekly profit-->
                                    <select  name="weeklyprofit" id="weeklyprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>

                                <th>
                                    <!--monthly profit-->
                                    <select name="monthlyprofit" id="monthlyprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>
                                <th>
                                    <!--3 month profit-->
                                    <select name="threemonthprofit" id="threemonthprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>
                                <th>
                                    <!--6 month profit-->
                                    <select name="sixmonthprofit" id="sixmonthprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>
                                <th>
                                    <!--9 month profit-->
                                    <select name="ninemonthprofit" id="ninemonthprofit"  class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>
                                <th>
                                    <!--total profit-->
                                    <select name="totalprofit" id="totalprofit" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="10-20">10-20</option>
                                        <option value="20-30">20-30</option>
                                        <option value="30-50">30-50</option>
                                        <option value="50-100">50-100</option>
                                        <option value="100-200">100-200</option>
                                        <option value="200-300">200-300</option>
                                    </select>
                                </th>
                                <th>
                                    <!--balance-->
                                    <select name="balance" id="balance" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">1">&gt;1</option>
                                        <option value=">100">&gt;100</option>
                                        <option value=">1000">&gt;1000</option>
                                        <option value=">3000">&gt;3000</option>
                                        <option value=">5000">&gt;5000</option>
                                        <option value=">10000">&gt;10000</option>
                                        <option value=">50000">&gt;50000</option>
                                        <option value=">100000">&gt;100000</option>
                                        <option value="0-1000">0-1000</option>
                                        <option value="1000-3000">1000-3000</option>
                                        <option value="3000-5000">3000-5000</option>
                                        <option value="5000-10000">5000-10000</option>
                                        <option value="10000-50000">10000-50000</option>
                                    </select>
                                </th>
                                <th>
                                    <!--equity-->
                                    <select name="equity" id="equity" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">1">&gt;1</option>
                                        <option value=">100">&gt;100</option>
                                        <option value=">1000">&gt;1000</option>
                                        <option value=">3000">&gt;3000</option>
                                        <option value=">5000">&gt;5000</option>
                                        <option value=">10000">&gt;10000</option>
                                        <option value=">50000">&gt;50000</option>
                                        <option value=">100000">&gt;100000</option>
                                        <option value="0-1000">0-1000</option>
                                        <option value="1000-3000">1000-3000</option>
                                        <option value="3000-5000">3000-5000</option>
                                        <option value="5000-10000">5000-10000</option>
                                        <option value="10000-50000">10000-50000</option>
                                    </select>
                                </th>
                                <th>
                                    <!--current trades-->
                                    <select name="currenttrades" id="currenttrades" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option>
                                    </select>
                                </th>

                                <th>
                                    <!--total trades-->
                                    <select name="totaltrades" id="totaltrades" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option>
                                    </select>
                                </th>
                                <th>
                                    <!--active investor-->
                                    <select name="activeinvestor" id="activeinvestor" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option>
                                    </select>
                                </th>
                                <th>
                                    <!--Daily total (balance)-->
                                    <select name="dailytotalbalance" id="dailytotalbalance" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option>
                                    </select>
                                </th>
                                <th>
                                    <!--total daily equity-->
                                    <select name="totaldailyequity" id="totaldailyequity" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value=">0">&gt;0</option>
                                        <option value="0-20">0-20</option>
                                        <option value="20-40">20-40</option>
                                        <option value="40-60">40-60</option>
                                        <option value="60-80">60-80</option>
                                        <option value="80-100">80-100</option>
                                        <option value="100-150">100-150</option>
                                        <option value="150-200">150-200</option>
                                        <option value=">200">&gt;200</option>
                                    </select>
                                </th>
                                <th>
                                    <!--since registered-->
                                    <select name="sinceregistered" id="sinceregistered" class="form-control ctm_selfixwidth">
                                        <option value=""></option>
                                        <option value="30">&gt;=30 days</option>
                                        <option value="90">&gt;=90 days</option>
                                        <option value="180">&gt;=180 days</option>
                                        <option value="270">&gt;=270 days</option>
                                        <option value="360">&gt;=360 days</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="request">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
  


    var fd2 = new FormData();
    var table ='';
        // fd2.append('supplies_name',$('select#supplies_name').val());
        // fd2.append('date_of_received',$('input#date_of_received').val());
        // fd2.append('no_of_items',$('input#no_of_items').val());

                $.ajax({
                    type: 'POST',
                    url: 'get_monitoring',
                    dataType: 'json',
                    data: fd2,
                    contentType: false,      
                    cache: false,            

                    processData: false       
                }).done(function (response) {
                    console.log(response);

                    table = $('#MonitoringTable').DataTable( {
                        "data": response.data,
                        "destroy": true,
                        "bInfo": false,
                        "bSortCellsTop": true,
                        "bLengthChange": false,
                        "columnDefs": [
                            { className: "sinceregistered", "targets": [ 16 ] }
                          ],
                        "columns": [
                            { "data": "AccountId" },
                            { "data": "SimpleRating" },
                            { "data": "DailyProfit" },
                            { "data": "WeeklyProfit" },
                            { "data": "MonthlyProfit" },
                            { "data": "Month_3_Profit" },
                            { "data": "Month_6_Profit" },
                            { "data": "Month_9_Profit" },
                            { "data": "TotalProfit" },
                            { "data": "Balance" },
                            { "data": "Equity" },
                            { "data": "CurrentTrades" },
                            { "data": "TotalTrades" },
                            { "data": "ActiveInvestors" },
                            { "data": "DailyTotalBalance" },
                            { "data": "DailyTotalEquity" },
                            { "data": "SinceRegisteredDays" }


                            // { "data": "ActiveFollowers" },
                            // { "data": "BrokerId" },
                            // { "data": "Currency" },

                        ]
                    } );

                        table.column( 2 ).visible( false );
                        table.column( 3 ).visible( false );
                        table.column( 4 ).visible( false );
                        table.column( 5 ).visible( false );
                        table.column( 6 ).visible( false );
                        table.column( 7 ).visible( false );
                        table.column( 8 ).visible( false );
                        $("td.sinceregistered").append(" day/s");


                });


    table = $('#MonitoringTable').DataTable();

    $('#accountnumber_project').on('keyup', function(){
        table.column(0).search(this.value).draw();
    });


$(document).ready(function() {
$('#example').dataTable( {
"aoColumns": [ 
null,
{ "fnRender": function ( oObj ) {
return oObj.aData[1] +' '+ "°C";
} },
{ "fnRender": function ( oObj ) {
return oObj.aData[2] +' '+ "hPa";
} }
],
"bProcessing": true,
"bServerSide": true,
"bInfo": true,
"sAjaxSource": "./server_processing.php"
} );
} );


// sample rating 

    var sampleRatingMin = '';
    var sampleRatingMax = '';
    $( "#simplerating" ).change(function() {
        var simpleRating = this.value;
        if ( simpleRating.includes('-') ) {
            var array = simpleRating.split('-');
            sampleRatingMin = array[0];
            sampleRatingMax = array[1];
            table.draw();
        }else{
            switch(simpleRating){
                case '>0':
                    sampleRatingMin = 0;
                    sampleRatingMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    sampleRatingMin = 200;
                    sampleRatingMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    sampleRatingMin = 200;
                    sampleRatingMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    sampleRatingMin = -10;
                    sampleRatingMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( sampleRatingMin, 10 );
            var max = parseInt( sampleRatingMax, 10 );
            var age = parseFloat( data[1] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
// sample rating end 


// daily profit 

    var dailyProfitMin = '';
    var dailtProfitMax = '';
    $( "#dailyprofit" ).change(function() {
        var dailtProfit = this.value;
        console.log(dailtProfit);
        if ( dailtProfit.includes('-') ) {
            var array = dailtProfit.split('-');
            dailyProfitMin = array[0];
            dailtProfitMax = array[1];
            table.draw();
        }else{
            switch(dailtProfit){
                case '>0':
                    dailyProfitMin = 0;
                    dailtProfitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    dailyProfitMin = 200;
                    dailtProfitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    dailyProfitMin = -10;
                    dailtProfitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( dailyProfitMin, 10 );
            var max = parseInt( dailtProfitMax, 10 );
            var age = parseFloat( data[2] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
// daily profit end 

// weekly profit

    var weeklyProfitMin = '';
    var weeklyProfitMax = '';
    $( "#weeklyprofit" ).change(function() {
        var weeklyprofit = this.value;
        console.log(weeklyprofit);
        if ( weeklyprofit.includes('-') ) {
            var array = weeklyprofit.split('-');
            weeklyProfitMin = array[0];
            weeklyProfitMax = array[1];
            table.draw();
        }else{
            switch(weeklyprofit){
                case '>0':
                    weeklyProfitMin = 0;
                    weeklyProfitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    weeklyProfitMin = 200;
                    weeklyProfitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    weeklyProfitMin = -1000;
                    weeklyProfitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( weeklyProfitMin, 10 );
            var max = parseInt( weeklyProfitMax, 10 );
            var age = parseFloat( data[3] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//weekly profit end 


// monthlyprofit

    var monthlyprofitMin = '';
    var monthlyprofitMax = '';
    $( "#monthlyprofit" ).change(function() {
        var monthlyprofit = this.value;
        console.log(monthlyprofit);
        if ( monthlyprofit.includes('-') ) {
            var array = monthlyprofit.split('-');
            monthlyprofitMin = array[0];
            monthlyprofitMax = array[1];
            table.draw();
        }else{
            switch(monthlyprofit){
                case '>0':
                    monthlyprofitMin = 0;
                    monthlyprofitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    monthlyprofitMin = 200;
                    monthlyprofitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    monthlyprofitMin = -1000;
                    monthlyprofitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( monthlyprofitMin, 10 );
            var max = parseInt( monthlyprofitMax, 10 );
            var age = parseFloat( data[4] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//monthlyprofit end 




// threemonthprofit

    var threemonthprofitMin = '';
    var threemonthprofitMax = '';
    $( "#threemonthprofit" ).change(function() {
        var threemonthprofit = this.value;
        console.log(threemonthprofit);
        if ( threemonthprofit.includes('-') ) {
            var array = threemonthprofit.split('-');
            threemonthprofitMin = array[0];
            threemonthprofitMax = array[1];
            table.draw();
        }else{
            switch(threemonthprofit){
                case '>0':
                    threemonthprofitMin = 0;
                    threemonthprofitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    threemonthprofitMin = 200;
                    threemonthprofitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    threemonthprofitMin = -1000;
                    threemonthprofitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( threemonthprofitMin, 10 );
            var max = parseInt( threemonthprofitMax, 10 );
            var age = parseFloat( data[5] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//threemonthprofit end 



// sixmonthprofit
    var sixmonthprofitMin = '';
    var sixmonthprofitMax = '';
    $( "#sixmonthprofit" ).change(function() {
        var sixmonthprofit = this.value;
        console.log(sixmonthprofit);
        if ( sixmonthprofit.includes('-') ) {
            var array = sixmonthprofit.split('-');
            sixmonthprofitMin = array[0];
            sixmonthprofitMax = array[1];
            table.draw();
        }else{
            switch(sixmonthprofit){
                case '>0':
                    sixmonthprofitMin = 0;
                    sixmonthprofitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    sixmonthprofitMin = 200;
                    sixmonthprofitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    sixmonthprofitMin = -1000;
                    sixmonthprofitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( sixmonthprofitMin, 10 );
            var max = parseInt( sixmonthprofitMax, 10 );
            var age = parseFloat( data[6] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//sixmonthprofit end 

// ninemonthprofit
    var ninemonthprofitMin = '';
    var ninemonthprofitMax = '';
    $( "#ninemonthprofit" ).change(function() {
        var ninemonthprofit = this.value;
        console.log(ninemonthprofit);
        if ( ninemonthprofit.includes('-') ) {
            var array = ninemonthprofit.split('-');
            ninemonthprofitMin = array[0];
            ninemonthprofitMax = array[1];
            table.draw();
        }else{
            switch(ninemonthprofit){
                case '>0':
                    ninemonthprofitMin = 0;
                    ninemonthprofitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    ninemonthprofitMin = 200;
                    ninemonthprofitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    ninemonthprofitMin = -1000;
                    ninemonthprofitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( ninemonthprofitMin, 10 );
            var max = parseInt( ninemonthprofitMax, 10 );
            var age = parseFloat( data[7] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//ninemonthprofit end 

// totalprofit
    var totalprofitMin = '';
    var totalprofitMax = '';
    $( "#totalprofit" ).change(function() {
        var totalprofit = this.value;
        console.log(totalprofit);
        if ( totalprofit.includes('-') ) {
            var array = totalprofit.split('-');
            totalprofitMin = array[0];
            totalprofitMax = array[1];
            table.draw();
        }else{
            switch(totalprofit){
                case '>0':
                    totalprofitMin = 0;
                    totalprofitMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    totalprofitMin = 200;
                    totalprofitMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    totalprofitMin = -1000;
                    totalprofitMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( totalprofitMin, 10 );
            var max = parseInt( totalprofitMax, 10 );
            var age = parseFloat( data[8] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//totalprofit end 



// balance
    var balanceMin = '';
    var balanceMax = '';
    $( "#balance" ).change(function() {
        var balance = this.value;
        console.log(balance);
        if ( balance.includes('-') ) {
            var array = balance.split('-');
            balanceMin = array[0];
            balanceMax = array[1];
            table.draw();
        }else{

            if ( balance.includes('>') ) {
                balanceMin = balance.replace('>', "");
                balanceMax = 1000000000;
                console.log(balanceMin);
                table.draw();
            }else{
                    balanceMin = -1000;
                    balanceMax = 1000000000;
                    console.log(2);
                    table.draw();
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( balanceMin, 10 );
            var max = parseInt( balanceMax, 10 );
            var age = parseFloat( data[9] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//balance end 

// equity
    var equityMin = '';
    var equityMax = '';
    $( "#equity" ).change(function() {
        var equity = this.value;
        console.log(equity);
        if ( equity.includes('-') ) {
            var array = equity.split('-');
            equityMin = array[0];
            equityMax = array[1];
            table.draw();
        }else{
            if ( equity.includes('>') ) {
                equityMin = equity.replace('>', "");
                equityMax = 1000000000;
                table.draw();
            }else{
                    equityMin = -1000;
                    equityMax = 1000000000;
                    console.log(2);
                    table.draw();
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( equityMin, 10 );
            var max = parseInt( equityMax, 10 );
            var age = parseFloat( data[10] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//equity end 

// currenttrades
    var currenttradesMin = '';
    var currenttradesMax = '';
    $( "#currenttrades" ).change(function() {
        var currenttrades = this.value;
        console.log(currenttrades);
        if ( currenttrades.includes('-') ) {
            var array = currenttrades.split('-');
            currenttradesMin = array[0];
            currenttradesMax = array[1];
            table.draw();
        }else{
            switch(currenttrades){
                case '>0':
                    currenttradesMin = 0;
                    currenttradesMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    currenttradesMin = 200;
                    currenttradesMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    currenttradesMin = -1000;
                    currenttradesMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( currenttradesMin, 10 );
            var max = parseInt( currenttradesMax, 10 );
            var age = parseFloat( data[11] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//currenttrades end 

// totaltrades
    var totaltradesMin = '';
    var totaltradesMax = '';
    $( "#totaltrades" ).change(function() {
        var totaltrades = this.value;
        console.log(totaltrades);
        if ( totaltrades.includes('-') ) {
            var array = totaltrades.split('-');
            totaltradesMin = array[0];
            totaltradesMax = array[1];
            table.draw();
        }else{
            switch(totaltrades){
                case '>0':
                    totaltradesMin = 0;
                    totaltradesMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    totaltradesMin = 200;
                    totaltradesMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    totaltradesMin = -1000;
                    totaltradesMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( totaltradesMin, 10 );
            var max = parseInt( totaltradesMax, 10 );
            var age = parseFloat( data[12] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
 
//totaltrades end 

// activeinvestor
    var activeinvestorMin = '';
    var activeinvestorMax = '';
    $( "#activeinvestor" ).change(function() {
        var activeinvestor = this.value;
        console.log(activeinvestor);
        if ( activeinvestor.includes('-') ) {
            var array = activeinvestor.split('-');
            activeinvestorMin = array[0];
            activeinvestorMax = array[1];
            table.draw();
        }else{
            switch(balance){
                case '>0':
                    activeinvestorMin = 0;
                    activeinvestorMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    activeinvestorMin = 200;
                    activeinvestorMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    activeinvestorMin = -1000;
                    activeinvestorMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( activeinvestorMin, 10 );
            var max = parseInt( activeinvestorMax, 10 );
            var age = parseFloat( data[13] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
//activeinvestor end 

// dailytotalbalance
    var dailytotalbalanceMin = '';
    var dailytotalbalanceMax = '';
    $( "#dailytotalbalance" ).change(function() {
        var dailytotalbalance = this.value;
        console.log(dailytotalbalance);
        if ( dailytotalbalance.includes('-') ) {
            var array = dailytotalbalance.split('-');
            dailytotalbalanceMin = array[0];
            dailytotalbalanceMax = array[1];
            table.draw();
        }else{
            switch(balance){
                case '>0':
                    dailytotalbalanceMin = 0;
                    dailytotalbalanceMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    dailytotalbalanceMin = 200;
                    dailytotalbalanceMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    dailytotalbalanceMin = -1000;
                    dailytotalbalanceMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( dailytotalbalanceMin, 10 );
            var max = parseInt( dailytotalbalanceMax, 10 );
            var age = parseFloat( data[14] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
//dailytotalbalance end 



// totaldailyequity
    var totaldailyequityMin = '';
    var totaldailyequityMax = '';
    $( "#totaldailyequity" ).change(function() {
        var totaldailyequity = this.value;
        console.log(totaldailyequity);
        if ( totaldailyequity.includes('-') ) {
            var array = totaldailyequity.split('-');
            totaldailyequityMin = array[0];
            totaldailyequityMax = array[1];
            table.draw();
        }else{
            switch(balance){
                case '>0':
                    totaldailyequityMin = 0;
                    totaldailyequityMax = 1000000000;
                    table.draw();
                    break;
                case '>200':
                    console.log('1');
                    totaldailyequityMin = 200;
                    totaldailyequityMax = 1000000000;
                    table.draw();
                    break;
                default :
                    console.log('1');
                    totaldailyequityMin = -1000;
                    totaldailyequityMax = 1000000000;
                    table.draw();
                    break;
            }
        }
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( totaldailyequityMin, 10 );
            var max = parseInt( totaldailyequityMax, 10 );
            var age = parseFloat( data[15] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
//totaldailyequity end .

// sinceregistered
    var sinceregisteredMin = '';
    var sinceregisteredMax = '';
    $( "#sinceregistered" ).change(function() {
        var sinceregistered = this.value;
        sinceregisteredMin = sinceregistered;
        sinceregisteredMax = 1000000000;
        table.draw();
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( sinceregisteredMin, 10 );
            var max = parseInt( sinceregisteredMax, 10 );
            var age = parseFloat( data[16] ) || 0; // use data for the age column
     
            if ( ( isNaN( min ) && isNaN( max ) ) || ( isNaN( min ) && age <= max ) || ( min <= age   && isNaN( max ) ) || ( min <= age   && age <= max ) )
            {
                return true;
            }
            return false;
        }
    );
//sinceregistered end 


$(document).on("click", ".btn_daily", function (e) {
    // <!-- start column 0-->
    // <!-- column 2-->
    e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 2 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 2, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 2, true );
    }
});
$(document).on("click", ".btn_weekly", function (e) {
    // <!-- column 3-->
    e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 3 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 3, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 3, true );
    }
});
$(document).on("click", ".btn_monthly", function (e) {
    // <!-- column 4-->
        e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 4 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 4, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 4, true );
    }
});
$(document).on("click", ".btn_3months", function (e) {
    // <!-- column 5-->
        e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 5 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 5, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 5, true );
    }
});

$(document).on("click", ".btn_6months", function (e) {
    // <!-- column 6-->
        e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 6 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis(6, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 6, true );
    }
});
$(document).on("click", ".btn_9months", function (e) {
    // <!-- column 7-->
        e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 7 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis(7, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis(7, true );
    }
});
$(document).on("click", ".btn_total", function (e) {
    // <!-- column 8-->
        e.preventDefault();
    var table = $('#MonitoringTable').DataTable();
    var column = table.column( 8 );
    column.visible( ! column.visible() );
    if($( this ).hasClass( "custom_hoverfilters" )){
        $( this ).removeClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis(8, false );
    }else{
        $(this ).addClass("custom_hoverfilters" );
        // maintable.fnSetColumnVis( 8, true );
    }
});

$( document ).ready(function() {


    // column.visible( ! column.visible() );

    // var column = table.column( 3 );
    // column.visible( ! column.visible() );

    // var column = table.column( 4 );
    // column.visible( ! column.visible() );

    // var column = table.column( 5 );
    // column.visible( ! column.visible() );

    // var column = table.column( 6 );
    // column.visible( ! column.visible() );

    // var column = table.column( 7 );
    // column.visible( ! column.visible() );

    // var column = table.column( 8 );
    // column.visible( ! column.visible() );
});


</script>