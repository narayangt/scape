<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 6/3/17
 * Time: 7:03 PM
 */

namespace SCAPE\app\controller;


use SCAPE\app\model\ErrorModel;
use scape\source\controller\BaseController;

class ErrorController extends BaseController {
    public function __construct()
    {
        parent::__construct(new ErrorModel());
    }
    public function onLoad()
    {
        // TODO: Implement onLoad() method.
    }
    public function error404(){
        $this->model->error(404);
    }
    public function error500(){
        $this->model->error(500);
    }

}