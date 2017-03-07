<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 17/8/16
 * Time: 8:38 AM
 */

namespace scape\source\template;

include_once("../../scInit.php");


/**
 * Class Template
 *
 */
class Template extends ATemplate{
    public function __construct($adminMenu=false, $header=true, $menu=true, $farLeftSideBar=false,
                                $leftSideBar=true, $rightSidebar=true, $farRightSideBar=false, $footer=true){
        parent::__construct($adminMenu, $header, $menu, $farLeftSideBar, $leftSideBar, $rightSidebar, $farRightSideBar, $footer);
    }
}


?>