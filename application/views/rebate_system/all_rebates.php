<?php //echo '<pre>';
//print_r($_SESSION);
?>

<style>
    
select.project-status {
    float: left;
    width: 50%;
}
button.btn-update-project {
    float: right;
}
#new_value::placeholder {
  color: gray;
  opacity: 0.5; /* Firefox */
}

</style>

<div role="tabpanel" class="tab-pane active" id="tab1">
    <div class="row">
        <div class="col-sm-12 rebate-child-container">
            <a href="" data-toggle="modal" data-target="#successful-registration-bonus" class="login-external" id="create_affiliate"><button class="btn-login"><?= lang('reb_txt_8'); ?></button></a>
        </div>
    </div>
    <div class="rebate-system-table table-responsive">
        <?php if(!empty($errorMsg)){ ?>
            <div class="alert <?= $hasError ? "alert-danger" : "alert-success"; ?>" role="alert" style="margin-top: 10px;">
              <?= $errorMsg; ?>
            </div>
        <?php } ?>


        <table class="table table-striped part-table" id="tbl-get-projects">
            <thead>
            <tr>
                <th>#</th><th><?= lang('reb_txt_9'); ?></th><th>Rebate (%)</th><th>Status</th> <th ><?= lang('reb_txt_13'); ?></th>
            </tr>
            </thead>
            <tbody id="result"></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?= lang('reb_txt_18'); ?></h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-horizontal rebate_form">
                <input type="hidden" id="rebate" name="rebate" value="0">
                <p><?php echo validation_errors(); ?></p>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('reb_txt_9'); ?></label>
                        <div class="col-sm-9 project_name_error">
                            <input maxlength="16" type="text" class="form-control project_name" id="project_name" name="project_name" placeholder="<?= lang('reb_txt_9'); ?>">
                            <span class="red"></span>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Rebate (%)</label>
                        <div class="col-sm-9 new_value_error">
                                <input type="number" class=" form-control new_value" onkeyup='this.value = rebateChange(this.value, 1, <?= $max_value; ?>)' id="new_value" name="new_value" min="1" max="<?=$max_value;?>" placeholder="<?=$rebate_msg;?>" list="numbers">
                                <datalist id="numbers">
                                    <?= $list_option; ?>
                                </datalist>
                                <span class="red" id="rebet_percen_error_msg" style="display: none">  </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" id="submit_rebate_system" class="btn  btn-login"><?= lang('reb_txt_17'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="msg" class="modal fade" id="successful-registration-bonus" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content bonus-modal-container ex-modal-content round-0">
            <div class="modal-header ex-modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-sub ex-modal-title"><?= lang('reb_txt_18'); ?></h4>
            </div>
            <div class="modal-body">
                <div id="msg_body"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var max_rebate = '<?= $max_value; ?>';
    
     var min_percent_mgs='Minimum rebate is 1 %';
     var max_percent_mgs='Maximum rebate is '+max_rebate+" %";
    
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    $(document).ready(function () {

        $(document).on('click','.part-li',function () {
            $('.part-li').each(function () {
                var tbHide = $(this).data('tabId');
                $('#'+tbHide).hide();
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            var tabShow = $(this).data('tabId');
            $('#'+tabShow).show();
        });
        $(document).on('click', '#submit_rebate_system', function (e) {
            e.preventDefault();
            var rebate_submit = false;
            var project_name = $('.project_name').val();
            var new_value = $('#new_value').val();
            $('.pull_name').hide();

            if (project_name != '') {
                $('.pull_name').hide();
                rebate_submit = true;
            } else {
                $('.pull_name').hide();
                $('.project_name_error').append('<span class="red pull_name">Please fill in.</span>');
                rebate_submit = false;
                return false;
            }
            
            
            if(newRebeatValueValidation())
            {                 
                rebate_submit = true;
            }else{
                 rebate_submit = false;
                return false;
            }    
                        
            if ($('.new_value').hasClass('not-valid')) {
                $("#error_msg").show();
                rebate_submit = false;
                return false;
            }
            if (rebate_submit == true) {
                $(".rebate_form").submit();
            }
        });

    });



    $(document).on("blur", "#new_value", function () {
        var object=$(this);
        var new_rebate = $(this).val();      
        newRebeatValueValidation();
          
    });
    
function newRebeatValueValidation()
{ 
        var new_rebate = $("#new_value").val();      
         $("#rebet_percen_error_msg").hide();
         $("#new_value").removeClass('not-valid');
         var return_status=false;
//console.log("--->[",new_rebate,"]<---")         ;
          if(new_rebate=="")
          {
               errorMagShowRebetPercen(min_percent_mgs,"rebet_percen_error_msg","new_value");
          }else{
              
                new_rebate= new_rebate.replace(/\s/g,'');
                new_rebate= parseFloat(new_rebate);
//console.log(new_rebate<parseFloat(1),"=========>",new_rebate);

                if(new_rebate<parseFloat(1))
               {
                    errorMagShowRebetPercen(min_percent_mgs,"rebet_percen_error_msg","new_value");
               }
               else if(new_rebate>parseFloat(max_rebate))
               {
                   errorMagShowRebetPercen(max_percent_mgs,"rebet_percen_error_msg","new_value")
               }else{
                   return_status=true;
               }    
              
          }
          
          return return_status;
}
    
    
function errorMagShowRebetPercen(mgs,error_span_id,object_id)
{
     $("#"+error_span_id).show();
    $("#"+error_span_id).html(mgs);
     $("#"+object_id).addClass('not-valid');
}

    


        function rebateChange(value, min, max) {
            if (parseInt(value) < 1 || isNaN(value))
                return 1;
            else if (parseInt(value) > max)
                return max_percent_mgs;
            else return value;
        }



</script>
<style> #error_msg{display: none;color: red;}   #msg_body{ text-align: center;  font-weight: bold;  margin-right: 8px;}  .red{    color: red;    } </style>

<script>
    $(document).ready(function () {
        var act = 0;
        GetRebates('get-projects',0);

        function GetRebates( recordType, pageNum){
            console.log(recordType);
            var container = "table#tbl-"+recordType+" tbody#result", data = 'recType='+recordType+'&page='+pageNum, urL ="rebate-systems-new/useNewRebateAPI";
            if(recordType==='update-project'){
                var proj = $("#project-status" +pageNum +" option:selected"), prj = $("select#project-status"+pageNum),
                evnt = proj.val(), pr= $(".project-periodicity option:selected").val(), pName = prj.data('pname'), rVal = prj.data('rvalue'), rType = prj.data("rtype")  ;
                data= { recType:recordType, st: evnt , periodicity: pr , rebateVal:rVal,rebateNewVal:$('#pip'+pageNum).val() ,rType:rType, rsId: pageNum , project_name: pName} ;
                urL ="rebate_systems_new/updateProject";
                console.log(data);
//                $(prj).css('border','1px solid red');
            }
            $.ajax({
                type: "post",
                url: base_url+urL,
                data: data,
                dataType: 'json',
                beforeSend: function () {     $('#loader-holder').show();     },
                success: function(x) {
                    console.log(x);
                    if(x.hasError){
                        $(container).html("<tr><td colspan='6' style='text-align: center;'>Internal Error. Please contact support.</td></tr>");
                    }else{
                        if(recordType==='update-project'){
                            console.log(x.errorMsg);
                            $("#msg_body").text(x.errorMsg);
                            $("#msg").modal('show');
                            if(x.hasError===false){ GetRebates('get-projects',0); }else{   $("#tr-"+pageNum).css('border','1px solid red'); }

                        }else{

                            $(container).html(x.result['result']);
                            $("#"+recordType+"-showing").html(x.result['showing']);
                            $("#"+recordType+"-pagination").html(x.result['pagination']);
                            var pg = pageNum<=1? 1 : pageNum;

                            $('ul.tab-pagination li.latest-page').each(function(){        $(this).removeClass('active');   });
                            $("ul.tab-pagination").find("[data-ci-pagination-page='" + pg + "']").closest('li').addClass('active');
                            $('table#tbl-get-projects #result select').each(function () {
                                if( $(this).hasClass('project_status') ){
                                    act = act +1;
                                }
                            });
                            console.log(act);
                        }
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
        $(document).on('click', 'button.btn-update-project', function () {
            var rsId=$(this).data('rsid');
            var active = 0;
            $("#result select.project_status").each(function () {
                if ($(this).val() === 1) {
                    active++;
                }
            });
            console.log(active);
            if (active > 1) {
                $("#msg_body").text("Only one project can be active");
                $("#msg").modal('show');
//                $('#status' + id).val(0);
            } else {
                GetRebates('update-project',rsId);
            }
            active = 0;

        });
    });
</script>
