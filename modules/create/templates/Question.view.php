<div data-id="<?= $questionId ?>" data-type="<?= $questionType ?>" data-order="<?= $questionOrder ?>" data-question="<?= $question ?>" id="question-<?= $questionOrder ?>" order="<?= $questionOrder ?>" questionid="<?= $questionId ?>" class="well oz-question">
    <span data-toggle="tooltip" data-placement="bottom" title="Remove Question" class="icon-close question-action remove-question trans-all" style="font-size:16px;position:absolute;top:10px;right: 10px;"></span>
    <span data-toggle="tooltip" data-placement="bottom" title="Edit Question" class="icon-edit question-action edit-question trans-all" style="font-size:16px;position:absolute;top:10px;right: 31px;"></span>
    <span class="label label-primary" style="margin-right:5px;"><?= $questionOrder ?></span>
    <span class="question-text"><?= $question ?></span>
    <?php
    switch($questionType){
        case SHORT_ANSWER:
        ?>
        <div class="input-group" style="margin-top:20px;">
            <input  type="text" class="form-control" value="" name="<?= $questionId ?>" placeholder="Type answer here..">
            <span class="input-group-btn">
                <button class="btn  btn-primary save-answer" type="button">Save</button>
            </span>
        </div>
        <?php
        break;
        case ESSAY_ANSWER:
        ?>
        <textarea style="margin-top:20px;margin-bottom: 30px;" class="form-control" rows="3" name="<?= $questionId ?>" placeholder="Type answer here.."></textarea>
        <a class="btn btn-xs save-answer btn-primary" style="float:right;position:relative;bottom:15px;">Save</a>
        <?php
        break;
        case MULTICHOICE_SINGLESELECT:
        ?>
        <br/><br/>
        <select name="<?= $questionId ?>">
            <option selected value="" >None Selected</option>
            <?= $choices ?>
        </select>
        <?php
        break;
        case MULTICHOICE_MULTISELECT:
        ?>
        <br/><br/>
        <select class="multiselect" multiple="multiple" name="<?= $questionId ?>">
            <option value="multiselect-all">Select all</option>
            <?= $choices ?>
        </select>
        <?php
        break;
        case TXT_UPLOAD:
        ?>
            <br/><br/>
            <input type="file" name="answer">
            <?php
            break;
        case IMAGE_UPLOAD:
        ?>
        <br/><br/>
        <input type="file" multiple="multiple" name="answer">
        <?php
        break;
    }
    ?>
</div>