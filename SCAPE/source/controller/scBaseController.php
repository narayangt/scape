<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 9/9/16
 * Time: 8:02 AM
 */

namespace scape\source\controller;

use SCAPE\source\Model\DataModel;
use SCAPE\source\Model\Model;


abstract class BaseController extends AController implements IController {
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model){
        parent::__construct();
        $this->setModel($model);
        $this->onLoad();
    }
    public function setModel(Model $model){
        $this->model=$model;
    }
    protected function getModel():Model{
        return $this->model;
    }
    public function getDataModel():DataModel{
        return $this->getModel()->getDataModel();
    }
}