<input type="hidden" id="baseURL" value="<?php echo base_url();?>" />
<input type="hidden" id="fee" value="<?php echo $fee ?>" />
<input type="hidden" id="ndb_bonus" value="<?php echo $ndb_bonus ?>" />
<input type="hidden" id="add_on" value="<?php echo $add_on ?>" />
<input type="hidden" id="min_amount_req" value="<?php echo $bank_min_withdrawal ?>" />
<input type="hidden" id="micro" value="<?php echo $micro ?>" />
<input type="hidden" name="language" id="language" value = "<?= FXPP::html_url()?>">
<input type="hidden" name="is_from_eu" id="is_from_eu" value = "<?= FXPP::isAccountFromEUCountry();?>">

<h1>
    <?=lang('finav_00');?>
</h1>

<div class="acct-tab-holder">
    <ul role="tablist" class="main-tab arabic-main-tab arabic-finance-main-tab">
    <?php
    $hasContest = FXPP::hasContestBonus();
    if(!$hasContest){
    if ($login_type==0) { ?>
            <li role="presentation">
            <a id="fin_nav1" href="<?php echo FXPP::loc_url('deposit');?>" class="<?=($active_sub_tab == 'deposit') ? 'acct-active' : '';?> finance-tab"><i class="fa fa-money"></i>
                <?=lang('finav_01');?>
            </a>
            </li>
    <?php }else { ?>
        <li role="presentation">
            <a id="fin_nav1" href="<?php echo FXPP::loc_url('deposit'); ?>"
               class="<?= ($active_sub_tab == 'deposit') ? 'acct-active' : ''; ?> finance-tab"><i
                        class="fa fa-money"></i>
                <?= lang('finav_01'); ?>
            </a>
        </li>
    <?php }
    }
    
    
    
       
    
        
   if(!FXPP::prohibition(2))
   {   
    ?>


            <li role="presentation">
                <a id="fin_nav2" href="<?php echo FXPP::loc_url('withdraw');?>" class="<?=($active_sub_tab == 'withdraw') ? 'acct-active' : '';?> finance-tab"><i class="fa fa-credit-card">

                    </i>
                    <?=lang('finav_02');?>
                </a>
            </li>


        <?php
      }
        
        
        $is_tabvisible=true;
        if (IPLOC::Office_and_Vpn()){

        }else{

            $usrs = $this->general_model->showssingle2($table='users',$field='id',$id=$_SESSION['user_id'],$select='nodepositbonus');
            if($usrs){
                if($usrs['nodepositbonus']=='1'){
                    $is_tabvisible=false;
                }
            }
        }
        ?>

            <?php if($is_tabvisible==true){
                
              if(!FXPP::prohibition(1))
               {
                ?>
                <li role="presentation">
                    <a id="fin_nav3" href="<?php echo FXPP::loc_url('transfer');?>" class="<?php echo ($active_sub_tab == 'transfer') ? 'acct-active' : '';?> finance-tab"><i class="fa fa-chevron-right">
                    </i><?php echo lang('finav_03'); ?>
                    </a>
                </li>
            <?php
               }
            
            
            } ?>


            <li role="presentation">
                <a id="fin_nav4" href="<?php echo FXPP::loc_url('transaction-history');?>" class="<?=($active_sub_tab == 'transaction-history') ? 'acct-active' : '';?> finance-tab">
                    <i class="fa fa-history"></i>
                    <?=lang('finav_04');?>
                </a>
            </li>
    </ul>
    <div class="clearfix"></div>
</div>

<style type="text/css">
    ul.main-tab li {
        width: auto !important;
    }

    ul.main-tab li {
        width: 25%;
    }
    @media screen and (max-width: 1120px) {
        ul.main-tab li{
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a{
            text-align: center;
        }
    }
    @media screen and (max-width: 1120px) {
        ul.main-tab li:lang(es){
            width: 100%;
            float: none;
            margin: 1px;

        }
        ul.main-tab li a:lang(es){
            text-align: center;
        }
    }

    @media screen and (min-width: 640px) and (max-width: 1120px){   
       .main-tab li:last-child{
            border-right: 2px solid #fff!important;
        }
    }
</style>
<script type="text/javascript">

    var fin_navhighheight=0;
    var fin_nav1=0;
    var fin_nav2=0;
    var fin_nav3=0;
    var fin_nav4=0;

    $(window).load(function() {
        fin_nav1 = parseFloat($('#fin_nav1').height());
        fin_nav2 = parseFloat($('#fin_nav2').height());
        fin_nav3 = parseFloat($('#fin_nav3').height());
        fin_nav4 = parseFloat($('#fin_nav4').height());
        if(isNaN(fin_nav4)){
            fin_nav4=0;
        }
        fin_navhighheight=parseFloat(Math.round(Math.max(fin_nav1,fin_nav2,fin_nav3,fin_nav4)));
        $('#fin_nav1').height(fin_navhighheight);
        $('#fin_nav2').height(fin_navhighheight);
        $('#fin_nav3').height(fin_navhighheight);
        $('#fin_nav4').height(fin_navhighheight);


    });
    $(window).resize(function() {
        fin_nav1 = parseFloat($('#fin_nav1').height());
        fin_nav2 = parseFloat($('#fin_nav2').height());
        fin_nav3 = parseFloat($('#fin_nav3').height());
        fin_nav4 = parseFloat($('#fin_nav4').height());
        if(isNaN(fin_nav4)){
            fin_nav4=0;
        }
        fin_navhighheight=parseFloat(Math.round(Math.max(fin_nav1,fin_nav2,fin_nav3,fin_nav4)));
        $('#fin_nav1').height(fin_navhighheight);
        $('#fin_nav2').height(fin_navhighheight);
        $('#fin_nav3').height(fin_navhighheight);
        $('#fin_nav4').height(fin_navhighheight);
    });
</script>