<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 1/3/17
 * Time: 8:09 AM
 */

namespace SCAPE\source\view;


use SCAPE\source\Model\DataModel;
use scape\source\template\Template;

interface  IView{
    public function render(DataModel $data);
    public function onLoad();
    public function loadTemplate(Template $template);
    public function populate();
}