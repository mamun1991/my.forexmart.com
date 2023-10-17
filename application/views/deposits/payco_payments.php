<body onLoad="document.form.submit();">
    <form id="form" name="form" method="post" action="<?php echo $urlaction?>">
        <input id="desc" name="desc" type="hidden" value="<?php echo $desc?>" />
        <input id="curr" name="curr" type="hidden" value="<?php echo $curr?>" />
        <input id="amt" name="amt" type="hidden" value="<?php echo $amt?>" />
        <input id="choice" name="choice" type="hidden" value="<?php echo $choice?>" />
        <input id="MID" name="MID" type="hidden" value="<?php echo $MID?>" />
        <input id="TID" name="TID" type="hidden" value="<?php echo $TID?>" />
        <input id="MWALLET" name="MWALLET" type="hidden" value="<?php echo $MWALLET?>" />
        <input id="SIGN" name="SIGN" type="hidden" value="<?php echo $SIGN?>" />
        <input id="choice" name="choice" type="hidden" value="<?php echo $choice?>" />
    </form>
</body>