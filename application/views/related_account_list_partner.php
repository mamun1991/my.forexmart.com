<?php

if (count($accounts2) > 0) {
            foreach ($accounts2 as $account) {  
                
                
                
                ?>
            <tr>
                <td>
                    <div class="dropdown" rel="etst_2" >
                        <span class="on-disabled" onclick="closedScore(<?php echo $account['account_number'] ?>)">
                          <button type="button" class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown disabled" aria-haspopup="true"
                                aria-expanded="false"
                                style="color: #555151;" disabled>
                                <?php echo $account['account_number'] ?>
                            <!-- <span class="caret"></span> -->
                          </button>
                        </span>
          							<!-- <div id="score<?php // echo $account['account_number'] ?>" class="score-div score-hide hidden" onclick="removeScore(<?php // echo $account['account_number'] ?>)">
          								Closed Score
          							</div> -->
                        <ul class="dropdown-menu multi-level" role="menu"
                            aria-labelledby="dropdownMenu">
                            <li class="dropdown-submenu"><a href="#">
                                    <?= lang('mya_04'); ?><!--<?= lang('trd_232');?>--></a>
                                <ul class="dropdown-menu">
                                    <?php if (IPLoc::WhitelistPIPCandCC()) { ?>
                                    <?php } ?>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"><?= lang('mya_06'); ?><!--Debit/Credit Cards--></a></li>
                                    <?php if (IPLoc::WhitelistPIPCandCC()) { ?>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"><?= lang('mya_07'); ?><!--China UnionPay--></a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/skrill') ?>"><?= lang('mya_08'); ?><!--Skrill--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/neteller') ?>"><?= lang('mya_09'); ?><!--Neteller--></a></li>
                                    <?php if (IPLoc::WhitelistPIPCandCC()) { ?>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/webmoney') ?>"><?= lang('mya_10'); ?><!--WebMoney--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/paxum') ?>"><?= lang('mya_11'); ?><!--Paxum--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/ukash') ?>"><?= lang('mya_12'); ?><!--Ukash--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/payco') ?>"><?= lang('mya_13'); ?><!--PayCo--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/filspay') ?>"><?= lang('mya_14'); ?><!--FilsPay--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/cashu') ?>"><?= lang('mya_15'); ?><!--CashU--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/hipay') ?>"><?= lang('mya_16'); ?><!--Hipay Wallet--></a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo FXPP::loc_url('deposit/paypal') ?>"><?= lang('mya_17'); ?><!--PayPal--></a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#"><?= lang('mya_18'); ?><!--Withdraw Funds--></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/bank-transfer') ?>"><?= lang('mya_05'); ?><!--Bank Transfer--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/debit-credit-cards') ?>"><?= lang('mya_06'); ?><!--Debit/Credit Cards--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/unionpay') ?>"><?= lang('mya_07'); ?><!--China UnionPay--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/skrill') ?>"><?= lang('mya_08'); ?><!--Skrill--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/neteller') ?>"><?= lang('mya_09'); ?><!--Neteller--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/webmoney') ?>"><?= lang('mya_10'); ?><!--WebMoney--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/paxum') ?>"><?= lang('mya_11'); ?><!--Paxum--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/ukash') ?>"><?= lang('mya_12'); ?><!--Ukash--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/payco') ?>"><?= lang('mya_13'); ?><!--PayCo--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/filspay') ?>"><?= lang('mya_14'); ?><!--FilsPay--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/cashu') ?>"><?= lang('mya_15'); ?><!--CashU--></a></li>
                                    <li><a href="<?php echo FXPP::loc_url('withdraw/paypal') ?>"><?= lang('mya_17'); ?><!--PayPal--></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <span class="clearfix"></span>
                </td>
             <td style="display: none"></td>
            <td><?= $account['mt_currency_base'] == 'RUB' ? 'RUR' : $account['mt_currency_base']; ?></td>
            <td class="balance"><?=  $account['amount']== '' ? 0 : $account['amount']; ?></td><!--<td>Read Only</td>-->
            
           
                <td class="partner_td_total_commision">
                    <?= number_format(FXPP::getTotalCommissionFromAllReferralsAccounts($account['account_number']), 2); ?>
                                  
                </td>
                           
                            
            
            <td>
                <?=$account['veri_status'] ?>
            </td>
                
                
            
              <td class="actionBtnMyAcc">



                    <?php if(isset($_SESSION['first_login']) && $_SESSION['first_login'] ){?>
                    <a class="btn btn-primary" href="<?php echo FXPP::loc_url('partner/signin');?>" style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;white-space:normal!important;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                        <?= lang('mya_32'); ?>
                    </a>
                    <?php }else{?>

                            <?= form_open(FXPP::loc_url('client/switch-account-partner'), '', ''); ?>
                            <input type="hidden"  name="username" value="<?= $account['account_number'] ?>">
                            <button class="switchBtn" type="submit"
                                    style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                                <?= lang('mya_32'); ?>
                            </button>
                            <?php echo form_close() ?>


                    <?php }?>


                </td>
                
                 
            </tr>
                <?php
            }
        } ?>
