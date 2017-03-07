<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 9/8/16
 * Time: 8:59 AM
 */

namespace scape\source\scape;

use scape\source\model \AUser;


class User extends AUser implements IUser{
    /**
     * User constructor.
     * @param $userid
     */
    public function __construct($userid){
        parent::__construct($userid);
    }
    public function checkRegister($username):bool {
        $return=false;

        return $return;
    }
    public function registerUser($username,$password):bool{
        $return=false;
        return $return;
    }
    public function verifyRegister($userid, $email, $key):bool{
        $return=false;
        return $return;
    }
    public function updatePassword($password):bool{
        $return=false;
        return $return;
    }
    public function createSession():bool {
        $return=false;
        return $return;
    }
    public function createConnection():bool {
        $return=false;
        return $return;
    }
    public function checkConnection():bool {
        $return=false;
        return $return;
    }
    public function deleteSession():bool {
        $return=false;
        return $return;
    }
    public function deleteConnection($connectionid=0):bool{
        $return=false;
        return $return;
    }
}