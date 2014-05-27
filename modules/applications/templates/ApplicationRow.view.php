<tr type="Application">
    <td style="position:relative;" name="id" editable="false"><span class="icon-remove remove-item" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder"><?= $id ?></span><span class="icon-edit edit-item" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:30px;color:primary;display: none;"></span></td>
    <td name="name" editable="true"><span><?= $name ?></span></td>
    <td name="createdBy" editable="false"><span><?= $createdBy ?></span></td>
    <td name="createdOn" editable="false"><span><?= date('Y-m-d H:i:s', $createdOn) ?></span></td>
    <td name="lastEditedOn" editable="false"><span><?= date('Y-m-d H:i:s', $lastEditedOn) ?></span></td>
    <td name="startDate" editable="true"><span><?= $startDate ?></span></td>
    <td name="deadline" editable="true"><span><?= $deadline ?></span></td>
</tr>