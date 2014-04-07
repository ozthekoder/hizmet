<div id="cropper" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false" style="display: block;">
<div class="modal-dialog modal-sm">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title" id="mySmallModalLabel" style="font-size: 16px;font-family: Architects Daughter;">Crop your image into a square</h4>
    </div>
    <div class="modal-body">
        <img id="avatar-crop" style="width:258px;height:auto;" src="<?= EventManager::url($url) ?>" <?= $imgInfo ?> />
    </div>
    <div class="modal-footer">
        <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="cropper-done" class="btn btn-primary">OK</button>
    </div>
  </div>
</div>
</div>