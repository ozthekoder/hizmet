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
        if(!userExists())
            EventManager::goToLoc ('home');
        $view = new View('applicants/templates/Applicants.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $row = new View('applicants/templates/ApplicantRow.view.php');
        $table = new View('applicants/templates/ApplicantsTable.view.php');
        
        $detailsView = new View('panels/UserDetails.view.php');
        $questionView = new View('panels/Question.view.php');
        $formView = new View('panels/Form.view.php');
        
            if($_SESSION['user']->accountType == SUPER_ADMIN)
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
            else
            {
                
                $permissions = getPermissions('User', $_SESSION['user']->id);
                $regionFilter = '';
                $fedFilter = '';
                foreach ($permissions['Federation'] as $i => $p)
                {
                    $or = '';
                    if($i < count($permissions['Federation'])-1)
                        $or = ' or ';
                    $fedFilter .= 'f.fedId=' . $p->fedId . $or;
                }
                foreach ($permissions['Region'] as $i => $p)
                {
                    $or = '';
                    if($i < count($permissions['Region'])-1)
                        $or = ' or ';
                    $regionFilter .= 's.regionId=' . $p->regionId . $or;
                }
                $sql = "SELECT * FROM User
                        left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                        on User.nationality = n.nationId
                        left join (select id as fedId, `name` as fedName from Federation) as f
                        on n.fedId = f.fedId
                        left join (select id as stateId, short as state, regionId from State) as s
                        on User.state=s.stateId 
                        where ($fedFilter) and ($regionFilter)
                        group by User.id;";
                $applicants = EventManager::$db->query($sql);
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
