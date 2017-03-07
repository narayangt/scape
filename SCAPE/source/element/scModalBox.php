<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 19/1/17
 * Time: 11:15 PM
 */

namespace scape\source\element;


class ModalBox extends Element{
    public function __construct( $id, $title = "Modal Dialog",$class="modalDialog",$height=0,$width=0)
    {
        parent::__construct("div", $id, $class, $height, $width);
        $this->setWrapper("div");
        $close= new ALink("X","#close","","close");
        $close->setAttribute("title","Close");
        $this->addSubElement($close);
        $tmpTitle= new Element("h2");
        $tmpTitle->setText($title);
        $this->addSubElement($tmpTitle);
    }
}