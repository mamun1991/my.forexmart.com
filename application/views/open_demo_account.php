<style type="text/css">
    div.open-demo-cont{
        margin-top: 25px;
    }
    .red-border{ border: 1px solid red; }
    div.error_p p{
        color: red;
    }
</style>

<h1 class="">Open Demo Account</h1>
<div class="col-lg-10 col-md-10 col-centered open-demo-cont">
    <div class="form-horizontal" style="margin: 20px;">
    <form action="" method="post" class="form-horizontal open-demo-account-form" id="open_demo">
        <div class="form-group">
            <label for="account_type" class="col-sm-3 control-label">Account Type<cite class="req">*</cite></label>
            <div class="col-sm-6">
                <select class="form-control round-0 required" name="acct_type" id="acct_type">
                    <?php echo $accountType;?>
                </select>
            </div>
            <div class="error_p col-sm-3" id="error_acct_type"><?php echo form_error('acct_type'); ?></div>
        </div>

        <div class="form-group">
            <label for="acct_cur_base" class="col-sm-3 control-label">Account Currency Base<cite class="req">*</cite></label>
            <div class="col-sm-6">
                <select class="form-control round-0 required" name="acct_cur_base" id="acct_cur_base">
                    <?php echo $accountCurrencyBase;?>
                </select>
            </div>
            <div class="error_p col-sm-3" id="error_acct_cur_base"><?php echo form_error('acct_cur_base'); ?></div>
        </div>

        <div class="form-group">
            <label for="acct_leverage" class="col-sm-3 control-label">Leverage<cite class="req">*</cite></label>
            <div class="col-sm-6">
                <select class="form-control round-0 required" name="acct_leverage" id="acct_leverage">
                    <?php echo $leverage;?>
                </select>
            </div>
            <div class="error_p col-sm-3" id="error_acct_leverage"><?php echo form_error('acct_leverage'); ?></div>
        </div>
        <div class="form-group">
            <label for="acct_amt" class="col-sm-3 control-label">Amount<cite class="req">*</cite></label>
            <div class="col-sm-6">
                <select class="form-control round-0 required" name="acct_amt" id="acct_amt">
                    <?php echo $amount;?>
                </select>
            </div>
            <div class="error_p col-sm-3" id="error_acct_amt"><?php echo form_error('acct_amt'); ?></div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-5">
                <button type="button" class="btn-submit" id="btn-demo-complete">Complete</button>
            </div><div class="clearfix"></div>
        </div>
    </form>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        $('div.open-demo-cont').on("focus",'select',function(){
            jQuery(this).closest('div').next('div.error_p').html("");
            $(this).removeClass("red-border");
        });


        $('div.open-demo-cont').on("click", "#btn-demo-complete", function(){
            var flag =true;
            var errors = new Array();
            jQuery(".open-demo-cont .required").each(function(){
                if('' == jQuery(this).val()){
                    flag = false;
                    errors.push(this.name);
                }
            });

            if(flag){
                $("#open_demo").submit();
            }else{
                for(error in errors){
                    switch (errors[error]){
                        case 'acct_type':
                            jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                            jQuery("select#"+errors[error]).addClass('red-border');
                            break;
                        case 'acct_cur_base':
                            jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                            jQuery("select#"+errors[error]).addClass('red-border');
                            break;
                        case 'acct_leverage':
                            jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                            jQuery("select#"+errors[error]).addClass('red-border');
                            break;
                        case 'acct_amt':
                            jQuery("#error_"+errors[error]).html( "<p>This field is required.</p>" );
                            jQuery("select#"+errors[error]).addClass('red-border');
                            break;
                    }
                }
            }
        });
    });
</script>
