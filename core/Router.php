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
			Router::validAccountByMail($params);
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
		if (isset($tmpAction[0]) && $tmpAction[0] === 'validation') {
			$params[1] = $tmpAction[0];
			$con = new Model;
			try{
				$sql = "SELECT * FROM users
							WHERE login=? AND cle=?";
				$st = $con->db->prepare($sql);
				$d = array($_GET['log'], $_GET['cle']);
				$st->execute($d);
				$user_exist = $st->rowCount();
			}catch (PDOexception $e){
				print "Erreur : ".$e->getMessage()."";
				die();
			}

			if ($user_exist) {
				try {
					$sql = "UPDATE users SET actif =?, cle =?  WHERE login=?
					AND cle=?";
					$st = $con->db->prepare($sql);
					$d = array(1, uniqid('', true), $_GET['log'], $_GET['cle']);
					$st->execute($d);
				}catch (PDOexception $e){
					print "Erreur : ".$e->getMessage()."";
					die();
				}
			}
		}
	}
}


?>