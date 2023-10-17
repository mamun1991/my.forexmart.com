<link rel='stylesheet' href='<?=$this->template->Css()?>custom_dashboard.css'>
<style type="text/css">
    table.head-th thead th{
        padding-right:8px;
    }
    .th-accnum{
        width:18%;
    }
    .th-lev, .th-cur , .th-bal , .type-td, .bal-td{
        width: 10%;
    }
	.th-status {
        width: 10%;
    }
    .th-type{
        width:20%;
    }
    .th-swapf{
        width:12%;
    }
    .frst-td{
        width:19%;
    }
    .sec-td{
        width: 11%;
    }
    .cur-td{
        width: 9%;
    }
    .swapf-td{
        width: 10%;
    }

	.tab-my-acct > tbody > tr > td {
		line-height: 20px;
		padding: 8px;
		padding-right: 8px;
	}
	.th-action{
		width: 10%;
	}
	.tab-res-holder {
		margin-left: 5px;
	}
    @media only screen and (max-width: 700px){
        #first-accounts-tables {
            display: none;
        }
    }
    .btns-open-acc {
        margin-top: 15px;
        margin-right: 26px;
        /*float: left;*/
        display: inline-block;
    }
    .btn-trading-demo-holder{
        text-align: center;
    }
	

</style>
<style>
.checkbox-center{
	text-align: center;
}
@media screen and (min-width:1124px){
.btns-open-acc{
	width:33.2%
}
.mid-btn{
	width:31%
}
.btns-open-acc button ,.mid-btn button {
	width:100%
}
.reg-btn{
	margin-right:0px;
}



}
@media screen and (max-width:1124px){
.open-trading{
	padding: 7px 50px;
}
}
@media screen and (max-width:991px){
.btn-trading-demo-holder{
	margin-bottom: 10px;
}
}
@media screen and (max-width:1024px){
.checkbox-center{
	text-align: left;
}
}


</style>


<h1 class="tst789"><?=lang('mya_01');?></h1>
<?php $this->load->view('account_nav.php');?>
<div class="tab-content acct-cont">
<div role="tabpanel" class="row tab-pane active" id="tab1">
<div class="col-md-12 col-sm-12 btn-trading-demo-holder">
<!--    <div class="btns btns-open-acc" style="">-->
<!--        <form action="--><?//= FXPP::www_url('register')?><!--" method="post">-->
<!--            <input type="hidden" name="email" value="--><?php //echo $this->session->userdata('email') ?><!--">-->
<!--            <input type="hidden" name="full_name" value="--><?php //echo $this->session->userdata('full_name') ?><!--">-->
<!--            <button type="submit" class="open-trading btns-open-wid-acc" disabled>--><?//=lang('mya_02');?><!--</button>-->
<!--        </form>-->
<!--    </div>-->
    <div class="btns btns-open-acc mid-btn" style="">
        <form action="<?= FXPP::www_url('register/demo')?>" method="post">
            <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
            <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
            <button type="submit" class="open-demo open-demo_custom btns-open-wid-acc"><?=lang('mya_03');?></button>
        </form>
    </div>
    <?php if( $acc_status['accountstatus']==1 or $acc_status['accountstatus']==3){ ?>
    <div class="btns btns-open-acc reg-btn" style="">
        <form action="<?= FXPP::my_url('registration')?>" method="post">
            <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
            <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
            <button type="submit" class="open-trading btns-open-wid-acc"><?=lang('reg_in_02');?></button>
        </form>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
</div>
<div class="col-md-12 tab-res-holder">
<div class="row">
<div class="table-responsive" style="overflow: visible !important;">
<?php if(!$this->session->userdata('login_type')){ ?>
<table id="tb_dshbrd2" class="table table-striped tab-my-acct">
    <thead>
    <tr>
        <th><?= lang('macv_00'); ?></th>
        <th><?= lang('macv_01'); ?></th>
        <th><?= lang('macv_02'); ?></th>
        <!-- <th>Free Margin</th>-->
        <th><?= lang('macv_03'); ?></th>
        <th><?= lang('macv_04'); ?></th>
        <th><?= lang('trd_status'); ?></th>
        <th><?= lang('macv_05'); ?></th>
        <th><?= lang('macv_06'); ?></th>

        <?php if(count($accounts2)> 0) { ?>
        <th><?= lang('mya_33');  ?> </th>
        <?php } ?>



    </tr>
    </thead>
<tbody id="partner-accounts-table" class="rrrrrr">
    <?php if (count($accounts) > 0) {
    foreach ($accounts as $account) { ?>
    <tr>
        <td>
            <div class="dropdown">
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="color: #ff0000;">
                    <?php echo $account['account_number'] ?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu multi-level" role="menu"
                    aria-labelledby="dropdownMenu">
                    <li class="dropdown-submenu">
                        <a href="<?php echo FXPP::loc_url('deposit') ?>">
                            <!--<?= lang('trd_232');?>-->
                            <?= lang('mya_04'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (IPLoc::WhitelistPIPCandCC()) { ?>

                            <li>
                                <a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>">
                                    <!--Debit/Credit Cards--><?= lang('mya_06'); ?></a></li>
                            <?php if (IPLoc::WhitelistPIPCandCC()) { ?>
                            <li>
                                <a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>">
                                    <!--China UnionPay--><?= lang('mya_07'); ?></a></li>
                            <?php } ?>
                            <li><a href="<?php echo FXPP::loc_url('deposit/skrill') ?>">
                                <!--Skrill--><?= lang('mya_08'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/neteller') ?>">
                                <!--Neteller--><?= lang('mya_09'); ?></a></li>
                            <?php if (IPLoc::WhitelistPIPCandCC()) { ?>
                            <li>
                                <a href="<?php echo FXPP::loc_url('deposit/webmoney') ?>">
                                    <!--WebMoney--><?= lang('mya_10'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/paxum') ?>">
                                <!--Paxum--><?= lang('mya_11'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/ukash') ?>">
                                <!--Ukash--><?= lang('mya_12'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/payco') ?>">
                                <!--PayCo--><?= lang('mya_13'); ?></a></li>
                            <li>
                                <a href="<?php echo FXPP::loc_url('deposit/filspay') ?>">
                                    <!--FilsPay--><?= lang('mya_14'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/cashu') ?>">
                                <!--CashU--><?= lang('mya_15'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('deposit/hipay') ?>">
                                <!--Hipay Wallet--><?= lang('mya_16'); ?></a></li>
                            <?php } ?>
                            <li><a href="<?php echo FXPP::loc_url('deposit/paypal') ?>">
                                <!--PayPal--><?= lang('mya_17'); ?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="<?php echo FXPP::loc_url('withdraw') ?>">
                            <!--Withdraw Funds--><?= lang('mya_18'); ?></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo FXPP::loc_url('withdraw/bank-transfer') ?>">
                                    <!--Bank Transfer--><?= lang('mya_05'); ?></a></li>
                            <li>
                                <a href="<?php echo FXPP::loc_url('withdraw/debit-credit-cards') ?>">
                                    <!--Debit/Credit Cards--><?= lang('mya_06'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/unionpay') ?>">
                                <!--China UnionPay--><?= lang('mya_07'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/skrill') ?>">
                                <!--Skrill--><?= lang('mya_08'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/neteller') ?>">
                                <!--Neteller--><?= lang('mya_09'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/webmoney') ?>">
                                <!--WebMoney--><?= lang('mya_10'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/paxum') ?>">
                                <!--Paxum--><?= lang('mya_11'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/ukash') ?>">
                                <!--Ukash--><?= lang('mya_12'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/payco') ?>">
                                <!--PayCo--><?= lang('mya_13'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/filspay') ?>">
                                <!--FilsPay--><?= lang('mya_14'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/cashu') ?>">
                                <!--CashU--><?= lang('mya_15'); ?></a></li>
                            <li><a href="<?php echo FXPP::loc_url('withdraw/paypal') ?>">
                                <!--PayPal--><?= lang('mya_17'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </td>
        <td><span id="txt_leverage"><?php echo $account['leverage'] ?></span>
            <?php
                 if($show_fx_bonus['is_showfxbonus']==1 ){

                  }  elseif ($users['nodepositbonus'] == 0 OR $user_profiles['country'] == 'PL') { ?>
                    <?php if( $acc_status['accountstatus']==1 or $acc_status['accountstatus']==3){

                        if(FXPP::isAccountFromEUCountry()){ ?>
                            <a id="edit_leverage"><i class="fa fa-pencil edit-lev"></i></a>
                            <select id="select_leverage" class="form-control round-0 test00" style="display: none;" ><?php echo $leverage ?></select>
                       <?php }else{ ?>
                            <a id="edit_leverage"><i class="fa fa-pencil edit-lev"></i></a>
                            <select id="select_leverage" class="form-control round-0" style="display: none;"><?php echo $leverage ?></select>
                        <?php }?>

                    <?php }else{ ?>
                        <a id="edit_leverage"><i class="fa fa-pencil edit-lev"></i></a>
                        <select id="select_leverage" class="form-control round-0 ma testp" style="display: none;" ><?php echo $leverage ?></select>
                    <?php  }
                }
             ?>
        </td>
        <td><?php echo $account['mt_currency_base'] == 'RUB' ? 'RUR' : $account['mt_currency_base']; ?></td>
        <!-- <td><?php /*echo $account['amount'] == '' ? 0 : $account['amount']; */
            ?> </td>-->
        <td><?php echo $balance == '' ? 0 : $balance; ?></td>
            <td id="live-client-status skt">
                <?php echo $account['veri_status']; ?>
            </td>
        <td id="live-client-trade-status"> <?php echo $account['trade_status']; ?></td>
        <?//=lang('mya_27'); //"Verified" ?> <?//=lang('mya_26'); //"Read only" ?> <!-- <td><?php /*echo $account['mt_type'] ? 'Trading' : 'Demo' */ ?></td>-->
        <?php
        //FXPP-4852
        switch ($account['account_type']) {
            case 'ForexMart Standard':
                $account_type = lang('mya_28');
                break;
            case 'ForexMart Zero Spread':
                $account_type = lang('mya_29');
                break;
            case 'ForexMart Micro Account':
                $account_type = lang('mya_31');
                break;
            default:
                $account_type = $account['account_type'];
        }
        ?>
        <td><?php /*if (IPLoc::Office()) { echo $account_type;   } else {*/    echo $account['account_type']; // } ?></td>
        <td class="checkbox-center"><input type="checkbox" id="chk_swap"<?php echo $account['swap_free'] ? ' checked' : '' ?><?= isset($reg_loc) && ($reg_loc == 7) ? 'disabled' : ''; ?> /></td>


        <?php if(count($accounts2)> 0) { ?>

            <td class="onlyAcc">N/A </td>

        <?php } ?>



    </tr>
        <?php
    }
}
//    if(IPLoc::Office()){
        if (count($accounts2) > 0) {
            foreach ($accounts2 as $account) {  ?>
            <tr>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown disabled" aria-haspopup="true"
                                aria-expanded="false"
                                style="color: #aba3a3;"><?php echo $account['account_number'] ?>
                            <span class="caret"></span></button>
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
                <?php if (IPLoc::Office()){  ?>

                    <?php if ($account['veri_status']=='Verified'){?>
                        <img data-toggle="tooltip" src="<?= $this->template->Images()?>my_account/Icon2.svg" title="Your account has been verified!" alt="" width="25" height="30">
                    <?php }else{?>
                        <img data-toggle="tooltip" src="<?= $this->template->Images()?>my_account/icon1.svg" title="Your account has not been verified!" alt="" width="25" height="30">
                    <?php }?>

                <?php }else{ ?>
                    <?php echo $account['veri_status']; ?>
                <?php }?>
                </td>
                <td id="live-client-status1" style="<?=$color;?>"><?= $account['trade_status']?></td>

                <td>
                    <?php
//                    if(IPLoc::Office()){
//                        print_r($account['account_type']);
//                    }
                    switch ($account['account_type']) {
                        case 'ForexMart Standard':
                            $account_type = lang('mya_28');
                            break;
                        case 'ForexMart Zero Spread':
                            $account_type = lang('mya_29');
                            break;
                        case 'ForexMart Micro Account':
                            $account_type = lang('mya_31');
                            break;
                        case 'ForexMart Classic':
                            $account_type = lang('mya_38');
                            break;
                        default:
                            $account_type = lang('mya_39');
                    }
                    echo $account_type ?></td>
                <td class="checkbox-center"><input type="checkbox" id="chk_swap"<?php echo $account['swap_free'] ? ' checked' : '' ?> disabled/></td>
                <td>



                    <?php if(isset($_SESSION['first_login']) && $_SESSION['first_login'] ){?>
                    <a class="btn btn-primary" href="<?php echo FXPP::loc_url('Client/signin');?>" style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;white-space:normal!important;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                        <?= lang('mya_32'); ?>
                    </a>
                    <?php }else{?>

                           <!-- <a class="btn btn-primary" href="<?php /*echo FXPP::loc_url('my-account/switch-account')."/".$account['account_number'];*/?>" style="background: <?/*= $account['inactive']?'#aaabaa':'#29a643';*/?> ;white-space:normal!important;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?/*= $account['inactive']?'disabled':'';*/?>>
                                <?/*= lang('mya_32'); */?>
                            </a>-->

                            <?= form_open(FXPP::loc_url('Client/signin'), array('id' => 'switchAccount'), ''); ?>
                            <input type="hidden" id="inputEmail3" name="username"
                                   value="<?= $account['email'] ?>">
                            <input type="hidden" name="password" id="pass"
                                   value="<?= $account['trader_password'] ?>">
                            <button type="submit"
                                    style="background: <?= $account['inactive']?'#aaabaa':'#29a643';?> ;color: #fff;border: none;font-size: 12px;font-family: Open Sans;transition: all ease 0.3s;" <?= $account['inactive']?'disabled':'';?>>
                                <?= lang('mya_32'); ?>
                            </button>
                            <?php echo form_close() ?>


                    <?php }?>


                </td>
            </tr>
                <?php
            }
        }
  /*  }//office IP*/
    ?>
</tbody>
</table>
</div>

    <?php }else{?>
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
    <?php }?>
</div>
</div>
</div>
</div>

<input type="hidden" name="account_verification" id="account_verification" value="0">
<?php// please locate PaymentSystemCarousel in the applications/modal folder ?>
<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
<?= $this->load->ext_view('modal', 'accountTypeHolder', '', TRUE); ?>

<?= $this->load->ext_view('modal', 'edit_swap_free', '', TRUE); ?>
<?php if($users['nodepositbonus'] == 0 OR $user_profiles['country'] == 'PL' ){ ?>
    <?= $this->load->ext_view('modal', 'edit_leverage', '', TRUE); ?>
<?php } ?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>


<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    var accountnumber = "<?php echo $AN; ?>";
    var AN_type = "<?php echo $AN_type; ?>";

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function(){

        prvt["data"] = {
            AccountNumber:accountnumber,
            AccNum_type:AN_type
        };

        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'my-account/req_bal',
            method: 'POST',
            data: prvt["data"]
        });
        pblc['request'].done(function( data ) {

            $('td.balance').html(data.balance);

            if (data.leverage_option!=''){
                $('#select_leverage').empty().append(data.leverage_option);
            }

            console.log(data.is_showfx);
            if (data.is_showfx){
                $('#txt_leverage').css('display','block!important');
                $('#select_leverage').css('display','none!important');
                console.log('hit');
            }

            if (data.leverage!=''){
                $('#txt_leverage').html(data.leverage);
                $('#select_leverage').val(data.leverage);

            }else{
                $('#select_leverage').val($('#txt_leverage').html());
            }


        });
        pblc['request'].fail(function( jqXHR, textStatus ) {

        });

        var ajax_call = function() {
            prvt["data"] = {
                AccountNumber:accountnumber,
                AccNum_type:AN_type
            };

            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url + 'my-account/req_bal',
                method: 'POST',
                data: prvt["data"]
            });
            pblc['request'].done(function( data ) {



                $('td.balance').html(data.balance);

                if (data.leverage_option!=''){
                    $('#select_leverage').empty().append(data.leverage_option);
                }
                console.log(data.is_showfx);
                if (data.is_showfx){
                    $('#txt_leverage').css('display','block!important');
                    $('#select_leverage').css('display','none!important');
                    console.log('hit');
                }
                if (data.leverage!=''){
                    $('#txt_leverage').html(data.leverage);
                    $('#select_leverage').val(data.leverage);

                }else{
                    $('#select_leverage').val($('#txt_leverage').html());
                }

            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });
        };
        var interval = 1000 * 60 * .5; // where X is your every X minutes
        setInterval(ajax_call, interval);

        <?php if($this->session->userdata('login_type') == 1){ ?>
        getPartnerTradedLots();
        <?php } ?>

    });



    function getPartnerTradedLots() {

            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url + 'Partnership/getReferralTradedlots',
                method: 'POST',
            });
            pblc['request'].done(function( data ) {
                console.log(data);
                if(data.totalRefVolume > 0){
                    $(".total-traded-lots").html(data.totalRefVolume);
                }else{
                    $(".total-traded-lots").html(0);
                }

            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });

    };
</script>


<?php $data['accountstatus']= ((!isset($account['mt_status']) || trim($account['mt_status'])==='')) ? lang('mya_26') : lang('mya_27'); ?>

<?php if($AN_type==1 and $data['accountstatus']==lang('mya_26') ){  ?>

<script type="text/javascript">

    var pblc = [];
    var prvt = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    var accountnumber = "<?php echo $AN; ?>";
    var AN_type = "<?php echo $AN_type; ?>";
    var is_readonly=true;


    $(document).ready(function(){
        if (is_readonly){

            prvt["data"] = {
                AccountNumber:accountnumber,
                AccNum_type:AN_type,
                account_verification: $("#account_verification").val()
            };

            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url + 'Query/is_verified',
                method: 'POST',
                data: prvt["data"]
            });
            pblc['request'].done(function( data ) {

                if(data.verification_status=='Read Only'){
                    is_readonly=true;
                    $("#live-client-status").html('<?=lang('mya_26')?>');
                    $("#account_verification").val(0);
                    //lang('mya_26') = Read Only
                }else{
                    $("#account_verification").val(1);
                    $("#live-client-status").html('<?=lang('mya_27')?>');
                    $("div#va").css('display','none');
                    //lang('mya_27') = Verified
                    is_readonly=false;
                    clearInterval(interval2)
                }

            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });

            var ajax_verify = function() {
                if (is_readonly){
                    prvt["data"] = {
                        AccountNumber:accountnumber,
                        AccNum_type:AN_type,
                        account_verification: $("#account_verification").val()
                    };

                    pblc['request'] = $.ajax({
                        dataType: 'json',
                        url: site_url + 'Query/is_verified',
                        method: 'POST',
                        data: prvt["data"]
                    });
                    pblc['request'].done(function( data ) {

                        if(data.verification_status=='Read Only'){
                            is_readonly=true;
                            $("#live-client-status").html('<?=lang('mya_26')?>');
                            //lang('mya_26') = Read Only
                            console.log('read only true');
                            $("#account_verification").val(0);

                        }else{
                            $("#live-client-status").html('<?=lang('mya_27')?>');
                            $("div#va").css('display','none');
                            clearInterval(interval2);
                            //lang('mya_27') = Verified
                            is_readonly=false;
                            console.log('read only false');
                            $("#account_verification").val(1);
                        }

                    });
                    pblc['request'].fail(function( jqXHR, textStatus ) {

                    });
                }
            };
            var interval2 = 1000 * 60 * .5; // where X is your every X minutes
            setInterval(ajax_verify, interval2);
        }
    });

</script>

<?php } ?>
<!-- modal -->

<!--<div class="modal fade" id="popfilter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog round-0">-->
<!--        <div class="modal-content round-0">-->
<!--            <div class="modal-header popheader">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title poptitle" id="myModalLabel">Set Filter Properties</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <div class="row" id="popcheck_filter">-->
<!--                    <div class="col-sm-4 popcheck-holder" id="mt_type_cont">-->
<!--                        <label>Status</label>-->
<!--                        --><?php //echo $mt_type; ?>
<!--                    </div>-->
<!--                    <div class="col-sm-4 popcheck-holder" id="mt_currency_base_cont">-->
<!--                        <label>Currency</label>-->
<!--                        --><?php //echo $mt_currency_base; ?>
<!--                    </div>-->
<!--                    <div class="col-sm-4 popcheck-holder" id="mt_account_set_id_cont">-->
<!--                        <label>Account Type</label>-->
<!--                        --><?php //echo $mt_account_set_id; ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="modal-footer round-0 popfooter">-->
<!--                <button type="button" id="upd-Btn" class="btn btn-primary round-0">Update</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- end modal -->

<script type="text/javascript">
    var site_url="<?=FXPP::ajax_url('')?>";

    $(document).ready(function(){
        jQuery('#edit_leverage').on('click', function(){
            jQuery(this).hide();
            jQuery('#txt_leverage').hide();
            jQuery('#select_leverage').val(jQuery('#txt_leverage').html());
            jQuery('#select_leverage').show();
        });

        jQuery('#select_leverage').on('change', function(){
            jQuery('#leverage_from').html(jQuery('#txt_leverage').html());
            jQuery('#leverage_to').html(jQuery(this).val());
            jQuery('#modaleditleverage').modal('show');
            jQuery('#cancel_leverage').removeAttr("disabled");
            jQuery('#update_leverage').removeAttr("disabled");
            jQuery('.close').removeAttr("disabled");
        });

        jQuery('#chk_swap').on('change', function(){
            if($(this).is(":checked")){
//                $('.edit-swap-text').html('You are about to turn on the Swap-Free field.');
                $('.edit-swap-text').html(  '<?=lang('mya_24');?>');
                $('.swap-free-agree').show();
            }else{
//                $('.edit-swap-text').html('You are about to turn off the Swap-Free field.');
                $('.edit-swap-text').html('<?=lang('mya_25');?>');
                $('.swap-free-agree').hide();
            }
            jQuery('#modaleditswap').modal('show');
        });


        jQuery('#cancel_swap,#swap-dismiss').on('click', function() {
            if($('#chk_swap').is(":checked")){
                $('#chk_swap').prop('checked', false);
            }else{
                $('#chk_swap').prop('checked', true);
            }
            jQuery('#modaleditswap').modal('hide');
        });

        jQuery('#cancel_leverage').on('click', function() {
            jQuery('#select_leverage').hide();
            jQuery('#txt_leverage').show();
            jQuery('#edit_leverage').show();
            jQuery('#modaleditleverage').modal('hide');
        });

        jQuery('#update_swap').on('click', function() {
            var is_checked = 0;
            if(jQuery('#chk_swap').is(':checked')){
                is_checked = 1;
            }

            jQuery.ajax({
                type: "post",
                url: site_url+"my-account/updateSwap",
                data: {swap:is_checked},
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x) {
                    if(x.success) {
                        jQuery('#modaleditswap').modal('hide');
                    }else{
                        if($('#chk_swap').is(":checked")){
                            $('#chk_swap').prop('checked', false);
                        }else{
                            $('#chk_swap').prop('checked', true);
                        }
                        jQuery('#modaleditswap').modal('hide');
                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    $('#loader-holder').hide();
                }
            });
        });

        jQuery('#update_leverage').on('click', function() {
            jQuery.ajax({
                type: "post",
                url: site_url+"my-account/updateLeverage",
                data: 'leverage='+jQuery('#select_leverage').val(),
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(x) {
                    if(x.success){
                        jQuery('#select_leverage').hide();
                        jQuery('#txt_leverage').html(jQuery('#select_leverage').val());
                        jQuery('#txt_leverage').show();
                        jQuery('#edit_leverage').show();
                        jQuery('#modaleditleverage').modal('hide');
                    }else{
                        jQuery('#select_leverage').hide();
                        jQuery('#txt_leverage').show();
                        jQuery('#edit_leverage').show();
                        jQuery('#modaleditleverage').modal('hide');
                    }
                    $('#loader-holder').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                    $('#loader-holder').hide();
                }
            });
//            jQuery('#select_leverage').hide();
//            jQuery(this).show();
//            jQuery('#txt_leverage').show();
        });
//        var baseurl = '<?php //echo FXPP::loc_url();?>//';
//        $('div#popfilter').on('click', 'button#upd-Btn', function(){
//            var mt_type_dts = $("#mt_type_cont input:checkbox:checked").map(function(){return $(this).val();}).toArray();
//            var mt_currency_base_dts = $("#mt_currency_base_cont input:checkbox:checked").map(function(){return $(this).val();}).toArray();
//            var mt_account_set_id_dts = $("#mt_account_set_id_cont input:checkbox:checked").map(function(){return $(this).val();}).toArray();
//            $.ajax({
//                type: 'POST',
//                url: baseurl+'accounts/updateAccountsFilter',
//                data: {
//                    mt_type_dts:mt_type_dts,
//                    mt_currency_base_dts:mt_currency_base_dts,
//                    mt_account_set_id_dts:mt_account_set_id_dts
//                },
//                dataType: 'json'
//            }).done(function(response){
//                $('tbody#accounts-table').html(response);
//                $('#popfilter').modal('toggle');
//            });
//        });



    <?php if(isset($_SESSION['first_login'])){?>
        $(function(){
            var mouseY = 0;
            var topValue = 0;
            window.addEventListener("mouseout",function(e){
                    mouseY = e.clientY;
                    if(mouseY<topValue) {
                        window.history.pushState("object or string", "Title", "/my-account?z42esbsn4yqu2p");
                    }
                },
                false);
        });
        <?php }?>
        $( "body" ).mousemove(function( event ) {
            window.history.pushState("object or string", "Title", "/my-account");
        });
    });
</script>
<?php if( FXPP::html_url() == 'de'){ ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('img[alt="sofort"]').parents('.owl-item').remove();
        $('.owl-wrapper').prepend('<div class="owl-item" style="width: 204px;"><div class="item"><a href="https://my.forexmart.com/deposit/sofort"><img class="lazyOwl" alt="sofort" width="212" height="100" style="display: block;" src="https://my.forexmart.com/assets/images/sofort-carousel.png"></a></div></div>');
    });
</script>
<?php } ?>

<style>
    .owl-buttons{display: none;}
</style>