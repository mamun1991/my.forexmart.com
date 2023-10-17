<?php $this->load->view('email/_email_internal_email_header');?>
<div class="wrapper-body" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 10px 0;margin-top: 3px;border-top: 1px solid #2988ca;border-bottom: 1px solid #2988ca;padding-bottom: 20px;">

    <h2 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;page-break-after: avoid;font-family: Georgia,'Times New Roman',serif;font-weight: 500;line-height: 1.1;color: #2988ca;margin-top: 20px;margin-bottom: 10px;font-size: 22px;text-align: left;">
        <?=$subject?>
    </h2>
 
    <table border="1" cellspacing="0" cellpadding="0"  style="font-size: 14px;font-family: Arial;font-weight: 400;color: #555;text-align: center;line-height: 19px; width: 100%">
        <tr>
            <th style="width: 6%"> No.</th>
            <th >Full name</th>
            <th >Account Number</th>
            <th >Phone Number </th>
            <th >Email</th>
            <th >Address </th>
            <!--<th >Email</th>-->
        </tr>
        <?php
        if($client_country){
            foreach( $client_country as $key => $value ){ ?>
                <tr>
                    <td><?=$no--;?></td>
                    <td style="text-align: left;padding-left: 4px;"><?=$value->full_name?></td>
                    <td><?=$value->account_number?></td>
                    <td><?=$value->phone1?></td>
                    <td><?=$value->email?></td>
                    <td style="text-align: left;padding-left: 4px;"><?=$value->city.", ".$value->state.","?><?=isset($country[$value->country])?$country[$value->country]:""?></td>

                </tr>
            <?php }}else{
            echo "<tr><td style='text-align: center' colspan='6'> No records found  </td></tr>";
        } ?>
    </table>


</div>
<?php //$this->load->view('email/_email_footer');?>
