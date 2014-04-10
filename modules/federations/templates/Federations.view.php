<div class="container-fluid" style="margin-top:50px;height:100%;">
    <div class="row" style="height:100%;">
        <?= $leftPanel ?>
        <div class="col-md-10" style="height:100%;padding-top: 15px;">
            <div class="row">
                <div class="col-md-7">
                    <div class="modal fade" id="addNewFederationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Add New Federation</h4>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <span class="input-group-addon">Name</span>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name..">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Website (optional)</span>
                                <input type="text" name="website" class="form-control" placeholder="Enter Website..">
                              </div>
                            </div>
                          
                          
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" id="add-new-federation" class="btn btn-primary">Add</button>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="btn-group">
                        
                        <button data-toggle="modal" data-target="#addNewFederationModal" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Add New Federation</button>
                        <button type="button" class="btn btn-default"><span class="icon-earth" style="margin-right: 5px;"></span>Edit Nationality Mappings</button>
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
        </div> 
    </div>
</div>


