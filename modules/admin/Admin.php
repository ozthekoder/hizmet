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
class Admin extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('admin/templates/Admin.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
