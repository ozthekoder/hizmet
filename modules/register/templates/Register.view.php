<div class="row" style="position:relative;top:50px;width: 100%;">
    <!--<div class="page-header" style="text-align: center;font-family: Architects Daughter;"><h1>Register for Teach and Travel Program</h1></div>-->
    <div class="col-md-4 col-md-offset-4" style="margin-top:20px;">
        <div class="panel panel-default register-panel">
            <div class="panel-heading"><h3 class="panel-title" style="font-family: Architects Daughter;">Account Info</h3></div>
            <div class="panel-body">
                <div class="input-group">
                    <span class="input-group-addon">E-mail</span>
                    <input type="text" name="email" class="form-control" placeholder="E-mail..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Repeat E-mail</span>
                    <input type="text" name="email-repeat" class="form-control" placeholder="E-mail again..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Password</span>
                    <input type="password" name="password" class="form-control" placeholder="Password..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Repeat Password</span>
                    <input type="password" name="password-repeat" class="form-control" placeholder="Password again..">
                </div>
            </div>
        </div>
            
        <div class="panel panel-default register-panel">
            <div class="panel-heading"><h3 class="panel-title" style="font-family: Architects Daughter;">Personal Info</h3></div>
            <div class="panel-body">
                <div class="input-group">
                    <span class="input-group-addon">First Name</span>
                    <input type="text" name="firstName" class="form-control" placeholder="First Name..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Last Name</span>
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Date of Birth</span>
                    <input type="text" name="dob" class="form-control" placeholder="mm/dd/yyyy">
                </div>
                <div class="btn-group input-group">
                    <span style="width:91px;" class="input-group-addon btn-default">Gender</span>
                    <div class="btn-group oz-select" id="gender-select">
                        <button name="gender" type="button" value="" class="btn btn-large dropdown-toggle btn-default " data-toggle="dropdown">Select<span class="caret" style="margin-left: 2px;"></span></button>
                        <ul class="dropdown-menu">
                            <li value="0"><a>Male</a></li>
                            <li value="1"><a>Female</a></li>
                        </ul>
                    </div>
                </div>
                <div class="btn-group input-group">
                    <span class="input-group-addon btn-default">Nationality</span>
                    <div class="btn-group oz-select" id="nation-select">
                        <button type="button" name="nationality" value="" class="btn btn-large dropdown-toggle btn-default " data-toggle="dropdown">Select<span class="caret" style="margin-left: 2px;"></span></button>
                        <ul class="dropdown-menu">
                            <ul class="dropdown-menu scroll-menu scroll-menu-2x">
                                <?php
                                foreach($nations as $nation)
                                {
                                ?>
                                <li fedId="<?= $nation->fedId ?>" value="<?= $nation->id ?>"><a><?= $nation->name ?></a></li>        
                                <?php
                                }
                                ?>
                            </ul>
                        </ul>
                    </div>
                </div>
                <form method="post" id="avatar" action="<?= EventManager::url('crop-avatar') ?>" target="cropper" enctype="multipart/form-data" style="border-left: 1px solid #c5c5c5; float: right;margin-top: -100px;height: 100px;width: 200px;">
                    <a style="width:100px;height:100px;float: right;" class="thumbnail">
                        <img id="preview-holder" src="holder.js/92x92" alt="">
                    </a>
                    <div style="margin-left: 15px;" class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-default btn-file" style="display: block;">
                            <span class="fileinput-new">Upload<br/>Avatar</span>
                            <span class="fileinput-exists">Change</span>
                            <input name="avatar" type="file">
                        </span>
                        <span class="fileinput-filename"></span>
                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                    </div>
                    <input type="hidden" name="finalAvatarName" id="final-avatar" value="" />
                    <input type="hidden" name="cropped" id="cropped" value="false" />
                    <input type="hidden" name="w" id="signup-avatar-w" value="50"/>
                    <input type="hidden" name="h" id="signup-avatar-h" value="50"/>
                    <input type="hidden" name="x" id="signup-avatar-x" value="10"/>
                    <input type="hidden" name="y" id="signup-avatar-y" value="10"/>
                    <iframe name="cropper" style="width:0px;height:0px; visibility: hidden;opacity:0;"></iframe>
                </form>
            </div>
        </div>
            
        <div class="panel panel-default register-panel">
            <div class="panel-heading"><h3 class="panel-title" style="font-family: Architects Daughter;">Contact Info</h3></div>
            <div class="panel-body">
                <div class="input-group">
                    <span class="input-group-addon">Street</span>
                    <input type="text" name="street" class="form-control" placeholder="Street Address..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">City</span>
                    <input type="text" name="city" class="form-control" placeholder="City..">
                </div>
                <div class="btn-group input-group">
                    <span class="input-group-addon btn-default">State</span>
                    <div class="btn-group oz-select" id="state-select">
                        <button name="state" type="button" value="" class="btn btn-large dropdown-toggle btn-default " data-toggle="dropdown">Select<span class="caret" style="margin-left: 2px;"></span></button>
                        <ul class="dropdown-menu">
                            <ul class="dropdown-menu scroll-menu scroll-menu-2x">
                                <?php
                                foreach($states as $state)
                                {
                                ?>
                                <li short="<?= $state->short ?>"regionId="<?= $state->regionId ?>" value="<?= $state->id ?>"><a><?= $state->name ?></a></li>        
                                <?php
                                }
                                ?>
                            </ul>
                        </ul>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Zip Code</span>
                    <input type="text" name="zip" class="form-control" placeholder="Zip Code..">
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Phone</span>
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number..">
                </div>
            </div>
        </div>
        
        <button class="btn btn-primary btn-lg center-block" style="margin-bottom:20px;" id="submit-everything">Go!</button>
    </div>
</div>
