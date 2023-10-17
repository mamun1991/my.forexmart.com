<link href="<?= $this->template->Css()?>external-register-style.css" rel="stylesheet">
<div class="container">
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
            <div class="stepwizard-step">
                <a href="#step-4" type="button" class="btn btn-default btn-circle"  disabled="disabled"><i class="fa fa-flag"></i></a>
                <p> <?=lang('reli_h4');?></p>
            </div>
        </div>
    </div>

    <form class="form-horizontal" action="" method="post">

        <div class="row setup-content" id="step-1">

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label required col-sm-4 col-xs-12" for="address"><?=lang('reli_01');?></label>
                    <div class="col-sm-6 col-sm-2-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Address field should be up to 128 characters)</sup>
                        <input maxlength="128" type="text" required="required" class="form-control" value="<?php echo isset($user_details['street']) ? $user_details['street'] : '' ?>" id="street" name= "street" placeholder="<?=lang('reli_01_1');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="city"><?=lang('reli_02');?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(City field should be up to 32 characters)</sup>
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo isset($user_details['city']) ? $user_details['city'] : '' ?>" id="city" name="city" placeholder="<?=lang('reli_02');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="state"><?=lang('reli_03');?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(State/Province field should be up to 32 characters)</sup>
                        <input maxlength="32" type="text" required="required" class="form-control" value="<?php echo isset($user_details['state']) ? $user_details['state'] : '' ?>" id="state" placeholder="<?=lang('reli_03');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="country"><?=lang('reli_04');?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Please select Country of Residence)</sup>
                        <select class="form-control" name= "country" id="country">
                            <?php echo  $countries;?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="zip"><?=lang('reli_05');?></label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Postal/Zip Code field should be up to 15 characters)</sup>
                        <input maxlength="15" type="number" required="required" class="form-control" placeholder="<?=lang('reli_05');?>" name="zip" value="<?php echo isset($user_details['zip']) ? $user_details['zip'] : '' ?>" name="zip" id="zip" placeholder="Postal/Zip Code">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="telephone">Telephone Number </label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Phone number field should be up to 32 characters)</sup>
                        <input maxlength="32" type="tel" required="required" class="form-control" name="phone" id="telephone" placeholder="Telephone">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required  col-sm-4 col-xs-12" for="phone">Mobile Number </label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <sup class="pull-right note-at-top">(Phone number field should be up to 32 characters)</sup>
                        <input maxlength="32" type="tel" required="required" class="form-control" value="<?php echo isset($user_details['phone1']) ? $user_details['phone1'] : '+'.$calling_code ?>" name="phone" id="phone" placeholder="Phone">
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
                        <input maxlength="2" type="number" required="required" class="form-control" value="<?php echo isset($user_details['age']) ? $user_details['age'] : '' ?>" name="age" id="age" placeholder="Age">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="birth"><?=lang('reli_07');?></label>
                    <div class="col-sm-3 col-sm-5-offset col-xs-12">
                        <input type="date" required="required" class="form-control" value="<?php echo isset($user_details['dob']) ? date('Y-m-d', strtotime($user_details['dob'])) : '' ?>" name= "dob" id="birth" placeholder="<?=lang('reli_07');?>">
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

        <div class="row setup-content" id="step-2">
            <div class="col-md-12">

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
                        <label><input type="checkbox" name="swap_free" <?php echo isset($user_details['swap_free']) ? $user_details['swap_free'] ? ' checked' : '' : '' ?> value="1" ><?=lang('reli_15');?></label>
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
                        <sup class="note-at-top info">How would you caracterized your investment knowledge and experience?</sup>
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
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="politically">Are you currently or have ypu previously been Politically Exposed Person? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input type="radio"  value="1" <?php echo isset($user_details['politically_exposed_person']) ? $user_details['politically_exposed_person'] ? ' checked' : '' : '' ?> name="politically_exposed_person" id="politically_exposed_person1"><?=lang('reli_ye');?></label>
                        <label class="radio-inline"><input type="radio" value="0"<?php echo isset($user_details['politically_exposed_person']) ? $user_details['politically_exposed_person'] ? '' : ' checked' : ' checked' ?> name="politically_exposed_person" id="politically_exposed_person"  ><?=lang('reli_no');?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="otc">What is the meaning of Over The Counter ("OTC") derivatives? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input id="otc-1" type="radio" name="otc_meaning" <?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? ' checked' : '' : ' checked' ?> value="1"/>Contract that are traded (and privately negotiated) directly beetween two parties, without going through an exchange or other intermediary.</label><br>

                        <label class="radio-inline"> <input id="otc-2" type="radio" name="otc_meaning" <?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? '' : ' checked' : '' ?>  value="2"/>Contract that are traded publicly through a regulated Stock - Exchange or other intermediary.</label><br>

                        <label class="radio-inline"> <input id="otc-3" type="radio" name="otc_meaning"<?php echo isset($user_details['otc_meaning']) ? $user_details['otc_meaning'] ? '' : ' checked' : '' ?>  value="3"/>Contract that are traded (and privately negotiated) directly beetween unknown parties, which sometimes are traded through a regulated Stock - Exchange.</label>
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
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="investrisk">Understand Investment Risk </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details['risk']) ? $user_details['risk'] ? ' checked' : '' : ' checked' ?> id="risk1" type="radio" class="rdo-btn-required" name="risk" /><span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"<input value="0"<?php echo isset($user_details['risk']) ? $user_details['risk'] ? '' : ' checked' : '' ?> id="risk" type="radio" class="rdo-btn-required" name="risk" /> <span><?=lang('reli_no');?></span></label>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="bankruptcy">Have you ever declared Bankruptcy? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details['bankruptcy']) ? $user_details['bankruptcy'] ? ' checked' : '' : ' checked' ?> id="bankruptcy1" type="radio" class="rdo-btn-required" name="bankruptcy" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details['bankruptcy']) ? $user_details['bankruptcy'] ? '' : ' checked' : '' ?> id="bankruptcy" type="radio" class="rdo-btn-required" name="bankruptcy" />
                            <span><?=lang('reli_no');?></span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="seminar">I have attended a seminar or course on Forex/CFDs Trading? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details['seminar_attended']) ? $user_details['seminar_attended'] ? ' checked' : '' : ' checked' ?> id="seminar_attended1" type="radio" class="rdo-btn-required" name="seminar_attended" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details['seminar_attended']) ? $user_details['seminar_attended'] ? '' : ' checked' : '' ?> id="seminar_attended" type="radio" class="rdo-btn-required" name="seminar_attended" />
                            <span><?=lang('reli_no');?></span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="experience">Do you have any experience or relevant qualification to understand the nature of the risk involved in trading leveraged products such as OTC derivatives? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input value="1"<?php echo isset($user_details['trading_leverage_experience']) ? $user_details['trading_leverage_experience'] ? ' checked' : '' : '' ?> id="trading_leverage_experience1" type="radio" class="rdo-btn-required" name="trading_leverage_experience" />
                            <span><?=lang('reli_ye');?></span></label>
                        <label class="radio-inline"> <input value="0"<?php echo isset($user_details['trading_leverage_experience']) ? $user_details['trading_leverage_experience'] ? '' : ' checked' : ' checked' ?> id="trading_leverage_experience" type="radio" class="rdo-btn-required" name="trading_leverage_experience" />

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="affiliate">Affiliate Code </label>
                    <div class="col-sm-3">
                        <input maxlength="32" type="text"  class="form-control"  name="affiliateCodeStr" value="<?php echo $referral_code;?>" id="affiliateCodeStr" placeholder="<?=lang('reli_34');?>">
                        <input type="hidden" name="affiliate_code" id="affiliate_code" value="<?php echo $referral_code;?>">
                        <input type="hidden" name="isSubscribe" id="isSubscribe" value="0">
                    </div>
                    <div class="col-sm-5 pop"> <a id="popoverOption" class="btn" href="#" data-content="lorem ipsum dolor sit amet" rel="popover" data-placement="right" ><i class="fa fa-question-circle"></i></a></div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                        <button class="btn btn-success prevBtn pull-left" type="button"><?=lang('reli_ba');?></button>
                        <button class="btn btn-success nextBtn pull-right" type="button"><?=lang('reli_ne');?></button>
                    </div>
                </div>


            </div>
        </div>

        <div class="row setup-content" id="step-3">
            <div class="col-md-12">

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="employee"><?= lang('reli_27'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="employment_status" id="employment_status">
                            <?php echo $employment_status; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="industry"><?= lang('reli_28'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="industry" id="industry">
                            <?php echo $industry; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="income"><?= lang('reli_29'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="estimated_annual_income" id="estimated_annual_income">
                            <?php echo $estimated_annual_income; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="worth"><?= lang('reli_30'); ?></label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control"  name="estimated_net_worth" id="estimated_net_worth">
                            <?php echo $estimated_net_worth; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="education"><?= lang('reli_31'); ?> </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <select class="form-control" name="education_level" id="education_level">
                            <?php echo $education_level; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="tax">Tax Identification Number (TIN) </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control" value="<?php echo isset($user_details['tin']) ? $user_details['tin'] : '' ?>" name="tin" id="tin" placeholder="Tax Identification Number (TIN)">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="passport">Passport Number </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo isset($user_details['passport']) ? $user_details['passport'] : '' ?>" name="passport" id="passport" placeholder="Passport Number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority">Issuing Authority </label>
                    <div class="col-sm-4 col-sm-4-offset col-xs-12">
                        <input maxlength="32" type="text" required="required" class="form-control"  value="<?php echo isset($user_details['authority']) ? $user_details['authority'] : '' ?>" name="authority" id="authority" placeholder="Issuing Authority">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority"><?= lang('reli_32'); ?>?</label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input type="radio" value="1"<?php echo isset($user_details['us_resident']) ? $user_details['us_resident'] ? '' : ' checked' : '' ?>  name="us_resident" id="us_resident1" ><?= lang('reli_ye'); ?></label>
                        <label class="radio-inline"><input type="radio" value="0"<?php echo isset($user_details['us_resident']) ? $user_details['us_resident'] ? '' : ' checked' : ' checked' ?> name="us_resident" id="us_resident"><?= lang('reli_no'); ?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label required-plus col-sm-4 col-xs-12" for="authority"><?= lang('reli_33'); ?>? </label>
                    <div class="col-sm-8 col-xs-12">
                        <label class="radio-inline"><input type="radio"  value="1"<?php echo isset($user_details['us_resident']) ? $user_details['us_resident'] ? '' : ' checked' : '' ?> id="us_citizen" name="us_citizen"><?= lang('reli_ye'); ?></label>
                        <label class="radio-inline"><input type="radio"  value="0"<?php echo isset($user_details['us_citizen']) ? $user_details['us_citizen'] ? '' : ' checked' : ' checked' ?> id="us_citizen"  name="us_citizen" ><?= lang('reli_no'); ?></label>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                        <button class="btn btn-success prevBtn pull-left" type="button"><?= lang('reli_ba'); ?></button>
                        <button class="btn btn-success nextBtn pull-right" type="button"><?= lang('reli_ne'); ?></button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row setup-content" id="step-4">

            <div class="col-md-12">

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8 col-sm-2-offset">
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat?</p>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6 col-xs-12">
                        <button class="btn btn-success prevBtn pull-left" type="button">Previous</button>
                        <button class="btn btn-success nextBtn pull-right" type="submit">Submit</button>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>
