<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 29/12/16
 * Time: 9:24 PM
 */

namespace scape\source\view;


use scape\source\element\Element;
use scape\source\template\Template;
use SCAPE\source\Model\DataModel;

abstract class View extends AView implements IView {
    /**
     * @var Template $templa
     */
    protected $template;
    public function __construct(){
        parent::__construct();
        $this->loadTemplate(new Template());
        $this->onLoad();
    }
    public function render(DataModel $data){
        /** @var Element $item */
        foreach ($this->entity as $key=>$item){
            if(strlen($data->$key)>0)
                $item->setText($data->$key);
        }
        $this->populate();
        $docType="<!DOCTYPE html>";
        $html= new Element("html");
        $html->setAttribute("lang","en-us");
        $html->addSubElement($this->template->getHead());
        $html->addSubElement($this->template->getBody());
        return $docType.PHP_EOL.$html->getHtml();
    }
    public function loadTemplate(Template $template)
    {
        $this->template=$template;
    }
    public function addContent($content,Element $element){
        $this->template->addSectionChild($content,$element);
    }
}