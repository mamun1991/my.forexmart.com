<style type="text/css">
    .bitcoin-address-text {
        width: 50% !important;
        cursor: default !important;
    }
</style>
<input type="hidden" id="base_url" value="<?php echo FXPP::ajax_url() ?>" />
<h1 class=""><?= lang('dbit_00') ?></h1>
<?php /* <p class="bitcoin-text"><?= lang('dbit_01') ?></p> */ ?>
<div class="form-group">
    <?php /*
    <input type="text" class="form-control round-0 bitcoin-address-text" readonly placeholder="" value="<?php echo $payment_address ?>">
    <button type="button" class="btn-generate" id="btnGenerateAddress"><?= lang('dbit_02') ?></button>
 */ ?>
</div>
<div class="row">
    <div class="col-lg-10 col-centered">
        <form class="form-horizontal" id="frmBitcoin" method="POST">
            <?php
            $disabled = "";
            if($error_msg && !$count_status){
                $disabled = "disabled"
                ?>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <?=$error_msg?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>bitcoinlogo.png" class="img-reponsive bitcoin-logo" width="350px"/>
            </div>
            <?php
            $result = $this->session->flashdata("result");
            if(isset($result)) {
                if ($result['success']) {
                    ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo $result['message'] ?>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $result['message'] ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('dbit_03') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="hidden" name="currency" id="currency" value="<?php echo $account['currency'] ?>"/>
                    <input type="text" name="account_currency" id="account_currency" class="form-control round-0" value="<?php echo $account['currency_new'] . ' - ' . $account['account_number'] . ' [' . number_format($account['amount'],2) . ']' ?>" placeholder="" disabled/>
                    <span class="req" id="bitcoin_currency"><?php echo  form_error('currency')?></span>
                </div>
            </div>
            <?php /*
            <div class="form-group">
                <label class="col-sm-5 control-label"><?= lang('dbit_04') ?><cite class="req">*</cite></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control round-0" name="amount" placeholder="0.00">
                    <span class="req" id="bitcoin_amount"><?php echo  form_error('amount')?></span>
                </div>
            </div>
            */ ?>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('dbit_05') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="address" id="txtPaymentAddress" class="form-control round-0"  value="<?php echo ($bitcoin_address->bitcoin_address !='') ? $bitcoin_address->bitcoin_address:'' ?>" >
                    <span class="req" id="bitcoin_address"><?php echo  form_error('address')?></span>
                </div>
                <div class="col-sm-4" id="generate-address-holder">
                    <button type="button" class="btn-generate" id="btnGenerateAddress" style="background-color: <?php echo ($bitcoin_address->bitcoin_address !='') ? '#eaeaea':'' ?>" <?php echo ($bitcoin_address->bitcoin_address !='') ? 'disabled="disabled"':'' ?> ><?= lang('dbit_02') ?></button>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('dbit_06') ?><cite class="req">*</cite></label>
                <div class="col-sm-5">
                    <input type="text" name="transaction_id" class="form-control round-0">
                    <span class="req" id="bitcoin_transaction_id"><?php echo  form_error('transaction_id')?></span>
                </div>
<!--             <div  class=""><i style="top: 10px;color: red;" class="tooltip-trans-id glyphicon glyphicon-question-sign"></i></div>-->
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <button type="button" class="btn-submit" id="btnBitcoinSubmit">Submit</button>
                </div><div class="clearfix"></div>
            </div>
        </form>
    </div>

</div>

      <div class="row" style="margin-top: 50px">
          <div class="col-lg-1 col-centered"> </div>
          <div class="col-lg-10 col-centered">
              <h1 class="imp-notes"><i class="fa fa-edit" style="color: #777; margin-right: 15px; font-size: 30px;"></i>
                  <?=lang('n_21');?>
              </h1>
              <table class="notes-list" style="margin-bottom: 150px;">
                  <tr class="cb">
                      <td class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                      <td  class="r_">
                          <p>
                              ForexMart Bitoin Address is generated only once.
                          </p>
                      </td>
                  </tr>
                  <tr class="cb">
                      <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                      <td  class="r_">
                          <p>
                              Transfer is made within BTC wallet.
                          </p>
                      </td>
                  </tr>
                  <tr class="cb">
                      <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                      <td  class="r_">
                          <p>
                              Please wait for about 6 confirmations in your Bitcoin wallet. After which, enter the hash number in Bitcoin Deposit form of ForexMart.
                          </p>
                      </td>
                  </tr>
                  <tr class="cb">
                      <td  class="l_"><i class="fa fa-chevron-right" style="color: #29a643; margin-right: 20px; vertical-align: top;"></i></td>
                      <td  class="r_">
                          <p>
                              Your <strong>Bitcoin wallet</strong> is different from the <strong>Transaction ID.</strong>
                          </p>
                      </td>
                  </tr>
              </table>

          </div>

          <div class="col-lg-1 col-centered"> </div>
      </div>




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