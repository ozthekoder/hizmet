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
        jsConfig('loginBox', $loginBox->createHTML());
        switch(self::$params[0])
        {
            case '':
                
                return $this->loadModule('Home');
                
                break;
            case 'home':
                
                return $this->loadModule('Home');
                
                break;
            case 'admin':
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
            case 'crop-avatar':
                
                echo $this->loadModule('Crop');
                exit;
                break;
            case 'logout':
                
                return $this->loadModule('Logout');
                
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
        }
        echo json_encode($response);
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
