<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 5/8/16
 * Time: 9:36 AM
 */

namespace scape\source\element;


interface IElement{
    public function setTag($tag);
    public function getTag();
    public function setID($id);
    public function getID();
    public function setAttribute($attribute,$value="");
    public function setClass($class);
    public function setMinHeight($height);
    public function setMinWidth($width);
    public function setBackground($color);
    public function setBCImage($url);
    public function setText($text);
    public function appendText($text);
    public function getText();
    public function setStyle($style,$value="");
    public function setClosingTag($flag=true);
    public function getHtml();
    public function __toString();
}

?>