<?php $this->load->view('email/_email_internal_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">

    <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;color: #5a5a5a;text-align: justify;">
        <label style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;max-width: 100%;margin-bottom: 5px;font-weight: normal;color:#2988ca; font-size: 20px;padding-top: 30px;">
       <?=$email_data['heading']?></label> <br>
 
    </p>

    <table cellspacing="0" border="1">
        
        <?php 
        unset($email_data['heading']);
        foreach($email_data as $key=>$val)
        {?>
        
        <tr>
            <th style="padding: 5px; text-align: left"><?php if($key == 'Account'){ echo 'Account Number'; }else{ echo $key; } ?></th>
            <td style="width: 20px; text-align: center">:</td>
            <td style="padding: 5px; text-align: left"><?=$val?></td>
        </tr>
 
       <?php }?>
 
    </table>
</div>
<?php //$this->load->view('email/_email_footer');?>

