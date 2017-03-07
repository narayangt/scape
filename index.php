<?php
/**
 * Created by PhpStorm.
 * User: narayanbhandari
 * Date: 8/2/17
 * Time: 5:08 PM
 */

include_once("SCAPE/scInit.php");

use SCAPE\source\scape\Route;

$controller =request("controller","get","home");        // module ie: HomeController name
$view       =request("view","get",$controller);         // view name to render output
$action     =request("action","get");                   // action to call on controller otherwise nothing will called

$run= new Route($controller,$view);
//if(strlen($action)>0)
    $run->call($action);
$run->render();


































/*

$template= new Template();
$view= new View();
$template->setPageView(false,false,false,false,false,false,false,true);
$page= PageController::getInstance($view,$template);


$formRegister= new Form("register","Becoming member is easy","processRegister.php");
$formLogin  =  new Form("login","Do you have an account?","processLogin.php","","login","","",null,[
    "border-radius"=>"15px",
    "border"=>"1px solid skyblue",
    "width"=>"600px",
    "margin"=>"80px 20px",

]);

$formRegister->addText("email","Email Address","Enter Your Email");
$formRegister->addPassword("password","Password","Choose Your Password");
$formRegister->addText("fullname","Name","Enter Your Full Name");
$formRegister->addSubmit("Register");

$formLogin->addText("username","Username","Enter Your Username");
$formLogin->addPassword("password","Password","Your Password");
$formLogin->addSubElement(new Alert("Do not have an account",new ALink("Click here to create an account","#registerBox"),"Lavender","","alert-registerlink","",[
    "margin-top"=>"10px",
    "padding"=>"10px",
    "border"=>"1px solid skyblue"]));
//$formLogin->addSubElement(new ALink("Click here to create account","#registerBox"));
$formLogin->addSubmit("Login");
$tmpModalboxRegister= new ModalBox("registerBox","Register");
$tmpModalboxRegister->addSubElement($formRegister);
$page->content=new Alert("Please","Login or Register to create new account","orange");



$page->content  = $formLogin;
$page->content  = $tmpModalboxRegister;



$page->render();
*/