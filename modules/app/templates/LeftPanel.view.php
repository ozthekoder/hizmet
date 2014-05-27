<div class="col-md-2" style="height:100%;background: #f9f9f9;padding:0px;padding-top: 15px;" id="leftCol">            
    <ul class="nav nav-stacked left-panel" id="sidebar">
        <?php foreach($forms as $form){ ?>
        <li class="nav-list-item" formid="<?= $form['formId'] ?>" order="<?= $form['formOrder'] ?>"><a href="#form-<?= $form['formOrder'] ?>"><?= $form['formOrder'] ?>) <?= $form['formName'] ?></a></li>
        <?php } ?>
        <li>
            <button style="display: block;margin: 0px auto;width: 90%;" type="button" class="btn btn-xs btn-danger submit-application">Submit</button>
        </li>
    </ul>
    
</div>  