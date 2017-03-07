<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 9/9/16
 * Time: 8:00 AM
 */

namespace scape\source\controller;

use SCAPE\source\Model\Model;

interface IController{
    public function setModel(Model $model);
    public function onLoad();
}