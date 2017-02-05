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
	private $_mailCon;

	// Check dans la table user si le login et le passwd == ce que je recois de
	// $_POST et so ok -> va sur la page Camagru, sinon propose de creer un compte.
	public function __construct() {
		if (isset($_POST['login'])){
			if (isset($_POST['login'], $_POST['passwd']) &&
				!empty($_POST['login']) && !empty($_POST['passwd']) &&
				($_POST['submit'] === 'Login' || $_POST['submit'] === 'Inscription')){
				$this->login = htmlentities($_POST['login']);
				$this->passwd = htmlentities($_POST['passwd']);
				$this->hashPasswd = hash('sha256', $this->passwd);
				$this->formOk = 1;
			}else if (empty($_POST['login']) && empty($_POST['passwd'])){
				$this->mess_error = '<p class="form_error">Veuillez saisir tous les champs !</p>';
			}else if (empty($_POST['login'])){
				$this->passwd = $_POST['passwd'];
				$this->mess_error = '<p class="form_error">Veuillez saisir votre nom d\'utilisateur !</p>';
			}else if (empty($_POST['passwd'])){
				$this->login = $_POST['login'];
				$this->mess_error = '<p class="form_error">Veuillez saisir votre mot de passe !</p>';
			}
			if (isset($_POST['repPasswd']) && $_POST['submit'] === 'Inscription') {
				if (!empty($_POST['repPasswd'])){
					$this->repPasswd = htmlentities($_POST['repPasswd']);
				} else if (empty($_POST['repPasswd']) && !empty($_POST['passwd'])){
					$this->login = htmlentities($_POST['login']);
					$this->passwd = htmlentities($_POST['passwd']);
					$this->mess_error = '<p class="form_error">Le champ de verification de 	mot de passe est vide!</p>';
					$this->formOk = 0;
				}
				if (!empty($_POST['repPasswd']) && !empty($_POST['passwd'])){
					if ($_POST['repPasswd'] !== $_POST['passwd']){
						$this->mess_error = '<p class="form_error">Les deux champs de mot de passe ne sont pas identiques!</p>';
						$this->formOk = 0;
					}
				}
			}
			if (isset($_POST['email']) && $_POST['submit'] === 'Inscription') {
				if (!empty($_POST['email'])){
					$this->email = htmlentities($_POST['email']);
					$this->_mailCon = new Mail($this->email, $this->login);
					if ($this->_mailCon->validEmail($this->email) !== TRUE){
						$this->mess_error = '<p class="form_error">Veuillez renseigner une adresse email valide!</p>';
						$this->formOk = 0;
					}
				}else{
					$this->mess_error = '<p class="form_error">Veuillez renseigner votre adresse email!</p>';
					$this->formOk = 0;
				}
			}
		}
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
		$cle = hash('sha256', microtime(TRUE)*100000);

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

				$subject = 'Inscription a CAMAGRU';
				$title = 'Bienvenue sur Camagru !';
				$message = 'Bravo '.ucfirst($this->login).', tu as demander a 
				t\'inscrire sur Camagru et je t\'en remercie. Plus qu\'une seule etape pour demarrer l\'experience!';
				$from = 'insciption@camagru.com';

				$sender = new MailSender($this->email, $this->login, $subject, $title, $message, $from, $cle);
				$sender->confirmSubscribeMail();
//				$sender->newaMail();
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
}
?>