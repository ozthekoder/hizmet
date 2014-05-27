<div id="question-<?= $questionOrder ?>" order="<?= $questionOrder ?>" questionid="<?= $questionId ?>" class="well">
    <span class="label <?php if(!$hasSelected && $answer === '') echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
    <span class="question-text <?php if(!$hasSelected && $answer === '') echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
    <?php
    switch($questionType){
        case SHORT_ANSWER:
        ?>
        <div class="input-group" style="margin-top:20px;">
            <input  type="text" class="form-control <?php if($answer !== '') echo 'success' ?>" value="<?= $answer ?>" name="<?= $questionId ?>" placeholder="Type answer here..">
            <span class="input-group-btn">
                <button class="btn  <?php if($answer !== '') echo 'btn-success'; else echo 'btn-primary'; ?> save-answer" type="button">Save</button>
            </span>
        </div>
        <?php
        break;
        case ESSAY_ANSWER:
        ?>
        <textarea style="margin-top:20px;margin-bottom: 30px;" class="form-control <?php if($answer !== '') echo 'success' ?>" rows="3" name="<?= $questionId ?>" placeholder="Type answer here.."><?= $answer ?></textarea>
        <a class="btn btn-xs save-answer <?php if($answer !== '') echo 'btn-success'; else echo 'btn-primary'; ?>" style="float:right;position:relative;bottom:15px;">Save</a>
        <?php
        break;
        case MULTICHOICE_SINGLESELECT:
        ?>
        <br/><br/>
        <select name="<?= $questionId ?>">
            <?php if(!$hasSelected){ ?><option selected value="" >None Selected</option><?php } ?>
            <?= $choices ?>
        </select>
        <?php
        break;
        case MULTICHOICE_MULTISELECT:
        ?>
        <br/><br/>
        <select class="multiselect" multiple="multiple" name="<?= $questionId ?>">
            <option value="multiselect-all"> Select all</option>
            <?= $choices ?>
        </select>
        <?php
        break;
    }
    ?>
</div>