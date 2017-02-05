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
				$st = $con->db->query("SELECT COUNT(*) FROM users 
								WHERE login='" . $_GET['login'] . "' 
								AND cle='" . $_GET['cle'] . "'")->fetch();
				if ($st['COUNT(*)'] == 1) {
					$req = $con->db->prepare("UPDATE `users` SET `actif`= :actif, WHERE `login`= :login");
					$req->bindValue('actif', 1, PDO::PARAM_INT);
					$req->bindValue('login', $_GET['login'],
						PDO::PARAM_VARCHAR);
					$req->execute();
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}
		$request->action = isset($params[1]) ? $params[1] : 'accueil';
		$request->params = array_slice($params, 2);
		
		return TRUE;
	}
}


?>