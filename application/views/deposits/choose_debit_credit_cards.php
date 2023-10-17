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
    .internal-breadcrumb {
        margin-top: 15px;
        border-radius: 0px;
    }

</style>


        <div class="deposit-cards-holder">
            <h1><?= lang('trd_5'); ?></h1>
            <ol class="breadcrumb internal-breadcrumb">
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_22'); ?></a></li>
                <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_28'); ?></a></li>
                <li class="active"><?= lang('ddc_desc'); ?></li>
            </ol>
            <div class="debit-credit-row">



             <?php if(FXPP::isPayomaPayMentAvailable()){ ?>

                <div class="debit-col">
                    <div class="debit-credit-holder">
                        <img src="<?= $this->template->Images()?>payoma.png" class="img-responsive">
                        <p><?= lang('trd_31'); ?></p>
                        <!-- <button type="submit" class="emerchantpay" href="<?//= FXPP::loc_url('deposit/payoma').$url;?>"><?//= lang('trd_30'); ?></button> -->
                        <a class="payoma"  ><?= lang('trd_30'); ?></a>


                    </div>
                </div>

               <?php } ?>



                <?php        if( false && FXPP::isAccountFromEUCountry()){?>
            <div class="debit-col">
                <div class="debit-credit-holder">
                    <img src="<?= $this->template->Images()?>cardpay.png" class="img-responsive">
                    <p><?= lang('trd_25'); ?></p>
                    <!-- <a href="<?= FXPP::loc_url('deposit/cardpay/'.$bonusAmount);?>">Deposit now</a> -->
                    <?php  if(IPLoc::Office()){ ?>
                        <a id="submit_bonus"  href="<?= FXPP::loc_url('deposit/cardpay_v2').$url;?>"> <?= lang('trd_30'); ?></a>
                    <?php }else{ ?>
                        <a id="submit_bonus"  href="<?= FXPP::loc_url('deposit/cardpay').$url;?>"> <?= lang('trd_30'); ?></a>
                    <?php }?>

                    <?php
/*                    if($amount!=NULL){ */?><!--
                        <a id="submit_bonus"  href="Javascript:;"> Deposit now</a>
                    <?php /*}else{*/?>
                        <?php /*$url = isset($_GET['bonus']) ? '?bonus='.$_GET['bonus'] : ''; */?>
                        <a id="submit_bonus"  href="<?/*= FXPP::loc_url('deposit/cardpay').$url;*/?>"> Deposit now</a>
                    --><?php /*}*/?>
                </div>
            </div>


            </div>

            <?php }?>

            <form action="" id="limited" method="">
                <input type="hidden" id="amount1" name="amount1" value='<?=floatval($amount);?>'>
            </form>

        </div>


<?php
if( strtoupper($currency) == 'RUB' ){
    echo $modal_currency_cardpay;
}
?>
<script type="text/javascript">
     // $(document).on('click', '#submit_bonus', function(){
     //        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>');
     //        $("#limited").attr('method','POST');
     //        $('#limited').submit();
     //        }
     // $(document).on('click', '#submit_bonus2', function(){
     //        $("#limited").attr('action','<?= FXPP::loc_url('deposit/megatransfer-credit-card');?>');
     //        $("#limited").attr('method','POST');
     //           $('#limited').submit();
     //        }
     var get_bonus = "<?= $_GET['bonus']?>";
     if ( $( 'a#submit_bonus' ).length ) {
         if(get_bonus === "twpb"){
             $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=twpb');
         }
        if(get_bonus === "tpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=tpb');
        }
        if(get_bonus === "fpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=fpb');
        }
        if(get_bonus === "hpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=hpb');
        }
    }
$( "#submit_bonus" ).click(function() {
    <?php if( strtoupper($currency) == 'RUB' ) { ?>
    $('.currency-cardpay-alert-message').html('Deposit in RUR is not available.');
    $('#modalCurrencyCardPayAlert').modal('show');
    <?php }else{ ?>
    if(get_bonus === "tpb"){
        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=tpb');
    }else if(get_bonus === "twpb"){
        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=twpb');
    }else if(get_bonus === "fpb"){
        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=fpb');
    }else if(get_bonus === "hpb"){
        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>?bonus=hpb');
    }
    else{
        $("#limited").attr('action','<?= FXPP::loc_url('deposit/cardpay');?>');
    }
            $("#limited").attr('method','POST');
            $('#limited').submit();
    <?php } ?>
});


$( "#submit_bonus2" ).click(function() {
        console.log($('#amount1').val());

     $("#limited").attr('action','<?= FXPP::loc_url('deposit/megatransfer-credit-card');?>');
            $("#limited").attr('method','POST');
               $('#limited').submit();
});


     $( ".emerchantpay" ).click(function() {
         console.log($('#amount1').val());


         $("#limited").attr('action','<?= FXPP::loc_url('deposit/emerchantpay');?>'+ '?bonus='+get_bonus);
         $("#limited").attr('method','POST');
         $('#limited').submit();
     });

     var test_phase = false;
     <?php if(IPLoc::VPN_IP_Jenalie() || IPLoc::frzPM()){ ?>
        test_phase = true;
     <?php } ?>

     $( ".payoma" ).click(function() {
         console.log($('#amount1').val());

         var additional_bonus = "<?= $_GET['additional_bonus']?>";

         $("#limited").attr('action','<?= FXPP::loc_url('deposit/payoma');?>'+ '?bonus='+get_bonus+'&addBonus='+additional_bonus);

         $("#limited").attr('method','POST');
         $('#limited').submit();
     });

</script>

