<?php
class AppController extends Controller
{
//	public $content_for_layout;

	public function appCamagru(){
		if ($_SESSION['log'] == 1){
			if (isset($_POST['logout']) && $_POST['logout'] === 'Logout'){
				session_destroy();
				$this->redirection('Accueil', 'accueil');
			}
			$this->render('appCamagru', 'app_layout');
		}else{
			$this->redirection('Accueil', 'accueil');
		}

	}
}