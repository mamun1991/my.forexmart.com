<?php $this->lang->load('email_footer');?>

<?php $this->load->view('email/_email_header');?>

<div>    
    <h1 class="h1" style="margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;">ForexMart MT4 Live Trading Account details</h1>
    <div class="content-grid" style="margin: 0 auto;padding: 15px;box-sizing: border-box;border-bottom: 1px solid #2988ca;padding-bottom: 60px;">
        <p class="greetings" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">Hi <?=$full_name; ?>,</p>
        <p class="letter-body" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;line-height: 19px;">

            Thank you for opening an MT4 account with ForexMart! Your login details are as follows:</p>
        <div style="margin:20px 0 20px 50px; text-align: left;">
            <p class="greetings" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">Cabinet login details.</p><br>
            <table style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;text-align: justify;line-height: 19px;">
                <tr>
                    <th > Username:</th>
                    <td > <?= $email; ?></td>
                </tr>
            </table>
            <p style="font-size: 14px;font-family: Arial sans-serif;font-weight: 400;color: #555;margin: 25px 0px 30px 0px;text-align: justify;"><a href="https://my.forexmart.com/client/signin" style="background: none repeat scroll 0 0 #29A643; border: 1px solid #00AE00; color: #fff; font-family: Arial; font-size: 15px; font-weight: 500; padding: 8px 25px; transition: all 0.3s ease 0s; text-decoration: none;">
                    Login to cabinet </a></p>
        </div>

        <div style="margin:20px 0 20px 50px;text-align: left;">
            <p class="greetings" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;">MT4 login details.</p><br>
            <table style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;text-align: justify;line-height: 19px;">
                <tr>
                    <th >Account number:</th>
                    <td > <?= $account_number; ?></td>
                </tr>
                <tr>
                    <th>Trader password:</th>
                    <td> <?= $trader_password; ?></td>
                </tr>
                <!-- <tr>
                     <th>Phone Password:</th>
                     <td>[phone password]</td>
                 </tr>-->
                <tr>
                    <th>Investor Password:</th>
                    <td> <?= $investor_password; ?></td>
                </tr>
                <tr>
                    <th>Phone Password:</th>
                    <td> <?= $phone_password; ?></td>
                </tr>

                <tr>
                    <th>MT4 Live Server:</th>
                    <td><?php echo MT4_SERVER_LIVE ?></td>
                </tr>


            </table>
            <p style="font-size: 14px;font-family: Arial sans-serif;font-weight: 400;color: #555;margin: 25px 0px 30px 0px;text-align: justify;"><a href="https://download.mql5.com/cdn/web/instant.trading.eu/mt4/forexmart4setup.exe" style="background: none repeat scroll 0 0 #2988CA; border: 1px solid #2988ca; color: #fff; font-family: Arial; font-size: 15px; font-weight: 500; padding: 8px 25px; transition: all 0.3s ease 0s; text-decoration: none;">
                    Download MT4 desktop platform </a></p>

        </div>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            Keep your account details safe and secure at all times.
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        We also offer several ways to deposit money into your account. You can quickly and securely make deposits via credit/debit card,from your bank account through online money transfer services such as Skrill, Neteller, Payco and many more. Please click here to know more about our different <a href="https://www.forexmart.com/deposit-withdraw-page"> Deposit</a> Methods.
            
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            You are categorized as a Retail Client. If you desire to be reclassified, kindly send a request to us and follow the steps outlined in the Client Categorisation. You can start trading once your request is approved.
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            For more information, please do not hesitate to contact us at support@forexmart.com.
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            May you have a successful trading!
        </p>
        <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
            All the best, <br style="margin: 0 auto;">
            <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team
        </p>



       
    </div>
</div> 
<?php $this->load->view('email/_email_footer');?>