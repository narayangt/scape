<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 22/7/16
 * Time: 10:26 AM
 */

namespace scape\source\registry ;
use scape\source\registry\IniProcessor;
use scape\source\registry\AFileProcessor;


class FileProcessor{
    private $fp;

    public function __construct($fileName){
        switch (pathinfo($fileName,PATHINFO_EXTENSION)) {
            case "ini":
            case "INI":
                $this->fp = new IniProcessor($fileName);
        }
    }
    public function getFileProcessor(){
        return $this->fp;
    }
}
