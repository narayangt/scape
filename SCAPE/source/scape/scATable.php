<?php

/**
* Created by PhpStorm.
* User: narayanbhandari
* Date: 19/7/16
* Time: 10:51 PM
*/
namespace scape\source\scape;
use scape\source\scape\TableField;

abstract class ATable{

    protected $name;
    protected $fields;


    /**
     * ATable constructor.
     * @param $tableName
     */

    public function __construct($tableName){
        $this->setName($tableName);
        $this->fields       =   array();


    }

    public function addField($name,$default="",$required=true,$display=true){
        $this->addTableField(new TableField($name,$default,$required,$display));
    }
    public function addTableField(TableField $field){
        $this->fields[$field->getName()]=$field;
    }


    /**
     * @return mixed
     */
    public function getName():string{
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    // check if field in record is already exist
    public function ifFieldExist($fieldName):bool{
        return array_key_exists($fieldName,$this->fields)? true: false;
    }

    /**
     * @param $fieldName
     * @return TableField|null
     */
    public function getField($fieldName){    // return type hiniting : TableField not use as sometimes value could null.
                                                //  but implement in PHP 7.1. as :?TableField
        return ($this->ifFieldExist($fieldName))? $this->fields[$fieldName]: null;
    }

    /**
     * @param string $key
     * @param array|string $properties
     */
    protected function addFieldProperties($key, $properties){
        if(is_array($properties)){
            foreach ($properties as $property) {
                $this->getField($key)->addProperties($property);
            }
        }
        else
            $this->getField($key)->addProperties($properties);
    }

    /**
     * @param $key
     * @param $dataType
     */
    private function addNullKey($key, $dataType){
        $this->addFieldProperties($key,[$dataType,"NULL"]);
    }

    /**
     * @param $key
     * @param $dataType
     */
    private function addNotNullKey($key, $dataType){
        $this->addFieldProperties($key,[$dataType,"NOT NULL"]);
    }

    /**
     * @param string $key
     * @param string $dataType
     * @param bool $notNull
     */
    public function addKey($key, $dataType, $notNull=true){
        return $notNull? $this->addNotNullKey($key,$dataType):$this->addNullKey($key,$dataType);
    }
    public function getFieldValue($fieldName){
        return $this->getField($fieldName)->getValue();
    }
}

?>