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
                                        <div data-spy="affix" class="col-md-3" id="forms-sidebar" style="padding-top: 15px;height: 448px;overflow: auto;">
                                            <ul class="nav nav-stacked left-panel" id="forms-list">
                                            </ul>
                                        </div>
                                        <div class="col-md-9" >
                                            <div class="container-fluid" style="height: 60px;background: #e0e0e0" id="app-create-top-panel">
                                                <div class="input-group" style="max-width:154px;float:left;margin-top:15px;">
                                                    <span class="input-group-addon">Name</span>
                                                    <input type="text" name="applicationName" id="appName" class="form-control input-sm" placeholder="Name..">
                                                </div>
                                                <div style="margin-left: 10px;margin-top: 15px;float: left;max-width: 300px;" class="input-daterange input-group" id="datepicker">
                                                    <span class="input-group-addon" style="border-width: 1px 0px 1px 1px;">Start: </span>
                                                    <input type="text" class="input form-control input-sm" name="startDate">
                                                    <span class="input-group-addon">End: </span>
                                                    <input type="text" class="input form-control input-sm" name="deadline">
                                                </div>
                                                <button style="margin-left: 10px;margin-top: 15px;float: left;" data-toggle="modal" data-target="#createNewFormModal" type="button" class="btn btn-default btn-sm"><span class="icon-plus" style="margin-right: 5px;"></span>Create New Form</button>
                                            </div>
                                            <div class="container-fluid" style="height: 388px;overflow: auto;background: #f9f9f9;" id="forms-panel">
                                                <div style="padding-top: 15px;">
                                                    
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
                    <div class="modal fade" id="createNewFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" href="#createNewFormModal" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Add New Form</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group">
                                        <span class="input-group-addon">Name</span>
                                        <input type="text" name="name" id="form-name" class="form-control" placeholder="Enter Name..">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-new-form" class="btn btn-primary">Add</button>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="addNewQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Add New Question</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group" style="margin-bottom: 10px;">
                                        <span class="input-group-addon">Question</span>
                                        <input type="text" name="name" id="question-text" class="form-control" placeholder="Enter Question..">
                                    </div>
                                    <div class="input-group btn-group" style="margin-bottom: 10px;">
                                        <button type="button" class="btn btn-default">Type</button>
                                    <div class="btn-group oz-dropdown" >
                                        <button value="0" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                          <span class="selected-type">Short Answer<span>
                                          <span class="caret"></span>
                                        </button>
                                        <ul id="question-type" class="dropdown-menu">
                                          <li value="0"><a>Short Answer</a></li>
                                          <li value="1"><a>Essay Answer</a></li>
                                          <li value="2"><a>Multiple Choice - Single Answer</a></li>
                                          <li value="3"><a>Multiple Choice - Multiple Answer</a></li>
                                        </ul>
                                     </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-new-question" class="btn btn-primary">Add</button>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        
                        <button data-toggle="modal" id="create-new-app" data-target="#createNewAppModal" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Create New Application</button>
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


