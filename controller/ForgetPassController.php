<?php

/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 3:00 PM
 */

class ForgetPassController extends Controller
{
	public function accueil(){
		$this->render('pages/forgetPass');
		$this->checkLoginMail();
	}

	public function checkLoginMail(){
		if (isset($_POST['login']) && $_POST['submit'] === 'Réinitialiser' && !empty
			($_POST['login'])){
			$check = htmlentities($_POST['login']);
			if (($user_exist = $this->_requestLoginMail($check)) === 1){
				echo "<script>showPopup();</script>";
			}else if ($user_exist === "mail"){
				echo '<p class="form_error">Cette adresse mail ne correspond à aucun
			utilisateur!</p>';
			}else if ($user_exist === 'login'){
				echo '<p class="form_error">Ce login ne correspond à aucun
			utilisateur!</p>';
			}
		} else if (isset($_POST['login']) && $_POST['submit'] === 'Réinitialiser'
			&& empty ($_POST['login'])){
			echo "<p class=\"form_error\">Veuillez renseigner un login ou une adresse mail !</p>";
		}
	}

	private function _requestLoginMail($toCheck){
		if (Mail::validEmail($toCheck)){
			$sql = "SELECT * FROM users
							WHERE email=?";
			$err = "mail";
		}else{
			$sql = "SELECT * FROM users
							WHERE login=?";
			$err = "login";
		}
		$con = new Model;
		try{
			$st = $con->db->prepare($sql);
			$d = array($toCheck);
			$st->execute($d);
			$user_exist = $st->rowCount();
			if ($user_exist === 1 && $err === 'mail'){
				$_SESSION['EmailForgetPass'] = $toCheck;
				$this->_getLoginByEmail($con, $toCheck);
			}else if ($user_exist === 1 && $err === 'login'){
				$_SESSION['UserForgetPass'] = $toCheck;
				$this->_getEmailByLogin($con, $toCheck);
			}
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($user_exist !== 1){
			return $err;
		}
		return $user_exist;
	}

	private function _getLoginByEmail($conBdd, $toCheck){
		try{
			$query = $conBdd->db->prepare("SELECT login FROM users WHERE email=?");
			$d = array($toCheck);
			$query->execute($d);
			$row = $query->fetch();
			$_SESSION['UserForgetPass'] = $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}

	private function _getEmailByLogin($conBdd, $toCheck){
		try{
			$query = $conBdd->db->prepare("SELECT email FROM users WHERE login=?");
			$d = array($toCheck);
			$query->execute($d);
			$row = $query->fetch();
			$_SESSION['EmailForgetPass'] = $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
}