<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 22/7/16
 * Time: 9:38 AM
 */
namespace scape\source\registry;
use scape\source\registry\AFileProcessor;
use scape\source\registry \IFileProcessor;

class IniProcessor extends AFileProcessor implements IFileProcessor{
    public function __construct($fileName)
    {
        parent::__construct($fileName.'.php');
    }
    public function loadFile(){
        if(file_exists($this->getFileName())){
            $this->fileContent=parse_ini_file($this->getFileName(),true,INI_SCANNER_TYPED);
        }
    }
    public function saveFile(){
        $strFileContent=';<?php'.PHP_EOL;
        $strFileContent.=';die()'.PHP_EOL;
        $strFileContent.=';/*############# '.$this->getFileName().' ###############'. PHP_EOL.
                            $this->array2ini($this->fileContent). PHP_EOL.
                        '; end of config */'. PHP_EOL;
        file_put_contents($this->getFileName(), $strFileContent );
    }
    private function array2ini(array $array):string{
        $tmpContent='';
        foreach ($array as $section => $value) {
            if (is_array($value)) {
                $tmpContent.='['.$section.']'. PHP_EOL;
                $tmpContent.=$this->array2ini($value);
            }
            else {
                $tmpContent.= $section.'='.$value. PHP_EOL;
            }
        }
        return $tmpContent;
    }
}