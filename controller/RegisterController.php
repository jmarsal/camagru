<?php

class RegisterController extends Controller
{

	public function accueil(){
		$this->loadModel('User');
		$this->render('pages/register');
	}
}
?>