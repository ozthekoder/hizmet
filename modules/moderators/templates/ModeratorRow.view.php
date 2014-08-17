<tr type="User">
    <td style="position:relative;" name="id" editable="false">
        <span class="icon-remove remove-item" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span>
        <span class="icon-eye permissions-item" style="font-size: 23px;margin:7px;margin-left: 35px;position:absolute;top:0px;left:0px;color:blueviolet;display: none;"></span>
        <span class="id-holder"><?= $id ?></span></td>
    <td name="email" editable="true"><span><?= $email ?></span></td>
    <td name="password" editable="true"><span><?= $password ?></span></td>
    <td name="firstName" editable="true"><span><?= $firstName ?></span></td>
    <td name="lastName" editable="true"><span><?= $lastName ?></span></td>
    <td name="dob" editable="true"><span><?= $dob ?></span></td>
    <td name="gender" editable="true"><span><?= $gender == 0 ? 'Male' : 'Female' ?></span></td>
    <td name="avatar" editable="false"><span><img src="<?= EventManager::url($avatar) ?>" width="24" height="24"/></span></td>
    <td name="accountType" editable="true"><span><?= $accountType == ADMIN ? 'Admin' : 'Moderator' ?></span></td>
    <td name="resume" editable="false"><span><?= $resume ?></span></td>
    <td name="registeredOn" editable="false"><span><?= date('Y-m-d H:i:s', $registeredOn) ?></span></td>
    <td name="street" editable="true"><span><?= $street ?></span></td>
    <td name="city" editable="true"><span><?= $city ?></span></td>
    <td name="state" editable="true"><span><?= $state ?></span></td>
    <td name="zip" editable="true"><span><?= $zip ?></span></td>
    <td name="phone" editable="true"><span><?= $phone ?></span></td>
    <td name="nationality" editable="true"><span><?= $nationality ?></span></td>
</tr>