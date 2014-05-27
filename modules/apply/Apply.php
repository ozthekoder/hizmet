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
class Apply extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $today = date('Y-m-d', time());
        $apps = EventManager::$db->query("select * from application where startDate <= '$today' and deadline > '$today' and status=1");
        $subs = EventManager::$db->selectAll('Submission', array('userId' => $_SESSION['user']->id));
        $view = new View('apply/templates/Apply.view.php');
        $row = new View('apply/templates/ApplicationRow.view.php');
        $table = new View('apply/templates/ApplicationsTable.view.php');
        
        $rows = '';
        
        foreach($apps as $app)
        {
            $app = (array)$app;
            $app['submission'] = 2;
            foreach($subs as $sub)
            {
                if(intval($sub->appId) === intval($app['id']))
                {
                    $app['submission'] = intval($sub->status);
                }
            }
            $rows .= $row->createHtml($app);
        }
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setView($view);  
        
        return $this->createHTML();
    }
    
    
}

?>
