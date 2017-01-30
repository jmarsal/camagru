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
					if ($this->validEmail($this->email) !== TRUE){
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

	// verifie que l'adresse email est valide
	function validEmail($email){
	$isValid = true;
	$atIndex = strrpos($email, "@");

	if (is_bool($atIndex) && !$atIndex){
		$isValid = false;
	}
	else{
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64){
			// local part length exceeded
			$isValid = false;
		}else if ($domainLen < 1 || $domainLen > 255){
			// domain part length exceeded
			$isValid = false;
		}else if ($local[0] == '.' || $local[$localLen-1] == '.'){
			// local part starts or ends with '.'
			$isValid = false;
		}else if (preg_match('/\\.\\./', $local)){
			// local part has two consecutive dots
			$isValid = false;
		}else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
			// character not valid in domain part
			$isValid = false;
		}else if (preg_match('/\\.\\./', $domain)){
			// domain part has two consecutive dots
			$isValid = false;
		}else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
			// character not valid in local part unless
			// local part is quoted
			if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))){
				$isValid = false;
			}
		}if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
			// domain not found in DNS
			$isValid = false;
		}
	}
	return $isValid;
}


	// Enregistre un nouvel user dans la bdd
	public function addUser($login, $email, $passwd) {
		echo "Enregistre un nouvel user dans la bdd, ouvir accueil.php, register.php, User.php, egalement, voir ce site : http://m-gut.developpez.com/tutoriels/php/mail-confirmation/";
	}
}
?>