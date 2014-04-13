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
class Applicants extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('applicants/templates/Applicants.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $row = new View('applicants/templates/ApplicantRow.view.php');
        $table = new View('applicants/templates/ApplicantsTable.view.php');
        
        $applicants = EventManager::$db->selectAll('User', array());
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
