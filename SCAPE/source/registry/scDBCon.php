<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 19/7/16
 * Time: 10:41 PM
 */

namespace scape\source\registry;

include_once("../../scInit.php");


use scape\source\registry \FileProcessor;
use scape\source\registry\AFileProcessor;


final class DBCon
{

    private static $instance;
    /**
     * @var $fp AFileProcessor
     */
    private $fp;

    private $fileName;

    private function __construct($configFileName="db_config.ini")
    {
        $this->setFileName(SC_ROOT."source/registry/".$configFileName);
        $tmpFp=new FileProcessor($this->getFileName());
        $this->fp=$tmpFp->getFileProcessor();
        $this->loadConfig();
    }

    /**
     * @return DBCon
     */
    public static function getInstance()
    {
        if (self::$instance ===NULL)
            self::$instance = new DBCon();
        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        $connection=NULL;

        $dsn =$this->getDriver().':host='.$this->getHost().';dbname='.$this->getDbName().';charset=utf8';

        //echo "dsn:".$dsn.PHP_EOL;
        try
        {
            $connection =new \PDO($dsn, $this->getUsername(), $this->getPassword() , array(\PDO::ATTR_PERSISTENT => true));

            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //echo 'connected to database'.PHP_EOL;
            return $connection;
        }
        catch(\PDOException $e)
        {
            echo $e->getmessage();
            die();
        }
    }
    public function createConfig(){
        $this->setUsername();
        $this->setPassword();
        $this->setDbName();
        $this->setDriver();
        $this->setHost();
        $this->setPort();
        $this->setOptions("PDO::MYSQL_ATTR_INIT_COMMAND","set names utf8");
        $this->setAttributes("PDO::ATTR_ERRMODE","PDO::ERRMODE_EXCEPTION");
        $this->fp->saveFile();
    }

    public function loadConfig(){
        $this->fp->loadFile();
    }


    /**
     * @return mixed
     */
    public function getFileName(){
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName){
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->fp->getContent("db","username");
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username="planeton_narayan")
    {
        $this->fp->setContent("db","username",$username);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->fp->getContent("db","password");
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password="Narayan123")
    {
        $this->fp->setContent("db","password",$password);
    }
    /**
     * @return mixed
     */
    public function getDbName(){
        return $this->fp->getContent("db","dbname");
    }

    /**
     * @param mixed $dbName
     */
    public function setDbName($dbName="planeton_scape"){
        $this->fp->setContent("db","dbname",$dbName);
    }
    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->fp->getContent("dsn","driver");
    }

    /**
     * @param mixed $driver
     */
    public function setDriver($driver="mysql")
    {
        $this->fp->setContent("dsn","driver",$driver);
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->fp->getContent("dsn","host");
    }

    /**
     * @param mixed $host
     */
    public function setHost($host="localhost")
    {
        $this->fp->setContent("dsn","host",$host);
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->fp->getContent("dsn","port");
    }

    /**
     * @param mixed $port
     */
    public function setPort($port=3306)
    {
        $this->fp->setContent("dsn","port",$port);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function getOptions($key=null)
    {
        return isset($key)? $this->fp->getContent("db_options",$key):
            $this->fp->getSectionContent("db_options");
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setOptions($key,$value)
    {
        $this->fp->setContent("db_options",$key,$value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getAttributes($key=null)
    {
        return isset($key)?  $this->fp->getContent("db_attributes",$key):
            $this->fp->getSectionContent("db_attributes");
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setAttributes($key,$value){
        $this->fp->setContent("db_attributes",$key,$value);
    }
    public function checkDbExist(){
        return $this->runQuery('SHOW DATABASES LIKE "'.$this->getDbName().'"');
    }
    public function checkTableExist($table){
        $connection=$this->getConnection();
        $result=$connection->query('SHOW TABLES LIKE "'.$table.'"');
        if($result->rowCount()>0)
            return true;
        return false;
    }
    private function runQuery($query=""):bool{
        $dsn =$this->getDriver().':host='.$this->getHost();
        $connection =new \PDO($dsn, $this->getUsername(), $this->getPassword() , array(\PDO::ATTR_PERSISTENT => true));
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $result=$connection->query($query);
        if($result->rowCount()>0)
            return true;
        return false;
    }
}
?>