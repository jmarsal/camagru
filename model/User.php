<?php
class User extends Model {

	public $table = 'users';

	// check si dans la bdd et envoie vers l'app si existant...
	//	return message d'erreur si probleme
	public function checkLogin($login, $passwd){
		$query = $this->db->query("SELECT COUNT(*) FROM users 
								WHERE login='".$login."' 
								AND password='".$passwd."'")->fetch();
		if ($query['COUNT(*)'] == 1){
			$_SESSION['login'] = $login;
			$_SESSION['loged'] = 1;
			return (TRUE);
		}
		else{
			$query = $this->db->query("SELECT COUNT(*) FROM users 
									WHERE login='".$login."'")->fetch();
			if ($query['COUNT(*)'] == 1){
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
			$query = $this->db->query("SELECT COUNT(*) FROM users
									WHERE login='".$login."'")->fetch();
			if ($query['COUNT(*)'] == 1){
				return $this->mess_error = 'Ce Login est deja utilise !';
			}
			$query = $this->db->query("SELECT COUNT(*) FROM users
									WHERE email='".$email."'")->fetch();
			if ($query['COUNT(*)'] == 1){
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
				$query = $this->db->prepare($sql);
				$d = array($email);
				$query->execute($d);
				$user_exist = $query->rowCount();
				if ($user_exist === 1){
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

//	Check si le login et la cle correspondent dans la bdd
	public function checkValueOfGetForValidation($login, $cle){
		$sql = "SELECT cle FROM users
							WHERE login=?";
		$cle_comp = NULL;

		try{
			$query = $this->db->prepare($sql);
			$d = array($login);
			$query->execute($d);
			$user_exist = $query->rowCount();
			if ($user_exist === 1) {
				$row = $query->fetch();
				$cle_comp = $row[0];
				if ($cle_comp === $cle) {
					return (TRUE);
				} else {
					return FALSE;
				}
			}
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
			}
	}

	//	Change la cle user
	public function changeKeyUser($log){
		$newcle = uniqid('', true);
		$sql = "UPDATE users SET cle=? WHERE login=?";
		try{
			$query = $this->db->prepare($sql);
			$d = array($newcle, $log);
			$query->execute($d);
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	//	Change le ststus user (actif 1 ou 0)
	public function changeActifUser($log){
		$sql = "SELECT actif FROM users WHERE login=?";
		try{
			$query = $this->db->prepare($sql);
			$d = array($log);
			$query->execute($d);
			$row = $query->fetch();
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		$actif = ($row[0] == 1) ? 0 : 1;
		$sql = "UPDATE users SET actif=? WHERE login=?";
		try{
			$query = $this->db->prepare($sql);
			$d = array($actif, $log);
			$query->execute($d);
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

}

?>