<?php include_once('partnership_nav.php') ?>
<?php $this->lang->load('datatable');?>
<style>
    .period-option {
        width: 411px!important;
    }
    .part-table:lang(sa) {
        margin-top: 20px !important;
    }
    .referral-table td { text-align: center; }

    .center-data{
        text-align: center;
    }
    @media screen and (max-width: 991px) and (-webkit-min-device-pixel-ratio:0){
        .btnapply{
            float: right;
        }
     }
      @media screen and (max-width: 463px)and (min-width: 344px) and (-webkit-min-device-pixel-ratio:0){
        .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 32.5%!important;
        }
     }
      @media screen and (max-width: 343px) and (-webkit-min-device-pixel-ratio:0){
         .ulday{
            margin-top:5px;
        }
        .nav-pills li{
            width: 100%!important;
        }
     }
.highcharts-container{
	width: auto !important;
}
.table-padding {
	padding: 10px 0;
}
 .table > thead:first-child > tr:first-child > th {
    border-top: 0;
    text-align: center;
}





    @media screen and (max-width: 767px){
        .crTradesMob{
            display: none;
        }
        .crTradesWeb{
            display: ;
        }
        .showDetailsMob,.crTradesWebStyle{
            color: #337AB7;
        }



    }

    @media screen and (min-width: 767px){

        .crTradesMob{
            display:;
        }
        .crTradesWeb{
            display:none ;
        }
    }








</style>
<div class="tab-content acct-cont">
    <div role="tabpanel" class="tab-pane active" id="referrals">
        
        <div class="table-padding">
        <div class="table-responsive">
            <table class="table table-striped part-table referral-table arabic-part-table" id="tab-referrals-table" cellspacing="0" width="100%"  cellspacing="0" border="0">
                 <thead>
                 <tr>
                    <th class="crTradesMob"><?=lang('oth_com_20_10');?></th>
                    <th><?=lang('oth_com_20_11');?></th>
                    <th><?=lang('oth_com_20_12');?></th>
                    <th class="crTradesMob"><?=lang('oth_com_20_13');?></th>
                    <th class="crTradesMob"><?=lang('oth_com_20_14');?></th>

                    <th class="crTradesWeb">  <?='Action';?> </th>
                    
                 </tr>
                 </thead>
                 <tbody>    
                        
                           <?php                            
                           foreach($ref_table as $d){

                               $rDate=$d->tx_date;
                               $rAcc=$d->account_number;
                               $rAffCode=$d->referral_affiliate_code;
                               $rCountry=$d->country;
                               $rTransection=$d->tnx_type.' '. number_format($d->amount,2) ." ". $d->mt_currency_base ;

                               $rDetails='Details';


                               if($d->tnx_type==1){
                                   $tranType='Sent to client';
                               }elseif($d->tnx_type==2 ) {
                                   $tranType='Sent to other Partner';
                               }elseif($d->tnx_type==3 ){
                                   $tranType='Request from Client';

                               }else{
                                   $tranType=$d->tnx_type;
                               }

                              
                               ?>
                               <tr onclick="viewDetailsMob('<?=$rDate?>','<?=$rAcc?>','<?=$rAffCode?>','<?=$rCountry?>','<?=$rTransection?>')">

                                   <td class="crTradesMob"><?php echo $d->tx_date?></td>
                                   <td><?php echo $d->account_number?></td>
                                   <td><?php echo $d->referral_affiliate_code?></td>
                                   <td class="crTradesMob"><?php echo $d->country?></td>


                                   <td class="crTradesMob"><?php




                                           if($d->micro_status ==1 ){


                                               if(IPLoc::Office()) {

                                                   if ($d->tnx_type == '1' || $d->tnx_type == '2' || $d->tnx_type == '3') {
                                                       $conVAmount=$d->amount/100;
//                                                       $centAmount=($conVAmount/10);
                                                       $totalCentAmount=round($conVAmount,2);
                                                       echo $tranType.' '. $totalCentAmount ." USD ";

                                                   } else if($d->tnx_type == 'Deposited') {

//                                                       $centAmount=($d->amount/10);
                                                       $totalCentAmount=round($d->amount,2);
                                                       echo $tranType.' '. $totalCentAmount ." USD ";

                                                   }else{

                                                       echo $tranType . ' ' . number_format(($d->amount ), 2) . " " . $d->mt_currency_base;
                                                   }


                                               }else{

                                                   if ($d->tnx_type == '1' || $d->tnx_type == '2' || $d->tnx_type == '3') {
                                                       echo $tranType . ' ' . number_format(($d->amount ), 2) . " USD cents";
                                                   } else {
                                                       echo $tranType.' '. number_format($d->amount,2) ." ". $d->mt_currency_base ;
                                                   }

                                               }



                                           }else{

                                               echo $tranType.' '. number_format($d->amount,2) ." ". $d->mt_currency_base ;
                                           }
                                       ?>


                                   </td>

                                   <td class="crTradesWeb crTradesWebStyle"><?php echo $rDetails; ?> </td>
                                   
                                   
                                   
                               </tr>
                           
                           
                           <?php } ?>
                        
                        
                        
               
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<?php if (FXPP::html_url() == 'sa') { ?>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } else { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://code.highcharts.com/stock/2.1.9/highstock.js"></script>
<?php } ?>

<script>

    $('#tab-referrals-table').dataTable({
    "order": [[ 1, "desc" ]],
	"language":{
				search:'<?=lang('curtra_s')?>',
				lengthMenu: '<?=lang('dta_tbl_07')?>',
				info: '<?=lang('dta_tbl_02')?>',
				zeroRecords: '<?=lang('dta_tbl_01')?>',
				paginate: {
					next:       '<?=lang('dta_tbl_14')?>',
					previous:   '<?=lang('dta_tbl_15')?>'
				}
			}	//or asc 
   
});










 function viewDetailsMob(rDate, rAcc, rCode, rCountry, rTransec) {
     //console.log(date+'--'+acc+'--'+code+'--'+country+'--'+transec);

     if($(window).width() < 768) {
         $('#referral_activities_modal').modal('show');
         $("#modalReffaral").removeAttr('disabled');

         $('.rDate').html(rDate);
         $('.rAcc').html(rAcc);
         $('.rCode').html(rCode);
         $('.rCountry').html(rCountry);
         $('.rTransec').html(rTransec);


     }

 }

    </script>


<div id="referral_activities_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content withdraw-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <strong style="font-size: 20px"> Referral Activities </strong>
                <button id="modalReffaral" type="button" class="close" data-dismiss="modal" data-toggle="tooltip" ><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <table class="table table-striped tab-my-acct">

                    <tr>
                        <th>Txn.Date</th>
                        <td class="rDate"> </td>
                    </tr>

                    <tr>
                        <th>Account number of referral</th>
                        <td class="rAcc"> </td>
                    </tr>
                    <tr>
                        <th>Affiliate code</th>
                        <td class="rCode"> </td>
                    </tr>

                    <tr  >
                        <th>Country</th>
                        <td class="rCountry"> </td>
                    </tr>

                    <tr>
                        <th>Transactions</th>
                        <td class="rTransec"> </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>
</div>
