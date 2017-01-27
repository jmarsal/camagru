<?php 
class Controller {

	public	$request;
	private	$_vars = array();
	public	$layout = 'default';
	private	$rendered = FALSE;
	
	function __construct($request) {
		$this->request = $request;
	}
	
	public function render($view, $layout = NULL) {
		if ($layout === NULL){
			$layout = $this->layout;
			// var_dump($layout);
		}
		if ($this->rendered) {
			return FALSE;
		}
		extract($this->_vars);
		if (strpos($view, '/') === 0)
		{
			$view = ROOT.DS.'view'.$view.'.php';
		} else {
			$view = ROOT.DS.'view'.DS.$this->request->controller.$view.'.php';
		}
		ob_start();
		require($view);
		$content_for_layout = ob_get_clean();
		require(ROOT.DS.'view'.DS.'layout'.DS.$layout.'.php');
		$this->rendered = TRUE;
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

	function e404($message) {
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->render('/errors/404');
		die();
	}
}
?>