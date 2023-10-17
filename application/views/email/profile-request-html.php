<?php $this->load->view('email/_email_internal_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">

    <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;color: #5a5a5a;text-align: justify;">
        <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;max-width: 100%;margin-bottom: 5px;font-weight: normal;color: #000;padding-top: 30px;">Good day,</label> <br>

        Here are the fields requested to be changed by <?=$name?>(<?=$account_number?>):
    </p>

    <table cellspacing="0" border="1">
        <tr>
            <th style="background-color: #CFE2F3">Field</th>
            <th style="background-color: #CFE2F3">Previous Value</th>
            <th style="background-color: #CFE2F3">New Value</th>
        </tr>
        <?php foreach( $change_fields as $key => $value ){ ?>
            <tr>
                <td><?php echo $value['field'] ?></td>
                <td><?php echo $value['old_value'] ?></td>
                <td><?php echo $value['new_value'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php //$this->load->view('email/_email_footer');?>

