<?php
/**
 * Description of Home module
 *
 * @author osman ozdemir
 */
class Home extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('home/templates/Home.view.php');
        $this->setView($view);
        
        return $this->createHTML();
    }
}

?>
