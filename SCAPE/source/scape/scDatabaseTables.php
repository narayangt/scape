<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 17/9/16
 * Time: 8:31 AM
 */

namespace scape\source\scape;

use scape\source\scape\DBTable;

trait DatabaseTables{
    protected $databaseTables;
    protected $tablesLoaded;

    public function addDBTable(DBTable $table){
        $this->databaseTables[$table->getName()]=$table;
    }

    /**
     * @param string $name
     * @return DBTable|bool
     */
    public function getDBTable($name):DBTable{
        return $this->databaseTables[$name];
    }
    public function getTableNames():array {
        $return=[];
        foreach ($this->databaseTables as $tname=>$table)
            $return[]=$tname;
        return $return;
    }

    public function createTables($tname = ""){
        $return= true;
        if(strlen($tname)==0){
            foreach ($this->databaseTables as $table) {
                if(!$table->runQuery($table->queryCreate()));{
                    echo $table->queryCreate();
                    $return = false;
                }
            }
        }
        else if(isset($this->databaseTables[$tname])){
            if(!$this->databaseTables[$tname]->runQuery($this->databaseTables[$tname]->queryCreate()));{
                echo $this->databaseTables[$tname]->queryCreate();
                $return = false;
            }
        }
        return $return;
    }

}

