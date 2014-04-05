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
class Logout extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        session_destroy();
        EventManager::goToLoc('home');
    }
}

?>
