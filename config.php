<?php
error_reporting(E_ERROR);
date_default_timezone_set('UTC');
//define('DB_HOST', 'balkanamerican.domaincommysql.com', true);
//define('DB_USER', 'ozthekoder', true);
//define('DB_NAME', 'hizmet', true);
//define('DB_PASSWORD', 'Kafa1500', true);
define('DB_HOST', 'localhost', true);
define('DB_USER', 'root', true);
define('DB_NAME', 'hizmet', true);
define('DB_PASSWORD', '', true);
define('PASS_STRING', 'Osman Ozdemir is a fucking genius.');
define('MANDRILL_API_KEY', 'e1XIGvOfJLxKK6ZN_loiUg');
define('REGULAR', 0); //Applicant
define('ADMIN', 1); //Region Admin
define('SUPER_ADMIN', 2);
define('MALE', 0);
define('FEMALE', 1);
define('SHORT_ANSWER', 0);
define('ESSAY_ANSWER', 1);
define('MULTICHOICE_SINGLESELECT', 2);
define('MULTICHOICE_MULTISELECT', 3);
define('TXT_UPLOAD', 4);
define('IMAGE_UPLOAD', 5);
define('INCOMPLETE', 0);
define('COMPLETE', 1);
define('UPLOADS', 'uploads/');
define('HOST', $_SERVER['SERVER_NAME']);
$_jsConfig = array();
?> 