<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 2/7/17
 * Time: 3:00 PM
 */
class ForgetPassController extends Controller
{
	public $login;
	public $email;

	public function accueil(){
		$this->render('pages/forgetPass');
		$this->checkLoginMail();
		if (isset($_GET['confirm']) && $_GET['confirm'] === '1'){
			if (!empty($this->email) && !empty($this->login)){
				$options = array('email' => $this->email,
					'login' => $this->login,
					'subject' => '',
					'message' => '',
					'title' => '',
					'from' => '',
					'cle' => '');
				$reinitMail = new MailSender($options);
				$reinitMail->reinitPassMail();
				echo file_get_contents('view/forgetPass/pages/sendMessPop.html');
				?>
				<script>
                    setTimeout(changePage, 2000);
                    function changePage(){
                        document.location.href="<?php echo BASE_URL ?>";
					}
				</script>
				<?php
			}else{
				echo "Probleme pour send le mail...";
			}
		}
	}

	public function checkLoginMail(){
		if (isset($_POST['login']) && $_POST['submit'] === 'Réinitialiser' && !empty
			($_POST['login'])){
			$check = htmlentities($_POST['login']);
			if (($user_exist = $this->_requestLoginMail($check)) === 1){
//				Ne doit afficher la popup que si les champs sont charges...
				if (isset($this->email) && isset($this->login) &&
					!empty($this->email) && !empty($this->login)){
				    $_SESSION['user'] = $this->login;
				    $_SESSION['email'] = $this->email;
					echo "<script>showPopup();</script>";
				}
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
				$this->email = $toCheck;
				$this->_getLoginByEmail($con, $toCheck);
			}else if ($user_exist === 1 && $err === 'login'){
				$this->login = $toCheck;
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
			$this->login = $row[0];
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
			$this->email = $row[0];
		}catch (PDOexception $e){
			print "Erreur : ".$e->getMessage()."";
			die();
		}
	}
}