<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 26/2/17
 * Time: 8:22 PM
 */


/**
 *
 *      uri:    www.reunitefornepal.com/index.php?home=home&view=home
 *              www.reunitefornepal.com/index.php?home=home&view=home&action=login"
 *      or
 *      todo
 *      uri:    www.reunitefornepal.com/home/home
 *              www.reunitefornepal.com/home/sucess/login"
 *
 * @var \SCAPE\source\Model\Model
 */

namespace SCAPE\source\scape;
use scape\source\controller\BaseController;
use scape\source\view\View;


class Route{
    protected $app;
    protected $model;
    protected $view;
    protected $controller;
    protected $namespace;
    public function __construct($controller, $view){
        $this->namespace=[];
        $this->setApp($controller);
        $this->init($controller,$view);
    }
    private function setApp($name){
        $this->app=$name;
    }
    private function init($appName,$view){
        $this->setNamespace();
        $view           =   ucfirst($view)."View";
        $controller     =   ucfirst($appName)."Controller";
        if($sucess=$this->createController($controller))
            if($sucess=$this->createView($view))
                return true;
        header("location:http://reunitefornepal.com/error/error404");
    }
    private function createView($view){
        $trail=NL."View: $view creating";
        $className=$this->getNamespace("view").$view;
        $trail.=NL."Class: $className";
        if(class_exists($className)) {
            $trail .= NL . "Class : $className found";
            $this->view= new $className();
            $trail.=NL." $view created".NL;

            return true;
        }
        else
            $trail.=NL."Class : $className Not found";
        return false;
    }
    private function createController($controller){
        $trail=NL."controller: $controller creating";
        $className=$this->getNamespace("controller").$controller;
        $trail.= NL."class: $className";
        if(class_exists($className)) {
            $trail .= NL . "Class : $className found";
            $this->controller = new $className();
            $trail.=NL." $controller created".NL;
            return true;
        }
        else
            $trail.=NL."Class : $className Not found";
        return false;
    }
    private function getController():BaseController{
        return $this->controller;
    }
    private function getView():View{
        return $this->view;
    }
    public function setNamespace(){
        $this->namespace=[
            "model"     =>  "SCAPE\\app\\model\\",
            "view"      =>  "SCAPE\\app\\view\\$this->app\\",
            "controller"=>  "SCAPE\\app\\controller\\"
        ];
    }
    public function getNamespace($key){
        return array_key_exists($key,$this->namespace)? $this->namespace[$key]: "";
    }
    public function call($action){
        if(method_exists($this->getController(),$action)) {
            $this->getController()->{$action}();
            //echo "method $action exist".NL;
        }
        //else
          //  echo "method $action doesn't exist on controller: ".get_class($this->getController()).NL;
    }
    public function render($echo=true){
        $output=$this->getView()->render($this->getController()->getDataModel());
        if($echo)
            echo $output;
        return $output;
    }
}