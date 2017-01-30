<?php

class RegisterController extends Controller
{
	public function accueil(){
		$this->render('pages/register', 'accueil_layout');
	}

	public function validation(){
		$this->render('pages/validation', 'accueil_layout');
	}
}
?>