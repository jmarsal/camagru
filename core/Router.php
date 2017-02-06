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
		if ($request->controller === 'register') {
			if (!empty($params[1])) {
				$tmpAction = explode('?', $params[1]);
			}
			if (isset($tmpAction[0]) && $tmpAction[0] === 'validation') {
				$params[1] = $tmpAction[0];
				$con = new Model;
				var_dump($_GET);
				$login = $_GET['log'];
				$cle = $_GET['cle'];
				$sql = "SELECT COUNT(*) FROM users
						WHERE login=? AND cle=?";
				$st = $con->db->prepare($sql);
				$d = array($login, $cle);
				$st->execute($d);
//				die(var_dump(count($st)));
				if (count($st)) {
					$sql = "UPDATE users SET actif =? WHERE login=?
				AND cle=?";
					$st = $con->db->prepare($sql);
					$d = array(1, $login, $cle);
					$st->execute($d);
					return TRUE;
				}
			}
		}
		$request->action = isset($params[1]) ? $params[1] : 'accueil';
		$request->params = array_slice($params, 2);
		
		return TRUE;
	}
}


?>