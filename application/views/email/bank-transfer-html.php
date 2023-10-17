<?php $this->load->view('email/_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
    <h2 class="h1" style="margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;">Deposit - Bank Transfer</h2>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Dear <?php echo $full_name ?>,
    </p>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Please refer to the attached Wire Transfer Form which contains details which your preferred bank require in order to make a deposit to your ForexMart Account. Please print this out and send it to your bank of processing.
    </p>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Please see the details of your transaction below.
    </p>
    <div style="text-align: left;">
    <table cellspacing="7" border="0" style="width: 100%; border: 1px solid #000;">
            <tr>
                <td width="20%">TRANSACTION TYPE:</td>
                <td style="font-weight: bold">Deposit</td>
            </tr>
            <tr>
                <td width="20%">PAYMENT METHOD:</td>
                <td style="font-weight: bold">Bank Wire</td>
            </tr>
            <tr>
                <td width="20%">CLIENT'S NAME:</td>
                <td style="font-weight: bold"><?php echo $full_name ?></td>
            </tr>
            <tr>
                <td width="20%">TRANSACTION DATE:</td>
                <td style="font-weight: bold"><?php echo date('d M Y H:i', strtotime($date_now)) ?></td>
            </tr>
            <tr>
                <td width="20%">YOUR BANK'S NAME:</td>
                <td style="font-weight: bold"><?php echo $bank_name ?></td>
            </tr>
            <tr>
                <td width="20%">AMOUNT:</td>
                <td style="font-weight: bold"><?php echo $amount ?></td>
            </tr>
            <tr>
                <td width="20%">CURRENCY:</td>
                <td style="font-weight: bold"><?php echo $currency ?></td>
            </tr>
            <tr>
                <td width="20%">COMMENT:</td>
                <td style="font-weight: bold">Account Number: <?php echo $account_number ?></td>
            </tr>
    </table>
    </div>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        ForexMart - ELECTRONIC WIRE FUND TRANSFER DETAILS
    </p>
    <div style="text-align: left;">
        <table cellspacing="7" border="0" style="width: 100%; border: 1px solid #000;">
            <tr>
                <td width="20%">ACCOUNT NAME:</td>
                <td style="font-weight: bold"><?php echo $beneficiary_account_name ?></td>
            </tr>
            <tr>
                <td width="20%">BANK NAME:</td>
                <td style="font-weight: bold"><?php echo $beneficiary_bank_name ?></td>
            </tr>
            <tr>
                <td width="20%">BANK ADDRESS:</td>
                <td style="font-weight: bold"><?php echo $beneficiary_bank_address ?></td>
            </tr>
            <tr>
                <td width="20%">SWIFT:</td>
                <td style="font-weight: bold"><?php echo $beneficiary_swift ?></td>
            </tr>
            <tr>
                <td width="20%">ACCOUNT NUMBER:</td>
                <td style="font-weight: bold"><?php echo $bank_account_number ?></td>
            </tr>
            <tr>
                <td width="20%">IBAN:</td>
                <td style="font-weight: bold"><?php echo $bank_iban ?></td>
            </tr>
        </table>
    </div>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Should you have any assistance, please contact us at finance@forexmart.com.
    </p>
    <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
        Best Regards, <br style="margin: 0 auto;">
        <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team
    </p>
</div>
<?php $this->load->view('email/_email_footer');?>

