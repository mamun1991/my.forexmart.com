
<link rel='stylesheet' href='<?=$this->template->Css()?>custom_dashboard.css'>
<style type="text/css">

table#tb_dshbrd2 td {
    font-size: 12px!important;
}  
.hover_color:focus-visible {
    outline: 2px solid black;
    background: #f5f5f5;
    
}
.hover_btn{
    background: white;
} 
    
table#tb_dshbrd2 thead th {
    font-size: 12px !important;
}
    .showHideDiv {
        display: none;
    }
    table.head-th thead th{
        padding-right:8px;
    }
    tbody#partner-accounts-table{
        text-align: center;
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
		padding: 8px 5px;
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
        /*margin-right: 26px;*/
        /*float: left;*/
        display: inline-block;
    }
    .btn-trading-demo-holder{
        text-align: center;
    }
    .demoNnewRegBtn{
        width: 48% !important;
    }
    @media only screen and (max-width: 1120px){
        .demoNnewRegBtn{
            width: 50% !important;
        }
    }
    @media only screen and (max-width: 1024px){
        tbody#partner-accounts-table{
            text-align: justify!important;
        }
    }
    @media only screen and (max-width: 768px){
        .demoNnewRegBtn{
            width: 70% !important;
        }
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
            /*width:31%*/
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
            padding: 7px 52px;
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
    .mailSentFlogin{
        text-align: center;
        border: 1px solid #106BAA;
        background-color: #106BAA;
        color: white;
        padding: 6px;
        font-size: 13px;
    }
        @media screen and (max-width:450px){
            .open-demo_custom {
                padding: 7px 25px!important;
            }

            .open-trading {
                padding: 7px 24px;
            }
        }
        a.open-trading.btns-open-wid-acc.cngBtna {
            padding: 15px 15px;
        }
        @media screen and (max-width:768px){
            .btns.btns-open-acc.mid-btn.cngPrBtn {
                width: 190px;
                margin-right: 5px;
            }

        }

        @media screen and (min-width:768px) {
            .btns.btns-open-acc.mid-btn.cngPrBtn {
                float: right;
            }
        }

        @media screen and (min-width:1025px) and (max-width:1400px){
            table#tb_dshbrd2 thead th {
                font-size: 10px !important;
            }

            /*.dropdown-menu {*/
                /*left: -80% !important;*/
            /*}*/
        }
.chk_reports_cls{cursor: pointer}

</style>
<style>
    .tooltip_z {
        position: relative;
        display: inline-block;
    }
    .tooltip_z .tooltiptext_z {
        visibility: hidden;
        width: 140px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 15px 10px;
        position: absolute;
        z-index: 1;
        bottom: 120%;
        left: 13%;
        margin-left: -60px;

        /* Fade in tooltip - takes 1 second to go from 0% to 100% opac: */
        opacity: 0;
        transition: opacity 1s;
    }

    .tooltiptext_z::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .tooltip_z:hover .tooltiptext_z {
        visibility: visible;
        opacity: 1;
    }
    .tooltip_z a{
        color: green;
        font-size: 18px;
    }

    .col-centered {
        padding: 0px;
        overflow: hidden !important;
    }

    .drpmenuswitch {
        left: -160px !important;
        top: -3px !important;
    }

#tb_dshbrd2 thead tr th{text-align: center}
</style>


<?php
//if (IPLoc::Office()) {
    if(isset($_SESSION['first_login'])){
        echo '<br>  <span class="mailSentFlogin"> <i class="fa fa-check"></i>'.lang('mya_37').'</span> <hr>';
    }

    $errorMsg = $this->session->flashdata("account-error");
    if (isset($errorMsg)) {
        echo '<br>  <span class="mailSentFlogin"> <i class="fa fa-times"></i>' . $errorMsg . '</span> <hr>';
    }



//}
?>


<h1 ><?=lang('mya_01');?></h1>
<?php $this->load->view('account_nav.php');?>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="row tab-pane active" id="tab1">
        <div class="col-md-12 col-sm-12 btn-trading-demo-holder">

            <div class="personal-details">
                <form action="" class="fr-personal-details">
                    <div class="row">
                        <div class="col-md-3 col-sm-5">
                            <?php
                            $image = $this->session->userdata('image'); //google auth avatar
                            if($this->session->userdata('oauth_id')){
                                $img = $image;
                            }else{
                                $avatar_url = base_url('assets/images/avatar.png'); $img_url = base_url('assets/user_images/'.$image);
                            } ?>
                            <div class="avatar-holder">
                                <img src="<?= isset($img) ? $img : (isset($image) && $image!='') ? $img_url:$avatar_url;?>" alt="avatar">
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-7">
                            <input type="text" id="disFullName" disabled value="<?= $_SESSION['full_name']?>" class="form-control">
                            <input type="text" id="disEmail" disabled value="<?= $_SESSION['email']?>" class="form-control">
                        </div>
                    </div>

                    <div class="btns btns-open-acc mid-btn cngPrBtn " >
                        <a href="<?= FXPP::loc_url('profile/edit');?>" class="open-trading btns-open-wid-acc cngBtna"><?=lang('change-detail')?></a>
                    </div>

                    <!--   <a href="--><?//= FXPP::loc_url('profile/edit');?><!--" class="btn-custom btn-custom-success trsr">Change Personal Details</a>-->

                    <div class="clearfix"></div>
                </form>
            </div>

            <div class="btns btns-open-acc mid-btn demoNnewRegBtn" >
                <form action="<?= FXPP::www_url('register/demo/setName')?>" method="post">
                    <input type="hidden" name="email" value="<?php echo $this->session->userdata('email') ?>">
                    <input type="hidden" name="full_name" value="<?php echo $this->session->userdata('full_name') ?>">
                    <button type="submit" class="open-demo open-demo_custom btns-open-wid-acc"><?=lang('mya_03');?></button>
                </form>
            </div>
            <?php if( $acc_status['accountstatus']==1 or $acc_status['accountstatus']==3){ ?>
            <div class="btns btns-open-acc reg-btn demoNnewRegBtn">
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
                    <style>
                    .filter-btn{
                        border: 1px solid #5a5a5a;
                        padding: 5px 10px;
                        border-radius: 5px;
                    }
                    .filter-div{
                        text-align: left;
                        position: absolute;
                        background: #fff;
                        padding: 15px 25px;
                        z-index: 10;
                        border: 1px solid #999191;
                        width: 138px;
                        border-radius: 6px;
                     }
                    .score-div{
                        text-align: left;
                        position: absolute;
                        background: #fff;
                        z-index: 10;
                        border: 1px solid #999191;
                        padding: 10px 15px;
                        border-radius: 5px;
                        cursor: pointer;
                    }
                    .hidden {
                        display:none;
                    }
                    .visible {
                        display:block;
                    }
                    .sort i.fa-sort-asc,
                    .sort i.fa-sort-desc{
                        display: none;
                        margin-left: 5px;
                    }
                    .sort.asc i.fa-sort-desc{
                        display: unset;
                    }
                    .sort.desc i.fa-sort-asc {
                        display: unset;
                    }

                    .pull-right:lang(ru) {
                        /*margin-right: -85px;*/
                    }

                    .pull-left {
                        float: left!important;
                    }

                    .pull-left:lang(ru) {
                        /*margin-right: -48px;*/
                    }

                    .filter-btn {
                        border: 1px solid #999191 !important;
                        font-weight: normal !important;
                    }
                    .glyphicon {
                        padding-left: 5px!important;
                    }
                    .btn {
                        padding: 4px !important;
                    }
                    </style>
                    <div class="pull-left">
                        <label class="pull-left btn" ><?= lang('curtra_tbl_11'); ?></label>
                        <div class="pull-left btn" >
                            <!--	<label id="filterbutton" class="filter-btn"><span class="glyphicon glyphicon-chevron-down">&#x25BC;</span></label>-->
                            <label id="filterbutton" class="filter-btn"><?= lang('trd_status'); ?><span class="glyphicon glyphicon-chevron-down"></span></label>
	                        <div id="filterStatus" class="filter-div" style="display: none;">
                                <input type="checkbox" name="filterStatus" value="<?php echo lang('curtra_tbl_07');  ?>" />
                                <label for="filter_status_1"><?php echo lang('curtra_tbl_07');  ?></label><br>
                                <input type="checkbox" name="filterStatus" value="<?php echo lang('curtra_tbl_06');  ?>" />
                                <label for="filter_status_2"><?php echo lang('curtra_tbl_06');  ?></label><br>
	                        </div>
	                    </div>

	                    <div id="filterCurrencydiv" class="pull-left btn" style="display: none;">
	                        <label id="Currencybutton" class="filter-btn"><?= lang('macv_02'); ?><span class="glyphicon glyphicon-chevron-down"></span></label>
	                        <div id="filterCurrency" class="filter-div" style="display: none;">
                                <input type="checkbox" name="filterCurrency" value="USD" />
                                <label for="filter_3">$ (USD)</label><br>
                                <input type="checkbox" name="filterCurrency" value="EUR" />
                                <label for="filter_2">€ (EUR)</label><br>
                                <input type="checkbox" name="filterCurrency" value="GBP" />
                                <label for="filter_4">£ (GBR)</label><br>
                                <input type="checkbox" name="filterCurrency" value="RUB" />
                                <label for="filter_1">₽ (RUB)</label><br>
	                        </div>
	                    </div>
                    </div>
                    <div class="pull-right"><?= lang('curtra_tbl_12'); ?> <?= lang('curtra_tbl_13'); ?> 
                        <select name="state" id="maxRows"  class="btn" style=" border: 1px solid #999191;">
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="50">25</option>
                            <option value="100">100</option>
                        </select> 
                    </div>

                    <input type="hidden" class="changePagi" value="<?= count($accountsPagi);?>">
                    <div class="col-sm-12 col-centered table-responsive">
                        <table id="tb_dshbrd2" class="table table-striped tab-my-acct trtTbl2">
                            <thead>
                                <tr>
                                    <th class="sort "><?= lang('macv_00'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('macv_01'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort "><?= lang('macv_02'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <!-- <th>Free Margin</th>-->
                                    <th class="sort asc filterClass"><?= lang('macv_03'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('macv_04'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort asc filterClass"><?= lang('trd_status'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('macv_05'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('macv_06'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('curtra_tbl_14'); ?><i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                    <th class="sort"><?= lang('mya_33');  ?> <i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
                                </tr>
                            </thead>
                            <tbody id="partner-accounts-table" class="">
                                <?php if (count($accounts) > 0) {
                                foreach ($accounts as $account) { if (IPLoc::Office()){
                                }?>
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


                                                        <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"> <!--Debit/Credit Cards--><?= lang('mya_06'); ?></a></li>
                                                        <?php if(IPLoc::WhitelistPIPCandCC()) { ?>
                                                        <li><a href="<?php echo FXPP::loc_url('deposit/debit-credit-cards') ?>"><!--China UnionPay--><?= lang('mya_07'); ?></a></li>
                                                        <?php } ?>


                                                        <li><a href="<?php echo FXPP::loc_url('deposit/skrill') ?>"><!--Skrill--><?= lang('mya_08'); ?></a></li>
                                                        <li><a href="<?php echo FXPP::loc_url('deposit/neteller') ?>"><!--Neteller--><?= lang('mya_09'); ?></a></li>
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

                                                        <li><a href="<?php echo FXPP::loc_url('deposit/paypal') ?>"> <!--PayPal--><?= lang('mya_17'); ?></a></li>
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

                                    <td><?php echo $balance == '' ? 0 : $balance; ?></td>
                                    <td id="live-client-status skt">
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
                                        case 'ForexMart Classic':
                                            $account_type = lang('mya_38');
                                            break;
                                        case 'ForexMart Pro':
                                            $account_type = lang('curtra_tbl_15');
                                            break;
                                        default:
                                            $account_type = lang('mya_39');
                                    }
                                    ?>
                                    <td><?php     echo $account_type;  ?></td>
                                    <td class="checkbox-center"><input type="checkbox" id="chk_swap"<?php echo $account['swap_free'] ? ' checked' : '' ?><?= isset($reg_loc) && ($reg_loc == 7) ? 'disabled' : ''; ?> /></td>
                                    <td class="checkbox-center">
                                            <input rel="<?=$account['SendReports']?>" type="checkbox" <?=($account['SendReports'])?"checked":""?> id="chk_reports_cls_master_box" class="chk_reports_cls"   />
                                    </td>
                                    <td class="onlyAcc"><?=lang('curtra_tbl_16');?> </td>
                                </tr>
                                 <?php
                                }
                                }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12" >
                        <div class="row" >
                            <div class='pagination-container pull-right showHideDiv' >
                                <nav>
                                    <ul class="pagination">

                                        <li data-page="prev" >
                                            <span> <?=lang('curtra_tbl_17');?>
                                            <span class="sr-only">(current)</span></span>
                                        </li>
                                        <!--	Here the JS Function Will Add the Rows -->
                                        <li data-page="next" id="prev">
                                            <span> <?=lang('curtra_tbl_18');?> <span class="sr-only">(current)</span></span>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?php
                        if($account['trade_status'] =='Archived'){?>
                        <p><?=lang('sup_dep_content');?><b class="blue-text"><a href="mailto:support@forexmart.com">support@forexmart.com</a></b></p>
                        <?php  } ?>
                    </div>
                    <style>
                    .loader_tr {
                      border: 16px solid #f3f3f3;
                      border-radius: 50%;
                      border-top: 16px solid #3498db;
                      width: 80px;
                      height: 80px;
                      -webkit-animation: spin 2s linear infinite; /* Safari */
                      animation: spin 2s linear infinite;
                    }

                    /* Safari */
                    @-webkit-keyframes spin {
                      0% { -webkit-transform: rotate(0deg); }
                      100% { -webkit-transform: rotate(360deg); }
                    }

                    @keyframes spin {
                      0% { transform: rotate(0deg); }
                      100% { transform: rotate(360deg); }
                    }
                    

                    </style>

                </div>

                <?php }else{?>
                <table id="tb_dshbrd2" class="table table-striped tab-my-acct trbtTbl">
                    <thead>
                        <tr>
                            <th ><!--Account Number--><?=lang('mya_19');?></th>
                            <th style="display: none"><!--Leverage--></th>
                            <th><!--Currency--><?=lang('mya_20');?></th>
                            <th><!--Balance--><?=lang('mya_21');?></th>
                            
                            
                            <th><?=lang('parnav_04');?></th>
                         
                            
                            <th><!--Verification Status--><?=lang('mya_22');?></th>
                            <th ><?= lang('mya_33');  ?> </th>
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
                            <td style="display: none"></td>
                            <td><?php echo $account['currency'] == 'RUB' ? 'RUR' : $account['currency']; ?></td>
                            <td class="balance"><?php echo $balance == '' ? 0 : $balance; ?></td><!--<td>Read Only</td>-->
                            
                            
                            
                             <td class="selected_account_td_total_commision"><?= number_format($user_commission, 2); ?></td>
                           
                            
                            
                            <td>
                                <?php            echo ($p_status['accountstatus']==1 or $p_status['accountstatus']==3) ? "Verified" : "Non-verified";       ?>
                            </td>
                            <td class="onlyAcc"><?=lang('curtra_tbl_16');?></td>
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
<!-- // please locate PaymentSystemCarousel in the applications/modal folder -->
<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
<?= $this->load->ext_view('modal', 'edit_swap_free', '', TRUE); ?>
<?= $this->load->ext_view('modal', 'monthly_reports_confirmation', '', TRUE); ?>
<?php if($users['nodepositbonus'] == 0 OR $user_profiles['country'] == 'PL' ){ ?>
    <?= $this->load->ext_view('modal', 'edit_leverage', '', TRUE); ?>
<?php } ?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>



<?php
                                        
echo $this->load->ext_view('modal', 'smart_dollar_not_allow_modal', '', TRUE);
                                        
?>

<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    var accountnumber = "<?php echo $AN; ?>";
    var email  = "<?php echo $email; ?>";
    var AN_type = "<?php echo $AN_type; ?>";
var login_type="<?=$this->session->userdata('login_type')?>";
var current_user_email="<?=$this->session->userdata('email')?>";

    $(document).ready(function(){

        var pagiVal = $(".changePagi").val();

        if(pagiVal > 9){
            $(".showHideDiv").show();
        } else {
            $(".showHideDiv").hide();
        }


var account_type=(login_type!=1)?'client':'partner';


     $.post(site_url+'my-account/releted_accounts',{email:current_user_email,account_type:account_type},function(data){
           $(".loader_tr").hide();
            $('#tb_dshbrd2 tr:last').after(data);
        });



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

			console.log($("#tb_dshbrd2 tbody tr td:nth-child(3)").length);
			var items=[], options=[];
			$('#tb_dshbrd2 tbody tr td:nth-child(3)').each( function(){
			   //add item to array
			   items.push( $(this).text() );
			});

			var items = $.unique( items );
			if(items.length>1) {
				$.each( items, function(i, item){
					if(item == 'USD'){
						options.push('<input type="checkbox" name="filterCurrency" value="USD" /><label style="padding-left: 5px;"> $ (USD)</label><br>');
					} else if(item == 'EUR'){
						options.push('<input type="checkbox" name="filterCurrency" value="EUR" /><label  style="padding-left: 5px;"> € (EUR)</label><br>');
					} else if(item == 'GBR'){
						options.push('<input type="checkbox" name="filterCurrency" value="GBR" /><label style="padding-left: 5px;"> £ (GBR)</label><br>');
					}  else if(item == 'GBR'){
						options.push('<input type="checkbox" name="filterCurrency" value="GBR" /><label style="padding-left: 5px;"> £ (GBR)</label><br>');
					} else if(item == 'RUB'){
						options.push('<input type="checkbox" name="filterCurrency" value="RUB" /><label style="padding-left: 5px;"> ₽ (RUB)</label><br>');
					} else if(item == 'RUR'){
						options.push('<input type="checkbox" name="filterCurrency" value="RUR" /><label style="padding-left: 5px;"> ₽ (RUR)</label><br>');
					}
				})
				$('#filterCurrency').html(options);
				$('#filterCurrencydiv').show();
			}
			getPagination('#tb_dshbrd2');
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
//                console.log(data.is_showfx);
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
        getPartnerTotalCommission();
        getPartnerTotalReferrals();
        <?php } ?>

    });


    function getPartnerTradedLots() {

            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url + 'Partnership/requestReferralTradedlots',
                method: 'POST',
            });
            pblc['request'].done(function( data ) {
                console.log(data);
                if(data.totalLots > 0){
                    $(".total-traded-lots").html(data.totalLots);
                }else{
                    $(".total-traded-lots").html(0.00);
                }

            });
            pblc['request'].fail(function( jqXHR, textStatus ) {

            });

    }
    function getPartnerTotalCommission() {

        <?php //if(IPLoc::APIUpgradeDevIP()){ ?>


        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'Partnership/requestReferralTotalCommission',
            method: 'POST',
        });
        pblc['request'].done(function( data ) {

            if(data.totalCommission > 0){
               // $(".total-commission").html(data.totalCommission);
               setTotalCommission(data.totalCommission);
            }else{
               // $(".total-commission").html(0.00);
                 setTotalCommission(0.0);
            }

        });
        pblc['request'].fail(function( jqXHR, textStatus ) {

        });

      <?php // }else{ ?>

            //setTotalCommission('<?= number_format($user_commission, 2); ?>');
       // $(".total-commission").html('<?= number_format($user_commission, 2); ?>');
        <?php //}?>


    }
    
function setTotalCommission(total_commision){
    total_commision= total_commision.toFixed(2);

    
    $(".selected_account_td_total_commision").html(total_commision);
    $(".total-commission").html(total_commision);
    
}    
    
    function getPartnerTotalReferrals() {
       // console.log('ref');

        <?php //if(IPLoc::APIUpgradeDevIP()){ ?>


        pblc['request'] = $.ajax({
            dataType: 'json',
            url: site_url + 'Partnership/requestReferralsCount',
            method: 'POST',
        });
        pblc['request'].done(function( data ) {
           // console.log(data);
            if(data.totalReferred > 0){
                $(".total-referrals").html(data.totalReferred);
            }else{
                $(".total-referrals").html(0);
            }

        });
        pblc['request'].fail(function( jqXHR, textStatus ) {

        });

        <?php // }else{ ?>

       // $(".total-referrals").html('<?= $user_referrals; ?>');
        <?php //}?>


    }

    function closedScore(id) {
		var account_number = id;
		var scoreid = '#score'+id;
		$(scoreid).addClass("visible");
		if ($("div"+scoreid).hasClass("hidden")) {
			$('.score-hide').addClass("hidden");
			$(scoreid).removeClass("hidden");
			$(scoreid).addClass("visible");
		} else {
			$(scoreid).addClass("hidden");
			$(scoreid).removeClass("visible");
		}
    }

    function removeScore(id) {
		var account_number = id;
		var answer = window.confirm("Would you like to close score?");
		if (answer) {
			$.ajax({
				type: 'POST',
				url:site_url+'my-account/removeAccount',
				data: {
					account_number: id
				},
				dataType: 'json',
				beforeSend: function () {
				},
				success: function(response){
					location.reload();
				},
				error: function (xhr, ajaxOptions, thrownError) {
				}
			});
		}
		else {
			//some code
		}
    }



    function removeAccount(id) {
        var account_number = id;
        var answer = window.confirm("Would you like to remove account?");
        if (answer) {
            $.ajax({
                type: 'POST',
                url:site_url+'my-account/removeAccount',
                data: {
                    account_number: id
                },
                dataType: 'json',
                beforeSend: function () {
                },
                success: function(response){
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                }
            });
        }
        else {
            //some code
        }
    }












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


    function account_lists(){

    }

    $(document).ready(function(){

        account_lists();
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

        var userLang='<?php echo FXPP::html_url(); ?>';

        $( "body" ).mousemove(function( event ) {
            window.history.pushState("object or string", "Title", '/'+userLang+"/my-account");
//            window.history.pushState("object or string", "Title", "/my-account");
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


<script type="text/javascript">
    document.getElementById("disFullName").disabled = true;
    document.getElementById("disEmail").disabled = true;


<?php if($this->session->userdata('login_type') != 1){ ?>

//$(window).on('load', function() {

function getPagination(table) {
  var lastPage = 1;

  $('#maxRows')
    .on('change', function(evt) {
      //$('.paginationprev').html('');						// reset pagination

     lastPage = 1;
      $('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
      var trnum = 0; // reset tr counter
      var maxRows = parseInt($(this).val()); // get Max Rows from select option

      if (maxRows == 5000) {
        $('.pagination').hide();
      } else {
        $('.pagination').show();
      }

      var totalRows = $(table + ' tbody tr').length; // numbers of rows
	  console.log(totalRows);
      $(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
        if (trnum > maxRows) {
          // if tr number gt maxRows

          $(this).hide(); // fade it out
        }
        if (trnum <= maxRows) {
          $(this).show();
        } // else fade in Important in case if it ..
      }); //  was fade out to fade it in
      if (totalRows > maxRows) {
        // if tr total rows gt max rows option
        var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
        //	numbers of pages
        for (var i = 1; i <= pagenum; ) {
          // for each page append pagination li
          $('.pagination #prev')
            .before(
              '<li data-page="' +
                i +
                '">\
								  <span>' +
                i++ +
                '<span class="sr-only">(current)</span></span>\
								</li>'
            )
            .show();
        } // end for i
      } // end if row count > max rows
      $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
      $('.pagination li').on('click', function(evt) {
        // on click each page
        evt.stopImmediatePropagation();
        evt.preventDefault();
        var pageNum = $(this).attr('data-page'); // get it's number

        var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

        if (pageNum == 'prev') {
          if (lastPage == 1) {
            return;
          }
          pageNum = --lastPage;
        }
        if (pageNum == 'next') {
          if (lastPage == $('.pagination li').length - 2) {
            return;
          }
          pageNum = ++lastPage;
        }

        lastPage = pageNum;
        var trIndex = 0; // reset tr counter
        $('.pagination li').removeClass('active'); // remove active class from all li
        $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
        // $(this).addClass('active');					// add active class to the clicked
	  	limitPagging();
        $(table + ' tr:gt(0)').each(function() {
          // each tr in table not the header
          trIndex++; // tr index counter
          // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
          var lfckv = $('#filterStatus').find(":checked").val();
		  if(lfckv != null) {
			  var i = 0;
			  var lfckv = $('#filterStatus').find(":checked").val();


				 $("input:checkbox[name=filterStatus]:checked").each(function(){
					flag = 0;
					var i = 0;
					var j = 0;

					var value = $(this).val().toLowerCase();
					$("#tb_dshbrd2 tbody tr").filter(function() {
						if($(this).text().toLowerCase().indexOf(value) > -1){ i++;
						console.log(pageNum);
						var page = pageNum-1;
						if(page == 0){
							countMaxRows = maxRows;
						} else {
						 countMaxRows = maxRows*(pageNum-1);
						}
						if(i>countMaxRows){
							if(j<=maxRows){
								$(this).show();
								j++;
							} else {
								$(this).hide();
							}
						} else {
								$(this).hide();
							}
						}
					});
				 });
		  } else {
          if ( trIndex > maxRows * pageNum || trIndex <= maxRows * pageNum - maxRows  ) {
		    $(this).hide();
          } else {
            $(this).show();
          } //else fade in
		  }  //else fade in
        }); // end of for each tr in table
      }); // end of on click pagination list
	  limitPagging();
    })
    .val(10)
    .change();

  // end of on select change

  // END OF PAGINATION
}

function limitPagging(){
	// alert($('.pagination li').length)

	if($('.pagination li').length > 7 ){
			if( $('.pagination li.active').attr('data-page') <= 3 ){
			$('.pagination li:gt(5)').hide();
			$('.pagination li:lt(5)').show();
			$('.pagination [data-page="next"]').show();
		}if ($('.pagination li.active').attr('data-page') > 3){
			$('.pagination li:gt(0)').hide();
			$('.pagination [data-page="next"]').show();
			for( var i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
				$('.pagination [data-page="'+i+'"]').show();

			}

		}
	}
}


//});

$(function () {
  $('table')
    .on('click', 'th.filterClass', function () {
      var index = $(this).index(),
          rows = [],
          thClass = $(this).hasClass('asc') ? 'desc' : 'asc';

      $(this).removeClass('asc desc');
      $(this).addClass(thClass);

      $('#tb_dshbrd2 tbody tr').each(function (index, row) {
        rows.push($(row).detach());
      });

      rows.sort(function (a, b) {
        var aValue = $(a).find('tr').eq(index).text(),
            bValue = $(b).find('tr').eq(index).text();

        return aValue > bValue
             ? 1
             : aValue < bValue
             ? -1
             : 0;
      });

        console.log('---ok---'+rows);

      if ($(this).hasClass('desc')) {
        rows.reverse();
      }

      $.each(rows, function (index, row) {
        $('#tb_dshbrd2 tbody').append(row);
      });
    });
});



$(document).ready(function(){
$("#filterCurrency").on("click", function() {
	var name_list = [];
	var currency_list = [];
	$("#tb_dshbrd2 tbody tr").hide();
	$("input:checkbox[name=filterStatus]:checked").each(function(){
		currency_list.push($(this).val());
	});
	$("input:checkbox[name=filterCurrency]:checked").each(function(){
		name_list.push($(this).val());
	});
	var items=[], options=[];
	var i = 0;
	var maxRows = $('#maxRows').find(":selected").val();
	console.log(name_list);
	if( name_list &&  name_list != '') {
	$('#tb_dshbrd2 tbody tr').each( function(){
	  var thisTd = $(this).children().eq(2).text();
	  var thisCurrency = $(this).children().eq(5).text();

	 if(currency_list.length != 0){
		if($.inArray(thisTd, name_list) >= 0 && $.inArray(thisCurrency, currency_list) >= 0){
			i++;
			if(i<=maxRows){
				$(this).show();
			} else {
				$(this).hide();
			}
		} else {
			$(this).hide();
		}
	} else if (currency_list.length != 0 && $.inArray(thisTd, name_list) >= 0) {
			i++;
			if(i<=maxRows){
				$(this).show();
			} else {
				$(this).hide();
			}
		} else if($.inArray(thisTd, name_list) >= 0){
				i++;
				if(i<=maxRows){
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
			$(this).hide();
		}

	});
	} else{
		$('#tb_dshbrd2 tbody tr').each( function(){
		var thisCurrency = $(this).children().eq(5).text();

		 if(currency_list.length != 0){
			if($.inArray(thisCurrency, currency_list) >= 0){
				i++;
				if(i<=maxRows){
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
				$(this).hide();
			}
		} else {
			if(i<=maxRows){	 i++;
				$(this).show();
			} else {
				$(this).hide();
			}
		 }
	   });
	 }
});



$("input[name='filterStatus']").on("click", function() {

	var name_list = [];
	var currency_list = [];
	$("#tb_dshbrd2 tbody tr").hide();
	$("input:checkbox[name=filterStatus]:checked").each(function(){
		name_list.push($(this).val());
	});
	$("input:checkbox[name=filterCurrency]:checked").each(function(){
		currency_list.push($(this).val());
	});
	var items=[], options=[];
	var i = 0;
	var maxRows = $('#maxRows').find(":selected").val();
	console.log(name_list);
	if( name_list &&  name_list != '') {
	$('#tb_dshbrd2 tbody tr').each( function(){
	  var thisTd = $(this).children().eq(5).text();
	  var thisCurrency = $(this).children().eq(2).text();

	 if(currency_list.length != 0){
		if($.inArray(thisTd, name_list) >= 0 && $.inArray(thisCurrency, currency_list) >= 0){
			i++;
			if(i<=maxRows){
				$(this).show();
			} else {
				$(this).hide();
			}
		} else {
			$(this).hide();
		}
	} else if (currency_list.length != 0 && $.inArray(thisTd, name_list) >= 0) {
			i++;
			if(i<=maxRows){
				$(this).show();
			} else {
				$(this).hide();
			}
		} else if($.inArray(thisTd, name_list) >= 0){
				i++;
				if(i<=maxRows){
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
			$(this).hide();
		}

	});
	} else{
		$('#tb_dshbrd2 tbody tr').each( function(){
		var thisCurrency = $(this).children().eq(2).text();

		 if(currency_list.length != 0){
			if($.inArray(thisCurrency, currency_list) >= 0){
				i++;
				if(i<=maxRows){
					$(this).show();
				} else {
					$(this).hide();
				}
			} else {
				$(this).hide();
			}
		} else {
			if(i<=maxRows){	 i++;
				$(this).show();
			} else {
				$(this).hide();
			}
		 }
	   });
	 }
});
});


    $(document).mouseup(function(e)
    {
        var container = $("#filterbutton");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $("#filterStatus").hide();
            //container.hide();
        }

        var container2 = $(".on-disabled");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container2.is(e.target) && container2.has(e.target).length === 0)
        {
            $(".score-div").removeClass('visible');
            $(".score-div").addClass('hidden');
            //container.hide();
        }
    });

$(document).ready(function(){
  $("#filterbutton").click(function(){
      $("#filterStatus").toggle();
  });
});
$(document).ready(function(){
  $("#Currencybutton").click(function(){
    $("#filterCurrency").toggle();
  });
});


<?php } ?>
</script>





<style>
    .owl-buttons{display: none;}
</style>


<script>
$(document).on("click",".chk_reports_cls",function(){
  repStatsupopModal(false);
var status_check_box=0;
    if($(this).is(':checked'))
    {
         $(this).prop('checked', false);
         status_check_box=0;

    }
    else
    {
       $(this).prop('checked', true);
       status_check_box=1;
    }



    if(status_check_box==1){
         $("#container_month_report_confirm_box").find(".activeReport").click();
    }else{
        $("#container_month_report_confirm_box").find(".inActiveReport").click();
    }

  //console.log(status_check_box,"=========>");

  $('#motnhlyReportsPermissionModal').modal('show');
})  ;



function checkRadiboxStatus(){
    if($("#container_month_report_confirm_box").find(".activeReport").is(':checked'))
    {
       return 1;
    }
    else{
     return 0;
    }
}

function repStatsupopModal(status)
{
    if(status=="success")
    {
        $("#container_month_report_confirm_box").hide();
        $("#container_month_report_confirm_box_failed").hide();
        $("#container_month_report_confirm_box_success").show();
        $("#update_month_reports").hide();
    }
    else if(status=="failed")
    {
        $("#container_month_report_confirm_box").hide();
        $("#container_month_report_confirm_box_success").hide();
        $("#container_month_report_confirm_box_failed").show();
         $("#update_month_reports").hide();


    }
     else
    {

        $("#container_month_report_confirm_box_success").hide();
        $("#container_month_report_confirm_box_failed").hide();
        $("#container_month_report_confirm_box").show();
        $("#update_month_reports").show();

    }

}


$(document).on("click","#update_month_reports",function(){

var report_status=checkRadiboxStatus();
$('#motnhlyReportsPermissionModal').modal('show');



     jQuery.ajax({
                type: "post",
                url: site_url+"my-account/updateRepostStatus",
                data: {report_status:report_status},
                dataType: 'json',
                beforeSend: function(){
                    $('#loader-holder').show();
                },
                success: function(result) {

                    repStatsupopModal(result.api_status);

                    if(result.api_status=="success")
                    {
                            if(report_status)
                            {
                               $("#chk_reports_cls_master_box").prop('checked', true);
                            }else{
                                 $("#chk_reports_cls_master_box").prop('checked', false);
                            }
                    }
                  $('#loader-holder').hide();


                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                 $('#loader-holder').hide();
                }
            });



})  ;

</script>
<script>
    $('.tooltip_z').mouseenter(function(){
        $(this).find('tooltiptext_z').fadeIn();
    }).mouseleave(function(){
        $(this).find('tooltiptext_z').fadeOut();
    });
</script>
