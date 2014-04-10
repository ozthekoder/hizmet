<?php

include_once('util.php');


$eventManager = new EventManager();

//EventManager::$db->createObjectClassFromTable('Federation');
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
        <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAT5UxACBoBACIWv8AzMzMAL+0zgAkAL4AGTgxABRsAgBuWP4ANAyDACBHDwCe+ZIAWjj2AMSj7gBkDLMAQQvIAEQLhgA8Dn4AOhF+ALSz0wD/4P8AvYP/AD1KMAA2Vh8AFmoBAJJb/gDJrN4ALgGkAMKv1gA7CY0AOhJ8AIVb/wA2AaQAYjvvAMOg8AAyA+EAcjX3ALLRygBvNPoAOQyFAMOS/wAyALgAocDBAEMIiAAOBPEArMG+AAwD9ACebPAAPg99AGo96gA4IqMAIAzaACwAuQAhDNoAwrHSAGMGvwA6Bo8AMFcfAHxIywBECckAQZcxAEYFzAA6DswAsZD/ACcBpwALAMQAOgeNAA0B8wBVB8YAwc7MAH9c/wDBxOAAeFa1ACczMwCNw8QAQSCqACwCtQBtNfoAZQXDAL2T/wDYgf8AXy7+AMiq3wAwBJcAPU4pAG5F1gA9CcsARZUwADcOzgA6DYYAMQCjAHRXtAD+6/4AIwuNAI/FwABxNPYARACzACMBoQBFA9QAL1gfAHQ86AC/qeQAOiz/ABJrBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFwAAAAAAAAAADAgZAgxkOkoAAAAAAAAAVWg9WAEYDAtGAAAAAAAALitfSwUAAAcmAAAAAAAVFmAnHxJaUEgEAAAAAAAASWU8KjETKAoUAAAAAAAAD09FQ15ELSQQWwAAAAAAAFE4YTkzL2dSGhwAAAAAAAAAHRFCNA0/A1dUAAAAAAAAAAAsNglHIFk1VgAAAAAAAAAjITAeYiIGYw4AAAAAAAAAADs+TUFMXGYAAAAAAAAAAAApJU4yQBVdAAAAAAAAAAAAAFMbNwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//AAD//QAA/gEAAPwBAAD4MwAA4AcAAOAPAADADwAAwA8AAOAPAADwDwAA4A8AAPAfAADwHwAA+P8AAP//AAA=" rel="icon" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/bootstrap.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/bootstrap-theme.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/jasny-bootstrap.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/icons.css') ?>" media="all" />
        <link rel="stylesheet" type="text/css" href="<?= EventManager::url('css/jquery.jcrop.css') ?>" media="all" />
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
              <li class="<?php if(EventManager::$currentModule == 'Home') echo 'active'; ?>"><a href="<?= EventManager::url('home') ?>"><span class="icon-home" style="margin-right:5px;"></span>Home</a></li>
            <?php if(userExists()): ?>
                <?php if($_SESSION['user']->accountType == ADMIN): ?>
                    <li class="<?php if(EventManager::$currentModule == 'Admin') echo 'active'; ?>"><a href="<?= EventManager::url('admin') ?>">Admin</a></li>
                <?php else: ?>
                    <li class="<?php if(EventManager::$currentModule == 'Profile') echo 'active'; ?>"><a href="<?= EventManager::url('profile') ?>">Profile</a></li>
                <?php endif; ?>
            <?php else :?>
                    <li><a id="login-opener" style="cursor: pointer;" data-trigger="click" data-html="true" data-animation="true" data-container="body" data-toggle="popover" data-placement="bottom"><span class="icon-key" style="margin-right:5px;"></span>Login</a></li>
                <li class="<?php if(EventManager::$currentModule == 'Register') echo 'active'; ?>"><a href="<?= EventManager::url('register') ?>"><span class="icon-signup" style="margin-right:5px;"></span>Register</a></li>
            <?php endif; ?>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="<?php if(EventManager::$currentModule == 'ContactUs') echo 'active'; ?>"><a href="<?= EventManager::url('contactus') ?>"><span class="icon-phone2" style="margin-right:5px;"></span>Contact Us</a></li>
            <li class="<?php if(EventManager::$currentModule == 'About') echo 'active'; ?>"><a href="<?= EventManager::url('about') ?>"><span class="icon-info" style="margin-right:5px;"></span>About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
            
        </div>
            <?= $page ?>
            <?= addJSVars() ?>
            <script type="text/javascript" src="<?= EventManager::url('js/jquery.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/jquery.jcrop.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/holder.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/bootstrap.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/jasny-bootstrap.js') ?>"></script>
            <script type="text/javascript" src="<?= EventManager::url('js/underscore.js') ?>"></script> 
            <script type="text/javascript" src="<?= EventManager::url('js/backbone.js') ?>"></script> 
            <script type="text/javascript" src="<?= EventManager::url('js/main.js') ?>"></script>
            <?php echo $eventManager->js; ?>
    </body>
</html>
<?php
exit;
?>