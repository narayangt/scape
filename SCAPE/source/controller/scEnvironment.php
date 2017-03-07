<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 25/2/17
 * Time: 1:16 PM
 */

namespace SCAPE\source\controller;

trait Environment{
    protected $envVars;
    protected $redirect;
    protected $redirectTo;
    protected $environment;

    protected function loadEnvironment(){
        $this->setRedirect();
        $this->setRedirectTo();
        $this->envVars=array();
        $this->environment= ["get"     =>  $_GET,
                            "post"      =>  $_POST,
                            "request"   =>  $_REQUEST,
                            "session"   =>  $_SESSION,
                            "cookie"    =>  $_COOKIE,
                            "server"    =>  $_SERVER];

        foreach ($this->environment as $method => $dec){
            foreach ($dec as $param_name => $param_val){
                $this->envVars[$method][$param_name]=$param_val;
            }
        }
    }
    public function getEnvVars($key, $method="get"): string {
        if(array_key_exists($key,$this->environment[$method]))
            return $this->envVars[$method][$key];
        return false;
    }

    public function reDirect($redirect=""){
        if(strlen($redirect)>0)
            $this->setRedirectTo($this->getRedirectTo().$redirect);
        header("location: ".$this->getRedirectTo());
        exit();
    }

    /**
     * @param array|string $condition
     * @param string $value
     * @param string $method
     * @return bool
     */
    public function on($condition,$value,$method="get"):bool{
        $return = true;
        if (is_array($condition)) {
            foreach ($condition as $tmpArr) {
                if (!isset($tmpArr[2]))
                    $tmpArr[2] = "get";
                $result = $this->on($tmpArr[0], $tmpArr[1], $tmpArr[2]);
                if (!$result)
                    $return = false;
            }
        } else
            return $this->getEnvVars($condition, $method) == $value ? true : false;
        return $return;
    }

    public function getRedirect(){
        return $this->redirect;
    }

    public function setRedirect($redirect=true){
        $this->redirect = ($redirect) ? true : false;
    }

    public function getRedirectTo(){
        return $this->redirectTo;
    }

    public function setRedirectTo($redirectTo=HOME_PATH){
        $this->redirectTo = $redirectTo;
    }
}