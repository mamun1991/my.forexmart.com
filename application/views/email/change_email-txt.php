<?php echo lang('che_00') ?><?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

<?php echo lang('che_01') ?> <?php echo $site_name; ?>.
<?php echo lang('che_02') ?>:

<?php echo FXPP::loc_url('/auth/reset_email/'.$user_id.'/'.$new_email_key); ?>


<?php echo lang('che_03') ?>: <?php echo $new_email; ?>


<?php echo lang('che_04') ?> <?php echo $site_name; ?> <?php echo lang('che_05') ?>.

<?php echo lang('che_06') ?>,
<?php echo lang('che_07') ?> <?php echo $site_name; ?> <?php echo lang('che_08') ?>