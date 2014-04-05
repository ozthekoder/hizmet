<?php
include_once 'config.php';

function __autoload($classname)
{
    $filename = $classname . '.php';
    if(file_exists($filename))
    {
        $filename = './' . $filename;
        include_once($filename);
    }
    else if(file_exists('modules/' . $filename))
    {
       $filename = 'modules/' . $filename;
       include_once($filename);
    }
    else if(file_exists('objects/' . $filename))
    {
       $filename = 'objects/' . $filename;
       include_once($filename);
    }
    else if(file_exists('modules/' . strtolower($classname) . '/' . $filename))
    {
        $filename = 'modules/' . strtolower($classname) . '/' . $filename;
        include_once($filename);
    }
}

function userExists()
{
    if(!isset($_SESSION['user']) || empty($_SESSION['user']))
        return false;
    else return true;
}

function jsConfig($key, $val) 
{
    global $_jsConfig;
    $_jsConfig[$key] = $val;
}

function addJSVars()
{
    global $_jsConfig;
    $_inlineJs = "\n<!--//--><![CDATA[//><!--\nOZ = " . json_encode($_jsConfig) . ";\n//--><!]]>\n";
    $includes .= "<script type=\"text/javascript\">$_inlineJs</script>\n";

    return $includes;
}
?>
