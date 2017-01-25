<?php

class Controller
{
	private $_controllerArray;

	public function __construct($dbName, $url) {
		$db = new Database($dbName);
		$_controllerArray = $this->_direction($url);
		var_dump($_controllerArray);
		
	}

	private function _direction($url) {
		$elemsUrl = Router::parse($url);
		if (!array_count_values($elemsUrl)) {
			$controllerArray[0] = ['Controller'=>'Accueil'];
		} else {
			$controllerArray[0] = ['Controller'=>$elemsUrl[0]];
			if (!empty($elemsUrl[1])) {
				$controllerArray[1] = ['Action'=>$elemsUrl[1]];
			}
		}
		// Cherche a mettre en majuscule la valeur de la cle du tab controllerArray
		// ne marche pas pour le moment ...
		foreach($controllerArray as $key => $value) {
			foreach($value as $key => $v) {
				var_dump($v);
				$v = ucfirst($v);

			}
		}
		return $controllerArray;
	}
}