<?php
if (!isset($_SESSION)){
    session_start();
}
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
		if ($request->controller === 'register' ||
			$request->controller === 'forgetId') {
			$params[1] = Router::validAccountByMail($params);
		}
		$request->action = isset($params[1]) ? $params[1] : 'accueil';
		$request->params = array_slice($params, 2);

		return TRUE;
	}

	static private function validAccountByMail($params)
	{
		if (!empty($params[1])) {
			$tmpAction = explode('?', $params[1]);
		}
		if (isset($tmpAction[0]) && ($tmpAction[0] === 'validation' ||
				$tmpAction[0] === 'reinit')) {
			return $tmpAction[0];
		}
	}
}


?>