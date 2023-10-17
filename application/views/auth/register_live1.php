<style>
    .red{text-align: left; color: red;}
    .form-holder h1{text-align: left;}
</style>
<div class="reg-form-holder" xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row col-centered">
            <div class="col-lg-3 col-md-3 ">

            </div>
            <div class="col-lg-8 col-md-8">
                <div class="form-holder">

                    <h1><?=lang('int_reg_00')?> </h1>

                    <form action="" method="post" class="form-horizontal">

                        <?php /*if(form_error('email') || form_error('full_name')){*/?><!--
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php /*echo  form_error('email')*/?>
                        <?php /*echo  form_error('full_name')*/?>
                        </div>
                        --><?php /*}*/?>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?=lang('int_reg_01')?><cite class="req">*</cite></label>
                            <div class="col-sm-6">
                                <input name="email" type="text" class="form-control round-0 <?php echo form_error('email')?"red-border":""?>" id="inputEmail3" placeholder="<?=lang('int_reg_01')?>" value="<?=set_value('email');?>">

                            </div>
                            <span class="col-sm-4 red">  <?php echo  form_error('email')?> </span>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?=lang('int_reg_02')?><cite class="req">*</cite></label>
                            <div class="col-sm-6">
                                <input name="full_name" type="text" class="form-control round-0 <?php echo form_error('full_name')?"red-border":""?>" id="full" placeholder="<?=lang('int_reg_02')?>" value="<?=set_value('full_name');?>">

                            </div>
                            <span class="col-sm-4 red"> <?php echo  form_error('full_name')?> </span>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn-submit"><?=lang('int_reg_03')?></button>
                            </div><div class="clearfix"></div>
                        </div>
                        <label class="control-label form-text"><?=lang('int_reg_04')?></label>
                        <div class="clearfix"></div>
                    </form>
                    <a href="<?php echo base_url()?>signin" >
                        <button type="button" class="btn-signin"><?=lang('int_reg_05')?></button>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>