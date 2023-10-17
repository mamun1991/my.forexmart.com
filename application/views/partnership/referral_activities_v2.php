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
                <table id='activities_table' class="table table-striped part-table referral-table arabic-part-table" id="tab-referrals-table" cellspacing="0" width="100%"  cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <th class="crTradesMob"><?=lang('oth_com_20_10');?></th>
                        <th><?=lang('oth_com_20_11');?></th>
<!--                        <th>--><?//=lang('oth_com_20_12');?><!--</th>-->
                        <th class="crTradesMob"><?=lang('oth_com_20_13');?></th>
                        <th class="crTradesMob"><?=lang('oth_com_20_14');?></th>

                        <th class="crTradesWeb">  <?='Action';?> </th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <div id="activities_pagination"></div>
                <input type="hidden" id="activitiesTotalPages" value="<?php echo $activitiesTotalPages; ?>">
            </div>
        </div>


    </div>
</div>


<script>

    geReferralActivityList();










    function viewDetailsMob(rDate, rAcc, rCode, rCountry, rTransec) {
        //console.log(date+'--'+acc+'--'+code+'--'+country+'--'+transec);

        if ($(window).width() < 768) {
            $('#referral_activities_modal').modal('show');
            $("#modalReffaral").removeAttr('disabled');

            $('.rDate').html(rDate);
            $('.rAcc').html(rAcc);
//            $('.rCode').html(rCode);
            $('.rCountry').html(rCountry);
            $('.rTransec').html(rTransec);


        }
    }


    function geReferralActivityList(){


            var totalPageActivities = parseInt($('#activitiesTotalPages').val());
            $('#activities_pagination').simplePaginator({ //pagination js plugin
                totalPages: totalPageActivities,
                maxButtonsVisible: 5,
                currentPage: 1,
                nextLabel: 'Next',
                prevLabel: 'Prev',
                firstLabel: 'First',
                lastLabel: 'Last',
                clickCurrentPage: true,
                pageChange: function(page) {
                    $.ajax({
                        url: '<?= FXPP::ajax_url('partnership/requestReferralActivities')?>',
                        method:"POST",
                        dataType: "json",
                        data:{page:	page},
                        beforeSend: function(){
                            $('#activities_table tbody').html('<div id ="loading_rec" style="text-align:center;"><tr><td colspan="5">Loading records<img src="<?=$this->template->Images()?>loading.gif" /></td></tr></div>');

                        },
                        success:function(response){
                            $('#activities_table tbody').html(response.htmlView);

                            $("#loading_rec").hide();

                        }
                    });
                }
            });


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
