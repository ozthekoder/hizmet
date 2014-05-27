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
class App extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $appId = EventManager::$params[1];
        
        $app = EventManager::$db->query("select 
                                                Application.id as id, 
                                                Application.name as appName, 
                                                Application.startDate as startDate,
                                                Application.deadline as deadline,
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
        $answers = EventManager::$db->selectAll('Answer', array('appId' => $appId, 'userId' => $_SESSION['user']->id));
        $view = new View('app/templates/App.view.php');
        $leftPanel = new View('app/templates/LeftPanel.view.php');
        $formView = new View('app/templates/Form.view.php');
        $questionView = new View('app/templates/Question.view.php');
        $choiceView = new View('app/templates/Choice.view.php');
        $application = array(
            'id' => $app[0]['appId'],
            'name' => $app[0]['appName'],
            'startDate' => $app[0]['startDate'],
            'deadline' => $app[0]['deadline'],
            'app' => ''
        );
        
        $choices = array();
        $selected = array();
        $questions = array();
        $forms = array();
        foreach($app as $c)
        {
            $choiceId = $c['choiceId'];
            $c['selected'] = '';
            if(!$selected[$c['questionId']])
                $selected[$c['questionId']] = false;
            foreach ($answers as $answer)
            {
                if($answer->choiceId === $choiceId)
                {
                    $c['selected'] = 'selected';
                    if(!$selected[$c['questionId']])
                        $selected[$c['questionId']] = true;
                }
            }
            $choices[$c['questionId']] .= $choiceView->createHTML($c);
                
        }
        
        foreach($app as $q)
        {
            $questionId = $q['questionId'];
            $q['answer'] = '';
            foreach ($answers as $answer)
            {
                if($answer->questionId === $questionId && isset($answer->answer) && !empty($answer->answer))
                {
                    $q['answer'] = $answer->answer;
                }
            }
            if(isset($choices[$q['questionId']]) && !empty($choices[$q['questionId']]))
            {
                $q['choices'] = $choices[$q['questionId']];
                $q['hasSelected'] = $selected[$q['questionId']];
                $questions[$q['formId']] .= $questionView->createHTML($q);
                unset($q['hasSelected']);
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
        $this->setVar('leftPanel', $leftPanel->createHTML(array('forms'=> $leftInfo)));
        $this->setVar('application', $application);
        $this->setView($view);  
        $this->addJS('js/application.js');
        return $this->createHTML();
    }
    
    
}

?>
