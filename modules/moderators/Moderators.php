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
        $applicants = EventManager::$db->query('SELECT * FROM User
                                                left join (select id as nationId, `name` as nationality from Nationality) as Nationality 
                                                on User.nationality=Nationality.nationId where accountType!=0;');
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
