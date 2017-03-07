<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 20/8/16
 * Time: 8:33 AM
 */

namespace scape\source\scape;

include_once("../../scInit.php");

use scape\source\scape\DatabaseSchema;
use scape\source\scape\DBTable;
use scape\source\registry\DBCon;


class DatabaseHandler{
    use DatabaseSchema;
    use DatabaseTables;
    private static $instance;



    private function __construct(){
        $this->schemaTables= array();
        $this->databaseTables=array();
        $this->tablesLoaded= false;
        $this->prepareSchema();
        $this->loadTables();
    }
    public static function getInstance(){
        if (self::$instance ===NULL)
            self::$instance = new DatabaseHandler();
        return self::$instance;
    }

    /**
     * @param DBTable $table
     */
    public function addDBTable(DBTable $table){
        $this->databaseTables[$table->getName()]= $table;
    }
    /**
     * @param $tableName
     * @return DBTable
     */
    public function getDBTable($tableName):DBTable{
        return $this->databaseTables[$tableName];
    }
    public function loadTables(){
        $dbDriver = DBCon::getInstance();
        if ($dbDriver->checkTableExist("schema_table")) {

            $schemaTable = $this->getSchemaTable("schema_table");
            $result = $schemaTable->searchAll();
            foreach ($result as $key => $item) {
                $tmpDBtable = new DBTable($item['tname']);
                $this->addDBTable($tmpDBtable);
            }
            $this->tablesLoaded = true;
        }
    }
    public function reload(){
        $this->schemaTables= null;
        $this->databaseTables=null;
        $this->tablesLoaded= false;
        $this->prepareSchema();
        $this->loadTables();
    }


    /*
     *
     public function __get($name):DBTable{
        return $this->getDBTable($name);
    }
    public function __set($name,DBTable $value){
        $this->addDBTable($value);
    }
    */
}

?>