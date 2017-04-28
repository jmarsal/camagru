<?php
if (!isset($_SESSION)){
    session_start();
}
class Dispatcher {
	
	var $request;
	
	function __construct($redirect = NULL) {
		// Recupere l'URL et la parse
		if (!$redirect){
			$this->request = new Request();
			Router::parse($this->request->url, $this->request);
//			var_dump($this->request);
			/////////////////////////////////////////////////////////////////////////////////
		}else{
			$this->request = $redirect;
		}
		// Charge le controller correspondant, si erreur, renvoi sur Controller 404
		try {
			$controller = $this->loadController();
		} catch(InvalidArgumentException $controllerError) {
			if ($controllerError->getCode() !== 42)
			{
				throw $controllerError;
			}
			$this->error('Le controller '.DS.$this->request->controller.' n\'existe pas !');
		}

		// Verifie que l'action existe dans les methodes du controller



		if (!in_array($this->request->action, get_class_methods($controller))) {
			$this->error('Le controller '.$this->request->controller.' n\'a pas de methode '.$this->request->action);
		}

		// Appel de la fonction qui correspond a l'action dans le controller
		call_user_func_array(array($controller, $this->request->action), $this->request->params);
		if(empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$controller->render($this->request->action);
		}
		if ($this->request->controller === 'PagesController' && !empty($this->request->params)) {
			$this->error('Le controller '.$this->request->controller.' a besoin de parametres !');
		}
	}
	
	function error($message) {
		$this->request->url = "";
		$controller = $this->loadController();
		$controller->e404($message);
	}
	
	function loadController() {
		if ($this->request->url !== "") {
			$name = ucfirst($this->request->controller).'Controller';
		} else {
			$name = 'AccueilController';
		}
		$file = ROOT.DS.'controller'.DS.$name.'.php';
		if (!file_exists($file))
		{
			throw new InvalidArgumentException("Le controller ".DS.$name. " n'existe pas, retour vers index", 42);
			$index = new ErrorController();
		}
		require $file;
        return new $name($this->request);
	}
}

?>