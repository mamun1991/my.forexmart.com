<?= $this->load->ext_view('modal', 'preloader', '', TRUE); ?>

<!--trader registration-->
<div class="pamm-onclick-page destination-class" id="pamm-div-trader">

    <?=$nav;?>

    <div id="my-tab-content" class="tab-content pamm-tab-content">
        <div id="secondary-monitoring">
            <div class="pamm-monitoring-landing live-feed-class" id="secondary-monitoring-div">
                <h1><?= lang('pamm_39'); ?></h1>
                <div class="pamm-monitoring-info">
                    <p><?= lang('pamm_40'); ?>.
                        </br></br><?= lang('pamm_41'); ?>.
                        </br></br>
                        <?= lang('pamm_42'); ?>.
                    </p>
                </div>

                <div class="broker-info text-center">
                    <a href="javascript:void(0)" class="btn_daily btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_55'); ?></a>
                    <a href="javascript:void(0)" class="btn_weekly btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_56'); ?></a>
                    <a href="javascript:void(0)" class="btn_monthly btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_57'); ?></a>
                    <a href="javascript:void(0)" class="btn_3months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_58'); ?></a>
                    <a href="javascript:void(0)" class="btn_6months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_59'); ?></a>
                    <a href="javascript:void(0)" class="btn_9months btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_60'); ?></a>
                    <a href="javascript:void(0)" class="btn_total btn btn-demo1"><i class="fa fa-calendar"></i> <?= lang('pamm_61'); ?></a>
                </div>

                <div class="trades-tab-holder">
                    <div class="table-responsive">
                        <table id="MonitoringTable"  name="MonitoringTable" class="table table-striped table-hover one-table cdsize">
                            <thead>
                                <tr>
                                    <th style="width: 260px"><?= lang('pamm_62'); ?></th>
                                    <th><?= lang('pamm_63'); ?></th>
                                    <th>Daily Profit</th>
                                    <th>Weekly Profit</th>
                                    <th>Monthly Profit</th>
                                    <th>3-month Profit</th>
                                    <th>6-month Profit</th>
                                    <th>9-month Profit</th>
                                    <th>Total Profit</th>
                                    <th><?= lang('pamm_64'); ?></th>
                                    <th><?= lang('pamm_65'); ?></th>
                                    <th><?= lang('pamm_66'); ?></th>
                                    <th><?= lang('pamm_67'); ?></th>
                                    <th><?= lang('pamm_68'); ?></th>
                                    <th style="width: 90px"><?= lang('pamm_70'); ?></th>
                                    <th style="width: 90px"><?= lang('pamm_71'); ?></th>
                                    <th><?= lang('pamm_72'); ?></th>
                                </tr>
                                <tr>
                                    <th><div class="input-group">
                                        <input  id="accountnumber_project" name="accountnumber_project" type="text" class="form-control ctm_inputwidth">
                                          <span class="input-group-btn">
                                                  <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                          </span>
                                    </div>
                                    </th>
                                    <th>
                                        <!--simple rating-->
                                        <select name="simplerating" id="simplerating" class="form-control ctm_selfixwidth">
                                            <option value=""></option>
                                            <option value=">0">&gt;0</option>
                                            <option value="0-20">0-20</option>
                                            <option value="20-40">20-40</option>
                                            <option value="40-60">40-60</option>
                                            <option value="60-80">60-80</option>
                                            <option value="80-100">80-100</option>
                                            <option value="100-150">100-150</option>
                                            <option value="150-200">150-200</option>
                                            <option value=">200">&gt;200</option></select>
                                        </select>
                                    </th>
                                    <th>
                                        <!--dailyprofit-->
                                        <select  name="dailyprofit" id="dailyprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option></select>
                                        </select>
                                    </th>
                                    <th>
                                        <!--weekly profit-->
                                        <select  name="weeklyprofit" id="weeklyprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>

                                    <th>
                                        <!--monthly profit-->
                                        <select name="monthlyprofit" id="monthlyprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--3 month profit-->
                                        <select name="threemonthprofit" id="threemonthprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--6 month profit-->
                                        <select name="sixmonthprofit" id="sixmonthprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--9 month profit-->
                                        <select name="ninemonthprofit" id="ninemonthprofit"  class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--total profit-->
                                        <select name="totalprofit" id="totalprofit" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0.1-0.2">10-20</option><option value="0.2-0.3">20-30</option><option value="0.3-0.5">30-50</option><option value="0.5-1.0">50-100</option><option value="1.0-2.0">100-200</option><option value="2.0-3.0">200-300</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--balance-->
                                        <select name="balance" id="balance" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">1">&gt;1</option><option value=">100">&gt;100</option><option value=">1000">&gt;1000</option><option value=">3000">&gt;3000</option><option value=">5000">&gt;5000</option><option value=">10000">&gt;10000</option><option value=">50000">&gt;50000</option><option value=">100000">&gt;100000</option><option value="0-1000">0-1000</option><option value="1000-3000">1000-3000</option><option value="3000-5000">3000-5000</option><option value="5000-10000">5000-10000</option><option value="10000-50000">10000-50000</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--equity-->
                                        <select name="equity" id="equity" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">1">&gt;1</option><option value=">100">&gt;100</option><option value=">1000">&gt;1000</option><option value=">3000">&gt;3000</option><option value=">5000">&gt;5000</option><option value=">10000">&gt;10000</option><option value=">50000">&gt;50000</option><option value=">100000">&gt;100000</option><option value="0-1000">0-1000</option><option value="1000-3000">1000-3000</option><option value="3000-5000">3000-5000</option><option value="5000-10000">5000-10000</option><option value="10000-50000">10000-50000</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--current trades-->
                                        <select name="currenttrades" id="currenttrades" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0-20">0-20</option><option value="20-40">20-40</option><option value="40-60">40-60</option><option value="60-80">60-80</option><option value="80-100">80-100</option><option value="100-150">100-150</option><option value="150-200">150-200</option><option value=">200">&gt;200</option>
                                        </select>
                                    </th>

                                    <th>
                                        <!--total trades-->
                                        <select name="totaltrades" id="totaltrades" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0-20">0-20</option><option value="20-40">20-40</option><option value="40-60">40-60</option><option value="60-80">60-80</option><option value="80-100">80-100</option><option value="100-150">100-150</option><option value="150-200">150-200</option><option value=">200">&gt;200</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--active investor-->
                                        <select name="activeinvestor" id="activeinvestor" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0-20">0-20</option><option value="20-40">20-40</option><option value="40-60">40-60</option><option value="60-80">60-80</option><option value="80-100">80-100</option><option value="100-150">100-150</option><option value="150-200">150-200</option><option value=">200">&gt;200</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--Daily total (balance)-->
                                        <select name="dailytotalbalance" id="dailytotalbalance" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0-20">0-20</option><option value="20-40">20-40</option><option value="40-60">40-60</option><option value="60-80">60-80</option><option value="80-100">80-100</option><option value="100-150">100-150</option><option value="150-200">150-200</option><option value=">200">&gt;200</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--total daily equity-->
                                        <select name="totaldailyequity" id="totaldailyequity" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value=">0">&gt;0</option><option value="0-20">0-20</option><option value="20-40">20-40</option><option value="40-60">40-60</option><option value="60-80">60-80</option><option value="80-100">80-100</option><option value="100-150">100-150</option><option value="150-200">150-200</option><option value=">200">&gt;200</option>
                                        </select>
                                    </th>
                                    <th>
                                        <!--since registered-->
                                        <select name="sinceregistered" id="sinceregistered" class="form-control ctm_selfixwidth">
                                            <option value=""></option><option value="30">&gt;=30 days</option><option value="90">&gt;=90 days</option><option value="180">&gt;=180 days</option><option value="270">&gt;=270 days</option><option value="360">&gt;=360 days</option>
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="request">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">

    /*custom*/
    .pamm-onclick-page{
        display: block!important;
    }
    /*custom*/
    .a-reg-btn{
        margin: 10px auto;
        display: table;
        background: rgb(41, 136, 202) none repeat scroll 0% 0%;
        color: rgb(255, 255, 255);
        padding: 8px 20px;
        border: medium none;
        transition: all 0.3s ease 0s;
    }
    .check{cursor: pointer;}
    .fa {
        padding-right: 0;
    }

    a {
        color: #5874BF;
        text-decoration: none;
    }
    a:hover {
        color: #112763;
    }

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
        display:none;
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
        background:url(../assets/images/show-eye-button.png);
    }

    .show-button:hover {
        background:url(../assets/images/show-eye-button-hover.png);
    }

    .hide-button {
        background:url(../assets/images/hide-eye-button.png);
    }

    .hide-button:hover {
        background:url(../assets/images/hide-eye-button-hover.png);
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
        margin-top: 13px;
        text-align:justify;
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

    .slider {
        width: 100px;
    }

    .slider > .dragger {
        background: #2eb94b;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        -webkit-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        -moz-box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 2px rgba(255,255,255,0.5), 0 2px 8px rgba(0,0,0,0.2);

        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;

        border: 1px solid #18872f;
        width: 16px;
        height: 16px;
    }

    .slider > .dragger:hover {
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
    }


    .slider > .track, .slider > .highlight-track {
        background: #ccc;
        background: -webkit-linear-gradient(top, #bbb, #ddd);
        background: -moz-linear-gradient(top, #bbb, #ddd);
        background: linear-gradient(top, #bbb, #ddd);

        -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);

        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;

        border: 1px solid #aaa;
        height: 4px;
    }

    .slider > .highlight-track {
        background-color: #8DCA09;
        background: -webkit-linear-gradient(top, #2eb94b, #29a643);
        background: -moz-linear-gradient(top, #2eb94b, #29a643);
        background: linear-gradient(top, #2eb94b, #29a643);

        border-color: #496805;
    }

    .slider-volume {
        width: 300px;
    }

    .slider-volume > .dragger {
        width: 16px;
        height: 16px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.6);

        -moz-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        -webkit-box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);
        box-shadow: 0 0px 2px 1px rgba(0,0,0,0.5), 0 2px 5px 2px rgba(0,0,0,0.2);

        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;

        background: #c5c5c5;
        background: -moz-linear-gradient(90deg, rgba(180,180,180,1) 20%, rgba(230,230,230,1) 50%, rgba(180,180,180,1) 80%);
        background:	-webkit-radial-gradient(  50%   0%,  12% 50%, hsla(0,0%,100%,1) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(  50% 100%, 12% 50%, hsla(0,0%,100%,.6) 0%, hsla(0,0%,100%,0) 100%),
        -webkit-radial-gradient(	50% 50%, 200% 50%, hsla(0,0%,90%,1) 5%, hsla(0,0%,85%,1) 30%, hsla(0,0%,60%,1) 100%);
    }

    .slider-volume > .track, .slider-volume > .highlight-track {
        height: 11px;

        background: #787878;
        background: -moz-linear-gradient(top, #787878, #a2a2a2);
        background: -webkit-linear-gradient(top, #787878, #a2a2a2);
        background: linear-gradient(top, #787878, #a2a2a2);

        -moz-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        -webkit-box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);
        box-shadow: inset 0 2px 5px 1px rgba(0,0,0,0.15), 0 1px 0px 0px rgba(230,230,230,0.9), inset 0 0 1px 1px rgba(0,0,0,0.2);

        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    .slider-volume > .highlight-track {
        background-color: #c5c5c5;
        background: -moz-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: -webkit-linear-gradient(top, #c5c5c5, #a2a2a2);
        background: linear-gradient(top, #c5c5c5, #a2a2a2);
    }
    .cdsize{
        font-size: 10px!important;
    }
    .custom_hoverfilters{
        background: #2988ca none repeat scroll 0 0;
        color: #fff;
    }
    .ctm_selfixwidth{
        /*width:60px;*/
        width: 80px;
        font-size: 10px;
    }
    .ctm_inputwidth{
        width: 90px !important;
    }
</style>

<script type="text/javascript">
    var site_url="<?=FXPP::ajax_url('')?>";

    $("[data-slider]")
        .each(function () {
            var input = $(this);
            $("<span>")
                .addClass("output")
                .insertAfter($(this));
        })
        .bind("slider:ready slider:changed", function (event, data) {
            $(this)
                .nextAll(".output:first")
                .html(data.value.toFixed(3));
        });

    /* START SHOW AND HIDE DIV */
    $(function(){
        $('body').on('click','.pamm-link',function(e){
            e.preventDefault();
            var destination = $(this).attr('data-destination');
            $('.destination-class').hide();
            $(destination).show();
            console.log(destination);
            console.log('test linkhit');
        });
    });
    /* END SHOW AND HIDE DIV */

    /* START DROPDOWN SHOW AND HIDE DIV */
    $(function(){
        $('body').on('click','.live-feed-link',function(e){
            e.preventDefault();
            var destination = $(this).attr('data-destination');
            $('.live-feed-class').hide();
            $(destination).show();
        });
    });
    $(function(){
        $('body').on('click','.monitoring-link',function(e){
            e.preventDefault();
            var destination = $(this).attr('data-destination');
            $('partner-registration').hide();
            $(destination).show();
        });
    });
    /* END DROPDOWN SHOW AND HIDE DIV */


    $(document).on("click", ".pamm-checkbox", function () {
        if($("#pamm-checkbox").is(':checked')){
            $( "#partner-registration" ).addClass( "pamm-link" );
            $( "#investor-registration" ).addClass( "pamm-link" );
            $( "#trader-registration" ).addClass( "pamm-link" );
        }else{
            $( "#partner-registration").removeClass( "pamm-link" );
            $( "#investor-registration").removeClass( "pamm-link" );
            $( "#trader-registration").removeClass( "pamm-link" );
        }
    });
</script>
<script type="text/javascript">
    var pblc = [];
    pblc['request'] = null;
    if(pblc['request'] != null) pblc['request'].abort();


</script>

<script type="text/javascript">
    var site_url="<?=FXPP::ajax_url('')?>";
    var maintable;
//    $.fn.dataTable.moment( 'YYYY-MMM-DD HH:mm:ss' );

    $(window).load(function() {
        $('#loader-holder').hide();
    });
    $(document).ready(function() {
//        $('#MonitoringTable').DataTable();
    });


    $(document).ready(function() {
        $('#loader-holder').show();
        var dom_tbl='<"row ins-filter"<"col-sm-6"<"form-inline">>>';
        var sendfilters;
        sendfilter = '';
        var prvt = [];
//        console.log( $('#accountnumber_project').val());

        prvt["data"] = {
            accountnumber_project: $('#accountnumber_project').val(),
            simplerating:$('#simplerating').val(),
            dailyprofit:$('#dailyprofit').val(),
            weeklyprofit:$('#weeklyprofit').val(),
            monthlyprofit:$('#monthlyprofit').val(),
            threemonthprofit :$('#threemonthprofit').val(),
            sixmonthprofit:$('#sixmonthprofit').val(),
            ninemonthprofit:$('#ninemonthprofit').val(),
            totalprofit:$('#totalprofit').val(),
            balance:$('#balance').val(),
            equity:$('#equity').val(),
            currenttrades:$('#currenttrades').val(),
            totaltrades:$('#totaltrades').val(),
            activeinvestor:$('#activeinvestor').val(),
            dailytotalbalance:$('#dailytotalbalance').val(),
            totaldailyequity:$('#totaldailyequity').val(),
            sinceregistered:$('#sinceregistered').val()
        };
        maintable = $('#MonitoringTable').dataTable( {
//            "order": [[ 4, "desc" ]],
//            searchDelay: 2000,

//            paging: false,
//            "bSort": false,
//            "ordering": false,
//            "info":     false,
//            initComplete: function () {
//                this.api().columns().every( function () {
//                    var column = this;
//                    var select = $('<select><option value=""></option></select>')
//                        .appendTo( $(column.footer()).empty() )
//                        .on( 'change', function () {
//                            var val = $.fn.dataTable.util.escapeRegex(
//                                $(this).val()
//                            );
//
//                            column
//                                .search( val ? '^'+val+'$' : '', true, false )
//                                .draw();
//                        } );
//
//                    column.data().unique().sort().each( function ( d, j ) {
//                        select.append( '<option value="'+d+'">'+d+'</option>' )
//                    } );
//                } );
//            },
            dom: dom_tbl,
            columnDefs: [
                            { orderable: false, targets: [2] , visible: false},  //
                            { orderable: false, targets: [3] , visible: false},  //
                            { orderable: false, targets: [4] , visible: false},  //
                            { orderable: false, targets: [5] , visible: false},  //
                            { orderable: false, targets: [6] , visible: false},  //
                            { orderable: false, targets: [7] , visible: false},  //
                            { orderable: false, targets: [8] , visible: false},  //
                            { orderable: false, targets: [14] },  //
                            { orderable: false, targets: [15] },  //
                            { orderable: false, targets: [16] }], //

            "fnDrawCallback": function( oSettings ) {
                $('#loader-holder').hide();
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "data": function(paramsdata){
                        paramsdata.accountnumber_project=$('#accountnumber_project').val();                        simplerating:$('#simplerating').val(),
                        paramsdata.simplerating=$('#simplerating').val();
                        paramsdata.dailyprofit=$('#dailyprofit').val();
                        paramsdata.weeklyprofit=$('#weeklyprofit').val();
                        paramsdata.monthlyprofit=$('#monthlyprofit').val();
                        paramsdata.threemonthprofit =$('#threemonthprofit').val();
                        paramsdata.sixmonthprofit=$('#sixmonthprofit').val();
                        paramsdata.ninemonthprofit=$('#ninemonthprofit').val();
                        paramsdata.totalprofit=$('#totalprofit').val();
                        paramsdata.balance=$('#balance').val();
                        paramsdata.equity=$('#equity').val();
                        paramsdata.currenttrades=$('#currenttrades').val();
                        paramsdata.totaltrades=$('#totaltrades').val();
                        paramsdata.activeinvestor=$('#activeinvestor').val();
                        paramsdata.dailytotalbalance=$('#dailytotalbalance').val();
                        paramsdata.totaldailyequity=$('#totaldailyequity').val();
                        paramsdata.sinceregistered=$('#sinceregistered').val();
                },
                "url": site_url+"query/get_monitoring_dt",
                "type": "POST",
                "beforeSend": function (xhr, opts) {
                    $('#loader-holder').show();
                },
//                "timeout": 500000, // optional if you want to handle timeouts (which you should)
                "error": handleAjaxError // this sets up jQuery to give me errors
            },
            "columns": [
                { "data": "account" },
                { "data": "simple_rating" },

                { "data": "daily_profit" },
                { "data": "weekly_profit" },
                { "data": "monthly_profit" },
                { "data": "3_month_profit" },
                { "data": "6_month_profit" },
                { "data": "9_month_profit" },
                { "data": "total_profit" },

                { "data": "balance" },
                { "data": "equity" },
                { "data": "current_trades" },
                { "data": "total_trades" },
                { "data": "active_trades" },
                { "data": "daily_total_balance" },
                { "data": "daily_total_equity" },
                { "data": "sinceregistereddays" }
            ]
        } );

        function handleAjaxError( xhr, textStatus, error ) {
            $('#loader-holder').hide();
            if ( textStatus === 'timeout' ) {
                console.log( 'The server took too long to send the data.' );
                alert( 'The server took too long to send the data.' );
                $('#s_report').html('The server took too long to send the data.');
                $('#avreport').modal('show');
            }
            else {
                console.log( 'An error occurred on the server. Please try again in a minute.' );
                alert( 'An error occurred on the server. Please try again in a minute.' );
                $('#s_report').html('An error occurred on the server. Please try again in a minute.');
                $('#avreport').modal('show');
            }
            $('#MonitoringTable').fnProcessingIndicator( false );
        }

        jQuery.fn.dataTableExt.oApi.fnProcessingIndicator = function ( oSettings, onoff ) {
            if ( typeof( onoff ) == 'undefined' ) {
                onoff = true;
            }
            this.oApi._fnProcessingDisplay( oSettings, onoff );
        };

    } );

    $(document).on("click", ".btn_daily", function () {
        <!-- start column 0-->
        <!-- column 2-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 2, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 2, true );
        }
    });
    $(document).on("click", ".btn_weekly", function () {
        <!-- column 3-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 3, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 3, true );
        }
    });
    $(document).on("click", ".btn_monthly", function () {
        <!-- column 4-->
        if($( this ).hasClass( "custom_hoverfilters" )){

            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 4, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 4, true );
        }
    });
    $(document).on("click", ".btn_3months", function () {
        <!-- column 5-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 5, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 5, true );
        }
    });

    $(document).on("click", ".btn_6months", function () {
        <!-- column 6-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis(6, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 6, true );
        }
    });
    $(document).on("click", ".btn_9months", function () {
        <!-- column 7-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis(7, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis(7, true );
        }
    });
    $(document).on("click", ".btn_total", function () {
        <!-- column 8-->
        if($( this ).hasClass( "custom_hoverfilters" )){
            $( this ).removeClass("custom_hoverfilters" );
            maintable.fnSetColumnVis(8, false );
        }else{
            $(this ).addClass("custom_hoverfilters" );
            maintable.fnSetColumnVis( 8, true );
        }
    });
    $( "#accountnumber_project" ).click(function() {
        $('#MonitoringTable').DataTable().ajax.reload();
    });
    $('select').on('change', function() {
        $('#MonitoringTable').DataTable().ajax.reload();
    })
</script>

<!--- TRADER Registration Start --->




