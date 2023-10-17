<?php $this->load->view('email/_email_header');?>
    <div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
        <h2 class="h1" style="margin: 0 auto;font-family: Georgia;font-weight: 400;font-size: 25px;color: #2988ca;margin-top: 30px;margin-bottom: 30px;border-bottom: 1px solid #2988ca;padding-bottom: 10px;padding-left: 15px;">
            <?=$subject;?>
        </h2>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">

            Dear <?php echo $full_name ?>,
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?= $details; ?>
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Your request was accepted and the transfer will be processed by the Finance Department of Forexmart in the nearest future. 
        </p>

        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        This letter was generated automatically and doesn’t require any response. <br>
        If you have any questions, please contact our <a href="https://www.forexmart.com/contact-us">support team</a>. 
      
        </p>


        <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
        Sincerely, <br style="margin: 0 auto;">
            <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">Automatic Notification Service.</span>
        </p>
    </div>
<?php $this->load->view('email/_email_footer');?>