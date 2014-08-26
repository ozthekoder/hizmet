<?php
session_start();
include_once 'config.php';
include_once 'underscore.php';
include_once 'xlsxwriter.class.php';
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
    else if(file_exists('modules/' . strtolower($classname) . '/' . $filename))
    {
        $filename = 'modules/' . strtolower($classname) . '/' . $filename;
        include_once($filename);
    }
    else if(file_exists('objects/' . $filename))
    {
       $filename = 'objects/' . $filename;
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
    $_inlineJs = "\n<!--//--><![CDATA[//><!--\nOZ = " . json_encode($_jsConfig, JSON_NUMERIC_CHECK) . ";\n//--><!]]>\n";
    $includes .= "<script type=\"text/javascript\">$_inlineJs</script>\n";

    return $includes;
}

function getPermissions($for, $id)
{
    switch($for)
    {
        case 'User':
            $federationPermissions = EventManager::$db->query("select * from Permission right join Federation on Permission.fedId=Federation.id where userId=$id group by Permission.id");
            $regionPermissions = EventManager::$db->query("select * from Permission right join Region on Permission.regionId=Region.id where userId=$id group by Permission.id");
            $p = array(
                'Federation' =>  $federationPermissions,
                'Region' =>  $regionPermissions
            );
            break;
        case 'Application':
            $federationPermissions = EventManager::$db->query("select * from Permission right join Federation on Permission.fedId=Federation.id where appId=$id group by Permission.id");
            $regionPermissions = EventManager::$db->query("select * from Permission right join Region on Permission.regionId=Region.id where appId=$id group by Permission.id");
            $p = array(
                'Federation' =>  $federationPermissions,
                'Region' =>  $regionPermissions
            );
            break;
    }
//    var_dump($p);
//    exit;
    return $p;
}

function cleanData( &$str ) {
    $str = preg_replace( "/\t/", "\\t", $str );
    $str = preg_replace("/\r?\n/", "\\n", $str);
}
function excelize($data)
{
    $flag = false;
    foreach( $data as $row ) {
        if( !$flag ) {
            // display field/column names as first row
            echo implode( "\t", array_keys( $row ) ) . "\r\n";
            $flag = true;
        }
        array_walk( $row, 'cleanData' );
        return implode( "\t", array_values( $row ) ) . "\r\n";
    }
}
                        
                        

?>
