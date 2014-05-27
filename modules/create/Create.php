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
class Create extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        
        $appId = EventManager::$params[1];
        if($appId !== 'new')
        {
            $app = EventManager::$db->query("select 
                                                Application.id as id, 
                                                Application.name as appName, 
                                                Application.startDate as startDate,
                                                Application.deadline as deadline,
                                                Application.createdBy as createdBy,
                                                Application.status as status,
                                                Form.id as formId,
                                                Form.name as formName,
                                                Form.order as formOrder,
                                                Question.id as questionId,
                                                Question.question as question,
                                                Question.order as questionOrder,
                                                Question.type as questionType,
                                                Choice.id as choiceId,
                                                Choice.choice as choice
                                                from
                                                Application left join 
                                                Form left join 
                                                Question left join 
                                                Choice
                                                on Question.id=Choice.questionId 
                                                on Form.id=Question.formId 
                                                on Application.id=Form.appId 
                                                where Application.id=$appId");
            $application = array(
                'id' => $app[0]['id'],
                'name' => $app[0]['appName'],
                'startDate' => $app[0]['startDate'],
                'deadline' => $app[0]['deadline'],
                'createdBy' => $app[0]['createdBy'],
                'status' => $app[0]['status'],
                'app' => ''
            );
        }
        else
        {
            $application = array(
            'id' => 0,
            'name' => '',
            'startDate' => '',
            'deadline' => '',
            'createdBy' => $_SESSION['user']->id,
            'status' => 0,
            'app' => ''
        );
        }
        $view = new View('create/templates/Create.view.php');
        $formView = new View('create/templates/Form.view.php');
        $questionView = new View('create/templates/Question.view.php');
        $choiceView = new View('create/templates/Choice.view.php');
        
        
        $choices = array();
        $selected = array();
        $questions = array();
        $forms = array();
        foreach($app as $c)
        {
            if(!is_null($c['questionId']))
                $choices[$c['questionId']] .= $choiceView->createHTML($c);
        }
        
        foreach($app as $q)
        {
            if(isset($choices[$q['questionId']]) && !empty($choices[$q['questionId']]))
            {
                $q['choices'] = $choices[$q['questionId']];
                $q['hasSelected'] = $selected[$q['questionId']];
                $questions[$q['formId']] .= $questionView->createHTML($q);
                unset($q['choices']);
                unset($choices[$q['questionId']]);
            }
        }
        $leftInfo = array();
        foreach($app as $f)
        {
            if(isset($questions[$f['formId']]) && !empty($questions[$f['formId']]))
            {
                $f['questions'] = $questions[$f['formId']];
                $forms[$f['formId']] .= $formView->createHTML($f);
                $leftInfo[$f['formId']] = $f;
                unset($f['questions']);
                unset($questions[$f['formId']]);
            }
        }
        
        foreach($forms as $form)
        {
            
            $application['app'] .= $form;
        }
        $application['forms'] = $leftInfo;
        $this->setVar('application', $application);
        $this->setView($view);  
        
        echo $this->createHTML();
    }
    
    
}

?>
