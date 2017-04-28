<?php
if (!isset($_SESSION)){
    session_start();
}
abstract class Controller {

	public	$request;
	private	$_vars = array();
	public	$layout = 'accueil_layout';
	private	$_rendered = FALSE;
	
	function __construct($request) {
		$this->request = $request;
	}
	
	public function render($view, $layout = NULL) {
		if ($layout === NULL){
			$layout = $this->layout;
		}
		if ($this->_rendered) {
			return FALSE;
		}
		extract($this->_vars);
		if (strpos($view, '/') === 0)
		{
			$view = ROOT.DS.'view'.$view.'.php';
		} else {
			$view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}
		ob_start();
		require($view);
		$content_for_layout = ob_get_clean();
		require(ROOT.DS.'view'.DS.'layout'.DS.$layout.'.php');
		$this->_rendered = TRUE;
	}
	
	public function json($httpCode, $data = []){
		http_response_code($httpCode);
		die(json_encode($data));
	}

	public function set($key, $value=NULL) {
		if ($_SERVER['debug'] === 1) {
			if (is_array($key)) {
				$this->_vars += $key;
			} else {
				$this->_vars[$key] = $value;
			}
		}
	}

	public function loadModel($name) {
		$file = ROOT.DS.'model'.DS.$name.'.php';
		require_once($file);
		if(!isset($this->$name)) {
			$this->$name = new $name();
		} else {
			echo 'Pas charge';
		}
	}

	/**
	 * @param $message string Message d'erreur a afficher
	 */
	public function e404($message) {
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->render('/errors/404', '404_layout');
		die();
	}

	/**
	 * @param $newRequest string Le Controller vers lequel on souhaite se
	 * redirige
	 * @param $newAction string La methode que l'on cherche a atteindre
	 */
	public function redirection($newRequest=null, $newAction=null){
		ob_get_clean();
		if ($newRequest && $newAction){
		    header('Location: '.BASE_URL.DS.ucfirst($newRequest).DS.$newAction);
        } else {
            header('Location: '.BASE_URL.DS);
        }
		exit();
	}

    public function logout(){
        if (isset($_SESSION)){
            $_SESSION = array();
            session_destroy();
        }
        $this->redirection();
    }
}
?>