<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?= lang('fpe_09') . ' ' . $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <?php $this->lang->load('forgotpassword_email');?>
    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?=lang('fpe_08')?></h2>
                <?=lang('fpe_01')?>.<br />
                <?=lang('fpe_02')?>:<br />
                <br />
                <big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo FXPP::loc_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;"><?=lang('fpe_08')?></a></b></big><br />
                <br />
                <?=lang('fpe_10')?>:<br />
                <nobr><a href="<?php echo FXPP::loc_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;"><?php echo FXPP::loc_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?></a></nobr><br />
                <br />
                <br />
                <?=lang('fpe_03')?> <a href="<?php echo FXPP::loc_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> <?=lang('fpe_04')?>.<br />
                <br />
                <br />
                <?=lang('fpe_05')?>,<br />
                <?=lang('fpe_06')?> <?php echo $site_name; ?> <?=lang('fpe_07')?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
