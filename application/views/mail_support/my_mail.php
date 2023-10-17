<?php $this->view('mail_support/nav'); ?>

<style>
    .nonvisible {
        display: none;
    }
</style>
<div class="tab-content acct-cont">
    <div class="clearfix"></div>
    <div class="table-responsive" style="margin-top: 15px;overflow-x: hidden;">
        <table class="table table-striped tab-my-acct part-table arabic-part-table no-footer" id="mails">
            <thead>
                <th class="col-sm-2"><?= lang('ms_25'); ?></th>
                <th class="col-sm-6"><?= lang('ms_11'); ?></th>
                <th class="col-sm-3"><?= lang('ms_14'); ?></th>
                <th class="col-sm-1"><?= lang('ms_13'); ?></th>
            </thead>
            <tbody>
            <?php foreach ($inbox as $value) {
                $date_updated = new DateTime($value['date_updated']); ?>
                <tr>
                    <td><?= $value['id']; ?></td>
                    <td>
                        <a style="font-weight: <?= $value['mail_notif'] != 0 ? 'bold' : 'normal'; ?>" href="<?= FXPP::loc_url('mail-support/mail/'.$value['id']) ?>" onclick="manageMail('<?=$value['id']?>')">
                            <?= $value['subject']; ?>
                            <span class="<?= $value['mail_notif'] == 0 || $value['mail_notif'] == 1 ? 'nonvisible': ''; ?>">(<?= $value['mail_notif']; ?>)</span>
                        </a>
                    </td>
                    <td><?= $date_updated->format('d M Y H:i A'); ?></td>
                    <td><?= $value['status'] == 1 ? lang('ms_15') : lang('ms_16'); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php /*if (empty($inbox)) {
            echo '<span class="col-sm-12" style="text-align: center; margin-bottom: 50px;">' . lang('fer_03') . '</span>';
        } */?>
    </div>
</div>

<script type="text/javascript">
    var url = '<?= base_url()?>';

    $(window).load(function() {
        $('#mails').DataTable({
			"order": [[ 2, "desc" ]],
			"language":{
				search:'<?=lang('curtra_s')?>',
				lengthMenu: '<?=lang('dta_tbl_07')?>',
				info: '<?=lang('dta_tbl_02')?>',
				zeroRecords: '<?=lang('dta_tbl_01')?>',
				paginate: {
					next:       '<?=lang('dta_tbl_14')?>',
					previous:   '<?=lang('dta_tbl_15')?>'
				}
			}
			
		});
    });

    function manageMail(thread_id) {
        // Check notification
        $.post(url + 'mail-support/getMailNotification', {thread_id:thread_id}, function (data) {
            console.log(data);
        });
    }
</script>