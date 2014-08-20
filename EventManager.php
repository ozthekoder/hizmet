<?php
/**
 * Description of EventManager
 *
 * @author osman ozdemir
 */
class EventManager 
{
    public static $base;
    public static $params;
    public static $post;
    public static $get;
    public static $currentModule;
    public $css;
    public $js;
    public static $db;
    
    public function __construct() 
    {
        EventManager::$base = trim(dirname($_SERVER['SCRIPT_NAME']));
        if (!(EventManager::$base == '/')) {
            EventManager::$base .= "/";
        };
        
        $this->css = '';
        $this->js = '';
        self::$params = explode('/', isset($_GET['q']) ? $_GET['q'] : "");
        self::$post = $_POST;
        self::$get = $_GET;
        self::$db = new DBManager();
        self::$db->load();
        self::$currentModule = 'Home';
    }
    
    public function serve()
    {
        jsConfig('base', EventManager::$base);
        jsConfig('host', HOST);
        $loginBox = new View('modules/login/templates/Login.view.php'); 
        $modal = new View('panels/Modal.view.php'); 
        jsConfig('loginBox', $loginBox->createHTML());
        jsConfig('modal', $modal->createHTML());
        switch(self::$params[0])
        {
            case '':
                
                return $this->loadModule('Home');
                
                break;
            case 'home':
                
                return $this->loadModule('Home');
                
                break;
            case 'create':
                
                (new Create())->load();
                exit;
                
                break;
            case 'admin':
                if(intval($_SESSION['user']->accountType) == REGULAR)
                    return $this->loadModule('Home');
                switch(self::$params[1])
                {
                    case 'federations':
                        return $this->loadModule('Federations');
                        break;
                    case 'applicants':
                        return $this->loadModule('Applicants');
                        break;
                    case 'applications':
                        return $this->loadModule('Applications');
                        break;
                    case 'moderators':
                        return $this->loadModule('Moderators');
                        break;
                    case 'regions':
                        return $this->loadModule('Regions');
                        break;
                    default :
                        return $this->loadModule('Federations');
                        break;
                }
                
                
                break;
            case 'profile':
                if(intval($_SESSION['user']->accountType) != ADMIN)
                    return $this->loadModule('Profile');
                else
                    self::goToLoc(self::url ('admin'));
                
                break;
            case 'register':
                
                return $this->loadModule('Register');
                
                break;
            case 'apply':
                
                return $this->loadModule('Apply');
                
                break;
            case 'app':
                if(!(isset($_SESSION['submission']) && !empty($_SESSION['submission'])) || (intval($_SESSION['submission']->appId) !== intval(self::$params[1]) || intval($_SESSION['submission']->userId) !== intval($_SESSION['user']->id)))
                {
                    if($sub = self::$db->select('Submission', array( 'userId' => $_SESSION['user']->id, 'appId' => self::$params[1] )))
                    {
                        $_SESSION['submission'] = $sub;
                    }
                    else
                    {
                        $_SESSION['submission'] =  (new Submission(array(
                            'appId' => self::$params[1],
                            'userId' => $_SESSION['user']->id,
                            'lastEditedOn' => time(),
                            'status' => INCOMPLETE
                        )))->save();

                    }
                }
                    
                return $this->loadModule('App');
                
                break;
            case 'crop-avatar':
                
                echo $this->loadModule('Crop');
                exit;
                break;
            case 'logout':
                
                return $this->loadModule('Logout');
                
                break;
            case 'browser-failure':
                
                return $this->loadModule('BrowserFailure');
                
                break;
            case 'ajax':
                
                $this->ajax();
                
                break;
                
        }
    }
    
    public function loadModule($moduleName)
    {
        $module = new $moduleName();
        self::$currentModule = $moduleName;
        $loaded =  $module->load();
        
        $this->addCSS($module->css);
        $this->addJS($module->js);
        
        
        
        return $loaded;
    }
    
    public static function goToLoc($location)
    {
        header('Location: ' . $location);
        die();
    }
    
    public function addCSS($css)
    {
        $this->css .= $css;
    }
    public function addJS($js)
    {
        $this->js .= $js;
    }
    
    public function ajax()
    {
        $response = array();
        switch(self::$params[1])
        {
            case 'authenticate':
                $response = EventManager::login(self::$post['email'], self::$post['password']);
                break;
            case 'signup':
                $response = EventManager::signup(self::$post);
                break;
            case 'add-new-federation':
                if($r = EventManager::$db->insert('Federation', array( 'name' => EventManager::$post['name'] , 'website' => EventManager::$post['website'] )))
                {
                    $response = array(
                        'federation' => $r,
                        'status' => true,
                        'message' => 'New federation has been successfully added'
                    );
                }
                else
                    $response = array('status' => false, 'message' => 'db error nigga');
                break;
            case 'add-new-region':
                if($r = EventManager::$db->insert('Region', array( 'name' => EventManager::$post['name'])))
                {
                    $response = array(
                        'region' => $r,
                        'status' => true,
                        'message' => 'New region has been successfully added'
                    );
                }
                else
                    $response = array('status' => false, 'message' => 'db error nigga');
                break;
            case 'delete-item':
                $id = EventManager::$post['id'];
                $type = EventManager::$post['type'];
                if($r = EventManager::$db->delete(ucfirst($type), array( 'id' => $id )))
                {
                    if($type == 'Federation')
                    {
                        if($r = EventManager::$db->queryNoResultSet("UPDATE Nationality SET fedId=0 WHERE fedId=$id"))
                        {

                            $response = array(
                                'status' => true,
                                'message' => 'Item has been successfully deleted.'
                            );
                        }
                        else
                            $response = array('status' => false, 'message' => 'db error nigga');
                    }
                    else if($type == 'User')
                    {
                        $response = array(
                                'status' => true,
                                'message' => 'Item has been successfully deleted.'
                            );
                    }
                    else if($type == 'Moderator')
                    {
                        $response = array(
                                'status' => true,
                                'message' => 'Item has been successfully deleted.'
                            );
                    }
                    else if($type == 'Region')
                    {
                        if($r = EventManager::$db->queryNoResultSet("UPDATE State SET regionId=0 WHERE regionId=$id"))
                        {

                            $response = array(
                                'status' => true,
                                'message' => 'Item has been successfully deleted.'
                            );
                        }
                        else
                            $response = array('status' => false, 'message' => 'db error nigga');
                    }
                    else if($type == 'Application')
                    {
                        $response = array(
                                'status' => true,
                                'message' => 'Item has been successfully deleted.'
                            );
                    }
                        
                }
                else
                    $response = array('status' => false, 'message' => 'db error nigga');
                break;
            case 'map-nation':
                if($r = EventManager::$db->update('Nationality', array( 'id' => EventManager::$post['nationid'], 'fedId' => EventManager::$post['fedid'] )))
                {
                    $response = array(
                        'status' => true,
                        'message' => 'Mapping has been successfully applied.'
                    );
                }
                else
                    $response = array('status' => false, 'message' => 'db error nigga');
                break;
            case 'create-app':
                $ap = array();
                $application = EventManager::$post;
                $forms = $application['forms'];
                unset($application['forms']);
                if(!isset($application['createdOn']) || empty($application['createdOn']))
                    $application['createdOn'] = time();
                $application['lastEditedOn'] = time();
                $app = new Application($application);
                $check = true;
                $i=0;
                
                
                if($app->save())
                {
                    $ap = (array)$app;
                    $ap['forms'] = array();
                    foreach($forms as $form)
                    {
                        $questions = $form['questions'];
                        unset($form['questions']);
                        $form['appId'] = $app->id;
                        $f = new Form($form);
                        if($f = $f->save())
                        {
                            $ap['forms'][$i] = (array)$f;
                            
                            if(isset($questions) && !empty($questions))
                            {
                                $ap['forms'][$i]['questions'] = array();
                                $j=0;
                                foreach($questions as $q)
                                {
                                    $choices = $q['choices'];
                                    unset($q['choices']);
                                    $q['appId'] = $app->id;
                                    $q['formId'] = $f->id;
                                    $q['order'] = intval($q['order']);
                                    $question = new Question($q);
                                    if($question = $question->save())
                                    {
                                        $ap['forms'][$i]['questions'][$j] = (array)$question;
                                        
                                        if(isset($choices) && !empty($choices))
                                        {
                                            $ap['forms'][$i]['questions'][$j]['choices'] = array();
                                            $k=0;
                                            foreach($choices as $choice)
                                            {
                                                $c = new Choice(array(
                                                    'id' => $choice['id'],
                                                    'choice' => $choice['choice'],
                                                    'appId' => $app->id,
                                                    'questionId' => $question->id,
                                                    'formId' => $f->id,
                                                ));
                                                if($c = $c->save())
                                                {
                                                    $ap['forms'][$i]['questions'][$j]['choices'][$k] = (array)$c;
                                                }
                                                else
                                                {
                                                    $check = false;
                                                    echo json_encode($response = array(
                                                        'status' => false,
                                                        'message' => 'Db Error Saving Application'
                                                    ));
                                                    exit;
                                                }
                                                $k++;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $check = false;
                                        echo json_encode($response = array(
                                            'status' => false,
                                            'message' => 'Db Error Saving Application'
                                        ));
                                        exit;
                                    }
                                    
                                    $j++;
                                }
                                
                            }
                                
                        }
                        else
                        {
                            $check = false;
                            echo json_encode($response = array(
                                'status' => false,
                                'message' => 'Db Error Saving Application'
                            ), JSON_NUMERIC_CHECK);
                            exit;
                        }
                        $i++;
                    }
                }
                else
                {
                    $check = false;
                    echo json_encode($response = array(
                        'status' => false,
                        'message' => 'Db Error Saving Application'
                    ));
                    exit;
                }
                
                if($check)
                {
                    $response = array(
                        'app' => $ap,
                        'status' => true,
                        'message' => 'Application successfully saved'
                    );
                }
                
                
                break;
            case 'save-chosen':
                $choiceId = self::$post['choiceId'];
                $questionId = self::$post['questionId'];
                $type = intval(self::$post['type']);
                
                if($type === MULTICHOICE_SINGLESELECT)
                {
                    if($chosen = self::$db->select('Answer', array('questionId' => $questionId, 'userId' => $_SESSION['user']->id)))
                    {
                        $chosen->choiceId = $choiceId;
                        $chosen->save();
                        $response = array(
                            'status' => true
                        );
                    }
                    else
                    {
                        if($saved = self::$db->insert('Answer', array(
                            'choiceId' => $choiceId,
                            'questionId' => $questionId,
                            'subId' => $_SESSION['submission']->id,
                            'appId' => $_SESSION['submission']->appId,
                            'userId' => $_SESSION['submission']->userId
                        )))
                        {
                            $response = array(
                                'status' => true
                            );
                        }
                    }
                }
                else if($type === MULTICHOICE_MULTISELECT)
                {
                    $checked = self::$post['checked'];
                    if($checked !== "false")
                    {
                        if($choiceId === "all")
                        {
                            $chosen = self::$post['chosen'];
                            $actuallyChosen = self::$db->delete('Answer', array(
                                'questionId' => $questionId, 'userId' => $_SESSION['user']->id
                            ));
                            
                            foreach ($chosen as $c)
                            {
                                $saved = self::$db->insert('Answer', array(
                                    'choiceId' => $c,
                                    'questionId' => $questionId,
                                    'subId' => $_SESSION['submission']->id,
                                    'appId' => $_SESSION['submission']->appId,
                                    'userId' => $_SESSION['submission']->userId
                                ));
                            }
                            
                            $response = array(
                                'status' => true
                            );
                        }
                        else
                        {
                            if($saved = self::$db->insert('Answer', array(
                                'choiceId' => $choiceId,
                                'questionId' => $questionId,
                                'subId' => $_SESSION['submission']->id,
                                'appId' => $_SESSION['submission']->appId,
                                'userId' => $_SESSION['submission']->userId
                            )))
                            {
                                $response = array(
                                    'status' => true
                                );
                            }
                        }
                            
                    }
                    else
                    {
                        if($choiceId === "all")
                        {
                            if(self::$db->delete('Answer', array(
                                'questionId' => $questionId, 'userId' => $_SESSION['submission']->userId
                            )))
                            {
                                $response = array(
                                    'status' => true
                                );
                            }
                        }
                        else
                        {
                            if(self::$db->delete('Answer', array(
                                'userId' => $_SESSION['submission']->userId,
                                'choiceId' => $choiceId,
                                'questionId' => $questionId
                            )))
                            {
                                $response = array(
                                    'status' => true
                                );
                            }
                        }
                            
                    }
                }
                    
                break;
            case 'save-answer':
                if($_FILES['files'])
                {
                    $count = count($_FILES['files']);
                    $paths = array();
                    $i = 0;
                    $check = true;
                    $ans;
                    $questionId = self::$post['questionId'];
                                      
                    if($ans = self::$db->select('Answer', array( 'questionId' => $questionId, 'userId' => $_SESSION['user']->id )))
                    {
                        $uploads = self::$db->selectAll('Upload', array( 'answerId' => $ans->id ));
                        self::$db->delete('Upload', array( 'answerId' => $ans->id ));

                        foreach ($uploads as $upload)
                        {
                            $path = UPLOADS . $upload->hash . '.' . $upload->extension;
                            unlink($path);
                        }
                    }
                    
                    foreach ($_FILES['files']['tmp_name'] as $index => $file)
                    {
                        if(self::$post['questionType'] == TXT_UPLOAD)
                        {
                            if (($_FILES["files"]["type"][$index] == "application/pdf") || 
                                ($_FILES["files"]["type"][$index] == "application/msword") || 
                                ($_FILES["files"]["type"][$index] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
                            {
                                
                                if($ans = self::$db->select('Answer', array( 'questionId' => $questionId, 'userId' => $_SESSION['user']->id )))
                                {
                                    
                                }
                                else
                                {
                                    $ans = self::$db->insert('Answer', array(
                                        'answer' => '',
                                        'questionId' => $questionId,
                                        'subId' => $_SESSION['submission']->id,
                                        'appId' => $_SESSION['submission']->appId,
                                        'userId' => $_SESSION['submission']->userId
                                    ));


                                }

                                
                                $fileName = $_FILES['files']['name'][$index];
                                $hash = sha1($fileName . time());
                                $extension = explode('.', $fileName);
                                $extension = $extension[count($extension)-1];
                                $path = UPLOADS . $hash . '.' . $extension;
                                move_uploaded_file($_FILES["files"]["tmp_name"][$index], $path);
                                
                                self::$db->insert('Upload', array(
                                    'answerId' => $ans->id,
                                    'questionId' => $questionId,
                                    'subId' => $_SESSION['submission']->id,
                                    'appId' => $_SESSION['submission']->appId,
                                    'hash' => $hash,
                                    'extension' => $extension,
                                    'type' => TXT_UPLOAD
                                ));
                                
                                $paths[$i] = self::url($path);
                            }
                            else
                            {
                                $check = false;
                                break;
                            }
                        }
                        else if(self::$post['questionType'] == IMAGE_UPLOAD)
                        {
                            if (($_FILES["files"]["type"][$index] == "image/png") || 
                                ($_FILES["files"]["type"][$index] == "image/jpeg") || 
                                ($_FILES["files"]["type"][$index] == "image/gif"))
                            {
                                if($ans = self::$db->select('Answer', array( 'questionId' => $questionId, 'userId' => $_SESSION['user']->id )))
                                {
                                    
                                }
                                else
                                {
                                    $ans = self::$db->insert('Answer', array(
                                        'answer' => '',
                                        'questionId' => $questionId,
                                        'subId' => $_SESSION['submission']->id,
                                        'appId' => $_SESSION['submission']->appId,
                                        'userId' => $_SESSION['submission']->userId
                                    ));


                                }
                                
                                
                                $fileName = $_FILES['files']['name'][$index];
                                $hash = sha1($fileName . time());
                                $extension = explode('.', $fileName);
                                $extension = $extension[count($extension)-1];
                                $path = UPLOADS . $hash . '.' . $extension;
                                move_uploaded_file($_FILES["files"]["tmp_name"][$index], $path);
                                
                                self::$db->insert('Upload', array(
                                    'answerId' => $ans->id,
                                    'questionId' => $questionId,
                                    'subId' => $_SESSION['submission']->id,
                                    'appId' => $_SESSION['submission']->appId,
                                    'hash' => $hash,
                                    'extension' => $extension,
                                    'type' => IMAGE_UPLOAD
                                ));
                                
                                $paths[$i] = self::url($path);
                            }
                            else
                            {
                                $check = false;
                                break;
                            }
                        }
                        $i++;
                    }
                    
                    if($check)
                    {
                        $response = array(
                            'status' => true,
                            'paths' => $paths,
                            'message' => 'Successfully uploaded!'
                              );
                    }
                    else
                    {
                        $response = array(
                            'status' => false,
                            'message' => 'Please upload the required file types only.'
                              );
                    }
                }
                else
                {
                    $questionId = self::$post['name'];
                    $answer = self::$post['value'];
                    if($ans = self::$db->select('Answer', array( 'questionId' => $questionId, 'userId' => $_SESSION['user']->id )))
                    {
                        $ans->answer = $answer;
                        $ans->save();
                        $response = array(
                            'status' => true
                        );
                    }
                    else
                    {
                        self::$db->insert('Answer', array(
                            'answer' => $answer,
                            'questionId' => $questionId,
                            'subId' => $_SESSION['submission']->id,
                            'appId' => $_SESSION['submission']->appId,
                            'userId' => $_SESSION['submission']->userId
                        ));
                        $response = array(
                            'status' => true
                        );


                    }
                }
                
                $_SESSION['submission']->lastEditedOn = time();
                $_SESSION['submission']->save();
                break;
            case 'submit-app':
                if(isset($_SESSION['submission']) && !empty($_SESSION['submission']))
                {
                    $_SESSION['submission']->status = COMPLETE;
                    $_SESSION['submission']->submittedOn = time();
                    $_SESSION['submission']->lastEditedOn = time();
                    $_SESSION['submission']->save();
                    $response = array( 'status' => true);
                }
                break;
            case 'app':
                $appId = self::$params[2];
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
                $response = $app;
                break;
            case 'delete-form':
                self::$db->delete('Form', self::$post);
                break;
            case 'delete-question':
                self::$db->delete('Question', self::$post);
                break;
            case 'toggle-app-status':
                $status = self::$post['status'];
                $id = self::$post['id'];
                if(self::$db->queryNoResultSet("update Application set status='$status' where id='$id'"))
                {
                    $response = array(
                        'status' => true,
                        'message' => 'Status Updated'
                    );
                }
                break;
            case 'get-permissions':
                $userId = self::$post['userId'];
                $q =  "select * from Federation
                    left join (select fedId, userId from Permission) as c on Federation.id = c.fedId
                    left join (select id as uid from User where id=$userId) as u on c.userId = u.uid group by id";
                $permissions = EventManager::$db->query($q);
                $response = array(
                        'status' => true,
                        'permissions' => $permissions
                    );
                break;
            case 'set-permission':
                $userId = self::$post['userId'];
                $fedId = self::$post['fedId'];
                $value = self::$post['value'];
                
                $response = array();
                
                if($value == "true")
                {
                    if(self::$db->insert('Permission', array(
                        'userId' => $userId,
                        'fedId' => $fedId
                    )))
                    {
                        $response['status'] = true;
                        $response['message'] = 'Permission is successfully set!';
                    }
                    else
                    {
                        $response['status'] = false;
                        $response['message'] = 'Opss! Shit.';
                    }
                    
                    
                }
                else
                {
                    $response['status'] = self::$db->delete('Permission', array(
                        'userId' => $userId,
                        'fedId' => $fedId
                    ));
                    $response['message'] = 'Persmission is successfully removed.';
                }
                
                break;
            case 'get-region-state-mappings':
                $sql = "select * from State
                        left outer join (select id as regionId, `name` as regionName from Region) as r
                        on State.regionId = r.regionId group by id;";
                $mappings = self::$db->query($sql);
                $regions = self::$db->selectAll('Region', array());
                $response = array(
                    'mappings' => $mappings,
                    'regions' => $regions
                );
                break;
            case 'map-state':
                if($r = self::$db->update('State', array( 'id' => EventManager::$post['stateId'], 'regionId' => EventManager::$post['regionId'] )))
                {
                    $response = array(
                        'status' => true,
                        'message' => 'Mapping has been successfully applied.'
                    );
                }
                else
                    $response = array('status' => false, 'message' => 'db error nigga');
                break;
            case 'load-item-details':
                $type = self::$post['type'];
                $id = self::$post['id'];
                
                switch($type)
                {
                    case 'User':
                        $item = self::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    left join (select id as regionId, `name` as regionName from Region) as r
                                                    on s.regionId=r.regionId
                                                    where User.id=$id limit 1;")[0];
                        $item['submissions'] = self::$db->query("select * from
                                                                Application left join Submission on Application.id=Submission.appId
                                                                where userId=$id");
                        $response = array(
                            'status' => true,
                            'item' => $item
                        );
                        break;
                    case 'Application':
                        $item = self::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    left join (select id as regionId, `name` as regionName from Region) as r
                                                    on s.regionId=r.regionId
                                                    where User.id=$id limit 1;")[0];
                        $item['submissions'] = self::$db->query("select * from
                                                        Submission right join Application
                                                        on Submission.appId = Application.id
                                                        where Submission.userId=$id");
                        $response = array(
                            'status' => true,
                            'item' => $item
                        );
                        break;
                    case 'Moderator':
                        $item = self::$db->query("SELECT * FROM User
                                                    left join (select id as nationId, fedId, `name` as nation from Nationality) as n
                                                    on User.nationality = n.nationId
                                                    left join (select id as fedId, `name` as fedName from Federation) as f
                                                    on n.fedId = f.fedId
                                                    left join (select id as stateId, short as state, regionId from State) as s
                                                    on User.state=s.stateId
                                                    left join (select id as regionId, `name` as regionName from Region) as r
                                                    on s.regionId=r.regionId
                                                    where User.id=$id limit 1;")[0];
                        $item['applications'] = self::$db->selectAll('Application', array( 'createdBy' => $id ));
                        $item['myPermissions'] = getPermissions('User', $_SESSION['user']->id);
                        $item['permissions'] = getPermissions('User', $id);
                        $response = array(
                            'status' => true,
                            'item' => $item
                        );
                        break;
                }
                        break;
            case 'load-submission':
                        $id = self::$post['id'];
                        $answers = self::$db->query("select

                                                    Submission.id as id,
                                                    Submission.submittedOn as submittedOn,
                                                    Submission.lastEditedOn as lastEditedOn,
                                                    Submission.userId as userId,
                                                    Application.id as appId, 
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
                                                    Answer.id as answerId,
                                                    Answer.answer as answer,
                                                    Answer.choiceId as choiceId,
                                                    Choice.id as choiceId,
                                                    Choice.choice
                                                    from
                                                    Submission left join
                                                    Application left join 
                                                    Form left join 
                                                    Question left join 
                                                    Answer left join
                                                    Choice
                                                    on Choice.questionId=Answer.questionId and Answer.choiceId=Choice.id 
                                                    on Question.id=Answer.questionId and Answer.userId=userId
                                                    on Form.id=Question.formId 
                                                    on Application.id=Form.appId 
                                                    on Application.id=Submission.appId 
                                                    where Submission.id=$id");
        
                        foreach ($answers as $index => $answer)
                        {
                            if($answer['questionType'] == TXT_UPLOAD || $answer['questionType'] == IMAGE_UPLOAD)
                            {
                                $answers[$index]['uploads'] = EventManager::$db->selectAll('Upload', array('answerId' => $answer['answerId']));
                            }
                                
                        }
                        
                        $response = array(
                            'sub' => $answers,
                            'status' => true
                        );
                        
                        
                        
                break;
                    case 'save-user-permission':
                        $selected = self::$post['selected'];
                        $type = self::$post['type'];
                        $userId = self::$post['userId'];
                        $checked = self::$post['checked'];
                        $all = self::$post['all'];
                        if($type == 'fedId') $other = 'regionId';
                        else if($type == 'regionId') $other = 'fedId';
                        
                        if($checked == "true")
                        {
                            if($all == "true")
                            {
                                self::$db->query("delete from Permission where userId=$userId and $type!=0");
                                foreach ($selected as $s)
                                {
                                    self::$db->insert('Permission', array(
                                        'userId' => $userId,
                                        $type => $s
                                    ));
                                }
                            }
                            else
                            {
                                self::$db->insert('Permission', array(
                                        'userId' => $userId,
                                        $type => $selected
                                    ));
                            }
                            
                                
                        }
                        else
                        {
                            if($all == "true")
                            {
                                self::$db->query("delete from Permission where userId=$userId and $type!=0");
                            }
                            else
                            {
                                self::$db->delete('Permission', array(
                                    'userId' => $userId,
                                    $type => $selected
                                ));
                            }
                        }
                        
                        $response = array(
                            'status' => true,
                            'message' => 'Permissions successfully updated.'
                        );
                        break;
            
        }
        echo json_encode($response, JSON_NUMERIC_CHECK);
        exit;
    }
    
    public static function url($fileURL)
    {
        return 'http://' . HOST . EventManager::$base . $fileURL;
    }
    
    public static function login($email, $password)
    {
        return self::$db->authenticateUser($email, sha1(md5($password . PASS_STRING)));
    }
    
    public static function signup($nvp)
    {
        return self::$db->signup($nvp);
    }
}

?>
