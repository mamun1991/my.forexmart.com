<style>
        .maintenance_div{text-align: center;
    width: 100%;
    position: absolute;
    height: auto;
    min-height: 200px;}
 
.maintencebutton {
    height: 45px;
    font-size: 15px;
    font-weight: bold;
    color: black;
            
        }   
</style>

<div class="maintenance_div">
    <img class="img" src="<?= $this->template->Images() ?>maintenance_is_ongoing.png" />
    <a href="<?=$_SERVER['HTTP_REFERER']?>"> <button class="maintencebutton"> << Back to previous page </button></a>
    
      
    
</div>