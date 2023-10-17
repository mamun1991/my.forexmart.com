<style type="text/css">
    div.forgot-success{
        text-align: center;
        padding: 30px;
        margin-top: 20px;
    }
    div.forgot-password-holder{
        min-height: 300px;
    }
</style>
<div class="reg-form-holder">
    <div class="container">
        <div class="row col-centered">
            <div class="forgot-password-holder">
                <h1 class="info-text">SMS Security Code</h1>
                <div class="col-lg-3 col-md-3 "></div>
                <?php
                $flash = $this->session->flashdata("success");
                if(isset($flash))
                {
                    ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="alert alert-success forgot-success">We sent you an email containing the link to reset your password.</div>
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
                            echo isset($msg)?'<div class="alert alert-danger">'.$msg.'</div>':"";
                            ?>

                            <?= form_open('',array('id' => 'form_login','class'=> 'form-horizontal')); ?>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Security Code<cite class="req">*</cite></label>
                                <div class="col-sm-5">
                                    <input class="form-control round-0" type="text" name="security_code" placeholder=""/>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
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
</div>
