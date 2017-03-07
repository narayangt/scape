<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 6/3/17
 * Time: 7:03 PM
 */

namespace SCAPE\app\model;


use SCAPE\source\model\Model;

class ErrorModel extends Model
{
    public function error($code){
        $this->data->errorCode=$code. "&#9760;";
        switch ($code){
            case 404:
                $this->data->errorDesc="Content Not Found";
                $this->data->errorMsg="<h4>A long time ago, in a galaxy far, far away ....</h4>".NL.NL.
                    "It appears you are looking for something which isn’t there.".NL.
                    "Either you have entered an incorrect URL or we have messed up.";
                break;
            case 500:
                $this->data->errorDesc="Server in trouble";
                $this->data->errorMsg="Do not panic. It's not your fault.".NL."Our monkey team are scratching balls to fix it";
                break;
        }
    }
}