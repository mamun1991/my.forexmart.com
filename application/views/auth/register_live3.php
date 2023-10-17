<div class="reg-form-holder1">
    <div class="container1">
        <div class="row">
            <div class="step-tab-holder1" style="margin-left: 105px;" >
                <ul>

                    <li class="tabs-personal toptab color">
                        <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="50"/> <?=lang('int_reg_06')?>

                    </li>
                    <li>
                        <img src="<?= $this->template->Images() ?>nxt.png" class="img-reponsive" width="50"/>
                    </li>

                    <li class="tabs-employment toptab">
                        <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="50"/> <?=lang('int_reg_08')?>

                    </li>
                    <li>
                        <img src="<?= $this->template->Images() ?>nxt.png" class="img-reponsive" width="50"/>
                    </li>
                    <li class="tabs-title3 toptab">
                        <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="50"/> <?=lang('int_reg_07')?>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <form method="POST" id="register-live" enctype="multipart/form-data" class="uploadimage">
                <div class="tab-content" style="margin-top: 30px;">


                    <div role="tabpanel" class="tab-pane active" id="personal">
                        <div class="col-lg-12 col-md-12 col-centered">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>

                                    <div class="col-sm-6">
                                        <label><?=lang('int_reg_06')?></label>
                                    </div>
                                </div>


                                <!--- -->
                                <?php
                                $address=$user_data['address']!=''?$user_data['address']:'';
                                $city=$user_data['city']!=''?$user_data['city']:'';
                                $state=$user_data['state']!=''?$user_data['state']:'';
                                $postal=$user_data['zip_code']!=''?$user_data['zip_code']:'';
                                $phone=$user_data['telephone1']!=''?$user_data['telephone1']:"+".$calling_code;
                                $date_of_birth = '';
                                if(IPLoc::Office()){
                                    $date_of_birth=$user_data['dob'];
                                }

                               // $bday=$user_data['zip_code']!=''?$user_data['zip_code']:'';
                                ?>

                                <div class="form-group">
                                    <label for="street" class="col-sm-3 control-label"><?= (lang('int_reg_50')!='')? lang('int_reg_50'): 'Street Address'; ?><cite
                                            class="req">*</cite></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 required" id="street" name="street" placeholder="<?= (lang('int_reg_50')!='')? lang('int_reg_50'): 'Street Address'; ?>" value="<?=$address;?>">
                                    </div>
                                    <div class="error_p col-sm-3" id="error_street"><?php echo form_error('street'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label"><?=(lang('int_reg_53')!='')?lang('int_reg_53'):'City';?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 required" id="city" name="city" placeholder="<?=(lang('int_reg_53')!='')?lang('int_reg_53'):'City';?>" value="<?=$city;?>">
                                    </div>
                                    <div class="error_p col-sm-3"id="error_city"><?php echo form_error('city'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-sm-3 control-label"><?=(lang('int_reg_54')!='')? lang('int_reg_54'):'State/Province';?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 required" id="state" name="state" placeholder="<?=(lang('int_reg_54')!='')? lang('int_reg_54'):'State/Province';?>" value="<?=$state;?>">
                                    </div>
                                    <div class="error_p col-sm-3"id="error_state"><?php echo form_error('state'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country" class="col-sm-3 control-label"><?= (lang('int_reg_55')!='')? lang('int_reg_55'):'Country or Residence'; ?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">

                                        <select class="form-control round-0 required" id="country" name="country">

                                            <?php echo $countries;?>
                                        </select>

                                    </div>
                                    <div class="error_p col-sm-3"id="error_country"><?php echo form_error('country'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="zip" class="col-sm-3 control-label"><?= (lang('int_reg_56')!='')?lang('int_reg_56'):'Postal/Zip Code' ?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 required" id="zip" name="zip" placeholder="<?= (lang('int_reg_56')!='')?lang('int_reg_56'):'Postal/Zip Code' ?>" value="<?=$postal;?>">
                                    </div>
                                    <div class="error_p col-sm-3"id="error_zip"><?php echo form_error('zip'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="Phone number" class="col-sm-3 control-label"><?=(lang('int_reg_51')!='')?lang('int_reg_51'):'Phone number'?><cite
                                            class="req">*</cite></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 required" value="<?=$phone;?>"  id="Phone_number" name="Phone_number">
                                    </div>
                                    <div class="error_p col-sm-3" id="error_Phone_number"><?php echo form_error('Phone_number'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dob" class="col-sm-3 control-label"><?=(lang('int_reg_52')!='')?lang('int_reg_52'):'Date of birth'?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0 datepicker required" id="dob" value="<?php echo $date_of_birth;?>" name="dob">
                                    </div>
                                    <div class="error_p col-sm-3" id="error_dob"><?php echo form_error('dob'); ?> </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-5">

                                        <a href="javascript:void(0)" aria-controls="account" role="tab" data-toggle="tab" class="personal-next">


                                            <button id="personal-next" type="button" class="btn-submit"><?=lang('int_reg_20')?></button>
                                        </a>
                                        <a href="<?=FXPP::loc_url('my-account')?>"  class="back acc-back" ><?=lang('int_reg_21')?></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                    </div>





                    <div role="tabpanel" class="tab-pane" id="employment">
                        <div class="col-lg-12 col-md-12 col-centered">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>

                                    <div class="col-sm-6">
                                        <label><?=lang('int_reg_08')?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_09')?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select id="employment_status" class="form-control round-0 required" name="employment_status"
                                                id="employment_status">
                                            <?php echo $employment_status; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3"
                                         id="error_employment_status"><?php echo form_error('employment_status'); ?></div>
                                </div>
                                <div class="form-group industry">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_10')?><cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select id="industry" class="form-control round-0 emp-stat-cat" name="industry" id="industry">
                                            <?php echo $industry; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3" id="error_industry"><?php echo form_error('industry'); ?></div>
                                </div>
                                <div class="form-group source_of_funds" style="display: none;">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_11')?><cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select id="source_of_funds" class="form-control round-0 emp-stat-cat" name="source_of_funds"
                                                id="source_of_funds">
                                            <?php echo $source_of_funds; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3"
                                         id="error_source_of_funds"><?php echo form_error('source_of_funds'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_12')?><cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select class="form-control round-0 required" name="estimated_annual_income"
                                                id="estimated_annual_income">
                                            <?php echo $estimated_annual_income; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3"
                                         id="error_estimated_annual_income"><?php echo form_error('estimated_annual_income'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_13')?><cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select class="form-control round-0 required" name="estimated_net_worth" id="estimated_net_worth">
                                            <?php echo $estimated_net_worth; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3"
                                         id="error_estimated_net_worth"><?php echo form_error('estimated_net_worth'); ?></div>
                                </div>


                                <!-- <div class="form-group">
                                     <label class="col-sm-3 control-label"></label>
                                     <div class="col-sm-6">
                                         <label>Additional Details</label>
                                     </div>
                                 </div>-->

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?=lang('int_reg_14')?> <cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <select class="form-control round-0 required" name="education_level" id="education_level">
                                            <?php echo $education_level; ?>
                                        </select>
                                    </div>
                                    <div class="error_p col-sm-3"
                                         id="error_education_level"><?php echo form_error('education_level'); ?></div>
                                </div>

                                <!--<div class="form-group">
                                    <label class="col-sm-3 control-label">
                                    </label><div class="col-sm-6">For U.S. FATCA Purpose(Foreign Account Tax Compliance Act)</div>

                                </div>-->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?=lang('int_reg_15')?><cite
                                            class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <label class="">
                                            <input value="1" id="us_resident" type="radio" class="rdo-btn-required" name="us_resident"> <?=lang('int_reg_16')?>
                                            &nbsp;
                                            <input checked value="0" id="us_resident" type="radio" class="rdo-btn-required"
                                                   name="us_resident"> <?=lang('int_reg_17')?>
                                        </label>
                                    </div>
                                    <div class="error_p col-sm-3" id="error_us_resident"><?php echo form_error('us_resident'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?=lang('int_reg_18')?><cite class="req">*</cite></label>

                                    <div class="col-sm-6">
                                        <label class="">
                                            <input value="1" id="us_citizen" type="radio" name="us_citizen" class="rdo-btn-required"> <?=lang('int_reg_16')?>
                                            &nbsp;
                                            <input checked value="0" id="us_citizen" type="radio" name="us_citizen"
                                                   class="rdo-btn-required"> <?=lang('int_reg_17')?>
                                        </label>
                                    </div>
                                    <div class="error_p col-sm-3" id="error_us_citizen"><?php echo form_error('us_citizen'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?=lang('int_reg_19')?></label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control round-0" placeholder="Affiliate code" name="affiliate_code">
                                        <!--                    <button class="btn btn-success btn-md">Hover over me</button>-->
                                    </div>
                                    <div><i style="top: 10px !important;color: red;"
                                            class="tooltip-affiliate glyphicon glyphicon-question-sign"></i></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-5">

                                        <a href="javascript:void(0)" aria-controls="account" role="tab" data-toggle="tab" class="trading-next">


                                            <button id="employment-next" type="button" class="btn-submit"><?=lang('int_reg_20')?></button>
                                        </a>
                                        <a href="#personal" rel="tabs-personal" aria-controls="trading" role="tab" data-toggle="tab" class="back acc-back"
                                           id="back"><?=lang('int_reg_36')?></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div role="tabpanel" class="tab-pane" id="account">
                        <div class="col-lg-12 col-md-12 col-centered">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="optional"><i class="fa fa-info-circle"></i> (<?=lang('int_reg_22')?>)
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_23')?></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <div class="formliststyle-uploadfile">
                                                <div id="s-front-id" class="docs-id" style="display:none"></div>
                                            </div>
                                            <div class="formliststyle-uploadfile">
                                                <input type="file" name="filename[]" id="s-f0"/>
                                            </div>
                                            <br/>
                                            <div class="formliststyle-uploadfile">
                                                <a class="btn-up-file flt-l" name="s-front-id"  onclick="return false;">
                                                    <i class="fa fa-upload"></i>
                                                    Upload File
                                                </a>
                                            </div>
                                            <br/>
                                            <br/>
                                            <?php /**  <button class="capture">Capture From Webcam</button>  */ ?>
                                            <p class="note"><?=lang('int_reg_24')?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_25')?></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <div class="formliststyle-uploadfile">
                                                <div id="s-back-id" class="docs-id" style="display:none"></div>
                                            </div>
                                            <div class="formliststyle-uploadfile">
                                                <input type="file" name="filename[]" id="s-f1"/>

                                            </div>
                                            <br/>
                                            <div class="formliststyle-uploadfile">
                                                <a class="btn-up-file " name="s-back-id"  onclick="return false;">
                                                    <i class="fa fa-upload"></i>
                                                    Upload File
                                                </a>
                                            </div>
                                            <br/>
                                            <?php /**  <button class="capture">Capture From Webcam</button>  */ ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"><?=lang('int_reg_26')?></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <div class="formliststyle-uploadfile">
                                                <div id="s-proof-residence" class="docs-id" style="display:none"></div>
                                            </div>

                                            <div class="formliststyle-uploadfile">
                                                <input type="file" name="filename[]" id="s-f2">
                                            </div>

                                            <br/>
                                            <div class="formliststyle-uploadfile">
                                                <a class="btn-up-file " name="s-proof-residence"  onclick="return false;">
                                                    <i class="fa fa-upload"></i>
                                                    Upload File
                                                </a>
                                            </div>
                                            <br/>

                                            <?php /**  <button class="capture">Capture From Webcam</button>  */ ?>
                                            <p class="note"><?=lang('int_reg_27')?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <p class="sub"><?=lang('int_reg_28')?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-3">
                                        <div class="demo" id="labels" style="float: right;">
                                            <div class="switch-wrapper" style="padding: 0px 0px 10px 0px;">
                                                <input type="checkbox" value="1" checked name="technical_analysis">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?=lang('int_reg_29')?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <p class="sub"><?=lang('int_reg_30')?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-3 control-label"></label>

                                    <div class="col-sm-6">
                                        <div class="myfileupload-buttonbar ">
                                            <div class="checkbox">
                                                <label class="agreement">
                                                    <input id="agree-checkbox" type="checkbox">
                                                    <?=lang('int_reg_31')?> <a target="_blank" href=" <?php echo base_url('terms-and-conditions') ?>"><?=lang('int_reg_32')?></a> <?=lang('int_reg_39')?>
                                                    <a target="_blank" href=" <?php echo base_url('privacy-policy') ?>"><?=lang('int_reg_33')?></a>, <?=lang('int_reg_34')?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 40px;">
                                    <label for="inputPassword3" class="col-sm-3 control-label"></label>

                                    <div class=" col-sm-6">
                                        <!-- <a href="#account" aria-controls="account" role="tab" data-toggle="tab">-->
                                        <button id="complete_btn" type="button" class="btn-submit"><?=lang('int_reg_35')?></button>
                                        <!-- </a>-->
                                        <a href="#employment" rel="tabs-employment" aria-controls="trading" role="tab" data-toggle="tab" class="back acc-back"
                                           id="back"><?=lang('int_reg_36')?></a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal face" id="popinfo" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="">
    <div class="modal-dialog round-0">
        <div class="modal-content round-0">
            <div class="modal-header round-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-show-title">
                    <img src="<?= $this->template->Images() ?>logo.png" class="img-responsive modal-logo-title">
                </h4>
            </div>
            <div class="modal-body modal-show-body step-bg">
                <div class="row">
                    <div class="col-sm-4 not-available-holder">
                        <img src="<?= $this->template->Images() ?>choose4.png" class="img-responsive not-available-img">
                    </div>
                    <div class="col-sm-8 not-available-holder" style="padding-top: 22px;">
                        <p class="not-available-text"><?=lang('int_reg_37')?> <span>ForexMart</span>. <br/><?=lang('int_reg_38')?>.</p>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer round-0">
                <button type="button" class="btn btn-primary round-0">Update</button>
            </div> -->
        </div>
    </div>
</div>
<!-- end modal -->
<style type="text/css">
    .btn-up-file:hover{
        color: white!important;
        text-decoration: none!important;
    }
    .btn-up-file{
        background: rgb(41, 166, 67) none repeat scroll 0% 0%;
        border-radius: 0px;
        transition: all 0.3s ease 0s;
        border: medium none;
        padding: 7px 10px;
        color: rgb(255, 255, 255);
        margin-top: 10px;
        margin-right: 15px;
        cursor: pointer;
    }
    .flt-l{
        float: left!important;
    }
    .step-tab-holder1 ul li {
        float: left;
        font-size: 18px !important;
        font-weight: 600;
        font-family: Open Sans;
        padding: 0 0px !important;
    }

    .step-tab-holder1 ul {
        list-style: none;
        padding: 0;
        margin: 0;
        margin-left: 0px !important;
    }

    .error {
        color: red;
    }

    .error_p {
        color: red;
    }

    .nav-fix {
        position: fixed;
        top: 0;
        z-index: 9999;
        width: 100%;
        transition: all ease 0.3s;
    }

    .demo {
        margin-top: 0px !important;
    }

    .form-group > .col-sm-3 {

        padding-left: 0 !important;
    }
    .col-sm-6 > label {

        padding-top: 7px;;
    }
    .reg-form-holder1{ margin-left: 10px;}
</style>

<link href="<?= $this->template->Css() ?>jquery.fileupload.css" rel="stylesheet">
<link href="<?= $this->template->Css() ?>jquery.switchButton.css" rel="stylesheet">

<script src="<?= $this->template->Js() ?>jquery.js"></script>

<script src="<?= $this->template->Js() ?>jquery.easing.min.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>-->

<script src="<?= $this->template->Js() ?>jquery.ui.widget.js"></script>
<script src="<?= $this->template->Js() ?>jquery.switchButton.js"></script>
<script src="<?= $this->template->Js() ?>jquery.iframe-transport.js"></script>
<script src="<?= $this->template->Js() ?>jquery.fileupload.js"></script>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<?php //$this->load->view('account_nav.php');?>

<script type="text/javascript">


    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 95) {
            $('#nav').addClass('nav-fix');
        }
        else {
            $('#nav').removeClass('nav-fix');
        }
    });


    $(document).on('change', '#country', function(){

        var country=$(this).val();
        var url='<?=  base_url('my-account/getCalingCode')?>';
        $.post(url,{country:country},function(view){
            var code=view.trim();
            $("#Phone_number").val("+"+code);
        });
    });


</script>


<script type="text/javascript">
    //    $(document).ready(function () {
    //
    //        $("#back").click(function () {
    //            $(".tabs-title3").removeClass("color");
    //            $(".tabs-employment").addClass("color");
    //        });
    //    });
    $(document).on("click",".back",function(){
        var list=$(this).attr('rel');
        $(".toptab").removeClass("color");
        $("."+list).addClass("color");
    }) ;

    $(function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
            yearRange: "-95:-18",
            minDate: '-95Y',
            maxDate: '-18Y',
            defaultDate: +7
        });
    });

    $(document).on("click", "#personal-next", function () {
        $(".error_p").html("");
        var street=$("#street").val();
        var Phone_number=$("#Phone_number").val();
        var city=$("#city").val();
        var state=$("#state").val();
        var country=$("#country").val();
        var zip=$("#zip").val();
        var dob=$("#dob").val();
        street=street.trim();
        Phone_number=Phone_number.trim();
        city=city.trim();
        state=state.trim();
        country=country.trim();
        zip=zip.trim();
        dob=dob.trim();

        var result=1;
        if(street==""){$("#error_street").html("Street Address is required");result=0;}
        if(Phone_number==""){$("#error_Phone_number").html("Phone number is required");result=0;}
        if(city==""){$("#error_city").html("City is required");result=0;}
        if(state==""){$("#error_state").html("State/Province is required");result=0;}
        if(country==""){$("#error_country").html("Country or Residence is required");result=0;}
        if(zip==""){$("#error_zip").html("Postal/Zip Code is required");result=0;}
        if(dob==""){$("#error_dob").html("Date of birth is required");result=0;}




        if(result==1)
        {


            $(".personal-next").attr("href", '#employment');
            $(".toptab").removeClass("color");
            $(".tabs-employment").addClass("color");

            setTimeout(function(){ $(".personal-next").attr("href", '#personal'); }, 1000);
        }
    });



    $(document).on("click", "#employment-next", function () {
        var flag = true;
        var errors = new Array();

        $("#employment .required").each(function () {
            if ('' == jQuery(this).val()) {
                flag = false;
                errors.push(this.name);
            }
        });

        if ($('#employment_status').val() != '') {
            if ($('#employment_status').val() == 0) {
                if ($('#industry').val() == '') {
                    errors.push("industry");
                    flag = false;
                }
            } else {
                if ($('#source_of_funds').val() == '') {
                    errors.push("source_of_funds");
                    flag = false;
                }
            }
        }


        if ($("input[name=us_citizen]:checked").length <= 0) {
            errors.push("us_citizen");
            flag = false;
        }
        if ($("input[name=us_resident]:checked").length <= 0) {
            errors.push("us_resident");
            flag = false;
        }

        if (flag) {
            $(".trading-next").attr("href", '#account');
            $(".tabs-employment").removeClass("color");
            $(".tabs-title3").addClass("color");
        } else {
            for (error in errors) {
                switch (errors[error]) {

                    case 'employment_status':
                        jQuery("#error_" + errors[error]).html("<p>The Employment Status field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;
                    case 'industry':
                        jQuery("#error_" + errors[error]).html("<p>This field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;
                    case 'source_of_funds':
                        jQuery("#error_" + errors[error]).html("<p>The Source of Funds Status field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;
                    case 'estimated_annual_income':
                        jQuery("#error_" + errors[error]).html("<p>The Estimated Annual Income field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;
                    case 'estimated_net_worth':
                        jQuery("#error_" + errors[error]).html("<p>The Estimated Net Worth field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;
                    case 'education_level':
                        jQuery("#error_" + errors[error]).html("<p>The Education Level field is required.</p>");
                        jQuery("select#" + errors[error]).addClass('red-border');
                        break;

                    case 'us_citizen':
                        jQuery("#error_" + errors[error]).html("<p>This field is required.</p>");
                        break;
                    case 'us_resident':
                        jQuery("#error_" + errors[error]).html("<p>This field is required.</p>");
                        break;

                }
            }
        }

    });

    $(document).on("click", 'input,select', function () {

        jQuery(this).removeClass("red-border");
        jQuery(this).closest('div').next('div.error_p').html("");
    });

    var base_url = "<?php echo base_url();?>";


    $(document).on("change", "#employment_status", function () {

        if ($(this).val() == "0") {

            $('.source_of_funds').hide();
            $(".industry").show();
            $('#source_of_funds').val("");
            $("#industry").addClass('required');
            $('#source_of_funds').removeClass('required');

        } else {
            $(".industry").hide();
            $("#industry").val("");
            $('.source_of_funds').show();
            $('#source_of_funds').addClass('required');
            $("#industry").removeClass('required');
        }

    })


</script>

<script type="text/javascript">
    $(window).load(function(){
        $('#popinfo').modal('show');
    });
</script>

<script>
    $(document).on("click", "#complete_btn", function () {

        if ($("#agree-checkbox").is(':checked')) {
            $("#register-live").submit();
        } else {
            alert(" You must agree with the Terms of Service. ");
        }
    })


    $(function () {
        $('#basic.demo input').switchButton();

        $('#basic2.demo input').switchButton();

        $("#labels.demo input").switchButton({
            on_label: 'YES',
            off_label: 'NO'
        });

        $("#default.demo input").switchButton({
            checked: false
        });

        $("#labels2-1.demo input").switchButton({
            show_labels: false
        });

        $("#labels2-2.demo input").switchButton({
            labels_placement: "right"
        });

        $("#labels2-3.demo input").switchButton({
            labels_placement: "left"
        });

        $("#slider-1.demo input").switchButton({
            width: 100,
            height: 40,
            button_width: 50
        });

        $("#slider-2.demo input").switchButton({
            width: 100,
            height: 40,
            button_width: 70
        });
    })
</script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === 'blueimp.github.io' ?
            '//jquery-file-upload.appspot.com/' : 'server/php/';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).ready(function () {
        $('.tooltip-affiliate').tooltip({title: "<p align='left' style='padding: 5px !important;'>The field is optional. In this field you may enter the affiliate code of a partner who referred you to the company.</p>", html: true, placement: "right"});
    });
    $(document).ready(function(){
        var forexmart = "<?php echo FXPP::ajax_url();?>";
        var pblc = [];
        pblc['request']=null;
        if(pblc['request'] != null) pblc['request'].abort();

        //Document 1
        $('a[name=s-front-id]').click(function () {
            /* perform action here */
            console.log(1);
            $('div#s-front-id').show();
            $('div#s-front-id').html('<div class="alert alert-info">Uploading file. Please wait...</div>');
            var file_data = $("#s-f0").prop("files")[0];
            console.log(file_data);
            var myFormData = new FormData();
            myFormData.append('file', file_data);
            myFormData.append('doc_type', 0);
            pblc['request'] =  $.ajax({
                url: forexmart+'query/upload/'+$.now(),
                type: 'POST',
                processData: false, // important
                contentType: false, // important
                cache: false,
                dataType : 'json',
                data: myFormData
            });
            pblc['request'].done(function( response ) {
                if(response.error){
                    if( response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>' && response.msgError_ext===false){
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong> ,<strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#s-front-id').html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#s-front-id').html('<div class="alert alert-success">The file was uploaded successfully.</div>');
                }
            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });
        });

        //Document 2
        $('a[name=s-back-id]').click(function () {
            /* perform action here */
            console.log(2);
            $('div#s-back-id').show();
            $('div#s-back-id').html('<div class="alert alert-info">Uploading file. Please wait...</div>');
            var file_data = $("#s-f1").prop("files")[0];
            console.log(file_data);
            var myFormData = new FormData();
            myFormData.append('file', file_data);
            myFormData.append('doc_type', 1);
            pblc['request'] =  $.ajax({
                url: forexmart+'query/upload/'+$.now(),
                type: 'POST',
                processData: false, // important
                contentType: false, // important
                cache: false,
                dataType : 'json',
                data: myFormData
            });
            pblc['request'].done(function( response ) {
                if(response.error){
                    if(response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>'){
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong> ,<strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#s-back-id').html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#s-back-id').html('<div class="alert alert-success">The file was uploaded successfully.</div>');
                }
            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });
        });

        //Document 3
        $('a[name=s-proof-residence]').click(function () {
            /* perform action here */
            console.log(3);
            $('div#s-proof-residence').show();
            $('div#s-proof-residence').html('<div class="alert alert-info">Uploading file. Please wait...</div>');
            var file_data = $("#s-f2").prop("files")[0];
            console.log(file_data);
            var myFormData = new FormData();
            myFormData.append('file', file_data);
            myFormData.append('doc_type', 2);
            pblc['request'] = $.ajax({
                url: forexmart+'query/upload/'+$.now(),
                type: 'POST',
                processData: false, // important
                contentType: false, // important
                cache: false,
                dataType : 'json',
                data: myFormData
            });
            pblc['request'].done(function( response ) {
                if(response.error){
                    if(response.msgError === '<p>The filetype you are attempting to upload is not allowed.</p>'){
                        var rtnError = 'The file type you are attempting to upload is not allowed. The format should be in <strong>pdf</strong>,  <strong>gif</strong>, <strong>jpg</strong>, or <strong>png</strong>.';
                    }else{
                        var rtnError = response.msgError;
                    }
                    $('div#s-proof-residence').html('<div class="alert alert-danger">'+rtnError+'</div>');
                }else{
                    $('div#s-proof-residence').html('<div class="alert alert-success">The file was uploaded successfully.</div>');
                }
            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });
        });
    });
    <?php if(isset($_SESSION['first_login'])){?>
    $(function(){
        var mouseY = 0;
        var topValue = 0;
        window.addEventListener("mouseout",function(e){
                mouseY = e.clientY;
                if(mouseY<topValue) {
                    window.history.pushState("object or string", "Title", "/my-account/register?z42esbsn4yqu2p");
                }
            },
            false);
    });
    <?php }?>
    $( "body" ).mousemove(function( event ) {
        window.history.pushState("object or string", "Title", "/my-account/register");
    });
</script>























