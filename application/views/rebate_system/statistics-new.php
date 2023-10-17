
<div role="tabpanel" class="tab-pane active" id="tab3">
    <div class="row">
        <div class="col-md-12 rebate-child-container">
            <div class="date-statistics">
                <label><?= lang('from'); ?></label>
                <div id="sandbox-container" class="rebate-datepicker">
                    <input id="from" min='2015-01-01' placeholder="Year-month-day" value="<?= date('Y-m-d', strtotime(' -1 day'));?>"  max='<?php echo date("Y-m-d");?>' class="form-control" type="text" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" required autofocus autocomplete="nope">        
                </div>
            </div>
           
            
            <div class="date-statistics">
                <label><?= lang('to'); ?></label>
                <div id="sandbox-container" class="rebate-datepicker">
                    <input id="to" min='2015-01-01' placeholder="Year-month-day" value="<?php echo date("Y-m-d");?>"   max='<?php echo date("Y-m-d");?>' class="form-control form-input" type="text" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" required autofocus autocomplete="nope">
                </div>
            </div>
            <a class="rebate-showbutton"><button id="show" class="btn-login"><?= lang('show'); ?></button></a>
        </div>
        <div class="col-sm-12 rebate-child-container">
            <div class="rebate-accountnumbers">
                <label class="rebate-label"><?= lang('accounts'); ?></label>
                <select id="account_number" class="dropdown-account-numbers form-control round-0">
                    <option>All</option>
                    <?php  if($referrals){
                        foreach($referrals as $d){  ?>
                            <option value="<?=$d['account_number']?>"><?=$d['account_number']?></option>
                        <?php } }?>
                </select>
            </div>
            <div class="rebate-system-checkbox">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-centered">
            <div class="graph-holder" id="container">
                <p><?= lang('reb_statistics'); ?></p>
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
    var frz_ip="<?= IPLoc::frz(true)?>";

  //  $(document).ready(function(){

//        var dateNow = moment().format('YYYY-MM-DD');
//        var startDate = new Date();
//        var setMoment = moment(startDate);
//        var endDateMoment = setMoment;
//        $('#from').val( endDateMoment.subtract(1, 'months').format('YYYY-MM-DD'));
//        $('#to').val(dateNow);

   // });

 




    $(document).on("click","#show",function(){
       
         var to = $("#to").val();
        var from = $("#from").val();
        
        if(from.length<1 || to.length<1)
        {
             checkDateTime('ajax');
             
        }else{
            showDataMethod();
        }
       
    });

function showDataMethod(){
    
       $("#loader-holder").show();
        var account_number = $("#account_number").val();
        var to = $("#to").val();
        var from = $("#from").val();
         ajaxView(account_number,to,from);
        
    
}


    function ajaxView(account_number,to,from){
         
               
        $.post(base_url+"rebate_systems_new/statisticsData",{account_number:account_number,to:to,from:from},function(data){
            console.log(data);
            viewGrap(data);
            $("#loader-holder").hide();
        });
        
        
    }

    $(function () {
        ajaxView("All","<?=date('Y-m-d h:i:s')?>","2015-01-01 00:00:00");
        //  viewGrap(dates);


    });


    function viewGrap(datas){
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?= lang("reb_sys_statistics"); ?>'
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
                    text: '<?= lang("oth_com_20_15"); ?>'
                }
            },
            yAxis: {
                title: {
                    text: '<?= lang("reb_amount"); ?>'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>rebate</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.2f}'
            },

            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },

            series: [{
                name: '<?= lang("reb_statistics"); ?>',
                data: eval(datas)
            } ]
        });
    }
    
    


$( function() {
		$( "#from" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        dateFormat: 'yy-mm-dd',
                         maxDate: new Date(),
                        minDate: new Date(2015, 01, 01), 

		});
                
                $( "#to" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        maxDate: new Date(),
                        minDate: new Date(2015, 01, 01),
		});
	} );


 $(document).on("blur","#from",function(){
   
    checkDateTime();
    
 });
 
  $(document).on("blur","#to",function(){
   
    checkDateTime();
    
 });
    
     
 function checkDateTime(return_type=false){
 

var action_request=false;

var from_date=$("#from").val();
var to_date=$("#to").val();
var cur_date= new Date();
var start_date= "2015-01-01";


var my_f_date = new Date(from_date);
var my_t_date = new Date(to_date);
var start_s_date= new Date(start_date);






            if(from_date.length<1)
            {
               $("#from").val(formateDate(cur_date)); 
            }    
            else if(to_date.length<1)
            {
               $("#to").val(formateDate(cur_date)); 
            } 
            else if(!moment(from_date, "YYYY-MM-DD").isValid())
            {
                 $("#from").val(formateDate(cur_date));
            }
            else if(!moment(to_date, "YYYY-MM-DD").isValid())
            {
                  $("#to").val(formateDate(cur_date));
            }
            else if(my_t_date>cur_date)
            {
                 $("#to").val(formateDate(cur_date));

            }else if(my_f_date<start_s_date)
            {
                 $("#from").val(formateDate(start_s_date));

            }
            else if(my_f_date>my_t_date)
            {
                $("#from").val(formateDate(my_t_date));
                $("#to").val(formateDate(my_f_date));
            }
            
            
     // console.log(my_f_date>my_t_date,"====================>",my_f_date,"---->",my_t_date);      
             
     if(return_type=="ajax"){
         showDataMethod();
     }           
 
 }
 
 
function formateDate(raw_date){

var formate_date = moment(raw_date).format('YYYY-MM-DD');

return formate_date;

}    
    
    
</script>