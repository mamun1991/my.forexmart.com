
<div class="modal fade" id="motnhlyReportsPermissionModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button"  id ="motnhlyReportsPermissionModalDismis" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title">
                                <?=lang('esf_4');?>
                </h4>
            </div>
            <div class="modal-body modal-show-body">
                <div class="row">
                    <div class="col-md-12" id="container_month_report_confirm_box"> 
                        
                         <label class="container_month_report_confirm">
                            <b class="activeReportTitle"> <?=lang('esf_5');?></b>
                            <input  class="activeReport" value="1" type="radio" checked="checked" name="radio">
                            <span class="checkmark"></span>
                          </label>
                          <label class="container_month_report_confirm">
                              <b class="inActiveReportTitle"> <?=lang('esf_6');?></b>
                              <input class="inActiveReport" value="0" type="radio" name="radio">
                            <span class="checkmark"></span>
                          </label>
                          
                    </div>
                    <div class="col-md-12" id="container_month_report_confirm_box_success"> 
                        <p><?=lang('esf_7');?></p>
                    </div>
                    <div class="col-md-12" id="container_month_report_confirm_box_failed"> 
                         <p> <?=lang('esf_8');?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer round-0">
                <button type="button"  data-dismiss="modal" id="cancel_month_reports" class="btn-green-default">
                    <?=lang('esf_9');?>
                </button>
                <button type="button" id="update_month_reports" class="btn-green">
                    <?=lang('esf_2');?>
                </button>
            </div>
        </div>
    </div>
</div>


<style>
.activeReportTitle{
      color: #2988CA;
    font-weight: 600;   
    }    
.inActiveReportTitle{
      color: red;
    font-weight: 600; 
    }  

#container_month_report_confirm_box{display: block}        
#container_month_report_confirm_box_success{display: none}    
#container_month_report_confirm_box_failed{display: none}    
#container_month_report_confirm_box_success p{color: green;font-weight: bold; text-align: center}
#container_month_report_confirm_box_failed p{color: red;font-weight: bold ; text-align: center}
    
#motnhlyReportsPermissionModal .modal-show-title {
    color: currentcolor;
    font-weight: bold;
    text-align: center;
}
</style>    


<style>
/* The container */
.container_month_report_confirm {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container_month_report_confirm input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container_month_report_confirm:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container_month_report_confirm input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container_month_report_confirm input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container_month_report_confirm .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>