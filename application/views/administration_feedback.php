
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
        background: #f1f1f1 url(../administration/noise-diagonal.png);
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

    /**/
    .centerme{
        text-align: center;
    }

</style>

<div class="reg-form-holder">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="license-title">Feedback</h1>

                        <table>
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Date</th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach($results as $data) {
                                    echo ' <tr>';
                                    echo ' <td><strong>'.$data->id.'</strong></td>';
                                    echo ' <td>'.$data->user_id.'</td>';
                                    echo ' <td>'.$data->category.'</td>';
                                    echo ' <td>'.$data->message.'</td>';
                                    echo ' <td>'.$data->rating.'</td>';
                                    echo ' <td>'.$data->date_created.'</td>';
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
            </div>
        </div>
    </div>
</div>


