<div class="container-fluid" style="margin-top:50px;height:calc(100% - 50px);">
    <div class="row" style="height:100%;">
        <?= $leftPanel ?>
        <div class="col-md-10" style="height:100%;padding-top: 15px;">
            <div class="row">
                <div class="col-md-7">
                    <div class="modal fade" id="createNewAppModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Create Application</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row " style="position: relative;">
                                        <div data-spy="affix" class="col-md-3" id="forms-sidebar" style="padding-top: 15px;">
                                            <ul class="nav nav-stacked left-panel" id="forms-list">
                                                <li>
                                                    <a href="#form-1">form 1</a>
                                                </li>
                                                <li>
                                                    <a href="#form-2">form 2</a>
                                                </li>
                                                <li>
                                                    <a href="#form-3">form 3</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-9" >
                                            <div class="container-fluid" style="height: 60px;background: #f9f9f9" id="app-create-top-panel">
                                                <div class="modal fade" id="createNewFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                <!--<div class="btn-group">-->
                                                <button style="margin-top: 13px;" data-toggle="modal" data-target="#createNewFormModal" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Create New Form</button>
<!--                                                    <div class="btn-group">
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
                                                </div>-->
                                            </div>
                                            <div class="container-fluid" style="height: 388px;overflow: auto;background: #f0f0f0;" id="forms-panel">
                                                <div style="padding-top: 15px;">
                                                    <div id="form-1" class="panel panel-default">
                                                <div class="panel-heading">Panel heading without title</div>
                                                <div class="panel-body">
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                </div>
                                              </div>
                                                <div id="form-2" class="panel panel-default">
                                                <div class="panel-heading">Panel heading without title</div>
                                                <div class="panel-body">
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                </div>
                                              </div>
                                                <div id="form-3" class="panel panel-default">
                                                <div class="panel-heading">Panel heading without title</div>
                                                <div class="panel-body">
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                  <br/><br/><br/><br/><br/>
                                                </div>
                                              </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="save-app" class="btn btn-primary">Save</button>
                                  </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        
                        <button data-toggle="modal" data-target="#createNewAppModal" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Create New Application</button>
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
            <?php if(count($apps) == 0): ?>
            <h3 style="text-align: center;font-family:Architects Daughter;text-shadow:0px 2px 3px rgba(0,0,0,0.3)">No applications have been created yet.</h3>
            <?php else: ?>
             <?= $table ?>
            <?php endif; ?>
        </div> 
    </div>
</div>


