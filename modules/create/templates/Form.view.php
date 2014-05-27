<div data-id="<?= $formId ?>" data-order="<?= $formOrder ?>" data-name="<?= $formName ?>" id="form-<?= $formOrder ?>" order="<?= $formOrder ?>" formid="<?= $formId ?>" class="panel panel-primary oz-form">
    <div class="panel-heading" style="position:relative;">
        <a style="color:#fff;"><?= $formName ?></a>
        <span data-toggle="tooltip" data-placement="bottom" title="Remove Form"  class="form-action icon-close trans-all remove-form"></span>
        <span order="<?= $formOrder ?>" title="Add Question" data-toggle="modal" data-target="#addNewQuestionModal" class="form-action icon-plus trans-all add-question" id=""></span>
    </div>
    <div class="panel-body">
        <?= $questions ?>
    </div>
</div>