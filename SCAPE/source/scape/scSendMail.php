<?php

//**************************************************//
// Created By: Narayan Bhandari                     //
//             www.narayan.id.au                    //
//             www.planetonnet.com                  //
// Date:       Jan 2013                             //
//**************************************************//

namespace scape\source\scape;
include_once("../../scInit.php");

use scape\source\element\Alert;
use scape\source\element\Div;
use scape\source\element\Element;


class SendMail{
	protected $from;
	protected $toList;
	protected $replyTo;
	protected $subject;
	protected $message;
	public function __construct(){
		$this->setFrom();
		$this->setReplyTo();
		$this->setSubject();
	}
	
	
	public function sendMail():Element{
		$return =new Div();

		$headers ='From: '.$this->getFrom()."\r\n" .
				  'Reply-To: '.$this->getReplyTo(). "\r\n" .
				  'MIME-Version: 1.0' . "\r\n".
				  'Content-type: text/html; charset=iso-8859-1' . "\r\n".
				  'X-Mailer: PHP/' . phpversion();
		foreach($this->toList as $to)
		{
			if(mail($to, $this->getSubject(), $this->getMessage(), $headers))
				$return->addSubElement(new Alert("Success","email sent to: ".$to,"green"));
			else
			    $return->addSubElement(new Alert("Error","email sent to: ".$to,"red"));
		}
		return $return;
	}
	
	public function setFrom ($tmpFrom = "updates@narayan.id.au"){
		$this->from = $tmpFrom ;
	}
	public function getFrom (){
		return $this->from ;
	}
	
	public function addInToList ($tmpTo ){
		$this->toList[] = $tmpTo ;
	}
	
	public function setReplyTo ($tmpReplyTo = "narayan.mail12@gmail.com"){
		$this->replyTo = $tmpReplyTo ;
	}
	public function getReplyTo (){
		return $this->replyTo  ;
	}
	
	public function setSubject ($tmpSubject = "Update from Narayan Bhandari"){
		$this->subject= $tmpSubject ;
	}
	public function getSubject (){
		return $this->subject ;
	}
	
	public function setMessage ($tmpMessage ){
		$tmpMessage.='<br>This is System Generated Message on behalf of 
						<a href="http://narayan.id.au/">Narayan Bhandari</a><br>';
		$this->message = stripslashes($tmpMessage) ;
	}
	public function getMessage (){
		return  $this->message ;
	}
}

?>