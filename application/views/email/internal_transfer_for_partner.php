<?php $this->load->view('email/_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
    <h2 class="h1" style="margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;">

        <?=$subject;?>
    </h2>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">

        Dear <?php echo $full_name ?>,
    </p>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">

        Your internal transfer request has been sent.
    </p>

    <div style="text-align: left;">
        <table cellspacing="7" border="0" style="width: 100%; border: 1px solid #000;">
            <tr>
                <td width="20%">Name:</td>
                <td style="font-weight: bold"><?php echo $full_name ?></td>
            </tr>
            <tr>
                <td width="20%">Account number:</td>
                <td style="font-weight: bold"><?php echo $account_number ?></td>
            </tr>
            <tr>
                <td width="20%">E-mail:</td>
                <td style="font-weight: bold"><?php echo $email ?></td>
            </tr>

        </table>
    </div>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Should you have any assistance, please contact us at partnership@forexmart.com.
    </p>
    <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
        Best Regards, <br style="margin: 0 auto;">
        <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team
    </p>
</div>
<?php $this->load->view('email/_email_footer');?>
