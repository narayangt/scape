<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 24/9/16
 * Time: 8:29 AM
 */

namespace scape\source\element;


class Article extends Div{
    protected $format;
    protected $showReaction;
    protected $formatPopulated;
    public function __construct($id="", $class="article", $height=0, $width=0)
    {
        parent::__construct($id, $class, $height, $width);
        $this->formatPopulated=false;
        $this->populateFormat();
        $this->setTitle();
        $this->setTitleNote();
        $this->setBody();
        $this->setShowReaction();



    }
    public function setTitle($title="I am Title"){
        $this->getElement("title")->setText($title);
    }
    public function setTitleNote($note=""){
        $this->getElement("footNote")->setText($note);
    }
    public function setBody($body="I am Body of this article"){
        $this->getElement("body")->setText($body);
    }
    public function populateFormat(){
        if(!$this->formatPopulated) {
            $this->format = [
                "title" => new Div("title"),
                "footNote" => new Div("footNote"),
                "body" => new Div("body"),
                "reaction" => new Div("reaction")
            ];
        }
    }
    public function setShowReaction($showReaction=true){
        $this->showReaction= $showReaction? true: false;
    }

    /**
     * @param string $element
     * @param View $subView
     */
    public function addSubViewOnElement($element, Element $subView){
        if(!$this->formatPopulated){
            $this->format[$element]->addSubElement($subView);
        }
    }
    public function getElement($element):Element{
        return $this->format[$element];
    }
    public function getHtml(){
        if(!$this->formatPopulated){
            $this->formatPopulated=true;
            $this->addSubElement($this->format['title']);
            $this->addSubElement($this->format["footNote"]);
            $this->addSubElement($this->format['body']);
            if($this->showReaction){
                $this->addSubElement($this->format['reaction']);
            }
        }
        return parent::getHtml();
    }
    public function __toString()
    {
        return $this->getHtml();
    }


}