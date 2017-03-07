<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 18/8/16
 * Time: 12:00 PM
 */

namespace scape\source\scape;
use scape\source\element\Element;

include_once("../../scInit.php");

class FileHandler
{
    protected $fileList;
    private static $instance;

    private function __construct()
    {
        $this->fileList= array();
    }
    public static function getInstance()
    {
        if (self::$instance ===NULL)
            self::$instance = new FileHandler();
        return self::$instance;
    }

    public function addJavaScriptPath($path)
    {
        if(is_array($path)){
            foreach($path as $url)
                $this->addJavaScriptPath($url);
        }
        else{
            // file_exists not checked as file can be from remote server
            $script= new Element("script");
            //$script->setAttribute("type","text/javascript");
            $script->setAttribute("src",absoluteString($path));
            $this->addToList($script);
        }
    }

    public function addCssPath($path)
    {
        if(is_array($path)) {
            foreach ($path as $url)
                $this->addCssPath($url);
        }
        else{
            $link=new Element("link","","","","",false);
            $link->setAttribute("rel","stylesheet");
            //$link->setAttribute("type","text/css");
            $link->setAttribute("href",absoluteString($path));
            $this->addToList($link);
        }
    }

    public function addToList(Element $link)
    {
        $this->fileList[]=$link;
    }

    public function getFilesTag()
    {
        return $this->fileList;
    }

}