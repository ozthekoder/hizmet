<tr type="Moderator" itemid="<?= $id ?>">
    <td style="position:relative;" name="id" editable="false"><span class="icon-remove remove-item" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder"><?= $id ?></span></td>
    <td name="avatar" editable="false"><span><img src="<?= EventManager::url($avatar) ?>" width="24" height="24"/></span></td>
    <td name="email" editable="true"><span><?= $email ?></span></td>
    <td name="firstName" editable="true"><span><?= $firstName ?></span></td>
    <td name="lastName" editable="true"><span><?= $lastName ?></span></td>
    <td name="dob" editable="true"><span><?= $dob ?></span></td>
    <td name="gender" editable="true"><span><?= $gender == 0 ? 'Male' : 'Female' ?></span></td>
    
</tr>