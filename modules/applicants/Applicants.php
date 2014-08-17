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
        $row = new View('applicants/templates/ApplicantRow.view.php');
        $table = new View('applicants/templates/ApplicantsTable.view.php');
        
        $detailsView = new View('panels/UserDetails.view.php');
        $questionView = new View('panels/Question.view.php');
        $formView = new View('panels/Form.view.php');
        
            $fedId = $_SESSION['permissions']->fedId;
            $regionId = $_SESSION['permissions']->regionId;
            if($regionId == 0 && $fedId == 0)
            {
                $applicants = EventManager::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    group by User.id;");
            }
            else if($regionId != 0 && $fedId == 0)
            {
                $applicants = EventManager::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    where s.regionId=$regionId
                                                    group by User.id;");
            }
            else if($regionId == 0 && $fedId != 0)
            {
                $applicants = EventManager::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    where f.fedId=$fedId
                                                    group by User.id;");
            }
            else
            {
                $applicants = EventManager::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    where s.regionId=$regionId and f.fedId=$fedId
                                                    group by User.id;");
            }
            
        
        $rows = '';
        
        foreach($applicants as $user)
        {
            $rows .= $row->createHtml((array)$user);
        }
        
        jsConfig('detailsView', $detailsView->createHTML());
        jsConfig('questionView', $questionView->createHTML());
        jsConfig('formView', $formView->createHTML());
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setVar('applicants', $applicants);
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
