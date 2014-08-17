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
class Applications extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('applications/templates/Applications.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $formView = new View('applications/templates/Form.view.php');
        $questionView = new View('applications/templates/Question.view.php');
        $row = new View('applications/templates/ApplicationRow.view.php');
        $table = new View('applications/templates/ApplicationsTable.view.php');
        
        $apps = EventManager::$db->selectAll('Application', array());
        $rows = '';
        
        foreach($apps as $app)
        {
            $rows .= $row->createHtml((array)$app);
        }
        
        jsConfig('formView', $formView->createHTML());
        jsConfig('questionView', $questionView->createHTML());
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setVar('apps', $apps);
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        $this->addCSS('css/fileinput.css');
        $this->addJS('js/fileinput.js');
        return $this->createHTML();
    }
    
    
}

?>
