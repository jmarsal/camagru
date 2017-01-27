<?php

class AccueilController extends Controller
{
	public function accueil() {
		$this->render('pages/accueil', 'accueil_layout');
	}
}


?>