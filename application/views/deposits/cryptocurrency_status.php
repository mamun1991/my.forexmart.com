
<h1>
<?= lang('trd_10'); ?>
</h1>
<div class="row tab-content">
    <div class="col-lg-11 col-centered tab-pane active" id="nt-tab">

        <form method="post" action="" class="form-horizontal" style="margin-top: 50px;" >

           

            <div class="form-group" style="text-align: center;">
                <img src="<?= $this->template->Images()?>bitcoinlogo.png" border="0" alt="" style="width: 200px; margin-bottom: 15px;"/>
            </div>


            <div class="form-group">

            <?php if($invData['status']!=1){?>
            <p>Please send the payment to the following bitcoin address: <?php echo  $invData['input_address']?>
            <p align="center">
                <img src="https://apirone.com/api/v1/qr?message=<?php echo urlencode ("bitcoin:". $invData['input_address'])?>&format=png"  width="300" alt="QR code">
            </p>
            <?php }?>

               <table class="table">
                  
               <tr>
                       <td>Bitcoin address</td> 
                       <td><?php echo $invData['input_address']?></td>
                   </tr>
                <tr>
                       <td>Order Id</td> 
                       <td><?php echo $invData['order_id']?></td>
                   </tr>
                   <tr>
                       <td>Payment Date</td> 
                       <td><?php echo $invData['create_date']?></td>
                   </tr>

                   <tr>
                       <td>Payment Status</td> 
                       <td>
                           <?php if($invData['status']==1){
                           echo "Payment done!";
                       } else{?>
                       
                      <b> Waiting for Payment Confirmation </b>
                      ( <a href="<?php echo FXPP::loc_url('deposit/cryptocurrency_status')."/".$invData['order_id']; ?>">Refresh</a> )
                       <?php }?>
                    </td>
                   </tr>

               </table>
            </div>

           
           


            
        </form>
    </div>

</div>


