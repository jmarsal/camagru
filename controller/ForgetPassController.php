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

			if (($user_exist  = $this->requestLoginMail($check)) === 1){
				?>
				<script>
					var x;
					if (confirm("Si vous cliquer sur OK, un mail de reinitialisation va vous etre envoyer sur votre adresse email !") == true) {
						x = <?php echo"Un mail viens de vous etre envoyer"; ?>
						}
				</script>
				<?php
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

	private function requestLoginMail($toCheck){
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
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
		if ($user_exist !== 1){
			return $err;
		}
		return $user_exist;
	}
}