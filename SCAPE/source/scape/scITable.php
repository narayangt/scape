<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 19/7/16
 * Time: 10:51 PM
 */

namespace scape\source\scape;

interface ITable{

    public function addField($name,$default,$required=false,$display=false);
    public function runQuery($query);
    public function queryCreate();
    public function queryDrop();
    public function queryTurncate();
    public function search($search);
    public function insert();
    public function update();
    public function scan();
}


?>