<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 6/3/17
 * Time: 7:04 PM
 */

namespace SCAPE\app\view\error;


use scape\source\view\View;
use scape\source\element\Div;
use scape\source\element\Element;
use scape\source\element\ALink;

class ErrorView extends View{
    public function onLoad(){
        $this->template->setPageView(false,false,false,false,false,false,false,true);
        $errorIcon=new Element("p");
        $errorIcon->setAttribute("style","line-height:0.7;");
        $errorIcon->setText("
&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;<br>
&#9618;&#9618;&#9617;&#9617;&#9617;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9618;&#9617;&#9618;&#9618;<br>
&#9618;&#9618;&#9617;&#9618;&#9618;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9617;&#9618;&#9618;<br>
&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9618;&#9618;&#9617;&#9618;&#9617;&#9617;&#9618;&#9618;&#9618;&#9617;&#9618;&#9618;<br>
&#9618;&#9618;&#9617;&#9618;&#9618;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9618;&#9618;&#9618;<br>
&#9618;&#9618;&#9617;&#9617;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9617;&#9617;&#9618;&#9618;&#9617;&#9618;&#9617;&#9618;&#9618;&#9617;&#9618;&#9618;<br>
&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;&#9618;");

        $errorCode = new Element("span");
        $errorCode->setWrapper("h1");



        $errorDesc = new Div();
        $errorDesc->setWrapper("h3");

        $errorMsg = new Div();

        $this->entity("errorIcon",$errorIcon);
        $this->entity("errorCode",$errorCode);
        $this->entity("errorDesc",$errorDesc);
        $this->entity("errorMsg",$errorMsg);
    }

    public function populate(){
        $tmpDiv= new Div();

        $tmpLink= new ALink("","http://reunitefornepal.com/");
        $tmpLink->addSubElement([$this->getEntity("errorCode"),$this->getEntity("errorDesc"),
                                    $this->getEntity("errorMsg")]);
        $tmpDiv->addSubElement([$this->getEntity("errorIcon"),$tmpLink]);
        $this->template->addSectionChild("content", $tmpDiv);
    }
}