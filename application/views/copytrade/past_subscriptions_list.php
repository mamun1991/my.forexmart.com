
    <?php foreach($pastsubs_list as $key => $pastsubs_value){ ?>
        <?php if(in_array($pastsubs_value['StatusId'],array(3,4,5)) ){?>
            <tr>
                <td><?= $pastsubs_value['Account']?></td>
                <td> <?= $pastsubs_value['CreateTime']?></td>
                <td><?= $pastsubs_value['LastModify']?></td>
                <td><?= $pastsubs_value['StatusDesc']?></td>

            </tr>
        <?php }}?>