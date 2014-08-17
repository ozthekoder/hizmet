<div class="container-fluid" style="margin-top:50px;height:calc(100% - 50px);">
    <div class="row" style="height:100%;">
        <?= $leftPanel ?>
        <div class="col-md-10" style="height:100%;padding-top: 15px;overflow: scroll;">
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group">
                        
                        <button id="add-new-region" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Add New Region</button>
                        <button id="edit-state-region-mappings" type="button" class="btn btn-default"><span class="icon-us-continental" style="margin-right: 5px;"></span>Edit State-Region Mappings</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="icon-query" style="margin-right: 5px;"></span>
                              Query
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a href="#">Query 1</a></li>
                              <li><a href="#">Query 2</a></li>
                            </ul>
                          </div>
                    </div>
                </div>
                <div class="col-md-3">
                    
                </div>
            </div>
            <?php if(count($federations) == 0): ?>
            <h3 style="text-align: center;font-family:Architects Daughter;text-shadow:0px 2px 3px rgba(0,0,0,0.3)">No Federations have been added yet.</h3>
            <?php else: ?>
             <?= $table ?>
            <?php endif; ?>
        </div> 
    </div>
</div>


