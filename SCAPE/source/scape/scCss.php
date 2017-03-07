<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 7/8/16
 * Time: 8:22 AM
 */

namespace scape\source\scape;


use scape\source\element\Element;

class Css {
    protected $name;
    protected $styles;


    public function __construct($name,$styles){
        $this->setName($name);

        $this->styles=array();

        $this->addStyles($styles);
    }
    public function setName($name){
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }
    public function addStyles($styles){
        if(count($styles)>0)
            foreach($styles as $key=>$value)
                $this->styles[$key]=$value;
    }
    public function getCss($depth=0)
    {
        $tab=str_repeat(' ',$depth);
        $result=PHP_EOL.$tab.$this->getName().'{';
        $tab=str_repeat(" ",$depth+1);
        foreach($this->styles as $key=>$value)
            $result.=PHP_EOL.$tab.' '.$key.': '.$value.';';
        $result.=PHP_EOL.$tab.'}';
        return $result;
    }

    public function __toString(){
        return $this->getCss();
    }

}