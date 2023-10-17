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
    p{ margin: 0px 0px !important;}
</style>
<h1>
    <?= lang('trd_13'); ?>
</h1>
<div class="row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form action="" method="post" class="form-horizontal subMob" enctype="multipart/form-data" style="margin-top: 50px;">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="alert alert-danger" role="alert" id="amountErrorVal" style="display: none"></div>
                </div>
            </div>

            <?php if($CurPendValidation['TradeError'] && !empty($CurPendValidation['TradeError']) ){?>
                <div class="form-group">
                    <div class="col-sm-12" style= "margin-top: 21px;">
                        <?php if(!empty($CurPendValidation['TradeErrorMsg'])){?>
                            <div class="alert alert-danger" role="alert">
                                <?php  echo $CurPendValidation['TradeErrorMsg'];?>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>

            <?php
            $disabled = "";
            if($error_msg){
                $disabled = "disabled";
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <?=$error_msg?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php  //$disabled = false;
            $display = $this->session->flashdata('msg');
            if(isset($display)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-success center" role="alert">
                            <p> <?=$display?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php  //$disabled = false;
            // $display = $this->session->flashdata('cardpay_transaction');
            if(isset($msg)){
                ?>
                <div class="form-group" style="">
                    <div class="col-sm-10">
                        <div class="alert alert-danger center" role="alert">
                            <p> <?=$msg;?> </p>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <!--<div class="form-group">
                <label class="col-sm-4 control-label"></label>
                <div class="col-sm-8">
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>mastercard2.png" width="40px"></a>
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>maestro.png" width="40px"></a>
                    <a href="#"> <img src="<?/*= $this->template->Images()*/?>visacard-new.png" width="40px"></a>
                    <a href="#">  <img src="<?/*= $this->template->Images()*/?>visacard2.png" width="40px"></a>
                    <a href="#"> <img src="<?/*= $this->template->Images()*/?>switch.png" width="40px"> </a>
                </div>
            </div>-->

            <?php if(!$is_allowed_deposit){  $disabled = "disabled"; ?>

                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Sorry, but the following payment option is not available in your country.
                </div>

            <?php }?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>payoma.png" border="0" alt="" style="width: 165px; margin-bottom: 15px;"/>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_02');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <?php
                    //$attr = 'id="currency" class="form-control round-0"' . $disabled;
                    ?>
                    <?php //echo form_dropdown('account_currency',Custom_library::getDepositCurrencyBase(),false,$attr);?>
                    <input type="hidden" name="account_currency" id="currency" value="<?php echo $account['id'] ?>"/>
                    <input type="text" name="currency" id="currency" class="form-control round-0" value="<?php echo $account['currency'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>

            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label">
                   Currency type
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <select name="currency_type" class="form-control round-0">
                        <option <?php echo $account['currency'] == 'USD' ? "selected":"" ?>  value="USD">USD</option>
                        <option <?php echo $account['currency'] == 'EUR' ? "selected":"" ?> value="EUR">EUR</option>
                        <?php if(IPLoc::Office()){?>
                            <option <?php echo $account['currency'] == 'RUB' ? "selected":"" ?> value="RUB">RUB</option>
                        <?php }; ?>
                    </select>
                   
               </div>

            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?=lang('ddcc_03');?>
                    <cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="amount" value="<?=floatval($amount)?>"  id="amount" class="form-control round-0 numeric depositamountcheck"/>
                    <input type="hidden" name="bounusfiled" id="bounusfiled"  class="form-control round-0"   value="<?=$bounusfiled?>" >
                    <div class="reqs errorlineshow">
                        <?php echo form_error('amount'); ?>
                    </div>
                </div>
            </div>


                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        Card number
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input class="form-control round-0" type="text" name="card_number" id="card_number">
                    </div>
                    <div class="reqs ">
                        <?php echo form_error('card_number'); ?>
                    </div>
                </div>

                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        Color copy of front side of the card
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input class="form-control round-0" type="file" name="front_side" id="front_side">
                    </div>
                    <div class="reqs ">
                        <?php echo form_error('front_side'); ?>
                    </div>
                </div>


                <div class="form-group">

                    <label class="col-sm-4 control-label">
                        Color copy of back side of the card
                        <cite class="req">*</cite></label>

                    <div class="col-sm-5">
                        <input class="form-control round-0" type="file" name="back_side" id="back_side">
                    </div>
                    <div class="reqs ">
                        <?php echo form_error('back_side'); ?>
                    </div>
                </div>






            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="submit" class="btn-submit" id="send2"<?php echo $disabled ?>>
                        <?=lang('ddcc_04');?>
                    </button>
                </div><div class="clearfix"></div>
            </div>

        </form>

    </div>

</div>



    <h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
        <?=lang('n_21');?>
    </h1>
    <table class="notes-list" style="margin-bottom: 150px;">
        <tr class="cb">
            <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
            <td  class="r_">
                <p>
                    Back image signature field must be signed - First six digits to reveal,
                    middle six digits to hide, final four digits to reveal again. So only 6 digits must be covered. And to hide CVV/CVC.
                </p>
            </td>
        </tr>
        <?php if(FXPP::IsCountryPayoma()){ ?>
            <tr class="cb">
                <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                <td  class="r_">
                    <p>
                        <b>Dear Client! <br><br>

                            For successful deposit, please verify your card. To verify, you must send the required documents to finance@forexmart.com. Documents required: <br><br>
                            Clear photos of both sides of the card. The middle of the card number should be covered, leaving the first 6 and last 4 digits, expiry date and cardholder name visible.
                            On the back side, CVC/CVV code should be covered, leaving the cardholder's signature visible. <br><br>

                            You'll be notified via email when your card documents are approved or rejected. We apologize for inconveniencing you.</b>
                    </p>
                </td>
            </tr>
        <?php } ?>

    </table>


<script type="text/javascript">

    function isMobile(a) {
        return (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)));
    }
    $(document).ready(function(){

        if( isMobile(navigator.userAgent || navigator.vendor || window.opera) ) {
            setTimeout(function(){
                //$('form input[type="text"]').prop("disabled", false);
                $('form input[name="amount"]').removeAttr("disabled");
                $('form input[name="card_number"]').removeAttr("disabled");
                $('form input[name="front_side"]').removeAttr("disabled");
                $('form input[name="back_side"]').removeAttr("disabled");
            }, 1000);
        }
    });



    $(document).on('touchstart click', '#send2', function(){
        if( isMobile(navigator.userAgent || navigator.vendor || window.opera) ) {
            $('.subMob').submit();
        }
    });


</script>
