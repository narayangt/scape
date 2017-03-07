<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 19/7/16
 * Time: 10:51 PM
 */
//namespace scape;
define("SC_ROOT", dirname( __FILE__ ) ."/" );
define("SC_PREFIX", "sc");
define("SC_EXTENSION", ".php");
define("HOME_PATH","http://reunitefornepal.com/SCAPE/");
define("NL","<br>".PHP_EOL);
define("VAR_PREFIX","{{##");
define("TITLE","Planet on net:: Future of the web application");
define("COPYRIGHT_NAME","Narayan Bhandari");

//cho "filePath: ".SC_ROOT.PHP_EOL;
//start session if not started

if(!isset($_SESSION))
    session_start();

function isFileExist($path):bool{
    return file_exists($path)? true:false;
}


function loadSetup($file="setup.php"){

    //echo $file= getcwd()."/".$file;
    if(file_exists($file));
        include_once($file);
}


/**
 * @param $class_name
 */
spl_autoload_register(
    function ($namespace) {
        $parts= explode('\\',$namespace);
        $class_name= array_pop($parts);
        $project_name=array_shift($parts);
        $includePath=SC_ROOT.implode('/',$parts)."/".SC_PREFIX.$class_name.SC_EXTENSION;
        $trail=NL."Namespace: $namespace";
        $trail.=NL."Class Name: $class_name";
        $trail.=NL."Looking for: $includePath";


        if(isFileExist($includePath)) {
            $trail.=NL."$class_name Found";
            include_once($includePath);
        }
        else{
            $trail.=NL."$class_name not found";
        }

        /*
        $directory=[
            "home"       =>  ["admin","site","model","view","controller"],
            "library"   =>  [],
            "source"    =>  ["model","controller", "element", "registry", "scape", "template", "view"]];
        $includePath="";
        $found=false;
        $trail=PHP_EOL.PHP_EOL."namespace: ".$namespace.PHP_EOL;
        $parts=explode('\\', $namespace);
        $class_name= end($parts);
        foreach ($directory as $dir => $sub_dir) {
            $classFileName = SC_ROOT .$dir."/". SC_PREFIX . $class_name . SC_EXTENSION;
            $trail.="looking: ".$classFileName.PHP_EOL;
            if(isFileExist($classFileName)) {
                $found= true;
                $includePath=$classFileName;
            }
            else if(is_array($sub_dir)){
                foreach ($sub_dir as $tmp_dir){
                    $classFileName = SC_ROOT .$dir."/".$tmp_dir."/". SC_PREFIX . $class_name . SC_EXTENSION;
                    $trail.="looking: ".$classFileName.PHP_EOL;
                    if(isFileExist($classFileName)){
                        $found= true;
                        $includePath=$classFileName;
                    }
                }
            }
        }
        $trail.="class: ".$class_name.PHP_EOL;
        if ($found) {
            $trail .= "found class: " .$class_name." path: ".$includePath . PHP_EOL;
            include_once($includePath);
        }
        else{
            $trail.="could not locate: ".$classFileName.PHP_EOL;
        }
        */
        //echo $trail;

});

function getFilePath(){

}



// method to remove unwanted char in a string

function absoluteString($str)
{
    return str_replace(array("\n\r", "\n", "\r","\t"), "", $str);
}

// methods to get values in different mode
/**
 * @param $var
 * @param string $mode
 * @param string $default
 * @return string
 */
function request($var, $mode="", $default=""){
    $return=null;
    switch($mode) {
        case "GET": case "get":
            $return=$_GET[$var] ?? $default;
        break;
        case "POST": case "post":
            $return=$_POST[$var] ?? $default;
        break;
        case "SESSION": case "session":
            $return=$_SESSION[$var]??$default;
        break;
        case "request": case "REQUEST":
            $return=$_REQUEST[$var]??$default;
            break;
        default:
            $return= $_SESSION[$var]?? $_REQUEST[$var] ?? $return= $_COOKIE[$var] ?? $default;
            break;
    }
    if(!strlen($return)>0)
        $return=$default;
    return absoluteString($return);
}

function getTimestamp(){
    return $_SERVER["REQUEST_TIME"];
}


class DBSets
{
    const int_12 		= "int(12)";
    const int_5			= "int(5)";

    const bigint_20		= "bigint(20)";

    const double		= "double";

    const varchar_5		= "varchar(5)";
    const varchar_20	= "varchar(20)";
    const varchar_50	= "varchar(50)";
    const varchar_250	= "varchar(250)";
    const varchar_500	= "varchar(500)";
    const varchar_750	= "varchar(750)";
    const varchar_1000  = "varchar(1000)";

    const null			= "NULL";
    const not_null		= "NOT NULL";
    const unique_key	= "UNIQUE KEY";
    const primery_key	= "PRIMARY KEY";
    const auto_increment= "AUTO_INCREMENT";

    const auto_inc_value= "1000000000001";
    const engine        = "ENGINE";
    const innodb_default= "InnoDB DEFAULT";
    const charset       = "CHARSET";
    const latin1        = "latin1";
}

class AppConstant{
    const MENU          = "menu";
    const ADMIN_MENU    = "adminMenu";
    const HEADER_CONTENT= "headerContent";
    const FOOTER_CONTENT= "footerContent";
    const LEFT_SIDE_BAR = "leftSideBar";
    const RIGHT_SIDE_BAR= "rightSideBar";
    const FAR_LEFT_SIDE_BAR="farLeftSideBar";
    const FAR_RIGHT_SIDE_BAR="farRightSideBar";
    const CONTENT       = "content";

}