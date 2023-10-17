<script src="<?= $this->template->Js()?>jquery.js"></script>
<body onLoad="document.form.submit();">
<form id="form" name="form" method="post" action="<?php echo $url?>">

    <?php foreach($cup_pra as $key=>$value){?>
        <input type="hidden" name="<?php echo $key?>" value="<?php echo $value?>"/>
    <?php }?>

</form>

<p> Sending data... Please wait...</p>

</body>