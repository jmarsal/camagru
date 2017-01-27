<?php 
class Request {
	
	public $url;	//URL appelle par l'utilisateur
	
	function __construct() {
		$this->url = $_SERVER['REDIRECT_URL'];
		$this->url = trim($this->url, '/');
		$urlTmp = explode('/', $this->url);
		if ($urlTmp[0] !== 'camagru') {
			unset($urlTmp[0], $urlTmp[1]);
		} else {
			unset($urlTmp[0]);
		}
		$this->url = implode('/', $urlTmp);
	}
}


?>