<?php
$this->load->view('profile_nav');
?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="pass" style="<?= FXPP::html_url() != 'sa' ? 'min-height: 600px;' : '' ?>">

        <div class="row">
            <div class="col-md-12 col-centered <?= FXPP::html_url() == 'sa' ? 'col-lg-12 col-md-12 col-xs-12' : '' ?>">
                <div>
                    <h1>Your second step</h1>
                    <P> After entering your password, you’ll be asked for a second verification step.</P>

                   <h1>Registered Phone</h1>
                    <p><?=$auth['phone']?><br>
                    Verification codes are sent by text message.
                    </p>

                    <p> <a href="<?=FXPP::my_url('security-verification/setting?flag=0')?>"> Change phone</a></p>

                </div>




            </div>

        </div>
    </div>
</div>
<style>
    .red{color: red;}
</style>
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