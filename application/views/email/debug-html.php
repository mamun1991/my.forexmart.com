<?php $this->load->view('email/_email_header');?>
<?php $this->lang->load('live-account-html');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
   <?php echo $message ?>
</div>

<?php $this->load->view('email/_email_footer');?>
