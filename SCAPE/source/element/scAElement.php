<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 5/8/16
 * Time: 9:54 AM
 */

namespace scape\source\element;


use scape\source\scape\Css;
use scape\source\scape\CssController;

abstract class AElement
{
    protected $tagName;
    protected $attributes;
    protected $styles;
    protected $text;
    protected $closingTag;
    protected $wrapper;

    public function __construct($tagName, $id="", $class="", $height=0, $width=0, $closingTag=true, $text="",$attributes=null, $styles=null)
    {
        if(strlen($class)<=0)
            $class=$id;
        $this->setTag($tagName);

        $this->attributes= array();
        $this->styles= array();
        $this->childs=array();

        // todo
        //$this->setParent();


        $this->setID($id);
        $this->setClass($class);
        $this->setMinHeight($height);
        $this->setMinWidth($width);

        $this->setText("");
        $this->setClosingTag($closingTag);
        $this->setText($text);
        $this->setAttribute($attributes);
        $this->setStyle($styles);

    }

    public function setTag($tag){
        $this->tagName=$tag;
    }
    public function getTag(){
        return $this->tagName;
    }
    public function setID($id){
        $this->setAttribute(["id"=>$id]);
    }
    public function getID(){
        return $this->getAttribute("id");
    }

    /**
     * @param string|array $attribute
     * @param string $value
     * @param bool $insertEmpty  : for scForm as input need to set disabled which is without any value
     */
    public function setAttribute($attribute, $value="", $insertEmpty=false){
        if(is_array($attribute)) {
            foreach ($attribute as $key => $val)
                if (strlen($val) > 0)
                    $this->attributes[$key] = $val;
        }
        else {
            if (strlen($value) > 0 || $insertEmpty)
                $this->attributes[$attribute] = $value;
        }
    }

    /**
     * @param $attribute
     * @return string| bool
     */
    public function getAttribute($attribute){
        return $this->attributes[$attribute] ?? false;
    }
    public function setClass($class){
        $this->setAttribute(["class"=>$class]);
    }
    public function setMinHeight($height){
        if(intval($height)>0)
            $this->setStyle(["min-height"=>$height]);
    }
    public function setMinWidth($width){
        if(intval($width)>0)
            $this->setStyle(["min-width"=>$width]);
    }
    public function setBackground($color){
        $this->setStyle(["background-color"=>$color]);
    }
    public function setBCImage($url){
        $this->setStyle(["background-image"=>"url(".$url.")"]);
    }
    public function setText($text){
        $this->text=$text;

    }
    public function appendText($text){
        $this->text.=$text;
    }
    public function getText(){
        return $this->text;
    }
    /**
     * @param string|array $style
     * @param string $value
     */
    public function setStyle($style, $value=""){
        if(is_array($style)) {
            foreach ($style as $key => $val)
                $this->setStyle($key,$val);
        }
        else
            if(strlen($value)>0) {
                $this->styles[$style] = $value;
                $this->generateCss();
            }
    }
    public function setClosingTag($flag=true){
        $flag= $flag? true:false;
        $this->closingTag=$flag;
    }
    private function generateCss(){
        if(count($this->styles)>0){
            $styleName=$this->getTag();
            if(strlen($this->getAttribute("class"))>0)
                $styleName.=".".$this->getAttribute("class");
            else if(strlen($this->getAttribute("id"))>0)
                $styleName="#".$this->getAttribute("id");
            $css= new Css($styleName,$this->styles);
            CssController::getInstance()->addStyle($css);
        }
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name,$value);
    }
    public function __get($name)
    {
        return $this->getAttribute($name);
    }
    public function setWrapper($wrapper=""){
        $this->wrapper=$wrapper;
    }
    private function getWrapper(){
        return $this->wrapper;
    }
    public function getHtml($depth=0){

        $space='  ';
        $tab=str_repeat($space,$depth);
        $return=PHP_EOL.$tab."<".strtolower($this->getTag());
        $tab=str_repeat($space,$depth+1);
        if(count($this->attributes)>0)
            foreach($this->attributes as $entity => $value)
                $return.= ' '.$entity.'="'.$value.'"';

        if($this->closingTag) {
            $return.='>';
            if(strlen($this->getWrapper())>0){
                $depth++;
                $tab=str_repeat($space,$depth);
                $return.=PHP_EOL.$tab.'<'.$this->getWrapper().'>';
            }
            if(strlen($this->getText())>20)
                $return.=PHP_EOL.$tab;
            $return.=$this->getText();
            if(count($this->childs)>0) {
                /** @var Element $child */
                foreach($this->childs as $child) {
                    $return.=$child->getHtml($depth+1);
                }
            }
            if(strlen($this->getWrapper())>0){
                $depth--;
                $tab=str_repeat($space,$depth+1);
                $return.=PHP_EOL.$tab.'</'.$this->getWrapper().'>';
            }
            if(strlen($this->getText())>20 || count($this->childs)>0){
                $tab=str_repeat($space,$depth);
                $return.=PHP_EOL.$tab;
            }
            $return.='</'.strtolower($this->getTag()).'>';
        }
        else
            $return.= '/>';
        return $return;
    }
    public function __toString(){
        return $this->getHtml();
    }

}