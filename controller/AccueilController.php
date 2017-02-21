<?php
class AccueilController extends Controller
{
	public $formOk = 0;
	public $mess_error;
	public $login = "";
	public $passwd = "";
	public $hashPasswd = "";

	public function accueil() {
		$this->loadModel('User');
		if (isset($_POST['login'])) {
//			Check le formulaire de la page accueil
			$this->checkFormAccueil();
			if ($this->formOk === 1){
//				Check dans la bdd si le user existe et si le couple
// 				user / pass match
				if (($this->mess_error = $this->User->checkLogin($this->login,
					$this->hashPasswd)) === TRUE){
					if ($_SESSION['loged'] === 1){
//						Si il match, ouvre page principal de l'app
						$this->redirection('app', 'appCamagru');
					}
				}
			}
		}
		$this->render('pages/accueil', 'accueil_layout');
	}

	//	check formulaire de la page accueil
	public function checkFormAccueil(){
		if ($_POST['submit'] === 'Login'){
			if ($this->_getFormAccueil()) {
				$this->formOk = 1;
			}
		}
	}

	private function _getFormAccueil(){
		if (empty($_POST['login']) && empty($_POST['passwd'])){
			$this->mess_error = 'Veuillez saisir tous les champs !';
			return FALSE;
		}
		else if (isset($_POST['login']) && !empty($_POST['login'])){
			$this->login = trim(htmlentities($_POST['login']));
		} else{
			$this->mess_error = 'Le champ Login est vide!';
			return FALSE;
		}
		if (isset($_POST['passwd']) && !empty($_POST['passwd'])){
			$this->passwd = trim(htmlentities($_POST['passwd']));
			$this->hashPasswd = hash('sha256', $this->passwd);
		} else {
			$this->mess_error = 'Veuillez renseigner un mot de passe!';
			return FALSE;
		}
		return TRUE;
	}
}
?>