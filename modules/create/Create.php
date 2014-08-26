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
        
        $appId = EventManager::$post['id'];
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
                                                Choice.choice as choice,
                                                Choice.afterText as afterText
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
                'status' => $app[0]['status']
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
                'status' => 0
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
        
        $foo = array();
        $foo['forms'] = __::groupBy($app, 'formId');
        $i = 0;
        foreach($foo['forms'] as $form)
        {
            $forms[$i] = array(
                    'id' => $form[0]['formId'],
                    'name' => $form[0]['formName'],
                    'order' => $form[0]['formOrder'],
                    'questions' => array()
                );
            $foo['questions'] = __::groupBy($form, 'questionId');
            $j = 0;
            foreach($foo['questions'] as $question)
            {
                $forms[$i]['questions'][$j] = array(
                        'id' => $question[0]['questionId'],
                        'question' => $question[0]['question'],
                        'order' => $question[0]['questionOrder'],
                        'type' => $question[0]['questionType'],
                        'choices' => array()
                    );
                if(intval($question[0]['questionType']) == MULTICHOICE_MULTISELECT || intval($question[0]['questionType']) == MULTICHOICE_SINGLESELECT)
                {
                    $foo['choices'] = __::groupBy($question, 'choiceId');

                    $k = 0;
                    foreach($foo['choices'] as $choice)
                    {
                        $forms[$i]['questions'][$j]['choices'][] = array(
                            'id' => $choice[0]['choiceId'],
                            'choice' => $choice[0]['choice'],
                            'afterText' => $choice[0]['afterText']
                        );
                        $k++;
                    }
                }
                $j++;
            }
            
            $i++;
        }
//        foreach($app as $c)
//        {
//            if(!is_null($c['questionId']))
//            {
//                if(!isset($choices[$c['choiceId']])) 
//                    $choices[$c['questionId']] = array();
//                $choices[$c['questionId']][] = array(
//                    'id' => $c['choiceId'],
//                    'choice' => $c['choice']
//                );
//            }
//                
//        }
//        
//        foreach($app as $q)
//        {
//            if(!isset($questions[$q['formId']])) 
//                $questions[$q['formId']] = array();
//            $question = array(
//                'id' => $q['questionId'],
//                'question' => $q['question'],
//                'order' => $q['questionOrder'],
//                'type' => $q['questionType']
//            );
//            if(isset($choices[$q['questionId']]) && !empty($choices[$q['questionId']]))
//            {
//                $question['choices'] = $choices[$q['questionId']];
//                unset($choices[$q['questionId']]);
//            }
//            $questions[$q['formId']][] = $question;
//        }
//        $i = 0;
//        foreach($app as $f)
//        {
//            if(isset($questions[$f['formId']]) && !empty($questions[$f['formId']]))
//            {
//                $forms[$i] = array(
//                    'id' => $f['formId'],
//                    'name' => $f['formName'],
//                    'order' => $f['formOrder'],
//                    'questions' => $questions[$f['formId']]
//                );
//                $i++;
//                unset($questions[$f['formId']]);
//            }
//        }
        $application['forms'] = $forms;
        
        echo json_encode($application, JSON_NUMERIC_CHECK);
    }
    
    
}

?>
