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
</style>
<?php
$disabled = $disable_input ? '' : ' disabled="disabled"';
?>
<!--<h1><?/*=lang('duksh_00');*/?></h1>-->
<h1> <?=lang('ukash_h');?></h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <form class="form-horizontal" style="margin-top: 50px;">
            <?php if(!$disable_input){ ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert"><?=lang('duksh_01');?></div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <!--<label class="col-sm-4 control-label"><?/*=lang('duksh_02');*/?><cite class="req">*</cite></label>-->
                <label class="col-sm-4 control-label"><?=lang('ukash_01');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php $attr = 'id="currency" class="form-control round-0"' . $disabled ?>
                    <?php echo form_dropdown('currency',FXPP::getUserAccountCurrencyBase(),false,$attr);?>
                </div>
            </div>
            <div class="form-group">
                <!--<label class="col-sm-4 control-label"><?/*=lang('duksh_03');*/?><cite class="req">*</cite></label>-->
                <label class="col-sm-4 control-label"><?=lang('ukash_02');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" id="amount" name="amount" class="form-control round-0 numeric depositamountcheck"<?php echo $disabled ?>>
                     <span class="errorlineshow" style="color: red"> </span>
                </div>
            </div>
            <div class="form-group">
                <!--<label class="col-sm-4 control-label"><?/*=lang('duksh_04');*/?><cite class="req">*</cite></label>-->
                <label class="col-sm-4 control-label"><?=lang('ukash_03');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control round-0"<?php echo $disabled ?>>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <!--<button type="button" class="btn-submit"<?php /*echo $disabled */?>><?/*=lang('ddcc_04');*/?></button>-->
                    <button type="button" class="btn-submit"<?php echo $disabled ?>><?=lang('ukash_bu');?></button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<!--<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?/*=lang('ddcc_05');*/?></h1>-->
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?=lang('ukash_04');?></h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?/*=lang('duksh_05');*/?><!-- <a href mailto="finance@forexmart.com"><?/*=lang('duksh_06');*/?></a>.-->
                <?=lang('ukash_04_1');?><a href mailto=" <?=lang('ukash_04_2');?>"> <?=lang('ukash_04_2');?></a>.
            </p>
        </td>
    </tr>
</table>