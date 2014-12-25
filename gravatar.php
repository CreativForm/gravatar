<?php
/**********************************************************
 * GET CONTENT FROM GRAVATAR v1.0.0 (http://creativform.com)
 * created: 12/24/2014 10:00 (EST)
 * Copyright 2014 CreativForm.com
 * Created by: Ivijan-Stefan Stipic (creativform@gmail.com)
 * Licensed under MIT (http://creativform.com/MIT-License)
***********************************************************/
/*
	EXAMPLE:
	----------------------------
	$gravatar=new gravatar('example@gmail.com', 'http://mydomain.com/image/no-image.jpg');
	
	echo $gravatar->image(200);		// Get image
	echo $gravatar->QRcode(400);	// Get QR Code
	echo $gravatar->vCard();		// Get VCF/vCard
	$json=$gravatar->json(); 		// return objects
	echo $gravatar->xml(); 			// return xml data
*/
class gravatar
{
	protected $validateURL="/\b(?:(?:https?|ftp|ftps|http):\/\/|www\.)[-a-zA-Z0-9+&@#\/%?=~_|!:,.;]*[-a-zA-Z0-9+&@#\/%=~_|]/i";
	protected $email=NULL;
	protected $default=NULL;
	/*
		GET GRAVATAR IMAGE
		----------------------------
		$gravatar=new gravatar('example@gmail.com', 'http://mydomain.com/image/no-image.jpg');
		
		echo $gravatar->image(400);
	*/
	public function image($size=false)
	{
		$url=$this->__get_url($this->__generate_image($size));
		if($url!==false)
			return $url;
		else
			return $this->default;
	}
	/*
		GET GRAVATAR QR CODE
		----------------------------
		$gravatar=new gravatar('example@gmail.com');
		
		echo $gravatar->QRcode(400);
	*/
	public function QRcode($size=false)
	{
		$url=$this->__get_url($this->__generate_qrcode($size));
		if($url!==false)
			return $url;
		else
			return false;
	}
	/*
		GET GRAVATAR VCF/vCard
		----------------------------
		$gravatar=new gravatar('example@gmail.com');
		
		echo $gravatar->vCard();
	*/
	public function vCard()
	{
		$url=$this->__get_url($this->__generate_vcf());
		if($url!==false)
			return $url;
		else
			return false;
	}
	/*
		GET GRAVATAR VCF/vCard
		----------------------------
		$gravatar=new gravatar('example@gmail.com');
		
		$json=$gravatar->json(); // return objects
	*/
	public function json()
	{
		$url=$this->__get_url($this->__generate_json());
		if($url!==false)
		{
			return json_decode($url);
		}
		else
			return false;
	}
	/*
		GET GRAVATAR VCF/vCard
		----------------------------
		$gravatar=new gravatar('example@gmail.com');
		
		echo $gravatar->xml(); // return xml data
	*/
	public function xml()
	{
		$url=$this->__get_url($this->__generate_xml());
		if($url!==false)
			return $url;
		else
			return false;
	}
/*------------------------------------------------------------------------------*/
	// generate safe URL for image
	protected function __generate_image($size,$max_rating=NULL,$secure=false){
		if(in_array($max_rating, array('g','pg','r','x'))) $gets[]='r='.trim($max_rating);
		if(!empty($this->default)) $gets[]='d='.urlencode($this->default);
		if(is_float($size) || is_numeric($size)) $gets[]='s='.$size;
		if($secure===true)
			$host='https://secure.gravatar.com/avatar/';
		else
			$host='http://www.gravatar.com/avatar/';
		return $host.$this->email.(count($gets)>0?'?'.join('&',$gets):'');
	}
	// generate safe URL for QR code
	protected function __generate_qrcode($size){
		if(is_float($size) || is_numeric($size)) $gets[]='s='.$size;
		$host='http://sr.gravatar.com/';
		return $host.$this->email.'.qr'.(count($gets)>0?'?'.join('&',$gets):'');
	}
	// generate safe URL for QR code
	protected function __generate_vcf(){
		$host='http://www.gravatar.com/';
		return $host.$this->email.'.vcf';
	}
	// generate safe URL for json
	protected function __generate_json(){
		$host='https://sr.gravatar.com/';
		return $host.$this->email.'.json';
	}
	// generate safe URL for xml
	protected function __generate_xml(){
		$host='http://sr.gravatar.com/';
		return $host.$this->email.'.xml';
	}
	// chck url
	protected function __get_url($url)
	{
		$url=trim($url);
		if(preg_match($this->validateURL, $url)!==0)
		{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5); 
			curl_setopt($ch, CURLOPT_TIMEOUT , 2);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return (($retcode===200)?$url:false);
		} else return false;
	}
	// constructions
	function __construct($email=false, $default=false)
	{
		$this->email	= md5(strtolower(trim($email)));
		$this->default	= trim($default);
	}
	// clear all data
	function __destruct()
	{
		$this->email=$this->default=NULL;
	}
}
?>
