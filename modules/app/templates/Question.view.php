<div id="question-<?= $questionOrder ?>" order="<?= $questionOrder ?>" questionid="<?= $questionId ?>" class="well">
    <?php
    switch($questionType){
        case SHORT_ANSWER:
        ?>
        <span class="label <?php if($answer === '') echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
        <span class="question-text <?php if($answer === '') echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
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
        <span class="label <?php if($answer === '') echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
        <span class="question-text <?php if($answer === '') echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
        <textarea style="margin-top:20px;margin-bottom: 30px;" class="form-control <?php if($answer !== '') echo 'success' ?>" rows="3" name="<?= $questionId ?>" placeholder="Type answer here.."><?= $answer ?></textarea>
        <a class="btn btn-xs save-answer <?php if($answer !== '') echo 'btn-success'; else echo 'btn-primary'; ?>" style="float:right;position:relative;bottom:15px;">Save</a>
        <?php
        break;
        case MULTICHOICE_SINGLESELECT:
        ?>
        <span class="label <?php if(!$hasSelected) echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
        <span class="question-text <?php if(!$hasSelected) echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
        <br/><br/>
        <select name="<?= $questionId ?>">
            <?php if(!$hasSelected){ ?><option selected value="" >None Selected</option><?php } ?>
            <?= $choices ?>
        </select>
        <?php
        break;
        case MULTICHOICE_MULTISELECT:
        ?>
        <span class="label <?php if(!$hasSelected) echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
        <span class="question-text <?php if(!$hasSelected) echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
        <br/><br/>
        <select class="multiselect" multiple="multiple" name="<?= $questionId ?>">
            <option value="multiselect-all"> Select all</option>
            <?= $choices ?>
        </select>
        <?php
        break;
        case TXT_UPLOAD:
        ?>
            <span class="label <?php if(!$uploads) echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
            <span class="question-text <?php if(!$uploads) echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
            <br/><br/>
            <form enctype="multipart/form-data" action="<?= EventManager::url('ajax/save-answer') ?>" method="post">
                <input data-browse-class="btn <?php if(!$uploads) echo 'btn-default'; else  echo 'btn-success';  ?>" type="file" multiple="multiple" name="files[]">
                <input type="hidden" name="questionId" value="<?= $questionId ?>" />
                <input type="hidden" name="questionType" value="<?= TXT_UPLOAD ?>" />
            </form>
            <?php
            break;
        case IMAGE_UPLOAD:
        ?>
        <span class="label <?php if(!$uploads) echo 'label-primary'; else  echo 'label-success';  ?>" style="margin-right:5px;"><?= $questionOrder ?></span>
        <span class="question-text <?php if(!$uploads) echo ''; else echo 'text-success';  ?>"><?= $question ?></span>
        <br/><br/>
        <form enctype="multipart/form-data" action="<?= EventManager::url('ajax/save-answer') ?>" method="post">
            <input data-browse-class="btn <?php if(!$uploads) echo 'btn-default'; else  echo 'btn-success';  ?>" type="file" multiple="multiple" name="files[]">
            <input type="hidden" name="questionId" value="<?= $questionId ?>" />
            <input type="hidden" name="questionType" value="<?= IMAGE_UPLOAD ?>" />
        </form>
        <?php
        break;
    }
    ?>
</div>