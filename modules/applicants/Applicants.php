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
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
