<?php
if (!isset($_SESSION)){
    session_start();
}
class AccueilController extends Controller
{
	public $formOk = 0;
	public $mess_error;
	public $login = "";
	public $passwd = "";
	public $hashPasswd = "";

    public function accueil() {
        $this->loadModel('User');
        $this->loadModel('Photo');

        if (isset($_COOKIE['camagru-log'])){
            $log = $_COOKIE['camagru-log'];
        }
        if (isset($log) && !empty($log)){
            $idLog = $this->User->getIdUser($log);
            $this->Photo->deleteDirectoryIfExist(REPO_PHOTO.$idLog.DS.'min');
            $this->Photo->deletePrevInDb($idLog);
        }
        if (isset($_SESSION)){
            session_destroy();
            setcookie('camagru-log', '', time() - 31556926);
            unset($_COOKIE['camagru-log']);
        }
        $this->render('pages/accueil', 'accueil_layout');
	}

	public function submitAccueilAjax(){
        $this->loadModel('User');
//		Check le formulaire de la page accueil
        $this->_checkFormAccueil();
        if ($this->formOk == 1){
//		Check dans la bdd si le user existe et si le couple user / pass match
            if (($this->mess_error = $this->User->checkLogin($this->login, $this->hashPasswd)) === TRUE){
                $_SESSION['login'] = $this->login;
                $_SESSION['log'] = 1;
                setcookie('camagru-log', $this->login, time() + 31556926);
                return $this->json(200, [
                    'redirect' => 'ok'
                ]);
            }
        }
        $this->mess_error = ($this->mess_error === 'true') ? "" : $this->mess_error;
        if (!empty($this->mess_error) || $this->mess_error !== 'true'){
            return $this->json(200, [
                "messError" => $this->mess_error
            ]);
        }
    }

	//	check formulaire de la page accueil
	private function _checkFormAccueil(){
        if ($this->_getFormAccueil()) {
            $this->formOk = 1;
        }
	}

	private function _getFormAccueil(){
        if (empty($_POST['login']) && empty($_POST['passwd'])){
            $this->mess_error = 'Veuillez saisir tous les champs !';
            return FALSE;
		}
		else if (!empty($_POST['login'])){
			$this->login = trim(htmlentities($_POST['login']));
		} else{
			$this->mess_error = 'Le champ Login est vide!';
			return FALSE;
		}
		if (!empty($_POST['passwd'])){
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