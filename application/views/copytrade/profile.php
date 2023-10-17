<script src="<?= $this->template->Js()?>jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<meta charset="utf-8">
<style>


    .description-setting .input-group {
        display:flex;
    }
    .description-setting .input-group-addon {
        width:50%;
        display:inline-flex;
        align-items: center;
        min-width: 220px;
    }
    .commission_copier_payer .copying_terms {
        text-align:left;
    }
    .payer{
        width: 130px;
    }

    .commission_copier_payer .cp-terms {
        width: 130px;
    }

    .content-head-block-dark {
        background-color: #373739;
        color: #FFF;
        padding-left: 20px;
        padding-top: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .ac{
        border-left: 1px solid #ccc !important;
        width: 4%;
    }
    .pr{
        padding-right: 28px !important;
    }
    .pr1{
        text-align: center !important;
    }
    .des{
        padding-right: 23px !important;
    }
    .des_ru {
        padding-right: 15px !important;
    }
    .des_jp {
        padding-right: 11px !important;
    }
    .des_pl {
        padding-right: 28px !important;
    }
    .ac_cm {
        padding-right: 0px !important;
    }

    .trd_fr {
        padding-right: 50px !important;
    }

    .btn-floating img {
        height: 80px;
        width: auto;
        transition: 1s ease;
    }

    .btn-floating img:hover{
        -webkit-transform: scale(1.2);
        -ms-transform: scale(1.2);
        transform: scale(1.2);
        transition: 1s ease;
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
</style>
<div class="section">

    <div class="acct-tab-holder">
        <ul role="tablist" class="main-tab">
			<li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1"><?= lang('sb_li_12'); ?></a>
                </li>
  
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" ><?= lang('trd_74'); ?></a>
                </li>
                
                  
           
                <li>
                        <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                </li>

                
            <?php if(FXPP::getCopytradeType() == 1){ ?>
                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" ><?= lang('trd_75'); ?></a>
                </li>
            <?php } ?>
                <li class="active">
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" ><?= lang('trd_76'); ?></a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/recommended-accounts')?>" id = "tab5" ><?= lang('trd_77'); ?></a>
                </li>

            <div class="clearfix"></div>
    </div>

    <div class="content-delimetr"></div>


    <div class = "fc-profile-avatar" style="display: none">
        <div class="content-head-block-dark"><?= lang('trd_174'); ?>   </div>
        <div class="well well-login-form">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <form class="form-horizontal prof-form" id="frmUploadAvatar" enctype="multipart/form-data">
                            <div class="file-upload-wrapper">
                                <div class="dp-holder dp-holder2" style="text-align: center">
                                    <input type="hidden" value="<?= $details['UserId']; ?> " name="avt-acc">
                                    <input type="hidden" id="no-image" value="<?= $this->template->Images()?>copytrade_avatar.png" />
                                    <img src="<?php echo $image ? $imageUrl : $this->template->Images() . 'copytrade_avatar.png' ?>" id="avatar" class="dp" style="display: block;margin: 0 auto; margin-bottom: 10px;">
                                    <input type="file" name="filename[0]" id="chooseUploadLogo" class="form-control fileUpload fake-shadow" style="width: 250px;display: block;margin-left: auto; margin-right: auto;margin-bottom:5px;" onchange="readFile(this)">

                                    <div style="clear: both;"></div>
                                    <div class="input-group" style=" width: 75%; margin: 0 auto;">
                                        <input type ="hidden" id="image_type" value="0">
                                        <input type ="hidden" id="file_name_img" value="">
                                        <div class="input-group-btn">
                                            <div>

                                                <button type="button" id="select_avatar" name="logo" class="btn btn-default">   <span><i class="glyphicon glyphicon-plus"></i> Select </span> </button>
                                                <button type="button" id="logo-id" name="logo" class="btn btn-primary  attachment_upload attachUploadBtn">   <span><i class="glyphicon glyphicon-upload"></i> <?= lang('trd_175'); ?></span> </button>
                                                <button type="button" id="logo-id" name="logo" class="btn btn-danger  remove_attachment">   <span><i class="glyphicon glyphicon-trash"></i> <?= lang('trd_176'); ?></span> </button>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="show-msg" style="display:none;text-align: center; margin-top: 10px;"><div class="alert alert-info"><?= lang('trd_177'); ?></div></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2"></div>
        </div>
    </div>


    <form id="updateprofile_form" method="post">

    <div class ="profile-active">
        <div style="display: block" class="content-head-block-dark trader-settings">
            <?= lang('trd_179'); ?>
        </div>
        <div class="well well-login-form trader-settings" style="display: block">
            <div class="row  description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                            <span class="input-group-addon"><?= lang('trd_180'); ?> :  </span>

                            <input class="form-control pr1" type="text" name="account_number" value="<?=$details['UserId']; ?> "  readonly>

                            <!--<span class="input-group-addon ac"> <?//= $details['UserId']; ?> </span>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon pr">
                            <span class="star">*</span>&nbsp;<?= lang('trd_181');?> : &nbsp;<i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_2'); ?>"></i>
                        </span>
                            <input class="form-control pr1" type="text" name="project_name" value="<?=$details['ProjectName']; ?> "  maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon des">
                            <?= lang('trd_182'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_3'); ?>"></i>
                        </span>
                            <textarea name="desc_en" maxlength="300"   id="project_desc" class="form-control"> <?= $details['desc_4']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon des_ru">
                            <?= lang('trd_183'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_3'); ?>"></i>
                        </span>
                            <textarea name="desc_ru"   maxlength="300"  id="project_desc" class="form-control"><?= $details['desc_1']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon des_jp">
                            <?= lang('trd_184'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_3'); ?>"></i>
                        </span>
                            <textarea name="desc_jp"  maxlength="300"  id="project_desc" class="form-control"><?= $details['desc_2']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon des_pl">
                            <?= lang('trd_185'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_3'); ?>"></i>
                        </span>
                            <textarea name="desc_pl" maxlength="300"  id="project_desc" class="form-control"><?= $details['desc_3']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <!-- 
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon ac_cm">
                            <? lang('trd_186'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<? lang('note_ques_4'); ?>"></i>
                        </span>
                            <input class="form-control" type="text" name="commission_acc" value="<? $details['conditions_values_5'] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row description-setting">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon trd_fr">
                           <? lang('trd_187'); ?> : &nbsp; <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<? lang('note_ques_5'); ?>"></i>
                        </span>
                            <input class="form-control" type="text" name="topic_theme" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            
            -->
        </div>

        <div style="display: block" class=" trader-settings content-delimetr"></div>

        <div class="content-head-block-dark trader-settings" style="display: block">
            <span class="star">*</span>&nbsp;<?= lang('trd_140'); ?>  : </div>
        <div class="well well-login-form trader-settings" style="display: block">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="row commission_copier_payer" >
                        <div class="col-md-12">
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                                <!--<span class="input-group-addon copying_terms cpt"><?//= lang('trd_188'); ?> <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?//= lang('note_ques_6'); ?>"></i>
                                </span>-->

                                    <span class="input-group-addon copying_terms"><?= lang('trd_188'); ?> :  <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="Copytrading follower  pays commission for copying your trades. You can make your service free of charge for the Copytrading followers and receive 0.5 pip commission for 1 lot closed by your followers from the company."></i></span>

                                    <input type="text" name="commission_payer" class="cp-terms  form-control" value = "<?= lang('follower')?>" readonly>
                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row commission_copier_payer" style="">
                        <div class="col-md-12">
                            <!-- >
                                @todo temporary hack
                            < -->
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                        <span class="input-group-addon copying_terms">
                            <span class="hidden-xs"><?= lang('trd_112'); ?> :  </span>
                            <span class="hidden-lg hidden-md hidden-sm"><?= lang('trd_112'); ?>  :  </span>
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_7'); ?>"></i> <?=$details['Currency']?></span>
                                    <input  type="number" min="1" max="999999"  onKeyDown="if(this.value.length==6) return false;" step="any" name="conditions_values_1" class="cp-terms form-control numeric" onfocus="value='';" placeholder="<?=  lang('not_use')?>" value="<?=  $details['conditions_values_1'] ? $details['conditions_values_1'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row commission_copier_payer" style="">
                        <div class="col-md-12">
                            <!-- >
                                @todo temporary hack
                            < -->
                            <div class="text-center hidden-lg hidden-md hidden-sm"><strong>Commission per 0.01 lots </strong></div>
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                        <span class="input-group-addon copying_terms">
                            <span class="hidden-xs">
                                Commission per 0.01 lots (profitable trades) :                             </span>
                            <span class="hidden-lg hidden-md hidden-sm">
                                Profitable trades :                </span>
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_8'); ?>"></i>
                            <?=$details['Currency']?>
                                                    </span>
                                    <input type="number" min="1" max="999999" onKeyDown="if(this.value.length==6) return false;" step="any" name="conditions_values_2" class="cp-terms form-control numeric"  onfocus="value='';" placeholder="<?=  lang('not_use')?>" value="<?=  $details['conditions_values_2'] ? $details['conditions_values_2'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row commission_copier_payer" style="">
                        <div class="col-md-12">
                            <!-- >
                                @todo temporary hack
                            < -->
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                        <span class="input-group-addon copying_terms">
                            <span class="hidden-xs">
                                Commission per 0.01 lots (all trades):                            </span>
                            <span class="hidden-lg hidden-md hidden-sm">
                                All trades :  </span>
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_9'); ?>"></i>
                            <?=$details['Currency']?>
                                                    </span>
                                    <input type="number" min="1" max="999999" onKeyDown="if(this.value.length==6) return false;" step="any" name="conditions_values_10" class="cp-terms  form-control numeric"  onfocus="value='';" placeholder="<?=  lang('not_use')?>" value="<?=  $details['conditions_values_10'] ? $details['conditions_values_10'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row commission_copier_payer" style="">
                        <div class="col-md-12">
                            <!-- >
                                @todo temporary hack
                            < -->
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                        <span class="input-group-addon copying_terms">
                            <span class="hidden-xs">
                                Profit share (in %) :                            </span>
                            <span class="hidden-lg hidden-md hidden-sm">
                                Profit share (in %) :                            </span>
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_10'); ?>"></i>
                            %
                                                    </span>
                                    <select id = "conditions_values_3" name="conditions_values_3" class="cp-terms  form-control" data-live-search="true" data-width="100%">
                                        <option value="<?= lang('not_use')?>" selected=""><?= lang('not_use')?></option>
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
                            <!-- >
                                @todo temporary hack
                            < -->
                            <div class="form-group one-elem one-elem-top">
                                <div class="input-group">
                        <span class="input-group-addon copying_terms">
                            <span class="hidden-xs">
                                <?= lang('trd_117'); ?>  :                           </span>
                            <span class="hidden-lg hidden-md hidden-sm">
                                <?= lang('trd_117'); ?>                            </span>
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?= lang('note_ques_11'); ?>"></i>
                            <?=$details['Currency']?>
                                                    </span>
                                    <input type="number" min="1" max="999999" onKeyDown="if(this.value.length==6) return false;" step="any" name="conditions_values_4" class="cp-terms  form-control numeric"  onfocus="value='';" placeholder="<?=  lang('not_use')?>" value="<?=  $details['conditions_values_4'] ? $details['conditions_values_4'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
        </div>

        <div style="display: block">
            <div class="content-delimetr"></div>
            <div class="trader-settings content-head-block-dark">
                <?= lang('trd_189'); ?>                    </div>
            <div class="trader-settings well well-login-form">
                <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf"><?= lang('trd_190'); ?> : </span>
                                <input class="form-control" type="text" value="<?=$details['AccountName']; ?>" disabled="true">
                                <select name="show_acc_name" class="form-control">
                                    <option value="0" selected=""><?= lang('hidden')?></option>
                                    <option value="2"><?= lang('available_to_f')?></option>
                                    <option value="1"><?= lang('available_to_all')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>
<!--                <div class="row">-->
<!--                    <div class="col-md-2 col-lg-2 col-sm-2"></div>-->
<!--                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">-->
<!--                        <div class="form-group one-elem one-elem-top">-->
<!--                            <div class="input-group">-->
<!--                                <span class="input-group-addon conf">Icq: </span>-->
<!--                                <input class="form-control" type="text" name="icq" value=" <?  $details['Icq']; ?> ">-->
<!--                                <select name="show_icq" class="form-control">-->
<!--                                    <option value="0" selected="">Hidden</option>-->
<!--                                    <option value="2">Available to followers</option>-->
<!--                                    <option value="1">Available to all</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-2 col-lg-2 col-sm-2"></div>-->
<!--                </div>-->

                <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf">Icq : </span>
                                <input class="form-control" maxlength ="30" type="text" name="icq" value="<?=$details['Icq']; ?>">
                                <select name="show_icq"  class="form-control">
                                    <option value="0" selected=""><?= lang('hidden')?></option>
                                    <option value="2"><?= lang('available_to_f')?></option>
                                    <option value="1"><?= lang('available_to_all')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>

               <!-- <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf"><?//= lang('trd_192'); ?> </span>
                                <input class="form-control" maxlength ="30" type="text" name="icq" value="<?//=$details['telegram']; ?>">
                                <select name="show_icq" class="form-control">
                                    <option value="0" selected="">Hidden</option>
                                    <option value="2">Available to followers</option>
                                    <option value="1">Available to all</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>-->

                <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf"><?= lang('trd_193'); ?> </span>
                                <input class="form-control" maxlength ="30" type="text" name="skype" value="<?=$details['Skype']; ?>">
                                <select name="show_skype" class="form-control">
                                    <option value="0" selected=""><?= lang('hidden')?></option>
                                    <option value="2"><?= lang('available_to_f')?></option>
                                    <option value="1"><?= lang('available_to_all')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>
               
               
<!--        test email and pone      -->
               
                    
               
                 <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf"><?= lang('mf_02'); ?>  : </span>
                                <input class="form-control" maxlength ="50" type="text" name="email" value="<?=$details['Email']; ?>">
                                <select name="show_email" class="form-control">
                                    <option value="0" selected=""><?= lang('hidden')?></option>
                                    <option value="2"><?= lang('available_to_f')?></option>
                                    <option value="1"><?= lang('available_to_all')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>
               
               
                 <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <span class="input-group-addon conf"><?= lang('trd_259'); ?>  : </span>
                                <input class="form-control" maxlength ="16" type="text" name="phone" value="<?=$details['Phone']; ?>">
                                <select name="show_phone" class="form-control">
                                    <option value="0" selected=""><?= lang('hidden')?></option>
                                    <option value="2"><?= lang('available_to_f')?></option>
                                    <option value="1"><?= lang('available_to_all')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>
               
                
               
               
            </div>
        </div>

        <div class="content-delimetr "></div>
<!--        <div class="content-head-block-dark"><? lang('trd_194'); ?>  </div> 
        <div class="well well-login-form">
            <div class=" trader-settings row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                        <span class="input-group-addon">
                            <? lang('trd_195'); ?><i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<? lang('note_ques_12'); ?>"></i>
                        </span>
                            <input class="form-control datetimepicker1 monitor_start" name="mon_start" type="text" value="<?//=$details['MonitoringStart']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class=" trader-settings row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <div class="input-group">
                            <span class="input-group-addon set_notf"><? lang('trd_196'); ?> </span>
                            <select name="show_deals" class="form-control">
                                <option value="0" selected="">Hide to all</option>
                                <option value="1">Hide to all except my followers</option>
                                <option value="2">Show to all</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
           <!-- <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                        <?//= lang('trd_197'); ?>                                    <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?//= lang('note_ques_13'); ?>"></i>
                        <input type="checkbox" name="alerts_email" checked="" value ="1">
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                       <?//= lang('trd_198'); ?>                                     <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?//= lang('note_ques_14'); ?>"></i>
                        <input type="checkbox" name="alerts_sms" value ="0">
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                    <div class="form-group one-elem one-elem-top">
                       <?//= lang('trd_199'); ?>                                      <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-question-circle" data-original-title="<?//= lang('note_ques_15'); ?>"></i>
                        <input type="checkbox" name="alert_unsubscribe" value ="0">
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2"></div>
            </div> 
        </div> -->
        <div class="follower-settings" style="display: block">
            <div class="content-delimetr"></div>
            <div class="content-head-block-dark">
                <?= lang('trd_200'); ?>                    </div>
            <div class="well well-login-form">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <?= lang('trd_201'); ?>
                        <input type="checkbox" name="is_trader">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <?= lang('trd_202'); ?>                            </div>
                </div>
            </div>
        </div>

     
        <?php if($profitShare){ ?>
        <div class="rollover-setting">
            <div class="content-head-block-dark">Rollover Status</div>
            <div class="well well-login-form">
              <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <p>*Note: The method can be changed once every 30 days only.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                        <div class="form-group one-elem one-elem-top">
                            <div class="input-group">
                                <label class="radio-inline"><input type="radio" value="0" name="rollover_status" checked <?= ($change_rollover) ? '':'disabled' ?>> Manual</label>
                                <label class="radio-inline"><input type="radio" value="1"  name="rollover_status" <?= ($change_rollover) ? '':'disabled' ?>>Automatic</label>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2"></div>
                </div>
            </div>
        </div>

        <?php } ?>
      
       

<!--        <div  style="display: block">
            <div class="content-delimetr"></div>
            <div class="content-head-block-dark">                <? lang('trd_203'); ?>                        </div>
            <div class="well well-login-form">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <? lang('trd_204'); ?> 
                        <input type="checkbox" name="conditions_values_6" value ="<? $details['conditions_values_6'] ?>">
                    </div>
                </div>
            </div>
        </div>-->
        
       <!-- <div class="content-delimetr"></div>
        <div class="content-head-block-dark">
           <?//= lang('trd_205'); ?>                     </div>
        <div class="well well-login-form">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                     <?//= lang('trd_206'); ?>
                    <input type="checkbox" name="user_spec_param_1" value ="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <?//= lang('trd_207'); ?>
				</div>
            </div>
        </div>-->

        <div class="content-delimetr"></div>
        <div class="content-head-block-dark account-deactivate">
            <?= lang('trd_208'); ?>
		</div>
        <div class="well well-login-form account-deactivate">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <?= lang('trd_209'); ?>
                    <input type="checkbox" name="close_project" value ="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <?= lang('trd_210'); ?>
				</div>
            </div>
        </div>

    </div>

    <div class ="profile-inactive">
        <div class="content-head-block-dark account-activate">
            <?= lang('trd_211'); ?>
        </div>
        <div class="well well-login-form account-activate">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <?= lang('trd_212'); ?>
                    <input type="checkbox" name="open_project" value ="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <?= lang('trd_213'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Отписка от проекта -->
    <!-- /Настройки трейдера -->

    <!-- /Настройки -->
    <div class="content-delimetr"></div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
            <input type="button" value="<?= lang('perdet_11'); ?>" class="btn update-profile btn-main btn-cp">
        </div>
    </div>
    </form>
    </div>



<div id = "profileAvatar2" class="modal fade" id="modalSocial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal" role="document">
        <!--Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="classModalLabel">
                    Select  Avatar
                </h4>
            </div>

            <div class="modal-body mb-0 text-center">

                <a href="#" class="btn-floating" data-id="avatar-01"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-01.png' ?>"></a>
                <a href="#" class="btn-floating" data-id="avatar-02"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-02.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-03"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-03.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-04"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-04.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-05"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-05.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-06"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-06.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-07"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-07.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-08"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-08.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-09"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-09.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-10"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-10.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-11"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-11.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-12"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-12.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-13"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-13.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-14"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-14.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-15"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-15.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-16"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-16.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-17"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-17.png' ?>"/></a>
                <a href="#" class="btn-floating" data-id="avatar-18"><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-18.png' ?>"/></a>


            </div>

        </div>


    </div>
</div>


<div id="profileAvatar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="classInfo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="classModalLabel">
                   Select  Avatar
                </h4>
            </div>
            <div class="modal-body">
                <table id="classTable" class="table table-bordered">
                    <thead>
                    </thead>
                    <tbody id="profile_tbody">
                    <tr>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-01.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-02.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-03.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-04.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-05.png' ?>"/></td>
                    </tr>

                    <tr>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-06.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-07.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-08.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-09.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-10.png' ?>"/></td>
                    </tr>
                    <tr>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-11.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-12.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-13.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-14.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-15.png' ?>"/></td>
                    </tr>
                    <tr>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-16.png' ?>"/></td>
                        <td><img src="<?php echo $this->template->Images() . 'trader_avatar/avatar-17.png' ?>"/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Select
                </button>
            </div>
        </div>
    </div>
</div>


        <div id="cpy_modal"  tabindex="-1" class="modal-custom modal-center modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
">
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
                        <button type="button" class="btn btn-success btn-form" data-dismiss="modal">OK</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title conf-modal-title text-center"></h4>
                    <img src="<?= $this->template->Images()?>img-info-modal.png" class="img-center img-info-modal">
                </div>
                <div class="modal-body">
                    <p id="m_message" class="text-center conf-modal-desc"></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default"  data-dismiss="modal" value="Cancel">
                    <input type="button" class="btn btn-danger" id ='confirm' value="Confirm">
                </div>
            </div>
        </div>
    </div>








<script>
    var isAvatarLoaded = false;
    var is_trader = '<?= $IsTrader?>';
    console.log(is_trader);
    if(is_trader == 1) {
        $('.follower-settings').hide();
        $('.trader-settings').show();
        $('.profile-inactive').hide();
        $('.fc-profile-avatar').show();
       // $('input[name="project_name"]').prop('disabled', true);
    }else if(is_trader == 2) {
        $('.profile-active').hide();
        $('.profile-inactive').show();
    } else{
        $('.trader-settings').hide();
        $('.follower-settings').show();
        $('.profile-inactive').hide();
        $('input[name="project_name"]').prop('disabled', false);
    }







    var url = '<?php echo base_url();?>';
  //  var alert_unsubscribe  = '<?//=  $details['AlertUnsubscribe'] ?>';
    var auto_subs  = '<?=  $details['conditions_values_6'] ?>';
    console.log('<?=  $details['ShowIcq'] ?>');
    $('select[name="conditions_values_3"]').val( <?=  $details['conditions_values_3'] ?>);
    $('select[name="show_icq"]').val( <?=  $details['ShowIcq'] ?>);
    $('select[name="show_skype"]').val( <?=  $details['ShowSkype'] ?>);
    $('select[name="show_acc_name"]').val( <?=  $details['ShowAccountName'] ?>);
    $('select[name="show_deals"]').val( <?=  $details['ShowDeals'] ?>);
    $('select[name="lang_notify"]').val( <?=  $details['LangNotify'] ?>);
    $('select[name="show_email"]').val( <?=  $details['ShowEmail'] ?>);
    $('select[name="show_phone"]').val( <?=  $details['ShowPhone'] ?>);



    $("input[name=rollover_status][value='<?= $rollover_status ?>']").prop("checked",true);







//    if (alert_unsubscribe) {
//        $('input[name="alert_unsubscribe"]').prop('checked', true);
//        $('input[name="alert_unsubscribe"]').val(1);
//    } else {
//        $('input[name="alert_unsubscribe"]').prop('checked', false);
//        $('input[name="alert_unsubscribe"]').val(0);
//    }
    if (auto_subs == 1) {
        $('input[name="conditions_values_6"]').prop('checked', true);
        $('input[name="conditions_values_6"]').val(1);
    } else {
        $('input[name="conditions_values_6"]').prop('checked', false);
        $('input[name="conditions_values_6"]').val(0);
    }


    $('input[name="is_trader"]').on('change', function() {
          $(".trader-settings").toggle();
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });




    $(document).ready(function() {

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




        $('#startDate').datepicker({
            showButtonPanel: true,
            closeText: 'Close',
            dateFormat: 'yy-mm-dd'
//            beforeShowDay: function(date) {
//                /* Check for the first day */
//                if (date.getDate() == 1) { return [true, '']; }
//                else { return [false, '', 'Unavailable']; }
//            }

        });

//        $('.monitor_start').datetimepicker({
//            format: 'YYYY/DD/MM',
//            maxDate: new Date,
//            minDate: new Date(2015, 1, 1),
//        });








//
//        $('input[name="alerts_email"]').on('change', function() {
//            if ($(this).is(':checked')) {
//                $(this).val(1);
//            } else {
//                $(this).val(0);
//            }
//        });
//        $('input[name="alerts_sms"]').on('change', function() {
//            if ($(this).is(':checked')) {
//                $(this).val(1);
//            } else {
//                $(this).val(0);
//            }
//        });
//        $('input[name="alert_unsubscribe"]').on('change', function() {
//            if ($(this).is(':checked')) {
//                $(this).val(1);
//            } else {
//                $(this).val(0);
//            }
//        });
        $('input[name="conditions_values_6"]').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
        $('input[name="close_project"]').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
//        $('input[name="user_spec_param_1"]').on('change', function() {
//            if ($(this).is(':checked')) {
//                $(this).val(1);
//            } else {
//                $(this).val(0);
//            }
//        });
        $('input[name="open_project"]').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });



    });

//    $('#chooseUploadLogo').change(function() {
//         var file_data = $("#chooseUploadLogo").prop("files")[0];
//        if(!file_data){
//
//        }else{
//            $('#image_type').val(0);
//        }
//    });

    $(document).on('click',".attachment_upload",function(){
        $('div#show-msg').show();
        $('div#show-msg').html('<div class="alert alert-info"><?= lang("trd_177"); ?></div>');
        var file_data = $("#chooseUploadLogo").prop("files")[0];
        var imgType =  $('#image_type').val();
        var imgFilename =  $('#file_name_img').val();
        if(imgType == 1){

            jQuery.ajax({
                type: 'POST',
                url: url + 'copytrade/uploadAvatarSelected',
                data: {imgFilename:imgFilename},
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    $('#image_type').val(0);
                    $('div#show-msg').html('<div class="alert alert-info">'+ x.error + '</div>');
                    $('div#show-msg').delay(5000).fadeOut(300);
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.col-alert').html('');
                    console.log(xhr.status);
                    console.log(thrownError);
                    $('#loader-holder').hide();
                }
            });
        }else{

            if(!file_data){
                jQuery('#avatar').attr('src', jQuery('#no-image').val());
                $('div#show-msg').html('<div class="alert alert-info"><?= lang("trd_214"); ?></div>');
                $('div#show-msg').delay(5000).fadeOut(300);
                return false;
            }
            if(!isAvatarLoaded){
                $('div#show-msg').html('<div class="alert alert-info">Please load correct avatar format and size.</div>');
                $('div#show-msg').delay(5000).fadeOut(300);
                return false;
            }



            var file_data_up = $("#chooseUploadLogo").prop("files")[0];
            var fileType = file_data_up["type"];
            var validImageTypesAv = ["image/jpg", "image/jpeg", "image/png"];

            if ($.inArray(fileType, validImageTypesAv) < 0) {

                $('div#show-msg').html('<div class="alert alert-info">You have loaded an invalid format. Valid format *png and jpg*</div>');
                $('div#show-msg').delay(5000).fadeOut(300);
                return false;
            }else{

            }




            var myFormData = new FormData();
            myFormData.append('avatar', file_data);
            jQuery.ajax({
                type: 'POST',
                url: url + 'copytrade/uploadAvatar',
                data: myFormData,
                dataType: 'json',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x){
                    console.log(x);
                    if(x.success){
                        jQuery('#avatar').attr('src', x.src);
                        $('div#show-msg').html('<div class="alert alert-info">'+ x.error + '</div>');
                        $('div#show-msg').delay(5000).fadeOut(300);
                    }else{
                         $('div#show-msg').show();
                          $('div#show-msg').html('<div class="alert alert-info">Something went wrong. Please contact technical support.</div>');

                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    jQuery('.col-alert').html('');
                    console.log(xhr.status);
                    console.log(thrownError);
                    $('#loader-holder').hide();
                    
                     $('div#show-msg').show();
                    $('div#show-msg').html('<div class="alert alert-info">Something went wrong. Please contact technical support.</div>');

                    
                }
            });

        }


    });

    $(document).on('click',".remove_attachment",function(){
        jQuery.ajax({
            type: 'POST',
            url: url + 'copytrade/removeAvatar',
            dataType: 'json',
            beforeSend: function(){
                $('#loader-holder').show();
            },
            success: function(x){
                $('#image_type').val(0);
               // if(x.success){
                    jQuery('#avatar').attr('src', jQuery('#no-image').val());
                //}
                $('#loader-holder').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                jQuery('.col-alert').html('');
                console.log(xhr.status);
                console.log(thrownError);
                $('#loader-holder').hide();
            }
        });
    });

    $(document).on('click',"#select_avatar",function(){
       $('#profileAvatar2').modal('show');
    });
    $(document).on('click',".btn-floating",function(){
      var imageID = $(this).data('id');
        console.log(imageID);
        var urlImage = '<?= $this->template->Images() ?>' + 'trader_avatar/' + imageID + '.png';
        console.log(urlImage);
        $('#image_type').val(1);
        $('#file_name_img').val(imageID + '.png');
        $('#avatar').attr('src', urlImage);
        $('#profileAvatar2').modal('hide');
    });


    $(document).on("click",".update-profile",function(e){
        var is_error = true;
        var  message = "<?=lang('trd_215'); ?>";
        var is_upgrade = $('input[name="is_trader"]').val();


var commision_type=$("input[name=commission_payer]").val();

      

      //  if( $("select[name=commission_payer]").val() != 1)
        if(!commision_type)
        {
            if((is_trader == 0 && is_upgrade == 1)  || is_trader == 1){
                console.log('test');

                if (($('input[name="conditions_values_1"]').val() == lang('not_use') || !$.trim($('input[name="conditions_values_1"]').val()).length) &&
                    ($('input[name="conditions_values_2"]').val() == lang('not_use') || !$.trim($('input[name="conditions_values_2"]').val()).length) &&
                    ($('select[name="conditions_values_3"]').val() == lang('not_use') || !$.trim($('select[name="conditions_values_3"]').val()).length) &&
                    ($('input[name="conditions_values_4"]').val() == lang('not_use') || !$.trim($('input[name="conditions_values_4"]').val()).length) &&
                    ($('input[name="conditions_values_10"]').val() == lang('not_use') || !$.trim($('input[name="conditions_values_10"]').val()).length))
                {
                    is_error = false;
                }else{
                    var count = 0;
                    if($('input[name="conditions_values_1"]').val() == lang('not_use')){

                    }else{
                        if ($.trim($('input[name="conditions_values_1"]').val()).length){
                            count  = count +  1;
                        }
                    }
                    if($('input[name="conditions_values_2"]').val() == lang('not_use')){

                    }else{
                        if ($.trim($('input[name="conditions_values_2"]').val()).length){
                            count  = count +  1;
                        }
                    }
                    if ($('select[name="conditions_values_3"]').val() != lang('not_use')){
                        count  = count +  1;
                    }

                    if($('input[name="conditions_values_4"]').val() == lang('not_use')){

                    }else{
                        if ($.trim($('input[name="conditions_values_4"]').val()).length){
                            count  = count +  1;
                        }
                    }

                    if($('input[name="conditions_values_10"]').val() == lang('not_use')){

                    }else{
                        if ($.trim($('input[name="conditions_values_10"]').val()).length){
                            count  = count +  1;
                        }
                    }

                    console.log(count);

                    if(count > 1){
                        is_error = false;
                    }

                }

            }
        }
        if((is_trader == 0 && is_upgrade == 1)  || is_trader == 1){
            if(!$.trim($('input[name="project_name"]').val()).length){
                message = "Project name is required.";
                is_error = false;
            }


        }



        if(is_error){
            $('.conf-modal-title').html('<?= lang("trd_216"); ?>');
            $('.conf-modal-desc').html('<?= lang("trd_163"); ?>');
            $('#confirmModal')
                .modal({ backdrop: 'static', keyboard: false })
                .on('click', '#confirm', function (event) {
                    $.ajax({
                        type:'POST',
                        url:url + 'copytrade/update_profile',
                        data: $('#updateprofile_form').serialize(),
                        beforeSend:function(){
                            $('#loader-holder').show();
                            $('.subscribed').show();
                        }
                    }).done(function(response){
                        console.log(response);

                        $('#confirmModal').modal('hide');
                        $('#loader-holder').hide();
                        if(response.success) {
                            if($('input[name="open_project"]').val() == 1){
                                $('input[name="open_project"]').val(0);
                            }
                            if($('input[name="close_project"]').val() == 1){
                                $('input[name="close_project"]').val(0);
                            }
                            if(response.type == 1) {
                                $('.profile-active').show();
                                $('.profile-inactive').hide();
                                $('.follower-settings').hide();
                            }else if(response.type == 2) {
                                $('.profile-active').hide();
                                $('.profile-inactive').show();
                            } else{
                                $('.profile-active').show();
                                $('.profile-inactive').hide();
                                $('.trader-settings').hide();
                                $('.follower-settings').show();
                            }

                            $('#m_message').html(response.errorMsg);
                        }else{
                            $('#m_message').html(response.errorMsg);
                        }
                        $('#cpy_modal').modal('show');



                    });

                    event.stopImmediatePropagation();

                });


        }else {
            $('#m_message').html(message);
            $('#cpy_modal').modal('show');
        }

        e.stopImmediatePropagation();

        });




    function readFile(input) {
        if (input.files && input.files[0]) {
            var file_data = input.files[0];
            var fileSize = file_data["size"] / (1024 * 1024); //convert to MB
            var fileType = file_data["type"];
            var validImageTypes = ["image/jpg", "image/jpeg", "image/png"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                // invalid file type code goes here.
                $('div#show-msg').show();
                $('div#show-msg').html('<div class="alert alert-info">You have loaded an invalid format. Valid format *png and jpg*</div>');


            }else if(fileSize > 2) { // 5 MB



                $('div#show-msg').show();
                $('div#show-msg').html('<div class="alert alert-info">Please upload image size less than 2 MB</div>');


            }else{ // valid


                isAvatarLoaded = true;

                var reader = new FileReader(); //load image

                reader.onload = function (e) {
                    $('#avatar').attr('src', e.target.result);
                    $('#image_type').val(0);
                }

                reader.readAsDataURL(input.files[0]);



                $('div#show-msg').hide();
                $('div#show-msg').html('');


            }

        }
    }






</script>
