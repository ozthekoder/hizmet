<?php
//var_dump($dbManager->authenticateUser('asd@buncee.com', md5('1')));
//var_dump($dbManager->query('select * from Users;'));
//var_dump($_SERVER);
//var_dump($eventManager);

session_start();
include_once('util.php');


$eventManager = new EventManager();

//EventManager::$db->createObjectClassFromTable('User');
//$array = array(
//    'email' => 'oozdemir2704@gmail.com',
//    'password' => 'Kafa1500',
//    'firstName' => 'Osman',
//    'lastName' => 'Ozdemir',
//    'dob'   => '1988-04-27',
//    'registeredOn' => time(),
//    'accountType' => ADMIN
//);
//
//EventManager::$db->signup($array);

//$array = array(
//    'email' => 'oozdemir2704@gmail.com',
//    'password' => sha1(md5('osoz7162' . PASS_STRING))
//);
//$user = new User($array);
//$user = $user->load();
//$user = $user->save();
$page = $eventManager->serve();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teach and Travel</title>
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/bootstrap.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/bootstrap-theme.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/icons.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/style.css') ?>" media="all" />
        <link href='http://fonts.googleapis.com/css?family=Sniglet:400,800|Architects+Daughter' rel='stylesheet' type='text/css'>
        <?php
            echo $eventManager->css;
        ?>
        <script type="text/javascript" src="<?= EventManager::url('js/modernizr.custom.js') ?>"></script>
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" style="font-family: Architects Daughter;" href="<?= EventManager::url('home') ?>">Teach and Travel</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?= EventManager::url('home') ?>">Home</a></li>
            <?php if(userExists()): ?>
                <li><a href="<?= EventManager::url('profile') ?>">Profile</a></li>
                <?php if($_SESSION['user']->accountType == ADMIN): ?>
                    <li><a href="<?= EventManager::url('profile') ?>">Admin</a></li>
                <?php endif; ?>
            <?php else :?>
                    <li><a id="login-opener" style="cursor: pointer;" data-trigger="click" data-html="true" data-animation="true" data-container="body" data-toggle="popover" data-placement="bottom">Login</a></li>
                <li><a href="<?= EventManager::url('register') ?>">Register</a></li>
            <?php endif; ?>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= EventManager::url('contactus') ?>">Contact Us</a></li>
            <li ><a href="<?= EventManager::url('about') ?>">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
            
        </div>
            <?= $page ?>
            <?= addJSVars() ?>
            <script type="text/javascript" src="<?= EventManager::url('js/jquery.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/bootstrap.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/jasny-bootstrap.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/underscore.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/main.js') ?>"></script>
            <?= $eventManager->js ?>
    </body>
</html>
<?php
exit;
?>