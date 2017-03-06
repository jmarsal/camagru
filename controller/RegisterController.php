<?php

class RegisterController extends Controller
{
	public $formOk = 0;
	public $mess_error;
	public $login = "";
	public $email = "";
	public $passwd = "";
	public $repPasswd = "";
	public $hashPasswd = "";
	public $popup;

	public function accueil(){
		$this->loadModel('User');
		if (isset($_POST['login'])) {
//			Check le formulaire de la page register
			$this->checkFormRegister();
		}

		$this->render('pages/register');
	}

	//			Check le formulaire de la page register
	public function checkFormRegister(){

		if ($_POST['submit'] === 'Inscription'){
			if ($this->_getFormRegister()) {
				$this->formOk = 1;
				if (Mail::validEmail($this->email) !== TRUE){
					$this->mess_error = 'Veuillez renseigner une adresse email valide!';
					$this->formOk = 0;
				}
				if ($this->formOk = 1){
					if ($this->repPasswd !== $this->passwd){
						$this->mess_error = 'Les deux champs de mot de passe ne sont pas identiques!';
						$this->formOk = 0;
					}
					if (($this->mess_error = $this->User->addUser($this->login,
                        $this->email, $this->hashPasswd)) === TRUE){
						$this->popup = str_replace('^^email^^', $this->email,
                        str_replace('^^login^^', $this->login,
                        file_get_contents(ROOT.DS.'view'.DS .'register'.DS.'pages'.DS.'popupRegister.html')));
						$_ENV['popup'] = 1;
                    }
				}
			}
		}
	}

	private function _getFormRegister(){
		if (empty($_POST['login']) && empty($_POST['passwd'])){
			$this->mess_error = 'Veuillez saisir tous les champs !';
			return FALSE;
		} else if (isset($_POST['login']) && !empty($_POST['login'])){
			$this->login = trim(htmlentities($_POST['login']));
		} else{
			$this->mess_error = 'Le champ Login est vide!';
			return FALSE;
		}
		if (isset($_POST['email']) && !empty($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
		}else{
			$this->mess_error = 'Veuillez renseigner votre adresse email!';
			return FALSE;
		}
		if (isset($_POST['passwd']) && !empty($_POST['passwd'])){
			$this->passwd = trim(htmlentities($_POST['passwd']));
			$this->hashPasswd = hash('sha256', $this->passwd);
		} else {
			$this->mess_error = 'Veuillez renseigner un mot de passe!';
			return FALSE;
		}

		if (isset($_POST['repPasswd']) && !empty($_POST['repPasswd'])){
			$this->repPasswd = trim(htmlentities($_POST['repPasswd']));
			$this->hashPasswd = hash('sha256', $this->passwd);
		}else{
			$this->mess_error = 'Le champ de verification de mot de passe est vide!';
			return FALSE;
		}
		return TRUE;
	}

	public function validation(){
		$this->loadModel('User');
		if (isset($_GET['log'], $_GET['cle']) &&
			!empty($_GET['log']) && !empty($_GET['cle'])){
			$log = htmlentities(trim($_GET['log']));
			$cle = htmlentities(trim($_GET['cle']));
			if (($this->User->checkValueOfGetForValidation($log, $cle)) ===
				TRUE){
				$this->User->changeKeyUser($log);
				$this->User->changeActifUser($log);
				$this->redirection();
			}else{
				echo $this->mess_error = 'Le Login ne correspond pas a la cle de validation';
				die();
			}
		}else{
			echo $this->mess_error = 'Le Login et / ou la cle de validation sont vides';
			die();
		}
	}
}
?>