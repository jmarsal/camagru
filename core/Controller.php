<?php
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

	public function e404($message) {
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->render('/errors/404', '404_layout');
		die();
	}

	public function redirection($newRequest, $newAction){
		ob_get_clean();
		$this->request->url = ucfirst($newRequest.DS.$newAction);
		$this->request->controller = $newRequest;
		$this->request->action = $newAction;
		$name = ucfirst($this->request->controller).'Controller';
		$file = ROOT.DS.'controller'.DS.$name.'.php';
		if (!file_exists($file))
		{
			throw new InvalidArgumentException("Le controller ".DS.$name. " n'existe pas, retour vers index", 42);
			$index = new ErrorController();
		}
//		var_dump($name);
//		echo PHP_EOL;
//		die($file);
		require $file;
		$redirect = new $name($this->request);
		$redirect->$newAction();
	}
}
?>