<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 22/7/16
 * Time: 10:03 AM
 *
 * interface for ini, csv, pdf files to read, change, save
 */

namespace scape\source\registry ;


interface IFileProcessor{
    public function setFileName($fileName);
    public function loadFile();
    public function setContent($section,$key,$value);
    public function getContent($section,$key);
    public function saveFile();
}