
<style type="text/css">
    body {
        background: #fafafa url(../images/administration/noise-diagonal.png);
        color: #444;
        /*font: 100%/30px 'Helvetica Neue', helvetica, arial, sans-serif;*/
        text-shadow: 0 1px 0 #fff;
    }

    strong {
        font-weight: bold;
    }

    em {
        font-style: italic;
    }

    table {
        background: #f5f5f5;
        border-collapse: separate;
        box-shadow: inset 0 1px 0 #fff;
        font-size: 12px;
        line-height: 24px;
        margin: 30px auto;
        text-align: left;
        width: 800px;
    }

    th {
        background: url(../images/administration/noise-diagonal.png), linear-gradient(#777, #444);
        border-left: 1px solid #555;
        border-right: 1px solid #777;
        border-top: 1px solid #555;
        border-bottom: 1px solid #333;
        box-shadow: inset 0 1px 0 #999;
        color: #fff;
        font-weight: bold;
        padding: 10px 15px;
        position: relative;
        text-shadow: 0 1px 0 #000;
    }

    th:after {
        background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
        content: '';
        display: block;
        height: 25%;
        left: 0;
        margin: 1px 0 0 0;
        position: absolute;
        top: 25%;
        width: 100%;
    }

    th:first-child {
        border-left: 1px solid #777;
        box-shadow: inset 1px 1px 0 #999;
    }

    th:last-child {
        box-shadow: inset -1px 1px 0 #999;
    }

    td {
        border-right: 1px solid #fff;
        border-left: 1px solid #e8e8e8;
        border-top: 1px solid #fff;
        border-bottom: 1px solid #e8e8e8;
        padding: 10px 15px;
        position: relative;
        transition: all 300ms;
    }

    td:first-child {
        box-shadow: inset 1px 0 0 #fff;
    }

    td:last-child {
        border-right: 1px solid #e8e8e8;
        box-shadow: inset -1px 0 0 #fff;
    }

    tr {
        background: url(../images/administration/noise-diagonal.png);
    }

    tr:nth-child(odd) td {
        background: #f1f1f1 url(../images/administration/noise-diagonal.png);
    }

    tr:last-of-type td {
        box-shadow: inset 0 -1px 0 #fff;
    }

    tr:last-of-type td:first-child {
        box-shadow: inset 1px -1px 0 #fff;
    }

    tr:last-of-type td:last-child {
        box-shadow: inset -1px -1px 0 #fff;
    }

    tbody:hover td {
        color: transparent;
        text-shadow: 0 0 3px #aaa;
    }

    tbody:hover tr:hover td {
        color: #444;
        text-shadow: 0 1px 0 #fff;
    }

    /* paging */
    .centerme{
        text-align: center;
    }
    /* paging */
    /* add news**/
    ul.add{
        display: inline-block;
        list-style: outside none none;
    }
    ul.add>li{
        padding-left: 100px;
    }
    ul.horizontal{
        display: inline-block;
        list-style: outside none none;
    }
    ul.horizontal>li{
        float: left;
    }
    ul.horizontal>li:first-child {
        width: 200px;
    }
    /* add news**/
    .definewidth{
        width: 274px;
    }
.successcolor{
    color: green;
}
</style>

<div class="reg-form-holder">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="license-title">Company News</h1>
                    <table>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Link</th>
                            <th>Date</th>
                            <th><?= lang('reb_txt_13'); ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        foreach($results as $data) {
                            echo ' <tr>';
                            echo ' <td><strong>'.$data->id.'</strong></td>';
                            echo ' <td>'.$data->user_id.'</td>';
                            echo ' <td>'.$data->title.'</td>';
                            echo ' <td>'.$data->message.'</td>';
                            echo ' <td>'.$data->link.'</td>';
                            echo ' <td>'.$data->date_created.'</td>';
                            echo ' <td>';
                            echo  form_open('administration/deleteNews',array('name' => 'form_delete','class'=> ''),'');
                            echo  form_button(
                                array(
                                    'name'          => 'button_delete',
                                    'value'         => $data->id,
                                    'type'          => 'submit',
                                    'class'          => 'btn-sign',
                                    'content'       => 'Delete'
                                )
                            );
                            echo  form_close();
                            echo '</td>';
                            echo ' </tr>';
                        }
                        ?>
                        </tbody>
                    </table>

                    <div class="pagination-holder centerme" >
                        <nav>
                            <ul class="pagination">
                                <?php echo $links; ?>
                            </ul>
                        </nav>
                    </div>

                    <?= form_open('administration/news',array('id' => 'form_news','class'=> ''),''); ?>


                        <ul class="add">
                            <li>


                                <ul class="horizontal">
                                    <li>
                                        <label >Add News</label>
                                    </li>
                                    <li>
                                        <label class="successcolor"><?= ($saved)? 'Sucesssfully saved news':'' ?></label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <ul class="horizontal">
                                    <li>
                                        <label for="title" >Title<cite class="req">*</cite></label>
                                    </li>
                                    <li>
                                        <div >
                                            <?php echo form_input($title);?>
                                        </div>
                                    </li>
                                    <li>
                                        <span class=" red">
                                            <?php echo  form_error('title')?>
                                        </span>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <ul class="horizontal">
                                    <li>
                                        <label for="message" >Message<cite class="req">*</cite></label>
                                    </li>
                                    <li>
                                        <?php echo form_textarea($message);?>
                                    </li>
                                    <li>
                                        <span class=" red">
                                           <?php echo  form_error('message')?>
                                        </span>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <ul class="horizontal">
                                    <li>
                                        <label for="link" >Link<cite class="req">*</cite></label>
                                    </li>
                                    <li>
                                        <?php echo form_input($link);?>
                                    </li>
                                    <li>
                                            <span class=" red">
                                                <?php echo  form_error('link')?>
                                            </span>
                                    </li>
                                </ul>

                            </li>
                            <li>
                                <?php echo form_button($form_button);?>
                            </li>
                        </ul>
                    <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


