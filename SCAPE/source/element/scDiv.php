<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 9/8/16
 * Time: 9:21 AM
 */

namespace scape\source\element;


class Div extends Element {
    public function __construct($id="", $class="", $height=0, $width=0,$text="",$attributes=null,$styles=null){
        parent::__construct("div", $id, $class, $height, $width, true,$text,$attributes,$styles);
    }
}