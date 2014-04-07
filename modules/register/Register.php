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
class Register extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        if(userExists())
        {
            EventManager::goToLoc('home');
        }
        $view = new View('register/templates/Register.view.php');
        $this->setVar('nations', EventManager::$db->selectAll('Nationality'));
        $this->setVar('states', EventManager::$db->selectAll('State'));
        $this->setView($view);  
        $this->addJS('js/register.js');
        return $this->createHTML();
    }
    
    
}

?>
