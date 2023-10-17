<?php $this->load->view('email/_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        Dear <?php echo $full_name ?>,
    </p>
    <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
        <?php echo $body ?>
    </p>
    <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
        Best Regards, <br style="margin: 0 auto;">
        <span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team
    </p>
</div>
<?php $this->load->view('email/_email_footer');?>
