            <style type="text/css">
                body{color: #333!important;}
                .custom_h1{font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 18px;color: #333;}
                .custom_h1_uline{border-bottom: 1px solid rgb(41, 136, 202);margin-bottom: 10px;}
            </style>

            <script>
                $("[data-slider]")
                    .each(function () {
                        var input = $(this);
                        $("<span>")
                            .addClass("output")
                            .insertAfter($(this));
                    })
                    .bind("slider:ready slider:changed", function (event, data) {
                        $(this)
                            .nextAll(".output:first")
                            .html(data.value.toFixed(3));
                    });
            </script>


<div class="pamm-onclick-page destination-class" id="pamm-div-trader">
    <?=$nav;?>

    <div id="my-tab-content" class="tab-content pamm-tab-content">

        <div  id="my-conditions">
            <?php if(isset($_SESSION['mycondition_update'])){?>
                <div id="partner_registration_prompt" style="text-align: center;">
                    <?php if($_SESSION['mycondition_success']==True){?>
                    <div class="alert alert-success"><strong>My Condition:</strong>  Update is successful.</div>
                    <?php }else{?>

                    <div class="alert alert-warning"><strong>My Condition:</strong>  <?=$_SESSION['mycondition_errror_msg']?></div>
                    <?php }?>
                </div>
            <?php unset($_SESSION['mycondition_update']); }else{}?>

            <form action="<?=FXPP::my_url('pamm/my_conditions_post')?>" method="post"  id="my_condition" accept-charset="utf-8" autocomplete="off">

                <?php
//                        var_dump($infor);
                        for ($i = 1; $i <= 4; $i++) {
                            switch ($i) {
                                case 2:
                                    $investment = 500;
                                    break;
                                case 3:
                                    $investment = 1000;
                                    break;
                                case 4:
                                    $investment = 3000;
                                    break;
                                default:
                                    $investment = 0;
                            }
                            $cond = array(
                                'no' => $i,
                                'investment' => $investment,
                                'infor' => $infor
                            );
                            echo $this->load->view('pamm/cond_pack', $cond, TRUE);
                        }
                ?>

            <div class="pamm-content-input">
                <div class="custom_h1_uline">
                    <label class="custom_h1">
                    Minimal investment sum
                    </label>
                </div>
                <div class="from-group row minimal-sum-holder">
                    <label  class="col-sm-6">Minimal investment sum in your PAMM-account:</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="minimum_investment_sum" name="minimum_investment_sum" placeholder="Amount" value="<?= set_value('minimum_investment_sum') == false ? ((isset($infor[1]['apply_investment_from']))?$infor[1]['apply_investment_from']:0) : set_value('minimum_investment_sum') ?>">
                            <div class="input-group-addon">USD</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-set-holder">
                <button type="button" name="formbutton" value="set" id='set_condition' class="btn-set">
                    <!--Set-->
                    Set
                </button>
            </div>

            </form>
        </div>
    </div>
</div>

<script type="application/javascript">


    // $('#my_condition').validate({ // initialize the plugin
    //     rules: {
    //         minimum_investment_sum:  "required",
    //         investoricq:  {
    //             number: true
    //         }
    //     },
    //     messages: {
    //         minimum_investment_sum:  "Enter minimum investment sum"

    //     },
    //     submitHandler: function (form) {
    //         form.submit();

    //     }
    // });
    
    // $("#my_condition").submit(function(e) {
    //     e.preventDefault();
    // });

    $('#set_condition').click(function(){

        $("#my_condition").submit(); 
    });




    $(document).on("click",".conditionpackage",function() {
        if ($('#'+this.id).is(':checked')) {
            if($( "div#div_inlinecheck"+this.id ).hasClass( "hide" )){

            }else{
                $("div#div_"+this.id).removeClass('hide');
            }
        }else{
            if($( "div#div_inlinecheck"+this.id ).hasClass( "hide" )){

            }else{
                $("div#div_"+this.id).addClass('hide');
            }
        }
    });
</script>

