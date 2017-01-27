<?php 
class Router {
	
	/**
	 * Permet de parser une url
	 * @param $url Url a parser
	 * @return TRUE
	 */
	static function parse($url, $request){
		// phpinfo();
		$url = trim($url, '/');
		$params = explode('/', $url);
		// $params = array_filter($params);
		
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'accueil';
		$request->params = array_slice($params, 2);
		// var_dstatusump($request);
		
		return TRUE;
	}
}


?>