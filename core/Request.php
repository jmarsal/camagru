<?php 
class Request {
	
	public $url;	//URL appelle par l'utilisateur
	
	function __construct() {
		$this->url = $_SERVER['REQUEST_URI'];
		$this->url = trim($this->url, '/');
		$urlTmp = explode('/', $this->url);
		unset($urlTmp[0], $urlTmp[1]);
		$this->url = implode('/', $urlTmp);
	}
}


?>