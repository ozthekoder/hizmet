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
class BrowserFailure extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('browserfailure/templates/BrowserFailure.view.php');
        $this->setView($view);  
        return $this->createHTML();
    }
}

?>
