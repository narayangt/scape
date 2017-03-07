<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 29/12/16
 * Time: 9:22 PM
 */

namespace scape\source\view;

use scape\source\element\Div;
use scape\source\element\Element;
use SCAPE\source\Model\Model;
use scape\source\template\Template;

abstract class AView{
    protected $entity;
    public function __construct(){
        $this->entity=array();
    }
    public function entity($identifier,Element $element){
        $this->entity[$identifier]=$element;
    }
    public function getEntity($entity):Element{
        if(array_key_exists($entity,$this->entity))
            return $this->entity[$entity];
        return null;
    }
    public function __get($name):Element {
        return $this->getEntity($name);
    }
    public function __set($name, $value){
        $this->getEntity($name)->setText($value);
    }

}
