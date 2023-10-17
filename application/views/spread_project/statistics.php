
        <div role="tabpanel" class="tab-pane active" id="tab3">
            <div class="row">
                <div class="col-md-12 rebate-child-container">
                    <div class="date-statistics">
                        <label><?= lang('from'); ?></label>
                        <div id="sandbox-container" class="rebate-datepicker">
                            <input type="text" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="date-statistics">
                        <label><?= lang('to'); ?></label>
                        <div id="sandbox-container" class="rebate-datepicker">
                            <input type="text" type="text" class="form-control"/>
                        </div>
                    </div>
                    <a class="rebate-showbutton"><button class="btn-login"><?= lang('show'); ?></button></a>
                </div>
                <div class="col-sm-12 rebate-child-container">
                    <div class="rebate-accountnumbers">
                        <label class="rebate-label"><?= lang('accounts'); ?></label>
                        <select class="dropdown-account-numbers form-control round-0">
                            <option>All</option>
                            <option>Certain Referral Account</option>
                        </select>
                    </div>
                    <div class="rebate-system-checkbox">
                        <input type="checkbox"/>
                        <p>Include trades details checkbox</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-centered">
                    <div class="graph-holder">
                        <p>Rebate Statistics</p>
                    </div>
                </div>
            </div>
        </div>