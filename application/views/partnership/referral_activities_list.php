<?php
foreach($activities as $d){
$rDate = $d['processTime'];
$rAcc=$d['accountNumber'];
$rAffCode= '';
$rCountry= $d['country'];
$rTransection = $d['comment'];


$rDetails='Details';

?>
<tr onclick="viewDetailsMob('<?=$rDate?>','<?=$rAcc?>','<?=$rAffCode?>','<?=$rCountry?>','<?=$rTransection?>')">

    <td class="crTradesMob"><?php echo $rDate;?></td>
    <td><?php echo $rAcc; ?></td>
    <td class="crTradesMob"><?php echo $rCountry; ?> </td>
    <td class="crTradesMob"><?php echo $rTransection; ?> </td>
    <td class="crTradesWeb crTradesWebStyle"><?php echo $rDetails; ?> </td>



</tr>


<?php } ?>