<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 8/2/17
 * Time: 5:08 PM
 */

include_once("SCAPE/scInit.php");

use SCAPE\source\scape\Route;

$controller =request("controller","get","home");        // module ie: HomeController name
$view       =request("view","get",$controller);         // view name to render output
$action     =request("action","get");                   // action to call on controller otherwise nothing will called

$run= new Route($controller,$view);
//if(strlen($action)>0)
    $run->call($action);
$run->render();
