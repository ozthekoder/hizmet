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
class Federations extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('federations/templates/Federations.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $row = new View('federations/templates/FederationRow.view.php');
        $table = new View('federations/templates/FederationsTable.view.php');
        
        $feds = (array)EventManager::$db->selectAll('Federation');
        $rows = '';
        
        foreach($feds as $fed)
        {
            $rows .= $row->createHtml((array)$fed);
        }
        
        $nats = EventManager::$db->query('SELECT * FROM hizmet.Nationality left join (select id as fedId, name as fedName from hizmet.Federation) as f on Nationality.fedId=f.fedId;');
        $this->setVar('federations', $feds);
        $this->setVar('nations', $nats);
        jsConfig('federations', $feds);
        jsConfig('nations', $nats);
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
