<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?= lang('che_09') . ' ' . $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <?php $this->lang->load('change_email');?>
    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo lang('che_09') . ' ' . $site_name; ?></h2>
                <?php echo lang('che_01') . ' ' . $site_name; ?>.<br />
                <?php echo lang('che_02') ?>:<br />
                <br />
                <big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo lang('che_10') ?></a></b></big><br />
                <br />
                <?php echo lang('che_11') ?>:<br />
                <nobr><a href="<?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?></a></nobr><br />
                <br />
                <br />
                <?php echo lang('che_12') ?>: <?php echo $new_email; ?><br />
                <br />
                <br />
                <?php echo lang('che_04') ?> <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> <?php echo lang('che_05') ?>.<br />
                <br />
                <br />
                <?php echo lang('che_06') ?>,<br />
                <?php echo lang('che_07') . ' ' . $site_name . ' ' . lang('che_08'); ?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
