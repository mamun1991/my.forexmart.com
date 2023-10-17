<?php $this->lang->load('datatable');?>
<div class="pamm-onclick-page destination-class" id="pamm-div-trader">
    <?=$nav;?>
    <div id="my-tab-content" class="tab-content pamm-tab-content">
            <style>
                .table-responsive {
                    overflow-x: inherit;
                }
                .trades-table thead tr th {

                    text-align: center;
                    vertical-align: middle;
                    background: #2988ca;
                    color: #fff!important;
                    border-color: #217cbb;
                }
                .table{
                    font-size: 10px!important;
                }
                .txt-L{
                    text-align: left!important;
                    font-weight:bold!important;
                }
                .rightbtnlink {
                    display: inline-block;
                    float: right;
                    text-decoration: none;
                }
                .btnLinkl {
                    background: #2988ca;
                    color: #fff;
                    min-width: 100px;
                }
                .btnLinkl:hover {
                    color: #fff;
                    background: #13639a;
                }
            </style>

            <div class="pamm-investment-container">
                <h1>
                    Monitoring of project: <?=$infor['project_name'];?>
                </h1>
                <br/>
                <div class="pamm-investment-parent">
                    <div class="pamm-investment-table">

                            <div class="table-responsive">
                                <table id="General_information" class="table table-stripped  trades-table">
                                    <thead>
                                        <th>General information</th>
                                        <th></th>
                                        <th>Indicators</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <!-- row1-->
                                        <!--NYI = Not Yet Implemented-->
                                        <tr>
                                            <td> Broker </td>
                                            <td> <?= $broker; ?> </td>
                                            <td> Simple rating </td>
                                            <td>  <?=$infor2['SimpleRating'];?> </td>
                                        </tr>
                                        <!-- row2-->
                                        <tr>
                                            <td> Account:  </td>
                                            <td> <?=$infor['account_number'];?> </td>
                                            <td> Balance: </td>
                                            <td> <?=$infor2['Balance'];?> </td>

                                        </tr>
                                        <!-- row3-->
                                        <tr>
                                            <td>Type:</td>
                                            <td> <?= $pamm_type;?>  </td>
                                            <td>Equity:</td>
                                            <td> <?=$infor2['Equity'];?> </td>
                                        </tr>

                                        <!-- row4-->
                                        <tr>
                                            <td>Project:</td>
                                            <td> <?=$infor['project_name'];?>  </td>
                                            <td>Current trades:</td>
                                            <td> <?=$infor2['CurrentTrades'];?> </td>
                                        </tr>

                                        <!-- row5-->
                                        <tr>
                                            <td>Account name: </td>
                                            <td>
                                                <?=$gi_show_account_name;?>
                                            </td>
                                            <td>Total trades:</td>
                                            <td> <?=$infor2['TotalTrades'];?> </td>
                                        </tr>

                                        <!-- row6-->
                                        <tr>
                                            <td>Icq:</td>
                                            <td>
                                                <?=$gi_show_icq;?>

                                            </td>
                                            <td>Last day balance:</td>
                                            <td>
                                                N/A
                                            </td>
                                        </tr>
                                        <!-- row7-->
                                        <tr>
                                            <td>Skype:</td>
                                            <td>
                                                <?=$gi_show_skype;?>
                                            </td>
                                            <td>Total profit:</td>
                                            <td>
                                                <?=$infor2['TotalProfit'];?>
                                            </td>
                                        </tr>

                                        <!-- row8-->
                                        <tr>
                                            <td>Phone: </td>
                                            <td>
                                                N/A
                                            </td>
                                            <td>Balance from begin:</td>
                                            <td>
                                                N/A
                                            </td>
                                        </tr>

                                        <!-- row9-->
                                        <tr>
                                            <td>Email:</td>
                                            <td>
                                                Hidden
                                            </td>
                                            <td>Last day equity:</td>
                                            <td>
                                                N/A
                                            </td>
                                        </tr>

                                        <!-- row10-->
                                        <tr>
                                            <td>Trader's percent: </td>
                                            <td>
                                                N/A
                                            </td>
                                            <td>Equity from begin:</td>
                                            <td>
                                               N/A
                                            </td>
                                        </tr>

                                        <!-- row11-->
                                        <tr>
                                            <td>Percent to affiliate:</td>
                                            <td>
                                                <?=$infor['partner_share'];?>
                                            </td>
                                            <td>Forum topic:</td>
                                            <td>
                                            -
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>


                <div class="pamm-investment-secondary">
                    <label>
                        Project's Profit
                    </label>
                    <div class="pamm-investment-table">

                            <div class="table-responsive">
                                <table id="Project_profit" class="table table-stripped  trades-table">
                                    <thead>
                                        <th>Daily profit</th>
                                        <th>Weekly profit</th>

                                        <th>Monthly profit</th>
                                        <th>3-month profit</th>

                                        <th>6-month profit</th>
                                        <th>9-month profit</th>

                                        <th>Total profit</th>
                                    </thead>
                                    <tbody>

                                        <td>
                                            <!--Daily profit-->
                                            <?= sprintf("%01.2f", (($infor2['DailyProfit'])*100)); ?> %
                                        </td>

                                        <td>
                                            <!--WeeklyProfit-->
                                            <?= sprintf("%01.2f", (($infor2['WeeklyProfit'])*100)); ?> %
                                        </td>

                                        <td>
                                            <!--Monthly profit-->
                                            <?= sprintf("%01.2f", (($infor2['MonthlyProfit'])*100)); ?> %
                                        </td>

                                        <td>
                                            <!--3-month profit-->
                                            <?= sprintf("%01.2f", (($infor2['Month_3_Profit'])*100)); ?> %
                                        </td>

                                        <td>
                                            <!--6-month profit-->
                                            <?= sprintf("%01.2f", (($infor2['Month_6_Profit'])*100)); ?> %
                                        </td>

                                        <td>
                                            <!--9-month profit-->
                                            <?= sprintf("%01.2f", (($infor2['Month_9_Profit'])*100)); ?> %
                                        </td>
                                        <td>
                                            <!--Total profit-->
                                            <?= sprintf("%01.2f", (($infor2['TotalProfit'])*100)); ?> %
                                        </td>
                                    </tr>
                                     <tr>
                                         <td colspan="7">
                                             <label>PAMM project profitability statistics for the indicated time intervals.</label>
                                         </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
<!--                <div class="pamm-investment-secondary">-->
<!--                    <label>Investment calculator</label>-->
<!--                </div>-->
                <div class="pamm-investment-secondary">
                    <label>Trader conditions</label>
                    <div class="pamm-investment-table">

                            <div class="table-responsive">
                                <table id="trader_conditions" class="table table-stripped  trades-table">

                                    <thead>
                                        <th>Number set</th>
                                        <th>Minimum investment</th>

                                        <th>Commission</th>
                                        <th>Minimum investment period</th>

                                        <th>Penalty</th>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><?=$infor3[1]['apply_investment_from'];?> <?=$gi_currency;?> </td>

                                            <td><?=$infor3[1]['project_share'];?> <?=$gi_percentsymbol;?></td>
                                            <td><?=$infor3[1]['days'];?> days <?=$infor3[1]['hours'];?> hours</td>

                                            <td><?=$infor3[1]['prepaymentinvestmentsum'];?> <?=$gi_percentsymbol;?></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><?=$infor3[2]['apply_investment_from'];?> <?=$gi_currency;?> </td>

                                            <td><?=$infor3[2]['project_share'];?> <?=$gi_percentsymbol;?></td>
                                            <td><?=$infor3[2]['days'];?> days <?=$infor3[2]['hours'];?> hours</td>

                                            <td><?=$infor3[2]['prepaymentinvestmentsum'];?> <?=$gi_percentsymbol;?></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><?=$infor3[3]['apply_investment_from'];?> <?=$gi_currency;?> </td>

                                            <td><?=$infor3[3]['project_share'];?> <?=$gi_percentsymbol;?></td>
                                            <td><?=$infor3[3]['days'];?> days <?=$infor3[3]['hours'];?> hours</td>

                                            <td><?=$infor3[3]['prepaymentinvestmentsum'];?> <?=$gi_percentsymbol;?></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><?=$infor3[4]['apply_investment_from'];?> <?=$gi_currency;?> </td>

                                            <td><?=$infor3[4]['project_share'];?> <?=$gi_percentsymbol;?></td>
                                            <td><?=$infor3[4]['days'];?> days <?=$infor3[4]['hours'];?> hours</td>

                                            <td><?=$infor3[4]['prepaymentinvestmentsum'];?> <?=$gi_percentsymbol;?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
                <div class="pamm-investment-secondary">
                    <div class="pamm-investment-table">
                            <div class="table-responsive">
                                <table id="table4" class="table table-stripped  trades-table">
                                    <thead>
                                        <th>PAMM-Project's rate</th>
                                        <th>Evaluation by investors</th>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>
                                            <i>
                                                Votes:<strong>0</strong>
                                            </i>
                                        </td>
                                        <td>
                                            <i>
                                                Votes:<strong>0</strong>
                                            </i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>


                <div class="pamm-investment-secondary">
                    <label>Web counter</label>
                    <!--<div class="pamm-investment-table">-->
                        <table class="" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td class="without-border">
                                    <table class="table table_main table-striped" style="width: 363px; margin: 0 7px 5px 7px" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th class="first">Type</th>
                                            <th class="middle">Per day</th>
                                            <th class="middle">Per week</th>
                                            <th class="last">Per month</th>
                                        </tr>
                                        </thead>
                                        <tbody><tr>
                                            <td class="middle_first">Views</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td class="middle_last">N/A</td>
                                        </tr>
                                        <tr>
                                            <td class="first">Hosts</td>
                                            <td class="middle">N/A</td>
                                            <td class="middle">N/A</td>
                                            <td class="last">N/A</td>
                                        </tr>
                                        </tbody></table>
                                </td>
                                <td style="font-size: 100%; text-align: left; width: 280px; vertical-align: top" class="without-border">
                                    PAMM project visitor statistics for the specified period.                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <!--</div>-->
                </div>
                <br/>
                <div class="pamm-investment-secondary">
                    <div class="pamm-investment-table">
                        <label class="desc_head en" style="display: inline-block;">Description in English</label>
                        <label class="desc_head ru" style="display: none;">Description in Русский</label>
                        <label class="desc_head jp" style="display: none;">Description in 日本語</label>
                        <label class="desc_head pl" style="display: none;">Description in Polski</label>
                        <br/>
                        <nobr>
                            Language of description:&nbsp;
                            <a href="javascript:void(0)" onclick="ChangeDescription('en')">English</a>&nbsp;|&nbsp;
                            <a href="javascript:void(0)" onclick="ChangeDescription('ru')">Русский</a>&nbsp;|&nbsp;
                            <a href="javascript:void(0)" onclick="ChangeDescription('jp')">日本語 </a>&nbsp;|&nbsp;
                            <a href="javascript:void(0)" onclick="ChangeDescription('pl')">Polski</a>
                        </nobr>
                        <div class="alert alert-main alert-dismissible langbox">
                            <div style="display: none;" class="account_monitoring_bottom_padding_block description en"><?=$infor['description'];?></div>
                            <div style="display: none;" class="account_monitoring_bottom_padding_block description ru"><?=$infor['description_russian'];?></div>
                            <div style="display: none;" class="account_monitoring_bottom_padding_block description jp"><?=$infor['description_japanese'];?></div>
                            <div style="" class="account_monitoring_bottom_padding_block description pl"><?=$infor['description_polish'];?></div>                           
                        </div>
                        <div class="rightbtnlink"><a href="https://my.forexmart.com/pamm/invest/<?=$infor['account_number'];?> " class="btn btnLinkl">Invest</a></div>
                    </div>
                </div>
            </div>

    </div>
</div>
<style>
    /*slider*/
    #ex1Slider .slider-selection
    {
        background: #2988ca;
    }
    .slider-handle
    {
        width: 17px!important;
        height: 17px!important;
        background-color: #EDEFF0!important;
        border: 1px solid #ccc!important;
        border-radius: 0px!important;
        background-image: none!important;
        margin-top: -3px!important;
    }
    .slider.slider-horizontal .slider-track
    {
        height: 11px!important;
    }
    .slider-track
    {
        border-radius: 0px!important;
        background-image: none!important;
        background: #ddd!important;
        box-shadow: none!important;
    }
    .slider-selection, .slider-track-high
    {
        border-radius: 0px!important;
    }
    /*PAMM style*/
    .pamm-landing-page {
        display:table;
        margin-bottom:20px;
    }

    .pamm-landing-intro p {
        padding:10px 0;
        text-align:justify;
    }

    .pamm-landing-intro p , .pamm-landing-intro ul {
        margin-bottom:0!important;
    }

    .pamm-landing-agreement h1 {
        text-align:center;
        font-size:20px;
        color:#2988CA;
    }

    .pamm-agreement-content {
        width:90%;
        margin:20px auto;
        padding:10px;
        height:300px;
        overflow-y:scroll;
        border:1px solid #cacaca;
    }

    .pamm-agreement-content p {
        font-weight:600;
    }

    .pamm-agreement-list-parent , .pamm-agreement-list-child {
        padding:0 15px!important;
    }

    .pamm-agreement-list-parent li {
        padding:5px 0;
    }

    .pamm-agreement-list-parent li span {
        font-weight:600;
        color:#ff0000;
    }

    .pamm-agreement-list-child li {
        padding:0;
    }

    .pamm-agreement-checkbox {
        display:table;
        margin:0 auto;
    }

    .pamm-agreement-checkbox input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-select-account {
        margin:20px 0;
        width:100%;
        display:table;
    }

    .pamm-select-account-child {
        width:100%;
        display:table;
    }

    .pamm-select-account-child img {
        margin:0 auto!important;
        display:table;
    }

    .pamm-select-account-child a {
        background:#2988ca;
        color:#fff;
        text-align:center;
        padding:10px 20px;
        font-size:15px;
        margin:0 auto;
        margin-top:-15px;
        display:table;
        text-decoration:none;
        transition: all ease 0.3s;
    }

    .pamm-select-account-child p {
        margin-top:10px;
        text-align:center;
    }

    .pamm-onclick-page {
        width:100%;
        margin:20px 0;

    }

    .pamm-tab-content {
        border:1px solid #ddd;
    }

    .pamm-btn {
        padding:0;
        background:none;
        color: #333;
        font-size: 15px;
        margin:0!important;
        line-height:12px!important;
    }

    .pamm-btn-secondary {
        padding-right:0!important;
    }

    .pamm-btn-group.open .dropdown-toggle , .pamm-btn:focus , .pamm-btn:hover {
        box-shadow:none;
    }

    .pamm-dropdown-menu {
        margin-top:5px!important;
        border-radius:0!important;
        padding:0!important;
    }

    .pamm-dropdown-menu ul {
        position:relative;
        padding:0!important;
    }

    .pamm-dropdown-menu ul li {
        list-style-type:none;
        padding:5px;
        cursor:pointer;
    }

    .pamm-dropdown-menu ul li:hover {
        background:#f0f0f0;
    }

    .navbar-brand-internal{
        margin-top: 4px!important;
    }

    /*----- PAMM ONCLICK PAGE -----*/
    .pamm-nav-tabs {
        background:#eee;
        border:1px solid #ddd;
    }

    .pamm-nav-tabs li a {
        color:#333;
        font-size:15px;
    }

    .pamm-nav-tabs .active a {
        border-radius:0;
        border:none!important;
        border-bottom:2px solid #fff!important;
        font-weight:600;
    }
    .pamm-tab-content {
        margin-top:-1px;
        padding:10px;
        /*display:table;*/
        width:100%;
    }

    /*----- PAMM PROFILE TAB -----*/

    .pamm-content-input {
        width:90%;
        margin:0 auto;
    }

    .pamm-content-input h1 {
        border-bottom:1px solid #2988CA;
        color:#333;
        text-align:left;
        font-size:18px;
        font-weight:600;
        padding:5px;
    }

    .pamm-content-input-box {
        margin:10px auto!important;
        display:table;
        float:none!important;
    }
    .pamm-content-input-box p
    {
        text-align: justify;
    }
    .pamm-content-input-box textarea {
        resize:vertical;
    }

    .pamm-content-input-box label {
        margin-bottom:0;
    }

    .pamm-content-input-box input[type=checkbox] {
        float:left;
        margin-right:5px;
    }

    .pamm-content-input-box button , .pamm-investment-parent button , .pamm-investment-secondary button {
        margin:10px auto;
        display:table;
        background: #2988CA;
        color: #fff;
        padding:8px 20px;
        border:none;
        transition: all ease 0.3s;
    }

    .pamm-content-input-box button:hover , .pamm-investment-parent button:hover , .pamm-investment-secondary button:hover {
        background:#319ae3;
    }

    .required-field {
        font-size:12px;
        font-weight:normal;
        color:#ff0000;
    }

    .hide-unhide-input-box {
        display:table;
        float:right;
    }

    .show-button , .hide-button {
        display:block;
        width:20px;
        height:20px;
        float:left;
        margin:0 1px;
        transition: all ease 0.3s;
    }

    .show-button {
        background:url(../images/show-eye-button.png);
    }

    .show-button:hover {
        background:url(../images/show-eye-button-hover.png);
    }

    .hide-button {
        background:url(../images/hide-eye-button.png);
    }

    .hide-button:hover {
        background:url(../images/hide-eye-button-hover.png);
    }

    .pamm-trader-list ul {
        padding:0;
    }

    .pamm-trader-list ul li {
        list-style-type:none;
        margin:5px 0;
    }

    .pamm-trader-list ul li label {
        font-weight:normal;
    }

    /*----- PAMM MY INVESTMENTS TAB -----*/
    .pamm-investment-container  {
        width:90%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-container h5 {
        font-size:15px;
        padding:5px 0;
        border-bottom:1px solid #2988CA;
    }

    .pamm-investment-content ul {
        padding:0;
    }

    .pamm-investment-content ul li {
        list-style-type:none;
    }

    .pamm-investment-content ul li i {
        font-style:normal;
        color:#2988CA;
    }

    .pamm-investment-parent {
        display:table;
        width:100%;
    }

    .pamm-investment-parent button , .pamm-investment-secondary button {
        display:block;
        clear:both;
    }

    .pamm-investment-secondary {
        width:100%;
        margin:0 auto;
        display:table;
    }

    .pamm-investment-table {
        width:100%;
    }

    .pamm-investment-table table thead {
        background:#eee;
    }

    .pamm-investment-table table thead th {
        text-align:center;
        color:#707071;
        font-weight:600;
        padding:7px 5px;
    }

    .pamm-investment-table table tr td {
        text-align:center;
        padding:5px;
        border-bottom:1px solid #ddd;
    }

    .pamm-trader-condition-child {
        margin:0 0 20px 0;
    }

    .pamm-trader-condition-child label {
        margin-bottom:0;
        display:block;
    }

    .pamm-trader-condition-child input[type=text] {
        width:80%!important;
        float:left;
        margin-right:5px;
    }

    .pamm-trader-condition-child span {
        display:inline-block;
        line-height:34px;
    }

    .max-investment-amount {
        line-height:32px!important;
        display:table;
        background: #eee;
        border: 1px solid #ddd;
        padding:0 10px;
    }

    /*----- PAMM MONITORING TAB -----*/

    .pamm-monitoring-landing h1 , .pamm-monitoring-live-feed h1 {
        padding:0;
        font-size:18px;
        margin:0!important;
        display:table;
        font-weight:600;
    }

    .pamm-monitoring-landing h1 {
        float:left;
        line-height:31px;
    }

    .pamm-monitoring-info {
        clear:both!important;
        padding:20px 0;
    }

    .pamm-monitoring-live-feed {
        display:none;
    }

    .pamm-monitoring-live-feed p {
        margin-top:20px;
    }

    .live-feed-child-content {
        display:table;
        width:100%;
        padding:10px;
        margin:10px auto;
    }

    .live-feed-child-content:nth-child(odd) {
        background:#fcfcfc;
        border:1px solid #dadada;
    }

    .live-feed-child-content:nth-child(even) {
        background:#f3f2f2;
        border:1px solid #dadada;
    }


    .live-feed-child-content h2 {
        font-size:14px;
        font-weight:600;
        margin:0 0 3px 0;
    }

    .live-feed-child-content img {
        float:left;
    }

    .live-feed-child-content span {
        color: #707071;
        float:left;
        margin-left:5px;
        margin-top:3px;
    }

    .live-feed-child-content ul {
        padding:0;
        margin-bottom:0;
        display:table;
        width:100%;
    }

    .live-feed-child-content ul li {
        list-style-type:none;
        float:left;
        border-right:1px solid #dadada;
    }

    .live-feed-child-content ul li a {
        padding:0 10px;
    }

    .live-feed-child-content ul li:first-child a {
        padding-left:0;
    }

    .live-feed-child-content ul li:last-child {
        border-right:0;
    }

    .monitoring-btn-default {
        padding:6px!important;
    }

    .secondary-monitoring-text-center {
        margin-top:3px;
    }

    .btn-demo1 {
        background: none;
        border: 1px solid #2988ca;
        color: #2988ca;
        padding: 7px;
        margin-top: 5px;
        transition: all ease 0.3s;
    }

    .btn-demo1:hover {
        background:#2988ca;
        color:#fff;
    }

    .trades-tab-holder {
        max-width:824px;
    }

    .trades-tab-holder tr th {
        border-bottom:0!important;
    }

    .conditions-input-holder {
        display:table;
        width:100%;
    }

    .conditions-slider {
        width:80%;
        float:left;
        margin:12px 0;
    }

    .conditions-slider span {
        outline:none!important;
    }

    .conditions-input {
        width:15%;
        border-radius:0;
        float:right;
    }

    .conditions-slider .ui-state-hover , .conditions-slider .ui-state-focus {
        background:#98d1f9!important;
        border:1px solid #52aae7!important;
    }

    .conditions-mid-content {
        text-align:center;
    }

    .conditions-mid-reward {
        text-align:justify;
    }
    .package-holder
    {
        width: 100%;
        text-align: center;
    }

    /*new*/
    .pamm-title-sub
    {
        font-size: 17px;
        font-weight: 600;
    }
    .control-label
    {
        text-align: right;
    }
    .radio-textbox
    {
        width: 100px;
        display: inline-block;
    }
    .minimal-sum-holder
    {
        padding: 0 15px!important;
    }
    .btn-set-holder
    {
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }
    .btn-set
    {
        background: #2988ca;
        color: #fff;
        display: inline-block;
        text-align: center;
        width: 100px;
        padding: 10px;
        transition: all ease 0.3s;
    }
    .btn-set:hover, .btn-set:focus
    {
        text-decoration: none;
        background: #48AFF6;
        transition: all ease 0.3s;
        color: #fff;
    }

    @media screen and (max-width: 1168px) {

        .monitoring-text-center {
            text-align:start!important;
        }

        .monitoring-btn-default {
            font-size:12px;
            padding:6px 4px!important;
        }

    }

    @media screen and (max-width: 1066px) {

        .monitoring-btn-default {
            margin-top:2px;
        }

    }

    @media screen and (max-width: 991px) {

        .pamm-side-nav li {
            width: calc(100% / 7)!important;
        }

    }

    @media screen and (max-width: 928px) {

        .pamm-side-nav li a {
            width:100%;
            display:table!important;
        }

        .pamm-side-nav li i , .pamm-side-nav li cite {
            float:left;
        }

        .pamm-side-nav li cite {
            font-size:11px!important;
        }

    }

    @media screen and (max-width: 767px) {

        .pamm-side-nav li {
            width:100%!important;
        }

        .pamm-side-nav li cite {
            font-size:14px!important;
            margin-left:5px;
        }

        .pamm-side-nav li i {
            margin-top:2px;
        }

        .pamm-investment-content {
            padding:0!important;
            float:none!important;
        }

        .pamm-investment-content ul {
            margin-bottom:0!important;
        }

        .pamm-investment-parent button {
            margin-top:10px!important;
        }

    }

    @media screen and (max-width: 670px) {

        .pamm-investment-table {
            max-width:500px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 570px) {

        .pamm-investment-table {
            max-width:400px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 558px) {

        .finance-payment-methods select {
            width:100%;
        }

        .finance-method-amount .input-group {
            width:100%;
        }

        .finance-method-amount label {
            line-height:16px;
        }

        .finance-method-table button {
            margin:0 auto;
            display:table;
            float:none;
        }

    }

    @media screen and (max-width: 550px) {

        .pamm-agreement-checkbox {
            width:80%;
        }

    }

    @media screen and (max-width: 475px) {

        .pamm-investment-table {
            max-width:300px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 465px) {

        .pamm-monitoring-landing h1 , .pamm-monitoring-landing button {
            float:none!important;
        }

        .pamm-monitoring-landing h1 {
            display:block;
            text-align:left;
        }

        .pamm-monitoring-landing button {
            display:block;
            margin:10px auto;
        }

        .pamm-monitoring-info {
            padding:10px 0;
        }

    }

    @media screen and (max-width: 430px) {

        .pamm-nav-tabs li {
            width:100%!important;
        }

        .pamm-nav-tabs li a {
            border:none!important;
            margin-right:0!important;
        }

        .pamm-content-input-box {
            padding:0!important;
        }

        .live-feed-child-content ul li {
            float:none;
            display:block;
            border-right:0;
        }

        .live-feed-child-content ul li a {
            padding:0;
        }

    }

    @media screen and (max-width: 370px) {

        .pamm-investment-table {
            max-width:200px;
            margin:0 auto!important;
        }

    }

    @media screen and (max-width: 315px) {

        .finance-deposit-container {
            margin:0 auto;
            position:relative;
            padding:10px 0!important;
        }

        .finance-deposit-container, .finance-payment-methods, .finance-method-content {
            display:block;
        }

        .finance-table-holder {
            border:1px solid #ddd;
            overflow-x:scroll;
        }

        .finance-table-holder table {
            margin-top:0;
            border:none;
        }
    }
    .langbox{
        background-color: #fff;
        border-color: #e6e6e6;
        color: #333;
    }
</style>

<script type="text/javascript">
    function ChangeDescription(lang){
        $('.description, .desc_head').hide();
        $('.description.'+lang+', .desc_head.'+lang).show();
    }

    $(function(){
        ChangeDescription('en');
    });
</script>