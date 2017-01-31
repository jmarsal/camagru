<?php 
class Router {
	
	/**
	 * Permet de parser une url
	 * @param $url Url a parser
	 * @return TRUE
	 */
	static function parse($url, $request){
		$url = trim($url, '/');
		$params = explode('/', $url);
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'accueil';
		$request->params = array_slice($params, 2);
		// die(var_dump($request));
		
		return TRUE;
	}
}


?>