<link href="<?= $this->template->Css()?>external-register-style.css" rel="stylesheet">
<?php $this->load->view('account_nav.php');?>
<style type="text/css">
    .fix-height-scroll{
        max-height: 757px;
        overflow-y: auto;
    }
    #success-div h4 {
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        color: #2988ca;
    }
    #success-div span{
        text-align: center;
        display: block;
    }


    .btn_next_employment{
        border-radius: 0;
        padding: 5px 50px;
    }

    .btns-open-acc {
        margin-top: 15px;
        margin-right: 10px;
        /*float: left;*/
        display: inline-block;
    }
    .btn-trading-demo-holder{
        text-align: center;
        margin-bottom: 15px;
    }

    @media only screen and (max-width: 760px){
        .btns-open-acc {
            margin-top: 15px;
            margin-right: 0px;
            float: none;
            width: 100%;
        }

        .btns-open-wid-acc {
            width: 100% !important;
        }
    }

    .btn_complete,.btn_next,.btn_back{
        padding: 10px;
        margin-right: 40%;
        float: right;
        margin-top: 2%;
        margin-bottom: 2%;
        background: #29a643;
        color: #fff;
        border: none;
        display: block;
        text-align: center;
    }

    #success-div h4 {
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        color: #2988ca;
    }
    #success-div span{
        text-align: center;
        display: block;
    }
    .btns-open-acc{
        width:33.2%
    }
    .mid-btn{
        width:31%
    }
    .btns-open-acc button ,.mid-btn button {
        width:100%
    }
    .reg-btn{
        margin-right:0px;
    }



    @media screen and (max-width:760px){
        .open-demo .open-trading {
            width: 100% !important;
            padding: 7px;
        }
        .btns-open-acc {
            width: 100%!important;
        }
    }

    @media screen and (max-width: 767px){
        .nextBtn {
            margin-top: 0px;
        }
        .btn_next_employment {
            margin-top: 0px;
        }
        .open-demo {
            padding-right: 0px!important;
        }
    }

</style>
<div class="container">
    <div role="tabpanel" class="row tab-pane active" id="tab1">
        <div class="col-md-12 col-sm-12 btn-trading-demo-holder">
            <div class="btns btns-open-acc mid-btn" style="">
                <form action="<?= FXPP::www_url('register/demo/step2')?>" method="post">
                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
                    <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
                    <button type="submit" class="open-demo open-demo_custom btns-open-wid-acc">
                        <?=lang('mya_03');?>
                    </button>
                </form>
            </div>
            <div class="btns btns-open-acc reg-btn" style="">
                <form action="<?= FXPP::loc_url('registration');?>" method="post">
                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
                    <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
                    <input type="hidden" name="success_reg" value="<?php isset($success)?'done':'';?>">
                    <button type="submit" class="open-trading btns-open-wid-acc"><?=lang('reg_in_02');?></button>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="stepwizard col-md-3">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-success btn-circle" ><i class="fa fa-flag"></i></a>
                <p> <?=lang('reli_h1');?> </p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-flag"></i></a>
                <p><?=lang('reli_h2');?></p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-flag"></i></a>
                <p><?=lang('reli_h3');?></p>
            </div>
            <?php if(isset($success) && $success){ ?>
            <div class="stepwizard-step">
                <a href="#step-4" type="button" class="btn btn-default btn-circle"  disabled="disabled"><i class="fa fa-flag"></i></a>
                <p> <?=lang('reli_h4');?></p>
            </div>
            <?php } ?>
        </div>
    </div>


        <?= form_open(FXPP::loc_url('registration/index_new'),array('id' => 'addAccount','class'=> 'addAcc form-horizontal', 'enctype'=>"multipart/form-data"),''); ?>
        <div class="row setup-content" id="step-1">

            <div class="col-md-12 fix-height-scroll">
                <div class="form-group">
                    <label class="control-label required col-sm-4 col-xs-12" for="address"><?=lang('reli_01');?></label>
                    <div class="col-sm-6 col-sm-2-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Address field should be up to 128 characters)</sup>
                        <input maxlength="128" type="text" required="required" class="form-control" value="<?php echo isset($user_details_emailname['street']) ? $user_details_emailname['street'] : '' ?>" id="street" name= "street" placeholder="<?=lang('reli_01_1');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="city"><?=lang('reli_02');?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(City field should be up to 32 characters)</sup>
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo isset($user_details_emailname['city']) ? $user_details_emailname['city'] : '' ?>" id="city" name="city" placeholder="<?=lang('reli_02');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="state"><?=lang('reli_03');?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(State/Province field should be up to 32 characters)</sup>
                        <input maxlength="32" type="text" required="required" class="form-control" value="<?php echo isset($user_details_emailname['state']) ? $user_details_emailname['state'] : '' ?>" id="state" name ="state" placeholder="<?=lang('reli_03');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="country"><?=lang('reli_04');?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Please select Country of Residence)</sup>
                        <select class="form-control" name="country" id="country">
                            <?php echo  $countries;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="zip"><?=lang('reli_05');?></label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Postal/Zip Code field should be up to 15 characters)</sup>
                        <input maxlength="15" type="number" required="required" class="form-control" placeholder="<?=lang('reli_05');?>" name="zip" value="<?php echo isset($user_details_emailname['zip']) ? $user_details_emailname['zip'] : '' ?>" name="zip" id="zip" placeholder="Postal/Zip Code">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="telephone">Telephone Number </label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Phone number field should be up to 32 characters)</sup>
                        <input maxlength="32" type="tel" required="required" class="form-control" name="telephone" id="telephone" value="<?php echo isset($user_details_emailname['telephone']) ? $user_details_emailname['telephone'] : '' ?>"  placeholder="Telephone">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="phone">Mobile Number </label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Phone number field should be up to 32 characters)</sup>
                        <input maxlength="32" type="tel" required="required" class="form-control" value="<?php echo isset($user_details_emailname['phone1']) ? $user_details_emailname['phone1'] : '+'.$calling_code ?>" name="phone" id="phone" placeholder="Phone">
                        <input type="hidden" name="phone_code" value="<?php echo '+'.$calling_code ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="gender">Gender </label>
                    <div class="col-sm-2 col-sm-6-offset col-xs-12">
                        <select class="form-control" name="gender" id="gender">
                            <?php echo  $gender;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="age">Age </label>
                    <div class="col-sm-2 col-sm-6-offset col-xs-12">
                        <input maxlength="2" type="number" required="required" class="form-control" min="13" max="100" value="<?php echo isset($user_details_emailname['age']) ? $user_details_emailname['age'] : '' ?>" name="age" id="age" placeholder="Age">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="birth"><?=lang('reli_07');?></label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <input type="date" required="required" class="form-control" value="<?php echo isset($user_details_emailname['dob']) ? date('Y-m-d', strtotime($user_details_emailname['dob'])) : '' ?>" name= "dob" id="birth" placeholder="<?=lang('reli_07');?>">
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                        <button class="btn btn-success nextBtn pull-right" type="button">Next</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row setup-content"   id="step-2">
            <div class="col-md-12 fix-height-scroll">

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="mt_account_set_id"><?=lang('reli_12');?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="mt_account_set_id" id="mt_account_set_id" >
                            <?php echo $account_type;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="currency"><?=lang('reli_13');?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name= "mt_currency_base" id="mt_currency_base">
                            <?php echo $account_currency_base;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="leverage">Leverage </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="leverage" id="xleverage">
                            <?php echo $leverage;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8 checkbox swap">
                        <label><input type="checkbox" name="swap_free" <?php echo isset($user_details_emailname['swap_free']) ? $user_details_emailname['swap_free'] ? ' checked' : '' : '' ?> value="1" ><?=lang('reli_15');?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="trading">Trading Experience </label>
                    <div class="col-sm-8 col-xs-12 info">
                        <p>Please indicate if you have traded on an execution only basis in any of the following markets for the past 1-3 years</p>
                        <div class="checkbox">
                            <label><input id="agree-1" type="checkbox" name="experience" <?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][0] ? ' checked' : '' : '' ?> value="1"><?=lang('reli_n_18');?></label>
                        </div>
                        <div class="checkbox">
                            <label><input id="agree-2" type="checkbox" name="experience" <?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][1] ? ' checked' : '' : '' ?> value="2"><?=lang('reli_n_20');?></label>
                        </div>
                        <div class="checkbox">
                            <label><input id="agree-3" type="checkbox" name="experience"<?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][2] ? ' checked' : '' : '' ?> value="3"><?=lang('reli_n_20');?></label>
                        </div>
                        <div class="checkbox">
                            <label><input id="agree-4" type="checkbox" name="experience"<?php echo isset($user_details['trading_experience_value'][0]) ? $user_details['trading_experience_value'][3] ? ' checked' : '' : '' ?> value="4"><?=lang('reli_n_21');?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="investment"><?=lang('reli_21');?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="note-at-top info">How would you characterized your investment knowledge and experience?</sup>
                        <select class="form-control" name="investment_knowledge" id="investment_knowledge">
                            <?php echo $investment_knowledge;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="trade">How often do you trade? </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="trade_duration" id="trade_duration">
                            <?php echo $trade_duration;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="number_of_trades">How many trades connected to Rolling Spot Forex/CFDs on FX pairs/Indices or Commodities have you made in the last six months? </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="number_of_trades" id="number_of_trades">
                            <?php echo $number_of_trades;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="otc">What is the meaning of Over The Counter ("OTC") derivatives? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input id="otc-1" type="radio" name="otc_meaning" <?php echo isset($user_details_emailname['otc_meaning']) ? $user_details_emailname['otc_meaning'] ? ' checked' : '' : ' checked' ?> value="1"/>Contract that are traded (and privately negotiated) directly beetween two parties, without going through an exchange or other intermediary.</label><br>

                        <label class="radio-inline"> <input id="otc-2" type="radio" name="otc_meaning" <?php echo isset($user_details_emailname['otc_meaning']) ? $user_details_emailname['otc_meaning'] ? '' : ' checked' : '' ?>  value="2"/>Contract that are traded publicly through a regulated Stock - Exchange or other intermediary.</label><br>

                        <label class="radio-inline"> <input id="otc-3" type="radio" name="otc_meaning"<?php echo isset($user_details_emailname['otc_meaning']) ? $user_details_emailname['otc_meaning'] ? '' : ' checked' : '' ?>  value="3"/>Contract that are traded (and privately negotiated) directly beetween unknown parties, which sometimes are traded through a regulated Stock - Exchange.</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="position">The market is moving against your position. What is the result of you CFD position if your equity reaches stop-out level. </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="cfd_equity_stop_out_level" id="cfd_equity_stop_out_level">
                            <?php echo $cfd_equity_stop_out_level;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="position">Trading with a higher leverage in CFDs means? </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="cfd_higher_leverage" id="cfd_higher_leverage">
                            <?php echo $cfd_higher_leverage;?></select>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus  col-sm-4 col-xs-12" for="account">The market is moving against your and your account has a stop-out level of 50%. Your account will be stopped out in which of the following situations? </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="stop_out_level_50" id="stop_out_level_50">
                            <?php echo $stop_out_level_50;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="politically">Are you currently or have ypu previously been Politically Exposed Person? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input type="radio"  value="1" <?php echo isset($user_details_emailname['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? ' checked' : '' : '' ?> name="politically_exposed_person" id="politically_exposed_person1"><?=lang('reli_ye');?></label>
                        <label class="radio-inline"><input type="radio" value="0"<?php echo isset($user_details_emailname['politically_exposed_person']) ? $user_details_emailname['politically_exposed_person'] ? '' : ' checked' : ' checked' ?> name="politically_exposed_person" id="politically_exposed_person"  ><?=lang('reli_no');?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="investrisk">Understand Investment Risk </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details_emailname['risk']) ? $user_details_emailname['risk'] ? ' checked' : '' : ' checked' ?> id="risk1" type="radio" class="rdo-btn-required" name="risk" /><span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"<input value="0"<?php echo isset($user_details_emailname['risk']) ? $user_details_emailname['risk'] ? '' : ' checked' : '' ?> id="risk" type="radio" class="rdo-btn-required" name="risk" /> <span><?=lang('reli_no');?></span></label>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="bankruptcy">Have you ever declared Bankruptcy? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details_emailname['bankruptcy']) ? $user_details_emailname['bankruptcy'] ? ' checked' : '' : '' ?> id="bankruptcy1" type="radio" class="rdo-btn-required" name="bankruptcy" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details_emailname['bankruptcy']) ? $user_details_emailname['bankruptcy'] ? '' : ' checked' : 'checked' ?> id="bankruptcy" type="radio" class="rdo-btn-required" name="bankruptcy" />
                            <span><?=lang('reli_no');?></span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="seminar">I have attended a seminar or course on Forex/CFDs Trading? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details_emailname['seminar_attended']) ? $user_details_emailname['seminar_attended'] ? ' checked' : '' : ' checked' ?> id="seminar_attended1" type="radio" class="rdo-btn-required" name="seminar_attended" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details_emailname['seminar_attended']) ? $user_details_emailname['seminar_attended'] ? '' : ' checked' : '' ?> id="seminar_attended" type="radio" class="rdo-btn-required" name="seminar_attended" />
                            <span><?=lang('reli_no');?></span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="experience">Do you have any experience or relevant qualification to understand the nature of the risk involved in trading leveraged products such as OTC derivatives? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details_emailname['trading_leverage_experience']) ? $user_details_emailname['trading_leverage_experience'] ? ' checked' : '' :  ' ' ?> id="trading_leverage_experience1" type="radio" class="rdo-btn-required" name="trading_leverage_experience" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details_emailname['trading_leverage_experience']) ? $user_details_emailname['trading_leverage_experience'] ? '' : ' checked' : ' checked' ?> id="trading_leverage_experience" type="radio" class="rdo-btn-required" name="trading_leverage_experience" />
                            <span><?=lang('reli_no');?></span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="affiliate">Affiliate Code </label>
                    <div class="col-sm-3">
                        <input type="hidden" name="hidden_affiliate_code" value="<?php echo $aff_code;?>">
                        <?php if(empty($aff_code)){ ?>
                            <input type="text" class="form-control round-0 required" maxlength="32" placeholder="<?=lang('reli_34');?>" name="affiliate_code" value="">
                        <?php  }else{ ?>
                            <input type="text" class="form-control round-0 required" maxlength="32" placeholder="<?php echo $aff_code;?>" name="affiliate_code" value="">
                        <?php  } ?>
                        <span id="error-msg-code" style="color: red;"></span>
                    </div>

                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12  next-employment">
                        <button class="btn btn-success prevBtn pull-left" type="button"><?=lang('reli_ba');?></button>
                        <button class="btn btn_next_employment btn-success pull-right" type="button"><?=lang('reli_ne');?></button>
                    </div>
                </div>


            </div>
        </div>

        <div class="row setup-content" id="step-3">
            <div class="col-md-12 fix-height-scroll">

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="employee"><?= lang('reli_27'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="employment_status" id="employment_status" <?= isset($user_details_emailname['employment_status'])?'disabled':'';?>>
                            <?php echo $employment_status; ?>
                        </select>
<!--                        <input id="employment_status" type="hidden" name="employment_status" value="--><?php //echo $user_details_emailname['employment_status'];?><!--"/>-->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="industry"><?= lang('reli_28'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="industry" id="industry" <?= isset($user_details_emailname['industry'])?'disabled':'';?>><?php echo $industry;?>>
                            <?php echo $industry; ?>
                        </select>
<!--                        <input id="industry" type="hidden" name="industry" value="--><?php //echo $user_details_emailname['industry'];?><!--"/>-->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="income"><?= lang('reli_29'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="estimated_annual_income" id="estimated_annual_income" <?= isset($user_details_emailname['estimated_annual_income'])?'disabled':'';?>>
                            <?php echo $estimated_annual_income; ?>
                        </select>
<!--                        <input id="estimated_annual_income" type="hidden" name="estimated_annual_income"value="--><?php //echo $user_details_emailname['estimated_annual_income'];?><!--"/>-->

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="worth"><?= lang('reli_30'); ?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control"  name="estimated_net_worth" id="estimated_net_worth" <?= isset($user_details_emailname['estimated_net_worth'])?'disabled':'';?>>
                            <?php echo $estimated_net_worth; ?>
                        </select>
<!--                        <input id="estimated_net_worth" type="hidden" name="estimated_net_worth" value="--><?php //echo $user_details_emailname['estimated_net_worth'];?><!--"/>-->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="education"><?= lang('reli_31'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="education_level" id="education_level" <?= isset($user_details_emailname['education_level'])?'disabled':'';?>>
                            <?php echo $education_level; ?>
                        </select>
<!--                        <input id="education_level" type="hidden" name="education_level" value="--><?php //echo $user_details_emailname['education_level'];?><!--"/>-->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="tax">Tax Identification Number (TIN) </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control" value="<?php echo $user_details_emailname['tin'] ? $user_details_emailname['tin'] : '' ?>" name="tin" id="tin" <?= isset($user_details_emailname['tin']) ? 'disabled':''; ?> placeholder="Tax Identification Number (TIN)">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="passport">Passport Number </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo $user_details_emailname['passport_number'] ? $user_details_emailname['passport_number'] : '' ?>" name="passport" id="passport" <?= isset($user_details_emailname['passport']) ? 'disabled':''; ?> placeholder="Passport Number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority">Issuing Authority </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo $user_details_emailname['issuing_authority'] ? $user_details_emailname['issuing_authority'] : '' ?>" name="authority" id="authority" <?= isset($user_details_emailname['authority']) ? 'disabled':''; ?> placeholder="Issuing Authority">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority"><?= lang('reli_32'); ?>?</label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?></label>
                        <input id="us_resident" type="hidden" name="us_resident" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                    </div>
                </div>



                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority"><?= lang('reli_33'); ?>?</label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline">
                           <?php echo isset($user_details_emailname['us_resident']) ? $user_details_emailname['us_resident'] ? 'Yes' : ' No' : '' ?>
                        </label>
                        <input id="us_citizen" type="hidden" name="us_citizen" value="<?php echo $user_details_emailname['us_resident'];?>"/>
                    </div>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                        <button class="btn btn-success prevBtn pull-left" type="button"><?= lang('reli_ba'); ?></button>
                        <button class="btn btn-success nextBtn pull-right" type="button"><?= lang('reg_in_07'); ?></button>
                    </div>
                </div>

            </div>


    <?php if(isset($success) && $success){ ?>
    <div class="row setup-content" id="step-4">
            <div class="col-md-12">

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8 col-sm-2-offset">
                        <div id="success-div" style="padding-bottom: 2%;padding-top: 2%;" class="col-md-12">
                            <h4><?= $suc = (isset($success) && $success)? lang('reg_in_10'):lang('reg_in_11');?></h4>
                            <span><?=lang('reg_in_12');?> <?=$this->session->userdata('email')?> .</span>
                            <span><strong><?=lang('reg_in_08');?>:</strong> <?=$info['account_number']?></span>
                            <span><strong><?=lang('reg_in_09');?>:</strong> <?=$info['trader_password']?></span>
                        </div>
                    </div>
                </div>

                <hr>

            </div>
    </div>
    <?php } ?>



    <?=form_close();?>

</div>

<script>
    $('body').css('margin-top', '0');

    $( window ).load(function() {
        $('body').css('margin-top', '0');
        var success_reg = "<?php echo (isset($success) && $success)?"done":'';?>";
        if(success_reg=='done') {
            var nextStepWizard = $('div.setup-panel div a[href="#' + 'step-3' + '"]').parent().next().children("a");
            nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });



    $(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-success').addClass('btn-default');
                $item.addClass('btn-success');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allPrevBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepWizard.removeAttr('disabled').trigger('click');
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url'], input[type='tel'], input[type='number'], input[type='email'], input[type='date']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
            if(curStepBtn =='step-3' && isValid){
                document.getElementById("addAccount").submit();// Form submission
            }

        });

        $('div.setup-panel div a.btn-success').trigger('click');

        $('#mt_account_set_id').on('change', function () {
            var list = ["USD", "EUR"];
            var original = ["EUR", "USD", "GBP", "RUR", "MYR", "IDR", "THB", "CNY"];
            if ($('#mt_account_set_id').val() == 4) {
                $('#mt_currency_base option').filter(function () {
                    return $.inArray(this.value, list) == -1
                }).hide()
            } else {
                $('#mt_currency_base').find('option').remove()
                for (var i = 0; i < original.length; i++) {
                    $('#mt_currency_base').append("<option>" + original[i] + "</option>");
                }
                $('#mt_currency_base').val(selected);
            }
        });

    });



    $(document).on('click','.btn_next_employment',function(){

        var agent = $("input[name='affiliate_code']").val();
        if(agent!=''){
            $.ajax({
                type: 'POST',
                url: '<?=FXPP::my_url('registration/checkAgent')?>',
                data: {code:agent},
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        var nextStepWizard = $('div.setup-panel div a[href="#' + 'step-2' + '"]').parent().next().children("a");
                            nextStepWizard.removeAttr('disabled').trigger('click');
                    }else{
                        $("#error-msg-code").text(response.error);
                    }
                },
                error: function (jqXHR, textStatus) { }
            });
        }else{
            var nextStepWizard = $('div.setup-panel div a[href="#' + 'step-2' + '"]').parent().next().children("a");
            nextStepWizard.removeAttr('disabled').trigger('click');
        }
    });


</script>