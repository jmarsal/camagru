<?php
class User extends Model {

	public $table = 'users';
	public $formOk = 0;
	public $mess_error;
	public $login = "";
	public $email = "";
	public $passwd = "";
	public $repPasswd = "";
	public $hashPasswd = "";
//	private $_mailCon;

	// Check dans la table user si le login et le passwd == ce que je recois de
	// $_POST et so ok -> va sur la page Camagru, sinon propose de creer un compte.
	public function __construct() {

		if (isset($_POST['login'])) {
//			Check le formulaire de la page accueil
			$this->checkFormAccueil();

//			Check le formulaire de la page register
			$this->checkFormRegister();
		}
		if (isset($_POST['email'])) {
//			Check le formulaire de la page forgetId
			$this->checkForgetId();
		}
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
			$this->mess_error = '<p class="form_error">Veuillez saisir tous les champs !</p>';
			return FALSE;
		}
		else if (isset($_POST['login']) && !empty($_POST['login'])){
			$this->login = trim(htmlentities($_POST['login']));
		} else{
			$this->mess_error = '<p class="form_error">Le champ Login est vide!</p>';
			return FALSE;
		}
		if (isset($_POST['passwd']) && !empty($_POST['passwd'])){
			$this->passwd = trim(htmlentities($_POST['passwd']));
			$this->hashPasswd = hash('sha256', $this->passwd);
		} else {
			$this->mess_error = '<p class="form_error">Veuillez renseigner un mot de passe!</p>';
			return FALSE;
		}
		return TRUE;
	}

//			Check le formulaire de la page register
	public function checkFormRegister(){
		if ($_POST['submit'] === 'Inscription'){
			if ($this->_getFormRegister()) {
				$this->formOk = 1;
				if (Mail::validEmail($this->email) !== TRUE){
						$this->mess_error .= '<p class="form_error">Veuillez renseigner une adresse email valide!</p>';
						$this->formOk = 0;
				}
				if ($this->formOk = 1){
					if ($this->repPasswd !== $this->passwd){
						$this->mess_error = '<p class="form_error">Les deux champs de mot de passe ne sont pas identiques!</p>';
						$this->formOk = 0;
					}
				}
			}
		}
	}

	private function _getFormRegister(){
		if (!$this->_getFormAccueil()){
			return FALSE;
		}
		if (isset($_POST['email']) && !empty($_POST['email'])){
			$this->email = trim(htmlentities($_POST['email']));
		}else{
			$this->mess_error = '<p class="form_error">Veuillez renseigner votre adresse email!</p>';
			return FALSE;
		}

		if (isset($_POST['repPasswd']) && !empty($_POST['repPasswd'])){
			$this->repPasswd = trim(htmlentities($_POST['repPasswd']));
			$this->hashPasswd = hash('sha256', $this->passwd);
		}else{
			$this->mess_error = '<p class="form_error">Le champ de verification de mot de passe est vide!</p>';
			return FALSE;
		}
		return TRUE;
	}

	// check si dans la bdd et envoie vers l'app si existant...
	public function checkLogin($login, $passwd){
		$con = new Model;
 
		$st = $con->db->query("SELECT COUNT(*) FROM users 
								WHERE login='".$this->login."' 
								AND password='".$this->hashPasswd."'")->fetch();
		if ($st['COUNT(*)'] == 1){
			$_SESSION['login'] = $this->login;
			$_SESSION['loged'] = 1;
			return (TRUE);
		}
		else{
			$st = $con->db->query("SELECT COUNT(*) FROM users 
									WHERE login='".$this->login."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				$this->mess_error = "<p class='form_error'>Wrong Password</p>";
			}else{
				$this->mess_error = '<p class="form_error">Le Login n\'existe pas !</p>';
			}
		}
	}


	// Enregistre un nouvel user dans la bdd + send mail de confirmation
	public function addUser($login, $email, $passwd) {
		$con = new Model;
		$cle = uniqid('', true);

		if (preg_match('/^[a-zA-Z0-9_]{3,16}$/', $this->login)){
			$st = $con->db->query("SELECT COUNT(*) FROM users
									WHERE login='".$this->login."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				$this->mess_error = '<p class="form_error">Ce Login est deja utilise !</p>';
				return (FALSE);
			}
			$st = $con->db->query("SELECT COUNT(*) FROM users
									WHERE email='".$this->email."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				$this->mess_error = '<p class="form_error">Cet email est deja utilise !</p>';
				return (FALSE);
			}
			$req = $con->db->prepare("INSERT INTO `users`(`login`, `password`, `email`, `cle`)
										VALUES (:login, :password, :email, :cle)");
			if ($req->execute(array(
				"login" => $login,
				"password" => $passwd,
				"email" => $email,
				"cle" => $cle))){

				$this->_sendMailRegister($cle);
				return (TRUE);
			}else{
				if ($_SERVER['debug'] === 1)
					$this->mess_error = '<p class="form_error">l\'insertion n\'a pas marche!</p>';
					return (FALSE);
			}
		}else{
			$this->mess_error = '<p class="form_error">Votre login doit faire entre trois et seize caracteres et les caracteres speciaux ne sont pas autorises !</p>';
			return (FALSE);
		}
	}

	private function _sendMailRegister($cle){
		$options = array(
			'email' => $this->email,
			'login' => $this->login,
			'subject' => 'Inscription a CAMAGRU',
			'message' => '',
			'title' => '',
			'from' => '',
			'cle' => $cle);

		$sender = new MailSender($options);
		$sender->confirmSubscribeMail();
	}

	public function checkForgetId(){
		if ($_POST['submit'] === 'Récuperer' && !empty
			($_POST['email'])){
			$email = trim(htmlentities($_POST['email']));
			if (($user_exist = $this->_requestMail($email)) === TRUE){
//				Ne doit afficher la popup que si les champs sont charges...
				if (isset($this->email) && isset($this->login) &&
					!empty($this->email) && !empty($this->login)){
					$_ENV['login'] = $this->login;
					$_ENV['email'] = $this->email;
				}
			}else if ($user_exist === FALSE){
				echo '<p class="form_error">Cette adresse mail ne correspond à aucun
			utilisateur!</p>';
			}
		} else if (isset($_POST['email']) && $_POST['submit'] === 'Récuperer'
			&& empty ($_POST['email'])){
			echo "<p class=\"form_error\">Veuillez renseigner une adresse mail !</p>";
		}
	}

	private function _requestMail($email){
		if (Mail::validEmail($email)){
			$sql = "SELECT * FROM users
							WHERE email=?";
			$con = new Model;
			try{
				$st = $con->db->prepare($sql);
				$d = array($email);
				$st->execute($d);
				$user_exist = $st->rowCount();
				if ($user_exist === 1){
					$this->email = $email;
					$this->_getLoginByEmail($con, $email);
				}
			}catch (PDOexception $e){
				print "Erreur : ".$e->getMessage()."";
				die();
			}
			if ($user_exist !== 1){
				return FALSE;
			}
			return TRUE;
		}
		echo "<p class=\"form_error\">Veuillez renseigner une adresse mail !</p>";
	}

	private function _getLoginByEmail($conBdd, $toCheck){
		try{
			$query = $conBdd->db->prepare("SELECT login FROM users WHERE email=?");
			$d = array($toCheck);
			$query->execute($d);
			$row = $query->fetch();
			$this->login = $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
}
?>