<?php

class RegisterController extends Controller
{
	public function accueil(){
		$this->render('pages/register');
	}

	public function validation(){
		$this->render('pages/validation');
	}
}
?>