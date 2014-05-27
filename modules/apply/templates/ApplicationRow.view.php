<tr type="Application">
    <td name="name" editable="true"><span><?= $name ?></span></td>
    <td name="deadline" editable="true"><span><?= $deadline ?></span></td>
    <?php
    switch($submission)
    {
        case 2: ?>
        <td name="apply">
            <a href="<?= EventManager::url('app/' . $id) ?>" class="btn btn-xs btn-danger apply-to-app">Apply</a>
        </td>
        <?php break;
        case INCOMPLETE: ?>
        <td name="apply">
            <a style="" href="<?= EventManager::url('app/' . $id) ?>" class="btn btn-xs btn-primary apply-to-app">Continue</a>
        </td>
        <?php break;
        case COMPLETE: ?>
        <td name="apply">
            <span class="label label-success">Already applied</span>
        </td>
        <?php break;
    }
    ?>
    
</tr>