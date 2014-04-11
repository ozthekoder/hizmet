<div class="col-md-2" style="height:100%;background: #f9f9f9;padding:0px;padding-top: 15px;" id="leftCol">            
    <ul class="nav nav-stacked left-panel" id="sidebar">
        <li><a <?php if(EventManager::$currentModule == 'Federations') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/federations') ?>"><span class="icon-moon" style="margin-right:25px;"></span>Federations</a></li>
      <li><a <?php if(EventManager::$currentModule == 'Applicants') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/applicants') ?>"><span class="icon-users" style="margin-right:25px;"></span>Applicants</a></li>
      <li><a  <?php if(EventManager::$currentModule == 'Applications') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/applications') ?>"><span class="icon-file" style="margin-right:25px;"></span>Applications</a></li>
    </ul>
</div>  