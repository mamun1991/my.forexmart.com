<?php $method = $this->router->method; ?>
<?php $class = $this->router->class; ?>
<?php $this->lang->load('datatable');?>
<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>

<style>
 
    .btn-ok:lang(ru){
        color: #fff;
        background: #29a643;
        border: none;
        border-radius:0px; 
    }
    .btn-ok:lang(ru){
        width: 100%;
    }
    .label_date{
        display: inline-block;
        width: 80px;
    }
    .label_date:lang(ru){
        width: 130px;
    }

    .date_field{
        resize: horizontal;
        width: 115px;
        margin-bottom: 15px;
    }
    .date_field:lang(ru){
        width: 193px;
    }
    

    
@media only screen and (min-width: 768px) and (max-width: 2650px)  {
    
    .datesearchformbox .form-group{width: 100% !important}
   .datesearchformbox .date_field{width: 100% !important}
   .datesearchformbox .label_date{width: 100% !important}
.datesearchformbox .btn-ok{
    width: 100% !important;
    padding: 5px !important;}    
    
    
    
}  
 
 
@media only screen and (min-width: 300px) and (max-width: 767px)  {
   .datesearchformbox .date_field{width: 80% !important}
   .datesearchformbox .label_date{width: 80% !important}
.datesearchformbox .btn-ok{
    width: 80% !important;
    padding: 5px !important;}
    
}
    @media only screen and (max-width: 480px)  {

        .date_section{
            margin-left: 63px!important;
        }

    }






</style>


<!--    <h1>-->
<!--       Smart Dollar-->
<!--    </h1>-->
<!--    --><?php //$this->load->view('smart_dollar/smartdollar_nav.php');?>



    <h1>
        <?=lang('curtra_03');?>
    </h1>

    <?php $this->load->view('trading_nav.php');?>


<div class="tab-content acct-cont">
    <div role="tabpanel" class="row tab-pane active">
        <div class="col-sm-12">
            <p class="cur-trades-text arabic-cur-trades-text">

            </p>
            <div class="row history-form-holder">
                <div class="col-sm-12">
                    <div class="info-box-holder row">
                        <div class="col-md-5 col-sm-4 col-centered">
                            <div class="panel panel-blue" style=".panel-blue {border-color: #2988ca;border-radius: 0px!important;}">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-line-chart fa-5x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <div class="huge total-traded-lots">0</div>
                                            <span><?=lang('total_trade_lots');?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <form class="col-sm-5 col-centered" style="margin-bottom: 30px"> -->

                </div>
                <div class="col-sm-5 col-centered">
                    <form  class="form-inline datesearchformbox date_section" style="margin-bottom: 30px">
                        <div class="form-group">
                            <label for="" class="label_date"><?= lang('hot_03'); ?></label>
                            <!--<input  type="date" class="form-control round-0" id="date_start" name="start_date" value="<?//= $from ?>" >-->
                            <input  type="text" class="form-control round-0 datepicker date_field" id="date_start" name="start_date" value="<?= $from ?>"  >
                        </div>
                        <div class="form-group">
                            <label for="" class="label_date"><?= lang('hot_04'); ?></label>
                            <!-- <input type="date" class="form-control round-0"  id="date_end" name="start_end" value="<?//= $to ?>">-->
                            <input type="text" class="form-control round-0 datepicker date_field" id="date_end"  name="start_end" value="<?= $to ?>" >
                        </div>

                        <button type="button" class="btn btn-default btn-ok"><?=lang('total_trade_lots');?></button>
                    </form>
                    <table id="monthly-lots" name="monthly-lots" class="table table-striped  table-bordered tab-my-acct arabic-part-table text-center">
                        <thead>
                        <tr>
                            <th class="text-center"><?=lang('trd_1');?></th>
                            <th class="text-center"><?=lang('trd_2');?></th>
                        </tr>
                        </thead>
                        <tbody id="lots-tbody">
                        <tr>
                            <td class="td-period"></td>
                            <td class=""></td>
                        </tr>
                        <tr>
                            <td><?=lang('trd_3');?></td>
                            <td class="td-sub-total">0.00</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style type="text/css">
    .dashboard > thead > tr > th {
        text-align: center;
    }
    .dashboard > tbody > tr > td {
        text-align: center;
    }

</style>

<script type="text/javascript">
    var pblc = [];
    var prvt = [];
    var site_url="<?=FXPP::ajax_url('')?>";
    pblc['request'] = null;

    $(document).ready(function(){



//        $("#date_start").datetimepicker({
//            format: "YYYY/DD/MM",
//        });
//        $("#date_end").datetimepicker({
//            format: 'MM/DD/YYYY'
//        });

        $('.datepicker').datetimepicker({
              format: 'MM/DD/YYYY',
              maxDate: moment("<?php echo date('Y-m-d');?>"),
              minDate: moment("<?php echo date('2000-01-01');?>")
        });



//    $('#date_start').daterangepicker({
//        "singleDatePicker": true,
//        "setDate": '<?//= $from ?>//',
//        locale: {
//            format: 'MM/DD/YYYY'
//        }
//    }, function(start, end, label) {});
//
//    $('#date_end').daterangepicker({
//        "singleDatePicker": true,
//        "setDate": '<?//= $to ?>//',
//        locale: {
//            format: 'MM/DD/YYYY'
//        }
//    }, function(start, end, label) {});


        initializeRequets(); //start


        $('.btn-ok').click(function() {
            initializeRequets();
        });
    });

        function initializeRequets(){
            $('#loader-holder').show();
            var prvt = [];
            prvt["data"] = {
                from: $('#date_start').val(),
                to: $('#date_end').val()
            };
            pblc['request'] = $.ajax({
                dataType: 'json',
                url: site_url+"my-account/getAccounTotalLots",
                method: 'POST',
                data: prvt["data"]
            });


            pblc['request'].done(function( data ) {
                var totalLots = parseFloat(data.totalLots).toFixed(2);
                var totalTradedLots = parseFloat(data.totalTradedVolume).toFixed(2);
                $('#loader-holder').hide();
                $('.td-period').html(data.from + '  -  ' + data.to);
                $('.td-sub-total').html(totalLots);
                if(totalTradedLots > 0){
                    $('.total-traded-lots').html(totalTradedLots)
                }else{
                    $(".total-traded-lots").html(0);
                }

            });
        }



    </script>

<?= $this->load->ext_view('modal', 'PaymentSystemCarousel', '', TRUE); ?>
