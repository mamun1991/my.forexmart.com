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
<h1><?= lang('cashu_h');?></h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <form method="post" action="<?php echo base_url()?>deposit/cashu" class="form-horizontal" style="margin-top: 50px;">
            <?php
            $disabled = "";
            if($error_msg){
                $disabled = "disabled"
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <?=$error_msg?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('cashu_01');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency" id="currency" class="form-control round-0"<?php echo $disabled ?>>
                        <?php   echo $option; ?>
                       <!-- <?php /*$option_value = Custom_library::getUserAccountCurrencyBase();
                        if(strlen($option_value)>2){ echo $option_value;}
                        else { */?>
                            <option value="usd" >USD</option>
                            <option value="EUR" >EUR</option>
                            <option value="GBP" >GBP</option>
                        --><?php /*}*/?>
                    </select>

                </div>
                <span class="col-sm-3 req">  <?php echo  form_error('currency')?> </span>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('cashu_02');?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input name="amount" type="text" class="form-control round-0 numeric" placeholder="0.00"<?php echo $disabled ?>>
                </div>
                <span class="col-sm-3 req">  <?php echo  form_error('amount')?> </span>

            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit"<?php echo $disabled ?>><?= lang('cashu_bu');?></button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?= lang('cashu_03');?></h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr>
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
             <?= lang('cashu_03_1');?>
            </p>
        </td>
    </tr>
</table>