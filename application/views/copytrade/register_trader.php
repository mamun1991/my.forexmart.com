
<style>


    #fc-offer {
        border: 1px solid #e6e6e6;
        height: auto !important;
        max-height: 280px;
        overflow: auto;
        padding: 10px;
        font-size: 12px;
        width: 100%;
    }
    .content-head-block {
        background-color: #136fd7;
        color: #FFF;
        padding-left: 15px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #fc-offer p{
        font-style: normal;
    }
    #fc-offer li{
        font-size: 15px;
    }
    .btn-main {
        color: #fff;
        background-color: #3d83d2;
        /*border-color: #db3e2b;*/
    }
    .fc-agrr-body{
        margin-bottom: 30px;
    }

    /*Modal*/
    .modal-custom{
        /*min-height: 100%;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*width: 100%;*/
        /*left: 0;*/
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
    }
    .modal-custom .modal-content{
        padding: 15px;
        line-height: 1.5;
    }
    .modal-custom .modal-header, .modal-custom .modal-footer{
        border:0;
        padding:0;
    }
    .modal-custom .close{
        /*position: absolute;*/
        top: 10px;
        right: 10px;
        color: red;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid red;
    }
    .modal-custom .modal-footer{
        text-align:center;
    }
    .img-center{
        display: block;
        margin:0 auto;
    }
    .img-info-modal{
        width:auto;
        height: 86px;
    }
    .btn-form{
        min-width: 150px;
        height:40px;
        letter-spacing: 1px;
    }
    
    @media only screen and (min-width: 1001px) and (max-width: 1015px)  {
 .main-tab li a{font-size:16px !important }

}
</style>
<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li class="active">
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('reg_trader_01'); ?></a>
                </li>

                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('reg_trader_02'); ?></a>
                </li>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('reg_trader_03'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('reg_trader_04'); ?></a>
                </li>
                <div class="clearfix"></div>
        </div>

        <div class="tab-content clearfix">
            <div class="myproject-trader-reg clearfix" >
                <h3><?= lang('reg_trader_05'); ?></h3>
                <!-- <div class="pull-right be-center">
                     <button class="btn btn-investing" id="forexcopy-master" type="button">Register as a ForexCopy Trader</button>
                 </div>-->
                <div class="row">
                    <div class="col-md-2 col-sm-1"></div>
                    <div class="col-md-8 col-sm-10 col-xs-12">
                        <form action="" method="post" id="master_reg_form">
                            <div class="well well-form-text">
                                <input type="hidden" name="is_register" value="1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-head">
                                            <?= lang('reg_trader_06'); ?>
                                        </div>
                                        <div class="content-delimetr"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group one-elem one-elem-top">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                 <span class="star">*</span>&nbsp;<?= lang('reg_trader_07'); ?></span>
                                                <input type="text" name="project_name" id ="project_name" class="form-control" maxlength="50"  value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group one-elem one-elem-top">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <span class="hidden-xs"><?= lang('reg_trader_08'); ?> </span>
                                                    <span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_09'); ?></span>
                                                    <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_10'); ?>"></i>
                                                </span>
                                                <select name="notify_lang" class="selectpicker form-control languagdropdowntextselectbox" data-live-search="false" data-width="100%" style="display: none;">
                                                    <option value="en" selected="">English</option>
                                                    <option value="ru">Русский</option>
                                                </select>
                                                <div class="btn-group bootstrap-select input-group-btn form-control" style="width: 100%;">
                                                    <button id="languagdropdowntextbutton" type="button" class="btn dropdown-toggle form-control selectpicker btn-default" data-toggle="dropdown" title="English">
                                                        <span class="filter-option pull-left">English</span>&nbsp;<span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu open">
                                                       <!-- <div class="bs-searchbox">
                                                            <input type="text" class="form-control" autocomplete="off">
                                                        </div>-->
                                                        <ul class="dropdown-menu inner selectpicker" role="menu">
                                                            <li data-original-index="0" class="selected languagdropdowntext"><a tabindex="0" class="" data-normalized-text="<span class=&quot;text&quot;>English</span>" data-tokens="null">
                                                                    <span class="text dropdownlanspan" rel="en">English</span><span class="glyphicon glyphicon-ok check-mark"></span></a>
                                                            </li>
                                                            <li data-original-index="1"><a tabindex="0" class="languagdropdowntext" data-normalized-text="<span class=&quot;text&quot;>Русский</span>" data-tokens="null">
                                                                    <span class="text dropdownlanspan" rel="ru" >Русский</span><span class="glyphicon glyphicon-ok check-mark"></span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="well well-form-text">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-head">
                                            <span class="star">*</span>&nbsp;<?= lang('reg_trader_11'); ?>
                                        </div>
                                        <div class="content-delimetr"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <!--<span class="input-group-addon">Who pays commission:<i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Select who should pay commission for copying your trades: Copytrading followers or the company. You can make your service free of charge for the Copytrading followers and receive 0.5 pip commission for 1 lot closed by your followers from the company."></i></span>-->
                                                       <span class="input-group-addon"><?= lang('reg_trader_12'); ?> <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_13'); ?>"></i></span>

                                                       <input type="text" name="commission_payer" class="form-control" value="Investor" data-live-search="true" data-width="100%" readonly>
                                                       <!--<select name="commission_payer" class="form-control" data-live-search="true" data-width="100%">
                                                            <option value="0">Follower</option>
                                                           <!-- <option value="1">Company</option>-->
                                                      <!-- </select>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row" style="">
                                             <div class="col-md-12">

                                                 <div class="form-group one-elem one-elem-top">
                                                     <div class="input-group">
                                                         <span class="input-group-addon">
                                                             <span class="hidden-xs">Commission Type</span>
                                                             <span class="hidden-lg hidden-md hidden-sm"> </span><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title=""></i>
                                                             </span>
                                                             <select name="commission_type" id = "commission_type" class="form-control" data-live-search="true" data-width="100%">
                                                             <option value="1" selected>Per trade</option>
                                                             <option value="2">Per Lot</option>
                                                             <option value="3">Percent from profit</option>
                                                             <option value="4">Per day</option>
                                                             <option value="10">Per any lot</option>
                                                             </select>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>-->


                                        <div class="row commission_copier_payer" style="">
                                            <div class="col-md-12">

                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <span class="hidden-xs"><?= lang('reg_trader_14'); ?> </span>
                                                            <span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_15'); ?></span><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_38'); ?>"></i>USD
                                                        </span>
                                                        <input type="number" min="1" step="any" name="conditions_values_1" class="form-control numeric"  onfocus="value='';" value="" placeholder="<?= lang('reg_trader_25'); ?>e">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row commission_copier_payer" style="">
                                            <div class="col-md-12">

                                                <div class="text-center hidden-lg hidden-md hidden-sm"><strong><?= lang('reg_trader_16'); ?></strong></div>
                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <span class="hidden-xs"><?= lang('reg_trader_17'); ?>  </span>
                                                            <span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_18'); ?></span><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_37'); ?>"></i>USD
                                                        </span>
                                                        <input type="number" min="1" step="any" name="conditions_values_2" class="form-control numeric" onfocus="value='';"  value="" placeholder="<?= lang('reg_trader_25'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row commission_copier_payer" style="">
                                            <div class="col-md-12">

                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <span class="hidden-xs"><?= lang('reg_trader_19'); ?></span>
                                                            <span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_20'); ?></span><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_21'); ?>"></i>USD
                                                        </span>
                                                        <input type="number" min="1" step="any" name="conditions_values_10" class="form-control numeric" onfocus="value='';" value="" placeholder="<?= lang('reg_trader_25'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row commission_copier_payer" style="">
                                            <div class="col-md-12">

                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <span class="hidden-xs"><?= lang('reg_trader_22'); ?></span>
                                                            <span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_23'); ?></span><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_24'); ?>"></i>%
                                                            </span>
                                                        <select name="conditions_values_3" class="form-control" data-live-search="true" data-width="100%">
                                                            <option value="Do not use"><?= lang('reg_trader_25'); ?></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="12">12</option>
                                                            <option value="14">14</option>
                                                            <option value="16">16</option>
                                                            <option value="18">18</option>
                                                            <option value="20">20</option>
                                                            <option value="25">25</option>
                                                            <option value="30">30</option>
                                                            <option value="35">35</option>
                                                            <option value="40">40</option>
                                                            <option value="45">45</option>
                                                            <option value="50">50</option>
                                                            <option value="55">55</option>
                                                            <option value="60">60</option>
                                                            <option value="65">65</option>
                                                            <option value="70">70</option>
                                                            <option value="75">75</option>
                                                            <option value="80">80</option>
                                                            <option value="85">85</option>
                                                            <option value="90">90</option>
                                                            <option value="95">95</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row commission_copier_payer" style="">
                                            <div class="col-md-12">

                                                <div class="form-group one-elem one-elem-top">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <span class="hidden-xs"><?= lang('reg_trader_26'); ?></span><span class="hidden-lg hidden-md hidden-sm"><?= lang('reg_trader_27'); ?> </span>
                                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('reg_trader_28'); ?>">
                                                            </i>USD
                                                        </span>
                                                        <input type="number" min="1" step="any" name="conditions_values_4" class="form-control numeric" onfocus="value='';" value="" placeholder="<?= lang('reg_trader_25'); ?>Do not use">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="content-delimetr"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <input type="button" class="btn btn-main" id = "master_register" value="<?= lang('reg_trader_30'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 col-sm-1"></div>
                </div>


            </div>
        </div>
    </div>
</div>
    <div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-form" data-dismiss="modal"><?= lang('reg_trader_29'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" id="confirmModalclosemanual" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title conf-modal-title text-center"></h4>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center conf-modal-desc"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-success" id ='confirm' value="<?= lang('reg_trader_31'); ?>">
                </div>
            </div>
        </div>
    </div>






<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript">
    var url = '<?php echo base_url();?>';


    $(document).ready(function(){

        jQuery(".numeric").on("keypress keyup blur",function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        jQuery(".numeric").on("blur",function (event) {
            var value=$(this).val().replace(/[^0-9.,]*/g, '');
            value=value.replace(/\.{2,}/g, '.');
            value=value.replace(/\.,/g, ',');
            value=value.replace(/\,\./g, ',');
            value=value.replace(/\,{2,}/g, ',');
            value=value.replace(/\.[0-9]+\./g, '.');
            $(this).val(value)
        });


        jQuery(".numeric").on("cut copy paste",function (event) {
            event.preventDefault();
        });

        $('[data-toggle="tooltip"]').tooltip();

        $("#commission_type").on('change', function() {
            var type = $(this).val();
            var type_value = '';
            switch(type) {

                case '1':
                    type_value = "per trade";
                    break;
                case '2':
                    type_value = "per lot";
                    break;
                case '3':
                    type_value = "per percent from profit";
                    break;
                case '4':
                    type_value = "per day";
                    break;
                case '10':
                    type_value = "per any lot";
                    break;
            }

            $('#comm_type').html(type_value)
        });

    });


var maseter_register_success=false;
$(document).on("click","#master_register",function(e){
        var master = '<?= $_SESSION['account_number']; ?>';
         maseter_register_success=false;

// option value="0">Investor</option> <option value="1">Company</option> -->

        var is_error = true;
        var  message = "<?= lang('reg_trader_32'); ?>";
        var commision_type=$("input[name=commission_payer]").val();

      //  if( $("select[name=commission_payer]").val() != 1)
      
     // console.log(commision_type,"------------------------------------->");
      
      
        if(!commision_type)
        {
                       
                

                if (($('input[name="conditions_values_1"]').val() == 'Do not use' || !$.trim($('input[name="conditions_values_1"]').val()).length) &&
                    ($('input[name="conditions_values_2"]').val() == 'Do not use' || !$.trim($('input[name="conditions_values_2"]').val()).length) &&
                    ($('select[name="conditions_values_3"]').val() == 'Do not use' || !$.trim($('select[name="conditions_values_3"]').val()).length) &&
                    ($('input[name="conditions_values_4"]').val() == 'Do not use' || !$.trim($('input[name="conditions_values_4"]').val()).length) &&
                    ($('input[name="conditions_values_10"]').val() == 'Do not use' || !$.trim($('input[name="conditions_values_10"]').val()).length))
                {
                    is_error = false;
                    
                     //console.log(is_error,"---------------____---------------------->");
                }else{

                    var count = 0;
                    if($('input[name="conditions_values_1"]').val() == 'Do not use'){

                    }else{
                        if ($.trim($('input[name="conditions_values_1"]').val()).length){
                            count  = count +  1;
                        }
                    }
                    if($('input[name="conditions_values_2"]').val() == 'Do not use'){

                    }else{
                        if ($.trim($('input[name="conditions_values_2"]').val()).length){
                            count  = count +  1;
                        }
                    }
                    if ($('select[name="conditions_values_3"]').val() != 'Do not use'){
                        count  = count +  1;
                    }

                    if($('input[name="conditions_values_4"]').val() == 'Do not use'){

                    }else{
                        if ($.trim($('input[name="conditions_values_4"]').val()).length){
                            count  = count +  1;
                        }
                    }

                    if($('input[name="conditions_values_10"]').val() == 'Do not use'){

                    }else{
                       // console.log("============================>");
                        if ($.trim($('input[name="conditions_values_10"]').val()).length){
                            count  = count +  1;
                        }
                    }



                    //console.log($('input[name="conditions_values_10"]').val(),"--------------------->");



                    if(count > 1){
                        is_error = false;
                    }

                }

        }
        
    //     console.log(is_error,"---------------____---------------------->");
        
        if(!$.trim($('#project_name').val()).length){
            message = "<?= lang('reg_trader_35'); ?>"
            is_error = false;
        }
 

        if(is_error){
            
             
            $.ajax({
                type: 'POST',
                url: url + 'copytrade/register_master',
                data: $('#master_reg_form').serialize(),
                beforeSend: function () {
                    $('#loader-holder').show();
                }
            }).done(function (response) {
                $('#loader-holder').hide();
                if (response.success) {
                    $('#master_register').attr('disabled',true);
                    $('.conf-modal-title').html("<?= lang('reg_trader_33'); ?>");
                    $('.conf-modal-desc').html("<?= lang('reg_trader_34'); ?>");
                    $('#confirmModal')
                        .modal({ backdrop: 'static', keyboard: false })
                        .on('click', '#confirm', function (e) {
                            window.location.href = url+ 'copytrade/monitor_user/' + master;
                        });
                      maseter_register_success=master;   
                        
                } else {
                    $('#m_message').html(response.errorMsg);
                    $('#cpy_modal').modal('show');
                }


            });
        }else{
            // console.log(message,"------------------------------------->");
            $('#m_message').html(message);
            $('#cpy_modal').modal('show');
        }

        e.stopImmediatePropagation();
    });




$(document).on("click","#confirmModalclosemanual",function(){
    
    if(maseter_register_success){
         window.location.href = url+ 'copytrade/monitor_user/' + maseter_register_success;
    }
});

$(document).on("click",".languagdropdowntext",function(){
    
    
    var lancode=$(this).find('.dropdownlanspan').attr('rel');   
     
    var english='<span class="filter-option pull-left">English</span>&nbsp;<span class="caret"></span>';
    var russian='<span class="filter-option pull-left">Русский</span>&nbsp;<span class="caret"></span>';
    
    
setTimeout(function(){  
    
    
                if(lancode=="ru")
                {
                    $("#languagdropdowntextbutton").html(russian);
                }
                else if(lancode=="en")
                {
                    $("#languagdropdowntextbutton").html(english);
                }    


            $(".languagdropdowntextselectbox option").each(function() {
                var optionval=$(this).val();
                 var attr_option=$(this).attr('selected');


                if (typeof attr_option !== "undefined") {
                  $(this).removeAttr('selected');
                } 
                               

// console.log(attr_option,"===========>",optionval,"----------->",lancode);

                if(optionval==lancode)
                {        
                    $(this).attr("selected","selected");
                } 

            });
            
            
  }, 200);   
  
  
  
});



</script>