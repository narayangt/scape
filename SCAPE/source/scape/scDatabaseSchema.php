<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 23/8/16
 * Time: 8:32 AM
 */
namespace scape\source\scape;


use scape\source\scape\TableField;
use scape\source\scape\DBTable;

trait DatabaseSchema{

    protected $arrSchema;   // array that holds schema for framework

    protected $schemaTables;// array of schema tables

    protected function prepareSchema()
    {
        $this->arrSchema = [
            "schema_table" => [
                new TableField("tableid", "", false, true),         // TableID
                new TableField("tname", "tname"),                   // Tablename
                new TableField("description"),                      // Table description
                new TableField("insert_unique"),                    // ?
                new TableField("populated"),                        // Is table is already populated
                new TableField("date_created", getTimestamp()),     // Date the information is created
            ],
            "schema_field" => [
                new TableField("fieldid", "", false, true),         // ID for field name
                new TableField("fname"),                            // FieldName
                new TableField("tableid"),                          // Reference table ID
                new TableField("description"),                      // Field description
                new TableField("defaultval"),                          // default value
                new TableField("required"),                         // required on scan
                new TableField("displayToUser")                     // display to user while showing record
            ],
            "schema_field_property" => [
                new TableField("propertyid", "", false, true),      // ID for field property
                new TableField("fieldid"),                          // reference field id
                new TableField("value")                             // property
            ],
            "schema_reference"=>[
                new TableField("referenceid","",false),             // Reference id
                new TableField("source_tableid"),                   // Source table id
                new TableField("source_fieldid"),                   // Source field ID
                new TableField("dest_tableid"),                     // Destination table ID
                new TableField("dest_fieldid")                      // Destination Field ID
            ],
            "schema_value" => [
                new TableField("global_valueid", "", false, true),  // Global value id
                new TableField("name"),                             // Global name
                new TableField("value"),                            // Global Value
                new TableField("description"),                      // Description
                new TableField("state")                             // active/ de-active
            ]
        ];
        //$this->con->createConfig();
        foreach ($this->arrSchema as $tname=>$fields){
            $tmpTable= new DBTable($tname);
            foreach ($fields as $field){
                $tmpTable->addTableField($field);
            }
            $this->addSchemaTable($tmpTable);
        }
        $this->getSchemaTable("schema_table")->addPrimeryKey("tableid");
        $this->getSchemaTable("schema_table")->addUniqueKey("tname","varchar(50)");
        $this->getSchemaTable("schema_table")->addKey("description","varchar(250)");
        $this->getSchemaTable("schema_table")->addKey("insert_unique","int(1)");
        $this->getSchemaTable("schema_table")->addKey("populated","int(1)");
        $this->getSchemaTable("schema_table")->addKey("date_created","int(12)");

        $this->getSchemaTable("schema_field")->addPrimeryKey("fieldid");
        $this->getSchemaTable("schema_field")->addKey("fname","varchar(20)");
        $this->getSchemaTable("schema_field")->addKey("tableid","bigint(20)");
        $this->getSchemaTable("schema_field")->addKey("description","varchar(250)");
        $this->getSchemaTable("schema_field")->addKey("defaultval","varchar(50)");
        $this->getSchemaTable("schema_field")->addKey("required","varchar(5)");
        $this->getSchemaTable("schema_field")->addKey("displayToUser","varchar(5)");
        $this->getSchemaTable("schema_field")->addReference($this->getSchemaTable("schema_field")->getField("tableid"),
                    $this->getSchemaTable("schema_table"),$this->getSchemaTable("schema_table")->getField("tableid"));

        $this->getSchemaTable("schema_field_property")->addPrimeryKey("propertyid");
        $this->getSchemaTable("schema_field_property")->addKey("fieldid","bigint(20)");
        $this->getSchemaTable("schema_field_property")->addKey("value","varchar(50)");
        $this->getSchemaTable("schema_field_property")->addReference($this->getSchemaTable("schema_field_property")->getField("fieldid"),
                    $this->getSchemaTable("schema_field"),$this->getSchemaTable("schema_field")->getField("fieldid"));

        $this->getSchemaTable("schema_reference")->addPrimeryKey("referenceid");
        $this->getSchemaTable("schema_reference")->addKey("source_tableid","bigint(20)");
        $this->getSchemaTable("schema_reference")->addKey("source_fieldid","bigint(20)");
        $this->getSchemaTable("schema_reference")->addKey("dest_tableid","bigint(20)");
        $this->getSchemaTable("schema_reference")->addKey("dest_fieldid","bigint(20)");
        $this->getSchemaTable("schema_reference")->addReference($this->getSchemaTable("schema_reference")->getField("source_tableid"),
            $this->getSchemaTable("schema_table"),$this->getSchemaTable("schema_table")->getField("tableid"));
        $this->getSchemaTable("schema_reference")->addReference($this->getSchemaTable("schema_reference")->getField("source_fieldid"),
            $this->getSchemaTable("schema_field"),$this->getSchemaTable("schema_field")->getField("fieldid"));
        $this->getSchemaTable("schema_reference")->addReference($this->getSchemaTable("schema_reference")->getField("dest_tableid"),
            $this->getSchemaTable("schema_table"),$this->getSchemaTable("schema_table")->getField("tableid"));
        $this->getSchemaTable("schema_reference")->addReference($this->getSchemaTable("schema_reference")->getField("dest_fieldid"),
            $this->getSchemaTable("schema_field"),$this->getSchemaTable("schema_field")->getField("fieldid"));


        $this->getSchemaTable("schema_value")->addPrimeryKey("global_valueid");
        $this->getSchemaTable("schema_value")->addKey("name","varchar(50)");
        $this->getSchemaTable("schema_value")->addKey("value","varchar(250)");
        $this->getSchemaTable("schema_value")->addKey("description","varchar(250)");
        $this->getSchemaTable("schema_value")->addKey("state","TINYINT(1)");
    }

    private function addSchemaTable(DBTable $table){
        $this->schemaTables[$table->getName()]= $table;
    }
    /**
     * @param $tableName
     * @return DBTable
     */
    public function getSchemaTable($tableName):DBTable{
        return $this->schemaTables[$tableName];
    }

    /**
     * @return bool
     */

    public function createSchema(){
        echo'create schema called, ';
        $return=true;
        /** @var DBTable $table */
        echo
            count($this->schemaTables).' tables found';
        foreach($this->schemaTables as $tname=> $table){
            if($result=$table->runQuery($table->queryCreate())) {
                echo $tname. ' Created'.NL;
            }
            else {
                $return=false;
                echo 'Could not create schema table ' . $tname . NL;
            }

        }
        return $return;
    }
    public function destroySchema(){
        $return=true;
        /** @var DBTable $table */
        echo count($this->schemaTables).' tables to destroy'.NL;
        foreach(array_reverse($this->schemaTables) as $tname=> $table){
            if($result=$table->runQuery($table->queryDrop())) {
                echo $tname. ' Destroyed'.NL;
            }
            else {
                $return=false;
                echo 'Could not destroy schema table ' . $tname . NL;
            }
        }
        return $return;
    }
}