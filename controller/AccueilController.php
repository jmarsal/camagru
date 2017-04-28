<?php
if (!isset($_SESSION)){
    session_start();
}
class AccueilController extends Controller
{
    protected $_login = "";
    protected $_passwd = "";
    private $_hashPasswd = "";
    private $_mess_error;

    public function accueil() {
        $this->loadModel('User');
        $this->loadModel('Photo');

        $this->_delogUser();
        $this->render('pages/accueil', 'accueil_layout');
	}

	public function submitAccueilAjax(){
        $this->loadModel('User');

        if ($this->_checkAndGetFormAccueil()){
            $this->_logUser();
        }
        $this->_printErrorIfNecessary();
    }

	private function _checkAndGetFormAccueil(){
        if (empty($_POST['login']) && empty($_POST['passwd'])){
            $this->_mess_error = 'Veuillez saisir tous les champs !';
            return FALSE;
		}
		else if (!empty($_POST['login'])){
			$this->_login = trim(htmlentities($_POST['login']));
		} else{
			$this->_mess_error = 'Le champ Login est vide!';
			return FALSE;
		}
		if (!empty($_POST['passwd'])){
			$this->_passwd = trim(htmlentities($_POST['passwd']));
			$this->_hashPasswd = hash('sha256', $this->_passwd);
		} else {
			$this->_mess_error = 'Veuillez renseigner un mot de passe!';
			return FALSE;
		}
		return TRUE;
	}

    private function _delogUser(){
        if (isset($_SESSION['log']) && $_SESSION['log'] == 1){
            $log = $_SESSION['login'];
        }
        if (!empty($log)) {
            $idLog = $this->User->getIdUser($log);
            $this->Photo->deleteDirectoryIfExist(REPO_PHOTO.$idLog.DS.'min');
            $this->Photo->deletePrevInDb($idLog);
        }
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        setcookie('camagru-log', '', time() - 31556926);
        unset($_COOKIE['camagru-log']);
        $this->_login = "";
    }

    private function _logUser(){
        if (($this->_mess_error = $this->User->checkLogin($this->_login, $this->_hashPasswd)) === TRUE){
            $_SESSION['login'] = $this->_login;
            $_SESSION['log'] = 1;
            return $this->json(200, [
                'redirect' => 'ok'
            ]);
        }
    }

    private function _printErrorIfNecessary(){
        $this->_mess_error = ($this->_mess_error === 'true') ? "" : $this->_mess_error;
        if (!empty($this->_mess_error) || $this->_mess_error !== 'true'){
            return $this->json(200, [
                "messError" => $this->_mess_error
            ]);
        }
    }
}
?>