<script type="text/javascript">
    $(window).bind('scroll', function() {
        if ($(window).scrollTop() > 95) {
            $('#nav').addClass('nav-fix');
        }
        else {
            $('#nav').removeClass('nav-fix');
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#next").click(function(){
            $(".info-text").text("Your Almost Done.");
        });
        $("#back").click(function(){
            $(".info-text").text("Thank you, You're half way to completing your demo account.");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".personal-next").click(function(){
            $(".tabs-title1").removeClass("color");
            $(".tabs-title2").addClass("color");
        });
        $(".trading-next").click(function(){
            $(".tabs-title2").removeClass("color");
            $(".tabs-title3").addClass("color");
        });
        $(".trading-back").click(function(){
            $(".tabs-title2").removeClass("color");
            $(".tabs-title1").addClass("color");
        });
        $(".acc-back").click(function(){
            $(".tabs-title3").removeClass("color");
            $(".tabs-title2").addClass("color");
        });
    });
</script>
<style>
    .nav-fix
    {
        position: fixed;
        top: 0;
        z-index: 9999;
        width: 100%;
        transition: all ease 0.3s;
    }
    .error{ color: #a94442;
</style>


<script>
var base_url = "<?php echo base_url();?>";
    function checkPassword(pass){

        $.post(base_url+"register/passwordCheck",{pass:pass,status:"demo"},function(data){

            if(data){

                $("#error_password").text("This password has already been used by other account under the same email.");
                $("#pass").val("");
                //alert(flg);

            }else{
                $("#error_password").text("");
            }
        })


    }

    $(document).on("focus",'input,select',function(){
        $(this).css('border','');
        $(this).removeClass("red-border");
        
    })

    $(document).on("click",'.next_step',function(event){

       var  $pass =  $("#pass").val();
        var  $repass =  $("#repass").val();
        var  $country =  $("#country").val();
        var flag = true;


        if($pass.match(/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,})$/)){
            $("#error_password").text("");
            $("#pass").css("border",' ');
        }else{
            $("#error_password").text("Minimum of 8 characters, combination of a-z, A-Z and at least one digit,0-9.");
            $("#pass").css("border",' 1px solid red');
            flag = false;
        }

       if($repass.length>1){
            if($pass == $repass){
                $("#error_re_password").text("");
                $("#repass").css("border",' ');
            }else{
                $("#error_re_password").text("Passwords does not match.");
                $("#repass").css("border",' 1px solid red');
                flag = false;
            }
       }else{
           $("#error_re_password").text("Re-enter password.");
           $("#repass").css("border",' 1px solid red');
           flag = false;
       }

        if($country.length>1){
            $("#country").css("border",'');
           // $("#country").css("background-color",'');
        }else{
            $("#country").css("border",' 1px solid red');
           // $("#country").css("background-color",'red');
            flag = false;
        }


        if(flag){
            $("#next").attr("href",'#step3');
            $("#next").click();
        }

        /*if (preg_match('/[A-Z]+[a-z]+[0-9]+/', $myString))
        {
            alert('Secure enough') ;
        }else{
            alert('not Secure enough') ;
        }*/




    })
    $(document).on("click",'#step_complete',function(event){

        flag = true;
        //alert("test")
        $("#step3 select").each(function(){

            if($(this).val().length>0){

               $(this).removeClass("red-border");
            }else{
                $(this).addClass("red-border");
               // $(this).focus();
                flag = false;
            }
        })



        if(flag){
           $("#demo_form").submit();
           // $("#next").attr("href",'#step3');
            //$("#next").click();
        }
    })

</script>
<style>

    .red-border{
        border: 1px solid red; }
    }

</style>

<div class="reg-form-holder">
    <div class="container">
        <div class="row">
            <h1 class="info-text"><?=lang('int_reg_41')?>.</h1>
            <div class="step-tab-holder">
                <ul>
                    <li>
                        <img src="<?= $this->template->Images()?>step.png" class="img-reponsive" width="60"/> Step 2
                    </li>
                    <li>
                        <img src="<?= $this->template->Images()?>nxt.png" class="img-reponsive" width="60"/>
                    </li>
                    <li>
                        <img src="<?= $this->template->Images()?>step.png" class="img-reponsive" width="60"/> Step 3
                    </li>
                </ul><div class="clearfix"></div>
            </div>
            <form id="demo_form" action="" method="post" >
            <div class="tab-content" style="margin-top: 30px;">

                <div role="tabpanel" class="step2 tab-pane active" id="step2">
                    <div class="col-lg-12 col-md-12 col-centered">

                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-5 control-label"><?=lang('int_reg_42')?><cite class="req">*</cite></label>
                                <div class="col-sm-4">
                                        <input onblur="checkPassword(this.value)"  type="password" name="password" class="form-control round-0 col-sm-4" id="pass" placeholder="<?=lang('int_reg_42')?>">
                                </div>
                                   <span  class="col-sm-3 error" id="error_password"> <?php echo  form_error('password')?></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label"><?=lang('int_reg_43')?><cite class="req">*</cite></label>
                                <div class="col-sm-4">
                                    <input type="password" name="re_password" class="form-control round-0" id="repass" placeholder="<?=lang('int_reg_43')?>">

                                </div>
                                <span class="col-sm-3 error" id="error_re_password"> <?php echo  form_error('re_password')?></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label"><?=lang('int_reg_44')?><cite class="req">*</cite></label>
                                <div class="col-sm-4">

                                    <select id="country"  name="country" class="form-control round-0 ">
                                        <?php echo $countries; ?>
                                    </select>

                                </div>
                               <!-- <span class="col-sm-3 alert-danger" id="error_country"><?php /*echo  form_error('country')*/?></span>-->
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label"><?=lang('int_reg_45')?></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control round-0" id="phone" placeholder="<?=lang('int_reg_45')?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-5">

                                    <a class="next2" href="Javascript:;" role="tab" data-toggle="tab" id="next"><button type="button" class="btn-submit next_step"><?=lang('int_reg_20')?></button></a>
                                </div><div class="clearfix"></div>
                            </div>
                       </div>
                    </div>

                </div>
                <div role="tabpanel" class="step3 tab-pane" id="step3">
                    <div class="col-lg-6 col-md-6 col-centered">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"><?=lang('int_reg_46')?><cite class="req">*</cite></label>
                                <div class="col-sm-8">
                                    <select id="account_type"  name="account_type" class="form-control round-0">
                                       <?php echo $account_type; ?>
                                    </select>
                                    <?php echo  form_error('account_type')?>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label"><?=lang('int_reg_47')?><cite class="req">*</cite></label>
                                <div class="col-sm-8">
                                    <select id="currency" name="currency" class="form-control round-0">
                                        <?php echo $account_currency_base; ?>
                                    </select>
                                    <?php echo  form_error('currency')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label"><?=lang('int_reg_48')?><cite class="req">*</cite></label>
                                <div class="col-sm-8">
                                    <select id="leverage" name="leverage" class="form-control round-0">
                                        <?php echo $leverage; ?>
                                    </select>
                                    <?php echo  form_error('leverage')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label"><?=lang('int_reg_49')?><cite class="req">*</cite></label>
                                <div class="col-sm-8">
                                    <select id="amount" name="amount" class="form-control round-0">
                                        <?php echo $amount; ?>
                                    </select>
                                    <?php echo  form_error('amount')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <label><?=lang('int_reg_29')?></label>
                                    <div class="slideThree">
                                        <input  type="checkbox" value="1" id="slideThree" name="technical_analysis" onclick="exefunction()" style="display: none;"/>
                                        <label for="slideThree"></label>
                                    </div>
                                </div><div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button id="step_complete" type="button" class="btn-submit"><?=lang('int_reg_35')?></button>
                                    <a href="#step2" aria-controls="step2" role="tab" data-toggle="tab" class="back" id="back"><?=lang('int_reg_36')?></a>
                                </div><div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </form>
        </div>

    </div>
</div>