<div class="container-fluid" style="margin-top:50px;height:calc(100% - 50px);">
    <div class="row" style="height:100%;">
        <?= $leftPanel ?>
        <div class="col-md-10" style="height:100%;padding-top: 15px;overflow: scroll;">
            <div class="row">
                <div class="col-md-7">
                    
<!--                    <div class="modal fade" id="createNewAppModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Create Application</h4>
                                </div>
                                <div class="modal-body">
                                    
                                </div> 
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    <button type="button" id="save-app" class="btn btn-primary">Save</button>
                                  </div>
                                
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="modal fade" id="createNewFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-new-form" class="btn btn-primary">Add</button>
                                  </div>
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="modal fade" id="addNewQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <button type="button" class="btn btn-primary">Type</button>
                                    <div class="btn-group oz-dropdown" >
                                        <button value="0" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                          <span class="selected-type">Short Answer<span>
                                          <span class="caret"></span>
                                        </button>
                                        <ul id="question-type" class="dropdown-menu">
                                          <li value="0"><a>Short Answer</a></li>
                                          <li value="1"><a>Essay Answer</a></li>
                                          <li value="2"><a>Multiple Choice - Single Answer</a></li>
                                          <li value="3"><a>Multiple Choice - Multiple Answer</a></li>
                                          <li value="4"><a>Text Document Upload (DOC, DOCX, TXT)</a></li>
                                          <li value="5"><a>Image Upload (JPEG, PNG, GIF)</a></li>
                                        </ul>
                                     </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    <button type="button" id="add-new-question" class="btn btn-primary">Add</button>
                                  </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="btn-group">
                        
                        <button  id="create-new-app"  type="button" class="btn btn-primary"><span class="icon-plus" style="margin-right: 5px;"></span>Create New Application</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
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


