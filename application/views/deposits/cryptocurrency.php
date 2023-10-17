
<h1>
<?= lang('trd_10'); ?>
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">

        <form method="post" action="" class="form-horizontal" style="margin-top: 50px;" >

            <div class="form-group" style= "text-align: center;">
                <?php if(validation_errors() != false){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=validation_errors();?></div> <?php }
                 if(isset($error)){?>  <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"> <?=$error;?></div> <?php } ?>
            </div>


    
            <?php  if($error_msg){ ?>
                <div class="form-group" style= "text-align: center;">
                        <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>bitcoinlogo.png" border="0" alt="" style="width: 200px; margin-bottom: 15px;"/>
            </div>


            <?php if(isset($display_massage)){?>


                <div class="form-group">
                    <?php echo $display_massage; ?>
                </div>

            <?php }else{?>

            <div class="form-group">
                <label class="col-sm-6 control-label">
                    Account currency
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php echo $input_account_number; ?>
                  </div>
            </div>

           
            <div class="form-group">
                <label class="col-sm-6 control-label">
                Currency type
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency" class="form-control round-0">
                        <option value="btc">Bitcoin</option>
<!--                        <option value="ltc">Litecoin</option>-->

                    </select>
                </div>
            </div>

            


            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-5">
                    <button type="submit" class="btn-submit" <?=$disabled?>>
                    Send Request
                    </button>
                </div><div class="clearfix"></div>
            </div>


            <?php } ?>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?=lang('payco_03');?></h1>
<table class="notes-list" style="margin-bottom: 150px;">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                Minimum deposit amount is 5 USD.
            </p>
        </td>
    </tr>
</table>

