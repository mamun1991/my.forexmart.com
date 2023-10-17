<style>
    .checkmodal{
        z-index: 10000;
    }
    .checkmodal-content{
        top: 50%;
        width: 80%;
    }
    .checkmodal-modal-dialog{
        top: 20%;
    }
    .check-btn-explore{
        margin-top: 0px!important;
        padding: 10px 80px;
    }
    .check-p{
        text-align: center;
    }
    .check-modal-body{
        padding: 26px 65px 10px 65px;
    }
    .check-mrgntp{
        margin-top:60px;
    }
    .check-h3{
        font-weight: bold;
        font-family: times;
        text-align: center;
        margin-bottom: 20px;
    }
    .check-ps{
      font-size: 16px;
    }
</style>

<div class="checkmodal modal fade" id="popbonus" tabindex="=-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="checkmodal-modal-dialog modal-dialog round-0 ">
        <div  class="checkmodal-content  modal-content round-0 ">
            <div class="check-modal-body modal-body">

                <h3 class="check-h3">No Deposit Bonus</h3>

                <p class="check-ps"> Below is the "No Deposit Bonus" to be credited. The bonus is fixed.</p>
                <p class="check-ps">
                    Bonus amount: <?=(isset($bonus))? $bonus: '';?> USD
                </p>
                <p class="check-p check-mrgntp">
                    <button class="check-btn-explore btn-explore" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                </p>
            </div>

        </div>
    </div>
</div>

