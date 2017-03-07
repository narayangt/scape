<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 4/3/17
 * Time: 12:52 PM
 */

namespace SCAPE\source\Model;


class DataModel{
    protected $data;
    public function __construct(){
        $this->data= [];
    }
    public function __set($var,$value){
        $this->data[$var]=$value;
    }
    public function __get($name){
        return array_key_exists($name,$this->data)? $this->data[$name]:false;
    }
}