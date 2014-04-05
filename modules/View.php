<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author osman
 */
class View 
{
    public $file;
    
    public function __construct($fileLocation) 
    {
        $this->file = $fileLocation;
    }
    
    public function createHTML($vars)
    {
        
        extract($vars);        
        ob_start();                
        include "{$this->file}";     
        $contents = ob_get_contents(); 
        ob_end_clean();       
        return $contents;  
    }
}

?>
