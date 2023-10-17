<?php echo lang('ave_00'); ?> <?php echo $site_name; ?>,

<?php echo lang('ave_01'); ?> <?php echo $site_name; ?>. <?php echo lang('ave_02'); ?>.
<?php echo lang('ave_03'); ?>:

<?php echo FXPP::loc_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>


<?php echo lang('ave_04'); ?> <?php echo $activation_period; ?> <?php echo lang('ave_05'); ?>.
<?php if (strlen($username) > 0) { ?>

    <?php echo lang('ave_06'); ?>: <?php echo $username; ?>
<?php } ?>

<?php echo lang('ave_07'); ?>: <?php echo $email; ?>
<?php if (isset($password)) { /* ?>

Your password: <?php echo $password; ?>
<?php */ } ?>

<?php echo lang('ave_08'); ?>!
<?php echo lang('ave_09'); ?> <?php echo $site_name; ?> <?php echo lang('ave_10'); ?>