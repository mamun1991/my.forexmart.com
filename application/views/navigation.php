 <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="dl-holder">
                        <h1 class="accbal-title">Account Balance</h1>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control round-0 txt-balance" placeholder="" Value="0.00">
                              <div class="input-group-addon round-0 euro-sign">&euro;</div>
                            </div>
                        </div>
                        <div class="btn-deposit-holder">
                            <button class="btn-deposit"><?= lang('trd_232');?></button>
                        </div>
                        <div class="btn-withdraw-holder">
                            <button class="btn-withdraw">Withdraw Funds</button>
                        </div>
                        <div class="dls">
                            <h1>Download platforms</h1>
                            <ul class="platforms">
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx1.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro Client Terminal<br><cite>MT4 Platform</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx2.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro MultiTerminal<br><cite>Multi-MT4</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx3.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro WebTrader<br><cite>MT4 Online</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx4.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro iPhone<br><cite>Trader</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx5.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro iPad<br><cite>Trader</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                                <li>
                                    <a href="#">
                                        <img src="http://forexmart.com/assets/images/fx6.png" class="img-reponsive" width="50px" height="50px" style="float: left;">
                                        FxPro Android<br><cite>Transfer</cite>
                                    </a>
                                </li><div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
				<div class="col-lg-9 col-md-9 col-sm-9" style="border-left: 1px solid #ccc;">
                    <div class="section">
                        <div class="side-nav-holder">
                            <ul class="side-nav">
                                <li><a href="my-account.html"><i class="fa fa-suitcase"></i><cite>My Account</cite></a></li>
                                <li><a href="#"><i class="fa fa-user"></i><cite>My Profile</cite></a></li>
                                <li><a href="<?php echo base_url(); ?>deposit" class="<?php if($this->uri->segment(2) != "deposit") echo "active-sidenav"; ?>"><i class="fa fa-money"></i><cite><?= lang('trd_232');?></cite></a></li>
                                <li><a href="<?php echo base_url(); ?>withdraw" class="<?php if($this->uri->segment(2) == "withdraw") echo "active-sidenav"; ?>"><i class="fa fa-credit-card"></i><cite>Withdraw Funds</cite></a></li>
                                <li><a href="#"><i class="fa fa-download"></i><cite>Platform Downloads</cite></a></li>
                            </ul><div class="clearfix"></div>
                        </div>