<?php
class User extends Model {

	public $table = 'users';
//	public $formOk = 0;
//	public $mess_error;
//	public $login = "";
//	public $email = "";
//	public $passwd = "";
//	public $repPasswd = "";
//	public $hashPasswd = "";
//	private $_mailCon;

	// Check dans la table user si le login et le passwd == ce que je recois de
	// $_POST et so ok -> va sur la page Camagru, sinon propose de creer un compte.
//	public function __construct() {
//		parent::__construct();
//		if (isset($_POST['login'])) {
////			Check le formulaire de la page accueil
//			$this->checkFormAccueil();
//
////			Check le formulaire de la page register
//			$this->checkFormRegister();
//		}
//		if (isset($_POST['email'])) {
////			Check le formulaire de la page forgetId
//			$this->checkForgetId();
//		}
//	}

	// check si dans la bdd et envoie vers l'app si existant...
	//	return message d'erreur si probleme
	public function checkLogin($login, $passwd){
		$st = $this->db->query("SELECT COUNT(*) FROM users 
								WHERE login='".$login."' 
								AND password='".$passwd."'")->fetch();
		if ($st['COUNT(*)'] == 1){
			$_SESSION['login'] = $login;
			$_SESSION['loged'] = 1;
			return (TRUE);
		}
		else{
			$st = $this->db->query("SELECT COUNT(*) FROM users 
									WHERE login='".$login."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				return ("Wrong Password");
			}else{
				return ('Le Login n\'existe pas !');
			}
		}
	}


	// Enregistre un nouvel user dans la bdd + send mail de confirmation
	public function addUser($login, $email, $passwd) {
		$cle = uniqid('', true);

		if (preg_match('/^[a-zA-Z0-9_]{3,16}$/', $login)){
			$st = $this->db->query("SELECT COUNT(*) FROM users
									WHERE login='".$login."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				return $this->mess_error = 'Ce Login est deja utilise !';
			}
			$st = $this->db->query("SELECT COUNT(*) FROM users
									WHERE email='".$email."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				return $this->mess_error = 'Cet email est deja utilise !';
			}
			$req = $this->db->prepare("INSERT INTO `users`(`login`, `password`, `email`, `cle`)
										VALUES (:login, :password, :email, :cle)");
			if ($req->execute(array(
				"login" => $login,
				"password" => $passwd,
				"email" => $email,
				"cle" => $cle))){

				$this->_sendMailRegister($cle, $email, $login);
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

	private function _sendMailRegister($cle, $email, $login){
		$options = array(
			'email' => $email,
			'login' => $login,
			'subject' => 'Inscription a CAMAGRU',
			'message' => '',
			'title' => '',
			'from' => '',
			'cle' => $cle);

		$sender = new MailSender($options);
		$sender->confirmSubscribeMail();
	}

	public function requestMail($email){
		if (Mail::validEmail($email)){
			$sql = "SELECT * FROM users
							WHERE email=?";
			try{
				$st = $this->db->prepare($sql);
				$d = array($email);
				$st->execute($d);
				$user_exist = $st->rowCount();
				if ($user_exist === 1){
//					$this->email = $email;
					$login = $this->getLoginByEmail($email);
				}
			}catch (PDOexception $e){
				print "Erreur : ".$e->getMessage()."";
				die();
			}
			if ($user_exist !== 1){
				return FALSE;
			}
			return $login;
		}
		return "Veuillez renseigner une adresse mail valide";
	}

	public function getLoginByEmail($email){
		try{
			$query = $this->db->prepare("SELECT login FROM users WHERE email=?");
			$d = array($email);
			$query->execute($d);
			$row = $query->fetch();
			return $this->login = $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
}
?>