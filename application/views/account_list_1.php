
<?php

if (count($accounts2) > 0) {
            foreach ($accounts2 as $account) {  ?>
            <tr>
                <td>
                    <div class="dropdown" rel="etst_1" >
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
                <td><span id="txt_leverage"><?php echo $account['leverage'] ?></span>
                    <?php
                    if($show_fx_bonus['is_showfxbonus']==1 && IPLoc::Office()){

                    } elseif ($users['nodepositbonus'] == 0 OR $user_profiles['country'] == 'PL') { ?>
                        <a id="edit_leverage"><!-- <i class="fa fa-pencil edit-lev"></i> --></a>
                        <select id="select_leverage" class="form-control round-0" style="display: none;"><?php echo $leverage ?></select>
                        <?php } ?>
                </td>
                <td><?php echo $account['mt_currency_base'] ?></td>
                <td class="balance1"><?php echo $account['amount']; ?></td>
                <?php if($account['inactive']==1){
                    $stat_inactive = "Inactive";
                    $color = 'color:red';
                }else{
                    $stat_inactive = ((!isset($account['mt_status']) || trim($account['mt_status']) === '')) ? lang('mya_26') : lang('mya_27');
                    $color = '';
                } ?>
                <td>
                    <?php if ($account['veri_status']=='Verified' OR $account['veri_status']=="Проверено"){?>
                        <div class="tooltip_z">
                            <img src="<?= $this->template->Images()?>my_account/Icon2.svg" alt="" width="25" height="30">
                            <span class="tooltiptext_z"><?=lang('verified_text');?></span>
                        </div>
                    <?php }else if(empty($account['veri_status'])){?>
                        <div></div>
                    <?php }else{?>
                        <div class="tooltip_z">
                            <img src="<?= $this->template->Images()?>my_account/icon1.svg" alt="" width="25" height="30">
                            <span class="tooltiptext_z"><?=lang('non_verified_text');?></span>
                        </div>
                    <?php }?>
                </td>
                <td id="live-client-status1" style="<?=$color;?>"><?= $account['trade_status']?></td>

                <td rel="<?=$account['account_type']?>">
                    <?php 
                    
                        
                    
                        switch ($account['account_type_code']) {
                        case 1:
                            $account_type = lang('mya_28');
                            break;
                        case 2:
                            $account_type = lang('mya_29');
                            break;
                        case 4:
                            $account_type = lang('mya_31');
                            break;
                        case 5:
                            $account_type = lang('mya_38');
                            break;
                        case 6:
                            $account_type = lang('mya_42');
                            break; 
                        default:
                            $account_type = lang('mya_39');
                    }
                            
                    
//                    switch ($account['account_type_code']) {
//                        case 'ForexMart Standard':
//                            $account_type = lang('mya_28');
//                            break;
//                        case 'ForexMart Zero Spread':
//                            $account_type = lang('mya_29');
//                            break;
//                        case 'ForexMart Micro Account':
//                            $account_type = lang('mya_31');
//                            break;
//                        case 'ForexMart Classic':
//                            $account_type = lang('mya_38');
//                            break;
//                        default:
//                            $account_type = lang('mya_39');
//                    }
                    echo $account_type ?></td>
                <td class="checkbox-center"><input type="checkbox" id="chk_swap"<?php echo $account['swap_free'] ? ' checked' : '' ?> disabled/></td>



            <td class="checkbox-center">
                <input type="checkbox" rel="<?=$account['SendReports']?>"  <?=($account['SendReports'])?"checked":""?> class="chk_reports_cls"   disabled="disabled"/>
            </td>




                <td class="actionBtnMyAcc">



                    <?php if(isset($_SESSION['first_login']) && $_SESSION['first_login'] ){?>
                    <a class="btn btn-primary" href="<?php echo FXPP::loc_url('Client/signin');?>" style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;white-space:normal!important;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                        <?= lang('mya_32'); ?>
                    </a>
                    <?php }else{?>




                        <?php   ?>


                            <div class="dropdown drp-action drp-active" id="drp_switch">
                                <button style="border-radius: 3px !important;" class="btn btn-primary btn-action" type="button" data-toggle="dropdown"><?= lang('mya_40'); ?><span class="caret"></span></button>
                                <ul class="dropdown-menu drpmenuswitch" id="drp_menu_switch">

                                    <li class="hover_color">
                                        

                                        <?= form_open(FXPP::loc_url('client/switch-account'), '', ''); ?>
                                        <input type="hidden"  name="username" value="<?= $account['account_number'] ?>">
                                        <button class="switchBtn hover_btn" type="submit"
                                                style="color: <?= $account['inactive']?'#c5c5c5':'black';?> ;  border: none;font-size: 14px;font-family: Open Sans;transition: all ease 0.3s; padding-left: 20px;" <?= $account['inactive']?'disabled':'';?>>
                                            <?= lang('mya_32'); ?>
                                        </button>
                                        <?php echo form_close() ?>

                                    </li>

                                    <li style="cursor: pointer;"><a onclick="removeAccount(<?php echo $account['account_number'] ?>)"><?= lang('mya_41'); ?></a></li>

                                </ul>
                            </div>


                        <?php  /*  ?>


                            <?= form_open(FXPP::loc_url('client/switch-account'), '', ''); ?>
                            <input type="hidden"  name="username" value="<?= $account['account_number'] ?>">
                            <button class="switchBtn" type="submit"
                                    style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                                <?= lang('mya_32'); ?>
                            </button>
                            <?php echo form_close() ?>




                        <?php   */   ?>




                    <?php }?>


                </td>
            </tr>
                <?php

            }
        } ?>




