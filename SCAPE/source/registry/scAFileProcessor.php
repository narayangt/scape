<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 22/7/16
 * Time: 10:21 AM
 */

namespace scape\source\registry;



abstract class AFileProcessor{
    protected   $fileName;
    protected   $fileContent;

    /**
     * AFileProcessor constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        $this->setFileName($fileName);
        $this->fileContent = array();

    }

    /**
     * @return mixed
     */
    public function getFileName(){
        return $this->fileName;
    }

    /**
     * @param mixed $FileName
     */
    public function setFileName($FileName)
    {
        $this->fileName = $FileName;
    }


    public function setContent($section,$key,$value){
        $this->fileContent[$section][$key]=$value;
    }
    public function getContent($section,$key){
        return $this->fileContent[$section][$key];
    }
    public function getSectionContent($section):array {
        return $this->fileContent[$section];
    }
    public function getContentValue($key){
        return array_filter($this->fileContent,function ($sectionArr) use ($key){return $sectionArr[$key]?? null;});
    }
}