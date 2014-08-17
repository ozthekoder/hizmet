<div class="col-md-2" style="height:100%;background: #f9f9f9;padding:0px;padding-top: 15px;" id="leftCol">            
    <ul class="nav nav-stacked left-panel" id="sidebar">
        <li><a <?php if(EventManager::$currentModule == 'Federations') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/federations') ?>"><span class="icon-building" style="margin-right:25px;"></span>Federations</a></li>
        <li><a <?php if(EventManager::$currentModule == 'Regions') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/regions') ?>"><span class="icon-us-continental" style="margin-right:25px;"></span>Regions</a></li>
      <li><a <?php if(EventManager::$currentModule == 'Applicants') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/applicants') ?>"><span class="icon-users" style="margin-right:25px;"></span>Applicants</a></li>
      <?php if($_SESSION['user']->accountType > REGULAR): ?>
      <li><a  <?php if(EventManager::$currentModule == 'Moderators') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/moderators') ?>"><span class="icon-users-1" style="margin-right:25px;"></span>Moderators</a></li>
      <?php endif; ?>
      <li><a  <?php if(EventManager::$currentModule == 'Applications') echo 'class="selected-nav-item"'; ?> href="<?= EventManager::url('admin/applications') ?>"><span class="icon-file" style="margin-right:25px;"></span>Applications</a></li>
    </ul>
</div>  