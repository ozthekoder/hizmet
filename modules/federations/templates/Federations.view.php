<div class="container-fluid" style="margin-top:50px;height:calc(100% - 50px);">
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
                    <div class="modal fade" id="nationalityMappingsModal" tabindex="-1" role="dialog" aria-labelledby="nationality" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="font-family:Architects Daughter;" class="modal-title" id="">Nationality Mappings</h4>
                                </div>
                                <div class="modal-body">
<!--                                    <div class="btn-group" style="left: calc(50% - 132.5px);margin-bottom: 15px;">
                                      <button id="by-nation" type="button" class="btn btn-default"><span class="icon-earth" style="margin-right: 5px;"></span>By Nationality</button>
                                      <button id="by-fed" type="button" class="btn btn-default"><span class="icon-moon" style="margin-right: 5px;"></span>By Federation</button>
                                    </div>-->
                                    <div class="panel panel-default">
                                        <table class="table table-responsive table-striped">
                                          <thead>
                                            <tr>
                                                <th>Nationalities</th>
                                                <th>Federations</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($nations as $nation)
                                            {
                                            ?>
                                            <tr nationid="<?= $nation['id'] ?>" style="position:relative;">
                                                <td style="font-size: 24px;"><?= $nation['name'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" name="mapping" value="" class="btn dropdown-toggle btn-default " data-toggle="dropdown">
                                                            <span class="selected-fed"><?= is_null($nation['fedName']) ? 'Unselected' : $nation['fedName'] ?></span>
                                                            <span class="caret" style="margin-left: 2px;"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" id="mapping-selection">
                                                            <ul class="dropdown-menu scroll-menu scroll-menu-2x">
                                                               <?php
                                                            foreach($federations as $fed) {
                                                            ?>
                                                                <li fedid="<?= $fed->id ?>"><a href="#"><?= $fed->name ?></a></li>
                                                            <?php 
                                                            } 
                                                            ?>
                                                            </ul>
                                                        </ul>
                                                    </div>
                                                    <span class="icon-checkmark map-success"></span>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        </table>
                                      </div>
                                </div>
                                  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        
                        <button data-toggle="modal" data-target="#addNewFederationModal" type="button" class="btn btn-default"><span class="icon-plus" style="margin-right: 5px;"></span>Add New Federation</button>
                        <button type="button" data-toggle="modal" data-target="#nationalityMappingsModal" class="btn btn-default"><span class="icon-earth" style="margin-right: 5px;"></span>Edit Nationality Mappings</button>
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
            <table id="federations-table" class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <?php
                        foreach($federations[0] as $key=>$val)
                        {
                        ?>
                        <th><?= ucfirst($key) ?></th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($federations as $fed)
                    {
                    ?>
                    <tr fedid="<?= $fed->id ?>" style="position:relative;">
                        <?php
                        $i = 0;
                        foreach((array)$fed as $k=>$v)
                        {
                        ?>
                            <td style="position:relative;"><?php echo $i == 0 ? '<span class="icon-remove remove-fed" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder">' : '<span>'; ?><?= $v ?></span></td>
                        <?php
                        $i++;
                        }
                        ?>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div> 
    </div>
</div>


