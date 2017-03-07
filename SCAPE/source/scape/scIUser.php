<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 8/8/16
 * Time: 8:27 AM
 */

namespace scape\source\scape ;


interface IUser{
    public function checkRegister($username):bool ;
    public function registerUser($username,$password):bool;
    public function verifyRegister($userid, $email, $key):bool;
    public function updatePassword($password):bool;
    public function createSession():bool ;
    public function createConnection():bool ;
    public function checkConnection():bool ;
    public function deleteSession():bool ;
    public function deleteConnection($connectionid=null):bool;
}