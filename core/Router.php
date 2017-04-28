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
//		$testURL = 0;

		$params = explode('/', $url);
		if ($params[0] == ""){
			$request->controller = $params[0];
		} else {
			$request->controller = $params[1];
			$testURL = 1;
		}
		if ($request->controller === 'register' ||
			$request->controller === 'forgetId') {
			$params[1] = Router::validAccountByMail($params);
		}
//		if ($testURL == 0){
			$request->action = isset($params[1]) ? $params[1] : 'accueil';
//		} else {
//			$request->action = isset($params[2]) ? $params[2] : 'accueil';
//		}
		$request->params = array_slice($params, 2);
//		var_dump($request->params);

		return TRUE;
	}

	static private function validAccountByMail($params)
	{
		if (!empty($params[1])) {
			$tmpAction = explode('?', $params[1]);
//			var_dump($tmpAction);
		}
		if (isset($tmpAction[0]) && ($tmpAction[0] === 'validation' ||
				$tmpAction[0] === 'reinit')) {
			return $tmpAction[0];
		}
	}
}


?>