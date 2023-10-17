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
    <h1>Local bank transfer in Indonesia</h1>
    <ol class="breadcrumb internal-breadcrumb">
        <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_22'); ?></a></li>
        <li><a href="<?= FXPP::loc_url('deposit');?>"><?= lang('trd_28'); ?></a></li>
        <li class="active">Deposit via Local bank transfer in Indonesia</li>
    </ol>
    <div class="debit-credit-row">

        <div class="debit-col">
            <div class="debit-credit-holder">
                <img src="<?= $this->template->Images() ?>payment_getway_logo/bca-idr.png" class="img-reponsive" style="height: 100px;margin:10px">

                <a class="submit_bonus"  data-type="bank-transfer-idr" href="#"> Deposit PayTrust</a>
            </div>
        </div>
        <div class="debit-col">
            <div class="debit-credit-holder">
                <img src="<?= $this->template->Images() ?>payment_getway_logo/idr-cards.png" class="img-reponsive" style="height: 100px;margin:10px">
                <a class="submit_bonus" data-type="zotapay" href="#"> Deposit ZotaPay</a>
            </div>
        </div>

    </div>

</div>


<script type="text/javascript">
    var addBonus = '&addBonus=0';
    <?php if(IPLoc::VPN_IP_Jenalie() || IPLoc::frzPM()){ ?>
        addBonus = ("<?= $_GET['addBonus']?>") ?  '&addBonus='+"<?= $_GET['addBonus']?>" : '&addBonus=0';
    <?php } ?>
    var bonus = ("<?= $_GET['bonus']?>") ?  '&bonus='+"<?= $_GET['bonus']?>" : '';
    var amount = ("<?=floatval($amount);?>") ? 'amount1=' + "<?=floatval($amount);?>" : 'amount1=0' ;
    $('.submit_bonus').click(function(event) {
        event.preventDefault();
        var type  = $(this).attr('data-type');
        var url ='<?= FXPP::loc_url('deposit');?>/' + type + '?' +  amount + bonus + addBonus;
        if(type == "zotapay"){
            url = url +  '&wallet_id=idr';
        }
        window.location.href = url;
    });
</script>

