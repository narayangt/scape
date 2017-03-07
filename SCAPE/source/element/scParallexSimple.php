<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 1/2/17
 * Time: 6:50 AM
 */

namespace scape\source\element;


class ParallexSimple extends Element {
    public function __construct($height="", $width="",$id="", $class="")
    {
        parent::__construct("div", $id, $class, $height, $width);
    }

    /**
     * @param $name
     * @param $url
     * @param null|string|Element $caption
     */
    public function addImage($name, $url, $caption=null){
        $name="img-".$name;
        $tmpImage= new Div("",$name);
        $tmpStr='url("'.$url.'")  center  no-repeat fixed';
        $tmpImage->setStyle("background",$tmpStr);
        $tmpImage->setStyle("background-size", "cover");
        $tmpCaption=new Div("","caption");
        $tmpSpan= new Element("span","","border");
        if(is_string($caption)){
            $tmpSpan->setText($caption);
            $tmpCaption->addSubElement($tmpSpan);
            $tmpImage->addSubElement($tmpCaption);
        }
        else if(is_object($caption))
            $tmpImage->addSubElement($caption);

        $this->addSubElement($tmpImage);
    }
    public function addContent($content,$name="parallax-section"){
        $tmpDiv=new Div("",$name);
        $tmpDiv->setAttribute("style","position:relative;");
        $tmpChildDiv=new Div();
        if(is_string($content)){
            $tmpP= new Element("p");
            $tmpP->setText($content);
            $tmpChildDiv->addSubElement($tmpP);
        }
        else if(is_object(($content))){
            $tmpChildDiv->addSubElement($content);
        }
        $tmpDiv->addSubElement($tmpChildDiv);
        $this->addSubElement($tmpDiv);
    }
}