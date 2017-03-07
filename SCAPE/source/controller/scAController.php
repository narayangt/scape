<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 9/9/16
 * Time: 8:02 AM
 */

namespace scape\source\controller;

abstract class AController{
    use Environment;
    public function __construct(){
        $this->loadEnvironment();
    }
    public function isSubmitted($method="post"){
        return ($_SERVER['REQUEST_METHOD'] == strtoupper($method))? true:false;
    }
    public function home(){

    }
    public function __toString(){
        $return=PHP_EOL;
        $return.="Redirect to: ".$this->getRedirectTo().PHP_EOL;
        $return.="Environment Vars: ".PHP_EOL;
        foreach ($this->envVars as $key=> $var)
            $return.="     ".$key." = ".$var.PHP_EOL;
        $return.="Vars: ".PHP_EOL;
        foreach ($this->vars as $key=> $var)
            $return.="     ".$key." = ".$var.PHP_EOL;
        return $return;
    }


}
