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
    <h1>Local bank transfer in Malaysia</h1>
    <ol class="breadcrumb internal-breadcrumb">
        <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_22'); ?></a></li>
        <li><a href="<?= FXPP::loc_url('withdraw');?>"><?= lang('trd_23'); ?></a></li>
        <li class="active">Withdraw via Local bank transfer in Malaysia</li>
    </ol>
    <div class="debit-credit-row">

        <div class="debit-col">
            <div class="debit-credit-holder">
                <img src="<?= $this->template->Images() ?>payment_getway_logo/paytrust-banks.png" class="img-reponsive" style="height: 100px;margin:10px">

                <a class="submit_bonus"  data-type="bank-transfer-myr" href="#"> Withdraw PayTrust</a>
            </div>
        </div>
        <div class="debit-col">
            <div class="debit-credit-holder">
                <img src="<?= $this->template->Images() ?>payment_getway_logo/zp-bank-myr.png" class="img-reponsive" style="height: 100px;margin:10px">
                <a class="submit_bonus" data-type="zotapay" href="#"> Withdraw ZotaPay</a>
            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    $('.submit_bonus').click(function(event) {
        event.preventDefault();
        var type  = $(this).attr('data-type');
        var url ='<?= FXPP::loc_url('withdraw');?>/' + type + '?wallet_id=myr';
        window.location.href = url;
    });
</script>

