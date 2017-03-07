<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 21/7/16
 * Time: 9:40 AM
 *
 */

namespace scape\source\scape;

include_once("../../scInit.php");

use scape\source\registry\DBCon;
use scape\source\scape\TableField;

class DBTable extends ATable implements ITable{


    protected $con;
    protected $references;
    protected $properties;
    public    $primeryKey;
    protected $uniqueKey;

    /**
     * DBTable constructor.
     * @param $tableName
     * @var \PDO $this->con
     */
    public function __construct($tableName)
    {
        parent::__construct($tableName);
        $this->con=DBCon::getInstance()->getConnection();
        $this->references   =   array();
        $this->properties   =   array();
        $this->primeryKey   =   array();
        $this->uniqueKey    =   array();

        $this->addProperties("ENGINE","InnoDB DEFAULT");
        $this->addProperties("CHARSET","latin1");
        $this->addProperties("AUTO_INCREMENT","1000000000001");
    }

    /**
     * @var \PDO $this->con
     * @var \PDOStatement $statement
     * @param string|array $query
     * @return bool|null|\PDOStatement
     *
     * $query has to be either string or array
     * if array, has to follow following format
     *   $query= [
     *              "query" = String,
     *              "param" = array[],
     *              "parameter" = String: positioned | named
     *      ]
     * $query['param'] should have following format according to
     * $query['paramater'] value
     * if positioned,
     * $query['param'] = ["value1", "value2" ...]
     *
     * if named
     * $query['param'] = [":k1"=>"value1",
     *                    ":k2"=>"value2" ...]
     */
    public function runQuery($query){
        //echo"Run query started".PHP_EOL;
        //var_dump($query);
        /** @var \PDOStatement $statement
         */
        $result=NULL;

        $statement=$this->con->prepare(is_array($query)? $query['query']: $query);
        /*
        if(is_array($query)){
            $statement = $this->con->prepare($query['query']);
            switch ($query["parameter"]){
                case "named":
                    foreach ($query["param"] as $key=>$param){
                        $statement->bindParam($key,$param);
                    }
                    break;
                case "positioned":
                default:
                    foreach ($query['param'] as $k=>$val){
                        $statement->bindParam($k+1,$val);
                    }
                    break;
            }
        }
        else{
            $statement=$this->con->prepare($query);
        }
        */
        try
        {
            $statement->execute(is_array($query)?$query['param']:null);
            return $statement;
        }
        catch (\Exception $e)
        {
            if($e->errorInfo[1]==1062)
                echo PHP_EOL."Duplicate Entry. Check your unique Entry such as username, ID etc.".PHP_EOL;
            else if ($e->errorInfo[1]==1146)
                echo PHP_EOL."Table ".$this->getName()." Not Found".PHP_EOL;
            else
                echo $e->getCode().": ".$e->getMessage();
            return false;
        }
    }
    /**
     * @var string $name
     * @var TableField $field
     * @return string
     */
    public function queryCreate(){
        $query='CREATE TABLE IF NOT EXISTS '.$this->getName().' (';
        $count=0;
        foreach ($this->fields as $name=> $field){
            if($count>0)
                $query.=' , ';
            $query.=$name;
            foreach($field->getProperties() as $property)
                $query.=' '.$property;
            $count++;
        }
        foreach ($this->uniqueKey as $key=>$value)
            $query.= ' , UNIQUE KEY ('.$value.') ';
        if(count($this->primeryKey)>0){
            $count=0;
            $query.=' , PRIMARY KEY (';
            foreach ($this->primeryKey as $key) {
                if($count>0)
                    $query.='+';
                $query.=$key;
            } $query.=')';
        }
        foreach ($this->references as $fieldName=> $arr)
            $query.=', FOREIGN KEY ('.$fieldName.') REFERENCES '.$arr['destTableName'].'('.$arr['destField'].') 
                        ON DELETE RESTRICT ON UPDATE RESTRICT ';
        $query.=')';
        foreach ($this->properties as $key=>$value)
            $query.=' '.$key.'='.$value.' ';
        $query.=';';
        return $query;
    }
    public function queryDrop():string {
        return 'DROP TABLE '.$this->getName().' ;';
    }
    public function queryTurncate():string {
        return 'TURNCATE TABLE '.$this->getName().' ;';
    }

    /**
     * @param string|array $search
     * @param bool $custom
     * @return bool|array;
     * if $search is string and custom is true use custom query
     */
    public function search($search=null,$custom=false)
    {
        $return = false;
        $values = null;
        $query = array();
        $tmpQ = "SELECT * FROM " . $this->getName() . " WHERE ";
        if (is_array($search)) { // use other values so do not use primery key
            $count = 0;
            foreach ($search as $key => $value) {
                if ($count > 0)
                    $tmpQ .= " AND ";
                $tmpQ .= $key . " = ? ";
                $values[$count] = $value;
                $count++;
            }
            $query = [
                "query" => $tmpQ,
                "param" => $values,
                "parameter" => "positioned"
            ];
        } else { // use primery key as only one value is presented
            if ($custom) {
                $query = $search;
            } else {
                $tmpQ .= $this->getPrimeryKey() . " = ?";
                $query = [
                    "query" => $tmpQ,
                    "param" => [$search],
                    "parameter" => "positioned"
                ];
            }
        }
        $result = $this->runQuery($query);
        /** @var TableField $field */
        $newRet=[];
        $arr=$result->fetchAll();
        foreach($this->fields as $field){
            $field->setValue($arr[0][$field->getName()]);
        }
        foreach ($arr as $item) {
            $tmpArr=null;
            foreach ($this->fields as $field)
                $tmpArr[$field->getName()]=$item[$field->getName()];
            $newRet[]=$tmpArr;
        }
        return $newRet;
    }

    /**
     * @param bool $indexPrimeryKey
     * @return array
     */
    public function searchAll($indexPrimeryKey=true):array {
        $return=[];
        $tmpQ = "SELECT * FROM " . $this->getName();
        $result=$this->runQuery($tmpQ);
        foreach($result->fetchAll() as $rows) {
            $key='';
            if($indexPrimeryKey)
                $key=$rows[$this->getPrimeryKey()];
            $tmpArr=null;
            /** @var TableField $field */
            foreach ($this->fields as $field)
                $tmpArr[$field->getName()]=$rows[$field->getName()];
            $return[$key]=$tmpArr;
        }
        return $return;
    }

    public function insert($primeryKey=false){
        $query='INSERT INTO '.$this->getName().' (';
        $count=0;
        $values=[];
        $search=[];
        /** @var TYPE_NAME $this
         * @var TableField $field
         */
        foreach ($this->fields as $name=> $field) {
            if($primeryKey || !in_array($name, $this->primeryKey)){
                if ($count > 0)
                    $query .= ', ';
                $query .= $name;
                $count++;
                $values[]=$field->getValue();
                $search[$name]=$field->getValue();
                //$values[':'.$name] = $field->getValue();
            }
        }
        $query.=') VALUES(';
        foreach(range(0,count($values)-1) as $count){
            if($count>0)
                $query.=', ';
            $query.='?';
        }
        $query.=')';

        $arr=[  "query"=>$query,
                "param"=>$values,
                "parameter"=>"positioned"];
        //var_dump($arr);
        if($this->runQuery($arr))
            return $this->search($search);
        return false;
    }
    public function insertUnique(){
    }
    public function update():string {

    }
    public function scan(){

    }
    /**
     * @param TableField $field
     * @param DBTable $destTable
     * @param TableField $destField
     */
    function addReference(TableField $field, DBTable $destTable, TableField $destField){
        if($destTable->ifFieldExist($destField->getName()))
            $this->references[$field->getName()]=   ["destTableName" => $destTable->getName(),
                                                     "destField" => $destField->getName()];
    }

    /**
     * @param $key
     * @param $value
     */
    public function addProperties($key, $value){
        $this->properties[$key]=$value;
    }

    public function addUniqueKey($key,$dataType="varchar(50)"){
        $this->addKey($key,$dataType);
        $this->uniqueKey[]=$key;
    }
    public function addPrimeryKey($key,$dataType="bigint(20)"){
        $this->addKey($key,$dataType);
        $this->addFieldProperties($key,"AUTO_INCREMENT");
        $this->primeryKey[]=$key;
    }

    public function getPrimeryKey(){
        return implode(",",$this->primeryKey);
    }
    public function __get($name){
        $this->getFieldValue($name);
    }
    public function __set($name, $value){
        $this->getField($name)->setValue($value);
    }
}

/**
$test=new DBTable("test");
$test->addField("id");
$test->addField("chat");
$test->addField("name");

$test->addPrimeryKey("id");
$test->addKey("chat",DBSets::varchar_50);
$test->addKey("name",DBSets::varchar_250);
echo "queryCreate: ".$test->queryCreate().PHP_EOL;
echo "queryDrop: ".$test->queryDrop().PHP_EOL;
echo "queryTurncate: ".$test->queryTurncate().PHP_EOL;
echo "queryInsert: ".$test->insert()["query"].PHP_EOL;
var_dump($test->insert());
 * */
