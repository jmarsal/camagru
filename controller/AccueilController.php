<?php
class AccueilController extends Controller
{
	public function accueil() {
		$this->loadModel('User');
		$this->render('pages/accueil', 'accueil_layout');
	}
}
?>