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

	// Check dans la table user si le login et le passwd == ce que je recois de
	// $_POST et so ok -> va sur la page Camagru, sinon propose de creer un compte.
	public function __construct() {
		if (isset($_POST['login'])){
			if (isset($_POST['login'], $_POST['passwd']) &&
				!empty($_POST['login']) && !empty($_POST['passwd']) &&
				($_POST['submit'] === 'Login' || $_POST['submit'] === 'Inscription')){
				$this->login = htmlspecialchars($_POST['login']);
				$this->passwd = htmlspecialchars($_POST['passwd']);
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
					$this->repPasswd = htmlspecialchars($_POST['repPasswd']);
				} else if (empty($_POST['repPasswd']) && !empty($_POST['passwd'])){
					$this->login = htmlspecialchars($_POST['login']);
					$this->passwd = htmlspecialchars($_POST['passwd']);
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
					$this->email = htmlspecialchars($_POST['email']);
					if (Mail::validEmail($this->email) !== TRUE){
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
		$cle = hash(sha256, microtime(TRUE)*100000);

		$st = $con->db->query("SELECT COUNT(*) FROM users 
									WHERE login='".$this->login."'")->fetch();
			if ($st['COUNT(*)'] == 1){
				$this->mess_error = '<p class="form_error">Ce Login est deja utilise !</p>';
				return (FALSE);
			}
		$req = $con->db->prepare("INSERT INTO `users`(`login`, `password`, `email`, `cle`) 
									VALUES (:login, :password, :email, :cle)");
		if ($req->execute(array(
            "login" => $login, 
            "password" => $passwd,
            "email" => $email,
			"cle" => $cle))){
				Mail::sendMailConfirmation($email, $login, $cle);
				return (TRUE);
			}else{
				if ($_SERVER['debug'] === 1)
					$this->mess_error = "<p>l'insertion n'a pas marche!</p>";
					return (FALSE);
			}
		// echo "Enregistre un nouvel user dans la bdd, ouvir accueil.php, register.php, User.php, egalement, voir ce site : http://m-gut.developpez.com/tutoriels/php/mail-confirmation/";
	}
}
?>