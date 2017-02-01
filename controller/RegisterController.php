<?php

class RegisterController extends Controller
{
	// public	$request;

	// function __construct($request) {
	// 	$this->request = $request;
	// }

	public function accueil(){
		$this->render('pages/register');
	}

	public function validation(){
		$this->render('pages/validation');
		// var_dump($this->request->params[1]);
	}
}
?>