<?php 
class Request {
	
	public $url;	//URL appelle par l'utilisateur
	
	function __construct() {
		$controller = array(
			"0" => "app",
			"1" => "register",
			"2" => "forgetId",
			"3" => "galerie"
		);
		$i = 0;
		$this->url = $_SERVER['REQUEST_URI'];
		$this->url = trim($this->url, '/');
		$urlTmp = explode('/', $this->url);
		if ($urlTmp[0] === 'workspace'){
			array_shift($urlTmp);
		}

		foreach ($urlTmp as $v){
			if ((array_search($v, $controller)) !== FALSE){
				break;
			} else {
				$i++;
			}
		}

		if ($i < count($urlTmp) && $i > 0){
			while ($urlTmp[$i] > 0 && $urlTmp[0] !== NAME_FOLDER) {
				array_shift($urlTmp);
				$i--;
			}
		} else {
			array_shift($urlTmp);
		}
		$this->url = implode('/', $urlTmp);
	}
}


?>