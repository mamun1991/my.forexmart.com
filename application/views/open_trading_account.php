<style type="text/css">
    div.open-trading-cont{
        margin-top: 25px;
    }
</style>

<h1 class="">Open Trading Account</h1>
<div class="col-md-7 col-centered open-trading-cont">
    <form action="" method="post" class="form-horizontal open-demo-account-form" id="open_trading">
        <div class="form-group">
            <label class="col-sm-5 control-label">Account Type<cite class="req">*</cite></label>
            <div class="col-sm-7">
                <select class="form-control round-0" name="mt_account_set_id">
                    <?php echo $account_type;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Account Currency Base<cite class="req">*</cite></label>
            <div class="col-sm-7">
                <select class="form-control round-0" name="mt_currency_base">
                    <?php echo $account_currency_base;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">Leverage<cite class="req">*</cite></label>
            <div class="col-sm-7">
                <select class="form-control round-0" name="leverage">
                    <?php echo $leverage;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="button" class="btn-submit" id="btn-trading-complete">Complete</button>
            </div><div class="clearfix"></div>
        </div>
    </form>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        $('div.open-trading-cont').on("focus",'select',function(){
            $(this).css('border','');
            $(this).removeClass("red-border");

        });

        $('div.open-trading-cont').on("click", "#btn-trading-complete", function(){
            flag = true;
            $("select.form-control").each(function(){
                if($(this).val().length>0){
                    $(this).removeClass("red-border");
                }else{
                    $(this).addClass("red-border");
                    // $(this).focus();
                    flag = false;
                }
            });

            if(flag){
                $("#open_trading").submit();
            }
        });
    });
</script>
