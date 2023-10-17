<style>


    #fc-offer {
        border: 1px solid #e6e6e6;
        height: auto !important;
        max-height: 280px;
        overflow: auto;
        padding: 10px;
        font-size: 12px;
        width: 100%;
    }
    .content-head-block {
        background-color: #136fd7;
        color: #FFF;
        padding-left: 15px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #fc-offer p{
        font-style: normal;
    }
    #fc-offer li{
        font-size: 15px;
    }
    .btn-main {
        color: #fff;
        background-color: #3d83d2;
        /*border-color: #db3e2b;*/
    }
    .fc-agrr-body{
        margin-bottom: 30px;
    }
    
@media only screen and (min-width: 1001px) and (max-width: 1015px)  {
 .main-tab li a{font-size:16px !important }

}    
</style>
<div id="exTab" class="col-lg-12 col-md-12 int-main-cont">
    <div class="section">
        <div class="acct-tab-holder">
            <ul role="tablist" class="main-tab">
                <li>
                    <a  href="<?=FXPP::my_url('copytrade')?>" id = "tab1">Copytrading</a>
                </li>

                <li>
                    <a href="<?=FXPP::my_url('copytrade/my_subscription')?>" id = "tab2" >My Subscriptions</a>
                </li>

                
            
                <li>
                        <a href="<?=FXPP::my_url('copytrade/rollover-commission')?>" id = "tab6" ><?= lang('trd_277'); ?></a>
                    </li>

                
              
                <li class="active">
                    <a href="<?=FXPP::my_url('copytrade/my_project')?>" id = "tab3" >My Project</a>
                </li>
                <li>
                    <a  href="<?=FXPP::my_url('copytrade/profile')?>" id = "tab4" >Profile</a>
                </li>
                <div class="clearfix"></div>
        </div>


        <div class="tab-content clearfix">

                <p>The system ensures precise computation and accounting of payouts to commissions, as well as real-time account statistics for followers. Both traders and followers can monitor the total amount of payouts credited into their accounts.</p>
                <div class="no-subs" style="display: none;">
                    <h3>You have no active projects</h3>
                </div>
                <div class="myproject-holder clearfix" style="display: none;">

                    <div class="table-responsive">
                        <table class="table tbl-proj">
                            <tbody>
                            <tr>
                                <td rowspan="2"><img src="<?= $this->template->Images()?>copytrade_avatar.png" class="proj-avatar"></td>
                                <td class="tbl-col-myproj text-myproj"><?= lang('reb_txt_9'); ?><span class="myproj-desc proj-title">My Project</span></td>
                                <td class="tbl-col-myproj text-myproj">Account<span class="myproj-desc proj-number">7021457</span></td>
                                <td class="tbl-col-myproj text-myproj">Leverage<span class="myproj-desc proj-leverage">1:</span></td>
                                <td class="tbl-col-myproj text-myproj">Account Type<span class="myproj-desc proj-desc">PAMM</span></td>
                            </tr>
                            <tr>
                                <td class="tbl-col-myproj text-myproj">Rating<span class="myproj-desc proj-rating">9.1</span></td>
                                <td class="tbl-col-myproj text-myproj">Trades<span class="myproj-desc proj-trade">0/64</span></td>
                                <td class="tbl-col-myproj text-myproj">Registered<span class="myproj-desc proj-reg-days">2850 days</span></td>
                                <td class="tbl-col-myproj text-myproj">Investors<span class="myproj-desc proj-investor">0</span></td>
                            </tr>
                             <tr>
                                 <td class="tbl-col-myproj text-myproj"></td>
                                <td class="tbl-col-myproj text-myproj">Balance<span class="myproj-desc proj-balance">9.1</span></td>
                                <td class="tbl-col-myproj text-myproj">Equity<span class="myproj-desc proj-equity">0/64</span></td>
                                 <td class="tbl-col-myproj text-myproj"></td>
                                 <td class="tbl-col-myproj text-myproj"></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

<!--                    <div class="clearfix">-->
<!--                        <div class="trading-style">-->
<!--                            <p>Trading Agression <a href="#">by time</a> | <a href="#">by percentage weight</a></p>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3 col-sm-6 col-xs-6">-->
<!--                            <div class="c100 p7 small">-->
<!--                                <span>7%</span>-->
<!--                                <div class="slice">-->
<!--                                    <div class="bar"></div>-->
<!--                                    <div class="fill"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <span class="agression">Low</span>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3 col-sm-6 col-xs-6">-->
<!--                            <div class="c100 p20 small">-->
<!--                                <span>20%</span>-->
<!--                                <div class="slice">-->
<!--                                    <div class="bar"></div>-->
<!--                                    <div class="fill"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <span class="agression">Medium</span>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3 col-sm-6 col-xs-6">-->
<!--                            <div class="c100 p45 small">-->
<!--                                <span>45%</span>-->
<!--                                <div class="slice">-->
<!--                                    <div class="bar"></div>-->
<!--                                    <div class="fill"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <span class="agression">High</span>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3 col-sm-6 col-xs-6">-->
<!--                            <div class="c100 p60 small">-->
<!--                                <span>60%</span>-->
<!--                                <div class="slice">-->
<!--                                    <div class="bar"></div>-->
<!--                                    <div class="fill"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <span class="agression">Very High</span>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="tbl-profit-wrapper clearfix">-->
<!--                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 gap">-->
<!--                            <div class="table-responsive">-->
<!--                                <table class="table tbl-profit">-->
<!--                                    <tbody>-->
<!--                                    <tr>-->
<!--                                        <td class="tbl-col-profit-1 text-profit">Balance<span class="profit-desc">$9.11</span></td>-->
<!--                                        <td class="tbl-col-profit-2"><i class="fa fa-chevron-up arrow-profit"></i></td>-->
<!--                                        <td class="tbl-col-profit-3 text-profit-small">0.00<span class="profit-desc-small">+9.11</span></td>-->
<!--                                        <td class="tbl-col-profit-4 chart-profit"></td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 gap">-->
<!--                            <div class="table-responsive">-->
<!--                                <table class="table tbl-profit">-->
<!--                                    <tbody>-->
<!--                                    <tr>-->
<!--                                        <td class="tbl-col-profit-1 text-profit">Equity<span class="profit-desc">$9.11</span></td>-->
<!--                                        <td class="tbl-col-profit-2"><i class="fa fa-chevron-up arrow-profit"></i></td>-->
<!--                                        <td class="tbl-col-profit-3 text-profit-small">0.00<span class="profit-desc-small">+9.11</span></td>-->
<!--                                        <td class="tbl-col-profit-4 chart-profit"></td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">-->
<!--                            <div class="table-responsive">-->
<!--                                <table class="table tbl-profit">-->
<!--                                    <tbody>-->
<!--                                    <tr>-->
<!--                                        <td class="tbl-col-profit-1 text-profit">Total Profit<span class="profit-desc">0.00%</span></td>-->
<!--                                        <td class="tbl-col-profit-2"></td>-->
<!--                                        <td class="tbl-col-profit-3 text-profit-small"></td>-->
<!--                                        <td class="tbl-col-profit-4 chart-profit"></td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->

                    <div class="pull-right be-center">
                        <button class="btn btn-investing" id ="unsubscribe_master" type="button">Unsubscribe</button>
                    </div>


                </div>
        </div>
    </div>
</div>
<div id="cpy_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="m_message">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript">
    var url = '<?php echo base_url();?>';


    $(document).ready(function(){

        $('[data-toggle="tooltip"]').tooltip();


        <?php if($is_master){ ?>
        runMyProject();
        <?php }else{ ?>
        $('.no-subs').show();
       <?php } ?>


    });



    function runMyProject(){
        $.ajax({
            type:'POST',
            url:url+'copytrade/my_project_request',
            beforeSend:function(){
                $('#loader-holder').show();
            }
        }).done(function(response){
            console.log(response);
            if(response.is_success) {
                $('.proj-title').html(response.all_master_info.project_name);
                $('.proj-number').html(response.all_master_info.account_number);
                $('.proj-leverage').html(response.all_master_info.leverage);
                $('.proj-desc').html(response.all_master_info.account_type);
                // $('.proj-rating').html(response.all_master_info.rating);
                $('.proj-trade').html(response.all_master_info.trade);
                $('.proj-reg-days').html(response.all_master_info.registration_time);
                // $('.proj-investor').html(response.all_master_info.investor);
                $('.proj-equity').html(response.all_master_info.equity);
                $('.proj-balance').html(response.all_master_info.balance);

                $('.myproject-holder').show();
                $('.myproject-trader-reg').hide()
            }else{
                $('.myproject-trader-reg').show();
                $('.myproject-holder').hide();
                //$('#project_name').val(response.all_master_info.name);
            }
            $('#loader-holder').hide();

        });
    }

</script>