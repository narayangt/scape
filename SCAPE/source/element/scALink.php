<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 17/9/16
 * Time: 7:14 AM
 */

namespace scape\source\element;

use scape\source\element\Element;

class ALink extends Element
{
    public function __construct($text="Link",$href="#",$id="",$class="",$height=0,$width=0,$attributes=null,$styles=null){
        parent::__construct("a",$id,$class,$height,$width,true,$text,$attributes,$styles);
        $this->setLink($href);
    }
    public function setLink($link){
        $this->setAttribute("href",$link);
    }
}