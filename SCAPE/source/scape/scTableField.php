<?php

/**
* Created by PhpStorm.
* User: narayanbhandari
* Date: 19/7/16
* Time: 10:51 PM
*/
namespace scape\source\scape;

class TableField{
    private $name;
    private $value;

    private $properties;

    private $required;
    private $displayToUser;

    public function __construct($name,$default="",$required=true,$displayToUser=true){
        $this->setName($name);
        $this->setValue($default);
        $this->setRequired($required);
        $this->setDisplayToUser($displayToUser);
        $this->properties=array();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value="")
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getRequired():bool
    {
        return $this->required;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required=false)
    {
        $this->required = $required? true: false;
    }

    /**
     * @return mixed
     */
    public function getDisplayToUser():bool
    {
        return $this->displayToUser;
    }

    /**
     * @param mixed $displayToUser
     */
    public function setDisplayToUser($displayToUser=false)
    {
        $this->displayToUser = $displayToUser? true: false;
    }
    public function addProperties($value){
        $this->properties[]=$value;
    }

    /**
     * @return mixed
     * @param $key
     */
    public function getProperties($key=null){
        return isset($key) ? $this->properties[$key]: $this->properties;
    }
}

?>