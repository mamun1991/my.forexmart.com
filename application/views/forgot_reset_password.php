<div class="reg-form-holder">
    <div class="container">
        <div class="row col-centered">
            <h1 class="info-text">New Password</h1>
            <div class="col-lg-2 col-md-2 ">

            </div>

            <?php if(isset($success)){ ?>
                <div class="col-lg-6 col-md-6">
                    <div class="alert alert-success forgot-success">You have successfully reset your password.</div>
                </div>
            <?php }else{ ?>
                <div class="col-lg-8 col-md-8">
                    <div class="form-holder" >

                        <?php
                        if(validation_errors())
                        {
                            echo '<div class="alert alert-danger">';
                            echo validation_errors();
                            echo '</div>';
                        }
                        ?>

                        <?= form_open('reset-password/'.$token,array('id' => 'form_login','class'=> 'form-horizontal')); ?>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Password<cite class="req">*</cite></label>
                            <div class="col-sm-6">
                                <input class="form-control round-0" type="password" name="password" placeholder="Password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Re-enter Password<cite class="req">*</cite></label>
                            <div class="col-sm-6">
                                <input class="form-control round-0" type="password" name="confirm_password" placeholder="Re-enter Password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn-sign">Submit</button>
                                <div class="clearfix"></div>
                                <div class="blue-line"></div>
                            </div>
                        </div>

                        <?php echo form_close()?>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>