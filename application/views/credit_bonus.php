<style>
    .credit-bonus{
        margin: 140px 0px;
    }
    .show-message{
        margin-left: 402px;
        white-space: normal;
        height: auto;
        width: 38%;
    }
    }
</style>
<h1>Credit Bonus $30</h1>

<?php //echo "<pre>"; print_r($userdata);?>
<div class="row tab-content credit-bonus">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">

        <form method="post" action="" class="form-horizontal" style="margin-top: 50px;">
            <div class="form-group">
                <label class="col-sm-6 control-label"></label>
                <div class="col-sm-5 show-message">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-6 control-label">
                    Account number
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="account_num" class="form-control round-0" id="account-num" placeholder="Enter Account Number" value="">
                </div>
            </div>
            <!--
            <div class="form-group">
                <label class="col-sm-6 control-label">
                    IB Code
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="ib_code" id="ib-code" value="" class="form-control round-0" disabled>
                </div>
            </div>
            -->
            <div class="form-group">
                <div class="col-sm-offset-6 col-sm-5">
                    <button type="button" class="btn-submit" id="credit-bonus">
                        Credit Bonus $30
                    </button>
                </div><div class="clearfix"></div>
            </div>
        </form>

    </div>
</div>


<script>

    $("#credit-bonus").click(function(){
        var account_num = $('#account-num').val();

        $.ajax({
            url: "/Credit_Bonus/CreditBonus30",
            type: "post",
            data: {account_num:account_num} ,
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.success===true){
                    $('.show-message').hide();
                    $('.show-message').show().delay(5000).fadeOut(300).addClass("btn btn-success").text(data.message);
                }else {
                    $('.show-message').hide();
                    $('.show-message').show().delay(5000).fadeOut(300).addClass("btn btn-danger").text(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

    });
    $('.show-message').hide();
</script>


