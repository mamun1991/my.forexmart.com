
<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="<?= $this->template->Css()?>newdepositdefault/finance-style.css" rel="stylesheet">
<link href="<?= $this->template->Css()?>newdepositdefault/finance-style-v2.css" rel="stylesheet">

<!--<script type="application/javascript" src="https://my.forexmart.com/assets/js/bootstrap.min.js"></script>-->


<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


<script type="text/javascript">
    $(document).ready(function(){
        $(".int-side-collapse").click(function(){
            $(".dl-holder").slideToggle("fast");
        });
        $("#set_amount2").hide();
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

    .imgclslogo{
        display: block;
        max-height: 90px !important;
        max-width: 190px !important;
    }


    .imgclslogo2{
        display: block;
        max-height: 90px !important;
        max-width: 190px !important;
    }
    .finance-local-total-amount {
        display: table;
        float: none !important;
        margin: 0 auto;
    }
</style>
<script type="text/javascript">
    $(window).load(function(){
        $("#t1").addClass("acct-active");
    });

    $( document ).ready(function() {
        var $t1 = $('#t1');
        var $t2 = $('#t2');
        var $t3 = $('#t3');
        var $t4 = $('#t4');

        var ta1 = [$t2, $t3, $t4];
        var ta2 = [$t1, $t3, $t4];
        var ta3 = [$t2, $t1, $t4];
        var ta4 = [$t2, $t1, $t3];
        $("#t1").click(function(){
            $("#t1").addClass("acct-active");
            $.each(ta1, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t2").click(function(){
            $("#t2").addClass("acct-active");
            $.each(ta2, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t3").click(function(){
            $("#t3").addClass("acct-active");
            $.each(ta3, function(){
                $(this).removeClass("acct-active");
            });
        });
        $("#t4").click(function(){
            $("#t4").addClass("acct-active");
            $.each(ta4, function(){
                $(this).removeClass("acct-active");
            });
        });
    });
</script>


<?php
if($staticId != 'logId'){
    $this->load->view('finance_nav.php');
}
?>
<div class="tab-content acct-cont">
    <!--    <div role="tabpanel" class="tab-pane active" id="tab1">-->
    <!--        --><?//=$show_deposit;?>
    <!--    </div>-->


    <div class="section">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                <div class="finance-deposit-container">

                    <?php
                    if($this->session->userdata('new_reg_id'))
                    {
                        ?>
                        <div class="finance-deposit-description">
                            <p>Hello <span class="username-dep">Username101</span>,</p>
                            <p>Thank you for opening an MT4 account with ForexMart! Your login details are as follows:</p>
                            <table class="mt4-login-details-table">
                                <thead>
                                <th colspan="2">MT4 login details</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Account Number:</td>
                                    <td>154198</td>
                                </tr>
                                <tr>
                                    <td>Trader Password:</td>
                                    <td>4BNZfje</td>
                                </tr>
                                <tr>
                                    <td>Investor Password:</td>
                                    <td>fARGNCj</td>
                                </tr>
                                <tr>
                                    <td>Phone Password:</td>
                                    <td>K8jbpgw</td>
                                </tr>
                                <tr>
                                    <td>MT4 Live Server:</td>
                                    <td>real.forexmart.com:443</td>
                                </tr>
                                </tbody>
                            </table>
                            <p>The details are also sent to your email. Please deposit your account to start real trading. You can get unlimeted 30% bonus every time you make a deposit.
                            </p>
                        </div>
                        <?php
                    }
                    ?>


                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".imgclslogo").hide();
                            $(".imgclslogo2").hide();
                            $(".imgclsdtl").show();
                            $(".fdsc").show();
                            $(".paymentforidr").hide();
                            $("#submit_bonus").removeAttr("disabled");
                            $(".paymentforidr").css('border-top', '1px solid #eaeaea');
                            $(".paymentforidr").css('padding-top', '20px');
                            $("option[value='ddcc']").attr('selected','selected');
                            $(".pDescription").hide();
                            $(".defaultDes").show();
                            $(".pDescription2").hide();
                            $(".defaultDes2").show();
                            $("input:radio").attr("checked", false);
                            $(".btn_class_disable").attr("disabled","disabled");


                            // $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
                        });


                        var url = '';
                        var val = '';
                        var amount2='';


                        $(document).on('change', '#select-deposit-logo', function(){
                            var id = $(this).val();
                            $(".imgclslogo").hide();
                            $(".finance-image-rep #"+id).show();
                            $(".pDescription").hide();
                            $(".finance-description #"+id).show();
                            if(id == 'idr' || id == 'myr' || id == 'btc'){
                                $(".fdsc").hide();
                                $(".paymentforidr").show();
                                $("#submit_bonus").removeAttr("disabled");
                            }
                            else{
                                $(".fdsc").show();
                                $(".paymentforidr").hide();

                                $(".btn_class_disable").attr("disabled","disabled");
                                $("input:radio").attr("checked", false);
                                $(".ckbox_class").prop("checked", true);
                                $(".other_ckbox").prop("checked", true);

                                $("#amount").attr("disabled","disabled");
                                $("#set_amount").val('');
                                $(".show-img").hide();
                                $(".img-other").hide();

                                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>100-percent-bonus.png" class="img-responsive show-img"/>');
                                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>100-percent-bonus.png" class="img-responsive img-other"/>');
                            }
                            $("#amount").val("");
                            $("#financetable tbody tr").each(function(){
                                var amount=$(this).find(".radio_class").val();
                                amount=amount.trim(); 
                                amount=amount.replace(/ /g,'');
                                amount=amount.replace(/\s/g,'');
                               
                                if(parseInt(amount)>2000)
                                {
                                 //  alert(  $(this).find(".checking-bonus").find('.show-img').attr('src'));
                                   $(this).find(".checking-bonus").find('.show-img').attr('src','<?= $this->template->Images()?>50-percent-bonus.png');
                                }   
                            });
                            
                        });
                        $(document).on('input', '#amount', function(){
                            var amount=$(this).val();
                                amount=amount.trim(); 
                                amount=amount.replace(/ /g,'');
                                amount=amount.replace(/\s/g,'');
                               
                                if(parseInt(amount)>2000)
                                {
                                
                                   $("#img_show_percent").find(".img-other").attr('src','<?= $this->template->Images()?>50-percent-bonus.png');
                                }   
                        
                        });


                        $(document).on('change', '#select-deposit-logo2', function(){
                            var id = $(this).val();
                            url = id;
                            console.log(url);
                            $(".imgclslogo2").hide();
                            $(".finance-image-rep2 #"+id).show();
                            $(".pDescription2").hide();
                            $(".finance-description2 #"+id).show();

                            if(id == 'idr' || id == 'myr' || id == 'btc'){
                                $(".fdsc").hide();

                                $("#submit_bonus").hide();
                                $(".paymentforidr").hide();
                                $(".local-bank-content").hide();
                            }
                            else{
                                $(".fdsc").show();
                                $(".paymentforidr").hide();

                                $(".btn_class_disable").attr("disabled","disabled");
                                $("input:radio").attr("checked", false);
                                $(".ckbox_class").prop("checked", true);
                                $(".other_ckbox").prop("checked", true);

                                $("#amount").attr("disabled","disabled");
                                $("#set_amount").val('');
                                $(".show-img").hide();
                                $(".img-other").hide();

                                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
                                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
                            }
                        });



                       
                        $(document).on('change', '#financetable', function(){
                            var id = $(this).val();

                            console.log(id);
                            amount2=id;

                            var get = 0;
                            var get2 =  amount2;

                                 if (amount2>2000) {
                                    get= amount2*50/100;

                                }else{
                                     get= amount2*100/100;
                                }

                            $("#set_amount2").val(amount2);

                              if(amount2 > 2000){
                               // $(".img-other2").attr('src', '<?= $this->template->Images()?>50-percent-bonus.png');
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }
                            else
                            {
                                // $(".img-other2").attr('src', '<?= $this->template->Images()?>100-percent-bonus.png');
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }


                            if (amount2 == 'OtherAmount') {
                                $("#set_amount2").removeAttr("disabled");
                                $("#set_amount2").show();
                                $("#set_amount2").val(0);
                                $("#amount2").val(0);

                            }else{
                                if($('.other_ckbox2').prop('checked')) {
                                  get2 = parseFloat(get)+parseFloat(amount2);
                                }
                                
                                $("#amount2").val(get2);
                                $("#set_amount2").hide();
                                // $(".set_amount2").attr("disabled","disabled");
                            }



                        });

                        $(document).on("keyup","#set_amount2",function(){

                            // var id = $(this).val();
                            // amount2=id;
                            //  var get = 0;
                            //      // var pct = percent_calculation(value);
                            // if($('.other_ckbox2').prop('checked')) {
                            //   get= amount2*30/100;
                            // }
                            //  var get2=  Number(get)+Number(amount2);
                            // $("#amount2").val(get2);
                            // // $("#set_amount2").val(amount2);

                            var value = $(this).val();
                            if(value.length > 0.001){
                                $('.btn_class_disable').removeAttr('disabled');
                            }
                            else
                            {
                                $('.btn_class_disable').attr('disabled', 'disabled');
                            }

                            if(value > 2000){
                   
                                $("#img_show_percent2").attr('src', '<?= $this->template->Images()?>50-percent-bonus.png');
                            }
                            else
                            { 
                                $("#img_show_percent2").attr('src', '<?= $this->template->Images()?>100-percent-bonus.png');

                            }


                            var parcent = percent_calculation(value);
                            var total = parseFloat(parseFloat(value)+parseFloat(parcent));

                            if(isNaN(parseInt(value))){
                                $("#set_amount2").val('');
                            }else{
                                if($('.other_ckbox2').is(':checked')){
                                    $("#amount2").val(total);
                                    $(".radio_id").attr('id', value);
                                }
                                else{
                                    $("#amount2").val(value);
                                    $(".radio_id").attr('id', value);
                                }
                            }


                        });

                        $(document).on('click', '#submit_bonus', function(){

                            var myLength = $("#select-deposit-logo").val().length;
                            console.log($("#select-deposit-logo").val());
                            var amount1 = '';
                            var amount = '';

                            if(myLength == 0){
                                val = url;
                            }else{
                                val = $("#select-deposit-logo").val(); 
                               // console.log('val = else = ');
                                console.log(val);
                            }

                            if($('.radio_id').attr('id') != ''){
                                amount1 = $('.radio_id').attr('id');
                            }

                            var bonustype = '';                        
                            $("#financetable tbody tr").each(function(){
                                if($(this).find('.radio_class').is(':checked'))
                                {
                                    $('.radio_id').removeAttr('id');
                                    amount1 = $(this).find('.radio_class').attr('value');
                                    if($(this).find('.ckbox_class').is(':checked')){
                                        bonustype = '?bonus=hpb';
                                    }
                                }
                                
                                 
                                
                            });
                            
                   
                            
                            

                            if(amount1 == undefined ){
                                if(amount2 == ''){
                                    amount = $("#set_amount2").val();
                                }else{
                                    amount = amount2;
                                    console.log('this 2 amount ');
                                }

                            }else{
                                amount = amount1;
                            }

                            if($(".lastRadiobutton").is(':checked'))
                            {
                                if($("#lastBox").is(':checked'))
                                {
                                    bonustype = '?bonus=hpb';
                                }
                            }

                            if(val == 'btc'){
                                amount = '0';
                                if($("#btcCheck").is(':checked')){
                                        bonustype = '?bonus=hpb';
                                }
                            }
                            
                            var getRedirectUrl = $("#select-deposit-logo option:selected").data('url');

                            url = getRedirectUrl + bonustype;
                            console.log(url);

                            $("#limited").attr('action',url);
                            $("#limited").attr('method','POST');

                            $('#amount1').val(amount);



// check is bouns active ?
                            var bonusAtive=0;
                            if($(".lastRadiobutton").is(':checked'))
                            {
                                if($("#lastBox").is(':checked'))
                                {
                                    bonusAtive=1;
                                }
                            }
                            if($("#btcCheck").is(':checked')){
                                bonusAtive=1;
                            }

                            if(bonusAtive==0)
                            {
                                $("#financetable tr").each(function(){
                                    if($(this).find('.radio_class').is(':checked'))
                                    {
                                        if($(this).find('.ckbox_class').is(':checked'))
                                        {
                                            bonusAtive=1;
                                        }

                                    }
                                });
                            }
                            $('#bounusfiled').val(bonusAtive);

                            
           

                            // $('#limited').submit();
                            var base_url = "<?=FXPP::ajax_url('deposit/limitedBonusValidation')?>";
                            
                    if(bonustype!="")
                    {    
                            $.post(base_url,{amount:amount},function(data){
                                console.log(data);
                                if(data.Error){

                                    $("#errorMsg").text(data.ErrorMsg);
                                    $("#MyModal").modal('show');
                                }else{
                                     $('#limited').submit();
                                }
                            },"json")
                    }
                    else
                    {
                        $('#limited').submit();
                    }
                      
                            
          });


                        $(document).on('click', '#submit_bonus2', function(){

                            var amount1 = '';
                            var amount = '';


                            val = $("#select-deposit-logo2").val();



                            if($('.radio_id').attr('id') != ''){
                                amount1 = $('.radio_id').attr('id');
                            }

                            $("#financetable tbody tr").each(function(){
                                if($(this).find('.radio_class').is(':checked'))
                                {
                                    $('.radio_id').removeAttr('id');
                                    amount1 = $(this).find('.radio_class').attr('value');
                                }
                            });


                            if(amount1 == undefined ){
                                if(amount2 == ''){
                                    amount = $("#set_amount2").val();
                                }else{
                                    amount = amount2;
                                    console.log('this 2 amount ');
                                }

                            }else{
                                amount = amount1;
                            }

                            if(val == 'idr'){
                                url="<?= FXPP::loc_url('deposit/bank-transfer-idr'); ?>";
                            }
                            if(val == 'myr'){
                                url="<?= FXPP::loc_url('deposit/bank-transfer-myr'); ?>";
                            }
                            if(val == 'bt'){
                                url="<?= FXPP::loc_url('deposit/bank-transfer'); ?>";
                            }
                            if(val == 'ddcc'){
                                url="<?= FXPP::loc_url('deposit/debit-credit-cards'); ?>";
                            }
                            if(val == 'skl'){
                                url="<?= FXPP::loc_url('deposit/skrill'); ?>";
                            }
                            if(val == 'ntl'){
                                url="<?= FXPP::loc_url('deposit/neteller'); ?>";
                            }
                            if(val == 'pxm'){
                                url="<?= FXPP::loc_url('deposit/paxum'); ?>";
                            }
                            if(val == 'ppl'){
                                url="<?= FXPP::loc_url('deposit/paypal'); ?>";
                            }
                            if(val == 'web'){
                                url="<?= FXPP::loc_url('deposit/webmoney'); ?>";
                            }
                            if(val == 'pco'){
                                url="<?= FXPP::loc_url('deposit/payco'); ?>";
                            }
                            if(val == 'qwi'){
                                url="<?= FXPP::loc_url('deposit/qiwi'); ?>";
                            }
                            if(val == 'mgt'){
                                url="<?= FXPP::loc_url('deposit/megatransfer'); ?>";
                            }
                            if(val == 'btc'){
                                url="<?= FXPP::loc_url('deposit/bitcoin'); ?>";
                                amount = '0';
                            }
                            if(val == 'ynx'){
                                url="<?= FXPP::loc_url('deposit/yandex'); ?>";
                            }
                            if(val == 'mtr'){
                                url="<?= FXPP::loc_url('deposit/moneta'); ?>";
                            }
                            if(val == 'sft'){
                                url="<?= FXPP::loc_url('deposit/sofort'); ?>";
                            }
                            if(val == 'hwt'){
                                url="<?= FXPP::loc_url('deposit/hipay'); ?>";
                            }
<!--                            if(val == 'pmts'){-->
<!--                                url="--><?//= FXPP::loc_url('deposit/payments'); ?><!--";-->
<!--                            }-->
<!--                            if(val == 'pmil'){-->
<!--                                url="--><?//= FXPP::loc_url('deposit/paymill'); ?><!--";-->
<!--                            }-->

                            $("#limited").attr('action',url);
                            $("#limited").attr('method','POST');

                            $('#amount1').val(amount);
                            console.log('val = ');
                            console.log(val);
                            console.log('url = ');
                            console.log(url);
                            console.log('amount = ');
                            console.log(amount);

                           // $('#limited').submit();
                            var base_url = "<?=FXPP::ajax_url('deposit/limitedBonusValidation')?>";

                            $.post(base_url,{amount:amount},function(data){
                                console.log(data);
                                if(data.Error){
                                    alert(data.ErrorMsg);
                                }else{
                                   // $('#limited').submit();
                                }
                            },"json")

                            console.log('submit');
                        });




                    </script>

                    <form action="" id="limited" method="">
                        <input type="hidden" id="amount1" name="amount1">
                        <input type="hidden" id="bounusfiled" name="bounusfiled">
                    </form>

                    <form action="" id="limited2" method="">
                        <input type="hidden" id="amount3" name="amount3">
                    </form>

                    <div class="finance-payment-methods finance-payment-methods-first col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label><?=lang('PaymentMethods');?></label>
                        <select class="form-control" id="select-deposit-logo">
                            <option value="ddcc" data-url="deposit/debit-credit-cards"><?=lang('DepositCredit');?></option>
                            <?php if(IPLoc::for_id_only() || IPLoc::Office()){ ?>
                                <option value="idr" data-url="deposit/bank-transfer-idr"><?=lang('idr');?></option>
                            <?php } ?>

                            <?php if(IPLoc::for_my_only() || IPLoc::Office()){ ?>
                                <option value="myr" data-url="deposit/bank-transfer-myr"><?=lang('myr');?></option>
                            <?php } ?>

                            <option value="bt" data-url="deposit/bank-transfer"><?= lang('bt');?></option>
                            <option value="skl" data-url="deposit/skrill"><?= lang('dsk_desc');?></option>
                            <option value="ntl" data-url="deposit/neteller"><?= lang('dn_desc');?></option>
                            <option value="pxm" data-url="deposit/paxum"><?= lang('dpx_desc');?></option>
                            <option value="ppl" data-url="deposit/paypal"><?= lang('ppl');?></option>
                            <option value="web" data-url="deposit/webmoney"><?= lang('web');?></option>
                            <option value="pco" data-url="deposit/payco"><?= lang('pco');?></option>
                            <option value="qwi" data-url="deposit/qiwi"><?= lang('qwi');?></option>
                            <option value="mgt" data-url="deposit/megatransfer"><?= lang('mgt');?></option>
                            <option value="btc" data-url="deposit/bitcoin"><?= lang('btc');?></option>
                            <option value="ynx" data-url="deposit/yandex"><?= lang('ynx');?></option>
                            <option value="mtr" data-url="deposit/moneta"><?= lang('mtr');?></option>
                            <option value="sft" data-url="deposit/sofort"><?= lang('sft');?></option>
                            <option value="cup" data-url="deposit/chinaUnionPay">Deposit China Union Pay</option>
                            <!--            <option value="hwt">Deposit HiPay Wallet</option>-->
                            <!--            <option value="pmts">Deposit Payments</option>-->
                            <!--            <option value="pmil">Deposit Paymill</option>-->
                        </select>
                    </div>
                    <div class="finance-image-rep col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <img id="idr" src="<?= $this->template->Images()?>/indcard.png" class="img-responsive imgclslogo"/>
                        <img id="myr" src="<?= $this->template->Images()?>/myrcard.png" class="img-responsive imgclslogo"/>
                        <img id="bt" src="<?= $this->template->Images()?>/banktransfer.png" class="img-responsive imgclslogo"/>
                        <img id="ddcc" src="<?= $this->template->Images()?>/ccard.png" class="img-responsive imgclslogo imgclsdtl"/>
                        <img id="skl" src="<?= $this->template->Images()?>/skrill.png" class="img-responsive imgclslogo"/>
                        <img id="ntl" src="<?= $this->template->Images()?>/neteller.png" class="img-responsive imgclslogo"/>
                        <img id="pxm" src="<?= $this->template->Images()?>/paxum.png" class="img-responsive imgclslogo"/>
                        <img id="ppl" src="<?= $this->template->Images()?>/paypal.png" class="img-responsive imgclslogo"/>
                        <img id="web" src="<?= $this->template->Images()?>/webmoney.png" class="img-responsive imgclslogo"/>
                        <img id="pco" src="<?= $this->template->Images()?>/payco.png" class="img-responsive imgclslogo"/>
                        <img id="qwi" src="<?= $this->template->Images()?>/qiwilogo.png" class="img-responsive imgclslogo"/>
                        <img id="mgt" src="<?= $this->template->Images()?>/megatransfer.png" class="img-responsive imgclslogo"/>
                        <img id="btc" src="<?= $this->template->Images()?>/bitcoinlogo.png" class="img-responsive imgclslogo"/>
                        <img id="ynx" src="<?= $this->template->Images()?>/yandex.png" class="img-responsive imgclslogo"/>
                        <img id="mtr" src="<?= $this->template->Images()?>/moneta.png" class="img-responsive imgclslogo"/>
                        <img id="sft" src="<?= $this->template->Images()?>/sofortlogo.png" class="img-responsive imgclslogo"/>
                        <img id="hwt" src="<?= $this->template->Images()?>/hipaywalletlogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmts" src="<?= $this->template->Images()?>/epaymentslogo.png" class="img-responsive imgclslogo"/>
                        <img id="pmil" src="<?= $this->template->Images()?>/paymilllogo.png" class="img-responsive imgclslogo"/>
                        <img id="cup" src="<?= $this->template->Images()?>/chinaUnionPay.png" class="img-responsive imgclslogo"/>
                    </div>
                    <div class="finance-description col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p id="idr" class="pDescription"><?= lang('idr_desc');?></p>
                        <p id="myr" class="pDescription"><?= lang('myr_desc');?></p>
                        <p id="bt" class="pDescription"><?= lang('BankTransfer_desc');?></p>
                        <p id="ddcc" class="pDescription defaultDes"><?= lang('Visa_desc');?></p>
                        <p id="skl" class="pDescription"> <?= lang('Skrill_desc');?></p>
                        <p id="ntl" class="pDescription"> <?= lang('Neteller_desc');?></p>
                        <p id="pxm" class="pDescription"> <?= lang('Paxum_desc');?></p>
                        <p id="ppl" class="pDescription"> <?= lang('paypal_desc');?></p>
                        <p id="web" class="pDescription"> <?= lang('Payments_desc');?></p>
                        <p id="pco" class="pDescription"> <?= lang('PayCo_desc');?></p>
                        <p id="qwi" class="pDescription"> <?= lang('PayCo_desc');?></p>
                        <p id="mgt" class="pDescription"> <?= lang('MegaTransfer_desc');?></p>
                        <p id="btc" class="pDescription"> <?= lang('Bitcoin_desc');?></p>
                        <p id="ynx" class="pDescription"> <?= lang('YandexMoney_desc');?></p>
                        <p id="mtr" class="pDescription"> <?= lang('Moneta_desc');?></p>
                        <p id="sft" class="pDescription"> <?= lang('Sofort_desc');?></p>
                        <p id="hwt" class="pDescription"> <?= lang('HipayWallet_desc');?></p>
                        <p id="pmts" class="pDescription"><?= lang('Payments_desc');?></p>
                        <p id="pmil" class="pDescription"><?= lang('Paymill_desc');?></p>
                        <p id="cup" class="pDescription"><?= lang('cup_desc');?></p>
                    </div>
                </div>

                <div class="hidden-finance-dep-local paymentforidr">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 local-bank-content">
                        <div class="checkbox chk-bitcoin">
                            <label>
                                <input type="checkbox" class="chk" id="btcCheck" style="margin-top: 10px;" checked>
                                <img src="<?= $this->template->Images()?>/100-percent-bonus.png" id="img-active"/>
                                <img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" style="display:none" id="img-inactive"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 local-bank-content">
                        <p style="margin-top: 12px;"><?= lang('opportunity_hundred');?></p>
                    </div>

                    <div class="finance-total-amount finance-local-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <button type="submit" id="submit_bonus"><?= lang('Proceed');?></button>
                    </div>
                </div>

                <script type="text/javascript">

                    $(document).ready(function(){
                        //$(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
                    });

                    function percent_calculation(value){
                         if (value>2000) {
                              var result = parseInt(value)*50/100;

                        }else{
                             var result = parseInt(value)*100/100;
                        }
                       return result;
                    }

                    var radio_click_val;
                    //console.log(radio_click_val +' : click value');

                    $(document).on('click', '.radio_class', function(){
                        $(".btn_class_disable").removeAttr('disabled');
                        $('.radio_class').removeAttr('id');

                        var value = $(this).val();
                        var pct = percent_calculation(value);
                        var radio_id = parseFloat(parseFloat(value)+parseFloat(pct));
                        var text = $(this).closest('tr').find('td').eq(3).text();
                        var re = text.replace('$ ','');
                        // var radio_id = $(text).contains('$').remove();​
                        $(this).attr('id',re);

                        console.log('total value : '+re);
                    });




                    $(document).on("click",'.ckbox_class',function(){

                        $(this).closest('tr').find('.radio_class').removeAttr('id');
                        //console.log("test");
                        var val = $(this).closest('tr').find('.radio_class').val();
                        var currencysign = '<?=$currency2;?>';
                        // var currencysign = document.createElement("i");
                        // currencysign.val('<?=$currency2;?>');
                            if(val > 2000){
                                if($(this).is(':checked')){
                                    $(this).closest('tr').find('.img-responsive').hide();
                                    $(this).closest('tr').find('td').eq(3).html(currencysign + parseInt(parseInt(val)+percent_calculation(val)));
                                    $(this).after('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive show-img"/>');
                                    var ckval = parseInt(parseInt(val)+ percent_calculation(val));
                                    $(this).closest('tr').find('.radio_class').attr('id',ckval);
                                    //radio_click_val = parseInt(parseInt(val)+ percent_calculation(val));
                                }else{
                                    $(this).closest('tr').find('.img-responsive').hide();
                                    $(this).closest('tr').find('td').eq(3).html(currencysign + parseInt( val ));
                                    $(this).after('<img src="<?= $this->template->Images()?>/50-percent-bonus-inactive.png" class="img-responsive show-img"/>');
                                    var ckval = parseInt(val);
                                    $(this).closest('tr').find('.radio_class').attr('id',ckval);
                                }
                            }
                            else
                            {
                                if($(this).is(':checked')){
                                    $(this).closest('tr').find('.img-responsive').hide();
                                    $(this).closest('tr').find('td').eq(3).html(currencysign + parseInt(parseInt(val)+percent_calculation(val)));
                                    $(this).after('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive show-img"/>');
                                    var ckval = parseInt(parseInt(val)+ percent_calculation(val));
                                    $(this).closest('tr').find('.radio_class').attr('id',ckval);
                                    //radio_click_val = parseInt(parseInt(val)+ percent_calculation(val));
                                }else{
                                    $(this).closest('tr').find('.img-responsive').hide();
                                    $(this).closest('tr').find('td').eq(3).html(currencysign + parseInt( val ));
                                    $(this).after('<img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" class="img-responsive show-img"/>');
                                    var ckval = parseInt(val);
                                    $(this).closest('tr').find('.radio_class').attr('id',ckval);
                                }
                            }
                    });

                    $(document).on('click', '.other_ckbox', function(){
                        // if($(this).is(':checked')){
                        //     $(".img-other").hide();
                        //     $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other"/>');
                        // } else {
                        //     $(".img-other").hide();
                        //     $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/100-percent-bonus-inactive.png" class="img-responsive img-other"/>');
                        // }

                        var value = $('#amount').val();
                        if($(this).is(':checked')){
                             if(value > 2000){
                             $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>50-percent-bonus.png');
                            }
                            else
                            {
                                $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>100-percent-bonus.png');
                            }
                        } else {
                            if(value > 2000){
                             $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>50-percent-bonus-inactive.png');
                            }
                            else
                            {
                                $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>100-percent-bonus-inactive.png');
                            }
                          
                        }
                    });


                    $(document).on('click', '.other_ckbox2', function(){
                        // if($(this).is(':checked')){
                        //     $(".img-other2").hide();
                        //     $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                        //     var value = $("#set_amount2").val();
                        //     console.log(value);
                        //     var parcent = percent_calculation(value);
                        //     var total = parseFloat(parseFloat(value)+parseFloat(parcent));
                        //     $("#amount2").val(total);
                        // } else {
                        //     $("#amount2").val($("#set_amount2").val());
                        //     $(".img-other2").hide();
                        //     $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                        // }

                        
                        if($(this).is(':checked')){
                            var value = $('#set_amount2').val();
                            if(value > 2000){
                               // $(".img-other2").attr('src', '<?= $this->template->Images()?>50-percent-bonus.png');
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }
                            else
                            {
                                // $(".img-other2").attr('src', '<?= $this->template->Images()?>100-percent-bonus.png');
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }
                            var parcent = percent_calculation(value);
                            var total = parseFloat(parseFloat(value)+parseFloat(parcent));
                            $("#amount2").val(total);
                        } else {
                            var value = $('#set_amount2').val();
                            if(value > 2000){
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/50-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }
                            else
                            {
                                $(".img-other2").hide();
                                $("#img_show_percent2").append('<img src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                            }

                            $("#amount2").val(value);
                            // $(".img-other2").hide();
                            // $(".img-other2").append('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive img-other2" style="display: inline-block;"/>');
                          
                        }
                    });


                    $(document).on('change', '.radio_class', function(){
                        if($(".radio_id").is(':checked')){
                            $("#amount").removeAttr('disabled');
                        }
                        else{
                            $("#amount").attr('disabled', 'disabled');
                        }
                    });

                    $(document).on('click', '.radio_id', function(){
                        $('.btn_class_disable').attr('disabled', 'disabled');
                    });



                    $(document).on("keyup","#amount",function(){

                        var value = $(this).val();
                        if(value.length > 0.001){
                            $('.btn_class_disable').removeAttr('disabled');
                        }
                        else
                        {
                            $('.btn_class_disable').attr('disabled', 'disabled');
                        }

                        if(value > 2000){
                             $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>50-percent-bonus.png');
                        }
                        else
                        {
                            $("#img_show_percent_img").attr('src', '<?= $this->template->Images()?>100-percent-bonus.png');
                        }



                        var parcent = percent_calculation(value);
                        var total = parseFloat(parseFloat(value)+parseFloat(parcent));

                        if(isNaN(parseInt(value))){
                            $("#set_amount").val('');
                        }else{
                            if($('.other_ckbox').is(':checked')){
                                $("#set_amount").val(total);
                                $(".radio_id").attr('id', value);
                            }
                            else{
                                $("#set_amount").val(value);
                                $(".radio_id").attr('id', value);
                            }
                        }
                    });


                    $(document).ready(function(){
                        $("#amount").keydown(function (e) {
                            // Allow: backspace, delete, tab, escape, enter and .
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                    // Allow: Ctrl+A, Command+A
                                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });

                        $(document).on('click', '.other_ckbox', function(){
                            if($(this).is(':checked')){
                                var value = $("#amount").val();
                                var parcent = percent_calculation(value);
                                var total = parseFloat(parseFloat(value)+parseFloat(parcent));
                                $("#set_amount").val(total);
                                $(".radio_id").attr('id', total);
                            }
                            else{
                                var value = $("#amount").val();

                                $("#set_amount").val(value);
                                $(".radio_id").attr('id', value);
                            }
                        });
                    });

                </script>

                <div class="finance-deposit-second-container fdsc">
                    <div class="finance-dep-table-parent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="finance-dep-table">
                            <table id="financetable">
                                <thead>
                                <th></th>
                                <th><?= lang('DepositAmount');?></th>
                                <th>Bonus</th>
                                <th><?= lang('YouGet');?></th>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($depositAmount as $value) {
                                    if ($value>2000) {
                                            $get = $value*50/100;
                                            $bonus = '<td><div class="checking-bonus"><input type="checkbox" class="ckbox_class" checked=""><img src="https://my.forexmart.com/assets/images/50-percent-bonus.png" class="img-responsive show-img"></div></td>';
                                    }else{
                                            $get = $value*100/100;
                                            $bonus = '<td><div class="checking-bonus"><input type="checkbox" class="ckbox_class" checked=""><img src="https://my.forexmart.com/assets/images/100-percent-bonus.png" class="img-responsive show-img"></div></td>';
                                    }
                                    $get = $value+$get;
                                    // echo number_format($value);
                                    echo "<tr>";
                                    echo '<td><input value=" ' . $value . ' "  name="bonus_deposit_amount" type="radio" class="radio_class"/></td>';
                                    echo "<td>".$currency." ".number_format($value)."</td>";
                                    echo $bonus;
                                    echo '<td id="currencysign">'.$currency.' '.'<span class="get">'.number_format($get).'</span></td>';
                                    echo "</tr>";
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="finance-total-amount-left">
                            <input name="bonus_deposit_amount" type="radio" class="radio_class radio_id lastRadiobutton" />
                        </div>
                        <div class="finance-total-amount-right">
                            <label><?= lang('OtherAmount');?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><?=$currency;?></div>
                                <input class="form-control" id="amount" name="amount" type="text" placeholder="Amount" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="finance-total-sub-amount">
                            <div class="finance-total-amount-left-child">
                                <input type="checkbox" id="lastBox" class="other_ckbox" checked/>
                            </div>
                            <div class="finance-total-amount-right-child" id="img_show_percent">
                                <img id="img_show_percent_img" src="<?= $this->template->Images()?>/100-percent-bonus.png" class="img-responsive img-other">
                            </div>
                        </div>
                    </div>
                    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label><?= lang('YouGet');?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><?=$currency;?></div>
                            <input class="form-control" id="set_amount" name="amount" type="text" disabled="disabled" />
                        </div>
                        <button type="submit" class="btn_class_disable" id="submit_bonus"><?= lang('Proceed');?></button>
                    </div>

                    <div class="regulatory-note col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <a href="javascript:;"><?= lang('All_deposits');?></a>
                    </div>
                </div>

                <!-- START HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-finance-deposit-container">
                    <div class="finance-deposit-holder">
                        <div class="finance-image-rep2 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <img id="idr"  src="<?= $this->template->Images()?>/indcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="myr"  src="<?= $this->template->Images()?>/myrcard.png"          class="img-responsive imgclslogo2 "/>
                            <img id="bt"   src="<?= $this->template->Images()?>/banktransfer.png"     class="img-responsive imgclslogo2 "/>
                            <img id="ddcc" src="<?= $this->template->Images()?>/ccard.png"            class="img-responsive imgclslogo2  imgclsdtl"/>
                            <img id="skl"  src="<?= $this->template->Images()?>/skrill.png"           class="img-responsive imgclslogo2 "/>
                            <img id="ntl"  src="<?= $this->template->Images()?>/neteller.png"         class="img-responsive imgclslogo2 "/>
                            <img id="pxm"  src="<?= $this->template->Images()?>/paxum.png"            class="img-responsive imgclslogo2 "/>
                            <img id="ppl"  src="<?= $this->template->Images()?>/paypal.png"           class="img-responsive imgclslogo2 "/>
                            <img id="web"  src="<?= $this->template->Images()?>/webmoney.png"         class="img-responsive imgclslogo2 "/>
                            <img id="pco"  src="<?= $this->template->Images()?>/payco.png"            class="img-responsive imgclslogo2 "/>
                            <img id="qwi"  src="<?= $this->template->Images()?>/qiwilogo.png"         class="img-responsive imgclslogo2 "/>
                            <img id="mgt"  src="<?= $this->template->Images()?>/megatransfer.png"     class="img-responsive imgclslogo2 "/>
                            <img id="btc"  src="<?= $this->template->Images()?>/bitcoinlogo.png"      class="img-responsive imgclslogo2 "/>
                            <img id="ynx"  src="<?= $this->template->Images()?>/yandex.png"           class="img-responsive imgclslogo2 " />
                            <img id="mtr"  src="<?= $this->template->Images()?>/moneta.png"           class="img-responsive imgclslogo2 "/>
                            <img id="sft"  src="<?= $this->template->Images()?>/sofortlogo.png"       class="img-responsive imgclslogo2 "/>
                            <img id="hwt"  src="<?= $this->template->Images()?>/hipaywalletlogo.png"  class="img-responsive imgclslogo2 "/>
                            <img id="pmts" src="<?= $this->template->Images()?>/epaymentslogo.png"    class="img-responsive imgclslogo2 "/>
                            <img id="pmil" src="<?= $this->template->Images()?>/paymilllogo.png"      class="img-responsive imgclslogo2 "/>
                            <img id="cup" src="<?= $this->template->Images()?>/chinaUnionPay.png"      class="img-responsive imgclslogo2 "/>
                        </div>
                        <div class="finance-description2 col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p id="idr"  class="pDescription2"><?= lang('idr_desc');?></p>
                            <p id="myr"  class="pDescription2"><?= lang('myr_desc');?></p>
                            <p id="bt"   class="pDescription2"><?= lang('BankTransfer_desc');?></p>
                            <p id="ddcc" class="pDescription2 defaultDes2"><?= lang('Visa_desc');?></p>
                            <p id="skl"  class="pDescription2"> <?= lang('Skrill_desc');?></p>
                            <p id="ntl"  class="pDescription2"> <?= lang('Neteller_desc');?></p>
                            <p id="pxm"  class="pDescription2"> <?= lang('Paxum_desc');?></p>
                            <p id="ppl"  class="pDescription2"> <?= lang('paypal_desc');?></p>
                            <p id="web"  class="pDescription2"> <?= lang('Payments_desc');?></p>
                            <p id="pco"  class="pDescription2"> <?= lang('PayCo_desc');?></p>
                            <p id="qwi"  class="pDescription2"> <?= lang('PayCo_desc');?></p>
                            <p id="mgt"  class="pDescription2"> <?= lang('MegaTransfer_desc');?></p>
                            <p id="btc"  class="pDescription2"> <?= lang('Bitcoin_desc');?></p>
                            <p id="ynx"  class="pDescription2"> <?= lang('YandexMoney_desc');?></p>
                            <p id="mtr"  class="pDescription2"> <?= lang('Moneta_desc');?></p>
                            <p id="sft"  class="pDescription2"> <?= lang('Sofort_desc');?></p>
                            <p id="hwt"  class="pDescription2"> <?= lang('HipayWallet_desc');?></p>
                            <p id="pmts" class="pDescription2"><?= lang('Payments_desc');?></p>
                            <p id="pmil" class="pDescription2"><?= lang('Paymill_desc');?></p>
                            <p id="cup" class="pDescription2"><?= lang('cup_desc');?></p>
                        </div>


                        <div class="parent-fin-dep-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                <label><?=lang('PaymentMethods');?></label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">

                                <select class="form-control" id="select-deposit-logo2">
                                    <option value="ddcc"><?=lang('DepositCredit');?></option>
                                    <?php if(IPLoc::for_id_only() || IPLoc::Office()){ ?>
                                        <option value="idr"><?=lang('idr');?></option>
                                    <?php } ?>

                                    <?php if(IPLoc::for_my_only() || IPLoc::Office()){ ?>
                                        <option value="myr"><?=lang('myr');?></option>
                                    <?php } ?>
                                    <option value="bt">  <?=lang('bt');?></option>
                                    <option value="skl"> <?=lang('skl');?></option>
                                    <option value="ntl"> <?=lang('ntl');?></option>
                                    <option value="pxm"> <?=lang('pxm');?></option>
                                    <option value="ppl"> <?=lang('ppl');?></option>
                                    <option value="web"> <?=lang('web');?></option>
                                    <option value="pco"> <?=lang('pco');?></option>
                                    <option value="qwi"> <?=lang('qwi');?></option>
                                    <option value="mgt"> <?=lang('mgt');?></option>
                                    <option value="btc"> <?=lang('btc');?></option>
                                    <option value="ynx"> <?=lang('ynx');?></option>
                                    <option value="mtr"> <?=lang('mtr');?></option>
                                    <option value="sft"> <?=lang('sft');?></option>
                                    <option value="cup">Deposit China Union Pay</option>
                                </select>
                            </div>
                        </div>
                        <div class="fdsc">
                            <div class="parent-fin-dep-content">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <label><?=lang('chose_amount');?></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <select class="form-control" id="financetable">

                                <?php  asort($depositAmount);

                                        foreach ($depositAmount as $value) {


                                            $get = $value*30/100;
                                            $get = $value+$get;


                                            echo '<option value=" ' . $value . ' " >'.$value.'</option>';
                                        }

                                        $cash = array_values($depositAmount)[0];
                                        $cash2 = $cash*30/100;
                                        $cash2 = $cash2+$cash; ?>
                                        <option value="OtherAmount"><?=lang('OtherAmount');?></option>
                                    </select>



                                </div>
                            </div>
                            <div class="parent-fin-dep-content">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 fin-dep-content-input2" id="img_show_percent2" style="    padding: 0;">
                                    <input type="checkbox" id="lastBox" class="other_ckbox2" style="display: inline-block;    vertical-align: middle;    margin: 0px;" checked/>
                                    <img src="<?= $this->template->Images()?>/100-percent-bonus.png"  class="img-responsive img-other2" style="display: inline-block;"">

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 fin-dep-content-input2" style="    padding: 5px 0;">
                                    <input type="text" class="form-control" id="set_amount2" name="set_amount2" value='10' disabled="disabled" style="border-radius: 0;    height: 40px;">
                                </div>
                            </div>
                            <div class="parent-fin-dep-content">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <label><?=lang('total');?></label>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                                    <input class="form-control" id="amount2" name="amount2" type="text" value='13' disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <div class="parent-fin-dep-content">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input-button">
                                <button type="submit" id="submit_bonus2"><?=lang('Proceed');?></button>
                            </div>
                        </div>


                        <a href="javascript:;"><?=lang('All_deposits');?></a>
                    </div>
                </div>
                <!-- END HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
            </div>

        </div>
    </div>





</div>
<?=$show_modal;?>

<!-- Modal -->
<div class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Limited deposit bonus</h4>
            </div>
            <div class="modal-body" id="errorMsg">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<style>
    #owl-demo .item{
        margin: 3px;
    }
    #owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }
</style>


<script>
    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            items : 4,
            lazyLoad : true,
            navigation : true
        });
    });
</script>


<style type="text/css">
    .new-dpst-widt-design{
        font-weight: bold !important;
    }
    .acc-num-holder
    {
        margin-bottom: 30px;
        margin-top: 30px;
    }
    .up-file-text
    {
        font-family: Open Sans;
        font-size: 14px;
        /*text-align: right;*/
    }
    .up-file-text span
    {
        color: #ff0000;
    }
    .up-file-step
    {
        font-family: Open Sans;
        font-size: 50px;
        font-weight: 600;
        color: #2988ca;
        margin-top: 0;
    }
    .step2-2
    {
    }
    .file-up-holder
    {
        padding: 15px;
    }
    .btn-uploadsave-holder
    {
        margin-top: 15px;
    }
    .btn-uploadsave
    {
        border: none;
        color: #fff;
        background: #2988ca;
        padding: 7px 40px;
        font-family: Open Sans;
        font-size: 14px;
        transition: all ease 0.3s;
    }
    .btn-uploadsave:hover
    {
        transition: all ease 0.3s;
        background: #319ae3;
    }
    .center-int-tab thead tr th, .anti-fraud-tab thead tr th
    {
        background: #bbb;
        color: #fff;
        border-bottom: none;
        text-align: center;
    }
    .center-int-tab
    {
        margin-bottom: 0!important;
    }
    .center-int-tab tbody tr td
    {
        text-align: center;
    }
    .center-int-tab tbody tr td a
    {
        margin-right: 10px;
    }
    .tab-pagination-holder
    {
        margin-top: 15px;
    }
    .hidden-tr
    {
        display: none;
    }
    .show-tr
    {
        display: table-row!important;
    }
    .no-referral
    {
        text-align: center;
    }
    footer
    {
        background: #fbfafa;
    }
    .btn-get-afflink
    {
        border-radius: 0px;
        background: #29a643;
        width: 200px;
        color: #fff;
    }
    .btn-get-afflink:hover
    {
        background: #50DF6E;
        transition: all ease 0.3s;
        color: #fff;
    }
    .afflink-holder
    {
        display: none;
    }
    .calculate-form-holder
    {
        margin-top: 30px;
    }
    .saldo
    {
        width: 10%;
        text-align: right;
    }
    .total-saldo
    {
        text-align: right;
        font-weight: 600;
    }
    .saldo-tab tbody tr td:last-child
    {
        text-align: right;
    }
    .border-right
    {
        border-right: 1px solid #ccc;
    }
    .separator-note
    {
        margin-top: 0!important;
        font-family: Open Sans;
        font-style: italic;
        font-size: 13px!important;
        font-weight: 400!important;
    }
    .btn-calculate
    {
        padding: 8px 15px;
        border: none;
        color: #fff;
        background: #29a643;
        width: 120px;
        transition: all ease 0.3s;
    }
    .btn-calculate:hover
    {
        background: #50DF6E;
        transition: all ease 0.3s;
    }
    .flag-drp-holder
    {
        display: none;
    }
    .col-search
    {
        padding-left: 0px;
    }
    .flag-img
    {
        margin-top: 5px;
    }
    .mob-flag-holder
    {
        float: right;
    }
    .frm-opendeal-holder
    {
        width: 100%;
    }
    .frm-opendeal-title h3
    {
        font-size: 17px;
        font-family: Georgia;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .m-top
    {
        margin-top: 10px;
    }
    .market-execution-type, .pending-order-type
    {
        display: none;
        padding: 10px;
        border: 1px solid #ddd;
        margin-top: 33px;
    }
    .market-execution-type h3, .pending-order-type h3
    {
        font-size: 17px;
        font-family: Georgia;
        margin: 0!important;
    }
    .type-active
    {
        display: block!important;
    }
    .market-execution-type p
    {
        text-align: center;
        margin-top: 15px;
        font-size: 35px;
        font-family: Open Sans;
        margin-bottom: 15px;
    }
    .market-execution-type p span small
    {
        font-size: 20px;
    }
    .btn-market-sell
    {
        font-family: Open Sans;
        font-size: 14px;
        padding: 7px;
        border: 1px solid #ff0000;
        background: #fff;
        color: #ff0000;
        width: 100%;
        transition: all ease 0.3s;
    }
    .btn-market-sell:hover
    {
        background: #ff0000;
        color: #fff;
        transition: all ease 0.3s;
    }
    .btn-market-buy
    {
        font-family: Open Sans;
        font-size: 14px;
        padding: 7px;
        border: 1px solid #2988ca;
        background: #fff;
        color: #2988ca;
        width: 100%;
    }
    .btn-market-buy:hover
    {
        background: #2988ca;
        color: #fff;
        transition: all ease 0.3s;
    }
    .btn-pend-place
    {
        margin-top: 3px;
    }
    .pend-note
    {
        margin-top: 10px;
        font-family: Open Sans;
        font-size: 13px;
    }
    .flag-img
    {
        width: 40px;
    }
    .btn-getbonus
    {
        background: #29a643;
        color: #fff;
        border: none;
        width: 200px;
        padding: 7px 10px;
        font-size: 17px;
        font-family: Open Sans;
        text-align: center;
    }
    .btn-getbonus:hover
    {
        color: #fff;
        text-decoration: none;
        background: #50DF6E;
        transition: all ease 0.3s;
    }
    /*new css 05-17-16*/
    .admin-email-tab
    {
        margin: 0;
        letter-spacing: none;
        margin-top: 15px!important;
        list-style: none;
        padding: 0;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }
    .admin-email-tab li
    {
        float: left;
    }
    .admin-email-tab li a
    {
        padding: 7px 15px;
        display: block;
        transition: all ease 0.3s;
        color: #333;
        font-family: Open Sans;
    }
    .admin-email-tab li a:focus, .admin-email-tab li a:hover
    {
        background: #2988ca;
        color: #fff;
        text-decoration: none;
        transition: all ease 0.3s;
    }
    .upload-email-form
    {
        margin-top: 20px;
    }
    .admin-email-active
    {
        background: #2988ca;
        color: #fff!important;
        text-decoration: none;
    }
    .set-form
    {
        margin-right: 50px;
    }
    .card-row
    {
        width: 100%;
    }
    .card-row .card-col
    {
        width: calc(100% / 5);
        padding-right: 10px;
        float: left;
    }
    .card-col a
    {
        transition: all ease 0.3s;
        opacity: 0.5;
    }
    .card-col a:hover
    {
        transition: all ease 0.3s;
        opacity: 1;
    }
    .card-text
    {
        font-family: Open Sans;
        margin-left: 4px;
        margin-top: 10px;
    }
    .card-text span
    {
        font-weight: 600;
        color: #2988ca;
    }
    .card-cont-text
    {
        color: #6a6a6a;
        margin-top: 20px;
    }
    .card-cont-holder
    {
        margin-left: 4px;
    }
    .card-cont-holder p
    {
        font-family: Open Sans;
        font-size: 14px;
        color: #6a6a6a;
    }
    .card-cont-holder p span
    {
        font-weight: 600;
        color: #2988ca;
    }
    /*** FXPP-2407 (start) ***/
    @media screen and (max-width: 991px) {
        .bankdep-text {
            margin: 20px 30% 10px;
        }
    }
    @media screen and (max-width: 990px) {
        .bankdep-text {
            margin: 20px 29% 10px;
        }
    }
    @media screen and (max-width: 500px) {
        .bankdep-text {
            margin: 20px 15% 10px;
        }
    }
    /*** FXPP-2407 (end) ***/

    .paypalimage{
        padding: 16px;
    }
    .card-row .card-col {
        width: calc(100% / 5);
        padding-right: 10px;
        float: left;
    }
    @media screen and (max-width: 767px) {
        .side-nav-holder .side-nav li a
        {
            border-left: none;
        }
        .int-logo
        {
            width: 250px;
            transition: all ease 0.3s;
        }
        .navbar-right-internal li a
        {
            padding-bottom: 10px!important;
            padding-top: 10px!important;
        }
        .flag-desk
        {
            display: none!important;
        }
        .flag-drp-holder
        {
            display: block;
        }
        .flag-drp
        {
            position: fixed!important;
            z-index: 9;
            left: 10px;
            top: 155px;
            width: 150px;
            float: right;
        }
        .int-logo
        {
            margin-left: 10px;
        }
        .btn-getbonus
        {
            margin-bottom: 15px;
        }
        .btn-acct-calc
        {
            margin-top: 10px;
        }
        .acct-sum-holder, .btn-text-holder
        {
            padding-right: 3px;
            padding-left: 3px;
        }
        .bonus-text
        {
            padding: 0px;
        }
    }
    @media screen and (max-width: 639px) {
        .card-col
        {
            padding-right: 3px!important;
        }
    }
    @media screen and (max-width: 405px) {
        .other-link li
        {
            float: none!important;
        }
        .other-link li a
        {
            padding-left: 0!important;
        }
    }
    @media screen and (max-width: 355px) {
        .btn-getbonus
        {
            width: 100%;
        }
    }

</style>
<script type="text/javascript">
    $('#btcCheck').click(function(){
        if($(this).is(':checked')){
            $('#img-active').css('display','block');
            $('#img-inactive').css('display','none');
        }else{
            $('#img-active').css('display','none');
            $('#img-inactive').css('display','block');
        }
    });
</script>