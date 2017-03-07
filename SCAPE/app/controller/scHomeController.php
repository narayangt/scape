<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 27/2/17
 * Time: 5:35 PM
 */

namespace SCAPE\app\controller;

use SCAPE\app\model\HomeModel;
use scape\source\controller\BaseController;

class HomeController extends BaseController{
    public function __construct(){
        parent::__construct(new HomeModel());
    }
    public function onLoad(){

    }
    /*
    public function onRender(){
    }
    */
}