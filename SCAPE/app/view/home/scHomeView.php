<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 27/2/17
 * Time: 5:53 PM
 */

namespace SCAPE\app\view\home;

use scape\source\element\Element;
use scape\source\view\View;

class HomeView extends View {

    public function onLoad(){
        $this->entity("welcome",new Element("div","","","","",true,"<h1>Scape! A Framework for PHP Artisan </h1>"));
    }
    public function populate(){
        $this->template->addSectionChild("content",$this->getEntity("welcome"));
    }
}