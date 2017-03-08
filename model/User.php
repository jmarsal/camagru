<?php
if (!isset($_SESSION)){
    session_start();
}
class User extends Model {

	public $table = 'users';

	/**
	 * check dans la bdd si le login et le passwd match et envoie vers l'app
	 * si existant.
	 * @param $login string le login a check
	 * @param $passwd string le passwd a check
	 * @return bool|string true si ca match, message d'erreur au contraire
	 */
	public function checkLogin($login, $passwd)
	{
//		cherche dans la DB si un user a ce login et passwd
		$sql = "SELECT COUNT(*) FROM users
							WHERE login=? AND password=?";
		try {
			$query = $this->db->prepare($sql);
			$d = array($login, $passwd);
			$query->execute($d);
			$row = $query->fetch();
			if ($row['COUNT(*)'] == 1) {
				$sql = "SELECT actif FROM users
								WHERE login=?";
				try {
					$query = $this->db->prepare($sql);
					$d = array($login);
					$query->execute($d);
					$row = $query->fetch();
					if ($row[0] == 1) {
						$_SESSION['login'] = $login;
						$_SESSION['loged'] = 1;
                        setcookie('camagru-log', $login, time() + 31556926);
						return (TRUE);
					} else {
						return ("Le compte n'est pas actif!<br/>Clique sur 'Forget Password or Account not 
								Active'<br/>pour obtenir un mail avec un nouveau lien d'activation! ");
					}
				} catch (PDOexception $e) {
					print "Erreur : " . $e->getMessage() . "";
					die();
				}
			} else{
				$sql = "SELECT COUNT(*) FROM users
							WHERE login=?";
				try {
					$query = $this->db->prepare($sql);
					$d = array($login);
					$query->execute($d);
					$row = $query->fetch();
					if ($row['COUNT(*)'] == 1) {
						return ("Wrong Password");
					}else {
						return ('Le Login n\'existe pas !');
					}
				} catch (PDOexception $e) {
						print "Erreur : " . $e->getMessage() . "";
						die();
					}
			}
		} catch (PDOexception $e) {
			print "Erreur : " . $e->getMessage() . "";
			die();
		}
	}


	/**
	 * Enregistre un nouvel user dans la bdd + send mail de confirmation
	 * @param $login string le login user.
	 * @param $email string l'email user.
	 * @param $passwd string le password user (recu en parametre deja hash).
	 * @return bool|string return true si tout c'est bien passe, False pour
	 * le contraire, ou un message d'erreur.
	 */
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

	/**
	 * Envoie un mail au nouvel utilisateur
	 * @param $cle string la cle de verification qui sera placer dans le mail.
	 * @param $email l'email de l'user.
	 * @param $login le login de l'user qui sera placer dans le mail.
	 */
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

	/**
	 * Verifie que le param email est valide, verifie que le user existe,
	 * auquel cas renvoi un array contenant le login et la cle correspondant
	 * a l'email.
	 * Return False si l'user n'existe pas.
	 * Return message d'erreur si l'adresse mail n'est pas valide.
	 * @param $email string l'adresse mail a chercher dans la DB
	 * @return array|bool|string Array contenant login et cle si tout c'est
	 * bien passer, False si l'user n'existe pas et un message d'erreur si le
	 * mail n'est pas valide.
	 */
	public function requestMail($email){
		if (Mail::validEmail($email)){
			$sql = "SELECT email FROM users
							WHERE email=?";
			try{
				$query = $this->db->prepare($sql);
				$d = array($email);
				$query->execute($d);
				$user_exist = $query->rowCount();
				if ($user_exist === 1){
					$options = array();
					$options['login'] = $this->getLoginByEmail($email);
					$options['cle'] = $this->getCleByEmail($email);
				}
			}catch (PDOexception $e){
				print "Erreur : ".$e->getMessage()."";
				die();
			}
			if ($user_exist !== 1){
				return FALSE;
			}
			return $options;
		}
		return "Veuillez renseigner une adresse mail valide";
	}

	/**
	 * Trouve a quel user correspond l'email
	 * @param $email string l'email a rechercher dans la DB
	 * @return mixed return le login qui correspond a l'email
	 */
	public function getLoginByEmail($email){
		try{
			$query = $this->db->prepare("SELECT login FROM users WHERE email=?");
			$d = array($email);
			$query->execute($d);
			$row = $query->fetch();
			return $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	/**
	 * Return la cle user de par son email
	 * @param $email string l'email a chercher dans la bdd
	 * @return mixed return la cle dans la DB
	 */
	public function getCleByEmail($email){
		try{
			$query = $this->db->prepare("SELECT cle FROM users WHERE email=?");
			$d = array($email);
			$query->execute($d);
			$row = $query->fetch();
			return $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	/**
	 * Check si le login et la cle correspondent dans la bdd
	 * @param $login string le nom de l'user a update
	 * @param $cle string la cle a verifier
	 * @return bool return TRUE si trouve dans la DB, FALSE autrement.
	 */
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

	/**
	 * Change la cle user
	 * @param $log string le nom de l'user a mettre actif
	 */
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

	/**
	 * Change l'etat de l'user a actif
	 * @param $log string le nom de l'user a mettre actif
	 */
	public function changeActifUser($log){
		$actif = 1;
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

	/**
	 * Change la cle user
	 * @param $log string le nom de l'user a update
	 * @param $newPasswd string le nouveau password a update
	 */
	public function changePasswdUser($log, $newPasswd){
		$sql = "UPDATE users SET password=? WHERE login=?";
		try{
			$query = $this->db->prepare($sql);
			$d = array($newPasswd, $log);
			$query->execute($d);
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	/**
	 * Check si User a valider son compte
	 * @param $login string le login a check
	 * @return bool true si compte valide, false autrement.
	 */
	public function checkIfUserActif($login){
		$sql = "SELECT actif FROM users WHERE login=?";
		try{
			$query = $this->db->prepare($sql);
			$d = array($login);
			$query->execute($d);
			if (($query->rowCount()) == 1){
				return TRUE;
			}else {
				return FALSE;
			}
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

    /**
     * Recupere id user par le login.
     * @param $login string login user.
     * @return mixed return id user ou die avec erreur.
     */
	public function getIdUser($login){
	    $sql = "SELECT id FROM users WHERE login=?";
	    try{
	        $query = $this->db->prepare($sql);
	        $d = array($login);
	        $query->execute(($d));
            $row = $query->fetch();
            return $row[0];
        } catch (PDOexception $e){
            print "Erreur : ".$e->getMessage()."";
            die();
        }
    }
}

?>