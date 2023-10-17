<?php //include_once('invite_friend/nav.php')
$this->view('invite_friend/nav');
?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="min-height: 320px;">
        <div class="row">
            <div class="col-md-12 col-centered">

                <?php  if($this->session->flashdata('msg')){ ?>
                <div class="col-md-12 col-centered">
                   <div class="alert-success alert"><?php echo $this->session->flashdata('msg');?></div>
                </div>
                <?php } ?>
                <?php echo form_open('', array('role' => 'form', 'class' => 'form-horizontal prof-form', 'id' => 'frmChangePassword')) ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> contest-label arabic-invite-friend-form">
                        <?=lang('ibe_00');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> arabic-input-placeholder arabic-invite-friend-form">
                        <input type="text" name="name" class="form-control round-0" id="name" placeholder="Enter Name" value="<?php echo set_value('name'); ?>">
                    </div>
                    <div class="reqs col-sm-5 col-sm-offset-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?>  arabic-invite-friend-form arabic-error-input">
                        <?php echo form_error('name', '<span class="error">', '</span>') ?>
                    </div>
                </div>
                <div class="form-group" id="#pwd-container">
                    <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> contest-label arabic-invite-friend-form">
                        <?=lang('ibe_01');?>
                        <cite class="req">*</cite></label>
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> arabic-invite-friend-form">
                        <input type="email" name="email" class="form-control round-0" id="email" placeholder="Enter Email" value="<?php echo set_value('email'); ?>">
                    </div>
                    <div class="reqs  col-sm-5 col-sm-offset-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?>  arabic-invite-friend-form arabic-error-input">
                        <?php echo form_error('email', '<span class="error">', '</span>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-4 col-md-4 col-xs-12' : '' ?> contest-label arabic-invite-friend-form">
                        <?=lang('ibe_02');?>
                        <cite class="req">*</cite>
                    </label>
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> arabic-invite-friend-form">
                        <select name="language" class="form-control arabic-select-box">
                            <?=$language?>
                        </select>
                    </div>
                    <div class="reqs  col-sm-5 col-sm-offset-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-12' : '' ?>  arabic-invite-friend-form arabic-error-input">
                        <?php echo form_error('language', '<span class="col-sm-4 error">', '</span>') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label contest-label arabic-invite-friend-form"></label>
                    <div class="col-sm-5 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> control-label contest-label arabic-invite-friend-form">
                        <button type="submit" class="btn-send-invitation arabic-btn-send-invitation">
                            <?=lang('ibe_03');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
