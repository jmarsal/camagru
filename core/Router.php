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
        if (!empty($params[1])){
            $request->controller = $params[1];
        } else {
            $request->controller = "";
        }

		if ($request->controller === 'register' ||
			$request->controller === 'forgetId') {
			$params[2] = Router::validAccountByMail($params);
		}
		$request->action = isset($params[2]) ? $params[2] : 'accueil';
		$request->params = array_slice($params, 3);

		return TRUE;
	}

	static private function validAccountByMail($params)
	{
		if (!empty($params[2])) {
			$tmpAction = explode('?', $params[2]);
		}
		if (isset($tmpAction[0]) && ($tmpAction[0] === 'validation' ||
				$tmpAction[0] === 'reinit')) {
			return $tmpAction[0];
		}
	}
}


?>