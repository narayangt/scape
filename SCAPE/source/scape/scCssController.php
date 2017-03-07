<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 7/8/16
 * Time: 8:28 AM
 */

namespace scape\source\scape;


use scape\source\element\Element;

class CssController{
    private static $instance;
    protected $cssList;

    private function __construct(){
        $this->cssList=array();
    }
    public static function getInstance(){
        if (self::$instance ===NULL)
            self::$instance = new CssController();
        return self::$instance;
    }
    public function addStyle(Css $style){
        $this->cssList[$style->getName()]=$style;
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function getStyle($name){
        if($this->isStyleExist($name))
            return $this->cssList[$name];
        return false;
    }
    private function isStyleExist($name){
        return (isset($this->cssList[$name]))? true:false;
    }

    /**
     * @return Element
     */
    public function getStyles($depth=0):Element{
        $space='  ';
        $tab=str_repeat($space,$depth);
        $tag=new Element("style");
        $values["type"]="text/css";
        $tag->setAttribute($values);

        /** @var Css $style */
        foreach($this->cssList as $name=> $style)
            $tag->appendText(PHP_EOL.$tab.$style->getCss($depth));
        return $tag;
    }
    public function __toString(){
        return $this->getStyles()->getHtml();
    }

    public function __clone(){}
    public function __wakeup(){}
}


?>