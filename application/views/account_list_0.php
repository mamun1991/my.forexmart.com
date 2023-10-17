<table id="tb_dshbrd2" class="table table-striped tab-my-acct">
    <thead>
    <tr>
        <th><!--Account Number--><?=lang('mya_19');?></th>
        <th><!--Currency--><?=lang('mya_20');?></th>
        <th><!--Balance--><?=lang('mya_21');?></th>
        <th><!--Verification Status--><?=lang('mya_22');?></th>
    </tr>
    </thead>
    <tbody id="partner-accounts-table" class="ttt">
        <?php if( count($accounts) > 0 ){
        foreach( $accounts as $account ){ ?>
        <tr>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #ff0000;"><?php echo $account['reference_num'] ?> <i class="fa fa-caret-down arabic-caret-down"></i></button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        <li class="dropdown-submenu">
                            <a href="<?php echo FXPP::loc_url('deposit') ?>"><!--<?= lang('trd_232');?>--><?=lang('mya_04');?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"><!--Debit/Credit Cards--><?=lang('mya_06');?></a></li>
                                <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                                <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"><!--China UnionPay--><?=lang('mya_07');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/skrill') ?>"><!--Skrill--><?=lang('mya_08');?></a></li>
                                <?php } ?>
                                <li><a href="<?php echo FXPP::loc_url('deposit/neteller') ?>"><!--Neteller--><?=lang('mya_09');?></a></li>
                                <?php if(IPLoc::WhitelistPIPCandCC()){ ?>
                                <li><a href="<?php echo FXPP::loc_url('deposit/webmoney') ?>"><!--WebMoney--><?=lang('mya_10');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/paxum') ?>"><!--Paxum--><?=lang('mya_11');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/ukash') ?>"><!--Ukash--><?=lang('mya_12');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/payco') ?>"><!--PayCo--><?=lang('mya_13');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/filspay') ?>"><!--FilsPay--><?=lang('mya_14');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('deposit/cashu') ?>"><!--CashU--><?=lang('mya_15');?></a></li>
                                <?php } ?>
                                <li><a href="<?php echo FXPP::loc_url('deposit/paypal') ?>"><!--PayPal--><?=lang('mya_17');?></a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="<?php echo FXPP::loc_url('withdraw') ?>"><!--Withdraw Funds--><?=lang('mya_18');?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo FXPP::loc_url('withdraw/bank-transfer') ?>"><!--Bank Transfer--><?=lang('mya_05');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/debit-credit-cards') ?>"><!--Debit/Credit Cards--><?=lang('mya_06');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/unionpay') ?>"><!-- China UnionPay--><?=lang('mya_07');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/skrill') ?>"><!--Skrill--><?=lang('mya_08');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/neteller') ?>"><!-- Neteller--><?=lang('mya_09');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/webmoney') ?>"><!-- WebMoney--><?=lang('mya_10');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/paxum') ?>"><!--Paxum--><?=lang('mya_11');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/ukash') ?>"><!--Ukash--><?=lang('mya_12');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/payco') ?>"><!--PayCo--><?=lang('mya_13');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/filspay') ?>"><!-- FilsPay--><?=lang('mya_14');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/cashu') ?>"><!--CashU--><?=lang('mya_15');?></a></li>
                                <li><a href="<?php echo FXPP::loc_url('withdraw/paypal') ?>"><!--PayPal--><?=lang('mya_17');?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </td>
            <td><?php echo $account['currency'] == 'RUB' ? 'RUR' : $account['currency']; ?></td>
            <td class="balance"><?php echo $balance == '' ? 0 : $balance; ?></td><!--<td>Read Only</td>-->
            <td>
                <?php //if($this->session->userdata('readOnly')){
                //echo "Read Only";
            //}else{
                echo ($p_status['accountstatus']==1 or $p_status['accountstatus']==3) ? "Verified" : "Non-verified";
          //  }?>
            </td>
        </tr>
            <?php
        }
    }else{ ?>
    <tr>
        <td colspan="4" align="center"><!--No records found.--><?=lang('mya_23');?></td>
    </tr>
        <?php } ?>
    </tbody>
</table>