<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 8/8/16
 * Time: 7:59 AM
 */

namespace scape\source\scape;


abstract class AUser{
    protected $userid;
    protected $role;
    protected $fullName;
    protected $description;
    protected $profilePictureName;
    public function __construct($userid){
        $this->setUserid($userid);
        $this->fullName=array();
        $this->loadUser();
    }
    public function loadUser(){

    }


    /**
     * @return mixed
     */
    public function getUserid(){
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid){
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role="guest"){
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getFullName(){
        return implode(" ",$this->fullName);
    }

    /**
     * @param string|array $name
     * @param string $mname
     * @param string $lname
     * @param string $title
     */
    public function setFullName($name, $mname="", $lname="", $title=""){
        if(is_array($name)) {
            $this->fullName['title']=$name['title'];
            $this->fullName['fname']=$name['fname'];
            $this->fullName['mname']=$name['mname'];
            $this->fullName['lname']=$name['lname'];
        }
        else{
            $this->setFullName(["title"=>$title, "fname"=>$name, "mname"=>$mname, "lname"=>$lname]);
        }
    }


    /**
     * @return mixed
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description="Clean World"){
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getProfilePictureName(){
        return $this->profilePictureName;
    }

    /**
     * @param mixed $profilePictureName
     */
    public function setProfilePictureName($profilePictureName){
        $this->profilePictureName = $profilePictureName;
    }

}