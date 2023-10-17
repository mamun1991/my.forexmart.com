<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<style type="text/css">
    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }

    .select2-container{
        width:100%;
        height: auto;

    }
    .select2-container .select2-choice{
        border-radius: 0px!important;
        height: 32px!important;
    }
    .select2-container ,.select2-choice  ,.select2-arrow{
        border-radius: 0px!important;
    }
    .select2-drop-active{
        border-width: medium 2px 2px!important;
    }

    a.calculate:hover{
        color: #FFF;
        text-decoration: none;
    }
    a.calculate:link{
        color: #FFF;
        text-decoration: none;
    }
    a.calculate:visited{
        color: #FFF;
        text-decoration: none;
    }
    a.calculate:active{
        color: #FFF;
        text-decoration: none;
    }
    .iro{
        background-color: white!important;
    }

    .th{
        color: #353535;
        font-size: 11px;
    }
    .btn-calc-holder{
        text-align: center!important;
        margin: 3% 0;
    }
    .calc{
        margin-right: auto;
        margin-bottom: 0px;
        margin-left: auto;
        margin-top: 28px !important;
        display: block;
        right: 0px;
        left: 0px;
        text-align: center;
    }
</style>
    <h1>
        <?= lang('forcal_34'); ?>
    </h1>

    <?php $this->load->view('account_nav.php');?>

    <div class="tab-content acct-cont">
        <div role="tabpanel" class="row tab-pane active" >
            <div class="col-md-12">
                <div class="row calc-result-holder">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_00');?> :
                            </label>
                            <?= form_dropdown('CurrencyPair', $CurrencyPair, '', 'class="form-control round-0 calc-txt arabic-selection-form"'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_01');?> :
                            </label>
                            <?= form_dropdown('Leverage', $Leverage, '', 'class="form-control round-0 calc-txt arabic-selection-form"'); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_02');?> :
                            </label>
                            <?php $data['V'] = array(
                                'name'  => 'Volume',
                                'id'    => 'Volume',
                                'value' => '0.1',
                                'size'  => '50',
                                'class' => 'form-control round-0',
                                'max' => '100000000000',
                                'min' => '0.1',
                                'type' => 'number'
                            );
                            ?>
                            <?= form_input($data['V']); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_03');?> :
                            </label>
                            <?= form_dropdown('Currency', $Currency, '', 'class="form-control round-0 calc-txt arabic-selection-form"'); ?>
                        </div>
                    </div>
                </div>
                <div class="row calc-result-holder">
                    <div class="col-md-3 arabic-btn-calculate-button">
                        <div class="calc-btn-holder">
                            <a href="javascript:void(0)" class="calc btn-calc calculate" id="calc">
                                <?=lang('forcal_04');?>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_05');?>:
                            </label>
                            <span class="calc-result"><span name="CurrentQuote">&zwnj;</span></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="arabic-form-label">
                                <?=lang('forcal_06');?>:
                            </label>
                            <span class="calc-result"><span name="Valueof1PIP">&zwnj;</span></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">
                                <?=lang('forcal_07');?>:
                            </label>
                            <span class="calc-result"><span name="Margin">&zwnj;</span></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-12">
                        <div class="computation-holder">
                            <h1>
                                <?=lang('forcal_08');?>:
                            </h1>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="calc-val-pip arabic-calc-val-pip">
                                        <h2>
                                            <?=lang('forcal_09');?>
                                        </h2>

                                        <div class="content-calculator-example dtop " name="computations" style="display:none;">
                                            <p>
                                                <?=lang('forcal_10');?>
                                                <strong><span class="volume"></span></strong>
                                                <?=lang('forcal_11');?>
                                                <strong><span class="cur12"></span></strong>
                                                <?=lang('forcal_12');?>
                                                <strong><span class="cur3"></span></strong>

                                                </br>
                                                <?=lang('forcal_13');?> = 0.0001
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur12"></span>)</strong> = <strong><span class="CF12"></span></strong>
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur23"></span>)</strong> = <strong><span class="CF23"></span></strong>
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur13"></span>)</strong> = <strong><span class="CF13"></span></strong>
                                                </br><strong>
                                                    <?=lang('forcal_20');?>

                                                </strong> = <strong class="result"><span class="CF12"></span> <span class="cur12"></span></strong>
                                                </br>
                                                <?=lang('forcal_21');?>
                                                </br>
                                                <?=lang('forcal_01');?> = <strong><span class="leverage"></span></strong>
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = <span class="volume"></span>* 0.0001 * <span class="cur23"></span> * 100,000 <span class="RURJYPUSD1"></span></span>
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = <span class="volume"></span> * 0.0001 * <span class="CF23"></span> * 100,000 <span class="RURJYPUSD1"></span> = <span class="ValueofPIP"></span>
                                                </br>
                                                <?=lang('forcal_16');?>


                                                <strong class="result"><span class="ValueofPIP"></span> <span class="cur3"></span></strong>
                                            </p>

                                        </div>
                                        <div class="content-calculator-example dtop " name="SpotMetals" style="display:none;">
                                            <p>
                                                <?=lang('forcal_10');?>
                                                <strong><span class="volume"></span></strong>
                                                <?=lang('forcal_11');?>
                                                <strong><span class="cur12"></span></strong>
                                                <?=lang('forcal_12');?>
                                                <strong><span class="cur3"></span></strong>
                                                </br>
                                                <?=lang('forcal_13');?> = 0.0001
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur12"></span>)</strong> = <strong><span class="CF12"></span></strong>
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur23"></span>)</strong> = <strong><span class="CF23"></span></strong>
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur13"></span>)</strong> = <strong><span class="CF13"></span></strong>
                                                </br><strong>
                                                    <?=lang('forcal_20');?>
                                                </strong> = <strong class="result"><span class="CF12"></span> <span class="cur12"></span></strong>
                                                </br>
                                                <?=lang('forcal_21');?>
                                                </br><?=lang('forcal_01');?> = <strong><span class="leverage"></span></strong>
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = <span class="volume"></span> * 0.0001 * <span class="cur23"></span> * 100,000 * rate</span>
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = <span class="volume"></span> * 0.0001 * <span class="CF23"></span> * 100,000 = <span class="ValueofPIP"></span> * <span class="spotrate"></span></span>
                                                </br>
                                                <?=lang('forcal_16');?>
                                                <strong  class="result"><span class="ValueofPIP"></span> <span class="cur3"></span></strong>
                                            </p>
                                        </div>
                                        <div class="content-calculator-example dtop " name="CFD" style="display:none;">
                                            <p>
                                                <?=lang('forcal_10');?>
                                                <strong><span class="volume"></span></strong>
                                                <?=lang('forcal_11');?>
                                                <strong><span class="cur1"></span>/<span class="cur2"></span></strong>
                                                <?=lang('forcal_12');?>
                                                <strong><span class="cur3"></span></strong>
                                                </br>
                                                <?=lang('forcal_13');?> = 0.0001
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur1"></span>/<span class="cur2"></span>)</strong> = <strong><span class="CF12"></span></strong>
                                                </br>
                                                <?=lang('forcal_14');?>
                                                <strong>(<span class="cur2"></span>/<span class="cur3"></span>)</strong> = <strong><span class="CF23"></span></strong>

                                                </br><strong>
                                                    <?=lang('forcal_20');?>
                                                </strong> = <strong class="result"><span class="CF12"></span> <span class="cur12"></span></strong>
                                                </br>
                                                <?=lang('forcal_21');?>
                                                </br><?=lang('forcal_01');?> = <strong><span class="leverage"></span></strong>
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = 0.0001 * 100,000 * Volume(lots) * Exchange rate (<span class="cur2"></span>/<span class="cur3"></span>)
                                                </br><strong>
                                                    <?=lang('forcal_15');?>
                                                </strong> = 0.0001 * 100,000 *  <span class="volume"></span> ( <span class="CF23"></span> )=  <span class="ValueofPIP"></span>
                                                </br>
                                                <?=lang('forcal_16');?>
                                                <strong  class="result"><span class="ValueofPIP"></span></strong>

                                            </p>

                                        </div>


                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="calc-margin">
                                        <h2>
                                            <?=lang('forcal_18');?>
                                        </h2>


                                        <div class="content-calculator-example" name="computations" style="display:none;">
                                            <p>
                                                <strong>
                                                    <?=lang('forcal_19');?>
                                                </strong>

                                                = (<?=lang('curtra_06')?> * (<?=lang('forcal_26')?>/<?=lang('curtra_06')?>) )/<?=lang('forcal_01')?>  * <?=lang('forcal_14')?> (<?=lang('forcal_27')?>/<?=lang('forcal_28')?>)


                                                </br> <?=lang('forcal_19');?>= (<span class="volume"></span>*100,000)/<span class="leverage"></span> * <span class="CF13"></span> <span class="cur13"></span> = <span class="Margin"></span>
                                                </br>
                                                <?=lang('forcal_22');?>
                                                <strong  class="result"> <span class="Margin"></span> <span class="cur3"></span></strong>
                                            </p>
                                        </div>


                                        <div class="content-calculator-example" name="SpotMetals" style="display:none;">
                                            <p>
                                                <strong><?=lang('forcal_19');?></strong> = <?=lang('forcal_26')?> X <?=lang('forcal_33')?> * <?=lang('forcal_32')?>
                                                </br><?=lang('forcal_19');?> =  <span style="text-transform: lowercase">(<?=lang('curtra_06')?> * (<?=lang('forcal_26')?>/<?=lang('curtra_06')?>)) * <?=lang('forcal_14')?> (<?=lang('forcal_27')?>/<?=lang('forcal_28')?>)  * <?=lang('forcal_32')?></span>
                                                </br><?=lang('forcal_19');?> =  (0.0001 * <span class="volume"></span>*100,000) * <span class="CF13"></span> <span class="cur13"></span> * <span class="spotrate"></span> = <span class="Margin"></span>
                                                </br><?=lang('forcal_19');?>  is <strong class="result"><span class="Margin"></span> <span class="cur3"></span></strong>
                                            </p>
                                        </div>


                                        <div class="content-calculator-example"  name="CFD" style="display:none;">
                                            <p>
                                                <strong><?=lang('forcal_19');?></strong> = (10% PIP) * <span style="text-transform: lowercase">((<?=lang('curtra_06')?> * (<?=lang('forcal_26')?>/<?=lang('curtra_06')?>) )/<?=lang('forcal_01')?>) * <?=lang('forcal_14')?> (<?=lang('forcal_27')?>/<?=lang('forcal_28')?>)</span>
                                                </br><?=lang('forcal_19');?> = (0.10 * <span class="ValueofPIP"></span> ) * ( <span class="volume"></span> * 100000  )/ <span class="leverage"></span> *  <span class="CF12"></span>
                                                </br>
                                                <?=lang('forcal_22');?>
                                                <strong class="result"> <span class="Margin"></strong>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="calc-example-holder">
                            <h1>
                                <?=lang('forcal_23');?>
                            </h1>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="calc-pip-example">
                                        <h2>
                                            <?=lang('forcal_24');?>
                                        </h2>
                                        <p class="ex-text"><?=lang('forcal_25');?> = 1 pip * <span style="text-transform: lowercase"><?=lang('forcal_14')?> (<?=lang('forcal_29') . ' ' . lang('ddcc_02')?>/ <?=lang('forcal_28')?>) * <?=lang('forcal_26')?></span></p>
                                        <p class="ex-text"><?=lang('forcal_23');?>:</p>
                                        <p class="ex-text">
                                            <?=lang('forcal_15');?>
                                            1 <?=lang('forcal_11')?> EUR/USD
                                            <?=lang('forcal_12');?>
                                            GBP <br> <?=lang('forcal_13')?> = 0.0001 </p>
                                        <p class="ex-text">
                                            <?=lang('forcal_14');?>
                                            (USD/GBP) = 0.6548 <br> 1 <?=lang('forcal_30')?> = 100 000</p>
                                        <p class="ex-text"><?=lang('forcal_25');?> = 0.0001 * 0.6548 * 100000 = 6.548 <br> <?=lang('forcal_16')?> &#163;6.55</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="calc-pip-example">
                                        <h2>
                                        <?=lang('forcal_18');?>
                                        </h2>
                                        <p class="ex-text"><?=lang('forcal_19');?> = <span style="text-transform: lowercase"><?=lang('forcal_26')?>/<?=lang('forcal_17')?> * <?=lang('forcal_14')?> (<?=lang('forcal_27')?> / <?=lang('forcal_28')?>)</span></p>
                                        <p class="ex-text"><?=lang('forcal_23');?>:</p>
                                        <p class="ex-text">
                                            <?=lang('forcal_15');?>
                                            1 <?=lang('forcal_11')?> EUR/USD <?=lang('forcal_31')?> <br> 1 <?=lang('forcal_30')?> = 100 000</p>
                                        <p class="ex-text">
                                            <?=lang('forcal_14');?>
                                            (EUR/GBP) = 0.7369
                                            <br> <?=lang('forcal_01');?> = 200
                                        </p>
                                        <p class="ex-text"><?=lang('forcal_19');?> = 100000 / 200 * 0.7369 = 368.45 <br>
                                            <?=lang('forcal_22');?>
                                            &#163;368.45</p>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>


            </div>


        </div>
    </div>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>
<div class="row">
    <?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>

</div>
<script>
    var site_url="<?=FXPP::ajax_url('')?>";
    var img_url="<?=$this->template->Images()?>";

    var pblc = [];
    pblc['request'] = null;
    var prvt = [];
    var conversionfactor = false;
    var SpotMetals = ["XAGUSD", "XAUUSD", "XXAU/USD" ];
    var spotrate;
    var cur1;
    var cur3;
    var Leverage;
    var Volume;

    $().ready(function(){
        $('select[name=CurrencyPair]').select2({
            matcher: function(term, text, option) {
                return text.toUpperCase().indexOf(term.toUpperCase())>=0 || option.val().toUpperCase().indexOf(term.toUpperCase())>=0;
            }
        });

        $('select[name=Leverage]').select2({});
        $('select[name=Currency]').select2({});

        $("select[name=CurrencyPair]").change(function() {


            $('select[name=Leverage]').prop("disabled", false);
            $('select[name=Leverage]').val('1:1');
            $('select[name=Leverage]').select2();

            var CFD = ['#AA','#AAL','#AAPL','#AIG','#AMZN','#AXP','#BA','#BABA','#BAC','#BARC','#BLT','#BP','#BTA','#C','#CAT','#CSCO','#CVX','#DD','#DIS','#EBAY', '#FB', '#GEN', '#GOOG', '#GS', '#GSK', '#HD', '#HPQ', '#HSBA', '#IBM', '#INTC', '#JNJ', '#JPM', '#KO', '#LLOY', '#LNKD', '#MCD', '#MMM', '#MRK', '#MSFT','#ORCL','#PFE','#PG','#T','#TRV','#TSCO','#TWTR','#UTX','#VOD','#VZ','#WFC','#WMT','#XOM','#YHOO'];

            var RUR = ['USDRUB','USDRUR'];

            if($.inArray(this.value,RUR) == -1){

            }else{
                $('select[name=Leverage]').select2('destroy');
                $('select[name=Leverage]').val('1:50');
                $('select[name=Leverage]').prop("disabled", true);
                $('select[name=Leverage]').select2();
            }

            if($.inArray(this.value,SpotMetals) == -1){

            }else{
                $('select[name=Leverage]').select2('destroy');
                $('select[name=Leverage]').val('1:100');
                $('select[name=Leverage]').prop("disabled", true);
                $('select[name=Leverage]').select2();
            }

            if($.inArray(this.value,CFD) == -1){

            }else{

                $('select[name=Leverage]').select2('destroy');
                $('select[name=Leverage]').val('1:20');
                $('select[name=Leverage]').prop("disabled", true);
                $('select[name=Leverage]').select2();
            }

         });

    });


    $(document).on("click", ".calculate", function () {
        $('#loader-holder').show();
        var split = $('select[name=CurrencyPair] option:selected').text().split('/');
        var CurrencySelected = $('select[name=Currency] option:selected').val();
        var newstring = $('select[name=CurrencyPair] option:selected').val();
        var splitname = $('select[name=CurrencyPair] option:selected').html().split('/');
        var parts = newstring.match(/[\s\S]{1,3}/g) || [];
        var Leverage = $('select[name=Leverage] option:selected').val().split(':');
        var Volume = $('input[name=Volume]').val();

        if(newstring.indexOf('#') != -1){
            parts[0]=split[0];
        }
        if(newstring.indexOf('/') != -1){
            parts[0]=split[0];
            parts[1]=split[1];
        }

        prvt["data"] = {
            cur1: parts[0],
            cur2: parts[1],
            cur3: CurrencySelected,
            cur1name: splitname[0],
            cur2name: splitname[1],

            leverage: Leverage[1],
            volume: Volume
        };
        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'accounts/API_CurrencyPairSpotCFD',
            method: 'POST',
            data: prvt["data"]
        });

        pblc['request'].done(function( data ) {

            if (data.isCFD){
                //cfd
                $('div[name=legends]').css('display','block');
                $('div[name=SpotMetals]').css('display','none');
                $('div[name=computations]').css('display','none');
                $('div[name=CFD]').css('display','block');

                $('span[name=CurrentQuote]').html(data.CurrentQuote);
                $('span[name=Valueof1PIP]').html(data.PIPValue);
                $('span[name=Margin]').html(data.Margin);

                $('.cur1').html(cur1=parts[0]);
                $('.cur2').html('USD');
                $('.cur3').html(cur3=CurrencySelected);

                $('.CF12').html(data.CurrentQuote);
                $('.CF23').html(data.CF23);

                $('.leverage').html(Leverage[1]);
                $('.ValueofPIP').html(data.PIPValue);
                $('.volume').html(Volume);
                $('.Margin').html(data.Margin);
            }else{

                var spots = $('select[name=CurrencyPair] option:selected').val();
                conversionfactor = data.value;

                $('span[name=CurrentQuote]').html(data.CurrentQuote);
                $('span[name=Valueof1PIP]').html(data.PIPValue);
                $('span[name=Margin]').html(data.Margin);
                $('.Margin').html(data.Margin);

                $('.cur23').html(parts[1] +'/'+ CurrencySelected); // 23
                $('.cur12').html(parts[0] +'/'+ parts[1]); // 12
                $('.cur2').html(parts[0] +'/'+ parts[1]); // 12
                $('.cur13').html(parts[0]+'/'+ CurrencySelected); // 13
                $('.cur3').html(CurrencySelected); //3

                $('span[name=CQ]').html(data.CurrentQuote);
                $('span[name=CF23]').html(data.CF23);

                $('.volume').html(Volume);
                $('.ValueofPIP').html(data.PIPValue);
                $('.CF12').html(data.CF12);
                $('.CF23').html(data.CF23);
                $('.CF13').html(data.CF13);
                $('span[class=leverage]').html(Leverage[1]);
                $('span[name=MarginC]').html(data.Margin);

                if($.inArray(spots,SpotMetals) == -1){
                    // currency pair
                    if(splitname[1]=='RUR' || splitname[1]=='RUB'){
                        $('.RURJYPUSD1').html('* 10 ');
                    }else if( parts[0]=="USD" && parts[1]=="JPY" ){
                        $('.RURJYPUSD1').html('* 100 ');
                    }else{
                        $('.RURJYPUSD1').html('');
                    }

                    $('div[name=legends]').css('display','block');
                    $('div[name=computations]').css('display','block');
                    $('div[name=SpotMetals]').css('display','none');
                    $('div[name=CFD]').css('display','none');

                }else{
                    //spotmetals
                    if(spots=='XXAU/USD'){
                        spotrate= '5';
                    }else if(spots=='XAGUSD'){
                        spotrate= '1/2';
                    }else{
                        spotrate= '1';
                    }
                    $('.spotrate').html(spotrate);
                    $('div[name=legends]').css('display','block');
                    $('div[name=SpotMetals]').css('display','block');
                    $('div[name=computations]').css('display','none');
                    $('div[name=CFD]').css('display','none');
                }
            }
        });

        pblc['request'].fail(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });

        pblc['request'].always(function( jqXHR, textStatus ) {
            $('#loader-holder').hide();
        });
    });

</script>