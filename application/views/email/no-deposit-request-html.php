<?php $this->load->view('email/_email_header');?>
<?php $this->lang->load('nodepositrequest_email');?>
    <div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_00')?>,
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_01')?>.
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_02')?>.
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_03')?>
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_04')?>.
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_05')?>.
        </p>
        <p style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;text-align: justify;">
            <?=lang('ndr_06')?>.
        </p>
        <p class="closing" style="margin: 0 auto;font-size: 14px;font-family: Arial;font-weight: 400;color: #555;margin-top: 15px;line-height: 19px;">
            <?=lang('ndr_07')?>, <br style="margin: 0 auto;">
            <span style="margin: 0 auto;font-weight: 600;color: #2988ca;"><?=lang('ndr_08')?></span>
        </p>
    </div>
<?php $this->load->view('email/_email_footer');?>

