<?php $this->load->lang('deposit_lang') ?>


<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="<?= $this->template->Css()?>newdepositdefault/finance-style.css" rel="stylesheet">
<link href="<?= $this->template->Css()?>newdepositdefault/finance-style-v2.css" rel="stylesheet">


<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    $(document).ready(function(){
        $(".int-side-collapse").click(function(){
            $(".dl-holder").slideToggle("fast");
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

    .imgclslogo{
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
<!--	<div role="tabpanel" class="tab-pane active" id="tab1">-->
<!--		--><?//=$show_deposit;?>
<!--	</div>-->


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
            $(".imgclsdtl").show();
            $(".fdsc").show();
            $(".paymentforidr").hide();
            $("#submit_bonus").removeAttr("disabled");
            $(".paymentforidr").css('border-top', '1px solid #eaeaea');
            $(".paymentforidr").css('padding-top', '20px');
            $("option[value='ddcc']").attr('selected','selected');

            $(".pDescription").hide();
            $(".defaultDes").show();

            $("input:radio").attr("checked", false);
            $(".btn_class_disable").attr("disabled","disabled");
            $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');

        });

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
                $("#amount").val('');
                $("#amount").attr("disabled","disabled");
                $("#set_amount").val('');
                $(".show-img").hide();
                $(".img-other").hide();

                $(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
            }
        });

        $(document).on('click', '#submit_bonus', function(){
            var val = $("#select-deposit-logo").val();



            var amount="";

            if($('.radio_id').attr('id') != ''){
                amount = $('.radio_id').attr('id');
            }

            $("#financetable tbody tr").each(function(){
               if($(this).find('.radio_class').is(':checked'))
               {
                   $('.radio_id').removeAttr('id');
                   amount = $(this).find('.radio_class').attr('value');
               }
            });
            var url = '';

            // amount = amount.replace(",", "");

            if(val == 'idr'){
                // $(location).attr('href','<?=FXPP::loc_url('');?>');
                url="<?= FXPP::loc_url('deposit/bank-transfer-idr'); ?>";
            }
            if(val == 'myr'){
                // $(location).attr('href','<?=FXPP::loc_url('deposit/bank-transfer-myr');?>');
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
             url="<?= FXPP::loc_url('deposit/megaTransfer'); ?>";
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
<!--            if(val == 'pmts'){-->
<!--             url="--><?//= FXPP::loc_url('deposit/payments'); ?><!--";-->
<!--            }-->
<!--            if(val == 'pmil'){-->
<!--             url="--><?//= FXPP::loc_url('deposit/paymill'); ?><!--";-->
<!--            }-->

            $("#limited").attr('action',url);
            $("#limited").attr('method','POST');

            $('#amount1').val(amount);
            console.log(url);
            console.log(amount);
            $('#limited').submit();
        });

    </script>

    <form action="" id="limited" method="">
        <input type="hidden" id="amount1" name="amount1">
    </form>


    <div class="finance-payment-methods finance-payment-methods-first col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label><?= lang('trd_20'); ?>:</label>
        <select class="form-control" id="select-deposit-logo">
            <option value="ddcc"><?= lang('ddc_desc');?></option>
            <?php if(IPLoc::for_id_only() || IPLoc::Office()){ ?>
                   <option value="idr"><?= lang('idr');?></option>
            <?php } ?>

            <?php if(IPLoc::for_my_only() || IPLoc::Office()){ ?>
                <option value="myr"><?= lang('myr');?></option>
            <?php } ?>

            <option value="bt"><?= lang('bt');?></option>
            <option value="skl"><?= lang('dsk_desc');?></option>
            <option value="ntl"><?= lang('dn_desc');?></option>
            <option value="pxm"><?= lang('dpx_desc');?></option>
            <option value="ppl"><?= lang('ppl');?></option>
            <option value="web"><?= lang('web');?></option>
            <option value="pco"><?= lang('pco');?></option>
            <option value="qwi"><?= lang('qwi');?></option>
            <option value="mgt"><?= lang('mgt');?></option>
            <option value="btc"><?= lang('btc');?></option>
            <option value="ynx"><?= lang('ynx');?></option>
            <option value="mtr"><?= lang('mtr');?></option>
            <option value="sft"><?= lang('sft');?></option>
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
        <img id="mgt" src="<?= $this->template->Images()?>/megatransferlogo.png" class="img-responsive imgclslogo"/>
        <img id="btc" src="<?= $this->template->Images()?>/bitcoinlogo.png" class="img-responsive imgclslogo"/>
        <img id="ynx" src="<?= $this->template->Images()?>/yandexmoneylogo.png" class="img-responsive imgclslogo"/>
        <img id="mtr" src="<?= $this->template->Images()?>/moneta.png" class="img-responsive imgclslogo"/>
        <img id="sft" src="<?= $this->template->Images()?>/sofortlogo.png" class="img-responsive imgclslogo"/>
        <img id="hwt" src="<?= $this->template->Images()?>/hipaywalletlogo.png" class="img-responsive imgclslogo"/>
        <img id="pmts" src="<?= $this->template->Images()?>/epaymentslogo.png" class="img-responsive imgclslogo"/>
        <img id="pmil" src="<?= $this->template->Images()?>/paymilllogo.png" class="img-responsive imgclslogo"/>
    </div>
    <div class="finance-description col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <p id="idr" class="pDescription">Sekarang anda bisa mendepositokan dana ke akun ForexMart melalui bank lokal dengan mudah. Kami menerima transfer bank lokal dari seluruh bank terbesar di Indonesia.</p>
        <p id="myr" class="pDescription">It is now easy to deposit funds to your ForexMart account through local bank. We accept local bank transfers from all biggest banks in Malaysia.</p>
        <p id="bt" class="pDescription">Transfer money from your bank account to ours directly. As you deposit in your local currency, the receiving bank will convert the funds to your preferred currency. </p>
        <p id="ddcc" class="pDescription defaultDes">Entrust your funds with one of the world's leading online payments. Deposit money to your tradingaccount using your Visa credit/debit card. </p>
        <p id="skl" class="pDescription">Skrill (Moneybookers) enables you to transfer funds to your trading account and receive money via email. </p>
        <p id="ntl" class="pDescription">Being an independent money transfer business, Neteller offers a quick, easy method of depositing or withdrawing into your trading account. </p>
        <p id="pxm" class="pDescription">Paxum offers a fast, efficient, and affordable payment solution to deposit or withdraw money with ease.</p>
        <p id="ppl" class="pDescription">Paypal is the faster, safer way to send money, make an online payment, receive money or set up a merchant account. </p>
        <p id="web" class="pDescription">WebMoney is a global e-wallet providing an avenue for making deposits or withdrawals into your trading account. </p>
        <p id="pco" class="pDescription">PayCo, having the lowest transaction fee worldwide, provides the most flexible, safest way of transferring and receiving money online, and paying bills. </p>
        <p id="qwi" class="pDescription">Buy online and offline, pay bills and translate money to close at any time. </p>
        <p id="mgt" class="pDescription">MegaTransfer is a worldwide, online payment that is efficient, convenient, and innovative. </p>
        <p id="btc" class="pDescription">Bitcoin is an innovative payment network and a new kind of money. Bitcoin uses peer-to-peer technology to operate with no central authority or banks. </p>
        <p id="ynx" class="pDescription">More than just a wallet. Yandex.Money is a simple service providing online payments. Pay for home utilities, transfer money to your relatives, or buy goods at online stores. </p>
        <p id="mtr" class="pDescription">MONETA.Assistant interface is an application for processing online payments via various payment methods. </p>
        <p id="sft" class="pDescription"><?=lang('de_sf_01');?>
        <p id="hwt" class="pDescription">HiPay wallet is the e-wallet solution of Hi-Media Payments and allows your online shop users a convenient, fast and secure payment. </p>
        <p id="pmts" class="pDescription">WebMoney is a global e-wallet providing an avenue for making deposits or withdrawals into your trading account. </p>
        <p id="pmil" class="pDescription">PAYMILL offers you an online payment service, which makes the transactions in your online shop easy. </p>
    </div>
</div>

<div class="hidden-finance-dep-local paymentforidr">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 local-bank-content">
    <label>
        <input type="checkbox" class="chk" id="btcCheck">
        <img src="<?= $this->template->Images()?>/30-percent-bonus.png"/>
    </label>
        
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 local-bank-content">
        <p>Have the opportunity to get 30% of the total amount of money deposited to your account.</p>
    </div>

    <div class="finance-total-amount finance-local-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <button type="submit" id="submit_bonus">Proceed to Payment</button>
    </div>
</div>

<script type="text/javascript">

        $(document).ready(function(){
            //$(".ckbox_class").after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
        });

        function percent_calculation(value){
            var result = parseInt(value)*30/100;
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

            if($(this).is(':checked')){
                $(this).closest('tr').find('.img-responsive').hide();
                $(this).closest('tr').find('td').eq(3).text('$ '+parseInt(parseInt(val)+ percent_calculation(val)));
                $(this).after('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive show-img"/>');
                var ckval = parseInt(parseInt(val)+ percent_calculation(val));
                $(this).closest('tr').find('.radio_class').attr('id',ckval);

                //radio_click_val = parseInt(parseInt(val)+ percent_calculation(val));

            }else{
                $(this).closest('tr').find('.img-responsive').hide();
                $(this).closest('tr').find('td').eq(3).text('$ '+parseInt(val));
                $(this).after('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive show-img"/>');
                var ckval = parseInt(val);
                $(this).closest('tr').find('.radio_class').attr('id',ckval);

                //radio_click_val = parseInt(val);

                //console.log(parseInt(val));
            }
        });

        $(document).on('click', '.other_ckbox', function(){
            if($(this).is(':checked')){
                $(".img-other").hide();
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other"/>');
            } else {
                $(".img-other").hide();
                $("#img_show_percent").append('<img src="<?= $this->template->Images()?>/30-percent-bonus-inactive.png" class="img-responsive img-other"/>');
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
            if(value.length > 0){
                $('.btn_class_disable').removeAttr('disabled');
            }
            else
            {
                $('.btn_class_disable').attr('disabled', 'disabled');
            }

            var parcent = percent_calculation(value);
            var total = parseFloat(parseFloat(value)+parseFloat(parcent));

            if(isNaN(parseInt(value))){
                $("#set_amount").val('');
            }
            else{
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
                <th>Deposit Amount</th>
                <th>30% Bonus</th>
                <th>You get</th>
                </thead>
                <tbody>
                <tr>
                    <td><input value="10000"  name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 10,000</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ <span class="get">13,000</span></td>
                </tr>
                <tr>
                    <td><input value="5000" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 5,000</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 6,500</td>
                </tr>
                <tr>
                    <td><input value="3000" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 3,000</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 3,900</td>
                </tr>
                <tr>
                    <td><input value="1000" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 1,000</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 1,300</td>
                </tr>
                <tr>
                    <td><input value="500" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 500</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 650</td>
                </tr>
                <tr>
                    <td><input value="250" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 250</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 325</td>
                </tr>
                <tr>
                    <td><input value="100" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 100</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 130</td>
                </tr>
                <tr>
                    <td><input value="50" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 50</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 65</td>
                </tr>
                <tr>
                    <td><input value="30" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 30</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 39</td>
                </tr>
                <tr>
                    <td><input value="20" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 20</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 26</td>
                </tr>
                <tr>
                    <td><input value="10" name="bonus_deposit_amount" type="radio" class="radio_class"/></td>
                    <td>$ 10</td>
                    <td>
                        <div class="checking-bonus">
                            <input type="checkbox" class="ckbox_class" checked/>

                        </div>
                    </td>
                    <td>$ 13</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="finance-total-amount-left">
            <input name="bonus_deposit_amount" type="radio" class="radio_class radio_id"/>
        </div>
        <div class="finance-total-amount-right">
            <label>Other Amount</label>
            <div class="input-group">
                <div class="input-group-addon">$</div>
                <input class="form-control" id="amount" name="amount" type="text" placeholder="Amount" disabled="disabled" />
            </div>
        </div>
    </div>
    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="finance-total-sub-amount">
            <div class="finance-total-amount-left-child">
                <input type="checkbox" class="other_ckbox" checked/>
            </div>
            <div class="finance-total-amount-right-child" id="img_show_percent">
                <img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive img-other">
            </div>
        </div>
    </div>
    <div class="finance-total-amount col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <label>You Get</label>
        <div class="input-group">
            <div class="input-group-addon">$</div>
            <input class="form-control" id="set_amount" name="amount" type="text" disabled="disabled" />
        </div>
        <button type="submit" class="btn_class_disable" id="submit_bonus">Proceed to Payment</button>
    </div>
    <div class="regulatory-note col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <a href="javascript:;">All deposits are being made to EU-regulated and licensed company Tradomart Ltd, CySEC license number 266/15</a>
    </div>
</div>

<!-- START HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 main-finance-deposit-container">
    <div class="finance-deposit-holder">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 fin-dep-content">
            <img src="<?= $this->template->Images()?>/indcard.png" class="img-responsive">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 fin-dep-content">
            <p>It is now easy to deposit funds to your ForexMart account through local bank. We accept local bank transfers from all biggest banks in Malaysia.</p>
        </div>
        <form>
            <div class="parent-fin-dep-content">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <label><?= lang('trd_20'); ?></label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <select class="form-control">
                        <option><?= lang('idr');?></option>
                        <option><?= lang('myr');?></option>
                        <option><?= lang('bt');?></option>
                        <option><?= lang('ddc_desc');?></option>
                        <option><?= lang('dsk_desc');?></option>
                        <option><?= lang('dn_desc');?></option>
                        <option><?= lang('dpx_desc');?></option>
                        <option><?= lang('ppl');?></option>
                        <option><?= lang('web');?></option>
                        <option><?= lang('pco');?></option>
                        <option><?= lang('qwi');?></option>
                        <option><?= lang('mgt');?></option>
                        <option><?= lang('btc');?></option>
                        <option><?= lang('ynx');?></option>
                        <option><?= lang('mtr');?></option>
                        <option><?= lang('sft');?></option>
                        <option>Deposit HiPay Wallet</option>
                        <option>Deposit Payments</option>
                        <option>Deposit Paymill</option>
                    </select>
                </div>
            </div>
            <div class="parent-fin-dep-content">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <label>Choose an amount</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <select type="text" class="form-control">
                        <option>$10</option>
                        <option>$20</option>
                        <option>$30</option>
                        <option>$50</option>
                        <option>$100</option>
                        <option>$250</option>
                        <option>$500</option>
                        <option>$1,000</option>
                        <option>$3,000</option>
                        <option>$5,000</option>
                        <option>$10,000</option>
                    </select>
                </div>
            </div>
            <div class="parent-fin-dep-content">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <img src="<?= $this->template->Images()?>/30-percent-bonus.png" class="img-responsive">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <input type="text" class="form-control" value="$3" disabled="">
                </div>
            </div>
            <div class="parent-fin-dep-content">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <label>Total</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input">
                    <input type="text" class="form-control" value="$13" disabled="">
                </div>
            </div>
            <div class="parent-fin-dep-content">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 fin-dep-content-input-button">
                    <button type="submit">Proceed to Payment</button>
                </div>
            </div>
        </form>

        <a href="javascript:;">All deposits are being made to EU-regulated and licensed company Tradomart Ltd, CySEC license number 266/15</a>
    </div>
</div>
<!-- END HIDDEN CONTAINER (SHOW WHEN IN MOBILE VERSION) -->
</div>

</div>
</div>





</div>
<?=$show_modal;?>


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