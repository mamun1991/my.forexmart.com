<?php foreach($trader_list as $key => $trader_value){?>

<?php if(in_array($trader_value['StatusId'],array(1,2)) ){
    $total_2 = $total_2 + 1;
    ?>
    <tr class="tr_id_<?= $trader_value['ConnectionId']?>">
        <td>
            <?= $trader_value['ConnectionId']?>
        </td>
        <td>
            <a href="<?= FXPP::my_url('copytrade/monitor_user/'. $trader_value['Trader']);?>"><?= $trader_value['Trader']?></a><br>
            <!--<span >Rollover:&nbsp;<font color="black"><?//= $f_value['RollOver']?></font> USD</span> <br>-->
            <span >Balance:&nbsp;<font color="black"><?= $trader_value['StartBalance']?> <?= $trader_value['Currency']?> </font></span>
        <td> <?= $trader_value['CreateTime']?> </td>
        <td><?= $trader_value['LastModify']?> </td>
        <td><span title="" class="toltip-help" data-original-title="Approved"><?= $trader_value['StatusDesc']?></span></td>
           
      
            
             <td><?= $trader_value['PendingRollOver']?></td>
        
     
        
        <td>
            <div class="row">
                <div class="col-xs-12">
                    <?php if($trader_value['StatusId'] == 1){ ?>
                        
                           <input type="button" class="btn btn-xs btn-danger" onclick="unsubscribe_account(<?= $trader_value['ConnectionId']?>, 1,<?= $trader_value['Trader']?>,<?= $trader_value['Follower']?>,<?= $trader_value['PendingRollOver']?>)" value="Cancel">
                           <!-- <input type="button" class="btn btn-xs btn-danger" onclick="reject_account(<?//= $trader_value['ConnectionId']?>,1,<?//= $trader_value['Trader']?>,<?//= $trader_value['Follower']?>)" value="Cancel">-->
                        
                    <?php }else{ ?>
                        <input type="button" class="btn btn-xs btn-danger" onclick="unsubscribe_account(<?= $trader_value['ConnectionId']?>, 5,<?= $trader_value['Trader']?>,<?= $trader_value['Follower']?>,<?= $trader_value['PendingRollOver']?>)" value="Unsubscribe">
                    <?php } ?>

                    <div style="height: 2px"></div>
                </div>
            </div>
            <div id="buttons_conn_t_c_463381" class="row">
                <div class="content-delimetr-form"></div>
                <div class="col-xs-12">
                    <input type="hidden" value="false" id="tr-condition-<?= $trader_value['ConnectionId']?>">
                    <a class="fa fa-gears  tooltip-help" style="cursor: pointer;" onclick="show_conditions(<?= $trader_value['ConnectionId']?>)" id="button_conditions_<?= $trader_value['ConnectionId']?>" data-toggle="tooltip" data-placement="top" title="Copy settings"></a>
                    <input type="hidden" value="false" id="tr-terms-<?= $trader_value['ConnectionId']?>">
                    <a style="cursor: pointer;"  onclick="show_terms(<?= $trader_value['Trader']?>,<?= $trader_value['ConnectionId']?>,<?= $trader_value['Follower']?>)"  class=" tooltip-help fa fa-search-plus" data-toggle="tooltip" data-placement="top" title="Commission settings"></a>
                    <input type="hidden" value="false" id="tr-trades-<?= $trader_value['ConnectionId']?>">
                    <a style="cursor: pointer;"  href="javascript:void(0)" onclick="trades_toggle(<?= $trader_value['ConnectionId']?>)" class=" tooltip-help fa fa-file-text" data-toggle="tooltip" data-placement="top" title="Trades history"> </a>
                        <!--<input type="hidden" value="false" id="tr-commission-<?//= $trader_value['ConnectionId']?>">-->
                        <?php// if($trader_value['CopyTermsKey']['dailyKey']){ ?>
                           <!-- <a href="javascript:void(0)" onclick="commission_toggle(<?//= $trader_value['ConnectionId']?>,1)" class=" tooltip-help  fa fa-usd" title="" data-original-title="Commission History"> </a>-->
                        <?php //}else{ ?>
                           <!-- <a href="javascript:void(0)" onclick="commission_toggle(<?//= $trader_value['ConnectionId']?>,2)" class=" tooltip-help  fa fa-usd" title="" data-original-title="Commission History"> </a>-->
                        <?php  //} ?>
                        <?php //if($trader_value['CopyTermsKey']['percentKey']){?>
                            <!--<input type="hidden" value="false" id="tr-pending-rollovers-<?//= $trader_value['ConnectionId']?>">-->
                            <!--<a href="javascript:void(0)" onclick="pendingRollovers(<?//= $trader_value['ConnectionId']?>)" class=" tooltip-help fa fa-history" title="" data-original-title="Pending Commission"> </a>-->
                        <?php //} ?>
                    <!-- <a href="javascript:void(0)"  onclick="rollover(<?//= $trader_value['ConnectionId']?>)" class="tooltip-help fa fa-money" title="" data-original-title="Show the list of rollovers available for this subscription"> </a>-->

                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="8" id="current_trade_<?= $trader_value['ConnectionId']?>" style=" display: none;background-color: white !important; border-top: 0 none; padding-bottom: 19px; padding-left: 2px; padding-right: 2px;">
            <div id="trades-history" style="overflow: hidden; width: 811px;">
                    <!-- Style for secondary Table (open and close trade) -->
                    <ul class="nav nav-pills nav-justified nav-pill-items">
                        <li class="active"><a data-toggle="pill" href="#openTrades_<?= $trader_value['ConnectionId']?>" onclick="SubmitTradesForm(<?= $trader_value['ConnectionId']?>,0)">Open Trades</a></li>
                        <li><a data-toggle="pill" href="#closeTrades_<?= $trader_value['ConnectionId']?>" onclick="SubmitTradesForm(<?= $trader_value['ConnectionId']?>,1)">Close Trades</a></li>
                    </ul>
                    <div class="tab-content tab-custom-content">
                        <div id="openTrades_<?= $trader_value['ConnectionId']?>" class="tab-pane fade in active">
                            <div class="secondary-table">
                                <h3 class="tab-title"><span>Open Trades</span> (ticket details of follower)</h3>

                                    <table id="open_time_<?= $trader_value['ConnectionId']?>" class="table table-striped table-trades open_time_<?= $trader_value['ConnectionId']?>" style="width:1000px;overflow-x: auto;">
                                        <thead>
                                        <tr>
                                            <th class="no-sort first center"><b>Copy Id</b></th>
                                            <th class="no-sort middle center"><b>Status</b></th>
                                            <th class="no-sort middle center"><b>Master Ticket</b></th>
                                            <th class="no-sort middle center"><b>Ticket</b></th>
                                            <th class="no-sort middle center"><b>Symbol</b></th>
                                            <th class="no-sort middle center"><b>Cmd</b></th>
                                            <th class="no-sort middle center"><b>Volume</b></th>
                                            <th class="no-sort middle center"><b>Open Price</b></th>
                                            <th class="no-sort middle center"><b>Close Price</b></th>
                                            <th class="no-sort middle center"><b>Open Time</b></th>
                                            <th class="no-sort middle center"><b>Close Time</b></th>
                                            <th class="no-sort middle center"><b>SL</b></th>
                                            <th class="no-sort middle center"><b>TP</b></th>
                                            <th class="no-sort last center"><b>Profit</b></th>
                                        </tr>
                                        </thead>
                                        <tbody id="Open_Trade_<?= $trader_value['ConnectionId']?>">

                                        </tbody>
                                    </table>

                            </div>
                        </div>
                        <div id="closeTrades_<?= $trader_value['ConnectionId']?>" class="tab-pane fade">
                            <div class="secondary-table">
                                <h3 class="tab-title"><span>Close Trades</span> (ticket details of follower)</h3>
                               
                                    <table id="close_time_<?= $trader_value['ConnectionId']?>" class="table table-striped table-trades close_time_<?= $trader_value['ConnectionId']?>" style="width:1000px;overflow-x: auto;">
                                        <thead>
                                        <tr>
                                            <th class="no-sort first center"><b>Copy Id</b></th>
                                            <th class="no-sort middle center"><b>Status</b></th>
                                            <th class="no-sort middle center"><b>Master Ticket</b></th>
                                            <th class="no-sort middle center"><b>Ticket</b></th>
                                            <th class="no-sort middle center"><b>Symbol</b></th>
                                            <th class="no-sort middle center"><b>Cmd</b></th>
                                            <th class="no-sort middle center"><b>Volume</b></th>
                                            <th class="no-sort middle center"><b>Open Price</b></th>
                                            <th class="no-sort middle center"><b>Close Price</b></th>
                                            <th class="no-sort middle center"><b>Open Time</b></th>
                                            <th class="no-sort middle center"><b>Close Time</b></th>
                                            <th class="no-sort middle center"><b>SL</b></th>
                                            <th class="no-sort middle center"><b>TP</b></th>
                                            <th class="no-sort middle center"><b>Profit</b></th>
                                            <?php if($commissionType != 4){ ?>
                                                <th class="no-sort last center"><b>Trader's Commission</b></th>
                                            <?php } ?>
                                        </tr>
                                        </thead>
                                        <tbody  id="Close_Trade_<?= $trader_value['ConnectionId']?>">

                                        </tbody>
                                    </table>

                            </div>
                        </div>
                    </div>
                    <!-- end of style-->

           </div>

            <div id="div-rollover-profit-<?=$trader_value['ConnectionId']?>" style="margin-left:20px; margin-top:15px; text-align:left; display:none;">
                <b><span>Trader’s current rollover: </span><span id="total-rollover-profit-<?=$trader_value['ConnectionId']?>"></span></b>
            </div>

            <div id="div-total-profit-<?=$trader_value['ConnectionId']?>" style="margin-left:20px; margin-top:15px; text-align:left; display:none;">
                <b><span>Trader’s total profit: </span><span id="total-profit-<?=$trader_value['ConnectionId']?>"></span></b>
            </div>

        </td>
        <td colspan="6" id="loader_current_trade_<?= $trader_value['ConnectionId']?>"  style="display:none" >
            <img src="<?=$this->template->Images()?>ajax-loader-long.gif">
        </td>
    </tr>
    <tr>

        <td colspan="6" id="commission_history_<?= $trader_value['ConnectionId']?>" style=" display: none;background-color: white !important; border-top: 0 none; padding-bottom: 19px; padding-left: 2px; padding-right: 2px;">
            <div style="text-align: left; margin-bottom: 5px; border-bottom: 1px solid #BBB5B7; width: 100.6%; background-color: #e3e3e3; margin-left: -2px;">
           <?php if($trader_value['CopyTermsKey']['dailyKey']){ ?>
               <input type="hidden" value="1" id ="commission_time_type_<?= $trader_value['ConnectionId']?>">
           <?php }else{ ?>
               <input type="hidden" value="2" id ="commission_time_type_<?= $trader_value['ConnectionId']?>">
           <?php  } ?>
            </div>
            <table class="tPresentation table-responsive table  table-striped  commission_daily commission_daily_<?= $trader_value['ConnectionId']?>" style="width: 100%; padding-top: 5px; padding-bottom: 5px;  display:none" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td colspan="8"> <center><b>Daily Commission</b></center></td>
                </tr>
                </tr>
                <tr>
                    <th class="first center"><b>Commission Processed Time</b></th>
                    <th class="middle center"><b>FollowerPay Ticket</b></th>
                    <th class="middle center"><b>TraderPay Ticket</b></th>
                </tr>
                </thead>
                <tbody id="commission_daily_tbody_<?= $trader_value['ConnectionId']?>">

                </tbody>
            </table>


            <table class="tPresentation table-responsive table  table-striped  commission_per_trade commission_per_trade_<?= $trader_value['ConnectionId']?>" style="width: 100%; padding-top: 5px; display:none" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td colspan="7"><center><b>Commission Per Trade</b></center></td>
                </tr>
                <tr>
                    <th class="first center"><b>Commission Processed Time</b></th>
                    <th class="middle center"><b>Follower Amount</b></th>
                    <th class="middle center"><b>Trader Amount</b></th>
                    <th class="middle center"><b>Follower Copied Ticket</b></th>
                    <th class="middle center"><b>Trader Copied Ticket</b></th>
                    <th class="middle center"><b>FollowerPay Ticket</b></th>
                    <th class="last center"><b>TraderPay Ticket</b></th>
                </tr>
                </thead>
                <tbody  id="commission_per_trade_tbody_<?= $trader_value['ConnectionId']?>">
                </tbody>
            </table>
        </td>

    </tr>
    <tr>
        <td colspan="6" id="pending_rollovers_<?= $trader_value['ConnectionId']?>" style=" display: none;background-color: white !important; border-top: 0 none; padding-bottom: 19px; padding-left: 2px; padding-right: 2px;">

            <table class="tPresentation table-responsive table  table-striped  pending_rollovers pending_rollovers_table_<?= $trader_value['ConnectionId']?>" style="width: 100%; padding-top: 5px; padding-bottom: 5px;  display:none" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <td colspan="6"> <center><b>Pending Rollovers</b></center></td>
                </tr>
                <tr>
                    <th class="first center"><b>CopiedTrades Id</b></th>
                    <th class="middle center"><b>Commission Id</b></th>
                    <th class="middle center"><b>Follower Amount</b></th>
                    <th class="middle center"><b>Trader Amount</b></th>
                    <th class="middle center"><b>Follower Copied Ticket</b></th>
                    <th class="last center"><b>Trader Copied Ticket</b></th>
                </tr>
                </thead>
                <tbody id="pending_rollovers_tbody_<?= $trader_value['ConnectionId']?>">

                </tbody>
            </table>
        </td>
        <td colspan="6" id="loader_pending_rollovers_<?= $trader_value['ConnectionId']?>"  style="display:none" >
            <img src="<?=$this->template->Images()?>ajax-loader-long.gif">
        </td>
    </tr>
    <tr id="">

        <td colspan="6" class="f_condition_<?= $trader_value['ConnectionId']?>" id="" style="display: none;">
            <div style="text-align: center; font-size: 15px">Copying terms:</div>
            <form method="post" id="updatesetting-form-<?= $trader_value['ConnectionId']?>">
                <input type="hidden" name="connection_id" id= "con_id_<?= $trader_value['ConnectionId']?>" value="">

                <table cellpadding="0" cellspacing="4" class="well">
                    <tbody>
                    <tr>
                        <td width="50%" rowspan="2" class="well" style="vertical-align: baseline; padding: 19px;">
                            <!-- Валютные пары для выбранные для копирования -->
                            <center>Choose instruments to copy:</center>
                            <table cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td width="250">All ForexMart trading instruments:</td>
                                    <td class="center" style="padding-left: 10px;"><input type="radio" name="copy_settings_values_1"  id="copy_settings_values_1_1_<?= $trader_value['ConnectionId']?>" value="1" checked onclick="ResetCheckbox(<?= $trader_value['ConnectionId']?>)"></td>
                                </tr>
                                <tr>
                                    <td>Major currency pairs (EURUSD, USDJPY, GBPUSD, USDCHF):</td>
                                    <td class="center" style="padding-left: 10px;"><input type="radio" name="copy_settings_values_1" id="copy_settings_values_1_2_<?= $trader_value['ConnectionId']?>" value="2" onclick="ResetCheckbox(<?= $trader_value['ConnectionId']?>)"></td>
                                </tr>
                                <tr>
                                    <td style="">Choose manually:</td>
                                    <td class="center" style="padding-left: 10px;">
                                        <input type="radio"  name="copy_settings_values_1" id="copy_settings_values_1_3_<?= $trader_value['ConnectionId']?>"  value="-1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" class="w100" id="i-quotes-list_<?= $trader_value['ConnectionId']?>">
                                            <tbody><tr>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="4" id="qoute_4_<?= $trader_value['ConnectionId']?>"  onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/USD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="8" id="qoute_8_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">GBP/USD</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="16" id="qoute_16_<?= $trader_value['ConnectionId']?>"  onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/JPY</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="32" id="qoute_32_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/CHF</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="64" id="qoute_64_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">USD/CAD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="128" id="qoute_128_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">AUD/USD</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="256" id="qoute_256_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">NZD/USD</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="512" id="qoute_512_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/JPY</td>
                                            </tr><tr>
                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="1024" id="qoute_1024_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/CHF</td>

                                                <td>
                                                    <input type="checkbox" class="check_quotes" name="quotes[]" value="2048" id="qoute_2048_<?= $trader_value['ConnectionId']?>" onclick="CheckedReset(<?= $trader_value['ConnectionId']?>)">
                                                </td>
                                                <td style="padding-right:0px; width:120px">EUR/GBP</td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody></table>
                            <!-- /Валютные пары для выбранные для копирования -->
                        </td>

                        <td class="well">
                            <!-- Масштаб копирования -->
                            Copying ratio:
                            <table cellpadding="0" class="center w100" id="copy_setting_table_<?= $trader_value['ConnectionId']?>">
                                <tbody>
                                <tr>
                                    <td style="padding-right: 23px; text-align:center;padding-top: 10px;padding-bottom: 10px;">
                                        <input type="hidden" style="width: 137px;display:inline-block;" class="form-control" name="copy_settings_2_default" id="copy_settings_2_default_<?= $trader_value['ConnectionId']?>" value="0.01">

                                        <input type="number" style="width: 137px;display:inline-block;" class="form-control" name="copy_settings_values_2" id="copy_settings_values_2_<?= $trader_value['ConnectionId']?>" value="0.01" step=".01" min=".01" max="1000"  onchange="CalculateRatio(this.value,<?= $trader_value['ConnectionId']?>)">
                                    </td>
                                </tr>
                                <tr>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2"><span id="all_text_<?= $trader_value['ConnectionId']?>">If a trader opens a 1  lot deal, you will get a 0.5 lot deal copied to your account</span>.
                                        <div style="display: none; color: red" id="eu_warning">The Company does not recommend increasing the ratio of the copied lots:<br>
                                            Changing the copying ratio affects the lot size.<br>
                                            Increasing the ratio of the copied lots leads to increased marginal requirements, and vice versa.</div></td>
                                </tr>
                                <!-- /Масштаб копирования -->
                                <!-- Кол-во сделок для копирования -->
                                <!-- /Кол-во сделок для копирования -->
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td class="well" height="50%">
                            <center>
                                Daily copying limit:			</center>
                            <table class="center w100">
                                <tbody><tr>
                                    <td width="180px">
                                        Choose the number<br> of trades:                    </td>

                                    <td style="padding-right: 23px; text-align:center;">
                                        <select style="width: 120px;" class="form-control" name="copy_settings_values_3" id="copy_settings_values_3_<?= $trader_value['ConnectionId']?>" onchange="ResetSelectCopy(<?= $trader_value['ConnectionId']?>)">
                                            <option value="0" selected="selected">All</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        You copy <span id="traider_copy_deals_<?= $trader_value['ConnectionId']?>"> all deals</span> of a Copytrading trader.
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: left; border: none;" class="well">
                            <span  style="float: left; margin-right: 8px; height: 35px;"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                            <div>The advanced settings of subscription to copying positions of the Copytrading traders are designed for skilled Copytrading followers and allow fine adjusting the subscription parameters.</div>
                            <div style="float: right">
                                <a onclick="ShowHideSettings(<?= $trader_value['ConnectionId']?>)">
                                    <label for="adv_settings" id="set_view_<?= $trader_value['ConnectionId']?>" style="cursor: pointer;">Hide settings</label>
                                </a>
                            </div>
                            <input type="checkbox" name="use_adv_settings" id="adv_settings_<?= $trader_value['ConnectionId']?>" style="display:none">
                        </td>
                    </tr>
                    <tr id="advanced_settings_<?= $trader_value['ConnectionId']?>" style="">
                        <td colspan="2" style="text-align: left; border: none;" class="well">
                            <div class="simple-wnd">
                                <div>Set the lot range:</div>
                                <div id="advanced_settings_select">
                                    <select class="form-control" style="width: 200px;" name="limited_or_fixed" id="limited_or_fixed_<?= $trader_value['ConnectionId']?>" onchange="LimitOrFixed($(this).val(),<?= $trader_value['ConnectionId']?>)">
                                        <option value="0">Lot range</option>
                                        <option value="1">Fixed lot</option>
                                    </select>
                                </div>
                                <div id="limited_lots_holder_<?= $trader_value['ConnectionId']?>">
                                    <div>
                                        <div style="width: 50%; float:left">By using lot range feature, you will copy all the positions from Copytrading trader’s account within the selected diapason chosen by you in the settings.</div>
                                        <div style="width: 48%; float:right;">
                                            <div class="row">
                                                <div class="col-md-5" style="padding: 1px 10px!important;">Min lot:</div>
                                                <div class="col-md-5" style="padding: 3px;">
                                                    <select name="min_lot_open" id="min_lot_open_<?= $trader_value['ConnectionId']?>" class="form-control" onchange="SetLimit(<?= $trader_value['ConnectionId']?>)" style="">
                                                        <option value="0.01">
                                                            0.01                                                         lot deal                                                    </option>
                                                        <option value="0.02">
                                                            0.02                                                         lot deal                                                    </option>
                                                        <option value="0.03">
                                                            0.03                                                         lot deal                                                    </option>
                                                        <option value="0.04">
                                                            0.04                                                         lot deal                                                    </option>
                                                        <option value="0.05">
                                                            0.05                                                         lot deal                                                    </option>
                                                        <option value="0.06">
                                                            0.06                                                         lot deal                                                    </option>
                                                        <option value="0.07">
                                                            0.07                                                         lot deal                                                    </option>
                                                        <option value="0.08">
                                                            0.08                                                         lot deal                                                    </option>
                                                        <option value="0.09">
                                                            0.09                                                         lot deal                                                    </option>
                                                        <option value="0.1">
                                                            0.1                                                         lot deal                                                    </option>
                                                        <option value="0.2">
                                                            0.2                                                         lot deal                                                    </option>
                                                        <option value="0.3">
                                                            0.3                                                         lot deal                                                    </option>
                                                        <option value="0.4">
                                                            0.4                                                         lot deal                                                    </option>
                                                        <option value="0.5">
                                                            0.5                                                         lot deal                                                    </option>
                                                        <option value="0.6">
                                                            0.6                                                         lot deal                                                    </option>
                                                        <option value="0.7">
                                                            0.7                                                         lot deal                                                    </option>
                                                        <option value="0.8">
                                                            0.8                                                         lot deal                                                    </option>
                                                        <option value="0.9">
                                                            0.9                                                         lot deal                                                    </option>
                                                        <option value="1">
                                                            1                                                         lot deal                                                    </option>
                                                        <option value="2">
                                                            2                                                         lot deal                                                    </option>
                                                        <option value="3">
                                                            3                                                         lot deal                                                    </option>
                                                        <option value="4">
                                                            4                                                         lot deal                                                    </option>
                                                        <option value="5">
                                                            5                                                         lots deal                                                    </option>
                                                        <option value="6">
                                                            6                                                         lots deal                                                    </option>
                                                        <option value="7">
                                                            7                                                         lots deal                                                    </option>
                                                        <option value="8">
                                                            8                                                         lots deal                                                    </option>
                                                        <option value="9">
                                                            9                                                         lots deal                                                    </option>
                                                        <option value="10">
                                                            10                                                         lots deal                                                    </option>
                                                        <option value="15">
                                                            15                                                         lots deal                                                    </option>
                                                        <option value="20">
                                                            20                                                         lots deal                                                    </option>
                                                        <option value="25">
                                                            25                                                         lots deal                                                    </option>
                                                        <option value="30">
                                                            30                                                         lots deal                                                    </option>
                                                        <option value="35">
                                                            35                                                         lots deal                                                    </option>
                                                        <option value="40">
                                                            40                                                         lots deal                                                    </option>
                                                        <option value="45">
                                                            45                                                         lots deal                                                    </option>
                                                        <option value="50">
                                                            50                                                         lots deal                                                    </option>
                                                        <option value="55">
                                                            55                                                         lots deal                                                    </option>
                                                        <option value="60">
                                                            60                                                         lots deal                                                    </option>
                                                        <option value="65">
                                                            65                                                         lots deal                                                    </option>
                                                        <option value="70">
                                                            70                                                         lots deal                                                    </option>
                                                        <option value="75">
                                                            75                                                         lots deal                                                    </option>
                                                        <option value="80">
                                                            80                                                         lots deal                                                    </option>
                                                        <option value="85">
                                                            85                                                         lots deal                                                    </option>
                                                        <option value="90">
                                                            90                                                         lots deal                                                    </option>
                                                        <option value="95">
                                                            95                                                         lots deal                                                    </option>
                                                        <option value="100">
                                                            100                                                         lots deal                                                    </option>
                                                        <option value="200">
                                                            200                                                         lots deal                                                    </option>
                                                        <option value="300">
                                                            300                                                         lots deal                                                    </option>
                                                        <option value="400">
                                                            400                                                         lots deal                                                    </option>
                                                        <option value="500">
                                                            500                                                         lots deal                                                    </option>
                                                        <option value="600">
                                                            600                                                         lots deal                                                    </option>
                                                        <option value="700">
                                                            700                                                         lots deal                                                    </option>
                                                        <option value="800">
                                                            800                                                         lots deal                                                    </option>
                                                        <option value="900">
                                                            900                                                         lots deal                                                    </option>
                                                        <option value="1000">
                                                            1000                                                         lots deal                                                    </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 48%; float:right">
                                            <div class="row">
                                                <div class="col-md-5" style="padding: 1px 10px!important;margin-top:-3px;">Max lot:</div>
                                                <div class="col-md-5" style="padding: 3px;">
                                                    <select name="max_lot_open" id="max_lot_open_<?= $trader_value['ConnectionId']?>" class="form-control" onchange="SetLimit(<?= $trader_value['ConnectionId']?>)">
                                                        <option value="0.01">
                                                            0.01                                                         lot deal                                                    </option>
                                                        <option value="0.02">
                                                            0.02                                                         lot deal                                                    </option>
                                                        <option value="0.03">
                                                            0.03                                                         lot deal                                                    </option>
                                                        <option value="0.04">
                                                            0.04                                                         lot deal                                                    </option>
                                                        <option value="0.05">
                                                            0.05                                                         lot deal                                                    </option>
                                                        <option value="0.06">
                                                            0.06                                                         lot deal                                                    </option>
                                                        <option value="0.07">
                                                            0.07                                                         lot deal                                                    </option>
                                                        <option value="0.08">
                                                            0.08                                                         lot deal                                                    </option>
                                                        <option value="0.09">
                                                            0.09                                                         lot deal                                                    </option>
                                                        <option value="0.1">
                                                            0.1                                                         lot deal                                                    </option>
                                                        <option value="0.2">
                                                            0.2                                                         lot deal                                                    </option>
                                                        <option value="0.3">
                                                            0.3                                                         lot deal                                                    </option>
                                                        <option value="0.4">
                                                            0.4                                                         lot deal                                                    </option>
                                                        <option value="0.5">
                                                            0.5                                                         lot deal                                                    </option>
                                                        <option value="0.6">
                                                            0.6                                                         lot deal                                                    </option>
                                                        <option value="0.7">
                                                            0.7                                                         lot deal                                                    </option>
                                                        <option value="0.8">
                                                            0.8                                                         lot deal                                                    </option>
                                                        <option value="0.9">
                                                            0.9                                                         lot deal                                                    </option>
                                                        <option value="1">
                                                            1                                                         lot deal                                                    </option>
                                                        <option value="2">
                                                            2                                                         lot deal                                                    </option>
                                                        <option value="3">
                                                            3                                                         lot deal                                                    </option>
                                                        <option value="4">
                                                            4                                                         lot deal                                                    </option>
                                                        <option value="5">
                                                            5                                                         lots deal                                                    </option>
                                                        <option value="6">
                                                            6                                                         lots deal                                                    </option>
                                                        <option value="7">
                                                            7                                                         lots deal                                                    </option>
                                                        <option value="8">
                                                            8                                                         lots deal                                                    </option>
                                                        <option value="9">
                                                            9                                                         lots deal                                                    </option>
                                                        <option value="10">
                                                            10                                                         lots deal                                                    </option>
                                                        <option value="15">
                                                            15                                                         lots deal                                                    </option>
                                                        <option value="20">
                                                            20                                                         lots deal                                                    </option>
                                                        <option value="25">
                                                            25                                                         lots deal                                                    </option>
                                                        <option value="30">
                                                            30                                                         lots deal                                                    </option>
                                                        <option value="35">
                                                            35                                                         lots deal                                                    </option>
                                                        <option value="40">
                                                            40                                                         lots deal                                                    </option>
                                                        <option value="45">
                                                            45                                                         lots deal                                                    </option>
                                                        <option value="50">
                                                            50                                                         lots deal                                                    </option>
                                                        <option value="55">
                                                            55                                                         lots deal                                                    </option>
                                                        <option value="60">
                                                            60                                                         lots deal                                                    </option>
                                                        <option value="65">
                                                            65                                                         lots deal                                                    </option>
                                                        <option value="70">
                                                            70                                                         lots deal                                                    </option>
                                                        <option value="75">
                                                            75                                                         lots deal                                                    </option>
                                                        <option value="80">
                                                            80                                                         lots deal                                                    </option>
                                                        <option value="85">
                                                            85                                                         lots deal                                                    </option>
                                                        <option value="90">
                                                            90                                                         lots deal                                                    </option>
                                                        <option value="95">
                                                            95                                                         lots deal                                                    </option>
                                                        <option value="100">
                                                            100                                                         lots deal                                                    </option>
                                                        <option value="200">
                                                            200                                                         lots deal                                                    </option>
                                                        <option value="300">
                                                            300                                                         lots deal                                                    </option>
                                                        <option value="400">
                                                            400                                                         lots deal                                                    </option>
                                                        <option value="500">
                                                            500                                                         lots deal                                                    </option>
                                                        <option value="600">
                                                            600                                                         lots deal                                                    </option>
                                                        <option value="700">
                                                            700                                                         lots deal                                                    </option>
                                                        <option value="800">
                                                            800                                                         lots deal                                                    </option>
                                                        <option value="900">
                                                            900                                                         lots deal                                                    </option>
                                                        <option value="1000" selected="selected">
                                                            1000                                                         lots deal                                                    </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div style="margin-top: 5px;">The volume of all trades opened on your account is limited to <span id="min_<?= $trader_value['ConnectionId']?>">0.01                                                         lot deal</span> – <span id="max_<?= $trader_value['ConnectionId']?>">1000                                                         lots deal</span>.</div>
                                    <div>
                                        <div style="float: left;">
                                            <input style="margin: 2px 0 0;" type="checkbox" name="dont_copy" id="dont_copy_<?= $trader_value['ConnectionId']?>" onclick="CheckDontCopy(<?= $trader_value['ConnectionId']?>)">&nbsp;&nbsp;
                                        </div>
                                        <div>
                                            Don’t copy trades of bigger or smaller volume than set.
                                                            <span style="margin-top:-6px;" title="" class="tooltip-help" data-original-title="In case it is unchecked, the volume of all trades copied from the Copytrading trader account and exceeding set parameters will be limited to max and min lot size.">
   <i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="fixed_lot_holder_<?= $trader_value['ConnectionId']?>" style="display: none">
                                    <div style="width: 50%; float:left">By using fixed lot feature, you will copy all the positions from Copytrading trader’s account specified by you in the lot settings.</div>
                                    <div style="width: 48%; float:right">
                                        <div style="float: left;">Fixed lot:</div>
                                        <div style="float: right; margin-right: 40px; margin-top: -4px;">
                                            <select name="fixed_lot" id="fixed_lot_<?= $trader_value['ConnectionId']?>" class="form-control" onchange="SetFixedLot(<?= $trader_value['ConnectionId']?>)">
                                                <option value="0.01">
                                                    0.01                                                     lot deal                                                </option>
                                                <option value="0.02">
                                                    0.02                                                     lot deal                                                </option>
                                                <option value="0.03">
                                                    0.03                                                     lot deal                                                </option>
                                                <option value="0.04">
                                                    0.04                                                     lot deal                                                </option>
                                                <option value="0.05">
                                                    0.05                                                     lot deal                                                </option>
                                                <option value="0.06">
                                                    0.06                                                     lot deal                                                </option>
                                                <option value="0.07">
                                                    0.07                                                     lot deal                                                </option>
                                                <option value="0.08">
                                                    0.08                                                     lot deal                                                </option>
                                                <option value="0.09">
                                                    0.09                                                     lot deal                                                </option>
                                                <option value="0.1">
                                                    0.1                                                     lot deal                                                </option>
                                                <option value="0.2">
                                                    0.2                                                     lot deal                                                </option>
                                                <option value="0.3">
                                                    0.3                                                     lot deal                                                </option>
                                                <option value="0.4">
                                                    0.4                                                     lot deal                                                </option>
                                                <option value="0.5">
                                                    0.5                                                     lot deal                                                </option>
                                                <option value="0.6">
                                                    0.6                                                     lot deal                                                </option>
                                                <option value="0.7">
                                                    0.7                                                     lot deal                                                </option>
                                                <option value="0.8">
                                                    0.8                                                     lot deal                                                </option>
                                                <option value="0.9">
                                                    0.9                                                     lot deal                                                </option>
                                                <option value="1" selected="selected">
                                                    1                                                     lot deal                                                </option>
                                                <option value="2">
                                                    2                                                     lot deal                                                </option>
                                                <option value="3">
                                                    3                                                     lot deal                                                </option>
                                                <option value="4">
                                                    4                                                     lot deal                                                </option>
                                                <option value="5">
                                                    5                                                     lots deal                                                </option>
                                                <option value="6">
                                                    6                                                     lots deal                                                </option>
                                                <option value="7">
                                                    7                                                     lots deal                                                </option>
                                                <option value="8">
                                                    8                                                     lots deal                                                </option>
                                                <option value="9">
                                                    9                                                     lots deal                                                </option>
                                                <option value="10">
                                                    10                                                     lots deal                                                </option>
                                                <option value="15">
                                                    15                                                     lots deal                                                </option>
                                                <option value="20">
                                                    20                                                     lots deal                                                </option>
                                                <option value="25">
                                                    25                                                     lots deal                                                </option>
                                                <option value="30">
                                                    30                                                     lots deal                                                </option>
                                                <option value="35">
                                                    35                                                     lots deal                                                </option>
                                                <option value="40">
                                                    40                                                     lots deal                                                </option>
                                                <option value="45">
                                                    45                                                     lots deal                                                </option>
                                                <option value="50">
                                                    50                                                     lots deal                                                </option>
                                                <option value="55">
                                                    55                                                     lots deal                                                </option>
                                                <option value="60">
                                                    60                                                     lots deal                                                </option>
                                                <option value="65">
                                                    65                                                     lots deal                                                </option>
                                                <option value="70">
                                                    70                                                     lots deal                                                </option>
                                                <option value="75">
                                                    75                                                     lots deal                                                </option>
                                                <option value="80">
                                                    80                                                     lots deal                                                </option>
                                                <option value="85">
                                                    85                                                     lots deal                                                </option>
                                                <option value="90">
                                                    90                                                     lots deal                                                </option>
                                                <option value="95">
                                                    95                                                     lots deal                                                </option>
                                                <option value="100">
                                                    100                                                     lots deal                                                </option>
                                                <option value="200">
                                                    200                                                     lots deal                                                </option>
                                                <option value="300">
                                                    300                                                     lots deal                                                </option>
                                                <option value="400">
                                                    400                                                     lots deal                                                </option>
                                                <option value="500">
                                                    500                                                     lots deal                                                </option>
                                                <option value="600">
                                                    600                                                     lots deal                                                </option>
                                                <option value="700">
                                                    700                                                     lots deal                                                </option>
                                                <option value="800">
                                                    800                                                     lots deal                                                </option>
                                                <option value="900">
                                                    900                                                     lots deal                                                </option>
                                                <option value="1000">
                                                    1000                                                     lots deal                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div style="clear:both"></div>
                                    <div style="margin-top: 5px;">All the trades on your account are opened within <span id="fixed_lot_span_<?= $trader_value['ConnectionId']?>">1</span> lot.</div>
                                </div>
                            </div>
                            <div class="simple-wnd" style="margin-top: 5px;">
                                <div>
                                    Options copying:<br>
                                    The options bought on the Copytrading trader’s account are automatically copied to your trading account.<br>
                                </div>
                                <div>
                                    <div style="float: left;">
                                        <input style="margin: 2px 0 0;" type="checkbox" name="copy_options"   id="copy_options_<?= $trader_value['ConnectionId']?>"  onclick="CheckCopyOption(<?= $trader_value['ConnectionId']?>)">&nbsp;&nbsp;
                                    </div>
                                    <div>
                                        Copy options from this Copytrading trader’s account.
                                                        <span style="margin-top:-6px;" title="" class="tooltip-help" data-original-title="All the copied options will be displayed on the pages Current Trades and History of Trades  of the section My trading in your Client Cabinet.
- Upon early cancellation of an option by a Copytrading trader, the option will also be cancelled on your account. However, 10% of the option’s value will be charged.
- If the balance is insufficient, the option will not be copied to the Copytrading follower’s account.
- Options are copied based on the copying ratio. Thus, if the ratio is 1:2, a Copytrading trader’s option of a $10 value will be copied to your account as an option of a $20 value.
- Option’s minimum nominal value is $1, maximum - $1,000. If the option does not comply with these requirements, the closest nominal value will be used for copying.
- Selective restrictions on the instruments for copying do not apply to the options."><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="simple-wnd" style="margin-top: 5px;">
                                <div>
                                    Inverse copying:<br>
                                </div>
                                <div>
                                    <div style="float: left;">
                                        <input style="margin: 2px 0 0;" type="checkbox" name="copy_inverse" id="copy_inverse_<? $trader_value['ConnectionId']?>"  onclick="CheckCopyInverse(<? $trader_value['ConnectionId']?>)"> &nbsp;&nbsp;
                                    </div>
                                    <div>
                                        Copy the trades opposite to those opened on Copytrading trader’s account.
                                                        <span style="margin-top:-6px;" title="" class="tooltip-help" data-original-title="By activating the inverse copying option, a Copytrading follower will trigger copying of the trades opposite to those opened by a Copytrading trader. Thus, BUY deals opened by a Copytrading trader will be copied as SELL deals to the follower’s account, whereas SELL deals will be copied as BUY deals. The new settings will be applied to the newly opened trades only (not the current ones) right after the activation.">
      <i class="fa fa-question-circle" aria-hidden="true"></i>
    </span>
                                    </div>
                                </div>
                            </div>-->

                        </td>
                    </tr>
                    </tbody></table>


                <center>
                    <input type="button" class="btn btn-main"  onclick="updateSetting(<?= $trader_value['ConnectionId']?>,<?= $trader_value['Trader']?>,<?= $trader_value['Follower']?>)" value="Edit">
                </center>
            </form>
        </td>

        <td colspan="6" class="f_loader_condition_<?= $trader_value['ConnectionId']?>"  style="display:none" >
            <img src="<?=$this->template->Images()?>ajax-loader-long.gif">
        </td>


    </tr>
    <tr class="default_none" style="display:none">
        <td colspan="6" class="center">
            <img src="<?=$this->template->Images()?>ajax-loader-long.gif">
        </td>
    </tr>

<?php }}?>


<script>
    $(document).ready(function(){


        $('.tooltip-help_predelay').tooltip({
            offset: [10, 2],
            predelay: 1000
        });


        $('.tooltip-help').tooltip({
            offset: [10, 2]
        });

        $('.tooltip-help2').tooltip({
            offset: [10, 2]
        });



        $('[data-toggle="tooltip"]').tooltip();

    });

</script>