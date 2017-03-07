<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 14/1/17
 * Time: 10:23 AM
 */

namespace scape\source\element;


class Form extends Element{
    protected $name;

    public function __construct($formName,$title="",$action="#", $id="", $class="", $height=0, $width=0,$attributes=null,$styles=null)
    {
        parent::__construct("form", $id, $class, $height, $width,true,"",$attributes,$styles);

        $this->setMethod();
        $this->setName($formName);
        if(strlen($title)>0)
            $this->setTitle($title);
        $this->setAction($action);
    }
    public function addText($name="text", $index="", $placeHolder="", $active=true,$value=false){
        $tmpInput= new Element("input","","","","",false);
        if(strlen($placeHolder)==0) {
            $placeHolder = $name;
        }
        $tmpInput->setAttribute(["name"=>$name,
            "type"=>"text",
            "placeholder"=>$placeHolder]);
        if($value)
            $tmpInput->setAttribute("value",$placeHolder);
        $this->addInput($tmpInput,$index,$active);
    }
    public function addSelect($name="select",$index="",$value=null,$active=true){
        $tmpinput=new Element("select");
        $tmpinput->setAttribute(["name"=>$name]);
        foreach ($value as $val=>$desc)
        {
            $tmpOption=new Element("option");
            $tmpOption->setAttribute(["value"=>$val]);
            $tmpOption->setText($desc);
            $tmpinput->addSubElement($tmpOption);
        }
        $this->addInput($tmpinput,$index,$active);
    }
    public function addTextarea($name="textarea", $index="", $placeHolder="", $active=true){
        $tmpInput= new Element("textarea");
        $tmpInput->setAttribute(["name"=>$name,
            "placeholder"=>$placeHolder]);


        $this->addInput($tmpInput,$index,$active);
    }
    public function addSubmit($text="Submit"){
        $tmpInput= new Element("input","","","","",false);
        $onClick=" this.name='btnSubmit'; this.disabled=true; this.value='Sending'; this.form.submit();";
        $tmpInput->setAttribute(["type"=>"submit",
            "onClick"=>$onClick,
            "value"=>$text]);
        $this->addInput($tmpInput);

    }
    public function addPassword($name="password", $index="", $placeHolder="", $active=true,$value=false){
        $tmpInput= new Element("input","","","","",false);
        $tmpInput->setAttribute(["name"=>$name,
            "type"=>"password",
            "placeholder"=>$placeHolder]);
        $this->addInput($tmpInput,$index,$active);
        if($value)
            $tmpInput->setAttribute("value",$placeHolder);
    }
    private function addInput(Element $input,$index="",$active=true){
        $tmpIndex=new Div("index");
        $tmpIndex->setText(strtoupper($index));

        $tmpDiv=new Div();
        if(strlen($index)>0)
            $tmpDiv->addSubElement($tmpIndex);
        if(!$active)
            $input->setAttribute("disabled","",true);
        $tmpDiv->addSubElement($input);
        $this->addSubElement($tmpDiv);
    }

    public function setAction($action="#"){
        $this->setAttribute("action",$action);
    }
    public function setMethod($method="post"){
        $this->setAttribute("method",$method);
    }
    public function setName($name){
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }
    public function setTitle($title){
        $tmpTitle = new Div("title");
        $tmpTitle->setText($title);
        $this->addSubElement($tmpTitle);
    }

}