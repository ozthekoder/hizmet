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
        if(userExists())
        {
            EventManager::goToLoc('home');
        }
        $view = new View('admin/templates/Admin.view.php');
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        return $this->createHTML();
    }
    
    
}

?>
