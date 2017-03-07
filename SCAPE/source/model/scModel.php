<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 1/3/17
 * Time: 6:29 PM
 */

namespace SCAPE\source\model;


abstract class Model{
    protected $data;
    public function __construct(){
        $this->data= new DataModel();
    }
    public function getDataModel():DataModel{
        return $this->data;
    }
}