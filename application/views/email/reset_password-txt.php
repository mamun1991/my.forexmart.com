<?php echo lang('rpe_00') ?><?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

<?php echo lang('rpe_01') ?>.
<?php echo lang('rpe_02') ?>.
<?php if (strlen($username) > 0) { ?>

    <?php echo lang('rpe_03') ?>: <?php echo $username; ?>
<?php } ?>

<?php echo lang('rpe_04') ?>: <?php echo $email; ?>

<?php /* Your new password: <?php echo $new_password; ?>

*/ ?>
<?php echo lang('rpe_05') ?>,
<?php echo lang('rpe_06') ?> <?php echo $site_name; ?> <?php echo lang('rpe_07') ?>