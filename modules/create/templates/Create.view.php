<div data-id="<?= $application['id'] ?>" data-name="<?= $application['name'] ?>" data-startDate="<?= $application['startDate'] ?>" data-deadline="<?= $application['deadline'] ?>" data-createdBy="<?= $application['createdBy'] ?>" class="row creation-modal-content" style="position: relative;">
    <div data-spy="affix" class="col-md-3" id="forms-sidebar" style="padding-top: 15px;height: 448px;overflow: auto;">
        <ul class="nav nav-stacked left-panel" id="forms-list">
        <?php foreach($application['forms'] as $form){ ?>
        <li class="nav-list-item" formid="<?= $form['formId'] ?>" order="<?= $form['formOrder'] ?>"><a href="#form-<?= $form['formOrder'] ?>"><?= $form['formOrder'] ?>) <?= $form['formName'] ?></a></li>
        <?php } ?>
        </ul>
    </div>
    <div class="col-md-9" >
        <div class="container-fluid" style="height: 60px;background: #e0e0e0" id="app-create-top-panel">
            <div class="input-group" style="max-width:154px;float:left;margin-top:15px;">
                <span class="input-group-addon">Name</span>
                <input type="text" name="applicationName" id="appName" value="<?= $application['name'] ?>" class="form-control input-sm" placeholder="Name..">
            </div>
            <div style="margin-left: 10px;margin-top: 15px;float: left;max-width: 300px;" data-date-format="yyyy-mm-dd" class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon" style="border-width: 1px 0px 1px 1px;">Start: </span>
                <input type="text" class="input form-control input-sm" value="<?= $application['startDate'] ?>" name="startDate">
                <span class="input-group-addon">End: </span>
                <input type="text" class="input form-control input-sm" value="<?= $application['deadline'] ?>" name="deadline">
            </div>
            <button id="toggleStatus" status="<?= $application['status'] ?>" style="float:left;margin-top:15px;margin-left: 10px;" class="btn btn-primary btn-sm"><?php if($application['status']) echo 'Deactivate'; else echo 'Activate'; ?></button>
            <span title="Add New Form" data-toggle="modal" data-target="#createNewFormModal" style="font-size:24px;margin-left: 10px;margin-top: 18px;float: left;" class="create-new-form icon-plus trans-all"></span>
        </div>
        <div class="container-fluid" style="height: 388px;overflow: auto;background: #f9f9f9;" id="forms-panel">
            <div style="padding-top: 15px;">
                <?= $application['app'] ?>
            </div>
        </div>
    </div>
</div>