<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 19/1/17
 * Time: 8:52 PM
 */

namespace scape\source\element;


class Alert extends Element   {

    /**
     * Alert constructor.
     * @param $title
     * @param string|Element $description
     * @param string $bgColor
     * @param string $id
     * @param string $class
     * @param null $attributes
     * @param null $styles
     */
    public function __construct($title, $description, $bgColor="", $id="alert", $class="", $attributes=null, $styles=null){
        parent::__construct("div",$id,$class,"","",true,"",$attributes,$styles);
        $this->addSubElement(new Element("span","closeBtn","","","",true,"&times;",[
            "title"=>"Close this Alert",
            "onClick"=>"this.parentElement.style.display='none';"
        ]));
        $this->addSubElement(new Element("strong","","","","",true,$title."!"));
        $tmpTxt=new Div();

        if(is_object($description))
            $tmpTxt->addSubElement($description);
        else
            $tmpTxt->setText($description);
        $this->addSubElement($tmpTxt);
        $this->setBGColor($bgColor);
    }
    public function setBGColor($bgColor="green"){
        $this->setBackground($bgColor);
        if($bgColor!="green"){
            $this->setStyle(
                [
                    "padding"=>"20px"
                ]);
        }
    }
}