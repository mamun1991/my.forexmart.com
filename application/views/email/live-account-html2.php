<?php $this->load->view('email/_email_header');?>
<?php $this->lang->load('live-account-html');?>
        <div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
            <h2 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;page-break-after: avoid;font-family: Georgia,'Times New Roman',serif;font-weight: 500;line-height: 1.1;color: #2988ca;margin-top: 20px;margin-bottom: 10px;font-size: 22px;text-align: center;">
                <?=lang('liv_acc_htm_00');?>
                <!--ForexMart MT4 Live Trading Account Details-->
            </h2>
            <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;color: #5a5a5a;text-align: justify;">
                <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;max-width: 100%;margin-bottom: 5px;font-weight: normal;color: #000;padding-top: 30px;">
                    <?=lang('liv_acc_htm_01');?><!--Hi -->
                    <?=$full_name; ?>,
                </label> <br>
                <?=lang('liv_acc_htm_02');?>:
<!--                Thank you for opening an MT4 account with ForexMart! Your login details are as follows-->

            </p>
            <div class="cabinet-login-details" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 30px 20px;width: 500px;">
                <h1 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: .67em 0;font-size: 15px;font-family: inherit;font-weight: 500;line-height: 1.1;color: #5a5a5a;margin-top: 20px;margin-bottom: 10px;">
                    <?=lang('liv_acc_htm_03');?>
<!--                    Cabinet login details.-->
                </h1>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_04');?>:
                        <!--                        Username:-->
                    </label>
                    <?php echo $account_number." or "?> <a href="javascript:;" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: transparent;color: #2988ca;text-decoration: underline;"><?=$email?></a>
                </div>

                    <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                        <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                            <?=lang('liv_acc_htm_05');?>:
                            <!--                        Password:-->
                        </label>
                        <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;"><?php echo urlencode($trader_password); ?></span>
                    </div>



                <div class="login-button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box; width: 350px; margin-top: 20px;">
                    <a href="https://my.forexmart.com/client/signin" style="text-decoration: none; text-align: center" >

                        <div style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;text-decoration: none; width:300px; box-sizing: border-box;margin: 0;text-align:center;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #29a643;">
                            <?=lang('liv_acc_htm_06');?>
                        </div>

<!--                            Login to cabinet-->
                      </a>
                </div>
            </div>
            <div class="cabinet-login-details" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 30px 20px;width: 500px;">
                <h1 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: .67em 0;font-size: 15px;font-family: inherit;font-weight: 500;line-height: 1.1;color: #5a5a5a;margin-top: 20px;margin-bottom: 10px;">
                    <?=lang('liv_acc_htm_07');?>
<!--                    MT4 login details.-->
                </h1>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_08');?>
<!--                        Account Number:-->
                    </label>
                    <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;"><?=$account_number; ?></span>
                </div>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_09');?>
<!--                        Trader Password:-->
                    </label>
                    <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;"><?=$trader_password; ?></span>
                </div>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_10');?>
<!--                        Investor Password:-->
                    </label>
                    <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;"><?=$investor_password; ?></span>
                </div>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_11');?>
<!--                        Phone Password:-->
                    </label>
                    <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;"><?=$phone_password; ?></span>
                </div>
                <div class="cabinet-login-data" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block!important;max-width: 100%;margin-bottom: 5px;font-weight: bold;color: #555;">
                        <?=lang('liv_acc_htm_12');?>
<!--                        MT4 Live Server:-->
                    </label>
                    <a href="javascript:;" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: transparent;color: #2988ca;text-decoration: underline;"><?=MT4_SERVER_LIVE ?></a>
                </div>
                <div class="download-button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box; width: 300px;  margin-top: 20px;">
                    <a href="https://download.mql5.com/cdn/web/tradomart.ltd/mt4/forexmart4setup.exe" style="text-decoration: none;text-align: center">

                        <div style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;text-decoration: none; width:300px;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #2988ca;text-decoration: none;text-align: center">
                            <?=lang('liv_acc_htm_13');?>
                        </div>

<!--                            Download MT4 desktop platform-->
                       </a>
                </div>
				
				<div class="download-button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box; width: 300px;  margin-top: 20px;">
                    <a href="https://www.forexmart.com/webterminal" style="text-decoration: none;text-align: center">

                        <div style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;text-decoration: none; width:300px;box-sizing: border-box;margin: 0;font: inherit;color: #fff;overflow: visible;text-transform: none;-webkit-appearance: button;cursor: pointer;font-family: inherit;font-size: inherit;line-height: inherit;border: none;padding: 10px 30px;background: #e64e54;text-decoration: none;text-align: center">
                            Web Terminal
                        </div>

<!--                            Download MT4 desktop platform-->
                       </a>
                </div>
				
				
      
                    <div class="download-button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-top: 10px; display: inline-block; max-width: 145.5px;">
                        <a href="https://itunes.apple.com/app/metatrader-4/id496212596?l=en&mt=8">
                            <img src="https://www.forexmart.com/assets/images/app-store.png" style="width: 97%; vertical-align: middle;">
                        </a>
                    </div>

                    <div class="download-button" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-top: 10px;display: inline-block; max-width: 145.5px;">
                        <a href="https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4">
                            <img src="https://www.forexmart.com/assets/images/google-play.png" style="width: 97%; vertical-align: middle;">
                        </a>
                    </div>
                </div>
				
				
            </div>

         <div>   
            <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;color: #5a5a5a;text-align: justify;">
                <?=lang('liv_acc_htm_14');?>
<!--                Keep your account details safe and secure at all times.-->
                <br><br>
				
				
                <!--<?php //lang('liv_acc_htm_15');?> -->
<!--                To express our gratitude for jump-starting your trading with us, you can avail of the 30%-->
                <!--<a href="<?php //FXPP::loc_url('bonus/bonuses')?>" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: transparent;color: #2988ca;text-decoration: underline;"> -->
				<!--<?php //lang('liv_acc_htm_16');?></a> -->
                <!-- <?php //lang('liv_acc_htm_17');?> -->
<!--                offer, Open a real account make a deposit, and have the opportunity to get 30% of the total amount of this and every subsequent deposit.-->
<!--                <br><br> -->
				
				
				
                <?=lang('liv_acc_htm_18');?>
<!--                We also offer several was to deposit money into your account. You can quickly and securely make deposits via credit/debit card, from your bank account via a Bank Transfer or through online money transfer services such as Skrill, Paypal, Webmoney, Neteller,-->
<!--                Payco and many more. Please click here to know more about our different-->
                <a href="<?=FXPP::loc_url('deposit-withdraw-page')?>" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: transparent;color: #2988ca;text-decoration: underline;"><?=lang('liv_acc_htm_19');?></a>.
                <br><br>
                <?=lang('liv_acc_htm_20');?>
<!--                You are categorized as a Retail Client. If you desire to be reclassified, kindly send a request to us and follow the steps outlined in the Client Categorization. You can start trading once your request is approved.-->
                <br><br>
                <?=lang('liv_acc_htm_21');?>
<!--                For more information, please do not hesitate to contact us at-->

                <a href="javascript:;" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: transparent;color: #2988ca;text-decoration: underline;">support@forexmart.com</a>.
                <br><br>
                <?=lang('liv_acc_htm_22');?>
<!--                May you have a successful trading!-->
                <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;max-width: 100%;margin-bottom: 5px;font-weight: normal;color: #000;padding-top: 30px;">
                    <?=lang('liv_acc_htm_23');?>
<!--                    All the best,-->
                    <span style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;">
                        <?=lang('liv_acc_htm_24');?>
<!--                        ForexMart Team-->
                    </span>
                </label>
            </p>
        </div>





<?php


$this->load->view('email/_email_footer');
?>
