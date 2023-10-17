<script src="<?= $this->template->Js()?>jquery.ui.widget.js"></script>
<script src="<?= $this->template->Js()?>jquery.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<style type="text/css">
    div.open-trading-cont{
        width: 100%;
    }
    div.step-tab-holder1 ul{
        margin-left: 0px !important;
    }
    div.step-tab-holder1 li{
        font-size: 16px;
    }
    .red-border{ border: 1px solid red; }
    .form-horizontal .control-label{
        padding-top: 0px !important;
    }
    .tooltip{
        width: 100%!important;
    }
    .step-tab-holder1 ul li{
        padding: 0px !important;
        font-size: 15px;
    }
</style>

<h1 class="">Open Trading Account</h1>
<div class="open-trading-cont">
    <div class="step-tab-holder1">
        <ul>
            <li class="tabs-title1 color">
                <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="30"/> Personal Details
            </li>
            <li>
                <img src="<?= $this->template->Images() ?>nxt.png" class="img-reponsive" width="28"/>
            </li>
            <li class="tabs-title2">
                <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="30"/> Trading Account Details
            </li>
            <li>
                <img src="<?= $this->template->Images() ?>nxt.png" class="img-reponsive" width="28"/>
            <li class="tabs-title3">
                <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="30"/> Employment Details
            </li>
            <li>
                <img src="<?= $this->template->Images() ?>nxt.png" class="img-reponsive" width="28"/>
            </li>
            <li class="tabs-title4">
                <img src="<?= $this->template->Images() ?>step.png" class="img-reponsive" width="30"/> Account Confirmation
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<form action="" method="post" id="register-live" enctype="multipart/form-data">
    <div class="tab-content" style="margin-top: 30px;">
        <div role="tabpanel" class="tab-pane active row col-centered " id="personal">
            <div class="col-lg-10 col-md-10 col-centered">
                <div class="form-horizontal personal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Street address<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0" placeholder="Street address" name="street" id="street">
                        </div>
                        <div class="error_p col-sm-3" id="error_street"><?php echo form_error('street'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">City<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0" placeholder="City" name="city" id="city">
                        </div>
                        <div class="error_p col-sm-3" id="error_city"><?php echo form_error('city'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">State/Province<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0" placeholder="State/Province" name="state" id="state">
                        </div>
                        <div class="error_p col-sm-3" id="error_state"><?php echo form_error('state'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Country<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <select id="country"  name="country" class="form-control round-0 ">
                                <?php echo $countries; ?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_state"><?php echo form_error('country'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Postal/Zip Code<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0" placeholder="Postal/Zip Code" name="zip" id="zip">
                        </div>
                        <div class="error_p col-sm-3" id="error_zip"><?php echo form_error('zip'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone Number<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0" placeholder="Phone Number" name="phone" id="phone" value="<?php echo $calling_code; ?>">
                        </div>
                        <div class="error_p col-sm-3" id="error_phone"><?php echo form_error('phone'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Date of Birth<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <input type="text" class="required form-control round-0 datepicker" placeholder="Date of Birth" name="dob" id="dob">
                        </div>
                        <div class="error_p col-sm-3" id="error_dob"><?php echo form_error('dob'); ?></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-5">
                            <a href="javascript:void(0)" aria-controls="trading" role="tab" data-toggle="tab" class="personal-next">
                                <button id="personal-next" type="button" class="btn-submit">Next</button>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="trading">
            <div class="col-lg-10 col-md-10 col-centered">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Type<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="mt_account_set_id" id="mt_account_set_id">
                                <?php echo $account_type;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_mt_account_set_id"><?php echo form_error('mt_account_set_id'); ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Account Currency Base<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="mt_currency_base" id="mt_currency_base">
                                <?php echo $account_currency_base;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_mt_currency_base"><?php echo form_error('mt_currency_base'); ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Leverage<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="leverage" id="leverage">
                                <?php echo $leverage;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_leverage"><?php echo form_error('leverage'); ?></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-12">
                            <input name="swap_free" value='1' type="checkbox"/> Swap-free
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Trading Experience</label>
                        <div class="col-sm-6">
                            Please indicate if you have traded on an execution only basis in any of the following Markets for the past 1-3 years
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label class="">
                                    <input id="agree" <?php echo $trade_exp[0] == 0 ? '' : 'checked'?> type="checkbox" name="experience" value="1"> Forex and CFD's
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="">
                                    <input id="agree" <?php echo $trade_exp[1] == 0 ? '' : 'checked'?> type="checkbox" name="experience" value="2"> Securities(Shares or Bonds)
                                </label>
                            </div>
                            <div class="checkbox">
                                <label class="">
                                    <input id="agree" <?php echo $trade_exp[2] == 0 ? '' : 'checked'?> type="checkbox" name="experience" value="3"> Other Derivative Products
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-3 control-label">Investment Knowledge <cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            How would you characterize your investment knowledge and experience?
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="investment_knowledge" id="investment_knowledge">
                                <?php echo $investment_knowledge;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_investment_knowledge"><?php echo form_error('investment_knowledge'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">How often do you trade? <cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="trade_duration" id="trade_duration">
                                <?php echo $trade_duration;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_trade_duration"><?php echo form_error('trade_duration'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <label>Additional Details</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Politically Exposed Person <cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <label class="">
                                <input <?php echo $politically_exposed_person == 1 ? 'checked' : ''; ?> value="1" id="politically_exposed_person" type="radio" class="rdo-btn-required" name="politically_exposed_person"> Yes &nbsp;
                                <input <?php echo $politically_exposed_person == 0 ? 'checked' : ''; ?> value="0" id="politically_exposed_person" type="radio" class="rdo-btn-required" name="politically_exposed_person"> No
                            </label>
                        </div>
                        <div class="error_p col-sm-3" id="error_politically_exposed_person"><?php echo form_error('politically_exposed_person'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Understand investment risk <cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <label class="">
                                <input <?php echo $risk == 1 ? 'checked' : ''; ?> value="1" id="risk" type="radio" class="rdo-btn-required" name="risk"> Yes &nbsp;
                                <input <?php echo $risk == 0 ? 'checked' : ''; ?> value="0" id="risk" type="radio" class="rdo-btn-required" name="risk"> No
                            </label>
                        </div>
                        <div class="error_p col-sm-3" id="error_risk"><?php echo form_error('risk'); ?></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-5">
                            <a href="Javascript:;"  aria-controls="account" role="tab" data-toggle="tab" class="trading-next">
                                <button id="trading-next" type="button" class="btn-submit">Next</button>
                            </a>
                            <a href="#personal" aria-controls="personal" role="tab" data-toggle="tab" class="back trading-back"
                               id="back">Back</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="employment">
            <div class="col-lg-10 col-md-10 col-centered">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Employment Status<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <select id="employment_status" class="form-control round-0 required" name="employment_status" id="employment_status">
                                <?php echo $employment_status;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_employment_status"><?php echo form_error('employment_status'); ?></div>
                    </div>
                    <div class="form-group industry">
                        <label for="inputPassword3" class="col-sm-3 control-label">Industry<cite class="req">*</cite></label>
                        <div class="col-sm-6">
                            <select id="industry" class="form-control round-0 emp-stat-cat" name="industry" id="industry">
                                <?php echo $industry;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_industry"><?php echo form_error('industry'); ?></div>
                    </div>
                    <div class="form-group source_of_funds" style="display: none;">
                        <label for="inputPassword3" class="col-sm-3 control-label">Source of Funds<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select id="source_of_funds" class="form-control round-0 emp-stat-cat" name="source_of_funds" id="source_of_funds">
                                <?php echo $source_of_funds;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_source_of_funds"><?php echo form_error('source_of_funds'); ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Estimated Annual Income<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="estimated_annual_income" id="estimated_annual_income">
                                <?php echo $estimated_annual_income;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_estimated_annual_income"><?php echo form_error('estimated_annual_income'); ?></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Estimated Net Worth<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="estimated_net_worth" id="estimated_net_worth">
                                <?php echo $estimated_net_worth;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_estimated_net_worth"><?php echo form_error('estimated_net_worth'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Education Level <cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <select class="form-control round-0 required" name="education_level" id="education_level">
                                <?php echo $education_level;?>
                            </select>
                        </div>
                        <div class="error_p col-sm-3" id="error_education_level"><?php echo form_error('education_level'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Are you a United States Resident for Tax Purposes?<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <label class="">
                                <input <?php echo $us_resident == 1 ? 'checked' : ''; ?> value="1" type="radio" class="rdo-btn-required" name="us_resident"> Yes &nbsp;
                                <input <?php echo $us_resident == 0 ? 'checked' : ''; ?> value="0" type="radio" class="rdo-btn-required" name="us_resident"> No
                            </label>
                        </div>
                        <div class="error_p col-sm-3" id="error_us_resident"><?php echo form_error('us_resident'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Are you a United States Citizen?<cite class="req">*</cite></label>

                        <div class="col-sm-6">
                            <label class="">
                                <input <?php echo $us_citizen == 1 ? '' : 'checked = ""'; ?> value="1" type="radio" name="us_citizen" class="rdo-btn-required"> Yes &nbsp;
                                <input <?php echo $us_citizen == 0 ? '' : 'checked = ""'; ?> value="0"  type="radio" name="us_citizen" class="rdo-btn-required"> No
                            </label>
                        </div>
                        <div class="error_p col-sm-3" id="error_us_citizen"><?php echo form_error('us_citizen'); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Affiliate Code</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control round-0" placeholder="Affiliate code" name="affiliate_code">
                            <!--                    <button class="btn btn-success btn-md">Hover over me</button>-->
                        </div>
                        <div><i style="top: 10px !important;color: red;" class="tooltip-affiliate glyphicon glyphicon-question-sign"></i></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-5">
                            <a href="Javascript:;"  aria-controls="account" role="tab" data-toggle="tab" class="employment-next">
                                <button id="employment-next" type="button" class="btn-submit">Next</button>
                            </a>
                            <a href="#trading" aria-controls="trading" role="tab" data-toggle="tab" class="back employment-back"
                               id="back">Back</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>


        <div role="tabpanel" class="tab-pane" id="account">
            <div class="col-lg-7 col-md-7 col-centered">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-5">
                        </div>
                        <div class="col-sm-7">
                            <p class="optional"><i class="fa fa-info-circle"></i> (Optional, you can upload documents later.)
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label">Colour copy of passport or the front of the
                            ID</label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <input type="file" name="filename[]" />
                                <p class="note">
                                    To open an FX account you must provide a full, clear and valid (colour) copy of your
                                    international passport or national I.D. card or photocard driving license, in addition to
                                    the documents required to verify your address.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label">Colour copy of the back of the ID</label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <input type="file" name="filename[]" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label">Proof of Residence</label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <input type="file" name="filename[]" />
                                <p class="note">
                                    Recent utility bill dated within the last six months, current local authority tax bill, or
                                    credit card statement.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label"></label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <p class="sub">
                                    Product Update and Technical Analysis Emails
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-7">
                            <div class="checkbox">
                                <p style="padding-left: 20px;">
                                    <input type="checkbox" value="1" checked name="technical_analysis"> I want to receive product update and Technical Analysis emails.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label"></label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <p class="sub">
                                    Submission Confirmation
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-5 control-label"></label>

                        <div class="col-sm-7">
                            <div class="myfileupload-buttonbar ">
                                <div class="checkbox">
                                    <p style="padding-left: 20px;" class="agreement">
                                        <input id="agree-checkbox" type="checkbox"> I declare that I have carefully read and fully understood the
                                        entire text of the <a style="color: #2988CA" target="_blank" href="<?= FXPP::www_url('terms-and-conditions');?>">Customer Agreement</a> and <a style="color: #2988CA" target="_blank" href="<?= FXPP::www_url('privacy-policy');?>">Privacy Policy</a>, with which I fully
                                        understand, accept and agree.
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 40px;">
                        <div class="col-sm-offset-5 col-sm-7">
                            <!-- <a href="#account" aria-controls="account" role="tab" data-toggle="tab">-->
                            <button id="complete_btn" type="button" class="btn-submit">Complete</button>
                            <!-- </a>-->
                            <a href="#employment" aria-controls="employment" role="tab" data-toggle="tab" class="back acc-back"
                               id="back">Back</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    $(function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'yy-mm-dd',
            yearRange: "-95:-18",
            minDate: '-95Y',
            maxDate: '-18Y'
        });
    });

    $(document).on("click","#complete_btn",function(){

        if($("#agree-checkbox").is(':checked')){
            $("#register-live").submit();
        }else{
            alert(" You must agree with the Terms of Service. ");
        }
    });


    $(document).ready(function(){
        $(".trading-back").click(function(){
            $(".tabs-title2").removeClass("color");
            $(".tabs-title1").addClass("color");
        });
        $(".acc-back").click(function(){
            $(".tabs-title4").removeClass("color");
            $(".tabs-title3").addClass("color");
        });
        $(".employment-back").click(function(){
            $(".tabs-title3").removeClass("color");
            $(".tabs-title2").addClass("color");
        });
    });

    $(document).on("click","#personal-next",function(){
        var flag =true;
        var errors = new Array();

        jQuery("#personal .required").each(function(){
            if('' == jQuery(this).val()){
                flag = false;
                errors.push(this.name);
            }
        });

        if(flag){
            $(".personal-next").attr("href",'#trading');
            $(".tabs-title1").removeClass("color");
            $(".tabs-title2").addClass("color");
        }else{
            for(error in errors){
                switch (errors[error]){
                    case 'street':
                        jQuery("#error_"+errors[error]).html( "<p>The Street address field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                    case 'city':
                        jQuery("#error_"+errors[error]).html( "<p>The City field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                    case 'state':
                        jQuery("#error_"+errors[error]).html( "<p>The State/Province field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                    case 'zip':
                        jQuery("#error_"+errors[error]).html( "<p>The Postal/Zip Code field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                    case 'phone':
                        jQuery("#error_"+errors[error]).html( "<p>The Phone number field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                    case 'dob':
                        jQuery("#error_"+errors[error]).html( "<p>The Date of Birth field is required.</p>" );
                        jQuery("input#"+errors[error]).addClass('red-border');
                        break;
                }
            }
            $(".personal-next").attr("href",'');
        }
    });

    $(document).on("click","#trading-next",function(){
        var flag = true;
        var errors = new Array();

        $("#trading .required").each(function(){
            if('' == jQuery(this).val()){
                flag = false;
                errors.push(this.name);
            }
        });

        if ($("input[name=risk]:checked").length<=0){
            errors.push( "risk" );
            flag = false;
        }

        if ($("input[name=politically_exposed_person]:checked").length<=0){
            errors.push( "politically_exposed_person" );
            flag = false;
        }

        if(flag){
            $(".trading-next").attr("href",'#employment');
            $(".tabs-title2").removeClass("color");
            $(".tabs-title3").addClass("color");
        }else{

        }


//        var flag =true;
//        $("#trading .required").each(function(){
//            if($(this).val().length>0)
//            {
//                $(this).closest('div').next('div').text("");
//                $(this).removeClass("red-border");
//            }else{
//                $(this).closest('div').next('div').text("This is a required field.");
//                $(this).addClass("red-border");
//                flag = false;
//            }
//        });
//
//        if(flag){
//            $(".trading-next").attr("href",'#account');
//            $(".tabs-title2").removeClass("color");
//            $(".tabs-title3").addClass("color");
//        }else{
//            $(".trading-next").attr("href",'');
//        }

    });

    $(document).on("click","#employment-next",function(){
        var flag = true;
        var errors = new Array();

        $("#employment .required").each(function(){
            if('' == jQuery(this).val()){
                flag = false;
                errors.push(this.name);
            }
        });

        if($('#employment_status').val() != ''){
            if($('#employment_status').val() == 0){
                if($('#industry').val() == ''){
                    errors.push( "industry" );
                    flag = false;
                }
            }else{
                if($('#source_of_funds').val() == ''){
                    errors.push( "source_of_funds" );
                    flag = false;
                }
            }
        }

        if ($("input[name=us_citizen]:checked").length<=0){
            errors.push( "us_citizen" );
            flag = false;
        }

        if ($("input[name=us_resident]:checked").length<=0){
            errors.push( "us_resident" );
            flag = false;
        }

        if(flag){
            $(".employment-next").attr("href",'#account');
            $(".tabs-title3").removeClass("color");
            $(".tabs-title4").addClass("color");
        }else{
            for(error in errors){
                switch (errors[error]){
                    case 'employment_status':
                        jQuery("#error_"+errors[error]).html( "<p>The Employment Status field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'industry':
                        jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'source_of_funds':
                        jQuery("#error_"+errors[error]).html( "<p>The Source of Funds Status field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'estimated_annual_income':
                        jQuery("#error_"+errors[error]).html( "<p>The Estimated Annual Income field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'estimated_net_worth':
                        jQuery("#error_"+errors[error]).html( "<p>The Estimated Net Worth field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'education_level':
                        jQuery("#error_"+errors[error]).html( "<p>The Education Level field is required.</p>" );
                        jQuery("select#"+errors[error]).addClass('red-border');
                        break;
                    case 'us_citizen':
                        jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                        break;
                    case 'us_resident':
                        jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                        break;
                }
            }
        }
    });


    $(document).on("change","#employment_status",function(){

        if($(this).val() == "0"){

            $('.source_of_funds').hide();
            $(".industry").show();
            $('#source_of_funds').val("");

        }else{
            $(".industry").hide();
            $("#industry").val("");
            $('.source_of_funds').show();
        }
    });

    $(document).on("focus",'input,select',function(){
        jQuery(this).closest('div').next('div.error_p').html("");
        $(this).removeClass("red-border");
    });

    $(document).ready(function(){
        $('.tooltip-affiliate').tooltip({title: "<p align='left' style='padding: 5px !important;'>The field is optional. In this field you may enter the affiliate code of a partner who referred you to the company.</p>", html: true, placement: "right"});
    });

    $(function() {

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
    });

</script>
