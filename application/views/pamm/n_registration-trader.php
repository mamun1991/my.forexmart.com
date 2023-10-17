<style type="text/css">
    .page{
        display:none;
    }
</style>
<div class="pamm-onclick-page destination-class page" id="pamm-div-trader">
    <?=$nav?>
    <div id="my-tab-content" class="tab-content pamm-tab-content">
        <div class="tab-pane active" id="secondary-pamm-profile">
            <?php if(isset($_SESSION['trader_update'])){?>
                <div id="trader_registration_prompt" style="text-align: center;">
                <?php if($_SESSION['trader_success']==True){?>
                        <div class="alert alert-success"><strong>Trader Update:</strong>  Update is successful.</div>
                <?php }else{?>
                        <div class="alert alert-warning"><strong>Trader Update:</strong>  Update failed.</div>
                <?php }?>
                </div>
                <?php unset($_SESSION['trader_update']);?>
            <?php }else{?>

            <?php } ?>
            <?php if(isset($_SESSION['trader_register'])){?>

                <div id="trader_registration_prompt" style="text-align: center;">
                    <?php if($_SESSION['trader_success']==True){?>
                        <div class="alert alert-success"><strong>Registration Update:</strong>  Registration is successful.</div>
                    <?php }else{?>
                        <div class="alert alert-warning"><strong>Registration Update:</strong>  Registration failed.</div>
                    <?php }?>
                </div>

                <?php unset($_SESSION['trader_register']);?>
            <?php }else{?>
            <?php } ?>
            <form action="<?=FXPP::my_url('pamm')?>" id="trader_registration" method="post"  accept-charset="UTF-8" autocomplete="off">
                <input type="hidden" value="trader" name="type" />
                    <div class="pamm-content-input deact" >
                        <style type="text/css">
                            body{color: #333!important;}
                            .custom_h1{font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 18px;color: #333;}
                            .custom_h1_uline{border-bottom: 1px solid rgb(41, 136, 202);}
                        </style>

                        <div class="custom_h1_uline">
                            <label for="traderprojectname" class="custom_h1">
                                <!--Account Information-->
                                <?= lang('pamm_106'); ?>
                            </label>
                        </div>


                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderprojectname" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_85_title')!='')?lang('pamm_85_title'):'Short name of your PAMM project to be displayed in Monitoring.'; ?>" ><?= lang('pamm_85'); ?> <span class="required-field"><?= lang('pamm_107'); ?></span></label>
                            <input type="text" class="form-control round-0" placeholder="<?= lang('pamm_85'); ?>" name="traderprojectname"  id="traderprojectname" value="<?= set_value('traderprojectname') == false ? (isset($infor['project_name'])?$infor['project_name']:'') : set_value('traderprojectname') ?>" />

                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderdescEN" data-toggle="tooltip" data-placement="top" title="<?=(lang('pamm_108_title')!='')?lang('pamm_108_title'):'Full description about your project (1500 symbols)'; ?>">
                                <?= lang('pamm_108'); ?>
                            </label>
                            <textarea class="form-control round-0" placeholder="<?= lang('pamm_108'); ?>" name="traderdescEN"  maxlength="1500" id="traderdescEN"><?= set_value('traderdescEN') == false ? (isset($infor['description'])?$infor['description']:'') : set_value('traderdescEN') ?></textarea>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderdescRU" data-toggle="tooltip" data-placement="top" title="<?=(lang('pamm_109_title')!='')?lang('pamm_109_title'):'Detailed description of your project in Russian (max. 1500 symbols, if there is no description in Russian, the one in English shall be shown)'; ?>" ><?= lang('pamm_109'); ?></label>
                            <textarea class="form-control round-0" placeholder="<?= lang('pamm_109'); ?>" name="traderdescRU" id="traderdescRU" maxlength="1500"><?= set_value('traderdescRU') == false ? (isset($infor['description_russian'])?$infor['description_russian']:'') : set_value('traderdescRU') ?></textarea>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderdescJP" data-toggle="tooltip" data-placement="top" title="<?=(lang('pamm_110_title')!='')?lang('pamm_110_title'):'Detailed description of your project in Japanese (max. 1500 symbols, if there is no description in Russian, the one in English shall be shown)'; ?>"><?= lang('pamm_110'); ?></label>
                            <textarea class="form-control round-0" placeholder="<?= lang('pamm_110'); ?>" name="traderdescJP" id="traderdescJP" maxlength="1500"><?= set_value('traderdescJP') == false ? (isset($infor['description_japanese'])?$infor['description_japanese']:''): set_value('traderdescJP') ?></textarea>
                        </div>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderdescPL" data-toggle="tooltip" data-placement="top" title="<?=(lang('pamm_111_title')!='')?lang('pamm_111_title'):'Detailed description of your project in Polish (max. 1500 symbols, if there is no description in Russian, the one in English shall be shown)'; ?>"><?= lang('pamm_111'); ?></label>
                            <textarea class="form-control round-0" placeholder="<?= lang('pamm_111'); ?>" name="traderdescPL" id="traderdescPL" maxlength="1500"><?= set_value('traderdescPL') == false ? (isset($infor['description_polish'])?$infor['description_polish']:'') : set_value('traderdescPL') ?></textarea>
                        </div>
                    </div>

                    <div class="pamm-content-input deact">
                        <div class="custom_h1_uline">
                            <label class="custom_h1"><?= lang('pamm_30'); ?></label>
                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderName" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_31_title')!='')?lang('pamm_31_title'):'Your full name identical to the trading account name to be hidden in Monitoring.'; ?>" ><?= lang('pamm_31'); ?></label>

                            <div class="row">
                                <div class="col-lg-7">
                                    <input id="traderName" type="text" class="form-control round-0" placeholder="<?= lang('pamm_31'); ?>" name="traderName" maxlength="100" value="<?= set_value('traderName') == false ? $investor_name : set_value('traderName') ?>" />
                                </div>
                                <div class="col-lg-5">
                                    <select name="sel_name_showhide" id="sel_name_showhide">
                                        <option value="0" selected>
                                            <!--Hidden-->
                                            <?= (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ; ?>
                                        </option>
                                        <option value="1" >
                                            <!--Available to investors-->
                                            <?= (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ; ?>
                                        </option>
                                        <option value="2" >
                                            <!--Available to all-->
                                            <?= (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ; ?>
                                        </option>
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $().ready(function(){
                                        $('select[name=sel_name_showhide]').val('<?= set_value('sel_name_showhide') == false ? (isset($infor['show_account_name'])?$infor['show_account_name']:0) : set_value('sel_name_showhide') ?>');
                                        $('select[name=sel_name_showhide]').select2({});
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderSkype"><?= lang('pamm_32'); ?></label>

                            <div class="row">
                                <div class="col-lg-7">
                                    <input type="text" class="form-control round-0" placeholder="<?= lang('pamm_32'); ?>"  name="traderSkype" maxlength="100" id="traderSkype" value="<?= set_value('traderSkype') == false ? (isset($infor['skype'])?$infor['skype']:"") : set_value('traderSkype') ?>"/>
                                </div>
                                <div class="col-lg-5">
                                    <select name="sel_skype_showhide" id="sel_skype_showhide">
                                        <option value="0" selected>
                                            <!--Hidden-->
                                            <?= (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ; ?>
                                        </option>
                                        <option value="1" >
                                            <!--Available to investors-->
                                            <?= (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ; ?>
                                        </option>
                                        <option value="2" >
                                            <!--Available to all-->
                                            <?= (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ; ?>
                                        </option>
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $().ready(function(){
                                        $('select[name=sel_skype_showhide]').val('<?= set_value('sel_skype_showhide') == false ? (isset($infor['show_skype'])?$infor['show_skype']:0) : set_value('sel_skype_showhide') ?>');
                                        $('select[name=sel_skype_showhide]').select2({});
                                    });
                                </script>
                            </div>

                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderIcq"><?= lang('pamm_33'); ?></label>
                            <div class="row">
                                <div class="col-lg-7">
                                    <input id="traderIcq" type="text" class="form-control round-0" placeholder="<?= lang('pamm_33'); ?>" name="traderIcq" maxlength="9" value="<?= set_value('traderIcq') == false ? (isset($infor['icq'])?$infor['icq']:"") : set_value('traderIcq') ?>"/>
                                </div>
                                <div class="col-lg-5">
                                    <select name="sel_icq_showhide" id="sel_icq_showhide">
                                        <option value="0" selected>
                                            <!--Hidden-->
                                            <?= (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ; ?>
                                        </option>
                                        <option value="1" >
                                            <!--Available to investors-->
                                            <?= (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ; ?>
                                        </option>
                                        <option value="2" >
                                            <!--Available to all-->
                                            <?= (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ; ?>
                                        </option>
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $().ready(function(){
                                        $('select[name=sel_icq_showhide]').val('<?= set_value('sel_icq_showhide') == false ? (isset($infor['show_icq'])?$infor['show_icq']:0) : set_value('sel_icq_showhide') ?>');
                                        $('select[name=sel_icq_showhide]').select2({});
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderYahoo">
                                <?= (lang('pamm_33_1')!='')?lang('pamm_33_1'):'Yahoo';?>
                            </label>
                            <div class="row">

                                <div class="col-lg-7">
                                    <input id="traderYahoo" type="text" class="form-control round-0" placeholder=" <?= (lang('pamm_33_1')!='')?lang('pamm_33_1'):'Yahoo';?>" name="traderYahoo" maxlength="100" value="<?= set_value('traderYahoo') == false ? (isset($infor['yahoo'])?$infor['yahoo']:"") : set_value('traderYahoo') ?>"/>
                                </div>

                                <div class="col-lg-5">
                                    <select name="sel_yahoo_showhide" id="sel_yahoo_showhide">
                                        <option value="0" selected>
                                            <!--Hidden-->
                                            <?= (lang('pamm_opt1')!='')? lang('pamm_opt1') : 'Hidden' ; ?>
                                        </option>
                                        <option value="1" >
                                            <!--Available to investors-->
                                            <?= (lang('pamm_opt2')!='')? lang('pamm_opt2') : 'Available to investors' ; ?>
                                        </option>
                                        <option value="2" >
                                            <!--Available to all-->
                                            <?= (lang('pamm_opt3')!='')? lang('pamm_opt3') : 'Available to all' ; ?>
                                        </option>
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $().ready(function(){
                                        $('select[name=sel_yahoo_showhide]').val('<?= set_value('sel_yahoo_showhide') == false ? (isset($infor['show_yahoo'])?$infor['show_yahoo']:0) : set_value('sel_yahoo_showhide') ?>');
                                        $('select[name=sel_yahoo_showhide]').select2({});
                                    });
                                </script>
                            </div>

                        </div>
                    </div>

                    <div class="pamm-content-input deact ">
                        <div class="custom_h1_uline">
                            <label class="custom_h1"><?= lang('pamm_34'); ?></label>
                        </div>

                        <div  class=" pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="traderStartTime" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_112_title')!='')?lang('pamm_31_title'):'Time from whom your monitoring show'; ?>" ><?= lang('pamm_112'); ?></label>
                            <div class="input-group date datetime col-md-5"  data-date-format="mm-dd-yyyy HH:ii:ss" data-link-field="dtp_input1">
                                <input id="traderStartTime" type="text" class="form-control round-0" placeholder="Start Time" name="traderStartTime" value="<?= set_value('traderStartTime') == false ? (isset($infor['start_time'])?$infor['start_time']:FXPP::getServerTime()) : set_value('traderStartTime') ?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>
                        <!--custom-->
                        <script type="text/javascript">
                            $('.datetime').datetimepicker({
                                language:  '<?= FXPP::html_url(); ?>',
                                weekStart: 1,
                                todayBtn:  1,
                                autoclose: 1,
                                todayHighlight: 1,
                                startView: 2,
                                forceParse: 0,
                                showMeridian: 1
                            });
                        </script>
                        <!--custom-->

                        <?php if($trader_registration==true){?>

                            <div class="pamm-content-input-box pamm-trader-list col-lg-8 col-md-10 col-sm-12 col-xs-12">
                                <ul>
                                    <li style="display: none;">
                                        <?php
                                        if (isset($infor['email_alerts']) && ($infor['email_alerts']==1 )){
                                            $check0='checked';
                                        }else{
                                            $check0='';
                                        }
                                        ?>
                                        <input type="checkbox" name="trader_emailalerts" id="trader_emailalerts" value="1" <?= set_value('trader_emailalerts') == false ? $check0 :  (set_value('trader_emailalerts')==1)?'checked':''  ?> />
                                        <label id="lbl1"  for="trader_emailalerts" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_113_title')!='')?lang('pamm_113_title'):'Time from whom your monitoring show'; ?>" >
                                            <?= lang('pamm_113'); ?></label>
                                    </li>
                                    <li>
                                        <?php
                                        if (isset($infor['sms_alerts']) && ($infor['sms_alerts']==1 )){
                                            $check1='checked';
                                        }else{
                                            $check1='';
                                        }
                                        ?>
                                        <input type="checkbox" name="trader_smsalerts" id="trader_smsalerts" value="1" <?= set_value('trader_smsalerts') == false ? $check1 :  (set_value('trader_smsalerts')==1)?'checked':'' ?> />
                                        <label id="lbl2"  for="trader_smsalerts" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_114_title')!='')?lang('pamm_114_title'):'The maximal number of sms for one user is 10 per day'; ?>">
                                            <?= lang('pamm_114'); ?>
                                        </label>
                                    </li>
                                    <li>
                                        <?php
                                        if (isset($infor['is_auto_investment_agree']) && ($infor['is_auto_investment_agree']==1 )){
                                            $check2='checked';
                                        }else{
                                            $check2='';
                                        }
                                        ?>
                                        <input type="checkbox" name="trader_approveinvestmentauto" id="trader_approveinvestmentauto" value="1" <?= set_value('trader_approveinvestmentauto') == false ? $check2 : (set_value('trader_approveinvestmentauto')==1)?'checked':'' ?> />
                                        <label id="lbl3" for="trader_approveinvestmentauto" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_115_title')!='')?lang('pamm_115_title'):'Investments are automatically approved when sent to your PAMM-account'; ?>" >
                                            <?= lang('pamm_115'); ?>
                                        </label>
                                    </li>
                                    <li>
                                        <?php
                                        if (isset($infor['confirm_investement_refund']) && ($infor['confirm_investement_refund']==1 )){
                                            $check3='checked';
                                        }else{
                                            $check3='';
                                        }
                                        ?>
                                        <input type="checkbox" name="trader_cir" id="trader_cir" value="1" <?= set_value('trader_cir') == false ? $check3 : (set_value('trader_cir')==1)?'checked':'' ?>/>
                                        <label id="lbl4" for="trader_cir" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_116_title')!='')?lang('pamm_116_title'):'It is designed to protect every investment from accidental refund. If the option is enabled, you will have to confirm every refund of the investment to PAMM investor account'; ?>">
                                            <?= lang('pamm_116'); ?></label>
                                    </li>
                                </ul>
                            </div>

                            <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                                <label for="trader_hidetradesforall" id="lbl_trader_hidetradesforall" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_117_title')!='')?lang('pamm_117_title'):'Time from whom your monitoring show'; ?>">
                                    <!--Hide trades for all-->
                                    <?= lang('pamm_117'); ?>
                                </label>
                                <select class="form-control round-0 margin-ref select-box" name="trader_hidetradesforall" id="trader_hidetradesforall">
                                    <option default="" selected="" value="0">
                                        <!--Do not hide-->
                                        <?= (lang('pamm_118')!='')?lang('pamm_118'):'Do not hide'; ?>
                                    </option>
                                    <option value="1">
                                        <!--Hide trades for all-->
                                        <?= (lang('pamm_118_1')!='')?lang('pamm_118_1'):'Hide trades for all'; ?>
                                    </option>
                                    <option value="2">
                                        <!--For all excluding my investors-->
                                        <?= (lang('pamm_118_2')!='')?lang('pamm_118_2'):'For all excluding my investors'; ?>
                                    </option>
                                </select>
                                <script type="text/javascript">
                                    $().ready(function(){
                                        $('select[name=trader_hidetradesforall]').val('<?= set_value('trader_hidetradesforall') == false ? (isset($infor['hide_trades_for_all'])?$infor['hide_trades_for_all']:0) : set_value('trader_hidetradesforall') ?>');
                                        $('select[name=trader_hidetradesforall]').select2({});
                                    });
                                </script>
                            </div>

                        <?php }else{?>



                        <?php }?>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="trader_langauge" id="lbl_trader_langauge" data-toggle="tooltip" data-placement="top"  >
                                <!--System notification&#39;s language-->
                                <?= lang('pamm_119'); ?>
                            </label>
                            <select class="form-control round-0 margin-ref select-box" name="trader_langauge" id="trader_langauge">
                                <option default="" selected="" value="en">
                                    <!--English-->
                                    <?= (lang('pamm_en')!='')?lang('pamm_en'):'English' ;?>
                                </option>
                                <option value="ru">
                                    <!--Русский-->
                                    <?= (lang('pamm_ru')!='')?lang('pamm_ru'):'Русский' ;?>
                                </option>
                            </select>
                            <script type="text/javascript">
                                $().ready(function(){
                                    $('select[name=trader_langauge]').val('<?= set_value('trader_langauge') == false ? (isset($infor['config_language'])?$infor['config_language']:'en') : set_value('trader_langauge') ?>');
                                    $('select[name=trader_langauge]').select2({});
                                });
                            </script>
                        </div>

                    </div>
                    <?php if($trader_registration==true){?>

                    <?php }else{?>

                        <div class="pamm-content-input deact">
                            <div class="custom_h1_uline">
                                <label class="custom_h1">
                                    Condition package № 1
                                </label>
                            </div>

                            <label class="pamm-title-sub">
                                Minimal investment timeframe
                            </label>
                            <div class="minimal-investment-holder">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 control-label t-a-r">
                                        Days:
                                    </label>
                                    <div class="col-sm-5">
                                        <div style="width: 100%;" id="c1d" name="c1d" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="90" data-slider-step="1" data-slider-value="">
                                        </div>
                                        <style type="text/css">
                                            #c1d .ui-widget-header { background: #2988CA!important;}
                                        </style>
                                        <script type="text/javascript">
                                            $("#c1d").slider({
                                                range: "min",
                                                value: '',
                                                step: 1,
                                                min: 0,
                                                max: 90,
                                                slide: function(event, ui) {
                                                    var value=ui.value;
                                                    $("input#i_c1d").val(value.toString());
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control round-0 t-a-c" id="i_c1d" name="i_c1d" value="" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 control-label t-a-r">
                                        Hours:
                                    </label>
                                    <div class="col-sm-5">
                                        <div style="width: 100%;" id="c1h" name="c1h" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="23" data-slider-step="1" data-slider-value="">
                                        </div>
                                        <style type="text/css">
                                            #c1h .ui-widget-header { background: #2988CA!important;}
                                        </style>
                                        <script type="text/javascript">
                                            $("#c1h").slider({
                                                range: "min",
                                                value: '',
                                                step: 1,
                                                min: 0,
                                                max: 23,
                                                slide: function(event, ui) {
                                                    var value=ui.value;
                                                    $("input#i_c1h").val(value.toString());
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control round-0 t-a-c" id="i_c1h" name="i_c1h" value="" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 control-label t-a-r">
                                        Project Share:
                                    </label>
                                    <div class="col-sm-5">
                                        <div style="width: 100%;" id="c1ps" name="c1ps" data-slider-id='ex1Slider' type="text" data-slider-min="1" data-slid`er-max="80" data-slider-step="1" data-slider-value="">
                                        </div>
                                        <style type="text/css">
                                            #c1ps .ui-widget-header { background: #2988CA!important;}
                                        </style>
                                        <script type="text/javascript">
                                            $("#c1ps").slider({
                                                range: "min",
                                                value: '',
                                                step: 1,
                                                min: 0,
                                                max: 10,
                                                slide: function(event, ui) {
                                                    var value=ui.value;
                                                    $("input#i_c1ps").val(value.toString().concat( ' %'));
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control round-0 t-a-c" id="i_c1ps" name="i_c1ps" value="" readonly/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-5 control-label t-a-r" >
                                        Prepayment penalty of the investment sum:
                                    </label>
                                    <div class="col-sm-5">
                                        <div style="width: 100%;" id="c1ppis" name="c1ppis" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="">
                                        </div>
                                        <style type="text/css">
                                            #c1ppis .ui-widget-header { background: #2988CA!important;}
                                        </style>
                                        <script type="text/javascript">
                                            $("#c1ppis").slider({
                                                range: "min",
                                                value: '',
                                                step: 1,
                                                min: 0,
                                                max: 20,
                                                slide: function(event, ui) {
                                                    var value=ui.value;
                                                    $("input#i_c1ppis").val(value.toString().concat( ' %'));
                                                }
                                            });
                                        </script>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control round-0 t-a-c" id="i_c1ppis" name="i_c1ppis" value="" readonly />
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php }?>
                    <div class="pamm-content-input deact">
                        <div class="custom_h1_uline">
                            <label class="custom_h1">
                                <?= lang('pamm_120'); ?>
                            </label>
                        </div>

                        <p class="conditions-mid-reward">
                            <?= lang('pamm_121'); ?>.
                        </p>
                        <div class="pamm-content-input-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="conditions-input-holder">

                                <div  class="slide visibility-slider-input conditions-slider" id="slideranger5" data-slider-min="0" data-slider-max="80" data-slider-step="10"></div>

                                <input id="slider_reg_trader_value" name="slider_reg_trader_value"  class="form-control conditions-input" type="text" value="<?= set_value('slider_reg_trader_value') == false ? (isset($infor['partner_share'])?$infor['partner_share'].' %':'0'.' %') : set_value('slider_reg_trader_value')?>" readonly />

                                <style type="text/css">
                                    #slideranger5 .ui-widget-header { background: #2988CA!important;}
                                    #slider_reg_trader_value{text-align: center;}
                                </style>

                                <script type="text/javascript">
                                    $("#slideranger5").slider({
                                        range: "min",
                                        value: '<?= set_value('slider_reg_trader_value') == false ? (isset($infor['partner_share'])?$infor['partner_share']:0) : (str_replace('%','',set_value('slider_reg_trader_value'))) ?>',
                                        step: 10,
                                        min: 0,
                                        max: 80,
                                        slide: function(event, ui) {
                                            var value=ui.value;
                                            $("input#slider_reg_trader_value").val(value.toString().concat( ' %'));
                                        }
                                    });
                                </script>

                            </div>
                        </div>
                    </div>

                <?php if($trader_registration==true){?>

                    <div class="pamm-content-input deact">
                        <div class="custom_h1_uline">
                            <label class="custom_h1">
                                <?= lang('pamm_123'); ?>
                            </label>
                        </div>

                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <label for="forumtopic">
                                <?= lang('pamm_124'); ?>
                            </label>
                            
                            <input id="forumtopic" name="forumtopic" type="text" class="form-control round-0" placeholder="<?= lang('pamm_124'); ?>" value="<?= set_value('forumtopic') == false ? (isset($infor['forum_topic'])?$infor['forum_topic']:'') : set_value('forumtopic') ?>"/>
                        </div>
                    </div>

                <?php }else{?>

                <?php }?>
                    <div class="pamm-content-input">
                        <?php if($trader_registration==true){?>
                        <label class="custom_h1">
                            <?= lang('pamm_37'); ?>
                        </label>
                        <?php }?>
                        <div class="pamm-content-input-box col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <?php if($trader_registration==true){?>
                                <?php
                                    if (isset($infor['deactivatepamm']) && ($infor['deactivatepamm']==1 )){
                                        $check4='checked';
                                    }else{
                                        $check4='';
                                    }
                                ?>
                                    <input type="checkbox" name="trader_checkbox_deactivate" id="trader_checkbox_deactivate" class="custom_a" value="1" <?= set_value('trader_checkbox_deactivate') == false ? $check4 : (set_value('trader_checkbox_deactivate')==1)?'checked':'' ?>/>

                                    <label for="trader_checkbox_deactivate" id="lbl5" data-toggle="tooltip" data-placement="top"  title="<?=(lang('pamm_37_title')!='')?lang('pamm_37_title'):'This operation is transient, so you need to return all investments.'; ?>">
                                    <?= lang('pamm_37'); ?>

                                    </label>
                            <?php }?>
                                <style type="text/css">
                                    .custom_a{
                                        margin: 10px auto;
                                        display: table;
                                        background: rgb(41, 136, 202) none repeat scroll 0% 0%;
                                        color: rgb(255, 255, 255);
                                        padding: 8px 20px;
                                        border: medium none;
                                        transition: all 0.3s ease 0s;
                                        cursor: pointer;
                                        text-decoration: none;
                                    }
                                    #trader_deactivate:hover {
                                        color: rgb(255, 255, 255);
                                        text-decoration: none;
                                    }
                                </style>

                            <?php if($trader_registration==true){?>
                                <button type="submit" name="formbutton" value="update">
                                    <!--Update-->
                                    <?= lang('pamm_38'); ?>
                                </button>
                            <?php }else{?>
                                <button type="submit" name="formbutton" value="register">
                                    <!--Register-->
                                    <?= (lang('pamm_132')!="")?lang('pamm_132'):'Register'; ?>
                                </button>
                            <?php }?>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
    /*custom*/
    .t-a-r{
        text-align: right;
    }
    .t-a-c{
        text-align: center;
    }
    /*custom*/
    .a-reg-btn{
        margin: 10px auto;
        display: table;
        background: rgb(41, 136, 202) none repeat scroll 0% 0%;
        color: rgb(255, 255, 255);
        padding: 8px 20px;
        border: medium none;
        transition: all 0.3s ease 0s;
    }
    .check{cursor: pointer;}
    .fa {
        padding-right: 0;
    }

    a {
        color: #5874BF;
        text-decoration: none;
    }
    a:hover {
        color: #112763;
    }

    .pamm-landing-page {
        display:table;
        margin-bottom:20px;
    }

    .pamm-landing-intro p {
        padding:10px 0;
        text-align:justify;
    }

    .pamm-landing-intro p , .pamm-landing-intro ul {
        margin-bottom:0!important;
    }

    .pamm-landing-agreement h1 {
        text-align:center;
        font-size:20px;
        color:#2988CA;
    }

    .pamm-agreement-content {
        width:90%;
        margin:20px auto;
        padding:10px;
        height:300px;
        overflow-y:scroll;
        border:1px solid #cacaca;
    }

    .pamm-agreement-content p {
        font-weight:600;
    }

    .pamm-agreement-list-parent , .pamm-agreement-list-child {
        padding:0 15px!important;
    }

    .pamm-agreement-list-parent li {
        padding:5px 0;
    }

    .pamm-agreement-list-parent li span {
        font-weight:600;
        color:#ff0000;
    }

    .pamm-agreement-list-child li {
        padding:0;
    }

    .pamm-agreement-checkbox {
        display:table;
        margin:0 auto;
    }

    .pamm-agreement-checkbox input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-select-account {
        margin:20px 0;
        width:100%;
        display:table;
    }

    .pamm-select-account-child {
        width:100%;
        display:table;
    }

    .pamm-select-account-child img {
        margin:0 auto!important;
        display:table;
    }

    .pamm-select-account-child a {
        background:#2988ca;
        color:#fff;
        text-align:center;
        padding:10px 20px;
        font-size:15px;
        margin:0 auto;
        margin-top:-15px;
        display:table;
        text-decoration:none;
        transition: all ease 0.3s;
    }

    .pamm-select-account-child p {
        margin-top:10px;
        text-align:center;
    }

    .pamm-onclick-page {
        width:100%;
        margin:20px 0;
        display:none;
    }

    .pamm-tab-content {
        border:1px solid #ddd;
    }

    .pamm-btn {
        padding:0;
        background:none;
        color: #333;
        font-size: 15px;
        margin:0!important;
        line-height:12px!important;
    }

    .pamm-btn-secondary {
        padding-right:0!important;
    }

    .pamm-btn-group.open .dropdown-toggle , .pamm-btn:focus , .pamm-btn:hover {
        box-shadow:none;
    }

    .pamm-dropdown-menu {
        margin-top:5px!important;
        border-radius:0!important;
        padding:0!important;
    }

    .pamm-dropdown-menu ul {
        position:relative;
        padding:0!important;
    }

    .pamm-dropdown-menu ul li {
        list-style-type:none;
        padding:5px;
        cursor:pointer;
    }

    .pamm-dropdown-menu ul li:hover {
        background:#f0f0f0;
    }

    .navbar-brand-internal{
        margin-top: 4px!important;
    }

    /*----- PAMM ONCLICK PAGE -----*/
    .pamm-nav-tabs {
        background:#eee;
        border:1px solid #ddd;
    }

    .pamm-nav-tabs li a {
        color:#333;
        font-size:15px;
    }

    .pamm-nav-tabs .active a {
        border-radius:0;
        border:none!important;
        border-bottom:2px solid #fff!important;
        font-weight:600;
    }
    .pamm-tab-content {
        margin-top:-1px;
        padding:10px;
        /*display:table;*/
        width:100%;
    }

    /*----- PAMM PROFILE TAB -----*/

    .pamm-content-input {
        width:90%;
        margin:0 auto;
    }

    .pamm-content-input h1 {
        border-bottom:1px solid #2988CA;
        color:#333;
        text-align:left;
        font-size:18px;
        font-weight:600;
        padding:5px;
    }

    .pamm-content-input-box {
        margin:10px auto!important;
        display:table;
        float:none!important;
    }

    .pamm-content-input-box textarea {
        resize:vertical;
    }

    .pamm-content-input-box label {
        margin-bottom:0;
    }

    .pamm-content-input-box input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-content-input-box button , .pamm-investment-parent button , .pamm-investment-secondary button {
        margin:10px auto;
        display:table;
        background: #2988CA;
        color: #fff;
        padding:8px 20px;
        border:none;
        transition: all ease 0.3s;
    }

    .pamm-content-input-box button:hover , .pamm-investment-parent button:hover , .pamm-investment-secondary button:hover {
        background:#319ae3;
    }

    .required-field {
        font-size:12px;
        font-weight:normal;
        color:#ff0000;
    }

    .hide-unhide-input-box {
        display:table;
        float:right;
    }

    .show-button , .hide-button {
        display:block;
        width:20px;
        height:20px;
        float:left;
        margin:0 1px;
        transition: all ease 0.3s;
    }

    .show-button {
        background:url(../assets/images/show-eye-button.png);
    }

    .show-button:hover {
        background:url(../assets/images/show-eye-button-hover.png);
    }

    .hide-button {
        background:url(../assets/images/hide-eye-button.png);
    }

    .hide-button:hover {
        background:url(../assets/images/hide-eye-button-hover.png);
    }

    .pamm-trader-list ul {
        padding:0;
    }

    .pamm-trader-list ul li {
        list-style-type:none;
        margin:5px 0;
    }

    .pamm-trader-list ul li label {
        font-weight:normal;
    }

    /*----- PAMM MY INVESTMENTS TAB -----*/
    .pamm-investment-container  {
        width:90%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-container h5 {
        font-size:15px;
        padding:5px 0;
        border-bottom:1px solid #2988CA;
    }

    .pamm-investment-content ul {
        padding:0;
    }

    .pamm-investment-content ul li {
        list-style-type:none;
    }

    .pamm-investment-content ul li i {
        font-style:normal;
        color:#2988CA;
    }

    .pamm-investment-parent {
        display:table;
        width:100%;
    }

    .pamm-investment-parent button , .pamm-investment-secondary button {
        display:block;
        clear:both;
    }

    .pamm-investment-secondary {
        width:100%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-table {
        width:100%;
    }

    .pamm-investment-table table thead {
        background:#eee;
    }

    .pamm-investment-table table thead th {
        text-align:center;
        color:#707071;
        font-weight:600;
        padding:7px 5px;
    }

    .pamm-investment-table table tr td {
        text-align:center;
        padding:5px;
        border-bottom:1px solid #ddd;
    }

    .pamm-trader-condition-child {
        margin:0 0 20px 0;
    }

    .pamm-trader-condition-child label {
        margin-bottom:0;
        display:block;
    }

    .pamm-trader-condition-child input[type=text] {
        width:80%!important;
        float:left;
        margin-right:5px;
    }

    .pamm-trader-condition-child span {
        display:inline-block;
        line-height:34px;
    }

    .max-investment-amount {
        line-height:32px!important;
        display:table;
        background: #eee;
        border: 1px solid #ddd;
        padding:0 10px;
    }

    /*----- PAMM MONITORING TAB -----*/

    .pamm-monitoring-landing h1 , .pamm-monitoring-live-feed h1 {
        padding:0;
        font-size:18px;
        margin:0!important;
        display:table;
        font-weight:600;
    }

    .pamm-monitoring-landing h1 {
        float:left;
        line-height:31px;
    }

    .pamm-monitoring-info {
        clear:both!important;
        padding:20px 0;
    }

    .pamm-monitoring-live-feed {
        display:none;
    }

    .pamm-monitoring-live-feed p {
        margin-top:20px;
    }

    .live-feed-child-content {
        display:table;
        width:100%;
        padding:10px;
        margin:10px auto;
    }

    .live-feed-child-content:nth-child(odd) {
        background:#fcfcfc;
        border:1px solid #dadada;
    }

    .live-feed-child-content:nth-child(even) {
        background:#f3f2f2;
        border:1px solid #dadada;
    }


    .live-feed-child-content h2 {
        font-size:14px;
        font-weight:600;
        margin:0 0 3px 0;
    }

    .live-feed-child-content img {
        float:left;
    }

    .live-feed-child-content span {
        color: #707071;
        float:left;
        margin-left:5px;
        margin-top:3px;
    }

    .live-feed-child-content ul {
        padding:0;
        margin-bottom:0;
        display:table;
        width:100%;
    }

    .live-feed-child-content ul li {
        list-style-type:none;
        float:left;
        border-right:1px solid #dadada;
    }

    .live-feed-child-content ul li a {
        padding:0 10px;
    }

    .live-feed-child-content ul li:first-child a {
        padding-left:0;
    }

    .live-feed-child-content ul li:last-child {
        border-right:0;
    }

    .monitoring-btn-default {
        padding:6px!important;
    }

    .secondary-monitoring-text-center {
        margin-top:3px;
    }

    .btn-demo1 {
        background: none;
        border: 1px solid #2988ca;
        color: #2988ca;
        padding: 7px;
        margin-top: 5px;
        transition: all ease 0.3s;
    }

    .btn-demo1:hover {
        background:#2988ca;
        color:#fff;
    }

    .trades-tab-holder {
        max-width:824px;
    }

    .conditions-input-holder {
        display:table;
        width:100%;
    }

    .conditions-slider {
        width:80%;
        float:left;
        margin:12px 0;
    }

    .conditions-slider span {
        outline:none!important;
    }

    .conditions-input {
        width:15%;
        border-radius:0;
        float:right;
    }

    .conditions-slider .ui-state-hover , .conditions-slider .ui-state-focus {
        background:#98d1f9!important;
        border:1px solid #52aae7!important;
    }

    .conditions-mid-content {
        text-align:center;
    }

    .conditions-mid-reward {
        margin-top: 13px;
        text-align:justify;
    }

    @media screen and (max-width: 1168px) {

        .monitoring-text-center {
            text-align:start!important;
        }

        .monitoring-btn-default {
            font-size:12px;
            padding:6px 4px!important;
        }

    }

    @media screen and (max-width: 1066px) {

        .monitoring-btn-default {
            margin-top:2px;
        }

    }

    @media screen and (max-width: 991px) {

        .pamm-side-nav li {
            width: calc(100% / 7)!important;
        }

    }

    @media screen and (max-width: 928px) {

        .pamm-side-nav li a {
            width:100%;
            display:table!important;
        }

        .pamm-side-nav li i , .pamm-side-nav li cite {
            float:left;
        }

        .pamm-side-nav li cite {
            font-size:11px!important;
        }

    }

    @media screen and (max-width: 767px) {

        .pamm-side-nav li {
            width:100%!important;
        }

        .pamm-side-nav li cite {
            font-size:14px!important;
            margin-left:5px;
        }

        .pamm-side-nav li i {
            margin-top:2px;
        }

        .pamm-investment-content {
            padding:0!important;
            float:none!important;
        }

        .pamm-investment-content ul {
            margin-bottom:0!important;
        }

        .pamm-investment-parent button {
            margin-top:10px!important;
        }

    }

    @media screen and (max-width: 670px) {

        .pamm-investment-table {
            max-width:500px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 570px) {

        .pamm-investment-table {
            max-width:400px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 558px) {

        .finance-payment-methods select {
            width:100%;
        }

        .finance-method-amount .input-group {
            width:100%;
        }

        .finance-method-amount label {
            line-height:16px;
        }

        .finance-method-table button {
            margin:0 auto;
            display:table;
            float:none;
        }

    }

    @media screen and (max-width: 550px) {

        .pamm-agreement-checkbox {
            width:80%;
        }

    }

    @media screen and (max-width: 475px) {

        .pamm-investment-table {
            max-width:300px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 465px) {

        .pamm-monitoring-landing h1 , .pamm-monitoring-landing button {
            float:none!important;
        }

        .pamm-monitoring-landing h1 {
            display:block;
            text-align:left;
        }

        .pamm-monitoring-landing button {
            display:block;
            margin:10px auto;
        }

        .pamm-monitoring-info {
            padding:10px 0;
        }

    }

    @media screen and (max-width: 430px) {

        .pamm-nav-tabs li {
            width:100%!important;
        }

        .pamm-nav-tabs li a {
            border:none!important;
            margin-right:0!important;
        }

        .pamm-content-input-box {
            padding:0!important;
        }

        .live-feed-child-content ul li {
            float:none;
            display:block;
            border-right:0;
        }

        .live-feed-child-content ul li a {
            padding:0;
        }

    }

    @media screen and (max-width: 370px) {

        .pamm-investment-table {
            max-width:200px;
            margin:0 auto!important;
        }

    }
    @media screen and (max-width: 315px) {

        .finance-deposit-container {
            margin:0 auto;
            position:relative;
            padding:10px 0!important;
        }

        .finance-deposit-container, .finance-payment-methods, .finance-method-content {
            display:block;
        }

        .finance-table-holder {
            border:1px solid #ddd;
            overflow-x:scroll;
        }

        .finance-table-holder table {
            margin-top:0;
            border:none;
        }

    }

    .slider {
        width: 100px;
    }

    .slider > .dragger {
        background: #2eb94b;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        -webkit-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        -moz-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);

        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;

        border: 1px solid #18872f;
        width: 16px;
        height: 16px;
    }

    .slider > .dragger:hover {
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
    }


    .slider > .track, .slider > .highlight-track {
        background: #ccc;
        background: -webkit-linear-gradient(top, #bbb, #ddd);
        background: -moz-linear-gradient(top, #bbb, #ddd);
        background: linear-gradient(top, #bbb, #ddd);

        -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);

        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;

        border: 1px solid #aaa;
        height: 4px;
    }

    .slider > .highlight-track {
        background-color: #8DCA09;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        border-color: #496805;
    }

    .slider-volume {
        width: 300px;
    }

    .slider-volume > .dragger {
        width: 16px;
        height: 16px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.6);

        -moz-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        -webkit-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);

        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;

        background: #c5c5c5;
        background: -moz-linear-gradient(90deg, rgba(180,180,180,1) 20%, rgba(230,230,230,1) 50%, rgba(180,180,180,1) 80%);
        background:	-webkit-radial-gradient(  50%   0%,  12% 50%, hsla(0,0%,100%,1) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(  50% 100%, 12% 50%, hsla(0,0%,100%,.6) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(	50% 50%, 200% 50%, hsla(0,0%,90%,1) 5%, hsla(0,0%,85%,1) 30%, hsla(0,0%,60%,1) 100%);
    }

    .slider-volume > .track, .slider-volume > .highlight-track {
        height: 11px;

        background: #787878;
        background: -moz-linear-gradient(top, #787878, #a2a2a2);
        background: -webkit-linear-gradient(top, #787878, #a2a2a2);
        background: linear-gradient(top, #787878, #a2a2a2);

        -moz-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        -webkit-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    .slider-volume > .highlight-track {
        background-color: #c5c5c5;
        background: -moz-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: -webkit-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: linear-gradient(top, #c5c5c5, #a2a2a2);
    }

</style>

<style type="text/css">
    /*custom*/
    .select2-container{  width:100%;height: auto;  }
    .select2-container .select2-choice{  border-radius: 0px!important;  height: 32px!important;  }
    .select2-container ,.select2-choice  ,.select2-arrow{  border-radius: 0px!important;  }
    .select2-drop-active{  border-width: medium 2px 2px!important;  }
    /*custom*/
</style>
<script type="text/javascript">
    var destination = '#pamm-div-trader';
    $('.destination-class').hide();
    $(destination).show();
</script>
<script type="application/javascript">
    var deactivated='<?=$deactivated?>';
    console.log('deactivated account is'+deactivated);
    if (deactivated==1){
        $('.deact').css('display','none');
    }

    var pblc = [];
    pblc['request'] = null;
    if(pblc['request'] != null) pblc['request'].abort();

    $('#trader_registration').validate({ // initialize the plugin
        rules: {
            traderprojectname:  "required",
//            traderdescEN: "required",
//            traderdescRU:  "required",
//            traderdescJP:  "required",
//            traderdescPL:  "required",
//            traderName:  "required",
//            traderSkype:  "required",
            traderIcq:  {
//                required:true,
                maxlength: 9,
                number: true
            },
//            traderYahoo:  "required",
//            traderStartTime:  "required",
        },
        messages: {
            traderprojectname:  "Please enter your Project name",
            traderdescEN:  "Please enter your English Description",
            traderdescRU:  "Please enter your Russian Description",
            traderdescJP:  "Please enter your Japanese Description",
            traderdescPL:  "Please enter your Polish Description",
            traderName:  "Please enter name",
            traderSkype:  "Please enter your skype account",
            traderIcq:  "Please enter your Icq account",
            traderYahoo:  "Please enter your Yahoo account",
            traderStartTime:  "Please select start time",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    $('[data-toggle="tooltip"]').tooltip()

    $('label').click(function() {
        labelID = $(this).attr('for');
        $('#'+labelID).trigger('click');
    });

    $(document).on("click", "#lbl_trader_hidetradesforall", function () {
        $('#trader_hidetradesforall').select2('focus');
        $('#trader_hidetradesforall').select2('open');
    });

    $(document).on("click", "#lbl_trader_langauge", function () {
        $('#trader_langauge').select2('focus');
        $('#trader_langauge').select2('open');
    });

    $(document).on("click", "#lbl1", function () {
        $('input[name=trader_emailalerts]').trigger('click');
    });

    $(document).on("click", "#lbl2", function () {
        $('input[name=trader_smsalerts]').trigger('click');
    });

    $(document).on("click", "#lbl3", function () {
        $('input[name=trader_approveinvestmentauto]').trigger('click');
    });

    $(document).on("click", "#lbl4", function () {
        $('input[name=trader_cir]').trigger('click');
    });

    $(document).on("click", "#lbl5", function () {
        $('input[name=trader_checkbox_deactivate]').trigger('click');
    });
    $( window ).load(function() {
        $('#pamm-div-trader').removeClass('page');
    });
</script>