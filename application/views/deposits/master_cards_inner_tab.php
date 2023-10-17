
<style>
.master_cards_main_div{width: 100%;}    
.master_cards_main_div ul li{
    min-width: 20%;
    text-align: center;
    margin-left: -16px;
    border-radius: 20px;
}
.master_cards_main_div ul li.active a{
    background: green;
    color: white;
    font-weight: bold;
}

</style>

<div class="master_cards_main_div">
    
    
 <ul class="nav nav-tabs">
     <li class="<?=($innertab=="nova2pay")?'active':''?>"><a href="<?=base_url('deposit/master-cards?card=nova2pay')?>">Nova2Pay</a></li>
     <li class="<?=($innertab=="zotapay")?'active':''?>"><a href="<?=base_url('deposit/master-cards?card=zotapay')?>">Zotapay</a></li>
     <li class="<?=($innertab=="payoma")?'active':''?>"><a href="<?=base_url('deposit/master-cards?card=card-documents')?>">Payoma</a></li>
  </ul>

</div>