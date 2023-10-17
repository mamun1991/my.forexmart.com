<style>
    .l_{
    float: left;
    width: 20px;
    margin: 1px 10px 0 7px;
    }
    .r_{
    width: 80%;
    float: left;
    }
    .cb{
        clear: both;
    }
    .r{
        text-align: right;
    }
    @-moz-document url-prefix() {
        @media screen and (max-width: 695px){
            .prof-form:lang(en){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(ru){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(jp){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(id){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(de){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(fr){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(it){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(sa){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(es){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(pt){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(bg){
                width: 50%;
                margin: 0px auto;
            }
            .prof-form:lang(my){
                width: 50%;
                margin: 0px auto;
            }
        }
    }
    @media screen and  (max-width: 635px) and (-webkit-min-device-pixel-ratio:0){
        .prof-form:lang(en){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(ru){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(jp){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(id){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(de){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(fr){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(it){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(sa){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(es){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(pt){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(bg){
            width: 75%;
            margin: 0px auto;
        }
        .prof-form:lang(my){
            width: 75%;
            margin: 0px auto;
        }
    }
    @media screen and  (min-width: 636px) and (max-width: 767px) and (-webkit-min-device-pixel-ratio:0) {
        .prof-form:lang(en){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(ru){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(jp){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(id){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(de){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(fr){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(it){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(sa){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(es){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(pt){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(bg){
            width: 50%;
            margin: 0px auto;
        }
        .prof-form:lang(my){
            width: 50%;
            margin: 0px auto;
        }
    }
</style>



<h1>
    My Account
</h1>

<?php $this->load->view('account_nav.php');?>

<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="min-height: 600px;">
        <div class="row">
            <div class="col-md-12 col-centered <?= FXPP::html_url() == 'sa' ? 'col-lg-12 col-md-12 col-xs-12' : '' ?>">
            <form method="post" action="" class="form-horizontal prof-form">
                <div class="form-group">
                    <label class="col-sm-3 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-3' : '' ?>">
                    </label>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?>">
                        
                        <span id="activated" class="error arabic-error"><?=isset($mobile)?"SMS Security is already activated with  *****".substr($mobile['sms'], -3, 3).".": lang('mfn_07'); ?></span>
                    
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-3 col-md-3 col-xs-3' : '' ?>">

                    </label>
                    <div class="col-sm-6 <?= FXPP::html_url() == 'sa' ? 'col-lg-6 col-md-6 col-xs-12' : '' ?> arabic-input-form">
                        <input <?php  set_value('sms')==1?"checked":""; ?>  id="sms_active" type="radio" value="1" name="sms" class="l_">   <span class="r_"><?=lang('mfn_05');?></span>
                        <br class="cb">
                        <input <?php  set_value('sms')==0?"checked":""; ?> id="sms_deactive" type="radio" value="0" name="sms" class="l_">  <span class="r_"><?=lang('mfn_06');?></span>
                    </div>
                </div>
            <div id="mobile" style="display: none">
                <div class="form-group">
                    <label class="col-sm-5 control-label <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-5 col-xs-12' : '' ?> r">
                        <?=lang('sms_mbl');?>
                    </label>
                    <div class="col-sm-4 <?= FXPP::html_url() == 'sa' ? 'col-lg-5 col-md-4 col-xs-12' : '' ?>">
                        <input type="text" value="<?php echo set_value('mobile'); ?>" name="mobile" class="form-control round-0" placeholder="<?=lang('sms_mbl2');?>">
                    </div>
                    <?php echo form_error('mobile', '<span class="col-sm-4 error">', '</span>') ?>

                </div>
            </div>

                <div class="form-group">
                    <div class="col-sm-8 <?= FXPP::html_url() == 'sa' ? 'col-lg-8 col-md-8 col-xs-12' : '' ?> arabic-send-request">
                        <button type="submit" class="btn-submit">
                            <?=lang('chapas_04');?>
                        </button>
                    </div><div class="clearfix"></div>
                </div>

            </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">


    $("#sms_active").change(function(){

        if($(this).is(":checked")){
            $("#mobile").show();
        }else{
            $("#mobile").hide();
        }
    })

    $("#sms_deactive").change(function(){

        if($(this).is(":checked")){
            $("#mobile").hide();
        }else{
            $("#mobile").hide();
        }
    })
</script>