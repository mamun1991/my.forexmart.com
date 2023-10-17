<?php /**
 * design removed
<div id="mainright" class="fix-holder">
<div id="fix-menu" class="fix-menu">
<a class="opt" href="#">
<div class="input-group">
<span data-original-title="LiveChat" class="input-group-addon fix-icon2" data-toggle="tooltip" data-placement="left" title="">
<i class="fa fa-weixin"></i>
<p class="lbl-live">Live Chat</p>
</span>
</div>
</a>
</div>
<!--    <div id="fix-menu" class="fix-menu">-->
<!--        <a href="#popfeedback"id="callfeedback" class="opt" data-toggle="modal" data-target="#popfeedback">-->
<!--            <div class="input-group">-->
<!--                    <span data-original-title="Feedback" class="input-group-addon fix-icon3" data-toggle="tooltip" data-placement="left" title="">-->
<!--                        <i class="fa fa-comments-o"></i>-->
<!--                        <p class="lbl-live">Feedback</p>-->
<!--                    </span>-->
<!--            </div>-->
<!--        </a>-->
<!--    </div>-->
</div>
<script>
    $(function(){
        $('#callfeedback').click(function( ) {
            $('#FeedbackFormRating')
                .addClass('formshow')
                .removeClass('formhide');
            $('#FeedbackFormSuccess')
                .addClass('formhide')
                .removeClass('formshow');
            $('#FeedbackFormDone')
                .addClass('formhide')
                .removeClass('formshow');
            $('.modalfeedbackcontent').removeClass('setsuccessheight');
        });
    });
</script>
*/ ?>