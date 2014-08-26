<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginModule
 *
 * @author osman
 */
class Moderators extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('moderators/templates/Moderators.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $row = new View('moderators/templates/ModeratorRow.view.php');
        $table = new View('moderators/templates/ModeratorsTable.view.php');
        $detailsView = new View('panels/ModeratorDetails.view.php');
        $modalTable = '<table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Federation</th>
                            <th>Has Permissions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <%= tableContent %>
                        </tbody>
                      </table>';
        jsConfig('modalTable', $modalTable);
        jsConfig('detailsView', $detailsView->createHTML());
        $boss= $_SESSION['user']->accountType;
        if($_SESSION['user']->accountType == SUPER_ADMIN)
        {
            $applicants = EventManager::$db->query("select * from User where accountType>0 and boss=$boss and id != $boss;");
        }
        else
        {
            $sql = "SELECT * FROM User where accountType=1 and boss=$boss and id != $boss;";
            $applicants = EventManager::$db->query($sql);
        }
        $rows = '';
        
        foreach($applicants as $user)
        {
            $rows .= $row->createHtml((array)$user);
        }
        
        
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setVar('applicants', $applicants);
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
