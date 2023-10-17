<style type="text/css">
    .btn-download {
        color: #fff;
        background: #29a643;
        border: none;
        padding: 7px 30px;
    }

    .bank-transfer-info {
        width: 100%;
        border: 1px solid #000;
    }

    .bank-transfer-info tr td{
        padding: 5px;
    }
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
</style>

<h1><?= lang('dbt_01') ?></h1>
<div class="row" id="bank-transfer-row">
    <div class="col-lg-9 col-centered">
        <input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
        <form class="form-horizontal" id="frmBankTransfer" style="margin-top: 50px;">
            <div class="form-group" style= "text-align: center;">
                <div class="col-sm-8 alert alert-danger" role="alert" id="amountErrorVal" style="margin-left:15%; display: none"></div>
            </div>

            <?php if($non_verified_notice){?>
                <div class="form-group" style= "text-align: center;">
                    <div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?=$non_verified_notice?></div>
                </div>
            <?php }else if($error_msg){ ?>
                <div class="form-group" style= "text-align: center;">
                    <!--<div class="col-sm-8 alert alert-danger" role="alert" style= "margin-left:15%;"><?/*=$error_msg*/?></div>-->
                    <?php if($error_msg){?>  <div class="col-sm-9 alert alert-danger" role="alert" style= "margin-left:12%;"><?=$error_msg?></div> <?php } ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('macv_02') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="currency" id="currency" value="<?php echo $account['currency'] ?>"/>
                    <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('ddcc_03') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="bank_amount" id="amount" class="form-control round-0 numeric depositamountcheck" value="<?=floatval($amount)?>" placeholder="<?= lang('ddcc_03') ?>"<?php echo $disabled ?>>
                     <span class="errorlineshow" style="color: red"> </span>
                </div>
               
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('dbt_02') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="bank_name" id="bankName" class="form-control round-0" placeholder="<?= lang('dbt_02') ?>"<?php echo $disabled ?>>
                </div>

            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('paypal_05') ?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control round-0" name="note" id="note" placeholder="<?= lang('paypal_05') ?>"<?php echo $disabled ?>>
                    <input type="hidden" name="bonus" value="<?= $_GET['bonus']?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button type="button" id="btnSendBankTransfer" class="btn-submit"<?php echo $disabled ?>><?= lang('paypal_04') ?></button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>
<h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i><?= lang('paypal_05') ?></h1>
<table class="notes-list">
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_">
            <p>
                <?= lang('dbt_03') ?>
            </p>
        </td>
    </tr>
    <tr class="cb">
        <td colspan="2">
            <p></p>
            <!--<table class="bank-transfer-info" border="0">
                <tr >
                    <td width="20%" style="text-transform: uppercase"><?/*= lang('dbt_04') */?>:</td>
                    <td style="font-weight: bold"><?/*=$account_name*/?></td>
                </tr>
                <tr>
                    <td width="20%" style="text-transform: uppercase"><?/*= lang('dbt_06') */?>:</td>
                    <td style="font-weight: bold"><?/*=$bank_address*/?></td>
                </tr>
                <tr>
                    <td width="20%"><?/*= lang('dbt_08') */?>:</td>
                    <td style="font-weight: bold"><?php /*echo $bank_iban */?></td>
                </tr>
                <tr>
                    <td width="20%" style="text-transform: uppercase"><?/*= lang('dbt_05') */?>:</td>
                    <td style="font-weight: bold"><?/*=$bank_name*/?></td>
                </tr>
                <?php /*if(!empty($bank_beneficiary_address)){ */?>
                    <tr>
                        <td width="20%">BENEFICIARY'S BANK ADDRESS:</td>
                        <td style="font-weight: bold"><?/*=$bank_beneficiary_address*/?></td>
                    </tr>
                <?php /*} */?>
                <tr>
                    <td width="20%"><?/*= lang('dbt_07') */?>:</td>
                    <td style="font-weight: bold"><?/*=$bank_swift*/?></td>
                </tr>
                <tr>
                    <td width="20%" style="text-transform: uppercase"><?/*= lang('fer_02') */?>:</td>
                    <td style="font-weight: bold"><?php /*echo $bank_account_number */?></td>
                </tr>

            </table>-->



            <table class="bank-transfer-info" border="0">


                <tr >
                    <td width="30%" style="text-transform: uppercase">Beneficiary’s bank account number (IBAN):</td>
                    <td style="font-weight: bold">CY08018000030000200100294532(EUR)<br>CY13018000030000201100306630(USD)<br>CY82018000030000201100306649(GBP)<br>CY42018000030000201100306690(AUD)</td>
                </tr>


                <tr >
                    <td width="20%" style="text-transform: uppercase">Beneficiary name:</td>
                    <td style="font-weight: bold">INSTANT TRADING EU LTD</td>
                </tr>
                <tr>
                    <td width="20%" style="text-transform: uppercase">Beneficiary address:</td>
                    <td style="font-weight: bold">23A Leda Court, Block B, Office B203, 4000 Mesa Geitonia, Limassol, Cyprus</td>
                </tr>
                <tr>
                    <td width="20%">Beneficiary’s Bank name:</td>
                    <td style="font-weight: bold">Eurobank Cyprus Ltd.</td>
                </tr>
                <tr>
                    <td width="20%" style="text-transform: uppercase">Beneficiary’s Bank address:</td>
                    <td style="font-weight: bold">6 SPYROU KYPRIANOU STREET, 4040 LIMASSOL</td>
                </tr>


                <tr>
                    <td width="20%" style="text-transform: uppercase">Beneficiary bank SWIFT:</td>
                    <td style="font-weight: bold">ERBKCY2N</td>
                </tr>


            </table>



            <br/>
            <p></p>
        </td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_"><p><?= lang('dbt_09') ?></p></td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_"><p><?= lang('dbt_10') ?></p></td>
    </tr>
    <tr class="cb">
        <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
        <td class="r_"><p><?= lang('dbt_11') ?> <!--50 USD / 50 EUR / 40 GBP / 5000 RUB. --></p></td>
    </tr>
</table>

<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<?php /** Preloader Modal End */ ?>
