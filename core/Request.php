<?php 
class Request {
	
	public $url;	//URL appelle par l'utilisateur
	
	function __construct() {
        $PATH = (explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        if ($PATH[0] === ""){
            array_shift($PATH);
        }
        if ($PATH[0] === "workspace"){
            array_shift($PATH);
            $this->url = str_replace('workspace/', "", $_SERVER['REQUEST_URI']);
        } else {
            $this->url = $_SERVER['REQUEST_URI'];
        }
        $this->url = trim($this->url, '/');
        $this->url = implode('/', $PATH);
        if (empty($PATH[1])){
            $this->url = "";
        }
    }
}


?>