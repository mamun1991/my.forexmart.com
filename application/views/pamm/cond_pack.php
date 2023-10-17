<div class="pamm-content-input">

    <div class="custom_h1_uline">
        <label class="custom_h1">
            Conditions paсkage №<?=$no;?>
        </label>
    </div>

        <input type="hidden" value="<?=$no;?>" name="condition<?=$no;?>" />

       <?php  if($no!=1){ ?>

           <?php  if (isset($infor[$no]['status']) && ($infor[$no]['status']==1 )){
               $check0='checked';
           }else{
               $check0='';
           }  ?>

           <div class="from-group package-holder">
               <input type="hidden" value="0" name="inlinecheck<?=$no;?>" />
               <input type="checkbox" id="inlinecheck<?=$no;?>" name="inlinecheck<?=$no;?>"  value="1" class="conditionpackage" <?= set_value('inlinecheck'.$no) == false ? $check0 :  (set_value('inlinecheck'.$no)==1)?'checked':''  ?>> Apply to investments from
               <input type="text" class="form-control round-0 radio-textbox" value="<?= set_value('inv_from'.$no) == false ? ((isset($infor[$no]['apply_investment_from']))?$infor[$no]['apply_investment_from']:0) : set_value('inv_from'.$no) ?>" name="inv_from<?=$no;?>" id="inv_from<?=$no;?>"/>
           </div>
       <?php

           $check1 = set_value('inlinecheck'.$no) == false ? $check0 :  (set_value('inlinecheck'.$no)==1)?'checked':'';
           if ($check1=='checked'){
               $hide='';
           }else{
               $hide='hide';
           }

       }else{ $hide=''; ?>
           <input type="hidden" value="1" name="inlinecheck<?=$no;?>" />
           <input type="hidden" value="0" name="inv_from<?=$no;?>" />
       <?php } ?>

    <div id="div_inlinecheck<?=$no;?>" class="<?=$hide;?>">

        <p>
            This condition is set during the registration in the PAMM-system and can not be changed.
        </p>
        <h2 class="pamm-title-sub">
            Minimal investment timeframe
        </h2>
        <div class="minimal-investment-holder">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 control-label">
                    Days:
                </label>
                <div class="col-sm-5">
                    <div style="width: 100%;" id="c<?=$no;?>d" name="c<?=$no;?>d" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="90" data-slider-step="1" data-slider-value="<?= set_value('c'.$no.'d') == false ? (isset($infor[$no]['days'])?$infor[$no]['days']:0) : set_value('c'.$no.'d') ?>">
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control round-0" id="i_c<?=$no;?>d" name="i_c<?=$no;?>d" value="<?= set_value('i_c'.$no.'d') == false ? (isset($infor[$no]['days'])?$infor[$no]['days']:0) : set_value('i_c'.$no.'d') ?>" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 control-label">
                    Hours:
                </label>
                <div class="col-sm-5">
                    <div style="width: 100%;" id="c<?=$no;?>h" name="c<?=$no;?>h" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="23" data-slider-step="1" data-slider-value="<?= set_value('c'.$no.'h') == false ? (isset($infor[$no]['hours'])?$infor[$no]['hours']:0) : set_value('c'.$no.'h') ?>">
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control round-0" id="i_c<?=$no;?>h" name="i_c<?=$no;?>h" value="<?= set_value('i_c'.$no.'h') == false ? (isset($infor[$no]['hours'])?$infor[$no]['hours']:0) : set_value('i_c'.$no.'h') ?>" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 control-label">
                    Project Share:
                </label>
                <div class="col-sm-5">
                    <div style="width: 100%;" id="c<?=$no;?>ps" name="c<?=$no;?>ps" data-slider-id='ex1Slider' type="text" data-slider-min="1" data-slider-max="80" data-slider-step="1" data-slider-value="<?= set_value('c'.$no.'ps') == false ? ((isset($infor[$no]['project_share']))?$infor[$no]['project_share']:0) : set_value('c'.$no.'ps') ?>">
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control round-0" id="i_c<?=$no;?>ps" name="i_c<?=$no;?>ps" value="<?= set_value('i_c'.$no.'ps') == false ? (isset($infor[$no]['project_share'])?$infor[$no]['project_share']:0) : set_value('i_c'.$no.'ps') ?>" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-5 control-label" style="text-align: left!important;">
                    Prepayment penalty of the investment sum:
                </label>
                <div class="col-sm-5">
                    <div style="width: 100%;" id="c<?=$no;?>ppis" name="c<?=$no;?>ppis" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?= set_value('c'.$no.'ppis') == false ? ((isset($infor[$no]['prepaymentinvestmentsum']))?$infor[$no]['prepaymentinvestmentsum']:0) : set_value('c'.$no.'ppis') ?>">
                    </div>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control round-0" id="i_c<?=$no;?>ppis" name="i_c<?=$no;?>ppis" value="<?= set_value('i_c'.$no.'ppis') == false ? (isset($infor[$no]['prepaymentinvestmentsum'])?$infor[$no]['prepaymentinvestmentsum']:0) : set_value('i_c'.$no.'ppis') ?>" readonly/>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    var id='<?=$no;?>';
    var slider = new Slider('#c'+id+'d', {
        formatter: function(value) {
            $('#i_c<?=$no;?>d').val(value);
            return value;
        }
    });

    $('#c'+id+'d').on("slide", function(slideEvt) {
        $('#i_c<?=$no;?>d').val(slideEvt.value);
    });


    var slider = new Slider('#c'+id+'h', {
        formatter: function(value) {
            $('#i_c<?=$no;?>h').val(value);
            return value;
        }
    });
    $('#c'+id+'h').on("slide", function(slideEvt) {
        $('#i_c<?=$no;?>h').val(slideEvt.value);
    });


    var slider = new Slider('#c'+id+'ps', {
        formatter: function(value) {
            $('#i_c<?=$no;?>ps').val(value+ '%');
            return value + '%';
        }
    });

    $('#c'+id+'ps').on("slide", function(slideEvt) {
        $('#i_c<?=$no;?>ps').val(slideEvt.value+ '%');
    });


    var slider = new Slider('#c'+id+'ppis', {
        formatter: function(value) {
            $('#i_c<?=$no;?>ppis').val(value + '%');
            return value + '%';
        }
    });

    $('#c'+id+'ppis').on("slide", function(slideEvt) {
        $('#i_c<?=$no;?>ppis').val(slideEvt.value+ '%');
    });



    $("input#i_c"+id+"d").val($("div#c"+id+"d").val());
    $("input#i_c"+id+"h").val($("div#c"+id+"h").val());
    $("input#i_c"+id+"ps").val($("div#c"+id+"ps").val());
    $("input#i_c"+id+"ppis").val($("div#c"+id+"ppis").val());

//    $("input#i_c"+id+"ps").val($("div#c"+id+"ps").val()+'%');
//    $("input#i_c"+id+"ppis").val($("div#c"+id+"ppis").val()+'%');






</script>