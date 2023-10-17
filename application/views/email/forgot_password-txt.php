<?php echo lang('fpe_00') ?><?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

<?php echo lang('fpe_01') ?>.
<?php echo lang('fpe_02') ?>:

<?php echo FXPP::loc_url('/auth/reset_password/'.$user_id.'/'.$new_pass_key); ?>


<?php echo lang('fpe_03') ?> <?php echo $site_name; ?> <?php echo lang('fpe_04') ?>.

<?php echo lang('fpe_05') ?>,
<?php echo lang('fpe_06') ?> <?php echo $site_name; ?> <?php echo lang('fpe_07') ?>