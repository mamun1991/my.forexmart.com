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
    <h1><?= lang('trd_9'); ?></h1>
    <ol class="breadcrumb internal-breadcrumb">
        <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_22'); ?></a></li>
        <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_28'); ?></a></li>
        <li class="active"><?= lang('dbt_desc'); ?></li>
    </ol>
    <div class="debit-credit-row">

        <div class="debit-col">
            <div class="debit-credit-holder">
                <img src="<?= $this->template->Images() ?>inpay_icon.png" class="img-reponsive" style="height: 51px;">
                <p><?= lang('trd_32'); ?></p>
                <a id="submit_bonus"  href="<?= FXPP::loc_url('deposit/inpay');?>"> <?= lang('trd_30'); ?></a>
            </div>
        </div>

    </div>

</div>


<form action="" id="limited" method="">
    <input type="hidden" id="amount1" name="amount1" value='<?=floatval($amount);?>'>
</form>
<?php
if( strtoupper($currency) == 'RUB' ){
    echo $modal_currency_cardpay;
}
?>
<script type="text/javascript">

    var get_bonus = "<?= $_GET['bonus']?>";
    if ( $( 'a#submit_bonus' ).length ) {
        if(get_bonus === "twpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/inpay');?>?bonus=twpb');
        }
        if(get_bonus === "tpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/inpay');?>?bonus=tpb');
        }
        if(get_bonus === "fpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/inpay');?>?bonus=fpb');
        }
        if(get_bonus === "hpb"){
            $('a#submit_bonus').attr('href','<?= FXPP::loc_url('deposit/inpay');?>?bonus=hpb');
        }
    }



</script>

