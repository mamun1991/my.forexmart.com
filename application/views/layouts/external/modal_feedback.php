<?php $this->lang->load('feedback'); ?>
<div class="modal fade del" id="popfeedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog round-0 ">
        <div  class="modal-content round-0 modalfeedbackcontent">
            <div class="modal-header popheader">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-title poptitle" id="myModalLabel">
                    <img src="<?= $this->template->Images()?>feedback_fx.png" height="66px" alt="logo" class="img-reponsive fmodal">
                </div>
            </div>

            <div id="FeedbackFormRating" class="formshow">
                <?= form_open('feedback',array('id' => 'form_feedback')); ?>
                <?php
                if(validation_errors()){
                    echo '<div class="bg-danger">';
                    echo validation_errors();
                    echo '</div>';
                }
                ?>
                <div class="modal-body modal-body1">
                    <p class="fback-first-line">
                        <?=lang('fid_bck_01')?>
<!--        Good day! We'd love to hear your feedback about your Account.-->
                    </p>
                    <p class="rate-line">
                        <small>
                            <?=lang('fid_bck_02')?>
<!--                            How would you rate your experience on a scale of 1-10?-->
                        </small>
                    </p>
                    <div class="row" dir="ltr">
                          <div class="col-sm-12 scale">
                              <div class="feedback-rate-holder" style="padding: 2px 12px 12px 12px">
                                <p>1 - <?=lang('fid_bck_13')?></p>
                                <p>10 - <?=lang('fid_bck_14')?></p>
                                <ul class="feedback-rate-list" id="listRating">
                                    <li>
                                        <input type="radio" id="c1" name="rate" value="1" class="rad rating">
                                        <label for="c1">1</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c2"  name="rate" value="2" class="rad rating">
                                        <label for="c2">2</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c3"  name="rate" value="3" class="rad rating">
                                        <label for="c3">3</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c4"  name="rate" value="4" class="rad rating">
                                        <label for="c4">4</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c5"  name="rate" value="5" class="rad rating">
                                        <label for="c5">5</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c6"  name="rate" value="6" class="rad rating">
                                        <label for="c6">6</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c7"  name="rate" value="7" class="rad rating">
                                        <label for="c7">7</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c8" name="rate" value="8" class="rad rating">
                                        <label for="c8">8</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c9"  name="rate" value="9" class="rad rating">
                                        <label for="c9">9</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="c10"  name="rate" value="10" class="rad rating">
                                        <label for="c10">10</label>
                                    </li><div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                        

                        
                        
                        
                    </div>
                    <p class="rate-line2">
                        <small>
                            <?=lang('fid_bck_15')?>
<!--                            Should you have any specific feedback, please select a category below.(optional)-->
                        </small>
                    </p>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group" style="margin-bottom: 50px">
                                <label for="" class="col-sm-3 control-label lblcat">
                                    <?=lang('fid_bck_16')?>
<!--                                    Category-->
                                </label>
                                <div class="col-sm-9">
                                    <?php
                                    $data['options'] = array(
                                        'Problem'     => lang('fid_bck_24'),
                                        'Suggestion'  => lang('fid_bck_25'),
                                        'Compliment'  => lang('fid_bck_26'),
                                        'Other'       => lang('fid_bck_27'),
                                    );
                                    $data['attributes'] = ' class="form-control round-0" id="select_category" ';
                                    echo form_dropdown('category', $data['options'], set_value('category', '') ,$data['attributes']);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-sm-12">
                                <textarea rows="5" class="form-control round-0 topadjust" name="textarea"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer round-0 popfooter">

                    <button type="button" data-dismiss="modal" aria-label="Close"  class="btn btn-default round-0 ">
                        <?=lang('fid_bck_23')?>
<!--                        Cancel-->
                    </button>

                    <?php
                    $data['button_submit']=  array(
                        'name'          => 'feedback',
                        'id'            => 'button_feedback',
                        'value'         => 'true',
                        'type'          => 'submit',
                        'class'          => 'btn btn-primary round-0',
                        'content'       => lang('fid_bck_28')
                    );
                    ?>

                    <?= form_button($data['button_submit']);?>

                </div>
                <?= form_close();?>
            </div>

            
            
            
            
            
            
            <div id="FeedbackFormSuccess" class="formhide">
                <?= form_open('feedback-email',array('id' => 'form_feedback_sendemail')); ?>
                <?php
                if(validation_errors()){
                    echo '<div class="bg-danger">';
                    echo validation_errors();
                    echo '</div>';
                }
                ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <p>
                                    <b>
                                        <?=lang('fid_bck_17')?>
<!--                                        Thank  you very much, your feedback has been successfully submitted.-->
                                    </b>
                                </p>
                                <p>
                                    <?=lang('fid_bck_18')?>
<!--                                    If you'd like us to follow up on your feedback, please enter your email address below. Rest assured your email will never be used for any other purpose.-->
                                </p>
                                <?php  $data = array(
                                    'name'          => 'email',
                                    'id'            => 'email',
                                    'type'         => 'email',
                                    'maxlength'     => '100',
                                    'size'          => '50',
                                    'class'          => 'form-control round-0',
                                );
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?=lang('fid_bck_22')?>:
<!--                                Email: -->
                                <?= form_input($data); ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer round-0 popfooter">
                    <?php $data['button_submit2']=  array(
                        'name'          => 'feedback_email',
                        'id'            => 'button_feedback',
                        'value'         => 'true',
                        'type'          => 'submit',
                        'class'          => 'btn btn-default round-0',
                        'content'       => 'Submit email address' ); ?>
                    <?= form_button($data['button_submit2']);?>
                    <button type="button" data-dismiss="modal" aria-label="Close"  class="btn btn-default round-0 ">
                        <?=lang('fid_bck_19')?>
<!--                        Close-->
                    </button>
                </div>
                <?= form_close();?>

            </div>

            <div id="FeedbackFormDone" class="formhide">
                <div class="modal-body">
                    <p>
                        <b>
                            <?=lang('fid_bck_20')?>
<!--                            Thank  you very much, E-mail has been submitted.-->
                        </b>
                    </p>
                </div>
                <div class="modal-footer round-0 popfooter">
                    <button type="button" data-dismiss="modal" aria-label="Close"  class="btn btn-default round-0 ">
                        <?=lang('fid_bck_21')?>
<!--                        Close-->
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- end modal -->
<?php unset($data);?>
<!-- modal -->
<style type="text/css">
    .formshow{
        visibility: visible;
        display: block;
    }
    .formhide{
        visibility: hidden;
        display: none;
    }
    .setsuccessheight{
        /*height: 285px;*/
    }
    div.bg-danger {
        background-color: #f2dede;
        padding: 5px;
        font-size: 12px;
        color: rgb(174, 21, 21) !important;
        text-align: center;
        border: 1px solid;
        margin: 20px;

    }

    div.bg-danger p {
        margin: 10px 10px!important;
        text-align: center !important;
        font-size: 12px !important;
        color: rgb(174, 21, 21) !important;
        line-height: 17px;
    }
    .modal-body1{
        padding: 0 15px;
    }
    @media (max-width: @screen-xs-min) {
        .modal-xs { width: @modal-sm; }
    }
    @media only screen and (min-width: 0px)  and (max-width: 600px) {
        .fmodal{
            width: 300px!important;
        }
    }
    @media only screen and (min-width: 0px)  and (max-width: 400px) {
        .fmodal{
            /*width: 101px!important;*/
            width: 235px!important;
        }
    }



    /*new*/
    .feedback-rate-holder
    {
        width: 100%;
        margin-top: 5px;
    }
    .feedback-rate-list
    {
        list-style: none;
        padding: 0;
        margin: 0;
        border: 1px solid #EAEAEA;
        margin-top: 10px!important;
    }
    .feedback-rate-list li
    {
        float: left;
        width: calc(100% / 10);
        text-align: center;
        display: block;
        border-left: 1px solid #EAEAEA;
    }
    .feedback-rate-list li:first-child
    {
        border-left: none;
    }
    .feedback-rate-list li .rad
    {
        display: none;
    }
    .feedback-rate-list li label
    {
        padding: 5px;
        font-size: 14px;
        margin: 0;
        background: #fafafa;
        display: block;
        color: #6a6a6a;
        cursor: pointer;
        transition: all ease 0.3s;
    }
    .feedback-rate-list li label:hover
    {
        background: #2988ca;
        color: #fff;
        transition: all ease 0.3s;
    }
    .feedback-rate-list li .rad:checked + label
    {
        background: #2988ca;
        color: #fff;
        transition: all ease 0.3s;
    }
    .feedback-rate-holder p
    {
        font-size: 12px;
        color: #6a6a6a;
        margin: 0;
    }

</style>

