<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?= lang('rpe_08') . ' ' . $site_name; ?></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">>
    <?php $this->lang->load('resetpassword_email');?>
    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?= lang('rpe_08') . ' ' . $site_name; ?></h2>
                <?=lang('rpe_01')?>.<br />
                <?=lang('rpe_02')?>.<br />
                <br />
                <?php if (strlen($username) > 0) { ?><?=lang('rpe_03')?>: <?php echo $username; ?><br /><?php } ?>
                <?=lang('rpe_04')?>: <?php echo $email; ?><br />
                <?php /* Your new password: <?php echo $new_password; ?><br /> */ ?>
                <br />
                <br />
                <?=lang('rpe_05')?>,<br />
                <?=lang('rpe_06')?> <?php echo $site_name; ?> <?=lang('rpe_07')?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
