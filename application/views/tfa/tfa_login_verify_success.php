<link href="<?= $this->template->Css()?>bootstrap.min.css" rel="stylesheet">
<link href="<?= $this->template->Css()?>custom-internal.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= $this->template->Css()?>loaders.css"/>

<?php /** Preloader Modal Start */ ?>
<div id="loader-holder" class="loader-holder" style="display: block !important;">
    <div class="loader">
        <div class="loader-inner ball-pulse">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<body onLoad="document.form.submit();">
<form id="form" name="form" method="post" action="<?=FXPP::my_url($type.'/signin')?>">
    <input id="username" name="username" type="hidden" value="<?php echo $credentials['username']; ?>" />
    <input id="password" name="password" type="hidden" value="<?php echo $credentials['password']; ?>" />
</form>
</body>

